<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = '3ff53405-4abb-4468-bff5-f9493badac5b';

        $complaints = [
            [
                'company_id'  => $companyId,
                'client_id'   => 1,
                'employee_id' => null,
                'received_at' => '2025-10-05',
                'subject'     => 'Ritardo nella liquidazione sinistro auto',
                'description' => 'Il cliente segnala un ritardo di oltre 45 giorni nella liquidazione del sinistro auto n. SIN-2025-0891, nonostante tutta la documentazione sia stata consegnata in data 20/09/2025.',
                'status'      => 'in_lavorazione',
                'resolved_at' => null,
            ],
            [
                'company_id'  => $companyId,
                'client_id'   => 2,
                'employee_id' => 3,
                'received_at' => '2025-11-12',
                'subject'     => 'Comportamento scorretto del consulente',
                'description' => 'La cliente riferisce che durante il colloquio del 10/11/2025 il consulente ha utilizzato toni aggressivi e ha fornito informazioni errate sulle condizioni della polizza vita.',
                'status'      => 'ricevuto',
                'resolved_at' => null,
            ],
            [
                'company_id'  => $companyId,
                'client_id'   => 3,
                'employee_id' => null,
                'received_at' => '2025-09-01',
                'subject'     => 'Addebito non autorizzato',
                'description' => 'Il cliente contesta un addebito di €450,00 relativo a una polizza accessoria mai richiesta, apparsa in estratto conto a partire da luglio 2025.',
                'status'      => 'accolto',
                'resolved_at' => '2025-10-15',
            ],
            [
                'company_id'  => $companyId,
                'client_id'   => 4,
                'employee_id' => null,
                'received_at' => '2026-01-08',
                'subject'     => 'Mancata risposta a richiesta di recesso',
                'description' => 'La cliente ha inviato richiesta di recesso in data 15/12/2025 tramite raccomandata A/R. A distanza di 30 giorni non ha ricevuto alcuna risposta né conferma di ricezione.',
                'status'      => 'ricevuto',
                'resolved_at' => null,
            ],
            [
                'company_id'  => $companyId,
                'client_id'   => 5,
                'employee_id' => 2,
                'received_at' => '2025-07-20',
                'subject'     => 'Errore nel calcolo del premio',
                'description' => 'Il cliente segnala un errore nel calcolo del premio annuale della polizza RC professionale, con un sovrapprezzo non giustificato di €320,00 rispetto al preventivo accettato.',
                'status'      => 'respinto',
                'resolved_at' => '2025-08-30',
            ],
        ];

        foreach ($complaints as $complaint) {
            DB::connection('mysql_compliance')->table('complaints')->insert(array_merge($complaint, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
