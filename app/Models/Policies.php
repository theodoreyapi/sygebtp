<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Policies extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'file_policie',
        'name_policie',
        'appraisal_policie',
        'department_id',
    ];

    protected $table = 'policies';

    protected $primaryKey = 'policie';
}
