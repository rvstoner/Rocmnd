<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Payroll\TimePunch;

class PayrollController extends Controller
{
    public function clockin(Request $request)
    {
    	$clockin = new TimePunch;
    	$clockin->clock_in = $clockin->roundTime(Carbon::now());
    	$clockin->reason = $request->reason;
        $clockin->user_id = Auth::user()->id;
        $clockin->shift_date = $clockin->getShiftDate(Carbon::now());
        $clockin->save();

        return back();
    }

    public function clockout()
    {
    	$clockin = new TimePunch;
    	$clockin->clock_in = $clockin->roundTime(Carbon::now());
    	$clockin->reason = $request->reason;
    }
}
