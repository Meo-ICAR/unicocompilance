<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConflictOfInterestSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = '3ff53405-4abb-4468-bff5-f9493badac5b';

        $conflicts = [
            [
                'company_id'                  => $companyId,
                'user_id'                     => 1,
                'conflict_description'        => 'Il consulente ha un rapporto di parentela di primo grado con il titolare della società cliente "Rossi & Figli Srl", per cui ha gestito la pratica di finanziamento n. 2025-0034.',
                'mitigation_strategy'         => 'Pratica riassegnata a un consulente terzo. Il soggetto è stato escluso da tutte le comunicazioni relative alla pratica.',
                'approved_by_compliance_at'   => '2025-03-10 11:00:00',
            ],
            [
                'company_id'                  => $companyId,
                'user_id'                     => 2,
                'conflict_description'        => 'Il dipendente detiene una partecipazione azionaria del 15% in una società fornitrice di servizi IT con cui l\'azienda ha stipulato un contratto di fornitura.',
                'mitigation_strategy'         => 'Il dipendente è stato escluso dal processo di selezione e negoziazione del contratto. Dichiarazione di conflitto depositata agli atti.',
                'approved_by_compliance_at'   => '2025-01-20 09:30:00',
            ],
            [
                'company_id'                  => $companyId,
                'user_id'                     => 3,
                'conflict_description'        => 'Il responsabile commerciale ha ricevuto un invito a un evento di lusso da parte di un partner assicurativo durante il periodo di rinnovo contrattuale.',
                'mitigation_strategy'         => 'Invito declinato. Comunicazione formale al partner. Aggiornamento del registro dei doni e delle ospitalità.',
                'approved_by_compliance_at'   => null, // in attesa di approvazione
            ],
        ];

        foreach ($conflicts as $conflict) {
            DB::connection('mysql_compliance')->table('conflict_of_interest_registry')->insert(array_merge($conflict, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
