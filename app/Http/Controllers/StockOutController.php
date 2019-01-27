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
class StockOutController extends Controller{

        public function stockout_default(){
      //  Log::debug("Triggered Stock default");
        $user_id= Auth::user()->id;
        $date = Carbon::now();
        //first i have to get date of first stock report
        $first_ = DB::table('stockreport')->join
        ('stockreportproduct','stockreport.id','=','stockreportproduct.stockreport_id')->join
        ('company','company.id','=','stockreport.creator_company_id')->where
        ('company.owner_user_id', $user_id)->select('stockreport.created_at')->first();
          //  dd($first->created_at);
        if($first_){
//            $first =  Carbon::createFromFormat('Y-m-d H:i:s',
//                $first_->created_at);
            $first = $date->subdays(1);
            $days_count = ($first->diffInDays($date));
            $days = [];
            $days[] = $first->format('Y-m-d');
            for ($i = 0; $i <= $days_count; $i++){

                $days[] = $first->addDays(1)->format('Y-m-d');
            }
          //  dd($first_->created_at);
        $result = [];
           foreach ($days as $d){
            $d_start = $d." 00:00:00";
               $d_end = $d." 23:59:59";
               $stocks = DB::select(DB::raw("
              SELECT
               sr.id,
              sr.mode,
              sr.created_at as DATE,
              srp.product_id as proId,
             SUM((srp.quantity * (p.retail_price/100))) as quantity
              
              FROM
              stockreport sr
              JOIN stockreportproduct srp on srp.stockreport_id=sr.id
              JOIN company c on c.id = sr.creator_company_id
              JOIN product p on p.id = srp.product_id
              WHERE
                      sr.ttype = 'tout' AND
                      sr.status = 'confirmed' AND
                      c.owner_user_id = $user_id AND
                      sr.created_at BETWEEN '$d_start' AND '$d_end';
              
        "));
        $stocks[0]->date = $d;
               if(!$stocks[0]->quantity){
                   $stocks[0]->quantity = 0;
               }

               $result[] = $stocks;

           }
          // dd($result);
         $data = array();
            foreach ($result as $key => $row) {

                $data[$key]['mode'] = $row[0]->mode;
                $data[$key]['date'] =   $row[0]->date;
                $data[$key]['quantity'] = $row[0]->quantity;

            }

           return $data ;

        }else{
            return 0;
        }
    }

        public function stockout_today(Request $request){
        $user_id= Auth::user()->id;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $mode = $request['mode'];
        $start_date = Carbon::createFromFormat('d-M-Y H:i:s',
            $start_date.' 00:00:00');
        $end_date = Carbon::createFromFormat('d-M-Y H:i:s',
            $end_date.' 23:59:59');

        $difference = $start_date->diffInDays($end_date, false);

        if($difference >= 0) {

            Log::debug("Difference between the dates " . $difference);
            $days = [];
            $days[] = $start_date->format('Y-m-d');
            for ($i = 0; $i <= $difference; $i++) {

                $days[] = $start_date->addDays(1)->format('Y-m-d');
            }
            //  dd($first_->created_at);
            $result = [];
            $others = [];
            $i = 0;
            foreach ($days as $d) {

                $d_start = $d . " 00:00:00";
                $d_end = $d . " 23:59:59";
                $stocks = DB::select(DB::raw("
              SELECT
               sr.id,
              sr.mode,
              sr.created_at as DATE,
              srp.product_id as proId,
             SUM((srp.quantity * (p.retail_price/100))) as quantity
            
              
              FROM
              stockreport sr
              JOIN stockreportproduct srp on srp.stockreport_id=sr.id
              JOIN company c on c.id = sr.creator_company_id
              JOIN product p on p.id = srp.product_id
              WHERE
                      sr.ttype = 'tout' AND
                      sr.mode = '$mode' AND
                      sr.status = 'confirmed' AND
                      c.owner_user_id = $user_id AND
                      sr.created_at BETWEEN '$d_start' AND '$d_end'
                       GROUP BY proId;
                     
              
        "));

                if ($stocks) {
                    $stocks[0]->date = $d;
                    $result[] = $stocks;
                    Log::debug("Stocks ".$stocks[0]->quantity);
                    Log::debug("Date ".$stocks[0]->date);
            }else{

                    $others[0] = new \stdClass();
                    $others[0]->date = $d;
                    $others[0]->quantity = 0;
                    $others[0]->mode = $mode;
                    $result[] = $others;
                }


            }
           Log::debug("Results ");
            foreach ($result as $r){
                Log::debug("Quantity" .$r[0]->quantity);
                Log::debug("Date" .$r[0]->date);
            }
            Log::debug("Results End ");
            $data = array();

            foreach ($result as $key => $row) {

                //   dd($row[0]->created_at);
                $data[$key]['mode'] = $row[0]->mode;
                $data[$key]['date'] = $row[0]->date;
                $data[$key]['quantity'] = $row[0]->quantity;
                Log::debug("Quantity" .$row[0]->quantity);
                Log::debug("Date" .$row[0]->date);
            }

            return $data ;

        }else{
            return 0;
        }
        }


        public function stockout_details($uid=null){
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

        return view('merchant.stockoutdetails',compact('since'));
    }

        public function stockout_since(Request $request)
        {
            $TimeFilter = $request->input('TimeFilter');
            $where = '';

            if($TimeFilter == 'YTD'){
                $where = " AND sr.created_at BETWEEN '".date('Y-01-01 00:00:00')."' AND '".date('Y-m-d H:i:s')."'";

            }else if($TimeFilter == 'MTD'){
                $where = " AND sr.created_at BETWEEN '".date('Y-m-01 00:00:00')."' AND '".date('Y-m-d H:i:s')."'";

            }else if($TimeFilter == 'WTD'){
                $weekDay = (date('D') != 'Mon') ? date('Y-m-d 00:00:00', strtotime('last Monday')) : date('Y-m-d 00:00:00');
                $where = " AND sr.created_at BETWEEN '".$weekDay."' AND '".date('Y-m-d H:i:s')."'";
            }else if($TimeFilter == 'today'){
                $where =  " AND sr.created_at BETWEEN '".date('Y-m-d 00:00:00')."' AND '".date('Y-m-d H:i:s')."'";
            }

            $user_id     = Auth::user()->id;
            $merchant = Merchant::where('user_id','=',$user_id)->first();

            $product = $this->default_products($merchant);

            $stock = DB::select(DB::raw("
				SELECT
              sr.id,
              sr.mode,
              sr.created_at as DATE,
              srp.product_id as proId,
             ((srp.quantity * (p.retail_price/100))) as sales,
             srp.quantity as quantity
            
              
              FROM
              stockreport sr
              JOIN stockreportproduct srp on srp.stockreport_id=sr.id
              JOIN company c on c.id = sr.creator_company_id
              JOIN product p on p.id = srp.product_id
              WHERE
                      sr.ttype = 'tout' AND
                      sr.status = 'confirmed' AND
                      c.owner_user_id = $user_id $where
                      GROUP BY proId
                      ;
        "));
//Log::debug($stock);
            $max = 0;
            foreach ($product as $p){
                $p->sales = 0;
                $p->pname = $p->name;
                $p->image = $p->thumb_photo;
                $p->sales_quantity = 0;
                $p->DATE = Carbon::now();
                foreach ($stock as $t){
                    if($p->id == $t->proId){
                        $p->sales = $t->sales;
                        $p->DATE = $t->DATE;
                        $p->sales_quantity = $t->quantity;
                        if($p->sales > $max){
                            $max = $p->sales;
                        }
                    }
                }
            }




            $sum = 0;
            foreach ($stock as $key => $values) {
                $sum += $values->sales;
            }

            $sales = array();
            if(empty($TimeFilter)){
                $TimeFilter = 'Since';
                Log::debug("Yes");
            }
            foreach ($product as $key => $row) {

                $sales[$key]['name'] = $row->pname;
                $sales[$key]['image'] = $row->image;
                $sales[$key]['proId'] = $row->id;
                $sales[$key]['salesall'] = $sum;
                $sales[$key]['max'] = $max;
                $sales[$key]['sales'] = number_format($row->sales,2);
                $sales[$key]['sales1'] = $row->sales;
                $sales[$key]['sales_quantity'] = $row->sales_quantity;
                $sales[$key]['date'] = $TimeFilter;
                $sales[$key]['npid'] = $row->npid;

            }
            Log::debug(count($sales));
            if(!empty($sales)) {
                return $sales;
            } else {
                return 0;
            }
        }
        public function stockout_range(Request $request){

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
        $stock = DB::select(DB::raw("
				 SELECT
              sr.id,
              sr.mode,
              sr.created_at as DATE,
              srp.product_id as proId,
             ((srp.quantity * (p.retail_price/100))) as sales,
              srp.quantity as quantity
              
              FROM
              stockreport sr
              JOIN stockreportproduct srp on srp.stockreport_id=sr.id
              JOIN company c on c.id = sr.creator_company_id
              JOIN product p on p.id = srp.product_id
              WHERE
                      sr.ttype = 'tout' AND
                      sr.status = 'confirmed' AND
                      c.owner_user_id = $user_id AND
                      sr.created_at BETWEEN '$from' AND '$to'
                      GROUP BY proId;
        "));
        $max = 0;
        foreach ($product as $p){
            $p->sales = 0;
            $p->pname = $p->name;
            $p->image = $p->thumb_photo;
            $p->sales_quantity = 0;
            $p->DATE = Carbon::now();
            foreach ($stock as $t){
                if($p->id == $t->proId){
                    $p->sales = $t->sales;
                    $p->DATE = $t->DATE;
                    $p->sales_quantity = $t->quantity;
                    if($p->sales > $max){
                        $max = $p->sales;
                    }
                }
            }
        }




        $sum = 0;
        foreach ($stock as $key => $values) {
            $sum +=$values->sales;
        }

        $sales = array();
        foreach ($product as $key => $row) {

            $sales[$key]['name'] = $row->pname;
            $sales[$key]['image'] = $row->image;
            $sales[$key]['proId'] = $row->id;
            $sales[$key]['salesall'] = $sum;
            $sales[$key]['max'] = $max;
            $sales[$key]['sales1'] = $row->sales;
            $sales[$key]['sales'] = number_format($row->sales,2);
            $sales[$key]['sales_quantity'] = $row->sales_quantity;
            $sales[$key]['date'] = $rfrom . " to ". $rto;
            $sales[$key]['npid'] = $row->npid;

        }
        Log::debug(count($sales));
        if(!empty($sales)) {
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