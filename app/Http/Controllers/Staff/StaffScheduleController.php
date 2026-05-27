<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffScheduleController extends Controller
{
    public function index(Request $request)
    {
        $staff = Staff::where('status', 'active')
            ->orderBy('full_name')
            ->get();

        $schedules = StaffSchedule::with('staff')
            ->when($request->staff_id, function ($query, $staffId) {
                $query->where('staff_id', $staffId);
            })
            ->when($request->work_date, function ($query, $date) {
                $query->whereDate('work_date', $date);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff.staff_schedules.index', compact('staff', 'schedules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'work_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'status' => ['required', Rule::in(['scheduled', 'off', 'leave'])],
            'note' => ['nullable', 'string'],
        ]);

        if ($data['status'] === 'scheduled' && (empty($data['start_time']) || empty($data['end_time']))) {
            return back()
                ->withInput()
                ->withErrors(['start_time' => 'Ca làm cần có giờ bắt đầu và giờ kết thúc.']);
        }

        if (in_array($data['status'], ['off', 'leave'])) {
            $data['start_time'] = null;
            $data['end_time'] = null;
        }

        StaffSchedule::updateOrCreate(
            [
                'staff_id' => $data['staff_id'],
                'work_date' => $data['work_date'],
            ],
            $data
        );

        return back()->with('success', 'Lưu lịch làm việc thành công.');
    }

    public function update(Request $request, StaffSchedule $staffSchedule)
    {
        $data = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'work_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'status' => ['required', Rule::in(['scheduled', 'off', 'leave'])],
            'note' => ['nullable', 'string'],
        ]);

        if ($data['status'] === 'scheduled' && (empty($data['start_time']) || empty($data['end_time']))) {
            return back()
                ->withInput()
                ->withErrors(['start_time' => 'Ca làm cần có giờ bắt đầu và giờ kết thúc.']);
        }

        if (in_array($data['status'], ['off', 'leave'])) {
            $data['start_time'] = null;
            $data['end_time'] = null;
        }

        $staffSchedule->update($data);

        return back()->with('success', 'Cập nhật lịch làm việc thành công.');
    }

    public function destroy(StaffSchedule $staffSchedule)
    {
        $staffSchedule->delete();

        return back()->with('success', 'Xóa lịch làm việc thành công.');
    }
}
