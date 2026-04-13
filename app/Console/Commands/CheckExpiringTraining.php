<?php

/**
 * SCOPO: Verifica i corsi di formazione in scadenza entro i prossimi 30 giorni.
 * PATH: app/Console/Commands/Compliance/CheckExpiringTraining.php
 * CONSTRAINTS: Interroga TrainingRegistry e registra log di audit/sistema.
 */

namespace App\Console\Commands\Compliance;

use App\Models\TrainingRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckExpiringTraining extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'compliance:check-training-expiries {--days=30 : Giorni di preavviso}';

    /**
     * The console command description.
     */
    protected $description = 'Controlla e notifica i corsi di formazione IVASS/OAM/GDPR in scadenza';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $targetDate = today()->addDays($days);

        $this->info("Inizio scansione corsi in scadenza entro il {$targetDate->toDateString()}...");

        $expiringRecords = TrainingRegistry::with('user')  // Eager load del Proxy Model BPM
            ->whereBetween('valid_until', [today(), $targetDate])
            ->get();

        if ($expiringRecords->isEmpty()) {
            $this->info('Nessun corso in scadenza nel periodo indicato.');
            return Command::SUCCESS;
        }

        foreach ($expiringRecords as $record) {
            // Qui potresti dispatchare un Job o inviare una Mail/Notifica BPM
            Log::channel('compliance')->warning('Formazione in scadenza', [
                'agent_id' => $record->user_id,
                'agent_name' => $record->user->name ?? 'N/A',
                'course' => $record->course_name,
                'expires_at' => $record->valid_until->toDateString(),
            ]);

            $this->line("- L'agente {$record->user_id} scade il {$record->valid_until->toDateString()} ({$record->course_name})");
        }

        $this->info("Completato. {$expiringRecords->count()} posizioni trovate.");

        return Command::SUCCESS;
    }
}
