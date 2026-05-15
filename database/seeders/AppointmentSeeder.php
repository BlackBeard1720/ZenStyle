<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Client;
use App\Models\Role;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('appointment_service')->delete();
        DB::table('appointments')->delete();

        $clientRole = Role::firstOrCreate(['role_name' => 'client']);
        $staffRole = Role::firstOrCreate(['role_name' => 'stylist']);

        if (Client::count() === 0) {
            User::factory(8)->create(['role_id' => $clientRole->id, 'status' => 'active'])
                ->each(function (User $user) {
                    Client::create([
                        'user_id' => $user->id,
                        'full_name' => $user->username,
                        'phone' => $user->phone ?: fake()->numerify('09########'),
                        'email' => $user->email,
                        'status' => 'active',
                    ]);
                });
        }

        if (Staff::count() === 0) {
            User::factory(5)->create(['role_id' => $staffRole->id, 'status' => 'active'])
                ->each(function (User $user) {
                    Staff::create([
                        'user_id' => $user->id,
                        'full_name' => $user->username,
                        'phone' => $user->phone,
                        'email' => $user->email,
                        'specialization' => fake()->randomElement(['Hair stylist', 'Skin care', 'Nail care']),
                        'hire_date' => now()->subMonths(fake()->numberBetween(1, 24)),
                        'status' => 'active',
                    ]);
                });
        }

        if (Service::count() === 0) {
            Service::insert([
                ['service_name' => 'Hair Cut', 'description' => 'Basic salon haircut.', 'price' => 150000, 'duration_minutes' => 45, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
                ['service_name' => 'Hair Wash', 'description' => 'Wash and scalp massage.', 'price' => 120000, 'duration_minutes' => 30, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
                ['service_name' => 'Hair Coloring', 'description' => 'Basic coloring service.', 'price' => 650000, 'duration_minutes' => 120, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
                ['service_name' => 'Hair Treatment', 'description' => 'Recovery treatment.', 'price' => 320000, 'duration_minutes' => 60, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
                ['service_name' => 'Skin Care', 'description' => 'Facial skin care.', 'price' => 400000, 'duration_minutes' => 75, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        $clients = Client::where('status', 'active')->get();
        $staff = Staff::where('status', 'active')->get();
        $services = Service::whereIn('status', ['active', 'available'])->get();
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];

        for ($i = 0; $i < 28; $i++) {
            $selectedServices = $services->random(fake()->numberBetween(1, min(3, $services->count())));
            $startTime = Carbon::createFromTime(fake()->numberBetween(8, 17), fake()->randomElement([0, 30]));

            $appointment = Appointment::factory()->create([
                'client_id' => $clients->random()->id,
                'appointment_time' => $startTime->format('H:i:s'),
                'status' => $statuses[$i % count($statuses)],
                'total_amount' => $selectedServices->sum('price'),
            ]);

            foreach ($selectedServices as $service) {
                AppointmentService::create([
                    'appointment_id' => $appointment->id,
                    'service_id' => $service->id,
                    'staff_id' => $staff->random()->id,
                    'price_at_booking' => $service->price,
                ]);
            }
        }
    }
}
