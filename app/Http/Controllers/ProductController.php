<?php

namespace App\Http\Controllers;
use App\Classes\Delivery;
use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\MerchantCategory;
use App\Models\MerchantProduct;
use App\Models\OpenWish;
use App\Models\Autolink;
use App\Models\OpenWishPledge;
use App\Models\productspec;
use App\Models\ProfileProduct;
use App\Models\State;
use Facebook\Facebook;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\ProductDealer;
use App\Models\TProductDealer;
use App\Models\Specification;
use App\Models\SubCatLevel1;
use App\Models\SubCatLevel2;
use App\Models\SubCatLevel3;
use App\Models\GlobalT;
use App\Models\SubCatLevel1Spec;
// use Illuminate\Http\File;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\IdController;
use App\Http\Controllers\UserController; 
use Validator;
use Input;
use Cart;
use URL;
use Log;
use Storage;
use Response;
use DateTime;
use App\Models\User;
use App\Models\Product;
use App\Models\Wholesale;
use App\Models\Twholesale;
use App\Http\Requests\ProductRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exceptions\CustomException;
use Exception;
use \Illuminate\Database\QueryException;
use Yajra\Datatables\Facades\Datatables;
use Excel;
include_once(app_path() . '/WebClientPrint/WebClientPrint.php');
use Neodynamic\SDK\Web\WebClientPrint;
use Neodynamic\SDK\Web\Utils;
use Neodynamic\SDK\Web\ClientPrintJob;
use Neodynamic\SDK\Web\DefaultPrinter;
use Neodynamic\SDK\Web\UserSelectedPrinter;
use Neodynamic\SDK\Web\InstalledPrinter;
use Neodynamic\SDK\Web\ParallelPortPrinter;
use Neodynamic\SDK\Web\SerialPortPrinter;
use Neodynamic\SDK\Web\NetworkPrinter;
use File;
use Image;

class ProductController extends Controller 
{
    // public function __construct()
    // {
    //     $this->middleware('auth', ['except' => ['productconsumer','get_delivery_price']]);

    // }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    //public function index()
    public function index(Request $req)
    {
        // page view counter--- chonchol
        if (!Auth::check()) {
            return view('common.generic')
            ->with('message_type','error')
            ->with('message','Please login to access this page')
            ;
        }
        $details = json_decode(file_get_contents("http://ipinfo.io/"));
        $country_name = $details->country;
        if ($country_name == "MY" || $country_name == "HK") {
            $query=DB::SELECT("INSERT INTO view_count (product_view_count,created_at) VALUES (1,now())");
        }

        // $id = category_id
        $id = $req->id;
        $subcat_id =$req->subcat;
        $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        if (is_null($merchant)) {
            return view('common.generic')
            ->with('message_type','error')
            ->with('message','You do not have access to this page')
            ;
        }

        $brand = Brand::all();
        $category = Category::where('id', $id)->get();
        if (count($category) > 0) {
            $subcat_level1 = SubCatLevel1::where('category_id', $id)->where('id',$subcat_id)->get();
            $user = User::where('created_at', '<=', Carbon::now())->get();
            $countries = Country::all();
            $city = City::all();
            $states = State::all();

            $oshop = $merchant->oshop_name;
            $description = $merchant->description;
            return view('product.create_new_product', compact('id', 'brand', 'subcat_id','category', 'subcat_level1', 'user', 'oshop', 'description', 'countries', 'city', 'states'));

        } else {
            return Redirect::back();
        }

    }

    //public function store(Request $request)
    public function store(ProductRequest $request)
    {
        $user_id = Auth::user()->id;
        $merchant_data = Merchant::where('user_id', $user_id)->first();
        $merchant_id = $merchant_data->id;

        /*
         * Product table section
         */
        $product = new Product();
        $product_data = $product->store($request, $merchant_id);

        $file = $request->file('product_photo');
        $fileNameUniq = uniqid();
        $destinationPath = public_path() . 'images/product/' . $product->id . '/';


        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

        $fileName = uniqid();
        if (move_uploaded_file($file, 'images/product/' . $product->id . '/' . $fileName . '.' . $extension)) {
            $product->photo_1 = $fileName . '.' . $extension;
        }


        /*
         * Saved Product in mechant product table
         */
        $merchant_pro = new MerchantProduct();
        $merchant_pro_data = $merchant_pro->storeproduct($product_data, $merchant_id);
        /*
         * save product to profile product table
         */
        /*----Get Logged User Profile---
        if (Session::has('profile_id')) {
            $profile_id = session()->get("profile_id");
            /*----Save product in ProfileProduct Table-
            $profile_product = new ProfileProduct();
            $profile_product->profile_id = $profile_id;
            $profile_product->product_id = $product_data->id;
            $profile_product->save();
        }

        /********End ProfileProduct***************/


        /*
        * Saved Category in mechant Category table
        */
        $merchant_category = new MerchantCategory();
        $merchant_category_data = $merchant_category->storecategory($request, $merchant_id);
        /*
        * Unit and price section....Wholesaletable
        */
        $wholesale = new Wholesale();
        $wholesale->storewholesale($request, $product_data);
        /*
        * Dealer section with speacial price....productdealer table
        */
        $productDealer = new ProductDealer();
        $productDealer->stroeproductDealer($request, $product_data);
        /*
        * Product Specification section..specification table
        */
        $spec = new Specification();
        $specification = $spec->storespecification();
        /*
        * Assign Specification to product
        */
        //$product_spec = new Productspec();
        // $product_spec = new Productspec();
        // $product_specification = $product_spec->AssignSpec($product_data,$specification,$request);

        Session::flash('createproduct', 'Product Registered');

        return redirect()->back()->with('message', 'Product Registered.');
    }


