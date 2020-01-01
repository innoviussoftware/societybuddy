<?php

namespace App\Helpers\Notification;

use Illuminate\Support\Facades\DB;
use App\User;

class PushNotificationDemo
{
    public static function SendPushNotification($msg, $data,$device_ids)
    {
         $fields = array(
                    'registration_ids' => $device_ids,
                    'data' => $data,
                    'notification' => $msg,
                    'content_available' => true,
                );
        
        

        $headers = array(
                'Authorization: key=AAAAQ5vGmpc:APA91bEG8UeQWcWDjbYoAJy1WPHGSj8IDbk3H5L8PkSF50l3FCGeuT9RZy_UtfAuoKXIduu6ugkK3kAe043RgytpDLOQWY_MFrB0g9qQfp2tRwRck0TFj_m1P3bae81qB4HGuyOx0wqS',
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
