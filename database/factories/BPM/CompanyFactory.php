<?php

namespace Database\Factories\BPM;

use App\Models\BPM\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'name' => $this->faker->company(),
            'domain' => $this->faker->domainName(),
            'vat_number' => $this->faker->numerify('IT###########'),
            'vat_name' => $this->faker->company(),
        ];
    }
}
