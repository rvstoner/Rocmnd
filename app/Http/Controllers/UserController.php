<?php
namespace App\Http\Controllers;
use DB;
use Hash;
use Input;
use LaraFlash;
use Carbon\Carbon;
use App\{User, Role};
use Illuminate\Http\Request;
use App\Models\Payroll\Team;
use App\Models\User\TempPassword;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users = User::hasSameTeam()->orderBy('id', 'desc')->with('roles', 'team')->paginate(20);
      
      return view('manage.users.index')->withUsers($users);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $roles = Role::all();
      $teams = Team::all();
      return view('manage.users.create', compact('roles', 'teams'));
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
        'username' => 'required|max:255',
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required_with:password_confirmation',
        'password_confirmation' => 'required_with:password|same:password',
      ]);
      if (!empty($request->password)) {
        $password = trim($request->password);
      } else {
        # set the manual password
        $length = 10;
        $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        $password = $str;
      }
      if(!empty($request->team)){
        $team = $request->team;
      }else{
        $team = auth()->user()->team_id;
      }
      $user = new User();
      $user->username = $request->username;
      $user->first_name = $request->first_name;
      $user->last_name = $request->last_name;
      $user->team_id = $team;
      $user->email = $request->email;
      $user->password = Hash::make($password);
      $user->hire_date = Carbon::now()->startOfDay();
      $user->save();
      
      if ($request->roles) {
        $user->syncRoles(explode(',', $request->roles));
      }
      LaraFlash::new()->content('Successfully created the new a new User.')->type('success')->priority(5);
      return redirect()->route('users.show', $user->id);
      
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = User::where('id', $id)->with('roles')->with(['timepunches' => function ($qurey) {
        $qurey->orderBy('shift_date', 'desc')->take(100);
      }])->first();
      $user->timepunches = $user->timepunches->sortBy('clock_in');
      // dd($user->timepunches);
      $user->getHours();
      // dd($user->payroll->period->weeks);
      return view("manage.users.show")->withUser($user);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $roles = Role::all();
      $user = User::where('id', $id)->with('roles')->first();
      return view("manage.users.edit")->withUser($user)->withRoles($roles);
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
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'home_phone_area' => 'required_with_all:home_phone_prefix,home_phone_number|digits:3',
        'home_phone_prefix' => 'required_with_all:home_phone_area,home_phone_number|digits:3',
        'home_phone_number' => 'required_with_all:home_phone_prefix,home_phone_area|digits:4',
        'secondary_phone_area' => 'required_with_all:secondary_phone_prefix,secondary_phone_number|digits:3',
        'secondary_phone_prefix' => 'required_with_all:secondary_phone_area,secondary_phone_number|digits:3',
        'secondary_phone_number' => 'required_with_all:secondary_phone_prefix,secondary_phone_area|digits:4',
        
      ]);
      $user = User::findOrFail($id);
      $user->first_name = $request->first_name;
      $user->last_name = $request->last_name;
      $user->home_phone_area = $request->home_phone_area;
      $user->home_phone_prefix = $request->home_phone_prefix;
      $user->home_phone_number = $request->home_phone_number; 
      $user->secondary_phone_area = $request->secondary_phone_area;
      $user->secondary_phone_prefix = $request->secondary_phone_prefix;
      $user->secondary_phone_number = $request->secondary_phone_number;
      if ($request->password_options == 'auto') {
        $length = 10;
        $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        $user->password = Hash::make($str);
        // $tempPassword = TempPassword::updateOrCreate(
        //     ['user_id' => $user->id],
        //     ['password' => $str]
        // );
        // $user->tempPassword()->updateOrCreate($tempPassword);
      } elseif ($request->password_options == 'manual') {
        $user->password = Hash::make($request->password);
      }
      $user->save();
      $user->syncRoles(explode(',', $request->roles));
      LaraFlash::new()->content('Successfully updated user.')->type('success')->priority(5);
      return redirect()->route('users.show', $id);
      // if () {
      //   return redirect()->route('users.show', $id);
      // } else {
      //   Session::flash('error', 'There was a problem saving the updated user info to the database. Try again later.');
      //   return redirect()->route('users.edit', $id);
      // }
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