<?php

namespace App\Http\Controllers;
use App;
use App\Models\Address;
use App\Models\Merchant;
use App\Models\MerchantCategory;
use App\Models\OpenWish;
use App\Models\OrderProduct;
use App\Models\POrder;
use App\Models\Product;
use App\Models\Album;
use App\Models\Signboard;
use App\Models\Bunting;
use App\Models\Theme;
use App\Models\Profile;
use App\Models\VBanner;
use App\Models\Voucher;
use App\Models\Autolink;
use App\Models\ProductDealer;
use App\Models\Category;
use App\Models\SubCatLevel1;
use App\Models\SubCatLevel2;
use App\Models\SubCatLevel3;
use App\Models\SubCatLevel4;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;
use URL;
use Illuminate\Support\Facades\Session;

class OshopController extends Controller
{
    /**
     * Get the o shops list
     * @return $this
     */
    public function index()
    {
        // $merchants = Merchant::orderBy('oshop_name', 'ASC')->get();

    // page view counter--- chonchol

        $details = json_decode(file_get_contents("http://ipinfo.io/"));
        $country_name = $details->country;
        if ($country_name == "MY" || $country_name == "HK") {
            $query=DB::SELECT("INSERT INTO view_count (oshop_view_count,created_at) VALUES (1,now())");
        }


        $merchants=Merchant::all();
        try {
            $test=$merchants[0];
        } catch (\Exception $e) {
            return "No merchant record";
        }
        // Check if there is a product
        $counter=0;
        foreach ($merchants as $r) {

            $mid=$r->id;

            //$oshopsection=DB::table("oshopsection")->where('merchant_id',$mid)->get();

            //oshopsection is an array. check if array is not empty
            //if (empty($oshopsection)) {

            //    unset($merchants[$counter]); // ? not working
            //}
            //else{
                //foreach ($oshopsection as $k) {

                    # check if the product is confirmed
                    //$product=DB::table('sectionproduct')->where('section_id',$k->section_id)->first();
                    $product=DB::table('oshopproduct')->where('merchant_id',$mid)->first();
                    try {
                        $a=Product::where('id',$product->product_id)->get();
                        // return $a;
                        $a[0];
                    } catch (\Exception $e) {
                        unset($merchants[$counter]);
                    }

                //}
            //}

            $counter++;
        }

        $firstLetter = '';
        $firstRun = true;

        $letters['AD'] = array('A','B','C','D');
        $letters['EH'] = array('E','F','G','H');
        $letters['IL'] = array('I','J','K','L');
        $letters['MP'] = array('M','N','O','P');
        $letters['QT'] = array('Q','R','S','T');
        $letters['UX'] = array('U','V','W','X');
        $letters['YZ'] = array('Y','Z');

        return view('shops.oshoplist')
            ->with('merchants', $merchants)
            ->with('firstLetter', $firstLetter)
            ->with('firstRun', $firstRun)
            ->with('letters', $letters);
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function oShopOne(Request $request, $url)
     {
		//$oshop_id = $id;
		$id = 0;
		$subid = null;
		$oshop = DB::table('oshop')->where('url',$url)->first();
		
	   if(is_null($oshop)){
		   return view('error');
	   } else {
		   $oshop_id = $oshop->id;
		   
		   $merchanto = DB::table('merchantoshop')->where('oshop_id',$oshop->id)->first();
		  // dd($merchanto);
		   if(is_null($merchanto)){
			   return view('error');
		   } else {
			   $id = $merchanto->merchant_id;
		   }
	   }
       // Variables
        $subcategoriesp_hyper=array();
       if(Auth::check()){
            $user_id = Auth::user()->id;
			$merchantvisit=DB::table('merchantvisit')->where('user_id',$user_id)->where('merchant_id',$id)->first();
			if(is_null($merchantvisit)){
				DB::table('merchantvisit')->insert(['user_id'=>$user_id,'merchant_id'=>$id,'counter'=>1]);
			} else {
				DB::table('merchantvisit')->where('id',$merchantvisit->id)->update(['counter'=>($merchantvisit->counter + 1)]);
			}
        } 		 
        $merchant_user_id= Merchant::where('id',$id)->pluck('user_id');
        $checkmerchant= Merchant::where('id',$id)->first();
		//dd($checkmerchant);
		if(is_null($checkmerchant)){
			 return view('error');
		} else {
			if($checkmerchant->status != 'active'){
				return view('error');
			}
		}
		$oshop_name = $checkmerchant->oshop_name;
		$oshoptemplate = DB::table('oshop_template')->where('merchant_id',$id)->first();
		if(!is_null($oshoptemplate)){
			$customcontroller = $oshoptemplate->controller;
			$customoshop = $oshoptemplate->init_oshop;
			return App::make('App\Http\Controllers\\'.$customcontroller)->$customoshop();
		} else {
        // Get Album ID
        try{
            $album = DB::table('album')->where('merchant_id',$id)->first();
            $album_id= $album->id;
        }catch(\Exception $e){
            $album_id=false;
        }
        //Get Profile ID
        try {
            $profile = DB::table('profile')->where('album_id',$album_id)->first();
            $profile_id=$profile->id;
        } catch (\Exception $e) {
            $profile_id=false;
        }
        //Get theme
        if ($profile_id!=false) {
            # code...
               try {
                    $theme= DB::table('theme')->where('profile_id',$profile_id)->firstorFail();
                    } catch (\Exception $e) {
                        $theme= null;
                    }
        }
		$signboard=DB::table('signboard')->where('oshop_id',$oshop_id)->where('active',true)->orderBy('created_at', 'desc')->first();
        if ($album_id!=false) {
            //Signboard
			
          /*  try {
                $signboard=DB::table('signboard')->where('album_id',$album_id)->where('active',true)->orderBy('created_at', 'desc')->first();
				//dd($signboard);
            } catch (\Exception $e) {
                $signboard=null;
            }*/
            //Bunting
            try {
                $bunting= DB::table('bunting')->where('album_id',$album_id)->first();
            } catch (\Exception $e) {
                $bunting=null;
            }
            //Vbanner
            try {
                $vbanner=DB::table('vbanner')->where('album_id',$album_id)->first();
            } catch (\Exception $e) {
                $vbanner=null;
            }
        }
        //Lazy loading
        /*
            ->where('product.available','>',0)
                ->where('product.status','active')
                ->where('product.retail_price','>',0)
        */ 
        $merchant = Merchant::with('categories')->find($id);
        $categories = $merchant->categories;

        $categories = DB::select(DB::raw(
            "SELECT DISTINCT(category.id) as id, category.name,
				category.description, COUNT(product.id) as nprod
            FROM category
            JOIN product ON product.category_id = category.id
            JOIN oshopproduct ON oshopproduct.product_id = product.id
            WHERE 
				oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0  AND product.available > 0 AND product.oshop_selected = 1 AND product.status ='active' AND product.segment = 'b2c' AND product.deleted_at IS NULL
            GROUP BY category.id
            ORDER BY nprod DESC"
        ));
        $count_products = DB::select(DB::raw(
            "select count(p.id) as counter from oshopproduct op,
				product p where op.product_id=p.id and
				op.oshop_id= " . $oshop_id . " and p.oshop_selected=true and p.retail_price > 0 AND p.available > 0 AND p.status ='active' AND p.segment = 'b2c' AND p.deleted_at IS NULL"
        )); 
		$categoriesp = array();
		$subcategoriesp = array();
        $count_categoriesp = array();
        $count_subcategoriesp = array();
		$p = 0;
        $sp = 0;
        $products = array();

		foreach($categories as $c){
			$subcategories = DB::select(DB::raw(
				"SELECT id, COUNT(nprod) as nprod, name, description FROM 
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name,
				subcat_level_1.description as description, product.id as nprod
				FROM subcat_level_1
				JOIN product ON product.subcat_id = subcat_level_1.id AND product.subcat_level = 1
				JOIN oshopproduct ON oshopproduct.product_id = product.id
				WHERE oshopproduct.oshop_id = " . $oshop_id .
					" AND subcat_level_1.category_id = " . $c->id . "
					AND product.oshop_selected = true
					AND product.retail_price > 0
					AND product.available > 0
					AND product.status ='active' AND product.segment = 'b2c'
					AND product.deleted_at IS NULL					
					UNION				
					SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name,
					subcat_level_1.description as description, product.id as nprod
					FROM subcat_level_1
					JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
					JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
					JOIN oshopproduct ON oshopproduct.product_id = product.id
					WHERE oshopproduct.oshop_id = " . $oshop_id .
					" AND subcat_level_1.category_id = " . $c->id . "
					AND product.oshop_selected = true
					AND product.retail_price > 0
					AND product.available > 0
					AND product.status ='active' AND product.segment = 'b2c'
					AND product.deleted_at IS NULL
					GROUP BY id				
										
					UNION				
					SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name,
					subcat_level_1.description as description, product.id as nprod
					FROM subcat_level_1
					JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
					JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
					JOIN oshopproduct ON oshopproduct.product_id = product.id
					WHERE oshopproduct.oshop_id = " . $oshop_id .
					" AND subcat_level_1.category_id = " . $c->id . "
					AND product.oshop_selected = true
					AND product.retail_price > 0
					AND product.available > 0	
					AND product.status ='active' AND product.segment = 'b2c'
					AND product.deleted_at IS NULL
					GROUP BY id
					) as T
					GROUP BY id
					ORDER BY nprod DESC"
			));

            $count_categories = DB::select(DB::raw(
                "SELECT COUNT(*) as counter
                FROM oshopproduct op, product p
                WHERE op.product_id=p.id
                AND p.oshop_selected=true
				AND p.retail_price > 0
				AND p.available > 0
				AND p.status = 'active'
				AND p.deleted_at IS NULL
                AND p.category_id= " . $c->id . "
                AND op.oshop_id = " . $oshop_id .  ";"
            ));

            $count_categoriesp[$p] = $count_categories[0]->counter;

            foreach($subcategories as $sub){
                $count_subcategories = DB::select(DB::raw(
                    "SELECT COUNT(*) as counter FROM oshopproduct op, product p 
					LEFT JOIN subcat_level_2 ON (p.subcat_id = subcat_level_2.id AND p.subcat_level = 2) 
					LEFT JOIN subcat_level_3 ON (p.subcat_id = subcat_level_3.id AND p.subcat_level = 3) 
					WHERE op.product_id=p.id AND 
					p.oshop_selected=true 
					AND p.retail_price > 0 
					AND p.deleted_at IS NULL
					AND p.available > 0 AND p.status ='active' AND p.segment = 'b2c' AND p.category_id= " . $c->id . " 
					AND ((p.subcat_id= " . $sub->id . " AND p.subcat_level = 1) OR (subcat_level_2.subcat_level_1_id = " . $sub->id . ") OR (subcat_level_3.subcat_level_1_id = " . $sub->id . ")) 
					AND op.oshop_id = " . $oshop_id
                ));
                $count_subcategoriesp[$sp] = $count_subcategories[0]->counter;
                $sp++;
            }

			$subcategoriesp[$p] = $subcategories;


			if(!is_null($subid)){
                $product_idsForaSection = DB::select(DB::raw(
					"select p.* from merchantproduct op, product p, merchant m
						where op.product_id=p.id and op.merchant_id=m.id
						and p.oshop_selected=true and p.retail_price > 0 AND p.deleted_at IS NULL AND p.available > 0 AND p.status ='active' AND p.segment = 'b2c'
						ORDER BY p.brand_id;"));

			} else {
                $product_idsForaSection = DB::select(DB::raw(
					"select p.* from merchantproduct mp, oshopproduct op, product p, merchant m
						where op.product_id=p.id and mp.product_id=p.id and mp.merchant_id=m.id and
						p.oshop_selected=true and
						p.retail_price > 0 and
						p.available > 0 and
						p.deleted_at IS NULL and
						p.status ='active' and p.segment = 'b2c' and
						p.category_id =" .$c->id ." and
						op.oshop_id = " . $oshop_id .  " ORDER BY p.brand_id;"));
			}
			$products = array();
			foreach ($product_idsForaSection as $product_id) {
				$product=Product::find($product_id->id);
				array_push($products, $product);
			}
			$categoriesp[$p] = $products;
			$p++;
		}
		
        $colors = DB::select(DB::raw(
            "SELECT DISTINCT(color.id) as id, color.description,
			 color.rgb, color.hex, COUNT(product.id) as nprod
            FROM color
            JOIN productcolor ON productcolor.color_id = color.id
            JOIN product ON productcolor.product_id = product.id
            JOIN oshopproduct ON oshopproduct.product_id = product.id
            WHERE 
				oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.status = 'active' AND product.segment = 'b2c' 
            GROUP BY color.id
			ORDER BY nprod DESC"
        ));			
		
        $brands = DB::select(DB::raw(
            "SELECT DISTINCT(brand.id) as id, brand.name, COUNT(product.id) as nprod
            FROM brand
            JOIN product ON product.brand_id = brand.id
            JOIN oshopproduct ON oshopproduct.product_id = product.id
            WHERE 
				oshopproduct.oshop_id = " . $oshop_id .  " AND
				product.retail_price > 0  AND 
				product.available > 0 AND 
				product.deleted_at IS NULL AND
				product.status = 'active' AND
				product.oshop_selected = 1 AND
				product.segment = 'b2c'
            GROUP BY brand.id
			ORDER BY brand.name ASC"
        ));	

        $subcatlevels = DB::select(DB::raw(
            "SELECT id, name, nprod FROM (
SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
            FROM subcat_level_2
            JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
            JOIN oshopproduct ON oshopproduct.product_id = product.id
            WHERE 
				oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.status ='active' AND product.segment = 'b2c'
			GROUP BY id
UNION
SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
            FROM subcat_level_2
            JOIN subcat_level_3 ON subcat_level_3.subcat_level_2_id = subcat_level_2.id
            JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
            JOIN oshopproduct ON oshopproduct.product_id = product.id
            WHERE 
				oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.status ='active' AND product.segment = 'b2c'
			GROUP BY id	
) as T
			GROUP BY id
			ORDER BY name ASC"
        ));		
		$subcatleves3 = null;
		if(!is_null($subcatlevels)){
			foreach($subcatlevels as $subcatleveldef){
				$subcatleves3[$subcatleveldef->id] = DB::select(DB::raw(
					"SELECT DISTINCT(subcat_level_3.id) as id, subcat_level_3.description as name, COUNT(product.id) as nprod
					FROM subcat_level_3
					JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
					JOIN oshopproduct ON oshopproduct.product_id = product.id
					WHERE 
						oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.status ='active' AND product.segment = 'b2c'
						AND subcat_level_3.subcat_level_2_id = " . $subcatleveldef->id . "
					GROUP BY subcat_level_3.id
					ORDER BY name ASC"
				));					
			}
		}
		
    $voucher_data=[];
         $merchantvouchers= DB::table('merchantvoucher')->where('merchant_id', $id)->get();
         if (!empty($merchantvouchers)){
             foreach ($merchantvouchers as $v){
                 $vouchers = Voucher::where('id','=',$v->voucher_id)->orderBy('created_at', 'desc')->get();
                // $voucher_data = [];
                 foreach ($vouchers as $i) {
                     
                     //$temp['voucher_timeslot']=$i->timeSlots;
                     $product_id = $i->product_id;
                     $product = DB::table('product')->where('product.id', '=', $product_id)->first();
                     if (!is_null($product)) {
                         # code...
                    $temp['voucher'] = $i;
                     $temp['voucher_product'] = $product;
                     $temp['voucher_timeslot'] = DB::table('timeslot')->select('*')->where('voucher_id', $i->id)->first();
                     $temp['voucher_address'] = $i->address;
                     if($product->segment == 'v1' || $product->segment == 'v2'){
                         if($product->segment == 'v1'){
                             if(!is_null($temp['voucher_timeslot'])){
                                  $voucher_data[] = $temp;
                             }
                         } else {
                             $voucher_data[] = $temp;
                         }   
                     }  
                     }
		 
                 }
             }
         }

		$count_all_voucher_products = count($voucher_data);
		
        $categories_voucher = DB::select(DB::raw(
            "SELECT DISTINCT(category.id) as id, category.name,
				category.description, COUNT(product.id) as nprod
            FROM category
            JOIN product ON product.category_id = category.id
            JOIN voucher ON voucher.product_id = product.id
            JOIN merchantvoucher ON merchantvoucher.voucher_id = voucher.id
            WHERE 
				merchantvoucher.merchant_id = " . $id .  " AND voucher.status = 'active' AND (product.segment = 'v1' OR product.segment = 'v2')
            GROUP BY category.id
            ORDER BY nprod DESC"
        ));		
		
		$categoriesp_voucher = array();
		$subcategoriesp_voucher = array();
        $count_categoriesp_voucher = array();
        $count_subcategoriesp_voucher = array();
		$p_voucher = 0;
        $sp_voucher = 0;
        $products_voucher = array();

		foreach($categories_voucher as $c){
			$subcategories_voucher = DB::select(DB::raw(
				"SELECT id, COUNT(nprod) as nprod, name, description FROM 
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name,
				subcat_level_1.description as description, product.id as nprod
				FROM subcat_level_1
				JOIN product ON product.subcat_id = subcat_level_1.id AND product.subcat_level = 1
				JOIN voucher ON voucher.product_id = product.id
				JOIN merchantvoucher ON merchantvoucher.voucher_id = voucher.id
				WHERE merchantvoucher.merchant_id = " . $id .
					" AND subcat_level_1.category_id = " . $c->id . " AND
					voucher.status = 'active'				
					UNION				
					SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
									JOIN voucher ON voucher.product_id = product.id
									JOIN merchantvoucher ON merchantvoucher.voucher_id = voucher.id
									WHERE merchantvoucher.merchant_id = " . $id .
										" AND subcat_level_1.category_id = " . $c->id . " AND
										voucher.status = 'active'
						GROUP BY id				
										
					UNION				
					SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
									JOIN voucher ON voucher.product_id = product.id
									JOIN merchantvoucher ON merchantvoucher.voucher_id = voucher.id
									WHERE merchantvoucher.merchant_id = " . $id .
										" AND subcat_level_1.category_id = " . $c->id . " AND
										voucher.status = 'active'
						GROUP BY id
					) as T
					GROUP BY id
					ORDER BY nprod DESC"
			));

            $count_categories_voucher = DB::select(DB::raw(
                "SELECT COUNT(*) as counter
                FROM merchantvoucher op, product p, voucher v
                WHERE v.product_id=p.id
				AND v.id = op.voucher_id
                AND p.category_id= " . $c->id . "
                AND op.merchant_id = " . $id .  ";"
            ));

            $count_categoriesp_voucher[$p_voucher] = $count_categories_voucher[0]->counter;

            foreach($subcategories_voucher as $sub){
                $count_subcategories_voucher = DB::select(DB::raw(
                    "SELECT COUNT(*) as counter FROM merchantvoucher op,  voucher v,product p 
					LEFT JOIN subcat_level_2 ON (p.subcat_id = subcat_level_2.id AND p.subcat_level = 2) 
					LEFT JOIN subcat_level_3 ON (p.subcat_id = subcat_level_3.id AND p.subcat_level = 3) 
					WHERE v.product_id=p.id
					AND v.id = op.voucher_id
					AND p.category_id= " . $c->id . " 
					AND ((p.subcat_id= " . $sub->id . " AND p.subcat_level = 1) OR (subcat_level_2.subcat_level_1_id = " . $sub->id . ") OR (subcat_level_3.subcat_level_1_id = " . $sub->id . ")) 
					AND op.merchant_id = " . $id
                ));
                $count_subcategoriesp_voucher[$sp_voucher] = $count_subcategories_voucher[0]->counter;
                $sp_voucher++;
            }

			$subcategoriesp_voucher[$p_voucher] = $subcategories_voucher;


			if(!is_null($subid)){
                $product_idsForaSection_voucher = DB::select(DB::raw(
					"select p.* from merchantvoucher op,  voucher v, product p, merchant m
						where v.product_id=p.id and op.merchant_id=m.id AND v.id = op.voucher_id
						and v.status='active'
						ORDER BY p.brand_id;"));

			} else {
                $product_idsForaSection_voucher = DB::select(DB::raw(
					"select p.* from merchantvoucher op,  voucher v, product p, merchant m
						where v.product_id=p.id and op.merchant_id=m.id AND v.id = op.voucher_id
						and v.status='active' and
						p.category_id =" .$c->id ." and
						op.merchant_id = " . $id .  " ORDER BY p.brand_id;"));
			}
			$products_voucher = array();
			foreach ($product_idsForaSection_voucher as $product_id) {
				$product=Product::find($product_id->id);
				array_push($products_voucher, $product);
			}
			$categoriesp_voucher[$p_voucher] = $products_voucher;
			$p_voucher++;
		}		

        $brands_voucher = DB::select(DB::raw(
            "SELECT DISTINCT(brand.id) as id, brand.name, COUNT(product.id) as nprod
            FROM brand
            JOIN product ON product.brand_id = brand.id
            JOIN voucher ON voucher.product_id = product.id
            JOIN merchantvoucher ON merchantvoucher.voucher_id = voucher.id
            WHERE 
				merchantvoucher.merchant_id = " . $id .  " AND voucher.status = 'active' AND (product.segment = 'v1' OR product.segment = 'v2')
            GROUP BY brand.id
			ORDER BY nprod DESC"
        ));		
		
        $subcatlevels_voucher = DB::select(DB::raw(
            "SELECT id, name, nprod FROM (
			SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
						FROM subcat_level_2
						JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
						JOIN voucher ON voucher.product_id = product.id
						JOIN merchantvoucher ON merchantvoucher.voucher_id = voucher.id
						WHERE 
							merchantvoucher.merchant_id = " . $id .  " AND voucher.status = 'active' AND (product.segment = 'v1' OR product.segment = 'v2')
						GROUP BY id
			UNION
			SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
						FROM subcat_level_2
						JOIN subcat_level_3 ON subcat_level_3.subcat_level_2_id = subcat_level_2.id
						JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
						JOIN voucher ON voucher.product_id = product.id
						JOIN merchantvoucher ON merchantvoucher.voucher_id = voucher.id
						WHERE 
							merchantvoucher.merchant_id = " . $id .  " AND voucher.status = 'active' AND (product.segment = 'v1' OR product.segment = 'v2')
						GROUP BY id	
			) as T
						GROUP BY id
			ORDER BY nprod DESC"
        ));		
		$subcatleves3_voucher = null;
		if(!is_null($subcatlevels_voucher)){
			foreach($subcatlevels_voucher as $subcatleveldef){
				$subcatleves3_voucher[$subcatleveldef->id] = DB::select(DB::raw(
					"SELECT DISTINCT(subcat_level_3.id) as id, subcat_level_3.description as name, COUNT(product.id) as nprod
					FROM subcat_level_3
					JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
					JOIN voucher ON voucher.product_id = product.id
					JOIN merchantvoucher ON merchantvoucher.voucher_id = voucher.id
					WHERE 
						merchantvoucher.merchant_id = " . $id .  " AND voucher.status = 'active'
						AND subcat_level_3.subcat_level_2_id = " . $subcatleveldef->id . "
					GROUP BY subcat_level_3.id
					ORDER BY nprod DESC"
				));					
			}
		}		 
		 
		$smmProducts=array();
		$product_idsForaSection=DB::table('oshopproduct')->where('oshop_id',$oshop_id)->get();
		foreach ($product_idsForaSection as $product_id) {
			$product=Product::find($product_id->product_id);
            if (!is_null($product)) {
                # code...
            if ($product->smm_selected==1 and $product->oshop_selected==1) {
                # code...
                array_push($smmProducts, $product);
            }
            $temp2=array();
            //$temp2['section']=DB::table('section')->where('id',$section->id)->first();
            $temp2['product']=$product;
            array_push($products, $temp2);
            }


		}
		
		$count_all_smm_products = count($smmProducts);
		
        $categories_smm = DB::select(DB::raw(
            "SELECT DISTINCT(category.id) as id, category.name,
				category.description, COUNT(product.id) as nprod
            FROM category
            JOIN product ON product.category_id = category.id
            JOIN oshopproduct ON oshopproduct.product_id = product.id
            WHERE 
				oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.smm_selected = 1
            GROUP BY category.id
            ORDER BY nprod DESC"
        ));		
		
		$categoriesp_smm = array();
		$subcategoriesp_smm = array();
        $count_categoriesp_smm = array();
        $count_subcategoriesp_smm = array();
		$p_smm = 0;
        $sp_smm = 0;
        $products_smm = array();

		foreach($categories_smm as $c){
			$subcategories_smm = DB::select(DB::raw(
				"SELECT id, COUNT(nprod) as nprod, name, description FROM 
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name,
				subcat_level_1.description as description, product.id as nprod
				FROM subcat_level_1
				JOIN product ON product.subcat_id = subcat_level_1.id AND product.subcat_level = 1
				JOIN oshopproduct ON oshopproduct.product_id = product.id
				WHERE oshopproduct.oshop_id = " . $oshop_id .
					" AND subcat_level_1.category_id = " . $c->id . "
					AND product.oshop_selected = true
					AND product.smm_selected = true
					AND product.retail_price > 0
					AND product.available > 0	
					AND product.deleted_at IS NULL					
					UNION				
					SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
									JOIN oshopproduct ON oshopproduct.product_id = product.id
									WHERE oshopproduct.oshop_id = " . $oshop_id .
					" AND subcat_level_1.category_id = " . $c->id . "
										AND product.smm_selected = true
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0
										AND product.deleted_at IS NULL
						GROUP BY id				
										
					UNION				
					SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
									JOIN oshopproduct ON oshopproduct.product_id = product.id
									WHERE oshopproduct.oshop_id = " . $oshop_id .
					" AND subcat_level_1.category_id = " . $c->id . "
										AND product.smm_selected = true
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0	
										AND product.deleted_at IS NULL
						GROUP BY id
					) as T
					GROUP BY id
					ORDER BY nprod DESC"
			));

            $count_categories_smm = DB::select(DB::raw(
                "SELECT COUNT(*) as counter
                FROM oshopproduct op, product p
                WHERE op.product_id=p.id
                AND p.oshop_selected=true
                AND p.smm_selected=true
				AND p.retail_price > 0
				AND p.available > 0
				AND p.deleted_at IS NULL
                AND p.category_id= " . $c->id . "
                AND op.oshop_id = " . $oshop_id .  ";"
            ));

            $count_categoriesp_smm[$p_smm] = $count_categories_smm[0]->counter;

            foreach($subcategories_smm as $sub){
                $count_subcategories_smm = DB::select(DB::raw(
                    "SELECT COUNT(*) as counter FROM oshopproduct op, product p 
					LEFT JOIN subcat_level_2 ON (p.subcat_id = subcat_level_2.id AND p.subcat_level = 2) 
					LEFT JOIN subcat_level_3 ON (p.subcat_id = subcat_level_3.id AND p.subcat_level = 3) 
					WHERE op.product_id=p.id AND 
					p.oshop_selected=true 
					AND p.smm_selected=true 
					AND p.retail_price > 0 
					AND p.deleted_at IS NULL
					AND p.available > 0 AND p.category_id= " . $c->id . " 
					AND ((p.subcat_id= " . $sub->id . " AND p.subcat_level = 1) OR (subcat_level_2.subcat_level_1_id = " . $sub->id . ") OR (subcat_level_3.subcat_level_1_id = " . $sub->id . ")) 
					AND op.oshop_id = " . $oshop_id
                ));
                $count_subcategoriesp_smm[$sp_smm] = $count_subcategories_smm[0]->counter;
                $sp_smm++;
            }

			$subcategoriesp_smm[$p_smm] = $subcategories_smm;


			if(!is_null($subid)){
                $product_idsForaSection_smm = DB::select(DB::raw(
					"select p.* from merchantproduct op, product p, merchant m
						where op.product_id=p.id and op.merchant_id=m.id
						and p.oshop_selected=true and p.smm_selected=true and p.retail_price > 0 AND product.deleted_at IS NULL AND p.available > 0
						ORDER BY p.brand_id;"));

			} else {
                $product_idsForaSection_smm = DB::select(DB::raw(
					"select p.* from oshopproduct op, merchantproduct mp,product p, merchant m
						where op.product_id=p.id and mp.product_id=p.id and mp.merchant_id=m.id and
						p.oshop_selected=true and p.smm_selected=true and
						p.retail_price > 0 and
						p.available > 0 and
						p.deleted_at IS NULL and
						p.category_id =" .$c->id ." and
						op.oshop_id = " . $oshop_id .  " ORDER BY p.brand_id;"));
			}
			$products_smm = array();
			foreach ($product_idsForaSection_smm as $product_id) {
				$product=Product::find($product_id->id);
				array_push($products_smm, $product);
			}
			$categoriesp_smm[$p_smm] = $products_smm;
			$p_smm++;
		}		

        $brands_smm = DB::select(DB::raw(
            "SELECT DISTINCT(brand.id) as id, brand.name, COUNT(product.id) as nprod
            FROM brand
            JOIN product ON product.brand_id = brand.id
            JOIN oshopproduct ON oshopproduct.product_id = product.id
            WHERE 
				oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.smm_selected = 1
            GROUP BY brand.id
			ORDER BY brand.name ASC"
        ));		
		
        $subcatlevels_smm = DB::select(DB::raw(
            "SELECT id, name, nprod FROM (
			SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
						FROM subcat_level_2
						JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
						JOIN oshopproduct ON oshopproduct.product_id = product.id
						WHERE 
							oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.smm_selected = 1
						GROUP BY id
			UNION
			SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
						FROM subcat_level_2
						JOIN subcat_level_3 ON subcat_level_3.subcat_level_2_id = subcat_level_2.id
						JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
						JOIN oshopproduct ON oshopproduct.product_id = product.id
						WHERE 
							oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.smm_selected = 1
						GROUP BY id	
			) as T
						GROUP BY id
			ORDER BY name ASC"
        ));		
		$subcatleves3_smm = null;
		if(!is_null($subcatlevels_smm)){
			foreach($subcatlevels_smm as $subcatleveldef){
				$subcatleves3_smm[$subcatleveldef->id] = DB::select(DB::raw(
					"SELECT DISTINCT(subcat_level_3.id) as id, subcat_level_3.description as name, COUNT(product.id) as nprod
					FROM subcat_level_3
					JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
					JOIN oshopproduct ON oshopproduct.product_id = product.id
					WHERE 
						oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.smm_selected = 1
						AND subcat_level_3.subcat_level_2_id = " . $subcatleveldef->id . "
					GROUP BY subcat_level_3.id
					ORDER BY name ASC"
				));					
			}
		}		
		
        $oshop_template=DB::table('oshop_template')->where('merchant_id',$id)->first();
        $subname = null;
		if(!is_null($subid)){
			$subname = DB::table('subcat_level_1')->where('id',$subid)->first();
		}
		$oshop_template=DB::table('oshop_template')->where('merchant_id',$id)->first();

        $autolink_status=0;
        $canautolink=true;
        $isadmin=0;
		$isadmin = 0;
		if (Auth::check()){
			$role= DB::table('role_users')->where('user_id',Auth::user()->id)->join('roles', 'roles.id', '=', 'role_users.role_id')->get();
			foreach ($role as $userrole) {
				if($userrole->name == "adminstrator"){
					$isadmin = 1;
				}
			}	
			$professional= DB::table('station')->where('user_id',Auth::user()->id)->join('logistic', 'station.id', '=', 'logistic.station_id')->pluck('professional');
			if($professional == 1){
				$canautolink=false;
			}
		}
        $autolink_requested=0;
        // check if an autolink enabled exists
		$autolink = 0;
		if(Auth::check()){
			$autolink=DB::table('autolink')->where('status','linked')->where(['initiator'=>Auth::user()->id,'responder'=>$id])->get();
		}

        // return $autolink;
        if (count($autolink)>0) {
            # code...
            $autolink_status=1;
        } else {
			$autolinkr=DB::table('autolink')->where('status','requested')->where(['initiator'=>Auth::user()->id,'responder'=>$id])->get();
			if (count($autolinkr)>0) {
				 $autolink_requested=1;
			}
		}

        $enableSpecialAndWholesalePrice = 0;
        $user_id = null;
        if (Auth::check()){
           $user_id = Auth::user()->id;
        }
        $showAutolink =  0;

        $getInitiatorOrResponder =  Autolink::where('initiator', $user_id)->first();
		$badge_num = "";
        $getMerchant =  Merchant::where('user_id', $user_id)->first();
        $address = null;
        $raddress = null;
		if(isset($getMerchant)){
			$address =  Address::where('id', $getMerchant->address_id)->first();
			$raddress =  Address::where('id', $getMerchant->return_address_id)->first();
		}
		$immerchant = 0;
        if(isset($getInitiatorOrResponder) or isset($getMerchant)){
            $viewForDealers = 1;
			if(isset($getMerchant)){
				$immerchant = $getMerchant->id;
				if($immerchant == $id){
					$autolink_status=1;
					$autolinkrr=DB::table('autolink')->where('status','requested')->where(['responder'=>$id])->get();
					$badge_num = count($autolinkrr);
				}
			}
        }else{
            $viewForDealers = 0;
        }

        $count_productsb = DB::select(DB::raw(
            "SELECT p.id,p.name
             FROM product p, product p2, oshopproduct op, wholesale w, productdealer pd
             WHERE op.oshop_id = $oshop_id
             AND p2.parent_id = p.id
			 AND p.status ='active'
			 AND p2.available > 0
             AND p2.segment = 'b2b'
			 AND p.deleted_at IS NULL
             AND ((p2.id = w.product_id and price > 0)
             OR (p2.id = pd.product_id and special_price > 0))
			 AND p.id = op.product_id
             AND p.oshop_selected=true
             GROUP BY p.id;"
        ));

        $count_all_products = count($count_productsb);

        $categoriesb2b = DB::select(DB::raw(
            "SELECT DISTINCT(category.id) as id , category.name , category.description , COUNT(product.id) as nprod FROM category, wholesale, productdealer,product, product p2, oshopproduct WHERE product.category_id = category.id AND oshopproduct.product_id = product.id AND product.status ='active' AND product.deleted_at IS NULL AND p2.parent_id = product.id AND p2.available > 0 AND p2.segment = 'b2b' AND product.oshop_selected = 1 AND oshopproduct.oshop_id = " . $oshop_id . " AND ((p2.id = wholesale.product_id and price > 0) OR (p2.id = productdealer.product_id and productdealer.special_price > 0)) GROUP BY category.id ORDER BY nprod DESC"
        ));
        $categoriespb2b = array();
        $subcategoriespb2b = array();
        $count_categoriespb2b = array();
        $count_subcategoriespb2b = array();
        $b2bcategoriesp = array();
        $p = 0;
        $sp = 0;
        foreach($categoriesb2b as $c){

            $subcategoriesb2b = DB::select(DB::raw(
                "SELECT id, COUNT(nprod) as nprod, name, description FROM 					
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name, subcat_level_1.description as description, 
								product.id as nprod
								FROM subcat_level_1 
								JOIN product ON product.subcat_id = subcat_level_1.id  AND product.subcat_level = 1
								JOIN oshopproduct ON oshopproduct.product_id = product.id 
								JOIN product as p2 ON product.id = p2.parent_id AND p2.segment = 'b2b' AND p2.available > 0 
								JOIN wholesale ON wholesale.product_id = p2.id LEFT JOIN productdealer ON productdealer.product_id = p2.id 
								WHERE oshopproduct.oshop_id = " . $oshop_id . " AND subcat_level_1.category_id = " . $c->id . " 
								AND ((p2.id = wholesale.product_id and price > 0) OR (p2.id = productdealer.product_id and productdealer.special_price > 0)) AND product.status ='active' AND product.deleted_at IS NULL
								and product.oshop_selected=true 
								UNION
				SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name, subcat_level_1.description as description, 
								product.id as nprod
								FROM subcat_level_1 
								JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
								JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
								JOIN oshopproduct ON oshopproduct.product_id = product.id 
								JOIN product as p2 ON product.id = p2.parent_id AND p2.segment = 'b2b'  AND p2.available > 0
								JOIN wholesale ON wholesale.product_id = p2.id LEFT JOIN productdealer ON productdealer.product_id = p2.id 
								WHERE oshopproduct.oshop_id = " . $oshop_id . " AND subcat_level_1.category_id = " . $c->id . " 
								AND ((p2.id = wholesale.product_id and price > 0) OR (p2.id = productdealer.product_id and productdealer.special_price > 0)) AND product.status ='active' AND product.deleted_at IS NULL 
								and product.oshop_selected=true 
								UNION
				SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name, subcat_level_1.description as description, 
								product.id as nprod
								FROM subcat_level_1 
								JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
								JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
								JOIN oshopproduct ON oshopproduct.product_id = product.id 
								JOIN product as p2 ON product.id = p2.parent_id AND p2.segment = 'b2b'  AND p2.available > 0
								JOIN wholesale ON wholesale.product_id = p2.id LEFT JOIN productdealer ON productdealer.product_id = p2.id 
								WHERE oshopproduct.oshop_id = " . $oshop_id . " AND subcat_level_1.category_id = " . $c->id . " 
								AND ((p2.id = wholesale.product_id and price > 0) OR (p2.id = productdealer.product_id and productdealer.special_price > 0)) AND product.status ='active' AND product.deleted_at IS NULL
								and product.oshop_selected=true				
									
				) as T
				GROUP BY id
				ORDER BY nprod DESC	"
							));

            $count_categoriesb2b = DB::select(DB::raw(
                "SELECT p.id,p.name,p.brand_id
                 FROM product p, product p2,oshopproduct op, wholesale w, productdealer pd
                 WHERE op.oshop_id = " . $oshop_id . "
                 AND p2.parent_id = p.id
                 AND p2.segment = 'b2b' AND p2.available > 0
                 AND ((p2.id = w.product_id and price > 0)
                 OR (p2.id = pd.product_id and special_price > 0))
                 AND p.oshop_selected=true
				 AND p.id = op.product_id
				 AND p.status ='active'
				 AND p.deleted_at IS NULL
                 AND p.category_id= " . $c->id . "
                 GROUP BY p.id
				 ORDER BY p.brand_id"
            ));
            $count_categoriespb2b[$p] = count($count_categoriesb2b);
            foreach($subcategoriesb2b as $sub){
                $count_subcategoriesb2b = DB::select(DB::raw(
                    "SELECT p.id,p.name,p.brand_id
                     FROM product p2,oshopproduct op, wholesale w, productdealer pd, product p
					LEFT JOIN subcat_level_2 ON (p.subcat_id = subcat_level_2.id AND p.subcat_level = 2) 
					LEFT JOIN subcat_level_3 ON (p.subcat_id = subcat_level_3.id AND p.subcat_level = 3)					 
                     WHERE op.oshop_id = " . $oshop_id . "
                     AND p2.parent_id = p.id
                     AND p2.segment = 'b2b' AND p2.available > 0
                     AND ((p2.id = w.product_id and price > 0)
                     OR (p2.id = pd.product_id and special_price > 0))
                     AND p.oshop_selected=true
					 AND p.id = op.product_id
					 AND p.status ='active'
					 AND p.deleted_at IS NULL
                     AND p.category_id= " . $c->id . "
                     AND ((p.subcat_id= " . $sub->id . " AND p.subcat_level = 1) 
					 OR (subcat_level_2.subcat_level_1_id = " . $sub->id . " AND p.subcat_level = 2) 
					 OR (subcat_level_3.subcat_level_1_id = " . $sub->id . " AND p.subcat_level = 3))
                     GROUP BY p.id
					 ORDER BY p.brand_id"
                ));
				/*dd("SELECT p.id,p.name
                     FROM product p, product p2,oshopproduct op, wholesale w, productdealer pd
                     WHERE op.merchant_id = " . $id . "
                     AND p2.parent_id = p.id
                     AND p2.segment = 'b2b'
                     AND ((p2.id = w.product_id and price > 0)
                     OR (p2.id = pd.product_id and special_price > 0))
                     AND p.oshop_selected=true
					 AND p.id = op.product_id
                     AND p.category_id= " . $c->id . "
                     AND p.subcat_level= " . $sub->subcat_level . "
                     AND p.subcat_id= " . $sub->subcat_id . "
                     GROUP BY p.id;");*/
                $count_subcategoriespb2b[$sp] = count($count_subcategoriesb2b);
                $sp++;
            }
            $subcategoriespb2b[$p] = $subcategoriesb2b;

            $b2bproducts = DB::select(DB::raw(
                "SELECT p.*, p2.id as sid
                 FROM product p, product p2,oshopproduct op, wholesale w, productdealer pd
                 WHERE op.oshop_id = " . $oshop_id . "
                 AND p2.parent_id = p.id
                 AND p2.segment = 'b2b' AND p2.available > 0
                 AND ((p2.id = w.product_id and price > 0)
                 OR (p2.id = pd.product_id and special_price > 0))
                 AND p.oshop_selected=true
				 AND p.status ='active'
				 AND p.deleted_at IS NULL
				 AND p.id = op.product_id
                 AND p.category_id= " . $c->id . "
                 GROUP BY p.id
				 ORDER BY p.brand_id"
            ));

            $b2bcategoriesp[$p] = $b2bproducts;
            $p++;

        }

        $brands_b2b = DB::select(DB::raw(
            "SELECT DISTINCT(brand.id) as id, brand.name, COUNT(DISTINCT(product.id)) as nprod
            FROM brand
				JOIN product ON product.brand_id = brand.id
				JOIN oshopproduct ON oshopproduct.product_id = product.parent_id
				JOIN product as parent ON parent.id = product.parent_id
				JOIN wholesale ON wholesale.product_id = product.id
            WHERE 
				oshopproduct.oshop_id = " . $oshop_id .  " AND product.available > 0 AND parent.retail_price > 0 AND parent.available > 0 AND parent.oshop_selected = 1 AND parent.id = product.parent_id AND product.deleted_at IS NULL AND  product.segment = 'b2b' AND parent.status ='active'
            GROUP BY brand.id
			ORDER BY brand.name ASC"
        ));	

        $subcatlevels_b2b = DB::select(DB::raw(
            "SELECT id, name, nprod FROM (
				SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
							FROM subcat_level_2
							JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
							JOIN oshopproduct ON oshopproduct.product_id = product.parent_id
							JOIN product as parent ON parent.id = product.parent_id
							JOIN wholesale ON wholesale.product_id = product.id							
							WHERE 
								oshopproduct.oshop_id = " . $oshop_id .  " AND product.available > 0 AND parent.retail_price > 0  AND parent.available > 0 AND parent.oshop_selected = 1 AND product.deleted_at IS NULL AND parent.id = product.parent_id AND product.segment = 'b2b' AND parent.status ='active'
							GROUP BY id
				UNION
				SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
							FROM subcat_level_2
							JOIN subcat_level_3 ON subcat_level_3.subcat_level_2_id = subcat_level_2.id
							JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
							JOIN oshopproduct ON oshopproduct.product_id = product.parent_id
							JOIN product as parent ON parent.id = product.parent_id
							JOIN wholesale ON wholesale.product_id = product.id								
							WHERE 
								oshopproduct.oshop_id = " . $oshop_id .  " AND product.available > 0 AND parent.retail_price > 0  AND parent.available > 0 AND parent.oshop_selected = 1 AND product.deleted_at IS NULL AND parent.id = product.parent_id AND product.segment = 'b2b' AND parent.status ='active'
							GROUP BY id	
				) as T
			GROUP BY id
			ORDER BY name ASC"
        ));			
		

        // if(Auth::check()){
        //     if ($viewForDealers){
        //         $b2bproducts = $this->getProductsForDealers($id);
        //         $b2bSidebar = $this->getSidebar($b2bproducts);

        //     }else {
        //         $b2bproducts = $this->getProductsForRegularUsers($id);
        //         $b2bSidebar = $this->getSidebar($b2bproducts);
        //         $showAutolink = 1;
        //     }
        // }else{
        //     $b2bproducts = $this->getProductsForAnonymous($id);
        //     $b2bSidebar = $this->getSidebar($b2bproducts);
        // }


        // return $bunting->id;
        // return $autolink_status;
		
    //  $product_ids= DB::table('owarehouse')->lists('product_id');
        $data = Product::join('owarehouse as o','product.id','=','o.product_id')
                ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id')
							 ->where('op.status','=','executed');
                         })
                ->join('merchantproduct as mp','product.parent_id','=','mp.product_id')
                //->where('product.subcat_id','=',$id)
           //   ->whereIn('product.id',$product_ids)
                ->where('mp.merchant_id',$id)
                ->where('product.status','active')
                ->where('o.status','active')
                ->where('o.moq','>',0)
                ->where('product.owarehouse_moqperpax','>',0)
                ->where('product.owarehouse_price','>',0)
                ->where('product.oshop_selected',1)
                ->select(DB::raw('product.*,o.id as owarehouse_id,o.collection_price, product.parent_id as product_id,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
                ->groupBy('product.id')
                ->get();	
		
		$count_all_hyper = count($data);
		$categories_hyper = DB::select(DB::raw(
            "SELECT DISTINCT(category.id) as id, category.name,
				category.description, COUNT(product.id) as nprod
            FROM category
            JOIN product ON product.category_id = category.id
            JOIN oshopproduct ON oshopproduct.product_id = product.id
			JOIN product as hyper ON product.id = hyper.parent_id AND hyper.segment = 'hyper'
			JOIN owarehouse ON owarehouse.product_id = hyper.id
            WHERE 
				oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0  AND product.available > 0 AND product.oshop_selected = 1 AND hyper.owarehouse_moqperpax > 0 AND hyper.owarehouse_price > 0 AND owarehouse.status = 'active' AND owarehouse.moq > 0
				AND hyper.status = 'active'
            GROUP BY category.id
            ORDER BY name ASC"
        ));
		
		$categoriesp_hyper = array();
		$subcategoriesp_hyper = array();
        $count_categoriesp_hyper = array();
        $count_subcategoriesp_hyper = array();
		$p_hyper = 0;
        $sp_hyper = 0;
        $products_hyper = array();

		foreach($categories_hyper as $c){
			$subcategories_hyper = DB::select(DB::raw(
				"SELECT id, COUNT(nprod) as nprod, name, description FROM 
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name,
				subcat_level_1.description as description, product.id as nprod
				FROM subcat_level_1
				JOIN product ON product.subcat_id = subcat_level_1.id AND product.subcat_level = 1
				JOIN oshopproduct ON oshopproduct.product_id = product.id
				JOIN product as hyper ON product.id = hyper.parent_id AND hyper.segment = 'hyper'
				JOIN owarehouse ON owarehouse.product_id = hyper.id				
				WHERE oshopproduct.oshop_id = " . $oshop_id .
					" AND subcat_level_1.category_id = " . $c->id . "
					AND product.oshop_selected = true
					AND product.retail_price > 0
					AND product.available > 0	
					AND hyper.owarehouse_moqperpax > 0 AND hyper.owarehouse_price > 0 AND owarehouse.status = 'active' AND owarehouse.moq > 0
					AND hyper.status = 'active'					
					UNION				
					SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
									JOIN oshopproduct ON oshopproduct.product_id = product.id
									JOIN product as hyper ON product.id = hyper.parent_id AND hyper.segment = 'hyper'
									JOIN owarehouse ON owarehouse.product_id = hyper.id											
									WHERE oshopproduct.oshop_id = " . $oshop_id .
					" AND subcat_level_1.category_id = " . $c->id . "
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0
										AND hyper.owarehouse_moqperpax > 0 AND hyper.owarehouse_price > 0 AND owarehouse.status = 'active' AND owarehouse.moq > 0
										AND hyper.status = 'active'
						GROUP BY id				
										
					UNION				
					SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
									JOIN oshopproduct ON oshopproduct.product_id = product.id
									JOIN product as hyper ON product.id = hyper.parent_id AND hyper.segment = 'hyper'
									JOIN owarehouse ON owarehouse.product_id = hyper.id											
									WHERE oshopproduct.oshop_id = " . $oshop_id .
					" AND subcat_level_1.category_id = " . $c->id . "
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0
										AND hyper.owarehouse_moqperpax > 0 AND hyper.owarehouse_price > 0 AND owarehouse.status = 'active' AND owarehouse.moq > 0
										AND hyper.status = 'active'
						GROUP BY id
					) as T
					GROUP BY id
					ORDER BY nprod DESC"
			));

            $count_categories_hyper = DB::select(DB::raw(
                "SELECT COUNT(*) as counter
                FROM oshopproduct op, product p, product hyper, owarehouse ow
                WHERE op.product_id=p.id
				AND p.id = hyper.parent_id
				AND hyper.segment = 'hyper'
				AND ow.product_id = hyper.id
                AND p.oshop_selected=true
				AND p.retail_price > 0
				AND p.available > 0
				AND hyper.owarehouse_moqperpax > 0 AND hyper.owarehouse_price > 0 AND ow.status = 'active' AND ow.moq > 0
				AND hyper.status = 'active'
                AND p.category_id= " . $c->id . "
                AND op.oshop_id = " . $oshop_id .  ";"
            ));

            $count_categoriesp_hyper[$p_hyper] = $count_categories_hyper[0]->counter;
			/**/
            foreach($subcategories_hyper as $sub){
                $count_subcategories_hyper = DB::select(DB::raw(
                    "SELECT COUNT(*) as counter FROM oshopproduct op, product hyper, owarehouse ow, product p 
					LEFT JOIN subcat_level_2 ON (p.subcat_id = subcat_level_2.id AND p.subcat_level = 2) 
					LEFT JOIN subcat_level_3 ON (p.subcat_id = subcat_level_3.id AND p.subcat_level = 3) 
					WHERE op.product_id=p.id 
					AND p.id = hyper.parent_id
					AND hyper.segment = 'hyper'
					AND ow.product_id = hyper.id					
					AND 
					p.oshop_selected=true 
					AND p.retail_price > 0
					AND hyper.owarehouse_moqperpax > 0 AND hyper.owarehouse_price > 0 AND ow.status = 'active' AND ow.moq > 0
					AND hyper.status = 'active'					
					AND p.available > 0 AND p.category_id= " . $c->id . " 
					AND ((p.subcat_id= " . $sub->id . " AND p.subcat_level = 1) OR (subcat_level_2.subcat_level_1_id = " . $sub->id . ") OR (subcat_level_3.subcat_level_1_id = " . $sub->id . ")) 
					AND op.oshop_id = " . $oshop_id
                ));
                $count_subcategoriesp_hyper[$sp_hyper] = $count_subcategories_hyper[0]->counter;
                $sp_hyper++;
            }

			$subcategoriesp_hyper[$p_hyper] = $subcategories_hyper;

            // return $subcategoriesp_hyper;



			/*if(!is_null($subid)){
                $product_idsForaSection = DB::select(DB::raw(
					"select p.* from oshopproduct op, product p, merchant m, product hyper, owarehouse ow
						where op.product_id=p.id and op.merchant_id=m.id
						and p.oshop_selected=true and p.retail_price > 0 AND p.available > 0
						ORDER BY p.brand_id;"));

			} else {
                $product_idsForaSection = DB::select(DB::raw(
					"select p.* from oshopproduct op, product p, merchant m
						where op.product_id=p.id and op.merchant_id=m.id and
						p.oshop_selected=true and
						p.retail_price > 0 and
						p.available > 0 and
						p.category_id =" .$c->id ." and
						op.merchant_id = " . $id .  " ORDER BY p.brand_id;"));
			}
			$products_hyper = array();
			foreach ($product_idsForaSection as $product_id) {
				$product=Product::find($product_id->id);
				array_push($products_hyper, $product);
			}
			$categoriesp_hyper[$p_hyper] = $products_hyper;*/
			$p_hyper++;
		}		
        $brands_hyper = DB::select(DB::raw(
            "SELECT DISTINCT(brand.id) as id, brand.name, COUNT(product.id) as nprod
            FROM brand
            JOIN product ON product.brand_id = brand.id
            JOIN oshopproduct ON oshopproduct.product_id = product.id
            JOIN product as hyper ON hyper.parent_id = product.id
			JOIN owarehouse ON owarehouse.product_id = hyper.id
            WHERE 
				oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0  AND product.available > 0 AND product.oshop_selected = 1 AND hyper.owarehouse_moqperpax > 0 AND hyper.owarehouse_price > 0 AND owarehouse.status = 'active' AND owarehouse.moq > 0 AND hyper.status = 'active'
            GROUP BY brand.id
			ORDER BY brand.name ASC"
        ));	
		
        $subcatlevels_hyper = DB::select(DB::raw(
            "SELECT id, name, nprod FROM (
			SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
						FROM subcat_level_2
						JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
						JOIN oshopproduct ON oshopproduct.product_id = product.id
						JOIN product as hyper ON hyper.parent_id = product.id
						JOIN owarehouse ON owarehouse.product_id = hyper.id
						WHERE 
							oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0  AND product.available > 0 AND product.oshop_selected = 1 AND hyper.owarehouse_moqperpax > 0 AND hyper.owarehouse_price > 0 AND owarehouse.status = 'active' AND owarehouse.moq > 0 AND hyper.status = 'active'
						GROUP BY id
			UNION
			SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
						FROM subcat_level_2
						JOIN subcat_level_3 ON subcat_level_3.subcat_level_2_id = subcat_level_2.id
						JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
						JOIN oshopproduct ON oshopproduct.product_id = product.id
						JOIN product as hyper ON hyper.parent_id = product.id
						JOIN owarehouse ON owarehouse.product_id = hyper.id
						WHERE 
							oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0  AND product.available > 0 AND product.oshop_selected = 1 AND hyper.owarehouse_moqperpax > 0 AND hyper.owarehouse_price > 0 AND owarehouse.status = 'active' AND owarehouse.moq > 0 AND hyper.status = 'active'
						GROUP BY id	
			) as T
						GROUP BY id
			ORDER BY name ASC"
        ));		
		$subcatleves3_hyper = null;
		if(!is_null($subcatlevels_hyper)){
			foreach($subcatlevels_hyper as $subcatleveldef){
				$subcatleves3_hyper[$subcatleveldef->id] = DB::select(DB::raw(
					"SELECT DISTINCT(subcat_level_3.id) as id, subcat_level_3.description as name, COUNT(product.id) as nprod
					FROM subcat_level_3
					JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
					JOIN oshopproduct ON oshopproduct.product_id = product.id
					JOIN product as hyper ON hyper.parent_id = product.id
					JOIN owarehouse ON owarehouse.product_id = hyper.id
					WHERE 
						oshopproduct.oshop_id = " . $oshop_id .  " AND product.retail_price > 0  AND product.available > 0 AND product.oshop_selected = 1 AND hyper.owarehouse_moqperpax > 0 AND hyper.owarehouse_price > 0 AND owarehouse.status = 'active' AND owarehouse.moq > 0 AND hyper.status = 'active'
						AND subcat_level_3.subcat_level_2_id = " . $subcatleveldef->id . "
					GROUP BY subcat_level_3.id
					ORDER BY name ASC"
				));					
			}
		}		
		
            if(!Auth::check()){
				$role=False;
			} else {
				$role_user=DB::table('role_users')->where('user_id',Auth::user()->id)->pluck('role_id');
				$role=False;
				if ($role_user==2 || $role_user==11 || $role_user==3) {
				  # code...
				  $role=True;
				}
			}
			
		if(Auth::check()){
			$specialproducts = DB::table('product')->join('merchantproduct','product.id','=','merchantproduct.product_id')->where('merchantproduct.merchant_id',$id)->select('product.id' ,
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
				  'product.updated_at')->distinct()->join('productdealer', function ($join) {
				$join->on('productdealer.product_id', '=', 'product.id')->where('productdealer.dealer_id','=',Auth::user()->id);
			})->get();
			
		} else {
			$specialproducts = null;
		}
		//dd($voucher_data);		
        return view('oshop')
            ->with('specialproducts',$specialproducts)
            ->with('smmProducts',$smmProducts)
            ->with('oshop_url',$url)
            ->with('count_all_hyper',$count_all_hyper)
            ->with('count_all_smm_products',$count_all_smm_products)
            ->with('count_all_voucher_products',$count_all_voucher_products)
			->with('subcatlevels_hyper',$subcatlevels_hyper)
			->with('subcatlevels',$subcatlevels)
			->with('subcatlevels_smm',$subcatlevels_smm)
			->with('subcatlevels_voucher',$subcatlevels_voucher)
			->with('subcatleves3',$subcatleves3)
			->with('subcatleves3_hyper',$subcatleves3_hyper)
			->with('subcatleves3_voucher',$subcatleves3_voucher)
			->with('subcatleves3_smm',$subcatleves3_smm)
			->with('colors',$colors)
			->with('brands',$brands)
			->with('brands_smm',$brands_smm)
			->with('brands_voucher',$brands_voucher)
			->with('brands_hyper',$brands_hyper)
			->with('brands_b2b',$brands_b2b)
			->with('subcatlevels_b2b',$subcatlevels_b2b)
            ->with('merchant',$merchant)
            ->with('address',$address)
            ->with('raddress',$raddress)
//            ->with('theme',$theme)
            ->with('bunting',$bunting)
            ->with('merchantvouchers',$voucher_data)
            ->with('vbanner',$vbanner)
            ->with('signboard',$signboard)
            ->with('products',$products)
            ->with('products_smm',$products_smm)
            ->with('type','oshop')
            ->with('categories',$categories)
            ->with('categories_smm',$categories_smm)
            ->with('categories_voucher',$categories_voucher)
            ->with('categories_hyper',$categories_hyper)
            ->with('subcategoriesp',$subcategoriesp)
            ->with('subcategoriesp_smm',$subcategoriesp_smm)
            ->with('subcategoriesp_voucher',$subcategoriesp_voucher)
            ->with('subcategoriesp_hyper',$subcategoriesp_hyper)
            ->with('categoriesp',$categoriesp)
            ->with('categoriesp_smm',$categoriesp_smm)
            ->with('categoriesp_voucher',$categoriesp_voucher)
            ->with('subid',$subid)
            ->with('subname',$subname)
            ->with('id',$id)
            ->with('oshop_id',$oshop_id)
            ->with('canautolink',$canautolink)
            ->with('showAutolink', $showAutolink)
            //->with('b2bSidebar',$b2bSidebar)
            // ->with('b2bproducts',$b2bproducts)
            ->with('b2bcategoriesp',$b2bcategoriesp)
            ->with('count_categoriesp',$count_categoriesp)
            ->with('count_categoriesp_smm',$count_categoriesp_smm)
            ->with('count_categoriesp_voucher',$count_categoriesp_voucher)
            ->with('count_categoriesp_hyper',$count_categoriesp_hyper)
            ->with('count_subcategoriesp',$count_subcategoriesp)
            ->with('count_subcategoriesp_smm',$count_subcategoriesp_smm)
            ->with('count_subcategoriesp_voucher',$count_subcategoriesp_voucher)
            ->with('count_subcategoriesp_hyper',$count_subcategoriesp_hyper)
            ->with('count_products',$count_products)
            ->with('count_productsb',$count_productsb)
            ->with('count_all_products',$count_all_products)
            ->with('categoriesb2b',$categoriesb2b)
            ->with('count_categoriespb2b',$count_categoriespb2b)
            ->with('subcategoriespb2b',$subcategoriespb2b)
            ->with('count_subcategoriespb2b',$count_subcategoriespb2b)
            ->with('autolink_status',$autolink_status)
            ->with('isadmin',$isadmin)
            ->with('autolink_requested',$autolink_requested)
            ->with('badge_num',$badge_num)
            ->with('ow_product',$data)
            ->with('role',$role)			
            ->with('oshop_name',$oshop_name)			
            ->with('immerchant',$immerchant);
	 }
    }

    public function master() {
		$oshops = DB::table('oshop')
		->select('oshop.*','merchantoshop.merchant_id as merchant_id','merchant.company_name as company_name','city.name as cityname','area.name as areaname','state.name as statename','country.name as countryname')
		->join('merchantoshop','oshop.id','=','merchantoshop.oshop_id')->join('merchant','merchant.id','=','merchantoshop.merchant_id')
		->leftJoin('address','oshop.address_id','=','address.id')
		//->leftJoin('brand','oshop.brand_id','=','brand_id')
		->leftJoin('city','address.city_id','=','city.id')->leftJoin('area','address.area_id','=','area.id')
		->leftJoin('state','state.code','=','city.state_code')->leftJoin('country','country.code','=','state.country_code')
		->distinct()
		->get();
		
		foreach($oshops as $oshop){
			//dd($oshop);
			$sales = DB::table('orderproduct')
			->join('oshopproduct','oshopproduct.product_id','=','orderproduct.product_id')
			->where('oshopproduct.oshop_id','=',$oshop->id)
			->select(DB::raw('SUM(orderproduct.order_price + orderproduct.quantity + orderproduct.order_delivery_price) as total_sales'))
			->groupBy('oshopproduct.oshop_id')->get();
			//dd($sales);
			if(count($sales) > 0){
				$oshop->sales = $sales[0]->total_sales;
			} else {
				$oshop->sales = 0;
			}
			$merchantstatus = DB::table('merchant')->where('id',$oshop->merchant_id)->pluck('status');
			if($merchantstatus == 'suspended'){
				if($oshop->status != 'transferred'){
					$oshop->status = 'inactive';
				}
			}
			$productstatus = DB::table('product')->join('oshopproduct','product.id','=','oshopproduct.product_id')
									->where('oshopproduct.oshop_id',$oshop->id)->where('product.status','active')->first();
			if(is_null($productstatus)){
				if($oshop->status != 'transferred'){
					$oshop->status = 'inactive';
				}
			}
			$brand = DB::table('brand')->where('id',$oshop->brand_id)->first();
			$oshop->brand_name = 'N.A';
			if(!is_null($brand)){
				$oshop->brand_name = $brand->name;
			}
		}
		//dd($osh1ops);
		return view('master.oshop',['oshops'=>$oshops]);
	}
	
	public function oshopapproval($id)
    {
		$oshop = DB::table('oshop')
		->select('oshop.*','merchantoshop.merchant_id as merchant_id','merchant.company_name as company_name','city.name as cityname','area.name as areaname','state.name as statename','country.name as countryname')
		->join('merchantoshop','oshop.id','=','merchantoshop.oshop_id')->join('merchant','merchant.id','=','merchantoshop.merchant_id')
		->leftJoin('address','oshop.address_id','=','address.id')
		->leftJoin('city','address.city_id','=','city.id')->leftJoin('area','address.area_id','=','area.id')
		->leftJoin('state','state.code','=','city.state_code')->leftJoin('country','country.code','=','state.country_code')
		->where('oshop.id',$id)
		->first();
		$merchantstatus = DB::table('merchant')->where('id',$oshop->merchant_id)->pluck('status');
		if($merchantstatus == 'suspended'){
			if($oshop->status != 'transferred'){
				$oshop->status = 'inactive';
			}
		}
		$productstatus = DB::table('product')->join('oshopproduct','product.id','=','oshopproduct.product_id')
								->where('oshopproduct.oshop_id',$oshop->id)->where('product.status','active')->first();
		if(is_null($productstatus)){
			if($oshop->status != 'transferred'){
				$oshop->status = 'inactive';
			}
		}
		$products = DB::table('product')->join('oshopproduct','product.id','=','oshopproduct.product_id')
								->where('oshopproduct.oshop_id',$oshop->id)->select('product.*')->get();
		$merchant = DB::table('merchant')->where('id',$oshop->merchant_id)->first();
		return view('master.oshop_approval',['merchant'=>$merchant,'products'=>$products,'oshop'=>$oshop]);
    }	
	
	public function oshoptransfer($id)
    {
		$oshop = DB::table('oshop')->where('id',$id)->first();
		$oshops = null;
		$merchant_id = DB::table('merchantoshop')->where('oshop_id',$oshop->id)->pluck('merchant_id');
		//dd($merchant_id);
		if(!is_null($oshop)){
			$oshops = DB::table('merchant')
			->select('merchantbrand.merchant_id as merchant_id','merchant.company_name as company_name','city.name as cityname','area.name as areaname','state.name as statename','country.name as countryname','brand.name as brand_name')
			->join('merchantbrand','merchant.id','=','merchantbrand.merchant_id')
			->join('brand','brand.id','=','merchantbrand.brand_id')
			->leftJoin('address','merchant.address_id','=','address.id')
			->leftJoin('city','address.city_id','=','city.id')->leftJoin('area','address.area_id','=','area.id')
			->leftJoin('state','state.code','=','city.state_code')->leftJoin('country','country.code','=','state.country_code')
			->where('merchantbrand.brand_id','=',$oshop->brand_id)
			->where('merchant.id','!=',$merchant_id)
			->get();
			//dd($oshops);
		}

		return view('master.oshop_transfer',['oshops'=>$oshops,'oshop'=>$oshop]);
	}
	
	public function oshopproducttransfer($id)
    {
		$oshop = DB::table('oshop')
		->select('oshop.*','merchantoshop.merchant_id as merchant_id','merchant.company_name as company_name','city.name as cityname','area.name as areaname','state.name as statename','country.name as countryname')
		->join('merchantoshop','oshop.id','=','merchantoshop.oshop_id')->join('merchant','merchant.id','=','merchantoshop.merchant_id')
		->join('oshopproduct','oshop.id','=','oshopproduct.oshop_id')
		->join('product','product.id','=','oshopproduct.product_id')
		->leftJoin('address','oshop.address_id','=','address.id')
		->leftJoin('city','address.city_id','=','city.id')->leftJoin('area','address.area_id','=','area.id')
		->leftJoin('state','state.code','=','city.state_code')->leftJoin('country','country.code','=','state.country_code')
		->where('product.id','=',$id)
		->first();
		//dump($oshop);
		$oshops = null;
		if(!is_null($oshop)){
			$oshops = DB::table('oshop')
			->select('oshop.*','merchantoshop.merchant_id as merchant_id','merchant.company_name as company_name','city.name as cityname','area.name as areaname','state.name as statename','country.name as countryname','brand.name as brand_name')
			->join('merchantoshop','oshop.id','=','merchantoshop.oshop_id')->join('merchant','merchant.id','=','merchantoshop.merchant_id')
			->join('brand','brand.id','=','oshop.brand_id')
			->leftJoin('address','oshop.address_id','=','address.id')
			->leftJoin('city','address.city_id','=','city.id')->leftJoin('area','address.area_id','=','area.id')
			->leftJoin('state','state.code','=','city.state_code')->leftJoin('country','country.code','=','state.country_code')
			->where('oshop.id','!=',$oshop->id)
			->where('oshop.status','!=','transferred')
			->where('oshop.brand_id','=',$oshop->brand_id)
			->get();
		}
		//dd($oshops);
		$product = DB::table('product')->where('id',$id)->first();
		return view('master.oshop_product_transfer',['oshops'=>$oshops,'product'=>$product]);
    }
	
//function for saving remarks of station
    public function saveOshopRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
		$res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
			$res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
			echo $res;
		}
		//echo "Hola";
    }

    public function oshop_remarks($id){
		$remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status, nbuyerid.nbuyer_id, oshop.url, oshop.id as noshopid from remark inner join oshopremark on oshopremark.remark_id = remark.id left join nbuyerid on remark.user_id = nbuyerid.user_id join oshop ON oshopremark.oshop_id = oshop.id where oshopremark.oshop_id = " . $id . " order by remark.created_at desc"));

		return json_encode($remarks);
	}	
	
	public function approveOshop() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
         return \App\Classes\AdminApproveHelper::approveUser($inputs);

      }
    }	
	
    private function getSidebar($products) {
        $categories = array();
        foreach ($products as $key => $product) {
            $level = $product->subcat_level;
            if ($level == 1) {
                $category_id = $product->category_id;
                $subcat_level_1 = DB::table('subcat_level_1')->where('id', $category_id)->first(['name', 'category_id']);

                if (isset($subcat_level_1)) {

                    // $category = DB::table('category')->where('id', $subcat_level_1->category_id)->first()->name;
                    $category = DB::table('category')->where('id', $subcat_level_1->category_id)->first();
                    if (isset($category)) {
                        $key = ucwords(str_replace("_"," ",$category->name));
                        $value = ucwords(str_replace("_"," ",$subcat_level_1->name));
                        $array_key_exists = array_key_exists($key, $categories);
                        if ($array_key_exists == 0) {
                            $categories[$key] = $value;
                        }
                    }
                }
            } else if ($level == 2) {
                $category_id = $product->category_id;
                $subcat_level_2 = DB::table('subcat_level_2')->where('id', $category_id)->first(['name', 'subcat_level_1_id']);
                if (isset($subcat_level_2)) {
                    $subcat_level_1_id = $subcat_level_2->subcat_level_1_id;
                    $subcat_level_1 = DB::table('subcat_level_1')->where('id', $subcat_level_1_id)->first(['name', 'category_id']);
                    if (isset($subcat_level_1)) {
                        // $category = DB::table('category')->where('id', $subcat_level_1->category_id)->first()->name;
                        $category = DB::table('category')->where('id', $subcat_level_1->category_id)->first();
                        if (isset($category)) {
                            $first_key = ucwords(str_replace("_"," ",$category->name));
                            $second_key = ucwords(str_replace("_"," ",$subcat_level_1->name));
                            $value = ucwords(str_replace("_"," ",$subcat_level_2->name));
                            $first_key_exist = array_key_exists($first_key, $categories);
                            $second_key_exist = array_key_exists($second_key, $categories);
                            if ($first_key_exist == 0 && $second_key_exist == 0) {
                                $categories[$first_key][$second_key] = $value;
                            }
                        }
                    }
                }
            } else if ($level == 3) {
                $category_id = $product->category_id;
                $subcat_level_3 = DB::table('subcat_level_3')->where('id', $category_id)->first(['name', 'subcat_level_2_id']);
                if (isset($subcat_level_3)) {
                    $subcat_level_2_id = $subcat_level_3->subcat_level_2_id;
                    $subcat_level_2 = DB::table('subcat_level_2')->where('id', $subcat_level_2_id)->first(['name', 'sub_cat_level_1_id']);
                    if (isset($subcat_level_2)) {
                        $subcat_level_1_id = $subcat_level_2->subcat_level_1_id;
                        $subcat_level_1 = DB::table('subcat_level_1')->where('id', $subcat_level_1_id)->first(['name', 'category_id']);
                        if (isset($subcat_level_1)) {
                            // $category = DB::table('category')->where('id', $subcat_level_1->category_id)->first()->name;
                            $category = DB::table('category')->where('id', $subcat_level_1->category_id)->first();
                            if (isset($category)) {
                                $first_key = ucwords(str_replace("_"," ",$category->name));
                                $second_key = ucwords(str_replace("_"," ",$subcat_level_1->name));
                                $third_key = ucwords(str_replace("_"," ",$subcat_level_2->name));
                                $value = ucwords(str_replace("_"," ",$subcat_level_3->name));
                                $first_key_exist = array_key_exists($first_key, $categories);
                                $second_key_exist = array_key_exists($second_key, $categories);
                                $third_key_exist = array_key_exists($third_key, $categories);
                                if ($first_key_exist == 0 && $second_key_exist == 0 && $third_key_exist == 0) {
                                    $categories[$first_key][$second_key][$third_key] = $value;
                                }
                            }
                        }
                    }
                }
            }  else if ($level == 4) {
                $category_id = $product->category_id;
                $subcat_level_4 = DB::table('subcat_level_4')->where('id', $category_id)->first(['name', 'subcat_level_3_id']);
                if (isset($subcat_level_4)) {
                    $subcat_level_3_id = $subcat_level_4->subcat_level_3_id;
                    $subcat_level_3 = DB::table('subcat_level_3')->where('id', $category_id)->first(['name', 'subcat_level_2_id']);
                    if (isset($subcat_level_3)) {
                        $subcat_level_2_id = $subcat_level_3->subcat_level_2_id;
                        $subcat_level_2 = DB::table('subcat_level_2')->where('id', $subcat_level_2_id)->first(['name', 'sub_cat_level_1_id']);
                        if (isset($subcat_level_2)) {
                            $subcat_level_1_id = $subcat_level_2->subcat_level_1_id;
                            $subcat_level_1 = DB::table('subcat_level_1')->where('id', $subcat_level_1_id)->first(['name', 'category_id']);
                            if (isset($subcat_level_1)) {
                                // $category = DB::table('category')->where('id', $subcat_level_1->category_id)->first()->name;
                                $category = DB::table('category')->where('id', $subcat_level_1->category_id)->first();
                                if (isset($category)) {
                                    $first_key = ucwords(str_replace("_"," ",$category->name));
                                    $second_key = ucwords(str_replace("_"," ",$subcat_level_1->name));
                                    $third_key = ucwords(str_replace("_"," ",$subcat_level_2->name));
                                    $fourth_key = ucwords(str_replace("_"," ",$subcat_level_3->name));
                                    $value = ucwords(str_replace("_"," ",$subcat_level_4->name));
                                    $first_key_exist = array_key_exists($first_key, $categories);
                                    $second_key_exist = array_key_exists($second_key, $categories);
                                    $third_key_exist = array_key_exists($third_key, $categories);
                                    $fourth_key_exist = array_key_exists($fourth_key, $categories);
                                    if ($first_key_exist == 0 && $second_key_exist == 0 && $third_key_exist == 0 && $third_key_exist == 0) {
                                        $categories[$first_key][$second_key][$third_key][$fourth_key] = $value;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // dd($categories);
        return $categories;
    }

    private function getProductsForDealers($id){
        try {
            $products = DB::select(DB::raw("
				SELECT p.* FROM product p, oshopproduct op, wholesale w, productdealer pd
				WHERE  p.oshop_selected = 1 AND op.oshop_id = $id AND ((p.id = w.product_id and w.price > 0)
				OR (p.id = pd.product_id and pd.special_price > 0))
				GROUP BY p.id"));
            foreach ($products as $product) {
                $special_price = ProductDealer::where('product_id', $product->id)->first(['special_funit', 'special_unit', 'special_price']);
                if($special_price){
                    $product->special_funit = $special_price->special_funit;
                    $product->special_unit = $special_price->special_unit;
                    $product->special_price = $special_price->special_price;
                }
            }
        } catch(Exception $e){
            throw new CustomException($e);
        }

        return $products;
    }

    private function getProductsForRegularUsers($id){
        try {
            $products = DB::select(DB::raw("SELECT p.* FROM product p, oshopproduct op WHERE p.oshop_selected = 1 AND op.oshop_id = $id AND p.display_non_autolink = true GROUP BY p.id"));
        } catch(Exception $e){
            throw new CustomException($e);
        }

        return $products;
    }

    private function getProductsForAnonymous($id){
        try {
            $products = DB::select(DB::raw("SELECT p.* FROM product p, oshopproduct op WHERE p.oshop_selected = 1 AND op.oshop_id = $id GROUP BY p.id"));
        } catch(Exception $e){
            throw new CustomException($e);
        }

        return $products;
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function aboutUs(Request $request, $id)
    {
        $merchant = Merchant::find($id);

        $profile = Merchant::withProfile($id);

        if(!$merchant){
            $request->session()->flash('message', 'Cant find these merchant');
            return redirect()->back();
        }

        return view('shops.oshopaboutus')->with('merchant', $merchant)->with('profile', $profile);
    }

    public function all_query(Request $request)
    {
        $r = $request->all();

        $id = $r['id'];
        $mid = $r['mid'];

        $merchant = Merchant::with('categories')->find($mid);

        if($r['tab_product'] == 'retail'){
            $categories = $merchant->categories;

            $categories = DB::select(DB::raw(
                "SELECT DISTINCT(category.id) as id, category.name, category.description, COUNT(product.id) as nprod
                FROM category
                JOIN product ON product.category_id = category.id
                JOIN oshopproduct ON oshopproduct.product_id = product.id
                WHERE oshopproduct.oshop_id = " . $id .  " AND
				product.oshop_selected = true AND
				product.available > 0  AND
				product.status = 'active'
                GROUP BY category.id
                ORDER BY nprod DESC"
            ));

			/*dd($categories);
			exit;*/

            $categoriesp = array();
            $b2bcategoriesp = array();
            $subcategoriesp = array();
            $p = 0;
            foreach($categories as $c){
                $subcategories = DB::select(DB::raw(
                    "SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name, subcat_level_1.description, COUNT(product.id) as nprod, product.subcat_level as subcat_level, product.subcat_id as subcat_id
                    FROM subcat_level_1
                    JOIN product ON product.subcat_id = subcat_level_1.id
                    JOIN oshopproduct ON oshopproduct.product_id = product.id
                    WHERE oshopproduct.oshop_id = " . $id . " AND subcat_level_1.category_id = " . $c->id . " AND product.status = 'active'
                    GROUP BY subcat_level_1.id
                    ORDER BY nprod DESC"
                ));

                    $products = array();

                $product_idsForaSection = DB::select(DB::raw("select p.* from merchantproduct mp, oshopproduct op, product p, merchant m where op.product_id=p.id and mp.product_id=p.id and mp.merchant_id=m.id and p.status = 'active' and p.oshop_selected=true and p.category_id =" .$c->id ." and op.oshop_id = " . $id .  " ORDER BY p.brand_id;"));

                    foreach ($product_idsForaSection as $product_id) {
                        $product=Product::find($product_id->id);
                        array_push($products, $product);
                    }

                    $categoriesp[$p] = $products;
                    $p++;


            }

			return view('oshop_retail_products_all')
                    ->with('categoriesp',$categoriesp)
                    ->with('categories',$categories);

        }else if($r['tab_product'] == 'B2B'){
            $categoriesb2b = DB::select(DB::raw(
                "SELECT DISTINCT(category.id) as id , category.name , category.description , COUNT(product.id) as nprod FROM category, wholesale, productdealer,product,product p2,oshopproduct WHERE product.category_id = category.id AND p2.parent_id = product.id AND p2.segment = 'b2b' AND oshopproduct.product_id = product.id AND product.oshop_selected = 1 AND oshopproduct.oshop_id = " . $id . " AND ((p2.id = wholesale.product_id and price > 0) OR (p2.id = productdealer.product_id and productdealer.special_price > 0)) GROUP BY category.id ORDER BY nprod DESC"
            ));
            $b2bcategoriesp = array();
            $categoriespb2b = array();
            $p = 0;
            foreach($categoriesb2b as $c){

                $b2bproducts = DB::select(DB::raw(
                    "SELECT p.*, p2.id as ssid
                     FROM product p, product p2,oshopproduct op, wholesale w, productdealer pd
                     WHERE op.oshop_id = " . $id . "
					 AND p2.parent_id = op.product_id
					 AND p2.parent_id = p.id
					 AND p2.segment = 'b2b' AND p2.available > 0
                     AND ((p2.id = w.product_id and price > 0)
                     OR (p2.id = pd.product_id and special_price > 0))
                     AND p.oshop_selected=true
                     AND p.status='active'
                     AND p.category_id= " . $c->id . "
                     GROUP BY p.id
					 ORDER BY p.brand_id"
                ));

                $b2bcategoriesp[$p] = $b2bproducts;

                $p++;
            }
            return view('oshop_b2b_products_all')
                ->with('b2bcategoriesp',$b2bcategoriesp)
                ->with('categoriesb2b',$categoriesb2b);
        }else if ($r['tab_product'] == 'smm'){
            $categories = $merchant->categories;

            $categories = DB::select(DB::raw(
                "SELECT DISTINCT(category.id) as id, category.name, category.description, COUNT(product.id) as nprod
                FROM category
                JOIN product ON product.category_id = category.id
                JOIN oshopproduct ON oshopproduct.product_id = product.id
                WHERE oshopproduct.oshop_id = " . $id .  "
                GROUP BY category.id
                ORDER BY nprod DESC"
            ));

			/*dd($categories);
			exit;*/
			$products = array();
            $categoriesp = array();
            $b2bcategoriesp = array();
            $subcategoriesp = array();
            $p = 0;
            foreach($categories as $c){
                $subcategories = DB::select(DB::raw(
                    "SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name, subcat_level_1.description, COUNT(product.id) as nprod, product.subcat_level as subcat_level, product.subcat_id as subcat_id
                    FROM subcat_level_1
                    JOIN product ON product.subcat_id = subcat_level_1.id
                    JOIN oshopproduct ON oshopproduct.product_id = product.id
                    WHERE oshopproduct.oshop_id = " . $id . " AND subcat_level_1.category_id = " . $c->id . "
                    GROUP BY subcat_level_1.id
                    ORDER BY nprod DESC"
                ));

                    

                $product_idsForaSection = DB::select(DB::raw("select p.* from merchantproduct mp,oshopproduct op, product p, merchant m where op.product_id=p.id and mp.product_id=p.id and mp.merchant_id=m.id and p.oshop_selected=true and p.smm_selected=true and p.category_id =" .$c->id ." and op.merchant_id = " . $id .  " ORDER BY p.brand_id;"));

                    foreach ($product_idsForaSection as $product_id) {
                        $product=Product::find($product_id->id);
                        array_push($products, $product);
                    }

                    $categoriesp[$p] = $products;
                    $p++;


            }

			return view('oshop_smm_products_all')
                    ->with('products',$products);
        } else if ($r['tab_product'] == 'hyper'){
            if(!Auth::check()){
				$role=False;
			} else {
				$role_user=DB::table('role_users')->where('user_id',Auth::user()->id)->pluck('role_id');
				$role=False;
				if ($role_user==2 || $role_user==11 || $role_user==3) {
				  # code...
				  $role=True;
				}
			}			
			$product_ids= DB::table('owarehouse')->lists('product_id');
			$data = Product::leftJoin('owarehouse as o','product.id','=','o.product_id')
                ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id')
							 ->where('op.status','=','executed');
                         })
                ->join('merchantproduct as mp','product.parent_id','=','mp.product_id')
                //->where('product.subcat_id','=',$id)
                ->whereIn('product.id',$product_ids)
                ->where('mp.merchant_id',$id)
                ->where('product.status','active')
                ->where('o.status','active')
                ->where('o.moq','>',0)
                ->where('product.owarehouse_moqperpax','>',0)
                ->where('product.owarehouse_price','>',0)
                ->where('product.oshop_selected',1)
                ->select(DB::raw('product.*,o.id as owarehouse_id,o.collection_price, product.parent_id as product_id,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
                ->groupBy('product.id')
                ->get();
				
            return view('oshop_hyper_products_all')
                    ->with('role',$role)
                    ->with('ow_product',$data);				
		}else if ($r['tab_product'] == 'voucher'){
		
		    $voucher_data=[];
			 $merchantvouchers= DB::table('merchantvoucher')->where('merchant_id', $id)->get();
			 if (!empty($merchantvouchers)){
				 foreach ($merchantvouchers as $v){
					 $vouchers = Voucher::where('id','=',$v->voucher_id)->orderBy('created_at', 'desc')->get();
					// $voucher_data = [];
					 foreach ($vouchers as $i) {
						 
						 //$temp['voucher_timeslot']=$i->timeSlots;
						 $product_id = $i->product_id;
						 $product = DB::table('product')->where('product.id', '=', $product_id)->first();
						 if (!is_null($product)) {
							 # code...
						$temp['voucher'] = $i;
						 $temp['voucher_product'] = $product;
						 $temp['voucher_timeslot'] = DB::table('timeslot')->select('*')->where('voucher_id', $i->id)->first();
						 $temp['voucher_address'] = $i->address;
						 if($product->segment == 'v1' || $product->segment == 'v2'){
							 if($product->segment == 'v1'){
								 if(!is_null($temp['voucher_timeslot'])){
									  $voucher_data[] = $temp;
								 }
							 } else {
								 $voucher_data[] = $temp;
							 }   
						 }  
						 }
			 
					 }
				 }
			 }
            return view('oshop_voucher_products_all')
                    ->with('merchantvouchers',$voucher_data);		 
		}

    }

    public function category_query(Request $request)
    {
        $r = $request->all();

        $id = $r['id'];
        $cid = $r['category_id'];

        $category = DB::table('category')->where('id', $cid)->first();

        $subcategoriesp = array();

        if($r['tab_product'] == 'retail'){

            $subcategories = DB::select(DB::raw(
				"SELECT id, COUNT(nprod) as nprod, name, description FROM 
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name,
				subcat_level_1.description as description, product.id as nprod
				FROM subcat_level_1
				JOIN product ON product.subcat_id = subcat_level_1.id AND product.subcat_level = 1
				JOIN oshopproduct ON oshopproduct.product_id = product.id
				WHERE oshopproduct.oshop_id = " . $id .
					" AND subcat_level_1.category_id = " . $cid . "
					AND product.oshop_selected = true
					AND product.retail_price > 0
					AND product.available > 0
					AND product.status ='active' AND product.segment = 'b2c'					
					UNION				
					SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
									JOIN oshopproduct ON oshopproduct.product_id = product.id
									WHERE oshopproduct.oshop_id = " . $id .
					" AND subcat_level_1.category_id = " . $cid . "
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0
										AND product.status ='active' AND product.segment = 'b2c'
						GROUP BY id				
										
					UNION				
					SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
									JOIN oshopproduct ON oshopproduct.product_id = product.id
									WHERE oshopproduct.oshop_id = " . $id .
					" AND subcat_level_1.category_id = " . $cid . "
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0	
                                        AND product.status ='active' AND product.segment = 'b2c'
						GROUP BY id
					) as T
					GROUP BY id
					ORDER BY nprod DESC"
			));

            //$p = 0;
            foreach($subcategories as $sc){
                $products = array();

                $product_idsForaSection=DB::select(DB::raw(
				"SELECT id, nprod, name, description FROM 
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name,
				subcat_level_1.description as description, product.id as nprod
				FROM subcat_level_1
				JOIN product ON product.subcat_id = subcat_level_1.id AND product.subcat_level = 1
				JOIN oshopproduct ON oshopproduct.product_id = product.id
				WHERE oshopproduct.oshop_id = " . $id .
					" AND subcat_level_1.id = " . $sc->id . "
					AND product.oshop_selected = true
					AND product.retail_price > 0
					AND product.available > 0
					AND product.status ='active' AND product.segment = 'b2c'					
					UNION				
					SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
									JOIN oshopproduct ON oshopproduct.product_id = product.id
									WHERE oshopproduct.oshop_id = " . $id .
					" AND subcat_level_1.id = " . $sc->id . "
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0
										AND product.status ='active' AND product.segment = 'b2c'
						
										
					UNION				
					SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
									JOIN oshopproduct ON oshopproduct.product_id = product.id
									WHERE oshopproduct.oshop_id = " . $id .
					" AND subcat_level_1.id = " . $sc->id . "
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0	
                                        AND product.status ='active' AND product.segment = 'b2c'
						
					) as T
					ORDER BY nprod DESC"
			));
				//dd($product_idsForaSection);
                foreach ($product_idsForaSection as $product_id) {
                    $product=Product::find($product_id->nprod);
                    array_push($products, $product);
                }

                array_push($subcategoriesp, $products);
                //$subcategoriesp[$p] = $products;
                //$p++;

            }
			//dd($subcategoriesp);
            return view('oshop_retail_products_category')
                    ->with('subcategoriesp',$subcategoriesp)
                    ->with('subcategories',$subcategories)
                    ->with('category',$category);

        }else if($r['tab_product'] == 'B2B'){
			/*dd($cid);
			exit;*/
            $subcategoriesb2b = DB::select(DB::raw(
                "SELECT id, COUNT(nprod) as nprod, name, description FROM 					
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name, subcat_level_1.description as description, 
								product.id as nprod
								FROM subcat_level_1 
								JOIN product ON product.subcat_id = subcat_level_1.id  AND product.subcat_level = 1
								JOIN oshopproduct ON oshopproduct.product_id = product.id 
								JOIN product as p2 ON product.id = p2.parent_id AND p2.segment = 'b2b' AND p2.available > 0 
								JOIN wholesale ON wholesale.product_id = p2.id LEFT JOIN productdealer ON productdealer.product_id = p2.id 
								WHERE oshopproduct.oshop_id = " . $id . " AND subcat_level_1.category_id = " . $cid . " 
								AND ((p2.id = wholesale.product_id and price > 0) OR (p2.id = productdealer.product_id and productdealer.special_price > 0)) AND product.status ='active' AND product.deleted_at IS NULL
								and product.oshop_selected=true 
								UNION
				SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name, subcat_level_1.description as description, 
								product.id as nprod
								FROM subcat_level_1 
								JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
								JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
								JOIN oshopproduct ON oshopproduct.product_id = product.id 
								JOIN product as p2 ON product.id = p2.parent_id AND p2.segment = 'b2b'  AND p2.available > 0
								JOIN wholesale ON wholesale.product_id = p2.id LEFT JOIN productdealer ON productdealer.product_id = p2.id 
								WHERE oshopproduct.oshop_id = " . $id . " AND subcat_level_1.category_id = " . $cid . " 
								AND ((p2.id = wholesale.product_id and price > 0) OR (p2.id = productdealer.product_id and productdealer.special_price > 0)) AND product.status ='active' AND product.deleted_at IS NULL 
								and product.oshop_selected=true 
								UNION
				SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name, subcat_level_1.description as description, 
								product.id as nprod
								FROM subcat_level_1 
								JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
								JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
								JOIN oshopproduct ON oshopproduct.product_id = product.id 
								JOIN product as p2 ON product.id = p2.parent_id AND p2.segment = 'b2b'  AND p2.available > 0
								JOIN wholesale ON wholesale.product_id = p2.id LEFT JOIN productdealer ON productdealer.product_id = p2.id 
								WHERE oshopproduct.oshop_id = " . $id . " AND subcat_level_1.category_id = " . $cid . " 
								AND ((p2.id = wholesale.product_id and price > 0) OR (p2.id = productdealer.product_id and productdealer.special_price > 0)) AND product.status ='active' AND product.deleted_at IS NULL
								and product.oshop_selected=true				
									
				) as T
				GROUP BY id
				ORDER BY nprod DESC	"
            ));
			//dd($subcategoriesb2b);
            foreach($subcategoriesb2b as $sb2b){
                $productsb2b = array();

                $product_idsForaSection=DB::select(DB::raw(
                "SELECT id, nprod, name, description, ssid FROM 					
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name, subcat_level_1.description as description, 
								product.id as nprod, p2.id as ssid
								FROM subcat_level_1 
								JOIN product ON product.subcat_id = subcat_level_1.id  AND product.subcat_level = 1
								JOIN oshopproduct ON oshopproduct.product_id = product.id 
								JOIN product as p2 ON product.id = p2.parent_id AND p2.segment = 'b2b' AND p2.available > 0 
								JOIN wholesale ON wholesale.product_id = p2.id LEFT JOIN productdealer ON productdealer.product_id = p2.id 
								WHERE oshopproduct.oshop_id = " . $id . " AND subcat_level_1.category_id = " . $cid . " AND subcat_level_1.id = " . $sb2b->id . "
								AND ((p2.id = wholesale.product_id and price > 0) OR (p2.id = productdealer.product_id and productdealer.special_price > 0)) AND product.status ='active' AND product.deleted_at IS NULL
								and product.oshop_selected=true 
								UNION
				SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name, subcat_level_1.description as description, 
								product.id as nprod, p2.id as ssid
								FROM subcat_level_1 
								JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
								JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
								JOIN oshopproduct ON oshopproduct.product_id = product.id 
								JOIN product as p2 ON product.id = p2.parent_id AND p2.segment = 'b2b'  AND p2.available > 0
								JOIN wholesale ON wholesale.product_id = p2.id LEFT JOIN productdealer ON productdealer.product_id = p2.id 
								WHERE oshopproduct.oshop_id = " . $id . " AND subcat_level_1.category_id = " . $cid . " AND subcat_level_1.id = " . $sb2b->id . "
								AND ((p2.id = wholesale.product_id and price > 0) OR (p2.id = productdealer.product_id and productdealer.special_price > 0)) AND product.status ='active' AND product.deleted_at IS NULL 
								and product.oshop_selected=true 
								UNION
				SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name, subcat_level_1.description as description, 
								product.id as nprod, p2.id as ssid
								FROM subcat_level_1 
								JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
								JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
								JOIN oshopproduct ON oshopproduct.product_id = product.id 
								JOIN product as p2 ON product.id = p2.parent_id AND p2.segment = 'b2b'  AND p2.available > 0
								JOIN wholesale ON wholesale.product_id = p2.id LEFT JOIN productdealer ON productdealer.product_id = p2.id 
								WHERE oshopproduct.oshop_id = " . $id . " AND subcat_level_1.category_id = " . $cid . " AND subcat_level_1.id = " . $sb2b->id . " 
								AND ((p2.id = wholesale.product_id and price > 0) OR (p2.id = productdealer.product_id and productdealer.special_price > 0)) AND product.status ='active' AND product.deleted_at IS NULL
								and product.oshop_selected=true				
									
				) as T
				GROUP BY id
				ORDER BY nprod DESC	"
            ));

                foreach ($product_idsForaSection as $product_id) {
                 //   dd($product_idsForaSection);
					$product=Product::find($product_id->nprod);
                    $product->ssid = $product_id->ssid;
                    array_push($productsb2b, $product);
                }

                array_push($subcategoriesp, $productsb2b);
                //$subcategoriesp[$p] = $products;
                //$p++;
            }

			//dd($subcategoriesp);
			return view('oshop_b2b_products_category')
                ->with('subcategoriesp',$subcategoriesp)
                ->with('subcategoriesb2b',$subcategoriesb2b)
                ->with('category',$category);
        }else if ($r['tab_product'] == 'smm'){
			
            $subcategories = DB::select(DB::raw(
                "SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name, subcat_level_1.description, COUNT(product.id) as nprod, product.subcat_level as subcat_level, product.subcat_id as subcat_id
                FROM subcat_level_1
                JOIN product ON product.subcat_id = subcat_level_1.id
                JOIN oshopproduct ON oshopproduct.product_id = product.id
                WHERE oshopproduct.oshop_id = " . $id . " AND subcat_level_1.category_id = " . $cid . "
                GROUP BY subcat_level_1.id
                ORDER BY nprod DESC"
            ));
            //$p = 0;
			$products = array();
            foreach($subcategories as $sc){
                

                $product_idsForaSection=DB::table('oshopproduct')
                ->join('product','oshopproduct.product_id','=','product.id')
                ->where('oshopproduct.merchant_id',$id)
                ->where('product.oshop_selected','=',true)
                ->where('product.smm_selected','=',true)
                ->where('product.subcat_id',$sc->id)
                ->orderBy('product.brand_id','ASC')
                ->get();

                foreach ($product_idsForaSection as $product_id) {
                    $product=Product::find($product_id->id);
                    array_push($products, $product);
                }

                array_push($subcategoriesp, $products);				
			}			

            return view('oshop_smm_products_category')
                    ->with('products',$products)
                    ->with('subcategoriesp',$subcategoriesp)
                    ->with('subcategories',$subcategories)
                    ->with('category',$category);
        }else if ($r['tab_product'] == 'hyper'){
            if(!Auth::check()){
				$role=False;
			} else {
				$role_user=DB::table('role_users')->where('user_id',Auth::user()->id)->pluck('role_id');
				$role=False;
				if ($role_user==2 || $role_user==11 || $role_user==3) {
				  # code...
				  $role=True;
				}
			}			
			$product_ids= DB::table('owarehouse')->lists('product_id');
			$data = Product::leftJoin('owarehouse as o','product.id','=','o.product_id')
                ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id')
							 ->where('op.status','=','executed');
                         })
                ->join('merchantproduct as mp','product.parent_id','=','mp.product_id')
                //->where('product.subcat_id','=',$id)
                ->whereIn('product.id',$product_ids)
                ->where('mp.merchant_id',$id)
                ->where('product.status','active')
                ->where('product.category_id',$cid)
                ->where('o.status','active')
                ->where('o.moq','>',0)
                ->where('product.owarehouse_moqperpax','>',0)
                ->where('product.owarehouse_price','>',0)
                ->where('product.oshop_selected',1)
                ->select(DB::raw('product.*,o.id as owarehouse_id,o.collection_price, product.parent_id as product_id,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
                ->groupBy('product.id')
                ->get();
				
            return view('oshop_hyper_products_category')
                    ->with('role',$role)
                    ->with('ow_product',$data)
                    ->with('category',$category);				
		}else if ($r['tab_product'] == 'voucher'){
		
		    $voucher_data=[];
			 $merchantvouchers= DB::table('merchantvoucher')->where('merchant_id', $id)->get();
			 if (!empty($merchantvouchers)){
				 foreach ($merchantvouchers as $v){
					 $vouchers = Voucher::where('id','=',$v->voucher_id)->orderBy('created_at', 'desc')->get();
					// $voucher_data = [];
					 foreach ($vouchers as $i) {
						 
						 //$temp['voucher_timeslot']=$i->timeSlots;
						 $product_id = $i->product_id;
						 $product = DB::table('product')->where('product.id', '=', $product_id)->where('product.category_id',$cid)->first();
						 if (!is_null($product)) {
							 # code...
						$temp['voucher'] = $i;
						 $temp['voucher_product'] = $product;
						 $temp['voucher_timeslot'] = DB::table('timeslot')->select('*')->where('voucher_id', $i->id)->first();
						 $temp['voucher_address'] = $i->address;
						 if($product->segment == 'v1' || $product->segment == 'v2'){
							 if($product->segment == 'v1'){
								 if(!is_null($temp['voucher_timeslot'])){
									  $voucher_data[] = $temp;
								 }
							 } else {
								 $voucher_data[] = $temp;
							 }   
						 }  
						 }
			 
					 }
				 }
			 }
            return view('oshop_voucher_products_category')
                    ->with('merchantvouchers',$voucher_data)
					->with('category',$category);		 
		}

    }

    public function sub_category_query(Request $request)
    {
        $r = $request->all();

        $id = $r['id'];
        $scid = $r['sub_category_id'];

        $subcategory = DB::table('subcat_level_1')->where('id', $scid)->first();
        $category = DB::table('category')->where('id', $subcategory->category_id)->first();
		/*dd($category);
		exit;*/
        /*
         * B2B
         */
        $category_id = $r['id'];

        if($r['tab_product'] == 'retail'){
            $products = array();

			$product_idsForaSection=DB::select(DB::raw("SELECT p.id
                     FROM oshopproduct op, product p
					LEFT JOIN subcat_level_2 ON (p.subcat_id = subcat_level_2.id AND p.subcat_level = 2) 
					LEFT JOIN subcat_level_3 ON (p.subcat_id = subcat_level_3.id AND p.subcat_level = 3)					 
                     WHERE op.oshop_id = " . $id . "
                     AND p.oshop_selected=true
					 AND p.id = op.product_id
					 AND p.status = 'active'
                     AND ((p.subcat_id= " . $scid . " AND p.subcat_level = 1) 
					 OR (subcat_level_2.subcat_level_1_id = " . $scid . " AND p.subcat_level = 2) 
					 OR (subcat_level_3.subcat_level_1_id = " . $scid . " AND p.subcat_level = 3))
					 ORDER BY p.brand_id"));
        /*    $product_idsForaSection=DB::table('oshopproduct')
                ->join('product','oshopproduct.product_id','=','product.id')
                ->where('oshopproduct.merchant_id',$id)
                ->where('product.oshop_selected','=',true)
                ->where('product.subcat_id',$scid)
                ->orderBy('product.brand_id','ASC')
                ->get();*/

            foreach ($product_idsForaSection as $product_id) {
                $product=Product::find($product_id->id);		
                array_push($products, $product);
            }
            return view('oshop_retail_products_subcategory')
                ->with('products',$products)
                ->with('category',$category)
                ->with('subcategory',$subcategory);

        }else if($r['tab_product'] == 'B2B'){
            $categoriesb2b =  DB::table('subcat_level_1')->where('id', $scid)->get();
            $categoriespb2b = array();
            $p = 0;
            foreach($categoriesb2b as $c){

                $b2bproducts = DB::select(DB::raw(
                    "SELECT p.*, p2.id as ssid
                     FROM product p2, oshopproduct op, wholesale w, productdealer pd, product p
					 LEFT JOIN subcat_level_2 ON (p.subcat_id = subcat_level_2.id AND p.subcat_level = 2) 
					 LEFT JOIN subcat_level_3 ON (p.subcat_id = subcat_level_3.id AND p.subcat_level = 3)			
                     WHERE op.oshop_id = " . $id . "
					 AND p2.parent_id = op.product_id
                     AND p2.parent_id = p.id
                     AND p2.segment = 'b2b' AND p2.available > 0
                     AND ((p2.id = w.product_id and price > 0)
                     OR (p2.id = pd.product_id and special_price > 0))
                     AND p.oshop_selected=true
                     AND ((p.subcat_id= " . $scid . " AND p.subcat_level = 1) 
					 OR (subcat_level_2.subcat_level_1_id = " . $scid . " AND p.subcat_level = 2) 
					 OR (subcat_level_3.subcat_level_1_id = " . $scid . " AND p.subcat_level = 3))
                     GROUP BY p.id
					 ORDER BY p.brand_id"
                ));

                $b2bcategoriesp[$p] = $b2bproducts;

                $p++;
            }
            return view('oshop_b2b_products_subcategory')
                ->with('b2bcategoriesp',$b2bcategoriesp)
				->with('categoryo',$category)
                ->with('categoriesb2b',$categoriesb2b);

        }else if ($r['tab_product'] == 'smm'){
            $products = array();

			$product_idsForaSection=DB::select(DB::raw("SELECT p.id
                     FROM oshopproduct op, product p
					LEFT JOIN subcat_level_2 ON (p.subcat_id = subcat_level_2.id AND p.subcat_level = 2) 
					LEFT JOIN subcat_level_3 ON (p.subcat_id = subcat_level_3.id AND p.subcat_level = 3)					 
                     WHERE op.oshop_id = " . $id . "
                     AND p.oshop_selected=true
                     AND p.smm_selected=true
					 AND p.id = op.product_id
                     AND ((p.subcat_id= " . $scid . " AND p.subcat_level = 1) 
					 OR (subcat_level_2.subcat_level_1_id = " . $scid . " AND p.subcat_level = 2) 
					 OR (subcat_level_3.subcat_level_1_id = " . $scid . " AND p.subcat_level = 3))
					 ORDER BY p.brand_id"));

            foreach ($product_idsForaSection as $product_id) {
                $product=Product::find($product_id->id);		
                array_push($products, $product);
            }
            return view('oshop_smm_products_subcategory')
                ->with('products',$products)
                ->with('category',$category)
                ->with('subcategory',$subcategory);
        }else if ($r['tab_product'] == 'hyper'){
            if(!Auth::check()){
				$role=False;
			} else {
				$role_user=DB::table('role_users')->where('user_id',Auth::user()->id)->pluck('role_id');
				$role=False;
				if ($role_user==2 || $role_user==11 || $role_user==3) {
				  # code...
				  $role=True;
				}
			}			
			$product_ids= DB::table('owarehouse')->lists('product_id');
			$data = Product::leftJoin('owarehouse as o','product.id','=','o.product_id')
                ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id')
							 ->where('op.status','=','executed');
                         })
                ->join('merchantproduct as mp','product.parent_id','=','mp.product_id')
                //->where('product.subcat_id','=',$id)
                ->whereIn('product.id',$product_ids)
                ->where('mp.merchant_id',$id)
                ->where('product.status','active')
                ->where('product.subcat_id',$scid)
                ->where('o.status','active')
                ->where('o.moq','>',0)
                ->where('product.owarehouse_moqperpax','>',0)
                ->where('product.owarehouse_price','>',0)
                ->where('product.oshop_selected',1)
                ->select(DB::raw('product.*,o.id as owarehouse_id,o.collection_price, product.parent_id as product_id,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
                ->groupBy('product.id')
                ->get();
				
            return view('oshop_hyper_products_subcategory')
                    ->with('role',$role)
                    ->with('ow_product',$data)
                    ->with('category',$category)				
                    ->with('subcategory',$subcategory);				
		}  else if ($r['tab_product'] == 'voucher'){
		
		    $voucher_data=[];
			 $merchantvouchers= DB::table('merchantvoucher')->where('merchant_id', $id)->get();
			 if (!empty($merchantvouchers)){
				 foreach ($merchantvouchers as $v){
					 $vouchers = Voucher::where('id','=',$v->voucher_id)->orderBy('created_at', 'desc')->get();
					// $voucher_data = [];
					 foreach ($vouchers as $i) {
						 
						 //$temp['voucher_timeslot']=$i->timeSlots;
						 $product_id = $i->product_id;
						 $product = DB::table('product')->where('product.id', '=', $product_id)->where('product.subcat_id',$scid)->first();
						 if (!is_null($product)) {
							 # code...
						$temp['voucher'] = $i;
						 $temp['voucher_product'] = $product;
						 $temp['voucher_timeslot'] = DB::table('timeslot')->select('*')->where('voucher_id', $i->id)->first();
						 $temp['voucher_address'] = $i->address;
						 if($product->segment == 'v1' || $product->segment == 'v2'){
							 if($product->segment == 'v1'){
								 if(!is_null($temp['voucher_timeslot'])){
									  $voucher_data[] = $temp;
								 }
							 } else {
								 $voucher_data[] = $temp;
							 }   
						 }  
						 }
			 
					 }
				 }
			 }
            return view('oshop_voucher_products_subcategory')
                    ->with('merchantvouchers',$voucher_data)
					->with('category',$category)				
                    ->with('subcategory',$subcategory);		 
		}

    }

    public function color_query(Request $request)
    {
        $r = $request->all();

        $id = $r['id'];
        $cid = $r['color_id'];

        $color = DB::table('color')->where('id', $cid)->first();
        $colorsp = array();

        if($r['tab_product'] == 'retail'){
            $products = array();

			$product_idsForaSection=DB::select(DB::raw("SELECT p.id
                     FROM oshopproduct op, product p
					 JOIN productcolor pc ON pc.product_id = p.id 
					 JOIN color col ON col.id = pc.color_id 				 
                     WHERE op.oshop_id = " . $id . "
                     AND p.oshop_selected=true
					 AND p.status = 'active'
					 AND p.id = op.product_id
                     AND col.id = " . $cid . " 
					 ORDER BY p.brand_id"));

            foreach ($product_idsForaSection as $product_id) {
                $product=Product::find($product_id->id);		
                array_push($products, $product);
            }
            return view('oshop_retail_products_color')
                ->with('color',$color)
                ->with('products',$products);

        }else if($r['tab_product'] == 'B2B'){
			
        }else if ($r['tab_product'] == 'smm'){
            //$smmProducts=array();
        }

    }		
	
    public function brand_query(Request $request)
    {
        $r = $request->all();

        $id = $r['id'];
        $bid = $r['brand_id'];

        $brand = DB::table('brand')->where('id', $bid)->first();
        $colorsp = array();

        if($r['tab_product'] == 'retail'){
            $products = array();

			$product_idsForaSection=DB::select(DB::raw("SELECT p.id
                     FROM oshopproduct op, product p
					 JOIN brand bra ON bra.id = p.brand_id 				 
                     WHERE op.oshop_id = " . $id . "
                     AND p.oshop_selected=true
					 AND p.available > 0
					 AND p.status='active'
					 AND p.retail_price > 0
					 AND p.segment='b2c'
					 AND p.id = op.product_id
                     AND bra.id = " . $bid . " 
					 ORDER BY p.brand_id"));

            foreach ($product_idsForaSection as $product_id) {
                $product=Product::find($product_id->id);		
                array_push($products, $product);
            }

            return view('oshop_retail_products_brand')
                ->with('brand',$brand)
                ->with('products',$products);

        }else if($r['tab_product'] == 'B2B'){
            $brandspb2b = array();
            $p = 0;

			$products = DB::select(DB::raw(
				"SELECT p.*, p2.id as ssid
				 FROM product p2, oshopproduct op, wholesale w, productdealer pd, product p
				 LEFT JOIN subcat_level_2 ON (p.subcat_id = subcat_level_2.id AND p.subcat_level = 2) 
				 LEFT JOIN subcat_level_3 ON (p.subcat_id = subcat_level_3.id AND p.subcat_level = 3)			
				 WHERE op.oshop_id = " . $id . "
				 AND p2.parent_id = op.product_id
				 AND p2.parent_id = p.id
				 AND p2.segment = 'b2b' AND p2.available > 0
				 AND ((p2.id = w.product_id and price > 0)
				 OR (p2.id = pd.product_id and special_price > 0))
				 AND p.oshop_selected=true
				 AND p.brand_id= " . $brand->id . "
				 GROUP BY p.id
				 ORDER BY p.brand_id"
			));
 
            return view('oshop_b2b_products_brand')
                ->with('products',$products)
				->with('brand',$brand);			
        }else if ($r['tab_product'] == 'smm'){
           $products = array();

			$product_idsForaSection=DB::select(DB::raw("SELECT p.id
                     FROM oshopproduct op, product p
					 JOIN brand bra ON bra.id = p.brand_id 				 
                     WHERE op.oshop_id = " . $id . "
                     AND p.oshop_selected=true
                     AND p.smm_selected=true
					 AND p.id = op.product_id
                     AND bra.id = " . $bid . " 
					 ORDER BY p.brand_id"));

            foreach ($product_idsForaSection as $product_id) {
                $product=Product::find($product_id->id);		
                array_push($products, $product);
            }
            return view('oshop_smm_products_brand')
                ->with('brand',$brand)
                ->with('products',$products);
        }else if ($r['tab_product'] == 'hyper'){
            if(!Auth::check()){
				$role=False;
			} else {
				$role_user=DB::table('role_users')->where('user_id',Auth::user()->id)->pluck('role_id');
				$role=False;
				if ($role_user==2 || $role_user==11 || $role_user==3) {
				  # code...
				  $role=True;
				}
			}			
			$product_ids= DB::table('owarehouse')->lists('product_id');
			$data = Product::leftJoin('owarehouse as o','product.id','=','o.product_id')
                ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id')
							 ->where('op.status','=','executed');
                         })
                ->join('merchantproduct as mp','product.parent_id','=','mp.product_id')
                //->where('product.subcat_id','=',$id)
                ->whereIn('product.id',$product_ids)
                ->where('mp.merchant_id',$id)
                ->where('product.status','active')
                ->where('product.brand_id',$bid)
                ->where('o.status','active')
                ->where('o.moq','>',0)
                ->where('product.owarehouse_moqperpax','>',0)
                ->where('product.owarehouse_price','>',0)
                ->where('product.oshop_selected',1)
                ->select(DB::raw('product.*,o.id as owarehouse_id,o.collection_price, product.parent_id as product_id,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
                ->groupBy('product.id')
                ->get();
				
            return view('oshop_hyper_products_brand')
                    ->with('role',$role)
                    ->with('ow_product',$data)
                    ->with('brand',$brand);				
		}  else if ($r['tab_product'] == 'voucher'){
		
		    $voucher_data=[];
			 $merchantvouchers= DB::table('merchantvoucher')->where('merchant_id', $id)->get();
			 if (!empty($merchantvouchers)){
				 foreach ($merchantvouchers as $v){
					 $vouchers = Voucher::where('id','=',$v->voucher_id)->orderBy('created_at', 'desc')->get();
					// $voucher_data = [];
					 foreach ($vouchers as $i) {
						 
						 //$temp['voucher_timeslot']=$i->timeSlots;
						 $product_id = $i->product_id;
						 $product = DB::table('product')->where('product.id', '=', $product_id)->where('product.brand_id',$bid)->first();
						 if (!is_null($product)) {
							 # code...
						$temp['voucher'] = $i;
						 $temp['voucher_product'] = $product;
						 $temp['voucher_timeslot'] = DB::table('timeslot')->select('*')->where('voucher_id', $i->id)->first();
						 $temp['voucher_address'] = $i->address;
						 if($product->segment == 'v1' || $product->segment == 'v2'){
							 if($product->segment == 'v1'){
								 if(!is_null($temp['voucher_timeslot'])){
									  $voucher_data[] = $temp;
								 }
							 } else {
								 $voucher_data[] = $temp;
							 }   
						 }  
						 }
			 
					 }
				 }
			 }
            return view('oshop_voucher_products_brand')
                    ->with('merchantvouchers',$voucher_data)
					->with('brand',$brand);		 
		}

    }	
	
    public function subcatlevel2_query(Request $request)
    {
        $r = $request->all();

        $id = $r['id'];
        $sid = $r['subcatlevel_id'];

        $subcat2 = DB::table('subcat_level_2')->where('id', $sid)->first();
        $colorsp = array();

        if($r['tab_product'] == 'retail'){
            $products = array();

			$product_idsForaSection=DB::select(DB::raw("SELECT p.id
                     FROM oshopproduct op, product p
					 LEFT JOIN subcat_level_2 sub ON sub.id = p.subcat_id AND p.subcat_level = 2 				 
					 LEFT JOIN subcat_level_3 as s3 ON s3.id = p.subcat_id AND p.subcat_level = 3				 
					 LEFT JOIN subcat_level_2 as s2 ON s2.id = s3.subcat_level_2_id 				 
                     WHERE op.oshop_id = " . $id . "
                     AND p.oshop_selected=true
					 AND p.id = op.product_id
					 AND p.status = 'active'
                     AND (sub.id = " . $sid . " OR s2.id = " . $sid . ")
					 ORDER BY p.brand_id"));

            foreach ($product_idsForaSection as $product_id) {
                $product=Product::find($product_id->id);		
                array_push($products, $product);
            }
            return view('oshop_retail_products_subcat2')
                ->with('subcat2',$subcat2)
                ->with('products',$products);

        }else if($r['tab_product'] == 'B2B'){
            $products = array();

			$products=DB::select(DB::raw("SELECT p.*, p2.id as ssid
                     FROM product p2, oshopproduct op, wholesale w, productdealer pd, product p
					 LEFT JOIN subcat_level_2 sub ON sub.id = p.subcat_id AND p.subcat_level = 2 				 
					 LEFT JOIN subcat_level_3 as s3 ON s3.id = p.subcat_id AND p.subcat_level = 3				 
					 LEFT JOIN subcat_level_2 as s2 ON s2.id = s3.subcat_level_2_id 				 
                     WHERE op.oshop_id = " . $id . "
					 AND p2.parent_id = op.product_id
					 AND p2.parent_id = p.id
					 AND p2.segment = 'b2b' AND p2.available > 0
					 AND ((p2.id = w.product_id and price > 0)
					 OR (p2.id = pd.product_id and special_price > 0))
					 AND p.oshop_selected=true
                     AND (sub.id = " . $sid . " OR s2.id = " . $sid . ")
					 GROUP BY p.id
					ORDER BY p.brand_id"));
					
			return view('oshop_b2b_products_subcat2')
                ->with('subcat2',$subcat2)
                ->with('products',$products);
			
        }else if ($r['tab_product'] == 'smm'){
            $products = array();

			$product_idsForaSection=DB::select(DB::raw("SELECT p.id
                     FROM oshopproduct op, product p
					 LEFT JOIN subcat_level_2 sub ON sub.id = p.subcat_id AND p.subcat_level = 2 				 
					 LEFT JOIN subcat_level_3 as s3 ON s3.id = p.subcat_id AND p.subcat_level = 3				 
					 LEFT JOIN subcat_level_2 as s2 ON s2.id = s3.subcat_level_2_id 				 
                     WHERE op.oshop_id = " . $id . "
                     AND p.oshop_selected=true
                     AND p.smm_selected=true
					 AND p.id = op.product_id
                     AND (sub.id = " . $sid . " OR s2.id = " . $sid . ")
					 ORDER BY p.brand_id"));

            foreach ($product_idsForaSection as $product_id) {
                $product=Product::find($product_id->id);		
                array_push($products, $product);
            }
            return view('oshop_smm_products_subcat2')
                ->with('subcat2',$subcat2)
                ->with('products',$products);
        }else if ($r['tab_product'] == 'hyper'){
            if(!Auth::check()){
				$role=False;
			} else {
				$role_user=DB::table('role_users')->where('user_id',Auth::user()->id)->pluck('role_id');
				$role=False;
				if ($role_user==2 || $role_user==11 || $role_user==3) {
				  # code...
				  $role=True;
				}
			}			
			$product_ids= DB::table('owarehouse')->lists('product_id');
			$data = Product::leftJoin('owarehouse as o','product.id','=','o.product_id')
                ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id')
							 ->where('op.status','=','executed');
                         })
                ->join('merchantproduct as mp','product.parent_id','=','mp.product_id')
                //->where('product.subcat_id','=',$id)
                ->whereIn('product.id',$product_ids)
                ->where('mp.merchant_id',$id)
                ->where('product.status','active')
                ->where('product.subcat_id',$sid)
				->where('product.subcat_level','2')
                ->where('o.status','active')
                ->where('o.moq','>',0)
                ->where('product.owarehouse_moqperpax','>',0)
                ->where('product.owarehouse_price','>',0)
                ->where('product.oshop_selected',1)
                ->select(DB::raw('product.*,o.id as owarehouse_id,o.collection_price, product.parent_id as product_id,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
                ->groupBy('product.id')
                ->get();
				
            return view('oshop_hyper_products_subcat2')
                    ->with('role',$role)
                    ->with('ow_product',$data)
                    ->with('subcat2',$subcat2);				
		} else if ($r['tab_product'] == 'voucher'){
		
		    $voucher_data=[];
			 $merchantvouchers= DB::table('merchantvoucher')->where('merchant_id', $id)->get();
			 if (!empty($merchantvouchers)){
				 foreach ($merchantvouchers as $v){
					 $vouchers = Voucher::where('id','=',$v->voucher_id)->orderBy('created_at', 'desc')->get();
					// $voucher_data = [];
					 foreach ($vouchers as $i) {
						 
						 //$temp['voucher_timeslot']=$i->timeSlots;
						 $product_id = $i->product_id;
						 $product = DB::table('product')->where('product.id', '=', $product_id)->where('product.subcat_id',$sid)->where('product.subcat_level','2')->first();
						 if (!is_null($product)) {
							 # code...
						$temp['voucher'] = $i;
						 $temp['voucher_product'] = $product;
						 $temp['voucher_timeslot'] = DB::table('timeslot')->select('*')->where('voucher_id', $i->id)->first();
						 $temp['voucher_address'] = $i->address;
						 if($product->segment == 'v1' || $product->segment == 'v2'){
							 if($product->segment == 'v1'){
								 if(!is_null($temp['voucher_timeslot'])){
									  $voucher_data[] = $temp;
								 }
							 } else {
								 $voucher_data[] = $temp;
							 }   
						 }  
						 }
			 
					 }
				 }
			 }
            return view('oshop_voucher_products_subcat2')
                    ->with('merchantvouchers',$voucher_data)
					->with('subcat2',$subcat2);		 
		}

    }	
	
    public function subcatlevel3_query(Request $request)
    {
        $r = $request->all();

        $id = $r['id'];
        $sid = $r['subcatlevel_id'];

        $subcat2 = DB::table('subcat_level_3')->where('id', $sid)->first();
		$subcat = DB::table('subcat_level_2')->where('id', $subcat2->subcat_level_2_id)->first();
        $colorsp = array();

        if($r['tab_product'] == 'retail'){
            $products = array();

			$product_idsForaSection=DB::select(DB::raw("SELECT p.id
                     FROM oshopproduct op, product p
					 JOIN subcat_level_3 sub ON sub.id = p.subcat_id AND p.subcat_level = 3 				 
                     WHERE op.oshop_id = " . $id . "
                     AND p.oshop_selected=true
					 AND p.id = op.product_id
					 AND p.status = 'active'
                     AND sub.id = " . $sid . " 
					 ORDER BY p.brand_id"));

            foreach ($product_idsForaSection as $product_id) {
                $product=Product::find($product_id->id);		
                array_push($products, $product);
            }
            return view('oshop_retail_products_subcat2')
                ->with('subcat',$subcat)
                ->with('subcat2',$subcat2)
                ->with('products',$products);

        }else if($r['tab_product'] == 'B2B'){
			
            $products = array();

			$products=DB::select(DB::raw("SELECT p.*, p2.id as ssid
                     FROM product p2, oshopproduct op, wholesale w, productdealer pd, product p
					 JOIN subcat_level_3 sub ON sub.id = p.subcat_id AND p.subcat_level = 3				 
                     WHERE op.oshop_id = " . $id . "
					 AND p2.parent_id = op.product_id
					 AND p2.parent_id = p.id
					 AND p2.segment = 'b2b' AND p2.available > 0
					 AND ((p2.id = w.product_id and price > 0)
					 OR (p2.id = pd.product_id and special_price > 0))
					 AND p.oshop_selected=true
                     AND (sub.id = " . $sid . " OR s2.id = " . $sid . ")
					 GROUP BY p.id
					ORDER BY p.brand_id"));
					
            return view('oshop_retail_products_subcat2')
                ->with('subcat',$subcat)
                ->with('subcat2',$subcat2)
                ->with('products',$products);			
			
        }else if ($r['tab_product'] == 'smm'){
            $products = array();

			$product_idsForaSection=DB::select(DB::raw("SELECT p.id
                     FROM oshopproduct op, product p
					 JOIN subcat_level_3 sub ON sub.id = p.subcat_id AND p.subcat_level = 3 				 
                     WHERE op.oshop_id = " . $id . "
                     AND p.oshop_selected=true
                     AND p.smm_selected=true
					 AND p.id = op.product_id
                     AND sub.id = " . $sid . " 
					 ORDER BY p.brand_id"));

            foreach ($product_idsForaSection as $product_id) {
                $product=Product::find($product_id->id);		
                array_push($products, $product);
            }
            return view('oshop_smm_products_subcat2')
                ->with('subcat',$subcat)
                ->with('subcat2',$subcat2)
                ->with('products',$products);
        }else if ($r['tab_product'] == 'hyper'){
            if(!Auth::check()){
				$role=False;
			} else {
				$role_user=DB::table('role_users')->where('user_id',Auth::user()->id)->pluck('role_id');
				$role=False;
				if ($role_user==2 || $role_user==11 || $role_user==3) {
				  # code...
				  $role=True;
				}
			}			
			$product_ids= DB::table('owarehouse')->lists('product_id');
			$data = Product::leftJoin('owarehouse as o','product.id','=','o.product_id')
                ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id')
							 ->where('op.status','=','executed');
                         })
                ->join('merchantproduct as mp','product.parent_id','=','mp.product_id')
                //->where('product.subcat_id','=',$id)
                ->whereIn('product.id',$product_ids)
                ->where('mp.merchant_id',$id)
                ->where('product.status','active')
                ->where('product.subcat_id',$sid)
                ->where('product.subcat_level','3')
                ->where('o.status','active')
                ->where('o.moq','>',0)
                ->where('product.owarehouse_moqperpax','>',0)
                ->where('product.owarehouse_price','>',0)
                ->where('product.oshop_selected',1)
                ->select(DB::raw('product.*,o.id as owarehouse_id,o.collection_price, product.parent_id as product_id,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
                ->groupBy('product.id')
                ->get();
				
            return view('oshop_hyper_products_subcat2')
                    ->with('role',$role)
                    ->with('ow_product',$data)
					->with('subcat',$subcat)
					->with('subcat2',$subcat2);			
		} else if ($r['tab_product'] == 'voucher'){
		
		    $voucher_data=[];
			 $merchantvouchers= DB::table('merchantvoucher')->where('merchant_id', $id)->get();
			 if (!empty($merchantvouchers)){
				 foreach ($merchantvouchers as $v){
					 $vouchers = Voucher::where('id','=',$v->voucher_id)->orderBy('created_at', 'desc')->get();
					// $voucher_data = [];
					 foreach ($vouchers as $i) {
						 
						 //$temp['voucher_timeslot']=$i->timeSlots;
						 $product_id = $i->product_id;
						 $product = DB::table('product')->where('product.id', '=', $product_id)->where('product.subcat_id',$sid)->where('product.subcat_level','3')->first();
						 if (!is_null($product)) {
							 # code...
						$temp['voucher'] = $i;
						 $temp['voucher_product'] = $product;
						 $temp['voucher_timeslot'] = DB::table('timeslot')->select('*')->where('voucher_id', $i->id)->first();
						 $temp['voucher_address'] = $i->address;
						 if($product->segment == 'v1' || $product->segment == 'v2'){
							 if($product->segment == 'v1'){
								 if(!is_null($temp['voucher_timeslot'])){
									  $voucher_data[] = $temp;
								 }
							 } else {
								 $voucher_data[] = $temp;
							 }   
						 }  
						 }
			 
					 }
				 }
			 }
            return view('oshop_voucher_products_subcat2')
                    ->with('merchantvouchers',$voucher_data)
					->with('subcat',$subcat)
					->with('subcat2',$subcat2)	;		 
		}
    }	
	
	public function oshop_transfer(Request $r)
    {
        $ooshop_id = $r->oshop_id;
        $merchant_id = $r->merchant_id;
		$notes = $r->notes;
		$copy = $r->copyv;
		$getoshop = DB::table('oshop')->where('id',$ooshop_id)->first();
		$noshop = DB::table('oshop')->join('merchantoshop','merchantoshop.oshop_id','=','oshop.id')->where('oshop.brand_id',$getoshop->brand_id )->where('merchantoshop.merchant_id',$merchant_id )->select('oshop.*')->first();
		$oriurl = $getoshop->url;
		$oriurl1 = $getoshop->original_url;
		$mid = 0;
		$cp = 0;
		if($copy == 0){
			$oshop = DB::table('oshop')->where('id',$ooshop_id)->update(['url'=>$oriurl."transferred",'original_url'=>$oriurl1."transferred"]);
		}		
		if(!is_null($noshop)){
			$oshop_id = $noshop->id;	
		} else {
			if($copy == 1){
				$randn = rand(100,999);
				$oriurl .= $randn;
				$oriurl1 .= $randn;
			}
			$oshop_id = DB::table('oshop')->insertGetId([
				'oshop_name' =>$getoshop->oshop_name,
				'brand_id' =>$getoshop->brand_id,
				'address_id' =>$getoshop->address_id,
				'shop_size' =>$getoshop->shop_size,
				'url' =>$oriurl,
				'original_url' =>$oriurl1,
				'created_at'  => date('Y-m-d H:i:s'),
				'updated_at'  => date('Y-m-d H:i:s')
			]);
			
			DB::table('merchantoshop')->insert([
				'merchant_id' =>$merchant_id,
				'oshop_id' =>$oshop_id,
				'created_at'  => date('Y-m-d H:i:s'),
				'updated_at'  => date('Y-m-d H:i:s')
			]);
		}
		//dump($oshop_id);
		$oshopproducts = DB::table('oshopproduct')->
			where('oshop_id',$ooshop_id)->get();
		$oldmid = 0;
		foreach($oshopproducts as $oshopproduct){
		$product_id = $oshopproduct->product_id;
		$originalProduct = DB::table('product')->
			where('id',$product_id )->first();
		
		if($originalProduct->status != 'deleted' && $originalProduct->status != 'transferred'){
			$cp++;
		$newB2CProduct = DB::table('product')->insertGetId([
		  'name' => $originalProduct->name ,
		  'brand_id' => $originalProduct->brand_id ,
		  'parent_id' => $originalProduct->parent_id ,
		  'category_id' => $originalProduct->category_id ,
		  'subcat_id' => $originalProduct->subcat_id ,
		  'subcat_level' => $originalProduct->subcat_level ,
		  'segment' => $originalProduct->segment,
		  'photo_1' => $originalProduct->photo_1,
		  'photo_2' => $originalProduct->photo_2,
		  'photo_3' => $originalProduct->photo_3,
		  'photo_4' => $originalProduct->photo_4,
		  'photo_5' => $originalProduct->photo_5,
		  'thumb_photo' => $originalProduct->thumb_photo,
		  'thumb_photo2' => $originalProduct->thumb_photo2,
		  'adimage_1' => $originalProduct->adimage_1,
		  'adimage_2' => $originalProduct->adimage_2,
		  'adimage_3' => $originalProduct->adimage_3,
		  'adimage_4' => $originalProduct->adimage_4,
		  'adimage_5' => $originalProduct->adimage_5,
		  'productdetail_id' => $originalProduct->productdetail_id,
		  'description' => $originalProduct->description,
		  'free_delivery' => $originalProduct->free_delivery,
		  'free_delivery_with_purchase_qty' => $originalProduct->free_delivery_with_purchase_qty,
		  'views' => $originalProduct->views,
		  'display_non_autolink' => $originalProduct->display_non_autolink,
		  'del_worldwide'  => $originalProduct->del_worldwide,
		  'del_west_malaysia'  => $originalProduct->del_west_malaysia,
		  'del_sabah_labuan'  => $originalProduct->del_sabah_labuan,
		  'del_sarawak'  => $originalProduct->del_sarawak,
		  'cov_country_id' => $originalProduct->cov_country_id,
		  'cov_state_id' => $originalProduct->cov_state_id,
		  'cov_city_id' => $originalProduct->cov_city_id,
		  'cov_area_id' => $originalProduct->cov_area_id,
		  'b2b_del_worldwide' => $originalProduct->b2b_del_worldwide,
		  'b2b_del_west_malaysia' => $originalProduct->b2b_del_west_malaysia,
		  'b2b_del_sabah_labuan' => $originalProduct->b2b_del_sabah_labuan,
		  'b2b_del_sarawak' => $originalProduct->b2b_del_sarawak,
		  'b2b_cov_country_id' => $originalProduct->b2b_cov_country_id,
		  'b2b_cov_state_id' => $originalProduct->b2b_cov_state_id,
		  'b2b_cov_city_id' => $originalProduct->b2b_cov_city_id,
		  'b2b_cov_area_id' => $originalProduct->b2b_cov_area_id,
		  'del_pricing'  => $originalProduct->del_pricing,
		  'del_width'  => $originalProduct->del_width,
		  'del_lenght'  => $originalProduct->del_lenght,
		  'del_height'  => $originalProduct->del_height,
		  'del_weight'  => $originalProduct->del_weight,
		  'weight'  => $originalProduct->weight,
		  'height'  => $originalProduct->height,
		  'width'  => $originalProduct->width,
		  'length'  => $originalProduct->length,
		  'del_option' => $originalProduct->del_option,
		  'retail_price' => $originalProduct->retail_price,
		  'original_price' => $originalProduct->original_price,
		  'discounted_price' => $originalProduct->discounted_price,
		  'private_retail_price' => $originalProduct->private_retail_price,
		  'private_discounted_price' => $originalProduct->private_discounted_price,
		  'stock' => $originalProduct->stock,
		  'available' => $originalProduct->available,
		  'private_available' => $originalProduct->private_available,
		  'b2b_available' => $originalProduct->b2b_available,
		  'hyper_available' => $originalProduct->hyper_available,
		  'owarehouse_moq' => $originalProduct->owarehouse_moq,
		  'owarehouse_moqpb' => $originalProduct->owarehouse_moqpb,
		  'owarehouse_moqperpax' => $originalProduct->owarehouse_moqperpax,
		  'owarehouse_price' => $originalProduct->owarehouse_price,
		  'measure' => $originalProduct->measure ,
		  'owarehouse_units' => $originalProduct->owarehouse_units,
		  'owarehouse_ave_unit_price' => $originalProduct->owarehouse_ave_unit_price,
		  'type'  => $originalProduct->type,
		  'owarehouse_duration' => $originalProduct->owarehouse_duration,
		  'smm_selected' => $originalProduct->smm_selected,
		  'oshop_selected'  => $originalProduct->oshop_selected,
		  'mc_sales_staff_id' => $originalProduct->mc_sales_staff_id,
		  'referral_sales_staff_id' => $originalProduct->referral_sales_staff_id,
		  'mcp1_sales_staff_id' => $originalProduct->mcp1_sales_staff_id,
		  'mcp2_sales_staff_id' => $originalProduct->mcp2_sales_staff_id,
		  'psh_sales_staff_id' => $originalProduct->psh_sales_staff_id,
		  'osmall_commission'  => $originalProduct->osmall_commission,
		  'b2b_osmall_commission' => $originalProduct->b2b_osmall_commission ,
		  'mc_sales_staff_commission'  => $originalProduct-> mc_sales_staff_commission,
		  'mc_with_ref_sales_staff_commission'  => $originalProduct-> mc_with_ref_sales_staff_commission,
		  'referral_sales_staff_commission'  => $originalProduct-> referral_sales_staff_commission,
		  'mcp1_sales_staff_commission' => $originalProduct-> mcp1_sales_staff_commission,
		  'mcp2_sales_staff_commission'  => $originalProduct->mcp2_sales_staff_commission,
		  'smm_sales_staff_commission'  => $originalProduct->smm_sales_staff_commission,
		  'psh_sales_staff_commission'  => $originalProduct->psh_sales_staff_commission,
		  'str_sales_staff_commission'  => $originalProduct->str_sales_staff_commission,
		  'return_policy' => $originalProduct->return_policy,
		  'return_address_id' => $originalProduct->return_address_id,
		  'status' => $originalProduct->status,
		  'active_date'  => $originalProduct->active_date,
		  'deleted_at'  =>  null,
		  'created_at'  => date('Y-m-d H:i:s'),
		  'updated_at'  => date('Y-m-d H:i:s')
		]);
		DB::table('product')->
			where('id',$newB2CProduct)->
			update(['parent_id'=>$newB2CProduct]);
		try {
			$folder = URL::to('/').'/images/product/' . $product_id;
			$folder_thumb = URL::to('/').'/images/product/'.$product_id.'/thumb';
			//$files = File::allFiles($folder);
			//$files_thumb = File::allFiles($folder);
			$original_photo = fopen($folder.'/'.$originalProduct->photo_1,'r');
			$thumb_1_photo = fopen($folder_thumb.'/'.$originalProduct->thumb_photo,'r');
			$thumb_2_photo = fopen($folder_thumb.'/'.$originalProduct->thumb_photo2,'r');
			
			$nfolder = base_path().'/public/images/product/'.$newB2CProduct;
			$nfolder_thumb = base_path().'/public/images/product/'.$newB2CProduct.'/thumb';
			
			File::makeDirectory($nfolder, 0777, true, true);
			File::makeDirectory($nfolder_thumb, 0777, true, true);
			
			$image_split = explode(".", $originalProduct->photo_1);
			$arr_size = count($image_split);
			$image_format = $image_split[$arr_size - 1];
			
			$image_name = "p" . str_pad($newB2CProduct, 10, '0', STR_PAD_LEFT) . "-" . "m" . str_pad($merchant_id->merchant_id, 10, '0', STR_PAD_LEFT) . "-" . rand(1000, 9999) . "." . $image_format;
			$image_thumb_name = "thumb_" . $image_name;
			$image_thumb400_name = "thumb400_" . $image_name;
		
		
		
			File::put($nfolder . '/' . $image_name,$original_photo);
			File::put($nfolder_thumb . '/' . $image_thumb_name,$thumb_1_photo);
			File::put($nfolder_thumb . '/' . $image_thumb400_name,$thumb_2_photo);
			DB::table('product')->where('id',$newB2CProduct)->update(['photo_1' => $image_name,'thumb_photo' => $image_thumb_name,'thumb_photo2' => $image_thumb400_name]);
		} catch (\Exception $e){
			dump($e);
		}
			
		
		$originalB2BProduct = DB::table('product')->where('parent_id',$product_id)->where('segment','b2b')->first();
		$newB2BProduct = 0;
		if(!is_null($originalB2BProduct)){
			$newB2BProduct = DB::table('product')->insertGetId([
			  'name' => $originalB2BProduct->name ,
			  'brand_id' => $originalB2BProduct->brand_id ,
			  'parent_id' => $newB2CProduct ,
			  'category_id' => $originalB2BProduct->category_id ,
			  'subcat_id' => $originalB2BProduct->subcat_id ,
			  'subcat_level' => $originalB2BProduct->subcat_level ,
			  'segment' => $originalB2BProduct->segment,
			  'photo_1' => $originalB2BProduct->photo_1,
			  'photo_2' => $originalB2BProduct->photo_2,
			  'photo_3' => $originalB2BProduct->photo_3,
			  'photo_4' => $originalB2BProduct->photo_4,
			  'photo_5' => $originalB2BProduct->photo_5,
			  'thumb_photo' => $originalProduct->thumb_photo,
		      'thumb_photo2' => $originalProduct->thumb_photo2,
			  'adimage_1' => $originalB2BProduct->adimage_1,
			  'adimage_2' => $originalB2BProduct->adimage_2,
			  'adimage_3' => $originalB2BProduct->adimage_3,
			  'adimage_4' => $originalB2BProduct->adimage_4,
			  'adimage_5' => $originalB2BProduct->adimage_5,
			  'productdetail_id' => $originalB2BProduct->productdetail_id,
			  'description' => $originalB2BProduct->description,
			  'free_delivery' => $originalB2BProduct->free_delivery,
			  'free_delivery_with_purchase_qty' => $originalB2BProduct->free_delivery_with_purchase_qty,
			  'views' => $originalB2BProduct->views,
			  'display_non_autolink' => $originalB2BProduct->display_non_autolink,
			  'del_worldwide'  => $originalB2BProduct->del_worldwide,
			  'del_west_malaysia'  => $originalB2BProduct->del_west_malaysia,
			  'del_sabah_labuan'  => $originalB2BProduct->del_sabah_labuan,
			  'del_sarawak'  => $originalB2BProduct->del_sarawak,
			  'cov_country_id' => $originalB2BProduct->cov_country_id,
			  'cov_state_id' => $originalB2BProduct->cov_state_id,
			  'cov_city_id' => $originalB2BProduct->cov_city_id,
			  'cov_area_id' => $originalB2BProduct->cov_area_id,
			  'b2b_del_worldwide' => $originalB2BProduct->b2b_del_worldwide,
			  'b2b_del_west_malaysia' => $originalB2BProduct->b2b_del_west_malaysia,
			  'b2b_del_sabah_labuan' => $originalB2BProduct->b2b_del_sabah_labuan,
			  'b2b_del_sarawak' => $originalB2BProduct->b2b_del_sarawak,
			  'b2b_cov_country_id' => $originalB2BProduct->b2b_cov_country_id,
			  'b2b_cov_state_id' => $originalB2BProduct->b2b_cov_state_id,
			  'b2b_cov_city_id' => $originalB2BProduct->b2b_cov_city_id,
			  'b2b_cov_area_id' => $originalB2BProduct->b2b_cov_area_id,
			  'del_pricing'  => $originalB2BProduct->del_pricing,
			  'del_width'  => $originalB2BProduct->del_width,
			  'del_lenght'  => $originalB2BProduct->del_lenght,
			  'del_height'  => $originalB2BProduct->del_height,
			  'del_weight'  => $originalB2BProduct->del_weight,
			  'weight'  => $originalB2BProduct->weight,
			  'height'  => $originalB2BProduct->height,
			  'width'  => $originalB2BProduct->width,
			  'length'  => $originalB2BProduct->length,
			  'del_option' => $originalB2BProduct->del_option,
			  'retail_price' => $originalB2BProduct->retail_price,
			  'original_price' => $originalB2BProduct->original_price,
			  'discounted_price' => $originalB2BProduct->discounted_price,
			  'private_retail_price' => $originalB2BProduct->private_retail_price,
			  'private_discounted_price' => $originalB2BProduct->private_discounted_price,
			  'stock' => $originalB2BProduct->stock,
			  'available' => $originalB2BProduct->available,
			  'private_available' => $originalB2BProduct->private_available,
			  'b2b_available' => $originalB2BProduct->b2b_available,
			  'hyper_available' => $originalB2BProduct->hyper_available,
			  'owarehouse_moq' => $originalB2BProduct->owarehouse_moq,
			  'owarehouse_moqpb' => $originalB2BProduct->owarehouse_moqpb,
			  'owarehouse_moqperpax' => $originalB2BProduct->owarehouse_moqperpax,
			  'owarehouse_price' => $originalB2BProduct->owarehouse_price,
			  'measure' => $originalB2BProduct->measure ,
			  'owarehouse_units' => $originalB2BProduct->owarehouse_units,
			  'owarehouse_ave_unit_price' => $originalB2BProduct->owarehouse_ave_unit_price,
			  'type'  => $originalB2BProduct->type,
			  'owarehouse_duration' => $originalB2BProduct->owarehouse_duration,
			  'smm_selected' => $originalB2BProduct->smm_selected,
			  'oshop_selected'  => $originalB2BProduct->oshop_selected,
			  'mc_sales_staff_id' => $originalB2BProduct->mc_sales_staff_id,
			  'referral_sales_staff_id' => $originalB2BProduct->referral_sales_staff_id,
			  'mcp1_sales_staff_id' => $originalB2BProduct->mcp1_sales_staff_id,
			  'mcp2_sales_staff_id' => $originalB2BProduct->mcp2_sales_staff_id,
			  'psh_sales_staff_id' => $originalB2BProduct->psh_sales_staff_id,
			  'osmall_commission'  => $originalB2BProduct->osmall_commission,
			  'b2b_osmall_commission' => $originalB2BProduct->b2b_osmall_commission ,
			  'mc_sales_staff_commission'  => $originalB2BProduct-> mc_sales_staff_commission,
			  'mc_with_ref_sales_staff_commission'  => $originalB2BProduct-> mc_with_ref_sales_staff_commission,
			  'referral_sales_staff_commission'  => $originalB2BProduct-> referral_sales_staff_commission,
			  'mcp1_sales_staff_commission' => $originalB2BProduct-> mcp1_sales_staff_commission,
			  'mcp2_sales_staff_commission'  => $originalB2BProduct->mcp2_sales_staff_commission,
			  'smm_sales_staff_commission'  => $originalB2BProduct->smm_sales_staff_commission,
			  'psh_sales_staff_commission'  => $originalB2BProduct->psh_sales_staff_commission,
			  'str_sales_staff_commission'  => $originalB2BProduct->str_sales_staff_commission,
			  'return_policy' => $originalB2BProduct->return_policy,
			  'return_address_id' => $originalB2BProduct->return_address_id,
			  'status' => $originalB2BProduct->status,
			  'active_date'  => $originalB2BProduct->active_date,
			  'deleted_at'  =>  null,
			  'created_at'  => date('Y-m-d H:i:s'),
			  'updated_at'  => date('Y-m-d H:i:s')
			]);
			
			$wholesales = DB::table('wholesale')->where('product_id',$originalB2BProduct->id)->get();
			foreach($wholesales as $wholesale){
				DB::table('wholesale')->insert([
						'product_id'  => $newB2BProduct,
						'unit'  => $wholesale->unit,
						'funit'  => $wholesale->funit,
						'price'  => $wholesale->price,
						'created_at'  => date('Y-m-d H:i:s'),
						'updated_at'  => date('Y-m-d H:i:s')
				]);
			}
			
			$productdealers = DB::table('productdealer')->where('product_id',$originalB2BProduct->id)->get();
			foreach($productdealers as $productdealer){
				DB::table('productdealer')->insert([
						'product_id'  => $newB2BProduct,
						'dealer_id'  => $wholesale->dealer_id,
						'special_unit'  => $wholesale->special_unit,
						'special_funit'  => $wholesale->special_funit,
						'special_price'  => $wholesale->special_price,
						'created_at'  => date('Y-m-d H:i:s'),
						'updated_at'  => date('Y-m-d H:i:s')
				]);
			}	
			if($copy == 0){
				DB::table('product')->where('id',$originalB2BProduct->id)->update(['status'=>'transferred']);
			}
			//dump("HAVE B2B");
		}
		//dump("MEDIUM");
		if($copy == 0){
			DB::table('product')->where('id',$originalProduct->id)->update(['status'=>'transferred']);
		}
		
		$old_merchant_id = DB::table('merchantproduct')->where('product_id',$originalProduct->id)->first();
		$old_oshop_id = DB::table('oshopproduct')->where('product_id',$originalProduct->id)->first();
		$merchant_id = DB::table('merchantoshop')->where('oshop_id',$oshop_id)->first();
		//dump("MEDIUM 2");
		$oldmid = $old_merchant_id->merchant_id;
		DB::table('merchantproduct')->insert([
			'product_id'=> $newB2CProduct,
			'merchant_id'=> $merchant_id->merchant_id,
			'created_at'  => date('Y-m-d H:i:s'),
			'updated_at'  => date('Y-m-d H:i:s')
		]);
		
		DB::table('oshopproduct')->insert([
			'product_id'=> $newB2CProduct,
			'oshop_id'=> $oshop_id,
			'created_at'  => date('Y-m-d H:i:s'),
			'updated_at'  => date('Y-m-d H:i:s')
		]);
		
		//DB::table('oshopproduct')->where('product_id',$product_id)->where('oshop_id',$old_oshop_id->oshop_id)->delete();
	
		$newmerchant = DB::table('merchant')->where('id',$merchant_id->merchant_id)->first();
		$merchantuniqueq = DB::table('nsellerid')->where('user_id',$newmerchant->user_id)->first();
		//dump("OSHOP UNIQUE");
		if(!is_null($merchantuniqueq)){
				//dump($merchantuniqueq);
				$newid = UtilityController::productuniqueid(
					$merchant_id->merchant_id,$merchantuniqueq->nseller_id,'b2c',0,$newB2CProduct);
				//dump($newid);
				if($newid != ""){
					DB::table('nproductid')->
						insert(['nproduct_id'=>$newid,
						'product_id'=>$newB2CProduct,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')]);
				}
				//dump("problem 2???");
				if($newB2BProduct > 0){
					$newid = UtilityController::productuniqueid(
					$merchant_id->merchant_id,$merchantuniqueq->nseller_id,'b2b',0,$newB2BProduct);
					//dump("problem 3???");	
					if($newid != ""){
						DB::table('nproductid')->
							insert(['nproduct_id'=>$newid,
							'product_id'=>$newB2BProduct,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')]);
					}
				}
				
		}
		//dump("DONE UNIQUE");
		$mid = $merchant_id->merchant_id;
			if($copy == 0){
				DB::table('producttransferlog')
					->insert([
						"old_product_id"=>$originalProduct->id,
						"product_id"=>$newB2CProduct,
						"old_oshop_id"=>$old_oshop_id->oshop_id,
						"new_oshop_id"=>$oshop_id,
						"old_merchant_id"=>$old_merchant_id->merchant_id,
						"new_merchant_id"=>$merchant_id->merchant_id,
						"notes"=>$notes,
						"created_at"=>date('Y-m-d H:i:s'),
						"updated_at"=>date('Y-m-d H:i:s'),
						"status"=>"success",
						"admin_user_id"=>Auth::user()->id
					 ]);
			} else {
				DB::table('productcopylog')
					->insert([
						"old_product_id"=>$originalProduct->id,
						"product_id"=>$newB2CProduct,
						"old_oshop_id"=>$old_oshop_id->oshop_id,
						"new_oshop_id"=>$oshop_id,
						"old_merchant_id"=>$old_merchant_id->merchant_id,
						"new_merchant_id"=>$merchant_id->merchant_id,
						"notes"=>$notes,
						"created_at"=>date('Y-m-d H:i:s'),
						"updated_at"=>date('Y-m-d H:i:s'),
						"status"=>"success",
						"admin_user_id"=>Auth::user()->id
					 ]);
			}
		}
		}
		if($cp > 0){
			if($copy == 0){
				DB::table('oshoptransferlog')
					->insert([
						"old_oshop_id"=>$old_oshop_id->oshop_id,
						"oshop_id"=>$oshop_id,
						"old_merchant_id"=>$oldmid,
						"new_merchant_id"=>$merchant_id->merchant_id,
						"notes"=>$notes,
						"created_at"=>date('Y-m-d H:i:s'),
						"updated_at"=>date('Y-m-d H:i:s'),
						"admin_user_id"=>Auth::user()->id
						]);
			} else {
				DB::table('oshopcopylog')
					->insert([
						"old_oshop_id"=>$old_oshop_id->oshop_id,
						"oshop_id"=>$oshop_id,
						"old_merchant_id"=>$oldmid,
						"new_merchant_id"=>$merchant_id->merchant_id,
						"notes"=>$notes,
						"created_at"=>date('Y-m-d H:i:s'),
						"updated_at"=>date('Y-m-d H:i:s'),
						"admin_user_id"=>Auth::user()->id
						]);				
			}
			if($copy == 0){
				$oshop = DB::table('oshop')->where('id',$ooshop_id)->update(['status'=>'transferred']);
			}
		}
		return "OK";
	}	
	
	public function product_transfer(Request $r)
    {
        $oshop_id = $r->oshop_id;
        $product_id = $r->product_id;
        $notes = $r->notes;
        $copy = $r->copyv;
		$merchant_id = DB::table('merchantoshop')->where('oshop_id',$oshop_id)->first();
		$originalProduct = DB::table('product')->where('id',$product_id )->first();
		if($originalProduct->status != 'deleted' && $originalProduct->status != 'transferred'){
		$newB2CProduct = DB::table('product')->insertGetId([
		  'name' => $originalProduct->name ,
		  'brand_id' => $originalProduct->brand_id ,
		  'parent_id' => $originalProduct->parent_id ,
		  'category_id' => $originalProduct->category_id ,
		  'subcat_id' => $originalProduct->subcat_id ,
		  'subcat_level' => $originalProduct->subcat_level ,
		  'segment' => $originalProduct->segment,
		  'photo_1' => $originalProduct->photo_1,
		  'photo_2' => $originalProduct->photo_2,
		  'photo_3' => $originalProduct->photo_3,
		  'photo_4' => $originalProduct->photo_4,
		  'photo_5' => $originalProduct->photo_5,
		  'thumb_photo' => $originalProduct->thumb_photo,
		  'thumb_photo2' => $originalProduct->thumb_photo2,
		  'adimage_1' => $originalProduct->adimage_1,
		  'adimage_2' => $originalProduct->adimage_2,
		  'adimage_3' => $originalProduct->adimage_3,
		  'adimage_4' => $originalProduct->adimage_4,
		  'adimage_5' => $originalProduct->adimage_5,
		  'productdetail_id' => $originalProduct->productdetail_id,
		  'description' => $originalProduct->description,
		  'free_delivery' => $originalProduct->free_delivery,
		  'free_delivery_with_purchase_qty' => $originalProduct->free_delivery_with_purchase_qty,
		  'views' => $originalProduct->views,
		  'display_non_autolink' => $originalProduct->display_non_autolink,
		  'del_worldwide'  => $originalProduct->del_worldwide,
		  'del_west_malaysia'  => $originalProduct->del_west_malaysia,
		  'del_sabah_labuan'  => $originalProduct->del_sabah_labuan,
		  'del_sarawak'  => $originalProduct->del_sarawak,
		  'cov_country_id' => $originalProduct->cov_country_id,
		  'cov_state_id' => $originalProduct->cov_state_id,
		  'cov_city_id' => $originalProduct->cov_city_id,
		  'cov_area_id' => $originalProduct->cov_area_id,
		  'b2b_del_worldwide' => $originalProduct->b2b_del_worldwide,
		  'b2b_del_west_malaysia' => $originalProduct->b2b_del_west_malaysia,
		  'b2b_del_sabah_labuan' => $originalProduct->b2b_del_sabah_labuan,
		  'b2b_del_sarawak' => $originalProduct->b2b_del_sarawak,
		  'b2b_cov_country_id' => $originalProduct->b2b_cov_country_id,
		  'b2b_cov_state_id' => $originalProduct->b2b_cov_state_id,
		  'b2b_cov_city_id' => $originalProduct->b2b_cov_city_id,
		  'b2b_cov_area_id' => $originalProduct->b2b_cov_area_id,
		  'del_pricing'  => $originalProduct->del_pricing,
		  'del_width'  => $originalProduct->del_width,
		  'del_lenght'  => $originalProduct->del_lenght,
		  'del_height'  => $originalProduct->del_height,
		  'del_weight'  => $originalProduct->del_weight,
		  'weight'  => $originalProduct->weight,
		  'height'  => $originalProduct->height,
		  'width'  => $originalProduct->width,
		  'length'  => $originalProduct->length,
		  'del_option' => $originalProduct->del_option,
		  'retail_price' => $originalProduct->retail_price,
		  'original_price' => $originalProduct->original_price,
		  'discounted_price' => $originalProduct->discounted_price,
		  'private_retail_price' => $originalProduct->private_retail_price,
		  'private_discounted_price' => $originalProduct->private_discounted_price,
		  'stock' => $originalProduct->stock,
		  'available' => $originalProduct->available,
		  'private_available' => $originalProduct->private_available,
		  'b2b_available' => $originalProduct->b2b_available,
		  'hyper_available' => $originalProduct->hyper_available,
		  'owarehouse_moq' => $originalProduct->owarehouse_moq,
		  'owarehouse_moqpb' => $originalProduct->owarehouse_moqpb,
		  'owarehouse_moqperpax' => $originalProduct->owarehouse_moqperpax,
		  'owarehouse_price' => $originalProduct->owarehouse_price,
		  'measure' => $originalProduct->measure ,
		  'owarehouse_units' => $originalProduct->owarehouse_units,
		  'owarehouse_ave_unit_price' => $originalProduct->owarehouse_ave_unit_price,
		  'type'  => $originalProduct->type,
		  'owarehouse_duration' => $originalProduct->owarehouse_duration,
		  'smm_selected' => $originalProduct->smm_selected,
		  'oshop_selected'  => $originalProduct->oshop_selected,
		  'mc_sales_staff_id' => $originalProduct->mc_sales_staff_id,
		  'referral_sales_staff_id' => $originalProduct->referral_sales_staff_id,
		  'mcp1_sales_staff_id' => $originalProduct->mcp1_sales_staff_id,
		  'mcp2_sales_staff_id' => $originalProduct->mcp2_sales_staff_id,
		  'psh_sales_staff_id' => $originalProduct->psh_sales_staff_id,
		  'osmall_commission'  => $originalProduct->osmall_commission,
		  'b2b_osmall_commission' => $originalProduct->b2b_osmall_commission ,
		  'mc_sales_staff_commission'  => $originalProduct-> mc_sales_staff_commission,
		  'mc_with_ref_sales_staff_commission'  => $originalProduct-> mc_with_ref_sales_staff_commission,
		  'referral_sales_staff_commission'  => $originalProduct-> referral_sales_staff_commission,
		  'mcp1_sales_staff_commission' => $originalProduct-> mcp1_sales_staff_commission,
		  'mcp2_sales_staff_commission'  => $originalProduct->mcp2_sales_staff_commission,
		  'smm_sales_staff_commission'  => $originalProduct->smm_sales_staff_commission,
		  'psh_sales_staff_commission'  => $originalProduct->psh_sales_staff_commission,
		  'str_sales_staff_commission'  => $originalProduct->str_sales_staff_commission,
		  'return_policy' => $originalProduct->return_policy,
		  'return_address_id' => $originalProduct->return_address_id,
		  'status' => $originalProduct->status,
		  'active_date'  => $originalProduct->active_date,
		  'deleted_at'  =>  null,
		  'created_at'  => date('Y-m-d H:i:s'),
		  'updated_at'  => date('Y-m-d H:i:s')
		]);
		
		try {
			$folder = URL::to('/').'/images/product/' . $product_id;
			$folder_thumb = URL::to('/').'/images/product/'.$product_id.'/thumb';
			//$files = File::allFiles($folder);
			//$files_thumb = File::allFiles($folder);
			$original_photo = fopen($folder.'/'.$originalProduct->photo_1,'r');
			$thumb_1_photo = fopen($folder_thumb.'/'.$originalProduct->thumb_photo,'r');
			$thumb_2_photo = fopen($folder_thumb.'/'.$originalProduct->thumb_photo2,'r');
			
			$nfolder = base_path().'/public/images/product/'.$newB2CProduct;
			$nfolder_thumb = base_path().'/public/images/product/'.$newB2CProduct.'/thumb';
			
			File::makeDirectory($nfolder, 0777, true, true);
			File::makeDirectory($nfolder_thumb, 0777, true, true);
			
			$image_split = explode(".", $originalProduct->photo_1);
			$arr_size = count($image_split);
			$image_format = $image_split[$arr_size - 1];
			
			$image_name = "p" . str_pad($newB2CProduct, 10, '0', STR_PAD_LEFT) . "-" . "m" . str_pad($merchant_id->merchant_id, 10, '0', STR_PAD_LEFT) . "-" . rand(1000, 9999) . "." . $image_format;
			$image_thumb_name = "thumb_" . $image_name;
			$image_thumb400_name = "thumb400_" . $image_name;
		
		
		
			File::put($nfolder . '/' . $image_name,$original_photo);
			File::put($nfolder_thumb . '/' . $image_thumb_name,$thumb_1_photo);
			File::put($nfolder_thumb . '/' . $image_thumb400_name,$thumb_2_photo);
			DB::table('product')->where('id',$newB2CProduct)->update(['photo_1' => $image_name,'thumb_photo' => $image_thumb_name,'thumb_photo2' => $image_thumb400_name]);
		} catch (\Exception $e){
			dump($e);
		}
		DB::table('product')->where('id',$newB2CProduct)->update(['parent_id'=>$newB2CProduct]);
		$originalB2BProduct = DB::table('product')->where('parent_id',$product_id)->where('segment','b2b')->first();
		$newB2BProduct = 0;
		if(!is_null($originalB2BProduct)){
			$newB2BProduct = DB::table('product')->insertGetId([
			  'name' => $originalB2BProduct->name ,
			  'brand_id' => $originalB2BProduct->brand_id ,
			  'parent_id' => $newB2CProduct ,
			  'category_id' => $originalB2BProduct->category_id ,
			  'subcat_id' => $originalB2BProduct->subcat_id ,
			  'subcat_level' => $originalB2BProduct->subcat_level ,
			  'segment' => $originalB2BProduct->segment,
			  'photo_1' => $originalProduct->photo_1,
			  'photo_2' => $originalB2BProduct->photo_2,
			  'photo_3' => $originalB2BProduct->photo_3,
			  'photo_4' => $originalB2BProduct->photo_4,
			  'photo_5' => $originalB2BProduct->photo_5,
			  'thumb_photo' => $originalProduct->thumb_photo,
		      'thumb_photo2' => $originalProduct->thumb_photo2,
			  'adimage_1' => $originalB2BProduct->adimage_1,
			  'adimage_2' => $originalB2BProduct->adimage_2,
			  'adimage_3' => $originalB2BProduct->adimage_3,
			  'adimage_4' => $originalB2BProduct->adimage_4,
			  'adimage_5' => $originalB2BProduct->adimage_5,
			  'productdetail_id' => $originalB2BProduct->productdetail_id,
			  'description' => $originalB2BProduct->description,
			  'free_delivery' => $originalB2BProduct->free_delivery,
			  'free_delivery_with_purchase_qty' => $originalB2BProduct->free_delivery_with_purchase_qty,
			  'views' => $originalB2BProduct->views,
			  'display_non_autolink' => $originalB2BProduct->display_non_autolink,
			  'del_worldwide'  => $originalB2BProduct->del_worldwide,
			  'del_west_malaysia'  => $originalB2BProduct->del_west_malaysia,
			  'del_sabah_labuan'  => $originalB2BProduct->del_sabah_labuan,
			  'del_sarawak'  => $originalB2BProduct->del_sarawak,
			  'cov_country_id' => $originalB2BProduct->cov_country_id,
			  'cov_state_id' => $originalB2BProduct->cov_state_id,
			  'cov_city_id' => $originalB2BProduct->cov_city_id,
			  'cov_area_id' => $originalB2BProduct->cov_area_id,
			  'b2b_del_worldwide' => $originalB2BProduct->b2b_del_worldwide,
			  'b2b_del_west_malaysia' => $originalB2BProduct->b2b_del_west_malaysia,
			  'b2b_del_sabah_labuan' => $originalB2BProduct->b2b_del_sabah_labuan,
			  'b2b_del_sarawak' => $originalB2BProduct->b2b_del_sarawak,
			  'b2b_cov_country_id' => $originalB2BProduct->b2b_cov_country_id,
			  'b2b_cov_state_id' => $originalB2BProduct->b2b_cov_state_id,
			  'b2b_cov_city_id' => $originalB2BProduct->b2b_cov_city_id,
			  'b2b_cov_area_id' => $originalB2BProduct->b2b_cov_area_id,
			  'del_pricing'  => $originalB2BProduct->del_pricing,
			  'del_width'  => $originalB2BProduct->del_width,
			  'del_lenght'  => $originalB2BProduct->del_lenght,
			  'del_height'  => $originalB2BProduct->del_height,
			  'del_weight'  => $originalB2BProduct->del_weight,
			  'weight'  => $originalB2BProduct->weight,
			  'height'  => $originalB2BProduct->height,
			  'width'  => $originalB2BProduct->width,
			  'length'  => $originalB2BProduct->length,
			  'del_option' => $originalB2BProduct->del_option,
			  'retail_price' => $originalB2BProduct->retail_price,
			  'original_price' => $originalB2BProduct->original_price,
			  'discounted_price' => $originalB2BProduct->discounted_price,
			  'private_retail_price' => $originalB2BProduct->private_retail_price,
			  'private_discounted_price' => $originalB2BProduct->private_discounted_price,
			  'stock' => $originalB2BProduct->stock,
			  'available' => $originalB2BProduct->available,
			  'private_available' => $originalB2BProduct->private_available,
			  'b2b_available' => $originalB2BProduct->b2b_available,
			  'hyper_available' => $originalB2BProduct->hyper_available,
			  'owarehouse_moq' => $originalB2BProduct->owarehouse_moq,
			  'owarehouse_moqpb' => $originalB2BProduct->owarehouse_moqpb,
			  'owarehouse_moqperpax' => $originalB2BProduct->owarehouse_moqperpax,
			  'owarehouse_price' => $originalB2BProduct->owarehouse_price,
			  'measure' => $originalB2BProduct->measure ,
			  'owarehouse_units' => $originalB2BProduct->owarehouse_units,
			  'owarehouse_ave_unit_price' => $originalB2BProduct->owarehouse_ave_unit_price,
			  'type'  => $originalB2BProduct->type,
			  'owarehouse_duration' => $originalB2BProduct->owarehouse_duration,
			  'smm_selected' => $originalB2BProduct->smm_selected,
			  'oshop_selected'  => $originalB2BProduct->oshop_selected,
			  'mc_sales_staff_id' => $originalB2BProduct->mc_sales_staff_id,
			  'referral_sales_staff_id' => $originalB2BProduct->referral_sales_staff_id,
			  'mcp1_sales_staff_id' => $originalB2BProduct->mcp1_sales_staff_id,
			  'mcp2_sales_staff_id' => $originalB2BProduct->mcp2_sales_staff_id,
			  'psh_sales_staff_id' => $originalB2BProduct->psh_sales_staff_id,
			  'osmall_commission'  => $originalB2BProduct->osmall_commission,
			  'b2b_osmall_commission' => $originalB2BProduct->b2b_osmall_commission ,
			  'mc_sales_staff_commission'  => $originalB2BProduct-> mc_sales_staff_commission,
			  'mc_with_ref_sales_staff_commission'  => $originalB2BProduct-> mc_with_ref_sales_staff_commission,
			  'referral_sales_staff_commission'  => $originalB2BProduct-> referral_sales_staff_commission,
			  'mcp1_sales_staff_commission' => $originalB2BProduct-> mcp1_sales_staff_commission,
			  'mcp2_sales_staff_commission'  => $originalB2BProduct->mcp2_sales_staff_commission,
			  'smm_sales_staff_commission'  => $originalB2BProduct->smm_sales_staff_commission,
			  'psh_sales_staff_commission'  => $originalB2BProduct->psh_sales_staff_commission,
			  'str_sales_staff_commission'  => $originalB2BProduct->str_sales_staff_commission,
			  'return_policy' => $originalB2BProduct->return_policy,
			  'return_address_id' => $originalB2BProduct->return_address_id,
			  'status' => $originalB2BProduct->status,
			  'active_date'  => $originalB2BProduct->active_date,
			  'deleted_at'  =>  null,
			  'created_at'  => date('Y-m-d H:i:s'),
			  'updated_at'  => date('Y-m-d H:i:s')
			]);
			
			$wholesales = DB::table('wholesale')->where('product_id',$originalB2BProduct->id)->get();
			foreach($wholesales as $wholesale){
				DB::table('wholesale')->insert([
						'product_id'  => $newB2BProduct,
						'unit'  => $wholesale->unit,
						'funit'  => $wholesale->funit,
						'price'  => $wholesale->price,
						'created_at'  => date('Y-m-d H:i:s'),
						'updated_at'  => date('Y-m-d H:i:s')
				]);
			}
			
			$productdealers = DB::table('productdealer')->where('product_id',$originalB2BProduct->id)->get();
			foreach($productdealers as $productdealer){
				DB::table('productdealer')->insert([
						'product_id'  => $newB2BProduct,
						'dealer_id'  => $wholesale->dealer_id,
						'special_unit'  => $wholesale->special_unit,
						'special_funit'  => $wholesale->special_funit,
						'special_price'  => $wholesale->special_price,
						'created_at'  => date('Y-m-d H:i:s'),
						'updated_at'  => date('Y-m-d H:i:s')
				]);
			}	
			if($copy == 0){
				DB::table('product')->where('id',$originalB2BProduct->id)->update(['status'=>'transferred']);
			}
			//dump("HAVE B2B");
		}
		//dump("MEDIUM");
		if($copy == 0){
			DB::table('product')->where('id',$originalProduct->id)->update(['status'=>'transferred']);
		}
		
		$old_merchant_id = DB::table('merchantproduct')->where('product_id',$originalProduct->id)->first();
		$old_oshop_id = DB::table('oshopproduct')->where('product_id',$originalProduct->id)->first();
		
		//dump("MEDIUM 2");
		DB::table('merchantproduct')->insert([
			'product_id'=> $newB2CProduct,
			'merchant_id'=> $merchant_id->merchant_id,
			'created_at'  => date('Y-m-d H:i:s'),
			'updated_at'  => date('Y-m-d H:i:s')
		]);
		
		DB::table('oshopproduct')->insert([
			'product_id'=> $newB2CProduct,
			'oshop_id'=> $oshop_id,
			'created_at'  => date('Y-m-d H:i:s'),
			'updated_at'  => date('Y-m-d H:i:s')
		]);
		
		//DB::table('oshopproduct')->where('product_id',$product_id)->where('oshop_id',$old_oshop_id->oshop_id)->delete();
	
		$newmerchant = DB::table('merchant')->where('id',$merchant_id->merchant_id)->first();
		$merchantuniqueq = DB::table('nsellerid')->where('user_id',$newmerchant->user_id)->first();
		//dump("OSHOP UNIQUE");
		if(!is_null($merchantuniqueq)){
				//dump($merchantuniqueq);
				$newid = UtilityController::productuniqueid(
					$merchant_id->merchant_id,$merchantuniqueq->nseller_id,'b2c',0,$newB2CProduct);
				//dump($newid);
				if($newid != ""){
					DB::table('nproductid')->
						insert(['nproduct_id'=>$newid,
						'product_id'=>$newB2CProduct,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')]);
				}
				//dump("problem 2???");
				if($newB2BProduct > 0){
					$newid = UtilityController::productuniqueid(
					$merchant_id->merchant_id,$merchantuniqueq->nseller_id,'b2b',0,$newB2BProduct);
					//dump("problem 3???");	
					if($newid != ""){
						DB::table('nproductid')->
							insert(['nproduct_id'=>$newid,
							'product_id'=>$newB2BProduct,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')]);
					}
				}
				
		}
		//dump("DONE UNIQUE");
		if($copy == 0){
			DB::table('producttransferlog')
				->insert([
					"old_product_id"=>$originalProduct->id,
					"product_id"=>$newB2CProduct,
					"old_oshop_id"=>$old_oshop_id->oshop_id,
					"new_oshop_id"=>$oshop_id,
					"old_merchant_id"=>$old_merchant_id->merchant_id,
					"new_merchant_id"=>$merchant_id->merchant_id,
					"status"=>"success",
					"notes"=>$notes,
					"created_at"=>date('Y-m-d H:i:s'),
					"updated_at"=>date('Y-m-d H:i:s'),
					"admin_user_id"=>Auth::user()->id
				 ]);
			} else {
				DB::table('productcopylog')
				->insert([
					"old_product_id"=>$originalProduct->id,
					"product_id"=>$newB2CProduct,
					"old_oshop_id"=>$old_oshop_id->oshop_id,
					"new_oshop_id"=>$oshop_id,
					"old_merchant_id"=>$old_merchant_id->merchant_id,
					"new_merchant_id"=>$merchant_id->merchant_id,
					"status"=>"success",
					"notes"=>$notes,
					"created_at"=>date('Y-m-d H:i:s'),
					"updated_at"=>date('Y-m-d H:i:s'),
					"admin_user_id"=>Auth::user()->id
				 ]);				
			}
		}
		return "OK";
	}
	
	public function oshop_transfer_history($oshop_id)
    {
		$fhistory = $this->get_oshop_fhistory($oshop_id,[],0,1);
		$bhistory = $this->get_oshop_bhistory($oshop_id,[],0,1);
		$oshop = DB::table('oshop')->where('id',$oshop_id)->first();
		//dd($bhistory);
		return view('master.transfer_history')
                    ->with('fhistory',array_reverse($fhistory))
                    ->with('oshop',$oshop)
					->with('bhistory',$bhistory);
	}
	
	public function get_oshop_fhistory($oshop_id,$farray,$counter,$bold)
    {
		$old_oshop = DB::table('oshoptransferlog')->where('old_oshop_id',$oshop_id)->first();
		if(!is_null($old_oshop)){
			$new_merchant = DB::table('merchant')->where('id',$old_oshop->new_merchant_id)->select('id','user_id','company_name')->first();
			$old_merchant = DB::table('merchant')->where('id',$old_oshop->old_merchant_id)->select('id','user_id','company_name')->first();
			$farray[$counter]['new_merchant'] = $new_merchant;
			$farray[$counter]['old_merchant'] = $old_merchant;		
			$farray[$counter]['bold'] = $bold;		
			$farray[$counter]['action'] = 'Transfer';		
			$counter = $counter +1;	
			$old_oshop_copys = DB::table('oshopcopylog')->where('old_oshop_id',$oshop_id)->get();
			foreach($old_oshop_copys as $copyv){
				$new_merchant = DB::table('merchant')->where('id',$copyv->new_merchant_id)->select('id','user_id','company_name')->first();
				$old_merchant = DB::table('merchant')->where('id',$copyv->old_merchant_id)->select('id','user_id','company_name')->first();
				$farray[$counter]['new_merchant'] = $new_merchant;
				$farray[$counter]['old_merchant'] = $old_merchant;		
				$farray[$counter]['bold'] = $bold;	
				$farray[$counter]['action'] = 'Copy';				
				$counter = $counter +1;	
			}
			return $this->get_oshop_fhistory($old_oshop->oshop_id,$farray,$counter,0);
		} else {
			return $farray;
		}
	}
	
	public function get_oshop_bhistory($oshop_id,$barray,$counter,$bold)
    {
		//dump($barray);
		$old_oshop = DB::table('oshoptransferlog')->where('oshop_id',$oshop_id)->first();
		if(!is_null($old_oshop)){
			$new_merchant = DB::table('merchant')->where('id',$old_oshop->new_merchant_id)->select('id','user_id','company_name')->first();
			$old_merchant = DB::table('merchant')->where('id',$old_oshop->old_merchant_id)->select('id','user_id','company_name')->first();
			$barray[$counter]['new_merchant'] = $new_merchant;
			$barray[$counter]['old_merchant'] = $old_merchant;	
			$barray[$counter]['bold'] = $bold;
			$barray[$counter]['action'] = 'Transfer';			
			$counter = $counter +1;		
			$old_oshop_copys = DB::table('oshopcopylog')->where('old_oshop_id',$oshop_id)->get();
			foreach($old_oshop_copys as $copyv){
				$new_merchant = DB::table('merchant')->where('id',$copyv->new_merchant_id)->select('id','user_id','company_name')->first();
				$old_merchant = DB::table('merchant')->where('id',$copyv->old_merchant_id)->select('id','user_id','company_name')->first();
				$barray[$counter]['new_merchant'] = $new_merchant;
				$barray[$counter]['old_merchant'] = $old_merchant;		
				$barray[$counter]['bold'] = $bold;	
				$barray[$counter]['action'] = 'Copy';				
				$counter = $counter +1;	
			}
			return $this->get_oshop_bhistory($old_oshop->old_oshop_id,$barray,$counter,0);
		} else {
			return $barray;
		}
	}
	
	public function product_transfer_history($product_id)
    {
		$fhistory = $this->get_product_fhistory($product_id,[],0,1);
		$bhistory = $this->get_product_bhistory($product_id,[],0,1);
		$product = DB::table('product')->where('id',$product_id)->first();
		//dump($bhistory);
		//dd($fhistory);
		return view('master.product_transfer_history')
                    ->with('fhistory',array_reverse($fhistory))
                    ->with('product',$product)
					->with('bhistory',$bhistory);
	}
	
	public function get_product_fhistory($product_id,$farray,$counter,$bold)
    {
		$old_product = DB::table('producttransferlog')->where('old_product_id',$product_id)->first();
		if(!is_null($old_product)){
			$new_merchant = DB::table('merchant')->where('id',$old_product->new_merchant_id)->select('id','user_id','company_name')->first();
			$new_oshop = DB::table('oshop')->where('id',$old_product->new_oshop_id)->select('id','oshop_name','url')->first();
			$old_merchant = DB::table('merchant')->where('id',$old_product->old_merchant_id)->select('id','user_id','company_name')->first();
			$old_oshop = DB::table('oshop')->where('id',$old_product->old_oshop_id)->select('id','oshop_name','url')->first();
			$farray[$counter]['old_product'] = $old_product;
			$farray[$counter]['new_merchant'] = $new_merchant;
			$farray[$counter]['old_merchant'] = $old_merchant;	
			$farray[$counter]['new_oshop'] = $new_oshop;
			$farray[$counter]['old_oshop'] = $old_oshop;
			$farray[$counter]['datetime'] = $old_product->created_at;			
			$farray[$counter]['bold'] = $bold;		
			$farray[$counter]['action'] = 'Transfer';
			$counter = $counter +1;	
			$old_oshop_copys = DB::table('productcopylog')->where('old_oshop_id',$oshop_id)->get();
			foreach($old_oshop_copys as $copyv){
				$new_merchant = DB::table('merchant')->where('id',$copyv->new_merchant_id)->select('id','user_id','company_name')->first();
				$new_oshop = DB::table('oshop')->where('id',$copyv->new_oshop_id)->select('id','oshop_name','url')->first();
				$old_merchant = DB::table('merchant')->where('id',$copyv->old_merchant_id)->select('id','user_id','company_name')->first();
				$old_oshop = DB::table('oshop')->where('id',$copyv->old_oshop_id)->select('id','oshop_name','url')->first();
				$farray[$counter]['old_product'] = $copyv;
				$farray[$counter]['new_merchant'] = $new_merchant;
				$farray[$counter]['old_merchant'] = $old_merchant;	
				$farray[$counter]['new_oshop'] = $new_oshop;
				$farray[$counter]['old_oshop'] = $old_oshop;
				$farray[$counter]['datetime'] = $copyv->created_at;			
				$farray[$counter]['bold'] = $bold;		
				$counter = $counter +1;	
				$farray[$counter]['action'] = 'Copy';				
			}			
			return $this->get_product_fhistory($old_product->product_id,$farray,$counter,0);
		} else {
			return $farray;
		}
	}
	
	public function get_product_bhistory($product_id,$barray,$counter,$bold)
    {
		//dump($barray);
		$product = DB::table('producttransferlog')->where('product_id',$product_id)->first();
		if(!is_null($product)){
			$old_product = DB::table('product')->where('id',$product->old_product_id)->first();
			$new_merchant = DB::table('merchant')->where('id',$product->new_merchant_id)->select('id','user_id','company_name')->first();
			$new_oshop = DB::table('oshop')->where('id',$product->new_oshop_id)->select('id','oshop_name','url')->first();
			$old_merchant = DB::table('merchant')->where('id',$product->old_merchant_id)->select('id','user_id','company_name')->first();
			$old_oshop = DB::table('oshop')->where('id',$product->old_oshop_id)->select('id','oshop_name','url')->first();
			$barray[$counter]['old_product'] = $old_product;
			$barray[$counter]['new_merchant'] = $new_merchant;
			$barray[$counter]['old_merchant'] = $old_merchant;	
			$barray[$counter]['new_oshop'] = $new_oshop;
			$barray[$counter]['old_oshop'] = $old_oshop;	
			$barray[$counter]['datetime'] = $product->created_at;	
			$barray[$counter]['bold'] = $bold;	
			$counter = $counter +1;		
			$old_oshop_copys = DB::table('productcopylog')->where('old_oshop_id',$oshop_id)->get();
			foreach($old_oshop_copys as $copyv){
				$new_merchant = DB::table('merchant')->where('id',$copyv->new_merchant_id)->select('id','user_id','company_name')->first();
				$new_oshop = DB::table('oshop')->where('id',$copyv->new_oshop_id)->select('id','oshop_name','url')->first();
				$old_merchant = DB::table('merchant')->where('id',$copyv->old_merchant_id)->select('id','user_id','company_name')->first();
				$old_oshop = DB::table('oshop')->where('id',$copyv->old_oshop_id)->select('id','oshop_name','url')->first();
				$farray[$counter]['old_product'] = $copyv;
				$farray[$counter]['new_merchant'] = $new_merchant;
				$farray[$counter]['old_merchant'] = $old_merchant;	
				$farray[$counter]['new_oshop'] = $new_oshop;
				$farray[$counter]['old_oshop'] = $old_oshop;
				$farray[$counter]['datetime'] = $copyv->created_at;			
				$farray[$counter]['bold'] = $bold;		
				$counter = $counter +1;	
				$farray[$counter]['action'] = 'Copy';				
			}			
			return $this->get_oshop_bhistory($product->old_product_id,$barray,$counter,0);
		} else {
			return $barray;
		}
	}	
	
    public function transferOshop(Request $r)
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
            MerchantOshop
            MerchantProduct
            OshopTransferlog
            Unlink all stations
        
        */ 
        try {
            $origMerchant=$r->origMerchant;
            $transferToMerchant=$r->transferToMerchant;
            $oshop=$r->oshop;
            $admin_user_id=Auth::user()->id;
        } catch (\Exception $e) {
            $resp['short_message']=$e->getMessage();
            $resp['long_message']="Invalid Params";
            return response()->json($resp);
        }

        try {
            $existingValidRecords=DB::table('merchantproduct')
            ->join('oshopproduct','oshopproduct.product_id','=','merchantproduct.product_id')
            ->where('oshopproduct.oshop_id',$oshop)
            ->where('merchant_id',$origMerchant)
            ->whereNull('merchantproduct.deleted_at')
            ->get();
            DB::table('merchantproduct')
            ->join('oshopproduct','oshopproduct.product_id','=','merchantproduct.product_id')
            ->where('merchant_id',$origMerchant)

            ->update(['merchantproduct.deleted_at'=>date('Y-m-d H:i:s')]);
            foreach ($existingValidRecords as $evr) {
                DB::table('merchantproduct')
                ->insert([
                    "merchant_id"=>$transferToMerchant,
                    "product_id"=>$evr->product_id
                   
                    ]);
            }
            DB::table('merchantoshop')
            ->where('merchant_id',$origMerchant)
            ->where('oshop_id',$oshop)
            ->update(['merchant_id'=>$transferToMerchant]);
            DB::table('oshoptransferlog')
            ->insert([
                "oshop_id"=>$oshop,
                "old_merchant_id"=>$origMerchant,
                "new_merchant_id"=>$transferToMerchant,
                "notes"=>"No note",
                "admin_user_id"=>$admin_user_id
                ]);
            $resp['status']="success";
            $resp['short_message']="success";
            $resp['long_message']="O-Shop transfer done";

        } catch (\Exception $e) {
            $resp['short_message']=$e->getMessage();
            $resp['long_message']="Failed to process";

        }
        return response()->json($resp);

    }
}
