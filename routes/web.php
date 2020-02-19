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

Route::get('R_admin_adminDetails','AdminController@adminDetails')->name('Admin.details')->middleware('checkPost');
Route::get('C_admin_registerAdmin','AdminController@registerAdmin_view')->name('Admin.create')->middleware('checkPost');
Route::post('C_admin_registerAdmin','AdminController@registerAdmin')->name('Admin.register')->middleware('checkPost');
Route::get('D_admin_deleteAdmin/{id}','AdminController@deleteAdmin')->name('Admin.delete')->middleware('checkPost');
Route::get('U_admin_editAdmin/{id}','AdminController@editAdmin_view')->name('Admin.edit')->middleware('checkPost');
Route::post('U_admin_editAdmin','AdminController@editAdmin')->name('Admin.edit')->middleware('checkPost');
Route::get('R_admin_roles','AdminController@getSystemRoles')->name('Admin.roles')->middleware('checkPost');
Route::get('C_admin_role','AdminController@newRole')->name('Admin.newRole')->middleware('checkPost');
Route::post('C_admin_role','AdminController@registeredNewRole')->name('Admin.newRole')->middleware('checkPost');


Route::get('C_admin_companies','CompanyController@createCompanies_view')->name('Admin.newCompanies')->middleware('checkPost');
Route::post('C_admin_companies','CompanyController@registeredCompany')->name('Admin.createCompanies')->middleware('checkPost');
Route::get('R_admin_companies','CompanyController@companies')->name('Admin.Companies')->middleware('checkPost');
Route::get('R_admin_deletecompanies/{id}','CompanyController@deletecompanies')->name('Admin.deleteCompanies')->middleware('checkPost');
Route::get('U_admin_updateCompanies/{id}','CompanyController@updatecompanies_view')->name('Admin.updateCompaniesView')->middleware('checkPost');
Route::post('U_admin_updateCompanies','CompanyController@updatecompanies')->name('Admin.updateCompanies')->middleware('checkPost');





Route::get('/homo','HomeController@homo');
Route::post('/users','HomeController@getUsers')->name('dataProcessing');


Route::get('locale/{locale}',function ($locale){
    Session::put('locale',$locale);
    return redirect()->back();
});

//Home Page
Route::get('R_home','HomeController@home')->name('Home')->middleware('checkPost');
//Tracking
Route::get('R_tracking','HomeController@tracking')->name('Tracking')->middleware('checkPost');
//Tracking Passenger
Route::get('R_tracking_trackingPassenger','HomeController@trackingPassenger')->name('Tracking.Passenger')->middleware('checkPost');

//Search User or Driver By ID
Route::post('search','HomeController@searchUser')->name('Home.search')->middleware('checkPost');
//open Countries Panel
Route::get('countries','HomeController@countries')->name('Countries')->middleware('checkPost');






//Bookings
Route::get('R_bookings','BookingController@AllBooking')->name('Booking.AllBooking')->middleware('checkPost');
//Today Bookings
Route::get('R_bookings_dailyBookings','BookingController@BookingsInProgress')->name('Booking.DailyBooking')->middleware('checkPost');
//Monthly Bookings
Route::get('R_bookings_monthlyBookings','BookingController@MonthlyBookings')->name('Booking.MonthlyBooking')->middleware('checkPost');
//Bookings On Date View
Route::get('R_bookings_dateBookings','BookingController@BookingsOnDate_view')->name('Booking.DateBooking')->middleware('checkPost');
//Bookings On Date 
Route::post('R_bookings_dateBookings','BookingController@BookingsOnDate')->name('Booking.DateBooking')->middleware('checkPost');
//Booking with stats //New: Start: End: Complete: Driver Not Found: Cancel 
Route::get('R_bookings_bookingStatus/{rideStatus}','BookingController@BookingWithStatus')->name('Booking.Status')->middleware('checkPost');
//Booking Status main View
Route::get('R_bookings_statusBooking','BookingController@getTypesOfBooking')->name('Booking.StatusView')->middleware('checkPost');
//Booking Details
Route::get('R_bookings_bookingDetails/{bookingId}/{rideStatus}','BookingController@BookingDetails')->name('Booking.Details')->middleware('checkPost');
//BookingNotifications
Route::get('R_bookings_bookingNofications/{bookingId}','BookingController@bookingNofications')->name('Booking.notification')->middleware('checkPost');
//Today End Trips
Route::get('R_bookings_CompleteBookings','BookingController@getTodayCompleteBookings')->name('Booking.Complete')->middleware('checkPost');






