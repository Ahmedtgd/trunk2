<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Carbon;
use Log;
class MerchantCaimanController extends Controller
{
    /*Section: Consignment Account Number*/
    

    public function show_cacct_view()
    {
        return view("seller.caiman.cacctno");
    }
    public function cacctno(Request $r)
    {   
        $ret=array();

        $user = Auth::user();

        if (empty($user)) {
            $ret["error"]="User doesn't exist";
            return response()->json($ret,403);
        }
        if ($r->action=="save" and !$r->has("company") ) {
            $ret["error"]="Bad Parameters,missing company";
            return response()->json($ret,500);
        }

        if ($r->action=="save" and !$r->has("consignment_no")) {
            $ret["error"]="Bad Parameters, missing consignment_no";
            return response()->json($ret,500);
        }
        
        $merchant=DB::table("merchant")
        ->where("user_id",$user->id)
        ->whereNull("deleted_at")
        ->orderBy("created_at")
        ->first();
        if (empty($merchant)) {
            $ret["error"]="Merchant doesn't exist";
            return response()->json($ret,500);
        }

        $does_exist=DB::table("cacctno")
        ->whereNull("deleted_at")
        ->where("company",$r->company)
        ->where("user_id",$merchant->user_id)
        ->where("acctno",$r->consignment_no)
        ->first();

        switch ($r->action) {
            case 'save':
                $does_exist=DB::table("cacctno")
                ->whereNull("deleted_at")
                ->where("company",$r->company)
                ->where("user_id",$merchant->user_id)
                ->where("acctno",$r->consignment_no)
                ->first();
                if (!empty($does_exist)) {
                    $ret["error"]="Consignment Number already exists";
                    return response()->json($ret,555);
                }
                return $this->save_cacct($r,$merchant);
                break;
            case 'delete':
                $does_exist=DB::table("cacctno")
                ->whereNull("deleted_at")
              
                ->where("id",$r->cacct_id)
          
                ->first();
                if (empty($does_exist)) {
                    $ret["error"]="Consignment Number does not exists1";
                    return response()->json($ret,500);
                }
                return $this->delete_acct($r,$does_exist);
                break;

            default:
                # code...
                break;
        }
    }

    public function save_cacct($r,$merchant)
    {
        $to_insert=[
            "company"=>$r->company,
            "user_id"=>$merchant->user_id,
            "acctno"=>$r->consignment_no,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ];

        $cacct_id=DB::table("cacctno")
        ->insertGetId($to_insert);
        $ret=array();
        $ret["id"]=$cacct_id;
        return response()->json($ret);
    }

    public function delete_acct($r,$acct)
    {
        DB::table("cacctno")
        ->where("id",$acct->id)
        ->update(
            [
                "deleted_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ]
            );
        $ret=array();
        $ret["id"]=$acct->id;
        return response()->json($ret,200);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function cacct_by_location(Request $r)
    {
        $ret=array();
       
        $company=$r->company;
        $user_id=Auth::user()->id;
        try{
            $data=DB::select(DB::raw(
                "
                SELECT 
                c.acctno,
                l.location_id,
                l.deleted_at,
                c.id,
                CASE
                    WHEN l.location_id IS NULL  THEN 'unchecked'
                    ELSE 'checked'
                END as 'status'
                FROM
                cacctno c
                LEFT JOIN locationcacctno l ON c.id=l.cacctno_id 
                WHERE
                        c.company='$company'
                    
                    AND c.user_id='$user_id'
                    AND c.deleted_at IS NULL
                    AND l.deleted_at IS NULL
                ORDER BY 
                    c.created_at DESC
                "
                ));
    
            $ret["data"]=$data;
            $ret["status"]="success";
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
        //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function cacct_by_company(Request $r)
    {
        $ret=array();
       
        $company=$r->company;
        $user_id=Auth::user()->id;
        try{
            $data=DB::select(DB::raw(
                "
                SELECT 
                c.acctno,
           
                c.id,
               
                FROM
                cacctno c
               
                WHERE
                        c.company='$company'
                    
                    AND c.user_id='$user_id'
                    AND c.deleted_at IS NULL
           
                ORDER BY 
                    c.created_at DESC
                "
                ));
    
            $ret["data"]=$data;
            $ret["status"]="success";
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }



    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function assign_location(Request $r)
    {
        $ret=array();
        $ret["status"]="error";
        if (!Auth::check()) {
            $ret["error"]="Authentication Error";
            return response()->json($ret);
        }
        if (!$r->has("company") or !$r->has("location_id")) {
            
            $ret["error"]="Missing Parameters";
            return response()->json($ret);
        }
        try{
            $user_id=Auth::user()->id;
            $location_id=$r->location_id;
            $company=$r->company;

            $does_cacctno_exists=DB::table("cacctno")
            ->where("company",$company)
            ->where("user_id",$user_id)
            ->whereNull("deleted_at")
            ->first();
            $is_location_assigned=null;
            if (empty($does_cacctno_exists)) {
                $ret["error"]="CACCTNO does not exists";
                 return response()->json($ret);
            }else{
                $is_location_assigned=DB::table("locationcacctno")
                ->where("cacctno_id",$does_cacctno_exists->id)
                ->where("location_id",$location_id)
                ->whereNull("deleted_at")
                ->first();
            }

            if ($r->action=="assign" and !empty($does_cacctno_exists)
                and empty($is_location_assigned)
                ) {
                $insert_data=[
                    "cacctno_id"=>$does_cacctno_exists->id,
                    "location_id"=>$location_id,
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now()
                ];
                DB::table("locationcacctno")
                ->insertGetId($insert_data);
                $ret['status']="success";
                $ret["message"]="Assigned";
            }
            elseif ($r->action=="unassign" and !empty($does_cacctno_exists)
                and !empty($is_location_assigned)) {
                DB::table("locationcacctno")
                ->where("id",$is_location_assigned->id)
                ->update([
                    "deleted_at"=>Carbon::now()
                    ]);
                $ret['status']="success";
                $ret["message"]="Unassigned";
            }
            
            
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return $ret;
    }
    

}
