<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    public function commuter()
    {
    	return $this->belongsTo('App\User', 'commuter_id');
    }


    public function driver()
    {
    	return $this->belongsTo('App\User', 'driver_id');
    }


    public function ride()
    {
    	return $this->belongsTo('App\Ride', 'ride_id');
    }
}
