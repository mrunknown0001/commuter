<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

	public function admin()
    {
    	return $this->belongsTo('App\Admin', 'admin_id', 'id');
    }

}
