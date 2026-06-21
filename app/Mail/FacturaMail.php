<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class FacturaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $venta;
    public $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct($venta, $pdfContent)
    {
        $this->venta = $venta;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $nroFacturaStr = str_pad($this->venta->nro_factura, 5, '0', STR_PAD_LEFT);
        return new Envelope(
            subject: 'Tu Factura N° ' . $nroFacturaStr . ' - SaborXpress',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.factura',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $nroFacturaStr = str_pad($this->venta->nro_factura, 5, '0', STR_PAD_LEFT);
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'Factura_' . $nroFacturaStr . '.pdf')
                    ->withMime('application/pdf'),
        ];
    }
}
