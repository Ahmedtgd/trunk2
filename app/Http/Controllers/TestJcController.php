<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\api\ARSApi as jcAPI;

class TestJcController extends Controller
{


    public function test(){
        return view('jctopup.test');
    }


    public $obj;

    public function __construct(){
        $api = jcAPI::getInstance();
        $this->obj = $api;
        $base_url = \DB::table('global')->select('jc_ars_url')->first();
        $this->obj->setBaseURL($base_url); 

    }

    public function request1(Request $request)
    {
        $inputs = $request->all();

        // $tM = $inputs["targetMSISDN"];
        // $tpD = $inputs["telcoCODE"];
        // $tD = $inputs["transDATE"];
        // $tt = $inputs["transTIME"];
        // $tid = $inputs["transID"];

        // $this->obj->setTransID();
        
        // $tid = $this->obj->getTransID();

        // $tid = $inputs["trans_id"];
        // $tM  = $inputs["target_msisdn"];
        // $tpD = $inputs["tp_denom"];
        // $tD = date('Ymd');
        // $tt = date('hms');

        
        // $this->obj->setVeriCode($tid, $tM, $tpD, $tD, $tt);
       
        // $vc = $this->obj->getVeriCode();


        // $inputs["veriCODE"] = $vc;
        // $inputs["transDATE"] = $tD;
        // $inputs["transTIME"] = $tt;


       


        // $inputs["transID"] = $tid;
        
        dd($this->obj->arsTpFieldsPOSTHttpRequest($inputs));

    }

    public function request2(Request $request)
    {
        $inputs = $request->all();

        $this->obj->setTransID();
    
        $tid = $this->obj->getTransID();

        $inputs["transID"] = $tid;

        dd($this->obj->arsTpRstFieldsPOSTHttpRequest($inputs));
    }

    public function tpresponse(Request $request)
    {
    }

}
