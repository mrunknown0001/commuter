<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ActivityLog;

class GeneralController extends Controller
{
    

    // method use to log all action by the users
    // you can call in other controller
    public static function activity_log($user_id = null, $admin_id = null, $action = null, $datetime = null)
    {
    	$log = new ActivityLog();
    	$log->user_id = $user_id;
    	$log->admin_id = $admin_id;
    	$log->action_performed = $action;
    	$log->performed_on = $datetime;
    	$log->save();
    }
}
