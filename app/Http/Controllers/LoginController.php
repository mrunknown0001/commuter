<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{

	public function showLogin()
	{
		// check if the user is authenticated
		if(Auth::check()) {
			return $this->check_user();
		}
		else {
			// return the login page view
			return view('login');
		}
	}
    
    public function postLogin(Request $request)
    {

    	// validate inputs
    	$request->validate([
    		'identification' => 'required',
    		'password' => 'required|min:6'
    	]);
    	

    	// assign values to variable
    	$id = $request['identification'];
    	$password = $request['password'];


    	// authenticate user
    	if(Auth::attempt(['identification' => $id, 'password' => $password])) {
    		// login success
    		// redirect to homepage of the user based on its user type
            return $this->check_user();
    	}


    	// return with error displaying on the login form
    	// with no user found
    	return redirect()->route('login')->with('error', 'No User Found!');
    	
    }



    // check authenticated user in accessing login page
    public function showWelcome()
    {
        if(Auth::check()) {
            return $this->check_user();
        }

        return view('welcome');
    }




    // this method is use to redirect to home page of the type of the authenticated user
    // this method can call in other controller
    public static function check_user()
    {
        // check if what type of user
        // return to designated page
        // user type: 1 for commuter, 2 for the driver
        if(Auth::user()->user_type == 1) {
            return redirect()->route('commuter.home');
        }
        else {
            return redirect()->route('driver.home');
        }
    }

}
