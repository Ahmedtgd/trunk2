<?php
namespace App\Http\Controllers;

// Constants for record lengths
// define("OCBCRET_HEADER_LEN", 77);
// define("OCBCRET_DETAIL_LEN", 78);
// define("OCBCRET_TRAILER_LEN", 105);

// use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\View;
use File;
use App\Models\GlobalT;
use App\Models\OcbcHeader;
use App\Models\OcbcDetail;
use App\Models\OcbcInv;
use App\Models\OcbcTrailer;
use App\Models\POrder;
use App\Models\Merchant;
use App\Models\User;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Currency;
use App\Models\OcbcRetHeader;
use App\Models\OcbcRetDetail;
use App\Models\OcbcRetTrailer;
use App\Models\OcbcPaymentStatus;
use DB;
use PDO;
use Cart;
use Auth;
use Storage;
use Exception;
use Session;
use Redirect;

class OcbcController extends Controller
{
    private $debug = false;

    // function __construct()
    // {
    //     $this->middleware('admin');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $debug = $this->debug;
        $success = true;
        $records = Request::all();
        // dd($records);
        if(isset($records['merchants'])){ $merchants = $records['merchants']; }
            else{ $merchants = null; }
        if(isset($records['mc'])){ $mcs = $records['mc']; }
            else{ $mcs = null; }
        if(isset($records['rc'])){ $rcs = $records['rc']; }
            else{ $rcs = null; }
        if(isset($records['smm'])){ $smms = $records['smm']; }
            else{ $smms = null; }

