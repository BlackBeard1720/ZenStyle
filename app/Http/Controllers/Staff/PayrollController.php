<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AppointmentService;
use App\Models\Payroll;
use App\Models\Staff;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    private float $commissionRate = 0.10; // 10%

    public function index(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $payrolls = Payroll::with('staff')
            ->where('month', $month)
            ->where('year', $year)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff.payrolls.index', compact(
            'payrolls',
            'month',
            'year'
        ));
    }

    public function generate(Request $request)
    {
        $data = $request->validate([
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'integer', 'min:2020'],
        ]);

        $staffList = Staff::where('status', 'active')->get();

        foreach ($staffList as $staff) {
            $baseSalary = $staff->salary ?? 0;

            // Tổng tiền dịch vụ mà nhân viên đã làm trong tháng
            // Chỉ tính appointment đã completed
            $serviceRevenue = AppointmentService::query()
                ->where('staff_id', $staff->id)
                ->whereHas('appointment', function ($query) use ($data) {
                    $query->whereMonth('appointment_date', $data['month'])
                        ->whereYear('appointment_date', $data['year'])
                        ->where('status', 'completed');
                })
                ->sum('price_at_booking');

            $commission = round($serviceRevenue * $this->commissionRate, 2);

            $totalSalary = $baseSalary + $commission;

            Payroll::updateOrCreate(
                [
                    'staff_id' => $staff->id,
                    'month' => $data['month'],
                    'year' => $data['year'],
                ],
                [
                    'base_salary' => $baseSalary,
                    'commission' => $commission,
                    'total_salary' => $totalSalary,
                    'status' => 'draft',
                ]
            );
        }

        return back()->with('success', 'Payroll generated successfully.');
    }

    public function confirm(Payroll $payroll)
    {
        $payroll->update([
            'status' => 'confirmed',
        ]);

        return back()->with('success', 'Payroll confirmed.');
    }

    public function markAsPaid(Payroll $payroll)
    {
        $payroll->update([
            'status' => 'paid',
        ]);

        return back()->with('success', 'Payroll marked as paid.');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return back()->with('success', 'Payroll deleted.');
    }
}
