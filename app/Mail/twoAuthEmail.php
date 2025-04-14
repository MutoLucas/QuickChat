<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class twoAuthEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $dados;

    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Authentication Code',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.sendTokenMail',
            with: ['dados' => $this->dados]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
