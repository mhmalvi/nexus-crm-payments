<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionUpgradeMail extends Mailable
{
    use Queueable, SerializesModels;
    private $email;
    private $name;
    private $interval;
    private $package;
    /**
     * Create a new message instance.
     */
    public function __construct($email, $name, $interval, $package)
    {
        $this->email = $email;
        $this->name = $name;
        $this->interval = $interval;
        $this->package = $package;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Upgrade Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'subcriptionUpgrade',
            with: [
                'email' => $this->email,
                'package' => $this->package,
                'interval' => $this->interval
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
