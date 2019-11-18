<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\City;
use App\User;
use App\Area;
use App\Society;
use App\Notice;
use App\Flat;
use App\Building;
use App\Member;
use Auth;
use DB;
use App\Helpers\Notification\PushNotification;
use App\Notification;
use App\Settings;

class NoticeController extends Controller
{
    //
    public function index($id){

        $society = Society::find($id);
        if($society){
        	$buildings = Building::where('society_id',$id)->get();
          return view('admin.notice.index',["society" => $society]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function addNotices($id){

    	$society = Society::find($id);
        $roles = Role::memberRoles();
        if($society){
          $buildings = Building::where('society_id',$id)->get();
          return view('admin.notice.add',["society" => $society, 'buildings' => $buildings, 'roles' => $roles]);
        }else{
          return view('admin.errors.404');
        }

    }

    public function store(Request $request,$society_id){

	$user=Auth::user();

      $this->validate($request, [
          'title' => 'required',
          'description' => 'required',
          'viewtill' => 'required',
      ]);
        $building_id=request('building_id');

        $array_comp_prod = implode(",", $building_id);
        $notice = new Notice;
        $notice->title = request('title');
        $notice->description = request('description');
        $notice->view_till = request('viewtill');
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
              $settings=Settings::where('user_id',$value->user_id)->where('notice',1)->first();
              if($settings !=null)
              {
                $token=$users->fcm_token;  
                $societyName=Society::where('id',$society_id)->first();

                $str = implode(",", $user_ids);

                $pmsg = array(
                        'body' => request('description'),
                        'title' => request('title'),
                        'icon' => 'myicon',
                        'sound' => 'mySound'
                );

                $data=array(
                      'notification_type'=>'Notice',
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

     
        

        return redirect()->route('admin.societies.notices.index',$society_id)->with("success","Notice added successfully.");
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

        $b = Notice::find($id);
        if($b && $s){
        	$buildings = Building::where("society_id",$society_id)->get();
          return view('admin.notice.edit',["society" => $s,"notice" => $b,'buildings'=> $buildings,]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function update(Request $request, $society_id, $member_id){
        
        $user=Auth()->user();

         $this->validate($request, [
	          'building_id' => 'required',
	          'title' => 'required',
	          'description' => 'required',
	          'view_till' => 'required',
      	]);
        $notice = Notice::find($member_id);

      if($notice){
         $building_id=request('building_id');

         $array_comp_prod = implode(",", $building_id);
          $notice->society_id = $society_id;
          $notice->building_id = $array_comp_prod;
          $notice->user_id = $user->id;
          $notice->title = request('title');
          $notice->description = request('description');
          $notice->view_till = request('view_till');
          $notice->save();
        }
        return redirect()->route('admin.societies.notices.index', $society_id)->with('success','Notice updated successfully.');
    }

  
     public function Array(Request $request,$society_id){
            $response = [];
            
           
            $notice = \DB::table("notice")
        ->select("notice.*",\DB::raw("GROUP_CONCAT(buildings.name) as buildingsname"))
        ->leftjoin("buildings",\DB::raw("FIND_IN_SET(buildings.id,notice.building_id)"),">",\DB::raw("'0'"))
        ->where('notice.society_id',$society_id)
        ->groupBy("notice.id")
        ->get();
            foreach ($notice as $s) {

                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->title;
                $sub[] = $s->description;
                $sub[] = date('d-m-Y',strtotime($s->view_till));
                $sub[] = $s->buildingsname;

                // $sub[] = "<img src='$s->document' width='100'/>";
                $delete_url = route('admin.societies.notices.delete', ["society_id" => $society_id, "member_id" => $id]);

                $notify_url = route('admin.societies.notices.notify', ["society_id" => $society_id, "member_id" => $id]);
             
                $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.notices.edit', ["society_id" => $society_id, "notice_id" => $id]).'"><i class="fa fa-pencil-square-o"></i></a>' . ' ';

                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.$delete_url.'"><i class="fa fa-trash"></i>&nbsp;</a>';

                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to send notification?`)"  href="'.$notify_url.'"><i class="fa fa-bell-o"></i>&nbsp;</a></div>';

                $sub[] = $action;

                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }

        public function delete($society_id,$member_id){
	        $notice = Notice::find($member_id);

	        if($notice)
	        {
	          $notice->delete();
	        }
	        return redirect()->route('admin.societies.notices.index',$society_id)->with('success','Notice deleted successfully.');
        }

        public function notify($society_id,$member_id){
          
          $notice = Notice::find($member_id);

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

                   $settings=Settings::where('user_id',$value->user_id)->where('notice',1)->first();
                    if($settings !=null)
                    {
                        $token=$users->fcm_token;  
                        $societyName=Society::where('id',$society_id)->first();

                        $str = implode(",", $user_ids);

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

          }
          return redirect()->route('admin.societies.notices.index',$society_id)->with('success','Notification sent successfully.');
        }

   
}
