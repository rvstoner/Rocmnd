<?php

namespace App;

use DB;
use Carbon\Carbon;
use App\Models\Report;
use App\Filters\User\UsersFilters;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Payroll\{TimePunch, Payroll, Period, Team};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'team_id',
        'pto',
        'holiday',
        'first_name',
        'Last_name',
        'email',
        'password',
        'address',
        'address_city',
        'address_state',
        'address_zip',
        'image',
        'active',
        'home_phone_area',
        'home_phone_prefix',
        'home_phone_number',
        'secondary_phone_area',
        'secondary_phone_prefix',
        'secondary_phone_number',
        'emergency_phone_area',
        'emergency_phone_prefix',
        'emergency_phone_number',
        'image',
        'hire_date',
        'fire_date',
        'pto_set_date',
        'pto_amount',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

     /**
     * The attributes that should be Carbon insant.
     *
     * @var array
     */
    protected $dates = [
        'hire_date', 'fire_date', 'pto_set_date',
    ];

    public function  getName()
    {
        if ($this->first_name && $this->last_name) {
            return "{$this->first_name} {$this->last_name}";
        }

        if ($this->first_name){
            return $this->first_name;
        }
        return null;
    }

    public function IPallowed()
    {       
        $ips = $this->cachedIps();
        $userIp = request()->getClientIp();

        foreach($ips as $ip){
            if($ip->address === $userIp){
                return true;
            }
        }
        return false;

    }
    /**
     * Tries to return all the cached Ip's.
     * If it can't bring the ip's from the cache,
     * it brings them back from the DB.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cachedIps()
    {
        $cachedIps = Cache::rememberForever('ipAdresses', function() {
           return DB::table('ip_addresses')->get();
        });

        return $cachedIps;
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Payroll\Team');
    }

    public function shifts()
    {
        return $this->hasManyThrough('App\Models\Payroll\Shift', 'App\Models\Payroll\Team');
    }

    public function  getNameOrUsername()
    {
        return $this->getName() ?: $this->username;
    }

    public function isActive()
    {
        return ($this->active ? 'True' : 'False');
    }

    public function timepunches()
    {
        return $this->hasMany('App\Models\Payroll\TimePunch');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report');
    }

    public function getTimepunches($start, $endDate = NULL)
    {
        if(empty($endDate)){
            $endDate = Carbon::now();
        }
        return $this->hasMany('App\Models\Payroll\TimePunch')->where('shift_date', '>=', $start)->where('shift_date', '<=', $endDate);
    }

    public function isClockedIn()
    { 
        $cacheKey = 'clockin_' . $this->id;
        return Cache::remember($cacheKey, 60, function () {
            return $this->getClockinStatus();
        });
    }

    public function getClockinStatus()
    {
        if($this->hasMany('App\Models\Payroll\TimePunch')->whereNull('clock_out')->count()){
            return true;
        }
        return false;
    }

    public function flushClockinCache()
    {
        Cache::forget('clockin_' . $this->id);
    }

    public function getLastTimePunch()
    {
        return $this->hasMany('App\Models\Payroll\TimePunch')->whereNull('clock_out')->latest('clock_in')->first();
    }

    public function getHours($type = "lastPeriod", $date = Null, $endDate = NULL)
    {
        $this->payroll = $payroll = new Payroll();

        $payroll->calulateHours($this, $type, $date, $endDate);

    }

    public function scopeOnShift($query)
    {
        return $query->whereHas('timepunches', function ($Query) {
            $Query->latest('shift_date')->where('clock_out', NULL);
        });
    }
    
    public function scopeHasSameTeam($query)
    {
        if(auth()->user()->can('create-facilities')){
            return $query;
        }
        return $query->where('team_id', auth()->user()->team_id);
    }

    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        return (new UsersFilters($request))->add($filters)->filter($builder);
    }
}
