<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GdprDsrRequestSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = '3ff53405-4abb-4468-bff5-f9493badac5b';

        $requests = [
            [
                'company_id'          => $companyId,
                'request_type'        => 'access',
                'subject_name'        => 'Mario Rossi',
                'received_at'         => '2026-01-05 10:00:00',
                'due_date'            => '2026-02-04 10:00:00',
                'unicodoc_request_id' => null,
                'status'              => 'fulfilled',
            ],
            [
                'company_id'          => $companyId,
                'request_type'        => 'erasure',
                'subject_name'        => 'Giulia Bianchi',
                'received_at'         => '2026-02-10 09:30:00',
                'due_date'            => '2026-03-12 09:30:00',
                'unicodoc_request_id' => null,
                'status'              => 'pending',
            ],
            [
                'company_id'          => $companyId,
                'request_type'        => 'rectification',
                'subject_name'        => 'Luca Verdi',
                'received_at'         => '2026-03-01 14:00:00',
                'due_date'            => '2026-03-31 14:00:00',
                'unicodoc_request_id' => 1001,
                'status'              => 'fulfilled',
            ],
            [
                'company_id'          => $companyId,
                'request_type'        => 'portability',
                'subject_name'        => 'Anna Neri',
                'received_at'         => '2026-03-15 11:00:00',
                'due_date'            => '2026-04-14 11:00:00',
                'unicodoc_request_id' => null,
                'status'              => 'extended',
            ],
            [
                'company_id'          => $companyId,
                'request_type'        => 'objection',
                'subject_name'        => 'Roberto Ferrari',
                'received_at'         => '2026-04-01 08:00:00',
                'due_date'            => '2026-05-01 08:00:00',
                'unicodoc_request_id' => null,
                'status'              => 'pending',
            ],
            [
                'company_id'          => $companyId,
                'request_type'        => 'erasure',
                'subject_name'        => 'Carla Esposito',
                'received_at'         => '2025-12-01 10:00:00',
                'due_date'            => '2025-12-31 10:00:00',
                'unicodoc_request_id' => null,
                'status'              => 'rejected',
            ],
        ];

        foreach ($requests as $request) {
            DB::connection('mysql_compliance')->table('gdpr_dsr_requests')->insert(array_merge($request, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
