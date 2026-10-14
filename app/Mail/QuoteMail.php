<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteMail extends Mailable
{
    public $quote;
    public $link;
    public $log;

    public function __construct($quote,$link, $log)
    {
        $this->quote = $quote;
        $this->link = $link;
        $this->log = $log;
    }

    public function build()
    {

        return $this->subject('Your Quote is Ready')
            ->view('emails.quote');

    }
}
