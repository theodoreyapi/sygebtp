<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TrainingEmployee extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'employe_id',
        'training_id',
    ];

    protected $table = 'training_employee';

    protected $primaryKey = 'traiemp';
}
