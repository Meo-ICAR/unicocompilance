<?php

namespace Database\Seeders;

use App\Models\COMPILANCE\Authorization;
use Illuminate\Database\Seeder;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use fixed company UUID since companies table is in different database
        $companyUuid = '5c044917-15b3-4471-90c9-38061fcca754';

        $authorizations = [
            [
                'id' => 1,
                'company_id' => $companyUuid,
                'name' => 'Autorizzato HR',
                'description' => 'Accesso ai trattamenti e ai fascicoli del personale.',
                'created_at' => '2026-03-28 07:17:28',
                'updated_at' => '2026-03-28 07:17:28',
            ],
            [
                'id' => 2,
                'company_id' => $companyUuid,
                'name' => 'Autorizzato IT',
                'description' => 'Gestione infrastruttura, account e log di sicurezza.',
                'created_at' => '2026-03-28 07:17:28',
                'updated_at' => '2026-03-28 07:17:28',
            ],
        ];

        foreach ($authorizations as $auth) {
            Authorization::create($auth);
        }

        $this->command->info(count($authorizations) . ' authorization records created.');
    }
}
