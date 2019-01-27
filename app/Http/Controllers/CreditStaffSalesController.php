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

class CreditStaffSalesController extends Controller{


    public function creditStaffSales($uid = null)
    {
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
            $since = date("d-M-Y",strtotime('-2 year'));
        } else {
            $since = date("d-M-Y", strtotime($since));
        }

        return view('merchant.creditstaffsales',compact('since'));
    }

    public function creditStaffSalesData(Request $request){

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
        /* This is NOT admin friendly,and will crap out in admin mode.
         * $merchant=null because $user_id is NOT $merchant.user_id */

        return DB::select(DB::raw("
            SELECT 
                '${filter}' as filter,
                member.id,
                member.user_id,
                IF((ISNULL(users.first_name) || users.first_name='') &&
                (ISNULL(users.last_name)     || users.last_name =''),
                SUBSTRING_INDEX(users.email, '@', 1),
                concat(users.first_name,' ',users.last_name)) as name,
                nstaff.nickname,
                users.avatar as image,
                users.id AS user_id,
                IFNULL(sales,0) as sales,
                IFNULL(sales_quantity,0) as sales_quantity,
                MAX(IFNULL(sales,0)) as max,
                staff_id
            FROM `member`
            LEFT JOIN `users` ON `users`.`id` = `member`.`user_id`
            LEFT JOIN `nstaff` ON `nstaff`.`member_id` = `member`.`id`
            INNER JOIN `company` ON `member`.`company_id` = `company`.`id`
            LEFT JOIN (
                SELECT
                    product.name as name,
                    product.thumb_photo as image,
                    product.parent_id as product_id,
                    count(orderproduct.product_id) as ordercount,
                    CAST(SUM(IF(orderproduct.created_at BETWEEN '${from}' AND '${to}',(orderproduct.order_price*orderproduct.quantity/100), 0))  AS DECIMAL(10,2)) AS sales,
                    CAST((SUM(orderproduct.quantity)) AS DECIMAL(10,2)) as sales_quantity,
                    porder.user_id,
                    porder.staff_user_id as staff_id,
                    IFNULL(DATE(orderproduct.created_at),NOW()) as DATE,
                    usr.email as email,
                    porder.status
                FROM
                    product 
                    LEFT JOIN merchantproduct as mp ON product.parent_id = mp.product_id
                    LEFT JOIN orderproduct on product.id = orderproduct.product_id
                    LEFT JOIN porder as porder on orderproduct.porder_id = porder.id
                    LEFT JOIN users as usr on usr.id = porder.staff_user_id
                WHERE             
                    mp.merchant_id = ${merchant_id} AND               
                    mp.deleted_at IS NULL
                        AND product.deleted_at IS NULL
                        AND product.status != 'transferred'
                        AND product.status != 'deleted'
                        AND product.status != ''
                    GROUP BY
                    staff_id
                    order by sales desc
            ) AS staff_sales  ON users.id =  staff_sales.staff_id
            WHERE `company`.`owner_user_id` = ${user_id}
                AND `member`.`type` = 'member'
                AND `member`.`status` = 'active'
                AND  users.id <> 0
            GROUP BY  users.id
            ORDER BY `sales` DESC;
        "));

       
    }

     public function all_staffs(){
        $user_id  = Auth::user()->id;

        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $company  = DB::table('company')->where('owner_user_id','=',$user_id)->first();

        $staffs = DB::table('users as u')->
            join('role_users as ru','ru.user_id','=','u.id')->
            join('roles as r','r.id','=','ru.role_id')->
            join('company as c','c.id','=','ru.company_id')->
            join('member as m','m.user_id','=','u.id')->
            where('c.owner_user_id',$merchant->user_id)->
            where('m.company_id',$company->id)->
            where('m.type','member')->
            where('r.slug','mbr')->
            whereNotNull('u.id')->
            select(
                'u.id',
                 DB::raw('(u.first_name  = "") || IF(ISNULL(u.first_name),
                            SUBSTRING_INDEX(u.email, "@", 1)
                            ,u.first_name) as firstName'
                        ),
                'u.avatar as image',
                'u.email',
                'u.username'
            )->
            orderBy('u.first_name')->
            get();

        Log::debug('***** all_staffs() *****');
        Log::debug($merchant->user_id);
        Log::debug($staffs);

        return $staffs;
    }

     public function sales($merchant,$from,$to){
        $staff_sales = DB::table('opos_receiptproduct')->
            join('hcap_productcomm', 'opos_receiptproduct.product_id', '=','hcap_productcomm.product_id')->
            join('member', 'hcap_productcomm.sales_member_id', '=', 'member.id')->
            leftjoin('users','member.user_id','=','users.id')->
            join('product', 'product.id', '=','opos_receiptproduct.product_id')->
            join('merchantproduct as mp', 'mp.product_id', '=', 'product.parent_id')->
            where('mp.merchant_id', $merchant->id)->
            select('users.first_name','users.username','users.name',
                'users.avatar as image','users.id',
                'opos_receiptproduct.price','opos_receiptproduct.quantity','hcap_productcomm.commission_amt')->
            whereBetween('opos_receiptproduct.created_at', [$from,$to])->
            groupBy('users.id')->
            get();

        return $staff_sales;
    }



}
