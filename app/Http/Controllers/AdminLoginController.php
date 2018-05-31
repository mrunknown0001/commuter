<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
    // admin login show form
    public function showAdminLoginForm()
    {
    	return view('admin-login');
    }


    // login method for admin
    public function postAdminLogin(Request $request)
    {
    	// validate admin credential input
    	
    	// Auth::guard('admin')->attempt($credentials)
    	// login attempt
    }

}
