<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Designations extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name_designation',
        'department_id',
        'status_design',
    ];

    protected $table = 'designations';

    protected $primaryKey = 'design';
}
