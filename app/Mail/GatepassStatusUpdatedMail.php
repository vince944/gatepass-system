<?php

namespace App\Mail;

use App\Models\GatepassRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GatepassStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public GatepassRequest $gatepass,
        public string $newStatus,
        public string $recipientDisplayName,
    ) {}

    public function envelope(): Envelope
    {
        $subject = match ($this->newStatus) {
            'Approved' => 'Your gate pass request was approved',
            'Rejected' => 'Your gate pass request was rejected',
            default => 'Your gate pass request status was updated',
        };

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.gatepass-status-updated',
        );
    }
}
