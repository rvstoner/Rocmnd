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
    public $shifts;
	/**
     * Change Carbons start and end of the week.
     */
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        $this->timePunchesToCheck = collect([]);
        $this->shifts = $this->getShifts();
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
        // $this->getShifts();
        $shifts = $this->shifts->each(function ($item, $key) use ($time) {
            $item->getTimes($time);
        });
        $shift = $shifts->where('clockin', '<=', $time)->where('clockout', '>', $time)->first();
        return $shift;
    } 

    private function getThisShift($shift)
    {      
        $shifts = $this->getShifts(); 
        $shift = $shifts->where('shift', $shift)->first();
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

    public function clockout()
    {
        $this->setUpClockOut($this);
    }

    private function setUpClockOut($timepunch)
    {
        $shift = $this->setShiftTimes($timepunch);
        if($this->clockoutIsNextDay($timepunch)){
            $this->nextDay($timepunch);
        }else{
            $this->processClockOut($timepunch, $this->roundTime(Carbon::now()));
        }
        // if($this->checkIfSameShift($shift)){
        //     $this->processClockOut($timepunch, $this->roundTime(Carbon::now()));
        // }else{
        //     $this->nextShift($timepunch, $shift);
        // }
                  
    }

    private function clockoutIsNextDay($timePunch){
        $shifts = $this->getShifts();
        $shift = $shifts->firstWhere('shift', 1);
        $startOfNextDAy = $timePunch->shift_date->copy()->hour($shift->shift_start)->addDay();
        return $startOfNextDAy->lte($this->roundTime(Carbon::now()));
    }

    

    private function setShiftTimes($timepunch)
    {
       $shift = $this->getThisShift($timepunch->shift);
       $shift->start_time = $timepunch->shift_date->copy()->hour($shift->shift_start);
       if($shift->shift_start > $shift->shift_end){
           $shift->end_time = $timepunch->shift_date->copy()->hour($shift->shift_end)->addDay();
       }else{
           $shift->end_time = $timepunch->shift_date->copy()->hour($shift->shift_end);
       }
       return $shift;
    }

    private function checkIfSameShift($shift)
    {
        $start = $this->roundTime(Carbon::now());
        return $start->lte($shift->end_time);
    }

    private function processClockOut($timepunch, $time)
    {
        $timepunch->clock_out = $time;
        $timepunch->save();
        $cacheKey = 'clockin_' . auth()->user()->id;
        Cache::put($cacheKey, false, 60);
    }

    private function nextDay($timePunch){
        $shifts = $this->getShifts();
        $shift = $shifts->firstWhere('shift', 1);
        $startOfNextDAy = $timePunch->shift_date->copy()->hour($shift->shift_start)->addDay();
        $this->processClockOut($timePunch, $startOfNextDAy);
        $newTimepunch = new TimePunch();
        $newTimepunch->clock_in = $timePunch->clock_out;
        $newTimepunch->reason = $timePunch->reason;
        $newTimepunch->shift = 1;
        $newTimepunch->user_id = $timePunch->user_id;
        $newTimepunch->shift_date = $timePunch->clock_out->copy()->startOfDay();
        $newTimepunch->save();
        $this->setUpClockOut($newTimepunch);

    }

     public function nextShift($timepunch, $shift)
    {
        $shiftNumber = $timepunch->shift;
        if($this->shifts->count() === $shiftNumber){
            $shiftNumber = 0;
        }
        $shiftNumber ++;
        $this->processClockOut($timepunch, $shift->end_time);
        $newTimepunch = new TimePunch();
        $newTimepunch->clock_in = $timepunch->clock_out;
        $newTimepunch->reason = $timepunch->reason;
        $newTimepunch->shift = $shiftNumber;
        $newTimepunch->user_id = $timepunch->user_id;
        $newTimepunch->shift_date = $timepunch->clock_out->copy()->startOfDay();
        $newTimepunch->save();
        $this->setUpClockOut($newTimepunch);

    }

    public function calulate()
    {
        if(empty($this->clock_out)){
            return $this->clock_in->diffInSeconds(Carbon::now());
        }
        return $this->clock_in->diffInSeconds($this->clock_out);
    }

}
