<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SmsController;

use App\User;
use App\UserRetrievalCode;
use App\Admin;

class ForgotAccountController extends Controller
{
	// method use to show forgot account form
    public function forgotAccount()
    {
    	return view('forgot-account');
    }


    // method use to verify identity and send code to mobile number with the
    // username and the retrieval code
    // public function forgotAccountVerify(Request $request)
    // {
    // 	$request->validate([
    // 		'identification' => 'required'
    // 	]);

    // 	$id = $request['identification'];
    // 	$account_code = $request['code'];

    // 	$user = User::where('identification', $id)
    // 				->orwhere('mobile_number', $id)
    // 				->first();

    // 	if(count($user) < 1) {
    // 		return redirect()->back()->with('error', 'User not found!');
    // 	}

    // 	if($user->registered == 0) {
    // 		return redirect()->back()->with('error', 'User not active or registered!');
    // 	}

    // 	// delete old code
    // 	$old_code = UserRetrievalCode::where('user_id', $user->id)->where('used', 0)->first();
    // 	if(count($old_code) > 0) {
    // 		$old_code->delete();
    // 	}

    // 	$code = GeneralController::generateRandomString(5, '1234567890');

    // 	$message = 'The retrieval code for the account ' . strtoupper($user->identification) . ' is ' . $code . '. This code is valid for 5minutes.';

    // 	// send sms with retrival code
    // 	SmsController::sendSms($user->mobile_number, $message);

    // 	// save to retrival code
    // 	$ret = new UserRetrievalCode();
    // 	$ret->user_id = $user->id;
    // 	$ret->code = $code;
    // 	$ret->expiration = strtotime(now()) + 300;
    // 	$ret->type = $account_code;
    // 	$ret->save();

    // 	// generate report

    // 	// return to view/validate retrival code
    // 	return view('forgot-account-enter-code', ['user' => $user]);

    // }



    // method use to verify code entered by user
    public function forgotAccountVerifyCode(Request $request)
    {
    	$request->validate([
    		'code' => 'required'
    	]);

    	$code = $request['code'];
    	$user_id = $request['user_id'];

    	$user = User::findorfail($user_id);

    	// validate code
    	$check_code = UserRetrievalCode::where('user_id', $user->id)
    					->where('code', $code)
    					->where('used', 0)
    					->where('expiration', '>', strtotime(now()))
    					->first();

    	if(count($check_code) < 1) {
    		return redirect()->back()->with('error', 'Invalide Code!');
    	}

    	$check_code->used = 1;
    	$check_code->save();

    	// return to password change if all is validated an ok
    	return view('forgot-account-change-password', ['user' => $user]);
    }


    // method use to change password of the forgotten account
    public function postForgotAccountChangePassword(Request $request)
    {
    	$request->validate([
    		'password' => 'required|confirmed'
    	]);

    	$password = $request['password'];
    	$user_id = $request['user_id'];

    	$user = User::findorfail($user_id);

    	$user->password = bcrypt($password);
    	$user->save();

    	return redirect()->route('login')->with('success', 'Account Retrieved!');
    }


    // method use to check forgot account admin
    public function forgotAdminAccount()
    {
        return view('forgot-admin-account');
    }


    // method use to validate and send code
    // public function sendAdminCode(Request $request)
    // {
    //     $request->validate([
    //         'identification' => 'required'
    //     ]);

    //     $username = $request['identification'];
    //     $account_code = $request['code'];

    //     $admin = Admin::where('identification', $username)->first();

    //     if(count($admin) < 1) {
    //         return redirect()->back()->with('error', 'Admin Not Found!');
    //     }

    //     $old_code = UserRetrievalCode::where('admin_id', $admin->id)->where('used', 0)->first();
    //     if(count($old_code) > 0) {
    //         $old_code->delete();
    //     }

    //     $code = GeneralController::generateRandomString(5, '1234567890');

