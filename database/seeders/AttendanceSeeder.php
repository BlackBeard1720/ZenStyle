<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\StaffSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Attendance::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $schedules = StaffSchedule::query()
            ->whereDate('work_date', '<=', now()->toDateString())
            ->orderBy('work_date')
            ->get();

        foreach ($schedules as $schedule) {
            $workDate = Carbon::parse($schedule->work_date)->toDateString();

            if ($schedule->status === 'off') {
                Attendance::create([
                    'staff_id' => $schedule->staff_id,
                    'work_date' => $workDate,
                    'check_in' => null,
                    'check_out' => null,
                    'status' => Attendance::STATUS_LEAVE,
                ]);

                continue;
            }

            if ($schedule->status === 'leave') {
                Attendance::create([
                    'staff_id' => $schedule->staff_id,
                    'work_date' => $workDate,
                    'check_in' => null,
                    'check_out' => null,
                    'status' => Attendance::STATUS_LEAVE,
                ]);

                continue;
            }

            if (
                $schedule->status !== 'scheduled' ||
                empty($schedule->start_time) ||
                empty($schedule->end_time)
            ) {
                continue;
            }

            $start = Carbon::parse($workDate . ' ' . $schedule->start_time);
            $end = Carbon::parse($workDate . ' ' . $schedule->end_time);

            $rand = rand(1, 100);

            if ($rand <= 10) {
                Attendance::create([
                    'staff_id' => $schedule->staff_id,
                    'work_date' => $workDate,
                    'check_in' => null,
                    'check_out' => null,
                    'status' => Attendance::STATUS_ABSENT,
                ]);

                continue;
            }

            if ($rand <= 35) {
                Attendance::create([
                    'staff_id' => $schedule->staff_id,
                    'work_date' => $workDate,
                    'check_in' => $start->copy()->addMinutes(rand(10, 45)),
                    'check_out' => $end->copy()->subMinutes(rand(0, 10)),
                    'status' => Attendance::STATUS_LATE,
                ]);

                continue;
            }

            Attendance::create([
                'staff_id' => $schedule->staff_id,
                'work_date' => $workDate,
                'check_in' => $start->copy()->addMinutes(rand(0, 5)),
                'check_out' => $end->copy()->subMinutes(rand(0, 10)),
                'status' => Attendance::STATUS_PRESENT,
            ]);
        }
    }
}
