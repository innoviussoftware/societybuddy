<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notice;
use App\Circular;
use App\Event;
use App\Member;
use App\User;
use App\Society;
use Auth;
use Validator;
use DB;
use App\Helpers\Notification\PushNotification;
use App\Notification;
use App\Settings;
class NoticeController extends Controller
{
    
	public function addnotice(Request $request)
	{
		  $validator = Validator::make($request->all(),[
           'society_id'  => 'required',
           'building_id'  => 'required',
           'title'  => 'required',
           'description'=>'required',
           'view_till'=>'required',
    	]);

    	if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());
            return response()->json(['data' => $errorMessage,'status'=>0,'message' => "Please enter valid data."] , 200);
      }else
      {
          $user_id=auth()->user()->id;

        	$notice=new Notice();
        	$notice->society_id=request('society_id');
        	$notice->building_id=request('building_id');
        	$notice->user_id=$user_id;
        	$notice->title=request('title');
        	$notice->description=request('description');
        	$notice->view_till=request('view_till');
        	$notice->save();

          $mysqlvalue= explode(",",request('building_id'));
          $token=[];
          $user_ids=[];
          foreach ($mysqlvalue as $value) 
          {
              $members=Member::where('building_id',$value)->where('society_id',request('society_id'))->get();

              foreach ($members as $value) {

                  $users=User::where('id',$value->user_id)->first();
                  $settings=Settings::where('user_id',$value->user_id)->where('notice',1)->first();

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
                        $notify->type=2;
                        $notify->save();

                        PushNotification::SendPushNotification($pmsg, $data, [$token]);
                  }
              }
          }

          return response()->json(['data' => $notice,'status'=>1,'message' => "Notice Added Successfully."] , 200);

        	
      }
	}

	public function getNotice(Request $request){

		$user_id=auth()->user()->id;

    $members=Member::where('user_id',$user_id)->first();

    $building_id=$members->building_id;

    $date = new \DateTime();
  
    $formatted_date = $date->format('Y-m-d');

    $notice=DB::table('notice')->whereRaw('find_in_set("'.$building_id.'",building_id)')->wheredate('view_till', '>=',$formatted_date)->orderBy('id','desc')->get();		
    
    return response()->json(['data' => $notice,'status'=>1,'message' => "Notice Details."] , 200);
	}

  public function editNotice(Request $request)
  {
      $validator = Validator::make($request->all(),[
           'society_id'  => 'required',
           'building_id'  => 'required',
           'title'  => 'required',
           'description'=>'required',
           'view_till'=>'required',
      ]);

      if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());
            return response()->json(['data' => $errorMessage,'status'=>0,'message' => "Please enter valid data."] , 200);
      }else
      {
          $user_id=auth()->user()->id;
          $id=request('notice_id');
          $society_id=request('society_id');
          $building_id=request('building_id');
          $title=request('title');
          $description=request('description');
          $view_till=request('view_till');

          $updateDetails = array(
            'society_id' => $society_id,
            'building_id' => $building_id,
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'view_till' => $view_till,
          );

          $notice = Notice::where('id', $id)->update($updateDetails);

          $notice = Notice::where('id', $id)->get();
          
          return response()->json(['data' => $notice,'status'=>1,'message' => "Notice Edited Successfully."] , 200);
      }
  }

  public function deleteNotice(Request $request)
  {
      $id=request('notice_id');

      $Notice=Notice::where('id',$id)->delete();

      if($Notice)
      {
          return response()->json(['data' => "1",'status'=>1,'message' => "Notice Deleted SuccessFully."] , 200);
      }
      else
      {
          return response()->json(['data' => "0",'status'=>0,'message' => "Notice Deleted Failed."] , 200);
      }
  }

  public function remainderNotification(Request $request)
  {
     $type=request('type');

     $user_id=auth()->user()->id;

     $id=request('id');

     $society_id=request('society_id');

     if($type=='1')
     {
        
        $notice = Notice::find($id);

          if($notice)
          {

            
            $mysqlvalue= explode(",",$notice->building_id);
            
            foreach ($mysqlvalue as $value) {
                $members=Member::where('building_id',$value)->where('society_id',$society_id)->get();
                foreach ($members as $value) {

                    $users=User::where('id',$value->user_id)->first();
                      
                    $settings=Settings::where('user_id',$value->user_id)->where('notice',1)->first();

                    if($settings !=null)
                    {
                      $token=$users->fcm_token; 

                      $societyName=Society::where('id',$society_id)->first();

                     // $str = implode(",", $user_ids);

                      $pmsg = array(
                              'body' => $notice->description,
                              'title' => $notice->title,
                              'icon' => 'myicon',
                              'sound' => 'mySound'
                      );

                      $data=array(
                            'notification_type'=>'Notice',
                            'title'=>$notice->title,
                            'description'=>$notice->description,
                      );

                      $notify=new Notification;
                      $notify->text=$notice->description;
                      $notify->user_id=$value->user_id;
                      $notify->type=2;
                      $notify->save();
                    
                      PushNotification::SendPushNotification($pmsg, $data, [$token]); 
                    }
                      
                }
            }

            // $device_id=$token;

            // $societyName=Society::where('id',$society_id)->first();

            // $str = implode(",", $user_ids);


          }
          return response()->json(['data' => "1",'status'=>1,'message' => "Notice Remainder SuccessFully."] , 200);
     }

     if($type=='2')
     {
          
          $notice = Event::find($id);
          if($notice)
          {
            $token=[];
            $user_ids=[];
            $mysqlvalue= explode(",",$notice->building_id);
            foreach ($mysqlvalue as $value) {
              $members=Member::where('building_id',$value)->where('society_id',$society_id)->get();
              foreach ($members as $value) {

                  $users=User::where('id',$value->user_id)->first();
                  //$user_ids[]=$value->user_id;
                  $settings=Settings::where('user_id',$value->user_id)->where('event',1)->first();

                  if($settings !=null)
                  {
                      $token=$users->fcm_token; 

                      $societyName=Society::where('id',$society_id)->first();
                      $pmsg = array(
                              'body' => $notice->description,
                              'title' => $notice->title,
                              'icon' => 'myicon',
                              'sound' => 'mySound'
                      );
                      $data=array(
                            'notification_type'=>'Event',
                            'title'=>$notice->title,
                            'description'=>$notice->description,
                      );
                      $notify=new Notification;
                      $notify->text=$notice->description;
                      $notify->user_id=$value->user_id;
                      $notify->type=1;
                      $notify->save();
                      PushNotification::SendPushNotification($pmsg, $data, [$token]); 
                  }
                    
              }
            }
          }
          return response()->json(['data' => "1",'status'=>1,'message' => "Event Remainder SuccessFully."] , 200);
     }

     if($type=='3')
     {
          $notice = Circular::find($id);

          if($notice)
          {

            $token=[];
            $user_ids=[];
            $mysqlvalue= explode(",",$notice->building_id);
            
            foreach ($mysqlvalue as $value) {
              $members=Member::where('building_id',$value)->where('society_id',$society_id)->get();
              foreach ($members as $value) {

                  $users=User::where('id',$value->user_id)->first();

                  $settings=Settings::where('user_id',$value->user_id)->where('circular',1)->first();
                  //$user_ids[]=$value->user_id;
                  if($settings !=null)
                  {
                      $token=$users->fcm_token;  

                      $societyName=Society::where('id',$society_id)->first();

                      $pmsg = array(
                              'body' => $notice->description,
                              'title' => $notice->title,
                              'icon' => 'myicon',
                              'sound' => 'mySound'
                      );

                      $data=array(
                            'notification_type'=>'Notice',
                            'title'=>$notice->title,
                            'description'=>$notice->description,
                      );

                      $notify=new Notification;
                      $notify->text=$notice->description;
                      $notify->user_id=$value->user_id;
                      $notify->type=3;
                      $notify->save();

                    PushNotification::SendPushNotification($pmsg, $data, [$token]);
                  }
                    
              }
            }
           
          }

          return response()->json(['data' => "1",'status'=>1,'message' => "Circular Remainder SuccessFully."] , 200);
     }     
  }
    
}
