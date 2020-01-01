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
use App\Categories;
use App\Products;
use App\ProductsImages;
use App\Polls;
use Validator;
use App\Helpers\Notification\FamilyMemberList;
use Carbon\Carbon;
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

    public function getCategories(Request $request)
    {

        $cat=Categories::all();

        return response()->json(['data' =>$cat,'status'=>1,'message' => "Categories Get Successfully"] , 200);

    }

    public function AddProduct(Request $request)
    {
            $validator = Validator::make($request->all(),[
                   'title'  => 'required',
                   'price'  => 'required',
                   'description' => 'required',
            ]);

            if ($validator->fails()) {
                $errorMessage = implode(',', $validator->errors()->all());
                return response()->json(['data' =>(Object)[],'status'=>0,'message' => $errorMessage] , 200);
            }else
            {
                $user_id=auth()->user()->id;
                $pro=new Products;
                $pro->user_id=$user_id;
                $pro->society_id=request('society_id');
                $pro->category_id=request('category_id');
                $pro->title=request('title');
                $pro->price=request('price');
                $pro->description=request('description');
                $pro->quality=request('quality');
                $pro->flag=2;
                $pro->save();

                if(request('product_photos'))
                {
                    $file=request('product_photos');
                    foreach ($file as $value) {
                        $path = $value->store('product_photos');
                        $proim=new ProductsImages;
                        $proim->product_id=$pro->id;
                        $proim->image=$path;
                        $proim->save();
                    }
                }
                $pro->productsimages;
                return response()->json(['data' =>$pro,'status'=>1,'message' => "Successfully Added Product."] , 200);
            }
    }

    public function getProduct(Request $request)
    {
        $user_id=auth()->user()->id;

        $familyMember=FamilyMemberList::getfamilyMemberList($user_id);
        
        $type=request('type');

        if($type==1)//Buy
        {
                $category_id=request('category_id');

                if($category_id==0)
                {
                    $pro=Products::whereNotIn('user_id',$familyMember)->where('society_id',request('society_id'))->with('user','categories','productsimages')->get();

                }
                else
                {   
                    $pro=Products::whereNotIn('user_id',$familyMember)->where('society_id',request('society_id'))->where('category_id',$category_id)->with('user','categories','productsimages')->get();
                }
                

                $response = [];

                foreach ($pro as $u) {
                        $buildingname=isset($u->user->member->building->name)?$u->user->member->building->name:'';
                        $flatname=isset($u->user->member->flat->name)?$u->user->member->flat->name:'';
                        $response[] = [
                            "id" => $u->id,
                            "user_id"=>$u->user_id,
                            "category_id"=>$u->category_id,
                            "society_id"=>$u->society_id,
                            "title"=>$u->title,
                            "price"=>$u->price,
                            "quality"=>$u->quality,
                            "description"=>$u->description,
                            "flag"=>$u->flag,
                            "username"=>isset($u->user->name)?$u->user->name:'',
                            "buildingname"=>$buildingname.'-'.$flatname,
                            "phone"=>isset($u->user->phone)?$u->user->phone:'',
                            "image"=>isset($u->user->image)?$u->user->image:'',
                            "categoryname"=>isset($u->categories->name)?$u->categories->name:'',
                            "productsimages"=>isset($u->productsimages)?$u->productsimages:''
                        ];
                }
                return response()->json(['data' =>$response,'status'=>1,'message' => "Successfully Get Product."] , 200);
        }

        if($type==2)//Sell
        {
                $category_id=request('category_id');

                if($category_id==0)
                {
                    $pro=Products::whereIn('user_id',$familyMember)->where('society_id',request('society_id'))->with('user','categories','productsimages')->get();
                }
                else
                {
                    $pro=Products::whereIn('user_id',$familyMember)->where('society_id',request('society_id'))->where('category_id',$category_id)->with('user','categories','productsimages')->get();
                }
                

                $response = [];

                foreach ($pro as $u) {
                        $buildingname=isset($u->user->member->building->name)?$u->user->member->building->name:'';
                        $flatname=isset($u->user->member->flat->name)?$u->user->member->flat->name:'';
                        $response[] = [
                            "id" => $u->id,
                            "user_id"=>$u->user_id,
                            "category_id"=>$u->category_id,
                            "society_id"=>$u->society_id,
                            "title"=>$u->title,
                            "price"=>$u->price,
                            "quality"=>$u->quality,
                            "description"=>$u->description,
                            "flag"=>$u->flag,
                            "username"=>$u->user->name,
                            "buildingname"=>$buildingname.'-'.$flatname,
                            "phone"=>$u->user->phone,
                            "image"=>$u->user->image,
                            "categoryname"=>$u->categories->name,
                            "productsimages"=>$u->productsimages
                        ];
                }
                return response()->json(['data' =>$response,'status'=>1,'message' => "Successfully Get Product."] , 200);
        }
        
    }

    public function editProducts(Request $request)
    {
         $validator = Validator::make($request->all(),[
                   'title'  => 'required',
                   'price'  => 'required',
                   'description' => 'required',
            ]);

            if ($validator->fails()) {
                $errorMessage = implode(',', $validator->errors()->all());
                return response()->json(['data' =>(Object)[],'status'=>0,'message' => $errorMessage] , 200);
            }else
            {
                $user_id=auth()->user()->id;

                $id=request('product_id');

                $pro=Products::find($id);
                $pro->user_id=$user_id;
                $pro->society_id=request('society_id');
                $pro->category_id=request('category_id');
                $pro->title=request('title');
                $pro->price=request('price');
                $pro->description=request('description');
                $pro->quality=request('quality');
                $pro->flag=2;
                $pro->save();

                if(request('product_photos'))
                {
                    $file=request('product_photos');
                    foreach ($file as $value) {
                        $path = $value->store('product_photos');
                        $proim=new ProductsImages;
                        $proim->product_id=$pro->id;
                        $proim->image=$path;
                        $proim->save();
                    }
                }
                $pro->productsimages;
                return response()->json(['data' =>$pro,'status'=>1,'message' => "Successfully Added Product."] , 200);
            }
    }

    public function deleteProducts(Request $request)
    {
        $id=request('id');

        $products=Products::where('id',$id)->delete();

        $productsimages=ProductsImages::where('product_id',$id)->delete();

        return response()->json(['data' =>[],'status'=>1,'message' => "Successfully Deleted Product."] , 200);
    }

    public function deleteProductsImages(Request $request)
    {
        $id=request('id');

        $products=ProductsImages::where('id',$id)->delete();

        return response()->json(['data' =>[],'status'=>1,'message' => "Successfully Deleted Productimages."] , 200);
    }

    public function RelatedProduct(Request $request)
    {
        $category_id=request('category_id');

        $product_id=request('product_id');
        
        $user_id=auth()->user()->id;

        $familyMember=FamilyMemberList::getfamilyMemberList($user_id);

        $products=Products::whereNotIn('user_id',$familyMember)->where('society_id',request('society_id'))->where('id','!=',$product_id)->where('category_id',$category_id)->with('user','categories','productsimages')->get();

        $response = [];

                foreach ($products as $u) {
                        $buildingname=isset($u->user->member->building->name)?$u->user->member->building->name:'';
                        $flatname=isset($u->user->member->flat->name)?$u->user->member->flat->name:'';
                        $response[] = [
                            "id" => $u->id,
                            "user_id"=>$u->user_id,
                            "category_id"=>$u->category_id,
                            "title"=>$u->title,
                            "price"=>$u->price,
                            "quality"=>$u->quality,
                            "description"=>$u->description,
                            "flag"=>$u->flag,
                            "username"=>$u->user->name,
                            "buildingname"=>$buildingname.'-'.$flatname,
                            "phone"=>$u->user->phone,
                            "image"=>$u->user->image,
                            "categoryname"=>$u->categories->name,
                            "productsimages"=>$u->productsimages
                        ];
                }

        return response()->json(['data' =>$response,'status'=>1,'message' => "Successfully Get Related Product."] , 200);
    }

    public function pollslist(Request $request)
    {

        $user_id=auth()->user()->society_id;           

        $polls=Polls::where('expires_on','>=',Carbon::now())->where('society_id',$user_id)->where('active',1)->get();

        $response = [];

              foreach ($polls as $u) {
               
                if($u->a1_userid !=null)
                {
                    $result1 = count(explode(',',$u->a1_userid));    
                }
                else
                {
                    $result1 = 0;
                }
                if($u->a2_userid !=null)
                {
                    $result2 = count(explode(',',$u->a2_userid));    
                }
                else
                {
                    $result2 = 0;
                }
                if($u->a3_userid !=null)
                {
                    $result3 = count(explode(',',$u->a3_userid));    
                }else
                {
                    $result3 = 0;
                }
                if($u->a4_userid !=null)
                {
                    $result4 = count(explode(',',$u->a4_userid));    
                }else
                {
                    $result4 = 0;
                }
                
                $totalcount=$result1+$result2+$result3+$result4;
                if($result1 >0)
                {
                    $per=(100 * $result1) / $totalcount;    
                }
                else
                {
                    $per=(int)'';
                }
                if($result2 >0)
                {
                    $per2=(100 * $result2) / $totalcount;    
                }
                else
                {
                    $per2=(int)'';
                }
                if($result3 >0)
                {
                    $per3=(100 * $result3) / $totalcount;    
                }
                else
                {
                    $per3=(int)'';
                }

                 if($result4 >0)
                {
                    $per4=(100 * $result4) / $totalcount;    
                }
                else
                {
                    $per4=(int)'';
                }
                
                
                      $response[] = [
                        "id" => $u->id,
                        "society_id" => $u->society_id,
                        "question" => $u->question,
                        "a1" => $u->a1,
                        "a2" => $u->a2,
                        "a3" => $u->a3,
                        "a4" => $u->a4,
                        "a1_userid" => $u->a1_userid,
                        "a2_userid" => $u->a2_userid,
                        "a3_userid" => $u->a3_userid,
                        "a4_userid" => $u->a4_userid,
                        "expires_on" => $u->expires_on,
                        "active" => $u->active,
                        "created_at" => $u->created_at->toDateTimeString(),
                        "updated_at" => $u->updated_at->toDateTimeString(),
                        "percentage1"=>floor($per),
                        "percentage2" => floor($per2),
                        "percentage3" => floor($per3),
                        "percentage4" => floor($per4)
                      ];
              }

        return response()->json(['data' =>$response,'status'=>1,'message' => "Successfully Get Polls."] , 200);
    }

    public function pollsanswer(Request $request)
    {
        $user_id=auth()->user()->id;

        $id=request('id'); //Id

        $options=request('options'); // 1-Option 2-Option 3-Option 4-Option

        $type=request('type'); // 1-select 2-deselect

        if($type==1)
        {
            if($options==1){
                $polls=Polls::where('id',$id)->first();
                
                if($polls->a1_userid == null)
                {
                    $parts = explode(',', $user_id);
                    $roll=implode(',', $parts);
                }
                else
                {
                    $parts = explode(',', $polls->a1_userid);
                    if (in_array($user_id, $parts))
                    {
                        $roll=implode(',', $parts);    
                    }
                    else
                    {
                        $parts[]=$user_id;
                        $roll=implode(',', $parts);    
                    }
                    
                }
                Polls::where('id',$id)->update(['a1_userid'=>$roll]);

                $polls=Polls::where('id',$id)->first();

                if($polls->a1_userid !=null)
                {
                    $result1 = count(explode(',',$polls->a1_userid));    
                }
                else
                {
                    $result1 =0;
                }
                if($polls->a2_userid !=null)
                {
                    $result2 = count(explode(',',$polls->a2_userid));    
                }
                else
                {
                    $result2 =0;
                }
                if($polls->a3_userid !=null)
                {
                    $result3 = count(explode(',',$polls->a3_userid));    
                }else
                {
                    $result3 =0;
                }
                if($polls->a4_userid !=null)
                {
                    $result4 = count(explode(',',$polls->a4_userid));    
                }else
                {
                    $result4 =0;
                }
                
                $totalcount=$result1+$result2+$result3+$result4;
                if($result1 >0)
                {
                    $per=(100 * $result1) / $totalcount;    
                }
                else
                {
                    $per=(int)'';
                }
                if($result2 >0)
                {
                    $per2=(100 * $result2) / $totalcount;    
                }
                else
                {
                    $per2=(int)'';
                }
                if($result3 >0)
                {
                    $per3=(100 * $result3) / $totalcount;    
                }
                else
                {
                    $per3=(int)'';
                }

                 if($result4 >0)
                {
                    $per4=(100 * $result4) / $totalcount;    
                }
                else
                {
                    $per4=(int)'';
                }
                $polls->percentage1=floor($per);
                $polls->percentage2=floor($per2);
                $polls->percentage3=floor($per3);
                $polls->percentage4=floor($per4);
            }

            if($options==2){
                $polls=Polls::where('id',$id)->first();
                if($polls->a2_userid == null)
                {
                    $parts = explode(',', $user_id);
                    $roll=implode(',', $parts);
                }
                else
                {
                    $parts = explode(',', $polls->a2_userid);
                    if (in_array($user_id, $parts))
                    {
                        $roll=implode(',', $parts);    
                    }
                    else
                    {
                        $parts[]=$user_id;
                        $roll=implode(',', $parts);    
                    }
                    
                }
                Polls::where('id',$id)->update(['a2_userid'=>$roll]);
                $polls=Polls::where('id',$id)->first();
                if($polls->a1_userid !=null)
                {
                    $result1 = count(explode(',',$polls->a1_userid));    
                }
                else
                {
                    $result1 =0;
                }
                if($polls->a2_userid !=null)
                {
                    $result2 = count(explode(',',$polls->a2_userid));    
                }
                else
                {
                    $result2 =0;
                }
                if($polls->a3_userid !=null)
                {
                    $result3 = count(explode(',',$polls->a3_userid));    
                }else
                {
                    $result3 =0;
                }
                if($polls->a4_userid !=null)
                {
                    $result4 = count(explode(',',$polls->a4_userid));    
                }else
                {
                    $result4 =0;
                }
                
                $totalcount=$result1+$result2+$result3+$result4;
               if($result1 >0)
                {
                    $per=(100 * $result1) / $totalcount;    
                }
                else
                {
                    $per=(int)'';
                }
                if($result2 >0)
                {
                    $per2=(100 * $result2) / $totalcount;    
                }
                else
                {
                    $per2=(int)'';
                }
                if($result3 >0)
                {
                    $per3=(100 * $result3) / $totalcount;    
                }
                else
                {
                    $per3=(int)'';
                }

                 if($result4 >0)
                {
                    $per4=(100 * $result4) / $totalcount;    
                }
                else
                {
                    $per4=(int)'';
                }
                $polls->percentage1=floor($per);
                $polls->percentage2=floor($per2);
                $polls->percentage3=floor($per3);
                $polls->percentage4=floor($per4);
            }

            if($options==3){
                $polls=Polls::where('id',$id)->first();
                if($polls->a3_userid == null)
                {
                    $parts = explode(',', $user_id);
                    $roll=implode(',', $parts);
                }
                else
                {
                    $parts = explode(',', $polls->a3_userid);
                    if (in_array($user_id, $parts))
                    {
                        $roll=implode(',', $parts);    
                    }
                    else
                    {
                        $parts[]=$user_id;
                        $roll=implode(',', $parts);    
                    }
                }
                Polls::where('id',$id)->update(['a3_userid'=>$roll]);
                $polls=Polls::where('id',$id)->first();
               if($polls->a1_userid !=null)
                {
                    $result1 = count(explode(',',$polls->a1_userid));    
                }
                else
                {
                    $result1 =0;
                }
                if($polls->a2_userid !=null)
                {
                    $result2 = count(explode(',',$polls->a2_userid));    
                }
                else
                {
                    $result2 =0;
                }
                if($polls->a3_userid !=null)
                {
                    $result3 = count(explode(',',$polls->a3_userid));    
                }else
                {
                    $result3 =0;
                }
                if($polls->a4_userid !=null)
                {
                    $result4 = count(explode(',',$polls->a4_userid));    
                }else
                {
                    $result4 =0;
                }
                
                $totalcount=$result1+$result2+$result3+$result4;
                if($result1 >0)
                {
                    $per=(100 * $result1) / $totalcount;    
                }
                else
                {
                    $per=(int)'';
                }
                if($result2 >0)
                {
                    $per2=(100 * $result2) / $totalcount;    
                }
                else
                {
                    $per2=(int)'';
                }
                if($result3 >0)
                {
                    $per3=(100 * $result3) / $totalcount;    
                }
                else
                {
                    $per3=(int)'';
                }

                 if($result4 >0)
                {
                    $per4=(100 * $result4) / $totalcount;    
                }
                else
                {
                    $per4=(int)'';
                }
                $polls->percentage1=floor($per);
                $polls->percentage2=floor($per2);
                $polls->percentage3=floor($per3);
                $polls->percentage4=floor($per4);
            }

            if($options==4){
                $polls=Polls::where('id',$id)->first();
                if($polls->a4_userid == null)
                {
                    $parts = explode(',', $user_id);
                    $roll=implode(',', $parts);
                }
                else
                {
                    $parts = explode(',', $polls->a4_userid);
                    if (in_array($user_id, $parts))
                    {
                        $roll=implode(',', $parts);    
                    }
                    else
                    {
                        $parts[]=$user_id;
                        $roll=implode(',', $parts);    
                    }
                }
                Polls::where('id',$id)->update(['a4_userid'=>$roll]);
                $polls=Polls::where('id',$id)->first();
                if($polls->a1_userid !=null)
                {
                    $result1 = count(explode(',',$polls->a1_userid));    
                }
                else
                {
                    $result1 =0;
                }
                if($polls->a2_userid !=null)
                {
                    $result2 = count(explode(',',$polls->a2_userid));    
                }
                else
                {
                    $result2 =0;
                }
                if($polls->a3_userid !=null)
                {
                    $result3 = count(explode(',',$polls->a3_userid));    
                }else
                {
                    $result3 =0;
                }
                if($polls->a4_userid !=null)
                {
                    $result4 = count(explode(',',$polls->a4_userid));    
                }else
                {
                    $result4 =0;
                }
                
                $totalcount=$result1+$result2+$result3+$result4;
                if($result1 >0)
                {
                    $per=(100 * $result1) / $totalcount;    
                }
                else
                {
                    $per=(int)'';
                }
                if($result2 >0)
                {
                    $per2=(100 * $result2) / $totalcount;    
                }
                else
                {
                    $per2=(int)'';
                }
                if($result3 >0)
                {
                    $per3=(100 * $result3) / $totalcount;    
                }
                else
                {
                    $per3=(int)'';
                }

                 if($result4 >0)
                {
                    $per4=(100 * $result4) / $totalcount;    
                }
                else
                {
                    $per4=(int)'';
                }
                $polls->percentage1=floor($per);
                $polls->percentage2=floor($per2);
                $polls->percentage3=floor($per3);
                $polls->percentage4=floor($per4);
            }
        }

        if($type==2)
        {
            if($options==1){
                $polls=Polls::where('id',$id)->first();
                
                if($polls->a1_userid != null)
                {
                    $parts = explode(',', $polls->a1_userid);
                    if (in_array($user_id, $parts))
                    {
                        $findSkill = array_search($user_id, $parts);
                        if ($findSkill !== false){

                            unset($parts[$findSkill]);
                        }
                        $skills = implode(',', $parts);   
                    }
                }
                Polls::where('id',$id)->update(['a1_userid'=>$skills]);
                $polls=Polls::where('id',$id)->first();
                if($polls->a1_userid !=null)
                {
                    $result1 = count(explode(',',$polls->a1_userid));    
                }
                else
                {
                    $result1 =0;
                }
                if($polls->a2_userid !=null)
                {
                    $result2 = count(explode(',',$polls->a2_userid));    
                }
                else
                {
                    $result2 =0;
                }
                if($polls->a3_userid !=null)
                {
                    $result3 = count(explode(',',$polls->a3_userid));    
                }else
                {
                    $result3 =0;
                }
                if($polls->a4_userid !=null)
                {
                    $result4 = count(explode(',',$polls->a4_userid));    
                }else
                {
                    $result4 =0;
                }
                
                $totalcount=$result1+$result2+$result3+$result4;
                if($result1 >0)
                {
                    $per=(100 * $result1) / $totalcount;    
                }
                else
                {
                    $per=(int)'';
                }
                if($result2 >0)
                {
                    $per2=(100 * $result2) / $totalcount;    
                }
                else
                {
                    $per2=(int)'';
                }
                if($result3 >0)
                {
                    $per3=(100 * $result3) / $totalcount;    
                }
                else
                {
                    $per3=(int)'';
                }

                 if($result4 >0)
                {
                    $per4=(100 * $result4) / $totalcount;    
                }
                else
                {
                    $per4=(int)'';
                }
                $polls->percentage1=floor($per);
                $polls->percentage2=floor($per2);
                $polls->percentage3=floor($per3);
                $polls->percentage4=floor($per4);

            }

            if($options==2){
                $polls=Polls::where('id',$id)->first();
                
                if($polls->a2_userid != null)
                {
                    $parts = explode(',', $polls->a2_userid);
                    if (in_array($user_id, $parts))
                    {
                        $findSkill = array_search($user_id, $parts);
                        if ($findSkill !== false){

                            unset($parts[$findSkill]);
                        }
                        $skills = implode(',', $parts);   
                    }
                }
                Polls::where('id',$id)->update(['a2_userid'=>$skills]);
                $polls=Polls::where('id',$id)->first();
                if($polls->a1_userid !=null)
                {
                    $result1 = count(explode(',',$polls->a1_userid));    
                }
                else
                {
                    $result1 =0;
                }
                if($polls->a2_userid !=null)
                {
                    $result2 = count(explode(',',$polls->a2_userid));    
                }
                else
                {
                    $result2 =0;
                }
                if($polls->a3_userid !=null)
                {
                    $result3 = count(explode(',',$polls->a3_userid));    
                }else
                {
                    $result3 =0;
                }
                if($polls->a4_userid !=null)
                {
                    $result4 = count(explode(',',$polls->a4_userid));    
                }else
                {
                    $result4 =0;
                }
                
                $totalcount=$result1+$result2+$result3+$result4;
                if($result1 >0)
                {
                    $per=(100 * $result1) / $totalcount;    
                }
                else
                {
                    $per=(int)'';
                }
                if($result2 >0)
                {
                    $per2=(100 * $result2) / $totalcount;    
                }
                else
                {
                    $per2=(int)'';
                }
                if($result3 >0)
                {
                    $per3=(100 * $result3) / $totalcount;    
                }
                else
                {
                    $per3=(int)'';
                }

                 if($result4 >0)
                {
                    $per4=(100 * $result4) / $totalcount;    
                }
                else
                {
                    $per4=(int)'';
                }
                $polls->percentage1=floor($per);
                $polls->percentage2=floor($per2);
                $polls->percentage3=floor($per3);
                $polls->percentage4=floor($per4);
            }

            if($options==3){
                $polls=Polls::where('id',$id)->first();
                
                if($polls->a3_userid != null)
                {
                    $parts = explode(',', $polls->a3_userid);
                    if (in_array($user_id, $parts))
                    {
                        $findSkill = array_search($user_id, $parts);
                        if ($findSkill !== false){

                            unset($parts[$findSkill]);
                        }
                        $skills = implode(',', $parts);   
                    }
                }
                Polls::where('id',$id)->update(['a3_userid'=>$skills]);
                $polls=Polls::where('id',$id)->first();
                if($polls->a1_userid !=null)
                {
                    $result1 = count(explode(',',$polls->a1_userid));    
                }
                else
                {
                    $result1 =0;
                }
                if($polls->a2_userid !=null)
                {
                    $result2 = count(explode(',',$polls->a2_userid));    
                }
                else
                {
                    $result2 =0;
                }
                if($polls->a3_userid !=null)
                {
                    $result3 = count(explode(',',$polls->a3_userid));    
                }else
                {
                    $result3 =0;
                }
                if($polls->a4_userid !=null)
                {
                    $result4 = count(explode(',',$polls->a4_userid));    
                }else
                {
                    $result4 =0;
                }
                
                $totalcount=$result1+$result2+$result3+$result4;
                if($result1 >0)
                {
                    $per=(100 * $result1) / $totalcount;    
                }
                else
                {
                    $per=(int)'';
                }
                if($result2 >0)
                {
                    $per2=(100 * $result2) / $totalcount;    
                }
                else
                {
                    $per2=(int)'';
                }
                if($result3 >0)
                {
                    $per3=(100 * $result3) / $totalcount;    
                }
                else
                {
                    $per3=(int)'';
                }

                 if($result4 >0)
                {
                    $per4=(100 * $result4) / $totalcount;    
                }
                else
                {
                    $per4=(int)'';
                }
                $polls->percentage1=floor($per);
                $polls->percentage2=floor($per2);
                $polls->percentage3=floor($per3);
                $polls->percentage4=floor($per4);
            }

            if($options==4){
                $polls=Polls::where('id',$id)->first();
                
                if($polls->a4_userid != null)
                {
                    $parts = explode(',', $polls->a4_userid);
                    if (in_array($user_id, $parts))
                    {
                        $findSkill = array_search($user_id, $parts);
                        if ($findSkill !== false){

                            unset($parts[$findSkill]);
                        }
                        $skills = implode(',', $parts);   
                    }
                }
                Polls::where('id',$id)->update(['a4_userid'=>$skills]);
                $polls=Polls::where('id',$id)->first();
                if($polls->a1_userid !=null)
                {
                    $result1 = count(explode(',',$polls->a1_userid));    
                }
                else
                {
                    $result1 =0;
                }
                if($polls->a2_userid !=null)
                {
                    $result2 = count(explode(',',$polls->a2_userid));    
                }
                else
                {
                    $result2 =0;
                }
                if($polls->a3_userid !=null)
                {
                    $result3 = count(explode(',',$polls->a3_userid));    
                }else
                {
                    $result3 =0;
                }
                if($polls->a4_userid !=null)
                {
                    $result4 = count(explode(',',$polls->a4_userid));    
                }else
                {
                    $result4 =0;
                }
                
                $totalcount=$result1+$result2+$result3+$result4;
                if($result1 >0)
                {
                    $per=(100 * $result1) / $totalcount;    
                }
                else
                {
                    $per=(int)'';
                }
                if($result2 >0)
                {
                    $per2=(100 * $result2) / $totalcount;    
                }
                else
                {
                    $per2=(int)'';
                }
                if($result3 >0)
                {
                    $per3=(100 * $result3) / $totalcount;    
                }
                else
                {
                    $per3=(int)'';
                }

                 if($result4 >0)
                {
                    $per4=(100 * $result4) / $totalcount;    
                }
                else
                {
                    $per4=(int)'';
                }
                $polls->percentage1=floor($per);
                $polls->percentage2=floor($per2);
                $polls->percentage3=floor($per3);
                $polls->percentage4=floor($per4);
            }
        }
        return response()->json(['data' =>$polls,'status'=>1,'message' => "Successfully Get Polls."] , 200);

    }

}
