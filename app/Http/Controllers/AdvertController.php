<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdControl;
use App\Models\AdImage;
use App\Models\AdTarget;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Owarehouse;
use App\Models\Owarehouse_pledge;
use App\Models\Product;
use App\Models\Globals;
use App\Models\Oshop;
use DB;
use Log;
use App\Models\Category;
use App\Models\Categoryadimage;
use App\Models\SubCatLevel1;

class AdvertController extends Controller
{
	protected $slider_path = "/images/adimage/";

	public function index() {
		$sliderDetails = AdTarget::with([
			'AdControl.AdImages'=>function($query){
				// $query->where('hide','0');
			}])->
				where("target","lpage_slider")->
				has('AdControl.AdImages')->first();
		
		$topContainerDetails = AdTarget::with([
			'AdControl.AdImages'=>function($query){ 
				// $query->where('hide','0');
			}])->
				where("target","lpage_internal_top")->
				has('AdControl.AdImages')->first();

		$bottomContainerDetails = AdTarget::with([
			'AdControl.AdImages'=>function($query){
				// $query->where('hide','0');
			}])->
				where("target","lpage_internal_bottom")->
				has('AdControl.AdImages')->first();

        $slider_path = $this->slider_path; 
		
		/* Get Hyper deals data */

		/*$hyper_deals = Owarehouse::join('product','owarehouse.product_id','=','product.id')
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
        ->get();*/

        /* Get Hyper deals data */

        /* oshop images section */
    	$oshopImages = AdTarget::with([
			'AdControl.AdImages'=>function($query){ 
				// $query->where('hide','0');
			}])->
				where("target","lpage_oshop")->
				has('AdControl.AdImages')->first();

		/* Category */

		$categories = Category::where('enable',true)->orderBy('floor')->get()->pluck('description','id');
		$subCategories = SubCatLevel1::orderBy('description')->get()->pluck('description','id');

        /* Oshop Images done by rahul */
		return view("advertisement.advert_preview",
			compact('sliderDetails','topContainerDetails',
			'bottomContainerDetails','slider_path','oshopImages','categories','subCategories'));
	}

	public function sliderImage(Request $request){
		
		if(!empty($request->get('delete_image')))
		{
			$delete_images = explode(",",trim($request->get('delete_image'),','));
			foreach($delete_images as $image) {
				$adImageDetails = AdImage::where("id",$image)->first();

				if($adImageDetails):

				$path = $this->slider_path.$adImageDetails->id.
					"/".$adImageDetails->temp_path;

				try {
					Storage::disk('slider-data')->delete($path);
					$adImageDetails->delete();
				} catch (\Exception $e) {
					\Log::error($e->getFile().':'.$e->getLine().', '.
						$e->getMessage());
				}
				endif;
			}
		}

		$adTargetDetails = AdTarget::where("target","lpage_slider")->first();
		if($adTargetDetails == null){
			$adTargetDetails = new AdTarget;
			$adTargetDetails->target 	   = "lpage_slider";
			$adTargetDetails->description  = "Slider Images";
			$adTargetDetails->route 	   = "/";
			$adTargetDetails->save();
		}

		$advert = AdControl::where("adtarget_id", $adTargetDetails->id)->
			first();

		$isAdControlAvailable = true;
		if($advert == null){
			$advert = new AdControl;
			$isAdControlAvailable = false;
		}

		$advert->height        = $request->get("height");
		$advert->width         = $request->get("width");
		$advert->nav           = "no";
		$advert->rotation_time = $request->get("rottime");
		$advert->priority      = 0;

		if($isAdControlAvailable == true){
			$advert->update();

		} else {
			$advert->adtarget_id   = $adTargetDetails->id;
			$advert->save();
		}

		$targetsArray		  = $request->get("target");
		$sliderImagesArray    = $request->file("slider_image");
		
		 for($i=0; $i<count($sliderImagesArray); $i++){
			
            if($request->hasFile('slider_image') && !empty($sliderImagesArray[$i])){
                
                $target    = $targetsArray[$i];
             	$advertImage           		   = new AdImage();
				$advertImage->adcontrol_id	   = $advert->id;
				$advertImage->advertisement_id = null;
				$advertImage->path             = "";
				$advertImage->temp_path        = "/";
				$advertImage->target           = $target;
				$advertImage->save();

				$imageName = $sliderImagesArray[$i]->getClientOriginalName();
                $imagePath = $this->slider_path.$advertImage->id."/".$imageName;
                Storage::disk('slider-data')->put($imagePath,  File::get($sliderImagesArray[$i]));

                $advertImage->temp_path = $imageName;
                $advertImage->update();
            }
        }

        if($request->get("old_target") !== null &&
			count($request->get("old_target")) > 0){
        	for($i=0; $i<count($request->get("old_target")); $i++){
        		AdImage::where("id", $request->get("ids")[$i])->
					update(["target" => $request->get("old_target")[$i]]);
        	}
        }
        return redirect()->back();
	}	
	
