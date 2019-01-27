<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Sproperty;

use DB;

class AdminPropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $property = DB::table('station')->select('station.id as id', 'users.first_name as first_name', 'users.last_name as last_name', 'station.company_name as company_name')->join('users','users.id','=','station.user_id')->get();
		//dd($property);
        return view('admin.property',['property'=>$property]);
    }

    public function sproperty($id)
    {
        $sproperty = DB::table('sproperty')->select('state.name as state','city.name as city', 'country.name as country', 'area.name as area'
		, 'sproperty.biz_name as biz_name', 'sproperty.shop_size as shop_size', 'sproperty.prop_owner_first_name as prop_owner_first_name'
		, 'sproperty.prop_owner_last_name as prop_owner_last_name','sproperty.biz_owner_contact as biz_owner_contact'
		, 'outlet.description as outlet', 'sproperty.delivery_mode as delivery', 'sproperty.outlet_name as outlet_name')
		->where('sproperty.station_id',$id)->leftJoin('address','address.id','=','sproperty.address_id')->leftJoin('area','address.area_id','=','area.id')
		->leftJoin('city','city.id','=','address.city_id')->leftJoin('state','state.code','=','city.state_code')
		->leftJoin('outlet','outlet.id','=','sproperty.outlet_id')
		->leftJoin('country','country.code','=','state.country_code')->get();
		//dd($property);
		return json_encode($sproperty);
       // return view('admin.property',['property'=>$property]);
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
