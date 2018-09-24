<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
   protected $table = 'carbrands';
    public $timestamps = false;
 	protected $fillable = [
						        'brandId', 'brandName', 'companyId'
						    ];
}
