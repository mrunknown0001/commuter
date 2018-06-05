<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Http\Controllers\GeneralController;

use App\ActivityLog;
use App\User;
use App\Admin;

class AdminController extends Controller
{
    public function __construct()
    {
    	// only admin can access
    	$this->middleware(['auth:admin', 'admin']);
    }


    // admin dashboard
    public function dashboard()
    {
        /////////////////////////////////////////////////////
        // get all data need to show in dashboard of admin //
        /////////////////////////////////////////////////////
    	return view('admin.dashboard');
    }


    // admin profile
    public function profile()
    {
        return view('admin.profile');
    }


    // method use to show profile update form
    public function profileUpdate()
    {
        return view('admin.update-profile');
    }


    // method use to post update profile
    public function postProfileUpdate(Request $request)
    {
        // validate request data
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required'
        ]);


        // assign to variables
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        // $email = $request['email'];

        // check email availability
        // if($email != Auth::guard('admin')->user()->email) {
        //     // check if the new email is used by other user
        //     $check_email = Admin::whereEmail($email)->first();

        //     if(count($check_email) > 0) {
        //         // the new email is already used by other user
        //         return redirect()->route('admin.profile.update')->with('error', 'The new Email ' . $email . ', already used!');
        //     }
        // }

        // save update
        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $admin->first_name = $first_name;
        $admin->last_name = $last_name;
        // $admin->email = $email;
        $admin->save();


        // log here
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Profile Update', now());

        // redirect route with succes message
        return redirect()->route('admin.profile')->with('success', 'Profile Updated!');
    }


    // method use view change password form
    public function changePassword()
    {
        return view('admin.change-password');
    }


    // method use to post change password
    public function postChangePassword(Request $request)
    {

        // validate form data
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed|max:50'
        ]);

        // assign values to variable
        $old_password = $request['old_password'];
        $password = $request['password'];


        // check if old password match
        if(password_verify($old_password, Auth::guard('admin')->user()->password)) {
            // true
            // save new password
            $admin = Admin::find(Auth::guard('admin')->user()->id);
            $admin->password = bcrypt($password);
            $admin->save();

            // log here
            GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Password Change', now());


            // redirect with success
            return redirect()->route('admin.change.password')->with('success', 'Password changed!');
        }

        return redirect()->route('admin.change.password')->with('error', 'Incorrect Old Password');

    }


    // admin add driver method, show the add driver form
    public function registerDriver()
    {
        return view('admin.register-driver');
    }



    // method to store new driver
    public function postRegisterDriver(Request $request)
    {
        // validate data
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'identification' => 'required|unique:users',
            'mobile_number' => 'required'
        ]);

        // store data in varabiels
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $id = $request['identification'];
        $mobile = $request['mobile_number'];
        // $email = $request['email'];


        // other check
        // check if email/mobile number is already used
        // $check_email = User::whereEmail($email)->first();

        // if($email != Null && count($check_email) > 0) {
        //     // return to designated view/page
        //     return redirect()->route('admin.register.driver')->with('error', 'Email ' . $email . ' is already used!')->withInput();
        // }

        $check_mobile = User::where('mobile_number', $mobile)->first();

        if($mobile != Null && count($check_mobile) > 0) {
            // return to designated view/page
            return redirect()->route('admin.register.driver')->with('error', 'Mobile Number ' . $mobile . ' is already used!')->withInput();
        }


        // save/register new driver info
        // driver is the default password for driver
        // user_type == 2
        $driver = new User();
        $driver->first_name = $first_name;
        $driver->last_name = $last_name;
        $driver->identification = $id;
        $driver->mobile_number = $mobile;
        // $driver->email = $email;
        $driver->user_type = 2;
        $driver->password = bcrypt('driver'); // driver is the default password for driver
        $driver->save();

        // save activity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Registered a Driver: ' . $driver->identification, now());

        // redirect with message success
        return redirect()->route('admin.register.driver')->with('success', 'Driver ' . $driver->identification . ' Successfully Registered!');
    }



    // method use to view all driver
    public function viewAllDriver()
    {
        // get all drivers in pagination form
        $drivers = User::where('user_type', 2)
                        ->where('active', 1)
                        ->orderBy('last_name', 'asc')
                        ->paginate(15);

        return view('admin.view-all-drivers', ['drivers' => $drivers]);
    }


    // method use to view all commuters
    public function viewAllCommuters()
    {
        // get all drivers in pagination form
        $commuters = User::where('user_type', 1)
                        ->where('active', 1)
                        ->orderBy('last_name', 'asc')
                        ->paginate(15);

        return view('admin.view-all-commuters', ['commuters' => $commuters]);
    }



    // method use to view all rides history
    public function ridesHistory()
    {
        return view('admin.rides-history');
    }



    // method use to view commutes reports
    public function commutersReports()
    {
        return view('admin.commuters-reports');
    }



    // method use to view drivers reports
    public function driversReports()
    {
        return view('admin.drivers-reports');
    }


    // method use to view feedbacks
    public function viewFeedbacks()
    {
        return view('admin.feedbacks');
    }


    // admin activity log
    public function activityLog()
    {
        $logs = ActivityLog::orderBy('performed_on', 'desc')->paginate(15);

        return view('admin.activity-log', ['logs' => $logs]);
    }
}
