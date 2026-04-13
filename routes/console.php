<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * SCOPO: Registrare i cron jobs di UnicoCompliance.
 * PATH: routes/console.php
 */

// Esegui il controllo scadenze formazione ogni mattina alle 02:00
Schedule::command('compliance:check-training-expiries --days=30')
    ->dailyAt('02:00')
    ->onOneServer();

// Esegui il controllo DSR GDPR due volte al giorno (mattina e pomeriggio)
Schedule::command('compliance:escalate-dsr')
    ->twiceDaily(8, 14)
    ->onOneServer();
