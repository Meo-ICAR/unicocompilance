<?php

namespace Database\Seeders;

use App\Models\COMPILANCE\SoftwareCategory;
use Illuminate\Database\Seeder;

class SoftwareCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'CRM',
                'code' => 'CRM',
                'description' => 'Customer Relationship Management',
            ],
            [
                'name' => 'Contabilità',
                'code' => 'COG',
                'description' => 'Sistemi Contabili',
            ],
            [
                'name' => 'Firma Elettronica',
                'code' => 'SIGN',
                'description' => 'Servizi di Firma Digitale',
            ],
            [
                'name' => 'Documentale',
                'code' => 'DOC',
                'description' => 'Conservazione Documentale',
            ],
            [
                'name' => 'Call Center',
                'code' => 'CAL',
                'description' => 'Call Center',
            ],
            [
                'name' => 'Creditizie',
                'code' => 'IC',
                'description' => 'Informazioni creditizie',
            ],
        ];

        foreach ($categories as $category) {
            SoftwareCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
