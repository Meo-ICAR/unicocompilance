<?php

namespace App\Models\COMPILANCE;

use App\Models\PROFORMA\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientDpa extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql_compliance';

    protected $table = 'client_dpas';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'bigint';

    protected $fillable = [
        'id',
        'name',
        'status',
        'processing_nature_and_purpose',
        'data_categories',
        'data_subjects',
        'allows_general_subprocessors',
        'signed_at',
        'valid_until',
        'model_id',
        'model_type',
        'company_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'data_categories' => 'json',
        'data_subjects' => 'json',
        'allows_general_subprocessors' => 'boolean',
        'signed_at' => 'datetime',
        'valid_until' => 'date',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function model(): MorphTo
    {
        return $this->morphTo('model');
    }

    // Scopes for common status queries
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeValidUntil($query, $date)
    {
        return $query->whereDate('valid_until', '<=', $date);
    }
}
