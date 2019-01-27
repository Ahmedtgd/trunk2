<?php



/**
 * Created by PhpStorm.
 * User: Chris Uzor
 * Date: 10/25/2018
 * Time: 13:47
 */
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\OposSpaCustomer;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Globals;
use App\Models\OposSparoom;
use App\Models\OposReceiptproduct;
use App\Models\OposReceipt;
use App\Models\OposDiscount;
use App\Models\OposMerchantterminal;
use App\Models\OposTerminal;
use App\Models\OposBundle;
use App\Models\OposBundleProduct;
use Auth;
use DB;
use Log;
use Carbon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
use App\Models\User;
use App\Models\Address;
use App\Models\OposSave;
use App\Models\RoleUser;
use App\Models\Buyer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Rhumsaa\Uuid\Console\Exception;

class SalesItemsController extends Controller
{


    public function sales_items_today(Request $request){
        $user_id = Auth::user()->id;
        $merchant = Merchant::where( 'user_id', '=', $user_id )->first();

        $location = DB::table('fairlocation as f')->join
        ('opos_locationterminal as olt', 'olt.location_id', '=', 'f.id')->join
        ('opos_terminal as ot', 'ot.id', '=', 'olt.terminal_id')
            ->select('ot.id', 'f.location', 'f.id', 'ot.start_work')
            ->whereNotNull('ot.start_work')
            ->where('f.user_id', $merchant->user_id)->get();
        $all = [];

        foreach ($location as $id){
            $all [] = $id->id;
        }

		Log::debug($all);

        $rdate = $request['date'];
        $date = Carbon::createFromFormat('d-M-Y', $rdate);
        $date = $date->format('Y-m-d');

        $sales_items = $this->sales_items_query_all($merchant,$date,$all);

        $product = $this->default_products($merchant);

		$product = $this->calculations($product,$sales_items);

        if (!empty($product)) {
            return $product;
        } else {
            return 0;
        }
    }

    public function sales_items_default()
    {
		Log::debug('***** sales_items_default() *****');

        $user_id = Auth::user()->id;
        $merchant = Merchant::where('user_id', '=', $user_id)->first();
        $location = DB::table('fairlocation as f')->join
        ('opos_locationterminal as olt', 'olt.location_id', '=', 'f.id')->join
        ('opos_terminal as ot', 'ot.id', '=', 'olt.terminal_id')
            ->select('ot.id', 'f.location', 'f.id', 'ot.start_work')
            ->whereNotNull('ot.start_work')
            ->where('f.user_id', $merchant->user_id)->get();
                $all = [];
        foreach ($location as $id){
            $all[] = $id->id;
        }
		Log::debug($all);


        //Log::debug($location_id);
        $date = Carbon::now()->format('Y-m-d');

        $sales_items = $this->sales_items_query_all($merchant,$date,$all);

        $product = $this->default_products($merchant);
        $product = $this->calculations($product,$sales_items);


        if (!empty($product)) {
            return $product;
        } else {
            return 0;
        }


    }

    public function sales_items($uid = null)
    {

        if (!Auth::check()) {
            return view( 'common.generic' )
                ->with( 'message_type', 'error' )
                ->with( 'message', 'Please login to access' );
        }

        if (is_null( $uid )) {
            $user_id = Auth::id();
        } else {
            $user_id = $uid;
        }

        $merchant = Merchant::where( 'user_id', '=', $user_id )->first();

        $since = DB::table( 'merchant' )->
        where( 'user_id', $user_id )->
        orderBY( 'created_at', 'ASC' )->pluck( 'created_at' );

        if (is_null( $since )) {
            $since = date( "d-M-Y", strtotime( '-2 year', date( "Y-m-d" ) ) );
        } else {
            $since = date( "d-M-Y", strtotime( $since ) );
        }

        $locations = DB::table('fairlocation as f')->join
        ('opos_locationterminal as olt','olt.location_id','=','f.id')->join
        ('opos_terminal as ot','ot.id','=','olt.terminal_id')->select
        ('ot.id','f.location','ot.start_work','f.id')->where
        ('f.user_id',$merchant->user_id)->
            groupBy('f.location')->get();
        $mode = "All";

        return view( 'merchant.itemized_sales', compact( 'since','locations','mode' ) );
    }

