<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
//*****Created By Usman Abbas*******//
class Bookings extends Model
{
    protected $table = 'bookings';
    public $timestamps = false;
 	protected $fillable = [
						        'bookingId', 'passengerId', 'rideType', 'transactionId', 'pickupAddress', 'destinationAddress', 'pickupLatLong', 'destinationLatLong', 'EndTripLatLng', 'passengerCount', 'tripTotal', 'Actual_TripTotal', 'actualDistance', 'actualTime', 'vehichleId', 'rideStartDate', 'rideStartTime', 'rideEndDate', 'rideEndTime', 'distance', 'paymentType', 'rideStatus', 'driverId', 'rejectBy', 'reason', 'status', 'Serve_status', 'suggestedPrice', 'customer_type', 'tripReferenceNumber', 'crd', 'upd'
						    ];

		public static function getAllBookings()
		{
			$bookings=DB::table('bookings') ->leftJoin('users', 'bookings.passengerId', '=', 'users.userId')
           									->leftJoin('driverdetail', 'bookings.driverId', '=', 'driverdetail.userId')
           									->select('bookings.bookingId', 'bookings.passengerId', 'bookings.pickupAddress', 'bookings.destinationAddress', 'bookings.rideStartDate', 'bookings.rideStartTime', 'bookings.rideEndTime', 'bookings.actualDistance', 'bookings.rideStatus', 'bookings.Actual_TripTotal','bookings.driverId', 'users.userName', 'driverdetail.fullName','users.mobileNumber')->get();
            return $bookings;
		}

		public static function getBookingsWithStatus($rideStatus)
		{
			$bookings=DB::table('bookings')->where('bookings.rideStatus',$rideStatus)
										   ->leftJoin('passengerdetail', 'bookings.passengerId', '=', 'passengerdetail.userId')
		   								   ->leftJoin('driverdetail', 'bookings.driverId', '=', 'driverdetail.userId')
		   								   ->select('bookings.bookingId', 'bookings.passengerId', 'bookings.pickupAddress',
		   								   'bookings.pickupLatLong','bookings.EndTripLatLng', 'bookings.destinationAddress', 'bookings.rideStartDate', 'bookings.rideStartTime', 'bookings.rideEndTime', 'bookings.actualDistance', 'bookings.rideStatus', 'bookings.Actual_TripTotal','bookings.driverId',  'driverdetail.fullName as driverName','passengerdetail.fullName as passengerName','passengerdetail.mobileNumber')->get();
            return $bookings;
		}

		public static function getDriverBookings($driverUserId)
		{
			$bookings=DB::table('bookings')->where('driverId',$driverUserId)
											->leftJoin('users', 'bookings.passengerId', '=', 'users.userId')
           									->select('bookings.bookingId', 'bookings.passengerId', 'bookings.pickupAddress', 'bookings.destinationAddress', 'bookings.rideStartDate', 'bookings.rideStartTime', 'bookings.rideEndTime', 'bookings.actualDistance', 'bookings.rideStatus', 'bookings.Actual_TripTotal','bookings.driverId', 'users.userName', 'users.mobileNumber')->get();
            return $bookings;
		}

		public static function getPassengerBookings($UserId)
		{
			$bookings=DB::table('bookings')->where('passengerId',$UserId)
											->leftJoin('driverdetail', 'bookings.driverId', '=', 'driverdetail.userId')
           									->select('bookings.bookingId', 'bookings.passengerId', 'bookings.pickupAddress', 'bookings.destinationAddress', 'bookings.rideStartDate', 'bookings.rideStartTime', 'bookings.rideEndTime', 'bookings.actualDistance', 'bookings.rideStatus', 'bookings.Actual_TripTotal','bookings.driverId', 'driverdetail.fullName', 'driverdetail.mobileNumber')->get();
            return $bookings;
		}

		public static function getTodayBookings_count()
		{
			$Date=date('Y-m-d');
			$startDate=date("Y-m-d",strtotime($Date)).' 00:00'; //00:00 start day time
			$endDate=date("Y-m-d",strtotime($Date)).' 23:59'; //23:59 end day time
		
			return Bookings::whereBetween('crd', [$startDate, $endDate])->count();
		}

		public static function getTodayBookings()
		{
			$Date=date('Y-m-d');
			$startDate=date("Y-m-d",strtotime($Date)).' 00:00'; //00:00 start day time
			$endDate=date("Y-m-d",strtotime($Date)).' 23:59'; //23:59 end day time
		
			$bookings=Bookings::whereBetween('bookings.crd', [$startDate, $endDate])
			->select('bookings.bookingId', 'bookings.passengerId', 'bookings.pickupAddress', 'bookings.destinationAddress', 'bookings.rideStartDate', 'bookings.rideStartTime', 'bookings.rideEndTime', 'bookings.actualDistance', 'bookings.rideStatus', 'bookings.driverId', 'users.userName', 'driverdetail.fullName','users.mobileNumber','bookings.crd')
			->leftJoin('users', 'bookings.passengerId', '=', 'users.userId')
           	->leftJoin('driverdetail', 'bookings.driverId', '=', 'driverdetail.userId')
			->get();
			 return $bookings;

		}

		public static function getAllMonthlyBookings()
		{
			$bookings=Bookings::where('ridetype',"TM")
			->select('bookings.bookingId', 'bookings.passengerId', 'bookings.pickupAddress', 'bookings.destinationAddress', 'bookings.rideStartDate', 'bookings.rideStartTime', 'bookings.rideEndTime', 'bookings.actualDistance', 'bookings.rideStatus', 'bookings.driverId', 'users.userName', 'driverdetail.fullName','users.mobileNumber','bookings.crd')
			->leftJoin('users', 'bookings.passengerId', '=', 'users.userId')
           	->leftJoin('driverdetail', 'bookings.driverId', '=', 'driverdetail.userId')
			->get();
			 return $bookings;
		}

		public static function getBookingDate($date,$rideType)
		{
			
			$startDate=date("Y-m-d",strtotime($date)).' 00:00'; //00:00 start day time
			$endDate=date("Y-m-d",strtotime($date)).' 23:59'; //23:59 end day time
		
			$bookings=Bookings::where('bookings.rideType',$rideType)->whereBetween('bookings.crd',[$startDate, $endDate])
			->select('bookings.bookingId', 'bookings.passengerId', 'bookings.pickupAddress', 'bookings.destinationAddress', 'bookings.rideStartDate', 'bookings.rideStartTime', 'bookings.rideEndTime', 'bookings.actualDistance', 'bookings.rideStatus', 'bookings.driverId', 'users.userName', 'driverdetail.fullName','users.mobileNumber','bookings.crd')
			->leftJoin('users', 'bookings.passengerId', '=', 'users.userId')
           	->leftJoin('driverdetail', 'bookings.driverId', '=', 'driverdetail.userId')
			->get();
			return $bookings;
		}
}
