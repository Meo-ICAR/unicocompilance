<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

/**
 * Rappresenta una banca dell'elenco ufficiale ABI.
 *
 * @property int             $id
 * @property string          $name         Nome ufficiale della banca
 * @property string          $code         Codice ABI a 5 cifre
 * @property string          $description  Descrizione aggiuntiva
 * @property \Carbon\Carbon  $created_at
 * @property \Carbon\Carbon  $updated_at
 */
class Abi extends Model
{
    protected $connection = 'db';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];
}
