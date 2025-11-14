<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\TechnicalEvaluation;
use App\Jobs\SendTechnicalEvaluationReminderJob;
use Illuminate\Support\Facades\Log;

class SendFinancialBidOpeningEmails extends Command
{
    protected $signature = 'financial-bids:send-opening-notifications';
    protected $description = 'Send financial bid opening emails to tender persons every morning';

    public function handle(): void
    {
        $targetDate = now()->subDays(7)->startOfDay()->toDateString();
        $today = now()->toDateString();
        Log::info("Running SendTechnicalEvaluationReminders for evaluations uploaded on: $today");

        TechnicalEvaluation::with('tender.tenderPerson')
        ->whereDate('financial_opening_date', $today)
        ->chunk(100, function ($evaluations) {
            foreach ($evaluations as $evaluation) {
                $person = $evaluation->tender->tenderPerson ?? null;
                $email = $person?->email;

                Log::info("Evaluation ID: {$evaluation->id}, Email: " . ($email ?? 'null'));

                if ($email) {
                    Log::info("Dispatching email to: $email");
                    dispatch(new SendTechnicalEvaluationReminderJob($evaluation, $email));
                } else {
                    Log::warning("Evaluation ID {$evaluation->id} has no valid tender person or email.");
                }
            }
        });

        Log::info("Technical evaluation reminders queued successfully.");
        $this->info('Reminder emails have been dispatched.');
    }
}
