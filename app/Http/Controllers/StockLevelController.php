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

class StockLevelController extends Controller
{
    public function stocklevel_list()
    {
        Log::debug("**** stocklevel_list() *****");
        $user_id = Auth::user()->id;
      //  $merchant = Merchant::where( 'user_id', '=', $user_id )->first();
        $date = Carbon::now();

		/*
        $products = DB::select(DB::raw("
			SELECT
				sl.id,
				sl.product_id,
				sl.quantity,
				sl.created_at,
				sl.name,
				sl.thumb_photo,
				sl.pid
			FROM (
				SELECT lp.*,p.name,p.thumb_photo,p.id as pid
				FROM
					product p,
					locationproduct lp,
					merchantproduct mp
				WHERE
					lp.product_id = p.id AND
					mp.product_id = p.parent_id AND
					mp.merchant_id = ".$merchant['id']." AND
					lp.created_at < '$date'  AND
					lp.quantity > 0
												  ORDER BY
					lp.created_at DESC
				LIMIT
					18446744073709551615
				) AS sl
			GROUP BY
				sl.product_id
			ORDER BY
				sl.quantity DESC;
        "));
		*/

        $merchant=Merchant::where("user_id",$user_id)->
			whereNull("deleted_at")->
			first();

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
            })->

            join('nproductid as np', 'np.product_id', '=', 'product.id')
            ->leftJoin('productbc','product.id','=','productbc.product_id')
            ->leftJoin('bc_management','bc_management.id','=','productbc.bc_management_id')
            ->select(DB::raw('
                product.id,
                np.nproduct_id as npid,
                product.parent_id,
                bc_management.id as bc_management_id,
                productbc.deleted_at as pbdeleted_at,
                product.name,
                product.thumb_photo'))
            ->groupBy('product.id')
            ->where("product.status","!=","transferred")
            ->where("product.status","!=","deleted")
            ->where("product.status","!=","")

            ->orderBy('product.created_at','DESC')
            ->get();

        $total = 0;
        $max = 0;

        foreach ($products as $p){
            $pr=new ProductController;
            $p->quantity = $pr->consignment($p->id,$user_id);
            $p->total = number_format($p->quantity);

            if($p->quantity > $max){
                $max = $p->quantity;
            }
        }

        foreach ($products as $p){
            $p->max = $max;
        }

		/*
        if (!empty($products)) {
            return $products;
        } else {
            return 0;
        }
		*/

        return (!empty($products)) ? $products : 0;
    }

    public function stocklevel($uid = null) {
        if (!Auth::check()) {
            return view( 'common.generic' )->
				with('message_type', 'error')->
				with('message', 'Please login to access');
        }

        if (is_null( $uid )) {
            $user_id = Auth::id();
        } else {
            $user_id = $uid;
        }

        $merchant_id = DB::table( 'merchant' )->
			where( 'user_id', $user_id )->
			pluck( 'id' );

        $since = DB::table('merchant')->
			where( 'user_id', $user_id )->
			orderBY( 'created_at', 'ASC' )->
			pluck( 'created_at' );

        if (is_null( $since )) {
            $since = date( "d-M-Y", strtotime( '-2 year', date( "Y-m-d" ) ) );
        } else {
            $since = date( "d-M-Y", strtotime( $since ) );
        }

        return view('merchant.stocklevel', compact('since'));
    }

    public function stocklevel_today(Request $request){
        $user_id = Auth::user()->id;
        $merchant = Merchant::where( 'user_id', '=', $user_id )->first();

        $date = $request['date'];
        $date = Carbon::createFromFormat('d-M-Y H:i:s',
			$date.' 23:59:59')->toDateTimeString();

        Log::debug($date);

        $products_initial = $merchant->products()
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
                product.thumb_photo,                
                product.sku'))
            /*->where('product.id',2699)*/
            // ->whereNull('bc_management.deleted_at')
            ->groupBy('product.id')

            // ->limit(2) //danger Danger , to be commented in production
            ->where("product.status","!=","transferred")
            ->where("product.status","!=","deleted")
            ->where("product.status","!=","")

            ->orderBy('product.created_at','DESC')
            ->get();

		$products=DB::select(DB::raw("

            SELECT 
                p.id,
                p.name,
                p.thumb_photo,
                lp.product_id,
                lp.quantity,
                lp.created_at

            FROM
            product p
            LEFT JOIN locationproduct lp on lp.product_id=p.id
            LEFT JOIN merchantproduct mp on mp.product_id=p.parent_id
            WHERE 
                    mp.product_id = p.parent_id AND
					mp.merchant_id = ".$merchant['id']." AND
					lp.created_at <= '$date'
					GROUP BY
				p.id
			ORDER BY
				lp.quantity DESC; 
        "));

        $max = 0;

        foreach ($products as $p){
            $pr=new ProductController;
            $p->quantity = $pr->consignment($p->id,$user_id);
            $p->total = number_format($p->quantity);

            if($p->quantity > $max){
                $max = $p->quantity;
            }
        }



        foreach ($products_initial as $pi){
            $pi->quantity = 0;
            $pi->total = number_format($pi->quantity);
            foreach ($products as $p){
                if($pi->id == $p->id) {
                    $pi->quantity = $p->quantity;
                    $pi->total = number_format($pi->quantity);
                    Log::debug($pi->quantity);
                    break;
                }
            }
        }

        foreach ($products_initial as $p){
            $p->max = $max;
		}

		/*
        if (!empty($products_initial)) {
            return $products_initial;
        } else {
            return 0;
        }
		*/
        return (!empty($products_initial)) ? $products_initial : 0;
    }
}
