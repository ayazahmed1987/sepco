<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FinancialBidOpeningNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $evaluation;

    public function __construct($evaluation)
    {
        $this->evaluation = $evaluation;
    }

    public function build()
    {
        return $this->subject("Intimation for Financial Bid Opening (Tender No. {$this->evaluation->tender->ref_no})")
        ->view('emails.technical-evaluation-notification')
        ->with(['evaluation' => $this->evaluation]);
    }
}
