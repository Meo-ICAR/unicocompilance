<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OAM\OamScope;

class OamScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oamScopes = [
            [
                'code' => 'A.1',
                'name' => 'Mutui',
                'description' => 'A.1 Mutui',
                'tipo_prodotto' => json_encode(['Mutuo']),
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 10:53:30',
            ],
            [
                'code' => 'A.2',
                'name' => 'Cessioni del V dello stipendio/pensione e delegazioni di pagamento',
                'description' => 'A.2 Cessioni del V dello stipendio/pensione e delegazioni di pagamento',
                'tipo_prodotto' => json_encode(['Cessione', 'Delega']),
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 10:47:47',
            ],
            [
                'code' => 'A.3',
                'name' => 'Factoring crediti',
                'description' => 'A.3 Factoring crediti',
                'tipo_prodotto' => json_encode(['Factoring']),
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 10:46:53',
            ],
            [
                'code' => 'A.4',
                'name' => 'Acquisto di crediti',
                'description' => 'A.4 Acquisto di crediti',
                'tipo_prodotto' => json_encode(['Aziendale']),
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 10:53:46',
            ],
            [
                'code' => 'A.4 bis',
                'name' => 'Anticipazione TFS',
                'description' => 'A.4 bis Anticipazione TFS',
                'tipo_prodotto' => json_encode(['TFS']),
                'created_at' => '2026-03-23 08:21:28',
                'updated_at' => '2026-03-23 10:54:07',
            ],
            [
                'code' => 'A.5',
                'name' => 'Leasing autoveicoli e aeronavali',
                'description' => 'A.5 Leasing autoveicoli e aeronavali',
                'tipo_prodotto' => json_encode(['Leasing']),
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 10:46:53',
            ],
            [
                'code' => 'A.6',
                'name' => 'Leasing immobiliare',
                'description' => 'A.6 Leasing immobiliare',
                'tipo_prodotto' => json_encode(['Leasing']),
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 10:46:53',
            ],
            [
                'code' => 'A.7',
                'name' => 'Leasing strumentale',
                'description' => 'A.7 Leasing strumentale',
                'tipo_prodotto' => json_encode(['Leasing']),
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 10:46:53',
            ],
            [
                'code' => 'A.8',
                'name' => 'Leasing su fonti rinnovabili ed altre tipologie di investimento',
                'description' => 'A.8 Leasing su fonti rinnovabili ed altre tipologie di investimento',
                'tipo_prodotto' => null,
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 08:06:44',
            ],
            [
                'code' => 'A.9',
                'name' => 'Aperture di credito in conto corrente',
                'description' => 'A.9 Aperture di credito in conto corrente',
                'tipo_prodotto' => null,
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 08:06:44',
            ],
            [
                'code' => 'A.10',
                'name' => 'Credito personale',
                'description' => 'A.10 Credito personale',
                'tipo_prodotto' => json_encode(['Prestito']),
                'created_at' => '2026-03-23 08:15:48',
                'updated_at' => '2026-03-23 08:15:48',
            ],
            [
                'code' => 'A.11',
                'name' => 'Credito finalizzato',
                'description' => 'A.11 Credito finalizzato',
                'tipo_prodotto' => json_encode(['Prestito']),
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 08:06:44',
            ],
            [
                'code' => 'A.12',
                'name' => 'Prestito su pegno',
                'description' => 'A.12 Prestito su pegno',
                'tipo_prodotto' => json_encode(['Prestito']),
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 08:06:44',
            ],
            [
                'code' => 'A.13',
                'name' => 'Rilascio di fidejussioni e garanzie',
                'description' => 'A.13 Rilascio di fidejussioni e garanzie',
                'tipo_prodotto' => null,
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 08:06:44',
            ],
            [
                'code' => 'A.13-bis',
                'name' => 'Garanzia collettiva dei fidi',
                'description' => 'A.13-bis Garanzia collettiva dei fidi',
                'tipo_prodotto' => null,
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 08:06:44',
            ],
            [
                'code' => 'A.14',
                'name' => 'Anticipi e sconti commerciali',
                'description' => 'A.14 Anticipi e sconti commerciali',
                'tipo_prodotto' => null,
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 08:06:44',
            ],
            [
                'code' => 'A.15',
                'name' => 'Credito revolving',
                'description' => 'A.15 Credito revolving',
                'tipo_prodotto' => null,
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 08:06:44',
            ],
            [
                'code' => 'A.16',
                'name' => 'Ristrutturazione dei crediti (art. 128-quater decies, del TUB)',
                'description' => 'A.16 Ristrutturazione dei crediti (art. 128-quater decies, del TUB)',
                'tipo_prodotto' => null,
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 08:06:44',
            ],
            [
                'code' => 'Consulenza',
                'name' => ' ',
                'description' => 'Consulenza  ',
                'tipo_prodotto' => null,
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 08:06:44',
            ],
            [
                'code' => 'Segnalazione mutuo',
                'name' => ' ',
                'description' => 'Segnalazione mutuo  ',
                'tipo_prodotto' => null,
                'created_at' => '2026-03-23 08:06:44',
                'updated_at' => '2026-03-23 08:06:44',
            ],
        ];

        foreach ($oamScopes as $scope) {
            OamScope::create($scope);
        }
    }
}
