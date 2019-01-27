<?php

namespace App\Http\Controllers;
use App\Classes\FPX;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Log;
use App\Models\FPXREF;
use App\Models\FPXAC;
use Cart;
use GuzzleHttp\Client;
use Redirect;
use Session;

define('FPXLOG', '/tmp/fpx.log');

class FPXController extends Controller
{
	public static function log2file($data, $logfile){
        $fp = fopen($logfile, 'a');
		fwrite($fp, $data."\n");
		fwrite($fp, "-----------------------------------------------\n");
		fclose($fp);
    }
 
    public function show_receipt_page() {
        /*
            Post payment show the receipt page to buyer.
            Need to show the following information to the buyer
            a. Transaction Date
            b. Transaction Amount
            c. Seller Order Number
            d. FPX Transaction ID
            e. Buyer Bank Name
            f. Transaction Status
        */ 

        return view("cart.post_payment_receipt");
    }

    public function fake_ac() {
        $ret="fpx_msgType%3DAC%0Afpx_msgToken%3D01%0Afpx_fpxTxnId%3D1610181200130689%0Afpx_sellerExId%3DEX00002460%0Afpx_sellerExOrderNo%3D2204757146129723630%0Afpx_fpxTxnTime%3D20161018115351%0Afpx_sellerTxnTime%3D20161018120215%0Afpx_sellerOrderNo%3D5408327679348321178%0Afpx_sellerId%3DSE00006921%0Afpx_txnCurrency%3DMYR%0Afpx_txnAmount%3D1.00%0Afpx_checkSum%3D22B141C646CDD15C5B5AD647A274C106FF80FBDFE727F8000%0AD456EB269355526D7B13F2AF1E2BB8A38530860C7D977706606CCE6324898B5%0A2B697266E7B50B2541788194BC52B8FC04E6C36B937F82DC06AF64BD99D359%0A4496468538E92CB979E216929326B331B93B12222F226EF0C15482E50C1A5F9%0AE72CF370DDADD43831AC5B7384FC97F66C97A9F04E75BB80642752E4CEB32%0ADF3F5429809CA9DD9810FF4DC495CF0CCFD09BAA11EE689B6DB5AB3071EF%0A57D2A30F4CFD0CF0AB38910AD97EC9B1B6B9A29113E58822B3FAF978670ED%0A2A0B9DF37AC995FFDD9533893167D8AD5A96C456A8E324F9BCE5A8BBB5483%0AD01AB6EBBB02E189C31E5CA0093CEF6D%0Afpx_buyerName%3DBuyer%20Name%0Afpx_buyerBankId%3DTEST0021%0Afpx_buyerBankBranch%3DSBI%20BANK%20A%0Afpx_buyerId%3DBuyer1234%0Afpx_makerName%3DMaker%20Name%0Afpx_buyerIban%3D%0Afpx_debitAuthCode%3D00%0Afpx_debitAuthNo%3D15733223%0Afpx_creditAuthCode%3D00%0Afpx_creditAuthNo%3D42424224";

        return $ret;
    }

	/* This is triggered by the [Pay] button in cartview */
    public function checksum_over_ajax(Request $req)
    {
        $ret=array();
		$ret['matomo']=null;
        $ret['status']="failure";
		$orderproduct = null;
		$prod = array();
		$order = array();
		$globals = DB::table('global')->first();

		/* Populating porder data from Matomo ECommerce integration */
		/*
		try {
			$order['id']		= null;
			$order['revenue']	= null;
			$order['gst']		= null;
			$order['shipping']	= null;
			$order['discount']	= null;

		} catch (\Exception $e) {
			Log::error($e->getFile().":".$e->getLine().",".$e->getMessage());
		}
		*/

        try {
			$amount_without_delivery= Cart::total();
			$delivery=0;
			$amount=0;
			$product = array();
			$allcats = array();
			foreach (Cart::contents() as $k) {
				$p = null;
				$delivery=$delivery+$k->delivery_price;

				$allcats = UtilityController::get_allcats($k->id);

				$p['id']	 	= $k->id;
				$p['name']	 	= $k->name;
				$p['category']	= $k->category;
				$p['price']	  	= $k->price;
				$p['quantity']	= $k->quantity;
				$p['delivery']	= $k->delivery_price;
				array_push($product, $p);
			}
			Log::debug($product);

			$epsilon=0.01; //very important!!!
			$amount=Session::get('amount_due');
			$fpx=new FPX;
			$r=(object)array();
			$r->reference_number=$req->refno;
			$r->amount=$amount/100;
			$r->buyer_bankid=$req->bank;

			self::log2file("BEFORE get_ar_msg(): session_id()=".
				session_id(), FPXLOG);
							
			$fpx_form=$fpx->get_ar_msg($r);

			self::log2file("AFTER get_ar_msg(): session_id()=".
				session_id(), FPXLOG);

			//$fpx_post_url=$fpx->fpx_url_test;
			$fpx_post_url=$fpx->get_primary_url($globals);
			$ret['status']="success";
			$ret['fpx_form']=$fpx_form;
			$ret['fpx_post_url']=$fpx_post_url;
			$ret['matomo']=$product;
            
        } catch (\Exception $e) {
            $error=$e->getMessage();
            $ret['short_message']=$error;
			Log::error($e->getFile().":".$e->getLine().",".$e->getMessage());
        }

        return response()->json($ret);
    }