	public function advertSmallImage(Request $request)
	{
		/*Small Top Image*/
		$adTargetDetails = AdTarget::where("target","lpage_internal_top")->
			first();

		if($adTargetDetails == null){
			$adTargetDetails = new AdTarget;
			$adTargetDetails->target 	   = "lpage_internal_top";
			$adTargetDetails->description  = "Landing Page Internal Top";
			$adTargetDetails->route 	   = "/";
			$adTargetDetails->save();
		}

		$adSmallTopImage =
			AdControl::where("adtarget_id", $adTargetDetails->id)->first();

		$isSmallImageAvailable = true;
		if($adSmallTopImage == null){
			$adSmallTopImage = new AdControl;
			$isSmallImageAvailable = false;
		}

		$adSmallTopImage->height        = 0;
		$adSmallTopImage->width         = 0;
		$adSmallTopImage->nav           = "no";
		$adSmallTopImage->rotation_time = 0;
		$adSmallTopImage->priority      = 0;

		if($isSmallImageAvailable == true){
			$adSmallTopImage->update();

		} else {
			$adSmallTopImage->adtarget_id = $adTargetDetails->id;
			$adSmallTopImage->save();
		}
		
		if($request->file("slider_image_top") != null){

				$adTopImage = new AdImage;

				$adTopImage->advertisement_id = null;
				$adTopImage->path   	  	  = "";
				$adTopImage->temp_path   	  	  = "/";
				$adTopImage->target 	  	  = $request->get("toptarget");
				$adTopImage->adcontrol_id 	  = $adSmallTopImage->id;
				$adTopImage->save();

				$fileTop = $request->file("slider_image_top"); 
	        	$imageNameTop = $fileTop->getClientOriginalName();
	        	$imagePathTop = $this->slider_path.$adTopImage->id."/".$imageNameTop;
	        	Storage::disk('slider-data')->put($imagePathTop,  File::get($fileTop));
				
				$adTopImage->temp_path = $imageNameTop;
				$adTopImage->update();
		}

		if($request->get("old_toptarget") != null){

			$adTopImage = AdImage::where("adcontrol_id", $adSmallTopImage->id)->first();

			$adTopImage->target = $request->get("old_toptarget");
			$adTopImage->update();
		}
		
		return redirect()->back();
	}

	public function advertSmallbImage(Request $request)
	{
		/*Small Bottom Image*/
		$adTargetDetails = AdTarget::where("target","lpage_internal_bottom")->first();

		if($adTargetDetails == null){
			$adTargetDetails = new AdTarget;
			$adTargetDetails->target 	   = "lpage_internal_bottom";
			$adTargetDetails->description  = "Landing Page Internal Bottom";
			$adTargetDetails->route 	   = "/";
			$adTargetDetails->save();
		}

		$adSmallBottomImage = AdControl::where("adtarget_id", $adTargetDetails->id)->first();

		$isSmallImageAvailable = true;
		if($adSmallBottomImage == null){
			$adSmallBottomImage = new AdControl;
			$isSmallImageAvailable = false;
		}

		$adSmallBottomImage->height        = 0;
		$adSmallBottomImage->width         = 0;
		$adSmallBottomImage->nav           = "no";
		$adSmallBottomImage->rotation_time = 0;
		$adSmallBottomImage->priority      = 0;

		if($isSmallImageAvailable == true){
			$adSmallBottomImage->update();		

		} else {
			$adSmallBottomImage->adtarget_id = $adTargetDetails->id;
			$adSmallBottomImage->save();
		}	

		if($request->file("slider_image_bottom") != null){

			$adBottomImage = new AdImage;
			$adBottomImage->path   		 = "";
			$adBottomImage->temp_path    = "/";
			$adBottomImage->target 		 = $request->get("bottomtarget");
			$adBottomImage->adcontrol_id = $adSmallBottomImage->id;
			$adBottomImage->save();

			$fileBottom = $request->file("slider_image_bottom"); 
	        $imageNameBottom = $fileBottom->getClientOriginalName();
	        $imagePathBottom = $this->slider_path.$adBottomImage->id."/".$imageNameBottom;
	        Storage::disk('slider-data')->put($imagePathBottom,  File::get($fileBottom));

	        $adBottomImage->temp_path = $imageNameBottom;
	        $adBottomImage->update();
		}
		
		if($request->get("old_bottomtarget") != null){
			$adBottomImage = AdImage::where("adcontrol_id", $adSmallBottomImage->id)->first();

			$adBottomImage->target = $request->get("old_bottomtarget");
			$adBottomImage->update();
		}
		return redirect()->back();
	}


