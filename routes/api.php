<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });




//-------------------------- Api For Both Driver And Customer-------------------------------
//phone Verification
Route::post('phoneVerification','Api\SignUpController@phoneVerification');
Route::post('logout','Api\LoginController@logout');
//update Imei Number
Route::post('imeiNumberUpdate','Api\SignUpController@imeiNumberUpdate');
//Notificcation 
Route::post('sendNotification','Api\NotificationController@sendNotification');





//----------------------For Customer------------------------

//UserLogin
Route::post('passengerLogin','Api\LoginController@userLogin');
//Registration of a Customer
Route::post('registerPassenger','Api\SignUpController@registerCustomer');
//Existed Booking of Customer with status //2:confirm //3:start //6:on the way
Route::post('checkBooking','Api\BookingController@checkExistedBooking');
//Create Booking for Customer
Route::post('createBooking','Api\BookingController@createBooking');
//Customer can Cancel the Request 
Route::post('cancelRequest','Api\BookingController@cancelRequest');
//Customer can Pre Cancel the Request 
Route::post('preCancel','Api\BookingController@preCancel');
//update Passenger Users details 
Route::post('updatePassengerProfile','Api\PassengerController@updateProfile');
//update Passenger Driver Details
Route::post('updatePassengerDetail','Api\PassengerController@updatePassengerDetails');
//Update passenger Image
Route::post('updatePassengerImage','Api\PassengerController@updateProfileImage');
//Previous Bookings
Route::post('previousBookingsPassenger','Api\PassengerController@previousBookings');
//Cancel Bookings
Route::post('cancelBookingsPassenger','Api\PassengerController@cancelBookings');
//Driver Rating
Route::post('passengerRating','Api\PassengerController@passengerRating');
//Get Passenger Wallet
Route::post('passengerWallet','Api\PassengerController@getWallet');






//-----------------------For Driver-------------------------------

//Driver Login
Route::post('driverLogin','Api\LoginController@driverLogin');
//Registration
Route::post('registeredDriver','Api\SignUpController@DriverRegistration');
//driver login Status 
Route::post('updateLoginStatus','Api\DriverController@updateDriverOnlineStatus');
//near by Drivers
Route::post('nearByDrivers','Api\DriverController@nearByDrivers');
//update Driver Profile for User
Route::post('updateDriverProfile','Api\DriverController@updateProfile');
//update Driver Profile for driverDetails
Route::post('updateDriverDetail','Api\DriverController@updateDriverDetails');
//update Driver Profile Image
Route::post('updateDriverImage','Api\DriverController@updateProfileImage');
//booking Notify to driver
Route::post('bookingNotification','Api\BookingController@bookingNotificationToDriver');
//Check Accepted Booking already Exists or Not
Route::post('bookingCheckDriver','Api\DriverController@checkAcceptedBooking');
//Accept Passenger Booking
Route::post('acceptPassenger','Api\BookingController@acceptPassengerBooking');
//update Arrived Status by Driver of Booking
Route::post('updateBooking','Api\DriverController@updateBookingStatus');
//End Trip
Route::post('endTrip','Api\DriverController@endTrip');
//Previous Complete booking of Driver
Route::post('previousBookingsDriver','Api\DriverController@previousBookings');
//Cancel Bookings
Route::post('cancelBookingsDriver','Api\DriverController@cancelBookings');
//Driver Rating
Route::post('driverRating','Api\DriverController@driverRating');
//get Driver Wallet
Route::post('driverWallet','Api\DriverController@getWallet');











Route::post('check','Api\SignUpController@check');



//--------------------------For Vehicle-----------------------
Route::post('registerVehicle','Api\SignUpController@vehicleRegistration');
//get Car list the Cars Types we have in DB
Route::get('carTypes','Api\VehicleController@getCarList');
//get Vehicle CarBrands
Route::post('getVehicleBrands','Api\VehicleController@getVehicleBrands')->name('VehicleBrands');



//Accounting Part
Route::post('confirmPayment','Api\AccountController@confirmPayment');






//Version control 
Route::post('versionCheck','Api\VersionController@versionCheck');
//Version update
Route::post('versionUpdate','Api\VersionController@versionUpdate');


//For panel
Route::get('getAllDrivers','Api\DriverController@allDrivers');