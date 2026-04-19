<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingRegistrySeeder extends Seeder
{
    public function run(): void
    {
        $companyId = '3ff53405-4abb-4468-bff5-f9493badac5b';

        // Simulated BPM user IDs
        $users = [1, 2, 3, 4, 5];

        $courses = [
            [
                'user_id'              => $users[0],
                'company_id'           => $companyId,
                'course_name'          => 'Corso Antiriciclaggio Base - OAM',
                'regulatory_framework' => 'oam',
                'completed_at'         => '2024-03-15',
                'valid_until'          => '2026-03-15',
                'certificate_document_id' => null,
            ],
            [
                'user_id'              => $users[0],
                'company_id'           => $companyId,
                'course_name'          => 'Formazione GDPR per Responsabili del Trattamento',
                'regulatory_framework' => 'gdpr',
                'completed_at'         => '2024-06-01',
                'valid_until'          => '2026-06-01',
                'certificate_document_id' => null,
            ],
            [
                'user_id'              => $users[1],
                'company_id'           => $companyId,
                'course_name'          => 'Corso IVASS - Distribuzione Assicurativa',
                'regulatory_framework' => 'ivass',
                'completed_at'         => '2023-09-20',
                'valid_until'          => '2025-09-20', // scaduto
                'certificate_document_id' => null,
            ],
            [
                'user_id'              => $users[1],
                'company_id'           => $companyId,
                'course_name'          => 'Sicurezza sul Lavoro - D.Lgs. 81/2008',
                'regulatory_framework' => 'safety',
                'completed_at'         => '2024-01-10',
                'valid_until'          => '2029-01-10',
                'certificate_document_id' => null,
            ],
            [
                'user_id'              => $users[2],
                'company_id'           => $companyId,
                'course_name'          => 'Aggiornamento OAM Biennale 2025',
                'regulatory_framework' => 'oam',
                'completed_at'         => '2025-02-28',
                'valid_until'          => '2027-02-28',
                'certificate_document_id' => null,
            ],
            [
                'user_id'              => $users[3],
                'company_id'           => $companyId,
                'course_name'          => 'Corso Antiriciclaggio Avanzato - UIF',
                'regulatory_framework' => 'oam',
                'completed_at'         => '2025-04-01',
                'valid_until'          => '2027-04-01',
                'certificate_document_id' => null,
            ],
            [
                'user_id'              => $users[4],
                'company_id'           => $companyId,
                'course_name'          => 'Privacy e Protezione dei Dati Personali',
                'regulatory_framework' => 'gdpr',
                'completed_at'         => '2024-11-15',
                'valid_until'          => null, // nessuna scadenza
                'certificate_document_id' => null,
            ],
        ];

        foreach ($courses as $course) {
            DB::connection('mysql_compliance')->table('training_registry')->insert(array_merge($course, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
