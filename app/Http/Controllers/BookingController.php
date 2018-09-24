<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;

use App\Model\Bookings;
use App\Model\Drivers;
use App\Model\Users;

// 'bookingId', 'passengerId', 'rideType', 'transactionId', 'pickupAddress', 'destinationAddress', 'pickupLatLong', 'destinationLatLong', 'EndTripLatLng', 'passengerCount', 'tripTotal', 'Actual_TripTotal', 'actualDistance', 'actualTime', 'vehichleId', 'rideStartDate', 'rideStartTime', 'rideEndDate', 'rideEndTime', 'distance', 'paymentType', 'rideStatus', 'driverId', 'rejectBy', 'reason', 'status', 'Serve_status', 'suggestedPrice', 'customer_type', 'tripReferenceNumber', 'crd', 'upd'

//*****Created By Usman Abbas*******//
class BookingController extends Controller
{

    protected $url;

    public function __construct()
    {
        $this->url = URL::to('/');
    }

    Public function AllBooking()
    {
    	$Bookings=Bookings::getAllBookings();

    // echo '<pre>';
    // var_dump($Bookings->toArray());
    // echo '</pre>';

       $bookingTitle="All Bookings";
	   return view('Pages.Bookings.bookings',compact('Bookings','bookingTitle'));
    }   

    public function getTypesOfBooking()
    {
       return view('Pages.Bookings.bookingTypes');
    }

    Public function BookingWithStatus($rideStatus)
    {

        $Bookings=Bookings::getBookingsWithStatus($rideStatus);
        if ($rideStatus== '1')
            $bookingTitle="New Bookings"; 
        elseif($rideStatus== '2')
             $bookingTitle="Comfirm Bookings"; 
        elseif($rideStatus== '3')
             $bookingTitle="Start Bookings"; 
        elseif($rideStatus== '4')
             $bookingTitle="End Bookings"; 
        elseif($rideStatus== '5')
             $bookingTitle="Cancel Bookings"; 
        elseif($rideStatus== '6')
             $bookingTitle="On the Way Bookings"; 
         elseif($rideStatus== '8')
             $bookingTitle="Driver Those Arrived"; 

        return view('Pages.Bookings.bookings',compact('Bookings','bookingTitle'));
    }


    Public function DailyBookings()
    {
       $Bookings=Bookings::getTodayBookings();

       $bookingTitle="Daily Bookings";
       return view('Pages.Bookings.bookings',compact('Bookings','bookingTitle'));
    }


    Public function MonthlyBookings()
    {
        $Bookings=Bookings::getAllMonthlyBookings();
        $bookingTitle="Monthly All Bookings";
        return view('Pages.Bookings.bookings',compact('Bookings','bookingTitle'));
    }

    Public function BookingsOnDate_view()
    {
          return view('Pages.Bookings.bookingDateBased',compact('Bookings','bookingTitle'));
    }

    public function BookingsOnDate(Request $request)
    {
        $Bookings=Bookings::getBookingDate($request->date,$request->rideType);
        //      echo '<pre>';
        // var_dump($Bookings->toArray());
        // echo '</pre>';
        if ($request->rideType=='TN') 
        {
            $bookingTitle="Daily Bookings of Date: ".$request->date;
        }
        else
        {
            $bookingTitle="Monthly Bookings of Date: ".$request->date;
        }
        return view('Pages.Bookings.bookings',compact('Bookings','bookingTitle'));
    }

    public function BookingDetails($bookingId)
    {
        $trips=Bookings::where(['bookingId'=>$bookingId,'rideStatus'=>'4'])->first();
        if (!empty($trips))
        {
            $pickupLatLng=explode(',', $trips->pickupLatLong);
            $endTripLatLng=explode(',', $trips->EndTripLatLng);
         
            $driverInfo=Drivers::where('userId',$trips->driverId)->first();
            $driverUserInfo=Users::where('userId',$trips->driverId)->first();
            $customer=Users::where('userId',$trips->passengerId)->first();
            if(empty($driverUserInfo->profileImage))
            {
                $driverUserInfo->profileImage="not Avaliable";
            }
            else
            {
                $driverUserInfo->profileImage=$this->url."/uploads/images/driverImage/".$driverUserInfo->profileImage;
            }
            return view('Pages.Bookings.bookingDetail',compact('driverInfo','driverUserInfo','trips','customer','pickupLatLng','endTripLatLng'));
        }
      

    }
    
}
