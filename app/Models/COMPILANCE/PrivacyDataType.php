<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivacyDataType extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'slug',
        'name',
        'category',
        'retention_years',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'retention_years' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeComuni($query)
    {
        return $query->where('category', 'comuni');
    }

    public function scopeParticolari($query)
    {
        return $query->where('category', 'particolari');
    }

    public function scopeGiudiziari($query)
    {
        return $query->where('category', 'giudiziari');
    }

    public function scopeByRetention($query, $years)
    {
        return $query->where('retention_years', $years);
    }

    public function scopeLongRetention($query, $years = 10)
    {
        return $query->where('retention_years', '>=', $years);
    }

    public function scopeShortRetention($query, $years = 5)
    {
        return $query->where('retention_years', '<=', $years);
    }

    public function getRetentionPeriodAttribute(): string
    {
        return $this->retention_years . ' ' . str('year', 'anni', $this->retention_years);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'comuni' => 'Dati Comuni',
            'particolari' => 'Dati Particolari',
            'giudiziari' => 'Dati Giudiziari',
            default => $this->category
        };
    }

    public function getCategoryColorAttribute(): string
    {
        return match ($this->category) {
            'comuni' => 'blue',
            'particolari' => 'orange',
            'giudiziari' => 'red',
            default => 'gray'
        };
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\BPM\Employee::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\BPM\Employee::class, 'updated_by');
    }

    public static function getCategories(): array
    {
        return [
            'comuni' => 'Dati Comuni',
            'particolari' => 'Dati Particolari',
            'giudiziari' => 'Dati Giudiziari',
        ];
    }
}
