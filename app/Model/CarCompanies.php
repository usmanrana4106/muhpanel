<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CarCompanies extends Model
{

	protected $table = 'carcompany';
    public $timestamps = false;
 	protected $fillable = [   'companyId','companyName','arabicCompanyName'   ];

}
