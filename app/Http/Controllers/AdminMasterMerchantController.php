<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Auth;
use Input;
use Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MasterMerchant;
use App\Classes;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Globals;
use Yajra\Datatables\Facades\Datatables;

class AdminMasterMerchantController extends Controller
{
	public  $cStatus=["completed","reviewed","commented"];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function wishlist_product($product_id){
		$product_likes = DB::table('wishlist')
							->join('users','wishlist.user_id','=','users.id')
							->leftJoin('buyer','buyer.user_id','=','users.id')
							->where('wishlist.product_id',$product_id)
							->select(DB::raw("LPAD(buyer.id,16,'0') as nbuyer_id, users.id as user_id, 
							CONCAT(users.first_name, ' ', users.last_name) as name, wishlist.quantity as quantity, 
							DATE_FORMAT(wishlist.updated_at,'%d%b%y %h:%m') as wishdate"))
							->get();	
		
		return json_encode($product_likes);
	}	 
	 
	public function wishlist(){
		$product_likes = DB::table('wishlist')->join('product','product.id','=','wishlist.product_id')->select(DB::raw('product.*,SUM(wishlist.quantity) as wish'))->groupBy('product.id')->get();	
		return view('master.wishlist')
				->with('product_likes',$product_likes);
	}	 
	 
    public function campaign()
    {
		$currency = '';
		if(!is_null(Currency::where('active',true)->first())){
            $currency = Currency::where('active',true)->first()->code;
        }

        $campaigns = DB::table('companycampaign')->select('companycampaign.id as id', 'companycampaign.name as name'
		,'company.company_name as company_name', 'companycampaign.status')
		->join('company', 'companycampaign.owner_id', '=', 'company.owner_user_id')
        ->orderBy('companycampaign.created_at','desc')
		->get();

		foreach($campaigns as $campaign){
			$logcounter = DB::table('logcompanycampaign')->where('companycampaign_id',$campaign->id)->count();
			$campaign->logcount = $logcounter;
		}
		
        return view('master.merchant_campaign',['campaigns'=>$campaigns, 'currency' => $currency, 'error_code'=> '5']);
    }	
	
    public function campaign_approval($id) {
        $currency = '';
        if (!is_null(Currency::where('active', true)->first())) {
            $currency = Currency::where('active', true)->first()->code;
        }

        $campaigns = DB::table('companycampaign')->select('companycampaign.id as id', 'companycampaign.name as name'
		,'company.company_name as company_name', 'companycampaign.status')
		->join('company', 'companycampaign.owner_id', '=', 'company.owner_user_id')
		->where('companycampaign.id',$id)
        ->orderBy('companycampaign.created_at','desc')
		->get();
        // return $merchantsc;
        return view('master.campaignApproval',
                    ['campaigns' => $campaigns, 'currency' => $currency]);
    }	
	
    public function index()
    {
        // $mer = array();
        // $merchants=MasterMerchant::paginate(10);
        
        // return $merchants;
		$total_active = DB::select(DB::raw("select count(DISTINCT m.id) as counting
from merchantproduct mp, product p, merchant m 
where mp.merchant_id=m.id and mp.product_id=p.id 
and m.status = 'active'
and p.status='active' and lcase(p.name) not like '%test%' 
and lcase(m.company_name) not like '%test%' and m.id != 184 order by m.company_name"));
        return view('master.merchant_pagination')->with('total_active',$total_active[0]);
    }
	
	public function paginate_merchant($start=0)
    {
		$end=$start+30;
		$ret=array();
        if (!Auth::check() or !Auth::user()->hasRole('adm')) {
            return $ret;
        }
        try {
            $ret = DB::table('merchant')->leftJoin('nsellerid','merchant.user_id','=','nsellerid.user_id')
			->leftJoin('merchantoshop','merchant.id','=','merchantoshop.merchant_id')
			->leftJoin('oshop','oshop.id','=','merchantoshop.oshop_id')
			->leftJoin('autolink', function($join) {
						 $join->on('merchant.id', '=', 'autolink.responder')
						 ->where('autolink.status','=','linked');
					 })
			->leftJoin('station','station.user_id','=','autolink.initiator')
			->leftJoin('merchantproduct','merchant.id','=','merchantproduct.merchant_id')
			->leftJoin('product as p2','p2.id','=','merchantproduct.product_id')
			->leftJoin('orderproduct','p2.id','=','orderproduct.product_id')
			->leftJoin('porder', function($join) {
							$join->on('porder.id','=','orderproduct.porder_id')
							->whereIn('porder.status',$this->cStatus);
						})
			->leftJoin('product', function($join) {
						 $join->on('product.id', '=', 'merchantproduct.product_id')
						->whereNull('product.deleted_at')->where('product.segment','=','b2c');
					 })
			->select(DB::raw("merchant.*,
				IFNULL(nsellerid.nseller_id,LPAD(merchant.id,16,'E')) as
					merchant_id,
				SUM(orderproduct.quantity * orderproduct.order_price) as
					total_sales,
				COUNT(DISTINCT oshop.id) as oshops,
				COUNT(DISTINCT product.id) as products,
				COUNT(DISTINCT station.id) as autolinks,p2.cashback"))
			->groupBy('merchant.id')
			->orderBY('merchant.created_at', 'desc')->get();
			foreach($ret as $r){
				$memberc = 0;
				$company = DB::table('company')->where('owner_user_id',$r->user_id)->first();
				if(!is_null($company)){
					$membersc = DB::table('member')->where('company_id',$company->id)->where('type','member')->count();
				}
				$r->staff = $memberc;
				
				$total_sales = DB::table('porder')->join('orderproduct','porder.id','=','orderproduct.porder_id')->join('merchantproduct','orderproduct.product_id','=','merchantproduct.product_id')->where('merchantproduct.merchant_id',$r->id)->select(DB::raw("SUM(orderproduct.quantity * orderproduct.order_price) as
					total_sales"))->first();
				$total = 0;
				if(!is_null($total_sales)){
					$total = $total_sales->total_sales;
				}
				$r->since_sales = $total;
				$tokens = DB::table('userstoken')->where('user_id',$r->user_id)->first();
				$token = 0;
				if(!is_null($tokens)){
					$token = $tokens->qty;
				}
				$r->tokens = $token;
				$mrole = DB::table('roles')->where('slug','mer')->first();
				$ism = 0;
				$role = 0;
				if(!is_null($mrole)){
					$ism = DB::table('role_users')->where('user_id',$r->user_id)->where('role_id',$mrole->id)->count();
				}
				if($ism == 0){
					$hrole = DB::table('roles')->where('slug','hcu')->first();
					$ish = 0;
					if(!is_null($hrole)){
						$ish = DB::table('role_users')->where('user_id',$r->user_id)->where('role_id',$hrole->id)->count();
					}
					if($ish == 0){
						$frole = DB::table('roles')->where('slug','fmu')->first();
						$isf = 0;
						if(!is_null($frole)){
							$isf = DB::table('role_users')->where('user_id',$r->user_id)->where('role_id',$frole->id)->count();
						}
						if($isf == 0){
							
						} else {
							$role = 3;
						}
					} else {
						$role = 2;
					}
				} else {
					$role = 1;
				}
				$r->role = $role;
			}
			$ret= collect($ret);
              
        } catch (\Exception $e) {
          //   dd($e);
        }
		//dd($ret);
        return Datatables::of($ret)->make(true);
	}
	
    public function approval($id)
    {
        // $mer = array();
        // $merchants=MasterMerchant::paginate(10);
        $merchants = MasterMerchant::where('id',$id)->orderBY('created_at', 'desc')->get();
        // return $merchants;
		$idmerchant = DB::table('merchant')->where('id',$id)->first(); 
        return view('master.merchant_approval',['merchants'=>$merchants, 'idmerchant'=>$idmerchant]);
    }	
	
	public function listProducts($mid)
     {
         if(!is_null(Currency::where('active',true)->first())){
             $currency = Currency::where('active',true)->first()->code;
         }
 		$product=Product::where('segment','b2c')->join('merchantproduct','product.parent_id','=','merchantproduct.product_id')->where('merchantproduct.merchant_id',$mid)->whereNull('product.deleted_at')->select('product.id' ,
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
				  'product.updated_at')->with('category')->with('brand')->with('subCategory')->with('productdealer')->with('dealers')->orderBy('created_at','desc')->get();
		$brands = DB::table('brand')->get();
		$categories = DB::table('category')->get();
		$subcategories =DB::select(DB::raw('SELECT
		id, subcat_level, description FROM (
			SELECT subcat_level_1.id, "1" as subcat_level, subcat_level_1.description FROM subcat_level_1
			UNION
			SELECT subcat_level_2.id, "2" as subcat_level, subcat_level_2.description FROM subcat_level_2
			UNION
			SELECT subcat_level_3.id, "3" as subcat_level, subcat_level_3.description FROM subcat_level_3
		) as TT
		'));		
 
		return view('admin/adminMasterProduct',['product'=>$product, 'currency'=>$currency, 'brands' => $brands, 'categories' => $categories, 'subcategories' => $subcategories]);
    }	

    public function oshops($id)
    {
		$oshops = DB::table('oshop')->select('oshop.*','city.name as cityname','area.name as areaname','state.name as statename','country.name as countryname')->join('merchantoshop','oshop.id','=','merchantoshop.oshop_id')->leftJoin('address','oshop.address_id','=','address.id')->leftJoin('city','address.city_id','=','city.id')->leftJoin('area','address.area_id','=','area.id')->leftJoin('state','state.code','=','city.state_code')->leftJoin('country','country.code','=','state.country_code')->where('merchantoshop.merchant_id',$id)->get();
		return view('master.oshops',['oshops'=>$oshops,'merchant_id'=>$id]);
	}
	
	public function snetwork($id)
    {
		$station = DB::table('station')->where('id',$id)->first();
		$merchants = array();
		if(!is_null($station)){
			$merchants = DB::table('merchant')->leftJoin('nsellerid','merchant.user_id','=','nsellerid.user_id')->leftJoin('address','merchant.address_id','=','address.id')->leftJoin('city','address.city_id','=','city.id')->leftJoin('area','address.area_id','=','area.id')->leftJoin('state','state.code','=','city.state_code')->leftJoin('country','country.code','=','state.country_code')->join('users','users.id','=','merchant.user_id')->join('autolink','autolink.responder','=','merchant.id')->where('autolink.initiator',$station->user_id)->where('autolink.status','linked')->select('merchant.*','nsellerid.nseller_id as nmerchant_id','city.name as cityname','area.name as areaname','state.name as statename','country.name as countryname')->distinct()->get();			
		}

		return view('master.snetwork',['merchants'=>$merchants]);
	}
	
    public function network($id)
    {
        $stations = DB::table('station')->leftJoin('nsellerid','station.user_id','=','nsellerid.user_id')->leftJoin('address','station.station_address_id','=','address.id')->leftJoin('city','address.city_id','=','city.id')->leftJoin('area','address.area_id','=','area.id')->leftJoin('state','state.code','=','city.state_code')->leftJoin('country','country.code','=','state.country_code')->join('users','users.id','=','station.user_id')->join('autolink','autolink.initiator','=','users.id')->where('autolink.responder',$id)->where('autolink.status','linked')->select('station.*','nsellerid.nseller_id as nstation_id','city.name as cityname','area.name as areaname','state.name as statename','country.name as countryname')->distinct()->get();
		//dd($stations);
		$globals=Globals::first();
		foreach($stations as $station){
			$stationso=DB::select(DB::raw("SELECT c.code as currency, COUNT(po.id) as poid, m.id as mid,m.user_id as user_id, m.company_name as company, m.station_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$globals->osmall_commission."),-1) as commission_sv, 
					SUM(IF(m.commission_type = 'std',IF(m.osmall_commission > 0, op.order_price * op.quantity * ((100 - m.osmall_commission)/100), op.order_price * op.quantity * ((100 - ".$globals->osmall_commission.")/100)),
					IF(pro.osmall_commission > 0,op.order_price * op.quantity * ((100 - pro.osmall_commission)/100),
					IF(m.osmall_commission > 0, op.order_price * op.quantity * ((100 - m.osmall_commission)/100), op.order_price * op.quantity * ((100 - 10)/100))))) 
					as payable, SUM(op.order_price * op.quantity) as net_payable, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM station m, payment p, porder po, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id AND m.id = ".$station->id."
					and op.product_id = pro.id GROUP BY m.id ORDER BY p.created_at DESC"));
					
				if(count($stationso)>0){
					$station->since_amount = $stationso[0]->net_payable;
					$station->since_no = $stationso[0]->poid;
				} else {
					$station->since_amount = 0;
					$station->since_no = 0;
				}	
			$stationso=DB::select(DB::raw("SELECT c.code as currency, COUNT(po.id) as poid, m.id as mid,m.user_id as user_id, m.company_name as company, m.station_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$globals->osmall_commission."),-1) as commission_sv, 
					SUM(IF(m.commission_type = 'std',IF(m.osmall_commission > 0, op.order_price * op.quantity * ((100 - m.osmall_commission)/100), op.order_price * op.quantity * ((100 - ".$globals->osmall_commission.")/100)),
					IF(pro.osmall_commission > 0,op.order_price * op.quantity * ((100 - pro.osmall_commission)/100),
					IF(m.osmall_commission > 0, op.order_price * op.quantity * ((100 - m.osmall_commission)/100), op.order_price * op.quantity * ((100 - 10)/100))))) 
					as payable, SUM(op.order_price * op.quantity) as net_payable, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM station m, payment p, porder po, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id AND m.id = ".$station->id."
					and op.product_id = pro.id AND po.id AND po.created_at >= '".date('Y')."-01-01' GROUP BY m.id ORDER BY p.created_at DESC"));
				if(count($stationso)>0){
					$station->ytd_amount = $stationso[0]->net_payable;
					$station->ytd_no = $stationso[0]->poid;
				} else {
					$station->ytd_amount = 0;
					$station->ytd_no = 0;
				}			
			$stationso=DB::select(DB::raw("SELECT c.code as currency, COUNT(po.id) as poid, m.id as mid,m.user_id as user_id, m.company_name as company, m.station_name as name, IF(m.commission_type = 'std',IF(m.osmall_commission > 0,m.osmall_commission,".$globals->osmall_commission."),-1) as commission_sv, 
					SUM(IF(m.commission_type = 'std',IF(m.osmall_commission > 0, op.order_price * op.quantity * ((100 - m.osmall_commission)/100), op.order_price * op.quantity * ((100 - ".$globals->osmall_commission.")/100)),
					IF(pro.osmall_commission > 0,op.order_price * op.quantity * ((100 - pro.osmall_commission)/100),
					IF(m.osmall_commission > 0, op.order_price * op.quantity * ((100 - m.osmall_commission)/100), op.order_price * op.quantity * ((100 - 10)/100))))) 
					as payable, SUM(op.order_price * op.quantity) as net_payable, 
					m.mc_sales_staff_id as mc_id, m.mc_sales_staff_commission as mc_commission, m.referral_sales_staff_id as referral_id, m.referral_sales_staff_commission as referral_commission,
					m.mcp1_sales_staff_id as mcp1_id, m.mcp1_sales_staff_commission as mcp1_commission, m.mcp2_sales_staff_id as mcp2_id, m.mcp2_sales_staff_commission as mcp2_commission,
					DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, UPPER(po.source) as source FROM station m, payment p, porder po, orderproduct op, product pro, stationsproduct mp, sproduct sp, currency c WHERE c.active = 1 and p.id = po.payment_id and m.id = mp.station_id and mp.sproduct_id = sp.id and pro.id = sp.product_id and op.porder_id = po.id AND m.id = ".$station->id."
					and op.product_id = pro.id AND po.id AND po.created_at >= '".date('Y')."-".date('m')."-01' GROUP BY m.id ORDER BY p.created_at DESC"));
				if(count($stationso)>0){
					$station->mtd_amount = $stationso[0]->net_payable;
					$station->mtd_no = $stationso[0]->poid;
				} else {
					$station->mtd_amount = 0;
					$station->mtd_no = 0;
				}					
		}
		

        return view('master.network',['stations'=>$stations]);
    }	

    public function getmngrs($id)
    {
        $merchant = DB::table('merchant')->select('mc_sales_staff_id', 'referral_sales_staff_id', 'mcp1_sales_staff_id', 'mcp2_sales_staff_id')
		->where('id',$id)
		->first();

		$arr['mcu'] = "";
		$arr['mcuname'] = "";
		$arr['mc'] = "";
		if($merchant->mc_sales_staff_id != 0 && $merchant->mc_sales_staff_id != ""){
			$mc = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name')
			->where('sales_staff.id',$merchant->mc_sales_staff_id)
			->join('users', 'users.id', '=', 'sales_staff.user_id')
			->first();
			$arr['mcu'] = $mc->user_id;
			$arr['mcuname'] = $mc->first_name . ' ' . $mc->last_name;
			$arr['mc'] = $mc->id;
		}

		$arr['mcrefu'] = "";
		$arr['mcrefname'] = "";
		$arr['mcref'] = "";
		if($merchant->referral_sales_staff_id != 0 && $merchant->referral_sales_staff_id != ""){
			$mcref = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name')
			->where('sales_staff.id',$merchant->referral_sales_staff_id)
			->join('users', 'users.id', '=', 'sales_staff.user_id')
			->first();
			$arr['mcrefu'] = $mcref->user_id;
			$arr['mcrefname'] = $mcref->first_name . ' ' . $mcref->last_name;
			$arr['mcref'] = $mcref->id;
		}

		$mcs = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name')
		->where('sales_staff.type','mct')
		->join('users', 'users.id', '=', 'sales_staff.user_id')
		->get();

		$arr['mcs'] = $mcs;

		$arr['mp1u'] = "";
		$arr['mp1name'] = "";
		$arr['mp1'] = "";
		if($merchant->mcp1_sales_staff_id != 0 && $merchant->mcp1_sales_staff_id != ""){
			$mp1 = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name')
			->where('sales_staff.id',$merchant->mcp1_sales_staff_id)
			->join('users', 'users.id', '=', 'sales_staff.user_id')
			->first();
			$arr['mp1u'] = $mp1->user_id;
			$arr['mp1name'] = $mp1->first_name . ' ' . $mp1->last_name;
			$arr['mp1'] = $mp1->id;
		}

		$arr['mp2u'] = "";
		$arr['mp2name'] = "";
		$arr['mp2'] = "";
		if($merchant->mcp2_sales_staff_id != 0 && $merchant->mcp2_sales_staff_id != ""){
			$mp2 = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name')
			->where('sales_staff.id',$merchant->mcp2_sales_staff_id)
			->join('users', 'users.id', '=', 'sales_staff.user_id')
			->first();
			$arr['mp2u'] = $mp2->user_id;
			$arr['mp2name'] = $mp2->first_name . ' ' . $mp2->last_name;
			$arr['mp2'] = $mp2->id;
		}

		$mps = DB::table('sales_staff')->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name as first_name', 'users.last_name as last_name')
		->where('sales_staff.type','mcp')
		->join('users', 'users.id', '=', 'sales_staff.user_id')
		->get();

		$arr['mps'] = $mps;

		return json_encode($arr);
    }

	public function setmngrs($id)
    {
		$ssid = Input::get('ssid');
		$column = Input::get('column');
		DB::table('merchant')->where('id',$id)->update([$column => $ssid]);
		echo 'OK';
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

    /**
     * Approve merchant.
     *
     * @return \Illuminate\Http\Response
     */
     public function approveMerchant() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
         return \App\Classes\AdminApproveHelper::approveUser($inputs);

      }
    }
	
     public function approveCompanycampaign() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
         return \App\Classes\AdminApproveHelper::approveUser($inputs);

      }
    }	
	
	public function approveMerchantSection() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) && !empty($inputs['section']) ){
         return \App\Classes\AdminApproveHelper::approveSection($inputs);

      }
    }

    //function for saving remarks of station
    public function saveMerchantRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
		$res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
			$res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
			echo $res;
		}
		//echo "Hola";
    }
	
    //function for saving remarks of station
    public function saveCompanycampaignRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
		$res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
			$res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
			echo $res;
		}
		//echo "Hola";
    }	
	
	public function saveMerchantSecRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
		$res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) && !empty($inputs['section'])){
			$res = \App\Classes\AdminApproveHelper::saveSecRemarks($inputs);
			echo $res;
		}
		//echo "Hola";
    }

    public function companycampaign_remarks($id) {

        $remarks = DB::select(DB::raw("select 
          remark.remark,
           nbuyerid.nbuyer_id as nuser_id,
           remark.user_id,
           DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status 
           from remark inner join companycampaignremark on companycampaignremark.remark_id = remark.id 
           join nbuyerid on nbuyerid.user_id=remark.user_id


           where companycampaignremark.companycampaign_id = " . $id . " order by remark.created_at desc"));


        return json_encode($remarks);
    }	
	
    public function merchant_remarks_approval($id){
		
		$sections = [];
		$aprsections = DB::table('aprsection')->where('type','merchant')->get();
		$count = 0;
		foreach($aprsections as $aprsection){
			$getstatus = DB::table('aprchecklist')->where('merchant_id',$id)
								->where('aprsection_id',$aprsection->id)->first();
			$statusc = "pending";
			$remark = "";
			$aprid = 0;
			if(!is_null($getstatus)){
				$statusc = $getstatus->status;
				$remarks = DB::table('aprchecklistremark')->join('remark','aprchecklistremark.remark_id','=','remark.id')
									->where('aprchecklist_id',$getstatus->id)
									->orderBy('aprchecklistremark.created_at','DESC')->select('remark.*')->orderBy('aprchecklistremark.created_at','DESC')->first();
				if(!is_null($getstatus)){
					$remark = $remarks->remark;
				}
				$aprid = $getstatus->id;
									
			} 
			
			$sections[$count]['description'] = $aprsection->description;
			$sections[$count]['comment'] = $remark;
			$sections[$count]['status'] = $statusc;
			$sections[$count]['aprid'] = $aprid;
			$count++;			
		}
		
		$remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status, nmerchantid.nmerchant_id, nbuyerid.nbuyer_id from remark inner join merchantremark on merchantremark.remark_id = remark.id left join nmerchantid on merchantremark.merchant_id = nmerchantid.merchant_id left join nbuyerid on remark.user_id = nbuyerid.user_id where merchantremark.merchant_id = " . $id . " order by remark.created_at desc"));

		$merchant = DB::table('merchant')->where('id',$id)->first();
		return view('master/merchant_remarks',['merchant'=>$merchant,'merchant_id'=>$id ,'sections'=>$sections, 'remarks'=>$remarks]);
	}
	
    public function merchant_remarks($id){
		$remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status, nmerchantid.nmerchant_id, nbuyerid.nbuyer_id from remark inner join merchantremark on merchantremark.remark_id = remark.id left join nmerchantid on merchantremark.merchant_id = nmerchantid.merchant_id left join nbuyerid on remark.user_id = nbuyerid.user_id where merchantremark.merchant_id = " . $id . " order by remark.created_at desc"));

		return json_encode($remarks);
	}
	
	public function apr_remarks($id){
		$remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status, nbuyerid.nbuyer_id from remark inner join aprchecklistremark on aprchecklistremark.remark_id = remark.id left join nbuyerid on remark.user_id = nbuyerid.user_id where aprchecklistremark.aprchecklist_id = " . $id . " order by remark.created_at desc"));

		return json_encode($remarks);
	}
	
	public function merchant_approval($id){
		$sections = [];
		$aprsections = DB::table('aprsection')->where('type','merchant')->get();
		$count = 0;
		foreach($aprsections as $aprsection){
			$getstatus = DB::table('aprchecklist')->where('merchant_id',$id)
								->where('aprsection_id',$aprsection->id)->first();
			$statusc = "pending";
			$remark = "";
			if(!is_null($getstatus)){
				$statusc = $getstatus->status;
				$remarks = DB::table('aprchecklistremark')->join('remark','aprchecklistremark.remark_id','=','remark.id')
									->where('aprchecklist_id',$getstatus->id)
									->orderBy('aprchecklistremark.created_at','DESC')->select('remark.*')->first();
				if(!is_null($getstatus)){
					$remark = $remarks->remark;
				}
									
			} 
			
			$sections[$count]['description'] = $aprsection->description;
			$sections[$count]['comment'] = $remark;
			$sections[$count]['status'] = ucfirst($statusc);
			$count++;			
		}
		return json_encode($sections);
	}

    public function employee_remarks($id){
		$remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status from remark inner join employeeremark on employeeremark.remark_id = remark.id where employeeremark.employee_id = " . $id . " order by remark.created_at desc"));

		return json_encode($remarks);
	}

        public function getmerchantproduct($id){
        $station_product =  DB::table('product')
            ->select('product.id as id', 'product.name as name', 'product.stock as stock', 'product.available as available', 'product.parent_id as parent_id')
            ->join('merchantproduct', 'product.id', '=', 'merchantproduct.product_id')
            ->where('merchantproduct.merchant_id', '=', $id)
            ->get();
       // dd($sales_stuffs);
        return json_encode($station_product);
    }
}
