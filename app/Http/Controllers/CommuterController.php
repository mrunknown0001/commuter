<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
        return $request;

        // validate request

        // check if existing unique values from database

        // update/save the profile of the user

        // redirect to the profile page
    }


    // method to view notifications
    public function notification()
    {
        return view('commuter.notification');
    }


    // method use to request ride ride form
    public function requestRide()
    {
        return view('commuter.request-ride');
    }


    // method use to view ride history of commuter
    public function rideHistory()
    {
        return view('commuter.ride-history');
    }
}
