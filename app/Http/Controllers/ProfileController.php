<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use LaraFlash;
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
        $user = User::findOrFail($id);

        return view('profile.edit', compact('user'));
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
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'home_phone_area' => 'required_with:home_phone_prefix,home_phone_number',
            'home_phone_prefix' => 'required_with:home_phone_area,home_phone_number',
            'home_phone_number' => 'required_with:home_phone_prefix,home_phone_area',
            'secondary_phone_area' => 'required_with:secondary_phone_prefix,secondary_phone_number',
            'secondary_phone_prefix' => 'required_with:secondary_phone_area,secondary_phone_number',
            'secondary_phone_number' => 'required_with:secondary_phone_prefix,secondary_phone_area',
            'emergency_phone_area' => 'required_with:emergency_phone_prefix,emergency_phone_number',
            'emergency_phone_prefix' => 'required_with:emergency_phone_area,emergency_phone_number',
            'emergency_phone_number' => 'required_with:emergency_phone_prefix,emergency_phone_area',
            
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // foreach ($errors->all() as $message) {
            //     LaraFlash::new()->content($message)->type('danger');

            // }
            // $laraFlash = LaraFlash::notifications();
            return redirect()->route('profile.edit', ['id' => $id])
                        ->withErrors($validator)
                        ->withInput();
        }
    }
}
