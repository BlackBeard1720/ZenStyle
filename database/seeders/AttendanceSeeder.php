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

        $schedules = StaffSchedule::where('work_date', '<=', now()->toDateString())
            ->get();

        foreach ($schedules as $schedule) {
            if ($schedule->status === 'off' || $schedule->status === 'leave') {
                Attendance::create([
                    'staff_id' => $schedule->staff_id,
                    'work_date' => $schedule->work_date->toDateString(),
                    'check_in' => null,
                    'check_out' => null,
                    'status' => 'leave',
                ]);

                continue;
            }

            $random = rand(1, 100);

            // 10% vắng
            if ($random <= 10) {
                Attendance::create([
                    'staff_id' => $schedule->staff_id,
                    'work_date' => $schedule->work_date->toDateString(),
                    'check_in' => null,
                    'check_out' => null,
                    'status' => 'absent',
                ]);

                continue;
            }

            $workDate = Carbon::parse($schedule->work_date);
            $start = Carbon::parse($workDate->format('Y-m-d') . ' ' . $schedule->start_time);
            $end = Carbon::parse($workDate->format('Y-m-d') . ' ' . $schedule->end_time);

            // 25% đi muộn
            if ($random <= 35) {
                $checkIn = $start->copy()->addMinutes(rand(10, 45));
                $status = 'late';
            } else {
                $checkIn = $start->copy()->addMinutes(rand(0, 5));
                $status = 'present';
            }

            $checkOut = $end->copy()->subMinutes(rand(0, 10));

            Attendance::create([
                'staff_id' => $schedule->staff_id,
                'work_date' => $workDate->toDateString(),
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => $status,
            ]);
        }
    }
}
