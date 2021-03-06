<?php
Route::group(['middleware' => 'prevent-back-history'], function ()  {


	Route::get('/', 'LoginController@showWelcome')->name('welcome');

	// Registration form for commuter only
	Route::get('/registration/commuter', 'RegisterController@commuterRegistration')->name('commuter.registration');

	Route::post('/registration/commuter', 'RegisterController@postRegisterCommuter')->name('commuter.registration.post');


	Route::get('/registration/commuter/verification', 'RegisterController@verifyCommuterRegistration')->name('verify.commuter.registration');

	Route::get('/registraton/commuter/verification/code', 'RegisterController@codeVerification')->name('code.verification.registration');

	Route::get('/registration/commuter/check', 'RegisterController@checkCommuterRegistration')->name('check.commuter.registration');




	// post register for commuter only
	Route::post('/registration/commuter/submit', 'RegisterController@postCommuterRegistration')->name('register.submit');

	Route::get('/registration/commuter/submit', function () {
		return redirect()->route('commuter.registration');
	});


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


	// route to admin(guard registration)
	Route::get('/admin/registration', 'RegisterController@adminRegistration')->name('admin.registration');


	// route to post register guard(admin)
	Route::post('/admin/registration', 'RegisterController@postAdminRegistration')->name('admin.registration.post');


	// route to forgot account
	Route::get('/forgot/account', 'ForgotAccountController@forgotAccount')->name('forgot.account');

	// route to verifiy details entered/send sms code with the retrieval code 
	Route::get('/forgot/account/verify', 'ForgotAccountController@forgotAccountVerify')->name('forgot.account.verify');

	// route to continuation of forgot password of student/commuter
	Route::post('/forgot/account/commuter/verify', 'ForgotAccountController@postForgotCommuterAccountVerify')->name('forgot.commuter.account.verify.post');

	Route::get('/forgot/account/commuter/verify', function () {
		return redirect()->route('forgot.account');
	});

	// route to continuation of forgot password of driver
	Route::post('/forgot/account/driver/verify', 'ForgotAccountController@postForgotAccountDriverVerify')->name('forgot.driver.account.verify.post');

	// route to change password of the account
	Route::post('/forgot/account/change/password', 'ForgotAccountController@postForgotAccountChangePassword')->name('forgot.account.change.password');







	// route to verify sent code
	Route::get('/forgot/account/verify/code', 'ForgotAccountController@forgotAccountVerifyCode')->name('forgot.account.verify.code');

	// route to forgot admin account
	Route::get('/forgot/admin/account', 'ForgotAccountController@forgotAdminAccount')->name('forgot.admin.account');

	// route to validate and get send notification code for admin
	Route::get('/forgot/admin/account/code', 'ForgotAccountController@sendAdminCode')->name('send.code.admin');

	// route to verify code
	Route::get('/forgot/admin/verifiy/code', 'ForgotAccountController@verifyAdminCode')->name('verify.admin.code');

	// route to change password
	Route::post('/forgot/admin/account/change/password', 'ForgotAccountController@postForgotAdminChangePassword')->name('forgot.admin.change.password.post');


// end of rotue grooup middlware
});
	
Route::get('/logout', 'LoginController@logout')->name('logout');


/*
 * Commuter
 * Controller Protected Middleware auth/user, commuter middleware
 */
