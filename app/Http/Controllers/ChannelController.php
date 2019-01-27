<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Station;
use App\Models\Merchant;

class ChannelController extends Controller
{
    public function createNewChannel()
    {
        return view('channel.add-new-channel');
    }

	public function channeladmin()
    {

		$initiators = DB::select(DB::raw("select mer.id as merchantid, mer.user_id as userid, mer.company_name as name, SUM( IF(porder.created_at >= '1970-01-01' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, SUM(IF(porder.created_at >= '" . date('Y') . "-01-01' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= '" . date('Y-m') . "-01' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD
		from merchant mer 
		left join autolink auto on auto.responder = mer.id AND auto.visibility = 1
		left join merchantproduct on merchantproduct.merchant_id = mer.id
		left join orderproduct ON merchantproduct.product_id = orderproduct.product_id
		left join porder ON orderproduct.porder_id = porder.id
		left join sorder ON sorder.porder_id = porder.id
		WHERE 
		mer.status = 'active'
		group by merchantid 
		order by mer.created_at DESC")); 
		
		$stations = DB::select(DB::raw("select station.id as stationid, station.user_id as userid, station.company_name as name, SUM( IF(porder.created_at >= '1970-01-01' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, SUM(IF(porder.created_at >= '" . date('Y') . "-01-01' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= '" . date('Y-m') . "-01' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD
		from autolink auto inner join station on auto.initiator = station.user_id 
		left join merchant on auto.responder = merchant.id
		left join merchantproduct on merchantproduct.merchant_id = merchant.id
		left join orderproduct ON merchantproduct.product_id = orderproduct.product_id
		left join porder ON orderproduct.porder_id = porder.id
		left join sorder ON sorder.porder_id = porder.id
		WHERE auto.visibility = 1
		group by stationid 
		order by auto.created_at DESC"));
		//dd($stations);
		return view('admin.adminchannel',['merchants'=>$initiators, 'stations'=>$stations]);
    }

    public function ochannelall($id)
    {

		
	$stations=  Station::join('autolink', 'autolink.initiator', '=', 'station.user_id')->
				leftJoin('address','station.address_id','=','address.id')->
				leftJoin('city','city.id','=','address.city_id')->
				leftJoin('state','city.state_code','=','state.code')->
				leftJoin('country','country.code','=','state.country_code')->
				leftJoin('merchant','autolink.responder','=','merchant.id')->
				leftJoin('merchantproduct','merchantproduct.merchant_id','=','merchant.id')->
				leftJoin('sproduct','merchantproduct.product_id','=','sproduct.product_id')->
				leftJoin('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')->
				leftJoin('sorder','sorder.station_id','=','station.id')->
				leftJoin('porder','sorder.porder_id','=','porder.id')->
				leftJoin('orderproduct','orderproduct.porder_id','=','porder.id')->
				leftJoin('area','area.id','=','address.area_id')
                ->selectRaw('station.id, station.station_name, station.user_id, address.line1, address.line2, station.address_id, city.name as cityname, state.name as statename, country.name as countryname, area.name as areaname, autolink.responder as merchantid, SUM( IF(porder.created_at >= \'1970-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, SUM(IF(porder.created_at >= \'' . date('Y') . '-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= \'' . date('Y-m') . '-01\' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD, IF(station.id = stationsproduct.station_id, COUNT(stationsproduct.station_id), 0) as apcount
                    ')
                ->where('merchant.user_id', '=', $id)->where('autolink.status', '=', 'linked')->where('autolink.visibility', '=', 1)->groupBy('station.id')->get();


					//$openstation = DB::table('station')->where('id',$stations)->get();	
                //dd($stations);
					$currency = Currency::where('active', 1)->first();

                   return view('admin.adminchannel_all')
                ->with('stations',$stations)
                ->with('mode','all')
                ->with('currency',$currency);
    }
	
	public function ochannelpasive($id)
    {

		
	$stations=  Station::join('autolink', 'autolink.initiator', '=', 'station.user_id')->
				leftJoin('address','station.address_id','=','address.id')->
				leftJoin('city','city.id','=','address.city_id')->
				leftJoin('state','city.state_code','=','state.code')->
				leftJoin('country','country.code','=','state.country_code')->
				leftJoin('merchant','autolink.responder','=','merchant.id')->
				leftJoin('merchantproduct','merchantproduct.merchant_id','=','merchant.id')->
				leftJoin('sproduct','merchantproduct.product_id','=','sproduct.product_id')->
				leftJoin('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')->
				leftJoin('sorder','sorder.station_id','=','station.id')->
				leftJoin('porder','sorder.porder_id','=','porder.id')->
				leftJoin('orderproduct','orderproduct.porder_id','=','porder.id')->
				leftJoin('area','area.id','=','address.area_id')
                ->selectRaw('station.id, station.station_name, station.user_id, station.address_id, address.line1, address.line2, city.name as cityname, state.name as statename, country.name as countryname, area.name as areaname, autolink.responder as merchantid, SUM( IF(porder.created_at >= \'1970-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, SUM(IF(porder.created_at >= \'' . date('Y') . '-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= \'' . date('Y-m') . '-01\' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD, IF(station.id = stationsproduct.station_id, COUNT(stationsproduct.station_id), 0) as apcount
                    ')
                ->where('merchant.user_id', '=', $id)->where('autolink.status', '=', 'linked')->where('autolink.visibility', '=', 1)->groupBy('station.id')->get();

					//$openstation = DB::table('station')->where('id',$stations)->get();	
                //dd($stations);
					$currency = Currency::where('active', 1)->first();

                   return view('admin.adminchannel_all')
                ->with('stations',$stations)
				->with('mode','pasive')
                ->with('currency',$currency);
    }
	
	public function ochannelactive($id)
    {

		
	$stations=  Station::join('autolink', 'autolink.initiator', '=', 'station.user_id')->
				leftJoin('address','station.address_id','=','address.id')->
				leftJoin('city','city.id','=','address.city_id')->
				leftJoin('state','city.state_code','=','state.code')->
				leftJoin('country','country.code','=','state.country_code')->
				leftJoin('merchant','autolink.responder','=','merchant.id')->
				leftJoin('merchantproduct','merchantproduct.merchant_id','=','merchant.id')->
				leftJoin('sproduct','merchantproduct.product_id','=','sproduct.product_id')->
				leftJoin('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')->
				leftJoin('sorder','sorder.station_id','=','station.id')->
				leftJoin('porder','sorder.porder_id','=','porder.id')->
				leftJoin('orderproduct','orderproduct.porder_id','=','porder.id')->
				leftJoin('area','area.id','=','address.area_id')
                ->selectRaw('station.id, station.station_name, station.user_id, station.address_id, address.line1, address.line2, city.name as cityname, state.name as statename, country.name as countryname, area.name as areaname, autolink.responder as merchantid, SUM( IF(porder.created_at >= \'1970-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, AVG((sproduct.stock - sproduct.available)/sproduct.stock) as qty_left,SUM(IF(porder.created_at >= \'' . date('Y') . '-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= \'' . date('Y-m') . '-01\' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD, IF(station.id = stationsproduct.station_id, COUNT(stationsproduct.station_id), 0) as apcount
                    ')
                ->where('merchant.user_id', '=', $id)->where('autolink.status', '=', 'linked')->where('autolink.visibility', '=', 1)->groupBy('station.id')->get();


					//$openstation = DB::table('station')->where('id',$stations)->get();	
                //dd($stations);
					$currency = Currency::where('active', 1)->first();

                   return view('admin.adminchannel_all')
                ->with('stations',$stations)
				->with('mode','active')
                ->with('currency',$currency);
    }
	
    public function sochannelall($id)
    {	
	$merchants= Merchant::
				leftJoin('address','merchant.address_id','=','address.id')->
				leftJoin('city','city.id','=','address.city_id')->
				leftJoin('state','city.state_code','=','state.code')->
				leftJoin('country','country.code','=','state.country_code')->
				leftJoin('autolink','autolink.responder','=','merchant.id')->
				leftJoin('station','autolink.initiator','=','station.user_id')->
				leftJoin('merchantproduct','merchantproduct.merchant_id','=','merchant.id')->
				leftJoin('sproduct','merchantproduct.product_id','=','sproduct.product_id')->
				leftJoin('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')->
				leftJoin('sorder','sorder.station_id','=','station.id')->
				leftJoin('porder','sorder.porder_id','=','porder.id')->
				leftJoin('orderproduct','orderproduct.porder_id','=','porder.id')->
				leftJoin('area','area.id','=','address.area_id')
                ->selectRaw('merchant.id, merchant.company_name, merchant.user_id, address.line1, address.line2, merchant.address_id, city.name as cityname, state.name as statename, country.name as countryname, area.name as areaname, autolink.responder as merchantid, SUM( IF(porder.created_at >= \'1970-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, SUM(IF(porder.created_at >= \'' . date('Y') . '-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= \'' . date('Y-m') . '-01\' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD, IF(station.id = stationsproduct.station_id, COUNT(stationsproduct.station_id), 0) as apcount
                    ')
                ->where('station.user_id', '=', $id)->where('autolink.status', '=', 'linked')->where('autolink.visibility', '=', 1)->groupBy('merchant.id')->get();


					//$openstation = DB::table('station')->where('id',$stations)->get();	
                //dd($stations);
					$currency = Currency::where('active', 1)->first();

                   return view('admin.adminchannel_sall')
                ->with('merchants',$merchants)
                ->with('mode','all')
                ->with('currency',$currency);
    }
	
	public function sochannelpasive($id)
    {

		
	$merchants= Merchant::
				leftJoin('address','merchant.address_id','=','address.id')->
				leftJoin('city','city.id','=','address.city_id')->
				leftJoin('state','city.state_code','=','state.code')->
				leftJoin('country','country.code','=','state.country_code')->
				leftJoin('autolink','autolink.responder','=','merchant.id')->
				leftJoin('station','autolink.initiator','=','station.user_id')->
				leftJoin('merchantproduct','merchantproduct.merchant_id','=','merchant.id')->
				leftJoin('sproduct','merchantproduct.product_id','=','sproduct.product_id')->
				leftJoin('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')->
				leftJoin('sorder','sorder.station_id','=','station.id')->
				leftJoin('porder','sorder.porder_id','=','porder.id')->
				leftJoin('orderproduct','orderproduct.porder_id','=','porder.id')->
				leftJoin('area','area.id','=','address.area_id')
                ->selectRaw('merchant.id, merchant.company_name, merchant.user_id, address.line1, address.line2, merchant.address_id, city.name as cityname, state.name as statename, country.name as countryname, area.name as areaname, autolink.responder as merchantid, SUM( IF(porder.created_at >= \'1970-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, SUM(IF(porder.created_at >= \'' . date('Y') . '-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= \'' . date('Y-m') . '-01\' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD, IF(station.id = stationsproduct.station_id, COUNT(stationsproduct.station_id), 0) as apcount
                    ')
                ->where('station.user_id', '=', $id)->where('autolink.status', '=', 'linked')->where('autolink.visibility', '=', 1)->groupBy('merchant.id')->get();

					//$openstation = DB::table('station')->where('id',$stations)->get();	
                //dd($stations);
					$currency = Currency::where('active', 1)->first();

                   return view('admin.adminchannel_sall')
                ->with('merchants',$merchants)
				->with('mode','pasive')
                ->with('currency',$currency);
    }
	
	public function sochannelactive($id)
    {

		
	$merchants= Merchant::
				leftJoin('address','merchant.address_id','=','address.id')->
				leftJoin('city','city.id','=','address.city_id')->
				leftJoin('state','city.state_code','=','state.code')->
				leftJoin('country','country.code','=','state.country_code')->
				leftJoin('autolink','autolink.responder','=','merchant.id')->
				leftJoin('station','autolink.initiator','=','station.user_id')->
				leftJoin('merchantproduct','merchantproduct.merchant_id','=','merchant.id')->
				leftJoin('sproduct','merchantproduct.product_id','=','sproduct.product_id')->
				leftJoin('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')->
				leftJoin('sorder','sorder.station_id','=','station.id')->
				leftJoin('porder','sorder.porder_id','=','porder.id')->
				leftJoin('orderproduct','orderproduct.porder_id','=','porder.id')->
				leftJoin('area','area.id','=','address.area_id')
                ->selectRaw('merchant.id, merchant.company_name, merchant.user_id, address.line1, address.line2, merchant.address_id, city.name as cityname, state.name as statename, country.name as countryname, area.name as areaname, autolink.responder as merchantid, SUM( IF(porder.created_at >= \'1970-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, SUM(IF(porder.created_at >= \'' . date('Y') . '-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= \'' . date('Y-m') . '-01\' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD, IF(station.id = stationsproduct.station_id, COUNT(stationsproduct.station_id), 0) as apcount
                    ')
                ->where('station.user_id', '=', $id)->where('autolink.status', '=', 'linked')->where('autolink.visibility', '=', 1)->groupBy('merchant.id')->get();

					//$openstation = DB::table('station')->where('id',$stations)->get();	
                //dd($stations);
					$currency = Currency::where('active', 1)->first();

                   return view('admin.adminchannel_sall')
                ->with('merchants',$merchants)
				->with('mode','active')
                ->with('currency',$currency);
    }	
	
    public function getstation($id)
    {

		
	$stations=  Station::join('autolink', 'autolink.initiator', '=', 'station.user_id')
                ->selectRaw('station.id, station.station_name, station.user_id
                    ')
                ->where('autolink.responder', '=', $id)->get();

    	//$openstation = DB::table('station')->where('id',$stations)->get();	
                //dd($stations);
        $currency = Currency::where('active', 1)->first();

                   return view('admin.adminchannel_all')
                ->with('stations',$stations)
                ->with('currency',$currency);
    }
   
}
