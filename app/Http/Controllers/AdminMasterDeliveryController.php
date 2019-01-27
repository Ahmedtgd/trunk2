<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Delivery;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Yajra\Datatables\Facades\Datatables;

class AdminMasterDeliveryController extends Controller
{
    public function getDelivery()
    {
        // return array();
       // DB::table('delivery')
        try {
            return Delivery::join('logistic','logistic.id','=','delivery.logistic_id')
			->join('station','logistic.station_id','=','station.id')
		//	->leftJoin('nsellerid','station.user_id','=','nsellerid.user_id')
			->leftJoin('nsproviderlogisticid','nsproviderlogisticid.logistic_id','=','logistic.id')
			->leftJoin('nsproviderid','nsproviderid.id','=','nsproviderlogisticid.nsproviderid_id')
			->leftJoin('ndeliveryid','ndeliveryid.delivery_id','=','delivery.id')
			->join('porder','porder.id','=','delivery.porder_id')
			->join('orderproduct','delivery.porder_id','=','orderproduct.porder_id')
			->leftJoin('nporderid','nporderid.porder_id','=','porder.id')
            ->select(DB::raw("
				DATE_FORMAT(delivery.created_at,'%d%b%y %H:%i') as date,
                delivery.logistic_id as lid,
                station_id as sid,
                station.user_id as uid,
                0 as fee,
				IFNULL(nsproviderid.nsprovider_id,LPAD(logistic.id,16,'E')) as seller_id,
				IFNULL(ndeliveryid.ndelivery_id,LPAD(delivery.id,16,'E')) as delivery_id,
				IFNULL(nporderid.nporder_id,LPAD(porder.id,16,'E')) as porder_id,
                delivery.porder_id as id,
                delivery.id as did,
				SUM(orderproduct.order_delivery_price) as nfee,
                porder.status,
                delivery.status as dstatus,
                delivery.consignment_number as cn
                "))
            ->groupBy('delivery.id')
            ->orderBy('delivery.created_at','DESC');
        } catch (\Exception $e) {
			//dd($e);
            return array(); 
        }
       
    }

	public function get_deliverys($start=0)
    {
        $end=$start+30;

        $ret=array();
        if (!Auth::check() or !Auth::user()->hasRole('adm')) {
            return $ret;
        }
        try {
            $ret=$this->getDelivery();
              
        } catch (\Exception $e) {
            // dd($e);
        }
        return Datatables::eloquent($ret)->make(true);
        return response()->json($ret);
    }	
	
    public function showDelivery()
    {

		$ret=$this->getDelivery();
        // return $data;
		//dd(Datatables::eloquent($ret)->make(true));
        return view('logistics.admin.master');
       // ->with('deliverys',$data);
    }
}
