<?php

namespace Database\Seeders;

use App\Models\BPM\Employee;
use App\Models\COMPILANCE\ClientiEmployee;
use App\Models\PROFORMA\Clienti;
use App\Models\PROFORMA\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientiEmployeeSeeder extends Seeder
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

        // Get some clients to assign employees to
        $clients = Clienti::limit(5)->get();
        if ($clients->isEmpty()) {
            $this->command->error('No clients found. Please run ClientSeeder first.');
            return;
        }

        // Get some employees to assign from bpm database
        $employees = DB::connection('bpm')->table('employees')->limit(10)->get();

        $clientiEmployees = [];
        $recordId = 100;  // Start from 100 to avoid conflicts with existing records

        foreach ($clients as $client) {
            // Assign 2-3 employees per client
            $assignedEmployees = $employees->random(min(3, $employees->count()));

            foreach ($assignedEmployees as $index => $employee) {
                $clientiEmployees[] = [
                    'id' => ++$recordId,
                    'clienti_id' => $client->id,
                    'company_id' => $company->id,
                    'personable_type' => Employee::class,
                    'personable_id' => $employee->id,
                    'num_iscr_intermediario' => $index === 0 ? 'INT' . rand(10000, 99999) : null,
                    'num_iscr_collaboratori_ii_liv' => $index === 1 ? 'COL' . rand(10000, 99999) : null,
                    'usercode' => 'EMP' . $employee->id,
                    'description' => "Impiegato assegnato a {$client->name}",
                    'start_date' => now()->subMonths(rand(1, 12))->format('Y-m-d'),
                    'end_date' => rand(0, 3) === 0 ? null : now()->addMonths(rand(6, 24))->format('Y-m-d'),
                    'is_active' => rand(0, 3) !== 0,  // 75% chance of being active
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($clientiEmployees, 100) as $chunk) {
            DB::connection('mariadb')->table('clienti_employees')->insert($chunk);
        }

        $this->command->info(count($clientiEmployees) . ' client employee records created.');
    }
}
