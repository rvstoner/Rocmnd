<?php

namespace App\Models\Payroll;

use Carbon\Carbon;
use App\Models\Payroll\TimePunch;
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

    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY); 
    }

    public $timestamps = false;

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function getShiftHour($time)
    {
    	if(preg_match('~^\d+(?::\d+)*$~', $time)){
            $newTime = Carbon::createFromFormat('H:i', $time);
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
    public function getShift()
    {
        $num = $this->shift;
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

    public function getTimes($time)
    {

        if($this->shift_start > $this->shift_end){
            if($time < $time->copy()->hour($this->shift_end)){
                $this->clockin = $time->copy()->hour($this->shift_start)->minute(00)->subDay();
                $this->clockout = $time->copy()->hour($this->shift_end)->minute(00);
            }else{
                $this->clockin = $time->copy()->hour($this->shift_start)->minute(00);
                $this->clockout = $time->copy()->hour($this->shift_end)->addDay()->minute(00);
            }
        }else{            
            $this->clockin = $time->copy()->hour($this->shift_start)->minute(00);
            $this->clockout = $time->copy()->hour($this->shift_end)->minute(00);
        }

        return $this;
    }

    public function calulate($timepunches)
    {
        $this->timepunches = collect([]);
        $this->timepunches->push($timepunches);
        $hours = collect([0]);
        foreach($this->timepunches as $timepunch){
            $hours->push($timepunch->calulate());
        }
        $this->hours = $hours->sum();
        return $this->hours;
    }
}
