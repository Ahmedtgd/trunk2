<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\POrder;
use App\Models\OrdertProduct;
use App\Models\ReturnOfGood;
use App\Models\MerchanttProduct;
use App\Models\Merchant;
use App\Models\CreditNote;
use App\Models\Globals;
use App\Models\Currency;
use App\Models\User;
use Session;
use DB;
use Log;
use App\Models\DeliveryOrder;
use App\Models\Sorderproduct;
use App\NPorderid;
use Auth;
use PDF;
use Input;
class CreditNoteController extends Controller
{
    public function creditnote()
    {
        $user_id =  Auth::user()->id;
        $merchant_id = Merchant::where('user_id',$user_id)->first();
        $month=(int)Request::input('month');
        $emonth=(string)$month+1;
        $smonth=(string)$month;
        $year=Request::input('year');
        $id = Request::input('user_id');
        $fromDate=$year."-".$smonth.'-01';
        if($emonth == 13){
            $toDate=$year."-12-31";
        }else{
            $toDate=$year."-".$emonth."-01";
        }


        $creditnote =  CreditNote::join('orderproductreturn', 'creditnote.return_of_goods_id', '=', 'orderproductreturn.id')
            ->join('orderproductqty','orderproductreturn.orderproductqty_id','=','orderproductqty.id')
            ->join('orderproduct','orderproduct.id','=','orderproductqty.orderproduct_id')
            ->join('porder','porder.id','=','orderproduct.porder_id')
            ->leftjoin('emerchant','emerchant.id','=','porder.user_id')
            ->leftjoin('merchant','merchant.user_id','=','porder.user_id')
            // ->leftjoin('invoice', 'invoice.porder_id', '=', 'porder.id')
            ->where('porder.staff_user_id', $user_id)
            //->where('creditnote.status', '=', 'approved')
            ->whereBetween('creditnote.created_at',[$fromDate,$toDate])
            ->orderBy('creditnote.created_at', 'desc')
            ->groupBy('orderproduct.id')
            ->get([
                'creditnote.id',
                'emerchant.company_name as e_comp_name',
                'merchant.company_name as comp_name',
                'porder.id as pid',
                'creditnote.creditnote_no',
                'creditnote.created_at',
            ]);
      //  dd($creditnote);
        $creditnote2 =  CreditNote::join('orderproductreturn', 'creditnote.return_of_goods_id', '=', 'orderproductreturn.id')
            ->join('orderproductqty','orderproductreturn.orderproductqty_id','=','orderproductqty.id')
            ->join('orderproduct','orderproduct.id','=','orderproductqty.orderproduct_id')
            ->join('porder','porder.id','=','orderproduct.porder_id')
            // ->leftjoin('invoice', 'invoice.porder_id', '=', 'porder.id')
            ->where('porder.staff_user_id', $user_id)
            //->where('creditnote.status', '=', 'approved')
            ->whereBetween('creditnote.created_at',[$fromDate,$toDate])
            ->orderBy('creditnote.created_at', 'desc')
            ->get([
                'creditnote.id',
                'creditnote.creditnote_no',
                'creditnote.created_at',
                'orderproduct.order_price as price'
            ]);

        foreach ($creditnote as $cn){
            $price = 0;
            foreach ($creditnote2 as $cn2){
                if($cn->creditnote_no == $cn2->creditnote_no){
                    $price += $cn2->price;
                }
            }
            $cn->price = $price;
        }

        $creditnotetable = view('seller.credit_note_views.return_creditnote_ajax',compact('creditnote',$creditnote))->render();

        return $creditnotetable;
    }

