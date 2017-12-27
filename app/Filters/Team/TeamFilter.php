<?php

namespace App\Filters\Team;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class TeamFilter extends FilterAbstract
{
	public function filter(Builder $builder, $value)
	{
		return $builder->where('id', $value);
	}
}