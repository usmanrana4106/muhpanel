<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

use App\Model\Drivers;
use App\Model\VehicleDetails;




use App\Model\Bookings\Bookings;
use App\Model\Bookings\BookingDetails;
use App\Model\Bookings\BookingBroadCasting;
use App\Model\Bookings\BookingProgress;
use App\Model\Bookings\BookingComplete;



use App\Model\Nationality;
use App\Model\MOT;
use App\Model\Users;
use App\Model\CarDetail;
use App\Model\CarCompanies;
use App\Model\DriverWallet;
use App\Model\Notification;

//*******Created By Usman Abbas*******//
class DriverController extends Controller
{
    protected $url;

    public function __construct()
    {
        $this->url = URL::to('/');
    }
    
    public function getDrivers()
    {
      $TotalApprovedDrivers=Drivers::where(['identityProofStatus'=>'1','licenceNumberStatus'=>'1'])->count();
      $TotalUnApprovedDrivers=Drivers::where('identityProofStatus','=','0')->orWhere('licenceNumberStatus','=','0')->count();
      $TotalActiveDrivers=Users::where(['status'=>'1','userType'=>'driver'])->count();
      $TotalUnActiveDrivers=Users::where(['status'=>'0','userType'=>'driver'])->count();

      $Date=date('Y-m-d');
      $startDate=date("Y-m-d",strtotime($Date)).' 00:00'; //00:00 start day time
      $endDate=date("Y-m-d",strtotime($Date)).' 23:59'; //23:59 end day time

      $dailRegisteredDrivers=Drivers::whereBetween('crd', [$startDate, $endDate])->where('mobileNumber', '!=', 0)->count();
      return view('Pages.Drivers.driversType',compact('TotalApprovedDrivers','TotalUnApprovedDrivers','TotalActiveDrivers','TotalUnActiveDrivers','dailRegisteredDrivers'));
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
        return view('Pages.Drivers.totalDriver',compact('title'));
      }
      elseif ($status==0) 
      {
        $title='Total UnApproved Drivers';
        return view('Pages.Drivers.totalDriver',compact('title'));
      }
      else
        return redirect()->route('Home');
    }

    public function getactiveOrUnActive($status)
    {
      if ($status==1) 
      {
        $title='Total Active Drivers';
        return view('Pages.Drivers.totalDriver',compact('title'));

      }
      elseif ($status==0) 
      {
        $title='Total UnActive Drivers';
        return view('Pages.Drivers.totalDriver',compact('title'));
      }
       else
        return redirect()->route('Home');
      // return view('Pages.Drivers.totalDriver',compact('Drivers'));
    }

    public function dailyRegisteredDrivers()
    {
       $title='Daily Registered Drivers';
       return view('Pages.Drivers.dailyRegisteredDrivers',compact('title'));
    }

    public function driversWithCars($carType)
    {
        return view('Pages.Drivers.totalDriversOf_vehicles',compact('carType'));

    }


   public function updateProfileImage(Request $request)
   {
      $file=$request->file('profileImage');
      if($file)
      {
          $extension=$file->getClientOriginalExtension();
          $filename =$request->userId.".".$extension;
          $file->move('public/uploads/images/driverImage/',$filename);
          Users::where('userId',$request->userId)->update(['profileImage'=> $filename]);
          session()->flash('uploadImage', 'Driver Profile Image is Successfully Updated');
          return redirect()->route('Driver.ApproveView',$request->driverId);
      }
   }
   public function updateIdentityProof(Request $request)
   {
      $file=$request->file('identityProof');
      if($file)
      {
          $extension=$file->getClientOriginalExtension();
          $filename =$request->userId.".".$extension;
          $file->move('public/uploads/images/identityProof/',$filename);
          $Images['identityProof']=$filename;
          Drivers::where('userId',$request->userId)->update($Images);
          session()->flash('uploadImage', 'Driver IdentityProof Image is Successfully Updated');
          return redirect()->route('Driver.ApproveView',$request->driverId);
      }
   }
   public function updateLicenseProof(Request $request)
   {
      $file=$request->file('licenseProof');
      if($file)
      {
        $extension=$file->getClientOriginalExtension();
        $filename =$request->userId.".".$extension;
        $file->move('public/uploads/images/licenseProof/',$filename);
        $Images['licenseProof']=$filename;
        Drivers::where('userId',$request->userId)->update($Images);
        session()->flash('uploadImage', 'Driver license Proof Image is Successfully Updated');
        return redirect()->route('Driver.ApproveView',$request->driverId);
      }
      else
      {

      }
   }
   public function updateVehicleProof(Request $request)
   {
      $file=$request->file('vechicleIdentityProof');
      if($file)
      {
        $extension=$file->getClientOriginalExtension();
        $filename =$request->userId.".".$extension;
        $file->move('public/uploads/images/vehicleProof/',$filename);
        $input['vechicleIdentityProof']= $filename;
        VehicleDetails::where('driverId',$request->driverId)->update($input);
        session()->flash('uploadImage', 'Driver VechicleIdentityProof Image is Successfully Updated');
        return redirect()->route('Driver.ApproveView',$request->driverId);
      }
      else
      {

      }
   }
   public function updateDriverCarImage(Request $request)
   {
      $file=$request->file('driverCarImage');
      if($file)
      {
        $extension=$file->getClientOriginalExtension();
          $filename =$request->userId.".".$extension;
          $file->move('public/uploads/images/driverCarImage/',$filename);
          $input['driverCarImage']= $filename;
          VehicleDetails::where('driverId',$request->driverId)->update($input);
          session()->flash('uploadImage', 'Driver driver CarImage  is Successfully Updated');
          return redirect()->route('Driver.ApproveView',$request->driverId);
      }
      else
      {

      }
   }


   public function searchDrivers()
   {
      $nationalities=Nationality::all();
      return view('Pages.Drivers.searchDrivers',compact('nationalities'));
   }

   public function searchbasedDrivers(Request $request)
   {
      $request->request->remove('_token');
      $Drivers=Drivers::getDriverSearchBased($request->all(),$request->fullName);
      return view('Pages.Drivers.totalDriverUsers',compact('Drivers'));
   }






    public function driverStats()
    {
          $Driver=Users::where('userType','driver')->count();
          $login=Users::where(['userType'=>'driver','isLoggedIn'=>'1'])->count();
          $logout=Users::where(['userType'=>'driver','isLoggedIn'=>'2'])->count();
          $online=Users::where(['userType'=>'driver','loginStatus'=>'1'])->count();
          $offline=Users::where(['userType'=>'driver','loginStatus'=>'2'])->count();
          $free=Drivers::where('driverStatus','1')->count();
          $ride=Drivers::where('driverStatus','3')->count();
          $unapproved=Drivers::where('identityProofStatus','0')->orWhere('licenceNumberStatus','0')->count();
          $Approved=Drivers::where(['identityProofStatus'=>'1','licenceNumberStatus'=>'1'])->count();
          $notapprovedMOT=Users::where(['userType'=>'driver','notapprovedMOT'=>'1'])->count();
          $TotalActiveDrivers=Users::where(['status'=>'1','userType'=>'driver'])->count();
          $TotalUnActiveDrivers=Users::where(['status'=>'0','userType'=>'driver'])->count();
         
         return view('Pages.Drivers.statsOfDriver',compact(
                                                            'Driver','login','online','offline','TotalUnActiveDrivers','logout','free','ride','Approved','unapproved','TotalActiveDrivers','notapprovedMOT'
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
            $driverInfo->identityProof=$this->url."/public/uploads/images/identityProof/".$driverInfo->identityProof;              
        }
        if(empty($driverUserInfo->profileImage))
        {
            $driverUserInfo->profileImage="not Avaliable";
        }
        else
        {
            $driverUserInfo->profileImage=$this->url."/public/uploads/images/driverImage/".$driverUserInfo->profileImage;
        }
          
        if($driverUserInfo->licenseProof != 'undefined')
        {
            $driverUserInfo->licenseProof=$this->url."/public/uploads/images/driverImage/".$driverUserInfo->licenseProof;
        }

        if(empty($VehicleInfo->vechicleIdentityProof))
        {
           $VehicleInfo['vechicleIdentityProof']="not Avaliable";
        }
        else
        {
           $VehicleInfo->vechicleIdentityProof=$this->url."/public/uploads/images/vehicleProof/".$VehicleInfo->vechicleIdentityProof;
        }
        $Wallet=DriverWallet::where('driverId',$driverInfo->userId)->first();
        //$Bookings=BookingComplete::getDriverBookingsComplete($driverInfo->userId);
        return view('Pages.Drivers.driverProfile',compact('driverUserInfo','driverInfo','VehicleInfo','Wallet'));
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
      $nationalities=Nationality::all();
      $status=session()->get('status');
       return view('Pages.Drivers.insertDriver',compact('carTypes','status','companies','nationalities'));
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
                                        'vihicleType' => 'required',
                                        'nationality' =>'required'
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
          $data['dateOfBirth']=$request->day."-".$request->month."-".$request->year;
          $data['email']=$request->email;
          $data['mobileNumber']=$request->mobileNumber;
          $data['captainIdentityNumber']=$request->captainIdentityNumber;

          $driverReferenceNumber = 99999;
          $input['notapprovedMOT']=1;






          if ($request->motDriver=="on")
          {
             $response=MOT::hitMotForDriver($data);
             if($response['error']==1) 
             {
               return "Driver Registration MOT Error : ".$response['errorMessage'];
             }

             $driverReferenceNumber = $response['ReferenceNumber'];
             $input['notapprovedMOT']=0;
          }

          $vehicleReferenceNumber=1111;
          $vehicleApproval=0;
          if ($request->motVehicle=="on") 
          {
            $response=MOT::hitMotForDriverVehicle($input);
            if ($response['error']==1) 
            {
                return "Vehicle Registration MOT Error : ".$response['errorMessage'];
            }
            
            $vehicleReferenceNumber=$response['vehiclerefnumber'];
            $vehicleApproval=1;
          }

            $authToken=$this->quickRandom();
            $input['authToken']=$authToken;
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
            $input['driverReferenceNumber']=$driverReferenceNumber;
            $input['dateOfBirth']=$request->year."-".$request->month."-".$request->day;
            $input['nationality']=$request->nationality;
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
            $input2=[
                        'driverId'=>$driverDetails->id,
                        'vehicleModel'=>$request->vehicleModel,
                        'vihicleType'=>$request->vihicleType,
                        'company'=>$request->company, 
                        'brands'=>$request->brands,
                        'colour'=>$request->colour, 
                        'vihicleNumber'=>$request->vihicleNumber, 
                        'plateLetterRight'=>$request->plateLetterRight, 
                        'plateLetterMiddle'=>$request->plateLetterMiddle, 
                        'plateLetterLeft'=>$request->plateLetterLeft, 
                        'plateType'=>$request->plateType, 
                        'plateNumber'=>$request->plateNumber, 
                        'vehicleReferenceNumber'=>$vehicleReferenceNumber, 
                        'vehicleApproval'=>$vehicleApproval,
                        'vechicleIdentityProof'=>1
                    ];
          VehicleDetails::create($input2);
          return redirect()->route('Drivers');
    }

    public function approveDriver_view($driverId)
    {
       $carTypes=CarDetail::all();
       $companies=CarCompanies::all();
       $nationalities=Nationality::all();
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
               return view('Pages.Drivers.approvalPage',compact('carTypes','status','companies','driverDetails','driverUser','dateOfBirth','vehicleDetails','nationalities'));
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
                                        'vihicleType' => 'required',
                                        'nationality' => 'required'
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


            $url="https://wasl.api.elm.sa/api/dispatching/v2/drivers";
           $mot_data=[
               'driver'=>[

                   "identityNumber" => "1234567890",
                   "dateOfBirthHijri" => "1420/01/01",
                   "emailAddress" => "address@email.com",
                   "mobileNumber" => "+966512345678"

               ],
               'vehicle'=>[
                   "sequenceNumber"=> "123456879",
                   "plateLetterRight"=> "ا",
                   "plateLetterMiddle"=> "ا",
                   "plateLetterLeft"=> "ا",
                   "plateNumber"=> "1234",
                   "plateType"=> "1"
               ]
           ];

//           $response=MOT::motNewApi($mot_data,$url);
//           $response2=json_encode($response);
//           print_r($response2);
//           die;











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

          $data['dateOfBirth']=$request->day."-".$request->month."-".$request->year;
          $data['email']=$request->email;
          $data['mobileNumber']=$request->mobileNumber;
          $data['captainIdentityNumber']=$request->captainIdentityNumber;

          
          if ($request->motDriver=="on") 
          {
             $response=MOT::hitMotForDriver($data);
             if($response['error']==1) 
             {
               return "Driver Registration MOT Error : ".$response['errorMessage'];
             }

             $driverReferenceNumber = $response['ReferenceNumber'];
             $input['notapprovedMOT']=0;
          }
          else
          {
            if (empty($request->driverReferenceNumber)) 
            {
               $driverReferenceNumber = 99999;
               $input['notapprovedMOT']=1;
            }
            else
            {
              $driverReferenceNumber = $request->driverReferenceNumber;
              $input['notapprovedMOT']=1;
            }
          }

          $input=$request->all();
         
          if ($request->motVehicle=="on") 
          {
            $response=MOT::hitMotForDriverVehicle($input);
            if ($response['error']==1) 
            {
                return "Vehicle Registration MOT Error : ".$response['errorMessage'];
            }
            
            $vehicleReferenceNumber=$response['vehiclerefnumber'];
            $vehicleApproval=1;
          }
          else
          {
             if (empty($request->vehicleReferenceNumber)) 
              {
                 $vehicleReferenceNumber=1111;
                 $vehicleApproval=0;
              }
              else
              {
                $vehicleReferenceNumber=$request->vehicleReferenceNumber;
                 $vehicleApproval=1;
              }
          }



          Drivers::where('driveId',$request->driverId)->update([
                                                                  'fullName'=>$request->fullName,
                                                                  'dateOfBirth'=>$dateOfBirth,
                                                                  'mobileNumber'=>$request->mobileNumber,
                                                                  'vihicleNumber'=>$request->vihicleNumber,
                                                                  'captainIdentityNumber'=>$request->captainIdentityNumber,
                                                                  'licenceNumberStatus'=>$licenceNumberStatus,
                                                                  'identityProofStatus'=>$identityProofStatus,
                                                                  'accountNo'=>$request->accountNo,
                                                                  'nationality'=>$request->nationality,
                                                                  'driverReferenceNumber'=>$driverReferenceNumber,
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
                                                                            'vihicleType' => $request->vihicleType,
                                                                            'vehicleReferenceNumber'=>$vehicleReferenceNumber, 
                                                                          ]);
       }

       session()->flash('status', 'Driver Profile is Successfully Updated');
       return redirect()->route('Driver.ApproveView',$request->driverId);
    }


    public function freeDriver($userId)
    {
        $user=Users::where(['userId'=>$userId,'userType'=>'driver'])->first();
        Drivers::where('userId',$userId)->update(['driverStatus'=>'1']);
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
          session()->flash('driverFree','yes');
       }
       return redirect($url);
    } 


    public function logoutDriver($userId)
    {
        $user=Users::where(['userId'=>$userId,'userType'=>'driver'])->first();
        Drivers::where('userId',$userId)->update(['driverStatus'=>'1']);
        $result=1;
        if ($user->deviceType == 1) 
         {
              $notifyResponse=Notification::notify(array($user->deviceToken), 'logout' , "", '1', 'logout');
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
          session()->flash('driverFree','yes');
       }
       return redirect($url);
    } 

    public function deleteDrivers($userId)
    {
        //delete User done
        //delete driver done
        //delete vehicle done
        //delete wallet done
        // delete all images done
        // delete bookings
      // $driver=Drivers::where('userId',$userId)->first();
       $user=Users::where(['userId'=>$userId,'userType'=>'driver'])->first();
      // $profileImage = 'public/uploads/images/driverImage/'.$user->profileImage; // Value is not URL but directory file path
      // if(File::exists($profileImage)) {
      //     File::delete($profileImage);
      // }
      // $identityProof = 'public/uploads/images/identityProof/'.$driver->identityProof;// Value is not URL but directory file path
      // if(File::exists($identityProof)) {
      //     File::delete($identityProof);
      // }
      // $licenseProof = 'public/uploads/images/licenseProof/'.$driver->licenseProof;  // Value is not URL but directory file path
      // if(File::exists($licenseProof)) {
      //     File::delete($licenseProof);
      // }
      // $vechicleIdentityProof = 'public/uploads/images/vehicleProof/'.$driver->vechicleIdentityProof;// Value is not URL but directory file path
      // if(File::exists($vechicleIdentityProof)) {
      //     File::delete($vechicleIdentityProof);
      // }
      // $driverCarImage='public/uploads/images/driverCarImage/'.$driver->driverCarImage;// Value is not URL but directory file path
      // if(File::exists($driverCarImage)) {
      //     File::delete($driverCarImage);
      // }    
      // Users::where('userId',$userId)->delete();
      // Drivers::where('userId',$userId)->delete();
      // if(!empty($driver))
      // {
      //    VehicleDetails::where('driverId',$driver->driveId)->delete();
      // }
      // DriverWallet::where('driverId',$userId)->delete();
       $input=['mobileNumber'=>0,'unactive'=>$user->mobileNumber];
       Users::where('userId',$userId)->update($input);
       Drivers::where('userId',$userId)->update(['mobileNumber'=>'0']);
       if ($user->deviceType == 1) 
         {
              $notifyResponse=Notification::silentNotify(array($user->deviceToken),$user->userType);
         }
         else
         {
              $result=Notification::silentNotifyiOS($user->deviceToken);
         }
         
         
       $url = URL::previous();
       session()->flash('uncative','yes');
       return redirect($url);
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
