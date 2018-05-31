<?php

Route::get('/', 'LoginController@showWelcome')->name('welcome');


Route::get('/logout', function () {
	Auth::logout();
	return redirect()->route('welcome');
})->name('logout');


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
 */
Route::group(['prefix' => 'admin'], function () {
	// route to go to dashboard of the admin
	Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
});