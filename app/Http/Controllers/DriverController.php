<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

use App\Model\Drivers;
use App\Model\VehicleDetails;
use App\Model\Bookings;
use App\Model\MOT;
use App\Model\Users;
use App\Model\CarDetail;
use App\Model\CarCompanies;
use App\Model\DriverWallet;

//*****Created By Usman Abbas*******//
class DriverController extends Controller
{
    protected $url;

    public function __construct()
    {
        $this->url = URL::to('/');
    }
    
    public function getDrivers()
    {
      return view('Pages.Drivers.driversType');
    }

    public function getTotalDriver()
    {
    	$Drivers=Drivers::all();
      $title='Total Drivers';
		  return view('Pages.Drivers.totalDriver',compact('Drivers','title'));
    }

    public function getApprovedOrUnApproved($status)
    {
      if ($status==1)
      {
         $title='Total Approved Drivers';
        $Drivers=Drivers::where(['identityProofStatus'=>'1','licenceNumberStatus'=>'1'])->get();
        return view('Pages.Drivers.totalDriver',compact('Drivers','title'));
      }
      elseif ($status==0) 
      {
        $title='Total UnApproved Drivers';
        $Drivers=Drivers::where('identityProofStatus','=','0')->orWhere('licenceNumberStatus','=','0')->get();
        return view('Pages.Drivers.totalDriver',compact('Drivers','title'));
      }
      else
        return redirect()->route('Home');
       
    }

    public function getactiveOrUnActive($status)
    {
      if ($status==1) 
      {
        $title='Total Active Drivers';
         $Drivers=Users::select('driverdetail.driveId', 'driverdetail.userId', 'fullName', 'driverdetail.mobileNumber', 'driverdetail.identityProofStatus', 'driverdetail.licenceNumberStatus','users.status','driverdetail.crd' ,'bankName','accountNo','vihicleNumber','captainIdentityNumber','driverdetail.address')->where(['users.status'=>'1','users.userType'=>'driver'])
                          ->leftJoin('driverdetail', 'users.userId', '=', 'driverdetail.userId')->get();
        return view('Pages.Drivers.totalDriver',compact('Drivers','title'));

      }
      elseif ($status==0) 
      {
        $title='Total UnActive Drivers';
         $Drivers=Users::select('driverdetail.driveId', 'driverdetail.userId', 'fullName', 'driverdetail.mobileNumber', 'driverdetail.identityProofStatus', 'driverdetail.licenceNumberStatus','bankName','accountNo','users.status','vihicleNumber','captainIdentityNumber','driverdetail.crd','driverdetail.address' )->where(['users.status'=>'0','users.userType'=>'driver'])
                          ->leftJoin('driverdetail', 'users.userId', '=', 'driverdetail.userId')->get();
        return view('Pages.Drivers.totalDriver',compact('Drivers','title'));
      }
       else
        return redirect()->route('Home');
      // return view('Pages.Drivers.totalDriver',compact('Drivers'));
    }



    public function driverStats()
    {

          $Driver=Users::where('userType','driver')->count();
          $online=Users::where(['userType'=>'driver','loginStatus'=>'1'])->count();
          $offline=Users::where(['userType'=>'driver','loginStatus'=>'2'])->count();
          $login=Users::where(['userType'=>'driver','isLoggedIn'=>'1'])->count();
          $logout=Users::where(['userType'=>'driver','isLoggedIn'=>'2'])->count();
          $free=Drivers::where('driverStatus','1')->count();
          $ride=Drivers::where('driverStatus','3')->count();
          $accept=DB::table('bookingdetail')->where('driverStatus','2')->count();
          $ontheway=DB::table('bookings')->where('rideStatus','6')->count();
          $unapprove=Drivers::where('identityProofStatus','0'&&'licenceNumberStatus','0')->count();
          $Approve=Drivers::where('identityProofStatus','1'&&'licenceNumberStatus','1')->count();
          $passenger=Users::where('userType','passenger')->count();
          $notapprovedMOT=Users::where(['userType'=>'driver','notapprovedMOT'=>'1'])->count();

  
         return view('Pages.Drivers.statsOfDriver',
                                                  compact(
                                                           'userdetails','admin','Driver','online','offline','login','logout','free','ride','accept','ontheway','Approve','unapprove','passenger','notapprovedMOT'
                                                         ));
        
    }

