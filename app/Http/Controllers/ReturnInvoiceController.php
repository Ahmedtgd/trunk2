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


class ReturnInvoiceController extends Controller{

    public function inv_refund($receipt_id)
    {
        $currency = Currency::where('active','=',1)->first();
        $user_id = Auth::user()->id;
        $staff_id=sprintf("%010d",$user_id);

        $merchant = Merchant::where('user_id','=',$user_id)->first();
        //$merchant_id=$merchant->id;
        if(!empty($receipt_id)) {
            DB::table('porder')->
            where('id', $receipt_id)->
            update(['staff_user_id' => Auth::user()->id]);
        }

        $staff=DB::table("users")->
        where("id",$user_id)->
        select("first_name","last_name")->
        first();

        $staff_name=$staff->first_name." ".$staff->last_name;

        $porder_data = DB::table('porder')->
        select('id','user_id','is_emerchant','salesorder_no','status')->
        where('id',$receipt_id)->first();

        $invoice = DB::table('invoice')->
        where('porder_id',$receipt_id)->first();
        $products = DB::table('orderproduct')
            ->leftjoin('nproductid','nproductid.product_id','=','orderproduct.product_id')
            ->join('product','orderproduct.product_id','=','product.id')
            ->join('orderproductqty as opq', 'opq.orderproduct_id','=','orderproduct.id')
            ->leftjoin('orderproductreturn as orp','orp.orderproductqty_id','=','opq.id')
            ->leftjoin('orderproductwarranty','opq.id','=','orderproductwarranty.orderproductqty_id')
            ->join('receipt','receipt.porder_id','=','orderproduct.porder_id')
            ->join('deliveryorder','receipt.id','=','deliveryorder.receipt_id')

            ->where('orderproduct.porder_id',$receipt_id)
            ->where('opq.deleted_at', '=', NULL)
            ->select('product.id as pid',
                'product.name as pname',
                'product.parent_id',
                'product.thumb_photo',
                'orderproduct.id as opid',
                'orderproduct.created_at as return_option',
                'orderproductwarranty.serial_no as imeiNo',
                'orderproductwarranty.warranty_no as warrantyNo',
                'orderproduct.approved_qty','orderproduct.quantity','orderproduct.order_price',
                'nproductid.nproduct_id','orp.status','orp.note', 'orp.return_option',
                'opq.id as opqid',
                'deliveryorder.status as stats'
            )
            ->orderby('opq.id')->get();
        $inv = DB::table('invoice')->
        where('porder_id', $receipt_id)->first();
        $wholesaleprices = Product::join('wholesale','wholesale.product_id','=','product.id')
            ->join('merchantproduct','product.parent_id','=','merchantproduct.product_id')
            ->where('merchantproduct.merchant_id','=',$merchant->id)
            ->orderBy('wholesale.price','desc')
            ->get([
                'wholesale.funit',
                'wholesale.unit',
                'wholesale.price',
                'wholesale.product_id as id',
            ]);
        $return_completed = 0;
        if($inv){
            if(($inv->payment == 'offset') || ($inv->payment == 'full')){
                $return_completed = 1;
            }
        }
        //  $note = $products[0]->note;
        $disabled = '';
        $status = '';
        $exchanged = 0;
        $query="
            SELECT
            DISTINCT 
            pp.parent_id as tprid,
            product.id as id,
            product.id as prid,
            product.segment as segment,
            product.name as name,
            product.thumb_photo as thumb_photo,
            product.parent_id as parent_id,
            product.private_available as offlineProd,
            product.private_retail_price as offlinePrice,
            
            wholesale.price as retail_price,
            wholesale.id as wid,
            sum(locationproduct.quantity) as consignment_total,
            product.id as product_id,
            np.nproduct_id as nproductid

            FROM 
            product 
            join product parent on parent.id=product.parent_id
            join merchantproduct mp on mp.product_id=product.parent_id
            join nproductid np on np.product_id=product.id
            inner join (
                select parent_id ,MAX(created_at) as created_at
                from 
                product
                group by parent_id
            ) pp on pp.parent_id=product.parent_id AND pp.created_at=product.created_at
            left join wholesale on wholesale.product_id=product.id
             left join locationproduct on locationproduct.product_id=product.parent_id
             left join fairlocation on fairlocation.id=locationproduct.location_id
            
            WHERE
            mp.merchant_id=$merchant->id
            AND product.status != 'transferred'
            AND product.status != 'deleted'
            AND product.status !=''
            AND product.deleted_at IS NULL
            AND parent.status != 'transferred'
            AND parent.status != 'deleted'
            AND parent.status !=''
            AND parent.deleted_at IS NULL
            AND fairlocation.user_id =$user_id
            
            GROUP BY tprid
            ORDER BY offlineProd DESC
         
        ";
        $products_gator=DB::select(DB::raw($query));
        $porder_data = DB::table('porder')->
        select('id','user_id','is_emerchant','salesorder_no','status')->
        where('id',$receipt_id)->first();
        return view('seller.gator.inv_refund')->
        with(compact('staff_name','disabled','exchanged','note','status','wholesaleprices','user_id',
            'staff_id','invoice','products','products_gator','porder_data','return_completed'));
    }

