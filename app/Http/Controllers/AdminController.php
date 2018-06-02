<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Http\Controllers\GeneralController;

use App\ActivityLog;
use App\User;

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
    	return view('admin.dashboard');
    }


    // admin profile
    public function profile($username = null)
    {
        return view('admin.profile');
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
            'identification' => 'required|unique:users'
        ]);

        // store data in varabiels
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $id = $request['identification'];
        $mobile = $request['mobile_number'];
        $email = $request['email'];


        // other check
        // check if email/mobile number is already used
        $check_email = User::whereEmail($email)->first();

        if($email != Null && count($check_email) > 0) {
            // return to designated view/page
            return redirect()->route('admin.register.driver')->with('error', 'Email ' . $email . ' is already used!')->withInput();
        }


        // save/register new driver info
        // driver is the default password for driver
        // user_type == 2
        $driver = new User();
        $driver->first_name = $first_name;
        $driver->last_name = $last_name;
        $driver->identification = $id;
        $driver->mobile_number = $mobile;
        $driver->email = $email;
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
