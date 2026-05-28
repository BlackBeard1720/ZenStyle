<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminderMail;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';

    protected $description = 'Send reminder emails for confirmed appointments in the next hour';

    public function handle(): int
    {
        $now = Carbon::now();
        $windowEnd = $now->copy()->addHour();
        $candidateDates = [$now->toDateString(), $windowEnd->toDateString()];

        $appointments = Appointment::query()
            ->where('status', 'confirmed')
            ->whereNull('reminder_sent_at')
            ->whereIn('appointment_date', array_unique($candidateDates))
            ->whereHas('client', function ($query): void {
                $query->whereNotNull('email')->where('email', '!=', '');
            })
            ->whereDoesntHave('payments', function ($query): void {
                $query->where('status', 'paid');
            })
            ->with(['client', 'appointmentServices.service', 'appointmentServices.staff'])
            ->get();

        $appointmentsInWindow = $appointments->filter(function (Appointment $appointment) use ($now, $windowEnd): bool {
            if (empty($appointment->appointment_date) || empty($appointment->appointment_time)) {
                return false;
            }

            $appointmentAt = Carbon::parse($appointment->appointment_date->format('Y-m-d').' '.$appointment->appointment_time);

            return $appointmentAt->betweenIncluded($now, $windowEnd);
        })->values();

        $foundCount = $appointmentsInWindow->count();
        $sentCount = 0;
        $failedCount = 0;

        foreach ($appointmentsInWindow as $appointment) {
            try {
                Mail::to($appointment->client->email)->send(new AppointmentReminderMail($appointment));

                $appointment->forceFill([
                    'reminder_sent_at' => Carbon::now(),
                ])->save();

                $sentCount++;
            } catch (\Throwable $exception) {
                $failedCount++;

                Log::warning('Failed sending appointment reminder email.', [
                    'appointment_id' => $appointment->id,
                    'error' => $exception->getMessage(),
                ]);

                $this->warn("Failed sending reminder for appointment #{$appointment->id}.");
            }
        }

        $this->info("Appointments found: {$foundCount}");
        $this->info("Reminders sent: {$sentCount}");
        $this->info("Failures: {$failedCount}");

        return self::SUCCESS;
    }
}
