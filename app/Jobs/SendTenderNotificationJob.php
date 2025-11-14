<?php

namespace App\Jobs;

use App\Mail\TenderBidOpeningNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTenderNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tender;
    public $recipientEmail;

    public function __construct($tender, $recipientEmail)
    {
        $this->tender = $tender;
        $this->recipientEmail = $recipientEmail;
    }

    public function handle(): void
    {
        Mail::to($this->recipientEmail)
            ->send(new TenderBidOpeningNotification($this->tender));
    }
    
}
