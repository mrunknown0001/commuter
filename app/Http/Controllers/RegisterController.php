<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SmsController;

use App\User;
use App\DriverInfo;
use App\AdminId;
use App\Admin;
use App\UserCode;

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


    // method use to register/show details
    public function postRegisterCommuter(Request $request)
    {
        $request->validate([
            'student_number' => 'required'
        ]);

        $student_number = $request['student_number'];

        // find student
        $student = User::where('student_number', $student_number)->first();

        if(count($student) < 1) {
            return redirect()->back()->with('error', 'No Student Found!');
        }

        // check if registered
        if($student->registered == 1) {
            return redirect()->back()->with('info', 'Student Already Registered!');
        }

        // if no, enter detail of student
        // return to input password
        return 'return to input details of student';
    }


    public function checkCommuterRegistration(Request $request)
    {

        $request->validate([
            'id' => 'required'
        ]);

        $identification = $request['id'];

        $commuter = User::where('identification', $identification)->first();

        if(count($commuter) < 1) {
            return redirect()->back()->with('error', 'Identification not found!');
        }

        if($commuter->registered == 1) {
            return redirect()->back()->with('error', 'Commuter already registered! If it\'s you, please report to admin');
        }



        return view('commuter-registration-validation', ['commuter' => $commuter]);
    }


    public function verifyCommuterRegistration(Request $request)
    {
        // validate mobile number
        $request->validate([
            'mobile_number' => 'required|unique:users|numeric|digits:11'
        ]);

        $commuter_id = $request['commuter_id'];
        $mobile_number = $request['mobile_number'];

        $commuter = User::findorfail($commuter_id);

        if(count($commuter) < 1) {
            return redirect()->back()->with('error', 'Identification not found!');
        }

        if($commuter->registered == 1) {
            return redirect()->back()->with('error', 'Commuter already registered! If it\'s you, please report to admin');
        }

        // save number to user
        $commuter->mobile_number = $mobile_number;
        $commuter->save();

        // create validation code
        // last for 5 mins
        $user_code = UserCode::where('user_id', $commuter->id)
                            ->where('used', 0)
                            ->first();

        if(count($user_code) < 1) {

            $code = new UserCode();
            $code->user_id = $commuter->id;
            $code->code = GeneralController::generateRandomString(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
            $code->expiration = date(strtotime(now())) + 300; // for 5 mins exp
            $code->save();

            $message = 'Your Registration Code is ' . strtoupper($code->code);

            // send the code here
            SmsController::sendSms($commuter->mobile_number, $message);
        }


        

        return view('commuter-registration-validation-code', ['commuter' => $commuter]);
    }


    public function codeVerification(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $commuter_id = $request['commuter_id'];
        $code = $request['code'];

        $commuter = User::findorfail($commuter_id);

        if(count($commuter) < 1) {
            return redirect()->back()->with('error', 'Identification not found!');
        }

        if($commuter->registered == 1) {
            return redirect()->back()->with('error', 'Commuter already registered! If it\'s you, please report to admin');
        }

        // check code if valid
        $check = UserCode::where('user_id', $commuter->id)
                        ->where('used', 0)
                        ->first();

        if(count($check) < 1) {
            return redirect()->route('commuter.registration')->with('error', 'Error! Please Try Again!');
        }

        // check the code and the expiration time
        if(strtoupper($check->code) == strtoupper($code) && $check->expiration > date(strtotime(now()))) {
            
            $check->used = 1;
            $check->save();

            return view('commuter-registration-check', ['commuter' => $commuter]);
        }
        else {
            return redirect()->route('commuter.registration')->with('error', 'Invalid or Expired Code! Please Try Again!'); 
        }

        return redirect()->route('commuter.registration')->with('error', 'Error! Please Try Again!');

    }


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
