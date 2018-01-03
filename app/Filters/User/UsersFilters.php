<?php

namespace App\Filters\User;

use Illuminate\Http\Request;
use App\Filters\FiltersAbstract;
use App\Filters\User\{TeamFilter, UserFilters, TimepunchFilter};
use Illuminate\Database\Eloquent\Builder;

class UsersFilters extends FiltersAbstract
{
	protected $filters = [

		'user' => UserFilter::class,
		'team' => TeamFilter::class,
		'timepunch' => TimepunchFilter::class,
	];
}