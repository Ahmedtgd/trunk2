<?php
/**
 * Created by PhpStorm.
 * User: Chris Uzor
 * Date: 11/10/2018
 * Time: 23:11
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

class CreditProductSalesController extends Controller{

    public function productsales($uid=null){

        if (!Auth::check() ) {
            return view('common.generic')
                ->with('message_type','error')
                ->with('message','Please login to access');
        }

        if(is_null($uid)){
            $user_id = Auth::id();
        } else {
            $user_id = $uid;
        }


        $merchant_id= DB::table('merchant')->
        where('user_id',$user_id)->pluck('id');

        $since = DB::table('merchant')->
                    where('user_id',$user_id)->
                    orderBY('created_at','ASC')->pluck('created_at');

        if(is_null($since)){
            $since = date("d-M-Y",strtotime('-2 year',  date("Y-m-d")));
        } else {
            $since = date("d-M-Y", strtotime($since));
        }

        return view('merchant.productsales',compact('since'));
    }

    public function creditProductSales($uid = null)
    {

        if (!Auth::check() ) {
            return view('common.generic')
                ->with('message_type','error')
                ->with('message','Please login to access');
        }

        if(!isset($uid)){
            $user_id = Auth::id();
        } else {
            $user_id = $uid;
        }

        $since = DB::table('merchant')
                    ->where('user_id',$user_id)
                    ->orderBY('created_at','ASC')
                    ->pluck('created_at');

        if(is_null($since)){
            $since = date("d-M-Y",strtotime('-2 year'));
        } else {
            $since = date("d-M-Y", strtotime($since));
        }

        $productsales = DB::table('orderproduct as op')
			->join('porder as po','op.porder_id','=','po.id')
			->where('po.user_id',$user_id)
			->select('op.*')
			->whereDate('op.created_at','>',date('Y-m-d',strtotime($since)))
			->get();


        return view('merchant.creditproductsales',compact('since','uid'));
    }

    public function skulist(Request $request)
    {
		Log::debug('***** skulist() *****');

        $TimeFilter = $request->input('TimeFilter') ?: 'CUSTOM';
        $where = '';

        $from = date('Y-m-d 00:00:00');
        $to   = date('Y-m-d H:i:s');
        if($TimeFilter == 'YTD'){
            $from = date('Y-01-01 00:00:00');
        }else if($TimeFilter == 'MTD'){
            $from = date('Y-m-01 00:00:00');
        }else if($TimeFilter == 'WTD'){
            $from = (date('D') != 'Mon') ? date('Y-m-d 00:00:00', strtotime('last Monday')) : date('Y-m-d 00:00:00');
            $weekDay = (date('D') != 'Mon') ? date('Y-m-d 00:00:00', strtotime('last Monday')) : date('Y-m-d 00:00:00');
        }else if($TimeFilter == 'today'){
            $from = (date('D') != 'Mon') ? date('Y-m-d 00:00:00', strtotime('last Monday')) : date('Y-m-d 00:00:00');
        }else if($TimeFilter == 'CUSTOM'){
            $from = $request->from ? date('Y-m-d 00:00:00',strtotime($request->from)) : $from;
            $to   = $request->to ? date('Y-m-d 23:59:59',strtotime($request->date)) : $to;
        }
        else if($TimeFilter === 'Since'){
            $from = date('Y-01-01 00:00:00', 0);
            $to   = date('Y-m-d H:i:s');
        }

        $user_id  = $request->user_id ?: Auth::user()->id;
        $merchant = Merchant::where('user_id',$user_id)->first();
        $merchant_id = $merchant->id;

        $filter = $TimeFilter === 'CUSTOM' ? date('d-M-Y',strtotime($from))." - ".date('d-M-Y',strtotime($to)) : $TimeFilter;

		Log::debug('filter     ='.$filter);
		Log::debug('from       ='.$from);
		Log::debug('to         ='.$to);
		Log::debug('merchant_id='.$merchant_id);

        $subquery  = "
		SELECT
			product.name as name,
			product.thumb_photo as image,
			product.parent_id as product_id,
			count(orderproduct.product_id) as ordercount,
			CAST(SUM(IF(orderproduct.created_at BETWEEN
				'$from' AND '$to',
				(orderproduct.order_price*orderproduct.quantity/100), 0))
				AS DECIMAL(10,2)) AS sales1,
			CAST((SUM(orderproduct.quantity)) AS DECIMAL(10,2))
				as sales_quantity,
			porder.user_id,
			IFNULL(DATE(orderproduct.created_at),NOW()) as date,
			usr.email as email,
			porder.status
		FROM
			product 
			LEFT JOIN merchantproduct as mp ON product.parent_id = mp.product_id
			LEFT JOIN orderproduct on product.id = orderproduct.product_id
			JOIN porder as porder on orderproduct.porder_id = porder.id
			LEFT JOIN users as usr on usr.id = porder.staff_user_id
		WHERE                            
			mp.merchant_id = ${merchant_id}  
			AND mp.deleted_at IS NULL
			AND product.deleted_at IS NULL
			AND product.status != 'transferred'
			AND product.status != 'deleted'
			AND product.status != ''
		GROUP BY
			product_id
		ORDER BY
			sales1 desc";

        $totalsales = DB::select(DB::raw("
		SELECT
			product.name as name,
			product.thumb_photo as image,
			product.id as proId,
			np.nproduct_id AS npid,
			product_sales.sales1,
			product_sales.sales_quantity,
			product_sales.user_id,
			product_sales.DATE,
			product_sales.email,
			product_sales.status,
			'${filter}' as date
		FROM
			product
			INNER JOIN nproductid AS np ON np.product_id = product.id
			INNER JOIN merchantproduct as mp ON product.id = mp.product_id
			INNER JOIN merchant AS m ON mp.merchant_id = m.id
			LEFT JOIN (
			   ${subquery}
			) as product_sales ON product.id = product_sales.product_id
		WHERE                            
			m.id =  ${merchant_id} 
			AND mp.deleted_at IS NULL
			AND product.deleted_at IS NULL
			AND product.status != 'transferred'
			AND product.status != 'deleted'
			AND product.status != ''
		GROUP BY
			product.id
		ORDER BY
			sales1 desc
		"));    

		Log::debug($totalsales);
        $max = count($totalsales) ?  $totalsales[0]->sales1 : 0;
        $res = array_map(function($item)use($max){
                 $item->max = $max;
                 $item->sales1 = number_format($item->sales1,2,'.','');
                 return $item;
        }, $totalsales);

		return $res;
    }

    public function default_products($merchant){
        $products = $merchant->products()
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
                product.name as pname,
                product.thumb_photo as image'))
            ->where("product.status","!=","transferred")
            ->where("product.status","!=","deleted")
            ->where("product.status","!=","")
            ->groupBy('product.id')
            ->get();

        return $products;
    }

    private function salesSubQuery($merchant_id)
    {
        $subquery = DB::table('product')
                      ->leftJoin('merchantproduct as mp','product.parent_id', '=', 'mp.product_id')
                      ->leftJoin('orderproduct','product.id', '=', 'orderproduct.product_id')
                      ->join('porder as porder', 'orderproduct.porder_id' ,'=' ,'porder.id')
                      ->leftJoin('users as usr', 'usr.id' ,'=' ,'porder.staff_user_id')
                      ->leftJoin('locationproduct AS lp', 'product.parent_id' ,'=' ,'lp.product_id')
                      ->leftJoin('fairlocation as loc', 'lp.location_id' ,'=' ,'loc.id')
                      ->leftJoin('opos_locationterminal', 'loc.id' ,'=' ,'opos_locationterminal.location_id')
                      ->leftJoin('opos_terminal', 'opos_locationterminal.terminal_id' ,'=' ,'opos_terminal.id')
                      ->where('mp.merchant_id' , $merchant_id)
                      ->whereNull('mp.deleted_at')
                      ->whereNull('product.deleted_at')
                      ->where('product.status', '!=' , 'transferred')
                      ->where('product.status', '!=', 'deleted')
                      ->where('product.status', '!=', '')
                      ->select([
                        'product.name as name',
                        'product.thumb_photo as image',
                        'product.parent_id as product_id',
                        DB::raw('count(orderproduct.product_id) as ordercount'),
                        DB::raw('CAST(SUM(IF(orderproduct.created_at BETWEEN opos_terminal.start_work AND NOW(), (orderproduct.order_price*orderproduct.quantity/100), 0)) AS DECIMAL(10,2)) AS sales1'),
                        DB::raw('CAST((SUM(orderproduct.quantity)) AS DECIMAL(10,2)) as sales_quantity'),
                        'porder.user_id',
                        DB::raw('IFNULL(DATE(orderproduct.created_at),NOW()) as date'),
                        'usr.email as email',
                        'porder.status'
                    ])
                    ->groupBy('product_id');
          return $subquery->toSql();  
    }
}


