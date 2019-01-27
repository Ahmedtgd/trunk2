<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Delivery;
use App\Models\User;
use App\Models\Logistic;
use App\Models\Merchant;
use App\Models\Address;
use App\Models\City;
use App\Models\State;
use App\Models\Buyer;
use App\Models\LogisticSlab;
use App\Models\Slab;

class AdminLogisticController extends Controller
{
  
    public function showLCMasterAPI($value='')
    {
        // API
        try {
            $logs=Logistic::where('professional',1)
            ->leftJoin('station as st','st.id','=','logistic.station_id')
            ->leftJoin('delivery as dl','dl.id','=','logistic.id')
            ->leftJoin('company','company.id','=','logistic.company_id')
   //         ->leftJoin('porder as po','dl.porder_id','=','po.id')
   //         ->leftJoin('orderproduct as op','op.porder_id','=','po.id')
			->distinct()
			->select(DB::raw("
                logistic.*,
                st.id as station_id,
                st.user_id as uid,
                company.company_name as lcompany_name,
				dl.porder_id
                "))
            ->get();
			foreach($logs as $l){
				$outstanding = DB::table('porder')->join('delivery','delivery.porder_id','=','porder.id')->where('delivery.logistic_id',$l->id)->where('delivery.status','!=','delivered')->select('porder.*')->distinct()->get();
				
				$delivered = DB::table('porder')->join('delivery','delivery.porder_id','=','porder.id')->where('delivery.logistic_id',$l->id)->where('delivery.status','=','delivered')->select('porder.*')->distinct()->get();
				
				$total = DB::table('porder')->join('delivery','delivery.porder_id','=','porder.id')->where('delivery.logistic_id',$l->id)->select('porder.*')->distinct()->get();
				$total_delivery = 0;
				$total_delivery_up = 0;
				
				foreach($total as $porder){
					//dump($porder);
					$total_del = DB::table('orderproduct')->where('porder_id',$porder->id)->sum('order_delivery_price');
					$total_del_up = DB::table('orderproduct')->where('porder_id',$porder->id)->whereRaw('orderproduct.porder_id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = ' . $l->uid . ' AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = orderproduct.porder_id)')->sum('order_delivery_price');
					$total_delivery += $total_del;
					$total_delivery_up += $total_del_up;
				}
				
				
				$l->outstanding= count($outstanding);
				$l->delivered= count($delivered);
				$l->dos= count($total);
				$l->total_delivery= $total_delivery;
				$l->total_delivery_up= $total_delivery;
			}
        } catch (\Exception $e) {

            dump($e);
            $logs=array();
        }
        // return $logs;
		$lgrades = DB::table('lgrade')->get();
        return view('logistics.lcapi')
        ->with('lgrades',$lgrades)
        ->with('logs',$logs);
    }

    public function showLCMaster()
    {
        // without API
        try {
            $logs=Logistic::where('professional',0)
            ->leftJoin('station as st','st.id','=','logistic.station_id')
            ->leftJoin('delivery as dl','dl.id','=','logistic.id')
            ->leftJoin('company','company.id','=','logistic.company_id')
   //         ->leftJoin('porder as po','dl.porder_id','=','po.id')
   //         ->leftJoin('orderproduct as op','op.porder_id','=','po.id')
			->distinct()
			->select(DB::raw("
                logistic.*,
                st.id as station_id,
                st.user_id as uid,
                company.company_name as lcompany_name
                "))
            ->get();
			
			foreach($logs as $l){
				$outstanding = DB::table('porder')->join('delivery','delivery.porder_id','=','porder.id')->where('delivery.logistic_id',$l->id)->where('delivery.status','!=','delivered')->select('porder.*')->distinct()->get();
				
				$delivered = DB::table('porder')->join('delivery','delivery.porder_id','=','porder.id')->where('delivery.logistic_id',$l->id)->where('delivery.status','=','delivered')->select('porder.*')->distinct()->get();
				
				$total = DB::table('porder')->join('delivery','delivery.porder_id','=','porder.id')->where('delivery.logistic_id',$l->id)->select('porder.*')->distinct()->get();
				$total_delivery = 0;
				$total_delivery_up = 0;
				
				foreach($total as $porder){
					//dump($porder);
					$total_del = DB::table('orderproduct')->where('porder_id',$porder->id)->sum('order_delivery_price');
					$total_del_up = DB::table('orderproduct')->where('porder_id',$porder->id)->whereRaw('orderproduct.porder_id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = ' . $l->uid . ' AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = orderproduct.porder_id)')->sum('order_delivery_price');
					$total_delivery += $total_del;
					$total_delivery_up += $total_del_up;
				}
				
				
				$l->outstanding= count($outstanding);
				$l->delivered= count($delivered);
				$l->dos= count($total);
				$l->total_delivery= $total_delivery;
				$l->total_delivery_up= $total_delivery;
			}
        } catch (\Exception $e) {
            dump($e);
            $logs=array();
        }
		$lgrades = DB::table('lgrade')->get();
        return view('logistics.lc')
		->with('lgrades',$lgrades)
        ->with('logs',$logs);
    }


    public function showLogComm()
    {
        
        return view('logistics.lcomm');
    }

    
}
