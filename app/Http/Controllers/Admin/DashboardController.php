<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Guard;
use App\Visitor;
use App\Building;
use App\Member;
use App\Vehicle;
use App\Inouts;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
      $data = [];
      $barchart = ["labels" => [], "values" => []];
      $graph_data = [
        ["day" => date('l'), "visitors" => 0],
        ["day" => date('l', strtotime('-1 days')), "visitors" => 0],
        ["day" => date('l', strtotime('-2 days')), "visitors" => 0],
        ["day" => date('l', strtotime('-3 days')), "visitors" => 0],
        ["day" => date('l', strtotime('-4 days')), "visitors" => 0],
        ["day" => date('l', strtotime('-5 days')), "visitors" => 0],
        ["day" => date('l', strtotime('-6 days')), "visitors" => 0]
      ];
        if(auth()->user()->hasRole('society_admin')){
          $society_id=auth()->user()->society_id;
            $total_guards = Guard::where('society_id',auth()->user()->society_id)->get()->count();
            //$total_visitors = Visitor::where('society_id',auth()->user()->society_id)->get()->count();
            $total_visitors = Inouts::where('flag',1)->where("society_id",auth()->user()->society_id)->with('visitorlist','invitelist')->where('type','!=',3)->get()->count();
            $total_buildings = Building::where('society_id',auth()->user()->society_id)->get()->count();
            $total_members = Member::where('society_id',auth()->user()->society_id)->get()->count();
            $total_two_vehicles=Vehicle::where('type','=','Two Wheeler')->with('user')->whereHas('user'     ,function($q) use ($society_id){
                      $q->where('society_id',$society_id);
            })->count();
            $total_four_vehicles=Vehicle::where('type','=','Four Wheeler')->with('user')->whereHas('user'     ,function($q) use ($society_id){
                      $q->where('society_id',$society_id);
            })->count();

            $date = \Carbon\Carbon::today()->subDays(6);
            $users = Visitor::select(DB::raw('DATE_FORMAT(created_at, "%W") as date'), DB::raw('count(*) as visitors'))
                              ->where('created_at', '>=', $date)
                              ->where('society_id',  auth()->user()->society_id)
                              ->groupBy('date')
                              ->get();
            if($users){
              foreach ($users->toArray()  as $u) {
                foreach ($graph_data as $key => $l) {
                  if($l['day'] == $u['date']){
                    $graph_data[$key]['visitors'] = $u['visitors'];
                  }else{
                    $graph_data[$key]['visitors'] = 0;
                  }
                }
              }
            }
        }else{
            $total_guards = Guard::all()->count();
            $total_visitors = Visitor::all()->count();
            $total_buildings = Building::all()->count();
            $total_members = Member::all()->count();
            $total_two_vehicles='';
            $total_four_vehicles='';
        }
        $data['total_guards'] = $total_guards;
        $data['total_visitors'] = $total_visitors;
        $data['total_buildings'] = $total_buildings;
        $data['total_members'] = $total_members;
        $data['total_two_vehicles'] = $total_two_vehicles;
        $data['total_four_vehicles'] = $total_four_vehicles;

        $days = array_column($graph_data, 'day');
        $days[0] = "Today";
        $days[1] = "Yesterday";
        $v = array_column($graph_data, 'visitors');
        $barchart['labels'] = $days;
        $barchart['values'] = $v;
        $data['bar_chart'] = $barchart;
        return view('admin.dashboard',['data' => $data]);
    }
}
