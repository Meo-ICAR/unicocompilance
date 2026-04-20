<?php

namespace App\Models\PROFORMA;

use App\Models\COMPILANCE\ClientType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Wildside\Userstamps\HasUserstamps;

class Clienti extends Model
{
    use HasFactory, SoftDeletes;  // , HasUserstamps;

    protected $connection = 'mysql_proforma';
    protected $table = 'clientis';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $orderBy = 'name';
    protected $orderDirection = 'asc';

    protected $fillable = [
        'abi',
        'abi_name',
        'stipulated_at',
        'dismissed_at',
        'type',
        'oam',
        'oam_name',
        'oam_at',
        'numero_iscrizione_rui',
        'ivass',
        'ivass_at',
        'ivass_name',
        'ivass_section',
        'mandate_number',
        'start_date',
        'end_date',
        'is_exclusive',
        'status',
        'notes',
        'principal_type',
        'submission_type',
        'website',
        'is_reported',
        'cf',
        'coge',
        'codice',
        'name',
        'nome',
        'piva',
        'email',
        'regione',
        'citta',
        'company_id',
        'customertype_id',
        'is_active',
        'is_dummy',
    ];

    protected $casts = [
        'stipulated_at' => 'date',
        'dismissed_at' => 'date',
        'oam_at' => 'date',
        'ivass_at' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_exclusive' => 'boolean',
        'status' => 'string',
        'principal_type' => 'string',
        'submission_type' => 'string',
        'is_reported' => 'boolean',
        'is_active' => 'boolean',
        'is_dummy' => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'is_exclusive' => false,
        'status' => 'ATTIVO',
        'principal_type' => 'banca',
        'submission_type' => 'accesso portale',
        'is_reported' => false,
        'is_active' => true,
        'is_dummy' => false,
        'company_id' => '5c044917-15b3-4471-90c9-38061fcca754',
    ];

    // Constants for enums
    const IVASS_SECTIONS = [
        'A' => 'Sezione A',
        'B' => 'Sezione B',
        'C' => 'Sezione C',
        'D' => 'Sezione D',
        'E' => 'Sezione E',
    ];

    const STATUSES = [
        'ATTIVO' => 'Attivo',
        'SCADUTO' => 'Scaduto',
        'RECEDUTO' => 'Receduto',
        'SOSPESO' => 'Sospeso',
    ];

    const PRINCIPAL_TYPES = [
        '--' => '--',
        'banca' => 'Banca',
        'agente_assicurativo' => 'Agente Assicurativo',
        'agente_captive' => 'Agente Captive',
    ];

    const SUBMISSION_TYPES = [
        '--' => '--',
        'accesso portale' => 'Accesso Portale',
        'inoltro' => 'Inoltro',
        'entrambi' => 'Entrambi',
    ];

