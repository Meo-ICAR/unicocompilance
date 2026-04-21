<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessingActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'bpm_process_id',
        'company_id',
        'name',
        'purpose',
        'lawful_basis',
        'data_subjects_categories',
        'personal_data_categories',
        'recipients_categories',
        'retention_period',
        'transfers_outside_eu',
        'transfer_safeguards',
        'security_measures_description',
        'requires_dpia',
        'dpia_id',
        'last_reviewed_at',
    ];

    protected $casts = [
        'data_subjects_categories' => 'array',
        'personal_data_categories' => 'array',
        'recipients_categories' => 'array',
        'transfers_outside_eu' => 'boolean',
        'requires_dpia' => 'boolean',
        'last_reviewed_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function dpia()
    {
        return $this->belongsTo(Dpia::class);
    }

    public function dpas()
    {
        return $this->belongsToMany(Dpa::class, 'dpa_processing_activity');
    }

    public function scopeRequiresDpia($query)
    {
        return $query->where('requires_dpia', true);
    }

    public function scopeTransfersOutsideEu($query)
    {
        return $query->where('transfers_outside_eu', true);
    }

    public function needsReview(): bool
    {
        return $this->last_reviewed_at && $this->last_reviewed_at->addYear()->isPast();
    }

    public function getDaysSinceLastReview(): ?int
    {
        if (!$this->last_reviewed_at) {
            return null;
        }

        return now()->diffInDays($this->last_reviewed_at);
    }
}
