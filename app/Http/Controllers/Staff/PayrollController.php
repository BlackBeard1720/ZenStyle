<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PayrollController extends Controller
{
    private const DEFAULT_STANDARD_WORK_DAYS = 26;

    public function index(Request $request)
    {
        Gate::authorize('view-payroll');

        $filters = $this->monthYear($request);
        $month = $filters['month'];
        $year = $filters['year'];

        $payrolls = Payroll::query()
            ->with('staff')
            ->whereHas('staff', fn ($query) => $query->where('status', 'active'))
            ->where('month', $month)
            ->where('year', $year)
            ->orderBy('staff_id')
            ->paginate(15)
            ->withQueryString();

        return view('staff.payroll.index', [
            'payrolls' => $payrolls,
            'month' => $month,
            'year' => $year,
        ]);
    }

    public function generate(Request $request)
    {
        Gate::authorize('manage-payroll');

        $filters = $this->monthYear($request, required: true);
        $month = $filters['month'];
        $year = $filters['year'];

        $staffMembers = Staff::query()
            ->where('status', 'active')
            ->orderBy('full_name')
            ->get();

        if ($staffMembers->isEmpty()) {
            return to_route('staff.payroll.index', compact('month', 'year'))
                ->withErrors(['staff' => 'No active staff found to generate payroll.']);
        }

        $count = 0;

        foreach ($staffMembers as $staff) {
            $existingPayroll = Payroll::query()
                ->where('staff_id', $staff->id)
                ->where('month', $month)
                ->where('year', $year)
                ->first();

            $standardWorkDays = max(1, (int) ($existingPayroll?->standard_work_days ?: self::DEFAULT_STANDARD_WORK_DAYS));
            $actualWorkDays = $this->actualWorkDays($staff, $month, $year);
            $baseSalary = (float) ($staff->salary ?? 0);
            $bonus = (float) ($existingPayroll?->bonus ?? 0);
            $deduction = (float) ($existingPayroll?->deduction ?? 0);

            Payroll::updateOrCreate(
                [
                    'staff_id' => $staff->id,
                    'month' => $month,
                    'year' => $year,
                ],
                [
                    'standard_work_days' => $standardWorkDays,
                    'actual_work_days' => $actualWorkDays,
                    'base_salary' => $baseSalary,
                    'bonus' => $bonus,
                    'deduction' => $deduction,
                    'net_salary' => $this->netSalary($baseSalary, $standardWorkDays, $actualWorkDays, $bonus, $deduction),
                    'status' => $existingPayroll?->status ?? Payroll::STATUS_DRAFT,
                ]
            );

            $count++;
        }

        return to_route('staff.payroll.index', compact('month', 'year'))
            ->with('success', "Payroll generated for {$count} active staff.");
    }

    public function update(Request $request, Payroll $payroll)
    {
        Gate::authorize('manage-payroll');

        $data = $request->validate([
            'standard_work_days' => ['required', 'integer', 'min:1'],
            'bonus' => ['required', 'numeric', 'min:0'],
            'deduction' => ['required', 'numeric', 'min:0'],
            'status' => ['sometimes', Rule::in(Payroll::STATUSES)],
        ]);

        $standardWorkDays = (int) $data['standard_work_days'];
        $bonus = (float) $data['bonus'];
        $deduction = (float) $data['deduction'];
        $baseSalary = (float) $payroll->base_salary;
        $actualWorkDays = (int) $payroll->actual_work_days;

        $payroll->update([
            'standard_work_days' => $standardWorkDays,
            'bonus' => $bonus,
            'deduction' => $deduction,
            'net_salary' => $this->netSalary($baseSalary, $standardWorkDays, $actualWorkDays, $bonus, $deduction),
            'status' => $data['status'] ?? $payroll->status,
        ]);

        return $this->redirectToPayroll($payroll)
            ->with('success', 'Payroll updated successfully.');
    }

    public function confirm(Payroll $payroll)
    {
        Gate::authorize('manage-payroll');

        $payroll->update(['status' => Payroll::STATUS_CONFIRMED]);

        return $this->redirectToPayroll($payroll)
            ->with('success', 'Payroll confirmed successfully.');
    }

    public function markAsPaid(Payroll $payroll)
    {
        Gate::authorize('manage-payroll');

        $payroll->update(['status' => Payroll::STATUS_PAID]);

        return $this->redirectToPayroll($payroll)
            ->with('success', 'Payroll marked as paid successfully.');
    }

    private function monthYear(Request $request, bool $required = false): array
    {
        $data = $request->validate([
            'month' => [$required ? 'required' : 'nullable', 'integer', 'min:1', 'max:12'],
            'year' => [$required ? 'required' : 'nullable', 'integer', 'min:2000', 'max:2100'],
        ]);

        return [
            'month' => (int) ($data['month'] ?? now()->month),
            'year' => (int) ($data['year'] ?? now()->year),
        ];
    }

    private function actualWorkDays(Staff $staff, int $month, int $year): int
    {
        return Attendance::query()
            ->where('staff_id', $staff->id)
            ->whereMonth('work_date', $month)
            ->whereYear('work_date', $year)
            ->whereIn('status', [
                Attendance::STATUS_PRESENT,
                Attendance::STATUS_LATE,
            ])
            ->count();
    }

    private function netSalary(float $baseSalary, int $standardWorkDays, int $actualWorkDays, float $bonus, float $deduction): float
    {
        return round(($baseSalary / $standardWorkDays) * $actualWorkDays + $bonus - $deduction, 2);
    }

    private function redirectToPayroll(Payroll $payroll)
    {
        return to_route('staff.payroll.index', [
            'month' => $payroll->month,
            'year' => $payroll->year,
        ]);
    }
}
