<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrdenesCompraMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public function __construct($asunto,$mensaje)
    {
        $this->data = [
            // 'name' => $destinatario,
            // 'email' => $email,
            'subject' => $asunto,
            'bodyMessage' => $mensaje,
        ];
    }
    public function envelope() { return new Envelope( subject: $this->data['subject'], ); }
    public function content() { return new Content( view: 'mails.OrdenRech', ); }
    // public function content() { return new Content( view: 'mails.pruebaMail', ); }
    public function attachments() { return []; }
}
