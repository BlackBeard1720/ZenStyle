<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;

class TrimStaffSeeder extends Seeder
{
    private const TARGETS = [
        'admin' => 1,
        'receptionist' => 2,
        'stylist' => 6,
    ];

    private const PREFERRED_STAFF = [
        'admin' => ['minhpham@gmail.com', 'minhpham'],
        'receptionist' => ['linhvn@gmail.com', 'linhvn'],
        'stylist' => ['huyphg@gmail.com', 'huyphg'],
    ];

    public function run(): void
    {
        if (! app()->environment(['local', 'development', 'testing'])) {
            $this->command?->warn('TrimStaffSeeder skipped: only local/development/testing environments are allowed.');

            return;
        }

        $staffMembers = Staff::query()
            ->with('user.role')
            ->withCount(['attendances', 'payrolls', 'appointmentServices'])
            ->get();

        if ($staffMembers->isEmpty()) {
            $this->command?->warn('TrimStaffSeeder skipped: no staff found.');

            return;
        }

        $selectedStaff = collect();

        foreach (self::TARGETS as $role => $targetCount) {
            $roleStaff = $staffMembers->filter(
                fn (Staff $staff) => $staff->user?->role?->role_name === $role
            );

            $preferred = collect(self::PREFERRED_STAFF[$role] ?? [])
                ->flatMap(fn (string $identifier) => $roleStaff->filter(
                    fn (Staff $staff) => in_array($identifier, [
                        $staff->user?->email,
                        $staff->user?->username,
                    ], true)
                ));

            $ranked = $roleStaff->sort(function (Staff $first, Staff $second) {
                return [
                    $second->appointment_services_count,
                    $second->payrolls_count,
                    $second->attendances_count,
                    -$second->id,
                ] <=> [
                    $first->appointment_services_count,
                    $first->payrolls_count,
                    $first->attendances_count,
                    -$first->id,
                ];
            });

            $selectedStaff = $selectedStaff
                ->merge($preferred)
                ->merge($ranked)
                ->unique('id')
                ->take($selectedStaff->count() + $targetCount);
        }

        $keepIds = $selectedStaff->pluck('id');

        if ($keepIds->count() < array_sum(self::TARGETS)) {
            $fallback = $staffMembers
                ->whereNotIn('id', $keepIds)
                ->sort(function (Staff $first, Staff $second) {
                    return [
                        $second->appointment_services_count,
                        $second->payrolls_count,
                        $second->attendances_count,
                        -$second->id,
                    ] <=> [
                        $first->appointment_services_count,
                        $first->payrolls_count,
                        $first->attendances_count,
                        -$first->id,
                    ];
                })
                ->pluck('id');

            $keepIds = $keepIds
                ->merge($fallback)
                ->unique()
                ->take(array_sum(self::TARGETS));
        }

        Staff::query()
            ->whereIn('id', $keepIds)
            ->update(['status' => 'active']);

        $inactiveCount = Staff::query()
            ->whereNotIn('id', $keepIds)
            ->where('status', 'active')
            ->update(['status' => 'inactive']);

        $this->command?->info("TrimStaffSeeder completed: {$keepIds->count()} staff kept active, {$inactiveCount} staff marked inactive.");
    }
}
