<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssoTypeTraining extends Model
{
    protected $fillable = [
        'employe_id',
        'formation_id',
    ];

    protected $table = 'asso_type_training';

    protected $primaryKey = 'asso_type_training_id';
}