	public function advertOshopImage(Request $request) {
		if(!empty($request->get('delete_oshop_image'))) {
			$delete_images = explode(",",trim($request->get('delete_oshop_image'),','));
			foreach($delete_images as $image) {
				$adImageDetails = AdImage::where("id",$image)->first();

				if($adImageDetails):

				$path = $this->slider_path.$adImageDetails->id.
					"/".$adImageDetails->temp_path;

				try {
					Storage::disk('slider-data')->delete($path);
					$adImageDetails->delete();
				} catch (\Exception $e) {
					\Log::error($e->getFile().':'.$e->getLine().', '.
						$e->getMessage());
				}

				endif;
			}
		}

		if($request->get("old_target") !== null &&
			count($request->get("old_target")) > 0){
        	for($i=0; $i<count($request->get("old_target")); $i++){
        		AdImage::where("id", $request->get("ids")[$i])->
					update(["target" => $request->get("old_target")[$i]]);
        	}
        }

		/*Oshop Image*/
		$adTargetDetails = AdTarget::where("target","lpage_oshop")->first();

		if($adTargetDetails == null){
			$adTargetDetails = new AdTarget;
			$adTargetDetails->target 	   = "lpage_oshop";
			$adTargetDetails->description  = "Landing Page O-Shop";
			$adTargetDetails->route 	   = "/";
			$adTargetDetails->save();
		}

		$adOshopImage = AdControl::where("adtarget_id", $adTargetDetails->id)->first();

		$isOshopImageAvailable = true;
		if($adOshopImage == null){
			$adOshopImage = new AdControl;
			$isOshopImageAvailable = false;
		}

		$adOshopImage->height        = 0;
		$adOshopImage->width         = 0;
		$adOshopImage->nav           = "no";
		$adOshopImage->rotation_time = 0;
		$adOshopImage->priority      = 0;

		if($isOshopImageAvailable == true){
			$adOshopImage->update();		

		} else {
			$adOshopImage->adtarget_id = $adTargetDetails->id;
			$adOshopImage->save();
		}

		$targetsArray	= $request->get("target");
		$oshopImagesArray    = $request->file("slider_oshop_image");

		/*if($request->has('hidden_oshop_images'))
		{
			$hiddenArray	= $request->get("hidden_oshop_images");
			foreach($hiddenArray as $key => $value)
			{
				$adimage = AdImage::find($value);
				$adimage->target = $targetsArray[$key];
				$adimage->save(); 
			}
		}*/

		for($i=0; $i<count($oshopImagesArray); $i++){
			if (isset($oshopImagesArray[$i])) {
				if($request->hasFile('slider_oshop_image') && !empty($oshopImagesArray[$i])){
					$target    = $targetsArray[$i];
					$advertImage = new AdImage();
					$advertImage->adcontrol_id	   = $adOshopImage->id;
					$advertImage->advertisement_id = null;
					$advertImage->path             = "";
					$advertImage->temp_path        = "/";
					$advertImage->target           = $target;
					$advertImage->save();
					$imageName = $oshopImagesArray[$i]->getClientOriginalName();
					$imagePath = $this->slider_path.$advertImage->id."/".$imageName;
					Storage::disk('slider-data')->put($imagePath,
						File::get($oshopImagesArray[$i]));
					$advertImage->temp_path = $imageName;
					$advertImage->update();
				}
			}
		}
		
		/*if($request->get("old_bottomtarget") != null){
			$adBottomImage = AdImage::where("adcontrol_id", $adSmallBottomImage->id)->first();

			$adBottomImage->target = $request->get("old_bottomtarget");
			$adBottomImage->update();
		}*/
		return redirect()->back();
	}

