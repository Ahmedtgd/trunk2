<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\AdvertisementRepo;
use App\Http\Requests\AdvertisementRequest;
use App\Models\Advertisement;
use App\Models\AdTarget;
use Illuminate\Http\Request;
use Validator;
use Input;
use DB;
use File;
use App;
use App\Models\Adslot;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\Currency;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\global_landing;

class AdvertisementController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected $repo;
	function __construct(AdvertisementRepo $repo) {
		$this->repo = $repo;
	}
	
	public function save_landing_slider(Request $request)
    {
		$AdTarget=AdTarget::where('route','/')->first();
		$name = $request->get('slider_name');
		$url = $request->get('slider_url');
		$price = $request->get('slider_price');
		$slider = $request->get('slider_number');
		$adslot_id = 3;
		$slot = DB::table('adslot')->where('adtarget_id','=',$AdTarget->id)->where('placement','A1')->first();
		if(!is_null($slot)){
			$adslot_id = $slot->id;
		}
		$advertexists = DB::table('advertisement')->where('adslot_id',$adslot_id)->where('slider',$slider)->first();
		if(is_null($advertexists)){
			$advert = DB::table('advertisement')->insertGetId(['name'=> $name, 'slider'=>$slider,'url'=> $url, 'price'=>$price * 100, 'adslot_id'=>$adslot_id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=> date('Y-m-d H:i:s')]);
		} else {
			$advert = $advertexists->id;
			DB::table('advertisement')->where('id',$advert)->update(['name'=> $name, 'url'=> $url, 'price'=>$price * 100, 'updated_at'=> date('Y-m-d H:i:s')]);
		}
		$folder = base_path() . '/public/images/advertisement/' . $advert;
        File::makeDirectory($folder, 0777, true, true);
        $destination = $folder . '/';
        //chmod($folder,0775);
        $image = $request->file('slider_image');
		
        if (isset($image)) {		
            $image_name = $image->getClientOriginalName();
            if ($image->move($destination, $image_name)) {
				$adimageexists = DB::table('adimage')->where('advertisement_id',$advert)->first();
				
				if(is_null($adimageexists)){
					DB::table('adimage')->insert(['path'=>$image_name,'adcontrol_id'=>0,'advertisement_id'=>$advert, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=> date('Y-m-d H:i:s')]);
				} else {
					DB::table('adimage')->where('advertisement_id',$advert)->update(['path'=>$image_name, 'updated_at'=> date('Y-m-d H:i:s')]);
				}
            }
        }
		$a1 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','A1')
										->orderBy('advertisement.updated_at','DESC')->first();
		$d1 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D1')->first();
		//dd($d1);
		$d2 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D2')->first();
		$d3 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D3')->first();
		$d4 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D4')->first();
		return view('advertisement.global.landing_edit')
			->with('a1',$a1)
			->with('d1',$d1)
			->with('d2',$d2)
			->with('d3',$d3)
			->with('d4',$d4);		
	}
	
	public function save_hyper(Request $request)
    {
		$AdTarget=AdTarget::where('route','/')->first();
		$name = $request->get('hyper_name');
		$url = $request->get('hyper_url');
		$price = $request->get('hyper_price');
		$segment = $request->get('hyper_segment');
		$adslot_id = 3;
		$slot = DB::table('adslot')->where('placement','D' . $segment)->first();
		if(!is_null($slot)){
			$adslot_id = $slot->id;
		}
		$advertexists = DB::table('advertisement')->where('adslot_id',$adslot_id)->first();
		if(is_null($advertexists)){
			$advert = DB::table('advertisement')->insertGetId(['name'=> $name, 'url'=> $url, 'price'=>$price * 100, 'adslot_id'=>$adslot_id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=> date('Y-m-d H:i:s')]);
		} else {
			$advert = $advertexists->id;
			DB::table('advertisement')->where('id',$advert)->update(['name'=> $name, 'url'=> $url, 'price'=>$price * 100, 'updated_at'=> date('Y-m-d H:i:s')]);
		}
		$folder = base_path() . '/public/images/advertisement/' . $advert;
        File::makeDirectory($folder, 0777, true, true);
        $destination = $folder . '/';
        //chmod($folder,0775);
        $image = $request->file('hyper_image');
		
        if (isset($image)) {		
            $image_name = $image->getClientOriginalName();
            if ($image->move($destination, $image_name)) {
				$adimageexists = DB::table('adimage')->where('advertisement_id',$advert)->first();
				
				if(is_null($adimageexists)){
					DB::table('adimage')->insert(['path'=>$image_name,'adcontrol_id'=>0,'advertisement_id'=>$advert, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=> date('Y-m-d H:i:s')]);
				} else {
					DB::table('adimage')->where('advertisement_id',$advert)->update(['path'=>$image_name, 'updated_at'=> date('Y-m-d H:i:s')]);
				}
            }
        }
		$a1 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','A1')
										->orderBy('advertisement.updated_at','DESC')->first();
		$d1 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D1')->first();
		//dd($d1);
		$d2 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D2')->first();
		$d3 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D3')->first();
		$d4 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D4')->first();
		return view('advertisement.global.landing_edit')
			->with('a1',$a1)
			->with('d1',$d1)
			->with('d2',$d2)
			->with('d3',$d3)
			->with('d4',$d4);
	}

	public function landing_preview() {
		$AdTarget=AdTarget::where('route','/')->first();
		$a1slides = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','A1')->get();
		$a1 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','A1')
										->first();
		$d1 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D1')->first();
		//dd($d1);
		$d2 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D2')->first();
		$d3 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D3')->first();
		$d4 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D4')->first();
		return view('advertisement.global.landing_preview')
			->with('images',$a1slides)
			->with('a1',$a1)
			->with('d1',$d1)
			->with('d2',$d2)
			->with('d3',$d3)
			->with('d4',$d4);	
	}
	
	public function global_slider() {
		return view('advertisement.global.slider');
	}
	
	public function global_landing() {
	//	$AdTarget=AdTarget::where('route','/')->first();
		/*$a1slides = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','A1')->get();
		$a1 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','A1')
										->orderBy('advertisement.updated_at','DESC')->first();
		$d1 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D1')->first();
		//dd($d1);
		$d2 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D2')->first();
		$d3 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D3')->first();
		$d4 = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
										->join('adimage','adimage.advertisement_id','=','advertisement.id')
										->join('adtarget','adslot.adtarget_id','=','adtarget.id')
										->select('advertisement.*','adimage.path')
										->where('adtarget.id','=',$AdTarget->id)
										->where('adslot.placement','=','D4')->first();*/
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
				$category_data[] = ['color' => $cat_id['original_color'],
					'floor' => $cat_id['floor'],
					'name' => $cat_id['name'],
					'desc' => $cat_id['description'],
					'category_id' => $cat_id['id'],
					'isenable' => 1,
					'logo_white' => $cat_id['logo_white'],
					'latest_photo_id' => $cat_latest_product_id,
					'latest_photo' => $cat_latest_product,
					'random_photos' => $cat_products_random_photos
				];				
			} else {
				$category_data[] = ['color' => $cat_id['color'],
					'floor' => $cat_id['floor'],
					'name' => $cat_id['name'],
					'desc' => $cat_id['description'],
					'category_id' => $cat_id['id'],
					'isenable' => 0,
					'logo_white' => $cat_id['logo_white'],
					'latest_photo_id' => $cat_latest_product_id,
					'latest_photo' => $cat_latest_product,
					'random_photos' => $cat_products_random_photos
				];					
			}
			
        }
		//dd($floor);
		foreach($category_data as $categories){
			if($categories['isenable']==0){
				DB::table('category')->where('id',$categories['category_id'])->update(['floor'=>$floor,'enable'=>false, 'color'=>'#AAAAAA']);
				$floor++;
			}	
		}
		//dd(end($category_data));
		
		$oShopProMob = DB::table('merchantproduct')
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
				->orderByRaw("RAND()")
				->limit(6);
				
		$rand_pro_mob=array();
			
            foreach ($oShopProMob->get() as $p) {
                # code...
				//dd($p);
				if(!is_null($p)){
					$productId=$p->id;
					array_push($rand_pro_mob, $productId);					
				}
            }
			
		$cat_random_product_mob=DB::table('merchantproduct')
				->join('product','merchantproduct.product_id','=','product.id')
				->select('product.*','merchantproduct.product_id')
				->join('merchant','merchantproduct.merchant_id','=','merchant.id')
				->whereIn('product.id',$rand_pro_mob)
				->where('product.oshop_selected','=',true)
                ->where('product.available','>',0)
                ->where('product.status','active')
				->where('merchant.status', '=', 'active')
                ->where('product.retail_price','>',0)->get();	
        
        return view('advertisement.global.landing',
			compact(['adSlot_data', 'category_data', 'cat_random_product_mob']))->
			with('currency',$currency);										
		//return view('');
	}
	public function global_index() {
		
		return view('advertisement.global');
	}
	
	public function master() {
		$advertisements = DB::table('advertisement')->join('adslot','adslot.id','=','adslot_id')
							->join('adimage','adimage.advertisement_id','=','advertisement.id')
							->join('adtarget','adslot.adtarget_id','=','adtarget.id')
							->select('advertisement.*','adimage.path','adslot.placement','adtarget.description as target')
							->get();
		return view('advertisement.master')->with('advertisements',$advertisements);
	}
	
	public function index() {
		return view('advertise');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}
