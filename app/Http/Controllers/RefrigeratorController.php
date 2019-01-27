<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderStockReport;
use App\Models\DeliveryOrdertProduct;
use App\Models\Employee;
use App\Models\Fairlocation;
use App\Models\LocationProduct;
use App\Models\Member;
use App\Models\Merchant;
use App\Models\NdoID;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Role;
use App\Models\Stockreport;
use App\Models\Stockreportproduct;
use App\Models\Tproduct;
use App\Models\User;
use App\Models\POrder;
use Carbon\Carbon;

use function Clue\StreamFilter\fun;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use DB;
use Session;
use Log;
use Auth;

class RefrigeratorController extends Controller {

	/*
    public function getDeliveryMasterDetails() {
        return view('admin.delivery_details');
    }
	 */

    public function index($user_id = null) {
		if (!Auth::check()) {
            return view("common.generic")
				->with("message_type", "error")
				->with("message", "Please login to access this view");
        }

        if ($user_id == null) {
            $user_id = Auth::user()->id;
        }
		$selluser = User::find($user_id);
		$fStorages= \App\Models\Refrigerator::select('product.id as id',
			'fstorage.id as fstorage_id','product.name as product_name',
                        'nproductid.nproduct_id as nproduct_id',
                        'product.thumb_photo as thumb_photo',
			DB::raw('count(rawmaterial.id) as raw_materials'),
			DB::raw('sum(stockreportproduct.quantity) as wastage_quantity'),
			DB::raw('SUM(DISTINCT rawmaterial.raw_qty*opos_receiptproduct.quantity) as quantity_sold'),
			'users.name as staffname','fstorage.estimated',
			"fstorage.status as status",
			DB::raw("COUNT(productionldgr.id) - "
					. "(SELECT count(id) as total FROM productionldgr plr 
					WHERE plr.created_at = productionldgr.created_at) as days"),
			DB::raw('SUM(locationproduct.quantity) as total_quantity')
        )
        ->leftjoin("wastageldgr","fstorage.raw_product_id","=","wastageldgr.product_id")
        ->leftjoin("productionldgr","fstorage.raw_product_id","=","productionldgr.product_id")
        ->leftjoin('rawmaterial','rawmaterial.raw_product_id','=','fstorage.raw_product_id')
        ->leftjoin('product','product.id','=','fstorage.raw_product_id')
        ->leftjoin('locationproduct','locationproduct.product_id','=','fstorage.raw_product_id')
        ->leftjoin('opos_receiptproduct','rawmaterial.item_product_id','=','opos_receiptproduct.product_id')
        ->leftjoin('opos_receipt','opos_receiptproduct.receipt_id','=','opos_receipt.id')
        ->leftjoin('nproductid','nproductid.product_id',"=",'fstorage.raw_product_id')
        ->leftjoin('users','users.id','=','opos_receipt.staff_user_id')
        ->leftjoin("stockreportproduct","stockreportproduct.product_id","=","fstorage.raw_product_id")
        ->groupBy(DB::raw("fstorage.id"))
        ->get();

		// dump($fStorages);

        return view('seller.refrigerator.refrigeratorfirst',
			compact(
				'fStorages',
				'selluser'
         ));
    }

