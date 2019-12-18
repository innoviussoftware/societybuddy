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
use App\Circular;
use Auth;
use DB;
use App\Helpers\Notification\PushNotification;
use App\Notification;
use App\Settings;

class CircularController extends Controller
{
    //
    public function index($id){

        $society = Society::find($id);
        if($society){
          $buildings = Building::where('society_id',$id)->get();
          return view('admin.circular.index',["society" => $society]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function addCirculars($id){

      $society = Society::find($id);
        $roles = Role::memberRoles();
        if($society){
          $buildings = Building::where('society_id',$id)->get();
          return view('admin.circular.add',["society" => $society, 'buildings' => $buildings, 'roles' => $roles]);
        }else{
          return view('admin.errors.404');
        }

    }

    public function store(Request $request,$society_id){

      $user=Auth::user();

      $this->validate($request, [
          'title' => 'required',
          'description' => 'required',
          'pdf'=>'mimes:pdf,png,jpeg'
      ]);
        $building_id=request('building_id');

        $array_comp_prod = implode(",", $building_id);

        if ($request->file('pdf')) {
            $image = $request->pdf;
            $path = $image->store('circularfile');
        }

        $notice = new Circular;
        $notice->title = request('title');
        $notice->description = request('description');
        $notice->pdffile = request('viewtill');
        $notice->building_id = $array_comp_prod;
        $notice->society_id = $society_id;
        $notice->user_id = $user->id;
        $notice->pdffile = isset($path)?$path:'';
        $notice->save();

        $token=[];
        $user_ids=[];
            $mysqlvalue= explode(",",$notice->building_id);
            
            foreach ($mysqlvalue as $value) {
              $members=Member::where('building_id',$value)->where('society_id',$society_id)->get();
              foreach ($members as $value) {

                  $users=User::where('id',$value->user_id)->first();
                  $societyName=Society::where('id',$society_id)->first();
                  $settings=Settings::where('user_id',$value->user_id)->where('circular',1)->first();

                  if($settings !=null)
                  {
                      $token=$users->fcm_token; 

                      $pmsg = array(
                              'body' => request('description'),
                              'title' =>request('title'),
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
                  $user_ids[]=$value->user_id;
                  
              }
            }
            

        return redirect()->route('admin.societies.circulars.index',$society_id)->with("success","Circular added successfully.");
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

        $b = Circular::find($id);
        if($b && $s){
          $buildings = Building::where("society_id",$society_id)->get();
          return view('admin.circular.edit',["society" => $s,"notice" => $b,'buildings'=> $buildings,]);
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
            'pdf'=>'mimes:pdf,png,jpeg'
                 
        ]);
        $notice = Circular::find($member_id);

      if($notice){
          $building_id=request('building_id');

          $array_comp_prod = implode(",", $building_id);
          
          if ($request->file('pdf')) {
            $image = $request->pdf;
            $path = $image->store('circularfile');
          }
          else
          {
            $circular_path=request('circularfile');
          }

          $notice->society_id = $society_id;
          $notice->building_id = $array_comp_prod;
          $notice->user_id = $user->id;
          $notice->title = request('title');
          $notice->description = request('description');
          $notice->pdffile=isset($path)?$path:$circular_path;
          $notice->save();
        }
        return redirect()->route('admin.societies.circulars.index', $society_id)->with('success','Circular updated successfully.');
    }

  
     public function Array(Request $request,$society_id){
            $response = [];
            
            //$notice = Circular::where("society_id",$society_id)->get();
            $notice = \DB::table("circular")
        ->select("circular.*",\DB::raw("GROUP_CONCAT(buildings.name) as buildingsname"))
        ->leftjoin("buildings",\DB::raw("FIND_IN_SET(buildings.id,circular.building_id)"),">",\DB::raw("'0'"))
        ->where('circular.society_id',$society_id)
        ->groupBy("circular.id")
        ->get();
        
            foreach ($notice as $s) {

                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->title;
                $sub[] = $s->description;
                $sub[] = $s->buildingsname;

                $ext = pathinfo($s->pdffile, PATHINFO_EXTENSION);

                $img   = env('APP_URL_STORAGE').$s->pdffile;

                if($ext=='jpeg' || $ext=='jpg'||$ext=='png'||$ext=='bmp')
                {
                    $sub[] = "<a class='example-image-link' href='".$img."' data-lightbox='example-1'><img width='50' class='example-image' src='".$img."' alt='image-1' /></a>";
                }elseif ($ext=='pdf') {

                    $sub[] = "<a href='".$img."' download><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
                }else{
                    $sub[] = "<a href='".$img."' download><i class='fa fa-file' aria-hidden='true'></i></a>";
                }


                // $sub[] = "<img src='$s->document' width='100'/>";
                $delete_url = route('admin.societies.circulars.delete', ["society_id" => $society_id, "member_id" => $id]);

                 $notify_url = route('admin.societies.circulars.notify', ["society_id" => $society_id, "member_id" => $id]);


  
             
                $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.circulars.edit', ["society_id" => $society_id, "notice_id" => $id]).'"><i class="fa fa-pencil-square-o"></i></a>' . ' ';

                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.$delete_url.'"><i class="fa fa-trash"></i>&nbsp;</a>';

                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to send notification?`)"  href="'.$notify_url.'"><i class="fa fa-bell-o"></i>&nbsp;</a></div>';

                $sub[] = $action;

                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }

        public function delete($society_id,$member_id){
          $notice = Circular::find($member_id);

          if($notice)
          {
            $notice->delete();
          }
          return redirect()->route('admin.societies.circulars.index',$society_id)->with('success','Circular deleted successfully.');
        }

        public function notify($society_id,$member_id){
          
          $notice = Circular::find($member_id);

          if($notice)
          {

            $token=[];
            $user_ids=[];
            $mysqlvalue= explode(",",$notice->building_id);
            
            foreach ($mysqlvalue as $value) {
              $members=Member::where('building_id',$value)->where('society_id',$society_id)->get();
              foreach ($members as $value) {

                  $users=User::where('id',$value->user_id)->first();
                  $societyName=Society::where('id',$society_id)->first();

                  $user_ids[]=$value->user_id;

                  $settings=Settings::where('user_id',$value->user_id)->where('circular',1)->first();

                  if($settings !=null)
                  {
                      $token=$users->fcm_token;  
                      $pmsg = array(
                          'body' => $notice->description,
                          'title' => $notice->title,
                          'icon' => 'myicon',
                          'sound' => 'mySound'
                      );

                      $data=array(
                            'notification_type'=>'Circular',
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
          return redirect()->route('admin.societies.circulars.index',$society_id)->with('success','Notification sent successfully.');
        }
}
