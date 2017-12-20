<?php

namespace App\Models\Payroll;

use App\User;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class TimePunch extends Model
{
	/**
     * Change Carbons start and end of the week.
     */
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY); 
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'clock_in', 'clock_out', 'shift_date', 'reason'
    ];

     /**
     * The attributes that are Carbon dates.
     *
     * @var array
     */
    protected $dates = [
        'clock_in', 'clock_out','shift_date',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Used to round times to the nearest 15 minutes.
     */
    public static function roundTime($time)
    {
        $roundedTime = Carbon::createFromTimestamp(60*(15*round(round(($time->timestamp)/60)/15)));

        return $roundedTime;
    }

}
