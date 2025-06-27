<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Terminations extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'type_termi',
        'notice_date_termi',
        'design_date_termi',
        'reason_termi',
        'employe_id',
    ];

    protected $table = 'terminations';

    protected $primaryKey = 'termi';
}
