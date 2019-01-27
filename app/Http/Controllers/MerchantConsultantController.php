<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\SalesStaff;
use App\Models\User;
use App\Models\Product;
use App\Models\Currency;

class MerchantConsultantController extends Controller {

    public function approval($id) {
        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }

        $merchantsc = DB::table('sales_staff')->select('sales_staff.id as ssid',
                                                       'sales_staff.user_id as user_id',
                                                       'users.first_name as first_name',
                                                       'users.last_name as last_name',
                                                       'users.email as email',
                                                       'country.name as nationality',
                                                       'sales_staff.recruiter_user_id as recruiter_id',
                                                       'sales_staff.target_merchant as target_merchant',
                                                       'sales_staff.target_revenue as target_revenue',
                                                       'sales_staff.bonus as bonus',
                                                       'sales_staff.status')->where('sales_staff.type',
                                                                                    'mct')->where('sales_staff.user_id',
                                                                                    $id)
                ->leftjoin('users', 'sales_staff.user_id', '=', 'users.id')
                ->leftjoin('country', 'users.nationality_country_id', '=',
                           'country.id')
                ->orderBy('sales_staff.created_at', 'desc')
                ->get();
        // return $merchantsc;
        return view('master.merchantConsultantApproval',
                    ['merchantsconsultant' => $merchantsc, 'currency' => $currency]);
    }

    public function consultant() {
        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }

        $merchantsc = DB::table('sales_staff')->select('sales_staff.id as ssid',
                                                       'sales_staff.user_id as user_id',
                                                       'users.first_name as first_name',
                                                       'users.last_name as last_name',
                                                       'users.email as email',
                                                       'country.name as nationality',
                                                       'sales_staff.recruiter_user_id as recruiter_id',
                                                       'sales_staff.target_merchant as target_merchant',
                                                       'sales_staff.target_revenue as target_revenue',
                                                       'sales_staff.bonus as bonus',
                                                       'sales_staff.status')->where('sales_staff.type',
                                                                                    'mct')
                ->leftjoin('users', 'sales_staff.user_id', '=', 'users.id')
                ->leftjoin('country', 'users.nationality_country_id', '=',
                           'country.id')
                ->orderBy('sales_staff.created_at', 'desc')
                ->get();
        // return $merchantsc;
        return view('master.merchantConsultant',
                    ['merchantsconsultant' => $merchantsc, 'currency' => $currency]);
    }

    public function approveSalesStaff() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if (!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role'])) {
            return \App\Classes\AdminApproveHelper::approveUser($inputs);
        }
    }

    //function for saving remarks of station
    public function saveSalesStaffRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        $res    = "";
        if (!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role'])) {
            $res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
            echo $res;
        }
        //echo "Hola";
    }

    public function sales_staff_remarks($id) {

        $remarks = DB::select(DB::raw("select 
          remark.remark,
           nbuyerid.nbuyer_id as user_id,
           DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status 
           from remark inner join sales_staffremark on sales_staffremark.remark_id = remark.id 
           join nbuyerid on nbuyerid.user_id=remark.user_id


           where sales_staffremark.sales_staff_id = " . $id . " order by remark.created_at desc"));


        return json_encode($remarks);
    }

    public function index() {
        
        $merchantConsultant = DB::table('merchant')
            ->leftjoin('sales_staff', 'merchant.user_id', '=', 'sales_staff.user_id')
            ->leftjoin('users', 'merchant.user_id', '=', 'users.id')
            ->select('users.id as user_id',
                    DB::raw('CONCAT(users.first_name, " ", users.last_name) AS name'),
                    'merchant.status', 'merchant.created_at as since')
            ->where('sales_staff.type','=','mct')
            ->get();
        
        
    foreach ($merchantConsultant as $key => $merchant) {
                $sales_since[] = DB::select("select SUM(payment.receivable) as sales_since FROM merchant 

                    LEFT JOIN sales_staff ON (merchant.user_id = sales_staff.user_id 
                                              AND sales_staff.id = merchant.mc_sales_staff_id)
                    LEFT JOIN merchantproduct ON (merchant.id = merchantproduct.merchant_id)
                    LEFT JOIN orderproduct ON (orderproduct.porder_id = merchantproduct.product_id)
                    LEFT JOIN porder ON (orderproduct.porder_id = porder.id)
                    LEFT JOIN payment ON (porder.payment_id = payment.id)

                    WHERE sales_staff.type = 'mct' AND merchant.user_id = ".$merchant->user_id);
                
                
                $sales_ytd[] = DB::select("select SUM(payment.receivable) as sales_since FROM merchant 

                    LEFT JOIN sales_staff ON (merchant.user_id = sales_staff.user_id 
                                              AND sales_staff.id = merchant.mc_sales_staff_id)
                    LEFT JOIN merchantproduct ON (merchant.id = merchantproduct.merchant_id)
                    LEFT JOIN orderproduct ON (orderproduct.porder_id = merchantproduct.product_id)
                    LEFT JOIN porder ON (orderproduct.porder_id = porder.id)
                    LEFT JOIN payment ON (porder.payment_id = payment.id)

                    WHERE sales_staff.type = 'mct' AND porder.created_at >= concat(year(curdate()),'-01-01')  AND merchant.user_id = ".$merchant->user_id);
    }
        //dd($merchantConsultant);
        

        return view('admin.adminMerchantConsultant');
    }

    public function showaarea() {
        return view('admin.adminMerchantConsultantArea');
    }

}

?>
