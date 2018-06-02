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
