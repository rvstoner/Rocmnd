<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Payroll\{TimePunch, Team};

class PayrollController extends Controller
{
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY); 
    }
    
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

    public function index(Request $request)
    {
    
        $teams = Team::hasSameTeam()->usersOnShift()->get();

        foreach($teams as $team){
            foreach($team->users as $user){
                $user->getHours('lastPeriod');
            }
        }
        return view('manage.timesheets.index', compact('teams'));
        // return Team::with('users.timepunches')->filter($request, $this->getFilters())->get();
        
    }

    public function period(Request $request, $Date, $team = NULL)
    {
        return Team::with('users.timepunches')->get();
        // return Team::with('users.timepunches')->filter($request, $this->getFilters())->get();
        
    }

    public function range(Request $request, $startDate, $endDate, $team = NULL)
    {
        return Team::with('users.timepunches')->get();
        // return Team::with('users.timepunches')->filter($request, $this->getFilters())->get();
        
    }

    public function week(Request $request, $Date, $team = NULL)
    {
        return Team::with('users.timepunches')->get();
        // return Team::with('users.timepunches')->filter($request, $this->getFilters())->get();
        
    }

    public function day(Request $request, $Date, $team = NULL)
    {
        return Team::with('users.timepunches')->get();
        // return Team::with('users.timepunches')->filter($request, $this->getFilters())->get();
        
    }

    public function shift(Request $request, $Date, $shift, $team = NULL)
    {
        return Team::with('users.timepunches')->get();
        // return Team::with('users.timepunches')->filter($request, $this->getFilters())->get();
        
    }

    protected function getFilters()
    {
        return [
            //
        ];
    }


}
