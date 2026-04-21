<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientDpaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use a fixed company UUID since companies table is in different database
        $companyUuid = '5c044917-15b3-4471-90c9-38061fcca754';

        // DPA data from SQL
        $dpas = [
            [
                'id' => 1,
                'name' => 'DPA infrastruttura cloud primaria',
                'status' => 'active',
                'processing_nature_and_purpose' => 'Hosting applicativi HR e backup giornalieri.',
                'data_categories' => json_encode(['Dati anagrafici', 'Dati bancari e retributivi']),
                'data_subjects' => json_encode(['Dipendenti']),
                'allows_general_subprocessors' => false,
                'signed_at' => '2025-01-28 07:17:29',
                'valid_until' => '2027-01-28',
                'model_id' => null,
                'model_type' => null,
                'company_id' => $companyUuid,
                'created_at' => '2026-03-28 07:17:29',
                'updated_at' => '2026-03-28 07:17:29',
            ],
            [
                'id' => 2,
                'name' => 'DPA campagne DEM e analytics',
                'status' => 'expired',
                'processing_nature_and_purpose' => 'Invio DEM e report aperture click.',
                'data_categories' => json_encode(['Email', 'Dati di navigazione']),
                'data_subjects' => json_encode(['Clienti', 'Lead']),
                'allows_general_subprocessors' => true,
                'signed_at' => '2023-03-28 06:17:29',
                'valid_until' => '2026-02-28',
                'model_id' => null,
                'model_type' => null,
                'company_id' => $companyUuid,
                'created_at' => '2026-03-28 07:17:29',
                'updated_at' => '2026-03-28 07:17:29',
            ],
            [
                'id' => 3,
                'name' => 'DPA outsourcing paghe',
                'status' => 'active',
                'processing_nature_and_purpose' => 'Elaborazione mensile cedolini e adempimenti previdenziali.',
                'data_categories' => json_encode(['Dati retributivi', 'Dati anagrafici']),
                'data_subjects' => json_encode(['Dipendenti']),
                'allows_general_subprocessors' => false,
                'signed_at' => '2024-03-28 07:17:29',
                'valid_until' => '2027-03-28',
                'model_id' => null,
                'model_type' => null,
                'company_id' => $companyUuid,
                'created_at' => '2026-03-28 07:17:29',
                'updated_at' => '2026-03-28 07:17:29',
            ],
            [
                'id' => 4,
                'name' => 'DPA backup e disaster recovery',
                'status' => 'draft',
                'processing_nature_and_purpose' => 'Replica dati in EU-West per continuità operativa.',
                'data_categories' => json_encode(['Dati aziendali classificati']),
                'data_subjects' => json_encode(['Dipendenti', 'Clienti']),
                'allows_general_subprocessors' => false,
                'signed_at' => null,
                'valid_until' => null,
                'model_id' => null,
                'model_type' => null,
                'company_id' => $companyUuid,
                'created_at' => '2026-03-28 07:17:29',
                'updated_at' => '2026-03-28 07:17:29',
            ],
        ];

        DB::table('client_dpas')->insert($dpas);
    }
}
