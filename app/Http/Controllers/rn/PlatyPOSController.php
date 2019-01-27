<?php

namespace App\Http\Controllers\rn;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\PlatyPOS;
use Log;
use Carbon;
use JWTAuth;
class PlatyPOSController extends Controller
{


    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    function __construct()
    {
        $this->platypos=new PlatyPOS(1);
    }
    public function tables($location_id=NULL)
    {
        
        
       return $this->platypos->tables($location_id);
    }

    public function menu($location_id=null)
    {
        return $this->platypos->menu(19);
    }

    public function add_products(Request $r)
    {
        
        try {
            return $this->platypos->add_products($r);
        } catch (\Exception $e) {
            Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
        }
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function kitchen_dishes(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        
        try{
         
            $data=$this->platypos->kitchen_dishes($r);
            $ret["status"]="success";
            $ret["dishes"]=$data;
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
    
    public function kitchen_cooking(Request $r,$uid=NULL)
    {
        
        return $this->platypos->kitchen_cooking($r);
    }

    public function end_cooking(Request $r)
    {
        # code...

        return $this->platypos->end_cooking($r);
    }

    public function customer_order(Request $r)
    {
        return $this->platypos->customer_order($r);
    }
    
    public function customer_order_deliver(Request $r)
    {
        # code...
        return $this->platypos->customer_order_deliver($r);
    }
    
    public function linkedproducts(Request $r)
    {
        return $this->platypos->linkedproducts($r);
    }

    public function end_transaction(Request $r)
    {
        # code...
        return $this->platypos->end_transaction($r);
    }
}
