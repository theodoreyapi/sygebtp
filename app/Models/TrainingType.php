<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TrainingType extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'type',
        'description_type',
        'status_type',
    ];

    protected $table = 'training_type';

    protected $primaryKey = 'trai_type';
}
