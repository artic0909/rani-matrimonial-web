<?php

namespace App\Mail;

use App\Models\Help;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HelpInquiryAdminReply extends Mailable
{
    use Queueable, SerializesModels;

    public Help $help;
    public string $replyMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Help $help, string $replyMessage)
    {
        $this->help = $help;
        $this->replyMessage = $replyMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Update on your inquiry: {$this->help->subject} - Rani Matrimonial",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.help_inquiry_reply',
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
