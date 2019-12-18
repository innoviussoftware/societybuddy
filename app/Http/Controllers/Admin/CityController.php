<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;
use App\Referral;
use App\User;
use App\Society;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cities.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.cities.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
          'name' => 'required',
      ]);

        $city = new City;
        $city->name = request('name');
        $city->save();
        return redirect()->route('admin.cities.index')->with("success","City added successfully.");
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::find($id);
        if($city){
          return view('admin.cities.edit',["city" => $city]);
        }else{
          return redirect()->route('admin.dashboard');
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
        ]);
        $city = City::find($id);
        if($city){
          $city->name = request('name');
          $city->save();
        }
        return redirect()->route('admin.cities.index')->with('success','City updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $city = City::find($id);
        if($city){
          $city->delete();
        }
        return redirect()->route('admin.cities.index')->with('success','City deleted successfully.');

    }


        public function cityArray(Request $request)
        {
            $response = [];
            $doctors = City::all();
            $doctors = $doctors->toArray();
            foreach ($doctors as $doctor) {
                $sub = [];
                $id = $doctor['id'];

                $sub[] = $id;

                $sub[] = $doctor['name'];
                $sub[] = date('d-m-Y H:s',strtotime($doctor['created_at']));


                $delete_url = route('admin.cities.delete', [$id]);

                $action = '<div class="btn-part"><a class="edit" href="' . route('admin.cities.edit', $id) . '"><i class="fa fa-pencil-square-o"></i></a>' . ' ';
                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record ?`)"  href="'.route('admin.cities.delete',$id).'"><i class="fa fa-trash"></i>&nbsp;</a></div>';

                $sub[] = $action;
                $response[] = $sub;
            }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }

        public function referralindex(Request $request)
        {
            return view('admin.referral.index');
        }

        public function referralArray(Request $request)
        {
            $response = [];
            $referrals = Referral::all();
            $referrals = $referrals->toArray();
            foreach ($referrals as $referral) {


                $sub = [];
                $id = $referral['id'];


                $user = User::find($referral['user_id']);

                $society_id=Society::find(isset($user->society_id)?$user->society_id:'');

                $building_name=isset($user->member->building->name)?$user->member->building->name:'';

                $flat_name=isset($user->member->flat->name)?$user->member->flat->name:'';

                $member=$building_name.'-'.$flat_name;
                
                $sub[] = $id;

                $sub[]=isset($society_id->name)?$society_id->name:'';

                $sub[]=isset($user->name)?$user->name:'-';

                $sub[]=isset($member)?$member:'-';

                $sub[]=isset($referral['society_name'])?$referral['society_name']:'-';

                $sub[]=isset($referral['contact'])?$referral['contact']:'-';

                $sub[] = date('d-m-Y',strtotime($referral['created_at']));

                $response[] = $sub;
            }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }


}
