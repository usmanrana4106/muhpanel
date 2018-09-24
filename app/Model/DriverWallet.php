<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DriverWallet extends Model
{
    protected $table = 'driverwallet';
    public $timestamps = false;
 	protected $fillable = [
                              'id', 'driverId', 'totalEarn','fullName','totalCompanyProfit','totalPay', 'currCash', 'currentEarn', 'currCompanyProfit', 'currVat', 'totalVatPaid','creditor', 'status', 'crd', 'upd','currentpaymentLeft'
                         ];
}
