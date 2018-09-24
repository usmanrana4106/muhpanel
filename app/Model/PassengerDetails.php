<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//*****Created By Usman Abbas*******//
class PassengerDetails extends Model
{
   	 protected $table = 'passengerdetail';
   	 public $timestamps = false;
 	protected $fillable = [
                              'pasengerId', 'userId', 'fullName', 'mobileNumber', 
                              'emergencyContact', 'paypalId', 'latitude', 'longitude', 
                              'location', 'rating', 'status', 'crd', 'upd'
                         ];
                         
}
