<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    	return $request;
    }
}
