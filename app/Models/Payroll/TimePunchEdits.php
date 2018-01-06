<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class TimePunchEdits extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'clock_in', 'clock_out', 'time_punch_id', 'reason'
    ];

     /**
     * The attributes that are Carbon dates.
     *
     * @var array
     */
    protected $dates = [
        'clock_in', 'clock_out',
    ];

    public $timestamps = false;
}
