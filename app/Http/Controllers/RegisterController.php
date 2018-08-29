<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GeneralController;

use App\User;
use App\DriverInfo;
use App\AdminId;
use App\Admin;

class RegisterController extends Controller
{
    
    public function commuterRegistration()
    {
        // check if there is authenticated user
        if(Auth::check()) {
            return LoginController::check_user();
        }
        else if(Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
    	// return the registration form view for the commuter
    	return view('commuter-registration');
    }

    public function checkCommuterRegistration(Request $request)
    {
        $request->validate(['identification' => 'required']);

        $identification = $request['identification'];

        $commuter = User::whereIdentification($identification)->first();

        if(count($commuter) < 1) {
            return redirect()->back()->with('error', 'Identification not found!');
        }

        return view('commuter-registration-check', ['commuter' => $commuter]);
    }


    // public function postCommuterRegistration(Request $request)
    // {
    //     // validate request data
    //     $request->validate([
    //         'first_name' => 'required|max:255',
    //         'last_name' => 'required|max:255',
    //         'identification' => 'required|unique:users|max:20',
    //         'mobile_number' => 'required|unique:users',
    //         'password' => 'required|min:6|confirmed|max:50'
    //     ]);


    //     // assign values in variable for use
    //     $first_name = $request['first_name'];
    //     $last_name = $request['last_name'];
    //     $id = $request['identification'];
    //     $mobile_number = $request['mobile_number'];
    //     // $email = $request['email'];
    //     $password = $request['password'];


    //     // check if there is existing email used
    //     // $check_email = User::whereEmail($email)->first();

    //     // if($email != Null && count($check_email) > 0) {
    //     //  // return to designated view/page
    //     //  return redirect()->route('register')->with('error', 'Email ' . $email . ' is already used!');
    //     // }


    //     // check if the mobile number is used by other user
    //     $check_mobile = User::where('mobile_number', $mobile_number)->first();

    //     if($mobile_number != Null && count($check_mobile) > 0) {
    //         // return to designated view/page
    //         return redirect()->route('commuter.registration')->with('error', 'Mobile Number ' . $mobile_number . ' is already used!');
    //     }


    //     // create user
    //     $user = new User();
    //     $user->first_name = $first_name;
    //     $user->last_name = $last_name;
    //     $user->identification = $id;
    //     $user->mobile_number = $mobile_number;
    //     // $user->email = $email;
    //     $user->password = bcrypt($password);
    //     $user->save();


    //     // mobile number check


    //     // add log here
    //     GeneralController::activity_log($user->id, null, 'Commuter Registration', now());
    //     // return to designated page
    //     // with success message
    //     return redirect()->route('login')->with('success', 'Registration Successful! You can now login!');
        

    // }


    public function postCommuterRegistration(Request $request)
    {
    	// validate request data
    	$request->validate([
            'commuter_id' => 'required',
    		'password' => 'required|min:6|confirmed|max:50'
    	]);

    	$password = $request['password'];
        $commuter_id = $request['commuter_id'];


    	// create user
    	$user = User::findorfail($commuter_id);
    	// $user->email = $email;
    	$user->password = bcrypt($password);
        $user->active = 1;
        $user->registered = 1;
    	$user->save();


        // add log here
        GeneralController::activity_log($user->id, null, 'Commuter Registration', now());
    	// return to designated page
    	// with success message
    	return redirect()->route('login')->with('success', 'Registration Successful! You can now login!');
    	

    }



    public function driverRegistration()
    {
        // check if there is authenticated user
        if(Auth::check()) {
            return LoginController::check_user();
        }
        else if(Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        // return the registration form view for the commuter
        return view('driver-registration');
    }



    public function postDriverRegistration(Request $request)
    {


        // validate request data
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'identification' => 'required|unique:users|max:20',
            'mobile_number' => 'required|unique:users',
            'password' => 'required|min:6|confirmed|max:50',
            'body_number' => 'required',
            'plate_number' => 'required|unique:driver_infos',
            'operator_name' => 'required'
        ]);


        // assign request data to variables
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $id = $request['identification'];
        $mobile_number = $request['mobile_number'];
        $password = $request['password'];

        $body_number = $request['body_number'];
        $plate_number = $request['plate_number'];
        $operator_name = $request['operator_name'];


        // additional check


        // save information on users and driver_infos
        $user = new User();
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->identification = $id;
        $user->mobile_number = $mobile_number;
        $user->user_type = 2;
        $user->password = bcrypt($password);
        $user->save();

        $info = new DriverInfo();
        $info->driver_id = $user->id;
        $info->body_number = $body_number;
        $info->plate_number = $plate_number;
        $info->operator_name = $operator_name;
        $info->save();


        // log here
        GeneralController::activity_log($user->id, null, 'Driver Registration', now());

        // redirect message success
        return redirect()->route('login')->with('success', 'Registration Successful! You can now login!');

    }




    // method to show admin registration
    public function adminRegistration()
    {        
        // check if there is authenticated user
        if(Auth::check()) {
            return LoginController::check_user();
        }
        else if(Auth::guard('admin')->check()) {
            return redirect()->route('admin.dahsboard');
        }
        
        return view('admin-registration');
    }


    // method use to register admin
    public function postAdminRegistration(Request $request)
    {

        // validate request data
        $request->validate([
            'identification' => 'required|unique:admins',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required|unique:admins',
            'password' => 'required|min:6|max:50|confirmed'
        ]);


        // assign to variables
        $id = $request['identification'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $mobile_number = $request['mobile_number'];
        $password = $request['password'];


        // check if the id is known by system
        $check_id = AdminId::where('identification', $id)
                        ->where('used', 0)
                        ->first();

        if(count($check_id) < 1) {
            // the id is not recognize by the system
            return redirect()->route('admin.registration')->with('error', 'Identification Error!')->withInput(
                                    $request->except(['identification', 'password'])
                                );
        }



        // save admin user 
        $admin = new Admin();
        $admin->first_name = $first_name;
        $admin->last_name = $last_name;
        $admin->identification = $id;
        $admin->mobile_number = $mobile_number;
        $admin->password = bcrypt($password);
        $admin->save();


        // set admin id used 
        $admin_id = AdminId::where('identification', $id)->first();
        $admin_id->used = 1;
        $admin_id->save();


        // activity log
        GeneralController::activity_log(null, $admin->id, 'Admin Registration', now());


        // redirect with message
        return redirect()->route('admin.login')->with('success', 'Admin Registration Successful!');
    }
}
