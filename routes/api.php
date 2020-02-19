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

Route::post('/login','AdminController@login')->name('Admin.login');



//-------------------------- Api For Both Driver And Customer-------------------------------
//phone Verification
Route::post('phoneVerification','Api\SignUpController@phoneVerification');
Route::post('logout','Api\LoginController@logout');
//update Imei Number
Route::post('imeiNumberUpdate','Api\SignUpController@imeiNumberUpdate');
//Notificcation 
Route::post('sendNotification','Api\NotificationController@sendNotification');
Route::post('sendNotificationiOS','Api\NotificationController@sendNotificationiOS');

//ForgetPassword
Route::post('changePassword','Api\LoginController@changePassword');
Route::post('forgetPassword','Api\LoginController@forgetPassword');

//LoginCheck
Route::post('loginCheck','Api\LoginController@LoginCheck');

//----------------------------For Customer----------------------------




//UserLogin
Route::post('passengerLogin','Api\LoginController@userLogin');
Route::post('passengerLoginIos','Api\LoginController@iosUserLogin');
//Registration of a Customer
Route::post('registerPassenger','Api\SignUpController@registerCustomer');
//Existed Booking of Customer with status //2:confirm //3:start //6:on the way
Route::post('checkBooking','Api\BookingController@checkExistedBooking');
//Create Booking for Customer
Route::post('createBooking','Api\BookingController@createBooking');
//get Driver Details of Booking 
Route::post('getDriversDetails','Api\BookingController@getDriversDetails');
//Customer can Cancel the Request 
Route::post('cancelRequest','Api\BookingController@cancelRequest');
//Customer can Pre Cancel the Request 
Route::post('preCancel','Api\BookingController@notAccepted');
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
Route::post('driverLoginIos','Api\LoginController@iosDriverLogin');
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
//get NAtionalities
Route::get('/getNationalities','NationalityController@getAllNationality');
//Get Car Companies
Route::get('carCompanies','Api\VehicleController@carCompanies');
// Get Car Brands
Route::get('carBrands','Api\VehicleController@carBrands');
// Get Company brands
Route::post('getCompanyBrands','Api\VehicleController@getCarBrandsbyCompany');
//Get just ProgressBooking Driver
Route::post('getBooking','Api\BookingController@getBooking');
//Get Booking Details for Panel
Route::get('getBookingDetails/{bookingId}','Api\BookingController@getBookingDetails');
//get driver data
Route::get('getdriverData/{userId}','Api\DriverController@getDriverDetail');






Route::post('check','Api\SignUpController@check');



//--------------------------For Vehicle-----------------------
Route::post('registerVehicle','Api\SignUpController@vehicleRegistration');
//get Car list the Cars Types we have in DB
Route::get('carTypes','Api\VehicleController@getCarList');
//get Vehicle CarBrands
Route::post('getVehicleBrands','Api\VehicleController@getVehicleBrands')->name('VehicleBrands');
//get Distance
Route::get('getdistance','Api\BookingController@getdistance');

//Accounting Part
Route::post('confirmPayment','Api\AccountController@confirmPayment');





//Version control 
Route::post('versionCheck','Api\VersionController@versionCheck');
//Version update
Route::post('versionUpdate','Api\VersionController@versionUpdate');


















//Api's For DashBoard Muhrah
Route::get('getAllDrivers','Api\DriverController@allDrivers');
//Passengers
Route::post('/R_passenger_totalPassengers','DashboardApi\PassengerController@getTotalPassengers');
Route::post('R_passenger_bookings','DashboardApi\PassengerController@getPassengerBooking')->name('Passenger.Bookings');
Route::post('R_passenger_wallets','DashboardApi\PassengerController@getPassengersWallet')->name('Passenger.Wallets');
Route::post('R_passenger_Raitings','DashboardApi\PassengerController@getPassengerRaiting')->name('Passenger.Raiting');



//Driver 
Route::post('R_drivers_driversWithStatus','DashboardApi\DriverController@getDriverOnStatus')->name('Driver.driversWithStatus');
Route::post('R_drivers_driversWithCars','DashboardApi\DriverController@getDriverOnCars')->name('Driver.driversWithCars');
Route::post('R_drivers_bookings','DashboardApi\DriverController@getDriverBookings')->name('Driver.Bookings');
Route::post('R_drivers_driverRaitings','DashboardApi\DriverController@raitingsAndReviews')->name('Driver.raiting');
Route::post('R_drivers_registeredToday','DashboardApi\DriverController@dailyRegisteredDrivers')->name('Registered.Today');


//Booking
Route::post('R_bookings_InProgress','DashboardApi\BookingController@bookingsInProgress')->name('Booking.InProgress');
//broadCasting
Route::post('R_bookings_bookings','DashboardApi\BookingController@bookings')->name('Booking.broadCasting');
