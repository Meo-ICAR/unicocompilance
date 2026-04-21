<?php

namespace App\Models\COMPILANCE;

use App\Models\PROFORMA\Clienti;
use App\Models\PROFORMA\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
// use Wildside\Userstamps\HasUserstamps;

class ClientiEmployee extends Model
{
    use HasFactory;  // , HasUserstamps;

    protected $connection = 'mysql_compliance';

    protected $table = 'clienti_employees';

    protected $fillable = [
        'clienti_id',
        'company_id',
        'personable_type',
        'personable_id',
        'num_iscr_intermediario',
        'num_iscr_collaboratori_ii_liv',
        'usercode',
        'description',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    // Relationships
    public function clienti(): BelongsTo
    {
        return $this->belongsTo(Clienti::class, 'clienti_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function personable(): MorphTo
    {
        return $this->morphTo();
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

    public function scopeForClient($query, $clientId)
    {
        return $query->where('clienti_id', $clientId);
    }

    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeWithUsercode($query, $usercode)
    {
        return $query->where('usercode', $usercode);
    }

    public function scopeCurrentlyActive($query)
    {
        return $query
            ->where('is_active', true)
            ->where(function ($q) {
                $q
                    ->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    public function scopeExpired($query)
    {
        return $query
            ->whereNotNull('end_date')
            ->where('end_date', '<', now());
    }

    public function scopeExpiring($query, $days = 30)
    {
        return $query
            ->whereNotNull('end_date')
            ->where('end_date', '<=', now()->addDays($days))
            ->where('end_date', '>', now());
    }

    public function scopeWithIntermediaryNumber($query)
    {
        return $query->whereNotNull('num_iscr_intermediario');
    }

    public function scopeWithCollaboratorNumber($query)
    {
        return $query->whereNotNull('num_iscr_collaboratori_ii_liv');
    }

    // Helper methods
    public function isActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        return true;
    }

    public function isExpired(): bool
    {
        return $this->end_date && $this->end_date->isPast();
    }

    public function isExpiring(): bool
    {
        if (!$this->end_date) {
            return false;
        }

        return $this->end_date->isFuture() &&
            $this->end_date->diffInDays(now()) <= 30;
    }

    public function getDaysUntilExpiry(): ?int
    {
        if (!$this->end_date) {
            return null;
        }

        if ($this->end_date->isPast()) {
            return 0;
        }

        return $this->end_date->diffInDays(now());
    }

    public function getAuthorizationPeriodAttribute(): string
    {
        if (!$this->start_date) {
            return 'Non specificata';
        }

        $start = $this->start_date->format('d/m/Y');

        if ($this->end_date) {
            $end = $this->end_date->format('d/m/Y');
            return "Dal $start al $end";
        }

        return "Dal $start (senza scadenza)";
    }

    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'Inattivo';
        }

        if ($this->isExpired()) {
            return 'Scaduto';
        }

        if ($this->isExpiring()) {
            return 'In scadenza';
        }

        return 'Attivo';
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Attivo' => 'success',
            'In scadenza' => 'warning',
            'Scaduto' => 'danger',
            'Inattivo' => 'secondary',
            default => 'gray',
        };
    }

    public function getPersonNameAttribute(): ?string
    {
        if (!$this->personable) {
            return null;
        }

        // Try different name attributes based on common model patterns
        $nameAttributes = ['name', 'full_name', 'display_name', 'nome_completo'];

        foreach ($nameAttributes as $attr) {
            if (isset($this->personable->{$attr})) {
                return $this->personable->{$attr};
            }
        }

        // Try combining first_name and last_name
        if (isset($this->personable->first_name) && isset($this->personable->last_name)) {
            return trim($this->personable->first_name . ' ' . $this->personable->last_name);
        }

        if (isset($this->personable->nome) && isset($this->personable->cognome)) {
            return trim($this->personable->nome . ' ' . $this->personable->cognome);
        }

        // Fallback to usercode or description
        return $this->usercode ?: $this->description ?: 'N/A';
    }

    public function getPersonTypeAttribute(): string
    {
        if (!$this->personable_type) {
            return 'Non specificato';
        }

        $typeMap = [
            'App\Models\BPM\Employee' => 'Dipendente',
            'App\Models\BPM\Agent' => 'Agente',
            'App\Models\PROFORMA\Fornitori' => 'Fornitore',
            'App\Models\User' => 'Utente',
        ];

        return $typeMap[$this->personable_type] ?? class_basename($this->personable_type);
    }

    public function hasIntermediaryNumber(): bool
    {
        return !empty($this->num_iscr_intermediario);
    }

    public function hasCollaboratorNumber(): bool
    {
        return !empty($this->num_iscr_collaboratori_ii_liv);
    }

    public function getRegistrationNumbersAttribute(): string
    {
        $numbers = [];

        if ($this->hasIntermediaryNumber()) {
            $numbers[] = "Intermediario: {$this->num_iscr_intermediario}";
        }

        if ($this->hasCollaboratorNumber()) {
            $numbers[] = "Coll. II Liv: {$this->num_iscr_collaboratori_ii_liv}";
        }

        return empty($numbers) ? 'Nessuno' : implode(', ', $numbers);
    }

    // Business logic methods
    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    public function extendAuthorization(\DateTime $newEndDate): void
    {
        $this->update(['end_date' => $newEndDate]);
    }

    public function setPermanentAuthorization(): void
    {
        $this->update(['end_date' => null]);
    }

    public function canWorkWithClient(): bool
    {
        return $this->isActive();
    }

    public function getWorkPermissionsAttribute(): array
    {
        $permissions = [];

        if ($this->isActive()) {
            $permissions[] = 'Può lavorare con il cliente';
        }

        if ($this->hasIntermediaryNumber()) {
            $permissions[] = 'Iscritto come intermediario';
        }

        if ($this->hasCollaboratorNumber()) {
            $permissions[] = 'Iscritto come collaboratore II livello';
        }

        if (!$this->end_date) {
            $permissions[] = 'Autorizzazione permanente';
        }

        return $permissions;
    }
}
