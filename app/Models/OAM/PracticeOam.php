<?php

namespace App\Models\OAM;

use App\Models\BPM\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PracticeOam extends Model
{
    use HasFactory;

    protected $fillable = [
        'practice_id',
        'oam_code_id',
        'oam_code',
        'oam_name',
        'principal_name',
        'is_notconvenctioned',
        'is_previous',
        'liquidato',
        'liquidato_lavorazione',
        'CRM_code',
        'practice_name',
        'type',
        'inserted_at',
        'erogated_at',
        'compenso',
        'compenso_lavorazione',
        'erogato',
        'erogato_lavorazione',
        'compenso_premio',
        'compenso_rimborso',
        'compenso_assicurazione',
        'compenso_cliente',
        'storno',
        'provvigione',
        'provvigione_lavorazione',
        'provvigione_premio',
        'provvigione_rimborso',
        'provvigione_assicurazione',
        'provvigione_storno',
        'is_active',
        'is_cancel',
        'is_perfected',
        'is_conventioned',
        'is_notconventioned',
        'is_working',
        'invoice_at',
        'start_date',
        'perfected_at',
        'end_date',
        'accepted_at',
        'canceled_at',
        'is_invoice',
        'is_before',
        'is_after',
        'name',
        'tipo_prodotto',
        'mese',
        'company_id',
    ];

    protected $casts = [
        'is_notconvenctioned' => 'boolean',
        'is_previous' => 'boolean',
        'liquidato' => 'decimal:2',
        'liquidato_lavorazione' => 'decimal:2',
        'inserted_at' => 'date',
        'erogated_at' => 'date',
        'compenso' => 'decimal:2',
        'compenso_lavorazione' => 'decimal:2',
        'erogato' => 'decimal:2',
        'erogato_lavorazione' => 'decimal:2',
        'compenso_premio' => 'decimal:2',
        'compenso_rimborso' => 'decimal:2',
        'compenso_assicurazione' => 'decimal:2',
        'compenso_cliente' => 'decimal:2',
        'storno' => 'decimal:2',
        'provvigione' => 'decimal:2',
        'provvigione_lavorazione' => 'decimal:2',
        'provvigione_premio' => 'decimal:2',
        'provvigione_rimborso' => 'decimal:2',
        'provvigione_assicurazione' => 'decimal:2',
        'provvigione_storno' => 'decimal:2',
        'is_active' => 'boolean',
        'is_cancel' => 'boolean',
        'is_perfected' => 'boolean',
        'is_conventioned' => 'boolean',
        'is_notconventioned' => 'boolean',
        'is_working' => 'boolean',
        'invoice_at' => 'date',
        'start_date' => 'date',
        'perfected_at' => 'date',
        'end_date' => 'date',
        'accepted_at' => 'date',
        'canceled_at' => 'date',
        'is_invoice' => 'boolean',
        'is_before' => 'boolean',
        'is_after' => 'boolean',
        'mese' => 'integer',
    ];

    public function oamCode(): BelongsTo
    {
        return $this->belongsTo(OamCode::class, 'oam_code_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Scopes for common queries
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeConventioned($query)
    {
        return $query->where('is_conventioned', true);
    }

    public function scopeNotConventioned($query)
    {
        return $query->where('is_notconventioned', true);
    }

    public function scopePerfected($query)
    {
        return $query->where('is_perfected', true);
    }

    public function scopeCanceled($query)
    {
        return $query->where('is_cancel', true);
    }

    public function scopeInvoiced($query)
    {
        return $query->where('is_invoice', true);
    }

    // Helper methods
    public function isConventionedPractice(): bool
    {
        return $this->is_conventioned && !$this->is_notconventioned;
    }

    public function getTotalCompensoAttribute(): float
    {
        return (float) ($this->compenso ?? 0);
    }

    public function getTotalProvvigioneAttribute(): float
    {
        return (float) ($this->provvigione ?? 0);
    }

    public function getLiquidatoTotaleAttribute(): float
    {
        return (float) ($this->liquidato ?? 0);
    }

    public function getErogatoTotaleAttribute(): float
    {
        return (float) ($this->erogato ?? 0);
    }
}
