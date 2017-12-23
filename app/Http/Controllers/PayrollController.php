<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Payroll\{TimePunch, Team};

class PayrollController extends Controller
{
    public function clockin(Request $request)
    {
    	$clockin = new TimePunch;
    	$clockin->clock_in = $clockin->roundTime(Carbon::now());
    	$clockin->reason = $request->reason;
        $clockin->shift = $clockin->setShift(Carbon::now());
        $clockin->user_id = auth()->user()->id;
        $clockin->shift_date = $clockin->getStartOfDay(Carbon::now());
        $clockin->save();

        return back();
    }

    public function clockout()
    {
    	$clockout = auth()->user()->latestTimePunch;
        $clockout->clockout(Carbon::now());

        return back();
    }

    public function index()
    {
        dd(new Carbon('first day of January 2008'));
        $teams = Team::with('users')->get();
        foreach($teams as $team){
            foreach($team->users as $user){
                $user->getHours();
            }
            dd($team);
        }
    }


}
