<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Product;
use App\Models\Currency;

class StationComissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stations = Station::with(['products'])->get();
        return view('admin.adminComission',['stations'=>$stations]);
    }

    public function recruiter()
    {
        $currency = '';
        if(!is_null(Currency::where('active',true)->first())){
            $currency = Currency::where('active',true)->first()->code;
        }

        $stationsr = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name', 'sales_staff.target_merchant as target_merchant', 'sales_staff.target_revenue as target_revenue', 'sales_staff.commission as commission')->where('sales_staff.type','str')
		->join('users', 'sales_staff.user_id', '=', 'users.id')
		->orderBy('sales_staff.created_at','DESC')
		->get();
        return view('admin.adminComission',['stationrecruiter'=>$stationsr, 'currency' => $currency]);
    }

	public function getStation($id)
    {
        $stations = DB::table('product')->select('product.id as pid', 'product.name as pname', 'product.osmall_commission as osmall_commission', 'product.parent_id as parent_id', 'product.segment as segment')
		->where('station.id',$id)
		->join('stationsproduct', 'stationsproduct.sproduct_id', '=', 'product.id')
		->join('station', 'stationsproduct.station_id', '=', 'station.id')
		->get();

		return view('commissions.station_commissions',['stationscom'=>$stations,'sid'=>$id]);
    }
	
	public function getStationb2b($id)
    {
        $stations = DB::table('product')->select('product.id as pid', 'product.name as pname', 'product.b2b_osmall_commission as b2b_osmall_commission', 'product.parent_id as parent_id', 'product.segment as segment')
		->where('station.id',$id)
		->join('stationsproduct', 'stationsproduct.sproduct_id', '=', 'product.id')
		->join('station', 'stationsproduct.station_id', '=', 'station.id')
		->get();

		return view('commissions.station_commissionsb2b',['stationscom'=>$stations,'sid'=>$id]);
    }	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
