<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incendits extends Model
{
    protected $fillable = [
        'reference_incendit',
        'type_incendit',
        'lieu_incendit',
        'date_incendit',
        'description_incendit',
        'gravite_incendit',
        'statut_incendit',
        'employe_id',
        'emetteur_id',
    ];

    protected $table = 'incendits';

    protected $primaryKey = 'incendit_id';
}
