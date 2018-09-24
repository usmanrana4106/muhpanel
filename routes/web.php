<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('loginSignup.login');
// });


//Admin Part
Route::get('/','AdminController@loginView');
Route::post('/login','AdminController@login')->name('Admin.login');
Route::get('/logout','AdminController@logout')->name('Admin.logout');
Route::get('adminDetails','AdminController@adminDetails')->name('Admin.details');
Route::get('registerAdmin','AdminController@registerAdmin_view')->name('Admin.create');
Route::post('registerAdmin','AdminController@registerAdmin')->name('Admin.register');
Route::get('deleteAdmin/{id}','AdminController@deleteAdmin')->name('Admin.delete');
Route::get('editAdmin/{id}','AdminController@editAdmin_view')->name('Admin.edit');
Route::post('editAdmin','AdminController@editAdmin')->name('Admin.edit');




//Home Page
Route::get('home','HomeController@home')->name('Home')->middleware('checkPost');
//Tracking
Route::get('tracking','HomeController@tracking')->name('Tracking')->middleware('checkPost');
//Search User or Driver By ID
Route::post('search','HomeController@searchUser')->name('Home.search')->middleware('checkPost');






//Bookings
Route::get('bookings','BookingController@AllBooking')->name('Booking.AllBooking')->middleware('checkPost');
//Today Bookings
Route::get('dailyBookings','BookingController@DailyBookings')->name('Booking.DailyBooking')->middleware('checkPost');
//Monthly Bookings
Route::get('monthlyBookings','BookingController@MonthlyBookings')->name('Booking.MonthlyBooking')->middleware('checkPost');
//Bookings On Date View
Route::get('dateBookings','BookingController@BookingsOnDate_view')->name('Booking.DateBooking')->middleware('checkPost');
//Bookings On Date 
Route::post('dateBookings','BookingController@BookingsOnDate')->name('Booking.DateBooking')->middleware('checkPost');
//Booking with stats //New: Start: End: Complete: Driver Not Found: Cancel 
Route::get('bookingStatus/{rideStatus}','BookingController@BookingWithStatus')->name('Booking.Status')->middleware('checkPost');
//Booking Status main View
Route::get('statusBooking','BookingController@getTypesOfBooking')->name('Booking.StatusView')->middleware('checkPost');
//Booking Details
Route::get('bookingDetails/{bookingId}','BookingController@BookingDetails')->name('Booking.Details')->middleware('checkPost');




//Passanger Part
Route::get('passanger','PassengerController@getPassengers')->name('Passanger')->middleware('checkPost');
Route::get('passengerProfile/{userId}','PassengerController@passengerProfile')->name('Passanger.Profile')->middleware('checkPost');
//Passenger Wallets
Route::get('passengerWallets','PassengerController@passengerWallets')->name('Passanger.Wallets')->middleware('checkPost');








//Drivers Part
//get Drivers
Route::get('drivers','DriverController@getDrivers')->name('Drivers')->middleware('checkPost');
//Route::get('drivers','DriverController@getTotalDriver')->name('Driver.totalDrivers')->middleware('checkPost');
//Driver Statistics
Route::get('driverStats','DriverController@driverStats')->name('Driver.stat')->middleware('checkPost');
//Drivers Profile
Route::get('driverProfile/{driverId}','DriverController@getDriverProfile')->name('Driver.driverProfile')->middleware('checkPost');
//online Drivers
Route::get('onlineDriver','DriverController@onlineDrivers')->name('Driver.online')->middleware('checkPost');
//Active or non Active Drivers Check the Working Status
Route::get('activeOrUnactiveDrivers/{status}','DriverController@getactiveOrUnActive')->name('Working.Status')->middleware('checkPost');
//Approved or not Approved Drivers Check the Validity Status
Route::get('approvedOrNotApproved/{status}','DriverController@getApprovedOrUnApproved')->name('Valid.Status')->middleware('checkPost');
//Insert Drivers
Route::get('createDriver','DriverController@createDriver')->name('Driver.Create')->middleware('checkPost');
//Registered Drivers
Route::post('registeredDriver','DriverController@registeredDriver')->name('Driver.Registered')->middleware('checkPost');
//Approve Driver
Route::get('approveDriver/{driverId}','DriverController@approveDriver_view')->name('Driver.ApproveView')->middleware('checkPost');
//Approve or Edit
Route::post('approvedOrEdit','DriverController@approveOrEdit')->name('Driver.editProfile')->middleware('checkPost');
//Drivers Booking
Route::get('getBookings/{userId}','DriverController@getBooking')->name('Driver.booking')->middleware('checkPost');
//Drivers Wallets
Route::get('driversWallets','DriverController@driversWallets')->name('Driver.Wallets')->middleware('checkPost');










//Vehicle Part
//get Vehicle Parts
Route::get('vehicleTypes','VehicleController@allCarTypes')->name('Vehicle.allTypes')->middleware('checkPost');
//here we can make the CarType Unactive 
Route::get('changeStatusVehicle/{id}/{status}','VehicleController@activeOrInactive')->name('Vehicle.changeStatus')->middleware('checkPost');
//page to show edit CarType.
Route::get('editCarType/{id}','VehicleController@editCarType_show')->name('Vehicle.editShow')->middleware('checkPost');
//Request to Edit CarType.
Route::post('editCarType','VehicleController@editCarType')->name('Vehicle.edit')->middleware('checkPost');



// Accounts Part
//Get Payment 
Route::get('getPayments/{driverId}','AccountController@getPayments')->name('Driver.getPayment')->middleware('checkPost');
Route::post('receivePayment','AccountController@driverPayment')->name('Driver.Payment')->middleware('checkPost');
//get All Payment Records of Driver
Route::get('getAllPaymentRecords/{driverId}','AccountController@getAllReceiptRecordsofDriver')->name('Driver.getAllPayment')->middleware('checkPost');
