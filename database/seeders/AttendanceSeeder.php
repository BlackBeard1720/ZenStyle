<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $staffMembers = Staff::query()
            ->where('status', 'active')
            ->orderBy('id')
            ->get();

        if ($staffMembers->isEmpty()) {
            $this->command?->warn('AttendanceSeeder skipped: no active staff found. Run StaffSeeder first.');

            return;
        }

        $templates = [
            [
                'status' => Attendance::STATUS_PRESENT,
                'check_in' => '08:00',
                'check_out' => '17:00',
                'working_hours' => 8,
                'note' => 'On time',
            ],
            [
                'status' => Attendance::STATUS_LATE,
                'check_in' => '09:00',
                'check_out' => '17:00',
                'working_hours' => 7,
                'note' => 'Late arrival',
            ],
            [
                'status' => Attendance::STATUS_ABSENT,
                'check_in' => null,
                'check_out' => null,
                'working_hours' => 0,
                'note' => 'Absent',
            ],
            [
                'status' => Attendance::STATUS_LEAVE,
                'check_in' => null,
                'check_out' => null,
                'working_hours' => 0,
                'note' => 'Approved leave',
            ],
        ];

        $monthStart = now()->startOfMonth();
        $daysInMonth = $monthStart->daysInMonth;
        $created = 0;
        $updated = 0;

        $staffMembers->each(function (Staff $staff, int $staffIndex) use ($templates, $monthStart, $daysInMonth, &$created, &$updated) {
            for ($i = 0; $i < 8; $i++) {
                $template = $templates[$i % count($templates)];
                $workDate = $monthStart->copy()
                    ->addDays(($staffIndex * 2 + $i * 3) % $daysInMonth)
                    ->toDateString();

                $attendance = Attendance::updateOrCreate(
                    [
                        'staff_id' => $staff->id,
                        'work_date' => $workDate,
                    ],
                    [
                        'check_in' => $template['check_in'],
                        'check_out' => $template['check_out'],
                        'working_hours' => $template['working_hours'],
                        'overtime_hours' => $template['status'] === Attendance::STATUS_PRESENT && ($staffIndex + $i) % 3 === 0 ? 1 : 0,
                        'status' => $template['status'],
                        'note' => $template['note'],
                    ]
                );

                if ($attendance->wasRecentlyCreated) {
                    $created++;
                } else {
                    $updated++;
                }
            }
        });

        $this->command?->info("AttendanceSeeder completed: {$created} created, {$updated} updated.");
    }
}
