<?php

namespace App\Models\COMPILANCE;

use App\Models\PROFORMA\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Mattiverse\Userstamps\HasUserstamps;

class ConflictOfInterestRegistry extends Model
{
    use SoftDeletes;  // , HasUserstamps;

    protected $table = 'conflict_of_interest_registry';

    protected $fillable = [
        'user_id',
        'conflict_description',
        'mitigation_strategy',
        'approved_by_compliance_at',
    ];

    protected $casts = [
        'approved_by_compliance_at' => 'datetime',
        'user_id' => 'integer',
    ];

    // Check if conflict is approved
    public function isApproved(): bool
    {
        return !is_null($this->approved_by_compliance_at);
    }

    // Check if conflict is pending approval
    public function isPending(): bool
    {
        return is_null($this->approved_by_compliance_at);
    }

    // Scope for approved conflicts
    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_by_compliance_at');
    }

    // Scope for pending conflicts
    public function scopePending($query)
    {
        return $query->whereNull('approved_by_compliance_at');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
