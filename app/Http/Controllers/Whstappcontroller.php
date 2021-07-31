<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class Whstappcontroller extends Controller
{
    
    public function test()
    {
        // Find your Account SID and Auth Token at twilio.com/console
		// and set the environment variables. See http://twil.io/secure
		$sid = 'ACb2ad2cef38e416fa4ba454d4779b300f';
		$token = '4068ee81e01861f1983f5189b4a78d72';
		$twilio = new Client($sid, $token);
		$body = "Size : 20, Qty : 16 \n Size : 22, Qty : 18";
		$message = $twilio->messages
		                  ->create("whatsapp:+917203957277", // to
		                           [
		                               "from" => "whatsapp:+14155238886",
		                               "body" => $body,
		                               "MediaUrl" => 'http://3.23.151.152/school/public/uniforms/15960068471789386045.jpeg'
		                           ]
		                  );

		print($message);

    }
}
