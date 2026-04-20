<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintRegistrySeeder extends Seeder
{
    public function run(): void
    {
        $companyId = '3ff53405-4abb-4468-bff5-f9493badac5b';

        $complaints = [
            [
                'company_id' => $companyId,
                'complaint_number' => 'REC-2025-001',
                'complainant_name' => 'Marco Colombo',
                'category' => 'delay',
                'description' => 'Il cliente lamenta un ritardo di oltre 30 giorni nella liquidazione della pratica assicurativa n. 12345, nonostante i documenti siano stati consegnati nei tempi previsti.',
                'financial_impact' => 0.0,
                'status' => 'resolved',
            ],
            [
                'company_id' => $companyId,
                'complaint_number' => 'REC-2025-002',
                'complainant_name' => 'Francesca Marino',
                'category' => 'behavior',
                'description' => 'La cliente segnala un comportamento scorretto da parte di un consulente durante il colloquio del 15/03/2025, con toni aggressivi e informazioni fuorvianti sul prodotto proposto.',
                'financial_impact' => 0.0,
                'status' => 'investigating',
            ],
            [
                'company_id' => $companyId,
                'complaint_number' => 'REC-2025-003',
                'complainant_name' => 'Stefano Ricci',
                'category' => 'fraud',
                'description' => "Il cliente denuncia l'addebito non autorizzato di una polizza mai sottoscritta per un importo di €1.200,00 annui.",
                'financial_impact' => 1200.0,
                'status' => 'open',
            ],
            [
                'company_id' => $companyId,
                'complaint_number' => 'REC-2025-004',
                'complainant_name' => 'Elena Gallo',
                'category' => 'privacy',
                'description' => 'La cliente segnala la ricezione di comunicazioni commerciali nonostante avesse revocato il consenso marketing in data 01/01/2025.',
                'financial_impact' => 0.0,
                'status' => 'resolved',
            ],
            [
                'company_id' => $companyId,
                'complaint_number' => 'REC-2025-005',
                'complainant_name' => 'Antonio De Luca',
                'category' => 'contract',
                'description' => 'Il cliente contesta le condizioni contrattuali applicate, ritenendo che le clausole di recesso non siano state adeguatamente illustrate al momento della sottoscrizione.',
                'financial_impact' => 350.0,
                'status' => 'open',
            ],
            [
                'company_id' => $companyId,
                'complaint_number' => 'REC-2024-099',
                'complainant_name' => 'Valentina Conti',
                'category' => 'quality',
                'description' => 'La cliente lamenta la scarsa qualità del servizio di assistenza telefonica, con tempi di attesa superiori a 45 minuti e operatori non adeguatamente formati.',
                'financial_impact' => 0.0,
                'status' => 'closed',
            ],
        ];

        foreach ($complaints as $complaint) {
            DB::connection('mysql_compliance')->table('complaint_registry')->insertOrIgnore(array_merge($complaint, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
