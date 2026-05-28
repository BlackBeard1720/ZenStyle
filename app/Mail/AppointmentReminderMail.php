<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment->loadMissing(['client', 'appointmentServices.service', 'appointmentServices.staff']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ZenStyle - Appointment Reminder',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
