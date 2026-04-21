<?php

namespace Database\Seeders;

use App\Models\COMPILANCE\PrivacyLegalBase;
use Illuminate\Database\Seeder;

class PrivacyLegalBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $legalBases = [
            [
                'id' => 1,
                'name' => 'Consenso',
                'reference_article' => 'Art. 6 par. 1 lett. a)',
                'description' => "L'interessato ha espresso il consenso al trattamento dei propri dati personali per una o più specifiche finalità.",
                'created_at' => '2026-04-11 04:10:52',
                'updated_at' => '2026-04-11 04:10:52',
            ],
            [
                'id' => 2,
                'name' => 'Esecuzione Contratto',
                'reference_article' => 'Art. 6 par. 1 lett. b)',
                'description' => "Il trattamento è necessario all'esecuzione di un contratto di cui l'interessato è parte o all'esecuzione di misure precontrattuali.",
                'created_at' => '2026-04-11 04:10:52',
                'updated_at' => '2026-04-11 04:10:52',
            ],
            [
                'id' => 3,
                'name' => 'Obbligo Legale',
                'reference_article' => 'Art. 6 par. 1 lett. c)',
                'description' => 'Il trattamento è necessario per adempiere un obbligo legale al quale è soggetto il titolare del trattamento.',
                'created_at' => '2026-04-11 04:10:52',
                'updated_at' => '2026-04-11 04:10:52',
            ],
            [
                'id' => 4,
                'name' => 'Interesse Vitale',
                'reference_article' => 'Art. 6 par. 1 lett. d)',
                'description' => "Il trattamento è necessario per la salvaguardia degli interessi vitali dell'interessato o di un'altra persona fisica.",
                'created_at' => '2026-04-11 04:10:52',
                'updated_at' => '2026-04-11 04:10:52',
            ],
            [
                'id' => 5,
                'name' => 'Interesse Pubblico',
                'reference_article' => 'Art. 6 par. 1 lett. e)',
                'description' => "Il trattamento è necessario per l'esecuzione di un compito di interesse pubblico o connesso all'esercizio di pubblici poteri.",
                'created_at' => '2026-04-11 04:10:52',
                'updated_at' => '2026-04-11 04:10:52',
            ],
            [
                'id' => 6,
                'name' => 'Legittimo Interesse',
                'reference_article' => 'Art. 6 par. 1 lett. f)',
                'description' => 'Il trattamento è necessario per il perseguimento del legittimo interesse del titolare del trattamento o di terzi.',
                'created_at' => '2026-04-11 04:10:52',
                'updated_at' => '2026-04-11 04:10:52',
            ],
        ];

        foreach ($legalBases as $legalBase) {
            PrivacyLegalBase::create($legalBase);
        }

        $this->command->info(count($legalBases) . ' privacy legal base records created.');
    }
}
