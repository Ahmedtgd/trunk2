<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\StatusState;
use App\Models\POrder;
use Illuminate\Support\Facades\Auth;
use DB;
use Yajra\Datatables\Facades\Datatables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      /*  $order = DB::table('porder')
            ->join('payment', 'porder.payment_id', '=', 'payment.id')
            ->where('mode', 'cash')
            ->select(
                DB::raw(
                    "payment.receivable as oprice, 
        		porder.*"

                )
            )
            ->orderBy(DB::raw("
			  CASE porder.status
				WHEN 'active' THEN 1
				WHEN 'pending' THEN 2
				WHEN 'cancelreq' THEN 3
				WHEN 'b-returning' THEN 4
				WHEN 'unb-collected' THEN 5
				WHEN 'cancelled' THEN 6
				WHEN 'returned' THEN 7
				WHEN 'b-collected' THEN 8
				WHEN '' THEN 9
				WHEN NULL THEN 9
				ELSE 10
			  END"))
            ->orderBy('porder.created_at', 'DESC')
            ->get();
        // Add Segment
        foreach ($order as $ord) {
            $ord->segment = UtilityController::getPorderSegment($ord->id);
        }*/
        return view('admin/adminMasterOrderPaginate');
    }
	
	public function order_pagination($start=0)
    {
		$end=$start+30;

        $ret=array();
        if (!Auth::check() or !Auth::user()->hasRole('adm')) {
            return $ret;
        }
        try {
            $ret=POrder::join('orderproduct', 'orderproduct.porder_id', '=', 'porder.id')->
			leftJoin('nporderid', 'nporderid.porder_id', '=', 'porder.id')->
			leftJoin('nbuyerid', 'nbuyerid.user_id', '=', 'porder.user_id')
            ->where('mode', 'cash')
            ->select(
                DB::raw(
                    "
					 porder.*,
					 DATE_FORMAT(porder.created_at,'%d%b%y %H:%i') as received,
					 DATE_FORMAT(porder.updated_at,'%d%b%y %H:%i') as completed,
					 SUM(orderproduct.order_price * orderproduct.quantity) as total,
					 IFNULL(nporderid.nporder_id,LPAD(porder.id,16,'E')) as order_id,
					 IFNULL(nbuyerid.nbuyer_id,LPAD(porder.user_id,16,'E')) as buyer_id"

                )
            )
			->groupBy("porder.id")
            ->orderBy(DB::raw("
			  CASE porder.status
				WHEN 'active' THEN 1
				WHEN 'pending' THEN 2
				WHEN 'cancelreq' THEN 3
				WHEN 'b-returning' THEN 4
				WHEN 'unb-collected' THEN 5
				WHEN 'cancelled' THEN 6
				WHEN 'returned' THEN 7
				WHEN 'b-collected' THEN 8
				WHEN '' THEN 9
				WHEN NULL THEN 9
				ELSE 10
			  END"))
            ->orderBy('porder.created_at', 'DESC');
              
        } catch (\Exception $e) {
            // dd($e);
        }
        return Datatables::eloquent($ret)->make(true);
	}

    public function term()
    {
        $order = DB::table('porder')
            ->join('invoice', 'porder.id', '=', 'invoice.porder_id')
            ->where('mode', 'term')
            ->select(
                DB::raw(
                    " DISTINCT porder.* "

                )
            )
            ->orderBy(DB::raw("
			  CASE porder.status
				WHEN 'active' THEN 1
				WHEN 'pending' THEN 2
				WHEN 'cancelreq' THEN 3
				WHEN 'b-returning' THEN 4
				WHEN 'unb-collected' THEN 5
				WHEN 'cancelled' THEN 6
				WHEN 'returned' THEN 7
				WHEN 'b-collected' THEN 8
				WHEN '' THEN 9
				WHEN NULL THEN 9
				ELSE 10
			  END"))
            ->orderBy('porder.created_at', 'DESC')
            ->get();
        //dd($order);
        //return $order;
        return view('admin/adminMasterTerm', ['order' => $order]);
    }

    public function manual($id)
    {
        //  Paul on 30 April 2017 at 7 20 pm
        //DB::table('porder')->where('id', $id)->update(['status' => 'manual']);
        try {
             POrder::find($id)->update(['status' => 'manual']);
             $ret="Ok";
        } catch (\Exception $e) {
            $ret=$e->getMessage();
        }
       
        return $ret;
    }

    public function approval($id)
    {
        /*  Paul on 29 April 2017 at 1 50 am to fetch
        statusstate names along with description
        to display it (description) at MRT Canvas  */

        $status_states = StatusState::all()->pluck('description', 'name');
        $status_states = json_encode($status_states);
        $role = "";
        $porder=POrder::find($id);
        if (!Auth::check() ) {
            return view('common.generic')
                ->with('message_type','error')
                ->with('message','Please login to access the page')
                ->with('redirect_to_login',1);
        }
        if(is_null($porder)){
            return view('admin/adminMasterOrderApproval', [
				'status_states' => $status_states
			]);
        }
        /*  Ends Here  */
        $order = DB::table('porder')
            ->join('payment', 'porder.payment_id', '=', 'payment.id')
            ->join('receipt', 'porder.id', '=', 'receipt.porder_id')
            ->select(
                DB::raw(
                    "payment.receivable as oprice, receipt.do_password,
        		porder.*"
                )
            )
            ->orderBy(DB::raw("
			  CASE porder.status
				WHEN 'active' THEN 1
				WHEN 'pending' THEN 2
				WHEN 'cancelreq' THEN 3
				WHEN 'b-returning' THEN 4
				WHEN 'unb-collected' THEN 5
				WHEN 'cancelled' THEN 6
				WHEN 'returned' THEN 7
				WHEN 'b-collected' THEN 8
				WHEN '' THEN 9
				WHEN NULL THEN 9
				ELSE 10
			  END"))
            ->orderBy('porder.created_at', 'DESC');


            /*  Paul on 2 May 2017 at 8 40 pm
                to apply survivability for users
            */
            if(Auth::user()->hasRole('adm')) {
                $role = 'adm';
                //  he can see all orders
                $order = $order->where('porder.id', $id)
                    /* Paul: we should use first() instead of get() because
                        we know that we will get exactly 1 Record as we
                        have applied condition for PK, so for PK,
                        we must will get Exactly 1 Row */
                    //->get();
                    ->first();

            //  for buyer
            } else if(Auth::user()->id == $porder->user_id){
                $role = 'byr';
                //return Auth::user()->id;
                $order = $order->where('porder.id', $id)
                    //porder.user_id is actually buyer_id
                    ->where('porder.user_id',Auth::user()->id)
                    ->first();
            }
            //  for merchant
            else if(Auth::user()->hasRole('mer')){

                $role = 'mer';
				/*  we will check whether the current porder belongs to
				 *  this merchant or not for this, we will follow
				 *  following steps:
                1)  Get porder_id from porder and we already have it in the url
                2)  Get product_id from orderproduct for this porder
                3)  Get merchant_id from merchantproduct for the ordered product
                4)  Get user_id from merchant
				5)  Compare current user's (merchant) id with the above
					retrieved user_id
				6)  If it matches, we have a valid merchant otherwise we
					will not populate the MRT.
                */

                $merchant = DB::table('orderproduct')
					->join('merchantproduct', 'orderproduct.product_id', '=',
						   'merchantproduct.product_id')
				    ->join('merchant', 'merchant.id', '=',
						   'merchantproduct.merchant_id')
                    ->where('orderproduct.porder_id', $id)
                    ->whereNull('merchantproduct.deleted_at')
                    ->first(['merchant.user_id']);

                if(!is_null($merchant) &&
					Auth::user()->id === $merchant->user_id) {
                    $order = $order->where('porder.id', $id)->first();

                } else
                    $order = null;
            } else
                {$order = null;}

        // dump($order);

		/*
		In case of Commented or Completed, we need previous status to build
		correct MRT. Prev of Commented is always Completed but Prev of
		Completed is unknown. So the last status NOT IN Commented or
		Completed is required for building correct MRT Path
		*/
        if(is_null($order)){
            return view('admin/adminMasterOrderApproval', [
				'status_states' => $status_states
			]);
        }

        $previous_path = "";
        $awarded = "";

        if ($order->status === 'completed' || $order->status === 'commented') {
            $orderdeliverypath = DB::table('orderdeliverypath')
				->join('statusstate',
					'orderdeliverypath.statusstate_id', '=', 'statusstate.id')
                ->where('orderdeliverypath.porder_id', $id)
                //  Not in Completed & Commented
                ->whereNotIn('orderdeliverypath.statusstate_id', [37, 38])
                //  path_no order is very important to be maintained
                ->orderBy('orderdeliverypath.path_no', 'DESC')
                ->first(['statusstate.name']);
        } else {
            //  Get Max path_no
			$max_path_no = DB::table('orderdeliverypath')->
				where('orderdeliverypath.porder_id', $id)->max('path_no');

            if(is_null($max_path_no))
                $max_path_no = 0;

            $orderdeliverypath = DB::table('orderdeliverypath')
                ->join('statusstate', 'orderdeliverypath.statusstate_id',
					'=', 'statusstate.id')
                ->where('orderdeliverypath.porder_id', $id)
                ->where('orderdeliverypath.path_no', '<', $max_path_no)
                ->orderBy('orderdeliverypath.path_no', 'DESC')
                ->first(['statusstate.name']);
        }

        if (!is_null($orderdeliverypath))
            $previous_path = $orderdeliverypath->name;

        //dump($orderdeliverypath);

        $winner = DB::table('adminreview')
            ->join('orderproduct', 'adminreview.orderproduct_id', '=', 'orderproduct.id')
            ->join('porder', 'orderproduct.porder_id', '=', 'porder.id')
            ->where('porder.id', '=', $order->id)
            ->whereNull('porder.deleted_at')
            ->first([
                'awarded',
                'porder.status as porder_status',
                'orderproduct.status as orderproduct_status',
                'adminreview.status as adminreview_status'
            ]);
        $delivery_rtr=NULL;
        if (!is_null($winner))
            $awarded = $winner->awarded;

		/* Squidster: Have to TEST delivery for NULL!!! */
		$delivery = DB::table('delivery')->
			where('porder_id',$id)->
            where('type','m2b')->
			orderBy('id','DESC')->first();

        $delivery_rtr = DB::table('delivery')->
            where('porder_id',$id)->
            where('type','b2m')->
            orderBy('id','DESC')->first();

		/* Grab the list of comments for all the returned products */
		try {
 			$comment=OrderProduct::join('product','product.id','=','orderproduct.product_id')->
				join('porder','porder.id','=','orderproduct.porder_id')->
				join('ocomment','ocomment.orderproduct_id','=','orderproduct.id')->
				where('orderproduct.porder_id','=',$order->id)->
				select([
					'orderproduct.product_id',
					'orderproduct.porder_id',
					'product.name',
					'product.thumb_photo',
					'ocomment.comment'])->
				groupBy('orderproduct.id')->
				get();
 
        } catch (\Exception $e) {
			$comment = NULL;
        }

        $nv_image = $nvpod = NULL;
        try {
			$nvpod=DB::table('nv_pod')->
				where('nv_tracking_id', $delivery->consignment_number)->
				where('nv_shipper_order_ref_no', $order->id)->
				orderBy('id','DESC')->first();

            //$nv_image=$order->id.$delivery->consignment_number.".png";
            $nv_image=$order->id.$nvpod->nv_tracking_id.".png";
            
            $acquired_time=$nvpod->created_at;

        } catch (\Exception $e) {
			$acquired_time=NULL;
			$acquired_time_rtr=NULL;
        }

        $nv_image_rtr=$nvpod_rtr=$acquired_time_rtr=NULL;
        /* Data for Second Security */ 
        try {
            $nvpod_rtr=DB::table('nv_pod')->where('nv_tracking_id',
                    $delivery_rtr->consignment_number)->
                where('nv_shipper_order_ref_no', $order->id)->
                orderBy('id','DESC')->first();
            $nv_image_rtr=$order->id.$nvpod_rtr->nv_tracking_id.".png";
            $acquired_time_rtr=$nvpod_rtr->created_at;
            
        } catch (\Exception $e) {
        }

		/* Find out if there's ever a dfailedX for M2B and B2M for a porder */
		$attempt = $attempt_rtr = null;
		$dstatus = $dstatus_rtr = null;
		if (isset($delivery) && !empty($delivery)) {
			$attempt=(int)DB::table('dfailure')->
				where('delivery_id', $delivery->id)->
				where('type', $delivery->type)->
				orderBy('attempt','DESC')->
				pluck('attempt');

			if ($attempt==1 or $attempt==2 or $attempt==3) {
				$dstatus='dfailed'.$attempt;
			}
		}

		if (isset($delivery_rtr) && !empty($delivery_rtr)) {
			$attempt_rtr=(int)DB::table('dfailure')->
				where('delivery_id', $delivery_rtr->id)->
				where('type', $delivery_rtr->type)->
				orderBy('attempt','DESC')->
				pluck('attempt');

			if ($attempt_rtr==1 or $attempt_rtr==2 or $attempt_rtr==3) {
				$dstatus_rtr='dfailed'.$attempt_rtr;
			}
		}

		/*
		dump('C:dstatus_rtr='.$dstatus_rtr);
		dump('C:delivery_rtr->status='.$delivery_rtr->status);

   	 	dd($order);
		dump($delivery);
		dump('previous_path='.$previous_path);
		dump($nvpod);
		*/

        return view('admin/adminMasterOrderApproval', [
			'comment' => $comment,
			'order' => $order,
			'status_states' => $status_states,
			'oid' => $id,
			'previous_path' => $previous_path,
			'awarded' => $awarded,
			'delivery' => $delivery,
			'delivery_rtr' => $delivery_rtr,
			'nvpod' => $nvpod,
			'nvpod_rtr' => $nvpod_rtr,
			'role' => $role,
			'acquired_time'=>$acquired_time,
			'acquired_time_rtr'=>$acquired_time_rtr,
			'nv_image'=>$nv_image,
			'nv_image_rtr'=>$nv_image_rtr,
			'dstatus'=>$dstatus,
			'dstatus_rtr'=>$dstatus_rtr
		]);
    }

    public function getDeliveryOrder($id)
    {
        $deliveryorder = DeliveryOrder::where('porder_id', $id)->get();
        return json_encode($deliveryorder);
    }

    public function status()
    {
		//  Paul fetching all the statuses from ENUM Colum Status,
		//  the column of Porder table...
        $enum_status = DB::select(DB::raw("SHOW COLUMNS FROM porder WHERE Field = 'status'"))[0]->Type;

        preg_match('/^enum\((.*)\)$/', $enum_status, $matches);
        $values = array();

        foreach (explode(',', $matches[1]) as $value) {
            $values[] = trim($value, "'");
        }

        return $values;
    }

    public function get_op_details_mobile($porder_id)
    {
        $currency= DB::table('currency')->where('active', 1)->first()->code;
        $ops=OrderProduct::join('product','product.id','=','orderproduct.product_id')->
        where('porder_id',$porder_id)->
        select(['product.name','product.parent_id','product.photo_1','orderproduct.quantity','orderproduct.order_price'])->
        get();
        $nporderid=DB::table('nporderid')->where('porder_id',$porder_id)->pluck('nporder_id');
        $ret="
    
        <table class='table mobile_table_op table-borderless'>
            <thead>
            <tr><th colspan=3>Order ID :".$nporderid."</th></tr>
            <tr>
            <th style='border:none !important;font-size:1.2em;'>Sales Order</th>
            <th style='border:none !important;'>Qty</th>
            <th style='border:none !important;'></th>
            </tr>
            </thead>
            <tbody>
        ";
        /*Format*/
        $total=0;
        foreach ($ops as $op) {
            $src=url()."/images/product/".$op->parent_id."/".$op->photo_1;
            $price=$op->order_price*$op->quantity;
            $total+=$price;
            $price="<b>".$currency."</b> ".number_format($price/100,2);
            $temp="
                <tr>
                <td style='border:none !important;'>
                <img class='img img-responsive img-op pull-left' src='".$src."' style='height:50px;width:50px;object-fit:containt;'>
                </td>
                <td style='border:none !important;'>".$op->quantity."</td>
                <td style='border:none !important;'><span class='pull-right'>".$price."</span></td>
            ";
            $ret.=$temp;
        }
        $total="".$currency." ".number_format($total/100,2);
        $ret.="
        <tr>
        <td></td>
        <td>Total: </td>
        <td>
        <span class='pull-right'><strong>".$total."</strong></span>
        </td>
        
        <tr>
        </tbody></table>
        ";
        return $ret;
    }
}
