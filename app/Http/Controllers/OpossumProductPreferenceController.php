<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\OposSpaCustomer;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Globals;
use App\Models\OposSparoom;
use App\Models\OposReceiptproduct;
use App\Models\OposReceipt;
use App\Models\OposDiscount;
use App\Models\OposMerchantterminal;
use App\Models\OposTerminal;
use App\Models\OposBundle;
use App\Models\OposBundleProduct;
use Auth;
use DB;
use Log;
use Carbon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
use App\Models\User;
use App\Models\Address;
use App\Models\OposSave;
use App\Models\RoleUser;
use App\Models\Buyer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Image;
use URL;
use File;

class OpossumProductPreferenceController extends Controller
{
 //-----------------------------------------
 // Created by Zurez
 //-----------------------------------------
 
 public function all_products($terminal_id,$uid=NULL)
 {
    try {
        $location_id=DB::table("opos_locationterminal")
        ->where("terminal_id",$terminal_id)
        ->pluck("location_id");
        $merchant_user_id=DB::table("fairlocation")
        ->where("id",$location_id)
        ->pluck("user_id");
        $merchant = Merchant::where('user_id','=',$merchant_user_id)->first();
        $merchant_id=$merchant->id;
      /*  $pp_products=DB::table('opos_productpreference')
        ->whereNull('deleted_at')
        ->where('terminal_id',$terminal_id)
        ->get();*/
       /* $products =   $merchant->products()
        
            
           
            ->join('merchantproduct as mp','mp.product_id','=','product.id')
            ->leftJoin('opos_productpreference as opp','opp.product_id','=','product.id AND opp.terminal_id='.$terminal_id)
            ->whereNull('mp.deleted_at')
            ->where('product.status','!=','transferred')
            
            ->whereNull('product.deleted_at')
        
            ->orderBy('product.id','DESC')
            ->orderBy('product.created_at','DESC') 
            ->select(
                'product.id as id',
                'product.sku as sku',
                'opp.status as pstatus',
                'opp.terminal_id as oppterminal_id',
                'product.name as name',
                'product.retail_price as price',
                'product.description as description',
                'product.thumb_photo as image',
                "opp.price_keyin"
            )
            ->groupBy('id')
            ->get();*/
     /*   foreach ($products as $product) {
            foreach ($pp_products as $pp) {
                # code...
                if ($pp->product_id==$product->id) {
                    # code...
                    $product->pstatus=$pp->status;
                }else{
                    $product->pstatus=NULL;
                }
            }
        }*/
        $products=DB::select(DB::raw("
            SELECT
                product.id as id,
                product.sku as sku,
                opp.status as pstatus,
                opp.terminal_id as oppterminal_id,
                product.name as name,
                product.retail_price as price,
                product.description as description,
                product.thumb_photo as image,
                opp.price_keyin
            FROM 

            product 
            JOIN merchantproduct mp on mp.product_id=product.id
            LEFT JOIN opos_productpreference opp on opp.product_id=product.id AND opp.terminal_id=$terminal_id
            WHERE 
                mp.merchant_id=$merchant_id
                AND  product.deleted_at IS NULL
                AND mp.deleted_at IS NULL
                AND opp.deleted_at IS NULL
            GROUP BY product.id
            ORDER BY opp.id DESC
            "
        ));
        //dd($products);
        return view("opposum.trunk.productpreference",compact('products','terminal_id'));
    } catch (\Exception $e) {
        //dump($e);
        Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
    }
 }

 //-----------------------------------------
 // Created by Zurez
 //-----------------------------------------
 
 public function update_product(Request $r,$uid=NULL)
 {
     $ret=array();
     $ret["status"]="failure";
     if(!Auth::check()){return "";}
     $user_id=Auth::user()->id;
     if(!empty($uid) and Auth::user()->hasRole("adm")){
         $user_id=$uid;
     }
     /*Check if record exists*/
     $does_exists=DB::table("opos_productpreference")
     ->where("terminal_id",$r->terminal_id)
     ->where("product_id",$r->product_id)
     ->whereNull('deleted_at')
     ->first();
     if (empty($does_exists)) {
        Log::debug("Creating productpreference record for product_id ".$r->product_id." and terminal_id ".$r->terminal_id);
         DB::table('opos_productpreference')
         ->insert([
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now(),
            "product_id"=>$r->product_id,
            "terminal_id"=>$r->terminal_id
        ]);
     }
     /**/
     try{
        switch ($r->action) {
            case 'hide':
                # code...
                return $this->hide_product($r);
                break;
            case 'show':
                # code...
                return $this->show_product($r);
                break;
            case 'pricekeyin':
                # code...
                return $this->price_keyin($r);
                break;
            default:
                # code...
                break;
        }
     }
     catch(\Exception $e){
         $ret["short_message"]=$e->getMessage();
         Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
     }
     return response()->json($ret);
 }

 //-----------------------------------------
 // Created by Zurez
 //-----------------------------------------
 
