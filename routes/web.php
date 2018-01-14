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

Route::prefix('manage')->middleware('role:serveradministrator|payrollmanager|director|assistantdirector|administrator|parttimesupervisor')->group(function () {
	Route::get('/', 'ManageController@index');
	Route::get('/dashboard', 'ManageController@dashboard')->name('manage.dashboard');
	Route::resource('/users', 'UserController');
	Route::get('/onshift', 'ManageController@onshift')->name('users.onshift');
	Route::resource('/permissions', 'PermissionController', ['except' => 'destroy'])->middleware('role:serveradministrator');
	Route::resource('/roles', 'RoleController', ['except' => 'destroy']);
	Route::get('address/create/{id}', 'AddressController@create')->name('address.create');
	Route::resource('/address', 'AddressController', ['except' => [
		'destroy', 'create', 'show'
	]]);
	Route::get('shifts/create/{id}', 'ShiftController@create')->name('shifts.create');
	Route::resource('/shifts', 'ShiftController', ['except' => [
		'destroy', 'index', 'create', 'show'
	]]);
	route::get('usertimesheet/{id}', 'PayrollController@user')->name('timesheets.user');
	Route::resource('/timesheets', 'PayrollController');
	Route::resource('/facilities', 'TeamController');
	Route::resource('/reports', 'ReportController');
	Route::get('/pto/otconversion', 'PtoController@otToPto');
	Route::resource('/pto', 'PtoController', ['except' => [
		'destroy', 'create', 'show'
	]]);
	Route::get('/ipcheck', 'manageController@address')->middleware('role:serveradministrator');
});
Route::middleware('auth')->group(function () {
    
    Route::resource('/profile', 'ProfileController', ['except' => [
		'destroy', 'index', 'create', 'store'
	]]);
	Route::post('clockout', 'PayrollController@clockout')->name('clockout');
	Route::post('clockin', 'PayrollController@clockin')->name('clockin');


	Route::get('/home', 'HomeController@index')->name('home');
});


