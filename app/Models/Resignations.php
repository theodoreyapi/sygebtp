<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Resignations extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'notice_date',
        'resignation_date',
        'reason',
        'employe_id',
    ];

    protected $table = 'resignations';

    protected $primaryKey = 'resi';
}
