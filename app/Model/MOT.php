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


}
