<?php

namespace App\Http\Controllers;

use Request;
use DB;
use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DeliveryOrder;
use App\Models\Receipt;
use App\Models\OrderProduct;
use App\Models\DeliveryOrderProduct;
use App\Models\POrder;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\EMail;
use App\Models\User;
use App\Models\Product;
use Response;
use Hash;
use App\Models\Currency;
use App\Exceptions\CustomException;
use App\Http\Controllers\UtilityController;
use Exception;
use Auth;
use PDF;
use QrCode;
use Carbon;
use App\Models\Stockreportproduct;
use App\Models\Stockreport;

class DOController extends Controller {

    //---__construct Method---//
    public function __construct() {
        $this->middleware('auth', ['only', 'getDashboard']);
    }

    public function print_do($type,$porder_id){
		 try {
            $fname=IdController::nO($porder_id);
            if ($type=="receipt") {
                $this->printRC($porder_id);
            } elseif ($type=="invoice") {
                $this->printIV($porder_id);
            } elseif ($type=="do") {
                $this->printDO($porder_id);
            } elseif ($type=="di") {
                $this->printDI($porder_id);
            } elseif ($type=="podi") {
                $this->printPODI($porder_id);
            } elseif ($type=="posm") {
                $array = $this->printPOSM($porder_id);
				return view('do.core.salesmemo_gst', $array);
            }
        } catch (\Exception $e) {
		//	dd($e);
            return view("common.generic")
            ->with('message_type','error')
            ->with('message',"Please try again later");
        }		
	}
    public function downloadPDF($type,$porder_id)
    {
        try {
            // generate
            /* Paul */
//            ini_set('max_execution_time', 1800);
            $fname=IdController::nO($porder_id);
            if ($type=="receipt") {
                $pr="receipt-do/receiptp-";
                $this->pdfRC($porder_id);
            }
			elseif ($type=="invoice") {
                $pr="receipt-do/invoicep-";
                $this->pdfIV($porder_id);
            }
            elseif ($type=="do") {
                $pr="receipt-do/dop-";
                $this->pdfDO($porder_id);
            }
			elseif ($type=="di") {
                $this->pdfDI($porder_id);
                $pr="receipt-do/dip-";
            }
			elseif ($type=="podi") {
                $this->pdfPODI($porder_id);
                $pr="receipt-do/dip-";
            }elseif ($type=="posm") {
                $this->pdfPOSM($porder_id);
                $pr="receipt-do/sm-";
				$fname=IdController::nSM($porder_id);
            }
		//	dd("TESTEANDO");
            $file_path=$pr.$fname.".pdf";

            $headers = array(
              'Content-Type: application/pdf',
            );
            return response()->download(storage_path($file_path),$fname,$headers)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
         //   return $e;
            return view("common.generic")
            ->with('message_type','error')
            ->with('message',"Please try again later");
        }
    }
    public static function rcQR($receipt_id)
    {
        $filepath="images/qr/".$receipt_id.".png";
        try {
            $filepath=public_path($filepath);
           $rc=DB::table('receipt')->where('id',$receipt_id)->first();
            $qrInfo=$rc->do_password.";".$rc->porder_id;
            QrCode::format('png')->
                    encoding('UTF-8')->
                    size(400)->
                    generate($qrInfo,$filepath);
        } catch (\Exception $e) {
    
        }
        return $filepath;
        
    }

    public function salesmemostatus($status,$salesmemo_id) {
		DB::table('salesmemo')->where('id',$salesmemo_id)->update(['status'=>$status]);
		return "OK";
	}
    public function salesmemo($salesmemo_id) {
        $nsalesmemo_id =  IdController::nSM($salesmemo_id);
        
        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        // Validation
        if (!Auth::check()) {
            # code...
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'You need to login to view this resource.');
        }
        $user_id = Auth::user()->id;
        $isadmin = DB::table('role_users')->where('role_id', '1')->where('user_id', $user_id)->count();
		$salesmemo= DB::table('salesmemo')->where('id',$salesmemo_id)->first();
		$pid=DB::table('salesmemoproduct')->where('salesmemo_id',$salesmemo_id)->pluck('product_id');
		$pid=DB::table('product')->where('id',$pid)->pluck('id');
		$merchant_id=DB::table('merchantproduct')->where('product_id',$pid)->whereNull('deleted_at')->pluck('merchant_id');
		// 
		$merchant = DB::table('merchant')->where('id',$merchant_id)->first();
		$merchantaux = DB::table('merchant')->where('id',$merchant_id)->first();
        if ($isadmin == 0) {
			if ($salesmemo->creator_user_id != $user_id) {
				
				// $merchant = Merchant::where('user_id', $user_id)->first();
				if (is_null($merchant)) {
					# code...
					return view('common.generic')
									->with('message_type', 'error')
									->with('message', 'You do not have access to view this Sales Memo. Please contact OpenSupport');
				}
				$merchant_id = $merchant->id;
				$salesmemo= DB::table('salesmemo')->where('id',$salesmemo_id)->first();
				if (is_null($salesmemo)) {
					return view('common.generic')
									->with('message_type', 'error')
									->with('message', 'Invalid Sales Memo ID. Please contact OpenSupport');
				}

				$hasAccess = "yes";
				$orderproduct =DB::table('salesmemoproduct')->where('salesmemo_id',$salesmemo_id)->get();
				foreach ($orderproduct as $o) {
					$myp = DB::table('product')->where('id', $o->product_id)->first();
					$mp = DB::table('merchantproduct')->where('product_id', $myp->id)->first();
					if ($mp->merchant_id != $merchant_id) {
						$hasAccess = "no";
						return view('common.generic')
										->with('message_type', 'error')
										->with('message', 'You do not have access to view this Sales Memo. Please contact OpenSupport');
					}
				}
			} else {
				$hasAccess = "yes";
			}
        } else {
            $hasAccess = "yes";
        }		
		