//Passanger Part
Route::get('R_passenger_passanger','PassengerController@getPassengers')->name('Passanger')->middleware('checkPost');
Route::get('R_passenger_passengerProfile/{userId}','PassengerController@passengerProfile')->name('Passanger.Profile')->middleware('checkPost');
//Passenger Wallets
Route::get('R_passenger_passengerWallets','PassengerController@passengerWallets')->name('Passanger.Wallets')->middleware('checkPost');
//Delete all the Records
Route::get('D_passenger_deletePassegerRecords/{userId}','PassengerController@deleteAllRecords')->name('PassangerRecords.Delete')->middleware('checkPost');
//Passenger Stats
Route::get('R_passenger_passengerStats','PassengerController@passengerStats')->name('Passanger.stat')->middleware('checkPost');

Route::get('D_passenger_deletePassenger/{userId}','PassengerController@deletePassenger')->name("Passanger.delete")->middleware('checkPost');
//Free Passenger
Route::get('U_passenger_freePassenger/{userId}','PassengerController@freePassenger')->name("Passanger.freePassenger")->middleware('checkPost');








//Drivers Part
//get Drivers
Route::get('R_drivers','DriverController@getDrivers')->name('Drivers')->middleware('checkPost');
//Route::get('drivers','DriverController@getTotalDriver')->name('Driver.totalDrivers')->middleware('checkPost');
//Driver Statistics
Route::get('R_drivers_driverStats','DriverController@driverStats')->name('Driver.stat')->middleware('checkPost');
//Drivers Profile
Route::get('R_drivers_driverProfile/{driverId}','DriverController@getDriverProfile')->name('Driver.driverProfile')->middleware('checkPost');
//online Drivers
Route::get('R_drivers_onlineDriver','DriverController@onlineDrivers')->name('Driver.online')->middleware('checkPost');
//Active or non Active Drivers Check the Working Status
Route::get('R_drivers_activeOrUnactiveDrivers/{status}','DriverController@getactiveOrUnActive')->name('Working.Status')->middleware('checkPost');
//Approved or not Approved Drivers Check the Validity Status
Route::get('R_drivers_approvedOrNotApproved/{status}','DriverController@getApprovedOrUnApproved')->name('Valid.Status')->middleware('checkPost');

//Get Drivers on CarBased
Route::get('R_drivers_getDriverwithCars/{cartype}','DriverController@driversWithCars')->name('Driver.WithCar')->middleware('checkPost');


