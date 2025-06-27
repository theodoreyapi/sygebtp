<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Holidays extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'date',
        'description',
        'status_holi',
    ];

    protected $table = 'holidays';

    protected $primaryKey = 'holi';
}
