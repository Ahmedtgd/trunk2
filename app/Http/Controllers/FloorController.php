<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\FloorRepo;
use App\Http\Requests\FloorRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;
use Auth;

class FloorController extends Controller {

	protected $slider_path = "/images/adimage/";

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	function __construct(FloorRepo $repo) {
		$this->repo = $repo;
	}

	public function index() {
		$object = $this->repo->getfloors();
		return view('floor')->with(array(
			'allCategories'=>$object,
		));
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
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(FloorRequest $request) {

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function filter(Request $request) {
		 $r = $request->all();
		 $id = $r['id'];
         $filter = $r['filter'];
         $filter_id = $r['filter_id'];
		 $merchant=False;
		 $user=False;
         $station=False;
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
        }		 

		$category = DB::table('category')->where('floor', $id)->first();
		$filter_name = "";
		if($filter == 'all'){
		   $products = $this->repo->getfloorproducts($id);
		} else {
		   $products = $this->repo->getfloordatafiltern($id, $filter, $filter_id); 
		   if($filter == 'subcategory'){
			  $subcategory = DB::table('subcat_level_1')->where('id', $filter_id)->first(); 
			  $filter_name = $subcategory->description;
		   }
		}
		
		return view('floordetail')->with(array(
			'products'=>$products,
			'filter_name'=>$filter_name
		));
	}
	
	public function show($id) {
		$slider_path = $this->slider_path;
        $merchant=False;
        $user=False;
        $station=False;
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
        }		

		$category = DB::table('category')->where('floor', $id)->first();
		$category_logo = "";
		$category_floor = 0;
		if(!is_null($category)){
			$category_name = $category->description;
			$category_logo = $category->logo_white;
			$category_floor = $category->floor;
		} else {
			$category_name = "This floor does not exists";
		}
		
			$subcategories = DB::select(DB::raw(
				"SELECT id, COUNT(nprod) as nprod, name, description FROM 
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name,
				subcat_level_1.description as description, product.id as nprod
				FROM subcat_level_1
				JOIN product ON product.subcat_id = subcat_level_1.id AND product.subcat_level = 1
				JOIN merchantproduct ON product.id = merchantproduct.product_id
				JOIN merchant ON merchant.id = merchantproduct.merchant_id
				JOIN oshopproduct ON product.id = oshopproduct.product_id
				JOIN oshop ON oshop.id = oshopproduct.oshop_id
				WHERE subcat_level_1.category_id = " . $category->id . "
					AND product.oshop_selected = true
					AND product.retail_price > 0
					AND product.available > 0
					AND merchant.status = 'active'
					AND oshop.status = 'active'
					AND product.status ='active' AND product.segment = 'b2c'
					AND product.deleted_at IS NULL					
					UNION				
					SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
									JOIN merchantproduct ON product.id = merchantproduct.product_id
									JOIN merchant ON merchant.id = merchantproduct.merchant_id
									JOIN oshopproduct ON product.id = oshopproduct.product_id
									JOIN oshop ON oshop.id = oshopproduct.oshop_id
									WHERE  subcat_level_1.category_id = " . $category->id . "
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0
										AND merchant.status = 'active'
										AND oshop.status = 'active'
										AND product.status ='active' AND product.segment = 'b2c'
										AND product.deleted_at IS NULL
						GROUP BY id				
										
					UNION				
					SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
									JOIN merchantproduct ON product.id = merchantproduct.product_id
									JOIN merchant ON merchant.id = merchantproduct.merchant_id
									JOIN oshopproduct ON product.id = oshopproduct.product_id
									JOIN oshop ON oshop.id = oshopproduct.oshop_id
									WHERE 
										subcat_level_1.category_id = " . $category->id . "
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0
										AND merchant.status = 'active'										
										AND oshop.status = 'active'										
                                        AND product.status ='active' AND product.segment = 'b2c'
										AND product.deleted_at IS NULL
						GROUP BY id
					) as T
					GROUP BY id
					ORDER BY description ASC"
			));

			$count_subcategoriesp = array();
			$sp = 0;
			
