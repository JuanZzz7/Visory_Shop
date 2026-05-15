<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompanyStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $status;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(Company $company, string $status, string $reason = null)
    {
        $this->company = $company;
        $this->status = $status;
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->status === 'active' 
            ? '¡Tu empresa ha sido aprobada en Spotlight!'
            : 'Actualización sobre el estado de tu empresa en Spotlight';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.company_status',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
