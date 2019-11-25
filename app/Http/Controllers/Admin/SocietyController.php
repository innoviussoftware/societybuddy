<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\City;
use App\User;
use App\Area;
use App\Society;
use App\Flat;
use App\Building;
use App\Member;
use App\Vehicle;
use App\Notifications\Activation;
use Mail;
use App\Helpdesk;
use App\Inouts;
use App\InviteGuest;
use App\Visitor;
use App\Guard;
use App\Settings;
use App\DomesticHelpers;
use App\Notification;
use App\Referral;
use App\Helpers\Notification\Otp;
use App\Helpers\Notification\FamilyMember;
class SocietyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function viewnotification($society_id,$id) {
        $society = Society::find($society_id);
        
        $booking = Notification::find($id);
        $booking->isread = 1;
        $booking->save();
        
        return view('admin.societies.members.index',["society" => $society]);
    }

    public function viewreferralnotification($id)
    {
        
        $booking = Referral::find($id);
        $booking->isread = 1;
        $booking->save();
        
        return view('admin.referral.index');
    }

    public function index(){
        return view('admin.societies.index');
    }

    public function indexAdminUsers($id){
        $society = Society::find($id);
        if($society){
          return view('admin.societies.adminusers.index',["society" => $society]);
        }else{
          return view('admin.errors.404');
        }
    }
    public function indexMembers($id){
        $society = Society::find($id);
        if($society){
          return view('admin.societies.members.index',["society" => $society]);
        }else{
          return view('admin.errors.404');
        }
    }
    public function indexMembersVehicles($society_id,$member_id){
        $society = Society::find($society_id);
        $member = Member::where("society_id", $society_id)->where("id",$member_id)->first();
        if($society && $member){
          return view('admin.societies.members.vehicles.index',["society" => $society, "member" => $member]);
        }else{
          return view('admin.errors.404');
        }
    }

     public function indexMembersFamilymembers($society_id,$member_id){
        $society = Society::find($society_id);
        $member = Member::where("society_id", $society_id)->where("id",$member_id)->first();
        if($society && $member){
          return view('admin.societies.members.familymember.index',["society" => $society, "member" => $member]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function indexCommitees($id){
        $society = Society::find($id);

        $chairman = User::whereHas('roles', function($q){
            $q->where('name', 'chairman');
        })->where("society_id",$society->id)->first();

        $secretory = User::whereHas('roles', function($q){
            $q->where('name', 'secretory');
        })->where("society_id",$society->id)->first();

        $jt_secretory = User::whereHas('roles', function($q){
          $q->where('name', 'jt_secretory');
        })->where("society_id",$society->id)->first();

        $treasurer = User::whereHas('roles', function($q){
            $q->where('name', 'treasurer');
        })->where("society_id",$society->id)->first();

        if($society){
          return view('admin.societies.commitees.index',["society" => $society,'chairman'=>$chairman,'secretory'=>$secretory,'jt_secretory'=>$jt_secretory,'treasurer'=>$treasurer]);
        }else{
          return view('admin.errors.404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(){
        $cities = City::all();
        if(old('city')){
          $areas = Area::where('city_id', old('city'))->get();
        }else{
          $areas = [];
        }
        return view('admin.societies.add',['cities' => $cities, 'areas' => $areas]);
    }

    public function addBuildings($id){
        $society = Society::find($id);
        if($society){
          return view('admin.societies.buildings.add',["society" => $society]);
        }else{
          return view('admin.errors.404');
        }
    }
    public function addAdminUsers($id){
        $society = Society::find($id);
        if($society){
          return view('admin.societies.adminusers.add',["society" => $society]);
        }else{
          return view('admin.errors.404');
        }
    }
    public function addMembers($id){
        $society = Society::find($id);
        $roles = Role::memberRoles();
        if($society){
          $buildings = Building::where('society_id',$id)->get();
          return view('admin.societies.members.add',["society" => $society, 'buildings' => $buildings, 'roles' => $roles]);
        }else{
          return view('admin.errors.404');
        }
    }
    public function addMembersVehicles($society_id, $member_id){
        $society = Society::find($society_id);
        $member = Member::where('id',$member_id)->where('society_id',$society_id)->first();
        if($society && $member){
          return view('admin.societies.members.vehicles.add',["society" => $society, 'member' => $member]);
        }else{
          return view('admin.errors.404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
      $this->validate($request, [
          'name' => 'required',
          'area' => 'required',
          'address' => 'required',
          'email' => 'required|email|unique:societies',
          'contact' => 'required|numeric|unique:societies,contact',
          'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
      ]);

        $city = new Society;
        $city->name = request('name');
        $city->area_id = request('area');
        $city->address = request('address');
        $city->email = request('email');
        $city->contact = request('contact');

        if ($request->file('document')) {
            $image = $request->document;
            $path = $image->store('document');
        }
        $city->document = isset($path) ? $path : "";
        if ($request->file('logo')) {
            $imageLogo = $request->logo;
            $logo = $imageLogo->store('society_logo');
        }
        $city->logo = isset($logo) ? $logo : "";;
        
        $city->save();
        return redirect()->route('admin.societies.buildings.add',$city->id)->with("success","Society added successfully.");
    }

    public function storeBuildings(Request $request, $society_id){
        $this->validate($request, [
            'name' => 'required',
            'flats' => 'required'
        ]);
        $city = new Building();
        $city->name = request('name');
        $city->society_id = $society_id;
        $city->save();
        $flats = request('flats');
        foreach ($flats as  $f) {
          Flat::create(array('name' => $f, "building_id" => $city->id));
        }
        return redirect()->route('admin.societies.buildings.add',$society_id)->with("success","Society Building added successfully.");
    }
    public function storeAdminUsers(Request $request, $society_id)    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric',
            'password' => 'required|confirmed|min:6'
        ]);
        $city = new User();
        $city->name = request('name');
        $city->society_id = $society_id;
        $city->name = request('name');
        $city->email = request('email');
        $city->phone = request('phone');
        $city->password = Hash::make(request('password'));
        if ($request->file('image')) {
            $image = $request->image;
            $path = $image->store('user');
        }
        $city->image = isset($path) ? $path : "";
        $city->save();
        // role attach society admin which has 8 id
        $city->attachRole(8); // parameter can be an Role object, array, or id
        return redirect()->route('admin.societies.adminusers.index',$society_id)->with("success","Society Admin Users added successfully.");
    }

    public function storeMembers(Request $request, $society_id)    {
        $this->validate($request, [
            'building_id' => 'required',
            'flat_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:9 | max:13 | unique:users,phone',
            'roles' => 'required',
        ]);
        $city = new User();
        $city->name = request('name');
        $city->society_id = $society_id;
        $city->email = request('email');
        $city->phone = request('phone');
        $city->password = Hash::make('123456');
        if ($request->file('image')) {
            $image = $request->image;
            $path = $image->store('user');
        }
        $city->image = isset($path) ? $path : "";
        $city->save();
        // role attach society admin which has 8 id
        $roles = request('roles');
        foreach ($roles as $r) {
          $city->attachRole($r);
        }

        $member = new Member;
        $member->user_id = $city->id;
        $member->society_id = $society_id;
        $member->building_id = request('building_id');
        $member->flat_id = request('flat_id');
        $member->gender = request('gender');
        $member->relation = 'self';
        $member->save();
        $visitor=new Settings();
        $visitor->user_id=$city->id;
        $visitor->receiver_id=$city->id;
        $visitor->save();
        return redirect()->route('admin.societies.members.index',$society_id)->with("success","Society Members added successfully.");
    }

    public function storeMembersVehicles(Request $request, $member_id)    {
        $this->validate($request, [
            'type' => 'required',
            'number' => 'required',
        ]);
        $member = Member::find($member_id);
        if(!$member){
          return view('admin.errors.404');
        }
        $city = new Vehicle();
        $city->user_id = $member->user_id;
        $city->type = request('type');
        $city->number = request('number');
        $city->save();

        return redirect()->route('admin.societies.members.vehicles.index',[$member->society_id, $member->id])->with("success","Member's Vehicle added successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function checkForSocietyAdmin($society_id){
      //If user has role society_admin then make sure he/she can only access their society
      if(auth()->user()->hasRole('society_admin')){
        if(auth()->user()->society_id != $society_id){
          abort(403, 'Unauthorized action.');
        }
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->checkForSocietyAdmin($id);
        $society = Society::find($id);
        if($society){
          $cities = City::all();
          $areas = Area::where('city_id',$society->area->city_id)->get();
          // dd($areas);
          return view('admin.societies.edit',["society" => $society,'cities' => $cities, 'areas' => $areas]);
        }else{
          return view('admin.errors.404');
        }
    }
    public function editBuildings($society_id,$building_id)
    {
        $this->checkForSocietyAdmin($society_id);

        $s = Society::find($society_id);
        $b = Building::find($building_id);
        if($b && $s){
          return view('admin.societies.buildings.edit',["society" => $s,"building" => $b]);
        }else{
          return view('admin.errors.404');
        }
    }
    public function editAdminUsers($society_id,$user_id){
      $this->checkForSocietyAdmin($society_id);

        $s = Society::find($society_id);
        $b = User::find($user_id);
        if($b && $s){
          return view('admin.societies.adminusers.edit',["society" => $s,"user" => $b]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function editMembers($society_id,$member_id){
      $this->checkForSocietyAdmin($society_id);

        $s = Society::find($society_id);
        $b = Member::find($member_id);
        if($b && $s){
          $buildings = Building::where("society_id",$society_id)->get();
          $flats = Flat::where("building_id",$b->building_id)->get();
          $roles = Role::memberRoles();
          $userroles = $b->user->roles->pluck('id')->toArray();
          return view('admin.societies.members.edit',["society" => $s,"member" => $b, 'buildings'=> $buildings, 'roles' => $roles, 'userroles' => $userroles, 'flats' => $flats]);
        }else{
          return view('admin.errors.404');
        }
    }
    public function editMembersVehicles($vehicle_id){
        $v = Vehicle::find($vehicle_id);
        if($v){
          $member = Member::where('user_id',$v->user_id)->first();
          $society = Society::find($member->society_id);
          return view('admin.societies.members.vehicles.edit',["vehicle" => $v,'member' => $member, 'society' => $society]);
        }else{
          return view('admin.errors.404');
        }
    }
    public function editCommitees($society_id){
      $this->checkForSocietyAdmin($society_id);
      $s = Society::find($society_id);
      if($s){

        $chairman = User::whereHas('roles', function($q){
            $q->where('name', 'chairman');
        })->where("society_id",$society_id)->first();


        $secretory = User::whereHas('roles', function($q){
            $q->where('name', 'secretory');
        })->where("society_id",$society_id)->first();


        $jt_secretory = User::whereHas('roles', function($q){
          $q->where('name', 'jt_secretory');
        })->where("society_id",$society_id)->first();

        $treasurer = User::whereHas('roles', function($q){
            $q->where('name', 'treasurer');
        })->where("society_id",$society_id)->first();

        $commitees = User::whereHas('roles', function($q){
          $q->where('name', 'committee_member');
        })->whereHas('member', function($q){
          $q->where('flatType', 'Owner of flat');
        })->where("society_id",$society_id)->pluck('id')->toArray();
        
        $society_committee = [
          'chairman' => $chairman ? $chairman->id : 0,
          'secretory' => $secretory ? $secretory->id : 0,
          'jt_secretory' => $jt_secretory ? $jt_secretory->id : 0,
          'treasurer' => $treasurer ? $treasurer->id : 0,
          'commitees' => $commitees ? $commitees : []
        ];

        $members = User::with(['member'])->whereHas('roles', function($q){
          $q->where('name', 'chairman');
          $q->orWhere('name', 'committee_member');
          $q->orWhere('name', 'secretory');
          $q->orWhere('name', 'jt_secretory');
          $q->orWhere('name', 'treasurer');
          $q->orWhere('name', 'member');
        })->whereHas('member', function($q){
          $q->where('relation', 'self');
        })->whereHas('member', function($q){
          $q->where('flatType', 'Owner of flat');
        })->where("society_id",$society_id)->get();

        return view('admin.societies.commitees.edit', ['society' => $s, 'members' => $members, 'society_committee' => $society_committee]);
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
    public function update(Request $request, $id){
        //
        $this->validate($request, [
            'name' => 'required',
            'area' => 'required',
            'address' => 'required',
            'email' => 'required',
            'contact' => 'required',
        ]);

        $s = Society::find($id);
        if($s){
          $s->name = request('name');
          $s->area_id = request('area');
          $s->address = request('address');
          $s->email = request('email');
          $s->contact = request('contact');

          if ($request->file('document')) {
              $image = $request->document;
              $path = $image->store('document');
              $s->document = isset($path) ? $path : "";
          }
          if ($request->file('logo')) {
              $imageLogo = $request->logo;
              $logo = $imageLogo->store('society_logo');
              $s->logo = isset($logo) ? $logo : "";
          }

          $s->lat=request('lat');
          $s->lng=request('lng');
          $s->save();
        }
        if(auth()->user()->hasRole('society_admin')){
          return redirect()->route('admin.societies.edit',$id)->with('success','Society updated successfully.');
        }else{
          return redirect()->route('admin.societies.index')->with('success','Society updated successfully.');
        }
    }
    public function updateBuildings(Request $request, $society_id, $building_id){
        $this->validate($request, [
            'name' => 'required',
            'flats' => 'required',
        ]);
        $area = Building::find($building_id);
        if($area){
          $area->name = request('name');
          $area->save();
          $flats = request('flats');
          foreach ($flats as  $f) {
            Flat::firstOrCreate(array('name' => $f, "building_id" => $building_id));
          }
        }
        return redirect()->route('admin.societies.buildings.add', $society_id)->with('success','Building updated successfully.');
    }
    public function updateAdminUsers(Request $request, $society_id, $user_id){
      $this->validate($request, [
          'name' => 'required',
          // 'email' => 'required|email|unique:users',
          // 'password' => 'required'
      ]);
        $user = User::find($user_id);
        if($user){
          $user->name = request('name');
          $user->phone = request('phone');

          // if (request('password')) {
          //   $user->password = Hash::make(request('password'));
          // }
          if ($request->file('image')) {
              $image = $request->image;
              $path = $image->store('user');
          }
          $user->image = isset($path) ? $path : "";
          $user->save();
        }
        return redirect()->route('admin.societies.adminusers.index', $society_id)->with('success','Admin User updated successfully.');
    }
    public function updateMembers(Request $request, $society_id, $member_id){
      $this->validate($request, [
          'building_id' => 'required',
          'flat_id' => 'required',
          'name' => 'required',
          'roles' => 'required',
          'gender' => 'required',
      ]);
        $member = Member::find($member_id);
      if($member){
          $member->building_id = request('building_id');
          $member->flat_id = request('flat_id');
          $member->gender = request('gender');
          $member->occupancy = request('occupy');

          if ($request->file('verification_image')) {

              $image = $request->verification_image;
              $path = $image->store('verification_image');
              $member->idproof = isset($path) ? $path : "";
          }

          $member->policeverify=request('policeverify');
          $member->since=request('since');
          $member->save();
          $user = User::find($member->user_id);
          $user->name = request('name');
          if ($request->file('image')) {
              $image = $request->image;
              $path = $image->store('user');
              $user->image = isset($path) ? $path : "";
          }
          $user->save();
          $user->roles()->sync(request('roles')); // ex. ['9','5']
        }
        return redirect()->route('admin.societies.members.index', $society_id)->with('success','Member updated successfully.');
    }
    public function updateMembersVehicles(Request $request, $vehicle_id){
      $this->validate($request, [
          'type' => 'required',
          'number' => 'required',
      ]);
      $vehicle = Vehicle::find($vehicle_id);
      if($vehicle){
          $member = Member::where('user_id',$vehicle->user_id)->first();
          $vehicle->type = request('type');
          $vehicle->number = request('number');
          $vehicle->save();
        }
      return redirect()->route('admin.societies.members.vehicles.index', [$member->society_id , $member->id])->with('success','Member Vehicles updated successfully.');
    }

    public function updateCommitees(Request $request, $society_id){

      $society = Society::find($society_id);
      if($society){
          $all_commitees = User::whereHas('roles', function($q){
              $q->where('name', 'chairman');
              $q->orWhere('name', 'committee_member');
              $q->orWhere('name', 'secretory');
              $q->orWhere('name', 'jt_secretory');
              $q->orWhere('name', 'treasurer');
          })->where("society_id",$society_id)->get();

          foreach ($all_commitees as $c) {
            $c->roles()->sync([9]); //Make default member. 9 = member
          }

          if(request('chairman')){
            $c = User::find(request('chairman'));
            if($c){
              $c->attachRole(3); //3 = Chairman
            }
          }

          if(request('secretory')){
            $s = User::find(request('secretory'));
            if($s){
              $s->attachRole(5); //5 = secretory
            }
          }

          if(request('jt_secretory')){
            $js = User::find(request('jt_secretory'));
            if($js){
              $js->attachRole(6); //6 = Jt. secretory
            }
          }
          if(request('treasurer')){
            $t = User::find(request('treasurer'));
            if($t){
              $t->attachRole(7); //7 = Treasurer
            }
          }
          if(request('commitees')){
            $cts = User::whereIn('id',request('commitees'))->get();
            foreach ($cts as $u) {
              $u->attachRole(4); //7 = Committee Member
            }
          }

        }
        return redirect()->route('admin.societies.commitees.index', $society_id)->with('success','Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        $city = Society::find($id);
        if($city){
          $city->delete();
        }
        return redirect()->route('admin.societies.index')->with('success','Society deleted successfully.');

    }
    public function deleteBuildings($society_id,$building_id){
        $city = Building::find($building_id);
        if($city){
          $city->delete();
        }
        return redirect()->route('admin.societies.buildings.add',$society_id)->with('success','Building deleted successfully.');

    }
    
    public function deleteAdminUsers($society_id,$member_id)
    {
      $user = User::find($member_id);
      $user->delete();
      return redirect()->route('admin.societies.adminusers.index',$society_id)->with('success','Admin User deleted successfully.');
    }
    public function deleteMembers($society_id,$member_id){
        $member = Member::find($member_id);
        if($member){
          $city = User::find($member->user_id);
          $city->delete();
          $member->delete();
        }
        return redirect()->route('admin.societies.members.index',$society_id)->with('success','Admin Member deleted successfully.');

    }
    public function deleteMembersVehicles($vehicle_id){
        $vehicle = Vehicle::find($vehicle_id);
        if($vehicle){
          $member = Member::where('user_id',$vehicle->user_id)->first();
          $vehicle->delete();
        }
        return redirect()->route('admin.societies.members.vehicles.index',[$member->society_id,$member->id])->with('success','Vehicle deleted successfully.');

    }


        public function Array(Request $request){
            $response = [];
            $sosieties = Society::all();
            foreach ($sosieties as $s) {
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->name;
                $sub[] = $s->email;
                $sub[] = $s->contact;
                $sub[] = $s->area->city->name;
                $sub[] = $s->area->name;
                $sub[] = $s->address;
                // $sub[] = $s->created_at->toDateTimeString();
                $sub[] = date('d-m-Y H:s',strtotime($s->created_at));
                // $sub[] = "<img src='$s->document' width='100'/>";
                $delete_url = route('admin.societies.delete', [$id]);
                $action = '<div class="btn-part"><a class="edit" href="' . route('admin.societies.edit', $id) . '"><i class="fa fa-pencil-square-o"></i></a>' . ' ';
                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.route('admin.societies.delete',$id).'"><i class="fa fa-trash"></i>&nbsp;</a></div>';
                $sub[] = $action;
                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }
        public function ArrayBuildings(Request $request, $society_id){
            $response = [];
            $sosieties = Building::where("society_id",$society_id)->get();
            foreach ($sosieties as $s) {
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->name;
                // $sub[] = "<img src='$s->document' width='100'/>";
                $delete_url = route('admin.societies.buildings.delete', ["society_id" => $society_id, "building_id" => $id]);
                $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.buildings.edit', ["society_id" => $society_id, "building_id" => $id]).'"><i class="fa fa-pencil-square-o"></i></a>' . ' ';
                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.$delete_url.'"><i class="fa fa-trash"></i>&nbsp;</a></div>';
                $sub[] = $action;
                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }
        public function ArrayAdminUsers(Request $request, $society_id){
            $response = [];
            // $sosieties = User::withRole('society_admin')->where("society_id",$society_id)->get();

            $sosieties = User::whereHas('roles', function($q){
                $q->where('name', 'society_admin');
            })->where("society_id",$society_id)->get();
            foreach ($sosieties as $s) {
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->name;
                $sub[] = $s->email;
                // $sub[] = "<img src='$s->document' width='100'/>";
                $delete_url = route('admin.societies.adminusers.delete', ["society_id" => $society_id, "user_id" => $id]);
                $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.adminusers.edit', ["society_id" => $society_id, "user_id" => $id]).'"><i class="fa fa-pencil-square-o"></i></a>' . ' ';
                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.$delete_url.'"><i class="fa fa-trash"></i>&nbsp;</a></div>';
                $sub[] = $action;
                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }
        public function ArrayMembers(Request $request, $society_id){
            $response = [];
            $sosieties = Member::where("society_id",$society_id)->where('relation','=','self')->with('vehicle','user','building','flat')->get();
            

            foreach ($sosieties as $s) {

                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = isset($s->user->name)?$s->user->name:'';
                $sub[] = isset($s->user->email)?$s->user->email:'';
                $sub[] = isset($s->user->phone)?$s->user->phone:'';
                $sub[] = isset($s->building->name)?$s->building->name.'-'.$s->flat->name:'';
                $sub[] = $s->flatType;
                $sub[] = $s->occupancy;
                
                if($s->user->activate==1)
                {
                    $verified_url = route('admin.societies.serviceprovider.changestatus',["society_id" => $society_id, "member_id" => $s->user->id,"status"=>0]);
                    $sub[] = '<a data-toggle="tooltip" title="click here to inactive" style="color:red" onclick="return confirm(`' . $verified_url . '`,`Are you sure you want to inactivate this member ?`)"  href="#"><label class="label label-success">Active</label></a>' . ' ';
                }
                elseif($s->user->activate==0)
                {
                    $verified_url = route('admin.societies.serviceprovider.changestatus',["society_id" => $society_id, "member_id" => $s->user->id,"status"=>1]);
                    
                    $sub[] = '<a data-toggle="tooltip" title="click here to active" style="color:red" onclick="return confirm(`' . $verified_url . '`,`Are you sure you want to activate this member ?`)"  href="#"><label class="label label-danger">In-Active</label></a>' . ' ';
                }
                
                $delete_url = route('admin.societies.members.delete', ["society_id" => $society_id, "member_id" => $id]);
                
                $action = '<div class="btn-part">';

                if (!$s->vehicle->isEmpty())
                {

                    $action .='<a href="'.route("admin.societies.members.vehicles.index",[$society_id, $id]).'"><i class="fa fa-car"></i>&nbsp;&nbsp;</a>';
                }
                
                $action .= '<a class="edit" href="'.route('admin.societies.members.edit', ["society_id" => $society_id, "member_id" => $id]).'"><i class="fa fa-pencil-square-o">&nbsp;</i></a>';
                $action .= '<a class="delete" data-toggle="tooltip" onclick="return confirm (`' . $delete_url . '`,`Are you sure you want to delete this record?`)"><i class="fa fa-trash"></i>&nbsp;&nbsp;</a></div>';

                $sub[] = $action;
                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }
        public function ArrayCommitees(Request $request, $society_id){
            $response = [];
            $sosieties = User::whereHas('roles', function($q){
                $q->where('name', 'committee_member');
                // $q->orWhere('name', 'chairman');
                // $q->orWhere('name', 'secretory');
                // $q->orWhere('name', 'jt_secretory');
                $q->orWhere('name', 'treasurer');
            })->where("society_id",$society_id)->get();

            foreach ($sosieties as $s) {
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->name;
                $sub[] = $s->phone;
                $sub[] = $s->email;
                // $sub[] = $s->member->building->name;
                $sub[] = isset($s->member->flat->name)?$s->member->building->name .'-'.$s->member->flat->name:'';
                // $sub[] = $s->roles->pluck('display_name')->toArray();
                $delete_url = route('admin.societies.members.delete', ["society_id" => $society_id, "member_id" => $id]);
                $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.members.edit', ["society_id" => $society_id, "member_id" => $id]).'"><i class="fa fa-pencil-square-o"></i></a>' . ' ';


                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.$delete_url.'"><i class="fa fa-trash"></i>&nbsp;</a></div>';
                // $sub[] = $action;
                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }
        public function ArrayMembersVehicles(Request $request, $user_id){
            $response = [];
            //$sosieties = Vehicle::where("user_id",$user_id)->with('user')->get();
            $familyMember=FamilyMember::getfamilyMemberList($user_id);
            $sosieties = Vehicle::whereIn('user_id', $familyMember)->orderBy('id','desc')->with('user')->get();
            $user = User::find($user_id);
            foreach ($sosieties as $s) {
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->type;
                $sub[] = $s->number;
                
                $member_name=isset($s->user->name)?$s->user->name:'';
                $building_name=isset($s->user->member->building->name)?$s->user->member->building->name:'';
                $flat_name=isset($s->user->member->flat->name)?$s->user->member->flat->name:'';
                $member=$member_name.'-'.$building_name.'-'.$flat_name;
                
                $delete_url = route('admin.societies.members.vehicles.delete',  $id);
                $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.members.vehicles.edit',  $id).'"><i class="fa fa-pencil-square-o"></i></a>' . ' ';
                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.$delete_url.'"><i class="fa fa-trash"></i>&nbsp;</a>';
                $action .= '<a   href="'.route('qrcode',["number" => $s->number, "member" => $member]).'" target="_blank"><i class="fa fa-qrcode"></i>&nbsp;</a></div>';


                $sub[] = $action;
                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }

        public function ArrayMembersFamilyMembers(Request $request, $user_id){
            $response = [];
            $sosieties = Member::where("family_user_id",$user_id)->with('vehicle')->get();

            foreach ($sosieties as $s) {

                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->user->name;
                $sub[] = $s->user->email;
                $sub[] = $s->user->phone;
                $sub[] = $s->building->name.'-'.$s->flat->name;
                $sub[] = $s->relation;
                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }

        public function flatsByBuilding($building_id){
          $f = Flat::select('id','name')->where('building_id',$building_id)->get();
          return response()->json($f);
        }

        public function sendemail(Request $request)
      {

        $data = $request->all();

        //$check = Contact::insert($data);
       Mail::send('emailTemplate.password', ['user' => $data], function ($m) use($data) {

                 $m->from(env('SUPPORT_EMAIL'), 'SocietyBuddy');
                 $m->to('societybuddy@gmail.com')->subject('Contact Request | SocietyBuddy');
        });

        if (Mail::failures()) {
            $arr = array('msg' => 'Something goes to wrong. Please try again lator', 'status' => false);
        }
        else
        {
          $arr = array('msg' => 'Your message has been successfully sent. We will contact you very soon!', 'status' => true);

        }


        return Response()->json($arr);

      }

      public function changestatus($society_id,$user_id,$status)
      {
            

            $referral = User::where('society_id',$society_id)->where('id',$user_id)->get();

            $update_attributes = array('activate' => $status);

            $user=User::where('society_id',$society_id)->where('id',$user_id)->get();

            $user = User::where('society_id',$society_id)->where('id',$user_id)->update(['activate'=>$status]);

            $user=User::where('society_id',$society_id)->where('id',$user_id)->get();
            
            $phone=isset($user[0]->phone)?$user[0]->phone:'';
            
            if ($status == 1) {
                
                $output = substr($phone, 0, 3);

                if($output=='+91')
                {
                   $nn=str_replace(' ', '', $phone);
                   $otp_new = 'Dear '.ucfirst(isset($user[0]->name)?$user[0]->name:'').','.PHP_EOL.'Your SocietyBuddy account is approved by society admin. Kindly login and enjoy the app now.';
                   Otp::send_otp($nn,$otp_new);
                }
                else
                {

                  $number='+91'.$phone;
                  $nn=str_replace(' ', '', $number);
                  $otp_new = 'Dear '.ucfirst(isset($user[0]->name)?$user[0]->name:'').','.PHP_EOL.'Your SocietyBuddy account is approved by society admin. Kindly login and enjoy the app now.';
                  
                  Otp::send_otp($nn,$otp_new);
                }
                $msg = 'Member is approved.';
            } elseif ($status == 0) {
                $msg = 'Member is not approved.';
            }

            return redirect()->route('admin.societies.members.index',$society_id)->with('success', $msg);
      }


       public function Arrayhelpdesk(Request $request, $society_id){
            $response = [];
            $sosieties = Helpdesk::where("society_id",$society_id)->get();
            foreach ($sosieties as $s) {
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->societyName1;
                $sub[] = $s->societyPhone1;
                $sub[] = isset($s->societyName2)?$s->societyName2:'-';
                $sub[] = isset($s->societyPhone2)?$s->societyPhone2:'-';
                $sub[] = isset($s->fire)?$s->fire:'-';
                $sub[] = isset($s->police)?$s->police:'-';
                $sub[] = isset($s->policenumber)?$s->policenumber:'-';
                $sub[] = isset($s->hostipalName)?$s->hostipalName:'-';
                $sub[] = isset($s->hostipalPhone)?$s->hostipalPhone:'-';
                $sub[] = $s->ambulance;
                $delete_url = route('admin.societies.helpdesk.delete', ["society_id" => $society_id, "user_id" => $id]);
                $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.helpdesk.edit', ["society_id" => $society_id, "user_id" => $id]).'"><i class="fa fa-pencil-square-o"></i></a>' . ' ';
                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.$delete_url.'"><i class="fa fa-trash"></i>&nbsp;</a></div>';
                $sub[] = $action;
                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }

      public function indexhelpdesk($id){
        $society = Society::find($id);
        if($society){
          return view('admin.societies.helpdesk.index',["society" => $society]);
        }else{
          return view('admin.errors.404');
        }
      }

      public function addHelpdesk($id){
          $society = Society::find($id);
          if($society){
            return view('admin.societies.helpdesk.add',["society" => $society]);
          }else{
            return view('admin.errors.404');
          }
      }

      public function storeHelpdesk(Request $request, $society_id)    {
        $this->validate($request, [
            'sname1' => 'required',
            'sno1' => 'required',
            'firenumber' => 'required',
            'ambulanceno' => 'required'
        ]);
        $city = new Helpdesk();
        $city->societyName1 = request('sname1');
        $city->society_id = $society_id;
        $city->societyPhone1 = request('sno1');
        $city->societyName2 = request('sname2');
        $city->societyPhone2 = request('sno2');
        $city->police = request('policename');
          $city->policenumber = request('policenumber');
        $city->fire = request('firenumber');
        $city->hostipalName = request('hostipalname');
        $city->hostipalPhone = request('hostipalno');
        $city->ambulance = request('ambulanceno');
        $city->save();

        return redirect()->route('admin.societies.helpdesk.index',$society_id)->with("success","HelpDesk added successfully.");
    }

    public function editHelpdesk($society_id,$building_id)
    {
        $this->checkForSocietyAdmin($society_id);
        $society = Society::find($society_id);
        $b = Helpdesk::find($building_id);
        if($b && $society){
          return view('admin.societies.helpdesk.edit',['society'=>$society,"building" => $b]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function updateHelpdesk(Request $request, $society_id, $user_id){
        $this->validate($request, [
            'sname1' => 'required',
            'sno1' => 'required',
            'firenumber' => 'required',
            'ambulanceno' => 'required'
        ]);
        $user = Helpdesk::find($user_id);
        if($user){
          
          $user->societyName1 = request('sname1');
          $user->society_id = $society_id;
          $user->societyPhone1 = request('sno1');
          $user->societyName2 = request('sname2');
          $user->societyPhone2 = request('sno2');
          $user->police = request('policename');
          $user->policenumber = request('policenumber');
          $user->fire = request('firenumber');
          $user->hostipalName = request('hostipalname');
          $user->hostipalPhone = request('hostipalno');
          $user->ambulance = request('ambulanceno');
          $user->save();

        }
        return redirect()->route('admin.societies.helpdesk.index', $society_id)->with('success','HelpDesk updated successfully.');
    }

     public function deleteHelpdesk($society_id,$member_id){
        $member = Helpdesk::find($member_id);

        if($member){
          //$city = Helpdesk::find($member->user_id);
          $member->delete();
        }
        return redirect()->route('admin.societies.helpdesk.index',$society_id)->with('success','HelpDesk deleted successfully.');
    }

    public function indexreports($id)
    {
      $society = Society::find($id);
      if($society){
          $buildings = Building::where('society_id',$id)->get();
          $guard=Guard::where('society_id',$id)->get();
          //$flats = Flat::where("building_id",$buildings->building_id)->get();
          return view('admin.societies.reports.index',["society" => $society,'buildings'=>$buildings,'guard'=>$guard]);
      }else{
          return view('admin.errors.404');
      }
    }

    public function arrayReports(Request $request, $society_id)
    {
            $response = [];
            $sosieties = Inouts::where('flag',1)->where("society_id",$society_id)->with('visitorlist','invitelist')->where('type','!=',3)->get();
            
            foreach ($sosieties as $s) {
            
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
              
                if($s->type=='1')
                {
                    $invite = InviteGuest::where('id',$s->request_id)->where("society_id",$society_id)->with('users')->first();

                    $member=Member::where('user_id',isset($invite->user_id)?$invite->user_id:'')->with('flat','building')->first();

                    $guardname=Guard::where('id',$s->guard_id)->first();

                     $sub[]=$guardname['name'];

                    $sub[]=$invite['contact_name'];

                    $sub[]=$member['building']['name'].' - '.$member['flat']['name'];

                    $sub[]=$invite['users']['name'];

                    $sub[]=$s['intime'];

                    $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.reports.out', ["society_id" => $society_id,"type" => $s->type, "request_id" => $id]).'">Out</a>' . '</div> ';

                }

                if($s->type=='2')
                {

                    $visitor=Visitor::where('id',$s->request_id)->where("society_id",$society_id)->with('flats','building')->first();

                    $member=Member::where('flat_id',isset($visitor->flat_id)?$visitor->flat_id:'')->with('user')->first();

                    $guardname=Guard::where('id',$s->guard_id)->first();

                     $sub[]=$guardname['name'];

                    $sub[]=$visitor['name'];

                    $sub[]=$visitor['building']['name'].' - '.$visitor['flats']['name'];

                    $sub[]=$member['user']['name'];

                    $sub[]=$s['intime'];

                    $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.reports.out', ["society_id" => $society_id,"type" => $s->type, "request_id" => $id]).'">Out</a>' . '</div> ';
                }
                 $sub[] = $action;
                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
    }

    public function filterReports(Request $request, $society_id)
    {

        $building_id=request('building_id');
        $flat_id=request('flat_id');
        $guard_id=request('guard_id');

        $startdate=request('startdate');
        $enddate=request('enddate');

        // return view('admin.societies.reports.filter_index',["society" => $society,'buildings'=>$buildings,'guard'=>$guard]);

            $sosieties = Inouts::where('flag',1)->where("society_id",$society_id)->with('visitorlist','invitelist')->get();
            
            foreach ($sosieties as $s) {
            
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
              
                if($s->type=='1')
                {
                    $invite = InviteGuest::where('id',$s->request_id)->where("society_id",$society_id)->with('users')->first();

                    $member=Member::where('user_id',isset($invite->user_id)?$invite->user_id:'')->with('flat','building')->first();

                    $sub[]=$invite['contact_name'];

                    $sub[]=$member['building']['name'].' - '.$member['flat']['name'];

                    $sub[]=$invite['users']['name'];

                    $sub[]=$s['intime'];

                    $sub[]=$s['outtime'];

                }

                if($s->type=='2')
                {

                    $visitor=Visitor::where('id',$s->request_id)->where("society_id",$society_id)->with('flats','building')->first();

                    $member=Member::where('flat_id',isset($visitor->flat_id)?$visitor->flat_id:'')->with('user')->first();

                    $sub[]=$visitor['name'];

                    $sub[]=$visitor['building']['name'].' - '.$visitor['flat']['name'];

                    $sub[]=$member['user']['name'];

                    $sub[]=$s['intime'];

                    $sub[]=$s['outtime'];
                }
                
                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
    }

    public function visitorReports(Request $request,$id)
    {
         $society = Society::find($id);
         if($society){
              $buildings = Building::where('society_id',$id)->get();
              $guard=Guard::where('society_id',$id)->get();
              //$flats = Flat::where("building_id",$buildings->building_id)->get();
              return view('admin.societies.reports.visitorreport',["society" => $society,'buildings'=>$buildings,'guard'=>$guard]);
         }else{
              return view('admin.errors.404');
         }
    }

    public function arrayVisitorReports(Request $request, $society_id)
    {
            $flat_id = $request->get('flat_id');
            $building_id = $request->get('building_id');
            $guard_id = $request->get('guard_id');

            $startdate=$request->get('startdate');
            $enddate=$request->get('endDate');

            $response = [];

            if($guard_id !='' || $building_id !='' && $flat_id !='' && $guard_id !='')
            {
                
                if($building_id !='' && $flat_id !='' && $guard_id !='')
                {
                    $sosieties = Inouts::where("society_id",$society_id)->where('guard_id',$guard_id)->with('visitorlist','invitelist')->where('building_id',$building_id)->where('flat_id',$flat_id)->get();

                }
                else
                {
                    $sosieties = Inouts::where("society_id",$society_id)->where('guard_id',$guard_id)->with('visitorlist','invitelist')->get();
                }
                
                  foreach ($sosieties as $s) {
                  
                      $sub = [];
                      $id = $s->id;
                      $sub[] = $id;
                    
                      if($s->type=='1')
                      {
                          $invite = InviteGuest::where('id',$s->request_id)->where("society_id",$society_id)->with('users')->first();

                          $member=Member::where('user_id',isset($invite->user_id)?$invite->user_id:'')->with('flat','building')->first();

                          $guardname=Guard::where('id',$s->guard_id)->first();

                          $sub[]=$guardname['name'];

                          $sub[]=$invite['contact_name'];

                          $sub[]=$member['building']['name'].' - '.$member['flat']['name'];

                          $sub[]=$invite['users']['name'];

                          $sub[]='<a class="edit" class="btn btn-success"><label class="label label-success">Invited</label></a>';

                          $sub[]=$s['intime'];

                          $sub[]=$s['outtime'];

                      }

                      if($s->type=='2')
                      {

                          $visitor=Visitor::where('id',$s->request_id)->where("society_id",$society_id)->with('flats','building')->first();
                          
                          $member=Member::where('flat_id',isset($visitor->flat_id)?$visitor->flat_id:'')->with('user')->first();

                          $guardname=Guard::where('id',$s->guard_id)->first();

                          $sub[]=$guardname['name'];

                          $sub[]=$visitor['name'];

                          $sub[]=$visitor['building']['name'].' - '.$visitor['flats']['name'];

                          $sub[]=$member['user']['name'];

                          if($visitor['flag']=='1')
                          {
                              $sub[]='<a class="edit" class="btn btn-danger"><label class="label label-success">Apporve</label></a>';

                          }
                          elseif($visitor['flag']=='2')
                          {
                              $sub[]='<a class="edit" class="btn btn-success"><label class="label label-success">Not Apporve</label></a>';
                          }
                          else
                          {
                              $sub[]='<a class="edit" class="btn btn-success"><label class="label label-success">Waiting</label></a>';
                          }

                          $sub[]=$s['intime'];

                          $sub[]=$s['outtime'];
                      }
                      
                      $response[] = $sub;
                    }
              }
            elseif($building_id!='' && $flat_id !='')
            {
                  $start_date=date("Y-m-d",strtotime($request->get('startdate')));
                  $end_date=date("Y-m-d",strtotime($request->get('endDate')));

                  if($building_id !='' && $flat_id !='' && $startdate !='' && $end_date !='')
                  {
                      $society = Inouts::where("society_id",$society_id)->with('visitorlist','invitelist')->where('building_id',$building_id)->where('flat_id',$flat_id)->whereBetween('intime',[$start_date,$end_date])->orWhereBetween('outtime',[$start_date,$end_date])->get();
                  }elseif($building_id!='' && $flat_id !='')
                  {
                    $society = Inouts::where("society_id",$society_id)->where('building_id',$building_id)->where('flat_id',$flat_id)->with('visitorlist','invitelist')->get();
                  }
                  
                  foreach ($society as $s) {
                  
                      $sub = [];
                      $id = $s->id;
                      
                    
                      if($s->type=='1')
                      {

                          $invite = InviteGuest::where('id',$s->request_id)->where("society_id",$society_id)->with('users')->first();

                          $member=Member::where('user_id',isset($invite->user_id)?$invite->user_id:'')->with('flat','building')->first();

                          $guardname=Guard::where('id',$s->guard_id)->first();

                          $sub[] =isset($member)? $id:'';

                          $sub[]=isset($member)?$guardname['name']:'';
                          
                          $sub[]=isset($member)?$invite['contact_name']:'';

                          $sub[]=$member['building']['name'].' - '.$member['flat']['name'];

                          $sub[]=isset($member)?$invite['users']['name']:'';

                          $sub[]=isset($member)?'<a class="edit" class="btn btn-success"><label class="label label-success">Invited</label></a>':'';

                          $sub[]=isset($member)?$s['intime']:'';

                          $sub[]=isset($member)?$s['outtime']:'';

                      }

                      if($s->type=='2')
                      {

                          $visitor=Visitor::where('id',$s->request_id)->where("society_id",$society_id)->with('flats','building')->first();

                          $member=Member::where('flat_id',$visitor->flat_id)->with('user')->first();


                          $guardname=Guard::where('id',$s->guard_id)->first();

                          $sub[] =$id;

                          $sub[]=$guardname['name'];

                          $sub[]=$visitor['name'];

                          $sub[]=$visitor['building']['name'].' - '.$visitor['flats']['name'];

                          $sub[]=$member['user']['name'];

                         // $sub[]=$username['name'];

                          if($visitor['flag']=='1')
                          {
                              $sub[]='<a class="edit" class="btn btn-danger"><label class="label label-success">Apporve</label></a>';

                          }
                          elseif($visitor['flag']=='2')
                          {
                              $sub[]='<a class="edit" class="btn btn-success"><label class="label label-success">Not Apporve</label></a>';
                          }
                          else
                          {
                              $sub[]='<a class="edit" class="btn btn-success"><label class="label label-success">Waiting</label></a>';
                          }

                          $sub[]=$s['intime'];

                          $sub[]=$s['outtime'];
                      }
                      
                      $response[] = $sub;
                    }
            }
            elseif($startdate !='' && $enddate !='')
            {
              
                $start_date=date("Y-m-d",strtotime($request->get('startdate')));
                $end_date=date("Y-m-d",strtotime($request->get('endDate')));

                $sosieties = Inouts::where("society_id",$society_id)->with('visitorlist','invitelist')->where('building_id',$building_id)->where('flat_id',$flat_id)->whereDate('intime',$start_date)->get();
                  
                  foreach ($sosieties as $s) {
                  
                      $sub = [];
                      $id = $s->id;
                      $sub[] = $id;
                    
                      if($s->type=='1')
                      {
                          $invite = InviteGuest::where('id',$s->request_id)->where("society_id",$society_id)->with('users')->first();

                          $member=Member::where('user_id',isset($invite->user_id)?$invite->user_id:'')->with('flat','building')->first();

                          $guardname=Guard::where('id',$s->guard_id)->first();

                          $sub[]=$guardname['name'];

                          $sub[]=$invite['contact_name'];

                          $sub[]=$member['building']['name'].' - '.$member['flat']['name'];

                          $sub[]=$invite['users']['name'];

                          $sub[]='<a class="edit" class="btn btn-success"><label class="label label-success">Invited</label></a>';

                          $sub[]=$s['intime'];

                          $sub[]=$s['outtime'];

                      }

                      if($s->type=='2')
                      {

                          $visitor=Visitor::where('id',$s->request_id)->where("society_id",$society_id)->with('flats','building')->first();
                          

                          $member=Member::where('flat_id',isset($visitor->flat_id)?$visitor->flat_id:'')->with('user')->first();

                          $guardname=Guard::where('id',$s->guard_id)->first();


                          $sub[]=$guardname['name'];

                          $sub[]=$visitor['name'];

                          $sub[]=$visitor['building']['name'].' - '.$visitor['flats']['name'];

                          $sub[]=$member['user']['name'];

                          if($visitor['flag']=='1')
                          {
                              $sub[]='<a class="edit" class="btn btn-danger"><label class="label label-success">Apporve</label></a>';

                          }
                          elseif($visitor['flag']=='2')
                          {
                              $sub[]='<a class="edit" class="btn btn-success"><label class="label label-success">Not Apporve</label></a>';
                          }
                          else
                          {
                              $sub[]='<a class="edit" class="btn btn-success"><label class="label label-success">Waiting</label></a>';
                          }

                          $sub[]=$s['intime'];

                          $sub[]=$s['outtime'];
                      }
                      
                      $response[] = $sub;
                    }
            }
            else
            {
                 $sosieties = Inouts::where("society_id",$society_id)->with('visitorlist','invitelist')->where('type','!=',3)->get();

                  foreach ($sosieties as $s) {
                  
                      $sub = [];
                      $id = $s->id;
                      $sub[] = $id;
                    
                      if($s->type=='1')
                      {
                          $invite = InviteGuest::where('id',$s->request_id)->where("society_id",$society_id)->with('users')->first();

                          $member=Member::where('user_id',isset($invite->user_id)?$invite->user_id:'')->with('flat','building')->first();

                          $guardname=Guard::where('id',$s->guard_id)->first();

                          $sub[]=$guardname['name'];

                          $sub[]=$invite['contact_name'];

                          $sub[]=$member['building']['name'].' - '.$member['flat']['name'];

                          $sub[]=isset($invite['users']['name'])?$invite['users']['name']:'';

                          $sub[]='<a class="edit" class="btn btn-success"><label class="label label-success">Invited</label></a>';

                          $sub[]=$s['intime'];

                          $sub[]=$s['outtime'];

                      }

                      if($s->type=='2')
                      {

                          $visitor=Visitor::where('id',$s->request_id)->where("society_id",$society_id)->with('flats','building')->first();
                          

                          $member=Member::where('user_id',isset($visitor->user_id)?$visitor->user_id:'')->with('user')->first();
                          
                          $guardname=Guard::where('id',$s->guard_id)->first();


                          $sub[]=$guardname['name'];

                          $sub[]=$visitor['name'];

                          $sub[]=$visitor['building']['name'].' - '.$visitor['flats']['name'];

                          $sub[]=isset($member['user']['name'])?$member['user']['name']:'';

                          if($visitor['flag']=='1')
                          {
                              $sub[]='<a class="edit" class="btn btn-danger"><label class="label label-success">Apporve</label></a>';

                          }
                          elseif($visitor['flag']=='2')
                          {
                              $sub[]='<a class="edit" class="btn btn-danger"><label class="label label-success">Not Apporve</label></a>';
                          }
                          else
                          {
                              $sub[]='<a class="edit" class="btn btn-info"><label class="label label-success">Waiting</label></a>';
                          }

                          $sub[]=$s['intime'];

                          $sub[]=$s['outtime'];
                      }
                      
                      $response[] = $sub;
                    }
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
    }

    public function outreports($society_id,$type,$id)
    {
        $date=date("d-m-Y h:i A");

        $sosieties = Inouts::where('type',$type)->where("id",$id)->update(['flag'=>2,'outtime'=>$date]);

        return redirect()->route('admin.societies.reports.index',$society_id)->with('success','Visitor out successfully.');
    } 

    public function tenantReports(Request $request,$id)
    {
         $society = Society::find($id);
         if($society){
              $buildings = Building::where('society_id',$id)->get();
              $guard=Guard::where('society_id',$id)->get();
              //$flats = Flat::where("building_id",$buildings->building_id)->get();
              return view('admin.societies.reports.tenantreport',["society" => $society,'buildings'=>$buildings,'guard'=>$guard]);
         }else{
              return view('admin.errors.404');
         }
    }

    public function arrayTenantReports(Request $request, $society_id)
    {

      $response = [];
      $sosieties = Member::where("society_id",$society_id)->where('relation','=','self')->where('flatType','=','Renting the flat')->with('vehicle','user','building','flat')->get();

      foreach ($sosieties as $s) {

                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = isset($s->user->name)?$s->user->name:'';
                $sub[] = isset($s->building->name)?$s->building->name.'-'.$s->flat->name:'';
                
                if($s->policeverify=='Y')
                {
                    $sub[] = '<a href="#"><label class="label label-success">Yes</label></a>';

                }
                elseif($s->policeverify=='N')
                {
                    $sub[] = '<a href="#"><label class="label label-success">No</label></a>';
                }
                else
                {
                    $sub[] = '<a href="#">--</a>';
                }
               // $sub[] = isset($s->policeverify)?$s->policeverify:'';

                $ext = pathinfo($s->idproof, PATHINFO_EXTENSION);

                $img   = env('APP_URL_STORAGE').$s->idproof;

                if($ext=='jpeg' || $ext=='jpg'||$ext=='png'||$ext=='bmp')
                {
                    $sub[] = "<a class='example-image-link' href='".$img."' data-lightbox='example-1'><img width='50' class='example-image' src='".$img."' alt='image-1' /></a>";
                }elseif ($ext=='pdf') {

                    $sub[] = "<a href='".$img."' download><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
                }elseif($img==''){
                    $sub[] = "<a href='".$img."' download><i class='fa fa-file' aria-hidden='true'></i></a>";
                }else{
                   $sub[] = "<a href='#' download></a>";
                }
               
                $sub[] = date('d-m-Y',strtotime($s->since));
                
                $response[] = $sub;
      }
      $userjson = json_encode(["data" => $response]);
      echo $userjson;

    }

    public function indexdomestichelpers($id)
    {
        $society = Society::find($id);
      if($society){
          $buildings = Building::where('society_id',$id)->get();
          $guard=Guard::where('society_id',$id)->get();
          //$flats = Flat::where("building_id",$buildings->building_id)->get();
          return view('admin.societies.reports.helpersreport',["society" => $society,'buildings'=>$buildings,'guard'=>$guard]);
      }else{
          return view('admin.errors.404');
      }
    }

    public function domestichelpersArray(Request $request,$society_id)
    {
      $sosieties = Inouts::where("society_id",$society_id)->with('visitorlist','invitelist')->where('type','=',3)->get();

      $response=[];

      foreach ($sosieties as $s) {
                          $sub = [];
                          $id = $s->id;
                          $sub[] = $id;
                          $visitor=DomesticHelpers::where('id',$s->request_id)->where("society_id",$society_id)->first();
                          $guardname=Guard::where('id',$s->guard_id)->first();
                          $sub[]=$visitor['name'];
                          $sub[]=$guardname['name'];
                          $sub[]=$s['intime'];
                          $sub[]=$s['outtime'];
                          if($s->flag=='1')
                          {
                              $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.reports.out', ["society_id" => $society_id,"type" => $s->type, "request_id" => $id]).'">Out</a>' . '</div> ';
                          }else
                          {
                              $action = '<div class="btn-part"></div> ';
                          }
                          
                          $sub[] = $action;
                          $response[] = $sub;
      }
              
      $userjson = json_encode(["data" => $response]);
      echo $userjson;
    }

    public function domestichelperoutreports($society_id,$type,$id)
    {
        $date=date("d-m-Y h:i A");
        
        

        $sosieties = Inouts::where('type',$type)->where("id",$id)->update(['flag'=>2,'outtime'=>$date]);

        return redirect()->route('admin.societies.helpers.index',$society_id)->with('success','DomesticHelpers out successfully.');
    } 


}
