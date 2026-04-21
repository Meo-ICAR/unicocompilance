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
                'name' => 'Marco Colombo',
                'received_at' => '2025-01-15',
                'company_email' => 'info@company.com',
                'category' => 'delay',
                'request_type' => 'investigation',
                'request_details' => 'Richiesta di verifica ritardo liquidazione',
                'complaint_email' => 'marco.colombo@email.com',
                'complaint_type' => 'client',
                'complaint_id' => 'CLI-001',
                'description' => 'Il cliente lamenta un ritardo di oltre 30 giorni nella liquidazione della pratica assicurativa n. 12345, nonostante i documenti siano stati consegnati nei tempi previsti.',
                'entity_type' => 'pratica',
                'entity_id' => 'PR-12345',
            ],
            [
                'company_id' => $companyId,
                'complaint_number' => 'REC-2025-002',
                'name' => 'Francesca Marino',
                'received_at' => '2025-03-16',
                'company_email' => 'info@company.com',
                'category' => 'behavior',
                'request_type' => 'investigation',
                'request_details' => 'Segnalazione comportamento scorretto consulente',
                'complaint_email' => 'francesca.marino@email.com',
                'complaint_type' => 'client',
                'complaint_id' => 'CLI-002',
                'description' => 'La cliente segnala un comportamento scorretto da parte di un consulente durante il colloquio del 15/03/2025, con toni aggressivi e informazioni fuorvianti sul prodotto proposto.',
                'entity_type' => 'employee',
                'entity_id' => 'EMP-001',
            ],
            [
                'company_id' => $companyId,
                'complaint_number' => 'REC-2025-003',
                'name' => 'Stefano Ricci',
                'received_at' => '2025-02-10',
                'company_email' => 'info@company.com',
                'category' => 'fraud',
                'request_type' => 'investigation',
                'request_details' => 'Segnalazione addebito non autorizzato',
                'complaint_email' => 'stefano.ricci@email.com',
                'complaint_type' => 'client',
                'complaint_id' => 'CLI-003',
                'description' => "Il cliente denuncia l'addebito non autorizzato di una polizza mai sottoscritta per un importo di 1.200,00 annui.",
                'entity_type' => 'pratica',
                'entity_id' => 'PR-67890',
            ],
            [
                'company_id' => $companyId,
                'complaint_number' => 'REC-2025-004',
                'name' => 'Elena Gallo',
                'received_at' => '2025-01-02',
                'company_email' => 'info@company.com',
                'category' => 'privacy',
                'request_type' => 'erasure',
                'request_details' => 'Revoca consenso marketing',
                'complaint_email' => 'elena.gallo@email.com',
                'complaint_type' => 'client',
                'complaint_id' => 'CLI-004',
                'description' => 'La cliente segnala la ricezione di comunicazioni commerciali nonostante avesse revocato il consenso marketing in data 01/01/2025.',
                'entity_type' => 'marketing',
                'entity_id' => 'MKT-001',
            ],
            [
                'company_id' => $companyId,
                'complaint_number' => 'REC-2025-005',
                'name' => 'Antonio De Luca',
                'received_at' => '2025-03-01',
                'company_email' => 'info@company.com',
                'category' => 'delay',
                'request_type' => 'rectification',
                'request_details' => 'Contestazione condizioni contrattuali',
                'complaint_email' => 'antonio.deluca@email.com',
                'complaint_type' => 'client',
                'complaint_id' => 'CLI-005',
                'description' => 'Il cliente contesta le condizioni contrattuali applicate, ritenendo che le clausole di recesso non siano state adeguatamente illustrate al momento della sottoscrizione.',
                'entity_type' => 'contract',
                'entity_id' => 'CTR-001',
            ],
            [
                'company_id' => $companyId,
                'complaint_number' => 'REC-2024-099',
                'name' => 'Valentina Conti',
                'received_at' => '2024-12-15',
                'company_email' => 'info@company.com',
                'category' => 'behavior',
                'request_type' => 'investigation',
                'request_details' => 'Reclamo qualità assistenza telefonica',
                'complaint_email' => 'valentina.conti@email.com',
                'complaint_type' => 'client',
                'complaint_id' => 'CLI-099',
                'description' => 'La cliente lamenta la scarsa qualità del servizio di assistenza telefonica, con tempi di attesa superiori a 45 minuti e operatori non adeguatamente formati.',
                'entity_type' => 'call_center',
                'entity_id' => 'CC-001',
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
