<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'user_type', 'identificatoion', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    // the user has many activity log records | one to many relationship
    public function activity_log()
    {
        return $this->hasMany('App\ActivityLog', 'user_id', 'id');
    }


    // driver info for the driver
    public function driver_info()
    {
        return $this->hasOne('App\DriverInfo', 'driver_id', 'id');
    }
}
