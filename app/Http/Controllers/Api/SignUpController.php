<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\QueryException;

use Validator;
use App\Model\Users;
use App\Model\PassengerDetails;
use App\Model\MOT;
use App\Model\Drivers;
use App\Model\VehicleDetails;
use App\Model\Entries;
use App\Model\EntryItem;
use App\Model\Group;
use App\Model\Ledger;

//*****Created By Usman Abbas*******//

class SignUpController extends Controller
{
	protected $url;
    public function __construct()
    {
        $this->url = URL::to('/');
    }

	//We have a phone verification to check phone number exist in user table or not
	public function phoneVerification(Request $request)
	{
		$user=Users::where('mobileNumber',$request->phone)->first();
		if (!empty($user)) 
		{
			$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
		    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
		    return  response()->json(array('array'=>$array), 200);
		}
		else 
		{
			$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
		    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
		    return  response()->json(array('array'=>$array), 200);
		}
	}

	//here we just Register Customer with his important details
    public function registerCustomer(Request $request)
    {
    	$validation=Validator::make($request->all(), [
										                'fullName' => 'required',
										                'email' => 'required',
										                'mobileNumber'=>'required',
										                'imeiNumber' => 'required',
										                'deviceToken'=>'required',
										                'deviceType'=>'required'

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
        	$ErrorDetail=['ErrorDetails'=>"Email is Already Registered",'ErrorMessage'=>""];
		    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
		    return  response()->json(array('array'=>$array), 200);
        }

        $input=$request->all();
        $authToken=$this->quickRandom();
        // $input['password']=Hash::make($request->password);
        $input['isLoggedIn']=1;
        $input['logTime']=date('Y-m-d h:i:s');
        $input['userType']='passenger';
        $input['authToken']=$authToken;
        $input['userName']=$request->fullName;
        $user=Users::create($input);
        $passengerDetail=['userId'=>$user->id,'fullName'=>$request->fullName,'mobileNumber'=>$request->mobileNumber];

        $selectgroup=Group::where('name','Passenger')->first();
		$passengerGroupId=$selectgroup->id;
		//Creating Passenger Ledger 
       
        $passengerDetail['ledgerStatus']=1;

        $passDetail=PassengerDetails::create($passengerDetail);

         $insertledger=[
            				'group_id'=>$passengerGroupId,
            				'name'=>$request->fullName."/".$passDetail->id,
            				'code'=>$passDetail->id,
            				'op_balance'=>'0.00',
            				'op_balance_dc'=>'D',
            				'type'=>0,
            				'reconciliation'=>1,
            				'notes'=>''
        				];
        Ledger::create($insertledger);


        $user->passengerDetail=$passDetail;

        $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
	    $array=array('UserDetail'=>$user,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
	    return  response()->json(array('array'=>$array), 200);
    }

    //here we Register Driver with his Vehicle
    public function DriverRegistration(Request $request)
    {
    	$validation=Validator::make($request->all(), [
											                'fullName' => 'required',
											                'email' => 'required',
											                'mobileNumber'=>'required',
											                'imeiNumber' => 'required',
											                'captainIdentityNumber'=>'required',
											                'dateOfBirth'=>'required',
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


        $user = Users::where('email','=', $request->email)->first();
	      if(empty($user))
	      {
	      	try{
			      	$input=$request->all();
		            $date=explode("-", $request->dateOfBirth);
			        $input['dateOfBirth']=$date[2]."-".$date[1]."-".$date[0];
			      	$str=$request->captainIdentityNumber;
			      	// if ($str[0]=='1') 
			      	// {
				        $driver_data = array("apiKey" => "8EF7AA53-3860-4242-955F-7AC218FDE3C1", "captainIdentityNumber" => $request->captainIdentityNumber , "dateOfBirth" => $request->dateOfBirth,"emailAddress" =>$request->email,"mobileNumber"=>$request->mobileNumber); 
			            $driver_data_string = json_encode($driver_data); 
			            $url = "https://wasl.elm.sa/WaslPortalWeb/rest/DriverRegistration/send"; 
			            $driver_api_response = MOT::call_api($driver_data_string,$url);
			            $notapprovedMOT='0';
			            $data_decode = json_decode($driver_api_response,true);

			            if($data_decode['resultCode']=='100')
			            {
			                $ReferenceNumber = $data_decode['referenceNumber'];
			                $input['licenceNumberStatus'] = 1;
	        				$input['identityProofStatus'] = 1;
			            }

			            if($data_decode['resultCode']!='100')
			            {
			                if ($data_decode['resultMessage']=="General Server Error") 
			                {
			                    $ReferenceNumber = 99999;
			                    $notapprovedMOT='1';
			                    $input['licenceNumberStatus']=0;
	        					$input['identityProofStatus']=0;
			                }
			                else
			                {
			                    $errors = $data_decode['resultMessage'];
			                    $ErrorDetail=['ErrorDetails'=>"Error in MOT",'ErrorMessage'=> preg_replace("/[\\n\\r]+/", " ", $errors)];
					            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
					            return  response()->json(array('array'=>$array), 200);
			                }           
			            }
				    // }
				    // else
				    // {
				    // 	$ReferenceNumber = 99999;
				    // 	$notapprovedMOT='1';
				    // 	$input['licenceNumberStatus']=0;
	       //  			$input['identityProofStatus']=0;
				    // }
	   
	       			$authToken=$this->quickRandom();
		            $input['authToken']=$authToken;
		            $input['notapprovedMOT']=$notapprovedMOT;
		            $input['status']=1;
		            // $input['password']=Hash::make($request->password);
		            $input['userType']='driver';
	        		$input['logTime']=date('Y-m-d h:i:s');
	        		$input['isLoggedIn']=1;

		            $user=Users::create($input);
		           	
		           	$file=$request->file('profileImage');
			        if($file)
			        {
			        	$extension=$file->getClientOriginalExtension();
			            $filename =$user->id.".".$extension;
			            $file->move('public/uploads/images/driverImage/',$filename);
			            Users::where('userId',$user->id)->update(['profileImage'=> $filename]);
			            $user->profileImage=$this->url."/public/uploads/images/driverImage/".$filename;
			        }

		            $input['userId']=$user->id;
		            $input['driverReferenceNumber']=$ReferenceNumber;
		            

		            $driverDetails=Drivers::create($input);

		           	$file=$request->file('identityProof');
		           	if($file)
			        {
			        	$extension=$file->getClientOriginalExtension();
			            $filename =$user->id.".".$extension;
			            $file->move('public/uploads/images/identityProof/',$filename);
			            Drivers::where('userId',$user->id)->update(['identityProof'=> $filename]);
			            $user->identityProof=$this->url."/public/uploads/images/identityProof/".$filename;
			        }
		            $user->driverDetails=$driverDetails;

		            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
				    $array=array('Driver'=>$user,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
				    return  response()->json(array('array'=>$array), 200);

			    }
		        catch(QueryException $ex){
		         
		            $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>$ex->getMessage()];
				    $array=array('Driver'=>$user,'ErrorDetail'=>$ErrorDetail,'Result'=>0);
				    return  response()->json(array('array'=>$array), 200);
		        }
	      }
	      else
	      {
	      		$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>"Driver is Already Registered"];
			    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
			    return  response()->json(array('array'=>$array), 200);
	      }
    }

    //Vehicle Registration
    public function vehicleRegistration(Request $request)
    {
    	$validation=Validator::make($request->all(),[
    													'userId'=> 'required',
										                'driverId' => 'required',
										                'vihicleNumber' => 'required',
										                'company'=>'required',
										                'brands' => 'required',
										                'vehicleModel' => 'required',
										                'plateLetterLeft'=>'required',
										                'plateLetterRight'=>'required',
										                'plateLetterMiddle'=>'required',
										                'plateNumber'=>'required',
										                'plateType'=>'required',
										                'vihicleType'=>'required',
										                'colour'=>'required',
										                
											        ]);
    										          
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Vehicle Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }

        try
        {

        
		        // $str=$request->captainIdentityNumber;
		      	// if ($str[0]=='1') 
		      	// {
					       
		         $vehicle_data = array("apiKey" => "8EF7AA53-3860-4242-955F-7AC218FDE3C1", "vehicleSequenceNumber" => $request->vihicleNumber, "plateLetterRight" => $request->plateLetterRight,"plateLetterMiddle" =>$request->plateLetterMiddle,"plateLetterLeft"=>$request->plateLetterLeft,"plateNumber"=>$request->plateNumber,"plateType"=>$request->plateType);

		                $vehicle_data_string = json_encode($vehicle_data);
		                $vurl = "https://wasl.elm.sa/WaslPortalWeb/rest/VehicleRegistration/send"; 
		                $vehicle_api_response = Mot::call_api($vehicle_data_string,$vurl);
		                $vehicle_data_decode = json_decode($vehicle_api_response,true);

		                 $vehicleApproval='0';

		                if($vehicle_data_decode['resultCode']=='100')
		                {
		                  
		                    $vehiclerefnumber = $vehicle_data_decode['vehicleReferenceNumber'];
		                    $vehicleApproval='1';
		                    //    $vehiclerefnumber='454885';
		           		}
		                elseif($vehicle_data_decode['resultCode']!='100')
		                {

		                    if ($vehicle_data_decode['resultMessage']=="General Server Error") 
		                    {

		                         $vehiclerefnumber = 99999;
		                         $vehicleApproval='0';

		                    }
		                    else
		                    {
		                        $errors = $vehicle_data_decode['resultMessage'];
			                    $ErrorDetail=['ErrorDetails'=>"Error in MOT",'ErrorMessage'=> preg_replace("/[\\n\\r]+/", " ", $errors)];
					            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
					            return  response()->json(array('array'=>$array), 200);
		                    }   
		                }
		     //  	}
			    // else
			    // {
			    // 	 $vehicleApproval='0';
			    // }
		       
		        $input['driverId'] = $request->driverId;
		        $input['vihicleNumber'] = $request->vihicleNumber;
		        $input['company']=$request->company;
		        $input['brands'] = $request->brands;
		        $input['plateLetterLeft']=$request->plateLetterLeft;
		        $input['plateLetterRight']=$request->plateLetterRight;
		        $input['plateLetterMiddle']=$request->plateLetterMiddle;
		        $input['plateNumber']=$request->plateNumber;
		        $input['plateType']=$request->plateType;
		        $input['vihicleType']=$request->vihicleType;
		        $input['colour']=$request->colour;
		        $input['vehicleModel'] = $request->vehicleModel;
		        $input['vehicleApproval']=$vehicleApproval;
		        $input['vehicleReferenceNumber']=$vehiclerefnumber;

		        $vehicle=VehicleDetails::where('driverId',$request->driverId)->first();
		        if (empty($vehicle))
		        {
		        	$user=new VehicleDetails();
		        	$file=$request->file('vechicleIdentityProof');
			        if($file)
			        {
			        	$extension=$file->getClientOriginalExtension();
			            $filename =$request->userId.".".$extension;
			            $file->move('public/uploads/images/vehicleProof/',$filename);
			            $input['vechicleIdentityProof']= $filename;
			            $user->vechicleIdentityProof=$this->url."/public/uploads/images/vehicleProof/".$filename;

			        }

			        $file=$request->file('driverCarImage');
			        if($file)
			        {
			        	$extension=$file->getClientOriginalExtension();
			            $filename =$request->userId.".".$extension;
			            $file->move('public/uploads/images/driverCarImage/',$filename);
			            $input['carImage']= $filename;
			            $user->carImage=$this->url."/public/uploads/images/driverCarImage/".$filename;

			        }

		        	$user=VehicleDetails::create($input);

		        	Drivers::where('driveId',$request->driverId)->update([ 
		        														  'vihicleNumber'=>$request->vihicleNumber
		        														]);
		    		
		        }
		        else
		        {
		        	VehicleDetails::where('driverId',$request->driverId)->update($input);
		        	Drivers::where('driveId',$request->driverId)->update([ 
		        														  	'vihicleNumber'=>$request->vihicleNumber
		        														]);
		        	$user=$request->all();
		        	$file=$request->file('vechicleIdentityProof');
			        if($file)
			        {
			        	$extension=$file->getClientOriginalExtension();
			            $filename =$request->userId.".".$extension;
			            $file->move('public/uploads/images/vehicleProof/',$filename);
			            VehicleDetails::where('driverId',$request->driverId)->update(['vechicleIdentityProof'=> $filename]);
			            $user->vechicleIdentityProof=$this->url."/public/uploads/images/vehicleProof/".$filename;
			        }
		        }
		        $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
			    $array=array('Driver'=>$user,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
			    return  response()->json(array('array'=>$array), 200);
		}
		catch(QueryException $ex)
		{
			$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>$ex->getMessage()];
		    $array=array('Driver'=>$user,'ErrorDetail'=>$ErrorDetail,'Result'=>0);
		    return  response()->json(array('array'=>$array), 200);
		}
    }

    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    public function imeiNumberUpdate(Request $request)
    {
    	$validation=Validator::make($request->all(),[
    													'mobileNumber'=> 'required',
    													'imeiNumber'=>'required',
											        ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Vehicle Registration",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }

        $update=Users::where('mobileNumber',$request->mobileNumber)->update(['imeiNumber'=>$request->imeiNumber]);
        if ($update == 1) 
        {
        	$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
		    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
		    return  response()->json(array('array'=>$array), 200);
        }
        else
        {
        	$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
		    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
		    return  response()->json(array('array'=>$array), 200);
        }
       
    }


}
