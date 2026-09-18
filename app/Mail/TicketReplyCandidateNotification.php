<?php

namespace App\Mail;

use App\Models\Candidate;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketReplyCandidateNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public Candidate $candidate;
    public string $adminReply;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket, Candidate $candidate, string $adminReply)
    {
        $this->ticket = $ticket;
        $this->candidate = $candidate;
        $this->adminReply = $adminReply;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Update on Ticket [{$this->ticket->ticket_code}]: Status ({$this->ticket->status}) - Rani Matrimonial Support",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket_reply_candidate',
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
