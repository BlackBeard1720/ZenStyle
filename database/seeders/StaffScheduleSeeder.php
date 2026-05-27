<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffScheduleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        StaffSchedule::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $staffList = Staff::where('status', 'active')->get();

        if ($staffList->isEmpty()) {
            return;
        }

        $startDate = Carbon::now()->startOfMonth();

        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i);

            foreach ($staffList as $staff) {
                if ($date->isSunday()) {
                    StaffSchedule::create([
                        'staff_id' => $staff->id,
                        'work_date' => $date->toDateString(),
                        'status' => 'off',
                        'note' => 'Day off',
                    ]);

                    continue;
                }

                $specialization = strtolower($staff->specialization ?? '');

                if (str_contains($specialization, 'receptionist')) {
                    StaffSchedule::create([
                        'staff_id' => $staff->id,
                        'work_date' => $date->toDateString(),
                        'start_time' => '08:00',
                        'end_time' => '17:00',
                        'status' => 'scheduled',
                        'note' => 'Reception shift',
                    ]);

                    continue;
                }

                if (str_contains($specialization, 'manager')) {
                    StaffSchedule::create([
                        'staff_id' => $staff->id,
                        'work_date' => $date->toDateString(),
                        'start_time' => '09:00',
                        'end_time' => '18:00',
                        'status' => 'scheduled',
                        'note' => 'Manager shift',
                    ]);

                    continue;
                }

                $isMorningShift = $staff->id % 2 === 0;

                StaffSchedule::create([
                    'staff_id' => $staff->id,
                    'work_date' => $date->toDateString(),
                    'start_time' => $isMorningShift ? '08:00' : '13:00',
                    'end_time' => $isMorningShift ? '17:00' : '21:00',
                    'status' => 'scheduled',
                    'note' => $isMorningShift ? 'Morning shift' : 'Afternoon shift',
                ]);
            }
        }
    }
}
