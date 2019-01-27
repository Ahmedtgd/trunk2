<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use App\Models\Currency;
use Yajra\Datatables\Facades\Datatables;

class AnalysisController extends Controller {
    public function inventory_paginate($start=0){
		$end=$start+30;
		$ret=array();
		if (!Auth::check() or !Auth::user()->hasRole('adm')) {
            return $ret;
        }
        try {
            $ret = DB::table('product')->select(DB::raw(
			   "product.id,  product.status as status,  product.parent_id, product.name, product.created_at, IF(sproduct.id is NULL, 'Direct', 'Station/Direct') as type, SUM(orderproduct.quantity) as qty, SUM(orderproduct.order_price) as total, IF(oshopproduct.id is NULL, 0, product.available) retail_oshop, IF(oshopproduct.id is NULL, 0, b2b.available) as b2b_oshop, product.available as album_available, b2b.available as b2b_available, SUM(sproduct.available) as sproduct_total, SUM(IF(sproduct.available >= (sproduct.stock*0.3),1,0)) as high_stock, SUM(IF(sproduct.available < (sproduct.stock*0.3),1,0)) as low_stock,IFNULL(nproductid.nproduct_id,LPAD(product.id,16,'E')) as nproduct_id, DATE_FORMAT(product.created_at,'%d%b%y %H:%i') as since"
			))
			->leftJoin('nproductid','product.id','=','nproductid.product_id')
			->leftJoin('sproduct','product.id','=','sproduct.product_id')
			->leftJoin('orderproduct','product.id','=','orderproduct.product_id')
			->leftJoin('product as b2b', function($join) {
						 $join->on('product.id', '=', 'b2b.parent_id')
						 ->where('b2b.segment','=','b2b');
					 })
			->leftJoin('oshopproduct','product.id','=','oshopproduct.product_id')
			->groupBy('product.id')
			->orderBy('product.created_at','DESC');
              
        } catch (\Exception $e) {
            // dd($e);
        }
        return Datatables::queryBuilder($ret)->make(true);
		
	}
    public function index(){

        $currency = Currency::where('active', 1)->first();
       //dd($inventoryResults);exit;
        return view('admin.adminInventoryPaginate')->with('currencyCode' , $currency->code);
    }
	
    public function productinventory($id){
        $inventory = DB::select(DB::raw('SELECT merchant.id as id, merchant.company_name as name, product.available as qty, "merchant" as type FROM merchant JOIN merchantproduct ON merchant.id = merchantproduct.merchant_id JOIN product ON merchantproduct.product_id = product.id WHERE product.id = ' . $id . ' UNION SELECT station.id as id, station.company_name as name, sproduct.available as qty, "station" as type FROM station JOIN stationsproduct ON station.id = stationsproduct.station_id JOIN sproduct ON stationsproduct.sproduct_id = sproduct.id WHERE sproduct.product_id = ' . $id));
        return json_encode($inventory);
    }
	
    public function productinventoryhigh($id){
        $inventory = DB::select(DB::raw('SELECT DISTINCT(station.id) as id, station.company_name as name, sproduct.available as qty, "station" as type FROM station JOIN stationsproduct ON station.id = stationsproduct.station_id JOIN sproduct ON stationsproduct.sproduct_id = sproduct.id WHERE sproduct.product_id = ' . $id . ' AND sproduct.available >= (sproduct.stock*0.3)'));
        return json_encode($inventory);
    }		
	
    public function productinventorylow($id){
        $inventory = DB::select(DB::raw('SELECT DISTINCT(station.id) as id, station.company_name as name, sproduct.available as qty, "station" as type FROM station JOIN stationsproduct ON station.id = stationsproduct.station_id JOIN sproduct ON stationsproduct.sproduct_id = sproduct.id WHERE sproduct.product_id = ' . $id . ' AND sproduct.available < (sproduct.stock*0.3)'));
        return json_encode($inventory);
    }		
}