    public function productionLedger($product_id,$user_id=null){
        
        if (!Auth::check()) {
            return view("common.generic")
				->with("message_type", "error")
				->with("message", "Please login to access this view");
        }
        
        if ($user_id == null) {
            $user_id = Auth::user()->id;
        }
        $this->updateProductionLedger($product_id);
$selluser = User::find($user_id);

		$productionLedgers= \App\Models\productionLedger::where(
			'productionldgr.product_id', '=', $product_id)
                        ->leftjoin("rawmaterial","productionldgr.product_id","=",
				"rawmaterial.raw_product_id")
                        ->leftjoin("product","productionldgr.product_id","=",
				"product.id")
                        ->leftjoin('nproductid',
                                'nproductid.product_id','=',
                                'productionldgr.product_id')
			->select("productionldgr.qty as qty",
                                "productionldgr.created_at",
                                "product.name as product_name",
                                "product.id",
                                   "product.thumb_photo",
                                "nproductid.nproduct_id as nproduct_id")
                        ->groupBy("productionldgr.id")
                        ->orderBy("productionldgr.id",'desc')
                        ->get();
//                dd($productionLedgers);
//$productionLedgers= \App\Models\productionLedger::select('product.id as id',
//			'product.name as product_name',
//                        'nproductid.nproduct_id as nproduct_id',
//                        'product.thumb_photo as thumb_photo',
//			DB::raw('count(rawmaterial.id) as raw_materials'),
////			DB::raw('sum(stockreportproduct.quantity) as wastage_quantity'),
//			DB::raw('rawmaterial.raw_qty*SUM(opos_receiptproduct.quantity) as qty'),
//			'productionldgr.created_at as created_at'
//        )
//        ->distinct()
//        ->leftjoin('rawmaterial','productionldgr.product_id','=','rawmaterial.raw_product_id')
//        ->leftjoin('product','product.id','=','productionldgr.product_id')
//        ->leftjoin('locationproduct','locationproduct.product_id','=','productionldgr.product_id')
//        ->leftjoin('opos_receiptproduct','rawmaterial.item_product_id','=','opos_receiptproduct.product_id')
//        ->leftjoin('opos_receipt','opos_receiptproduct.receipt_id','=','opos_receipt.id')
//        ->leftjoin('nproductid','nproductid.product_id',"=",'productionldgr.product_id')
//        ->leftjoin('users','users.id','=','opos_receipt.staff_user_id')
//        ->leftjoin("stockreportproduct","stockreportproduct.product_id","=","productionldgr.product_id")
//        ->groupBy(DB::raw("productionldgr.id"))
//        ->where('rawmaterial.raw_product_id', '=', $product_id)
//        ->get();
//dd($productionLedgers);
		return view('seller.refrigerator.productionledger',
			compact(
				'selluser',
				'productionLedgers'
         ));
    }
    
    
     public function updateProductionLedger($raw_product_id){
        $productionLedgrDatas= \App\Models\OposReceiptproduct::select("opos_receiptproduct.product_id",
                "rawmaterial.raw_product_id as product_id",
                "productionldgr.pdecimal",
                DB::raw('rawmaterial.raw_qty*opos_receiptproduct.quantity as qty'),
                "opos_receiptproduct.created_at as created_at")
                ->leftjoin("rawmaterial",
                        "rawmaterial.item_product_id","=",
                        "opos_receiptproduct.product_id")
                ->leftjoin("productionldgr",
                        "rawmaterial.raw_product_id","=",
                        "productionldgr.product_id")
                ->groupBy("rawmaterial.id")
                ->where("rawmaterial.raw_product_id","=",$raw_product_id);
                if($previous_production_ldgr_data=DB::table("productionldgr")->count()!=0){
                $productionLedgrDatas=$productionLedgrDatas->whereRaw("productionldgr.product_id!=rawmaterial.raw_product_id AND productionldgr.created_at != opos_receiptproduct.created_at AND productionldgr.qty!=qty");
                }
                       $productionLedgrDatas= $productionLedgrDatas->get() 
                        ->toArray();
                       $productionInsertData=[];
      if($previous_production_ldgr_data==0)
          {
                       for($i=0;$i<count($productionLedgrDatas);$i++)
                       {
                           $previous_qty=[];
            $previous_qty["amount"]=!empty($productionLedgrDatas[$i-1])?
            $productionLedgrDatas[$i-1]["qty"]:"";
            $previous_qty["decimals"]=$this->splitDecimals($previous_qty['amount']);
            $qty["amount"]=$productionLedgrData->qty;
            $qty["decimals"]=$this->splitDecimals($qty['amount']);
             if(!empty($previous_qty['amount']))
                 {
                 
                 $qty_and_previous_qty_sum=$qty['decimals']['after_decimal']+$previous_qty['decimals']['before_decimal'];
                 $quantities_sum['decimals']=$this
                         ->splitDecimals($qty_and_previous_qty_sum);
                 $qty['decimals']['before_decimal'];
                 
                 }
             
                       }
           }else
           {
               
               $pdecimal_previous_before_insert=DB::table("productionldgr")
                       ->select("pdecimal")->orderby("id","desc")->first();
                for($i=0;$i<count($productionLedgrDatas);$i++)
                       {
                             if($pdecimal_previous_before_insert!=0)
                                 {
                   $previous_decimal=$pdecimal_previous_before_insert;
                                 }
                                        
                                   
                       }
               

                
           }
        
        
        
        if(count($productionLedgrDatas)>0){
            DB::table("productionldgr")->insert((array)$productionLedgrDatas);
        }
        
    }
    
    public function splitDecimals($float){
        
         $before_decimal=(int)$float;
         $after_decimal=abs($float-$before_decimal);
                 return compact("before_decimal","after_decimal");       
    }

    public function wastageLedger($product_id,$user_id=null){
        if (!Auth::check()) {
            return view("common.generic")
				->with("message_type", "error")
				->with("message", "Please login to access this view");
        }
        
        if ($user_id == null) {
            $user_id = Auth::user()->id;
        }
       $selluser = User::find($user_id);


		$wastageLedgers= \App\Models\wastageLedger::where(
			"wastageldgr.product_id","=",$product_id)->get();

		return view('seller.refrigerator.wastageledger',
			compact(
				'selluser',
				'wastageLedgers'
         ));
    }

