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

}
