<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Payroll\Period;

class ProfileController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $period = new Period();
        $period->getLastPeriod();
        $period->end = Carbon::now()->endOfDay();
        $startOfPeriod = $period->start->startOfWeek();
        $endOfPeriod = $period->end;

        $user = User::with(['timepunches' => function ($qurey) use ($startOfPeriod, $endOfPeriod){
            $qurey->whereBetween('shift_date', [$startOfPeriod, $endOfPeriod])->
                    orderBy('clock_in', 'asc');
        }])->with('roles')->findOrFail($id);

        $user->getHours('range', $startOfPeriod, $endOfPeriod);
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
