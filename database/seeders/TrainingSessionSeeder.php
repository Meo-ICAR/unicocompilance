<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingSessionSeeder extends Seeder
{
    public function run(): void
    {
        $companyId    = '3ff53405-4abb-4468-bff5-f9493badac5b';
        $agentType    = 'App\\Models\\BPM\\Agent';
        $employeeType = 'App\\Models\\BPM\\Employee';

        $sessions = [
            [
                'company_id'       => $companyId,
                'trainee_type'     => $agentType,
                'trainee_id'       => 1,
                'course_name'      => 'Antiriciclaggio e Normativa OAM - Aggiornamento Biennale',
                'provider'         => 'OAM - Organismo Agenti e Mediatori',
                'hours'            => 30,
                'completion_date'  => '2025-03-15',
                'expiry_date'      => '2027-03-15',
                'certificate_path' => null,
                'notes'            => 'Corso obbligatorio biennale per iscritti OAM sezione agenti.',
            ],
            [
                'company_id'       => $companyId,
                'trainee_type'     => $agentType,
                'trainee_id'       => 2,
                'course_name'      => 'Distribuzione Assicurativa - IVASS Modulo Base',
                'provider'         => 'IVASS',
                'hours'            => 60,
                'completion_date'  => '2024-09-20',
                'expiry_date'      => '2026-09-20',
                'certificate_path' => null,
                'notes'            => 'Formazione obbligatoria per intermediari assicurativi.',
            ],
            [
                'company_id'       => $companyId,
                'trainee_type'     => $employeeType,
                'trainee_id'       => 1,
                'course_name'      => 'Sicurezza sul Lavoro - Formazione Generale D.Lgs. 81/2008',
                'provider'         => 'Ente Bilaterale Nazionale',
                'hours'            => 8,
                'completion_date'  => '2025-01-10',
                'expiry_date'      => '2030-01-10',
                'certificate_path' => null,
                'notes'            => null,
            ],
            [
                'company_id'       => $companyId,
                'trainee_type'     => $employeeType,
                'trainee_id'       => 2,
                'course_name'      => 'GDPR e Privacy - Ruoli e Responsabilità del Personale',
                'provider'         => 'Associazione Italiana Privacy',
                'hours'            => 16,
                'completion_date'  => '2025-05-22',
                'expiry_date'      => '2027-05-22',
                'certificate_path' => null,
                'notes'            => 'Formazione specifica per addetti al trattamento dati.',
            ],
            [
                'company_id'       => $companyId,
                'trainee_type'     => $agentType,
                'trainee_id'       => 3,
                'course_name'      => 'Antiriciclaggio Avanzato - Indicatori di Anomalia UIF',
                'provider'         => 'Unità di Informazione Finanziaria - Banca d\'Italia',
                'hours'            => 20,
                'completion_date'  => '2025-09-10',
                'expiry_date'      => '2027-09-10',
                'certificate_path' => null,
                'notes'            => 'Corso avanzato sugli indicatori di anomalia emanati dalla UIF.',
            ],
            [
                'company_id'       => $companyId,
                'trainee_type'     => $employeeType,
                'trainee_id'       => 3,
                'course_name'      => 'Antiriciclaggio Base - Obblighi di Adeguata Verifica',
                'provider'         => 'OAM - Organismo Agenti e Mediatori',
                'hours'            => 15,
                'completion_date'  => '2024-11-05',
                'expiry_date'      => '2026-11-05',
                'certificate_path' => null,
                'notes'            => null,
            ],
        ];

        foreach ($sessions as $session) {
            DB::connection('mysql_compliance')->table('training_sessions')->insert(array_merge($session, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
