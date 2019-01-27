<?php

namespace App\Http\Controllers;

use Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellerHelpRequest;
use App\Models\SellerHelp;
use App\Models\Merchant;
use App\Models\Station;
use App\Models\Invoice;
use App\Models\CreditNote;

use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use Log;
use Carbon;
use App\Models\Globals;
use App\Models\User;
use App\DebitNote;

class AgeingReportController extends Controller
{
	public function creditageinreport($id=null, $merchant_id = null)
	{
		if (!Auth::check() ) 
		{
			return view('common.generic')->
				with('message_type','error')->
				with('message','Please login to access the page')->
				with('redirect_to_login',1);
		}

		$globals=Globals::first();

		if ($id != null && $id != 0) {
			$user_id= $id;
		} else {
			$user_id= Auth::user()->id;
		}

		$selluser = User::find($user_id);

		$station=null;
		if(!empty($merchant_id)){
			$station= DB::table('station')->
			where('user_id',$merchant_id)->
			first();
		}

		$invoices = array();

		$gatorcrediter = \DB::table('porder')->
			Leftjoin('station','station.user_id','=','porder.user_id')->
			join('orderproduct', 'orderproduct.porder_id', '=', 'porder.id')->
			join('product', 'orderproduct.product_id', '=', 'product.id')->
			join('merchantproduct' ,'merchantproduct.product_id','=',
				'product.parent_id')->
			join('invoice', 'invoice.porder_id', '=', 'porder.id')->
			join('merchant','merchantproduct.merchant_id','=','merchant.id')->
			where('porder.user_id' , $merchant_id)->
			whereNull('porder.is_emerchant')->
			orderBy('porder.created_at','desc')->
			get();

		$CreditorData= $this->get_Creditorinvoice_payment(
			$gatorcrediter,true);

		$oid = 0;
		foreach ($CreditorData as $po2) {
			$rcv_date = null;
			$due_date = null;
			$ex=DB::table('porder')->where('id',$po2['oid'])->first();

			if(isset($ex)){
				$rcv_date = $ex->created_at;

				if($rcv_date != null and $rcv_date != ''){
					$date = Carbon::parse($rcv_date);
					$day = $date->format('d');
					$month = $date->format('m');
					$year = $date->format('Y');
					$day_after_seven_days = $day + 7;

					if($day_after_seven_days <= 15){
						$due_date = Carbon::parse($year.'-'.$month.'-15')->
							format('dMy h:m');
					} else {
						$due_date = Carbon::parse($year.'-'.$month.'-30')->
							format('dMy h:m');
					}

				} else {
					$due_date= '';
				}

				$po2['due_date'] =   $due_date;
				$po2['rcv_date'] =   Carbon::parse($rcv_date)->format('dMy h:m');
			}

			$po2['status']=$ex->status;
			$po2['o_exec']=$ex->created_at;
			$po2['o_upd']=$ex->updated_at;

			if($oid != $po2['oid']){
				$oid = $po2['oid'];
				array_push($invoices, $po2);
			}
		}

		$dtcrediter = CreditNote::join('return_of_goods',
			'creditnote.return_of_goods_id','=','return_of_goods.id')->
			join('ordertproduct','return_of_goods.order_tproduct_id','=',
				'ordertproduct.id')->
			join('merchant','merchant.id','=','return_of_goods.merchant_id')->
			where('station_id' , $merchant_id)->
			whereIn('creditnote.status', ['rejected','approved'])->
			select(
				'return_of_goods.merchant_id as merchant_id',
				'merchant.company_name as name',
				'return_of_goods.quantity as quantity',
				'ordertproduct.order_price as order_price',
				'creditnote.status as status',
				'ordertproduct.porder_id as porder_id',
				'return_of_goods.station_id as station_id')->
			orderBy('creditnote.id','desc')->
			get();

		return view('seller.term.cageing-report')->
			with('selluser',$selluser)->
			with('station',$station)->
			with('invoices',$invoices)->
			with('dtcrediter',$dtcrediter)->
			with('merchantData',$gatorcrediter);
	}


