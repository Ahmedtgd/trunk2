<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use DB;
use Log;
use Carbon;
use Auth;

class CustomerController extends Controller
{
    //-----------------------------------------
    // Created by Zurez
    // DataManagement ->Customer List->Action
    //-----------------------------------------
    
    public function customer_details($member_id,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{

            $member=DB::table('member')->where('id', $member_id)->first();
            $otherpoints=DB::select(DB::raw(
                "
                SELECT 
                SUM(CASE WHEN opl.type = 'IN'  then points
                WHEN opl.type = 'OUT' then - points
                END) as total_points
                FROM 
                opos_otherpointlog opl 
                 
                WHERE opl.deleted_at IS NULL 
                AND opl.member_id=$member_id
            "))[0]->total_points;
            //dd($otherpoints);
            $segments=DB::table('membersegment')
            ->join('companymembersegment','companymembersegment.id','=','membersegment.segment_id')
            ->where('membersegment.member_id',$member_id)
            ->whereNull('membersegment.deleted_at')
            ->get();
            $otherpoints=number_format($otherpoints/1.0,2);
            $data=compact('member','segments','otherpoints');            
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
    
    public function save_details(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $member_id=$r->member_id;
            $segmentlist=$r->segmentlist;

            $update=[
            "updated_at"=>Carbon::now(),
            "action"=>$r->action,
            "stage"=>$r->stage,
            "remark"=>$r->remarks

            ];
            DB::table("member")->where('id',$member_id)->update($update);
            $ret["status"]="success";
          
            $customer_segments = DB::table('membersegment')->where('member_id',$member_id)->delete();
            for($i=0;$i<sizeof($segmentlist);$i++){

                    $customer_segments = DB::table('membersegment')->insert(['member_id'=>$member_id,'segment_id'=>$segmentlist[$i]]);
                    
            }
           
           $ret['status']="success";
        }
        catch(\Exception $e){
            
            
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    public function show_otherpoints($member_id)
    {
        # code...
        return view("seller.customer.otherpoints");
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function ncustomer_details($member_id,$uid=NULL)
    {
        $ret=array();

        $ret["status"]="failure";
        if(!Auth::check()){return "auth error";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="ncustomer";
           // return $table;
            $ncustomer=DB::table($table)
            ->where($table.".member_id",$member_id)        
            ->whereNull($table.".deleted_at")
            ->orderBy($table.".created_at","DESC")
            ->first();
            $user=DB::table("member")->join("users","users.id","=","member.user_id")
            ->where('member.id',$member_id)
            ->select("users.id as user_id")->first();
            $data=compact('ncustomer','user');
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            dump($e);
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function save_ncustomer(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }

        try{
            $data=[
                "company_name"=>$r->company_name,
                "business_reg_no"=>$r->bs_no,
                
                "address_line1"=>$r->address1,
                "address_line2"=>$r->address2,
                "address_line3"=>$r->address3,
                "state"=>$r->state,
                "city"=>$r->city,
                "postcode"=>$r->postal_code,
                "name"=>$r->name,
                "c_address_line1"=>$r->c_address1,
                "c_address_line2"=>$r->c_address2,
                "c_address_line3"=>$r->c_address3,
                "c_state"=>$r->c_state,
                "c_city"=>$r->c_city,
                "c_postcode"=>$r->cpostal,
                "mobile_no"=>$r->c_mobile,
                "updated_at"=>Carbon::now()

            ];
            // echo "<pre>"; print_r ($r->all()); echo "</pre>"; exit();
            $member_id=$r->member_id;
            // if (empty($member_id) && !empty($r->email)) {
            if (empty($member_id) && !empty($r->email)) {
                #Create new member
                $insert=[
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now(),
                "email"=>$r->email,
                "type"=>'customer',
                "name"=>$r->name

                ];
                $member_id=DB::table('member')->insertGetId($insert);
            }
            if ($r->has('alt_email') && !empty($r->alt_email)) {
                # code...
                DB::table("member")
                ->where("id",$member_id)->update([
                    "updated_at"=>Carbon::now(),
                    "email"=>$r->alt_email
                ]);
            }
            $does_exists=DB::table('ncustomer')
            ->where('member_id',$r->member_id)
            ->whereNull('deleted_at')
            ->first();
            if ($r->has('member_id') && !empty($does_exists)) {
                DB::table("ncustomer")->where('member_id',$r->member_id)->update($data);
            }else{
                $data["created_at"]=Carbon::now();
                $data['member_id']=$r->member_id;
                DB::table("ncustomer")->insert($data);
            }

            $ret["status"]="success";
           
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    public function otherpoint($member_id)
    {
        # code...
        $logs=DB::table('opos_otherpointlog')
        ->whereNull('deleted_at')
        ->where('member_id',$member_id)
        ->get();

        return view('seller.customer.otherpoint',compact('logs'));
    }
}
