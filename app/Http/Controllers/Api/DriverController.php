<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\URL;

use Validator;
use App\Model\Drivers;
use App\Model\Users;
use App\Model\Bookings;
use App\Model\Notification;
use App\Model\DriverWallet;
use App\Model\Accounts;
use App\Model\DriverRating;
use Carbon\Carbon;
//*****Created By Usman Abbas*******//

class DriverController extends Controller
{
    protected $url;

    public function __construct()
    {
        $this->url = URL::to('/');
    }
    //For Panel Tracking
    public function allDrivers()
    {
    	$drivers=DB::table('driverdetail')
                        					->select('driverdetail.driveId', 'driverdetail.userId', 'driverdetail.fullName', 'driverdetail.latitude', 'driverdetail.longitude','users.loginStatus')
                        					->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')
                        					->where('driverdetail.latitude','!=','')
                        					->where('users.loginStatus','1')
                        					->get();
                                            
        return  response()->json(array('data'=>$drivers), 200); 
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
                $driverWallet=DriverWallet::where('driverId',$request->userId)->first();
                if(empty($driverWallet))
                {
                   $driverWallet= DriverWallet::create([
                                                  'driverId'=>$request->userId,
                                                  'fullName'=>$request->fullName,
                                                  'totalPay'=>0.0,
                                                  'totalVatPaid'=>0.0,
                                                  'totalEarn'=> 0,
                                                  'currCash'=> 0,
                                                  'currentEarn'=> 0,
                                                  'currCompanyProfit'=> 0, 
                                                  'currVat'=> 0
                                             ]);
                    Users::where('userId',$request->userId)->update(['walletStatus'=>1]);
                }
                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                $array=array('wallet'=>$driverWallet,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
                return  response()->json(array('array'=>$array), 200);
            }
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
    }