    public function credit_note_dealer()
    {
        $user_id =  Auth::user()->id;
        $merchant_id = Merchant::where('user_id',$user_id)->first();
        $month=(int)Request::input('month');
        $emonth=(string)$month+1;
        $smonth=(string)$month;
        $year=Request::input('year');
        $id = Request::input('user_id');
        $fromDate=$year."-".$smonth.'-01';
        if($emonth == 13){
            $toDate=$year."-12-31";
        }else{
            $toDate=$year."-".$emonth."-01";
        }


        $creditnote =  CreditNote::join('orderproductreturn', 'creditnote.return_of_goods_id', '=', 'orderproductreturn.id')
            ->join('orderproductqty','orderproductreturn.orderproductqty_id','=','orderproductqty.id')
            ->join('orderproduct','orderproduct.id','=','orderproductqty.orderproduct_id')
            ->join('porder','porder.id','=','orderproduct.porder_id')
            ->leftjoin('emerchant','emerchant.id','=','porder.user_id')
            ->leftjoin('merchant','merchant.user_id','=','porder.user_id')
            // ->leftjoin('invoice', 'invoice.porder_id', '=', 'porder.id')
            ->where('porder.user_id', $user_id)
            //->where('creditnote.status', '=', 'approved')
            ->whereBetween('creditnote.created_at',[$fromDate,$toDate])
            ->orderBy('creditnote.created_at', 'desc')
            ->groupBy('orderproduct.id')
            ->get([
                'creditnote.id',
                'emerchant.company_name as e_comp_name',
                'merchant.company_name as comp_name',
                'porder.id as pid',
                'creditnote.creditnote_no',
                'creditnote.created_at',
            ]);
        //  dd($creditnote);
        $creditnote2 =  CreditNote::join('orderproductreturn', 'creditnote.return_of_goods_id', '=', 'orderproductreturn.id')
            ->join('orderproductqty','orderproductreturn.orderproductqty_id','=','orderproductqty.id')
            ->join('orderproduct','orderproduct.id','=','orderproductqty.orderproduct_id')
            ->join('porder','porder.id','=','orderproduct.porder_id')
            // ->leftjoin('invoice', 'invoice.porder_id', '=', 'porder.id')
            ->where('porder.user_id', $user_id)
            //->where('creditnote.status', '=', 'approved')
            ->whereBetween('creditnote.created_at',[$fromDate,$toDate])
            ->orderBy('creditnote.created_at', 'desc')
            ->get([
                'creditnote.id',
                'creditnote.creditnote_no',
                'creditnote.created_at',
                'orderproduct.order_price as price'
            ]);

        foreach ($creditnote as $cn){
            $price = 0;
            foreach ($creditnote2 as $cn2){
                if($cn->creditnote_no == $cn2->creditnote_no){
                    $price += $cn2->price;
                }
            }
            $cn->price = $price;
        }

        $creditnotetable = view('seller.credit_note_views.return_creditnote_ajax',compact('creditnote',$creditnote))->render();

        return $creditnotetable;
    }
	/*public function returnGoods()
	{

		$user_id   = Auth::user()->id; 
		$orderlist = POrder::where('user_id',$user_id)->where('mode','=','term')->get();
		$returnGoodsTable = view('seller.credit_note_views.return_goods_ajax',compact('orderlist',$orderlist))->render();

		return $returnGoodsTable;
		
	}*/

	public function returnStatus()
	{

		$station_id     = Auth::user()->id;
		//$station_id     = 487;

		$returnofgoodrequest = ReturnOfGood::where('station_id' ,'=',		$station_id)
		->join('ordertproduct','ordertproduct.id'				,'=',		'return_of_goods.order_tproduct_id')
		->join('tproduct','tproduct.id'							,'=',		'ordertproduct.tproduct_id')
		->join('creditnote','creditnote.return_of_goods_id'		,'=',		'return_of_goods.id')
		->select('creditnote.status as status',
			'creditnote_no as c_no',
			'return_of_goods.id as return_of_goods_id',
			'return_of_goods.order_tproduct_id as order_tproduct_id',
			'return_of_goods.quantity as quantity',
			'return_of_goods.station_id as station_id',
			'return_of_goods.merchant_id as merchant_id',
			'return_of_goods.returnofgoods_no as returnofgoods_no',
			'tproduct.name as name')->get();
		

		$returnGoodsTable = view('seller.credit_note_views.return_status_ajax',compact('returnofgoodrequest',$returnofgoodrequest))->render();
		return $returnGoodsTable;
	}

