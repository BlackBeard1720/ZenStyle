<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $otpCode)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your ZenStyle Booking OTP',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-otp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
