<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    protected $table = 'paymentdetail';
    public $timestamps = false;
 	protected $fillable = [
                             'detailId', 'driverId', 'currCash', 'currEarn', 'currCompanyProfit', 'currVat', 'creditor', 'currentpaymentLeft', 'payAmount', 'paidTo', 'paymentMethod', 'created_at', 'updated_at','date'
                         ];
}
