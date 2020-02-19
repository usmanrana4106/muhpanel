<?php

namespace App\Http\Controllers;

use App\Model\VehicleDetails;
use App\Model\Verion;
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
        $vehicleCreate=session()->get('vehicleCreate');
        $updateCarDetails=session()->get('updateCarDetails');

    	return view('Pages.Vehicles.vehicleTypes',compact('vehicleTypes','vehicleCreate','updateCarDetails'));
    }

    public function getDistance()
    {
        $version=Verion::where('id',100)->first();
        $distance=$version->version_code;
        $distanceCreate=session()->get('distanceCreate');
        return view('Pages.Vehicles.distance',compact('distance','distanceCreate'));
    }

    public function changeDistance(Request $request)
    {
        $this->validate($request,[
            'distance'=>'required',

        ]);
        session()->flash('distanceCreate', 'yes');
        Verion::where('id',100)->update(['version_code'=>$request->distance]);
        return redirect()->route('distance.createView');
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

    public function deleteCarType($id)
    {
        $carType=CarDetail::where('carId',$id)->delete();
        return redirect()->route('Vehicle.allTypes');
    }

    public function editCarType(Request $request)
    {
        $this->validate($request,[
                                    'carId'=>'required',
                                    'carName'=>'required',
                                    'arabicName'=>'required',
                                    'carSheet'=>'required',
                                    'Counterprice'=>'required',
                                    'priceByDistence'=>'required',
                                    'priceByTime'=>'required',
                                    'rushHoursPBT'=>'required',
                                    'rushHoursPBD'=>'required',
                                    'priority'=>'required',
                                            ]);
        $input['carId']=$request->carId;
        $input['carName']=$request->carName;
        $input['arabicName']=$request->arabicName;
        $input['carSheet']=$request->carSheet;
        $input['Counterprice']=$request->Counterprice;
        $input['priceByDistence']=$request->priceByDistence;
        $input['priceByTime']=$request->priceByTime;
        $input['arabicName']=$request->arabicName;
        $input['rushHoursPBT']=$request->rushHoursPBT;
        $input['rushHoursPBD']=$request->rushHoursPBD;
        $input['priority']=$request->priority;
        if($request->status== 'on')
            $input['status']=1;
        else 
            $input['status']=0;

        $file=$request->file('carImage');
        if($file)
        {
            $extension=$file->getClientOriginalExtension();
            $filename =$request->carId.".".$extension;
            $file->move('public/uploads/images/carImage/',$filename);
            $input['carImage']= $filename;
        }
    	CarDetail::where('carId',$request->carId)->update($input);
    	session()->flash('updateCarDetails','yes');
        return redirect()->route('Vehicle.allTypes');
    }

    public function createCarType_show()
    {
        $request=new CarDetail();
        return view('Pages.Vehicles.createVehicleType',compact('request'));
    }

    public function createCarType(Request $request)
    {
        $this->validate($request,[
            'carName'=>'required',
            'arabicName'=>'required',
            'carSheet'=>'required',
            'Counterprice'=>'required',
            'carImage'=>'required',
            'priceByDistence'=>'required',
            'priceByTime'=>'required',
            'rushHoursPBT'=>'required',
            'rushHoursPBD'=>'required',
            'priority'=>'required',
        ]);

        $input['carName']=$request->carName;
        $input['arabicName']=$request->arabicName;
        $input['carSheet']=$request->carSheet;
        $input['Counterprice']=$request->Counterprice;
        $input['priceByDistence']=$request->priceByDistence;
        $input['priceByTime']=$request->priceByTime;
        $input['arabicName']=$request->arabicName;
        $input['rushHoursPBT']=$request->rushHoursPBT;
        $input['rushHoursPBD']=$request->rushHoursPBD;
        $input['priority']=$request->priority;
        if($request->status== 'on')
            $input['status']=1;
        else
            $input['status']=0;
        $car=CarDetail::create($input);
        $file=$request->file('carImage');
        if($file)
        {
            $extension=$file->getClientOriginalExtension();
            $filename =$car->id.".".$extension;
            $file->move('public/uploads/images/carImage/',$filename);
            CarDetail::where('carId',$car->id)->update(['carImage'=> $filename]);
        }
        session()->flash('vehicleCreate', 'yes');
        return redirect()->route('Vehicle.allTypes');
    }

    public function vehicleRegistration()
    {

        $cartype['taxi']=VehicleDetails::where([['vehicledetail.vihicleType','=','1'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->count();
        $cartype['sedan']=VehicleDetails::where([['vehicledetail.vihicleType','=','2'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->count();
        $cartype['pickup']=VehicleDetails::where([['vehicledetail.vihicleType','=','8'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->count();
        $cartype['van']=VehicleDetails::where([['vehicledetail.vihicleType','=','5'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->count();
        $cartype['tow']=VehicleDetails::where([['vehicledetail.vihicleType','=','7'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->count();
        $cartype['dana']=VehicleDetails::where([['vehicledetail.vihicleType','=','11'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->count();

        $Date=date('Y-m-d');
        $startDate=date("Y-m-d",strtotime($Date)).' 00:00'; //00:00 start day time
        $endDate=date("Y-m-d",strtotime($Date)).' 23:59'; //23:59 end day time
        $cartype['taxi_daily']=VehicleDetails::where([['vehicledetail.vihicleType','=','1'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->whereBetween('vehicledetail.created_at', [$startDate, $endDate])->count();
        $cartype['sedan_daily']=VehicleDetails::where([['vehicledetail.vihicleType','=','2'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->whereBetween('vehicledetail.created_at', [$startDate, $endDate])->count();
        $cartype['pickup_daily']=VehicleDetails::where([['vehicledetail.vihicleType','=','8'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->whereBetween('vehicledetail.created_at', [$startDate, $endDate])->count();
        $cartype['van_daily']=VehicleDetails::where([['vehicledetail.vihicleType','=','5'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->whereBetween('vehicledetail.created_at', [$startDate, $endDate])->count();
        $cartype['tow_daily']=VehicleDetails::where([['vehicledetail.vihicleType','=','7'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->whereBetween('vehicledetail.created_at', [$startDate, $endDate])->count();
        $cartype['dana_daily']=VehicleDetails::where([['vehicledetail.vihicleType','=','11'],['users.mobileNumber','!=','0']])
            ->leftJoin('driverdetail', 'vehicledetail.driverId', '=', 'driverdetail.driveId')
            ->leftJoin('users', 'driverdetail.userId', '=', 'users.userId')->whereBetween('vehicledetail.created_at', [$startDate, $endDate])->count();

        //return $cartype['taxi_daily'];


        return view('Pages.Vehicles.vehicleRegistration',compact('cartype'));

    }
}
