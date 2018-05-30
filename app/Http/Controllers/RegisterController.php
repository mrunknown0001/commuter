<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    
    public function showRegistration()
    {
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

    	if(count($check_email) > 0) {
    		// return to designated view/page
    		return 'Email Already Used';
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
    	return 'Registration Successful';
    	

    }
}
