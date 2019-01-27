<?php
//
namespace App\Http\Controllers;
use App\Classes\SecurityIDGenerator;
use App\Classes\StationIntelligence;
use App\Classes\FPX;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\APICapsOcreditController;
use App\Http\Controllers\SMMController;
use App\Models\OpenWishPledge;
use App\Models\Owarehouse_pledge;
use App\Models\PGP;
use App\Models\SMMin;
use App\Models\SMMout;
use App\Models\Ocredit;
use App\Models\SalesStaff;
use App\Models\OpenWish;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\CREController;
use App\OWish;
use Carbon;
use Log;
use Cart;
use App\Models\Ctrans;
use App\Models\Cart as DBCart;
use App\Models\Product;
use App\Models\PaymentRequest;
use App\Models\PaymentResponse;
use App\Models\GlobalT;
use App\Models\POrder;
use App\Models\SOrder;
use App\Models\Receipt;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderProduct;
use App\Models\OrderProduct;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\Address;
use App\Models\User;
use App\Models\Payment;
use App\Models\PRef;
// use App\Models\SMMin;
use App\Jobs\OpenwishPledgeJob;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use Mailgun\Mailgun;
use Input;
use Redirect;
use Auth;
use DB;
use Session;
use URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

define("LOGFILE", "/tmp/osmall.log");

class MakePaymentController extends Controller
{

    private $limit = 5;
    private $days = 90;

	public function log2file($data, $logfile) {
        $fp = fopen($logfile, 'a');
		fwrite($fp, $data."\n");
        fwrite($fp, "-------------------------------------------------\n");
        fclose($fp);    
	}

	public function md5_id()
	{
		
	}

	public function postOrder(Request $request)
    {
    	// Lazy returb
    	if (!Auth::check()) {
    		# code...
    		return "You are not logged in";
    	}
    	try {
		// dd("dsadfsaf");
        $now = \Carbon\Carbon::now()->toDateTimeString();
        try {
        	$user = Auth::user()->id;
        } catch (\Exception $e) {
        	return "You are not logged in";
        }

		$useris = DB::table('users')->where('id',$user)->first();
        $paymentID = Input::get('card');
        $productDesc = Input::get('ProdDesc');
        $remark = Input::get('Remark');
        $pick_station = Input::get('pick_station');
        $language = Input::get('Lang');
        $responseURL = Input::get('ResponseURL');
        $courierID = 1;
        $currency = DB::table('currency')->pluck('code');
        $receipt_tstamp = $now;
        $checkout_tstamp = $now;
        $delivery_tstamp = $now;

        $saved = false;
        $identifier = '';
        $contents = Cart::contents();

        // dd($contents);

		$address = Address::find(Auth::user()->shipping_address_id);
		if (is_null($address)) {
			# code...
			return "No saved address";
		}
		// Issue
		/*For users who login though FB or any other social media account there is no address . This code doesn't deals with such cases
			and an ugly exception gets throwns up.
		 */
		// return $address;
		if($pick_station == 0){
			$station_picked = $this->get_station($address, $contents);
		} else {
			$station_picked = $pick_station;
		}
        $getTotal = Cart::total();

        // dd($getTotal);

        $payment = new Payment;
        $payment->receivable = $getTotal*100;
        $payment->save();

        $cartProducts = Cart::contents();
        foreach ($cartProducts as $key => $cartProduct) {
            $id = $cartProduct->id;
            $merchant = DB::select(DB::raw("SELECT m.id AS mid, m.oshop_name AS oshop, m.company_name AS company FROM users u , merchantproduct mp, merchant m WHERE mp.product_id = $id AND mp.merchant_id = m.id AND m.user_id = u.id GROUP BY m.id"));
            $cartProducts[$key]->mid = $merchant[0]->mid;
            $cartProducts[$key]->oshop = $merchant[0]->oshop;
            $cartProducts[$key]->company = $merchant[0]->company;
        }

        $merchants = array();
        foreach ($cartProducts as $key => $cp) {
            if (!in_array($cp->mid, $merchants)){
                $merchants[$key] = $cp->mid;
            }
        }

		$varhtml = '
			<h3>Thank you for buying on OpenSupermall.com.</h3>
			<p>Your order details</p>
			<table class="table table-bordered cart-table" style="margin-top:20px">
				<thead>
					<tr style="background-color: #e0e0e0;">
						<th style="text-align:center;">Product ID</th>
						<th style="text-align:center;">Product Name</th>
						<th style="text-align:center;">Unit Price</th>
						<th style="text-align:center;">Quantity</th>
						<th style="text-align:center; border:none">Total</th>
					</tr>
				</thead>';
		$sumtotal = 0;
        $products = array();
        foreach ($merchants as $m) {
			$varhtml .= '
			  	<tr>
			  		<td colspan="5">
			  			<strong><span id="mcomp-'.$m->id.'"></span></strong>
			  			<span id="moshop-'.$m->id.'"></span>
			  		</td>
			  	</tr>
			';
			$sum = 0;
			$order = new POrder;

			$order->user_id = $user;
			$order->courier_id = $courierID;
			$order->payment_id = $payment->id;
			$order->status = 'pending';
			$order->receipt_tstamp = $receipt_tstamp;
			$order->checkout_tstamp = $checkout_tstamp;
			$order->delivery_tstamp = $delivery_tstamp;
			$order->station_id = $station_picked;
			if ($order->save()) {		
				$date = date('Y-m-d H:i:s');
				$receipt = DB::table('receipt')->insertGetId(['porder_id' =>  $order->id,'do_password'=>substr( md5($date),0, 8),'created_at'=>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
				$deliveryorder = DB::table('deliveryorder')->insertGetId(['receipt_id' =>  $receipt,'status'=>'pending','created_at'=>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
				foreach ($cartProducts as $item) {
					$identifier = $item->identifier;
					if ($item->mid == $m) {
						$varhtml .= '<tr>
							<td style="text-align:center">['.str_pad($item->id, 10, '0', STR_PAD_LEFT) .']</td>
							<td style="padding-bottom:0;padding-top:0;text-align:left">
								&nbsp;
								'.$item->name.'
							</td>
							<td style="padding-bottom:8px;padding-top:8px">
								<span>'.$currency.'</span> '. number_format((float)$item->price/100,2) .'
							</td>
							<td style="width:14%;padding-bottom:0;padding-top:0">
								'.$item->quantity.'
							</td>
							<td>
								<span>'.$currency.'</span> '. number_format((float)(($item->price + ($item->delivery_price*100)) * $item->quantity)/100,2) .'
							</td>
						</tr>';	
						$sum += (($item->price + ($item->delivery_price*100)) * $item->quantity)/100;
						$sumtotal += (($item->price + ($item->delivery_price*100)) * $item->quantity)/100;
						//$products[$m][$key] = $cartP;
						$deliveryorderp = DB::table('deliveryordersproduct')->insertGetId(['do_id' =>  $deliveryorder,'product_id'=>$item->id,'quantity'=>$item->quantity,'status'=>'pending','created_at'=>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
						$orderproduct = DB::table('orderproduct')->insertGetId(['porder_id' =>  $order->id,'product_id'=>$item->id,'quantity'=>$item->quantity,'order_price'=>$item->price,'order_delivery_price'=>$item->delivery_price,'status'=>'pending','created_at'=>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
					}
				}
			}
        }

		$varhtml .= '
			<tr>
				<td colspan="3"  style="border-right:0px">&nbsp;</td>
				<th style="border-right:0px; border-left: 0px">Grand Total :</th>
				<td style="text-align: center; border-left:0px>
					'.$currency.' '. number_format((float)($sum)).'
				</td></tr>';
		try{
			$mgClient = new Mailgun('key-80495c8905443d885803333b49b45718');
			$domain = "opensupermall.com";

			# Make the call to the client.
			$result = $mgClient->sendMessage($domain, array(
				'from'    => 'Opensupermall <info@opensupermall.com>',
				'to'      => $useris->first_name . ' ' . $useris->first_name .  ' <'. $useris->email .'>',
				'subject' => 'Your Opensupermall order',
				'html'    => $varhtml
			));
		} catch (\Exception $e){
			Log::error($e->getFile().":".$e->getLine().",".$e->getMessage());
		}


        $orderID = POrder::orderBy('id', 'desc')->first()->id;

		$saved = true;
		$res = DB::table('stationarea')->insert(['area_id' =>  $address->area_id, 'station_id' => $station_picked, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'last_pick' => date('Y-m-d H:i:s'), 'amount' => $sumtotal]);

        if ($saved == true) {
			
            if (isset($contents[$identifier]->openwish_id)) {
                $product = Product::where('id',$contents[$identifier]->id)->
					leftJoin('productdetail',
						'productdetail.id','=','product.productdetail_id')->
					select('product.*','productdetail.data as product_details')->
					first();

                //Prepare data for facebook link
                $data = array(
                    'product_id' => $product->id,
                    'product_photo' => $product->photo_1,
                    'product_original_price' => $product->retail_price,
                    'product_retail_price' => $product->discounted_price,
                    'product_name' => $product->name,
                    'oshop_name' => $contents[$identifier]->oshop_name,
                    'openwish_id' => $contents[$identifier]->openwish_id,
                    'product_details' => $product->product_details

                );
                $this->sharePost($data);
            }

            $global = new GlobalT;

            $global = GlobalT::get(['ipay88_merchant_key', 'ipay88_merchant_code'])->toArray();

            $merchantKey = $global[0]['ipay88_merchant_key'];
            $merchantCode = $global[0]['ipay88_merchant_code'];
            $refNo = $orderID;
            $total = str_replace(array('.', ','), '', $sumtotal);

            $src = $merchantKey . $merchantCode . $refNo . $total . $currency;
            $signature = $this->iPay88_signature($src);

            $paymentRequest = new PaymentRequest;

            $paymentRequest->payment_id = $payment->id;
            $paymentRequest->merchant_code = $merchantCode;
            $paymentRequest->iPay88_payment_id = $paymentID;
            $paymentRequest->ref_no = !is_null($refNo) ? $refNo : 0;
            $paymentRequest->amount = $getTotal;
            $paymentRequest->currency = $currency;
            $paymentRequest->prod_desc = $productDesc;
            $paymentRequest->user_name = Auth::user()->first_name;
            $paymentRequest->user_email = Auth::user()->email;
            $paymentRequest->user_contact = Auth::user()->mobile_no;
            $paymentRequest->remark = $remark;
            $paymentRequest->lang = $language;
            $paymentRequest->signature = $signature;
            $paymentRequest->response_url = $responseURL;
            $paymentRequest->backend_url = 'test_url';

            if ($paymentRequest->save()) {
                //After a successfull payment fire smmin

                // $csoi = $contents[$identifier]->smmout_id;
                // $csii = $contents[$identifier]->smedia_id;

                // $csoi = 11;
                // $csii = 11;

                // return $csii;
                /**
                 * if order done via social media insert smm record
                 */
                // if($csoi != null and $csii != null) {
                	$smmIN = new SMMin();
                	// $smmIN->smmout_id = $csoi;
                	// $smmIN->smedia_id = $csii;
                	$smmIN->source_ip = $request->ip();
                	$smmIN->response = 'buy';
                	$smmIN->porder_id = $orderID;
                   	$smmIN->save();
                // }
                Cart::destroy();
                $page = Session::get('page');
                if($page == 'owarehouse'){
                    Session::forget('page');
                }
            }
        }

        $returnValue[0] = $payment->id;
        $returnValue[1] = $refNo;
        $returnValue[2] = $signature;

        return $returnValue;

    	} catch (\Exception $e) {
    		return $e;
    		return "Something went wrong in pre-initialization";
    	}
    }

	public function get_station($address, $contents){
		$limit = 5;
		$days = 90;
		$station_picked = 0;
		$date = date('Y-m-j H:i:s');
		$newdate = strtotime ( '-' . $days .' day' , strtotime ( $date ) ) ;
		$newdate = date ( 'Y-m-j H:i:s' , $newdate );
		$stations = null;
		// return $address->area_id;
		if(!is_null($address)){
			if(!is_null($address->area_id)){
				$sqlselect = "SELECT DISTINCT (station.id) as id,(((acos(sin((address.latitude*pi()/180)) * 
					sin((" . $address->latitude . "*pi()/180))+cos((address.latitude*pi()/180)) * 
					cos((" . $address->latitude . "*pi()/180)) * cos(((address.longitude - " . $address->longitude . ")* 
					pi()/180))))*180/pi())*60*1.1515
				) as distance ";
				$sqlfrom = " FROM station, address, sproperty ";
				$sqlwhere = " WHERE (station.id = sproperty.station_id AND sproperty.address_id = address.id AND address.area_id = " . $address->area_id . ") OR (station.station_address_id  = address.id AND address.area_id = " . $address->area_id . ")";
				$sqlorder = " ORDER BY distance LIMIT " . $limit; 
				$k=0;
				foreach ($contents as $l) {
					$item=Cart::item($l);
					$k++;
					$sqlfrom = $sqlfrom . " , stationsproduct as st" . $k . ", sproduct as sproduct" . $k . " ";
					$sqlwhere = $sqlwhere . " AND st" . $k . ".station_id = station.id AND sproduct" . $k . ".id = st" . $k . ".sproduct_id AND sproduct" . $k . ".product_id = " . $item->id . " AND sproduct" . $k . ".available >= " . $item->quantity . " AND sproduct" . $k . ".stock > 0 ";
				}

				$sqltotal = $sqlselect . $sqlfrom . $sqlwhere . $sqlorder;

				$stations = DB::select(DB::raw($sqltotal));
			}
			$arrstations = array();
			$arrsums = array();
			if(!is_null($stations)){
				$k=0;
				$sum = 10000;
				
				foreach ($stations as $st) {
					$station = null;
					$stationsum = DB::select(DB::raw("SELECT * FROM stationarea WHERE station_id = " . $st->id . " AND created_at > '" . $newdate . "'"));
					foreach ($stationsum as $sum) {
						$station = $sum->id;
					}
					if(!is_null($station)){
						$arrstations[$k] = $st->id;
						$arrsums[$k] = $sum;
						$k++;
					} else {
						$station_picked = $st->id;
						break;
					}
					$sum--;
				}
				if($station_picked == 0){
					$least_ammount = 1000000000;
					$least_id = 0;
					for($i=0;$i<$limit;$i++){
						if($arrsums[$i]<$least_ammount){
							$least_ammount = $arrsums[$i];
							$least_id = $arrstations[$i];
						}
					}
					$station_picked = $least_id;
				}
			} else {
				if(!is_null($address->city_id)){
					$sqlselect = "SELECT DISTINCT (station.id),(((acos(sin((address.latitude*pi()/180)) * 
					sin((" . $address->latitude . "*pi()/180))+cos((address.latitude*pi()/180)) * 
					cos((" . $address->latitude . "*pi()/180)) * cos(((address.longitude - " . $address->longitude . ")* 
					pi()/180))))*180/pi())*60*1.1515
				) as distance ";
					$sqlfrom = " FROM station, address, sproperty ";
					$sqlwhere = " WHERE (station.id = sproperty.station_id AND sproperty.address_id = address.id AND address.city_id = " . $address->city_id . ") OR (station.station_address_id  = address.id AND address.city_id = " . $address->city_id . ")";
					$sqlorder = " ORDER BY distance";
					$k=0;
					foreach ($contents as $item) {
						$k++;
						$sqlfrom = $sqlfrom . " , stationsproduct as st" . $k . ", sproduct as sproduct" . $k . " ";
						$sqlwhere = $sqlwhere . " AND st" . $k . ".station_id = station.id AND sproduct" . $k . ".id = st" . $k . ".sproduct_id AND sproduct" . $k . ".product_id = " . $item->id . " AND sproduct" . $k . ".available >= " . $item->quantity . " ";
					}

					$sqltotal = $sqlselect . $sqlfrom . $sqlwhere . $sqlorder;

					$stations = DB::select(DB::raw($sqltotal));
				}
				$arrstations = array();
				$arrsums = array();
				if(!is_null($stations)){
					$k=0;
					$sum = 10000;
					foreach ($stations as $st) {
						$station = null;
						$stationsum = DB::select(DB::raw("SELECT * FROM stationarea WHERE station_id = " . $st->id . " AND created_at > '" . $newdate . "'"));
						foreach ($stationsum as $sum) {
							$station = $sum->id;
						}
						if(!is_null($station)){
							$arrstations[$k] = $st->id;
							$arrsums[$k] = $sum;
							$k++;
						} else {
							$station_picked = $st->id;
							break;
						}
						$sum--;
					}
					if($station_picked == 0){
						$least_ammount = 1000000000;
						$least_id = 0;
						for($i=0;$i<$limit;$i++){
							if($arrsums[$i]<$least_ammount){
								$least_ammount = $arrsums[$i];
								$least_id = $arrstations[$i];
							}
						}
						$station_picked = $least_id;
					}
					$k=0;
					$sum = 10000;
					foreach ($stations as $st) {
						$stationsum = DB::select(DB::raw("SELECT * FROM stationarea WHERE station_id = " . $st->id . " AND created_at > '" . $newdate . "'"));
						foreach ($stationsum as $sum) {
							$station = $sum->id;
						}
						if(!is_null($station)){
							$arrstations[$k] = $st->id;
							$arrsums[$k] = $sum;
							$k++;
						} else {
							$station_picked = $st->id;
							break;
						}
						$sum--;
					}
					if($station_picked == 0){
						$least_ammount = 1000000000;
						$least_id = 0;
						for($i=0;$i<$limit;$i++){
							if($arrsums[$i]<$least_ammount){
								$least_ammount = $arrsums[$i];
								$least_id = $arrstations[$i];
							}
						}
						$station_picked = $least_id;
					}
				}
			}
		}

		return $station_picked;
	}

