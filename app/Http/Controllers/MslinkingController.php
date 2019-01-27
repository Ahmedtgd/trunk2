<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Classes\MsLinking;


class MslinkingController extends Controller
{
    public function __construct(MsLinking $msLinking)
    {
        $this->msLinking = $msLinking;
    }

	public function enable_product(Request $request)
    {
		$dataenable = json_decode($request->get('dataenable'));
		$this->msLinking->pEnable($dataenable);
		return response()->json([
            'message'=>'Enable is successful',
            'status'=>true
        ]);
	}
	
    public function autolink(Request $request)
    {
        $stations = json_decode($request->get('stations'));
        $spoutlets = json_decode($request->get('spoutlets'));
		$stationsenable = json_decode($request->get('stationsenable'));
        $spoutlets = json_decode($request->get('spoutlets'));
        $spoutletsenable = json_decode($request->get('spoutletsenable'));
        $action = $request->get('action');
        $merchant_id = $request->get('merchant_id');

        if(!is_array($stations)){
            return response()->json([
                'message'=>'No station was selected',
                'status'=>false,
            ]);
        }

        $all_stations = ($action == 'link')
            ? $this->msLinking->doAutolink($stations, $spoutlets,$stationsenable,$spoutletsenable, $merchant_id)
            : $this->msLinking->doEnable($stations, $spoutlets);

        return response()->json([
            'message'=>'Linking is successful',
            'status'=>true,
            'data'=> is_array($all_stations) ? $all_stations : [],
        ]);
    }

	public function products($uid, $mid)
    {
		$products = array();
		$station = DB::table('station')->where('user_id',$uid)->first();
		if(!is_null($station)){
		$products = DB::table('product')
        ->join('category','product.category_id','=','category.id')
		->join('merchantproduct', 'product.parent_id', '=', 'merchantproduct.product_id')
		->join('merchant', 'merchant.id', '=', 'merchantproduct.merchant_id')
		//->leftJoin('sproduct', 'merchantproduct.product_id', '=', 'sproduct.product_id')
		/*->leftJoin('stationsproduct', function($join) use ($station) {
			 $join->on('stationsproduct.sproduct_id', '=', 'sproduct.id')
			 ->where('stationsproduct.station_id','=',$station->id);
		 })*/
		->leftJoin('productblacklist', function($join) use ($uid) {
			 $join->on('productblacklist.product_id', '=', 'product.id')
			 ->where('productblacklist.user_id','=',$uid);
		 })
		->where('product.segment', '=', 'b2c')
		->where('product.status', '!=', 'transferred')
		->whereNull('product.deleted_at')
		->where('merchantproduct.merchant_id', '=', $mid)
//            ->where('sorder.id', '=', 1)
                        ->select([
                            'product.id AS product_id',
                            'product.name AS name',
                            'product.parent_id AS parent_id',
                            'product.osmall_commission',
                            'product.status',
                            'product.available',
                           /* 'stationsproduct.fair_commission',
                            'stationsproduct.enabled',
                            'stationsproduct.id as sid',*/
                            'product.subcat_id',
                            'product.available',
                            'product.retail_price',
                            'product.photo_1',
                            'productblacklist.id as blacklist_id',
                            'product.discounted_price',
							'merchant_id',
							'merchant.user_id as muid',
							'merchant.osmall_commission as merchant_osmall_commission'
                        ])
						->orderBy('product.created_at','DESC')
						->distinct()
						->get();
			foreach($products as $product){
				$wholesales = [];
				$wi = 0;
				$b2bproduct = DB::table('product')->where('parent_id',$product->product_id)->where('product.segment', '=', 'b2b')->first();
				if(!is_null($b2bproduct)){
					$wws = DB::table('wholesale')->where('product_id',$b2bproduct->id)->orderBy('funit','ASC')->get();
					foreach($wws as $ww){
						$wholesales[$wi]['funit'] = $ww->funit;
						$wholesales[$wi]['unit'] = $ww->unit;
						$wholesales[$wi]['price'] = $ww->price;
						$wi++;
					}
				}
				$product->wholesales = $wholesales;
			}
		}
		//dd($products);
		return view('admin.general.pmslinking',[
            'products' => $products,
            'uid' => $uid
        ]);
	}
	
    public function index()
    {
        $station_types = $this->msLinking->station_type();

        $stations = $this->msLinking->station();

        $merchants =  $this->msLinking->merchant();

		$brands = DB::table('brand')->orderBy('description')->get();
		
		$products = DB::table('subcat_level_2')->orderBy('description')->get();
		
		$oshops = DB::table('oshop')->where('single',0)->orderBy('oshop_name')->get();
		//dd($oshops);
        return view('admin.general.mslinking',[
            'merchants' => $merchants,
            'stations' => $stations,
            'brands' => $brands,
            'oshops' => $oshops,
            'products' => $products,
            'station_types' => $station_types
        ]);
    }

    public function filter(Request $request)
    {
        $merchant_id = $request->get('merchant');
        $station_type_id = $request->get('station_type');
        $station_character = $request->get('station_character');
        $brands = $request->get('brands');
        $products = $request->get('products');
        $oshops = $request->get('oshops');
        $station_id = $request->get('station_id');

        $stations = $this->msLinking->
			station_filter($merchant_id, $station_type_id, $station_character, $brands, $products, $oshops, $station_id);

        return response()->json([
            'message'=>'',
            'status'=>true,
            'data' => is_array($stations) ? $stations : []
        ]);
    }
}
