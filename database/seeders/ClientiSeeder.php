<?php

namespace Database\Seeders;

use App\Models\PROFORMA\Clienti;
use App\Models\PROFORMA\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first company to satisfy foreign key constraints
        $company = Company::first();
        if (!$company) {
            $this->command->error('No company found. Please run CompanySeeder first.');
            return;
        }

        // Create some basic client records
        $clients = [
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Vitanuova spa',
                'business_name' => 'Vitanuova spa',
                'customertype_id' => 1, // Assuming ClientType with ID 1 exists
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'ING BANK spa',
                'business_name' => 'ING BANK spa',
                'customertype_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'IFIS spa',
                'business_name' => 'IFIS spa',
                'customertype_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'BANCA POPOLARE DI PUGLIA E BASILICATA',
                'business_name' => 'BANCA POPOLARE DI PUGLIA E BASILICATA',
                'customertype_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'MK CAPITAL',
                'business_name' => 'MK CAPITAL',
                'customertype_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert in chunks
        foreach (array_chunk($clients, 100) as $chunk) {
            DB::connection('mariadb')->table('clientis')->insert($chunk);
        }

        $this->command->info(count($clients) . ' client records created.');
    }
}
