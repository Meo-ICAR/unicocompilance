<?php

namespace App\Models\COMPILANCE;

use Illuminate\Database\Eloquent\Model;

class AddressType extends Model
{
    protected $connection = 'mysql_proforma';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    //
}