	public function get_Creditorinvoice_payment($invoices,$payment){
		$products = array();

		foreach ($invoices as $order) {
			try {
				$odata = DB::table('orderproduct')->
					where('porder_id', $order->porder_id)->get();

				$total = 0;
				foreach ($odata as $opd) {
					$amount = ($opd->quantity * ($opd->order_price)) +
						$opd->order_delivery_price;
					$total += $amount;
				}

				$inv = DB::table('invoice')->
					where('porder_id', $order->porder_id)->first();

				$pdata = DB::table('invoicepayment')->
					where('invoice_id', $inv->id)->get();

				$paid = 0;
				foreach ($pdata as $ppd) {
					$amount = $ppd->amount;
					$paid += $amount;
				}

				$porder = DB::table('porder')->
					where('id', $order->porder_id)->first();

				$temp = array();
				$temp['total'] = $total;

				$temp['paid'] = $paid;
				$temp['mode'] = $order->mode;
				$temp['oid'] = $order->porder_id; //Order ID
				$temp['invoice_no'] = $inv->invoice_no; //Order ID
				$temp['merchant_id'] = $order->merchant_id; //Order ID

				$merchant = DB::table('merchant')->
					where('id',$order->merchant_id)->first();

				$temp['merchant_name'] = $merchant->company_name; //Order ID
				$temp['invoice_status'] = $inv->status; //Order ID
				$temp['invoice_payment'] = $inv->payment; //Order ID
				$temp['o_rcv'] = $order->delivery_tstamp;
				$temp['o_exec'] = $order->created_at;
				$temp['uid'] = $porder->user_id;

				$user = DB::table('users')->
					where('id',$porder->user_id)->first();

				if(!is_null($user)){
					$temp['name']=$user->first_name . " " . $user->last_name;
				} else {
					$temp['name']="";
				}

				$temp['comm']=0;
				$temp['desc']=$order->description;

				array_push($products, $temp);

			} catch (\Exception $e){
				Log::error($e->getFile().':'.$e->getLine().':'.
					$e->getMessage());
				echo "<script> console.log('Exception:Product not found' ); </script>";
			}
		}
		return $products;
	}