    public function reject_return(Request $request){
        $data = $request->pTableData;
        $note = $request->notes;
        Log::debug("note=".$note);

        $tableData = json_decode($data,TRUE);
        for($i = 0; $i < count($tableData); $i++){
            $opid = $tableData[$i]['opid'];
            $stat =   $tableData[$i]['status'];
            $status = 'rejected';
            //$serial_no =  $tableData[$i]['serial_no'];
            if($stat != 'Approved'){
                DB::table('orderproductreturn')->where('orderproductqty_id', $opid)
                    ->update(['status' => $status, 'note' => $note]);
            }
        }
        return 1;
    }


    public function sub_dar(Request $request)
    {
        Log::debug("***** sub_dar() *****");

        $data = $request->pTableData;
        Log::debug(json_encode($data));


        $porder = $request->id;
        $note = $request->notes;
        Log::debug("porder_id=" . $porder);

        $invoice = DB::table('invoice')->
        where('porder_id', $porder)->first();

        if (empty($invoice)) {
            return 999;
        }
        //$notes_no = 0;
        $porder_table = DB::table('porder')->where('id', $porder)->first();
        if ($porder_table->is_emerchant == 1) {
            $note_no = DB::table('emerchant')
                ->where('id', $porder_table->user_id)->max('creditnote_no');

        } else {
            $note_no = DB::table('merchant')
                ->where('user_id', $porder_table->user_id)->max('creditnote_no');
        }

        $note_no = $note_no + 1;

        $tableData = json_decode($data, TRUE);

        $once = 0;
        for ($i = 0; $i < count($tableData); $i++) {
            $opid = $tableData[$i]['opid'];
            $pid = $tableData[$i]['prodID'];
            $rmk = $tableData[$i]['option'];
            $stat = $tableData[$i]['status'];
            $status = 'approved';

            if (($rmk != '') && ($stat == 'Return')) {

                if (($rmk == 'dx') || ($rmk == 'd') && ($once == 0)) {
                    Log::debug("hit this");
                    //  dd();
                    $exists = DB::table('orderproductreturn')->
                    where('orderproductqty_id', $opid)->first();

                    $new_porder = DB::table('porder')
                        ->where('user_id', $porder_table->user_id)
                        ->where('salesorder_no', $exists->return_invoice_id)->first();
                    Log::debug("New Porder ".$new_porder->id);
                    if (!empty($new_porder)) {
                        $do_table = DB::table('deliveryorder')->select('deliveryorder.id')
                            ->join('receipt', 'receipt.id', '=', 'deliveryorder.receipt_id')
                            ->join('porder', 'receipt.porder_id', '=', 'porder.id')
                            ->where('porder.id', $new_porder->id)->first();
                        Log::debug("DO table ". $do_table->id);
                        $delivery_order = DeliveryOrder::find($do_table->id);
                        $delivery_order->status = 'inprogress';
                        $delivery_order->action = 'issue';
                        //$delivery_order->member_id  = $request->member_id;

                        $new_user_id = Auth::user()->id;
                        $new_merchant_id = Merchant::where('user_id', $new_user_id)->pluck('id');

                        $deliveryId = DB::table('deliveryorder')
                            ->leftjoin('receipt', 'deliveryorder.receipt_id', '=', 'receipt.id')
                            ->leftjoin('invoice', 'invoice.porder_id', '=', 'receipt.porder_id')
                            ->select('deliveryorder.id as doid', 'invoice.invoice_no', 'receipt.porder_id')
                            ->where('deliveryorder.id', $do_table->id)
                            ->where('deliveryorder.merchant_id', $new_merchant_id)
                            ->first();


                        //if(count($deliveryId) > 0 && $deliveryId->invoice_no == ''){
                        if (!empty($deliveryId) && $deliveryId->invoice_no == '') {

                            //get invoice number
                            $new_merchant = DB::table('porder')
                                ->where('id', $deliveryId->porder_id)->first();
                            if ($new_merchant->is_emerchant == 1) {
                                $new_invoice_no = DB::table('emerchant')
                                    ->where('id', $new_merchant->user_id)->max('invoice_no');
                            } else {
                                $new_invoice_no = DB::table('merchant')
                                    ->where('user_id', $new_merchant->user_id)->max('invoice_no');
                            }

                            $new_invoice = new Invoice;
                            $new_invoice->porder_id = $deliveryId->porder_id;

                            //Invoice number increases here from the max
                            // $invoice->invoice_no = Invoice::max('invoice_no')+1;
                            $new_invoice->invoice_no = $new_invoice_no + 1;
                            //After increasing the invoice, update
                            if ($new_merchant->is_emerchant == 1) {
                                DB::table('emerchant')
                                    ->where('id', $new_merchant->user_id)->update(['invoice_no' => $new_invoice_no + 1]);
                            } else {
                                DB::table('merchant')
                                    ->where('user_id', $new_merchant->user_id)->update(['invoice_no' => $new_invoice_no + 1]);
                            }
                            $new_invoice->stationterm_id = 0;
                            $new_invoice->status = 'completed';
                            $new_invoice->direct = 0;
                            $new_invoice->save();

                            $once = 1;
                            if ($delivery_order->save()) {
                                Session::flash('success', 'Delivery Order has been issued');
                            } else {
                                Session::flash('error_message', 'Delivery Order can not be Issued');
                            }
                        }
                    }
                }

                $p_id = DB::table('nproductid')->
                where('nproduct_id', $pid)->first();

                $prod = DB::table('orderproduct')
                    ->join('orderproductqty', 'orderproductqty.orderproduct_id', '=', 'orderproduct.id')
                    ->where('orderproduct.porder_id', $porder)
                    ->where('orderproduct.product_id', $p_id->product_id)
                    ->where('orderproductqty.deleted_at', '=', NULL)
                    ->where('orderproductqty.id', $opid)->first();

                Log::debug("Order id " . $opid);
                Log::debug("Status " . $rmk);
                DB::table('orderproductreturn')->where('orderproductqty_id', $opid)
                    ->where('return_option', $rmk)
                    ->where('status', '=', 'return')
                    // ->whereNotIn([''])
                    ->update(['status' => $status, 'updated_at' => Carbon::now()]);

                DB::table('invoicepayment')->insert(['invoice_id' => $invoice->id,
                    'amount' => $prod->order_price, 'date_paid' => Carbon::now(), 'note' => 'Credit Note No: ' . sprintf('%010d', $note_no), 'method' => 'return']);
                //Get the last updated table in Orp
                $insert = DB::table('orderproductreturn')->where('orderproductqty_id', $opid)->first();
                Log::debug('Last inserted is ' . $insert->id);
                DB::table('creditnote')->insert(['creditnote_no' => $note_no, 'return_of_goods_id' => $insert->id, 'quantity' => 1,
                    'created_at' => Carbon::now()]);
            }
        }

        $odata = DB::table('orderproduct')->
        where('porder_id', $porder)->get();

        $total = 0;
        foreach ($odata as $opd) {
            $amount = $opd->quantity * ($opd->order_price);
            $total += $amount;
        }

        $inv = DB::table('invoice')->
        where('porder_id', $porder)->first();

        $pdata = DB::table('invoicepayment')->
        where('invoice_id', $inv->id)->get();

        $cash = DB::table('invoicepayment')->where('invoice_id', $inv->id)->where('method', 'cash')->get();
        $offset = DB::table('invoicepayment')->where('invoice_id', $inv->id)->where('method', 'return')->get();
        $cash_amt = 0;
        $offset_amt = 0;
        $paid = 0;

        foreach ($pdata as $ppd) {
            $amount = $ppd->amount;
            $paid += $amount;
        }
        foreach ($cash as $c) {
            $c_amount = $c->amount;
            $cash_amt += $c_amount;
        }
        foreach ($offset as $o) {
            $o_amount = $o->amount;
            $offset_amt += $o_amount;
        }
        $data = array();
        $data['balance'] = number_format(($total - $paid) / 100, 2);
        if (($total - $paid) == 0) {
            if ($paid == $offset_amt) {
                DB::table('invoice')->where('porder_id', $porder)->update(['payment' => 'offset']);
                $data['status'] = 'Offset';
            } else {
                DB::table('invoice')->where('porder_id', $porder)->update(['payment' => 'full']);
                $data['status'] = 'Full';
            }

        } else if (($total - $paid) > 0) {
            DB::table('invoice')->where('porder_id', $porder)->update(['payment' => 'partial']);
            $data['status'] = 'Partial';
        }
        $data['credit_note'] = $note_no;
        if ($porder_table->is_emerchant == 1) {
            DB::table('emerchant')
                ->where('id', $porder_table->user_id)->update(['creditnote_no' => $note_no]);

        } else {
            DB::table('merchant')
                ->where('user_id', $porder_table->user_id)->update(['creditnote_no' => $note_no]);
        }
        return response()->json($data);
    }
    public function return_prod_modal($id){
        $user_id=Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            $user_id=$uid;
        }

