<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Payroll\{TimePunch, Team, TimePunchEdits};

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
    
        // return User::with(['timepunches', 'team'])->filter($request, $this->getFilters())->get();

        // dd($users);
        $teams = Team::hasSameTeam()->with('users')->get();

        foreach($teams as $team){
            foreach($team->users as $user){
                $user->getHours('lastPeriod');
            }
        }
        return view('manage.timesheets.index', compact('teams'));
        // // return Team::with('users.timepunches')->filter($request, $this->getFilters())->get();
        
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
        
        $clockin = $this->format($request->clockin_time, $request->clockin_date);
        $clockout = $this->format($request->clockout_time, $request->clockout_date);

        $timepunch = new TimePunch;
        $timepunch->clock_in = $timepunch->roundTime($clockin);
        $timepunch->clock_out = $timepunch->roundTime($clockout);
        $timepunch->user_id = $request->user;
        $timepunch->reason = $request->reason;
        $timepunch->shift_date = $clockin->copy()->startofDay();
        $timepunch->edited = 1;
        $timepunch->save();

        $timepunchedits = new TimePunchEdit();
        $timepunchedits->clock_in = $timepunch->clock_in;
        $timepunchedits->clock_out = $timepunch->clock_out;
        $timepunchedits->time_punch_id = $timepunch->id;
        $timepunchedits->user_id = auth()->user()->id;
        $timepunchedits->reason = $timepunch->reason;
        $timepunch->save();


        // return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $timepunch = TimePunch::where('id', $id)->with('user')->first();

        // if($timepunch->edited){
        //     $timepunchedit = TimePunchEdits::where('time_punch_id', $id)->with('user')->first();
        // }

        // return view('timesheets.show',compact('timepunch', 'timepunchedit'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $timepunch = TimePunch::where('id', $id)->with('user')->first();

        // return view('timesheets.edit',compact('timepunch'));

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
        $userid = Auth::id();

        $clockinnew = NULL;

        $clockoutnew = NULL;

        $timepunch = TimePunch::where('id', $id)->first();

        $timepunch->clock_out->format('m/d/Y');

        $timepunch->clock_out->format('h:i A');

        if(!empty($request->clockin_date) || !empty($timepunch->clock_in)){
            if (empty($request->clockin_date)){
                $request->clockin_date = $timepunch->clock_in->format('m/d/Y');
            }

            if (empty($request->clockin_time)){
                $request->clockin_time = $timepunch->clock_in->format('h:i A');
            }

            if(preg_match('~^\d+(?::\d+)*$~', $request->clockin_time)){
                $clockinnew = Carbon::createFromFormat('m/d/Y h:i', $request->clockin_date . ' ' . $request->clockin_time);
            }else{
                $clockinnew = Carbon::createFromFormat('m/d/Y h:i A', $request->clockin_date . ' ' . $request->clockin_time);            
            }
        }

        if(!empty($request->clockout_date) || !empty($timepunch->clock_out)){
            if (empty($request->clockout_date)){
                $request->clockout_date = $timepunch->clock_out->format('m/d/Y');
            }

            if (empty($request->clockout_time)){
                $request->clockout_time = $timepunch->clock_out->format('h:i A');
            }

            if(preg_match('~^\d+(?::\d+)*$~', $request->clockout_time)){
                $clockoutnew = Carbon::createFromFormat('m/d/Y h:i', $request->clockout_date . ' ' . $request->clockout_time);
            }else{
                $clockoutnew = Carbon::createFromFormat('m/d/Y h:i A', $request->clockout_date . ' ' . $request->clockout_time);            
            }
        }
            
        
        // dd($clockoutnew);
        TimePunchEdits::create([
            'clock_in' => $timepunch->clock_in,
            'clock_out' => $timepunch->clock_out,
            'user_id' => $userid,
            'reason' => $request->reason,
            'time_punch_id' => $timepunch->id
        ]);

        if($clockinnew->hour <= 7){
            $timepunch->shift_date = $clockinnew->subDay()->startOfDay();
        }
        $timepunch->edited = 1;
        $timepunch->clock_in = $clockinnew;
        $timepunch->clock_out = $clockoutnew;
        $timepunch->save();

        return $this->index();
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user($id)
    {
        $startOfPeriod = Carbon::now()->subMonths(2);

        $endOfPeriod = Carbon::now();

        $user = User::with(['timepunches' => function ($qurey) use ($startOfPeriod, $endOfPeriod){
            $qurey->whereBetween('shift_date', [$startOfPeriod, $endOfPeriod])->
                    orderBy('clock_in', 'asc');
        }])->findOrFail($id);

        $user->calulateHours();

        foreach($user->weeks as $week){
            $week->sortBy('clock_in');
        }
        // dd($user);

        return view('timesheets.user', compact('user'));
    }

    protected function format($time, $date)
    {
        if(preg_match('~^\d+(?::\d+)*$~', $time)){
                return Carbon::createFromFormat('m/d/Y H:i', $date . ' ' . $time);
            }else{
                return Carbon::createFromFormat('m/d/Y h:i A', $date . ' ' . $time);            
            }
    }

}
