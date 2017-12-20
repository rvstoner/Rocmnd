<?php

namespace App\Models\Payroll;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'shift',
        'shift_start',
        'shift_end',
    ];

    public $timestamps = false;

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function getShiftHour($time)
    {
    	if(preg_match('~^\d+(?::\d+)*$~', $time)){
            $newTime = Carbon::createFromFormat('h:i', $time);
        }else{
            $newTime = Carbon::createFromFormat('h:i A', $time);            
        }
        return $newTime->hour;
    }

    /**
     * set the sufix for the shift.
     *
     * @param  string  $value
     * @return string
     */
    public function getShiftAttribute($num)
    {
        $ones = $num % 10;
	    $tens = floor($num / 10) % 10;
	    if ($tens == 1) {
	        $suff = "th";
	    } else {
	        switch ($ones) {
	            case 1 : $suff = "st"; break;
	            case 2 : $suff = "nd"; break;
	            case 3 : $suff = "rd"; break;
	            default : $suff = "th";
	        }
	    }
	    return $num . $suff;
    }
}
