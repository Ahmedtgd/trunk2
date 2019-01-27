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
use App\Models\Globals;
use App\Models\Currency;

class MerchantComissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$merchants = Merchant::paginate(10);
        $merchants = Merchant::get();

		return view('admin.adminComission',['merchants'=>$merchants]);
    }

	public function getMerchant($id)
    {
        $merchants = DB::select(DB::raw("SELECT product.id as pid, product.name as pname, product.osmall_commission as osmall_commission, product.segment as segment, product.parent_id as parent_id FROM product, merchantproduct, merchant WHERE merchant.id = merchantproduct.merchant_id and segment = 'b2c' and (merchantproduct.product_id = product.id OR merchantproduct.product_id = product.parent_id) AND merchantproduct.merchant_id = ".$id));

		return view('commissions.merchant_commissions',['merchantscom'=>$merchants,'mid'=>$id]);
		//return json_encode($merchants);
    }

	public function getMerchantb2b($id)
    {
        $merchants = DB::select(DB::raw("SELECT product.id as pid, product.name as pname, product.b2b_osmall_commission as b2b_osmall_commission, product.segment as segment, product.parent_id as parent_id FROM product, merchantproduct, merchant WHERE merchant.id = merchantproduct.merchant_id and segment = 'b2b' and (merchantproduct.product_id = product.id OR merchantproduct.product_id = product.parent_id) AND merchantproduct.merchant_id = ".$id));

		return view('commissions.merchant_commissionsb2b',['merchantscom'=>$merchants,'mid'=>$id]);
		//return json_encode($merchants);
    }	
	
	public function getMerchantpusher($id)
    {
        $merchants = DB::table('product')->select('product.id as pid', 'product.name as pname', 'product.psh_sales_staff_commission as osmall_commission')
		->where('merchant.id',$id)
		->join('merchantproduct', 'merchantproduct.product_id', '=', 'product.id')
		->join('merchant', 'merchantproduct.merchant_id', '=', 'merchant.id')
		->get();

		return json_encode($merchants);
    }

	public function smm()
    {
        $merchants = DB::select(DB::raw('SELECT SUM(payment.receivable) as smmtotal, COUNT(payment.receivable) as smmcount,merchant.id as id, merchant.osmall_commission as osmall_commission, merchant.smm_sales_staff_commission as smm_sales_staff_commission FROM payment, porder, smmin, smmout, product, merchantproduct, merchant WHERE payment.id = porder.payment_id AND smmin.porder_id=porder.id AND smmin.response=\'buy\' AND smmout.id=smmin.smmout_id AND smmout.product_id = product.id AND merchantproduct.product_id = product.id AND merchantproduct.merchant_id = merchant.id GROUP BY merchant.id'));

		return view('admin.adminComission',['smm'=>$merchants]);
    }

    public function professional()
    {
         $merchantsprq = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name')->where('sales_staff.type','mcp')
		->join('users', 'sales_staff.user_id', '=', 'users.id')
		->distinct();

		$merchantspr = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name')->where('sales_staff.type','mcp')
		->join('users', 'sales_staff.user_id', '=', 'users.id')
		->union($merchantsprq)
		->distinct()
		->get();

        return view('admin.adminComission',['merchantsprofessional'=>$merchantspr]);
    }

    public function professional_commission($id)
    {
         $merchantsprq = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name', 'sales_staff.commission as commission', 'merchant.id as merchant_id', 'merchant.company_name as merchant_name', 'merchant.mc_sales_staff_id as mc_id', 'merchant.mcp1_sales_staff_id as mp1_id', 'merchant.mcp2_sales_staff_id as mp2_id', 's1.user_id as mcu_id')
		 ->where('sales_staff.type','mcp')
		 ->where('sales_staff.id',$id)
		->join('users', 'sales_staff.user_id', '=', 'users.id')
		->join('merchant', 'sales_staff.id', '=', 'merchant.mcp2_sales_staff_id')
		->join('sales_staff as s1', 's1.id', '=', 'merchant.mc_sales_staff_id')
		->join('users as u1', 'u1.id', '=', 's1.user_id');

		$merchantspr = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name', 'sales_staff.commission as commission', 'merchant.id as merchant_id', 'merchant.company_name as merchant_name', 'merchant.mc_sales_staff_id as mc_id', 'merchant.mcp1_sales_staff_id as mp1_id', 'merchant.mcp2_sales_staff_id as mp2_id', 's1.user_id as mcu_id')
		 ->where('sales_staff.type','mcp')
		 ->where('sales_staff.id',$id)
		->join('users', 'sales_staff.user_id', '=', 'users.id')
		->join('merchant', 'sales_staff.id', '=', 'merchant.mcp1_sales_staff_id')
		->join('sales_staff as s1', 's1.id', '=', 'merchant.mc_sales_staff_id')
		->join('users as u1', 'u1.id', '=', 's1.user_id')
		->union($merchantsprq)
		->get();

        return json_encode($merchantspr);
    }

    public function consultant()
    {
        $currency = '';
        if(!is_null(Currency::where('active',true)->first())){
            $currency = Currency::where('active',true)->first()->code;
        }

        $merchantsc = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id','users.first_name as first_name', 'users.last_name as last_name', 'sales_staff.target_merchant as target_merchant', 'sales_staff.target_revenue as target_revenue', 'sales_staff.commission as commission')->where('sales_staff.type','mct')
		->join('users', 'sales_staff.user_id', '=', 'users.id')
		->get();
//dd($merchantsc);
        return view('admin.adminComission',['merchantsconsultant'=>$merchantsc, 'currency' => $currency]);
    }

    public function get_user($id){
        $user=User::where('id', $id)->first();
        return json_encode($user);
    }

    public function pusher()
    {
        //$merchants = Merchant::paginate(10);
        $merchantsp = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name', 'sales_staff.commission as commission')->where('sales_staff.type','psh')
		->join('users', 'sales_staff.user_id', '=', 'users.id')
		->get();

        return view('admin.adminComission',['merchantpusher'=>$merchantsp]);
    }

    public function pushermerchants($id)
    {
        //$merchants = Merchant::paginate(10);
        $merchants = DB::table('merchant')->select('merchant.id as mid', 'merchant.company_name as mname')->where('merchant.psh_sales_staff_id',$id)
		->get();

        return json_encode($merchants);
    }

    public function summary()
    {
        $global = Globals::where('id','1')->first();
        //$merchants = Merchant::paginate(10);
        $merchants = DB::select(DB::raw('SELECT SUM(payment.receivable) as total, IF(merchant.osmall_commission>0,merchant.osmall_commission,'. $global->osmall_commission .') as osmall_commission, merchant.id as id, merchant.company_name as company_name, IF(ss1.commission>0,ss1.commission,IF(merchant.mc_sales_staff_commission > 0,merchant.mc_sales_staff_commission,'. $global->mc_sales_staff_commission .')) as mc_sales_staff_commission, ss1.id as mc_sales_staff_id, IF(ss2.commission > 0,ss2.commission,IF(merchant.referral_sales_staff_commission > 0,merchant.referral_sales_staff_commission,'. $global->referral_sales_staff_commission .')) as referral_sales_staff_commission, ss2.id as referral_sales_staff_id, IF(ss3.commission > 0,ss3.commission,IF(merchant.mcp1_sales_staff_commission > 0,merchant.mcp1_sales_staff_commission,'. $global->mcp1_sales_staff_commission .')) as mcp1_sales_staff_commission, ss3.id as mcp1_sales_staff_id, IF(ss4.commission > 0,ss4.commission,IF(merchant.mcp2_sales_staff_commission > 0,merchant.mcp2_sales_staff_commission,'. $global->mcp2_sales_staff_commission .')) as mcp2_sales_staff_commission, ss4.id as mcp2_sales_staff_id, ss5.commission as psh_sales_staff_commission, ss5.id as psh_sales_staff_id, merchant.smm_sales_staff_commission as smm_sales_staff_commission, merchant.str_sales_staff_commission as str_sales_staff_commission, us1.first_name as first_name1, us1.last_name as last_name1, us2.first_name as first_name2, us2.last_name as last_name2, us3.first_name as first_name3, us3.last_name as last_name3, us4.first_name as first_name4, us4.last_name as last_name4, us5.first_name as first_name5, us5.last_name as last_name5, SUM((payment.receivable*product.psh_sales_staff_commission/100)) as psh_com, SUM((payment.receivable*product.smm_sales_staff_commission/100)) as smm_com
		FROM merchant
		LEFT JOIN sales_staff as ss1 ON merchant.mc_sales_staff_id = ss1.id
		LEFT JOIN users as us1 ON ss1.user_id = us1.id
		LEFT JOIN sales_staff as ss2 ON merchant.referral_sales_staff_id = ss2.id
		LEFT JOIN users as us2 ON ss2.user_id = us2.id
		LEFT JOIN sales_staff as ss3 ON merchant.mcp1_sales_staff_id = ss3.id
		LEFT JOIN users as us3 ON ss3.user_id = us3.id
		LEFT JOIN sales_staff as ss4 ON merchant.mcp2_sales_staff_id = ss4.id
		LEFT JOIN users as us4 ON ss4.user_id = us4.id
		LEFT JOIN sales_staff as ss5 ON merchant.psh_sales_staff_id = ss5.id
		LEFT JOIN users as us5 ON ss5.user_id = us5.id
		LEFT JOIN merchantproduct ON merchantproduct.merchant_id = merchant.id
		LEFT JOIN orderproduct ON merchantproduct.product_id = orderproduct.product_id
        LEFT JOIN product ON merchantproduct.product_id = product.id
		LEFT JOIN porder ON orderproduct.porder_id = porder.id
		LEFT JOIN payment ON porder.payment_id = payment.id
		GROUP BY merchant.id'));

		$global = Globals::where('id','1')->first();

        return view('admin.adminComission',['summary'=>$merchants, 'global'=>$global]);
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
