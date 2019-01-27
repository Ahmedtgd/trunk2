<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Product;
use App\Models\Currency;

class CapsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
	
	public function paymentordersaudit($user_id)
	{
		try {
			$userarr = explode("_",$user_id); 
			$global = DB::table('global')->first();
			$orders = null;
			if($userarr[1] == "3"){
				$orders = DB::select(DB::raw("
						SELECT audit_cs_payment.created_at as created, SUM(IF(audit_cs_payment.status = 'awaiting',audit_cs_payment.amount,0)) as awaiting_amount, SUM(IF(audit_cs_payment.status = 'executed',orderproduct.quantity * orderproduct.order_price	,0)) as pending_amount, SUM(IF(audit_cs_payment.status = 'executed',audit_cs_payment.amount,0)) as executed_amount,
						merchant.id as id, merchant.user_id as user_id, audit_cs_payment.role_id as role_id, merchant.company_name as name, audit_cs_payment.period_start as period_start, audit_cs_payment.period_end as period_end, audit_cs_payment_detail.order_id as order_id, audit_cs_payment.date_confirm as confirm, COUNT(audit_cs_payment_detail.id) as orders_count
						FROM audit_cs_payment, merchant, audit_cs_payment_detail, porder, orderproduct
						WHERE 
						audit_cs_payment.status = 'executed' AND audit_cs_payment.role_id = 3 AND merchant.user_id = audit_cs_payment.user_id AND audit_cs_payment.cs_id = audit_cs_payment_detail.cs_payment_id AND audit_cs_payment.user_id = " . $userarr[0] . " AND audit_cs_payment.role_id = " .$userarr[1]  . " AND audit_cs_payment_detail.order_id = porder.id AND porder.id = orderproduct.porder_id
						GROUP BY order_id"));				
			}
			if($userarr[1] == "11"){
				$orders = DB::select(DB::raw("
						SELECT audit_cs_payment.created_at as created, SUM(IF(audit_cs_payment.status = 'awaiting',audit_cs_payment.amount,0)) as awaiting_amount, SUM(IF(audit_cs_payment.status = 'executed',orderproduct.quantity * orderproduct.order_price,0)) as pending_amount, SUM(IF(audit_cs_payment.status = 'executed',audit_cs_payment.amount,0)) as executed_amount,
						station.id as id, station.user_id as user_id, audit_cs_payment.role_id as role_id, station.company_name as name, audit_cs_payment.period_start as period_start, audit_cs_payment.period_end as period_end, audit_cs_payment_detail.order_id as order_id,  audit_cs_payment.date_confirm as confirm, COUNT(audit_cs_payment_detail.id) as orders_count
						FROM audit_cs_payment, station, audit_cs_payment_detail, porder, orderproduct
						WHERE 
						audit_cs_payment.status = 'executed' AND audit_cs_payment.role_id = 11 AND station.user_id = audit_cs_payment.user_id AND audit_cs_payment.cs_id = audit_cs_payment_detail.cs_payment_id AND audit_cs_payment.user_id = " . $userarr[0] . " AND audit_cs_payment.role_id = " .$userarr[1]  . " AND audit_cs_payment_detail.order_id = porder.id AND porder.id = orderproduct.porder_id
						GROUP BY order_id"));				
			}			

		} catch(Exception $e){
			throw new CustomException($e);
		}	
		return json_encode($orders);
	}	

    public function auditpayment()
    {
        $audits = DB::table('audit_cs_payment')->where('status','executed')->get();
		return view('audit_payment_view',['audits'=>$audits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
