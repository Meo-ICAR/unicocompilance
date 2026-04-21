<?php

namespace App\Models\COMPILANCE;

use App\Models\PROFORMA\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Authorization extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'company_id',
        'name',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
