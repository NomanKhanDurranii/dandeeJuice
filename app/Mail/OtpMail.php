<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $otp,
        public readonly string $expiresInMinutes = '5',
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->otp . ' is your DandeeJuice login code',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.otp',
        );
    }
}
