<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Http\Controllers\GeneralController;

use App\ActivityLog;
use App\User;
use App\Admin;
use App\Ride;
use App\AdminId;
use App\Feedback;
use App\Report;

class AdminController extends Controller
{
    public function __construct()
    {
    	// only admin can access
    	$this->middleware('auth:admin');
    }



    //////////////////////////////////////////
    // all super admin method will go there //
    //////////////////////////////////////////


    // method to view all guard or admin
    public function viewAllAdmin()
    {
        // get all the admin in the admins table
        $admins = Admin::where('role', 2)
                        ->orderBy('last_name', 'asc')
                        ->paginate(15);

        return view('admin.view-all-admins', ['admins' => $admins]);
    }


    // method use to view admin ids
    public function viewAdminId()
    {
        // get all admin ids
        $ids = AdminId::paginate(10);

        return view('admin.view-all-admin-ids', ['ids' => $ids]);
    }


    // method use to view adin logs
    public function viewAdminLogs()
    {
        // admin logs
        $logs = ActivityLog::where('user_id', null)
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);

        return view('admin.admin-log', ['logs' => $logs]);
    }



    ////////////////////////////////////////
    // end of all methods of super admins //
    ////////////////////////////////////////




    // admin dashboard
    public function dashboard()
    {

        // get all data need to show in dashboard of admin //
        $rides = Ride::where('finished', 1)
                        ->where('cancelled', 0)
                        ->get();
                        
        $commuters = User::where('user_type', 1)->get();
        $drivers = User::where('user_type', 2)->get();
        $current_rides = Ride::where('current', 1)
                            ->where('finished', 0)
                            ->get();

    	return view('admin.dashboard', ['rides' => $rides, 'commuters' => $commuters, 'drivers' => $drivers, 'current_rides' => $current_rides]);
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
            'last_name' => 'required',
            'mobile_number' => 'required'
        ]);


        // assign to variables
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $mobile_number = $request['mobile_number'];
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
        $admin->mobile_number = $mobile_number;
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




    // method use to view all driver
    public function viewAllDriver()
    {
        // get all drivers in pagination form
        $drivers = User::where('user_type', 2)
                        ->orderBy('last_name', 'asc')
                        ->paginate(15);

        return view('admin.view-all-drivers', ['drivers' => $drivers]);
    }


    // method use to search driver
    public function searchDriver(Request $request)
    {
        $q = $request['q'];

        // find all related keyword on the database
        $drivers = User::where('user_type', 2)
                        ->where('first_name', "like", "$q%")
                        ->orwhere('last_name', "like", "%$q%")
                        ->orwhere('identification', "like", "%$q%")
                        ->orderBy('last_name', 'asc')
                        ->paginate(5);


        // add log for search
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Searched: ' . $q, now());

        return view('admin.driver-search-results', ['drivers' => $drivers, 'term' => $q]);       
    }



    // method use to view driver details
    public function viewDriverDetails($id = null)
    {
        $driver = User::findorfail($id);

        if($driver->user_type != 2) {
            // return to commuter
            return redirect()->route('admin.view.all.commuters');
        }

        return view('admin.driver-details', ['driver' => $driver]);
    }




    // method use to view all commuters
    public function viewAllCommuters()
    {
        // get all drivers in pagination form
        $commuters = User::where('user_type', 1)
                        ->orderBy('last_name', 'asc')
                        ->paginate(15);

        return view('admin.view-all-commuters', ['commuters' => $commuters]);
    }


    // method use to search commuters
    public function searchCommuter(Request $request)
    {
        $q = $request['q'];

        // find all related keyword on the database
        $commuters = User::where('user_type', 1)
                        ->where('first_name', "like", "$q%")
                        ->orwhere('last_name', "like", "%$q%")
                        ->orwhere('identification', "like", "%$q%")
                        ->orderBy('last_name', 'asc')
                        ->paginate(5);

        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Searched: ' . $q, now());

        return view('admin.commuter-search-results', ['commuters' => $commuters, 'term' => $q]);
    }


    // method use to view details of commuter
    public function viewCommuterDetails($id = null)
    {
        // get the info of the commuter
        $commuter = User::findorfail($id);

        if($driver->user_type != 1) {
            // return to commuter
            return redirect()->route('admin.view.all.driver');
        }


        return view('admin.commuter-details', ['commuter' => $commuter]);
    }


    // method use to block user
    public function blockUser(Request $request)
    {
        $id = $request['id'];

        $user = User::findorfail($id);
        $user->active = 0;
        $user->save();

        // activity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Block User: ' . $user->identification, now());


        // return to dashboard
        return redirect()->route('admin.dashboard')->with('success', 'User Blocked!');
    }


    // method use to unblock user
    public function unblockUser(Request $request)
    {
        $id = $request['id'];

        $user = User::findorfail($id);
        $user->active = 1;
        $user->save();

        // activity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Unnlock User: ' . $user->identification, now());


        // return to dashboard
        return redirect()->route('admin.dashboard')->with('success', 'User Unblocked!');
    }


    // method use to view current rides
    public function currentRides()
    {
        $rides = Ride::where('current', 1)
                    ->where('cancelled', 0)
                    ->where('finished', 0)
                    ->orderBy('updated_at', 'desc')
                    ->paginate(15);

        return view('admin.current-rides', ['rides' => $rides]);
    }



    // method use to view cancelled rides
    public function cancelledRides()
    {
        // get all cancelled rides
        $rides = Ride::where('cancelled', 1)
                    ->where('finished', 1)
                    ->orderBy('updated_at', 'desc')
                    ->paginate(15);

        return view('admin.cancelled-rides', ['rides' => $rides]);
    }



    // method use to view all rides history
    public function ridesHistory()
    {
        // get all data of finished rides and not cancelled
        $rides = Ride::where('cancelled', 0)
                    ->where('finished', 1)
                    ->orderBy('updated_at', 'desc')
                    ->paginate(15);

        return view('admin.rides-history', ['rides' => $rides]);
    }



    // method use to view details of ride
    public function rideDetails($id = null, $ride_number)
    {
        $ride = Ride::findorfail($id);


        // other checking, check if the id and ride_number belongs to the same ride
        if($ride->ride_number != $ride_number) {
            return redirect()->back();
        }

        return view('admin.ride-details', ['ride' => $ride]);

    }



    // method use to view commutes reports
    public function commutersReports()
    {
        // get all commuters report
        // user type == 1
        
        $reports = Report::where('user_type', 1)
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);

        return view('admin.commuters-reports', ['reports' => $reports]);
    }



    // method use to view commuter report details
    public function commuterReportView($id = null, $report_number = null)
    {
        // validate
        $report = Report::findorfail($id);
        $report->viewed = 1;
        $report->save();

        // assign to variables

        // generate log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Viewed Report of Commuter', now());

        // return to page with data
        return view('admin.commuter-report-details', ['report' => $report]);
    }



    // method use to view drivers reports
    public function driversReports()
    {
        // get all driver report
        // user type == 2
        $reports = Report::where('user_type', 2)
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);

        return view('admin.drivers-reports', ['reports' => $reports]);
    }



    // method use to view driver report detils
    public function driverReportView($id = null, $report_number = null)
    {
        // validate
        $report = Report::findorfail($id);


        // check the report number belongs to the report
        if($report->report_number != $report_number) {
            return redirect()->back();
        }

        $report->viewed = 1;
        $report->save();

        // assign to variables

        // generate log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Viewed Report of Commuter', now());

        // return to page with data
        return view('admin.driver-report-details', ['report' => $report]);
    }


    // method use to view feedbacks
    public function viewFeedbacks()
    {
        // get all the unread feedbacks
        $feedbacks = Feedback::orderBy('created_at', 'desc')
                            ->paginate(15);

        return view('admin.feedbacks', ['feedbacks' => $feedbacks]);
    }


    // method use to view feddback details
    public function viewFeedbackDetails($id = null, $feedback_number)
    {
        $feedback = Feedback::findorfail($id);

        // add checking here if the 2 parameters not matched with the record
        // if the id is not the number of feedback number
        if($feedback->feedback_number != $feedback_number) {
            return redirect()->back();
        }

        // make feedback viewed status
        if($feedback->viewed == 0) {
            $feedback->viewed = 1;
            $feedback->save();
        }

        // add log the admin viewed the feedback
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin View Feedback', now());

        // return to view
        return view('admin.view-feedback', ['feedback' => $feedback]);
    }


    // admin activity log
    public function activityLog()
    {
        $logs = ActivityLog::where('admin_id', null)
                        ->orderBy('performed_on', 'desc')
                        ->paginate(15);

        return view('admin.activity-log', ['logs' => $logs]);
    }
}