    public function getDriverProfile($driverId)
    {
        $driverID=$driverId;
        $driverInfo = Drivers::where('driveId',$driverID)->first();
        $driverUserInfo = Users::where('userId',$driverInfo->userId)->first();
        $VehicleInfo = VehicleDetails::where('driverId',$driverID)->first();

        if(empty($driverInfo->identityProof))
        {
            $driverInfo->identityProof="Not Avaliable";
        }
        else
        {
            $driverInfo->identityProof=$this->url."/uploads/images/identityProof/".$driverInfo->identityProof;              
        }
        if(empty($driverUserInfo->profileImage))
        {
            $driverUserInfo->profileImage="not Avaliable";
        }
        else
        {
            $driverUserInfo->profileImage=$this->url."/uploads/images/driverImage/".$driverUserInfo->profileImage;
        }
        
        if(empty($VehicleInfo->vechicleIdentityProof))
        {
           $VehicleInfo['vechicleIdentityProof']="not Avaliable";
        }
        else
        {
           $VehicleInfo->vechicleIdentityProof=$this->url."/uploads/images/vehicleProof/".$VehicleInfo->vechicleIdentityProof;
        }

        $Bookings=Bookings::getDriverBookings($driverInfo->userId);
        return view('Pages.Drivers.driverProfile',compact('driverUserInfo','driverInfo','VehicleInfo','Bookings'));
    }

    public function onlineDrivers()
    {
         $Drivers=Users::where(['userType'=>'driver','loginStatus'=>'1'])
                            ->join('driverdetail', 'users.userId', '=', 'driverdetail.userId')->get();
         return view('Pages.Drivers.totalDriverUsers',compact('Drivers'));
    }

    public function createDriver()
    {
      $carTypes=CarDetail::all();
      $companies=CarCompanies::all();
      $status=session()->get('status');
       return view('Pages.Drivers.insertDriver',compact('carTypes','status','companies'));
    }

    public function registeredDriver(Request $request)
    {
          $this->validate($request,
                                    [ 

                                        'fullName' => 'required|min:3|max:50',
                                        'email' => 'required|email',
                                        'mobileNumber' => 'required',
                                        'day' => 'required',
                                        'month' => 'required',
                                        'year' => 'required',
                                        'captainIdentityNumber' => 'required',
                                        'vihicleNumber' => 'required',
                                        'company' => 'required',
                                        'brands' => 'required',
                                        'vehicleModel' => 'required',
                                        'plateLetterRight' => 'required',
                                        'plateLetterMiddle' => 'required',
                                        'plateLetterLeft' => 'required',
                                        'plateNumber' => 'required',
                                        'plateType' => 'required',
                                        'vihicleType' => 'required'
                                        
                                        
                                     ]);

        $user = Users::where('email','=', $request->email)->orWhere('mobileNumber','=', $request->mobileNumber)->first();
        if (!empty($user))
        {
          if ($user->email==$request->email)
          {
            session()->flash('status', 'Email is Already Avaliable Select another');
            return redirect()->route('Driver.Create');
          }
          elseif ($user->mobileNumber == $user->mobileNumber)
          {
            session()->flash('status', 'mobileNumber is Already Avaliable Select another');
            return redirect()->route('Driver.Create');
          }
        }

          $input=$request->all();
          if ($request->identityProofStatus== 'on') 
          {
            $input['identityProofStatus']=1;
          }
          if ($request->licenceNumberStatus == 'on') 
          {
            $input['licenceNumberStatus']=1;
          }
          //     $input['dateOfBirth']=$request->day."-".$request->month."-".$request->year;

          // $driver_data = array("apiKey" => "8EF7AA53-3860-4242-955F-7AC218FDE3C1", "captainIdentityNumber" => $request->captainIdentityNumber , "dateOfBirth" =>  $input['dateOfBirth'],"emailAddress" =>$request->email,"mobileNumber"=>$request->mobileNumber); 

          //       $driver_data_string = json_encode($driver_data); 
          //       $url = "https://wasl.elm.sa/WaslPortalWeb/rest/DriverRegistration/send"; 
          //       $driver_api_response = MOT::call_api($driver_data_string,$url);
          //       $notapprovedMOT='0';
          //       $data_decode = json_decode($driver_api_response,true);

          //       if($data_decode['resultCode']=='100')
          //       {
          //           $ReferenceNumber = $data_decode['referenceNumber'];
          //       }

          //       return $data_decode;
          //       if($data_decode['resultCode']!='100')
          //       {
          //           if ($data_decode['resultMessage']=="General Server Error") 
          //           {
          //               $ReferenceNumber = 99999;
          //               $notapprovedMOT='1';
          //           }
          //           else
          //           {
          //               $errors = $data_decode['resultMessage'];
          //               $response = array('status'=>0,'message'=>preg_replace("/[\\n\\r]+/", " ", $errors));
          //               return  response()->json(array('array'=>$response), 200);
          //           }           
          //       }






            $authToken=$this->quickRandom();
            $input['authToken']=$authToken;
            $input['notapprovedMOT']=0;
            $input['status']=1;
            $input['deviceType']=3;
            $input['deviceToken']='sdadsadas';
            $input['userType']='driver';
            $input['logTime']=date('Y-m-d h:i:s');
            $input['isLoggedIn']=1;
            $input['userName']=$request->fullName;

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
              $input['driverReferenceNumber']=99999;
              $input['dateOfBirth']=$request->year."-".$request->month."-".$request->day;
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
            //create Vehicle
          return redirect()->route('Drivers');
    }

