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
class MerchantDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //---__construct Method---//
    public function __construct() {
        //TODO
        //  $this->middleware('auth', ['only', 'getDashboard']);
        $this->countryModel = new Country();
        $this->paymentModel = new Payment();
        $this->merchantModel = new Merchant();
        $this->salesStaffModel = new SalesStaff();        
    }

    public function salesreport($uid = null) {
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
        $selluser = User::find($user_id);
        $merchant_id= DB::table('merchant')->
            where('user_id',$user_id)->pluck('id');
        $data['countries'] = $this->countryModel->where('code','=','MYS')->lists('name','id')->all();
        $data['merchants'] = $this->merchantModel->getAllMerchants();
        $data['products']=Product::join('merchantproduct as mp','mp.product_id','=','product.id')
            ->where('mp.merchant_id',$merchant_id)
            ->lists('product.name','product.id')->all();
       

        $data['brands'] = Brand::join('product','product.brand_id','=','brand.id')
            ->join('merchantproduct as mp','mp.product_id','=','product.parent_id')

        ->where('mp.merchant_id',$merchant_id)
        ->lists('brand.name','brand.id')->all();
        
        $data['categories'] = Category::join('product','product.category_id','=','category.id')
            ->join('merchantproduct as mp','mp.product_id','=','product.parent_id')

        ->where('mp.merchant_id',$merchant_id)
        ->lists('category.description','category.id')->all();
        
        $data['merchantConsultants'] =
            $this->salesStaffModel->getAllMerchantConsultants();    
        
      
        $channel = DB::table('fairlocation')->where('user_id', $user_id)->get();
            
        $since = DB::table('merchant')->where('user_id',$user_id)->orderBY('created_at','ASC')->pluck('created_at');
        if(is_null($since)){
            $since = date("d-M-Y",strtotime('-2 year'.date("Y-m-d")));
        } else 
        {
            $since = date("d-M-Y", strtotime($since));
        }           
    
        return view('merchant.salesreport')
            ->with('merchant_id',$merchant_id)
            ->with('since',$since)
            ->with('selluser',$selluser)
            ->with('data',$data)
            ->with('channel',$channel);       
    }   


    public function productcomms(){
        $user_id= Auth::user()->id;
        $selluser = User::find($user_id);

        return view('merchant.productcomms',compact('selluser'));
    }
 

    public function get_porder_payment($porders,$payment) {
        // dd($porders);
        $products = array();

        foreach ($porders as $order) {
            try {
                //dd($order);
                $odata = DB::table('orderproduct')->where('porder_id', $order->porder_id)->get();
               // $pdata = DB::table('product')->where('id', $odata->product_id)->first();//product detail
                $total = 0;
                foreach ($odata as $opd) {
                    $amount = ($opd->quantity * ($opd->order_price)) + $opd->order_delivery_price;
                    $total += $amount;
                }

                // return $pdata->name;


              /*  if ($pdata->subcat_level == '0') {
                    $cat2 = DB::table('category')->
                        where('id', $pdata->category_id)->pluck('name');

                } else {
                    try {
                        $table = 'subcat_level_' . $link->subcat_level;
                        $totaldata = DB::table($table)->
                            where('id', $link->subcat_id)->first();

                        $catdata = DB::table('category')->
                            where('id', $totaldata->category_id)->first();

                        $cat2 = $catdata->name;
                        $subcat2 = $totaldata->description;

                    } catch (\Exception $e) {
                        $cat2 = "Not Found";
                        $subcat2 = "Not Found";
                    }
                }*/

                /*$commission= Product::where('id',$pdata->id)->
                    pluck('osmall_commission');

                if (is_null($commission)) {
                    $m= new MerchantDashboardController;
                    $user_id= Auth::user()->id;
                    $commission= $m->get_merchant_commission($user_id);
                }*/

                $temp = array();
                $temp['total'] = $total;
                //$temp['pname'] = $pdata->name;
                $temp['oid'] = $order->porder_id; //Order ID
                //$temp['quantity'] = $odata->quantity;
                //$temp['orig_price'] = $pdata->retail_price;
                //$temp['retail_price'] = $pdata->discounted_price;
                $temp['o_rcv'] = $order->delivery_tstamp;
                $temp['o_exec'] = $order->created_at;
                $temp['uid'] = $order->user_id;
                $temp['source'] = $order->source;
               // $temp['sku'] = $pdata->id; //product id
                $temp['comm']=0;
                $temp['desc']=$order->description;

                if ($payment==true) {
                
                    $pay = DB::table('payment')->
                        where('id',$order->payment_id)->first();

                }
                $temp['payment']=$pay;
                array_push($products, $temp);

            } catch (\Exception $e) {
                echo "<script> console.log('Exception:Product not found' ); </script>";
            }
        }
        return $products;
    }

    public function index() {

        if (!Auth::check() ) {
             return view('common.generic')
            ->with('message_type','error')
            ->with('message','Please login to access the page')
            ->with('redirect_to_login',1);
        }
        
        // orderproduct.product_id=merchantproduct.product_id
        // merchantproduct.merchant_id=merchant.id
        // merchant.user_id=users.id => SELLER

        $globals=Globals::first(); 
        $user_id= Auth::user()->id;
        $merchant_id= DB::table('merchant')->
            where('user_id',$user_id)->
            pluck('id');

        $b= new BuyerController();
        $autolinks= DB::table('autolink')->
            select('autolink.id as id',
                'autolink.sproperty_id as sproperty_id',
                'autolink.linked_since as l_s',
                'autolink.status as status',
                'users.first_name as first_name',
                'users.last_name as last_name',
                'users.id as user_id',
                'buyer.photo_1 as photo_1',
                'autolink.created_at')->
            join('users','autolink.initiator','=','users.id')->
                leftJoin('buyer','buyer.user_id','=','users.id')->
                where('responder',$merchant_id)->
                where('autolink.status', '!=','unlinked')->
                where('autolink.status', '!=','')->
                orderBy('autolink.created_at','DESC')->
                distinct()->
                get();

        // dd($autolinks);
        $porders = DB::table('porder')->
            where('user_id', $user_id)->
            orderBy('porder.created_at','DESC')->get();

        $porders2= DB::table('porder')
            ->join('orderproduct', 'porder.id', '=', 'orderproduct.porder_id')
            ->join('product', 'orderproduct.product_id', '=', 'product.id')
            ->join('merchantproduct',
                'merchantproduct.product_id', '=', 'product.parent_id')
            ->join('merchant',
                'merchantproduct.merchant_id', '=', 'merchant.id')
            ->where('merchant.id', $merchant_id)
            ->where('porder.status', '!=','cancelled')
            ->whereRaw('NOT EXISTS(
                SELECT sorder.id
                FROM sorder
                WHERE sorder.porder_id = porder.id)')
            ->whereRaw('NOW() > DATE_ADD(porder.created_at,INTERVAL ' . $globals->buyer_cancellation_window . ' MINUTE)')
            ->orderBy('porder.created_at','DESC')
            ->get();

        //dd($porders2);
        // return $porders2;
        // return $autolinks;
        // Shipping
        /*  $shipping= $b->get_shipping($porders,true);
        // return $shipping;*/
        /*merchant payment details */

        $merchant_payment_details=DB::table("merchant as m")
            ->select("m.mc_sales_staff_commission as commission",
                "po.id as order_id",
                "p.receivable as receivable",
                DB::raw('sum(pro.del_pricing) as logistics'))
            ->join("merchantproduct as mp","m.id","=","mp.merchant_id")
            ->join("orderproduct as op","op.product_id","=","mp.product_id")
            ->join("porder as po","po.id","=","op.porder_id") 
            ->join("payment as p","p.id","=","po.payment_id")
            ->join("merchantsales_staff as msstf",
                "msstf.id","=","m.mc_sales_staff_id")
            ->join("product as pro","pro.id","=","op.product_id")   
            ->where("m.id",$merchant_id)
            ->orderBy('m.created_at','DESC')
            ->get();

        //return $merchant_payment_details;
        $globals=Globals::first();                        
        /*END merchant payment details */
        
        $product_orders= $b->products($porders,true);
        $product_orders2= $this->get_porder_payment($porders2,true);
        // return $product_orders2;
        $orders= array();
        $ordersb= array();

//         foreach ($product_orders as $po) {
//             $po['user_name']=Auth::user()->first_name." ".Auth::user()->last_name;
//             $rcv_date = null;
//             $due_date = null;
//             $ex=DB::table('porder')->where('id',$po['oid'])->first();
//             if(isset($ex)){
//                 $rcv_date = $ex->created_at;
//                 if($rcv_date != null and $rcv_date != ''){
//                     $date = Carbon::parse($rcv_date);
//                     $day = $date->format('d');
//                     $month = $date->format('m');
//                     $year = $date->format('Y');
//                     $day_after_seven_days = $day + 7;

//                     if ($day_after_seven_days <= 15){
//                         $due_date = Carbon::parse($year.'-'.$month.'-15')->format('dMy h:m');
//                     }else{
//                         $due_date = Carbon::parse($year.'-'.$month.'-30')->format('dMy h:m');
//                     }
//                 }else{
//                     $due_date= '';
//                 }
//                 $po['due_date'] =   $due_date;
//                 $po['rcv_date'] =   Carbon::parse($rcv_date)->format('dMy h:m');
//             }
            
// //            $po['description']= $ex->description;
//             $total= DB::table('payment')->where('id',$ex->payment_id)->pluck('receivable');
//             $po['total']=$total;
//          $po['status']=$ex->status;
//             // $po['']
//             array_push($orders, $po);

//         }

        $oid = 0;
        // return $product_orders2[0];
        foreach ($product_orders2 as $po2) {
            $rcv_date = null;
            $due_date = null;
            $ex=DB::table('porder')->where('id',$po2['oid'])->first();
            
            if(isset($ex)){
                $rcv_date = $ex->created_at;
                if($rcv_date != null and $rcv_date != ''){
                    $date = Carbon::parse($rcv_date);
                    $day = $date->format('d');
                    $month = $date->format('m');
                    $year = $date->format('Y');
                    $day_after_seven_days = $day + 7;

                    if ($day_after_seven_days <= 15){
                        $due_date = Carbon::parse($year.'-'.$month.'-15')->format('dMy h:m');
                    }else{
                        $due_date = Carbon::parse($year.'-'.$month.'-30')->format('dMy h:m');
                    }
                }else{
                    $due_date= '';
                }
                $po2['due_date'] =   $due_date;
                $po2['rcv_date'] =   Carbon::parse($rcv_date)->format('dMy h:m');
            }


//            $po['description']= $ex->description;
         //   $total= DB::table('payment')->where('id',$ex->payment_id)->pluck('receivable');
         //   $po2['total']=$total;
            $po2['status']=$ex->status;
            $po2['o_exec']=$ex->updated_at;
            // Check for return/cancel status?
            $cre=DB::table('cre')->where('porder_id',$po2['oid'])->where('status','pending')->first();
            $cre_op=null; //Orderproduct for a cre, only to be used if a return has been requested
            if (!is_null($cre)) {
                if ($cre->type=="return") {
                    #Get the porder_id and get all the subsequent products where return has been requested
                    $cre_op=DB::table('orderproduct')->where('porder_id',$cre->porder_id)->where('status','b-returning1')->get();
                    
                }
            }
            $po2['cre']=$cre;
            $po2['cre_op']=$cre_op;
            if($oid != $po2['oid']){
                $oid = $po2['oid'];

                array_push($ordersb, $po2);
            } else {            
            }
        }

        // dd($ordersb);
        //Need description and 
        // return $products;
        $o= new OpenWishController();

        $openwish= $o->get_openwish('merchant');
        // return $openwish;
       /* foreach($openwish as $o){
            $openwish_product_id = $o->product_id;
        }*/

//        dd($openwish_product_id);
        $commission= $this->get_merchant_commission($user_id);
        // return $openwish[0];
        // Vouchers
        $bank_commision=DB::table('global')->pluck('payment_gateway_commission');
         // $currency = Currency::where('active',true)->first()->code;

        // if (is_null($bank_commision)) {
        //     # code...
        //     $bank_commision=3;
        // }
        $shipping = POrder::select('porder.*','courier.shipping_id','merchant.id as merchant_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('product','product.id','=','orderproduct.product_id')
            ->leftJoin('merchantproduct','product.parent_id','=','merchantproduct.product_id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->where('porder.user_id',$user_id)
            ->where('porder.status','=','active')
            ->orderBy('porder.created_at','DESC')
            ->get();    

        $shippingsales = POrder::select('porder.*','courier.shipping_id','merchant.id as merchant_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('product','product.id','=','orderproduct.product_id')
            ->leftJoin('merchantproduct','product.parent_id','=','merchantproduct.product_id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->where('merchant.user_id',$user_id)
            ->where('porder.status','=','active')
            ->orderBy('porder.created_at','DESC')
            ->get();            
        $currency = Currency::where('active', 1)->first();
        $merchantvouchers= DB::table('merchantvoucher')->where('merchant_id', $merchant_id)->get();
        //return $merchantvouchers;
        $voucher_data = [];
        if (!empty($merchantvouchers)){
            foreach ($merchantvouchers as $v){
                $vouchers = Voucher::where('id','=',$v->voucher_id)->orderBy('created_at', 'desc')->get();

                foreach ($vouchers as $i) {

                    $temp['voucher_id'] = $v->voucher_id;
                    $temp['merchant_id'] = $v->voucher_id;
                    $temp['current_merchant_id'] = $merchant_id;
                    $temp['voucher'] = $i;
                    //$temp['voucher_timeslot']=$i->timeSlots;
                    $product_id = $i->product_id;
                    $product = DB::table('product')->where('product.id', '=', $product_id)->first();
                    if (!is_null($product)) {
                        # code...
                        $temp['voucher_product'] = $product;
                    }
                    
                    $temp['voucher_timeslot'] = DB::table('timeslot')->select('*')->where('voucher_id', $i->id)->first();;
                    $temp['voucher_address'] = $i->address;
                    $voucher_data[] = $temp;
                }
            }
        }


        $data['countries'] = $this->countryModel->lists('name','id')->all();
        $data['merchants'] = $this->merchantModel->getAllMerchants();
        $data['merchantConsultants'] = $this->salesStaffModel->getAllMerchantConsultants();
        //getting all products for merchant discount
        $products= Product::select('product.id' ,
                  'product.name' ,
                  'product.brand_id' ,
                  'product.parent_id' ,
                  'product.category_id' ,
                  'product.subcat_id' ,
                  'product.subcat_level'  ,
                  'product.segment' ,
                  'product.photo_1' ,
                  'product.photo_2' ,
                  'product.photo_3' ,
                  'product.photo_4' ,
                  'product.photo_5' ,
                  'product.adimage_1' ,
                  'product.adimage_2' ,
                  'product.adimage_3' ,
                  'product.adimage_4' ,
                  'product.adimage_5' ,
                  'product.description' ,
                  'product.free_delivery' ,
                  'product.free_delivery_with_purchase_qty' ,
                  'product.views' ,
                  'product.display_non_autolink' ,
                  'product.del_worldwide'  ,
                  'product.del_west_malaysia'  ,
                  'product.del_sabah_labuan'  ,
                  'product.del_sarawak'  ,
                  'product.cov_country_id' ,
                  'product.cov_state_id' ,
                  'product.cov_city_id' ,
                  'product.cov_area_id' ,
                  'product.b2b_del_worldwide' ,
                  'product.b2b_del_west_malaysia' ,
                  'product.b2b_del_sabah_labuan' ,
                  'product.b2b_del_sarawak' ,
                  'product.b2b_cov_country_id' ,
                  'product.b2b_cov_state_id' ,
                  'product.b2b_cov_city_id' ,
                  'product.b2b_cov_area_id' ,
                  'product.del_pricing'  ,
                  'product.del_width'  ,
                  'product.del_lenght'  ,
                  'product.del_height'  ,
                  'product.del_weight'  ,
                  'product.weight'  ,
                  'product.height'  ,
                  'product.width'  ,
                  'product.length'  ,
                  'product.del_option' ,
                  'product.retail_price' ,
                  'product.original_price' ,
                  'product.discounted_price',
                  'product.private_retail_price' ,
                  'product.private_discounted_price' ,
                  'product.stock' ,
                  'product.available' ,
                  'product.private_available' ,
                  'product.b2b_available' ,
                  'product.hyper_available' ,
                  'product.owarehouse_moq' ,
                  'product.owarehouse_moqpb' ,
                  'product.owarehouse_moqperpax' ,
                  'product.owarehouse_price' ,
                  'product.measure'  ,
                  'product.owarehouse_units' ,
                  'product.owarehouse_ave_unit_price' ,
                  'product.type'  ,
                  'product.owarehouse_duration' ,
                  'product.smm_selected'  ,
                  'product.oshop_selected'  ,
                  'product.mc_sales_staff_id' ,
                  'product.referral_sales_staff_id' ,
                  'product.mcp1_sales_staff_id' ,
                  'product.mcp2_sales_staff_id' ,
                  'product.psh_sales_staff_id' ,
                  'product.osmall_commission'  ,
                  'product.b2b_osmall_commission'  ,
                  'product.mc_sales_staff_commission'  ,
                  'product.mc_with_ref_sales_staff_commission'  ,
                  'product.referral_sales_staff_commission'  ,
                  'product.mcp1_sales_staff_commission'  ,
                  'product.mcp2_sales_staff_commission'  ,
                  'product.smm_sales_staff_commission'  ,
                  'product.psh_sales_staff_commission'  ,
                  'product.str_sales_staff_commission'  ,
                  'product.return_policy' ,
                  'product.return_address_id' ,
                  'product.status' ,
                  'product.active_date'  ,
                  'product.deleted_at'  ,
                  'product.created_at' ,
                  'product.updated_at')->get();  
        // dd($currency);
        // Hyper
            // Preventing not isset error
            $hypers= array();
            $merchant_products=MerchantProduct::products($merchant_id);
            // return $merchant_products;
            // Maybe inefficient . Needs to be re-written!
            // markeer zxcv
            $product_ids=array();
            $product_hids=array();

            try {
                foreach ($merchant_products as $mp) {
                    array_push($product_ids,$mp->product_id);  
                    $nyhyper = DB::table('product')->
                        where('parent_id',$mp->product_id)->
                        where('segment','hyper')->first();

                    if(!is_null($nyhyper)){
                        array_push($product_hids,$nyhyper->id);
                    }
                }
            
            } catch (\Exception $e) {
             return $e;   
            }
            
        // Hyper
        try {
            $hypers_ple = Product::leftJoin('owarehouse as o',
                'product.id','=','o.product_id')
            ->leftJoin('owarehousepledge as op', function($join) {
                 $join->on('o.id', '=', 'op.owarehouse_id')
                 ->where('op.status','=','executed');
             })
            ->where('op.user_id',$user_id)
            ->where('product.oshop_selected','1')
            ->where('product.available','>','0')
            ->where('o.status','=','active')
            ->select(DB::raw('product.*, product.parent_id as product_id,
                o.id as owarehouse_id,o.collection_price,o.collection_units,
                o.created_at as odate,
                GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
            ->groupBy('product.id')
            ->get();

        } catch (\Exception $e) {
            // return $e;
            $hypers_ple=array();  //Fallback ! Just in case something happens
        }           
        // dd($currency);

        try {
            $hypers = Product::leftJoin('owarehouse as o',
                'product.id','=','o.product_id')
                ->leftJoin('owarehousepledge as op', function($join) {
                     $join->on('o.id', '=', 'op.owarehouse_id')
                         ->where('op.status','=','executed');
                })
                ->whereIn('product.id',$product_hids)
                ->where('o.status','=','active')
                ->select(DB::raw('product.*,o.id as owarehouse_id,
                    o.collection_price,o.collection_units,
                    product.parent_id as product_id,
                    o.created_at as odate,
                    GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
                ->groupBy('product.id')
                ->get();
                // return $hyper;
   
            } catch (\Exception $e) {
                $hypers=array(); 
                // Fallback
               }
            // dd($hypers);
            // dd($voucher_data);

        $product_likes = DB::select(DB::raw(
            "SELECT product.*,
                DATE_FORMAT(usersproduct.created_at,'%d%b%y') as since,
                usersproduct.created_at
            FROM product, usersproduct
            WHERE product.id = usersproduct.product_id
            AND usersproduct.user_id = " . $user_id. "
            ORDER BY usersproduct.created_at DESC"));

        $crereasons = DB::table('crereasons')->get();

        // Writing this fresh code, it will make ordersb obsolete.
        $so=DB::table('porder as p')
            ->join('orderproduct as op','op.porder_id','=','p.id')
            ->join('payment as py','py.id','=','p.payment_id')
            ->join('merchantproduct as mp','op.product_id','=','mp.product_id')
            ->where('mp.merchant_id','=',$merchant_id)
            ->orderBy('p.created_at','DESC')
            ->select('p.id as oid','p.status as dstatus','py.status',
                'py.receivable','p.created_at as o_exec',
                'p.description as desc')
            ->get();
        // return $so;
        // return ($ordersb);

        $user_id=Auth::user()->id;
        $cre1= DB::table('cre')
            ->join('porder as por','cre.porder_id','=','por.id')
            ->join('orderproduct as ord','ord.porder_id','=','por.id')
            ->leftJoin('crereasons as crs','cre.crereason_id','=','crs.id')
            ->join('users as us','us.id','=','por.user_id')
            ->join('merchantproduct as mp','ord.product_id','=','mp.product_id')
            ->join('merchant as mer','mp.merchant_id','=','mer.id')
          
            ->where('mer.user_id','=',$user_id)
            ->where('por.status','!=','cancelled')
            ->where('por.status','!=','b-collected')
            ->where('por.status','!=','pending')
            ->where('ord.status','=','cancelreq')
            ->groupBy('por.id')
            ->having('status','=','cancelreq')
            ->orHaving('status','=','b-returning1')
            ->orderBy('cre.created_at','DESC')
            ->select(
                    'cre.id as cre_id',
                    'por.id as porder_id',
                    'ord.product_id as product_id',
                    'ord.id as op_id',
                    'us.id as user_id',
                    'us.first_name as first_name',
                    'us.last_name as last_name',
                    'us.mobile_no as contact',
                    'us.email as email',
                    'ord.status as status',
                    'cre.type as iwishto',
                    'crs.reason_text as reason'
                );

            // return $cre1;
            $cre2=DB::table('cre')
            ->join('porder as por','cre.porder_id','=','por.id')
            ->join('orderproduct as ord','ord.porder_id','=','por.id')
            ->leftJoin('crereasons as crs','ord.crereason_id','=','crs.id')
            ->join('users as us','us.id','=','por.user_id')
            ->join('merchantproduct as mp','ord.product_id','=','mp.product_id')
            ->join('merchant as mer','mp.merchant_id','=','mer.id')
            ->where('mer.user_id','=',$user_id)
            ->where('por.status','!=','cancelled')
            ->where('por.status','!=','b-collected')
            ->where('por.status','!=','pending')
            ->where('ord.status','!=','cancelreq')
            ->orderBy('cre.created_at','DESC')
            ->select(
                
                    'cre.id as cre_id',
                    'por.id as porder_id',
                    'ord.product_id as product_id',
                    'ord.id as op_id',
                    'us.id as user_id',
                    'us.first_name as first_name',
                    'us.last_name as last_name',
                    'us.mobile_no as contact',
                    'us.email as email',
                    'ord.status as status',
                    'cre.type as iwishto',
                    'crs.reason_text as reason'
                

                );

        $cre= $cre2->union($cre1)->get();

        // return $cre;
        return view('merchant.dashboard')
            ->with('product_likes',$product_likes)
            ->with('autolinks',$autolinks)
            ->with('shipping',$shipping)
            ->with('merchant_id',$merchant_id)
            ->with('tmerchant_id', $user_id)
            ->with('shippingsales',$shippingsales)
            ->with('orders',$orders)
            ->with('ordersb',$ordersb)
            ->with('openwish',$openwish)
            ->with('vouchers1',$voucher_data)
            ->with('comm',$commission)
            ->with('bank',$bank_commision)
            ->with('currency_code' , $currency->code)
            ->with('products' , $products)
            ->with('ow_product',$hypers)
            ->with('ow_product_ple',$hypers_ple)
            ->with('data', $data)
            ->with('voucher_data', $voucher_data)
            ->with('crereasons', $crereasons)
            ->with('merchant_payment_details', $merchant_payment_details)
            ->with('cre',$cre)
            ->with('globals', $globals);
    }

    public function get_merchant_product_ids($user_id) {
        $merchant_id= DB::table('merchant')->
            where('user_id',$user_id)->pluck('id');

        $product_ids=DB::table('merchantproduct')->
            where('merchant_id',$merchant_id)->lists('product_id');

        return  $product_ids;
    }

    public function get_merchant_vouchers($user_id) {
        $merchant_product_ids=$this->get_merchant_product_ids($user_id);
        $vouchers= DB::table('voucher')->
            whereIn('product_id',$merchant_product_ids)->get();

        return $vouchers;
    }

    public function get_merchant_commission($user_id) {
        $commission= DB::table('merchant')->
            where('user_id',$user_id)->pluck('osmall_commission');

        if (is_null($commission)) {
            $commission= DB::table('global')->pluck('osmall_commission');
        }

        return $commission;

    }

    public function get_porder($porder_id) {
        $infos= array();
        $do= DB::table('deliveryorder')->
            where('porder_id',$porder_id)->
            first();

        $merchant=DB::table('merchant')->
            where('user_id', Auth::user()->id)->
            first();

        $merchant_address= DB::table('address')->
            where('id',$merchant->address_id)->
            first();

        if (!is_null($do)) {
            $ops= DB::table('deliveryordersproduct')->
                where('do_id',$do->id)->
                get();

            foreach ($ops as $key) {
                # code...
                
                $product= Product::find($key->product_id);
                $key->unit_price= $product->retail_price;
                $key->product_desc= $product->name;
                array_push($infos,$key);
            }
        }

        return view('merchant.order-details-modal')->
            with('infos',$infos)->with('merchant',$merchant)->
            with('address',$merchant_address)->
            with('order_id',$porder_id);
    
    }

    public function station_order_process($oid) {
        try {
            $user_id = Auth::user()->id;
            $station = DB::table('station')->where('user_id',$user_id)->first();
            $station_id = $station->id;         
            // DB::table('porder')->where('id',$oid)->update(['status'=>'processing']);
            $qr_store_path=public_path()."/images/qr/".$oid."/";
            // return $qr_store_path;

            if (!file_exists($qr_store_path)) {
                mkdir($qr_store_path, 0775, true);
            }
            // Get Buyer Info
            $p= POrder::find($oid);
            $buyer_user_id=$p->user_id;
            $buyer=User::find($buyer_user_id);
            $shipping_address_id=$buyer->default_address_id;

            $address= Address::find($shipping_address_id);

            if (is_null($address)) {
                return response()->json([
                    'status'=>'failure',
                    'short_message'=>'DB Error',
                    'long_message'=>'Shipping Address Missing']);
            }

            $qr_info=$buyer->first_name." ".$buyer->last_name." \n".
                    $address->line1." \n".
                    $address->line2." \n".
                    $address->line3. "\n".
                    "Malaysia -".$address->postcode." \n".
                    "Contact Number: ".$buyer->mobile_no;

            $qr_image_name='BY-'.str_random(10);
            QrCode::format('png')->
                encoding('UTF-8')->
                size(400)->
                generate($qr_info,$qr_store_path.$qr_image_name.".png");

            $qr= new QR;
            $qr->type='qr';
            $qr->image_path=$qr_image_name;
            $qr->save();
           
             // Call Logistic
            $xml= $this->generateXMLProcess($oid);
            $cityLink= new CL;
            $resp=$cityLink->shipReq($xml);
            $l= new CtlShip;
            $l->porder_id=$oid;
            $l->qr_management_id=$qr->id;
            $l->priority='normal';
            $l->save();
            $p->status="processing";
            $p->save();

            $log= new Logistic;
            $log->save();
            
            /*** Update Availability ***/
            $op = DB::table('orderproduct')->where('porder_id',$p->id)->get();
            foreach($op as $o_p){
                $product = DB::table('product')->where('id',$o_p->product_id)->first();
                if(!is_null($product)){
                    $available = $product->available - $op->quantity;
                    DB::table('product')->where('id',$o_p->product_id)->update(['available'=>$available]);
                }
            }
            return json_encode("OK");

        } catch (\Exception $e) {
            try {
                dump($e);
                QR::destroy($qr->id);
                Logistic::destroy($l->id);
                return response()->json([
                    'status'=>'failure',
                    'short_message'=>'Server Error #1',
                    'long_message'=>'Failed to process the order']);

            } catch (\Exception $e) {
                return response()->json([
                    'status'=>'failure',
                    'short_message'=>'Server Error #2',
                    'long_message'=>'Failed to process the order']);
            }
        }
        
    }   
    
    public function merchant_order_process($oid) {
        try {
            // Rever
            //$logistic_id=1;
            // Get Buyer Info
            $p= POrder::find($oid);
            $buyer_user_id=$p->user_id;
            $buyer=User::find($buyer_user_id);
            $shipping_address_id=$buyer->default_address_id;

            if (!Auth::check()) {
                return response()->json(['status'=>'failure','short_message'=>'MDC#MOP#001',
					'long_message'=>'Please log in to complete your action']);
            }
            if ($p->status!="pending") {
               return response()->json(['status'=>'failure','short_message'=>'MDC#MOP#000',
                    'long_message'=>'This order cannot be processed.']);
            }
            if (Auth::user()->hasRole('adm')) {
                $product_id=OrderProduct::where('porder_id',$oid)->
					pluck('product_id');
                $merchant_id=UtilityController::productMerchantId($product_id);
            }else{
                $merchant_id= DB::table('merchant')->
					where('user_id',Auth::user()->id)->pluck('id');
            }   
            $merchant_add_id=DB::table('merchant')->where('id',$merchant_id)->pluck('address_id'); 
            
            $address= Address::find($shipping_address_id);
            $mAddress=Address::find($merchant_add_id);
            if (is_null($address) or is_null($mAddress)) {
                return response()->json([
                    'status'=>'failure',
                    'short_message'=>'DB Error',
                    'long_message'=>'Address Missing']);
            }
            $rcity=DB::table('city')
            ->where('id',$address->city_id)
            ->pluck('name');
            
            $mcity=DB::table('city')
            ->where('id',$mAddress->city_id)
            ->pluck('name');


            $qr_info=$buyer->first_name." ".$buyer->last_name." \n".
                    $address->line1." \n".
                    $address->line2." \n".
                    $address->line3. "\n".
                    "Malaysia -".$address->postcode." \n".
                    "Contact Number: ".$buyer->mobile_no;

		
            $sidg= new SecurityIDGenerator;
            $security_id= $sidg->generate(Carbon::now()->toDateString());
   
			// $newid = UtilityController::generaluniqueid($dl->id, '11', '1', $dl->created_at, 'ndeliveryid', 'ndelivery_id');
			// if($newid != ""){
			// 	DB::table('ndeliveryid')->insert(['ndelivery_id'=>$newid, 'delivery_id'=>$dl->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			/*	$deliveryorder = DB::table('deliveryorder')->join('receipt','deliveryorder.receipt_id','=','receipt.id')->where('receipt.porder_id',$oid)
				->select('deliveryorder.*')->first();
				if(!is_null($deliveryorder)){
					UtilityController::createQr($deliveryorder->id,'deliveryorder',IdController::nDel($dl->id));
				}*/
				
            // Change Status
            $p->status="m-processing1";
            $p->save();
            
            /*** Update Availability ***/
            $op = DB::table('orderproduct')->where('porder_id',$p->id)->get();

            foreach($op as $o_p){
                // $product = DB::table('sproduct')->select('sproduct.*')->join('stationsproduct','sproduct.id','stationsproduct.sproduct_id')->where('sproduct.product_id',$o_p->product_id)->where('stationsproduct.station_id',$station_id)->first();
                DB::table('orderproduct')->where('id',$o_p->id)->update(['status'=>'m-processing1']);
                // if(!is_null($product)){
                //  $available = $product->available - $op->quantity;
                //  DB::table('sproduct')->where('id',$product->id)->update(['available'=>$available]);
                // }
            }
            return json_encode("OK");
            
        } catch (\Exception $e) {
            try {
                dump($e);
                
                // Logistic::destroy($l->id);
                return response()->json([
                    'status'=>'failure',
                    'short_message'=>'Server Error #1',
                    'long_message'=>'Failed to process the order']);

            } catch (\Exception $e) {
                return response()->json([
                    'status'=>'failure',
                    'short_message'=>'Server Error #2',
                    'long_message'=>'Failed to process the order']);
            }
        }
        
    } //ends

    public function postAddOW(Request $r) {
        # This function lets a merchant complete
        # the openwish pledge for a buyer
        $openwish_id=$r->ow_id;
        $amount= $r->amount*100; //in cents
        $pid= $r->product_id;
        $first=true;

        // Check if cart has the openwish added
        $p=Product::find($pid);
        foreach (Cart::contents() as $c) {
            if ($c->mode=="owish") {
                if ($c->openwish_id==$openwish_id) {
                    $first=false;
                }
            }
        }

        if ($first==true) {
            Cart::insert(array(
                'id'=>$pid,
                'name'=>$p->name,
                'parent_id'=>$pid,
                'delivery'=>0,
                'price'=>$amount,
                'quantity'=>1,
                'image'=>$p->photo_1,
                'openwish_id'=>$openwish_id,
                'mode'=>'owish'


                ));
        }
        $total_items = Cart::totalItems();
        $product_name = $p->name;
        return compact('total_items' , 'product_name');
    }
    public function postAddtocart(Request $request) {
        $found = false;
        $product = Product::find($request->product_id)->first();
        foreach (Cart::contents() as $item) {
            if($item->id == $request->product_id){
                $item->price = $request->amount + $item->price;
                $item->quantity += 1;
                $found = true;
            }
        }
        if(!$found){
            Cart::insert(
                array(
                    'id' => $request->product_id,
                    'quantity' => '1',
                    'name' => $product->name,
                    'price' => $request->amount,
                    'image' => $product->photo_1,
                    
                )
            );
        }
        $total_items = Cart::totalItems();
        $product_name = $product->name;
      //    Cart::destroy();
        return compact('total_items' , 'product_name');
    }
    function addNewDiscount(Request $request){
        $buyers_count=Buyer::count();
        if ($request->discount_product=="Select Product") {

            return Response(['Product is required'],422);
        }
        $this->validate($request,array(
                'discount_product'=>'required|max:250',
                'discount_duration'=>'required|numeric|min:1',
                //'discount_start_date'=>'required|date',
                'discount_quantity'=>"required|numeric|min:1|max:$buyers_count",
                'percentage'=>'required|numeric|min:1|max:100',
          //  'discount_image' => 'required|image|max:2000',
                ));

		//dd($image);
        $discount=new Discount;
        $discount->product_id=$request->discount_product;
        //$discount->start_date = strtotime(time());
        $discount->duration_days=$request->discount_duration;
        $discount->quantity=$request->discount_quantity;
        $discount->remarks = $request->discount_remarks;
        $discount->discount_percentage=$request->percentage;
        if ($discount->save()) {
            $newid = UtilityController::generaluniqueid($discount->id, '4','1', $discount->created_at, 'ndiscountid', 'ndiscount_id');
            DB::table('ndiscountid')->insert(['ndiscount_id'=>$newid, 'discount_id'=>$discount->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);     
            /*************Saving Image**************/
			$image=Input::file('discount_image');
			if(is_null($image)){
				$folder = base_path() . '/public/images/discount/' . $discount->id;
				File::makeDirectory($folder, 0777, true, true);
				if (\File::copy('images/discount/default/default.jpg' , 'images/discount/'.$discount->id.'/default.jpg')) {
					$discount->image='default.jpg';
					$discount->save();
				}
			} else {         
				$filename=uniqid().$image->getClientOriginalName();
				$filename=str_replace(" ","",$filename);
				$move=$image->move('images/discount/'.$discount->id,$filename);
				if ($move) {
					$discount->image=$filename;
					$discount->save();
				}
			}
            $product = DB::table('product')->where('product.id', '=', $request->discount_product)->first();
            $subcat_id = 0;
            $cat_id = 0;
            $merchant_id = 0;
            if(!is_null($product)){
                $subcat_id = $product->category_id;
                $cat_id = $product->subcat_id;
            }
            $mproduct = DB::table('merchantproduct')->where('merchantproduct.product_id', '=', $request->discount_product)->first();
            if(!is_null($product)){
                $merchant_id = $mproduct->merchant_id;
            }           
            /*             * *************Assigning discounts to buyers******************** */
            $buyers = DB::select(DB::raw('SELECT buyer.id as id, buyer.user_id as user_id, IF(usersproduct.id IS NULL,0,SUM(1)) as likes, IF(porder.id IS NULL,0,SUM(1)) as orders, IF(productvisit.counter IS NULL, 0, productvisit.counter) as product_clicks, IF(subcategoryvisit.counter IS NULL, 0, subcategoryvisit.counter) as subcategory_clicks, IF(categoryvisit.counter IS NULL, 0, categoryvisit.counter) as category_clicks, IF(merchantvisit.counter IS NULL, 0, merchantvisit.counter) as merchant_clicks, IF(osmallvisit.counter IS NULL, 0, osmallvisit.counter) as osmall_clicks
            FROM buyer 
            LEFT JOIN usersproduct ON buyer.user_id = usersproduct.user_id AND usersproduct.product_id = '.$request->discount_product.' 
            LEFT JOIN porder ON buyer.user_id = porder.user_id 
            LEFT JOIN orderproduct ON porder.id = orderproduct.porder_id AND orderproduct.product_id = '.$request->discount_product.'
            LEFT JOIN productvisit ON buyer.user_id = productvisit.user_id AND productvisit.product_id = '.$request->discount_product.' 
            LEFT JOIN subcategoryvisit ON buyer.user_id = subcategoryvisit.user_id AND subcategoryvisit.subcategory_id = '.$subcat_id.'
            LEFT JOIN categoryvisit ON buyer.user_id = categoryvisit.user_id AND categoryvisit.category_id = '.$cat_id.'
            LEFT JOIN merchantvisit ON buyer.user_id = merchantvisit.user_id AND merchantvisit.merchant_id = '.$merchant_id.'
            LEFT JOIN osmallvisit ON buyer.user_id = osmallvisit.user_id
            WHERE buyer.deleted_at IS NULL
            GROUP BY id 
            ORDER BY likes DESC, product_clicks DESC, orders DESC, subcategory_clicks DESC, category_clicks DESC, merchant_clicks DESC, osmall_clicks DESC, buyer.created_at limit ' . $request->discount_quantity));
            //dd($buyers);
            foreach ($buyers as $i) {
                $discount_buyer=new DiscountBuyer;
                $discount_buyer->buyer_id=$i->user_id;
                $discount_buyer->discount_id=$discount->id;
                $discount_buyer->status="active";
                $discount_buyer->save();
            }

            return "1";
        }
        else{
            return "0";
        }
    }


    function getAllDiscounts(){
        $discount= Discount::orderBy('created_at','DESC')->get();

        $discount_data=[];
        foreach ($discount as $i) {
            $buyer_discounts = DB::table('discountbuyer')->where('discount_id', $i->id)->get();
            $temp['discount_left'] = ($i->quantity) - DB::table('discountbuyer')->where('discount_id', $i->id)->Where(function ($query) {
                $query->where('status', '=', 'expired')
                      ->orwhere('status', '=', 'executed');
            })->count();
            $temp['buyer_discount'] = $buyer_discounts;
            $buyer_ids = "";
            $due_date = date("d-M-Y H:i:s", strtotime($i->created_at . "+ " . $i->duration_days . ' days'));
            $temp['due_date'] = date("d-M-Y H:i:s", strtotime($i->created_at . "+ " . $i->duration_days . ' days'));
            foreach ($buyer_discounts as $j) {
                $buyer_ids.=$j->buyer_id.", ";
                if((time()-(60*60*24)) < strtotime($temp['due_date'])){
                    
                } else {
                    DB::table('discountbuyer')->where('id',$j->id)->update(['status'=> 'expired']);
                }
            }
			$merchant_name = "";
			$merchant_id = 0;
			$merchant = DB::table('merchant')->join('merchantproduct','merchantproduct.merchant_id','=','merchant.id')->join('discount','merchantproduct.product_id','=','discount.product_id')->where('discount.product_id',$i->product_id)->first();
			if(!is_null($merchant)){
				$merchant_name = $merchant->company_name;
				$merchant_id = $merchant->merchant_id;
			}
			$temp['expiry_date'] = date("dMy", strtotime($i->created_at . "+ " . $i->duration_days . ' days'));
            $temp['merchant_id'] = $merchant_id;
            $temp['merchant_name'] = $merchant_name;
            $temp['buyer_ids'] = $buyer_ids;
            $temp['id'] = $i->id;
            $temp['buyer_idf'] = IdController::nB($i->buyer_id);
            $temp['discount_idf'] = IdController::nD($i->id);
            $temp['idf'] = ' [' . sprintf('%010d', $i->id) . ']  ';

            $temp['product_idf'] = IdController::nP($i->product_id);
            $temp['product_id'] = $i->product_id;
            //$temp['duration_days']=$i->duration_days;
            $temp['quantity'] = $i->quantity;
            $temp['remarks'] = $i->remarks;
            $temp['status'] = $i->status;
            $temp['start_date'] = date("d-M-Y", strtotime($i->created_at));
            
            
           
            $date_left = date_diff(date_create($due_date), date_create(date("d-M-Y H:i:s")));
            
            $temp['days_left'] = $date_left->format('%a days, %h hours and %i minutes');
            $temp['discount_percentage'] = $i->discount_percentage;
            $temp['product_name'] = Product::select('name')->where('id', $i->product_id)->get();
            $discount_data[] = $temp;
            if((time()-(60*60*24)) < strtotime($temp['due_date'])){
                
            } else {
                DB::table('discount')->where('id',$i->id)->update(['status'=> 'expired']);
            }           
            
        }
        return $discount_data;
    }
    
    function getMerchantDiscounts($merchant_id){
        $discount= Discount::select('discount.id as id','discount.status as status','discount.quantity as quantity','discount.product_id as product_id','discount.remarks as remarks','discount.created_at as created_at','discount.duration_days as duration_days','discount.discount_percentage as discount_percentage')
        ->join('merchantproduct','discount.product_id','=','merchantproduct.product_id')
        ->join('product as p','discount.product_id','=','p.id')
        ->where('p.available','>',0)
        ->where('merchantproduct.merchant_id',$merchant_id)
        ->orderBy('discount.created_at','DESC')
        ->get();

        $discount_data=[];
        foreach ($discount as $i) {
            $buyer_discounts = DB::table('discountbuyer')->where('discount_id', $i->id)->get();
            $temp['discount_left'] = ($i->quantity) - DB::table('discountbuyer')->where('discount_id', $i->id)->Where(function ($query) {
                $query->where('status', '=', 'expired')
                      ->orwhere('status', '=', 'executed');
            })->count();
            $temp['buyer_discount'] = $buyer_discounts;
            $due_date = date("d-M-Y H:i:s", strtotime($i->created_at . "+ " . $i->duration_days . ' days'));
            
            $temp['due_date'] = date("d-M-Y H:i:s", strtotime($i->created_at . "+ " . $i->duration_days . ' days'));            
            $buyer_ids = "";
            foreach ($buyer_discounts as $j) {
                $buyer_ids.=$j->buyer_id.", ";
                if((time()-(60*60*24)) < strtotime($temp['due_date'])){
                    
                } else {
                    DB::table('discountbuyer')->where('id',$j->id)->update(['status'=> 'expired']);
                }               
            }
            $temp['buyer_ids'] = $buyer_ids;
            $temp['id'] = $i->id;
            $temp['buyer_idf'] = IdController::nB($i->buyer_id);
            $temp['idf'] = ' [' . sprintf('%010d', $i->id) . ']  ';

            $temp['product_idf'] = IdController::nP($i->product_id);
            $temp['product_id'] = $i->product_id;
            //$temp['duration_days']=$i->duration_days;
            $temp['quantity'] = $i->quantity;
            $temp['remarks'] = $i->remarks;
            $temp['status'] = $i->status;
            $temp['start_date'] = date("d-M-Y", strtotime($i->created_at));

            $date_left = date_diff(date_create($due_date), date_create(date("d-M-Y H:i:s")));
            
            $temp['days_left'] = $date_left->format('%a days, %h hours and %i minutes');
            $temp['discount_percentage'] = $i->discount_percentage;
            $temp['product_name'] = Product::select('name')->where('id', $i->product_id)->get();
			$temp['discount_idf']= IdController::nD($i->id);
            $discount_data[] = $temp;
            if((time()-(60*60*24)) < strtotime($temp['due_date'])){ 
            } else {
                DB::table('discount')->where('id',$i->id)->update(['status'=> 'expired']);
            }           
            
        }
        return $discount_data;
    }   
    
    function getLeftDiscounts($id) {

        $discount = Discount::find($id);
        $discount_data = [];
        $left_discounts =  DB::table('discountbuyer')->where('discount_id', $discount->id)->Where(function ($query) {
            $query->where('status', '=', 'active');
        })->orderBy('created_at','DESC')->get();
        if (!empty($left_discounts)) {
            $count_left=0;
            foreach($left_discounts as $left_i){
                $count_left++;
                $temp['no']=$count_left;
                $temp['buyer_id']=$left_i->buyer_id;
                $temp['buyer_idf'] = IdController::nB($left_i->buyer_id);
                $userss = User::find($left_i->buyer_id);
                if(!is_null($userss)){
                    $temp['user_id']= $userss->id;
                } else {
                    $temp['user_id']= 0;
                }
                $temp['user_idf']= ' [' . sprintf('%010d', $left_i->buyer_id) . ']  ';
                $temp['discount_id']=$left_i->discount_id;
                $temp['discount_idf']= ' [' . sprintf('%010d', $left_i->discount_id) . ']  ';
                $temp['discount_idf']= IdController::nD($left_i->discount_id);
                $temp['created_at']=date("dMy h:m", strtotime($left_i->created_at));
                $discount_data[] = $temp;
            }
        }

        
        
        return $discount_data;
    }
    
    function getIssuedDiscounts($id) {

        $discount = Discount::find($id);
        $discount_data = [];
        $discounts =  DB::table('discountbuyer')->where('discount_id', $discount->id)->orderBy('created_at','DESC')->get();
        if (!empty($discounts)) {
            $count_left=0;
            foreach($discounts as $left_i){
                $count_left++;
                $temp['no']=$count_left;
                $temp['buyer_id']=$left_i->buyer_id;
                $temp['buyer_idf'] = IdController::nB($left_i->buyer_id);
                $userss = User::find($left_i->buyer_id);
                if(!is_null($userss)){
                    $temp['user_id']= $userss->id;
                } else {
                    $temp['user_id']= 0;
                }
                $date_used = "";
				if(!is_null($left_i->executed_date)){
					$date_used = date("dMy h:m", strtotime($left_i->executed_date));
				}
                $temp['user_idf']= ' ' . sprintf('%010d', $left_i->buyer_id) . '  ';
                $temp['discount_id']=$left_i->discount_id;
                $temp['discount_idf']= ' [' . sprintf('%010d', $left_i->discount_id) . ']  ';
                $temp['discount_idf']= IdController::nD($left_i->discount_id);
                $temp['created_at']=date("dMy h:m", strtotime($left_i->created_at));
                $temp['date_used']=$date_used;
                $discount_data[] = $temp;
            }
        }

        
        
        return $discount_data;
    }   

    function getDiscount($discount_id) {
        $discount=DB::table('discount')
        ->select('discount.*','discount.created_at as created_atnew','discount.image as discount_image'
		,'discount.id as discount_id','product.name as product_name')
        ->join('product', 'discount.product_id', '=', 'product.id')
        ->where('discount.id', $discount_id)
        ->first();
        $discount->idf= IdController::nD($discount->id);
        return view('seller.discountdetail')->
            with('discount',$discount);
    }

    function get_buyer_discounts($discount_id) {
        $buyerdiscounts = DB::table('discount')
                ->join('discountbuyer', 'discount.id', '=', 'discountbuyer.discount_id')
                ->join('buyer', 'buyer.id', '=', 'discountbuyer.buyer_id')
                ->join('product as p','discount.product_id','=','p.id')
                ->where('p.available','>',0)
                ->where('discount.id', $discount_id)
                ->get();
        $discount_data = [];
        foreach ($buyerdiscounts as $i) {
            $temp['expired'] = false;
            $temp['buyer_id'] = $i->buyer_id;
            $due_date = date("Y-m-d H:i:s", strtotime($i->created_at . "+ " . $i->duration_days . ' days'));
            $date_left = date_diff(date_create($due_date), date_create(date("d-M-Y H:i:s")));
            $_due_date_sec=strtotime($i->created_at . "+ " . $i->duration_days . ' days');
            $temp['due_date'] = date("d-M-Y H:s:i", strtotime($i->created_at . "+ " . $i->duration_days . ' days'));
            $time_left_sec= $_due_date_sec-strtotime(date("Y-m-d H:i:s"));
            
            if($time_left_sec<0){
                
                DB::table('discountbuyer')
                ->where('discount_id', $i->discount_id)
                ->where('status','!=', 'executed')
                ->update(['status'=>'expired']);
                 if($i->status=="executed") {
                        $temp['days_left'] = "Executed";

                    }else{

                        $temp['expired'] = true;
                        $temp['days_left'] = "Expired";
                    }

            }else{
                $temp['days_left'] = $date_left->format('%a days, %h hours and %i minutes');
            }
            $temp['buyer_idf'] = IdController::nB($i->user_id);
            $temp['idf'] = IdController::nD($i->discount_id);
            $temp['id'] = $i->id;
            $temp['product_id'] = $i->product_id;
            $temp['product_idf'] = ' [' . sprintf('%010d', $i->product_id) . ']  ';

            $temp['status'] = $i->status;
            //$temp['duration_days']=$i->duration_days;
            $temp['quantity'] = $i->quantity;
            $temp['start_date'] = date("d-M-Y", strtotime($i->created_at));

            
            $temp['discount_percentage'] = $i->discount_percentage;
            $temp['product_name'] = Product::select('name')->where('id', $i->product_id)->get();
            if((time()-(60*60*24)) < strtotime($temp['due_date'])){
                $discount_data[] = $temp;
            }
        }
        return $discount_data;
    }

    function masterDiscount(){

        return view("merchant.master_discount");
    }

    function rejectBuyerRequest(Request $request){
        $po = DB::table('porder')->where('id', $request->id)->first();
        $product = DB::table('orderproduct')->where('porder_id', $request->id)->select('product_id')->first();
        if($po->status == "b-returning1"){
            if($request->status == 'approve'){ // Approval of Return
                DB::table('cre')->insert(array(
                    'user_id' => $po->user_id,
                    'type' => 'return',
                    'status' => 'success',
                    'crereason_id' => $request->reason_id,
                    'product_id' => $product->product_id,
                    'created_at' => (Carbon::now())
                ));
                DB::table('porder')->where('id', $request->id)->update(['status' => 'returned']);
                DB::table('orderproduct')->where('porder_id', $request->id)->update(['status' => 'returned']);
                return response()->json(['responseText' => 'Success!'], 200);
            }else{
                DB::table('cre')->insert(array(
                    'user_id' => $po->user_id,
                    'type' => 'return',
                    'status' => 'fail',
                    'crereason_id' => $request->reason_id,
                    'product_id' => $product->product_id,
                    'created_at' => (Carbon::now())
                ));
                return response()->json(['responseText' => 'Success!'], 200);
            }
        }else if($po->status == "cancelreq"){
            if($request->status == 'approve'){ // Approval of cancellation
                DB::table('cre')->insert(array(
                    'user_id' => $po->user_id,
                    'type' => 'cancel',
                    'status' => 'success',
                    'crereason_id' => $request->reason_id,
                    'product_id' => $product->product_id,
                    'created_at' => (Carbon::now())
                ));
                DB::table('porder')->where('id', $request->id)->update(['status' => 'cancelled']);
                DB::table('orderproduct')->where('porder_id', $request->id)->update(['status' => 'cancelled']);
                return response()->json(['responseText' => 'Success!'], 200);
            }else{
                DB::table('cre')->insert(array(
                    'user_id' => $po->user_id,
                    'type' => 'cancel',
                    'status' => 'fail',
                    'crereason_id' => $request->reason_id,
                    'product_id' => $product->product_id,
                    'created_at' => (Carbon::now())
                ));
                return response()->json(['responseText' => 'Success!'], 200);
            }
        }
    }
    


}
