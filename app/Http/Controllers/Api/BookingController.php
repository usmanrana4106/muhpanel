<?php

namespace App\Http\Controllers\Api;

use App\Model\Verion;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Log;
use Validator;


use App\Model\Users;
use App\Model\PassengerDetails;
use App\Model\Drivers;
use App\Model\VehicleDetails;


use App\Model\Bookings\Bookings;
use App\Model\Bookings\BookingDetails;
use App\Model\Bookings\BookingBroadCasting;
use App\Model\Bookings\BookingProgress;
use App\Model\Bookings\BookingComplete;


use App\Model\Notification;


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

	public function getdistance()
    {
        $distance=Verion::where('id',100)->first();
        $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
        $array=array('distance'=>$distance,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
        return  response()->json(array('array'=>$array), 200);
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
            try
            {

                $input=$request->all();
                $rideStartDate = $request->rideStartDate;
                if(empty($rideStartDate)){ $rideStartDate = date("Y-m-d"); }
                $rideStartTime = $request->rideStartTime;
                if(empty($rideStartTime)){ $rideStartTime = date("H:i:s"); }

                $input['rideStartDate']=$rideStartDate;
                $input['rideStartTime']=$rideStartTime;

                $booking=BookingBroadCasting::create($input);

                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                $array=array('Booking'=>$booking,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
                return  response()->json(array('array'=>$array), 200);
            }
            catch(QueryException $ex)
            {
                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>$ex->getMessage()];
                $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                return  response()->json(array('array'=>$array), 200);
            }

          }
    }




    public function bookingNotificationToDriver(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                            'userId'=>'required',
                                                            'bookingId'=>'required',
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
                  $Result=BookingBroadCasting::select('bookingId','pickupLatLong','passengerId')->where('bookingId',$request->bookingId)->first();
                    if (!empty($Result))
                    {
                        $driver=Users::select('deviceToken', 'deviceType')->where(['userId'=>$request->userId,'userType'=>'driver'])->first();

                         if (!empty($driver->deviceToken))
                         {
//                             $driverdetail=Drivers::where('userId',$request->userId)->first();
//                             if($driverdetail->identityProofStatus==0 || $driverdetail->licenceNumberStatus==0)
//                             {
//                                 if ($driver->deviceType== 1)
//                                 {
//                                     $notifyResponse=Notification::notify(array($driver->deviceToken), 'You have recived new Booking Request' , $Result, '1', 'request');
//
//                                     $notifyResult=json_decode($notifyResponse);
//                                     if ($notifyResult->success==1)
//                                     {
//                                         BookingDetails::create(['bookingId'=>$request->bookingId,'driverId'=>$request->userId]);
//                                         $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
//                                         $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
//                                         return  response()->json(array('array'=>$array), 200);
//                                     }
//                                     else
//                                     {
//                                         $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
//                                         $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
//                                         return  response()->json(array('array'=>$array), 200);
//                                     }
//                                 }
//                                 else
//                                 {
//                                     $result=Notification::notifyiOS($driver->deviceToken,'You have recived new Booking Request',$Result,'request');
//                                     if ($result==1)
//                                     {
//                                         BookingDetails::create(['bookingId'=>$request->bookingId,'driverId'=>$request->userId]);
//                                         $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
//                                         $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$result);
//                                         return  response()->json(array('array'=>$array), 200);
//                                     }
//                                     else
//                                     {
//                                         $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
//                                         $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$result);
//                                         return  response()->json(array('array'=>$array), 200);
//                                     }
//                                 }
//                             }

                            if ($driver->deviceType== 1)
                            {
                                  $notifyResponse=Notification::notify(array($driver->deviceToken), 'You have recived new Booking Request' , $Result, '1', 'request');

                                     $notifyResult=json_decode($notifyResponse);
                                     if ($notifyResult->success==1)
                                     {
                                         BookingDetails::create(['bookingId'=>$request->bookingId,'driverId'=>$request->userId]);
                                          $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                          $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
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
                              $result=Notification::notifyiOS($driver->deviceToken,'You have recived new Booking Request',$Result,'request');
                              if ($result==1)
                              {
                                BookingDetails::create(['bookingId'=>$request->bookingId,'driverId'=>$request->userId]);
                                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$result);
                                return  response()->json(array('array'=>$array), 200);
                              }
                              else
                              {
                                 $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                 $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$result);
                                 return  response()->json(array('array'=>$array), 200);
                              }
                            }

                         }
                         else
                         {
                            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"device token is empty"];
                            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                            return  response()->json(array('array'=>$array), 200);
                         }

                    }
                    else
                    {
                        $ErrorDetail=['ErrorDetails'=>"sending Booking Error",'ErrorMessage'=>"Booking is already Accepted or cancel"];
                        $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                        return  response()->json(array('array'=>$array), 200);
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
            return  response()->json(array('array'=>$array), 200 );
        }
        else
        {
            try
            {
                $booking=BookingBroadCasting::where(['bookingId'=>$request->bookingId,
                                                      'passengerId'=>$request->passengerId])->first();
                //Log::info(json_encode($request->all()));
//                Log::info("idr ha Code");
                if (!empty($booking))
                {
                   $bookingProgress=[
                                        'bookingId'=>$booking->bookingId,
                                        'passengerId'=>$booking->passengerId,
                                        'pickupAddress' =>$booking->pickupAddress,
                                        'destinationAddress'=>$booking->destinationAddress,
                                        'pickupLatLong'=>$booking->pickupLatLong,
                                        'destinationLatLong'=>$booking->destinationLatLong,
                                        'tripTotal'=>$booking->tripTotal,
                                        'vehichleId'=>$booking->vehichleId,
                                        'paymentType'=>$booking->paymentType,
                                        'distance'=>$booking->distance,
                                        'rideType'=>$booking->rideType,
                                        'rideStatus'=>$booking->rideStatus,
                                        'rideStartDate'=>$booking->rideStartDate,
                                        'rideStartTime'=>$booking->rideStartTime,
                                        'driverId'=>$request->userId,
                                        'rideStatus'=>'6',
                                   ];
                   if (!empty($request->companyId))
                   {
                       $bookingProgress['companyId']=$request->companyId;
                   }

                    BookingProgress::create($bookingProgress);
                    BookingBroadCasting::where('bookingId',$request->bookingId)->delete();
                    Drivers::where('userId',$request->userId)->update(['driverStatus'=>'3']);
                    BookingDetails::where(['bookingId'=>$request->bookingId,'driverId'=>$request->userId])->update(['driverStatus'=>'1']);
                    $user=Users::where('userId',$booking->passengerId)->first();
                     if (!empty($user->deviceToken))
                     {
                        $data=['bookingId'=>$booking->bookingId];

                           if ($user->deviceType== 1)
                           {
                              $notifyResponse=Notification::notify(array($user->deviceToken), 'your Request is Being Accepted' , $data, '1', 'Accepted');
                              $notifyResult=json_decode($notifyResponse);
                             if ($notifyResult->success==1)
                             {
                                  $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                  $array=array('user'=>$user,'booking'=>$bookingProgress,'ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
                                  return  response()->json(array('array'=>$array), 200);
                             }
                             elseif ($notifyResult->success==0)
                             {
                                 $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Booking is accepted But notification not send to Customer"];
                                 $array=array('user'=>$user,'booking'=>$bookingProgress,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
                                 return  response()->json(array('array'=>$array), 200);
                             }
                          }
                          else
                          {
                              $result=Notification::notifyiOS($user->deviceToken,'your Request is Being Accepted',$data,'Accepted');
                              if ($result==1)
                              {
                                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                  $array=array('user'=>$user,'booking'=>$bookingProgress,'ErrorDetail'=>$ErrorDetail,'Result'=>$result);
                                  return  response()->json(array('array'=>$array), 200);
                              }
                              else
                              {
                                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Booking is accepted But notification not send to Customer"];
                                 $array=array('user'=>$user,'booking'=>$bookingProgress,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
                                 return  response()->json(array('array'=>$array), 200);
                              }
                          }
                     }
                     else
                     {
                        $ErrorDetail=['ErrorDetails'=>"Device Token is empty",'ErrorMessage'=>"Booking is accepted But notification not send to Customer"];
                       $array=array('user'=>$user,'booking'=>$bookingProgress,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
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

    public function getBooking(Request $request)
    {
        $validation=Validator::make($request->all(), [
            'userId'=>'required',
        ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Booking Parameters",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        if (!empty($request->bookingId))
        {
            $booking=bookingProgress::where(['bookingId'=>$request->bookingId,'driverId'=>$request->userId])->first();
        }
        else
        {
            $booking=bookingProgress::where(['driverId'=>$request->userId])->orderBy('crd','desc')->first();
        }
        if (!empty($booking))
        {
            $booking_date_time=$booking->crd;
            $booking_date_time=explode(' ',$booking_date_time);

            $mytime = \Carbon\Carbon::now();
            $current_timestamp=$mytime->toDateTimeString();

            $current_timestamp=explode(' ',$current_timestamp);

            $today_date=date('Y-m-d');
            $current_time=date("h:i:s", time());

            $start_datetime = new DateTime($booking_date_time[0].' '.$booking_date_time[1]);
            $end_datetime = new DateTime($today_date.' '.$current_timestamp[1]);

            //echo date("h:i:s", time());
            $total_difference_time=$start_datetime->diff($end_datetime);
            // print_r($total_difference_time);



                if ($total_difference_time->h > 12)
                {
                    Drivers::where('userId',$request->userId)->update(['driverStatus'=>1]);
                    $users=Users::where('userId',$request->userId)->first();
                    Drivers::silentNotification($users->deviceType,$users->deviceToken);

                    Drivers::sendBookingtoCancel_or_confict($booking);
                    Log::info("Free Driver on: "."hours: ".$total_difference_time->h." days: ".$total_difference_time->d." BookingID: ".$booking->bookingId);
                    $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"hours: ".$total_difference_time->h." days: ".$total_difference_time->d];
                    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>2);
                    return  response()->json(array('array'=>$array), 200);
                }



            $bookingProgress=[
                'bookingId'=>$booking->bookingId,
                'passengerId'=>$booking->passengerId,
                'pickupAddress' =>$booking->pickupAddress,
                'destinationAddress'=>$booking->destinationAddress,
                'pickupLatLong'=>$booking->pickupLatLong,
                'destinationLatLong'=>$booking->destinationLatLong,
                'tripTotal'=>$booking->tripTotal,
                'vehichleId'=>$booking->vehichleId,
                'paymentType'=>$booking->paymentType,
                'distance'=>$booking->distance,
                'rideType'=>$booking->rideType,
                'rideStatus'=>$booking->rideStatus,
                'rideStartDate'=>$booking->rideStartDate,
                'rideStartTime'=>$booking->rideStartTime,
                'driverId'=>$request->userId,
                'rideStatus'=>"$booking->rideStatus"
            ];
            $user=Users::where('userId',$booking->passengerId)->first();
            $user->email="empty";
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('user'=>$user,'booking'=>$bookingProgress,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
            return  response()->json(array('array'=>$array), 200);
        }
        else
        {

            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Sorry Booking is not Avaliable!!!"];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
    }


    public function getBookingDetails($bookingId)
    {
        $booking=bookingProgress::where(['bookingId'=>$bookingId])->first();
        if(!empty($booking)){
            $passenger=PassengerDetails::where('userId',$booking->passengerId)->select('userId', 'fullName', 'mobileNumber')->first();
        }
        else
        {
            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
        $array=array('ErrorDetail'=>$ErrorDetail,'booking'=>$booking,'passenger'=>$passenger,'Result'=>1);
        return  response()->json(array('array'=>$array), 200);
    }






    public function getDriversDetails(Request $request)
    {
        $validation=Validator::make($request->all(), [

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
           $booking=BookingProgress::where(['bookingId'=>$request->bookingId,'passengerId'=>$request->passengerId])->first();
           if (!empty($booking))
           {

                $driver=Drivers::where('driverdetail.userId',$booking->driverId)
                                ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')
                                ->leftJoin('vehicledetail', 'driverdetail.driveId', '=', 'vehicledetail.driverId')
                                ->select('driverdetail.fullName', 'driverdetail.mobileNumber','users.profileImage','driverdetail.rating','users.profileImage','vehicledetail.vehicleModel','vehicledetail.company', 'vehicledetail.brands','vehicledetail.colour','vehicledetail.plateLetterRight', 'vehicledetail.plateLetterMiddle', 'vehicledetail.plateLetterLeft','vehicledetail.plateNumber')->first();
                $driver->rating=round($driver->rating,2);
                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                $array=array('driver'=>$driver,'booking'=>$booking,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
                return  response()->json(array('array'=>$array), 200);

           }
           else
           {
               $booking=BookingComplete::where(['bookingId'=>$request->bookingId,'passengerId'=>$request->passengerId])->first();
               if (!empty($booking))
               {
                   $driver=Drivers::where('driverdetail.userId',$booking->driverId)
                       ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')
                       ->leftJoin('vehicledetail', 'driverdetail.driveId', '=', 'vehicledetail.driverId')
                       ->select('driverdetail.fullName', 'driverdetail.mobileNumber','users.profileImage','driverdetail.rating','users.profileImage','vehicledetail.vehicleModel','vehicledetail.company', 'vehicledetail.brands','vehicledetail.colour','vehicledetail.plateLetterRight', 'vehicledetail.plateLetterMiddle', 'vehicledetail.plateLetterLeft','vehicledetail.plateNumber')->first();
                   $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                   $array=array('driver'=>$driver,'booking'=>$booking,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
                   return  response()->json(array('array'=>$array), 200);

               }
               else
               {
                   $ErrorDetail=['ErrorDetails'=>"Booking Not Avaliable",'ErrorMessage'=>"Booking is not Avaliable"];
                   $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                   return  response()->json(array('array'=>$array), 200);
               }
           }
        }
    }




    public function notAccepted(Request $request)
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
            $booking=BookingBroadCasting::where(['bookingId'=>$request->bookingId,'passengerId'=>$request->passengerId])->first();
            if (!empty($booking))
            {
               $input=[
                        'bookingId'=>$booking->bookingId,
                        'passengerId'=>$booking->passengerId,
                        'pickupAddress' =>$booking->pickupAddress,
                        'destinationAddress'=>$booking->destinationAddress,
                        'pickupLatLong'=>$booking->pickupLatLong,
                        'destinationLatLong'=>$booking->destinationLatLong,
                        'tripTotal'=>$booking->tripTotal,
                        'vehichleId'=>$booking->vehichleId,
                        'paymentType'=>$booking->paymentType,
                        'distance'=>$booking->distance,
                        'rideType'=>$booking->rideType,
                        'rideStatus'=>2,
                        'rideStartDate'=>$booking->rideStartDate,
                        'rideStartTime'=>$booking->rideStartTime,

                    ];
              $data=Bookings::create($input);
              BookingBroadCasting::where(['bookingId'=>$request->bookingId,'passengerId'=>$request->passengerId])->delete();

                if (!empty($data))
                {
                    $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
                    return  response()->json(array('array'=>$array), 200);
                }
            }

            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Booking not Exist"];
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
                  $booking=BookingProgress::where(['bookingId'=>$request->bookingId,'passengerId'=>$request->passengerId])->first();
                  if (!empty($booking))
                  {
                      $input=[
                            'bookingId'=>$booking->bookingId,
                            'passengerId'=>$booking->passengerId,
                            'pickupAddress' =>$booking->pickupAddress,
                            'destinationAddress'=>$booking->destinationAddress,
                            'pickupLatLong'=>$booking->pickupLatLong,
                            'destinationLatLong'=>$booking->destinationLatLong,
                            'tripTotal'=>$booking->tripTotal,
                            'vehichleId'=>$booking->vehichleId,
                            'paymentType'=>$booking->paymentType,
                            'distance'=>$booking->distance,
                            'rideType'=>$booking->rideType,
                            'rideStatus'=>$booking->rideStatus,
                            'rideStartDate'=>$booking->rideStartDate,
                            'rideStartTime'=>$booking->rideStartTime,
                            'rideStatus'=>'5',
                            'rejectBy'=>'P',
                            'driverId'=>$request->driverId,
                            'reason'=>$request->reason
                        ];
                      if ($booking->companyId != 0)
                      {
                          $input['companyId']=$booking->companyId;
                      }

                  $data=Bookings::create($input);

                  BookingProgress::where(['bookingId'=>$request->bookingId,'passengerId'=>$request->passengerId])->delete();




                  $driver=Users::select('deviceToken','deviceType')->where(['userId'=>$request->driverId,'userType'=>'driver'])->first();
                  Drivers::where('userId',$request->driverId)->update(['driverStatus'=>'1']);
                  if (!empty($data))
                  {
                      if ($driver)
                      {
                          if ($driver->deviceType==1)
                          {
                            $notifyResponse=Notification::notify(array($driver->deviceToken),'Passenger Cancelled the Booking' , '', '1', 'Cancelled');
                          }
                          else
                          {
                              $result=Notification::notifyiOS($driver->deviceToken,'Passenger Cancelled the Booking','','Cancelled');
                          }
                      }
                      $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                      $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
                      return  response()->json(array('array'=>$array), 200);
                  }
              }
              else
              {
                    $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Booking is Already cancelled"];
                    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
                    return  response()->json(array('array'=>$array), 200);
              }

            }
            else
            {
                $booking=BookingProgress::where(['bookingId'=>$request->bookingId,'driverId'=>$request->driverId])->first();
                if (!empty($booking))
                  {
                      $input=[
                                  'bookingId'=>$booking->bookingId,
                                  'passengerId'=>$booking->passengerId,
                                  'pickupAddress' =>$booking->pickupAddress,
                                  'destinationAddress'=>$booking->destinationAddress,
                                  'pickupLatLong'=>$booking->pickupLatLong,
                                  'destinationLatLong'=>$booking->destinationLatLong,
                                  'tripTotal'=>$booking->tripTotal,
                                  'vehichleId'=>$booking->vehichleId,
                                  'paymentType'=>$booking->paymentType,
                                  'distance'=>$booking->distance,
                                  'rideType'=>$booking->rideType,
                                  'rideStatus'=>$booking->rideStatus,
                                  'rideStartDate'=>$booking->rideStartDate,
                                  'rideStartTime'=>$booking->rideStartTime,
                                  'rideStatus'=>'5',
                                  'rejectBy'=>'D',
                                 'driverId'=>$request->driverId,
                                 'reason'=>$request->reason
                        ];
                      if ($booking->companyId != 0)
                      {
                          $input['companyId']=$booking->companyId;
                      }
                  $data=Bookings::create($input);
                  BookingProgress::where(['bookingId'=>$request->bookingId,'passengerId'=>$request->passengerId])->delete();

                  $passenger=Users::select('deviceToken','deviceType')->where(['userId'=>$request->passengerId,'userType'=>'passenger'])->first();
                  Drivers::where('userId',$request->driverId)->update(['driverStatus'=>'1']);

                  if (!empty($data))
                  {
                      if ($passenger)
                      {
                          if ($passenger->deviceType==1)
                          {
                             $notifyResponse=Notification::notify(array($passenger->deviceToken),'Driver Cancelled your Booking' , '', '1', 'Cancelled');
                          }
                          else
                          {
                             $notifyResponse=Notification::notifyiOS($passenger->deviceToken,'Driver Cancelled your Booking','','Cancelled');
                          }

                      }
                      $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                      $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
                      return  response()->json(array('array'=>$array), 200);
                    }
                    else
                    {
                      $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Booking is Already cancelled"];
                      $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
                      return  response()->json(array('array'=>$array), 200);
                    }
                }
            }
        }
    }
}