<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AmlSosReportSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = '3ff53405-4abb-4468-bff5-f9493badac5b';
        $agentId1  = Str::uuid()->toString();
        $agentId2  = Str::uuid()->toString();

        $reports = [
            [
                'company_id'           => $companyId,
                'agent_id'             => $agentId1,
                'practice_reference'   => 'PRJ-2025-0042',
                'suspicion_indicators' => json_encode(['1A', '2B', '4A']),
                'internal_evaluation'  => 'Cliente ha effettuato tre bonifici internazionali verso paesi a rischio in 48 ore per importi appena sotto soglia.',
                'forwarded_to_fiu'     => true,
                'fiu_protocol_number'  => 'UIF-2025-00123',
                'receipt_document_id'  => null,
                'status'               => 'reported',
            ],
            [
                'company_id'           => $companyId,
                'agent_id'             => $agentId1,
                'practice_reference'   => 'PRJ-2025-0078',
                'suspicion_indicators' => json_encode(['1B', '3A']),
                'internal_evaluation'  => 'Operazioni frammentate ripetute nel corso di una settimana. Comportamento anomalo del cliente durante il colloquio.',
                'forwarded_to_fiu'     => false,
                'fiu_protocol_number'  => null,
                'receipt_document_id'  => null,
                'status'               => 'evaluating',
            ],
            [
                'company_id'           => $companyId,
                'agent_id'             => $agentId2,
                'practice_reference'   => 'PRJ-2025-0101',
                'suspicion_indicators' => json_encode(['5B']),
                'internal_evaluation'  => 'Versamenti in contanti ripetuti di importo elevato senza giustificazione economica plausibile.',
                'forwarded_to_fiu'     => false,
                'fiu_protocol_number'  => null,
                'receipt_document_id'  => null,
                'status'               => 'drafted',
            ],
            [
                'company_id'           => $companyId,
                'agent_id'             => $agentId2,
                'practice_reference'   => 'PRJ-2024-0215',
                'suspicion_indicators' => json_encode(['4B', '2A']),
                'internal_evaluation'  => 'Soggetto presente in lista sanzionatoria internazionale. Operazione bloccata e segnalata.',
                'forwarded_to_fiu'     => true,
                'fiu_protocol_number'  => 'UIF-2024-00987',
                'receipt_document_id'  => null,
                'status'               => 'archived',
            ],
        ];

        foreach ($reports as $report) {
            DB::connection('mysql_compliance')->table('aml_sos_reports')->insert(array_merge($report, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