    public function store_retail(Request $request,$uid=null)
    {
		$input = $request->all();
		//dump($request->get('free_delivery_with_purchase_qty_ow'));
		//dd($request->get('free_delivery_with_purchase_qty'));
        $ret=array();
        $ret["status"]="failure";
        if (!Auth::check()) {
            return response()->json($ret);

        }
        $user_id=Auth::user()->id;
		if (!empty($uid) && Auth::user()->hasRole('adm')) {
            $user_id=$uid;
        }
       $company_id=DB::table('company')->where('owner_user_id',$uid)->whereNull('deleted_at')->pluck('id');

        if (empty($company_id)) {
            # code...
            return response()->json($ret);
        }

        $is_staff=DB::table('member')
        ->where('user_id',$user_id)
        ->where('company_id',$company_id)
        ->whereNull('deleted_at')
        ->where('status','active')
        ->where('type','member')
        ->first();
        //dd($is_staff);
        if (empty($is_staff) and Auth::user()->id!=$uid) {
            # code...
            $message_type="error";
            $message="You do not have permission to view this page";
            return response()->json($ret);
        }
        if (!empty($is_staff)) {
            # code...
            $user_id=$uid;
        }

        $merchant_data = Merchant::where('user_id', $user_id)->first();
        // Validate for Delivery Option ~Zurez
        try {
            $merchant_id = $merchant_data->id;
        } catch (\Exception $e) {
            return json_encode("Merchant ID not found");
        }
        
         $name_exists=DB::table("product")->join("merchantproduct","merchantproduct.product_id","=","product.id")
        ->where("product.name",$request->name)
        ->where("merchantproduct.merchant_id",$merchant_id)
        ->whereNull("product.deleted_at")
        ->first();
        if (!empty($name_exists)) {
            # code...
            $ret["long_message"]="A product with similar name already exists. Please change name";
             return response()->json($ret);
        }
        $product = new Product();
        $product_data = $product->storep($request,$merchant_id);
        $file = $request->file('product_photo');
        $fileNameUniq = uniqid();
        $destinationPath = public_path().'images/product/'.$product->id.'/';

        $extension = pathinfo($file->getClientOriginalName(),
			PATHINFO_EXTENSION);

        $fileName = uniqid();
        if (move_uploaded_file($file,'images/product/'.$product->id .'/'.
			$fileName.'.'.$extension)) {
            $product->photo_1 = $fileName . '.' . $extension;
        }

        $merchant_pro = new MerchantProduct();
        $merchant_pro_data = $merchant_pro->storeproduct($product_data,
			$merchant_id);
		
		$pdetail = DB::table('productdetail')->insertGetId(['data'=>$request->get('product_details'),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		
		DB::table('product')->where('id',$product_data->id)->update(['productdetail_id'=>$pdetail]);
		
		if($request->get('oshop_id') > 0){
			DB::table('oshopproduct')->insert(['oshop_id'=>$request->get('oshop_id'),'product_id'=>$product_data->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}
		
        /*
         * save product to profile product table
         */
        /*----Get Logged User Profile---*/
        /*if (Session::has('profile_id')) {
            $profile_id = session()->get("profile_id");
            /*----Save product in ProfileProduct Table-
            $profile_product = new ProfileProduct();
            $profile_product->profile_id = $profile_id;
            $profile_product->product_id = $product_data->id;
            $profile_product->save();
        }*/

        /********End ProfileProduct***************/
        /*$spec = new Specification();
        $specification = $spec->storespecification();*/

	/*	$color = DB::table('specification')->where('name','color')->first();
		if(isset($color)){
			$spec_id = $color->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'color', 'description' => 'Color','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_2'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);*/

	/*	$model = DB::table('specification')->where('name','model')->first();
		if(isset($model)){
			$spec_id = $model->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'model', 'description' => 'Model','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_3'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$size = DB::table('specification')->where('name','size')->first();
		if(isset($size)){
			$spec_id = $size->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'size', 'description' => 'Size(L x W x H)','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_4'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$weight = DB::table('specification')->where('name','weight')->first();
		if(isset($weight)){
			$spec_id = $weight->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'weight', 'description' => 'Weight','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_5'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$warranty_period = DB::table('specification')->where('name','warranty_period')->first();
		if(isset($warranty_period)){
			$spec_id = $warranty_period->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'warranty_period', 'description' => 'Warranty Period','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_6'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$warranty_type = DB::table('specification')->where('name','warranty_type')->first();
		if(isset($warranty_type)){
			$spec_id = $warranty_type->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'warranty_type', 'description' => 'Warranty Type++','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_7'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);*/
        /* Assign Specification to product
        */
        /*
        * Unit and price section....Wholesaletable
        */
		/***/
        //$product_spec = new Productspec();
        // $product_spec = new Productspec();
        // $product_specification = $product_spec->AssignSpec($product_data,$specification,$request);

		DB::table('productcolor')->
			where('product_id', $product_data->id)->delete();
		$colorsrgb=$request->get('colorsrgb');
		$colorshex=$request->get('colorshex');
		$colorsrgb=json_decode($colorsrgb);
		$colorshex=json_decode($colorshex);
		for($jj = 0; $jj < count($colorsrgb); $jj++){
			$colorexist = DB::table('color')->where('hex',$colorshex[$jj])->count();
			if($colorexist == 0){
				$color_id = DB::table('color')->insertGetId(['name'=> "", 'description'=> "", 'rgb'=> $colorsrgb[$jj], 'hex'=> $colorshex[$jj], "created_at"=>date("Y-m-d H:i:s"), "updated_at"=>date("Y-m-d H:i:s")]);
			} else {
				$color_id = DB::table('color')->where('hex',$colorshex[$jj])->first()->id;
			}
			$colorexist = DB::table('productcolor')->where('product_id', $product_data->id)->where('color_id', $color_id)->count();
			if($colorexist == 0){
				DB::table('productcolor')->insert(['product_id'=> $product_data->id, 'color_id'=> $color_id, "created_at"=>date("Y-m-d H:i:s"), "updated_at"=>date("Y-m-d H:i:s")]);
			}
		}
	//	$save_policy = DB::table('merchant')->where('id',$merchant_id)->update(array('return_policy' => $request->merchant_policy));
        /*
        * Saved Category in mechant Category table
        */

        $merchant_category = new MerchantCategory();
        $merchant_category_data = $merchant_category->
			storecategory($request, $merchant_id);

		$parent_id = $product_data->id;
		
		$merchantuniqueq = DB::table('nsellerid')->
			where('user_id',$user_id)->first();

		if(!empty($merchantuniqueq)){
			$colors = DB::table('color')->
				join('productcolor','color.id','=','productcolor.color_id')->
				where('productcolor.product_id',$product_data->id)->
				select('color.*')->get();

			if(!empty($colors) && count($colors) > 0){
				foreach($colors as $color){
					$newid = UtilityController::productuniqueid(
						$merchant_id,$merchantuniqueq->nseller_id,'b2c',
						$color->id, $product_data->id);

					if(!empty($newid)){
						DB::table('nproductid')->
							insert(['nproduct_id'=>$newid,
							'product_id'=>$product_data->id,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')]);
					}					
				}

			} else {
				$newid = UtilityController::productuniqueid(
					$merchant_id,$merchantuniqueq->nseller_id,'b2c',0,
					$product_data->id);

				if($newid != ""){
					DB::table('nproductid')->
						insert(['nproduct_id'=>$newid,
						'product_id'=>$product_data->id,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')]);
                    /*Barcode*/
                    
                        # code...
                        $bc_management_id=DB::table("bc_management")->insertGetId([
                            "created_at"=>Carbon::now(),
                            "updated_at"=>Carbon::now(),
                            "barcode_type"=>"CODE_128",
                            "barcode"=>$newid
                        ]);
                        
                        DB::table("productbc")->insert([
                            "created_at"=>Carbon::now(),
                            "updated_at"=>Carbon::now(),
                            "bc_management_id"=>$bc_management_id,
                            "product_id"=>$product_data->id
                        ]);
                    
				}
			}
		}
		UtilityController::createQr($product_data->id,'product',URL::to('/') . '/productconsumer/' . $product_data->id);

        
        // store in voucher table if product type is voucher and otcvoucher
        if($product_data->type == "voucher" || $product_data->type == "otcvoucher")
        {
            $expiry_date = date_format(date_create($request->expiry_date),"Y-m-d");

            // $logged_id = Auth::user()->id;
            // $address_id = DB::table('fairlocation')->select('id')->where('user_id',$logged_id)->first();
            // echo '<pre>'; print_r($address_id); die();
            $storeinvoucher = DB::table('voucher')
                                ->insert([
                                    "product_id" => $product_data->id,
                                    "expiry" => $expiry_date,
                                    "validity" => "wmonth",
                                    // "address_id" => $address_id->id,
                                    "address_id" => '19',
                                    // "package_qty" => $request->voucher_package_qty,
                                    // "issued" => $product_data->available,
                                    "status" => 'active',
                                    "nature" => 'counter',
                                    "source" => 'opossum',
                                    "reference_no" => '0000',
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
        }
       
		$ret["status"]= "success";
        $ret["pid"]=$parent_id;
        return response()->json($ret);
		return json_encode($parent_id);
    }

    public function store_sp(Request $request)
    {
		try {
			$input = $request->all();
			$product_id = $request->get('myproduct_id');
			$product_data = Product::where('id', $product_id)->first();
			/*
			* Dealer section with speacial price....productdealer table
			*/
			DB::table('productdealer')->where('product_id', $product_data->id)->where('dealer_id',$request->get('did'))->delete();
			$productDealer = new ProductDealer();
			$productDealer->storeproductDealer($request, $product_data);
			return json_encode($input);
        } catch(QueryException $e){
            return json_encode("error");
        }		
	}	
	
	public function store_stp(Request $request)
    {
		try {
			$input = $request->all();
			$tproduct_id = $request->get('myproduct_id');
			$tmerchant_id = $request->get('tmerchant_id');
			/*
			* Dealer section with speacial price....productdealer table
			*/
			DB::table('tproductdealer')->where('tproduct_id', $tproduct_id)->where('dealer_id',$request->get('did'))->delete();
			$productDealer = new TProductDealer();
			$productDealer->storetproductDealer($request, $tproduct_id);
			return json_encode($input);
        } catch(QueryException $e){
            return json_encode($e);
        }		
	}
	
    public function store_tb2b(Request $request)
    {
         $pr =  $request->protect;
        foreach ($pr as $key => $value) {
            if ($value==1) {
            return json_encode("overlaped");
               
            }
        }
		try {
			$merchant_id = $request->get('tmerchant_id');
			$tproduct_id = $request->get('tproduct_id');
			$merchant_data = Merchant::where('id', $merchant_id)->first();		
			$input = $request->all();
			DB::table('twholesale')->
				where('tproduct_id', $tproduct_id)->
				delete();

			$twholesale = new Twholesale();
			$twholesale->storetwholesale($request, $tproduct_id);
			return json_encode($input);
        } catch(QueryException $e){
            return json_encode("error");
        }	
	}
   
	public function store_hyper(Request $request)
    {
		$input = $request->all();
		$moq = $request->get('moq');
		$hyper_id = $request->get('hyper_id');
		$owarehouse_id = $request->get('owarehouse_id');
		$moqcaf = $request->get('moqcaf');
		$global_system_vars = GlobalT::orderBy('id', 'desc')->first();
		$duration = $global_system_vars->hyper_duration;
		$hyperprice = $request->get('hyperprice');
		$hqty = $request->get('hqty');
		//$deliveryqty = $request->get('deliveryqty');
		$states_hyper = $request->get('states_hyper');
		$cities_hyper = $request->get('cities_hyper');
		$areas_hyper = $request->get('areas_hyper');
		$del_option_hyper = 'system';
		$hyper_terms = $request->get('hyper_terms');
		$hyper_terms = $request->get('hyper_terms');
		$free_delivery = $request->get('free_delivery');
		$free_delivery_with_purchase_qty = $request->get('free_delivery_with_purchase_qty');
		$prod_del_timehyper = $request->get('prod_del_timehyper');
		$prod_del_time_tohyper = $request->get('prod_del_time_tohyper');
		//dd($free_delivery);
		$parent_id = $request->get('parent_id');
		//dd($rfree_delivery);
		$retail = Product::find($parent_id);
		$merchant_id = DB::table('merchantproduct')->where('product_id',$retail->id)->pluck('merchant_id');
		if($hyper_id == 0){
			$hyper = $retail->replicate();
			$hyper->save();
			$return_id = $hyper->id;
			
			DB::table('product')->where('id',$return_id)
						->update(
							[
								'parent_id' => $parent_id,
								'segment' => 'hyper',
								'available' => $hqty,
								'cov_state_id' => $states_hyper,
								'cov_city_id' => $cities_hyper,
								'cov_area_id' => $areas_hyper,
								'cov_area_id' => $areas_hyper,
								'free_delivery' => 1,
								'free_delivery_with_purchase_qty' => $free_delivery_with_purchase_qty,
								'free_delivery_with_purchase_amt' => $free_delivery_with_purchase_qty,
								'owarehouse_moq' => $moq,
								'owarehouse_moqperpax' => $moqcaf,
								'return_policy' => $hyper_terms,
								'delivery_time' => 30,
								'delivery_time_to' => 37,
								'owarehouse_price' => $hyperprice*100
							]
						);
								
			$hypernn = DB::table('owarehouse')->insertGetId(
									[
										'product_id' => $return_id,
										'moq' => $moq,
									//	'deliverypax' => $deliveryqty,
										'duration' => $duration,
										'collection_units' => 0,
										'collection' => 'box',
										'created_at' => date('Y-m-d H:i:s'),
										'updated_at' => date('Y-m-d H:i:s'),
										'collection_price' => $hyperprice*100
									]
								);	
								
			$newid = UtilityController::generaluniqueid($hypernn ,'6','1', date('Y-m-d H:i:s'), 'nhyperid', 'nhyper_id');
			DB::table('nhyperid')->insert(['nhyper_id'=>$newid, 'hyper_id'=>$hypernn, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);	
			DB::table('product')->where('id',$parent_id)
								->update(
									[
										'owarehouse_moq' => $moq,
										'owarehouse_moqperpax' => $moqcaf,
										'owarehouse_price' => $hyperprice*100
									]
								);
			$user_id = Auth::user()->id;
			$merchant_data = Merchant::where('id', $merchant_id)->first();								
			$merchantuniqueq = DB::table('nsellerid')->where('user_id',$merchant_data->user_id)->first();
			//dump($merchantuniqueq);
			if(!is_null($merchantuniqueq)){
			//	dump("MUNIQUE");
				$newid = UtilityController::productuniqueid($merchant_id,$merchantuniqueq->nseller_id,'hyper',0, $return_id);
			//	dump($newid);
				if($newid != ""){
					DB::table('nproductid')->insert(['nproduct_id'=>$newid, 'product_id'=>$return_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
				
			}
			$return_id = $return_id . "-" . $hypernn;
		} else {
			//	dd($hyper_id);
					DB::table('product')->where('id',$hyper_id)
							->update(
								[
									'available' => $hqty,
									'owarehouse_moq' => $moq,
									'owarehouse_moqperpax' => $moqcaf,
									'return_policy' => $hyper_terms,
									'free_delivery' => 1,
									'free_delivery_with_purchase_qty' => $free_delivery_with_purchase_qty,
									'free_delivery_with_purchase_amt' => $free_delivery_with_purchase_qty,
									'cov_state_id' => $states_hyper,
									'cov_city_id' => $cities_hyper,
									'cov_area_id' => $areas_hyper,
									'del_option' => $del_option_hyper,										
									'delivery_time' => 30,
									'delivery_time_to' => 37,
									'owarehouse_price' => $hyperprice*100
								]
							);
							
					DB::table('owarehouse')->where('id',$owarehouse_id)
							->update(
								[
									'duration' => $duration,
									'moq' => $moq,
								//	'deliverypax' => $deliveryqty,
								]
							);							

					DB::table('product')->where('id',$parent_id)
										->update(
											[
												'owarehouse_moq' => $moq,
												'owarehouse_moqperpax' => $moqcaf,
												'owarehouse_price' => $hyperprice*100
											]
										);

	
				$return_id = $hyper_id . "-" . $owarehouse_id;
		}
		return $return_id;
	}
	
    public function store_b2b(Request $request)
    {
		try {
			$user_id = $request->get('userid');
			$merchant_data = Merchant::where('user_id', $user_id)->first();
			$merchant_id = $merchant_data->id;			
			$input = $request->all();
			//dd($input);
			$product_id = $request->get('myproduct_id');
			$product_data = Product::where('id', $product_id)->first();

			Log::debug('product_id='.$product_id);
			Log::debug($product_data);


		//	dd($product_id);
			/* Assign Specification to product
			*/
			/*
			* Unit and price section....Wholesaletable
			*/
			/***/
			$parent_id = $product_data->id;
			$product_new = Product::where('id', $parent_id)->first();
			$photo = $product_new->photo_1;
			$thumb_photo = $product_new->thumb_photo;

			$product = new Product();
			$product_b2b = Product::where('parent_id', $parent_id)->where('segment', 'b2b')->first();
			if(is_null($product_b2b)){
				$product_data = $product->storeb2b($request,$parent_id,$photo,$thumb_photo);
				$pdetail = DB::table('productdetail')->
					insertGetId(['data'=>$request->
					get('product_detailsb2b'),
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>date('Y-m-d H:i:s')]);
		
				DB::table('product')->
					where('id',$product_data->id)->
					update(['productdetail_id'=>$pdetail]);
				$merchantuniqueq = DB::table('nsellerid')->where('user_id',$user_id)->first();
				if(!is_null($merchantuniqueq)){
					$newid = UtilityController::productuniqueid($merchant_id,$merchantuniqueq->nseller_id,'b2b',0, $product_data->id);
					if($newid != ""){
						DB::table('nproductid')->insert(['nproduct_id'=>$newid, 'product_id'=>$product_data->id,
                            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}
					
				}
				UtilityController::createQr($product_data->id,'product',URL::to('/') . '/productconsumer/' . $parent_id);

			} else {
				$product_data = $product->storeb2bedit($request,$parent_id,$photo,$thumb_photo);
				$pdetail = DB::table('productdetail')->
					where('id',$product_data->productdetail_id)->first();

				if(!is_null($pdetail)){
					$pdetail = DB::table('productdetail')->
						where('id',$product_data->productdetail_id)->
						update(['data'=>$request->
						get('product_detailsb2b')]);

				} else {
					$pdetail = DB::table('productdetail')->
						insertGetId(['data'=>$request->
						get('product_detailsb2b'),
							'created_at'=>date('Y-m-d H:i:s'),
							'updated_at'=>date('Y-m-d H:i:s')]);
		
					DB::table('product')->
						where('id',$product_data->id)->
						update(['productdetail_id'=>$pdetail]);
				}
			}

			DB::table('wholesale')->where('product_id',
				$product_data->id)->delete();

			$wholesale = new Wholesale();
			$wholesale->storewholesale($request, $product_data);

			return json_encode($input);

        } catch(QueryException $e){
           dump($e);
        }		
	}

    public function store_retailedit(Request $request,$uid=null)
    {
		$input = $request->all();
        $request->free_delivery_with_purchase_amt=$request->free_delivery_with_purchase_amt*100;
        $ret['short_message']="failure";
		// dd($request->free_delivery_with_purchase_amt);
		/* This is the person who is logged in, may not be the merchant!
		 * Can be admin who is editing the product! 
         * Need to add more validation for role and user_id and merchantproductid here ~Zurez
         */
        if (!Auth::check()) {
            return response()->json($ret);

        }
        $user_id=Auth::user()->id;
        if (!empty($uid) && Auth::user()->hasRole('adm')) {
            $user_id=$uid;
        }
       $company_id=DB::table('company')->where('owner_user_id',$uid)->whereNull('deleted_at')->pluck('id');

        if (empty($company_id)) {
            # code...
            return response()->json($ret);
        }

        $is_staff=DB::table('member')
        ->where('user_id',$user_id)
        ->where('company_id',$company_id)
        ->whereNull('deleted_at')
        ->where('status','active')
        ->where('type','member')
        ->first();
        //dd($is_staff);
        if (empty($is_staff) and Auth::user()->id!=$uid) {
            # code...
            $message_type="error";
            $message="You do not have permission to view this page";
            return response()->json($ret);
        }
        if (!empty($is_staff)) {
            # code...
            $user_id=$uid;
        }

		
        $merchant_data = Merchant::where('user_id', $user_id)->first();
        $merchant_id = $merchant_data->id;
       /* if ($request->del_option =="own") {
            UserController::alsologistic($user_id);   
        }*/
		$hsfile = $request->hasFile('product_photo');
		$product = new Product();
		$product_data = $product->storepedit($request,$hsfile,$merchant_id);
		
		$pdetail = DB::table('productdetail')->where('id',$product_data->productdetail_id)->first();
		if(!is_null($pdetail)){
			$pdetail = DB::table('productdetail')->where('id',$product_data->productdetail_id)->update(['data'=>$request->get('product_details')]);
		} else {
			$pdetail = DB::table('productdetail')->insertGetId(['data'=>$request->get('product_details'),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);

			DB::table('product')->where('id',$product_data->id)->update(['productdetail_id'=>$pdetail]);
		}
		if($hsfile){
			$file = $request->file('product_photo');
			$fileNameUniq = uniqid();
			$destinationPath = public_path() . 'images/product/' . $product->id . '/';

			$extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

			$fileName = uniqid();
			if (move_uploaded_file($file, 'images/product/' . $product->id . '/' .
				$fileName . '.' . $extension)) {
				$product->photo_1 = $fileName . '.' . $extension;
			}
		}
        try {
            DB::table('productspec')->where('product_id', $product_data->id)->delete();
        } catch (\Exception $e) {
            //return "Data Corruption Alert!";
        }
		
		$myoshop = DB::table('oshopproduct')->where('product_id',$product_data->id)->first();
		if(!is_null($myoshop)){
			DB::table('oshopproduct')->where('id',$myoshop->id)->update(['oshop_id'=>$request->get('oshop_id'),'updated_at'=>date('Y-m-d H:i:s')]);
		} else {
			DB::table('oshopproduct')->insert(['oshop_id'=>$request->get('oshop_id'),'product_id'=>$product_data->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}
		
		
		/*$color = DB::table('specification')->where('name','color')->first();
		if(isset($color)){
			$spec_id = $color->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'color', 'description' => 'Color','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_2'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);*/

		/*$model = DB::table('specification')->where('name','model')->first();
		if(isset($model)){
			$spec_id = $model->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'model', 'description' => 'Model','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_3'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$size = DB::table('specification')->where('name','size')->first();
		if(isset($size)){
			$spec_id = $size->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'size', 'description' => 'Size(L x W x H)','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_4'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$weight = DB::table('specification')->where('name','weight')->first();
		if(isset($weight)){
			$spec_id = $weight->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'weight', 'description' => 'Weight','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_5'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$warranty_period = DB::table('specification')->where('name','warranty_period')->first();
		if(isset($warranty_period)){
			$spec_id = $warranty_period->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'warranty_period', 'description' => 'Warranty Period','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_6'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$warranty_type = DB::table('specification')->where('name','warranty_type')->first();
		if(isset($warranty_type)){
			$spec_id = $warranty_type->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'warranty_type', 'description' => 'Warranty Type++','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_7'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        /* Assign Color to product*/
		DB::table('productcolor')->where('product_id', $product_data->id)->delete();
		$colorsrgb=$request->get('colorsrgb');
		$colorshex=$request->get('colorshex');
		$colorsrgb=json_decode($colorsrgb);
		$colorshex=json_decode($colorshex);
		for($jj = 0; $jj < count($colorsrgb); $jj++){
			$colorexist = DB::table('color')->where('hex',$colorshex[$jj])->count();
			if($colorexist == 0){
				$color_id = DB::table('color')->insertGetId(['name'=> "", 'description'=> "", 'rgb'=> $colorsrgb[$jj], 'hex'=> $colorshex[$jj], "created_at"=>date("Y-m-d H:i:s"), "updated_at"=>date("Y-m-d H:i:s")]);
			} else {
				$color_id = DB::table('color')->where('hex',$colorshex[$jj])->first()->id;
			}
			$colorexist = DB::table('productcolor')->where('product_id', $product_data->id)->where('color_id', $color_id)->count();
			if($colorexist == 0){
				DB::table('productcolor')->insert(['product_id'=> $product_data->id, 'color_id'=> $color_id, "created_at"=>date("Y-m-d H:i:s"), "updated_at"=>date("Y-m-d H:i:s")]);
			}
		}
	//	$save_policy = DB::table('merchant')->where('id',$merchant_id)->update(array('return_policy' => $request->merchant_policy));

        // update data in voucher table if product type is voucher and otcvoucher
        if($product_data->type == "voucher" || $product_data->type == "otcvoucher")
        {
            $isvoucher = DB::table('voucher')->select('id')->where('product_id',$request->myproduct_id)->first();
            
            if(count($isvoucher) > 0 )
            {
                $expiry_date = date_format(date_create($request->expiry_date),"Y-m-d");

                $storeinvoucher = DB::table('voucher')
                                    ->where('id',$isvoucher->id)
                                    ->update([
                                        "product_id" => $product_data->id,
                                        "expiry" => $expiry_date,
                                        "validity" => "wmonth",
                                        // "address_id" => $address_id->id,
                                        "address_id" => '19',
                                        // "package_qty" => $request->voucher_package_qty,
                                        // "issued" => $product_data->available,
                                        "status" => 'active',
                                        "nature" => 'counter',
                                        "source" => 'opossum',
                                        "reference_no" => '0000',
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s')
                                    ]);
            }
           
        }

		$parent_id = $product_data->id;
        $ret["status"]= "success";
        $ret["pid"]=$parent_id;
        return response()->json($ret);
		return json_encode($parent_id);
	}

    public function rawproductlocations($id,$user_id=NULL)
    {
		/*
		Log::debug('***** rawproductlocations() *****');
		Log::debug('***** user_id='.$user_id.' *****');
		*/

        $locations=DB::table("locationproduct")->
        join("fairlocation","fairlocation.id","=","locationproduct.location_id")->
        where("fairlocation.user_id",$user_id)->
        where("locationproduct.product_id",$id)->
        whereNull("locationproduct.deleted_at")->select("location_id")->
        groupBy("location_id")
        ->get();

		/*
		Log::debug('***** $locations *****');
		Log::debug(json_encode($locations));
		 */
     //   dd($locations->tosql());
		$data=array();
		foreach ($locations as $k) {
			$quantity=DB::table("locationproduct")->where("product_id",$id)
			->where("location_id",$k->location_id)
			->orderBy("created_at","DESC")
			->pluck("quantity");
                //->tosql();
			$location=DB::table("fairlocation")->
				where("id",$k->location_id)->pluck("location");

			$data[$location]=$quantity;
		}
		return $data;
    }


    public function consignment($id,$user_id=NULL)
    {
        $consignment=0;
        $data=$this->rawproductlocations($id,$user_id);
        foreach ($data as $key => $value) {
            $consignment+=$value;
        }
        return $consignment;
    }

    public function productlocations($id,$uid=NULL){
		Log::debug('***** productlocations() *****');
		Log::debug('***** uid='.$uid.' *****');
			
        if (!Auth::check()) {
            return "";
        }

        $user_id=Auth::user()->id;
		if (!empty($uid) and
			(Auth::user()->hasRole("adm") or Auth::user()->hasRole("byr"))) {
            $user_id=$uid;
        }

		$data=$this->rawproductlocations($id,$user_id);

		return view('product.productlocations')->with('data', $data);
	}
	
    public function producttracking($id,$uid=null){
		Log::debug('***** producttracking() *****');

        if (!Auth::check()) {
            return view("common.generic")
                ->with('message_type','error')
                ->with('message','You do not have permission to view this page. Please contact OpenSupport #001');
        }
        
         $user_id=Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            # code...
            $user_id=$uid;
        }

        $company_id=DB::table('company')->where('owner_user_id',$uid)->whereNull('deleted_at')->pluck('id');

        if (empty($company_id)) {
            # code...
            return Redirect::back();
        }

        $is_staff=DB::table('member')
        ->where('user_id',$user_id)
        ->where('company_id',$company_id)
        ->whereNull('deleted_at')
        ->where('status','active')
        ->where('type','member')
        ->first();

        if (empty($is_staff) and Auth::user()->id!=$uid) {
            # code...
            $message_type="error";
            $message="You do not have permission to view this page";
            return view('common.generic',compact('message','message_type'));
        }
        if (!empty($is_staff)) {
            # code...
            $user_id=$uid;
        }

        $product=DB::table("product")->leftJoin("nproductid","nproductid.product_id","=","product.id")
        ->where("product.id",$id)
        ->whereNull("product.deleted_at")
        ->whereNull("nproductid.deleted_at")
        ->select("product.id","product.photo_1","nproductid.nproduct_id","product.name","product.parent_id")
        ->first();

        if (empty($product)) {
            return view("common.generic")
                ->with('message_type','error')
                ->with('message','Product does not exist. Please contact OpenSupport #001');
        }
        if (empty($product->nproduct_id)) {
            $product->nproduct_id=UtilityController::nsid($product->id);
        }
        $selluser = User::find($user_id);
		//dd($user_id);
        $company_id=DB::table("company")->where("owner_user_id",$user_id)
        ->whereNull("deleted_at")->orderBy("created_at","DESC")
        ->pluck("id");

        /* The first SELECT block is to get all TR*/
        $querystring = "
            SELECT sr.id as no,
            sr.report_no as sequence,
             sr.ttype, 
             sr.updated_at,
             DATE_FORMAT(sr.updated_at,'%d%b%y %H:%i') as date_created, l.location,
                srp.opening_balance,
                srp.received,
                srp.quantity,
                sr.status,
                srp.remark,
                srp.image,
                sr.checker_company_id,
                l2.location as location2,
                sr.creator_company_id
                FROM 
                    merchant m,
                    fairlocation l,
                    fairlocation l2,
                    stockreport sr,
                    stockreportproduct srp,
                    users u,
                    company c 
                WHERE 
                    srp.product_id=$id
                    and l.user_id=u.id 
                    and srp.stockreport_id = sr.id
                    and m.user_id=u.id 
                    and sr.status = 'confirmed'
                    and m.user_id=c.owner_user_id 
                    and sr.creator_location_id = l.id
                    and sr.checker_location_id=l2.id
                    
                UNION
                SELECT
                    salesmemo.id as no,
                    salesmemo.salesmemo_no as sequence,
                    'smemo' as ttype,
                    salesmemo.updated_at,
                    DATE_FORMAT(salesmemo.updated_at,'%d%b%y %H:%i') as date_created,
                    fairlocation.location,
                    0 as opening_balance,
                    0 as received,
                    0 as image,
                    0 as remark,
                    salesmemoproduct.quantity as quantity,
                    salesmemo.status,
                    '0' as checker_company_id,
                    '-' as location2,
                    '0' as creator_company_id

                FROM
                    salesmemo 
                    JOIN salesmemoproduct on salesmemoproduct.salesmemo_id=salesmemo.id
                    JOIN merchantproduct on merchantproduct.product_id=salesmemoproduct.product_id
                    JOIN merchant on merchant.id=merchantproduct.merchant_id
                    JOIN users on users.id=merchant.user_id
                    JOIN fairlocation on fairlocation.id=salesmemo.fairlocation_id
                WHERE
                    salesmemoproduct.product_id=$id

                UNION
                SELECT
                    opr.id as no,
                    opr.receipt_no as sequence,
                    'sales' as ttype, 
                    opr.updated_at,
                    DATE_FORMAT(opr.updated_at,'%d%b%y %H:%i') as date_created,
                    fairlocation.location,
                    0 as opening_balance,
                    0 as received,
                    oprp.quantity,
                    opr.status,
                    '' as remark,
                    '' as image,
                    '0' as checker_company_id,
                    '-' as location2,
                    '0' as creator_company_id
                    
                FROM 
                    opos_receipt opr 
                    JOIN opos_receiptproduct oprp on oprp.receipt_id=opr.id
                    JOIN merchantproduct on merchantproduct.product_id=
                    oprp.product_id
                    JOIN merchant on merchant.id=merchantproduct.merchant_id
                    JOIN opos_locationterminal oplt on oplt.terminal_id=opr.terminal_id
                    JOIN fairlocation on fairlocation.id=oplt.location_id
                WHERE
                    oprp.product_id=$id
                    AND opr.status IN ('completed','voided')

                ORDER BY updated_at DESC";

        if ($product->id!=$product->parent_id) {
            /*Important to prevent same product being counted twice*/
            $querystring="SELECT sr.id as no,
            sr.report_no as sequence,
             sr.ttype, 
             sr.updated_at,
             DATE_FORMAT(sr.updated_at,'%d%b%y %H:%i:%s') as date_created, l.location,
                srp.opening_balance,
                srp.received,
                srp.quantity,
                sr.status,
                srp.remark,
                srp.image,
                sr.checker_company_id,
                l2.location as location2,
                sr.creator_company_id
                FROM 
                    merchant m,
                    fairlocation l,
                    fairlocation l2,
                    stockreport sr,
                    stockreportproduct srp,
                    users u,
                    company c 
                WHERE 
                    srp.product_id=$product->parent_id
                    and l.user_id=u.id 
                    and sr.ttype='treport'
                    and srp.stockreport_id = sr.id
                    and m.user_id=u.id 
                    and sr.status = 'confirmed'
                    and sr.checker_company_id=c.id 
                    and l.id=sr.checker_location_id
                    and sr.checker_location_id=l2.id
            UNION ".$querystring;
        }
		

		/*return $querystring;*/
		$data = DB::select(DB::raw($querystring));
       


		//dd($data);
		return view('product.producttrackings')	
            ->with('data', $data)
            ->with("selluser",$selluser)
            ->with("product",$product)
            ->with("company_id",$company_id)
            ;
	}
	
    public function productmapping($selluser,$id){

        if (!Auth::check()) {
            return "Please login";
        }

        $user_id=Auth::user()->id;
        $merchant=DB::table("merchant")->whereNull("deleted_at")->where("user_id",$selluser)->first();
        // dump($merchant);
        if (empty($merchant)) {
            return "Merchant not valid";
        }

		$product=DB::table('product')
		->leftJoin('nproductid','product.id','=','nproductid.product_id')
		->leftJoin('productqr','product.id','=','productqr.product_id')
		->leftJoin('qr_management','qr_management.id','=','productqr.qr_management_id')
		->leftJoin('productbc','product.id','=','productbc.product_id')
		->leftJoin('bc_management','bc_management.id','=','productbc.bc_management_id')
		->select(DB::raw("IFNULL(nproductid.nproduct_id,
			LPAD(product.id,16,'E')) as product_id,
			qr_management.image_path as qrpath,
			bc_management.id as bc_management_id,
			productbc.id as productbc_id,
			bc_management.image_path as bcpath,
			bc_management.barcode as bcode,
			bc_management.barcode_type as bcode_type,
			product.parent_id as parent_id,
			product.sku,
			product.id"))
        // ->whereNull('productbc.deleted_at')
		->where('product.id',$id)
        ->first();


        // dump($product);exit();
		return view('product.productmapping')	
			->with('selluser', $selluser)
            ->with('product', $product);
	}
    public function productbarmapping($selluser,$id){

        if (!Auth::check()) {
            return "Please login";
        }
        $user_id=Auth::user()->id;
		$merchant=DB::table("merchant")->
			whereNull("deleted_at")->where("user_id",$selluser)->first();
        // dump($merchant);

        if (empty($merchant)) {
            return "Merchant not valid";
        }

        $product=DB::table('product')
        ->leftJoin('nproductid','product.id','=','nproductid.product_id')
        ->leftJoin('productqr','product.id','=','productqr.product_id')
        ->leftJoin('qr_management','qr_management.id','=','productqr.qr_management_id')
        ->leftJoin('productbc','product.id','=','productbc.product_id')
        ->leftJoin('bc_management','bc_management.id','=','productbc.bc_management_id')
        ->select(DB::raw("IFNULL(nproductid.nproduct_id,
            LPAD(product.id,16,'E')) as product_id,
            qr_management.image_path as qrpath,
            bc_management.id as bc_management_id,
            productbc.id as productbc_id,
            bc_management.image_path as bcpath,
            bc_management.barcode as bcode,
            bc_management.barcode_type as bcode_type,
            product.parent_id as parent_id,
            product.sku,
            product.name,
            product.id"))
        ->whereNull('productbc.deleted_at')
        ->whereNull("bc_management.deleted_at")
        ->where("product.id",$id)
        ->first();


        $barcodes=DB::table("bc_management")
		  ->join("productbc","productbc.bc_management_id","=","bc_management.id")
          ->leftjoin('orderproductwarranty as opw','bc_management.id','=','opw.serial_bc_mgmt_id')
            ->leftjoin('orderproductwarranty as opws','bc_management.id','=','opws.warranty_bc_mgmt_id')
            ->leftjoin('orderproductqty as opq', 'opw.orderproductqty_id','=','opq.id')
            ->leftjoin('orderproductqty as opqs', 'opws.orderproductqty_id','=','opqs.id')
            ->leftjoin('orderproduct as op','op.id','=','opq.orderproduct_id')
            ->leftjoin('orderproduct as ops','ops.id','=','opqs.orderproduct_id')
            ->leftjoin('porder','porder.id','=','op.porder_id')
            ->leftjoin('porder as p','p.id','=','ops.porder_id')
            ->leftjoin('invoice','invoice.porder_id','=','porder.id')
            ->leftjoin('invoice as i','i.porder_id','=','p.id')
		    ->select("bc_management.image_path as bcpath",
			"bc_management.barcode as bcode",
			"bc_management.id as bc_management_id",
			"bc_management.barcode_type as bcode_type",
			"bc_management.source",
              "invoice.invoice_no",
                "opw.serial_used",
                "opw.warranty_used",
                "opws.warranty_used as w_used",
                "opws.serial_used as s_used",
                "i.invoice_no as inv",
              "porder.id as pid",
              "p.id as pidd"
			)
		  ->whereNull("bc_management.deleted_at")
		  ->whereNull("productbc.deleted_at")
		  ->where("productbc.product_id",$id)
		  ->orderBy("bc_management.id",'desc')
		  ->get();
          //  dd($barcodes);

		return view('product.productbarmapping',
			compact('selluser','product',"barcodes")); 
    }

	
    /**
     * @api {post} /product/map/delete Delete Mapping Record for the Product
     * @apiName DeleteProductMapping
     * @apiGroup Product
     *
     * @apiParam {Number} product_id Products unique ID.
     * @apiPermission Merchant Admin
     * @apiSuccess {String} status success.
     * @apiSuccess {String} long_message .
     * @apiFailure {String} status failure
     */

	public function sku(Request $r, $id){
		DB::table('product')->where('id',$id)->update(['sku'=>$r->data]);
		return response()->json(['status'=>'success']);
	}	 

	 
    public function product_map_delete(Request $r)
    {
        /*Validation*/
        $ret=array();
        $ret['status']="failure";
        $ret['long_message']="Validation 1 failure";

        if (!Auth::check()  ) {
            $ret['long_message']='Authorization Failure';
            return response()->json($ret);
        }
        if (!$r->has('pid')) {
            # code...
            $ret['long_message']='Bad Request Error';
            return response()->json($ret);
        }

        $user_id=$r->selluser;
        $product_id=$r->pid;
        $validator=DB::table('merchantproduct')->
			join('product','product.id','=','merchantproduct.product_id')->
			join('merchant','merchant.id','=','merchantproduct.merchant_id')->
			join('users','users.id','=','merchant.user_id')->
			whereNull('users.deleted_at')->
			where('users.id','=',$user_id)->
			where('product.id','=',$product_id)->
			first();

        if (empty($validator)) {
            $ret['long_message']="Validation 2 failure";
            return response()->json($ret);
        }
        try {
            $data=DB::table('productbc')->
				join('bc_management','bc_management.id','=',
					'productbc.bc_management_id')->
				where('productbc.product_id',$product_id)->
                select("productbc.id as pbid","bc_management.id as bcid",
					"bc_management.image_path","productbc.product_id")->
				first();

			if (!empty($data)) {
				DB::table("productbc")->where("id",$data->pbid)->delete();
				DB::table("bc_management")->where("id",$data->bcid)->delete();

				/* Delete the image file of barcode */   
				$image_path='barcode/'.$data->product_id.'/'.
					$data->image_path;

				Log::debug('image_path='.$image_path);
				Storage::disk('images')->delete($image_path);

				$ret['status']="success";
				$ret['long_message']="Product's mapping has been deleted.";

			} else {
				$ret['status']="error";
				$ret['long_message']="Product's mapping is NOT found! Please refresh your browser.";
			}

        } catch (\Exception $e) {
            $ret['short_message']=$e->getMessage();
			Log::error($e->getFile().":".$e->getLine().":".$e->getMessage());
        }
        return response()->json($ret);
    }

    /**
     * 
     */
    public function get_product_details($id){
		$pdetail = DB::table('productdetail')->where('id',$id)->first();
		if(!is_null($pdetail)){
			$pdetail = $pdetail->data;
		} else {
			$pdetail = "-";
		}
		return $pdetail;
	}
    public function storep(ProductRequest $request)
    {
        $user_id = Auth::user()->id;
        $merchant_data = Merchant::where('user_id', $user_id)->first();
        $merchant_id = $merchant_data->id;
        /*Validation if the same name product for the merchant already exists*/
        $name_exists=DB::table("product")->join("merchantproduct","merchantproduct.product_id","=","product.id")
        ->where("product.name",$name)
        ->where("merchantproduct.merchant_id",$merchant_id)
        ->whereNull("product.deleted_at")
        ->first();
        if (!empty($name_exists)) {
            # code...
             return redirect()->back()->with('message', 'A product with similar name already exists. Please change name');
        }
        $product = new Product();
        $product_data = $product->storep($request);

        $file = $request->get('pimage');
        $fileNameUniq = uniqid();
        $destinationPath = public_path().'images/product/'.$product->id.'/';

        if(isset($file)) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            $fileName = uniqid();
            if (move_uploaded_file($file, 'images/product/' . $product->id . '/' . $fileName . '.' . $extension)) {
                $product->photo_1 = $fileName . '.' . $extension;
            }
        }

        $merchant_pro = new MerchantProduct();
        $merchant_pro_data = $merchant_pro->storeproduct($product_data, $merchant_id);

        /*
         * save product to profile product table
         */
        /*----Get Logged User Profile---
        if (Session::has('profile_id')) {
            $profile_id = session()->get("profile_id");
            /*----Save product in ProfileProduct Table-
            $profile_product = new ProfileProduct();
            $profile_product->profile_id = $profile_id;
            $profile_product->product_id = $product_data->id;
            $profile_product->save();
        }

        /********End ProfileProduct***************/
        /*$spec = new Specification();
        $specification = $spec->storespecification();*/

        $color = DB::table('specification')->where('name','color')->first();
        if(isset($color)){
            $spec_id = $color->id;
        } else {
            $spec_id =  DB::table('specification')->insertGetId(['name' => 'color', 'description' => 'Color','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }
        $specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_2'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

        $model = DB::table('specification')->where('name','model')->first();
        if(isset($model)){
            $spec_id = $model->id;
        } else {
            $spec_id =  DB::table('specification')->insertGetId(['name' => 'model', 'description' => 'Model','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }
        $specprod = DB::table('productspec')->
			insertGetId([
				'product_id' => $product_data->id,
				'spec_id' => $spec_id,
				'value' => $request->get('product_specification_3'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			]);

        $size = DB::table('specification')->where('name','size')->first();
        if(isset($size)){
            $spec_id = $size->id;
        } else {
            $spec_id =  DB::table('specification')->insertGetId(['name' => 'size', 'description' => 'Size(L x W x H)','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }
        $specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_4'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

        $weight = DB::table('specification')->where('name','weight')->first();
        if(isset($weight)){
            $spec_id = $weight->id;
        } else {
            $spec_id =  DB::table('specification')->insertGetId(['name' => 'weight', 'description' => 'Weight','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }
        $specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_5'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

        $warranty_period = DB::table('specification')->where('name','warranty_period')->first();
        if(isset($warranty_period)){
            $spec_id = $warranty_period->id;
        } else {
            $spec_id =  DB::table('specification')->insertGetId(['name' => 'warranty_period', 'description' => 'Warranty Period','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }
        $specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_6'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

        $warranty_type = DB::table('specification')->where('name','warranty_type')->first();
        if(isset($warranty_type)){
            $spec_id = $warranty_type->id;
        } else {
            $spec_id =  DB::table('specification')->insertGetId(['name' => 'warranty_type', 'description' => 'Warranty Type++','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }
        $specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_7'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        /* Assign Specification to product
        */
        /*
        * Unit and price section....Wholesaletable
        */
        $wholesale = new Wholesale();
        $wholesale->storewholesale($request, $product_data);
        /*
        * Dealer section with speacial price....productdealer table
        */
        $productDealer = new ProductDealer();
        $productDealer->stroeproductDealer($request, $product_data);
        /***/
        /***/
        //$product_spec = new Productspec();
        // $product_spec = new Productspec();
        // $product_specification = $product_spec->AssignSpec($product_data,$specification,$request);
 //       $save_policy = DB::table('merchant')->where('id',$merchant_id)->update(array('return_policy' => $request->merchant_policy));
        /*
        * Saved Category in mechant Category table
        */

        $merchant_category = new MerchantCategory();
        $merchant_category_data = $merchant_category->storecategory($request, $merchant_id);
		/***/
		$parent_id = $product_data->id;
		$product_new = Product::where('id', $parent_id)->first();
		$photo = $product_new->photo_1;
		/***/

        $product = new Product();
        $product_data = $product->storeb2b($request,$parent_id,$photo);
        Session::flash('album', 'Product Registered');

        return redirect()->back()->with('message', 'Product Registered.');
    }

    public function productb2b($product_id)
    {
        $enableSpecialAndWholesalePrice = 0;
        $user_id  = Auth::id();
        $showAutolink =  0;
		$merchant_id = 0;
		$getMerchant =  Merchant::where('user_id', $user_id)->first();
		if(!is_null($getMerchant)){
			$merchant_id = $getMerchant->id;
		}

        $getInitiatorOrResponder =  Autolink::where('initiator', $user_id)->orWhere('responder', $merchant_id)->first();



        if(isset($getInitiatorOrResponder) or isset($getMerchant)){
            $viewForDealers = 1;
        }else{
            $viewForDealers = 0;
        }

        if ($viewForDealers){
            $products = $this->getProductsForDealers($product_id);
        }else {
            $products = $this->getProductsForRegularUsers($product_id);
        }


        $coverage = $this->getCoverageAddress($product_id);
        $specs = $this->getSpecifications($product_id);

        return view('productb2b')->withProducts($products[0])
                            ->withCoverage($coverage[0])
                            ->withSpecs($specs);

    }

    public function storepedit(ProductRequest $request)
    {
		$user_id = Auth::user()->id;
        $merchant_data = Merchant::where('user_id', $user_id)->first();
        $merchant_id = $merchant_data->id;

		$hsfile = $request->hasFile('product_photo');
		$product = new Product();
		$product_data = $product->storepedit($request,$hsfile);
		if($hsfile){
			$file = $request->file('product_photo');
			$fileNameUniq = uniqid();
			$destinationPath = public_path() . 'images/product/' . $product->id . '/';

			$extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

			$fileName = uniqid();
			if (move_uploaded_file($file, 'images/product/' . $product->id . '/' . $fileName . '.' . $extension)) {
				$product->photo_1 = $fileName . '.' . $extension;
			}
		}
		DB::table('productspec')->where('product_id', $product_data->id)->delete();
		$color = DB::table('specification')->where('name','color')->first();
		if(isset($color)){
			$spec_id = $color->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'color', 'description' => 'Color','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_2'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$model = DB::table('specification')->where('name','model')->first();
		if(isset($model)){
			$spec_id = $model->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'model', 'description' => 'Model','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_3'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$size = DB::table('specification')->where('name','size')->first();
		if(isset($size)){
			$spec_id = $size->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'size', 'description' => 'Size(L x W x H)','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_4'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$weight = DB::table('specification')->where('name','weight')->first();
		if(isset($weight)){
			$spec_id = $weight->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'weight', 'description' => 'Weight','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_5'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$warranty_period = DB::table('specification')->where('name','warranty_period')->first();
		if(isset($warranty_period)){
			$spec_id = $warranty_period->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'warranty_period', 'description' => 'Warranty Period','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_6'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$warranty_type = DB::table('specification')->where('name','warranty_type')->first();
		if(isset($warranty_type)){
			$spec_id = $warranty_type->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'warranty_type', 'description' => 'Warranty Type++','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product_data->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_7'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        /* Assign Specification to product
        */
        /*
        * Unit and price section....Wholesaletable
        */
		DB::table('wholesale')->where('product_id', $product_data->id)->delete();
        $wholesale = new Wholesale();
        $wholesale->storewholesale($request, $product_data);
        /*
        * Dealer section with speacial price....productdealer table
        */
		DB::table('productdealer')->where('product_id', $product_data->id)->delete();
        $productDealer = new ProductDealer();
        $productDealer->stroeproductDealer($request, $product_data);
		/***/
		/***/
        //$product_spec = new Productspec();
        // $product_spec = new Productspec();
        // $product_specification = $product_spec->AssignSpec($product_data,$specification,$request);
	//	$save_policy = DB::table('merchant')->where('id',$merchant_id)->update(array('return_policy' => $request->merchant_policy));

		/***/
		$parent_id = $product_data->id;
		$product_new = Product::where('id', $parent_id)->first();
		$photo = $product_new->photo_1;
		/***/
		$product_b2b = Product::where('parent_id', $parent_id)->where('segment', 'b2b')->first();
		$product = new Product();
		if(is_null($product_b2b)){
			$product_data = $product->storeb2b($request,$parent_id,$photo);
		} else {
			$product_data = $product->storeb2bedit($request,$parent_id,$photo);
		}

		Session::flash('albumupdated', 'Product Updated');

        return redirect()->back()->with('message', 'Product Updated.');
	}

    private function getProductsForDealers($product_id) {

        $user_id = Auth::id();

        try {
            $products = DB::select(DB::raw("SELECT 
					pr.id AS id,
					pr2.id AS sid, 
					pr.name AS description,
					pr.name AS pname, 
					pr.retail_price AS retailprice, 
					pr.discounted_price AS discountedprice, 
					pr.available as available, 
					pr.photo_1 AS image, 
					pr.free_delivery AS free, 
					pr.free_delivery_with_purchase_qty AS free_qty, 
					pr.subcat_level AS subcat_level, 
					pr.subcat_id AS subcat_id, 
					pr.b2b_del_worldwide AS worldwide_price,
					pr.b2b_del_west_malaysia AS west_malaysia_price, 
					pr.b2b_del_sabah_labuan AS sabah_labuan_price,
					pr.b2b_del_sarawak AS sarawak_price, 
					br.name AS brand, 
					m.oshop_name AS oshop,
					CONCAT(u.first_name, ' ', u.last_name) AS sellername

					FROM  product pr, product pr2,brand br,merchant m, merchantproduct op,users u, wholesale w, productdealer pd

					WHERE pr.oshop_selected = 1 AND pr2.parent_id = pr.id AND pr2.segment = 'b2b' AND ((pr2.id = w.product_id and w.price > 0)
					OR (pr2.id = pd.product_id and pd.special_price > 0)) AND pr.id = $product_id AND pr.id = op.product_id
					AND pr.brand_id = br.id AND op.merchant_id = m.id
					AND m.user_id = u.id
					GROUP BY pr.id"));

        } catch(QueryException $e){
              throw new CustomException($e->getMessage());
        }

        $products = is_array($products) && !empty($products) ? $products : null;
        if (isset($products)) {
            $sl = $products[0]->subcat_level;
            $sid = $products[0]->subcat_id;
            $subcat = DB::table('subcat_level_'.$sl)->where('id', $sid)->first(['name', 'category_id']);
            if (isset($subcat)) {
                $category = DB::table('category')->where('id', $subcat->category_id)->first()->name;
                $products[0]->category = str_replace("_"," ",$category);
                $products[0]->subcategory = str_replace("_"," ",$subcat->name);
            } else {
                $products[0]->category = null;
                $products[0]->subcategory = null;
            }

            $return_address = $this->getReturnAddress($product_id);
            if(isset($return_address)) {
                $products[0]->return_address = $return_address[0]->ra;
            } else {
                $products[0]->return_address = null;
            }
        }

        return $products;
    }

    private function getProductsForRegularUsers($product_id) {

        $user_id = Auth::id();

        try {
            $products = DB::select(DB::raw("SELECT pr.id AS id, pr.name AS description, pr.name AS pname, pr.retail_price
                        AS retailprice, pr.discounted_price AS discountedprice, pr.available as available, pr.photo_1 AS image,
                        pr.free_delivery AS free, pr.free_delivery_with_purchase_qty AS free_qty, pr.subcat_level AS subcat_level,
                        pr.subcat_id as subcat_id, pd.special_price AS specialprice, pr.b2b_del_worldwide AS worldwide_price,
                        pr.b2b_del_west_malaysia AS west_malaysia_price, pr.b2b_del_sabah_labuan AS sabah_labuan_price,
                        pr.b2b_del_sarawak AS sarawak_price, br.name AS brand, m.oshop_name AS oshop,
                        CONCAT(u.first_name, ' ', u.last_name) AS sellername, c.name AS sellercountry, cty.name AS sellercity,
                        st.name AS sellerstate, ad.postcode AS sellerpostcode, ar.name AS sellerarea,
                        CONCAT(ad.line1,' ',ad.line2,' ',ad.line3,' ',ad.line4) AS shipping_address FROM  product pr, brand br,
                        merchant m, merchantproduct op, productdealer pd, country c, city cty, state st, address ad, users u, area ar
                        WHERE pr.oshop_selected = 1 AND pr.display_non_autolink = true
                        AND pd.product_id = pr.id  AND pr.id = $product_id AND pr.id = op.product_id
                        AND pr.brand_id = br.id AND ar.id = ad.area_id AND op.merchant_id = m.id AND m.address_id = ad.id
                        AND ad.city_id = cty.id AND cty.state_code = st.code AND st.country_code = c.code AND m.user_id = u.id
                        GROUP BY pr.id"));

        } catch(QueryException $e){
              throw new CustomException($e->getMessage());
        }

        $products = is_array($products) && !empty($products) ? $products : null;
        if (isset($products)) {
            $sl = $products[0]->subcat_level;
            $sid = $products[0]->subcat_id;
            $subcat = DB::table('subcat_level_'.$sl)->where('id', $sid)->first(['name', 'category_id']);
            if (isset($subcat)) {
                $category = DB::table('category')->where('id', $subcat->category_id)->first()->name;
                $products[0]->category = str_replace("_"," ",$category);
                $products[0]->subcategory = str_replace("_"," ",$subcat->name);
            } else {
                $products[0]->category = null;
                $products[0]->subcategory = null;
            }

            $return_address = $this->getReturnAddress($product_id);
            if(isset($return_address)) {
                $products[0]->return_address = $return_address[0]->ra;
            } else {
                $products[0]->return_address = null;
            }
        }

        return $products;
    }

    private function getReturnAddress($product_id) {
        try {
            $return_address  =  DB::select(DB::raw("SELECT CONCAT(ad.line1,' ',ad.line2,' ',ad.line3,' ',ad.line4) AS ra
                                FROM merchantproduct op, address ad, merchant m WHERE op.product_id = $product_id AND
                                op.merchant_id = m.id AND m.return_address_id = ad.id"));
        } catch(QueryException $e){
              throw new CustomException($e->getMessage());
        }

        $return_address = is_array($return_address) && !empty($return_address) ? $return_address : null;

        return $return_address;
    }

    private function getCoverageAddress($product_id) {
        try {
            $coverage_address = DB::select(DB::raw("SELECT c.name AS delivery_country, cty.name AS delivery_city, st.name AS                delivery_state, ar.name AS delivery_area FROM product pr, area ar, country c, city cty,
                                state st WHERE pr.id = $product_id AND pr.b2b_cov_city_id = cty.id AND pr.b2b_cov_state_id = st.id
                                AND pr.b2b_cov_country_id = c.id AND pr.b2b_cov_area_id = ar.id"));

        } catch(QueryException $e){
              throw new CustomException($e->getMessage());
        }

        $coverage = is_array($coverage_address) && !empty($coverage_address) ? $coverage_address : null;

        return $coverage;
    }

    private function getSpecifications($product_id) {
        try {
            $product_specs =  DB::select(DB::raw("SELECT sp.description AS spec, ps.value AS value FROM specification sp,
                              productspec ps WHERE ps.product_id = $product_id AND ps.spec_id = sp.id"));
        } catch(QueryException $e){
              throw new CustomException($e->getMessage());
        }

        $specs = is_array($product_specs) && !empty($product_specs) ? $product_specs : null;

        return $specs;
    }

	public function update_availability(Request $request, $id)
    {
		$available = $request->get('available');
		DB::table('product')->where('id', $id)->update(['available'=>$available]);
		return json_encode("OK");
	}
	
	public function update_brand(Request $request, $id)
    {
		$brand = $request->get('brand');
		DB::table('product')->where('id', $id)->update(['brand_id'=>$brand]);
		return json_encode("OK");
	}	
	
	public function update_category(Request $request, $id)
    {
		$category = $request->get('category');
		DB::table('product')->where('id', $id)->update(['category_id'=>$category]);
		return json_encode("OK");
	}	
	
	public function update_subcategory(Request $request, $id)
    {
		$subcategory = $request->get('subcategory');
		$subcatarr = explode("-", $subcategory);
		DB::table('product')->where('id', $id)->update(['subcat_id'=>$subcatarr[0], 'subcat_level'=>$subcatarr[1]]);
		return json_encode("OK");
	}		
	
    public function productconsumer(Request $request, $id, $openwish_id = '')
    {
        $button_status=True;
        $merchant=False;
		$user_id = 0;
       if(Auth::check()){
            $user_id = Auth::user()->id;
            $role=DB::table('role_users')->where('user_id',$user_id)->pluck('role_id');
            if ($role==3) {
                # Merchant is Yes now.

                $merchant=True;
                $button_status=True;
                $merchant_id=DB::table('merchant')->where('user_id',$user_id)->pluck('id');
            }
            if ($role==1){
                // Lazy Bypass. Bad 
                $button_status=False;
            }
			$productvisits=DB::table('productvisit')->where('user_id',$user_id)->where('product_id',$id)->first();
			if(is_null($productvisits)){
				DB::table('productvisit')->insert(['user_id'=>$user_id,'product_id'=>$id,'counter'=>1]);
			} else {
				DB::table('productvisit')->where('id',$productvisits->id)->update(['counter'=>($productvisits->counter + 1)]);
			}
			
			$checkproduct= Product::where('product.id',$id)
            ->join('oshopproduct','oshopproduct.product_id','=','product.id')
            ->join('oshop','oshop.id','=','oshopproduct.oshop_id')
            ->join('merchantproduct','merchantproduct.product_id','=','product.parent_id')
            ->join('merchant','merchant.id','=','merchantproduct.merchant_id')
			->where('product.available','>',0)
			->where('product.status','active')
			->where('product.retail_price','>',0)
			->where('product.oshop_selected',true)
            ->where('merchant.status','active')
            ->where('oshop.status','active')
			->first();
		//dd($checkproduct);
			$checkmerchant= Product::where('product.id',$id)
		//	->where('product.available','>',0)
		//	->where('product.status','active')
		//	->where('product.retail_price','>',0)
		//	->where('product.oshop_selected',true)
			->select('merchant.status as merchant_status', 'merchant.user_id as userid')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->first();
		//	dd($checkmerchant);
			if(is_null($checkmerchant)){
    
				return view('error');
			} else {
				if($checkmerchant->merchant_status != 'active'){
					return view('error');
				}
			}		
			
			if(is_null($checkproduct) && !(Auth::user()->hasRole('adm') || $checkmerchant->userid == $user_id)){
				 return view('producterror');
			}		
				
        } else {
			$checkproduct= Product::where('product.id',$id)
            ->join('oshopproduct','oshopproduct.product_id','=','product.id')
            ->join('oshop','oshop.id','=','oshopproduct.oshop_id')
            ->join('merchantproduct','merchantproduct.product_id','=','product.parent_id')
            ->join('merchant','merchant.id','=','merchantproduct.merchant_id')
			->where('product.available','>',0)
			->where('product.status','active')
			->whereNull('product.deleted_at')
			->where('product.retail_price','>',0)
			->where('product.oshop_selected',true)
            ->where('merchant.status','active')
            ->where('oshop.status','active')
			->first();
			
			$checkmerchant= Product::where('product.id',$id)
		//	->where('product.available','>',0)
		//	->where('product.status','active')
			//->where('product.retail_price','>',0)
		//	->where('product.oshop_selected',true)
			->select('merchant.status as merchant_status', 'merchant.user_id as userid')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->first();
		//	dd($checkmerchant);
			if(is_null($checkmerchant)){
				return view('error');
			} else {
				if($checkmerchant->merchant_status != 'active'){
					return view('error');
				}
			}		
			//dd("Hola");
			if(is_null($checkproduct)){
				 return view('producterror');
			} 
			
		}
		$checkdelete= Product::where('id',$id)->first();
		if(!is_null($checkdelete->deleted_at)){
			return view('producterror');
		}
		

        if ($id)
            $data['pro'] = Product::with(["brand", 'category', 'Country', 'State', 'City', 'Area', 'wholesale', 'productdealer'])->where('product.id',$id)->leftJoin('productdetail','product.productdetail_id','=','productdetail.id')->select('product.*','productdetail.data as product_details')->first();
        else
            $data['pro'] = Product::with(["brand", 'category', 'Country', 'State', 'City', 'Area', 'wholesale', 'productdealer'])->leftJoin('productdetail','product.productdetail_id','=','productdetail.id')->select('product.*','productdetail.data as product_details')->first();

           // dd($data['pro']);
        
        $data['specifications'] = Product::leftJoin('productspec as ps', 'product.id', '=', 'ps.product_id')
            ->join('specification as s', 's.id', '=', 'ps.spec_id')
            ->where('product.id', $id)
			->get();
        if (!empty($openwish_id)) {
            $pledgeAllowed=1; //1 means pledge is allowed
            $product = Product::with('merchant')
            ->where('product.available','>',0)
            ->where('product.status','active')
            ->where('product.retail_price','>',0)
            ->where('product.oshop_selected',true)
            ->find($id);

            // return $product;
            $pledge_amt = OpenWishPledge::select(DB::raw('SUM(pledged_amt) as pledged_amt'))->where('openwish_id', $openwish_id)->first()->pledged_amt;
            
            $ow=OpenWish::find($openwish_id);
            $p=Product::find($id);
            $prc=new PriceController;
            $productPrice=$prc->init($id);
            // dump($productPrice);
            try {
                 if ($ow->status!='active') {
                $pledgeAllowed=0;
            }
            } catch (\Exception $e) {
                return view('error');
            }
            
            // Find if pledge is fullfilled.
            // Get Product Price , get delivery Add them up. and compare with pledge value.
            $del= new Delivery;
            $pp=UtilityController::realPrice($p->id);
            $delivery=$del->get_delivery_price($p->id,1);
            $max_amount=($pp+$delivery)-$pledge_amt;
          
            $profile = Merchant::withProfile($product->merchant->first()->id);
						
            return view('openwish_pledge')
                ->with('openwish_id', $openwish_id)
                ->with('product_id', $id)
                ->with('profile', $profile)
                ->with('pledged_amt', $pledge_amt)
                ->with('pledgeAllowed',$pledgeAllowed)
                ->with('max_amount',$max_amount)
                ->with('product', $product);
        }

        //We need to get Product from openwish;
//        $productOpenWish = OpenWish::where('product_id', $id)->first();
//
        $summary = null;
//		if ($productOpenWish) {
//			$fb = new Facebook(Config::get('facebook.credentials'));
//
//			//We need to get insights for this product share, link
//			$linkId = $productOpenWish->link_id;
//			$request = $fb->get('/'.$linkId.'/likes?summary=true',
//							Auth::user()->access_token);
//			//Get Meta data from facebook. in this case we are asking for likes
//			//If we need comment we substitute 'likes' with 'comments'
//			$response= $request->getGraphEdge();
//			$metaData = $response->getMetaData();
//			$summary = $metaData['summary'];
//		}
		$product_spec = null;
		$data['subcat_level'] = null;
		$data['subcat_level1'] = null;
		$data['subcat_level_1_id'] = null;
		$data['subcat_level2'] = null;
		$data['subcat_level_2_id'] = null;
		$data['subcat_level3'] = null;
		$data['subcat_level_3_id'] = null;
		$data['colors'] = DB::table('productcolor')->join('color','productcolor.color_id','=','color.id')->where('productcolor.product_id',$id)->get();

        if ($data) {
			$data['subcat_level'] = $data['pro']->subcat_level;
				if($data['subcat_level'] == 3){
					$subcat_level3_idc = SubCatLevel3::where('id', $data['pro']->subcat_id)->first();
					if(!is_null($subcat_level3_idc)){
						$data['subcat_level_3_id'] = $subcat_level3_idc->id;
						$data['subcat_level_2_id'] = $subcat_level3_idc->subcat_level_2_id;
						$data['subcat_level_1_id'] = $subcat_level3_idc->subcat_level_1_id;
						$data['subcat_level3'] = $subcat_level3_idc;
						$data['subcat_level2'] = SubCatLevel2::where('subcat_level_1_id', $subcat_level3_idc->subcat_level_1_id)->where('category_id', $data['pro']->category_id)->where('id', $subcat_level3_idc->subcat_level_2_id)->first();							
						$data['subcat_level1'] = SubCatLevel1::where('category_id', $data['pro']->category_id)->where('id', $subcat_level3_idc->subcat_level_1_id)->first();					
					}								
				} else if($data['subcat_level'] == 2){
					$subcat_level2_idc = SubCatLevel2::where('id', $data['pro']->subcat_id)->first();
					if(!is_null($subcat_level2_idc)){
						$data['subcat_level_2_id'] = $subcat_level2_idc->id;
						$data['subcat_level_1_id'] = $subcat_level2_idc->subcat_level_1_id;
						$data['subcat_level2'] = $subcat_level2_idc;			
						$data['subcat_level1'] = SubCatLevel1::where('category_id', $data['pro']->category_id)->where('id', $subcat_level2_idc->subcat_level_1_id)->first();					
					}					
				} else if($data['subcat_level'] == 1){
					$subcat_level1_idc = SubCatLevel1::where('id', $data['pro']->subcat_id)->first();
					if(!is_null($subcat_level1_idc)){
						$data['subcat_level_1_id'] = $subcat_level1_idc->id;						
						$data['subcat_level1'] = $subcat_level1_idc;					
					}					
				}
            $level = $data['pro']->subcat_level;
            if ($level == 1) {
                $data['sub_product'] = SubCatLevel1::find($data['pro']->subcat_id);
                $data['specification'] = Product::leftJoin('subcat_level_1 as s1', 'product.subcat_id', '=', 's1.id')
                    ->leftJoin('subcat_level_1spec as ss1', 's1.id', '=', 'ss1.subcat_level_1_id')
                    ->leftJoin('specification as s', 's.id', '=', 'ss1.spec_id')
                    ->leftJoin('productspec as ps', 'product.id', '=', 'ps.product_id')
                    ->where('product.id', $id)
                    ->select(DB::raw('distinct(s.id),s.description,ps.value'))->get();
            } else if ($level == 2) {
                $data['sub_product'] = SubCatLevel2::find($data['pro']->subcat_id);
                $data['specification'] = Product::leftJoin('subcat_level_2 as s1', 'product.subcat_id', '=', 's1.id')
                    ->leftJoin('subcat_level_2spec as ss1', 's1.id', '=', 'ss1.subcat_level_2_id')
                    ->leftJoin('specification as s', 's.id', '=', 'ss1.spec_id')
                    ->leftJoin('productspec as ps', 'product.id', '=', 'ps.product_id')
                    ->where('product.id', $id)
                    ->select(DB::raw('distinct(s.id),s.description,ps.value'))->get();
            } else if ($level == 3) {
                $data['sub_product'] = SubCatLevel3::find($data['pro']->subcat_id);
                $data['specification'] = Product::leftJoin('subcat_level_3 as s1', 'product.subcat_id', '=', 's1.id')
                    ->leftJoin('subcat_level_3spec as ss1', 's1.id', '=', 'ss1.subcat_level_3_id')
                    ->leftJoin('specification as s', 's.id', '=', 'ss1.spec_id')
                    ->leftJoin('productspec as ps', 'product.id', '=', 'ps.product_id')
                    ->where('product.id', $id)
                    ->select(DB::raw('distinct(s.id),s.description,ps.value'))->get();
            }
            $data['merchant'] = Merchant::whereHas('merchant_product', function ($query) use ($id) {
                $query->where('product_id', '=', $id);
            })->with('address')->get();
			$data['comments'] = DB::table('ocomment')->select('users.id as user_id','ocomment.created_at as created_at', 'buyer.photo_1 as photo_1', 'users.first_name as first_name','users.last_name as last_name','ocomment.comment as comment')
			->where('product_id', $data['pro']->id)->join('users','users.id','=','ocomment.user_id')->leftJoin('buyer','users.id','=','buyer.user_id')->orderBy('created_at','DESC')->get();
			$data['havorder'] = false;
			if(Auth::check()){
				$haveorder = DB::table('product')->where('product_id', $data['pro']->id)->join('orderproduct','product.id','=','orderproduct.product_id')->join('porder','orderproduct.porder_id','=','porder.id')->first();
				if(!is_null($haveorder)){
					$data['havorder'] = true;
					$data['current_user'] = DB::table('users')->select('users.id as user_id', 'buyer.photo_1 as photo_1', 'users.first_name as first_name','users.last_name as last_name')
					->where('users.id',Auth::user()->id)->leftJoin('buyer','users.id','=','buyer.user_id')->first();
					//dd($data['current_user']);
					$data['havorder'] = true;
				}
			}
			$data['likes'] = DB::table('usersproduct')->where('product_id',$data['pro']->id)->count();
			if(Auth::check()){
				$data['liked'] = DB::table('usersproduct')->where('product_id',$data['pro']->id)->where('user_id',Auth::user()->id)->count();
			} else {
				$data['liked'] = 0;
			}
			
			//dd($data['comments']);
        }

		$real_oshop_id = DB::table('oshopproduct')->where('product_id', $data['pro']->id)->pluck('oshop_id');
		$issingle = DB::table('oshopproduct')->join('oshop','oshopproduct.oshop_id','=','oshop.id')->where('product_id', $data['pro']->id)->pluck('single');
		$oshop_url = DB::table('oshopproduct')->join('oshop','oshopproduct.oshop_id','=','oshop.id')->where('product_id', $data['pro']->id)->pluck('url');
		$oshopname = DB::table('oshopproduct')->join('oshop','oshopproduct.oshop_id','=','oshop.id')->where('product_id', $data['pro']->id)->pluck('oshop_name');
		$oshop_id = DB::table('merchantproduct')->where('product_id', $data['pro']->id)->first()->merchant_id;

        $enableSpecialAndWholesalePrice = 0;
        $user_id  = Auth::id();
        $showAutolink =  0;
        $autolink_status = 0;
        $autolink_requested=0;
		$canautolink=true;
		$viewForDealers = false;
		if(!is_null($user_id)){
			$getInitiatorOrResponder =  Autolink::where('initiator', $user_id)->where('responder', $oshop_id)->where('status', 'linked')->first();
			$professional= DB::table('station')->where('user_id',$user_id)->join('logistic', 'station.id', '=', 'logistic.station_id')->pluck('professional');

			if($professional == 1){
				$canautolink=false;
			}

			if(isset($getInitiatorOrResponder)){
				$viewForDealers = 1;
                $autolink_status = 1;
			}else{
                $autolinkr=DB::table('autolink')->where('status','requested')->where(['initiator'=>$user_id,'responder'=>$oshop_id])->get();
                if (count($autolinkr)>0) {
                     $autolink_requested=1;
                }
			}
		}

        if ($viewForDealers){
            $products = $this->getProductsForDealers($id);
        }else {
            $products = $this->getProductsForRegularUsers($id);
        }

        $coverage = $this->getCoverageAddress($id);
        $specsb2b = $this->getSpecifications($id);
		$global_system_vars = GlobalT::orderBy('id', 'desc')->first();
		$discount_dis = DB::table('discount')->select('discount.*')->join('discountbuyer','discount.id','=','discountbuyer.discount_id')->where('discount.product_id', $id)->where('discountbuyer.buyer_id', $user_id)->where('discountbuyer.status', 'active')->where('discount.status', 'active')->orderBy('discount.created_at','DESC')->first();
		$discount_detail = null;
        if (is_null($discount_dis)) {       
        } else {
			$exp_date = date("d-M-Y H:s:i",
				strtotime($discount_dis->created_at . "+ " .
				$discount_dis->duration_days . ' days'));

			if((time()-(60*60*24)) < strtotime($exp_date)){
				$product_price_dis = $data['pro']->retail_price / 100;
				$discount_detail['discount_detail'] = $discount_dis;
				$discount_detail['discount_percentage_dis'] =
					number_format($discount_dis->discount_percentage,2);
				$discount_detail['discounted_price_dis'] =
					number_format($product_price_dis-((
						$discount_detail['discount_percentage_dis'] / 100) *
							$product_price_dis), 2);

		//      checking if item already in cart
				$cart_items_ids=[];
				$discount_detail['item_in_cart']=false;
				foreach (Cart::contents() as $i){
					if ($i->id==$id && $i->page=="productconsumerdisc") {
						$discount_detail['item_in_cart']=true;
					}
				}	
			}			
		}
		//dd($specs);
        $productb2b = DB::table('product')->where('product.parent_id', $data['pro']->id)->where('product.segment', 'b2b')->leftJoin('productdetail','product.productdetail_id','=','productdetail.id')->select('product.*','productdetail.data as product_details')->first();
		$data['specificationsb2b'] = null;
		$del_b2b_option = "";
		$delivery_pricecb2b = 0;
		
		if(!is_null($productb2b)){
			$isblacklisted = DB::table('productblacklist')->where('user_id',$user_id)->where('product_id',$productb2b->parent_id)->first();
			if(!is_null($isblacklisted)){
				$productb2b = null;
			} else {	
				if($productb2b->available == 0){
					$productb2b = null;
				} else {
					$data['specificationsb2b'] = Product::leftJoin('productspec as ps', 'product.id', '=', 'ps.product_id')
						->join('specification as s', 's.id', '=', 'ps.spec_id')
						->where('product.id', $productb2b->id)
						->get();		
					$del_b2b_option = $productb2b->del_option;
					if($del_b2b_option == 'own'){
							$delivery_pricecb2b = $productb2b->b2b_del_west_malaysia;
					} else {
						if($del_b2b_option == 'system'){
							$del_calculation = new Delivery;
							$delivery_pricecb2b = $del_calculation->calculate_price($productb2b->weight,$productb2b->length,$productb2b->width,$productb2b->height,$productb2b->del_option);
						//	dd($delivery_pricecb2b);
						} else {
							$delivery_pricecb2b = 0;
						}
					}
				}
			}
		}
		
        $immerchant = 0;
        $isadmin = 0;
		$badge_num = "";
        if (Auth::check()){
           $user_id = Auth::user()->id;
           $checkmerchant= Merchant::where('user_id',$user_id)->first();
           if(!is_null($checkmerchant)){
                if($oshop_id == $checkmerchant->id){
                    $immerchant = $checkmerchant->id;
					$autolink_status=1;
					$autolinkrr=DB::table('autolink')->where('status','requested')->where(['responder'=>$id])->get();
					$badge_num = count($autolinkrr);
                }
           }
        } 
		$isadmin = 0;
		$product_id= $data['pro']['id'];
		if (Auth::check()){
			$product_id= $data['pro']['id'];
			$role= DB::table('role_users')->where('user_id',Auth::user()->id)->join('roles', 'roles.id', '=', 'role_users.role_id')->get();
			
			foreach ($role as $userrole) {
				if($userrole->name == "adminstrator"){
					$isadmin = 1;
				}
			}	
		}

		$del_option = $data['pro']['del_option'];
		if($del_option == 'own'){
				$delivery_pricec = $data['pro']['del_west_malaysia'];
		} else {
			if($del_option == 'system'){
				$del_calculation = new Delivery;
				$delivery_pricec = $del_calculation->calculate_price($data['pro']['weight'],$data['pro']['length'],$data['pro']['width'],$data['pro']['height'],$data['pro']['del_option']);
			} else {
				$delivery_pricec = 0;
			}
			
		}
		
		$hyper = Product::join('owarehouse as o',
			'product.id','=','o.product_id')
			->leftJoin('owarehousepledge as op', function($join) {
				 $join->on('o.id', '=', 'op.owarehouse_id')
					 ->where('op.status','=','executed');
			})
			->where('o.status','=','active')
			->where('product.owarehouse_price','>',0)
			->where('product.parent_id','=',$data['pro']->id)
			->select(DB::raw('product.*,o.id as owarehouse_id,
                o.moq as moq,
				o.collection_price,o.collection_units,
				product.parent_id as product_id,
				o.created_at as odate,
				GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
			->groupBy('product.id')
			->first();
		
			$dDiff = null;
			if(!is_null($hyper)){
				$date = $hyper->odate;
				$date = strtotime($date);
				$current_date = strtotime(date('Y-m-d H:i:s'));			
				$date1 = new DateTime('now');
				$date2 = new DateTime(date('Y-m-d H:i:s', strtotime("+ $global_system_vars->hyper_duration day", $date)));
				$dDiff = $date1->diff($date2);
				if ($dDiff->format("%r") == '-') {
					$hyper = null;
				}
			}
		// dd($button_status);
        return view('productconsumer')->with('product', $data)
			->with('hyper', $hyper)
			->with('dDiff', $dDiff)
			->with('immerchant', $immerchant)
			->with('delivery_pricec', $delivery_pricec)
			->with('delivery_pricecb2b', $delivery_pricecb2b)
			->with('badge_num', $badge_num)
			->with('isadmin', $isadmin)
			->with('del_option', $del_option)
			->with('del_b2b_option', $del_b2b_option)
			->with('issingle', $issingle)
			->with('canautolink', $canautolink)
			->with('oshop_url', $oshop_url)
            ->with('pid',$product_id)
			->with('product_spec', $product_spec)
			->with('summary', $summary)
			->with('discount_dis', $discount_dis)
			->with('discount_detail', $discount_detail)
			->with('button_status',$button_status)
			->with('global_system_vars',$global_system_vars)
			->with('merchant_id', $oshop_id)
			->with('real_oshop_id', $real_oshop_id)
			->with('autolink_status', $autolink_status)
			->with('autolink_requested', $autolink_requested)
			->with('oshop_id', $real_oshop_id)
			->with('oshopname', $oshopname)
			->withProducts($products[0])
			->withProductb2b($productb2b)
			->withCoverage($coverage[0])
			->withSpecsb2b($specsb2b);
    }

	public function productconsumerdiscount(Request $request, $id, $discount_id) {

        if ($id)
            $data['pro'] = Product::with(["brand", 'category', 'Country', 'State', 'City', 'Area', 'wholesale', 'productdealer'])->findOrFail($id);
        else
            $data['pro'] = Product::with(["brand", 'category', 'Country', 'State', 'City', 'Area', 'wholesale', 'productdealer'])->first();

        $data['specifications'] = Product::leftJoin('productspec as ps', 'product.id', '=', 'ps.product_id')
                        ->leftJoin('specification as s', 's.id', '=', 'ps.spec_id')
                        ->where('product.id', $id)
                        ->select('*')->get();
        if (!empty($openwish_id)) {

            $product = Product::with('merchant')->find($id);
            $pledge_amt = OpenWishPledge::select(DB::raw('SUM(pledged_amt) as pledged_amt'))->where('openwish_id', $openwish_id)->first()->pledged_amt;
            $profile = Merchant::withProfile($product->merchant->first()->id);
            return view('openwish_pledge')
                            ->with('openwish_id', $openwish_id)
                            ->with('product_id', $id)
                            ->with('profile', $profile)
                            ->with('pledged_amt', $pledge_amt)
                            ->with('product', $product);
        }

        //We need to get Product from openwish;
//        $productOpenWish = OpenWish::where('product_id', $id)->first();
//
        $summary = null;
//		if ($productOpenWish) {
//			$fb = new Facebook(Config::get('facebook.credentials'));
//
//			//We need to get insights for this product share, link
//			$linkId = $productOpenWish->link_id;
//			$request = $fb->get('/'.$linkId.'/likes?summary=true',
//							Auth::user()->access_token);
//			//Get Meta data from facebook. in this case we are asking for likes
//			//If we need comment we substitute 'likes' with 'comments'
//			$response= $request->getGraphEdge();
//			$metaData = $response->getMetaData();
//			$summary = $metaData['summary'];
//		}

        if ($data) {
            $level = $data['pro']->subcat_level;
            if ($level == 1) {
                $data['sub_product'] = SubCatLevel1::find($data['pro']->subcat_id);
                $data['specification'] = Product::leftJoin('subcat_level_1 as s1', 'product.subcat_id', '=', 's1.id')
                                ->leftJoin('subcat_level_1spec as ss1', 's1.id', '=', 'ss1.subcat_level_1_id')
                                ->leftJoin('specification as s', 's.id', '=', 'ss1.spec_id')
                                ->leftJoin('productspec as ps', 'product.id', '=', 'ps.product_id')
                                ->where('product.id', $id)
                                ->select(DB::raw('distinct(s.id),s.description,ps.value'))->get();
            } else if ($level == 2) {
                $data['sub_product'] = SubCatLevel2::find($data['pro']->subcat_id);
                $data['specification'] = Product::leftJoin('subcat_level_2 as s1', 'product.subcat_id', '=', 's1.id')
                                ->leftJoin('subcat_level_2spec as ss1', 's1.id', '=', 'ss1.subcat_level_2_id')
                                ->leftJoin('specification as s', 's.id', '=', 'ss1.spec_id')
                                ->leftJoin('productspec as ps', 'product.id', '=', 'ps.product_id')
                                ->where('product.id', $id)
                                ->select(DB::raw('distinct(s.id),s.description,ps.value'))->get();
            } else if ($level == 3) {
                $data['sub_product'] = SubCatLevel3::find($data['pro']->subcat_id);
                $data['specification'] = Product::leftJoin('subcat_level_3 as s1', 'product.subcat_id', '=', 's1.id')
                                ->leftJoin('subcat_level_3spec as ss1', 's1.id', '=', 'ss1.subcat_level_3_id')
                                ->leftJoin('specification as s', 's.id', '=', 'ss1.spec_id')
                                ->leftJoin('productspec as ps', 'product.id', '=', 'ps.product_id')
                                ->where('product.id', $id)
                                ->select(DB::raw('distinct(s.id),s.description,ps.value'))->get();
            }
            $data['merchant'] = Merchant::whereHas('merchant_product', function ($query) use ($id) {
                        $query->where('product_id', '=', $id);
                    })->with('address')->get();
        }

        $merchant_id = 0;
        if (isset($data['merchant'])) {
            $merchant_id = $data['merchant'][0]->id;
        }

        $enableSpecialAndWholesalePrice = 0;
        $user_id = Auth::id();
        $showAutolink = 0;
        $viewForDealers = false;
        if (!is_null($user_id)) {
			$merchant_id = 0;
			$getMerchant =  Merchant::where('user_id', $user_id)->first();
			if(!is_null($getMerchant)){
				$merchant_id = $getMerchant->id;
			}

			$getInitiatorOrResponder =  Autolink::where('initiator', $user_id)->orWhere('responder', $merchant_id)->first();

            if (isset($getInitiatorOrResponder) or isset($getMerchant)) {
                $viewForDealers = 1;
            } else {
                $viewForDealers = 0;
            }
        }

        if ($viewForDealers) {
            $products = $this->getProductsForDealers($id);
        } else {
            $products = $this->getProductsForRegularUsers($id);
        }
        //sending discount details for this product
        $discount_dis = DB::table('discount')->where('product_id', $id)->where('id', $discount_id)->first();
        if (empty($discount_dis)) {
            return redirect()->back();
        }
        $product_price_dis = $data['pro']->retail_price / 100;
        $discount_detail['discount_detail'] = $discount_dis;
        $discount_detail['discount_percentage_dis'] = number_format($discount_dis->discount_percentage,2);
        $discount_detail['discounted_price_dis'] = number_format($product_price_dis-(($discount_detail['discount_percentage_dis'] / 100) * $product_price_dis), 2);
//      checking if item already in cart
        $cart_items_ids=[];
        $discount_detail['item_in_cart']=false;
        foreach (Cart::contents() as $i){
            if ($i->id==$id && $i->page=="productconsumerdisc") {
                $discount_detail['item_in_cart']=true;
            }
        }

//        end discount details

        $coverage = $this->getCoverageAddress($id);
        $specsb2b = $this->getSpecifications($id);
        //dd($specs);

        return view('productconsumerdisc')->with('product', $data)
                        ->with('summary', $summary)
                        ->withDiscountDetail($discount_detail)
                        ->with('merchant_id', $merchant_id)
                        ->withProducts($products[0])
                        ->withCoverage($coverage[0])
                        ->withSpecsb2b($specsb2b);
    }
    
	public function approval($id)
     {
         if(!is_null(Currency::where('active',true)->first())){
             $currency = Currency::where('active',true)->first()->code;
         }
 		$product=Product::with('category')->with('brand')->with('subCategory')->with('productdealer')->with('dealers')->where('id',$id)->orderBy('created_at','desc')->get();
		$likes = DB::table('usersproduct')->where('product_id',$id)->count();
		$brands = DB::table('brand')->get();
		$categories = DB::table('category')->get();
		$subcategories =DB::select(DB::raw('SELECT
		id, subcat_level, description FROM (
			SELECT subcat_level_1.id, "1" as subcat_level, subcat_level_1.description FROM subcat_level_1
			UNION
			SELECT subcat_level_2.id, "2" as subcat_level, subcat_level_2.description FROM subcat_level_2
			UNION
			SELECT subcat_level_3.id, "3" as subcat_level, subcat_level_3.description FROM subcat_level_3
		) as TT
		'));
        $oshop_id= DB::table('oshopproduct')->whereNull('deleted_at')->where('product_id',$id)->pluck('oshop_id');
		return view('admin/adminMasterProductApproval',['product'=>$product, 'currency'=>$currency, 'likes' => $likes, 'brands' => $brands, 'categories' => $categories, 'subcategories' => $subcategories,'product_id'=>$id ,'oshop_id'=>$oshop_id]);		 
	 }
	 
	public function price($id)
     {
         if(!is_null(Currency::where('active',true)->first())){
             $currency = Currency::where('active',true)->first()->code;
         }
 		$product=Product::with('category')->with('brand')->with('subCategory')->with('productdealer')->with('dealers')->where('id',$id)->orderBy('created_at','desc')->get();
		
		$brands = DB::table('brand')->get();
		$categories = DB::table('category')->get();
		$subcategories =DB::select(DB::raw('SELECT
		id, subcat_level, description FROM (
			SELECT subcat_level_1.id, "1" as subcat_level, subcat_level_1.description FROM subcat_level_1
			UNION
			SELECT subcat_level_2.id, "2" as subcat_level, subcat_level_2.description FROM subcat_level_2
			UNION
			SELECT subcat_level_3.id, "3" as subcat_level, subcat_level_3.description FROM subcat_level_3
		) as TT
		'));
 
		return view('admin/adminMasterProductPrice',['product'=>$product, 'currency'=>$currency, 'brands' => $brands, 'categories' => $categories, 'subcategories' => $subcategories,'product_id'=>$id  ]);		 
	 }	 
	
	public function listProducttermid($id){
		$product=DB::table('tproduct')->leftJoin('product','tproduct.product_id','=','product.id')->leftJoin('product as parent','product.parent_id','=','parent.id')
		->where('tproduct.id',$id)		
		->select('tproduct.*','tproduct.id as tid','parent.photo_1 as real_photo_1','parent.id as parentid')->
		get();
		return view('admin/adminMasterProductTermDetail')->
			with('product',$product);
			
	}
	public function listProductterm()
	{
		$product=DB::table('tproduct')->leftJoin('product','tproduct.product_id','=','product.id')->leftJoin('product as parent','product.parent_id','=','parent.id')	
		->select('tproduct.*','tproduct.id as tid','parent.photo_1 as real_photo_1','parent.id as parentid')->
		get();
		return view('admin/adminMasterProductTerm')->
			with('product',$product);
	}
	public function get_products($merchant_id = null,$start=0)
    {
        $end=$start+30;

        $ret=array();
        if (!Auth::check() or !Auth::user()->hasRole('adm')) {
            return $ret;
        }
        try {
            $ret=Product::leftJoin('oshopproduct','oshopproduct.product_id',
            '=','product.parent_id')
            ->join('merchantproduct','merchantproduct.product_id','=','product.parent_id')
            ->leftJoin('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->leftJoin('nproductid','nproductid.product_id','=','product.id')
            ->join('category','category.id','=','product.category_id')
            ->leftJoin('subcat_level_1','subcat_level_1.id','=','product.subcat_id')
            ->leftJoin('subcat_level_2','subcat_level_2.id','=','product.subcat_id')
            ->leftJoin('subcat_level_3','subcat_level_3.id','=','product.subcat_id')
            ->join('brand','brand.id','=','product.brand_id')
        //     ->join(DB::raw("
        //       SELECT
        // id, subcat_level, description FROM (
        //     SELECT subcat_level_1.id, "1" as subcat_level,
        //         subcat_level_1.description FROM subcat_level_1
        //     UNION
        //     SELECT subcat_level_2.id, "2" as subcat_level,
        //         subcat_level_2.description FROM subcat_level_2
        //     UNION
        //     SELECT subcat_level_3.id, "3" as subcat_level,
        //         subcat_level_3.description FROM subcat_level_3
        // ) as TT'

        //         "))
            ->leftJoin('oshop','oshop.id','=','oshopproduct.oshop_id')
			->leftJoin('productbc','product.parent_id','=','productbc.product_id')
			->leftJoin('bc_management','bc_management.id','=','productbc.bc_management_id')
			->where('product.segment','b2c')

            ->where('product.id','>',$start)
        
        
            ->whereNull('product.deleted_at')->
            orderBy(DB::raw("
              CASE product.status
                WHEN 'pending' THEN 1
                WHEN 'suspended' THEN 2
                WHEN 'active' THEN 3
                ELSE 4
              END"))
			  ->orderBy('product.created_at','DESC')
			  ->select(DB::raw("
                  product.id as no,
                  IFNULL(nproductid.nproduct_id,LPAD(product.id,16,'E')) as product_id,
                  category.description,
                  product.parent_id as pid,
				  bc_management.id as bc_management_id,
                  oshop.oshop_name as o_shop,
                  merchantproduct.merchant_id,
                  merchant.osmall_commission,
                  merchant.commission_type,
                  product.id ,
				  product.subcat_id,
				  product.subcat_level,
				  product.photo_1,
				  subcat_level_1.description as slevel1,
				  subcat_level_2.description as slevel2,
				  subcat_level_3.description as slevel3,
                  brand.name as brand,
                  oshop.status as oshop_status,
				product.retail_price ,
                product.osmall_commission as pocommission ,
				product.status ,
                product.cashback,
                product.pcashback,
                product.created_at			  
			  "));
			  if(!is_null($merchant_id)){
				  $ret=$ret->where('merchantproduct.merchant_id',$merchant_id);
				 
			  }
              //  Raw Query Equivalent
              // $ret=DB::raw("
              //       SELECT
              //       product.id,
              //       nproductid.nproduct_id as product_id,
              //       category.description,
              //       oshop.oshop_name as oshop,
              //       merchantproduct.merchant_id,
              //       brand.name as brand,
              //       oshop.status as oshop_status,
              //       product.retail_price,
              //       product.status,
              //       product.created_at,
              //       CASE product.status
              //       WHEN 'pending' THEN 1
              //       WHEN 'suspended' THEN 2
              //       WHEN 'active' THEN 3
              //       ELSE 4
              //       END as imp
              //       FROM
              //       product
              //       LEFT JOIN oshopproduct on oshopproduct.product_id=product.id
              //       JOIN merchantproduct on merchantproduct.product_id=product.parent_id
              //       JOIN nproductid on nproductid.product_id=product.id
              //       JOIN category on category.id=product.category_id
              //       JOIN brand on brand.id=product.brand_id
              //       JOIN oshop on oshop.id=oshopproduct.oshop_id


              //       WHERE
              //       product.segment='b2c'
              //       AND product.deleted_at IS NULL 
              //       ORDER BY
              //       imp
              //   ");
              
        } catch (\Exception $e) {
            // dd($e);
        }
        return Datatables::eloquent($ret)->make(true);
        return response()->json($ret);
    }
	public function listProducts($merchant_id = null)
	{
	//	echo "Memory Usage: ".memory_get_usage()."<br>";
	//	echo "Memory Peak Usage: ".memory_get_peak_usage()."<br>";

		if(!is_null(Currency::where('active',true)->first())){
			$currency = Currency::where('active',true)->first()->code;
		}

		
   	    // $product=$this->get_products();
        
		// $brands = DB::table('brand')->get();
		// $categories = DB::table('category')->get();
		// $subcategories =DB::select(DB::raw('SELECT
		// id, subcat_level, description FROM (
		// 	SELECT subcat_level_1.id, "1" as subcat_level,
		// 		subcat_level_1.description FROM subcat_level_1
		// 	UNION
		// 	SELECT subcat_level_2.id, "2" as subcat_level,
		// 		subcat_level_2.description FROM subcat_level_2
		// 	UNION
		// 	SELECT subcat_level_3.id, "3" as subcat_level,
		// 		subcat_level_3.description FROM subcat_level_3
		// ) as TT'
		// ));
		if(is_null($merchant_id)){
			$total_active = DB::select(DB::raw("select count(*) as counting from merchantproduct mp, product p, merchant m 
			where mp.merchant_id=m.id and mp.product_id=p.id and p.status='active' and p.segment = 'b2c'
			and m.status='active' and lcase(p.name) not like '%test%' and lcase(m.company_name) not like '%test%' 
			and lcase(m.company_name) not like '%internal%';"));
		} else {
			$total_active = DB::select(DB::raw("select count(*) as counting from merchantproduct mp, product p, merchant m 
			where mp.merchant_id=m.id and m.id = " . $merchant_id . " and mp.product_id=p.id and p.status='active' and p.segment = 'b2c'
			and m.status='active' and lcase(p.name) not like '%test%' and lcase(m.company_name) not like '%test%' 
			and lcase(m.company_name) not like '%internal%';"));			
		}
		
		//dd($total_active);
        return view('admin/product_master')
            ->with('total_active',$total_active[0])
            ->with('currency',$currency)
            ->with('merchant_id',$merchant_id)

        ;
		return view('admin/adminMasterProduct')->
			with('product',$product)->
			with('currency',$currency)->
			with('brands',$brands)->
			with('categories', $categories)->
			with('subcategories', $subcategories);
	}

	public function getWholesale($id)
    {
        $products = Product::where('id',$id)->with('category')->with('brand')->with('subCategory')->with('productdealer')->with('dealers')->with('wholesale')->get();
		return json_encode($products);
    }
	
		public function getWholesalet($id)
    {
        $products = DB::table('tproduct')->where('tproduct.id',$id)->join('twholesale','twholesale.tproduct_id','=','tproduct.id')->get();
		return json_encode($products);
    }

	public function getSpecialsale($id)
    {
        $products = DB::select(DB::raw('SELECT pd.special_unit as unit, pd.special_funit as funit, pd.special_price as special_price, CONCAT(u.first_name,\' \', u.last_name) as username , p.name as name FROM productdealer pd, users u, product p WHERE pd.dealer_id = u.id and pd.product_id='.$id.' and pd.product_id = p.id'));

		return json_encode($products);
    }
	
		public function getSpecialsalet($id)
    {
        $products = DB::select(DB::raw('SELECT pd.special_unit as unit, pd.special_funit as funit, pd.special_price as special_price, CONCAT(u.first_name,\' \', u.last_name) as username , p.name as name FROM tproductdealer pd, users u, tproduct p WHERE pd.dealer_id = u.id and pd.tproduct_id='.$id.' and pd.tproduct_id = p.id'));

		return json_encode($products);
    }

	public function getLikes($id)
    {
        $likes = DB::select(DB::raw("
            SELECT 
            product.name as name,
            DATE_FORMAT(usersproduct.created_at,'%d%b%y %H:%i') as since, usersproduct.user_id as user_id, 
            nbuyerid.nbuyer_id
            -- ,nsellerid.nseller_id 
            FROM product, usersproduct 
            JOIN nbuyerid ON nbuyerid.user_id = usersproduct.user_id
		-- LEFT JOIN nsellerid ON nsellerid.user_id = usersproduct.user_id
		WHERE product.id = usersproduct.product_id AND product.id=".$id." ORDER BY usersproduct.created_at DESC"));

		return json_encode($likes);
    }

    public function approveProduct() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
            return \App\Classes\AdminApproveHelper::approveUser($inputs);
        }
    }
	
	public function approveProductSection() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) && !empty($inputs['section']) ){
         return \App\Classes\AdminApproveHelper::approveSection($inputs);

      }
    }
	
	public function approveProductSectionB2b() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) && !empty($inputs['section']) ){
         return \App\Classes\AdminApproveHelper::approveSectionB2b($inputs);

      }
    }

    //function for saving remarks of station
    public function saveProductRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        $res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
            $res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
            echo $res;
        }
        //echo "Hola";
    }
	
    public function saveProductSecRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        $res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) && !empty($inputs['section']) ){
            $res = \App\Classes\AdminApproveHelper::saveSecRemarks($inputs);
            echo $res;
        }
        //echo "Hola";
    }	

    public function product_approval($id){
		$sections = [];
		$aprsections = DB::table('aprsection')->where('type','product')->get();
		$count = 0;
		foreach($aprsections as $aprsection){
			$getstatus = DB::table('aprchecklist')->where('product_id',$id)
								->where('aprsection_id',$aprsection->id)->first();
			$statusc = "pending";
			$remark = "";
			if(!is_null($getstatus)){
				$statusc = $getstatus->status;
				$remarks = DB::table('aprchecklistremark')->join('remark','aprchecklistremark.remark_id','=','remark.id')
									->where('aprchecklist_id',$getstatus->id)
									->orderBy('aprchecklistremark.created_at','DESC')->select('remark.*')->first();
				if(!is_null($getstatus)){
					$remark = $remarks->remark;
				}
									
			} 
			
			$sections[$count]['description'] = $aprsection->description;
			$sections[$count]['name'] = $aprsection->name;
			$sections[$count]['comment'] = $remark;
			$sections[$count]['status'] = $statusc;
			$count++;			
		}

		return json_encode($sections);
	}
    public function product_remarks($id){
        $remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status from remark inner join productremark on productremark.remark_id = remark.id where productremark.product_id = " . $id . " order by remark.created_at desc"));
        return json_encode($remarks);
    }
	
	public function product_remarks_approval($id){
		$sections = [];
		$aprsections = DB::table('aprsection')->where('type','product')->get();
		$count = 0;
		foreach($aprsections as $aprsection){
			$getstatus = DB::table('aprchecklist')->where('product_id',$id)
								->where('aprsection_id',$aprsection->id)->first();
			$statusc = "pending";
			$remark = "";
			$aprid = 0;
			if(!is_null($getstatus)){
				$statusc = $getstatus->status;
				$remarks = DB::table('aprchecklistremark')->join('remark','aprchecklistremark.remark_id','=','remark.id')
									->where('aprchecklist_id',$getstatus->id)
									->orderBy('aprchecklistremark.created_at','DESC')->select('remark.*')->first();
				if(!is_null($remarks)){
					$remark = $remarks->remark;
				}
				$aprid = $getstatus->id;
									
			} 
			
			$sections[$count]['description'] = $aprsection->description;
			$sections[$count]['comment'] = $remark;
			$sections[$count]['name'] = $aprsection->name;
			$sections[$count]['status'] = $statusc;
			$sections[$count]['aprid'] = $aprid;
			$count++;			
		}
		$product = DB::table('product')->where('id',$id)->first();
		$remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status from remark inner join productremark on productremark.remark_id = remark.id where productremark.product_id = " . $id . " order by remark.created_at desc"));
		
		return view('admin/adminMasterProductRemarks',['product'=>$product,'product_id'=>$id ,'sections'=>$sections, 'remarks'=>$remarks]);
		
	}

    public function update_product_selected(Request $anArray)
    {
        # code...
        // Get Key Based Array
        $merchant_id = $anArray->merchant_id;
		//dd( $merchant_id);
        if (!$anArray->has('data')) {
           foreach ($anArray->datasmm as $key => $value) {
                $valueaux = false;
				if($value=="true"){
					$valueaux = true;
				}
                $up = DB::table('product')->where('id',$key)->update(['smm_selected' => $valueaux]);
            }
			 return array();
        }
        try {
            $temp=array();
            foreach ($anArray->data as $key => $value) {
				//dd($value);
				$oshopproduct = DB::table('merchantproduct')->where('product_id',$key)->where('merchant_id',$merchant_id)->first();
				$cb = DB::table('product')->where('id',$key)->update(['cashback' => $value[5]]);
				if($value[0] == 0){
					DB::table('oshopproduct')->where('product_id',$key)->delete();
					$valueaux = false;
				} else {
					$isoshop = DB::table('oshopproduct')->where('product_id',$key)->first();
					if(!is_null($isoshop)){
						DB::table('oshopproduct')->where('product_id',$key)->update(['oshop_id'=>$value[0],'updated_at'=>date('Y-m-d H:i:s')]);
					} else {
						DB::table('oshopproduct')->insert(['oshop_id'=>$value[0], 'product_id'=>$key,'updated_at'=>date('Y-m-d H:i:s'),'created_at'=>date('Y-m-d H:i:s')]);
					}
					
					$valueaux = true;					
				}
                /*  $valueaux = false;
				if($value=="true"){
                if(is_null($oshopproduct)){
                        DB::table('merchantproduct')->insert(['merchant_id' => $merchant_id, 'product_id' => $key, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                    }else{
                        DB::table('merchantproduct')->where('id',$oshopproduct->id)->update(['deleted_at' => null]);
                    }
					$valueaux = true;
				}/*else{
                    if(!is_null($oshopproduct)){
                        DB::table('merchantproduct')->where('id',$oshopproduct->id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
                    }
                }*/
                
                $up = DB::table('product')->where('parent_id',$key)->update(['oshop_selected' => $valueaux]);
                $up = DB::table('product')->where('id',$key)->update(['retail_price' => $value[1] * 100, 'discounted_price' => $value[2] * 100, 'available' => $value[3]]);
				$b2b = DB::table('product')->where('parent_id',$key)->where('segment','b2b')->first();
				if(!is_null($b2b)){
					$up = DB::table('product')->where('id',$b2b->id)->update(['retail_price' => $value[1] * 100, 'available' => $value[4]]);
				}				
                array_push($temp, $valueaux);
            }
			if(!is_null($anArray->datasmm) && !empty($anArray->datasmm)){
				foreach ($anArray->datasmm as $key => $value) {
					$valueaux = false;
					if($value=="true"){
						$valueaux = true;
					}
					$up = DB::table('product')->where('id',$key)->update(['smm_selected' => $valueaux]);
				}
			}
            return $temp;
        } catch (\Exception $e) {
            return $e;
            return "failed";
        }
    }

    public function getHyper($id)
    {
        $hyper = DB::table('product')->where('parent_id', $id)->where('segment','hyper')->first();
        if (!is_null($hyper)) {
            $hyper->owarehouse_price = number_format(($hyper->owarehouse_price/100),2);
			$bought = DB::table('owarehouse')->join('owarehousepledge','owarehouse.id','=','owarehousepledge.owarehouse_id')->where('product_id',$hyper->id)->count();
			$hyper->bought = $bought;		
			$hyper->left = $hyper->owarehouse_moq - $bought;		
        }
		
        return json_encode($hyper);
    }

    public function getSpec($id)
    {
         $spec = Specification::where('productspec.product_id', $id)->join('productspec','productspec.spec_id','=','specification.id')->orderBy('specification.id', 'asc')->get();
        return json_encode($spec);
    }
	
    public function add_comment(Request $request)
    {
        $user_id = $request->get('user_id');
        $comment = $request->get('comment');
        $product_id = $request->get('product_id');
        $result = DB::table('ocomment')->insertGetId(['product_id' => $product_id, 'comment' => $comment,'user_id' => $user_id,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        return "OK";
    }	
	
    public function product_delete(Request $request)
    {
        $pid = $request->get('pid');
		$pledges = DB::table('owarehousepledge')->
			join('owarehouse','owarehousepledge.owarehouse_id','=','owarehouse.id')->
			join('product','product.id','=','owarehouse.product_id')->
			where('parent_id', $pid)->get();

		if(count($pledges) > 0){
			return $pledges;

		} else {
			$result = DB::table('product')->where('parent_id', $pid)->
				update([
					'oshop_selected' => false,
					'deleted_at' => date('Y-m-d H:i:s')]);
			DB::table('oshopproduct')->where('product_id', $pid)->delete();
			DB::table('merchantproduct')->where('product_id', $pid)->delete();
			return "1";						
		}

    }		
	public function product_oshop(Request $request){
		$id = $request->get('id');
		DB::table('oshopproduct')->where('product_id',$id)->update(['oshop_id'=>$request->get('oshop_id'),'updated_at'=>date('Y-m-d H:i:s')]);	
		return json_encode("OK");
	}
	
	public function product_retailprice(Request $request){
        $currency= DB::table('currency')->where('active', 1)->first()->code;
		$id = $request->get('id');
		DB::table('product')->where('id',$id)->update(['private_retail_price'=>$request->get('retail')*100,'updated_at'=>date('Y-m-d H:i:s')]);
		return Response::json(array('result' => $currency . number_format($request->get('retail'),2)));
	}	
	public function product_discountedprice(Request $request){
		$currency= DB::table('currency')->where('active', 1)->first()->code;
        $id = $request->get('id');
		DB::table('product')->where('id',$id)->update(['private_discounted_price'=>$request->get('discounted')*100,'updated_at'=>date('Y-m-d H:i:s')]);
		return Response::json(array('result' => $currency . number_format($request->get('discounted'),2)));
	}
	
	public function product_warehouse_qty(Request $request){

		$id = $request->get('id');
		DB::table('product')->where('id',$id)->update(['warehouse_available'=>$request->get('qty'),'updated_at'=>date('Y-m-d H:i:s')]);
		return Response::json(array('result' => $request->get('qty')));
	}
	public function tproduct_warehouse_qty(Request $request){
		$id = $request->get('id');
		DB::table('tproduct')->where('id',$id)->update(['available'=>$request->get('qty'),'updated_at'=>date('Y-m-d H:i:s')]);
		return Response::json(array('result' => $request->get('qty')));
	}
	public function product_qty(Request $request){
		$id = $request->get('id');
		DB::table('product')->where('id',$id)->update(['private_available'=>$request->get('qty'),'updated_at'=>date('Y-m-d H:i:s')]);
		return Response::json(array('result' => $request->get('qty')));
	}
	public function tproduct_qty(Request $request){
		$id = $request->get('id');
		DB::table('tproduct')->where('id',$id)->update(['available'=>$request->get('qty'),'updated_at'=>date('Y-m-d H:i:s')]);
		return Response::json(array('result' => $request->get('qty')));
	}
	public function addtp(Request $request){
		$merchant_id= $request->get('merchant_id');
		$merchant_user_id= DB::table('merchant')->
			where('id',$request->get('merchant_id'))->
			pluck('user_id');
		$merchantuniqueq = DB::table('nsellerid')->where('user_id',$merchant_user_id)->first();
		$tp_id = DB::table('tproduct')->insertGetId(['name'=>'Product Name', 'available'=>0,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		$mtp = DB::table('merchanttproduct')->insert(['tproduct_id'=>$tp_id,'merchant_id'=>$merchant_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		if(!is_null($merchantuniqueq)){
			$newid = UtilityController::tproductuniqueid($merchant_id,$merchantuniqueq->nseller_id,'term',0, $tp_id);
			if($newid != ""){
				DB::table('ntproductid')->insert(['ntproduct_id'=>$newid, 'tproduct_id'=>$tp_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			}
			
		}	
		return "OK";
	}
	public function deletetp(Request $request){
		DB::table('tproduct')->where('id',$request->get('id'))->update(['status'=>'deleted']);
		return "OK";
	}
	public function tproduct_name(Request $request){
		$id = $request->get('id');
		DB::table('tproduct')->where('id',$id)->update(['name'=>$request->get('name'),'updated_at'=>date('Y-m-d H:i:s')]);
		return Response::json(array('result' => $request->get('name')));
	}	
	
	public function productdetail($id)
    {
		$product = DB::table('product')->where('product.id',$id)->leftJoin('oshopproduct','product.id','=','oshopproduct.product_id')->select('product.*','oshopproduct.oshop_id')->first();
		$category = DB::table('category')->where('id',$product->category_id)->first();
		$subcategory = DB::table('subcat_level_' . $product->subcat_level)->where('id',$product->subcat_id)->first();
		$brand = DB::table('brand')->where('id',$product->brand_id)->first();
		$global_system_vars = GlobalT::orderBy('id', 'desc')->first();
		$merchant = DB::table('merchantproduct')->where('product_id',$id)->first();
		$merchant_id = $merchant->merchant_id;
		return view('productdetail',['product'=>$product, 'category'=>$category, 'subcategory'=>$subcategory, 'brand'=>$brand, 'global_system_vars'=>$global_system_vars, 'merchant_id'=>$merchant_id]);
	}
	
    public function getmerchantnotproducts(Request $request)
    {
		$i = 1; 

		$merchant_id = $request->get('merchant_id');
        $merchant = Merchant::find($merchant_id);
		$merchant_pro = DB::table('product')->
			join('merchantproduct','merchantproduct.product_id','=','product.parent_id')
			->leftJoin('tproduct','product.id','=','tproduct.product_id')
			->where('product.segment','b2b')
		//	->where('product.term','=','0')
			->join('product as parent','parent.id','=','product.parent_id')
			->whereRaw("(tproduct.id IS NULL OR tproduct.status = 'deleted')")
			->where('merchantproduct.merchant_id',$merchant_id)
			->where('parent.status','active')
			->select('product.*', 'tproduct.id as tid','parent.photo_1 as real_photo_1')
			->distinct()
			->get();

		$return_html = '';
		$productarr = array();
		$return = array();
		foreach($merchant_pro as $profile_product){
			if(!is_null($profile_product)){
					//$myoshop = DB::table('oshopproduct')->where('product_id',$profile_product->id)->join('oshop','oshopproduct.oshop_id','=','oshop.id')->first();
					//$profile_product->myoshop = $myoshop;
					$formatted_product_id =IdController::nP($profile_product->id);
					$profile_product->formatted_product_id = $formatted_product_id;
				//	$b2b = DB::table('product')->where('parent_id',$profile_product->id)->where('segment','b2b')->first();
				//	$profile_product->b2b = $b2b;
					array_push($productarr,$profile_product);
					$i++;
			}
		}
		
		return json_encode(['data'=>$productarr]);		
	}	
	
    public function getmerchanttproducts(Request $request)
    {
		$i = 1; 
		$merchant_id = $request->get('merchant_id');
        $merchant = Merchant::find($merchant_id);
		$merchant_pro = DB::table('tproduct')->
			join('merchanttproduct','merchanttproduct.tproduct_id','=','tproduct.id')->
			leftJoin('product','product.id','=','tproduct.product_id')->
			leftJoin('product as parent','product.parent_id','=','parent.id')->
			where('tproduct.status', '=', 'active')->
			where('merchanttproduct.merchant_id',$merchant_id)->
			select('tproduct.*',
				'parent.id as original_id',
				'parent.warehouse_available as original_available',
				'parent.status as parent_status')->
			get();

		$return_html = '';
		$productarr = array();
		$return = array();
		foreach($merchant_pro as $profile_product){
			if(!is_null($profile_product)){
					//$myoshop = DB::table('oshopproduct')->where('product_id',$profile_product->id)->join('oshop','oshopproduct.oshop_id','=','oshop.id')->first();
					//$profile_product->myoshop = $myoshop;
					$formatted_product_id =IdController::nTp($profile_product->id);
					$profile_product->formatted_product_id = $formatted_product_id;
					$formatted_oproduct_id =IdController::nP($profile_product->original_id);
					$profile_product->formatted_oproduct_id = $formatted_oproduct_id;
				//	$b2b = DB::table('product')->where('parent_id',$profile_product->id)->where('segment','b2b')->first();
				//	$profile_product->b2b = $b2b;
					$profile_product->is_from_album = 1;
					if(is_null($profile_product->original_id)){
						$profile_product->is_from_album = 0;
					}
					array_push($productarr,$profile_product);
					$i++;
			}
		}
		//dd($oshops);
		return json_encode(['data'=>$productarr]);		
	}
	

	public function getmerchantproducts(Request $request)
    {
        define('MAX_COLUMN_TEXT', 70);
		$global_system_vars = GlobalT::orderBy('id', 'desc')->first();
		Log::info('***** after $global_system_vars *****');
		//Log::info($global_system_vars);

		$merchant_id = $request->get('merchant_id');
       /* $merchant_id=282;*/
        $merchant = Merchant::find($merchant_id);
		Log::info('***** after $merchant *****');
		//Log::info($merchant);

        $osmall_commission = $merchant->osmall_commission;
        $globalcommission = DB::table('global')->first();
        $globalcommission = $globalcommission->commission_type;

     //   $merchant_products=$merchant->oshopproducts;
		$merchant_policy = $merchant->return_policy;

		Log::info('***** before $merchant_pro *****');
		Log::debug('merchant_id='.$merchant_id);

		$query = "
			SELECT 
                p.* ,
                np.nproduct_id as formatted_product_id

			FROM 
                product p

			JOIN merchantproduct mp on mp.product_id=p.id
			LEFT JOIN nproductid np on np.product_id=p.id

			WHERE 
                mp.deleted_at IS NULL AND
                p.deleted_at IS NULL AND
                p.status != 'transferred' AND
                mp.merchant_id=$merchant_id
                order by p.created_at DESC";

		Log::debug('query='.$query);

        //$merchant_pro = DB::select(DB::raw($query));

        $dbh=DB::connection('mysql')->getPdo();
		$sth=$dbh->prepare($query);
        $sth->execute();
		//$merchant_pro = $sth->fetchAll(); 
 

        //$merchant_pro = $merchant->products()->
		/*
        $merchant_pro = DB::table("product")->
			join('merchantproduct as mp','mp.product_id','=','product.id')->
			whereNull('mp.deleted_at')->
   		where('mp.merchant_id',$merchant_id)->
			where('product.status','!=','transferred')->
			whereNull('product.deleted_at')->
			orderBy('product.created_at','DESC')->
			get();	
		*/

		Log::info('***** after $merchant_pro *****');
		//Log::debug($merchant_pro);

        /*
        $query="SELECT 
                product.* ,
                np.nproduct_id as formatted_product_id
		} catch (\Exception $e) {
			Log:debug($e->getFile().':'.$e->getLine().':'.$e->getMessage());
		}

                FROM 
                product 
                JOIN merchantproduct mp on mp.product_id=product.id
                LEFT JOIN nproductid np on np.product_id=product.id
                WHERE 
                mp.deleted_at IS NULL AND
                product.deleted_at IS NULL AND
                product.status!='transferred' AND
                mp.merchant_id=$merchant_id
                order by product.created_at DESC
                
        ";
        $merchant_pro=DB::select(DB::raw($query));
       
        $dbh=DB::connection()->getPdo();
        $sth=$dbh->prepare($query);
        $sth->execute();
		$merchant_pro = $sth->fetchAll();
        */

		$i = 1; 
		$return_html = '';
		$oshops = DB::table('oshop')->
			select('oshop.*')->
			join('merchantoshop','oshop.id','=','merchantoshop.oshop_id')->
			where('status','!=','transferred')->
			where('merchantoshop.merchant_id',$merchant_id)->
			orderBy('single','DESC')->
			get();

		$productarr = array();
		$return = array();

		//$merchant_pro = $sth->fetchAll(); 
		$j = 0;

		Log::info('**** BEFORE while() *****');

		while ($pp = $sth->fetch()) {
		//foreach($merchant_pro as $pp){
			$profile_product = (array) $pp;

			//Log::info($j++.":".$profile_product['name']);
			Log::info($j++);

			if(!is_null($profile_product)){
				$del_option = $profile_product['del_option'];
				if($del_option == 'own'){
					$delivery_pricec =
						$profile_product['del_west_malaysia'];
				} else {
					if($del_option == 'system'){
						$del_calculation = new Delivery;
						$delivery_pricec =
							$del_calculation->calculate_price(
								$profile_product['weight'],
								$profile_product['length'],
								$profile_product['width'],
								$profile_product['height'],
								$profile_product['del_option']);
					} else {
						$delivery_pricec = 0;
					}
				}	

				$profile_product['delivery_pricec'] = $delivery_pricec;
				$myoshop = DB::table('oshopproduct')->
					where('product_id',$profile_product['id'])->
					join('oshop','oshopproduct.oshop_id','=','oshop.id')->
					first();

				$profile_product['myoshop'] = $myoshop;

			/*	$formatted_product_id =IdController::nP($profile_productid);*/
				/*$profile_product->formatted_product_id = $formatted_product_id;*/

				$b2b = DB::table('product')->
					where('parent_id',$profile_product['id'])->
					where('segment','b2b')->
					first();

				$profile_product['b2b'] = $b2b;
				array_push($productarr,$profile_product);
				$i++;
			}
		}

 		$ret = json_encode([
			'data'=>$productarr,
			'oshops'=>$oshops,
			'commission_type'=>$merchant->commission_type,
			'globalcomm'=>$globalcommission,
			'osmall_commission'=>$osmall_commission
		]); 

		return $ret;

		/*
		return response()->json([
			'data'=>$productarr,
			'oshops'=>$oshops,
			'commission_type'=>$merchant->commission_type,
			'globalcomm'=>$globalcommission,
			'osmall_commission'=>$osmall_commission
		]);
		*/
	}

    public function transfer_product(Request $r)
    {
        $resp=[];
        $resp["status"]="failure";
        if (!Auth::user()->hasRole('adm')) {
            
            $resp["short_message"]="Unauthorized Access";
            return response()->json($resp);
        }
        /*Space for more validation */
        // CSRF
        /*Space for more validation ends*/
        /*
            Tables to be affected by transfer
            oshopproduct
            merchantproduct
        
        */ 
        try {
            $origOshop=$r->origOshop;
            $transferToOshop=$r->transferToOshop;
            $product=$r->product;
            $admin_user_id=Auth::user()->id;
            $origMerchant=DB::table('oshopmerchant')->where('oshop_id',$origOshop)->pluck('merchant_id');
            $transferToMerchant=DB::table('oshopmerchant')->where('oshop_id',$transferToOshop)->pluck('merchant_id');
        } catch (\Exception $e) {
            $resp['short_message']=$e->getMessage();
            $resp['long_message']="Invalid Params";
            return response()->json($resp);
        }

        try {
            // Delete the existing record in merchantproduct & oshopproduct.
            DB::table('merchantproduct')
            ->where('product_id',$product_id)
            ->whereNull('deleted_at')
            ->where('merchant_id',$origMerchant)
            ->update(['deleted_at'=>date('Y-m-d H:i:s')]);
            DB::table('oshopproduct')
            ->where('product_id',$product_id)
            ->whereNull('deleted_at')
            ->where('oshop_id',$origOshop)
            ->update(['deleted_at'=>date('Y-m-d H:i:s')]);
            // Insert the new records.
                DB::table('merchantproduct')
                ->insert([
                    "merchant_id"=>$transferToMerchant,
                    "product_id"=>$product_id
                   
                    ]);
                DB::table('oshopproduct')
                ->insert([
                    "oshop_id"=>$transferToOshop,
                    "product_id"=>$product_id
                   
                    ]);
            /*****************/ 
            /*Record the transfer*/ 
            DB::table('producttransferlog')
            ->insert([
                "old_oshop_id"=>$origOshop,
                "new_oshop_id"=>$transferToOshop,
                "old_merchant_id"=>$origMerchant,
                "new_merchant_id"=>$transferToMerchant,
                "notes"=>"No note",
                "admin_user_id"=>$admin_user_id
                ]);
            $resp['status']="success";
            $resp['short_message']="success";
            $resp['long_message']="Product transfer done";

        } catch (\Exception $e) {
            $resp['short_message']=$e->getMessage();
            $resp['long_message']="Failed to process";

        }
        return response()->json($resp);
    }		

    public function pm()
    {
        $product=Product::where('segment','b2c')->
            with('category')->
            with('brand')->
            with('subCategory')->
            with('productdealer')->
            with('dealers')->
            whereNull('product.deleted_at')->
            
            select( 'product.id' ,
                  'product.name' ,
                  'product.brand_id' ,
                  'product.parent_id' ,
                  'product.category_id' ,
                  'product.subcat_id' ,
                  'product.subcat_level'  ,
                  'product.segment' ,
                  'product.photo_1' ,
                  'product.photo_2' ,
                  'product.photo_3' ,
                  'product.photo_4' ,
                  'product.photo_5' ,
                  'product.adimage_1' ,
                  'product.adimage_2' ,
                  'product.adimage_3' ,
                  'product.adimage_4' ,
                  'product.adimage_5' ,
                  'product.description' ,
                  'product.free_delivery' ,
                  'product.free_delivery_with_purchase_qty' ,
                  'product.views' ,
                  'product.display_non_autolink' ,
                  'product.del_worldwide'  ,
                  'product.del_west_malaysia'  ,
                  'product.del_sabah_labuan'  ,
                  'product.del_sarawak'  ,
                  'product.cov_country_id' ,
                  'product.cov_state_id' ,
                  'product.cov_city_id' ,
                  'product.cov_area_id' ,
                  'product.b2b_del_worldwide' ,
                  'product.b2b_del_west_malaysia' ,
                  'product.b2b_del_sabah_labuan' ,
                  'product.b2b_del_sarawak' ,
                  'product.b2b_cov_country_id' ,
                  'product.b2b_cov_state_id' ,
                  'product.b2b_cov_city_id' ,
                  'product.b2b_cov_area_id' ,
                  'product.del_pricing'  ,
                  'product.del_width'  ,
                  'product.del_lenght'  ,
                  'product.del_height'  ,
                  'product.del_weight'  ,
                  'product.weight'  ,
                  'product.height'  ,
                  'product.width'  ,
                  'product.length'  ,
                  'product.del_option' ,
                  'product.retail_price' ,
                  'product.original_price' ,
                  'product.discounted_price',
                  'product.private_retail_price' ,
                  'product.private_discounted_price' ,
                  'product.stock' ,
                  'product.available' ,
                  'product.private_available' ,
                  'product.b2b_available' ,
                  'product.hyper_available' ,
                  'product.owarehouse_moq' ,
                  'product.owarehouse_moqpb' ,
                  'product.owarehouse_moqperpax' ,
                  'product.owarehouse_price' ,
                  'product.measure'  ,
                  'product.owarehouse_units' ,
                  'product.owarehouse_ave_unit_price' ,
                  'product.type'  ,
                  'product.owarehouse_duration' ,
                  'product.smm_selected'  ,
                  'product.oshop_selected'  ,
                  'product.mc_sales_staff_id' ,
                  'product.referral_sales_staff_id' ,
                  'product.mcp1_sales_staff_id' ,
                  'product.mcp2_sales_staff_id' ,
                  'product.psh_sales_staff_id' ,
                  'product.osmall_commission'  ,
                  'product.b2b_osmall_commission'  ,
                  'product.mc_sales_staff_commission'  ,
                  'product.mc_with_ref_sales_staff_commission'  ,
                  'product.referral_sales_staff_commission'  ,
                  'product.mcp1_sales_staff_commission'  ,
                  'product.mcp2_sales_staff_commission'  ,
                  'product.smm_sales_staff_commission'  ,
                  'product.psh_sales_staff_commission'  ,
                  'product.str_sales_staff_commission'  ,
                  'product.return_policy' ,
                  'product.return_address_id' ,
                  'product.status' ,
                  'product.active_date'  ,
                  'product.deleted_at'  ,
                  'product.created_at' ,
                  'product.updated_at')
            ->where('product.id','=',541)
            ->orderBy('product.id','DESC')
            ->take(100)->get();
        $brands = DB::table('brand')->get();
        $categories = DB::table('category')->get();
        $subcategories =DB::select(DB::raw('SELECT
        id, subcat_level, description FROM (
            SELECT subcat_level_1.id, "1" as subcat_level,
                subcat_level_1.description FROM subcat_level_1
            UNION
            SELECT subcat_level_2.id, "2" as subcat_level,
                subcat_level_2.description FROM subcat_level_2
            UNION
            SELECT subcat_level_3.id, "3" as subcat_level,
                subcat_level_3.description FROM subcat_level_3
        ) as TT'
        ));
        $currency= DB::table('currency')->where('active', 1)->first()->code;
        return view('admin/adminMasterProduct')->
            with('product',$product)->
            with('currency',$currency)->
            with('brands',$brands)->
            with('categories', $categories)->
            with('subcategories', $subcategories);

    }

    function prouctcashback(Request $re){
        $flag = 0;
        $input =  $re->all();
        if($input['value'] == '') {
            $input['value'] = '0';
        }
        $product = Product::where('id',$input['id'])->first();
        $cash = array();
        $cash['private_cashback'] = $input['value'];
        $flag = $product->update($cash);
        if($flag == true) {
            $flag = 1;
        }
        return json_encode($flag);
    }

    function prouctpcashback(Request $re){
        $flag = 0;
        $input =  $re->all();
        if($input['value'] == '') {
            $input['value'] = '0';
        }
        $product = Product::where('id',$input['id'])->first();
        $cash = array();
        $cash['pcashback'] = $input['value'];
        $flag = $product->update($cash);
        if($flag == true) {
            $flag = 1;
        }
        return json_encode($flag);
    }

    public function subcats_by_pid(Request $r)
    {
        $data= array();
        $ret=array();
        $ret['status']="failure";
        try {
            $pids=$r->pids;
        } catch (\Exception $e) {
            return $ret;
        }
        try {
			$products=Product::whereIn('id',$pids)->get();
			foreach ($products as $key => $value) {
				$table="subcat_level_".$value->subcat_level;
				$subcat=DB::table($table)->where('id',$value->subcat_id)->pluck('name');

				$temp['id']=$value->id;
				$temp['subcat_name']=$subcat;
				$temp['pstatus']=$value->status;
				array_push($data, $temp);
			 }
         
			 $ret['status']="success";
			 $ret['data']=$data;
        } catch (\Exception $e) {
            
        }

         return response()->json($ret);
    }

    public function get_price(Request $r)
    {
        $ret=array();
        $product_id=$r->product_id;
        $quantity=$r->quantity;
        $product=Product::find($product_id);
        $ret['status']='failure';
        if (is_null($product) or $quantity>$product->available) {
            $ret['status']='failure';
            $ret['short_message']='validation failure';
            $ret['long_message']="Please reload the page to get available quantity";
            return response()->json($ret);
        }
        try {
			if($product->segment == 'b2b'){
				$wholesales = DB::table('wholesale')->where('product_id',$product->id)->where('funit','<=',$quantity)->orderBy('funit','DESC')->first();
				if(is_null($wholesales)){
					$ret['status']='failure';
					$ret['short_message']='validation failure';
					$ret['long_message']="Please reload the page to get available quantity";
					return response()->json($ret);
				}
				$ret['price']=$wholesales->price;
				$ret['price']=$ret['price']*$quantity;
			}
			if($product->segment == 'b2c'){
				$ret['price']=$product->discounted_price>0?$product->discounted_price:$product->retail_price;
				$ret['price']=$ret['price']*$quantity;
			}
            
            $del= new Delivery;
            $ret['delivery']=$del->get_delivery_price($product_id,$quantity);
            
            $ret['disable']='none';
            if ($quantity == $product->available) {
                $ret['disable']="add";
            }elseif ($product->available==1) {
                $ret['disable']='both';
            }
            $ret['status']='success';
            $ret['total']=number_format(($ret['price']+$ret['delivery'])/100,2);
            $ret['price']=number_format($ret['price']/100,2);
            $ret['delivery']=number_format($ret['delivery']/100,2);
        } catch (\Exception $e) {
            $ret['short_message']=$e->getMessage();
        }
        return $ret;
    }
	
    public function get_price_b2b(Request $r)
    {
        $ret=array();
        $product_id=$r->product_id;
        $quantity=$r->quantity;
        $product=Product::find($product_id);
        $ret['status']='failure';
        if (is_null($product) or $quantity>$product->available) {
            $ret['status']='failure';
            $ret['short_message']='validation failure';
            $ret['long_message']="Please reload the page to get available quantity";
            return response()->json($ret);
        }
        try {
			$wholesales = DB::table('wholesale')->where('product_id',$product->id)->where('funit','<=',$quantity)->orderBy('funit','DESC')->first();
			if(is_null($wholesales)){
				$ret['status']='failure';
				$ret['short_message']='validation failure';
				$ret['long_message']="Please reload the page to get available quantity";
				return response()->json($ret);
			}
            $ret['price']=$wholesales->price;
            $ret['price']=$ret['price']*$quantity;
            $del= new Delivery;
            $ret['delivery']=$del->get_delivery_price_b2b($product_id,$quantity,$wholesales->price);
            $ret['disable']='none';
            if ($quantity == $product->available) {
                $ret['disable']="add";
            }elseif ($product->available==1) {
                $ret['disable']='both';
            }
            $ret['status']='success';
            $ret['total']=number_format(($ret['price']+$ret['delivery'])/100,2);
            $ret['price']=number_format($ret['price']/100,2);
            $ret['delivery']=number_format($ret['delivery']/100,2);
        } catch (\Exception $e) {
            $ret['short_message']=$e->getMessage();
        }
        return $ret;
    }	
    public function import_public(Request $request)
    {
        $selluser = Auth::user();
        $merchant_id = $request->get('merchant_id');
        $merchant = Merchant::find($merchant_id);
        $file_data = array();
        return  view('import_public_form',compact('merchant_id','selluser','file_data'));
    }
    public function import_file_post(Request $request)
    {
        $input = $request->all();
        $selluser = Auth::user();
        $counter = 0;
        $flag = 0;
        $pro_detail = array();
        $pro_data = array();
        $path = Input::file('file1');
        if($path != null){
        $doc_extension = $this->check_extension_document($path->getClientOriginalName());
        //print_r($doc_extension);die;
        if($doc_extension == 1){
            $path = Input::file('file1')->getRealPath();
            $file_data = Excel::load($path, function($reader) {
            })->get();
            $pro_data = array(); 
            $pro_detail = array();
            $counter = 0;
            foreach ($file_data as $value) {
               
                $pro_data['name'] = $value->name;
                if($value->brand == null){
                    $pro_data['brand_id'] = '0';
                }else{
                    $pro_data['brand_id'] = $value->brand;
                }
                if($value->category_id == null){
                    $pro_data['category_id'] = '0';
                }else{
                    $pro_data['category_id'] = $value->category_id;
                }
                $pro_data['description'] =  $value->description;
                $pro_data['retail_price'] = $value->retail_price;
                $pro_data['discounted_price'] = $value->discounted_price;
                $pro_data['available'] = '';
                $pro_detail[$counter] = $pro_data;
                $counter++;
            }
           $flag = 1;
        }
        }
        $result['count']=$counter;
        $result['flag']=$flag;
        $result['result']=$pro_detail;
        return json_encode($result);
            //return  view('import_public_form',compact('merchant_id','selluser','file_data'));
    }
    function import_file_process(Request $request)
    {
        $input = $request->all();
       // $result = array();
        $response = 'Error:';
        if($input['name'] == null)
        {
            $response = $response.'Missing Name';
        }
        if($input['category_id'] == null)
        {
            $response = $response.', Missing Category id';
        }
        if($input['brand_id'] == null){
            $response = $response.', Missing Brand id';
        }
        if($response == 'Error:')
        {
            $result_table = DB::table('product')->insert($input);  
            if($result_table == true)
            {
                $response = '<span style="color:green;">Sucess:Insertd Record</span>';
            }else{
                $response  = '<span style="color:red;">Error: Not Create Record</span>';
            }
        }else{
            $response = "<span style='color:red;'>".$response."</span>";
        }
        return $response;
        
    }
    public function check_extension_document($docFile = null) {
        $valid_formats = array("xlsx","xls");
        $name = $docFile;
        list($txt, $ext) = explode(".", $name);
        if (in_array($ext, $valid_formats)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function export_public(Request $request)
    {
        $user = Auth::user();
        $merchant_id = $request->get('merchant_id');
        $merchant = Merchant::find($merchant_id);
        $merchant_pro = $merchant->products()
        ->join('merchantproduct as mp','mp.product_id','=','product.id')
        ->join('nproductid as np','np.product_id','=','product.id')
        ->join('locationproduct as lp','lp.product_id','=','product.id')
        ->whereNull('mp.deleted_at')
        ->where('product.status','!=','transferred')
        ->whereNull('product.deleted_at')->selectRaw('product.id,sum(lp.quantity) as quantity,np.nproduct_Id,product.name,product.brand_id,product.description,product.retail_price,product.discounted_price,product.available')->orderBy('product.created_at','DESC')
        ->groupby('product.id')
        ->get();	
        //dd($merchant_pro);
        $data1 = array();
        foreach($merchant_pro as $product)
        {
            //dd($product);
            $p['Product ID'] = $product->nproduct_Id;
            $p['Name'] = $product->name;
            if($product->brand_id != '')
            {
                $p['Brand'] = $product->brand->name;
            }else{
                $p['Brand'] = '';
            }
            if($product->category_id != '')
            {
                $p['Category'] = $product->category->name;
            }else{
                $p['Category'] = ''  ;
            }
            $p['Description'] = $product->description;
            $p['Retail Price'] = $product->retail_price;
            $p['Discounted Price'] = $product->discounted_price;
            $p['Online Inventory'] = $product->available;
            $p['Offline inventory'] = $product->quantity;
            $data1[] = $p;
        }
       
        Excel::create('Product list', function($excel) use ($data1) {
            
            $excel->sheet('Excel sheet', function($sheet) use ($data1) {
                $sheet->fromArray($data1);
                $sheet->setOrientation('landscape');
                
            });
        })->export('xls');
        
       
        return Redirect::back();
        
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function qrbccontent(Request $r)
    {
        $ret=array();
        $action=$r->action;
        $table="qrbc_content";
        try{

            switch ($action) {
                case 'fetch_data':

                    $data=DB::table($table)
                    ->where("product_id",$r->product_id)
                    ->where("mode",$r->mode)
                    ->where("type",$r->type)
                    ->whereNull("deleted_at")
                    ->orderBy("created_at","DESC")
                    ->get();

                    $ret["data"]=$data;
                    break;
                case 'save_data':
                    $to_insert=[
                    "mode"=>$r->mode,
                    "type"=>$r->type,
                    "product_id"=>$r->product_id,
                    "content"=>$r->content,
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now()
                    ];
                    $id=DB::table($table)
                    ->insertGetId($to_insert);
                    $ret["qrbc_id"]=$id;
                    
                    break;
                case 'delete_data':
                    $to_update=[
                   
                    "deleted_at"=>Carbon::now()
                    ];
                    DB::table($table)
                    ->where("id",$r->qrbc_id)
                    ->update($to_update);
                    $ret["status"]="success";
                    break;

                default:
                    
                    break;
            }

        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            
            Log::info("Error @ ".$e->getLine()." file ".$e->getFile().
				" ".$e->getMessage());
        }
        return response()->json($ret,200);
    }
    
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function barcode_generate($product_id,$barcode=NULL)
    {
        $selluser = User::find(Auth::user()->id);
        $currency = Currency::where('active','=',1)->first();
        if ($product_id == "default") {
            $product[0]["created_at"] = "00:00:00";
			$product[0]["nproduct_id"] = rand(10000,9000000).
				rand(10000,9000000).rand(10000,9000000).rand(10000,9000000);
            $product[0]["id"] = 0;
            $product[0]["name"] = "Default";
            
			return view("product.barcode-default",
				compact('selluser','currency'))->
				with("product",$product[0]) ;
        }

        $ret=array();
        if (!Auth::check()) {
            return view("common.generic")
            ->with("message_type","error")
            ->with("message","Please login to access this page");
        }

        if (!Auth::user()->hasRole("mer") and !Auth::user()->hasRole("adm")) {
            return view("common.generic")
            ->with("message_type","error")
            ->with("message","Please login as merchant to access this page");
        }

        $user_id=Auth::user()->id;
        /* Merchant Product Validation*/

        $does_exist=DB::table("merchantproduct")
        ->join("merchant","merchant.id","=","merchantproduct.merchant_id")
        ->where("merchantproduct.product_id",$product_id)
        ->where("merchant.user_id",$user_id)
        ->where("merchant.status","active")
        ->whereNull("merchant.deleted_at")
        ->whereNull("merchantproduct.deleted_at")
        ->first();

        if (empty($does_exist) and !Auth::user()->hasRole("adm")) {
            return view("common.generic")
				->with("message_type","error")
				->with("message","This product is not valid");
        }

        try{
             $product=DB::table("product")
            ->leftJoin("nproductid","nproductid.product_id","=","product.id")
            ->where("product.id",$product_id)
            ->select("product.created_at","product.id","nproductid.nproduct_id","product.name")
            ->whereNull("product.deleted_at")
            ->orderBy("product.created_at","DESC")

            ->first();

            if (empty($barcode)) {
                $barcode=$product->nproduct_id;
            }
         /*dd($product);*/
            
        } catch(\Exception $e){
            
			Log::info("Error @ ".$e->getLine()." file ".$e->getFile().
				" ".$e->getMessage());

            return view("common.generic")
				->with("message_type","error")
				->with("message","This product is not valid");
        }

		$wcppScript = WebClientPrint::createWcppDetectionScript(
			action('WebClientPrintController@processRequest'),
			Session::getId()); 

		$wcpScript = WebClientPrint::createScript(
			action('WebClientPrintController@processRequest'),
			action('DemoPrintCommandsController@printCommands'),
			Session::getId());    
 
		return view("product.barcode",
			compact('selluser','currency','barcode','wcppScript','wcpScript'))
        ->with("product",$product)
        ;
    }

    function action_form_data() {
        
        $formData = Input::all();
        dd($formData);
    }
/*
    function status_form_data() {
        $formData = Input::all();
        
        dd($formData);
        
    }
*/
    public function status_form_data(Request $request)
    {
        $input = $request->all();
        $input['created_at'] = date('Y-m-d H:i:s');
        $input['updated_at'] = date('Y-m-d H:i:s');
        $responce  = DB::table('prospect')->insertGetId($input);
        dd($responce);
    }

    public function branchSubcat($location_id,Request $request){
        $merchant = Merchant::where('user_id','=',Auth::user()->id)->first();
        $merchant_id = $merchant->id;
        $subcatdata = DB::select(DB::raw(
                "select count(distinct(product_id)) as productcount, subcat.subcat_id, subcat_level, ".
                // "sum(pcount) as productcount,".
                "subcat_level_1.name,subcat_level_1.id as level1_id ".
                "from ( ".
                   "select p.subcat_id, p.subcat_level, p.id as product_id ".
                   // " count(p.id) as pcount ". 
                    "from product as p ".
                    "join merchantproduct as mp ".
                        "on p.id = mp.product_id ".
                        "and mp.merchant_id = ".$merchant_id." ". 
                    // "join locationproduct as lp ".
                    //     "on p.id = lp.product_id ".
                    //     "and lp.location_id = ".$location_id." ".
                    // "GROUP BY p.subcat_id ". 
                ") as subcat ".
                "join subcat_level_1 ".
                    "on id = ( case ". 
                        "when subcat_level = 1 then subcat_id ".
                        "WHEN subcat_level = 2 then ( ".
                            "select subcat_level_1_id ".
                            "from subcat_level_2 as s2 ".
                            "where s2.id = subcat_id) ". 
                        "WHEN subcat_level = 3 then ( ".
                            "select subcat_level_1_id ".
                            "from subcat_level_3 as s3 ".
                            "where s3.id = subcat_id)". 
                        "end ) ".
                "GROUP by subcat_level_1.id ". 
                "ORDER by subcat_level_1.name"));

        return view("product.branchsubcat",compact('subcatdata','location_id'));
    }

    public function branchProduct($location_id,$subcat_id,Request $request){

        // $merchant_id = Auth::user()->id;
        $selluser = \App\Models\User::find(Auth::user()->id);
        $merchant = Merchant::where('user_id','=',Auth::user()->id)->first();
        $merchant_id = $merchant->id;

        $products = DB::select(DB::raw(
                "select p.id,p.name,p.thumb_photo,np.nproduct_id,COUNT(rw.item_product_id) as rw_count ". 
                    "from product as p ".
                    "join merchantproduct as mp ".
                        "on p.id = mp.product_id ".
                        "and mp.merchant_id = ".$merchant_id." ".
                    "join nproductid as np ".
                        "on p.id = np.product_id ".
                    "left join rawmaterial as rw ".
                        "on p.id = rw.item_product_id ".
                    // "join locationproduct as lp ".
                    //     "on p.id = lp.product_id ".
                    //     "and lp.location_id = ".$location_id." ".
                    "WHERE
                        ((subcat_id = ".$subcat_id." and subcat_level = 1)
                        or (subcat_id in( select id from subcat_level_2 where subcat_level_1_id = ".$subcat_id.") and subcat_level = 2)
                        or (subcat_id in( select id from subcat_level_3 where subcat_level_1_id = ".$subcat_id.") and subcat_level = 3)) ".
                        "GROUP BY p.id "));
        $subCategory = DB::table('subcat_level_1')->select('id','name')->where('id',$subcat_id)->first();        
//dd($products);
        return view("product.branchproduct",compact('products','subCategory','selluser'));
    }



    public function get_commission_products(Request $request){

        // $merchant_id = Auth::user()->id;
        $selluser = \App\Models\User::find(Auth::user()->id);
        $merchant = Merchant::where('user_id','=',Auth::user()->id)->first();
        $merchant_id = $merchant->id;

        $products = DB::select(DB::raw(
            "select p.id,p.name,p.thumb_photo,np.nproduct_id,COUNT(rw.item_product_id) as rw_count ".
            "from product as p ".
            "join merchantproduct as mp ".
            "on p.id = mp.product_id ".
            "and mp.merchant_id = ".$merchant_id." ".
            "join nproductid as np ".
            "on p.id = np.product_id ".
            "left join rawmaterial as rw ".
            "on p.id = rw.item_product_id ".
            "GROUP BY p.id "));
//dd($products);
        //return view("product.commission-product",compact('products','selluser'));
        return json_encode($products);
    }

    public function saveRemarks(Request $r)
    {
        $res = array();
        $res['status'] = "error";
        $save = DB::table('stockreportproduct')
                  ->where('stockreport_id',$r->srId)
                  ->update([
                    'remark' => $r->remark,
                    'updated_at' =>Carbon::now()
                  ]);
        if($save)
        {
            $res['status'] = "success"; 
        }
        return json_encode($res);
    }

    public function saveImage(Request $r)
    {
        // echo '<pre>'; print_r($r->all()); die();

        $saveSrId = $r->srid;
        $pid = $r->product_id;
        $folder = base_path() . '/public/images/siso/' . $pid;
        $folder_thumb = base_path() . '/public/images/siso/' . $pid . '/thumb';

        File::makeDirectory($folder, 0777, true, true);
        File::makeDirectory($folder_thumb, 0777, true, true);
        $destination = $folder . '/';

        $image = $r->file('image');

        if (isset($image)) {

            $image_split = explode(".", $image->getClientOriginalName());
            $arr_size = count($image_split);
            $image_format = $image_split[$arr_size - 1];
            $image_name = "siso".
                str_pad($saveSrId, 10, '0', STR_PAD_LEFT)."-".
                rand(1000, 9999) . "." . $image_format;

            if ($image->move($destination, $image_name)) {

                $imgpath = URL::to('/')."/images/siso/".$pid.
                    "/".$image_name;
                $t30path = public_path('images/siso/'.$pid.
                    '/thumb/'.$image_name);

                Image::make($imgpath)->
                    resize(80, 80, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($t30path);
                    
                $save = DB::table('stockreportproduct')
                          ->where('stockreport_id',$saveSrId)
                          ->where('product_id',$pid)
                          ->update([
                            'image' => $image_name,
                            'updated_at' =>Carbon::now()
                          ]);
            }
        }

        // return json_encode($save);
        return response()->json(array('image'=> $image_name));
    }


}
