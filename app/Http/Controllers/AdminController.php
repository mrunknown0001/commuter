<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\GeneralController;

use App\ActivityLog;
use App\User;
use App\Admin;
use App\Ride;
use App\AdminId;
use App\Feedback;
use App\Report;
use App\Avatar;
use App\DriverInfo;
use App\Location;

class AdminController extends Controller
{

    public function __construct()
    {
    	// only admin can access
    	$this->middleware('auth:admin');
    }


    public function index()
    {
        $value = Cache::get('key');
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


    // method use to add admin
    public function addAdmin()
    {
        return view('admin.admin-add');
    }


    // method use to save new admin
    public function postAddAdmin(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:admins,identification',
            'mobile_number' => 'required|unique:admins'
        ]);

        $fn = $request['first_name'];
        $ln = $request['last_name'];
        $username = $request['username'];
        $mobile = $request['mobile_number'];

        // save new admin, the defaul password is password
        $admin = new Admin();
        $admin->first_name = $fn;
        $admin->last_name = $ln;
        $admin->identification = $username;
        $admin->mobile_number = $mobile;
        $admin->password = bcrypt('password');
        $admin->save();

        $photoname = time().'.'.$request->image->getClientOriginalExtension();

        /*
        talk the select file and move it public directory and make avatars
        folder if doesn't exsit then give it that unique name.
        */
        $request->image->move(public_path('uploads/images'), $photoname);

        // save photoname to database
        $avatar = new Avatar();
        $avatar->admin_id = $admin->id;
        $avatar->avatar = $photoname;
        $avatar->save();


        // activity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Added new Admin Guard', now());


