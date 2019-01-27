<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SMMout;
use App\Models\SMMin;
use DB;
use App\Classes\UserPayment;

class PaySMMController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function smmpayment()
    {
    	$smmouts = SMMout::get();
    	//selected
    	//smmout - product_id, shares
    	$result = array();
    	$userpaymentservice = new UserPayment;
    	
    	foreach($smmouts as $smmout)
    	{
    		if(array_key_exists($smmout->user_id,$result))
    		{
    			$result[$smmout->user_id]['items']+=1;
    			$result[$smmout->user_id]['shares']+=$smmout->shares;
    		} else {
    			$result[$smmout->user_id]['name']=$smmout->user->name;
    			$result[$smmout->user_id]['items']=1;
    			$result[$smmout->user_id]['shares']=$smmout->shares;
    		}
    		$result[$smmout->user_id]['view'] = 0;
    		$result[$smmout->user_id]['buy'] = 0;
    		$query = SMMin::where('smmout_id',$smmout->id)->select('response', DB::raw('count(*) as total'))->groupBy('response')->get();
    		foreach($query as $row)
    		{
    			if(strcmp($row->response,'view')==0)
    			{
    				$result[$smmout->user_id]['view'] = $row->total;
    			} else {
    				$result[$smmout->user_id]['buy'] = $row->total;
    			}
    		}
    		if(!array_key_exists('payable',$result[$smmout->user_id]))
    		{
    			$result[$smmout->user_id]['payable'] = $userpaymentservice->payable($smmout->user_id);
    		}
    		
    		$result[$smmout->user_id]['bought'] = $smmout->product->retail_price * $result[$smmout->user_id]['buy'];
    	}
    	return view('smmpayment',compact('result'));
    }
    
}
