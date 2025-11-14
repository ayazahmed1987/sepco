<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TenderBidOpeningNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $tender;

    public function __construct($tender)
    {
        $this->tender = $tender;
    }

    public function build()
    {
        return $this->subject("Intimation for Bid Opening (Tender No. {$this->tender->ref_no})")
        ->view('emails.tender-bid-notification')
        ->with(['tender' => $this->tender]);
    }
}
