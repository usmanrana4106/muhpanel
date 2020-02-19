<?php

namespace App\Http\Controllers;

use App\Model\PassengerDetails;
use App\Model\VehicleDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;


use App\Model\Bookings\Bookings;
use App\Model\Bookings\BookingDetails;
use App\Model\Bookings\BookingBroadCasting;
use App\Model\Bookings\BookingProgress;
use App\Model\Bookings\BookingComplete;



use App\Model\Drivers;
use App\Model\Users;
use App\Model\Accounts;
use App\Model\CarDetail;

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
        $BookingBroadCasting=BookingBroadCasting::where('rideStatus','1')->count();
        $BookingStart=BookingProgress::where('rideStatus','3')->count();
        $BookingReaching=BookingProgress::where('rideStatus','6')->count();
        $BookingArrived=BookingProgress::where('rideStatus','8')->count();
        $BookingComplete=BookingComplete::where('rideStatus','4')->count();
        //$BookingnotAccepted=Bookings::where('rideStatus','2')->count();
        $BookingCancelled=Bookings::where('rideStatus','5')->count();
       return view('Pages.Bookings.bookingTypes',compact('BookingBroadCasting','BookingStart','BookingReaching','BookingArrived','BookingComplete','BookingnotAccepted','BookingCancelled'));
    }

    Public function BookingWithStatus($rideStatus)
    {
            $url='api/R_bookings_bookings'; 
        if ($rideStatus== '1')
        {
            $bookingTitle="New Bookings";
        }
        elseif($rideStatus== '2')
        {
            $bookingTitle="not Accept Bookings";
        }
        elseif($rideStatus== '3')
        {
            $bookingTitle="Start Bookings"; 
        }
        elseif($rideStatus== '4')
        {
            $bookingTitle="End Bookings"; 
        }
        elseif($rideStatus== '5')
        {
            $bookingTitle="Cancel Bookings"; 
        }
        elseif($rideStatus== '6')
        {
            $bookingTitle="On the Way Bookings"; 
        }
        elseif($rideStatus== '8')
        {
            $bookingTitle="Driver Those Arrived"; 
        }
        return view('Pages.Bookings.bookings',compact('bookingTitle','url','rideStatus'));
    }


    Public function BookingsInProgress()
    {
       $bookingTitle="Bookings In Progress";
       return view('Pages.Bookings.bookingInProgress',compact('bookingTitle'));
    }


    Public function MonthlyBookings()
    {
        $Bookings=Bookings::getAllMonthlyBookings();
        $bookingTitle="Monthly All Bookings";
        return view('Pages.Bookings.bookings',compact('Bookings','bookingTitle'));
    }

    Public function BookingsOnDate_view()
    {
        $carTypes=CarDetail::all();
          return view('Pages.Bookings.bookingDateBased',compact('Bookings','bookingTitle','carTypes'));
    }

    public function BookingsOnDate(Request $request)
    {
        if ($request->rideStatus== '1')
        {
             $bookingTitle="New Bookings Based on Date: ".$request->date;
            $Bookings=BookingBroadCasting::getBookingDate($request->date,$request->rideType);
        }
        elseif ($request->rideStatus== '3' || $request->rideStatus== '6' || $request->rideStatus== '8')
        {
            if ($request->rideStatus== '3') 
             $bookingTitle="Start Bookings Based on Date: ".$request->date;
            elseif ($request->rideStatus== '6') 
             $bookingTitle="On the Way Bookings Based on Date: ".$request->date;
            elseif ($request->rideStatus== '8') 
             $bookingTitle="Driver Arrived Bookings Based on Date: ".$request->date;
            $Bookings=BookingProgress::getBookingDate($request->date,$request->rideType,$request->rideStatus);
        }
        elseif ($request->rideStatus== '4')
        {
             $bookingTitle="End Bookings Based on Date: ".$request->date;
            $Bookings=BookingComplete::getBookingDate($request->date,$request->rideType);
        }
        elseif ($request->rideStatus== '2' || $request->rideStatus== '5')
        {
            if ($request->rideStatus== '2') 
             $bookingTitle="Bookings not Accepted Based on Date: ".$request->date;
            elseif ($request->rideStatus== '5') 
             $bookingTitle="Cancel Bookings Based on Date: ".$request->date;
            $Bookings=Bookings::getBookingDate($request->date,$request->rideType);
        }
        return view('Pages.Bookings.searchBasedBookings',compact('Bookings','bookingTitle'));
    }

    public function BookingDetails($bookingId,$rideStatus)
    {
        if ($rideStatus=="1")
        {
            $Bookings=BookingBroadCasting::where(['rideStatus'=>$rideStatus,]);

        }
        elseif ($rideStatus=="3" || $rideStatus=="6" || $rideStatus=="8")
        {
            $Bookings=BookingProgress::getBookingsWithStatus($rideStatus);
        }
        elseif ($rideStatus=="2" || $rideStatus=="5")
        {
            $Bookings=Bookings::getBookingsWithStatus($rideStatus);
        }
        elseif ($rideStatus=="4" )
        {
            $Bookings=BookingComplete::getBookingsWithStatus($rideStatus);
        }
        $trips=BookingComplete::where(['bookingId'=>$bookingId,'rideStatus'=>'4'])->first();
        if (!empty($trips))
        {
            $pickupLatLng=explode(',', $trips->pickupLatLong);
            if ($rideStatus=="4" )
            {
                $endTripLatLng = explode(',', $trips->EndTripLatLng);
            }
            else
            {
                $endTripLatLng = explode(',', $trips->destinationLatLong);
            }
            if ($rideStatus!="1" )
            {
                $driverInfo = Drivers::where('userId', $trips->driverId)->first();
                $driverUserInfo = Users::where('userId', $trips->driverId)->first();
                $vehicle=VehicleDetails::where('driverId',$driverInfo->driveId)->first();
                $carDetail=CarDetail::where('carId',$vehicle->vihicleType)->first();
                if(empty($driverUserInfo->profileImage))
                {
                    $driverUserInfo['profileImage']="not Avaliable";
                }
                else
                {
                    $driverUserInfo->profileImage=$this->url."/uploads/images/driverImage/".$driverUserInfo->profileImage;
                }
            }
            else
            {
                $driverInfo=new Drivers();
                $driverUserInfo = new Users();
                $vehicle=new VehicleDetails();
                $carDetail=new CarDetail();
            }
            $passenger=Users::where('userId',$trips->passengerId)->first();
            $passengerDetail=PassengerDetails::where('userId',$trips->passengerId)->first();

            $accounts=Accounts::where('bookingId',$bookingId)->first();
            return view('Pages.Bookings.bookingDetail',compact('driverInfo','driverUserInfo','vehicle','carDetail','trips','passenger','passengerDetail','pickupLatLng','endTripLatLng','accounts'));
        }
    }

    public function bookingNofications($bookingId)
    {
        if (!empty($bookingId))
        {
            $bookingDetails= BookingDetails::where('bookingId',$bookingId)->select('bookingdetail.bookingId', 'bookingdetail.driverId','bookingdetail.crd', 'bookingdetail.driverStatus','driverdetail.fullName', 'driverdetail.mobileNumber')
                ->leftJoin('driverdetail', 'bookingdetail.driverId', '=', 'driverdetail.driveId')->get();
            return view('Pages.Bookings.bookingNotificationsTo',compact('bookingDetails'));
        }
    }

    public function getTodayCompleteBookings()
    {
        $Date=date('Y-m-d');
        $Bookings=BookingComplete::getBookingDate($Date,'4');
        return view('Pages.Bookings.bookingComplete',compact('Bookings'));

    }
}
