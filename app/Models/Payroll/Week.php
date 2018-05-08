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

    public function calulate($date)
    {    	 
    	$this->end = $this->start->copy()->endOfWeek();  
    	$this->breakIntoDays($date);
        $this->checkForOverTime();

        if($this->hours < 0){
            $this->hours = 0;
        }
        $this->readableHours = $this->readableTime($this->hours);
        $this->readableOvertime = $this->readableTime($this->overtime);
        $this->readableRollover = $this->readableTime($this->rollover);
        $this->start = $this->start->toFormattedDateString();
        $this->end = $this->end->toFormattedDateString();
        $this->label = 'weeks';
    }

    public function breakIntoDays($date)
    {
    	$day = new Day();
        $day->start =  $this->start;
        $hours = collect([0]);
    	$rollover = collect([0]);
        $this->days = collect([]);
        $this->timepunches->sortBy('shift_date');
        $timepunchesGrouped = $this->timepunches->groupBy(function($date) {
            return Carbon::parse($date->shift_date)->format('Y-m-d');
        });
        foreach($timepunchesGrouped as $timepunches){
            if($this->checkForRollOver($date, $timepunches->first()->shift_date)){
                $day = new Day();
                $day->start = $timepunches->first()->shift_date;
                $rollover->push($day->calulate($timepunches));
                $this->days->push($day);
            }else{
                $day = new Day();
                $day->start = $timepunches->first()->shift_date;
                $hours->push($day->calulate($timepunches));
                $this->days->push($day);
            }
        
            
        }
        $this->hours = $hours->sum();
        $this->rollover = $rollover->sum();
    }

    public function checkForOverTime(){
        if(($this->hours + $this->rollover) > 144000){
            $hours = $this->hours + $this->rollover;
            $this->overtime = $hours - 144000;
            $this->hours = $this->hours - $this->overtime;
        }else{
            $this->overtime = 0;
        }
    }    

    public function checkForRollOver($start, $date)
    {
        if($start > $date){
            return true;
        }
        return false;
    }  

    private function readableTime($seconds) {
      $t = round($seconds);
      return sprintf('%02d:%02d', ($t/3600),($t/60%60));
    }
    
}
