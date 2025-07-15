<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objectifs extends Model
{
    protected $fillable = [
        'objectif',
        'note',
        'appreciation',
        'id_evaluation',
    ];

    protected $table = 'objectifs';

    protected $primaryKey = 'objectif_id';
}
