<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected $table = 'accounts';
    public $timestamps = false;
 	protected $fillable = [
                            'bookingId', 'userId', 'driverId', 'totalAmount', 'companyProfit', 'driverPercentage', 'driverProfit', 'vatTax', 'paymentStatus', 'receivedDate', 'payDate', 'paymentMethod', 'Modified_date', 'created_at', 'updated_at'
                         ];
}
