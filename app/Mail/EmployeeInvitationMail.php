<?php

namespace App\Mail;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmployeeInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Employee $employee,
        public string $completeRegistrationUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You\'re invited — Development Academy of Philippines (Gatepass Request and Management System)',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.employee-invitation',
        );
    }
}
