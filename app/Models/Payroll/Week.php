<?php

namespace App\Models\Payroll;

use Carbon\Carbon;
use App\Models\Payroll\{Day,Period}; 
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
	public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY); 
    }

    public function calulate($date = NULL)
    {
    	if(empty($date) && empty($this->start)){
    		return back();
    	}
    	if (!empty($date)){
    		$this->start = $date->startOfWeek();    		
    	}
    	$this->end = $this->start->copy()->endOfWeek();  
    	$this->breakIntoDays();
        $this->checkForOverTime();
    	
    }

    public function breakIntoDays()
    {
    	$weekStart = $this->start->copy();
        $hours = collect([0]);
    	$rollover = collect([0]);
        $this->period = $period = collect([]);
        while($weekStart <= $this->end){
            if($this->checkForRollOver($weekStart)){
                if($this->timepunches->where('shift_date', $weekStart)->count()){
                    $day = new Day();
                    $day->start = $weekStart->copy();
                    $rollover->push($day->calulate($this->timepunches->where('shift_date', $weekStart)));
                    $this->period->push($day);
                }
            }else{
                if($this->timepunches->where('shift_date', $weekStart)->count()){
                    $day = new Day();
                    $day->start = $weekStart->copy();
                    $hours->push($day->calulate($this->timepunches->where('shift_date', $weekStart)));
                    $this->period->push($day);
                }
            }
    
            
            
            $weekStart->addDay();
        }
        $this->hours = $hours->sum();
        $this->rollover = $rollover->sum();
    }

    public function checkForOverTime(){
        if($this->hours > 144000){
            $hours = $this->hours;
            $this->overtime = $hours - 144000;
            $this->hours = $this->hours - $this->overtime;
        }else{
            $this->overtime = 0;
        }
    }    

    public function checkForRollOver($date)
    {
    	$period = new Period();
        $period->getLastPeriod();
        if($period->end->day === 15){
            if($date->day > 15){
                return true;
            }
            return false;

        }else{
            if($date->day < 15){
                return true;
            }
            return false;
        }
        
    }    
    
}