        $buyer= User::leftJoin('address as add','add.id','=','users.default_address_id')
                ->leftJoin('city','add.city_id','=','city.id')
                ->leftJoin('state','state.code','=','city.state_code')
                ->where('users.id',$salesmemo->creator_user_id)
                ->groupBy('users.id')
                ->select(DB::raw("
                    users.name,
                    add.line1,
                    add.line2,
                    add.line3,
                    users.mobile_no,
                    users.id,
                    state.name as state,
                    city.name as city,
                    add.postcode
                    "))

                ->first();
		//dd('buyer');
        $gst = array();
        try {

			$address_line = " AND users.default_address_id = address.id ";
			$role_line = "";
			$station = DB::table('station')->where('user_id',$salesmemo->creator_user_id)->first();
			if(!is_null($station)){
				$address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
				$role_line = ", station";
			}
			$merchant = DB::table('merchant')->where('user_id',$salesmemo->creator_user_id)->first();
			if(!is_null($merchant)){
				$address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
				$role_line = ", merchant as merchant2";
			}

           $salesmemo2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name
			,address.line1 AS user_address,address.line2 AS line2,address.line3 AS line3,address.line4 AS line4
			, merchant.id AS merchant_id, merchant.company_name AS merchant_name, salesmemo.fairlocation_id
			,salesmemo.id as salesmemoid,salesmemo.status as salesmemostatus,salesmemo.salesmemo_no as merchantrecno, merchant.business_reg_no as mbiz
			,merchant.oshop_name AS oshop_name, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name
			, merchant.salesmemo_no AS salesmemo_no
			,maddress.line1 AS muser_address,maddress.line2 AS mline2,maddress.line3 AS mline3,maddress.line4 AS mline4, maddress.id as oshop_address_id,salesmemo.created_at as orderdate
				FROM users, address, address as a2, salesmemo,
				salesmemoproduct ' . $role_line . ', merchantproduct, product, merchant
				LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
				WHERE salesmemo.creator_user_id = users.id
				AND salesmemoproduct.salesmemo_id = salesmemo.id
				AND merchantproduct.product_id = salesmemoproduct.product_id
				AND merchantproduct.product_id = product.id
				AND merchant.id = merchantproduct.merchant_id
				AND merchant.address_id = a2.id
				AND salesmemo.id = :salesmemo_id'), array('salesmemo_id' => $salesmemo_id));
            $array_delivery = json_decode(json_encode($salesmemo2), True);
			
           // dd($array_delivery);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {
            dd ($e);
            // return $deliveryorder = null;
            // $products = null;
            // return view('do.deliveryorder', compact('deliveryorder', 'products'), ['currency' => $currency, 'array_delivery' => null, 'deliveryorderid' => $porder_id]);
        }		
		
        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;

        // if ($array_delivery[0]['merchant_gst']!="") {
        //     # code...
        //         dd($array_delivery[0]['merchant_gst']);
        // }
        
        if (isset($array_delivery)) {
			$fairlocation = DB::table('fairlocation')
				->leftJoin('address','address.id','=','fairlocation.address_id')
				->leftJoin('city','address.city_id','=','city.id')
				->where('fairlocation.id',$array_delivery[0]['fairlocation_id'])->first();
				//dd($fairlocation);
            if (is_null($array_delivery[0]['merchant_gst']) or $array_delivery[0]['merchant_gst'] == "") {
                //return view('do.deliveryorder_gst', compact('deliveryorder', 'products', 'gst'), ['ndelivery_id' => $ndelivery_id,'currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'deliveryorderid' => $porder_id,'buyer'=>$buyer]);
                return view('do.salesmemo_gst_rec', compact('role_line', 'gst','fairlocation'), ['ndelivery_id' => $nsalesmemo_id, 'salesmemo' => $salesmemo, 'currency' => $currency, 'array_delivery' => $array_delivery, 'deliveryorderid' => $salesmemo_id,'buyer'=>$buyer]);
            } else {
                return view('do.salesmemo_gst_rec', compact('role_line', 'gst','fairlocation'), ['ndelivery_id' => $nsalesmemo_id, 'salesmemo' => $salesmemo,'currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'deliveryorderid' => $salesmemo_id,'buyer'=>$buyer]);
            }
        } else {
            $message = "DB:Error! purchase " . $salesmemo_id . " not found. Please contact OpenSupport";
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', $message);
            return redirect()->route('home');
        }		
	}
	
    public function purchaseorder($porder_id) {
//        ini_set('max_execution_time', 1800);
        /*
          The input $porder_id is actually porder.id
         */
        $ndelivery_id =  IdController::nO($porder_id);

        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        // Validation
        if (!Auth::check()) {
            # code...
            return view('common.generic')->
				with('message_type', 'error')->
				with('message', 'You need to login to view this resource.');
        }
        $user_id = Auth::user()->id;
        $isadmin = DB::table('role_users')->where('role_id', '1')->where('user_id', $user_id)->count();
		$porder= POrder::find($porder_id);
		$pid=DB::table('ordertproduct')->where('porder_id',$porder_id)->pluck('tproduct_id');
		$pid=DB::table('tproduct')->where('id',$pid)->pluck('id');
		$merchant_id=DB::table('merchanttproduct')->where('tproduct_id',$pid)->whereNull('deleted_at')->pluck('merchant_id');
		// 
		$merchant = DB::table('merchant')->where('id',$merchant_id)->first();
		$merchantaux = DB::table('merchant')->where('id',$merchant_id)->first();
        if ($isadmin == 0) {
			if ($porder->user_id != $user_id) {
				
				// $merchant = Merchant::where('user_id', $user_id)->first();
				if (is_null($merchant)) {
					# code...
					return view('common.generic')
						->with('message_type', 'error')
						->with('message', 'You do not have access to view this deliveryorder. Please contact OpenSupport');
				}
				$merchant_id = $merchant->id;
				$porder = POrder::find($porder_id);
				if (is_null($porder)) {
					return view('common.generic')->
					with('message_type', 'error')->
					with('message', 'Invalid DeliveryOrder ID. Please contact OpenSupport');
				}

				$hasAccess = "yes";
				$orderproduct = DB::table('ordertproduct')->where('porder_id', $porder_id)->get();
				foreach ($orderproduct as $o) {
					$myp = DB::table('tproduct')->where('id', $o->tproduct_id)->first();
					$mp = DB::table('merchanttproduct')->where('tproduct_id', $myp->id)->first();
					if ($mp->merchant_id != $merchant_id) {
						$hasAccess = "no";
						return view('common.generic')->
							with('message_type', 'error')->
							with('message', 'You do not have access to view this deliveryorder. Please contact OpenSupport');
					}
				}
			} else {
				$hasAccess = "yes";
			}
        } else {
            $hasAccess = "yes";
        }

        $buyer= User::leftJoin('address as add','add.id','=','users.default_address_id')
                ->leftJoin('city','add.city_id','=','city.id')
                ->leftJoin('state','state.code','=','city.state_code')
                ->where('users.id',$porder->user_id)
                ->groupBy('users.id')
                ->select(DB::raw("
                    users.name,
                    add.line1,
                    add.line2,
                    add.line3,
                    users.mobile_no,
                    state.name as state,
                    city.name as city,
                    add.postcode
                    "))
                ->first();
		//dd('buyer');
        $gst = array();
        try {
			$address_line = " AND users.default_address_id = address.id ";
			$role_line = "";
			$station = DB::table('station')->where('user_id',$porder->user_id)->first();
			if(!is_null($station)){
				$address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
				$role_line = ", station";
			}
			$merchant = DB::table('merchant')->where('user_id',$porder->user_id)->first();
			if(!is_null($merchant)){
				$address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
				$role_line = ", merchant as merchant2";
			}
    //         $realdeliveryorderid = DB::select(DB::raw('SELECT deli.id
				// FROM deliveryinvoice deli, invoice inv
				// WHERE deli.invoice_id = inv.id and inv.porder_id =' . $porder_id
    //         ));
			$stationterm = DB::table('stationterm')->where('station_id',$station->id)->where('creditor_user_id',$merchantaux->user_id)->first();
            $invoice_id=DB::table('invoice')->where('porder_id',$porder_id)->pluck('id');
            // $deliveryinvoice_id=DB::table('deliveryinvoice')->where('invoice_id',$invoice_id)->pluck('id');
           
           $deliveryinvoice_id=DB::select(DB::raw(
                "SELECT MAX(id) as id from deliveryinvoice where invoice_id=$invoice_id"

            ))[0]->id;
           
            $deliveryorder = DB::table('deliveryinvoice')->where('id', $deliveryinvoice_id)->first();

            $deliveryorder2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name
			, deliveryinvoicetproduct.status as status,address.line1 AS user_address,address.line2 AS line2,address.line3 AS line3,address.line4 AS line4
			, merchant.id AS merchant_id, merchant.company_name AS merchant_name,deliveryinvoice.id as original_id,invoice.invoice_no as merchantrecno, merchant.business_reg_no as mbiz
			,merchant.oshop_name AS oshop_name, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name
			, merchant.invoice_no AS invoice_no, invoice.duration, invoice.do_password as password
			,maddress.line1 AS muser_address,maddress.line2 AS mline2,maddress.line3 AS mline3,maddress.line4 AS mline4, maddress.id as oshop_address_id,invoice.created_at as orderdate
				FROM users, address, address as a2, porder, invoice, deliveryinvoice
				, ordertproduct ' . $role_line . ', merchanttproduct, tproduct, deliveryinvoicetproduct, merchant
				LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
				WHERE porder.user_id = users.id
				
				AND invoice.porder_id = porder.id
				AND deliveryinvoice.invoice_id = invoice.id
				AND ordertproduct.porder_id = porder.id
				AND deliveryinvoicetproduct.tproduct_id = ordertproduct.tproduct_id
				AND deliveryinvoicetproduct.di_id = deliveryinvoice.id
				AND ordertproduct.tproduct_id = tproduct.id
				AND merchanttproduct.tproduct_id = tproduct.id
				AND merchant.id = merchanttproduct.merchant_id
				AND merchant.address_id = a2.id
				AND deliveryinvoice.id = :deliveryorderid'), array('deliveryorderid' => $deliveryinvoice_id));
            // dump($realdeliveryorderid[0]);
            $array_delivery = json_decode(json_encode($deliveryorder2), True);
            // dd($array_delivery);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {
            dd ($e);
            // return $deliveryorder = null;
            // $products = null;
            // return view('do.deliveryorder', compact('deliveryorder', 'products'), ['currency' => $currency, 'array_delivery' => null, 'deliveryorderid' => $porder_id]);
        }

        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;

        // if ($array_delivery[0]['merchant_gst']!="") {
        //     # code...
        //         dd($array_delivery[0]['merchant_gst']);
        // }
        
        if (isset($array_delivery)) {
            if (is_null($array_delivery[0]['merchant_gst']) or $array_delivery[0]['merchant_gst'] == "") {
                //return view('do.deliveryorder_gst', compact('deliveryorder', 'products', 'gst'), ['ndelivery_id' => $ndelivery_id,'currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'deliveryorderid' => $porder_id,'buyer'=>$buyer]);
                return view('do.purchaseinvoice', compact('deliveryorder', 'products'), ['ndelivery_id' => $ndelivery_id, 'stationterm' => $stationterm, 'currency' => $currency, 'array_delivery' => $array_delivery, 'deliveryorderid' => $porder_id,'buyer'=>$buyer]);
            } else {
                return view('do.purchaseinvoice_gst', compact('deliveryorder', 'products', 'gst'), ['ndelivery_id' => $ndelivery_id, 'stationterm' => $stationterm,'currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'deliveryorderid' => $porder_id,'buyer'=>$buyer]);
            }
        } else {
            $message = "DB:Error! purchase " . $porder_id . " not found. Please contact OpenSupport";
            return view('common.generic')
                ->with('message_type', 'error')
                ->with('message', $message);

            return redirect()->route('home');
        }       
    }

    public function deliveryinvoice($porder_id) {
		Log::debug('***** deliveryinvoice('.$porder_id.') *****');
        $user_id=Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
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
        $porder_data = DB::table('porder')->
        select('id','user_id','is_emerchant','salesorder_no','status')->
        where('id',$porder_id)->first();
        $this->DirectInvoice = new GatorInvoiceController();
        $InvoicedisplayData = $this->DirectInvoice->displayInvoice($porder_id);


        return view('do.deliveryDirectinvoice')->
			with([
			'InvoiceDisplayData' => $InvoicedisplayData,
			'OrderId' => $porder_id,
            'products_gator'=> $products_gator,
            'wholesaleprices' => $wholesaleprices,
            'porder_data' => $porder_data,
            'user_id' => $user_id
        ]);
    }

//     public function deliveryinvoice($porder_id) {
// //        ini_set('max_execution_time', 1800);
//         /*
//           The input $porder_id is actually porder.id
//          */
//         $ndelivery_id =  IdController::nO($porder_id);

//         $currency = '';
//         if (!is_null(Currency::where('active', true)->first())) {
//             $currency = Currency::where('active', true)->first()->code;
//         }
//         // Validation
//         if (!Auth::check()) {
//             # code...
//             return view('common.generic')
//                             ->with('message_type', 'error')
//                             ->with('message', 'You need to login to view this resource.');
//         }
//         $user_id = Auth::user()->id;

//         $isadmin = DB::table('role_users')->where('role_id', '1')->where('user_id', $user_id)->count();

//         // $pid=DB::table('ordertproduct')->where('porder_id',$porder_id)->pluck('tproduct_id');
//         // $pid=DB::table('orderproduct')->where('porder_id',$porder_id)->pluck('product_id');
//         $pid=DB::table('orderproduct')->where('porder_id',$porder_id)->pluck('product_id');
                   
//         // $pid=DB::table('tproduct')->where('id',$pid)->pluck('id');
//         //$pid=DB::table('product')->where('id',$pid)->pluck('id');
//         $pid=DB::table('product')->where('id',$pid)->pluck('parent_id');
        
//         $merchant_id=DB::table('merchantproduct')->where('product_id',$pid)->whereNull('deleted_at')->pluck('merchant_id');
//        // $merchant_id=DB::table('merchanttproduct')->where('tproduct_id',$pid)->whereNull('deleted_at')->pluck('merchant_id');
        
//         $merchant = DB::table('merchant')->where('id',$merchant_id)->first();
//         $merchantaux = DB::table('merchant')->where('id',$merchant_id)->first();

//         if ($isadmin == 0) {
//            // echo '<pre>'; print_r($merchant_id); die();
//             // $merchant = Merchant::where('user_id', $user_id)->first();
//             if (is_null($merchant)) {
//                 # code...
//                 return view('common.generic')
//                                 ->with('message_type', 'error')
//                                 ->with('message', 'You do not have access to view this deliveryorder. Please contact OpenSupport');
//             }
//             $merchant_id = $merchant->id;
//             $porder = POrder::find($porder_id);

//             if (is_null($porder)) {
//                 return view('common.generic')
//                                 ->with('message_type', 'error')
//                                 ->with('message', 'Invalid DeliveryOrder ID. Please contact OpenSupport');
//             }

//             $hasAccess = "yes";
//             // $orderproduct = DB::table('ordertproduct')->where('porder_id', $porder_id)->get();
//             $orderproduct = DB::table('orderproduct')->where('porder_id', $porder_id)->get();
            
//             foreach ($orderproduct as $o) {
//                 // $myp = DB::table('tproduct')->where('id', $o->tproduct_id)->first();
//                 $myp = DB::table('product')->where('id', $o->product_id)->first();
                
//                 // $mp = DB::table('merchanttproduct')->where('tproduct_id', $myp->id)->first();
//                   $mp = DB::table('merchantproduct')->where('product_id', $myp->parent_id)->first();
               
                    
//                 if ($mp->merchant_id != $merchant_id) {
//                     $hasAccess = "no";
//                     return view('common.generic')
//                                     ->with('message_type', 'error')
//                                     ->with('message', 'You do not have access to view this deliveryorder. Please contact OpenSupport');
//                 }
//             }
//         } else {
//             $hasAccess = "yes";
//         }

//         $porder= POrder::find($porder_id);

//         $buyer= User::leftJoin('address as add','add.id','=','users.default_address_id')
//                 ->leftJoin('city','add.city_id','=','city.id')
//                 ->leftJoin('state','state.code','=','city.state_code')
//                 ->where('users.id',$porder->user_id)
//                 ->groupBy('users.id')
//                 ->select(DB::raw("
//                     users.name,
//                     add.line1,
//                     add.line2,
//                     add.line3,
//                     users.mobile_no,
//                     state.name as state,
//                     city.name as city,
//                     add.postcode
//                     "))

//                 ->first();
//         //dd('buyer');
//         $gst = array();
//         try {
            
//             $address_line = " AND users.default_address_id = address.id ";
//             $role_line = "";
//             $station = DB::table('station')->where('user_id',$porder->user_id)->first();
//             if(!is_null($station)){
//                 $address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
//                 $role_line = ", station";
//             }
//             $merchant = DB::table('merchant')->where('user_id',$porder->user_id)->first();
//             if(!is_null($merchant)){
//                 $address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
//                 $role_line = ", merchant as merchant2";
//             }
//     //         $realdeliveryorderid = DB::select(DB::raw('SELECT deli.id
//                 // FROM deliveryinvoice deli, invoice inv
//                 // WHERE deli.invoice_id = inv.id and inv.porder_id =' . $porder_id
//     //         ));

//             $invoice_id=DB::table('invoice')->where('porder_id',$porder_id)->pluck('id');
//             // $deliveryinvoice_id=DB::table('deliveryinvoice')->where('invoice_id',$invoice_id)->pluck('id');
//            $stationterm = DB::table('stationterm')->where('station_id',$station->id)->where('creditor_user_id',$merchantaux->user_id)->first();
//            //dd($merchant->user_id);
//            $deliveryinvoice_id=DB::select(DB::raw(
//                 "SELECT MAX(id) as id from deliveryinvoice where invoice_id=$invoice_id"

//             ))[0]->id;
//            // echo '<pre>'; print_r($deliveryinvoice_id); die();
//             $deliveryorder = DB::table('deliveryinvoice')->where('id', $deliveryinvoice_id)->first();

//            // echo "<pre>"; print_r($stationterm); die();
//    //          $deliveryorder2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name
// 			// , deliveryinvoicetproduct.status as status,address.line1 AS user_address,address.line2 AS line2,address.line3 AS line3,address.line4 AS line4
// 			// , merchant.id AS merchant_id, merchant.company_name AS merchant_name,deliveryinvoice.id as original_id,invoice.invoice_no as merchantrecno, invoice.duration, merchant.business_reg_no as mbiz
// 			// ,merchant.oshop_name AS oshop_name, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name
// 			// , merchant.invoice_no AS invoice_no, invoice.do_password as password
// 			// ,maddress.line1 AS muser_address,maddress.line2 AS mline2,maddress.line3 AS mline3,maddress.line4 AS mline4, maddress.id as oshop_address_id,invoice.created_at as orderdate
// 			// 	FROM users, address, address as a2, porder, invoice, deliveryinvoice
// 			// 	, ordertproduct ' . $role_line . ', merchanttproduct, tproduct, deliveryinvoicetproduct, merchant
// 			// 	LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
// 			// 	WHERE porder.user_id = users.id
				
// 			// 	AND invoice.porder_id = porder.id
// 			// 	AND deliveryinvoice.invoice_id = invoice.id
// 			// 	AND ordertproduct.porder_id = porder.id
// 			// 	AND deliveryinvoicetproduct.tproduct_id = ordertproduct.tproduct_id
// 			// 	AND deliveryinvoicetproduct.di_id = deliveryinvoice.id
// 			// 	AND ordertproduct.tproduct_id = tproduct.id
// 			// 	AND merchanttproduct.tproduct_id = tproduct.id
// 			// 	AND merchant.id = merchanttproduct.merchant_id
// 			// 	AND merchant.address_id = a2.id
// 			// 	AND deliveryinvoice.id = :deliveryorderid'), array('deliveryorderid' => $deliveryinvoice_id));

//            $deliveryorder2 = DB::select(DB::raw('
//             SELECT DISTINCT(users.id) AS user_id, 
//                     CONCAT(users.first_name,  \' \', users.last_name) AS user_name,
//                     --  deliveryinvoicetproduct.status as status,
//                      address.line1 AS user_address,
//                      address.line2 AS line2,
//                      address.line3 AS line3,
//                      address.line4 AS line4, 
//                      merchant.id AS merchant_id, 
//                      merchant.company_name AS merchant_name,
//                      -- deliveryinvoice.id as original_id,
//                      invoice.id as original_id,
//                      invoice.invoice_no as merchantrecno, 
//                      invoice.duration, 
//                      merchant.business_reg_no as mbiz,
//                      merchant.oshop_name AS oshop_name, 
//                      a2.line1 AS merchant_address, 
//                      merchant.gst AS merchant_gst, 
//                      merchant.oshop_name AS oshop_name, 
//                      merchant.invoice_no AS invoice_no, 
//                     invoice.do_password as password,
//                     maddress.line1 AS muser_address,
//                     maddress.line2 AS mline2,
//                     maddress.line3 AS mline3,
//                     maddress.line4 AS mline4, 
//                     maddress.id as oshop_address_id,
//                     invoice.created_at as orderdate
//                 FROM porder

//                 left join orderproduct on orderproduct.porder_id = porder.id
//                 left join invoice on invoice.porder_id = porder.id
//                 left join product on orderproduct.product_id = product.id
//                 -- left join deliveryinvoice deliveryinvoice.invoice_id = invoice.id
//                 -- left join deliveryinvoicetproduct.product_id = orderproduct.product_id
//                 -- left join deliveryinvoicetproduct.di_id = deliveryinvoice.id
//                 left join merchantproduct on merchantproduct.product_id = product.id
//                 left join merchant on merchant.id = merchantproduct.merchant_id
//                 left join users on porder.user_id = users.id
//                 left join address on address.id=users.default_address_id
//                 LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
//                 left join address as a2 on merchant.address_id = a2.id
//                 -- WHERE porder.user_id = users.id
//                 WHERE invoice.id = :receipt_id'), array('receipt_id' => $invoice_id));
//             // dump($realdeliveryorderid[0]);   

//            // echo '<pre>'; print_r($deliveryorder2); die();
//             $array_delivery = json_decode(json_encode($deliveryorder2), True);
//             // dd($array_delivery);
//             $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
//         } catch (\Exception $e) {
//          //   dd ($e);
//             // return $deliveryorder = null;
//             // $products = null;
//             // return view('do.deliveryorder', compact('deliveryorder', 'products'), ['currency' => $currency, 'array_delivery' => null, 'deliveryorderid' => $porder_id]);
//         }


//         $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;

//         // if ($array_delivery[0]['merchant_gst']!="") {
//         //     # code...
//         //         dd($array_delivery[0]['merchant_gst']);
//         // }
        
//         if (isset($array_delivery)) {
//             if (is_null(true)) {
//                 //return view('do.deliveryorder_gst', compact('deliveryorder', 'products', 'gst'), ['ndelivery_id' => $ndelivery_id,'currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'deliveryorderid' => $porder_id,'buyer'=>$buyer]);
                
//                 return view('do.deliveryinvoice', compact('deliveryorder', 'products'), ['stationterm' => $stationterm, 'ndelivery_id' => $ndelivery_id, 'currency' => $currency, 'array_delivery' => $array_delivery, 'deliveryorderid' => $porder_id,'buyer'=>$buyer]);
//             } else {

//                 return view('do.deliveryinvoice_gst', compact('deliveryorder', 'products', 'gst'), ['stationterm' => $stationterm, 'ndelivery_id' => $ndelivery_id,'currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'deliveryorderid' => $porder_id,'buyer'=>$buyer]);
//             }
//         } else {
//             $message = "DB:Error! deliveryorder " . $porder_id . " not found. Please contact OpenSupport";
//             return view('common.generic')
//                             ->with('message_type', 'error')
//                             ->with('message', $message);
//             return redirect()->route('home');
//         }		
// 	}
	
    public function deliveryorder($porder_id) {
		Log::debug('***** deliveryorder('.$porder_id.') *****');

//        ini_set('max_execution_time', 1800);
        /*
          The input $porder_id is actually porder.id
         */
        $ndelivery_id =  IdController::nO($porder_id);

        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        // Validation
        if (!Auth::check()) {

            # code...
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'You need to login to view this resource.');
        }

        $user_id = Auth::user()->id;
        $isadmin = DB::table('role_users')->where('role_id', '1')->where('user_id', $user_id)->count();
        if ($isadmin == 0) {
            $pid=DB::table('orderproduct')->where('porder_id',$porder_id)->pluck('product_id');
            $pid=DB::table('product')->where('id',$pid)->pluck('parent_id');
            $merchant_id=DB::table('merchantproduct')->where('product_id',$pid)
            ->whereNull('deleted_at')->pluck('merchant_id');
            // 
            $merchant = DB::table('merchant')->where('id',$merchant_id)->first();
            // $merchant = Merchant::where('user_id', $user_id)->first();
            if (is_null($merchant)) {
                # code...

                return view('common.generic')
                                ->with('message_type', 'error')
                                ->with('message', 'You do not have access to view this deliveryorder. Please contact OpenSupport');
            }
            $merchant_id = $merchant->id;
            $porder = POrder::find($porder_id);
            if (is_null($porder)) {

                return view('common.generic')
                                ->with('message_type', 'error')
                                ->with('message', 'Invalid DeliveryOrder ID. Please contact OpenSupport');
            }

            $hasAccess = "yes";
            $orderproduct = OrderProduct::where('porder_id', $porder_id)->get();
            foreach ($orderproduct as $o) {
                $myp = DB::table('product')->where('id', $o->product_id)->first();
                $mp = MerchantProduct::where('product_id', $myp->parent_id)->first();
                if ($mp->merchant_id != $merchant_id) {
                    $hasAccess = "no";
                    return view('common.generic')
                                    ->with('message_type', 'error')
                                    ->with('message', 'You do not have access to view this deliveryorder. Please contact OpenSupport');
                }
            }
        } else {
            $hasAccess = "yes";
        }


        $porder= POrder::find($porder_id);
        $buyer= User::join('address as add','add.id','=','users.default_address_id')
                ->join('city','add.city_id','=','city.id')
                ->join('state','state.code','=','city.state_code')
                ->where('users.id',$porder->user_id)
                ->groupBy('users.id')
                ->select(DB::raw("
                    users.name,
                    add.line1,
                    add.line2,
                    add.line3,
                    users.mobile_no,
                    state.name as state,
                    city.name as city,
                    add.postcode
                    "))

                ->first();
        $gst = array();
        $array_delivery=array();
        try {

			$address_line = " AND users.default_address_id = address.id ";
			$role_line = "";
			$station = DB::table('station')->where('user_id',$porder->user_id)->first();
			if(!is_null($station)){
				$address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
				$role_line = ", station";
			}
			$merchant = DB::table('merchant')->where('user_id',$porder->user_id)->first();
			if(!is_null($merchant)){
				$address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
				$role_line = ", merchant as merchant2";
			}
            $realdeliveryorderid = DB::select(DB::raw('SELECT deli.id
				FROM deliveryorder deli, receipt rec
				WHERE deli.receipt_id = rec.id and rec.porder_id =' . $porder_id
            ));

            $deliveryorder = DeliveryOrder::where('id', $realdeliveryorderid[0]->id)->first();

            $deliveryorder2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name, deliveryordersproduct.status as status,address.line1 AS user_address,address.line2 AS line2,address.line3 AS line3,address.line4 AS line4, merchant.id AS merchant_id, merchant.company_name AS merchant_name,receipt.receipt_no as merchantrecno, merchant.business_reg_no as mbiz,merchant.oshop_name AS oshop_name, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name, merchant.invoice_no AS invoice_no, receipt.do_password as password
			,maddress.line1 AS muser_address,maddress.line2 AS mline2,deliveryorder.id as original_id,maddress.line3 AS mline3,maddress.line4 AS mline4, maddress.id as oshop_address_id,receipt.created_at as orderdate
				FROM users, address, address as a2, porder, receipt, deliveryorder, orderproduct ' . $role_line . ', merchantproduct, product, deliveryordersproduct, merchant
				LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
				WHERE porder.user_id = users.id
				
				AND receipt.porder_id = porder.id
				AND deliveryorder.receipt_id = receipt.id
				AND orderproduct.porder_id = porder.id
				AND deliveryordersproduct.product_id = orderproduct.product_id
				AND deliveryordersproduct.do_id = deliveryorder.id
				AND orderproduct.product_id = product.id
				AND merchantproduct.product_id = product.parent_id
                AND merchantproduct.deleted_at IS NULL
				AND merchant.id = merchantproduct.merchant_id
				AND merchant.address_id = a2.id
				AND deliveryorder.id = :deliveryorderid'), array('deliveryorderid' => $realdeliveryorderid[0]->id));
            //dd($deliveryorder2);
            $array_delivery = json_decode(json_encode($deliveryorder2), True);
            // dd($array_delivery);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {
        	Log::info("Error in ".$e->getFile(). "at line ".$e->geLine()." Error  ".$e->getMessage());
            // return $e;
            // return $deliveryorder = null;
            // $products = null;
            // return view('do.deliveryorder', compact('deliveryorder', 'products'), ['currency' => $currency, 'array_delivery' => null, 'deliveryorderid' => $porder_id]);
        }


        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;

        // if ($array_delivery[0]['merchant_gst']!="") {
        //     # code...
        //         dd($array_delivery[0]['merchant_gst']);
        // }
        
        if (isset($array_delivery)) {
            if (is_null($array_delivery[0]['merchant_gst']) or $array_delivery[0]['merchant_gst'] == "") {
                //return view('do.deliveryorder_gst', compact('deliveryorder', 'products', 'gst'), ['ndelivery_id' => $ndelivery_id,'currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'deliveryorderid' => $porder_id,'buyer'=>$buyer]);
                return view('do.deliveryorder', compact('deliveryorder', 'products'), ['ndelivery_id' => $ndelivery_id, 'currency' => $currency, 'array_delivery' => $array_delivery, 'deliveryorderid' => $porder_id,'buyer'=>$buyer]);
            } else {
                return view('do.deliveryorder_gst', compact('deliveryorder', 'products', 'gst'), ['ndelivery_id' => $ndelivery_id,'currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'deliveryorderid' => $porder_id,'buyer'=>$buyer]);
            }
        } else {
            $message = "DB:Error! deliveryorder " . $porder_id . " not found. Please contact OpenSupport";
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', $message);
            return redirect()->route('home');
        }
    }



    public function deliveryinvoiceprocess() {
        $code = 0;
        $items = Request::input('items');
        $porder_id = Request::input('porder_id');
        $password = Request::input('password');
    
        //check for the password
        // return $password;
        try {

            $deliveryorder = DB::table('deliveryinvoice')->join('invoice','deliveryinvoice.invoice_id','=','invoice.id')->where('invoice.porder_id', $porder_id)
        
            ->select('deliveryinvoice.*')->first();
			
            $invoice = DB::table('invoice')->where('id', $deliveryorder->invoice_id)->first();
        } catch (\Exception $e) {

            return Response::json(8);
        }

        if ($password === $invoice->do_password) {
			$porder = DB::table("porder")->where('id',$porder_id)->first();
            $flag = 1;
			$user_id = Auth::user()->id;
			$merchant_id = 0;
			$merchant = DB::table('merchant')->where('user_id', $user_id)->first();
			if(!is_null($merchant)){
				$merchant_id = $merchant->id;
			}
			$user_id = $porder->user_id;
			$imstation = DB::table('station')->where('user_id', $user_id)->where('status', 'active')->count();
			$imautolink = DB::table('autolink')->where('initiator', $user_id)->where('responder', $merchant_id)->where('status','linked')->count();
			$tproducts = DB::table('ordertproduct')->where('porder_id',$porder_id)->get();
			foreach ($tproducts as $product) {
				
                if ($items == null) {
                    $flag = 2;
                    break;
                }
				$prime_product = DB::table('tproduct')->
					where('id',$product->tproduct_id)->first();
	

				//$parent_product = DB::table('product')->
				//	where('id',$prime_product->parent_id)->first();				
			

                if (in_array($prime_product->id, $items)) {
                    DB::table('deliveryinvoicetproduct')->where('tproduct_id', $prime_product->id)->where('di_id', $deliveryorder->id)->update(['status' => 'b-collected']);
					DB::table('ordertproduct')->where('tproduct_id', $prime_product->id)->where('porder_id', $porder_id)->update(['status' => 'b-collected']);
                    /* $product->status="b-collected";
                      $product->save(); */
					  
						if($imstation > 0 && $imautolink > 0 && $prime_product->segment == 'b2b'){
							$op = DB::table('ordertproduct')->where('porder_id',$porder_id)->where('tproduct_id',$prime_product->id)->first();
							$station = DB::table('station')->where('user_id', $user_id)->where('status', 'active')->first();
							$stationsproduct = DB::table('stationsproduct')->where('station_id', $station->id)->join('sproduct', 'stationsproduct.sproduct_id','=','sproduct.id')->where('sproduct.product_id',$prime_product->product_id)->count();
							if($stationsproduct > 0){
								$stationsproduct = DB::table('stationsproduct')->where('station_id', $station->id)->join('sproduct', 'stationsproduct.sproduct_id','=','sproduct.id')->where('sproduct.product_id',$prime_product->product_id)->select('sproduct.*')->first();
								//dd($stationsproduct);
								DB::table('sproduct')->where('id',$stationsproduct->id)->update(['available'=>($op->quantity + $stationsproduct->available),'stock'=>($op->quantity + $stationsproduct->stock),'status'=>'active','updated_at'=>date('Y-m-d H:i:s')]);
							} else {
								$sp_id = DB::table('sproduct')->insertGetId(['available'=>$op->quantity,'status'=>'active', 'stock'=>$op->quantity, 'shipping_cost'=>$op->order_delivery_price * 100, 'product_id'=>$prime_product->product_id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
								$sps_id = DB::table('stationsproduct')->insert(['station_id'=>$station->id, 'sproduct_id'=>$sp_id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
							}	
						}					  
                } else {
                    $flag = 2;
                }
            }
            $cond=DB::table('ordertproduct')->where('porder_id',$porder_id)
            ->where('status','l-collected')->first();
            if (is_null($cond)) {
                $flag=1;
            }
            if ($flag == 1) {
                $deliveryorder['status'] = 'b-collected';
				$postatus = 'b-collected';
            } else {
                $deliveryorder['status'] = 'partial';
				$postatus = 'partial';
            }
            $deliveryorder->save();
			DB::table('porder')->where('id',$porder_id)->update(['status'=>$postatus,'receipt_tstamp'=>Carbon::now()]);
            $code = 1;
        } else {
            $code = -1; //password not correct
        }
        return Response::json($code);
    }	
	
    public function deliveryorderprocess() {
        $code = 0;
        $items = Request::input('items');
        $porder_id = Request::input('porder_id');
        $password = Request::input('password');
    
        //check for the password
        // return $password;
        try {

            $deliveryorder = DeliveryOrder::join('receipt','deliveryorder.receipt_id','=','receipt.id')->where('receipt.porder_id', $porder_id)
        
            ->select('deliveryorder.*')->first();
			
            $receipt = Receipt::where('id', $deliveryorder->receipt_id)->first();
        } catch (\Exception $e) {

            return Response::json(8);
        }

        if ($password === $receipt->do_password) {
			$porder = DB::table("porder")->where('id',$porder_id)->first();
            $flag = 1;
			$user_id = Auth::user()->id;
			$merchant_id = 0;
			$merchant = DB::table('merchant')->where('user_id', $user_id)->first();
			if(!is_null($merchant)){
				$merchant_id = $merchant->id;
			}
			$user_id = $porder->user_id;
			$imstation = DB::table('station')->where('user_id', $user_id)->where('status', 'active')->count();
			$imautolink = DB::table('autolink')->where('initiator', $user_id)->where('responder', $merchant_id)->where('status','linked')->count();
            foreach ($deliveryorder->products as $product) {
				
                if ($items == null) {
                    $flag = 2;
                    break;
                }
				$prime_product = DB::table('product')->
					where('id',$product->product_id)->first();
	

				$parent_product = DB::table('product')->
					where('id',$prime_product->parent_id)->first();				
			

                if (in_array($prime_product->id, $items)) {
                    DB::table('deliveryordersproduct')->where('product_id', $prime_product->id)->where('do_id', $deliveryorder->id)->update(['status' => 'b-collected']);
					DB::table('orderproduct')->where('product_id', $prime_product->id)->where('porder_id', $porder_id)->update(['status' => 'b-collected']);
                    /* $product->status="b-collected";
                      $product->save(); */
					  
						if($imstation > 0 && $imautolink > 0 && $prime_product->segment == 'b2b'){
							$op = DB::table('orderproduct')->where('porder_id',$porder_id)->where('product_id',$prime_product->id)->first();
							$station = DB::table('station')->where('user_id', $user_id)->where('status', 'active')->first();
							$stationsproduct = DB::table('stationsproduct')->where('station_id', $station->id)->join('sproduct', 'stationsproduct.sproduct_id','=','sproduct.id')->where('sproduct.product_id',$prime_product->parent_id)->count();
							if($stationsproduct > 0){
								$stationsproduct = DB::table('stationsproduct')->where('station_id', $station->id)->join('sproduct', 'stationsproduct.sproduct_id','=','sproduct.id')->where('sproduct.product_id',$prime_product->parent_id)->select('sproduct.*')->first();
								//dd($stationsproduct);
								DB::table('sproduct')->where('id',$stationsproduct->id)->update(['available'=>($op->quantity + $stationsproduct->available),'stock'=>($op->quantity + $stationsproduct->stock),'status'=>'active','updated_at'=>date('Y-m-d H:i:s')]);
							} else {
								$sp_id = DB::table('sproduct')->insertGetId(['available'=>$op->quantity,'status'=>'active', 'stock'=>$op->quantity, 'shipping_cost'=>$op->order_delivery_price * 100, 'product_id'=>$prime_product->parent_id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
								$sps_id = DB::table('stationsproduct')->insert(['station_id'=>$station->id, 'sproduct_id'=>$sp_id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
							}	
						}					  
                } else {
                    $flag = 2;
                }
            }
            $cond=DB::table('orderproduct')->where('porder_id',$porder_id)
            ->where('status','l-collected')->first();
            if (is_null($cond)) {
                $flag=1;
            }
            if ($flag == 1) {
                $deliveryorder['status'] = 'b-collected';
				$postatus = 'b-collected';
            } else {
                $deliveryorder['status'] = 'partial';
				$postatus = 'partial';
            }
            $deliveryorder->save();
			DB::table('porder')->where('id',$porder_id)->update(['status'=>$postatus,'receipt_tstamp'=>Carbon::now()]);
            $code = 1;
        } else {
            $code = -1; //password not correct
        }
        return Response::json($code);
    }

    public function stationdashboard() {
        return view('stationdashboard');
    }
    public static function pdfDO($porder_id)
    {
        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        $porder= POrder::find($porder_id);
        $buyer= User::join('address as add','add.id','=','users.default_address_id')
                ->join('city','add.city_id','=','city.id')
                ->join('state','state.code','=','city.state_code')
                ->where('users.id',$porder->user_id)
                ->groupBy('users.id')
                ->select(DB::raw("
                    users.name,
                    add.line1,
                    add.line2,
                    add.line3,
                    users.mobile_no,
                    state.name as state,
                    city.name as city,
                    add.postcode
                    "))

                ->first();
        $gst = array();
        try {

            $address_line = " AND users.default_address_id = address.id ";
            $role_line = "";
            $station = DB::table('station')->where('user_id',$porder->user_id)->first();
            if(!is_null($station)){
                $address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
                $role_line = ", station";
            }
            $merchant = DB::table('merchant')->where('user_id',$porder->user_id)->first();
            if(!is_null($merchant)){
                $address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
                $role_line = ", merchant as merchant2";
            }
            $realdeliveryorderid = DB::select(DB::raw('SELECT deli.id
                FROM deliveryorder deli, receipt rec
                WHERE deli.receipt_id = rec.id and rec.porder_id =' . $porder_id
            ));

            $deliveryorder = DeliveryOrder::where('id', $realdeliveryorderid[0]->id)->first();

            $deliveryorder2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name, deliveryordersproduct.status as status,address.line1 AS user_address,address.line2 AS line2,address.line3 AS line3,address.line4 AS line4, merchant.id AS merchant_id, merchant.company_name AS merchant_name,
                receipt.receipt_no as merchantrecno,
                merchant.business_reg_no as mbiz
                ,merchant.oshop_name AS oshop_name, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name, merchant.invoice_no AS invoice_no, receipt.do_password as password
            ,maddress.line1 AS muser_address,maddress.line2 AS mline2,deliveryorder.id as original_id,maddress.line3 AS mline3,maddress.line4 AS mline4, maddress.id as oshop_address_id,receipt.created_at as orderdate
                FROM users, address, address as a2, porder, receipt, deliveryorder, orderproduct ' . $role_line . ', merchantproduct, product, deliveryordersproduct, merchant
                LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
                WHERE porder.user_id = users.id
                
                AND receipt.porder_id = porder.id
                AND deliveryorder.receipt_id = receipt.id
                AND orderproduct.porder_id = porder.id
                AND deliveryordersproduct.product_id = orderproduct.product_id
                AND deliveryordersproduct.do_id = deliveryorder.id
                AND orderproduct.product_id = product.id
                AND merchantproduct.product_id = product.parent_id
                AND merchantproduct.deleted_at IS NULL
                AND merchant.id = merchantproduct.merchant_id
                AND merchant.address_id = a2.id
                AND deliveryorder.id = :deliveryorderid'), array('deliveryorderid' => $realdeliveryorderid[0]->id));
            //dd($deliveryorder2);
            $array_delivery = json_decode(json_encode($deliveryorder2), True);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {
            // return $e;
            // return $deliveryorder = null;
            // $products = null;
            // return view('do.deliveryorder', compact('deliveryorder', 'products'), ['currency' => $currency, 'array_delivery' => null, 'deliveryorderid' => $porder_id]);
        }

        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;
        $do_file_name="receipt-do/dop-".IdController::nO($porder_id).".pdf";
        // if ($array_delivery[0]['merchant_gst']!="") {
        //     # code...
        //         dd($array_delivery[0]['merchant_gst']);
        // }
        $orderproduct=DB::table('orderproduct')->where('porder_id',$porder_id)->whereNull('deleted_at')->get();
       
            if (is_null($array_delivery[0]['merchant_gst']) or $array_delivery[0]['merchant_gst'] == "") {

               $pdf=PDF::loadView('do.core.do',['currency' => $currency, 'array_delivery' => $array_delivery, 'deliveryorderid' => $porder_id,'deliveryorder'=>$deliveryorder,'buyer'=>$buyer,'orderproduct'=>$orderproduct])->save(storage_path($do_file_name));
            } else {
                $pdf=PDF::loadView('do.core.dogst',['currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'deliveryorderid' => $porder_id,'deliveryorder'=>$deliveryorder,'gst'=>$gst,
                    'buyer'=>$buyer,'orderproduct'=>$orderproduct
                    ])->save(storage_path($do_file_name));
            }
        
    }

    public static function pdfDI($porder_id)
    {
//        ini_set('max_execution_time', 1800);
        /*
          The input $porder_id is actually porder.id
         */
        $ndelivery_id =  IdController::nO($porder_id);

        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        // Validation
        if (!Auth::check()) {
            # code...
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'You need to login to view this resource.');
        }
        $user_id = Auth::user()->id;
        $isadmin = DB::table('role_users')->where('role_id', '1')->where('user_id', $user_id)->count();
        if ($isadmin == 0) {
            $pid=DB::table('ordertproduct')->where('porder_id',$porder_id)->pluck('tproduct_id');
            $pid=DB::table('tproduct')->where('id',$pid)->pluck('id');
            $merchant_id=DB::table('merchanttproduct')->where('tproduct_id',$pid)->whereNull('deleted_at')->pluck('merchant_id');
            // 
            $merchant = DB::table('merchant')->where('id',$merchant_id)->first();
            // $merchant = Merchant::where('user_id', $user_id)->first();
            if (is_null($merchant)) {
                # code...
                return view('common.generic')
                                ->with('message_type', 'error')
                                ->with('message', 'You do not have access to view this deliveryorder. Please contact OpenSupport');
            }
            $merchant_id = $merchant->id;
            $porder = POrder::find($porder_id);
            if (is_null($porder)) {
                return view('common.generic')
                                ->with('message_type', 'error')
                                ->with('message', 'Invalid DeliveryOrder ID. Please contact OpenSupport');
            }

            $hasAccess = "yes";
            $orderproduct = DB::table('ordertproduct')->where('porder_id', $porder_id)->get();
            foreach ($orderproduct as $o) {
                $myp = DB::table('tproduct')->where('id', $o->tproduct_id)->first();
                $mp = DB::table('merchanttproduct')->where('tproduct_id', $myp->id)->first();
                if ($mp->merchant_id != $merchant_id) {
                    $hasAccess = "no";
                    return view('common.generic')
                                    ->with('message_type', 'error')
                                    ->with('message', 'You do not have access to view this deliveryorder. Please contact OpenSupport');
                }
            }
        } else {
            $hasAccess = "yes";
        }


        $porder= POrder::find($porder_id);
        $buyer= User::leftJoin('address as add','add.id','=','users.default_address_id')
                ->leftJoin('city','add.city_id','=','city.id')
                ->leftJoin('state','state.code','=','city.state_code')
                ->where('users.id',$porder->user_id)
                ->groupBy('users.id')
                ->select(DB::raw("
                    users.name,
                    add.line1,
                    add.line2,
                    add.line3,
                    users.mobile_no,
                    state.name as state,
                    city.name as city,
                    add.postcode
                    "))

                ->first();
		//dd('buyer');
        $gst = array();
        try {

			$address_line = " AND users.default_address_id = address.id ";
			$role_line = "";
			$station = DB::table('station')->where('user_id',$porder->user_id)->first();
			if(!is_null($station)){
				$address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
				$role_line = ", station";
			}
			$merchant = DB::table('merchant')->where('user_id',$porder->user_id)->first();
			if(!is_null($merchant)){
				$address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
				$role_line = ", merchant as merchant2";
			}
            $realdeliveryorderid = DB::select(DB::raw('SELECT MAX(deli.id) as id
				FROM deliveryinvoice deli, invoice inv
				WHERE deli.invoice_id = inv.id and inv.porder_id =' . $porder_id
            ));

            $deliveryorder = DB::table('deliveryinvoice')->where('id', $realdeliveryorderid[0]->id)->first();

            $deliveryorder2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name
			, deliveryinvoicetproduct.status as status,address.line1 AS user_address,address.line2 AS line2,address.line3 AS line3,address.line4 AS line4
			, merchant.id AS merchant_id, merchant.company_name AS merchant_name,invoice.id as original_id,invoice.invoice_no as merchantrecno, invoice.duration, merchant.business_reg_no as mbiz
			,merchant.oshop_name AS oshop_name, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name
			, merchant.invoice_no AS invoice_no, invoice.do_password as password
			,maddress.line1 AS muser_address,maddress.line2 AS mline2,deliveryinvoice.id as original_id,maddress.line3 AS mline3,maddress.line4 AS mline4, maddress.id as oshop_address_id,invoice.created_at as orderdate
				FROM users, address, address as a2, porder, invoice, deliveryinvoice
				, ordertproduct ' . $role_line . ', merchanttproduct, tproduct, deliveryinvoicetproduct, merchant
				LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
				WHERE porder.user_id = users.id
				
				AND invoice.porder_id = porder.id
				AND deliveryinvoice.invoice_id = invoice.id
				AND ordertproduct.porder_id = porder.id
				AND deliveryinvoicetproduct.tproduct_id = ordertproduct.tproduct_id
				AND deliveryinvoicetproduct.di_id = deliveryinvoice.id
				AND ordertproduct.tproduct_id = tproduct.id
				AND merchanttproduct.tproduct_id = tproduct.id
				AND merchant.id = merchanttproduct.merchant_id
				AND merchant.address_id = a2.id
				AND deliveryinvoice.id = :deliveryorderid'), array('deliveryorderid' => $realdeliveryorderid[0]->id));
            //dd($deliveryorder2);
            $array_delivery = json_decode(json_encode($deliveryorder2), True);
            // dd($array_delivery);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {
            dd ($e);
            // return $deliveryorder = null;
            // $products = null;
            // return view('do.deliveryorder', compact('deliveryorder', 'products'), ['currency' => $currency, 'array_delivery' => null, 'deliveryorderid' => $porder_id]);
        }


        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;
        $do_file_name="receipt-do/dip-".IdController::nO($porder_id).".pdf";

        // if ($array_delivery[0]['merchant_gst']!="") {
        //     # code...
        //         dd($array_delivery[0]['merchant_gst']);
        // }
   
       
            if (!is_null($array_delivery[0]['merchant_gst']) and $array_delivery[0]['merchant_gst'] == "") {
               $pdf=PDF::loadView('do.core.di',['currency' => $currency, 'array_delivery' => $array_delivery, 'deliveryorderid' => $porder_id,'deliveryorder'=>$deliveryorder,'buyer'=>$buyer])->save(storage_path($do_file_name));
            } else if(!is_null($array_delivery[0]) and $array_delivery[0]['merchant_gst']!="") {
                $pdf=PDF::loadView('do.core.digst',['currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'deliveryorderid' => $porder_id,'deliveryorder'=>$deliveryorder,'gst'=>$gst,
                    'buyer'=>$buyer
                    ])->save(storage_path($do_file_name));
            }
            else{
                return "File not available";
                // zxcv
            }
        
    }	
	
    public function printPOSM($salesmemo_id) {
       
		$nsalesmemo_id =  IdController::nSM($salesmemo_id);

        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        // Validation
        if (!Auth::check()) {
            # code...
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'You need to login to view this resource.');
        }
        $user_id = Auth::user()->id;
        $isadmin = DB::table('role_users')->where('role_id', '1')->where('user_id', $user_id)->count();
		$salesmemo= DB::table('salesmemo')->where('id',$salesmemo_id)->first();
		$pid=DB::table('salesmemoproduct')->where('salesmemo_id',$salesmemo_id)->pluck('product_id');
		$pid=DB::table('product')->where('id',$pid)->pluck('id');
		$merchant_id=DB::table('merchantproduct')->where('product_id',$pid)->whereNull('deleted_at')->pluck('merchant_id');
		// 
		$merchant = DB::table('merchant')->where('id',$merchant_id)->first();
		$merchantaux = DB::table('merchant')->where('id',$merchant_id)->first();
        if ($isadmin == 0) {
			if ($salesmemo->user_id != $user_id) {
				
				// $merchant = Merchant::where('user_id', $user_id)->first();
				if (is_null($merchant)) {
					# code...
					return view('common.generic')
									->with('message_type', 'error')
									->with('message', 'You do not have access to view this Sales Memo. Please contact OpenSupport');
				}
				$merchant_id = $merchant->id;
				$salesmemo= DB::table('salesmemo')->where('id',$salesmemo_id)->first();
				if (is_null($salesmemo)) {
					return view('common.generic')
									->with('message_type', 'error')
									->with('message', 'Invalid Sales Memo ID. Please contact OpenSupport');
				}

				$hasAccess = "yes";
				$orderproduct =DB::table('salesmemoproduct')->where('salesmemo_id',$salesmemo_id)->get();
				foreach ($orderproduct as $o) {
					$myp = DB::table('product')->where('id', $o->product_id)->first();
					$mp = DB::table('merchantproduct')->where('product_id', $myp->id)->first();
					if ($mp->merchant_id != $merchant_id) {
						$hasAccess = "no";
						return view('common.generic')
										->with('message_type', 'error')
										->with('message', 'You do not have access to view this Sales Memo. Please contact OpenSupport');
					}
				}
			} else {
				$hasAccess = "yes";
			}
        } else {
            $hasAccess = "yes";
        }		
		
        $buyer= User::leftJoin('address as add','add.id','=','users.default_address_id')
                ->leftJoin('city','add.city_id','=','city.id')
                ->leftJoin('state','state.code','=','city.state_code')
                ->where('users.id',$salesmemo->user_id)
                ->groupBy('users.id')
                ->select(DB::raw("
                    users.name,
                    add.line1,
                    add.line2,
                    add.line3,
                    users.mobile_no,
                    users.id,
                    state.name as state,
                    city.name as city,
                    add.postcode
                    "))

                ->first();
		//dd('buyer');
        $gst = array();
        try {

			$address_line = " AND users.default_address_id = address.id ";
			$role_line = "";
			$station = DB::table('station')->where('user_id',$salesmemo->user_id)->first();
			if(!is_null($station)){
				$address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
				$role_line = ", station";
			}
			$merchant = DB::table('merchant')->where('user_id',$salesmemo->user_id)->first();
			if(!is_null($merchant)){
				$address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
				$role_line = ", merchant as merchant2";
			}

            $salesmemo2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name
			,address.line1 AS user_address,address.line2 AS line2,address.line3 AS line3,address.line4 AS line4
			, merchant.id AS merchant_id, merchant.company_name AS merchant_name,salesmemo.salesmemo_no as merchantrecno, merchant.business_reg_no as mbiz
			,merchant.oshop_name AS oshop_name, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name
			, merchant.salesmemo_no AS salesmemo_no
			,maddress.line1 AS muser_address,maddress.line2 AS mline2,maddress.line3 AS mline3,maddress.line4 AS mline4, maddress.id as oshop_address_id,salesmemo.created_at as orderdate
				FROM users, address, address as a2, salesmemo,
				salesmemoproduct ' . $role_line . ', merchantproduct, product, merchant
				LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
				WHERE salesmemo.user_id = users.id
				AND salesmemoproduct.salesmemo_id = salesmemo.id
				AND merchantproduct.product_id = salesmemoproduct.product_id
				AND merchantproduct.product_id = product.id
				AND merchant.id = merchantproduct.merchant_id
				AND merchant.address_id = a2.id
				AND salesmemo.id = :salesmemo_id'), array('salesmemo_id' => $salesmemo_id));
            // dump($realdeliveryorderid[0]);
            $array_delivery = json_decode(json_encode($salesmemo2), True);
            // dd($array_delivery);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {
            dd ($e);
            // return $deliveryorder = null;
            // $products = null;
            // return view('do.deliveryorder', compact('deliveryorder', 'products'), ['currency' => $currency, 'array_delivery' => null, 'deliveryorderid' => $porder_id]);
        }		
		 
        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;
		$do_file_name="receipt-do/sm-".IdController::nSM($salesmemo_id).".pdf";
        // if ($array_delivery[0]['merchant_gst']!="") {
        //     # code...
        //         dd($array_delivery[0]['merchant_gst']);
        // }
        
            if (!is_null($array_delivery[0]['merchant_gst']) and $array_delivery[0]['merchant_gst'] == "") {
               return ['ndelivery_id' => $nsalesmemo_id, 'salesmemo' => $salesmemo, 'currency' => $currency, 'array_delivery' => $array_delivery, 'deliveryorderid' => $salesmemo_id,'buyer'=>$buyer];
            } else if(!is_null($array_delivery[0]) and $array_delivery[0]['merchant_gst']!="") {
            //    dd("HOLA");
				return ['ndelivery_id' => $nsalesmemo_id, 'salesmemo' => $salesmemo, 'currency' => $currency, 'array_delivery' => $array_delivery, 'deliveryorderid' => $salesmemo_id,'buyer'=>$buyer,'gst'=>$gst];
            }
            else{
                return [];
                // zxcv
            }		
	}		
	
    public function pdfPOSM($salesmemo_id) {
        $nsalesmemo_id =  IdController::nSM($salesmemo_id);

        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        // Validation
        if (!Auth::check()) {
            # code...
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'You need to login to view this resource.');
        }
        $user_id = Auth::user()->id;
        $isadmin = DB::table('role_users')->where('role_id', '1')->where('user_id', $user_id)->count();
		$salesmemo= DB::table('salesmemo')->where('id',$salesmemo_id)->first();
		$pid=DB::table('salesmemoproduct')->where('salesmemo_id',$salesmemo_id)->pluck('product_id');
		$pid=DB::table('product')->where('id',$pid)->pluck('id');
		$merchant_id=DB::table('merchantproduct')->where('product_id',$pid)->whereNull('deleted_at')->pluck('merchant_id');
		// 
		$merchant = DB::table('merchant')->where('id',$merchant_id)->first();
		$merchantaux = DB::table('merchant')->where('id',$merchant_id)->first();
        if ($isadmin == 0) {
			if ($salesmemo->user_id != $user_id) {
				
				// $merchant = Merchant::where('user_id', $user_id)->first();
				if (is_null($merchant)) {
					# code...
					return view('common.generic')
									->with('message_type', 'error')
									->with('message', 'You do not have access to view this Sales Memo. Please contact OpenSupport');
				}
				$merchant_id = $merchant->id;
				$salesmemo= DB::table('salesmemo')->where('id',$salesmemo_id)->first();
				if (is_null($salesmemo)) {
					return view('common.generic')
									->with('message_type', 'error')
									->with('message', 'Invalid Sales Memo ID. Please contact OpenSupport');
				}

				$hasAccess = "yes";
				$orderproduct =DB::table('salesmemoproduct')->where('salesmemo_id',$salesmemo_id)->get();
				foreach ($orderproduct as $o) {
					$myp = DB::table('product')->where('id', $o->product_id)->first();
					$mp = DB::table('merchantproduct')->where('product_id', $myp->id)->first();
					if ($mp->merchant_id != $merchant_id) {
						$hasAccess = "no";
						return view('common.generic')
										->with('message_type', 'error')
										->with('message', 'You do not have access to view this Sales Memo. Please contact OpenSupport');
					}
				}
			} else {
				$hasAccess = "yes";
			}
        } else {
            $hasAccess = "yes";
        }		
		
        $buyer= User::leftJoin('address as add','add.id','=','users.default_address_id')
                ->leftJoin('city','add.city_id','=','city.id')
                ->leftJoin('state','state.code','=','city.state_code')
                ->where('users.id',$salesmemo->user_id)
                ->groupBy('users.id')
                ->select(DB::raw("
                    users.name,
                    add.line1,
                    add.line2,
                    add.line3,
                    users.mobile_no,
                    users.id,
                    state.name as state,
                    city.name as city,
                    add.postcode
                    "))

                ->first();
		//dd('buyer');
        $gst = array();
        try {

			$address_line = " AND users.default_address_id = address.id ";
			$role_line = "";
			$station = DB::table('station')->where('user_id',$salesmemo->user_id)->first();
			if(!is_null($station)){
				$address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
				$role_line = ", station";
			}
			$merchant = DB::table('merchant')->where('user_id',$salesmemo->user_id)->first();
			if(!is_null($merchant)){
				$address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
				$role_line = ", merchant as merchant2";
			}

            $salesmemo2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name
			,address.line1 AS user_address,address.line2 AS line2,address.line3 AS line3,address.line4 AS line4
			, merchant.id AS merchant_id, merchant.company_name AS merchant_name,salesmemo.salesmemo_no as merchantrecno, merchant.business_reg_no as mbiz
			,merchant.oshop_name AS oshop_name, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name
			, merchant.salesmemo_no AS salesmemo_no
			,maddress.line1 AS muser_address,maddress.line2 AS mline2,maddress.line3 AS mline3,maddress.line4 AS mline4, maddress.id as oshop_address_id,salesmemo.created_at as orderdate
				FROM users, address, address as a2, salesmemo,
				salesmemoproduct ' . $role_line . ', merchantproduct, product, merchant
				LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
				WHERE salesmemo.user_id = users.id
				AND salesmemoproduct.salesmemo_id = salesmemo.id
				AND merchantproduct.product_id = salesmemoproduct.product_id
				AND merchantproduct.product_id = product.id
				AND merchant.id = merchantproduct.merchant_id
				AND merchant.address_id = a2.id
				AND salesmemo.id = :salesmemo_id'), array('salesmemo_id' => $salesmemo_id));
            // dump($realdeliveryorderid[0]);
            $array_delivery = json_decode(json_encode($salesmemo2), True);
            // dd($array_delivery);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {
            dd ($e);
            // return $deliveryorder = null;
            // $products = null;
            // return view('do.deliveryorder', compact('deliveryorder', 'products'), ['currency' => $currency, 'array_delivery' => null, 'deliveryorderid' => $porder_id]);
        }		
		
        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;
		$do_file_name="receipt-do/sm-".IdController::nSM($salesmemo_id).".pdf";
        // if ($array_delivery[0]['merchant_gst']!="") {
        //     # code...
        //         dd($array_delivery[0]['merchant_gst']);
        // }
        
            if (!is_null($array_delivery[0]['merchant_gst']) and $array_delivery[0]['merchant_gst'] == "") {
               $pdf=PDF::loadView('do.core.salesmemo',['ndelivery_id' => $nsalesmemo_id, 'salesmemo' => $salesmemo, 'currency' => $currency, 'array_delivery' => $array_delivery, 'deliveryorderid' => $salesmemo_id,'buyer'=>$buyer])->save(storage_path($do_file_name));
            } else if(!is_null($array_delivery[0]) and $array_delivery[0]['merchant_gst']!="") {
                $pdf=PDF::loadView('do.core.salesmemo_gst',['ndelivery_id' => $nsalesmemo_id, 'salesmemo' => $salesmemo, 'currency' => $currency, 'array_delivery' => $array_delivery, 'deliveryorderid' => $salesmemo_id,'buyer'=>$buyer,'gst'=>$gst])->save(storage_path($do_file_name));
            }
            else{
                return "File not available";
                // zxcv
            }		
	}	
	
    public static function pdfPODI($porder_id)
    {
//        ini_set('max_execution_time', 1800);
        /*
          The input $porder_id is actually porder.id
         */
        $ndelivery_id =  IdController::nO($porder_id);

        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        // Validation
        if (!Auth::check()) {
            # code...
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'You need to login to view this resource.');
        }
        $user_id = Auth::user()->id;
        $isadmin = DB::table('role_users')->where('role_id', '1')->where('user_id', $user_id)->count();
        if ($isadmin == 0) {
            $pid=DB::table('ordertproduct')->where('porder_id',$porder_id)->pluck('tproduct_id');
            $pid=DB::table('tproduct')->where('id',$pid)->pluck('id');
            $merchant_id=DB::table('merchanttproduct')->where('tproduct_id',$pid)->whereNull('deleted_at')->pluck('merchant_id');
            // 
            $merchant = DB::table('merchant')->where('id',$merchant_id)->first();
            // $merchant = Merchant::where('user_id', $user_id)->first();
            if (is_null($merchant)) {
                # code...
                return view('common.generic')
                                ->with('message_type', 'error')
                                ->with('message', 'You do not have access to view this deliveryorder. Please contact OpenSupport');
            }
            $merchant_id = $merchant->id;
            $porder = POrder::find($porder_id);
            if (is_null($porder)) {
                return view('common.generic')
                                ->with('message_type', 'error')
                                ->with('message', 'Invalid DeliveryOrder ID. Please contact OpenSupport');
            }

            $hasAccess = "yes";
            $orderproduct = DB::table('ordertproduct')->where('porder_id', $porder_id)->get();
            foreach ($orderproduct as $o) {
                $myp = DB::table('tproduct')->where('id', $o->tproduct_id)->first();
                $mp = DB::table('merchanttproduct')->where('tproduct_id', $myp->id)->first();
                if ($mp->merchant_id != $merchant_id) {
                    $hasAccess = "no";
                    return view('common.generic')
                                    ->with('message_type', 'error')
                                    ->with('message', 'You do not have access to view this deliveryorder. Please contact OpenSupport');
                }
            }
        } else {
            $hasAccess = "yes";
        }


        $porder= POrder::find($porder_id);
        $buyer= User::leftJoin('address as add','add.id','=','users.default_address_id')
                ->leftJoin('city','add.city_id','=','city.id')
                ->leftJoin('state','state.code','=','city.state_code')
                ->where('users.id',$porder->user_id)
                ->groupBy('users.id')
                ->select(DB::raw("
                    users.name,
                    add.line1,
                    add.line2,
                    add.line3,
                    users.mobile_no,
                    state.name as state,
                    city.name as city,
                    add.postcode
                    "))

                ->first();
		//dd('buyer');
        $gst = array();
        try {

			$address_line = " AND users.default_address_id = address.id ";
			$role_line = "";
			$station = DB::table('station')->where('user_id',$porder->user_id)->first();
			if(!is_null($station)){
				$address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
				$role_line = ", station";
			}
			$merchant = DB::table('merchant')->where('user_id',$porder->user_id)->first();
			if(!is_null($merchant)){
				$address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
				$role_line = ", merchant as merchant2";
			}
            $realdeliveryorderid = DB::select(DB::raw('SELECT MAX(deli.id) as id
				FROM deliveryinvoice deli, invoice inv
				WHERE deli.invoice_id = inv.id and inv.porder_id =' . $porder_id
            ));

            $deliveryorder = DB::table('deliveryinvoice')->where('id', $realdeliveryorderid[0]->id)->first();

            $deliveryorder2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name
			, deliveryinvoicetproduct.status as status,address.line1 AS user_address,address.line2 AS line2,address.line3 AS line3,address.line4 AS line4
			, merchant.id AS merchant_id, merchant.company_name AS merchant_name,invoice.id as original_id,invoice.invoice_no as merchantrecno, invoice.duration, merchant.business_reg_no as mbiz
			,merchant.oshop_name AS oshop_name, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name
			, merchant.invoice_no AS invoice_no, invoice.do_password as password
			,maddress.line1 AS muser_address,maddress.line2 AS mline2,deliveryinvoice.id as original_id,maddress.line3 AS mline3,maddress.line4 AS mline4, maddress.id as oshop_address_id,invoice.created_at as orderdate
				FROM users, address, address as a2, porder, invoice, deliveryinvoice
				, ordertproduct ' . $role_line . ', merchanttproduct, tproduct, deliveryinvoicetproduct, merchant
				LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
				WHERE porder.user_id = users.id
				
				AND invoice.porder_id = porder.id
				AND deliveryinvoice.invoice_id = invoice.id
				AND ordertproduct.porder_id = porder.id
				AND deliveryinvoicetproduct.tproduct_id = ordertproduct.tproduct_id
				AND deliveryinvoicetproduct.di_id = deliveryinvoice.id
				AND ordertproduct.tproduct_id = tproduct.id
				AND merchanttproduct.tproduct_id = tproduct.id
				AND merchant.id = merchanttproduct.merchant_id
				AND merchant.address_id = a2.id
				AND deliveryinvoice.id = :deliveryorderid'), array('deliveryorderid' => $realdeliveryorderid[0]->id));
            //dd($deliveryorder2);
            $array_delivery = json_decode(json_encode($deliveryorder2), True);
            // dd($array_delivery);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {
            dd ($e);
            // return $deliveryorder = null;
            // $products = null;
            // return view('do.deliveryorder', compact('deliveryorder', 'products'), ['currency' => $currency, 'array_delivery' => null, 'deliveryorderid' => $porder_id]);
        }


        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;
        $do_file_name="receipt-do/dip-".IdController::nO($porder_id).".pdf";

        // if ($array_delivery[0]['merchant_gst']!="") {
        //     # code...
        //         dd($array_delivery[0]['merchant_gst']);
        // }
   
       
            if (!is_null($array_delivery[0]['merchant_gst']) and $array_delivery[0]['merchant_gst'] == "") {
               $pdf=PDF::loadView('do.core.podi',['currency' => $currency, 'array_delivery' => $array_delivery, 'deliveryorderid' => $porder_id,'deliveryorder'=>$deliveryorder,'buyer'=>$buyer])->save(storage_path($do_file_name));
            } else if(!is_null($array_delivery[0]) and $array_delivery[0]['merchant_gst']!="") {
                $pdf=PDF::loadView('do.core.podigst',['currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'deliveryorderid' => $porder_id,'deliveryorder'=>$deliveryorder,'gst'=>$gst,
                    'buyer'=>$buyer
                    ])->save(storage_path($do_file_name));
            }
            else{
                return "File not available";
                // zxcv
            }
        
    }	
	
    public function QR($data,$identifier)
    {
        
    }

    public static function pdfRC($porder_id,$type="m2b")
    {
        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        $gst = array();

        $user_id=POrder::find($porder_id)->user_id;

		/*
		DB::table('stuff')->
			insert(['note'=>'pdfRC: user_id='.$user_id]);
		*/

        try {
            $address_line = " AND users.shipping_address_id = address.id ";
            $role_line = "";
            $station = DB::table('station')->where('user_id',$user_id)->first();
            if(!is_null($station)){
                $address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
                $role_line = ", station";
            }
            // Code to get the merchant id out
            $pid=DB::table('orderproduct')->where('porder_id',$porder_id)->pluck('product_id');
            $pid=DB::table('product')->where('id',$pid)->pluck('parent_id');
            $merchant_id=DB::table('merchantproduct')->where('product_id',$pid)
            ->whereNull('deleted_at')->pluck('merchant_id');
            // 
            $merchant = DB::table('merchant')->where('id',$merchant_id)->first();
            if(!is_null($merchant)){
                $address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
                $role_line = ", merchant as merchant2";
            }           
            //if()
            $receiptid = Receipt::where('porder_id', $porder_id)->first()->id;
            $qrFilePath=DOController::rcQR($receiptid);
            $deliveryorder = DeliveryOrder::where('receipt_id', $receiptid)->get();
            $deliveryorder2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name, address.line1 AS user_address,address.line2 AS line2,address.line3 AS line3,address.line4 AS line4, merchant.id AS merchant_id, merchant.company_name AS merchant_name, 
                receipt.receipt_no as merchantrecno,
                merchant.business_reg_no as mbiz,merchant.oshop_name AS oshop_name, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name, merchant.invoice_no AS invoice_no, receipt.do_password as password
            ,maddress.line1 AS muser_address,maddress.line2 AS mline2,receipt.id as original_id,maddress.line3 AS mline3,maddress.line4 AS mline4, maddress.id as oshop_address_id,receipt.created_at as orderdate
                FROM users, address, address as a2, porder, receipt, deliveryorder, orderproduct ' . $role_line . ', merchantproduct, product, merchant
                LEFT JOIN address as maddress ON maddress.id = merchant.address_id 

                WHERE porder.user_id = users.id
                AND address.id=users.default_address_id
                AND receipt.porder_id = porder.id
                AND deliveryorder.receipt_id = receipt.id
                AND orderproduct.porder_id = porder.id
                AND orderproduct.product_id = product.id
                AND merchantproduct.product_id = product.parent_id
                AND merchantproduct.deleted_at IS NULL
                AND merchant.id = merchantproduct.merchant_id
                AND merchant.address_id = a2.id
                AND deliveryorder.receipt_id = :receipt_id'),
					array('receipt_id' => $receiptid));
            //dd($deliveryorder2);

            $array_delivery = json_decode(json_encode($deliveryorder2), True);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {
        
            // return redirect()->back();
            throw new CustomException($e);
        }
        // return $array_delivery;
        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;
        $receipt_file_name="receipt-do/receiptp-".IdController::nO($porder_id).".pdf";
        $orderproduct=DB::table('orderproduct')->where('porder_id',$porder_id)->whereNull('deleted_at')->get();
        if (isset($array_delivery) and !file_exists(storage_path($receipt_file_name))) {
            if (is_null($array_delivery[0]['merchant_gst']) or $array_delivery[0]['merchant_gst']=="") {
                $pdf=PDF::loadView('do.core.rc', ['currency' => $currency, 'array_delivery' => $array_delivery, 'receipt_id' => $porder_id,
                    'orderproduct'=>$orderproduct,
                    'deliveryorder'=>$deliveryorder,'qrFilePath'=>$qrFilePath])->save(storage_path($receipt_file_name));
                // return $pdf->stream();
            } else {
                $pdf=PDF::loadView('do.core.rcgst', compact('deliveryorder', 'gst'), ['currency' => $currency, 'array_delivery' => $array_delivery,
                     'orderproduct'=>$orderproduct,
                 'gst' => $gst, 'receipt_id' => $porder_id,'qrFilePath'=>$qrFilePath])->save(storage_path($receipt_file_name));
            }

        } else {
            // return "500";
        }
        return $qrFilePath;
    }
	
    public static function pdfIV($porder_id,$type="m2b")
    {
        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        $gst = array();
        // Validation
        if (!Auth::check()) {
            # code...
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'You need to login to view this resource. #001');
        }
        $user_id = Auth::user()->id;
		$isadmin = DB::table('role_users')->where('role_id', '1')->where('user_id', $user_id)->count();
        $porder = POrder::find($porder_id);
        if (is_null($porder)) {
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'Invalid Receipt ID. Please contact OpenSupport. #002');
        }
        if ($isadmin == 0) {
			if ($porder->user_id != $user_id) {
				# code...
				return view('common.generic')
								->with('message_type', 'error')
								->with('message', 'You do not have permission to view this receipt. Please contact OpenSupport. #003');
			}
        }

        try {
			
			
			$address_line = " AND users.default_address_id = address.id ";
			$role_line = "";
			$station = DB::table('station')->where('user_id',$user_id)->first();
			if(!is_null($station)){
				$address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
				$role_line = ", station";
			}
			 // Code to get the merchant id out
            $pid=DB::table('ordertproduct')->where('porder_id',$porder_id)->pluck('tproduct_id');
            $pid=DB::table('tproduct')->where('id',$pid)->pluck('id');
            $merchant_id=DB::table('merchanttproduct')->where('tproduct_id',$pid)->pluck('merchant_id');
            // 
            $merchant = DB::table('merchant')->where('id',$merchant_id)->first();
			if(!is_null($merchant)){
				$address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
				$role_line = ", merchant as merchant2";
			}			
			//if()
			//$qrFilePath=DOController::rcQR($receiptid);
            $receiptid = DB::table('invoice')->where('porder_id', $porder_id)->first()->id;
            $deliveryorder = DB::table('deliveryinvoice')->where('invoice_id', $receiptid)->get();
            $deliveryorder2 = DB::select(DB::raw('
                SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name
			, address.line1 AS user_address,address.line2 AS line2,invoice.id as original_id,address.line3 AS line3,address.line4 AS line4, merchant.id AS merchant_id
			, merchant.company_name AS merchant_name, 
                invoice.invoice_no as merchantrecno, invoice.duration,merchant.business_reg_no as mbiz,merchant.oshop_name AS oshop_name
				, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name, merchant.invoice_no AS invoice_no
				, invoice.do_password as password
			,maddress.line1 AS muser_address,invoice.id as original_id,maddress.line2 AS mline2,maddress.line3 AS mline3,maddress.line4 AS mline4
			, maddress.id as oshop_address_id,invoice.created_at as orderdate
				FROM users, address, address as a2, porder, invoice, deliveryinvoice, ordertproduct, merchanttproduct
				, tproduct, merchant
				LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
				WHERE porder.user_id = users.id
				AND address.id=users.default_address_id
				AND invoice.porder_id = porder.id
				AND deliveryinvoice.invoice_id = invoice.id
				AND ordertproduct.porder_id = porder.id
				AND ordertproduct.tproduct_id = tproduct.id
				AND merchanttproduct.tproduct_id = tproduct.id
				AND merchant.id = merchanttproduct.merchant_id
				AND merchant.address_id = a2.id
				AND deliveryinvoice.invoice_id = :receipt_id'), array('receipt_id' => $receiptid));
           // dump($deliveryorder2);
            $array_delivery = json_decode(json_encode($deliveryorder2), True);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {
        
            // return redirect()->back();
            throw new CustomException($e);
        }
    
        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;
        // dump($array_delivery);
        $receipt_file_name="receipt-do/invoicep-".IdController::nO($porder_id).".pdf";

        if (isset($array_delivery) and !file_exists(storage_path($receipt_file_name))) {

            if (is_null($array_delivery[0]['merchant_gst']) or $array_delivery[0]['merchant_gst']=="") {
                $pdf=PDF::loadView('do.core.inv', ['currency' => $currency, 'array_delivery' => $array_delivery, 'receipt_id' => $porder_id,'deliveryorder'=>$deliveryorder])->save(storage_path($receipt_file_name));
                // return $pdf->stream();
            } else {
                $pdf=PDF::loadView('do.core.invgst', compact('deliveryorder', 'gst'), ['currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'receipt_id' => $porder_id])->save(storage_path($receipt_file_name));
            }
        } 
        else{
            // return "500";
        }
      //  return $qrFilePath;

    }	
    /* When ORDER ID is clicked from Buyer Dashboard URL: /buyer/dashboard */
    /* Receipt is opened for RECEIPT (receipt.blade) */
    /* or TAX INVOCIE  receipt.gst.blade)*/
    public function invoice($porder_id) {
//        ini_set('max_execution_time', 1800);
    /**    Log::debug("Porder Id".$porder_id);
        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        $gst = array();
        // Validation
        if (!Auth::check()) {
            # code...
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'You need to login to view this resource. #001');
        }
        $user_id = Auth::user()->id;
        $isadmin = DB::table('role_users')->where('role_id', '1')->where('user_id', $user_id)->count();
        $porder = POrder::find($porder_id);
        if (is_null($porder)) {
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'Invalid Receipt ID. Please contact OpenSupport. #002');
        }
        if ($isadmin == 0) {
            if ($porder->user_id != $user_id) {
                # code...
                return view('common.generic')
                                ->with('message_type', 'error')
                                ->with('message', 'You do not have permission to view this receipt. Please contact OpenSupport. #003');
            }
        }

        try {
            
            
            $address_line = " AND users.default_address_id = address.id ";
            $role_line = "";
            $station = DB::table('station')->where('user_id',$porder->user_id)->first();
            if(!is_null($station)){
                $address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
                $role_line = ", station";
            }
             // Code to get the merchant id out
            // $pid=DB::table('ordertproduct')->where('porder_id',$porder_id)->pluck('tproduct_id');
            $pid=DB::table('orderproduct')->where('porder_id',$porder_id)->pluck('product_id');
            // $pid=DB::table('tproduct')->where('id',$pid)->pluck('id');
             $pid=DB::table('product')->where('id',$pid)->pluck('id');
            Log::debug("Product ID".$pid);
            // $merchant_id=DB::table('merchanttproduct')->where('tproduct_id',$pid)->pluck('merchant_id');
             $merchant_id=DB::table('merchant')->where('user_id',$porder->user_id)->pluck('id');
            //
            Log::debug("Merchant ID".$merchant_id);
            $merchant = DB::table('merchant')->where('id',$merchant_id)->first();
            $stationterm = DB::table('stationterm')->where('station_id',$station->id)->where('creditor_user_id',$merchant->user_id)->first();
            if(!is_null($merchant)){
                $address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
                $role_line = ", merchant as merchant2";
            }           
            //if()
            $receiptid = DB::table('invoice')->where('porder_id', $porder_id)->first()->id;
            $deliveryinvoice = DB::table('deliveryinvoice')->where('invoice_id', $receiptid)->get();
            // $deliveryorder2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name
            // , address.line1 AS user_address,address.line2 AS line2,invoice.id as original_id,address.line3 AS line3,address.line4 AS line4, merchant.id AS merchant_id
            // , merchant.company_name AS merchant_name, 
            //     invoice.invoice_no as merchantrecno, invoice.duration,merchant.business_reg_no as mbiz,merchant.oshop_name AS oshop_name
            //     , a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name, merchant.invoice_no AS invoice_no
            //     , invoice.do_password as password
            // ,maddress.line1 AS muser_address,maddress.line2 AS mline2,maddress.line3 AS mline3,maddress.line4 AS mline4
            // , maddress.id as oshop_address_id,invoice.created_at as orderdate
            //     FROM users, address, address as a2, porder, invoice, deliveryinvoice, ordertproduct, merchanttproduct
            //     , tproduct, merchant
            //     LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
            //     WHERE porder.user_id = users.id
            //     AND address.id=users.default_address_id
            //     AND invoice.porder_id = porder.id
            //     AND deliveryinvoice.invoice_id = invoice.id
            //     AND ordertproduct.porder_id = porder.id
            //     AND ordertproduct.tproduct_id = tproduct.id
            //     AND merchanttproduct.tproduct_id = tproduct.id
            //     AND merchant.id = merchanttproduct.merchant_id
            //     AND merchant.address_id = a2.id
            //     AND deliveryinvoice.invoice_id = :receipt_id'), array('receipt_id' => $receiptid));
            $deliveryorder2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name
            , address.line1 AS user_address,address.line2 AS line2,invoice.id as original_id,address.line3 AS line3,address.line4 AS line4, merchant.id AS merchant_id
            , merchant.company_name AS merchant_name, 
                invoice.invoice_no as merchantrecno, invoice.duration,merchant.business_reg_no as mbiz,merchant.oshop_name AS oshop_name
                , a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name, merchant.invoice_no AS invoice_no
                , invoice.do_password as password
            ,maddress.line1 AS muser_address,maddress.line2 AS mline2,maddress.line3 AS mline3,maddress.line4 AS mline4
            , maddress.id as oshop_address_id,invoice.created_at as orderdate
                
                FROM porder
                left join orderproduct on orderproduct.porder_id = porder.id
                left join invoice on invoice.porder_id = porder.id
                left join product on orderproduct.product_id = product.id
                left join merchantproduct on merchantproduct.product_id = product.id
                left join merchant on merchant.id = merchantproduct.merchant_id
                left join users on porder.user_id = users.id
                left join address on address.id=users.default_address_id
                -- left join porder on porder.user_id = users.id
                left join address as a2 on merchant.address_id = a2.id
                LEFT JOIN address as maddress ON maddress.id = merchant.address_id 
                where invoice.id = :receipt_id'), array('receipt_id' => $receiptid));
                
        //  dd($deliveryorder2);
            $array_delivery = json_decode(json_encode($deliveryorder2), True);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {

            // return redirect()->back();
            throw new CustomException($e);
        }
        // return $array_delivery;
        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;
     //   dd($array_delivery);
        // echo '<pre>'; print_r($array_delivery); die();
        if (isset($array_delivery)) {
            if (is_null($array_delivery[0]['merchant_gst']) or $array_delivery[0]['merchant_gst']=="") {
                //return view('do.core.rc', compact('deliveryorder'), ['currency' => $currency, 'array_delivery' => $array_delivery, 'receipt_id' => $porder_id]);
                return view('do.invoice', compact('deliveryinvoice'), ['stationterm' => $stationterm,'currency' => $currency, 'array_delivery' => $array_delivery, 'receipt_id' => $porder_id])
                ->with('hideHeader','1');
                ;
            } else {
                //return view('do.core.rcgst', compact('deliveryorder', 'gst'), ['currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'receipt_id' => $porder_id]);
                return view('do.invoice_gst', compact('deliveryinvoice', 'gst'), ['stationterm' => $stationterm, 'currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'receipt_id' => $porder_id]);
            }
        } else {
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'An unexpected error ocurred. Please contact OpenSupport. #004');
        } **/
        $this->DirectInvoice = new GatorInvoiceController();
        $InvoicedisplayData = $this->DirectInvoice->displayInvoice($porder_id);

        return view('do.invoice')->
        with([
            'InvoiceDisplayData' => $InvoicedisplayData,
            'OrderId' => $porder_id]);
	}
    public function receipt($porder_id) {
//        ini_set('max_execution_time', 1800);
        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }
        $gst = array();
        // Validation
        if (!Auth::check()) {
            # code...
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'You need to login to view this resource. #DCR001');
        }
        $user_id = Auth::user()->id;
		$isadmin = DB::table('role_users')->where('role_id', '1')->where('user_id', $user_id)->count();
        $porder = POrder::find($porder_id);
        if (is_null($porder)) {
            return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'Invalid Receipt ID. Please contact OpenSupport. #DCR002');
        }
        /*SMMOUT VALIDATION*/
        $smm_user_id=-1;
        $smmin=DB::table('smmin')->where('porder_id',$porder->id)->first();
        if (!empty($smmin)) {
            $smm_user_id=DB::table('smmout')->where('id',$smmin->smmout_id)->pluck('user_id');
        }
        // dump($smm_user_id);
        if ($isadmin == 0) {
			if (($porder->user_id != $user_id) and ($user_id!=$smm_user_id)) {


				$pid=DB::table('orderproduct')->where('porder_id',$porder_id)->pluck('product_id');
				$pid=DB::table('product')->where('id',$pid)->pluck('id');
				$merchant_id=DB::table('merchantproduct')->where('product_id',$pid)->whereNull('deleted_at')->pluck('merchant_id');
            // 
				$merchant = DB::table('merchant')->where('id',$merchant_id)->first();
				$merchant_user = DB::table('merchant')->where('user_id', $user_id)->first();
				if(is_null($merchant_user) || is_null($merchant)){
					# code...
					return view('common.generic')
								->with('message_type', 'error')
								->with('message', 'You do not have permission to view this receipt. Please contact OpenSupport. #DCR003');
				} else {
					if ($merchant_user->id != $merchant->id) {
						# code...
						return view('common.generic')
									->with('message_type', 'error')
									->with('message', 'You do not have permission to view this receipt. Please contact OpenSupport. #DCR004');
					}
				}
				
			}
        }

        try {
			
			
			$address_line = " AND users.default_address_id = address.id ";
			$role_line = "";
			$station = DB::table('station')->where('user_id',$user_id)->first();
			if(!is_null($station)){
				$address_line = " AND station.station_address_id = address.id AND station.user_id = users.id ";
				$role_line = ", station";
			}
			 // Code to get the merchant id out
            $pid=DB::table('orderproduct')->where('porder_id',$porder_id)->pluck('product_id');
            $pid=DB::table('product')->where('id',$pid)->pluck('parent_id');
            $merchant_id=DB::table('merchantproduct')->where('product_id',$pid)
            ->whereNull('deleted_at')->pluck('merchant_id');
            // 
            $merchant = DB::table('merchant')->where('id',$merchant_id)->first();
			if(!is_null($merchant)){
				$address_line = " AND merchant2.address_id = address.id AND merchant2.user_id = users.id ";
				$role_line = ", merchant as merchant2";
			}			
			//if()
            $receiptid = Receipt::where('porder_id', $porder_id)->first()->id;
            $deliveryorder = DeliveryOrder::where('receipt_id', $receiptid)->get();


            $deliveryorder2 = DB::select(DB::raw('SELECT DISTINCT(users.id) AS user_id, CONCAT(users.first_name,  \' \', users.last_name) AS user_name, address.line1 AS user_address,address.line2 AS line2,address.line3 AS line3,address.line4 AS line4, merchant.id AS merchant_id, merchant.company_name AS merchant_name, 
                receipt.receipt_no as merchantrecno,merchant.business_reg_no as mbiz,receipt.id as original_id,merchant.oshop_name AS oshop_name, a2.line1 AS merchant_address, merchant.gst AS merchant_gst, merchant.oshop_name AS oshop_name, merchant.invoice_no AS invoice_no, receipt.do_password as password
			,maddress.line1 AS muser_address,maddress.line2 AS mline2,maddress.line3 AS mline3,maddress.line4 AS mline4, maddress.id as oshop_address_id,receipt.created_at as orderdate
				FROM users, address, address as a2, porder, receipt, deliveryorder, orderproduct ' . $role_line . ', merchantproduct, product, merchant
				LEFT JOIN address as maddress ON maddress.id = merchant.address_id  
				WHERE porder.user_id = users.id
				AND address.id=users.default_address_id
				AND receipt.porder_id = porder.id
				AND deliveryorder.receipt_id = receipt.id
				AND orderproduct.porder_id = porder.id
				AND orderproduct.product_id = product.id
				AND merchantproduct.product_id = product.parent_id
                AND merchantproduct.deleted_at IS NULL
				AND merchant.id = merchantproduct.merchant_id
				AND merchant.address_id = a2.id
				AND deliveryorder.receipt_id = :receipt_id'), array('receipt_id' => $receiptid));
            //dd($deliveryorder2);
            $orderproduct=DB::table('orderproduct')->where('porder_id',$porder_id)->get();
            $array_delivery = json_decode(json_encode($deliveryorder2), True);
            $gst = DB::select(DB::raw('SELECT gst_rate FROM global limit 1'));
        } catch (\Exception $e) {
        
            // return redirect()->back();
            throw new CustomException($e);
        }
        // return $array_delivery;
        $array_delivery = is_array($array_delivery) && !empty($array_delivery) ? $array_delivery : null;

        if (isset($array_delivery)) {
            if (is_null($array_delivery[0]['merchant_gst']) or $array_delivery[0]['merchant_gst']=="") {
                //return view('do.core.rc', compact('deliveryorder'), ['currency' => $currency, 'array_delivery' => $array_delivery, 'receipt_id' => $porder_id]);
                return view('do.receipt', compact('deliveryorder','orderproduct'), ['currency' => $currency, 'array_delivery' => $array_delivery, 'receipt_id' => $porder_id])
                ->with('hideHeader','1');
                ;
            } else {
                $productcashback = Product::where('id',$orderproduct[0]->product_id)->first();
                $totalcashback = ($productcashback->cashback)+($productcashback->pcashback);
               
                //return view('do.core.rcgst', compact('deliveryorder', 'gst'), ['currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'receipt_id' => $porder_id]);
               //dump($deliveryorder[0]->products);exit();
                return view('do.receipt_gst', compact( 'deliveryorder','gst','orderproduct','totalcashback'), ['currency' => $currency, 'array_delivery' => $array_delivery, 'gst' => $gst, 'receipt_id' => $porder_id]);
            }
        } else {
			return view('common.generic')
                            ->with('message_type', 'error')
                            ->with('message', 'An unexpected error ocurred. Please contact OpenSupport. #004');
		}
    }

public static function processOrder($porder_id,$deliveryorder)
{
    
            $porder = DB::table("porder")->where('id',$porder_id)->first();
            $flag = 1;
            $user_id = $porder->user_id;
            $merchant_id = 0;
            $merchant = DB::table('merchant')->where('user_id', $user_id)->first();
            if(!is_null($merchant)){
                $merchant_id = $merchant->id;
            }
            $user_id = $porder->user_id;
            $imstation = DB::table('station')->where('user_id', $user_id)->where('status', 'active')->count();
            $imautolink = DB::table('autolink')->where('initiator', $user_id)->where('responder', $merchant_id)->where('status','linked')->count();
            foreach ($deliveryorder->products as $product) {
                
              
                $prime_product = DB::table('product')->
                    where('id',$product->product_id)->first();
    

                $parent_product = DB::table('product')->
                    where('id',$prime_product->parent_id)->first();             
            

                
                    DB::table('deliveryordersproduct')->where('product_id', $prime_product->id)->where('do_id', $deliveryorder->id)->update(['status' => 'b-collected']);
                    DB::table('orderproduct')->where('product_id', $prime_product->id)->where('porder_id', $porder_id)->update(['status' => 'b-collected']);
                    /* $product->status="b-collected";
                      $product->save(); */
                      
                        if($imstation > 0 && $imautolink > 0 && $prime_product->segment == 'b2b'){
                            $op = DB::table('orderproduct')->where('porder_id',$porder_id)->where('product_id',$prime_product->id)->first();
                            $station = DB::table('station')->where('user_id', $user_id)->where('status', 'active')->first();
                            $stationsproduct = DB::table('stationsproduct')->where('station_id', $station->id)->join('sproduct', 'stationsproduct.sproduct_id','=','sproduct.id')->where('sproduct.product_id',$prime_product->id)->count();
                            if($stationsproduct > 0){
                                $stationsproduct = DB::table('stationsproduct')->where('station_id', $station->id)->join('sproduct', 'stationsproduct.sproduct_id','=','sproduct.id')->where('sproduct.product_id',$prime_product->id)->select('sproduct.*')->first();
                                //dd($stationsproduct);
                                DB::table('sproduct')->where('id',$stationsproduct->id)->update(['available'=>($op->quantity + $stationsproduct->available),'stock'=>($op->quantity + $stationsproduct->stock),'status'=>'active','updated_at'=>date('Y-m-d H:i:s')]);
                            } else {
                                $sp_id = DB::table('sproduct')->insertGetId(['available'=>$op->quantity,'status'=>'active', 'stock'=>$op->quantity, 'shipping_cost'=>$op->order_delivery_price * 100, 'product_id'=>$prime_product->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
                                $sps_id = DB::table('stationsproduct')->insert(['station_id'=>$station->id, 'sproduct_id'=>$sp_id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
                            }   
                        }                     
                
            }
            $cond=DB::table('orderproduct')->where('porder_id',$porder_id)
            ->where('status','l-collected')->first();
            if (is_null($cond)) {
                $flag=1;
            }
            if ($flag == 1) {
                $deliveryorder['status'] = 'b-collected';
                $postatus = 'b-collected';
            } else {
                $deliveryorder['status'] = 'partial';
                $postatus = 'partial';
            }
            $deliveryorder->save();
            //DB::table('porder')->where('id',$porder_id)->update(['status'=>$postatus,'receipt_tstamp'=>Carbon::now()]);

            /*  Paul on 25 April 2017 at 12 am
            Modified ->where to -> find TO RAISE updated event on
            Model POrder...
            When we use ->where, updated event is not fired but
            when we use ->find, updated event will be fired
            events are present in EventServiceProvider  */

            POrder::find($porder_id)->update(['status'=>$postatus,'receipt_tstamp'=>Carbon::now()]);
    $code = 1;

        
}


/** [Stock report genertion] */
public function stockreport($id,$uid=null){
    try{
        if (!Auth::check()) {
            return view('common.generic')
            ->with('message_type','error')
            ->with('message','Please login to access this page')
            ;
        }

        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
       
        $selluser = User::find($user_id);
        $report_data = Stockreport::with('report_products','checker','creator','checker_company','creator_company','fairlocation','report_products.product')->find($id);
        return view('do.report', compact('report_data','selluser'));
    }catch(\Exception $e){
        Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
        throw new CustomException($e);        
    }
}

    public function savestockremark()
    {
      
        $remark = Request::input('remark');
        $srId = Request::input('srId');
        $res = array();
        $res['status'] = "error";
        $save = DB::table('stockreport')
                  ->where('id',$srId)
                  ->update([
                    'remark' => $remark,
                    'updated_at' =>Carbon::now()
                  ]);
        if($save)
        {
            $res['status'] = "success"; 
        }
        return response()->json($res);
    
    }

}
