<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DpaProcessingActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'dpa_id',
        'processing_activity_id',
        'specific_instructions',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function dpa()
    {
        return $this->belongsTo(Dpa::class);
    }

    public function processingActivity()
    {
        return $this->belongsTo(ProcessingActivity::class);
    }
}
