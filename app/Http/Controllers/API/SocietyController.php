<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\Role;
use App\City;
use App\User;
use App\Area;
use App\Society;
use App\Flat;
use App\Building;
use App\Member;
use App\Profession;
use App\Helpdesk;
use App\Notification;
use App\Referral;
use Auth;
use App\Settings;
class SocietyController extends Controller
{
    //
    public function getcity(Request $request)
    {
    	$city = request('city');
    	if($city){
    		$cities = City::find($city,['id','name']);
    		return response()->json(['data' => $cities,'status'=>1,'message' => "Successfully get city."] , 200);
    	}else{
    		$cities = City::all(['id','name']);
    		return response()->json(['data' => $cities,'status'=>1,'message' => "Successfully get city."] , 200);
    	}
    	
    }

    public function getarea(Request $request)
    {
    	$city = request('city_id');
    	if($city){
    		$area = Area::select('id','city_id','name')->where('city_id', $city)->get();
    		return response()->json(['data' => $area,'status'=>1,'message' => "Successfully get area."] , 200);
    	}else{
    		$area = Area::all(['id','city_id','name']);
    		return response()->json(['data' => $area,'status'=>1,'message' => "Successfully get area."] , 200);
    	}
    }

    public function getsociety(Request $request)
    {
    	$area = request('area_id');
    	if($area){
    		$society = Society::select('id','address','area_id','name')->where('area_id', $area)->get();
    		return response()->json(['data' => $society,'status'=>1,'message' => "Successfully get society."] , 200);
    	}else{
    		$society = Society::all(['id','address','area_id','name']);
    		return response()->json(['data' => $society,'status'=>1,'message' => "Successfully get society."] , 200);
    	}
    }

    public function getbuilding(Request $request)
    {
    	$society = request('society_id');
    	if($society){
    		$building = Building::select('id','society_id','name')->where('society_id', $society)->get();
    		return response()->json(['data' => $building,'status'=>1,'message' => "Successfully get building."] , 200);
    	}else{
    		$building = Building::all(['id','society_id','name']);
    		return response()->json(['data' => $building,'status'=>1,'message' => "Successfully get building."] , 200);
    	}
    }

    public function getflat(Request $request)
    {
    	$building = request('building_id');

    	if($building){
    		$flat = Flat::select('id','building_id','name')->where('building_id', $building)->get();
            $booked=[];
            $unbooked=[];
            foreach ($flat as $value) {
                $Member=Member::where('flat_id',$value->id)->first();

                if($Member==null)
                {
                    $booked[] = [
                        "id" => $value->id,
                        "name" => $value->name,
                        "building_id" =>$value->building_id,
                        "booked" =>"no",   
                        "book_type" =>"",                     
                      ];
                }
                else
                {
                     $booked[] = [
                        "id" => $value->id,
                        "name" => $value->name,
                        "building_id" =>$value->building_id,
                        "booked" =>"yes", 
                        "book_type" =>isset($Member->flatType)?$Member->flatType:'',                       
                      ];
                }       
            }           

    	   return response()->json(['data' => $booked,'status'=>1,'message' => "Successfully get area."] , 200);
    	}else{
    		$flat = Flat::all(['id','building_id','name']);
            $booked=[];
            foreach ($flat as $value) {
                $Member=Member::where('flat_id',$value->id)->first();
                
                // $flatType=[];
                // foreach ($Member as $value) {
                //     $flatType[]=$value->flatType;
                // }
               

                if($Member==null)
                {
                    //$booked[]=$value->id;
                    $booked[] = [
                        "id" => $value->id,
                        "name" => $value->name,
                        "building_id" =>$value->building_id,
                        "booked" =>"no",   
                        "book_type" =>"",                        
                      ];
                }
                else
                {
                     $booked[] = [
                        "id" => $value->id,
                        "name" => $value->name,
                        "building_id" =>$value->building_id,
                        "booked" =>"yes",  
                        "book_type" =>$Member->flatType,                         
                      ];
                }       
            }   
    		return response()->json(['data' => $booked,'status'=>1,'message' => "Successfully get area."] , 200);
    	}
    }

    public function getflat2(Request $request)
    {
        $building = request('building_id');
        $society_id = request('society_id');
        if($building){
            $pp =  DB::table('flats')
            ->leftjoin('buildings', 'flats.building_id', '=', $building )
            ->leftjoin('buildings', 'buildings.society_id', '=', $society_id )->get();
            
            // $flat = Flat::select('id','building_id','name')->where('building_id', $building)->get();
            return response()->json(['data' => $flat,'status'=>1,'message' => "Successfully get area."] , 200);
        }else{
            $flat = Flat::all(['id','building_id','name']);
            return response()->json(['data' => $flat,'status'=>1,'message' => "Successfully get area."] , 200);
        }
    }

    public function getprofessional(Request $request)
    {
        $Profession = Profession::get();

        return response()->json(['data' => $Profession,'status'=>1,'message' => "Successfully get Profession."] , 200);
    }

