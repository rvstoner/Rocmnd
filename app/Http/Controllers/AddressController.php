<?php

namespace App\Http\Controllers;

use LaraFlash;
use Illuminate\Http\Request;
use App\Models\Payroll\{Team, IpAddress};

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	 $facilities = Team::with('addresses')->get();
        return view('manage.address.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $facility = Team::with('addresses')->findOrFail($id);

        return view('manage.address.create', compact('facility'));
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
            'address' => 'required|unique:ip_addresses',
        ]);

        $ip = new IpAddress();
  		$ip->address = $request->address; 
  		$ip->team_id = $request->facility_id; 
        $ip->save();

        LaraFlash::new()->content('Successfully added a new Ip address.')->type('success')->priority(5);
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
        $ip = IpAddress::findOrFail($id)->with("team");
        return view('manage.address.show', compact('$ip'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ip = IpAddress::findOrFail($id);
        return view('manage.address.show', compact('$ip'));
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
            'address' => 'required',
        ]);

        $ip = IpAddress::findOrFail($id)->with("team");
  		$ip->address = $request->address; 
        $ip->save();

        LaraFlash::new()->content('Successfully added a new Ip address.')->type('success')->priority(5);
        return view('manage.address.show', compact('$id'));    }

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