    public function handle_ac_direct(Request $r) {
		/* Response to FPX
		   We create the order here. Not at INDIRECT.  */ 
		$fpx_buyerBankBranch=$_POST['fpx_buyerBankBranch'];
		$fpx_buyerBankId=$_POST['fpx_buyerBankId'];
		$fpx_buyerIban=$_POST['fpx_buyerIban'];
		// $fpx_buyerId=$_POST['fpx_buyerId'];
		// $fpx_buyerId=360;
		$fpx_buyerName=$_POST['fpx_buyerName'];
		$fpx_creditAuthCode=$_POST['fpx_creditAuthCode'];
		$fpx_creditAuthNo=$_POST['fpx_creditAuthNo'];
		$fpx_debitAuthCode=$_POST['fpx_debitAuthCode'];
		$fpx_debitAuthNo=$_POST['fpx_debitAuthNo'];
		$fpx_fpxTxnId=$_POST['fpx_fpxTxnId'];

		$fpx_fpxTxnTime=$_POST['fpx_fpxTxnTime'];

		$fpx_makerName=$_POST['fpx_makerName'];

		$fpx_msgToken=$_POST['fpx_msgToken'];
		$fpx_msgType=$_POST['fpx_msgType'];

		self::log2file($fpx_fpxTxnId.':'.$fpx_debitAuthCode.':'.
			$fpx_msgType.':DIRECT AC RECEIVED', FPXLOG);


		$fpx_sellerExId=$_POST['fpx_sellerExId'];

		$fpx_sellerExOrderNo=$_POST['fpx_sellerExOrderNo'];

		$fpx_sellerId=$_POST['fpx_sellerId'];
		$fpx_sellerOrderNo=$_POST['fpx_sellerOrderNo'];

		$fpx_sellerTxnTime=$_POST['fpx_sellerTxnTime'];

		$fpx_txnAmount=$_POST['fpx_txnAmount'];
		$fpx_txnCurrency=$_POST['fpx_txnCurrency'];
		$fpx_checkSum=$_POST['fpx_checkSum'];

		$data = $fpx_buyerBankBranch."|".
			$fpx_buyerBankId."|".
			$fpx_buyerIban."|".
			$fpx_buyerName."|".
			$fpx_creditAuthCode."|".
			$fpx_creditAuthNo."|".
			$fpx_debitAuthCode."|".
			$fpx_debitAuthNo."|".
			$fpx_fpxTxnId."|".
			$fpx_fpxTxnTime."|".
			$fpx_makerName."|".
			$fpx_msgToken."|".
			$fpx_msgType."|".
			$fpx_sellerExId."|".
			$fpx_sellerExOrderNo."|".
			$fpx_sellerId."|".
			$fpx_sellerOrderNo."|".
			$fpx_sellerTxnTime."|".
			$fpx_txnAmount."|".
			$fpx_txnCurrency;

		$variables = NULL;
		$variables=get_defined_vars();

		$res=UtilityController::dynamic_save($variables,"fpx_AC");
		self::log2file('fpxac_id='.$res, FPXLOG);

		$fpxac_id=$res;
		$fpx= new FPX;
		$tstatus="start";

		try {
			self::log2file('BEFORE fpx_debitAuthCode='.$fpx_debitAuthCode,
				FPXLOG);

			if ($fpx_debitAuthCode=="00" && $fpx_debitAuthNo!="") {
				/* Payment was successful. Create Order. */
				$fpxref=DB::table('fpxref')->
					where('ref_no',$fpx_sellerOrderNo)->first();

				$user_id=$fpxref->user_id;
				$session_id=$fpxref->cart_session_id;

				self::log2file('BEFORE CartController', FPXLOG);

				/* This is where porder is created */
				$result=CartController::complete_successful_transaction(
					$user_id, $fpx_sellerOrderNo,$fpx_txnAmount, $fpx_fpxTxnId);

				self::log2file('AFTER CartController: res='.$result, FPXLOG);

				if ($result==1) {
					$tstatus="Success";
					self::log2file('BEFORE delete_cart:'.$session_id, FPXLOG);
					$result = UtilityController::delete_cart($session_id);
					self::log2file('AFTER delete_cart: res='.$result, FPXLOG);

				} else {
					$tstatus=$result;
					/* Mail the buyer of failure */
				}
				$tstatus=$result;

			} else if($fpx_debitAuthCode=="09") {
				$tstatus=$fpx->get_status_by_code($fpx_debitAuthCode);
				$fref=FPXREF::find($fpxref->id);
				$fref->fpx_resp=$fpx_debitAuthCode;
				$fref->save();

			} else {
				$tstatus=$fpx->get_status_by_code($fpx_debitAuthCode);
			}

		} catch (\Exception $e) {
			$tstatus=$e->getMessage();
			self::log2file('Exception:'.json_encode($e), FPXLOG);
			Log::error($e->getFile().":".$e->getLine().",".$e->getMessage());
		}

		self::log2file("tstatus=".$tstatus, FPXLOG);
		//echo "OK";

		/* Important! Critical for acknowledging the FPX AC message */
		return "OK";
    }

