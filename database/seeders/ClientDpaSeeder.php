<?php

namespace Database\Seeders;

use App\Models\COMPILANCE\ClientDpa;
use App\Models\PROFORMA\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientDpaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        ClientDpa::query()->delete();

        // Get the first company to satisfy foreign key constraints
        $company = Company::first();
        if (!$company) {
            $this->command->error('No company found. Please run CompanySeeder first.');
            return;
        }

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
                'model_id' => '',
                'model_type' => '1',
                'company_id' => $company->id,
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
                'model_id' => '',
                'model_type' => '2',
                'company_id' => $company->id,
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
                'model_id' => '',
                'model_type' => '3',
                'company_id' => $company->id,
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
                'model_id' => '',
                'model_type' => '4',
                'company_id' => $company->id,
                'created_at' => '2026-03-28 07:17:29',
                'updated_at' => '2026-03-28 07:17:29',
            ],
        ];

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($dpas, 100) as $chunk) {
            DB::connection('mariadb')->table('client_dpas')->insert($chunk);
        }

        $this->command->info(count($dpas) . ' DPA records created.');
    }
}
