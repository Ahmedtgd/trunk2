<?php

namespace App\Http\Controllers\rn;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
/*ALL RESPONSES MUST BE JSON*/

class LandingPageController extends Controller
{
	public function get_landing($value='') {
	   $ret=array();
	   try {
			   $product = DB::table('product')->
				   select("id","name","brand_id","parent_id","category_id",
				   "photo_1","thumb_photo","thumb_photo2","retail_price",
				   "original_price","discounted_price","stock","available")->
				   orderByRaw("RAND()")->
				   where('product.retail_price','>',0)->
				   limit(6)->get();

			$base_image_url = public_path() . 'images';
			/*
			$languages = DB::table('language')->
				select("id","name")->orderBy('name')->get();

			$interests = DB::table('category')->
				select("id","name")->orderBy('name')->get();

			$banks = DB::table('bank')->
				select("id","name")->orderBy('name')->get();

			*/
			//printf($product);
		   

	   } catch (\Exception $e) {
		   dump($e);
	   }

	   $ret=compact('product','base_image_url');
	   //print_r($ret);exit;
	   return response()->json($ret);
   }
}
