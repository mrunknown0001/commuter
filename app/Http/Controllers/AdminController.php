<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function __construct()
    {
    	// only admin can access
    	$this->middleware('auth:admin');
    }



    // admin dashboard
    public function dashboard()
    {
    	return view('admin.dashboard');
    }
}
