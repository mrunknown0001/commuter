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
    	return Auth::user();
    }
}