    public function rounding($sales){
        $item_sales = number_format($sales, 2);
        list($nos, $decimal) = explode('.',$item_sales);
       $rounding = substr($decimal, -1);
      //  $decimal = (int)$decimal;
        $rounding = (int)$rounding;


		switch($rounding) {
			case 1:
				$sales = -0.01;
				break;
			case 2:
				$sales = -0.02;
				break;
			case 3:
				$sales = 0.02;
				break;
			case 4:
				$sales = 0.01;
				break;
			case 5:
				$sales = '0.00';
				break;
			case 6:
				$sales = -0.01;
				break;
			case 7:
				$sales = -0.02;
				break;
			case 8:
				$sales = 0.02;
				break;
			case 9:
				$sales = 0.01;
				break;
			case 0:
				$sales = '0.00';
				break;
			default:
		}

		return $sales;
    }

    public function location_sales_items($id)
    {
        if (!Auth::check()) {
            return view( 'common.generic' )
                ->with( 'message_type', 'error' )
                ->with( 'message', 'Please login to access' );
        }

		$user_id = Auth::id();

        $merchant = Merchant::where( 'user_id', '=', $user_id )->first();
        $since = DB::table( 'merchant' )->
			where( 'user_id', $user_id )->
			orderBY( 'created_at', 'ASC' )->
			pluck( 'created_at' );

        if (is_null( $since )) {
            $since = date( "d-M-Y", strtotime( '-2 year', date( "Y-m-d" ) ) );
        } else {
            $since = date( "d-M-Y", strtotime( $since ) );
        }

        $location = DB::table('fairlocation as f')->
			join('opos_locationterminal as olt','olt.location_id','=','f.id')->
			join('opos_terminal as ot','ot.id','=','olt.terminal_id')->
			select('f.id','f.location','ot.start_work')->
			where('f.user_id',$merchant->user_id)->
			where('f.id', $id)->first();

      //  dd($location);
       
        $locations = DB::table('fairlocation as f')->
			join('opos_locationterminal as olt','olt.location_id','=','f.id')->
			join('opos_terminal as ot','ot.id','=','olt.terminal_id')->
			select('ot.id','f.location','ot.start_work','f.id')->
			where('f.user_id',$merchant->user_id)->
			groupBy('f.location')->get();

		$mode = "One";
        if($location){
			Log::debug("***** Location ID *****");
			Log::debug($location->start_work);
			if(empty($location->start_work)){
				$location->start_work=1;
			}
        }
        return view('merchant.itemized_sales',
			compact( 'since','location','locations','mode') );
    }


    public function location_sales_items_default($id){
		Log::debug('***** location_sales_items_default() *****');

        $user_id = Auth::user()->id;
        $merchant = Merchant::where( 'user_id', '=', $user_id )->first();
        $location_id = DB::table('fairlocation as f')->join
        ('opos_locationterminal as olt','olt.location_id','=','f.id')->join
        ('opos_terminal as ot','ot.id','=','olt.terminal_id')
            ->select('ot.id','f.location','ot.start_work')->where('f.id', $id)->first();
        Log::debug("Location");
        Log::debug($location_id->start_work);
        $date = Carbon::now()->format('Y-m-d');

        //$date = Carbon::createFromFormat('m/d/Y', $date)->toDateTimeString();

        //Here comes the query
        $sales_items = $this->sales_items_query_all($merchant,$date,$id);

        $product = $this->default_products($merchant);

        $product=  $this->calculations($product, $sales_items);


        if (!empty($product)) {
            return $product;
        } else {
            return 0;
        }


    }
    public function location_sales_items_today(Request $request){
		Log::debug('***** location_sales_items_today() *****');

        $user_id = Auth::user()->id;
        $merchant = Merchant::where( 'user_id', '=', $user_id )->first();
        $id = trim($request['id']);

        $location_id = DB::table('fairlocation as f')->
			join('opos_locationterminal as olt','olt.location_id','=','f.id')->
			join('opos_terminal as ot','ot.id','=','olt.terminal_id')->
			select('ot.id','f.location','ot.start_work')->
			where('f.id', $id)->
			first();

        Log::debug('$id='.json_encode($id));
        Log::debug('$location_id='.json_encode($location_id));

        $rdate = $request['date'];
		$date = Carbon::createFromFormat('d-M-Y', $rdate);
        $date = $date->format('Y-m-d');

		Log::debug('***** date *****');
		Log::debug($date);

		$sales_items = $this->sales_items_query_all($merchant,$date,$id);

		$product = $this->default_products($merchant);

		$product = $this->calculations($product,$sales_items);

        if (!empty($product)) {
            $ret = $product;
        } else {
            $ret = 0;
        }
		return $ret;
    }

