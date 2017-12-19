<?php
namespace App\Http\Controllers;

use App\User;
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
}