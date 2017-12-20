<?php

namespace App\Models\Payroll;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
		'name',
		'display_name',
		'description'
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

}
