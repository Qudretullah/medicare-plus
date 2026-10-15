<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    
   
    public function __construct(
    public Appointment $appointment,
    public string $doctorName,
    public ?int $emailLogId = null
) {
    $this->afterCommit();
}



    public function envelope(): Envelope
    {
        $subject = match ($this->appointment->status) {
            'approved' => 'Your Medicare+ Appointment Is Confirmed',
            'rejected' => 'Update Regarding Your Medicare+ Appointment',
            default => 'Medicare+ Appointment Update',
        };

        return new Envelope(
            subject: $subject
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-status'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
