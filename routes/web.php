<?php

Route::view('/', 'welcome')->name('welcome');


Route::get('/logout', function () {
	Auth::logout();
	return redirect()->route('welcome');
})->name('logout');


// Registration form for commuter only
Route::get('/register', 'RegisterController@showRegistration')->name('register');

Route::post('/register', 'RegisterController@postRegistration')->name('register.submit');


// Commuter and Diver Login Page
Route::get('/login', 'LoginController@showLogin')->name('login');


// post login for commuter and driver
Route::post('/login', 'LoginController@postLogin')->name('login.submit');