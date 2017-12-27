<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('manage')->middleware('role:serveradministrator|payrollmanager|director|assistantdirector|administrator')->group(function () {
	Route::get('/', 'ManageController@index');
	Route::get('/dashboard', 'ManageController@dashboard')->name('manage.dashboard');
	Route::resource('/users', 'UserController');
	Route::get('/onshift', 'ManageController@onshift')->name('users.onshift');
	Route::resource('/permissions', 'PermissionController', ['except' => 'destroy'])->middleware('role:serveradministrator');
	Route::resource('/roles', 'RoleController', ['except' => 'destroy']);
	Route::get('shifts/create/{id}', 'ShiftController@create')->name('shifts.create');
	Route::resource('/shifts', 'ShiftController', ['except' => [
		'destroy', 'create', 'show'
	]]);
	Route::resource('/timesheets', 'PayrollController');
	Route::resource('/facilities', 'TeamController');
});
Route::post('clockout', 'PayrollController@clockout')->name('clockout');
Route::post('clockin', 'PayrollController@clockin')->name('clockin');


Route::get('/home', 'HomeController@index')->name('home');
