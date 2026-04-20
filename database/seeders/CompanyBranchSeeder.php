<?php

namespace Database\Seeders;

use App\Models\COMPILANCE\CompanyBranch;
use App\Models\PROFORMA\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanyBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        CompanyBranch::query()->delete();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Get some sample companies or create them if they don't exist
        $companies = Company::all();
        
        if ($companies->isEmpty()) {
            $this->command->warn('No companies found. Please run a company seeder first.');
            return;
        }
        
        $companyBranches = [];
        
        foreach ($companies as $company) {
            // Create 1-3 branches per company
            $branchCount = rand(1, 3);
            
            for ($i = 0; $i < $branchCount; $i++) {
                $isMainOffice = $i === 0; // First branch is always the main office
                
                $companyBranches[] = [
                    'company_id' => $company->id,
                    'name' => $this->generateBranchName($company->name, $i, $isMainOffice),
                    'is_main_office' => $isMainOffice,
                    'manager_first_name' => $this->generateFirstName(),
                    'manager_last_name' => $this->generateLastName(),
                    'manager_tax_code' => $this->generateTaxCode(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Insert all branches in bulk
        if (!empty($companyBranches)) {
            CompanyBranch::insert($companyBranches);
            
            $this->command->info('Company branches seeded successfully!');
            $this->command->info('Total branches created: ' . count($companyBranches));
        }
    }
    
    /**
     * Generate a branch name based on company name and position
     */
    private function generateBranchName(string $companyName, int $index, bool $isMainOffice): string
    {
        if ($isMainOffice) {
            return 'Sede Legale';
        }
        
        $branchTypes = [
            'Sede Operativa',
            'Filiale',
            'Ufficio',
            'Sportello',
            'Agenzia',
        ];
        
        $cities = [
            'Milano',
            'Roma',
            'Torino',
            'Napoli',
            'Bologna',
            'Firenze',
            'Genova',
            'Bari',
            'Palermo',
            'Verona',
            'Padova',
            'Brescia',
        ];
        
        $type = $branchTypes[array_rand($branchTypes)];
        $city = $cities[array_rand($cities)];
        
        return "{$type} {$city}";
    }
    
    /**
     * Generate a random Italian first name
     */
    private function generateFirstName(): string
    {
        $firstNames = [
            'Marco', 'Giuseppe', 'Antonio', 'Giovanni', 'Paolo',
            'Francesco', 'Roberto', 'Luca', 'Alessandro', 'Matteo',
            'Andrea', 'Lorenzo', 'Davide', 'Simone', 'Stefano',
            'Maria', 'Giulia', 'Sofia', 'Aurora', 'Alice',
            'Giorgia', 'Martina', 'Chiara', 'Sara', 'Valentina',
        ];
        
        return $firstNames[array_rand($firstNames)];
    }
    
    /**
     * Generate a random Italian last name
     */
    private function generateLastName(): string
    {
        $lastNames = [
            'Rossi', 'Bianchi', 'Ferrari', 'Esposito', 'Colombo',
            'Ricci', 'Marino', 'Greco', 'Bruno', 'Gallo',
            'Conti', 'De Luca', 'Costa', 'Giordano', 'Mancini',
            'Rizzo', 'Lombardi', 'Moretti', 'Barbieri', 'Fontana',
            'Santoro', 'Mariani', 'Rinaldi', 'Caruso', 'Ferrara',
        ];
        
        return $lastNames[array_rand($lastNames)];
    }
    
    /**
     * Generate a fake Italian tax code (Codice Fiscale)
     * This is a simplified version for demo purposes
     */
    private function generateTaxCode(): string
    {
        // Generate 16 characters tax code (simplified)
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        
        $taxCode = '';
        
        // 3 letters for surname (simplified)
        for ($i = 0; $i < 3; $i++) {
            $taxCode .= $letters[rand(0, strlen($letters) - 1)];
        }
        
        // 3 letters for name (simplified)
        for ($i = 0; $i < 3; $i++) {
            $taxCode .= $letters[rand(0, strlen($letters) - 1)];
        }
        
        // 2 numbers for birth year (last 2 digits)
        $taxCode .= rand(50, 99);
        
        // 1 letter for birth month
        $taxCode .= $letters[rand(0, strlen($letters) - 1)];
        
        // 2 numbers for birth day
        $taxCode .= str_pad(rand(1, 31), 2, '0', STR_PAD_LEFT);
        
        // 4 characters for municipality and check digit (simplified)
        for ($i = 0; $i < 4; $i++) {
            $taxCode .= rand(0, 1) ? $letters[rand(0, strlen($letters) - 1)] : $numbers[rand(0, strlen($numbers) - 1)];
        }
        
        return $taxCode;
    }
}
