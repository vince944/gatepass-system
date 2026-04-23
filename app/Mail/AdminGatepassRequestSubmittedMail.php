<?php

namespace App\Mail;

use App\Models\GatepassRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminGatepassRequestSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public GatepassRequest $gatepass,
        public string $requesterDisplayName
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New gate pass request submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-gatepass-request-submitted',
        );
    }
}
