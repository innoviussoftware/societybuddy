<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Guard;
use App\Visitor;
use App\Vehicle;
use App\Society;
use App\Building;
use App\Flat;
use App\Member;
use App\User;
use App\InviteGuest;
use App\Inouts;
use Auth;
use DB;
use Validator;
use Laravel\Passport\Token;
use App\Helpers\Notification\PushNotification;
use App\Settings;
use App\Helpers\Notification\Otp;
use App\Helpers\Notification\TinyUrl;
use App\DomesticHelpers;
use App\HelpersInout;
use App\Amenties;
use App\Amentiesbooking;
class GuardController extends Controller
{
    //

    public function guardlogin(Request $request)
    {
    	$validator = Validator::make($request->all(),[
           'login_pin'  => 'required',
    	]);

    	if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());
            return response()->json(['errors' => $errorMessage], 422);
        }else
        {
        	$Guard=Guard::where('login_pin',request('login_pin'))->first();
            
        
        	if($Guard != null)
        	{
                $societylogo=Society::where('id',$Guard->society_id)->first();

                $guard=Guard::whereId($Guard->id)->update(['fcm_token'=>request('device_id')]);

                $guard=Guard::whereId($Guard->id)->get();
                  
        		$guard=array(                
	                'isGuard'=>'1',
                    'Logo'=>$societylogo->logo,
	                'guard_list'=>$guard
            	);
                return response()->json(['data' => $guard,'status'=>1,'message' => "Successfully get Guard."] , 200);
        	}
        	else
        	{
        		$guard=array(                
	                'isGuard'=>'0',
                    'Logo'=>'',
	                'guard_list'=>[],
            	);
                return response()->json(['data' =>$guard,'status'=>0,'message' => "Guard Not Available"] , 200);
        	}

        }
    }

    public function addguestentry(Request $request)
    {
    	$guard_id=request('guard_id');

    	$society_id=request('society_id');

        $building_id=request('building_id');

        $flat_id=request('flat_id');

        $profile=request('profile');

        $guest_name=request('guest_name');
       
        if(request('profile'))
        {
                $img = request('profile');
                $custom_file_name = 'visitorprofile-'.time().'.'.$img->getClientOriginalExtension();
                $visitorprofile = $img->storeAs('visitorprofile', $custom_file_name);
        }

        $visitor=new Visitor();
        $visitor->guard_id=$guard_id;
        $visitor->society_id=$society_id;
        $visitor->building_id=$building_id;
        $visitor->flat_id=$flat_id;
        $visitor->name=$guest_name;
        $visitor->photos=isset($visitorprofile)?$visitorprofile:'';
        $visitor->save();
        $visitor->flats;
        $visitor->building;
        $visitor->society;
        $visitor->flats_users;
        $insertedId = $visitor->id;

        $userdeviceid=Member::where('society_id',$society_id)->where('flat_id',$flat_id)->where('relation','=','self')->first();

        
        if($userdeviceid->occupancy=='Tenant' || $userdeviceid->occupancy=='tenant')
        {
            $users=Member::where('society_id',$society_id)->where('flat_id',$flat_id)->where('flatType','=','Renting the flat')->first();

            Visitor::where('id',$insertedId)->update(['user_id'=>$users->user_id]);
 
        }
        else
        {
            $users=Member::where('society_id',$society_id)->where('flat_id',$flat_id)->where('relation','=','self')->first();

            Visitor::where('id',$insertedId)->update(['user_id'=>$users->user_id]);


        }
       
        $user_id=$users->user_id;      
 
        $username=User::where('id',$user_id)->first();

        $Settings=DB::table('settings')->where('user_id',$user_id)->orderBy('id','desc')->first();

        if($Settings->mute_notification_status==1)
        {
            $token=[];
        
            $receiver_id=explode(',', $Settings->receiver_id);
             
                foreach ($receiver_id as $value) {

                        $DeviceId=User::where('id',$value)->first();
                       
                        $token[]=isset($DeviceId->fcm_token)?$DeviceId->fcm_token:'';
                }
            
            

            $membername=[];
            $membername=isset($username->name)?$username->name:'';
            $visitor->membername=$membername;


            $DeviceId=User::where('id',isset($user_id)?$user_id:'')->first();

            $newtoken=$token;
            
            $societyName=Society::where('id',$society_id)->first();

            $buildingName=Building::where('id',$building_id)->first();

            $flatName=Flat::where('id',$flat_id)->first();

            $pmsg = array(
                    'body' => 'Security alert',
                    'title' => isset($societyName->name)?$societyName->name:'',
                    'icon' => 'myicon',
                    'sound' => 'audio.mp3'
            );

            $data=array(
                'notification_type'=>'security',
                'guest_name'=>$guest_name,
                'guest_image'=>isset($visitorprofile)?$visitorprofile:'',
                'flat_no'=>isset($flatName->name)?$flatName->name:'',
                'building_no'=>isset($buildingName->name)?$buildingName->name:'',
                'socity_name'=>isset($societyName->name)?$societyName->name:'',
                'guest_id'=>$insertedId
            );


            PushNotification::SendPushNotification($pmsg, $data, $newtoken);

            return response()->json(['data' => $visitor,'status'=>1,'message' => "Visitor added."] , 200);
        }
        else
        {
            $reason=$Settings->reason_to_mute_notification;
            
            return response()->json(['data' => $visitor,'status'=>2,'message' =>  $reason] , 200);
        }

                
    }

    public function acceptorreject(Request $request)
    {
        $type=request('type');
        
        $guest_id=request('guest_id');

        //1-Accept 2-Reject

        if($type=='1')
        {
                

                $Visitor=Visitor::where('id',$guest_id)->first();

                if($Visitor->status==1)
                {
                        $error= '';
                        return response()->json(['data' => (Object)[],'status'=>0,'message' => "Already answer submitted for this guest."] , 200);
                }
                else
                {
                        $Visitor=Visitor::where('id',$guest_id)->update(['flag'=>1,'status'=>1]);
                        $Visitor=Visitor::where('id',$guest_id)->first();

                        $guard=Guard::where('id',$Visitor->guard_id)->first();

                        $token=isset($guard->fcm_token)?$guard->fcm_token:'';

                        $societyName=Society::where('id',$Visitor->society_id)->first();

                        $buildingName=Building::where('id',$Visitor->building_id)->first();

                        $flatName=Flat::where('id',$Visitor->flat_id)->first();

                        $userid=Member::where('flat_id',$Visitor->flat_id)->with('user')->first();

                        $ownerName=$userid->user->name;

                        $pmsg = array(
                            'body' => 'Security alert',
                            'title' => $societyName->name,
                            'icon' => 'myicon',
                            'sound' => 'mySound'
                        );

                        $data=array(
                            'notification_type'=>'security',
                            'guest_name'=>$Visitor->name,
                            'guest_image'=>$Visitor->photos,
                            'flat_no'=>isset($flatName->name)?$flatName->name:'',
                            'building_no'=>isset($buildingName->name)?$buildingName->name:'',
                            'socity_name'=>isset($societyName->name)?$societyName->name:'',
                            'visitor_id'=>$Visitor->id,
                            'flag'=>'accepted',
                            'ownername'=>isset($ownerName)?$ownerName:''
                        );

                        PushNotification::SendPushNotification($pmsg, $data, [$token]);
                }
                return response()->json(['data' => $Visitor,'status'=>1,'message' => "Request accepted."] , 200);
        }   

        if($type=='2')
        {
                

                $Visitor=Visitor::where('id',$guest_id)->first();

                if($Visitor->status==1)
                {
                        return response()->json(['data' => (Object)[],'status'=>0,'message' => "Already answer submitted for this guest."] , 200);
                }
                else
                {
                    $Visitor=Visitor::where('id',$guest_id)->update(['flag'=>2,'status'=>1]);
                    $Visitor=Visitor::where('id',$guest_id)->first();

                    $guard=Guard::where('id',$Visitor->guard_id)->first();

                    $token=isset($guard->fcm_token)?$guard->fcm_token:'';

                    $societyName=Society::where('id',$Visitor->society_id)->first();

                    $buildingName=Building::where('id',$Visitor->building_id)->first();

                    $flatName=Flat::where('id',$Visitor->flat_id)->first();

                    $userid=Member::where('flat_id',$Visitor->flat_id)->with('user')->first();

                    $ownerName=$userid->user->name;

                    $pmsg = array(
                        'body' => 'Security alert',
                        'title' => $societyName->name,
                        'icon' => 'myicon',
                        'sound' => 'mySound'
                    );

                    $data=array(
                        'notification_type'=>'security',
                        'guest_name'=>$Visitor->name,
                        'guest_image'=>$Visitor->photos,
                        'flat_no'=>isset($flatName->name)?$flatName->name:'',
                        'building_no'=>isset($buildingName->name)?$buildingName->name:'',
                        'socity_name'=>isset($societyName->name)?$societyName->name:'',
                        'visitor_id'=>$Visitor->id,
                        'flag'=>'rejected',
                        'ownername'=>isset($ownerName)?$ownerName:''
                    );

                    PushNotification::SendPushNotification($pmsg, $data, [$token]);

                    return response()->json(['data' => $Visitor,'status'=>1,'message' => "Request rejected."] , 200);
                }
        }        
    }

    public function emailExists(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'email' => 'required|email|unique:users',
         ]);

        if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());
            return response()->json(['errors' => $errorMessage], 422);
        }
        else
        {
            return response()->json(['success' =>'Email Available'], 200);
        }
    }

    public function currentVisitorList(Request $request)
    {
        //$guard_id=request('guard_id');

        $society_id=request('society_id');

        $CurrentVisitor =  DB::table('visitor')
                    ->select('visitor.id','visitor.name','visitor.photos','flats.name as flatname','buildings.name as buildingname','visitor.flag')
                    ->join('flats','flats.id','=','visitor.flat_id')
                    ->join('buildings','buildings.id','=','visitor.building_id')
                    ->where('visitor.flag',1)
                    ->where('visitor.society_id',$society_id)
                    //->where('visitor.guard_id',$guard_id)
                    ->where('visitor.inOutFlag','!=',2)
                    ->where('visitor.soft_delete',0)
                    ->orderby('visitor.created_at','desc')
                    ->get(); 
                    
        $data = [];
        $p = 0;
        foreach ($CurrentVisitor as $value) 
        {
                
                $visitor= DB::table('inoutlists')
                        ->select('inoutlists.intime as Intime','inoutlists.outtime as Outtime','inoutlists.flag as inOutFlag')
                        ->where('inoutlists.request_id',$value->id)
                        ->where('inoutlists.flag',1)
                        ->where('inoutlists.type',2)
                        ->whereOr('inoutlists.flag','!=',2)
                        ->where('inoutlists.soft_delete',0)
                        
                        ->first();

                    if($visitor)
                    {
                        $data[$p]['id']=$value->id;
                        $data[$p]['name']=$value->name;
                        $data[$p]['photos']=$value->photos;
                        $data[$p]['code']='';
                        $data[$p]['flatname']=$value->flatname;
                        $data[$p]['buildingname']=$value->buildingname;
                        $data[$p]['flag']=$value->flag;
                        $data[$p]['Intime']=$visitor->Intime;
                        $data[$p]['Outtime']=$visitor->Outtime;
                        $data[$p]['inOutFlag']=$visitor->inOutFlag;
                        $data[$p]['type']='2';

                    }

                    else
                    {
                        $data[$p]['id']=$value->id;
                        $data[$p]['name']=$value->name;
                        $data[$p]['photos']=$value->photos;
                        $data[$p]['code']='';
                        $data[$p]['flatname']=$value->flatname;
                        $data[$p]['buildingname']=$value->buildingname;
                        $data[$p]['flag']=$value->flag;
                        $data[$p]['Intime']="";
                        $data[$p]['Outtime']="";
                        $data[$p]['inOutFlag']=(int)'';
                        $data[$p]['type']='2';
                    }
                    $p++;

        } 

        $date=date("Y-m-d");

        $frequentlyVisitor =  DB::table('inviteguest')
                    ->select('inviteguest.id','inviteguest.contact_name','inviteguest.code','inviteguest.user_id')
                    ->where('inviteguest.society_id',$society_id)  
                    ->where('inviteguest.flag','=','1')        
                    //->where('start_date',$date)->orWhere('end_date',$date)->whereBetween('start_date', [$date, $date])->orwherebetween('end_date', [$date, $date]) 
                    ->where('inviteguest.soft_delete',0)
                    ->orderby('inviteguest.created_at','desc')
                    ->get(); 
                   
        $data1 = [];

        $p1 = 0;

        foreach ($frequentlyVisitor as  $value) {

            $frequentlyvisitor= DB::table('inoutlists')
                        ->select('inoutlists.intime as Intime','inoutlists.outtime as Outtime','inoutlists.flag as inOutFlag')
                        ->where('inoutlists.request_id',$value->id)
                        ->where('inoutlists.flag',1)
                        ->where('inoutlists.type',1)
                        ->whereOr('inoutlists.flag','!=',2)
                        ->where('inoutlists.soft_delete',0)
                        ->first();

                        $flats= DB::table('members')
                        ->select('flats.name as flatname','buildings.name as buildingname')
                        ->where('members.user_id',$value->user_id)
                        ->join('flats','flats.id','=','members.flat_id')
                        ->join('buildings','buildings.id','=','members.building_id')
                        ->first();
                        

                    if($frequentlyvisitor)
                    {
                        $data1[$p1]['id']=$value->id;
                        $data1[$p1]['name']=$value->contact_name;
                        $data1[$p1]['photos']='';
                        $data1[$p1]['code']=$value->code;
                        $data1[$p1]['flatname']=isset($flats->flatname)?$flats->flatname:'';
                        $data1[$p1]['buildingname']=isset($flats->buildingname)?$flats->buildingname:'';
                        $data1[$p1]['flag']=(int)'';
                        $data1[$p1]['Intime']=$frequentlyvisitor->Intime;
                        $data1[$p1]['Outtime']=$frequentlyvisitor->Outtime;
                        $data1[$p1]['inOutFlag']=$frequentlyvisitor->inOutFlag;
                        $data1[$p1]['type']='1';

                    }
                    else
                    {
                        $data1[$p1]['id']=$value->id;
                        $data1[$p1]['name']=$value->contact_name;
                        $data1[$p1]['photos']='';
                        $data1[$p1]['code']=$value->code;
                        $data1[$p1]['flatname']=isset($flats->flatname)?$flats->flatname:'';
                        $data1[$p1]['buildingname']=isset($flats->buildingname)?$flats->buildingname:'';
                        $data1[$p1]['flag']=(int)'';
                        $data1[$p1]['Intime']="";
                        $data1[$p1]['Outtime']="";
                        $data1[$p1]['inOutFlag']=(int)'';
                        $data1[$p1]['type']='1';
                    }

                    $p1++;
        }


        $result = array_merge($data, $data1);
        krsort($result);
        array_multisort($result,SORT_DESC);

        return response()->json(['data' => $result,'status'=>1,'message' => "Current Visitor List."] , 200);
    }

    public function InoutVisitor(Request $request)
    {
        $type=request('type');// 1-In  // 2-Out

        $id=request('request_id');

        $user_type=request('user_type');// 1-Schedule  // 2-UnSchedule

        if($type=='1')
        {

            $visitor=Inouts::where('request_id',$id)->where('type',$user_type)->where('flag',1)->first();


            if($visitor['intime'] == null)
            {       
                    if($user_type==2 ||$user_type==1)
                    {
                        $building_id=Building::where('name',request('building_id'))->where('society_id',request('society_id'))->first();

                        $building=Flat::where('name',request('flat_id'))->where('building_id',$building_id->id)->first();

                        $userdeviceid=Member::where('society_id',request('society_id'))->where('flat_id',$building->id)->where('relation','=','self')->first();

                        if($userdeviceid->occupancy=='Tenant' || $userdeviceid->occupancy=='tenant')
                        {
                            $users=Member::where('society_id',request('society_id'))->where('flat_id',$building->id)->where('flatType','=','Renting the flat')->first();
                        }
                        else
                        {
                            $users=Member::where('society_id',request('society_id'))->where('flat_id',$building->id)->where('relation','=','self')->first();
                        }

                        $Settings=Settings::where('user_id',$users->user_id)->first();
                        
                        if($Settings->mute_notification_status==1)
                        {
                            $inouts = new Inouts();
                            $inouts->society_id = request('society_id');
                            $inouts->guard_id = request('guard_id');
                            $inouts->request_id = $id;
                            $inouts->type = $user_type;
                            $inouts->intime = request('intime');
                            $inouts->flag = 1;
                            $inouts->building_id=request('building_id');
                            $inouts->flat_id=request('flat_id');
                            $inouts->save();

                            $Visitor=InviteGuest::where('id',$id)->update(['flag'=>1]);


                            return response()->json(['data' => $inouts,'status'=>1,'message' => "Entry In Successfully."] , 200);   
                        }
                        else
                        {
                            return response()->json(['data' => (Object)[],'status'=>2,'message' =>$Settings->reason_to_mute_notification] , 200);   
                        }
                    }

                    if($user_type==3)
                    {
                            $inouts = new Inouts();
                            $inouts->society_id = request('society_id');
                            $inouts->guard_id = request('guard_id');
                            $inouts->request_id = $id;
                            $inouts->type = $user_type;
                            $inouts->intime = request('intime');
                            $inouts->flag = 1;
                            $inouts->building_id=request('building_id');
                            $inouts->flat_id=request('flat_id');
                            $inouts->save();

                            $Visitor=InviteGuest::where('id',$id)->update(['flag'=>1]);


                            return response()->json(['data' => $inouts,'status'=>1,'message' => "Entry In Successfully."] , 200); 
                    }
                    
                                
            }
            else
            {
                 return response()->json(['data' => (Object)[],'status'=>0,'message' => "Guest is already IN."] , 200);
            }
        }

        if($type=='2')
        {
           
            $visitor=Inouts::where('request_id',$id)->where('type','=',$user_type)->where('flag',1)->orderBy('created_at', 'desc')->first();
            
            if(isset($visitor))
            {
                if($visitor['outtime'] == null)
                {
                $Visitor=Inouts::where('request_id',$id)->where('type',$user_type)->update(['flag'=>2,'outtime'=>request('outtime')]);

                $Visitor=Inouts::where('request_id',$id)->where('type',$user_type)->get();

                if($user_type=='1' || $user_type=='1')
                {
                    $Visitor=InviteGuest::where('id',$id)->update(['flag'=>2]);
                }
                if($user_type=='2' || $user_type=='2')
                {
                    $Visitor=Visitor::where('id',$id)->update(['inOutFlag'=>2]);
                    $Visitor=Inouts::where('request_id',$id)->where('type',2)->get();
                }

                return response()->json(['data' => $Visitor,'status'=>1,'message' => "Entry Out Successfully."] , 200);
                }
            }
            else
            {
                
                return response()->json(['data' => [],'status'=>0,'message' => "Guest is already OUT."] , 200);
            }
        }
    }

    public function guardLogout(Request $request)
    {
        $guard_id=request('guard_id');

        $user=Guard::whereId($guard_id)->update(['fcm_token'=>'']);

        return response()->json(['data' => '[]','status'=>1,'message' => "Successfully logout."] , 200);
    }

    public function addFrequentEntry(Request $request)
    {
        $validator = Validator::make($request->all(), [
                   'society_id'  => 'required',
                   
                   
        ]);
        if ($validator->fails()) {
            $errorArray = $validator->errors()->all();
           return response()->json(['data' =>(Object) $errorArray,'status'=>0,'message' => "Please enter valid data."] , 200);
        }else
        {
                $userId = auth()->user()->id;
                $userName = auth()->user()->name;
                //dd($userName);

                $type=request('type');

                if($type=='once')
                {
                        $school_array=request('contact_array');

                        $someArray = json_decode($school_array, true);
                    
                        if (is_array($someArray) || is_object($someArray))
                        {

                            foreach ($someArray as $value) {

                                    $code = mt_rand(1000, 9999);
                                    $visitor=new InviteGuest();
                                    $visitor->user_id=$userId;
                                    $visitor->society_id=request('society_id');
                                    $visitor->code='#'.$code;
                                    $visitor->type=$type;
                                    $visitor->time=request('time');
                                    $visitor->start_date=request('start_date');
                                    $visitor->maxhour=request('maxhour');
                                    $visitor->contact_name=$value['name'];
                                    $visitor->contact_number=$value['contact'];
                                    $visitor->save();
                                    $societylist=Society::where('id',request('society_id'))->first();
                                    $society_name=isset($societylist->name)?$societylist->name:'';
                                    $output = substr($value['contact'], 0, 3);
                                    $society=Society::where('id',request('society_id'))->first();

                                    $lat=isset($society->lat)?$society->lat:'';
                                    $long=isset($society->lng)?$society->lng:'';

                                    $start_date=date('d-m-Y',strtotime(request('start_date')));
                                    if(isset($society->lat) && isset($society->lng))
                                    {
                                         $new_url = TinyUrl::get_tiny_url('https://www.google.com/maps/search/?api=1&query='.$lat.','.$long.'');
                                    }

                                   
                                    if($output=='+91')
                                    {
                                        $nn=str_replace(' ', '', $value['contact']);
                                        
                                        if(isset($new_url))
                                        {
                                             $otp_new = ucfirst($userName).' has invited you to '.$society_name.'.'.PHP_EOL.'Security code:'.$code.PHP_EOL.'Visit date : '.$start_date.' at '.request('time').PHP_EOL.'Location: '.$new_url.'';
                                        }
                                        else
                                        {
                                             $otp_new = ucfirst($userName).' has invited you to '.$society_name.'.'.PHP_EOL.'Security code:'.$code.PHP_EOL.'Visit date : '.$start_date.' at '.request('time').PHP_EOL.'';
                                        }
                                       
                                        
                                        Otp::send_otp($nn,$otp_new);
                                    }
                                    else
                                    {
                                        $number='+91'.$value['contact'];
                                        $nn=str_replace(' ', '', $number);
                                         if(isset($new_url))
                                        {
                                            $otp_new = ucfirst($userName).' has invited you to '.$society_name.'.'.PHP_EOL.'Security code:'.$code.PHP_EOL.'Visit date: '.$start_date.' at '.request('time').PHP_EOL.'Location: '.$new_url.'';
                                        }
                                        else
                                        {
                                            $otp_new = ucfirst($userName).' has invited you to '.$society_name.'.'.PHP_EOL.'Security code:'.$code.PHP_EOL.'Visit date : '.$start_date.' at '.request('time').PHP_EOL.'';
                                        }


                                        Otp::send_otp($nn,$otp_new);
                                    }
                            }
                        }
                }

                if($type=='frequently')
                {
                         $school_array=request('contact_array');

                        $someArray = json_decode($school_array, true);
                    
                        if (is_array($someArray) || is_object($someArray))
                        {

                            foreach ($someArray as $value) {

                                    $code = mt_rand(1000, 9999);
                                    $visitor=new InviteGuest();
                                    $visitor->user_id=$userId;
                                    $visitor->society_id=request('society_id');
                                    $visitor->code='#'.$code;
                                    $visitor->type=$type;
                                    $visitor->start_date=request('start_date');
                                    $visitor->end_date=request('end_date');
                                    $visitor->maxhour=request('maxhour');
                                    $visitor->contact_name=$value['name'];
                                    $visitor->contact_number=$value['contact'];
                                    $visitor->save();

                                    $start_date=date('d-m-Y',strtotime(request('start_date')));
                                    $end_date=date('d-m-Y',strtotime(request('end_date')));
                                    $otp=$code;

                                    $society=Society::where('id',request('society_id'))->first();

                                    $lat=isset($society->lat)?$society->lat:'';
                                    $long=isset($society->lng)?$society->lng:'';

                                    if(isset($society->lat) && isset($society->lng))
                                    {
                                         $new_url = TinyUrl::get_tiny_url('https://www.google.com/maps/search/?api=1&query='.$lat.','.$long.'');
                                    }

                                    

                                     $societylist=Society::where('id',request('society_id'))->first();
                                    $society_name=isset($societylist->name)?$societylist->name:'';

                                    $output = substr($value['contact'], 0, 3);

                                    if($output=='+91')
                                    {
                                        $nn=str_replace(' ', '', $value['contact']);
                                        // $otp_new = $value['name'].' has invited you to '.$society_name.' security code:'.$code.' visit date and time: '.request('start_date').'"to"'.request('end_date').'location: https://tinyurl.com/yxwgs9mq';

                                         if(isset($new_url))
                                        {
                                            $otp_new = ucfirst($userName).' has invited you to '.$society_name.'.'.PHP_EOL.'Security code:'.$code.PHP_EOL.'Visit date : '.$start_date.' to '.$end_date.PHP_EOL.'Location: '.$new_url.'';
                                        }
                                        else
                                        {
                                             $otp_new = ucfirst($userName).' has invited you to '.$society_name.'.'.PHP_EOL.'Security code:'.$code.PHP_EOL.'Visit date : '.$start_date.' to '.$end_date.PHP_EOL.'';
                                        }

                                        Otp::send_otp($nn,$otp_new);
                                    }
                                    else
                                    {
                                        $number='+91'.$value['contact'];
                                        $nn=str_replace(' ', '', $number);
                                        // $otp_new = $value['name'].' has invited you to '.$society_name.' security code:'.$code.' visit date and time: '.request('start_date').'"to"'.request('end_date').'location: https://tinyurl.com/yxwgs9mq';

                                        
                                        if(isset($new_url))
                                        {
                                            $otp_new = ucfirst($userName).' has invited you to '.$society_name.'.'.PHP_EOL.'Security code:'.$code.PHP_EOL.'Visit date : '.$start_date.' to '.$end_date.PHP_EOL.'Location: '.$new_url.'';
                                        }
                                        else
                                        {
                                             $otp_new = ucfirst($userName).' has invited you to '.$society_name.'.'.PHP_EOL.'Security code:'.$code.PHP_EOL.'Visit date : '.$start_date.' to '.$end_date.PHP_EOL.'';
                                        }
                                        Otp::send_otp($nn,$otp_new);
                                    }
                            }
                        }
                }

                return response()->json(['data' =>[],'status'=>1,'message' => "Successfully Added."] , 200);

        }
    }

    public function allvisitorList(Request $request)
    {
        $guard_id=request('guard_id');


        $society=Guard::where('id',$guard_id)->first();

        $society_id=isset($society->society_id)?$society->society_id:'';

        $Visitor= DB::table('visitor')
          ->select('visitor.id','visitor.name','visitor.photos','flats.name as flatname','buildings.name as buildingname','visitor.flag','visitor.created_at')
          ->join('flats','flats.id','=','visitor.flat_id')
          ->join('buildings','buildings.id','=','visitor.building_id')
          //->where('visitor.guard_id',$guard_id)
          ->where('visitor.society_id',$society_id)
          ->orderby('visitor.id','desc')
          ->get();
          
        $data = [];
        $p = 0;

        foreach ($Visitor as $value) 
        {
                
                $visitor= DB::table('inoutlists')
                        ->select('inoutlists.intime as Intime','inoutlists.outtime as Outtime','inoutlists.flag as inOutFlag')
                        ->where('inoutlists.request_id',$value->id)
                        //->where('inoutlists.flag',1)
                        //->where('inoutlists.type',2)
                        //->whereOr('inoutlists.flag','!=',2)
                        ->first();

                if($visitor)
                {
                        $data[$p]['id']=$value->id;
                        $data[$p]['name']=$value->name;
                        $data[$p]['photos']=$value->photos;
                        $data[$p]['flatname']=$value->flatname;
                        $data[$p]['buildingname']=$value->buildingname;
                        $data[$p]['flag']=$value->flag;
                        $data[$p]['Intime']=$visitor->Intime;
                        $data[$p]['Outtime']=$visitor->Outtime;
                        $data[$p]['inOutFlag']=$visitor->inOutFlag;
                        $data[$p]['create_at']=$value->created_at;
                }
                else
                {
                        $data[$p]['id']=$value->id;
                        $data[$p]['name']=$value->name;
                        $data[$p]['photos']=$value->photos;
                        $data[$p]['flatname']=$value->flatname;
                        $data[$p]['buildingname']=$value->buildingname;
                        $data[$p]['flag']=$value->flag;
                        $data[$p]['Intime']="";
                        $data[$p]['Outtime']="";
                        $data[$p]['inOutFlag']=(int)'';
                        $data[$p]['create_at']=$value->created_at;
                }
                $p++;
        }


        return response()->json(['data' => $data,'status'=>1,'message' => "All Visitor List."] , 200);
    }

    public function getfamilyMember($userId)
    {

        $Member=Member::where('user_id',$userId)->first();

        if($Member->relation=='self')
        {

            $Member1=Member::where('family_user_id',$userId)->get();

            $id=[];

            foreach ($Member1 as $value) {
                $id[]=$value->user_id;
            }

            $Member2=Member::where('user_id',$userId)->get();

            $id2=[];

            foreach ($Member2 as $value) {
                $id2[]=$value->user_id;
            }

            $res = array_merge($id, $id2); 


            return $res;

        }
        else
        {
            $Member1=Member::where('family_user_id',$Member->family_user_id)->get();

            $id=[];

            foreach ($Member1 as $value) {
                $id[]=$value->user_id;
            }

            $Member2=Member::where('user_id',$Member->family_user_id)->get();

            $id2=[];

            foreach ($Member2 as $value) {
                $id2[]=$value->user_id;
            }

            $res = array_merge($id, $id2); 

            return $res;

        }


    }
    public function getguestlist(Request $request)
    {
        $userId = auth()->user()->id;
        $familyMember=$this->getfamilyMember($userId);

        $InviteGuest=InviteGuest::whereIn('user_id',$familyMember)->orderBy('id','desc')->get();

        
       //  $Member=Member::where('user_id',auth()->user()->id)->first();
        
       // // $InviteGuest=InviteGuest::where('user_id',$userId)->orderBy('id', 'DESC')->get();

       //  if($Member)
       //  {
       //      if($Member->family_user_id != 0)
       //      {
       //          $Member=Member::where('user_id',$Member->family_user_id)->orWhere('user_id',auth()->user()->id)->orWhere('family_user_id',$Member->family_user_id)->get();

       //          foreach ($Member as $value) {
            
       //                  $InviteGuest=InviteGuest::where('user_id',$userId)->orWhere('user_id',$value->user_id)->orWhere('user_id',$value->family_user_id)->orderBy('id', 'DESC')->get();
       //          }
       //      }
       //      else
       //      {
       //          $Member=Member::where('user_id',$Member->user_id)->orWhere('family_user_id',auth()->user()->id)->orWhere('user_id',auth()->user()->id)->get();

       //          foreach ($Member as $value) {
            
       //                  $InviteGuest=InviteGuest::where('user_id',$userId)->orWhere('user_id',$value->user_id)->orWhere('user_id',$value->family_user_id)->orderBy('id', 'DESC')->get();
       //          }
       //      }
       //  }
            
        return response()->json(['data' => $InviteGuest,'status'=>1,'message' => "Invite Guest List."] , 200);
    }

    public function addsettings(Request $request)
    {
        $userId = auth()->user()->id;

        $Settings=Settings::where('user_id',$userId)->first();

        if($Settings !=null)
        {
            $Settings = Settings::find($Settings->id);

            if(request('receiver_id'))
            {
                Settings::where('user_id',$userId)->update(['receiver_id'=>request('receiver_id')]);

                $Member=Member::where('family_user_id',$userId)->get();

                if(!$Member->isEmpty())
                {
                    foreach ($Member as  $value) {
                       
                            $user=Settings::where('user_id',$value->user_id)->update(['receiver_id'=>request('receiver_id')]);

                            $user=Settings::where('user_id',$value->family_user_id)->update(['receiver_id'=>request('receiver_id')]);

                    }

                    $Settings->receiver_id=request('receiver_id');
                }
                else
                {
                    $Member=Member::where('user_id',$userId)->first();

                    $user=Settings::where('user_id',$userId)->update(['receiver_id'=>request('receiver_id')]);

                    $family_user_id=isset($Member->family_user_id)?$Member->family_user_id:'';

                    $user=Settings::where('user_id',$family_user_id)->update(['receiver_id'=>request('receiver_id')]);
                    
                    $Members=Member::where('family_user_id',$family_user_id)->get();

                    if(!$Members->isEmpty())
                    {
                        foreach ($Members as  $value) {
                           
                            $user=Settings::where('user_id',$value->user_id)->update(['receiver_id'=>request('receiver_id')]);
                        }
                    }
                    else
                    {
                        $Settings->receiver_id=request('receiver_id');
                    }
                    
                }

            }
            if(request('event'))
            {
                $Settings->event=(int)request('event');
            }
            if(request('notice'))
            {
                $Settings->notice=(int)request('notice');
            }
            if(request('circular'))
            {
                $Settings->circular=(int)request('circular');
            }
            if(request('contact_details'))
            {
                $Settings->contact_details=(int)request('contact_details');
            }
            if(request('family_details'))
            {
                $Settings->family_details=(int)request('family_details');
            }
            if(request('mute_notification_status')){
                $Settings->mute_notification_status=(int)request('mute_notification_status');
            }
            if(request('reason_to_mute_notification')){
                $Settings->reason_to_mute_notification=request('reason_to_mute_notification');
            }
            $Settings->save();
            $Settings=Settings::where('user_id',$userId)->first();

            return response()->json(['data' =>$Settings,'status'=>1,'message' => "Settings Updated Successfully."] , 200);
        }
        else
        {
            $visitor=new Settings();
            $visitor->user_id=$userId;
            if(request('receiver_id'))
            {
                $Member=Member::where('family_user_id',$userId)->get();
                Settings::where('user_id',$userId)->update(['receiver_id'=>request('receiver_id')]);
                if(!$Member->isEmpty())
                {
                    foreach ($Member as  $value) {
                    $new=Settings::where('user_id',$value->user_id)->first();

                        if(request('receiver_id'))
                        {
                            $user=Settings::where('user_id',$value->user_id)->update(['receiver_id'=>request('receiver_id')]);
                        }
                    }
                }
                else
                {
               
                    $Member=Member::where('user_id',$userId)->first();

                    $user=Settings::where('user_id',$userId)->update(['receiver_id'=>request('receiver_id')]);
                    $family_user_id=isset($Member->family_user_id)?$Member->family_user_id:'';
                    
                    $Members=Member::where('family_user_id',$family_user_id)->get();

                    if(!$Members->isEmpty())
                    {
                        foreach ($Members as  $value) {
                           
                            $user=Settings::where('user_id',$value->user_id)->update(['receiver_id'=>request('receiver_id')]);
                        }
                    }
                    else
                    {
                        $Settings->receiver_id=request('receiver_id');
                    }
                }
                
            }
            $visitor->receiver_id=request('receiver_id');
            $visitor->event=request('event');
            $visitor->notice=request('notice');
            $visitor->circular=request('circular');
            $visitor->contact_details=request('contact_details');
            $visitor->family_details=request('family_details');
            $visitor->mute_notification_status=request('mute_notification_status');
            $visitor->reason_to_mute_notification=request('reason_to_mute_notification');
            $visitor->save();

            return response()->json(['data' =>$visitor,'status'=>1,'message' => "Settings Added Successfully."] , 200);
        }
    }

    public function getSettings(Request $request)
    {
        $userId = auth()->user()->id;

        $InviteGuest=Settings::where('user_id',$userId)->get();

        return response()->json(['data' => $InviteGuest,'status'=>1,'message' => "Settings Get Successfully."] , 200);
    }

    public function deletefrequententry(Request $request)
    {
        $id=request('id');

        $inviteguest=InviteGuest::where('id',$id)->delete();

        if($inviteguest)
        {
              return response()->json(['data' => "1",'status'=>1,'message' => "Frequently Deleted SuccessFully."] , 200);
        }
        else
        {
              return response()->json(['data' => "0",'status'=>0,'message' => "Frequently Deleted Failed."] , 200);
        }
    }

    public function preapporvedEntryList(Request $request)
    {
        $society_id=request('society_id');

        $date=date("Y-m-d");
        
        $inviteguest=InviteGuest::where('society_id',$society_id)->with(['guestlist' => function($query){
            $query->where('flag',1);
            $query->where('type',1);
        }],'users')->where('start_date',$date)->orWhere('end_date',$date)->whereBetween('start_date', [$date, $date])->orwherebetween('end_date', [$date, $date])->get();

        $response = [];

        foreach ($inviteguest as $u) {
                    $response[] = [
                            "id" => $u->id,
                            "user_id" => $u->user_id,
                            "society_id" => $u->society_id,
                            "code" => $u->code,
                            "type" => $u->type,
                            "time" => $u->time,
                            "maxhour" => $u->maxhour,
                            "start_date" => $u->start_date,
                            "end_date" => $u->end_date,
                            "contact_name" => $u->contact_name,
                            "contact_number" => $u->contact_number,
                            "user_name" => isset($u->users->name)?$u->users->name:'',
                            "flat_name"=>isset($u->users->member->flat->name)?$u->users->member->flat->name:'',
                            "building_name"=>isset($u->users->member->building->name)?$u->users->member->building->name:'',
                            "request_id"=>isset($u->guestlist->request_id)?$u->guestlist->request_id:'',
                            "intime"=>isset($u->guestlist->intime)?$u->guestlist->intime:'',
                            "outtime"=>isset($u->guestlist->outtime)?$u->guestlist->outtime:'',
                            "flag"=>isset($u->guestlist->flag)?$u->guestlist->flag:''
                          ];
        }

        return response()->json(['data' => $response,'status'=>1,'message' => "Guest list Successfully."] , 200);
    }

    public function deleteguestentry(Request $request)
    {
        $type=request('type');

        $id=request('request_id');

        if($type==1)
        {
            $Inouts=Inouts::where('request_id',$id)->where('type',1)->update(['soft_delete'=>1]);
            
            InviteGuest::where('id',$id)->update(['soft_delete'=>1]);

            if($Inouts==1)
            {
                  return response()->json(['data' => "1",'status'=>1,'message' => "Inouts Deleted SuccessFully."] , 200);
            }
            else
            {
                  return response()->json(['data' => "0",'status'=>0,'message' => "Inouts Deleted Failed."] , 200);
            }
        }

        if($type==2)
        {
            $Inouts=Inouts::where('request_id',$id)->where('type',2)->update(['soft_delete'=>1]);
            
            Visitor::where('id',$id)->update(['soft_delete'=>1]);
            if($Inouts==1)
            {
                  return response()->json(['data' => "1",'status'=>1,'message' => "Inouts Deleted SuccessFully."] , 200);
            }
            else
            {
                  return response()->json(['data' => "0",'status'=>0,'message' => "Inouts Deleted Failed."] , 200);
            }
        }
    }

    public function DomesticHelpersList(Request $request)
    {
        $society_id=request('society_id');

        $helperslist=DomesticHelpers::where('society_id',$society_id)->with(['helperslist' => function($query){
            $query->where('flag',1);
            $query->where('type',3);
        }],'types')->where('status',1)->get();
        
        $response = [];

        foreach ($helperslist as $u) {
                    $type_name = DB::table('servicetypes')
                            ->select('servicetypes.name as type_name')
                            ->where('servicetypes.id',$u->type_id)
                            ->first();
                    $response[] = [
                            "id" => $u->id,
                            "user_id" => $u->user_id,
                            "society_id" => $u->society_id,
                            "name" => $u->name,
                            "pin" => $u->pin,
                            "type_name" =>$type_name->type_name,
                            "member_id" =>$u->member_id,
                            "mobile" => $u->mobile,
                            "document" =>$u->document,
                            "photos" => $u->photos,
                            "gender" => $u->gender,
                            "status" => $u->status,
                            "request_id"=>isset($u->helperslist->request_id)?$u->helperslist->request_id:'',
                            "intime"=>isset($u->helperslist->intime)?$u->helperslist->intime:'',
                            "outtime"=>isset($u->helperslist->outtime)?$u->helperslist->outtime:'',
                            "flag"=>isset($u->helperslist->flag)?$u->helperslist->flag:(int)''
                          ];
        }

        return response()->json(['data' => $response,'status'=>1,'message' => "Helpers list Successfully."] , 200);
    }

    // public function checknotificationflag(Request $request)
    // {
    //     $request_id=request('request_id');

    //     $inouts=Inouts::where('type',1)->where('request_id',$request_id)->get();

    //      return response()->json(['data' => $inouts,'status'=>1,'message' => "Flag Successfully."] , 200);

    // }

     public function getmemberfamilylist(Request $request)
      {
          $user_id=request('user_id');

          $member=Member::where('family_user_id',$user_id)->with('user','flat','building')->get();

          $response = [];

          foreach ($member as $u) {
            $u->name =
            $response[] = [
              "id" => $u->user->id,
              "name" => $u->user->name,
              "phone" => $u->user->phone,
              "image" => $u->user->image,
              "Member_id"=>$u->id,
              // "flattype" => $u->flattype,
              "gender" => $u->gender,
              "profession" => $u->profession,
              "relation" => $u->relation,
              "dob" => $u->dob,
              "bloodgroup" => $u->bloodgroup
            ];
          }

          return response()->json(['data' => $response,'status'=>1,'message' => "Successfully Get family member."] , 200);
      }

      public function MemberList(Request $request)
      {
        

        $society_id = request('society_id');

        $building_id=request('building_id');

        if($building_id=='0')
        {
            $member=Member::where('society_id',$society_id)->with('user','flat','building','vehicle')->whereHas('user', function($q){
              $q->where('activate', 1);
            })->get();


        }
        else
        {
            $member=Member::where('relation','=','self')->where('society_id',$society_id)->where('building_id',$building_id)->with('user','flat','building','vehicle')->whereHas('user', function($q){
              $q->where('activate', 1);
            })->get();
        }

        

        $response = [];

        foreach ($member as $u) {
          $Settings=Settings::where('user_id',$u->user_id)->first();
          $familyMember=$this->getfamilyMember($u->user_id);
          $vehicles = Vehicle::select('id','user_id','number','type')->whereIn('user_id', $familyMember)->orderBy('id','desc')->get();
          $response[] = [
            "id" => $u->id,
            "user_id"=>$u->user_id,
            "society_id"=>$u->society_id,
            "building_id"=>$u->building_id,
            "flat_id"=>$u->flat_id,
            "flatType"=>$u->flatType,
            "occupancy"=>$u->occupancy,
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
            "role"=>isset($u->user->roles->first()->name)?$u->user->roles->first()->name:'',
            "profession" => $u->profession,
            "relation" => $u->relation,
            "dob" => $u->dob,
            "bloodgroup" => $u->bloodgroup,
            "vehicles"=>$vehicles,
            "created_at"=>$u->user->created_at->toDateString(),
            "updated_at"=>$u->user->updated_at->toDateString(),
            "contact_status"=>isset($Settings->contact_details)?$Settings->contact_details:0,
            "member_status"=>isset($Settings->family_details)?$Settings->family_details:0,
          ];
        }
        return response()->json(['data' => $response,'status'=>1,'message' => "Successfully Member list."] , 200);
      }

    public function recentvisitorList(Request $request)
    {
        $guard_id=request('guard_id');  

        $yesterday = date("Y-m-d",strtotime( '-1 days' ));

        $today=date("Y-m-d");
        
        $society=Guard::where('id',$guard_id)->first();

        $society_id=isset($society->society_id)?$society->society_id:'';

        $Visitor= DB::table('visitor')
          ->select('visitor.id','visitor.name','visitor.photos','flats.name as flatname','buildings.name as buildingname','visitor.flag','visitor.created_at')
          ->join('flats','flats.id','=','visitor.flat_id')
          ->join('buildings','buildings.id','=','visitor.building_id')
          ->where('visitor.society_id',$society_id)
          ->whereDate('visitor.created_at',$today)
          ->orWhereDate('visitor.created_at',$yesterday)
          ->orderby('visitor.id','desc')
          ->get();

        $data = [];
        $p = 0;

        foreach ($Visitor as $value) 
        {
                
                $visitor= DB::table('inoutlists')
                        ->select('inoutlists.intime as Intime','inoutlists.outtime as Outtime','inoutlists.flag as inOutFlag')
                        ->where('inoutlists.request_id',$value->id)
                        //->where('inoutlists.flag',1)
                        //->where('inoutlists.type',2)
                        //->whereOr('inoutlists.flag','!=',2)
                        ->first();

                if($visitor)
                {
                        $data[$p]['id']=$value->id;
                        $data[$p]['name']=$value->name;
                        $data[$p]['photos']=$value->photos;
                        $data[$p]['flatname']=$value->flatname;
                        $data[$p]['buildingname']=$value->buildingname;
                        $data[$p]['flag']=$value->flag;
                        $data[$p]['Intime']=$visitor->Intime;
                        $data[$p]['Outtime']=$visitor->Outtime;
                        $data[$p]['inOutFlag']=$visitor->inOutFlag;
                        $data[$p]['create_at']=$value->created_at;
                }
                else
                {
                        $data[$p]['id']=$value->id;
                        $data[$p]['name']=$value->name;
                        $data[$p]['photos']=$value->photos;
                        $data[$p]['flatname']=$value->flatname;
                        $data[$p]['buildingname']=$value->buildingname;
                        $data[$p]['flag']=$value->flag;
                        $data[$p]['Intime']="";
                        $data[$p]['Outtime']="";
                        $data[$p]['inOutFlag']=(int)'';
                        $data[$p]['create_at']=$value->created_at;
                }
                $p++;
        }


        return response()->json(['data' => $data,'status'=>1,'message' => "All Visitor List."] , 200);
    }

    public function url(Request $request)
    {
        $society_id=request('society_id');
        $society=Society::where('id',$society_id)->first();

        $lat=isset($society->lat)?$society->lat:'';
        $long=isset($society->lng)?$society->lng:'';
        $new_url = TinyUrl::get_tiny_url('https://www.google.com/maps/search/?api=1&query='.$lat.','.$long.'');

    }

    public function domestichelpersinout(Request $request)
    {

        $id=request('helpers_id');

        $type=request('type');

        if($type=='1')
        {
            $inouts = new HelpersInout();
            $inouts->society_id = request('society_id');
            $inouts->guard_id = request('guard_id');
            $inouts->helpers_id = $id;            
            $inouts->intime = request('intime');
            $inouts->flag = 1;
            $inouts->save();

            return response()->json(['data' => $inouts,'status'=>1,'message' => "Entry In Successfully."] , 200);  
        }

        if($type=='2')
        {

            $HelpersInout=HelpersInout::where('id',request('id'))->update(['flag'=>2,'outtime'=>request('outtime')]);

            $HelpersInout=HelpersInout::where('id',request('id'))->get();

            return response()->json(['data' => $HelpersInout,'status'=>1,'message' => "Entry Out Successfully."] , 200);
        }
             
    }

    public function verifyvehical(Request $request)
    {
        $vehicle_number=request('vehicle_number');

        $society_id=request('society_id');

        //$mobilenumber=request('mobilenumber');

        $type=request('type');

        if($type==1)
        {
            $vehicle=Vehicle::where('number','=',$vehicle_number)->with('user')->whereHas('user',function($q) use ($society_id){
                 $q->where('society_id',$society_id);
            })->first();
        
            if($vehicle)
            {
                return response()->json(['data' => (Object)[],'status'=>1,'message' => "Vehicle Verified."] , 200);
            }else
            {
                return response()->json(['data' => (Object)[],'status'=>0,'message' => "Vehicle not verified."] , 200);
            }
        }

        if($type==2)
        {
            $member=Member::with('user')->whereHas('user',function($q) use ($vehicle_number,$society_id){
                 $q->where('phone',$vehicle_number);
                 $q->where('society_id',$society_id);
            })->first();
        
            if($member)
            {
                return response()->json(['data' => (Object)[],'status'=>1,'message' => "Member Verified."] , 200);
            }else
            {
                return response()->json(['data' => (Object)[],'status'=>0,'message' => "Member not verified."] , 200);
            }
        }
        
       
    }

    public function getAmenties(Request $request)
    {
        $amenties=Amenties::where('society_id',request('society_id'))->where('status',1)->get();

        return response()->json(['data' => $amenties,'status'=>1,'message' => "Amenties list."] , 200);
    }

    public function bookAmenties(Request $request)
    {
        $amenties_id=request('id');
        $date=request('date');
        $start_time=request('start_time');
        $end_time=request('end_time');
        $society_id=request('society_id');
        $user_id = auth()->user()->id;
        $description=request('description');

        $amentiesBooking = new Amentiesbooking();
        $amentiesBooking->amenties_id = $amenties_id;
        $amentiesBooking->user_id = $user_id;
        $amentiesBooking->date = $date;            
        $amentiesBooking->start_time = $start_time;
        $amentiesBooking->end_time = $end_time;
        $amentiesBooking->description = $description;
        $amentiesBooking->save();

        return response()->json(['data' => $amentiesBooking,'status'=>1,'message' => "Booking Successfully."] , 200);  
    }

    public function bookingList(Request $request)
    {
        $user_id = auth()->user()->id;

        $amentiesBooking = Amentiesbooking::where('user_id',$user_id)->with('amenties')->get();

        $response=[];

        foreach ($amentiesBooking as $am) {
            
             $response[] = [
                        "id" => $am->id,
                        "amenties_id" => $am->amenties_id,
                        "user_id" => $am->user_id,
                        "date" => $am->date,
                        "start_time" => $am->start_time,
                        "end_time" => $am->end_time,
                        "description" => $am->description,
                        "apporve" => $am->apporve,
                        "amenties_name" => isset($am->amenties->name)?$am->amenties->name:'',
                        "created_at"=>isset($am->created_at)?$am->created_at->toDateTimeString():'',
                        "updated_at"=>isset($am->updated_at)?$am->updated_at->toDateTimeString():'',
            ];
        }

        return response()->json(['data' => $response,'status'=>1,'message' => "Booking List."] , 200);  

    }

    public function deletebooking(Request $request)
    {
        $id=request('id');

        $amentiesBooking = Amentiesbooking::where('id',$id)->delete();

        return response()->json(['data' => [],'status'=>1,'message' => "Booking Deleted Successfully."] , 200); 
    }

    public function updatebooking(Request $request)
    {
        $id=request('id');

        $user_id = auth()->user()->id;

        $booking=Amentiesbooking::find($id);

        $booking->date=request('date');

        $booking->start_time=request('start_time');

        $booking->end_time=request('end_time');

        $booking->description=request('description');

        $booking->save();

        return response()->json(['data' => $booking,'status'=>1,'message' => "Booking Updated Successfully."] , 200);  
    }
}
