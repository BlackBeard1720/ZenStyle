<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('appointment_service')->delete();
        DB::table('appointments')->delete();

        $clients = Client::all();
        $staff = Staff::where('status', 'active')->get();
        $services = Service::where('status', 'active')->get();

        if ($clients->isEmpty() || $staff->isEmpty() || $services->isEmpty()) {
            throw new RuntimeException('AppointmentSeeder requires clients, active staff, and active services. Run ClientSeeder, StaffSeeder, and ServiceSeeder first.');
        }

        for ($i = 0; $i < 200; $i++) {
            Appointment::factory()
                ->withServices($services, $staff)
                ->create(['client_id' => $clients->random()->id]);
        }
    }
}