    const CLIENT_TYPES = [
        'Banca' => 'Banca',
        'Assicurazione' => 'Assicurazione',
        'Utility' => 'Utility',
    ];

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function clientType(): BelongsTo
    {
        return $this->belongsTo(ClientType::class, 'customertype_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeBanks($query)
    {
        return $query->where('type', 'Banca');
    }

    public function scopeInsurance($query)
    {
        return $query->where('type', 'Assicurazione');
    }

    public function scopeUtility($query)
    {
        return $query->where('type', 'Utility');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeAttivo($query)
    {
        return $query->where('status', 'ATTIVO');
    }

    public function scopeScaduto($query)
    {
        return $query->where('status', 'SCADUTO');
    }

    public function scopeReceduto($query)
    {
        return $query->where('status', 'RECEDUTO');
    }

    public function scopeSospeso($query)
    {
        return $query->where('status', 'SOSPESO');
    }

    public function scopeExclusive($query)
    {
        return $query->where('is_exclusive', true);
    }

    public function scopeNonExclusive($query)
    {
        return $query->where('is_exclusive', false);
    }

    public function scopeWithOam($query)
    {
        return $query->whereNotNull('oam');
    }

    public function scopeWithIvass($query)
    {
        return $query->whereNotNull('ivass');
    }

    public function scopeReported($query)
    {
        return $query->where('is_reported', true);
    }

    public function scopeNotReported($query)
    {
        return $query->where('is_reported', false);
    }

    public function scopeExpiring($query, $days = 30)
    {
        return $query
            ->whereNotNull('end_date')
            ->where('end_date', '<=', now()->addDays($days))
            ->where('end_date', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query
            ->whereNotNull('end_date')
            ->where('end_date', '<', now());
    }

    // Helper methods
    public function getIvassSectionLabelAttribute(): string
    {
        return self::IVASS_SECTIONS[$this->ivass_section] ?? $this->ivass_section;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getPrincipalTypeLabelAttribute(): string
    {
        return self::PRINCIPAL_TYPES[$this->principal_type] ?? $this->principal_type;
    }

    public function getSubmissionTypeLabelAttribute(): string
    {
        return self::SUBMISSION_TYPES[$this->submission_type] ?? $this->submission_type;
    }

    public function getFullNameAttribute(): string
    {
        return trim(($this->name ?? '') . ' ' . ($this->nome ?? ''));
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->abi_name ?: $this->getFullNameAttribute();
    }

    public function isCurrentlyActive(): bool
    {
        return $this->is_active && $this->status === 'ATTIVO';
    }

    public function hasValidMandate(): bool
    {
        return $this->start_date &&
            (!$this->end_date || $this->end_date >= now()) &&
            $this->status === 'ATTIVO';
    }

    public function isMandateExpired(): bool
    {
        return $this->end_date && $this->end_date < now();
    }

    public function hasValidOam(): bool
    {
        return !empty($this->oam) && $this->oam_at;
    }

    public function hasValidIvass(): bool
    {
        return !empty($this->ivass) && $this->ivass_at;
    }

    public function getMandateDurationAttribute(): ?string
    {
        if (!$this->start_date)
            return null;

        $end = $this->end_date ?? now();
        $duration = $this->start_date->diffInDays($end);

        if ($duration > 365) {
            $years = floor($duration / 365);
            $days = $duration % 365;
            return "{$years} anni e {$days} giorni";
        }

        return "{$duration} giorni";
    }

    public function getDaysUntilExpiryAttribute(): ?int
    {
        if (!$this->end_date)
            return null;

        return now()->diffInDays($this->end_date, false);
    }

    public function getContractDurationAttribute(): ?string
    {
        if (!$this->stipulated_at)
            return null;

        $end = $this->dismissed_at ?? now();
        return $this->stipulated_at->diffInDays($end) . ' giorni';
    }

    public function getWebsiteUrlAttribute(): ?string
    {
        if (!$this->website)
            return null;

        return str_starts_with($this->website, 'http')
            ? $this->website
            : 'https://' . $this->website;
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->regione,
            $this->citta,
        ]);

        return implode(', ', $parts);
    }

    public function getRegistrationInfoAttribute(): string
    {
        $info = [];

        if ($this->oam) {
            $info[] = "OAM: {$this->oam}";
        }

        if ($this->ivass) {
            $info[] = "IVASS: {$this->ivass}";
            if ($this->ivass_section) {
                $info[] = "Sez. {$this->ivass_section}";
            }
        }

        return implode(' | ', $info);
    }

    // Status management methods
    public function activate(): void
    {
        $this->update(['status' => 'ATTIVO', 'is_active' => true]);
    }

    public function suspend(): void
    {
        $this->update(['status' => 'SOSPESO']);
    }

    public function terminate(): void
    {
        $this->update([
            'status' => 'RECEDUTO',
            'dismissed_at' => now()
        ]);
    }

    public function markAsExpired(): void
    {
        if ($this->isMandateExpired()) {
            $this->update(['status' => 'SCADUTO']);
        }
    }
}