    //     $message = 'The retrieval code for the account ' . strtoupper($admin->identification) . ' is ' . $code . '. This code is valid for 5minutes.';

    //     // send sms with retrival code
    //     SmsController::sendSms($admin->mobile_number, $message);

    //     // save to retrival code
    //     $ret = new UserRetrievalCode();
    //     $ret->admin_id = $admin->id;
    //     $ret->code = $code;
    //     $ret->expiration = strtotime(now()) + 300;
    //     $ret->type = $account_code;
    //     $ret->save();

    //     // return to 
    //     return view('forgot-admin-account-enter-code', ['admin' => $admin]);
    // }


    // method use to verify code
    public function verifyAdminCode(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $code = $request['code'];
        $admin_id = $request['admin_id'];

        $admin = Admin::findorfail($admin_id);

        // validate code
        $check_code = UserRetrievalCode::where('admin_id', $admin->id)
                        ->where('code', $code)
                        ->where('used', 0)
                        ->where('expiration', '>', strtotime(now()))
                        ->first();

        if(count($check_code) < 1) {
            return redirect()->back()->with('error', 'Invalide Code!');
        }

        $check_code->used = 1;
        $check_code->save();

        return view('forgot-admin-account-change-password', ['admin' => $admin]);
    }


    // method use to change password
    public function postForgotAdminChangePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $password = $request['password'];
        $admin_id = $request['admin_id'];


        $admin = Admin::findorfail($admin_id);

        $admin->password = bcrypt($password);
        $admin->save();

        return redirect()->route('admin.login')->with('success', 'Account Retrieved!');
    }


    /*
     * start of new account recovery
     * 
     */
    public function forgotAccountVerify(Request $request)
    {
        $request->validate([
            'identification' => 'required'
        ]);

        $id = $request['identification'];

        // check for commuter/student
        $student = User::where('student_number', $id)->first();

        if(!empty($student)) {
            // return $student;

            // check if the student is already registered
            if($student->registered == 0) {
                return redirect()->back()->with('error', 'Active User Not Found!');
            }

            return view('forgot-account-commuter-answer-questions', ['user' => $student]);
        }

        // check for driver
        $driver = User::where('username', $id)->first();

        if(!empty($driver)) {
            // return $driver;
            return view('forgot-account-driver-answer-questions', ['user' => $driver]);
        }

        return redirect()->route('forgot.account')->with('error', 'No User Found!');


    }






    // postForgotCommuterAccountVerify
    public function postForgotCommuterAccountVerify(Request $request)
    {
        $father = $request['father'];
        $mother = $request['mother'];
        $fav_food = $request['fav_food'];
        $hobby = $request['hobby'];

        $user_id = $request['user_id'];

        $user = User::findorfail($user_id);

        if(strtoupper($user->father) == strtoupper($father) &&
            strtoupper($user->mother) == strtoupper($mother) &&
            strtoupper($user->fav_food) == strtoupper($fav_food) &&
            strtoupper($user->hobby) == strtoupper($hobby)
        ) {
            return view('forgot-account-commuter-change-password', ['user' => $user]);
        }
        else {
            return redirect()->back()->with('error', 'You\'re answer were incorrect. Please Try Again');
        }
    }



    public function postForgotAccountDriverVerify(Request $request)
    {
        $user_id = $request['user_id'];
        $username = $request['username'];
        $license = $request['license'];
        $plate_number = $request['plate_number'];

        $user = User::findorfail($user_id);

        if(strtoupper($user->username) == strtoupper($username) &&
            strtoupper($user->driver_info->license) == strtoupper($license) &&
            strtoupper($user->driver_info->plate_number) == strtoupper($plate_number)
        ) {
            return view('forgot-account-commuter-change-password', ['user' => $user]);
        }
        else {
            return redirect()->back()->with('error', 'You\'re answer were incorrect. Please Try Again');
        }
    }




    // admin recover account
    public function sendAdminCode(Request $request)
    {
        return 'admin account recovery';
    }
}