//Insert Drivers
Route::get('C_drivers_createDriver','DriverController@createDriver')->name('Driver.Create')->middleware('checkPost');
//Registered Drivers
Route::post('C_drivers_registeredDriver','DriverController@registeredDriver')->name('Driver.Registered')->middleware('checkPost');
//Registered Driver Today	
Route::get('R_drivers_registeredToday','DriverController@dailyRegisteredDrivers')->name('Registered.Today')->middleware('checkPost');
//Approve Driver
Route::get('R_drivers_approveDriver/{driverId}','DriverController@approveDriver_view')->name('Driver.ApproveView')->middleware('checkPost');
//Approve or Edit
Route::post('U_drivers_approvedOrEdit','DriverController@approveOrEdit')->name('Driver.editProfile')->middleware('checkPost');
//Drivers Booking
Route::get('R_drivers_getBookings/{userId}','DriverController@getBooking')->name('Driver.booking')->middleware('checkPost');
//Drivers Wallets
Route::get('R_drivers_driversWallets','DriverController@driversWallets')->name('Driver.Wallets')->middleware('checkPost');
//Drivers Profile Image
Route::post('C_drivers_profileImage','DriverController@updateProfileImage')->name('Driver.profileImage')->middleware('checkPost');
//Drivers Iqama Image
Route::post('C_drivers_identityProof','DriverController@updateIdentityProof')->name('Driver.identityProof')->middleware('checkPost');
//Drivers Vehicle Proof Image
Route::post('C_drivers_licenseProof','DriverController@updateLicenseProof')->name('Driver.licenseProof')->middleware('checkPost');
//Drivers License Proof Image
Route::post('C_drivers_vehicleProof','DriverController@updateVehicleProof')->name('Driver.vehicleidentityProof')->middleware('checkPost');
//Drivers Driver Car Image
Route::post('C_drivers_driverCarImage','DriverController@updateDriverCarImage')->name('Driver.driverCarImage')->middleware('checkPost');
//Search Driver
Route::get('R_drivers_getDriverSearchBased','DriverController@searchDrivers')->name('Driver.searchView')->middleware('checkPost');
Route::post('R_drivers_getDriverSearchBased','DriverController@searchbasedDrivers')->name('Driver.search')->middleware('checkPost');
// Driver delete
Route::get('D_drivers_deleteDriver/{userId}','DriverController@deleteDrivers')->name("Driver.delete")->middleware('checkPost');
//Free driver 
Route::get('U_drivers_freeDriver/{userId}','DriverController@freeDriver')->name("Driver.freeDriver")->middleware('checkPost');
//Logout Driver
Route::get('U_drivers_logoutDriver/{userId}','DriverController@logoutDriver')->name("Driver.logoutDriver")->middleware('checkPost');






//Vehicle Part
//get Vehicle Parts
Route::get('R_car_vehicleTypes','VehicleController@allCarTypes')->name('Vehicle.allTypes')->middleware('checkPost');
//here we can make the CarType Unactive 
Route::get('U_car_changeStatusVehicle/{id}/{status}','VehicleController@activeOrInactive')->name('Vehicle.changeStatus')->middleware('checkPost');
//page to show edit CarType.
Route::get('U_car_editCarType/{id}','VehicleController@editCarType_show')->name('Vehicle.editShow')->middleware('checkPost');
//Request to Edit CarType.
Route::post('U_car_editCarType','VehicleController@editCarType')->name('Vehicle.edit')->middleware('checkPost');
//Request to create CarType.
Route::get('R_car_createCarType','VehicleController@createCarType_show')->name('Vehicle.createShow')->middleware('checkPost');
//Request to create CarType.
Route::post('C_car_createCarType','VehicleController@createCarType')->name('Vehicle.create')->middleware('checkPost');
//Request to create CarType.
Route::get('D_car_deleteCarType/{id}','VehicleController@deleteCarType')->name('Vehicle.delete')->middleware('checkPost');
//getDistance
Route::get('R_car_getDistance','VehicleController@getDistance')->name('distance.createView')->middleware('checkPost');
//Update distance
Route::post('U_car_changeDistance','VehicleController@changeDistance')->name('distance.create')->middleware('checkPost');
//get Vehicle Based Registration
Route::get('R_car_vehicleRegistration','VehicleController@vehicleRegistration')->name('Vehicle.vehicleRegistration')->middleware('checkPost');


// Accounts Part
//Get Payment 
Route::get('R_drivers_getPayments/{driverId}','AccountController@getPayments')->name('Driver.getPayment')->middleware('checkPost');
Route::post('C_drivers_receivePayment','AccountController@driverPayment')->name('Driver.Payment')->middleware('checkPost');
//get All Payment Records of Driver
Route::get('R_drivers_getAllPaymentRecords/{driverId}','AccountController@getAllReceiptRecordsofDriver')->name('Driver.getAllPayment')->middleware('checkPost');


//verions update
Route::get('R_admin_version','HomeController@getVersion')->name('version.get')->middleware('checkPost');
Route::post('U_admin_version','HomeController@versionUpdate')->name('version.update')->middleware('checkPost');