 public function price_keyin(Request $r,$uid=NULL)
 {
     $ret=array();
     $ret["status"]="failure";
     if(!Auth::check()){return "";}
     $user_id=Auth::user()->id;
     if(!empty($uid) and Auth::user()->hasRole("adm")){
         $user_id=$uid;
     }
     try{
         
        $table="opos_productpreference";
        $query=DB::table($table)
            ->where($table.".product_id",$r->product_id)        
            ->where($table.".terminal_id",$r->terminal_id)  
            ->whereNull($table.".deleted_at");
        $existing_value=$query->pluck("price_keyin");
        $value=!$existing_value;
         
        $query->update([
                "updated_at"=>Carbon::now(),
                "price_keyin"=>$value
            ]);


        $ret["status"]="success";
        $ret["data"]=$r->product_id;
     }
     catch(\Exception $e){
         $ret["short_message"]=$e->getMessage();
         Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
     }
     return response()->json($ret);
 }
 
 
//-----------------------------------------
// Created by Zurez
//-----------------------------------------

public function hide_product(Request $r,$uid=NULL)
{
    $ret=array();
    $ret["status"]="failure";
    if(!Auth::check()){return "";}
    $user_id=Auth::user()->id;
    if(!empty($uid) and Auth::user()->hasRole("adm")){
        $user_id=$uid;
    }
    try{
        $table="opos_productpreference";
        $data=DB::table($table)
        ->where($table.".product_id",$r->product_id)        
        ->where($table.".terminal_id",$r->terminal_id)  
        ->whereNull($table.".deleted_at")
        ->update([
            "updated_at"=>Carbon::now(),
            "status"=>"hide"
        ]);

        
        $ret["status"]="success";
        $ret["data"]=$data;
    }
    catch(\Exception $e){
        $ret["short_message"]=$e->getMessage();
        Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    }
    return response()->json($ret);
}
//-----------------------------------------
// Created by Zurez
//-----------------------------------------

public function show_product(Request $r,$uid=NULL)
{
    $ret=array();
    $ret["status"]="failure";
    if(!Auth::check()){return "";}
    $user_id=Auth::user()->id;
    if(!empty($uid) and Auth::user()->hasRole("adm")){
        $user_id=$uid;
    }
    try{
        $table="opos_productpreference";
        $data=DB::table($table)
        ->where($table.".product_id",$r->product_id)        
        ->where($table.".terminal_id",$r->terminal_id)  
        ->whereNull($table.".deleted_at")
        ->update([
            "updated_at"=>Carbon::now(),
            "status"=>"show"
        ]);

        
        $ret["status"]="success";
        $ret["data"]=$data;
    }
    catch(\Exception $e){
        $ret["short_message"]=$e->getMessage();
        Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    }
    return response()->json($ret);
}

public function showreceiptaddress(Request $r)
{
    $terminal=DB::table("opos_terminal")
    ->where("id",$r->terminal_id)->first();
    if (empty($terminal)) {
        # code...
        return "invalid terminal";
    }
    $branchaddress=DB::table("address")->where("id",$terminal->address_id)->first();
    return view("opposum.trunk.receiptaddress",compact('terminal','branchaddress'));
}
public function savereceiptaddress(Request $r)
{
    $ret = array();
    $update_data=[
        "updated_at"=>Carbon::now(),
        "address_id"=>null
    ];

    if ($r->address_preference=="company") {
        # code...
     /* $insert=  DB::table('opos_terminal')
        ->where('id',$r->terminal_id)
        ->update($update_data);*/
    }else{
        $insert = [
                "city_id" =>isset($r->city) ? $r->city:0,
                "area_id"=>0,
                "postcode" => isset($r->code) ? $r->code : 0,
                "line1" => isset($r->address1) ? $r->address1 : '',
                "line2" => isset($r->address2) ? $r->address2 : '',
                "line3" => isset($r->address3) ? $r->address3 : '',
                "line4" => "test",
                "latitude" => isset($r->latitude) ? $r->latitude : 0,
                "longitude" => isset($r->longitude) ? $r->longitude : 0,
                "type" => "billing",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ];
            
        $addressId = DB::table("address")
            ->insertgetId($insert);
        $update_data['address_id']=$addressId;

      
    }
    if ($r->prefer_sst==1) {
        # code...
        $update_data['show_sst_no']=true;
    }else{
        $update_data['show_sst_no']=false;
    }
  $update=DB::table('opos_terminal')
    ->where('id',$r->terminal_id)
    ->update($update_data); 
    $ret["status"]="success";
    $ret["data"]=$update;

    return response()->json($ret);
}

public function showreceiptlogo(Request $request)
{
    $terminal_id = $request->terminal_id;
    $receipt_logo =DB::table('opos_terminal')
                     ->select('local_logo')
                     ->where('id',$terminal_id)
                     ->first();
    return view("opposum.trunk.receiptlogo",compact('receipt_logo','terminal_id'));
}

public function savereceiptlogo(Request $r)
{
    $saveterminalId = $r->receipt_terminal_id;
    $folder = base_path() . '/public/images/receipt/' . $saveterminalId;
    $folder_thumb = base_path() . '/public/images/receipt/' . $saveterminalId . '/thumb';

    File::makeDirectory($folder, 0777, true, true);
    File::makeDirectory($folder_thumb, 0777, true, true);
    $destination = $folder . '/';

    $image = $r->file('receiptimage');

    if (isset($image)) {

        $image_split = explode(".", $image->getClientOriginalName());
        $arr_size = count($image_split);
        $image_format = $image_split[$arr_size - 1];
        $image_name = "r".
            str_pad($saveterminalId, 10, '0', STR_PAD_LEFT)."-".
            rand(1000, 9999) . "." . $image_format;

        if ($image->move($destination, $image_name)) {

            $imgpath = URL::to('/')."/images/receipt/".$saveterminalId.
                "/".$image_name;
            $t30path = public_path('images/receipt/'.$saveterminalId.
                '/thumb/'.$image_name);

            Image::make($imgpath)->
                resize(80, 80, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($t30path);

            $saveimage = DB::table('opos_terminal')->where('id',$saveterminalId)
                       ->update(['local_logo' => $image_name]);
        }
    }
    return response()->json(array('image'=> $image_name));
}
 
}
