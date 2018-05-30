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
			// check if what type of user
			// return to designated page
			if(Auth::user()->user_type == 1) {
				return 'The authenticated user is commuter!';
			}
			else {
				return 'The authenticated user is driver!';
			}
			
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
    		return 'Login Success!';
    		// redirect to homepage of the user based on its user type
    	}

    	return 'No User';
    	
    }
}
