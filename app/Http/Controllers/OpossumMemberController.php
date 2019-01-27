<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Carbon;
use Log;
use Auth;
class OpossumMemberController extends Controller
{
    public function view($terminal_id)
    {
        # code...
        $location_id=DB::table("opos_locationterminal")->where("terminal_id",$terminal_id)->whereNull("deleted_at")->pluck("location_id");
        if (empty($location_id)) {
            # code...
            return "bad location";
        }

        $owner_user_id=DB::table('fairlocation')->where("id",$location_id)
        ->whereNull('deleted_at')->pluck("user_id");
        if (empty($owner_user_id)) {
            # code...
            return "bad owner";
        }

        $company_id=DB::table('company')->where('owner_user_id',$owner_user_id)
        ->whereNull('deleted_at')->pluck('id');
        if (empty($company_id)) {
            # code...
            return "bad company";
        }
        
        $customers=DB::select(DB::raw("

            SELECT 

                SUM(CASE WHEN opl.type = 'IN'  then points
                WHEN opl.type = 'OUT' then - points
                END) as total_points,
                member.member_no,
                ncustomer.*

                FROM 
                ncustomer 
                JOIN member on ncustomer.member_id=member.id AND member.company_id=$company_id
                LEFT JOIN opos_otherpointlog opl on member.id=opl.member_id

                WHERE opl.deleted_at IS NULL 
                AND member.deleted_at IS NULL
                AND ncustomer.deleted_at IS NULL 

                GROUP BY ncustomer.id

        "));
        
        return view("opposum.trunk.otherpoint",compact('customers'));

    }
    function get_company_id($r)
    {
        # code...
        $location_id=DB::table("opos_locationterminal")->where("terminal_id",$r->terminal_id)->whereNull("deleted_at")->pluck("location_id");
      

        $owner_user_id=DB::table('fairlocation')->where("id",$location_id)
        ->whereNull('deleted_at')->pluck("user_id");
        

        $company_id=DB::table('company')->where('owner_user_id',$owner_user_id)
        ->whereNull('deleted_at')->pluck('id');
        return $company_id;
    }
    public function create_member($r,$company_id,$membertype)
    {
        # code...
        $user_id=Auth::user()->id;
        
        $is_user=DB::table("users")->where('email',$r->email)
        ->whereNull('deleted_at')->first();
        $member_status='exists';
        if (empty($is_user)) {
            # code...
            $member_status='not exists';
        }else{

        }
        $email="";
        if ($membertype=="member") {
            # code...
            $email=$r->alt_email;
        }else{
            $email=$r->email;
        }
    
        $data=[
                
                "name"=>$r->name,
                "company_id"=>$company_id,
                "type"=>$membertype,
                "status"=>"active",
                "recruiter_id"=>$user_id,
                "email"=>$email,
                "member_status"=>$member_status,
                "updated_at"=>Carbon::now(),
                "created_at"=>Carbon::now()

            ];
        if ($membertype=="customer") {
            # code...
            $data['member_no']=$r->member_no;
        }
        return DB::table("member")->insertGetId($data);


    }
    public function create_customer(Request $r)

    {
        # code...
        if (!Auth::check()) {
            # code...
            return "Authorization error";
        }
        if (!$r->has('member_no')) {
            return "Member Number is required";
        }
        $user_id=Auth::user()->id;
        $company_id=$this->get_company_id($r);
        $is_member_email=null;
        $is_member=null;
       /* if (!empty($r->email) && $r->email!="") {
            # code...
            $is_member_email=DB::table('member')
            ->where('company_id',$company_id)
            ->whereNull('deleted_at')
            ->where('email',$r->email)
            
            ->first();
        
        
        }*/
        

        if (!empty($r->member_no) && $r->member_no!="") {
            # code...
            $is_member=DB::table('member')
            ->where('company_id',$company_id)
            ->whereNull('deleted_at')
            
            ->where('member_no',$r->member_no)
            ->first();
        
        
        }

        
        
        if (empty($is_member)) {
            # code...
            $member_id=$this->create_member($r,$company_id,"customer");
        }else{
            $member_id=$is_member->id;
        }
        
        $name=$r->name;
        if (empty($name)) {
            # code...
            $name="";
        }
        $mobile_no=$r->c_mobile;
        if (empty($mobile_no)) {
            # code...
            $mobile_no="";
        }
        $email=$r->email;
        if (empty($email)) {
            # code...
            $email="";
        }
        $insert=[
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now(),
                "email"=>$email,
                "name"=>$name,
                "mobile_no"=>$mobile_no,
                "member_id"=>$member_id

                ];
        $is_customer=DB::table("ncustomer")
        ->where('member_id',$member_id)->whereNull('deleted_at')
        ->first();
        if (empty($is_customer)) {
            # code...
            DB::table('ncustomer')->insert($insert);
            return "Member created.";
        }else{
            return "Member already exists.";
        }
        
        
    }

    public function create_staff(Request $r)
    {
        # code...
        $user_id=Auth::user()->id;
        $company_id=$this->get_company_id($r);
        
        $is_member=null;
        if (!empty($r->alt_email) && $r->alt_email!="") {
            # code...
            $is_member=DB::table('member')->where('email',$r->alt_email)
            ->where('company_id',$company_id)
            ->whereNull('deleted_at')->first();
        
        }
        
        if (empty($is_member)) {
            # code...
            $member_id=$this->create_member($r,$company_id,"member");
        }else{
            $member_id=$is_member->id;
        }
        $nickname=$r->name;
        if (empty($nickname)) {
            # code...
            $nickname="";
        }
        $mobile_no=$r->mobile_no;
        if (empty($mobile_no)) {
            # code...
            $mobile_no="";
        }
        $insert=[
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now(),
                "alt_email"=>$r->alt_email,
                "nickname"=>$nickname,
                "mobile_no"=>$mobile_no,
                "member_id"=>$member_id

                ];
        $is_customer=DB::table("nstaff")
        ->where('member_id',$member_id)->whereNull('deleted_at')
        ->first();
        if (empty($is_customer)) {
            # code...
            DB::table('nstaff')->insert($insert);
            return "ok";
        }
    }
}
