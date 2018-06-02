<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
