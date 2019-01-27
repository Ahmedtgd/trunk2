<?php 

namespace App\Http\Controllers;

use Response;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Validator;
use Input;
use View;
use DB;
use Auth;
use App\Models\Product;
use App\Models\MerchantProduct;
use App\Models\User;
use Yajra\Datatables\Facades\Datatables;
use App\Models\Esupplier;
use App\Models\Tproduct;
use App\Models\Inventorycost;
use App\Models\Inventorycostproducts;

class InventoryCostController extends Controller {

	protected $repo;
	protected $orepo;

	public function index(Request $request , $id=null) {

         $input = $request->all();
		if ($id != null) {
			$user_id= $id;
        } else {
			$user_id= Auth::user()->id;	
        }
        $selluser = User::find($user_id);

        //get suppliert list
        // $suppliers= Esupplier::get(['id','first_name','last_name']);
        $station_id = DB::table('station')->where('user_id',$user_id)->first();
        if(is_null($station_id )){
            $suppliers = [];
            $station_id = null;
        } else {
            $station_id = DB::table('station')->where('user_id',$user_id)->first()->id;
            $count = 0;
            $suppliers = array();
            $suppliers = DB::select(DB::raw("
                select supplier_id as id, name as value from
                (
                        select concat('mer_', mer.id) as supplier_id, mer.company_name as name
                        from autolink auto
                        inner join merchant mer on auto.responder = mer.id 
                        WHERE auto.initiator = $user_id
                        AND auto.visibility = 1
                        group by auto.responder
                    
                    UNION
                    
                        select concat('sup_', id) as supplier_id, concat('first_name', ' ', 'last_name') as name
                        from esupplier
                    
                )supplier
            "));       
        }

        if(isset($request->productIds) && count($request->productIds) > 0) {
            //gte products list
            $products = Tproduct::with('inventorycostproducts')
            ->join('merchantproduct','merchantproduct.product_id','=','product.id')
            ->whereIn('product.id', $input['productIds'])
            ->orderBy("product.name")
            ->get();
        }else {
            $products = array();
        }
        
        return view('seller.inventorycost.inventorycost')
                ->with('selluser', $selluser)
                ->with('suppliers',$suppliers)
                ->with('products', $products);
	}

    public function saveInventorycost(Request $request)
    {
    	// save inventory cost products
        $data = array();
        $index = 0;
        if(count($request->all()) > 0) {
        	if(count($request['product_id']) >0) {
        		foreach($request->product_id as $key=>$product) {
        			if((isset($request->product_qty[$key]) && !empty($request->product_qty[$key]) && $request->product_qty[$key] >0)
        			&& (isset($request->product_cost[$key]) && !empty($request->product_cost[$key]) && $request->product_cost[$key] >0)) {        				
        				// $data[$index]['inventorycost_id'] = $inventorycostObj->id;
        				$data[$index]['product_id'] = $product;
        				$data[$index]['quantity'] = $request->product_qty[$key];
        				$data[$index]['cost'] = ($request->product_cost[$key]*100);
        				$index++;
        			}
        		}
        	}
        }

        //save record to database
        if(count($data)>0){
            //save inventory cost
            $selected_supplier = explode("_", $request->supplier);
            $inventorycostObj = New Inventorycost();
            $inventorycostObj->esupplier_id = $selected_supplier[1];
            $inventorycostObj->is_esupplier = ($selected_supplier[0] == "sup") ? '1' : '0';
            $inventorycostObj->doc_date = $request->docdate;
            $inventorycostObj->doc_no = $request->docno;
            if(!$inventorycostObj->save()){
                return response()->json(['status'=>'error', 'long_message'=> 'Some error has occured while saving Inventory cost.']);
                exit();
            }

            //save inevntory cost products
            foreach($data as $key=>$val){
                $data[$key]['inventorycost_id'] = $inventorycostObj->id;
            }
        	if(!$inventoryproducts = Inventorycostproducts::insert($data)) {
                return response()->json(['status'=>'error', 'long_message'=> 'Some error has occured while saving Inventory cost for Products.']);
            }else {
        		return response()->json(['status'=>'success', 'long_message'=> 'Inventory cost saved successfully!']);	
            }
        }else {
            return response()->json(['status'=>'error', 'long_message'=> 'Nothing to save.']);	
        }
    }

	public function inventorycostRegisterdSupplier($id=null) {

		if ($id != null) {
			$user_id= $id;
        } else {
			$user_id= Auth::user()->id;	
        }
        $selluser = User::find($user_id);
        return view('seller.registered_supplier')->with('selluser', $selluser)	;
	}
	public function inventorycostAddProduct($id=null) {

		if ($id != null) {
			$user_id= $id;
        } else {
			$user_id= Auth::user()->id;	
        }
        $selluser = User::find($user_id);

        //get product detail
        $products = DB::table('product')
        ->select('id', 'name')
        ->orderBy("product.name")
        ->get();

        return view('seller.inventorycost.add_product')
        ->with('selluser', $selluser)
        ->with('products', $products);
	}
	public function inventorycostNewSupplier($id=null) {

		if ($id != null) {
			$user_id= $id;
        } else {
			$user_id= Auth::user()->id;	
        }
        $selluser = User::find($user_id);
        return view('seller.new_supplier')->with('selluser', $selluser)	;
	}
	
	public function inventorycostAverage($id=null) {

		if ($id != null) {
			$user_id= $id;
        } else {
			$user_id= Auth::user()->id;	
        }
        $selluser = User::find($user_id);
        $members=DB::table('member')->
            leftJoin('users','users.id','=','member.user_id')->
            join('company','member.company_id','=','company.id')->
            where('company.owner_user_id',$user_id)->
            where('member.type','member')->
            select(DB::raw("
                member.*,
                users.first_name as users_first_name,
                users.last_name as users_last_name,
                users.id as user_id
            "))
            ->orderBy('created_at','DESC')
            ->get();
        foreach ($members as $m) {
            $conn=SMMout::where('user_id',$m->user_id)->
            pluck('connections');
            $m->connections=$conn;
        }
     //   ->leftJoin('role_users','users.id','=','role_users.user_id')
       // ->leftJoin('roles','roles.id','=','role_users.role_id')
      //  ->join('logistic','logistic.company_id','=','company.id')


        $memberroles = DB::table('roles')->where('memberlist',true)->get();
        
        $customers=DB::table('member')
        ->leftJoin('users','users.id','=','member.user_id')
     //   ->leftJoin('role_users','users.id','=','role_users.user_id')
       // ->leftJoin('roles','roles.id','=','role_users.role_id')
        ->join('company','member.company_id','=','company.id')
        ->leftJoin('companymembersegment','companymembersegment.id','=','member.companymembersegment_id')
      //  ->join('logistic','logistic.company_id','=','company.id')
        ->where('company.owner_user_id',$user_id)
        ->where('member.type','customer')
        ->select(DB::raw("
            member.*,
            companymembersegment.description as segment,
            users.first_name as users_first_name,
            users.last_name as users_last_name
          "))
        ->orderBy('created_at','DESC')
        ->get();
        
        foreach($customers as $customer){
            $campaigns_members = DB::table('companycampaignmember')->where('member_id',$customer->id)->count();
            $customer->countcamp = $campaigns_members;
            
            $member_segments = DB::table('membersegment')->join('companymembersegment','companymembersegment.id','=','membersegment.segment_id')
            ->where('member_id',$customer->id)->get();
            $segments = "";
            foreach($member_segments as $member_segment){
                $segments .= $member_segment->description;
            }
            $customer->segments = $segments;
        }
        
        $customerroles = DB::table('roles')->where('customerlist',true)->get();
        $campaigns=DB::table('companycampaign')->where('owner_id',$selluser->id)->orderBy('created_at')->get();
        $campaignexists = false;
        $campaign_tosend = null;
        foreach($campaigns as $campaign){
            $campaigns_members = DB::table('companycampaignmember')->where('companycampaign_id',$campaign->id)->count();
            $campaign->customers = $campaigns_members;
            if($campaigns_members == 0){
                $campaignexists = true; 
                $campaign_tosend = DB::table('companycampaign')->where('id',$campaign->id)->first();
            }
        }
        $channels=Channel::get();
        foreach ($channels as $chan) {
            $uchan=UserChannel::where('user_id',$user_id)->
            where('status','active')->
            where('channel_id',$chan->id)
            ->first();
            if (empty($uchan)) {
                $chan->checked=false;
            }else{
                $chan->checked=true;
            }
        }
        
        $merchant_id = DB::table('merchant')->where('user_id',$user_id)->first();
        $stations=  Station::join('autolink', 'autolink.initiator', '=', 'station.user_id')->
                leftJoin('address','station.address_id','=','address.id')->
                leftJoin('city','city.id','=','address.city_id')->
                leftJoin('state','city.state_code','=','state.code')->
                leftJoin('country','country.code','=','state.country_code')->
                leftJoin('sorder','sorder.station_id','=','station.id')->
                leftJoin('porder','sorder.porder_id','=','porder.id')->
                leftJoin('orderproduct','orderproduct.porder_id','=','porder.id')->
                leftJoin('area','area.id','=','address.area_id')
                ->selectRaw('station.id, station.company_name as station_name, station.user_id, address.line1, address.line2, station.address_id, city.name as cityname, state.name as statename, country.name as countryname, area.name as areaname, autolink.responder as merchantid, SUM( IF(porder.created_at >= \'1970-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, SUM(IF(porder.created_at >= \'' . date('Y') . '-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= \'' . date('Y-m') . '-01\' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD
                    ')
                ->where('autolink.responder', '=', $merchant_id->id)->where('autolink.status', '=', 'linked')->where('autolink.visibility', '=', 1)->groupBy('station.id')->get();

                    //$openstation = DB::table('station')->where('id',$stations)->get();    
                //dd($stations);
                    $currency = Currency::where('active', 1)->first();

        $station_id = DB::table('station')->where('user_id',$user_id)->first();
        if(is_null($station_id )){
            $suppliers = [];
            $station_id = null;
        } else {
            $station_id = DB::table('station')->where('user_id',$user_id)->first()->id;
            $count = 0;
            $suppliers = array();
            $suppliers = DB::select(DB::raw("select auto.responder as merchantid, address.line1, address.line2, auto.linked_since as linked_since, mer.company_name as name, mer.user_id as supplier_user_id, SUM(IF(porder.created_at >= '1970-01-01' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, SUM(IF(porder.created_at >= '" . date('Y') . "-01-01' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= '" . date('Y-m') . "-01' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD, city.name as cityname, state.name as statename, country.name as countryname, area.name as areaname
                    from autolink auto inner join merchant mer on auto.responder = mer.id 
                    left join merchantproduct on merchantproduct.merchant_id = mer.id
                    left join orderproduct ON merchantproduct.product_id = orderproduct.product_id
                    left join porder ON orderproduct.porder_id = porder.id
                    left join sorder ON sorder.porder_id = porder.id
                    left join address ON mer.address_id = address.id
                    left join city ON address.city_id = city.id
                    left join state ON city.state_code = state.code
                    left join country ON state.country_code = country.code
                    left join area ON address.area_id = area.id
                    WHERE auto.initiator = $user_id
                    AND auto.visibility = 1
                    group by merchantid 
                    order by auto.created_at DESC"));       
        }
        
        /*Locations*/
        $locations=DB::table("fairlocation")
        ->where("user_id",$user_id)
        ->whereNull("deleted_at")
        ->orderBy("fairlocation.location")
        ->get();

        return view('seller.inventorycost.average')
            ->with('selluser',$selluser)
            ->with('merchant_id',$merchant_id)
            ->with('station_id',$station_id)
            ->with('stations',$stations)
            ->with('memberroles',$memberroles)
            ->with('campaignexists',$campaignexists)
            ->with('campaign_tosend',$campaign_tosend)
            ->with('customerroles',$customerroles)
            ->with('members', $members)     
            ->with('currency',$currency)
            ->with('channels',$channels)
            ->with('suppliers',$suppliers)
            ->with('customers', $customers)
            ->with('locations',$locations)
            ;
        // return view('seller.average')->with('selluser', $selluser)	;
	}

}
?>
