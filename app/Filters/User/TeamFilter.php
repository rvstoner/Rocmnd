<?php

namespace App\Filters\User;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class TeamFilter extends FilterAbstract
{
	public function filter(Builder $builder, $value)
	{
		return $builder->whereHas('team', function (Builder $builder) use ($value){
			$builder->where('id', $value);
		});
	}
}