	public function get_stations(){
        $contents = Cart::contents();
		$address = Address::find(Auth::user()->shipping_address_id);
		$limit = $this->limit;
		$days = $this->days;
		$stations = null;
		$station_picked = 0;
		$date = date('Y-m-j H:i:s');
		$newdate = strtotime ( '-' . $days .' day' , strtotime ( $date ) ) ;
		$newdate = date ( 'Y-m-j H:i:s' , $newdate );

		if(!is_null($address->area_id)){
			$sqlselect = "SELECT DISTINCT (station.id) as id, address.latitude as latitude, address.longitude as longitude, address.line1, address.line2, address.line3,address.line4, station.company_name as company_name,(((acos(sin((address.latitude*pi()/180)) * 
				sin((" . $address->latitude . "*pi()/180))+cos((address.latitude*pi()/180)) * 
				cos((" . $address->latitude . "*pi()/180)) * cos(((address.longitude - " . $address->longitude . ")* 
				pi()/180))))*180/pi())*60*1.1515
			) as distance ";
			$sqlfrom = " FROM station, address, sproperty ";
			$sqlwhere = " WHERE (station.id = sproperty.station_id AND sproperty.address_id = address.id AND address.area_id = " . $address->area_id . ") OR (station.station_address_id  = address.id AND address.area_id = " . $address->area_id . ")";
			$sqlorder = " ORDER BY distance LIMIT " . $limit;
			$k=0;
			foreach ($contents as $item) {
				$k++;
				$sqlfrom = $sqlfrom . " , stationsproduct as st" . $k . ", sproduct as sproduct" . $k . " ";
				$sqlwhere = $sqlwhere . " AND st" . $k . ".station_id = station.id AND sproduct" . $k . ".id = st" . $k . ".sproduct_id AND sproduct" . $k . ".product_id = " . $item->id . " AND sproduct" . $k . ".available >= " . $item->quantity . " AND sproduct" . $k . ".stock > 0 ";
			}

			$sqltotal = $sqlselect . $sqlfrom . $sqlwhere . $sqlorder;

			$stations = DB::select(DB::raw($sqltotal));
		}
		$arrstations = array();
		$arrsums = array();
		if(!is_null($stations)){
		} else {
			if(!is_null($address->city_id)){
				$sqlselect = "SELECT DISTINCT (station.id) as id, address.latitude as latitude, address.longitude as longitude, address.line1, address.line2, address.line3, address.line4,station.company_name as company_name,(((acos(sin((address.latitude*pi()/180)) * 
				sin((" . $address->latitude . "*pi()/180))+cos((address.latitude*pi()/180)) * 
				cos((" . $address->latitude . "*pi()/180)) * cos(((address.longitude - " . $address->longitude . ")* 
				pi()/180))))*180/pi())*60*1.1515
				) as distance ";
				$sqlfrom = " FROM station, address, sproperty ";
				$sqlwhere = " WHERE (station.id = sproperty.station_id AND sproperty.address_id = address.id AND address.city_id = " . $address->city_id . ") OR (station.station_address_id  = address.id AND address.city_id = " . $address->city_id . ")";
					$sqlorder = " ORDER BY distance";
				$k=0;
				foreach ($contents as $item) {
					$k++;
					$sqlfrom = $sqlfrom . " , stationsproduct as st" . $k . ", sproduct as sproduct" . $k . " ";
					$sqlwhere = $sqlwhere . " AND st" . $k . ".station_id = station.id AND sproduct" . $k . ".id = st" . $k . ".sproduct_id AND sproduct" . $k . ".product_id = " . $item->id . " AND sproduct" . $k . ".available >= " . $item->quantity . " ";
				}

				$sqltotal = $sqlselect . $sqlfrom . $sqlwhere . $sqlorder;

				$stations = DB::select(DB::raw($sqltotal));
				$arrstations = array();
				$arrsums = array();
				if(!is_null($stations)){
				}
			}
		}
		return json_encode($stations);
	}

    public function iPay88_signature($source)
    {
        return base64_encode(hex2bin(sha1($source)));
    }

    public function hex2bin($hexSource)
    {
        for ($i = 0; $i < strlen($hexSource); $i = $i + 2) {
            $bin .= chr(hexdec(substr($hexSource, $i, 2)));
        }
        return $bin;
    }
	
    public function pay_by_ocredit($ref_no,$ocredit_part,$address_id)
    {
    	// Check ocredit balance for user
    	// All transaction must be in cents.
		// Convert to cents whenever necessary
    	try {
    		$user_id=Auth::user()->id;
    	} catch (\Exception $e) {
    		return response()->json([
				'status'=>'failure',
				'short_message'=>-1,
				'long_message'=>'You must be logged in to pay.']);
    	}
    	// try {
    	// 	$scheck=Session::get('checkout');
    	// 	if ($scheck==1) {
    	// 		return response()->json(['status'=>'failure','short_message'=>-1,'long_message'=>'You have already done checkout. Please proceed to payment.']);
    	// 	}else{
    	// 		Session::put('checkout',1);
    	// 	}
    	// } catch (\Exception $e) {
    		
    	// }

		/* Convert to cents and cast to integer */
		$op=explode(".",$ocredit_part);
		
		try {
			$int=$op[0];
		} catch (\Exception $e) {
			$int="00";
		}
		try {
			$dec=$op[1];
		} catch (\Exception $e) {
			$dec="00";
		}
		/*Need to lookout for .
			if 13.5
			13*100 + 5*10
			13.100
			if 13.51

		*/ 
		if (strlen($dec)==1) {
			$dec=(int)($dec)*10;
		}else{
			$dec=(int)($dec);
		}
    	$amount_to_be_paid_by_oc=(int)$int*100+$dec;
        $roles= DB::table('role_users')->
			where('user_id',Auth::user()->id)->get();

        foreach ($roles as $r) {
            switch($r->role_id) {
                case 3:
                    $redirect_to_url=url('dashboard#orders');
                    break;
                case 11:
                    $redirect_to_url=url('station/purchases');
                    break;
                default:
                     $redirect_to_url=url('buyer/dashboard#orders');
            }
        }

		$user_id=Auth::user()->id;
		$address = Address::find(Auth::user()->default_address_id);	
		$address_id=$address->id;	
		// Update Cart Available
		foreach (Cart::contents() as $item) {
			$item->available=Product::find($item->id)->pluck('available');
		}
 		// Add Server Side Validations Here.
 		$CartController=new CartController;
 		$notify=array_filter($CartController->notify());
 	
 		if (!isset($notify) or !empty($notify)) {
 			return response()->json([
				'status'=>'failure',
				'short_message'=>-9,
				'long_message'=>$notify]);
 		}
 		/*
			owishbn -> it is openwish buy now option
 		*/ 
 		foreach (Cart::contents() as $cc) {
			if ($cc->mode != "owish" and
				$cc->mode != "owishbn" and
				$cc->mode != "hyper" and
				$cc->page != "b2b" and
				$cc->mode != "rfee" and
				$cc->mode != "disc") {
		
				$p=Product::find($cc->id);
				$available= $p->available;
				$price=UtilityController::realPrice($cc->id);
				
				if ($price != $cc->price or
					$available<$cc->quantity or
					$p->oshop_selected==false) {
					
					return response()->json([
						'status'=>'failure',
						'short_message'=>-4,
						'long_message'=>"Your Cart's state has changed. Please refresh the page to view the updated values"
					]);
				}
			}
	 	}

   		/* Squidster: Mon Sep  4 16:16:28 MYT 2017
		 * To bypass half-baked ocredit deduction logic */
    	$o_acct=UtilityController::ocredit();
    	$sidg= new SecurityIDGenerator;
    	$security_id= $sidg->generate(Carbon::now()->toDateString());
    	if (is_null($o_acct)) {
    		$ocredit_balance=0;
    	} else{
    		$ocredit_balance=$o_acct['ocredit'];
    	}
    	// $ocredit_balance=999999999;
    	// dd($amount_to_be_paid_by_oc);
    	$amount_without_delivery= Cart::total();
    	$delivery=0;
    	$amount=0;
    	foreach (Cart::contents() as $k) {
    		$delivery=$delivery+$k->delivery_price;
    		// $p = new PriceController;
    		// $amount+=$p->init($k->id);
    	}
    	$epsilon=0.01; //very important!!!
    	$amount_without_delivery=explode(".",$amount_without_delivery);

    	$amount_without_delivery=(int)$amount_without_delivery[0];
    	$delivery=$delivery*100;
    	$delivery=explode(".",$delivery);
    	$delivery=$delivery[0];
    	$amount=$amount_without_delivery+$delivery;
    	
    	// $amount=(int)abs(ceil($amount_without_delivery+$delivery*100));
		
    	// if (abs($amount-$amount_to_be_paid_by_oc)<$epsilon) {
    	// 	dump($amount_to_be_paid_by_oc,$amount);
    	// 	dump(gettype($amount_to_be_paid_by_oc),gettype($amount));
    	// 	dump($amount-$amount_to_be_paid_by_oc);
    	// }

		if ($ocredit_balance==0) {
			foreach (Cart::contents() as $k) {
				$identifier=$k->identifier.(string)time();
				$k->unique_identifier=$identifier;
				$c= new Ctrans;
				$c->ref_no=$ref_no;
				$c->cart_id=$identifier;
				$c->address_id=$address_id;
				$c->save();
			}
    			
    		$fpx=new FPX;
			$fpx_bank=$fpx->get_banks();
			$fpx_bank_kv=$fpx->bank_kv();
			
			Session::put('amount_due',$amount);	
			$amount_due=number_format($amount/100,2);
			$ff=$this->save_cart_in_db();
			return response()->json([
				'status'=>'success',
				'short_message'=>-2,
				'long_message'=>'Successfull',
				'amount_due'=>$amount_due,
				'fpx_bank'=>$fpx_bank,
				'fpx_bank_kv'=>$fpx_bank_kv,
				'redirect'=>$redirect_to_url]);
    	}

    	if ($amount_to_be_paid_by_oc>$ocredit_balance) {
			/* Pure FPX Payment */
			$fpx=new FPX;
			$fpx_bank=$fpx->get_banks();
			$fpx_bank_kv=$fpx->bank_kv();
			
			Session::put('amount_due',$amount);	
			$amount_due=number_format($amount/100,2);
			
    		return response()->json([
				'status'=>'success',
				'short_message'=>-11,
				'long_message'=>
				'Your ocredit balance is insufficient. Please pay using other methods.',
				'amount_due'=>$amount_due,
				'fpx_bank'=>$fpx_bank,
				'fpx_bank_kv'=>$fpx_bank_kv,
				'redirect'=>$redirect_to_url]);
    	}

		if ($amount_to_be_paid_by_oc > $amount) {
			// foreach (Cart::contents() as $k) {
			// 	$identifier=$k->identifier.(string)time();
			// 	$k->unique_identifier=$identifier;
			// 	$c= new Ctrans;
			// 	$c->ref_no=$ref_no;
			// 	$c->cart_id=$identifier;
			// 	$c->address_id=$address_id;
			// 	$c->save();
			// }

			return response()->json([
				'status'=>'failure',
				'short_message'=>-5,
				'long_message'=>'You have entered more than the total. Please adjust the ocredit value.',
				'redirect'=>$redirect_to_url]);
    	}

    	if ($amount_to_be_paid_by_oc==0) {
			// $amount_due=$amount-$amount_to_be_paid_by_oc;
			foreach (Cart::contents() as $k) {
				$identifier=$k->identifier.(string)time();

				$k->unique_identifier=$identifier;
				$c= new Ctrans;
				$c->ref_no=$ref_no;
				$c->cart_id=$identifier;
				$c->address_id=$address_id;
				$c->save();
				DB::table('stuff')->insert(['note'=>"identifier1|".$c->identifier]);
			}
			$ff=$this->save_cart_in_db();
			DB::table('stuff')->insert(['note'=>$ff]);
			// Cart::destroy();

			/* Pure FPX Payment */
			$fpx=new FPX;
			$fpx_bank=$fpx->get_banks();
			$fpx_bank_kv=$fpx->bank_kv();
			
			Session::put('amount_due',$amount);	
			$amount_due=number_format($amount/100,2);

			return response()->json([
				'status'=>'success',
				'short_message'=>-3,
				'long_message'=>'Successfull',
				'amount_due'=>$amount_due,
				'fpx_bank'=>$fpx_bank,
				'fpx_bank_kv'=>$fpx_bank_kv,
				'redirect'=>$redirect_to_url]);
    	}

    	if ($amount_to_be_paid_by_oc<=$ocredit_balance and $amount_to_be_paid_by_oc!=0) {
    		// Check if Ocredit can cover hundred percent
    		// return [$amount,$amount_to_be_paid_by_oc];
    		$oac= new APICapsOcreditController;

    		// $oac->matches($amount,$ref_no);
    		if (abs($amount-$amount_to_be_paid_by_oc)<$epsilon) {
    			$new_balance=$ocredit_balance-$amount_to_be_paid_by_oc;
    			$oc= new Ocredit;
    			$oc->source="purchase";
    			$oc->value=$amount_to_be_paid_by_oc;
    			$oc->ref_no=$ref_no;
    			$oc->mode="debit";
    			$oc->security_id=$security_id;
    			$oc->save();
    			// Create record in ref_pivot

    			// Create record in Porder for each mid [merchant_id]
    			$global=DB::table('global')->first();
    			$pgc_per=$global->payment_gateway_commission;
				$pgc=($pgc_per*$amount)/100;
				$py= new Payment;
				$py->receivable=$amount; //Cents not MYR
			
				$py->payment_gateway=$pgc;
				$py->status="paid";
				$py->note="ocredit";
				$py->save();

				$pick_station = 0;
    			$m_p_record=array();
    			foreach (Cart::contents() as $item){
    				if ($item->mode=="owish") {
						$email = Auth::user()->email;
    					$openwish_id=$item->openwish_id;
				        $data = array(
				            'openwish_id'    => $openwish_id,
				            'smedia_id'      => 1, //i am not sure whats fb
				            'smedia_account' => $email,
				            'source_ip'      => '0.0.0.0',
				            'pledged_amt'    => $item->pledged_amt,
				        );
    					$this->dispatch( new OpenwishPledgeJob($data) );
    					/*Write a record */
    					$pledge_ocredit=new Ocredit;
						$sidg= new SecurityIDGenerator;
		                $security_id= $sidg->generate(Carbon::now()->toDateString());
		                $pledge_ocredit->security_id=$security_id;
						$pledge_ocredit->value=($item->pledged_amt)+($item->actual_delivery_price*100);
						$pledge_ocredit->mode="debit";
						$pledge_ocredit->openwish_id=$openwish_id;
						$pledge_ocredit->save();  
    					$item->remove();
    					// Write Email Block

    				} else if ($item->mode == "rfee"){
    					return CREController::processCREOrder($item->id);

    				} else if ($item->mode=="hyper" or $item->page=="owarehouse") {
    					$process_hyper=$this->generate_order_hyper($item->identifier,$global,$py,$oc,$user_id,$amount,$ref_no);
    					// dump($process_hyper);
    					if ($process_hyper!="err") {
    						$owarehouse_id= $item->hyper_id;
							$owarehousepledge = new Owarehouse_pledge();
							$owarehousepledge->owarehouse_id =$owarehouse_id;
							$owarehousepledge->user_id=$user_id;
							
							$owarehousepledge->status='active';
							$owarehousepledge->porder_id=$process_hyper;
							$owarehousepledge->pledged_qty =$item->quantity;

							if(!$owarehousepledge->save()){
								$data['status'] = 'error';
							} else {
								$data['status'] = 'success';
								$producthyper = DB::table('product')->
									where('segment','hyper')->
									where('parent_id',$item->parent_id)->first();
								/*
								if(!is_null($producthyper)){
									$available = $producthyper->available - $item->quantity;
									DB::table('product')->
										where('segment','hyper')->
										where('parent_id',$item->parent_id)->
										update(['available'=>$available]);
								}
								*/
							}
							$item->remove();
    					}
    					/*
						if (array_key_exists($item->mid,$m_p_record)) {
							array_push($m_p_record[$item->mid],$item->identifier);

						} else {
						//if (!array_key_exists($item->mid,$m_p_record)) {
							$m_p_record[$item->mid]=array();
							array_push($m_p_record[$item->mid],$item->identifier);
						}
						*/

    					// Email Block
    				} else if ($item->mode == "disc"){
						$cartItem=$item;
						$this->processDiscount($cartItem);
						if (array_key_exists($item->mid,$m_p_record)) {
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}
	    				if (!array_key_exists($item->mid,$m_p_record)) {
	    					$m_p_record[$item->mid]=array();
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}

    				} else if ($item->mode == "owishbn"){
    					$cartItem=$item;
    					$this->processOwishBN($cartItem,$py->id,$ref_no);
    					$email = Auth::user()->email;
    					$openwish_id=$item->ow_id;
				        $data = array(
				            'openwish_id'    => $openwish_id,
				            'smedia_id'      => 1, //i am not sure whats fb
				            'smedia_account' => $email,
				            'source_ip'      => '0.0.0.0',
				            'pledged_amt'    => $item->price,
				        );
    					$this->dispatch( new OpenwishPledgeJob($data) );
    					 $pledge_ocredit=new Ocredit;
                        $sidg= new SecurityIDGenerator;
                        $security_id= $sidg->generate(Carbon::now()->toDateString());
                        $pledge_ocredit->security_id=$security_id;
                        $pledge_ocredit->value=($item->price)+($item->actual_delivery_price*100);
                        $pledge_ocredit->mode="debit";
                        $pledge_ocredit->openwish_id=$openwish_id;
                        $pledge_ocredit->save(); 
    					$item->remove();
    					
    				} else if ($item->mode=="token") {
						$checktoken = DB::table('userstoken')->
							where('user_id',$user_id)->first();

						if(is_null($checktoken)){
							DB::table('userstoken')->insert([
								'user_id'=>$user_id,
								'qty'=>($item->quantity*($item->tokenquantity/100)),
								'created_at'=> date('Y-m-d H:i:s'),
								'updated_at'=> date('Y-m-d H:i:s')]);
							
						} else {
							$nquantity = $checktoken->qty + ($item->quantity *
								($item->tokenquantity/100));
							DB::table('userstoken')->
								update([
									'qty'=>$nquantity,
									'updated_at'=> date('Y-m-d H:i:s')]);
						}

						DB::table('boughttokenlog')->insert([
							'user_id'=>$user_id,
							'quantity'=>($item->quantity * ($item->tokenquantity/100)),
							'created_at'=> date('Y-m-d H:i:s'),
							'updated_at'=> date('Y-m-d H:i:s')]);

						if (array_key_exists($item->mid,$m_p_record)) {
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}

	    				if (!array_key_exists($item->mid,$m_p_record)) {
	    					$m_p_record[$item->mid]=array();
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}

					} else {
	    				if (array_key_exists($item->mid,$m_p_record)) {
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}

	    				if (!array_key_exists($item->mid,$m_p_record)) {
	    					$m_p_record[$item->mid]=array();
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}
	    			}
    			}
    			
    			$pr_po_record=array();
				//dump($m_p_record);
    			foreach ($m_p_record as $k => $v) {
    				// Create one porder for each
    				$p= new POrder;
    				$p->user_id=$user_id;
    				$p->courier_id=0; //should be something else
    				$p->address_id=$address_id; //should be something else
    				$p->payment_id=$py->id; //0 for ocredit| No More
    				$p->order_administration_fee=$global->order_administration_fee;

    				$p->status="pending";
    				$p->osmall_comm_percent=$global->osmall_commission;
    				$p->smm_comm_percent=$global->smm_commission;
    				$p->ow_comm_percent=$global->ow_commission;
    				$p->log_comm_percent=$global->logistic_commission;
    			
    				// PorderPaymentGateway
					//dd($p);
    				
    				// ToDO add mode
    				// Mail to merchant
                    try {
                        $merchant_user_id=DB::table('merchant')->
							where('id',$k)->first()->user_id;

                        $merchant_email=User::find($merchant_user_id)->email;
                       
                    } catch (\Exception $e) {
                        $merchant_email="";
                    }

    				$p->save();
				//	dump($p);
					$pgp= new PGP;
    				$pgp->payment_gateway_id=1; //for ocredit
    				$pgp->porder_id=$p->id;
    				$pgp->save();
					$station_picked = 0;
					
					try{
					 	$sint= new StationIntelligence;
					 	if($pick_station == 0){
							$station_picked =
								$sint->get_station($address, $m_p_record[$k]);
					 	} else {
					 		$station_picked = $pick_station;
					 	}

						if($station_picked > 0){
							$so= new SOrder;
							$so->station_id=$station_picked;
							$so->porder_id=$p->id; 
							$so->save();
							$stationarea = DB::table('station')->
								where('station.id',$station_picked)->
								join('address','station.station_address_id','=',
									'address.id')->
								select('address.area_id')->first();

							if(!is_null($stationarea)){
								if(!is_null($stationarea->area_id)){
									DB::table('stationarea')->insert([
										'station_id'=>$station_picked,
										'area_id' => $stationarea->area_id,
										'created_at'=>date('Y-m-d H:i:s'),
										'updated_at'=>date('Y-m-d H:i:s')]);
								}
							}
						 }						
					 } catch (\Exception $e) {
					 	//dd($e->getMessage());
					 }

                    $newpoid = UtilityController::generaluniqueid(
						$p->id,'1','1', $p->created_at,
						'nporderid', 'nporder_id');

					DB::table('nporderid')->insert([
						'nporder_id'=>$newpoid,
						'porder_id'=>$p->id,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')]);

					$a = new SecurityIDGenerator;
					$do_password = $a->generate(date('Y-m-d'));		
					$receipt_no = 0;
					if($station_picked > 0){
						$station = DB::table('station')->
							where('id',$station_picked)->first();

						if(!is_null($station)){
							$receipt_no = $station->receipt_no;
							if(!is_null($receipt_no)){
								$receipt_no++;
							} else {
								$receipt_no = 1;
							}
							//DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
							DB::table('station')->
								where('id',$station_picked)->
								update(['receipt_no'=>$receipt_no]);
						}							
					} else {
						$merchant = DB::table('merchant')->where('id',$k)->first();
						if(!is_null($merchant)){
							$receipt_no = $merchant->receipt_no;
							if(!is_null($receipt_no)){
								$receipt_no++;
							} else {
								$receipt_no = 1;
							}
						//	DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
							DB::table('merchant')->
								where('id',$k)->
								update(['receipt_no'=>$receipt_no]);
						}
					}					
    				$rc= new Receipt;
    				$rc->porder_id=$p->id;
    				$rc->receipt_no=$receipt_no;
    				$rc->do_password=$do_password;
    				$rc->save();
					UtilityController::createQr($rc->id,'receipt',
						IdController::nO($p->id));

    				// $r=DB::table('receipt')->insert([
    				// 		'porder_id'=>$p->id
    				// 		]);
		            $do= new DeliveryOrder;
		            $do->receipt_id=$rc->id;
		            $do->status="pending";
		            $do->save();
                    $newdoid = UtilityController::generaluniqueid(
						$do->id,'3','1', $do->created_at,
						'ndeliveryorderid', 'ndeliveryorder_id');

					DB::table('ndeliveryorderid')->insert([
						'ndeliveryorder_id'=>$newdoid,
						'deliveryorder_id'=>$do->id,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')]);					

    				UtilityController::createQr($do->id,'deliveryorder',
						IdController::nO($p->id));

					// Add to porderefno
    				$r= new PRef;
    				$r->ref_no=$ref_no;
    				$r->porder_id=$p->id;
    				$r->payment_mode='ocredit';
    				$r->save();
					$merchant_user_id=DB::table('merchant')->
						where('id',$k)->first()->user_id;

                    $merchant_email=User::find($merchant_user_id)->email;

    				$porder_value=0;
					$imstation = DB::table('station')->
						where('user_id', $user_id)->
						where('status', 'active')->count();

					$imautolink = DB::table('autolink')->
						where('initiator', $user_id)->
						where('responder', $k)->
						where('status','linked')->count();

					$global=DB::table('global')->first();
					$merchant_commissions = DB::table('merchant')->
						where('id',$k)->first();

					$commission_type="std";
					$b2b_commission_type="std";
					
					if(is_null($merchant_commissions)){
						$commission_type=$global->commission_type;
						$b2b_commission_type=$global->b2b_commission_type;

					} else {
						if($merchant_commissions->commission_type != "std" &&
						   $merchant_commissions->commission_type != "var" ){
							$commission_type=$global->commission_type;
						} else {
							$commission_type=$merchant_commissions->commission_type;
						}
						
						if($merchant_commissions->b2b_commission_type != "std" &&
						   $merchant_commissions->b2b_commission_type != "var" ){
							$b2b_commission_type=$global->b2b_commission_type;
						} else {
							$b2b_commission_type=$merchant_commissions->b2b_commission_type;
						}						
					}
					$source_po = "";
					$source_po_global = "";
    				foreach ($m_p_record[$k] as $l) {
    					// $l is identifier here
    					$cartItem=Cart::item($l);
						$commission = $global->osmall_commission;
						$ptype ='b2c';
						$pavailable =0;
						$product = DB::table('product')->
							where('id',$cartItem->id)->first();

						if(!is_null($product)){
							$ptype = $product->segment;	
							$pavailable = $product->available;	
						}
						if($ptype == 'b2b'){
							if($b2b_commission_type ==  'std'){
								if(is_null($merchant_commissions)){
									$commission=$global->b2b_osmall_commission;
								} else {
									if($merchant_commissions->b2b_osmall_commission == null || $merchant_commissions->b2b_osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
										$commission=$global->b2b_osmall_commission;
									} else {
										$commission=$merchant_commissions->b2b_osmall_commission;
									}
								}
							} else {
								if(is_null($product)){
									$commission=$global->b2b_osmall_commission;
								} else {
									if($product->b2b_osmall_commission == null || $product->b2b_osmall_commission == 0 || $product->b2b_osmall_commission == ""){
										if($merchant_commissions->b2b_osmall_commission == null || $merchant_commissions->b2b_osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
											$commission=$global->b2b_osmall_commission;
										} else {
											$commission=$merchant_commissions->b2b_osmall_commission;
										}
									} else {
										$commission=$product->b2b_osmall_commission;
									}
								}								
							}
						} else {
							if($commission_type ==  'std'){
								if(is_null($merchant_commissions)){
									$commission=$global->osmall_commission;
								} else {
									if($merchant_commissions->osmall_commission == null || $merchant_commissions->osmall_commission == 0 || $merchant_commissions->osmall_commission == ""){
										$commission=$global->osmall_commission;
									} else {
										$commission=$merchant_commissions->osmall_commission;
									}
								}
							} else {
								if(is_null($product)){
									$commission=$global->osmall_commission;
								} else {
									if($product->osmall_commission == null || $product->osmall_commission == 0 || $product->osmall_commission == ""){
										if($merchant_commissions->osmall_commission == null || $merchant_commissions->osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
											$commission=$global->osmall_commission;
										} else {
											$commission=$merchant_commissions->osmall_commission;
										}
									} else {
										$commission=$product->osmall_commission;
									}
								}								
							}							
						}
						$source_now = "";
						if($ptype == 'b2c'){
							$source_now = 'b2c';
						} else if($ptype == 'b2b'){
							$source_now = 'b2b';
						} else if($ptype == 'hyper'){
							$source_now = 'hyper';
						} else {
							$source_now = 'b2c';
						}
						if($cartItem->mode == 'token'){
							$source_now = 'token';
						}
						if($source_po == ""){
							$source_po = $source_now;
							$source_po_global = $source_now;
						} else {
							if($source_po == $source_now){
								$source_po_global = $source_now;
							} else {
								$source_po_global = "mixed";
							}
						}						
    					$porder_value+=$cartItem->price;
    					$osmall_commission_per=$commission;
    					$totalPrice=$cartItem->price+$cartItem->delivery_price * 100;
    					$osmall_commission=$osmall_commission_per*100;
    					$ssfcomm=0;
    					if ($cartItem->mode=="smm") {
    						$smmin=$cartItem->smmin_id;
    						$s=SMMin::find($smmin);
    						$sout=$s->smmout_id;
    						$s->response="buy";
    						$s->porder_id=$p->id;
    						$s->quantity=$cartItem->quantity;
    						$s->save();
    				
    						$ssfcomm=SMMController::getCommission($cartItem->id);
    						$smmout=SMMout::find($sout);
    						$smm_author=$smmout->user_id;
    						$ssfc=SalesStaff::where('user_id',$smm_author)->where('type','smm')->first();
    						// check if salesStaff exists
    						if (is_null($ssfc)) {
    							# code...
							$ssf= new SalesStaff;
    						$ssf->type="smm";
    						$ssf->commission=$ssfcomm;
    						$ssf->user_id=Auth::user()->id;
    						$ssf->save();
    						}
    						else{
    						$ssf= SalesStaff::find($ssfc->id);
    					
    						$ssf->commission=$ssf->commission+$ssfcomm;
    						
    						$ssf->save();
    						/*Add Opencredit to the SMM Author */
    						$smm_ocredit=new Ocredit;
    						$sidg= new SecurityIDGenerator;
			                $security_id= $sidg->generate(Carbon::now()->toDateString());
			                $smm_ocredit->security_id=$security_id;
    						$smm_ocredit->value=$ssfcomm;
    						$smm_ocredit->mode="credit";
    						$smm_ocredit->smmout_id=$sout;
    						$smm_ocredit->save(); 
    						}
    						
    					}
    					$o= new OrderProduct;
    					$o->porder_id=$p->id;
    					$o->product_id=$cartItem->id;
    					$o->quantity=$cartItem->quantity;
    					$o->order_price=$cartItem->price;
						$o->source=$source_now;
						$o->smm_comm_amount=$ssfcomm;
						$totalOPprice=($cartItem->price*$cartItem->quantity)+($cartItem->delivery_price*100);
						$pgfee=($global->payment_gateway_commission*$totalOPprice)/100;

						// $shippingCost=$cartItem->delivery_price 
						// *
						// (1- ($global->logistic_commission/100)) ;

						$o->osmall_comm_amount=$osmall_commission;
    					//$o->paid_commission_rate=$commission;
    					$o->order_delivery_price=$cartItem->delivery_price * 100;
    					$o->payment_gateway_fee=$pgfee;
    					// $o->shipping_cost=$shippingCost;
    					$o->actual_delivery_price=$cartItem->actual_delivery_price * 100;
    					$o->save();
						DB::table('product')->where('id',$item->id)->update(['available'=> ($pavailable - $cartItem->quantity), 'private_available'=> ($pavailable - $cartItem->quantity)]);
    					if ($cartItem->mode=="smm") {
    						$smmin=$cartItem->smmin_id;
    						$s=SMMin::find($smmin);
    						$sout=$s->smmout_id;
    						$s->response="buy";
    						$s->porder_id=$p->id;
    						$s->quantity=$cartItem->quantity;
    						$s->save();
    				
    						$ssfcomm=SMMController::getCommission($cartItem->id);
    						$ssfc=SalesStaff::where('user_id',Auth::user()->id)->where('type','smm')->first();
    						// check if salesStaff exists
    						if (is_null($ssfc)) {
    							# code...
							$ssf= new SalesStaff;
    						$ssf->type="smm";
    						$ssf->commission=$ssfcomm;
    						$ssf->user_id=Auth::user()->id;
    						$ssf->save();
    						}else{
    						$ssf= SalesStaff::find($ssfc->id);
    					
    						$ssf->commission=$ssf->commission+$ssfcomm;
    						
    						$ssf->save();
    						}
    						
    					}

    					$pr=Product::find($cartItem->id);
    					$oc=new Ocredit;
    					DB::table('deliveryordersproduct')->insert([
    						'do_id'=>$do->id,
    						'product_id'=>$cartItem->id,
    						'status'=>'pending',
    						'quantity'=>$cartItem->quantity,

    						]);
    					
    				}
					//dd($source_po_global);
					
					$p->source=$source_po_global;
					$p->save();
					
					$e= new EmailController;
				//	$e->sendDO($merchant_email,$p->id);	
				//	$e->sendRC(Auth::user()->email,$p->id);
					
					
    			}
				// 
    			Cart::destroy();

    			return response()->json(['status'=>'success','short_message'=>0,'long_message'=>'Transaction Successfull','redirect'=>$redirect_to_url]);

    		}
    		try {
			if (abs($amount-$amount_to_be_paid_by_oc)<$epsilon) {
    			$new_balance=$ocredit_balance-$amount_to_be_paid_by_oc;
    			$oc= new Ocredit;
    			$oc->source="purchase";
    			$oc->value=$amount_to_be_paid_by_oc;
    			$oc->ref_no=$ref_no;
    			$oc->mode="debit";
    			$oc->security_id=$security_id;
    			$oc->save();
    			// Create record in ref_pivot

    			// Create record in Porder for each mid [merchant_id]
    			$global=DB::table('global')->first();
    			$pgc_per=$global->payment_gateway_commission;
				$pgc=($pgc_per*$amount)/100;
				$py= new Payment;
				$py->receivable=$amount; //Cents not MYR
			
				$py->payment_gateway=$pgc;
				$py->status="paid";
				$py->note="ocredit";
				$py->save();

				$pick_station = 0;
    			$m_p_record=array();
    			$is_hyper=array();
    			foreach (Cart::contents() as $item){
    				if ($item->mode=="owish") {
						$email = Auth::user()->email;
    					$openwish_id=$item->openwish_id;
				        $data = array(
				            'openwish_id'    => $openwish_id,
				            'smedia_id'      => 1, //i am not sure whats fb
				            'smedia_account' => $email,
				            'source_ip'      => '0.0.0.0',
				            'pledged_amt'    => $item->pledged_amt*100,
				        );
    					$this->dispatch( new OpenwishPledgeJob($data) );
    					$item->remove();
    					// Write Email Block
    				}
    				else if ($item->mode == "rfee"){
    					CREController::processCREOrder($item->id);
    				}
    				else if ($item->mode=="hyper" or $item->page=="owarehouse") {
    						/*Create porder for the hyper product.*/

    						/*Ends*/ 
                            $owarehouse_id= $item->hyper_id;
                            $owarehousepledge = new Owarehouse_pledge();
                            $owarehousepledge->owarehouse_id =$owarehouse_id;
                            $owarehousepledge->user_id=$user_id;
                            $owarehousepledge->status='executed';
                            $owarehousepledge->pledged_qty =$item->quantity;
                            if(!$owarehousepledge->save()){
                                $data['status'] = 'error';
                            }else{
                                $data['status'] = 'success';
                                $producthyper = DB::table('product')->where('segment','hyper')->where('parent_id',$item->parent_id)->first();
                                if(!is_null($producthyper)){
                                    $available = $producthyper->available - $item->quantity;
                                    DB::table('product')->where('segment','hyper')->where('parent_id',$item->parent_id)->update(['available'=>$available]);
                                }
                            }
                           
                            if (array_key_exists($item->mid,$m_p_record)) {
                                array_push($m_p_record[$item->mid],$item->identifier);
                            } else {
                            //if (!array_key_exists($item->mid,$m_p_record)) {
                                $m_p_record[$item->mid]=array();
                                array_push($m_p_record[$item->mid],$item->identifier);
                            }
    					// Email Block
    				}else if ($item->mode == "owishbn"){
    					$cartItem=$item;
    					$this->processOwishBN($cartItem,$py->id,$ref_no);
    					$email = Auth::user()->email;
    					$openwish_id=$item->ow_id;
				        $data = array(
				            'openwish_id'    => $openwish_id,
				            'smedia_id'      => 1, //i am not sure whats fb
				            'smedia_account' => $email,
				            'source_ip'      => '0.0.0.0',
				            'pledged_amt'    => $item->price,
				        );
    					$this->dispatch( new OpenwishPledgeJob($data) );
    					$item->remove();
    					
    				}else if ($item->mode=="token") {
						$checktoken = DB::table('userstoken')->where('user_id',$user_id)->first();
						if(is_null($checktoken)){
							DB::table('userstoken')->insert(['user_id'=>$user_id,'qty'=>($item->quantity * ($item->tokenquantity/100)),
							'created_at'=> date('Y-m-d H:i:s'), 'updated_at'=> date('Y-m-d H:i:s')]);
						} else {
							$nquantity = $checktoken->qty + ($item->quantity * ($item->tokenquantity/100));
							DB::table('userstoken')->update(['qty'=>$nquantity , 'updated_at'=> date('Y-m-d H:i:s')]);
						}
						DB::table('boughttokenlog')->insert(['user_id'=>$user_id,'quantity'=>($item->quantity * ($item->tokenquantity/100)),
						'created_at'=> date('Y-m-d H:i:s'), 'updated_at'=> date('Y-m-d H:i:s')]);
						if (array_key_exists($item->mid,$m_p_record)) {
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}
	    				if (!array_key_exists($item->mid,$m_p_record)) {
	    					$m_p_record[$item->mid]=array();
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}
					} else{
	    				if (array_key_exists($item->mid,$m_p_record)) {
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}
	    				if (!array_key_exists($item->mid,$m_p_record)) {
	    					$m_p_record[$item->mid]=array();
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}
	    				    			
    			
	    			}
    			}
    			
    			$pr_po_record=array();
    			foreach ($m_p_record as $k => $v) {
    				// Create one porder for each
    				$p= new POrder;
    				$p->user_id=$user_id;
    				$p->courier_id=0; //should be something else
    				$p->address_id=$address_id; //should be something else
    				$p->payment_id=$py->id; //0 for ocredit| No More
    				$p->order_administration_fee=$global->order_administration_fee;
    				$p->status="pending";
    				// PorderPaymentGateway
					//dd($p);
    				
    				// ToDO add mode
    				// Mail to merchant
                    try {
                        $merchant_user_id=DB::table('merchant')->where('id',$k)->first()->user_id;
                        $merchant_email=User::find($merchant_user_id)->email;
                       
                    } catch (\Exception $e) {
                   
                        $merchant_email="";
                    }
    				$p->save();
					$pgp= new PGP;
    				$pgp->payment_gateway_id=1; //for ocredit
    				$pgp->porder_id=$p->id;
    				$pgp->save();
					$station_picked = 0;
					
					 try{
					 	$sint= new StationIntelligence;
					 	if($pick_station == 0){
							$station_picked = $sint->get_station($address, $m_p_record[$k]);
					 	} else {
					 		$station_picked = $pick_station;
					 	}
						 if($station_picked > 0){
							$so= new SOrder;
							$so->station_id=$station_picked;
							$so->porder_id=$p->id; 
							$so->save();
							$stationarea = DB::table('station')->where('station.id',$station_picked)->join('address','station.station_address_id','=','address.id')->select('address.area_id')->first();
							if(!is_null($stationarea)){
								if(!is_null($stationarea->area_id)){
									DB::table('stationarea')->insert(['station_id'=>$station_picked, 'area_id' => $stationarea->area_id, 'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
								}
							}
							
						 }						
					 } catch (\Exception $e) {
					 
					 	//dd($e->getMessage());
					 }

                    $newpoid = UtilityController::generaluniqueid($p->id,'1','1', $p->created_at, 'nporderid', 'nporder_id');
					DB::table('nporderid')->insert(['nporder_id'=>$newpoid, 'porder_id'=>$p->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					$a = new SecurityIDGenerator;
					$do_password = $a->generate(date('Y-m-d'));		
					$receipt_no = 0;
					if($station_picked > 0){
						$station = DB::table('station')->where('id',$station_picked)->first();
						if(!is_null($station)){
							$receipt_no = $station->receipt_no;
							if(!is_null($receipt_no)){
								$receipt_no++;
							} else {
								$receipt_no = 1;
							}
							//DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
							DB::table('station')->where('id',$station_picked)->update(['receipt_no'=>$receipt_no]);
						}							
					} else {
						$merchant = DB::table('merchant')->where('id',$k)->first();
						if(!is_null($merchant)){
							$receipt_no = $merchant->receipt_no;
							if(!is_null($receipt_no)){
								$receipt_no++;
							} else {
								$receipt_no = 1;
							}
						//	DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
							DB::table('merchant')->where('id',$k)->update(['receipt_no'=>$receipt_no]);
						}
					}					
    				$rc= new Receipt;
    				$rc->porder_id=$p->id;
    				$rc->receipt_no=$receipt_no;
    				$rc->do_password=$do_password;
    				$rc->save();
					UtilityController::createQr($rc->id,'receipt', IdController::nO($p->id));

    				// $r=DB::table('receipt')->insert([
    				// 		'porder_id'=>$p->id
    				// 		]);
		            $do= new DeliveryOrder;
		            $do->receipt_id=$rc->id;
		            $do->status="pending";
		            $do->save();
                    $newdoid = UtilityController::generaluniqueid($do->id,'3','1', $do->created_at, 'ndeliveryorderid', 'ndeliveryorder_id');
					DB::table('ndeliveryorderid')->insert(['ndeliveryorder_id'=>$newdoid, 'deliveryorder_id'=>$do->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);					
    				UtilityController::createQr($do->id,'deliveryorder',IdController::nO($p->id));
					// Add to porderefno
    				$r= new PRef;
    				$r->ref_no=$ref_no;
    				$r->porder_id=$p->id;
    				$r->payment_mode='ocredit';
    				$r->save();
					$merchant_user_id=DB::table('merchant')->where('id',$k)->first()->user_id;
                    $merchant_email=User::find($merchant_user_id)->email;

    				$porder_value=0;
					$imstation = DB::table('station')->where('user_id', $user_id)->where('status', 'active')->count();
					$imautolink = DB::table('autolink')->where('initiator', $user_id)->where('responder', $k)->where('status','linked')->count();
					$global=DB::table('global')->first();
					$merchant_commissions = DB::table('merchant')->where('id',$k)->first();
					$commission_type="std";
					$b2b_commission_type="std";
					
					if(is_null($merchant_commissions)){
						$commission_type=$global->commission_type;
						$b2b_commission_type=$global->b2b_commission_type;
					} else {
						if($merchant_commissions->commission_type != "std" && $merchant_commissions->commission_type != "var" ){
							$commission_type=$global->commission_type;
						} else {
							$commission_type=$merchant_commissions->commission_type;
						}
						
						if($merchant_commissions->b2b_commission_type != "std" && $merchant_commissions->b2b_commission_type != "var" ){
							$b2b_commission_type=$global->b2b_commission_type;
						} else {
							$b2b_commission_type=$merchant_commissions->b2b_commission_type;
						}						
					}
					$source_po = "";
					$source_po_global = "";
    				foreach ($m_p_record[$k] as $l) {
    					// $l is identifier here
    					$cartItem=Cart::item($l);
						$commission = $global->osmall_commission;
						$ptype ='b2c';
						$pavailable = 0;
						$product = DB::table('product')->where('id',$cartItem->id)->first();
						if(!is_null($product)){
							$ptype = $product->segment;	
							$pavailable = $product->available;	
						}
						if($ptype == 'b2b'){
							if($b2b_commission_type ==  'std'){
								if(is_null($merchant_commissions)){
									$commission=$global->b2b_osmall_commission;
								} else {
									if($merchant_commissions->b2b_osmall_commission == null || $merchant_commissions->b2b_osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
										$commission=$global->b2b_osmall_commission;
									} else {
										$commission=$merchant_commissions->b2b_osmall_commission;
									}
								}
							} else {
								if(is_null($product)){
									$commission=$global->b2b_osmall_commission;
								} else {
									if($product->b2b_osmall_commission == null || $product->b2b_osmall_commission == 0 || $product->b2b_osmall_commission == ""){
										if($merchant_commissions->b2b_osmall_commission == null || $merchant_commissions->b2b_osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
											$commission=$global->b2b_osmall_commission;
										} else {
											$commission=$merchant_commissions->b2b_osmall_commission;
										}
									} else {
										$commission=$product->b2b_osmall_commission;
									}
								}								
							}
						} else {
							if($commission_type ==  'std'){
								if(is_null($merchant_commissions)){
									$commission=$global->osmall_commission;
								} else {
									if($merchant_commissions->osmall_commission == null || $merchant_commissions->osmall_commission == 0 || $merchant_commissions->osmall_commission == ""){
										$commission=$global->osmall_commission;
									} else {
										$commission=$merchant_commissions->osmall_commission;
									}
								}
							} else {
								if(is_null($product)){
									$commission=$global->osmall_commission;
								} else {
									if($product->osmall_commission == null || $product->osmall_commission == 0 || $product->osmall_commission == ""){
										if($merchant_commissions->osmall_commission == null || $merchant_commissions->osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
											$commission=$global->osmall_commission;
										} else {
											$commission=$merchant_commissions->osmall_commission;
										}
									} else {
										$commission=$product->osmall_commission;
									}
								}								
							}							
						}
						$source_now = "";
						if($ptype == 'b2c'){
							$source_now = 'b2c';
						} else if($ptype == 'b2b'){
							$source_now = 'b2b';
						} else if($ptype == 'hyper'){
							$source_now = 'hyper';
						} else {
							$source_now = 'b2c';
						}
						if($cartItem->mode == 'token'){
							$source_now = 'token';
						}
						if($source_po == ""){
							$source_po = $source_now;
							$source_po_global = $source_now;
						} else {
							if($source_po == $source_now){
								$source_po_global = $source_now;
							} else {
								$source_po_global = "mixed";
							}
						}						
    					$porder_value+=$cartItem->price;
    					$osmall_commission_per=$commission;
    					$totalPrice=$cartItem->price+$cartItem->delivery_price * 100;
    					$osmall_commission=$osmall_commission_per*100;
    					$o= new OrderProduct;
    					$o->porder_id=$p->id;
    					$o->product_id=$cartItem->id;
    					$o->quantity=$cartItem->quantity;
    					$o->order_price=$cartItem->price;
						$o->source=$source_now;
						DB::table('product')->where('id',$item->id)->update(['available'=> ($pavailable - $cartItem->quantity), 'private_available'=> ($pavailable - $cartItem->quantity)]);
						$totalOPprice=($cartItem->price*$cartItem->quantity)+($cartItem->delivery_price*100);
						$pgfee=($global->payment_gateway_commission*$totalOPprice)/100;

						$shippingCost=$cartItem->delivery_price;
						

						$o->osmall_comm_amount=$osmall_commission;
						$o->osmall_comm_amount=$global->logistic_commission;
    					//$o->paid_commission_rate=$commission;
    					$o->order_delivery_price=$cartItem->delivery_price * 100;
    					$o->payment_gateway_fee=$pgfee;
    					// $o->shipping_cost=$shippingCost;
    					
    					$o->actual_delivery_price=$cartItem->delivery_price * 100;
    					$o->save();
    					if ($cartItem->mode=="smm") {
    						$smmin=$cartItem->smmin_id;
    						$s=SMMin::find($smmin);
    						$sout=$s->smmout_id;
    						$s->response="buy";
    						$s->porder_id=$p->id;
    						$s->quantity=$cartItem->quantity;
    						$s->save();
    				
    						$ssfcomm=SMMController::getCommission($cartItem->id);
    						$ssfc=SalesStaff::where('user_id',Auth::user()->id)->where('type','smm')->first();
    						// check if salesStaff exists
    						if (is_null($ssfc)) {
    							# code...
							$ssf= new SalesStaff;
    						$ssf->type="smm";
    						$ssf->commission=$ssfcomm;
    						$ssf->user_id=Auth::user()->id;
    						$ssf->save();
    						}else{
    						$ssf= SalesStaff::find($ssfc->id);
    					
    						$ssf->commission=$ssf->commission+$ssfcomm;
    						
    						$ssf->save();
    						}
    						
    					}

    					$pr=Product::find($cartItem->id);
    					$oc=new Ocredit;
    					DB::table('deliveryordersproduct')->insert([
    						'do_id'=>$do->id,
    						'product_id'=>$cartItem->id,
    						'status'=>'pending',
    						'quantity'=>$cartItem->quantity,

    						]);
    					
    				}
					//dd($source_po_global);
					
					$p->source=$source_po_global;
					$p->save();
					
					$e= new EmailController;
				//	$e->sendDO($merchant_email,$p->id);	
				//	$e->sendRC(Auth::user()->email,$p->id);
					
					
    			}
				// 
    			Cart::destroy();

    			return response()->json(['status'=>'success','short_message'=>0,'long_message'=>'Transaction Successfull','redirect'=>$redirect_to_url]);

    		}

    		} catch (\Exception $e) {
    			
    		}

    	
    		if (abs($amount-$amount_to_be_paid_by_oc)>$epsilon or $ocredit_part==0) {
    			$new_balance=$ocredit_balance-$amount_to_be_paid_by_oc;
    			try {
    				// DB::table('ocredit_acct')->where('user_id',$user_id)->update(['balance'=>$new_balance]);
    				$oc= new Ocredit;
	    			$oc->source="purchase";
	    			$oc->value=$amount_to_be_paid_by_oc;
	    			$oc->ref_no=$ref_no;
	    			$oc->mode="credit";
	    			$oc->security_id=$security_id; 
	    			$oc->save();
    			} catch (\Exception $e) {
    				return $e;
    			}
    			
    			$amount_due=$amount-$amount_to_be_paid_by_oc;
    			foreach (Cart::contents() as $k) {
    				/*
						zxcv
    				*/
    				$identifier=$k->identifier.(string)time();
    				$k->unique_identifier=$identifier;
    				$c= new Ctrans;
    				$c->ref_no=$ref_no;
    				$c->cart_id=$identifier;
    				$c->address_id=$address_id;
    				$c->save();
    				DB::table('stuff')->insert(['note'=>"identifier2|".$c->identifier]);
    			}
    			$ff=$this->save_cart_in_db();
    			// Cart::destroy();
    			DB::table('stuff')->insert(['note'=>$ff]);
				
				/* Mixed payment OC+FPX */
    			$fpx=new FPX;
    			$fpx_bank=$fpx->get_banks();

				/* Difference between hardcoded array and function:
				   Never use the same name for a variable and a function */
    			$fpx_bank_kv=$fpx->bank_kv(); 

    			Session::put('amount_due',$amount_due);	
    			$amount_due=number_format($amount_due/100,2);
    			return response()->json(['status'=>'success','short_message'=>1,'long_message'=>'Partial Transaction Successfull',
    				'fpx_bank'=>$fpx_bank,
    				'fpx_bank_kv'=>$fpx_bank_kv,
    				'amount_due'=>$amount_due,'redirect'=>$redirect_to_url]);
    		}

    	}
    

    }
	# code...
    public function generate_order_hyper($cart_identifier,$global,$payment,$opencredit,$user_id,$amount,$ref_no)
    {
    	// zxcvv
    	$ret="err";
    	try {
    		$p= new POrder;
			$p->user_id=$user_id;
			$p->courier_id=0; //should be something else
			$p->address_id=0; //should be something else
			$p->payment_id=$payment->id; //0 for ocredit| No More
			$p->order_administration_fee=$global->order_administration_fee;
			$p->status="hyper";
			$p->save();
			$newpoid = UtilityController::generaluniqueid(
						$p->id,'1','1', $p->created_at,
						'nporderid', 'nporder_id');

			DB::table('nporderid')->insert([
				'nporder_id'=>$newpoid,
				'porder_id'=>$p->id,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')]);
		

			// Create record in Porder for each mid [merchant_id]
			$global=DB::table('global')->first();
			$pgc_per=$global->payment_gateway_commission;
			$pgc=($pgc_per*$amount)/100;


			$r= new PRef;
			$r->ref_no=$ref_no;
			$r->porder_id=$p->id;
			$r->payment_mode='ocredit';
			$r->save();
			$cartItem=Cart::item($cart_identifier);
			$o= new OrderProduct;
			$o->porder_id=$p->id;
			$o->product_id=$cartItem->id;
			$o->quantity=$cartItem->quantity;
			$o->order_price=$cartItem->price;
			$totalOPprice=($cartItem->price*$cartItem->quantity)+($cartItem->delivery_price*100);
						$pgfee=($global->payment_gateway_commission*$totalOPprice)/100;

			$osmall_commission_per=UtilityController::getCommission($cartItem->id);
			$totalPrice=$cartItem->price+$cartItem->delivery_price * 100;
			$osmall_commission=$osmall_commission_per*100;
			$o->osmall_comm_amount=$osmall_commission;
			$o->order_delivery_price=$cartItem->delivery_price * 100;
			$o->payment_gateway_fee=$pgfee;
			$o->actual_delivery_price=$cartItem->actual_delivery_price * 100;
			$o->source="hyper";
			$o->save();
			$ret=$p->id;
    	} catch (\Exception $e) {
    		dump($e);
    		
    		try {
    			POrder::destroy($p->id);
    			Orderproduct::destroy($o->id);
    		} catch (\Exception $e) {
    			
    		}
    		
    	}
    	return $ret;
    }
    public function generate_order()
    {
    	try {
    			$m_p_record=array();
    			foreach (Cart::contents() as $item){
    				if (array_key_exists($item->mid,$m_p_record)) {
    					array_push($m_p_record[$item->mid],$item->identifier);
    				}
    				if (!array_key_exists($item->mid,$m_p_record)) {
    					$m_p_record[$item]=array();
    					array_push($m_p_record[$item->mid],$item->identifier);
    				}
    			}

    			$pr_po_record=array();
    			foreach ($m_p_record as $k => $v) {
    				// Create one porder for each
    				$p= new POrder;
    				$p->user_id=$user_id;
    				$courier_id=0; //should be something else
    				$address_id=0; //should be something else
    				$payment_id=0; //0 for ocredit
    				// ToDO add mode
    				$p->save();
    				// Add to porderefno
    				$r= new PRef;
    				$r->ref_no=$ref_no;
    				$r->porder_id=$p->id;
    				$r->payment_mode='ocredit';
    				$r->save();
    				// Add Each Porder to 
    				foreach ($m_p_record[$k] as $l) {
    					// $l is identifier here
    					$cartItem=Cart::item($l);
    					$o= new OrderProduct;
    					$o->porder_id=$p->id;
    					$o->product_id=$cartItem->id;
    					$o->order_price=$cartItem->quantity;
    					$o->order_delivery_price=$cartItem->delivery_price * 100;
    					$o->save();
    				}
    			}
    			return True;
    	} catch (\Exception $e) {
    		
    		return False;
    	}
    }
	
	public function processDiscount($cartItem)
    {
		$product_id = $cartItem->id;
		$price = $cartItem->price;
		$product = DB::table('product')->where('id',$product_id)->first();
		$perc = round(($price * 100)/$product->retail_price);
		$perc = 100 - $perc;
		$disct = DB::table('discount')->where('product_id',$product_id)->where('discount_percentage',$perc)->where('status','active')->first();
		
		if(!is_null($disct)){
			DB::table('discountbuyer')->where('buyer_id',Auth::user()->id)->where('discount_id',$disct->id)->update(['executed_date'=>date('Y-m-d H:i:s'),'status'=>'executed']);
		}
		return True;
	}
	
    public function processOwishBN($cartItem,$payment_id,$ref_no)
    {
    	$ow_id= $cartItem->ow_id;
    	$content=array();
    	array_push($content,$cartItem->identifier);
		$ow=OpenWish::find($ow_id);
		$user_id=$ow->user_id;
		$user=User::find($user_id);
		$p= new POrder;
		$p->user_id=$user_id;
		$p->courier_id=0; //should be something else
		$p->address_id=$user->default_address_id; //should be something else
		$p->payment_id=$payment_id; //0 for ocredit| No More
		$p->status="pending";
		$p->source="ow";
		$ow->status='executed';
		$ow->save();
		$p->save();
		$station_picked = 0;
		$sintContent=array();
		// Merchant_id
		$k=DB::table('merchantproduct')->where('product_id',$ow->product_id)->pluck('merchant_id');
		try{
			$sint= new StationIntelligence;
			if($pick_station == 0){
			$station_picked = $sint->get_station($address, $content);
			} else {
				$station_picked = $pick_station;
			}
							 if($station_picked > 0){
								$so= new SOrder;
								$so->station_id=$station_picked;
								$so->porder_id=$p->id; 
								$so->save();
								$stationarea = DB::table('station')->where('station.id',$station_picked)->join('address','station.station_address_id','=','address.id')->select('address.area_id')->first();
								if(!is_null($stationarea)){
									if(!is_null($stationarea->area_id)){
										DB::table('stationarea')->insert(['station_id'=>$station_picked, 'area_id' => $stationarea->area_id, 'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
									}
								}
								
							 }						
						 } catch (\Exception $e) {
						 	//dd($e->getMessage());
						 }
						// Create Orderproduct
						 $newpoid = UtilityController::generaluniqueid($p->id,'1','1', $p->created_at, 'nporderid', 'nporder_id');
						DB::table('nporderid')->insert(['nporder_id'=>$newpoid, 'porder_id'=>$p->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						$a = new SecurityIDGenerator;
						$do_password = $a->generate(date('Y-m-d'));		
						$receipt_no = 0;
						if($station_picked > 0){
							$station = DB::table('station')->where('id',$station_picked)->first();
							if(!is_null($station)){
								$receipt_no = $station->receipt_no;
								if(!is_null($receipt_no)){
									$receipt_no++;
								} else {
									$receipt_no = 1;
								}
								//DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
								DB::table('station')->where('id',$station_picked)->update(['receipt_no'=>$receipt_no]);
							}							
						} else {
							$merchant = DB::table('merchant')->where('id',$k)->first();
							if(!is_null($merchant)){
								$receipt_no = $merchant->receipt_no;
								if(!is_null($receipt_no)){
									$receipt_no++;
								} else {
									$receipt_no = 1;
								}
							//	DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
								DB::table('merchant')->where('id',$k)->update(['receipt_no'=>$receipt_no]);
							}
						}						
	    				$rc= new Receipt;
	    				$rc->porder_id=$p->id;
	    				$rc->receipt_no=$receipt_no;
	    				$rc->do_password=$do_password;
	    				$rc->save();
						UtilityController::createQr($rc->id,'receipt',IdController::nO($p->id));
	    				// $r=DB::table('receipt')->insert([
	    				// 		'porder_id'=>$p->id
	    				// 		]);
			            $do= new DeliveryOrder;
			            $do->receipt_id=$rc->id;
			            $do->status="pending";
			            $do->save();
						//UtilityController::createQr($do->id,'deliveryorder',$do->id);
	                    $newdoid = UtilityController::generaluniqueid($do->id,'3','1', $do->created_at, 'ndeliveryorderid', 'ndeliveryorder_id');
						DB::table('ndeliveryorderid')->insert(['ndeliveryorder_id'=>$newdoid, 'deliveryorder_id'=>$do->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);					
	    				UtilityController::createQr($do->id,'deliveryorder', IdController::nO($p->id));
						// Add to porderefno
	    				$r= new PRef;
	    				$r->ref_no=$ref_no;
	    				$r->porder_id=$p->id;
	    				$r->payment_mode='ocredit';
	    				$r->save();
	    				$commission = 10;
						$ptype ='b2c';
						$product = DB::table('product')->where('id',$cartItem->id)->first();
						if(!is_null($product)){
							$ptype = $product->segment;	
						}
						// New Block
						$porder_value=0;
					$imstation = DB::table('station')->where('user_id', $user_id)->where('status', 'active')->count();
					$imautolink = DB::table('autolink')->where('initiator', $user_id)->where('responder', $k)->where('status','linked')->count();
					$global=DB::table('global')->first();
					$merchant_commissions = DB::table('merchant')->where('id',$k)->first();
					$commission_type="std";
					$b2b_commission_type="std";
					
						if($ptype == 'b2b'){
							if($b2b_commission_type ==  'std'){
								if(is_null($merchant_commissions)){
									$commission=$global->b2b_osmall_commission;
								} else {
									if($merchant_commissions->b2b_osmall_commission == null || $merchant_commissions->b2b_osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
										$commission=$global->b2b_osmall_commission;
									} else {
										$commission=$merchant_commissions->b2b_osmall_commission;
									}
								}
							} else {
								if(is_null($product)){
									$commission=$global->b2b_osmall_commission;
								} else {
									if($product->b2b_osmall_commission == null || $product->b2b_osmall_commission == 0 || $product->b2b_osmall_commission == ""){
										if($merchant_commissions->b2b_osmall_commission == null || $merchant_commissions->b2b_osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
											$commission=$global->b2b_osmall_commission;
										} else {
											$commission=$merchant_commissions->b2b_osmall_commission;
										}
									} else {
										$commission=$product->b2b_osmall_commission;
									}
								}								
							}
						} else {
							if($commission_type ==  'std'){
								if(is_null($merchant_commissions)){
									$commission=$global->osmall_commission;
								} else {
									if($merchant_commissions->osmall_commission == null || $merchant_commissions->osmall_commission == 0 || $merchant_commissions->osmall_commission == ""){
										$commission=$global->osmall_commission;
									} else {
										$commission=$merchant_commissions->osmall_commission;
									}
								}
							} else {
								if(is_null($product)){
									$commission=$global->osmall_commission;
								} else {
									if($product->osmall_commission == null || $product->osmall_commission == 0 || $product->osmall_commission == ""){
										if($merchant_commissions->osmall_commission == null || $merchant_commissions->osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
											$commission=$global->osmall_commission;
										} else {
											$commission=$merchant_commissions->osmall_commission;
										}
									} else {
										$commission=$product->osmall_commission;
									}
								}								
							}							
						}
    					
    					$o= new OrderProduct;
    					$o->porder_id=$p->id;
    					$o->product_id=$cartItem->id;
    					$o->quantity=$cartItem->quantity;
    					$o->order_price=$cartItem->price;
    					$o->source="ow";
    					//$o->paid_commission_rate=$commission;
    					$o->order_delivery_price=$cartItem->delivery_price * 100;
    					$o->save();
						//DB::table('product')->where('id',$ow->product_id)->update(['available'=> ($pavailable - $cartItem->quantity)]);
    					$pr=Product::find($cartItem->id);
    					$oc=new Ocredit;
    					DB::table('deliveryordersproduct')->insert([
    						'do_id'=>$do->id,
    						'product_id'=>$cartItem->id,
    						'status'=>'pending',
    						'quantity'=>$cartItem->quantity,

    						]);
    }

   public function save_cart_in_db()
   {
   		$ret="C0";
   		try {
			foreach (Cart::contents() as $k) {
	   			$dbc=new DBCart;
				$dbc->identifier=$k->unique_identifier;
				$dbc->product_id=$k->id;
				$dbc->parent_id=$k->parent_id;
				$dbc->product_name=$k->name;
				$dbc->merchant_id=$k->mid;
				$dbc->delivery_price=$k->delivery_price;
				$dbc->actual_delivery_price=$k->actual_delivery_price;
				$dbc->price=$k->price;
				$dbc->quantity=$k->quantity;
				$dbc->image=$k->image;
				$dbc->gst=$k->gst;
				$dbc->page=$k->page;
				if (is_null($k->mode)) {
					# code...
					$dbc->mode="product";
				}else{
					$dbc->mode=$k->mode;
				}
				$dbc->company_name=$k->company;
				$dbc->oshop_name=$k->oshop;
				$dbc->status="active";
				$dbc->save();

	   		}
   		$ret="C1";
   		} catch (\Exception $e) {
   			$ret=$e->getMessage();
   		}
   		return $ret;

   }
}


