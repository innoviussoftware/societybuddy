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
use App\Helpers\Notification\FamilyMember;
use Carbon;

class ActivityController extends Controller
{

	public function GuestList(Request $request)
    {
        $yesterday = date("Y-m-d",strtotime( '-1 days' ));

        $today=date("Y-m-d");

        $type=request('type');

        $past=date("Y-m-d", strtotime('-16 days'));


        $date = \Carbon\Carbon::today()->subDays(15);

        if($type==1)
        {
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
		                ->where(function($query) use ($today,$yesterday) {
                				$query->whereDate('visitor.created_at',$today)
                					  ->orwhereDate('visitor.created_at',$yesterday);
            			})
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
          				->where(function($query) use ($today,$yesterday) {
                			$query->whereDate('visitor.created_at',$today)
                				   ->orwhereDate('visitor.created_at',$yesterday);
            			})
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
		                    ->where('inviteguest.soft_delete',0) 
          					->where(function($query) use ($today,$yesterday) {
                				$query->whereDate('inviteguest.created_at',$today)
                				   ->orwhereDate('inviteguest.created_at',$yesterday);
            				})
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
		        krsort($result);
		        array_multisort($result,SORT_DESC);
        }
        if($type==0)
        {
        		$user_id=Auth::user()->id;
        		$Date = date('Y-m-d');
        		$fiftyday = date('Y-m-d', strtotime($Date. ' - 15 day'));
        		$oneDate = date('Y-m-d', strtotime($Date. ' - 2 day'));
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
		                ->whereBetween(DB::raw('DATE(visitor.created_at)'), array($fiftyday, $oneDate))
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
		                ->whereBetween(DB::raw('DATE(visitor.created_at)'), array($fiftyday, $oneDate))
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
		                  	->whereBetween(DB::raw('DATE(inviteguest.created_at)'), array($fiftyday, $oneDate))
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
		        krsort($result);
		        array_multisort($result,SORT_DESC);
        }
        

        return response()->json(['data' => $result,'status'=>1,'message' => "Successfully GuestList."] , 200);
    }

}