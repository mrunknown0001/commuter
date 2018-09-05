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
    	return $request->validate([
    		'code' => 'required'
    	]);
    }
}
