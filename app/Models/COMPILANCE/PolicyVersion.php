<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyVersion extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'name',
        'content',
        'published_at',
        'requires_reacknowledgment',
        'company_id',
    ];

    protected $casts = [
        'requires_reacknowledgment' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function acknowledgments()
    {
        return $this->hasMany(PolicyAcknowledgment::class, 'policy_version_id');
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }

    public function scopeRequiresAcknowledgment($query)
    {
        return $query->where('requires_reacknowledgment', true);
    }

    public function isPublished(): bool
    {
        return $this->published_at && $this->published_at->isPast();
    }

    public function getVersionNumberAttribute(): string
    {
        return 'v' . $this->name;
    }
}
