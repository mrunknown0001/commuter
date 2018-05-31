<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Controllers\LoginController;

class RegisterController extends Controller
{
    
    public function showRegistration()
    {
        // check if there is authenticated user
        if(Auth::check()) {
            return LoginController::check_user();
        }
    	// return the registration form view for the commuter
    	return view('register');
    }


    public function postRegistration(Request $request)
    {
    	// validate request data
    	$request->validate([
    		'first_name' => 'required|max:255',
    		'last_name' => 'required|max:255',
    		'identification' => 'required|unique:users|max:20',
    		'mobile_number' => 'max:11',
    		'password' => 'required|min:6|confirmed|max:50'
    	]);


    	// assign values in variable for use
    	$first_name = $request['first_name'];
    	$last_name = $request['last_name'];
    	$id = $request['identification'];
    	$mobile_number = $request['mobile_number'];
    	$email = $request['email'];
    	$password = bcrypt($request['password']);


    	// check if there is existing email used
    	$check_email = User::whereEmail($email)->first();

    	if($email != Null && count($check_email) > 0) {
    		// return to designated view/page
    		return redirect()->route('register')->with('error', 'Email is already used!');
    	}


    	// create user
    	$user = new User();
    	$user->first_name = $first_name;
    	$user->last_name = $last_name;
    	$user->identification = $id;
    	$user->mobile_number = $mobile_number;
    	$user->email = $email;
    	$user->password = $password;
    	$user->save();


    	// return to designated page
    	// with success message
    	return redirect()->route('register')->with('success', 'Registration Successful! You can now login!');
    	

    }
}
