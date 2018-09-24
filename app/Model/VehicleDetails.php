<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//*****Created By Usman Abbas*******//
class VehicleDetails extends Model
{
	protected $table = 'vehicledetail';
    public $timestamps = false;
 	protected $fillable = [
						         'vihicleId', 'driverId', 'vehicleModel', 'vihicleType','driverCarImage' ,'company', 'brands','colour', 'vihicleNumber', 'plateLetterRight', 'plateLetterMiddle', 'plateLetterLeft', 'plateType', 'plateNumber', 'vehicleReferenceNumber', 'vehicleApproval','vechicleIdentityProof'
						    ];
   
}
