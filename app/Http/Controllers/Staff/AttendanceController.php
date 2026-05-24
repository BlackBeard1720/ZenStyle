<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Staff;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('staff.attendance.calendar', [
            'staff' => Staff::where('status', 'active')
                ->orderBy('full_name')
                ->get(),
        ]);
    }

    public function events(Request $request): JsonResponse
    {
        $data = $request->validate([
            'start' => ['nullable', 'date'],
            'end' => ['nullable', 'date'],
        ]);

        $start = $data['start'] ?? now()->startOfMonth()->toDateString();
        $end = $data['end'] ?? now()->endOfMonth()->addDay()->toDateString();

        $events = Attendance::query()
            ->with('staff')
            ->whereHas('staff', fn ($query) => $query->where('status', 'active'))
            ->whereDate('work_date', '>=', $start)
            ->whereDate('work_date', '<', $end)
            ->orderBy('work_date')
            ->orderBy('staff_id')
            ->get()
            ->map(fn (Attendance $attendance) => $this->toCalendarEvent($attendance))
            ->values();

        return response()->json($events);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        $attendance = Attendance::updateOrCreate(
            [
                'staff_id' => $data['staff_id'],
                'work_date' => $data['work_date'],
            ],
            $this->payload($data)
        )->load('staff');

        return response()->json([
            'message' => 'Attendance saved successfully.',
            'event' => $this->toCalendarEvent($attendance),
        ]);
    }

    public function update(Request $request, Attendance $attendance): JsonResponse
    {
        $data = $request->validate($this->rules());

        $duplicateExists = Attendance::query()
            ->where('staff_id', $data['staff_id'])
            ->whereDate('work_date', $data['work_date'])
            ->whereKeyNot($attendance->id)
            ->exists();

        if ($duplicateExists) {
            return response()->json([
                'message' => 'Attendance already exists for this staff and date.',
                'errors' => [
                    'work_date' => ['Attendance already exists for this staff and date.'],
                ],
            ], 422);
        }

        $attendance->update([
            'staff_id' => $data['staff_id'],
            'work_date' => $data['work_date'],
            ...$this->payload($data),
        ]);

        $attendance->load('staff');

        return response()->json([
            'message' => 'Attendance updated successfully.',
            'event' => $this->toCalendarEvent($attendance),
        ]);
    }

    private function rules(): array
    {
        return [
            'staff_id' => [
                'required',
                Rule::exists('staff', 'id')->where(fn ($query) => $query->where('status', 'active')),
            ],
            'work_date' => ['required', 'date'],
            'status' => ['required', Rule::in(Attendance::STATUSES)],
            'check_in' => ['nullable', 'date_format:H:i'],
            'check_out' => ['nullable', 'date_format:H:i', 'after:check_in'],
            'working_hours' => ['nullable', 'numeric', 'min:0', 'max:24'],
            'overtime_hours' => ['nullable', 'numeric', 'min:0', 'max:24'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    private function payload(array $data): array
    {
        $status = $data['status'];
        $isAbsentLike = in_array($status, [Attendance::STATUS_ABSENT, Attendance::STATUS_LEAVE], true);

        return [
            'check_in' => $isAbsentLike ? null : ($data['check_in'] ?? null),
            'check_out' => $isAbsentLike ? null : ($data['check_out'] ?? null),
            'working_hours' => $isAbsentLike
                ? 0
                : ($data['working_hours'] ?? $this->calculateWorkingHours($data['check_in'] ?? null, $data['check_out'] ?? null)),
            'overtime_hours' => $isAbsentLike ? 0 : ($data['overtime_hours'] ?? 0),
            'status' => $status,
            'note' => $data['note'] ?? null,
        ];
    }

    private function calculateWorkingHours(?string $checkIn, ?string $checkOut): ?float
    {
        if (! $checkIn || ! $checkOut) {
            return null;
        }

        $start = Carbon::createFromFormat('H:i', $checkIn);
        $end = Carbon::createFromFormat('H:i', $checkOut);

        if ($end->lessThanOrEqualTo($start)) {
            return null;
        }

        return round($start->diffInMinutes($end) / 60, 2);
    }

    private function toCalendarEvent(Attendance $attendance): array
    {
        $staffName = $attendance->staff?->full_name ?? 'Staff #' . $attendance->staff_id;
        $statusLabel = $this->statusLabels()[$attendance->status] ?? ucfirst($attendance->status);

        return [
            'id' => (string) $attendance->id,
            'title' => "{$staffName} - {$statusLabel}",
            'start' => $attendance->work_date->toDateString(),
            'allDay' => true,
            'extendedProps' => [
                'attendance_id' => $attendance->id,
                'staff_id' => $attendance->staff_id,
                'staff_name' => $staffName,
                'status' => $attendance->status,
                'status_label' => $statusLabel,
                'calendar' => $this->statusCalendars()[$attendance->status] ?? 'Primary',
                'check_in' => $this->formatTime($attendance->check_in),
                'check_out' => $this->formatTime($attendance->check_out),
                'working_hours' => $attendance->working_hours,
                'overtime_hours' => $attendance->overtime_hours,
                'note' => $attendance->note,
            ],
        ];
    }

    private function statusLabels(): array
    {
        return [
            Attendance::STATUS_PRESENT => 'Present',
            Attendance::STATUS_LATE => 'Late',
            Attendance::STATUS_ABSENT => 'Absent',
            Attendance::STATUS_LEAVE => 'Leave',
        ];
    }

    private function statusCalendars(): array
    {
        return [
            Attendance::STATUS_PRESENT => 'Success',
            Attendance::STATUS_LATE => 'Warning',
            Attendance::STATUS_ABSENT => 'Danger',
            Attendance::STATUS_LEAVE => 'Primary',
        ];
    }

    private function formatTime(mixed $value): ?string
    {
        if (! $value) {
            return null;
        }

        if ($value instanceof CarbonInterface) {
            return $value->format('H:i');
        }

        return Carbon::parse($value)->format('H:i');
    }
}
