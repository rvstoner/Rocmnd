<?php

namespace App\Models\Payroll;

use App\User;
use Carbon\Carbon;
use App\Models\Payroll\Payroll;
use Illuminate\Support\Facades\Cache;

use Illuminate\Database\Eloquent\Model;

class TimePunch extends Model
{
	/**
     * Change Carbons start and end of the week.
     */
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY); 
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

    public function clockout($time)
    {
        $time = $this->roundTime($time);
        $shiftEnd = $this->getSEndOfShift($this->clock_in);
        if($shiftEnd >= $time){
            $this->clock_out = $time;
            $this->save();
            $cacheKey = 'clockin_' . auth()->user()->id;
            Cache::put($cacheKey, false, 60);
        }else{

            $this->clock_out = $shiftEnd;
            $this->save();
            $oldTimePunch = $this;
            $timePunch = new TimePunch();

            $timePunch->clock_in = $shiftEnd;
            $timePunch->reason = $oldTimePunch->reason;
            $timePunch->shift = $timePunch->setShift($shiftEnd);
            $timePunch->user_id = auth()->user()->id;
            $timePunch->shift_date = $timePunch->getStartOfDay($shiftEnd);
            $timePunch->save();
            $timePunch->clockout($time);
        }
    }

    public function calulate()
    {
        if(empty($this->clock_out)){
            return $this->clock_in->diffInSeconds(Carbon::now());
        }
        return $this->clock_in->diffInSeconds($this->clock_out);
    }

}
