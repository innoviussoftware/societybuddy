<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Member;
use App\User;
use App\Society;
use Validator;
use DB;
use App\Helpers\Notification\PushNotification;
use App\Notification;
use App\Settings;

class EventController extends Controller
{
    //
    public function addevent(Request $request)
	{
		  $validator = Validator::make($request->all(),[          
           'society_id'  => 'required',
           'title' => 'required',
           'description'  => 'required',
           'event_start_time'=>'required',
           'event_start_date'=>'required',
           'event_end_time'=>'required',
           'event_end_date'=>'required',
           'event_type'=>'required',
          // 'event_attachment'=>'mimes:pdf,png,jpg'
    	]);

    	if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());
            return response()->json(['data' => $errorMessage,'status'=>0,'message' => "Please enter valid data."] , 200);
        }else
        {
        	
        	$user_id=auth()->user()->id;
        	if(request('event_attachment'))
            {
                $img = request('event_attachment');
                $custom_file_name = 'event-'.time().'.'.$img->getClientOriginalExtension();
                $events = $img->storeAs('events', $custom_file_name);
            }

        	$event=new Event();
        	$event->user_id=$user_id;        	
        	$event->society_id=request('society_id');
          $event->building_id=request('building_id');
        	$event->title=request('title');
        	$event->description=request('description');
        	$event->event_start_time=request('event_start_time');
        	$event->event_start_date=request('event_start_date');
        	$event->event_end_time=request('event_end_time');
        	$event->event_end_date=request('event_end_date');
        	$event->event_type=request('event_type');
        	if(request('event_attachment'))
            {
                $event->event_attachment = $events;
            }
        	$event->save();

          $mysqlvalue= explode(",",request('building_id'));

          $token=[];
          $user_ids=[];

          foreach ($mysqlvalue as $value) 
          {
              $members=Member::where('building_id',$value)->where('society_id',request('society_id'))->get();

              foreach ($members as $value) {

                  $users=User::where('id',$value->user_id)->first();
                  //$user_ids[]=$value->user_id;
                  $settings=Settings::where('user_id',$value->user_id)->where('event',1)->first();

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
                        $notify->type=1;
                        $notify->save();

                        PushNotification::SendPushNotification($pmsg, $data, [$token]);
                  }
                  
              }
          }

        //  $device_id=$token;

          


          return response()->json(['data' => $event,'status'=>1,'message' => "Event Added Successfully."] , 200);
        }
	}

	public function getEvent(Request $request)
  {

		$user_id=auth()->user()->id;

    $members=Member::where('user_id',$user_id)->first();

    $building_id=$members->building_id;

    $date = new \DateTime();
  
    $formatted_date = $date->format('Y-m-d');
    

    $Event=DB::table('events')->whereRaw('find_in_set("'.$building_id.'",building_id)')->wheredate('event_end_date', '>=',$formatted_date)->orderBy('id','desc')->get();
		
    return response()->json(['data' => $Event,'status'=>1,'message' => "Event Details."] , 200);
	}

  public function editEvent(Request $request)
  {
      $validator = Validator::make($request->all(),[
           'society_id'  => 'required',
           'title' => 'required',
           'description'  => 'required',
           'event_start_time'=>'required',
           'event_start_date'=>'required',
           'event_end_time'=>'required',
           'event_end_date'=>'required',
           'event_type'=>'required',
           //'event_attachment'=>'mimes:pdf,png,jpg'
      ]);

      if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());
            return response()->json(['data' => $errorMessage,'status'=>0,'message' => "Please enter valid data."] , 200);
        }else
        {
          
          $user_id=auth()->user()->id;
          $id=request('event_id');

          if(request('event_attachment'))
          {
                $img = request('event_attachment');
                $custom_file_name = 'event-'.time().'.'.$img->getClientOriginalExtension();
                $events = $img->storeAs('events', $custom_file_name);
          }

          $society_id=request('society_id');
          $building_id=request('building_id');
          $event_start_time=request('event_start_time');
          $event_start_date=request('event_start_date');
          $event_end_time=request('event_end_time');
          $event_end_date=request('event_end_date');
          $event_type=request('event_type');
          $title=request('title');
          $description=request('description');

          if(request('event_attachment'))
          {
                $updateDetails = array(
                  'society_id' => $society_id,
                  'building_id' => $building_id,
                  'user_id' => $user_id,
                  'event_type' => $event_type,
                  'title' => $title,
                  'description' => $description,
                  'event_start_date' => $event_start_date,
                  'event_start_time' => $event_start_time,
                  'event_end_date' => $event_end_date,
                  'event_end_time' => $event_end_time,
                  'event_attachment' => isset($events)?$events:'',
                );
          }
          else
          {
                $updateDetails = array(
                  'society_id' => $society_id,
                  'building_id' => $building_id,
                  'user_id' => $user_id,
                  'event_type' => $event_type,
                  'title' => $title,
                  'description' => $description,
                  'event_start_date' => $event_start_date,
                  'event_start_time' => $event_start_time,
                  'event_end_date' => $event_end_date,
                  'event_end_time' => $event_end_time,
                );
          }
          

          $Event=Event::where('id', $id)->update($updateDetails);

          $Event = Event::where('id', $id)->get();

          return response()->json(['data' => $Event,'status'=>1,'message' => "Event Edited Successfully."] , 200);

        }
  }

  public function deleteEvent(Request $request)
  {
      $id=request('event_id');

      $Event=Event::where('id',$id)->delete();

      if($Event)
      {
          return response()->json(['data' => "1",'status'=>1,'message' => "Event Deleted SuccessFully."] , 200);
      }
      else
      {
          return response()->json(['data' => "0",'status'=>0,'message' => "Event Deleted Failed."] , 200);
      
      }
  }
}
