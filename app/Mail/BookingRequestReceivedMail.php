<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingRequestReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment->loadMissing([
            'client',
            'appointmentServices.service',
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ZenStyle - Appointment Request Received',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-request-received',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
