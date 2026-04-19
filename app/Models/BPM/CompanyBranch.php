<?php

namespace App\Models\BPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class CompanyBranch extends Model
{
    // use HasFactory;
    protected $connection = 'bpm';

    protected $fillable = [
        'company_id',
        'name',
        'is_main_office',
        'manager_first_name',
        'manager_last_name',
        'manager_tax_code',
    ];

    protected $casts = [
        'is_main_office' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
