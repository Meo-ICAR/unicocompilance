<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivacyPolicy extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'version',
        'content',
        'valid_from',
        'valid_until',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q
                ->whereNull('valid_until')
                ->orWhere('valid_until', '>', now());
        })->where('valid_from', '<=', now());
    }

    public function scopeValidAt($query, $date)
    {
        return $query
            ->where('valid_from', '<=', $date)
            ->where(function ($q) use ($date) {
                $q
                    ->whereNull('valid_until')
                    ->orWhere('valid_until', '>', $date);
            });
    }

    public function isValid(): bool
    {
        return $this->valid_from <= now() &&
            (!$this->valid_until || $this->valid_until > now());
    }

    public function isExpired(): bool
    {
        return $this->valid_until && $this->valid_until->isPast();
    }

    public function getValidityPeriodAttribute(): string
    {
        if (!$this->valid_until) {
            return 'From ' . $this->valid_from->format('Y-m-d') . ' (indefinite)';
        }

        return $this->valid_from->format('Y-m-d') . ' to ' . $this->valid_until->format('Y-m-d');
    }
}
