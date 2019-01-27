<?php

namespace App\Http\Controllers;

use Carbon;
use DB;
use Request;
use App\Models\POrder;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Globals;
use App\Models\Station;
use App\Models\Merchant;
use App\Classes\UserPayment;
use stdClass;
use Redirect;
use App\Exceptions\CustomException;
use Exception;
use \Illuminate\Database\QueryException;
use App\Models\GlobalT;
use App\Models\OcbcHeader;
use App\Models\OcbcDetail;
use App\Models\OcbcInv;
use App\Models\OcbcTrailer;
use App\Models\User;
use App\Models\Payment;
use App\Models\Currency;
use App\Models\OcbcRetHeader;
use App\Models\OcbcRetDetail;
use App\Models\OcbcRetTrailer;
use App\Models\OcbcPaymentStatus;
use App\Models\Ocredit;
use PDO;
use Cart;
use Auth;
use Storage;
use Session;
use File;
use App\Classes\IPayReceivable;

Class UserPaymentController extends Controller {

	private $carbon;
	private $userpayment;
	private $iPayReceivable;
	public  $cStatus='"completed","reviewed","commented"';
	public function __construct()
	{
		$this->carbon = new Carbon\Carbon;
		$this->userpayment = new UserPayment;
		$this->iPayReceivable=new IPayReceivable;
	}

	/**
	 * [payment view of merchant]
	 * @return [array] [it will return all merchants and redirect to merchant_payment view]
	 */
	public function get_consolidator()
	{
		$consolidators= $this->get_consolidation();
		$global = DB::table('global')->first();
		return view('consolidation_payment',['consolidators'=> $consolidators,'global'=> $global]);
	}

	private function get_consolidation()
	{
		try {
			$global = DB::table('global')->first();
			$consolidation = DB::select(DB::raw("SELECT created, pending_amount, executed_amount, awaiting_amount, id, user_id, role_id, name, period_start, period_end, confirm, remark FROM (
					SELECT cs_payment.created_at as created, SUM(IF(cs_payment.status = 'awaiting',cs_payment.amount,0)) as awaiting_amount, SUM(IF(cs_payment.status = 'pending',cs_payment.amount,0)) as pending_amount, SUM(IF(cs_payment.status = 'executed',cs_payment.amount,0)) as executed_amount,
					merchant.id as id, merchant.user_id as user_id, cs_payment.role_id as role_id, merchant.company_name as name, cs_payment.period_start as period_start, cs_payment.period_end as period_end, cs_payment.date_confirm as confirm, cs_payment.remark as remark
					FROM cs_payment, merchant
					WHERE
					cs_payment.status = 'pending' AND cs_payment.role_id = 3 AND merchant.user_id = cs_payment.user_id
					GROUP BY cs_payment.id
					UNION
					SELECT cs_payment.created_at as created, SUM(IF(cs_payment.status = 'awaiting',cs_payment.amount,0)) as awaiting_amount, SUM(IF(cs_payment.status = 'pending',cs_payment.amount,0)) as pending_amount, SUM(IF(cs_payment.status = 'executed',cs_payment.amount,0)) as executed_amount,
					station.id as id, station.user_id as user_id, cs_payment.role_id as role_id, station.company_name as name, cs_payment.period_start as period_start, cs_payment.period_end as period_end, cs_payment.date_confirm as confirm, cs_payment.remark as remark
					FROM cs_payment, station
					WHERE
					cs_payment.status = 'pending' AND cs_payment.role_id = 11 AND station.user_id = cs_payment.user_id
					GROUP BY cs_payment.id
					UNION
					SELECT cs_payment.created_at as created, SUM(IF(cs_payment.status = 'awaiting',cs_payment.amount,0)) as awaiting_amount, SUM(IF(cs_payment.status = 'pending',cs_payment.amount,0)) as pending_amount, SUM(IF(cs_payment.status = 'executed',cs_payment.amount,0)) as executed_amount,
					station.id as id, station.user_id as user_id, cs_payment.role_id as role_id, station.company_name as name, cs_payment.period_start as period_start, cs_payment.period_end as period_end, cs_payment.date_confirm as confirm, cs_payment.remark as remark
					FROM cs_payment, station, logistic
					WHERE
					cs_payment.status = 'pending' AND cs_payment.role_id = 13 AND station.user_id = cs_payment.user_id and logistic.station_id = station.id
					GROUP BY cs_payment.id
					UNION
					SELECT cs_payment.created_at as created, SUM(IF(cs_payment.status = 'awaiting',cs_payment.amount,0)) as awaiting_amount, SUM(IF(cs_payment.status = 'pending',cs_payment.amount,0)) as pending_amount, SUM(IF(cs_payment.status = 'executed',cs_payment.amount,0)) as executed_amount,
					sales_staff.id as id, sales_staff.user_id as user_id, cs_payment.role_id as role_id, users.first_name || users.last_name as name, cs_payment.period_start as period_start, cs_payment.period_end as period_end, cs_payment.date_confirm as confirm, cs_payment.remark as remark
					FROM cs_payment, sales_staff, users
					WHERE
					cs_payment.status = 'pending' AND (cs_payment.role_id = 6 OR cs_payment.role_id = 7 OR cs_payment.role_id = 10) AND sales_staff.user_id = cs_payment.user_id AND sales_staff.user_id = users.id
					GROUP BY cs_payment.id
						) as t"));
		} catch(Exception $e){
			throw new CustomException($e);
		}

		$consolidation = is_array($consolidation) && !empty($consolidation) ? $consolidation : null;
		return $consolidation;
	}
	
	public function paymentorders($user_id)
	{
		try {
			$userarr = explode("_",$user_id); 
			$global = DB::table('global')->first();
			$orders = null;
			if($userarr[1] == "3"){
				$orders = DB::select(DB::raw("
					SELECT c.code as currency, po.id as poid, npo.nporder_id as nporder_id,m.id as mid,m.user_id as user_id, m.company_name as company, m.oshop_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv,
					((op.order_price * op.quantity * ((100 - (op.osmall_comm_amount/100))/100)))
					as payable, SUM((op.order_price * op.quantity) + op.actual_delivery_price) as net_payable, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM merchant m, payment p, porder po, orderproduct op, product pro, merchantproduct mp, currency c, nporderid as npo WHERE po.id = npo.porder_id AND c.active = 1 and p.id = po.payment_id and m.id = mp.merchant_id and pro.id = mp.product_id and op.porder_id = po.id and op.product_id = pro.id AND m.user_id = " . $userarr[0] . " AND po.id IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 3 AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id AND cs_payment.status = 'pending') GROUP BY po.id ORDER BY po.created_at DESC"));
			}
			if($userarr[1] == "11"){
				$orders = DB::select(DB::raw("SELECT c.code as currency, po.id as poid, npo.nporder_id as nporder_id, m.id as mid,m.user_id as user_id, m.company_name as company, m.station_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, 
					((op.order_price * op.quantity * ((100 - op.osmall_comm_amount)/100)))
					as payable, SUM((op.order_price * op.quantity) + op.actual_delivery_price) as net_payable, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM station m, payment p, porder po, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c, nporderid as npo WHERE po.id = npo.porder_id AND c.active = 1 and p.id = po.payment_id and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id AND m.user_id = ".$userarr[0]."
					and op.product_id = pro.id AND po.id IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 11
					AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id AND cs_payment.status = 'pending') GROUP BY po.id ORDER BY p.created_at DESC"));				
			}	
			if($userarr[1] == "13"){
				$orders = DB::select(DB::raw("SELECT c.code as currency, po.id as poid, npo.nporder_id as nporder_id, m.id as mid,m.user_id as user_id, m.company_name as company, m.station_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, 
					((op.actual_delivery_price * ((100 - (op.log_comm_amount/100))/100)))
					as payable, SUM((op.order_price * op.quantity) + op.actual_delivery_price) as net_payable, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM logistic l, company co, station m, delivery d, payment p, porder po, orderproduct op, product pro, currency c, nporderid as npo WHERE po.id = npo.porder_id AND c.active = 1 and p.id = po.payment_id 
					 AND d.porder_id = po.id AND l.id = d.logistic_id AND m.id = l.station_id AND co.id = l.company_id
					 and op.porder_id = po.id and op.product_id = pro.id AND po.id IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 13
					AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id AND cs_payment.status = 'pending') GROUP BY po.id ORDER BY p.created_at DESC"));				
			}

		} catch(\Exception $e){
			throw new CustomException($e);
		}	
		return json_encode($orders);
	}		

	public function post_consolidation()
	{
		//get merchant consultant IDs, merchants IDs and Receivables
		$mc_ids = Request::get('mc_ids');
		$merchant_ids = Request::get('merchant_ids');
		$receivables = Request::get('receivables');

		//ensure we have an array of merchant_ids
		if(!is_array($mc_ids) || empty($mc_ids)){
			session()->flash('error_msg', 'Select atleast one Merchant Consult');
			return redirect()->route('mcPayment');
		}

		try{
			$consolidate = $this->consolidate($mc_ids, $merchant_ids, $receivables);
		}catch(Exception $e){
			throw new CustomException($e->getMessage());
		}

		if($consolidate === TRUE){
			session()->flash('success_msg', 'Consolidation was successful');
		}elseif($consolidate === FALSE){
			session()->flash('error_msg', 'Consolidation failed');
		}else{
			session()->flash('error_msg', $consolidate);
		}
		
		//Take us back to page
		return redirect()->route('mcPayment');
	}

	private function consolidate($mc_ids, $merchant_ids, $receivables)
	{

		$ii = 0;
		foreach($mc_ids as $mc_id)
		{
			$merchant_id = $merchant_ids[$mc_id];
			$merchant_payment = $receivables[$mc_id];
			$merchant_role = 6;
			$today_day = date('d');
			$today_month = date('m');
			$period_start = date('Y-m-');
			$period_end = date('Y-m-');

			if($today_day<=15){
				$period_start .= "01";
				$period_end .= "15";
			} else {
				$period_start .= "16";
				if($today_month == 2){
					$period_end .= "28";
				} else if($today_month == 1 || $today_month == 3 || $today_month == 5 || $today_month == 7 ||
					$today_month == 8 || $today_month == 10 || $today_month == 12){
					$period_end .= "31";
				} else {
					$period_end .= "30";
				}
			}

			$cs_pay = DB::table('cs_payment')->insertGetId([
				'user_id'=>$merchant_id,
				'role_id'=>$merchant_role,
				'period_start'=>$period_start,
				'period_end'=>$period_end,
				'amount'=>$merchant_payment,
				'status'=>'pending',
				'created_at'=>date("Y-m-d H:i:s"),
				'updated_at'=>date("Y-m-d H:i:s")
			]);
			// OCREDIT
			$o = new Ocredit;
			$o->save();
//			$audit_cs_pay = DB::table('audit_cs_payment')->insertGetId([
//				'cs_id'=>$cs_pay,
//				'user_id'=>$merchant_id,
//				'role_id'=>$merchant_role,
//				'period_start'=>$period_start,
//				'period_end'=>$period_end,
//				'amount'=>$merchant_payment,
//				'status'=>'pending',
//				'created_at'=>date("Y-m-d H:i:s"),
//				'updated_at'=>date("Y-m-d H:i:s")
//			]);


			if($merchant_role == 3)
			{
				$orders = DB::select("
					SELECT porder.*
					FROM porder, orderproduct, merchantproduct, merchant
					WHERE porder.id = orderproduct.porder_id
					AND orderproduct.product_id = merchantproduct.product_id
					AND merchantproduct.merchant_id = merchant.id
					AND merchant.user_id = $merchant_id
					AND porder.id

					NOT IN
					(
						SELECT cs_payment_detail.order_id
						FROM cs_payment, cs_payment_detail
						WHERE cs_payment.user_id = merchant.user_id
						AND cs_payment.role_id = ". $merchant_role ."
						AND cs_payment.id = cs_payment_detail.cs_payment_id
						AND cs_payment_detail.order_id = porder.id
					)
				");
			}

			if($merchant_role == 6){
				$orders = DB::select("
				SELECT porder.*
				FROM porder, orderproduct, merchantproduct, merchant, sales_staff
				WHERE porder.id = orderproduct.porder_id
				AND orderproduct.product_id = merchantproduct.product_id
				AND merchantproduct.merchant_id = merchant.id
				AND merchant.mc_sales_staff_id = sales_staff.id
				AND sales_staff.type = 'mct'
				AND sales_staff.user_id = $merchant_id
				AND porder.id
				NOT IN (
					SELECT cs_payment_detail.order_id
					FROM cs_payment, cs_payment_detail
					WHERE cs_payment.user_id = sales_staff.user_id
					AND cs_payment.role_id = ". $merchant_role ."
					AND cs_payment.id = cs_payment_detail.cs_payment_id
					AND cs_payment_detail.order_id = porder.id)
				");
			}

			foreach($orders as $order)
			{
				$cs_det_pay = DB::table('cs_payment_detail')->insertGetId([
					'order_id'=>$order->id,
					'cs_payment_id'=>$cs_pay,
					'created_at'=>date("Y-m-d H:i:s"),
					'deleted_at'=>date("Y-m-d H:i:s")
				]);

//				$audit_cs_det_pay = DB::table('audit_cs_payment_detail')->insertGetId([
//					'cs_id'=>$cs_det_pay,
//					'order_id'=>$orders[$iw]->id,
//					'cs_payment_id'=>$cs_pay,
//					'created_at'=>date("Y-m-d H:i:s"),
//					'deleted_at'=>date("Y-m-d H:i:s")
//				]);

			}

			return true;
		}
	}

	public function paymentdelete(Request $request){
		$requests = Request::all();
		$user_id=$requests['user_id'];
		$role_id=$requests['role_id'];

		$awaitings = DB::table('cs_payment')->where('user_id',$user_id)->where('role_id',$role_id)->where('status','awaiting')->get();
		foreach($awaitings as $awaiting){
			DB::table('cs_payment_detail')->where('cs_payment_id',$awaiting->id)->delete();
		}
		DB::table('cs_payment')->where('user_id',$user_id)->where('role_id',$role_id)->where('status','awaiting')->delete();
		DB::table('audit_cs_payment')->where('user_id',$user_id)->where('role_id',$role_id)->where('status','awaiting')->update(['status'=>'cancelled']);
		$pendings = DB::table('cs_payment')->where('user_id',$user_id)->where('role_id',$role_id)->where('status','pending')->get();
		foreach($pendings as $pending){
			DB::table('cs_payment_detail')->where('cs_payment_id',$pending->id)->delete();
		}		
		DB::table('cs_payment')->where('user_id',$user_id)->where('role_id',$role_id)->where('status','pending')->delete();
		DB::table('audit_cs_payment')->where('user_id',$user_id)->where('role_id',$role_id)->where('status','pending')->update(['status'=>'cancelled']);
		return json_encode("OK");
	}	
	
	public function paymentconfirm(Request $request){
		$requests = Request::all();
		$user_id=$requests['user_id'];
		$role_id=$requests['role_id'];
		DB::table('cs_payment')->where('user_id',$user_id)->where('role_id',$role_id)->where('status','awaiting')->update(['status'=>'executed','date_confirm'=>date('Y-m-d')]);
		return json_encode("OK");
	}	
	
	public function paymentfiledownload(Request $request){
		$requests = Request::all();
		$users=explode(",",$requests['users']);
		$total_amount=0;
		for($jj = 0; $jj < count($users); $jj++){
			$arr = explode("_",$users[$jj]);
			$payments = DB::table('cs_payment')->where('user_id',$arr[0])->where('role_id',$arr[2])->where('status','pending')->get();
			foreach ($payments as $payment){
				$payment_orders = DB::select(DB::raw("SELECT payment.id FROM payment, cs_payment, cs_payment_detail, porder WHERE payment.id = porder.payment_id AND porder.id = cs_payment_detail.order_id AND cs_payment_detail.cs_payment_id = cs_payment.id AND cs_payment.id = " . $payment->id));
				foreach ($payment_orders as $payment_order){
					if($arr[2] == 3){
						DB::table('payment')->where('id',$payment_order->id)->update(['merchant'=>true]);
					}
					if($arr[2] == 11){
						DB::table('payment')->where('id',$payment_order->id)->update(['station'=>true]);
					}
				}
			}
			$payments = DB::table('cs_payment')->where('user_id',$arr[0])->where('role_id',$arr[2])->where('status','pending')->delete();
			DB::table('audit_cs_payment')->where('user_id',$arr[0])->where('role_id',$arr[2])->where('status','pending')->update(['status'=>'executed']);
		}
		return json_encode("OK");
	}
	
	public function paymentfile(Request $request)
    {
		$requests = Request::all();
		$users=explode(",",$requests['users']);
		$total_amount=0;
		for($jj = 0; $jj < count($users); $jj++){
			$arr = explode("_",$users[$jj]);
			$total_amount += $arr[1];
		}
		$success = true;
        $saved = false;

        $ocbcHeader = new OcbcHeader;
        $ocbcTrailer = new OcbcTrailer;
        $ocbcTrailer->record_type = '03';
        $ocbcTrailer->total_count = str_pad(count($users), 6, '0', STR_PAD_LEFT);
        $ocbcTrailer->total_amount = str_pad($total_amount, 19, '0', STR_PAD_LEFT);
        $ocbcTrailer->filler1 = str_pad(' ', 255, ' ', STR_PAD_LEFT);
        $ocbcTrailer->filler2 = str_pad(' ', 198, ' ', STR_PAD_LEFT);	
        if($ocbcTrailer->save()){
            $now = \Carbon\Carbon::now()->toDateString();
            $date = \Carbon\Carbon::parse($now)->format('dmY');

            $ocbcHeader->ocbc_trailer_id = $ocbcTrailer->id;
            $ocbcHeader->record_type = '01';
            $ocbcHeader->tape_id = '002';
            $ocbcHeader->branch = '00790';
            $ocbcHeader->company_cif = str_pad('A999999', 20, ' ', STR_PAD_RIGHT);
            $ocbcHeader->company_name = str_pad('Intermedius OpenSupermall', 30, ' ', STR_PAD_RIGHT);
            $ocbcHeader->company_ac_no = str_pad('7901062119', 20, '0', STR_PAD_LEFT);
            $ocbcHeader->instruction = 'D';
            $ocbcHeader->reversal_indicator = 'N';
            $ocbcHeader->crediting_date = $date;
            $ocbcHeader->filler1 = str_pad(' ', 40, ' ', STR_PAD_RIGHT);
            $ocbcHeader->customer_ref_no = str_pad(' ', 16, ' ', STR_PAD_RIGHT);
            $ocbcHeader->filler2 = str_pad(' ', 255, ' ', STR_PAD_RIGHT);
            $ocbcHeader->filler3 = str_pad(' ', 79, ' ', STR_PAD_RIGHT);
			if($ocbcHeader->save()){
				for($jj = 0; $jj < count($users); $jj++){
					$arr = explode("_",$users[$jj]);
                    $user = User::where('id',$arr[0])->first();
                    $merchant = Merchant::where('user_id',$arr[0])->first();
                    $station = Station::where('user_id',$arr[0])->first();
                    $buyer = DB::table('buyer')->where('user_id',$arr[0])->first();		
					if(!is_null($station) || !is_null($merchant) || !is_null($buyer)){
						if(!is_null($merchant)){
							$bankaccount = DB::table('bankaccount')->where('id',$merchant->bankaccount_id)->first();
						} else {
							if(!is_null($station)){
								$bankaccount = DB::table('bankaccount')->where('id',$station->bankaccount_id)->first();
							} else {
								if(!is_null($buyer)){
									$bankaccount = DB::table('bankaccount')->where('id',$buyer->bankaccount_id)->first();
								}								
							}					
						}
				
						if(isset($bankaccount)){
							$account_number = null;
							$pay_amount = round($arr[1]/100, 2);
							/*if(isset($xamount[1])){
								$pay_amount = $xamount[0].$xamount[1];
							}else{
								$pay_amount = $xamount[0];
							}*/
							if(isset($bankaccount->account_number1)){
								$account_number = $bankaccount->account_number1;
							}elseif(isset($bankaccount->account_number2)){
								$account_number = $bankaccount->account_number2;
							}else{
								$account_number = null;
							}
							$bank_id = $bankaccount->bank_id;
							$bank = DB::table('bank')->where('id',$bank_id)->first();	
							if(isset($bank)){
								$ocbcDetail = new OcbcDetail;
								$ocbcDetail->ocbc_header_id = $ocbcHeader->id;
								$ocbcDetail->record_type = '02';
								$ocbcDetail->account_number = str_pad($account_number, 20, ' ', STR_PAD_RIGHT);
								$ocbcDetail->amount = str_pad($pay_amount, 17, '0', STR_PAD_LEFT);
								$ocbcDetail->instruction = 'C';
								$ocbcDetail->new_ic_number = str_pad($user->nric, 12, ' ', STR_PAD_RIGHT);
								if(!is_null($merchant)){
									$ocbcDetail->txn_description = str_pad($merchant->company_name, 20, ' ', STR_PAD_RIGHT);
									$ocbcDetail->business_registration_no = str_pad($merchant->business_reg_no, 20, ' ', STR_PAD_RIGHT);
								} else {
									if(!is_null($station)){
										$ocbcDetail->txn_description = str_pad($station->company_name, 20, ' ', STR_PAD_RIGHT);
										$ocbcDetail->business_registration_no = str_pad($station->business_reg_no, 20, ' ', STR_PAD_RIGHT);										
									} else {
										$ocbcDetail->txn_description = str_pad($buyer->company_name, 20, ' ', STR_PAD_RIGHT);
										$ocbcDetail->business_registration_no = str_pad($buyer->company_reg_no, 20, ' ', STR_PAD_RIGHT);	
									}
								}
								
								$ref = $arr[0].';'.$pay_amount;
								$ocbcDetail->reference_number = str_pad($ref, 20, ' ', STR_PAD_RIGHT);
								$ocbcDetail->receiving_fi_id = $bank->routing_id;
								$ocbcDetail->beneficiary_name = str_pad($user->first_name.' '.$user->last_name, 22, ' ', STR_PAD_RIGHT);
								$ocbcDetail->passport_no = str_pad(' ', 20, ' ', STR_PAD_RIGHT);
								$ocbcDetail->send_advice_via = 'E';
								$ocbcDetail->email = str_pad($user->email, 50, ' ', STR_PAD_RIGHT);
								$ocbcDetail->fax_no = str_pad(' ', 24, ' ', STR_PAD_RIGHT);
								$ocbcDetail->require_id_check = 'N';
								$ocbcDetail->filler = str_pad('', 233, ' ', STR_PAD_RIGHT);

								if($ocbcDetail->save()){
									$ocbcInv = new OcbcInv;
									$ocbcInv->ocbc_detail_id = $ocbcDetail->id;
									$ocbcInv->record_type = 21;
									$ocbcInv->invoice_details = $arr[0].';'.$pay_amount;
									$ocbcInv->save();
								}
                             }else{
								$success = false;
								$print= "bank_id not found\n";
                             }							
						} else {
							$success = false;
							$print= "missing bankccount_id\n";
						}									
					} else {
						$success = false;
                        $print= "missing station_id or merchant_id or buyer_id\n";
					}					
					//$total_amount += $arr[1];
				}					
			} else {
				$success = false;
				$print= "Unexpected error";			
			}
		} else {
			$success = false;
			$print= "Unexpected error";			
		}
		// dump($success);
		// dump($print);
        if($success)
        {

            $id = $ocbcHeader->id;
            $header =   OcbcHeader::find($id);
            $filename = 'text-'.$id.'.txt';
            $path = str_replace('\\', '/',base_path() . '/public/text/'.$filename);
			$filetxt = "";
            /* Set session sql_mode */
            $padsql = "SET sql_mode = 'PAD_CHAR_TO_FULL_LENGTH'";
            DB::connection('mysql')->statement($padsql);


            /* Generate Header */
            $sql1 = "id, CONCAT(record_type,tape_id,branch,company_cif,".
                "company_name,company_ac_no,instruction,reversal_indicator,".
                "crediting_date,customer_ref_no,filler1,filler2,filler3) as 'header'";

            $res1 = OcbcHeader::select(DB::raw($sql1))->where('id', '=', $id)->first();

            // echo "<pre>".$res1->header."</pre>\n";
            File::put($path, $res1->header."\n");
			$filetxt .= $res1->header."\n";

            /* Generate Details */
            $sql2 = "id, CONCAT(record_type,account_number,amount,instruction,".
                "new_ic_number,old_ic_no,txn_description,".
                "business_registration_no,reference_number,receiving_fi_id,".
                "beneficiary_name,passport_no,send_advice_via,email,fax_no,".
                "require_id_check,filler) as 'detail'";

            $res2 = OcbcDetail::select(DB::raw($sql2))->
            where('ocbc_header_id', '=', $res1->id)->get();
            // dump($res2);
            foreach ($res2 as $detail) {
                //echo "<pre>".$detail->detail."</pre>\n";
                File::append($path, $detail->detail."\n");
				$filetxt .= $detail->detail."\n";
                $sql3 = "CONCAT(record_type,invoice_details) as 'inv'";
                $res3 = OcbcInv::select(DB::raw($sql3))->where('ocbc_detail_id', $detail->id)->get();

                foreach ($res3 as $invoice) {

                    /* For each Detail, generate the Invoice */
                    // echo "<pre>".$invoice->inv."</pre>\n";
                    File::append($path, $invoice->inv."\n");
					$filetxt .= $invoice->inv."\n";
                }
            }

            $sql4 = "CONCAT(record_type,total_count,total_amount,filler1,"."filler2) as 'trailer'";
            $res4 = OcbcTrailer::select(DB::raw($sql4))->where('id', '=', $res1->id)->first();

            //echo "<pre>".$res4->trailer."</pre>\n";

            File::append($path, $res4->trailer."\n");
			$filetxt .= $res4->trailer."\n";
            if(file_exists($path)){
                try{
                    $exec_path = str_replace('\\', '/',app_path().'/ocbc_return/');
                    if(exec("unix2dos $exec_path", $out) != 0){
                        echo "unix2dos: Error: $out[0]<br>";
						return false;
                    }

                }catch(Exceptions $e){
                    throw new CustomException($e->getMessage());
                }

                Storage::disk('local')->put($filename,  File::get($path));
				$folder = base_path() . '/public/text/';
                $saved = true;
				$pfile_id = DB::table('pfile')->insertGetId(['path'=>"http://".$_SERVER['HTTP_HOST']."/text/".$filename,'gzipped_pfile'=>$filetxt,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				for($jj = 0; $jj < count($users); $jj++){
					$arr = explode("_",$users[$jj]);
					$cs_payments = DB::table('cs_payment')->where('user_id',$arr[0])->where('role_id',$arr[2])->where('status','pending')->get();
					if(!is_null($cs_payments)){
						foreach($cs_payments as $cs_payment){
							DB::table('audit_cs_payment')->where('cs_id',$cs_payment->id)->update(['pfile_id'=>$pfile_id,'updated_at'=>date('Y-m-d H:i:s')]);
						}
					}
				}
				return json_encode("<a href='http://".$_SERVER['HTTP_HOST']."/text/".$filename."' download>Download File</a>");

            }else{
                $print= "file not found\n";
				return false;
            }
        } else {
			return false;
		}		
	}
	
	public function get_logistic_view()
	{
		$logistics = $this->get_logistic();
		// dump($logistics);
		$global = DB::table('global')->first();
		return view('logistic_payment',['logistics'=> $logistics,'global'=> $global]);
	}
	
	public function get_merchant_view()
	{
		// dd($this->get_stations());
		// $stations= $this->check_payment_received($this->get_stations(),11);
			//dd($station); zxcv
		$stations=array();
		$merchants= $this->check_payment_received($this->get_merchant(), 3);
		//dd($merchants);
		$global = DB::table('global')->first();
		return view('merchant_payment',['merchants'=> $merchants,'stations'=> $stations,'global'=> $global]);
	}

	public function get_logistic_single($logistic_ID)
	{
		$payment=[];
		$global=Globals::first();
		$logistics = DB::select(DB::raw("
			SELECT c.code as currency,
			m.id as station_id,
			m.user_id as user_id,
			m.company_name as company,
			SUM(op.actual_delivery_price) as net_payable, 
			m.mc_sales_staff_id as mc_id,
			m.mc_sales_staff_commission as mc_commission,
			m.referral_sales_staff_id as referral_id,
			m.referral_sales_staff_commission as referral_commission,
					m.mcp1_sales_staff_id as mcp1_id,
					SUM(op.log_comm_amount) as logistic_commission,
					m.mcp1_sales_staff_commission as mcp1_commission,
					m.mcp2_sales_staff_id as mcp2_id,
					m.mcp2_sales_staff_commission as mcp2_commission,
					m.commission_type as commission_type,
					m.osmall_commission as osmall_commission,
					m.b2b_commission_type as b2b_commission_type,
					m.b2b_osmall_commission as b2b_osmall_commission,
					l.id as logistic_id,
					co.company_name, po.id as poid,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv,
					UPPER(po.source) as source ,
					po.log_comm_percent as log_percent
					FROM 
					logistic l,
					company co,
					station m,
					delivery d,
					payment p,
					porder po,
					orderproduct op,
					product pro,
					currency c WHERE c.active = 1 and p.id = po.payment_id 
					 AND po.status IN (".$this->cStatus.") AND d.porder_id = po.id AND l.id = ".$logistic_ID." AND l.id = d.logistic_id AND m.id = l.station_id AND co.id = l.company_id
					 and op.porder_id = po.id and op.product_id = pro.id AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id 
					 AND cs_payment.role_id = 13 AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY po.id ORDER BY p.created_at DESC"));
		// dump($logistics);
					 $payable = 0;
					 foreach ($logistics as $merchant) {								
						$merchant->payable = $merchant->net_payable-$merchant->logistic_commission;								
													
						
						$merchant->diff =  $merchant->logistic_commission;									
					 }
		$logis =  DB::table('logistic')->where('id',$logistic_ID)->first();
		return view('logistic_payment_details', ['logistics'=> $logistics,'logis'=> $logis,'logistic_id'=> $logistic_ID,"globals"=>$global]);		 
	}
	
	public function get_merchant_single($merchant_ID)
	{
		$payment=[];
		$merchant_details=Merchant::find($merchant_ID);
		$global=Globals::first();
		// dd($globals, DB::table('orderproduct')->first());
		if ($merchant_details) {
			// $merchants = DB::select(DB::raw("SELECT c.code as currency, po.id as poid,m.id as mid,m.user_id as user_id, m.company_name as company, m.oshop_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$globals->osmall_commission."),-1) as commission_sv,
			// 		SUM(IF(m.commission_type = 'std',IF(m.osmall_commission > 0, op.order_price * op.quantity * ((100 - m.osmall_commission)/100), op.order_price * op.quantity * ((100 - ".$globals->osmall_commission.")/100)),
			// 		IF(pro.osmall_commission > 0,op.order_price * op.quantity * ((100 - pro.osmall_commission)/100),
			// 		IF(m.osmall_commission > 0, op.order_price * op.quantity * ((100 - m.osmall_commission)/100), op.order_price * op.quantity * ((100 - 10)/100))))) 
			// 		m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
			// 		m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission,
			// 		DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM merchant m, payment p, porder po, orderproduct op, product pro, merchantproduct mp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.merchant_id and pro.id = mp.product_id and op.porder_id = po.id and op.product_id = pro.id AND m.id = ".$merchant_ID." AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 3 AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY po.id ORDER BY p.created_at DESC"));

			$merchants = DB::select(DB::raw("SELECT c.code as currency, po.id as poid,m.id as mid,m.user_id as user_id, m.company_name as company, m.oshop_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, SUM((op.order_price * op.quantity)) as net_payable, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission, m.commission_type as commission_type, m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, m.b2b_osmall_commission as b2b_osmall_commission, po.order_administration_fee,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM merchant m, payment p, porder po, orderproduct op, product pro, merchantproduct mp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.merchant_id and pro.id = mp.product_id and op.porder_id = po.id and op.product_id = pro.id AND m.id = ".$merchant_ID." 
						AND po.status IN (".$this->cStatus.")
						AND po.id NOT IN (SELECT sorder.porder_id FROM sorder WHERE sorder.porder_id = po.id) AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 3 AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY po.id ORDER BY p.created_at DESC"));
					 
					 foreach ($merchants as $merchant) {
						$mpayable = 0;
						$payable = 0;
						$commission_total = 0;
						 $log_commission_total = 0;
						 $corderp =0;
						 $delivery_total =0;
						$orderps = DB::select(DB::raw("SELECT c.code as currency, po.id as poid,m.id as mid,m.user_id as user_id, m.company_name as company, m.oshop_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, op.order_price as order_price, op.quantity as quantity, op.actual_delivery_price as actual_delivery_price, ((op.order_price * op.quantity)) as net_payable, 
						m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission, op.osmall_comm_amount, op.log_comm_amount,
						m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, pro.segment as segment, pro.osmall_commission as osmall_commission, pro.b2b_osmall_commission as b2b_osmall_commission,
						DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM merchant m, payment p, porder po, orderproduct op, product pro, merchantproduct mp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.merchant_id and pro.id = mp.product_id and op.porder_id = po.id and op.product_id = pro.id AND po.status IN (".$this->cStatus.") AND po.id = ".$merchant->poid." AND po.id NOT IN (SELECT sorder.porder_id FROM sorder WHERE sorder.porder_id = po.id) AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 3 AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY op.id ORDER BY p.created_at DESC"));
						if($merchant->commission_type != "std" && $merchant->commission_type != "var" ){
							$commission_type=$global->commission_type;
						} else {
							$commission_type=$merchant->commission_type;
						}					
						if($merchant->b2b_commission_type != "std" && $merchant->b2b_commission_type != "var" ){
							$b2b_commission_type=$global->b2b_commission_type;
						} else {
							$b2b_commission_type=$merchant->b2b_commission_type;
						}						
						$mc_pay = 0;
						if($merchant->mc_id > 0){
							if($merchant->mc_commission > 0){
								$mc_pay = $merchant->mc_commission;
							} else {
								$mc_pay = $global->mc_sales_staff_commission;
							}
						}
						$referral_pay = 0;
						if($merchant->referral_id > 0){
							if($merchant->referral_commission > 0){
								$referral_pay = $merchant->referral_commission;
							} else {
								$referral_pay = $global->referral_sales_staff_commission;
							}
						}
						$mcp1_pay = 0;
						if($merchant->mcp1_id > 0){
							if($merchant->mcp1_commission > 0){
								$mcp1_pay = $merchant->mcp1_commission;
							} else {
								$mcp1_pay = $global->mcp1_sales_staff_commission;
							}
						}															
						$mcp2_pay = 0;
						if($merchant->mcp2_id > 0){
							if($merchant->mcp2_commission > 0){
								$mcp2_pay = $merchant->mcp2_commission;
							} else {
								$mcp2_pay = $global->mcp2_sales_staff_commission;
							}
						}		
						$gateway_pay = $global->payment_gateway_commission;
						$logistic_pay = $global->logistic_commission;
						foreach ($orderps as $orderp) {
							$commission = 0;
							if($orderp->segment == 'b2b'){
								if($b2b_commission_type == 'std'){
									if($merchant->b2b_osmall_commission == null || is_null($merchant->b2b_osmall_commission) || $merchant->b2b_osmall_commission == "null" || $merchant->b2b_osmall_commission == "" || $merchant->b2b_osmall_commission == 0){
										$commission = $global->b2b_osmall_commission;
									} else {
										$commission = $merchant->b2b_osmall_commission;
									}
								} else {
									if($orderp->b2b_osmall_commission == null || is_null($orderp->b2b_osmall_commission) || $orderp->b2b_osmall_commission == "null" || $orderp->b2b_osmall_commission == "" || $orderp->b2b_osmall_commission == 0){
										if($merchant->b2b_osmall_commission == null || is_null($merchant->b2b_osmall_commission) || $merchant->b2b_osmall_commission == "null" || $merchant->b2b_osmall_commission == "" || $merchant->b2b_osmall_commission == 0){
											$commission = $global->b2b_osmall_commission;
										} else {
											$commission = $merchant->b2b_osmall_commission;
										}
									 } else {
										 $commission = $orderp->b2b_osmall_commission;
									 }
								}
							} else {
								if($commission_type == 'std'){
									if($merchant->osmall_commission == null || is_null($merchant->osmall_commission) || $merchant->osmall_commission == "null" || $merchant->osmall_commission == "" || $merchant->osmall_commission == 0){
										$commission = $global->osmall_commission;
									} else {
										$commission = $merchant->osmall_commission;
									}
								} else {
									if($orderp->osmall_commission == null || is_null($orderp->osmall_commission) || $orderp->osmall_commission == "null" || $orderp->osmall_commission == "" || $orderp->osmall_commission == 0){
										if($merchant->osmall_commission == null || is_null($merchant->osmall_commission) || $merchant->osmall_commission == "null" || $merchant->osmall_commission == "" || $merchant->osmall_commission == 0){
											$commission = $global->osmall_commission;
										} else {
											$commission = $merchant->osmall_commission;
										}
									 } else {
										 $commission = $orderp->osmall_commission;
									 }
								}								
							}
							$commission = $orderp->osmall_comm_amount;
							$commission_total += $commission;
							$log_commission_total += $orderp->log_comm_amount;
							$delivery_total += $orderp->actual_delivery_price;
							$corderp++;
							$mipayable = ($orderp->order_price * $orderp->quantity);					
							$mpayable += $mipayable;	
							$npayable = (($orderp->order_price * $orderp->quantity * ((100 - ($commission/100))/100))) -
								($gateway_pay/100)*$merchant->net_payable;
							
							$payable += $npayable;								
						}
						//dump($delivery_total);
						$merchant->real_commission = ($commission_total/100)/$corderp;						
						$merchant->real_logistic_commission = ($log_commission_total/100)/$corderp;						
						$merchant->mpayable = $mpayable;						
						$merchant->payable = $payable;								
						$merchant->delivery_total = $delivery_total;		
						
					 }					
			
					 
			return view('merchant_payment_details', ['merchants'=> $merchants,'merchant_id'=> $merchant_ID,"globals"=>$global]);	
		}else{
			return "Unauthorized Access";
		}
		
	}

	public function get_station_single($station_id)
	{
		$payment=[];
		$station_details=Station::find($station_id);
		$global=Globals::first();
		if ($station_details) {
			$stations=DB::select(DB::raw("SELECT c.code as currency, po.id as poid, m.id as mid,m.user_id as user_id, m.company_name as company, m.station_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, SUM((op.order_price * op.quantity) + op.actual_delivery_price) as net_payable, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, m.commission_type as commission_type, m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, m.b2b_osmall_commission as b2b_osmall_commission,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM station m, payment p, porder po, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id AND m.id = ".$station_id."
					and op.product_id = pro.id AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 11
					AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY po.id ORDER BY p.created_at DESC"));
					
					 foreach ($stations as $merchant) {
						$mpayable = 0;
					$payable = 0;
						$orderps = DB::select(DB::raw("SELECT c.code as currency, op.id as opid,po.id as poid, m.id as mid,m.user_id as user_id, m.company_name as company, op.order_price as order_price, op.quantity as quantity, op.actual_delivery_price as actual_delivery_price,m.station_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission, pro.segment as segment, pro.osmall_commission as osmall_commission, pro.b2b_osmall_commission as b2b_osmall_commission,op.osmall_comm_amount, op.log_comm_amount,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, m.commission_type as commission_type, m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, m.b2b_osmall_commission as b2b_osmall_commission,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source, p.id as paid, so.id as soid, c.id as cid, mp.id mpid, sp.id as spid, mp.fair_commission as fair_commission FROM station m, payment p, porder po, sorder so, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c WHERE c.active = 1 AND po.status IN (".$this->cStatus.") and p.id = po.payment_id and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id AND po.id = ".$merchant->poid." AND so.porder_id = po.id AND mp.station_id = ".$merchant->mid."
					and op.product_id = pro.id AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 11
					AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) ORDER BY p.created_at DESC"));

						if($merchant->commission_type != "std" && $merchant->commission_type != "var" ){
							$commission_type=$global->commission_type;
						} else {
							$commission_type=$merchant->commission_type;
						}					
						if($merchant->b2b_commission_type != "std" && $merchant->b2b_commission_type != "var" ){
							$b2b_commission_type=$global->b2b_commission_type;
						} else {
							$b2b_commission_type=$merchant->b2b_commission_type;
						}						
						$mc_pay = 0;
						if($merchant->mc_id > 0){
							if($merchant->mc_commission > 0){
								$mc_pay = $merchant->mc_commission;
							} else {
								$mc_pay = $global->mc_sales_staff_commission;
							}
						}
						$referral_pay = 0;
						if($merchant->referral_id > 0){
							if($merchant->referral_commission > 0){
								$referral_pay = $merchant->referral_commission;
							} else {
								$referral_pay = $global->referral_sales_staff_commission;
							}
						}
						$mcp1_pay = 0;
						if($merchant->mcp1_id > 0){
							if($merchant->mcp1_commission > 0){
								$mcp1_pay = $merchant->mcp1_commission;
							} else {
								$mcp1_pay = $global->mcp1_sales_staff_commission;
							}
						}															
						$mcp2_pay = 0;
						if($merchant->mcp2_id > 0){
							if($merchant->mcp2_commission > 0){
								$mcp2_pay = $merchant->mcp2_commission;
							} else {
								$mcp2_pay = $global->mcp2_sales_staff_commission;
							}
						}		
						$gateway_pay = $global->payment_gateway_commission;
						$logistic_pay = $global->logistic_commission;
						foreach ($orderps as $orderp) {
							$commission = 0;
							if($orderp->segment == 'b2b'){
								if($b2b_commission_type == 'std'){
									if($merchant->b2b_osmall_commission == null || is_null($merchant->b2b_osmall_commission) || $merchant->b2b_osmall_commission == "null" || $merchant->b2b_osmall_commission == "" || $merchant->b2b_osmall_commission == 0){
										$commission = $global->b2b_osmall_commission;
									} else {
										$commission = $merchant->b2b_osmall_commission;
									}
								} else {
									if($orderp->b2b_osmall_commission == null || is_null($orderp->b2b_osmall_commission) || $orderp->b2b_osmall_commission == "null" || $orderp->b2b_osmall_commission == "" || $orderp->b2b_osmall_commission == 0){
										if($merchant->b2b_osmall_commission == null || is_null($merchant->b2b_osmall_commission) || $merchant->b2b_osmall_commission == "null" || $merchant->b2b_osmall_commission == "" || $merchant->b2b_osmall_commission == 0){
											$commission = $global->b2b_osmall_commission;
										} else {
											$commission = $merchant->b2b_osmall_commission;
										}
									 } else {
										 $commission = $orderp->b2b_osmall_commission;
									 }
								}
							} else {
								if($commission_type == 'std'){
									if($orderp->fair_commission == null || is_null($orderp->fair_commission) || $orderp->fair_commission == "null" || $orderp->fair_commission == "" || $orderp->fair_commission == 0){
										if($merchant->osmall_commission == null || is_null($merchant->osmall_commission) || $merchant->osmall_commission == "null" || $merchant->osmall_commission == "" || $merchant->osmall_commission == 0){
											$commission = $global->osmall_commission;
										} else {
											$commission = $merchant->osmall_commission;
										}
									} else {
										$commission = $orderp->fair_commission;
									}	
								} else {
									if($orderp->fair_commission == null || is_null($orderp->fair_commission) || $orderp->fair_commission == "null" || $orderp->fair_commission == "" || $orderp->fair_commission == 0){
										if($orderp->osmall_commission == null || is_null($orderp->osmall_commission) || $orderp->osmall_commission == "null" || $orderp->osmall_commission == "" || $orderp->osmall_commission == 0){
											if($merchant->osmall_commission == null || is_null($merchant->osmall_commission) || $merchant->osmall_commission == "null" || $merchant->osmall_commission == "" || $merchant->osmall_commission == 0){
												$commission = $global->osmall_commission;
											} else {
												$commission = $merchant->osmall_commission;
											}
										 } else {
											 $commission = $orderp->osmall_commission;
										 }
									} else {
										$commission = $orderp->fair_commission; 
									}	 
								}								
							}
							$commission = $orderp->osmall_comm_amount;
							$mipayable = (($orderp->order_price * $orderp->quantity * ((100 - $commission)/100)) + ($orderp->actual_delivery_price));
							
							$mpayable += $mipayable;	
							$npayable = (($orderp->order_price * $orderp->quantity * ((100 - $commission)/100)) + ($orderp->actual_delivery_price * ((100 - ($orderp->log_comm_amount/100) )/100))) -
								((($mc_pay/100)*$merchant->net_payable) +
								(($mcp1_pay/100)*$merchant->net_payable) +
								(($referral_pay/100)*$merchant->net_payable) +
								(($mcp2_pay/100)*$merchant->net_payable) +
								(($gateway_pay/100)*$merchant->net_payable));

							$payable += $npayable;															
						}
						$merchant->mpayable = $mpayable;
						
						$merchant->payable = $payable;	
					 }								
			return view('station_payment_details', ['stations'=> $stations,'station_id'=> $station_id,"globals"=>$global]);	
		}else{
			return "Unauthorized Access";
		}
		
	}

	private function reverse_consolidation($user_id, $role_id){

		$awaitings = DB::table('cs_payment')
			->where('user_id',$user_id)
			->where('role_id',$role_id)
			->where('status','awaiting')->get();

		foreach($awaitings as $awaiting){
			DB::table('cs_payment_detail')
				->where('cs_payment_id',$awaiting->id)->delete();
		}

		DB::table('cs_payment')
			->where('user_id',$user_id)
			->where('role_id',$role_id)
			->where('status','awaiting')->delete();

		DB::table('audit_cs_payment')
			->where('user_id',$user_id)
			->where('role_id',$role_id)
			->where('status','awaiting')
			->update(['status'=>'cancelled']);

		$pendings = DB::table('cs_payment')
			->where('user_id',$user_id)
			->where('role_id',$role_id)
			->where('status','pending')->get();

		foreach($pendings as $pending){
			DB::table('cs_payment_detail')->
			where('cs_payment_id',$pending->id)->delete();
		}

		DB::table('cs_payment')
			->where('user_id',$user_id)
			->where('role_id',$role_id)
			->where('status','pending')->delete();
		DB::table('audit_cs_payment')
			->where('user_id',$user_id)
			->where('role_id',$role_id)
			->where('status','pending')
			->update(['status'=>'cancelled']
			);

	}

	/**
	 * [get_order_view of the USER (eg: merchant,smm,mc etc..)]
	 * @param  [integer] $id [USER id]
	 * @return [array]     [orders made by USER]
	 */
	public function get_order_view($id)
	{
		$orders = $this->get_order($id);
		return view('order_payment', compact('orders', $orders));
	}

	/**
	 * [get_product_view for the ORDER]
	 * @param  [integer] $id [ORDER id]
	 * @return [array]     [products under an ORDER]
	 */
	public function get_product_view($id)
	{
		$products = $this->get_product($id);
		return view('product_payment', compact('products', $products));
	}

	/**
	 * [payment view of smm]
	 * @return [array] [it will return all smms and redirect to smm_payment view]
	 */
	public function get_smm_view()
	{
		$smm_arrays = $this->get_smm();

		$smms = is_array($smm_arrays[0]) && !empty($smm_arrays[0]) ? $smm_arrays[0] : null;
		$ytd = is_array($smm_arrays[1]) && !empty($smm_arrays[1]) ? $smm_arrays[1] : null;

		return view('smm_payment', compact('smms', $smms, 'ytd', $ytd));
	}

	/**
	 * [get_smm_detail_view of smm]
	 * @param  [integer] $id [smm id]
	 * @return [array]     [smm details of a smm]
	 */
	public function get_smm_details_view($id)
	{
		$smm_details = $this->get_smm_details($id);

		$smmdetails = $smm_details[0];
		$smm_viewers = $smm_details[1];
		$smm_item_sold = $smm_details[2];
		$smm_bought = $smm_details[3];
		$smm_last_share = $smm_details[4];

		return view('smm_detail', compact('smmdetails', $smmdetails, 'smm_viewers', $smm_viewers, 'smm_item_sold', $smm_item_sold, 'smm_bought', $smm_bought, 'smm_last_share', $smm_last_share));
	}

	/**
	 * [payment view of employee]
	 * @return [array] [it will return all employees and redirect to employee_payment view]
	 */
	public function get_employee_view()
	{
		$employees = $this->get_employee();
		return view('employee_payment', compact('employees', $employees));
	}
	
	public function get_employee_view_details($id)
	{
		$employees = $this->get_employee_details($id);
		//dd($employees);
		return view('employee_paymentdetails', compact('employees', $employees));
	}

    public function get_payment_logistics()
    {
        $employees = $this->get_employee();
        return view('payment/logistics', compact('employees', $employees));
    }


	/**
	 * [payment view of mc]
	 * @return [array] [it will return all mcs and redirect to mc_payment view]
	 */
	public function get_mc_view()
	{
		$merchant_consultant = $this->get_merchant_consultant();
	
		
         // return $sr_arrays;
		return view('admin.payment.mc', compact('merchant_consultant', $merchant_consultant));
	}
	
	private function get_merchant_consultant(){
		try {
			if(!$global = DB::table('global')->first()) return; //A fix to avoid Trying to get property of non-object error ss.*,
// m.id as merchant_id,
			$merchant_consultant = DB::select(
				"SELECT u.id as mc_user_id, ss.type as ss_type, CONCAT(u.first_name, ' ', u.last_name) as mc_name,
				m.mc_sales_staff_commission as merchant_mc_sales_staff_commission, m.company_name as merchant_company_name,
				m.status as merchant_status, m.oshop_name as merchant_oshop_name,
				m.mc_sales_staff_id as merchant_mc_sales_staff_id, m.osmall_commission as merchant_osmall_commission,
				c.name as merchant_country_name,

				case
					when m.mc_sales_staff_commission > 0 then (m.mc_sales_staff_commission / 100) * sum(p.receivable)
					else
					 	case
					 		when m.referral_sales_staff_id >0 then ( {$global->mc_sales_staff_commission} / 100) * sum(p.receivable)
					 		*({$global->mc_with_ref_sales_staff_commission})
					 		else
					 		( {$global->mc_sales_staff_commission} / 100) * sum(p.receivable)
					 	end
				end as mc_receivable

				FROM sales_staff ss

				LEFT JOIN merchant m ON ss.id = m.mc_sales_staff_id
				LEFT JOIN users u ON u.id = ss.user_id
				LEFT JOIN country c ON m.country_id = c.id

				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id
				LEFT JOIN porder po ON po.id = op.porder_id
				LEFT JOIN payment p ON p.id = po.payment_id

				WHERE ss.type = 'mct'
				AND ss.user_id = u.id
				AND p.receivable <> 0
				AND po.id NOT IN (
					SELECT cs_payment_detail.order_id
					FROM cs_payment, cs_payment_detail
					WHERE cs_payment.user_id = ss.user_id
					AND cs_payment.role_id = 6
					AND cs_payment.id = cs_payment_detail.cs_payment_id
					AND cs_payment_detail.order_id = po.id
				)

				GROUP BY ss.id");

		} catch(QueryException $e){
		
			throw new CustomException($e->getMessage());
		}

		$merchant_consultant = is_array($merchant_consultant) && !empty($merchant_consultant) ? $merchant_consultant : null;
//		dd($merchant_consultant);
		return $merchant_consultant;
	}	
	
	public function get_mcdetail_view($user_id)
	{
		$mcdetails = $this->get_merchant_consultant_details($user_id);

         // return $sr_arrays;
		return view('admin.payment.mc_details', compact('mcdetails', $mcdetails));

	}
	
	private function get_merchant_consultant_details($user_id){
		try {
			if(!$global = DB::table('global')->first()) return; //A fix to avoid Trying to get property of non-object error

			$merchant_consultant = DB::select(DB::raw("SELECT ss.*,
			SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END) as revenue,
			p.id as orderid, (IF(ss.commission>0,
			ss.commission,IF(m.mc_sales_staff_commission > 0,m.mc_sales_staff_commission/100,".$global->mc_sales_staff_commission."))) as rate,
				m.id as merchant_id
				FROM sales_staff ss 
				JOIN users u ON u.id = ss.user_id AND ss.type = 'mct' 
				LEFT JOIN merchant m ON ss.id = m.mc_sales_staff_id
				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id 
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id
				LEFT JOIN porder p ON p.id = op.porder_id 
				LEFT JOIN commissionpaid cp ON p.id = cp.porder_id AND cp.user_id = u.id
				LEFT JOIN payment pa ON pa.id = p.payment_id 
				WHERE ss.user_id = " . $user_id . " 
				GROUP BY p.id"));
		} catch(QueryException $e){
			throw new CustomException($e->getMessage());
		}	
		
		$merchant_consultant = is_array($merchant_consultant) && !empty($merchant_consultant) ? $merchant_consultant : null;

		return $merchant_consultant;		
	}		
	
	public function get_mp_view()
	{
		$merchant_professional = $this->get_merchant_professional();
        // return $sr_arrays;
		return view('admin.payment.mp', compact('merchant_professional', $merchant_professional));
	}
	
	private function get_merchant_professional(){

		try {
			$global = DB::table('global')->first();
			$merchant_professional = DB::select(DB::raw("SELECT ss.*, CONCAT(u.first_name, ' ', u.last_name) as name,
				(IF(ss.commission>0,(ss.commission/100)*SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END),IF(m.mcp1_sales_staff_commission > 0,		(m.mcp1_sales_staff_commission/100)*SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END),(".$global->mcp1_sales_staff_commission."/100)*SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END)))) as receive
				FROM sales_staff ss
				JOIN users u ON u.id = ss.user_id AND ss.type = 'mcp'
				LEFT JOIN merchant m ON (ss.id = m.mcp1_sales_staff_id OR ss.id = m.mcp2_sales_staff_id)
				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id
				LEFT JOIN porder p ON p.id = op.porder_id
				LEFT JOIN commissionpaid cp ON p.id = cp.porder_id AND cp.user_id = u.id
				LEFT JOIN payment pa ON pa.id = p.payment_id
				GROUP BY ss.id"));
		} catch(QueryException $e){
			throw new CustomException($e->getMessage());
		}
		$merchant_professional = is_array($merchant_professional) && !empty($merchant_professional) ? $merchant_professional : null;
		return $merchant_professional;
	}

	public function get_mpdetail_view($user_id){
		$mpdetails = $this->get_merchant_professional_details($user_id);
		return view('admin.payment.mp_details', compact('mpdetails', $mpdetails));

	}
	
	private function get_merchant_professional_details($user_id){

		try {
			$global = DB::table('global')->first();
			$merchant_professional = DB::select(DB::raw("SELECT ss.*,
			 SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END) as revenue, p.id as orderid,
			 (IF(ss.commission>0,ss.commission,IF(m.mcp1_sales_staff_commission > 0,m.mcp1_sales_staff_commission/100,".$global->mcp1_sales_staff_commission."))) as rate,
				m.id as merchant_id
				FROM sales_staff ss 
				JOIN users u ON u.id = ss.user_id AND ss.type = 'mcp' 
				LEFT JOIN merchant m ON (ss.id = m.mcp1_sales_staff_id OR ss.id = m.mcp2_sales_staff_id) 
				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id 
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id 
				LEFT JOIN porder p ON p.id = op.porder_id 
				LEFT JOIN commissionpaid cp ON p.id = cp.porder_id AND cp.user_id = u.id
				LEFT JOIN payment pa ON pa.id = p.payment_id 
				WHERE ss.user_id = " . $user_id . " 
				GROUP BY p.id"));
		} catch(QueryException $e){
			throw new CustomException($e->getMessage());
		}

		$merchant_professional = is_array($merchant_professional) && !empty($merchant_professional) ? $merchant_professional : null;
		return $merchant_professional;		
	}	
	
	public function post_pay_pc()
	{
		$ss = Request::all();
		$type="pc";
		$user_payment = $this->userpayment->pay_pc($ss, $type);

		return Redirect::back();
	}		


	/**
	 * [pay to merchant]
	 */
	public function post_pay_merchant()
	{
		$merchants = Request::all();
		$type = 'merchant';
		// dd("l");
		if(isset($merchants['merchant_checked'])){
			$ii = 0;
			foreach($merchants['merchant_checked'] as $merchant){

				$merchantarr = explode("_" , $merchant);
				$merchant_id = $merchantarr[0]; 
				$merchant_payment = $merchantarr[1];
				$merchant_role = $merchantarr[2];
				$today_day = date('d');
				$today_month = date('m');
				$period_start = date('Y-m-');
				$period_end = date('Y-m-');
				if($today_day<=15){
					$period_start .= "01";
					$period_end .= "15";
				} else {
					$period_start .= "16";		
					if($today_month == 2){
						$period_end .= "28";
					} else if($today_month == 1 || $today_month == 3 || $today_month == 5 || $today_month == 7 || $today_month == 8 || $today_month == 10 || $today_month == 12){
						$period_end .= "31";
					} else {
						$period_end .= "30";
					}				
				}

				$cs_pay = DB::table('cs_payment')->insertGetId([
					'user_id'=>$merchant_id,
					'role_id'=>$merchant_role,
					'period_start'=>$period_start,
					'period_end'=>$period_end,
					'amount'=>$merchant_payment,
					'status'=>'pending',
					'created_at'=>date("Y-m-d H:i:s"),
					'updated_at'=>date("Y-m-d H:i:s")
				]);

				$audit_cs_pay = DB::table('audit_cs_payment')->insertGetId([
					'cs_id'=>$cs_pay,
					'user_id'=>$merchant_id,
					'role_id'=>$merchant_role,
					'period_start'=>$period_start,
					'period_end'=>$period_end,
					'amount'=>$merchant_payment,
					'status'=>'pending',
					'created_at'=>date("Y-m-d H:i:s"),
					'updated_at'=>date("Y-m-d H:i:s")
				]);

				if($merchant_role == 3){
					$orders = DB::select(DB::raw("
					SELECT porder.*
					FROM porder, orderproduct, merchantproduct, merchant
					WHERE porder.id = orderproduct.porder_id
					AND orderproduct.product_id = merchantproduct.product_id
					AND merchantproduct.merchant_id = merchant.id
					AND merchant.user_id = ".$merchant_id."
					AND porder.status IN (".$this->cStatus.")
					AND porder.id NOT IN (SELECT cs_payment_detail.order_id
										  FROM cs_payment, cs_payment_detail
										  WHERE cs_payment.user_id = merchant.user_id
										  AND cs_payment.role_id = ". $merchant_role ."
										  AND cs_payment.id = cs_payment_detail.cs_payment_id
										  AND cs_payment_detail.order_id = porder.id)"
					));
				}

				if($merchant_role == 11){
					$orders = DB::select(DB::raw("
					SELECT DISTINCT(porder.id) as id
					FROM porder, orderproduct, sproduct,stationsproduct, station
					WHERE porder.id = orderproduct.porder_id
					AND orderproduct.product_id = sproduct.product_id					
					AND sproduct.id = stationsproduct.sproduct_id
					AND stationsproduct.station_id = station.id
					AND station.user_id = ".$merchant_id."
					AND porder.status IN (".$this->cStatus.")
					AND porder.id NOT IN (SELECT cs_payment_detail.order_id
										  FROM cs_payment, cs_payment_detail
										  WHERE cs_payment.user_id = station.user_id
										  AND cs_payment.role_id = ". $merchant_role ."
										  AND cs_payment.id = cs_payment_detail.cs_payment_id
										  AND cs_payment_detail.order_id = porder.id)"
					));
				}
				if($merchant_role == 6){
					$orders = DB::select(DB::raw("SELECT porder.* FROM porder, orderproduct, merchantproduct, merchant, sales_staff WHERE porder.id = orderproduct.porder_id AND orderproduct.product_id = merchantproduct.product_id AND merchantproduct.merchant_id = merchant.id AND merchant.mc_sales_staff_id = sales_staff.id AND sales_staff.type = 'mct' AND sales_staff.user_id = ".$merchant_id." AND porder.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = sales_staff.user_id AND cs_payment.role_id = ". $merchant_role ." AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = porder.id)"));				
				}	
				if($merchant_role == 7){
					$orders = DB::select(DB::raw("SELECT porder.* FROM porder, orderproduct, merchantproduct, merchant, sales_staff WHERE porder.id = orderproduct.porder_id AND orderproduct.product_id = merchantproduct.product_id AND merchantproduct.merchant_id = merchant.id AND (merchant.mcp1_sales_staff_id = sales_staff.id OR merchant.mcp2_sales_staff_id = sales_staff.id) AND sales_staff.type = 'mcp' AND sales_staff.user_id = ".$merchant_id." AND porder.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = sales_staff.user_id AND cs_payment.role_id = ". $merchant_role ." AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = porder.id)"));				
				}	
				if($merchant_role == 10){
					$orders = DB::select(DB::raw("SELECT porder.* FROM porder, orderproduct, sproduct,stationsproduct, station, sales_staff WHERE porder.id = orderproduct.porder_id AND orderproduct.product_id = sproduct.product_id AND sproduct.id = stationsproduct.sproduct_id AND stationsproduct.station_id = station.id AND station.str_sales_staff_id = sales_staff.id AND sales_staff.user_id = ".$merchant_id." AND sales_staff.type = 'str' AND porder.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = sales_staff.user_id AND cs_payment.role_id = ". $merchant_role ." AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = porder.id)"));				
				}	
				if($merchant_role == 13){
					$orders = DB::select(DB::raw("SELECT po.* FROM logistic l, company co, station m, delivery d, payment p, porder po, orderproduct op, product pro, currency c WHERE c.active = 1 and p.id = po.payment_id 
					 AND po.status IN (".$this->cStatus.") AND d.porder_id = po.id AND m.user_id = ".$merchant_id." AND l.id = d.logistic_id AND m.id = l.station_id AND co.id = l.company_id
					 and op.porder_id = po.id and op.product_id = pro.id AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id 
					 AND cs_payment.role_id = 13 AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY po.id ORDER BY p.created_at DESC"));
				}
				$iw = 0;

				foreach($orders as $order)
				{
					$cs_det_pay = DB::table('cs_payment_detail')->insertGetId([
						'order_id'=>$orders[$iw]->id,
						'cs_payment_id'=>$cs_pay,
						'created_at'=>date("Y-m-d H:i:s"),
						'deleted_at'=>date("Y-m-d H:i:s")
					]);

					$audit_cs_det_pay = DB::table('audit_cs_payment_detail')->insertGetId([
						'cs_id'=>$cs_det_pay,
						'order_id'=>$orders[$iw]->id,
						'cs_payment_id'=>$cs_pay,
						'created_at'=>date("Y-m-d H:i:s"),
						'deleted_at'=>date("Y-m-d H:i:s")
					]);

					$iw++;
				}
			}
			//$user_payment = $this->userpayment->pay_user($users, $type);

					
		} else {
			
		}
		return Redirect::back();

	}

	public function pay_station_recruiter()
	{
		$users = Request::all();

		$type = 'user';
		$user_payment = $this->userpayment->pay_user($users, $type);

		return Redirect::back();
	}

	/**
	 * [pay to merchant by order]
	 */
	public function post_pay_order()
	{
		$users = Request::all();
		$type = 'order';
		$user_payment = $this->userpayment->pay_user($users, $type);

		return Redirect::back();
	}

	/**
	 * [pay to smm]
	 */
	public function post_pay_smm()
	{
		$users = Request::all();
		$type = 'smm';
		$user_payment = $this->userpayment->pay_user($users, $type);

		return Redirect::back();
	}

	/**
	 * [pay to employee]
	 */
	public function post_pay_employee()
	{
		$users = Request::all();
		$type = 'employee';

		$user_payment = $this->userpayment->pay_user($users, $type);
		return Redirect::back();
	}

	// get merchant view calculations/queries
	private function get_merchant($merchant_ID=null)
	{
		try {
			$global = DB::table('global')->first();
			if ($merchant_ID==null) {
				$merchants = DB::select(DB::raw("SELECT c.code as currency, m.id as mid,m.user_id as user_id, m.company_name as company, m.oshop_name as name, SUM((op.order_price * op.quantity) + op.actual_delivery_price) as net_payable, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, m.commission_type as commission_type, m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, m.b2b_osmall_commission as b2b_osmall_commission, po.order_administration_fee,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM merchant m, payment p, porder po, orderproduct op, product pro,
					 merchantproduct mp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.merchant_id and pro.id = mp.product_id
					 AND po.status IN (".$this->cStatus.")
					 and op.porder_id = po.id and op.product_id = pro.id AND po.id NOT IN (SELECT sorder.porder_id FROM sorder WHERE sorder.porder_id = po.id) AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id
					 AND cs_payment.role_id = 3 AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY m.id ORDER BY p.created_at DESC"));
					 $payable = 0;
					 $ofee = true;
					 $current_po = 0;
					 foreach ($merchants as $merchant) {
						$orderps = DB::select(DB::raw("SELECT c.code as currency, po.id as poid,m.id as mid,m.user_id as user_id, m.company_name as company, m.oshop_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, op.order_price as order_price, op.quantity as quantity, op.actual_delivery_price as actual_delivery_price, ((op.order_price * op.quantity) + op.actual_delivery_price) as net_payable, op.osmall_comm_amount,op.log_comm_amount, po.order_administration_fee,
						m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
						m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, pro.segment as segment, pro.osmall_commission as osmall_commission, pro.b2b_osmall_commission as b2b_osmall_commission,
						DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM merchant m, payment p, porder po, orderproduct op, product pro, merchantproduct mp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.merchant_id and pro.id = mp.product_id and op.porder_id = po.id and op.product_id = pro.id AND po.status IN (".$this->cStatus.") AND m.id = ".$merchant->mid." AND po.id NOT IN (SELECT sorder.porder_id FROM sorder WHERE sorder.porder_id = po.id) AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 3 AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY op.id ORDER BY po.id DESC"));
						if($merchant->commission_type != "std" && $merchant->commission_type != "var" ){
							$commission_type=$global->commission_type;
						} else {
							$commission_type=$merchant->commission_type;
						}					
						if($merchant->b2b_commission_type != "std" && $merchant->b2b_commission_type != "var" ){
							$b2b_commission_type=$global->b2b_commission_type;
						} else {
							$b2b_commission_type=$merchant->b2b_commission_type;
						}						
						$mc_pay = 0;
						if($merchant->mc_id > 0){
							if($merchant->mc_commission > 0){
								$mc_pay = $merchant->mc_commission;
							} else {
								$mc_pay = $global->mc_sales_staff_commission;
							}
						}
						$referral_pay = 0;
						if($merchant->referral_id > 0){
							if($merchant->referral_commission > 0){
								$referral_pay = $merchant->referral_commission;
							} else {
								$referral_pay = $global->referral_sales_staff_commission;
							}
						}
						$mcp1_pay = 0;
						if($merchant->mcp1_id > 0){
							if($merchant->mcp1_commission > 0){
								$mcp1_pay = $merchant->mcp1_commission;
							} else {
								$mcp1_pay = $global->mcp1_sales_staff_commission;
							}
						}															
						$mcp2_pay = 0;
						if($merchant->mcp2_id > 0){
							if($merchant->mcp2_commission > 0){
								$mcp2_pay = $merchant->mcp2_commission;
							} else {
								$mcp2_pay = $global->mcp2_sales_staff_commission;
							}
						}		
						$gateway_pay = $global->payment_gateway_commission;
						$logistic_pay = $global->logistic_commission;
						foreach ($orderps as $orderp) {
							$commission = 0;
							if($orderp->segment == 'b2b'){
								if($b2b_commission_type == 'std'){
									if($merchant->b2b_osmall_commission == null || is_null($merchant->b2b_osmall_commission) || $merchant->b2b_osmall_commission == "null" || $merchant->b2b_osmall_commission == "" || $merchant->b2b_osmall_commission == 0){
										$commission = $global->b2b_osmall_commission;
									} else {
										$commission = $merchant->b2b_osmall_commission;
									}
								} else {
									if($orderp->b2b_osmall_commission == null || is_null($orderp->b2b_osmall_commission) || $orderp->b2b_osmall_commission == "null" || $orderp->b2b_osmall_commission == "" || $orderp->b2b_osmall_commission == 0){
										if($merchant->b2b_osmall_commission == null || is_null($merchant->b2b_osmall_commission) || $merchant->b2b_osmall_commission == "null" || $merchant->b2b_osmall_commission == "" || $merchant->b2b_osmall_commission == 0){
											$commission = $global->b2b_osmall_commission;
										} else {
											$commission = $merchant->b2b_osmall_commission;
										}
									 } else {
										 $commission = $orderp->b2b_osmall_commission;
									 }
								}
							} else {
								if($commission_type == 'std'){
									if($merchant->osmall_commission == null || is_null($merchant->osmall_commission) || $merchant->osmall_commission == "null" || $merchant->osmall_commission == "" || $merchant->osmall_commission == 0){
										$commission = $global->osmall_commission;
									} else {
										$commission = $merchant->osmall_commission;
									}
								} else {
									if($orderp->osmall_commission == null || is_null($orderp->osmall_commission) || $orderp->osmall_commission == "null" || $orderp->osmall_commission == "" || $orderp->osmall_commission == 0){
										if($merchant->osmall_commission == null || is_null($merchant->osmall_commission) || $merchant->osmall_commission == "null" || $merchant->osmall_commission == "" || $merchant->osmall_commission == 0){
											$commission = $global->osmall_commission;
										} else {
											$commission = $merchant->osmall_commission;
										}
									 } else {
										 $commission = $orderp->osmall_commission;
									 }
								}								
							}
							$commission = $orderp->osmall_comm_amount;
							//dump($commission);
							$net_payable = ($orderp->order_price * $orderp->quantity);
						/*	dump($net_payable);
							dump($mc_pay);
							dump($gateway_pay);*/
							$npayable = (($orderp->order_price * $orderp->quantity * ((100 - ($commission/100))/100))) -
								($gateway_pay/100)*$net_payable;
							$payable += $npayable;	
							//dump($npayable);
							if($orderp->poid != $current_po){
								$payable -= $orderp->order_administration_fee;
								$current_po = $orderp->poid;
							}
						}
						
						//dump($merchant->order_administration_fee);
						$merchant->payable = $payable;								
					 }
					 
			}else{
				$merchants = DB::select(DB::raw("SELECT c.code as currency, m.id as mid, m.company_name as company, m.oshop_name as name,
						CASE WHEN m.commission_type = 'std' THEN m.osmall_commission ELSE SUM(pro.osmall_commission) END as commission,
						p.receivable as payable, DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, ops.success_indicator as status,
						UPPER(po.source) as source

						FROM merchant m, payment p, porder po, orderproduct op, product pro, ocbc_payment_status ops, currency c

						WHERE m.id=$merchant_ID AND c.active = 1 and p.id = po.payment_id and m.id = po.user_id and
						ops.porder_id = po.id and op.porder_id = po.id and op.product_id = pro.id GROUP BY m.id"));
			}
//			AND p.merchant = FALSE
//			AND p.station = FALSE
			

		} catch(Exception $e){
			dd($e);
		}

		if (isset($merchants) and $merchants != null){
			foreach ($merchants as $merchant) {
				$rcv_date = $merchant->rcv;
				if($rcv_date != null and $rcv_date != ''){
					$date = $this->carbon->parse($rcv_date);
					$day = $date->format('d');
					$month = $date->format('m');
					$year = $date->format('Y');
					$day_after_seven_days = $day + 7;

					if ($day_after_seven_days <= 15){
						$merchant->due = $this->carbon->parse($year.'-'.$month.'-15')->format('dMy h:m');
					}else{
						$merchant->due = $this->carbon->parse($year.'-'.$month.'-30')->format('dMy h:m');
					}
				}else{
					$merchant->due = '';
				}
			}
		}
		

		$merchants = is_array($merchants) && !empty($merchants) ? $merchants : null;
		return $merchants;
	}
	
	
	private function get_logistic($logistic_ID=null)
	{
		try {
			//dd("HOLA");
			if ($logistic_ID==null) {
				$logistics = DB::select(DB::raw("
					SELECT 
					c.code as currency,
					m.id as station_id,
					m.user_id as user_id,
					m.company_name as company,
					SUM(op.actual_delivery_price) as net_payable, 
					m.mc_sales_staff_id as mc_id,
					SUM(op.log_comm_amount) as log_comm_amount,
					COUNT(op.id) as number, 
					m.mc_sales_staff_commission as mc_commission,
					m.referral_sales_staff_id as referral_id,
					m.referral_sales_staff_commission as referral_commission,
					m.mcp1_sales_staff_id as mcp1_id,
					m.mcp1_sales_staff_commission as mcp1_commission,
					m.mcp2_sales_staff_id as mcp2_id,
					m.mcp2_sales_staff_commission as mcp2_commission,
					m.commission_type as commission_type,
					m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, m.b2b_osmall_commission as b2b_osmall_commission, l.logistic_commission, l.id as logistic_id, co.company_name,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source 
					FROM logistic l, company co, station m, delivery d, payment p, porder po, orderproduct op, product pro, currency c 
					WHERE 
					c.active = 1 
					and p.id = po.payment_id 
					AND po.status IN (".$this->cStatus.") AND d.porder_id = po.id AND l.id = d.logistic_id AND m.id = l.station_id AND co.id = l.company_id
					 and op.porder_id = po.id and op.product_id = pro.id AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id 
					 AND cs_payment.role_id = 13 AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY m.id ORDER BY p.created_at DESC"));
					 $payable = 0;
					 $comm = 0;
					 foreach ($logistics as $merchant) {
						//dump($merchant->net_payable);
						//dump($merchant->log_comm_amount);
						$merchant->payable = $merchant->net_payable-$merchant->log_comm_amount;
					//	$comm += $merchant->log_comm_amount;
					 }
					 
			}else{
				$logistics = DB::select(DB::raw("SELECT c.code as currency, m.id as mid, m.company_name as company, m.oshop_name as name,
						CASE WHEN m.commission_type = 'std' THEN m.osmall_commission ELSE SUM(pro.osmall_commission) END as commission,
						p.receivable as payable, DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, ops.success_indicator as status,
						UPPER(po.source) as source

						FROM merchant m, payment p, porder po, orderproduct op, product pro, ocbc_payment_status ops, currency c

						WHERE m.id=$merchant_ID AND c.active = 1 and p.id = po.payment_id and m.id = po.user_id and
						ops.porder_id = po.id and op.porder_id = po.id and op.product_id = pro.id GROUP BY m.id"));
			}			
			if (isset($logistics) and $logistics != null){
			foreach ($logistics as $merchant) {
				$rcv_date = $merchant->rcv;
				if($rcv_date != null and $rcv_date != ''){
					$date = $this->carbon->parse($rcv_date);
					$day = $date->format('d');
					$month = $date->format('m');
					$year = $date->format('Y');
					$day_after_seven_days = $day + 7;

					if ($day_after_seven_days <= 15){
						$merchant->due = $this->carbon->parse($year.'-'.$month.'-15')->format('dMy h:m');
					}else{
						$merchant->due = $this->carbon->parse($year.'-'.$month.'-30')->format('dMy h:m');
					}
				}else{
					$merchant->due = '';
				}
			}
		}
		} catch(Exception $e){
			dd($e);
		}

		$logistics = is_array($logistics) && !empty($logistics) ? $logistics : null;
		return $logistics;
	}
	
	public function check_payment_received($records, $role)
	{
		$paid_payment_ids=array_pluck($this->iPayReceivable->get_ipay(),['payment_id']);
		$paid_payment_count=count($paid_payment_ids);
		// dd($paid_payment_ids);
		// zxcv
		// dump($records);
		if (is_null($records)) {
			$records=array();
		}
		foreach ($records as $record) {
			if($role == 3){
				$merchants_rec = DB::select(DB::raw("SELECT c.code as currency, m.id as mid,m.user_id as user_id, m.company_name as company, m.oshop_name as name, SUM(pr.partial) as net_payable, 
						m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
						m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission,
						DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source 
						FROM merchant m, payment p, porder po, orderproduct op, product pro,
						 merchantproduct mp, currency c, pgatewayporder pgp, payment_gateway pg, payment_receivable pr WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.merchant_id and pro.id = mp.product_id
						 and op.porder_id = po.id and op.product_id = pro.id AND po.id = pgp.porder_id AND pgp.payment_gateway_id = pg.id AND pgp.payment_gateway_id = pr.id AND m.id = ".$record->mid."  AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id
						 AND cs_payment.role_id = 3 AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY m.id ORDER BY p.created_at DESC"));
				// dd($merchants_rec);
				if($record->payable > 0){
					// if($merchants_rec[0]->net_payable >= $record->net_payable){
					// 	$record->can_consolidate=true;
					// 	$record->partial=$merchants_rec[0]->partial;
					// } else {
						$record->can_consolidate=true;
						$record->partial=9999;
					// }
				} else {
					$record->can_consolidate=false;
					$record->partial=0;
				}				
			}
			// dump($records);
			if($role == 11){
				$stations_rec=DB::select(DB::raw("SELECT c.code as currency, m.id as mid,m.user_id as user_id, m.company_name as company, m.station_name as name, 
							SUM(pr.partial) as net_payable, 
							m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
							m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission,
							DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM station m, payment p, porder po, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c, pgatewayporder pgp, payment_gateway pg, payment_receivable pr WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id
							and op.product_id = pro.id AND po.id = pgp.porder_id AND pgp.payment_gateway_id = pg.id AND pgp.payment_gateway_id = pr.id AND m.id = ".$record->mid." AND  po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 11
							AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY m.id ORDER BY p.created_at DESC"));
				if(count($stations_rec) > 0){
					if($stations_rec[0]->net_payable >= $record->net_payable){
						$record->can_consolidate=true;
						$record->partial=$stations_rec[0]->partial;
					} else {
						$record->can_consolidate=false;
						$record->partial=$stations_rec[0]->partial;
					}
				} else {
					$record->can_consolidate=false;
					$record->partial=0;
				}
							
			}
		//payment ids for each merchant

		}
		return $records;
	}
	public function get_stations()
	{
		if(!$global = DB::table('global')->first()) return; //A fix to avoid Trying to get property of non-object error

		$stations=DB::select(DB::raw("SELECT c.code as currency, m.id as mid,m.user_id as user_id, m.company_name as company, m.station_name as name, SUM((op.order_price * op.quantity) + op.actual_delivery_price) as net_payable, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, m.commission_type as commission_type, m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, m.b2b_osmall_commission as b2b_osmall_commission,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM station m, payment p, porder po, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.station_id AND mp.station_id = m.id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id
					and op.product_id = pro.id AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 11
					AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) GROUP BY m.id ORDER BY p.created_at DESC"));

		
		if (isset($stations) and $stations != null){
			 $payable = 0;
			foreach ($stations as $station) {
					$orderps = DB::select(DB::raw("SELECT c.code as currency, op.id as opid,po.id as poid, m.id as mid,m.user_id as user_id, m.company_name as company, op.order_price as order_price, op.quantity as quantity, op.actual_delivery_price as actual_delivery_price,m.station_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission, pro.segment as segment, pro.osmall_commission as osmall_commission, pro.b2b_osmall_commission as b2b_osmall_commission,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, m.commission_type as commission_type, m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, m.b2b_osmall_commission as b2b_osmall_commission,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source, p.id as paid, so.id as soid, c.id as cid, mp.id mpid, sp.id as spid, mp.fair_commission as fair_commission FROM station m, payment p, porder po, sorder so, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id AND m.id = ".$station->mid." AND so.porder_id = po.id AND mp.station_id = ".$station->mid."
					and op.product_id = pro.id AND po.id NOT IN (SELECT cs_payment_detail.order_id FROM cs_payment, cs_payment_detail WHERE cs_payment.user_id = m.user_id AND cs_payment.role_id = 11
					AND cs_payment.id = cs_payment_detail.cs_payment_id AND cs_payment_detail.order_id = po.id) ORDER BY p.created_at DESC"));
					
						if($station->commission_type != "std" && $station->commission_type != "var" ){
							$commission_type=$global->commission_type;
						} else {
							$commission_type=$station->commission_type;
						}					
						if($station->b2b_commission_type != "std" && $station->b2b_commission_type != "var" ){
							$b2b_commission_type=$global->b2b_commission_type;
						} else {
							$b2b_commission_type=$station->b2b_commission_type;
						}						
						$mc_pay = 0;
						if($station->mc_id > 0){
							if($station->mc_commission > 0){
								$mc_pay = $station->mc_commission;
							} else {
								$mc_pay = $global->mc_sales_staff_commission;
							}
						}
						$referral_pay = 0;
						if($station->referral_id > 0){
							if($station->referral_commission > 0){
								$referral_pay = $station->referral_commission;
							} else {
								$referral_pay = $global->referral_sales_staff_commission;
							}
						}
						$mcp1_pay = 0;
						if($station->mcp1_id > 0){
							if($station->mcp1_commission > 0){
								$mcp1_pay = $station->mcp1_commission;
							} else {
								$mcp1_pay = $global->mcp1_sales_staff_commission;
							}
						}															
						$mcp2_pay = 0;
						if($station->mcp2_id > 0){
							if($station->mcp2_commission > 0){
								$mcp2_pay = $station->mcp2_commission;
							} else {
								$mcp2_pay = $global->mcp2_sales_staff_commission;
							}
						}		
						$gateway_pay = $global->payment_gateway_commission;
						$logistic_pay = $global->logistic_commission;
						foreach ($orderps as $orderp) {
							$commission = 0;
							if($orderp->segment == 'b2b'){
								if($b2b_commission_type == 'std'){
									if($station->b2b_osmall_commission == null || is_null($station->b2b_osmall_commission) || $station->b2b_osmall_commission == "null" || $station->b2b_osmall_commission == "" || $station->b2b_osmall_commission == 0){
										$commission = $global->b2b_osmall_commission;
									} else {
										$commission = $station->b2b_osmall_commission;
									}
								} else {
									if($orderp->b2b_osmall_commission == null || is_null($orderp->b2b_osmall_commission) || $orderp->b2b_osmall_commission == "null" || $orderp->b2b_osmall_commission == "" || $orderp->b2b_osmall_commission == 0){
										if($station->b2b_osmall_commission == null || is_null($station->b2b_osmall_commission) || $station->b2b_osmall_commission == "null" || $station->b2b_osmall_commission == "" || $station->b2b_osmall_commission == 0){
											$commission = $global->b2b_osmall_commission;
										} else {
											$commission = $station->b2b_osmall_commission;
										}
									 } else {
										 $commission = $orderp->b2b_osmall_commission;
									 }
								}
							} else {
								if($commission_type == 'std'){
									if($orderp->fair_commission == null || is_null($orderp->fair_commission) || $orderp->fair_commission == "null" || $orderp->fair_commission == "" || $orderp->fair_commission == 0){
										if($station->osmall_commission == null || is_null($station->osmall_commission) || $station->osmall_commission == "null" || $station->osmall_commission == "" || $station->osmall_commission == 0){
											$commission = $global->osmall_commission;
										} else {
											$commission = $station->osmall_commission;
										}										
									} else {
										$commission = $orderp->fair_commission;
									}

								} else {
									
									if($orderp->fair_commission == null || is_null($orderp->fair_commission) || $orderp->fair_commission == "null" || $orderp->fair_commission == "" || $orderp->fair_commission == 0){
										if($orderp->osmall_commission == null || is_null($orderp->osmall_commission) || $orderp->osmall_commission == "null" || $orderp->osmall_commission == "" || $orderp->osmall_commission == 0){
											if($station->osmall_commission == null || is_null($station->osmall_commission) || $station->osmall_commission == "null" || $station->osmall_commission == "" || $station->osmall_commission == 0){
												$commission = $global->osmall_commission;
											} else {
												$commission = $station->osmall_commission;
											}
										 } else {
											 $commission = $orderp->osmall_commission;
										 }
									} else {
										$commission = $orderp->fair_commission;
									}
								}								
							}
							$net_payable = (($orderp->order_price * $orderp->quantity + ($orderp->actual_delivery_price)));
							$npayable = (($orderp->order_price * $orderp->quantity * ((100 - $commission)/100)) + ($orderp->actual_delivery_price * ((100 - $global->logistic_commission )/100))) -
								((($mc_pay/100)*$net_payable) +
								(($mcp1_pay/100)*$net_payable) +
								(($referral_pay/100)*$net_payable) +
								(($mcp2_pay/100)*$net_payable) +
								(($gateway_pay/100)*$net_payable));
							//dd();
							$payable += $npayable;								
						}
						$station->payable = $payable;										
				$rcv_date = $station->rcv;
				if($rcv_date != null and $rcv_date != ''){
					$date = $this->carbon->parse($rcv_date);
					$day = $date->format('d');
					$month = $date->format('m');
					$year = $date->format('Y');
					$day_after_seven_days = $day + 7;

					if ($day_after_seven_days <= 15){
						$station->due = $this->carbon->parse($year.'-'.$month.'-15')->format('dMy h:m');
					}else{
						$station->due = $this->carbon->parse($year.'-'.$month.'-30')->format('dMy h:m');
					}
				}else{
					$station->due = '';
				}
			}
		}

		$stations = is_array($stations) && !empty($stations) ? $stations : array();
		return $stations;

	}

	// get order view calculations/queries
	private function get_order($id)
	{
		try {

			$orders = DB::select(DB::raw("SELECT c.code as currency, po.id as poid, CASE WHEN m.commission_type = 'std' THEN m.osmall_commission ELSE SUM(pro.osmall_commission) END as commission, op.order_price as sales, op.status as status, p.receivable as payable, DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM merchant m, payment p, porder po, currency c, orderproduct op, product pro WHERE c.active = 1 and po.user_id = $id and p.id = po.payment_id and op.porder_id = po.id and op.product_id = pro.id and m.id = po.user_id GROUP BY po.id"));

		} catch(Exception $e){
			throw new CustomException($e);
		}

		if (isset($orders) and $orders != null){
			foreach ($orders as $order) {
				$rcv_date = $order->rcv;
				if($rcv_date != null and $rcv_date != ''){
					$date = $this->carbon->parse($rcv_date);
					$day = $date->format('d');
					$month = $date->format('m');
					$year = $date->format('Y');
					$day_after_seven_days = $day + 7;

					if ($day_after_seven_days <= 15){
						$order->due = $this->carbon->parse($year.'-'.$month.'-15')->format('dMy h:m');
					}else{
						$order->due = $this->carbon->parse($year.'-'.$month.'-30')->format('dMy h:m');
					}
				}else{
					$order->due = '';
				}
			}
		}

		$orders = is_array($orders) && !empty($orders) ? $orders : null;
		return $orders;
	}

	// get product view calculations/queries
	private function get_product($id)
	{
		try {

			$products = DB::select(DB::raw("SELECT c.code as currency, po.id as poid, DATE_FORMAT(po.created_at,'%d%b%y %h:%m') as order_received, DATE_FORMAT(po.receipt_tstamp,'%d %b %y %h:%m') as order_executed, op.quantity as quantity, p.retail_price as price, po.user_id as user_id, CONCAT(u.first_name, ' ', u.last_name) as user_name, UPPER(po.source) as source from users u, porder po, orderproduct op, product p, currency c where p.id = op.product_id and u.id = po.user_id and c.active = 1 and po.id = $id and op.porder_id = po.id GROUP BY p.id "));

		} catch(Exception $e){
			throw new CustomException($e);
		}

		$products = is_array($products) && !empty($products) ? $products : null;

		return $products;
	}

	// get smm view calculations/queries
	private function get_smm()
	{
		try {

			$smms = DB::select(DB::raw("SELECT c.code as currency, ss.id as smmid, ss.user_id as user_id, CONCAT(u.first_name, ' ',u.last_name) as name, SUM(p.receivable) as pes, COUNT(op.status) as outstanding, DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv FROM payment p, sales_staff ss, users u, porder po, currency c, orderproduct op WHERE c.active = 1 and ss.user_id = u.id and ss.type = 'smm' and ss.user_id = po.user_id and po.payment_id = p.id and op.porder_id = po.id and op.status = 'unpaid' and ss.created_at BETWEEN ss.created_at AND CURDATE() GROUP BY ss.id "));

			foreach ($smms as $key => $smm) {
				$ytd[$key] = DB::select(DB::raw("SELECT SUM(p.receivable) as eytd FROM payment p, sales_staff ss, users u, porder po WHERE ss.id = $smm->smmid and ss.user_id = u.id and ss.type = 'smm' and ss.user_id = po.user_id and po.payment_id = p.id and p.created_at BETWEEN CONCAT(extract(year FROM CURDATE()), '-01', '-01') AND CURDATE() GROUP BY ss.id"));
			}

		} catch(Exception $e){
			throw new CustomException($e);
		}

		if (isset($smms) and $smms != null){
			foreach ($smms as $smm) {
				$rcv_date = $smm->rcv;
				if($rcv_date != null and $rcv_date != ''){
					$date = $this->carbon->parse($rcv_date);

					$day = $date->format('d');
					$month = $date->format('m');
					$year = $date->format('Y');
					$day_after_seven_days = $day + 7;

					if ($day_after_seven_days <= 15){
						$smm->due = $this->carbon->parse($year.'-'.$month.'-15')->format('dMy h:m');
					}else{
						$smm->due = $this->carbon->parse($year.'-'.$month.'-30')->format('dMy h:m');
					}
				}else{
					$smm->due = '';
				}
			}

			$smms = is_array($smms) && !empty($smms) ? $smms : null;
			$ytd = is_array($ytd) && !empty($ytd) ? $ytd : null;

			return array($smms,$ytd);
		}
	}

	// get smm_details view calculations/queries
	private function get_smm_details($id)
	{
		try {

			$smm_details = DB::select(DB::raw("SELECT ss.id as smmid, CONCAT(u.first_name, ' ', u.last_name) as name, so.product_id as shared_item, COUNT(so.product_id) as shared_times, COUNT(si.response) as clicked, ad.area as area, c.state_code as state, c.country_code as country, sm.name as source FROM sales_staff ss, users u, smmout so, smmin si, address ad, city c, social_media sm WHERE ss.id = $id and ss.user_id = u.id and ss.type = 'smm' and so.user_id = u.id and si.smmout_id = so.id and u.default_address_id = ad.id and ad.city_id = c.id and si.smedia_id=sm.id GROUP BY ss.id"));

		} catch(Exception $e){
			throw new CustomException($e);
		}

		try {

			$viewers = DB::select(DB::raw("SELECT COUNT(si.response) as viewers FROM sales_staff ss, users u, smmout so, smmin si WHERE ss.id = $id and ss.user_id = u.id and ss.type = 'smm' and so.user_id = u.id and si.smmout_id = so.id and si.response = 'view' GROUP BY ss.id"));

		} catch(Exception $e){
			throw new CustomException($e);
		}

		try {

			$item_sold = DB::select(DB::raw("SELECT COUNT(so.product_id) as item_sold FROM sales_staff ss, users u, smmout so, smmin si WHERE ss.id = $id and ss.user_id = u.id and ss.type = 'smm' and so.user_id = u.id and si.smmout_id = so.id and si.response = 'buy' GROUP BY ss.id"));

		} catch(Exception $e){
			throw new CustomException($e);
		}

		try {

			$bought = DB::select(DB::raw("SELECT SUM(p.receivable) as bought FROM sales_staff ss, users u, smmout so, smmin si, product pr, porder po, payment p WHERE ss.id = $id and ss.user_id = u.id and ss.type = 'smm' and so.user_id = u.id and si.smmout_id = so.id and si.response = 'buy' and si.porder_id = po.id and po.payment_id = p.id GROUP BY ss.id "));

		} catch(Exception $e){
			throw new CustomException($e);
		}

		try {

			$last_share = DB::select(DB::raw("SELECT DATE_FORMAT(so.created_at,'%d%b%y %h:%m') as last_share FROM sales_staff ss, users u, smmout so, smmin si WHERE ss.id = $id and ss.user_id = u.id and ss.type = 'smm' and so.user_id = u.id and si.smmout_id = so.id GROUP BY ss.id ORDER BY so.created_at DESC LIMIT 1"));

		} catch(Exception $e){
			throw new CustomException($e);
		}

		$smm_details = is_array($smm_details) && !empty($smm_details) ? $smm_details : null;
		$viewers = is_array($viewers) && !empty($viewers) ? $viewers : null;
		$item_sold = is_array($item_sold) && !empty($item_sold) ? $item_sold : null;
		$bought = is_array($bought) && !empty($bought) ? $bought : null;
		$last_share = is_array($last_share) && !empty($last_share) ? $last_share : null;

		return array($smm_details, $viewers, $item_sold, $bought, $last_share);
	}

	// get employee view calculations/queries
	private function get_employee(){

		try {

			$employee = DB::select(DB::raw("SELECT emp.id as emp_id, emp.user_id as user_id,CONCAT(u.first_name, ' ',u.last_name) as name, pos.code as position, UPPER(emp.status) as status, (emp.monthly_salary * 12/100) as annual_income,(emp.epf_no) as epf,(emp.socso_no) as socso, (emp.payment) as payment, (emp.payment_at) as payment_at, emp.monthly_salary/100 as monthly_income, DATE_FORMAT(CURDATE(),'30%b%y %h:%m') as due, c.code as currency FROM employee emp, users u, position pos, currency c WHERE emp.user_id = u.id and emp.position_id = pos.id and c.active = 1 GROUP BY emp.id"));
			$payslip = array();
			foreach ($employee as $key => $emp) {
				$employeenew = DB::table('employee')->where('user_id',$emp->user_id)->first();
				if(!is_null($employeenew)){
					$payslip[$key] = app('App\Http\Controllers\BuyerController')->calculate_payslip($employeenew,$emp->user_id);
				}
				
			}			
		} catch(QueryException $e){
			throw new CustomException($e->getMessage());
		}

		$employee = is_array($employee) && !empty($employee) ? $employee : null;
		$payslip = is_array($payslip) && !empty($payslip) ? $payslip : null;
		return array($employee,$payslip);
	}

	// get employee view calculations/queries
	private function get_employee_details($id){

		try {

			$employee = DB::select(DB::raw("SELECT emp.id as emp_id, emp.user_id as user_id, CONCAT(u.first_name, ' ',u.last_name) as name, pos.code as position, UPPER(emp.status) as status, (emp.monthly_salary * 12/100) as annual_income,(emp.epf_no) as epf,(emp.socso_no) as socso, (emp.payment) as payment, (emp.payment_at) as payment_at, emp.monthly_salary/100 as monthly_income, DATE_FORMAT(CURDATE(),'30%b%y %h:%m') as due, c.code as currency FROM employee emp, users u, position pos, currency c WHERE emp.user_id = u.id and u.id=".$id." and emp.position_id = pos.id and c.active = 1 GROUP BY emp.id"));
			$payslip = array();
			foreach ($employee as $key => $emp) {
				$employeenew = DB::table('employee')->where('user_id',$emp->user_id)->first();
				if(!is_null($employeenew)){
					$payslip[$key] = app('App\Http\Controllers\BuyerController')->calculate_payslip($employeenew,$emp->user_id);
				}
				
			}			
		} catch(QueryException $e){
			throw new CustomException($e->getMessage());
		}

		$employee = is_array($employee) && !empty($employee) ? $employee : null;
		$payslip = is_array($payslip) && !empty($payslip) ? $payslip : null;
		return array($employee,$payslip);		
	}	

	// get mc view calculations/queries
	private function get_mc()
	{
		/*HAVE TO REMOVE SOME SQL QUERIES HERE SINCE THEY MIGHT NOT CONTRIBUTE TO WHAT IS TO BE RENDERED IN THE VIEW*/
		try {

			$mcs = DB::select(DB::raw("SELECT ss.id as mcid, CONCAT(u.first_name, ' ', u.last_name) as name, ss.status as status, ss.target_merchant as target_merchant, ss.target_revenue as target_revenue, ss.bonus as bonus, SUM(p.receivable) as esince, COUNT(op.status) as outstanding, DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, ad.area_id as area, c.state_code as state, c.country_code as country, c.id as city, cur.code as currency FROM sales_staff ss, users u, address ad, city c, payment p, porder po, currency cur, orderproduct op WHERE cur.active = 1 and ss.user_id = u.id and ss.type = 'mct' and u.default_address_id = ad.id and ad.city_id = c.id and ss.user_id = po.user_id and po.payment_id = p.id and op.porder_id = po.id and op.status = 'unpaid' and ss.created_at BETWEEN ss.created_at AND CURDATE() GROUP BY ss.id"));
			/*foreach ($mcs as $key => $mc) {
				$item_sold[$key] = DB::select(DB::raw("SELECT COUNT(so.product_id) as item_sold FROM sales_staff ss, users u, smmout so, smmin si WHERE ss.id = $mc->mcid and ss.user_id = u.id and ss.type = 'mct' and so.user_id = u.id and si.smmout_id = so.id and si.response = 'buy' GROUP BY ss.id"));

				$eytd[$key] = DB::select(DB::raw("SELECT SUM(p.receivable) as eytd FROM payment p, sales_staff ss, users u, porder po WHERE ss.id = $mc->mcid and ss.user_id = u.id and ss.type = 'mct' and ss.user_id = po.user_id and po.payment_id = p.id and p.created_at BETWEEN CONCAT(extract(year FROM CURDATE()), '-01', '-01') AND CURDATE() GROUP BY ss.id"));

				$relationship[$key] = DB::select(DB::raw("SELECT COUNT(m.id) as relationship FROM merchant m, sales_staff ss WHERE ss.id = $mc->mcid and ss.type = 'mct' and ss.id=m.mc_sales_staff_id"));

				$brand[$key] = DB::select(DB::raw("SELECT COUNT(b.id) as brand FROM merchant m, sales_staff ss, merchantbrand mb, brand b WHERE ss.id = $mc->mcid and ss.type = 'mct' and ss.id=m.mc_sales_staff_id and m.id=mb.merchant_id and mb.brand_id=b.id"));

				$sales_since[$key] = DB::select(DB::raw("SELECT SUM(p.receivable) as sales_since FROM merchant m, sales_staff ss, merchantproduct mp, orderproduct op, porder po, payment p WHERE ss.id = $mc->mcid and ss.type = 'mct' and ss.id=m.mc_sales_staff_id and m.id=mp.merchant_id and op.product_id=mp.product_id and op.porder_id=po.id and po.payment_id=p.id  GROUP BY ss.id"));

				$sales_ytd[$key] = DB::select(DB::raw("SELECT SUM(p.receivable) as sales_ytd FROM merchant m, sales_staff ss, merchantproduct mp, orderproduct op, porder po, payment p WHERE ss.id = $mc->mcid and ss.type = 'mct' and ss.id=m.mc_sales_staff_id and m.id=mp.merchant_id and op.product_id=mp.product_id and op.porder_id=po.id and po.payment_id=p.id and p.created_at BETWEEN CONCAT(extract(year FROM CURDATE()), '-01', '-01') AND CURDATE() GROUP BY ss.id"));
			}*/

		} catch(Exception $e){
			throw new CustomException($e);
		}

		if (isset($mcs) and $mcs != null and is_array($mcs)){
			foreach ($mcs as $mc) {
				$rcv_date = $mc->rcv;
				if($rcv_date != null and $rcv_date != ''){
					$date = $this->carbon->parse($rcv_date);

					$day = $date->format('d');
					$month = $date->format('m');
					$year = $date->format('Y');
					$day_after_seven_days = $day + 7;

					if ($day_after_seven_days <= 15){
						$mc->due = $this->carbon->parse($year.'-'.$month.'-15')->format('dMy h:m');
					}else{
						$mc->due = $this->carbon->parse($year.'-'.$month.'-30')->format('dMy h:m');
					}
				}else{
					$mc->due = '';
				}
			}

			$mcs = is_array($mcs) && !empty($mcs) ? $mcs : null;
			/*$item_sold = is_array($item_sold) && !empty($item_sold) ? $item_sold : null;
			$eytd = is_array($eytd) && !empty($eytd) ? $eytd : null;
			$relationship = is_array($relationship) && !empty($relationship) ? $relationship : null;
			$brand = is_array($brand) && !empty($brand) ? $brand : null;
			$sales_since = is_array($sales_since) && !empty($sales_since) ? $sales_since : null;
			$sales_ytd = is_array($sales_ytd) && !empty($sales_ytd) ? $sales_ytd : null;*/

			return array($mcs);
		}
	}

	// get mc view calculations/queries
	private function get_mc_details($id)
	{
		/*HAVE TO REMOVE SOME SQL QUERIES HERE SINCE THEY MIGHT NOT CONTRIBUTE TO WHAT IS TO BE RENDERED IN THE VIEW*/
		try {

			$mcs = DB::select(DB::raw("SELECT ss.id as mcid, CONCAT(u.first_name, ' ', u.last_name) as name, ss.status as status, ss.target_merchant as target_merchant, ss.target_revenue as target_revenue, ss.bonus as bonus, SUM(p.receivable) as esince, COUNT(op.status) as outstanding, DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, ad.area_id as area, c.state_code as state, c.country_code as country, c.id as city, cur.code as currency FROM sales_staff ss, users u, address ad, city c, payment p, porder po, currency cur, orderproduct op WHERE cur.active = 1 and ss.user_id = u.id and ss.type = 'mct' and u.default_address_id = ad.id and ad.city_id = c.id and ss.user_id = po.user_id and po.payment_id = p.id and op.porder_id = po.id and u.id = ".$id." and op.status = 'unpaid' and ss.created_at BETWEEN ss.created_at AND CURDATE() GROUP BY ss.id"));
			/*foreach ($mcs as $key => $mc) {
				$item_sold[$key] = DB::select(DB::raw("SELECT COUNT(so.product_id) as item_sold FROM sales_staff ss, users u, smmout so, smmin si WHERE ss.id = $mc->mcid and ss.user_id = u.id and ss.type = 'mct' and so.user_id = u.id and si.smmout_id = so.id and si.response = 'buy' GROUP BY ss.id"));

				$eytd[$key] = DB::select(DB::raw("SELECT SUM(p.receivable) as eytd FROM payment p, sales_staff ss, users u, porder po WHERE ss.id = $mc->mcid and ss.user_id = u.id and ss.type = 'mct' and ss.user_id = po.user_id and po.payment_id = p.id and p.created_at BETWEEN CONCAT(extract(year FROM CURDATE()), '-01', '-01') AND CURDATE() GROUP BY ss.id"));

				$relationship[$key] = DB::select(DB::raw("SELECT COUNT(m.id) as relationship FROM merchant m, sales_staff ss WHERE ss.id = $mc->mcid and ss.type = 'mct' and ss.id=m.mc_sales_staff_id"));

				$brand[$key] = DB::select(DB::raw("SELECT COUNT(b.id) as brand FROM merchant m, sales_staff ss, merchantbrand mb, brand b WHERE ss.id = $mc->mcid and ss.type = 'mct' and ss.id=m.mc_sales_staff_id and m.id=mb.merchant_id and mb.brand_id=b.id"));

				$sales_since[$key] = DB::select(DB::raw("SELECT SUM(p.receivable) as sales_since FROM merchant m, sales_staff ss, merchantproduct mp, orderproduct op, porder po, payment p WHERE ss.id = $mc->mcid and ss.type = 'mct' and ss.id=m.mc_sales_staff_id and m.id=mp.merchant_id and op.product_id=mp.product_id and op.porder_id=po.id and po.payment_id=p.id  GROUP BY ss.id"));

				$sales_ytd[$key] = DB::select(DB::raw("SELECT SUM(p.receivable) as sales_ytd FROM merchant m, sales_staff ss, merchantproduct mp, orderproduct op, porder po, payment p WHERE ss.id = $mc->mcid and ss.type = 'mct' and ss.id=m.mc_sales_staff_id and m.id=mp.merchant_id and op.product_id=mp.product_id and op.porder_id=po.id and po.payment_id=p.id and p.created_at BETWEEN CONCAT(extract(year FROM CURDATE()), '-01', '-01') AND CURDATE() GROUP BY ss.id"));
			}*/

		} catch(Exception $e){
			throw new CustomException($e);
		}

		if (isset($mcs) and $mcs != null and is_array($mcs)){
			foreach ($mcs as $mc) {
				$rcv_date = $mc->rcv;
				if($rcv_date != null and $rcv_date != ''){
					$date = $this->carbon->parse($rcv_date);

					$day = $date->format('d');
					$month = $date->format('m');
					$year = $date->format('Y');
					$day_after_seven_days = $day + 7;

					if ($day_after_seven_days <= 15){
						$mc->due = $this->carbon->parse($year.'-'.$month.'-15')->format('dMy h:m');
					}else{
						$mc->due = $this->carbon->parse($year.'-'.$month.'-30')->format('dMy h:m');
					}
				}else{
					$mc->due = '';
				}
			}

			$mcs = is_array($mcs) && !empty($mcs) ? $mcs : null;
			/*$item_sold = is_array($item_sold) && !empty($item_sold) ? $item_sold : null;
			$eytd = is_array($eytd) && !empty($eytd) ? $eytd : null;
			$relationship = is_array($relationship) && !empty($relationship) ? $relationship : null;
			$brand = is_array($brand) && !empty($brand) ? $brand : null;
			$sales_since = is_array($sales_since) && !empty($sales_since) ? $sales_since : null;
			$sales_ytd = is_array($sales_ytd) && !empty($sales_ytd) ? $sales_ytd : null;*/

			return array($mcs);
		}
	}	
	
	//	get mp view calculations/queries
	private function get_mp()
	{
		// DB::table('')
	}
	/*below functions aim to return carryOver amount*/ 
	public function merchantCredit()
	{
		
	}
	public function merchantDebit()
	{
		# code...
	}

	public function merchantTotal()
	{
		// $glob= D
		// DB::select(DB::raw("
		// 	select 
		// 		(op.order_price * op.quantity)
		// 		-(op.actual_delivery_price)
		// 		-(".$payment_gateway_comm/100."*(op.order_price * op_quantity))
		// 		-(".$commission/100." * (op.order_price*op_quantity) 
		// 		- (".$administrative_fee.") 
		// 		as we_owe_to_merchant
		// 	"));
	}
	public function merchantPaid($month="*")
	{
		# code...
	}
	public function merchantCarryOver($month="*")
	{
		# code...
	}
}