	public function debtorageingdirect($id=null, $station_user_id = null)
	{
		
		Log::debug('***** debtorageingdirect('.$id.','.$station_user_id.') *****');

		if (!Auth::check() ) {
			return view('common.generic')->
				with('message_type','error')->
				with('message','Please login to access the page')->
				with('redirect_to_login',1);
		}
		$globals=Globals::first();

		if ($id != null && $id != 0) {
			$user_id= $id;
		} else {
			$user_id= Auth::user()->id;
		}
		
		Log::debug('user_id='.$user_id);

		$selluser = User::find($user_id);		
		$merchant_id= DB::table('merchant')->
			where('user_id',$user_id)->
			pluck('id');

		$station=null;

		if(!is_null($station_user_id)){
			$p_order = DB::table('porder')->
				where('user_id',$station_user_id)->first();

			if(!empty($p_order)){
				if($p_order->is_emerchant == 1) {
					// $station_user_id = $p_order->staff_user_id;

                    $station =  DB::table('emerchant')->where('id',$p_order->user_id)->first();
                    $station->user_id = $station->id;
				}else{
					$station= DB::table('station')->
					where('user_id',$station_user_id)->
					first();
				}
			}

			Log::debug("station_user_id=".$station_user_id);
		}

		Log::debug("station=".json_encode($station));
		$station_id = $station->id;

		$invoices = array();

		if(!empty($merchant_id)){

			$invoices2 = DB::table('porder')->
				Leftjoin('station','station.user_id','=','porder.user_id')->
				join('orderproduct', 'orderproduct.porder_id', '=',
					'porder.id')->
				leftjoin('orderproductreturn', 'orderproduct.id', '=',
					'orderproductreturn.orderproductqty_id')->
				join('product', 'orderproduct.product_id', '=', 'product.id')->
				join('invoice', 'invoice.porder_id', '=', 'porder.id')->
				join('merchantproduct' ,'merchantproduct.product_id','=',
					'product.parent_id')->
				leftjoin('merchant','merchantproduct.merchant_id','=',
					'merchant.id')->
				where('merchant.id', $merchant_id)->
				where('porder.user_id', $station_user_id)->
				orderBy('porder.created_at','desc')->
				get();

			$product_invoices2= $this->get_directinvoice_payment(
				$invoices2,true);

			$oid = 0;
			foreach($product_invoices2 as $po2) {
				$rcv_date = null;
				$due_date = null;

				$ex=DB::table('porder')->where('id',$po2['oid'])->first();

				if(isset($ex)) {
					$rcv_date = $ex->created_at;
					if($rcv_date != null and $rcv_date != ''){
						$date = Carbon::parse($rcv_date);
						$day = $date->format('d');
						$month = $date->format('m');
						$year = $date->format('Y');
						$day_after_seven_days = $day + 7;

						if($day_after_seven_days <= 15) {
							$due_date = Carbon::parse($year.'-'.$month.'-15')->
								format('dMy h:m');
						} else {
							$due_date = Carbon::parse($year.'-'.$month.'-30')->
							format('dMy h:m');
						}

					} else {
						$due_date= '';
					}

					$po2['due_date'] = $due_date;
					$po2['rcv_date'] = Carbon::parse($rcv_date)->
						format('dMy h:m');
				}

				$po2['status']=$ex->status;
				$po2['o_exec']=$ex->created_at;

				if($oid != $po2['oid']) {
					$oid = $po2['oid'];
					array_push($invoices, $po2);
				}
			}
		}


		$dtcrediter = CreditNote::join('return_of_goods',
			'creditnote.return_of_goods_id','=','return_of_goods.id')->
			join('orderproduct','return_of_goods.order_tproduct_id','=',
				'orderproduct.id')->
			join('merchant','merchant.id','=','return_of_goods.merchant_id')->
			where('station_id' , $station_id)->
			whereIn('creditnote.status', ['rejected','approved'])->
			select(
				'return_of_goods.merchant_id as merchant_id',
				'merchant.company_name as name',
				'return_of_goods.quantity as quantity',
				'orderproduct.order_price as order_price',
				'orderproduct.approved_qty',
				'creditnote.status as status',
				'orderproduct.porder_id as porder_id',
				'return_of_goods.station_id as station_id')->
			orderBy('creditnote.id','desc')->
			get();

			Log::debug("DTCrediter List ".$dtcrediter);

			$merchid = $invoices[0]['invoice_no'];

		$matchThese = [
			'merchant_id' => $merchant_id,
			'dealer_user_id' => $station_user_id
		];

		$debit_notes = DebitNote::where($matchThese)->
		join('merchantdebitnote', 'merchantdebitnote.debitnote_id', '=',
				'debitnote.id')->
		join('merchant as m', 'm.id', '=', 'merchantdebitnote.merchant_id')->
		join('station as s', 'm.user_id', '=', 's.user_id')->
		leftjoin('stationterm as st',
			function($join) use ($user_id, $station_id) {
				$join->where('st.creditor_user_id', '=', $user_id);
				$join->where('st.station_id', '=', $station_id);
		})
		->select(
				's.user_id',	
				'debitnote.id',
				'debitnote.debitnote_no',
				'st.credit_limit as balance',
				'debitnote.total',
				'debitnote.status',
				'merchantdebitnote.merchant_id as merchant_id',
				'm.company_name as name')
		->orderBy('debitnote.debitnote_no','DESC')
		->get();
		Log::debug('***** debit_notes *****');
		Log::debug('merchant_id='.$merchant_id);
		Log::debug('station_id ='.$station_id);
		Log::debug('station_user_id ='.$station_user_id);
		Log::debug(json_encode($debit_notes));

		$nseller_id = IdController::nSeller($station->user_id);
		$sellids=DB::table('nsellerid')->
			where('nseller_id','=',$nseller_id)->pluck('user_id');

		$rcvdt =  $invoices[0]['oid'];
	
		$product_id = $this->get_ntproductid($merchant_id,$user_id);

		return view('seller.debtor_ageing')->
			with('selluser',$selluser)->
			with('sellids',$sellids)->
    		with('rcvdt',$rcvdt)->
			with('station',$station)->
			with('invoices',$invoices)->
			with('dtcrediter',$dtcrediter)->
			with('debit_notes',$debit_notes)->
			with('merchant_uid',$user_id)->
			with('merchant_id',$merchant_id)->
			with('product_id',$product_id)->
			with('payment', 'active');
	}


