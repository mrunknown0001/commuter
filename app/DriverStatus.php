<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverStatus extends Model
{
    public function driver()
    {
    	return $this->belongsTo('App\User', 'driver_id');
    }
}
