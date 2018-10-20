<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{

    // method use to send sms
    public static function sendSms($number = null, $message = null)
    {

        $ch = curl_init();
        $parameters = array(
            'apikey' => '1f84034453772c09dec3e7d5c6597f2f', //Your API KEY
            'number' =>  $number,
            'message' => 'CampusGrabber ' . $message,
            'sendername' => 'SEMAPHORE' // sender name
        );
        curl_setopt( $ch, CURLOPT_URL,'https://api.semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);

        //Show the server response
        // return $output;

    }

}
