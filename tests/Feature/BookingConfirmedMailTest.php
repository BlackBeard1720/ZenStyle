<?php

namespace Tests\Feature;

use App\Mail\BookingConfirmedMail;
use App\Models\Appointment;
use App\Models\Client;
use Tests\TestCase;

class BookingConfirmedMailTest extends TestCase
{
    public function test_booking_confirmation_mail_renders_appointment_details(): void
    {
        $client = new Client([
            'full_name' => 'Nguyen Van A',
            'email' => 'customer@example.com',
        ]);

        $appointment = new Appointment([
            'appointment_date' => '2026-05-23',
            'appointment_time' => '09:30',
        ]);
        $appointment->forceFill(['id' => 123]);
        $appointment->setRelation('client', $client);

        $mail = new BookingConfirmedMail($appointment);
        $html = $mail->render();

        $this->assertSame('ZenStyle - Xác nhận đặt lịch thành công', $mail->envelope()->subject);
        $this->assertStringContainsString('Nguyen Van A', $html);
        $this->assertStringContainsString('#123', $html);
        $this->assertStringContainsString('23/05/2026', $html);
        $this->assertStringContainsString('09:30', $html);
    }
}