        $selluser = User::find($user_id);
        Log::debug("selluser_id=" .$user_id);

        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $merchant_id=$merchant->id;

        Log::debug("merchant_id=" .$merchant_id);
        $mini = 0;
        $query="
            SELECT
            DISTINCT 
            pp.parent_id as tprid,
            product.id as id,
            product.id as prid,
            product.segment as segment,
            product.name as name,
            product.thumb_photo as thumb_photo,
            product.parent_id as parent_id,
            product.private_available as offlineProd,
            product.private_retail_price as offlinePrice,
            
            wholesale.price as retail_price,
            wholesale.id as wid,
            sum(locationproduct.quantity) as consignment_total,
            product.id as product_id,
            np.nproduct_id as nproductid

            FROM 
            product 
            join product parent on parent.id=product.parent_id
            join merchantproduct mp on mp.product_id=product.parent_id
            join nproductid np on np.product_id=product.id
            inner join (
                select parent_id ,MAX(created_at) as created_at
                from 
                product
                group by parent_id
            ) pp on pp.parent_id=product.parent_id AND pp.created_at=product.created_at
            left join wholesale on wholesale.product_id=product.id
             left join locationproduct on locationproduct.product_id=product.parent_id
             left join fairlocation on fairlocation.id=locationproduct.location_id
            
