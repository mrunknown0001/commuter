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

}
