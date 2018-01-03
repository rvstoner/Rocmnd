<?php

namespace App\Filters\User;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends FilterAbstract
{
	public function filter(Builder $builder, $value)
	{
		return $builder->where('id', $value);
	}
}