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

class CashSalesController extends Controller{

    public function cash_Sales_default(Request $request)
    {
        
        $TimeFilter = $request->input('TimeFilter') ?: 'CUSTOM';

        $from = date('Y-m-d 00:00:00');
        $to   = date('Y-m-d H:i:s');
        if($TimeFilter === 'Since'){
            $from = date('Y-01-01 00:00:00',0);
            $to   = date('Y-m-d H:i:s');             
        }else if($TimeFilter == 'YTD'){
            $from = date('Y-01-01 00:00:00');
        }else if($TimeFilter == 'MTD'){
            $from = date('Y-m-01 00:00:00');
        }else if($TimeFilter == 'WTD'){
            $from = (date('D') != 'Mon') ? date('Y-m-d 00:00:00', strtotime('last Monday')) : date('Y-m-d 00:00:00');
            $weekDay = (date('D') != 'Mon') ? date('Y-m-d 00:00:00', strtotime('last Monday')) : date('Y-m-d 00:00:00');
        }else if($TimeFilter == 'today'){
            $from = (date('D') != 'Mon') ? date('Y-m-d 00:00:00', strtotime('last Monday')) : date('Y-m-d 00:00:00');
        }else if($TimeFilter == 'CUSTOM'){
            $to   = $request->to   ? date('Y-m-d 00:00:00',strtotime($request->to)) : $to;
            $from = $request->date ? date('Y-m-d 00:00:00',strtotime($request->date)) : $from;
        }

        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();

        $staffs = $this->all_staffs();

        $from = '2018-01-01';

        $totalsales = $this->cash_sales($merchant,$from,$to);

        $from = Carbon::now();
        $staffs = $this->final_cashier_sales($staffs, $totalsales,$from);
        $max = $this->maxi($totalsales);
        $sum = 0;
        foreach ($totalsales as $key => $values) {
            $sum += $values->sales;
        }

        $sales_stff = array();
        $filter = $TimeFilter === 'CUSTOM' ? date('d-M-Y',strtotime($from))." - ".date('d-M-Y',strtotime($to)) : $TimeFilter;

        foreach ($staffs as $key => $row) {

            if($row->name == ''){
                $row->name = $row->email;
            }
            Log::debug(json_encode($row));

            #$sales_stff[$key]['id'] = $row->id;
            $sales_stff[$key]['uid'] = $row->uid;
            $sales_stff[$key]['name'] = $row->name;
            $sales_stff[$key]['image'] = $row->image;
            $sales_stff[$key]['max'] = $max;
            $sales_stff[$key]['salesall'] = $sum;
            $sales_stff[$key]['sales1'] = $row->sales;
            $sales_stff[$key]['sales'] = number_format($row->sales / 100, 2);
            $sales_stff[$key]['sales_quantity'] = $row->sales_quantity;
            $sales_stff[$key]['date'] = $row->date;
            $sales_stff[$key]['TimeFilter'] = $filter;
        }
        if(!empty($sales_stff)) {
            return $sales_stff;
        } else {
            return 0;
        }

    }

    public function cash_Sales_Ytd() {
        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $startyear =  Carbon::now()->startOfYear()->toDateString();

        $current = Carbon::now()->endOfYear()->toDateString();


        $staffs = $this->all_staffs();

        // Log::debug($staffs);

        $totalsales = $this->cash_sales($merchant,$startyear,$current);
        $staffs = $this->final_cashier_sales($staffs, $totalsales,$startyear);
        $max = $this->maxi($totalsales);
        $sum = 0;
        foreach ($totalsales as $key => $values) {
            $sum +=$values->sales;
        }

        $sales_stff = array();
		foreach ($staffs as $key => $row) {
			if($row->name == ''){
				$row->name = $row->email;
			}

            $sales_stff[$key]['uid'] = $row->uid;
            $sales_stff[$key]['name'] = $row->name;
            $sales_stff[$key]['image'] = $row->image;
            $sales_stff[$key]['max'] = $max;
            $sales_stff[$key]['salesall'] = $sum;
            $sales_stff[$key]['sales1'] = $row->sales;
            $sales_stff[$key]['sales'] = number_format($row->sales / 100, 2);
            $sales_stff[$key]['sales_quantity'] = $row->sales_quantity;
            $sales_stff[$key]['date'] = $row->date;
        }

        if(!empty($sales_stff)) {
            return $sales_stff;
        } else {
            return 0;
        }
    }

