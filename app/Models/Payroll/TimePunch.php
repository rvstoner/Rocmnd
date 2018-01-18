<?php

namespace App\Models\Payroll;

use App\User;
use Carbon\Carbon;
use App\Models\Payroll\Payroll;
use Illuminate\Support\Facades\Cache;

use Illuminate\Database\Eloquent\Model;

class TimePunch extends Model
{
    private $timePunchesToCheck;
	/**
     * Change Carbons start and end of the week.
     */
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        $this->timePunchesToCheck = collect([]); 
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'clock_in', 'clock_out', 'shift_date', 'reason'
    ];

     /**
     * The attributes that are Carbon dates.
     *
     * @var array
     */
    protected $dates = [
        'clock_in', 'clock_out','shift_date',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Used to round times to the nearest 15 minutes.
     */
    public static function roundTime($time)
    {
        $roundedTime = Carbon::createFromTimestamp(60*(15*round(round(($time->timestamp)/60)/15)));

        return $roundedTime;
    }

    public static function getStartOfDay($time)
    {
        $timePunch = new TimePunch();
        $shifts = $timePunch->getShifts();
        $shift = $shifts->firstWhere('shift', 1);
        if($time->hour < $shift->shift_start){
            return $time->subDay()->startOfDay();
        }
        return $time->StartOfDay();
    }

    public static function getShifts()
    {
        $team = auth()->user()->team;
        $shifts = $team->shifts;

        return $shifts;
    }

    public function getShift($time)
    {
        $shifts = $this->getShifts();
        $shifts = $shifts->each(function ($item, $key) use ($time) {
            $item->getTimes($time);
        });
        $shift = $shifts->where('clockin', '<=', $time)->where('clockout', '>', $time)->first();
        return $shift;
    }

    public function getStartOfShift($time)
    {
        $shift = $this->getShift($time);

        return $shift->clockin;
    }

    public function getSEndOfShift($time)
    {
        $shift = $this->getShift($time);

        return $shift->clockout;
    }

    public static function setShift($time)
    {
        $timePunch = new TimePunch();
        $shift = $timePunch->getShift($time);
    
        return $shift->shift;
    }

    public static function setShiftDate($time)
    {
        $timePunch = new TimePunch();
        $shift = $timePunch->getShift($time);
        
        return $shift->clockin;
    }

    public function clockout($shifts = NULL, $timepunch = NULL)
    {
        $time = $this->roundTime(Carbon::now());
        if(empty($shifts)){
            $shifts = $this->getShifts();
        } 
        if(empty($timepunch)){
            $timepunch = $this;
        }        
        $shift = $shifts->where('shift', $timepunch->shift)->first();
        $shiftTimes = $this->setShiftTimes($shift, $timepunch);
        if(!$time->between($shiftTimes->clock_in_time, $shiftTimes->clock_out_time)){

            $timepunch->clock_out = $shiftTimes->clock_out_time;
            $timepunch->save();

            $timepunch->nextShift($shifts, $timepunch);
        }
        $timepunch->clock_out = $time;
        $timepunch->save();
        $cacheKey = 'clockin_' . auth()->user()->id;
        Cache::put($cacheKey, false, 60);

    }

    public function setShiftTimes($shift, $timePunch)
    {
        $shift->clock_in_time = $timePunch->shift_date->copy()->hour($shift->shift_start)->minute(00);
        if($shift->shift_start > $shift->shift_end){
            $shift->clock_out_time = $timePunch->shift_date->copy()->hour($shift->shift_end)->minute(00)->addDay();
        }else{
            $shift->clock_out_time = $timePunch->shift_date->copy()->hour($shift->shift_end)->minute(00);
        }

        return $shift;
    }

    public function nextShift($shifts, $timepunch)
    {
        $shift = $timepunch->shift;
        if($shifts->count() === $shift){
            $shift = 0;
        }
        $shift ++;
        $oldTimePunch = $timepunch;
        $timepunch = new TimePunch();

        $timepunch->clock_in = $oldTimePunch->clock_out;
        $timepunch->reason = $oldTimePunch->reason;
        $timepunch->shift = $shift;
        $timepunch->user_id = $oldTimePunch->user_id;
        $timepunch->shift_date = $timepunch->clock_in->startOfDay();
        $timepunch->save();
        $this->clockout($shifts, $timepunch);


    }

    public function calulate()
    {
        if(empty($this->clock_out)){
            return $this->clock_in->diffInSeconds(Carbon::now());
        }
        return $this->clock_in->diffInSeconds($this->clock_out);
    }

}
