<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Models\User;
use App\Models\Product;
use App\SProduct;
// use App\User;
use App\Models\StationProduct;
use App\Models\Station;
use Log;

class WarehouseController extends Controller
{
	protected $station_id;

	public function __construct()
	{
		# code...
        if (!Auth::check()) {
            # code...
            return "Login required";
        }
        $user_id=Auth::user()->id;
        try {
            $this->station_id= DB::table('station')->
				where('user_id',$user_id)->pluck('id');

            //return $this->index($station_id);
        } catch (\Exception $e) {
            return "Error redirecting to station: $e";
        }
	}

    public function redirect($uid = null)
    {
        # code...
        if (!Auth::check()) {
            # code...
            return "Login required";
        }
        if(is_null($uid)){
			$user_id = Auth::id();
		} else {
			$user_id = $uid;
		}
        try {
            $station_id= DB::table('station')->
				where('user_id',$user_id)->pluck('id');

            return $this->index($station_id, $user_id);

        } catch (\Exception $e) {
            return "Error redirecting to station: $e";
        }
    }

	public function sellerWareHouse($id = null)
	{
		if (!Auth::check()) {
            return "Please login";
        }

       	
    	if ($id != null) {
            $user_id= $id;
        } else {
            $user_id= Auth::user()->id; 
        }
        $selluser = User::find($user_id);


        if(isset($user_id)){

           /* $location = DB::table('fairlocation')->select('id')->where('user_id', $user_id)->whereNull('deleted_at')->get();

            $location_ids = array();

            if(count($location) > 0) {
                foreach ($location as $key => $loc) {
                    $location_ids[] = $loc->id;
                }
            }*/

            $warehouses =DB::table("warehouse")
            ->join("fairlocation","fairlocation.id","=","warehouse.location_id")
           /* ->join("branch","branch.location_id","=","fairlocation.id")*/
            ->whereNull("fairlocation.deleted_at")
            ->whereNull("warehouse.deleted_at")
            ->where("fairlocation.user_id",$user_id)
            ->select("fairlocation.*","warehouse.id as warehouse_id","fairlocation.location as branch_name")
            ->groupBy("warehouse_id")
            ->get()
            ;

          /*  if(count($location_ids) > 0) {
                $warehouses = DB::table('warehouse')

                                    ->whereIn('location_id', $location_ids)
                                    ->select('id', 'name', 'description', 'company_id' ,'location_id', 'address_id')
                                    ->get();
            }
        	
            if($warehouses){
                foreach ($warehouses as $warehproductRack_ledgerouse) {
                   
                    $productList = DB::table('warehouse')
                    ->JOIN('rack', 'rack.warehouse_id', '=', 'warehouse.id')
                    ->JOIN('rackproduct', 'rackproduct.rack_id', '=', 'rack.id')
                    ->JOIN('product', 'rackproduct.product_id', '=', 'product.id')
                    ->leftJoin('tproduct', 'product.id', '=', 'tproduct.product_id')
                    ->leftJoin('productbc','product.id','=','productbc.product_id')
                    ->leftJoin('bc_management','bc_management.id','=','productbc.bc_management_id')
                    ->leftJoin('ordertproduct', 'ordertproduct.tproduct_id','=','tproduct.id')
                    ->leftJoin('porder', 'porder.id','=','ordertproduct.porder_id')
                    ->leftJoin('qrbc_content', 'qrbc_content.product_id','=','product.id')
                    ->where('warehouse.id', $warehouse->id)
                    ->select('rack.rack_no',
                        'product.name as product_name',
                        'bc_management.image_path as bcpath',
                        'bc_management.barcode as bcode',
                        'bc_management.barcode_type as bcode_type',
                        'product.id',
                        'rackproduct.qty as quantity',
                        'qrbc_content.type',
                        'qrbc_content.content',
                        'warehouse.id as warehouse_id')
                    ->get();


                    $result = collect($productList)->map( function($x){
                        return (array) $x;
                    })->toArray();

                    $warehouse->product_list = $result;
                   
                }

            }
            */
            //dd($warehouses);

            //return $warehouses;
    		return view('seller.sellerwarehouse')->with('selluser', $selluser)->with('warehouses', $warehouses);
        }
	}
	
    public function sellerWareHouseApi()
    {
    	if (!Auth::check()) {
            return "Please login";
        }

        $user_id=Auth::user()->id;
       	$selluser = User::find($user_id);
    	$merchant_id= DB::table('merchant')->
			where('user_id',$user_id)->pluck('id');

    	$warehouses=DB::table('merchant')->
			Join('branch','branch.merchant_id','=','merchant.id')->
			join('fairlocation','fairlocation.id','=','branch.location_id')->
			where('merchant.id','=', $merchant_id)->
			select('branch.id as bid', 'branch.name', 'branch.code')->
			get();

		print json_encode($warehouses);
		exit();
    }

