<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use Auth;

class MailController extends Controller
{
    //

    public function sendfeedback(Request $request)
    {
        $this->validate($request, ['email' => 'required|email'] );

        $data = array(
            'name' => $request->first_name,
            'surname' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'city' => $request->city,
        );

        // Mail::send('emails.contact', $data, function($message) use ($data){
        //     $message->from($data['email']);
        //     $message->to('jafar@calmcollective.co.uk');
        //     $message->subject('Contact Details');
        // });

        return response()->json(['success' => 'Your E-mail was sent! Allegedly.'], 200);
     }
}
