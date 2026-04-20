<?php

namespace App\Models\COMPILANCE;

use App\Models\PROFORMA\Clienti;
use App\Models\PROFORMA\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Wildside\Userstamps\HasUserstamps;

class Website extends Model
{
    use HasFactory, SoftDeletes;  // , HasUserstamps;

    protected $connection = 'mysql_compliance';

    protected $fillable = [
        'websiteable_type',
        'websiteable_id',
        'company_id',
        'name',
        'domain',
        'type',
        'principal_id',
        'is_active',
        'is_typical',
        'privacy_date',
        'transparency_date',
        'privacy_prior_date',
        'transparency_prior_date',
        'url_privacy',
        'url_cookies',
        'is_footercompilant',
        'url_transparency',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_typical' => 'boolean',
        'privacy_date' => 'date',
        'transparency_date' => 'date',
        'privacy_prior_date' => 'date',
        'transparency_prior_date' => 'date',
        'is_footercompilant' => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'is_active' => true,
        'is_typical' => true,
        'is_footercompilant' => false,
    ];

    // Constants for website types
    const WEBSITE_TYPES = [
        'vetrina' => 'Vetrina',
        'portale' => 'Portale',
        'landing' => 'Landing Page',
        'blog' => 'Blog',
        'ecommerce' => 'E-commerce',
        'istituzionale' => 'Istituzionale',
        'microsite' => 'Microsite',
    ];

