<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\FinalEvaluation;
use App\Jobs\SendAwardIssuanceReminderJob;
use Illuminate\Support\Facades\Log;

class SendAwardIssuanceEmails extends Command
{
    protected $signature = 'award-issuance:send-notifications';
    protected $description = 'Send financial bid opening emails to tender persons every morning';

    public function handle(): void
    {
        $targetDate = now()->subDays(15)->startOfDay()->toDateString();
        $today = now()->toDateString();
        Log::info("Running SendAwardIssuanceReminderJob for evaluations uploaded on: $today");

        FinalEvaluation::with('tender.tenderPerson')
        ->whereDate('po_issuance_date', $today)
        ->chunk(100, function ($evaluations) {
            foreach ($evaluations as $evaluation) {
                $person = $evaluation->tender->tenderPerson ?? null;
                $email = $person?->email;

                Log::info("Evaluation ID: {$evaluation->id}, Email: " . ($email ?? 'null'));

                if ($email) {
                    Log::info("Dispatching email to: $email");
                    dispatch(new SendAwardIssuanceReminderJob($evaluation, $email));
                } else {
                    Log::warning("Evaluation ID {$evaluation->id} has no valid tender person or email.");
                }
            }
        });

        Log::info("Award Issuance reminders queued successfully.");
        $this->info('Reminder emails have been dispatched.');
    }
}
