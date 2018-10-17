<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Cache;
use DB;

use App\Http\Controllers\GeneralController;

use App\User;
use App\Location;
use App\Ride;
use App\Passenger;
use App\CommuterCancel;
use App\Report;
use App\Feedback;
use App\Notification;
use App\Avatar;


class CommuterController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth', 'commuter']);
	}

    public function index()
    {
        $value = Cache::get('key');
    }



    // method to go to home page of the commuter
    public function home()
    {
    	return view('commuter.home');
    }


    // method use to show/view profile of the commuter
    public function profile()
    {
    	// return Auth::user();
        return view('commuter.profile');
    }

    // method to view update profile form
    public function updateProfile()
    {
        return view('commuter.update-profile');
    }


    // method to update profile of the user
    public function postUpdateProfile(Request $request)
    {

        // validate request
        $request->validate([
            'mobile_number' => 'required'
        ]);

        // $id = $request['identification'];

        $mobile_number = $request['mobile_number'];

        // check if existing unique values from database
        // check if the record for the user is the same
        // if not, check if the new record is already used by other user
        // return necessary message to the user
        // identification
        // if($id != Auth::user()->identification) {
        //     // check if the new id is used by other user
        //     $check_id = User::whereIdentification($id)->first();

        //     if(count($check_id) > 0) {
        //         // the new id is already used by other user
        //         return redirect()->route('commuter.profile.update')->with('error', 'The new Identification ' . $id . ', already used!');
        //     }
        // }

        // mobile
        if(GeneralController::check_mobile_number($mobile_number)) {

            return redirect()->route('commuter.profile.update')->with('error', 'The new Mobile Number ' . $mobile_number . ', already used!');
        }

        // email
        // if($email != Auth::user()->email) {
        //     // check if the new email is used by other user
        //     $check_email = User::whereEmail($email)->first();

        //     if(count($check_email) > 0) {
        //         // the new email is already used by other user
        //         return redirect()->route('commuter.profile.update')->with('error', 'The new Email ' . $email . ', already used!');
        //     }
        // }


        // update/save the profile of the user
        $user = User::findOrFail(Auth::user()->id);
        // $user->first_name = $first_name;
        // $user->last_name = $last_name;
        // $user->identification = $id;
        $user->mobile_number = $mobile_number;
        // $user->email = $email;
        $user->save();

        // add log
        GeneralController::activity_log(Auth::user()->id, null, 'Profile Update', now());

        // redirect to the profile page
        return redirect()->route('commuter.profile')->with('success', 'Profile Successfully Updated!');
    }


    // method use to show image upload
    public function uploadProfileImage()
    {
        return view('commuter.upload-profile-image');
    }


    // method use to save upload image
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
        return redirect()->route('commuter.profile')->with('success', 'Profile Image Uploaded!');
    }


    // method to show change password form
    public function changePassword()
    {
        // change password view for user/commuter
        return view('commuter.change-password');
    }


    // method use post change password
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
            $user = User::findOrFail(Auth::user()->id);
            $user->password = bcrypt($password);
            $user->save();

            // add log
            GeneralController::activity_log(Auth::user()->id, null, 'Password Change', now());

            // redirect to password change form, messaging password has changed
            return redirect()->route('commuter.change.password')->with('success', 'Password Changed!');
        }
        else {
            return redirect()->route('commuter.change.password')->with('error', 'Incorrent Old Password!');
        }

    }


    // method to view notifications
    public function notification()
    {

        // make all notification read
        $unread = Notification::where('to', Auth::user()->id)
                                ->where('viewed', 0)
                                ->get();

        if(count($unread) > 0) {
            foreach($unread as $u) {
                $u->viewed = 1;
                $u->save();
            }
        }

        return view('commuter.notification');
    }


    // method use to request ride ride form
    public function requestRide()
    {

        // check if the has more than 20 mins from the time of request
        $last_ride = Ride::where('commuter_id', Auth::user()->id)
                        ->where('finished', 1)
                        ->orderBy('created_at', 'desc')
                        ->first();

        if(count($last_ride) > 0) {

            // check if ride is less than 20mins from time of request
            $timeofrequest = date(strtotime($last_ride->created_at));
            $timenow = date(strtotime(now()));


            $difference = $timenow - $timeofrequest;


            $next_request_time = strtotime("+15 minutes", strtotime($last_ride->created_at));


            if($difference < 1200) {
                // the time is less than 20 mins from time of request
                return redirect()->route('commuter.home')->with('notice', 'You can Request 20 minutes after your last ride request. Next Time of Request: ' . date('g:i a', $next_request_time));
            }

        }


        // check if the commuter has a ride
        $active_ride = Ride::where('commuter_id', Auth::user()->id)
                        ->where('finished', 0)
                        ->first();

        if(count($active_ride) > 0) {
            return redirect()->route('commuter.active.ride.request');
        }

        // verify the time interval if the commuter before, it can request a ride again (20mins)


        // get the locations
        $locations = Location::all();

        return view('commuter.request-ride', ['locations' => $locations]);
    }



    // method use to post ride request
    public function postRequestRide(Request $request)
    {

        // validate request data
        $request->validate([
            'pickup' => 'required',
            'dropoff' => 'required',
            'passenger1_id' => 'required',
            'passenger1_name' => 'required'
        ]);

        // assign request variables to data
        $pickup = $request['pickup'];
        $dropoff = $request['dropoff'];
        $commuter = $request['commuter'];
        $passenger1_id = $request['passenger1_id']; // Auth::user()->identification
        $passenger2_id = $request['passenger2_id'];
        $passenger3_id = $request['passenger3_id'];
        $passenger4_id = $request['passenger4_id'];

        $passenger1_name = $request['passenger1_name']; // Auth::user()->first_name . ' ' . Auth::user()->last_name
        $passenger2_name = $request['passenger2_name'];
        $passenger3_name = $request['passenger3_name'];
        $passenger4_name = $request['passenger4_name'];

        // add other additional data


        // other check and validation
        // pickup and dropoff is 1 and 2 only


        // compute the total payment for the driver
        // check if passenger 2 is on and 3,4 is off
        if(!empty($passenger2_id) && empty($passenger3_id) && empty($passenger4_id)) {
            // 30 total
            // 15 each
            $total = 30;
            $each = 15;
        }
        else if(!empty($passenger2_id) && !empty($passenger3_id) && empty($passenger4_id)) {
            // 30 total
            // 10 each
            $total = 30;
            $each = 10;
        }
        else if(!empty($passenger2_id) && !empty($passenger3_id) && !empty($passenger4_id)) {
            // 40 total
            // 10 each
            $total = 40;
            $each = 10;
        }
        if(empty($passenger2_id) && !empty($passenger3_id) && empty($passenger4_id)) {
            // 30 total
            // 15 each
            $total = 30;
            $each = 15;
        }
        else if(empty($passenger2_id) && !empty($passenger3_id) && !empty($passenger4_id)) {
            // 30 total
            // 10 each
            $total = 30;
            $each = 10;
        }
        if(empty($passenger2_id) && empty($passenger3_id) && !empty($passenger4_id)) {
            // 30 total
            // 15 each
            $total = 30;
            $each = 15;
        }
        else if(!empty($passenger2_id) && empty($passenger3_id) && !empty($passenger4_id)) {
            // 30 total
            // 10 each
            $total = 30;
            $each = 10;
        }
        else {
            $total = 30;
            $each = 30;
        }


        // generate unique reference number for ride
        // method from GeneralController
        $ride_number = GeneralController::generate_ride_number();


        // save ride request
        $ride = new Ride();
        $ride->ride_number = $ride_number;
        $ride->commuter_id = $commuter;
        $ride->pickup_loc = $pickup;
        $ride->drop_off_loc = $dropoff;
        $ride->payment = $total;
        $ride->each = $each;
        $ride->save();

        // add passengers
        $p = new Passenger();
        $p->ride_id = $ride->id;
        $p->passenger1 = $passenger1_id;
        $p->passenger2 = $passenger2_id;
        $p->passenger3 = $passenger3_id;
        $p->passenger4 = $passenger4_id;
        $p->passenger1_name = $passenger1_name;
        $p->passenger2_name = $passenger2_name;
        $p->passenger3_name = $passenger3_name;
        $p->passenger4_name = $passenger4_name;
        $p->save();

        // add activity log record
        GeneralController::activity_log(Auth::user()->id, null, 'Requested Ride', now());

        // if posible notification

        // return messages to the active ride of the commuter
        return redirect()->route('commuter.active.ride.request')->with('success', 'Request Ride Posted!');

    }


    // method to view active request ride
    public function activeRideRequest()
    {


        // get the active requested ride by the commuter
        $active_ride = Ride::where('commuter_id', Auth::user()->id)
                        ->where('finalized', 1)
                        ->where('cancelled', 0)
                        ->where('finished', 0)
                        ->first();

        return view('commuter.active-ride-request', ['active_ride' => $active_ride]);
    }



    // method use to cancel ride request by the commuter
    public function cancelRideRequest(Request $request)
    {
        $id = $request['ride_id'];

        // make ride cancelled and finished
        $ride = Ride::findOrFail($id);


        // check if the ride belongs to the owner
        if($ride->commuter_id != Auth::user()->id) {
            abort(406);
        }


        // check if the ride request is accepted by driver
        // so that the commuter must pay the driver for the amount computed by the system
        if($ride->driver_id != null) {
            // create a notification for the driver that the ride has been cancelled by the commuter
            // in this case the commuter must pay the amount to the driver
            // the system will notify the driver and ask if the commuter payed the amount 
            // if yes, its ok, if no, the driver can report the commuter
            // create notification for the user
            $notification = new Notification();
            $notification->to = $ride->driver->id;
            $notification->title = 'Accepted Request Ride Cancelled by Commuter';
            $notification->ride_id = $ride->id;
            $notification->message = 'Your Accepted Ride Request is cancelled  by ' . Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $notification->url = "driver.ride.history";
            $notification->save();

        }


        // save ride details
        $ride->cancelled_by_commuter = 1;
        $ride->cancelled = 1;
        $ride->finished = 1;
        $ride->save();
        

        // activity log here
        GeneralController::activity_log(Auth::user()->id, null, 'Cancelled Ride Request', now());


        // return to home page of commuter
        return redirect()->route('commuter.active.ride.request')->with('success', 'Ride Request Cancelled!');

    }


    // method use to confirm drop off 
    // public function rideDropoffConfirm($id = null)
    // {
    //     // get ride id
    //     $ride = Ride::findOrFail($id);

    //     if($ride->drop_off_conrimation == 1) {
    //         return redirect()->route('commuter.home')->with('info', 'Ride Confirmed Already!');
    //     }

    //     // return to dashboard
    //     return view('commuter.drop-off-confirm', ['ride' => $ride]);
    // }


    // // method use to accept ride drop off
    // public function postRideDropoffConfirm(Request $request)
    // {
    //     $ride_id = $request['ride_id'];

    //     $ride = Ride::findOrFail($ride_id);

    //     $ride->drop_off_conrimation = 1;
    //     $ride->finished = 1;
    //     $ride->save();

    //     GeneralController::activity_log(Auth::user()->id, null, 'Ride Drop Off Confirmed', now());

    //     return redirect()->route('commuter.home')->with('success', 'Ride Drop Off Confirmed!');
    // }



    // method use to add feedback to the driver or commuter
    public function sendFeedback(Request $request)
    {
        // validate request data
        $request->validate([
            'message' => 'required',
            'rating' => 'required'
        ]);


        // assgin to variables
        $id = $request['ride_id'];
        $message = $request['message'];
        $rating = $request['rating'];
        $feedback_number = GeneralController::generate_feedback_number();


        $ride = Ride::findOrFail($id);

        // check if the ride is not belong to the user
        if($ride->commuter_id != Auth::user()->id) {
            abort(406);
        }


        // save
        $feed = new Feedback();
        $feed->feedback_number = $feedback_number;
        $feed->commuter_id = Auth::user()->id;
        $feed->driver_id = $ride->driver_id;
        $feed->ride_id = $ride->id;
        $feed->comment = $message;
        $feed->rating = $rating;
        $feed->save();


        // activity log
        GeneralController::activity_log(Auth::user()->id, null, 'Send Feedback to the ride: ' . $ride->ride_number, now());


        // return message to the ride history
        return redirect()->route('commuter.ride.history')->with('success', 'Feedback Send!');
    }



    // method us to submit ride 
    public function submitReport(Request $request)
    {
        // validate request data
        $request->validate([
            'message' => 'required'
        ]);

        // assign to variables
        $id = $request['ride_id'];
        $message = $request['message'];
        $report_number = GeneralController::generate_report_number();


        $ride = Ride::findOrFail($id);

        // check if the ride is belongs to the user
        if($ride->commuter_id != Auth::user()->id) {
            abort(406);
        }

        // save
        $report = new Report();
        $report->report_number = $report_number;
        $report->complainant_id = Auth::user()->id;
        $report->reported_user_id = $ride->driver_id; // in this case the reported user is the driver of the ride
        $report->ride_id = $ride->id;
        $report->content = $message;
        $report->user_type = 1;
        $report->save();
        

        // add activity log
        GeneralController::activity_log(Auth::user()->id, null, 'Submitted Report on ride: ' . $ride->ride_number, now());

        // return to history with message
        return redirect()->route('commuter.ride.history')->with('success', 'Report Submitted!');
    }


    // method use to view ride history of commuter
    public function rideHistory()
    {
        // get all ride request with finished status
        $rides = Ride::where('commuter_id', Auth::user()->id)
                        ->where('finished', 1)
                        ->orderBy('created_at', 'desc')
                        ->paginate(5);

        return view('commuter.ride-history', ['rides' => $rides]);
    }




    // method use to load modal for drop off confirmation
    public function rideDropoffPrompt()
    {
        $ride = Ride::where('commuter_id', Auth::user()->id)
                        ->where('accepted', 1)
                        ->where('current', 0)
                        ->where('finished', 0)
                        ->first();

        if(count($ride) < 1) {
            return null;
        }

        if(strtotime($ride->current_at) < strtotime(now()) + 600) {
            return view('includes.modal-ride-drop-off-prompt', ['ride' => $ride]);
        }

    }



    // method use to confirm pickup
    public function ridePickupConfirm()
    {
        $commuter = Auth::user();

        $ride = Ride::where('commuter_id', $commuter->id)
            ->where('accepted', 1)
            ->where('current', 0)
            ->where('finished', 0)
            ->first();

        if(count($ride) < 1) {
            return redirect()->route('commuter.active.ride.request')->with('info', 'You have already pickedup!'); 
        }


        if(count($ride) > 0) {
            $notifs = DB::table('notifications')->where('ride_id', $ride->id)
                        ->update(['viewed' => 1]);

            // redirect to yes or no pick up confrimation
            return view('commuter.ride-pickup-confirm', ['ride' => $ride]);

        }
        else {
            // rediret to cashboard
            // with message info
            // the ride is already picked-up
            return redirect()->route('commuter.active.ride.request')->with('info', 'You have already pickedup!');
        }
    }


    // method use to make as pickup by the commuter
    public function postRidePickupConfirm(Request $request)
    {
        $id = $request['id'];

        $ride = Ride::findOrFail($id);

        // mark as pickup
        $ride->current = 1;
        $ride->current_at = now();
        $ride->save();

        // remove all notification with ride id
        $notifs = DB::table('notifications')->where('ride_id', $ride->id)
                        ->update(['viewed' => 1]);

        return redirect()->route('commuter.request.ride');
    }


    // method use to drop off confirmation
    public function rideDropoffConfirm()
    {
        $commuter = Auth::user();

        $ride = Ride::where('commuter_id', $commuter->id)
            ->where('accepted', 1)
            ->where('current', 1)
            ->where('finished', 0)
            ->first();

        if(count($ride) < 1) {
            return redirect()->route('commuter.active.ride.request')->with('info', 'You have already dropoff!'); 
        }

        if(count($ride) > 0) {
            $notifs = DB::table('notifications')->where('ride_id', $ride->id)
                        ->update(['viewed' => 1]);
                        
            // redirect to yes or no pick up confrimation
            return view('commuter.ride-dropoff-confirm', ['ride' => $ride]);

        }
        else {
            // rediret to cashboard
            // with message info
            // the ride is already picked-up
            return redirect()->route('commuter.active.ride.request')->with('info', 'You have already dropoff!');
        }
    }


    // method use to confirm drop off
    public function postRideDropoffConfirm(Request $request)
    {
        $id = $request['id'];

        $ride = Ride::findOrFail($id);

        // mark ride as finished
        $ride->drop_off = 1;
        $ride->drop_off_conrimation = 1;
        $ride->finished = 1;
        $ride->save();

        // return to home with info message
        return redirect()->route('commuter.home')->with('success', 'Success! Ride Saved!');
    }



}
