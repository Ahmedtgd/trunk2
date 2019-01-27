<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Input;

class AdminCommissionController extends Controller
{
    public function index(){

    	$merchants = DB::select(DB::raw(
            "select
            m.id as id,
            m.mc_sales_staff_commission as mcsc,
            m.mc_sales_staff_id as mcid,
            m.referral_sales_staff_commission as rsc,
            m.referral_sales_staff_id as rid,
            m.mcp1_sales_staff_commission as m1sc,
            m.mcp1_sales_staff_id as m1id,
            m.mcp2_sales_staff_commission as m2sc,
            m.mcp2_sales_staff_id as m2id,
            m.psh_sales_staff_commission as psc,
            m.psh_sales_staff_id as pid,
            (p.retail_price * (m.osmall_commission/100)) as amount,
            ((p.retail_price * (m.osmall_commission/100)) -
            (m.mc_sales_staff_commission + m.referral_sales_staff_commission +
            m.mcp1_sales_staff_commission + m.mcp2_sales_staff_commission +
            m.psh_sales_staff_commission)) as company
            from
            merchant m,
            sales_staff ssmc,
            merchantproduct mp ,
            orderproduct op ,
            product p
            where
            m.mc_sales_staff_id = ssmc.id and
            ssmc.type = 'mct' and
            mp.merchant_id = m.id and
            mp.product_id = op.product_id and
            op.product_id = p.id
            union all select
            m.id as id,
            m.mc_sales_staff_commission as mcsc,
            m.mc_sales_staff_id as mcid,
            m.referral_sales_staff_commission as rsc,
            m.referral_sales_staff_id as rid,
            m.mcp1_sales_staff_commission as m1sc,
            m.mcp1_sales_staff_id as m1id,
            m.mcp2_sales_staff_commission as m2sc,
            m.mcp2_sales_staff_id as m2id,
            m.psh_sales_staff_commission as psc,
            m.psh_sales_staff_id as pid,
            (p.retail_price * (m.osmall_commission/100)) as amount,
            ((p.retail_price * (m.osmall_commission/100)) -
            (m.mc_sales_staff_commission + m.referral_sales_staff_commission +
            m.mcp1_sales_staff_commission + m.mcp2_sales_staff_commission +
            m.psh_sales_staff_commission)) as company
            from
            merchant m,
            sales_staff ssmc,
            merchantproduct mp ,
            orderproduct op , product p
            where
            m.psh_sales_staff_id = ssmc.id and
            ssmc.type = 'psh' and
            mp.merchant_id = m.id and
            mp.product_id = op.product_id
            and op.product_id = p.id
            union all select
            m.id as id,
            m.mc_sales_staff_commission as mcsc,
            m.mc_sales_staff_id as mcid,
            m.referral_sales_staff_commission as rsc,
            m.referral_sales_staff_id as rid,
            m.mcp1_sales_staff_commission as m1sc,
            m.mcp1_sales_staff_id as m1id,
            m.mcp2_sales_staff_commission as m2sc,
            m.mcp2_sales_staff_id as m2id,
            m.psh_sales_staff_commission as psc,
            m.psh_sales_staff_id as pid,
            (p.retail_price * (m.osmall_commission/100)) as amount,
            ((p.retail_price * (m.osmall_commission/100)) -
            (m.mc_sales_staff_commission + m.referral_sales_staff_commission +
            m.mcp1_sales_staff_commission + m.mcp2_sales_staff_commission +
            m.psh_sales_staff_commission)) as company
            from
            merchant m,
            sales_staff ssmc,
            merchantproduct mp,
            orderproduct op,
            product p
            where
            m.mc_sales_staff_id = ssmc.id and
            ssmc.type = 'mcp' and
            mp.merchant_id = m.id and
            mp.product_id = op.product_id and
            op.product_id = p.id"
        ));

        $recruiters = DB::select(DB::raw(
                    "select
                    ss.id as uid,
                    st.id as mid,
                    u.first_name as fn,
                    (p.retail_price * (st.osmall_commission/100)) as commission
                    from
                    sales_staff ss,
                    station st,
                    users u,
                    sorder so,
                    porder po,
                    stationsproduct sp,
                    product p
                    where
                    ss.type = 'str' and
                    (so.porder_id = po.id and po.user_id = st.user_id and st.id = sp.station_id and p.id = sp.sproduct_id)
                    group by ss.id"
                ));


        $smms = DB::select(DB::raw(
            "select
            so.product_id as pid,
            sum(si.quantity) as unit,
            sum(pmt.receivable) as sdsmm,
            m.osmall_commission as commission,
            (sum(pmt.receivable)*(m.osmall_commission/100)) as revenue,
            ((sum(pmt.receivable)*(m.osmall_commission/100)) * (m.smm_sales_staff_commission/100)) as asmm,
            m.smm_sales_staff_commission as asmmp,
            count(si.response = 'buy') as sclick,
            (((sum(pmt.receivable)*(m.osmall_commission/100)) * (m.smm_sales_staff_commission/100))/count(si.response = 'buy')) as average,
            m.id as mid
            from
            smmout so,
            smmin si,
            payment pmt,
            merchant m,
            product p,
            porder po
            where
            si.response = 'buy' and
            si.smmout_id = so.id and
            si.porder_id = po.id and
            po.payment_id = pmt.id and
            so.user_id = m.user_id and
            so.product_id = p.id
            group by pid"
            ));
    	return view('admin_commission')
            ->with('merchants',$merchants)
            ->with('recruiters',$recruiters)
            ->with('smms',$smms);
    }