	public function returnMerchantAproval()
	{
		$currency = Currency::where('active','=',1)->first();
		$user     = Auth::user()->id;
		$merchant = Merchant::where('user_id','=',$user)->first();

		$returnofgoodrequest = ReturnOfGood::where('merchant_id'		,'=',		$merchant->id)
		->join('creditnote','creditnote.return_of_goods_id'				,'=',		'return_of_goods.id')
		->where('creditnote.status'										,'=',		'Pending')
		->join('users as stationuser','return_of_goods.station_id'		,'=',		'stationuser.id')
		->join('station','return_of_goods.station_id'					,'=',		'station.user_id')
		->join('merchant','return_of_goods.merchant_id'					,'=',		'merchant.id')
		->join('address','address.id'									,'=',		'merchant.address_id')
		->join('address as stationaddress','station.address_id'			,'=',		'stationaddress.id')
		->join('ordertproduct','ordertproduct.id'						,'=',		'return_of_goods.order_tproduct_id')
		->join('nporderid','ordertproduct.porder_id'						,'=',		'nporderid.porder_id')
		->join('tproduct','tproduct.id'									,'=',		'ordertproduct.tproduct_id')
		->join('ntproductid','tproduct.id'								,'=',		'ntproductid.tproduct_id')
		
		//->select()
		//->distinct('creditnote_no')
		->get(
			[
				'creditnote.status as status',
				'creditnote.creditnote_no as creditnote_no',
				'creditnote.id as creditnote_id',
				'return_of_goods.order_tproduct_id as order_tproduct_id',
				'return_of_goods.quantity as quantity',
				'return_of_goods.station_id as station_id',
				'return_of_goods.merchant_id as merchant_id',
				'tproduct.name as name',
				'creditnote.created_at as created_at',
				'stationuser.first_name as station_first_name',
				'stationuser.last_name as station_last_name',
				'tproduct.description as description',
				'ordertproduct.order_price as order_price',
				'ntproductid.ntproduct_id as productid',
				'nporderid.nporder_id as porder_id',
				'address.line1 as line1',
				'address.line2 as line2',
				'address.line3 as line3',
				'address.line4 as line4',
				'stationaddress.line1 as stationline1',
				'stationaddress.line2 as stationline2',
				'stationaddress.line3 as stationline3',
				'stationaddress.line4 as stationline4',
				'merchant.gst as gst'
			]
		);
		

		$returnGoodsTable = view('seller.credit_note_views.return_merchant_approval_ajax',compact('returnofgoodrequest',$returnofgoodrequest),compact('currency',$currency))->render();
		return $returnGoodsTable;
	}

	public function returnordertproduct()
	{
		$user_id   = Auth::user()->id; 
		$ordertproductlist =   OrdertProduct::join('porder','ordertproduct.porder_id','=','porder.id')
		->where('porder.user_id'						,'=',		$user_id)
		->where('mode'									,'=',		'term')
		->join('tproduct','tproduct.id'					,'=',		'ordertproduct.tproduct_id')
		->join('ntproductid','tproduct.id'				,'=',		'ntproductid.tproduct_id')
		->get([
			'tproduct.id as t_id' ,
			'tproduct.name as name',
			'ordertproduct.id as ordertproductid',
			'ordertproduct.quantity as quantity',
			'tproduct.description as description',
			'ordertproduct.order_price as order_price',
			'ordertproduct.quantity as qty',
			'ntproductid.ntproduct_id as ntproduct_id',
			//'ntproductid.tproduct_id as tproduct_id'
		])
		->groupBy('t_id');
		
		    foreach ($ordertproductlist as $key => $value) {
		    	$data[$key] = $value->groupBy('order_price');
		    }

		    /*foreach ($data as $key => $value) {

			foreach ($value as $k => $val) {
                     return $val[$key]->tproduct_id; 
                    $p_price = number_format($price/100,2);
                }
            }*/



            $currency = Currency::where('active','=',1)->first();
            $tableorderdproducts = view('seller.credit_note_views.return_ordertproductlist_ajax',compact('data'),compact('currency',$currency))->render();

            return $tableorderdproducts;
        }

