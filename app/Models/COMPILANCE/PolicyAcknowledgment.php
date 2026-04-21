<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyAcknowledgment extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'policy_type',
        'policy_id',
        'policy_version_id',
        'acknowledged_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'acknowledged_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeByVersion($query, $versionId)
    {
        return $query->where('policy_version_id', $versionId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('policy_type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('acknowledged_at', '>=', now()->subDays($days));
    }

    public function getAcknowledgedFromAttribute(): string
    {
        return $this->acknowledged_at ? $this->acknowledged_at->diffForHumans() : 'Never';
    }
}
