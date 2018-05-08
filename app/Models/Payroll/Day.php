<?php

namespace App\Models\Payroll;

use Carbon\Carbon;
use App\Models\Payroll\{Shift, Period};
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);    
        Carbon::setWeekEndsAt(Carbon::SATURDAY); 
    }

    public function calulate($timepunches, $date = NULL)
    {
    	if(empty($date) && empty($this->start)){
    		return back();
    	}
    	if (!empty($date)){
    		$this->start = $date;    		
    	} 
    	$this->timepunches = $timepunches;
        $hours = $this->getHours($timepunches); 
        $this->readableHours = $this->readableTime($hours);
        $this->label = $this->start->copy()->format('l');
        $this->end = $this->start->copy()->format('\\of F');
        $this->start = $this->start->copy()->format('jS');
         $this->readableOvertime = '';
        $this->readableRollover = '';

    	return $hours;
    }

    private function getHours($timepunches){
            $hours = 0;
        foreach($timepunches as $timepunch){
            if ( empty ( $timepunch->clock_out ) ) {
                $timepunch->clock_out = Carbon::now();
            }
            $currentHours = 0;
            $hours += $currentHours = $timepunch->calulate();
            $timepunch->readableHours = $this->readableTime($currentHours);
            $timepunch->label = $timepunch->reason;
            $timepunch->start = $timepunch->clock_in->toDayDateTimeString();
            $timepunch->end = $timepunch->clock_out->toDayDateTimeString();
            $timepunch->hoursLabel = 'Hours';
            $timepunch->rolloverLabel = 'Shift';
            $timepunch->overtimeLabel = 'Edited';
            $timepunch->readableOvertime = ($timepunch->edited ? 'Yes' : 'No');
            $timepunch->readableRollover = $timepunch->shift;


        }

        return $hours;
    }

    private function readableTime($seconds) {
      $t = round($seconds);
      return sprintf('%02d:%02d', ($t/3600),($t/60%60));
    }


}
