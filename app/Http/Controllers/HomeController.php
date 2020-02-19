<?php

namespace App\Http\Controllers;

use App\Model\Verion;
use Illuminate\Http\Request;

use App\Model\Bookings\Bookings;
use App\Model\Bookings\BookingDetails;
use App\Model\Bookings\BookingBroadCasting;
use App\Model\Bookings\BookingProgress;
use App\Model\Bookings\BookingComplete;



use Carbon\Carbon;
use App\Model\Users;
use App\Model\Drivers;
use App\Model\VehicleDetails;
use App\Model\PassengerDetails;

//*****Created By Usman Abbas*******//


class HomeController extends Controller
{
    public function home()
    {
    	//$totalmonthlyTrips=Bookings::where('rideType','TM')->count();
    	$ontheWay=BookingProgress::getTodayBookings_count(6);
        $arrived=BookingProgress::getTodayBookings_count(8);
        $startTrip=BookingProgress::getTodayBookings_count(3);
        $endTrip=BookingProgress::getTodayBookings_count(4);


        $Date=date('Y-m-d');
        $startDate=date("Y-m-d",strtotime($Date)).' 00:00'; //00:00 start day time
        $endDate=date("Y-m-d",strtotime($Date)).' 23:59'; //23:59 end day time
        $dailRegisteredDrivers=Drivers::whereBetween('crd', [$startDate, $endDate])->count();
        $dailRegisteredPassengers=PassengerDetails::whereBetween('crd', [$startDate, $endDate])->count();
        $onlineDriver=Users::where(['userType'=>'driver','loginStatus'=>'1'])->count();
        $onlinePassenger=Users::where(['userType'=>'passenger','loginStatus'=>'1'])->count();
    	return view('Pages.home',compact(
                                                'ontheWay','arrived','startTrip',
                                                'endTrip','dailRegisteredDrivers','onlineDriver',
                                                'dailRegisteredPassengers','onlinePassenger'
                                            ));
    }

    public function searchUser(Request $request)
    {
        echo "under Development";
    }

    public function tracking()
    {
    	return view('Pages.Tracking.tracking');
    }

    public function trackingPassenger()
    {
        return view('Pages.Tracking.passengerTracking');
    }

    public function homo()
    {
        return view('Pages.pagination.pagination');
    }



    public function getUsers(Request $request){
        //print_r($request->all());


        $query=Users::select('userId','userName','gender','mobileNumber','loginStatus','crd');
        return datatables($query)->addColumn('action', function ($faculties) {
                return '<a href="R_passenger_passengerProfile/'.$faculties->userId.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Profile</a>
                     ';
                         })->make(true);

    }

    public function getVersion()
    {
        $android=Verion::where('id','1')->first();
        $iOS=Verion::where('id','2')->first();

        $versionUpdate=session()->get('versionUpdate');
        return view('Pages.AppVersions.versions',compact('android','iOS','versionUpdate'));
    }

    public function versionUpdate(Request $request)
    {
        $this->validate($request,[
            'versionId1'=>'required',
            'versionId2'=>'required',
            'version_code1'=>'required',
            'version_code2'=>'required'
        ]);
        if ($request->versionId1 == 1)
        {
            $andriod=Verion::where('id',$request->versionId1)->update(['version_code'=>$request->version_code1]);
        }

        if ($request->versionId2 ==2)
        {
            $ios=Verion::where('id',$request->versionId2)->update(['version_code'=>$request->version_code2]);
        }
        session()->put('versionUpdate','yes');
        return redirect()->route('version.get');
    }


}
