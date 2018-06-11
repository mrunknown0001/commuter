<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function complainant()
    {
    	return $this->belongsTo('App\User', 'complainant_id');
    }


    public function reported()
    {
    	return $this->belongsTo('App\User', 'reported_user_id');
    }
}
