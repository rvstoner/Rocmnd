<?php

namespace App\Models\Payroll;

use App\User;
use App\Models\Payroll\Shift;
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

    public function shifts()
    {
        return $this->hasMany('App\Models\Payroll\Shift');
    }

}
