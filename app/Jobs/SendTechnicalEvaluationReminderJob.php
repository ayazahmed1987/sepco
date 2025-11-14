<?php

namespace App\Jobs;

use App\Mail\FinancialBidOpeningNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTechnicalEvaluationReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $evaluation;
    public $email;

    public function __construct($evaluation, $email)
    {
        $this->evaluation = $evaluation;
        $this->email = $email;
    }

    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new FinancialBidOpeningNotification($this->evaluation));
    }
}
