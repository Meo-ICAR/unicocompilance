<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Mattiverse\Userstamps\HasUserstamps;

class ComplaintRegistry extends Model
{
    use SoftDeletes;  // , HasUserstamps;

    protected $fillable = [
        'company_id',
        'complaint_number',
        'complainant_name',
        'category',
        'description',
        'financial_impact',
        'status',
    ];

    protected $casts = [
        'financial_impact' => 'decimal:2',
    ];

    // Constants for enums
    const CATEGORY_TYPES = [
        'delay' => 'Ritardo',
        'behavior' => 'Comportamento',
        'privacy' => 'Privacy',
        'fraud' => 'Frode',
        'quality' => 'Qualità del Servizio',
        'contract' => 'Contrattuale',
        'other' => 'Altro',
    ];

    const STATUS_TYPES = [
        'open' => 'Aperto',
        'investigating' => 'In Investigazione',
        'resolved' => 'Risolto',
        'rejected' => 'Rifiutato',
        'closed' => 'Chiuso',
    ];
}