    public function handle_ac_indirect(Request $r) {
        /*
        Only to be used for displaying status to the buyer.
		No order creation should be done
        */
        //$response=$this->fake_ac();
        $fpx_buyerBankBranch=$_POST['fpx_buyerBankBranch'];
        $fpx_buyerBankId=$_POST['fpx_buyerBankId'];
        $fpx_buyerIban=$_POST['fpx_buyerIban'];
        $fpx_buyerId=$_POST['fpx_buyerId'];
        $fpx_buyerName=$_POST['fpx_buyerName'];
        $fpx_creditAuthCode=$_POST['fpx_creditAuthCode'];
        $fpx_creditAuthNo=$_POST['fpx_creditAuthNo'];
        $fpx_debitAuthCode=$_POST['fpx_debitAuthCode'];
        $fpx_debitAuthNo=$_POST['fpx_debitAuthNo'];
        $fpx_fpxTxnId=$_POST['fpx_fpxTxnId'];
        $fpx_fpxTxnTime=$_POST['fpx_fpxTxnTime'];

        $fpx_makerName=$_POST['fpx_makerName'];
        $fpx_msgToken=$_POST['fpx_msgToken'];
        $fpx_msgType=$_POST['fpx_msgType'];
        $fpx_sellerExId=$_POST['fpx_sellerExId'];
        $fpx_sellerExOrderNo=$_POST['fpx_sellerExOrderNo'];
        $fpx_sellerId=$_POST['fpx_sellerId'];
        $fpx_sellerOrderNo=$_POST['fpx_sellerOrderNo'];
        $fpx_sellerTxnTime=$_POST['fpx_sellerTxnTime'];
        $fpx_txnAmount=$_POST['fpx_txnAmount'];
        $fpx_txnCurrency=$_POST['fpx_txnCurrency'];
        $fpx_checkSum=$_POST['fpx_checkSum'];

        $data=$fpx_buyerBankBranch."|".
        $fpx_buyerBankId."|".
        $fpx_buyerIban."|".
        $fpx_buyerId."|".
        $fpx_buyerName."|".
        $fpx_creditAuthCode."|".
        $fpx_creditAuthNo."|".
        $fpx_debitAuthCode."|".
        $fpx_debitAuthNo."|".
        $fpx_fpxTxnId."|".
        $fpx_fpxTxnTime."|".
        $fpx_makerName."|".
        $fpx_msgToken."|".
        $fpx_msgType."|".
        $fpx_sellerExId."|".
        $fpx_sellerExOrderNo."|".
        $fpx_sellerId."|".
        $fpx_sellerOrderNo."|".
        $fpx_sellerTxnTime."|".
        $fpx_txnAmount."|".
        $fpx_txnCurrency;

        //dump($_POST);
        $variables=get_defined_vars();
        $table="fpx_AC";
        // $res=UtilityController::dynamic_save($variables,$table);
        // $fpxac_id=$res->id;
        // Verify the $data against the checksum.
        // DB query.
        $fpx= new FPX;
        $tstatus=$fpx->get_status_by_code($fpx_debitAuthCode);
        return view("cart.post_payment_receipt")->
            with('t_date',$fpx_sellerTxnTime)->
            with('t_amount',$fpx_txnAmount)->
            with('t_refno',$fpx_sellerOrderNo)->
            with('t_bank',$fpx_buyerBankId)->
            with('t_status',$tstatus)->
            with('t_fpx_id',$fpx_fpxTxnId);

        //return $response;
    }

    public function fpx_sim(Request $r) {
        return $this->handle_ac_indirect();
    }
}
