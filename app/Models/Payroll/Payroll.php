<?php

namespace App\Models\Payroll;

use App\User;
use Carbon\Carbon;
use App\Models\Payroll\{Period, Week, Day, Shift, TtimePunches}; 
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    public function something($timePunches, $periodType = NULL)
    {
    	foreach($timePunches as $timePunch)
    	{
    		dd(Carbon::parse('two months ago'));
    	}
    }
}