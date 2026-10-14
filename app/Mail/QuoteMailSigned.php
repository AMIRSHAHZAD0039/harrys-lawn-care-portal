<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteMailSigned extends Mailable
{
    use SerializesModels;

    public $quote;
    public $pdfContent;

    public function __construct($quote, $pdfContent)
    {
        $this->quote = $quote;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Your Quote has been Signed')
            ->view('emails.quote-signed')
            ->attachData($this->pdfContent, "Quote_{$this->quote->quote_number}.pdf", [
                'mime' => 'application/pdf',
            ]);
    }
}
