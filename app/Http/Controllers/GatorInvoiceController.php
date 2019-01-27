<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Models\Product;
use App\Models\Station;
use App\Models\Receipt;
use App\Models\DeliveryOrder;
use App\Models\NdoID;
use App\Models\OrderProduct;
use App\Models\SOrder;
use App\Models\Sorderproduct;
use App\Models\POrder;
use Illuminate\Support\Facades\Session;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Emerchant;
use App\Models\User;
use App\Models\Wholesale;
use App\Models\Autolink;
use App\Models\Invoice;
use App\NPorderid;
use Mail;
use Carbon;

use DB;
use Auth;
use Log;

class GatorInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($receipt_id)
    {
        //
    }

    public function displayInvoice($receipt_id,$nporderid=null)
    {  
        $array_delivery = array();
        $currency = Currency::where('active','=',1)->first();
        $user_id = Auth::user()->id;
        $staffid=sprintf("%010d",$user_id);
        $merchant_name = '';
        $user_name = '';
        $user_address = '';
        $line2 = '';
        $line3 = '';
        $user_name = '';

		if(!empty($receipt_id)) {
			DB::table('porder')->
				where('id', $receipt_id)->
				update(['staff_user_id' => Auth::user()->id]);
		}

        $staff=DB::table("users")->
			where("id",$user_id)->
			select("first_name","last_name")->
			first();

        $staffname=$staff->first_name." ".$staff->last_name;

		$CompanyName=DB::table("merchant")->
        leftjoin('address','merchant.address_id','=','address.id')->
			where("merchant.user_id",$user_id)->
			select('merchant.id','merchant.address_id',
            'merchant.company_name',
            'merchant.gst',
            'merchant.business_reg_no',
            'address.line1',
            'address.line2',
            'address.line3',
            'address.line4')->first();
		Log::debug('------- CompanyName ------');
		Log::debug(json_encode($CompanyName));

        $PaidAmounts= DB::table('invoice')
            ->join('invoicepayment', 'invoice.id', '=', 'invoicepayment.invoice_id')
            ->leftJoin('bank', 'invoicepayment.bank_id', '=', 'bank.id')
            ->where('invoice.porder_id', $receipt_id)
            ->select('invoicepayment.amount as paidamount','invoice.status as paidstatus','bank.company_name as bankname','porder_id','invoicepayment.date_paid as paidDate','invoicepayment.method as paidmethod','invoicepayment.note as paidnote')
            ->orderBy('invoicepayment.created_at','DESC')
            ->get();

        $Porderdata = DB::table('porder')
            ->join('receipt','receipt.porder_id','=','porder.id')
            ->join('deliveryorder','receipt.id','=','deliveryorder.receipt_id')
			->select('porder.id','porder.user_id','porder.is_emerchant','porder.salesorder_no',
                'porder.status','deliveryorder.status as stats')->

			where('porder.id',$receipt_id)->first();
		Log::debug('------- Porderdata ------');
		Log::debug(json_encode($Porderdata));
       // $Porderdata = null;
        if(!empty($Porderdata)) {

            $post_code ='';
            $city = '';
            $state = '';

            if ($Porderdata->is_emerchant == 1) {
                $emerchantData = DB::table('emerchant')->
                where('id', $Porderdata->user_id)->first();

                //	if(count($emerchantData) >0){
                if (!empty($emerchantData)) {
                    $merchant_name = $emerchantData->first_name . ' ' .
                        $emerchantData->last_name;
                    $user_name = '';
                    $user_address = $emerchantData->address_line1;
                    $line2 = $emerchantData->address_line2;
                    $line3 = $emerchantData->address_line3;
                    $dealer_cname = $emerchantData->company_name;
                    $dealer_bizregno = $emerchantData->business_reg_no;
                    $post_code = $emerchantData->postcode;
                    $city = $emerchantData->city;
                    $state = $emerchantData->state;
                }
                Log::debug('***** emerchantData *****');
                Log::debug(json_encode($emerchantData));
            } else {
                /* This is Dealer/Buyer's details */
                $emerchantData = DB::table('merchant')
                    ->select('users.first_name', 'users.last_name', 'users.username',
                        'merchant.company_name', 'merchant.business_reg_no',
                        'address.line1', 'address.line2', 'address.line3',
                        'address.line4', 'address.city_id')
                    ->where('merchant.user_id', $Porderdata->user_id)
                    ->join('users', 'users.id', '=', 'merchant.user_id')
                    ->leftjoin('address', 'merchant.address_id', '=', 'address.id')
                    ->first();

                Log::debug('***** merchantData *****');
                Log::debug(json_encode($emerchantData));

                //   if(count($emerchantData) >0){
                if (!empty($emerchantData)) {
                    $merchant_name = $emerchantData->first_name . ' ' .
                        $emerchantData->last_name;
                    $user_address = $emerchantData->line1;
                    $line2 = $emerchantData->line2;
                    $line3 = $emerchantData->line3 . ' ' . $emerchantData->line4;
                    $user_name = $emerchantData->username;
                    $dealer_cname = $emerchantData->company_name;
                    $dealer_bizregno = $emerchantData->business_reg_no;
                }
            }

            $companyuser_address = '';
            $companyline2 = '';
            $companyline3 = '';

            if ($Porderdata->is_emerchant == 1) {
                $AddressData = DB::table('emerchant')->
                where('id', $Porderdata->user_id)->first();

                //    	if(count($AddressData) >0){
                if (!empty($AddressData)) {
                    $companyuser_address = $AddressData->address_line1;
                    $companyline2 = $AddressData->address_line2;
                    $companyline3 = $AddressData->address_line3;
                }

            } else {
                /* This is Merchant/Seller's details */
                $AddressData = DB::table('merchant')
                    ->select('users.first_name', 'users.last_name', 'users.username',
                        'merchant.company_name', 'merchant.business_reg_no',
                        'address.line1', 'address.line2', 'address.line3',
                        'address.line4', 'address.city_id')
                    ->where('merchant.user_id', $user_id)
                    ->join('users', 'users.id', '=', 'merchant.user_id')
                    ->join('address', 'merchant.address_id', '=', 'address.id')
                    ->first();

                Log::debug('***** AddressData *****');
                Log::debug(json_encode($AddressData));

                // if(count($AddressData) >0){
                if (!empty($AddressData)) {
                    $companyuser_address = $AddressData->line1;
                    $companyline2 = $AddressData->line2;
                    $companyline3 = $AddressData->line3 . ' ' . $AddressData->line4;
                    $merchant_bizregno = $AddressData->business_reg_no;
                }
            }


            $CreatedDate = DB::table('invoice')->
            where('porder_id', $Porderdata->id)->first();

            $merchant_id = DB::table('merchant')->
            where('user_id', $user_id)->
            pluck('id');

            Log::debug('merchant_id=' . $merchant_id);

            $station = DB::table('station')->
            select('id')->
            where('user_id', $Porderdata->user_id)->
            first();

            Log::debug('$Porderdata->user_id=' . $Porderdata->user_id);
            Log::debug('$Porderdata->Status=' . $Porderdata->status);

            Log::debug('***** station *****');
            Log::debug(json_encode($station));
            if (!empty($station)) {
                $stationtermData = DB::table('stationterm')->
                select('term_duration', 'credit_limit')->
                where('station_id', $station->id)->
                where('creditor_user_id', $user_id)->
                first();
            }

            // $invoicepaymentData = DB::table('invoice')
            // ->join('invoicepayment', 'invoice.id', '=', 'invoicepayment.invoice_id')
            // ->join('orderproduct', 'orderproduct.porder_id', '=', 'invoice.porder_id')
            // ->join('product', 'orderproduct.product_id', '=', 'product.id')
            // ->leftjoin('merchantproduct' ,'merchantproduct.product_id','=','product.parent_id')

            // ->leftjoin('merchant','merchantproduct.merchant_id','=','merchant.id')
            // ->where('merchant.id', $merchant_id)
            // //->where('invoice.payment' ,'!=' ,'full')
            // ->select(
            //         DB::raw("SUM(invoicepayment.amount )as newavailablebalance"),'invoice.payment')
            // ->groupBy('invoice.id')
            // ->get();

            $invoicepaymentData = "SELECT
			  invoice.*, SUM(invoicepayment.amount) as inamt
			FROM
			  invoice
			INNER JOIN
			  invoicepayment
			ON
			  invoice.id = invoicepayment.invoice_id
			AND
			  invoice.status != 'cancelled'
			WHERE
			  invoice.porder_id IN(
			  SELECT DISTINCT
				(orderproduct.porder_id)
			  FROM
				orderproduct
			  INNER JOIN
				product
			  ON
				orderproduct.product_id = product.id
			  LEFT JOIN
				merchantproduct
			  ON
				merchantproduct.product_id = product.parent_id
			  LEFT JOIN
				merchant
			  ON
				merchantproduct.merchant_id = merchant.id
			  WHERE
				merchant.id = $merchant_id
				-- GROUP BY  invoice.id 
			)";

            $dataPaymentNew = DB::select(DB::raw($invoicepaymentData));
           
            $availableBalance = DB::table('porder')
                ->join('orderproduct', 'orderproduct.porder_id', '=', 'porder.id')
                ->join('product', 'orderproduct.product_id', '=', 'product.id')
                ->join('merchantproduct', 'merchantproduct.product_id', '=', 'product.parent_id')
                ->leftjoin('merchant', 'merchantproduct.merchant_id', '=', 'merchant.id')
                ->where('merchant.id', $merchant_id)
                ->where('porder.status', '!=', 'cancelled')
                ->where('porder.user_id', $Porderdata->user_id)
                ->select(
//                   DB::raw("SUM((orderproduct.order_price*orderproduct.quantity) +
//					orderproduct.order_delivery_price) as order_price"),
//                    'porder.user_id','orderproduct.approved_qty','orderproduct.quantity','order_price as price','porder.id')
                 DB::raw("case when orderproduct.approved_qty IS NULL THEN
                    
                    SUM((orderproduct.order_price*orderproduct.quantity) + orderproduct.order_delivery_price)
                    ELSE  SUM((orderproduct.order_price*orderproduct.approved_qty) + orderproduct.order_delivery_price) END
                    as order_price"), 'porder.user_id')
                ->groupBy('orderproduct.id')
                ->orderBy('porder.created_at', 'desc')
                ->get();

            $total_purchase = 0;
            if (count($availableBalance) > 0) {
            foreach ($availableBalance as $ab){
                $total_purchase += $ab->order_price;
            }
                }
            $creditLimit = 0;
            $term_durations = 0;
            $availableCredit = 0;
            if (count($availableBalance) > 0) {
                if (!empty($stationtermData)) {
                    $creditLimit = $stationtermData->credit_limit;
                    $term_durations = $stationtermData->term_duration;
                    $availableCredit = $stationtermData->credit_limit - $total_purchase;
                    
                    if (!empty($invoicepaymentData[0])) {
                        $availableCredit += $dataPaymentNew[0]->inamt;
                    }
                }
            }
            $companyaddline3and4 = $CompanyName->line3;
            if(!empty($CompanyName->line4)){
                $companyaddline3and4 = $CompanyName->line3.' '.$CompanyName->line4;
            }
            array_push($array_delivery, [
                'merchant_name' => (empty($merchant_name)) ? "" : $merchant_name,
                'merchant_bizregno' => $CompanyName->business_reg_no,
                'muser' => '',
                'mbiz' => '',
                'postcode' => $post_code,
                'city' => $city,
                'state' => $state,
                'password' => '',
                'muser_address' => $companyuser_address,
                'mline1' => $CompanyName->line1,
                'mline2' =>  $CompanyName->line2,
                'mline3' =>  $companyaddline3and4,
                'user_name' => $user_name,
                'dealer_cname' => (empty($dealer_cname)) ? "" : $dealer_cname,
                'dealer_bizregno' => (empty($dealer_bizregno)) ? "" : $dealer_bizregno,
                'user_address' => $user_address,
                'line2' => $line2,
                'line3' => $line3,
                'merchantrecno' => '',
                'status' => 'Active',
                'orderdate' => '',
            ]);

            $SalesOrderNo = $Porderdata->salesorder_no;
            $nporderid = DB::table('nporderid')->
            where('porder_id', $receipt_id)->
            pluck('nporder_id');

            /* Test for unregistered emerchants */
            if (empty($stationtermData)) {
                $stationtermData = null;
            }



            return [
                'PaidAmounts' => $PaidAmounts,
                'currency' => $currency,
                'array_delivery' => $array_delivery,
                'receipt_id' => $receipt_id,
                'SalesOrderNo' => $SalesOrderNo,
                'Staffid' => $staffid,
                'StationtermData' => $stationtermData,
                'CreatedDate' => $CreatedDate,
                'availableCredit' => $availableCredit,
                'StaffName' => $staffname,
                'CompanyName' => $CompanyName,
                'nporderid' => $nporderid,
                'creditLimit' => $creditLimit,
                'term_durations' => $term_durations,
                'status' => $Porderdata->status,
                'stats' => $Porderdata->stats
            ];
        }else{
            return back();

        }
    }

    public function invoice(Request $request)
    {
        if ($request->user_id==null) {
            $user_id = Auth::user()->id;
		} else{
            $user_id= $request->user_id;
        }
         
        if ($request->isbuyer=="") {
            return 0;
        }
       
        $productsrequest =   $request->product;
        $productsrequest = array_filter($productsrequest,function($value){
            return $value>0;
        });
        $counproduct =  array_sum($productsrequest);
        //echo "Count Product" .$counproduct. "\n";

       // $salesorder_no = POrder::where('user_id', '=', $user_id);

        $order = new POrder;
        if ($counproduct>0) {
            if ($request->isbuyer==0) {
                $merchant = $request->setbuyer;
                $merchant_user_id = Merchant::where('id','=',$merchant)->pluck('user_id');
                $invoice_no = Merchant::where('id','=',$merchant)->
                max('invoice_no');
                $deliveryorder_no = Merchant::where('id','=',$merchant)->
                max('deliveryorder_no');
            } else{

                $merchant_user_id = $request->setbuyer;
                $order->is_emerchant = 1;
                $invoice_no = DB::table('emerchant')->where('id','=',$merchant_user_id)->
                max('invoice_no');
                  $deliveryorder_no = DB::table('emerchant')
                    ->where('id',$merchant_user_id)->max('deliveryorder_no');
            }

            //$s_no = Merchant::where('user_id', '=', $user_id)->max('salesorder_no');
            //$order->salesorder_no = $s_no+1;
           /** Merchant::where('user_id', '=', $user_id)->update([
                'salesorder_no'=> $s_no+1
            ]);
**/

            $order->user_id = (int) $merchant_user_id;
            $order->logistic_id = NULL;
            $order->courier_id    = 0;
            $order->payment_id    = 0;
            $order->order_administration_fee    = NULL;
            $order->osmall_comm_percent    = 0;
            $order->smm_comm_percent    = 0;
            $order->log_comm_percent    = 0;
            $order->description    = NULL;
            $order->source    = "b2b";
            $order->status    = "completed";
            $order->delivery_mode    = "own";
            $order->cre_count    = 0;
            $order->mode    = "gator";
            $order->prev_m_approved    = "b-returning";
            $order->prev_completed    = "b-approved";

            if ($order->save()) {
                foreach ($productsrequest as $key => $value) {
                    $wholesaleprice  =  wholesale::where('product_id','=',$key)
                        ->where('unit','>=',$value)
                        ->where('funit','<=',$value)
                        ->pluck('price');

                    if(empty($wholesaleprice)){
                        $wholesaleprice  =  wholesale::where('product_id','=',$key)->
                            orderBy('id','desc')->
                            pluck('price');
                    }
                    
					$Orderproduct                          = new OrderProduct;
					$Orderproduct->porder_id               = $order->id;
					$Orderproduct->product_id              = $key;
					$Orderproduct->order_price             = $wholesaleprice;
					$Orderproduct->order_delivery_price    = 0;
					$Orderproduct->payment_gateway_fee     = 0;
					$Orderproduct->quantity                = $value;
					$Orderproduct->actual_delivery_price   = 0;
					$Orderproduct->shipping_cost           = 0;
					$Orderproduct->crereason_id            = 0;

					$Orderproduct->save();
                    Log::debug("Save to Orderproductqy");
                    if($Orderproduct->save()){
                        for($i =1; $i <= $value; $i++){
                            DB::table('orderproductqty')->insert(['orderproduct_id' => $Orderproduct->id,'qty_no' => $i]);
                        }
                    }

				}

//				$invoice_no = DB::table('invoice')->join('porder','porder.id','=','invoice.porder_id')
//                    ->where('porder.user_id',$merchant_user_id)->max('invoice_no');
              
				$invoice = new Invoice;
				$invoice->porder_id = $order->id;
				// $invoice->invoice_no = Invoice::max('invoice_no')+1;
				$invoice->invoice_no = $invoice_no + 1;
				$invoice->stationterm_id = 0;
				$invoice->status = $order->status;
				$invoice->direct = 1;
				$invoice->save();

                if ($request->isbuyer==0) {
                    $merchant = $request->setbuyer;

                     Merchant::where('id','=',$merchant)->update(['invoice_no' => $invoice_no + 1]);
                    Merchant::where('id','=',$merchant)->update(['deliveryorder_no' => $deliveryorder_no + 1]);

                } else{
                    $merchant_user_id = $request->setbuyer;
                    $order->is_emerchant = 1;
                   DB::table('emerchant')
                        ->update(['invoice_no' => $invoice_no + 1]);
                    DB::table('emerchant')
                        ->update(['deliveryorder_no' => $deliveryorder_no + 1]);
                }

				$receipt = Receipt::create([
				'porder_id'=> $order->id,
				'receipt_no'=> Receipt::max('receipt_no') +1
				]);
                $new_do_no = $deliveryorder_no + 1;
                Log::debug("This is the new DO_NO " . $new_do_no);
			   $new_do =  DeliveryOrder::create([
					'receipt_id'=> $receipt->id,
					'status'=>'inprogress',
					'source'=>'gator',
                    'deliveryorder_no' =>  $new_do_no,
					'merchant_id'=>
						Merchant::where('user_id','=',$user_id)->pluck('id')
				]);
				NdoID::updateOrCreate(['deliveryorder_id'=> $new_do->id],
                    ['ndeliveryorder_id'=> UtilityController::generaluniqueid(
							$new_do->id, '3', '1',
							$new_do->created_at,
							'ndeliveryorderid',
							'ndeliveryorder_id'
						),
                    ]);
				$newpoid = UtilityController::generaluniqueid($order->id,
					'1','1', $order->created_at, 'nporderid', 'nporder_id');

				$nporder = DB::table('nporderid')->insert(['nporder_id'=>$newpoid,
					'porder_id'=>$order->id,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')]);

				if($nporder) {
					$nporderid = $newpoid;
				}
			}
		}


		$InvoicedisplayData = $this->displayInvoice($order->id,$nporderid);
		return view('seller.gator.directinvoice')->
			with([
				'InvoiceDisplayData' => $InvoicedisplayData,
				'OrderId' => $order->id,

				'NPorderid' => $nporderid]);
	}

    public function deleteInvoiceRecord(Request $request){
        //Get the Porder ID
         $porder_id =  $request['id'];
        Log::debug("product.parent_id=" . $porder_id);
        //Find the related table
        $model =POrder::find( $porder_id );

        //if table exists
        if($model){
            $delivered = DB::table('deliveryorder')->select('deliveryorder.status')
                ->join('receipt','deliveryorder.receipt_id','=','receipt.id')
                ->join('porder','receipt.porder_id','=','porder.id')
                ->whereIn('deliveryorder.source',['gator','jaguar','imported'])
                ->where('porder.id',$porder_id)
                ->first();
           //Change Status
            if($delivered){
                if ($delivered->status == 'completed'){
                    Log::debug('DO status' . $delivered->status);
                    return 2;
                }elseif($delivered->status == 'cancelled'){
                    Log::debug('DO status' . $delivered->status);
                    return 3;
                }
                else{
                    $model->status = 'cancelled';
                    $model->save();

                    //Check for related Order table
                    // $orders = DB::table('orderproduct')->where('porder_id',$porder_id)->update(['status' => 'cancelled']);
                    // status change to "cancelled" for invoice table
                    // $invoiceorders = DB::table('invoice')->where('porder_id',$porder_id)->update(['status' => 'cancelled']);

                    $invoice = DB::table('invoice')->where('porder_id',$porder_id)->first();

                    $products_pos = DB::table('orderproduct')->join('product','product.id','=','orderproduct.product_id')->
                    select('orderproduct.id as opid','orderproduct.approved_qty','orderproduct.quantity','orderproduct.order_price')
                        ->where('porder_id',$porder_id)->get();

                    $total_owned = 0;

                    foreach($products_pos as $products_poses){
                        $opqs = DB::table('orderproductqty as opq')->leftjoin('orderproductwarranty as opw','opq.id','=','opw.orderproductqty_id')
                            ->select('opw.serial_used','opw.warranty_used','opw.id as opwid')
                            ->where('opq.orderproduct_id',$products_poses->opid)->get();

                        foreach ($opqs as $opq) {
                            if($opq->serial_used == 1){
                                DB::table('orderproductwarranty')->where('id',$opq->opwid)->update(['serial_used' => 0]);
                            }else if($opq->warranty_used == 1){
                                DB::table('orderproductwarranty')->where('id',$opq->opwid)->update(['warranty_used' => 0]);
                            }
                        }
                        if(is_null($products_poses->approved_qty)){
                            $total_owned += ($products_poses->order_price/100)*$products_poses->quantity;
                        }else{
                            $total_owned += ($products_poses->order_price/100)*$products_poses->approved_qty;
                        }
                    }

                    $totalBalance = $total_owned * 100;
                    DB::table('invoicepayment')->insert(['invoice_id'=>$invoice->id,'amount'=>$totalBalance ,
                        'date_paid'=>date('Y-m-d H:i:s'),'method'=>'offset','note'=>'Offset due to cancellation','created_at'=>date('Y-m-d H:i:s'), 'updated_at'=> date('Y-m-d H:i:s')]);

                    $orders = DB::table('orderproduct')->where('porder_id',$porder_id)->update(['status' => 'cancelled']);

                    $invoiceorders = DB::table('invoice')->where('id',$invoice->id)->update(['status'=>'cancelled']);

                    //status change to "cancelled" for deliveryorder table
                    $dodelete = DB::table('receipt')
                        ->join('deliveryorder','deliveryorder.receipt_id','=','receipt.id')
                        ->select('deliveryorder.status')
                        ->where('receipt.porder_id',$porder_id)
                        ->update(['deliveryorder.status' => 'cancelled']);

                    if($orders && $invoiceorders){

                        return 1;
                    }

                }
            }else{
                return 0;
            }


        }else{
           return 0;
        }
    }


    public function checkCreaditLimit(Request $request)
    {
        $merchant = $request->buyerid;
        $is_buyer = $request->is_buyer;
        $SelectedProductTotalprice = $request->SelectedProductTotalprice;
        $message = '';
        $status = true;
        if($is_buyer == 0){
            $merchant_user_id = Merchant::where('id','=',$merchant)->pluck('user_id');
           
            $user_id = Auth::user()->id;
             
            $merchant_id= DB::table('merchant')->
                        where('user_id',$user_id)->
                        pluck('id');

            $CreditavailableBalance = DB::table('porder')
            // ->Leftjoin('station','station.user_id','=','porder.user_id')
            ->join('orderproduct', 'orderproduct.porder_id', '=', 'porder.id')
            ->join('product', 'orderproduct.product_id', '=', 'product.id')
            // ->join('invoice', 'invoice.porder_id', '=', 'porder.id')
            // ->leftjoin('users','users.id','=','porder.user_id')
            // ->leftjoin('emerchant','emerchant.id','=','porder.user_id')
            // ->join('merchantproduct' ,'merchantproduct.product_id','=','orderproduct.product_id')
            ->join('merchantproduct' ,'merchantproduct.product_id','=','product.parent_id')
            ->leftjoin('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->where('merchant.id', $merchant_id)
            ->where('porder.status', '!=','cancelled')
            ->where('porder.user_id',$merchant_user_id)
            // ->whereRaw('NOW() > DATE_ADD(porder.created_at,INTERVAL ' . $globals->buyer_cancellation_window . ' MINUTE)')
            ->select(
                //'orderproduct.order_price',
				// 'porder.id as porderid',
				// 'porder.mode as status',
				// 'porder.created_at',
				// 'porder.user_id AS station_id',
                 // 'porder.is_emerchant',
                 // 'orderproduct.quantity',
				// DB::raw("IF(porder.is_emerchant = '1', CONCAT(emerchant.first_name,' ',emerchant.last_name),CONCAT(users.first_name,' ',users.last_name)) as name"),
				DB::raw("SUM((orderproduct.order_price*orderproduct.quantity) + orderproduct.order_delivery_price) as order_price"),
				'porder.user_id')
            ->groupBy('porder.user_id')
            ->orderBy('porder.created_at','desc')
            ->get();
          
			Log::debug('***** CreditavailableBalance *****');
			Log::debug($CreditavailableBalance);
			Log::debug('user_id='.$user_id);
			Log::debug('merchant_user_id='.$merchant_user_id);

           
			Log::debug('***** merchant_user_id='.$merchant_user_id.' *****');
            $station = DB::table('station')->
				select('id')->
				where('user_id',$merchant_user_id)->
				first();
           
            $stationtermData = array();
            if (!empty($station)) {
              
				$stationtermData = DB::table('stationterm')->
					select('term_duration','credit_limit')->
					where('creditor_user_id',$user_id)->
					where('station_id',$station->id)->first();
                   
			} else {
                
				Log::info('***** $station is empty() *****');
				$message = '<h3>Merchant is not defined properly. Please contact OpenSupport.</h3>';
				$status = false;
			}
             $availableCreditblance = 0;   
			if (!empty($stationtermData)) {
                if(count($CreditavailableBalance) == 0){
                // // if(empty($CreditavailableBalance[0])){
                //     

                    $availableCreditblance = $stationtermData->credit_limit;
                    
                }else{
                   
                    $availableCreditblance = $stationtermData->credit_limit - $CreditavailableBalance[0]->order_price;
                    					Log::info('order_price='.$CreditavailableBalance[0]->order_price);
                }
                Log::info('credit_limit='.$stationtermData->credit_limit);
                Log::info('availableCreditblance='.$availableCreditblance);
           }
                
			//	if (count($stationtermData) == 0){
            if(empty($stationtermData)){

					$message = '<h3>Merchant does not have Credit Limit defined.
						<br>Please define it prior to ordering products</h3>';
					$status = false;
				}else if ($stationtermData->credit_limit == 0){

					$message = '<h3>Merchant\'s credit limit is ZERO.<br>
						Please increase credit limit</h3>';
					$status = false;

				} else if ( $availableCreditblance <= 0 ||  $availableCreditblance < $SelectedProductTotalprice){
					$message = '<h3>Merchant\'s credit limit is insufficient.
						<br>Please increase credit limit</h3>';
					$status = false;
				} else {
                    Log::info('***** $stationtermData PASSES VALIDATION *****');
                    Log::info('***** status='.$status.' *****');
                    
				}
//             } else {
// echo "main else";
// 				// Log::info('***** $stationtermData is empty() *****');
// 				// $message = '<h3>Merchant does not have Credit Limit defined.
// 				// 	<br>Please define it prior to ordering products</h3>';
// 				// $status = false;
// 			}
        }  
			return response()->json(
			array("message" => $message,
			"status" => $status));
    }
    public function calculateInvoiceAmount($productsrequest)
    {    
        $totalProductPrice = 0;
        foreach ($productsrequest as $key => $value) {
           
            $wholesaleProductprice  =  wholesale::where('product_id','=',$key)
                ->where('unit','>=',$value)
                ->where('funit','<=',$value)
                ->pluck('price');

            if(empty($wholesaleProductprice)){
                $wholesaleProductprice  =  wholesale::where('product_id','=',$key)->
                    orderBy('id','desc')->
                    pluck('price');
            }

           $value = (int)$value;
            Log::debug("Type Of Initial".(gettype($value)));
            $totalProductPrice += ($wholesaleProductprice * $value);
        }
        return $totalProductPrice;
    }
}
