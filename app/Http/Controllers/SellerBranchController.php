<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Carbon;
use Log;
class SellerBranchController extends Controller
{
 //-----------------------------------------
 // Created by Zurez
 //-----------------------------------------
 
 public function branch_users_list(Request $r,$uid=NULL)
 {
     $ret=array();
     $ret['status']="failure";
     if (!Auth::check()) {
         return response()->json($ret);
     }
    
    $user_id=Auth::id();
    if (!empty($uid) and Auth::user()->hasRole("adm")) {
        $user_id=$uid;
    }
     $branch_id=$r->branch_id;
     try{
         $data=DB::table("locationusers")
         ->join("fairlocation","fairlocation.id","=","locationusers.location_id")

         ->join("member","member.user_id","=","locationusers.user_id")
         ->join("company","company.id","=","member.company_id")
         ->join("users","users.id","=","locationusers.user_id")
         ->whereNull("fairlocation.deleted_at")
         ->whereNull("locationusers.deleted_at")
         ->where("locationusers.location_id",$branch_id)
         ->select("locationusers.*","users.first_name","users.last_name","member.id as member_id","users.name")
         ->groupBy("locationusers.user_id")
         ->orderBy("locationusers.created_at","DESC")
         ->get();
         $ret["status"]="success";
        $ret["data"]=$data;
 
        
     }
     catch(\Exception $e){
         $ret["short_message"]=$e->getMessage();
         Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
     }
     return response()->json($ret);
 }
  public function branch_products_list(Request $r,$uid=NULL)
 {
     $ret=array();
     $ret['status']="failure";
     if (!Auth::check()) {
         return response()->json($ret);
     }

    $user_id=Auth::id();
    if (!empty($uid) and Auth::user()->hasRole("adm")) {
        $user_id=$uid;
    }

     $branch_id=$r->branch_id;
     try{
        $query="
        SELECT 
        
        l.quantity,
        l.id as locationproduct_id,
        np.nproduct_id as nproduct_id,
        p.name,
        p.id as product_id,
        p.thumb_photo

        FROM
        locationproduct l
        JOIN fairlocation f on f.id=l.location_id
        JOIN product p on l.product_id=p.id
        LEFT JOIN nproductid np on np.product_id=p.id
        WHERE 
        l.location_id=$branch_id
        AND f.user_id=$user_id 
        AND  l.created_at=(select MAX(lp.created_at) from locationproduct lp where lp.product_id=p.id AND lp.location_id=$branch_id )
        group by p.id
        order by l.id DESC

        ";
  
        $data=DB::select(DB::raw($query));
         /*$data1=DB::table("locationproduct")
         ->join("fairlocation","fairlocation.id","=","locationproduct.location_id")
         ->join("product","product.id","=","locationproduct.product_id")
         ->join("merchantproduct","merchantproduct.product_id","=","product.parent_id")
         ->join("merchant","merchant.id","=","merchantproduct.merchant_id")
         
         ->leftJoin("nproductid","nproductid.product_id","=","product.id")
         //->whereNull("fairlocation.deleted_at")
         ->whereNull("locationproduct.deleted_at")
         ->where("locationproduct.location_id",$branch_id)
         ->where("merchant.user_id",Auth::user()->id)
         ->select("locationproduct.*","nproductid.nproduct_id as nproduct_id","product.name","product.id as product_id","product.thumb_photo")
         //->select(DB::raw("SELECT max(locationproduct.id) as lpid"))
         ->groupBy("locationproduct.product_id")
         ->orderBy("locationproduct.created_at","DESC")
         ->get();*/
         $ret["status"]="success";
        $ret["data"]=$data;
 
        
     }
     catch(\Exception $e){
         $ret["short_message"]=$e->getMessage();
         Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
     }
     return response()->json($ret);
 }
}