	public function get_directinvoice_payment($invoices,$payment){
		$products = array();

		foreach ($invoices as $order) {
			$option = '';
			try {
				$odata = DB::table('orderproduct')->
                where('porder_id', $order->porder_id)->get();

			$total = 0;
			foreach ($odata as $opd) {
				$opqs =  DB::table('orderproductqty') ->
					where('orderproductqty.orderproduct_id',$opd->id)->get();

				foreach ($opqs as $opq){

					$return_option = DB::table('orderproductreturn')->
						where('orderproductqty_id', $opq->id)->get();

					foreach ($return_option as $ro){
						if($ro->status == 'return'){
							$option = 'return';
						}
					}
				}

				if(empty($opd->approved_qty)){
					$amount = ($opd->quantity * ($opd->order_price)) +
						$opd->order_delivery_price;
					$total += $amount;
				} else {
					$amount = ($opd->approved_qty * ($opd->order_price)) +
						$opd->order_delivery_price;
					$total += $amount;
				}

			}

			$inv = DB::table('invoice')->
				where('porder_id', $order->porder_id)->first();

			$pdata = DB::table('invoicepayment')->
				where('invoice_id', $inv->id)->get();

			$paid = 0;

			foreach ($pdata as $ppd) {
				$amount = $ppd->amount;
				$paid += $amount;
			}

			$porder = DB::table('porder')->
				where('id', $order->porder_id)->first();

			Log::debug("option=".$option);

			$temp = array();
			$temp['total'] = $total;
			$temp['paid'] = $paid;
			$temp['mode'] = $order->mode;
			$temp['oid'] = $order->porder_id; //Order ID
			$temp['invoice_no'] = $inv->invoice_no;
			$temp['merchant_id'] = $order->merchant_id;

			$merchant = DB::table('merchant')->
				where('id',$order->merchant_id)->first();

			$temp['merchant_name'] = $merchant->company_name;
			$temp['invoice_status'] = $inv->status;
			$temp['invoice_payment'] = $inv->payment;
			$temp['o_rcv'] = $order->delivery_tstamp;
			$temp['o_exec'] = $order->created_at;
			$temp['uid'] = $porder->user_id;
			$temp['return'] = $option;

			$user = DB::table('users')->
				where('id',$porder->user_id)->first();

			if(!is_null($user)){
				$temp['name']=$user->first_name . " " . $user->last_name;
			} else {
				$temp['name']="";
			}

			$temp['comm']=0;
			$temp['desc']=$order->description;
			array_push($products, $temp);

			} catch (\Exception $e) {
				Log::error($e->getFile().':'.$e->getLine().':'.
					$e->getMessage());

				echo "<script> console.log('Exception:Product not found' ); </script>";
			}
		}
		return $products;
	}

	public function saveCreditNote(Request $request,$merchant_id,$merchant_uid)
	{		
		$row = $request->row;		
		$merchantunique_id = DB::table('nsellerid')->
		where('user_id',$merchant_uid)->
		pluck('nseller_id');		
		$ntproduct_id = UtilityController::tproductuniqueid($merchant_id,$merchantunique_id);		
		// $total = (int)$request->credit_note[$row]['total'];
		try
		{
				DB::table('tproduct')->
				insert([						
					'name' => 'test product name',
					'parent_id'=> 0,
					'product_id'=> 0,
					'description' => $request->credit_note[$row]['description'],
					'tproductdetail_id'=> 0,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				]);				
				$last_tproductid = UtilityController::getLast_tproductid();	
				DB::table('merchanttproduct')->
				insert([						
					'merchant_id'=> $merchant_id,
					'tproduct_id'=> $last_tproductid,										
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				]);

				DB::table('ntproductid')->
					insert([
						'ntproduct_id'=> $ntproduct_id,
						'tproduct_id'=> $last_tproductid,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					]);

					// DB::table('creditnoteitem')->
					// insert([						
					// 	'creditnote_id' => '1',
					// 	'creditnote_no'=> $ntproduct_id,						
					// 	'description' => $request->credit_note[$row]['description'],
					// 	'total'=> $total,						
					// ]);
		}
		catch(\Illuminate\Database\QueryException $e) 
		{			
			$errorCode = $e->errorInfo[1];
			if($errorCode == '1062')
			{				
				echo $e->errorInfo[2];
				Log::error($e->errorInfo[2]);
			}
		}		
		$newProductId = UtilityController::tproductuniqueid($merchant_id,$merchantunique_id);
		return $newProductId;
	}

	public function get_ntproductid($merchant_id,$merchant_uid) {

		Log::debug('***** get_ntproductid('.$merchant_id.','.
			$merchant_uid.') *****');		
		
		$merchantunique_id = DB::table('nsellerid')->
		where('user_id',$merchant_uid)->
		pluck('nseller_id');		
		$ntproduct_id = UtilityController::tproductuniqueid($merchant_id,$merchantunique_id);

		// $tproduct_id = UtilityController::getLast_tproductid();

	// 	if (!empty($ntproduct_id)) 
	// 	{
	// 		try 
	// 		{
	// 			DB::table('ntproductid')->
	// 				insert([
	// 					'ntproduct_id'=>$ntproduct_id,
	// 					'tproduct_id'=> $tproduct_id,
	// 					'created_at' => date('Y-m-d H:i:s'),
	// 					'updated_at' => date('Y-m-d H:i:s')
	// 				]);			
	// 		} 
	// 		catch(\Illuminate\Database\QueryException $e) 
	// 		{
	// 			// echo "error";
	// 			$errorCode = $e->errorInfo[1];
	// 			if($errorCode == '1062')
	// 			{
	// 				// echo "<br>";
	// 				// echo $e->errorInfo[2];
	// 				Log::error($e->errorInfo[2]);
	// 			}
	// 		}
	// }
		// exit;
		return $ntproduct_id;
	}
}
