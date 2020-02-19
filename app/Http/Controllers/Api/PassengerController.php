<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\QueryException;

use Validator;
use App\Model\Drivers;
use App\Model\Users;
use App\Model\PassengerDetails;
use App\Model\Notification;
use App\Model\PassengerRating;
use App\Model\PassengerWallet;

use App\Model\Bookings\Bookings;
use App\Model\Bookings\BookingDetails;
use App\Model\Bookings\BookingBroadCasting;
use App\Model\Bookings\BookingProgress;
use App\Model\Bookings\BookingComplete;



class PassengerController extends Controller
{
    protected $url;

    public function __construct()
    {
        $this->url = URL::to('/');
    }
    public function updateProfile(Request $request)
    {
    	$validation=Validator::make($request->all(),[
                                                        'userId' => 'required',
                                                        'email' => 'required'
                                                    ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }

        $user=Users::where('email',$request->email)->first();
        if (!empty($user))
        {
            if ($user->userId != $request->userId)
            {
                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Email is Already Existed"];
                $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                return  response()->json(array('array'=>$array), 200);
            }

        }
        $input['email']=$request->email;
        $file=$request->file('profileImage');
        $profileImage='';
        if($file)
        {
            $extension=$file->getClientOriginalExtension();
            $filename =$request->userId.".".$extension;
            $file->move('public/uploads/images/passengerImage/',$filename);
            $input['profileImage']=$filename;
            $profileImage=$this->url."/public/uploads/images/passengerImage/".$filename;
        }
        $update=Users::where(['userId'=>$request->userId,'userType'=>'passenger'])->update($input);
        $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
	    $array=array('profileImage'=>$profileImage,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
	    return  response()->json(array('array'=>$array), 200);
    }

    public function updatePassengerDetails(Request $request)
    {
    	$validation=Validator::make($request->all(), [
                                                            'userId' => 'required',
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
		$update=PassengerDetails::where('userId',$request->userId)->update($request->all());
		if ($update == 1)
		{
			$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
		    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$update);
		    return  response()->json(array('array'=>$array), 200);	
		}
		else
		{
			$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
		    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$update);
		    return  response()->json(array('array'=>$array), 200);	
		}
    }

    public function getWallet(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'userId' => 'required',
                                                            'fullName'=>'required'
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Updation",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        else
        {
            $user=Users::where('userId',$request->userId)->first();
            if (!empty($user)) 
            {
                $passengerWallet=PassengerWallet::where('userId',$request->userId)->first();
                if(empty($passengerWallet))
                {
                    $passengerWallet=PassengerWallet::create([
                                                'userId'=>$request->userId,
                                                'fullName'=>$request->fullName,
                                                'totalPay'=>0,
                                                'credit'=>0,
                                                'due'=>0
                                             ]);
                    Users::where('userId',$request->userId)->update(['walletStatus'=>1]);
                }
                
                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                $array=array('wallet'=>$passengerWallet,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
                return  response()->json(array('array'=>$array), 200);
            }
            
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
    }

    public function previousBookings(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'userId' => 'required',
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        $booking=BookingComplete::where(['passengerId'=>$request->userId,'rideStatus'=>'4'])->paginate(5);
        if (!empty($booking[0])) 
        {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('Booking'=>$booking,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
            return  response()->json(array('array'=>$array), 200);
        }
        else 
        {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('Booking'=>$booking,'ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        
    }

    public function cancelBookings(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'userId' => 'required',
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        $booking=Bookings::where(['passengerId'=>$request->userId,'rideStatus'=>'5','rejectBy'=>'P'])->paginate(5);
        if (!empty($booking[0])) 
        {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('Booking'=>$booking,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
            return  response()->json(array('array'=>$array), 200);
        }
        else 
        {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('Booking'=>$booking,'ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
    }

    public function updateProfileImage(Request $request)
    {
    	$validation=Validator::make($request->all(), [
                                                            'userId' => 'required',
                                                            'profileImage' => 'required',
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        $user=Users::where(['userId'=>$request->userId,'userType'=>'passenger'])->first();
        if (!empty($user))
        {
        	$file=$request->file('profileImage');
	       	if($file)
	        {
	        	$extension=$file->getClientOriginalExtension();
	            $filename =$request->userId.".".$extension;
	            $file->move('public/uploads/images/passengerImage/',$filename);
	            Users::where('userId',$user->userId)->update(['profileImage'=> $filename]);
	            $user->profileImage=$this->url."/public/uploads/images/passengerImage/".$filename;

	            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
			    $array=array('update_Profile'=>$user,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
			    return  response()->json(array('array'=>$array), 200);
	        }
        }
        $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"User does'nt exists"];
	    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
	    return  response()->json(array('array'=>$array), 200);
    }

    public function passengerRating(Request $request)
    {
         $validation=Validator::make($request->all(), [
                                                            'driverId' => 'required',
                                                            'passengerId'=>'required',
                                                            'rate'=>'required',
                                                            'status'=>'required',
                                                            'bookingId'=>'required'
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        else
        {
            $input['driverId']=$request->driverId;
            $input['passengerId']=$request->passengerId;
            $input['rate']=$request->rate;
            $input['review']=$request->review;
            $input['status']=1;
            $input['bookingId']=$request->bookingId;
            PassengerRating::create($input);
            $rating=PassengerRating::where('passengerId',$request->passengerId)->avg('rate');
            PassengerDetails::where('userId',$request->userId)->update(['rating'=>$rating]);
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
            return  response()->json(array('array'=>$array), 200);
        }
    }

}
