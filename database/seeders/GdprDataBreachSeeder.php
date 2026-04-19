<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GdprDataBreachSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = '3ff53405-4abb-4468-bff5-f9493badac5b';

        $breaches = [
            [
                'company_id'              => $companyId,
                'incident_date'           => '2025-11-10 09:00:00',
                'discovery_date'          => '2025-11-11 14:30:00',
                'nature_of_breach'        => 'unauthorized_access',
                'subjects_affected_count' => 120,
                'is_notified_to_authority' => true,
                'notification_date'       => '2025-11-13 10:00:00',
                'containment_measures'    => 'Revoca immediata delle credenziali compromesse. Notifica agli interessati entro 72 ore. Avvio di audit di sicurezza.',
                'status'                  => 'contained',
            ],
            [
                'company_id'              => $companyId,
                'incident_date'           => '2025-12-01 00:00:00',
                'discovery_date'          => '2025-12-02 08:00:00',
                'nature_of_breach'        => 'ransomware',
                'subjects_affected_count' => 450,
                'is_notified_to_authority' => true,
                'notification_date'       => '2025-12-04 09:00:00',
                'containment_measures'    => 'Isolamento dei sistemi infetti. Ripristino da backup. Coinvolgimento di un team di incident response esterno.',
                'status'                  => 'investigating',
            ],
            [
                'company_id'              => $companyId,
                'incident_date'           => '2025-09-15 11:00:00',
                'discovery_date'          => '2025-09-15 11:30:00',
                'nature_of_breach'        => 'human_error',
                'subjects_affected_count' => 5,
                'is_notified_to_authority' => false,
                'notification_date'       => null,
                'containment_measures'    => 'Email inviata per errore a destinatario sbagliato. Richiesta di cancellazione immediata. Nessun dato sensibile esposto.',
                'status'                  => 'closed',
            ],
            [
                'company_id'              => $companyId,
                'incident_date'           => '2026-01-20 16:00:00',
                'discovery_date'          => '2026-01-21 09:00:00',
                'nature_of_breach'        => 'phishing',
                'subjects_affected_count' => 30,
                'is_notified_to_authority' => false,
                'notification_date'       => null,
                'containment_measures'    => 'Reset password di tutti gli account coinvolti. Formazione di emergenza sul phishing per il personale.',
                'status'                  => 'investigating',
            ],
            [
                'company_id'              => $companyId,
                'incident_date'           => '2025-08-05 14:00:00',
                'discovery_date'          => '2025-08-06 10:00:00',
                'nature_of_breach'        => 'data_loss',
                'subjects_affected_count' => 200,
                'is_notified_to_authority' => true,
                'notification_date'       => '2025-08-08 09:00:00',
                'containment_measures'    => 'Perdita di un dispositivo portatile non cifrato. Denuncia alle autorità. Attivazione del piano di risposta agli incidenti.',
                'status'                  => 'closed',
            ],
        ];

        foreach ($breaches as $breach) {
            DB::connection('mysql_compliance')->table('gdpr_data_breaches')->insert(array_merge($breach, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
