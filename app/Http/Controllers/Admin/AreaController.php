<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;
use App\Area;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.areas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $cities = City::all();
        return view('admin.areas.add',['cities' => $cities]);
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
          'city' => 'required',
      ]);

        $city = new Area;
        $city->name = request('name');
        $city->city_id = request('city');
        $city->save();
        return redirect()->route('admin.areas.index')->with("success","Area added successfully.");
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
        $area = Area::find($id);
        $cities = City::all();
        if($area){
          return view('admin.areas.edit',["area" => $area,'cities' => $cities]);
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
            'city' => 'required',
        ]);
        $area = Area::find($id);
        if($area){
          $area->city_id = request('city');
          $area->name = request('name');
          $area->save();
        }
        return redirect()->route('admin.areas.index')->with('success','Area updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $city = Area::find($id);
        if($city){
          $city->delete();
        }
        return redirect()->route('admin.areas.index')->with('success','Area deleted successfully.');

    }


        public function Array(Request $request)
        {
            $response = [];
            $areas = Area::all();
            foreach ($areas as $area) {
                $sub = [];
                $id = $area->id;

                $sub[] = $id;

                $sub[] = $area->city->name;
                $sub[] = $area->name;
               // $sub[] = $area->created_at->toDateTimeString();;
                $sub[] = date('d-m-Y H:s',strtotime($area->created_at));

                $delete_url = route('admin.areas.delete', [$id]);

                $action = '<div class="btn-part"><a class="edit" href="' . route('admin.areas.edit', $id) . '"><i class="fa fa-pencil-square-o"></i></a>' . ' ';
                $action .= '<a class="delete" onclick="return confirm(`Are you sure you want to delete this record?`)"  href="'.route('admin.areas.delete',$id).'"><i class="fa fa-trash"></i>&nbsp;</a></div>';

                $sub[] = $action;
                $response[] = $sub;
            }
            $userjson = json_encode(["data" => $response]);
            echo $userjson;
        }

        public function areaByCity($city_id){
          $areas = Area::select('name','id')->where('city_id',$city_id)->get();
          return response()->json($areas);
        }
}
