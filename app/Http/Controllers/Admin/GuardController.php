<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\City;
use App\Area;
use App\Society;
use App\Building;
use App\Flat;
use App\Guard;
use Illuminate\Support\Facades\Storage;
use Excel;
use App\User;
use App\Member;
use App\Settings;

class GuardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        return view('admin.guard.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $society = Society::all();
        return view('admin.guard.add',['society' => $society]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd($request->all());
      $this->validate($request, [
          'name' => 'required',
          'pin' => 'required',
          'phone' => 'required | numeric',
          'gender' => 'required',
          'society' => 'required'
      ]);

        $user = new Guard;
        $user->name = request('name');
        $user->login_pin = request('pin');
        $user->phone = request('phone');
        $user->gender = request('gender');
        $user->society_id = request('society');

        if ($request->file('profile_pic')) {
            $image = $request->profile_pic;
            $path = $image->store('guards');
        }
        $user->profile_pic = isset($path) ? $path : "";
        $user->save();
        return redirect()->route('admin.guardes.index')->with("success","Guard added successfully.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $guard = Guard::find($id);
        if($guard){
          $this->checkForSocietyAdmin($guard->society_id);
          $society = Society::all();
          return view('admin.guard.edit',["society" => $society,'guard' => $guard]);
      }else{
          return view('admin.errors.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'pin' => 'required',
            'phone' => 'required | numeric',
            'gender' => 'required',
            'society' => 'required'
        ]);
        $guard = Guard::find($id);
        if($guard){
          if(!auth()->user()->hasRole('society_admin')){
            $guard->society_id = request('society');
          }
          $guard->name = request('name');
          $guard->login_pin = request('pin');
          $guard->phone = request('phone');
          $guard->gender = request('gender');
          if ($request->file('profile_pic')) {
            $image = $request->profile_pic;
            $path = $image->store('guards');
          }
          $guard->profile_pic = isset($path) ? $path : request('profile_hidden');
          $guard->save();
        }
        return redirect()->route('admin.guardes.index')->with('success','Guard updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $guard = Guard::find($id);
        if($guard){
          $guard->delete();
        }
        return redirect()->route('admin.guardes.index')->with('success','Guard deleted successfully.');

    }

    public function Array(Request $request)
        {
            $response = [];
            if(auth()->user()->hasRole('society_admin')){
              $guardes = Guard::where('society_id',auth()->user()->society_id)->get();
            }else{
              $guardes = Guard::all();
            }
            // echo url('storage/images/');
            foreach ($guardes as $g) {
                $sub = [];
                $id = $g->id;
                if($g->profile_pic)
                { 
                  $img = env('APP_URL_STORAGE').$g->profile_pic;
                } else {
                  $img = asset('no-image.png');
                }
                $sub[] = $id;
                $sub[] = "<a class='example-image-link' href='".$img."' data-lightbox='example-1'><img width='50' class='example-image' src='".$img."' alt='image-1' /></a>";
                $sub[] = $g->name;
                if(!auth()->user()->hasRole('society_admin')){
                $sub[] = isset($g->guards->name)?$g->guards->name:'';
                }
                $sub[] = $g->phone;
                $sub[] = $g->login_pin;
                $sub[] = $g->gender;
                $sub[] = date('d-m-Y',strtotime($g->created_at->toDateTimeString()));
                $delete_url = route('admin.guardes.delete', [$id]);
                $action = '<div class="btn-part"><a class="edit" href="' . route('admin.guardes.edit', $id) . '"><i class="fa fa-pencil-square-o"></i></a>' . ' ';
                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.route('admin.guardes.delete',$id).'"><i class="fa fa-trash"></i>&nbsp;</a></div>';
                $sub[] = $action;
                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }

        public function checkForSocietyAdmin($society_id)
        {
          //If user has role society_admin then make sure he/she can only access their society
          if(auth()->user()->hasRole('society_admin')){
            if(auth()->user()->society_id != $society_id){
              abort(403, 'Unauthorized action.');
            }
          }
        }

        public function import(){
          return view('admin.guard.import');
        }

        public function importdata(Request $request){
          $this->validate($request, [
            'file_import' => 'required',
            'society_id' => 'required | numeric'
          ]);
          try {
            $path = "";
            $data = "";
            $path = $request->file('file_import')->getRealPath();
            // $data3 = Excel::load($path)->get();
            $data = Excel::load($path, function($reader) {})->get();
              // dd($data3);
            $err[] = '';
            //count record 43
            if($data->count()){
                foreach ($data as $key => $value) {
                    
                    $keyid = $key + 2;
                    // dd($data);
                    if(empty($value->phone)){
                      $err[] = $value->name . " mobile number is empty.";
                    }
                    if(strlen($value->phone) < '8' && strlen($value->phone) > '13'){
                      $err[] = $value->name . " mobile number is to small or long.";
                    }
                    $usermobile = User::where('phone',$value->phone)->count();
                    if($usermobile > 0){
                      $err[] = $value->name . " mobile number is already exists.";
                    } 
                    $building = Building::where('name', $value->building)->where('society_id',$request->society_id)->first();
                    
                    if($building){
                      $building_id = $building->id;

                    }else{
                      $err[] = $value->name . " Building not exists.";
                    }
                    $flat = Flat::where('name',(int) $value->flat_no)->where('building_id',isset($building_id)?$building_id:'')->first();
                    
                    if($flat){
                      $flat_id = $flat->id;
                    }else{
                      $err[] = $value->name . " flat not exists.";
                    }
                   
                    $arr[] = ['name' =>$value->name, 'phone' =>(int) $value->phone , 'building' =>$building_id ,'flat' =>$flat_id, 'gender' => $value->gender,'relation'=>$value->relation,'flattype'=>$value->flattype];
                     
                }
                
                if(count($err) > 1){
                  // dd("cccccc");
                  return redirect()->back()->withInput($request->all())->withErrors($err);
                }else{
                  // dd("Asdsadsadasd");
                  // dd($arr);
                  
                  if(!empty($arr)){
                        $key = 0;
                      foreach ($arr as $key => $dv) {
                        //$building = Building::where('name', $dv['building'])->first();
                       // $flat = Flat::where('name', $dv['flat'])->first();
                        if(!empty($dv['flat']) && !empty($dv['building'])){
                          if($dv['gender'] == 'Male' || $dv['gender'] == 'male'){
                            $gender = 'M';
                          }else{
                            $gender = 'F';
                          }
                          $user = new User();
                          $user->name =  $dv['name'];
                          $user->phone =  $dv['phone'];
                          $user->society_id =  isset($request->society_id) ? $request->society_id : 1;
                          $user->password =  Hash::make('123456');
                          $user->save();
                          $insertedId = $user->id;
                          $member = new Member;
                          $member->user_id = $insertedId;
                          $member->society_id =  isset($request->society_id) ? $request->society_id : 1;
                          // $member->flat_id =  isset($flat['0']->id) ? $flat['0']->id : 1;
                          // $member->building_id =  isset($building['0']->id) ? $building['0']->id : 1;
                          $member->flat_id =  $dv['flat'];
                          $member->building_id =  $dv['building'];
                          $member->gender =  $gender;
                          $member->family_user_id =  0;
                          $member->relation = $dv['relation'];
                          $member->flatType = $dv['flattype'];
                          $member->save();
                          $settings=new Settings();
                          $settings->user_id=$insertedId;
                          $settings->save();
                           dd($$settings);
                        }
                      }
                  }
                }
            }
          return redirect()->route('admin.societies.members.index', ['id' => $request->society_id])->with('success','Member insert successfully.');
          } catch (Exception $e) {
            
          }

        }

}
