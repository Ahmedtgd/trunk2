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

class MerchantProfessionalController extends Controller {

    public function professional()
    {
		$currency = '';
		if(!is_null(Currency::where('active',true)->first())){
            $currency = Currency::where('active',true)->first()->code;
        }

        $merchantsc = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id','users.first_name as first_name', 'users.last_name as last_name', 'users.email as email', 'country.name as nationality', 'sales_staff.recruiter_user_id as recruiter_id', 'sales_staff.target_merchant as target_merchant', 'sales_staff.target_revenue as target_revenue','sales_staff.bonus as bonus', 'sales_staff.status')->where('sales_staff.type','mcp')
		->leftjoin('users', 'sales_staff.user_id', '=', 'users.id')
		->leftjoin('country', 'users.nationality_country_id', '=', 'country.id')
        ->orderBy('sales_staff.created_at','desc')
		->get();

        return view('master.merchantProfessional',['merchantsconsultant'=>$merchantsc, 'currency' => $currency, 'error_code'=> '5']);
    }
	
    public function approval($id)
    {
		$currency = '';
		if(!is_null(Currency::where('active',true)->first())){
            $currency = Currency::where('active',true)->first()->code;
        }

        $merchantsc = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id','users.first_name as first_name', 'users.last_name as last_name', 'users.email as email', 'country.name as nationality', 'sales_staff.recruiter_user_id as recruiter_id', 'sales_staff.target_merchant as target_merchant', 'sales_staff.target_revenue as target_revenue','sales_staff.bonus as bonus', 'sales_staff.status')->where('sales_staff.type','mcp')->where('sales_staff.user_id',  $id)
		->leftjoin('users', 'sales_staff.user_id', '=', 'users.id')
		->leftjoin('country', 'users.nationality_country_id', '=', 'country.id')
        ->orderBy('sales_staff.created_at','desc')
		->get();

        return view('master.merchantProfessionalApproval',['merchantsconsultant'=>$merchantsc, 'currency' => $currency, 'error_code'=> '5']);
    }	

    public function approveSalesStaff() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
            return \App\Classes\AdminApproveHelper::approveUser($inputs);
        }
    }

    //function for saving remarks of station
    public function saveSalesStaffRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        $res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
            $res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
            echo $res;
        }
        //echo "Hola";
    }

    public function sales_staff_remarks($id){
        $remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status from remark inner join sales_staffremark on sales_staffremark.remark_id = remark.id where sales_staffremark.sales_staff_id = " . $id . " order by remark.created_at desc"));
        return json_encode($remarks);
    }

}

?>
