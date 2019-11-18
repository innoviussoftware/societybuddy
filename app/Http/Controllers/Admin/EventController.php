<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\City;
use App\User;
use App\Area;
use App\Society;
use App\Flat;
use App\Building;
use App\Member;
use App\Event;
use Auth;
use DB;
use App\Helpers\Notification\PushNotification;
use App\Notification;
use App\Settings;

class EventController extends Controller
{
    //
      public function index($id){

        $society = Society::find($id);
        if($society){
          $buildings = Building::where('society_id',$id)->get();
          return view('admin.events.index',["society" => $society]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function addEvents($id){

      $society = Society::find($id);
        $roles = Role::memberRoles();
        if($society){
          $buildings = Building::where('society_id',$id)->get();
          return view('admin.events.add',["society" => $society, 'buildings' => $buildings, 'roles' => $roles]);
        }else{
          return view('admin.errors.404');
        }

    }

    public function store(Request $request,$society_id){

    $user=Auth::user();

      $this->validate($request, [
          'event_type' => 'required',
          'title' => 'required',
          'description' => 'required',
          'attachment'=>'mimes:pdf,png,jpg'
      ]);
        $building_id=request('building_id');

        $array_comp_prod = implode(",", $building_id);

        if ($request->file('attachment')) {
            $image = $request->attachment;
            $path = $image->store('event_attachment');
        }

        $notice = new Event;
        $notice->event_type = request('event_type');
        $notice->title = request('title');
        $notice->description = request('description');
        $notice->event_start_date = request('startdate');
        $notice->event_start_time = request('starttime');
        $notice->event_end_date = request('enddate');
        $notice->event_end_time = request('endtime');
        $notice->event_attachment = isset($path)?$path:'';
        $notice->building_id = $array_comp_prod;
        $notice->society_id = $society_id;
        $notice->user_id = $user->id;
        $notice->save();

            $token=[];
            $user_ids=[];
            $mysqlvalue= explode(",",$notice->building_id);
            
            foreach ($mysqlvalue as $value) {
              $members=Member::where('building_id',$value)->where('society_id',$society_id)->get();
              foreach ($members as $value) {

                  $users=User::where('id',$value->user_id)->first();
                  $user_ids[]=$value->user_id;
                  $settings=Settings::where('user_id',$value->user_id)->where('event',1)->first();
                  if($settings !=null)
                  {
                        $token=$users->fcm_token;  
                        $societyName=Society::where('id',$society_id)->first();

                        $pmsg = array(
                                'body' => request('description'),
                                'title' => request('title'),
                                'icon' => 'myicon',
                                'sound' => 'mySound'
                        );

                        $data=array(
                              'notification_type'=>'Event',
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

        return redirect()->route('admin.societies.events.index',$society_id)->with("success","Event added successfully.");
    }

    public function checkForSocietyAdmin($society_id){
      //If user has role society_admin then make sure he/she can only access their society
      if(auth()->user()->hasRole('society_admin')){
        if(auth()->user()->society_id != $society_id){
          abort(403, 'Unauthorized action.');
        }
      }
    }

     public function edit($society_id,$id)
    {

        $this->checkForSocietyAdmin($society_id);

        $s = Society::find($society_id);

        $b = Event::find($id);
        if($b && $s){
          $buildings = Building::where("society_id",$society_id)->get();
          return view('admin.events.edit',["society" => $s,"notice" => $b,'buildings'=> $buildings,]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function update(Request $request, $society_id, $member_id){
        
        $user=Auth()->user();

        $this->validate($request, [
          'event_type' => 'required',
          'title' => 'required',
          'description' => 'required',
          'attachment'=>'mimes:pdf,png,jpg'
        ]);

        $notice = Event::find($member_id);

        if($notice)
        {
            $building_id=request('building_id');

            $array_comp_prod = implode(",", $building_id);
            if ($request->file('attachment')) {
              $image = $request->attachment;
              $path = $image->store('event_attachment');
            }
            else{
              $event_path=request('event_file');
            }
            $notice->event_type = request('event_type');
            $notice->title = request('title');
            $notice->description = request('description');
            $notice->event_start_date = request('startdate');
            $notice->event_start_time = request('starttime');
            $notice->event_end_date = request('enddate');
            $notice->event_end_time = request('endtime');
            $notice->event_attachment = isset($path)?$path:$event_path;
            $notice->building_id = $array_comp_prod;
            $notice->society_id = $society_id;
            $notice->user_id = $user->id;
            $notice->save();
        }
        return redirect()->route('admin.societies.events.index', $society_id)->with('success','Event updated successfully.');
    }

  
     public function Array(Request $request,$society_id){
            $response = [];

            $notice = \DB::table("events")
                ->select("events.*",\DB::raw("GROUP_CONCAT(buildings.name) as buildingsname"))
                ->leftjoin("buildings",\DB::raw("FIND_IN_SET(buildings.id,events.building_id)"),">",\DB::raw("'0'"))
                ->where('events.society_id',$society_id)
                ->groupBy("events.id")
                ->get();

            foreach ($notice as $s) {
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->event_type;
                $sub[] = $s->title;
                $sub[] = $s->description;
                $sub[] = date('d-m-Y',strtotime($s->event_start_date)) .'-'.$s->event_start_time;
                $sub[] = date('d-m-Y',strtotime($s->event_end_date)) .'-'.$s->event_end_time;
                $sub[] = $s->buildingsname;

                $delete_url = route('admin.societies.events.delete', ["society_id" => $society_id, "member_id" => $id]);

                $notify_url = route('admin.societies.events.notify', ["society_id" => $society_id, "member_id" => $id]);
             
                $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.events.edit', ["society_id" => $society_id, "notice_id" => $id]).'"><i class="fa fa-pencil-square-o"></i></a>' . ' ';

                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.$delete_url.'"><i class="fa fa-trash"></i>&nbsp;</a>';

                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to send notification?`)"  href="'.$notify_url.'"><i class="fa fa-bell-o"></i>&nbsp;</a></div>';

                $sub[] = $action;

                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }

        public function delete($society_id,$member_id){
          $notice = Event::find($member_id);

          if($notice)
          {
            $notice->delete();
          }

          return redirect()->route('admin.societies.events.index',$society_id)->with('success','Notice deleted successfully.');

    }

    public function notify($society_id,$member_id){
          
          $notice = Event::find($member_id);

          if($notice)
          {

            $token=[];
            $user_ids=[];
            $mysqlvalue= explode(",",$notice->building_id);
            
            foreach ($mysqlvalue as $value) {
              $members=Member::where('building_id',$value)->where('society_id',$society_id)->get();
              foreach ($members as $value) {

                  $users=User::where('id',$value->user_id)->first();
                  $user_ids[]=$value->user_id;
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
          return redirect()->route('admin.societies.events.index',$society_id)->with('success','Notification sent successfully.');
        }
}
