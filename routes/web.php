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

	// route to go to update profile view
	Route::get('/profile/update', 'CommuterController@updateProfile')->name('commuter.profile.update');

	// route to update profile of the user
	Route::post('/profile/update', 'CommuterController@postUpdateProfile')->name('commuter.profile.update.post');

	// route to show password change for user
	Route::get('/password/change', 'CommuterController@changePassword')->name('commuter.change.password');

	// route to post  password change for user
	Route::post('/password/change', 'CommuterController@postChangePassword')->name('commuter.change.password.post');


	// route to go to notification
	Route::get('/notification', 'CommuterController@notification')->name('commuter.notification');

	// route to request ride for commuter
	Route::get('/ride/request', 'CommuterController@requestRide')->name('commuter.request.ride');


	// route to submit ride request
	Route::post('/ride/request', 'CommuterController@postRequestRide')->name('commuter.request.ride.post');


	// route use to view active request ride
	Route::get('/ride/request/active', 'CommuterController@activeRideRequest')->name('commuter.active.ride.request');

	// route to view ride history of the commuter
	Route::get('/ride/history', 'CommuterController@rideHistory')->name('commuter.ride.history');

});


/*
 * Driver
 * Controller Protected Middleware auth/user, driver middleware
 */
Route::group(['prefix' => 'd'], function () {
	// home page of the drivers
	Route::get('/home', 'DriverController@home')->name('driver.home');

	// route use to view profile of the driver
	Route::get('/profile', 'DriverController@profile')->name('driver.profile');


	// route use to profile update form
	Route::get('/profile/update', 'DriverController@profileUpdate')->name('driver.profile.update');

	// route use to post update profile
	Route::post('/profile/update', 'DriverController@postProfileUpdate')->name('driver.profile.update.post');


	// rotue use to go change password form
	Route::get('/password/change', 'DriverController@changePassword')->name('driver.change.password');


	// route use to post change password
	Route::post('/password/change', 'DriverController@postChangePassword')->name('driver.change.password.post');


	// route use to view driver notification
	Route::get('/notification', 'DriverController@notification')->name('driver.notification');


	// route use to view ride request
	Route::get('/ride/request', 'DriverController@rideRequest')->name('driver.ride.request');


	// route use to view ride history of the driver
	Route::get('/ride/history', 'DriverController@rideHistory')->name('driver.ride.history');
});


/*
 * Admin
 * Controller Protected Middleware admin guard
 */
Route::group(['prefix' => 'admin'], function () {
	// route to go to dashboard of the admin
	Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');


	// route to view profile of the admin
	Route::get('/profile', 'AdminController@profile')->name('admin.profile');


	// route use to view profile update form
	Route::get('/profile/update', 'AdminController@profileUpdate')->name('admin.profile.update');


	// route use to post update profile
	Route::post('/profile/update', 'AdminController@postProfileUpdate')->name('admin.profile.update.post');


	// route use to view change password form
	Route::get('/password/change', 'AdminController@changePassword')->name('admin.change.password');


	// route use to post change password
	Route::post('/password/change', 'AdminController@postChangePassword')->name('admin.change.password.post');


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