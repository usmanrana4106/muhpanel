<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Model\Bookings;
use Carbon\Carbon;
use App\Model\Users;

//*****Created By Usman Abbas*******//

class HomeController extends Controller
{
    public function home()
    {
    	$totalTrips=Bookings::count();
    	$totalmonthlyTrips=Bookings::where('rideType','TM')->count();
    	$totalTodayBookings=Bookings::getTodayBookings_count();    	

    	return view('Pages.home',compact('totalTrips','totalmonthlyTrips','totalTodayBookings'));
    }

    public function searchUser(Request $request)
    {
        echo "under Development";
    }

    public function tracking()
    {
    	return view('Pages.Tracking.tracking');
    }


    
}