    public function cash_Sales_Mtd()
    {
        $startmonth =  Carbon::now()->startOfMonth()->toDateString();
        $endmonth = Carbon::now()->endOfMonth()->toDateString();

        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();


        $staffs = $this->all_staffs();

        // Log::debug($staffs);

        $totalsales = $this->cash_sales($merchant,$startmonth,$endmonth);
        $staffs = $this->final_cashier_sales($staffs, $totalsales, $startmonth);
        $max = $this->maxi($totalsales);
        $sum = 0;
        foreach ($totalsales as $key => $values) {
            $sum +=$values->sales;
        }

        $sales_stff = array();
        foreach ($staffs as $key => $row) {
            if($row->name == ''){
                $row->name = $row->email;
            }
            $sales_stff[$key]['uid'] = $row->uid;
            $sales_stff[$key]['name'] = $row->name;
            $sales_stff[$key]['image'] = $row->image;
            $sales_stff[$key]['max'] = $max;
            $sales_stff[$key]['salesall'] = $sum;
            $sales_stff[$key]['sales1'] = $row->sales;
            $sales_stff[$key]['sales'] = number_format($row->sales / 100, 2);
            $sales_stff[$key]['sales_quantity'] = $row->sales_quantity;
            $sales_stff[$key]['date'] = $row->date;
        }

        if(!empty($sales_stff)) {
            return $sales_stff;
        } else {
            return 0;
        }
    }


    public function cash_Sales_Wtd()
    {
        $fromDate =  Carbon::now()->startOfWeek()->toDateString();
        $toDate = Carbon::now()->toDateString();
        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();

        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();


        $staffs = $this->all_staffs();

        // Log::debug($staffs);

        $totalsales = $this->cash_sales($merchant,$fromDate,$toDate);
        $staffs = $this->final_cashier_sales($staffs, $totalsales, $fromDate);
        $max = $this->maxi($totalsales);
        $sum = 0;
        foreach ($totalsales as $key => $values) {
            $sum +=$values->sales;
        }
        Log::debug($staffs);

        $sales_stff = array();
        foreach ($staffs as $key => $row)
        {
            if($row->name == ''){
                $row->name = $row->email;
            }

            //  $sales_stff[$key]['id'] = $row->id;
            $sales_stff[$key]['uid'] = $row->uid;
            $sales_stff[$key]['name'] = $row->name;
            $sales_stff[$key]['image'] = $row->image;
            $sales_stff[$key]['max'] = $max;
            $sales_stff[$key]['salesall'] = $sum;
            $sales_stff[$key]['sales1'] = $row->sales;
            $sales_stff[$key]['sales'] = number_format($row->sales / 100, 2);
            $sales_stff[$key]['sales_quantity'] = $row->sales_quantity;
            $sales_stff[$key]['date'] = $row->date;
        }

        if(!empty($sales_stff)) {
            return $sales_stff;
        } else {
            return 0;
        }
    }


    public function cash_today(Request $request)
    {
        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $to = $request['date'];
        $from = $request['from'];
        $to = Carbon::createFromFormat('d-M-Y H:i:s',
            $to.' 23:59:59');
        $from = Carbon::createFromFormat('d-M-Y H:i:s',
            $from.' 00:00:00');
        $difference = $from->diffInDays($to, false);

        if($difference >= 0) {

            $staffs = $this->all_staffs();

            // Log::debug($staffs);

            $totalsales = $this->cash_sales($merchant,$from,$to);
            $staffs = $this->final_cashier_sales($staffs, $totalsales,$from);
            $max = $this->maxi($totalsales);
            $sum = 0;
            foreach ($totalsales as $key => $values) {
                $sum += $values->sales;
            }

            $sales_stff = array();

            foreach ($staffs as $key => $row) {

                if($row->name == ''){
                    $row->name = $row->email;
                }
                Log::debug(json_encode($row));

                #$sales_stff[$key]['id'] = $row->id;
                $sales_stff[$key]['uid'] = $row->uid;
                $sales_stff[$key]['name'] = $row->name;
                $sales_stff[$key]['image'] = $row->image;
                $sales_stff[$key]['max'] = $max;
                $sales_stff[$key]['salesall'] = $sum;
                $sales_stff[$key]['sales1'] = $row->sales;
                $sales_stff[$key]['sales'] = number_format($row->sales/100,2);
                $sales_stff[$key]['sales_quantity'] = $row->sales_quantity;
                $sales_stff[$key]['date'] = $row->date;
            }

            if (!empty($sales_stff)) {
                return $sales_stff;

            } else {
                return 0;
            }
        } else {
            return 5;
        }
    }


