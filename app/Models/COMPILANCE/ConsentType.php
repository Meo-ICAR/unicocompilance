<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ConsentType extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_mandatory',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeMandatory($query)
    {
        return $query->where('is_mandatory', true);
    }

    public function scopeOptional($query)
    {
        return $query->where('is_mandatory', false);
    }
}
