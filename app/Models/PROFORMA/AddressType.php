<?php

namespace App\Models\PROFORMA;

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
