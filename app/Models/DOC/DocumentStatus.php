<?php

namespace App\Models\DOC;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class DocumentStatus extends Model
{
    protected $connection = 'doc';

    protected $fillable = [
        'name',
        'status',
        'is_ok',
        'is_rejected',
        'description',
    ];

    protected $casts = [
        'id' => 'integer',
        'is_ok' => 'boolean',
        'is_rejected' => 'boolean',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function isPositive(): bool
    {
        return $this->is_ok;
    }

    public function isNegative(): bool
    {
        return $this->is_rejected;
    }

    public function isPending(): bool
    {
        return !$this->is_ok && !$this->is_rejected;
    }
}
