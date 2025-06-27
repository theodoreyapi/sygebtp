<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Promotions extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'date_promo',
        'employe_id',
        'promo_from',
        'promo_to',
        'status_promo',
    ];

    protected $table = 'promotions';

    protected $primaryKey = 'promo';
}
