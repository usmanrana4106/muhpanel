<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//*****Created By Usman Abbas*******//
class CarDetail extends Model
{
    protected $table = 'cardetail';
    public $timestamps = false;
 	protected $fillable = [
						        'carId', 'carName', 'carSheet', 'carImage', 'Counterprice', 'priceByDistence', 'priceByTime', 'rushHoursPBD', 'rushHoursPBT', 'status', 'crd', 'upd'
						    ];
}
