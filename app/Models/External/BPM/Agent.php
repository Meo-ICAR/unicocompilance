<?php

/**
 * SCOPO: Proxy Model per l'agente BPM per relazioni cross-database.
 * PATH: app/Models/External/BPM/Agent.php
 * CONSTRAINTS: Connessione al database BPM e relazione logica.
 */

namespace App\Models\External\BPM;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $connection = 'bpm';
    
    protected $table = 'users'; // Tabella agents nel DB BPM
    
    protected $fillable = [
        'name',
        'email',
        // altri campi necessari
    ];
    
    // Disabilita timestamps se non presenti nella tabella BPM
    public $timestamps = false;
}
