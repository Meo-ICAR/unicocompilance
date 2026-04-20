<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Esegui con: php artisan db:seed
     * Oppure singolarmente: php artisan db:seed --class=ComplaintSeeder
     */
    public function run(): void
    {
        $this->call([
            GdprDataBreachSeeder::class,
            GdprDsrRequestSeeder::class,
            AmlSosReportSeeder::class,
            ComplaintRegistrySeeder::class,
            ComplaintSeeder::class,
            SuspiciousActivityReportSeeder::class,
            TrainingRegistrySeeder::class,
            TrainingSessionSeeder::class,
            ConflictOfInterestSeeder::class,
            OamCodeSeeder::class,
            OamScopeSeeder::class,
            ClientTypeSeeder::class,
            SoftwareCategorySeeder::class,
            CompanyBranchSeeder::class,
            EmployeeSeeder::class,
            ClientiSeeder::class,
            ClientiEmployeeSeeder::class,
        ]);
    }
}
