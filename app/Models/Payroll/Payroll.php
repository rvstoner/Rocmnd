<?php

namespace App\Models\Payroll;

use App\User;
use Carbon\Carbon;
use App\Models\Payroll\{Period, Week, Day, Shift, TimePunches}; 
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    public function calulateHours($user, $type = Null, $date = Null, $enddate = NULL)
    {
    	$this->$type($user);
    }

    public function timePunches()
    {
        return $this->hasManyThrough('App\Models\Payroll\TimePunch', 'App\User');
    }

    public function lastPeriod($user)
    {
        $this->period = $period = new Period();
        $period->getLastPeriod();
        $period->timepunches = $user->getTimepunches($period->start, $period->end)->get();
        $period->calulate();
    }
}