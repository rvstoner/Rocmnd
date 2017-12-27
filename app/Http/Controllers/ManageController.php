<?php
namespace App\Http\Controllers;

use App\User;
use App\Models\Payroll\Team;
use Illuminate\Http\Request;

class ManageController extends Controller
{
    public function index()
    {
      return redirect()->route('manage.dashboard');
    }
    public function dashboard()
    {
      return view('manage.dashboard');
    }

    public function clockedin()
    {
        $users = User::hasSameTeam()->onShift()->get();
        
        return view('manage.onshift')->withUsers($users);
    }

    public function onshift()
    {
		$users = User::hasSameTeam()->OnShift()->get();
		return view('manage.onshift')->withUsers($users);
    }
}