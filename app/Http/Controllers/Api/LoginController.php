<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

use Validator;
use App\Model\Users;
use App\Model\PassengerDetails;
use App\Model\Drivers;
use App\Model\VehicleDetails;
use App\Model\CarFacility;
use App\Model\Entries;
use App\Model\EntryItem;
use App\Model\Group;
use App\Model\Ledger;
use App\Model\DriverWallet;
use App\Model\PassengerWallet;


//*****Created By Usman Abbas*******//

class LoginController extends Controller
{
	protected $url;

    public function __construct()
    {
        $this->url = URL::to('/');
    }

    public function userLogin(Request $request)
    {
    	$validation=Validator::make($request->all(), [
											                'imeiNumber' => 'required',
											                'deviceToken'=>'required',
											                'deviceType'=>'required'
											          ]);		          
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in USer Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }

    	if (!empty($request->email)) 
    	{
    		$user=Users::where(['email'=>$request->email,'userType'=>'passenger'])->first();
    	}
    	if (!empty($request->mobileNumber)) 
    	{
    		$user=Users::where(['mobileNumber'=>$request->mobileNumber,'userType'=>'passenger'])->first();	
    	}
    	if (empty($user))
    	{
    		$ErrorDetail=['ErrorDetails'=>"user does'nt Exist.",'ErrorMessage'=>""];
	        $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
	        return  response()->json(array('array'=>$array), 200);
    	}
    	else
    	{
    		if ($request->imeiNumber==$user->imeiNumber) 
	        {
	    		$authToken=$this->quickRandom();
	    		
	    		$user->deviceToken=$request->deviceToken;
	    		$user->deviceType=$request->deviceType;
	    		$user->authToken=$authToken;
	    		$passengerDetail=PassengerDetails::where('userId',$user->userId)->first();
	    		$user->passengerDetail=$passengerDetail;
	    		
	    		$Input=[
							'deviceToken'=>$request->deviceToken,
							'deviceType'=>$request->deviceType,
							'isLoggedIn'=>'1',
							'loginStatus'=>'1',
							'logTime'=>date('Y-m-d h:i:s'),
							'authToken'=>$authToken,
							
						];

	    		if($user->ledgerStatus=='0')
	    		{
	    			$selectgroup=Group::where('name','Passenger')->first();
        			$passengerGroupId=$selectgroup->id;
	    			//Creating Passenger Ledger 
		            $insertledger=[
			            				'group_id'=>$passengerGroupId,
			            				'name'=>$passengerDetail->fullName."/".$passengerDetail->userId,
			            				'code'=>$passengerDetail->userId,
			            				'op_balance'=>'0.00',
			            				'op_balance_dc'=>'D',
			            				'type'=>0,
			            				'reconciliation'=>1,
			            				'notes'=>''
		            				];
		            Ledger::create($insertledger);
		            $Input['ledgerStatus']=1;
	    		}

	    		if ($user->walletStatus=='0')
	    		{
	    			  PassengerWallet::create([
		                                              'userId'=>$user->userId,
		                                              'fullName'=>$passengerDetail->fullName,
		                                              'totalPay' => 0.0,
		                                              'totalPay' => 0.0,
		                                              'credit' => 0.0,
		                                              'due' => 0.0
                                         		]);
	    			  
	    			  $Input['walletStatus']=1;
	    		}

	    		Users::where('userId',$user->userId)->update($Input);
	    		if ($user->profileImage)
	    		{
	    		   $user->profileImage=$this->url."/uploads/images/passengerImage/".$user->profileImage;
	    		}

	    		$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
		        $array=array('UserDetail'=>$user,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
		        return  response()->json(array('array'=>$array), 200);
	    	}
    	    else
		    {
		    	$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Imei is Not Matching."];
		        $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>2);
		        return  response()->json(array('array'=>$array), 200);
		    }

    	}
    }

    public function driverLogin(Request $request)
    {
    	
    	$validation=Validator::make($request->all(), [
											                'imeiNumber' => 'required',
											                'deviceToken'=>'required',
											                'deviceType'=>'required'

											          ]);		          
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Driver Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
    	if (!empty($request->email)) 
    	{
    		$user=Users::where(['email'=>$request->email,'userType'=>'driver'])->first();
    	}
    	if (!empty($request->mobileNumber)) 
    	{
    		$user=Users::where(['mobileNumber'=>$request->mobileNumber,'userType'=>'driver'])->first();	
    	}


    	if (empty($user))
    	{
    		$ErrorDetail=['ErrorDetails'=>"Driver does'nt Exist.",'ErrorMessage'=>"Driver data does'nt Exist."];
	        $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
	        return  response()->json(array('array'=>$array), 200);
    	}
    	else
    	{
    		if ($request->imeiNumber == $user->imeiNumber) 
	        {
	        	$authToken=$this->quickRandom();
	    		
	    		$user->deviceToken=$request->deviceToken;
	    		$user->deviceType=$request->deviceType;
	    		$user->authToken=$authToken;

	    		//cardetail //vehicle detail //driver detail

	    		$driverDetail=Drivers::where('userId',$user->userId)
	    		            ->leftJoin('vehicledetail', 'driverdetail.driveId', '=', 'vehicledetail.driverId')
	    		            ->leftJoin('cardetail', 'vehicledetail.vihicleType', '=', 'cardetail.carId')->first();

	    		$updateUser=[
								'deviceToken'=>$request->deviceToken,
								'deviceType'=>$request->deviceType,
								'isLoggedIn'=>'1',
								'loginStatus'=>'1',
								'logTime'=>date('Y-m-d h:i:s'),
								'authToken'=>$authToken
							];

	    		if($user->ledgerStatus=='0')
	    		{
	    			$selectgroup=Group::where('name','Driver')->first();
        			$drivergroupid=$selectgroup->id;

	    			//Creating Driver Ledger 
		            $insertledger=[
			            				'group_id'=>$drivergroupid,
			            				'name'=>$driverDetail->fullName."/".$driverDetail->userId,
			            				'code'=>$driverDetail->userId,
			            				'op_balance'=>'0.00',
			            				'op_balance_dc'=>'D',
			            				'type'=>0,
			            				'reconciliation'=>1,
			            				'notes'=>''
		            				];
		            Ledger::create($insertledger);
		            $updateUser['ledgerStatus']=1;
	    		}

	    		if ($user->walletStatus=='0')
	    		{
	    			  DriverWallet::create([
                                              'driverId'=>$user->userId,
                                              'fullName'=>$driverDetail->fullName,
                                              'totalPay'=>0.0,
                                              'totalVatPaid'=>0.0,
                                              'totalEarn'=> 0,
                                              'currCash'=> 0,
                                              'currentEarn'=> 0,
                                              'currCompanyProfit'=> 0, 
                                              'currVat'=> 0
                                         ]);
	    			  
	    			  $updateUser['walletStatus']=1;
	    		}
	    		

	    		Users::where('userId',$user->userId)->update($updateUser);



		        $driverDetail->carFacility=CarFacility::driversCarFacility($driverDetail->carFacility);
			    $user->driverDetail=$driverDetail;
			    if ($user->profileImage)
	    		{
	    		   $user->profileImage=$this->url."/uploads/images/driverImage/".$user->profileImage;
	    		}

	    		$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
		        $array=array('UserDetail'=>$user,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
		        return  response()->json(array('array'=>$array), 200);
	        }
	        else
	        {
	        	$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Imei is Not Matching."];
		        $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>2);
		        return  response()->json(array('array'=>$array), 200);
	        }
	    }
    }

    public function logout(Request $request)
    {
    	$validation=Validator::make($request->all(), [
											                'userId' => 'required',
											                'authToken'=>'required'
											          ]);		          
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in requirment",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }

        Users::where(['userId'=>$request->userId,'authToken'=>$request->authToken])->update(['loginStatus'=>'2','isLoggedIn'=>'2']);

        $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
        $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
        return  response()->json(array('array'=>$array), 200);
    }

    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}
