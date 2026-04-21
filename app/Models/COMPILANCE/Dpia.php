<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dpia extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'company_id',
        'process_name',
        'process_description',
        'necessity_assessment',
        'dpo_advice',
        'dpo_reviewed_at',
        'status',
        'next_review_date',
    ];

    protected $casts = [
        'necessity_assessment' => 'array',
        'dpo_reviewed_at' => 'datetime',
        'next_review_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function risks()
    {
        return $this->hasMany(DpiaRisk::class);
    }

    public function processingActivities()
    {
        return $this->hasMany(ProcessingActivity::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function needsReview(): bool
    {
        return $this->next_review_date && $this->next_review_date->isPast();
    }

    public function getDaysUntilReview(): ?int
    {
        if (!$this->next_review_date) {
            return null;
        }

        return now()->diffInDays($this->next_review_date, false);
    }
}
