<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'punch_in_time',
        'punch_out_time',
        'worked_hours',
        'break_minutes',
        'productive_hours',
        'overtime_hours',
        'status',
    ];

    protected $casts = [
        'punch_in_time' => 'datetime',
        'punch_out_time' => 'datetime',
        'date' => 'date',
    ];


    protected $table = 'attendances';

    protected $primaryKey = 'att_id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
