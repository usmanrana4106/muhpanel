<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PassengerRating extends Model
{
	protected $table = 'passengerrating';
    public $timestamps = false;
 	protected $fillable = [
                            'ratingId', 'passengerId', 'bookingId', 'driverId', 'rate', 'review', 'status','crd','upd'
                          ];
    
}
