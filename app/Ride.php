<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    public function pickup_location()
    {
    	return $this->belongsTo('App\Location', 'pickup_loc', 'id');
    }

	public function dropoff_location()
    {
    	return $this->belongsTo('App\Location', 'drop_off_loc', 'id');
    }


    public function driver()
    {
    	return $this->belongsTo('App\User', 'driver_id', 'id');
    }


    public function commuter()
    {
        return $this->belongsTo('App\User', 'commuter_id', 'id');
    }


    public function feedback()
    {
        return $this->hasMany('App\Feedback', 'ride_id', 'id');
    }

    public function report()
    {
        return $this->hasMany('App\Report', 'ride_id', 'id');
    }


    public function passenger()
    {
        return $this->hasMany('App\Passenger', 'ride_id', 'id');
    }

}
