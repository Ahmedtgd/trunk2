<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Log;
use Carbon;
class OtherPointController extends Controller
{
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function add(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_otherpointlog";
            $insert=[

                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now(),
                "member_id"=>$r->member_id,
                "staff_user_id"=>$user_id,
                "type"=>$r->type,
                "points"=>$r->points

            ];
            
            DB::table($table)->insert($insert);
            
            $ret["status"]="success";
          
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    public function show_detail($log_id)
    {
        # code...
        $log=DB::table("opos_otherpointlog")
        ->leftJoin("users","users.id","=","opos_otherpointlog.staff_user_id")
        ->select("users.name","users.first_name","users.last_name","users.id as user_id","opos_otherpointlog.*")
        ->where('opos_otherpointlog.id',$log_id)
        ->first();

        return view('seller.customer.otherpointdetail',compact('log'));
    }
    
}
