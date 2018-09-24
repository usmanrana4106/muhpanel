<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
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
                              'tutorial_status', 'driverReferenceNumber', 'ledger_id', 'companyId'
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

}
