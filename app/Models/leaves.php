<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class leaves extends Model
{
    protected $fillable = [
        'user_id',
        'leave_type',
        'start_date',
        'end_date',
        'day_type',
        'total_days',
        'remaining_days',
        'reason',
        'justification',
        'status',
        'approved_by',
    ];

    protected $table = 'leaves';

    protected $primaryKey = 'leave_id';

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

}
