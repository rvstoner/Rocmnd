<?php

namespace App\Filters\Team;

use Illuminate\Http\Request;
use App\Filters\FiltersAbstract;
use App\Filters\Team\{TeamFilter, UserFilters, TimepunchFilter};
use Illuminate\Database\Eloquent\Builder;

class TeamFilters extends FiltersAbstract
{
	protected $filters = [

		'user' => UserFilters::class,
		'team' => TeamFilter::class,
		'timepunch' => TimepunchFilter::class,
	];
}