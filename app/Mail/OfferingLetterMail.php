<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OfferingLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $name) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.conweb_from', 'mail@conweb.id'),
            subject: 'Selamat datang di ConWeb — website impianmu menanti ✨',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.offering');
    }
}
