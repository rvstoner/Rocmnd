<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'hire_date', 'fire_date',
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

    public function  getNameOrUsername()
    {
        return $this->getName() ?: $this->username;
    }
}