    public function getQuantityDetail(Request $request){
        try{
        $product_id=$request->input("product_id");
         $qtyDetail= \App\Models\Refrigerator::select('product.id as id',
        'product.name as product_name',
                'nproductid.nproduct_id as nproduct_id',
                 'product.thumb_photo as thumb_photo',
        DB::raw('COUNT(DISTINCT rawmaterial.id) as raw_materials'),
        DB::raw('SUM(DISTINCT rawmaterial.raw_qty*opos_receiptproduct.quantity) as production'),
			'users.name as staffname',
                DB::raw('sum(stockreportproduct.quantity) as wastage_quantity'),
			
                DB::raw("sum(wastageldgr.qty) as wastage_decimal"),
                DB::raw("sum(rawmaterial.raw_qty) as production_decimal")
        )
        ->leftjoin("wastageldgr","fstorage.raw_product_id","=","wastageldgr.product_id")
        ->leftjoin("productionldgr","fstorage.raw_product_id","=","productionldgr.product_id")
        ->leftjoin('rawmaterial','rawmaterial.raw_product_id','=','fstorage.raw_product_id')
        ->leftjoin('product','product.id','=','fstorage.raw_product_id')
        ->leftjoin('locationproduct','locationproduct.product_id','=','fstorage.raw_product_id')
        ->leftjoin('opos_receiptproduct','rawmaterial.item_product_id','=','opos_receiptproduct.product_id')
        ->leftjoin('opos_receipt','opos_receiptproduct.receipt_id','=','opos_receipt.id')
        ->leftjoin('nproductid','nproductid.product_id','=','fstorage.raw_product_id')
        ->leftjoin('users','users.id','=','opos_receipt.staff_user_id')
        ->where("fstorage.raw_product_id","=",$request->product_id)
       ->leftjoin("stockreportproduct","stockreportproduct.product_id","=","fstorage.raw_product_id")
       ->groupBy(DB::raw("rawmaterial.raw_product_id"))
       ->get();

        } catch(Exception $e){
			Log::error("ERROR at line ".$e->getLine()."FILE:".
				$e->getFile()." Message".$e->getMessage());

			return response()->json([
				"error"=>"ERROR at line ".$e->getLine()."FILE:".
					$e->getFile()." Message".$e->getMessage(),
				"status"=>500]);
        }

		return response()->json(["data"=>$qtyDetail]);
    }
public function getQuantityDistributionDetail(Request $request){
    $product_id=$request->input("product_id");
    try{
        $qtyDetail= \App\Models\Refrigerator::select('product.id as id',
                'nproductid.nproduct_id as nproduct_id',
        'product.name as product_name',
                 'product.thumb_photo as thumb_photo',
        DB::raw('count(DISTINCT rawmaterial.id) as raw_materials'),
                DB::raw('sum(stockreportproduct.quantity) as wastage_quantity'),
                DB::raw('SUM(DISTINCT rawmaterial.raw_qty*opos_receiptproduct.quantity) as production'),
                'users.name as staffname',
                DB::raw("sum(wastageldgr.qty) as wastage_decimal"),
                DB::raw("sum(productionldgr.qty) as production_decimal")
        )
        ->leftjoin("wastageldgr","fstorage.raw_product_id","=","wastageldgr.product_id")
        ->leftjoin("productionldgr","fstorage.raw_product_id","=","productionldgr.product_id")
        ->leftjoin('rawmaterial','rawmaterial.raw_product_id','=','fstorage.raw_product_id')
        ->leftjoin('product','product.id','=','fstorage.raw_product_id')
        ->leftjoin('locationproduct','locationproduct.product_id','=','fstorage.raw_product_id')
        ->leftjoin('opos_receiptproduct','rawmaterial.item_product_id','=','opos_receiptproduct.product_id')
        ->leftjoin('opos_receipt','opos_receiptproduct.receipt_id','=','opos_receipt.id')
        ->leftjoin('nproductid','nproductid.product_id','=','fstorage.raw_product_id')
        ->leftjoin('users','users.id','=','opos_receipt.staff_user_id')
        ->where("fstorage.raw_product_id","=",$request->product_id)
        ->groupBy(DB::raw("rawmaterial.raw_product_id"))
        ->leftjoin("stockreportproduct","stockreportproduct.product_id","=","fstorage.raw_product_id")
                ->get();
      }catch(Exception $e){
            Log::error("ERROR at line ".$e->getLine()."FILE:".$e->getFile()." Message".$e->getMessage());
             return response()->json(["error"=>"ERROR at line ".$e->getLine()."FILE:".$e->getFile()." Message".$e->getMessage(),"status"=>500]);
        }
     
		return response()->json(["data"=>$qtyDetail]);
	}


	public function saveFstorateEstimate(Request $r){
		$estimate=$r->input("estimate");
		$fstorage_id=$r->input("fstorage_id");
		try {
			$data= \Illuminate\Support\Facades\DB::table("fstorage")->
				where("id","=",$fstorage_id)->
				update(["estimated"=>$estimate]);

		} catch(Exception $e){
			Log::error("ERROR at line ".$e->getLine()."FILE:".
				$e->getFile()." Message".$e->getMessage());

			return response()->json(["error"=>"ERROR at line ".
				$e->getLine()."FILE:".$e->getFile()." Message".
				$e->getMessage(),"status"=>500]);
		}

		if(count($data)>0)
			return response()->json(["message"=>"Successfully Updated"]);
		else
			return response()->json(["message"=>"Unable to update"]);
		}
	}
