<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Training extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'cost_traini',
        'start_traini',
        'end_traini',
        'description_traini',
        'type_id',
        'trainer_id',
        'status_traini',
    ];

    protected $table = 'training';

    protected $primaryKey = 'traini';
}
