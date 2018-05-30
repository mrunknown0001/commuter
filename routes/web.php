<?php

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/logout', function () {
	Auth::logout();
	return redirect()->route('welcome');
});

// Commter and Diver Login Page
Route::get('/login', 'LoginController@showLogin')->name('login');


// post login for commuter and driver
Route::post('/login', 'LoginController@postLogin')->name('login.post');