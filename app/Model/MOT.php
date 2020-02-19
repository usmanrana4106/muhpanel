<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//*****Created By Usman Abbas*******//


class MOT extends Model
{
    public static function call_api($data_string,$url)
	{
		$ch = curl_init($url);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		curl_setopt($ch, CURLOPT_SSLVERSION,6);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                                                                     
		$result = curl_exec($ch);
		$var=curl_getinfo($ch);
        // print_r($var);
        // die;
		return $result;
	}


	public static function hitMotForDriver($data)
	{
		$driver_data = array("apiKey" => "8EF7AA53-3860-4242-955F-7AC218FDE3C1", "captainIdentityNumber" => $data['captainIdentityNumber'] , "dateOfBirth" =>  $data['dateOfBirth'],"emailAddress" =>$data['email'],"mobileNumber"=>$data['mobileNumber']); 

        $driver_data_string = json_encode($driver_data); 
        $url = "https://wasl.elm.sa/WaslPortalWeb/rest/DriverRegistration/send"; 
        $driver_api_response = MOT::call_api($driver_data_string,$url);
        $notapprovedMOT='0';
        $data_decode = json_decode($driver_api_response,true);
        $input['ReferenceNumber']=0;
        $input['notapprovedMOT']=0;
        $input['error']=0;
        $input['errorMessage']='';

        if($data_decode['resultCode']=='100')
        {
            $input['ReferenceNumber'] = $data_decode['referenceNumber'];
        }
        else
        {            
        	$input['errorMessage'] = $data_decode['resultMessage'];
            $input['error']=1;
        }

        return $input;
	}

	public static function hitMotForDriverVehicle($data)
	{
		$vehicle_data = array("apiKey" => "8EF7AA53-3860-4242-955F-7AC218FDE3C1", "vehicleSequenceNumber" => $data['vihicleNumber'], "plateLetterRight" => $data['plateLetterRight'],"plateLetterMiddle" =>$data['plateLetterMiddle'],"plateLetterLeft"=>$data['plateLetterLeft'],"plateNumber"=>$data['plateNumber'],"plateType"=>$data['plateType']);

            $vehicle_data_string = json_encode($vehicle_data);
            $vurl = "https://wasl.elm.sa/WaslPortalWeb/rest/VehicleRegistration/send"; 
            $vehicle_api_response = Mot::call_api($vehicle_data_string,$vurl);
            $vehicle_data_decode = json_decode($vehicle_api_response,true);

             $input['vehicleApproval']=0;
             $input['vehiclerefnumber']=0;
             $input['error']=0;
      	     $input['errorMessage']='';

            if($vehicle_data_decode['resultCode']=='100')
            {
              
                $input['vehiclerefnumber'] = $vehicle_data_decode['vehicleReferenceNumber'];
                 $input['vehicleApproval']='1';
                //    $vehiclerefnumber='454885';
       		}
            elseif($vehicle_data_decode['resultCode']!='100')
            {
            	$input['errorMessage'] = $vehicle_data_decode['resultMessage'];
				$input['error']=1;
            }
            return $input;
	}


    public static function motNewApi($data_string,$url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'client-id: 8EF7AA53-3860-4242-955F-7AC218FDE3C1',
                'app-id: 25f3e150',
                'app-key: d8cf2df2909c7dff1e7033925f5f14c7',
                'Content-Length: ' . strlen($data_string))
        );
        curl_setopt($ch, CURLOPT_SSLVERSION,6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $var=curl_getinfo($ch);
        // print_r($var);
        // die;
        return $result;
    }
}
