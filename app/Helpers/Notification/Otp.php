<?php

namespace App\Helpers\Notification;

use Illuminate\Support\Facades\DB;
use App\User;

class Otp
{
	public static function send_otp($mobilnumber,$otp)
	{
			 $xml_data ='<?xml version="1.0"?>
						<parent>
						<child>
						<user>SBUDDY</user>
						<key>2aea9304a8XX</key>
						<mobile>'.$mobilnumber.'</mobile>
						<message>'.$otp.'</message>
						<accusage>1</accusage>
						<senderid>SBUDDY</senderid>
						</child>
						</parent>';

			$URL = "http://dsms.iwebsoft.co.in/submitsms.jsp?"; 

			$ch = curl_init($URL);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
	}
}