    public function gethelpdesk(Request $request)
    {
        $society_id=request('society_id');

        $helpdesk=Helpdesk::where('society_id',$society_id)->get();

        return response()->json(['data' => $helpdesk,'status'=>1,'message' => "Successfully get Helpdesk."] , 200);
    }

    public function getnotificationcount(Request $request)
    {
        $user_id=Auth::user()->id;

        $type=request('type');

        //$events=DB::table('notifications')->whereRaw('find_in_set("'.$user_id.'",user_id)')->where('isread',0)->where('type',1)->orderBy('id','desc')->count();

        $events=DB::table('notifications')->where('user_id',$user_id)->where('isread',0)->where('type',1)->orderBy('id','desc')->count();

        $event=array(
                        'title'=>'Events',
                        'count'=>$events,
        );

        $notices=DB::table('notifications')->where('user_id',$user_id)->where('isread',0)->where('type',2)->orderBy('id','desc')->count();

        $notice=array(
                        'title'=>'Notices',
                        'count'=>$notices,
        );

        $circulars=DB::table('notifications')->where('user_id',$user_id)->where('isread',0)->where('type',3)->orderBy('id','desc')->count();

        $circular=array(
                        'title'=>'Circulars',
                        'count'=>$circulars,
        );
        
        $response=[];

        $response = [
            $event,
            $notice,
            $circular
        ];

        return response()->json(['data' => $response,'status'=>1,'message' => "Successfully get Notification Count."] , 200);

    }

    public function updatenotificationcount(Request $request)
    {
        $user_id=Auth::user()->id;

        $type=request('type');

        if($type=='1')
        {
            $events=DB::table('notifications')->where('user_id',$user_id)->where('type',$type)->orderBy('id','desc')->update(['isread'=>1]);
        }

        if($type=='2')
        {
            $notices=DB::table('notifications')->where('user_id',$user_id)->where('type',$type)->orderBy('id','desc')->update(['isread'=>1]);
        }

        if($type=='3')
        {   
            $circulars=DB::table('notifications')->where('user_id',$user_id)->where('type',$type)->orderBy('id','desc')->update(['isread'=>1]);
        }
        
        $response=[];

        $response=array(
            'events'=>isset($events)?$events:'',
            'notices'=>isset($notices)?$notices:'',
            'circulars'=>isset($circulars)?$circulars:'',
        );

        return response()->json(['data' => $response,'status'=>1,'message' => "Successfully get Notification Count."] , 200);

    }

    public function notificationDelete(Request $request)
    {
        $Notification_id=request('notification_id');

        $id=explode(',', $Notification_id);

        foreach ($id as $value) {
            Notification::where('id',$value)->delete();
        }

        return response()->json(['data' => (Object)[],'status'=>1,'message' => "Notification Deleted Successfully."] , 200);

    }

    public function MemberList(Request $request)
    {
        $user_id=auth()->user()->id;

        $society_id = request('society_id');

        $building_id=request('building_id');

        $member=Member::where('relation','=','self')->where('society_id',$society_id)->where('building_id',$building_id)->with('user','flat','building')->where('user_id','!=',$user_id)->get();

        $response = [];

        foreach ($member as $u) {
          $Settings=Settings::where('user_id',$u->user_id)->first();
          $response[] = [
            "id" => $u->id,
            "user_id"=>$u->user_id,
            "society_id"=>$u->society_id,
            "building_id"=>$u->building_id,
            "flat_id"=>$u->flat_id,
            "flatType"=>$u->flatType,
            "gender"=>$u->gender,
            "profession"=>$u->profession,
            "profession_detail"=>$u->profession_detail,
            "relation"=>$u->relation,
            "dob"=>$u->dob,
            "bloodgroup"=>$u->bloodgroup,
            "name" => $u->user->name,
            "phone" => $u->user->phone,
            "email" => $u->user->email,
            "image" => $u->user->image,
            "flatname" => $u->flat->name,
            "buildingname" => $u->building->name,
            "role"=>$u->user->roles->first()->name,
            "profession" => $u->profession,
            "relation" => $u->relation,
            "dob" => $u->dob,
            "bloodgroup" => $u->bloodgroup,
            "created_at"=>$u->user->created_at->toDateString(),
            "updated_at"=>$u->user->updated_at->toDateString(),
            "contact_status"=>isset($Settings->contact_details)?$Settings->contact_details:0,
            "member_status"=>isset($Settings->family_details)?$Settings->family_details:0,
          ];
        }
        return response()->json(['data' => $response,'status'=>1,'message' => "Successfully Member list."] , 200);

    }

    public function send_reffreal(Request $request)
    {

        $ref=new Referral;
        $ref->user_id=request('user_id');
        $ref->society_name=request('society_name');
        $ref->contact=request('phone');
        $ref->save();

        return response()->json(['data' =>$ref,'status'=>1,'message' => "Successfully Added Referral."] , 200);

    }
    

    

    
    
    
}
