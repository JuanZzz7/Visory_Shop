<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GoogleVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public string $userName;

    public function __construct(string $code, string $userName)
    {
        $this->code     = $code;
        $this->userName = $userName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔐 Tu código de verificación — Spotlight',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.google_verification',
        );
    }
}
