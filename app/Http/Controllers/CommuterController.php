<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;
use Auth;

use App\User;
use App\Location;

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
            'identification' => 'required'
        ]);

        // set request values to variables
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $id = $request['identification'];
        $email = $request['email'];
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
        if($email != Auth::user()->email) {
            // check if the new email is used by other user
            $check_email = User::whereEmail($email)->first();

            if(count($check_email) > 0) {
                // the new email is already used by other user
                return redirect()->route('commuter.profile.update')->with('error', 'The new Email ' . $email . ', already used!');
            }
        }


        // update/save the profile of the user
        $user = User::find(Auth::user()->id);
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->identification = $id;
        $user->mobile_number = $mobile_number;
        $user->email = $email;
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

        // get the locations
        $locations = Location::all();

        return view('commuter.request-ride', ['locations' => $locations]);
    }


    // method use to post ride request
    public function postRequestRide(Request $request)
    {
        return $request;

        // validate request data

        // assign request variables to data

        // add other additional data

        // other check and validation

        // save ride request

        // return messages
    }


    // method use to view ride history of commuter
    public function rideHistory()
    {
        return view('commuter.ride-history');
    }
}
