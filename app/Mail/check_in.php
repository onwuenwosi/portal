<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class check_in extends Mailable
{
    use Queueable, SerializesModels;

    public $policy;
    public $surname;
    public $othername;
    public $time;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($policy, $surname, $othername, $time, $user)
    {
        $this->policy = $policy;
        $this->surname = $surname;
        $this->othername = $othername;
        $this->time = $time;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Check-in Notification',

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.check_in',
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