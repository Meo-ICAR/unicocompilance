<?php

namespace App\Models\COMPILANCE;

use App\Models\PROFORMA\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Mattiverse\Userstamps\HasUserstamps;

class GdprDataBreach extends Model
{
    use SoftDeletes;  // , HasUserstamps;

    protected $fillable = [
        'company_id',
        'incident_date',
        'discovery_date',
        'nature_of_breach',
        'subjects_affected_count',
        'is_notified_to_authority',
        'notification_date',
        'containment_measures',
        'status',
    ];

    protected $casts = [
        'incident_date' => 'datetime',
        'discovery_date' => 'datetime',
        'notification_date' => 'datetime',
        'is_notified_to_authority' => 'boolean',
        'subjects_affected_count' => 'integer',
    ];

    // Constants for enums
    const NATURE_OF_BREACH_TYPES = [
        'unauthorized_access' => 'Accesso Non Autorizzato',
        'data_loss' => 'Perdita Dati',
        'ransomware' => 'Ransomware',
        'phishing' => 'Phishing',
        'malware' => 'Malware',
        'physical_theft' => 'Furto Fisico',
        'human_error' => 'Errore Umano',
        'other' => 'Altro',
    ];

    const STATUS_TYPES = [
        'investigating' => 'In Investigazione',
        'contained' => 'Contenuto',
        'closed' => 'Chiuso',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