	public function all_staffs()
	{
		$user_id = Auth::user()->id;

		$merchant = Merchant::where('user_id', '=', $user_id)->first();
		$company = DB::table('company')->
		where('owner_user_id', '=', $user_id)->first();

		$staffs = DB::table('users as u')->
			join('role_users as ru', 'ru.user_id', '=', 'u.id')->
			join('roles as r', 'r.id', '=', 'ru.role_id')->
			join('company as c', 'c.id', '=', 'ru.company_id')->
			join('member as m', 'm.user_id', '=', 'u.id')->
			where('c.owner_user_id', $merchant->user_id)->
			where('m.company_id', $company->id)->
			where('m.type', 'member')->
			whereIn('r.slug', ['mbr','opu'])->
			whereNotNull('u.id')->
			select('u.id as uid',
				'u.first_name as name',
				'u.last_name',
				'u.avatar as image',
				'u.email',
				'u.username')->
			orderBy('u.first_name')->
			groupBy('u.id')->
			get();

		foreach ($staffs as $s) {
			if (empty($s->name)) {
				$first_name = explode('@', $s->email);
				$s->name = $first_name[0];
			}else{
				$s->name = $s->name . " ". $s->last_name;
			}
		}

		return $staffs;
	}


    public function cash_sales($merchant,$from,$to){
        $totalsales = DB::select(DB::raw("
            SELECT
              count(op.product_id) as ordercount,
              SUM((op.price*op.quantity)) as sales,
              SUM((op.quantity)) as sales_quantity,
              usr.first_name as name,
              usr.avatar as image,
              usr.id as uid,
              DATE(op.created_at) as DATE
            FROM
              opos_receiptproduct as op
              LEFT JOIN salesmemoproduct as smp on smp.product_id = op.product_id
              LEFT JOIN salesmemo as sm on sm.id = smp.salesmemo_id
              JOIN opos_receipt as ops on ops.id = op.receipt_id
              JOIN users as usr on usr.id= ops.staff_user_id
              JOIN product on product.id = op.product_id 
              JOIN merchantproduct as mp on mp.product_id=product.parent_id
            WHERE
              DATE(op.created_at) BETWEEN '$from' AND '$to'
              AND mp.merchant_id = ${merchant['id']} 
              AND ops.status = 'completed'
            GROUP BY
              usr.id
		"
        ));

        return $totalsales;
    }


    public function final_cashier_sales($staffs, $totalsales, $from){

        foreach ($staffs as $staff){
            $staff->sales = 0;
            $staff->sales_quantity = 0;
            $staff->date = $from;

            foreach($totalsales as $totalsale){
                if($staff->uid == $totalsale->uid){
                    $staff->sales = $totalsale->sales;
                    $staff->sales_quantity = $totalsale->sales_quantity;
                }
            }
        }
        return $staffs;
    }


    public function maxi($staffs){
        $max = 0;
        foreach ($staffs as $staff){
            if($staff->sales > $max){
                $max = $staff->sales;
            }
        }
        return $max;
    }


    public function cashsales($uid = null){
        if (!Auth::check() ) {
            return view('common.generic')->
            with('message_type','error')->
            with('message','Please login to access');
        }

        if(is_null($uid)){
            $user_id = Auth::id();
        } else {
            $user_id = $uid;
        }

        $since = DB::table('merchant')->
        where('user_id',$user_id)->
        orderBY('created_at','ASC')->
        pluck('created_at');

        if(is_null($since)){
            $since = date("d-M-Y",strtotime('-2 year',  date("Y-m-d")));
        } else {
            $since = date("d-M-Y", strtotime($since));
        }

        return view('merchant.cashsales',compact('since'));
    }
}
