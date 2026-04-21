<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Dpa extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'company_id',
        'client_id',
        'title',
        'status',
        'processing_nature_and_purpose',
        'data_categories',
        'data_subjects',
        'allows_general_subprocessors',
        'signed_at',
        'valid_until',
    ];

    protected $casts = [
        'data_categories' => 'array',
        'data_subjects' => 'array',
        'allows_general_subprocessors' => 'boolean',
        'signed_at' => 'datetime',
        'valid_until' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function client()
    {
        return $this->belongsTo(\App\Models\PROFORMA\Clienti::class, 'client_id');
    }

    public function processingActivities()
    {
        return $this->belongsToMany(ProcessingActivity::class, 'dpa_processing_activity');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<', now());
    }

    public function isExpired(): bool
    {
        return $this->valid_until && $this->valid_until->isPast();
    }

    public function getDaysUntilExpiry(): ?int
    {
        if (!$this->valid_until) {
            return null;
        }

        return now()->diffInDays($this->valid_until, false);
    }
}