    public function approveDriver_view($driverId)
    {
       $carTypes=CarDetail::all();
       $companies=CarCompanies::all();
       $status=session()->get('status');
       $driverDetails=Drivers::where('driveId',$driverId)->first();
       if (!empty($driverDetails)) 
       {
          $driverUser=Users::where('userId',$driverDetails->userId)->first();
          if (!empty($driverUser))
          {
            $vehicleDetails=VehicleDetails::where('driverId',$driverId)->first();
            if (!empty($vehicleDetails))
            {
              $dateOfBirth=explode('-', $driverDetails->dateOfBirth);
               return view('Pages.Drivers.approvalPage',compact('carTypes','status','companies','driverDetails','driverUser','dateOfBirth','vehicleDetails'));
            }
            else
            {
              echo "VehicleDetails of Driver is Missing";
            }
              
          }
          else
          {
            echo "Driver User Information is Missing ";
          }
       }
       else 
       {
         echo "Driver Detail Information is missing";
       }
    }


    public function approveOrEdit(Request $request)
    {
      
    //Not complete
       $this->validate($request,
                                    [ 
                                        'fullName' => 'required|min:3|max:50',
                                        'email' => 'required|email',
                                        'mobileNumber' => 'required',
                                        'day' => 'required',
                                        'month' => 'required',
                                        'year' => 'required',
                                        'captainIdentityNumber' => 'required',
                                        'vihicleNumber' => 'required',
                                        'company' => 'required',
                                        'brands' => 'required',
                                        'vehicleModel' => 'required',
                                        'plateLetterRight' => 'required',
                                        'plateLetterMiddle' => 'required',
                                        'plateLetterLeft' => 'required',
                                        'plateNumber' => 'required',
                                        'plateType' => 'required',
                                        'vihicleType' => 'required'
                                     ]);
       
       if (!empty($request->userId))
       {
          Users::where('userId')->update([
                                            'userName'=>$request->fullName,
                                            'email'=>$request->email,
                                            'mobileNumber'=>$request->mobileNumber
                                          ]);
       }
       if (!empty($request->driverId)) 
       {
         $dateOfBirth=$request->year."-".$request->month."-".$request->day;
         $identityProofStatus=0;
         $licenceNumberStatus=0;
         if ($request->identityProofStatus== 'on') 
          {
            $identityProofStatus=1;
          }
          if ($request->licenceNumberStatus == 'on') 
          {
            $licenceNumberStatus=1;
          }
          Drivers::where('driveId',$request->driverId)->update([
                                                                  'fullName'=>$request->fullName,
                                                                  'dateOfBirth'=>$dateOfBirth,
                                                                  'mobileNumber'=>$request->mobileNumber,
                                                                  'vihicleNumber'=>$request->vihicleNumber,
                                                                  'captainIdentityNumber'=>$request->captainIdentityNumber,
                                                                  'licenceNumberStatus'=>$licenceNumberStatus,
                                                                  'identityProofStatus'=>$identityProofStatus,
                                                                  'accountNo'=>$request->accountNo
                                                                ]);
       }
       if (!empty($request->vihicleId)) 
       {
          VehicleDetails::where('vihicleId',$request->vihicleId)->update([
                                                                            'vihicleNumber'=>$request->vihicleNumber,
                                                                            'company' => $request->company,
                                                                            'brands' => $request->brands,
                                                                            'vehicleModel' => $request->vehicleModel,
                                                                            'plateLetterRight' => $request->plateLetterRight,
                                                                            'plateLetterMiddle' => $request->plateLetterMiddle,
                                                                            'plateLetterLeft' => $request->plateLetterLeft,
                                                                            'plateNumber' => $request->plateNumber,
                                                                            'plateType' => $request->plateType,
                                                                            'vihicleType' => $request->vihicleType
                                                                          ]);
       }

       session()->flash('status', 'Driver Profile is Successfully Updated');
       return redirect()->route('Driver.ApproveView',$request->driverId);
    }

    //Drivers Wallet
    public function driversWallets()
    {
        $Wallets=DriverWallet::all();
         return view('Pages.Drivers.driverWallets',compact('Wallets'));
    }

    //Driver Bookings
    public function getBooking($userId)
    {
       $Bookings=Bookings::getDriverBookings($userId);
       echo json_encode($Bookings);
    }

    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}
