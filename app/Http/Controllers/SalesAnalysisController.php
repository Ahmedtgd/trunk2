<?php
namespace App\Http\Controllers;

use App\Models\MerchantConsultant;
use App\Models\POrder;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\SalesStaff;
use App\Models\Station;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

use DateTime;
use DB;

class SalesAnalysisController extends Controller {
    public  $cStatus='"completed","reviewed","commented"';
    public function __construct()
    {
        $this->countryModel = new Country();
        $this->paymentModel = new Payment();
        $this->merchantModel = new Merchant();
        $this->salesStaffModel = new SalesStaff();
        $this->validation ="";
    }
    
    public function index(){
      
        $data['countries'] = $this->countryModel->lists('name','id')->all();
        $data['merchants'] = $this->merchantModel->getAllMerchants();
        $data['merchantConsultants'] = $this->salesStaffModel->getAllMerchantConsultants();
        $data['products'] = Product::lists('product.name','product.id')->all();
        // dd($data['products']);
        $data['brands'] = Brand::lists('brand.name','brand.id')->all();
        $data['categories'] = Category::lists('category.description','category.id')->all();     
        $since = DB::table('merchant')->orderBY('created_at','ASC')->pluck('created_at');
        if(is_null($since)){
            $since = date("d-M-Y",strtotime('-2 year',  date("Y-m-d")));
        } else {
            $since = date("d-M-Y", strtotime($since));
        }
        
        return view('admin.salesAnalysis')->with('data' , $data )->with('since' , $since );
    }

    /**
     * Display Sales Revenue data of country.
     *
     * @param Illuminate\Http\Request|Request $request
     * @return Response
     */
    public function getCountryData(Request $request)
    {
        if(!Input::exists("country_id"))
        {
            $data['success'] = false;
            $data['message'] = 'Parameters passed incorrect';
            return Response::json(array(
                    $data
                )); 
        }
        if($request->ajax())
        {
            if(!Input::exists("from_date") || !Input::exists("to_date"))
            {
                $res['success'] = false;
                $res['message'] = 'Parameters passed incorrect';
                return Response::json(array(
                        $res
                    )); 
            }
            $fromDate = Input::get("from_date");
            $toDate = Input::get("to_date");
            $id = Input::get("country_id");
            $data = $this->paymentModel->getCurrentCountrySalesRevenueDetails($id, date("Y-m-d", strtotime($fromDate)), date("Y-m-d", strtotime($toDate)));
           // dd($data);
            $res['data'] = array();
            $totalPayment = 0;
            foreach($data AS $key => $value)
            {
                if(is_numeric($value->total_payment))
                {
                    $res['data'][] = [strtotime($value->consignment) * 1000, floatval($value->total_payment/100)];
                    $totalPayment+= $value->total_payment/100;
                }
            }
            
            $date1 = new DateTime($fromDate);
            $date2 = new DateTime($toDate);

            $diff = $date2->diff($date1)->format("%a");
            if($diff == 0)
            {
                $res['averagePerDay'] = 0;
            }
            else
            {
                $res['averagePerDay'] = $totalPayment/$diff;
            }
            
            $data1 = $this->paymentModel->getCurrentCountryNumberOfPayments($id, date("Y-m-d", strtotime($fromDate)), date("Y-m-d", strtotime($toDate)));
            $totalPaymentCount = $data1[0]['total'];
            if($totalPaymentCount == 0)
            {
                $res['averagePerDeal'] = 0;
            }
            else
            {
                $res['averagePerDeal'] = $totalPayment/$totalPaymentCount;
            }
            $res['view'] = $data;
            $res['success'] = true;
            $res['message'] = 'Request successfully completed';
            return Response::json(array(
                    $res
                ));
        }
    }
    
    /**       
         * Display Sales Revenue data of state.
         *
         * @param  Illuminate\Http\Request $request
         * @return Response
         */
    public function getStateData(Request $request)
    {
        if(!Input::exists("state_id"))
        {
            $data['success'] = false;
            $data['message'] = 'Parameters passed incorrect';
            return Response::json(array(
                    $data
                )); 
        }
        if($request->ajax())
        {
            if(!Input::exists("from_date") || !Input::exists("to_date"))
            {
                $res['success'] = false;
                $res['message'] = 'Parameters passed incorrect';
                return Response::json(array(
                        $res
                    )); 
            }
            $fromDate = Input::get("from_date");
            $toDate = Input::get("to_date");
            $id = Input::get("state_id");
            $data = $this->paymentModel->getCurrentStateSalesRevenueDetails($id, date("Y-m-d", strtotime($fromDate)), date("Y-m-d", strtotime($toDate)));
            $res['data'] = array();
            $totalPayment = 0;
            foreach($data AS $key => $value)
            {
                if(is_numeric($value->total_payment))
                {
                    $res['data'][] = [strtotime($value->consignment) * 1000, floatval($value->total_payment/100)];
                    $totalPayment+= $value->total_payment/100;
                }
            }
            
            $date1 = new DateTime($fromDate);
            $date2 = new DateTime($toDate);

            $diff = $date2->diff($date1)->format("%a");
            if($diff == 0)
            {
                $res['averagePerDay'] = 0;
            }
            else
            {
                $res['averagePerDay'] = $totalPayment/$diff;
            }
            
            $data1 = $this->paymentModel->getCurrentStateNumberOfPayments($id, date("Y-m-d", strtotime($fromDate)), date("Y-m-d", strtotime($toDate)));
            $totalPaymentCount = $data1[0]['total'];
            if($totalPaymentCount == 0)
            {
                $res['averagePerDeal'] = 0;
            }
            else
            {
                $res['averagePerDeal'] = $totalPayment/$totalPaymentCount;
            }
            
            $res['view'] = $data;
            $res['success'] = true;
            $res['message'] = 'Request successfully completed';
            return Response::json(array(
                    $res
            )); 
        }
    }
    
    /**       
         * Display Sales Revenue data of merchant.
         *
         * @param  Illuminate\Http\Request $request
         * @return Response
         */
    public function getMerchantDataTotal(Request $request, $filter)
    {       

        $performace = [];   
        if($filter == "today"){
            $performance=$this->getMerchantDayPerformanceTotal($request->merchant_id);
        } else if($filter == "week"){
            $performance=$this->getMerchantWTDPerformanceTotal($request->merchant_id);
        } else if($filter == "month"){
            $performance=$this->getMerchantMTDPerformanceTotal($request->merchant_id);
        } else if($filter == "year"){
            $performance=$this->getMerchantYTDPerformanceTotal($request->merchant_id);
        } else if($filter == "hourly"){

            $performance=$this->getMerchantHourPerformanceTotal($request->merchant_id);
        } else {
            
            $performance=$this->getMerchantSincePerformanceTotal($request->merchant_id);

        }
        //return Response::json()
        return Response::json($performance);
    }        
         
