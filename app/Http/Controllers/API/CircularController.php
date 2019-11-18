<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Circular;
use App\Member;
use App\User;
use App\Society;
use Validator;
use DB;
use App\Helpers\Notification\PushNotification;
use App\Notification;
use App\Helpers\Notification\Otp;
use App\Settings;

class CircularController extends Controller
{
    //
    public function addcircular(Request $request)
	{
		$validator = Validator::make($request->all(),[
           'society_id'  => 'required',
           'building_id'  => 'required',
           'title' => 'required',
           'description'  => 'required',
           'pdffile'=>'mimes:pdf,png,jpg'
    	]);

    	if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());
            return response()->json(['data' => $errorMessage,'status'=>0,'message' => "Please enter valid data."] , 200);
        }else
        {
        	if(request('pdffile'))
            {
                $img = request('pdffile');
                $custom_file_name = 'circular-'.time().'.'.$img->getClientOriginalExtension();
                $events = $img->storeAs('circular', $custom_file_name);
            }
            $user_id=auth()->user()->id;

        	$circular=new Circular();
        	$circular->user_id=$user_id;
        	$circular->society_id=request('society_id');
        	$circular->building_id=request('building_id');
        	$circular->title=request('title');
        	$circular->description=request('description');
        	if(request('pdffile'))
            {
                $circular->pdffile=$events;
            }
        	
        	$circular->save();

            $mysqlvalue= explode(",",request('building_id'));

              $token=[];
              $user_ids=[];

              foreach ($mysqlvalue as $value) 
              {
                  $members=Member::where('building_id',$value)->where('society_id',request('society_id'))->get();

                  foreach ($members as $value) {

                      $users=User::where('id',$value->user_id)->first();

                      $settings=Settings::where('user_id',$value->user_id)->where('circular',1)->first();

                      if($settings !=null)
                      {

                        $token=$users->fcm_token;  

                        $societyName=Society::where('id',request('society_id'))->first();

                        $pmsg = array(
                              'body' => request('description'),
                              'title' => request('title'),
                              'icon' => 'myicon',
                              'sound' => 'mySound'
                        );

                        $data=array(
                            'notification_type'=>'Circular',
                            'title'=>request('title'),
                            'description'=>request('description'),
                        );

                        $notify=new Notification;
                        $notify->text=request('description');
                        $notify->user_id=$value->user_id;
                        $notify->type=3;
                        $notify->save();

                        PushNotification::SendPushNotification($pmsg, $data, [$token]);
                      }
                      //$user_ids=$value->user_id;


                  }
              }

              


          return response()->json(['data' => $circular,'status'=>1,'message' => "Circular Added Successfully."] , 200);

        }
	}

	public function getCircular(Request $request){

		$user_id=auth()->user()->id;
		
    $members=Member::where('user_id',$user_id)->first();

    $building_id=$members->building_id;
    
    $date = new \DateTime();
  
    //$formatted_date = $date->format('Y-m-d');
    
    $Circular=DB::table('circular')->whereRaw('find_in_set("'.$building_id.'",building_id)')->orderBy('id','desc')->get();

    return response()->json(['data' => $Circular,'status'=>1,'message' => "Circular Details."] , 200);
		
	}

    public function editCircular(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'society_id'  => 'required',
           'building_id'  => 'required',
           'title' => 'required',
           'description'  => 'required',
           'pdffile'=>'mimes:pdf,png,jpg'
        ]);

        if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());
            return response()->json(['data' => $errorMessage,'status'=>0,'message' => "Please enter valid data."] , 200);
        }else
        {

            if(request('pdffile'))
            {
                $img = request('pdffile');
                $custom_file_name = 'circular-'.time().'.'.$img->getClientOriginalExtension();
                $events = $img->storeAs('circular', $custom_file_name);
            }
            $user_id=auth()->user()->id;
            $id=request('circular_id');
            $society_id=request('society_id');
            $building_id=request('building_id');
            $title=request('title');
            $description=request('description');
            

            if(request('pdffile'))
            {
                    $updateDetails = array(
                        'society_id' => $society_id,
                        'building_id' => $building_id,
                         'user_id' => $user_id,
                        'title' => $title,
                        'description' => $description,
                        'pdffile'=>isset($events)?$events:'',
                    );
            }
            else
            {
                     $updateDetails = array(
                        'society_id' => $society_id,
                        'building_id' => $building_id,
                        'user_id' => $user_id,
                        'title' => $title,
                        'description' => $description,                        
                    );
            }
           

            $circular=Circular::where('id', $id)->update($updateDetails);

            $circular = Circular::where('id', $id)->get();

            return response()->json(['data' => $circular,'status'=>1,'message' => "Circular Edited Successfully."] , 200);  
        }

    }

    public function deleteCircular(Request $request)
    {
        $id=request('circular_id');

        $circular=Circular::where('id',$id)->delete();

        if($circular)
        {
              return response()->json(['data' => "1",'status'=>1,'message' => "Circular Deleted SuccessFully."] , 200);
        }
        else
        {
              return response()->json(['data' => "0",'status'=>0,'message' => "Circular Deleted Failed."] , 200);
        }
    }

    public function sendotpNewcode(Request $request)
    {

        $validator = Validator::make($request->all(), [
                   'phone'  => 'required | min:9 | max:13'
        ]);
        if ($validator->fails()) {
            $errorArray = $validator->errors()->all();
            return response()->json(['data' =>(Object) $errorArray,'status'=>0,'message' => "Please enter valid data."] , 200);
        }
        else
        {
            $phone=request('phone');

            $data['otp'] = rand(1000,9999);

            $otp="Your One Time Password for Society Buddy is: ".$data['otp'];

            Otp::send_otp($phone,$otp);

            return response()->json(['data' => $data,'status'=>1,'message' => "Successfully Sent Otp.",'isapporve'=>1] , 200);
        }
        

    }
}
