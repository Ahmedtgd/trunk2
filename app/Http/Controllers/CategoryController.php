<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OshopProduct;
use App\Models\Product;
use App\Models\SubCatLevel1;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App;
use DB;
use Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->subModel = new SubCatLevel1();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isfind = false;//check if all sub category of mai category have no product
        $maindata = [];
        $subdata = [];	
        //Get all product id
        //$sectionProduct=SectionProduct::all();
       /* $sectionProduct=OshopProduct::all();
         $pids=array();
         foreach ($sectionProduct as $sp) {
            # code...
            $products=Product::where('id',$sp->product_id)->first();
            // array_push($category_ids,$products->category_id);
			if(!is_null($products)){
				array_push($pids, $products->id);
			} 
            // array_push($pids, $products->id);
        }
        $pids=array_unique($pids);
		$pidss = implode(',', $pids);*/

        $getAllCategories= Category::with('subCatLevel1')->get();

        foreach($getAllCategories as $cat) {
            foreach ($cat->subCatLevel1 as $subCat){
				$query = DB::select(DB::raw(
					"SELECT COUNT(*) as counter FROM oshopproduct op, product p 
						LEFT JOIN subcat_level_2 ON (p.subcat_id = subcat_level_2.id AND p.subcat_level = 2) 
						LEFT JOIN subcat_level_3 ON (p.subcat_id = subcat_level_3.id AND p.subcat_level = 3) 
						WHERE op.product_id=p.id AND 
						p.oshop_selected=true 
						AND p.retail_price > 0 
						AND p.available > 0
						AND ((p.subcat_id= " . $subCat->id . " AND p.subcat_level = 1) OR (subcat_level_2.subcat_level_1_id = " . $subCat->id . ") OR (subcat_level_3.subcat_level_1_id = " . $subCat->id . "))  LIMIT 1"
				));		
				
                if ($query[0]->counter > 0){

                    $subdata[] = ['id'=>$cat->id,'subid'=>$subCat->id,'subname'=>$subCat->name,'subdescription'=>$subCat->description];
                    $isfind = true;
                }
            }
            if($isfind) {
                $maindata[] = ['id' => $cat->id, 'name' => $cat->name, 'logo_green' => $cat->logo_green, 'description' => $cat->description];
            }
            $isfind = false;
        }
        //return $subdata;
        //dd($subdata);
        return view('categorylist')->with(array(
            'allCategories'=>$maindata,
            'allsubCategories'=>$subdata,
        ));
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
    public function tshow($id, $sid) {
		dump("id:".$id);
		dump("sid:".$sid);

		return "foo bar baz";
	}

    public function show($id, $sid) {
        $merchant=False;
        $user=False;
        $station=False;

		if(Auth::check()){
            $user_id = Auth::user()->id;
            $roles=DB::table('role_users')->
				where('user_id',$user_id)->get();

            foreach ($roles as $r) {
                # code...
                $r= $r->role_id;
                if ($r==3) {
                # Merchant is Yes now.

                $merchant=True;
                $merchant_id=DB::table('merchant')->
					where('user_id',$user_id)->pluck('id');
                }
                if ($r==2) {
                    $user=True;
                }
            }
			$subcategoryvisit=DB::table('subcategoryvisit')->
				where('user_id',$user_id)->
				where('subcategory_id',$sid)->first();

			if(is_null($subcategoryvisit)){
				DB::table('subcategoryvisit')->
					insert(['user_id'=>$user_id,'subcategory_id'=>$sid,
						'subcategory_level'=>1,'counter'=>1]);
			} else {
				DB::table('subcategoryvisit')->
					where('id',$subcategoryvisit->id)->
					update(['counter'=>($subcategoryvisit->counter + 1)]);
			}			
        } 

		$oshoptemplate = DB::table('oshop_template')->
			where('subcat_id',$sid)->first();

		if(is_null($oshoptemplate)){
			/*$sectionProduct=OshopProduct::select('product.id' ,
				'product.name' ,
				'product.brand_id' ,
				'product.parent_id' ,
				'product.category_id' ,
				'product.subcat_id' ,
				'product.subcat_level'  ,
				'product.photo_1' ,
				'product.thumb_photo' ,
				'product.retail_price' ,
				'product.discounted_price',
				'product.updated_at')
					->join('product','oshopproduct.product_id','=',
					'product.id')->get();*/
			$pids=array();

		//	$c = 0;
		//	foreach ($sectionProduct as $sp) {
				# code...
				/*
				$c++;
				echo $c." ";
				flush(); ob_flush();
				*/

				$products=Product::where('subcat_level','1')
					->join('merchantproduct','merchantproduct.product_id','=','product.id')
					->join('merchant','merchantproduct.merchant_id','=','merchant.id')
					->join('oshopproduct','oshopproduct.product_id','=','product.id')
					->join('oshop','oshopproduct.oshop_id','=','oshop.id')->
					where('product.oshop_selected', '=', '1')->
					where('product.segment', '=', 'b2c')->
					where('product.retail_price', '>', '0')->
					where('merchant.status','active')->
					where('product.status','active')->
					where('oshop.status','active')->
					where('product.available','>',0)->
					where('subcat_id',$sid)->get();

				if(!is_null($products)){
					foreach ($products as $sp) {
						array_push($pids, $sp->id);
					}
				} 
				$products=Product::select('product.id' ,
					'product.name' ,
					'product.brand_id' ,
					'product.parent_id' ,
					'product.category_id' ,
					'product.subcat_id' ,
					'product.subcat_level'  ,
					'product.photo_1' ,
					'product.thumb_photo' ,
					'product.retail_price' ,
					'product.discounted_price',
					'product.updated_at')
					->join('merchantproduct','merchantproduct.product_id','=','product.id')
					->join('merchant','merchantproduct.merchant_id','=','merchant.id')
					->join('oshopproduct','oshopproduct.product_id','=','product.id')
					->join('oshop','oshopproduct.oshop_id','=','oshop.id')
					->leftJoin('subcat_level_2', 'product.subcat_id',
						'=', 'subcat_level_2.id')->
					where('product.oshop_selected', '=', '1')->
					where('product.segment', '=', 'b2c')->
					where('product.retail_price', '>', '0')->
					where('merchant.status','active')->
					where('product.status','active')->
					where('oshop.status','active')->
					where('product.available','>',0)
						
						->where('subcat_level','2')
						->where('subcat_level_2.subcat_level_1_id',$sid)
						->get();

				if(!is_null($products)){
					foreach ($products as $sp) {
						array_push($pids, $sp->id);
					}
				}  
				
				$products=Product::select('product.id' ,
						'product.name' ,
						'product.brand_id' ,
						'product.parent_id' ,
						'product.category_id' ,
						'product.subcat_id' ,
						'product.subcat_level'  ,
						'product.photo_1' ,
						'product.thumb_photo' ,
						'product.retail_price' ,
						'product.discounted_price',
						'product.updated_at') 
							->join('merchantproduct','merchantproduct.product_id','=','product.id')
							->join('merchant','merchantproduct.merchant_id','=','merchant.id')
							->join('oshopproduct','oshopproduct.product_id','=','product.id')
							->join('oshop','oshopproduct.oshop_id','=','oshop.id')
							->leftJoin('subcat_level_3', 'product.subcat_id',
							'=', 'subcat_level_3.id')->
							where('product.oshop_selected', '=', '1')->
							where('product.segment', '=', 'b2c')->
							where('product.retail_price', '>', '0')->
							where('merchant.status','active')->
							where('product.status','active')->
							where('oshop.status','active')->
							where('product.available','>',0)
							->where('subcat_level','3')
							->where('subcat_level_3.subcat_level_1_id',$sid)
							->get();

					if(!is_null($products)){
						foreach ($products as $sp) {
							array_push($pids, $sp->id);
						}
					} 		 
			$pids=array_unique($pids);

			$catDetails = Category::where('id', $id)->
				with(['products' => function($query) use($sid,$pids) {
				$query->select('product.id' ,
					'product.name' ,
					'product.brand_id' ,
					'product.parent_id' ,
					'product.category_id' ,
					'product.subcat_id' ,
					'product.subcat_level'  ,
					'product.photo_1' ,
					'product.thumb_photo' ,
					'product.retail_price' ,
					'product.discounted_price',
					'product.updated_at')  
					->join('merchantproduct','product.id','=',
						'merchantproduct.product_id')
					->join('merchant','merchantproduct.merchant_id','=',
						'merchant.id')
					->where('merchant.status', '=', 'active')
					->where('product.oshop_selected', '=', true)
					->where('product.retail_price','>','0')
					->where('product.available','>','0')
					->where('product.segment','=','b2c')
					->whereIn('product.id',$pids)
					->orderBy('product.retail_price', 'asc');
				}])->first();

		   /*
			$catDetails = \App\Category::where('id', $id)->
				with('product')->first();
			 */

			$subCatDesc = SubCatLevel1::find($sid)->description;

			return view('detail', ['subCatDesc'=>$subCatDesc])
				->with('catDetails', $catDetails)
				->with('subcat_id', $sid)
				->with('type','subcategory')
				->with('user',$user);

		} else {
			$customcontroller = $oshoptemplate->controller;
			$customproductreg = $oshoptemplate->init_category;

			return App::make('App\Http\Controllers\\'.$customcontroller)->
				$customproductreg();
		}
    }

    public function category_sort(Request $request)
    {
        $merchant=False;
        $user=False;
        $station=False;
        $r = $request->all();
		$sort = 1;
		if(isset($r['sort'])){
			$sort = $r['sort'];
		}
        $id = $r['category_id'];
        $sid = $r['subcat_id'];		
       if(Auth::check()){

            $user_id = Auth::user()->id;
            $roles=DB::table('role_users')->where('user_id',$user_id)->get();
            foreach ($roles as $r) {
                # code...
                $r= $r->role_id;
                if ($r==3) {
                # Merchant is Yes now.

                $merchant=True;
                $merchant_id=DB::table('merchant')->where('user_id',$user_id)->pluck('id');
                }
                if ($r==2) {
                    $user=True;
                }
            }
			$subcategoryvisit=DB::table('subcategoryvisit')->where('user_id',$user_id)->where('subcategory_id',$sid)->first();
			if(is_null($subcategoryvisit)){
				DB::table('subcategoryvisit')->insert(['user_id'=>$user_id,'subcategory_id'=>$sid,'subcategory_level'=>1,'counter'=>1]);
			} else {
				DB::table('subcategoryvisit')->where('id',$subcategoryvisit->id)->update(['counter'=>($subcategoryvisit->counter + 1)]);
			}			

        } 
        //$sectionProduct=SectionProduct::all();
		$oshoptemplate = DB::table('oshop_template')->where('subcat_id',$sid)->first();
		if(is_null($oshoptemplate)){
			$sectionProduct=OshopProduct::select('product.id' ,
				  'product.name' ,
				  'product.brand_id' ,
				  'product.parent_id' ,
				  'product.category_id' ,
				  'product.subcat_id' ,
				  'product.subcat_level'  ,
				  'product.segment' ,
				  'product.photo_1' ,
				  'product.thumb_photo' ,
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
				  'product.updated_at')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')
				  ->join('product','oshopproduct.product_id','=','product.id')->where('merchant.status', '=', 'active')->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')->get();
			$pids=array();
			foreach ($sectionProduct as $sp) {
				# code...

				$products=Product::where('subcat_level','1')->where('subcat_id',$sid)->where('id',$sp->id)->first();
				// array_push($category_ids,$products->category_id);
				if(!is_null($products)){
					array_push($pids, $products->id);
				} else {
					$products=Product::select('product.id' ,
				  'product.name' ,
				  'product.brand_id' ,
				  'product.parent_id' ,
				  'product.category_id' ,
				  'product.subcat_id' ,
				  'product.subcat_level'  ,
				  'product.segment' ,
				  'product.photo_1' ,
				  'product.thumb_photo' ,
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
				  'product.updated_at')->leftJoin('subcat_level_2', 'product.subcat_id', '=', 'subcat_level_2.id')->where('subcat_level','2')->where('subcat_level_2.subcat_level_1_id',$sid)->where('product.id',$sp->id)->first();
			
					if(!is_null($products)){					
						array_push($pids, $products->id);
					} else {
						$products=Product::select('product.id' ,
				  'product.name' ,
				  'product.brand_id' ,
				  'product.parent_id' ,
				  'product.category_id' ,
				  'product.subcat_id' ,
				  'product.subcat_level'  ,
				  'product.segment' ,
				  'product.photo_1' ,
				  'product.thumb_photo' ,
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
				  'product.updated_at')->leftJoin('subcat_level_3', 'product.subcat_id', '=', 'subcat_level_3.id')->where('subcat_level','3')->where('subcat_level_3.subcat_level_1_id',$sid)->where('product.id',$sp->id)->first();
						if(!is_null($products)){
							array_push($pids, $products->id);
						}
					}		 
				}
				// array_push($pids, $products->id);
			}
		//	dd($pids);
			$pids=array_unique($pids);
			//
			$catDetails = Category::where('id', $id)->
			with(['products' => function($query) use($sid,$pids) {
					$query
					->select('product.id' ,
				  'product.name' ,
				  'product.brand_id' ,
				  'product.parent_id' ,
				  'product.category_id' ,
				  'product.subcat_id' ,
				  'product.subcat_level'  ,
				  'product.segment' ,
				  'product.photo_1' ,
				  'product.thumb_photo' ,
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
					->join('merchantproduct','product.id','=','merchantproduct.product_id')
					->join('merchant','merchantproduct.merchant_id','=','merchant.id')
					->where('merchant.status', '=', 'active')->where('product.oshop_selected', '=', true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->whereIn('product.id',$pids)->orderBy('product.retail_price', 'asc');
				}])->first();
		   /*
			$catDetails = \App\Category::where('id', $id)->
				with('product')->first();
			 */

			$subCatDesc = SubCatLevel1::find($sid)->description;

		   return view('categorysort', ['subCatDesc'=>$subCatDesc])
			   ->with('catDetails', $catDetails)
			   ->with('subcat_id', $sid)
			   ->with('type','subcategory')
			   ->with('user',$user);
		} else {
			$customcontroller = $oshoptemplate->controller;
			$customproductreg = $oshoptemplate->init_category;
			return App::make('App\Http\Controllers\\'.$customcontroller)->$customproductreg();
		}

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

    public function get_subcategories($id)
    {
        if(!is_numeric($id))
        {
            $res['success'] = false;
            $res['message'] = 'Something went worng';
            return $res;
        }
		$data = $this->subModel->getSubsOfCurrentCat($id);

        $res['data'] = $data;
        $res['success'] = true;
        $res['message'] = 'Fetched Successfully';

        return Response::json(array(
                $res
            ));
    }
}
