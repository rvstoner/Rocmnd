<?php

namespace App\Http\Controllers;

use LaraFlash;
use Carbon\Carbon;
use App\Models\Payroll\{Team, Shift};
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $facility = Team::with('shifts')->findOrFail($id);

        return view('manage.shifts.create', compact('facility'));
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
            'shift_start' => 'required',
            'shift_end' => 'required',
            'shift' => 'required',
        ]);

        $shift = new Shift();
        $shift->shift_start = $shift->getShiftHour($request->shift_start);
        $shift->shift_end = $shift->getShiftHour($request->shift_end);
        $shift->shift = $request->shift;
        $shift->team_id = $request->facility_id;
        $shift->save();

        LaraFlash::new()->content('Successfully created the new shift.')->type('success')->priority(5);
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
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
