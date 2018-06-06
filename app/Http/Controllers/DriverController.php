<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;
use Auth;

use App\User;
class DriverController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth', 'driver']);
    }


    // method use to go to home page of the driver
    public function home()
    {
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
            'identification' => 'required'
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
        return redirect()->route('driver.profile')->with('success', 'Profile Successfully Updated!');
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
        return view('driver.notification');
    }


    // method to view ride request
    public function rideRequest()
    {
    	return view('driver.ride-request');
    }


    // method use to view ride history
    public function rideHistory()
    {
    	return view('driver.ride-history');
    }
}
