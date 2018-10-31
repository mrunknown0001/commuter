<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\GeneralController;

class AdminLoginController extends Controller
{
    // admin login show form
    public function showAdminLoginForm()
    {

        if(Auth::guard('admin')->check()) {
            return $this->check_admin();
        }
        elseif(Auth::check()) {
            return redirect()->route('login');
        }

    	return view('admin-login');
    }


    // login method for admin
    public function postAdminLogin(Request $request)
    {

    	// validate admin credential input
    	$request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);


        // assign to variables
        $id = $request['username'];
        $password = $request['password'];

    	// Auth::guard('admin')->attempt($credentials)
    	if(Auth::guard('admin')->attempt(['username' => $id, 'password' => $password, 'active' => 1])) {
            // add log here
            GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Login', now());

            return redirect()->route('admin.dashboard');
        }

        // return admin not found
        return redirect()->route('admin.login')->with('error', 'Admin Not Found!');
    }


    // this method is use to redirect to home page of the type of the authenticated admin
    // this method can call in other controller
    public static function check_admin()
    {
        // check if what type of user
        // return to designated page
        // user type: 1 for commuter, 2 for the driver
        if(Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        else {
            return redirect()->route('login');
        }
    }

}
