<?php

namespace App\Mail;

use App\Models\Branch;
use App\Models\Candidate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCandidateRegistrationAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public Candidate $candidate;
    public ?Branch $branch;

    /**
     * Create a new message instance.
     */
    public function __construct(Candidate $candidate, ?Branch $branch = null)
    {
        $this->candidate = $candidate;
        $this->branch = $branch;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $code = $this->candidate->display_code ?? ('RM' . str_pad((string)$this->candidate->id, 5, '0', STR_PAD_LEFT));
        $name = trim(($this->candidate->first_name ?? '') . ' ' . ($this->candidate->last_name ?? ''));
        $branchTag = $this->branch ? " [Branch: {$this->branch->code}]" : "";

        return new Envelope(
            subject: "🔔 New Registration Alert: {$name} ({$code}){$branchTag} - Rani Matrimonial",
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
     */
    public function attachments(): array
    {
        return [];
    }
}
