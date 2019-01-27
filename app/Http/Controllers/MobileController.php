<?php

namespace App\Http\Controllers;

use App;
use App\Models\Adslot;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MobileController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $pro = new Product();
        $adSlotObj = new Adslot();
        $catObj = new Category();
        $merchant = new Merchant();
        $currency = null;

        if(!is_null(Currency::where('active',true)->first())){
            $currency = Currency::where('active',true)->first()->code;
        }

        // Get Products from Oshop
        /*
            ->where('product.oshop_selected',true)
            ->where('product.available','>',0)
            ->where('product.status','active')
            ->where('product.retail_price','>',0)
        */ 

        /* getting all products for all slots(currently we have 7 slots) */
        $adSlot_data = $adSlotObj->with(['products'])->get(); /* t1-t7 */

        // dd($adSlot_data[4]['products'][0]);

        $category_temp_data = $catObj->
			orderBy('floor')->
			get(); 

        //return $category_temp_data;

        $category_data = [];
		//dd($category_temp_data);
		$floor = 1;
        foreach ($category_temp_data as $cat_id) {	
		
            $cat_latest_product = $pro->where('product.category_id', '=',$cat_id['id'])
				->select('product.*')
				->join('merchantproduct','product.id','=','merchantproduct.product_id')
				->join('merchant','merchantproduct.merchant_id','=','merchant.id')
				->join('oshopproduct','oshopproduct.product_id','=','product.id')
				->join('oshop','oshopproduct.oshop_id','=','oshop.id')
				->where('product.oshop_selected', '=', true)
                ->where('product.available','>',0)
                ->where('product.status','active')
                ->where('oshop.status','active')
                ->where('product.retail_price','>',0)
				->where('merchant.status', '=', 'active')
				->orderBy('product.created_at')
                ->take(1)
                ->pluck('thumb_photo2');

				//dd($cat_latest_product);
			// $cat_latest_product = $oShopPro->with('products')->find($cat_id)->orderBy('created_at')->take(1)->pluck('photo_1');

            $cat_latest_product_id = $pro->where('product.category_id', '=',$cat_id['id'])
				->select('product.*')
				->join('merchantproduct','product.id','=','merchantproduct.product_id')
				->join('merchant','merchantproduct.merchant_id','=','merchant.id')
				->join('oshopproduct','oshopproduct.product_id','=','product.id')
				->join('oshop','oshopproduct.oshop_id','=','oshop.id')
				->where('product.oshop_selected', '=', true)

                ->where('product.available','>',0)
                ->where('product.status','active')
                ->where('oshop.status','active')
                ->where('product.retail_price','>',0)
				->where('merchant.status', '=', 'active')
				->orderBy('product.created_at')
                ->take(1)
                ->pluck('id');
				//dump($cat_latest_product_id);

			$cat_latest_product_val = 0;
			if(!is_null($cat_latest_product_id)){
				$cat_latest_product_val = $cat_latest_product_id;
			}

			$oShopPro = DB::table('merchantproduct')
				->select('product.*')
                ->join('product','merchantproduct.product_id','=','product.id')
				->join('merchant','merchantproduct.merchant_id','=','merchant.id')
				->join('oshopproduct','oshopproduct.product_id','=','product.id')
				->join('oshop','oshopproduct.oshop_id','=','oshop.id')
				->where('product.oshop_selected', '=', true)
				->where('product.status', '=', 'active')	
				->where('oshop.status', '=', 'active')	
                ->where('product.segment', '=', 'b2c')		
                ->where('product.available', '>', '0')		
                ->where('product.retail_price', '>', '0')	
				->where('merchant.status', '=', 'active')
             //   ->where('product.id', '<>', $cat_latest_product_val)		
                ->where('product.category_id', '=', $cat_id['id'])
				->orderByRaw("RAND()")
				->limit(6);					
			//dump($oShopPro);
				
            $rand_pro=array();
			
            foreach ($oShopPro->get() as $p) {
                # code...
				//dd($p);
				if(!is_null($p)){
					$productId=$p->id;
					array_push($rand_pro, $productId);					
				}
            }

			$rand_pro = array_unique($rand_pro);
			//dump($rand_pro);

            $cat_random_product=DB::table('merchantproduct')
				->join('product','merchantproduct.product_id','=','product.id')
				->select('product.*','merchantproduct.product_id')
				->join('merchant','merchantproduct.merchant_id','=','merchant.id')
				->whereIn('product.id',$rand_pro)
				->where('product.oshop_selected','=',true)
                ->where('product.available','>',0)
                ->where('product.status','active')
				->where('merchant.status', '=', 'active')
                ->where('product.retail_price','>',0)
				->where('product.category_id',$cat_id['id'])->get();

            $cat_products_random_photos = [];

            foreach ($cat_random_product as $photo)
                $cat_products_random_photos[] = $photo;
				
			//dd($cat_random_product);

        /*    $category_data[] = ['color' => $cat_id['color'],
				'floor' => $cat_id['floor'],
				'name' => $cat_id['name'],
				'desc' => $cat_id['description'],
				'category_id' => $cat_id['id'],
				'logo_white' => $cat_id['logo_white'],
				'latest_photo_id' => $cat_latest_product_id,
				'latest_photo' => $cat_latest_product,
				'random_photos' => $cat_products_random_photos
            ];*/
		//	$endcategory = end($category_data);
			//dump($cat_products_random_photos);
			if(count($cat_products_random_photos) > 0 || !is_null($cat_latest_product_id)){
				DB::table('category')->
				where('id',$cat_id['id'])->
				update(['floor'=>$floor,'enable'=>true, 'color'=>$cat_id['original_color']]);
				$floor++;
				$category_data[] =['color' => $cat_id['original_color'],
					'floor' => $cat_id['floor'],
					'name' => $cat_id['name'],
					'desc' => $cat_id['description'],
					'category_id' => $cat_id['id'],
					'isenable' => 1,
					'logo_white' => $cat_id['logo_white'],
					'latest_photo_id' => $cat_latest_product_id,
					'latest_photo' => $cat_latest_product,
					'random_photos' => $cat_products_random_photos];				
			} else {
				$category_data[] =['color' => $cat_id['color'],
					'floor' => $cat_id['floor'],
					'name' => $cat_id['name'],
					'desc' => $cat_id['description'],
					'category_id' => $cat_id['id'],
					'isenable' => 0,
					'logo_white' => $cat_id['logo_white'],
					'latest_photo_id' => $cat_latest_product_id,
					'latest_photo' => $cat_latest_product,
					'random_photos' => $cat_products_random_photos];					
			}
			
        }
		//dd($floor);
		//foreach($category_data as $categories){
		//	if($categories['isenable']==0){
		//		DB::table('category')->where('id',$categories['category_id'])->update(['floor'=>        $floor,'enable'=>false,                                                                'color'=>'#AAAAAA']);
		//		$floor++;
		//	}	
		//}
		//dd(end($category_data));
        $result = [];
        foreach($category_data as $item )
             foreach($item['random_photos'] as $product)
                $result[] =  $product;
        return response()->json($result);
        // return view('landing_page',
		// 	compact(['adSlot_data', 'category_data']))->
		// 	with('currency',$currency);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
