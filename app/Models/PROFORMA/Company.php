<?php

namespace App\Models\PROFORMA;

use App\Enums\CompanyType;
use App\Models\COMPILANCE\CompanyBranch;
use App\Models\COMPILANCE\SoftwareApplication;
use App\Models\COMPILANCE\TrainingRecord;
use App\Models\COMPILANCE\Website;
use App\Models\DOC\Document;
use App\Models\PROFORMA\Address;
use App\Models\PROFORMA\Client;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Company extends Model implements HasAvatar, HasMedia, HasName
{
    use HasFactory, HasUuids, InteractsWithMedia;

    protected $connection = 'mysql_proforma';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'company_type',
        'vat_number',
        'vat_name',
        'oam',
        'oam_at',
        'oam_name',
        'numero_iscrizione_rui',
        'ivass',
        'ivass_at',
        'ivass_name',
        'ivass_section',
        'sponsor',
        'page_header',
        'page_footer',
        'domain',
    ];

    protected $casts = [
        'oam_at' => 'date',
        'ivass_at' => 'date',
        'company_type' => CompanyType::class,
        'smtp_enabled' => 'boolean',
        'smtp_verify_ssl' => 'boolean',
        'smtp_password' => 'encrypted',
    ];

    protected $hidden = [
        'smtp_password',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(CompanyBranch::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function websites()
    {
        return $this->morphMany(Website::class, 'websiteable');
    }

    public function trainingRecords(): MorphMany
    {
        return $this->morphMany(TrainingRecord::class, 'trainable');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function softwareApplications()
    {
        return $this->hasMany(SoftwareApplication::class);
    }

    public function companyClients(): HasMany
    {
        return $this->hasMany(Client::class)->where('is_company', 1);
    }

    public function getCompanyTypeNameAttribute(): ?string
    {
        return $this->company_type?->getLabel();
    }

    public function getCompanyTypeDescriptionAttribute(): ?string
    {
        return $this->company_type?->getDescription();
    }

    public function getCompanyTypeIconAttribute(): ?string
    {
        return $this->company_type?->getIcon();
    }

    public function getCompanyTypeColorAttribute(): ?string
    {
        return $this->company_type?->getColor();
    }

    public function isFinancialCompany(): bool
    {
        return $this->company_type?->isFinancial() ?? false;
    }

    public function isServiceCompany(): bool
    {
        return $this->company_type?->isService() ?? false;
    }

    public function scopeByCompanyType($query, CompanyType $type)
    {
        return $query->where('company_type', $type);
    }

    public function scopeFinancial($query)
    {
        return $query->whereIn('company_type', [CompanyType::MEDIATORE, CompanyType::CALL_CENTER]);
    }

    public function scopeNonFinancial($query)
    {
        return $query->whereIn('company_type', [CompanyType::ALBERGO, CompanyType::SOFTWARE_HOUSE]);
    }

    /**
     * Verifica se un'email appartiene al dominio aziendale.
     */
    public function ownsEmail(string $email): bool
    {
        if (empty($this->domain)) {
            return false;
        }

        $emailDomain = explode('@', $email);
        $emailDomain = end($emailDomain);

        return strtolower($emailDomain) === strtolower($this->domain);
    }

    /**
     * Implementazione di HasName per Filament (Nome Tenant)
     */
    public function getFilamentName(): string
    {
        return $this->name;
    }

    /**
     * Implementazione di HasAvatarUrl per Filament (Logo Tenant)
     */
    public function getFilamentAvatarUrl(): ?string
    {
        // Utile per restituire un logo da Spatie Media Library come avatar del tenant in Filament
        return null;
        // $this->getFirstMediaUrl('logo') ?: null;
    }
}
