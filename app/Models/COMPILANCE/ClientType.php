<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_person',
        'is_company',
        'privacy_role',
        'purpose',
        'data_subjects',
        'data_categories',
        'retention_period',
        'extra_eu_transfer',
        'security_measures',
        'privacy_data',
    ];

    protected $casts = [
        'is_person' => 'boolean',
        'is_company' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'is_person' => true,
        'is_company' => false,
    ];

    // Relationships
    public function clients(): HasMany
    {
        return $this->hasMany(\App\Models\PROFORMA\Client::class);
    }

    public function clienti(): HasMany
    {
        return $this->hasMany(\App\Models\PROFORMA\Clienti::class, 'customertype_id');
    }

    // Scopes
    public function scopePerson($query)
    {
        return $query->where('is_person', true);
    }

    public function scopeCompany($query)
    {
        return $query->where('is_company', true);
    }

    public function scopeProfessional($query)
    {
        return $query->where('is_person', true)->where('is_company', true);
    }

    public function scopeIndividual($query)
    {
        return $query->where('is_person', true)->where('is_company', false);
    }

    public function scopeWithPrivacyData($query)
    {
        return $query
            ->whereNotNull('privacy_role')
            ->whereNotNull('purpose');
    }

    public function scopeExtraEuTransfer($query)
    {
        return $query->where('extra_eu_transfer', '!=', 'No');
    }

    // Helper methods
    public function getTypeLabelAttribute(): string
    {
        if ($this->is_person && $this->is_company) {
            return 'Professionista/Azienda';
        } elseif ($this->is_person) {
            return 'Persona Fisica';
        } elseif ($this->is_company) {
            return 'Persona Giuridica';
        }

        return 'Non specificato';
    }

    public function hasPrivacyCompliance(): bool
    {
        return !empty($this->privacy_role) &&
            !empty($this->purpose) &&
            !empty($this->data_subjects);
    }

    public function hasExtraEuTransfer(): bool
    {
        return !empty($this->extra_eu_transfer) &&
            strtolower($this->extra_eu_transfer) !== 'no';
    }

    public function getRetentionPeriodAttribute(): string
    {
        return $this->retention_period ?? 'Non specificato';
    }

    public function getPrivacyRoleAttribute(): string
    {
        return $this->privacy_role ?? 'Non specificato';
    }

    public function getSecurityMeasuresSummaryAttribute(): string
    {
        if (empty($this->security_measures)) {
            return 'Non specificate';
        }

        // Estrai le prime 100 caratteri per un riepilogo
        return strlen($this->security_measures) > 100
            ? substr($this->security_measures, 0, 100) . '...'
            : $this->security_measures;
    }

    public function getDataCategoriesSummaryAttribute(): string
    {
        if (empty($this->data_categories)) {
            return 'Non specificate';
        }

        // Estrai le prime 100 caratteri per un riepilogo
        return strlen($this->data_categories) > 100
            ? substr($this->data_categories, 0, 100) . '...'
            : $this->data_categories;
    }

    // Privacy compliance helpers
    public function isDataController(): bool
    {
        return str_contains(strtolower($this->privacy_role ?? ''), 'titolare');
    }

    public function isDataProcessor(): bool
    {
        return str_contains(strtolower($this->privacy_role ?? ''), 'responsabile');
    }

    public function isJointController(): bool
    {
        return str_contains(strtolower($this->privacy_role ?? ''), 'contitolare');
    }

    public function requiresDpia(): bool
    {
        // Valutazione semplificata per DPIA (Data Protection Impact Assessment)
        $highRiskCategories = [
            'sanitari',
            'giudiziari',
            'biometrici',
            'genetici',
            'minori',
            'particolari'
        ];

        $dataCategories = strtolower($this->data_categories ?? '');

        foreach ($highRiskCategories as $category) {
            if (str_contains($dataCategories, $category)) {
                return true;
            }
        }

        return $this->hasExtraEuTransfer();
    }

    public function getRetentionDaysAttribute(): ?int
    {
        if (empty($this->retention_period)) {
            return null;
        }

        // Estrai numero di anni dalla stringa
        if (preg_match('/(\d+)\s*anni?/i', $this->retention_period, $matches)) {
            return (int) $matches[1] * 365;
        }

        if (preg_match('/(\d+)\s*mesi?/i', $this->retention_period, $matches)) {
            return (int) $matches[1] * 30;
        }

        if (preg_match('/(\d+)\s*giorni?/i', $this->retention_period, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }

    // Business logic methods
    public function canProcessPersonalData(): bool
    {
        return $this->hasPrivacyCompliance();
    }

    public function requiresSpecialProtection(): bool
    {
        $specialCategories = [
            'sanitari',
            'giudiziari',
            'biometrici',
            'genetici',
            'particolari',
            'minori'
        ];

        $dataCategories = strtolower($this->data_categories ?? '');

        foreach ($specialCategories as $category) {
            if (str_contains($dataCategories, $category)) {
                return true;
            }
        }

        return false;
    }

    public function getComplianceLevelAttribute(): string
    {
        $score = 0;

        // Punteggio base per compliance
        if ($this->hasPrivacyCompliance())
            $score += 30;
        if (!empty($this->data_categories))
            $score += 20;
        if (!empty($this->retention_period))
            $score += 20;
        if (!empty($this->security_measures))
            $score += 15;
        if (!$this->hasExtraEuTransfer())
            $score += 15;

        if ($score >= 80)
            return 'Alta';
        if ($score >= 60)
            return 'Media';
        if ($score >= 40)
            return 'Bassa';
        return 'Molto Bassa';
    }
}
