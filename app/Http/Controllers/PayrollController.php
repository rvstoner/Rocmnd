<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Payroll\{TimePunch, Team, TimePunchEdits, Period};

class PayrollController extends Controller
{
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY); 
    }
    
    public function clockin(Request $request)
    {
        if(!auth()->user()->getClockinStatus()){
            $clockin = new TimePunch;
            $clockin->clock_in = $clockin->roundTime(Carbon::now());
            $clockin->reason = $request->reason;
            $clockin->shift = $clockin->setShift(Carbon::now());
            $clockin->user_id = auth()->user()->id;
            $clockin->shift_date = $clockin->getStartOfDay(Carbon::now());
            $clockin->save();
            $cacheKey = 'clockin_' . auth()->user()->id;
            Cache::put($cacheKey, true, 60);
        }
    	

        return back();
    }

    public function clockout()
    {
        if(auth()->user()->getClockinStatus()){
            $timePunch = auth()->user()->getLastTimePunch();
            $timePunch->clockout();
        }
        return back();
    }

    public function index(Request $request)
    {
    
        $users = User::with(['timepunches', 'team'])->filter($request, $this->getFilters())->hasSameTeam()->get();

        foreach($users as $user){
            $user->getHours();
        }
        $teams = $users->groupBy('team_id');
        
        return view('manage.timesheets.index', compact('teams'));
        
    }

    protected function getFilters()
    {
        return [
            //
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::hasSameTeam()->get();

        return view('manage.timesheets.create', compact('users'));

    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateWith([
            'user' => 'required',
            'reason' => 'required',
            'clockin_date' => 'required',
            'clockin_time' => 'required',
            'clockout_date' => 'required_with:clockout_time',
            'clockout_time' => 'required_with:clockout_date',
            'edit_reason' => 'required|max:255',
          ]);
        
        $clockin = new Carbon($request->clockin_date . ' ' . $request->clockin_time);        

        $timepunch = new TimePunch;
        $timepunch->clock_in = $timepunch->roundTime($clockin);
        $timepunch->user_id = $request->user;
        $timepunch->reason = $request->reason;
        $timepunch->shift = $timepunch->setShift($clockin);
        $timepunch->shift_date = $timepunch->setShiftDate($clockin);
        $timepunch->edited = 1;
        $timepunch->save();
        if(!empty($request->clockout_date)){
            $clockout = new Carbon($request->clockout_date . ' ' . $request->clockout_time);
            $timepunch->clockout($clockout);
        }

        $timepunchedits = new TimePunchEdits();
        $timepunchedits->clock_in = $timepunch->clock_in;
        $timepunchedits->clock_out = $timepunch->clock_out;
        $timepunchedits->time_punch_id = $timepunch->id;
        $timepunchedits->user_id = auth()->user()->id;
        $timepunchedits->reason = $timepunch->reason;
        $timepunchedits->save();


        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $timepunch = TimePunch::where('id', $id)->with('user')->first();

        if($timepunch->edited){
            $timepunchedit = TimePunchEdits::where('time_punch_id', $id)->with('user')->first();
        }

        return view('timesheets.show',compact('timepunch', 'timepunchedit'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $timepunch = TimePunch::where('id', $id)->with('user')->first();

        return view('manage.timesheets.edit',compact('timepunch'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateWith([
            'reason' => 'required',
            'clockin_date' => 'required_with:clockin_time',
            'clockin_time' => 'required_with:clockin_date',
            'clockout_date' => 'required_with:clockout_time',
            'clockout_time' => 'required_with:clockout_date',            
          ]);
        $userid = auth()->user()->id;

        $timepunch = TimePunch::where('id', $id)->first();
        $oldClockin = $timepunch->clock_in;    
        $oldClockout = $timepunch->clock_out; 

        if(!empty($request->clockin_date)){
            $timepunch->clock_in = new Carbon($request->clockin_date . ' ' . $request->clockin_time);
            $timepunch->shift_date = $timepunch->setShiftDate($timepunch->clock_in);
        }    
        if(!empty($request->clockout_date)){
            $timepunch->clock_out = new Carbon($request->clockout_date . ' ' . $request->clockout_time);
        }
        $timepunch->edited = 1;
        $timepunch->save();
// dd($oldClockout);
        TimePunchEdits::create([
            'clock_in' => $oldClockin,
            'clock_out' => $oldClockout,
            'user_id' => $userid,
            'reason' => $request->reason,
            'time_punch_id' => $timepunch->id
        ]);

        return redirect()->route('manage.dashboard');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user($id)
    {
        $period = new Period();
        $period->getLastPeriod();
        $startOfPeriod = $period->start->startOfWeek();

        $endOfPeriod = $period->end;

        $user = User::with(['timepunches' => function ($qurey) use ($startOfPeriod, $endOfPeriod){
            $qurey->whereBetween('shift_date', [$startOfPeriod, $endOfPeriod])->
                    orderBy('clock_in', 'asc');
        }])->findOrFail($id);

        $user->getHours();

        return view('manage.timesheets.user', compact('user'));
    }

}