    public function calculations($product, $sales_items){
		Log::debug('***** calculations() *****');

        $total_sales = 0;
        $total_sst = 0;
        $total_service_charge = 0;
        $total_amount = 0;
        $total_rounding = 0;
        $count = 0;

        foreach ($product as $p){
            ++$count;
            $p->sales = 0;
            $p->amount = 0;
            $p->sst = 0;
            $p->quantity = 0;
            $p->rounding = 0;
            $p->servicecharge = 0;

            foreach ($sales_items as $key =>  $item) {

				/*
				Log::debug('***** item *****');
				Log::debug($key);
				Log::debug(json_encode($item));
				 */

                // $p->sales = 0;
                if ($p->id == $item->id) {
                    $p->quantity += $item->quantity;
                    $price = ($item->price / 100);
                    //get the discount of product
                    $discount = (($item->discount / 100) * $price);

                    $price = $price - $discount;

                    //  $final_price = $price * $item->quantity;
                    if ($item->mode == 'inclusive') {
                        $tax = 1 + ($item->service_tax / 100);
                        $sales = ($price / $tax);
                        $service_charge = (($item->servicecharge / 100) * $sales);
                        $p->servicecharge += $service_charge;
                        $sales = $sales * $item->quantity;
                        $sst = (($price * $item->quantity) - $sales);
                        $p->sales += $sales;
                        // $amount = $sales + $this->rounding($sales) + $item->servicecharge + $sst;
                        $amount = $price + $service_charge;
                        $amount = ($amount * $item->quantity);
                        $p->rounding += $this->rounding($amount);
                        $total_rounding = $total_rounding + $this->rounding($amount);
                        $amount = $amount + $this->rounding($amount);

                        $p->sst += $sst;
                        $p->amount += $amount;

                        $total_sales = $total_sales + $sales;
                        $total_service_charge = $total_service_charge + $service_charge;
                        $total_sst = $total_sst + $sst;

                        $total_amount = $total_amount + $amount;

                    } else {
                        /* mode = 'exclusive' */
                        $sales = ($price * $item->quantity);
                        $service_charge = (($item->servicecharge / 100) * $sales);
                        $sst = (($price * $item->quantity) * ($item->service_tax / 100));
                        $amount = $price * $item->quantity;
                        $amount = ($amount * (1 + $item->service_tax / 100)) + $service_charge;
                        $p->rounding += $this->rounding($amount);
                        $total_rounding = $total_rounding + $this->rounding($amount);
                        $amount = $amount + $this->rounding($amount);
                        $p->sst += $sst;
                        $p->servicecharge += $service_charge;
                        $p->amount += $amount;
                        $p->sales += $sales;
                        $total_sales = $total_sales + $sales;
                        $total_service_charge = $total_service_charge + $service_charge;
                        $total_sst = $total_sst + $sst;
                        // $total_rounding = $total_rounding + $this->rounding($amount);
                        $total_amount = $total_amount + $amount;
                    }
                }
            }

            $p->sales =  number_format($p->sales, 2);
            $p->sst =  number_format($p->sst, 2);
            $p->servicecharge = number_format($p->servicecharge, 2);
            $p->rounding =  number_format($p->rounding, 2);
            $p->amount =  number_format($p->amount, 2);

          /**  Log::debug('sales        ='.json_encode($p->sales));
            Log::debug('sst          ='.json_encode($p->sst));
            Log::debug('servicecharge='.$p->servicecharge);
            Log::debug('rounding     ='.json_encode($p->rounding));
            Log::debug('amount       ='.$p->amount);
*/
            $p->total_rounding = number_format($total_rounding, 2);
            $p->total_amount = number_format($total_amount, 2);
            $p->total_sales = number_format($total_sales, 2);
            $p->total_sst = number_format($total_sst, 2);
            $p->total_service_charge = number_format($total_service_charge, 2);
        }

		/*
		Log::debug('***** product *****');
		Log::debug($product);
		 */

        return $product;
    }


