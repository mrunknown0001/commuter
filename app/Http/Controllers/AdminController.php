<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\GeneralController;
use App\ActivityLog;

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


    // admin add driver method, show the add driver form
    public function registerDriver()
    {
        return view('admin.register-driver');
    }


    // admin activity log
    public function activityLog()
    {
        $logs = ActivityLog::orderBy('performed_on', 'desc')->paginate(15);

        return view('admin.activity-log', ['logs' => $logs]);
    }
}
