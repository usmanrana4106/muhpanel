<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DriverRating extends Model
{
    protected $table = 'rating';
    public $timestamps = false;
 	protected $fillable = [
                            'ratingId', 'driverId', 'passangerId','bookingId', 'rate', 'review', 'status', 'crd', 'upd'
                          ];
}
