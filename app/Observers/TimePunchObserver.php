<?php

namespace App\Observers;

use App\Models\Payroll\TimePunch;
use Illuminate\Support\Facades\Cache;

class TimePunchObserver
{
    /**
     * Listen to the TimePunch created event.
     *
     * @param  \App\Models\Payroll\TimePunch  $TimePunch
     * @return void
     */
    public function created(TimePunch $timePunch)
    {
        $cacheKey = 'clockin_' . $timePunch->user_id;
        Cache::put($cacheKey, true, 60);
    }
}