    public function default_products($merchant){
        $product = $merchant->products()
            ->whereNull('product.deleted_at')
            ->leftJoin('product as productb2b', function($join) {
                $join->on('product.id', '=', 'productb2b.parent_id')
                    ->where('productb2b.segment','=','b2b');
            })
            ->leftJoin('product as producthyper', function($join) {
                $join->on('product.id', '=', 'producthyper.parent_id')
                    ->where('producthyper.segment','=','hyper');
            })
            ->leftJoin('tproduct as tproduct', function($join) {
                $join->on('product.id', '=', 'tproduct.parent_id');
            })
            ->join('nproductid as np', 'np.product_id', '=', 'product.id')
            ->leftJoin('productbc','product.id','=','productbc.product_id')
            ->leftJoin('opos_receiptproduct', 'opos_receiptproduct.product_id', '=', 'product.id')
            ->leftJoin('bc_management','bc_management.id','=','productbc.bc_management_id')
            ->select(DB::raw('
                product.id,
                np.nproduct_id as npid,
                product.parent_id,
                bc_management.id as bc_management_id,
                productbc.deleted_at as pbdeleted_at,
                product.name,
                product.thumb_photo'))
            ->where("product.status","!=","transferred")
            ->where("product.status","!=","deleted")
            ->where("product.status","!=","")
            ->groupBy('product.id')
            ->get();

        return $product;
    }


   /** public function sales_items_query_id($merchant,$from,$to,$id){
		Log::debug('***** sales_items_query_id() *****');

		$terminal_id = DB::table('opos_locationterminal')->
			where('location_id',$id)->
            whereBetween('start_work',[$from,$to])->
            select('terminal_id','')->get();

		$sales_items = DB::table('opos_receiptproduct as op')->
			select('np.nproduct_id as nid', 'p.name','p.id as id',
				'op.receipt_id','op.discount','op.quantity',
				'opr.terminal_id','op.created_at','op.price','opr.mode',
				'opr.service_tax','sc.value as servicecharge')->
			join('product as p', 'p.id', '=', 'op.product_id')->
			join('opos_receipt as opr','op.receipt_id','=','opr.id')->
			join('opos_terminal as ot','opr.terminal_id','=','ot.id')->
			join('opos_locationterminal as lt','lt.terminal_id','=','ot.id')->
			join('fairlocation as fl', 'lt.location_id','=','fl.id')->
			join('opos_servicecharge as sc','sc.id','=','opr.servicecharge_id')->
			join('nproductid as np', 'np.product_id', '=', 'p.id')->
			whereBetween('opr.created_at',[$from, $to])->
			where('fl.user_id', $merchant->user_id)->
			where('opr.status','completed')->
			where('fl.id',$id)->
			get();

        return  $sales_items;
    }
**/

    public function sales_items_query_all($merchant,$date,$all){
		Log::debug('***** sales_items_query_all() *****');

 		Log::debug('***** merchant:'.$merchant->user_id);

        if(is_array($all)){
            $terminal_id = DB::table('opos_locationterminal')->
            join('opos_terminal as ot','opos_locationterminal.terminal_id','=','ot.id')->
            whereIn('opos_locationterminal.location_id',$all)->
           // whereBetween('ot.start_work',[$from,$to])->
            select('opos_locationterminal.terminal_id', 'ot.start_work')->
            get();

        }else{
            $terminal_id = DB::table('opos_locationterminal')->
            join('opos_terminal as ot','opos_locationterminal.terminal_id','=','ot.id')->
            where('location_id',$all)->
            select('terminal_id','ot.start_work')->get();
        }


		Log::debug('***** terminal_id *****');
		Log::debug($terminal_id);

       $sales_items = [];
        foreach ($terminal_id as $t){
            try{
                Log::debug("***** terminal_id=".$t->terminal_id);
                Log::debug("date =".$date);
                $from =  Carbon::createFromFormat('Y-m-d H:i:s',
                    $date.' ' .$t->start_work)->toDateTimeString();

                $from_ =  Carbon::createFromFormat('Y-m-d H:i:s',
                    $date.' ' .$t->start_work);

                Log::debug('from ='.$from);

            } catch (\Exception $e){
                Log::error("Error @ ".$e->getLine()." file ".
                    $e->getFile()." ".$e->getMessage());

                //	Log::debug('$date='.$date);
                //	Log::debug('$location_id->start_work='.$location_id->start_work);

                $from =  Carbon::createFromFormat('Y-m-d H:i:s',
                    $date.' 01:01:01')->toDateTimeString();
                $from_ =  Carbon::createFromFormat('Y-m-d H:i:s',
                    $date.' 01:01:01');
                Log::debug('from='.$from);
            }

            $to_ = $from_->addDay();
            $to  = $to_->subMinutes(1);
			Log::debug('to   ='.$to);

			$items = [];

            $items = DB::table('opos_receiptproduct as op')->
            select('np.nproduct_id as nid', 'p.name','p.id as id',
                'op.receipt_id','op.discount','op.quantity','opr.terminal_id',
                'op.created_at','op.price','opr.mode','opr.service_tax',
                'sc.value as servicecharge',
                'ot.id as tid')->
            join('product as p', 'p.id', '=', 'op.product_id')->
            join('opos_receipt as opr','op.receipt_id','=','opr.id')->
            join('opos_terminal as ot','opr.terminal_id','=','ot.id')->
            join('opos_locationterminal as lt','lt.terminal_id','=','ot.id')->
            join('fairlocation as fl', 'lt.location_id','=','fl.id')->
            leftjoin('opos_servicecharge as sc','sc.id','=','opr.servicecharge_id')->
            join('nproductid as np', 'np.product_id', '=', 'p.id')->
            whereBetween('opr.created_at',[$from, $to])->
            where('fl.user_id', $merchant->user_id)->
            where('opr.status','completed')->
            whereNull('op.deleted_at')->
            where('ot.id',$t->terminal_id)->
            get();

			/*
			$items  = DB::select(DB::raw("
				SELECT
					op.id,
					op.receipt_no,
					op.cash_received,
					op.otherpoints,
					op.creditcard_no,
					op.status,
					orp.status,
					orp.product_id,
					orp.quantity,
					op.created_at
				FROM 
					opos_receipt op,
					opos_receiptproduct orp,
					nproductid np,
					product p,
					opos_terminal ot,
					opos_locationterminal lt,
					fairlocation fl
				WHERE
					fl.id=lt.location_id and
					lt.terminal_id=ot.id and
					op.terminal_id=ot.id and
					orp.product_id=p.id and
					np.product_id=p.id and
					orp.receipt_id=op.id and
					orp.deleted_at is null and
					op.deleted_at is null and
					op.status='completed' and
					fl.user_id=".$merchant->user_id." and
					op.created_at >= '".$from."' and
					op.created_at <= '".$to."' and
					op.terminal_id=".$t->terminal_id
			));
			*/

            if(!empty($items)){
				Log::debug('***** items: terminal_id='.$t->terminal_id.' *****');
				Log::debug('count(items)      ='.count($items));

				foreach ($items as $i) {
					array_push($sales_items, $i);
					Log::debug('count(sales_items)='.count($sales_items));
				}
            }
        }

		Log::debug('***** terminals *****');
		//Log::debug($terminals);

		Log::debug('***** sales_items *****');
		Log::debug($sales_items);
		Log::debug('count(sales_items)='.count($sales_items));


//        foreach ($sales_items as $s){
//            Log::debug('sales='.($s->tid));
//        }

        return  $sales_items;
    }
}
