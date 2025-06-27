<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trainers extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name_trai',
        'lastname_trai',
        'role_trai',
        'phone_trai',
        'email_trai',
        'description_trai',
        'status_train',
    ];

    protected $table = 'trainers';

    protected $primaryKey = 'trai';
}
