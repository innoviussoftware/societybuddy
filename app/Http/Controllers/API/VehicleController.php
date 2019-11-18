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
use App\Vehicle;
use App\Member;

class VehicleController extends Controller
{
    // 1 = Succcess status
    // 0 = Error status
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

    public function get(Request $request){
        

      $familyMember=$this->getfamilyMember(auth()->user()->id);

      $vehicles = Vehicle::select('id','number','type')->whereIn('user_id', $familyMember)->orderBy('id','desc')->get();

      $response = [];

      foreach ($vehicles as $ve) {
                      $response[] = [
                        "id" => $ve->id,
                        "number" => $ve->number,
                        "type" => $ve->type,
                      ];
      }
      
      return response()->json(['data' => $response,'status'=>1,'message' => "Successfully Get Vehicles."] , 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
                  'type'  => 'required',
                  'number'=> 'required',
        ]);
        if ($validator->fails()) {
            $errorArray = $validator->errors()->all();
            $message = implode(",",$errorArray);
           return response()->json(['data' => [],'status'=>0,'message' => $message] , 200);
        } else {
          $loggedInUser = auth()->user();
          $v = new Vehicle();
          $v->user_id = $loggedInUser->id;
          $v->type = request('type');
          $v->number = request('number');
          $v->save();
          return response()->json(['data' => [],'status'=>1,'message' => "Successfully added vehicle."] , 200);
        }
    }



    public function update(Request $request, $vehicle_id){
      $vehicle = Vehicle::find($vehicle_id);
      if(!$vehicle){
        return response()->json(['data' => [],'status'=> 0,'message' => "Vehicle not found"] , 200);
        exit;
      }
      $validator = Validator::make($request->all(), [
                'type'  => 'required',
                 'number'=> 'required',
      ]);
      if ($validator->fails()) {
          $errorArray = $validator->errors()->all();
          $message = implode(",",$errorArray);
         return response()->json(['data' => [],'status'=>0,'message' => $message] , 200);
      } else {
        $vehicle->type = request('type');
        $vehicle->number = request('number');
        $vehicle->save();


        return response()->json(['data' => [],'status'=> 1, 'message' => "Vehicle updated"] , 200);
      }
    }

    public function delete($id){
        $v = Vehicle::find($id);
        if($v){
          $v->delete();
        }
        return response()->json(['data' => [],'status'=> 1, 'message' => "Vehicle deleted"] , 200);
    }

    public function exists(Request $request){
      $validator = Validator::make($request->all(), [
             'number'=> 'required',
      ]);
      if ($validator->fails()) {
          $errorArray = $validator->errors()->all();
          $message = implode(",",$errorArray);
         return response()->json(['data' => [],'status'=>0,'message' => $message] , 200);
      } else {
        $vehicle = Vehicle::select("type","number")->where('number',request('number'))->first();
        if(!$vehicle){
          return response()->json(['data' => [],'status'=>0,'message' => "Vehicle is not registerd"] , 200);
        }else{
          return response()->json(['data' => $vehicle,'status'=> 1, 'message' => "Vehicle success"] , 200);
        }

      }
    }
}
