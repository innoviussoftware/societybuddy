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
use App\Amenties;

class AmentiesController extends Controller
{
    public function indexAmenties($id){
        $society = Society::find($id);
        if($society){
          return view('admin.societies.amenties.index',["society" => $society]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function addAmenties($id){
        $society = Society::find($id);
        if($society){
          return view('admin.societies.amenties.add',["society" => $society]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function storeAmenties(Request $request, $society_id)    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            //'image' => 'required',
            'image.*' => 'mimes:jpeg,jpg,png|max:2048'
        ]);
        $amenties = new Amenties();
        $amenties->name = request('name');
        $amenties->society_id = $society_id;
        $amenties->description = request('description');
        $path=[];
        if($request->file('image'))
        {
        	foreach ($request->file('image') as $value) {
                $name=$value->getClientOriginalName();
                $path[] = $value->store('amenties');
        	}   
        }
        //$report_file_data = json_encode($path);
        $report_file_data = implode(' | ', $path);
        $amenties->images = isset($report_file_data) ? $report_file_data : "";
        $amenties->notes =  request('notes');
        $amenties->amount = request('amount');
        $amenties->save();        
        return redirect()->route('admin.societies.amenties.index',$society_id)->with("success","Amenities added successfully.");
    }

    public function editAmenties($society_id,$user_id){
      $this->checkForSocietyAdmin($society_id);

        $s = Society::find($society_id);

        $b = Amenties::find($user_id);

        if($b && $s){
          return view('admin.societies.amenties.edit',["society" => $s,"user" => $b]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function updateAmenties(Request $request, $society_id, $user_id){

	    $this->validate($request, [
	          'name' => 'required',
	          'description'=>'required',
              //'image' => 'required',
              'image.*' => 'mimes:jpeg,jpg,png|max:2048'

	    ]);

        $user = Amenties::find($user_id);

        if($user){
	          $user->name = request('name');
	          $user->description = request('description');
	          $path=[];
              if($request->file('image'))
              {

        		      foreach ($request->file('image') as $value) {
        		            $name=$value->getClientOriginalName();
        		            $path[] = $value->store('amenties');
        		      }
                      $report_file_data = implode(' | ', $path);
                     // $report_file_data = json_encode($path);
              }       
              else
              {
                    $oldimages=request('oldimages');
              }

		  
		      $user->images = isset($report_file_data) ? $report_file_data : $oldimages;
              $user->notes =  request('notes');
              $user->amount = request('amount');
	          $user->save();
        }


        return redirect()->route('admin.societies.amenties.index', $society_id)->with('success','Amenities updated successfully.');
    }

    public function ArrayAmenties(Request $request, $society_id){
            $response = [];

            $sosieties = Amenties::where("society_id",$society_id)->get();
            
            foreach ($sosieties as $s) {
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->name;
                $sub[] = substr($s->description,0,80);

                

                $subeducation=[];
                
                
                $reports_file = explode(' | ', $s->images);

                if($reports_file != null)
                {
                    

                    foreach ($reports_file as $reports) {
                        

                         if(!empty($reports)){
                                $subeducation[]='<div class="" style="display: inline-block;"><a class="example-image-link" href="'.env('APP_URL_STORAGE').'/'.$reports.'" data-lightbox="example-1"><img src="'.env('APP_URL_STORAGE').'/'.$reports.'"  width="50px" height="50px"></a></div>';
                            }
                            else
                            {

                                $img = asset('amenities image.png');
                                $subeducation[]='<a class="example-image-link" href="'.$img.'" data-lightbox="example-1"><img src="'.$img.'"  width="50px" height="50px" class="img-responsive"></a>';
                            }
                        
                    }
                }

                $sub[]=$subeducation;

                $sub[]=$s->amount;                

                if($s->status==1)
                {
                    $verified_url = route('admin.societies.amenties.changestatus',["society_id" => $society_id,"member_id" => $s->id,"status"=>0]);


                    $sub[] = '<a data-toggle="tooltip" title="click here to inactive" style="color:red" onclick="return confirm(`' . $verified_url . '`,`Are you sure you want to inactivate this amenties ?`)"  href="#"><label class="label label-success">Active</label></a>' . ' ';
                }
                elseif($s->status==0)
                {
                    $verified_url = route('admin.societies.amenties.changestatus',["society_id" => $society_id,"member_id" => $s->id,"status"=>1]);
                    
                    $sub[] = '<a data-toggle="tooltip" title="click here to active" style="color:red" onclick="return confirm(`' . $verified_url . '`,`Are you sure you want to activate this amenties ?`)"  href="#"><label class="label label-danger">In-Active</label></a>' . ' ';
                }
                
                $delete_url = route('admin.societies.amenties.delete', ["society_id" => $society_id, "user_id" => $id]);
                $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.amenties.edit', ["society_id" => $society_id, "user_id" => $id]).'"><i class="fa fa-pencil-square-o"></i></a>' . ' ';
                $action .= '<a  data-toggle="tooltip" class="delete" onclick="return confirm(`' . $delete_url . '`,`Are you sure you want to delete this record?`)"  href="#"><i class="fa fa-trash"></i>&nbsp;</a></div>';
                $sub[] = $action;
                $response[] = $sub;
            }

            $userjson = json_encode(["data" => $response]);

            echo $userjson;
    }

    public function deleteAmenties($society_id,$member_id){
        $amenties = Amenties::find($member_id);
        if($amenties){
          $amenties->delete();
        }
        return redirect()->route('admin.societies.amenties.index',$society_id)->with('success','Amenities deleted successfully.');
    }

    public function changestatus($society_id,$user_id,$status)
    {            
        //$referral = User::where('society_id',$society_id)->where('id',$user_id)->get();

        $update_attributes = array('status' => $status);

        //$user=User::where('society_id',$society_id)->where('id',$user_id)->get();

        $user = Amenties::where('society_id',$society_id)->where('id',$user_id)->update(['status'=>$status]);

        $user=Amenties::where('society_id',$society_id)->where('id',$user_id)->get();
            
        //$phone=isset($user[0]->phone)?$user[0]->phone:'';
            
        if ($status == 1) {
                $msg = 'Amenities is active.';
        }
        elseif ($status == 0) 
        {
                $msg = 'Amenities is de-active.';
        }

        return redirect()->route('admin.societies.amenties.index',$society_id)->with('success', $msg);
    }

    public function checkForSocietyAdmin($society_id){
      //If user has role society_admin then make sure he/she can only access their society
      if(auth()->user()->hasRole('society_admin')){
        if(auth()->user()->society_id != $society_id){
          abort(403, 'Unauthorized action.');
        }
      }
    }
}
