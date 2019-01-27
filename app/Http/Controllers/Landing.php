<?php

namespace App\Http\Controllers;

use App;
use App\Models\Adslot;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\AdTarget;
use App\Models\AdControl;
use App\Models\AdImage;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use URL;
use App\Models\Owarehouse;
use App\Models\User;
use App\Models\RoleUser;
use App\Models\Station;
use App\Models\Album;
use App\Models\Profile;
use App\Models\Buyer;

class Landing extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    protected $slider_path = "/images/adimage/";

    public function show_register() {
		Session::put('showregister',1);
		return $this->index();
	}
    public function index() {
		//print_r("hello");exit;
		//Session::forget('showregister');
    	/* Get Hyper deals data */
		/*  Results get overwritten at the bottom!! 
		 *  Squidster Tue Mar  6 00:07:46 MYT 2018
		$hyper_deals = Owarehouse::join('product','owarehouse.product_id','=','product.id')
        ->join('oshopproduct','oshopproduct.product_id','=','product.id')
        ->join('oshop','oshop.id','=','oshopproduct.oshop_id')
        ->join('merchantoshop','merchantoshop.oshop_id','=','oshopproduct.oshop_id')
        ->join('merchantproduct','merchantproduct.product_id','=','product.id')
        ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
        ->where('oshop.status','active')
        ->where('merchant.status','active')
        ->where('product.oshop_selected',1)
        ->where('product.status','active')
        ->where('product.available','>',0)
        ->select('owarehouse.id as owarehouse_id','product.*')
        ->orderByRaw("RAND()")
        ->take('12')
        ->get();
		*/

        /* Get Hyper deals data */
        $pro = new Product();
        $adSlotObj = new Adslot();
        $catObj = new Category();
        $merchant = new Merchant();
        $currency = null;
        if(isset($_GET['email']) && isset($_GET['pass'])){
            $this->Login($_GET['email'],$_GET['pass']);
        }
         
        if(!is_null(Currency::where('active',true)->first())){
            $currency = Currency::where('active',true)->first()->code;
        }
		$showbanner = 1;
		$popupurl = "";
		$popupimage = "";
		$adpopup = DB::table('adpopup')->where('status','active')->first();
		if(is_null($adpopup)){
			$showbanner = 0;
		} else { 
			$popupimage = URL::to('/') . "/images/popup/" . $adpopup->image_path;
			$popupurl = URL::to('/') . "/" . $adpopup->url;
			if (Session::has('showbanner')) {
				$showbanner = 0;
			} else {
				Session::put('showbanner',"showed");
			}
		}
		$register = 0;
		if(!Auth::check()){
			if (Session::has('showregister')) {
				$register = 1;
			}
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

        try {
        	$sliderImages 	= [];
        	$adControllerId = null;

        	$adTargetId   = AdTarget::where("target","lpage_slider")->
				select("id")->first();
        
	        if($adTargetId != null){
				$adControllerId =
					AdControl::where("adtarget_id", $adTargetId->id)->
					select("id")->first();
	        }
	        if($adControllerId != null){
				$sliderImages =
					AdImage::where("adcontrol_id", $adControllerId->id)->whereNotIn('path',array(''))->get();
				$sliderImages_hide =
					AdImage::where("adcontrol_id", $adControllerId->id)->whereNotIn('path',array(''))->pluck('hide_public');
	        }
        } catch (Exception $e) {
        	\Log::error("Landing slider error ". $e);
        }

        try {
        	$smallTopImage 	= null;
        	$smallTopAdControllerId = null;

        	$smallTopAdTargetId   = AdTarget::where("target","lpage_internal_top")->select("id")->first();
        
	        if($smallTopAdTargetId != null){
				$smallTopAdControllerId = AdControl::where("adtarget_id", $smallTopAdTargetId->id)->select("id")->first();
	        }

	        if($smallTopAdControllerId != null){
				$smallTopImage 	= AdImage::where("adcontrol_id", $smallTopAdControllerId->id)->whereNotIn('path',array(''))->first();
	        }

        } catch (Exception $e) {
        	\Log::error("Landing top small container error ". $e);
        }

        try {
        	$smallBottomImage 		   = null;
        	$smallBottomAdControllerId = null;

        	$smallBottomAdTargetId   = AdTarget::where("target","lpage_internal_bottom")->select("id")->first();
        
	        if($smallBottomAdTargetId != null){
				$smallBottomAdControllerId = AdControl::where("adtarget_id", $smallBottomAdTargetId->id)->select("id")->first();
	        }
	        if($smallBottomAdControllerId != null){
				$smallBottomImage 	= AdImage::where("adcontrol_id", $smallBottomAdControllerId->id)->whereNotIn('path',array(''))->first();
	        }
        } catch (Exception $e) {
        	\Log::error("Landing bottom small container error ". $e);
        }

        /* oshop images section */
        try {
        	$oshopImages 		   = null;
        	$oshopImages = AdTarget::with(['AdControl.AdImages'=>function($query){
        		return $query->whereNotIn('path',array(''))->limit('10');	
        	}])->where("target","lpage_oshop")->has('AdControl.AdImages')->first();
        } catch (Exception $e) {
        	\Log::error("Landing oshop page error". $e);
        }
        /* Oshop Images done by rahul */

        $slider_path = $this->slider_path;
		
		$product_ids= DB::table('owarehouse')->lists('product_id');
        $hyper_deals = Product::join('owarehouse as o','product.id','=','o.product_id')
                ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id')
							 ->where('op.status','=','executed');
                         })
                ->whereIn('product.id',$product_ids)
                ->where('product.status','active')
                ->where('product.oshop_selected',true)
                ->where('o.status','active')
                ->where('o.moq','>',0)
                ->where('product.owarehouse_moqperpax','>',0)
                ->where('product.owarehouse_price','>',0)
                ->where('product.oshop_selected',1)
                ->select(DB::raw('DISTINCT(product.id) as pid, product.*,o.id as owarehouse_id,o.collection_price, product.parent_id as product_id,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
                ->groupBy('product.id')
				->orderByRaw("RAND()")
				->limit(12)
                ->get();	
	//	dd($data);

        return view('landing_page',
			compact(['adSlot_data', 'category_data', 'cat_random_product_mob',
				'showbanner', 'register','popupurl','popupurl','popupimage','sliderImages','sliderImages_hide','smallTopImage','smallBottomImage','slider_path','hyper_deals','oshopImages']))->
				with('currency',$currency);
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
     public function Login($user_name, $user_password) {
        $user_id = User::where('email', $user_name)->first(['id']);
        if (!empty($user_id)) {
            $user_role = RoleUser::where('user_id', $user_id->id)->
		  		with('user_role')->get();
            if (is_null($user_role)) {
                return response()->json[['status'=>'failure','short_message'=>'Missing Role','long_message'=>'DB Error: The user has no role. Please contact OpenSupport.']];
                return "";
            }
            if (!empty($user_role)) {
                $userRole = $user_role->toArray();
                foreach ($userRole as $key => $Role) {
					if ($Role['user_role']['slug'] == 'byr') {
						$buyerStatus = Buyer::where('user_id', $user_id->id)->first(['status']);
						if ($buyerStatus->status != 'active') {
							if($buyerStatus->status == 'suspended'){
								$ret["long_message"]="Your buyer account has been suspended. Please contact OpenSupport.";
								
							} else {
								$ret["long_message"]="Your account is not active. Please contact OpenSupport.";
							}
							return response()->json($ret);
                        }
					}
					$ismerchant = DB::table('merchant')->where('user_id',$user_id->id)->first();
                    if ($Role['user_role']['slug'] == 'mer' || !is_null($ismerchant)) {
                        $merchantStatus = Merchant::where('user_id',
							$user_id->id)->first(['status']);
                        if ($merchantStatus->status != 'active') {
                            if($merchantStatus->status == 'suspended'){
                            	$ret["long_message"]="Your merchant account has been suspended. Please contact OpenSupport.";
								
							} else {
								$ret["long_message"]="Your merchant account is not active. Please contact OpenSupport.";
							}
							return response()->json($ret);
                        }
                    }
                    //Station Operator If not Active can't Login
                    if ($Role['user_role']['slug'] == 'sto') {
                        $stationStatus = Station::where('user_id', $user_id->id)->first(['status']);
						if(!is_null($stationStatus)){
							if ($stationStatus->status != 'active') {
								if($stationStatus->status == 'suspended'){
									$ret["long_message"]="Your station account has been suspended. Please contact OpenSupport.";
								} else {
									$ret["long_message"]="Your station account is not active. Please contact OpenSupport.";
								}
								return response()->json($ret);
							}
                        }
                    }
                }
            }
        }

        if (Auth::attempt(['email' => $user_name, 'password' => $user_password], true)) {
            $user_id = Auth::user()->id;
			$osmallvisit=DB::table('osmallvisit')->where('user_id',$user_id)->first();
			DB::table('users')->where('id', $user_id)->update(['password_fail'=>0]);
			if(is_null($osmallvisit)){
				DB::table('osmallvisit')->insert(['user_id'=>$user_id,'counter'=>1]);
			} else {
				DB::table('osmallvisit')->where('id',$osmallvisit->id)->update(['counter'=>($osmallvisit->counter + 1)]);
			}			
            Session::put('user_id', $user_id);
            //get merchant id
            $merchant_data = Merchant::where('user_id', $user_id)->first();

            /* User MAY not be a merchant!! */
            if (isset($merchant_data)) {

                $merchant_id = $merchant_data->id;

                //get album id
                $album = Album::where('merchant_id', $merchant_id)->first();
                if (empty($album)) {
                    $album = new Album();
                    $album->merchant_id = $merchant_id;
                    $album->save();
                }

                $album_id = $album->id;
                Session::put('merchant', $merchant_data);
                Session::put('album_id', $album_id);

                //get profile id
                $profile = Profile::where('album_id', $album_id)->first();
                if (empty($profile)) {
                    $profile = new Profile();
                    $profile->album_id = $album_id;
                    $profile->save();
                }

                $profile_id = $profile->id;
                Session::put('profile_id', $profile_id);
            }
            $ret["status"]="success";
			return response()->json($ret);
        } else {
			$dbuser = DB::table('users')->where('email', $user_name)->first();
			$globals = DB::table('global')->first();
			$att = 0;
			if(!is_null($dbuser)){
				$att = $dbuser->password_fail + 1;
				DB::table('users')->where('email', $user_name)->update(['password_fail'=>$att]);
                $userr = DB::table('users')->where('email', $user_name)->first();
                if(!is_null($userr)){
                    DB::table('buyer')->where('user_id', $userr->id)->update(['status' => 'active']);
                }             
				if($att >= $globals->max_password_fail){
					DB::table('merchant')->where('user_id', $dbuser->id)->update(['status'=>'suspended']);
					DB::table('station')->where('user_id', $dbuser->id)->update(['status'=>'suspended']);
					DB::table('buyer')->where('user_id', $dbuser->id)->update(['status'=>'suspended']);
					$e= new EmailController;
					$e->passwordFail($user_name);
				}
			}
            $ret["long_message"]="Your username or password is incorrect. Please try again.";
			return response()->json($ret);
        }
    }

}
