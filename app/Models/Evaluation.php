<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'note_moyenne',
        'date_evaluation',
        'periode_debut',
        'periode_fin',
        'commentaire',
        'employe_id',
        'evaluateur_id',
    ];

    protected $table = 'evaluations';

    protected $primaryKey = 'evaluation_id';
}
