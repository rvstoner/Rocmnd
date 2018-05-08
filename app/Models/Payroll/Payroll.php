<?php

namespace App\Models\Payroll;

use App\User;
use Carbon\Carbon;
use App\Models\Payroll\{Period, Week, Day, Shift, TimePunches}; 
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY); 
    }
    
    public function calulateHours($user, $type, $date, $enddate)
    {
    	$this->$type($user, $date, $enddate);
    }

    public function timePunches()
    {
        return $this->hasManyThrough('App\Models\Payroll\TimePunch', 'App\User');
    }

    public function lastPeriod($user, $date, $enddate)
    {
        $this->periods = $period = new Period();
        $this->label = 'Payroll';
        $period->getLastPeriod();
        $period->timepunches = $user->timepunches->where('shift_date', '>=', $period->start->copy()->startOfWeek())->where('shift_date', '<=', $period->end);
        $period->calulate();
    }

    public function range($user, $date, $enddate)
    {
        $this->periods = $period = new Period();
        $this->label = 'Payroll';
        $period->start = $date->copy()->startOfWeek();
        $period->end = $enddate;
        $period->timepunches = $user->timepunches->where('shift_date', '>=', $period->start)->where('shift_date', '<=', $period->end);
        $this->startdate = $period->start->toDateString();
        $this->enddate = $period->end->toDateString();
        $period->calulate();
    }

    public function lastWeek($user, $date, $enddate){
        $week = new Week();
        $week->timepunches = $user->timepunches;
        $week->start = $date->copy()->startOfWeek()->startOfDay();
        $week->calulate($date);
    }
}