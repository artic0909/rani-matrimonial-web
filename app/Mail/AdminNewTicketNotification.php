<?php

namespace App\Mail;

use App\Models\Candidate;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNewTicketNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public Candidate $candidate;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket, Candidate $candidate)
    {
        $this->ticket = $ticket;
        $this->candidate = $candidate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $priorityUpper = strtoupper($this->ticket->priority);
        return new Envelope(
            subject: "🎫 [{$priorityUpper}] New Ticket Raised: {$this->ticket->ticket_code} by {$this->candidate->first_name} {$this->candidate->last_name}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_new_ticket',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