			foreach($subcategories as $sub){
                $count_subcategories = DB::select(DB::raw(
                    "SELECT COUNT(*) as counter FROM product p 
					LEFT JOIN subcat_level_2 ON (p.subcat_id = subcat_level_2.id AND p.subcat_level = 2) 
					LEFT JOIN subcat_level_3 ON (p.subcat_id = subcat_level_3.id AND p.subcat_level = 3) 
					JOIN merchantproduct ON p.id = merchantproduct.product_id
					JOIN merchant ON merchant.id = merchantproduct.merchant_id
					JOIN oshopproduct ON p.id = oshopproduct.product_id
					JOIN oshop ON oshop.id = oshopproduct.oshop_id
					WHERE
					p.oshop_selected=true 
					AND p.retail_price > 0 
					AND p.deleted_at IS NULL
					AND p.available > 0 AND p.status ='active' AND merchant.status ='active' AND oshop.status ='active' AND p.segment = 'b2c' AND p.category_id= " . $category->id . " 
					AND ((p.subcat_id= " . $sub->id . " AND p.subcat_level = 1) OR (subcat_level_2.subcat_level_1_id = " . $sub->id . ") OR (subcat_level_3.subcat_level_1_id = " . $sub->id . ")) 
					"
                ));
                $count_subcategoriesp[$sp] = $count_subcategories[0]->counter;
                $sp++;
            }			
			$realcounter = 0;
			//$products = $this->repo->getfloordata($id);
			/*foreach ($products as $product => $value){
				foreach($value as $column => $product){
					$realcounter++;
				}
			}*/
        $subcatlevels = DB::select(DB::raw(
            "SELECT id, name, nprod FROM (
			SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
						FROM subcat_level_2
						JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
						WHERE 
							product.category_id = " . $category->id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.status ='active' AND product.segment = 'b2c'
						GROUP BY id
			UNION
			SELECT DISTINCT(subcat_level_2.id) as id, subcat_level_2.description as name, COUNT(product.id) as nprod
						FROM subcat_level_2
						JOIN subcat_level_3 ON subcat_level_3.subcat_level_2_id = subcat_level_2.id
						JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
						WHERE 
							product.category_id = " . $category->id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.status ='active' AND product.segment = 'b2c'
						GROUP BY id	
			) as T
			GROUP BY id
			ORDER BY nprod DESC"
        ));		
		$subcatleves3 = null;
		if(!is_null($subcatlevels)){
			foreach($subcatlevels as $subcatleveldef){
				$subcatleves3[$subcatleveldef->id] = DB::select(DB::raw(
					"SELECT DISTINCT(subcat_level_3.id) as id, subcat_level_3.description as name, COUNT(product.id) as nprod
					FROM subcat_level_3
					JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
					WHERE 
						product.category_id = " . $category->id .  " AND product.retail_price > 0 AND product.deleted_at IS NULL  AND product.available > 0 AND product.oshop_selected = 1 AND product.status ='active' AND product.segment = 'b2c'
						AND subcat_level_3.subcat_level_2_id = " . $subcatleveldef->id . "
					GROUP BY subcat_level_3.id
					ORDER BY nprod DESC"
				));					
			}
		}
		$brands = DB::select(DB::raw(
            "SELECT DISTINCT(brand.id) as id, brand.name, COUNT(product.id) as nprod
            FROM brand
            JOIN product ON product.brand_id = brand.id
            WHERE 
				product.category_id = " . $category->id . " AND
				product.retail_price > 0  AND 
				product.available > 0 AND 
				product.deleted_at IS NULL AND
				product.status = 'active' AND
				product.oshop_selected = 1 AND
				product.segment = 'b2c'
            GROUP BY brand.id
			ORDER BY nprod DESC"
        ));

        // Category Advert Images
        
        $cat_adv1 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'cat_adv1')
		->where('categoryadimage.category_id', $id)
		->select('adimage.*')
		->first();

		$cat_adv2 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'cat_adv2')
		->where('categoryadimage.category_id', $id)
		->select('adimage.*')
		->first();

		$cat_adv3 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'cat_adv3')
		->where('categoryadimage.category_id', $id)
		->select('adimage.*')
		->first();

		$cat_adv4 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'cat_adv4')
		->where('categoryadimage.category_id', $id)
		->select('adimage.*')
		->first();

		$cat_adv5 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'cat_adv5')
		->where('categoryadimage.category_id', $id)
		->select('adimage.*')
		->first();

		return view('detail')->with(array(
			'products'=>$this->repo->getfloorproducts($id),
			'category_name'=>$category_name,
			'category_logo'=>$category_logo,
			'category_floor'=>$category_floor,
			'floor_id'=>$id,
			'realcounter'=>$realcounter,
			'type'=>'floor',
			'subcategories'=>$subcategories,
			'subcatlevels'=>$subcatlevels,
			'subcatleves3'=>$subcatleves3,
			'brands'=>$brands,
			'count_subcategoriesp'=>$count_subcategoriesp,
			'user'=>$user,
			'cat_adv1'=>$cat_adv1,
			'cat_adv2'=>$cat_adv2,
			'cat_adv3'=>$cat_adv3,
			'cat_adv4'=>$cat_adv4,
			'cat_adv5'=>$cat_adv5,
			'slider_path'=>$slider_path,
		));
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
