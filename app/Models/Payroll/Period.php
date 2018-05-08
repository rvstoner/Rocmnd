<?php

namespace App\Models\Payroll;

use Carbon\Carbon;
use App\Models\Payroll\Week; 
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY); 
    }
    
    public function getLastPeriod()
    {
        $this->start = (Carbon::now()->day < '15' ? Carbon::now()->copy()->subMonth()->day(16)->startOfDay() : Carbon::now()->copy()->firstOfMonth());
        $this->end = (Carbon::now()->day < '15' ? Carbon::now()->copy()->subMonth()->endOfMonth() : Carbon::now()->copy()->day(15)->endOfDay());

        return $this;
    }
    
    public function calulate()
    {
        $this->breakIntoWeeks();
        $this->label = 'Period';
        $this->readableHours = $this->readableTime($this->hours);
        $this->readableOvertime = $this->readableTime($this->overtime);
        $this->readableRollover = $this->readableTime($this->rollover);
        $this->start = $this->start->toFormattedDateString();
        $this->end = $this->end->toFormattedDateString();

    }

    public function breakIntoWeeks()
    {
        $start = $this->start->copy()->startOfWeek();
        $this->weeks = $period = collect([]);
        $hours = collect([0]);
        $overtime = collect([0]);
        $rollover = collect([0]);
        while($start < $this->end){
            
            if($start->dayOfWeek === Carbon::SUNDAY){
                if ($this->timepunches->where('shift_date', '>=', $start)->where('shift_date', '<=', $start->copy()->endOfWeek())->count()){
                    $week = new Week();
                    $week->start = $start->copy();
                    $week->end = $endOfWeek = $start->copy()->endOfWeek();
                    $this->weeks->push($week);
                    if ($this->timepunches->where('shift_date', '>=', $start)->where('shift_date', '<=', $endOfWeek)->count()){
                        $week->timepunches = $this->timepunches->where('shift_date', '>=', $start)->where('shift_date', '<=', $endOfWeek);
                        $week->calulate($this->start);
                        $hours->push($week->hours);
                        $overtime->push($week->overtime);
                        $rollover->push($week->rollover);
                    }
                }
            }
            $start->addDay();
            
        }
               
        $this->hours = $hours->sum();
        $this->overtime = $overtime->sum();
        $this->rollover = $rollover->sum();
        
    }

    function readableTime($seconds) {
      $t = round($seconds);
      return sprintf('%02d:%02d', ($t/3600),($t/60%60));
    }
}