<?php

namespace App\Models\Payroll;

use App\User;
use App\Filters\Team\TeamFilters;
use App\Models\Payroll\{Shift, team};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Team extends Model
{
    protected $fillable = [
		'name',
		'display_name',
        'description',
		'ip_address'
    ];

    
    public function scopeUsersOnShift($query)
    {
        return $this->hasMany('App\User')->whereHas('timepunches', function ($Query) {
            $Query->latest('shift_date')->where('clock_out', NULL);
        });
    }
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function shifts()
    {
        return $this->hasMany('App\Models\Payroll\Shift');
    }

    public function timePunches()
    {
        return $this->hasManyThrough('App\Models\Payroll\TimePunch', 'App\User');
    }

    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        return (new TeamFilters($request))->add($filters)->filter($builder);
    }

    public function scopeHasSameTeam($query)
    {
        if(auth()->user()->can('create-facilities')){
            return $query;
        }
        return $query->where('id', auth()->user()->team_id);
    }

}
