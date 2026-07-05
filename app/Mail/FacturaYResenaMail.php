<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FacturaYResenaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $venta;
    public $pdfContent;

    public function __construct($venta, $pdfContent = null)
    {
        $this->venta = $venta;
        $this->pdfContent = $pdfContent;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu Factura y Calificación en SaborXpress',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.factura_resena',
        );
    }

    public function attachments(): array
    {
        if ($this->pdfContent) {
            return [
                Attachment::fromData(fn () => $this->pdfContent, 'Factura_'.$this->venta->nro_factura.'.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}
