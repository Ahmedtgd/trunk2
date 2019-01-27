<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

/**
 *
 */
class BuyerWarehouseController extends Controller
{

    public function __construct()
    {

    }

    public function get_buyer_warehouse_data(Request $r, $uid=null)
    {
		Log::debug('get_buyer_warehouse_data()');

		if (!Auth::check()) {
            return "Please login";
        }

		if(empty($r->location_id)) {

            Log::debug('Get this once');
 			return response()->
				json([
					'status'=>'warning',
					'long_message'=>'No location was selected. Please select location first'
				]);
		}

        
		//$u_id = $request->userid;
		/* Merchant's user_id */
		$mid = $r->userid;
        Log::debug('Merchant ID ='. $mid);
		$location_id=$r->location_id;
		$user_id = Auth::user()->id;
		if (Auth::user()->hasRole('adm') && !empty($user_id)) {
			# code...
			$user_id=$uid;
		}
     
        /* This is the merchant_user_id */
		Log::debug('mid   ='.$mid);
		Log::debug('user_id='.$user_id);

		$selluser   = User::find($mid);

		Log::debug(json_encode($selluser));

		$warehouses = DB::table("fairlocation")->
			join("warehouse", "fairlocation.id", "=","warehouse.location_id")->
            join("locationusers", "locationusers.location_id", "=","fairlocation.id")->
			whereNull("fairlocation.deleted_at")->
			whereNull("warehouse.deleted_at")->
			where([
				'fairlocation.user_id' => $mid,
				'locationusers.user_id' => $user_id])->
				select(
					"fairlocation.*",
					"warehouse.id as warehouse_id",
					"fairlocation.location as branch_name")->
			groupBy("warehouse_id")->
			get();


		Log::debug('-----------Warehouses----------------');
		Log::debug(json_encode($warehouses));


		if( count($warehouses) == 0 ){
			return response()->
				json([
					'status'=>'warning',
					'long_message'=>'This location is not a warehouse'
				]);
		} else{
            Log::debug('You should return this');
			return view('buyer.newbuyerinformation.functions.buyer_warehouse')->
				with('selluser', $selluser)->
				with('warehouses', $warehouses)->
				with('location_id', $location_id);
		}
	}


	public function get_description(Request $r){
        if (!Auth::check()) {
            return "Please login";
        }

        $rack_no = $r->rack_no;
        $w_id = $r->ware_id;

        $exists = DB::table('rack')->where(['rack_no' => $rack_no,'warehouse_id' => $w_id])->first();
        if($exists){
            Log::debug('description=' . $exists->description);
            return response()->
            json([
                'description'=>$exists->description,
            ]);
        }else{
            return response()->
            json([
                'description'=>"",

            ]);
        }

    }


}
