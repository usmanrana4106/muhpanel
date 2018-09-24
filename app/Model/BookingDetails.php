<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//*****Created By Usman Abbas*******//
class BookingDetails extends Model
{
    protected $table = 'bookingdetail';
    public $timestamps = false;
 	protected $fillable = [
						     'bookingId', 'driverId', 'driverStatus', 'crd', 'upd'
						   ];
}