    public function editCommission(){
        $column = Input::get('col');
        $id = Input::get('id');
        $val = Input::get('val');

        if(isset($id) and isset($val)){
            if($column == 'mc'){
                DB::table('merchant')->where('id',$id)->update(['mc_sales_staff_commission' => $val]);
            }elseif($column == 'rc'){
                DB::table('merchant')->where('id',$id)->update(['referral_sales_staff_commission' => $val]);
            }elseif($column == 'm1'){
                DB::table('merchant')->where('id',$id)->update(['mcp1_sales_staff_commission' => $val]);
            }elseif($column == 'm2'){
                DB::table('merchant')->where('id',$id)->update(['mcp2_sales_staff_commission' => $val]);
            }elseif($column == 'pc'){
                DB::table('merchant')->where('id',$id)->update(['psh_sales_staff_commission' => $val]);
            }elseif($column == 'smm'){
                DB::table('merchant')->where('id',$id)->update(['smm_sales_staff_commission' => $val]);
            }
        }else{
            echo 'fail';
        }
    }

    public function editSalesstaff($id){
        $commission = Input::get('commission');
		DB::table('sales_staff')->where('id',$id)->update(['commission' => $commission]);
        echo 'OK';
    }

    public function editSalesstaffmcr($id){
        $target_revenue = Input::get('target_revenue');
		DB::table('sales_staff')->where('id',$id)->update(['target_revenue' => ($target_revenue*100)]);
        echo 'OK';
	}

    public function editSalesstaffmcm($id){
        $target_merchant = Input::get('target_merchant');
		DB::table('sales_staff')->where('id',$id)->update(['target_merchant' => $target_merchant]);
        echo 'OK';
	}

    public function editSalesstaffmc($id){
        $commission = Input::get('commission');
		DB::table('sales_staff')->where('id',$id)->update(['commission' => $commission]);
        echo 'OK';
    }

    public function editStation($id){
        $commission = Input::get('commission');
		DB::table('station')->where('id',$id)->update(['osmall_commission' => $commission]);
        echo 'OK';
    }

    public function editStationtype($id){
        $type = Input::get('type');
		DB::table('station')->where('id',$id)->update(['commission_type' => $type]);
        echo 'OK';
    }

    public function editStationb2b($id){
        $commission = Input::get('commission');
		DB::table('station')->where('id',$id)->update(['b2b_osmall_commission' => $commission]);
        echo 'OK';
    }

    public function editStationtypeb2b($id){
        $type = Input::get('type');
		DB::table('station')->where('id',$id)->update(['b2b_commission_type' => $type]);
        echo 'OK';
    }

    public function editMerchant($id){
        $commission = Input::get('commission');
		DB::table('merchant')->where('id',$id)->update(['osmall_commission' => $commission]);
        echo 'OK';
    }

    public function editMerchantb2b($id){
        $commission = Input::get('commission');
		DB::table('merchant')->where('id',$id)->update(['b2b_osmall_commission' => $commission]);
        echo 'OK';
    }

	public function editMerchanttype($id){
        $type = Input::get('type');
		DB::table('merchant')->where('id',$id)->update(['commission_type' => $type]);
        echo 'OK';
    }

    public function editMerchanttypeb2b($id){
        $type = Input::get('type');
		DB::table('merchant')->where('id',$id)->update(['b2b_commission_type' => $type]);
        echo 'OK';
    }

    public function editSmm($id){
        $commission = Input::get('commission');
		DB::table('merchant')->where('id',$id)->update(['smm_sales_staff_commission' => $commission]);
        echo 'OK';
    }

    public function editLogistic($id){
        $commission = Input::get('commission');
		DB::table('logistic')->where('id',$id)->update(['logistic_commission' => $commission]);
        echo 'OK';
    }

    public function editProduct($id){
        $commission = Input::get('commission');
		DB::table('product')->where('parent_id',$id)->update(['osmall_commission' => $commission]);
        echo 'OK';
    }

