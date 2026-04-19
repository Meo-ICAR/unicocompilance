<?php

namespace App\Models;

use App\Models\BPM\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Mattiverse\Userstamps\HasUserstamps;

class GdprDsrRequest extends Model
{
    use SoftDeletes;  // , HasUserstamps;

    protected $fillable = [
        'company_id',
        'request_type',
        'subject_name',
        'received_at',
        'due_date',
        'unicodoc_request_id',
        'status',
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'due_date' => 'datetime',
        'unicodoc_request_id' => 'integer',
    ];

    // Constants for enums
    const REQUEST_TYPES = [
        'access' => 'Accesso ai Dati',
        'rectification' => 'Rettifica Dati',
        'erasure' => 'Cancellazione Dati',
        'portability' => 'Portabilità Dati',
        'restriction' => 'Limitazione Trattamento',
        'objection' => 'Opposizione al Trattamento',
    ];

    const STATUS_TYPES = [
        'pending' => 'In Attesa',
        'extended' => 'Esteso',
        'fulfilled' => 'Evaso',
        'rejected' => 'Rifiutato',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
