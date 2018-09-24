<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

use Validator;
use App\Model\Users;
use App\Model\PassengerDetails;
use App\Model\Drivers;
use App\Model\VehicleDetails;
use App\Model\Bookings;
use App\Model\Notification;
use App\Model\BookingDetails;

//*****Created By Usman Abbas*******//

class BookingController extends Controller
{
	//2:confirm //3:start //6:on the way
	public function checkExistedBooking(Request $request)
	{
		$validation=Validator::make($request->all(),[
    													'passengerId'=>'required'
											        ]);
		if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Driver Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        else
        {
        	$bookings=Bookings::where('passengerId',$request->passengerId)->whereIn('rideStatus',array(2,3,6))->get();
        	if (!empty($bookings))
        	{
        		$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
			    $array=array('Booking'=>$bookings,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
			    return  response()->json(array('array'=>$array), 200);
        	}
        	else
        	{
        		$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Booking not existed"];
			    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
			    return  response()->json(array('array'=>$array), 200);
        	}
        }							          	
	}

    public function createBooking(Request $request)
    {
      	$validation=Validator::make($request->all(), [
      														      
                                        'passengerId'=>'required',
  											                'pickupAddress' => 'required',
  											                'destinationAddress'=>'required',
  											                'pickupLatLong'=>'required',
  											                'destinationLatLong'=>'required',
  											                'tripTotal'=>'required',
  											                'vehichleId'=>'required',
  											                'paymentType'=>'required',
  											                'distance'=>'required',
  											                'rideType'=>'required',
  											          ]);		          
          if($validation->fails())
          {
              $errors = $validation->errors();
              $ErrorDetail=['ErrorDetails'=>"Error in Driver Registration",'ErrorMessage'=> $errors->toJson()];
              $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
              return  response()->json(array('array'=>$array), 200);
          }
          else
          {
          	$input=$request->all();
          	$rideStartDate = $request->rideStartDate;
      			if(empty($rideStartDate)){ $rideStartDate = date("Y-m-d", strtotime($rideStartDate)); }
      			$rideStartTime = $request->rideStartTime;
      			if(empty($rideStartTime)){ $rideStartTime = date("H:i:s", strtotime($rideStartTime)); }
              	
              $input['rideStartDate']=$rideStartDate;
              $input['rideStartTime']=$rideStartTime;
              
          		$booking=Bookings::create($input);
          		$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
      		    $array=array('Booking'=>$booking,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
      		    return  response()->json(array('array'=>$array), 200);
          }
    }

    
    
     
    public function bookingNotificationToDriver(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'userId'=>'required',
                                                            'bookingId'=>'required',
                                                            'passengerName'=>'required'
                                                      ]);                 
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Booking Request",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        else
        {

           $driver=Drivers::select('driverStatus')->where('userId',$request->userId)->first();
          if ($driver->driverStatus == '3' || $driver->driverStatus == '2')
          {
              $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Driver Already Accept the Request"];
              $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
              return  response()->json(array('array'=>$array), 200);
          } 
          else
          {
              $driver=Users::select('deviceToken', 'deviceType')->where(['userId'=>$request->userId,'userType'=>'driver'])->first();
              if (!empty($driver))
              {
                    // ->select('bookings.bookingId','bookings.distance','bookings.pickupAddress','bookings.destinationAddress','bookings.pickupLatLong','bookings.destinationLatLong','bookings.rideStartDate','bookings.rideStartTime','bookings.rideStatus','bookings.paymentType','bookings.passengerId','passengerdetail.fullName','passengerdetail.mobileNumber','bookings.tripTotal as price')
                    //                                       ->leftJoin('passengerdetail', 'bookings.passengerId', '=', 'passengerdetail.userId')
                  $Result=Bookings::where('bookingId',$request->bookingId)->first();

                       if (!empty($driver->deviceToken)) 
                       {
                              $notifyResponse=Notification::notify(array($driver->deviceToken), $Result->passengerName.' send you Booking Request' , $Result, '1', 'request');
                     
                                 $notifyResult=json_decode($notifyResponse);
                              
                                 if ($notifyResult->success==1) 
                                 {
                                     BookingDetails::create(['bookingId'=>$request->bookingId,'driverId'=>$request->userId]);
                                      $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                      $array=array('booking'=>$Result,'ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
                                      return  response()->json(array('array'=>$array), 200);
                                 }
                                 else
                                 {
                                     $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                     $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
                                     return  response()->json(array('array'=>$array), 200);
                                 }
                       }
                       else
                       {
                          $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"device token is empty"];
                         $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                         return  response()->json(array('array'=>$array), 200);
                       }  
                      
             }
         }

        }
    }


// Here driver can accept passengers Booking 
    public function acceptPassengerBooking(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'userId'=>'required',
                                                            'bookingId'=>'required',
                                                            'passengerId'=>'required'
                                                      ]);                 
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Booking Request",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        else
        {
            try
            {
                    

                
                    $booking=Bookings::where('bookingId',$request->bookingId)->first();
                    if ($booking->driverId == 0 && $booking->rideStatus==1)
                    {
                        Bookings::where('bookingId',$request->bookingId)->update(['driverId'=>$request->userId,'rideStatus'=>'6']);
                        Drivers::where('userId',$request->userId)->update(['driverStatus'=>'3']);
                        $user=Users::where('userId',$booking->passengerId)->first();
                        $driver=Drivers::where('driverdetail.userId',$request->userId)
                                        ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')
                                        ->leftJoin('vehicledetail', 'driverdetail.driveId', '=', 'vehicledetail.driverId')
                                        ->select('driverdetail.fullName', 'driverdetail.mobileNumber','driverdetail.rating','users.profileImage','vehicledetail.vehicleModel','vehicledetail.company', 'vehicledetail.brands','vehicledetail.colour','vehicledetail.plateLetterRight', 'vehicledetail.plateLetterMiddle', 'vehicledetail.plateLetterLeft','vehicledetail.plateNumber')->first();
                        
                        $data=['booking'=>$booking,'driver'=>$driver];
                        if (!empty($user->deviceToken)) 
                         {
                            $booking->driverId=$request->userId;
                            $booking->rideStatus='6';
                               $notifyResponse=Notification::notify(array($user->deviceToken), 'your Request is Being Accepted' , $data, '1', 'Accepted');

                               $notifyResult=json_decode($notifyResponse);
                               if ($notifyResult->success==1) 
                               {
                                    $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                    $array=array('user'=>$user,'rideStatus'=>'6','ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
                                    return  response()->json(array('array'=>$array), 200);
                               }
                               elseif ($notifyResult->success==0)
                               {
                                   $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Booking is accepted But notification not send to Customer"];
                                   $array=array('user'=>$user,'rideStatus'=>'6','ErrorDetail'=>$ErrorDetail,'Result'=>1);
                                   return  response()->json(array('array'=>$array), 200);
                               }
                         }
                         else
                         {
                            $ErrorDetail=['ErrorDetails'=>"Device Token is empty",'ErrorMessage'=>"Booking is accepted But notification not send to Customer"];
                           $array=array('user'=>$user,'rideStatus'=>'6','ErrorDetail'=>$ErrorDetail,'Result'=>1);
                           return  response()->json(array('array'=>$array), 200);
                         } 

                    }
                    else
                    {
                        $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Sorry Booking is already Accepted or Cancelled"];
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


    public function preCancel(Request $request)
    {
         $validation=Validator::make($request->all(), [
                                                            'passengerId'=>'required',
                                                            'bookingId'=>'required',
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in cancel request",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        else
        {
           
              $data=Bookings::where(['bookingId'=>$request->bookingId,'passengerId'=>$request->passengerId])->update(['rideStatus'=>7]);
              
              
              if ($data == 1)
              {
                  $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                  $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$data);
                  return  response()->json(array('array'=>$array), 200);
              }
            
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
    }

    public function cancelRequest(Request $request)
    {
      //driverId= UserId in this we are taking driverId As userId
        $validation=Validator::make($request->all(), [
                                                            'passengerId'=>'required',
                                                            'bookingId'=>'required',
                                                            'reason'=>'required',
                                                            'driverId'=>'required',
                                                            'rejectBy' => 'required'
                                                      ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in cancel request",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        else
        {
            //If the request is new we delete
            if ($request->rejectBy=='P') 
            {
              $data=Bookings::where(['bookingId'=>$request->bookingId,'passengerId'=>$request->passengerId])->update(['rideStatus'=>5,'rejectBy'=>'P','reason'=>$request->reason]);
              $driver=Users::select('deviceToken')->where(['userId'=>$request->driverId,'userType'=>'driver'])->first();
              Drivers::where('userId',$request->driverId)->update(['driverStatus'=>'1']);
              if ($data == 1)
              {
                  if ($driver) 
                  {
                      $notifyResponse=Notification::notify(array($driver->deviceToken),'Passenger Cancelled the Booking' , '', '1', 'Cancelled');
                  }
                  $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                  $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
                  return  response()->json(array('array'=>$array), 200);
              }
            }
            else
            {
              $data=Bookings::where(['bookingId'=>$request->bookingId,'driverId'=>$request->driverId])
                            ->update(['rideStatus'=>5,'rejectBy'=>'D','reason'=>$request->reason]);
             
              $passenger=Users::select('deviceToken')->where(['userId'=>$request->passengerId,'userType'=>'passenger'])->first();
              Drivers::where('userId',$request->driverId)->update(['driverStatus'=>'1']);
              if ($data == 1)
              {
                  if ($passenger) 
                  {
                      $notifyResponse=Notification::notify(array($passenger->deviceToken),'Driver Cancelled your Booking' , '', '1', 'Cancelled');
                  }
                  $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                  $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
                  return  response()->json(array('array'=>$array), 200);
              }
            }
          

            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
    }


}