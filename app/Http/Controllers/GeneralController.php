<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\ActivityLog;
use App\Ride;
use App\User;
use App\Admin;
use App\Report;
use App\Notification;
use App\Feedback;

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



    // method use to check existence of mobile number
    // 
    public static function check_mobile_number($mobile_number)
    {
        if($mobile_number != Auth::user()->mobile_number) {
            // check if the new mobile number is used by other user
            $check_mobile = User::where('mobile_number', $mobile_number)->first();

            if(count($check_mobile) > 0) {
                return true;
            }
        }

        return false;
    }



    // method called for notification
    public function notification()
    {
        $unread = Notification::where('to', Auth::user()->id)
                            ->orderBy('created_at', 'desc')
                            ->take(3)
                            ->get();
                            
        // pass the data and design it in the view
        return view('includes.notification-layout')->with(['unread' => $unread]);
    }


    // method use to displate count of the new notification
    public function notificationCount()
    {
        $unread = Notification::where('to', Auth::user()->id)
                            ->where('viewed', 0)
                            ->get();

        // return nothing if there is no unread notification
        // return count($unread);
        if(count($unread) > 0) {
            return count($unread);
        }

        return false;
    }


    // method use to create notification pickup
    public function createPickupNotification()
    {
        $commuter = Auth::user();

        // check if there is an active accepted ride
        $ride = Ride::where('commuter_id', $commuter->id)
                    ->where('accepted', 1)
                    ->where('current', 0)
                    ->where('finished', 0)
                    ->first();

        if(count($ride) > 0) {
            // do create notification
            $notif = new Notification();
            $notif->to = $commuter->id;
            $notif->title = 'Pickup Confirmation';
            $notif->ride_id = $ride->id;
            $notif->message = 'Are you already picked-up by the driver?';
            $notif->url = 'commuter.ride.pickup.confirm';
            $notif->save();
        }
    }



    // method use to generate unique feedback number
    public static function generate_feedback_number()
    {
        $number = 'f_'.mt_rand(000000, 999999);

        if(Feedback::whereFeedbackNumber($number)->exists()) {
            return self::generate_feedback_number();
        }

        return $number;

    }


    // method use to generate unique feedback number
    public static function generate_report_number()
    {
        $number = 'r_'.mt_rand(000000, 999999);

        if(Report::whereReportNumber($number)->exists()) {
            return self::generate_report_number();
        }

        return $number;

    }

    public static function generateRandomString($length = 5, $characters = null) {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }



}
