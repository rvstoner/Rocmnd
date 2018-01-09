<?php

namespace App\Http\Controllers;

use LaraFlash;
use Carbon\Carbon;
use App\Models\Report;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reportTypes = Report::where('date', '>', Carbon::now())->where('team_id', auth()->user()->team_id)->oldest('date')->with('user')->get();

        return view('home', compact('reportTypes'));
    }
}
