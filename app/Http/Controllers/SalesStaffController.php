<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Cart;
use App\Http\Requests;
use App\Models\Address;
use App\Models\CtlShip;
use App\Models\Logistic;
use App\Models\Delivery;
use App\Models\QR;
use App\Models\Currency;
use App\Models\Country;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Merchant;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SalesStaff;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\OpenWishController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\CityLinkController as CL;
use App\Http\Controllers\LogisticsController;
use App\Classes\SecurityIDGenerator;
use App\Models\Product;
use App\Models\Buyer;
use App\Models\POrder;
use App\Models\Discount;
use App\Models\DiscountBuyer;
use App\Models\Voucher;
use App\Models\MerchantProduct;
use App\Models\Owarehouse_pledge;
use App\Models\Owarehouse;
use App\Models\User;
use App\Models\Globals;
use App\Http\Controllers\IdController;
use File;
use URL;
// use App\Http\Classes\CityLinkConnection as CL;
use Auth;
use DB;
use Carbon;
use Input;
use QrCode;
use Storage;
class SalesStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $staff = SalesStaff::all();
        $users = User::all();
        $merchants = Merchant::all();
        return view("sales_staff.index",[
            'salesStaff' => $staff,
            'users' =>$users,
            'merchants'=>$merchants
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_is_merchant=False;
        // Check if user is a merchant
        $m= DB::table('merchant')->where('user_id',$request->get('user_id'))->first();
        if (!is_null($m)) {
            $user_is_merchant=True;
        }
        $staff = new SalesStaff();
        $staff->user_id = $request->get('user_id');
        $staff->type = $request->get('type');
        $staff->target_merchant = $request->get('target_merchant');
        $staff->target_revenue = $request->get('target_revenue');
        $commission= $request->get('commission');
        if ($user_is_merchant==True) {
            $commission=0;
        }
        $staff->commission = $commission;
        $staff->bonus = $request->get('bonus');
        $staff->save();
        return json_encode($staff);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = SalesStaff::find($id);
        return json_encode($staff);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $staff = SalesStaff::find($id);
        $staff->user_id = $request->get('user_id');
        $staff->type = $request->get('type');
        $staff->target_merchant = $request->get('target_merchant');
        $staff->target_revenue = $request->get('target_revenue');
        $staff->commission = $request->get('commission');
        $staff->bonus = $request->get('bonus');
        $staff->save();
        return json_encode($staff);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = SalesStaff::find($id);
        $staff->delete();
        return json_encode(array('message'=>true));
    }


    public function staffsales($uid = null){
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

        return view('merchant.staffsales',compact('since'));
    }


    public function staffsale(){
        $user_id     = Auth::user()->id;

        /* This is NOT admin friendly,and will crap out in admin mode.
         * $merchant=null because $user_id is NOT $merchant.user_id */
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $date = Carbon::now()->toDateTimeString();

        //$date = Carbon::createFromFormat('m/d/Y', $date)->toDateTimeString();
        //
        Log::debug("******* Today:Date ********");
        Log::debug($date);
        Log::debug($merchant->id);
        //dd($merchant->id);

        $from = date('Y-m-d 00:00:00',0);
        $to   = date('Y-m-d H:i:s');


        $staff_sales = DB::table('opos_receiptproduct')->
            leftJoin('hcap_productcomm', 'opos_receiptproduct.product_id', '=',
                'hcap_productcomm.product_id')->
            leftjoin('member','hcap_productcomm.sales_member_id','=','member.id')->
            leftjoin('users','member.user_id','=','users.id')->
            join('product','product.id', '=', 'opos_receiptproduct.product_id')->
            join('merchantproduct as mp','mp.product_id','=','product.parent_id')->
            join('merchant as m','mp.merchant_id','=','m.id')->
            where('mp.merchant_id', $merchant->id)->
            select('users.id', 'users.first_name','users.username','users.name',
                'users.avatar as image','opos_receiptproduct.price','hcap_productcomm.commission_amt',
                'opos_receiptproduct.quantity')->
            where('opos_receiptproduct.created_at', '<=', $date)->
            // whereNotNull('users.id')->
            groupBy('users.id')->
            get();

        $merchant_id = $merchant->id;
        $staff_sales = DB::select(DB::raw("
            SELECT
            member.id,
            member.user_id,
            IF((ISNULL(users.first_name) || users.first_name = '') &&
            (ISNULL(users.last_name) || users.last_name = ''),
            SUBSTRING_INDEX(users.email, '@', 1),
            concat(users.first_name, ' ', users.last_name)) AS name,
            nstaff.nickname,
            users.avatar          AS image,
            users.id              AS user_id,
            IFNULL(sales, 0)      AS sales,
            IFNULL(sales, 0)      AS total,
            MAX(IFNULL(sales, 0)) AS max,
            staff_id
            FROM `member`
            LEFT JOIN `users` ON `users`.`id` = `member`.`user_id`
            LEFT JOIN `nstaff` ON `nstaff`.`member_id` = `member`.`id`
            INNER JOIN `company` ON `member`.`company_id` = `company`.`id`
            LEFT JOIN (
              SELECT
                usr.id                                                        AS staff_id,
                CAST((SUM(`opos_receiptproduct`.`price` * `opos_receiptproduct`.`quantity`) -
                     SUM(`opos_saleslog`.`commission_amt`))/100 AS DECIMAL(10, 2)) AS sales,
                SUM(`opos_receiptproduct`.`quantity`)  AS sales_quantity
              FROM `opos_receipt`
                JOIN `opos_receiptproduct` ON `opos_receipt`.`id` = `opos_receiptproduct`.`receipt_id`
                JOIN `hcap_productcomm` ON `opos_receiptproduct`.`product_id` = `hcap_productcomm`.`product_id`
                JOIN `opos_saleslog` ON `opos_receiptproduct`.`id` = `opos_saleslog`.`receiptproduct_id`
                JOIN `member` ON `hcap_productcomm`.`sales_member_id` = `member`.`id`
                JOIN `users` AS usr ON `member`.`user_id` = `usr`.`id`
              WHERE usr.id = $user_id
              GROUP BY usr.id
            ) AS staff_sales ON users.id = staff_sales.staff_id
            WHERE `company`.`owner_user_id` = $user_id
            AND `member`.`type` = 'member'
            AND `member`.`status` = 'active'
            AND users.id <> 0
            GROUP BY users.id
            ORDER BY `sales` DESC;
            "));
        return  $staff_sales;



        Log::debug('***** Staff Sales *****');
        Log::debug($staff_sales);

        $staffs = $this->all_staffs();
        $max = 0;
        if(!empty($staffs)){
            foreach ($staffs as $s){
                $s->sales = 0;
                $s->total = number_format($s->sales/100, 2);
                $s->name = $s->first_name;
                if(!empty($staff_sales)){
                    foreach ($staff_sales as $ss){
                        if($s->id == $ss->id){
                            $s->sales = ($ss->price * $ss->quantity)  - $ss->commission_amt;
                            $s->total = number_format($s->sales/ 100, 2);
                            if($s->sales > $max){
                                $max = $s->sales;
                            }
                        }

                    }
                }

            }
            foreach ($staffs as $s){
                $s->max = $max;
            }
            return $staffs;

        }else{
            return 0;
        }
    }


    public function staffsaleYtd(){
        Log::debug('***** staffsaleYtd() *****');
        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $from =  Carbon::now()->startOfYear()->toDateString()." 00:00:00";
        $to = Carbon::now()->toDateString()." 23:59:59";
        Log::debug('from='.$from);
        Log::debug('to  ='.$to);
        //dd($merchant->id);

        $staffs = $this->all_staffs();
        $staff_sales = $this->sales($merchant,$from,$to);
        $max = 0;
        if(!empty($staffs)){
            foreach ($staffs as $s){
                $s->sales = 0;
                $s->total = number_format($s->sales/100, 2);
                $s->name = $s->first_name;
                if(!empty($staff_sales)){
                    foreach ($staff_sales as $ss){
                        if($s->id == $ss->id){
                            $ss->sales = ($ss->price * $ss->quantity)  - $ss->commission_amt;
                            $ss->total = number_format($ss->sales/ 100, 2);
                            if($s->sales > $max){
                                $max = $s->sales;
                            }
                        }

                    }
                }

            }
            foreach ($staffs as $s){
                $s->max = $max;
            }

            return $staffs;

        }else{
            return 0;
        }
    }


    public function staffsaleMtd(){
        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $from =  Carbon::now()->startOfMonth()->toDateString();
        $to = Carbon::now()->toDateString();
        //dd($merchant->id);

        $staffs = $this->all_staffs();
        $staff_sales = $this->sales($merchant,$from,$to);
        $max = 0;
        if(!empty($staffs)){
            foreach ($staffs as $s){
                $s->sales = 0;
                $s->total = number_format($s->sales/100, 2);
                $s->name = $s->first_name;
                if(!empty($staff_sales)){
                    foreach ($staff_sales as $ss){
                        if($s->id == $ss->id){
                            $ss->sales = ($ss->price * $ss->quantity)  - $ss->commission_amt;
                            $ss->total = number_format($ss->sales/ 100, 2);
                            if($s->sales > $max){
                                $max = $s->sales;
                            }
                        }

                    }
                }

            }
            foreach ($staffs as $s){
                $s->max = $max;
            }

            return $staffs;

        }else{
            return 0;
        }
    }


    public function staffsaleWtd(){
        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $from =  Carbon::now()->startOfWeek()->toDateString();
        $to = Carbon::now()->toDateString();
        //dd($merchant->id);

        $staffs = $this->all_staffs();
        $staff_sales = $this->sales($merchant,$from,$to);
        $max = 0;
        if(!empty($staffs)){
            foreach ($staffs as $s){
                $s->sales = 0;
                $s->total = number_format($s->sales/100, 2);
                $s->name = $s->first_name;
                if(!empty($staff_sales)){
                    foreach ($staff_sales as $ss){
                        if($s->id == $ss->id){
                            $ss->sales = ($ss->price * $ss->quantity)  - $ss->commission_amt;
                            $ss->total = number_format($ss->sales/ 100, 2);
                            if($s->sales > $max){
                                $max = $s->sales;
                            }
                        }

                    }
                }

            }
            foreach ($staffs as $s){
                $s->max = $max;
            }

            return $staffs;

        }else{
            return 0;
        }
    }


    public function staffsaletoday(Request $request){
        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $to = $request['date'];
        $from = $request['from'];
        $to = Carbon::createFromFormat('d-M-Y H:i:s',
            $to.' 23:59:59');
        $from = Carbon::createFromFormat('d-M-Y H:i:s',
            $from.' 00:00:00');
        $difference = $from->diffInDays($to, false);
        //Log::debug("The difference between ". $from." and ". $to ." is ".$difference);
        //dd($merchant->id);
        if($difference >= 0) {
            $staffs = $this->all_staffs();
            $staff_sales = $this->sales($merchant,$from,$to);
            $max = 0;
            if(!empty($staffs)){
                foreach ($staffs as $s){
                    $s->sales = 0;
                    $s->total = number_format($s->sales/100, 2);
                    $s->name = $s->first_name;
                    if(!empty($staff_sales)){
                        foreach ($staff_sales as $ss){
                            if($s->id == $ss->id){
                                $ss->sales = ($ss->price * $ss->quantity) - $ss->commission_amt;
                                $ss->total = number_format($ss->sales/ 100, 2);
                                if($s->sales > $max){
                                    $max = $s->sales;
                                }
                            }

                        }
                    }

                }
                foreach ($staffs as $s){
                    $s->max = $max;
                }

                return $staffs;

            }else{
                return 0;
            }

        } else {
            return 5;
        }
    }


    public function all_staffs(){
        $user_id     = Auth::user()->id;

        $merchant = Merchant::where('user_id','=',$user_id)->first();
		$company = DB::table('company')->
			where('owner_user_id','=',$user_id)->first();

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
			select('u.id','u.first_name','u.avatar as image','u.email','u.username')->
			orderBy('u.first_name')->
            get();
        foreach ($staffs as $s){
            if(empty($s->first_name)){
                $first_name = explode('@',$s->email);
                $s->first_name = $first_name[0];
            }
        }

		Log::debug('***** all_staffs() *****');
		Log::debug($merchant->user_id);
		Log::debug($staffs);

        return $staffs;
    }


    public function sales($merchant,$from,$to){
		$staff_sales = DB::table('opos_receiptproduct')->
			join('hcap_productcomm', 'opos_receiptproduct.product_id', '=',
				'hcap_productcomm.product_id')->
			join('member', 'hcap_productcomm.sales_member_id', '=',
				'member.id')->
			leftjoin('users','member.user_id','=','users.id')->
			join('product', 'product.id', '=',
				'opos_receiptproduct.product_id')->
			join('merchantproduct as mp', 'mp.product_id', '=',
				'product.parent_id')->
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
