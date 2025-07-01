<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrgenceContact extends Model
{
    protected $fillable = [
        'full_name',
        'relation',
        'phone_number_one',
        'phone_number_two',
        'employe_id',
    ];

    protected $table = 'urgence_contact';

    protected $primaryKey = 'urgcon';
}