/**
     * Get all advertisements
     *
     * @method Ajax Get
     */
    public function getAdvertisement() {
        $advertisement = advertisement::all('id', 'name', 'phone','email')->toArray();
        $advertisements = array();
        foreach ($advertisement as $key => $value) {
            if (empty($advertisements[$key])) {
                $advertisements[$key] = array();
            }
            $advertisements[$key]['text'] = $value['name'];
            $advertisements[$key]['name'] = $value['name'];
            $advertisements[$key]['phone'] = $value['phone'];
            $advertisements[$key]['email'] = $value['email'];
            $advertisements[$key]['data-advertisement-id'] = $value['id'];
        }
        return response()->json($advertisements);
    }

    public function getAdvertisementTable() {
        return view('admin/advertisementTree');
    }

    /**
     * Add new advertisement or subadvertisement
     *
     * @method Ajax POST
     */
    public function postNewadvertisement(Request $request) {

        $formData = Input::all();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        if (!empty($formData)) {

            $advertisementData = array(
                'name' => $formData['name'],
                'phone' => $formData['phone'],
                'email' => $formData['email'],
                'created_at' => $now,
                'updated_at' => $now,
            );

            advertisement::insert($advertisementData);
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Edit new advertisement or subadvertisement
     *
     * @method Ajax POST
     */
    public function postEditadvertisement(Request $request) {

        $formData = Input::all();

        $advertisementData = array(
            'name' => $formData['name'],
            'phone' => $formData['phone'],
            'email' => $formData['email'],
        );

        advertisement::where('id', '=', $formData['data-advertisement-id'])->update($advertisementData);

        echo json_encode(array('success' => true));
    }

    /**
     * Delete new advertisement or subadvertisement
     *
     * @method Ajax POST
     */
    public function removeAdvertisement() {
        $formData = Input::all();
        advertisement::where('id', '=', $formData['data-advertisement-id'])->delete();

        echo "success";
        exit();
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(AdvertisementRequest $request) {
		$input = $request->except("_token");
		$validator = Validator::make($input, [
			'name' => 'required|min:3',
			'phone' => 'required|min:0',
			'email' => 'required|email',
		]);

		if ($validator->fails()) {
			return redirect('advertise')
				->withErrors($validator)
				->withInput();
		}
		$status = $this->repo->create($input);
		return redirect('advertise')->with('success', "Thank You We Will Contact You.");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}
