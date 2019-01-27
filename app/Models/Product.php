<?php

namespace App\Models;

use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Image;
use URL;
use Carbon;
use Log;
class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'name', 'brand_id', 'category_id', 'subcat_id', 'subcat_level', 'photo_1', 'thumb_photo', 'free_delivery', 'flat_delivery', 'free_delivery_with_purchase_qty', 'del_worldwide', 'b2b_del_worldwide',
        'del_west_malaysia', 'del_sabah_labuan', 'del_sarawak', 'cov_country_id', 'cov_state_id',
        'b2b_del_west_malaysia', 'b2b_del_sabah_labuan', 'b2b_del_sarawak', 'b2b_cov_country_id', 'b2b_cov_state_id',
        'cov_city_id', 'b2b_cov_city_id', 'retail_price', 'original_price', 'discounted_price', 'private_retail_price', 'private_discounted_price', 'available', 'private_available', 'owarehouse_moq', 'owarehouse_price'
        ,'description', 'type', 'segment','oshop_selected','parent_id','del_option','del_height','del_weight','del_width','del_lenght','height','weight','width','length','delivery_time','delivery_time_to','cashback',
        'pcashback','private_cashback','voucher_package_qty','voucher_qty_limit','expiry_date','has_serialno'
    ];

    public function adSlots()
    {
        return $this->belongsToMany('App\Models\AdSlot', 'adslotproduct', 'product_id', 'adslot_id');
    }

    public function Country()
    {
        return $this->belongsTo('App\Models\Country', 'cov_country_id', 'id'); 
    }

    public function State()
    {
        return $this->belongsTo('App\Models\State', 'cov_state_id', 'id');
    }

    public function City()
    {
        return $this->belongsTo('App\Models\City', 'cov_city_id', 'id');
    }

    public function Area()
    {
        return $this->belongsTo('App\Models\Area', 'cov_area_id', 'id');
    }   
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory()
    {

        return $this->belongsTo('App\Models\Category', 'subcat_id');
    }

    // Function
    public function subCat()
    {
        if ($this->subcat_level == 1) {
//            return SubCatLevel1::whereId($subcat_id)
            return $this->belongsTo('App\Models\SubCatLevel1', 'subcat_id');
        } else if ($this->subcat_level == 2) {
//            return SubCatLevel2::whereId($subcat_id);
            return $this->belongsTo('App\Models\SubCatLevel2', 'subcat_id');
        } else {
//            return SubCatLevel3::whereId($subcat_id);
            return $this->belongsTo('App\Models\SubCatLevel3', 'subcat_id');
        }
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    public function wholesale()
    {
        return $this->hasMany('App\Models\Wholesale');
    }

    public function productdealer()
    {
        return $this->hasMany('App\Models\ProductDealer');
    }

    public function specification()
    {
        return $this->belongsToMany('App\Models\Specification', 'productspec', 'spec_id', 'product_id');
    }

    public function merchant()
    {
        return $this->belongsToMany('App\Models\Merchant', 'merchantproduct','product_id','merchant_id');
    }

    public function productspecs()
    {
        return $this->hasMany('App\Models\Productspec');
    }

    public function adSlotProduct()
    {
        return $this->hasOne('App\Models\AdslotProduct');
    }

    public function Owarehouse()
    {
        return $this->belongsTo('App\Models\Owarehouse', 'id', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany('App\Models\POrder', 'orderproduct', 'product_id', 'porder_id')->withTimestamps()->withPivot(['quantity', 'deleted_at']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dealers()
    {
        return $this->belongsToMany('App\Models\Dealer', 'productdealer', 'product_id', 'dealer_id')->withTimestamps()->withPivot(
            [
                'special_unit',
                'special_price',
                'deleted_at'
            ]
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function voucher()
    {
        return $this->hasOne('App\Models\Voucher');
    }



    /**********************************************************************
     * created by khakan
     */
    /*
     * Saved New products
     */
    public function store($request)
    {
        $product = new Product();
        $type="product";
        if ($request->get("del_option")=="service") {
            $type="service";
        }elseif ($request->get("del_option")=="voucher") {
            $type="voucher";
        }elseif ($request->get("del_option")=="warranty") {
            $type="warranty";
        }
        
        $record = [
            'name' => $request->get('name'),
            'brand_id' => $request->get('brand_id'),
            'category_id' => $request->get('category_id'),
            'subcat_id' => $request->get('subcat_id'),
            'free_delivery' => $request->get('free_delivery') ? $request->get('free_delivery') : 0,
            'del_worldwide' => $request->get('del_worldwide') ? $request->get('del_worldwide') : 0,
            'del_west_malaysia' => $request->get('del_west_malaysia') ? $request->get('del_west_malaysia') : 0,
            'del_sabah_labuan' => $request->get('del_sabah_labuan') ? $request->get('del_sabah_labuan') : 0,
            'del_sarawak' => $request->get('del_sarawak') ? $request->get('del_sarawak') : 0,
            'cov_country_id' => $request->get('cov_country_id'),
            'cov_state_id' => $request->get('cov_state_id'),
            'cov_city_id' => $request->get('cov_city_id'),
            'retail_price' => $request->get('retail_price'),
            'original_price' => $request->get('original_price'),
            'available' => $request->get('available'),
            'owarehouse_moq' => $request->get('owarehouse_moq'),
            'owarehouse_price' => $request->get('owarehouse_price'),
         //   'product_details' => $request->get('product_details'),
            'description' => $request->get('short_description'),
            'type' =>$type,
            'voucher_qty_limit' => $request->get('otc_qty_limit'),
            'voucher_package_qty'=>$request->get('voucher_package_qty'),
            'expiry_date'=>$request->get("voucher_expiry_date")

        ];

        $product_data = $product->create($record);
        $product_id = $product_data->id;
        $folder = base_path() . '/public/images/product/' . $product_id;
        File::makeDirectory($folder, 0777, true, true);
        $destination = $folder . '/';
        //chmod($folder,0775);
        $image = $request->file('product_photo');
        $image_name = $image->getClientOriginalName();
        if ($image->move($destination, $image_name)) {
            Product::where('id', $product_id)->update(['photo_1' => $image_name]);
        }
        return $product_data;
    }

	public static function smm_pr()
    {
        # code...
        return Product::join('merchantproduct','product.parent_id','=','merchantproduct.product_id')

        ->join('merchant','merchant.id','=','merchantproduct.merchant_id')
        ->join('oshopproduct','oshopproduct.product_id','='.'product.id')
        ->join('oshop','oshop.id','=','oshopproduct.oshop_id')
        ->where('merchant.status','active')
        ->where('merchant.status','active')
        ->where('product.smm_selected',1)
        ->where('product.oshop_selected',1)
        ->where('product.status','active')
        ->where('product.available','>',0)
        ->where('product.segment','b2c')
        ->orderBy('product.name','ASC')
        ->get();
    }

    /*This one saves the product*/
    public function storep($request,$merchant_id)
    {
        $input = Request::all();
        $product = new Product();
		if($request->get('subcat_id_3') != 0){
			$subcat_idarr = explode("-", $request->get('subcat_id_3'));
		} else {
			if($request->get('subcat_id_2') != 0){
				$subcat_idarr = explode("-", $request->get('subcat_id_2'));
			} else {
				$subcat_idarr = explode("-", $request->get('subcat_id'));
			}
		} 
        $subcat_id = $subcat_idarr[0];
        $level = 1;
        if(isset($subcat_idarr[1])){
            $level = $subcat_idarr[1];
        }
		$del_option = 'own'; 
		$type = 'product'; 
		if($request->get('del_option') == 'system'){
			$del_option = 'system';
        }	
		if($request->get('del_option') == 'pickup'){
			$del_option = 'pickup';
        }
		if($request->get('del_option') == 'voucher'){
			$del_option = 'own'; 
			$type = 'voucher'; 
		}		
        if($request->get('del_option') == 'service'){
            $del_option = 'own'; 
            $type = 'service'; 
        }
        // if($request->get('del_option') == 'warranty'){
        //     $del_option = 'own'; 
        //     $type = 'warranty';
        // }
        $expiry_date="";
        if ($request->get("del_option")=="voucher") {
            $type="voucher";
            $del_option="own";
            try {
               $expiry_date= Carbon::createFromFormat("m/d/Y",$request->get("expiry_date"));
            } catch (\Exception $e) {
                
            }
            
        }
		
		$cov_state_id = 0;
		if($request->get('cov_state_id') == "" || $request->get('cov_state_id') == 0){
			if(!($request->get('biz_state_id') == "" || $request->get('biz_state_id') == 0)){
				$cov_state_id = $request->get('biz_state_id');	
			}
		} else {
			$cov_state_id = $request->get('cov_state_id');
		}
		$cov_city_id = 0;
		if($request->get('cov_city_id') == "" || $request->get('cov_city_id') == 0){
			if(!($request->get('biz_city_id') == "" || $request->get('biz_city_id') == 0)){
				$cov_city_id = $request->get('biz_city_id');	
			}
		} else {
			$cov_city_id = $request->get('cov_city_id');
		}		
		$cov_area_id = 0;
		if($request->get('cov_area_id') == "" || $request->get('cov_area_id') == 0){
			if(!($request->get('biz_area_id') == "" || $request->get('biz_area_id') == 0)){
				$cov_area_id = $request->get('biz_area_id');	
			}
		} else {
			$cov_area_id = $request->get('cov_area_id');
		}
		$osel = false;
		if($request->get('oshop_id') > 0){
			$osel = true;
		} 
		$flat_delivery = 0;
		if(is_null($request->get('flat_delivery')) || $request->get('flat_delivery') == ""){
		} else {
			$flat_delivery = $request->get('flat_delivery');
		}
		$free_delivery = 0;
		if(is_null($request->get('free_delivery')) || $request->get('free_delivery') == ""){
			if(is_null($request->get('free_delivery_ow')) || $request->get('free_delivery_ow') == ""){
				
			} else {
				$free_delivery = $request->get('free_delivery_ow');
			}
		} else {
			$free_delivery = $request->get('free_delivery');
		}
		
		$free_delivery_qty = 0;
		if(is_null($request->get('free_delivery_with_purchase_qty')) || $request->get('free_delivery_with_purchase_qty') == "" || $request->get('free_delivery_with_purchase_qty') == 0){
			if(is_null($request->get('free_delivery_with_purchase_qty_ow')) || $request->get('free_delivery_with_purchase_qty_ow') == "" || $request->get('free_delivery_with_purchase_qty_ow') == 0){
				
			} else {
				$free_delivery_qty = $request->get('free_delivery_with_purchase_qty_ow') * 100;
			}
		} else {
			$free_delivery_qty = $request->get('free_delivery_with_purchase_qty') * 100;
		}
		//dd($request->get('prod_del_time'));
		$del_time = 5;
		if(!is_null($request->get('prod_del_time'))){
			$del_time = $request->get('prod_del_time');
		}
		$del_time_to = 7;
		if(!is_null($request->get('prod_del_time_to'))){
			$del_time_to = $request->get('prod_del_time_to');
		}
		//dd($del_time);
        // $checkboxvalue = 0;
        // if($request->get('has_serialno') == 1){
        //     $checkboxvalue = 1;
        // }
        $record = [
            'name' => $request->get('name'),
            'brand_id' => $request->get('brand_id'),
            'parent_id' => 0,
            'category_id' => $request->get('category_id'),
            'subcat_id' => $subcat_id,
            'subcat_level' => $level,
            'free_delivery' => $free_delivery,
            'flat_delivery' => $flat_delivery,
            'del_worldwide' => $request->get('del_worldwide') ? ($request->get('del_worldwide')*100) : 0,
            'del_west_malaysia' => $request->get('del_west_malaysia') ? ($request->get('del_west_malaysia')*100)  : 0,
            'del_sabah_labuan' => $request->get('del_sabah_labuan') ? ($request->get('del_sabah_labuan')*100) : 0,
            'del_sarawak' => $request->get('del_sarawak') ? ($request->get('del_sarawak')*100) : 0,
            'cov_country_id' => 150,
            'oshop_selected' => $osel,
            'cov_state_id' => $cov_state_id,
            'cov_city_id' => $cov_city_id,
            'cov_area_id' => $cov_area_id,
            'b2b_del_worldwide' => 0,
            'b2b_del_west_malaysia' => 0,
            'b2b_del_sabah_labuan' => 0,
            'b2b_del_sarawak' => 0,
            'b2b_cov_country_id' => 150,
            'b2b_cov_state_id' => 0,
            'b2b_cov_city_id' => 0,
            'b2b_cov_area_id' => 0,         
            'type' => $type,         
            'retail_price' => $request->get('retail_price') ? ($request->get('retail_price')*100) : 0,
            'private_retail_price' => $request->get('retail_price') ? ($request->get('retail_price')*100) : 0,
            'original_price' => $request->get('original_price') ? ($request->get('original_price')*100) : 0,
            'discounted_price' => $request->get('discounted_price') ? ($request->get('discounted_price')*100) : 0,
            'private_discounted_price' => $request->get('discounted_price') ? ($request->get('discounted_price')*100) : 0,
            'available' => $request->get('available'),
            'private_available' => $request->get('available'),
         //   'product_details' => $request->get('product_details'),
			'description' => $request->get('short_description'),
            'free_delivery_with_purchase_qty' => $free_delivery_qty,
            'free_delivery_with_purchase_amt' => $free_delivery_qty,
            'segment' => 'b2c',
            'del_option' => $del_option,
            'del_pricing' => $request->get('del_pricing') ? $request->get('del_pricing') : 0,
            'del_weight' => $request->get('del_weight') ? $request->get('del_weight') : 0,
            'del_height' => $request->get('del_height') ? $request->get('del_height') : 0,
            'del_lenght' => $request->get('del_lenght') ? $request->get('del_lenght') : 0,
            'del_width' => $request->get('width') ? $request->get('del_width') : 0,		
            'weight' => $request->get('prod_weight') ? $request->get('prod_weight') : 0,
            'height' => $request->get('prod_height') ? $request->get('prod_height') : 0,
            'length' => $request->get('prod_length') ? $request->get('prod_length') : 0,
            'width' => $request->get('prod_width') ? $request->get('prod_width') : 0,					
            'delivery_time' => $del_time,				
            'delivery_time_to' => $del_time_to,
            'voucher_qty_limit' => $request->get('otc_qty_limit'),
            'voucher_package_qty'=>$request->get('voucher_package_qty'),
            'expiry_date'=>$expiry_date,
            // 'has_serialno'=> $checkboxvalue
            // 'has_serialno'=>$request->get('has_serialno')?$request->get('has_serialno'):0
        ];
        $product_data = $product->create($record);

        $product_id = $product_data->id;
		$product_parent = Product::where('id', $product_id)->update(array('parent_id' => $product_id));
        $folder = base_path() . '/public/images/product/' . $product_id;
        $folder_thumb = base_path() . '/public/images/product/' . $product_id . '/thumb';
        File::makeDirectory($folder, 0777, true, true);
        File::makeDirectory($folder_thumb, 0777, true, true);
        $destination = $folder . '/';
        //chmod($folder,0775);
        $image = $request->file('product_photo');
        $image_thumb = $request->file('product_photo');
        if (isset($image)) {		
            $image_split = explode(".", $image->getClientOriginalName());
			$arr_size = count($image_split);
			$image_format = $image_split[$arr_size - 1];
			$image_name = "p".
				str_pad($product_id, 10, '0', STR_PAD_LEFT)."-"."m".
				str_pad($merchant_id, 10, '0', STR_PAD_LEFT)."-".
				rand(1000, 9999) . "." . $image_format;

			$image_thumb_name = "thumb_" . $image_name;
			$image_thumb400_name = "thumb400_" . $image_name;
			$image_aux_name = "aux_" . $image_name;
            try {
                    $fpath=public_path('images/product/'.$product_id);
                 File::makeDirectory(public_path($fpath), 0775, true);
                 
            } catch (\Exception $e) {
                
            }
            try {
                    $fpath=public_path('images/product/'.$product_id.'/thumb');
                 File::makeDirectory(public_path($fpath), 0775, true);
                 
            } catch (\Exception $e) {
                
            }
            if ($image->move($destination, $image_name)) {
				$auximg = Image::make(URL::to('/')."/images/product/".
					$product_id."/".$image_name)->
					save(public_path('images/product/'.$product_id.'/thumb/'.
					$image_aux_name));

				/*
				$width = $auximg->width();
				$height = $auximg->height();
				if($width >= $height){
					$twidth = 200;
					$t400width = 400;
					$theight = round(($height * 200)/$width);
					$t400height = round(($height * 400)/$width);
				} else {
					$theight = 200;
					$t400height = 400;
					$twidth = round(($width * 200)/$height);
					$t400width = round(($width * 400)/$height);
				}

				Image::make(URL::to('/')."/images/product/".$product_id.
					"/".$image_name)->
					fit($twidth, $theight)->
					save(public_path('images/product/'.$product_id.'/thumb/'.
						$image_thumb_name));

				Image::make(URL::to('/')."/images/product/".$product_id."/".
					$image_name)->
					fit($t400width, $t400height)->
					save(public_path('images/product/'.$product_id.'/thumb/'
						.$image_thumb400_name));
				*/

 				$imgpath = URL::to('/')."/images/product/".$product_id.
					"/".$image_name;
				$t200path = public_path('images/product/'.$product_id.
					'/thumb/'.$image_thumb_name);
				$t400path = public_path('images/product/'.$product_id.
					'/thumb/'.$image_thumb400_name);

				Image::make($imgpath)->
					resize(200, 200, function ($constraint) {
						$constraint->aspectRatio();
					})->save($t200path);

				Image::make($imgpath)->
					resize(400, 400, function ($constraint) {
						$constraint->aspectRatio();
					})->save($t400path);

				unlink(public_path('images/product/'.$product_id.'/thumb/'.
					$image_aux_name));

                Product::where('id', $product_id)->
					update([
					'photo_1' => $image_name,
					'thumb_photo' => $image_thumb_name,
					'thumb_photo2' => $image_thumb400_name
					]);
            }
        }
        //$product_data->photo_1 = $image_name;
        return $product_data;
    }
    
    public function storeb2b($request, $parent_id, $photo,$thumb_photo)
    {
        $input = Request::all();
        $product = new Product();
		if($request->get('subcat_id_3') != 0){
			$subcat_idarr = explode("-", $request->get('subcat_id_3'));
		} else {
			if($request->get('subcat_id_2') != 0){
				$subcat_idarr = explode("-", $request->get('subcat_id_2'));
			} else {
				$subcat_idarr = explode("-", $request->get('subcat_id'));
			}
		} 
        $subcat_id = $subcat_idarr[0];
        $level = 1;
        if(isset($subcat_idarr[1])){
            $level = $subcat_idarr[1];
        }
		$del_option = 'own';
        $type = 'product'; 
        if($request->get('del_option_b2b') == 'warranty'){
            $type = 'warranty';
        } 
		if($request->get('del_option_b2b') == 'system'){
			$del_option = 'system';
        }	
		if($request->get('del_option_b2b') == 'pickup'){
			$del_option = 'pickup';
        }	
		$cov_state_id = 0;
		if($request->get('cov_state_idb2b') == "" || $request->get('cov_state_idb2b') == 0){
			if(!($request->get('biz_state_id_b2b') == "" || $request->get('biz_state_id_b2b') == 0)){
				$cov_state_id = $request->get('biz_state_id_b2b');	
			}
		} else {
			$cov_state_id = $request->get('cov_state_idb2b');
		}
		$cov_city_id = 0;
		if($request->get('cov_city_idb2b') == "" || $request->get('cov_city_idb2b') == 0){
			if(!($request->get('biz_city_id_b2b') == "" || $request->get('biz_city_id_b2b') == 0)){
				$cov_city_id = $request->get('biz_city_id_b2b');	
			}
		} else {
			$cov_city_id = $request->get('cov_city_idb2b');
		}		
		$cov_area_id = 0;
		if($request->get('cov_area_idb2b') == "" || $request->get('cov_area_idb2b') == 0){
			if(!($request->get('biz_area_id_b2b') == "" || $request->get('biz_area_id_b2b') == 0)){
				$cov_area_id = $request->get('biz_area_id_b2b');	
			}
		} else {
			$cov_area_id = $request->get('cov_area_idb2b');
		}	
		$flat_delivery = 0;
		if(is_null($request->get('flat_deliveryb2b')) || $request->get('flat_deliveryb2b') == ""){
		} else {
			$flat_delivery = $request->get('flat_deliveryb2b');
		}
		$free_delivery = 0;
		if(is_null($request->get('free_deliveryb2b')) || $request->get('free_deliveryb2b') == ""){
			if(is_null($request->get('free_deliveryb2b_ow')) || $request->get('free_deliveryb2b_ow') == ""){
				
			} else {
				$free_delivery = $request->get('free_deliveryb2b_ow');
			}
		} else {
			$free_delivery = $request->get('free_deliveryb2b');
		}
		
		$free_delivery_qty = 0;
		if(is_null($request->get('free_delivery_with_purchase_qtyb2b')) || $request->get('free_delivery_with_purchase_qtyb2b') == ""){
			if(is_null($request->get('free_delivery_with_purchase_qtyb2b_ow')) || $request->get('free_delivery_with_purchase_qtyb2b_ow') == ""){
				
			} else {
				$free_delivery_qty = $request->get('free_delivery_with_purchase_qtyb2b_ow') * 100;
			}
		} else {
			$free_delivery_qty = $request->get('free_delivery_with_purchase_qtyb2b') * 100;
		}	

        $checkboxvalue = 0;
        if($request->get('has_serialno') == 1){
            $checkboxvalue = 1;
        }	

        $record = [
            'name' => $request->get('name'),
            'brand_id' => $request->get('brand_id'),
            'parent_id' => $parent_id,
            'category_id' => $request->get('category_id'),
            'subcat_id' => $subcat_id,
            'subcat_level' => $level,
            'photo_1' => $photo,
            'thumb_photo' => $thumb_photo,
            'free_delivery' => $free_delivery,
            'flat_delivery' => $flat_delivery,
            'del_worldwide' => 0,
            'del_west_malaysia' => 0,
            'del_sabah_labuan' => 0,
            'del_sarawak' => 0,
            'cov_country_id' => 150,
            'cov_state_id' => $cov_state_id,
            'cov_city_id' => $cov_city_id,
            'cov_area_id' => $cov_area_id,       
            'b2b_del_worldwide' => $request->get('del_worldwideb2b') ? ($request->get('del_worldwideb2b')*100) : 0,
            'b2b_del_west_malaysia' => $request->get('del_west_malaysiab2b') ? ($request->get('del_west_malaysiab2b')*100)  : 0,
            'b2b_del_sabah_labuan' => $request->get('del_sabah_labuanb2b') ? ($request->get('del_sabah_labuanb2b')*100) : 0,
            'b2b_del_sarawak' => $request->get('del_sarawakb2b') ? ($request->get('del_sarawakb2b')*100) : 0,
            'b2b_cov_country_id' => 150,
            'b2b_cov_state_id' => $request->get('cov_state_idb2b') ? $request->get('cov_state_idb2b') : 0,
            'b2b_cov_city_id' => $request->get('cov_city_idb2b') ? $request->get('cov_city_idb2b') : 0,
            'b2b_cov_area_id' => $request->get('cov_area_idb2b') ? $request->get('cov_area_idb2b') : 0,
            'private_retail_price' => $request->get('retail_price') ? ($request->get('retail_price')*100) : 0,
            'retail_price' => $request->get('retail_price') ? ($request->get('retail_price')*100) : 0,
            'original_price' => $request->get('original_price') ? ($request->get('original_price')*100) : 0,
            'discounted_price' => 0,
            'private_discounted_price' => 0,
            'available' => $request->get('available_b2b'),
            'private_available' => $request->get('available_b2b'),
        //    'product_details' => $request->get('product_detailsb2b'),
			'description' => $request->get('short_description'),
            'free_delivery_with_purchase_qty' => $free_delivery_qty,
            'free_delivery_with_purchase_amt' => $free_delivery_qty,
            'segment' => 'b2b',
            'del_option' => $del_option,
            'del_pricing' => $request->get('del_pricing') ? $request->get('del_pricing') : 0,
            'del_weight' => $request->get('del_weight') ? $request->get('del_weight') : 0,
            'del_height' => $request->get('del_height') ? $request->get('del_height') : 0,
            'del_lenght' => $request->get('del_lenght') ? $request->get('del_lenght') : 0,
            'del_width' => $request->get('del_width') ? $request->get('del_width') : 0,
            'weight' => $request->get('prod_weightb2b') ? $request->get('prod_weightb2b') : 0,
            'height' => $request->get('prod_heightb2b') ? $request->get('prod_heightb2b') : 0,
            'length' => $request->get('prod_lengthb2b') ? $request->get('prod_lengthb2b') : 0,
            'width' => $request->get('prod_widthb2b') ? $request->get('prod_widthb2b') : 0,
			'delivery_time' => $request->get('prod_del_timeb2b') ? $request->get('prod_del_timeb2b') : 5,		
			'delivery_time_to' => $request->get('prod_del_time_tob2b') ? $request->get('prod_del_time_tob2b') : 7,
            'type' => $type,
            'has_serialno'=>$checkboxvalue
        ];
        $product_data = $product->create($record);
        $product_id = $product_data->id;
        try{
            /*$folder = base_path() . '/public/images/product/' . $product_id;
            File::makeDirectory($folder, 0777, true, true);
            $destination = $folder . '/';
            //chmod($folder,0775);
            $image = $request->file('product_photo');
            $image_name = $image->getClientOriginalName();
            if ($image->move($destination, $image_name)) {
                Product::where('id', $product_id)->update(['photo_1' => $image_name]);
            }*/
        } catch (Exception $e) {
            //Excepton
        }
        return $product_data;
    }
    
    public function storepedit($request, $hsfile, $merchant_id)
    {
        $request->free_delivery_with_purchase_amt=intval(round($request->free_delivery_with_purchase_amt));
        // dump($request->free_delivery_with_purchase_amt);
		if($request->get('subcat_id_3') != 0){
			$subcat_idarr = explode("-", $request->get('subcat_id_3'));
		} else {
			if($request->get('subcat_id_2') != 0){
				$subcat_idarr = explode("-", $request->get('subcat_id_2'));
			} else {
				$subcat_idarr = explode("-", $request->get('subcat_id'));
			}
		} 
        $subcat_id = $subcat_idarr[0];
        $level = 1;
        if(isset($subcat_idarr[1])){
            $level = $subcat_idarr[1];
        }
 		$del_option = 'own'; 
        $type = 'product'; 
        if($request->get('del_option') == 'system'){
            $del_option = 'system';
        }   
        if($request->get('del_option') == 'pickup'){
            $del_option = 'pickup';
        }
        if($request->get('del_option') == 'voucher'){
            $del_option = 'own'; 
            $type = 'voucher'; 
        }       
        if($request->get('del_option') == 'service'){
            $del_option = 'own'; 
            $type = 'service'; 
        }
        // if($request->get('del_option') == 'warranty'){
        //     $del_option = 'own'; 
        //     $type = 'warranty';
        // }
        $expiry_date="";
        if ($request->get("del_option")=="voucher") {
            $type="voucher";
            $del_option="own";
            try {
               $expiry_date= Carbon::createFromFormat("m/d/Y",$request->get("expiry_date"));
            } catch (\Exception $e) {
                
            }
            
        }		
		$cov_state_id = 0;
		if($request->get('cov_state_id') == "" || $request->get('cov_state_id') == 0){
			if(!($request->get('biz_state_id') == "" || $request->get('biz_state_id') == 0)){
				$cov_state_id = $request->get('biz_state_id');	
			}
		} else {
			$cov_state_id = $request->get('cov_state_id');
		}
		$cov_city_id = 0;
		if($request->get('cov_city_id') == "" || $request->get('cov_city_id') == 0){
			if(!($request->get('biz_city_id') == "" || $request->get('biz_city_id') == 0)){
				$cov_city_id = $request->get('biz_city_id');	
			}
		} else {
			$cov_city_id = $request->get('cov_city_id');
		}		
		$cov_area_id = 0;
		if($request->get('cov_area_id') == "" || $request->get('cov_area_id') == 0){
			if(!($request->get('biz_area_id') == "" || $request->get('biz_area_id') == 0)){
				$cov_area_id = $request->get('biz_area_id');	
			}
		} else {
			$cov_area_id = $request->get('cov_area_id');
		}	       
		$flat_delivery = 0;
		if(is_null($request->get('flat_delivery')) || $request->get('flat_delivery') == ""){
		} else {
			$flat_delivery = $request->get('flat_delivery');
		}		
		$free_delivery = 0;
		if(is_null($request->get('free_delivery')) || $request->get('free_delivery') == ""){
			if(is_null($request->get('free_delivery_ow')) || $request->get('free_delivery_ow') == ""){
				
			} else {
				$free_delivery = $request->get('free_delivery_ow');
			}
		} else {
			$free_delivery = $request->get('free_delivery');
		}
		
		$free_delivery_qty = 0;
		if(is_null($request->get('free_delivery_with_purchase_amt')) || $request->get('free_delivery_with_purchase_amt') == "" || $request->get('free_delivery_with_purchase_amt') == 0){
			if(is_null($request->get('free_delivery_with_purchase_qty_ow')) || $request->get('free_delivery_with_purchase_qty_ow') == "" || $request->get('free_delivery_with_purchase_qty_ow') == 0){
				
			} else {
				$free_delivery_qty = $request->get('free_delivery_with_purchase_qty_ow') * 100;
			}
		} else {
			$free_delivery_qty = $request->get('free_delivery_with_purchase_amt') * 100;
		}
        // $checkboxvalue = 0;
        // if($request->get('has_serialno') == 1){
        //     $checkboxvalue = 1;
        // }
		
        $record = [
            'name' => $request->get('name'),
            'brand_id' => $request->get('brand_id'),
            'category_id' => $request->get('category_id'),
            'subcat_id' => $subcat_id,
            'subcat_level' => $level,
            'flat_delivery' => $flat_delivery,
            'free_delivery' => $free_delivery,
            'del_worldwide' => $request->get('del_worldwide') ? ($request->get('del_worldwide')*100) : 0,
            'del_west_malaysia' => $request->get('del_west_malaysia') ? ($request->get('del_west_malaysia')*100)  : 0,
            'del_sabah_labuan' => $request->get('del_sabah_labuan') ? ($request->get('del_sabah_labuan')*100) : 0,
            'del_sarawak' => $request->get('del_sarawak') ? ($request->get('del_sarawak')*100) : 0,
            'cov_country_id' => 150,
            'cov_state_id' => $cov_state_id,
            'cov_city_id' => $cov_city_id,
            'cov_area_id' => $cov_area_id,
            'b2b_del_worldwide' => 0,
            'b2b_del_west_malaysia' => 0,
            'b2b_del_sabah_labuan' => 0,
            'b2b_del_sarawak' => 0,
            'b2b_cov_country_id' => 150,
            'b2b_cov_state_id' => $request->get('cov_state_idb2b') ? $request->get('cov_state_idb2b') : 0,
            'b2b_cov_city_id' => $request->get('cov_city_idb2b') ? $request->get('cov_city_idb2b') : 0,
            'b2b_cov_area_id' => $request->get('cov_area_idb2b') ? $request->get('cov_area_idb2b') : 0,        
            'retail_price' => $request->get('retail_price') ? ($request->get('retail_price')*100) : 0,
            'private_retail_price' => $request->get('retail_price') ? ($request->get('retail_price')*100) : 0,
            'original_price' => $request->get('original_price') ? ($request->get('original_price')*100) : 0,
            'discounted_price' => $request->get('discounted_price') ? ($request->get('discounted_price')*100) : 0,
            'private_discounted_price' => $request->get('discounted_price') ? ($request->get('discounted_price')*100) : 0,
            'available' => $request->get('available'),
            'private_available' => $request->get('available'),
      //      'product_details' => $request->get('product_details'),
			'description' => $request->get('short_description'),
            'free_delivery_with_purchase_qty' => $free_delivery_qty,
            'free_delivery_with_purchase_amt'=>$free_delivery_qty,
            'segment' => 'b2c',
            'del_option' => $del_option,
            'type'=>$type,
            'del_pricing' => $request->get('del_pricing') ? $request->get('del_pricing') : 0,
            'del_weight' => $request->get('del_weight') ? $request->get('del_weight') : 0,
            'del_height' => $request->get('del_height') ? $request->get('del_height') : 0,
            'del_lenght' => $request->get('del_lenght') ? $request->get('del_lenght') : 0,
            'del_width' => $request->get('del_width') ? $request->get('del_width') : 0,
            'weight' => $request->get('prod_weight') ? $request->get('prod_weight') : 0,
            'height' => $request->get('prod_height') ? $request->get('prod_height') : 0,
            'length' => $request->get('prod_length') ? $request->get('prod_length') : 0,
            'width' => $request->get('prod_width') ? $request->get('prod_width') : 0,
			'delivery_time' => $request->get('prod_del_time') ? $request->get('prod_del_time') : 5,			
			'delivery_time_to' => $request->get('prod_del_time_to') ? $request->get('prod_del_time_to') : 7		,
            'voucher_qty_limit' => $request->get('otc_qty_limit'),
            'voucher_package_qty'=>$request->get('voucher_package_qty'),
            'expiry_date'=>$expiry_date,
            // 'has_serialno'=> $checkboxvalue
        ];
        // dump($record);
        $product_id = $request->get('myproduct_id');

        // $updateParentId = ['has_serialno'=> $checkboxvalue,'type'=>$type];

        $product_data = Product::where('id', $product_id)->update($record);
        // Product::where('parent_id', $product_id)->update($updateParentId);
        $product_data = Product::find($product_id);
        // $product_data->free_delivery_with_purchase_amt=$request->free_delivery_with_purchase_amt;
        // $product_data->save();
        if($hsfile){
            $folder = base_path() . '/public/images/product/' . $product_id;
            $folder_thumb = base_path() . '/public/images/product/' . $product_id . "thumb";
            try {
                    $fpath=public_path('images/product/'.$product_id);
                 File::makeDirectory(public_path($fpath), 0775, true);
                 
            } catch (\Exception $e) {
                
            }
            try {
                    $fpath=public_path('images/product/'.$product_id.'/thumb');
                 File::makeDirectory(public_path($fpath), 0775, true);
                 
            } catch (\Exception $e) {
                
            }
            $destination = $folder . '/';
            //chmod($folder,0775);
            $image = $request->file('product_photo');
			$image_split = explode(".", $image->getClientOriginalName());
			$arr_size = count($image_split);
			$image_format = $image_split[$arr_size - 1];
			$image_name = "p" . str_pad($product_id, 10, '0', STR_PAD_LEFT) . "-" . "m" . str_pad($merchant_id, 10, '0', STR_PAD_LEFT) . "-" . rand(1000, 9999) . "." . $image_format;
            $image_thumb_name = "thumb_" . $image_name;
			$image_thumb400_name = "thumb400_" . $image_name;
			$image_aux_name = "aux_" . $image_name;
			if ($image->move($destination, $image_name)) {
				$auximg = Image::make(URL::to('/')."/images/product/".$product_id."/".$image_name)->save(public_path('images/product/' . $product_id . '/thumb/'.$image_aux_name));
				$width = $auximg->width();
				$height = $auximg->height();
				if($width >= $height){
					$twidth = 200;
					$t400width = 400;
					$theight = round(($height * 200)/$width);
					$t400height = round(($height * 400)/$width);
				} else {
					$theight = 200;
					$t400height = 400;
					$twidth = round(($width * 200)/$height);
					$t400width = round(($width * 400)/$height);
				}
                Image::make(URL::to('/')."/images/product/".$product_id."/".$image_name)->fit($twidth, $theight)->save(public_path('images/product/' . $product_id . '/thumb/'.$image_thumb_name));
				Image::make(URL::to('/')."/images/product/".$product_id."/".$image_name)->fit($t400width, $t400height)->save(public_path('images/product/' . $product_id . '/thumb/'.$image_thumb400_name));
				unlink(public_path('images/product/' . $product_id . '/thumb/'.$image_aux_name));
                Product::where('id', $product_id)->update(['photo_1' => $image_name,'thumb_photo' => $image_thumb_name,'thumb_photo2' => $image_thumb400_name]);
            }
        }
        //$product_data->photo_1 = $image_name;
        return $product_data;
    }   
    
    public function storeb2bedit($request, $parent_id, $photo,$thumb_photo)
    {
        $input = Request::all();
		if($request->get('subcat_id_3') != 0){
			$subcat_idarr = explode("-", $request->get('subcat_id_3'));
		} else {
			if($request->get('subcat_id_2') != 0){
				$subcat_idarr = explode("-", $request->get('subcat_id_2'));
			} else {
				$subcat_idarr = explode("-", $request->get('subcat_id'));
			}
		} 
        $subcat_id = $subcat_idarr[0];
        $level = 1;
        if(isset($subcat_idarr[1])){
            $level = $subcat_idarr[1];
        }

 		$del_option = 'own';
        $type = 'product';

        if($request->get('del_option_b2b') == 'warranty'){
            $type = 'warranty';
        }
		if($request->get('del_option_b2b') == 'system'){
			$del_option = 'system';
        }	
		if($request->get('del_option_b2b') == 'pickup'){
			$del_option = 'pickup';
        }
		$cov_state_id = 0;
		if($request->get('cov_state_idb2b') == "" || $request->get('cov_state_idb2b') == 0){
			if(!($request->get('biz_state_id_b2b') == "" || $request->get('biz_state_id_b2b') == 0)){
				$cov_state_id = $request->get('biz_state_id_b2b');	
			}
		} else {
			$cov_state_id = $request->get('cov_state_idb2b');
		}
	/*	dump($request->get('cov_state_idb2b'));
		dump($request->get('biz_state_id_b2b'));
		dump($cov_state_id);*/
		$cov_city_id = 0;
		if($request->get('cov_city_idb2b') == "" || $request->get('cov_city_idb2b') == 0){
			if(!($request->get('biz_city_id_b2b') == "" || $request->get('biz_city_id_b2b') == 0)){
				$cov_city_id = $request->get('biz_city_id_b2b');	
			}
		} else {
			$cov_city_id = $request->get('cov_city_idb2b');
		}
		/*dump($request->get('cov_city_idb2b'));
		dump($request->get('biz_city_id_b2b'));
		dd($cov_city_id);		*/
		$cov_area_id = 0;
		if($request->get('cov_area_idb2b') == "" || $request->get('cov_area_idb2b') == 0){
			if(!($request->get('biz_area_idb_2b') == "" || $request->get('biz_area_id_b2b') == 0)){
				$cov_area_id = $request->get('biz_area_id_b2b');	
			}
		} else {
			$cov_area_id = $request->get('cov_area_idb2b');
		}	

		$flat_delivery = 0;
		//dd($request->get('flat_deliveryb2b'));
		if(is_null($request->get('flat_deliveryb2b')) || $request->get('flat_deliveryb2b') == ""){
		} else {
			$flat_delivery = $request->get('flat_deliveryb2b');
		}
		$free_delivery = 0;
		if(is_null($request->get('free_deliveryb2b')) || $request->get('free_deliveryb2b') == ""){
			if(is_null($request->get('free_deliveryb2b_ow')) || $request->get('free_deliveryb2b_ow') == ""){
				
			} else {
				$free_delivery = $request->get('free_deliveryb2b_ow');
			}
		} else {
			$free_delivery = $request->get('free_deliveryb2b');
		}
		
		$free_delivery_qty = 0;
		if(is_null($request->get('free_delivery_with_purchase_qtyb2b')) || $request->get('free_delivery_with_purchase_qtyb2b') == "" || $request->get('free_delivery_with_purchase_qtyb2b') == 0){
			if(is_null($request->get('free_delivery_with_purchase_qtyb2b_ow')) || $request->get('free_delivery_with_purchase_qtyb2b_ow') == "" || $request->get('free_delivery_with_purchase_qtyb2b_ow') == 0){
				
			} else {
				$free_delivery_qty = $request->get('free_delivery_with_purchase_qtyb2b_ow') * 100;
			}
		} else {
			$free_delivery_qty = $request->get('free_delivery_with_purchase_qtyb2b') * 100;
		}
        $checkboxvalue = 0;
        if($request->get('has_serialno') == 1){
            $checkboxvalue = 1;
        }
	/*	dump($free_delivery_qty);
		dump($request->get('free_delivery_with_purchase_qtyb2b_ow'));
		dd($request->get('free_delivery_with_purchase_qtyb2b'));*/
        $record = [
            'name' => $request->get('name'),
            'brand_id' => $request->get('brand_id'),
            'parent_id' => $parent_id,
            'category_id' => $request->get('category_id'),
            'subcat_id' => $subcat_id,
            'subcat_level' => $level,
            'photo_1' => $photo,
            'thumb_photo' => $thumb_photo,
            'free_delivery' => $free_delivery,
            'flat_delivery' => $flat_delivery,
            'del_worldwide' => 0,
            'del_west_malaysia' => 0,
            'del_sabah_labuan' => 0,
            'del_sarawak' => 0,
            'cov_country_id' => 150,
            'cov_state_id' => $cov_state_id,
            'cov_city_id' => $cov_city_id,
            'cov_area_id' => $cov_area_id,         
            'b2b_del_worldwide' => $request->get('del_worldwideb2b') ? ($request->get('del_worldwideb2b')*100) : 0,
            'b2b_del_west_malaysia' => $request->get('del_west_malaysiab2b') ? ($request->get('del_west_malaysiab2b')*100)  : 0,
            'b2b_del_sabah_labuan' => $request->get('del_sabah_labuanb2b') ? ($request->get('del_sabah_labuanb2b')*100) : 0,
            'b2b_del_sarawak' => $request->get('del_sarawakb2b') ? ($request->get('del_sarawakb2b')*100) : 0,
            'b2b_cov_country_id' => 150,
            'b2b_cov_state_id' => $request->get('cov_state_id') ? $request->get('cov_state_id') : 0,
            'b2b_cov_city_id' => $request->get('cov_city_id') ? $request->get('cov_city_id') : 0,
            'b2b_cov_area_id' => $request->get('cov_area_id') ? $request->get('cov_area_id') : 0,
            'private_retail_price' => $request->get('retail_price') ? ($request->get('retail_price')*100) : 0,
            'retail_price' => $request->get('retail_price') ? ($request->get('retail_price')*100) : 0,
            'original_price' => $request->get('original_price') ? ($request->get('original_price')*100) : 0,
            'discounted_price' => 0,
            'available' => $request->get('available_b2b'),
            'private_available' => $request->get('available_b2b'),
       //     'product_details' => $request->get('product_detailsb2b'),
			'description' => $request->get('short_description'),
            'free_delivery_with_purchase_qty' => $free_delivery_qty,
            'free_delivery_with_purchase_amt' => $free_delivery_qty,
            'segment' => 'b2b',
            'del_option' => $del_option,
            'del_pricing' => $request->get('del_pricing') ? $request->get('del_pricing') : 0,
            'del_weight' => $request->get('del_weight') ? $request->get('del_weight') : 0,
            'del_height' => $request->get('del_height') ? $request->get('del_height') : 0,
            'del_lenght' => $request->get('del_lenght') ? $request->get('del_lenght') : 0,
            'del_width' => $request->get('del_width') ? $request->get('del_width') : 0,
            'weight' => $request->get('prod_weightb2b') ? $request->get('prod_weightb2b') : 0,
            'height' => $request->get('prod_heightb2b') ? $request->get('prod_heightb2b') : 0,
            'length' => $request->get('prod_lengthb2b') ? $request->get('prod_lengthb2b') : 0,
            'width' => $request->get('prod_widthb2b') ? $request->get('prod_widthb2b') : 0,
			'delivery_time' => $request->get('prod_del_timeb2b') ? $request->get('prod_del_timeb2b') : 5,		
			'delivery_time_to' => $request->get('prod_del_time_tob2b') ? $request->get('prod_del_time_tob2b') : 7,
            'type' => $type,
            'has_serialno'=>$checkboxvalue
        ];
        $updateArray = [
            'type' => $type,
            'has_serialno'=>$checkboxvalue
        ];
        $product_id = $request->get('myproduct_id');
        $product_data = Product::where('parent_id', $product_id)->where('segment','b2b')->update($record);
        Product::where('parent_id', $product_id)->update($updateArray);
        $product_data = Product::where('parent_id', $product_id)->where('segment','b2b')->first();

        return $product_data;
    }   
	
	public function jc_product($request, $image, $merchant_id, $telcos_name, $price, $index, $parent, $subcatlevel, $subcat_id, $cat_id){
		$product = new Product();
		if($index == 0){
			$record = [
				'name' => $telcos_name . " " .  $price,
				'retail_price' => $price * 100,
				'subcat_id' => $subcat_id,
				'subcat_level' => $subcatlevel,
				'category_id' => $cat_id,
				'segment'=> 'b2c',
				'oshop_selected'=>1
			];				
		} else {
			$record = [
				'name' => $telcos_name . " " .  $price,
				'retail_price' => $price * 100,
				'subcat_id' => $subcat_id,
				'subcat_level' => $subcatlevel,
				'category_id' => $cat_id,
				'segment'=> 'custom',
				'oshop_selected'=>1
			];				
		}

		$product_data = $product->create($record);
		$product_id = $product_data->id;
		if($index == 0){
			$folder = base_path() . '/public/images/product/' . $product_id;
			File::makeDirectory($folder, 0777, true, true);
			$destination = $folder . '/';

			if(!is_null($image)){		
				$image_split = explode(".", $image->getClientOriginalName());
				$arr_size = count($image_split);
				$image_format = $image_split[$arr_size - 1];
				$image_name = "p" . str_pad($product_id, 10, '0', STR_PAD_LEFT) . "-" . "m" . str_pad($merchant_id, 10, '0', STR_PAD_LEFT) . "-" . rand(1000, 9999) . "." . $image_format;
				if ($image->move($destination, $image_name)) {
					Product::where('id', $product_id)->update(['photo_1' => $image_name]);
				}							
			}
		} else {
			$parent_p = DB::table('product')->where('id',$parent)->first();
			if(!is_null($parent_p)){
				Product::where('id', $product_id)->update(['photo_1' => $parent_p->photo_1]);
			}
		}

		
		return $product_data;
	}

    public function report_products()
    {
        return $this->hasMany('App\Models\Stockreportproduct','product_id','id');
    }
}
