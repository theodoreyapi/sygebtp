<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyInformation extends Model
{
    protected $fillable = [
        'complet_name',
        'relation_family',
        'phone_family',
        'naissance_family',
        'employe_id',
    ];

    protected $table = 'family_information';

    protected $primaryKey = 'faminf';
}
