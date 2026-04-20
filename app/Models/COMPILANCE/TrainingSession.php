<?php

namespace App\Models\COMPILANCE;

use App\Models\PROFORMA\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Mattiverse\Userstamps\HasUserstamps;

class TrainingSession extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql_compliance';

    protected $fillable = [
        'course_name',
        'hours',
        'completion_date',
        'provider',
        'expiry_date',
        'certificate_path',
        'notes',
        'trainee_id',
        'trainee_type',
    ];

    protected $casts = [
        'hours' => 'integer',
        'completion_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function trainee(): MorphTo
    {
        return $this->morphTo();
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
