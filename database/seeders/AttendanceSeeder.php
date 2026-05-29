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

        $schedules = StaffSchedule::all();

        foreach ($schedules as $schedule) {

            if ($schedule->status !== 'scheduled') {

                Attendance::create([
                    'staff_id' => $schedule->staff_id,
                    'work_date' => $schedule->work_date,
                    'status' => 'leave',
                ]);

                continue;
            }

            $start = Carbon::parse(
                $schedule->work_date->format('Y-m-d')
                .' '.$schedule->start_time
            );

            $end = Carbon::parse(
                $schedule->work_date->format('Y-m-d')
                .' '.$schedule->end_time
            );

            $rand = rand(1, 100);

            // absent
            if ($rand <= 10) {

                Attendance::create([
                    'staff_id' => $schedule->staff_id,
                    'work_date' => $schedule->work_date,
                    'status' => 'absent',
                ]);

                continue;
            }

            // late
            if ($rand <= 35) {

                Attendance::create([
                    'staff_id' => $schedule->staff_id,
                    'work_date' => $schedule->work_date,
                    'check_in' => $start->copy()->addMinutes(rand(10, 45)),
                    'check_out' => $end,
                    'status' => 'late',
                ]);

                continue;
            }

            // present
            Attendance::create([
                'staff_id' => $schedule->staff_id,
                'work_date' => $schedule->work_date,
                'check_in' => $start->copy()->addMinutes(rand(0, 5)),
                'check_out' => $end->copy()->subMinutes(rand(0, 10)),
                'status' => 'present',
            ]);
        }
    }
}
