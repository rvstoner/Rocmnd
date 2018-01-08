<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\Payroll\Team;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::hasSameTeam()->latest()->paginate(20);

        return view('manage.report.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::all();
        return view('manage.report.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'title' => 'required|unique:reports|max:255',
            'color' => 'required',
            'body' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        $report = new Report();
        $type = 'meeting';

        $report->user_id = auth()->user()->id;
        $report->title = $request->title;
        $report->team_id = $request->team_id;
        $report->class_type = $request->color;
        $report->type = $type;
        $report->slug = $request->slug;
        $report->body = $request->body;
        $report->date = new Carbon($request->date . ' ' . $request->time);

        $report->save();

        return redirect()->route('manage.dashboard');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {
        $report = Report::where('id', $param)
            ->orWhere('slug', $param)
            ->firstOrFail();

            return view('manage.report.show',  compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($param)
    {
        $report = Report::where('id', $param)
            ->orWhere('slug', $param)
            ->firstOrFail();
        $teams = Team::all();

        return view('manage.report.edit',  compact('report','teams'));
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

    public function apiCheckUnique(Request $request)
      {
        return json_encode(!Report::where('slug', '=', $request->slug)->exists());
      }
}
