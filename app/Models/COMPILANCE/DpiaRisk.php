<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DpiaRisk extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'dpia_id',
        'risk_type',
        'description',
        'initial_probability',
        'initial_severity',
        'initial_score',
        'mitigation_measures',
        'residual_probability',
        'residual_severity',
        'residual_score',
    ];

    protected $casts = [
        'initial_probability' => 'integer',
        'initial_severity' => 'integer',
        'initial_score' => 'integer',
        'residual_probability' => 'integer',
        'residual_severity' => 'integer',
        'residual_score' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function dpia()
    {
        return $this->belongsTo(Dpia::class);
    }

    public function getRiskLevelAttribute(): string
    {
        $score = $this->residual_score ?? $this->initial_score;

        if ($score <= 4)
            return 'low';
        if ($score <= 9)
            return 'medium';
        if ($score <= 16)
            return 'high';
        return 'critical';
    }

    public function getRiskColorAttribute(): string
    {
        $level = $this->risk_level;

        return match ($level) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray'
        };
    }
}
