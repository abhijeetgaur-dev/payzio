<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class SaveQR extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'QR Image Generated Successfully',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.qr-code-saved',
            with: [
                'data' => $this->data
            ]
        );
    }

    /**
     * Attach the QR code image to the email.
     */
    public function attachments(): array
    {
        $filePath = storage_path('app/public/qr_codes/' . $this->data['qr_code_url']);

        if (file_exists($filePath)) {
            return [
                Attachment::fromPath($filePath)
                    ->as('qr-code.jpg')
                    ->withMime('image/jpeg'),
            ];
        }

        return [];
    }
}

