<?php

namespace App\Mail;

use App\Models\Candidate;
use App\Models\GroundPartner;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCandidateRegistrationAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public Candidate $candidate;
    public ?GroundPartner $groundPartner;

    /**
     * Create a new message instance.
     */
    public function __construct(Candidate $candidate, ?GroundPartner $groundPartner = null)
    {
        $this->candidate = $candidate;
        $this->groundPartner = $groundPartner;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $code = $this->candidate->display_code ?? ('RM' . str_pad((string)$this->candidate->id, 5, '0', STR_PAD_LEFT));
        $name = trim(($this->candidate->first_name ?? '') . ' ' . ($this->candidate->last_name ?? ''));
        $partnerTag = $this->groundPartner ? " [GP: {$this->groundPartner->code}]" : "";

        return new Envelope(
            subject: "🔔 New Registration Alert: {$name} ({$code}){$partnerTag} - Rani Matrimonial",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_new_candidate_registration',
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
