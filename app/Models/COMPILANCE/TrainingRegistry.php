<?php

namespace App\Models\COMPILANCE;

use App\Models\PROFORMA\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Mattiverse\Userstamps\HasUserstamps;

class TrainingRegistry extends Model
{
    protected $table = 'training_registry';

    protected $fillable = [
        'user_id',
        'course_name',
        'regulatory_framework',
        'completed_at',
        'valid_until',
        'certificate_document_id',
    ];

    protected $casts = [
        'completed_at' => 'date',
        'valid_until' => 'date',
        'user_id' => 'integer',
    ];

    // Constants for enums
    const REGULATORY_FRAMEWORKS = [
        'ivass' => 'IVASS',
        'oam' => 'OAM',
        'gdpr' => 'GDPR',
        'safety' => 'Sicurezza sul Lavoro',
        'aml' => 'Antiriciclaggio',
        'privacy' => 'Privacy',
        'risk' => 'Gestione del Rischio',
        'compliance' => 'Compliance',
    ];

    // Check if certificate is still valid
    public function isValid(): bool
    {
        if (!$this->valid_until) {
            return true;  // No expiry date means always valid
        }

        return $this->valid_until->isFuture();
    }

    // Get days until expiry
    public function getDaysUntilExpiry(): ?int
    {
        if (!$this->valid_until) {
            return null;
        }

        return (int) now()->diffInDays($this->valid_until, false);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
