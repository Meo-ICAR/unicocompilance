<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Mattiverse\Userstamps\HasUserstamps;

class TrainingSession extends Model
{
    use SoftDeletes;

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
}
