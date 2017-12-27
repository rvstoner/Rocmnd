<?php

namespace App\Filters\Team;

use Illuminate\Database\Eloquent\Builder;

class UserFilters 
{
	public function filter(Builder $builder, $value)
	{
		return $builder->whereHas('users', function (Builder $builder) use ($value){
			$builder->where('id', $value);
		});
	}
}