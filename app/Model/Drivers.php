<?php

namespace App\Model;

use App\Model\Bookings\BookingProgress;
use App\Model\Bookings\Bookings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
//*****Created By Usman Abbas*******//
class Drivers extends Model
{
    protected $table = 'driverdetail';
    public $timestamps = false;
 	protected $fillable = [
                              'driveId', 'userId', 'fullName', 'mobileNumber',
                              'nationalityId', 'bankName', 'accountNo', 'identityProof',
                              'identityProofStatus', 'vihicleNumber', 'licenceNumberStatus', 
                              'licenceExDate', 'driverStatus', 'carFacility', 'address', 'rating',
                              'latitude', 'longitude', 'paypalId', 'driverlog_driverId', 'crd', 'upd',
                              'captainIdentityNumber', 'dateOfBirth', 'hijri_dateOfBirth', 'madaId',
                              'tutorial_status', 'driverReferenceNumber', 'ledger_id', 'companyId','licenseProof'
                         ];
    public function nearByDrivers($lat,$lng)
    {
       
        $latitude=$lat;
        $longitude=$lng;

        $miles=4;


         $drivers=DB::select('SELECT * FROM driverdetail WHERE
          driverStatus = "1" AND
        latitude BETWEEN ('.$latitude.' - ('.$miles.'*0.018)) AND ('.$latitude.' + ('.$miles.'*0.018)) AND
        longitude BETWEEN ('.$longitude.' - ('.$miles.'*0.018)) AND ('.$longitude.' + ('.$miles.'*0.018))');
         
        // $ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
        // $data= array( 'drivers'=>$drivers,'ErrorDetail'=>$ErrorDetail);
        // $array=array('Data' => $data,'Result'=>1);
        // return  response()->json(array('array'=>$array), 200);
    } 

    public static function dailyRegisteredDrivers()
    {
      $Date=date('Y-m-d');
      $startDate=date("Y-m-d",strtotime($Date)).' 00:00'; //00:00 start day time
      $endDate=date("Y-m-d",strtotime($Date)).' 23:59'; //23:59 end day time
      $drivers= Drivers::whereBetween('crd', [$startDate, $endDate])->select('driveId', 'userId', 'fullName', 'mobileNumber', 'identityProofStatus', 'licenceNumberStatus','crd' ,'bankName','accountNo','vihicleNumber','captainIdentityNumber','address')->where('mobileNumber', '!=', 0)->get();
      return $drivers;
    }                

    public static function getDriverSearchBased($data,$name)
    {
        foreach ($data as $key => $value) 
        {
          if($value)
          {
              $input[$key]=$value;
          }
        }

        if (!empty($name)) 
        {
            $drivers= Drivers::where($input)
                  ->orWhere('fullName', 'like', '%' . $name . '%')
                  ->select('driveId', 'userId', 'fullName', 'mobileNumber', 'identityProofStatus', 'licenceNumberStatus','crd' ,'bankName','accountNo','vihicleNumber','captainIdentityNumber','address')->get();
        }
        else
        {
            $drivers= Drivers::where($input)
                  ->select('driveId', 'userId', 'fullName', 'mobileNumber',
                      'identityProofStatus', 'licenceNumberStatus','crd' ,
                      'bankName','accountNo','vihicleNumber','captainIdentityNumber','address')->get();
        }
        return $drivers;
    }


    public static function silentNotification($deviceType,$deviceToken)
    {
        if ($deviceType == 1)
        {
            $notifyResponse=Notification::notify(array($deviceToken), 'booking free' , "", '1', 'silent');
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
            $result=Notification::silentNotifyiOS($deviceToken);
        }
    }

    public static function getDriverDetailWithCar($userId)
    {
        $driver=Users::where('users.userId',$userId)
            ->leftJoin('driverdetail', 'users.userId', '=', 'driverdetail.userId')
            ->leftJoin('vehicledetail', 'driverdetail.driveId', '=', 'vehicledetail.driverId')
            ->leftJoin('cardetail', 'vehicledetail.vihicleType', '=', 'cardetail.carId')
            ->select("users.userId","driverdetail.fullName","driverdetail.mobileNumber",
                        "driverdetail.driverStatus","vehicledetail.vehicleModel","vehicledetail.brands","vehicledetail.colour",'plateLetterRight', 'plateLetterMiddle', 'plateLetterLeft','plateNumber','vihicleType','cardetail.carName')->get();
        return $driver;
    }

    public static function sendBookingtoCancel_or_confict($booking)
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
            'driverId'=>$booking->driverId,
            'reason'=>"conflict in Booking"
        ];
        if ($booking->companyId != 0)
        {
            $input['companyId']=$booking->companyId;
        }

        $data=Bookings::create($input);
        BookingProgress::where(['bookingId'=>$booking->bookingId,'driverId'=>$booking->driverId])->delete();
    }
}
