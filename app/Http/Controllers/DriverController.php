<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\GeneralController;

use App\User;
use App\DriverInfo;
use App\Ride;
use App\Notification;
use App\Avatar;

class DriverController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth', 'driver']);
    }


    public function index()
    {
        $value = Cache::get('key');
    }



    // method use to go to home page of the driver
    public function home()
    {

        $ride = Ride::where('driver_id', Auth::user()->id)
                    ->where('cancelled', 0)
                    ->where('finished', 0)
                    ->first();

        if(!empty($ride)) {
            return redirect()->route('driver.accepted.ride');
        }
        
    	return view('driver.home');
    }



    // method to view profile of the driver
    public function profile()
    {
    	return view('driver.profile');
    }


    // method use to driver profile update form
    public function profileUpdate()
    {
        return view('driver.update-profile');
    }


    // method use to post update profile
    public function postProfileUpdate(Request $request)
    {

        // validate request
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'identification' => 'required',
            'mobile_number' => 'required',
            'body_number' => 'required',
            'plate_number' => 'required',
            'operator_name' => 'required'
        ]);

        // set request values to variables
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $id = $request['identification'];
        // $email = $request['email'];
        $mobile_number = $request['mobile_number'];
        $body_number = $request['body_number'];
        $plate_number = $request['plate_number'];
        $operator_name = $request['operator_name'];

        // check if existing unique values from database
        // check if the record for the user is the same
        // if not, check if the new record is already used by other user
        // return necessary message to the user
        // identification
        if($id != Auth::user()->identification) {
            // check if the new id is used by other driver
            $check_id = User::whereIdentification($id)->first();

            if(count($check_id) > 0) {
                // the new id is already used by other driver
                return redirect()->route('driver.profile.update')->with('error', 'The new Identification ' . $id . ', already used!');
            }
        }

        // mobile
        if(GeneralController::check_mobile_number($mobile_number)) {

            return redirect()->route('driver.profile.update')->with('error', 'The new Mobile Number ' . $mobile_number . ', already used!');
        }

        // email
        // if($email != Auth::user()->email) {
        //     // check if the new email is used by other driver
        //     $check_email = User::whereEmail($email)->first();

        //     if(count($check_email) > 0) {
        //         // the new email is already used by other user
        //         return redirect()->route('driver.profile.update')->with('error', 'The new Email ' . $email . ', already used!');
        //     }
        // }
        
        // check body number, plate number


        // update/save the profile of the user
        $user = User::find(Auth::user()->id);
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->identification = $id;
        $user->mobile_number = $mobile_number;
        // $user->email = $email;
        $user->save();


        $info = DriverInfo::find(Auth::user()->driver_info->id);
        $info->body_number = $body_number;
        $info->plate_number = $plate_number;
        $info->operator_name = $operator_name;
        $info->save();

        // add log
        GeneralController::activity_log(Auth::user()->id, null, 'Profile Update', now());

        // redirect to the profile page
        return redirect()->route('driver.profile')->with('success', 'Profile Successfully Updated!');
    }


    // method use to show upload imageform
    public function uploadProfileImage()
    {
        return view('driver.upload-profile-image');
    }


    // method use to save uploaded image
    public function postUploadProfileImage(Request $request)
    {
        // get current time and append the upload file extension to it,
        // then put that name to $photoName variable.
        $photoname = time().'.'.$request->image->getClientOriginalExtension();

        /*
        talk the select file and move it public directory and make avatars
        folder if doesn't exsit then give it that unique name.
        */
        $request->image->move(public_path('uploads/images'), $photoname);

        $avatar = Avatar::where('user_id', Auth::user()->id)->first();

        // save photoname to database
        if(count($avatar) < 1) {
            $avatar = new Avatar();
            $avatar->user_id = Auth::user()->id;
            $avatar->avatar = $photoname;
            $avatar->save();
        }
        else {
            $avatar->avatar = $photoname;
            $avatar->save();
        }

        // ad dactivity log
        GeneralController::activity_log(Auth::user()->id, null, 'Upload Profile Image', now());

        //return to profile
        return redirect()->route('driver.profile')->with('success', 'Profile Image Uploaded!');
    }


    // method use to view change password form
    public function changePassword()
    {
        return view('driver.change-password');
    }


    // method use to post change password
    public function postChangePassword(Request $request)
    {
        // validate request
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed|max:50'
        ]);


        $old_password = $request['old_password'];
        $password = $request['password'];


        // check if the old password matches
        if(password_verify($old_password, Auth::user()->password)) {
            // save the new password
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($password);
            $user->save();

            // add log
            GeneralController::activity_log(Auth::user()->id, null, 'Password Change', now());

            // redirect to password change form, messaging password has changed
            return redirect()->route('driver.change.password')->with('success', 'Password Changed!');
        }
        else {
            return redirect()->route('driver.change.password')->with('error', 'Incorrent Old Password!');
        }

    }


    // method use to view notification
    public function notification()
    {
        
        $unread = Notification::where('to', Auth::user()->id)
                                ->where('viewed', 0)
                                ->get();

        if(count($unread) > 0) {
            foreach($unread as $u) {
                $u->viewed = 1;
                $u->save();
            }
        }
        return view('driver.notification');
    }


    // method to view ride request
    public function rideRequest()
    {
        // check if the driver already accepted a ride request
        // if ther is any, redirect to acceptedRide route with message
        $ride = Ride::where('driver_id', Auth::user()->id)
                    ->where('type', '!=', 'mix')
                    ->where('cancelled', 0)
                    ->where('finished', 0)
                    ->first();

        if(!empty($ride)) {
            return redirect()->route('driver.accepted.ride');
        }


    	return view('driver.ride-request');
    }



    // method get data and load on ride request on driver
    public function rideRequestNew()
    {

        // if the driver accepted mix type of ride request
        // the next ride will only show a mix type of request


        // get all new active ride request
        $rides = Ride::where('driver_id', null)
                    ->where('cancelled', 0)
                    ->where('finished', 0)
                    ->orderBy('created_at', 'asc')
                    ->get();

        return view('driver.includes.ride-request-new', ['rides' => $rides]);
    }


    // method to accept ride request
    public function acceptRideRequest(Request $request)
    {


        $id = $request['ride_id'];

        // update the ride with needed data
        $ride = Ride::findorfail($id);

        $driver = Auth::user();


        // check if ride is solo and group proceed to accept ride


        // if mix the driver and commuter will be waiting for another 
        // commuter/requester with mix type
        if($ride->type == 'mix') {
            $driver->driver_status->status = 'Loading';
            $driver->driver_status->save();
        }


        // check if the driver is null
        if($ride->driver_id != null) {
            // return the ride already accepted by other driver
            return redirect()->route('driver.ride.request')->with('info', 'The ride is already accepted! Please wait for another request!');
        }


        $ride->driver_id = Auth::user()->id;
        $ride->accepted = 1;
        $ride->accepted_at = now();
        $ride->save();

        // create notification for the user
        $notification = new Notification();
        $notification->to = $ride->commuter->id;
        $notification->title = 'Request Ride Accepted';
        $notification->ride_id = $ride->id;
        $notification->message = 'Your Ride Request is Accepted by ' . Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $notification->url = "commuter.active.ride.request";
        $notification->save();


        // generate log for the activity
        GeneralController::activity_log(Auth::user()->id, null, 'Accepted Ride Request: ' . $ride->ride_number, now());

        // return message with success
        return redirect()->route('driver.accepted.ride')->with('success', 'You successfully accepted requested ride!');
    }


    // method use when there is accepted request by the driver
    public function acceptedRide()
    {
        // get the accepted ride by the driver
        $ride = Ride::where('driver_id', Auth::user()->id)
                    ->where('type', '!=', 'mix')
                    ->where('cancelled', 0)
                    ->where('finished', 0)
                    ->first();


        if(empty($ride)) {
            return redirect()->route('driver.ride.request');
        }
        
        return view('driver.accepted-ride', ['ride' => $ride]);
    }


    // method use to cancel accepted ride request
    public function cancelRideRequest(Request $request)
    {
        $id = $request['ride_id'];

        $ride = Ride::findOrFail($id);

        // check if the driver accepted this ride
        if($ride->driver_id != Auth::user()->id) {
            abort(406);
        }

        // notification for the commuter
        $notification = new Notification();
        $notification->to = $ride->commuter->id;
        $notification->title = 'Your Ride Request Cancelled by Driver';
        $notification->ride_id = $ride->id;
        $notification->message = 'Your Requested Ride is cancelled  by ' . Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $notification->url = "commuter.ride.history";
        $notification->save();

        // save the ride
        $ride->cancelled = 1;
        $ride->finished = 1;
        $ride->save();

        // activity log
        GeneralController::activity_log(Auth::user()->id, null, 'You Cancelled a ride', now());


        // return and message for the driver
        return redirect()->route('driver.ride.history')->with('success', 'Ride Successfully Cancelled');


    }



    // method to move a ride status in pickup
    public function ridePickup(Request $request)
    {
        $id = $request['id'];

        $driver = Auth::user();

        // update to current at time of pickup
        $ride = Ride::find($id);

        // check if the ride belongs to the driver that he/she accept
        if($ride->driver_id != Auth::user()->id) {
            abort(406);
        }


        // ride_type is solo or group
        // driver status will change to OTW
        if($ride->type == 'solo' || $ride->type == 'group') {
            // driver status to OTW
            $driver->driver_status->status = 'OTW';
            $driver->driver_status->save();
        }

        $ride->current = 1;
        $ride->current_at = now();
        $ride->save();

        // add activity log here
        GeneralController::activity_log(Auth::user()->id, null, 'Driver Picks up the passenger. Ride Number: ' . $ride->ride_number, now());

        return redirect()->route('driver.accepted.ride');
    }


    // method to drop off and finished the ride
    public function rideDropoff(Request $request)
    {
        $id = $request['id'];

        $driver = Auth::user();

        // update to current at time of pickup
        $ride = Ride::find($id);

        // check if the ride accepted by the driver
        if($ride->driver_id != Auth::user()->id) {
            abort(406);
        }

        $ride->drop_off = 1;
        $ride->drop_off_at = now();
        $ride->save();


        // change driver status to arrived
        $driver->driver_status->status = 'Arrived';
        $driver->driver_status->save();


        // add to notification for drop off confirmation
        $notif = new Notification();
        $notif->to = $ride->commuter_id;
        $notif->ride_id = $ride->id;
        $notif->title = 'Dropoff Confirmation';
        $notif->message = 'Drop Off Confirmation';
        $notif->url = "commuter.ride.dropoff.confirm"; //named
        $notif->save();

        // add activity log here
        GeneralController::activity_log(Auth::user()->id, null, 'Driver drops the passenger. Ride Number: ' . $ride->ride_number, now());

        return redirect()->route('driver.ride.history')->with('info', 'Waiting for Commuter Confirmation!');  
    }


    // method use to view ride history
    public function rideHistory()
    {
        // find all ride involving the driver with finished status
        $rides = Ride::where('driver_id', Auth::user()->id)
                    ->where('finished', 1)
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);

    	return view('driver.ride-history', ['rides' => $rides]);
    }


    // method use to submit report by the driver
    // public function submitReport(Request $request)
    // {
    //     // validate request data
    //     $request->validate([
    //         'message' => 'required'
    //     ]);


    //     // assign request data to variables
    //     $ride_id = $request['ride_id'];
    //     $message = $request['message'];


    //     $ride = Ride::findOrFail($ride_id);


    //     // check if the ride belongs to the driver
    //     if($ride->driver_id != Auth::user()->id) {
    //         abort(406);
    //     }

    //     $report_number = GeneralController::generate_report_number();

    //     // checks


    //     // save report to view by admin        
    //     $report = new Report();
    //     $report->report_number = $report_number;
    //     $report->complainant_id = Auth::user()->id;
    //     $report->reported_user_id = $ride->commuter_id;
    //     $report->ride_id = $ride->id;
    //     $report->content = $message;
    //     $report->user_type = 2;
    //     $report->save();


    //     // save log report
    //     GeneralController::activity_log(Auth::user()->id, null, 'Driver Submitted Report', now());


    //     // return message
    //     return redirect()->route('driver.ride.history')->with('success', 'Report Submitted!');
    // }


    // // method use to report and cancel and report to admin
    // public function postCancelReportCommuter(Request $request)
    // {
    //     $ride_id = $request['ride_id'];

    //     $ride = Ride::findorfail($ride_id);

    //     // mark ride has no commuter appearance and finished
    //     $ride->commuter_unappearance = 1;
    //     $ride->finished = 1;
    //     $ride->save();

    //     // add report to admin that the commuter not appeared in pickup location
    //     $report_number = GeneralController::generate_report_number();

    //     $report = new Report();
    //     $report->report_number = $report_number;
    //     $report->complainant_id = Auth::user()->id;
    //     $report->reported_user_id = $ride->commuter_id;
    //     $report->ride_id = $ride->id;
    //     $report->content = 'The Commuter Not Appeared in Pickup Location';
    //     $report->user_type = 2;
    //     $report->save();

    //     GeneralController::activity_log(Auth::user()->id, null, 'Driver cancel ride as commuter not appeared', now());

    //     return redirect()->route('driver.home')->with('info', 'Commuter Reported to Admin for No Appearance');
    // }
}
