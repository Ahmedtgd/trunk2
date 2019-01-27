<?php

namespace App\Classes;

// Constants for record lengths
define("OCBCRET_HEADER_LEN", 77);
define("OCBCRET_DETAIL_LEN", 78);
define("OCBCRET_TRAILER_LEN", 105);

// use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\View;
use File;
use App\Models\Globals;
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

Class UserPayment {

    private $debug = false;

    /**
     * [this function will calculate how much we owe the USER]
     * @param  [integer] $id   [USER id]
     * @param  [string] $date  [how much we owe til date to the USER]
     * @return [integer]       [the owe amount of the USER]
     */
    public function owe_user($id, $date)
    {
        /**
         * this function calculate how much we owe the USER
         */

        echo "[ this is owe_user function ] user_id : ".$id." date : ".$date . PHP_EOL;
    }

    /**
     * [pay_user saves the payment info in db and generates bank file]
     * @param  [array] $pay_users [user array]
     * @param  [string] $user_type [user role]
     * @return [redirect to back page after the operation (save or fail)]
     */
    public function pay_user($pay_users, $user_type)
    {
        $debug = $this->debug;
        $success = true;
        $outputs = array();

        // get the user array
        $records = $pay_users;
        // process user array for making payment
        if($user_type == 'order'){
            $outputs = $this->processed_output_for_order($records['order']);
        }else{
            $outputs = $this->processed_output($records, $user_type);
        }

        $output = $outputs[0];
        $total_amount = $outputs[1];
        $total_product = $outputs[2];

        if($total_amount > 0 and $total_product > 0)
        {
            $saved = $this->payment_save($total_amount, $total_product, $output);

            if($saved){
                return true;
            }
        }else{
            if($debug){
                print "amount or product is not available\n";
            }
        }
    }
	
    public function pay_pc($pay_users, $user_type)
    {
        $debug = $this->debug;
        $success = true;
        $outputs = array();

        // get the user array
        $records = $pay_users;

        // process user array for making payment

		$outputs = $this->processed_outputpc($records, $user_type);

        $output = $outputs[0];
        $total_amount = $outputs[1];

        if($total_amount > 0)
        {
            $saved = $this->payment_savepc($total_amount, $output);

            if($saved){
                return true;
            }
        }else{
            if($debug){
                print "amount or product is not available\n";
            }
        }
    }	

    private function processed_outputpc($user_array, $user_type)
    {
        $type = $user_type;
        /*$orders = array();
        $products = array();*/
        $outputs = array();
        $total_amount = 0;
        //$total_product = 0;

        $i = 0;
		$role_id = 0;
		$global = DB::table('global')->first();
		$roless = DB::table('roles')->where('slug',$user_array["ss_type"])->first();
		if(!is_null($roless)){
			$role_id = $roless->id;
		}
        foreach ($user_array["ss_userid"] as $user) {
			if($user_array["ss_type"] == "mcp"){
				$sql = "SELECT ss.*, CONCAT(u.first_name, ' ', u.last_name) as name,
				(IF(ss.commission>0,(ss.commission/100)*SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END),IF(m.mcp1_sales_staff_commission > 0,(m.mcp1_sales_staff_commission/100)*SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END),(".$global->mcp1_sales_staff_commission."/100)*SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END)))) as receive
				FROM sales_staff ss
				JOIN users u ON u.id = ss.user_id AND ss.type = 'mcp'
				LEFT JOIN merchant m ON (ss.id = m.mcp1_sales_staff_id OR ss.id = m.mcp2_sales_staff_id)
				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id
				LEFT JOIN porder p ON p.id = op.porder_id
				LEFT JOIN commissionpaid cp ON p.id = cp.porder_id AND cp.user_id = u.id
				LEFT JOIN payment pa ON pa.id = p.payment_id
				WHERE ss.user_id = " . $user . "
				GROUP BY ss.id";
				$total = DB::select(DB::raw($sql));
				foreach ($total as $sst) {
					$total_amount = $total_amount + $sst->receive;
				}
				
				$sqlv = "SELECT ss.*, SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END) as revenue, p.id as orderid, (IF(ss.commission>0,ss.commission,IF(m.mcp1_sales_staff_commission > 0,m.mcp1_sales_staff_commission/100,".$global->mcp1_sales_staff_commission."))) as rate, 
				m.id as merchant_id
				FROM sales_staff ss 
				JOIN users u ON u.id = ss.user_id AND ss.type = 'mcp' 
				LEFT JOIN merchant m ON (ss.id = m.mcp1_sales_staff_id OR ss.id = m.mcp2_sales_staff_id) 
				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id 
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id 
				LEFT JOIN porder p ON p.id = op.porder_id 
				LEFT JOIN commissionpaid cp ON p.id = cp.porder_id AND cp.user_id = u.id
				LEFT JOIN payment pa ON pa.id = p.payment_id 
				WHERE ss.user_id = " . $user . " 
				GROUP BY p.id";
				$orders = DB::select(DB::raw($sqlv));
				foreach ($orders as $order) {
					if(!is_null($order->revenue) && $order->revenue > 0){
						$update = DB::table('orderproduct')->where('porder_id',$order->orderid)->update(['commission_paid'=> true]);
						$insert = DB::table('commissionpaid')->insert(['porder_id'=>$order->orderid,'user_id'=>$user,'role_id'=>$role_id]);
						$outputs[$order->orderid][$user] = $order->revenue * ($order->rate/100);
					}
				}
			} else if($user_array["ss_type"] == "mct"){
				$sql = "SELECT ss.*, CONCAT(u.first_name, ' ', u.last_name) as name,
				(IF(ss.commission>0,(ss.commission/100)*SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END),IF(m.mc_sales_staff_commission > 0,		(m.mc_sales_staff_commission/100)*SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END),(".$global->mc_sales_staff_commission."/100)*SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END)))) as receive
				FROM sales_staff ss
				JOIN users u ON u.id = ss.user_id AND ss.type = 'mct'
				LEFT JOIN merchant m ON ss.id = m.mc_sales_staff_id
				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id
				LEFT JOIN porder p ON p.id = op.porder_id
				LEFT JOIN commissionpaid cp ON p.id = cp.porder_id AND cp.user_id = u.id
				LEFT JOIN payment pa ON pa.id = p.payment_id
				WHERE ss.user_id = " . $user . "
				GROUP BY ss.id";
				$total = DB::select(DB::raw($sql));
				foreach ($total as $sst) {
					$total_amount = $total_amount + $sst->receive;
				}
				
				$sqlv = "SELECT ss.*, SUM(CASE WHEN cp.id IS NULL THEN pa.receivable ELSE 0 END) as revenue, p.id as orderid, (IF(ss.commission>0,ss.commission,IF(m.mc_sales_staff_commission > 0,m.mc_sales_staff_commission/100,".$global->mc_sales_staff_commission."))) as rate, 
				m.id as merchant_id
				FROM sales_staff ss 
				JOIN users u ON u.id = ss.user_id AND ss.type = 'mct' 
				LEFT JOIN merchant m ON ss.id = m.mc_sales_staff_id
				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id 
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id
				LEFT JOIN porder p ON p.id = op.porder_id 
				LEFT JOIN commissionpaid cp ON p.id = cp.porder_id AND cp.user_id = u.id
				LEFT JOIN payment pa ON pa.id = p.payment_id 
				WHERE ss.user_id = " . $user . " 
				GROUP BY p.id";
				$orders = DB::select(DB::raw($sqlv));
				foreach ($orders as $order) {
					if(!is_null($order->revenue) && $order->revenue > 0){
						$update = DB::table('orderproduct')->where('porder_id',$order->orderid)->update(['commission_paid'=> true]);
						$insert = DB::table('commissionpaid')->insert(['porder_id'=>$order->orderid,'user_id'=>$user,'role_id'=>$role_id]);
						$outputs[$order->orderid][$user] = $order->revenue * ($order->rate/100);
					}
				}			
			}
            $i++;
        }

        return array($outputs, $total_amount);
    }	
	
    /**
     * [processed user array for making payment]
     * @param  [array] $user_array [user array contains user id]
     * @param  [string] $user_type  [user role]
     * @return [array]  [processed user array, total amount array, total product array]
     */
    private function processed_output($user_array, $user_type)
    {
        $type = $user_type;
        $orders = array();
        $products = array();
        $outputs = array();
        $total_amount = 0;
        $total_product = 0;
        $i = 0;
        if(isset($user_array[$type])){
        foreach ($user_array[$type] as $user) {
            $orders[$i] = POrder::where('user_id',$user)->select('id')->get();
            $j = 0;
            // By Ahmed Fayyaz Butt
            $temp = Employee::where('id',$user)->first();
            $temp->payment = 1;
            $mytime = Carbon::now();
            $temp->payment_at =  $mytime->toDateTimeString();
            $temp->save();
            foreach ($orders[$i] as $order) {
                $products[$j]= OrderProduct::where('porder_id',$order['id'])->select('product_id','quantity')->get();

                foreach ($products[$j] as $product) {

                    $quantity =  $product['quantity'];
                    $product_id = $product['product_id'];

                    $product_price = Product::where('id',$product_id)->select('retail_price')->first();

                    $total_price = ($product_price->retail_price) * $quantity;
                    $total_amount = $total_amount + $total_price;
                    $total_product = $total_product + 1;

                    $outputs[$order->id][$product->product_id][$user] = $total_price;
                }
                $j++;
            }
            $i++;
        }
        }
        return array($outputs, $total_amount, $total_product);
    }

    /**
     * [processed user array for making payment]
     * @param  [array] $user_array [user array contains user id]
     * @param  [string] $user_type  [user role]
     * @return [array]  [processed user array, total amount array, total product array]
     */
    private function processed_output_for_order($orders)
    {
        $products = array();
        $outputs = array();
        $total_amount = 0;
        $total_product = 0;

        foreach ($orders as $key => $order) {
            $products[$key]= OrderProduct::where('porder_id',$order)->select('product_id','quantity')->get();
            $user= POrder::where('id',$order)->select('user_id')->get();

            $user_id = $user[0]->user_id;

            foreach ($products[$key] as $product) {

                $quantity =  $product['quantity'];
                $product_id = $product['product_id'];

                $product_price = Product::where('id',$product_id)->select('retail_price')->first();

                $total_price = ($product_price->retail_price) * $quantity;
                $total_amount = $total_amount + $total_price;
                $total_product = $total_product + 1;

                $outputs[$order][$product->product_id][$user_id] = $total_price;
            }
        }

        return array($outputs, $total_amount, $total_product);
    }

    // Save the payment info's and generate bank files
    private function payment_save($total_amount, $total_product, $output)
    {
        $success = true;
        $saved = false;
        $debug = $this->debug;
		$g = $Globals(1);

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
            //$ocbcHeader->branch = '00790';
            $ocbcHeader->branch = $g->ocbc_branch;
			$ocbcHeader->company_cif =
				str_pad($g->ocbc_company_cif, 20, ' ', STR_PAD_RIGHT);
				//str_pad('A999999', 20, ' ', STR_PAD_RIGHT);
			$ocbcHeader->company_name =
				str_pad($g->ocbc_company_name, 30, ' ', STR_PAD_RIGHT);
				//str_pad('Intermedius OpenSupermall', 30, ' ', STR_PAD_RIGHT);
			$ocbcHeader->company_ac_no =
				str_pad($g->ocbc_company_ac_no, 20, '0', STR_PAD_LEFT);
				//str_pad('7901062119', 20, '0', STR_PAD_LEFT);
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
								$bankaccount = DB::table('bankaccount')->
									where('bank_id',$buyer->bankaccount_id)->
									first();

                                // dd($bankaccount);
                                if(isset($bankaccount)){
                                    $account_number = null;
									$xamount = explode(".",
										number_format($amount, 2));
                                    if(isset($xamount[1])){
                                        $pay_amount = $xamount[0].$xamount[1];
                                    }else{
                                        $pay_amount = $xamount[0]."00";
                                    }

                                    if(isset($bankaccount->account_number1)){
                                        $account_number = $bankaccount->account_number1;
                                    }elseif(isset($bankaccount->account_number2)){
                                        $account_number = $bankaccount->account_number2;
                                    }else{
                                        $account_number = null;
                                    }
                                    $bank_id = $bankaccount->bank_id;
                                    $bank = DB::table('bank')->where('id',$bank_id)->first();
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
                                        print "bank_account not found\n";
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

                Storage::disk('local')->put($filename,  File::get($path));

                $saved = true;

            }else{
                if($debug){
                    print "file not found\n";
                }
            }
        }

        if(!$debug){
            if($saved == true){
                Session::flash('success_msg','Payment successfull !! Payment file has generated.');
                return $saved;
            }else{
                Session::flash('error_msg','Payment failed !!');
                return $saved;
            }
        }
    }
	
    // Save the payment info's and generate bank files
    private function payment_savepc($total_amount, $output)
    {
        $success = true;
        $saved = false;
        $debug = $this->debug;

		$g = $Globals(1);
        $ocbcHeader = new OcbcHeader;
        $ocbcTrailer = new OcbcTrailer;
        $ocbcTrailer->record_type = '03';
        $ocbcTrailer->total_count = str_pad(0, 6, '0', STR_PAD_LEFT);
        $ocbcTrailer->total_amount = str_pad($total_amount, 19, '0', STR_PAD_LEFT);
        $ocbcTrailer->filler1 = str_pad(' ', 255, ' ', STR_PAD_LEFT);
        $ocbcTrailer->filler2 = str_pad(' ', 198, ' ', STR_PAD_LEFT);

        if($ocbcTrailer->save()){
            $now = \Carbon\Carbon::now()->toDateString();
            $date = \Carbon\Carbon::parse($now)->format('dmY');

            $ocbcHeader->ocbc_trailer_id = $ocbcTrailer->id;
            $ocbcHeader->record_type = '01';
            $ocbcHeader->tape_id = '002';
            $ocbcHeader->branch = $g->ocbc_branch;
            //$ocbcHeader->branch = '00790';
			$ocbcHeader->company_cif =
				str_pad($g->ocbc_compay_cif, 20, ' ', STR_PAD_RIGHT);
				//str_pad('A999999', 20, ' ', STR_PAD_RIGHT);
			$ocbcHeader->company_name =
				str_pad($g->ocbc_company_name, 30, ' ', STR_PAD_RIGHT);
				//str_pad('Intermedius OpenSupermall', 30, ' ', STR_PAD_RIGHT);
			$ocbcHeader->company_ac_no =
				str_pad($g->ocbc_company_ac_no, 20, '0', STR_PAD_LEFT);
				//str_pad('7901062119', 20, '0', STR_PAD_LEFT);
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
                        foreach ($output[$okey] as $ukey => $amount) {
                            $userID = $ukey;
                            $user = User::where('id',$userID)->first();
							$merchant = Merchant::where('user_id',$userID)->
								first();
							$buyer = DB::table('buyer')->
								where('user_id',$userID)->first();


							if(isset($user) and isset($merchant) and
							   isset($buyer)) {
							   $bankaccount = DB::table('bankaccount')->
								   where('bank_id',$buyer->bankaccount_id)->
								   first();

                                // dd($bankaccount);
                                if(isset($bankaccount)){
                                    $account_number = null;
									$xamount = explode(".",
										number_format($amount, 2));
                                    if(isset($xamount[1])){
                                        $pay_amount = $xamount[0].$xamount[1];
                                    }else{
                                        $pay_amount = $xamount[0]."00";
                                    }

									dump($xamount);
									dump($pay_amount);

                                    if(isset($bankaccount->account_number1)){
                                        $account_number = $bankaccount->account_number1;
                                    }elseif(isset($bankaccount->account_number2)){
                                        $account_number = $bankaccount->account_number2;
                                    }else{
                                        $account_number = null;
                                    }
                                    $bank_id = $bankaccount->bank_id;
                                    $bank = DB::table('bank')->where('id',$bank_id)->first();
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
                                        $ref = $order_ID.';'.$userID.';'.$pay_amount;
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
                                            $ocbcInv->invoice_details = $order_ID.';'.$pay_amount;
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
                                        print "bank_account not found\n";
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

                Storage::disk('local')->put($filename,  File::get($path));

                $saved = true;

            }else{
                if($debug){
                    print "file not found\n";
                }
            }
        }

        if(!$debug){
            if($saved == true){
                Session::flash('success_msg','Payment successfull !! Payment file has generated.');
                return $saved;
            }else{
                Session::flash('error_msg','Payment failed !!');
                return $saved;
            }
        }
    }	
}
