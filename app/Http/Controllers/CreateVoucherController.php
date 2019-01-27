<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Product;
use App\Models\Address;
use App\Models\TimeSlot;
use App\Models\Buyer;
use App\Models\MerchantVoucher;
use App\Models\OutletVoucher;
use DateTime;
use DB;
use Auth;
use File;



class CreateVoucherController extends Controller
{
    
    public function index()
    {
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
				  'product.created_at' ,
				  'product.updated_at','category.name as catName',
                'voucher.id as voucherId')
            ->where('voucher.status','=','active')
            ->orderBy('voucher.id','desc')
            ->get();
    
        $getCategory=Voucher::category();
        $getBrand=Voucher::Brand();
        
        return view('create_new_voucher', compact('getCategory','getBrand','product'));
    } 

    public function SubCategory(Request $request,$categoryId)
    {
       if($request->ajax())
        {
        return Voucher::SubCategory($categoryId);
        }
    }

    public function store(Request $request)
    {
		/*$input = $request->all();
		dd($input);*/
        $user_id= Auth::user()->id;
        $merchant_id= DB::table('merchant')->where('user_id',$user_id)->pluck('id');
        

        $this->validate($request,[
            'productName'=>'required|max:250',
            'Brand'=>'required|max:250',
            'categoryId'=>'required|max:250',
            'subCategoryId'=>'required|max:250',
            'retail_price'=>'required|numeric',
            'default1'=>'required',
            'defaultcity_name'=>'required'

            ]);
        $row=0;
        $buyers_count=Buyer::count();
        for ( $k=0; $k<count($request->bookingDate);$k++) {
            $row++;
            if ( !is_numeric($request->qtyOrdered[$k])) {
                    return Response(['timeslot'=>"Timeslot Row:$row Quantity Order must be a number"],422);
            }
            elseif ( !is_numeric($request->qtyLeft[$k])) {
                    return Response(['timeslot'=>"Timeslot Row:$row Quantity left must be a number"],422);
            }
            elseif ( !is_numeric($request->price[$k])) {
                    return Response(['timeslot'=>"Timeslot Row:$row price must be a number"],422);
            }
            elseif ( $request->qtyOrdered[$k] > $buyers_count) {
                    return Response(['timeslot'=>"Timeslot Row:$row Quantity Order must not be greater then $buyers_count"],422);
            }
            elseif ( $request->qtyOrdered[$k] < $request->qtyLeft[$k]) {
                    return Response(['timeslot'=>"Timeslot Row:$row Quantity left must not be greater then Quantity Ordered"],422);
            }
            elseif ($request->fromTime[$k] =="" || $request->price[$k]=="" || $request->qtyOrdered[$k]==""||$request->qtyLeft[$k]=="") {
                    return Response(['timeslot'=>"Timeslot Row:$row All timeslot fields all required"],422);
            }
            
        }




        if ($merchant_id<1){
            return response("unauthenticated",401);
        }

        $dateTime=date('Y-m-d H:i:s');

        $product=new Product;
        $product->name=$request->productName;    
        $product->brand_id=$request->Brand;
        $product->category_id=$request->categoryId;
        $product->subcat_id=$request->subCategoryId;
        $product->retail_price=$request->retail_price;
     //   $product->product_details=$request->product_details;
        $product->created_at=$dateTime;
        $product->save(); 
		
		
		$color = DB::table('specification')->where('name','color')->first();
		if(isset($color)){
			$spec_id = $color->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'color', 'description' => 'Color','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_2v'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$model = DB::table('specification')->where('name','model')->first();
		if(isset($model)){
			$spec_id = $model->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'model', 'description' => 'Model','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_3v'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$size = DB::table('specification')->where('name','size')->first();
		if(isset($size)){
			$spec_id = $size->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'size', 'description' => 'Size(L x W x H)','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_4v'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$weight = DB::table('specification')->where('name','weight')->first();
		if(isset($weight)){
			$spec_id = $weight->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'weight', 'description' => 'Weight','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_5v'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$warranty_period = DB::table('specification')->where('name','warranty_period')->first();
		if(isset($warranty_period)){
			$spec_id = $warranty_period->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'warranty_period', 'description' => 'Warranty Period','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_6v'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

		$warranty_type = DB::table('specification')->where('name','warranty_type')->first();
		if(isset($warranty_type)){
			$spec_id = $warranty_type->id;
		} else {
			$spec_id =  DB::table('specification')->insertGetId(['name' => 'warranty_type', 'description' => 'Warranty Type++','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		}
		$specprod = DB::table('productspec')->insertGetId(['product_id' => $product->id, 'spec_id' => $spec_id, 'value' => $request->get('product_specification_7v'),'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);		

        $address=new Address;   
        $address->line1=$request->default1;    
        $address->line2=$request->address_lan_2;    
        $address->line3=$request->address_lan_3;
        $address->line4=$request->address_lan_4;
        $address->city_id=$request->defaultcity_name;
        $address->created_at=$dateTime;
        $address->save();

        $voucher=new Voucher;   
        $voucher->product_id=$product->id;    
        $voucher->address_id=$address->id; 
        $voucher->validity=$request->validity;    
        $voucher->status='active';    
        $voucher->reference_no=rand(11111,99999);
        $voucher->created_at=$dateTime;
        $voucher->save();



        $merchantvoucher=new MerchantVoucher;
        $merchantvoucher->voucher_id=$voucher->id;
        $merchantvoucher->merchant_id=$merchant_id;
        $merchantvoucher->status='active';
        $merchantvoucher->created_at=$dateTime;
        $merchantvoucher->save();



        

        for ($k=0; $k <sizeof($request->bookingDate); $k++) {
                $date = DateTime::createFromFormat('M d, Y',$request->bookingDate[$k]);

// 2015-02-10
             
                $timeslot=new TimeSlot;   
                $timeslot->voucher_id=$voucher->id;    
                $timeslot->booking=$date->format("Y-m-d");
                $timeslot->from=date('H:i:s', strtotime($request->fromTime[$k]));
                $timeslot->to=date('H:i:s', strtotime($request->toTime[$k]));
                $timeslot->qty_left=$request->qtyLeft[$k];
                $timeslot->qty_ordered=$request->qtyOrdered[$k];    
                $timeslot->price=$request->price[$k];    
                //$timeslot->pax_per_table=$request->pax_per_table;    
                $timeslot->created_at=$dateTime;    
                $timeslot->save();
            }
        /*$result=Voucher::store($request->all());
       
        if ($result)
        {
            session()->flash('success','Data  Create success');
           
        }
        else
        {
             session()->flash('error','Data Created Unsuccess');

        }*/
        
    }
	
    public function storev2(Request $request)
    {
		/*$input = $request->all();
		dd($input);*/
        $user_id= Auth::user()->id;
        $merchant_id= DB::table('merchant')->where('user_id',$user_id)->pluck('id');
 
        $row=0;
        $this->validate($request,[
            'productNamev2'=>'required|max:250',
            'Brandv2'=>'required|max:250',
            'categoryIdv2'=>'required|max:250',
            'subCategoryIdv2'=>'required|max:250'

            ]);
        if ($merchant_id<1){
            return response("unauthenticated",401);
        }

        $dateTime=date('Y-m-d H:i:s');

        $product=new Product;
        $product->name=$request->productNamev2;    
        $product->segment='v2';
        $product->brand_id=$request->Brandv2;
        $product->category_id=$request->categoryIdv2;
        $product->subcat_id=$request->subCategoryIdv2;
        $product->retail_price=$request->retailv2*100;
        $product->discounted_price=$request->discountedv2*100;
        $product->available=$request->qtyv2;
        $product->description=$request->short_descriptionv2;
    //    $product->product_details=$request->voucher_detailsv2;
        $product->created_at=$dateTime;
        $product->save(); 
		
        $folder = base_path() . '/public/images/product/' . $product->id;
        File::makeDirectory($folder, 0777, true, true);
        $destination = $folder . '/';
        //chmod($folder,0775);
        $image = $request->file('voucher_photov2');
        if (isset($image)) {
            $image_name = $image->getClientOriginalName();
            if ($image->move($destination, $image_name)) {
                Product::where('id', $product->id)->update(['photo_1' => $image_name]);
            }
        }	

        $folder = base_path() . '/public/images/product/' . $product->id;
        File::makeDirectory($folder, 0777, true, true);
        $destination = $folder . '/';
        //chmod($folder,0775);
        $image2 = $request->file('voucher_photocoverv2');
        if (isset($image2)) {
            $image_name = $image2->getClientOriginalName();
            if ($image2->move($destination, $image_name)) {
                Product::where('id', $product->id)->update(['photo_2' => $image_name]);
            }
        }			

        $voucher=new Voucher;   
        $voucher->product_id=$product->id;    
        $voucher->address_id=0; 
        $voucher->validity="v2";    
        $voucher->status='active';    
        $voucher->unit=$request->voucherv2;    
        $voucher->validity_year=$request->validityv2;    
        $voucher->reference_no=rand(11111,99999);
        $voucher->created_at=$dateTime;
        $voucher->save();

		$merchantvoucher=new MerchantVoucher;
        $merchantvoucher->voucher_id=$voucher->id;
        $merchantvoucher->merchant_id=$merchant_id;
        $merchantvoucher->status='active';
        $merchantvoucher->created_at=$dateTime;
        $merchantvoucher->save();
		
		
		$outlet = $request->get('outletsv2');
		
		for ($i = 0; $i < count($outlet); $i++) {
			$outletvoucher=new OutletVoucher;
			$outletvoucher->voucher_id=$voucher->id;
			$outletvoucher->sproperty_id=$outlet[$i];
			$outletvoucher->status='active';
			$outletvoucher->created_at=$dateTime;
			$outletvoucher->save();			
		}
        
    }	
	
    public function storev1(Request $request)
    {
		/*$input = $request->all();
		dd($input);*/
        $user_id= Auth::user()->id;
        $merchant_id= DB::table('merchant')->where('user_id',$user_id)->pluck('id');
 
        $row=0;
        $this->validate($request,[
            'productNamev1'=>'required|max:250',
            'Brandv1'=>'required|max:250',
            'categoryIdv1'=>'required|max:250',
            'subCategoryIdv1'=>'required|max:250'

            ]);
        if ($merchant_id<1){
            return response("unauthenticated",401);
        }

        $dateTime=date('Y-m-d H:i:s');

        $product=new Product;
        $product->name=$request->productNamev1;
		$product->segment='v1';		
        $product->brand_id=$request->Brandv1;
        $product->category_id=$request->categoryIdv1;
        $product->subcat_id=$request->subCategoryIdv1;
        $product->retail_price=0;
        $product->available=0;
        $product->description=$request->short_descriptionv1;
     ////   $product->product_details=$request->voucher_detailsv1;
        $product->created_at=$dateTime;
        $product->save(); 
		
        $folder = base_path() . '/public/images/product/' . $product->id;
        File::makeDirectory($folder, 0777, true, true);
        $destination = $folder . '/';
        //chmod($folder,0775);
        $image = $request->file('voucher_photov1');
        if (isset($image)) {
            $image_name = $image->getClientOriginalName();
            if ($image->move($destination, $image_name)) {
                Product::where('id', $product->id)->update(['photo_1' => $image_name]);
            }
        }		

        $voucher=new Voucher;   
        $voucher->product_id=$product->id;    
        $voucher->address_id=0; 
        $voucher->validity=$request->validity;    
        $voucher->status='active';        
        $voucher->reference_no=rand(11111,99999);
        $voucher->created_at=$dateTime;
        $voucher->save();

		$merchantvoucher=new MerchantVoucher;
        $merchantvoucher->voucher_id=$voucher->id;
        $merchantvoucher->merchant_id=$merchant_id;
        $merchantvoucher->status='active';
        $merchantvoucher->created_at=$dateTime;
        $merchantvoucher->save();
		
        for ($k=0; $k <sizeof($request->fromTime); $k++) {
			$date = DateTime::createFromFormat('M d, Y',$request->selected_datefv1);
			$timeslot=new TimeSlot;   
			$timeslot->voucher_id=$voucher->id;    
			$timeslot->booking=$date->format("Y-m-d");
			$timeslot->from=date('H:i:s', strtotime($request->fromTime[$k]));
			$timeslot->to=date('H:i:s', strtotime($request->toTime[$k]));
			$timeslot->qty_ordered=$request->qtyOrdered[$k];    
			$timeslot->price=$request->price[$k]*100;     
			$timeslot->created_at=$dateTime;    
			$timeslot->save();
         }		
		
		$outlet = $request->get('outletsv1');
		
		for ($i = 0; $i < count($outlet); $i++) {
			$outletvoucher=new OutletVoucher;
			$outletvoucher->voucher_id=$voucher->id;
			$outletvoucher->sproperty_id=$outlet[$i];
			$outletvoucher->status='active';
			$outletvoucher->created_at=$dateTime;
			$outletvoucher->save();			
		}
        
    }	
	
    function voucher_information($voucher_id){
        return Voucher::find($voucher_id);
    }

    public function detailsVoucher($VoucherId)
    {

         $getVoucher=Voucher::CreateVoucherDetails($VoucherId);
      
         return view('createVoucherWiseDetails',compact('getVoucher'));
    }
   
}
