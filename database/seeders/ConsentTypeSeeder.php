<?php

namespace Database\Seeders;

use App\Models\COMPILANCE\ConsentType;
use Illuminate\Database\Seeder;

class ConsentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consentTypes = [
            [
                'id' => 1,
                'code' => 'newsletter',
                'name' => 'Newsletter',
                'description' => 'Iscrizione alla newsletter aziendale e comunicazioni periodiche.',
                'is_mandatory' => false,
                'created_at' => '2026-03-28 07:17:28',
                'updated_at' => '2026-03-28 07:17:28',
            ],
            [
                'id' => 2,
                'code' => 'marketing_profilato',
                'name' => 'Marketing profilato',
                'description' => 'Analisi delle preferenze per offerte personalizzate.',
                'is_mandatory' => false,
                'created_at' => '2026-03-28 07:17:28',
                'updated_at' => '2026-03-28 07:17:28',
            ],
            [
                'id' => 3,
                'code' => 'termini_servizio',
                'name' => 'Termini di servizio',
                'description' => 'Accettazione dei termini di utilizzo dei sistemi informativi.',
                'is_mandatory' => true,
                'created_at' => '2026-03-28 07:17:28',
                'updated_at' => '2026-03-28 07:17:28',
            ],
        ];

        foreach ($consentTypes as $type) {
            ConsentType::create($type);
        }

        $this->command->info(count($consentTypes) . ' consent type records created.');
    }
}
