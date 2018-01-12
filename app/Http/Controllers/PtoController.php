<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class PtoController extends Controller
{
	public function index()
	{
		$users = User::hasSameTeam()->orderBy('id', 'desc')->with('roles', 'team')->paginate(20);

		return view('manage.pto.index', compact('users'));
	}

    public function store()
    {
    	$users = User::hasSameTeam()->whereNotNull('pto_amount')->get();
    	$ptoSetDate = Carbon::now()->subMonth()->endOfMonth();
    	foreach($users as $user){
    		if(empty($user->pto_set_date)){
    			$user->pto_set_date = Carbon::now()->subMonths(2);
    		}
    		if(!$ptoSetDate->isSameDay($user->pto_set_date)){
    			$this->setPto($user);
    			$user->pto_set_date = $ptoSetDate;
				$user->save();
    		}
    	}
        return redirect()->route('manage.dashboard');
    }

    public function setPto($user)
    {
        $ptoAmount = $user->pto_amount;
		$user->pto = $user->pto + $user->pto_amount;
		
    }

    public function edit($id)
    {
    	$user = User::findOrFail($id);
       
       return view('manage.pto.edit', compact('user'));		
    }

    public function update(Request $request, $id)
    {
    	$this->validateWith([
          'pto' => 'required|max:4',
          'pto_amount' => 'required|max:2',
        ]);
    	$user = User::findOrFail($id);
    	$user->pto = $request->pto;
    	$user->pto_amount = $request->pto_amount;
    	$user->save();
    	
       return redirect()->route('manage.dashboard');		
    }
}
