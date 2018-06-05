<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;
use Auth;

use App\User;
use App\Location;
use App\Ride;
use App\Passenger;
use App\CommuterCancel;
use App\Report;
use App\Feedback;
use App\Notification;


class CommuterController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth', 'commuter']);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'identification' => 'required',
            'mobile_number' => 'required'
        ]);

        // set request values to variables
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $id = $request['identification'];
        // $email = $request['email'];
        $mobile_number = $request['mobile_number'];

        // check if existing unique values from database
        // check if the record for the user is the same
        // if not, check if the new record is already used by other user
        // return necessary message to the user
        // identification
        if($id != Auth::user()->identification) {
            // check if the new id is used by other user
            $check_id = User::whereIdentification($id)->first();

            if(count($check_id) > 0) {
                // the new id is already used by other user
                return redirect()->route('commuter.profile.update')->with('error', 'The new Identification ' . $id . ', already used!');
            }
        }

        // mobile
        if($mobile_number != Auth::user()->mobile_number) {
            // check if the new mobile number is used by other user
            $check_mobile = User::where('mobile_number', $mobile_number)->first();

            if(count($check_mobile) > 0) {
                // the new mobile number is already used by other user
                return redirect()->route('commuter.profile.update')->with('error', 'The new Mobile Number ' . $mobile_number . ', already used!');
            }
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
        $user = User::find(Auth::user()->id);
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->identification = $id;
        $user->mobile_number = $mobile_number;
        // $user->email = $email;
        $user->save();

        // add log
        GeneralController::activity_log(Auth::user()->id, null, 'Profile Update', now());

        // redirect to the profile page
        return redirect()->route('commuter.profile')->with('success', 'Profile Successfully Updated!');
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
            $user = User::find(Auth::user()->id);
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
        return view('commuter.notification');
    }


    // method use to request ride ride form
    public function requestRide()
    {

        // check if the commuter has a ride
        $active_ride = Ride::where('commuter_id', Auth::user()->id)
                        ->where('driver_id', null)
                        ->where('cancelled', 0)
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
        return view('commuter.active-ride-request');
    }


    // method use to view ride history of commuter
    public function rideHistory()
    {
        return view('commuter.ride-history');
    }
}
