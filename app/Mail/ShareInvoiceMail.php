<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShareInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $pdfContent;
    public $pdfFileName;

    public function __construct($pdfContent, $pdfFileName)
    {
        $this->pdfContent = $pdfContent;
        $this->pdfFileName = $pdfFileName;
    }

    public function build()
    {
        return $this->view('emails.order.share-invoice-mail')
        ->attachData($this->pdfContent, $this->pdfFileName, [
            'mime' => 'application/pdf',
        ]);
    }
}