Route::group(['prefix' => 'c', 'middleware' => 'prevent-back-history'], function () {
	// home page of the commuter
	Route::get('/home', 'CommuterController@home')->name('commuter.home');

	// profile of the commuter
	Route::get('/profile', 'CommuterController@profile')->name('commuter.profile');

	// route to go to update profile view
	Route::get('/profile/update', 'CommuterController@updateProfile')->name('commuter.profile.update');

	// route to update profile of the user
	Route::post('/profile/update', 'CommuterController@postUpdateProfile')->name('commuter.profile.update.post');

	// route to upload image form
	Route::get('/profile/image/upload', 'CommuterController@uploadProfileImage')->name('commuter.profile.image.upload');

	// route to save uplaod image
	Route::post('/profile/image/upload', 'CommuterController@postUploadProfileImage')->name('commuter.profile.image.upload.post');

	// route to show password change for user
	Route::get('/password/change', 'CommuterController@changePassword')->name('commuter.change.password');

	// route to post  password change for user
	Route::post('/password/change', 'CommuterController@postChangePassword')->name('commuter.change.password.post');

	// route to go to notification
	Route::get('/notification', 'CommuterController@notification')->name('commuter.notification');


	// route for load part of the notification
	Route::get('/notification/new', 'GeneralController@notification')->name('commuter.notification.new');

	// route for notification count
	Route::get('/notification/new/count', 'GeneralController@notificationCount')->name('commuter.notification.new.count');

	// route to request ride for commuter
	Route::get('/ride/request', 'CommuterController@requestRide')->name('commuter.request.ride');

	// route to load modal for 
	Route::get('/ride/dropoff/prompt', 'CommuterController@rideDropoffPrompt')->name('commuter.dropoff.prompt');



	// route to submit ride request
	Route::post('/ride/request', 'CommuterController@postRequestRide')->name('commuter.request.ride.post');


	// route use to view active request ride
	Route::get('/ride/request/active', 'CommuterController@activeRideRequest')->name('commuter.active.ride.request');


	// route to cancel ride request for the commuter // accepted or not accepted
	Route::post('/ride/request/cancel', 'CommuterController@cancelRideRequest')->name('commuter.cancel.ride.request');


	// route to view ride history of the commuter
	Route::get('/ride/history', 'CommuterController@rideHistory')->name('commuter.ride.history');


	// route to send feedback
	Route::post('/ride/feedback', 'CommuterController@sendFeedback')->name('commuter.send.feedback');

	// rout to send report
	Route::post('/ride/report', 'CommuterController@submitReport')->name('commuter.submit.report');


	// route to ask commuter if the driver already pick them up
	Route::get('/ride/pickup/confirm', 'CommuterController@ridePickupConfirm')->name('commuter.ride.pickup.confirm');

	// route to confirm pickup
	Route::post('/ride/pickup/confirm', 'CommuterController@postRidePickupConfirm')->name('commuter.ride.pick.confirm.post');

	// route to confirm drop off from driver
	Route::get('/ride/dropoff/confirm', 'CommuterController@rideDropoffConfirm')->name('commuter.ride.dropoff.confirm');

	// route to accept confirmation
	Route::post('/ride/dropoff/confirm', 'CommuterController@postRideDropoffConfirm')->name('commuter.ride.dropoff.confirm.post');


	// route to create notification for current/pickup ride
	Route::get('/ride/pickup/notification/create', 'GeneralController@createPickupNotification')->name('commuter.create.pickup.notification');

	// route to create notification for drop off ride
	Route::get('/ride/dropoff/notification/create', 'GeneralController@createDropoffNotification')->name('commuter.create.dropoff.notification');
	

});


/*
 * Driver
 * Controller Protected Middleware auth/user, driver middleware
 */