    // Relationships
    public function websiteable(): MorphTo
    {
        return $this->morphTo();
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function principal(): BelongsTo
    {
        return $this->belongsTo(Clienti::class, 'principal_id');
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

    public function scopeTypical($query)
    {
        return $query->where('is_typical', true);
    }

    public function scopeNonTypical($query)
    {
        return $query->where('is_typical', false);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeVetrina($query)
    {
        return $query->where('type', 'vetrina');
    }

    public function scopePortale($query)
    {
        return $query->where('type', 'portale');
    }

    public function scopeLanding($query)
    {
        return $query->where('type', 'landing');
    }

    public function scopeWithPrivacy($query)
    {
        return $query->whereNotNull('privacy_date');
    }

    public function scopeWithTransparency($query)
    {
        return $query->whereNotNull('transparency_date');
    }

    public function scopePrivacyCompliant($query)
    {
        return $query
            ->whereNotNull('privacy_date')
            ->whereNotNull('url_privacy')
            ->where('is_footercompilant', true);
    }

    public function scopeTransparencyCompliant($query)
    {
        return $query
            ->whereNotNull('transparency_date')
            ->whereNotNull('url_transparency');
    }

    public function scopeFullyCompliant($query)
    {
        return $query->privacyCompliant()->transparencyCompliant();
    }

    public function scopeExpiringPrivacy($query, $days = 30)
    {
        return $query
            ->whereNotNull('privacy_date')
            ->where('privacy_date', '<=', now()->subMonths($days));
    }

    public function scopeExpiringTransparency($query, $days = 30)
    {
        return $query
            ->whereNotNull('transparency_date')
            ->where('transparency_date', '<=', now()->subMonths($days));
    }

    // Helper methods
    public function getTypeLabelAttribute(): string
    {
        return self::WEBSITE_TYPES[$this->type] ?? ucfirst($this->type);
    }

    public function getFullDomainAttribute(): string
    {
        if (str_starts_with($this->domain, 'http')) {
            return $this->domain;
        }

        return 'https://' . $this->domain;
    }

    public function getPrivacyStatusAttribute(): string
    {
        if (!$this->privacy_date) {
            return 'Non configurata';
        }

        $daysSinceUpdate = $this->privacy_date->diffInDays(now());

        if ($daysSinceUpdate > 365) {
            return 'Scaduta';
        } elseif ($daysSinceUpdate > 180) {
            return 'Da aggiornare';
        } else {
            return 'Aggiornata';
        }
    }

    public function getTransparencyStatusAttribute(): string
    {
        if (!$this->transparency_date) {
            return 'Non configurata';
        }

        $daysSinceUpdate = $this->transparency_date->diffInDays(now());

        if ($daysSinceUpdate > 365) {
            return 'Scaduta';
        } elseif ($daysSinceUpdate > 180) {
            return 'Da aggiornare';
        } else {
            return 'Aggiornata';
        }
    }

    public function getComplianceLevelAttribute(): string
    {
        $score = 0;

        // Privacy compliance
        if ($this->privacy_date)
            $score += 20;
        if ($this->url_privacy)
            $score += 10;
        if ($this->url_cookies)
            $score += 10;

        // Transparency compliance
        if ($this->transparency_date)
            $score += 20;
        if ($this->url_transparency)
            $score += 10;

        // Footer compliance
        if ($this->is_footercompilant)
            $score += 20;

        // Recent updates
        if ($this->privacy_date && $this->privacy_date->diffInDays(now()) < 180)
            $score += 5;
        if ($this->transparency_date && $this->transparency_date->diffInDays(now()) < 180)
            $score += 5;

        if ($score >= 90)
            return 'Eccellente';
        if ($score >= 70)
            return 'Buona';
        if ($score >= 50)
            return 'Sufficiente';
        if ($score >= 30)
            return 'Insufficiente';
        return 'Non Conforme';
    }

    public function isPrivacyCompliant(): bool
    {
        return !empty($this->privacy_date) &&
            !empty($this->url_privacy) &&
            $this->is_footercompilant;
    }

    public function isTransparencyCompliant(): bool
    {
        return !empty($this->transparency_date) &&
            !empty($this->url_transparency);
    }

    public function isFullyCompliant(): bool
    {
        return $this->isPrivacyCompliant() && $this->isTransparencyCompliant();
    }

    public function getDaysSincePrivacyUpdateAttribute(): ?int
    {
        return $this->privacy_date ? $this->privacy_date->diffInDays(now()) : null;
    }

    public function getDaysSinceTransparencyUpdateAttribute(): ?int
    {
        return $this->transparency_date ? $this->transparency_date->diffInDays(now()) : null;
    }

    public function needsPrivacyUpdate(): bool
    {
        if (!$this->privacy_date)
            return true;

        return $this->privacy_date->diffInDays(now()) > 180;
    }

    public function needsTransparencyUpdate(): bool
    {
        if (!$this->transparency_date)
            return true;

        return $this->transparency_date->diffInDays(now()) > 180;
    }

    public function getComplianceIssuesAttribute(): array
    {
        $issues = [];

        if (!$this->privacy_date) {
            $issues[] = 'Data privacy non impostata';
        }

        if (!$this->url_privacy) {
            $issues[] = 'URL privacy policy mancante';
        }

        if (!$this->url_cookies) {
            $issues[] = 'URL cookie policy mancante';
        }

        if (!$this->transparency_date) {
            $issues[] = 'Data trasparenza non impostata';
        }

        if (!$this->url_transparency) {
            $issues[] = 'URL trasparenza mancante';
        }

        if (!$this->is_footercompilant) {
            $issues[] = 'Footer non conforme GDPR';
        }

        if ($this->needsPrivacyUpdate()) {
            $issues[] = 'Privacy policy da aggiornare';
        }

        if ($this->needsTransparencyUpdate()) {
            $issues[] = 'Informativa trasparenza da aggiornare';
        }

        return $issues;
    }

    // URL helpers
    public function getPrivacyUrlAttribute(): ?string
    {
        if (!$this->url_privacy)
            return null;

        if (str_starts_with($this->url_privacy, 'http')) {
            return $this->url_privacy;
        }

        return $this->getFullDomainAttribute() . '/' . ltrim($this->url_privacy, '/');
    }

    public function getCookiesUrlAttribute(): ?string
    {
        if (!$this->url_cookies)
            return null;

        if (str_starts_with($this->url_cookies, 'http')) {
            return $this->url_cookies;
        }

        return $this->getFullDomainAttribute() . '/' . ltrim($this->url_cookies, '/');
    }

    public function getTransparencyUrlAttribute(): ?string
    {
        if (!$this->url_transparency)
            return null;

        if (str_starts_with($this->url_transparency, 'http')) {
            return $this->url_transparency;
        }

        return $this->getFullDomainAttribute() . '/' . ltrim($this->url_transparency, '/');
    }

    // Update methods
    public function updatePrivacy(): void
    {
        $this->update([
            'privacy_prior_date' => $this->privacy_date,
            'privacy_date' => now(),
        ]);
    }

    public function updateTransparency(): void
    {
        $this->update([
            'transparency_prior_date' => $this->transparency_date,
            'transparency_date' => now(),
        ]);
    }

    public function markFooterCompliant(): void
    {
        $this->update(['is_footercompilant' => true]);
    }

    public function markFooterNonCompliant(): void
    {
        $this->update(['is_footercompilant' => false]);
    }

    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }
}
