<?php

/**
 * SCOPO: Controlla le richieste DSR (accesso/cancellazione) pendenti e vicine alla scadenza.
 * PATH: app/Console/Commands/Compliance/EscalateDsrRequests.php
 * CONSTRAINTS: Usa Enums PHP 8.4 e Spatie Activity Log per tracciare l'automazione.
 */

namespace App\Console\Commands;

use App\Models\COMPILANCE\GdprDsrRequest;
use Illuminate\Console\Command;

class EscalateDsrRequests extends Command
{
    protected $signature = 'compliance:escalate-dsr';
    protected $description = 'Verifica le richieste privacy con meno di 5 giorni alla scadenza e crea un alert';

    public function handle(): int
    {
        $criticalDate = today()->addDays(5);

        // Seleziona solo le pratiche 'pending' vicine alla scadenza
        $criticalRequests = GdprDsrRequest::where('status', 'pending')
            ->whereDate('due_date', '<=', $criticalDate)
            ->get();

        foreach ($criticalRequests as $request) {
            // Segna l'evento nell'audit log di sistema (causer_id nullo = Sistema)
            activity()
                ->performedOn($request)
                ->log("ESCALATION AUTOMATICA: Richiesta DSR scade il {$request->due_date->toDateString()}");

            // TODO: Invia notifica urgente su Slack / Teams / Email al DPO
            $this->error("URGENTE: Pratica DSR #{$request->id} scade il {$request->due_date->toDateString()}!");
        }

        return Command::SUCCESS;
    }
}
