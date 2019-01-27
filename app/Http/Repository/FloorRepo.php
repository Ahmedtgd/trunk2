<?php

namespace App\Http\Repository;

use App\Models\Category;
use App\Models\Product as Product;
use DB;

class FloorRepo {
	protected $model;

	function __construct(Product $model) {
		$this->model = $model;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return get all records
	 */
	public function index() {
		$object = $this->model->where("product.deleted_at", null);
		$object = $object->select(array(
			"product.*", "subcat_level_1.name as subcat_name", "category.name as category_name",
		))
		->Join("subcat_level_1", function ($join) {
			$join->on("subcat_level_1.id", "=", "product.subcat_id");
		})
		->Join("category", function ($join) {
			$join->on("category.id", "=", "product.category_id");
		})
		->get();

		$result = array();
		foreach ($object as $value) {
			$result[$value['subcat_name']][] = $value;
		}
		return $result;
	}

	public function getfloors(){
		return $this->model->where('product.deleted_at',null)
				->join("category",
				function ($join) {
					$join->on("category.id", "=", "product.category_id"); })
				->select(array("category.*"))
				->where('category.enable', '1')
				->orderBy('floor', 'asc')
				->groupBy('floor')
				->get();
	}
	
	public function getfloordatafiltern($id, $filter, $filter_id){
		$category = DB::table('category')->where('floor',$id)->first();
		if(!is_null($category)){
			$id = $category->id;
			$object = $this->model
				->join('merchantproduct','merchantproduct.product_id','=','product.id')
				->join('merchant','merchantproduct.merchant_id','=','merchant.id')
				->join('oshopproduct','oshopproduct.product_id','=','product.id')
				->join('oshop','oshopproduct.oshop_id','=','oshop.id')
				->where("product.deleted_at", null)->
				where('product.category_id',$id)->
				where('product.oshop_selected', '=', '1')->
				where('product.segment', '=', 'b2c')->
				where('product.retail_price', '>', '0')->
				where('merchant.status','active')->
				where('product.status','active')->
				where('oshop.status','active')->
				where('product.available','>',0)->
				join("category", function ($join) {
					$join->on("category.id", "=", "product.category_id"); })->
					select(array("product.*",
					DB::raw('
					CASE
					WHEN product.subcat_level = 1
						THEN subcat_level_1.description
					WHEN product.subcat_level = 2
						THEN subcat_level_2.description 
					WHEN product.subcat_level = 3 
						THEN subcat_level_3.description 
					END AS subcat_description'),
				DB::raw('
				CASE
				WHEN product.subcat_level = 1
					THEN subcat_level_1.name
				WHEN product.subcat_level = 2
					THEN subcat_level_2.name
				WHEN product.subcat_level = 3
					THEN subcat_level_3.name
				END AS subcat_name'),
				"category.description as category_description"));

			/*if($filter == 'brand'){
				$filterobject = $object->where('product.brand_id','=',$filter_id)
				->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); });
			}*/
			if($filter == 'subcategory'){
				$filterobject = $object->whereRaw("
					(product.subcat_level = 1 AND
					product.subcat_id = " . $filter_id . " AND product.segment = 'b2c' AND product.oshop_selected = 1 AND product.retail_price > 0 AND product.status = 'active' AND product.available > 0 AND product.deleted_at IS NULL AND product.category_id = " . $id .") OR
					(product.subcat_level = 2 AND
					subcat_level_2.subcat_level_1_id = " . $filter_id . "  AND product.segment = 'b2c' AND product.oshop_selected = 1 AND product.retail_price > 0 AND product.status = 'active' AND product.available > 0 AND product.deleted_at IS NULL AND product.category_id = " . $id .") OR
					(product.subcat_level = 3 AND
					subcat_level_3.subcat_level_1_id = " . $filter_id . "  AND product.segment = 'b2c' AND product.oshop_selected = 1 AND product.retail_price > 0 AND product.status = 'active' AND product.available > 0 AND product.deleted_at IS NULL AND product.category_id = " . $id .")")
				->leftjoin("subcat_level_1", function ($join) {
					$join->on("subcat_level_1.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_2", function ($join) {
					$join->on("subcat_level_2.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_3", function ($join) {
					$join->on("subcat_level_3.id", "=", "product.subcat_id"); });
			}

		/*	if($filter == 'subcatlevel'){
				$filterobject = $object->whereRaw('(product.subcat_level = ' . 2 .  ' AND product.subcat_id = ' . $filter_id . ') 
				OR (product.subcat_level = ' . 3 .  ' AND subcat_level_3.subcat_level_2_id = ' . $filter_id . ')')
				->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); });
			}

			if($filter == 'subcatlevel3'){
				$filterobject = $object->where('product.subcat_level',3)->where('product.subcat_id',$filter_id)
				->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); });
			}*/
			$finalobject = $filterobject->orderByRaw("RAND()")->get();

			//dd($finalobject);
			return $finalobject;				
		} else {
			$result = array();
			return $result;	
		}		
	}
	
	public function getfloordatafilter($id, $filter, $filter_id){
		$category = DB::table('category')->where('floor',$id)->first();
		if(!is_null($category)){
			$id = $category->id;
			$object = $this->model->where("product.deleted_at", null)->
				where('product.category_id',$id)->
				where('product.oshop_selected', '=', true)->
				where('product.segment', '=', 'b2c')->
				where('product.retail_price', '>', '0')->
				where('product.status','active')->
				where('product.available','>',0)->
				join("category", function ($join) {
					$join->on("category.id", "=", "product.category_id"); })->
					select(array("product.*",
					DB::raw('
					CASE
					WHEN product.subcat_level = 1
						THEN subcat_level_1.description
					WHEN product.subcat_level = 2
						THEN subcat_level_2.description 
					WHEN product.subcat_level = 3 
						THEN subcat_level_3.description 
					END AS subcat_description'),
				DB::raw('
				CASE
				WHEN product.subcat_level = 1
					THEN subcat_level_1.name
				WHEN product.subcat_level = 2
					THEN subcat_level_2.name
				WHEN product.subcat_level = 3
					THEN subcat_level_3.name
				END AS subcat_name'),
				"category.description as category_description"));

			if($filter == 'brand'){
				$filterobject = $object->where('product.brand_id','=',$filter_id)
				->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); });
			}
			if($filter == 'subcategory'){
				$filterobject = $object->whereRaw("
					(product.subcat_level = 1 AND
					product.subcat_id = " . $filter_id . " AND product.segment = 'b2c') OR
					(product.subcat_level = 2 AND
					subcat_level_2.subcat_level_1_id = " . $filter_id . "  AND product.segment = 'b2c') OR
					(product.subcat_level = 3 AND
					subcat_level_3.subcat_level_1_id = " . $filter_id . "  AND product.segment = 'b2c')")
				->leftjoin("subcat_level_1", function ($join) {
					$join->on("subcat_level_1.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_2", function ($join) {
					$join->on("subcat_level_2.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_3", function ($join) {
					$join->on("subcat_level_3.id", "=", "product.subcat_id"); });
			}

			if($filter == 'subcatlevel'){
				$filterobject = $object->whereRaw('(product.subcat_level = ' . 2 .  ' AND product.subcat_id = ' . $filter_id . ') 
				OR (product.subcat_level = ' . 3 .  ' AND subcat_level_3.subcat_level_2_id = ' . $filter_id . ')')
				->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); });
			}

			if($filter == 'subcatlevel3'){
				$filterobject = $object->where('product.subcat_level',3)->where('product.subcat_id',$filter_id)
				->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); });
			}
			$finalobject = $filterobject->get();

			$result = array();
			foreach ($finalobject as $value) {
				$result[$value['subcat_name']][] = $value;
			}
			//dd("HOLA");
			return $result;				
		} else {
			$result = array();
			return $result;	
		}
	}

	public function getfloorproducts($id){
		$category = DB::table('category')->where('floor',$id)->first();
		if(!is_null($category)){
		$id = $category->id;
			$object = $this->model
				->join('merchantproduct','merchantproduct.product_id','=','product.id')
				->join('merchant','merchantproduct.merchant_id','=','merchant.id')
				->join('oshopproduct','oshopproduct.product_id','=','product.id')
				->join('oshop','oshopproduct.oshop_id','=','oshop.id')
				->where("product.deleted_at", null)->
				where('product.category_id',$id)->
				where('product.oshop_selected', '=', '1')->
				where('product.segment', '=', 'b2c')->
				where('product.retail_price', '>', '0')->
				where('oshop.status','active')->
				where('product.status','active')->
				where('merchant.status','active')->
				where('product.available','>',0);
		$object = $object->select(array('product.id' ,
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
				  'product.thumb_photo' ,
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
				  'product.updated_at',
					DB::raw('CASE WHEN product.subcat_level = 1 THEN subcat_level_1.description WHEN product.subcat_level = 2 THEN subcat_level_2.description WHEN product.subcat_level = 3 THEN subcat_level_3.description END AS subcat_description'),
				DB::raw('CASE WHEN product.subcat_level = 1 THEN subcat_level_1.name WHEN product.subcat_level = 2 THEN subcat_level_2.name WHEN product.subcat_level = 3 THEN subcat_level_3.name END AS subcat_name'),
						"category.description as category_description"))
				->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); })
				->join("category", function ($join) { $join->on("category.id", "=", "product.category_id"); })
				->orderByRaw("RAND()")
				->get();
				
				return $object;	
				} else {
					$result = array();
					return $result;	
				}
	}
	
	public function getfloordata($id){
		$category = DB::table('category')->where('floor',$id)->first();
		if(!is_null($category)){
			$id = $category->id;
			$object = $this->model->
				where("product.deleted_at", null)->
				where('product.category_id',$id)->
				where('product.oshop_selected', '=', true)->
				where('product.segment', '=', 'b2c')->
				where('product.retail_price', '>', '0')->
				where('product.status','active')->
				where('product.available','>',0);

			$object = $object->select(array('product.id' ,
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
				  'product.thumb_photo' ,
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
				  'product.updated_at',
					DB::raw('CASE WHEN product.subcat_level = 1 THEN subcat_level_1.description WHEN product.subcat_level = 2 THEN subcat_level_2.description WHEN product.subcat_level = 3 THEN subcat_level_3.description END AS subcat_description'),
				DB::raw('CASE WHEN product.subcat_level = 1 THEN subcat_level_1.name WHEN product.subcat_level = 2 THEN subcat_level_2.name WHEN product.subcat_level = 3 THEN subcat_level_3.name END AS subcat_name'),
						"category.description as category_description"))
				->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
				->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); })
				->join("category", function ($join) { $join->on("category.id", "=", "product.category_id"); })
				->get();
			$result = array();
			foreach ($object as $value) {
				$result[$value['subcat_name']][] = $value;
			}

			return $result;			
		} else {
			$result = array();
			return $result;	
		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($input) {
		return $this->model->create($input);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return data base on id
	 */
	public function find($id) {
		return $this->model->find($id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @return data base on id
	 */
	public function findOrFail($id) {
		return $this->model->findOrFail($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  $input  $id
	 * @return model
	 */
	public function update($input, $id) {
		return $this->model->update($input)->where($id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return true or false
	 */
	public function destroy($id) {
		return $this->model->delete($id);
	}
}
