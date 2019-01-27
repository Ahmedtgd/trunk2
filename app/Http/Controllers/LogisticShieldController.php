<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\Product;
use App\Http\Requests;
use App\Models\MerchantProduct;
use App\Models\MerchantCategory;
use App\Models\Wholesale;
use Carbon\Carbon;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use \Illuminate\Support\Facades\DB;
use Response;
use Input;
use URL;
use Log;
    class LogisticShieldController extends Controller 
    {
        // for add new product
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

        // for Edit product 
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
        //  $save_policy = DB::table('merchant')->where('id',$merchant_id)->update(array('return_policy' => $request->merchant_policy));

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

        // for add and Edit B2B
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


            //  dd($product_id);
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
                            DB::table('nproductid')->insert(['nproduct_id'=>$newid, 'product_id'=>$product_data->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
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
    }