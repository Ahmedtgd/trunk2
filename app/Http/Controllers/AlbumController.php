<?php

namespace App\Http\Controllers;

use App\Classes\Delivery;
use App\Models\Currency;
use App\Models\Profile;
use App\Models\ProfileProduct;
use App\Models\SubCatLevel2;
use App\Models\SubCatLevel3;
use App\Models\SubCatLevel4;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use App\Models\Voucher;
use DB;
use App;
use Log;
use Input;
use Auth;
use Validator;
use App\Http\Controllers\ErrorMessagesController;
use App\Models\User;
use App\Models\Product;
use App\Models\Wholesale;
use App\Models\Album;
use App\Models\Bunting;
use App\Models\GlobalT;
use App\Models\MerchantProduct;
use App\Models\Signboard;
use App\Models\VBanner;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\ProductDealer;
use App\Models\Specification;
use App\Models\SubCatLevel1;
use App\Models\SubCatLevel1Spec;
use App\Models\OshopTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Requests\productRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IdController;
use Carbon\Carbon;
//use phpWhois\Whois;

class AlbumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->countryModel = new Country();
        $this->stateModel = new State();
		$this->cityModel = new City();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */	 

  	//-----------------------------------------
  	// Created by Zurez
  	//-----------------------------------------
  	
  	public function album_product($product_id,$uid=NULL)
  	{
  		$ret=array();
  		$ret["status"]="failure";
  		if(!Auth::check()){return "";}
  		$user_id=Auth::user()->id;
  		if(!empty($uid) and Auth::user()->hasRole("adm")){
  			$user_id=$uid;
  		}
  		
  	}
  	
    public function index($uid = null,$id=null,$param = NULL)
    {	
    
		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        $cat_name = array();
        $i = 0;
        //dd($id);
        /* Getting the merchant from the last login. If the session has
		 * expired, then the session will also be lost. So we need to
		 * force a relogin again */
        // $merchant = Session::get('merchant');
		$hproduct_id = $id;
		$user_id=Auth::user()->id;
		if (Auth::user()->hasRole('adm') and !empty($uid)) {
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
		
		//dd($is_staff);
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
		$mode="product";
		if (empty($id) || $id==0) {
			# code...
			$mode="merchant";
		}
		
		
		$selluser = User::find($user_id);
        $merchant = DB::table('merchant')->where('user_id',$user_id)->first();
      	$merchant_id = $merchant->id;

		$oshoptemplate = DB::table('oshop_template')->where('merchant_id',$merchant->id)->first();
		if(!is_null($oshoptemplate)){
			$customcontroller = $oshoptemplate->controller;
			$customproductreg = $oshoptemplate->init_productreg;
			return App::make('App\Http\Controllers\\'.$customcontroller)->$customproductreg();
		} else {
			$all_system_delivery = $merchant->all_system_delivery;
			$all_own_delivery = $merchant->all_own_delivery;
		//	dd($all_system_delivery);

            //  Paul on 15 May 2017
            if ($all_system_delivery == 0 && $all_own_delivery == 0)
                $pick_up_only = 1;
            else
                $pick_up_only = 0;

			

			if ($mode=="product") {
				# code...
				$productvalidation = DB::table('merchantproduct')->where('merchant_id',$merchant_id)->whereNull('merchantproduct.deleted_at')->where('product_id',$id)->first();
				if(is_null($productvalidation) && $id > 0){
					return Redirect::back();
				}
			}
			
			/*
			 * Get Active Currency
			 */

			$currency = Currency::where('active', true)->first(['code']);

			//get album id
			$album = DB::table('album')->
				where('merchant_id',$merchant_id)->first();
			$album_id=null;
			if (!empty($album)) {
				# code...
				$album_id=$album->id;
			}

			//get signboard
			$signboards = Signboard::where('album_id', $album_id)->get();
			//dd($signboards);
			//get bunting
			$buntings = Bunting::where('album_id', $album_id)->get();

			//get signboard
			$vbanners = VBanner::where('album_id', $album_id)->get();

			//get all categories
			$allcategory = Category::all();
			$category = Category::where('enable',1)->get();

			// *MY GOD* WHICH IDIOT DID THIS?????
			//$products= Product::all();

			$products= null;

			$merchant = Merchant::find($merchant_id);
			$merchant_products=$merchant_products=DB::table('merchant as m')
			->select('p.id as id','p.name as name')
			->join('merchantproduct as oshop','oshop.merchant_id','=','m.id')
			->join('product as p','oshop.product_id','=','p.id')
			->where('m.id',$merchant_id)
			->where('p.status','active')
			->where('p.available','>',0)
			->where('p.oshop_selected','=',1)
			->whereNull('oshop.deleted_at')
			->get();

			$merchant_policy = $merchant->return_policy;
			$merchant_pro =
				$merchant->products()
				->select('product.id as id','product.name as name')->
				whereNull('product.deleted_at')->
				orderBy('product.created_at','DESC')->
				get();

			$profile_id = session()->get('profile_id');

			if (is_null($profile_id)) {
				$merchanAlbum = isset($merchant->albums) ? $merchant->albums->first() : null;
				if (!is_null($merchanAlbum)) {
					$profile_id = isset($merchanAlbum) ? $merchanAlbum->profiles->pluck('id') : null;
					session()->put('profile_id', $profile_id);
				}
			}
			//dd($merchant_pro);

			$profile_products = $merchant_pro;
			//get vouchers
			$product_vouchers=Voucher::getVouchers($profile_products);
			$addressm = null;
			$oaddressm = null;
			$ocitym = null;
			$merchantproduct = new MerchantProduct();
			if ($merchant) {
			   // $category = $merchant->categories;
				$addressm = Address::find($merchant->address_id);
				if(!is_null($addressm)){
					$citym = City::find($addressm->city_id);
				}
				$oaddressm = Address::find($merchant->oshop_address_id);
				if(!is_null($oaddressm)){
					$ocitym = City::find($oaddressm->city_id);
				}			
				//dd($addressm);
				foreach ($category as $categ) {
					$cat_name[$i]['cat_id'] = $categ->id;
					$cat_name[$i]['cat_name'] = $categ->name;
					$cat_name[$i]['cat_description'] = $categ->description;

					$subCatLevel1 = $categ->subCatLevel1;
					foreach ($subCatLevel1 as $subCategory) {
						$subcat[$i]['sub_id'] = $subCategory->id;
						$subcat[$i]['cat_id'] = $categ->id;
						$subcat[$i]['cat_name'] = $categ->name;;
						$subcat[$i]['sub_name'] = $subCategory->name;
						$subcat[$i]['sub_description'] = $subCategory->description;
						$subcat[$i]['product_count'] = $merchantproduct->
						procount($merchant_id, $categ->id, $subCategory->id);
						$i++;
					}
				}

				$brand = Brand::all();
				$oshop = $merchant->oshop_name;
				$oshops = DB::table('oshop')->select('oshop.*')->join('merchantoshop','oshop.id','=','merchantoshop.oshop_id')->where('merchantoshop.merchant_id',$merchant->id)->get();
				$description = $merchant->description;
			}
			$updateBunting = session()->get('updateBunting');
			$updateSignboard = session()->get('signboard_update');
			$updateVideoBanner = session()->get('video_banner_update');

			$section_id = session()->get('p_section_id');
			$datas = session()->get('p_section_data');
			$selected_products = [];

			if (!is_null($datas)) {
				foreach ($datas as $data) {
					if (!empty($data)) {
						foreach ($data as $c_key => $c_val) {
							if (!empty($c_val)) {
								foreach ($c_val as $p_key => $p_val) {
									if (false == array_search($p_val, $selected_products)) {
										array_push($selected_products, $p_val);
									}
								}
							}
						}
					}
				}
			}

			$countries = Country::all();
			$city = City::all();
			$areas = Area::all();
			$states = State::where('country_code','MYS')->get();
			$user = User::where('created_at','<=',Carbon::now())->get();
			$current_product = null;
			$current_productb2b = null;
			$subcat_level = null;
			$subcat_level1 = array();
			$subcat_level_1_id = null;
			$subcat_level2 = array();
			$subcat_level_2_id = null;
			$subcat_level3 = array();
			$subcat_level_3_id = null;
			$colors = null;
			$color = null;
			$model = null;
			$size = null;
			$weight = null;
			$warranty_period = null;
			$warranty_type = null;
			$colorb2b = null;
			$modelb2b = null;
			$sizeb2b = null;
			$weightb2b = null;
			$warranty_periodb2b = null;
			$warranty_typeb2b = null;		
			$prodbrand = null;
			$prodcategory = null;
			$prodsubcategory = null;
			$specialprod = null;
			$wholesaleprod = null;
			$template = null;
			$delivery_pricec = 0;
			
			if($id > 0){
				// dd("lol");
				$current_product = Product::where('product.id',$id)->
					leftJoin('productdetail',
						'product.productdetail_id','=','productdetail.id')->
						select('product.*','productdetail.data as product_details')->
						first();
				
				if(!is_null($current_product)){
					$category = Category::whereRaw('enable=1 OR id = ' . $current_product->category_id)->get();
					$colors = DB::table('productcolor')->
						join('color','productcolor.color_id','=','color.id')->
						where('productcolor.product_id',$current_product->id)->
						get();

					$subcat_level = $current_product->subcat_level;
					if($subcat_level == 3){
						$subcat_level3_idc = SubCatLevel3::where('id', $current_product->subcat_id)->first();
						if(!is_null($subcat_level3_idc)){
							$subcat_level_3_id = $subcat_level3_idc->id;
							$subcat_level_2_id = $subcat_level3_idc->subcat_level_2_id;
							$subcat_level_1_id = $subcat_level3_idc->subcat_level_1_id;
							$subcat_level3 = SubCatLevel3::where('subcat_level_2_id', $subcat_level_2_id )->where('subcat_level_1_id', $subcat_level_1_id )->where('category_id', $current_product->category_id )->get();
							$subcat_level2 = SubCatLevel2::where('subcat_level_1_id', $subcat_level_1_id)->where('category_id', $current_product->category_id)->get();							
							$subcat_level1 = SubCatLevel1::where('category_id', $current_product->category_id)->get();					
						}								
					} else if($subcat_level == 2){
						$subcat_level2_idc = SubCatLevel2::where('id', $current_product->subcat_id)->first();
						if(!is_null($subcat_level2_idc)){
							$subcat_level_2_id = $subcat_level2_idc->id;
							$subcat_level_1_id = $subcat_level2_idc->subcat_level_1_id;
							$subcat_level2 = SubCatLevel2::where('subcat_level_1_id', $subcat_level_1_id)->where('category_id', $current_product->category_id)->get();							
							$subcat_level1 = SubCatLevel1::where('category_id', $current_product->category_id)->get();					
						}					
					} else if($subcat_level == 1){
						$subcat_level1_idc = SubCatLevel1::where('id', $current_product->subcat_id)->first();
						if(!is_null($subcat_level1_idc)){
							$subcat_level_1_id = $subcat_level1_idc->id;						
							$subcat_level1 = SubCatLevel1::where('category_id', $current_product->category_id)->get();					
						}					
					}				
					$current_productb2b = Product::where('product.parent_id',$id)->
						where('product.segment','b2b')->
						leftJoin('productdetail',
							'product.productdetail_id','=','productdetail.id')->
						select('product.*','productdetail.data as product_details')->
						first();

					$prodbrand = DB::table('brand')->
						where('id',$current_product->brand_id)->first();
					$prodcategory = DB::table('category')->
						where('id',$current_product->category_id)->first();
					$prodsubcategory = DB::table('subcat_level_' .
						$current_product->subcat_level)->
						where('id',$current_product->subcat_id)->first();

					/****** SPECIFICATIONS ******/
					/*Color*/
					$colorspec = DB::table('specification')->
						where('name','color')->first();

					if(isset($colorspec)){
						$colorspecp = DB::table('productspec')->
							where('spec_id',$colorspec->id)->
							where('product_id',$id)->
							first();

						if(isset($colorspecp)){
							$color = $colorspecp->value;
						}
					}
					/*Model*/
					$modelspec = DB::table('specification')->where('name','model')->first();
					if(isset($modelspec)){
						$modelspecp = DB::table('productspec')->
							where('spec_id',$modelspec->id)->
							where('product_id',$id)->first();

						if(isset($modelspecp)){
							$model = $modelspecp->value;
						}
					}
					/*Size*/
					$sizespec = DB::table('specification')->where('name','size')->first();
					if(isset($sizespec)){
						$sizespecp = DB::table('productspec')->
							where('spec_id',$sizespec->id)->
							where('product_id',$id)->first();

						if(isset($sizespecp)){
							$size = $sizespecp->value;
						}
					}
					/*Weight*/
					$weightspec = DB::table('specification')->
						where('name','weight')->first();

					if(isset($weightspec)){
						$weightspecp = DB::table('productspec')->
							where('spec_id',$weightspec->id)->
							where('product_id',$id)->first();

						if(isset($weightspecp)){
							$weight = $weightspecp->value;
						}
					}
					/*Warranty Period*/
					$warranty_periodspec = DB::table('specification')->
						where('name','warranty_period')->first();
					if(isset($warranty_periodspec)){
						$warranty_periodspecp = DB::table('productspec')->
							where('spec_id',$warranty_periodspec->id)->
							where('product_id',$id)->first();
						if(isset($warranty_periodspecp)){
							$warranty_period = $warranty_periodspecp->value;
						}
					}
					/*Warranty Type*/
					$warranty_typespec = DB::table('specification')->
						where('name','warranty_type')->first();
					if(isset($warranty_typespec)){
						$warranty_typespecp = DB::table('productspec')->
							where('spec_id',$warranty_typespec->id)->
							where('product_id',$id)->first();
						if(isset($warranty_typespecp)){
							$warranty_type = $warranty_typespecp->value;
						}
					}
					$specialprod = DB::table('productdealer')->
						select('users.*','productdealer.dealer_id')->
						where('product_id',$current_product->id)->
						join('users', 'users.id', '=', 'productdealer.dealer_id')->
						distinct()->get();
					if(!is_null($current_productb2b)){
						
						$wholesaleprod = DB::table('wholesale')->
							where('product_id',$current_productb2b->id)->
							orderBy('funit','ASC')->get();

							/****** SPECIFICATIONS ******/
							/*Color*/
							$colorspec = DB::table('specification')->where('name','color')->first();
							if(isset($colorspec)){
								$colorspecp = DB::table('productspec')->where('spec_id',$colorspec->id)->where('product_id',$current_productb2b->id)->first();
								if(isset($colorspecp)){
									$colorb2b = $colorspecp->value;
								}
							}
							/*Model*/
							$modelspec = DB::table('specification')->where('name','model')->first();
							if(isset($modelspec)){
								$modelspecp = DB::table('productspec')->where('spec_id',$modelspec->id)->where('product_id',$current_productb2b->id)->first();
								if(isset($modelspecp)){
									$modelb2b = $modelspecp->value;
								}
							}
							/*Size*/
							$sizespec = DB::table('specification')->where('name','size')->first();
							if(isset($sizespec)){
								$sizespecp = DB::table('productspec')->where('spec_id',$sizespec->id)->where('product_id',$current_productb2b->id)->first();
								if(isset($sizespecp)){
									$sizeb2b = $sizespecp->value;
								}
							}
							/*Weight*/
							$weightspec = DB::table('specification')->where('name','weight')->first();
							if(isset($weightspec)){
								$weightspecp = DB::table('productspec')->where('spec_id',$weightspec->id)->where('product_id',$current_productb2b->id)->first();
								if(isset($weightspecp)){
									$weightb2b = $weightspecp->value;
								}
							}
							/*Warranty Period*/
							$warranty_periodspec = DB::table('specification')->where('name','warranty_period')->first();
							if(isset($warranty_periodspec)){
								$warranty_periodspecp = DB::table('productspec')->where('spec_id',$warranty_periodspec->id)->where('product_id',$current_productb2b->id)->first();
								if(isset($warranty_periodspecp)){
									$warranty_periodb2b = $warranty_periodspecp->value;
								}
							}
							/*Warranty Type*/
							$warranty_typespec = DB::table('specification')->where('name','warranty_type')->first();
							if(isset($warranty_typespec)){
								$warranty_typespecp = DB::table('productspec')->where('spec_id',$warranty_typespec->id)->where('product_id',$current_productb2b->id)->first();
								if(isset($warranty_typespecp)){
									$warranty_typeb2b = $warranty_typespecp->value;
								}
							}					
					}

				} else {
					$id = 0;
				}

				$template = DB::table('oshop_template')->where('subcat_id', $current_product->subcat_id)->where('subcat_level', $current_product->subcat_level)->first();
				$del_calculation = new Delivery;
				$delivery_pricec = $del_calculation->calculate_price($current_product->weight,$current_product->length,$current_product->width,$current_product->height,$current_product->del_option, $merchant_id);
			}
			$sp = 0; 
			$wp = 0; 
			/**CREATE VOUCHER START**/
			
			$product = DB::table('product')
				->join('voucher','voucher.product_id','=','product.id')
				->join('category','product.category_id','=','category.id')
				->select('product.id' ,
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
				  'product.cashback'  ,
				  'product.created_at' ,
				  'product.updated_at','category.name as catName',
					'voucher.id as voucherId')
				->where('voucher.status','=','active')
				->orderBy('voucher.id','desc')
				->get();
			$getCategory=Voucher::category();
			$getBrand=Voucher::Brand();
			$address = new Address();
			$userModel = $address->getMeta();
			$global_system_vars = GlobalT::orderBy('id', 'desc')->first();
			$disable_del_option = "";
			$checked_system_option = "";
			$checked_warranty_option_b2b= "";
			$checked_own_option = "";
			$checked_pickup_option = "";
			$checked_pick_up_only = "";
			
			$disable_del_option_b2b = "";
			$checked_system_option_b2b = "";
			$checked_own_option_b2b = "";
			$checked_pickup_option_b2b = "";
			$checked_pick_up_only_b2b = "";			
			//dd($current_product->del_option);
			if(!is_null($current_product)){
				if($current_product->del_option == "system"){
					$checked_system_option = "checked";
					$checked_own_option = "";
				}
				if($current_product->del_option == "pickup" || $current_product->del_option == ""){
					$checked_pick_up_only = "checked";
					$checked_own_option = "";				
				}
				if($current_product->del_option == "own"){
					$checked_pick_up_only = "";
					$checked_own_option = "checked";				
				}			
			} else {
				$checked_system_option = "checked";
			}
			if($all_system_delivery == 1){
                $checked_system_option = "checked";
                $checked_own_option = "";
                $checked_pick_up_only = "";

				$disable_sys = "";
				$disable_own = "disabled";
				$disable_pu = "disabled";
			}
			else if($all_own_delivery == 1){
                $checked_system_option = "";
                $checked_own_option = "checked";
                $checked_pick_up_only="";

                $disable_sys = "disabled";
                $disable_own = "";
                $disable_pu = "disabled";
			}else{
               /* $checked_system_option = "checked";
                $checked_own_option = "";
                $checked_pick_up_only="";*/

                $disable_sys = "";
                $disable_own = "";
                $disable_pu = "";
            }
			
			if(!is_null($current_productb2b)){
				if($current_productb2b->del_option == "system"){
					$checked_system_option_b2b = "checked";
					$checked_own_option_b2b = "";
				}
				if($current_productb2b->del_option == "pickup" || $current_productb2b->del_option == ""){
					$checked_pick_up_only_b2b = "checked";
					$checked_own_option_b2b = "";				
				}
				if($current_productb2b->del_option == "own"){
					$checked_pick_up_only_b2b = "";
					$checked_own_option_b2b = "checked";				
				}
				if($current_productb2b->type == "warranty"){
					$checked_warranty_option_b2b = "checked";
					$checked_own_option_b2b = "";
				}				
			} else {
				$checked_system_option_b2b = "checked";
			}
			if($all_system_delivery == 1){
                $checked_system_option_b2b = "checked";
                $checked_own_option_b2b = "";
                $checked_pick_up_only_b2b = "";

				$disable_sys_b2b = "";
				$disable_own_b2b = "disabled";
				$disable_pu_b2b = "disabled";
			}
			else if($all_own_delivery == 1){
                $checked_system_option_b2b = "";
                $checked_own_option_b2b = "checked";
                $checked_pick_up_only_b2b="";

                $disable_sys_b2b = "disabled";
                $disable_own_b2b = "";
                $disable_pu_b2b = "disabled";
			}else{
               /* $checked_system_option = "checked";
                $checked_own_option = "";
                $checked_pick_up_only="";*/

                $disable_sys_b2b = "";
                $disable_own_b2b = "";
                $disable_pu_b2b = "";
            }			

            // if($all_system_delivery == 1){
            // 	$disable_del_option = "disabled";
            // 	$checked_system_option = "checked";
            // 	$checked_own_option = "";
            // }
            // if($all_own_delivery == 1){
            // 	$disable_del_option = "disabled";
            // 	$checked_system_option = "";
            // 	$checked_own_option = "checked";
            // }
		   // dd($checked_pick_up_only);
			$outlets = null;
			$station = DB::table('station')->where('user_id',$merchant->user_id)->first();
			if(!is_null($station)){
				$outlets = DB::table('sproperty')->where('station_id',$station->id)
							->select(DB::raw('sproperty.id as spid, sproperty.biz_name as biz_name, address.*, city.name as city_name'))
							->leftJoin('address','address.id','=','sproperty.address_id')
							->leftJoin('city','address.city_id','=','city.id')
							->get();
			}
			$merchant_iidd = DB::table('merchant')->where('user_id',$merchant->user_id)->first()->id;
			/*$dealers = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('autolink','users.id','=','autolink.initiator')->where('autolink.responder',$merchant_iidd)->where('autolink.status','linked')->whereNotExists(function($query)
				{
					$query->select(DB::raw(1))
						  ->from('productdealer')
						  ->whereRaw('productdealer.dealer_id = users.id');
				})->get();		*/
			$dealers = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('autolink','users.id','=','autolink.initiator')->where('autolink.responder',$merchant_iidd)->where('autolink.status','linked')->get();
			//dd($current_product->subcat_level_2_id);
			/**CREATE VOUCHER END**/
			// dd($selluser);
			// 
			
			$disable_del_option="";
			$productapp['approval']=array();
			$aprsections = DB::table('aprsection')->where('type','product')->get();
				foreach($aprsections as $aprsection){
					$getstatus = DB::table('aprchecklist')->where('product_id',$id)
										->where('aprsection_id',$aprsection->id)->first();
					$status = "";
					if(!is_null($getstatus)){
						$status = $getstatus->status;
					}
					$productapp['approval'][$aprsection->name] = $status;
			}

            //  Paul testing on 15 May 2017
            // $all_system_delivery = 0;
            // $all_own_delivery = 1;
            // $pick_up_only = 0;
			
			$logistic_id = null;
			
			if($merchant->own_delivery_logistic_id > 0){
				$logistic_id = $merchant->own_delivery_logistic_id > 0;
			}

			$hyper = null;
			if(isset($hproduct_id)) {
				$hyper = DB::table('product')->
					join('owarehouse','owarehouse.product_id','=','product.id')->
					where('parent_id', $hproduct_id)->
					where('segment','hyper')->
					where('owarehouse.status','active')->
					select('product.*')->
					orderBy('product.created_at','DESC')->
					first();
			}
			//dd($hyper);
			$owarehouse = null;
			$owarehousepledges = 0;
			$owarehousepledgers = 0;
			$city_hyper = [];
			$areas_hyper = [];
			if(!is_null($hyper)){
				$stateh_id = $hyper->cov_state_id;
				$stateh = DB::table('state')->where('id',$stateh_id)->first();
				if(!is_null($stateh)){
					$city_hyper = DB::table('city')->where('state_code',$stateh->code)->get();
					$cityh_id = $hyper->cov_city_id;
					$cityid = DB::table('city')->where('id',$cityh_id)->first();
					if(!is_null($cityid)){
						$areas_hyper = DB::table('area')->where('city_id',$cityid->id)->get();
					}
				}
				$owarehouse = $this->processOwarehouseInfo($hyper->id);
				if(!is_null($owarehouse)){
					$owarehousepledges = $this->processOwarehousePledges($owarehouse->id);
					$owarehousepledgers = $this->processOwarehousePledgers($owarehouse->id);
				}
				if($hyper->del_option == "system"){
					$checked_system_option = "checked";
					$checked_own_option = "";	
					$all_system_delivery = 1;				
				} else {
					$all_own_delivery = 0;
				}				
			}
			
			return view('album_tabbed', compact(
				'getCategory','getBrand','product','products',
				'hyper',
				'city_hyper',
				'areas_hyper',
				'owarehouse',
				'owarehousepledges',
				'owarehousepledgers',
				'colors',
				'logistic_id',
				'dealers',
				'merchant',
				'outlets',
				'oshops',
				'global_system_vars',
				'param',
				'userModel',
				'productapp',
				'selluser',
                'all_system_delivery',
                'all_own_delivery',
                'pick_up_only',
				'disable_del_option',
				'checked_system_option',
				'checked_own_option',
				'checked_pickup_option',
				'checked_pick_up_only',
				'disable_sys',
				'disable_own',
				'disable_pu',
				'disable_del_option_b2b',
				'checked_system_option_b2b',
				'checked_warranty_option_b2b',
				'checked_own_option_b2b',
				'checked_pickup_option_b2b',
				'checked_pick_up_only_b2b',
				'disable_sys_b2b',
				'disable_own_b2b',
				'disable_pu_b2b',
				'merchant_products',
				'updateBunting',
				'delivery_pricec',
				'updateSignboard',
				'updateVideoBanner',
				'profile_products',
				'product_vouchers',
				'merchant_id',
				'category',
				'countries',
				'brand',
				'allcategory',
				'merchant_pro',
				'merchant_policy',
				'addressm',
				'oaddressm',
				'citym',
				'ocitym',
				'cat_name',
				'subcat',
				'signboards',
				'buntings',
				'vbanners',
				'selected_products',
				'section_id',
				'currency',
				'oshop',
				'description',
				'current_product',
				'current_productb2b',
				'city',
				'areas',
				'subcat_level',
				'subcat_level1',
				'subcat_level2',
				'subcat_level3',
				'subcat_level_1_id',
				'subcat_level_2_id',
				'subcat_level_3_id',	
				'id',
				'states',
				'color',
				'model',
				'size',
				'weight',
				'warranty_period',
				'warranty_type',
				'colorb2b',
				'modelb2b',
				'sizeb2b',
				'weightb2b',
				'warranty_periodb2b',
				'warranty_typeb2b',			
				'prodbrand',
				'prodcategory',
				'prodsubcategory',
				'wholesaleprod',
				'template',
				'specialprod',
				'sp',
				'wp',
				'user'
			));
		}
    }
	public function get_delprice(Request $req)
    {
		$del_calculation = new Delivery;
		$delivery_pricec = $del_calculation->calculate_price($req->weight,$req->length,$req->width,$req->height,"system");
		return $delivery_pricec/100;
	}
	
    //---CopyToProfileMerchant Method---//
    public function copyToProfileMerchant($products, $profile_id)
    {
        try {
            foreach ($products as $product) {
                $profile_product = ProfileProduct::firstOrCreate(array('profile_id' => $profile_id, 'product_id' => $product->id));
//               $profile = ProfileProduct::whereProfileId($profile_id)->
//               whereProductId($product->id)->get();
//               if(count($profile) == 0){
//                   /* See if product_id exist */
//                   $profile = new ProfileProduct();
//
//                   $profile->profile_id = $profile_id;
//                   $profile->product_id = $product->id;
//
//                   $profile->save();
//               }

            }
        } catch (\Exception $e) {

        }

        return ProfileProduct::whereProfileId($profile_id)->get()->load([
            'product',
            'product.wholesale',
            'product.category',
            'product.subCategory',
            'product.brand',
//            'product.specification',
        ]);
    }

    /*
     * store SIGNBOARD
     */
    public function signboard(Request $req)
    {
        $merchant = Merchant::where('user_id', $req->userid)->first();
        $merchant_id = $merchant->id;
        $album = DB::table('album')->where('merchant_id', $merchant_id)->first();
		$album_id = $album->id;
        $signboard = new Signboard();
        return Response::json(array(
            'message' => 'Signboard Successfully updated',
            'id' => $signboard->updateSignboard($req, $album_id, $merchant_id)));
    }

    public function update_current_signboard(Request $req, $id, $userid, $enabled)
    {
        $merchant = Merchant::where('user_id', $userid)->first();
        $merchant_id = $merchant->id;
        $album = DB::table('album')->where('merchant_id', $merchant_id)->first();
		$album_id = $album->id;
		$sign = DB::table('signboard')->where('id',$id)->first();
		$active = false;
		if($enabled == 1){
			$active = true;
		}
		try {
			if (isset($sign->oshop_id) and !is_null($sign)) {
				DB::table('signboard')->where('oshop_id',$sign->oshop_id)->update(['active'=>false]);
			}
		} catch (\Exception $e) {
			
		}
		try {
			if (isset($active)) {
				# code...
					DB::table('signboard')->where('id',$id)->update(['active'=>$active]);
			}
		
		} catch (\Exception $e) {
			
		}
		
        return json_encode($req);
    }	
	
    public function update_current_signboard_oshop(Request $req, $id, $oshop_id, $userid)
    {
		//dd($req->all());
		$merchant = Merchant::where('user_id', $userid)->first();
        $merchant_id = $merchant->id;
        $album = DB::table('album')->where('merchant_id', $merchant_id)->first();
		$album_id = $album->id;
		DB::table('signboard')->where('id',$id)->update(['oshop_id'=>$oshop_id]);
        return json_encode($req);
    }		
	
    /*
     * store Bunting
     */
    public function bunting(Request $req)
    {
        $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        $merchant_id = $merchant->id;
        $album = DB::table('album')->where('merchant_id', $merchant_id)->first();
		$album_id = $album->id;
        $bunting = new Bunting();
        return Response::json(array(
            'message' => 'Bunting Successfully updated',
            'id' => $bunting->updateBunting($req, $album_id, $merchant_id)));
    }

    /*
     * store vbanner link
     */
    public function vbannerLink(Request $req)
    {
        $merchant = Merchant::where('user_id', Auth::user()->id)->first();
		$merchant_id = $merchant->id;
        $album = DB::table('album')->where('merchant_id', $merchant_id)->first();
		$album_id = $album->id;
        $banner = new VBanner();
        $banner->updateVBanner_link($req, $album_id);
        return "Banner Successfully updated";
    }

    /*
     * store vbanner image
     */
    public function vbannerImage(Request $req)
    {
        $image = $req->file('file');
        if ($image == null) return "false";

        $image_type = $image->getClientMimeType();
        $file_size_bytes = $image->getSize();
        $file_size_kb = $file_size_bytes / 1000;
        if ($image_type == 'video/mp4') {
            $global = GlobalT::orderBy('id', 'desc')->first();

            if (!$global) {
                $max_video_size = 1;

            } else {
                $max_video_size = $global->max_video_size;
            }

            if ($file_size_kb / 1024 > $max_video_size) {
                return "false";

            } else {
                $album_id = Session::get('album_id');
                $banner = new VBanner();
                $banner->updateVBanner_image($req, $album_id);
                return "Banner Successfully updated";
            }

        } else {
            $album_id = Session::get('album_id');
            $banner = new VBanner();
            $banner->updateVBanner_image($req, $album_id);
            return "Banner Successfully updated";
        }
    }

    /*
     * deletebunting
     */
    public function deletebunting(Request $req)
    {
        $id = $req->info;
        Bunting::where('id', $id)->delete();
        return "Bunting Successfully Deleted";
    }

    /*
     * deletesignboard
     */
    public function deletesignboard(Request $req)
    {
        $id = $req->info;
        Signboard::where('id', $id)->delete();
        return "Signboard Successfully Deleted";
    }

    /*
    * delete banner
    */
    public function deletebanner(Request $req)
    {
        $id = $req->info;
        VBanner::where('id', $id)->delete();
        return "Banner Successfully Deleted";
    }

    /*
     * function for product detail table to show
     * wholesale detail
     */
    public function productDetail(Request $request)
    {
        //$request->id;
        if ($request->type == 'HSP') {
            $result = Wholesale::where('product_id', $request->id)->get(['unit', DB::raw('concat((Select code from currency where active=true)," ",round(price/100,2)) as price')]);
        } elseif ($request->type == 'DPR') {
            $result = Product::where('id', $request->id)
                ->get([DB::raw('CONCAT((SELECT code FROM currency WHERE active=true)," ",ROUND(del_worldwide/100,2)) as Worldwide'),
                    DB::raw('CONCAT((SELECT code FROM currency WHERE active=true)," ",ROUND(del_west_malaysia/100,2)) as West_Malaysia'),
                    DB::raw('CONCAT((SELECT code FROM currency WHERE active=true)," ",ROUND(del_sabah_labuan/100,2)) as Sabah_Labuan'),
                    DB::raw('CONCAT((SELECT code FROM currency WHERE active=true)," ",ROUND(del_sarawak/100,2)) as Sarawak')
                ]);
        } elseif ($request->type == 'DCV') {
            $rec['country'] = Product::where('id', $request->id)->first()->country->name;
            $rec['state'] = Product::where('id', $request->id)->first()->state->name;
            $rec['city'] = Product::where('id', $request->id)->first()->city->name;
            $result = array($rec);
        } elseif ($request->type == 'PSP') {
            $result = array();
        } elseif ($request->type == 'SPP') {
            $result = DB::table('productdealer')
                ->where('product_id',$request->id)
                ->join('dealer', 'productdealer.dealer_id', '=', 'dealer.id')
                ->join('users', 'dealer.user_id', '=', 'users.id')
                ->select('productdealer.special_unit', DB::raw('concat((Select code from currency where active=true)," ",round(productdealer.special_price/100,2)) as special_price'), 'users.first_name as User_Name')
                ->get();

        }

        return json_encode($result);

    }

    public function  groupCategories(Request $request){
        $category_id = $request->id;
        $groups = array();
        $category = SubCatLevel1::where('category_id',$category_id)->get(['id','name','type','description']);
        foreach($category as $item){
            $item['L2'] = SubCatLevel2::where('subcat_level_1_id','=',$item->id)->get(['id','name','type','description']);
            //$groups = $item;
            foreach($item['L2'] as $value){
                $value['L3'] = SubCatLevel3::where('subcat_level_2_id',$value->id)->get(['id','name','type','description']);
                $groups = $value;
                foreach($value['L3'] as $item1){
                    $item1['L4'] = SubCatLevel4::where('subcat_level_3_id',$item1->id)->get(['id','name','type','description']);
                    $groups = $item1;
                }
            }
        }
        //dd($category);
        return $category;
    }

    public function scanOshopTemplate(Request $req){
        $subcat_id = $req->subcat_id;
        $level = $req->level;
        $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        $oshop_template = OshopTemplate::where("merchant_id", $merchant->id)
            ->where("subcat_id",$subcat_id)
            ->where("subcat_level",$level)
            ->get(['productreg_file']);
            return $oshop_template;
    }

	public function product_update($id){
        $value = Input::get('value');
        $column = Input::get('column');
		DB::table('product')->where('id',$id)->update([$column => $value]);
        echo 'OK';
	}

	/******************** ALBUM - PRODUCT DETAILS ************************/

    public function getHyperInfo($product_id)
    {
        try{
            $hyper = $this->processHyperInfo($product_id);
			$owarehouse = null;
			$owarehousepledges = 0;
			$owarehousepledgers = 0;
			$city = City::all();
			$areas = Area::all();
			$states = State::where('country_code','MYS')->get();			
			$global_system_vars = GlobalT::orderBy('id', 'desc')->first();
			$disable_del_option = "";
			$checked_system_option = "";
			$checked_own_option = "checked";
			//dd($current_product);	
			$all_system_delivery = 0;
			$all_own_delivery = 0;
			if(!is_null($hyper)){
				$owarehouse = $this->processOwarehouseInfo($hyper->id);
				if(!is_null($owarehouse)){
					$owarehousepledges = $this->processOwarehousePledges($owarehouse->id);
					$owarehousepledgers = $this->processOwarehousePledgers($owarehouse->id);
				}
				if($hyper->del_option == "system"){
					$checked_system_option = "checked";
					$checked_own_option = "";	
					$all_system_delivery = 1;				
				} else {
					$all_own_delivery = 0;
				}				
			}
			
			if($all_system_delivery == 1){
				$disable_del_option = "disabled";
				$checked_system_option = "checked";
				$checked_own_option = "";
			}
			if($all_own_delivery == 1){
				$disable_del_option = "disabled";
				$checked_system_option = "";
				$checked_own_option = "checked";	
			}		
			$product = Product::find($product_id);
			$merchantproduct = DB::table('merchantproduct')->where('product_id',$product_id)->first();
			$del_calculation = new Delivery;
			$delivery_pricec = $del_calculation->calculate_price($product->weight,$product->length,$product->width,$product->height,$product->del_option, $merchantproduct->merchant_id);

        }catch(Exception $e){
            throw new CustomException($e);
        }

        return view('hyper')->withHyper($hyper)->withProduct($product)->withOwarehouse($owarehouse)
							->with('global_system_vars',$global_system_vars)->with('disable_del_option',$disable_del_option)
							->with('checked_system_option',$checked_system_option)->with('checked_own_option',$checked_own_option)
							->with('city',$city)->with('areas',$areas)
							->with('states',$states)
							->with('owarehousepledges',$owarehousepledges)
							->with('delivery_pricec',$delivery_pricec)
							->with('owarehousepledgers',$owarehousepledgers);
    }

    private function processHyperInfo($product_id)
    {
       $hyper = DB::table('product')->where('parent_id', $product_id)->where('segment','hyper')->orderBy('product.created_at','DESC')->first();
        return $hyper;
    }

    private function processOwarehouseInfo($hyper_id)
    {
       $owarehouse = DB::table('owarehouse')->where('product_id', $hyper_id)->orderBy('owarehouse.created_at','DESC')->first();
        return $owarehouse;
    }
	
    private function processOwarehousePledges($owarehouse_id)
    {
       $owarehousepledgesum = 0;
	   $owarehousepledge = DB::table('owarehousepledge')->select('owarehouse_id', DB::raw('SUM(pledged_qty) as pledges'))
                ->where('owarehouse_id',$owarehouse_id)
				
                ->groupBy('owarehouse_id')
                ->get();
		if(!is_null($owarehousepledge)){
			foreach($owarehousepledge as $pledge){
				$owarehousepledgesum = $pledge->pledges;
			}
		}
        return $owarehousepledgesum;
    }	
	
    private function processOwarehousePledgers($owarehouse_id)
    {
       $owarehousepledgersum = 0;
	   $owarehousepledge = DB::table('owarehousepledge')->select('owarehouse_id', DB::raw('COUNT(user_id) as pledgers'))
                ->where('owarehouse_id',$owarehouse_id)

                ->groupBy('user_id')
                ->get();
		if(!is_null($owarehousepledge)){
			foreach($owarehousepledge as $pledge){
				$owarehousepledgersum += $pledge->pledgers;
			}
		}
        return $owarehousepledgersum;
    }
	
    public function getWholesaleInfo($product_id)
    {
        try{
            $productb2b = DB::table('product')->where('parent_id', $product_id)->where('segment','b2b')->first();
            $wholesales = null;
           if(isset($productb2b)){
                $wholesales = $this->processWholesalesInfo($productb2b->id);
           }
            $product = Product::find($product_id);
			$nproduct_id = IdController::nP($product_id);
            //$productb2b = DB::table('product')->where('parent_id', $product_id)->where('segment','b2b')->first();
        }catch(Exception $e){
            throw new CustomException($e);
        }

        return view('wholesale')->withWholesales($wholesales)->withProduct($product)->withNproductid($nproduct_id)->withProductb2b($productb2b);
    }

    private function processWholesalesInfo($product_id)
    {
        $wholesales = Wholesale::where('product_id', $product_id)->whereNull('deleted_at')->orderBy('unit', 'asc')->get();
        foreach ($wholesales as $wholesale) {
            $productInfo = Product::find($wholesale->product_id);
			if(!is_null($productInfo)){
				$wholesale->product = $productInfo->name;
			} else {
				$wholesale->product = "";
			}
        }

        return $wholesales;
    }

    public function getProductDealerInfo($product_id, $userid)
    {
        try{
            $productb2b = DB::table('product')->where('id', $product_id)->where('segment','b2c')->first();
            $productdealers = null;
           if(isset($productb2b)){
                 $productdealers = $this->processProductDealersInfo($productb2b->id);
           }
            $product = Product::find($product_id);
			$merchant_iidd = DB::table('merchant')->where('user_id',$userid)->first()->id;
			$dealers = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('autolink','users.id','=','autolink.initiator')->where('autolink.responder',$merchant_iidd)->where('autolink.status','linked')->whereNotExists(function($query) use ($product_id)
            {
                $query->select(DB::raw(1))
                      ->from('productdealer')
                      ->whereRaw('productdealer.dealer_id = users.id AND productdealer.product_id = ' . $product_id);
            })->get();						
        }catch(Exception $e){
            throw new CustomException($e);
        }

        return view('productdealers')->withProductdealers($productdealers)->withDealers($dealers)->withProduct($product)->withProductb2b($productb2b);
    }

     public function getSpecificationInfo($product_id)
     {
         try{
             $specifications = $this->processSpecificationInfo($product_id);
             $specificationsp = DB::table('specification')->select('specification.id as id', 'specification.description as description')->get();
         }catch(Exception $e){
             throw new CustomException($e);
         }

         return view('specification')->withSpecifications($specifications)->withSpecificationsp($specificationsp);
     }

    public function getDeliveryPrice($product_id)
    {
        try{
            $deliveryprice = $this->processDeliveryPrice($product_id);
        }catch(Exception $e){
            throw new CustomException($e);
        }

        return view('deliveryprice')->withDeliveryprice($deliveryprice);
    }

    public function getDeliveryCoverage($product_id)
    {
        try{
            $deliverycoverage = $this->processDeliveryCoverage($product_id);
			$countries = DB::table('country')->get();
			$country_code = $this->countryModel->getCountryCode($deliverycoverage->cov_country_id);
			$states = DB::table('state')->where('country_code',$country_code->code)->get();
			$state_code = $this->stateModel->getStateCode($deliverycoverage->cov_state_id);
			$cities = DB::table('city')->where('state_code',$state_code->code)->get();
			$areas = DB::table('area')->where('city_id',$deliverycoverage->cov_city_id)->get();
        }catch(Exception $e){
            throw new CustomException($e);
        }

        return view('deliverycoverage')->withDeliverycoverage($deliverycoverage)->withCountries($countries)->withStates($states)->withCities($cities)->withAreas($areas);
    }

    private function processProductDealersInfo($product_id)
    {
        $productdealers = DB::table('productdealer')->select('users.*','productdealer.dealer_id')->where('product_id',$product_id)->join('users', 'users.id', '=', 'productdealer.dealer_id')->distinct()->get();
        return $productdealers;
    }

     private function processSpecificationInfo($product_id)
     {
         $specifications = Specification::where('productspec.product_id', $product_id)->join('productspec','productspec.spec_id','=','specification.id')->orderBy('specification.id', 'asc')->get();
         foreach ($specifications as $specification) {
            $productInfo = Product::find($specification->product_id);
            $specInfo = DB::table('productspec')->where('productspec.spec_id', $specification->spec_id)->first();
			if(!is_null($productInfo)){
				$specification->product = $productInfo->name;
			} else {
				$specification->product = "";
			}
			if(!is_null($specInfo)){
				$specification->name = $specInfo->value;
			} else {
				$specification->name = "";
			}
         }


         return $specifications;
     }

    private function processDeliveryPrice($product_id)
    {
        $deliveryprice = Product::find($product_id);
        return $deliveryprice;
    }

    private function processDeliveryCoverage($product_id)
    {
        $deliverycoverage = Product::find($product_id);
        return $deliverycoverage;
    }

    public function updateFUnit(Request $request)
    {
        $type = $request->get('type');
        $values = $this->processRequestValuesToArray($request);

        if($type == 'wholesale'){
            try{
                $success = $this->updateWholesaleFUnit($values);
            }catch(Exception $e){
                throw new CustomException($e);
            }

            return $success;
        }
        else if($type == 'product_dealers'){
            try{
                $success = $this->updateProductDealerFUnit($values);
            }catch(Exception $e){
                throw new CustomException($e);
            }

            return $success;
        }
    }

   //-----------------------------------------
   // Created by Zurez
   //-----------------------------------------
   
   public function merchant_product_json(Request $r,$uid=NULL)
   {
   	$ret=array();
   	$ret["status"]="failure";
   	if(!Auth::check()){return "";}
   	$user_id=Auth::user()->id;
   	if(!empty($uid) and Auth::user()->hasRole("adm")){
   		$user_id=$uid;
   	}
   	try{
   		$table="product";
   		$raw_data=DB::table($table)
   		->join("merchantproduct","merchantproduct.product_id","=","product.id")
   		->join("merchant","merchantproduct.merchant_id","=","merchant.id")
   		->where("merchant.user_id",$user_id)
   		//->where($table.".","")		
   		->whereNull($table.".deleted_at")
   		->orderBy($table.".created_at","DESC")
   		->select("product.name")
   		->get();
   		$data=array();
   		foreach ($raw_data as $r) {
   			array_push($data,$r->name);
   		}
   		
   		$ret["status"]="success";
   		$ret["data"]=$data;
   	}
   	catch(\Exception $e){
   		$ret["short_message"]=$e->getMessage();
   		Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
   	}
   	//ob_start('ob_gzhandler');
   	return response()->json($ret);
   }

    private function updateWholesaleFUnit($fields)
    {
        $id = $fields['id'];
        $pid =  $fields['product_id'];
        $value =  $fields['updated_value'];
        $result = Wholesale::where('id', $id)->where('product_id', $pid)->update(['funit' => $value]);
        if($result) return $value;
    }

    private function updateProductDealerFUnit($fields)
    {
        $id = $fields['id'];
        $pid =  $fields['product_id'];
        $value =  $fields['updated_value'];
        $result = ProductDealer::where('id', $id)->where('product_id', $pid)->update(['special_funit' => $value]);
        if($result) return $value;
    }

    public function updateUnit(Request $request)
    {
        $type = $request->get('type');
        $values = $this->processRequestValuesToArray($request);

        if($type == 'wholesale'){
            try{
                $success = $this->updateWholesaleUnit($values);
            }catch(Exception $e){
                throw new CustomException($e);
            }

            return $success;
        }
        else if($type == 'product_dealers'){
            try{
                $success = $this->updateProductDealerUnit($values);
            }catch(Exception $e){
                throw new CustomException($e);
            }

            return $success;
        }
    }

    private function updateWholesaleUnit($fields)
    {
        $id = $fields['id'];
        $pid =  $fields['product_id'];
		$value =  $fields['updated_value'];
        $result = Wholesale::where('id', $id)->where('product_id', $pid)->update(['unit' => $value]);
		$resultarr['value'] = $value;
		$updatenext = DB::table('wholesale')->where('product_id', $pid)->where('unit','>', $value)->orderBy('unit', 'asc')->first();
		if(isset($updatenext)){
			$result2 = Wholesale::where('id', $updatenext->id)->where('product_id', $pid)->update(['funit' => ($value+1)]);
			$resultarr['nid'] = $updatenext->id;
			$resultarr['nvalue'] = ($value+1);
		} else {
			$resultarr['nid'] = 0;
			$resultarr['nvalue'] = 0;
		}

        if($result) return json_encode($resultarr);
    }

    private function updateProductDealerUnit($fields)
    {
        $id = $fields['id'];
        $pid =  $fields['product_id'];
        $value =  $fields['updated_value'];
        $result = ProductDealer::where('id', $id)->where('product_id', $pid)->update(['special_unit' => $value]);
        if($result) return $value;
    }

    public function updatePrice(Request $request)
    {
        $type = $request->get('type');
        $values = $this->processRequestValuesToArray($request);

        if($type == 'wholesale'){
            try{
                $success = $this->updateWholesalePrice($values);
            }catch(Exception $e){
                throw new CustomException($e);
            }

            return $success;
        }
        else if($type == 'product_dealers'){
            try{
                $success = $this->updateProductDealerPrice($values);
            }catch(Exception $e){
                throw new CustomException($e);
            }

            return $success;
        }

	}

    public function updateDeliveryprice(Request $request)
    {
        $values = $this->processRequestValuesToArray($request);
		try{
			$success = $this->updateDelPrice($values);
		}catch(Exception $e){
			throw new CustomException($e);
		}

		return $success;
	}

    public function updateDeliverycoverage(Request $request)
    {
        $product_id = $request->get('productID');
        $country_id = $request->get('country_id');
        $state_id = $request->get('state_id');
        $city_id = $request->get('city_id');
        $area_id = $request->get('area_id');
		$values = [
            'product_id' => $product_id,
            'country_id' => $country_id,
 			'state_id' => $state_id,
 			'city_id' => $city_id,
 			'area_id' => $area_id
        ];
		try{
			$success = $this->updateDelCoverage($values);
		}catch(Exception $e){
			throw new CustomException($e);
		}

		return $success;
	}

     public function updateSvalue(Request $request)

     {
         $type = $request->get('type');
         $values = $this->processRequestValuesToArray($request);

 		try{
 			$success = $this->updateProductSvalue($values);
 		}catch(Exception $e){
 			throw new CustomException($e);
 		}

 		return $success;
     }

	private function updateWholesalePrice($fields)
	{
		$id = $fields['id'];
		$pid =  $fields['product_id'];
		$value =  $fields['updated_value'];
		$result = Wholesale::where('id', $id)->where('product_id', $pid)->update(['price' => $value]);
		if($result) return number_format($value/100,2);
	}

	private function updateProductDealerPrice($fields)
	{
		$id = $fields['id'];
		$pid =  $fields['product_id'];
		$value =  $fields['updated_value'];
		$result = ProductDealer::where('id', $id)->where('product_id', $pid)->update(['special_price' => $value]);
		if($result) return number_format($value/100,2);
	}

	private function updateProductSvalue($fields)
     {
         $id = $fields['id'];
         $pid =  $fields['product_id'];
         $value =  $fields['updated_value'];
         $result = DB::table('productspec')->where('spec_id', $id)->where('product_id', $pid)->update(['value' => $value]);
         if($result) return $value;
     }

	private function updateDelPrice($fields)
	{
		$id = $fields['id'];
		$pid =  $fields['product_id'];
		$value =  $fields['updated_value'];
		$result = Product::where('id', $pid)->update([$id => $value]);
		if($result) return number_format($value/100,2);
	}

	private function updateDelCoverage($fields)
	{
		$pid =  $fields['product_id'];
		$country =  $fields['country_id'];
		$state =  $fields['state_id'];
		$city =  $fields['city_id'];
		$area =  $fields['area_id'];
		$result = Product::where('id', $pid)->update(['cov_country_id' => $country,'cov_state_id' => $state,'cov_city_id' => $city,'cov_area_id' => $area]);
		if($result) return "OK";
	}

    public function addRow(Request $request)
      {
        $type = $request->get('type');
		$values = $this->processRequestValuesToArray($request);

          if($type == 'wholesale'){
              try{
                  $success = $this->addWholesalePrice($values);
              }catch(Exception $e){
                  throw new CustomException($e);
              }

              return $success;
          }
          else if($type == 'product_dealers'){
              try{
                  $success = $this->addProductDealer($values);
              }catch(Exception $e){
                  throw new CustomException($e);
              }

              return $success;
          }
		  else if($type == 'specification'){
              try{
                  $success = $this->addSpecification($values);
              }catch(Exception $e){
                  throw new CustomException($e);
              }

              return $success;
		  }
      }

    public function removehyperprice(Request $request)
	{
		$owarehouse_id = $request->get('owarehouse_id');
		$hyper_id = $request->get('hyper_id');
		DB::table('owarehouse')->where('id',$owarehouse_id)->delete();
		DB::table('product')->where('id',$hyper_id)->delete();
		DB::table('nproductid')->where('product_id',$hyper_id)->delete();
		return json_encode("OK");
		
	}		  
	  
    public function addhyperprice(Request $request)
	{
        if (!Auth::check()) {
            $message=ErrorMessagesController::loginError();
			return response()->json($message);
        }
        if ($request->get('moq')< $request->get('moqcaf')) {
            return response()->json(['status'=>'failure','short_message'=>'Bad Quantity','long_message'=>'The MOQ per pax must be less than MOQ']);
        }
		$moq = $request->get('moq');
		$moqcaf = $request->get('moqcaf');
		$global_system_vars = GlobalT::orderBy('id', 'desc')->first();
		$duration = $global_system_vars->hyper_duration;
		$hyperprice = $request->get('hyperprice');
		$hqty = $request->get('hqty');
		//$deliveryqty = $request->get('deliveryqty');
		$states_hyper = $request->get('states_hyper');
		$cities_hyper = $request->get('cities_hyper');
		$areas_hyper = $request->get('areas_hyper');
		$del_width_hyper = $request->get('del_width_hyper');
		$del_height_hyper = $request->get('del_height_hyper');
		$del_lenght_hyper = $request->get('del_lenght_hyper');
		$del_weight_hyper = $request->get('del_weight_hyper');
		$states_biz_hyper = $request->get('states_biz_hyper');
		$cities_biz_hyper = $request->get('cities_biz_hyper');
		$areas_biz_hyper = $request->get('areas_biz_hyper');
		$del_pricing_hyper = $request->get('del_pricing_hyper');
		$del_option_hyper = $request->get('del_option_hyper');
		$hyper_terms = $request->get('hyper_terms');
		$del_world_v_hyper = $request->get('del_world_v_hyper');
		$del_malaysia_v_hyper = $request->get('del_malaysia_v_hyper');
		$del_sabah_v_hyper = $request->get('del_sabah_v_hyper');
		$free_delivery = $request->get('free_delivery');
		$free_delivery_with_purchase_qty = $request->get('free_delivery_with_purchase_qty');
		$del_sarawak_v_hyper = $request->get('del_sarawak_v_hyper');
		
		$rfree_delivery = 0;
		$rfree_delivery_with_purchase_qty = 0;
		if($free_delivery == 1){
			$rfree_delivery = $free_delivery;
		}
		if($free_delivery_with_purchase_qty == 1){
			$rfree_delivery_with_purchase_qty = $free_delivery_with_purchase_qty;
		}
		if($hyperprice == ''){
			$hyperprice = 0;
		}
		$parent_id = $request->get('parent_id');
		//dd($rfree_delivery);
		$retail = Product::find($parent_id);
		$merchant_id = DB::table('merchantproduct')->where('product_id',$retail->id)->pluck('merchant_id');
		$hyper = $retail->replicate();
		$hyper->save();
		$return_id = $hyper->id;

		DB::table('product')->where('id',$return_id)
							->update(
								[
									'parent_id' => $parent_id,
									'segment' => 'hyper',
									'available' => $hqty,
									'del_sarawak' => $del_sarawak_v_hyper,
									'del_sabah_labuan' => $del_sabah_v_hyper,
									'del_west_malaysia' => $del_malaysia_v_hyper,
									'del_worldwide' => $del_world_v_hyper,
									'cov_state_id' => $states_hyper,
									'cov_city_id' => $cities_hyper,
									'cov_area_id' => $areas_hyper,
									'cov_area_id' => $areas_hyper,
									'free_delivery' => $rfree_delivery,
									'free_delivery_with_purchase_qty' => $rfree_delivery_with_purchase_qty,
									'b2b_cov_city_id' => $cities_biz_hyper,
									'b2b_cov_area_id' => $areas_biz_hyper,
									'owarehouse_moq' => $moq,
									'owarehouse_moqperpax' => $moqcaf,
									'return_policy' => $hyper_terms,
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
        return response()->json();
		return $return_id;

	}

	public function updatehyperprice(Request $request)
	{
		$moq = $request->get('moq');
		$moqcaf = $request->get('moqcaf');
		$global_system_vars = GlobalT::orderBy('id', 'desc')->first();
		$duration = $global_system_vars->hyper_duration;
		$hyperprice = $request->get('hyperprice');
        $hyper_terms=$request->get('hyper_terms');
		if($hyperprice == ''){
			$hyperprice = 0;
		}
		$hyper_id = $request->get('hyper_id');
		$owarehouse_id = $request->get('owarehouse_id');
		$parent_id = $request->get('parent_id');
		//$deliveryqty = $request->get('deliveryqty');
		$states_hyper = $request->get('states_hyper');
		$cities_hyper = $request->get('cities_hyper');
		$areas_hyper = $request->get('areas_hyper');
		$del_width_hyper = $request->get('del_width_hyper');
		$del_height_hyper = $request->get('del_height_hyper');
		$del_lenght_hyper = $request->get('del_lenght_hyper');
		$del_weight_hyper = $request->get('del_weight_hyper');
		$states_biz_hyper = $request->get('states_biz_hyper');
		$cities_biz_hyper = $request->get('cities_biz_hyper');
		$areas_biz_hyper = $request->get('areas_biz_hyper');
		$del_pricing_hyper = $request->get('del_pricing_hyper');
		$del_option_hyper = $request->get('del_option_hyper');
		$hyper_terms = $request->get('hyper_terms');
		$del_world_v_hyper = $request->get('del_world_v_hyper');
		$del_malaysia_v_hyper = $request->get('del_malaysia_v_hyper');
		$del_sabah_v_hyper = $request->get('del_sabah_v_hyper');
		$del_sarawak_v_hyper = $request->get('del_sarawak_v_hyper');
		$hqty = $request->get('hqty');
		$free_delivery = $request->get('free_delivery');
		$free_delivery_with_purchase_qty = $request->get('free_delivery_with_purchase_qty');
		
		$rfree_delivery = 0;
		$rfree_delivery_with_purchase_qty = 0;
		if($free_delivery == 1){
			$rfree_delivery = $free_delivery;
		}
		if($free_delivery_with_purchase_qty == 1){
			$rfree_delivery_with_purchase_qty = $free_delivery_with_purchase_qty;
		}
		if($hyperprice == ''){
			$hyperprice = 0;
		}
		
		DB::table('product')->where('id',$hyper_id)
							->update(
								[
									'available' => $hqty,
									'owarehouse_moq' => $moq,
									'owarehouse_moqperpax' => $moqcaf,
									'return_policy' => $hyper_terms,
									'del_sarawak' => $del_sarawak_v_hyper,
									'free_delivery' => $rfree_delivery,
									'free_delivery_with_purchase_qty' => $rfree_delivery_with_purchase_qty,
									'del_sabah_labuan' => $del_sabah_v_hyper,
									'del_west_malaysia' => $del_malaysia_v_hyper,
									'del_worldwide' => $del_world_v_hyper,
									'cov_state_id' => $states_hyper,
									'cov_city_id' => $cities_hyper,
									'cov_area_id' => $areas_hyper,
									'b2b_cov_state_id' => $states_biz_hyper,
									'b2b_cov_city_id' => $cities_biz_hyper,
									'b2b_cov_area_id' => $areas_biz_hyper,
									'del_pricing' => $del_pricing_hyper,
									'del_weight' => $del_weight_hyper,
									'del_height' => $del_height_hyper,
									'del_lenght' => $del_lenght_hyper,
									'del_width' => $del_width_hyper,
									'del_option' => $del_option_hyper,									
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


		return $hyper_id;

	}


 	private function addWholesalePrice($fields)
      {
 		$pid =  $fields['product_id'];
		$last_price = DB::table('wholesale')->where('product_id', $pid)->orderBy('unit', 'desc')->first();
		if(isset($last_price)){
			$last_price_val = $last_price->unit;
			$minprice = $last_price_val+1;
			$maxprice = $minprice+1;
			$price = $last_price->price;
		} else {
			$minprice = 1;
			$maxprice = 2;
			$price = 0;
		}
		$returnarr['funit'] = $minprice;
		$returnarr['unit'] = $maxprice;
		$returnarr['price'] = number_format($price/100,2);
  		$result = DB::table('wholesale')->insertGetId(['autolink_id' =>  1, 'product_id' => $pid, 'funit' => $minprice, 'unit' => $maxprice, 'price' => $price,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		$returnarr['pid'] = $result;
          if($result) return json_encode($returnarr);
      }

    private function addProductDealer($fields)
      {
          $pid =  $fields['product_id'];
          $did =  $fields['dealer_id'];
          $result = DB::table('productdealer')->insertGetId(['product_id' => $pid, 'dealer_id' => $did,'special_funit' => 0,'special_unit' => 0, 'special_price' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
          if($result) return $result;
      }

    private function addSpecification($fields)
      {
          $pid =  $fields['product_id'];
          $sid =  $fields['specification_id'];
          $result = DB::table('productspec')->insertGetId(['product_id' => $pid, 'spec_id' => $sid,'value' => 'Change value','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
          if($result) return $result;
      }

    private function processRequestValuesToArray($request)
    {
        $id = $request->get('id');
        $product_id = $request->get('productID');
		$updated_value = $request->get('updatedValue');
 		$dealer_id = $request->get('dealerID');
 		$specification_id = $request->get('specificationID');

        return [
            'id' => $id,
            'product_id' => $product_id,
            'updated_value' => $updated_value,
 			'dealer_id' => $dealer_id,
 			'specification_id' => $specification_id
        ];
    }

    public function deleteProductDealer(Request $request)
    {
        $id = $request->get('id');

		try{
			$success = DB::table('productdealer')->where('id',$id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
		}catch(Exception $e){
			throw new CustomException($e);
		}

        return $success;
    }

    public function deleteWholesale(Request $request)
    {
        $id = $request->get('id');

		try{
			$currentwholesale = DB::table('wholesale')->where('id',$id)->first();
			$success = DB::table('wholesale')->where('id',$id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
			$updatenext = DB::table('wholesale')->where('product_id', $currentwholesale->product_id)->where('unit','>', $currentwholesale->unit)->orderBy('unit', 'asc')->first();
			if(isset($updatenext)){
				$result2 = Wholesale::where('id', $updatenext->id)->update(['funit' => $currentwholesale->funit]);
				$resultarr['nid'] = $updatenext->id;
				$resultarr['nvalue'] = $currentwholesale->funit;
			} else {
				$resultarr['nid'] = 0;
				$resultarr['nvalue'] = 0;
			}
		}catch(Exception $e){
			throw new CustomException($e);
		}

        return json_encode($resultarr);
    }

    public function fetchField(Request $request)
    {
        $id = $request->get('id');
        $val = $request->get('pre');
        $curr = DB::table('currency')->where('active', 1)->first()->code;
        return view('fetchField')->with('id', $id)->with('val', $val)->with('curr', strtoupper($curr));
    }

    public function fetchFieldsForSpecialPrice(Request $request)
    {
        $id = $request->get('id');
        $val = $request->get('val');
        $lastid = $request->get('lastid');
        $curr = DB::table('currency')->where('active', 1)->first()->code;
		$merchant_iidd = DB::table('merchant')->where('user_id',Auth::id())->first()->id;
		$dealers = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('autolink','users.id','=','autolink.initiator')->where('autolink.responder',$merchant_iidd)->where('autolink.status','linked')->get();		
        return view('fetchFieldsForSpecialPrice')->with('id', $id)->with('lastid', $lastid)->with('val', $val)->with('dealers', $dealers)->with('curr', strtoupper($curr));
    }
	
    public function fetchFieldsForSpecialPricen(Request $request)
    {
        $id = $request->get('id');
        $curr = DB::table('currency')->where('active', 1)->first()->code;
		$merchant_iidd = DB::table('merchant')->where('user_id',Auth::id())->first()->id;
		$dealers = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('autolink','users.id','=','autolink.initiator')->where('autolink.responder',$merchant_iidd)->where('autolink.status','linked')->whereNotExists(function($query)
            {
                $query->select(DB::raw(1))
                      ->from('productdealer')
                      ->whereRaw('productdealer.dealer_id = users.id');
            })->get();	
        return view('fetchFieldsForSpecialPricen')->with('id', $id)->with('dealers', $dealers)->with('curr', strtoupper($curr));
    }	    
	
	public function deletepdealer(Request $request)
    {
        $id = $request->get('id');
        $pid = $request->get('pid');
		DB::table('productdealer')->where('dealer_id',$id)->where('product_id',$id)->delete();
		return "OK";
    }	
	
	
	public function routegetdealers(Request $request)
    {
        $pid = $request->get('pid');
        $userid = $request->get('userid');
		
		$merchant_iidd = DB::table('merchant')->where('user_id',$userid)->first()->id;
		if($pid == 0){
			$dealers = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('autolink','users.id','=','autolink.initiator')->where('autolink.responder',$merchant_iidd)->where('autolink.status','linked')->get();
		} else {
			$dealers = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('autolink','users.id','=','autolink.initiator')->where('autolink.responder',$merchant_iidd)->where('autolink.status','linked')->whereNotExists(function($query) use ($pid)
            {
                $query->select(DB::raw(1))
                      ->from('productdealer')
                      ->whereRaw('productdealer.dealer_id = users.id AND productdealer.product_id = ' . $pid);
            })->get();				
		}
		foreach($dealers as $dealer){
			$dealer->nbid = IdController::nB($dealer->id);
		}
		
		return json_encode($dealers);
    }
	
	public function pdsprices($did, $pid)
    {
		$current_product = DB::table('product')->where('id',$pid)->first();
		$prodbrand = DB::table('brand')->where('id',$current_product->brand_id)->first();
		$prodcategory = DB::table('category')->where('id',$current_product->category_id)->first();
		$prodsubcategory = DB::table('subcat_level_' . $current_product->subcat_level)->where('id',$current_product->subcat_id)->first();
		$sprices = DB::table('productdealer')->where('dealer_id',$did)->where('product_id',$pid)->get();
		return view('product._forms.pdsprices')->with('prodbrand',$prodbrand)->with('prodcategory',$prodcategory)->with('prodsubcategory',$prodsubcategory)->with('current_product',$current_product)->with('sprices',$sprices)->with('did',$did)->with('pid',$pid);
    }

    //-----------------------------------------
    	// Created by Zurez
    	//-----------------------------------------
    	
    public function product_exists_name(Request $r,$uid=NULL)
    	{
    		$ret=array();
    		$ret["status"]="failure";
    		if (!Auth::check()) {
    			return "";
    		}
    		$user_id=Auth::user()->id;
    		if (!empty($uid) and Auth::user()->hasRole("adm")) {
    			$user_id=$uid;
    		}
    		$name=$r->name;
    		try{
    			$p=DB::table("product")
    			->join("merchantproduct","merchantproduct.product_id","=","product.parent_id")
    			->join("merchant","merchant.id","=","merchantproduct.merchant_id")
    			->whereNull("product.deleted_at")
    			->whereNull("merchantproduct.deleted_at")
    			->whereNull("merchant.deleted_at")
    			->where("merchant.user_id",$user_id)
    			->where("name",$name)
    			
    	
    			->select("product.name","product.id")
    			->first();
    			if (!empty($p)) {
    				# code...
    				$ret["status"]="success";
    				$ret["name"]=$p->name;
    				$ret["id"]=$p->id;
    			}
    	
    			
    		}
    		catch(\Exception $e){
    			$ret["short_message"]=$e->getMessage();
    			Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    		}
    		return response()->json($ret);
    	}
    		
}

