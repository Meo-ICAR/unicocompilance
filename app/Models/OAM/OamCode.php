<?php

namespace App\Models\OAM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OamCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'fase',
        'name',
    ];

    protected $casts = [
        'fase' => 'string',
    ];

    // Constants for phases
    const PHASES = [
        '1-Procacciamento' => '1-Procacciamento',
        '2-Trasparenza' => '2-Trasparenza',
        '3-Mediazione' => '3-Mediazione',
    ];

    public function practiceOams(): HasMany
    {
        return $this->hasMany(PracticeOam::class, 'oam_code_id');
    }

    public function getPhaseLabelAttribute(): string
    {
        return self::PHASES[$this->fase] ?? $this->fase;
    }
}
