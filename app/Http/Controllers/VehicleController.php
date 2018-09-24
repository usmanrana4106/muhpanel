<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Model\CarDetail;
use App\Model\CarCompanies;


//*****Created By Usman Abbas*******//


class VehicleController extends Controller
{
    public function allCarTypes()
    {
    	$vehicleTypes=CarDetail::all();
    	return view('Pages.Vehicles.vehicleTypes',compact('vehicleTypes'));
    }

    public function activeOrInactive($id,$status)
    {	
    	if ($status==0)
    	    $status=1;
    	else
    		$status=0;


    	if ( !empty($id) ) 
    	{
    		CarDetail::where('carId',$id)->update(['status'=>$status]);
    		return redirect()->route('Vehicle.allTypes');
    	}
    }

    public function editCarType_show($id)
    {
    	$carType=CarDetail::where('carId',$id)->first();
    	return view('Pages.Vehicles.editVehicleType',compact('carType'));
    }

    public function editCarType(Request $request)
    {
        $this->validate($request,[
                                    'carId'=>'required',
                                    'carName'=>'required',
                                    'carSheet'=>'required',
                                    'Counterprice'=>'required',
                                    'priceByDistence'=>'required',
                                    'priceByTime'=>'required',
                                    
                                            ]);
        $input['carId']=$request->carId;
        $input['carName']=$request->carName;
        $input['carSheet']=$request->carSheet;
        $input['Counterprice']=$request->Counterprice;
        $input['priceByDistence']=$request->priceByDistence;
        $input['priceByTime']=$request->priceByTime;
        if($request->status== 'on')
            $input['status']=1;
        else 
            $input['status']=0;
    	CarDetail::where('carId',$request->carId)->update($input);
        return redirect()->route('Vehicle.allTypes');
    }


    
}