	public function rightImageSlider(Request $request){
        $top_container =
			AdTarget::where("target","lpage_internal_top")->
			with("AdControl.AdImages")->first();

        return ["top_container" => $top_container];
	}

	public function rightbImageSlider(Request $request){
        $bottom_container =
			AdTarget::where("target","lpage_internal_bottom")->
			with("AdControl.AdImages")->first();

        return ["bottom_container" => $bottom_container];
	}

	public function oshopSlider(Request $request){
        $oshop_container =
			AdTarget::where("target","lpage_oshop")->
			with("AdControl.AdImages")->first();

		/*
		$oshop = Oshop::whereNotNull('oshop_name')->
			where('oshop_name','!=','Single')->
			where('oshop_name','!=','Temp')->
			where('url','!=','')->
			where('status','active')->
			whereNotNull('url')->
			orderby('oshop_name')->
			groupby('oshop_name')->
			get()->pluck('oshop_name','url');
		*/

		$oshop = DB::select(DB::raw("select 
				o.oshop_name, o.url
			from
				oshop o,
				merchantoshop mo,
				merchant m
			where
				o.oshop_name is not null and
				o.oshop_name != 'Single' and
				o.oshop_name != 'Temp' and
				o.oshop_name != 'Test' and
				o.url is not null and
				o.url != '' and
				mo.oshop_id = o.id and
				mo.merchant_id = m.id and
				m.status = 'active' and
				o.status = 'active'
			group by
				o.oshop_name
			order by 
				o.oshop_name
		"));


		$max = Globals::find('1')->adv_lp_max_oshop_images;

        return ["oshop_container" => $oshop_container, "max" => $max,
			"oshop" => $oshop];
	}

	public function leftImageSlider(Request $request)
	{
		return AdTarget::where("target","lpage_slider")->
			with("AdControl.AdImages")->first();
	}

	public function deleteSliderImage(Request $request)
	{
		$adImageDetails = AdImage::where("id",$request->get("id"))->first();
		//dd($adImageDetails);
		$path = $this->slider_path.$adImageDetails->id."/".
			$adImageDetails->temp_path;

		try {
			Storage::disk('slider-data')->delete($path);
			$adImageDetails->delete();
		} catch (\Exception $e) {
			//dd($e);
			$adImageDetails->delete();
			\Log::error($e->getFile().':'.$e->getLine().', '.
				$e->getMessage());
		}
	}

	public function uploadPublicImage(){
		AdImage::whereNull('deleted_at')->update(['adimage.path' => \DB::raw('adimage.temp_path')]);
		AdImage::whereNull('deleted_at')->update(['adimage.hide_public' => \DB::raw('adimage.hide')]);
		//AdImage::where('updated', '0')->update(['updated' => '1']);
		return "OK";
	}

	public function cateogoryAdvert($category)
	{
		if(!is_numeric($category))
		{
			return redirect()->back();
		}
	
		$cat_adv1 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'cat_adv1')
		->where('categoryadimage.category_id', $category)
		->select('adimage.*')
		->first();

		$cat_adv2 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'cat_adv2')
		->where('categoryadimage.category_id', $category)
		->select('adimage.*')
		->first();

		$cat_adv3 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'cat_adv3')
		->where('categoryadimage.category_id', $category)
		->select('adimage.*')
		->first();

