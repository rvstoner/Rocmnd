<?php

namespace App\Http\Controllers;

use LaraFlash;
use App\Models\Payroll\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facilities = Team::get();

        return view('manage.facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.facilities.create');
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
            'display_name' => 'required|max:255',
            'name' => 'required|max:100',
            'description' => 'sometimes|max:255'
        ]);

        $team = new Team();
        $team->display_name = $request->display_name;
        $team->name = $request->name;
        $team->description = $request->description;
        $team->save();
        LaraFlash::new()->content('Successfully created the new '. $team->display_name . ' Facility.')->type('success')->priority(5);
        return redirect()->route('facilities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $facility = Team::where('id', $id)->with('users')->first();;

        return view('manage.facilities.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facility = Team::where('id', $id)->first();;

        return view('manage.facilities.edit', compact('facility'));
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
            'display_name' => 'required|max:255',
            'description' => 'sometimes|max:255'
        ]);
        $team = Team::findOrFail($id);
        $team->display_name = $request->display_name;
        $team->description = $request->description;
        $team->save();
        LaraFlash::new()->content('Successfully update the '. $team->display_name . ' Facility.')->type('success')->priority(5);
        return redirect()->action('TeamController@index');
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
