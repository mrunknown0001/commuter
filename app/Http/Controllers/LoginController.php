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
			return 'user is authenticated';
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
