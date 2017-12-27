<?php

namespace App\Models\Payroll;

use Carbon\Carbon;
use App\Models\Payroll\{Shift, Period};
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY); 
    }

    public function calulate($timepunches, $date = NULL)
    {
    	if(empty($date) && empty($this->start)){
    		return back();
    	}
    	if (!empty($date)){
    		$this->start = $date;    		
    	} 
    	$this->timepunches = $timepunches; 
    	$this->breakIntoShifts();
    	return $this->hours;
    }

    public function breakIntoShifts()
    {
        $this->period = $period = collect([]);
        $x = 1;
        $hours = collect([0]);
        while($x < 4){
            if($this->timepunches->where('shift', $x)->count()){
            	$shift = new Shift();
	            $shift->start = $this->start; 
	            $hours->push($shift->calulate($this->timepunches->where('shift', $x)));
	            $this->period->push($shift);
            }
            $x++;
        }
        $this->hours = $hours->sum();
    }

}
