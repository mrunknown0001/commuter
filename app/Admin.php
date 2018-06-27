<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'identification', 'role', 'email', 'password',
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
        return $this->hasMany('App\ActivityLog', 'admin_id', 'id');
    }


    public function avatar()
    {
        return $this->hasOne('App\Avatar', 'admin_id');
    }
}
