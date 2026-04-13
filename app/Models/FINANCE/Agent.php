<?php

namespace App\Models\FINANCE;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model;
// use Spatie\MediaLibrary\HasMedia;
// use Spatie\MediaLibrary\InteractsWithMedia;

class Agent extends Model  // implements HasMedia
{
    // use BelongsToCompany;
    // use InteractsWithMedia;

    protected $connection = 'compilio';

    protected $fillable = [
        'company_id',
        'company_branch_id',
        'coordinated_by_id',
        'coordinated_by_agent_id',
        'name',
        'email',
        'email_personal',
        'pec',
        'phone',
        'tax_code',
        'description',
        'supervisor_type',
        'oam',
        'oam_at',
        'oam_dismissed_at',
        'oam_name',
        'ivass',
        'ivass_at',
        'ivass_name',
        'ivass_section',
        'stipulated_at',
        'dismissed_at',
        'type',
        'contribute',
        'contributeFrequency',
        'contributeFrom',
        'remburse',
        'vat_number',
        'vat_name',
        'enasarco',
        'is_active',
        'is_art108',
        'contoCOGE',
        'user_id',
        'numero_iscrizione_rui',
        'welcome_bonus',
        'campagna',
        'available_at',
        'budget',
    ];

    protected $casts = [
        'oam_at' => 'date',
        'oam_dismissed_at' => 'date',
        'ivass_at' => 'date',
        'stipulated_at' => 'date',
        'dismissed_at' => 'date',
        'contribute' => 'decimal:2',
        'remburse' => 'decimal:2',
        'contributeFrom' => 'date',
        'contributeFrequency' => 'integer',
        'is_art108' => 'boolean',
        'is_active' => 'boolean',
        'welcome_bonus' => 'decimal:2',
        'available_at' => 'date',
        'budget' => 'decimal:2',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function coordinatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'coordinated_by_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function companyBranch(): BelongsTo
    {
        return $this->belongsTo(CompanyBranch::class);
    }

    public function coordinatedByAgent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'coordinated_by_agent_id');
    }

    public function coordinatedAgents()
    {
        return $this->hasMany(Agent::class, 'coordinated_by_agent_id');
    }

    public function suspiciousActivityReports(): MorphMany
    {
        return $this->morphMany(SuspiciousActivityReport::class, 'reporter');
    }
}
