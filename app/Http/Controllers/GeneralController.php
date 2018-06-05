<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ActivityLog;
use App\Ride;

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



    // method to generate unique reference number for rides
    public static function generate_ride_number()
    {
        $number = 'r_' . mt_rand(000000, 999999) . uniqid(); // better than rand()

        // call the same function if the barcode exists already
        if (self::rideNumberExists($number)) {
            return self::generate_ride_number();
        }

        // otherwise, it's valid and can be used
        return  $number;
    }


    // method use to check the existence of reference number in database
    private static function rideNumberExists($number) {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return Ride::whereRideNumber($number)->exists();
    }


}
