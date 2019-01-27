<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Models\User;
use App\Models\Product;
use App\SProduct;
// use App\User;
use App\Models\StationProduct;
use App\Models\Station;

class InventoryController extends Controller
{
	protected $station_id;

	public function __construct()
	{
		# code...
        if (!Auth::check()) {
            # code...
            return "Login required";
        }
        $user_id=Auth::user()->id;
        try {
            $this->station_id= DB::table('station')->
				where('user_id',$user_id)->pluck('id');

            //return $this->index($station_id);
        } catch (\Exception $e) {
            return "Error redirecting to station: $e";
        }
	}

    public function redirect($uid = null)
    {
        # code...
        if (!Auth::check()) {
            # code...
            return "Login required";
        }
        if(is_null($uid)){
			$user_id = Auth::id();
		} else {
			$user_id = $uid;
		}
        try {
            $station_id= DB::table('station')->
				where('user_id',$user_id)->pluck('id');

            return $this->index($station_id, $user_id);

        } catch (\Exception $e) {
            return "Error redirecting to station: $e";
        }
    }

	public function inventory_all($merchantid, $stationid)
    {
		// $sproducts = DB::table('sproduct')->
		// 	join('stationsproduct','sproduct.id','=',
		// 		'stationsproduct.sproduct_id')->
		// 	join('product','sproduct.product_id','=','product.id')->
		// 	join('merchantproduct','merchantproduct.product_id','=',
		// 		'product.parent_id')->
		// 	where('merchantproduct.merchant_id',$merchantid)->
		// 	where('stationsproduct.station_id',$stationid)->
		// 	select(
		// 		'product.id as productid',
		// 		'product.photo_1 as photo_1',
		// 		'product.name as productname',
		// 		'sproduct.available as qtyleft',
		// 		'sproduct.stock as qtystock')->
		// 	get();
			$sproducts=DB::select(DB::raw("
			SELECT
			product.id as productid,
			product.parent_id as parent_id,
			product.photo_1 as photo_1,
			product.name as productname,
			sproduct.available as qtyleft,
			sproduct.stock as qtystock
			FROM 
			sproduct
			JOIN stationsproduct on stationsproduct.sproduct_id=sproduct.id
			JOIN product on sproduct.product_id = product.id
			JOIN merchantproduct on merchantproduct.product_id =
				product.parent_id
			WHERE
			
			merchantproduct.merchant_id = ".$merchantid." AND
			stationsproduct.station_id = ".$stationid."
			"));
		
		return view('inventoryall')
                ->with('sproducts',$sproducts);
	}
	
	public function inventory_low($merchantid, $stationid)
    {
    	// Converted to raw query by Zurez
		// $sproducts = DB::table('sproduct')->
		// 	join('stationsproduct','sproduct.id','=',
		// 		'stationsproduct.sproduct_id')->
		// 	join('product','sproduct.product_id','=','product.id')->
		// 	join('merchantproduct','merchantproduct.product_id','=',
		// 		'product.parent_id')->
		// 	where('merchantproduct.merchant_id',$merchantid)->
		// 	where('stationsproduct.station_id',$stationid)->
		// 	where('sproduct.available','<','(sproduct.stock*30)/100')->
		// 	select('product.id as productid', 'product.photo_1 as photo_1',
		// 		'product.name as productname','sproduct.available as qtyleft',
		// 		'sproduct.stock as qtystock')->
		// 	get();
			$sproducts=DB::select(DB::raw("
			SELECT
			product.id as productid,
			product.parent_id as parent_id,
			product.photo_1 as photo_1,
			product.name as productname,
			sproduct.available as qtyleft,
			sproduct.stock as qtystock
			FROM 
			sproduct
			JOIN stationsproduct on stationsproduct.sproduct_id=sproduct.id
			JOIN product on sproduct.product_id = product.id
			JOIN merchantproduct on merchantproduct.product_id =
				product.parent_id
			WHERE
			sproduct.available < (sproduct.stock*30)/100 AND
			merchantproduct.merchant_id = ".$merchantid." AND
			stationsproduct.station_id = ".$stationid."
			"));
		return view('inventorylow')
                ->with('sproducts',$sproducts);		
	}

	public function inventory_high($merchantid, $stationid)
    {
    	// Converted to raw query by Zurez
		// $sproducts = DB::table('sproduct')->
		// 	join('stationsproduct','sproduct.id','=',
		// 		'stationsproduct.sproduct_id')->
		// 	join('product','sproduct.product_id','=','product.id')->
		// 	join('merchantproduct','merchantproduct.product_id','=',
		// 		'product.parent_id')->
		// 	where('merchantproduct.merchant_id',$merchantid)->
		// 	where('stationsproduct.station_id',$stationid)->
		// 	where('sproduct.available','>=','(sproduct.stock*30)/100')->
		// 	select('product.id as productid', 'product.photo_1 as photo_1',
		// 		'product.name as productname','sproduct.available as qtyleft',
		// 		'sproduct.stock as qtystock')
		// 	->
		// 	get();
		$sproducts=DB::select(DB::raw("
			SELECT
			product.id as productid,
			product.photo_1 as photo_1,
			product.parent_id as parent_id,
			product.name as productname,
			sproduct.available as qtyleft,
			sproduct.stock as qtystock
			FROM 
			sproduct
			JOIN stationsproduct on stationsproduct.sproduct_id=sproduct.id
			JOIN product on sproduct.product_id = product.id
			JOIN merchantproduct on merchantproduct.product_id =
				product.parent_id
			WHERE
			sproduct.available >= (sproduct.stock*30)/100 AND
			merchantproduct.merchant_id = ".$merchantid." AND
			stationsproduct.station_id = ".$stationid."
			"));
		
		return view('inventoryhigh')->
			with('sproducts',$sproducts);		
	}	
	
    public function addproduct(Request $request)
    {
		$station_id= DB::table('station')->
			where('user_id', $request->get('sid'))->pluck('id');

		$sp_id = DB::table('sproduct')->
			insertGetId([
				'available'=>0,
				'status'=>'pending',
				'stock'=>0,
				'shipping_cost'=>0,
				'product_id'=>$request->get('id'),
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=>date('Y-m-d H:i:s')
			]);

		$sps_id = DB::table('stationsproduct')->
			insert([
				'station_id'=>$station_id,
				'sproduct_id'=>$sp_id,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=>date('Y-m-d H:i:s')
			]);

		return json_encode("ok");
	}
	
    public function updateinv(Request $request)
    {
		$ssp = DB::table('stationsproduct')->
			where('id',$request->
			get('id'))->
			first();

		$sps_id = DB::table('sproduct')->
			where('id',$ssp->sproduct_id)->
			update([
				'available' => $request->get('qty'),
				'updated_at' => date("Y-m-d H:i:s")
			]); 

		return json_encode("ok");
	}
	
    public function addoffer(Request $request)
    {
		$sps_id = DB::table('stationsproduct')->
			where('id',$request->
			get('id'))->
			update([
				'fair_commission' => $request->get('offer'),
				'updated_at' => date("Y-m-d H:i:s")
			]);		
		return json_encode("ok");
	}	
	
    public function add_product($uid = null)
    {
		//dump("uid=$uid");
        # code...
        if (!Auth::check()) {
            # code...
            return "Login required";
        }
		if(is_null($uid)){
			$user_id=Auth::user()->id;
		} else	{	
			$user_id=$uid;
		}
        		
		try {
            $station_id= DB::table('station')->
				where('user_id',$user_id)->pluck('id');
			//dump("station_id=$station_id");

			 $product_ids= DB::table('product')
			->join('category','product.category_id','=','category.id')
			->join('product as parent','product.parent_id','=','parent.id')
			->join('wholesale', 'product.id', '=', 'wholesale.product_id')
			->join('merchantproduct', 'product.parent_id', '=',
				'merchantproduct.product_id')
			->join('autolink', 'merchantproduct.merchant_id', '=',
				'autolink.responder')
			->where('autolink.initiator', '=', $user_id)
			->where('autolink.status', '=', 'linked')
		//	->where('product.oshop_selected', '=', 1)
			->where('product.available', '>', 0)
			->where('parent.status', '=', 'active')
			->whereRaw('NOT EXISTS (
				SELECT sproduct.id
				FROM sproduct, stationsproduct
				WHERE sproduct.id = stationsproduct.sproduct_id
				AND stationsproduct.station_id = ' . $station_id . '
				AND sproduct.product_id = product.parent_id)')
			->whereRaw('NOT EXISTS (
					SELECT product.id
					FROM productblacklist
					WHERE product.parent_id = productblacklist.product_id AND productblacklist.user_id = ' . $user_id . '
					)
				')
			->where('product.segment', '=', 'b2b')
			->lists('product.parent_id');			
			
			$products= DB::table('product')->whereIn('id',$product_ids)->
				select([
					'product.id AS product_id',
					'product.name',
					'product.subcat_id',
					'product.available',
					'product.retail_price',
					'product.discounted_price'
				])->distinct()->get();

			//dd($products);
			$selluser = User::find($user_id);
			return view('station.inventory-update-add')->
			with('products',$products)->
			with('selluser',$selluser);			
        } catch (\Exception $e) {
            return $e;
            return "Error redirecting to station";
        }		
	}	
	
    public function list_product($uid = null)
    {
        # code...
        if (!Auth::check()) {
            # code...
            return "Login required";
        }
		if(is_null($uid)){
			$user_id = Auth::id();
		} else {
			$user_id = $uid;
		}
		try {
            $station_id= DB::table('station')->
				where('user_id',$user_id)->pluck('id');

			$products= DB::table('product')
			->join('category','product.category_id','=','category.id')
			->join('product as parent','product.parent_id','=','parent.id')
			->join('wholesale', 'product.id', '=', 'wholesale.product_id')
			->join('merchantproduct', 'product.parent_id', '=', 'merchantproduct.product_id')
			->join('merchant', 'merchant.id', '=', 'merchantproduct.merchant_id')
			->join('autolink', 'merchantproduct.merchant_id', '=', 'autolink.responder')
			->join('sproduct', 'merchantproduct.product_id', '=', 'sproduct.product_id')
			->join('stationsproduct', 'stationsproduct.sproduct_id', '=', 'sproduct.id')
			->where('autolink.initiator', '=', $user_id)
			->where('autolink.status', '=', 'linked')
		//	->where('product.oshop_selected', '=', 1)
			->where('parent.status', '=', 'active')
			->where('stationsproduct.station_id', '=', $station_id)	
			->where('product.segment', '=', 'b2b')
		//	->where('product.available', '>', 0)
	//            ->where('sorder.id', '=', 1)
				->select([
					'product.id AS product_id',
					'product.parent_id AS parent_id',
					'product.name',
					'stationsproduct.station_id',
					'stationsproduct.id as sspid',
					'stationsproduct.fair_commission',
					'product.subcat_id',
					'product.osmall_commission as product_commission',
					'merchant.osmall_commission as merchant_commission',
					'sproduct.available',
					'product.available as av',
					'product.retail_price',
					'product.photo_1',
					'product.discounted_price'
				])
				->distinct()
				->get();		
			/*
			$products= DB::table('product')->join('sproduct','sproduct.product_id','=','product.id')
						->join('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')
						->join('merchantproduct','product.id','=','merchantproduct.product_id')
						->join('merchant','merchant.id','=','merchantproduct.merchant_id')
						->where('stationsproduct.station_id',$station_id)
						->whereIn('product.id',$product_ids)->select([
                            'product.id AS product_id',
                            'product.name',
                            'stationsproduct.station_id',
                            'stationsproduct.id as sspid',
                            'stationsproduct.fair_commission',
                            'product.subcat_id',
                            'product.osmall_commission as product_commission',
                            'merchant.osmall_commission as merchant_commission',
                            'sproduct.available',
                            'product.retail_price',
                            'product.photo_1',
                            'product.discounted_price'
                        ])
						->distinct()->get();*/
			//dd($products);

			$global_vars = DB::table('global')->first();
			$selluser = User::find($user_id);

			return view('station.inventory-update-list')->
				with('products',$products)->
				with('global_vars',$global_vars)->
				with('selluser',$selluser);			

        } catch (\Exception $e) {
            return $e;
            return "Error redirecting to station";
        }		
	}		
	
    public function index($station_id, $user_id)
    {
		$categoryList= DB::table('product')
        ->join('category','product.category_id','=','category.id')
        ->join('product as parent','product.parent_id','=','parent.id')
        ->join('wholesale', 'product.id', '=', 'wholesale.product_id')
		->join('merchantproduct', 'product.parent_id', '=', 'merchantproduct.product_id')
		->join('merchant', 'merchant.id', '=', 'merchantproduct.merchant_id')
		->join('autolink', 'merchantproduct.merchant_id', '=', 'autolink.responder')
		->join('sproduct', 'merchantproduct.product_id', '=', 'sproduct.product_id')
		->join('stationsproduct', 'stationsproduct.sproduct_id', '=', 'sproduct.id')	
		->where('autolink.initiator', '=', $user_id)
		->where('autolink.status', '=', 'linked')
	//	->where('product.oshop_selected', '=', 1)
		->where('stationsproduct.station_id', '=', $station_id)	
	//	->where('sproduct.status', '=', 'active')	
	//	->where('sproduct.available', '>', 0)		
		->where('product.segment', '=', 'b2b')
		->where('parent.status', '=', 'active')
        ->groupBy('category.name')
        ->get(['product.category_id']);
		//dd($categoryList);

		$activelist = array();
		$tt = 0;
		foreach($categoryList as $catlist){
			$activelist[$tt] = $catlist->category_id;
			$tt++;
		}
        $sub_cats=array();
        $product_ids=array();
        //Get all products
        // $sproduct_ids= DB::table('stationsproduct')->where('station_id',$station_id)->lists('sproduct_id');

         $product_ids= DB::table('product')
        ->join('category','product.category_id','=','category.id')
        ->join('product as parent','product.parent_id','=','parent.id')
        ->join('wholesale', 'product.id', '=', 'wholesale.product_id')
		->join('merchantproduct', 'product.parent_id', '=', 'merchantproduct.product_id')
		->join('merchant', 'merchant.id', '=', 'merchantproduct.merchant_id')
		->join('autolink', 'merchantproduct.merchant_id', '=', 'autolink.responder')
		->join('sproduct', 'merchantproduct.product_id', '=', 'sproduct.product_id')
		->join('stationsproduct', 'stationsproduct.sproduct_id', '=', 'sproduct.id')	
		->where('autolink.initiator', '=', $user_id)
		->where('autolink.status', '=', 'linked')
	//	->where('product.oshop_selected', '=', 1)
		->where('stationsproduct.station_id', '=', $station_id)	
	//	->where('sproduct.status', '=', 'active')	
	//	->where('sproduct.available', '>', 0)		
		->where('product.segment', '=', 'b2b')
		->where('parent.status', '=', 'active')->lists('product.id');
        $products= DB::table('product')->
			whereIn('id',$product_ids)->
			select('product.id as id',
				'product.name as name',
				'product.subcat_id as subcat_id',
				'product.subcat_level as subcat_level',
				'product.photo_1 as photo_1')->
			get();

		//dd($products);
        $new_products=array();
        // return $products;

        foreach ($products as $k) {
            # code...
            $level= $k->subcat_level;

            $sproduct=DB::table('sproduct')->
				where('product_id',$k->id)->first();

            // dd($sproduct);
			if(!is_null($sproduct)){

				$avlbl=$sproduct->available;
				$k->available=$sproduct->available;
				$stock= $sproduct->stock;
				// 30% logic
				$limit= 0.3 * $stock;
				if ($avlbl<$limit) {
					# code...
					$k->class="warning";
				}
				else{
					$k->class="ok";
				}				
			} else {
				$avlbl=0;
				$k->available=0;
				$stock= 0;
				$k->class="ok";
			}

            array_push($new_products, $k);

            $table="subcat_level_".$level;
            // dd($k);
            try {
            $subcat=DB::table($table)->where('id',$k->subcat_id)->first();

           
			$subcat->level = $level;
            
	            if (!in_array($subcat, $sub_cats)) {
	                # code...
	                if (!is_null($subcat)) {
	                    # code...
	                    array_push($sub_cats,$subcat);
	                }

	            }
            } catch (\Exception $e) {
            	
            }


        }
		
		$selluser = User::find($user_id);
		$categories = DB::table('category')->where('enable',true)->get();
		//dd($sub_cats);
        return view('station.inventory-update')->
			with('products',$new_products)->
			with('subcats',$sub_cats)->
			with('categories',$categories)->
			with('selluser',$selluser)->
			with('activelist',$activelist)->
			with('station_id',$station_id)->
			with('categoryList',$categoryList);

    }

    public function test()
    {
        # code...
        return view('station.inventory-report');
    }

	public function products($cat_leve, $cat_id)
	{

	}

    // AJAX
    //Need to fix security loopholes
    public function prajax($product_id)
    {
        if (!Auth::check()) {
            # code...
            return response()->json(['status'=>'failure']);

        }
        try{
            $product=Product::find($product_id);
            $level= $product->subcat_level;
            $photo=$product->photo_1;
            $table="subcat_level_".$level;
            $subcat=DB::table($table)->where('id',$product->subcat_id)->first();
            $sproduct= DB::table('sproduct')->
				where('product_id',$product_id)->first();

            $oprice= $product->retail_price;
            $rprice= $product->discounted_price;
            $avlbl=$sproduct->available;
            $stock= $product->stock;
            // 30% logic
            $limit= 0.3 * $stock;
            if ($avlbl<=$limit) {
                # code...
                $warning="true";
            }
            else if($avlbl>$limit){
                $warning="false";
            }
            else{
                $warning="wrpng";
            }
            return response()->json([
				'status' => 'success',
				'id'=>$product_id,
				'photo'=>$photo,
                'name'=>$product->name,
				'subcat'=>$subcat->name,
                'available'=>$avlbl,
                'warning'=>$warning,
                'oprice'=>$oprice,
				'rprice'=>$rprice
			]);
        }
        catch (Exception $e) {
            return response()->json(['status'=>'failure']);
        }
    }
    public function prajaxneutral($station_id, $product_id)
    {
        # code...
        try {

            $s= Sproduct::join(
				'stationsproduct',
				'stationsproduct.sproduct_id','=','sproduct.id')->
				where('stationsproduct.station_id',$station_id)->
				where('sproduct.product_id',$product_id)->
				select('sproduct.*')->
				first();

           // $s=Sproduct::find($sproduct_id);
          /*  if ($s->available==0) {
                # code...
                return response()->json([
					'status'=>'illegal_count',
					'count'=>$s->available
				]);
            }*/

            $s->available=$s->available;

            $s->save();
            $p= Product::find($s->product_id);
            $avlbl=$s->available;
            $stock= $s->stock;
            // 30% logic
            $limit= 0.3 * $stock;
            if ($avlbl<$limit) {
                # code...
                $warning="true";
            }
            else{
                $warning="false";
            }
            return response()->json([
				'status'=>'success',
				'count'=>$s->available,
				'warning'=>$warning,
				'product'=>$p]);
        } catch (Exception $e) {
            return response()->json(['status'=>'failure','message'=>$e]);
        }
    }	
	
    public function prajaxdel($station_id, $product_id)
    {
        # code...
        try {
			$s= Sproduct::join('stationsproduct',
					'stationsproduct.sproduct_id','=','sproduct.id')->
				where('stationsproduct.station_id',$station_id)->
				where('sproduct.product_id',$product_id)->
				select('sproduct.*')->
				first();

            if ($s->available==0) {
                # code...
                return response()->json([
					'status'=>'illegal_count',
					'count'=>$s->available
				]);
            }
            $s->available=$s->available-1;

            $s->save();
            $p= Product::find($s->product_id);
            $avlbl=$s->available;
            $stock= $s->stock;
            // 30% logic
            $limit= 0.3 * $stock;
            if ($avlbl<$limit) {
                # code...
                $warning="true";
            }
            else{
                $warning="false";
            }
            return response()->json([
				'status'=>'success',
				'count'=>$s->available,
				'warning'=>$warning,
				'product'=>$p
			]);

        } catch (Exception $e) {
            return response()->json(['status'=>'failure','message'=>$e]);
        }
    }

    public function prajaxadd($station_id, $product_id)
    {
        # code...
        try {

            $s= Sproduct::join('stationsproduct',
				'stationsproduct.sproduct_id','=','sproduct.id')->
				where('stationsproduct.station_id',$station_id)->
				where('sproduct.product_id',$product_id)->
				select('sproduct.*')->
				first();
			// Validation to prevent adding more than stock.
			/*if ($s->available >= $s->stock) {
				# Cannot add further;
				return response()->json(['status'=>'failure','long_message'=>'You cannot add more product.']);
			}*/
            $p= Product::find($s->product_id);

            $s->available=$s->available+1;

            $s->save();

            $avlbl=$s->available;
            $stock= $s->stock;
            // 30% logic
            $limit= 0.3 * $stock;
            if ($avlbl<$limit) {
                # code...
                $warning="true";
            } else{
                $warning="false";
            }

            return response()->json([
				'status'=>'success',
				'count'=>$s->available,
				'warning'=>$warning,
				'product'=>$p
			]);

        } catch (\Exception $e) {
            return response()->json(['status'=>'failure']);
        }
    }

	public function page(Request $request)
	{
		//dd($request->get('userid'));
		$station = DB::table('station')->where('user_id', $request->get('userid'))->first();
		$station_id = $station->id;
		$products = DB::table('product')
			->select('sproduct.*')

			->addSelect('product.name as product_name')
			->addSelect('product.id as product_id')
			->addSelect('product.parent_id as parent_id')
			->addSelect('product.description as product_description')
			->addSelect('product.photo_1 as product_image')
			->addSelect('nproductid.nproduct_id as formatted_product_id')
			->join('category','product.category_id','=','category.id')
			->join('product as parent','product.parent_id','=','parent.id')
			->join('wholesale', 'product.id', '=', 'wholesale.product_id')
			->join('merchantproduct', 'product.parent_id', '=', 'merchantproduct.product_id')
			->join('merchant', 'merchant.id', '=', 'merchantproduct.merchant_id')
			->join('autolink', 'merchantproduct.merchant_id', '=', 'autolink.responder')
			->join('sproduct', 'merchantproduct.product_id', '=', 'sproduct.product_id')
			->join('stationsproduct', 'stationsproduct.sproduct_id', '=', 'sproduct.id')	
			->leftJoin('nproductid','nproductid.product_id','=','product.id')
			->where('autolink.initiator', '=', $request->get('userid'))
			->where('autolink.status', '=', 'linked')
		//	->where('product.oshop_selected', '=', 1)
			->where('stationsproduct.station_id', '=', $station_id)	
			//->where('sproduct.status', '=', 'active')	
			//->where('sproduct.available', '>', 0)	
			->where('product.category_id', '=', $request->get('category_id'))	
			->where('product.segment', '=', 'b2b')
			->where('parent.status', '=', 'active')
			->groupBy('sproduct.id')
			;		
		/*foreach ($request->except('page') as $field => $value) {
			$products->where($field, '=', $value);
		}*/
		$result = $products->distinct()->get();
		return response()->json($result);
	}

	/*public function merchant_inventory($uid = null){
        $user_id = Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole('adm')){
            $user_id=$uid;
        }

        $selluser = User::find($user_id);
        Log::debug('selluser_id=' .$user_id);

        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $merchant_id = $merchant->id;
        Log::debug($merchant_id);

        $results = DB::table('product')
            ->leftJoin('locationproduct','product.id','=','locationproduct.product_id')
            ->join('fairlocation','locationproduct.location_id','=','fairlocation.id')
            ->leftJoin('inventorycostproduct','product.id','=','inventorycostproduct.product_id')
            ->join('merchantproduct','merchantproduct.product_id','=','product.id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->where('merchant.id',$merchant_id)
            ->select('product.id','product.name','product.available', 'fairlocation.id as location_id','locationproduct.quantity')
            ->selectRaw('
                            inventorycostproduct.cost * inventorycostproduct.quantity /inventorycostproduct.quantity  as average_cost
                        ')

            ->selectRaw('product.available + locationproduct.quantity as total')
            ->groupBy('product.name')
            ->orderBy('product.id','ASC')
            ->distinct()
            ->get();

        return view('merchant.inventory',compact('results'));

    }*/


}
