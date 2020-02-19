<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PushNotification;

use Validator;
use App\Model\Users;
use App\Model\PassengerDetails;
use App\Model\Drivers;
use App\Model\VehicleDetails;
use App\Model\Bookings;
use App\Model\Notification;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
    	$validation=Validator::make($request->all(), [
                                                            'userId'=>'required',
                                                            'title'=>'required',
                                                            'message'=>'required',
                                                            'userType'=>'required',
                                                            'requestType' => 'required'
                                                      ]);
    	 if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
        
    	$user=Users::select('deviceToken')->where('userId',$request->userId)->first();
    	if (!empty($user)) 
    	{
    		 $notifyResponse=Notification::notify(array($user->deviceToken), $request->title , $request->message, $request->userType, $request->requestType);
                           $notifyResult=json_decode($notifyResponse);
                           if ($notifyResult->success==1) 
                           {
                                $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
                                $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$notifyResult->success);
                                return  response()->json(array('array'=>$array), 200);
                           }
                           elseif ($notifyResult->success==0)
                           {
                               $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Device Token of receiver is not corrent cant send the notification"];
                               $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                               return  response()->json(array('array'=>$array), 200);
                           }
    	}
    	else
    	{
    		 $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Device Token of receiver is empty cant send the notification"];
                   $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
                   return  response()->json(array('array'=>$array), 200);
    	}
    }

    public function sendNotificationiOS(Request $request)
    {
        $validation=Validator::make($request->all(), [
                                                              'userId'=>'required',
                                                              'message'=>'required',
                                                              'requestType' => 'required'
                                                        ]);
         if($validation->fails())
          {
              $errors = $validation->errors();
              $ErrorDetail=['ErrorDetails'=>"Error in Registration",'ErrorMessage'=> $errors->toJson()];
              $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
              return  response()->json(array('array'=>$array), 200);
          }
        $user=Users::select('deviceToken')->where('userId',$request->userId)->first();
        if (!empty($user)) 
        {

          $result=Notification::notifyiOS($user->deviceToken,$request->message,'',$request->requestType);
          $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
          $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>$result);
          return  response()->json(array('array'=>$array), 200);

        }
        else
        {
             $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Device Token of receiver is empty cant send the notification"];
             $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
             return  response()->json(array('array'=>$array), 200);
        }
    }

   
}
