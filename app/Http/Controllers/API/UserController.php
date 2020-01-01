<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use App\Role;
use DB;
use Validator;
use Auth;
use App\User;
use App\Member;
use App\Familymember;
use App\Visitor;
use App\Settings;
use App\DomesticHelpers;
use App\Reviews;
use App\Inouts;
use App\Society;
use App\Helpers\Notification\Otp;
use App\Helpers\Notification\PushNotificationDemo;
use App\Vehicle;
use App\Notification;
use App\Flat;
use App\Building;
use QrCode;
use Storage;
class UserController extends Controller
{
    // 1 = Succcess status
    // 0 = Error status

  public function getfamilyMemberList($userId)
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

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
                   'username'  => 'required',
                   //'email'     => 'required|email|unique:users',
                   'phone'  => 'required| min:9 | max:13 | unique:users',
                   'society_id'  => 'required',
                   'building_id'  => 'required',
                   'flat_id'  => 'required',
                   'flatType'  => 'required',
                   // 'city_id'  => 'required',
                   // 'area_id'  => 'required'
        ]);
        if ($validator->fails()) {
            $errorArray = $validator->errors()->all();
           return response()->json(['data' =>(Object) $errorArray,'status'=>0,'message' => "Please enter valid data."] , 200);
        }
        $mobilexist = User::where('phone',request('phone'))->count();
        if($mobilexist){
            $error[] = 'Phone number is already exist.';
           return response()->json(['data' =>(Object) $error,'status'=>0,'message' => "Phone number is already exist."] , 200);
        }
        try {

            $user = User::create([
                'fcm_token' => request('fcm_token'),
                'email' => request('email'),
                'name' => request('username'),
                'society_id' => request('society_id'),
                'password' => Hash::make('user@123'),
                'phone' => request('phone')
            ]);

            if($user->id){

                $users = User::find($user->id);
                
                $users->attachRole(9);
                $users->role = "Committee Member";
                $users->token = $users->createToken('MyApp')->accessToken;

                $member = new Member;
                $member->user_id = $user->id;
                $member->society_id = request('society_id');
                $member->building_id = request('building_id');
                $member->flat_id = request('flat_id');
                $member->flatType = request('flatType');
                $member->profession = request('profession');
                $member->profession_detail = request('profession_detail');
                $member->relation = 'self';
                $flatname=Flat::select('name')->where('id',request('flat_id'))->first();
                $buildingname=Building::select('name')->where('id',request('building_id'))->first();

                $orcode='Name: '.request('username').PHP_EOL.'Flat No: '.$buildingname->name.'-'.$flatname->name.PHP_EOL.'Phone: '.request('phone'); 
                
                $codeimage=QrCode::format('png')->size(300)->generate($orcode); 
                $output_file =   time() . '.png';
                $dd=Storage::disk('local')->put($output_file, $codeimage);
                $member->qrcode=$output_file;                
                $member->save();

                $visitor=new Settings();
                $visitor->user_id=$user->id;
                $visitor->receiver_id=$user->id;
                $visitor->save();

                $notification=new Notification();
                $notification->text="New Member Created Successfully";
                $notification->user_id=$user->id;
                $notification->type=4;
                $notification->save();

                return response()->json(['data' => $users,'status'=>1,'message' => "Thank you for registering. You can login once your society admin approve your account."] , 200);
            }else{
                return response()->json(['data' => "0",'status'=>0,'message' => "User not created"] , 200);
            }
        } catch (Exception $e) {
                return response()->json(['data' => "0",'status'=>0,'message' => "User not created"] , 200);
        }
    }


    public function login_opt(Request $request) {

        $validator = Validator::make($request->all(), [
                   'phone'  => 'required | min:9 | max:13'
        ]);
        if ($validator->fails()) {
            $errorArray = $validator->errors()->all();
            return response()->json(['data' =>(Object) $errorArray,'status'=>0,'message' => "Please enter valid data."] , 200);
        }
        try {
            $phone = request('phone');
            if($phone){
                $is_exist = User::where('phone', $phone)->first();

                if($is_exist){
                    if($is_exist->activate==1)
                    {
                          $rolearray = $is_exist->roles->toArray();
                          $rolear = [];
                          foreach ($rolearray as $key => $value) {
                              $rolear[] = $value['display_name'];
                          }
                          $arrayrole =  implode(",",$rolear);
                          $data = [];
                          $data['is_exist'] = "1";
                          $data['role'] = $arrayrole;
                          $data['otp'] = rand(1000,9999);

                          $userTokens = $is_exist->tokens;
                          foreach($userTokens as $token) {
                              $token->delete();
                          }

                          $data['token'] = $is_exist->createToken('MyApp')->accessToken;
                          $user_update = User::whereId($is_exist->id)->update(['fcm_token'=>request('device_id')]);

                          $otp="Your One Time Password for Society Buddy is: ".$data['otp'];
                          
                          Otp::send_otp($phone,$otp);

                          return response()->json(['data' => $data,'status'=>1,'message' => "Successfully get user.",'isapporve'=>1] , 200);
                    }
                    else
                    {
                          $error=[];
                          return response()->json(['data' => (Object) $error,'status'=>0,'message' => "Your account is not approved yet.",'isapporve'=>0] , 200);
                    }
                   
                }else{
                    $data = [];
                    $data['is_exist'] = "0";
                    $data['role'] = "Member";
                    $data['otp'] = rand(1000,9999);

                    $otp="Your One Time Password Of Society Buddy:".$data['otp'];
                    Otp::send_otp($phone,$otp);

                    $data['token'] = "";

                    return response()->json(['data' => $data,'status'=>1, 'message' => "Successfully get user."] , 200);
                }
            }

        } catch (Exception $e) {

        }
    }

    public function me(){
        $user = auth()->user();

        if ($user) {
            $rolearray =  auth()->user()->roles;
            $rolear = [];
            $memberlist=[];
            $buildingidarray=[];
            $flatarray=[];

            foreach ($rolearray as $key => $value) {
                $rolear[] = $value['display_name'];
            }
            $arrayrole =  implode(",",$rolear);
            $user->role = $arrayrole;
            unset($user->roles);
            unset($user->roles);
            unset($user->roles);
            $society_logo=Society::where('id',$user->society_id)->first();


            $flatType=$user->member->flatType;
            $gender=$user->member->gender;
            $profession=$user->member->profession;
            $profession_detail=$user->member->profession_detail;
            $profession_other=$user->member->profession_other;
            $relation=$user->member->relation;
            $dob=$user->member->dob;
            $bloodgroup=$user->member->bloodgroup;
            $occupancy=$user->member->occupancy;
            $QrCode=$user->member->qrcode;

           $buildingarray=isset($user->member->building->name)?$user->member->building->name:'';
           $buildingidarray=isset($user->member->building->id)?$user->member->building->id:'';
           $flatarray=isset($user->member->flat->name)?$user->member->flat->name:'';
           $user->building=$buildingarray;
           $user->building_id=$buildingidarray;
           $user->flats=$flatarray;
           $user->flatType=$flatType;
           $user->occupancy=$occupancy;
           $user->gender=$gender;
           $user->profession=$profession;
           $user->profession_detail=$profession_detail;
           $user->profession_other=$profession_other;
           $user->relation=$relation;
           $user->dob=$dob;
           $user->bloodgroup=$bloodgroup;
           $user->qrcode=$QrCode;
           $user->society_logo=isset($society_logo->logo)?$society_logo->logo:'';
           
           unset($user->member);

            return response()->json(['data' => $user,'status'=>1,'message' => "User profile detail."] , 200);
        } else {
             $error[] = 'User not found.';
            return response()->json(['data' =>(Object) $error,'status'=>0,'message' => "User not found."] , 200);
        }
    }


    public function addfamilymember(Request $request){
        $validator = Validator::make($request->all(), [
                  'family_member_phone'  => 'required| min:9 | max:13 | unique:users,phone',
                   'family_member_relation'=> 'required',
                   'family_member_name'  => 'required',
                   'family_member_gender'  => 'required',
                   'family_member_dob'  => 'required',
                   'family_member_bloodgroup'  => 'required',
        ]);
        if ($validator->fails()) {
            $errorArray = $validator->errors()->all();
            $message = implode(",",$errorArray);
           return response()->json(['data' => [],'status'=>0,'message' => $message] , 200);
        } else {
          $loggedInUser = auth()->user();
          $user = new User();
          $user->name = request('family_member_name');
          $user->society_id = $loggedInUser->society_id;
          $user->phone = request('family_member_phone');
          $user->password = Hash::make('user@123');
          if ($request->file('family_member_photo')) {
              $image = $request->family_member_photo;
              $path = $image->store('user');
          }
          $user->image = isset($path) ? $path : "";
          $user->activate=1;
          $user->save();
          $user->attachRole(9);

          $member = new Member();
          $member->user_id = $user->id;
          $member->society_id = $loggedInUser->member->society_id;
          $member->building_id = $loggedInUser->member->building_id;
          $member->flat_id = $loggedInUser->member->flat_id;
          $member->family_user_id = $loggedInUser->id; //User family
          $member->gender = request('family_member_gender');
          $member->dob = request('family_member_dob');
          $member->bloodgroup = request('family_member_bloodgroup');
          $member->relation = request('family_member_relation');

          $flatname=Flat::select('name')->where('id',$loggedInUser->member->flat_id)->first();
          $buildingname=Building::select('name')->where('id',$loggedInUser->member->building_id)->first();

          $orcode='Name: '.request('family_member_name').PHP_EOL.'Flat No: '.$buildingname->name.'-'.$flatname->name.PHP_EOL.'Phone: '.request('family_member_phone'); 
          $codeimage=QrCode::format('png')->size(300)->generate($orcode); 
          $output_file =   time() . '.png';
          $dd=Storage::disk('local')->put($output_file, $codeimage);
          $member->qrcode=$output_file;    

          $member->save();

          $visitor=new Settings();
          $visitor->user_id=$user->id;
          $visitor->receiver_id=$user->id;
          $visitor->save();

          return response()->json(['data' => [],'status'=>1,'message' => "Successfully added family member."] , 200);
        }
    }

    public function getFamilyMember(Request $request){

        $user = Member::with('user')->where('user_id', auth()->user()->id)->first();

        if($user->relation=='self' || $user->relation==null)
        {
              $users = Member::with('user')->where('family_user_id', auth()->user()->id)->get();
              $response = [];

              foreach ($users as $u) {
                      $response[] = [
                        "id" => $u->user->id,
                        "name" => $u->user->name,
                        "phone" => $u->user->phone,
                        "image" => $u->user->image,
                        "gender" => $u->gender,
                        "profession" => $u->profession,
                        "relation" => $u->relation,
                        "dob" => $u->dob,
                        "bloodgroup" => $u->bloodgroup
                      ];
              }
        }
        else
        {
              $users = Member::with('user')->where('family_user_id', $user->family_user_id)->where('user_id','!=',auth()->user()->id)->orWhere('user_id',$user->family_user_id)->get();

              $response = [];

              foreach ($users as $u) {
                      $response[] = [
                        "id" => $u->user->id,
                        "name" => $u->user->name,
                        "phone" => $u->user->phone,
                        "image" => $u->user->image,
                        "gender" => $u->gender,
                        "profession" => $u->profession,
                        "relation" => $u->relation,
                        "dob" => $u->dob,
                        "bloodgroup" => $u->bloodgroup
                      ];
              }
        }

        return response()->json(['data' => $response,'status'=>1,'message' => "Successfully Get family member."] , 200);
    }


    public function updatefamilymember(Request $request, $family_member_id){
      $family_member = User::find($family_member_id);
      if(!$family_member){
        return response()->json(['data' => [],'status'=> 0,'message' => "Family Member not found"] , 200);
        exit;
      }
      $validator = Validator::make($request->all(), [
                'family_member_phone'  => 'required| min:9 | max:13 | unique:users,phone,'.$family_member_id,
                 'family_member_relation'=> 'required',
                 'family_member_name'  => 'required',
                 'family_member_gender'  => 'required',
                 'family_member_dob'  => 'required',
                 'family_member_bloodgroup'  => 'required',
      ]);
      if ($validator->fails()) {
          $errorArray = $validator->errors()->all();
          $message = implode(",",$errorArray);
         return response()->json(['data' => [],'status'=>0,'message' => $message] , 200);
      } else {
        if ($request->file('family_member_photo')) {
            $image = $request->family_member_photo;
            $path = $image->store('user');
            $family_member->image = $path;
        }
        $family_member->name = request('family_member_name');
        $family_member->phone = request('family_member_phone');
        $family_member->save();
        $member = Member::where('user_id',$family_member_id)->first();
        if($member){
          $member->dob = request('family_member_dob');
          $member->gender = request('family_member_gender');
          $member->bloodgroup = request('family_member_bloodgroup');
          $member->relation = request('family_member_relation');
          $flatname=Flat::select('name')->where('id',$member->flat_id)->first();
          $buildingname=Building::select('name')->where('id',$member->building_id)->first();
          $orcode='Name: '.request('family_member_name').PHP_EOL.'Flat No: '.$buildingname->name.'-'.$flatname->name.PHP_EOL.'Phone: '.request('family_member_phone'); 
          $codeimage=QrCode::format('png')->size(300)->generate($orcode); 
          $output_file =   time() . '.png';
          $dd=Storage::disk('local')->put($output_file, $codeimage);
          $member->qrcode=$output_file;   
          $member->save();
        }
        return response()->json(['data' => [],'status'=> 1, 'message' => "Family Member updated"] , 200);
      }
    }

    public function GuestList(Request $request)
    {
        $yesterday = date("Y-m-d",strtotime( '-1 days' ));

        $today=date("Y-m-d");

        $user_id=Auth::user()->id;
        $newresult=[];
        $newresult2=[];
        $member=Member::where('user_id',$user_id)->first();

        $flat_id=isset($member->flat_id)?$member->flat_id:'';

        if($member->family_user_id ==0)
        {
            $GuestList= DB::table('visitor')
                ->select('visitor.id','visitor.name','visitor.photos','flats.name as flatname','buildings.name as buildingname','visitor.flag','visitor.created_at')
                ->join('flats','flats.id','=','visitor.flat_id')
                ->join('buildings','buildings.id','=','visitor.building_id')
                ->where('visitor.flat_id',$flat_id)
                ->where('visitor.user_id',$user_id)
                ->where('visitor.soft_delete',0)
                ->orderby('visitor.id','desc')
                ->get();
        }
        else
        {
              $GuestList= DB::table('visitor')
                ->select('visitor.id','visitor.name','visitor.photos','flats.name as flatname','buildings.name as buildingname','visitor.flag','visitor.created_at')
                ->join('flats','flats.id','=','visitor.flat_id')
                ->join('buildings','buildings.id','=','visitor.building_id')
                ->where('visitor.flat_id',$flat_id)
                ->where('visitor.soft_delete',0)
                ->where('visitor.user_id',$member->family_user_id)
                ->orderby('visitor.id','desc')
                ->get();
        }

        

        $data = [];
        $p = 0;
        
        $result1=[];
        $result2=[];
        $count=0;
        $count2=0;

        for($i=0;$i<count($GuestList);$i++)
        {
            
            $visitor= DB::table('inoutlists')
                        ->select('inoutlists.request_id','inoutlists.guard_id','inoutlists.intime as Intime','inoutlists.outtime as Outtime','inoutlists.flag as inOutFlag','inoutlists.created_at as created_at')
                        ->where('inoutlists.request_id',$GuestList[$i]->id)
                        ->where('inoutlists.type',2)
                        ->where('inoutlists.soft_delete',0)
                        ->get();
                        

                      if($visitor->isNotEmpty())
                       {
                          foreach ($visitor as $value) {
                                $result1['id']=  $GuestList[$i]->id ;         
                                $result1['name']=$GuestList[$i]->name;
                                $result1['photos']=$GuestList[$i]->photos;
                                $result1['code']='';
                                $result1['guard_id']=$value->guard_id;
                                $result1['flatname']=$GuestList[$i]->flatname;
                                $result1['buildingname']=$GuestList[$i]->buildingname;
                                $result1['flag']=$GuestList[$i]->flag;
                                $result1['create_at']=$GuestList[$i]->created_at; 
                                $result1['intime']=isset($value->Intime)?$value->Intime:'';
                                $result1['Outtime']=isset($value->Outtime)?$value->Outtime:'';
                                $result1['inOutFlag']=isset($value->inOutFlag)?$value->inOutFlag:'';
                                $result1['type']='2'; 
                                $newresult[$count] = $result1;
                                $count++;
                          }
                       } 
                       else
                       {

                                $result1['id']=  $GuestList[$i]->id ;         
                                $result1['name']=$GuestList[$i]->name;
                                $result1['photos']=$GuestList[$i]->photos;
                                $result1['code']='';
                                $result1['guard_id']=(int)'';
                                $result1['flatname']=$GuestList[$i]->flatname;
                                $result1['buildingname']=$GuestList[$i]->buildingname;
                                $result1['flag']=$GuestList[$i]->flag;
                                $result1['create_at']=$GuestList[$i]->created_at; 
                                $result1['intime']='';
                                $result1['Outtime']='';
                                $result1['inOutFlag']=(int)'';    
                                $result1['type']='2'; 
                                $newresult[$count] = $result1;
                                $count++;
                       }
        }

        $date=date("Y-m-d");

        $frequentlyVisitor =  DB::table('inviteguest')
                    ->select('inviteguest.id','inviteguest.contact_name','inviteguest.code','inviteguest.user_id','inviteguest.created_at')
                    ->where('inviteguest.user_id',$user_id)    
                    ->where('inviteguest.soft_delete',0)    
                    ->get(); 
       

        for($i=0;$i<count($frequentlyVisitor);$i++)
        {
            $frequentlyvisitor= DB::table('inoutlists')
                        ->select('inoutlists.intime as Intime','inoutlists.guard_id','inoutlists.outtime as Outtime','inoutlists.flag as inOutFlag')
                        ->where('inoutlists.request_id',$frequentlyVisitor[$i]->id)
                        ->where('inoutlists.type',1)
                        ->where('inoutlists.soft_delete',0)                        
                        ->get();

            $flats= DB::table('members')
                        ->select('flats.name as flatname','buildings.name as buildingname')
                        ->where('members.user_id',$frequentlyVisitor[$i]->user_id)
                        ->join('flats','flats.id','=','members.flat_id')
                        ->join('buildings','buildings.id','=','members.building_id')
                        ->first();

                        if($frequentlyvisitor->isNotEmpty())
                       {

                          foreach ($frequentlyvisitor as $value) {

                                $result2['id']=  $frequentlyVisitor[$i]->id ;         
                                $result2['name']=$frequentlyVisitor[$i]->contact_name;
                                $result2['photos']='';
                                $result2['code']=$frequentlyVisitor[$i]->code;
                                $result2['guard_id']=isset($value->guard_id)?$value->guard_id:(int)'';
                                $result2['flatname']=isset($flats->flatname)?$flats->flatname:'';
                                $result2['buildingname']=isset($flats->buildingname)?$flats->buildingname:'';
                                $result2['flag']=(int)'';
                                $result2['create_at']=$frequentlyVisitor[$i]->created_at; 
                                $result2['intime']=isset($value->Intime)?$value->Intime:'';
                                $result2['Outtime']=isset($value->Outtime)?$value->Outtime:'';
                                $result2['inOutFlag']=isset($value->inOutFlag)?$value->inOutFlag:'';    
                                $result2['type']='1'; 
                        
                            $newresult2[$count2] = $result2;
                            $count2++;
                            
                          }

                       } 
                       else
                       {

                                $result2['id']=  $frequentlyVisitor[$i]->id ;         
                                $result2['name']=$frequentlyVisitor[$i]->contact_name;
                                $result2['photos']='';
                                $result2['code']=$frequentlyVisitor[$i]->code;
                                $result2['guard_id']=(int)'';
                                $result2['flatname']=isset($flats->flatname)?$flats->flatname:'';
                                $result2['buildingname']=isset($flats->buildingname)?$flats->buildingname:'';
                                $result2['flag']=(int)'';
                                $result2['create_at']=$frequentlyVisitor[$i]->created_at; 
                                $result2['intime']='';
                                $result2['Outtime']='';
                                $result2['inOutFlag']=(int)'';    
                                $result2['type']='1'; 
                          
                            $newresult2[$count2] = $result2;
                            $count2++;
                            
                       }                        
        }

        $result = array_merge($newresult, $newresult2);
        array_multisort($result,SORT_DESC);

        return response()->json(['data' => $result,'status'=>1,'message' => "Successfully GuestList."] , 200);
    }

    public function logout(Request $request)
    {
        $user_id=request('user_id');

        $user=User::whereId($user_id)->update(['fcm_token'=>'']);

        return response()->json(['data' => '[]','status'=>1,'message' => "Successfully logout."] , 200);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
                //'email' => 'required',
        ]);

        if ($validator->fails()) {
            $errorArray = $validator->errors()->all();
           return response()->json(['data' =>(Object) $errorArray,'status'=>0,'message' => "Please enter valid data."] , 200);
        }
        else
        {
            $file = $request->file('profile');

            if ($file)
            {
                    $path = $file->store('user_profile');
                    $user->image = isset($path) ? $path : null;
            }

             if (request('name')) {
                    $user->name = request('name');
            }

            if (request('email')) {
                    $user->email = request('email');
            }

            if (request('phone')) {
                    $user->phone = request('phone');
            }

            // if (request('roles')) {
            //     $str_arr = preg_split ("/\,/", request('roles'));
            //     $user->roles()->sync($str_arr); // ex. ['9','5']
            // }

            $member=Member::where('user_id',$user->id)->first();

            if (request('profession')) {
                    $member->profession = request('profession');
            }

            if(request('profession_other'))
            {
                    $member->profession_other = request('profession_other');
            }

            if (request('profession_detail')) {
                    $member->profession_detail = request('profession_detail');
            }

            if (request('bloodgroup')) {
                    $member->bloodgroup = request('bloodgroup');
            }

            if (request('flattype')) {
                    $member->flatType = request('flattype');
            }

            if (request('occupancy')) {
                    $member->occupancy = request('occupancy');
            }

            $user->save();

            $member->save();

            return response()->json(['data' => '[]','status'=>1,'message' => "Profile update successfully."] , 200);
        }
    }

    public function MemberList(Request $request)
      {
        $user_id=auth()->user()->id;

        $society_id = request('society_id');

        $building_id=request('building_id');

        if($building_id=='0')
        {
            $member=Member::where('society_id',$society_id)->with('user','flat','building','vehicle')->where('user_id','!=',$user_id)->with(['user'])->whereHas('user', function($q){
              $q->where('activate', 1);
            })->get();
        }
        else
        {
            $member=Member::where('relation','=','self')->where('society_id',$society_id)->where('building_id',$building_id)->with('user','flat','building','vehicle')->where('user_id','!=',$user_id)->with(['user'])->whereHas('user', function($q){
              $q->where('activate', 1);
            })->get();
        }

        

        $response = [];

        foreach ($member as $u) {
          $Settings=Settings::where('user_id',$u->user_id)->first();
          $familyMember=$this->getfamilyMemberList($u->user_id);
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
            "name" => isset($u->user)?$u->user->name:'',
            "phone" => isset($u->user)?$u->user->phone:'',
            "email" => isset($u->user)?$u->user->email:'',
            "image" => isset($u->user)?$u->user->image:'',
            "flatname" => isset($u->flat)?$u->flat->name:'',
            "buildingname" => isset($u->building)?$u->building->name:'',
            "role"=>isset($u->user->roles->first()->name)?$u->user->roles->first()->name:'',
            "profession" => $u->profession,
            "relation" => $u->relation,
            "dob" => $u->dob,
            "bloodgroup" => $u->bloodgroup,
            "vehicles"=>isset($u->vehicle)?$u->vehicle:(Object)[],
            "created_at"=>isset($u->user)?$u->user->created_at->toDateString():'',
            "updated_at"=>isset($u->user)?$u->user->updated_at->toDateString():'',
            "contact_status"=>isset($Settings->contact_details)?$Settings->contact_details:0,
            "member_status"=>isset($Settings->family_details)?$Settings->family_details:0,
          ];
        }
        return response()->json(['data' => $response,'status'=>1,'message' => "Successfully Member list."] , 200);
      }

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

      public function domestichelpers(Request $request)
      {
          $society_id = request('society_id');

          $member =  DB::table('domestic_helpers')
                    ->select('domestic_helpers.*','servicetypes.name as typename')
                    ->join('servicetypes','servicetypes.id','=','domestic_helpers.type_id')
                    ->where('domestic_helpers.status',1)
                    ->where('domestic_helpers.society_id',$society_id)
                    ->get(); 

          $response = [];
          $p = 0;
          foreach ($member as $u) {

            // $products = DB::table('reveiws')
            //      ->select('id',DB::raw('AVG(ratings) as ratings'))
            //      ->where('reveiws.helper_id',$u->id)
            //      ->groupBy('id')
            //      ->get();
            //      dd($products);
                 $avg_stars = DB::table('reveiws')
                 ->where('reveiws.helper_id',$u->id)
                ->avg('ratings');
                

                $response[$p]['id']=$u->id;
                $response[$p]['name']=$u->name;
                $response[$p]['pin']=$u->pin;
                $response[$p]['mobile']=$u->mobile;
                $response[$p]['photos']=$u->photos;
                $response[$p]['Member_id']=$u->member_id;
                $response[$p]['gender']=$u->gender;
                $response[$p]['created_at']=$u->created_at;
                $response[$p]['typename']=$u->typename;
                $response[$p]['average_rating']=isset($avg_stars)?$avg_stars:(int)"";
            $p++;

          }

          return response()->json(['data' => $response,'status'=>1,'message' => "Successfully Get Helpers."] , 200);
      }

      public function mydomestichelperslist(Request $request)
      {
          $user_id=auth()->user()->id;

          $Member=Member::where('user_id',auth()->user()->id)->first();

          if($Member)
          {
              if($Member->family_user_id !='0')
              {
                  $helperslist =  DB::table('domestic_helpers')
                    ->select('domestic_helpers.*','servicetypes.name as typename')
                    ->join('servicetypes','servicetypes.id','=','domestic_helpers.type_id')
                    ->whereRaw('find_in_set("'.$Member->family_user_id.'",member_id)')
                    ->where('domestic_helpers.status',1)
                    ->orderBy('domestic_helpers.id','desc')
                    ->get(); 
              }
              else
              {
                $helperslist =  DB::table('domestic_helpers')
                    ->select('domestic_helpers.*','servicetypes.name as typename')
                    ->join('servicetypes','servicetypes.id','=','domestic_helpers.type_id')
                    ->whereRaw('find_in_set("'.$user_id.'",member_id)')
                    ->where('domestic_helpers.status',1)
                    ->orderBy('domestic_helpers.id','desc')
                    ->get(); 
              }
              
          }
          else
          {
              $helperslist =  DB::table('domestic_helpers')
                    ->select('domestic_helpers.*','servicetypes.name as typename')
                    ->join('servicetypes','servicetypes.id','=','domestic_helpers.type_id')
                    ->whereRaw('find_in_set("'.$user_id.'",member_id)')
                    ->where('domestic_helpers.status',1)
                    ->orderBy('domestic_helpers.id','desc')
                    ->get(); 
          }

          $response = [];
          $p = 0;


          foreach ($helperslist as $u) {

                $avg_stars = DB::table('reveiws')
                    ->where('reveiws.helper_id',$u->id)
                    ->avg('ratings');
                

                $response[$p]['id']=$u->id;
                $response[$p]['name']=$u->name;
                $response[$p]['pin']=$u->pin;
                $response[$p]['mobile']=$u->mobile;
                $response[$p]['photos']=$u->photos;
                $response[$p]['Member_id']=$u->member_id;
                $response[$p]['gender']=$u->gender;
                $response[$p]['created_at']=$u->created_at;
                $response[$p]['typename']=$u->typename;
                $response[$p]['average_rating']=isset($avg_stars)?$avg_stars:(int)"";

                $p++;

          }

          return response()->json(['data' => $response,'status'=>1,'message' => "Successfully Get Helpers."] , 200);
      }

      public function detailsofdomestichelpers(Request $request)
      {
          $id = request('id');

          $member =  DB::table('domestic_helpers')
                    ->select('domestic_helpers.*','servicetypes.name as typename',DB::raw('AVG(ratings) as ratings'))
                    ->join('servicetypes','servicetypes.id','=','domestic_helpers.type_id')
                    ->join('reveiws','reveiws.helper_id','=','domestic_helpers.id')
                    ->where('domestic_helpers.id',$id)
                    ->first();
                    
          $reveiws =  DB::table('reveiws')
                    ->select('reveiws.id','reveiws.ratings','reveiws.comment','users.name','reveiws.user_id')
                    ->join('users','users.id','=','reveiws.user_id')
                    ->where('reveiws.helper_id',$id)
                    ->get();

          $reveiwsdata=[];
          foreach ($reveiws as $value) {
            $reveiwsdata[]=array(
              'id'=>$value->id,
              'ratings'=>$value->ratings,
              'comment'=>$value->comment,  
              'username'=>$value->name,
              'user_id'=>$value->user_id,
            );  
          }
          $building_id=$member->member_id; 
          $str_arr = preg_split ("/\,/", $building_id);

          $username=[];
          $user_id=request('user_id');
          
          foreach ($str_arr as $value) {
              $event=   DB::table('users')->where('id',$value)->orderBy('id','desc')->first();

              $members=Member::where('user_id',$value)->with('flat','building','user')->first();
              $familyMember=$this->getfamilyMemberList($value);
              if (in_array($user_id, $familyMember))
              {
                  $workWithLoggedInUser='true';
              }

              if(isset($members))
              {
                  if($user_id==$members->user_id  )
                  {

                      $username[]=array(
                        'name'=> isset($members->user->name)?$members->user->name:'',
                        'buildingname'=>isset($members->building->name)?$members->building->name:'',
                        'flatname'=>isset($members->flat->name)?$members->flat->name:'',
                        //'workWithLoggedInUser'=>'true'
                      );

                      $workWithLoggedInUser='true';
                  }
                  else
                  {
                      $username[]=array(
                        'name'=> isset($members->user->name)?$members->user->name:'',
                        'buildingname'=>isset($members->building->name)?$members->building->name:'',
                        'flatname'=>isset($members->flat->name)?$members->flat->name:'',
                       // 'workWithLoggedInUser'=>'false'
                      );
                     
                  }
              }

          }  

          $response = [];

          $response = [
            'id'=>$member->id,
            'society_id'=>$member->society_id,
            'name'=>$member->name,
            'pin'=>$member->pin,
            'mobile'=>$member->mobile,
            'document'=>$member->document,
            'photos'=>$member->photos,
            'gender'=>$member->gender,
            'typename'=>$member->typename,
            'join_date'=>date('d-m-Y',strtotime($member->created_at)),
            'ratings'=>$member->ratings,
            'work_with_data'=>$username,  
            'reveiws'=>$reveiwsdata,
            'workWithLoggedInUser'=>isset($workWithLoggedInUser)?$workWithLoggedInUser:'false'
          ];

          return response()->json(['data' => $response,'status'=>1,'message' => "Successfully Get Helpers."] , 200);   
      }

      public function addReview(Request $request)
      {
            $user_id=auth()->user()->id;

            $helper_id=request('helper_id');

            $reviews=new Reviews();
            $reviews->user_id=$user_id;
            $reviews->helper_id=$helper_id;
            $reviews->ratings=request('ratings');
            $reviews->comment=request('comment');
            $reviews->save();

            return response()->json(['data' => $reviews,'status'=>1,'message' => "Successfully added review."] , 200);
      }

      public function deletereview(Request $request)
      {
          $user_id=auth()->user()->id;

          $helper_id=request('id');

          $Reviews=Reviews::where('id',$helper_id)->where('user_id',$user_id)->delete();

          if($Reviews)
          {
                return response()->json(['data' => "1",'status'=>1,'message' => "Reviews Deleted SuccessFully."] , 200);
          }
          else
          {
                return response()->json(['data' => "0",'status'=>0,'message' => "Reviews Deleted Failed."] , 200);
          }
      }



      public function getreview(Request $request)
      {
          $helper_id=request('helper_id');

          $Reviews=Reviews::where('helper_id',$helper_id)->get();

           return response()->json(['data' => $Reviews,'status'=>1,'message' => "Reviews Deleted SuccessFully."] , 200);
      }

      public function NotificationList(Request $request)
      {
          $user_id=auth()->user()->id;  

          $eventnotification =  DB::table('notifications')
                    ->select('notifications.text','notifications.id','notifications.type','notifications.isread')
                    ->whereRaw('find_in_set("'.$user_id.'",user_id)')
                   // ->where('type',1)
                    //->where('isread',0)
                    ->get(); 

           return response()->json(['data' => $eventnotification,'status'=>1,'message' => "Reviews Deleted SuccessFully."] , 200); 

      }

      public function DeleteFamilyMember(Request $request)
      {
          $user_id=auth()->user()->id;  

          $id=request('id');

          if($id)
          {

            $users_id=Member::where('user_id',$id)->first();
            
            $Settings=Settings::where('user_id',$users_id->family_user_id)->first();
            
            $pieces = explode(",", isset($Settings->receiver_id)?$Settings->receiver_id:''); 
            
            if (in_array($id, $pieces))
            {
                
                unset($pieces[array_search($id,$pieces)]);
                $pieces = implode(",", $pieces); 
                $Settings=Settings::where('user_id',$users_id->family_user_id)->update(['receiver_id'=>$pieces]);
               
            }
            $users=User::where('id',$id)->delete();
            $members=Member::where('user_id',$id)->delete();  


            return response()->json(['data' => (Object)[],'status'=>1,'message' => "FamilyMember Deleted SuccessFully."] , 200); 

          }
          else
          {
              return response()->json(['data' => (Object)[],'status'=>0,'message' => "FamilyMember Deleted SuccessFully."] , 200); 
          }
          
      }

    public function notificationDemo(Request $request)
    {
            $request=request('fcm_token');

            $newtoken= $request;
            
            $pmsg = array(
                    'body' => 'Security alert',
                    'title' => 'Demo',
                    'icon' => 'myicon',
                    'sound' => 'audio.mp3'
            );

            $data=array(
                'notification_type'=>'security',
            );


            PushNotificationDemo::SendPushNotification($pmsg, $data,[$newtoken]);
    }
      

}
