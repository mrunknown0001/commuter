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
}
