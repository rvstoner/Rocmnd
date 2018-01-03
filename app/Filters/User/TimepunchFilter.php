<?php

namespace App\Filters\User;

use Carbon\Carbon;
use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class TimepunchFilter extends FilterAbstract
{
	public function filter(Builder $builder, $value)
	{
		$value = Carbon::createFromFormat('m-d-Y', $value)->startOfDay()->toDateString();
		
		return $builder->whereHas('timepunches', function (Builder $builder) use ($value){
			$builder->whereDate('shift_date', '>=', $value);
		});
	}
}