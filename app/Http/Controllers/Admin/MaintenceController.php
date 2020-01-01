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
use Auth;
use DB;
use App\Helpers\Notification\PushNotification;

class MaintenceController extends Controller
{
    //
    public function index($id){

        $society = Society::find($id);
        if($society){
          $buildings = Building::where('society_id',$id)->get();
          return view('admin.maintence.index',["society" => $society]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function addEvents($id){

      $society = Society::find($id);
      $roles = Role::memberRoles();
        if($society){
          $buildings = Building::where('society_id',$id)->get();
          return view('admin.maintence.add',["society" => $society, 'buildings' => $buildings, 'roles' => $roles]);
        }else{
          return view('admin.errors.404');
        }

    }

    public function store(Request $request,$society_id){


        $this->validate($request, [
            'amount' => 'required',
            
        ]);
         
        $building_id=request('building_id');
        $array_comp_prod = implode(",", $building_id);

        $maintence = new Maintence;        
        $maintence->society_id = $society_id;
        $maintence->building_id = $array_comp_prod;
        $maintence->payment_mode = request('optionsRadios');
        $maintence->maintence_amount = request('amount');

        if( $request->sameamount == 'on' )
        {
            $maintence->tenant_amount = request('amount');
        }
        else
        {
            $maintence->tenant_amount = request('amounttenant');
        }

        if(isset($request->monthly))
        {
            $maintence->monthlypayment_date = request('monthly');
        }

        if(isset($request->yearly))
        {
            $maintence->yearlypaymentdate = request('yearly');
        }
        $maintence->penalty = request('penalty');
        $maintence->save();

        return redirect()->route('admin.societies.maintence.index',$society_id)->with("success","Maintenance added successfully.");
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

        $b = Maintence::find($id);
        if($b && $s){
          $buildings = Building::where("society_id",$society_id)->get();
          return view('admin.maintence.edit',["society" => $s,"maintence" => $b,'buildings'=> $buildings,]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function update(Request $request, $society_id, $member_id){
        
        $this->validate($request, [
            'amount' => 'required',
            
        ]);
        $notice = Maintence::find($member_id);

        if($notice)
        {
            $building_id=request('building_id');

            $array_comp_prod = implode(",", $building_id);

            $notice->society_id = $society_id;
            $notice->building_id = $array_comp_prod;
            $notice->payment_mode = request('optionsRadios');
            $notice->maintence_amount = request('amount');
// dd($request->all());
            if($request->sameamount == 'on' )
            {
                $notice->tenant_amount = request('amount');
            }
            else
            {
                $notice->tenant_amount = request('amounttenant');
            }

            if(isset($request->monthly))
            {
                $notice->monthlypayment_date = request('monthly');
            }

            if(isset($request->yearly))
            {
                $notice->yearlypaymentdate = request('yearly');
            }
            $notice->penalty = request('penalty');

            $notice->save();
        }
        return redirect()->route('admin.societies.maintence.index', $society_id)->with('success','Maintenance updated successfully.');
    }

  
     public function Array(Request $request,$society_id){
            $response = [];
            
            //$notice = Event::where("society_id",$society_id)->get();

    $notice = \DB::table("maintence")
        ->select("maintence.*",\DB::raw("GROUP_CONCAT(buildings.name) as buildingsname"))
        ->leftjoin("buildings",\DB::raw("FIND_IN_SET(buildings.id,maintence.building_id)"),">",\DB::raw("'0'"))
        ->where('maintence.society_id',$society_id)
        ->groupBy("maintence.id")
        ->get();


            foreach ($notice as $s) {
                $sub = [];
                $id = $s->id;
                $sub[] = $id;
                $sub[] = $s->buildingsname;
                $sub[] = $s->maintence_amount;
                $sub[] = $s->tenant_amount;
                $sub[] = $s->payment_mode;
                $sub[] = isset($s->monthlypayment_date)?$s->monthlypayment_date:'-';
                $sub[] = isset($s->yearlypaymentdate)?$s->yearlypaymentdate:'-';
                $sub[] = $s->penalty;

                $delete_url = route('admin.societies.maintence.delete', ["society_id" => $society_id, "member_id" => $id]);

             
                $action = '<div class="btn-part"><a class="edit" href="'.route('admin.societies.maintence.edit', ["society_id" => $society_id, "notice_id" => $id]).'"><i class="fa fa-pencil-square-o"></i></a>' . ' ';

                $action .= '<a class="delete" onclick="return confirm(`'.$delete_url.'`,`Are you sure you want to delete this record?`)" ><i class="fa fa-trash"></i>&nbsp;</a></div>';

                $sub[] = $action;

                $response[] = $sub;
              }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }

        public function delete($society_id,$member_id){
          $notice = Maintence::find($member_id);

          if($notice)
          {
            $notice->delete();
          }

          return redirect()->route('admin.societies.maintence.index',$society_id)->with('success','Maintenance deleted successfully.');

    }

    public function maintencepayment($id)
    {
        $society = Society::find($id);
        if($society){
          $buildings = Building::where('society_id',$id)->get();
          return view('admin.societies.maintence_member_payment.index',["society" => $society,'buildings'=>$buildings]);
        }else{
          return view('admin.errors.404');
        }
    }

    public function buildingwisemember($id,$society_id)
    {
        $members=Member::where("building_id",$id)->where("society_id",$society_id)->where('relation','=','self')->with('vehicle','user','building','flat')->get();
        
        return response()->json($members);
    }



    
}