        // return with success
        return redirect()->route('admin.view.all.admin')->with('succes', 'Admin Added. Default password: password');
    }


    // method use to update admin
    public function updateAdmin($id = null)
    {
        $admin = Admin::findorfail($id);

        return view('admin.admin-update', ['admin' => $admin]);
    }


    // method use to save update on admin
    public function postUpdateAdmin(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required'
        ]);

        $admin_id = $request['admin_id'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $mobile = $request['mobile_number'];

        $admin = Admin::findorfail($admin_id);

        $check_mobile = Admin::where('mobile_number', $mobile)->first();

        if(count($check_mobile) > 0 && $check_mobile->id != $admin->id) {
            return redirect()->back()->with('error', 'Mobile Number Already Used!');
        }

        $admin->first_name = $first_name;
        $admin->last_name = $last_name;
        $admin->mobile_number = $mobile;
        $admin->save();

        // add to activity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Update Admin Guard', now());

        // add return message
        return redirect()->back()->with('success', 'Admin Detail Updated!');
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


        // save update
        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $admin->first_name = $first_name;
        $admin->last_name = $last_name;
        $admin->mobile_number = $mobile_number;
        $admin->save();


        // log here
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Profile Update', now());

        // redirect route with succes message
        return redirect()->route('admin.profile')->with('success', 'Profile Updated!');
    }


    // method use to show upload iamge form
    public function uploadProfileImage()
    {
        return view('admin.upload-profile-image');
    }


    // method use to save uploaded image
    public function postUploadProfileImage(Request $request)
    {
        // get current time and append the upload file extension to it,
        // then put that name to $photoName variable.
        $photoname = time().'.'.$request->image->getClientOriginalExtension();

        /*
        talk the select file and move it public directory and make avatars
        folder if doesn't exsit then give it that unique name.
        */
        $request->image->move(public_path('uploads/images'), $photoname);


        $avatar = Avatar::where('admin_id', Auth::guard('admin')->user()->id)->first();

        // save photoname to database
        if(count($avatar) < 1) {
            $avatar = new Avatar();
            $avatar->admin_id = Auth::user()->id;
            $avatar->avatar = $photoname;
            $avatar->save();
        }
        else {
            $avatar->avatar = $photoname;
            $avatar->save();
        }

        // ad dactivity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Upload Profile Image', now());

        //return to profile
        return redirect()->route('admin.profile')->with('success', 'Profile Image Uploaded!');
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


    // method use to add driver
    public function addDriver()
    {
        return view('admin.driver-add');
    }


    // method use to save new driver
    public function postAddDriver(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,identification',
            'mobile_number' => 'required|unique:users',
            'body_number' => 'required|min:3|max:10|unique:driver_infos',
            'plate_number' => 'required|unique:driver_infos'
        ]);

        $fn = $request['first_name'];
        $ln = $request['last_name'];
        $username = $request['username'];
        $mobile = $request['mobile_number'];
        $body_number = $request['body_number'];
        $plate_number = $request['plate_number'];
        $license = $request['license_number'];
        $operator = $request['operator'];

        // add users table the driver 
        $driver = new User();
        $driver->first_name = $fn;
        $driver->last_name = $ln;
        $driver->identification = $username;
        $driver->mobile_number = $mobile;
        $driver->password = bcrypt('password');
        $driver->user_type = 2;
        $driver->active = 1;
        $driver->registered = 1;
        $driver->save();



        $photoname = time().'.'.$request->image->getClientOriginalExtension();

        /*
        talk the select file and move it public directory and make avatars
        folder if doesn't exsit then give it that unique name.
        */
        $request->image->move(public_path('uploads/images'), $photoname);

        // save photoname to database
        $avatar = new Avatar();
        $avatar->user_id = $driver->id;
        $avatar->avatar = $photoname;
        $avatar->save();


        // add in driver_infos table
        $info = new DriverInfo();
        $info->driver_id = $driver->id;
        $info->plate_number = $plate_number;
        $info->body_number = $body_number;
        $info->operator_name = $operator;
        $info->license = $license;
        $info->save();

        // add to activity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Added New Driver', now());

        // add to return message
        return redirect()->back()->with('success', 'New Driver Added!');

    }


    // method use to update driver info
    public function updateDriver($id = null)
    {
        $driver = User::findorfail($id);

        return view('admin.driver-update', ['driver' => $driver]);
    }


    // method use to save update on driver
    public function postUpdateDriver(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required',
            'body_number' => 'required',
            'plate_number' => 'required'
        ]);

        $driver_id = $request['driver_id'];
        $fn = $request['first_name'];
        $ln = $request['last_name'];
        $username = $request['username'];
        $mobile = $request['mobile_number'];
        $body_number = $request['body_number'];
        $plate_number = $request['plate_number'];
        $license = $request['license_number'];
        $operator = $request['operator'];

        $driver = User::findorfail($driver_id);

        // add validation

        $driver->first_name = $fn;
        $driver->last_name = $ln;
        $driver->identification = $username;
        $driver->mobile_number = $mobile;
        $driver->password = bcrypt('password');
        $driver->save();

        // driver avatar
        $avatar = Avatar::where('user_id', $driver->id)->first();
        $avatar->user_id = $driver->id;
        $avatar->avatar = null;
        $avatar->save();

        // add in driver_infos table
        $info = DriverInfo::where('driver_id', $driver->id)->first();
        $info->driver_id = $driver->id;
        $info->plate_number = $plate_number;
        $info->body_number = $body_number;
        $info->operator_name = $operator;
        $info->license = $license;
        $info->save();

        // add to activity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Driver Details Updated', now());

        // add to return message
        return redirect()->back()->with('success', 'Driver Details Updated!');
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



    // method use to view driver report made
    public function viewDriverReport($id = null)
    {
        $driver = User::findorfail($id);

        return view('admin.driver-reports', ['driver' => $driver]);
    }



    // method use to view complaint on driver
    public function viewDriverComplaint($id = null)
    {
        $driver = User::findorfail($id);

        return view('admin.driver-complaint', ['driver' => $driver]);
    }




    // method use to view feedback received by driver
    public function viewDriverFeedback($id = null)
    {
        $driver = User::findorfail($id);

        return view('admin.driver-feedback', ['driver' => $driver]);
    }


    // method use to add student commuter to the system for validation
    public function addCommuter()
    {
        return view('admin.commuter-add-record');
    }


    // method use to save student record to the system
    public function postAddCommuter(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'identification' => 'required|unique:users'
        ]);

        $fn = $request['first_name'];
        $ln = $request['last_name'];
        $id = $request['identification'];

        $new = new User();
        $new->first_name = $fn;
        $new->last_name = $ln;
        $new->identification = $id;
        $new->save();

        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Added New Commuter');

        return redirect()->back()->with('success', 'Success! Commuter Added!');
    }


    // method use to upate commuter details
    public function upateCommuter($id = null)
    {
        $commuter = User::findorfail($id);

        return view('admin.commuter-update-record', ['commuter' => $commuter]);
    }


    // method use to save update in commuter details
    public function postUpdateCommuter(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'identification' => 'required'
        ]);

        $fn = $request['first_name'];
        $ln = $request['last_name'];
        $id = $request['identification'];
        $commuter_id = $request['commuter_id'];

        $commuter = User::findorfail($commuter_id);

        // check id
        $check_id = User::where('identification', $id)->first();

        if(count($check_id) > 0 && $check_id->id != $commuter->id) {
            return redirect()->back()->with('error', 'Identification already exists!');
        }

        $commuter->first_name = $fn;
        $commuter->last_name = $ln;
        $commuter->identification = $id;
        $commuter->save();

        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Updated Commuter Details');

        return redirect()->route('admin.view.all.commuters')->with('success', 'Admin saved commuter record!');

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

        if($commuter->user_type != 1) {
            // return to commuter
            return redirect()->route('admin.view.all.driver');
        }


        return view('admin.commuter-details', ['commuter' => $commuter]);
    }


    // method use to view report 
    public function viewCommuterReport($id = null)
    {
        $commuter = User::findorfail($id);

        return view('admin.commuter-reports', ['commuter' => $commuter]);
    }



    // method use to view feedback 
    public function viewCommuterFeedback($id = null)
    {
        $commuter = User::findorfail($id);

        return view('admin.commuter-feedbacks', ['commuter' => $commuter]);
    }



    // method use to view commuter complaint
    public function viewcommuterComplaint($id = null)
    {
        $commuter = User::findorfail($id);

        return view('admin.commuter-complaint', ['commuter' => $commuter]);
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
        if(Auth::guard('admin')->user()->id != 1){
            $report->viewed = 1;
        }
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

        if(Auth::guard('admin')->user()->id != 1){
            $report->viewed = 1;
        }
        $report->save();

        // assign to variables

        // generate log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Viewed Report of Commuter', now());

        // return to page with data
        return view('admin.driver-report-details', ['report' => $report]);
    }



    // method use to view ride reports
    public function viewRideReport($id = null)
    {
        $ride = Ride::findorfail($id);

        return view('admin.ride-reports', ['ride' => $ride]);
    }


    // method use to view ride feedbacks
    public function viewRideFeedback($id = null)
    {
        $ride = Ride::findorfail($id);

        return view('admin.ride-feedbacks', ['ride' => $ride]);
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
            if(Auth::guard('admin')->user()->id != 1){
                $feedback->viewed = 1;
            }
            $feedback->save();
        }

        // add log the admin viewed the feedback
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin View Feedback', now());

        // return to view
        return view('admin.view-feedback', ['feedback' => $feedback]);
    }


    // method use to view locations
    public function locations()
    {
        $locations = Location::orderBy('name', 'asc')->get();

        return view('admin.locations', ['locations' => $locations]);
    }


    // method use to add location
    public function addLocation()
    {
        return view('admin.location-add');
    }


    // method use to save location
    public function postAddLocation(Request $request)
    {
        $request->validate([
            'location' => 'required|unique:locations,name'
        ]);

        $loc = $request['location'];

        // save new location
        $location = new Location();
        $location->name = $loc;
        $location->save();


        // save to activity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Added Location', now());


        // set return response
        return redirect()->back()->with('success', 'Location Added');

    }


    // method use to update location
    public function updateLocation($id = null)
    {
        $location = Location::findorfail($id);

        return view('admin.location-update', ['location' => $location]);
    }


    // method use to save update on location
    public function postUpdateLocation(Request $request)
    {
        $loc_id = $request['location_id'];
        $location = $request['location'];

        $loc_check = Location::where('name', $location)->first();

        $loc = Location::findorfail($loc_id);

        // additional check here
        if(count($loc_check) > 0 && $loc_check->id != $loc->id) {
            return redirect()->back()->with('error', 'Location Name Already in the System');
        }

        $loc->name = $location;
        $loc->save();

        // add to activity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Updated Location', now());

        // return response
        return redirect()->route('admin.locations')->with('success', 'Location Updated!');
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