    public function store_racks(Request $request){
        $w_id = $request['warehouse_id'];
        $rack_no = $request['rack_no'];
        $description = $request['description'];
        $remarks = $request['remarks'];

        $exists = DB::table('rack')->where(['rack_no' => $rack_no,'warehouse_id' => $w_id])->first();
        if($exists){
            DB::table('rack')->where(['rack_no' => $rack_no,'warehouse_id' => $w_id])->update(['description' => $description]);
        }else{
            DB::table('rack')->insert(['warehouse_id' => $w_id, 'rack_no' => $rack_no, 'description' => $description,'remarks' => $remarks]);
        }



        return response()->json(['response' => 'success']);
    }
	
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function warehouse_rack_info($warehouse_id,$uid=NULL)
    {

        $ret=array();
    
        try{
            $i=0;
            $raw_data=DB::select(DB::raw("

                    SELECT
                    @s:=@s+1 serial_number,
                    '--' as expiry_date,remarks,rack.description,
                    rack.rack_no,
                    COUNT(DISTINCT(rackproduct.product_id)) as product_count
                    FROM 
                    (SELECT @s:= 0) AS s,
                    rack
                    LEFT JOIN rackproduct ON rackproduct.rack_id=rack.id
                    
                    
                    WHERE 
                    rack.deleted_at IS NULL
                    AND rack.warehouse_id=$warehouse_id 
                    AND rackproduct.deleted_at is NULL 
                    
                    group by rack_no

                "));


            Log::debug('-----------Allocated Products Count----------------');
         /*   foreach($raw_data as $data){
                Log::debug(json_encode($data));
            }
*/
            Log::debug('-----------Allocated Products Count----------------');

            $ret["status"]="success";
            $ret["data"]=$raw_data;


        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }

        return response()->json($ret);
    }


    public function productRack_ledger($rack_id,$product_id,$id=null){

 		if (!Auth::check()) {
            return "Please login";
        }
       // dd("Hit");
    	if ($id != null) {
            $user_id= $id;
        } else {
            $user_id= Auth::user()->id; 
        }
        $selluser = User::find($user_id);

        $name = "";

        $racks = DB::table("rackproduct")->
        leftjoin("rack","rack.id","=","rackproduct.rack_id")->
        where("rackproduct.product_id",$product_id)->
        where("rack.rack_no",$rack_id)
        ->first();

        // dd($racks);

//         $racks=DB::table("rack")->
// 			leftjoin("warehouse","warehouse.id","=","rack.warehouse_id")->
// 			where("rack_no",$rack_id)->first();

        $data=json_encode($racks);
        $arr = (array) json_decode($data);
// 		// dd($arr);

// 	//	dump($arr);
// 	//	dump($user_id);

        $warehouse = DB::table("warehouse")->
			join("fairlocation","fairlocation.id","=","warehouse.location_id")->

//            ->join("branch","branch.location_id","=","fairlocation.id")
            whereNull("fairlocation.deleted_at")->
            whereNull("warehouse.deleted_at")->
            where("fairlocation.user_id",$user_id)->
            where("warehouse.id",$arr['warehouse_id'])->
            select("fairlocation.*","warehouse.id as warehouse_id",
				"fairlocation.location as branch_name")->
            groupBy("warehouse_id")->
            first();

        // dd($warehouse);

		// Log::debug('***** warehouse *****');
		// Log::debug(json_encode($warehouse));

		if(!$warehouse){
			$warehouse['branch_name'] = "";
			$name=$warehouse['branch_name'];
		}
		$data=json_encode($warehouse);
		$array = (array)json_decode($data);

        if($array['branch_name']){
            $name=$array['branch_name'];
        }else{
            $array['branch_name'] = "";
        }

        $product_rack = DB::table('stockreportproduct as sp')
            ->select('sp.quantity','sr.id','sr.ttype','sr.updated_at')
            ->join('stockreport as sr','sp.stockreport_id', '=','sr.id')
            ->join('rackproductledger','rackproductledger.transaction_id','=','sp.id')
        ->where('sp.product_id', $product_id)
            ->orderBy('sr.id', 'desc')->get();

       // dd($product_rack);

        if(isset($user_id)){
			return view('seller.sellerproductRack_ledger',
				compact('rack_id','selluser','name','product_rack'));
				//with('selluser', $selluser,'warehouse',$arr,'rack_no',$rack_id);
		}
    }
}
