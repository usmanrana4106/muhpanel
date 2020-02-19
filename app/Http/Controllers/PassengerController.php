<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;



use App\Model\Bookings\Bookings;
use App\Model\Bookings\BookingDetails;
use App\Model\Bookings\BookingBroadCasting;
use App\Model\Bookings\BookingProgress;
use App\Model\Bookings\BookingComplete;


use App\Model\Notification;


use App\Model\Users;
use App\Model\Accounts;
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

         $wallet=PassengerWallet::where('userId',$userId)->first();     					
       	if(!empty($passengerInfo->profileImage))
       		$passengerInfo->profileImage=$this->url."/public/uploads/images/passengerImage/".$passengerInfo->profileImage;
    	return view('Pages.Passengers.passengerProfile',compact('passengerInfo','wallet'));
    }

    public function passengerWallets()
    {
         return view('Pages.Passengers.passengerWallets');
    }

    public function deleteAllRecords($userId)
    {
        Bookings::where('passengerId',$userId)->delete();
        Accounts::where('userId',$userId)->delete();
        PassengerWallet::where('userId',$userId)->update(['totalPay'=>0.0, 'credit'=>0.0, 'due'=>0.0]);
        return redirect()->route('Passanger.Profile',$userId);
    }

    public function passengerStats()
    {
          $Passengers=Users::where('userType','passenger')->count();
          $login=Users::where(['userType'=>'passenger','isLoggedIn'=>'1'])->count();
          $logout=Users::where(['userType'=>'passenger','isLoggedIn'=>'2'])->count();
         return view('Pages.Passengers.statsOfPassengers',compact(
                                                            'Passengers','login','logout'
                                                          ));
    }

    public function deletePassenger($userId)
    {
      $user=Users::where(['userId'=>$userId,'userType'=>'passenger'])->first();
      $input=['mobileNumber'=>0,'unactive'=>$user->mobileNumber];
      Users::where('userId',$userId)->update($input);
      PassengerDetails::where('userId',$userId)->update(['mobileNumber'=>'0']);
      
      if ($user->deviceType == 1) 
      {
          $notifyResponse=Notification::silentNotify(array($user->deviceToken),$user->userType);
      }
      else
      {
          $result=Notification::silentNotifyiOS($user->deviceToken);
      }
         
      $url = URL::previous();
      session()->put('delete','yes');
      return redirect($url);
    }

    public function freePassenger($userId)
    {
        $user=Users::where(['userId'=>$userId,'userType'=>'passenger'])->first();
        $result=1;
        if ($user->deviceType == 1)
        {
            $notifyResponse=Notification::notify(array($user->deviceToken), 'booking free' , "", '1', 'silent');
            $notifyResult=json_decode($notifyResponse);
            if ($notifyResult->success==1)
            {
                $result=1;
            }
            elseif ($notifyResult->success==0)
            {
                $result=0;
            }
        }
        else
        {
            $result=Notification::silentNotifyiOS($user->deviceToken);
        }

        $url = URL::previous();
        session()->put('free','yes');
        if ($result == 1)
        {
            session()->flash('passengerFree','yes');
        }
        return redirect($url);
    }
}
