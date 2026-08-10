<?php

namespace App\Mail;

use App\Models\ProductFreshnessChangeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FreshnessChangeRequestDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public ProductFreshnessChangeRequest $freshnessRequest;
    public string $decision;

    public function __construct(
        ProductFreshnessChangeRequest $freshnessRequest,
        string $decision
    ) {
        $this->freshnessRequest = $freshnessRequest;
        $this->decision = $decision;
    }

    public function envelope(): Envelope
    {
        $subject = $this->decision === 'approved'
            ? 'Freshness Change Request Approved'
            : 'Freshness Change Request Denied';

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.freshness-change-request-decision',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}