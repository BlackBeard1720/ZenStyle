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
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff.attendance.index', compact('staff', 'attendances'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'work_date' => ['required', 'date'],
            'check_in' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'check_out' => ['nullable', 'date_format:Y-m-d\TH:i', 'after:check_in'],
            'status' => ['nullable', Rule::in(['present', 'late', 'absent', 'leave'])],
        ]);

        $data['status'] = $data['status'] ?? $this->detectStatus($data);

        Attendance::updateOrCreate(
            [
                'staff_id' => $data['staff_id'],
                'work_date' => $data['work_date'],
            ],
            $data
        );

        return back()->with('success', 'Lưu chấm công thành công.');
    }

    public function update(Request $request, Attendance $attendance)
    {
        $data = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'work_date' => ['required', 'date'],
            'check_in' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'check_out' => ['nullable', 'date_format:Y-m-d\TH:i', 'after:check_in'],
            'status' => ['required', Rule::in(['present', 'late', 'absent', 'leave'])],
        ]);

        $attendance->update($data);

        return back()->with('success', 'Cập nhật chấm công thành công.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return back()->with('success', 'Xóa chấm công thành công.');
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
