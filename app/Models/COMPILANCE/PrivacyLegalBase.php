<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivacyLegalBase extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mariadb';

    protected $fillable = [
        'name',
        'reference_article',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeByArticle($query, $article)
    {
        return $query->where('reference_article', 'like', '%' . $article . '%');
    }

    public function scopeConsent($query)
    {
        return $query->where('name', 'Consenso');
    }

    public function scopeContract($query)
    {
        return $query->where('name', 'Esecuzione Contratto');
    }

    public function scopeLegalObligation($query)
    {
        return $query->where('name', 'Obbligo Legale');
    }

    public function scopeVitalInterest($query)
    {
        return $query->where('name', 'Interesse Vitale');
    }

    public function scopePublicInterest($query)
    {
        return $query->where('name', 'Interesse Pubblico');
    }

    public function scopeLegitimateInterest($query)
    {
        return $query->where('name', 'Legittimo Interesse');
    }

    public function getArticleLetterAttribute(): ?string
    {
        if (preg_match('/lett\. ([a-z])/', $this->reference_article, $matches)) {
            return strtoupper($matches[1]);
        }
        return null;
    }

    public function getArticleNumberAttribute(): string
    {
        return $this->reference_article;
    }

    public function getShortDescriptionAttribute(): string
    {
        return substr($this->description, 0, 100) . '...';
    }

    public static function getLegalBases(): array
    {
        return [
            'consent' => 'Consenso',
            'contract' => 'Esecuzione Contratto',
            'legal_obligation' => 'Obbligo Legale',
            'vital_interest' => 'Interesse Vitale',
            'public_interest' => 'Interesse Pubblico',
            'legitimate_interest' => 'Legittimo Interesse',
        ];
    }

    public static function getArticleLetters(): array
    {
        return [
            'a' => 'Consenso',
            'b' => 'Esecuzione Contratto',
            'c' => 'Obbligo Legale',
            'd' => 'Interesse Vitale',
            'e' => 'Interesse Pubblico',
            'f' => 'Legittimo Interesse',
        ];
    }
}
