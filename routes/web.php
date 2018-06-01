<?php

Route::get('/', 'LoginController@showWelcome')->name('welcome');


Route::get('/logout', 'LoginController@logout')->name('logout');


// Registration form for commuter only
Route::get('/register', 'RegisterController@showRegistration')->name('register');

// post register for commuter only
Route::post('/register', 'RegisterController@postRegistration')->name('register.submit');


// Commuter and Diver Login Page
Route::get('/login', 'LoginController@showLogin')->name('login');


// post login for commuter and driver
Route::post('/login', 'LoginController@postLogin')->name('login.submit');


// admin login redirect to login page and url
Route::get('/admin', function () {
	return redirect()->route('admin.login');
});

// admin login form
Route::get('/admin/login', 'AdminLoginController@showAdminLoginForm')->name('admin.login');

// post admin login form
Route::post('/admin/login', 'AdminLoginController@postAdminLogin')->name('admin.login.submit');


/*
 * Commuter
 * Controller Protected Middleware auth/user, commuter middleware
 */
Route::group(['prefix' => 'c'], function () {
	// home page of the commuter
	Route::get('/home', 'CommuterController@home')->name('commuter.home');

	// profile of the commuter
	Route::get('/profile', 'CommuterController@profile')->name('commuter.profile');

});


/*
 * Driver
 * Controller Protected Middleware auth/user, driver middleware
 */
Route::group(['prefix' => 'd'], function () {
	// home page of the drivers
	Route::get('/home', 'DriverController@home')->name('driver.home');
});


/*
 * Admin
 * Controller Protected Middleware admin guard
 */
Route::group(['prefix' => 'admin'], function () {
	// route to go to dashboard of the admin
	Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');


	// route to view profile of the admin
	Route::get('/profile/{username}', 'AdminController@profile')->name('admin.profile');


	Route::group(['prefix' => 'driver'], function () {
		// add driver form
		Route::get('/register', 'AdminController@registerDriver')->name('admin.register.driver');

		// post add driver
		Route::post('/register', 'AdminController@postRegisterDriver')->name('admin.post.register.driver');

		// view all driver
		Route::get('/view/all', 'AdminController@viewAllDriver')->name('admin.view.all.driver');
	});


	Route::group(['prefix' => 'commuter'], function () {
		// route to view all commuters
		Route::get('/view/all', 'AdminController@viewAllCommuters')->name('admin.view.all.commuters');
	});


	// route use to view all successful rides
	Route::get('/rides/history', 'AdminController@ridesHistory')->name('admin.rides.history');


	// route use to view reports from commuters
	Route::get('/reports/commuters', 'AdminController@commutersReports')->name('admin.commuters.reports');


	// route use to view reports from drivers
	Route::get('/reports/drivers', 'AdminController@driversReports')->name('admin.drivers.reports');


	// route to view feedbacks
	Route::get('/feedbacks', 'AdminController@viewFeedbacks')->name('admin.view.feedbacks');


	// route to go to activity log of the admin
	Route::get('/activity-log', 'AdminController@activityLog')->name('admin.activity.log');
});