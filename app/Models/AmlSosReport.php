<?php

/**
 * SCOPO: Modello per la gestione delle pratiche AML, con Audit Trail e Relazioni Cross-DB.
 * PATH: app/Models/AmlSosReport.php
 * CONSTRAINTS:
 * - Connessione 'mysql_compliance'.
 * - Spatie Activitylog configurato.
 * - Relazione BelongsTo logica verso il Proxy Model Agent.
 */

namespace App\Models;

use App\Enums\AmlReportStatus;
use App\Models\External\BPM\Agent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AmlSosReport extends Model
{
    use SoftDeletes, LogsActivity;

    protected $connection = 'mysql_compliance';

    protected $fillable = [
        'company_id', 'agent_id', 'practice_reference', 'suspicion_indicators',
        'internal_evaluation', 'forwarded_to_fiu', 'fiu_protocol_number',
        'receipt_document_id', 'status'
    ];

    protected function casts(): array
    {
        return [
            'suspicion_indicators' => 'array',
            'forwarded_to_fiu' => 'boolean',
            'status' => AmlReportStatus::class,  // PHP 8.4 Enum casting
        ];
    }

    // Configurazione Spatie Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('aml_compliance');
    }

    // Relazione logica cross-database
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
