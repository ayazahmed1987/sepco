<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Mail;

Schedule::command('tenders:send-opening-notifications')->dailyAt('08:00');
Schedule::command('financial-bids:send-opening-notifications')->dailyAt('08:00');
Schedule::command('award-issuance:send-notifications')->dailyAt('08:00');
