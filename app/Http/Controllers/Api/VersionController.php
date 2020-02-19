<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Verion;
use Validator;

//*****Created By Usman Abbas*******//

class VersionController extends Controller
{
    public function versionCheck(Request $request)
    {
        $validation=Validator::make($request->all(), [
            'version_code'=>'required',
            'versionId'=>'required'
        ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            $ErrorDetail=['ErrorDetails'=>"Error in Version Checking Parameters",'ErrorMessage'=> $errors->toJson()];
            $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
            return  response()->json(array('array'=>$array), 200);
        }
    	if($request->versionId==1)
    	{
    		$version=Verion::where('id',$request->versionId)->first();
    	}
    	if ($request->versionId==2)
    	{
    		$version=Verion::where('id',$request->versionId)->first();
    	}

    	if ($version->version_code == $request->version_code)
    	{
    		$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
		    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
		    return  response()->json(array('array'=>$array), 200);
    	}
    	else
    	{
    		$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
			$array=array('ErrorDetail'=>$ErrorDetail,'Result'=>0);
		    return  response()->json(array('array'=>$array), 200);
    	}
    }

 	public function versionUpdate(Request $request)
    {
    	if($request->android==1)
    	{
    		Version::where('id',$request->android)->update(['version_code'=>$request->version_code]);	
    		$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
		    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
		    return  response()->json(array('array'=>$array), 200);
    	}
    	if ($request->ios==2)
    	{
    		$version=Version::where('id',$request->ios)->update(['version_code'=>$request->version_code]);
    		$ErrorDetail=['ErrorDetails'=>"",'ErrorMessage'=>""];
		    $array=array('ErrorDetail'=>$ErrorDetail,'Result'=>1);
		    return  response()->json(array('array'=>$array), 200);	
    	}
    }
       
}
