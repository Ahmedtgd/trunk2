<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Carbon;
use Auth;
class StaffController extends Controller
{
 //-----------------------------------------
 // Created by Zurez
 //-----------------------------------------
 
 public function allowed_functions($location_id,$uid=NULL)
 {
     $ret='<option value="0" selected>Select Function</option>';
     if(!Auth::check()){return "";}
     $user_id=Auth::user()->id;
     if(!empty($uid) and Auth::user()->hasRole("adm")){
         $user_id=$uid;
     }
   
     try{
        /*Get Company Id from location*/
        $owner_user_id=DB::table('fairlocation')
        ->where('id',$location_id)
        ->pluck('user_id');
        if (empty($owner_user_id)) {
            
            return "No owner";
        }
        $company_id=DB::table('company')
        ->where('owner_user_id',$owner_user_id)
        ->whereNull('deleted_at')
        ->pluck('id');
        
        if (empty($company_id)) {
            # code...
            return "No company";
        }

        $roles=DB::table('role_users')
        ->join('roles','roles.id','=','role_users.role_id')
        ->where('role_users.company_id',$company_id)
        ->where('role_users.user_id',$user_id)
        ->whereNull('role_users.deleted_at')
        ->whereNull('roles.deleted_at')
        ->select('roles.slug')
        ->get();

        $rolesArray=[];
        foreach ($roles as $key => $value) {
            # code...
            array_push($rolesArray,$value->slug);
        }
       
        /*Opossum Access*/
        $oproles=['opu','opm','spu','spm'];
        
        if (sizeof((array_intersect($oproles,$rolesArray)))>0) {
           
            $ret.='<option value="opossum">Opossum</option>';
        }

        /*Warehouse Access*/
        $whroles=['whm','whu','cmg','cur'];
        if (sizeof((array_intersect($whroles,$rolesArray)))>0) {
            # code...
            $ret.='<option value="warehouse">Warehouse</option>';
        }
        /*Album*/
        $albroles=['alb'];
        if (sizeof((array_intersect($albroles,$rolesArray)))>0) {
            # code...
            $ret.='<option value="album">Album</option>';
        }
        /*Inventory*/
        $invroles=['inv'];
        if (sizeof((array_intersect($invroles,$rolesArray)))>0) {
            # code...
            $ret.='<option value="inventory">Inventory</option>';
        }

     }   
     catch(\Exception $e){
        
         Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());

     }
    
     return $ret;
 }
 
}