        public function returnquantity(Request $request)
        {




        	if (!$request->has('product')) {
        		Session::flash('error','Please Select atleast one product');
        		return redirect()->back();
        	}
        	$products = $request->product;

        	foreach ($products as $key => $value) {

        		$creditnote_no = CreditNote::orderBy('id','desc')->first();
        		if ($creditnote_no) {
        			$sequence_no = $creditnote_no->creditnote_no;
        			$sequence_no = ++$sequence_no;
        			$sequence_no = str_pad($sequence_no,10,'0',STR_PAD_LEFT);
        		}
        		else{
        			$global = Globals::first();
        			$sequence_no = $global->creditnote_sequence;
        			$sequence_no = ++$sequence_no;
        			$sequence_no = str_pad($sequence_no,10,'0',STR_PAD_LEFT);
        		}

        		$returnofgoods_no = ReturnOfGood::orderBy('id','desc')->first();
        		if ($returnofgoods_no) {
        			$rog_sequence_no = $returnofgoods_no->returnofgoods_no;
        			$rog_sequence_no =++$rog_sequence_no;
        			$rog_sequence_no = str_pad($rog_sequence_no,10,'0',STR_PAD_LEFT);

        		}
        		else{
        			$global = Globals::first();
        			$rog_sequence_no = $global->returnofgoods_no;
        			$rog_sequence_no =++$rog_sequence_no;
        			$rog_sequence_no = str_pad($rog_sequence_no,10,'0',STR_PAD_LEFT);
        		}


        		$ordertproduct  = OrdertProduct::select('ordertproduct.tproduct_id')->where('id',$key)->first();
        		$merchantid     = MerchanttProduct::where('tproduct_id','=',$ordertproduct->tproduct_id)->select('merchant_id')->first();

        		$station_id     = Auth::user()->id; 
        		$returnofgoods  = new ReturnOfGood();
        		$returnofgoods->order_tproduct_id = $key;
        		$returnofgoods->quantity    = $request->productqty[$key];
        		$returnofgoods->station_id    = $station_id;
        		$returnofgoods->merchant_id =  $merchantid->merchant_id;
        		$returnofgoods->returnofgoods_no =  $rog_sequence_no;
        		if ($returnofgoods->save()) {

        			$creditnote = new CreditNote();
        			$creditnote->creditnote_no = $sequence_no;
        			$creditnote->return_of_goods_id = $returnofgoods->id;
        			$creditnote->quantity = $returnofgoods->quantity;
        			$creditnote->status   =	"Pending";
        			$creditnote->save();

        		}

        		return redirect()->back();
        	}
        }
        public function updatereturnproductstatus($creditnote_id,$status)
        {

        	$creditnote = CreditNote::where('creditnote.id','=',$creditnote_id)
        	->join('return_of_goods','return_of_goods.id','=','creditnote.return_of_goods_id')->select('creditnote.*','return_of_goods.quantity as returnofgoodsqty')->first();
        	$creditnote->quantity = $creditnote->returnofgoodsqty;
        	$creditnote->status = $status;

        	if ($creditnote->save()) {
        		return "Status Updated to ".$status;
        	}
        }
        public function creditnotedocument($id, $cid)
        {
            if(!empty($id)) {
                DB::table('porder')->
                where('id', $id)->
                update(['staff_user_id' => Auth::user()->id]);
            }
            
            $merchant = POrder::join('orderproduct','orderproduct.porder_id','=',
                'porder.id')->
            join('product','product.id','=','orderproduct.product_id')->
            join('merchantproduct','merchantproduct.product_id','=',
                'product.parent_id')->
            join('merchant','merchantproduct.merchant_id','=','merchant.id')->
            leftjoin('address','merchant.address_id','=','address.id')->
            join('users','merchant.user_id','=','users.id')->
            join('nbuyerid','nbuyerid.user_id','=','merchant.user_id')->
            where('porder.id','=',$id)->
            first([
                'merchant.id',
                'merchant.company_name',
                'merchant.gst',
                'merchant.business_reg_no',
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
                'users.first_name',
                'users.last_name',
                'porder.staff_user_id as staff_id',
                'nbuyerid.nbuyer_id as user_id',
                'porder.created_at',
                'porder.updated_at',
                'porder.salesorder_no',
                'porder.user_id'
            ]);

            $staff = User::find(Auth::user()->id);
            $merchant->staff_id   = sprintf("%010d", $staff->id);
            $merchant->first_name = $staff->first_name;
            $merchant->last_name  = $staff->last_name;

            Log::debug('****** $merchant *****');
            Log::debug($merchant);

            $emerchant = POrder::where('porder.id','=',$id)->pluck('is_emerchant');
            Log::debug('is_emerchant='.$emerchant);

            if ($emerchant) {
                Log::debug('*** $emerchant=TRUE ***');
                Log::debug('$merchant->user_id='.$merchant->user_id);
                $buyeraddress = POrder::join('emerchant','emerchant.id','=',
                    'porder.user_id')->
                where('porder.id','=',$id)->
                first([
                    'emerchant.company_name',
                    'emerchant.business_reg_no',
                    'emerchant.address_line1 as line1',
                    'emerchant.address_line2 as line2',
                    'emerchant.address_line3 as line3',
                ]);
            } else {
                Log::debug('*** $emerchant=FALSE ***');
                Log::debug('$merchant->user_id='.$merchant->user_id);

                $buyeraddress = POrder::join('merchant','merchant.user_id','=',
                    'porder.user_id')->
                join('address','merchant.address_id','=','address.id')->
                join('users','merchant.user_id','=','users.id')->
                where('porder.id','=',$id)->
                where('merchant.user_id','=',$merchant->user_id)->
                first([
                    'merchant.company_name',
                    'merchant.business_reg_no',
                    'address.line1 as line1',
                    'address.line2 as line2',
                    'address.line3 as line3',
                    'address.line4 as line4',
//                'address.line3'.' '.'address.line4 as line3',
                    'users.first_name as first_name',
                    'users.last_name as last_name',
                ]);
            }

            Log::debug('******* $buyeraddress *******');
            Log::debug($buyeraddress);

            $invoice = POrder::join('orderproduct','orderproduct.porder_id','=',
                'porder.id')->
            join('nproductid','nproductid.product_id','=',
                'orderproduct.product_id')->
            join('product','orderproduct.product_id','=','product.id')
                ->join('orderproductqty','orderproductqty.orderproduct_id','=','orderproduct.id')
                ->join('orderproductreturn as orp','orp.orderproductqty_id','=','orderproductqty.id')
                ->join('invoice', 'invoice.porder_id', '=', 'porder.id')
                ->leftjoin('creditnote as cn','cn.return_of_goods_id','=','orp.id')
                ->leftjoin('orderproductreturnwarranty','orp.id','=','orderproductreturnwarranty.orderproductreturn_id')
                ->leftjoin('orderproductwarranty','orderproductreturnwarranty.orderproductwarranty_id','=','orderproductwarranty.id')
                ->where('orderproduct.porder_id',$id)
                ->where('cn.creditnote_no',$cid)
                ->groupBy('orp.id')
                ->orderby('orp.created_at','desc')->
                get([
                    'invoice.invoice_no',
                    'nproductid.nproduct_id',
                    'product.name',
                    'product.parent_id',
                    'product.id as prid',
                    'product.thumb_photo',
                    'orderproduct.order_price',
                    'cn.creditnote_no',
                    'porder.id'
                ]);
            $inv_no = $invoice[0]->invoice_no;


            $do = DeliveryOrder::where('merchant_id',$merchant->id)
                ->whereIn('deliveryorder.source',['gator','jaguar','imported'])
                ->join('ndeliveryorderid','deliveryorder.id','=','ndeliveryorderid.deliveryorder_id')
                ->leftjoin('receipt','receipt.id','=','deliveryorder.receipt_id')
                ->leftjoin('porder','receipt.porder_id','=','porder.id')
                ->where('porder.id', $id)
                ->leftjoin('fairlocation','fairlocation.id','=','deliveryorder.final_location_id')
                ->leftjoin("deliveryorderstockreport","deliveryorderstockreport.deliveryorder_id","=","deliveryorder.id")
                ->leftjoin("stockreport","stockreport.id","=","deliveryorderstockreport.stockreport_id")
                ->leftjoin('member', function ($join) {
                    $join->on('deliveryorder.member_id','=','member.id')
                        ->where('member.status','=','active');
                })->leftjoin('users as dlv', function ($join) {
                    $join->on('dlv.id','=','member.user_id');
                })
                ->orderby('deliveryorder.created_at','desc')
                //           ->first();
                ->first([
                    DB::raw('deliveryorder.*'),
                    'ndeliveryorderid.ndeliveryorder_id as ndid',
                    'deliveryorder.id as do_id',
                    'porder.id as porder_id'

                ]);

            Log::debug("***** Delivery Order *****");
            Log::debug("DO=".$do);


            $currency = Currency::where('active','=',1)->
            pluck('code');

            $nporder_id = NPorderid::where('porder_id','=',$id)->
            pluck('nporder_id');
        	return view('seller.credit_note_views.creditnotedocument')->
               with('merchant',$merchant)->
               with('id',$id)->
               with('do',$do)->
               with('buyeraddress',$buyeraddress)->
               with('invoice',$invoice)->
               with('inv_no',$inv_no)->
               with('currency',$currency)->
               with('nporder_id',$nporder_id);
        }
        public function returnofgoodsdocument($id)
        	{
        		$currency = Currency::where('active','=',1)->first();
        	$selluser = User::find(Auth::user()->id);
        	 $creditnote = CreditNote::where('creditnote.id','=',$id)
        	->join('return_of_goods','return_of_goods.id','=','creditnote.return_of_goods_id')
        	->join('users as stationuser','return_of_goods.station_id'	,'=',  'stationuser.id')
        	->join('station','return_of_goods.station_id'				,'=',  'station.user_id')
        	->join('merchant','return_of_goods.merchant_id'				,'=',  'merchant.id')
        	->join('address','address.id'								,'=',  'merchant.address_id')
        	->join('address as stationaddress','station.address_id'		,'=',  'stationaddress.id')
        	->join('ordertproduct','ordertproduct.id'					,'=',  'return_of_goods.order_tproduct_id')
        	->join('nporderid','ordertproduct.porder_id'				,'=',  'nporderid.porder_id')
        	->join('tproduct','tproduct.id'								,'=',  'ordertproduct.tproduct_id')
        	->join('ntproductid','tproduct.id'							,'=',  'ntproductid.tproduct_id')
        	->get(
        		[
        			'creditnote.status as status',
        			'return_of_goods.returnofgoods_no as creditnote_no',
        			'creditnote.id as creditnote_id',
        			'return_of_goods.order_tproduct_id as order_tproduct_id',
        			'return_of_goods.quantity as quantity',
        			'return_of_goods.station_id as station_id',
        			'return_of_goods.merchant_id as merchant_id',
        			'tproduct.name as name',
        			'creditnote.created_at as created_at',
        			'stationuser.first_name as station_first_name',
        			'stationuser.last_name as station_last_name',
        			'tproduct.description as description',
        			'ordertproduct.order_price as order_price',
        			'ntproductid.ntproduct_id as productid',
        			'nporderid.nporder_id as porder_id',
        			'address.line1 as line1',
        			'address.line2 as line2',
        			'address.line3 as line3',
        			'address.line4 as line4',
        			'stationaddress.line1 as stationline1',
        			'stationaddress.line2 as stationline2',
        			'stationaddress.line3 as stationline3',
        			'stationaddress.line4 as stationline4',
        			'merchant.gst as gst'
        		]
        	);
        	return view('seller.credit_note_views.returnofgoodsdocument',compact('selluser'))->with('returnofgoodrequest',$creditnote)->with('currency',$currency);
        	}
    }