		$cat_adv4 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'cat_adv4')
		->where('categoryadimage.category_id', $category)
		->select('adimage.*')
		->first();

		$cat_adv5 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'cat_adv5')
		->where('categoryadimage.category_id', $category)
		->select('adimage.*')
		->first();  

		$slider_path = $this->slider_path;

		$categoryImages = Category::find($category);

		$categories = Category::where('enable',true)->orderBy('floor')->get()->pluck('description','id');
		$subCategories = SubCatLevel1::where('category_id',$category)->orderBy('description')->get()->pluck('description','id');

		return view("advertisement.advert_category_preview",
			compact('categories','categoryImages','slider_path','subCategories','cat_adv1','cat_adv2','cat_adv3','cat_adv4','cat_adv5'));
	}

	public function categoryImage(Request $request)
	{
		if(!empty($request->get('delete_cat_image')))
		{
			$delete_images = explode(",",trim($request->get('delete_cat_image'),','));
			foreach($delete_images as $image) {
				$adImageDetails = AdImage::where("id",$image)->first();
				$categoryAdImage = Categoryadimage::where("adimage_id",$image)->first();

				$path = $this->slider_path.$adImageDetails->id.
					"/".$adImageDetails->temp_path;

				try {
					Storage::disk('slider-data')->delete($path);
					$adImageDetails->delete();
					if(!empty($categoryAdImage)){
						$categoryAdImage->delete();
					}
				} catch (\Exception $e) {
					\Log::error($e->getFile().':'.$e->getLine().', '.
						$e->getMessage());
				}
			}
		}

		$adTargetDetails = AdTarget::where("target",$request->get('adv_target'))->first();
		if($adTargetDetails == null){
			$adTargetDetails = new AdTarget;
			$adTargetDetails->target 	   = $request->get('adv_target');
			$adTargetDetails->description  = $request->get('adv_target');
			$adTargetDetails->route 	   = "/";
			$adTargetDetails->save();
		}

		$advert = AdControl::where("adtarget_id", $adTargetDetails->id)->
			first();

		$isAdControlAvailable = true;
		if($advert == null){
			$advert = new AdControl;
			$isAdControlAvailable = false;
		}

		$advert->height        = 0;
		$advert->width         = 0;
		$advert->nav           = "no";
		$advert->rotation_time = 0;
		$advert->priority      = 0;

		if($isAdControlAvailable == true){
			$advert->update();

		} else {
			$advert->adtarget_id   = $adTargetDetails->id;
			$advert->save();
		}

		if($request->hasFile('category_image')){
            
            $advertImage           		   = new AdImage();
			$advertImage->adcontrol_id	   = $advert->id;
			$advertImage->advertisement_id = null;
			$advertImage->path             = "";
			$advertImage->temp_path        = "/";
			$advertImage->target           = $request->get('target');
			$advertImage->save();

			$categoryImage = $request->file("category_image");
			$imageName = $categoryImage->getClientOriginalName();
            $imagePath = $this->slider_path.$advertImage->id."/".$imageName;
            Storage::disk('slider-data')->put($imagePath,  File::get($categoryImage));

            $advertImage->temp_path = $imageName;
            $advertImage->update();

            // Add image to transaction table
            $categoryAdImage = new Categoryadimage();
            $categoryAdImage->category_id = $request->get('category_id');
            $categoryAdImage->adimage_id = $advertImage->id;
            $categoryAdImage->save();
        }
        
        if($request->get("old_target") !== null){
        	AdImage::where("id", $request->get("ids"))->
					update(["target" => $request->get("old_target")]);
        }
        return redirect()->back();
	}

	public function categoryImageList(Request $request, $category)
	{
		$categoryad_image = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', $request->get('target'))
		->where('categoryadimage.category_id', $category)
		->select('adimage.*')
		->first();

		return response()->json($categoryad_image);
	}

	public function subcateogoryAdvert($category)
	{
		if(!is_numeric($category))
		{
			return redirect()->back();
		}
	
		$subcat_adv1 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'subcat_adv1')
		->where('categoryadimage.category_id', $category)
		->select('adimage.*')
		->first();

		$subcat_adv2 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'subcat_adv2')
		->where('categoryadimage.category_id', $category)
		->select('adimage.*')
		->first();

		$subcat_adv3 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'subcat_adv3')
		->where('categoryadimage.category_id', $category)
		->select('adimage.*')
		->first();

		$subcat_adv4 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'subcat_adv4')
		->where('categoryadimage.category_id', $category)
		->select('adimage.*')
		->first();

		$subcat_adv5 = DB::table('adtarget')
		->leftJoin('adcontrol', 'adtarget.id', '=', 'adcontrol.adtarget_id')
		->leftJoin('adimage', 'adcontrol.id', '=', 'adimage.adcontrol_id')
		->leftJoin('categoryadimage', 'adimage.id', '=', 'categoryadimage.adimage_id')
		->where('adtarget.target', 'subcat_adv5')
		->where('categoryadimage.category_id', $category)
		->select('adimage.*')
		->first();  

		$slider_path = $this->slider_path;

		$categoryImages = SubCatLevel1::find($category);
		$subcatlevel = SubCatLevel1::find($category);
	//	dd($subcatlevel);

		$categories = Category::where('enable',true)->orderBy('floor')->get()->pluck('description','id');
		$subCategories = SubCatLevel1::where('category_id',$subcatlevel->category_id)->orderBy('description')->get()->pluck('description','id');

		return view("advertisement.advert_subcategory_preview",
			compact('categories','categoryImages','slider_path','subCategories','subcat_adv1','subcat_adv2','subcat_adv3','subcat_adv4','subcat_adv5'));
	}

	public function subcategoryImage(Request $request)
	{
		if(!empty($request->get('delete_subcat_image')))
		{
			$delete_images = explode(",",trim($request->get('delete_subcat_image'),','));
			foreach($delete_images as $image) {
				$adImageDetails = AdImage::where("id",$image)->first();
				$categoryAdImage = Categoryadimage::where("adimage_id",$image)->first();

				$path = $this->slider_path.$adImageDetails->id.
					"/".$adImageDetails->temp_path;

				try {
					Storage::disk('slider-data')->delete($path);
					$adImageDetails->delete();
					if(!empty($categoryAdImage)){
						$categoryAdImage->delete();
					}
				} catch (\Exception $e) {
					\Log::error($e->getFile().':'.$e->getLine().', '.
						$e->getMessage());
				}
			}
		}

		$adTargetDetails = AdTarget::where("target",$request->get('sub_adv_target'))->first();
		if($adTargetDetails == null){
			$adTargetDetails = new AdTarget;
			$adTargetDetails->target 	   = $request->get('sub_adv_target');
			$adTargetDetails->description  = $request->get('sub_adv_target');
			$adTargetDetails->route 	   = "/";
			$adTargetDetails->save();
		}

		$advert = AdControl::where("adtarget_id", $adTargetDetails->id)->
			first();

		$isAdControlAvailable = true;
		if($advert == null){
			$advert = new AdControl;
			$isAdControlAvailable = false;
		}

		$advert->height        = 0;
		$advert->width         = 0;
		$advert->nav           = "no";
		$advert->rotation_time = 0;
		$advert->priority      = 0;

		if($isAdControlAvailable == true){
			$advert->update();

		} else {
			$advert->adtarget_id   = $adTargetDetails->id;
			$advert->save();
		}

		if($request->hasFile('sub_category_image')){
            
            $advertImage           		   = new AdImage();
			$advertImage->adcontrol_id	   = $advert->id;
			$advertImage->advertisement_id = null;
			$advertImage->path             = "";
			$advertImage->temp_path        = "/";
			$advertImage->target           = $request->get('target');
			$advertImage->save();

			$categoryImage = $request->file("sub_category_image");
			$imageName = $categoryImage->getClientOriginalName();
            $imagePath = $this->slider_path.$advertImage->id."/".$imageName;
            Storage::disk('slider-data')->put($imagePath,  File::get($categoryImage));

            $advertImage->temp_path = $imageName;
            $advertImage->update();

            // Add image to transaction table
            $categoryAdImage = new Categoryadimage();
            $categoryAdImage->category_id = $request->get('subcategory_id');
            $categoryAdImage->adimage_id = $advertImage->id;
            $categoryAdImage->save();
        }
        
        if($request->get("old_target") !== null){
        	AdImage::where("id", $request->get("ids"))->
					update(["target" => $request->get("old_target")]);
        }
        return redirect()->back();
	}

	public function subCategoryList(Request $request, $category)
	{
		return SubCatLevel1::where('category_id',$category)->orderBy('description')->get()->pluck('description','id');
	}

	public function hideAdvertImage(Request $request, $target){
		$oshoptarget = AdTarget::with('AdControl.AdImages')->where('target',$target)->first();
		
		if($oshoptarget && !empty($oshoptarget->AdControl)){
			$hidden_val = $oshoptarget->is_hidden ? '0' : '1';
			$adtarget = AdTarget::find($oshoptarget->id);
			$adtarget->is_hidden = $hidden_val;
			$adtarget->save();
			$adControlId = $oshoptarget->AdControl->id;
			AdControl::find($adControlId)->AdImages()->update(['hide'=>$hidden_val]);
		}
		
		return $hidden_val;
		#return redirect()->back();
	}
}