<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


use App\Model\CarDetail;
use App\Model\CarCompanies;
use App\Model\CarBrand;


//*****Created By Usman Abbas*******//

class VehicleController extends Controller
{
    public function getCarList()
    {
    	$cardetails=CarDetail::where('status',1)->get();
    	$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
	    $array=array('carDetails'=>$cardetails,'ErrorDetail'=>$ErrorDetail,'Result'=>1);
	    return  response()->json(array('array'=>$array), 200);
    }

    public function getVehicleBrands(Request $request)
    {
        $companyName=$request->companyName;
        $company=CarCompanies::where('companyName',$companyName)->first();
        $cars=CarBrand::where('companyId', $company->companyId)->get();
    	$pro_select_box='';
		$pro_select_box .='<option value="">Select Place</option>';
		foreach ($cars as $car) 
		{
				$pro_select_box .='<option value="'.$car->brandName.'">'.$car->brandName.'</option>';
		}
        echo json_encode($pro_select_box);
    }
}
