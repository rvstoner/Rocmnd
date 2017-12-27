<?php

namespace App\Filters\Team;

use Carbon\Carbon;
use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class TimepunchFilter extends FilterAbstract
{
	public function filter(Builder $builder, $value)
	{
		return $builder->whereHas('users', function (Builder $builder) use ($value){
			return $builder->whereHas('timepunches', function (Builder $builder) use ($value){
				$builder->where('time_punches.id', $value);
			});
		});
	}
}