            WHERE
            mp.merchant_id=$merchant_id
            AND product.status != 'transferred'
            AND product.status != 'deleted'
            AND product.status !=''
            AND product.deleted_at IS NULL
            AND parent.status != 'transferred'
            AND parent.status != 'deleted'
            AND parent.status !=''
            AND parent.deleted_at IS NULL
            AND fairlocation.user_id =$user_id
            
            GROUP BY tprid
            ORDER BY offlineProd DESC
         
           

        ";
        $porder_data = DB::table('porder')->
        select('id','user_id','is_emerchant','salesorder_no','status')->
        where('id',$id)->first();
        if($porder_data->is_emerchant == 0 || is_null($porder_data->is_emerchant)){
            $porder_data->user_id =Merchant::where('user_id','=',$porder_data->user_id)->pluck('id');
        }
        Log::debug("Product User ID".$porder_data->user_id);
        $products=DB::select(DB::raw($query));
        // dd($products);
        /* dd($products); */
        $index=0;
//
//            foreach($products as $prods){
//
//                /* Consignment */
//
//                $pr=new ProductController;
//                $offline=$pr->consignment($prods->tprid,$user_id);
//                $prods->consignment_total=$offline;
//
//            }

        //    dd($products);
        $currency = Currency::where('active','=',1)->first();
        //$emerchant =  Emerchant::select('business_reg_no','company_name as first_name')->get();