        // $result = OrderProduct::where('status','unpaid')->get();
        $total_product = 0;
        $total_merchant= 0;
        $total_mc= 0;
        $total_rc= 0;
        $total_smm = 0;
        $total_merchant_amount = 0;
        $total_mc_amount = 0;
        $total_rc_amount = 0;
        $total_smm_amount = 0;
        $total_amount = 0;
        $buyer_id = null;
        if(isset($merchants)){
            foreach ($merchants as $key => $value) {
                foreach ($merchants[$key] as $k => $v) {
                    // OrderProduct::where('porder_id',$key)->where('product_id', $k)->update(['status' => 'paid']);
                    foreach ($v as $kk => $vv) {
                        $output[$key][$k][$kk] = $vv[0];
                        $total_merchant_amount += $vv[0];
                    }
                    $total_merchant++;
                }
            }
        }
        if(isset($mcs)){
            foreach ($mcs as $key => $value) {
                foreach ($mcs[$key] as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        $output[$key][$k][$kk] = $vv[0];
                        $total_mc_amount += $vv[0];
                    }
                    $total_mc++;
                }
            }
        }
        if(isset($rcs)){
            foreach ($rcs as $key => $value) {
                foreach ($rcs[$key] as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        $output[$key][$k][$kk] = $vv[0];
                        $total_rc_amount += $vv[0];
                    }
                    $total_rc++;
                }
            }
        }
        if(isset($smms)){
            foreach ($smms as $key => $value) {
                foreach ($smms[$key] as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        $output[$key][$k][$kk] = $vv[0];
                        $total_smm_amount += $vv[0];
                    }
                    $total_smm++;
                }
            }
        }

        $total_product = $total_merchant + $total_mc + $total_rc + $total_smm;
        $ta = $total_merchant_amount + $total_mc_amount + $total_rc_amount + $total_smm_amount;

        $tamount = explode(".", round($ta, 2));
        $total_amount = null;

        if(isset($tamount[1])){
            $total_amount = $tamount[0].$tamount[1];
        }else{
            $total_amount = $tamount[0];
        }

        if($total_amount > 0 and $total_product > 0)
        {
            $ocbcHeader = new OcbcHeader;
            $ocbcTrailer = new OcbcTrailer;
            $ocbcTrailer->record_type = '03';
            $ocbcTrailer->total_count = str_pad($total_product, 6, '0', STR_PAD_LEFT);
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

                if($ocbcHeader->save())
                {
                    foreach ($output as $okey => $oval) {
                      $order_ID = $okey;
                        // echo 'product_id =' .$product_ID = key($productID); echo '<br>';
                        foreach ($output[$okey] as $pkey => $pval) {
                            $product_ID = $pkey;
                            foreach ($output[$okey][$pkey] as $ukey => $amount) {
                                $userID = $ukey;
                                $user = User::where('id',$userID)->first();
                                $merchant = Merchant::where('user_id',$userID)->first();
                                $buyer = DB::table('buyer')->where('user_id',$userID)->first();
                                if(isset($user) and isset($merchant) and isset($buyer))
                                {
                                    $bankaccount = DB::table('bankaccount')->where('bank_id',$buyer->bankaccount_id)->first();
                                    $account_number = null;
                                    $xamount = explode(".",round($amount, 2));
                                    if(isset($xamount[1])){
                                        $pay_amount = $xamount[0].$xamount[1];
                                    }else{
                                        $pay_amount = $xamount[0];
                                    }
                                    if(isset($bankaccount->account_number1)){
                                        $account_number = $bankaccount->account_number1;
                                    }elseif(isset($bankaccount->account_number2)){
                                        $account_number = $bankaccount->account_number2;
                                    }else{
                                        $account_number = null;
                                    }
                                    $bank = DB::table('bank')->where('id',$bankaccount->bank_id)->first();
                                    if(isset($bank))
                                    {
                                        $ocbcDetail = new OcbcDetail;
                                        $ocbcDetail->ocbc_header_id = $ocbcHeader->id;
                                        $ocbcDetail->record_type = '02';
                                        $ocbcDetail->account_number = str_pad($account_number, 20, ' ', STR_PAD_RIGHT);
                                        $ocbcDetail->amount = str_pad($pay_amount, 17, '0', STR_PAD_LEFT);
                                        $ocbcDetail->instruction = 'C';
                                        $ocbcDetail->new_ic_number = str_pad($user->nric, 12, ' ', STR_PAD_RIGHT);
                                        $ocbcDetail->txn_description = str_pad($merchant->oshop_name, 20, ' ', STR_PAD_RIGHT);
                                        $ocbcDetail->business_registration_no = str_pad($buyer->company_reg_no, 20, ' ', STR_PAD_RIGHT);
                                        $ref = $order_ID.';'.$product_ID.';'.$userID.';'.$pay_amount;
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
                                            $ocbcInv->invoice_details = $order_ID.';'.$product_ID.';'.$pay_amount;
                                            $ocbcInv->save();
                                        }
                                    }else{
                                       if($debug){
                                            $success = false;
                                            print "bank_id not found\n";
                                        }
                                    }
                                }else{
                                    if($debug){
                                        $success = false;
                                        print "missing user_id or merchant_id or buyer_id\n";
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if($success)
            {
                $id = $ocbcHeader->id;
                $header =   OcbcHeader::find($id);
                $filename = 'text-'.$id.'.txt';
                $path = str_replace('\\', '/',app_path().'/text/'.$filename);

                /* Set session sql_mode */
                $padsql = "SET sql_mode = 'PAD_CHAR_TO_FULL_LENGTH'";
                DB::connection('mysql')->statement($padsql);


                /* Generate Header */
                $sql1 = "id, CONCAT(record_type,tape_id,branch,company_cif,".
                "company_name,company_ac_no,instruction,reversal_indicator,".
                "crediting_date,customer_ref_no,filler1,filler2,filler3) as 'header'";

                $res1 = OcbcHeader::select(DB::raw($sql1))->where('id', '=', $id)->first();

                //echo "<pre>".$res1->header."</pre>\n";
                File::put($path, $res1->header."\n");


                /* Generate Details */
                $sql2 = "id, CONCAT(record_type,account_number,amount,instruction,".
                "new_ic_number,old_ic_no,txn_description,".
                "business_registration_no,reference_number,receiving_fi_id,".
                "beneficiary_name,passport_no,send_advice_via,email,fax_no,".
                "require_id_check,filler) as 'detail'";

                $res2 = OcbcDetail::select(DB::raw($sql2))->
                where('ocbc_header_id', '=', $res1->id)->get();

                foreach ($res2 as $detail) {
                  //echo "<pre>".$detail->detail."</pre>\n";
                  File::append($path, $detail->detail."\n");

                  $sql3 = "CONCAT(record_type,invoice_details) as 'inv'";
                  $res3 = OcbcInv::select(DB::raw($sql3))->where('ocbc_detail_id', $detail->id)->get();

                  foreach ($res3 as $invoice) {

                    /* For each Detail, generate the Invoice */
                     // echo "<pre>".$invoice->inv."</pre>\n";
                      File::append($path, $invoice->inv."\n");
                  }
                }

                $sql4 = "CONCAT(record_type,total_count,total_amount,filler1,"."filler2) as 'trailer'";
                $res4 = OcbcTrailer::select(DB::raw($sql4))->where('id', '=', $res1->id)->first();

                //echo "<pre>".$res4->trailer."</pre>\n";

                File::append($path, $res4->trailer."\n");

                if(file_exists($path)){
                    try{
                        $exec_path = str_replace('\\', '/',app_path().'/ocbc_return/');
                        if(exec("unix2dos $exec_path", $out) != 0){
                            echo "unix2dos: Error: $out[0]<br>";
                        }

                    }catch(Exceptions $e){
                        throw new CustomException($e->getMessage());
                    }

                    Storage::disk('local')->put($filename, File::get($path));

                    Session::flash('success_msg',
						'Payment Successfull! Payment file has been generated.');
                    return Redirect::back();

                }else{
                    if($debug){
                        print "file not found\n";
                    }
                }
            }
        }else{
            if($debug){
                print "amount or product is not available\n";
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBankPayment()
    {
        ini_set('max_execution_time', 300);
        $debug = $this->debug;

        $orders = POrder::all();
        $order_array = array();
        $product_array = array();
        $merchant_array = array();
        $smm_product_array = array();
        $currency = Currency::where('active',true)->first()->code;

        if(isset($orders))
        {
            foreach($orders as $order)
            {
                $user = User::where('id',$order->user_id)->first();
                $paymentIn = Payment::where('id',$order->payment_id)->select('receivable')->first();
                $merchant = Merchant::where('user_id',$order->user_id)->first();

                if(OrderProduct::where('porder_id',$order->id)->exists())
                {
                    $order_array[$order->id]['username'] = null;

                    $mcUserID = null;
                    $mcUserName = null;
                    $rcUserID = null;
                    $rcUserName = null;

                    $mcStaffID = $merchant['mc_sales_staff_id']; // mc_sales_staff_id from merchant table
                    $rcStaffID = $merchant['referral_sales_staff_id']; // referral_sales_staff_id from merchant table

                    if($mcStaffID != null and $mcStaffID != 0){
                        $staff = DB::table('sales_staff')->where('id', $mcStaffID)->where('type', 'mct')->first();
                        $user = User::where('id',$staff->user_id)->first();
                        $order_array[$order->id]['mc_staff_id'] = $user['id'];
                        $order_array[$order->id]['mc_staff_name'] =  $user['first_name'].' '.$user['last_name'];
                    }else{
                        $order_array[$order->id]['mc_staff_id'] = null;
                        $order_array[$order->id]['mc_staff_name'] =  null;
                    }

                    if($rcStaffID != null and $rcStaffID != 0){
                        $staff = DB::table('sales_staff')->where('id', $rcStaffID)->where('type', 'mct')->first();
                        $user = User::where('id',$staff->user_id)->first();
                        $order_array[$order->id]['rc_staff_id'] =  $user['id'];
                        $order_array[$order->id]['rc_staff_name'] = $user['first_name'].' '.$user['last_name'];
                    }else{
                        $order_array[$order->id]['rc_staff_id'] =  null;
                        $order_array[$order->id]['rc_staff_name'] = null;
                    }

                    if(strlen($user['name']) > 0)
                    {
                        $order_array[$order->id]['username'] = $user['name'];
                    }
                    else if(strlen($user['first_name'].' '.$user['last_name']) > 0)
                    {
                        $order_array[$order->id]['username'] = $user['first_name'].' '.$user['last_name'];
                    }
                    else if(strlen($user['last_name']) > 0)
                    {
                        $order_array[$order->id]['username'] = $user['last_name'];
                    }
                    $order_array[$order->id]['userid'] = $order->user_id;
                    $order_array[$order->id]['delivery'] = $order->delivery_tstamp;
                    $order_array[$order->id]['receipt'] = $order->receipt_tstamp;
                    $payment_in = $order_array[$order->id]['paymentIn'] = $paymentIn['receivable'];
                    $order_array[$order->id]['merchant_oshop_name'] = $merchant['oshop_name'];

                    // Merchant Consultant and Refferal FK
                    $mc_id = $order_array[$order->id]['mc_sales_staff_id'] = $merchant['mc_sales_staff_id'];
                    $ref_id = $order_array[$order->id]['referral_sales_staff_id'] = $merchant['referral_sales_staff_id'];

                    // Commission in merchant table
                    $merchant_osmall_commission = $merchant['osmall_commission'];
                    $merchant_commission = $merchant['mc_sales_staff_commission'];
                    $reff_commission = $merchant['referral_sales_staff_commission'];
                    $mc_with_reff_commission = $merchant['referral_sales_staff_commission'];

                    // Commission in global table
                    $global = GlobalT::select('osmall_commission','mc_sales_staff_commission','referral_sales_staff_commission')->first();
                    $global_osmall_commission = $global['osmall_commission'];
                    $global_merchant_commission = $global['mc_sales_staff_commission'];
                    $global_reff_commission = $global['referral_sales_staff_commission'];

                    $osmall_commission = null;

                    // if no merchant.osmall_commission set global.osmall_commission
                    if($merchant_osmall_commission != null or $merchant_osmall_commission > 0)
                    {
                        $osmall_commission = $order_array[$order->id]['merchant_osmall_commission'] = $merchant_osmall_commission;

                    }else{

                        $global = GlobalT::select('osmall_commission')->first();
                        $osmall_commission = $order_array[$order->id]['merchant_osmall_commission'] = $global_osmall_commission;
                    }


                    $mc = $merchant_commission;
                    $rc = $reff_commission;

                    // if mc_sales_staff_id has FK, but referral_sales_staff_id is NULL
                    if(($mc_id != null and $ref_id == null) or ($mc_id > 0 and $ref_id > 0)){
                        if($merchant_commission != null and $merchant_commission > 0){
                            $mc = $merchant_commission/100;
                        }else{
                            $mc = $global_merchant_commission/100;
                        }
                        $order_array[$order->id]['mc_commission'] = $mc;
                        $order_array[$order->id]['mc_ref_commission'] = null;
                    }

                    // if mc_sales_staff_id has FK AND referral_sales_staff_id has FK, both also has FK
                    else if(($mc_id != null and $ref_id != null) or ($mc_id != 0 and $ref_id != 0)){
                        if(($mc_with_reff_commission != null and $reff_commission != null) or ($mc_with_reff_commission > 0 and $reff_commission > 0)){
                            if( $mc_with_reff_commission + $reff_commission == 4 ){
                               $mc = $mc_with_reff_commission/100;
                               $rc = $reff_commission/100;
                            }
                        }else{
                              $mc = $global_merchant_commission/100;
                              $rc = $global_reff_commission/100;
                        }
                        $order_array[$order->id]['mc_commission'] = $mc;
                        $order_array[$order->id]['mc_ref_commission'] = $rc;
                    }else{
                        $order_array[$order->id]['mc_commission'] = null;
                        $order_array[$order->id]['mc_ref_commission'] = null;
                    }

                    $products = OrderProduct::where('porder_id',$order->id)->select('product_id','quantity')->get();
                    $i = 1;
                    if (isset($products)){
                        foreach ($products as  $product){
                            $pname = Product::where('id',$product['product_id'])->first();

                            // dd($pname[0]['mc_sales_staff_id']);

                            $mcID = $pname['mc_sales_staff_id']; // mc_sales_staff_id from product table
                            $rcID = $pname['referral_sales_staff_id']; // referral_sales_staff_id from product table
                            $product_osmall_commission = $pname['osmall_commission']; // product osmall_commission
                            $product_mc_sales_staff_commission = $pname['mc_sales_staff_commission']; // product mc_sales_staff_commission
                            $product_referral_sales_staff_commission = $pname['referral_sales_staff_commission']; // product referral_sales_staff_commission
                            $product_mc_with_ref_sales_staff_commission = $pname['mc_with_ref_sales_staff_commission']; // product mc_with_ref_sales_staff_commission

                            // if($product_osmall_commission == null or $product_osmall_commission <= 0){
                            //     $g_osmall_commission = GlobalT::select('smm_sales_staff_commission')->first();
                            //     $product_osmall_commission = $g_osmall_commission->smm_sales_staff_commission;
                            // }else{
                            //     $product_osmall_commission = $pname[0]['osmall_commission'];
                            // }

                            // get mc.id from product table else get from merchant table
                            if($mcID != null and $mcID != 0){
                                $staff = DB::table('sales_staff')->where('id', $mcID)->where('type', 'mct')->first();
                                $user = User::where('id',$staff->user_id)->first();
                                $mcUserID = $user['id'];
                                $mcUserName = $user['first_name'].' '.$user['last_name'];
                            }else{
                                if($mcStaffID != null){
                                    $staff = DB::table('sales_staff')->where('id', $mcStaffID)->where('type', 'mct')->first();
                                    $user = User::where('id',$staff->user_id)->first();
                                    $mcUserID = $user['id'];
                                    $mcUserName = $user['first_name'].' '.$user['last_name'];
                                }else{
                                    $mcUserID = null;
                                    $mcUserName = null;
                                }
                            }
                            // get reff.id from product table else get from merchant table
                            if($rcID != null and $rcID != 0){
                                $staff = DB::table('sales_staff')->where('id', $rcID)->where('type', 'mct')->first();
                                $user = User::where('id',$staff->user_id)->first();
                                $rcUserID = $user['id'];
                                $rcUserName = $user['first_name'].' '.$user['last_name'];
                            }else{
                                if($rcStaffID != null)
                                {
                                    $staff = DB::table('sales_staff')->where('id', $rcStaffID)->where('type', 'mct')->first();
                                    $user = User::where('id',$staff->user_id)->first();
                                    $rcUserID = $user['id'];
                                    $rcUserName = $user['first_name'].' '.$user['last_name'];
                                }else{
                                    $rcUserID = null;
                                    $rcUserName = null;
                                }
                            }
                            // Commission in global table
                            $global = GlobalT::select('osmall_commission','mc_sales_staff_commission','referral_sales_staff_commission')->first();
                            $global_osmall_commission = $global['osmall_commission'];
                            $global_merchant_commission = $global['mc_sales_staff_commission'];
                            $global_reff_commission = $global['referral_sales_staff_commission'];

                            // if no merchant.osmall_commission set global.osmall_commission
                            if($product_osmall_commission != null or $product_osmall_commission > 0)
                            {
                                $product_osmall_commission = $product_osmall_commission;

                            }else{

                                $product_osmall_commission = $global_osmall_commission;
                            }


                            $pmc = $product_mc_sales_staff_commission;
                            $prc = $product_referral_sales_staff_commission;

                            // if mc_sales_staff_id has FK, but referral_sales_staff_id is NULL
                            if(($mcID != null and $rcID == null) or ($mcID > 0 and $rcID > 0)){
                                if($product_mc_sales_staff_commission != null and $product_mc_sales_staff_commission > 0){
                                    $pmc = $product_mc_sales_staff_commission/100;
                                }else{
                                    $pmc = $global_merchant_commission/100;
                                }
                            }

                            // if mc_sales_staff_id has FK AND referral_sales_staff_id has FK, both also has FK
                            else if(($mcID != null and $rcID != null) or ($mcID!= 0 and $rcID != 0)){
                                if(($product_mc_with_ref_sales_staff_commission != null and $product_referral_sales_staff_commission != null) or ($product_mc_with_ref_sales_staff_commission > 0 and $product_referral_sales_staff_commission > 0)){
                                    if( $product_mc_with_ref_sales_staff_commission + $product_referral_sales_staff_commission == 4 ){
                                       $pmc = $product_mc_with_ref_sales_staff_commission/100;
                                       $prc = $product_referral_sales_staff_commission/100;
                                    }
                                }elseif(($mc != null or $mc > 0) and ($rc != null or $rc > 0)){
                                    $pmc = $mc;
                                    $prc = $rc;
                                }elseif(($global_merchant_commission != null or $global_merchant_commission > 0) and ($global_reff_commission != null or $global_reff_commission > 0)){
                                      $pmc = $global_merchant_commission/100;
                                      $prc = $global_reff_commission/100;
                                }
                            }else{
                                $pmc = null;
                                $prc = null;
                            }
                            $product_array[$order->id]['product-'.$i] = $product['product_id'].'/'.$pname['name'].'/'.$pname['retail_price']*$product['quantity'].'/'.$mcUserID.'/'.$mcUserName.'/'.$rcUserID.'/'.$rcUserName.'/'.$product_osmall_commission.'/'.$pmc.'/'.$prc;
                            $i++;
                        }
                    } else{
                        if($debug){
                            print "product not found\n";
                        }
                    }
                }
            }

            // smm calculation


            $smm_results = DB::select( DB::raw("select m.id as 'MID', m.oshop_name as 'OShop', p.id as 'ProductID', smm.id as 'SMMID',
            count(smm.id) as 'Buys' from smmin si, smmout so, porder po, orderproduct op, product p,
            merchantproduct mp, merchant m, users u, users smm where si.porder_id=po.id and si.response='buy'
            and si.smmout_id=so.id and so.user_id=smm.id and so.product_id=p.id and op.porder_id=po.id
            and op.product_id=p.id and mp.product_id=p.id and mp.merchant_id=m.id and m.user_id=u.id group by m.id, p.id, smm.id"));
            // dd($smm_results);
            $smm_array = null;
            if(isset($smm_results)){
                foreach ($smm_results as $smm_result) {
                    $merchant = Merchant::where('id',$smm_result->MID)->first();
                    $smm_product = Product::where('id',$smm_result->ProductID)->first();
                    // dd($smm_products);
                    if(isset($smm_product))
                    {
                        $count = 1;
                        foreach ($smm_results as $item) {
                          if ($item->ProductID == $smm_product->id ) {
                            $count++;
                          }
                        }
                        $quantity = $count;
                        $smmout_val = DB::table('smmout')->where('product_id',$smm_product->id)->get();
                        if(isset($smmout_val)){
                            $j=0;
                            foreach ($smmout_val as $smmout){
                                $user = User::where('id',$smmout->user_id)->first();
                                if(isset($user)){
                                    $userID = $user->id;
                                    $userName = $user->first_name;
                                }else{
                                    $user = null;
                                }
                                $smmin = DB::table('smmin')->where('smmout_id',$smmout->id)->first();
                                // dd($smmin);
                                if(isset($smmin))
                                {
                                    $osmall_commission = null;
                                    $poc = $smm_product->osmall_commission;
                                    $moc = $merchant->osmall_commission;
                                    $goc = $global = GlobalT::select('osmall_commission')->first();
                                    if($poc != null or $poc > 0){
                                        $osmall_commission = $poc;
                                    }
                                    else if($moc != null or $moc > 0){
                                        $osmall_commission = $moc;
                                    }
                                    else if($goc != null or $goc > 0){
                                        $osmall_commission = $goc;
                                    }else{
                                        $osmall_commission = null;
                                    }

                                    $mcUserID = null;
                                    $mcUserName = null;
                                    $rcUserID = null;
                                    $rcUserName = null;

                                    // Merchant Consultant and Refferal FK
                                    $mc_id = $merchant['mc_sales_staff_id'];
                                    $ref_id = $merchant['referral_sales_staff_id'];
                                    $merchant_commission = $merchant['mc_sales_staff_commission'];
                                    $reff_commission = $merchant['referral_sales_staff_commission'];
                                    $mc_with_reff_commission = $merchant['referral_sales_staff_commission'];

                                    // Commission in global table
                                    $global = GlobalT::select('osmall_commission','mc_sales_staff_commission','referral_sales_staff_commission')->first();
                                    $global_osmall_commission = $global['osmall_commission'];
                                    $global_merchant_commission = $global['mc_sales_staff_commission'];
                                    $global_reff_commission = $global['referral_sales_staff_commission'];

                                    $mc = $merchant_commission;
                                    $rc = $reff_commission;

                                    if($mcStaffID != null and $mcStaffID != 0){
                                        $staff = DB::table('sales_staff')->where('id', $mcStaffID)->where('type', 'mct')->first();
                                        $user = User::where('id',$staff->user_id)->first();
                                        $mc_staff_id = $user['id'];
                                        $mc_staff_name =  $user['first_name'].' '.$user['last_name'];
                                    }else{
                                        $mc_staff_id = null;
                                        $mc_staff_name =  null;
                                    }

                                    if($rcStaffID != null and $rcStaffID != 0){
                                        $staff = DB::table('sales_staff')->where('id', $rcStaffID)->where('type', 'mct')->first();
                                        $user = User::where('id',$staff->user_id)->first();
                                        $rc_staff_id =  $user['id'];
                                        $rc_staff_name = $user['first_name'].' '.$user['last_name'];
                                    }else{
                                        $rc_staff_id =  null;
                                        $rc_staff_name = null;
                                    }

                                    // if mc_sales_staff_id has FK, but referral_sales_staff_id is NULL
                                    if(($mc_id != null and $ref_id == null) or ($mc_id > 0 and $ref_id > 0)){
                                        if($merchant_commission != null and $merchant_commission > 0){
                                            $mc = $merchant_commission/100;
                                        }else{
                                            $mc = $global_merchant_commission/100;
                                        }
                                    }

                                    // if mc_sales_staff_id has FK AND referral_sales_staff_id has FK, both also has FK
                                    else if(($mc_id != null and $ref_id != null) or ($mc_id != 0 and $ref_id != 0))
                                    {
                                        if(($mc_with_reff_commission != null and $reff_commission != null) or
                                            ($mc_with_reff_commission > 0 and $reff_commission > 0)){
                                            if( $mc_with_reff_commission + $reff_commission == 4 ){
                                               $mc = $mc_with_reff_commission/100;
                                               $rc = $reff_commission/100;
                                            }
                                        }else{
                                              $mc = $global_merchant_commission/100;
                                              $rc = $global_reff_commission/100;
                                        }
                                    }else{
                                        $mc = null;
                                        $rc = null;
                                    }

                                    $x = $quantity;
                                    $porder_id = $smmin->porder_id;
                                    $productAmount = $smm_product->retail_price * $x;
                                    $productOpensupermall = ($productAmount/100) * ($osmall_commission/100);
                                    $productMerchantRev = $productAmount/100 - $productOpensupermall;
                                    if($x > 0){
                                        $smm = ($osmall_commission * $smm_product->smm_sales_staff_commission/100)/$x;
                                    }else{
                                        $smm = null;
                                    }
                                    $MC = $mc * $productOpensupermall;
                                    $RC = $mc * $productOpensupermall;

                                    $merchant_array[$merchant->id]['merchantID'] = $merchant->id;
                                    $merchant_array[$merchant->id]['merchantName'] = $merchant->oshop_name;
                                    $smm_product_array[$merchant->id][$smm_product->id]['productID'] = $smm_product->id;
                                    $smm_product_array[$merchant->id][$smm_product->id]['productName'] = $smm_product->name;
                                    $smm_product_array[$merchant->id][$smm_product->id]['productOrder'] = $porder_id;
                                    $smm_product_array[$merchant->id][$smm_product->id]['productAmount'] = $productAmount;
                                    $smm_product_array[$merchant->id][$smm_product->id]['productOpensupermall'] = $productOpensupermall;
                                    $smm_product_array[$merchant->id][$smm_product->id]['productMerchantRev'] = $productMerchantRev;
                                    $smm_product_array[$merchant->id][$smm_product->id]['mc_commission'] = $MC;
                                    $smm_product_array[$merchant->id][$smm_product->id]['mc_ref_commission'] = $RC;
                                    $smm_product_array[$merchant->id][$smm_product->id]['mc_staff_id'] = $mc_staff_id;
                                    $smm_product_array[$merchant->id][$smm_product->id]['mc_staff_name'] = $mc_staff_name;
                                    $smm_product_array[$merchant->id][$smm_product->id]['rc_staff_id'] = $rc_staff_id;
                                    $smm_product_array[$merchant->id][$smm_product->id]['rc_staff_name'] = $rc_staff_name;
                                    $smm_array[$merchant->id][$smm_product->id][$j]['user_id'] = $userID ;
                                    $smm_array[$merchant->id][$smm_product->id][$j]['username'] = $userName ;
                                    $smm_array[$merchant->id][$smm_product->id][$j]['smm'] = $smm ;
                                    $j++;
                                }
                                else
                                {
                                    if($debug){
                                        print "smmin table has no value\n";
                                    }
                                }
                            }
                        }else{
                            if($debug){
                                print "smmout table has no value\n";
                            }
                        }

                    }else{
                        if($debug){
                            print "smm product has no value\n";
                        }
                    }
                }
            }else{
                if($debug){
                    print "smm result null\n";
                }
            }

            return view('bank_payment')
                    ->with('order_array',$order_array)
                    ->with('product_array',$product_array)
                    ->with('currency',$currency)
                    ->with('merchant_array',$merchant_array)
                    ->with('smm_product_array',$smm_product_array)
                    ->with('smm_array',$smm_array);
        }
    }

    /**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function parseReturnFile()
    {
        $debug = $this->debug;
        $filename = 'ocbc_return.txt';
        $path = str_replace('\\', '/',app_path().'/ocbc_return/');
        $ret_file = $path.$filename;
        $textfile = $path.$filename;

        if ($debug) {
            echo "textfile = $textfile<br>";
        }

        if(file_exists($textfile)){
            // Make sure unix2dos and dos2unix is in the system PATH
            try{
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
                    // We are running in a Windows system
                    $header_len = OCBCRET_HEADER_LEN + 2;
                    $detail_len = OCBCRET_DETAIL_LEN + 2;
                    $trailer_len = OCBCRET_TRAILER_LEN + 2;

                    if(exec("unix2dos $textfile", $out) == 0){
                        $debug ? print "unix2dos: Success!<br>" : "";
                    }else{
                        $debug ? print 'unix2dos: Error!<br>' : '';
                    }
                }else{
                    // Otherwise, we are running in a non-Windows,
                    // hopefully Unix-like system
                    $header_len = OCBCRET_HEADER_LEN + 1;
                    $detail_len = OCBCRET_DETAIL_LEN + 1;
                    $trailer_len = OCBCRET_TRAILER_LEN + 1;

                    if(exec("dos2unix $textfile", $out ) == 0){
                        $debug ? print 'dos2unix: Success!<br>':'';
                    }else{
                        $debug ? print 'dos2unix: Error!<br>':'';
                    }
                }
            }catch(Exceptions $e){
                return $e->getMessage();
            }

            if ($debug) {
                echo "header_len  = $header_len<br>";
                echo "detail_len  = $detail_len<br>";
                echo "trailer_len = $trailer_len<br>";
            }

            $file = fopen($ret_file, "r");
            $line_of_text = null;
            $ocbcret_header = new OcbcRetHeader;
            while (!feof($file)) {
                $line = fgets($file);
                $length_of_line =strlen($line);

                if ($debug) {
                    echo "BEFORE length_of_line = $length_of_line<br>\n";
                    echo "      line = $line<br>";
                }

                if($length_of_line == $header_len){
                    $ocbcret_header->record_type = substr($line,0,2);
                    $ocbcret_header->company_ac_no = substr($line,2,20);
                    $ocbcret_header->value_date = substr($line,22,8);
                    $ocbcret_header->filler = substr($line,30,47);
                    if($ocbcret_header->save()){
                        $ocbcret_header->where('id', $ocbcret_header->id)
                        ->update(['ocbcret_trailer_id' => $ocbcret_header->id]);
                    }

                } else if($length_of_line == $detail_len){
                    $ocbcret_detail = new OcbcRetDetail;
                    $ocbcret_detail->ocbcret_header_id = $ocbcret_header->id;
                    $ocbcret_detail->record_type = substr($line,0,2);
                    $ocbcret_detail->receiving_fi_id = substr($line,2,9);
                    $ocbcret_detail->account_number = substr($line,11,20);
                    $ocbcret_detail->instruction = substr($line,31,1);
                    $ocbcret_detail->amount = substr($line,32,17);
                    $ocbcret_detail->reference_number = substr($line,49,20);
                    $ocbcret_detail->return_code = substr($line,69,3);
                    $ocbcret_detail->reject_code = substr($line,72,3);
                    $ocbcret_detail->success_indicator = substr($line,75,1);
                    $ocbcret_detail->filler = substr($line,76,2);
                    if($ocbcret_detail->save()){
                        $refNum = explode(';',$ocbcret_detail->reference_number);
                        $porder_id = $refNum[0];
                        $product_id = $refNum[1];
                        $user_id = $refNum[2];
                        $ocbcPaymentStatus = new OcbcPaymentStatus;
                        $ocbcPaymentStatus->porder_id = $porder_id;
                        $ocbcPaymentStatus->product_id = $product_id;
                        $ocbcPaymentStatus->user_id = $user_id;
                        $ocbcPaymentStatus->save();
                        $type = null;
                        $staff = DB::table('sales_staff')->where('user_id',$ocbcPaymentStatus->user_id)->first();
                        if(isset($staff)){
                            $type = $staff->type;
                        }else{
                            $type = null;
                        }
                        $ocbcgiro_reject = DB::table('ocbcgiro_reject')->where('code', $ocbcret_detail->reject_code)->first();
                        $ocbcgiro_return = DB::table('ocbcgiro_return')->where('code', $ocbcret_detail->return_code)->first();
                        $ocbc_rej_id = null;
                        $ocbc_ret_id = null;
                        if(isset($ocbcgiro_reject)){
                            $ocbc_rej_id = $ocbcgiro_reject->id;
                        }else{
                            $ocbc_rej_id = null;
                        }
                        if(isset($ocbcgiro_return)){
                            $ocbc_ret_id = $ocbcgiro_return->id;
                        }else{
                            $ocbc_ret_id = null;
                        }

                        if($ocbc_rej_id != null or $ocbc_ret_id != null){
                            if($ocbc_rej_id !=null){
                                $sql = "select rej.id from ocbcgiro_reject rej, ocbcret_detail det where rej.code = trim(det.reject_code)";
                                $rejID  = DB::raw($sql);
                                if($rejID != null){
                                    $s = "update ocbc_payment_status set ocbcgiro_reject_id=rej.id where porder_id=$porder_id,
                                          user_id=$user_id, product_id=$product_id, type=$type";
                                    $res = DB::raw($s);
                                }
                            }
                            if($ocbc_ret_id != null){
                                $sql = "select ret.id from ocbcgiro_return ret, ocbcret_detail det where ret.code = trim(det.return_code)";
                                $retID = DB::raw($sql);
                                if($retID != null){
                                    $s = "update ocbc_payment_status set ocbcgiro_return_id=ret.id where porder_id=$porder_id,
                                          user_id=$user_id, product_id=$product_id, type=$type";
                                    $res = DB::raw($s);
                                }
                            }
                        }else{
                            $ocbcPaymentStatus->success_indicator = true;
                            $ocbcPaymentStatus->save();
                        }
                    }
                } elseif($length_of_line == $trailer_len ||
                         $length_of_line == OCBCRET_TRAILER_LEN){ // No EOF/EOF!
                    $ocbcret_trailer = new OcbcRetTrailer;
                    $ocbcret_trailer->record_type = substr($line,0,2);
                    $ocbcret_trailer->accepted_count = substr($line,2,6);
                    $ocbcret_trailer->accepted_amount = substr($line,8,19);
                    $ocbcret_trailer->reject_count = substr($line,27,6);
                    $ocbcret_trailer->reject_amount = substr($line,33,19);
                    $ocbcret_trailer->returned_count = substr($line,52,6);
                    $ocbcret_trailer->returned_amount = substr($line,58,19);
                    $ocbcret_trailer->total_count = substr($line,77,6);
                    $ocbcret_trailer->total_amount = substr($line,83,19);
                    $ocbcret_trailer->filler = substr($line,102,2);
                    $ocbcret_trailer->save();

                } elseif($length_of_line == 0){
                    $debug ? print "END-of-FILE<br>\n":'';

                } else{
                    $debug ? print "ELSE length_of_line = $length_of_line<br>\n":'';
                    return "missing or mismatch character";
                }
            } // while()

            Session::flash('success_msg','Payment Successfull!');
            return Redirect::back();

        } else {
            // file_exists()
            if ($debug) {
                echo "file_exists(): ERROR!<br>File:$textfile<br>DOES NOT exist!<br>\n";
            }
        }
    }
}