    public function editProductb2b($id){
        $commission = Input::get('commission');
		DB::table('product')->where('parent_id',$id)->update(['b2b_osmall_commission' => $commission]);
        echo 'OK';
    }

    public function editProductpusher($id){
        $commission = Input::get('commission');
        DB::table('product')->where('id',$id)->update(['psh_sales_staff_commission' => $commission]);
        echo 'OK';
    }

    public function openwishComission(){
        $global = DB::table('global')->where('id', 1)->first();
        //dd($global->ow_commission);
        return view('commissions.openwish')->with('ow_commision',$global->ow_commission);
    }

    public function station_fees($id){
        $order_administration_fee = Input::get('order_fee');
        $annual_subscription_fee = Input::get('annual_fee');
		DB::table('station')->where('id',$id)->update(['order_administration_fee' => $order_administration_fee * 100, 'annual_subscription_fee' => $annual_subscription_fee * 100]);
        echo 'OK';
    }

    public function merchant_fees($id){
        $order_administration_fee = Input::get('order_fee');
        $annual_subscription_fee = Input::get('annual_fee');
		DB::table('merchant')->where('id',$id)->update(['order_administration_fee' => $order_administration_fee * 100, 'annual_subscription_fee' => $annual_subscription_fee * 100]);
        echo 'OK';
    }

	public function merchant_order_fee($id){
        $order_administration_fee = Input::get('order_fee');
		DB::table('merchant')->where('id',$id)->update(['order_administration_fee' => $order_administration_fee * 100]);
        echo 'OK';
    }

	public function merchant_annual_fee($id){
        $annual_subscription_fee = Input::get('annual_fee');
		DB::table('merchant')->where('id',$id)->update(['annual_subscription_fee' => $annual_subscription_fee * 100]);
        echo 'OK';
    }

	public function merchant_b2b_fee($id){
        $b2b_fee = Input::get('b2b_fee');
		DB::table('merchant')->where('id',$id)->update(['b2b_osmall_commission' => $b2b_fee,'b2b_commission_type'=>'std']);
        echo 'OK';
    }

	public function merchant_reg_fee($id){
        $fee = Input::get('fee');
		DB::table('merchant')->where('id',$id)->update(['osmall_commission' => $fee,'commission_type'=>'std']);
        echo 'OK';
    }

	public function station_order_fee($id){
        $order_administration_fee = Input::get('order_fee');
		DB::table('station')->where('id',$id)->update(['order_administration_fee' => $order_administration_fee * 100]);
        echo 'OK';
    }

	public function station_annual_fee($id){
        $annual_subscription_fee = Input::get('annual_fee');
		DB::table('station')->where('id',$id)->update(['annual_subscription_fee' => $annual_subscription_fee * 100]);
        echo 'OK';
    }

	public function station_b2b_fee($id){
        $b2b_fee = Input::get('b2b_fee');
		DB::table('station')->where('id',$id)->update(['b2b_osmall_commission' => $b2b_fee,'b2b_commission_type'=>'std']);
        echo 'OK';
    }

	public function station_reg_fee($id){
        $fee = Input::get('fee');
		DB::table('station')->where('id',$id)->update(['osmall_commission' => $fee,'commission_type'=>'std']);
        echo 'OK';
    }

    public function suscriptionfeeComission(){
        $global = DB::table('global')->where('id', 1)->first();
		$fees  = ['sfee' => $global->station_annual_subscription_fee,
				  'mfee' => $global->merchant_annual_subscription_fee];
        return view('commissions.suscriptionfee')->with('fees', $fees);
    }

    public function saveopenwishComission(Request $request){
        $r = $request->all();
        $ow_commision = $r['ow_commission'];

        DB::table('global')
            ->where('id', 1)
            ->update(['ow_commission' => $ow_commision]);

        return view('commissions.openwish')->with('ow_commision',$ow_commision);
    }

    public function savesuscriptionfeeComission(Request $request){
        $r = $request->all();

        $sfee = $r['station_annual_subscription_fee'] * 100;
        $mfee = $r['merchant_annual_subscription_fee'] * 100;

        DB::table('global')
            ->where('id', 1)
            ->update(['merchant_annual_subscription_fee' => $mfee,
					  'station_annual_subscription_fee'  => $sfee]);

        return view('commissions.suscriptionfee')->with('fees',
			['sfee' => $sfee, 'mfee' => $mfee]);
    }

    public function logistic()
    {
        //$merchants = Merchant::paginate(10);
        $logistic = DB::table('logistic')->leftJoin('company','logistic.company_id','=','company.id')->select('logistic.*','company.company_name')->get();

		return view('admin.adminComission',['logistic'=>$logistic]);
    }
}
