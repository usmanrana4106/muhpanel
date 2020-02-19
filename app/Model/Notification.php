<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
//*****Created By Usman Abbas*******//

use PushNotification;

class Notification extends Model
{

    protected $apnsDir = '';
    protected $url;

    public function __construct() 
    {
        parent::__construct();
        $this->url = URL::to('/');
        $this->apnsDir = $this->url."/public/ApnsPHP/"; // Set pem file path
        $this->_apns_req();
        return;
    } 



  public static function silentNotify ($r,$ut,$nt = 'silent' )
  { 
        if (!defined('API_ACCESS_KEY')) define( 'API_ACCESS_KEY', 'AIzaSyA3IVLT7IIQP7HqqJJyLxhOG2IvvPa9XNU' );
        $tokenarray = $r;
       
        $msg = array(
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
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        return $result;
    }


    public static function notifyiOS($deviceToken,$title,$data='',$notifyType)
    {
         $message = PushNotification::Message($title,array(
                      'badge' => 1,
                      'sound' => 'default',
                      "content-available" => 1,
                      
                      'actionLocKey' => 'new booking',
                      'locKey' => 'localized key',
                      'locArgs' => array(
                          'localized args',
                          'localized args',

                      ),
                     'custom' => array(
                                        'notifyType' =>$notifyType,
                                        'message'=>$data,
                                        'content_available'=>true,
                                    ),
                  ));
        try
        {
             $push =  PushNotification::app('appNameIOS')
                              ->to($deviceToken)
                              ->send($message);
            return 1;
        } 
        catch (\Sly\NotificationPusher\Exception\AdapterException $e) 
        {
          return 0;
        }
    }


    public static function silentNotifyiOS($deviceToken,$notifyType='silent')
    {
         $message = PushNotification::Message('',array(
                      'badge' => 1,
                      'sound' => '',
                      "content-available" => 1,
                      
                      'actionLocKey' => 'new booking',
                      'locKey' => 'localized key',
                      'locArgs' => array(
                          'localized args',
                          'localized args',

                      ),
                     'custom' => array(
                                        'notifyType' =>$notifyType,
                                        
                                    )
                  ));
        try
        {
             $push =  PushNotification::app('appNameIOS')
                              ->to($deviceToken)
                              ->send($message);
            return 1;
        } 
        catch (\Sly\NotificationPusher\Exception\AdapterException $e) 
        {
          return 0;
        }
    }
}