Route::group(['prefix' => 'd', 'middleware' => 'prevent-back-history'], function () {
	// home page of the drivers
	Route::get('/home', 'DriverController@home')->name('driver.home');

	// route use to view profile of the driver
	Route::get('/profile', 'DriverController@profile')->name('driver.profile');


	// route use to profile update form
	Route::get('/profile/update', 'DriverController@profileUpdate')->name('driver.profile.update');

	// route use to post update profile
	Route::post('/profile/update', 'DriverController@postProfileUpdate')->name('driver.profile.update.post');

	// route to show image upload form
	Route::get('/profile/image/upload', 'DriverController@uploadProfileImage')->name('driver.profile.upload.image');


	// route to save upload image
	Route::post('/profile/image/upload', 'DriverController@postUploadProfileImage')->name('driver.profile.upload.image.post');


	// rotue use to go change password form
	Route::get('/password/change', 'DriverController@changePassword')->name('driver.change.password');


	// route use to post change password
	Route::post('/password/change', 'DriverController@postChangePassword')->name('driver.change.password.post');


	// route use to view driver notification
	Route::get('/notification', 'DriverController@notification')->name('driver.notification');


	// route use to view ride request
	Route::get('/ride/request', 'DriverController@rideRequest')->name('driver.ride.request');


	// route to show data in ride request
	Route::get('/ride/request/new', 'DriverController@rideRequestNew')->name('driver.ride.request.new');


	// route to accept ride request
	Route::post('/ride/request/accept', 'DriverController@acceptRideRequest')->name('driver.accept.ride.request');

	// route to view accepted request
	Route::get('/ride/request/accept', 'DriverController@acceptedRide')->name('driver.accepted.ride');


	// route to cancel accepted request
	Route::post('/ride/request/cancel', 'DriverController@cancelRideRequest')->name('driver.cancel.ride.request');


	// route to move to pickup status of a ride
	Route::post('/ride/request/pickup', 'DriverController@ridePickup')->name('driver.ride.pickup');


	// route to finsihed the ride
	Route::post('/ride/request/dropoff', 'DriverController@rideDropoff')->name('driver.ride.dropoff');


	// route use to view ride history of the driver
	Route::get('/ride/history', 'DriverController@rideHistory')->name('driver.ride.history');


	// route to send report 
	Route::post('/ride/report', 'DriverController@submitReport')->name('driver.submit.report');


	// route to cancel and report the commuter to admin
	Route::post('/ride/report/commuter/cancel', 'DriverController@postCancelReportCommuter')->name('driver.cancel.report.commuter.post');
});


/*
 * Admin
 * Controller Protected Middleware admin guard
 */
