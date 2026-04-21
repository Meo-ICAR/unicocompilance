<?php

namespace Database\Seeders;

use App\Models\COMPILANCE\CompanyPolicy;
use Illuminate\Database\Seeder;

class CompanyPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use fixed company ID since companies table is in different database
        $companyId = 1;

        $policies = [
            [
                'id' => 1,
                'company_id' => $companyId,
                'name' => 'Regolamento informatico',
                'description' => 'Uso accettabile di PC, account e dati aziendali.',
                'target_audience' => 'Tutti i dipendenti',
                'is_active' => true,
                'created_at' => '2026-03-28 07:17:28',
                'updated_at' => '2026-03-28 07:17:28',
            ],
            [
                'id' => 2,
                'company_id' => $companyId,
                'name' => 'Policy smart working',
                'description' => 'Regole per il lavoro agile e la protezione dei dati fuori sede.',
                'target_audience' => 'Personale abilitato al remoto',
                'is_active' => true,
                'created_at' => '2026-03-28 07:17:28',
                'updated_at' => '2026-03-28 07:17:28',
            ],
        ];

        foreach ($policies as $policy) {
            CompanyPolicy::create($policy);
        }

        $this->command->info(count($policies) . ' company policy records created.');
    }
}
