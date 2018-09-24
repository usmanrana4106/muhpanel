<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//*****Created By Usman Abbas*******//
class Notification extends Model
{
	public static function notify ($r, $t, $m, $ut = '', $nt = '' )
	{
        
        if (!defined('API_ACCESS_KEY')) define( 'API_ACCESS_KEY', 'AIzaSyA3IVLT7IIQP7HqqJJyLxhOG2IvvPa9XNU' );
        $tokenarray = $r;
       
		$msg = array(
			'title'    	  => $t,
			'message'     => $m,
			'userType'    => $ut,
			'notifyType'  => $nt, 
		);
       
        $fields = array(
            'registration_ids' => $tokenarray,
            'data'             => $msg
        );

        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        return $result;
    }

}
