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
use App\Maintence;
use App\ServiceTypes;
use App\DomesticHelpers;
use Auth;
use DB;
use App\Helpers\Notification\PushNotification;
use App\Helpers\Notification\Otp;

class ServiceController extends Controller
{
    //
    public function index($id){

        $society = Society::find($id);
        if($society){
          $member = Member::where('relation','=','self')->where('society_id',$id)->with('user')->get();
          return view('admin.societies.serviceproviders.index',["society" => $society,'member'=>$member]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function addServiceProvider($id){
        $society = Society::find($id);
        if($society){
        	$member = Member::where('relation','=','self')->where('society_id',$id)->with('flat','building')->get();
        	$types  = ServiceTypes::all();
          return view('admin.societies.serviceproviders.add',["society" => $society,'member'=>$member,'types'=>$types]);
        }else{
          return view('admin.errors.404');
        }
    }


     public function storeServicesProviders(Request $request, $society_id)    {
        $this->validate($request, [
            'image' => 'required|max:2048',
            'name' => 'required',
            'type' => 'required',
           // 'members' => 'required',
            'phone' => 'required|numeric',
            'document' => 'required|max:2048',
            'gender' => 'required',
        ]);

        $members_id=request('members');

        if(request('members'))
        {
            $array_comp_prod = implode(",", $members_id);
        }
        
        $city = new DomesticHelpers();
        $city->society_id = $society_id;
        $city->name = request('name');
        $city->pin = request('pin');
        $city->type_id = request('type');
        $city->member_id = isset($array_comp_prod)?$array_comp_prod:'';
        $city->mobile = request('phone');
        $city->gender = request('gender');
        $city->status = request('Status');
        if ($request->file('image')) {
            $image = $request->image;
            $path = $image->store('DomesticHelpers');
        }
        if ($request->file('document')) {
            $image = $request->document;
            $path1 = $image->store('Helpersdocument');
        }
        $city->photos = isset($path) ? $path : "";
        $city->document = isset($path1) ? $path1 : "";
        $city->save();

        $number=request('phone');
        //$nn=str_replace(' ', '', $number);
        $otp_new = 'Dear '.request('pin').','.PHP_EOL.'Your SocietyBuddy account is approved by society admin. Kindly login and enjoy the app now.';

        Otp::send_otp($number,$otp_new);
        
        return redirect()->route('admin.societies.serviceprovider.index',$society_id)->with("success","Serviceprovider added successfully.");
    }

     public function checkForSocietyAdmin($society_id){
      //If user has role society_admin then make sure he/she can only access their society
      if(auth()->user()->hasRole('society_admin')){
        if(auth()->user()->society_id != $society_id){
          abort(403, 'Unauthorized action.');
        }
      }
    }

    public function editServices($society_id,$building_id)
    {
        $this->checkForSocietyAdmin($society_id);
        $s = Society::find($society_id);
        $Services = DomesticHelpers::find($building_id);
        if($s)
        {
        	$member = Member::where('relation','=','self')->where('society_id',$society_id)->with('flat','building')->get();
        	$types  = ServiceTypes::all();
            return view('admin.societies.serviceproviders.edit',["society" => $s,'member'=>$member,'types'=>$types,'Services'=>$Services]);
        }
        else
        {
          return view('admin.errors.404');
        }
    }

    public function update(Request $request, $society_id, $member_id)
    {
	    $this->validate($request, [
	          	'name' => 'required',
	            'type' => 'required',
	            //'members' => 'required',
	            'phone' => 'required|numeric',
	            'gender' => 'required',
                'document' => 'max:2048',
	    ]);

        $member = DomesticHelpers::find($member_id);

      	if($member){
      		$members_id=request('members');
        	

            if(request('members'))
        {
            $array_comp_prod = implode(",", $members_id);
        }

          	$member->society_id = $society_id;
	        $member->name = request('name');
	        $member->pin = request('pin');
	        $member->type_id = request('type');
	        $member->member_id = isset($array_comp_prod)?$array_comp_prod:'';
	        $member->mobile = request('phone');
	        $member->gender = request('gender');
	        $member->status = request('Status');

	        if ($request->file('image')) {
	            $image = $request->image;
	            $path = $image->store('DomesticHelpers');
	        }
	        else
	        {
	        	$imagepath = request('profile_hidden');
	        }

	        if ($request->file('document')) {
	            $image = $request->document;
	            $path1 = $image->store('Helpersdocument');
	        }
	        else
	        {
	        	$documentpath = request('document_hidden');
	        }

	        $member->photos = isset($path) ? $path : $imagepath;
	        $member->document = isset($path1) ? $path1 :$documentpath;
	        $member->save();
        }

        return redirect()->route('admin.societies.serviceprovider.index', $society_id)->with('success','Services Provider updated successfully.');
    }

    public function ArrayServices(Request $request, $society_id){
            $response = [];
            
            $sosieties = \DB::table("domestic_helpers")
                        ->select("servicetypes.name as servicetypesname","domestic_helpers.*",\DB::raw("GROUP_CONCAT(users.name) as usersname"))
                        ->leftjoin("users",\DB::raw("FIND_IN_SET(users.id,domestic_helpers.member_id)"),">",\DB::raw("'0'"))
                        ->join('servicetypes','servicetypes.id','=','domestic_helpers.type_id')
                        ->where('domestic_helpers.society_id',$society_id)
                        ->groupBy("domestic_helpers.id")
                        ->get();


            foreach ($sosieties as $s) 
            {
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                
                if(isset($s->usersname))
                {
                    $result = array();
                    if($s->usersname !=null)
                    {
                        $str_arr1 = preg_split ("/\,/", $s->usersname);  
                        $username=[];
                        foreach ($str_arr1 as $value) {
                     
                              $username[]=$value;
                        } 

                        $str_arr = preg_split ("/\,/", $s->member_id);
                        $flatname=[];
                        foreach ($str_arr as $value) {
                     
                              $members=Member::where('user_id',$value)->with('flat','building','user')->first();

                              $flatname[]=isset($members->building->name)?$members->building->name.'-'.$members->flat->name:'';  
                        } 

                        
                        foreach($username as $key=>$val){ 
                            $val2 = $flatname[$key];
                            $result[$key] = $val .' ('.$val2.')'; // combine 'em    
                        }
                    }

                }

                $stars = DB::table('reveiws')
                        ->where('reveiws.helper_id',isset($s->id)?$s->id:'')
                        ->avg('ratings'); 

                // $newstars=[];        
                // while($stars>0)    
                // {
                //     if($stars >0.5)
                //     {
                //         $newstars[] = '<i class="fa fa-star"></i>';
                //     }
                //     else
                //     {
                //         $newstars[] = '<i class="fa fa-star"></i>';
                //     }
                //    $stars--;
                // }
                 
                
                
                if($s->photos)
                { 
                  $img = env('APP_URL_STORAGE').$s->photos;
                } else {
                  $img = asset('public/no-image.png');
                }

                $sub[] = "<a class='example-image-link' href='".$img."' data-lightbox='example-1'><img width='50' class='example-image' src='".$img."' alt='image-1' /></a>";
                $sub[] = '<a class="edit" href="'.route('admin.societies.serviceprovider.view', ["society_id" => $society_id, "member_id" => $id]).'">'.$s->name.'</a>';
                $sub[] = $s->servicetypesname;
                $sub[] = isset($s->usersname)?$result:'';

                $sub[] = ROUND($stars,1);
                $sub[] = date('d-m-Y',strtotime($s->created_at));

                $delete_url = route('admin.societies.serviceprovider.delete', ["society_id" => $society_id, "member_id" => $id]);

                $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.serviceprovider.edit', ["society_id" => $society_id, "member_id" => $id]).'"><i class="fa fa-pencil-square-o"></i></a>' . ' ';
                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.$delete_url.'"><i class="fa fa-trash"></i>&nbsp;</a></div>';

                $sub[] = $action;
                $response[] = $sub;
            }

            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }


        public function deleteServices($society_id,$user_id){
	        $city = DomesticHelpers::find($user_id);
	        if($city){
	          $city->delete();
	        }
	        return redirect()->route('admin.societies.serviceprovider.index',$society_id)->with('success','Domestichelpers deleted successfully.');
    	}

        public function viewservices($society_id,$user_id)
        {
            $helpers=DomesticHelpers::where('id',$user_id)->first();
            
            $str_arr = preg_split ("/\,/", $helpers->member_id);
            $username=[];
            foreach ($str_arr as $value) {
             
              $members=Member::where('user_id',$value)->with('flat','building','user')->first();
              $username[]=$members;
            } 
            
            return view('admin.societies.serviceproviders.review',['helpers'=>$helpers,'username'=>$username]);
        }

        

        

}
