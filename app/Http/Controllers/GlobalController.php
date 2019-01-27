<?php

namespace App\Http\Controllers;

use App\Models\Globals;
use App\Models\Currency;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class GlobalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $global = Globals::findOrFail(1);
		$product1 = DB::table('product')->where('id', $global->token_product_id1)->first();
		$product2 = DB::table('product')->where('id', $global->token_product_id2)->first();
		$product3 = DB::table('product')->where('id', $global->token_product_id3)->first();
		$product4 = DB::table('product')->where('id', $global->token_product_id4)->first();
		
		$worldcurrency = DB::table('worldcurrency')->get();
		
		$arrcurrency = [];
		
		foreach($worldcurrency as $curr){
			$arrcurrency[$curr->code] = $curr->code.", ".$curr->description;
		}
		
	//	dd($arrcurrency);
		
        return view("global.index",[
            'globals' => $global,
            'product1' => $product1,
            'product2' => $product2,
            'product3' => $product3,
            'product4' => $product4,
            'worldcurrency' => $arrcurrency
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
	 public function updatecurrency(Request $request){
        $val = $request->get("val");
		DB::table('currency')->update(['code' => $val]);
		return json_encode("OK"); 
	 }
	 
	 public function updatetoken(Request $request)
    {
		$product_id = $request->get("pid");
        $field = $request->get("field");
        $val = $request->get("val");
		DB::table('product')->where('id',$product_id)->update([$field => $val]);
		return json_encode($product_id);
	}
	 
    public function store(Request $request)
    {
        //
        $global = new Globals();
        $global->smm_quota_max = $request->get("smm_quota_max");
        $global->owarehouse_duration = $request->get("owarehouse_duration");
        $global->ipay88_merchant_code = $request->get("ipay88_merchant_code");
        $global->ipay88_merchant_key = $request->get("ipay88_merchant_key");
        $global->max_video_size = $request->get("max_video_size");
        $global->ocbc_branch = $request->get("ocbc_branch");
        $global->ocbc_company_cif = $request->get("ocbc_company_cif");
        $global->ocbc_company_name = $request->get("ocbc_company_name");
        $global->ocbc_company_ac_no = $request->get("ocbc_company_ac_no");
        $global->osmall_commission = $request->get("osmall_commission");
        $global->mc_sales_staff_commission = $request->get("mc_sales_staff_commission");
        $global->mc_with_ref_sales_staff_commission = $request->get("mc_with_ref_sales_staff_commission");
        $global->referral_sales_staff_commission = $request->get("referral_sales_staff_commission");
        $global->mcp1_sales_staff_commission = $request->get("mcp1_sales_staff_commission");
        $global->mcp2_sales_staff_commission = $request->get("mcp2_sales_staff_commission");
        $global->smm_sales_staff_commission = $request->get("smm_sales_staff_commission");
        $global->psh_sales_staff_commission = $request->get("psh_sales_staff_commission");
        $global->str_sales_staff_commission = $request->get("str_sales_staff_commission");
        $global->hyper_duration = $request->get("hyper_duration");
        $global->save();
        return json_encode($global);
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
        $global = Globals::find($id);
        return json_encode($global);
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
        $global = Globals::find($id);
		foreach ($request->all() as $key => $value) {

			/* Convert to cents for all money parameters
			 * List all the money parameters below to make sure
			 * it's properly stored */
			switch($key) {
				case "min_merchant_token_value":
				case "min_station_token_value":
				case "merchant_annual_subscription_fee":
				case "station_annual_subscription_fee":
				case "station_min_order":
				case "delivery_administration_fee":
				case "order_administration_fee":
				case "agreement_stamping_fee":
				case "fpx_commission_b2c_fixed":
				case "fpx_commission_b2b_fixed":
				case "jpay_commission_fixed":
				case "jpay_commission_ccard_fixed":
				case "jpay_real_time_notification":
					$value = $value * 100;
			}
			$global->$key = $value;
		}

		$global->save();
		return null;
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
        $global = Globals::find($id);
        $global->delete();
        return json_encode(['message'=>true]);
    }
}
