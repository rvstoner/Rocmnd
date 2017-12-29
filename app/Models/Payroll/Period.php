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
    	$this->start = (Carbon::now()->day < '15' ? Carbon::now()->copy()->subMonth()->day(16)->startOfWeek() : Carbon::now()->copy()->firstOfMonth()->startOfWeek());
        $this->end = (Carbon::now()->day < '15' ? Carbon::now()->copy()->subMonth()->endOfMonth() : Carbon::now()->copy()->day(15)->endOfDay());
        return $this;
    }

    public function calulate()
    {
        $this->breakIntoWeeks();

    }

    public function breakIntoWeeks()
    {
        $start = $this->start->copy();
        $this->period = $period = collect([]);
        $hours = collect([0]);
        $overtime = collect([0]);
        $rollover = collect([0]);
        while($start <= $this->end){
            
            if($start->dayOfWeek === Carbon::SUNDAY){
                $week = new Week();                
                $week->start = $start->copy();
                $endOfWeek = $start->copy();
                $week->end = $endOfWeek->endOfWeek();
                $endOfWeek = $endOfWeek->endOfWeek();
                $this->period->push($week);
                if ($this->timepunches->where('shift_date', '>=', $start)->where('shift_date', '<=', $endOfWeek)->count()){
                    $week->timepunches = $this->timepunches->where('shift_date', '>=', $start)->where('shift_date', '<=', $endOfWeek);
                    $week->calulate();
                    $hours->push($week->hours);
                    $overtime->push($week->overtime);
                    $rollover->push($week->rollover);
                }
            }
            $start->addDay();
        }
        $this->hours = $hours->sum();
        $this->overtime = $overtime->sum();
        $this->rollover = $rollover->sum();
    }
}
