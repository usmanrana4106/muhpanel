<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//*****Created By Usman Abbas*******//
class Admin extends Model
{
     protected $table = 'admin';
 	  protected $fillable = [
						        'admin_id',
						        'admin_name', 
						        'emailid',
						        'password',
						        'email',
						        'created_at',
						        'status',
						        'maximumAmount',
						        'updatedMaxAmt',
						        'adminPercentage',
						        'updatedPercentage',
						        'updated_at',
						        'Auth_token'
						    ];
		public static $login_validation_rules=[
			'email' => 'required|email|exists:admin'
		];	
}
