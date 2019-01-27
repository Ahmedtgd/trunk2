<?php /** * Created by PhpStorm.  * User: Chris Uzor * Date: 11/10/2018
 * Time: 23:14
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

class ProductQuantityController extends Controller{

    public function productsqty($uid=null){

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
        return view('merchant.productsquantity',compact('since'));
    }

    public function skulist_since(Request $request)
    {
        $TimeFilter = $request->input('TimeFilter');
        $where = '';
        Log::debug("Time Filter" .$TimeFilter);
        if($TimeFilter == 'YTD'){
            $where = " AND opos_receiptproduct.created_at BETWEEN '".date('Y-01-01 00:00:00')."' AND '".date('Y-m-d H:i:s')."'";

        }else if($TimeFilter == 'MTD'){
            $where = " AND opos_receiptproduct.created_at BETWEEN '".date('Y-m-01 00:00:00')."' AND '".date('Y-m-d H:i:s')."'";

        }else if($TimeFilter == 'WTD'){
            $weekDay = (date('D') != 'Mon') ? date('Y-m-d 00:00:00', strtotime('last Monday')) : date('Y-m-d 00:00:00');
            $where = " AND opos_receiptproduct.created_at BETWEEN '".$weekDay."' AND '".date('Y-m-d H:i:s')."'";
        }else if($TimeFilter == 'today'){
            $where =  " AND opos_receiptproduct.created_at BETWEEN '".date('Y-m-d 00:00:00')."' AND '".date('Y-m-d H:i:s')."'";
        }

        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
       $product = $this->default_products($merchant);
     //   dd($products_initial);

        $totalsales = DB::select(DB::raw("
				SELECT
				    count(opos_receiptproduct.product_id) as ordercount,
				    -- format(SUM((opos_receiptproduct.price*opos_receiptproduct.quantity*(1 - (opos_receiptproduct.discount/100))))/100,2) as sales,
				   SUM((opos_receiptproduct.price*opos_receiptproduct.quantity*(1 - (opos_receiptproduct.discount/100)))) as sales,
				    SUM((opos_receiptproduct.quantity)) as sales_quantity,
				    ops.staff_user_id,
				    product.thumb_photo as image,
				    product.name as pname,
				    product.id as proId,
				    DATE(opos_receiptproduct.created_at) as DATE,
				    usr.email
				FROM
				       opos_receiptproduct
				    JOIN opos_receipt as ops on ops.id = opos_receiptproduct.receipt_id
				    JOIN users as usr on usr.id= ops.staff_user_id
				    JOIN product on product.id = opos_receiptproduct.product_id
				    JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE
					mp.merchant_id = ".$merchant['id']." ".$where." AND
				    product.status != 'transferred' AND
				     product.status != 'deleted' AND
				      product.status != '' AND
				      ops.status = 'completed'
				GROUP BY
				    product.id
				order by sales desc;
        "));

        $max = 0;
        foreach ($product as $p){

            $p->sales = 0;
            $p->pname = $p->name;
            $p->image = $p->thumb_photo;
            $p->sales_quantity = 0;
            $p->DATE = Carbon::now();
            foreach ($totalsales as $t){
                if($p->id == $t->proId){
                    $p->sales = $t->sales;
                    $p->DATE = $t->DATE;
                    $p->sales_quantity = $t->sales_quantity;

                    if($p->sales_quantity > $max){
                        $max = $p->sales_quantity;
                    }
                }
            }
        }




        $sum = 0;
        foreach ($totalsales as $key => $values) {
            $sum +=$values->sales_quantity;
        }

        $sales = array();
        Log::debug("TimeFilter " .$TimeFilter);
            if(empty($TimeFilter)){
                $TimeFilter = 'Since';
                Log::debug("Yes");
            }

        foreach ($product as $key => $row) {

            $sales[$key]['name'] = $row->pname;
            $sales[$key]['image'] = $row->image;
            $sales[$key]['proId'] = $row->id;
            $sales[$key]['qtyall'] = $sum;
            $sales[$key]['max'] = $max;
            $sales[$key]['sales1'] = $row->sales;
            $sales[$key]['quantity'] = number_format($row->sales_quantity);
            $sales[$key]['sales_quantity'] = $row->sales_quantity;
            $sales[$key]['date'] = $TimeFilter;
            $sales[$key]['npid'] = $row->npid;
        }
        if(!empty($sales)) {
            return $sales;
        } else {
            return 0;
        }
        }


    public function skulist_today(Request $request){

        $rto = $request['date'];
        $rfrom = $request['from'];
        $to = Carbon::createFromFormat('d-M-Y H:i:s',
            $rto.' 23:59:59');
        $from = Carbon::createFromFormat('d-M-Y H:i:s',
            $rfrom.' 00:00:00');
        $difference = $from->diffInDays($to, false);

        if($difference >= 0) {
            $user_id = Auth::user()->id;
            $merchant = Merchant::where('user_id', '=', $user_id)->first();
            $product = $this->default_products($merchant);
            $totalsales = DB::select(DB::raw("
				SELECT
				    count(opos_receiptproduct.product_id) as ordercount,
				    -- format(SUM((opos_receiptproduct.price*opos_receiptproduct.quantity*(1 - (opos_receiptproduct.discount/100))))/100,2) as sales,
				   SUM((opos_receiptproduct.price*opos_receiptproduct.quantity*(1 - (opos_receiptproduct.discount/100)))) as sales,
				    SUM((opos_receiptproduct.quantity)) as sales_quantity,
				    ops.staff_user_id,
				    product.thumb_photo as image,
				    product.name as pname,
				    opos_receiptproduct.product_id as proId,
				    DATE(opos_receiptproduct.created_at) as DATE,
				    usr.email
				FROM
				    opos_receiptproduct
				    JOIN opos_receipt as ops on ops.id = opos_receiptproduct.receipt_id
				    JOIN users as usr on usr.id= ops.staff_user_id
				    JOIN product on product.id = opos_receiptproduct.product_id
				    JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE
					mp.merchant_id = " . $merchant['id'] . " AND
					opos_receiptproduct.created_at BETWEEN '$from' AND '$to' AND
					ops.status = 'completed' 
                
				GROUP BY
				    product.id
				order by sales_quantity desc;
        "));
            $max = 0;
            foreach ($product as $p){

                $p->sales = 0;
                $p->pname = $p->name;
                $p->image = $p->thumb_photo;
                $p->sales_quantity = 0;
                $p->DATE = Carbon::now();
                foreach ($totalsales as $t){
                    if($p->id == $t->proId){
                        $p->sales = $t->sales;
                        $p->DATE = $t->DATE;
                        $p->sales_quantity = $t->sales_quantity;

                        if($p->sales_quantity > $max){
                            $max = $p->sales_quantity;
                        }
                    }
                }
            }




            $sum = 0;
            foreach ($totalsales as $key => $values) {
                $sum +=$values->sales_quantity;
            }

            $sales = array();
            foreach ($product as $key => $row) {

                $sales[$key]['name'] = $row->pname;
                $sales[$key]['image'] = $row->image;
                $sales[$key]['proId'] = $row->id;
                $sales[$key]['qtyall'] = $sum;
                $sales[$key]['max'] = $max;
                $sales[$key]['sales1'] = $row->sales;
                $sales[$key]['quantity'] = number_format($row->sales_quantity);
                $sales[$key]['sales_quantity'] = $row->sales_quantity;
                $sales[$key]['date'] = $rfrom . " to ". $rto;;
                $sales[$key]['npid'] = $row->npid;
            }
            if (!empty($sales)) {
                return $sales;
            } else {
                return 0;
            }
        }else{
            return 5;
        }

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
}
