<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Staff;
use App\Models\StaffSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $staff = Staff::where('status', 'active')
            ->orderBy('full_name')
            ->get();

        $attendances = Attendance::with('staff')
            ->when($request->staff_id, function ($query, $staffId) {
                $query->where('staff_id', $staffId);
            })
            ->when($request->work_date, function ($query, $date) {
                $query->whereDate('work_date', $date);
            })
            ->orderByDesc('work_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('staff.attendance.index', compact('staff', 'attendances'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'work_date' => ['required', 'date'],
            'check_in_time' => ['nullable', 'date_format:H:i'],
            'check_out_time' => ['nullable', 'date_format:H:i'],
            'status' => ['nullable', Rule::in(['present', 'late', 'absent', 'leave'])],
        ]);

        $checkIn = $this->buildDateTime($data['work_date'], $data['check_in_time'] ?? null);
        $checkOut = $this->buildDateTime($data['work_date'], $data['check_out_time'] ?? null);

        if ($checkIn && $checkOut && Carbon::parse($checkOut)->lessThanOrEqualTo(Carbon::parse($checkIn))) {
            return back()
                ->withInput()
                ->withErrors(['check_out_time' => 'check in first']);
        }

        $status = $data['status'] ?? $this->detectStatus([
            'staff_id' => $data['staff_id'],
            'work_date' => $data['work_date'],
            'check_in' => $checkIn,
        ]);

        Attendance::updateOrCreate(
            [
                'staff_id' => $data['staff_id'],
                'work_date' => $data['work_date'],
            ],
            [
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => $status,
            ]
        );

        return back()->with('success', 'successfull saved');
    }

    public function update(Request $request, Attendance $attendance)
    {
        $data = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'work_date' => ['required', 'date'],
            'check_in_time' => ['nullable', 'date_format:H:i'],
            'check_out_time' => ['nullable', 'date_format:H:i'],
            'status' => ['required', Rule::in(['present', 'late', 'absent', 'leave'])],
        ]);

        $checkIn = $this->buildDateTime($data['work_date'], $data['check_in_time'] ?? null);
        $checkOut = $this->buildDateTime($data['work_date'], $data['check_out_time'] ?? null);

        if ($checkIn && $checkOut && Carbon::parse($checkOut)->lessThanOrEqualTo(Carbon::parse($checkIn))) {
            return back()
                ->withInput()
                ->withErrors(['check_out_time' => 'Check in first.']);
        }

        $attendance->update([
            'staff_id' => $data['staff_id'],
            'work_date' => $data['work_date'],
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'status' => $data['status'],
        ]);

        return back()->with('success', 'successfull updated');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return back()->with('success', 'successfull deleted');
    }

    private function buildDateTime(string $date, ?string $time): ?string
    {
        if (empty($time)) {
            return null;
        }

        return $date . ' ' . $time . ':00';
    }

    private function detectStatus(array $data): string
    {
        if (empty($data['check_in'])) {
            return Attendance::STATUS_ABSENT;
        }

        $schedule = StaffSchedule::query()
            ->where('staff_id', $data['staff_id'])
            ->whereDate('work_date', $data['work_date'])
            ->where('status', 'scheduled')
            ->first();

        if (!$schedule || !$schedule->start_time) {
            return Attendance::STATUS_PRESENT;
        }

        $checkIn = Carbon::parse($data['check_in']);
        $scheduleStart = Carbon::parse($data['work_date'] . ' ' . $schedule->start_time);

        return $checkIn->greaterThan($scheduleStart)
            ? Attendance::STATUS_LATE
            : Attendance::STATUS_PRESENT;
    }
}
