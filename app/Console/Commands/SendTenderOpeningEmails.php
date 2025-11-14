<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TenderBidOpeningNotification;
use Carbon\Carbon;
use App\Models\Tender;
use App\Jobs\SendTenderNotificationJob;
use Illuminate\Support\Facades\Log;

class SendTenderOpeningEmails extends Command
{
    protected $signature = 'tenders:send-opening-notifications';
    protected $description = 'Send bid opening emails to tender persons every morning';

    public function handle(): void
    {
        $today = now()->toDateString();
        Log::info("Running SendTenderOpeningEmails for date: $today");

        Tender::with('tenderPerson')
            ->whereDate('bids_opening_date', $today)
            ->chunk(100, function ($tenders) {
                Log::info("Fetched tender chunk: " . count($tenders));

                foreach ($tenders as $tender) {
                    $person = $tender->tenderPerson;
                    Log::info("Tender ID: {$tender->id}, Person Email: " . ($person->email ?? 'null'));

                    if ($person && $person->email) {
                        Log::info("Dispatching job for: {$person->email}");
                        dispatch(new SendTenderNotificationJob($tender, $person->email));
                    } else {
                        Log::warning("Tender ID {$tender->id} has no valid tender person or email.");
                    }
                }
            });

        Log::info("Completed command: tenders:send-opening-notifications");
        $this->info('Tender bid opening emails queued.');
    }
}
