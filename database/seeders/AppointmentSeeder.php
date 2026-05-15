<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('appointment_service')->delete();
        DB::table('appointments')->delete();

        $clients = Client::where('status', 'active')->get();
        $staff = Staff::where('status', 'active')->get();
        $services = Service::where('status', 'active')->get();

        if ($clients->isEmpty() || $staff->isEmpty() || $services->isEmpty()) {
            throw new RuntimeException('AppointmentSeeder requires active clients, staff, and services. Run ClientSeeder, StaffSeeder, and ServiceSeeder first.');
        }

        for ($i = 0; $i < 28; $i++) {
            $selectedServices = $services->random(fake()->numberBetween(1, min(3, $services->count())));
            $appointmentTime = Carbon::createFromTime(
                fake()->numberBetween(8, 17),
                fake()->randomElement([0, 30])
            )->format('H:i:s');

            $appointment = Appointment::factory()->create([
                'client_id' => $clients->random()->id,
                'appointment_time' => $appointmentTime,
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
