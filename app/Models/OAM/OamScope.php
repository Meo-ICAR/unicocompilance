<?php

namespace App\Models\OAM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OamScope extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'tipo_prodotto',
    ];

    protected $casts = [
        'tipo_prodotto' => 'array',
    ];

    public function practiceOams(): HasMany
    {
        return $this->hasMany(PracticeOam::class, 'oam_scope_id');
    }

    public function getTipoProdottoLabelsAttribute(): array
    {
        return $this->tipo_prodotto ?? [];
    }
}