        return response()->json([
            'data' => $products,
            'success' => "Yes"
        ]);

    }


    public function return_prod(Request $request){
        Log::debug('***** return_prod() *****');

        $data = $request->pTableData;
        $note = trim($request->notes);
        $return_completed = 0;
        Log::debug('***** note='.json_encode($note));
        Log::debug('***** data *****');
        Log::debug($data);

        $tableData = json_decode($data,TRUE);
        for($i = 0; $i < count($tableData); $i++){
            $opid = $tableData[$i]['opid'];
            $rmk =   $tableData[$i]['option'];
            //  $status = $tableData[$i]['status'];
            $status = 'return';
            $serial_no =  $tableData[$i]['serial_no'];
            $porder_no = DB::table('orderproduct')->join
            ('orderproductqty','orderproduct.id','=','orderproductqty.orderproduct_id')->join
            ('porder','porder.id','=','orderproduct.porder_id')->select
            ('porder.user_id','porder.is_emerchant')->where('orderproductqty.id',$opid)->first();
            if($porder_no->is_emerchant == 1){
                $inv_no =   DB::table('emerchant')
                    ->where('id',$porder_no->user_id)->max('salesorder_no');
            }else{
                $inv_no =   DB::table('merchant')
                    ->where('user_id',$porder_no->user_id)->max('salesorder_no');
            }
            /*
            Log::debug("opid     =".$opid);
            Log::debug("rmk      =".$rmk);
            Log::debug("status   =".$status);
            Log::debug("serial_no=".$serial_no);
             */


            if(!empty($rmk)){
                $exists = DB::table('orderproductreturn')->
                where('orderproductqty_id',$opid)->first();

                if($exists){
                    Log::debug('***** EXISTS *****');
                    Log::debug(json_encode($exists));
                    if(($exists->status == 'return') && (($exists->return_option != 'd') || ($exists->return_option != 'dx'))){
                        $return_completed = 1;
                        DB::table('orderproductreturn')->
                        where('id',$exists->id)->
                        update([
                            'return_option' => $rmk ,
                            'note' => $note
                        ]);

                    }

                } else {
                    $return_completed = 1;
                    if(($rmk == 'd') || ($rmk == 'dx')){
                        Log::debug("D or Dx Selected");
                        $id =  DB::table('orderproductreturn')->
                        insertGetId([
                            'orderproductqty_id' => $opid,
                            'return_option' => $rmk,
                            'status' => $status,
                            'return_invoice_id' => $inv_no,
                            'note' => $note,
                            'created_at' => Carbon::now()
                        ]);
                        Log::debug("D or Dx opr is updated");
                    }else{

                        $id =  DB::table('orderproductreturn')->
                        insertGetId([
                            'orderproductqty_id' => $opid,
                            'return_option' => $rmk,
                            'status' => $status,
                            'note' => $note,
                            'created_at' => Carbon::now()
                        ]);
                    }


                    Log::debug("id=".$id);
                    Log::debug("status   =".$status);
                    Log::debug("serial_no=".$serial_no);
                    Log::debug("orderproductqty_id=".$opid);

                    if(!empty($serial_no)){
                        Log::debug("id=".$id);
                        Log::debug("serial_no=".$serial_no);
                        Log::debug("orderproductqty_id=".$opid);
                        $warranty = DB::table('orderproductwarranty')->
                        where('serial_no',$serial_no)->first();

                        DB::table('orderproductreturnwarranty')->
                        insert(['orderproductreturn_id' => $id,
                            'orderproductwarranty_id' => $warranty->id]);
                    }
                }
            }else{ $return_completed = 1;}
        }

            return $return_completed;
    }


    public function credit_note($id, $cid){
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
        $invoicev = POrder::join('orderproduct','orderproduct.porder_id','=',
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
            first([
                'invoice.invoice_no',
                'porder.id'
            ]);
        $inv_no = $invoicev->invoice_no;


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

        return view('seller.gator.creditnote')->
        with('merchant',$merchant)->
        with('id',$id)->
        with('do',$do)->
        with('buyeraddress',$buyeraddress)->
        with('invoice',$invoice)->
        with('inv_no',$inv_no)->
        with('currency',$currency)->
        with('nporder_id',$nporder_id);
    }


    public function inv_return($porder_id)
    {
        $currency = Currency::where('active','=',1)->first();
        $user_id = Auth::user()->id;
        $staff_id=sprintf("%010d",$user_id);


        if(!empty($porder_id)) {
            DB::table('porder')->
            where('id', $porder_id)->
            update(['staff_user_id' => Auth::user()->id]);
        }

        $staff=DB::table("users")->
        where("id",$user_id)->
        select("first_name","last_name")->
        first();

        $staff_name=$staff->first_name." ".$staff->last_name;


        $porder_data = DB::table('porder')->
        select('id','user_id','is_emerchant','salesorder_no','status')->
        where('id',$porder_id)->first();


        $disabled = '';
        $invoice = DB::table('invoice')->
        where('porder_id',$porder_id)->first();
        Log::debug("porder_id=".$porder_id);

        $products = DB::table('orderproduct')
            ->leftjoin('nproductid','nproductid.product_id','=','orderproduct.product_id')
            ->join('product','orderproduct.product_id','=','product.id')
            ->join('orderproductqty as opq', 'opq.orderproduct_id','=','orderproduct.id')
            ->leftjoin('orderproductreturn as orp','orp.orderproductqty_id','=','opq.id')
            ->leftjoin('orderproductwarranty','opq.id','=','orderproductwarranty.orderproductqty_id')
            ->where('orderproduct.porder_id',$porder_id)
            ->where('opq.deleted_at', '=', NULL)
            ->select('product.id as pid',
                'product.parent_id',
                'product.name as pname',
                'product.thumb_photo',
                'orderproduct.id as opid',
                'orderproduct.created_at as return_option',
                'orderproductwarranty.serial_no as imeiNo',
                'orderproductwarranty.warranty_no as warrantyNo',
                'orderproduct.approved_qty','orderproduct.quantity','orderproduct.order_price',
                'nproductid.nproduct_id','orp.status','orp.note', 'orp.return_option','orp.return_invoice_id',
                'opq.id as opqid'
            )
            ->orderby('opq.id')->get();
        $exchanged = 0;
        foreach ($products as $product){
            if((($product->return_option == 'd') || ($product->return_option =='dx')) && ($product->status == 'return')){
                $inv_po = DB::table('porder')->select('id')
                    ->where('salesorder_no',$product->return_invoice_id )
                    ->where('user_id',$porder_data->user_id)
                    ->first();
                $exchanged = $inv_po->id;

            }

        }
        $inv = DB::table('invoice')->
        where('porder_id', $porder_id)->first();
        $return_completed = 0;
        if($inv){
            if(($inv->payment == 'offset') || ($inv->payment == 'full')){
                $return_completed = 1;
            }
        }
        $note = $products[0]->note;
        $status = 1;
        return view('seller.gator.inv_refund')->
        with(compact('staff_name','disabled','exchanged','status','note','user_id',
            'staff_id','invoice','products','porder_data','return_completed'));

    }
    public function show_mini_seller_gator($id){
        $currency = Currency::where('active','=',1)->
        pluck('code');
        $products = POrder::join('orderproduct','orderproduct.porder_id','=',
            'porder.id')->
        join('nproductid','nproductid.product_id','=',
            'orderproduct.product_id')->
        join('product','orderproduct.product_id','=','product.id')->
        where('porder.id','=',$id)->
        get([
            'nproductid.nproduct_id',
            'product.name',
            'product.parent_id',
            'product.id as prid',
            'product.thumb_photo',
            'orderproduct.quantity',
            'orderproduct.order_price',
        ]);
        return view('seller.gator.mini_seller_gator')->with(compact('products','currency'));
    }
}