    //update Profile Driver
    public function updateProfile(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'userId' => 'required',
                                                            
                                                            'email' => 'required',
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Updation",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        $input=['email'=>$request->email];
        $file=$request->file('profileImage');
        $picUpdated=0;
        if($file)
        {
            $extension=$file->getClientOriginalExtension();
            $filename =$request->userId.".".$extension;
            $data=$file->move('public/uploads/images/driverImage/',$filename);
            $input['profileImage']=$filename;
            $imageUrl=$this->url."/public/uploads/images/driverImage/".$filename;
            if (!empty($data)) 
            {
                $picUpdated=1;
            }
        }
        
        $update=Users::where(['userId'=>$request->userId,'userType'=>'driver'])->update($input);
        // $updatedriver=Drivers::where('userId',$request->userId)->update(['fullName'=>$request->fullName]);

        if ($update == 1 || $picUpdated==1) 
        {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('profileImage'=>$imageUrl,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
            return  response()->json(array('array'=>$array), 200);
        }
        else 
        {
           $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
           $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
           return  response()->json(array('array'=>$array), 200);
        }
    }


    public function previousBookings(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'driverId' => 'required',

                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Request",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        $Accounts=Accounts::where('driverId',$request->driverId)->paginate(5);
        if (!empty($Accounts[0])) 
        {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('Accounts'=>$Accounts,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
            return  response()->json(array('array'=>$array), 200);
        }
        else 
        {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('Accounts'=>$Accounts,'ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        
    }


    public function cancelBookings(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'driverId' => 'required',
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        $booking=Bookings::where(['driverId'=>$request->driverId,'rideStatus'=>'5','rejectBy'=>'D'])->paginate(5);
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



    public function updateDriverDetails(Request $request)
    {
        $validation=Validator::make($request->all(),[
                                                        'userId' => 'required',
                                                    ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        $updatedriver=Drivers::where('userId',$request->userId)->update($request->all());

         if ($updatedriver == 1) 
         {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$updatedriver);
            return  response()->json(array('array'=>$array), 200);
         }
         else 
         {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
         }
    }



    //update profile Image of Driver
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
        $user=Users::where(['userId'=>$request->userId,'userType'=>'driver'])->first();
        if (!empty($user))
        {
            $file=$request->file('profileImage');
            if($file)
            {
                $extension=$file->getClientOriginalExtension();
                $filename =$request->userId.".".$extension;
                $file->move('public/uploads/images/driverImage/',$filename);
                Drivers::where('userId',$user->id)->update(['profileImage'=> $filename]);
                $user->profileImage=$this->url."/public/uploads/images/driverImage/".$filename;

                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                $array=array('update_Profile'=>$user,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
                return  response()->json(array('array'=>$array), 200);
            }
        }
        $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"User does'nt exists"];
        $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
        return  response()->json(array('array'=>$array), 200);
    }

    //Update Driver Status Online offline
    public function updateDriverOnlineStatus(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'userId' => 'required',
                                                            'loginStatus'=>'required'
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in change Status.",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        $user=Users::where('userId',$request->userId)->update(['loginStatus'=>$request->loginStatus]);
        if ($user == 1)
        {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$user);
            return  response()->json(array('array'=>$array), 200);
        }
        else
        {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$user);
            return  response()->json(array('array'=>$array), 200);
        }
    }
    
    
    // public function nearByDriverssss(Request $request)
    // {
    //     $validation=Validator::make($request->all(), [
    //                                                         'lat' => 'required',
    //                                                         'lng'=>'required'
    //                                                   ]);
    //     if($validation->fails())
    //     {
    //         $errors = $validation->errors();
    //         $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
    //         $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
    //         return  response()->json(array('array'=>$array), 200);
    //     }
    //     $latitude=$request->lat;
    //     $longitude=$request->lng;

    //     $miles=4;


    //      $drivers=DB::select('SELECT * FROM driverdetail WHERE
    //       driverStatus = "1" AND
    //     latitude BETWEEN ('.$latitude.' - ('.$miles.'*0.018)) AND ('.$latitude.' + ('.$miles.'*0.018)) AND
    //     longitude BETWEEN ('.$longitude.' - ('.$miles.'*0.018)) AND ('.$longitude.' + ('.$miles.'*0.018))');
         
    //     $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
    //     $data= array( 'drivers'=>$drivers,'ErrorDetail'=>$ErrorDetail);
    //     $array=array('Data' => $data,'Result'=>1);
    //     return  response()->json(array('array'=>$array), 200);
    // }

     public function nearByDrivers(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'lat' => 'required',
                                                            'lng'=>'required'
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        $latitude=$request->lat;
        $longitude=$request->lng;

        $miles=4;


         $drivers=DB::select('SELECT * FROM driverdetail LEFT JOIN users
                            ON users.userId = driverdetail.userId WHERE
          driverStatus = "1" AND 
        latitude BETWEEN ('.$latitude.' - ('.$miles.'*0.018)) AND ('.$latitude.' + ('.$miles.'*0.018)) AND
        longitude BETWEEN ('.$longitude.' - ('.$miles.'*0.018)) AND ('.$longitude.' + ('.$miles.'*0.018))');
         
        $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
        $data= array( 'drivers'=>$drivers,'ErrorDetail'=>$ErrorDetail);
        $array=array('Data' => $data,'Result'=>1);
        return  response()->json(array('array'=>$array), 200);
    }

    //Here we can able to check if Driver Already Accept Booking or not
    public function checkAcceptedBooking(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'userId' => 'required'
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
            try
            {
               $booking=Bookings::where('driverId',$request->userId)->Where('rideStatus','=','6')->orWhere('rideStatus','=','3')->first();
               $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                $array=array('booking'=>$booking,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
                return  response()->json(array('array'=>$array), 200);
            }
            catch(QueryException $ex)
            {
                
                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>$ex->getMessage()];
                $data= array('ErrorDetail'=>$ErrorDetail);
                $array=array('Data' => $data,'Result'=>0);
                return  response()->json(array('SignUpResult'=>$array), 200); 
            }
        }
    }

    //update Booking Arrived Status bY Driver
    public function updateBookingStatus(Request $request)
    {
      //UserId of Driver
        $validation=Validator::make($request->all(), [
                                                            'userId' => 'required',
                                                            'bookingId'=>'required',
                                                            'passengerId'=>'required',
                                                            'rideStatus'=>'required'
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
            try
            {
                //Driver Arrived at Customer Pickup

                if ($request->rideStatus == '8') 
                {
                   $booking=Bookings::where(['bookingId'=>$request->bookingId,'driverId'=>$request->userId,'rideStatus'=>'6'])->update(['rideStatus'=>'8']);

                }//Start the Trip
                elseif ($request->rideStatus == '3')
                {
                     $carbon=Carbon::now();
                     $date=$carbon->year."-".$carbon->month."-".$carbon->day;
                     $time=$carbon->hour.":".$carbon->minute.":".$carbon->second;
                    $booking=Bookings::where(['bookingId'=>$request->bookingId,'driverId'=>$request->userId,'rideStatus'=>'8'])->update(['rideStatus'=>'3','rideStartDate'=>date('Y-m-d'),'rideStartTime'=>date('H:i:s')]);
                }//End Trip
               
                
                if ($booking==1)
                {
                    $user=Users::select('deviceToken')->where('userId',$request->passengerId)->first();

                     if (!empty($user->deviceToken)) 
                     {
                      
                      if ($request->rideStatus == '8') 
                      {
                         $notifyResponse=Notification::notify(array($user->deviceToken), 'Driver Arrived' , "your driver is arrived Waiting outside", '1', 'Arrived');
                                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Driver is Arrived But notification not send to Customer not correct token"];

                      }
                      elseif ($request->rideStatus == '3') {
                           $notifyResponse=Notification::notify(array($user->deviceToken), 'Trip Started' , "your Trip is Started", '1', 'Started');
                                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Trip is started But notification not send to Customer not correct token"];

                      }
                      
                           

                           $notifyResult=json_decode($notifyResponse);
                           if ($notifyResult->success==1) 
                           {
                                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                $array=array('rideStatus'=>$request->rideStatus,'ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
                                return  response()->json(array('array'=>$array), 200);
                           }
                           elseif ($notifyResult->success==0) 
                           {
                               $array=array('rideStatus'=>$request->rideStatus ,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
                               return  response()->json(array('array'=>$array), 200);
                           }
                     }
                     else
                     {
                        if ($request->rideStatus == '8') 
                        $ErrorDetail=['ErrorDetails'=>"Device Token is empty",'ErrorMessage'=>"Driver is Arrived But notification not send to Customer token empty"];
                        elseif ($request->rideStatus == '3')
                        $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Trip is started But notification not send to Customer not correct token"];
                    
                       $array=array('rideStatus'=>$request->rideStatus,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
                       return  response()->json(array('array'=>$array), 200);
                     }
                 }
                 else
                 {
                    $ErrorDetail=['ErrorDetails'=>"Driver is already arrived",'ErrorMessage'=>"Driver Arrived"];
                    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                    return  response()->json(array('array'=>$array), 200);
                 } 
                
            }
            catch(QueryException $ex)
            {
                
                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>$ex->getMessage()];
                $data= array('ErrorDetail'=>$ErrorDetail);
                $array=array('Data' => $data,'Result'=>0);
                return  response()->json(array('SignUpResult'=>$array), 200); 
            }
        }
    }

    

    public function endTrip(Request $request)
    {
      //UserId of Driver
        $validation=Validator::make($request->all(), [
                                                            'userId' => 'required',
                                                            'bookingId'=>'required',
                                                            'passengerId'=>'required',
                                                            'rideStatus'=>'required',
                                                            'Actual_TripTotal'=>'required',
                                                            'actualDistance'=>'required',
                                                            'EndTripLatLng'=>'required',
                                                            'actualTime'=>'required',

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
            try
            {

               if ($request->rideStatus == '4') 
                {
                  // $carbon=Carbon::now();
                  // $date=$carbon->year."-".$carbon->month."-".$carbon->day;
                  // $time=$carbon->hour.":".$carbon->minute.":".$carbon->second;
                  $user=Users::select('deviceToken')->where('userId',$request->passengerId)->first();
                  
                  $booking=Bookings::where(['bookingId'=>$request->bookingId,'driverId'=>$request->userId,'rideStatus'=>'3'])
                                    ->update([    
                                                'rideStatus'=>'4',
                                                'rideEndDate'=>date('Y-m-d'),
                                                'rideEndTime'=>date('H:i:s'),
                                                'Actual_TripTotal'=>$request->Actual_TripTotal,
                                                'actualDistance'=>$request->actualDistance,
                                                'EndTripLatLng'=>$request->EndTripLatLng,
                                                'actualTime'=>$request->actualTime
                                              ]);
                    $input=$request->all();

                   $notifyResponse=Notification::notify(array($user->deviceToken), 'your Trip has Been Ended' , $input, '1', 'Ended');

                           $notifyResult=json_decode($notifyResponse);
                           if ($notifyResult->success==1) 
                           {
                                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                $array=array('rideStatus'=>'4','ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
                                return  response()->json(array('array'=>$array), 200);
                           }
                           elseif ($notifyResult->success==0)
                           {
                               $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Booking is accepted But notification not send to Customer"];
                               $array=array('rideStatus'=>'4','ErrorDetail'=>$ErrorDetail,'Result'=>1);
                               return  response()->json(array('array'=>$array), 200);
                           }
                }
            }
            catch(QueryException $ex)
            {
                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>$ex->getMessage()];
                $data= array('ErrorDetail'=>$ErrorDetail);
                $array=array('Data' => $data,'Result'=>0);
                return  response()->json(array('SignUpResult'=>$array), 200); 
            }
        }
    }

    
    function driverRating(Request $request)
    {
         $validation=Validator::make($request->all(), [
                                                            'driverId' => 'required',
                                                            'passengerId'=>'required',
                                                            'rate'=>'required',
                                                            'review'=>'required',
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
            $input['passangerId']=$request->passengerId;
            $input['rate']=$request->rate;
            $input['review']=$request->review;
            $input['status']=1;
            $input['bookingId']=$request->bookingId;
            DriverRating::create($input);
            
            $rating=DriverRating::where('driverId',$request->driverId)->avg('rate');
            Drivers::where('userId',$request->driverId)->update(['rating'=>$rating]);
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
            return  response()->json(array('array'=>$array), 200);
        }
    }


    public function dateTime()
    {
        $carbon=Carbon::now();
        return $carbon->hour.":".$carbon->minute.":".$carbon->second;
    }

}   
