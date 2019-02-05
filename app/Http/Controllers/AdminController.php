<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Cache;
use Excel;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use DB;

use App\Http\Controllers\GeneralController;

use App\ActivityLog;
use App\User;
use App\Admin;
use App\Ride;
use App\AdminId;
use App\Feedback;
use App\Avatar;
use App\DriverInfo;
use App\Location;
use App\DriverStatus;

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
        $admins = Admin::where('id', '!=', 1)
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


    // method use to print all activity of admins
    public function printAdminLogs()
    {
        // admin logs
        $logs = ActivityLog::where('user_id', null)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.admin-logs-print', ['logs' => $logs]);
    }


    // method use to search admin logs
    public function searchAdminLogs(Request $request)
    {
        $keyword = $request['keyword'];

        $admins = DB::table('admins')
                    ->join('activity_logs', 'admins.id', '=', 'activity_logs.admin_id')
                    ->where('first_name', "like", "%$keyword%")
                    ->orwhere('last_name', "like", "%$keyword%")
                    ->orwhere('identification', "like", "%$keyword%")
                    ->orderBy('last_name', 'asc')
                    ->paginate(15);

        return view('admin.admin-log-search-result', ['admins' => $admins, 'keyword' => $keyword]);
    }


    // method use to print admin search result
    public function printSearchResultAdmin($keyword = null)
    {
        $admins = DB::table('admins')
                    ->join('activity_logs', 'admins.id', '=', 'activity_logs.admin_id')
                    ->where('first_name', "like", "%$keyword%")
                    ->orwhere('last_name', "like", "%$keyword%")
                    ->orwhere('identification', "like", "%$keyword%")
                    ->orderBy('last_name', 'asc')
                    ->get();

        return view('admin.admin-logs-search-result-print', ['logs' => $admins]);
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
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'username' => 'required|unique:admins,username',
            'mobile_number' => 'required|unique:admins|numeric|digits:11'
        ]);

        $fn = $request['first_name'];
        $ln = $request['last_name'];
        $username = $request['username'];
        $mobile = $request['mobile_number'];

        // save new admin, the defaul password is password
        $admin = new Admin();
        $admin->first_name = $fn;
        $admin->last_name = $ln;
        $admin->username = $username;
        $admin->mobile_number = $mobile;
        $admin->password = bcrypt('password');
        $admin->save();

        $photoname = null;

        if($request->image) {

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

        }




        // activity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Added new Admin Guard', now());


        // return with success
        return redirect()->route('admin.view.all.admin')->with('succes', 'Admin Added. Default password: password');
    }


    // method use to import admins
    public function importAdmins()
    {
        return view('admin.admin-import-record');
    }


    // method use to save import admins
    public function postImportAdmins(Request $request)
    {
        if(Input::hasFile('admins')){
            $path = Input::file('admins')->getRealPath();
            $data[] = Excel::selectSheetsByIndex(0)->load($path, function($reader) {
                    // $reader->get();
                    // $reader->skipColumns(1);
                })->get();
        }
        else {
            return redirect()->back()->with('error', 'Error! Please Try Again! No file found!');
        }


        $admins = [];

        foreach ($data as $value) {
            
            foreach ($value as $row) {
                if($row->username != null) {

                    // check each student number if it is already in database
                    $check_username = Admin::where('username', $row->username)->first();

                    if(!$row->username) {
                        return redirect()->back()->with('error', 'Error Occurred! Please Use Excel for Importing Commuter');
                    }


                    // check if firstname & lastname has numbers on it



                    if(!empty($check_username)) {
                        return redirect()->back()->with('error', 'Admin Exist! Please Remove Admin with Username: ' . $row->username . ' - ' . ucwords($row->firstname . ' ' . $row->lastname));
                    }
                    else {
                        // for users table
                        $admins[] = [
                                'username' => $row->username,
                                'last_name' => $row->lastname,
                                'first_name' => $row->firstname,
                                'mobile_number' => $row->mobile_number,
                                'password' => bcrypt('password')
                            ];

                    }

                }
            }
            
        }

        // insert in users and student_infos tables
        if(!empty($admins)) {
            // insert data to users
            DB::table('admins')->insert($admins);

            GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Super Admin Imported Admins');

            return redirect()->route('admin.view.all.admin')->with('success', 'Imported Admins');
        }


        return redirect()->route('admin.view.all.admin')->with('error', 'Error Occurred! Please Try Again Later!');

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
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u',
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

        $arrived = DriverStatus::where('status', 'Arrived')->orderBy('updated_at', 'asc')->limit(5)->get();
        $otw = DriverStatus::where('status', 'OTW')->orderBy('updated_at', 'asc')->limit(5)->get();
        $loading = DriverStatus::where('status', 'Loading')->orderBy('updated_at', 'asc')->limit(5)->get();

    	return view('admin.dashboard', ['rides' => $rides, 'commuters' => $commuters, 'drivers' => $drivers, 'current_rides' => $current_rides, 'arrived' => $arrived, 'otw' => $otw, 'loading' => $loading]);
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
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u',
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
        if(empty($avatar)) {
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
            'password' => 'required|min:8|confirmed|max:50'
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
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'username' => 'required|unique:users,username',
            'mobile_number' => 'required|unique:users|numeric|digits:11',
            'body_number' => 'required|min:5|max:10|unique:driver_infos',
            'plate_number' => 'required|unique:driver_infos|min:5|max:12'
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
        $driver->username = $username;
        $driver->mobile_number = $mobile;
        $driver->password = bcrypt('password');
        $driver->user_type = 2;
        $driver->active = 1;
        $driver->registered = 1;
        $driver->save();

        $photoname = null;

        if($request->image) {

            $photoname = time().'.'.$request->image->getClientOriginalExtension();
            /*
            talk the select file and move it public directory and make avatars
            folder if doesn't exsit then give it that unique name.
            */
            $request->image->move(public_path('uploads/images'), $photoname);

        }

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

        // add driver status
        $ds = new DriverStatus();
        $ds->driver_id = $driver->id;
        $ds->save();

        // add to activity log
        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Added New Driver', now());

        // add to return message
        return redirect()->back()->with('success', 'New Driver Added!');

    }


    // method use to import driver
    public function importDriver()
    {
        return view('admin.driver-import-record');
    }


    // method use to save import driver
    public function postImportDriver(Request $request)
    {
        if(Input::hasFile('drivers')){
            $path = Input::file('drivers')->getRealPath();
            $data[] = Excel::selectSheetsByIndex(0)->load($path, function($reader) {
                    // $reader->get();
                    // $reader->skipColumns(1);
                })->get();
        }
        else {
            return redirect()->back()->with('error', 'Error! Please Try Again! No file found!');
        }

        $drivers = [];
        $info = [];
        $status = [];

        $last_driver = DriverInfo::orderBy('id', 'desc')->first(['id']);
        if(!empty($last_driver)) {
            $ref_id = $last_driver->id + 1;
        }
        else {
            $ref_id = 1;
        }

        foreach ($data as $value) {
            
            foreach ($value as $row) {
                if($row->username != null) {

                    // check each student number if it is already in database
                    $check_username = User::where('username', $row->username)->first();

                    if(!$row->username) {
                        return redirect()->back()->with('error', 'Error Occurred! Please Use Excel for Importing Commuter');
                    }


                    if(!empty($check_username)) {
                        return redirect()->back()->with('error', 'Driver Exist! Please Remove Driver with Username: ' . $row->username . ' - ' . ucwords($row->firstname . ' ' . $row->lastname));
                    }
                    else {
                        // for users table
                        $drivers[] = [
                                'username' => $row->username,
                                'last_name' => $row->lastname,
                                'first_name' => $row->firstname,
                                'user_type' => 2,
                                'mobile_number' => $row->mobile_number,
                                'password' => bcrypt('password'),
                                'active' => 1
                            ];

                        $info[] = [
                            'driver_id' => $ref_id,
                            'body_number' => $row->body_number,
                            'plate_number' => $row->plate_number,
                            'license' => $row->license_number,
                            'operator_name' => $row->operator
                        ];

                        $status[] = [
                            'driver_id' => $ref_id
                        ];
                    }


                }

                $ref_id += 1;
            }
            
        }

        // insert in users and student_infos tables
        if(!empty($drivers)) {
            // insert data to users
            DB::table('users')->insert($drivers);

            DB::table('driver_infos')->insert($info);

            // add to driver_status
            DB::table('driver_statuses')->insert($status);

            GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Imported Drivers');

            return redirect()->route('admin.view.all.driver')->with('success', 'Imported Drivers');
        }


        return redirect()->back()->with('error', 'Error Occurred! Please Try Again Later!');
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
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'mobile_number' => 'required|numeric|digits:11',
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
        $driver->username = $username;
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
    // public function viewDriverReport($id = null)
    // {
    //     $driver = User::findorfail($id);

    //     return view('admin.driver-reports', ['driver' => $driver]);
    // }



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
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'student_number' => 'required|unique:users,student_number'
        ]);

        $fn = $request['first_name'];
        $ln = $request['last_name'];
        $id = $request['student_number'];

        $new = new User();
        $new->first_name = $fn;
        $new->last_name = $ln;
        $new->student_number = $id;
        $new->save();

        GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Added New Commuter');

        return redirect()->back()->with('success', 'Success! Commuter Added!');
    }


    // method use to import stduent commuter 
    public function importStudentCommuter()
    {
        return view('admin.commuter-import-record');
    }


    // method use to save imported student commuter
    public function postImportStudentCommuter(Request $request)
    {

        if(Input::hasFile('commuters')){
            $path = Input::file('commuters')->getRealPath();
            $data[] = Excel::selectSheetsByIndex(0)->load($path, function($reader) {
                    // $reader->get();
                    // $reader->skipColumns(1);
                })->get();
        }
        else {
            return redirect()->back()->with('error', 'Error! Please Try Again! No file found!');
        }

        $commuters = [];

        foreach ($data as $value) {
            
            foreach ($value as $row) {
                if($row->student_number != null) {

                    // check each student number if it is already in database
                    $check_student_number = User::where('student_number', $row->student_number)->first();

                    if(!$row->student_number) {
                        return redirect()->back()->with('error', 'Error Occurred! Please Use Excel for Importing Commuter');
                    }


                    if(!empty($check_student_number)) {
                        return redirect()->back()->with('error', 'Student Exist! Please Remove Student with Student Number: ' . $row->student_number . ' - ' . ucwords($row->firstname . ' ' . $row->lastname));
                    }
                    else {
                        // for users table
                        $commuters[] = [
                                'student_number' => $row->student_number,
                                'last_name' => $row->lastname,
                                'first_name' => $row->firstname
                            ];
                    }


                }

            }
            
        }


        // insert in users and student_infos tables
        if(!empty($commuters)) {
            // insert data to users
            DB::table('users')->insert($commuters);

            GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Imported Student Commuter');

            return redirect()->route('admin.view.all.commuters')->with('success', 'Imported Commuter');
        }


        return redirect()->back()->with('error', 'Error Occurred! Please Try Again Later!');


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
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'student_number' => 'required'
        ]);

        $fn = $request['first_name'];
        $ln = $request['last_name'];
        $id = $request['student_number'];
        $commuter_id = $request['commuter_id'];

        $commuter = User::findorfail($commuter_id);

        // check id
        $check_id = User::where('student_number', $id)->first();

        if(!empty($check_id) && $check_id->id != $commuter->id) {
            return redirect()->back()->with('error', 'Student Number already exists!');
        }

        $commuter->first_name = $fn;
        $commuter->last_name = $ln;
        $commuter->student_number = $id;
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
    // public function viewCommuterReport($id = null)
    // {
    //     $commuter = User::findorfail($id);

    //     return view('admin.commuter-reports', ['commuter' => $commuter]);
    // }



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
    // public function commutersReports()
    // {
    //     // get all commuters report
    //     // user type == 1
        
    //     $reports = Report::where('user_type', 1)
    //                     ->orderBy('created_at', 'desc')
    //                     ->paginate(15);

    //     return view('admin.commuters-reports', ['reports' => $reports]);
    // }



    // method use to search commuter reports
    // public function searchCommuterReports(Request $request)
    // {
    //     $keyword = $request['keyword'];

    //     $users = User::where('first_name', "like", "%$keyword%")
    //         ->orwhere('last_name', "like", "%$keyword%")
    //         ->orwhere('identification', "like", "%$keyword%")
    //         ->orderBy('last_name', 'asc')
    //         ->paginate(15);

    //     return view('admin.commuters-reports-search-result', ['users' => $users, 'keyword' => $keyword]);
    // }



    // // method use to view commuter report details
    // public function commuterReportView($id = null, $report_number = null)
    // {
    //     // validate
    //     $report = Report::findorfail($id);
    //     if(Auth::guard('admin')->user()->id != 1){
    //         $report->viewed = 1;
    //     }
    //     $report->save();

    //     // assign to variables

    //     // generate log
    //     GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Viewed Report of Commuter', now());

    //     // return to page with data
    //     return view('admin.commuter-report-details', ['report' => $report]);
    // }



    // // method use to view drivers reports
    // public function driversReports()
    // {
    //     // get all driver report
    //     // user type == 2
    //     $reports = Report::where('user_type', 2)
    //                     ->orderBy('created_at', 'desc')
    //                     ->paginate(15);

    //     return view('admin.drivers-reports', ['reports' => $reports]);
    // }


    // // method use to search driver reports
    // public function searchDriversReports(Request $request)
    // {
    //     $keyword = $request['keyword'];

    //     $users = User::where('first_name', "like", "%$keyword%")
    //         ->orwhere('last_name', "like", "%$keyword%")
    //         ->orwhere('identification', "like", "%$keyword%")
    //         ->orderBy('last_name', 'asc')
    //         ->paginate(15);

    //     return view('admin.drivers-reports-search-result', ['users' => $users, 'keyword' => $keyword]);
    // }



    // // method use to view driver report detils
    // public function driverReportView($id = null, $report_number = null)
    // {
    //     // validate
    //     $report = Report::findorfail($id);


    //     // check the report number belongs to the report
    //     if($report->report_number != $report_number) {
    //         return redirect()->back();
    //     }

    //     if(Auth::guard('admin')->user()->id != 1){
    //         $report->viewed = 1;
    //     }
    //     $report->save();

    //     // assign to variables

    //     // generate log
    //     GeneralController::activity_log(null, Auth::guard('admin')->user()->id, 'Admin Viewed Report of Commuter', now());

    //     // return to page with data
    //     return view('admin.driver-report-details', ['report' => $report]);
    // }



    // // method use to view ride reports
    // public function viewRideReport($id = null)
    // {
    //     $ride = Ride::findorfail($id);

    //     return view('admin.ride-reports', ['ride' => $ride]);
    // }


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


    public function printActivityLog()
    {
        $logs = ActivityLog::where('admin_id', null)
                        ->orderBy('performed_on', 'desc')
                        ->paginate(15);

        return view('admin.activity-logs-print', ['logs' => $logs]);
    }


    // method use to search activity log
    public function searchActivityLog(Request $request)
    {
        $keyword = $request['q']; 

        // search user
        $users = DB::table('users')
            ->join('activity_logs', 'users.id', '=', 'activity_logs.user_id')
            ->where('first_name', "like", "%$keyword%")
            ->orwhere('last_name', "like", "%$keyword%")
            ->orwhere('identification', "like", "%$keyword%")
            ->orderBy('last_name', 'asc')
            ->paginate(15);


        // return to view
        return view('admin.activity-log-search-result', ['logs' => $users, 'keyword' => $keyword]);
    }


    // method use to print activity log in search result
    public function printSearchActivityLog($keyword = null)
    {
        // search user
        $users = DB::table('users')
            ->join('activity_logs', 'users.id', '=', 'activity_logs.user_id')
            ->where('first_name', "like", "%$keyword%")
            ->orwhere('last_name', "like", "%$keyword%")
            ->orwhere('identification', "like", "%$keyword%")
            ->orderBy('last_name', 'asc')
            ->paginate(15);

        return view('admin.activity-logs-print-search', ['logs' => $users]);
    }
}