    public function getMerchantData(Request $request)
    {

        if(!Input::exists("merchant_id"))
        {
            $data['success'] = false;
            $data['message'] = 'Parameters passed incorrect #1';
            return Response::json(array(
                    $data
                )); 
        }
        if($request->ajax())
        {
            
            if(!Input::exists("from_date") || !Input::exists("to_date") || !Input::exists("country") || !Input::exists("state") || !Input::exists("city") || !Input::exists("marea") || !Input::exists("product") || !Input::exists("brand") || !Input::exists("category") || !Input::exists("subcategory") || !Input::exists("channel") || !Input::exists('type'))
            {
              //  dd("Here");
                $res['success'] = false;
                $res['message'] = 'Parameters passed incorrect #2';
                return Response::json(array(
                        $res
                    )); 
            }
            $this->getValidations($request);
            $type = Input::exists('type');

            $merchantId = Input::get("merchant_id");
            $country = Input::get("country");
            $state = Input::get("state");
            $city = Input::get("city");
            $area = Input::get("marea");
            $consumer = Input::get("consumer");
            $fromDate = Input::get("from_date");
            $toDate = Input::get("to_date");
            $fromDate = date("Y-m-d", strtotime($fromDate));
            $toDate = date("Y-m-d", strtotime($toDate));
            $id = Input::get("merchant_id");
            $global = DB::table('global')->first();
            $channel = Input::get("channel");
            $res['data'] = array();
            $totalPayment = 0;
            $currmonth = 0;
            $prodarr = array();
            $prodqtyarr = array();
            $brandarr = array();
            $brandqtyarr = array();
            $categoryarr = array();
            $categoryqtyarr = array();
            $subcategoryarr = array();
            $subcategoryqtyarr = array();
            $mkfromDate = Input::get("from_date");
            $mktoDate = Input::get("to_date");
            $dated1 = mktime(0,0,0,date("n", strtotime($mkfromDate)),date("j", strtotime($mkfromDate)),date("Y", strtotime($mkfromDate))); // m d y, use 0 for day
            $dated2 = mktime(0,0,0,date("n", strtotime($mktoDate)),date("j", strtotime($mktoDate)),date("Y", strtotime($mktoDate))); // m d y, use 0 for day

            $realdif = (($dated2-$dated1) / 60 / 60 / 24 / 30);
            if($realdif > 24){
                $realdif = 24;
            }
            $months = array(0 => "Jan",1 => "Feb",2 => "Mar",3 => "Apr",4 => "May",5 => "Jun",6 => "Jul",7 => "Aug",8 => "Sep",9 => "Oct",10 => "Nov",11 => "Dec");         
            $xaxis_categories = Array();
            $d = date_parse_from_format("Y-m-d", $fromDate);
            $init_month = $d["month"];          
            $init_year = substr($d["year"],-2);         
            //$index = 0;
            for($i = 0; $i < ($realdif); $i++){
                $res['data'][$i] = 0;
                $xaxis_categories[$i] = $months[$init_month - 1] . " " . $init_year;
                $init_month++;
                if($init_month == 13){
                    $init_month = 1;
                    $init_year++;
                }
            }
            $countryq = "";
            if($country != ""){
               $countryq = " AND co.id = " . $country . " ";
            }
            $stateq = "";
            if($state != ""){
                $stateq = " AND s.id = " . $state . " ";
            }
            $cityq = "";
            if($city != ""){
                $cityq = " AND ci.id = " . $city . " ";
            }
            $areaq = "";
            if($area != ""){
                $areaq = "";
            }
            $consumerq = "";
            $consumerf = "";
            if($consumer != ""){
                $consumerf = ", " . $consumer .  " cons" ;
                $consumerq = " AND cons.user_id = u.id " ;
            }
            
            $merchants = DB::select(
                DB::raw("
                    SELECT 
                    MONTH(date(po.updated_at)) as currmonth,
                    YEAR(date(po.updated_at)) as curryear,
                    date(po.updated_at) as consignment,
                    c.code as currency,
                    po.id as poid,
                    m.id as mid,
                    m.user_id as user_id,
                    m.company_name as company,
                    m.oshop_name as name,
                    SUM(op.osmall_comm_amount) as commission_sv,
                    SUM((op.order_price * op.quantity)) as net_payable, 
                    m.mc_sales_staff_id as mc_id,
                    m.mc_sales_staff_commission as mc_commission,
                    m.referral_sales_staff_id as referral_id,
                    m.referral_sales_staff_commission as referral_commission,
                    m.commission_type as commission_type,
                    m.osmall_commission as osmall_commission,
                    m.b2b_commission_type as b2b_commission_type,
                    m.b2b_osmall_commission as b2b_osmall_commission,
                    m.mcp1_sales_staff_id as mcp1_id,
                    m.mcp1_sales_staff_commission as mcp1_commission,
                    m.mcp2_sales_staff_id as mcp2_id,
                    m.mcp2_sales_staff_commission as mcp2_commission,
                    DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, 
                    UPPER(po.source) as source 
                    FROM 
                    merchant m,
                    payment p,
                    porder po,
                    orderproduct op,
                    product pro,
                    merchantproduct mp,
                    currency c, users u " . $consumerf . ",
                    city ci,
                    state s,
                    country co,
                    address a 
                    WHERE 
                    c.active = 1 
                    and po.updated_at >= '".$fromDate." 00:00:00'
                    and po.updated_at <= '".$toDate." 23:59:59'
                    and p.id = po.payment_id 
                    and m.id = mp.merchant_id
                    and pro.id = mp.product_id
                    and op.porder_id = po.id
                    and op.product_id = pro.id 
                    AND po.user_id = u.id 
                    AND po.status IN (".$this->cStatus.") 
                    AND u.shipping_address_id = a.id 
                    AND a.city_id = ci.id 
                    AND ci.state_code = s.code 
                    AND s.country_code = co.code 
                    AND m.id = ".$id." " . $countryq . " " . $stateq . " " . $cityq . " " . $consumerq . " AND po.id NOT IN (SELECT sorder.porder_id FROM sorder WHERE sorder.porder_id = po.id) GROUP BY po.id ORDER BY p.updated_at DESC"));
            //  dd($merchants);
                    $totalPaymenttoday = 0;
                    $totalDealstoday = 0;
                    $totalPaymentwtd = 0;
                    $totalPaymentmtd = 0;
                    $totalPaymentytd = 0;
                    $totalDealswtd = 0;
                    $totalDealsmtd = 0;
                    $totalDealsytd = 0;         
                    $totalDeals = 0;    
                    $curri = 0; 
                    $currmonth = date("m", strtotime(Input::get('from_date')));
                    $curryear = date("Y", strtotime(Input::get('from_date')));
                    
                    foreach ($merchants as $merchant) {
                        $mpayable = 0;
                        $payable = 0;
                        $product = Input::get("product");
                        $brand = Input::get("brand");
                        $category = Input::get("category");
                        $subcategory = Input::get("subcategory");   
                        $channel = Input::get("channel");   
                    //  $subcategoryarr = explode("-",$subcategory);
                        $productq = "";
                        $subcategoryq = "";
                        if($subcategory != ""){
                            if($product != ""){
                                $productq = " AND pro.subcat_id = " . $product . " AND pro.subcat_level = 2 ";
                            } else {
                                $subcategoryq = " AND pro.subcat_id = " . $subcategory . " AND pro.subcat_level = 1 ";
                            }
                        }   
                        $brandq = "";
                        if($brand != ""){
                            $brandq = " AND pro.brand_id = " . $brand . " ";
                        }
                        $categoryq = "";
                        if($category != ""){
                            $categoryq = " AND pro.category_id = " . $category . " ";
                        }
                        $channelq = "";
                        if($channel != "")
                        {
                            /*if($channel == 'all2loc')
                            {
                                $channelData = DB::table('fairlocation')->where('user_id', $merchant->user_id)->get();
                                $i = 0;
                                foreach ($channelData as $value) {
                                    if($value->code != '' )
                                    {
                                        $locationList[$i] = $value->code;
                                        $i++;    
                                    }
                                }
                                
                                $finalChannel = implode(",", $locationList);
                                
                                $channelq = " AND pro.segment IN ('" . $finalChannel . "')";
                                
                            }
                            else if($channel == 'overall2sales')
                            {
                                $channelData = DB::table('fairlocation')->where('user_id', $merchant->user_id)->get();
                                $i = 0;
                                foreach ($channelData as $value) {
                                    if($value->code != '' )
                                    {
                                        $locationList[$i] = $value->code;
                                        $i++;    
                                    }
                                }
                                $finel1 = array('b2c','b2b','hyper','smm','openwish');
                                $final2 = $locationList;
                                $finalChannel = array_merge($finel1,$final2);
                                $final2 = implode(",", $finalChannel);
                                                               
                                $channelq = " AND pro.segment IN ('" . $final2 . "')";
                                
                            }*/
                            /*else
                            {*/
                                $channelq = " AND pro.segment = '" . $channel . "' ";

                           //} 
                        }   

                        /*if($channel = "all2loc")
                        {
                            $orderps = DB::select(DB::raw("SELECT c.code as currency, po.id as poid,m.id as mid,m.user_id as user_id, m.company_name as company, m.oshop_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, op.order_price as order_price, op.quantity as quantity, op.order_delivery_price as order_delivery_price, ((op.order_price * op.quantity)) as net_payable, 
                            m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
                            m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, pro.segment as segment, pro.id as proid, pro.brand_id as brandid, pro.category_id as categoryid, pro.subcat_id as subcatid, pro.subcat_level as slevel, pro.osmall_commission as osmall_commission,
                            DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM merchant m, payment p, porder po, orderproduct op, product pro, merchantproduct mp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.merchant_id " . $productq . " " . $brandq . " " . $categoryq . " " . $subcategoryq . " and pro.id = mp.product_id and op.porder_id = po.id and op.product_id = pro.id AND po.id = ".$merchant->poid." AND po.id NOT IN (SELECT sorder.porder_id FROM sorder WHERE sorder.porder_id = po.id) GROUP BY op.id ORDER BY p.created_at DESC"));
                            echo "<pre>";
                            print_r($orderps);
                            exit;
                        }*/

                        $orderps = DB::select("SELECT c.code as currency, po.id as poid,m.id as mid,m.user_id as user_id, m.company_name as company, m.oshop_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, op.order_price as order_price, op.quantity as quantity, op.order_delivery_price as order_delivery_price, ((op.order_price * op.quantity)) as net_payable, 
                        m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
                        m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, pro.segment as segment, pro.id as proid, pro.brand_id as brandid, pro.category_id as categoryid, pro.subcat_id as subcatid, pro.subcat_level as slevel, pro.osmall_commission as osmall_commission, pro.b2b_osmall_commission as b2b_osmall_commission,
                        DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM merchant m, payment p, porder po, orderproduct op, product pro, merchantproduct mp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.merchant_id " . $productq . " " . $brandq . " " . $categoryq . " " . $subcategoryq . " " . $channelq . "  and pro.id = mp.product_id and op.porder_id = po.id and op.product_id = pro.id AND po.id = ".$merchant->poid." AND po.id NOT IN (SELECT sorder.porder_id FROM sorder WHERE sorder.porder_id = po.id) GROUP BY op.id ORDER BY p.created_at DESC");

                        if($merchant->commission_type != "std" && $merchant->commission_type != "var" ){
                            $commission_type=$global->commission_type;
                        } else {
                            $commission_type=$merchant->commission_type;
                        }                   
                        if($merchant->b2b_commission_type != "std" && $merchant->b2b_commission_type != "var" ){
                            $b2b_commission_type=$global->b2b_commission_type;
                        } else {
                            $b2b_commission_type=$merchant->b2b_commission_type;
                        }                       
                        $mc_pay = 0;
                        if($merchant->mc_id > 0){
                            if($merchant->mc_commission > 0){
                                $mc_pay = $merchant->mc_commission;
                            } else {
                                $mc_pay = $global->mc_sales_staff_commission;
                            }
                        }
                        $referral_pay = 0;
                        if($merchant->referral_id > 0){
                            if($merchant->referral_commission > 0){
                                $referral_pay = $merchant->referral_commission;
                            } else {
                                $referral_pay = $global->referral_sales_staff_commission;
                            }
                        }
                        $mcp1_pay = 0;
                        if($merchant->mcp1_id > 0){
                            if($merchant->mcp1_commission > 0){
                                $mcp1_pay = $merchant->mcp1_commission;
                            } else {
                                $mcp1_pay = $global->mcp1_sales_staff_commission;
                            }
                        }                                                           
                        $mcp2_pay = 0;
                        if($merchant->mcp2_id > 0){
                            if($merchant->mcp2_commission > 0){
                                $mcp2_pay = $merchant->mcp2_commission;
                            } else {
                                $mcp2_pay = $global->mcp2_sales_staff_commission;
                            }
                        }       
                        $gateway_pay = $global->payment_gateway_commission;
                        $logistic_pay = $global->logistic_commission;
                        // dd($orderps);
                        foreach ($orderps as $orderp) {                     
                            $commission =DB::select(DB::raw("
                                SELECT DISTINCT
                                SUM(osmall_comm_amount) as comm
                                FROM 
                                orderproduct
                                WHERE
                                porder_id=".$orderp->poid."
                                group by porder_id
                                "))[0]->comm;
                            // dd($commission[0]->comm);
                            $mipayable = $orderp->net_payable;  
                            // dd($mipayable);
                            $mpayable += $mipayable;    
                            $npayable = $orderp->net_payable;
                            $payable += $npayable;  
                            if (array_key_exists($orderp->proid, $prodarr)) {
                                $prodarr[$orderp->proid] += $payable/100;
                                $prodqtyarr[$orderp->proid] += $orderp->quantity;
                            } else {
                                $prodarr[$orderp->proid] = $payable/100;
                                $prodqtyarr[$orderp->proid] = $orderp->quantity;
                            }
                            
                            if (array_key_exists($orderp->brandid, $brandarr)) {
                                $brandarr[$orderp->brandid] += $payable/100;
                                $brandqtyarr[$orderp->brandid] += $orderp->quantity;
                            } else {
                                $brandarr[$orderp->brandid] = $payable/100;
                                $brandqtyarr[$orderp->brandid] = $orderp->quantity;
                            }   

                            if (array_key_exists($orderp->categoryid, $categoryarr)) {
                                $categoryarr[$orderp->categoryid] += $payable/100;
                                $categoryqtyarr[$orderp->categoryid] += $orderp->quantity;
                            } else {
                                $categoryarr[$orderp->categoryid] = $payable/100;
                                $categoryqtyarr[$orderp->categoryid] = $orderp->quantity;
                            }   

                            if (array_key_exists($orderp->subcatid . "-" . $orderp->slevel , $subcategoryarr)) {
                                $subcategoryarr[$orderp->subcatid . "-" . $orderp->slevel] += $payable/100;
                                $subcategoryqtyarr[$orderp->subcatid . "-" . $orderp->slevel] += $orderp->quantity;
                            } else {
                                $subcategoryarr[$orderp->subcatid . "-" . $orderp->slevel] = $payable/100;
                                $subcategoryqtyarr[$orderp->subcatid . "-" . $orderp->slevel] = $orderp->quantity;
                            }                               
                        }
                        $merchant->mpayable = $mpayable;                        
                        $merchant->payable = $payable;  
                        if($currmonth == $merchant->currmonth && $curryear == $merchant->curryear){
                            
                        } else {
                            if($curryear == $merchant->curryear){
                                $curri = $curri + ($merchant->currmonth - $currmonth);
                            } else {
                                $curri = $curri + ((12 + $merchant->currmonth) - $currmonth);
                                /*dump($merchant->currmonth);
                                dump($currmonth);
                                dump($curri);*/
                            }
                            $currmonth = $merchant->currmonth;
                            $curryear = $merchant->curryear;
                        }
                        
                        
                        if(isset($res['data'][$curri])){
                            $res['data'][$curri] += floatval(round($merchant->payable/100,2));
                        } else {
                            $res['data'][$curri] = floatval(round($merchant->payable/100,2));
                        }
                        $totalPayment+= $merchant->payable/100;
                        $totalDeals++;
                        $thisW = date("W", strtotime($merchant->consignment));
                        if($thisW == date('W') && $curryear == date('Y') && $payable > 0){
                            $totalPaymentwtd+= $merchant->payable/100;
                            $totalDealswtd++;
                        }
                        if($merchant->consignment == date('Y-m-d') && $payable > 0){
                            $totalPaymenttoday+= $merchant->payable/100;
                            $totalDealstoday++;
                        } 
                        if($merchant->currmonth == date('m') && $curryear == date('Y') && $payable > 0){
                            $totalPaymentmtd+= $merchant->payable/100;
                            $totalDealsmtd++;
                        }
                        if($curryear == date('Y') && $payable > 0){
                            $totalPaymentytd+= $merchant->payable/100;
                            $totalDealsytd++;
                        }
                     }                  
            $maxprod = 0;
            $maxprodkey = 0;
            $minprod = 0;
            $minprodkey = 0;
            foreach ($prodarr as $key => $value) {
                if($prodarr[$key] > $maxprod){
                    $maxprod = $prodarr[$key];
                    $maxprodkey = $key;
                }
                
                if($prodarr[$key] < $minprod){
                    $minprod = $prodarr[$key];
                    $minprodkey = $key;
                }               
            }

            $productdescmin = "";
            $prodminqty = 0;
            $compproduct = DB::table('product')->where('id',$minprodkey)->first();
            if(!is_null($compproduct)){
                $productdescmin = $compproduct->name;
                $prodminqty = $prodqtyarr[$minprodkey];
            }
            
            $productdescmax = "";
            $prodmaxqty = 0;
            $compproduct = DB::table('product')->where('id',$maxprodkey)->first();
            if(!is_null($compproduct)){
                $productdescmax = $compproduct->name;
                $prodmaxqty = $prodqtyarr[$maxprodkey];
            }           
            
            $maxbrand = 0;
            $maxbrandkey = 0;
            $minbrand = 10000000000;
            $minbrandkey = 0;
            foreach ($brandarr as $key => $value) {
                if($brandarr[$key] > $maxbrand){
                    $maxbrand = $brandarr[$key];
                    $maxbrandkey = $key;
                }
                
                if($brandarr[$key] < $minbrand){
                    $minbrand = $brandarr[$key];
                    $minbrandkey = $key;
                }               
            }       

            $branddesmin = "";
            $brandminqty = 0;
            $compbran = DB::table('brand')->where('id',$minbrandkey)->first();
            if(!is_null($compbran)){
                $branddesmin = $compbran->name;
                $brandminqty = $brandqtyarr[$minbrandkey];
            }
            
            $branddesmax = "";
            $compbran = DB::table('brand')->where('id',$maxbrandkey)->first();
            $brandmaxqty = 0;
            if(!is_null($compbran)){
                $branddesmax = $compbran->name;
                $brandmaxqty = $brandqtyarr[$maxbrandkey];
            }           
            
            $maxcategory = 0;
            $maxcategorykey = 0;
            $mincategory = 10000000000;
            $mincategorykey = 0;
            foreach ($categoryarr as $key => $value) {
                if($categoryarr[$key] > $maxcategory){
                    $maxcategory = $categoryarr[$key];
                    $maxcategorykey = $key;
                }
                
                if($categoryarr[$key] < $mincategory){
                    $mincategory = $categoryarr[$key];
                    $mincategorykey = $key;
                }               
            }   

            $categorydesmin = "";
            $categoryminqty = 0;
            $compcategory = DB::table('category')->where('id',$mincategorykey)->first();
            
            if(!is_null($compcategory)){
                $categorydesmin = $compcategory->description;
                $categoryminqty = $categoryqtyarr[$mincategorykey];
            }   
            
            $categorydesmax = "";
            $categorymaxqty = 0;
            $compcategory = DB::table('category')->where('id',$maxcategorykey)->first();
            if(!is_null($compcategory)){
                $categorydesmax = $compcategory->description;
                $categorymaxqty = $categoryqtyarr[$maxcategorykey];
            }               
            
            $maxsubcategory = 0;
            $maxsubcategorykey = "0-1";
            $minsubcategory = 10000000000;
            $minsubcategorykey = "0-1";
            foreach ($subcategoryarr as $key => $value) {
                if($subcategoryarr[$key] > $maxsubcategory){
                    $maxsubcategory = $subcategoryarr[$key];
                    $maxsubcategorykey = $key;
                }
                
                if($subcategoryarr[$key] < $minsubcategory){
                    $minsubcategory = $subcategoryarr[$key];
                    $minsubcategorykey = $key;
                }               
            }           
            
            $subcategorydesmin = "";
            $subcategoryminqty = 0;
            $keyarr = explode("-",$minsubcategorykey);
            $compsubcategory = DB::table('subcat_level_' . $keyarr[1])->where('id',$keyarr[0])->first();
            if(!is_null($compsubcategory)){
                $subcategorydesmin = $compsubcategory->description;
                $subcategoryminqty = $subcategoryqtyarr[$minsubcategorykey];
            }   
            
            $subcategorydesmax = "";
            $subcategorymaxqty = 0;
            $keyarr = explode("-",$maxsubcategorykey);
            $compsubcategory = DB::table('subcat_level_' . $keyarr[1])->where('id',$keyarr[0])->first();
            if(!is_null($compsubcategory)){
                $subcategorydesmax = $compsubcategory->description;
                $subcategorymaxqty = $subcategoryqtyarr[$maxsubcategorykey];
            }               
            
            $date1 = new DateTime($fromDate);
            $date2 = new DateTime($toDate);
            // dd("xzcf");

            // $res['data']=
            /***********************Zurez***********************************/ 
            try {

                $dayMagic=$this->getStartDate($request->merchant_id,"merchant");
                $daysSinceCreation=$dayMagic[0];
                $brandPerformance=$this->getMerchantBrandPerformance($request->merchant_id); 
                $productPerformance=$this->getMerchantProductPerformance($request->merchant_id);
                $categoryPerformance=$this->getMerchantCategoryPerformance($request->merchant_id);

                $subcatPerformance=$this->getMerchantSubCatPerformance($request->merchant_id);
                //$wtdPerformance=$this->getMerchantWTDPerformance($request->merchant_id);
                $ytdPerformance=$this->getMerchantYTDPerformance($request->merchant_id);
                if(empty($ytdPerformance))
                    {
                        $ytdPerformance =[(object)
                        array("ordercount"=>0,
                        "sales"=>0,
                        "sales_quantity"=>0,
                        "month"=>1,
                        "day"=>1,

                        "name"=>"Not Available",
                        "description"=>"",
                        )];
                    }
                if($type == "daily")
                {
                    $dayPerformance=$this->getMerchantDayPerformance($request->merchant_id);

                    if(empty($dayPerformance))
                	{
	                	$dayPerformance =[(object)
                    	array("ordercount"=>0,
                    	"sales"=>0,
                    	"sales_quantity"=>0,
                    	"month"=>1,
                    	"day"=>1,

                    	"name"=>"Not Available",
                    	"description"=>"",
                    	)];
                	}
                }
                if($type == 'weekly')
                {
                    $weekPerformance=$this->getMerchantWeeklyPerformance($request->merchant_id);
                    if(empty($weekPerformance))
                	{
	                	$weekPerformance =[(object)
                    	array("ordercount"=>0,
                    	"sales"=>0,
                    	"sales_quantity"=>0,
                    	"month"=>1,
                    	"day"=>1,

                    	"name"=>"Not Available",
                    	"description"=>"",
                    	)];
                	}

                    
                }

                // Below line can be optimised for duplicacy ~Zurez
                if($type == 'mtd')
                {
                	$mtdPerformance=$this->getMerchantMTDPerformance($request->merchant_id);
                	if(empty($mtdPerformance))
                	{
	                	$mtdPerformance =[(object)
                    	array("ordercount"=>0,
                    	"sales"=>0,
                    	"sales_quantity"=>0,
                    	"month"=>1,
                    	"day"=>1,

                    	"name"=>"Not Available",
                    	"description"=>"",
                    	)];
                	}
                }

                $sincePerformance=$this->getMerchantSincePerformance($request->merchant_id);

                //$hourPerformance=$this->getMerchantHourlyPerformance($request->merchant_id);
                

                //dd($brandPerformance);
                $maxBrand=$this->maxKV($brandPerformance,"sales");
                $minBrand=$this->minKV($brandPerformance,"sales");
                $maxProduct=$this->maxKV($productPerformance,"sales");
                $minProduct=$this->minKV($productPerformance,"sales");
                $maxCategory=$this->maxKV($categoryPerformance,"sales");
                $minCategory=$this->minKV($categoryPerformance,"sales");
                $maxSubCat=$this->maxKV($subcatPerformance,"sales");
                $minSubCat=$this->minKV($subcatPerformance,"sales");
                /*$totalWTDPayment=$this->totalKV($wtdPerformance,"sales");
                $totalWTDDeals=$this->totalKV($wtdPerformance,"ordercount");*/

                $totalSincePayment=$this->totalKV($sincePerformance,"sales");
                $totalSinceDeals=$this->totalKV($sincePerformance,"ordercount");

                $totalYTDPayment=$this->totalKV($ytdPerformance,"sales");
                $totalYTDDeals=$this->totalKV($ytdPerformance,"ordercount");
                $totalMTDPayment=$this->totalKV($mtdPerformance,"sales");
                $totalMTDDeals=$this->totalKV($mtdPerformance,"ordercount");
                $totalDayPayment=$this->totalKV($dayPerformance,"sales");
                $totalDayDeals=$this->totalKV($dayPerformance,"ordercount");
                $totalWTDPayment=$this->totalKV($weekPerformance,"sales");
                $totalWTDDeals=$this->totalKV($weekPerformance,"ordercount");

                //$totalHourPayment =$this->totalKV($hourPerformance,"sales");
                //$totalHourDeals =$this->totalKV($hourPerformance,"ordercount");
                //dd("B");
            } catch (\Exception $e) {

                
               // dd($e);
                $brandPerformance=
                $productPerformance=
                $categoryPerformance=
                $subcatPerformance=
                //$wtdPerformance=
                //$ytdPerformance=
                //$mtdPerformance=
                $sincePerformance=
               // $dayPerformance=
                [  (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    )];
                $maxBrand=
                $minBrand=
                $maxProduct=
                $minProduct=
                $maxCategory=
                $minCategory=
                $maxSubCat=
                $minSubCat=
                
               (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    );
                    
                $totalWTDPayment=
                $totalWTDDeals=
                $totalSincePayment= 
                $totalSinceDeals=
                $totalYTDPayment= 
                $totalYTDDeals= 
                $totalMTDPayment=
                $totalMTDDeals=
                $totalDayPayment=
                //$totalWeelPayment=
                //$totalWeekDeals=
                //$totalHourPayment=
                //$totalHourDeals=

                $totalDayDeals=0;
            }
            /*************************************/ 
            /*if ($request->type == "since") {
                /*echo "<pre>";
                print_r($sincePerformance);
                exit;*/
                /*$yAxis=$this->initYAxis("since");
               
                foreach ($sincePerformance as $salesArray) {
                    $yAxis[$salesArray->year-1]=intval($salesArray->sales);
                    // array_push($xAxis,$salesArray->month);
                   
                }
                $res['data']=$yAxis;
            }*/

            if ($request->type == "ytd" or ($request->type == "since" and $dayMagic[1] == "ytd")) {

                $yAxis=$this->initYAxis("ytd");
               
                foreach ($ytdPerformance as $salesArray) {
                    $yAxis[$salesArray->month-1]=intval($salesArray->sales);
                    // array_push($xAxis,$salesArray->month);
                }
                $res['data']=$yAxis;
            }
            elseif ($request->type == "mtd" or ($request->type == "since" and $dayMagic[1] == "ytd")) {
                
                $yAxis=$this->initYAxis("mtd");
                /*echo "<pre>";
                print_r($mtdPerformance);
                exit;*/
                foreach ($mtdPerformance as $salesArray) {
                   /* echo "<pre>";
                    print_r($salesArray->DATE);*/
                    $yAxis[]=intval($salesArray->sales);
                   // $yAxis[$salesArray->day-1]=intval($salesArray->sales);
                    // array_push($xAxis,$salesArray->month);
                }
                //exit;
                $res['data']=$yAxis;
            }
             elseif ($request->type == "wtd") {
                
                //$yAxis=$this->initYAxis("wtd");
                foreach ($weekPerformance as $salesArray) {
                   /* echo "<pre>";
                    print_r($salesArray->DATE);*/
                    //$yAxis[]=intval($salesArray->sales);
                    
                    //$yAxis[]=intval($salesArray->sales);
                    
                    $yAxis[]=intval($salesArray->sales);
                 //  array_push($xAxis,$salesArray->month);
                   
                }
                //exit;

                $res['data']=$yAxis;
            }
            elseif ($request->type == "daily") {
                
               //$yAxis=$this->initYAxis("daily");

               foreach ($dayPerformance as $salesArray) {
                     /* echo "<pre>";
                    print_r($salesArray->DATE);*/
                    //$yAxis[]=intval($salesArray->sales);
                    $yAxis[]=intval($salesArray->sales);
                    // array_push($xAxis,$salesArray->month);
                   
                }
                //exit;

                $res['data']=$yAxis;
            }
            /*elseif ($request->type == "wtd" or ($request->type == "since" and $dayMagic[1] == "wtd")) {
                //$yAxis=$this->initYAxis("wtd");
                foreach ($weekPerformance as $salesArray) {
                    $yAxis[]=intval($salesArray->sales);
                    // array_push($xAxis,$salesArray->month);
                }
                $res['data']=$yAxis;
            }*/
            $diff = $date2->diff($date1)->format("%a");
            $res['maxsubcategory'] = number_format($maxSubCat->sales/100,2);
            $res['subcategorymaxqty'] = $maxSubCat->sales_quantity;
            $res['maxsubcategorydesc'] = $maxSubCat->name;
            $res['subcategoryminqty'] = $minSubCat->sales_quantity;
            $res['minsubcategory'] = number_format($minSubCat->sales/100,2);
            $res['minsubcategorydesc'] = $minSubCat->name;
            $res['maxcategory'] = number_format($maxCategory->sales/100,2);
            $res['categorymaxqty'] =$maxCategory->sales_quantity;
            $res['maxcategorydesc'] = $maxCategory->name;
            // Worst Cat Total Sales Amount
            $res['mincategory'] =number_format($minCategory->sales/100,2);
            // Worst Cat Performer Count
            $res['categoryminqty'] = $minCategory->sales_quantity;
            // Worst Category Description
            $res['mincategorydesc'] = $minCategory->name;
            $res['maxbrand'] =number_format($maxBrand->sales/100,2);
            $res['brandmaxqty'] = $maxBrand->sales_quantity;
            $res['maxbranddesc'] = $maxBrand->description;
            $res['minbrand'] =number_format($minBrand->sales/100,2);
            $res['brandminqty'] = $minBrand->sales_quantity;
            $res['minbranddesc'] = $minBrand->name;
            $res['maxprod'] =number_format($maxProduct->sales/100,2);
            $res['prodmaxqty'] = $maxProduct->sales_quantity;
            $res['maxproddesc'] = $maxProduct->name;
            $res['minprod'] = number_format($minProduct->sales/100,2);
            $res['prodminqty'] = $minProduct->sales_quantity;
            $res['minproddesc'] = $minProduct->name;
            
            
            $res['totalPaymenttoday'] =number_format($totalDayPayment/100,2);
            $res['totalDealstoday'] = $totalDayDeals;
            $res['totalPaymentwtd'] = number_format($totalWTDPayment/100,2);
            $res['totalDealswtd'] = $totalWTDDeals;         
            $res['totalPaymentmtd'] = number_format($totalMTDPayment/100,2);
            $res['totalDealsmtd'] = $totalMTDDeals;
            $res['totalPaymentytd'] = number_format($totalYTDPayment/100,2);
            $res['totalDealsytd'] = $totalYTDDeals;
            /*$res['totalPaymentWeek'] = number_format($totalWeelPayment/100,2);
            $res['totalDealsWeek'] = $totalWeekDeals;*/
            //$res['totalPaymentHour'] = number_format($totalHourPayment/100,2);
            //$res['totalDealsHour'] = $totalHourDeals;
            
            
            try {
                $res['averagePerDay'] =number_format($totalSincePayment/($daysSinceCreation*100),3);
                $res['averagePerDeal']=number_format($totalSincePayment/($totalSinceDeals*100),3);
            } catch (\Exception $e) {
                $res['averagePerDeal']=0;
                $res['averagePerDay']=0;
            } 
            $res['totalDeals'] = $totalSinceDeals;
            $res['totalSales'] =number_format($totalSincePayment/100,2);
            $res['view'] = $merchants;
            $res['success'] = true;
            $res['message'] = 'Request successfully completed';
            $res['xaxis_categories'] = $xaxis_categories;
            
            return Response::json(array(
                    $res
                )); 
        }
    }
    
    public function getStationDataTotal(Request $request, $filter)
    {           
        $performace = [];
        if($filter == "today"){
            $performance=$this->getStationDayPerformance($request->station_id);
        } else if($filter == "week"){
            $performance=$this->getStationWTDPerformance($request->station_id);
        } else if($filter == "month"){
            $performance=$this->getStationMTDPerformance($request->station_id);
        } else if($filter == "year"){
            $performance=$this->getStationYTDPerformance($request->station_id);
        } else {
            $performance=$this->getStationSincePerformance($request->station_id);
        }
        return Response::json($performance);
    }
    
    public function getStationData(Request $request)
    {
        if(!Input::exists("station_id"))
        {
            $data['success'] = false;
            $data['message'] = 'Parameters passed incorrect';
            return Response::json(array(
                    $data
                )); 
        }
        if($request->ajax())
        {
            if(!Input::exists("from_date") || !Input::exists("to_date") || !Input::exists("country") || !Input::exists("state") || !Input::exists("city") || !Input::exists("marea") || !Input::exists("product") || !Input::exists("brand") || !Input::exists("category") || !Input::exists("subcategory"))
            {
                $res['success'] = false;
                $res['message'] = 'Parameters passed incorrect';
                return Response::json(array(
                        $res
                    )); 
            }
            $this->getValidations($request);
            $country = Input::get("country");
            $state = Input::get("state");
            $city = Input::get("city");
            $area = Input::get("marea");
            $consumer = Input::get("consumer");
            $fromDate = Input::get("from_date");
            $toDate = Input::get("to_date");
            $fromDate = date("Y-m-d", strtotime($fromDate));
            $toDate = date("Y-m-d", strtotime($toDate));
            $id = Input::get("station_id");
            $global = DB::table('global')->first();
            $res['data'] = array();
            $totalPayment = 0;
            $currmonth = 0;
            $prodarr = array();
            $prodqtyarr = array();
            $brandarr = array();
            $brandqtyarr = array();
            $categoryarr = array();
            $categoryqtyarr = array();
            $subcategoryarr = array();
            $subcategoryqtyarr = array();       
            $mkfromDate = Input::get("from_date");
            $mktoDate = Input::get("to_date");
            $dated1 = mktime(0,0,0,date("n", strtotime($mkfromDate)),date("j", strtotime($mkfromDate)),date("Y", strtotime($mkfromDate))); // m d y, use 0 for day
            $dated2 = mktime(0,0,0,date("n", strtotime($mktoDate)),date("j", strtotime($mktoDate)),date("Y", strtotime($mktoDate))); // m d y, use 0 for day

            $realdif = (($dated2-$dated1) / 60 / 60 / 24 / 30);
            if($realdif > 24){
                $realdif = 24;
            }
            $months = array(0 => "Jan",1 => "Feb",2 => "Mar",3 => "Apr",4 => "May",5 => "Jun",6 => "Jul",7 => "Aug",8 => "Sep",9 => "Oct",10 => "Nov",11 => "Dec");         
            $xaxis_categories = Array();
            $d = date_parse_from_format("Y-m-d", $fromDate);
            $init_month = $d["month"];          
            $init_year = substr($d["year"],-2);         
            //$index = 0;
            for($i = 0; $i < ($realdif); $i++){
                $res['data'][$i] = 0;
                $xaxis_categories[$i] = $months[$init_month - 1] . " " . $init_year;
                $init_month++;
                if($init_month == 13){
                    $init_month = 1;
                    $init_year++;
                }
            }
            $countryq = "";
            if($country != ""){
               $countryq = " AND co.id = " . $country . " ";
            }
            $stateq = "";
            if($state != ""){
                $stateq = " AND s.id = " . $state . " ";
            }
            $cityq = "";
            if($city != ""){
                $cityq = " AND ci.id = " . $city . " ";
            }
            $areaq = "";
            if($area != ""){
                $areaq = "";
            }
            
            
            $stations=DB::select(DB::raw("SELECT MONTH(date(po.updated_at)) as currmonth, YEAR(date(po.updated_at)) as curryear,date(po.updated_at) as consignment,c.code as currency, po.id as poid, m.id as mid,m.user_id as user_id, m.company_name as company, m.station_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, SUM((op.order_price * op.quantity)) as net_payable, 
                    m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
                    m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, m.commission_type as commission_type, m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, m.b2b_osmall_commission as b2b_osmall_commission,
                    DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM station m, payment p, porder po, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c, users u, city ci, state s, country co, address a WHERE c.active = 1 AND po.status IN (".$this->cStatus.") and p.id = po.payment_id and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id AND po.user_id = u.id AND u.shipping_address_id = a.id AND a.city_id = ci.id AND ci.state_code = s.code AND s.country_code = co.code AND m.id = ".$id." " . $countryq . " " . $stateq . " " . $cityq . " AND m.id = ".$id."
                    and op.product_id = pro.id GROUP BY po.id ORDER BY p.created_at DESC"));
                    $totalPaymenttoday = 0;
                    $totalDealstoday = 0;
                    $totalPaymentmtd = 0;
                    $totalPaymentwtd = 0;
                    $totalPaymentytd = 0;
                    $totalDealswtd = 0;
                    $totalDealsmtd = 0;
                    $totalDealsytd = 0; 
                    $totalDeals = 0;    
                    $curri = 0; 
                    $currmonth = date("m", strtotime(Input::get('from_date')));
                    $curryear = date("Y", strtotime(Input::get('from_date')));
                     foreach ($stations as $merchant) {
                        $mpayable = 0;
                        $payable = 0;
                        $product = Input::get("product");
                        $brand = Input::get("brand");
                        $category = Input::get("category");
                        $subcategory = Input::get("subcategory");   
                        $channel = Input::get("channel");                       
                        $productq = "";
                        $subcategoryq = "";
                        if($subcategory != ""){
                            if($product != ""){
                                $productq = " AND pro.subcat_id = " . $product . " AND pro.subcat_level = 2 ";
                            } else {
                                $subcategoryq = " AND pro.subcat_id = " . $subcategory . " AND pro.subcat_level = 1 ";
                            }
                        }   
                        $brandq = "";
                        if($brand != ""){
                            $brandq = " AND pro.brand_id = " . $brand . " ";
                        }
                        $categoryq = "";
                        if($category != ""){
                            $categoryq = " AND pro.category_id = " . $category . " ";
                        }
                        $channelq = "";
                        if($channel != ""){
                            if($channel == 'all2loc')
                            {
                                $channelData = DB::table('fairlocation')->where('user_id', '378')->get();
                                $i = 0;
                                foreach ($channelData as $value) {
                                    if($value->code != '' )
                                    {
                                        $locationList[$i] = $value->code;
                                        $i++;    
                                    }
                                }
                                
                                $finalChannel = implode(",", $locationList);

                                $channelq = " AND pro.segment IN ('" . $finalChannel . "')";
                               /* echo $channelql;
                                exit;*/
                                
                            }
                            else
                            {
                                $channelq = " AND pro.segment = '" . $channel . "' ";
                            }
                           // $channelq = " AND pro.segment = '" . $channel . "' ";
                        }                   
                        $orderps = DB::select(DB::raw("
                            SELECT c.code as currency,
                            op.id as opid,
                            po.id as poid,
                            m.id as mid,
                            m.user_id as user_id,
                            m.company_name as company,
                            op.order_price as order_price,
                            op.quantity as quantity,
                            op.order_delivery_price as order_delivery_price,
                            m.station_name as name, 
                            op.osmall_comm_amount as commission_sv, 
                           m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission, pro.segment as segment, pro.osmall_commission as osmall_commission, pro.b2b_osmall_commission as b2b_osmall_commission,
                    m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, m.commission_type as commission_type, m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, pro.id as proid, pro.brand_id as brandid, pro.category_id as categoryid, pro.subcat_id as subcatid, pro.subcat_level as slevel, m.b2b_osmall_commission as b2b_osmall_commission,
                    DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source, p.id as paid, so.id as soid, c.id as cid, mp.id mpid, sp.id as spid FROM station m, payment p, porder po, sorder so, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c WHERE c.active = 1 and po.updated_at >= '".$fromDate." 00:00:00' and po.updated_at <= '".$toDate." 23:59:59' and p.id = po.payment_id " . $productq . " " . $brandq . " " . $categoryq . " " . $subcategoryq . " " . $channelq . " and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id AND po.id = ".$merchant->poid." AND so.porder_id = po.id AND mp.station_id = ".$merchant->mid."
                    and op.product_id = pro.id ORDER BY p.created_at DESC"));

                        if($merchant->commission_type != "std" && $merchant->commission_type != "var" ){
                            $commission_type=$global->commission_type;
                        } else {
                            $commission_type=$merchant->commission_type;
                        }                   
                        if($merchant->b2b_commission_type != "std" && $merchant->b2b_commission_type != "var" ){
                            $b2b_commission_type=$global->b2b_commission_type;
                        } else {
                            $b2b_commission_type=$merchant->b2b_commission_type;
                        }                       
                        $mc_pay = 0;
                        if($merchant->mc_id > 0){
                            if($merchant->mc_commission > 0){
                                $mc_pay = $merchant->mc_commission;
                            } else {
                                $mc_pay = $global->mc_sales_staff_commission;
                            }
                        }
                        $referral_pay = 0;
                        if($merchant->referral_id > 0){
                            if($merchant->referral_commission > 0){
                                $referral_pay = $merchant->referral_commission;
                            } else {
                                $referral_pay = $global->referral_sales_staff_commission;
                            }
                        }
                        $mcp1_pay = 0;
                        if($merchant->mcp1_id > 0){
                            if($merchant->mcp1_commission > 0){
                                $mcp1_pay = $merchant->mcp1_commission;
                            } else {
                                $mcp1_pay = $global->mcp1_sales_staff_commission;
                            }
                        }                                                           
                        $mcp2_pay = 0;
                        if($merchant->mcp2_id > 0){
                            if($merchant->mcp2_commission > 0){
                                $mcp2_pay = $merchant->mcp2_commission;
                            } else {
                                $mcp2_pay = $global->mcp2_sales_staff_commission;
                            }
                        }       
                        $gateway_pay = $global->payment_gateway_commission;
                        $logistic_pay = $global->logistic_commission;
                        // dd($orderps);
                        foreach ($orderps as $orderp) {
                            
                            $commission = 0;
                            if($orderp->segment == 'b2b'){
                                if($b2b_commission_type == 'std'){
                                    if($merchant->b2b_osmall_commission == null || is_null($merchant->b2b_osmall_commission) || $merchant->b2b_osmall_commission == "null" || $merchant->b2b_osmall_commission == "" || $merchant->b2b_osmall_commission == 0){
                                        $commission = $global->b2b_osmall_commission;
                                    } else {
                                        $commission = $merchant->b2b_osmall_commission;
                                    }
                                } else {
                                    if($orderp->b2b_osmall_commission == null || is_null($orderp->b2b_osmall_commission) || $orderp->b2b_osmall_commission == "null" || $orderp->b2b_osmall_commission == "" || $orderp->b2b_osmall_commission == 0){
                                        if($merchant->b2b_osmall_commission == null || is_null($merchant->b2b_osmall_commission) || $merchant->b2b_osmall_commission == "null" || $merchant->b2b_osmall_commission == "" || $merchant->b2b_osmall_commission == 0){
                                            $commission = $global->b2b_osmall_commission;
                                        } else {
                                            $commission = $merchant->b2b_osmall_commission;
                                        }
                                     } else {
                                         $commission = $orderp->b2b_osmall_commission;
                                     }
                                }
                            } else {
                                if($commission_type == 'std'){
                                    if($merchant->osmall_commission == null || is_null($merchant->osmall_commission) || $merchant->osmall_commission == "null" || $merchant->osmall_commission == "" || $merchant->osmall_commission == 0){
                                        $commission = $global->osmall_commission;
                                    } else {
                                        $commission = $merchant->osmall_commission;
                                    }
                                } else {
                                    if($orderp->osmall_commission == null || is_null($orderp->osmall_commission) || $orderp->osmall_commission == "null" || $orderp->osmall_commission == "" || $orderp->osmall_commission == 0){
                                        if($merchant->osmall_commission == null || is_null($merchant->osmall_commission) || $merchant->osmall_commission == "null" || $merchant->osmall_commission == "" || $merchant->osmall_commission == 0){
                                            $commission = $global->osmall_commission;
                                        } else {
                                            $commission = $merchant->osmall_commission;
                                        }
                                     } else {
                                         $commission = $orderp->osmall_commission;
                                     }
                                }                               
                            }
                            $mipayable = $orderp->net_payable;  
                            // dd($mipayable);
                            $mpayable += $mipayable;    
                            $npayable = $orderp->net_payable;
                            $payable += $npayable;       
                            if (array_key_exists($orderp->proid, $prodarr)) {
                                $prodarr[$orderp->proid] += $payable/100;
                                $prodqtyarr[$orderp->proid] += $orderp->quantity;
                            } else {
                                $prodarr[$orderp->proid] = $payable/100;
                                $prodqtyarr[$orderp->proid] = $orderp->quantity;
                            }
                            
                            if (array_key_exists($orderp->brandid, $brandarr)) {
                                $brandarr[$orderp->brandid] += $payable/100;
                                $brandqtyarr[$orderp->brandid] += $orderp->quantity;
                            } else {
                                $brandarr[$orderp->brandid] = $payable/100;
                                $brandqtyarr[$orderp->brandid] = $orderp->quantity;
                            }   

                            if (array_key_exists($orderp->categoryid, $categoryarr)) {
                                $categoryarr[$orderp->categoryid] += $payable/100;
                                $categoryqtyarr[$orderp->categoryid] += $orderp->quantity;
                            } else {
                                $categoryarr[$orderp->categoryid] = $payable/100;
                                $categoryqtyarr[$orderp->categoryid] = $orderp->quantity;
                            }   

                            if (array_key_exists($orderp->subcatid . "-" . $orderp->slevel , $subcategoryarr)) {
                                $subcategoryarr[$orderp->subcatid . "-" . $orderp->slevel] += $payable/100;
                                $subcategoryqtyarr[$orderp->subcatid . "-" . $orderp->slevel] += $orderp->quantity;
                            } else {
                                $subcategoryarr[$orderp->subcatid . "-" . $orderp->slevel] = $payable/100;
                                $subcategoryqtyarr[$orderp->subcatid . "-" . $orderp->slevel] = $orderp->quantity;
                            }                           
                        }
                        $merchant->mpayable = $mpayable;                        
                        $merchant->payable = $payable;  
                        if($currmonth == $merchant->currmonth && $curryear == $merchant->curryear){
                            
                        } else {
                            if($curryear == $merchant->curryear){
                                $curri = $curri + ($merchant->currmonth - $currmonth);
                            } else {
                                $curri = $curri + ((12 + $merchant->currmonth) - $currmonth);

                            }
                            $currmonth = $merchant->currmonth;
                            $curryear = $merchant->curryear;
                        }
                        if(isset($res['data'][$curri])){
                            $res['data'][$curri] += floatval(round($merchant->payable/100,2));
                        } else {
                            $res['data'][$curri] = floatval(round($merchant->payable/100,2));
                        }
                        $totalPayment+= $merchant->payable/100;
                        $totalDeals++;
                        $thisW = date("W", strtotime($merchant->consignment));
                        if($thisW == date('W') && $curryear == date('Y') && $payable > 0){
                            $totalPaymentwtd+= $merchant->payable/100;
                            $totalDealswtd++;
                        }                       
                        if($merchant->consignment == date('Y-m-d') && $payable > 0){
                            $totalPaymenttoday+= $merchant->payable/100;
                            $totalDealstoday++;
                        } 
                        if($merchant->currmonth == date('m') && $curryear == date('Y') && $payable > 0){
                            $totalPaymentmtd+= $merchant->payable/100;
                            $totalDealsmtd++;
                        }
                        if($curryear == date('Y') && $payable > 0){
                            $totalPaymentytd+= $merchant->payable/100;
                            $totalDealsytd++;
                        }
                     }              
            $maxprod = 0;
            $maxprodkey = 0;
            $minprod = 10000000000;
            $minprodkey = 0;
            foreach ($prodarr as $key => $value) {
                if($prodarr[$key] > $maxprod){
                    $maxprod = $prodarr[$key];
                    $maxprodkey = $key;
                }
                
                if($prodarr[$key] < $minprod){
                    $minprod = $prodarr[$key];
                    $minprodkey = $key;
                }               
            }
            if($minprod == 10000000000){
                $minprod = 0;
            }
            $productdescmin = "";
            $prodminqty = 0;
            $compproduct = DB::table('product')->where('id',$minprodkey)->first();
            if(!is_null($compproduct)){
                $productdescmin = $compproduct->name;
                $prodminqty = $prodqtyarr[$minprodkey];
            }
            
            $productdescmax = "";
            $prodmaxqty = 0;
            $compproduct = DB::table('product')->where('id',$maxprodkey)->first();
            if(!is_null($compproduct)){
                $productdescmax = $compproduct->name;
                $prodmaxqty = $prodqtyarr[$maxprodkey];
            }           
            
            $maxbrand = 0;
            $maxbrandkey = 0;
            $minbrand = 10000000000;
            $minbrandkey = 0;
            foreach ($brandarr as $key => $value) {
                if($brandarr[$key] > $maxbrand){
                    $maxbrand = $brandarr[$key];
                    $maxbrandkey = $key;
                }
                
                if($brandarr[$key] < $minbrand){
                    $minbrand = $brandarr[$key];
                    $minbrandkey = $key;
                }               
            }       
            if($minbrand == 10000000000){
                $minbrand = 0;
            }
            $branddesmin = "";
            $brandminqty = 0;
            $compbran = DB::table('brand')->where('id',$minbrandkey)->first();
            if(!is_null($compbran)){
                $branddesmin = $compbran->name;
                $brandminqty = $brandqtyarr[$minbrandkey];
            }
            
            $branddesmax = "";
            $compbran = DB::table('brand')->where('id',$maxbrandkey)->first();
            $brandmaxqty = 0;
            if(!is_null($compbran)){
                $branddesmax = $compbran->name;
                $brandmaxqty = $brandqtyarr[$maxbrandkey];
            }           
            
            $maxcategory = 0;
            $maxcategorykey = 0;
            $mincategory = 10000000000;
            $mincategorykey = 0;
            
            foreach ($categoryarr as $key => $value) {
                if($categoryarr[$key] > $maxcategory){
                    $maxcategory = $categoryarr[$key];
                    $maxcategorykey = $key;
                }
                
                if($categoryarr[$key] < $mincategory){
                    $mincategory = $categoryarr[$key];
                    $mincategorykey = $key;
                }               
            }   
            if($mincategory == 10000000000){
                $mincategory = 0;
            }
            $categorydesmin = "";
            $categoryminqty = 0;
            $compcategory = DB::table('category')->where('id',$mincategorykey)->first();
            
            if(!is_null($compcategory)){
                $categorydesmin = $compcategory->description;
                $categoryminqty = $categoryqtyarr[$mincategorykey];
            }   
            
            $categorydesmax = "";
            $categorymaxqty = 0;
            $compcategory = DB::table('category')->where('id',$maxcategorykey)->first();
            if(!is_null($compcategory)){
                $categorydesmax = $compcategory->description;
                $categorymaxqty = $categoryqtyarr[$maxcategorykey];
            }               
            
            $maxsubcategory = 0;
            $maxsubcategorykey = "0-1";
            $minsubcategory = 10000000000;
            $minsubcategorykey = "0-1";
            foreach ($subcategoryarr as $key => $value) {
                if($subcategoryarr[$key] > $maxsubcategory){
                    $maxsubcategory = $subcategoryarr[$key];
                    $maxsubcategorykey = $key;
                }
                
                if($subcategoryarr[$key] < $minsubcategory){
                    $minsubcategory = $subcategoryarr[$key];
                    $minsubcategorykey = $key;
                }               
            }           
            if($minsubcategory == 10000000000){
                $minsubcategory = 0;
            }           
            $subcategorydesmin = "";
            $subcategoryminqty = 0;
            $keyarr = explode("-",$minsubcategorykey);
            $compsubcategory = DB::table('subcat_level_' . $keyarr[1])->where('id',$keyarr[0])->first();
            if(!is_null($compsubcategory)){
                $subcategorydesmin = $compsubcategory->description;
                $subcategoryminqty = $subcategoryqtyarr[$minsubcategorykey];
            }   
            
            $subcategorydesmax = "";
            $subcategorymaxqty = 0;
            $keyarr = explode("-",$maxsubcategorykey);
            $compsubcategory = DB::table('subcat_level_' . $keyarr[1])->where('id',$keyarr[0])->first();
            if(!is_null($compsubcategory)){
                $subcategorydesmax = $compsubcategory->description;
                $subcategorymaxqty = $subcategoryqtyarr[$maxsubcategorykey];
            }
            //zzzz
            $date1 = new DateTime($fromDate);
            $date2 = new DateTime($toDate);
            
            $diff = $date2->diff($date1)->format("%a");

            /****************ZUREZ*****************/
            try {
            $dayMagic=$this->getStartDate($request->station_id,"station");
            $daysSinceCreation=$dayMagic[0];
            $brandPerformance=$this->getStationBrandPerformance($request->station_id);
            $productPerformance=$this->getStationProductPerformance($request->station_id);
            $categoryPerformance=$this->getStationCategoryPerformance($request->station_id);
            $subcatPerformance=$this->getStationSubCatPerformance($request->station_id);
            $wtdPerformance=$this->getStationWTDPerformance($request->station_id);
            $ytdPerformance=$this->getStationYTDPerformance($request->station_id);
            // Below line can be optimised for duplicacy ~Zurez
            $mtdPerformance=$this->getStationMTDPerformance($request->station_id);
            $sincePerformance=$this->getStationSincePerformance($request->station_id);
            $dayPerformance=$this->getStationDayPerformance($request->station_id);
            $maxBrand=$this->maxKV($brandPerformance,"sales");
            $minBrand=$this->minKV($brandPerformance,"sales");
            $maxProduct=$this->maxKV($productPerformance,"sales");
            $minProduct=$this->minKV($productPerformance,"sales");
            $maxCategory=$this->maxKV($categoryPerformance,"sales");
            $minCategory=$this->minKV($categoryPerformance,"sales");
            $maxSubCat=$this->maxKV($subcatPerformance,"sales");
            $minSubCat=$this->minKV($subcatPerformance,"sales");
            $totalWTDPayment=$this->totalKV($wtdPerformance,"sales");
            $totalWTDDeals=$this->totalKV($wtdPerformance,"ordercount");
            $totalSincePayment=$this->totalKV($sincePerformance,"sales");
            $totalSinceDeals=$this->totalKV($sincePerformance,"ordercount");
            $totalYTDPayment=$this->totalKV($ytdPerformance,"sales");
            $totalYTDDeals=$this->totalKV($ytdPerformance,"ordercount");
            $totalMTDPayment=$this->totalKV($mtdPerformance,"sales");
            $totalMTDDeals=$this->totalKV($mtdPerformance,"ordercount");
            $totalDayPayment=$this->totalKV($dayPerformance,"sales");
            $totalDayDeals=$this->totalKV($dayPerformance,"ordercount");
           

            } catch (\Exception $e) {
                $brandPerformance=
                $productPerformance=
                $categoryPerformance=
                $subcatPerformance=
                $wtdPerformance=
                $ytdPerformance=
                $mtdPerformance=
                $sincePerformance=
                $dayPerformance=
                [  (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    )];
                $maxBrand=
                $minBrand=
                $maxProduct=
                $minProduct=
                $maxCategory=
                $minCategory=
                $maxSubCat=
                $minSubCat=
                (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    );
                $totalWTDPayment=
                $totalWTDDeals=
                $totalSincePayment= 
                $totalSinceDeals=
                $totalYTDPayment= 
                $totalYTDDeals= 
                $totalMTDPayment=
                $totalMTDDeals=
                $totalDayPayment=
                $totalDayDeals=0;

            }


            /**************************************/ 
              if ($request->type == "ytd" or ($request->type=="since" and $dayMagic[1] == "ytd")) {
                
               
                $yAxis=$this->initYAxis("ytd");
               
                foreach ($ytdPerformance as $salesArray) {
                    $yAxis[$salesArray->month-1]=intval($salesArray->sales);
                    // array_push($xAxis,$salesArray->month);
                   
                }
             
                
                $res['data']=$yAxis;
            }
            elseif ($request->type == "mtd" or ($request->type=="since" and $dayMagic[1] == "mtd")) {
                
                $yAxis=$this->initYAxis("mtd");

                foreach ($mtdPerformance as $salesArray) {
                    $yAxis[$salesArray->day-1]=intval($salesArray->sales);
                    // array_push($xAxis,$salesArray->month);
                   
                }
                $res['data']=$yAxis;
            }
         
            $diff = $date2->diff($date1)->format("%a");
            $res['maxsubcategory'] = number_format($maxSubCat->sales/100,2);
            $res['subcategorymaxqty'] = $maxSubCat->sales_quantity;
            $res['maxsubcategorydesc'] = $maxSubCat->name;
            $res['subcategoryminqty'] = $minSubCat->sales_quantity;
            $res['minsubcategory'] = number_format($minSubCat->sales/100,2);
            $res['minsubcategorydesc'] = $minSubCat->name;
            $res['maxcategory'] = number_format($maxCategory->sales/100,2);
            $res['categorymaxqty'] =$maxCategory->sales_quantity;
            $res['maxcategorydesc'] = $maxCategory->name;
            // Worst Cat Total Sales Amount
            $res['mincategory'] =number_format($minCategory->sales/100,2);
            // Worst Cat Performer Count
            $res['categoryminqty'] = $minCategory->sales_quantity;
            // Worst Category Description
            $res['mincategorydesc'] = $minCategory->name;
            $res['maxbrand'] =number_format($maxBrand->sales/100,2);
            $res['brandmaxqty'] = $maxBrand->sales_quantity;
            $res['maxbranddesc'] = $maxBrand->name;
            $res['minbrand'] =number_format($minBrand->sales/100,2);
            $res['brandminqty'] = $minBrand->sales_quantity;
            $res['minbranddesc'] = $minBrand->name;
            $res['maxprod'] =number_format($maxProduct->sales/100,2);
            $res['prodmaxqty'] = $maxProduct->sales_quantity;
            $res['maxproddesc'] = $maxProduct->name;
            $res['minprod'] = number_format($minProduct->sales/100,2);
            $res['prodminqty'] = $minProduct->sales_quantity;
            $res['minproddesc'] = $minProduct->name;
            
            
            $res['totalPaymenttoday'] =number_format($totalDayPayment/100,2);
            $res['totalDealstoday'] = $totalDayDeals;
            $res['totalPaymentwtd'] = number_format($totalWTDPayment/100,2);
            $res['totalDealswtd'] = $totalWTDDeals;         
            $res['totalPaymentmtd'] = number_format($totalMTDPayment/100,2);
            $res['totalDealsmtd'] = $totalMTDDeals;
            $res['totalPaymentytd'] = number_format($totalYTDPayment/100,2);
            $res['totalDealsytd'] = $totalYTDDeals;
            try {
                $res['averagePerDay'] =number_format($totalSincePayment/($daysSinceCreation*100),3);
                $res['averagePerDeal']=number_format($totalSincePayment/($totalSinceDeals*100),3);
            } catch (\Exception $e) {
                $res['averagePerDeal']=0;
                $res['averagePerDay']=0;
            }           
            $res['totalDeals'] = $totalSinceDeals;
            $res['totalSales'] =number_format($totalSincePayment/100,2);
            $res['view'] = $stations;
            $res['success'] = true;
            $res['message'] = 'Request successfully completed';
            $res['xaxis_categories'] = $xaxis_categories;
            return Response::json(array(
                    $res
                )); 
        }
    }

    /**       
         * Display Sales Revenue data of merchant consultant.
         *
         * @param  Illuminate\Http\Request $request
         * @return Response
         */
    public function getMerchantConsultantData(Request $request)
    {
        if(!Input::exists("merchant_id"))
        {
            $data['success'] = false;
            $data['message'] = 'Parameters passed incorrect';
            return Response::json(array(
                    $data
                )); 
        }
        if($request->ajax())
        {
            if(!Input::exists("from_date") || !Input::exists("to_date"))
            {
                $res['success'] = false;
                $res['message'] = 'Parameters passed incorrect';
                return Response::json(array(
                        $res
                    )); 
            }
            $fromDate = Input::get("from_date");
            $toDate = Input::get("to_date");
            $id = Input::get("merchant_id");
            $data = $this->paymentModel->getCurrentMerchantConsultantSalesRevenueDetails($id, date("Y-m-d", strtotime($fromDate)), date("Y-m-d", strtotime($toDate)));
            $res['data'] = array();
            $totalPayment = 0;
            foreach($data AS $key => $value)
            {
                if(is_numeric($value->total_payment))
                {
                    $res['data'][] = [strtotime($value->consignment) * 1000, floatval($value->total_payment/100)];
                    $totalPayment+= $value->total_payment/100;
                }
            }
            
            
            $date1 = new DateTime($fromDate);
            $date2 = new DateTime($toDate);

            $diff = $date2->diff($date1)->format("%a");
            if($diff == 0)
            {
                $res['averagePerDay'] = 0;
            }
            else
            {
                $res['averagePerDay'] = $totalPayment/$diff;
            }
            
            $data1 = $this->paymentModel->getCurrentMerchantConsultantNumberOfPayments($id, date("Y-m-d", strtotime($fromDate)), date("Y-m-d", strtotime($toDate)));
            $totalPaymentCount = $data1[0]['total'];
            if($totalPaymentCount == 0)
            {
                $res['averagePerDeal'] = 0;
            }
            else
            {
                $res['averagePerDeal'] = $totalPayment/$totalPaymentCount;
            }
            
            
            $res['view'] = $data;
            $res['success'] = true;
            $res['message'] = 'Request successfully completed';
            return Response::json(array(
                    $res
                )); 
        }
    }
    
    public function getWorldDataTotal(Request $request, $filter)
    {           
        $performace = [];
        if($filter == "today"){
            $performance=$this->getAdminDayPerformanceTotal();
        } else if($filter == "week"){
            $performance=$this->getAdminWTDPerformanceTotal();
        } else if($filter == "month"){
            $performance=$this->getAdminMTDPerformanceTotal();
        } else if($filter == "year"){
            $performance=$this->getAdminYTDPerformanceTotal();
        } else {
            $performance=$this->getAdminSincePerformanceTotal();
        }
        return Response::json($performance);
    }
    
    public function getWorldData(Request $request)
    {
        if($request->ajax())
        {
            if(!Input::exists("from_date") || !Input::exists("to_date"))
            {
                $res['success'] = false;
                $res['message'] = 'Parameters passed incorrect';
                return Response::json(array(
                        $res
                    )); 
            }
            $this->getValidations($request);
            $country = Input::get("country");
            $state = Input::get("state");
            $city = Input::get("city");
            $area = Input::get("marea");
            $consumer = Input::get("consumer");
            $fromDate = Input::get("from_date");
            $toDate = Input::get("to_date");
            $fromDate = date("Y-m-d", strtotime($fromDate));
            $toDate = date("Y-m-d", strtotime($toDate));
            $id = Input::get("merchant_id");
            $global = DB::table('global')->first();
            $res['data'] = array();
            $totalPayment = 0;
            $currmonth = 0;
            $prodarr = array();
            $prodqtyarr = array();
            $brandarr = array();
            $brandqtyarr = array();
            $categoryarr = array();
            $categoryqtyarr = array();
            $subcategoryarr = array();
            $subcategoryqtyarr = array();
            $mkfromDate = Input::get("from_date");
            $mktoDate = Input::get("to_date");
            $dated1 = mktime(0,0,0,date("n", strtotime($mkfromDate)),date("j", strtotime($mkfromDate)),date("Y", strtotime($mkfromDate))); // m d y, use 0 for day
            $dated2 = mktime(0,0,0,date("n", strtotime($mktoDate)),date("j", strtotime($mktoDate)),date("Y", strtotime($mktoDate))); // m d y, use 0 for day

            $realdif = (($dated2-$dated1) / 60 / 60 / 24 / 30);
            if($realdif > 24){
                $realdif = 24;
            }
            $months = array(0 => "Jan",1 => "Feb",2 => "Mar",3 => "Apr",4 => "May",5 => "Jun",6 => "Jul",7 => "Aug",8 => "Sep",9 => "Oct",10 => "Nov",11 => "Dec");         
            $xaxis_categories = Array();
            $d = date_parse_from_format("Y-m-d", $fromDate);
            $init_month = $d["month"];          
            $init_year = substr($d["year"],-2);         
            //$index = 0;
            for($i = 0; $i < ($realdif); $i++){
                $res['data'][$i] = 0;
                $xaxis_categories[$i] = $months[$init_month - 1] . " " . $init_year;
                $init_month++;
                if($init_month == 13){
                    $init_month = 1;
                    $init_year++;
                }
            }
            $countryq = "";
            if($country != ""){
               $countryq = " AND co.id = " . $country . " ";
            }
            $stateq = "";
            if($state != ""){
                $stateq = " AND s.id = " . $state . " ";
            }
            $cityq = "";
            if($city != ""){
                $cityq = " AND ci.id = " . $city . " ";
            }
            $areaq = "";
            if($area != ""){
                $areaq = "";
            }
            $consumerq = "";
            $consumerf = "";
            if($consumer != ""){
                $consumerf = ", " . $consumer .  " cons" ;
                $consumerq = " AND cons.user_id = u.id " ;
            }
            
            $merchants = DB::select(DB::raw("SELECT stype, currmonth, curryear,thisHour, consignment, currency, poid, mid, user_id, company, name, net_payable, mc_id, mc_commission, referral_id, referral_commission, commission_type, osmall_commission, b2b_commission_type, b2b_osmall_commission, mcp1_id, mcp1_commission, mcp2_id, mcp2_commission, rcv, source FROM (SELECT 'M' AS stype,MONTH(date(po.updated_at)) as currmonth, YEAR(date(po.updated_at)) as curryear,date(po.updated_at) as consignment,c.code as currency, po.id as poid,m.id as mid,m.user_id as user_id, m.company_name as company, m.oshop_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, SUM((op.order_price * op.quantity)) as net_payable, 
                    m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission, m.commission_type as commission_type, m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, m.b2b_osmall_commission as b2b_osmall_commission,
                    m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission,
                    DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM merchant m, payment p, porder po, orderproduct op, product pro, merchantproduct mp, currency c, users u " . $consumerf . ", city ci, state s, country co, address a WHERE c.active = 1 and po.updated_at >= '".$fromDate." 00:00:00' and po.updated_at <= '".$toDate." 23:59:59' AND po.status IN (".$this->cStatus.") and p.id = po.payment_id and m.id = mp.merchant_id and pro.id = mp.product_id and op.porder_id = po.id and op.product_id = pro.id AND po.user_id = u.id AND u.shipping_address_id = a.id AND a.city_id = ci.id AND ci.state_code = s.code AND s.country_code = co.code " . $countryq . " " . $stateq . " " . $cityq . " " . $consumerq . " AND po.id NOT IN (SELECT sorder.porder_id FROM sorder WHERE sorder.porder_id = po.id)
                    GROUP BY po.id 
                    UNION
                    SELECT 'S' AS stype,MONTH(date(po.updated_at)) as currmonth, HOUR(date(po.updated_at)) as currhour, YEAR(date(po.updated_at)) as curryear,date(po.updated_at) as consignment,c.code as currency, po.id as poid, m.id as mid,m.user_id as user_id, m.company_name as company, m.station_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, SUM((op.order_price * op.quantity)) as net_payable, 
                    m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
                    m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, m.commission_type as commission_type, m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, m.b2b_osmall_commission as b2b_osmall_commission,
                    DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM station m, payment p, porder po, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c, users u, city ci, state s, country co, address a WHERE c.active = 1 AND po.status = 'completed'  and p.id = po.payment_id and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id AND po.user_id = u.id AND u.shipping_address_id = a.id AND a.city_id = ci.id AND ci.state_code = s.code AND s.country_code = co.code " . $countryq . " " . $stateq . " " . $cityq . " 
                    and op.product_id = pro.id 
                    GROUP BY po.id 
                    ) as t          
                    "));
                    //dd($merchants);
                    $totalPaymenttoday = 0;
                    $totalDealstoday = 0;
                    $totalPaymentwtd = 0;
                    $totalPaymentmtd = 0;
                    $totalPaymentytd = 0;
                    $totalPayment = 0;
                    $totalDealswtd = 0;
                    $totalDealsmtd = 0;
                    $totalDealsytd = 0;                         
                    $totalDeals = 0;    
                    $curri = 0; 
                    $currmonth = date("m", strtotime(Input::get('from_date')));
                    $curryear = date("Y", strtotime(Input::get('from_date')));
                    $thisday = date('W');
                    $thisHour = date("H");

                    foreach ($merchants as $merchant) {
                        $mpayable = 0;
                        $payable = 0;
                        $product = Input::get("product");
                        $brand = Input::get("brand");
                        $category = Input::get("category");
                        $subcategory = Input::get("subcategory");   
                        $channel = Input::get("channel");   
                    //  $subcategoryarr = explode("-",$subcategory);
                        $productq = "";
                        $subcategoryq = "";
                        if($subcategory != ""){
                           $subcategoryq = " AND pro.subcat_id = " . $subcategory . " AND pro.subcat_level = 1 ";
                        } 
                        
                        if($product != ""){
                            $productq = " AND pro.id = " . $product . " ";
                        }
                        
                        $brandq = "";
                        if($brand != ""){
                            $brandq = " AND pro.brand_id = " . $brand . " ";
                        }
                        $categoryq = "";
                        if($category != ""){
                            $categoryq = " AND pro.category_id = " . $category . " ";
                        }

                        $channelq = "";
                        if($channel != ""){
                            $channelq = " AND pro.segment = '" . $channel . "' ";
                        }
                        if($merchant->stype ==  'M'){
                            $orderps = DB::select(DB::raw("SELECT c.code as currency, po.id as poid,m.id as mid,m.user_id as user_id, m.company_name as company, m.oshop_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, op.order_price as order_price, op.quantity as quantity, op.order_delivery_price as order_delivery_price, ((op.order_price * op.quantity)) as net_payable, 
                            m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
                            m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, pro.segment as segment, pro.id as proid, pro.brand_id as brandid, pro.category_id as categoryid, pro.subcat_id as subcatid, pro.subcat_level as slevel, pro.osmall_commission as osmall_commission, pro.b2b_osmall_commission as b2b_osmall_commission,
                            DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM merchant m, payment p, porder po, orderproduct op, product pro, merchantproduct mp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.merchant_id " . $productq . " " . $brandq . " " . $categoryq . " " . $subcategoryq . " " . $channelq . "  and pro.id = mp.product_id and op.porder_id = po.id and op.product_id = pro.id AND po.id = ".$merchant->poid." AND po.id NOT IN (SELECT sorder.porder_id FROM sorder WHERE sorder.porder_id = po.id) GROUP BY op.id ORDER BY p.created_at DESC"));                         
                        } else { //IF Stype = S
                            $orderps = DB::select(DB::raw("SELECT c.code as currency, op.id as opid,po.id as poid, m.id as mid,m.user_id as user_id, m.company_name as company, op.order_price as order_price, op.quantity as quantity, op.order_delivery_price as order_delivery_price,m.station_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$global->osmall_commission."),-1) as commission_sv, 
                            m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission, pro.segment as segment, pro.osmall_commission as osmall_commission, pro.b2b_osmall_commission as b2b_osmall_commission,
                            m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission, m.commission_type as commission_type, m.osmall_commission as osmall_commission, m.b2b_commission_type as b2b_commission_type, pro.id as proid, pro.brand_id as brandid, pro.category_id as categoryid, pro.subcat_id as subcatid, pro.subcat_level as slevel, m.b2b_osmall_commission as b2b_osmall_commission,
                            DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source, p.id as paid, so.id as soid, c.id as cid, mp.id mpid, sp.id as spid FROM station m, payment p, porder po, sorder so, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c WHERE c.active = 1 and po.updated_at >= '".$fromDate." 00:00:00' and po.updated_at <= '".$toDate." 23:59:59' and p.id = po.payment_id and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id AND po.id = ".$merchant->poid." AND so.porder_id = po.id
                            and op.product_id = pro.id ORDER BY p.created_at DESC"));                           
                        }

                        if($merchant->commission_type != "std" && $merchant->commission_type != "var" ){
                            $commission_type=$global->commission_type;
                        } else {
                            $commission_type=$merchant->commission_type;
                        }                   
                        if($merchant->b2b_commission_type != "std" && $merchant->b2b_commission_type != "var" ){
                            $b2b_commission_type=$global->b2b_commission_type;
                        } else {
                            $b2b_commission_type=$merchant->b2b_commission_type;
                        }                       
                        $mc_pay = 0;
                        if($merchant->mc_id > 0){
                            if($merchant->mc_commission > 0){
                                $mc_pay = $merchant->mc_commission;
                            } else {
                                $mc_pay = $global->mc_sales_staff_commission;
                            }
                        }
                        $referral_pay = 0;
                        if($merchant->referral_id > 0){
                            if($merchant->referral_commission > 0){
                                $referral_pay = $merchant->referral_commission;
                            } else {
                                $referral_pay = $global->referral_sales_staff_commission;
                            }
                        }
                        $mcp1_pay = 0;
                        if($merchant->mcp1_id > 0){
                            if($merchant->mcp1_commission > 0){
                                $mcp1_pay = $merchant->mcp1_commission;
                            } else {
                                $mcp1_pay = $global->mcp1_sales_staff_commission;
                            }
                        }                                                           
                        $mcp2_pay = 0;
                        if($merchant->mcp2_id > 0){
                            if($merchant->mcp2_commission > 0){
                                $mcp2_pay = $merchant->mcp2_commission;
                            } else {
                                $mcp2_pay = $global->mcp2_sales_staff_commission;
                            }
                        }       
                        $gateway_pay = $global->payment_gateway_commission;
                        $logistic_pay = $global->logistic_commission;
                        foreach ($orderps as $orderp) {
                        
                            $commission = 0;
                            if($orderp->segment == 'b2b'){
                                if($b2b_commission_type == 'std'){
                                    if($merchant->b2b_osmall_commission == null || is_null($merchant->b2b_osmall_commission) || $merchant->b2b_osmall_commission == "null" || $merchant->b2b_osmall_commission == "" || $merchant->b2b_osmall_commission == 0){
                                        $commission = $global->b2b_osmall_commission;
                                    } else {
                                        $commission = $merchant->b2b_osmall_commission;
                                    }
                                } else {
                                    if($orderp->b2b_osmall_commission == null || is_null($orderp->b2b_osmall_commission) || $orderp->b2b_osmall_commission == "null" || $orderp->b2b_osmall_commission == "" || $orderp->b2b_osmall_commission == 0){
                                        if($merchant->b2b_osmall_commission == null || is_null($merchant->b2b_osmall_commission) || $merchant->b2b_osmall_commission == "null" || $merchant->b2b_osmall_commission == "" || $merchant->b2b_osmall_commission == 0){
                                            $commission = $global->b2b_osmall_commission;
                                        } else {
                                            $commission = $merchant->b2b_osmall_commission;
                                        }
                                     } else {
                                         $commission = $orderp->b2b_osmall_commission;
                                     }
                                }
                            } else {
                                if($commission_type == 'std'){
                                    if($merchant->osmall_commission == null || is_null($merchant->osmall_commission) || $merchant->osmall_commission == "null" || $merchant->osmall_commission == "" || $merchant->osmall_commission == 0){
                                        $commission = $global->osmall_commission;
                                    } else {
                                        $commission = $merchant->osmall_commission;
                                    }
                                } else {
                                    if($orderp->osmall_commission == null || is_null($orderp->osmall_commission) || $orderp->osmall_commission == "null" || $orderp->osmall_commission == "" || $orderp->osmall_commission == 0){
                                        if($merchant->osmall_commission == null || is_null($merchant->osmall_commission) || $merchant->osmall_commission == "null" || $merchant->osmall_commission == "" || $merchant->osmall_commission == 0){
                                            $commission = $global->osmall_commission;
                                        } else {
                                            $commission = $merchant->osmall_commission;
                                        }
                                     } else {
                                         $commission = $orderp->osmall_commission;
                                     }
                                }                               
                            }
                            $mipayable = $orderp->net_payable;  
                            // dd($mipayable);
                            $mpayable += $mipayable;    
                            $npayable = $orderp->net_payable;
                            $payable += $npayable;  
                            if (array_key_exists($orderp->proid, $prodarr)) {
                                $prodarr[$orderp->proid] += $payable/100;
                                $prodqtyarr[$orderp->proid] += $orderp->quantity;
                            } else {
                                $prodarr[$orderp->proid] = $payable/100;
                                $prodqtyarr[$orderp->proid] = $orderp->quantity;
                            }
                            
                            if (array_key_exists($orderp->brandid, $brandarr)) {
                                $brandarr[$orderp->brandid] += $payable/100;
                                $brandqtyarr[$orderp->brandid] += $orderp->quantity;
                            } else {
                                $brandarr[$orderp->brandid] = $payable/100;
                                $brandqtyarr[$orderp->brandid] = $orderp->quantity;
                            }   

                            if (array_key_exists($orderp->categoryid, $categoryarr)) {
                                $categoryarr[$orderp->categoryid] += $payable/100;
                                $categoryqtyarr[$orderp->categoryid] += $orderp->quantity;
                            } else {
                                $categoryarr[$orderp->categoryid] = $payable/100;
                                $categoryqtyarr[$orderp->categoryid] = $orderp->quantity;
                            }   

                            if (array_key_exists($orderp->subcatid . "-" . $orderp->slevel , $subcategoryarr)) {
                                $subcategoryarr[$orderp->subcatid . "-" . $orderp->slevel] += $payable/100;
                                $subcategoryqtyarr[$orderp->subcatid . "-" . $orderp->slevel] += $orderp->quantity;
                            } else {
                                $subcategoryarr[$orderp->subcatid . "-" . $orderp->slevel] = $payable/100;
                                $subcategoryqtyarr[$orderp->subcatid . "-" . $orderp->slevel] = $orderp->quantity;
                            }                               
                        }
                        $merchant->mpayable = $mpayable;                        
                        $merchant->payable = $payable;  
                        
                        if($currmonth == $merchant->currmonth && $curryear == $merchant->curryear){
                            
                        } else {
                            if($curryear == $merchant->curryear){
                                $curri = $curri + ($merchant->currmonth - $currmonth);
                            } else {
                                $curri = $curri + ((12 + $merchant->currmonth) - $currmonth);
                         
                            }
                            $currmonth = $merchant->currmonth;
                            $curryear = $merchant->curryear;
                        }
                        
                        
                        if(isset($res['data'][$curri])){
                            $res['data'][$curri] += floatval(round($merchant->payable/100,2));
                        } else {
                            $res['data'][$curri] = floatval(round($merchant->payable/100,2));
                        }
                        $totalPayment+= $merchant->payable/100;
                        $totalDeals++;
                        $thisW = date("W", strtotime($merchant->consignment));
                        if($thisW == date('W') && $curryear == date('Y') && $payable > 0){
                            $totalPaymentwtd+= $merchant->payable/100;
                            $totalDealswtd++;
                        }
                        if($merchant->consignment == date('Y-m-d') && $payable > 0){
                            $totalPaymenttoday+= $merchant->payable/100;
                            $totalDealstoday++;
                        } 
                        if($merchant->currmonth == date('m') && $curryear == date('Y') && $payable > 0){
                            $totalPaymentmtd+= $merchant->payable/100;
                            $totalDealsmtd++;
                        }
                        if($curryear == date('Y') && $payable > 0){
                            $totalPaymentytd+= $merchant->payable/100;
                            $totalDealsytd++;
                        }
                        $totalDeals++;
                     }
                     
            $maxprod = 0;
            $maxprodkey = 0;
            $minprod = 1000000;
            $minprodkey = 0;
            foreach ($prodarr as $key => $value) {
                if($prodarr[$key] > $maxprod){
                    $maxprod = $prodarr[$key];
                    $maxprodkey = $key;
                }
                
                if($prodarr[$key] < $minprod){
                    $minprod = $prodarr[$key];
                    $minprodkey = $key;
                }               
            }

            $productdescmin = "";
            $compproduct = DB::table('product')->where('id',$minprodkey)->first();
            if(!is_null($compproduct)){
                $productdescmin = $compproduct->name;
            }
            $prodminqty = 0;
            $productdescmax = "";
            $compproduct = DB::table('product')->where('id',$maxprodkey)->first();
            if(!is_null($compproduct)){
                $productdescmax = $compproduct->name;
            }           
            $prodmaxqty = 0;
            $maxbrand = 0;
            $maxbrandkey = 0;
            $minbrand = 0;
            $minbrandkey = 0;
            foreach ($brandarr as $key => $value) {
                if($brandarr[$key] > $maxbrand){
                    $maxbrand = $brandarr[$key];
                    $maxbrandkey = $key;
                }
                
                if($brandarr[$key] < $minbrand){
                    $minbrand = $brandarr[$key];
                    $minbrandkey = $key;
                }               
            }       

            $branddesmin = "";
            $compbran = DB::table('brand')->where('id',$minbrandkey)->first();
            if(!is_null($compbran)){
                $branddesmin = $compbran->name;
            }
            try {
                 $brandminqty = $brandqtyarr[$minbrandkey];
            } catch (\Exception $e) {
                 $brandminqty = 0;
            }
           
            $branddesmax = "";
            $compbran = DB::table('brand')->where('id',$maxbrandkey)->first();
            if(!is_null($compbran)){
                $branddesmax = $compbran->name;
            }           
            $brandmaxqty = 0;
            $maxcategory = 0;
            $maxcategorykey = 0;
            $mincategory = 10000000000;
            $mincategorykey = 0;
            foreach ($categoryarr as $key => $value) {
                if($categoryarr[$key] > $maxcategory){
                    $maxcategory = $categoryarr[$key];
                    $maxcategorykey = $key;
                }
                
                if($categoryarr[$key] < $mincategory){
                    $mincategory = $categoryarr[$key];
                    $mincategorykey = $key;
                }               
            }   



            $date1 = new DateTime($fromDate);
            $date2 = new DateTime($toDate);
            // Code by Zurez xxxx

            $diff = $date2->diff($date1)->format("%a");
             try {
                $brandPerformance=$this->getAdminBrandPerformance();
                $productPerformance=$this->getAdminProductPerformance();
                $categoryPerformance=$this->getAdminCategoryPerformance();
                $subcatPerformance=$this->getAdminSubCatPerformance();
                $wtdPerformance=$this->getAdminWTDPerformance();
                $ytdPerformance=$this->getAdminYTDPerformance();
                // Below line can be optimised for duplicacy ~Zurez
                $mtdPerformance=$this->getAdminMTDPerformance();
                $sincePerformance=$this->getAdminSincePerformance();
                $dayPerformance=$this->getAdminDayPerformance();
                $maxBrand=$this->maxKV($brandPerformance,"sales");
                $minBrand=$this->minKV($brandPerformance,"sales");
                $maxProduct=$this->maxKV($productPerformance,"sales");
                $minProduct=$this->minKV($productPerformance,"sales");
                $maxCategory=$this->maxKV($categoryPerformance,"sales");
                $minCategory=$this->minKV($categoryPerformance,"sales");
                $maxSubCat=$this->maxKV($subcatPerformance,"sales");
                $minSubCat=$this->minKV($subcatPerformance,"sales");
                $totalWTDPayment=$this->totalKV($wtdPerformance,"sales");
                $totalWTDDeals=$this->totalKV($wtdPerformance,"ordercount");
                $totalSincePayment=$this->totalKV($sincePerformance,"sales");
                $totalSinceDeals=$this->totalKV($sincePerformance,"ordercount");
                $totalYTDPayment=$this->totalKV($ytdPerformance,"sales");
                $totalYTDDeals=$this->totalKV($ytdPerformance,"ordercount");
                $totalMTDPayment=$this->totalKV($mtdPerformance,"sales");
                $totalMTDDeals=$this->totalKV($mtdPerformance,"ordercount");
                $totalDayPayment=$this->totalKV($dayPerformance,"sales");
                $totalDayDeals=$this->totalKV($dayPerformance,"ordercount");

            } catch (\Exception $e) {
                //dd($e);
                $brandPerformance=
                $productPerformance=
                $categoryPerformance=
                $subcatPerformance=
                $wtdPerformance=
                $ytdPerformance=
                $mtdPerformance=
                $sincePerformance=
                $dayPerformance=
                [  (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    )];
                $maxBrand=
                $minBrand=
                $maxProduct=
                $minProduct=
                $maxCategory=
                $minCategory=
                $maxSubCat=
                $minSubCat=
                (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    );
                $totalWTDPayment=
                $totalWTDDeals=
                $totalSincePayment= 
                $totalSinceDeals=
                $totalYTDPayment= 
                $totalYTDDeals= 
                $totalMTDPayment=
                $totalMTDDeals=
                $totalDayPayment=
                $totalDayDeals=0;

            }

        //  dd($totalYTDPayment);
            /**************************************/ 
              if ($request->type == "ytd") {
                
               
                $yAxis=$this->initYAxis($request->type);
               
                foreach ($ytdPerformance as $salesArray) {
                    $yAxis[$salesArray->month-1]=intval($salesArray->sales);
                    // array_push($xAxis,$salesArray->month);
                   
                }
             
                
                $res['data']=$yAxis;
            }
            elseif ($request->type == "mtd") {
                
                $yAxis=$this->initYAxis($request->type);

                foreach ($mtdPerformance as $salesArray) {
                    $yAxis[$salesArray->day-1]=intval($salesArray->sales);
                    // array_push($xAxis,$salesArray->month);
                   
                }
                $res['data']=$yAxis;
            }
         
            $diff = $date2->diff($date1)->format("%a");
            $res['maxsubcategory'] = number_format($maxSubCat->sales/100,2);
            $res['subcategorymaxqty'] = $maxSubCat->sales_quantity;
            $res['maxsubcategorydesc'] = $maxSubCat->name;
            $res['subcategoryminqty'] = $minSubCat->sales_quantity;
            $res['minsubcategory'] = number_format($minSubCat->sales/100,2);
            $res['minsubcategorydesc'] = $minSubCat->name;
            $res['maxcategory'] = number_format($maxCategory->sales/100,2);
            $res['categorymaxqty'] =$maxCategory->sales_quantity;
            $res['maxcategorydesc'] = $maxCategory->name;
            // Worst Cat Total Sales Amount
            $res['mincategory'] =number_format($minCategory->sales/100,2);
            // Worst Cat Performer Count
            $res['categoryminqty'] = $minCategory->sales_quantity;
            // Worst Category Description
            $res['mincategorydesc'] = $minCategory->name;
            $res['maxbrand'] =number_format($maxBrand->sales/100,2);
            $res['brandmaxqty'] = $maxBrand->sales_quantity;
            $res['maxbranddesc'] = $maxBrand->name;
            $res['minbrand'] =number_format($minBrand->sales/100,2);
            $res['brandminqty'] = $minBrand->sales_quantity;
            $res['minbranddesc'] = $minBrand->name;
            $res['maxprod'] =number_format($maxProduct->sales/100,2);
            $res['prodmaxqty'] = $maxProduct->sales_quantity;
            $res['maxproddesc'] = $maxProduct->name;
            $res['minprod'] = number_format($minProduct->sales/100,2);
            $res['prodminqty'] = $minProduct->sales_quantity;
            $res['minproddesc'] = $minProduct->name;
            
            
            $res['totalPaymenttoday'] =number_format($totalDayPayment/100,2);
            $res['totalDealstoday'] = $totalDayDeals;
            $res['totalPaymentwtd'] = number_format($totalWTDPayment/100,2);
            $res['totalDealswtd'] = $totalWTDDeals;         
            $res['totalPaymentmtd'] = number_format($totalMTDPayment/100,2);
            $res['totalDealsmtd'] = $totalMTDDeals;
            $res['totalPaymentytd'] = number_format($totalYTDPayment/100,2);
            $res['totalDealsytd'] = $totalYTDDeals;
            if($diff == 0)
            {
                $res['averagePerDay'] = 0;
            }
            else
            {
                 $res['averagePerDay'] = $totalPayment/$diff;
            }
            
            $data1 = count($merchants);
            $totalPaymentCount = $totalDeals;
            if($totalPaymentCount == 0)
            {
                $res['averagePerDeal'] = 0;
            }
            else
            {
                $res['averagePerDeal'] = $totalPayment/$totalPaymentCount;
            }
            
            /*for($i = 0; $i < ($realdif); $i++){
                $res['data'][$i] = number_format($res['data'][$i],2);
            }          */ 
            $res['totalDeals'] = $totalSinceDeals;
            $res['totalSales'] =number_format($totalSincePayment/100,2);
            $res['view'] = $merchants;
            $res['success'] = true;
            $res['xaxis_categories'] = $xaxis_categories;
            $res['message'] = 'Request successfully completed';
            return Response::json(array(
                    $res
                )); 
        }
    }
    /*

    X-Axis is Month
    */ 
    
    public function getMerchantSincePerformanceTotal($merchant_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE 
                mp.merchant_id = ".$merchant_id."
                AND porder.status IN (".$this->cStatus.")
                AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id.$this->validation."
                )
                
                GROUP BY porder.id


                "
            ));
    }   
    
    public function getMerchantSincePerformance($merchant_id)
    {
         if($_POST['country'] != '' || $_POST['state'] != '' || $_POST['city'] != '' || $_POST['product'] != '' || $_POST['brand'] != '' || $_POST['category'] != '' || $_POST['subcategory'] != '' || $_POST['channel'] != '')
            {
                $country = $_POST['country'];
                $state = $_POST['state'];   
                $city = $_POST['city'];
                $product = $_POST['product'];
                $brand = $_POST['brand'];
                $category = $_POST['category'];
                $subcategory = $_POST['subcategory'];
                $channel = $_POST['channel'];
                 $productCatq ='';
                    if($category != ''){
                        $productCatq = " AND product.category_id  = ".$category ;
                    }
                    $productSubCatq ='';
                    if($subcategory != '')
                    {
                        $productSubCatq = " AND product.subcat_id  = ".$subcategory ;
                    }
                    $productBrandq = '';
                    if($brand != '')
                    {
                        $productBrandq = " AND product.brand_id  = ".$brand ;
                    }
                    $productq = '';
                    if($product != '')
                    {
                        $productq = " AND product.id  = ".$product ;
                    }
                    $productSegmentq = '';
                    if($channel != '')
                    {

                        $productSegmentq = " AND product.segment  = '".$channel."'" ;
                    }

                if($channel == "all2loc" ||  $channel == "overall2sales" || $channel == "b2c" || $channel == "b2b" || $channel == "hyper" || $channel == "smm" || $channel == "openwish")
                { 
                    return DB::select(DB::raw(
                  //$dd = DB::select(DB::raw(
                    "
                    SELECT 
                    count(porder.id) as ordercount,
                    SUM((op.order_price*quantity)) as sales,
                    SUM((op.quantity)) as sales_quantity,
                    Year(porder.updated_at) as year

                    FROM 
                    porder
                    JOIN orderproduct as op on op.porder_id = porder.id
                    JOIN product on product.id = op.product_id
                    JOIN merchantproduct as mp on mp.product_id=product.parent_id
                    JOIN users on users.id= porder.user_id
                    JOIN address on users.default_address_id=address.id
                    JOIN city on address.city_id = city.id
                    JOIN state on city.state_code = state.code

                    WHERE 
                    mp.merchant_id = ".$merchant_id ."
                    
                    AND porder.id NOT IN (
                    select sorder.porder_id from sorder
                    JOIN orderproduct as op on op.porder_id=sorder.porder_id
                    JOIN product  on product.id = op.product_id 
                    JOIN merchantproduct as mp on mp.product_id=product.parent_id
                    
                    )
                    
                    GROUP BY Year(porder.updated_at)


                    "
                ));
             } 
            
            else
            {
            
               return DB::select(DB::raw(
               //$dd = DB::select(DB::raw(
                "
                
                    SELECT
                    count(opos_receiptproduct.product_id) as ordercount,
                    SUM((op.price*op.quantity)) as sales,
                    SUM((op.quantity)) as sales_quantity,
                    Year(op.updated_at) as year


                    FROM
                    opos_receiptproduct
                    JOIN salesmemoproduct as op on op.product_id = opos_receiptproduct.product_id
                    JOIN salesmemo as sm on sm.id = op.salesmemo_id
                    JOIN opos_receipt as ops on ops.id = opos_receiptproduct.receipt_id
                    JOIN product on product.id = op.product_id
                    JOIN merchantproduct as mp on mp.product_id=product.parent_id
                    JOIN users on users.id= ops.staff_user_id
                    JOIN address on users.default_address_id=address.id
                    JOIN city on address.city_id = city.id
                    JOIN state on city.state_code = state.code
     
                                        
                    
                   AND mp.merchant_id = ".$merchant_id . $productCatq . $productSubCatq . $productBrandq . $productq . $productSegmentq . $cityq . $stateq . $countryq ."
                
                   GROUP BY Year(op.updated_at) 
                    

                "
            ));    
            }
    }
}   
    
    public function getMerchantWTDPerformanceTotal($merchant_id)
    {
            return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND MONTH (porder.updated_at) = MONTH(CURDATE())
                AND WEEK(porder.updated_at) = WEEK (CURDATE())
                AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                AND mp.merchant_id = ".$merchant_id.$this->validation."
                
                GROUP BY porder.id


                "
            ));
    }   
    
    public function getMerchantWTDPerformance($merchant_id)
    {
        
         if($_POST['country'] != '' || $_POST['state'] != '' || $_POST['city'] != '' || $_POST['product'] != '' || $_POST['brand'] != '' || $_POST['category'] != '' || $_POST['subcategory'] != '' || $_POST['channel'] != '')
            {
                
                $country = $_POST['country'];
                $state = $_POST['state'];   
                $city = $_POST['city'];
                $product = $_POST['product'];
                $brand = $_POST['brand'];
                $category = $_POST['category'];
                $subcategory = $_POST['subcategory'];
                $channel = $_POST['channel'];
                $productCatq ='';
                    if($category != ''){
                        $productCatq = " AND product.category_id  = ".$category ;
                    }
                    $productSubCatq ='';
                    if($subcategory != '')
                    {
                        $productSubCatq = " AND product.subcat_id  = ".$subcategory ;
                    }
                    $productBrandq = '';
                    if($brand != '')
                    {
                        $productBrandq = " AND product.brand_id  = ".$brand ;
                    }
                    $productq = '';
                    if($product != '')
                    {
                        $productq = " AND product.id  = ".$product ;
                    }
                    $productSegmentq = '';
                    if($channel != '')
                    {

                        $productSegmentq = " AND product.segment  = '".$channel."'" ;
                    }
                    $cityq = '';
                    if($city != '')
                    {

                        $cityq = " AND city.id  = '".$city."'" ;
                    }
                    $stateq = '';
                    if($state != '')
                    {

                        $stateq = " AND state.code  = '".$state."'" ;
                    }
                    $countryq = '';
                    if($country != '')
                    {

                        $countryq = " AND country.id  = '".$country."'" ;
                    }
                if($channel == "all2loc" OR  $channel == "overall2sales" OR $channel == "b2c" OR $channel == "b2b" OR $channel == "hyper" OR $channel == "smm" OR $channel == "openwish")
                {       
                    return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DAY(porder.updated_at) as day

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND MONTH (porder.updated_at) = MONTH(CURDATE())
                AND WEEK(porder.updated_at) = WEEK (CURDATE())
                AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                AND mp.merchant_id = ".$merchant_id.$this->validation."
                
                GROUP BY DAY(porder.updated_at)


                "
            ));
              /*echo "<pre>";
               print_r($dd);
               exit;*/
                
            } 
        
            else
            {

                return DB::select(DB::raw(
              // $dd = DB::select(DB::raw(
                "
                
                    SELECT
                    count(opos_receiptproduct.product_id) as ordercount,
                    SUM((op.price*op.quantity)) as sales,
                    SUM((op.quantity)) as sales_quantity,
                    DAY(op.updated_at) as day


                    FROM
                    opos_receiptproduct
                    JOIN salesmemoproduct as op on op.product_id = opos_receiptproduct.product_id
                    JOIN salesmemo as sm on sm.id = op.salesmemo_id
                    JOIN opos_receipt as ops on ops.id = opos_receiptproduct.receipt_id
                    JOIN product on product.id = op.product_id
                    JOIN merchantproduct as mp on mp.product_id=product.parent_id
                    JOIN users on users.id= ops.staff_user_id
                    JOIN address on users.default_address_id=address.id
                    JOIN city on address.city_id = city.id
                    JOIN state on city.state_code = state.code
                     WHERE 
                     YEAR(op.updated_at) = YEAR(CURDATE()) 
                     AND MONTH (op.updated_at) = MONTH(CURDATE())
                     AND WEEK(op.updated_at) = WEEK (CURDATE())               
                        
                      AND mp.merchant_id = ".$merchant_id . $productCatq . $productSubCatq . $productBrandq . $productq . $productSegmentq . $cityq . $stateq . $countryq ."
                
                   
                   GROUP BY DAY(op.updated_at) 
                    

                "
            ));
    }
}
}
    
    public function getMerchantYTDPerformanceTotal($merchant_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE YEAR(porder.updated_at) = YEAR(CURDATE()) 
                AND porder.status IN (".$this->cStatus.")
                AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                AND mp.merchant_id = ".$merchant_id.$this->validation."
                
                GROUP BY porder.id


                "
            ));
    }   
    
    public function getMerchantYTDPerformance($merchant_id)
    {
         if($_POST['country'] != '' || $_POST['state'] != '' || $_POST['city'] != '' || $_POST['product'] != '' || $_POST['brand'] != '' || $_POST['category'] != '' || $_POST['subcategory'] != '' || $_POST['channel'] != '')
            {
                $country = $_POST['country'];
                $state = $_POST['state'];   
                $city = $_POST['city'];
                $product = $_POST['product'];
                $brand = $_POST['brand'];
                $category = $_POST['category'];
                $subcategory = $_POST['subcategory'];
                $channel = $_POST['channel'];
                $productCatq ='';
                    if($category != ''){
                        $productCatq = " AND product.category_id  = ".$category ;
                    }
                    $productSubCatq ='';
                    if($subcategory != '')
                    {
                        $productSubCatq = " AND product.subcat_id  = ".$subcategory ;
                    }
                    $productBrandq = '';
                    if($brand != '')
                    {
                        $productBrandq = " AND product.brand_id  = ".$brand ;
                    }
                    $productq = '';
                    if($product != '')
                    {
                        $productq = " AND product.id  = ".$product ;
                    }
                    $productSegmentq = '';
                    if($channel != '')
                    {

                        $productSegmentq = " AND product.segment  = '".$channel."'" ;
                    }
                    $cityq = '';
                    if($city != '') {
                        $cityq = " AND address.city_id  = ".$city ;
                    }

                    $stateq = '';
                    if($state != '') {
                        $stateq = " AND state.id = ".$state ;
                    }

                    $countryq = '';
                    if($country != '') {
                        $countryq = " AND country.id = ".$country ;
                    }
            if($channel == "all2loc" ||  $channel == "overall2sales" || $channel == "b2c" || $channel == "b2b" || $channel == "hyper" || $channel == "smm" || $channel == "openwish")
            {   
            
                  return DB::select(DB::raw(
                    "
                    SELECT 
                    count(porder.id) as ordercount,
                    SUM((op.order_price*quantity)) as sales,
                    SUM((op.quantity)) as sales_quantity,
                    Month(porder.updated_at) as month

                    FROM 
                    porder
                    JOIN orderproduct as op on op.porder_id = porder.id
                    JOIN product on product.id = op.product_id
                    JOIN merchantproduct as mp on mp.product_id=product.id
                    JOIN users on users.id= porder.user_id
                    JOIN address on users.default_address_id=address.id
                    JOIN city on address.city_id = city.id
                    JOIN state on city.state_code = state.code

                    WHERE YEAR(porder.updated_at) = YEAR(CURDATE()) AND mp.merchant_id=".$merchant_id . $productCatq . $productSubCatq . $productBrandq . $productBrandq . $productq . $productSegmentq . $cityq . $stateq . $countryq ."
                    
                    GROUP BY Month(porder.updated_at)
                    "
                ));
            } 
        
            else
            {
                 return DB::select(DB::raw(
                // $dd = DB::select(DB::raw(
                "
                
                    SELECT
                    count(opos_receiptproduct.product_id) as ordercount,
                    SUM((op.price*op.quantity)) as sales,
                    SUM((op.quantity)) as sales_quantity,
                    Month(op.updated_at) as month

                    FROM
                    opos_receiptproduct
                    JOIN salesmemoproduct as op on op.product_id = opos_receiptproduct.product_id
                    JOIN salesmemo as sm on sm.id = op.salesmemo_id
                    JOIN opos_receipt as ops on ops.id = opos_receiptproduct.receipt_id
                    JOIN product on product.id = op.product_id
                    JOIN merchantproduct as mp on mp.product_id=product.parent_id
                    JOIN users on users.id= ops.staff_user_id
                    JOIN address on users.default_address_id=address.id
                    JOIN city on address.city_id = city.id
                    JOIN state on city.state_code = state.code
                    /*WHERE YEAR(opos_receiptproduct.created_at) = YEAR(CURDATE()) */

                    WHERE YEAR(op.updated_at) = YEAR(CURDATE()) 
                                        
                    AND mp.merchant_id = ".$merchant_id . $productCatq . $productSubCatq . $productBrandq . $productq . $productSegmentq . $cityq . $stateq . $countryq ."

                   GROUP BY Month(op.updated_at) 
                "
            ));

              /*echo "<pre>";
              print_r($dd);
              exit;*/
            }
        }
    }
    /*
    X-Axis is Days

    */ 
    
    public function getMerchantMTDPerformanceTotal($merchant_id)
    {

                return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND MONTH (porder.updated_at) = MONTH (CURDATE())
                AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                AND mp.merchant_id = ".$merchant_id.$this->validation."
                
                GROUP BY porder.id
                "
            ));
    }   
    
    public function getMerchantMTDPerformance($merchant_id)
    {
        $startmonth =  Carbon::now()->startOfMonth()->toDateString();
        $endmonth = Carbon::now()->toDateString();
        
           if($_POST['country'] != '' || $_POST['state'] != '' || $_POST['city'] != '' || $_POST['product'] != '' || $_POST['brand'] != '' || $_POST['category'] != '' || $_POST['subcategory'] != '' || $_POST['channel'] != '')
            {
                $country = $_POST['country'];
                $state = $_POST['state'];   
                $city = $_POST['city'];
                $product = $_POST['product'];
                $brand = $_POST['brand'];
                $category = $_POST['category'];
                $subcategory = $_POST['subcategory'];
                $channel = $_POST['channel'];
                $productCatq ='';
                    if($category != ''){
                        $productCatq = " AND product.category_id  = ".$category ;
                    }
                    $productSubCatq ='';
                    if($subcategory != '')
                    {
                        $productSubCatq = " AND product.subcat_id  = ".$subcategory ;
                    }
                    $productBrandq = '';
                    if($brand != '')
                    {
                        $productBrandq = " AND product.brand_id  = ".$brand ;
                    }
                    $productq = '';
                    if($product != '')
                    {
                        $productq = " AND product.id  = ".$product ;
                    }
                    $productSegmentq = '';
                    if($channel != '')
                    {

                        $productSegmentq = " AND product.segment  = '".$channel."'" ;
                    }
                    $cityq = '';
                    if($city != '')
                    {

                        $cityq = " AND city.id  = '".$city."'" ;
                    }
                    $stateq = '';
                    if($state != '')
                    {

                        $stateq = " AND state.code  = '".$state."'" ;
                    }
                    $countryq = '';
                    if($country != '')
                    {

                        $countryq = " AND country.id  = '".$country."'" ;
                    }
                if($channel == "all2loc" OR  $channel == "overall2sales" OR $channel == "b2c" OR $channel == "b2b" OR $channel == "hyper" OR $channel == "smm" OR $channel == "openwish")
                {  
                    
                 
                //return DB::select(DB::raw(
              	$data = DB::select(DB::raw(
        
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE(porder.updated_at) as date

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.id

                WHERE 
                DATE(porder.updated_at) BETWEEN  ' $startmonth ' AND ' $endmonth ' AND mp.merchant_id = ".$merchant_id . $productCatq . $productSubCatq . $productBrandq . $productBrandq . $productq . $productSegmentq . "
                
                GROUP BY DATE(porder.updated_at)

                "
            ));
              	if(!empty($data))
                {
                    return $data;
                }
                else
                {
                  return   [  (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    )];
                } 

               /*echo "<pre>";
                print_r($dd);
                exit;*/
            } 
        
            else
            {
            	
            //return DB::select(DB::raw(
                $data = DB::select(DB::raw(
                "
                
                    SELECT
                    count(opos_receiptproduct.product_id) as ordercount,
                    SUM((op.price*op.quantity)) as sales,
                    SUM((op.quantity)) as sales_quantity,
                    DAY(op.updated_at) as day

                    FROM
                    opos_receiptproduct
                    JOIN salesmemoproduct as op on op.product_id = opos_receiptproduct.product_id
                    JOIN salesmemo as sm on sm.id = op.salesmemo_id
                    JOIN opos_receipt as ops on ops.id = opos_receiptproduct.receipt_id
                    JOIN product on product.id = op.product_id
                    JOIN merchantproduct as mp on mp.product_id=product.parent_id
                    JOIN users on users.id= ops.staff_user_id
                    JOIN address on users.default_address_id=address.id
                    JOIN city on address.city_id = city.id
                    JOIN state on city.state_code = state.code
                    /*WHERE YEAR(opos_receiptproduct.created_at) = YEAR(CURDATE()) */

                    WHERE  
                    DATE(op.updated_at) BETWEEN  ' $startmonth ' AND ' $endmonth '
                                        
                    
                   AND mp.merchant_id = ".$merchant_id . $productCatq . $productSubCatq . $productBrandq . $productq . $productSegmentq . $cityq . $stateq . $countryq ."
                
                   
                   GROUP BY DATE(op.updated_at) 
                    

                "
            ));
                if(!empty($data))
                {
                	echo "test";
                	exit;
                    return $data;
                }
                else
                {
                	echo "else";
                	exit;
                  return   [  (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    )];
                } 

               /*echo "<pre>";
                print_r($dd);
                exit;*/

             }

            }
    }
    public function getMerchantProductPerformance($merchant_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.id as product_id,
                product.name as name,
                product.description as description

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id

                WHERE 

                mp.merchant_id = ".$merchant_id."
                AND porder.status IN (".$this->cStatus.")
                 AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                
                group by product.parent_id


                "
            ));
    }
    public function getMerchantCategoryPerformance($merchant_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.category_id as category_id,
                category.name as name,
                category.description as description

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                JOIN category on category.id= product.category_id

                WHERE 
                mp.merchant_id = ".$merchant_id."
                AND porder.status IN (".$this->cStatus.")
                AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                
                group by product.category_id


                "
            )); 
    }
    public function getMerchantBrandPerformance($merchant_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.brand_id as brand_id,
                brand.name as name,
                brand.description as description

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                JOIN brand on brand.id =product.brand_id

                WHERE 
                mp.merchant_id = ".$merchant_id."
                AND porder.status IN (".$this->cStatus.")
                AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                
                group by product.brand_id


                "
            ));        
    }
    
    public function getMerchantDayPerformanceTotal($merchant_id)
    {
         return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id


                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND MONTH (porder.updated_at) = MONTH (CURDATE())
                AND DAY(porder.updated_at) = DAY(CURDATE())
                 AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                AND mp.merchant_id = ".$merchant_id.$this->validation."
                
                GROUP BY porder.id


                "
            ));
    }   
    
    public function getMerchantDayPerformance($merchant_id)
    {
          
            if($_POST['country'] != '' || $_POST['state'] != '' || $_POST['city'] != '' || $_POST['product'] != '' || $_POST['brand'] != '' || $_POST['category'] != '' || $_POST['subcategory'] != '' || $_POST['channel'] != '')
            {

                $country = $_POST['country'];
                $state = $_POST['state'];   
                $city = $_POST['city'];
                $product = $_POST['product'];
                $brand = $_POST['brand'];
                $category = $_POST['category'];
                $subcategory = $_POST['subcategory'];
                $channel = $_POST['channel'];
                $productCatq ='';
                    if($category != ''){
                        $productCatq = " AND product.category_id  = ".$category ;
                    }
                    $productSubCatq ='';
                    if($subcategory != '')
                    {
                        $productSubCatq = " AND product.subcat_id  = ".$subcategory ;
                    }
                    $productBrandq = '';
                    if($brand != '')
                    {
                        $productBrandq = " AND product.brand_id  = ".$brand ;
                    }
                    $productq = '';
                    if($product != '')
                    {
                        $productq = " AND product.id  = ".$product ;
                    }
                    $productSegmentq = '';
                    if($channel != '')
                    {
                        $productSegmentq = " AND product.segment  = '".$channel."'" ;
                    }
               if($channel == "all2loc" ||  $channel == "overall2sales" || $channel == "b2c" || $channel == "b2b" || $channel == "hyper" || $channel == "smm" || $channel == "openwish")
                {
                  
                  //  return DB::select(DB::raw(
                    $data = DB::select(DB::raw(
                    "
                    SELECT 
                    count(porder.id) as ordercount,
                    SUM((op.order_price*quantity)) as sales,
                    SUM((op.quantity)) as sales_quantity,
                    DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as day

                    FROM 
                    porder
                    JOIN orderproduct as op on op.porder_id = porder.id
                    JOIN product on product.id = op.product_id
                    JOIN merchantproduct as mp on mp.product_id=product.id
                    WHERE 
                    
                    YEAR(porder.updated_at) = YEAR(CURDATE())
                    
                    AND MONTH (porder.updated_at) = MONTH (CURDATE())
                    AND DAY(porder.updated_at) = DAY(CURDATE()) 
                    AND mp.merchant_id= " . $merchant_id ."
                    GROUP BY DATE(porder.updated_at)
                    "
                ));  
                if(!empty($data))
                {
                    
                    return $data;
                }
                else
                {
                  return   [  (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    )];
                }   
                }
                
            
            else
            {
                
               // return DB::select(DB::raw(
                 $data = DB::select(DB::raw(
                "
                    SELECT
                    count(opos_receiptproduct.product_id) as ordercount,
                    SUM((op.price*op.quantity)) as sales,
                    SUM((op.quantity)) as sales_quantity,
                    DATE(op.updated_at) as DATE

                    FROM
                    opos_receiptproduct
                    JOIN salesmemoproduct as op on op.product_id = opos_receiptproduct.product_id
                    JOIN salesmemo as sm on sm.id = op.salesmemo_id
                    JOIN opos_receipt as ops on ops.id = opos_receiptproduct.receipt_id
                    JOIN product on product.id = op.product_id
                    JOIN merchantproduct as mp on mp.product_id=product.parent_id
                    JOIN users on users.id= ops.staff_user_id
                    JOIN address on users.default_address_id=address.id
                    JOIN city on address.city_id = city.id
                    JOIN state on city.state_code = state.code
                    /*WHERE YEAR(opos_receiptproduct.created_at) = YEAR(CURDATE()) */

                    WHERE  
                    YEAR(op.updated_at) = YEAR(CURDATE())
                    AND MONTH (op.updated_at) = MONTH (CURDATE())
                    AND DAY(op.updated_at) = DAY(CURDATE()) " . $productCatq . $productBrandq . $productq . $productSegmentq . $cityq . $stateq . $countryq . "
                    GROUP BY DATE(op.updated_at) 
                "
            ));
                 /*echo "<pre>";
                 print_r($data);
                 exit;*/
                if(!empty($data))
                {
                    return $data;
                }
                else
                {
                  return   [  (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    )];
                }
            }
        }
    }
    public function getMerchantWeeklyPerformance($merchant_id)
    { 
        $fromDate =  Carbon::now()->startOfWeek()->toDateString();
        $toDate = Carbon::now()->toDateString();
        if($_POST['country'] != '' || $_POST['state'] != '' || $_POST['city'] != '' || $_POST['product'] != '' || $_POST['brand'] != '' || $_POST['category'] != '' || $_POST['subcategory'] != '' || $_POST['channel'] != '')
        {
               //echo "first";exit;
                $country = $_POST['country'];
                $state = $_POST['state'];   
                $city = $_POST['city'];
                $product = $_POST['product'];
                $brand = $_POST['brand'];
                $category = $_POST['category'];
                $subcategory = $_POST['subcategory'];
                $channel = $_POST['channel'];
                $productCatq ='';
                    if($category != ''){
                        $productCatq = " AND product.category_id  = ".$category ;
                    }
                    $productSubCatq ='';
                    if($subcategory != '')
                    {
                        $productSubCatq = " AND product.subcat_id  = ".$subcategory ;
                    }
                    $productBrandq = '';
                    if($brand != '')
                    {
                        $productBrandq = " AND product.brand_id  = ".$brand ;
                    }
                    $productq = '';
                    if($product != '')
                    {
                        $productq = " AND product.id  = ".$product ;
                    }
                    $productSegmentq = '';
                    if($channel != '')
                    {

                        $productSegmentq = " AND product.segment  = '".$channel."'" ;
                    }
                    $cityq = '';
                    if($city != '')
                    {

                        $cityq = " AND city.id  = '".$city."'" ;
                    }
                    $stateq = '';
                    if($state != '')
                    {

                        $stateq = " AND state.code  = '".$state."'" ;
                    }
                    $countryq = '';
                    if($country != '')
                    {

                        $countryq = " AND country.id  = '".$country."'" ;
                    }

                if($channel == "all2loc" ||  $channel == "overall2sales" || $channel == "b2c" || $channel == "b2b" || $channel == "hyper" || $channel == "smm" || $channel == "openwish")
                {

                //return DB::select(DB::raw(
                $data = DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DAY(porder.updated_at) as day
                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE
                DATE(porder.updated_at) BETWEEN  ' $fromDate ' AND ' $toDate ' AND mp.merchant_id=".$merchant_id . $productCatq . $productBrandq . $productq . $productSegmentq . $cityq . $stateq . $countryq . "
                
                GROUP BY DATE(porder.updated_at)
                "
            ));
                if(!empty($data))
                {
                    return $data;
                }
                else
                {
                  return   [  (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    )];
                } 
            } 
            else
            {
               // return DB::select(DB::raw(
                 $data = DB::select(DB::raw(
                "
                    SELECT
                    count(opos_receiptproduct.product_id) as ordercount,
                    SUM((op.price*op.quantity)) as sales,
                    SUM((op.quantity)) as sales_quantity,
                    DAY(op.updated_at) as day

                    FROM
                    opos_receiptproduct
                    JOIN salesmemoproduct as op on op.product_id = opos_receiptproduct.product_id
                    JOIN salesmemo as sm on sm.id = op.salesmemo_id
                    JOIN opos_receipt as ops on ops.id = opos_receiptproduct.receipt_id
                    JOIN product on product.id = op.product_id
                    JOIN merchantproduct as mp on mp.product_id=product.parent_id
                    JOIN users on users.id= ops.staff_user_id
                    JOIN address on users.default_address_id=address.id
                    JOIN city on address.city_id = city.id
                    JOIN state on city.state_code = state.code
                   WHERE  
                   DATE(op.updated_at) BETWEEN  ' $fromDate ' AND ' $toDate '
                   AND mp.merchant_id = ' $merchant_id ' " .$productCatq . $productBrandq . $productq . $productSegmentq . $cityq . $stateq . $countryq . "
                   GROUP BY DATE(op.updated_at) 
                "
            ));  

            if(!empty($data))
                {
                    return $data;
                }
                else
                {
                  return   [  (object)
                    array("ordercount"=>0,
                    "sales"=>0,
                    "sales_quantity"=>0,
                    "month"=>1,
                    "day"=>1,

                    "name"=>"Not Available",
                    "description"=>"",
                    )];
                }   
        }
    }   
}

    /*public function getMerchantHourlyPerformance($merchant_id)
    {
        //$fromDate = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
        //$todad = Carbon::now()->toDateString();
        $date = "2018-01-25 08:01";
        //return DB::select(DB::raw(
        return DB::select(DB::raw(
        
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%Y-%m-%d %h:%m') as DATE

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id

                WHERE 
                DATE(porder.updated_at) >= DATE(NOW()) - INTERVAL 1 HOUR
                
                AND porder.status IN (".$this->cStatus.")
                
                AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                AND mp.merchant_id = ".$merchant_id.$this->validation."
                
                GROUP BY DATE(porder.updated_at)

                "
            ));
    }*/
    /*public function getMerchantHourlyPerformance($merchant_id)
    {
         return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                HOUR(porder.updated_at) as hour

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id

                WHERE 
                
                AND porder.status IN (".$this->cStatus.")
                
                AND HOUR(porder.updated_at >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
                AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                AND mp.merchant_id = ".$merchant_id.$this->validation."
                
                GROUP BY DATE(porder.updated_at)


                "
            ));
    }*/
     /*public function getMerchantWeeklyPerformance()
     {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DAY(porder.updated_at) as day

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE 
                
                AND porder.status IN (".$this->cStatus.")
                
                AND WEEK (porder.updated_at > DATE_SUB(NOW(), INTERVAL 1 WEEK);
                AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                AND mp.merchant_id = ".$merchant_id.$this->validation."
                
                GROUP BY DATE(porder.updated_at)


                "
            ));
     }*/
    public function getMerchantSubCatPerformance($merchant_id)
    {
         $ret= DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.subcat_id as subcat_id,
                product.subcat_level as subcatlevel

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id

                WHERE 
                mp.merchant_id = ".$merchant_id."
                AND porder.status IN (".$this->cStatus.")
                 AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                
                group by product.subcat_id


                "
            )); 
         foreach ($ret as $r) {
             $r->name=DB::table("subcat_level_".$r->subcatlevel)->where('id',$r->subcat_id)->pluck('name');
         }
         return $ret;
    }
    public function getMerchantHourPerformanceTotal()
    {

        return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND MONTH (porder.updated_at) = MONTH(CURDATE())
                AND WEEK(porder.updated_at) = WEEK (CURDATE())
                AND WEEK(porder.updated_at) = WEEK (CURDATE())
                AND porder.id NOT IN (
                select sorder.porder_id from sorder
                JOIN orderproduct as op on op.porder_id=sorder.porder_id
                JOIN product  on product.id = op.product_id 
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                WHERE mp.merchant_id=".$merchant_id."
                )
                AND mp.merchant_id = ".$merchant_id.$this->validation."
                
                GROUP BY porder.id


                "
            ));
    }
    public function initYAxis($type)
    {

        $yAxis=array();
        switch ($type) {
            case 'ytd':
                $max=DB::select(DB::raw("
                SELECT max(MONTH(updated_at)) as month
                FROM 
                porder

                WHERE 
                YEAR(updated_at) = YEAR(CURDATE())
                limit 1


                "))[0]->month;
                break;
            case 'since':
                $max=DB::select(DB::raw("
                SELECT max(YEAR(updated_at)) as year
                FROM 
                porder
                limit 1
                "))[0]->year;
                break;
            
                
                
                
            
            case 'mtd':
                $max=DB::select(DB::raw("
                SELECT max(DAY(updated_at)) as day
                FROM 
                porder
                WHERE 
                YEAR(updated_at) = YEAR(CURDATE())
                AND
                MONTH(updated_at) = MONTH(CURDATE())
                limit 1


                "))[0]->day;
                break;
                
            default:
                # code...
                break;
        }
        
        for ($i=0; $i < $max; $i++) { 
            array_push($yAxis,0);
            }
        

        return $yAxis;

    }
    public function maxKV($kvArray,$key)
    {   $max=0;
        $maxIndex=0;
        $index=0;
        foreach ($kvArray as $kv) {
            if ($kv->$key > $max) {
                $max=$kv->$key;
                $maxIndex=$index;
            }
            $index++;
        }
         // Lazy Formatter
        return $kvArray[$maxIndex];
        // try {
        //     return $kvArray[$maxIndex];
        // } catch (\Exception $e) {
        //     return $kvArray[0];
        // }
        
    }
    public function minKV($kvArray,$key)
    {   $max=9999999999999999;
        $maxIndex=0;
        $index=0;
        foreach ($kvArray as $kv) {
            if ($kv->$key < $max) {
                $max=$kv->$key;
                $maxIndex=$index;

            }
            $index++;
        }
        // Lazy Formatter
   
        // try {
        //     return $kvArray[$maxIndex];
        // } catch (\Exception $e) {
        //     return $kvArray[0];
        // }
        return $kvArray[$maxIndex];
    }
    /*
        Table naming 
        porder porder
        merchantproduct mp
        stationsproduct ssp
        sproduct sp
        orderproduct op
        product product
        users users
   !Input::exists("marea") || 
    */ 
    public function getValidations($request)
    {
        // qqq

        $this->validation.="";
        // if ($request->has('from_date') and $request->from_date != "") {
        //     if ($request->has('to_date') and $request->to_date !="") {
        //         $to_date=$request->to_date;
        //     }else{
        //         $to_date="CURDATE() ";
        //     }
        //     $this->validation.=" AND porder.created between ".$request->from_date. " AND ".$to_date;
            
        // }
        if ($request->has('city') and $request->city != "" and is_numeric($request->city)) {
            $this->validation.=" AND city.id =".$request->city." ";
        }
        if ($request->has('state') and $request->state != "" and is_numeric($request->state)) {
            $this->validation.=" AND state.id =".$request->state." ";
        }
        if ($request->has('product') and $request->product != "" and is_numeric($request->product)) {
            # Maybe add integer validation? . Brand validation has priority over product
            $this->validation.=" AND product.id =".$request->product." ";
        }
        if ($request->has('brand') and $request->brand != "" ) {

            $this->validation .= " AND product.brand_id = ".$request->brand." ";
        }
        if ($request->has('category') and $request->category != "" and is_numeric($request->category)) {
            $this->validation.= " AND product.category_id = ".$request->category." ";
        }
        if ($request->has('subcategory') and $request->subcategory != "" and is_numeric($request->subcategory)) {
             $this->validation.= " AND product.subcat_id = ".$request->subcategory." ";
        }
        if ($request->has('channel') and $request->channel != "" and $request->channel=="b2c") {
            $this->validation.= " AND product.segment = '".$request->channel."'";
        }
        if ($request->has('channel') and $request->channel != "" and $request->channel=="b2b") {
            $this->validation.= " AND product.segment = '".$request->channel."' ";
        }
         if ($request->has('channel') and $request->channel != "" and $request->channel=="all2loc") {
            $this->validation.= " AND product.segment = '".$request->channel."' ";
        }

        
    }
    public function totalKV($kvArray,$key)
    {
        $ret=0;
        foreach ($kvArray as $kv) {
            $ret+=$kv->$key;
        }
        return $ret;
    }

    /***********STATION SECTION *****************************/
       public function getStationYTDPerformanceTotal($station_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id 
                JOIN stationsproduct on stationsproduct.sproduct_id =sp.id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE YEAR(porder.updated_at) = YEAR(CURDATE()) 
                AND porder.status IN (".$this->cStatus.")
                AND porder.id  IN (
                select sorder.porder_id from sorder
      
                WHERE sorder.station_id=".$station_id."
                )
                AND stationsproduct.station_id = ".$station_id.$this->validation."
                
                GROUP BY porder.id


                "
            ));
    }   
    
       public function getStationYTDPerformance($station_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                Month(porder.updated_at) as month

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id 
                JOIN stationsproduct on stationsproduct.sproduct_id =sp.id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE YEAR(porder.updated_at) = YEAR(CURDATE()) 
                AND porder.status IN (".$this->cStatus.")
                AND porder.id  IN (
                select sorder.porder_id from sorder
      
                WHERE sorder.station_id=".$station_id."
                )
                AND stationsproduct.station_id = ".$station_id.$this->validation."
                
                GROUP BY Month(porder.updated_at)


                "
            ));
    }
    /*
    X-Axis is Days

    */ 
    
    public function getStationMTDPerformanceTotal($station_id)
    {
                return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id 
                JOIN stationsproduct on stationsproduct.sproduct_id =sp.id
                                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND MONTH (porder.updated_at) = MONTH (CURDATE())
                AND porder.id  IN (
                select sorder.porder_id from sorder
              
                
                WHERE sorder.station_id=".$station_id."
                )
                AND stationsproduct.station_id = ".$station_id.$this->validation."
                
               GROUP BY porder.id


                "
            ));
    }   
    
    public function getStationMTDPerformance($station_id)
    {
                return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DAY(porder.updated_at) as day

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id 
                JOIN stationsproduct on stationsproduct.sproduct_id =sp.id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND MONTH (porder.updated_at) = MONTH (CURDATE())
                AND porder.id  IN (
                select sorder.porder_id from sorder
              
                
                WHERE sorder.station_id=".$station_id."
                )
                AND stationsproduct.station_id = ".$station_id.$this->validation."
                
                GROUP BY DATE(porder.updated_at)


                "
            ));
    }
    public function getStationProductPerformance($station_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.id as product_id,
                product.name as name,
                product.description as description

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id JOIN stationsproduct on stationsproduct.sproduct_id =sp.id

                WHERE 

                stationsproduct.station_id = ".$station_id."
                AND porder.status IN (".$this->cStatus.")
                 AND porder.id  IN (
                select sorder.porder_id from sorder
          
                
                WHERE sorder.station_id=".$station_id."
                )
                
                group by product.parent_id


                "
            ));
    }
    public function getStationCategoryPerformance($station_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.category_id as category_id,
                category.name as name,
                category.description as description

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id JOIN stationsproduct on stationsproduct.sproduct_id =sp.id
                JOIN category on category.id= product.category_id

                WHERE 
                stationsproduct.station_id = ".$station_id."
                AND porder.status IN (".$this->cStatus.")
                AND porder.id  IN (
                select sorder.porder_id from sorder
              
                WHERE sorder.station_id=".$station_id."
                )
                
                group by product.category_id


                "
            )); 
    }
    public function getStationBrandPerformance($station_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.brand_id as brand_id,
                brand.name as name,
                brand.description as description

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id JOIN stationsproduct on stationsproduct.sproduct_id =sp.id
                JOIN brand on brand.id =product.brand_id

                WHERE 
                stationsproduct.station_id = ".$station_id."
                AND porder.status IN (".$this->cStatus.")
                AND porder.id  IN (
                select sorder.porder_id from sorder
                
                WHERE sorder.station_id=".$station_id."
                )
                
                group by product.brand_id


                "
            ));        
    }
    
    public function getStationDayPerformanceTotal($station_id)
    {
         return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id JOIN stationsproduct on stationsproduct.sproduct_id =sp.id

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND MONTH (porder.updated_at) = MONTH (CURDATE())
                AND DAY(porder.updated_at) = DAY(CURDATE())
                 AND porder.id  IN (
                select sorder.porder_id from sorder
                
                
                WHERE sorder.station_id=".$station_id."
                )
                AND stationsproduct.station_id = ".$station_id.$this->validation."
                
                GROUP BY porder.id


                "
            ));
    }   
    
    public function getStationDayPerformance($station_id)
    {
         return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DAY(porder.updated_at) as day

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id JOIN stationsproduct on stationsproduct.sproduct_id =sp.id

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND MONTH (porder.updated_at) = MONTH (CURDATE())
                AND DAY(porder.updated_at) = DAY(CURDATE())
                 AND porder.id  IN (
                select sorder.porder_id from sorder
                
                
                WHERE sorder.station_id=".$station_id."
                )
                AND stationsproduct.station_id = ".$station_id.$this->validation."
                
                GROUP BY DATE(porder.updated_at)


                "
            ));
    }
    public function getStationSubCatPerformance($station_id)
    {
         $ret= DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.subcat_id as subcat_id,
                product.subcat_level as subcatlevel

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id JOIN stationsproduct on stationsproduct.sproduct_id =sp.id

                WHERE 
                stationsproduct.station_id = ".$station_id."
                AND porder.status IN (".$this->cStatus.")
                 AND porder.id  IN (
                select sorder.porder_id from sorder
                WHERE sorder.station_id=".$station_id."
                )
                
                group by product.subcat_id


                "
            )); 
         foreach ($ret as $r) {
             $r->name=DB::table("subcat_level_".$r->subcatlevel)->where('id',$r->subcat_id)->pluck('name');
         }
         return $ret;
    }
    
    public function getStationWTDPerformanceTotal($station_id)
    {
            return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id JOIN stationsproduct on stationsproduct.sproduct_id =sp.id

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND MONTH (porder.updated_at) = MONTH(CURDATE())
                AND WEEK(porder.updated_at) = WEEK (CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND porder.id  IN (
                select sorder.porder_id from sorder
                WHERE sorder.station_id=".$station_id."
                )
                AND stationsproduct.station_id = ".$station_id.$this->validation."
                
                GROUP BY porder.id


                "
            ));
    }   
    
    public function getStationWTDPerformance($station_id)
    {
            return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DAY(porder.updated_at) as day

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id JOIN stationsproduct on stationsproduct.sproduct_id =sp.id

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND MONTH (porder.updated_at) = MONTH(CURDATE())
                AND WEEK(porder.updated_at) = WEEK (CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND porder.id  IN (
                select sorder.porder_id from sorder
                WHERE sorder.station_id=".$station_id."
                )
                AND stationsproduct.station_id = ".$station_id.$this->validation."
                
                GROUP BY DAY(porder.updated_at)


                "
            ));
    }
    
    public function getStationSincePerformanceTotal($station_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id 
                JOIN stationsproduct on stationsproduct.sproduct_id =sp.id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE 
                stationsproduct.station_id = ".$station_id."
                AND porder.status IN (".$this->cStatus.")
                AND porder.id  IN (
                select sorder.porder_id from sorder
                WHERE sorder.station_id=".$station_id.$this->validation."
                )
                
                GROUP BY porder.id


                "
            ));
    }   
    
    public function getStationSincePerformance($station_id)
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                Year(porder.updated_at) as year

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN sproduct as sp on sp.product_id= op.product_id 
                JOIN stationsproduct on stationsproduct.sproduct_id =sp.id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE 
                stationsproduct.station_id = ".$station_id."
                AND porder.status IN (".$this->cStatus.")
                AND porder.id  IN (
                select sorder.porder_id from sorder
                WHERE sorder.station_id=".$station_id.$this->validation."
                )
                
                GROUP BY Year(porder.updated_at)


                "
            ));
    }
    /**********************ADMIN AREA **************************************/ 
 
    public function getAdminSincePerformanceTotal()
    {
        return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code
                WHERE
                porder.status IN (".$this->cStatus.")
                ".$this->validation."
                GROUP BY porder.id


                "
            ));
    }
 
    public function getAdminSincePerformance()
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                Year(porder.updated_at) as year

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code
                WHERE
                porder.status IN (".$this->cStatus.")
                ".$this->validation."
                GROUP BY Year(porder.updated_at)


                "
            ));
    }
    
    public function getAdminWTDPerformanceTotal()
    {
            return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                ".$this->validation."
                AND MONTH (porder.updated_at) = MONTH(CURDATE())
                AND WEEK(porder.updated_at) = WEEK (CURDATE())
               
                
                GROUP BY porder.id


                "
            ));
    }   
    
    public function getAdminWTDPerformance()
    {
            return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DAY(porder.updated_at) as day

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                ".$this->validation."
                AND MONTH (porder.updated_at) = MONTH(CURDATE())
                AND WEEK(porder.updated_at) = WEEK (CURDATE())
               
                
                GROUP BY DAY(porder.updated_at)


                "
            ));
    }
    
    public function getAdminYTDPerformanceTotal()
    {
        return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code
                

                WHERE YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")           
                ".$this->validation."
                
                GROUP BY porder.id


                "
            ));
    }   
    
    public function getAdminYTDPerformance()
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                Month(porder.updated_at) as month

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code
                

                WHERE YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")           
                ".$this->validation."
                
                GROUP BY Month(porder.updated_at)


                "
            ));
    }
    /*
    X-Axis is Days

    */ 

    public function getAdminMTDPerformanceTotal()
    {
                return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code
                

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND MONTH (porder.updated_at) = MONTH (CURDATE())
                AND porder.status IN (".$this->cStatus.")
                ".$this->validation."
                
                GROUP BY porder.id


                "
            ));
    }
    
    public function getAdminMTDPerformance()
    {
                return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DAY(porder.updated_at) as day

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                JOIN users on users.id= porder.user_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code
                

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND MONTH (porder.updated_at) = MONTH (CURDATE())
                AND porder.status IN (".$this->cStatus.")
                ".$this->validation."
                
                GROUP BY DATE(porder.updated_at)


                "
            ));
    }
    public function getAdminProductPerformance()
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.id as product_id,
                product.name as name,
                product.description as description

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                WHERE porder.status IN (".$this->cStatus.")

             
                
                group by product.parent_id


                "
            ));
    }
    public function getAdminCategoryPerformance()
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.category_id as category_id,
                category.name as name,
                category.description as description

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                
                JOIN category on category.id= product.category_id
                WHERE porder.status IN (".$this->cStatus.")
                group by product.category_id


                "
            )); 
    }
    public function getAdminBrandPerformance()
    {
        return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.brand_id as brand_id,
                brand.name as name,
                brand.description as description

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                
                JOIN brand on brand.id =product.brand_id
                WHERE porder.status IN (".$this->cStatus.")
                group by product.brand_id


                "
            ));        
    }
    public function getAdminDayPerformance()
    {
         return DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DAY(porder.updated_at) as day

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND MONTH (porder.updated_at) = MONTH (CURDATE())
                AND DAY(porder.updated_at) = DAY(CURDATE())
                ".$this->validation."
                
                GROUP BY DATE(porder.updated_at)


                "
            ));
    }
    
    public function getAdminDayPerformanceTotal()
    {
         return DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                IFNULL(nporderid.nporder_id,LPAD(porder.id,20,'E')) as nporder_id,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM 
                porder
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                

                WHERE 
                YEAR(porder.updated_at) = YEAR(CURDATE())
                AND porder.status IN (".$this->cStatus.")
                AND MONTH (porder.updated_at) = MONTH (CURDATE())
                AND DAY(porder.updated_at) = DAY(CURDATE())
                ".$this->validation."
                
                GROUP BY porder.id


                "
            ));
    }
    
    public function getAdminSubCatPerformance()
    {
         $ret= DB::select(DB::raw(
                "
                SELECT 
                count(porder.id) as ordercount,
                SUM((op.order_price*quantity)) as sales,
                SUM((op.quantity)) as sales_quantity,
                product.subcat_id as subcat_id,
                product.subcat_level as subcatlevel

                FROM 
                porder
                JOIN orderproduct as op on op.porder_id = porder.id
                JOIN product on product.id = op.product_id
                WHERE porder.status IN (".$this->cStatus.")
                group by product.subcat_id


                "
            )); 
         foreach ($ret as $r) {
             $r->name=DB::table("subcat_level_".$r->subcatlevel)->where('id',$r->subcat_id)->pluck('name');
         }
         return $ret;
    }
    /*
        returns account creation time difference from now
    */ 
    public function getStartDate($id,$type)
    {

        $created_at=new DateTime();
        try {
            if ($type == "station") {
                $station=Station::find($id);
                $created_at=new DateTime($station->updated_at);
            }elseif ($type == "merchant") {
                $merchant=Merchant::find($id);
                $created_at=$merchant->updated_at;
            }elseif ($type == "admin") {
                
            }
        } catch (\Exception $e) {
            return $e;
            $created_at=new DateTime();
        }
        $now=new DateTime();
        $diff = $created_at->diff($now);
        $year=$diff->y;
        $month=$diff->m;
        $day=$diff->d;
        $totalDays=$diff->days;
        $ret=[$totalDays];
        if ($year >= 1) {
            array_push($ret,"since");
        }elseif ($year == 1) {
            array_push($ret,"ytd");
        }
        else{
            array_push($ret,"mtd");
        }
        return $ret;
    }   
}
