<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

use App\Model\Bookings;
use App\Model\Users;
use App\Model\PassengerDetails;
use App\Model\PassengerWallet;


class PassengerController extends Controller
{
	protected $url;

    public function __construct()
    {
        $this->url = URL::to('/');
    }

    public function getPassengers()
    {
    	$Passengers=Users::select('userId', 'userName', 'userType', 'gender',
                            'email','mobileNumber','loginStatus','crd')->where('userType','passenger')->get();
    	$title='Total Passengers';
    	return view('Pages.Passengers.TotalPassengers',compact('Passengers','title'));
    }

    public function passengerProfile($userId)
    {
        $passengerInfo=Users::where('users.userId',$userId)
        					->leftJoin('passengerdetail', 'users.userId', '=', 'passengerdetail.userId')->first();
		$Bookings=Bookings::getPassengerBookings($userId);     					
       	if(!empty($passengerInfo->profileImage))
       		$passengerInfo->profileImage=$this->url."/uploads/images/passengerImage/".$passengerInfo->profileImage;
    	return view('Pages.Passengers.passengerProfile',compact('passengerInfo','Bookings'));
    }

    public function passengerWallets()
    {
        $Wallets=PassengerWallet::all();
         return view('Pages.Passengers.passengerWallets',compact('Wallets'));
    }
}
