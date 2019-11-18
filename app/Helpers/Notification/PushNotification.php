<?php

namespace App\Helpers\Notification;

use Illuminate\Support\Facades\DB;
use App\User;

class PushNotification
{
    public static function SendPushNotification($msg, $data, $device_ids)
    {
         $fields = array(
                    'registration_ids' => $device_ids,
                    'data' => $data,
                    'notification' => $msg,
                    'content_available' => true,
                );
        
        

        $headers = array(
                'Authorization: key=AAAA2_5M_pw:APA91bFBHftmmTDDmAEqxTIBuglf4XoZ4dsuwzTzBVEc0JWsrBMXNWi9xtce0w63Sh8yy3wwvVhVInG04DzQejMFiOInYSGB5_D0POBG_TCETfm3wWEXI081q3ouw0_kEX7EbflmeXRP',
                'Content-Type: application/json'
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        
        curl_close($ch);
        return $result;
    }
}
