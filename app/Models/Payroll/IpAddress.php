<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'address',
    ];

     public $timestamps = false;

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    /**
     * Set the ip address to a long value.
     *
     * @param  string  $value
     * @return void
     */
    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = ip2long($value);
    }

    /**
     * Gets the ip address from a long value.
     *
     * @param  string  $value
     * @return void
     */
    public function getAddressAttribute($value)
    {
        return long2ip($value);
    }
}
