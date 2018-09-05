<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SmsController;

use App\User;
use App\UserRetrievalCode;

class ForgotAccountController extends Controller
{
	// method use to show forgot account form
    public function forgotAccount()
    {
    	return view('forgot-account');
    }


    // method use to verify identity and send code to mobile number with the
    // username and the retrieval code
    public function forgotAccountVerify(Request $request)
    {
    	$request->validate([
    		'identification' => 'required'
    	]);

    	$id = $request['identification'];
    	$account_code = $request['code'];

    	$user = User::where('identification', $id)
    				->orwhere('mobile_number', $id)
    				->first();

    	if(count($user) < 1) {
    		return redirect()->back()->with('error', 'User not found!');
    	}

    	if($user->registered == 0) {
    		return redirect()->back()->with('error', 'User not active or registered!');
    	}

    	// delete old code
    	$old_code = UserRetrievalCode::where('user_id', $user->id)->where('used', 0)->first();
    	if(count($old_code) > 0) {
    		$old_code->delete();
    	}

    	$code = GeneralController::generateRandomString(5, '1234567890');

    	$message = 'The retrieval code for the account ' . strtoupper($user->identification) . ' is ' . $code . '. This code is valid for 5minutes.';

    	// send sms with retrival code
    	SmsController::sendSms($user->mobile_number, $message);

    	// save to retrival code
    	$ret = new UserRetrievalCode();
    	$ret->user_id = $user->id;
    	$ret->code = $code;
    	$ret->expiration = strtotime(now()) + 300;
    	$ret->type = $account_code;
    	$ret->save();

    	// generate report

    	// return to view/validate retrival code
    	return view('forgot-account-enter-code', ['user' => $user]);

    }



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
}
