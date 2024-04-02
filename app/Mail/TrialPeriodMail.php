<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrialPeriodMail extends Mailable
{
    use Queueable, SerializesModels;
    private $end_date;
    private $remaining;
    /**
     * Create a new message instance.
     */
    public function __construct($end_date,$remaining)
    {

        $this->end_date = $end_date;
        $this->remaining = $remaining;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Trial Period Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'trialPeriod',
            with: [
                'days_remaining'=>$this->remaining,
                'end_date' => $this->end_date
            ]
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
