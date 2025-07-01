<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'entreprise',
        'poste',
        'en_poste',
        'debut',
        'fin',
        'employe_id',
    ];

    protected $table = 'experience';

    protected $primaryKey = 'expe';
}
