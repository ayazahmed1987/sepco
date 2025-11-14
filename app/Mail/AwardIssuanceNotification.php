<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AwardIssuanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $evaluation;

    public function __construct($evaluation)
    {
        $this->evaluation = $evaluation;
    }

    public function build()
    {
        return $this->subject("Intimation for Award of Contract (Tender No. {$this->evaluation->tender->ref_no})")
        ->view('emails.award-issuance-notification')
        ->with(['evaluation' => $this->evaluation]);
    }
}
