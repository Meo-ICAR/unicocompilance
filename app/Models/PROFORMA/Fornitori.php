<?php

namespace App\Models\PROFORMA;

use App\Models\CompanyBranch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Wildside\Userstamps\HasUserstamps;

class Fornitori extends Model
{
    use HasFactory, SoftDeletes;  // , HasUserstamps;

    protected $connection = 'mysql_proforma';

    protected $table = 'fornitoris';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'pec',
        'description',
        'supervisor_type',
        'oam',
        'oam_at',
        'oam_name',
        'numero_iscrizione_rui',
        'ivass',
        'ivass_at',
        'ivass_name',
        'ivass_section',
        'stipulated_at',
        'dismissed_at',
        'type',
        'is_active',
        'is_art108',
        'company_branch_id',
        'coordinated_type',
        'coordinated_id',
        'user_id',
        'oam_dismissed_at',
        'welcome_bonus',
        'campagna',
        'available_at',
        'budget',
        'codice',
        'coge',
        'name',
        'nome',
        'natoil',
        'indirizzo',
        'comune',
        'cap',
        'prov',
        'tel',
        'coordinatore',
        'piva',
        'cf',
        'nomecoge',
        'nomefattura',
        'email',
        'anticipo',
        'enasarco',
        'anticipo_residuo',
        'contributo',
        'contributo_description',
        'anticipo_description',
        'issubfornitore',
        'operatore',
        'iscollaboratore',
        'isdipendente',
        'regione',
        'citta',
        'company_id',
        'contributoperiodicita',
        'contributodalmese',
    ];

    protected $casts = [
        'supervisor_type' => 'string',
        'oam_at' => 'date',
        'ivass_at' => 'date',
        'stipulated_at' => 'date',
        'dismissed_at' => 'date',
        'is_active' => 'boolean',
        'is_art108' => 'boolean',
        'oam_dismissed_at' => 'date',
        'welcome_bonus' => 'decimal:2',
        'budget' => 'decimal:2',
        'natoil' => 'date',
        'available_at' => 'date',
        'anticipo' => 'decimal:2',
        'enasarco' => 'string',
        'anticipo_residuo' => 'decimal:2',
        'contributo' => 'decimal:2',
        'issubfornitore' => 'integer',
        'iscollaboratore' => 'boolean',
        'isdipendente' => 'boolean',
        'contributoperiodicita' => 'integer',
        'contributodalmese' => 'date',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'supervisor_type' => 'no',
        'is_active' => true,
        'is_art108' => false,
        'enasarco' => 'plurimandatario',
        'contributo_description' => 'Contributo spese',
        'anticipo_description' => 'Anticipo attuale',
        'isdipendente' => false,
        'company_id' => '5c044917-15b3-4471-90c9-38061fcca754',
    ];

    // Constants for enums
    const SUPERVISOR_TYPES = [
        'no' => 'No',
        'si' => 'Sì',
        'filiale' => 'Filiale',
    ];

    const IVASS_SECTIONS = [
        'A' => 'Sezione A',
        'B' => 'Sezione B',
        'C' => 'Sezione C',
        'D' => 'Sezione D',
        'E' => 'Sezione E',
    ];

    const ENASARCO_TYPES = [
        'no' => 'No',
        'monomandatario' => 'Monomandatario',
        'plurimandatario' => 'Plurimandatario',
        'societa' => 'Società',
    ];

    const FORNITORI_TYPES = [
        'Agente' => 'Agente',
        'Mediatore' => 'Mediatore',
        'Consulente' => 'Consulente',
        'Call Center' => 'Call Center',
    ];

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Models\BPM\Company::class, 'company_id');
    }

    public function companyBranch(): BelongsTo
    {
        return $this->belongsTo(CompanyBranch::class, 'company_branch_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coordinatedBy(): BelongsTo
    {
        return $this->belongsTo(self::class, 'coordinated_id');
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

    public function scopeSupervisor($query)
    {
        return $query->where('supervisor_type', '!=', 'no');
    }

    public function scopeAgent($query)
    {
        return $query->where('type', 'Agente');
    }

    public function scopeMediator($query)
    {
        return $query->where('type', 'Mediatore');
    }

    public function scopeConsultant($query)
    {
        return $query->where('type', 'Consulente');
    }

    public function scopeCallCenter($query)
    {
        return $query->where('type', 'Call Center');
    }

    public function scopeDipendente($query)
    {
        return $query->where('isdipendente', true);
    }

    public function scopeCollaboratore($query)
    {
        return $query->where('iscollaboratore', true);
    }

    public function scopeArt108($query)
    {
        return $query->where('is_art108', true);
    }

    public function scopeWithOam($query)
    {
        return $query->whereNotNull('oam');
    }

    public function scopeWithIvass($query)
    {
        return $query->whereNotNull('ivass');
    }

    // Helper methods
    public function getSupervisorTypeLabelAttribute(): string
    {
        return self::SUPERVISOR_TYPES[$this->supervisor_type] ?? $this->supervisor_type;
    }

    public function getIvassSectionLabelAttribute(): string
    {
        return self::IVASS_SECTIONS[$this->ivass_section] ?? $this->ivass_section;
    }

    public function getEnasarcoTypeLabelAttribute(): string
    {
        return self::ENASARCO_TYPES[$this->enasarco] ?? $this->enasarco;
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->nome}";
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->indirizzo,
            $this->cap,
            $this->comune,
            $this->prov ? "({$this->prov})" : null,
        ]);

        return implode(', ', $parts);
    }

    public function isCurrentlyActive(): bool
    {
        return $this->is_active && !$this->dismissed_at;
    }

    public function hasValidOam(): bool
    {
        return !empty($this->oam) && $this->oam_at && (!$this->oam_dismissed_at || $this->oam_dismissed_at > now());
    }

    public function hasValidIvass(): bool
    {
        return !empty($this->ivass) && $this->ivass_at;
    }

    public function getAgeAttribute(): ?int
    {
        return $this->natoil ? $this->natoil->age : null;
    }

    public function getContractDurationAttribute(): ?string
    {
        if (!$this->stipulated_at)
            return null;

        $end = $this->dismissed_at ?? now();
        return $this->stipulated_at->diffInDays($end) . ' giorni';
    }

    // Financial calculations
    public function getTotalAnticipoAttribute(): float
    {
        return (float) ($this->anticipo ?? 0);
    }

    public function getAnticipoResiduoAttribute(): float
    {
        return (float) ($this->anticipo_residuo ?? 0);
    }

    public function getContributoAttribute(): float
    {
        return (float) ($this->contributo ?? 0);
    }

    public function getBudgetAttribute(): float
    {
        return (float) ($this->budget ?? 0);
    }

    public function getWelcomeBonusAttribute(): float
    {
        return (float) ($this->welcome_bonus ?? 0);
    }
}
