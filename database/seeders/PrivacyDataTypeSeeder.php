<?php

namespace Database\Seeders;

use App\Models\COMPILANCE\PrivacyDataType;
use Illuminate\Database\Seeder;

class PrivacyDataTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataTypes = [
            [
                'id' => 1,
                'slug' => 'ID_BASE',
                'name' => 'Dati Anagrafici di Base',
                'category' => 'comuni',
                'retention_years' => 10,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => '2026-04-11 04:10:50',
                'updated_at' => '2026-04-11 04:10:50',
            ],
            [
                'id' => 2,
                'slug' => 'ID_GOV',
                'name' => 'Documenti di Identità / Codice Fiscale',
                'category' => 'comuni',
                'retention_years' => 10,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => '2026-04-11 04:10:50',
                'updated_at' => '2026-04-11 04:10:50',
            ],
            [
                'id' => 3,
                'slug' => 'FIN_BANK',
                'name' => 'Coordinate Bancarie (IBAN)',
                'category' => 'comuni',
                'retention_years' => 10,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => '2026-04-11 04:10:50',
                'updated_at' => '2026-04-11 04:10:50',
            ],
            [
                'id' => 4,
                'slug' => 'FIN_CREDIT',
                'name' => 'Merito Creditizio / CRIF',
                'category' => 'comuni',
                'retention_years' => 5,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => '2026-04-11 04:10:50',
                'updated_at' => '2026-04-11 04:10:50',
            ],
            [
                'id' => 5,
                'slug' => 'HEALTH_DATA',
                'name' => 'Stato di Salute / Dati Sanitari',
                'category' => 'particolari',
                'retention_years' => 10,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => '2026-04-11 04:10:50',
                'updated_at' => '2026-04-11 04:10:50',
            ],
            [
                'id' => 6,
                'slug' => 'POLITICAL_REL',
                'name' => 'Cariche Politiche (PEP) / Sindacali',
                'category' => 'particolari',
                'retention_years' => 10,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => '2026-04-11 04:10:50',
                'updated_at' => '2026-04-11 04:10:50',
            ],
            [
                'id' => 7,
                'slug' => 'CRIMINAL_REC',
                'name' => 'Casellario Giudiziale',
                'category' => 'giudiziari',
                'retention_years' => 10,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => '2026-04-11 04:10:50',
                'updated_at' => '2026-04-11 04:10:50',
            ],
        ];

        foreach ($dataTypes as $dataType) {
            PrivacyDataType::create($dataType);
        }

        $this->command->info(count($dataTypes) . ' privacy data type records created.');
    }
}
