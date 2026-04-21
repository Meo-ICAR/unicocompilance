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
                'company_id' => $companyId,
                'name' => 'Violazione dati - Accesso non autorizzato',
                'incident_date' => '2025-11-10 09:00:00',
                'discovery_date' => '2025-11-11 14:30:00',
                'nature_of_breach' => 'unauthorized_access',
                'risk_level' => 'high',
                'likely_consequences' => 'Esposizione di dati personali potenzialmente sensibili',
                'approximate_records_count' => 150,
                'subjects_affected_count' => 120,
                'description' => 'Accesso non autorizzato al sistema da parte di utente esterno',
                'data_categories_involved' => json_encode(['personali', 'contatti', 'finanziari']),
                'containment_measures' => 'Revoca immediata delle credenziali compromesse. Notifica agli interessati entro 72 ore. Avvio di audit di sicurezza.',
                'status' => 'contained',
                'mitigation_measures' => 'Implementazione di autenticazione a più fattori',
                'authority_notified_at' => '2025-11-13 10:00:00',
                'subjects_notified_at' => '2025-11-13 11:00:00',
            ],
            [
                'company_id' => $companyId,
                'name' => 'Attacco Ransomware',
                'incident_date' => '2025-12-01 00:00:00',
                'discovery_date' => '2025-12-02 08:00:00',
                'nature_of_breach' => 'ransomware',
                'risk_level' => 'critical',
                'likely_consequences' => 'Crittografia di dati sensibili e interruzione del servizio',
                'approximate_records_count' => 500,
                'subjects_affected_count' => 450,
                'description' => 'Attacco ransomware che ha crittografato i dati del server principale',
                'data_categories_involved' => json_encode(['personali', 'sanitari', 'finanziari', 'documenti']),
                'containment_measures' => 'Isolamento dei sistemi infetti. Ripristino da backup. Coinvolgimento di un team di incident response esterno.',
                'status' => 'investigating',
                'mitigation_measures' => 'Backup offline regolari e formazione del personale',
                'authority_notified_at' => '2025-12-04 09:00:00',
                'subjects_notified_at' => '2025-12-04 10:00:00',
            ],
            [
                'company_id' => $companyId,
                'name' => 'Errore umano - Email errata',
                'incident_date' => '2025-09-15 11:00:00',
                'discovery_date' => '2025-09-15 11:30:00',
                'nature_of_breach' => 'human_error',
                'risk_level' => 'low',
                'likely_consequences' => 'Esposizione limitata di dati non sensibili',
                'approximate_records_count' => 5,
                'subjects_affected_count' => 5,
                'description' => 'Email inviata per errore a destinatario sbagliato',
                'data_categories_involved' => json_encode(['nome', 'email']),
                'containment_measures' => 'Email inviata per errore a destinatario sbagliato. Richiesta di cancellazione immediata. Nessun dato sensibile esposto.',
                'status' => 'closed',
                'mitigation_measures' => 'Verifica doppia destinatari prima invio email',
                'authority_notified_at' => null,
                'subjects_notified_at' => null,
            ],
            [
                'company_id' => $companyId,
                'name' => 'Attacco Phishing',
                'incident_date' => '2026-01-20 16:00:00',
                'discovery_date' => '2026-01-21 09:00:00',
                'nature_of_breach' => 'phishing',
                'risk_level' => 'medium',
                'likely_consequences' => 'Possibile furto di credenziali di accesso',
                'approximate_records_count' => 30,
                'subjects_affected_count' => 30,
                'description' => 'Campagna phishing che ha colpito diversi dipendenti',
                'data_categories_involved' => json_encode(['credenziali', 'accesso_sistemi']),
                'containment_measures' => 'Reset password di tutti gli account coinvolti. Formazione di emergenza sul phishing per il personale.',
                'status' => 'investigating',
                'mitigation_measures' => 'Filtro email avanzato e formazione continua',
                'authority_notified_at' => null,
                'subjects_notified_at' => null,
            ],
            [
                'company_id' => $companyId,
                'name' => 'Perdita dispositivo',
                'incident_date' => '2025-08-05 14:00:00',
                'discovery_date' => '2025-08-06 10:00:00',
                'nature_of_breach' => 'data_loss',
                'risk_level' => 'high',
                'likely_consequences' => 'Esposizione di dati aziendali sensibili',
                'approximate_records_count' => 200,
                'subjects_affected_count' => 200,
                'description' => 'Perdita di un laptop aziendale non criptato',
                'data_categories_involved' => json_encode(['personali', 'documenti_interni', 'report']),
                'containment_measures' => 'Perdita di un dispositivo portatile non cifrato. Denuncia alle autorità. Attivazione del piano di risposta agli incidenti.',
                'status' => 'closed',
                'mitigation_measures' => 'Crittografia dispositivi e policy di sicurezza',
                'authority_notified_at' => '2025-08-08 09:00:00',
                'subjects_notified_at' => '2025-08-08 10:00:00',
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
