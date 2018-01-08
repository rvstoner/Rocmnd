<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use App\Models\Payroll\Team;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
		'user_id',
		'title',
		'class_type',
		'type',
		'slug',
		'body',
		'date',
    ];

     protected $dates = [
        'date',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function team()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeHasSameTeam($query)
    {
        if(auth()->user()->can('create-facilities')){
            return $query;
        }
        return $query->where('team_id', auth()->user()->team_id);
    }
}
