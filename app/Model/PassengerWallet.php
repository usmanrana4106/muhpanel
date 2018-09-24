<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PassengerWallet extends Model
{
	protected $table = 'passengerwallet';
    public $timestamps = false;
 	protected $fillable = [
                              'walletId', 'userId','fullName', 'totalPay', 'credit', 'due'
                         ];
   
}
