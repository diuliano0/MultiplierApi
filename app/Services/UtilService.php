<?php

namespace App\Services;

use PHPJasper\PHPJasper;
use App\Repositories\PaginaRepository;


/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 03/01/17
 * Time: 14:49
 */
class UtilService
{
    public function __construct()
    {
    }

    public function curlFunction($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function curlFunctionProxy($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($this->check("192.168.2.254:3128")){
            curl_setopt($ch, CURLOPT_PROXY, "http://192.168.2.254"); //your proxy url
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "diuliano:123456"); //username:pass
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function check($proxy=null)
    {
        $proxy=  explode(':', $proxy);
        $host = $proxy[0];
        $port = $proxy[1];
        $waitTimeoutInSeconds = 10;

        if($fp = @fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){
            fclose($fp);
            return true;
        } else {
            return false;
        }
    }

    public static function FCMPush($token, $title, $body)
	{
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		//$token="fQg4P2cm3X8:APA91bENaLV4ignDpCN9Lg_ggBMM4lcedsmMlIOtpJct0lacqdo_tBUBqz6BhzCVFXkzA-R0_6VYWRMtXPf-i74-dg1dQGS_xscZsJLoew8Gfq_kY3l8VA9I_6ZqugOg6rxrfbuW-rNH";


		$notification = [
			'title' => $title,
			'body' => $body,
		];

		$extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

		$fcmNotification = [
			//'registration_ids' => $tokenList, //multple token array
			'to'        => $token, //single token
			'notification' => $notification,
			'data' => $extraNotificationData
		];

		$headers = [
			'Authorization: key=AIzaSyDciIJWVPWsubwpfYwxCF9RYgo0mUIdmVg',
			'Content-Type: application/json'
		];


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$fcmUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
		$result = curl_exec($ch);
		curl_close($ch);


		return $result;
	}

    public static function FCMPushAll($title, $body)
	{
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		//$token="fQg4P2cm3X8:APA91bENaLV4ignDpCN9Lg_ggBMM4lcedsmMlIOtpJct0lacqdo_tBUBqz6BhzCVFXkzA-R0_6VYWRMtXPf-i74-dg1dQGS_xscZsJLoew8Gfq_kY3l8VA9I_6ZqugOg6rxrfbuW-rNH";


		$notification = [
			'title' => $title,
			'body' => $body,
		];

		$extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

		$fcmNotification = [
			//'registration_ids' => $tokenList, //multple token array
			//'to'        => $token, //single token
			'notification' => $notification,
			'data' => $extraNotificationData
		];

		$headers = [
			'Authorization: key=AIzaSyDL1UwekBP3vGMHurowE3XWErvf10Xj7kw',
			'Content-Type: application/json'
		];


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$fcmUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
		$result = curl_exec($ch);
		curl_close($ch);


		return $result;
	}

    public static function FCMPushMulti(array $tokens, $title, $body)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        //$token="fQg4P2cm3X8:APA91bENaLV4ignDpCN9Lg_ggBMM4lcedsmMlIOtpJct0lacqdo_tBUBqz6BhzCVFXkzA-R0_6VYWRMtXPf-i74-dg1dQGS_xscZsJLoew8Gfq_kY3l8VA9I_6ZqugOg6rxrfbuW-rNH";


        $notification = [
            'title' => $title,
            'body' => $body,
        ];

        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            'registration_ids' => $tokens, //multple token array
            //'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=AIzaSyDL1UwekBP3vGMHurowE3XWErvf10Xj7kw',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);


        return $result;
    }

    static public function generateRelatorioJasper($input, $output, $options){
        $jasper = new PHPJasper();

        return $jasper->process( $input, $output, $options)->execute();

    }

}
