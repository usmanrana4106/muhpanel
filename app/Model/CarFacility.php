<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//*****Created By Usman Abbas*******//
class CarFacility extends Model
{
    protected $table = 'carfacility';
 	protected $fillable = [
                              'facilityId', 'facilityName', 'status', 'crd', 'upd'
                         ];

    public static function driversCarFacility($facility)
    {
    	$facilities=array();
		        $a=0;
		        $carfacility=explode(",", $facility);
		        foreach ($carfacility as $facility) 
		        {
		        	$facilities[$a]=$facility;
		        	$a++;
		        	
		        }
    	 return CarFacility::whereIn('facilityId',$facilities)->get();
    }
}