Route::group(['prefix' => 'admin', 'middleware' => 'prevent-back-history'], function () {
	/////////////////////////////
	// super admin route group //
	////////////////////////////
	// Route::group(['middleware' => 'super.admin'], function () {
		// route to view all registered admins
		Route::get('/admin/view/all', 'AdminController@viewAllAdmin')->name('admin.view.all.admin');

		// route to view all admin logs


		// route to view all available id for admins
		Route::get('/admin/ids', 'AdminController@viewAdminId')->name('admin.view.admin.id');

		// route to view admin logs
		Route::get('/admin/logs', 'AdminController@viewAdminLogs')->name('admin.view.admin.logs');

		// route to print all admin logs
		Route::get('/admin/logs/print', 'AdminController@printAdminLogs')->name('admin.print.admin.logs');

		// route to search admin logs
		Route::get('/admin/logs/search', 'AdminController@searchAdminLogs')->name('admin.search.admin.logs');

		// route to print search resutl
		Route::get('/admin/logs/search/{keyword}', 'AdminController@printSearchResultAdmin')->name('admin.print.search.result.admin.logs');

		// route to add admin (guard)
		Route::get('/admin/add', 'AdminController@addAdmin')->name('admin.add.admin');

		// route to save new admin
		Route::post('/admin/add', 'AdminController@postAddAdmin')->name('admin.add.admin.post');

		// route to import admins
		Route::get('/admin/import', 'AdminController@importAdmins')->name('admin.import.admins');

		// route to save import admins
		Route::post('/admin/import', 'AdminController@postImportAdmins')->name('admin.import.admins.post');

		// route to update admin (guard) detail
		Route::get('/admin/{id}/update', 'AdminController@updateAdmin')->name('admin.update.admin');

		// route to save update admin info
		Route::post('/admin/update', 'AdminController@postUpdateAdmin')->name('admin.update.admin.post');

		Route::get('/admin/update', function () {
			return abort(404);
		});

		
	// });
	////////////////////////////////////
	// end of super admin route group //
	////////////////////////////////////

	// route to go to dashboard of the admin
	Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');


	// route to view profile of the admin
	Route::get('/profile', 'AdminController@profile')->name('admin.profile');


	// route use to view profile update form
	Route::get('/profile/update', 'AdminController@profileUpdate')->name('admin.profile.update');


	// route use to post update profile
	Route::post('/profile/update', 'AdminController@postProfileUpdate')->name('admin.profile.update.post');


	// rotue to view upload image form
	Route::get('/profile/image/upload', 'AdminController@uploadProfileImage')->name('admin.profile.image.upload');


	// route to save upload image
	Route::post('/profile/image/upload', 'AdminController@postUploadProfileImage')->name('admin.profile.image.upload.post');


	// route use to view change password form
	Route::get('/password/change', 'AdminController@changePassword')->name('admin.change.password');


	// route use to post change password
	Route::post('/password/change', 'AdminController@postChangePassword')->name('admin.change.password.post');


	// view all driver
	Route::get('/driver/view/all', 'AdminController@viewAllDriver')->name('admin.view.all.driver');

	// route to add driver
	Route::get('/driver/add', 'AdminController@addDriver')->name('admin.add.driver');

	// route to save new driver
	Route::post('/driver/add', 'AdminController@postAddDriver')->name('admin.add.driver.post');

	// route to import driver 
	Route::get('/driver/import', 'AdminController@importDriver')->name('admin.import.driver');

	// route to save import driver
	Route::post('/driver/import', 'AdminController@postImportDriver')->name('admin.import.driver.post');

	// route to update driver
	Route::get('/driver/{id}/update', 'AdminController@updateDriver')->name('admin.update.driver');

	Route::post('/driver/update', 'AdminController@postUpdateDriver')->name('admin.update.driver.post');


	// route to search drivers
	Route::get('/driver/search', 'AdminController@searchDriver')->name('admin.search.driver');


	// route to view driver details
	Route::get('/driver/{id}/details', 'AdminController@viewDriverDetails')->name('admin.view.driver.details');


	// route to view driver report made
	Route::get('/driver/{id}/reports', 'AdminController@viewDriverReport')->name('admin.view.driver.report');


	// route to view driver complaint
	Route::get('/driver/{id}/complaint', 'AdminController@viewDriverComplaint')->name('admin.view.driver.complaint');


	// route to view feedback recieved by driver
	Route::get('/driver/{id}/feedback', 'AdminController@viewDriverFeedback')->name('admin.view.driver.feedback');


	// route to add student in the record by admin
	Route::get('/commuter/add', 'AdminController@addCommuter')->name('admin.add.commuter');

	// route to save student record for verification purposes
	Route::post('/commuter/add', 'AdminController@postAddCommuter')->name('admin.add.commuter.post');

	// route to import student commuters
	Route::get('/commuter/import', 'AdminController@importStudentCommuter')->name('admin.import.student.commuter');

	// route to save import student commuters
	Route::post('/commuter/import', 'AdminController@postImportStudentCommuter')->name('admin.import.student.commuter.post');

	// route to update commuter detail
	Route::get('/commuter/{id}/update', 'AdminController@upateCommuter')->name('admin.update.commuter');

	// route to save update on commuter
	Route::post('/commuter/update', 'AdminController@postUpdateCommuter')->name('admin.update.commuter.post');

	Route::get('/commuter/update', function () {
		return abort(404);
	});

	// route to view all commuters
	Route::get('/commuter/view/all', 'AdminController@viewAllCommuters')->name('admin.view.all.commuters');


	// route to search commuters
	Route::get('/commuter/search', 'AdminController@searchCommuter')->name('admin.search.commuter');


	// route to view commuter details
	Route::get('/commuter/{id}/details', 'AdminController@viewCommuterDetails')->name('admin.view.commuter.details');


	// rotue to view commuter reposts
	Route::get('/commuter/{id}/reports', 'AdminController@viewCommuterReport')->name('admin.view.commuter.report');


	// route to view commuter feedback
	Route::get('/commuter/{id}/feedbacks', 'AdminController@viewCommuterFeedback')->name('admin.view.commuter.feedback');


	// route to view commuter complaint
	Route::get('/commuter/{id}/complaint', 'AdminController@viewCommuterComplaint')->name('admin.view.commuter.complaint');


	// route to block user (commuter and driver)
	Route::post('/block/user', 'AdminController@blockUser')->name('admin.block.user');


	// route to unbloc user (commuter and driver)
	Route::post('/unblock/user', 'AdminController@unblockUser')->name('admin.unblock.user');


	// route use to view all successful rides
	Route::get('/rides/history', 'AdminController@ridesHistory')->name('admin.rides.history');


	// route use to view current Rides
	Route::get('/rides/current', 'AdminController@currentRides')->name('admin.current.rides');



	// route use to view cancelled rides
	Route::get('/rides/cancelled', 'AdminController@cancelledRides')->name('admin.cancelled.rides');


	// route use to view details of the ride
	Route::get('/ride/{id}/{ride_number}/details', 'AdminController@rideDetails')->name('admin.ride.details');


	// route use to view reports from commuters
	Route::get('/reports/commuters', 'AdminController@commutersReports')->name('admin.commuters.reports');


	// route to search commuter report
	Route::get('/reports/commuters/search', 'AdminController@searchCommuterReports')->name('admin.search.commuter.report');



	// route to view details of report of commuter
	Route::get('/report/commuter/{id}/{report_number}/view', 'AdminController@commuterReportView')->name('admin.commuter.report.view');


	// route use to view reports from drivers
	Route::get('/reports/drivers', 'AdminController@driversReports')->name('admin.drivers.reports');


	// route to search drivers reports
	Route::get('/reports/driver/search', 'AdminController@searchDriversReports')->name('admin.drivers.search.reports');


	// route to view driver report details
	Route::get('/report/{id}/{report_number}/view', 'AdminController@driverReportView')->name('admin.driver.report.view');



	// route to view all report related to the ride
	Route::get('/ride/{id}/reports', 'AdminController@viewRideReport')->name('admin.view.ride.report');



	// route use to view feedback for the rreports
	Route::get('/ride/{id}/feedbacks', 'AdminController@viewRideFeedback')->name('admin.view.ride.feedback');


	// route to view feedbacks
	Route::get('/feedbacks', 'AdminController@viewFeedbacks')->name('admin.view.feedbacks');


	// route to view individual details of feedback
	Route::get('/feedback/{id}/{feedback_number}', 'AdminController@viewFeedbackDetails')->name('admin.view.feedback.details');


	// route to view location management
	// Route::get('/locations', 'AdminController@locations')->name('admin.locations');


	// route to add location
	// Route::get('/location/add', 'AdminController@addLocation')->name('admin.add.location');

	// route to save location
	// Route::post('/location/add', 'AdminController@postAddLocation')->name('admin.add.location.post');


	// route to update location
	// Route::get('/location/{id}/update', 'AdminController@updateLocation')->name('admin.update.location');


	// route to save update location
	// Route::post('/location/upadte', 'AdminController@postUpdateLocation')->name('admin.update.location.post');

	Route::get('/location/upadte', function () {
		return abort(404);
	});


	// route to go to activity log of the admin
	Route::get('/activity-log', 'AdminController@activityLog')->name('admin.activity.log');


	// route to print activity log
	Route::get('/activity-log-print', 'AdminController@printActivityLog')->name('admin.print.activity.log');

	// route to search activity log
	Route::get('/activity-log/search', 'AdminController@searchActivityLog')->name('admin.search.activity.log');

	// route to print activity log in search result
	Route::get('/activity-log-print/search/{keyword}', 'AdminController@printSearchActivityLog')->name('admin.print.search.activity.log');

	// route to view analytics usage of the app
	Route::get('/usage/statistics', 'AdminController@usageAnalytics')->name('admin.usage.statistics');
});

