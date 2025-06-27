<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Departments extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'deparment_name',
        'status_depart',
    ];

    protected $table = 'departments';

    protected $primaryKey = 'depart';
}
