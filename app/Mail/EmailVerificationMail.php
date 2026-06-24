<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $name, public string $code) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.conweb_from', 'mail@conweb.id'),
            subject: 'Kode Verifikasi ConWeb: '.$this->code,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.verify');
    }
}
