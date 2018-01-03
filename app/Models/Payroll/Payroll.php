<?php

namespace App\Models\Payroll;

use App\User;
use Carbon\Carbon;
use App\Models\Payroll\{Period, Week, Day, Shift, TimePunches}; 
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    
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
        $this->period = $period = new Period();
        $period->getLastPeriod();
        $period->timepunches = $user->timepunches->where('shift_date', '>=', $period->start->copy()->startOfWeek())->where('shift_date', '<=', $period->end);
        $period->calulate();
    }

    public function range($user, $date, $enddate)
    {
        $this->period = $period = new Period();
        $period->start = $date->copy()->startOfWeek();
        $period->end = $enddate;
        $period->timepunches = $user->timepunches->where('shift_date', '>=', $period->start)->where('shift_date', '<=', $period->end);
        $period->calulate();
    }
}