<?php

namespace App\Models\FINANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    use HasFactory;

    protected $connection = 'bpm';

    protected $fillable = ['name', 'description'];

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
