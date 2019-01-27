<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\OposSpaCustomer;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Globals;
use App\Models\OposSparoom;
use App\Models\OposReceiptproduct;
use App\Models\OposReceipt;
use App\Models\OposDiscount;
use App\Models\OposMerchantterminal;
use App\Models\OposTerminal;
use App\Models\OposBundle;
use App\Models\OposBundleProduct;
use Auth;
use DB;
use Log;
use Carbon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\EmailController;
use App\Models\User;
use App\Models\Address;
use App\Models\OposSave;
use App\Models\RoleUser;
use App\Models\Buyer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use DateTime;
class OpossumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        /*DB::enableQueryLog();*/
    }

   
    public function index($terminal_id=null,$uid=null)
    {
        if (!Auth::check()) {
            return view("common.generic")
            ->with("message","Please login to access this page.")
            ->with("message_type","error");
        }
	     $user_id = Auth::user()->id;
	     $allow_access=false;
        if (Auth::user()->hasRole("adm") && !empty($uid)) {
        	# code...

        	$user_id=$uid;
        	$allow_access=true;
        }
		
        /*check if buyer has authorized*/
        if (Auth::user()->hasRole('byr')) {
        	# code...

        	$is_auth=DB::table('opos_terminalusers')->where('user_id',$user_id)
        	->where('terminal_id',$terminal_id)->first();

        	if (empty($is_auth)) {
        		# code...
        		$message="You do not have permission to access this terminal. Please contact admininistrator";
        		$message_type='error';
        		return view("common.generic",compact('message','message_type'))

				;
        	}

        }
        $bdata = DB::table('opos_terminal')->
				where("id",$terminal_id)->
				// select('bfunction','servicecharge_id','otherpointmode')->
				orderby('id','desc')->
				first();
		if (empty($bdata)) {
			# code...
			return view("common.generic")
			->with('message','Terminal does not exists')
			->with('message_type','error')
			;
		}
		$logged_user_id=$bdata->logged_user_id;
		if (empty($logged_user_id)) {
			$allow_access=true;
			$this->login($user_id,$terminal_id);
		}else{
			if (Auth::user()->hasRole('byr') and $user_id!=$logged_user_id) {
				$message_type="error";
				$logged_user=User::find($logged_user_id);
				$message=$logged_user->first_name." ".$logged_user->last_name."(".str_pad($logged_user_id,10,'0',STR_PAD_LEFT).") is using terminal 001. Please contact admininistrator .
				";
				return view("common.generic",compact('message','message_type'))

				;
			}
		}
		
       
		$staff_user_id = null;
		/*Check if user is a buyer*/
		$user_byr_role=DB::table("role_users")
		->where("role_id",2)
		->where("user_id",$user_id)
		->first();

		if (!empty($user_byr_role))  {
			$staff_user_id = $user_id;
 			$user_id = DB::table('role_users')->
				join('roles','roles.id','=','role_users.role_id')->
				join('company','company.id','=','role_users.company_id')->
				where('user_id',$user_id)->
				whereIn('roles.slug',['opu','opm'])->
				pluck('company.owner_user_id');
		}

		Log::info('Merchant user_id='.$user_id);
        $merchant_id = $user_id;
        /**/
        $location_id=DB::table("opos_locationterminal")
        ->where("terminal_id",$terminal_id)

        ->pluck("location_id");
        
	     
	     $is_eod=true;
	    
		/* Getting the company from a regular merchant user */
        $company=Company::where('company.owner_user_id',$user_id)->
			join("merchant","merchant.user_id","=","company.owner_user_id")->
			join("users","users.id","=","merchant.user_id")->
			leftJoin('address','merchant.address_id','=','address.id')->
			leftJoin('city','address.city_id','=','city.id')->
			leftJoin('state','city.state_code','=','state.code')->
			select('address.line1','address.line2','address.line3',
				'city.name','state.name','address.postcode',
				'company.dispname','company.id','merchant.gst',
				'users.first_name as first_name',
				'users.last_name as last_name',
				'users.name','users.id as user_id')->
			first();
		Log::debug('***** OPOSsum Controller: company *****');
		Log::debug($company);
                
        $company_id = !empty($company->id)?$company->id:"0";
		//dump('company_id='.$company_id);

		/* Overwrite Staff ID if real staff actually logs in from BD */
		if (!empty($staff_user_id)) {
			$company->user_id = $staff_user_id;

			/* Get the name of the staff */
			$u = DB::table('users')->
				where('id',$staff_user_id)->
				first();

			if (empty($u->name)) {
				Log::debug('first_name='.$u->first_name);
				Log::debug('last_name ='.$u->last_name);
				
				if (empty($u->first_name) and empty($u->last_name)) {
					$company->name = $u->email;
				} else {
					$company->name = $u->first_name." ".$u->last_name;
				}
			} else {
				$company->name = $u->name;
			}
                        
		} else {
			/*
			// Merchant user accoun
			Log::debug('name      ='.
				!empty($company->name)?$company->name:"");
			Log::debug('first_name='.
				!empty($company->first_name)?$company->first_name:"");
			Log::debug('last_name ='.
				!empty($company->last_name)?$company->last_name:"");
			*/

			if(!empty($company->name)){
				if (empty($company->name)) {
					$company->name =
						$company->first_name." ".$company->last_name;
				}
			}
		}
        
        
        $currentCurrency = Currency::where('active',1)->pluck('code');
        $gst_rate = Globals::pluck('gst_rate');
        $cache_reload_time = Globals::pluck('opossum_product_cache_expiry');
      /*  $sparooms = OposSparoom::orderBy('room_no','ASC')->get();*/
     
       //dd(count($lockerkeys));
        /*$ftype=$data=[
                "checkin_tstamp"=>$checkin_tstamp,
                "receipt_id"=>$receipt_id,
                "ref_no"=>$r->ref_no,
                "ftype_id"=>$r->id,
                "ftype"=>$ftype,
                "txn_id"=>$txn_id
            ];

*/      
            /*DataQUery should be seperate out*/
       
        /*dd($data);*/
        
        $staff_members = DB::select(
			"select
				u.id,
				 CONCAT(u.first_name,' ',u.last_name) as staff_name,
				 n.nbuyer_id as staff_id
			from
				users u,
				roles r,
				member m,
				nbuyerid n,
				role_users ru 
			where
				m.user_id=u.id AND
				ru.user_id=u.id and
				ru.role_id=r.id and
				m.user_id=n.user_id and
				(r.slug='spm' or
				r.slug='spu' or r.slug='mas') and				
				m.type='member' and
				m.company_id=$company_id
			group by
				u.id;
        ");

		$member=\App\Models\OposTerminalUsers::leftJoin(
		 	"users","users.id","=","opos_terminalusers.user_id")->
			where("users.id","=",$user_id)->
			first();
		$bfunction="";
		$pointmode="";
		$viewfile="opposum.trunk.opossum";
	
		try {
			
			$bfunction = $bdata->bfunction;
			$pointmode=$bdata->otherpointmode;

		} catch (\Exception $e) {
			Log::error("terminal_id=".$terminal_id);
			Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".
				$e->getMessage());
		}

		$table=$table_validation=$lockerkeys=$sparooms=$hotelroomquery=
		$sparoom_validation=$lockerkey_validation=[];
        
        switch ($bfunction) {
        	case 'table':
        		$table = $this->table($terminal_id);
        		//dd($table);
        		$table_validation=DB::table("opos_ftype")->
					where("ftype","table")->
					whereNull("deleted_at")->
					lists('fnumber'); 
        		break;

        	case 'spa':
        		$lockerkeyquery=$this->lockerkeyquery($location_id);
        		$lockerkeys=DB::select(DB::raw($lockerkeyquery));
        		$sparoomquery=$this->sparoomquery($location_id);
        		$sparooms=DB::select(DB::raw($sparoomquery));
        		$sparoom_validation  = DB::table("opos_ftype")->
					where("ftype","sparoom")->
					whereNull("deleted_at")->
					lists('fnumber');       
       			$lockerkey_validation=DB::table("opos_ftype")->
					where("ftype","lockerkey")->
					whereNull("deleted_at")->
					lists('fnumber'); 
        		break;

        	case 'hotel':
        		$hotelroomquery=$this->hotelroomquery();
        		$hotelroom=DB::select(DB::raw($hotelroomquery));
        		break;

        	default:break;
        }
        $service_per=DB::table("merchant")->
			where("user_id",$user_id)->first();
		//$viewfile="opposum.trunk.platypos_opossum";
		$viewfile="opposum.trunk.opossum";

		/*Log::debug('******** $bdata ********');
		Log::debug(json_encode($bdata));*/

		$servicecharge_id=$bdata->servicecharge_id;
		$pointmode=$bdata->mode;
		$service_tax=$bdata->servicetax;
		if ($pointmode=="inclusive") {
			# code...
			$service_per=0;
			$gst_rate=0;
		
		}
		//dd($is_eod);
		$logterminal_id=DB::table('opos_logterminal')
		->where('terminal_id',$terminal_id)
		->whereRaw("DATE(eod)=CURDATE()")
		->whereNull('deleted_at')
		->orderBy('created_at','DESC')
		->whereNotNull('eod')
		->pluck('id');
        return view($viewfile,
			compact('barcodearr','currentCurrency','gst_rate',
				'cache_reload_time','company','sparooms','staff_members',
				'sparoom_validation','lockerkeys','table',
				'lockerkey_validation','bfunction',
				'table_validation', 'merchant_id',"member",
				"hotelroomquery",'service_per','user_id','terminal_id',
				'servicecharge_id','pointmode','service_tax','is_eod','logterminal_id'));
    }
 
    
	public function getMemberLocationData(Request $request,$uid=NULL){
		$user_id = Auth::user()->id;
		if (Auth::user()->hasRole("adm") and !empty($uid)) {
			# code...
			$user_id=$uid;
		}
		$terminal_id=sprintf("%05d",$request->terminal_id);
		$fairlocation=DB::table("fairlocation")
		->join("opos_locationterminal","opos_locationterminal.location_id","=","fairlocation.id")
		->select("fairlocation.location","fairlocation.id","fairlocation.user_id")
		->where('opos_locationterminal.terminal_id',$terminal_id)
		->first();

		$staff=DB::table("users")->where("id",$user_id)->select("first_name","last_name")->first();
		//dd($staff);
		$company=DB::table('company')->where('owner_user_id',$fairlocation->user_id)->whereNull('deleted_at')->first();
		$first_name=$staff->first_name;
		$last_name=$staff->last_name;
		$staffname=$first_name." ".$last_name;
		$staffid=sprintf("%010d",$user_id);
		$branch_name=$fairlocation->location;
		$location_id=$fairlocation->id;
		$company_name=$company->dispname;
		return response()->json(compact('terminal_id','branch_name','first_name','last_name','staffname','location_id','company_name','staffid'));
	}

	public function location($terminal_id)
	{
		return DB::table("opos_locationterminal")
		->where("terminal_id",$terminal_id)
		->whereNull("deleted_at")
		->orderBy("created_at","DESC")
		->pluck("location_id")
		;
	}

    public function operation_hours_variables(Request $request,$uid=NULL){
		Log::debug('***** operation_hours_variables *****');

        $array=[];
        if (!Auth::check()) {
        	return "Authentication Failure";
        }
        $user_id     = Auth::user()->id;

    	if (Auth::user()->hasRole("adm") and !empty($uid)) {
    		# code...
    		$user_id=$uid;
    	}
        
        $terminal_id=$request->input("terminal_id");
     
        
       	/*Check if EOD*/
       	$status=$this->is_eod($terminal_id);
       	return response()->json(compact('status'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notEmpty($dat){
        return !empty($dat)?$dat:0;
	}

	public function convertToEpoch($date,$start_time="",$end_time="",$start=true){
		$converted=explode(":",$date);
		//0 for hours, 1 for minutes , 2 for seconds
		$time= $converted[0].$converted[1].$converted[2];
		$day=date("j");
		$months=date("n");    
		$year=date("Y");
		if(!empty($start_time) && !empty($end_time)){
			if(strtotime($start_time)>strtotime($end_time)){
				if($start){
					$day=date("j",strtotime("-1 day"));
				}
			}
		}
		return mktime(
			$this->notEmpty($converted[0]),
			$this->notEmpty($converted[1]),
			$this->notEmpty($converted[2]),
			$months,$day,$year);
	}

    public function skulist($terminal_id,$uid=null)
    {
    	$user_id     = Auth::user()->id;
    	if (Auth::user()->hasRole("adm") and !empty($uid)) {
    		# code...
    		$user_id=$uid;
    	}
        
		$location_id=DB::table("opos_locationterminal")
		->where("terminal_id",$terminal_id)
		->pluck("location_id");
		$merchant_user_id=DB::table("fairlocation")
		->where("id",$location_id)
		->pluck("user_id");
        $merchant = Merchant::where('user_id','=',$merchant_user_id)->first();
        $hidden_products=$this->get_hidden_products($terminal_id);
        return $products =   $merchant->products()
			->leftjoin('nproductid','nproductid.product_id','=','product.id')
			// ->leftJoin("opos_productpreference as opp","opp.product_id","=","product.id")
			 ->leftjoin('opos_productpreference',function($join) use ($terminal_id)
            {
            	$join->on('opos_productpreference.product_id','=','product.id');
            	$join->where('opos_productpreference.terminal_id','=',$terminal_id);
            	$join->where('opos_productpreference.price_keyin','=',1);

            })
            ->leftJoin('productbc', function ($leftJoin) {
				$leftJoin->on('productbc.product_id', '=', 'product.id')
				->where('productbc.id', '=',
					DB::raw("(select max(`id`) from productbc)"));
			})
			->leftjoin('bc_management','bc_management.id','=',
				'productbc.bc_management_id')
            ->join('merchantproduct as mp','mp.product_id','=','product.id')
            ->whereNull('mp.deleted_at')
            ->where('product.status','!=','transferred')
            ->whereNotIn('product.id',$hidden_products)
            ->whereNull('product.deleted_at')
            ->orderBy('product.id','DESC')
			->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.sku as sku',
                'bc_management.barcode',
                'product.name as name',
                 DB::raw('IF(opos_productpreference.price_keyin = 1 and opos_productpreference.local_price is not null,opos_productpreference.local_price,product.retail_price) as price'),
                // 'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
                'opos_productpreference.price_keyin'
            ]);

		return Response()->json($products);
    }





    public function skulist_sincebkp()
    {
        $user_id     = Auth::user()->id;     
       

   //     if(isset($_GET['country']) != '')
   //      {
   //          $country =  $_GET['country'];
   //      }
   //      if(isset($_GET['state']) != '')
   //      {
   //          $state = $_GET['state'];
   //      }
   //      if(isset($_GET['city']) != '')
   //      {
   //          $city = $_GET['city'];
   //      }
        
   //      if(isset($_GET['marea']) != '')
   //      {
   //          $marea = $_GET['marea'];
   //      }
   //      if(isset($_GET['product']) != '')
   //      {
   //          $product = $_GET['product'];
   //      }
   //      if(isset($_GET['brand']) != '')
   //      {
   //          $brand = $_GET['brand'];
   //      }
   //      if(isset($_GET['category']) != '')
   //      {
   //          $category = $_GET['category'];
   //      }
   //      if(isset($_GET['subcategory']) != '')
   //      {
   //          $subcategory = $_GET['subcategory'];
   //      }
   //      if(isset($_GET['consumer']) != '')
   //      {
   //          $consumer = $_GET['consumer'];
   //      }
   //      if(isset($_GET['channel']) != '')
   //      {
   //          $channel =  $_GET['channel'];
   //      }
        
   //     if($channel != "all2loc" OR  $channel != "overall2sales" OR $channel != "b2c" OR $channel != "b2b" OR $channel != "hyper" OR $channel == "smm" OR $channel != "openwish")
   //      {   
   //          $productCatq ='';
   //          if($category != ''){
   //          	$productCatq = $category ;
   //          }
   //          $productSubCatq ='';
   //          if($subcategory != '')
   //          {
   //              $productSubCatq = $subcategory ;
   //          }
   //          $productBrandq = '';
   //          if($brand != '')
   //          {
   //              $productBrandq = $brand ;
   //          }
   //          $productq = '';
   //          if($product != '')
   //          {
   //              $productq = $product ;
   //          }
   //          $productSegmentq = '';
   //          if($channel != '')
   //          {

   //              $productSegmentq = $channel;
   //          }
   //          $cityq = '';
			// if($city != '')
			// {

			// 	$cityq = $city ;
			// }
			// $stateq = '';
			// if($state != '')
			// {

			// 	$stateq = $state ;
			// }
			// $countryq = '';
			// if($country != '')
			// {

			// 	$countryq = $country ;
			// }
     


         $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
        $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();


            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }
        
         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $products =   $merchant->products()

            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
                //AND mp.merchant_id = ".$merchant['id'] . $productCatq . $productSubCatq . $productBrandq . $productq . $productSegmentq . "
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')



           /*  ->leftjoin('opos_receiptproduct','opos_receiptproduct.product_id','=', 'product.id')
             ->leftjoin('opos_receipt','opos_receipt.receipt_no','=','opos_receiptproduct.receipt_id')
             ->leftjoin('fairlocation','fairlocation.address_id','=','opos_receipt.terminal_id')
             ->leftjoin('fairlocation','fairlocation.address_id','=','address.city_id')
             ->leftjoin('address','address.city_id','=','address.state_code')
             ->leftjoin('address','address.city_id','=','address.country_code')
             ->leftjoin('state_code','state_code.country_code','=','country.code')
             ->leftjoin('state_code','state_code.state_code','=','sate.code')*/
             //->leftjoin('salesmemo',' salesmemo.id','=','salesmemoproduct.salesmemo_id')
                /*JOIN users on users.id= porder.user_id
                
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code
                JOIN country on city.country_code = country.code*/


            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',	
                'product.sku as sku',
                'product.brand_id as brand_id',
                'product.category_id as category_id',
                'product.subcat_id as subcat_id',
                'product.subcat_level as subcat_level',
                'product.segment as segment',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
                //'fairlocation.address_id as address_id',
                /*'country.id as id',
                'state.id as id',
                'city.id as id',*/
                /*'opos_receiptproduct.price as price',
                'opos_receiptproduct.quantity as quantity',
                'salesmemoproduct.salesmemo_id as salesmemo_id',*/
                //'salesmemo.fairlocation_id as fairlocation_id',
            ]);
          /*  echo "<pre>";
            print_r($product);
            exit;*/
         

            foreach ($products as $key1 => $value1) {
                foreach ($user_info as $key2 => $value2) {
                    //echo "<pre>";print_r($value2);
					if ($value1->id  ==  $value2->product_id) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount );
                        
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                    }
                }
            }
         	
            $sum = 0;

            foreach($newArry as $num => $values) {
                $sum += $values[ 'price' ];
            }
            
         /*echo "<pre>";
         print_r($productCatq);
         exit;*/

            $price = array();
            foreach ($newArry as $key => $row)
            {	
            	if( $productCatq == $row['category_id'] || $subcategory == $row['category_id'] || $brand == $row['brand_id'] || $product == $row['id'] || $channel == $row['segment'] || $countryq == '150'){

                $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                $price[$key]['quantity']= $row['quantity'];
                $price[$key]['discount']= $row['discount'];
                
                $price[$key]['brand_id']= $row['brand_id'];
                $price[$key]['category_id']= $row['category_id'];
                $price[$key]['subcat_id']= $row['subcat_id'];
                $price[$key]['subcat_level']= $row['subcat_level'];
                $price[$key]['location']= $row['segment'];
                
                $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                $price[$key]['price']= $row['price'];
                $price[$key]['pricedata']= number_format($row['price']/100,2);
                $price[$key]['id']= $row['id'];
                $price[$key]['totalProduct']= $sum;
                $price[$key]['sku']= $row['sku'];
                $price[$key]['barcode']= $row['barcode'];
                $price[$key]['name']= $row['name'];

                //$price[$key]['price']= $row['price'];
                $price[$key]['npid']= $row['npid'];
                $price[$key]['description']= $row['description'];
                $price[$key]['description']= $row['description'];
                $price[$key]['thumb_photo']= $row['thumb_photo'];
                $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];
            }
            
           }
         /*  echo "<pre>";
           print_r($price);
           exit;*/
           
                      
        return Response()->json($price);
       
    }
	
           
    public function skulist_ytd()
    {
        $user_id     = Auth::user()->id;     

        if(isset($_GET['country']) != '')
        {
            $country =  $_GET['country'];
        }
        if(isset($_GET['state']) != '')
        {
            $state = $_GET['state'];
        }
        if(isset($_GET['city']) != '')
        {
            $city = $_GET['city'];
        }
        
        if(isset($_GET['marea']) != '')
        {
            $marea = $_GET['marea'];
        }
        if(isset($_GET['product']) != '')
        {
            $product = $_GET['product'];
        }
        if(isset($_GET['brand']) != '')
        {
            $brand = $_GET['brand'];
        }
        if(isset($_GET['category']) != '')
        {
            $category = $_GET['category'];
        }
        if(isset($_GET['subcategory']) != '')
        {
            $subcategory = $_GET['subcategory'];
        }
        if(isset($_GET['consumer']) != '')
        {
            $consumer = $_GET['consumer'];
        }
        if(isset($_GET['channel']) != '')
        {
            $channel =  $_GET['channel'];
        }
        
        if($channel != "all2loc" OR  $channel != "overall2sales" OR $channel != "b2c" OR $channel != "b2b" OR $channel != "hyper" OR $channel == "smm" OR $channel != "openwish")
        {   
            $productCatq ='';
            if($category != ''){
            	$productCatq = $category ;
            }
            $productSubCatq ='';
            if($subcategory != '')
            {
                $productSubCatq = $subcategory ;
            }
            $productBrandq = '';
            if($brand != '')
            {
                $productBrandq = $brand ;
            }
            $productq = '';
            if($product != '')
            {
                $productq = $product ;
            }
            $productSegmentq = '';
            if($channel != '')
            {

                $productSegmentq = $channel;
            }
             $cityq = '';
			if($city != '')
			{

				$cityq = $city ;
			}
			$stateq = '';
			if($state != '')
			{

				$stateq = $state ;
			}
			$countryq = '';
			if($country != '')
			{

				$countryq = $country ;
			}
        
             $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id','created_at', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
             $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();
           
            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }


         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $hidden_products=$this->get_hidden_products($terminal_id);
         $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')
             ->whereNotIn('product.id',$hidden_products)
            ->orderBy('product.created_at','DESC') ->get([
                 'product.id as id',	
                'product.sku as sku',
                'product.brand_id as brand_id',
                'product.category_id as category_id',
                'product.subcat_id as subcat_id',
                'product.subcat_level as subcat_level',
                'product.segment as segment',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
          
            foreach ($products as $key1 => $value1) {
				$pdate = explode(' ', $value1['original']['pivot_created_at']);
				$dateytd = date("Y") . "-01-01";
             
				//if($pdate['0'] > $dateytd ) {
					foreach ($user_info as $key2 => $value2) {
						
                    $dd1 = explode(' ',$value2->created_at);
                    $dd = $dd1['0'];
                    
                      if ($value1->id  ==  $value2->product_id && $dateytd < $dd ) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount,'created_at' => $dd );
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                        } 
                    }
                }
                           // } 
        
            $sum = 0;
            foreach($newArry as $num => $values) {
                $sum += $values[ 'price' ];
            }

            $price = array();
            foreach ($newArry as $key => $row) {
            	
            	if( $productCatq == $row['category_id'] || $subcategory == $row['category_id'] || $brand == $row['brand_id'] || $product == $row['id'] || $channel == $row['segment']){
            	
                $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                $price[$key]['quantity']= $row['quantity'];
                $price[$key]['discount']= $row['discount'];
                $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                $price[$key]['price']= $row['price'];

                
                $price[$key]['brand_id']= $row['brand_id'];
                $price[$key]['category_id']= $row['category_id'];
                $price[$key]['subcat_id']= $row['subcat_id'];
                $price[$key]['subcat_level']= $row['subcat_level'];
                $price[$key]['location']= $row['segment'];

                $price[$key]['pricedata']= number_format($row['price']/100,2);
                $price[$key]['totalProduct']= $sum;
                $price[$key]['id']= $row['id'];
                $price[$key]['sku']= $row['sku'];
                $price[$key]['barcode']= $row['barcode'];
                $price[$key]['name']= $row['name'];
                $price[$key]['npid']= $row['npid'];
                $price[$key]['description']= $row['description'];
                $price[$key]['description']= $row['description'];
                $price[$key]['thumb_photo']= $row['thumb_photo'];
                $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];
               
             }
         }
                 
           //array_multisort($price, SORT_DESC, $newArry);
        return Response()->json($price);
       
    }
}
    

    public function skulist_mtd()
    {
        $user_id     = Auth::user()->id;    

         if(isset($_GET['country']) != '')
        {
            $country =  $_GET['country'];
        }
        if(isset($_GET['state']) != '')
        {
            $state = $_GET['state'];
        }
        if(isset($_GET['city']) != '')
        {
            $city = $_GET['city'];
        }
        
        if(!empty($_GET['marea']))
        {
            $marea = $_GET['marea'];
        }
        if(isset($_GET['product']) != '')
        {
            $product = $_GET['product'];
        }
        if(isset($_GET['brand']) != '')
        {
            $brand = $_GET['brand'];
        }
        if(isset($_GET['category']) != '')
        {
            $category = $_GET['category'];
        }
        if(isset($_GET['subcategory']) != '')
        {
            $subcategory = $_GET['subcategory'];
        }
        if(isset($_GET['consumer']) != '')
        {
            $consumer = $_GET['consumer'];
        }
        if(isset($_GET['channel']) != '')
        {
            $channel =  $_GET['channel'];
        }
        
        if($channel != "all2loc" OR  $channel != "overall2sales" OR $channel != "b2c" OR $channel != "b2b" OR $channel != "hyper" OR $channel == "smm" OR $channel != "openwish")
        {   
            $productCatq ='';
            if($category != ''){
            	$productCatq = $category ;
            }
            $productSubCatq ='';
            if($subcategory != '')
            {
                $productSubCatq = $subcategory ;
            }
            $productBrandq = '';
            if($brand != '')
            {
                $productBrandq = $brand ;
            }
            $productq = '';
            if($product != '')
            {
                $productq = $product ;
            }
            $productSegmentq = '';
            if($channel != '')
            {

                $productSegmentq = $channel;
            } 
             $cityq = '';
			if($city != '')
			{

				$cityq = $city ;
			}
			$stateq = '';
			if($state != '')
			{

				$stateq = $state ;
			}
			$countryq = '';
			if($country != '')
			{

				$countryq = $country ;
			}
        $user_info3 = DB::table('locationproduct')
                 ->select('location_id', DB::raw('count(*) as total'))
                 ->groupBy('location_id')
                 ->get();

         

         $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id','updated_at','created_at', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
         $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();
           
            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }

            
         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')

             //->join('locationproduct','locationproduct.product_id','=','product.id')
             //->leftjoin('opos_receiptproduct','opos_receiptproduct.product_id','=', 'product.id')


            ->orderby('product.created_at','DESC') ->get([
                 'product.id as id',	
                'product.sku as sku',
               'product.brand_id as brand_id',
                'product.category_id as category_id',
                'product.subcat_id as subcat_id',
                'product.subcat_level as subcat_level',
                'product.segment as segment',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
                //'locationproduct.location_id as location_id',
            ]);
         
            foreach ($products as $key1 => $value1) {
          
               $pdate = explode(' ', $value1['original']['pivot_created_at']);
               $datemtd = date("Y-m") . "-01";
                    
                	 	
                	
                foreach ($user_info as $key2 => $value2) {
              		$dd1 = explode(' ',$value2->created_at );
              		$dd = $dd1['0'];
                      if ($value1->id  ==  $value2->product_id && $datemtd <= $dd) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount,'created_at' => $dd );
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                        } 
                    }
                    }
                 /*  echo "<pre>";
                   print_r($newArry);
                   exit;*/

                   if(!empty($newArry))
                   {


                    $sum = 0;
                    foreach($newArry as $num => $values) {
                        $sum += $values[ 'price' ];
                    }

                    $price = array();
                    foreach ($newArry as $key => $row)
                    {
                    	if( $productCatq == $row['category_id'] || $subcategory == $row['category_id'] || $brand == $row['brand_id'] || $product == $row['id'] || $channel == $row['segment']){
                        $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                        $price[$key]['quantity']= $row['quantity'];
                        $price[$key]['discount']= $row['discount'];
                        $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                        $price[$key]['price']= $row['price'];

                        $price[$key]['pricedata']= number_format($row['price']/100,2);
                        $price[$key]['totalProduct']= $sum;
                        $price[$key]['id']= $row['id'];
                        $price[$key]['sku']= $row['sku'];

                        $price[$key]['barcode']= $row['barcode'];
                        $price[$key]['name']= $row['name'];
                        $price[$key]['brand_id']= $row['brand_id'];
		                $price[$key]['category_id']= $row['category_id'];
		                $price[$key]['subcat_id']= $row['subcat_id'];
		                $price[$key]['subcat_level']= $row['subcat_level'];
		                $price[$key]['segment']= $row['segment'];
		                //$price[$key]['location']= $row['location_id'];		

                        $price[$key]['npid']= $row['npid'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['thumb_photo']= $row['thumb_photo'];
                        $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                        $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                        $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                        $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];
                      
             }
         }
         return Response()->json($price);
     }
     else
     {
     	return "No data available";
     }
                 
           //array_multisort($price, SORT_DESC, $newArry);
        
       
    }
}
    

    public function skulist_wtd()
    {
        $user_id     = Auth::user()->id;     
         if(isset($_GET['country']) != '')
        {
            $country =  $_GET['country'];
        }
        if(isset($_GET['state']) != '')
        {
            $state = $_GET['state'];
        }
        if(isset($_GET['city']) != '')
        {
            $city = $_GET['city'];
        }
        
        if(isset($_GET['marea']) != '')
        {
            $marea = $_GET['marea'];
        }
        if(isset($_GET['product']) != '')
        {
            $product = $_GET['product'];
        }
        if(isset($_GET['brand']) != '')
        {
            $brand = $_GET['brand'];
        }
        if(isset($_GET['category']) != '')
        {
            $category = $_GET['category'];
        }
        if(isset($_GET['subcategory']) != '')
        {
            $subcategory = $_GET['subcategory'];
        }
        if(isset($_GET['consumer']) != '')
        {
            $consumer = $_GET['consumer'];
        }
        if(isset($_GET['channel']) != '')
        {
            $channel =  $_GET['channel'];
        }
        
        if($channel != "all2loc" OR  $channel != "overall2sales" OR $channel != "b2c" OR $channel != "b2b" OR $channel != "hyper" OR $channel == "smm" OR $channel != "openwish")
        {   
            $productCatq ='';
            if($category != ''){
            	$productCatq = $category ;
            }
            $productSubCatq ='';
            if($subcategory != '')
            {
                $productSubCatq = $subcategory ;
            }
            $productBrandq = '';
            if($brand != '')
            {
                $productBrandq = $brand ;
            }
            $productq = '';
            if($product != '')
            {
                $productq = $product ;
            }
            $productSegmentq = '';
            if($channel != '')
            {

                $productSegmentq = $channel;
            } 
             $cityq = '';
			if($city != '')
			{

				$cityq = $city ;
			}
			$stateq = '';
			if($state != '')
			{

				$stateq = $state ;
			}
			$countryq = '';
			if($country != '')
			{

				$countryq = $country ;
			}
         $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id','updated_at','created_at', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
         $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();
           
            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }

            
         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $hidden_products=$this->get_hidden_products($terminal_id);
         $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')
             ->whereNotIn('product.id',$hidden_products)

            ->orderBy('product.created_at','DESC') ->get([
               'product.id as id',	
                'product.sku as sku',
               'product.brand_id as brand_id',
                'product.category_id as category_id',
                'product.subcat_id as subcat_id',
                'product.subcat_level as subcat_level',
                'product.segment as segment',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
           
            foreach ($products as $key1 => $value1) {
          
               $pdate = explode(' ', $value1['original']['pivot_created_at']);
               $date1 = date("Y-m-d"); 
                $datewtd =  date('Y-m-d', strtotime('last monday', strtotime($date1)));
                	
                foreach ($user_info as $key2 => $value2) {
              
                      $dd1 = explode(' ',$value2->created_at );
              		  $dd = $dd1['0'];
                	/*echo '<pre>';
                	print_r($dd); */ 	
                      if ($value1->id  ==  $value2->product_id && $datewtd < $dd) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount,'created_at' => $dd );
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                        } 
                    }
                     }
                   
               /*    echo "<pre>";
                   print_r($newArry);
                   exit;*/	
                   if(!empty($newArry))
                   {
                    $sum = 0;
                    foreach($newArry as $num => $values) {
                        $sum += $values[ 'price' ];
                    }
                    $price = array();
                    foreach ($newArry as $key => $row)
                    {
                    	if( $productCatq == $row['category_id'] || $subcategory == $row['category_id'] || $brand == $row['brand_id'] || $product == $row['id'] || $channel == $row['segment']){
                        $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                        $price[$key]['quantity']= $row['quantity'];
                        $price[$key]['discount']= $row['discount'];
                        $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                        $price[$key]['price']= $row['price'];

                        $price[$key]['pricedata']= number_format($row['price']/100,2);
                        $price[$key]['totalProduct']= $sum;
                        $price[$key]['id']= $row['id'];
                        $price[$key]['sku']= $row['sku'];
                        $price[$key]['barcode']= $row['barcode'];
                        $price[$key]['name']= $row['name'];
                        $price[$key]['brand_id']= $row['brand_id'];
		                $price[$key]['category_id']= $row['category_id'];
		                $price[$key]['subcat_id']= $row['subcat_id'];
		                $price[$key]['subcat_level']= $row['subcat_level'];
		                $price[$key]['segment']= $row['segment'];
                        $price[$key]['npid']= $row['npid'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['thumb_photo']= $row['thumb_photo'];
                        $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                        $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                        $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                        $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];
                      
                     }
             }

        		return Response()->json($price);
            }
            else
            {	
            	return "No data available";
            }
          
            
           
       
    }
}
    public function skulist_daily()
       {
        $user_id     = Auth::user()->id;  
        if(isset($_GET['country']) != '')
        {
            $country =  $_GET['country'];
        }
        if(isset($_GET['state']) != '')
        {
            $state = $_GET['state'];
        }
        if(isset($_GET['city']) != '')
        {
            $city = $_GET['city'];
        }
        
        if(isset($_GET['marea']) != '')
        {
            $marea = $_GET['marea'];
        }
        if(isset($_GET['product']) != '')
        {
            $product = $_GET['product'];
        }
        if(isset($_GET['brand']) != '')
        {
            $brand = $_GET['brand'];
        }
        if(isset($_GET['category']) != '')
        {
            $category = $_GET['category'];
        }
        if(isset($_GET['subcategory']) != '')
        {
            $subcategory = $_GET['subcategory'];
        }
        if(isset($_GET['consumer']) != '')
        {
            $consumer = $_GET['consumer'];
        }
        if(isset($_GET['channel']) != '')
        {
            $channel =  $_GET['channel'];
        }
        
        if($channel != "all2loc" OR  $channel != "overall2sales" OR $channel != "b2c" OR $channel != "b2b" OR $channel != "hyper" OR $channel == "smm" OR $channel != "openwish")
        {   
            $productCatq ='';
            if($category != ''){
            	$productCatq = $category ;
            }
            $productSubCatq ='';
            if($subcategory != '')
            {
                $productSubCatq = $subcategory ;
            }
            $productBrandq = '';
            if($brand != '')
            {
                $productBrandq = $brand ;
            }
            $productq = '';
            if($product != '')
            {
                $productq = $product ;
            }
            $productSegmentq = '';
            if($channel != '')
            {

                $productSegmentq = $channel;
            }    
             $cityq = '';
			if($city != '')
			{

				$cityq = $city ;
			}
			$stateq = '';
			if($state != '')
			{

				$stateq = $state ;
			}
			$countryq = '';
			if($country != '')
			{

				$countryq = $country ;
			}

         $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id','updated_at','created_at', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
         $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();
           
            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }

            
         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')


            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',	
                'product.sku as sku',
               'product.brand_id as brand_id',
                'product.category_id as category_id',
                'product.subcat_id as subcat_id',
                'product.subcat_level as subcat_level',
                'product.segment as segment',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
           
            foreach ($products as $key1 => $value1) {
          
               $pdate = explode(' ', $value1['original']['pivot_created_at']);
               $dateytd = date("Y-m-d");
                foreach ($user_info as $key2 => $value2) {
              
                      $dd1 = explode(' ',$value2->created_at );
              		  $dd = $dd1['0'];
                      if ($value1->id  ==  $value2->product_id && $dateytd == $dd) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount,'created_at' => $dd );
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                        } 
                    }
                }
                	/*echo "<pre>";
                	print_r($newArry);
                	exit;*/
                   /* if(isset($newArry))
                    {  */   
                    if(!empty($newArry))        
                    {
                    $sum = 0;
                    foreach($newArry as $num => $values) {
                        $sum += $values[ 'pricesum' ];
                    }
                    $price = array();
                    foreach ($newArry as $key => $row)
                    {
                    /*echo "<pre>";
                	print_r($newArry);*/
                	
                    	if( $productCatq == $row['category_id'] || $subcategory == $row['category_id'] || $brand == $row['brand_id'] || $product == $row['id'] || $channel == $row['segment']){
                        $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                        $price[$key]['quantity']= $row['quantity'];
                        $price[$key]['discount']= $row['discount'];
                        $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                        $price[$key]['price']= $row['price'];

                        $price[$key]['pricedata']= number_format($row['price']/100,2);
                        $price[$key]['totalProduct']= $sum;
                        $price[$key]['id']= $row['id'];
                        $price[$key]['sku']= $row['sku'];
                        $price[$key]['barcode']= $row['barcode'];
                        $price[$key]['name']= $row['name'];
                        $price[$key]['brand_id']= $row['brand_id'];
		                $price[$key]['category_id']= $row['category_id'];
		                $price[$key]['subcat_id']= $row['subcat_id'];
		                $price[$key]['subcat_level']= $row['subcat_level'];
		                $price[$key]['segment']= $row['segment'];
                       
                        $price[$key]['npid']= $row['npid'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['thumb_photo']= $row['thumb_photo'];
                        $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                        $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                        $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                        $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];
                      
                       }
             }
             return Response()->json($price);


         }
         else
         {
         	return "No data available";
         }
        /* }*/
    }
         // echo "<pre>";
         // print_r($price);
         // exit;
             
        return Response()->json($price);
       
    }




        /*$totalsales  = DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                porder.user_id as uid,
                member.name as name,
                users.avatar as image,
                op.product_id as proId,
                
                SUM((opr.price* opr.quantity)) as sales,
                SUM((opr.quantity)) as sales_quantity,
                DAY(opr.updated_at) as date

                FROM

                porder
                
                JOIN member on member.user_id = porder.user_id
                
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id

                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                
                JOIN users on users.id= porder.user_id
                JOIN opos_receiptproduct as opr on opr.product_id = op.product_id
                
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code
                
                WHERE DATE(opr.created_at) = '".$toDate."'

                AND mp.merchant_id = ".$merchant['id']. " 
                GROUP BY users.id
                
            "
        ));
        
        $sum = 0;
        foreach ($totalsales as $key => $values) {
            $sum +=$values->sales; 
        }

        $sales_stff = array();
        foreach ($totalsales as $key => $row)
        {
        
            $sales_stff[$key]['id'] = $row->id;
            $sales_stff[$key]['uid'] = $row->uid;
            $sales_stff[$key]['name'] = $row->name;
            $sales_stff[$key]['image'] = $row->image;
            $sales_stff[$key]['proId'] = $row->proId;
            $sales_stff[$key]['salesall'] = $sum;
            $sales_stff[$key]['sales'] = $row->sales;
            $sales_stff[$key]['sales_quantity'] = $row->sales_quantity;
            $sales_stff[$key]['date'] = $row->date;
        }

        return $sales_stff;*/

    public function listproduct($terminal_id)
    {

        if (!Auth::check()) {
            # code...
            return response()->json(["error"=>"User not logged in"]);
        }
        $user_id     = Auth::user()->id;

		/* This only works when user_id is the merchant_user_id */
        $user_id  = Auth::user()->id;
		//Log::debug('listproduct: user_id='.$user_id);

 		$staff_user_id = null;

		if (Auth::user()->hasRole("byr")) {
			$staff_user_id = $user_id;
			Log::info('Staff: OPOSsum via Buyer Dashboard');
			Log::info('Staff user_id='.$staff_user_id);

 			$user_id = DB::table('role_users')->
				join('roles','roles.id','=','role_users.role_id')->
				join('company','company.id','=','role_users.company_id')->
				where('user_id',$user_id)->
				whereIn('roles.slug',['opu','opm'])->
				pluck('company.owner_user_id');
		}
 
		/* If user_id is a staff, then $merchant will be NULL */
		$merchant_user_id=DB::table("opos_locationterminal")
		->join("fairlocation","fairlocation.id","=","opos_locationterminal.location_id")
		->where("opos_locationterminal.terminal_id",$terminal_id)

		->pluck("fairlocation.user_id");
        $merchant = Merchant::where('user_id','=',$merchant_user_id)->first();

        if (empty($merchant)) {
            # code...
            return response()->json(["error"=>"User not merchant"]);
        }
          $barcodes = Product::join('productbc','productbc.product_id','=','product.id')
                    ->join('bc_management','bc_management.id','=','productbc.bc_management_id')
                     ->join('merchantproduct as mp','mp.product_id','=','product.id')
                     ->join('merchantproduct','merchantproduct.product_id','=','product.id')
                     ->where('merchantproduct.merchant_id',$merchant->id)
                    ->whereNull('mp.deleted_at')
                    ->get([
                        'product.id',
                        'bc_management.barcode',
                        'product.thumb_photo as thumb_photo',
                        'product.name as name',
                        'product.retail_price as retail_price',
                    ]);
 
		//Log::debug('listproduct: merchant_id='.$merchant->id);


		$barcodes = Product::join('productbc','productbc.product_id','=','product.id')
		->join('bc_management','bc_management.id','=','productbc.bc_management_id')
		->join('merchantproduct as mp','mp.product_id','=','product.id')
		->join('merchantproduct','merchantproduct.product_id','=','product.id')
		->where('merchantproduct.merchant_id',$merchant->id)
		->whereNull('mp.deleted_at')
		->get([
			'product.id',
			'bc_management.barcode',
			'product.thumb_photo as thumb_photo',
			'product.name as name',
			'product.retail_price as retail_price',
		]);

		$barcodearr = Array();
        foreach ($barcodes as $barcode){
			$barcodearr[$barcode->barcode] = array(
				"id"=>$barcode->id,
				"name"=>$barcode->name,
				"retail_price"=>$barcode->retail_price,
				"thumb_photo"=>$barcode->thumb_photo
			);
        }

//        return $barcodearr;
        $hidden_products=$this->get_hidden_products($terminal_id);
        Log::debug((array)$hidden_products);
        $products =   $merchant->products()
            ->join('merchantproduct as mp','mp.product_id','=','product.id')
            ->leftjoin('opos_productpreference',function($join) use ($terminal_id)
            {
            	$join->on('opos_productpreference.product_id','=','product.id');
            	$join->where('opos_productpreference.terminal_id','=',$terminal_id);
            	$join->where('opos_productpreference.price_keyin','=',1);

            })
            ->whereNull('mp.deleted_at')
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->where('product.status','!=','transferred')
            ->whereNotIn('product.id',$hidden_products)
            ->whereNull('product.deleted_at')->orderBy('product.created_at','DESC')
            ->get([
                'product.id as id',
                'product.parent_id as tprid',
                'product.id as prid',
                'product.discounted_price as discounted_price',
                'product.name as name',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
                'product.parent_id as parent_id',
                DB::raw('IF(opos_productpreference.price_keyin = 1 and opos_productpreference.local_price is not null,opos_productpreference.local_price,product.retail_price) as retail_price'),
                // 'product.retail_price as retail_price',
                'nproductid.nproduct_id as nproductid'
            ]);
            return Response()->json(array($products,$barcodearr));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savesparoom(Request $request)
    {
        $type=$request->type;
        $fnumber=$request->fnumber;
        $terminal_id=$request->terminal_id;
        $location_id=DB::table("opos_locationterminal")->
			where("terminal_id",$terminal_id)->
			whereNull("deleted_at")->
			pluck("location_id");

		Log::debug("savesparoom(): fnumber=$fnumber, terminal_id=$terminal_id, location_id=$location_id");

        if (empty($location_id)) {
        	# code...
        	return "";
        }
        $check    = DB::table("opos_ftype")->where('fnumber','=',$fnumber)
        	->where("location_id",$location_id)
        	->where("ftype",$request->ftype)->whereNull("deleted_at")->pluck('fnumber');
        if ($check == $request->fnumber) {
            return -1;
        }
        $does_exist=DB::table("opos_ftype")->where("fnumber",$fnumber)
        ->where("ftype",$type)->whereNull("deleted_at")->where("location_id",$location_id)->first();
        if (!empty($does_exist)) {
            # code...
            return -2;
        }
        $d=DB::table("opos_ftype")
        ->insertgetId([
            "ftype"=>$type,
            "fnumber"=>$fnumber,
            "location_id"=>$location_id,
            "terminal_id"=>$terminal_id,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ]);

        $ret=DB::table("opos_ftype")->where("id",$d)->first();
        return  response()->json($ret);
    }

    public function savetable(Request $request){
        $type=$request->type;
        $fnumber = $request->fnumber;
        $location_id=DB::table("opos_locationterminal")
        	->where("terminal_id",$request->terminal_id)
        	->whereNull("deleted_at")
        	->orderBy("id","DESC")
        	->pluck("location_id");

        $check = DB::table("opos_ftype")
        ->where("fnumber", $fnumber)
        ->where("location_id",$location_id)
        ->where("ftype",$type)
        ->whereNull("deleted_at")
        ->get();


        if (count($check) == 1) {
            return -1;
        } 
        else{

            $d=DB::table("opos_ftype")
            ->insertgetId([
                "ftype"=>$type,
                "fnumber"=>$fnumber,
                "terminal_id"=>$request->terminal_id,
                "location_id"=>$location_id,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ]);

            $ret=DB::table("opos_ftype")->where("id",$d)->first();
            return  response()->json($ret);
        }

    }
    
    public function savehotelroom(Request $request){
        $type=$request->type;
        $fnumber = $request->fnumber;

        $check = DB::table("opos_ftype")
        ->where("fnumber", $fnumber)
        ->where("ftype",$type)
        ->whereNull("deleted_at")
        ->get();


        if (count($check) == 1) {
            return -1;
        } 
        else{
            $d=DB::table("opos_ftype")
            ->insertgetId([
                "ftype"=>$type,
                "fnumber"=>$fnumber,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ]);

            $ret=DB::table("opos_ftype")->where("id",$d)->first();
            return  response()->json($ret);
        }

    }


    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function eod(Request $r,$uid=NULL)
    {
		Log::debug('--------- eod() ---------');

    	$ret=array();
    	$ret["status"]="failure";
    	if(!Auth::check()){return "";}
    	$user_id=Auth::user()->id;
    	if(!empty($uid) and Auth::user()->hasRole("adm")){
    		$user_id=$uid;
    	}
    	$log_id="";
    	try{

    		/*Decide if insert or update*/
    		$terminal_id=$r->terminal_id;
    		$table="hcap_attendance";
    		$insert=[
    		"staff_user_id"=>$user_id,
    		"terminal_id"=>$r->terminal_id,
    		"checkout"=>Carbon::now(),
    		"created_at"=>Carbon::now(),
    		"updated_at"=>Carbon::now()
    		];
    		$data=DB::table($table)
				->insert($insert);

    		$location_id=DB::table("opos_locationterminal")
				->where("terminal_id",$r->terminal_id)
				->whereNull("deleted_at")
				->orderBy("created_at","DESC")
				->pluck("location_id");

    		$affected_terminals=DB::table("opos_locationterminal")
				->where("location_id",$location_id)
				->whereNull("deleted_at")
				->orderBy("created_at","DESC")
				->select("opos_locationterminal.terminal_id")->get();

    		$eod=Carbon::now();
    		DB::table("opos_eod")
				->insert([
					"eod_presser_user_id"=>$user_id,
					"location_id"=>$location_id,
					"eod"=>$eod,
					"created_at"=>Carbon::now(),
					"updated_at"=>Carbon::now()
				]);

    		foreach ($affected_terminals as $terminal) {

    			$CommissionDataQuery = "SELECT
				  	`product`.`name`,
				  	`users`.`email` AS `useremail`,
				  	`member`.`email` AS `memberemail`,
				  	`product`.`id` AS `pid`,
				  	`nproductid`.`nproduct_id` AS `nproduct_id`,
				  	`product`.`thumb_photo`,
				  	`opos_saleslog`.*,
				  	SUM(
				    	hcap_productcomm.commission_amt
				  	) AS commission,
			  		SUM(hcap_productcomm.time) AS productTime,
			  		SUM(opos_saleslog.price) AS price,
			  		SUM(opos_saleslog.quantity) AS quantity
					FROM
					  `opos_saleslog`
					INNER JOIN
			  		`product`
					ON
			  		`product`.`id` = `opos_saleslog`.`product_id`
					INNER JOIN
			  		`hcap_productcomm`
					ON
			  		`hcap_productcomm`.`product_id` = `product`.`id` AND `opos_saleslog`.`masseur_id` = `hcap_productcomm`.`sales_member_id`
					LEFT JOIN
			  		`nproductid`
					ON
			  		`nproductid`.`product_id` = `product`.`id`
					LEFT JOIN
			  		`member`
					ON
			  		`member`.`id` = `opos_saleslog`.`masseur_id`
					LEFT JOIN
			  		`users`
					ON
			  		`member`.`user_id` = `users`.`id`
					WHERE
			  		`opos_saleslog`.`deleted_at` IS NULL AND `opos_saleslog`.`start` IS NOT NULL AND `opos_saleslog`.`end` IS NOT NULL AND `opos_saleslog`.`status` = 'completed' AND `opos_saleslog`.`terminal_id` = $terminal->terminal_id
					GROUP BY
			  		`opos_saleslog`.`masseur_id`";

			$CommissionDataWithEmail = DB::select(DB::raw($CommissionDataQuery));

			 $e = new EmailController;
			$e->sendCommissionEmail($CommissionDataWithEmail);

    			$r=DB::table('opos_terminal')
					->where("id",$terminal->terminal_id)
					->select(DB::raw(
						"start_work,HOUR(start_work) as starthour"))
					->first();

				/* Protect against old terminals which are deleted but
				   still referenced */
				if (empty($r)) continue;

				Log::debug('***** $terminal *****');
				Log::debug(json_encode($terminal));
				Log::debug(json_encode($r));

    			$start_work=$r->start_work;
    			$starthour=$r->starthour;
    			// $start_work=Carbon::createFromFormat('H:i:s',!empty($start_work)?$start_work:"00:00:00");

    			// if ($eod->hour<$starthour) {
    			// 	# code...
    			// 	$start_work=$start_work->subDays(1);
    			// }

//------------------------------------------------------------------------------------------//
			// insert all receiptdata
			
			$reports = DB::table("opos_receipt")->
				join("opos_receiptproduct","opos_receiptproduct.receipt_id","=","opos_receipt.id")->
				leftJoin('opos_servicecharge','opos_servicecharge.id','=','opos_receiptproduct.servicecharge_id')->
				leftJoin('users as usercheck','usercheck.id','=','opos_receipt.staff_user_id')->
				leftJoin('opos_servicecharge as sc','sc.id','=','opos_receipt.servicecharge_id')->
				select('sc.value',
	                "opos_receipt.id as receipt_id",
					DB::raw(
						"SUM(opos_receiptproduct.quantity*(opos_receiptproduct.price)) as amount"
					),
					"sc.value as servicecharge",
					"opos_receipt.service_tax",
					"opos_receipt.status",
					"opos_receipt.cash_received",
					"opos_receipt.otherpoints",
					"opos_receipt.payment_type",
					"opos_receipt.mode",
					DB::raw(
						"SUM((opos_receiptproduct.quantity*opos_receiptproduct.price*opos_receiptproduct.discount)/100) as discount")
					)->
				whereRaw('opos_receipt.status IN ("completed")')->
				whereNull("opos_receipt.deleted_at")->
	            whereNull("opos_receiptproduct.deleted_at");

		 		// $log_startDate = $log_endDate = $CurrentDate=date("Y-m-d H:i:s",strtotime($start_work));
		   //      $endDate = date("Y-m-d H:i:s",strtotime('+24 hours', strtotime($CurrentDate)));
		   //      $endDate = date("H:i:s",strtotime('-5 minutes',strtotime($CurrentDate)));
				
		   //      $CurrentTime  = date("H:i:s");
				
		   //      $CurrentdATETime  = date("Y-m-d H:i:s");
		   //      $Midnight     = date('00:00:00');

		        //  if($CurrentTime >= $Midnight && $CurrentTime < $endDate){
          //   		$log_startDate=date("Y-m-d H:i:s",strtotime('-24 hours', strtotime($CurrentDate)));
        	    
        		// }else{

          //  	 		$log_endDate=date("Y-m-d H:i:s",strtotime('+24 hours', strtotime($CurrentDate)));
        		// }
        		// $log_endDate = date("Y-m-d H:i:s",strtotime('-5 minutes',strtotime($log_endDate)));
				

				// $starttimes = '00:00:00' ;
		  		// $endtimes = '23:59:59';
	            $starttimes = date('Y-m-d 00:00:00');
        		$endtimes =date('Y-m-d 23:59:59');
		        if(!empty($terminal->terminal_id)){
					$Eodtimes = app('App\Http\Controllers\OposEodController')->eod_times($terminal->terminal_id);
					$starttimes = $Eodtimes['starttimes'];
					$endtimes = $Eodtimes['endtimes'];
				}
		

        		// $month_start = date('Y-m-d',strtotime('first day of this month',strtotime($CurrentDate)));

        		// $month_end = date('Y-m-d',strtotime('last day of this month',strtotime($log_endDate)));

        		$month_start = date('Y-m-d',strtotime('first day of this month',$starttimes));
				
        		$month_end = date('Y-m-d',strtotime('last day of this month',$endtimes));

        		//today total

	  			$todayAmount = $reports->
				whereRaw('opos_receipt.terminal_id = '.$terminal->terminal_id)->
	            // whereRaw('opos_receipt.created_at BETWEEN "'.
	            //     $CurrentDate.'" AND "'.$log_endDate.'"')->
	            whereRaw('opos_receipt.created_at BETWEEN "'.date('Y-m-d H:i:s', $starttimes).'" AND "'.date('Y-m-d H:i:s', $endtimes).'"')->
				groupBy('opos_receipt.id')->
				get();
				
				// monthly total
				$Monthlyamount = $reports->
				whereRaw('opos_receipt.terminal_id = '.$terminal->terminal_id)->
	            whereRaw('opos_receipt.created_at BETWEEN "'.
	                $month_start.'" AND "'.$month_end.'"')->
				groupBy('opos_receipt.id')->
				first();
				$Monthlyamount = 0;
				if(!empty($Monthlyamount)){
					$Monthlyamount = $Monthlyamount->amount;
				}

				//branch total
				$branchsalerecords=$reports->
				join('opos_locationterminal','opos_locationterminal.terminal_id','=','opos_receipt.terminal_id')->
				where('opos_locationterminal.location_id',$location_id)->
	            // whereRaw('opos_receipt.created_at BETWEEN "'.$CurrentDate.'" AND "'.$log_endDate.'"')->
	            whereRaw('opos_receipt.created_at BETWEEN "'.date('Y-m-d H:i:s', $starttimes).'" AND "'.date('Y-m-d H:i:s', $endtimes).'"')->
				groupBy('opos_receipt.id')->
				get();
				
				$todayservicecharge=0;$todaysst=0;$todaytotal=0;
				foreach ($todayAmount as $r) {
		            /* Original price less discount */

		            if ($r->mode=="inclusive") {
		                $r->amount = $r->amount - $r->discount;
		                $sc=0;
		                $amount=$r->amount/(1+($r->service_tax/100));
		                $todaysst+=$r->amount-$amount;
		                $todayservicecharge+=$sc;
		                $todaytotal += $amount;

		            }else{
		                $r->amount = $r->amount - $r->discount;
		                $todayservicecharge+=($r->servicecharge*$r->amount)/100;
		                $todaysst=($r->service_tax*$r->amount)/100;
		                $todaytotal += $r->amount;
		            }
		        }

		        $branchsale=0;
		        foreach ($branchsalerecords as $r) {
		            /* Original price less discount */

		            if ($r->mode=="inclusive") {
		                $r->amount = $r->amount - $r->discount;
		                $sc=0;
		                $amount=$r->amount/(1+($r->service_tax/100));
		                //$sst=$r->amount-$amount;
		                $branchsale += $amount;
		                /*$s=floatval($r->amount) * (($r->service_tax)/100.0);*/
		                /*$r->amount=$r->amount/(1+($r->service_tax/100));*/

		            }else{
		                $r->amount = $r->amount - $r->discount;
		                $branchsale += $r->amount;
		            }
		        }

		        $cash=0;
		        $creditcard=0;
		        $otherpoints=0;
        
		        foreach ($todayAmount as $r) {
		            //Log::debug(json_encode($r));
		            /* Original price less discount */
		            
		            $r->amount = $r->amount - $r->discount;

		            /* Service charge against total */
		            $scharge = $r->amount * (($r->value)/100);

		            /*Service Tax*/
		            $sst=0;
		            if ($r->mode=="exclusive") {
		                $sst+=$r->amount * (($r->service_tax)/100);
		            }
		            /* Final total includes service charge */
		            $r->amount = $r->amount + $scharge+$sst; 
		            /*For cash and credit*/
		            if($r->status=="completed"){
		                if ($r->cash_received>=$r->amount) {
		                    $cash+=$r->amount;

		                }else{
		                    if ($r->cash_received<$r->amount) {
		                        $cash+=$r->cash_received;

		                        if ($r->payment_type=="creditcard") {
		                           
		                            $creditcard+=($r->amount-($r->otherpoints*100)-$r->cash_received);
		                        }
		                    }
		                }

		                $otherpoints+=$r->otherpoints;
		            }
		        }
//------------------------------------------------------------------------------------------//
		       
    			$insert=[
					"terminal_id"=>$terminal->terminal_id,
					"eod"=>$eod,
					"type"=>"manual",
					// "start_work"=>$CurrentDate,
					"start_work"=>date('Y-m-d H:i:s', $starttimes),
					"today_branch_sales" => $branchsale,
					"today_sales" =>$todaytotal,
					"today_sst" =>$todaysst,
					"today_servicecharge" => $todayservicecharge,
					"today_cash" =>$cash,
					"today_creditcard" =>$creditcard,
					"today_point" => $otherpoints,
					"monthly_sales" =>$Monthlyamount,
					"created_at"=>Carbon::now(),
					"updated_at"=>Carbon::now()
				];

    			if($terminal->terminal_id==$terminal_id) {
    				$log_id=DB::table("opos_logterminal")
						->insertGetId($insert);
    			}else{
    				DB::table("opos_logterminal")
						->insert($insert);
    			}
    		}

    		$ret["status"]="success";
    		$ret['log_id']=$log_id;

    	} catch(\Exception $e){
    		//dump($e);
    		$ret["short_message"]=$e->getMessage();
			Log::error("Error @ ".$e->getLine()." file ".
				$e->getFile()." ".$e->getMessage());
    	}
    	return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function lockerkeyquery($location_id,$type="lockerkey")
    {
       
        
        return "
            SELECT
            of.*,
            ol.checkout_tstamp,
            ol.checkin_tstamp

            FROM 
            opos_ftype of 

            LEFT JOIN (
                SELECT * from opos_lockerkeytxn
                WHERE checkout_tstamp IS NULL 
                AND checkin_tstamp IS NOT NULL
                AND deleted_at IS NULL 
            ) ol on ol.lockerkey_ftype_id=of.id
            WHERE 
            of.ftype='lockerkey' AND 
            of.location_id=$location_id AND 
            of.deleted_at is NULL
            AND of.deleted_at IS NULL
            ORDER BY of.fnumber ASC
        ";
    }
    public function hotelroomquery($type="hotelroom")
    {
        return "
            SELECT
            of.*,
            ol.checkout_tstamp,
            ol.checkin_tstamp

            FROM 
            opos_ftype of 

            LEFT JOIN (
                SELECT * from opos_hotelroomtxn
                WHERE checkout_tstamp IS NULL 
                AND checkin_tstamp IS NOT NULL
                AND deleted_at IS NULL 


            ) ol on ol.hotelroom_ftype_id=of.id
            WHERE 
            of.ftype='$type' AND 
            of.deleted_at is NULL
            AND of.deleted_at IS NULL
            ORDER BY of.fnumber ASC
        ";
    }
    

     public function getLastUpdatedLockerKey()
    {
        
        return DB::select("
            SELECT
            of.*,
            ol.checkout_tstamp,
            ol.checkin_tstamp

            FROM 
            opos_ftype of 

            LEFT JOIN (
                SELECT * from opos_lockerkeytxn
                WHERE checkout_tstamp IS NULL 
                AND checkin_tstamp IS NOT NULL
                AND deleted_at IS NULL 
            ) ol on ol.lockerkey_ftype_id=of.id
            WHERE 
            of.ftype='lockerkey' AND 
            of.deleted_at is NULL
            AND of.deleted_at IS NULL
            ORDER BY checkin_tstamp DESC LIMIT 1
        ");
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function sparoomquery($location_id,$type='sparoom')
    {
        return "
            SELECT
            of.*,
            ol.sparoom_checkout,
            ol.sparoom_checkin

            FROM 
            opos_ftype of 

            LEFT JOIN (
                SELECT * from opos_lockerkeytxnsparoom
                WHERE sparoom_checkout IS NULL 
                AND sparoom_checkin IS NOT NULL
                AND deleted_at IS NULL 


            ) ol on ol.sparoom_ftype_id=of.id
            WHERE 
            of.ftype='$type' AND
            of.location_id='$location_id' AND
            of.deleted_at is NULL
            AND of.deleted_at IS NULL
            ORDER BY of.fnumber ASC

        ";
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sparooms($terminal_id,$type="sparoom")
    {
    	$location_id=DB::table("opos_locationterminal")
    		->where("terminal_id",$terminal_id)
    		->whereNull("deleted_at")
    		->pluck("location_id");
        $query=$this->sparoomquery($location_id);
        return DB::select(DB::raw($query));
        /*return $sparoom = DB::table("opos_ftype")
        ->leftJoin("opos_lockerkeytxnsparoom","opos_lockerkeytxnsparoom.sparoom_ftype_id","=","opos_ftype.id")
        ->whereNull("opos_ftype.deleted_at")
      
   /*     ->whereNull("opos_lockerkeytxnsparoom.sparoom_checkout")*/
     /*   ->whereNotNull("opos_lockerkeytxnsparoom.sparoom_checkin")*/
        /*->where("opos_ftype.ftype",$type)

        ->orderBy('opos_ftype.fnumber','ASC')
        ->select("opos_ftype.*","opos_lockerkeytxnsparoom.sparoom_checkin","opos_lockerkeytxnsparoom.sparoom_checkout")
        ->get();*/
    }
    public function lockerkeys($terminal_id,$type="lockerkey")
    {
    	$location_id=DB::table("opos_locationterminal")
    		->where("terminal_id",$terminal_id)
    		->whereNull("deleted_at")
    		->pluck("location_id");
        $query=$this->lockerkeyquery($location_id,$type);

        return DB::select(DB::raw($query));
    }
	
	public function table($terminal_id,$type="table", $fnumber = 0)
    {
        // if($fnumber > 0){
        //     return DB::table("opos_ftype")
        //     ->whereNull("deleted_at")
        //     ->where("fnumber", $fnumber)
        //     ->where("ftype",$type)
        //     ->orderBy('fnumber','ASC')->get();
        // } else{
    		$location_id=DB::table("opos_locationterminal")
    		->where("terminal_id",$terminal_id)
    		->whereNull("deleted_at")
    		->pluck("location_id");
            return DB::table("opos_ftype")
            ->leftJoin("opos_tabletxn","opos_tabletxn.ftype_id","=","opos_ftype.id")
            ->whereNull("opos_ftype.deleted_at")
            ->where("opos_ftype.ftype",$type)
            ->where("opos_ftype.location_id",$location_id)
            ->select("opos_ftype.*","opos_tabletxn.status as txnstatus")
            ->orderBy('opos_ftype.fnumber','ASC')->get();
        // }
    }
	public function hotelroom($type="hotelroom", $fnumber = 0)
    {
        $query=$this->hotelroomquery();
        return DB::select(DB::raw($query));
    }

    public function check_existance($type, $fnumber,$terminal_id ){
    	$location_id=DB::table("opos_locationterminal")
    	->where("terminal_id",$terminal_id)
    	->whereNull("deleted_at")
    	->pluck("location_id");
        return DB::table("opos_ftype")
        ->where("location_id",$location_id)
        ->whereNull("deleted_at")
        ->where("fnumber", $fnumber)
        ->where("ftype",$type)
        ->orderBy('fnumber','ASC')->get();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function checkin(Request $request)
    {

        $sparoom_ftype_id=$request->sparoom_id;

        $opos_customer =new OposSpaCustomer();
        $opos_customer->name = $request->customer_name;
        $opos_customer->email = $request->customer_email;
        $opos_customer->address_id   = 111;
        $opos_customer->save();


        DB::table("opos_lockerkeytxnsparoom")
        
        ->insert([
            "sparoom_ftype_id"=>$sparoom_ftype_id,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now(),
            "sparoom_checkin"=>Carbon::now()
        ]);
        return date('Y-m-d H:i:s');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkoutsparoom(Request $request)
    {
    	/*This is txn_id now*/
        $sparoom_ftype_id=$request->ftype_id;
        Log::debug(compact('sparoom_ftype_id'));
        DB::table("opos_lockerkeytxnsparoom")
        ->where("id",$sparoom_ftype_id)
        ->whereNull("sparoom_checkout")
        ->whereNull("deleted_at")
        ->update([
            "updated_at"=>Carbon::now(),
            "sparoom_checkout"=>Carbon::now()
        ]);
    /*    $sparoom    =   OposSparoom::find($request->id);
        $sparoom->checkin_tstamp   =  "0000-00-00 00:00:00";
        $sparoom->save();*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteroom($id)
    {   

        DB::table("opos_ftype")
        ->where("id",$id)
        ->update([
            "deleted_at"=>Carbon::now()
        ]);
        return $id;
    }

    public function saverec(Request $request)
    {
        $merchant_id = Merchant::where('user_id', Auth::user()->id)->
			first()->id;

        $opos_rec = new OposReceipt();
        $opos_rec->cash_received = $request->cashreceive;
        $opos_rec->merchant_id =   $merchant_id;
        $opos_rec->location_id =   $request->locationid;
        $opos_rec->payment_type =  $request->paymenttype;

        // $opos_rec->points =   $request->points;
        $opos_rec->room_no   = $request->roomno;
        $opos_rec->receipt_no =  Merchant::find($merchant_id)->
			max('opossum_receipt_no') + 1;

		//Log::debug('saverec='.json_encode($opos_rec));

        if ($opos_rec->save()) {
            Merchant::find($merchant_id)->
				update(['opossum_receipt_no'=> $opos_rec->receipt_no]);

            foreach ($request->rec as $key => $row) {
				$opos_rec_product = new OposReceiptproduct();

				$opos_rec_product->receipt_id = $opos_rec->id;    
				$opos_rec_product->product_id = $row['product'];    
				$opos_rec_product->quantity = $row['quantity'];    
				$opos_rec_product->price = $row['price'];    
				$opos_rec_product->discount = $row['discount'];  
				$opos_rec_product->save();  
            }
        }
    }

    public function savediscountbtn(Request $request)
    {
        $check = OposDiscount::where('value','=',$request->discount)
                            ->where('type',$request->type)
                            ->pluck('value');
        if ($check ==$request->discount) {
            return -1;
        }
        $discountbtn = new  OposDiscount();
        $discountbtn->value = $request->discount; 
        $discountbtn->type = $request->type; 
        if ($discountbtn->save()) {
            return  $this->getdiscountbtn();
        }

    }

    public function getdiscountbtn()
    {
        return  $discountbtn =    OposDiscount::orderBy('value','ASC')->get();
    }


    public function list_terminal(Request $request,$uid=NULL)
    {
        if (!Auth::check()) {
            return "";
        }
        $user_id = Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            # code...
            $user_id=$uid;
        }
        $merchant_id = Merchant::where('user_id',$user_id)->pluck('id');
        $month=(int)$request->month;
        $emonth=(string)$month+1;
        $smonth=(string)$month;
        $year=$request->year;
        $id = $request->user_id;
        $fromDate=$year."-".$smonth.'-01';
        $toDate=$year."-".$emonth."-01";
		$terminals  = OposMerchantterminal::join('opos_terminal','opos_merchantterminal.terminal_id','=','opos_terminal.id')
			->join('opos_receipt','opos_terminal.id','=','opos_receipt.terminal_id')
			->join('fairlocation','opos_terminal.location_id','=','fairlocation.id')
			->where('opos_merchantterminal.merchant_id','=',$merchant_id)
			 ->whereBetween('opos_receipt.created_at',[$fromDate,$toDate])
			->get([
				'opos_terminal.id',
				'opos_terminal.name',
				'fairlocation.location as code',

			])
			->groupBy('id');

        $monthly_sale_query="
            SELECT 
            sum(rp.price*rp.quantity) as sale
            FROM 
            opos_receiptproduct rp 
            JOIN  opos_receipt r on rp.receipt_id=r.id
            JOIN  opos_terminal t on r.terminal_id=t.id
            JOIN  opos_merchantterminal m on m.terminal_id=t.id

            WHERE 
            m.merchant_id=$merchant_id
            AND r.created_at BETWEEN '$fromDate' AND '$toDate'
       
            AND r.deleted_at IS NULL
            AND t.deleted_at IS NULL
            AND m.deleted_at IS NULL
        ";

       /* return $monthly_sale_query;*/
        $monthly=DB::select(DB::raw($monthly_sale_query))[0];
        if (empty($monthly)) {
            # code...
            $monthly=(object)array();
            $monthly->sale=0;
        }   
   
        $today_sale_query="
            SELECT 
            sum(rp.price*rp.quantity) as sale
            FROM 
            opos_receiptproduct rp 
            JOIN  opos_receipt r on rp.receipt_id=r.id
            JOIN  opos_terminal t on r.terminal_id=t.id
            JOIN  opos_merchantterminal m on m.terminal_id=t.id

            WHERE 
            m.merchant_id=$merchant_id
            AND r.created_at >=CURDATE()
  
            AND r.deleted_at IS NULL
            AND t.deleted_at IS NULL
            LIMIT 1
        ";
        $today=DB::select(DB::raw($today_sale_query))[0];
        if (empty($today)) {
            # code...
            $today=(object)array();
            $today->sale=0;
        }
        
        return view('seller.opossum_document.terminals',compact('terminals','fromDate','toDate','today','monthly'));
    }

    public function showreceipt($fromDate,$toDate,$terminal_id){
        $user_id = Auth::user()->id;
        $merchant_id = Merchant::where('user_id',$user_id)->pluck('id');
        $receipts  = OposMerchantterminal::join('opos_terminal','opos_merchantterminal.terminal_id','=','opos_terminal.id')
            ->join('opos_receipt','opos_terminal.id','=','opos_receipt.terminal_id')
            ->join('fairlocation','opos_terminal.location_id','=','fairlocation.id')
            ->where('opos_merchantterminal.merchant_id','=',$merchant_id)
            ->where('opos_merchantterminal.terminal_id','=',$terminal_id)
            ->whereBetween('opos_receipt.created_at',[$fromDate,$toDate])
            ->get([
                'opos_receipt.*'

            ]);

        $monthly_sale_query="
            SELECT 
            sum(rp.price*rp.quantity) as sale
            FROM 
            opos_receiptproduct rp 
            JOIN  opos_receipt r on rp.receipt_id=r.id
            JOIN  opos_terminal t on r.terminal_id=t.id
            JOIN  opos_merchantterminal m on m.terminal_id=t.id

            WHERE 
            m.merchant_id=$merchant_id
            AND r.created_at BETWEEN '$fromDate' AND '$toDate'
            AND t.id=$terminal_id
       
            AND r.deleted_at IS NULL
            AND t.deleted_at IS NULL
            AND m.deleted_at IS NULL
          
        ";
       /* return $monthly_sale_query;*/
        $monthly=DB::select(DB::raw($monthly_sale_query))[0];
        if (empty($monthly)) {
            # code...
            $monthly=(object)array();
            $monthly->sale=0;
        }   
   
        $today_sale_query="
            SELECT 
            sum(rp.price*rp.quantity) as sale
            FROM 
            opos_receiptproduct rp 
            JOIN  opos_receipt r on rp.receipt_id=r.id
            JOIN  opos_terminal t on r.terminal_id=t.id
            JOIN  opos_merchantterminal m on m.terminal_id=t.id

            WHERE 
            m.merchant_id=$merchant_id
            AND r.created_at >=CURDATE()
            AND t.id=$terminal_id
            AND r.deleted_at IS NULL
            AND t.deleted_at IS NULL
        ";
        $today=DB::select(DB::raw($today_sale_query))[0];
        return view('seller.opossum_document.opossumreceipt',compact('receipts','monthly','today'));

    }

    public function receiptproducts($receipt_id)
    {
        $gst_rate = Globals::pluck('gst_rate');
  //       $receipts  = OposReceipt::join('opos_receiptproduct',
		// 	'opos_receiptproduct.receipt_id','=','opos_receipt.id')
  //       ->leftJoin('opos_discount','opos_receiptproduct.discount_id','=',
		// 	'opos_discount.id')
		// ->join('product','opos_receiptproduct.product_id','=','product.id')
		// ->where('opos_receipt.id',$receipt_id)
		// ->whereNull("opos_receiptproduct.deleted_at")
		// ->get([
		// 	'opos_discount.type as discount_name',
		// 	'opos_discount.type as discount_name',
		// 	'opos_receiptproduct.*',
		// 	"opos_discount.value as discount",
		// 	'product.name',
		// 	'product.description',
		// ]);
		$receiptproduct  = OposReceipt::join('opos_receiptproduct','opos_receiptproduct.receipt_id','=','opos_receipt.id')
			        ->leftJoin('opos_discount','opos_receiptproduct.discount_id','=',
						'opos_discount.id')
					->leftjoin('product',function($join)
					{
						$join->on('opos_receiptproduct.product_id','=','product.id')
							 ->where('opos_receiptproduct.product_id','!=','null');
					})
					->leftjoin('opos_bundle',function($join)
					{
						$join->on('opos_bundle.id','=','opos_receiptproduct.bundle_id')
							->where('opos_receiptproduct.bundle_id','!=','null');
					})
					->where('opos_receipt.id',$receipt_id)
					->whereNull("opos_receiptproduct.deleted_at")
					->get([
						'opos_discount.type as discount_name',
						'opos_discount.type as discount_name',
						'opos_receiptproduct.*',
						"opos_discount.value as discount",
						'product.name',
						'product.description','opos_bundle.title','opos_bundle.bprice',
					]);


		$receipts = array();
	    foreach($receiptproduct as $bpdata)
	    {
        	// echo '<pre>55'; print_r($bpdata); die();
        	if($bpdata->bundle_id != null)
        	{
        		$bundleproducts = OposBundleProduct::where('bundle_id',$bpdata->bundle_id)->whereNull('deleted_at')->get();

        		// $bundleproducts = OposBundle::with('bundleProduct')
		        // 							->where('id',$bpdata->bundle_id)
		        // 							 ->whereNull('deleted_at')
		        // 							 ->get();

		        $bpdata['bundleproduct'] = $bundleproducts;
        	}
        	else
        	{
        		$bpdata['bundleproduct'] = [];
        	}
        	$receipts[] = $bpdata;
        }
        	// echo '<pre>'; print_r($receipts); die();

        return compact('receipts','gst_rate');
    }

    public function showreceiptproduct($receipt_id,$mode="close"){
        if (!Auth::check()) {
        	# code...
        	$message="Please login to view receipt";
        	$message_type="error";
        	return view("common.generic",compact('message','message_type'));
        }
        $data=$this->receiptproducts($receipt_id);
        // $bundleproducts = array();


        //dd($data);
		Log::debug("receipt_id=".$receipt_id);

        $relatedReceipt="";
        $location="";
        $key="";
		if (!empty($receipt_id)) {

		$receiptInfo = DB::table('opos_receipt')->
			select('opos_receipt.*',"opos_receiptvoucher.voucher_id","opos_servicecharge.value as service_charges",'users.id as staff_id','users.name as staff_name',DB::raw("CONCAT(users.first_name,' ',users.last_name) as staff_name_concat"))->
			leftJoin('users','users.id','=','opos_receipt.staff_user_id')->
			leftJoin("opos_servicecharge","opos_servicecharge.id","=","opos_receipt.servicecharge_id")->
			leftjoin('opos_receiptvoucher','opos_receipt.id','=','opos_receiptvoucher.receipt_id')->
			where('opos_receipt.id',$receipt_id)->
			first();

            if(!empty($receiptInfo->receipt_no)){
                $relatedReceipt = DB::table('opos_receipt')->
					where("opos_receipt.receipt_no","=",$receiptInfo->receipt_no)->
					where("opos_receipt.id","!=",$receiptInfo->id)->
					first(["opos_receipt.id"]);
			}
        }


        if (empty($receiptInfo)) {
        	# code...
        	return "Receipt is not valid";
        }
		if (!empty($receiptInfo)) {
	        $location  = DB::table('opos_locationterminal')->
				select('fairlocation.*','opos_locationterminal.terminal_id')->
				join('fairlocation','opos_locationterminal.location_id','=','fairlocation.id')->
				where('opos_locationterminal.terminal_id',$receiptInfo->terminal_id)->first();
	        $key=DB::table("opos_lockerkeytxnref")->
				join("opos_lockerkeytxn","opos_lockerkeytxn.id","=","opos_lockerkeytxnref.lockerkeytxn_id")->
				join("opos_ftype","opos_ftype.id","=","opos_lockerkeytxn.lockerkey_ftype_id")->
				where("opos_lockerkeytxnref.receipt_id",$receiptInfo->id)->
	            select("opos_ftype.*")
	            ->get();

	        // $keys =array();
	        // foreach ($key as $value) {
	        //    $keys[] = $value->fnumber;
	        // }

	        // $keys=implode(",",$keys);

            // dd($key);
		}
		if (!empty($location)) {
        $company=DB::table("company")
			->join("fairlocation","fairlocation.user_id","=","company.owner_user_id")
			->join("merchant","merchant.user_id","=","company.owner_user_id")
			->join("address","address.id","=","merchant.address_id")
			->leftjoin("address as address2","address2.id","=","fairlocation.address_id")
			->select(
				DB::raw("IF(fairlocation.address_preference = 'branch', address2.line1, address.line1) as line1"),
				DB::raw("IF(fairlocation.address_preference = 'branch', address2.line2, address.line2) as line2"),
				DB::raw("IF(fairlocation.address_preference = 'branch', address2.line3, address.line3) as line3"),
				DB::raw("IF(fairlocation.address_preference = 'branch', address2.line4, address.line4) as line4"),
				'company.dispname',
				'merchant.gst','merchant.business_reg_no'
			 )
			->where("fairlocation.id",$location->id)
			->first();
		}
        
        $bfunction="";
        
        $terminal=DB::table("opos_terminal")->
				where("id",$receiptInfo->terminal_id)->
				whereNull("deleted_at")->
				first();
		$is_eod=$this->is_eod($receiptInfo->terminal_id);
		$bfunction=$terminal->bfunction;
		$localLogo=$terminal->local_logo;
		$show_sst_no=$terminal->show_sst_no;

		if (!empty($company)) {
			/*If terminal has a local addres*/
			if (!empty($terminal->address_id)) {
				$address=DB::table("address")
				->where('id',$terminal->address_id)
				->first();
				if (!empty($address)) {
					# code...
					$company->line1=$address->line1;
					$company->line2=$address->line2;
					$company->line3=$address->line3;

				}
			}
			
		}
       
        $user_id=Auth::user()->id;
        $service_tax=$receiptInfo->service_tax;
        if (empty($service_tax)) {
        	# code...
        	$service_tax=0;
        }
 		$service_per=DB::table('opos_servicecharge')->where('id',$receiptInfo->servicecharge_id)->pluck('value');   
 		if ($receiptInfo->mode=="inclusive") {
 			$service_per=0;
 			$receiptInfo->service_tax=0;             	# code...
 		}             
        return view('seller.opossum_document.opossumreceiptproducts',$data)->
			with('receiptInfo',$receiptInfo)->
			with('location',$location)->
			with('company',$company)->
			with("key",$key)->
			with("service_per",$service_per)->
            with("bfunction",$bfunction)
            ->with("relatedReceipt",$relatedReceipt)
            ->with('service_tax_per',$service_tax)
            ->with('localLogo',$localLogo)
            ->with('show_sst_no',$show_sst_no)
            ->with('mode',$mode)
            ->with('is_eod',$is_eod)
            ;
    }


    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function product(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure1";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        /*if (empty($r->ref_no)) {
            # code...
            $ret["error"]="No ref_no";
            return response()->json($ret);
        }*/
        try{
            switch ($r->action) {
                case 'save':
                    return $this->save_product($r);
                    break;
                case 'update':
                    return $this->update_product($r);
                    break;
                case 'delete':
                    return $this->delete_product($r);
                    # code...
                    break;
                case 'update_discount':
                    # code...
                    return $this->update_discount($r);
                    break;
                case 'update_servicecharge':
                	return $this->update_servicecharge($r);
                	# code...
                	break;
                case 'fetch_servicecharge':
                	# code...
                	return $this->fetch_servicecharge($r);
                	break;
                case 'set_servicecharge':
                	return $this->set_servicecharge($r);
                	break;
                default:
                    # code...
                    break;
            }
        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".
				$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function set_servicecharge(Request $r,$uid=NULL)
    {
    	$ret=array();
    	$ret["status"]="failure";
    	if(!Auth::check()){return "";}
    	$user_id=Auth::user()->id;
    	if(!empty($uid) and Auth::user()->hasRole("adm")){
    		$user_id=$uid;
    	}
    	try{
    		$table="opos_terminal";
    		$data=DB::table($table)
    		->where($table.".id",$r->terminal_id)		
    		->whereNull($table.".deleted_at")
    		->update([
    				"servicecharge_id"=>$r->servicecharge_id,
    				"updated_at"=>Carbon::now()
    			]);
    
    		
    		$ret["status"]="success";
    		$ret["active_servicecharge_id"]=$r->servicecharge_id;
    	}
    	catch(\Exception $e){
    		$ret["short_message"]=$e->getMessage();
    		Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    	}
    	return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function fetch_servicecharge(Request $r,$uid=NULL)
    {
    	$ret=array();
    	$ret["status"]="failure";
    	if(!Auth::check()){return "";}
    	$user_id=Auth::user()->id;
    	if(!empty($uid) and Auth::user()->hasRole("adm")){
    		$user_id=$uid;
    	}
    	try{
    		$terminal_id=$r->terminal_id;
    		$table="opos_terminal";
    		$active_servicecharge_id=DB::table($table)
    		->where($table.".id",$terminal_id)		
    		->whereNull($table.".deleted_at")
    		->orderBy($table.".created_at","DESC")
    		->pluck("servicecharge_id");
    		
    		$data=DB::table("opos_servicecharge")
    		->whereNull("deleted_at")
    		->get();

    		$servicecharge=DB::table("opos_servicecharge")
    		->where("id",$active_servicecharge_id)
    		->pluck("value");
    		$ret["status"]="success";
    		$ret["data"]=$data;
    		$ret["active_servicecharge_id"]=$active_servicecharge_id;
    		$ret["servicecharge"]=$servicecharge;
    	}
    	catch(\Exception $e){
    		$ret["short_message"]=$e->getMessage();
    		Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    	}
    	return response()->json($ret);
    }
    
     //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function update_servicecharge(Request $r,$uid=NULL)
    {
		Log::info('***** update_servicecharge() *****');
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $receipt_id=$r->receipt_id;
            $discount_id=$r->servicecharge_id;
            /*Check discount*/
            $servicecharge_pct=DB::table("opos_servicecharge")
            ->where("id",$servicecharge_id)
            ->whereNull("deleted_at")
            ->pluck("value");
            if (empty($servicecharge_pct)) {
            	$ret["short_message"]="Servicecharge does not exists";
            	return response()->json($ret);
            }
            $products=$r->product_ids;

            $mode=$r->mode;
	
			if ($mode=="all") {
				DB::table("opos_receiptproduct")->
					where("receipt_id",$receipt_id)->
					update([
						"servicecharge_id"=>$servicecharge_id,
						"servicecharge"=>$servicecharge_pct,
						
						"updated_at"=>Carbon::now()
					]);	
			}else{
				foreach ($products as $product_id) {
					DB::table("opos_receiptproduct")->
					where("receipt_id",$receipt_id)->
					where("product_id",$product_id)->
					update([
						"servicecharge_id"=>$servicecharge_id,
						"servicecharge"=>$servicecharge_pct,
						
						"updated_at"=>Carbon::now()
					]);	
				}
			}

          
            $ret["data"]=$servicecharge_pct;
            $ret["status"]="success";

        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function update_discount(Request $r,$uid=NULL)
    {
		Log::info('***** update_discount() *****');
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $receipt_id=$r->receipt_id;
            $discount_id=$r->discount_id;
            /*Check discount*/
            $discount_pct=DB::table("opos_discount")
            ->where("id",$discount_id)
            ->whereNull("deleted_at")
            ->pluck("value");
            if (empty($discount_pct)) {
            	$ret["short_message"]="Discount does not exists";
            	return response()->json($ret);
            }
            $products=$r->product_ids;

            $mode=$r->mode;
	
			if ($mode=="all") {
				DB::table("opos_receiptproduct")->
					where("receipt_id",$receipt_id)->
					update([
						"discount_id"=>$discount_id,
						"discount"=>$discount_pct,
						
						"updated_at"=>Carbon::now()
					]);	
			}else{
				foreach ($products as $product_id) {
					DB::table("opos_receiptproduct")->
					where("receipt_id",$receipt_id)->
					where("product_id",$product_id)->
					update([
						"discount_id"=>$discount_id,
						"discount"=>$discount_pct,
						
						"updated_at"=>Carbon::now()
					]);	
				}
			}

          
            $ret["data"]=$discount_pct;
            $ret["status"]="success";

        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    


    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function delete_product(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            DB::table("opos_lockerkeyproducts")
	            ->where("product_id","=",$r->product_id)
	            ->where("lockerkey_id","=",$r->lockerkey_id)
	            ->delete();

            $table="opos_receiptproduct";

            if($r->bundletype == "bundle")
            {
            	$data=DB::table($table)
			            ->where($table.".receipt_id",$r->receipt_id)  
			            ->where("bundle_id",$r->product_id)      
			            ->whereNull($table.".deleted_at")
			            ->update([
			                "deleted_at"=>Carbon::now()
			            ]);
            }
            else
            {
            	$data=DB::table($table)
		            	 ->where($table.".receipt_id",$r->receipt_id)  
			             ->where("product_id",$r->product_id)      
			             ->whereNull($table.".deleted_at")
			             ->update([
			                "deleted_at"=>Carbon::now()
			             ]);
            }
            
            /*Rollback*/
           // DB::table("locationproduct");
            $ret["status"]="success";
            $ret["data"]=$data;

        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".
				$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function pettycash(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{

        
            /******************/
            $op=explode(".",$r->amount);
        
            try {
                $int=$op[0];
            } catch (\Exception $e) {
                $int="00";
            }
            try {
                $dec=$op[1];
            } catch (\Exception $e) {
                $dec="00";
            }
            /*Need to lookout for .
                if 13.5
                13*100 + 5*10
                13.100
                if 13.51

            */ 
            if (strlen($dec)==1) {
                $dec=(int)($dec)*10;
            }else{
                $dec=(int)($dec);
            }
            $amount=(int)$int*100+$dec;
            /*Validation*/
            $terminal=$r->terminal_id;
            $validation_query="
                SELECT 
                SUM(CASE 
                WHEN mode='in' THEN amount
                ELSE -amount
                END)as diff
                FROM 
                opos_pettycash
                WHERE
                terminal_id=$terminal
                AND deleted_at IS NULL

            ";
            $validation=DB::select(DB::raw($validation_query));
            $balance=(int)$validation[0]->diff;

            Log::debug($balance);
            Log::debug($amount);
            if ($balance <$amount and $r->mode=="out") {
                $ret['short_message']="Out amount is more than available balance";
                return response()->json($ret);
            }
            $to_insertpettycash=[
                "staff_user_id"=>$user_id,
                "amount"=>$amount,
                "pcreason_id"=>$r->pcreason_id,
                "mode"=>$r->mode,
                "terminal_id"=>$r->terminal_id,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $table="opos_pettycash";
            
            $data=DB::table($table)
            ->insert($to_insertpettycash);
    /*\App\Models\OposCashMgmtLedger::insert([
        "terminal_id"=>$r->terminal_id,
        "pcreason_id"=>$r->pcreason_id,
        "location_id"=>$r->location_id,
       "amount"=>$amount 
    ]);*/
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function update_product($r,$uid=NULL)
    {
        $ret=array();
        
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_receiptproduct";

            if(!empty($r->lockerkey_id)){
                DB::table("opos_lockerkeyproducts")
                ->where("product_id","=",$r->product_id)
                ->where("lockerkey_id","=",$r->lockerkey_id)
                ->delete();
                DB::table("opos_lockerkeyproducts")
                ->insert([
                    "quantity"=>$r->quantity,
                "product_id"=>$r->product_id,
                "lockerkey_id"=>$r->lockerkey_id,
                "receipt_id"=>$r->receipt_id,
                        ]);
        }

            $price = $r->price;
			$actual_discounted_amt = $price - $r->discount;
            Log::debug("reached distination");
			Log::debug('product_id='.$r->product_id);
            Log::debug('quantity='.$r->quantity);
			Log::debug('price='.$price);
			Log::debug('discountpct='.$r->discountpct);
			Log::debug('discount='.$r->discount);
			Log::debug('discount_id='.$r->discount_id);
			Log::debug('actual_discounted_amt='.$actual_discounted_amt);
        
            $update_data=[
                "updated_at"=>Carbon::now(),
                "quantity"=>$r->quantity,
                "price"=>$price * 100,
                "discount"=>$r->discountpct,
                "discount_id"=>$r->discount_id,
                "actual_discounted_amt"=>$actual_discounted_amt * 100
            ];

            /*LOCATION PRODUCT LOGIC */
            $receipt=DB::table("opos_receipt")
			            ->where("id",$r->receipt_id)
			            ->whereNull("deleted_at")
			            ->first();
            
            if (empty($receipt)) {
                return response()->json($ret);
            }

            /*Get location_id*/
            $terminal=DB::table("opos_locationterminal")
			            ->where("terminal_id",$receipt->terminal_id)
			            ->orderBy("id","DESC")
			            ->first();
            if (empty($terminal)) {
                return response()->json($ret);
            }
            $location_id=$terminal->location_id;
            Log::debug("Update Location ID ".$terminal->location_id);

            if($r->bundletype == "bundle")
        	{
	            $record=DB::table($table)
	                ->where("bundle_id",$r->product_id)
	                ->where("receipt_id",$r->receipt_id)
	                ->whereNull("deleted_at")
	                ->first();
	        }
	        else
	        {
	        	 $record=DB::table($table)
	                ->where("product_id",$r->product_id)
	                ->where("receipt_id",$r->receipt_id)
	                ->whereNull("deleted_at")
	                ->first();
	        }
               
            if (empty($record)) {
                return response()->json($ret);
            }
            $old_quantity=$record->quantity;
            $new_quantity=$r->quantity;
            $diff_quantity=$new_quantity-$old_quantity;
            $action="minus";

            if ($new_quantity<$old_quantity) {
                # Subtract the Difference
                $diff_quantity=$old_quantity-$new_quantity;
                $action="add";
            }
            /*ENDS*/
            if($r->bundletype == "bundle")
        	{
	            $d=DB::table($table)
					->where("bundle_id",$r->product_id)
					->where("receipt_id",$r->receipt_id)
	                ->update($update_data);
	        }
	        else
	        {
	        	$d=DB::table($table)
					->where("product_id",$r->product_id)
					->where("receipt_id",$r->receipt_id)
	                ->update($update_data);
	        }  
            
            if($r->bundletype != "bundle")
            {
            	 $product=DB::table("product")
			            ->where("id",$r->product_id)
			            ->first();
			            if ($product->type!="service") {
			                # code...
			                Log::debug("update parameter passed");
			                Log::debug([$location_id,$r->product_id,$diff_quantity,$action]);
			                UtilityController::locationproduct($location_id,$r->product_id,$diff_quantity,$action); 
			            }
            } 
           
                 
			Log::debug('product_id='.$r->product_id);
			Log::debug('receipt_id='.$r->receipt_id);
            
            $ret["status"]="success";
            $ret["data"]=[$r->receipt_id];
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function save_product($r,$uid=NULL)
    {
    	// echo "in save"; die();
        $ret=array();
        $ret["short_message"]="--";
        $ret["status"]="failure";
        try{
                Log::debug("locker key id".json_encode($r->all()));
            if(!empty($r->lockerkey_id)){
                
                DB::table("opos_lockerkeyproducts")
                ->where("product_id","=",$r->product_id)
                ->where("lockerkey_id","=",$r->lockerkey_id)
                ->delete();

                DB::table("opos_lockerkeyproducts")
                ->insert([
                    "quantity"=>$r->quantity,
                "product_id"=>$r->product_id,
                "lockerkey_id"=>$r->lockerkey_id,
                "receipt_id"=>$r->receipt_id
                ]);
        }
			$price = $r->price;
			$receipt_id = $r->receipt_id;
            Log::debug("save product receipt_id: ".$receipt_id);
           
            Log::debug("save product price: ".$price);
            Log::debug("save product actual_discounted_amt: ".$r->discount);

            $table="opos_receiptproduct";
            /*Get Discount*/
            $first_record=DB::table($table)->where("receipt_id",$r->receipt_id)
            ->whereNull("deleted_at")->orderBy("id","ASC")
            ->first();
            $discount="0.00";
            if (!empty($first_record)) {
                # code...
                $discount=$first_record->discount;
            }
             $receipt=DB::table("opos_receipt")
            ->where("id",$r->receipt_id)
            ->whereNull("deleted_at")
            ->first();

            if (empty($receipt)) {
            	$ret["short_message"]="Incorrect Receipt";
                return response()->json($ret);
            }
            /*validate service charge*/
            $servicecharge_id=$r->servicecharge_id;
            $servicecharge_pct=DB::table("opos_servicecharge")
            ->whereNull("deleted_at")
            ->where("id",$servicecharge_id)
            ->pluck("value");
            if (empty($servicecharge_pct)) {
            	# code...
            	$servicecharge_pct=0;
            }
            /*Get location_id*/
            $terminal=DB::table("opos_locationterminal")
            ->where("terminal_id",$receipt->terminal_id)
            ->orderBy("id","DESC")
            ->first();
            if (empty($terminal)) {
            	$ret["short_message"]="Empty Terminal";
                return response()->json($ret);
            }
            $location_id=$terminal->location_id;
            Log::debug("Save Location ID ".$terminal->location_id);
            $discount_pct_float=floatval($discount);

            $actual_discounted_amt=(int)($discount_pct_float*$price)/100;

            if($r->bundletype == "bundle")
            {
            	$insert_data=[
	                "receipt_id"=>$receipt_id,
	                "product_id"=> null,
	                "bundle_id" => $r->product_id,
	                "quantity"=>$r->quantity,
	                "price"=>$price,
	                "actual_discounted_amt"=>$actual_discounted_amt,
	                "discount"=>$discount,
	                "servicecharge_id"=>$servicecharge_id,
	                "servicecharge"=>$servicecharge_pct,
	                "created_at"=>Carbon::now(),
	                "updated_at"=>Carbon::now()
            	];
            }
            else
            {
            	 $insert_data=[
	                "receipt_id"=>$receipt_id,
	                "product_id"=>$r->product_id,
	                "quantity"=>$r->quantity,
	                "price"=>$price,
	                "actual_discounted_amt"=>$actual_discounted_amt,
	                "discount"=>$discount,
	                "servicecharge_id"=>$servicecharge_id,
	                "servicecharge"=>$servicecharge_pct,
	                "created_at"=>Carbon::now(),
	                "updated_at"=>Carbon::now()
	            ];
            }
           

            $data=DB::table($table)->insertgetId($insert_data);
			Log::debug('***** Inserted product to opos_receiptproduct *****');
			Log::info(json_encode($data));

			if($r->bundletype != "bundle")
			{
				$product=DB::table("product")
	            ->where("id",$r->product_id)
	            ->first();
	            if ($product->type!="service") {
	                # code...
	                UtilityController::locationproduct($location_id,$r->product_id,$r->quantity,"minus"); 
	            }
	            // save data in opos_receiptvoucher if product type is voucher or otcvoucher
	            if($product->type == "voucher" || $product->type == "otcvoucher")
	            {
	            	$v_data = DB::table('voucher')->select('id')->where('product_id',$r->product_id)->first();
	            	if(count($v_data) > 0)
	            	{
	            		$voucherdata = DB::table('opos_receiptvoucher')
		            					 ->insert([
		            					  		"receipt_id" => $r->receipt_id,
							            	 	"voucher_id" => $v_data->id,			                
								                "created_at" => Carbon::now(),
								                "updated_at" => Carbon::now()
		            					  ]);
		            	
				    	// if(Auth::user()->hasRole("byr")){
				    	// 	$user_id=Auth::user()->id;
				    	// }
		       //      	$savevoucherbuyer = DB::table('voucherbuyer')
		       //      					 ->insert([
		       //      					  		"buyer_id" => $user_id,
							  //           	 	"voucher_id" => $v_data->id,
							  //           	 	"v_left" => $v_data->package_qty,
							  //           	 	"status" => "active",
								 //                "created_at" => Carbon::now(),
								 //                "updated_at" => Carbon::now()
		       //      					  ]);
	            	}
			    }
			}
           
            $ret["status"]="success";
            $ret["data"]=$data;
        }

        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function transaction(Request $r,$action,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }

        try{
               
            




           switch ($action) {
               case 'start':
                   return $this->start_transaction($r,$user_id);
                   break;
               case 'end':
                   # code...
                    return $this->end_transaction($r,$user_id);
                   break;
                case 'delete':
                    # code...
                    break;
                case 'linkroom':
                    return $this->linkroom($r,$user_id);
                    # code...
                    break;
                case 'payment':
                    # code...
                    //Will return data for receipt.
                    return $this->handle_payment($r);
                    break;
                case 'sparoom_checkout':
                    return $this->sparoom_checkout($r);
                    # code...
                    break;
                case 'lockerkey_checkout':

                    return $this->lockerkey_checkout($r);
                    # code...
                    break;
                case 'linkedproducts':
                    return $this->linkedproducts($r);
                    # code...
                    break;
                case 'records':
                    # code...
                    return $this->transaction_records($r);
                    break;
                case 'pettycash':
                    return $this->pettycash($r,$user_id);
                    # code...
                    break;
                case 'receiptvoid':
                    # code...
                    return $this->receiptvoid($r);
                case 'starthotelroom':
                    # code...
                    return $this->starthotelroom($r);
                    break;
                case 'hotelroom_checkout':
                    # code...
                    return $this->hotelroom_checkout($r);
                    break;
                case 'stockreport':
                    return $this->do_stockreport($r);
                    break;
                case 'create_receipt':
                    return $this->create_receipt($r,$user_id);
                    break;
               default:
                   # code...
                   break;
           }
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }





    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function receiptvoid(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_receipt";
			$data=DB::table($table)
			->select("*")
			->where("id","=",$r->receipt_id)
			->first();
// $data=DB::table($table)
//             ->where($table.".id",$r->receipt_id)
//             ->whereNull("opos_receipt.deleted_at")
//             ->update([
//                 "status"=>"voided",
//                 "updated_at"=>Carbon::now()
//             ]);
//             $this->handle_inventory($r,"add");
			if (empty($data)) {
				return "Invalid receipt";
			}
			$receiptproducts=DB::table("opos_receiptproduct")
			->select("*")
			->where("opos_receiptproduct.receipt_id","=",$r->receipt_id)
			->get();
			foreach ($receiptproducts as $key => $ReceiptSingleProducts) {
				$voided_receiptproduct=Carbon::now();
				$receiptReceiptSingleProducts_update=[
					"status"=>"voided",
					"updated_at"=>$voided_receiptproduct,
				];

				DB::table('opos_receiptproduct')
				->where("opos_receiptproduct.receipt_id","=",$ReceiptSingleProducts->id)
				->update($receiptReceiptSingleProducts_update);		

			}
			$voided_at=Carbon::now();
			$receipt_update=[
			"status"=>"voided",
			"voided_at"=>$voided_at,
			"remark" => $r->remark

			];

			DB::table($table)->where("id",$data->id)->update($receipt_update);			          
    /*        $data->status="voided";
            $data->created_at=date("Y-m-d H:i:s");
            $data->updated_at=date("Y-m-d H:i:s");
            $data->cash_received=-($data->cash_received);
            $receipt_insert_id=DB::table($table)->insertGetId((array)$data);*/
           /* foreach($receiptproducts as $receiptproduct){
                $receiptproduct->id="";
                $receiptproduct->updated_at=date("Y-m-d H:i:s");
                $receiptproduct->created_at=date("Y-m-d H:i:s");
                $receiptproduct->receipt_id=$receipt_insert_id;
                DB::table("opos_receiptproduct")
                ->insert((array)$receiptproduct);
            }
		
			    */               
            
           $this->handle_inventory($r,"add");
            $ret["status"]="success";
            $ret["data"]=UtilityController::s_date($voided_at);
        }
        catch(\Exception $e){
             $ret["short_message"]=$e->getMessage();
//exit;

            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
       return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function transaction_records(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $dataquery="
            SELECT
            olt.checkin_tstamp,
            olkt.ref_no,
            olt.lockerkey_ftype_id as ftype_id,
            opr.id as receipt_id,
            'lockerkey' as ftype,
            olt.id as txn_id

            FROM 
            opos_receipt opr
            JOIN opos_lockerkeytxnref olkt on olkt.receipt_id=opr.id
            JOIN (SELECT * from opos_lockerkeytxn 
            WHERE deleted_at IS NULL AND checkout_tstamp IS NULL
            AND checkin_tstamp IS NOT NULL

            )olt on olt.id=olkt.lockerkeytxn_id
            WHERE 
            opr.deleted_at IS NULL


            ";
            $data=DB::select(DB::raw($dataquery));
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function linkedproducts(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        $data=[];
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_lockerkeytxn";
            $txn=DB::table($table)
				->where($table.".lockerkey_ftype_id",$r->ftype_id)        
				->whereNull($table.".deleted_at")
                //->whereNull($table.".checkout_tstamp")
				->orderBy($table.".created_at","DESC")
				->first();
			

            if (empty($txn)) {
                $ret["status"]="success";
                $ret["data"]=$data;
                return response()->json($ret);
            }

            $receipt_id=DB::table("opos_lockerkeytxnref")
				->where("lockerkeytxn_id",$txn->id)
				->whereNull("deleted_at")
				->orderBy("created_at","DESC")
				->pluck("receipt_id");
			

            /*$receipt=DB::table("opos_receipt")
                ->where("ref_no",$ref_no)
                ->whereNull("deleted_at")
                ->first();
            $receipt_id=$r->receipt_id;*/
			Log::debug('receipt_id='.json_encode($receipt_id));

			/* receipt_id will be null if products have not been selected */
			if (!empty($receipt_id)) {
				$query="
					SELECT 
					p.id as product_id,
					p.name,
					p.thumb_photo,
					rp.quantity,
					rp.price,
                    rp.discount,
					rp.actual_discounted_amt as discount_amt
					-- (CASE 
					--	WHEN rp.actual_discounted_amt IS NOT NULL
					--	THEN ROUND(((rp.actual_discounted_amt/rp.price)*100),2)
					--	ELSE 0.00
					-- END) as discount

					FROM opos_receiptproduct rp
					JOIN opos_receipt r on r.id=rp.receipt_id
					JOIN opos_lockerkeytxnref okf on okf.receipt_id =r.id
					JOIN opos_lockerkeytxn ol on okf.lockerkeytxn_id=ol.id
					JOIN product p on p.id=rp.product_id

					WHERE rp.deleted_at IS NULL and r.status = 'active'
					AND p.deleted_at IS NULL
					AND rp.receipt_id=$receipt_id 
					-- AND ol.checkout_tstamp IS NULL
					-- AND ol.checkin_tstamp IS NOT NULL
					AND ol.deleted_at IS NULL
				";

				$data=DB::select(DB::raw($query));
                                Log::info("json request value ".json_encode($r->all()));
                                
                                
				Log::info(json_encode($data));
                                
				$ret["status"]="success";
				$ret["data"]=$data;
                $ret["products"]= $this->getLockerKeyDataById($r->lockerkey_id);
                //$ret['receipt']=$receipt;

			} else {
				Log::debug('$receipt_id = NULL!');

				$ret["status"]="error";
				$ret["data"]="no product";
			}

        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }


    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function handle_payment($r,$uid=NULL)
    {

       
       $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_receipt";
            $payment_type="cash";
            if (!empty($r->creditcard_no) && $r->creditcard_no!=0 && $r->creditcard_no!="0" ) {
                # code...
                $payment_type="creditcard";
            }
		

            $receipt=DB::table('opos_receipt')->where("id",$r->receipt_id)->first();
           	
            if (empty($receipt)) {
                $ret["short_message"]="Receipt is not valid";
                return response()->json($ret);
            }
            /*Cash*/
            //$cash_received=UtilityController::cast($r->cash_received);
            $cash_received=$r->cash_received;
            $receipt_no=$this->receipt_no($r);
                
            $servicecharge_id=DB::table("opos_servicecharge")
            ->select("id")
            ->where("value","=",!empty($r->service_charges)?$r->service_charges:0)
            ->first();
            $servicecharge_id=!empty($servicecharge_id->id)?$servicecharge_id->id:"";

            $update_data=[
                "terminal_id"=>$r->terminal_id,
                "updated_at"=>Carbon::now(),
                "receipt_no"=>$receipt_no,
                'cash_received'=>$cash_received,
                'cash_10k'=>$r->cash_10000,
                'cash_1k'=>$r->cash_1000,
                'cash_100'=>$r->cash_100,
                'cash_50'=>$r->cash_50,
		        'cash_20'=>$r->cash_20,
                'cash_10'=>$r->cash_10,
                'cash_5'=>$r->cash_5,
                'cash_2'=>$r->cash_2,
                'cash_1'=>$r->cash_1,
                'cents_1'=>$r->cents_1,
                'cents_5'=>$r->cents_5,
                'cents_10'=>$r->cents_10,
                'cents_20'=>$r->cents_20,
                'cents_50'=>$r->cents_50,
                'creditcard_no'=>$r->creditcard_no,
                'payment_type'=>$payment_type,
                "servicecharge_id"=>$servicecharge_id,
                'otherpoints'=>$r->other_points,
                'mode'=>$r->mode,
                'points'=>'other',
                'otherpoints_remark'=>$r->otherpoint_remark,
                'service_tax'=>$r->service_tax,
                'round'=>$r->round,
                'status'=>'completed'
            ];
            // echo '<pre>'; print_r($update_data);

    	 $data=DB::table($table)
	            ->where("{$table}.id","=",$r->receipt_id)
	            ->update($update_data);

         // echo '<pre>'; print_r($data); die();
            /*SalesLog block*/
     		$saleslog_ids=DB::table("opos_receiptproduct")
     		->join("opos_receiptproductsaleslog","opos_receiptproductsaleslog.receiptproduct_id","=","opos_receiptproduct.id")
     		->where("opos_receiptproduct.receipt_id",$r->receipt_id)
     		
     		->select("opos_receiptproductsaleslog.saleslog_id")
     		->get();

     		foreach ($saleslog_ids as $s) {
     			# code...

     			if (!empty($s->saleslog_id)) {
     				DB::table("opos_saleslog")
     				->where("id",$s->saleslog_id)
     				->update([
     					"status"=>"completed",
     					"updated_at"=>Carbon::now()
     				]);
     			}
     		}

			Log::debug('***** Update data *****');
			Log::debug($update_data);
            $ret["status"]="success";
            $ret["data"]=$data;

        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function linkroom($r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $ftype=DB::table("opos_ftype")
            ->where("id",$r->id)->first();
            $checkin_tstamp=Carbon::now();
            $insert_data=[
            "lockerkey_ftype_id"=>$r->lockerkey_id,
            "sparoom_ftype_id"=>$ftype->id,
            "sparoom_checkin"=>$checkin_tstamp,
            "updated_at"=>Carbon::now(),
            "created_at"=>Carbon::now()
            ];
            $txn_id=DB::table("opos_lockerkeytxnsparoom")
            ->insertgetId($insert_data);
            $ret["status"]="success";
            $data=[
                "checkin_tstamp"=>$checkin_tstamp,
                

                "ftype_id"=>$r->id,
                "ftype"=>$ftype,
                "txn_id"=>$txn_id
            ];
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function lockerkey_checkout(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_lockerkeytxn";

            $update_data=[
                "checkout_tstamp"=>Carbon::now(),
                "updated_at"=>Carbon::now()

            ];
            
            
           /* $is_transact=DB::table("opos_lockerkeytxn")
            ->where("lockerkey_ftype_id",$r->ftype_id)
            ->whereNull("checkout_tstamp")
            ->whereNull("deleted_at")
            ->first();
           */
            
           
            /*Log::debug(["Locker key Txn : "=>$is_transact]);
*/            /*if(!empty($is_transact)){
                $is_lockerkeytxnref=DB::table("opos_lockerkeytxnref")
                        ->where("lockerkeytxn_id",$is_transact->id)
                        ->first();

                if(!empty($is_lockerkeytxnref)){
                    $is_receipt=DB::table("opos_receipt")
                    ->where("id",$is_lockerkeytxnref->receipt_id)
                    ->first();
                    if(!empty($is_receipt)){

                      //  DB::table('opos_receiptproduct')->where('receipt_id', $is_receipt->id)->delete();
                        DB::table('opos_save')->where('receipt_id', $is_receipt->id)->delete();
                    }
                }
            }
            */
            /*Temporary change. ftype_id for checkout is transaction id*/
            /*return $r->ftype_id;*/
            if (!empty($r->ftype_id)) {
            	# code...
            	$id=$r->ftype_id;
            	DB::table("opos_lockerkeytxn")->where("id",$id)->update([
            		"updated_at"=>Carbon::now(),
            		"checkout_tstamp"=>Carbon::now()
            	]);
            	return $id;
            	
            }
            return "ok";
            return response()->json(["status"=>"success"]);
            $data=DB::table($table)
            ->where($table.".lockerkey_ftype_id",$r->ftype_id)        
            ->whereNull($table.".deleted_at")
            ->whereNull($table.".checkout_tstamp")
            ->update($update_data);

            if(!empty($r->lockerkey_id)){
                DB::table("opos_lockerkeyproducts")
                        ->where("lockerkey_id","=",$r->lockerkey_id)
                        ->delete();
                    $data= DB::table("opos_lockerkeytxn")
            ->leftjoin("opos_ftype","opos_ftype.id","=","opos_lockerkeytxn.lockerkey_ftype_id")
            ->where("opos_ftype.fnumber","=",$r->lockerkey_id)
            ->whereNull("opos_lockerkeytxn.checkout_tstamp")
            ->update(["opos_lockerkeytxn.checkout_tstamp"=>date("d-m-Y H:s:i")]);

            }
            
            
            $ret["status"]="success";
            $ret["data"]=$data;
            
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    public function hotelroom_checkout(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_hotelroomtxn";

            $update_data=[
                "checkout_tstamp"=>Carbon::now(),
                "updated_at"=>Carbon::now()

            ];
            Log::debug($r->ftype_id);
            $data=DB::table($table)
            ->where($table.".hotelroom_ftype_id",$r->ftype_id)        
            ->whereNull($table.".deleted_at")
            ->whereNull($table.".checkout_tstamp")
            ->update($update_data);
    
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function sparoom_checkout(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_lockerkeytxnsparoom";
            $update_data=[
                "sparoom_checkout"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $data=DB::table($table)
            ->where($table.".id",$r->ftype_id)

            ->whereNull($table.".deleted_at")

            ->whereNull($table.".sparoom_checkout")
            ->update($update_data);
    
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function quantity_validation(Request $r,$uid=NULL)
    {
    	$ret=array();
    	
    	try{
    		$location_id=DB::table("opos_locationterminal")
            ->where("terminal_id",$r->terminal_id)
          /*  ->whereNull("deleted_at")*/
            ->pluck("location_id");
            $table="opos_receiptproduct";

            $rps=DB::table($table)
            ->where($table.".receipt_id",$r->receipt_id)      
            ->whereNull($table.".deleted_at")
            ->orderBy($table.".created_at","DESC")
            ->get();

    		$action="validate";
            foreach ($rps as $r) {
                # code...
                if($r->product_id == null) continue;
                $is_valid=UtilityController::locationproduct($location_id,$r->product_id,$r->quantity,$action);
                Log::info("is_valid ".$is_valid);
                if ($is_valid==-1) {
                	array_push($ret,$r->product_id);
                }
            }
    	}
    	catch(\Exception $e){
    		
    		Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    	}
    	return $ret;
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function end_transaction(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }

        try{

            
            
          	Log::info(json_encode(["request data"=>$r->all()]));
        	$array_of_failed_pids=$this->quantity_validation($r);
            Log::info($array_of_failed_pids);
            Log::info("locker key id".$r->lockerkey_id);
        	if (!empty($array_of_failed_pids)) {
    	//echo '<pre>'; print_r($array_of_failed_pids); die();
        		$ret["product_ids"]=$array_of_failed_pids;
        		return response()->json($ret);
        	}
           	$this->sparoom_checkout($r);
            $this->lockerkey_checkout($r);
            $this->handle_inventory($r);
            $this->handle_payment($r);
                        
            $ret["status"]="success";
            $ret["data"]=$r->ftype_id;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::debug("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function handle_inventory(Request $r,$action="minus",$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
        	$receipt=DB::table("opos_receipt")
        	->where("id",$r->receipt_id)
        	->first();
        	if (empty($receipt)) {
        		# code...
        		return;
        	}
        	if ($r->has('terminal_id')) {
        		$terminal_id=$r->terminal_id;
        	}elseif (!$r->has('terminal_id')&& $r->has('receipt_id')) {
        		$terminal_id=$receipt->terminal_id;
        	}
        	Log::debug("terminal_id ".$terminal_id);
        	$location_id=DB::table("opos_locationterminal")
	            ->where("terminal_id",$terminal_id)
	          /*  ->whereNull("deleted_at")*/
	            ->pluck("location_id");
            
            $table="opos_receiptproduct";
            $rps=DB::table($table)
            ->where($table.".receipt_id",$r->receipt_id)      
            ->whereNull($table.".deleted_at")
            ->orderBy($table.".created_at","DESC")
            ->get();
    
            foreach ($rps as $r) {
                # code...
                Log::debug("Receipt Void parameter passed");
                Log::debug([$location_id,$r->product_id,$r->quantity,$action]);
                UtilityController::locationproduct($location_id,$r->product_id,$r->quantity,$action);
            }
            $ret["status"]="success";
            $ret["data"]="success";
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function create_receipt(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $insert_data=[
                "ref_no"=>$r->ref_no,
                "terminal_id"=>$r->terminal_id,
                "staff_user_id"=>$user_id,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $table="opos_receipt";
            $receipt_id=DB::table($table)
            ->insertgetId($insert_data);
    
            
            $ret["status"]="success";
            $ret["receipt_id"]=$receipt_id;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function start_transaction(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{

            $checkin_tstamp=Carbon::now();
            $ftype=DB::table("opos_ftype")->where("id",$r->id)->first();
            if (empty($ftype)) {
                # code...
                return "";
            }
            $receipt_id=$r->receipt_id;
            if (empty($receipt_id)) {
            	# code...
            	return "";
            }
            /*Check if a transaction is already happening*/
            /*$is_transact=DB::table("opos_lockerkeytxn")
            ->where("lockerkey_ftype_id",$ftype->id)
            ->whereNull("checkout_tstamp")
            ->whereNotNull("checkin_tstamp")
            ->whereNull("deleted_at")
            ->first();
            if (!empty($is_transact)) {
                $ret["short_message"]="Transaction already in progress";
                return response()->json($ret);
            }*/
            $txn_data=[
                "lockerkey_ftype_id"=>$r->id,
                "checkin_tstamp"=>$checkin_tstamp,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $txn_id=DB::table("opos_lockerkeytxn")
            ->insertgetId($txn_data);
            $txn_ref_data=[
                "lockerkeytxn_id"=>$txn_id,
                "receipt_id"=>$receipt_id,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            DB::table("opos_lockerkeytxnref")
            ->insertgetId($txn_ref_data);
            /**/
            
            $insert_data=[
                "terminal_id"=>$r->terminal_id,
                "staff_user_id"=>$user_id,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            /*$table="opos_receipt";
            $receipt_id=DB::table($table)
            ->insertgetId($insert_data);*/
            $ret["status"]="success";
//             Log::debug(["active products ".$this->getLockerKeyDataById($r->lockerkey_id)]);

            $data=[
                "checkin_tstamp"=>$checkin_tstamp,
                "receipt_id"=>$receipt_id,
                "ftype_id"=>$r->id,
                "ftype"=>$ftype,
                "txn_id"=>$txn_id,
                "products"=>$this->getLockerKeyDataById($r->lockerkey_id)
            ];
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    public function starthotelroom(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{

            $checkin_tstamp=Carbon::now();
            $ftype=DB::table("opos_ftype")->where("id",$r->id)->first();
            if (empty($ftype)) {
                # code...
                return "";
            }
            /*Check if a transaction is already happening*/
           /* $is_transact=DB::table("opos_hotelroomtxn")
            ->where("hotelroom_ftype_id",$ftype->id)
            ->whereNull("checkout_tstamp")
            ->whereNotNull("checkin_tstamp")
            ->whereNull("deleted_at")
            ->first();
            if (!empty($is_transact)) {
                $ret["short_message"]="Transaction already in progress";
                return response()->json($ret);
            }*/
            $txn_data=[
                "hotelroom_ftype_id"=>$r->id,
                "checkin_tstamp"=>$checkin_tstamp,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $txn_id=DB::table("opos_hotelroomtxn")
            ->insertgetId($txn_data);
               
            $insert_data=[
                "ref_no"=>$r->ref_no,
                "terminal_id"=>$r->terminal_id,
                "staff_user_id"=>$user_id,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $table="opos_receipt";
            $receipt_id=DB::table($table)
            ->insertgetId($insert_data);
    
            
            $ret["status"]="success";
            $data=[
                "checkin_tstamp"=>$checkin_tstamp,
                "receipt_id"=>$receipt_id,
                "ref_no"=>$r->ref_no,
                "ftype_id"=>$r->id,
                "ftype"=>$ftype,
                "txn_id"=>$txn_id
            ];
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function support($type,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            switch ($type) {
                case 'pettycashreasons':
                    # code...
                    return $this->pettycashreasons();
                    break;
                case 'terminals':
                    # code...
                    return $this->terminals();
                    break;
                default:
                    # code...
                    break;
            }
            
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function terminals($uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }

        try{
            $query="
                SELECT
                    oplt.location_id,
                    oplt.id,
                    oplt.terminal_id,
                    f.location
                FROM 
                    opos_locationterminal oplt

                    JOIN fairlocation f on f.id=oplt.location_id
                    JOIN opos_receipt on opos_receipt.terminal_id=oplt.terminal_id


                WHERE
                    f.user_id=$user_id
                    AND f.deleted_at IS NULL
                    AND opos_receipt.status!='active'
                GROUP BY oplt.terminal_id
                    

            ";
            $data=DB::select(DB::raw($query));
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function pettycashreasons($uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_pcreason";
            $data=DB::table($table)
           /* ->where($table.".","")  */      
            ->whereNull($table.".deleted_at")
            ->orderBy($table.".name","ASC")
            ->get();
    
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    /**********************RECEIPT********************************************/

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function receipt($action="",$receipt_id,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            switch ($action) {
                case 'generate':

                    return $this->generate_receipt($receipt_id,$uid);
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function generate_receipt($receipt_id,$uid=NULL)
    {
        /*Returns JSON data for receipt*/
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $data=$this->receiptproducts($receipt_id);

            return view('modals.opossumreceipt',$data);

        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return view('common.generic');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockin(Request $r)
    {

        $user_id     = Auth::user()->id;

        if (!$r->has('terminal_id')) {
            return "Invalid Terminal ID";
        }

        $terminal_id=$r->terminal_id;
        $location_id=DB::table("opos_locationterminal")->
			where("terminal_id",$terminal_id)->
			orderBy("id","DESC")->
			pluck("location_id");

        if (empty($location_id)) {
            return "Invalid Terminal ID";
        }

        $merchant_user_id=DB::table("fairlocation")->
			where("id",$location_id)->
			pluck("user_id");

        if (empty($merchant_user_id)) {
        	return "Invalid Merchant";
        }

        $merchant = Merchant::where('user_id','=',$merchant_user_id)->first();
        $query = $merchant->products()
        ->whereNull('product.deleted_at')
        ->leftJoin('product as productb2b', function($join) {
            $join->on('product.id', '=', 'productb2b.parent_id')
            ->where('productb2b.segment','=','b2b');
        })
        ->leftJoin('product as producthyper', function($join) {
            $join->on('product.id', '=', 'producthyper.parent_id')
            ->where('producthyper.segment','=','hyper');
        })
        ->leftJoin('tproduct as tproduct', function($join) {
            $join->on('product.id', '=', 'tproduct.parent_id');
        })
        ->leftJoin('productbc','product.id','=','productbc.product_id')
        ->leftJoin('bc_management','bc_management.id','=','productbc.bc_management_id')
        ->select(DB::raw('
            product.id,
            product.parent_id,
            bc_management.id as bc_management_id,
            productbc.deleted_at as pbdeleted_at,
            product.name,
            product.thumb_photo as photo_1,
            product.available,
            productb2b.available as availableb2b,
            producthyper.available as availablehyper,
            tproduct.available as warehouse_available,
            product.sku'))
        ->groupBy('product.id')
        ->where("product.status","!=","transferred")
        ->where("product.status","!=","deleted")
        ->where("product.status","!=","")
        ->where("product.type","!=","service")
        ->orderBy('product.created_at','DESC');
           

        if ($r->has("where_in") and !empty($r->where_in)) {
            $query=$query->whereIn("product.id",$r->where_in);
        }
        $merchant_pro=$query->get();
        foreach ($merchant_pro as $product) {
            /*Get available quantity*/
            $available_quantity=DB::table("locationproduct")
            ->where("product_id",$product->id)
            ->where("location_id",$location_id)
            ->orderBy("id","DESC")
            ->pluck("quantity");
            if (empty($available_quantity)) {
                # code...
                $available_quantity=0;
            }
            $product->available_quantity=$available_quantity;
        }
        return $merchant_pro;
		return Response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockout($terminal_id)
    {
        $user_id     = Auth::user()->id;
       
        $location_id=DB::table("opos_locationterminal")->where("terminal_id",$terminal_id)->orderBy("id","DESC")->pluck("location_id");
        if (empty($location_id)) {
            return "Invalid Terminal ID";
        }
        $merchant_user_id=DB::table("fairlocation")
        ->where("id",$location_id)
        ->pluck("user_id");
        if (empty($merchant_user_id)) {
        	return "Invalid Merchant";
        }
         $merchant = Merchant::where('user_id','=',$merchant_user_id)->first();
         $merchant_pro = $merchant->products()
        ->whereNull('product.deleted_at')
        ->leftJoin('product as productb2b', function($join) {
            $join->on('product.id', '=', 'productb2b.parent_id')
            ->where('productb2b.segment','=','b2b');
        })
        ->leftJoin('product as producthyper', function($join) {
            $join->on('product.id', '=', 'producthyper.parent_id')
            ->where('producthyper.segment','=','hyper');
        })
        ->leftJoin('tproduct as tproduct', function($join) {
            $join->on('product.id', '=', 'tproduct.parent_id');
        })
        ->join("locationproduct","locationproduct.product_id","=","product.id")
        ->leftJoin('productbc','product.id','=','productbc.product_id')
        ->leftJoin('bc_management','bc_management.id','=','productbc.bc_management_id')
        ->select(DB::raw('
            product.id,
            product.parent_id,
            bc_management.id as bc_management_id,
            productbc.deleted_at as pbdeleted_at,
            product.name,
            product.thumb_photo as photo_1,
            product.available,
            productb2b.available as availableb2b,
            producthyper.available as availablehyper,
            tproduct.available as warehouse_available,
            product.sku'))
        ->groupBy('product.id')
            ->where("product.status","!=","transferred")
            ->where("product.status","!=","deleted")
            ->where("product.status","!=","")
            ->where("product.type","!=","service")
            ->where("locationproduct.location_id",$location_id)
            ->orderBy('product.created_at','DESC')
            ->get();
        foreach ($merchant_pro as $key=>$product) {
            /*Get available quantity*/
            $available_quantity=DB::table("locationproduct")
            ->where("product_id",$product->id)
            ->where("location_id",$location_id)
            ->orderBy("id","DESC")
            ->pluck("quantity");
            if ($available_quantity>0) {
                # code...
                 $product->available_quantity=$available_quantity;
            }else{
                /*Delete*/
                unset($merchant_pro[$key]);
            }
           
        }
        return $merchant_pro;
		//return Response()->json($products);
    }

     public function cmlquery($terminal_id,$pay_type)
    {  
        $query=
        "
		SELECT
			concat(u.first_name,u.last_name) as name,
			u.id as user_id,
			oppc.mode,
			'reason' as type,
			oppc.amount,
			0 as discount,
			0 as service_charges,
			0 as cash,
			oppcr.description as description,

			oppc.updated_at,
			'..' as voided_at,
			oppc.id as id,
			'--' as status,
			'' as ptype
		FROM 
            opos_pettycash oppc
            JOIN opos_pcreason oppcr on oppcr.id=oppc.pcreason_id
            LEFT JOIN users u on oppc.staff_user_id =u.id
		WHERE 
			oppc.terminal_id=$terminal_id 

		UNION 
		SELECT
            concat(u.first_name,u.last_name) as name,
            u.id as user_id,
            'in' as mode,
            'cash' as type,
            SUM(opcp.quantity*(opcp.price)) as amount,
            SUM((opcp.discount*opcp.quantity*opcp.price)/100) as discount,
            opsc.value as service_charges,
            opr.cash_received as cash,
            'Cash Sales' as description,
            opr.updated_at,
            opr.voided_at,
            opr.id as id,
            opr.status as status,
            opr.payment_type as ptype
		FROM 
			opos_receipt opr
			LEFT JOIN opos_receiptproduct opcp on opcp.receipt_id=opr.id
			JOIN users u on u.id=opr.staff_user_id
			LEFT JOIN opos_servicecharge opsc on opsc.id=opr.servicecharge_id
		WHERE opr.terminal_id=$terminal_id 

		
        AND opr.status IN ('completed','voided')
        AND DATE(opr.created_at) = CURDATE()
        AND opcp.deleted_at IS NULL

		GROUP BY opr.id
		ORDER BY updated_at desc
        ";
        return $query;

   //      $todayAmount = DB::select($report1.' and opos_receipt.created_at like "'.
			// date('Y-m-d',strtotime(Carbon::today())).'%" GROUP BY opos_receiptproduct.id');
    }

    
	public function getbalance($terminal_id,$pay_type)
	{  
        // $data=DB::select($this->cmlquery($terminal_id,$pay_type));
        if($pay_type == "cash")
        {
        	$data=DB::select("SELECT opr.cash_received as total_amount,        
		            'in' as mode,
		            SUM(opcp.quantity*(opcp.price)) as amount,
		            SUM((opcp.discount*opcp.quantity*opcp.price)/100) as discount,
		            opsc.value as service_charges,
		            opr.payment_type as ptype
				FROM 
					opos_receipt opr
					LEFT JOIN opos_receiptproduct opcp on opcp.receipt_id=opr.id
					JOIN users u on u.id=opr.staff_user_id
					LEFT JOIN opos_servicecharge opsc on opsc.id=opr.servicecharge_id
				WHERE opr.terminal_id=$terminal_id 		
		        AND opr.status IN ('completed','voided')
		        AND DATE(opr.created_at) = CURDATE()
		        AND opcp.deleted_at IS NULL
				GROUP BY opr.id
				ORDER BY opr.updated_at desc"
			);
        }
        else
        {
        	$data=DB::select("SELECT (SUM(opcp.quantity*(opcp.price)) - opr.cash_received) as total_amount,        
		            'in' as mode,
		            SUM(opcp.quantity*(opcp.price)) as amount,
		            SUM((opcp.discount*opcp.quantity*opcp.price)/100) as discount,
		            opsc.value as service_charges,
		            opr.payment_type as ptype
				FROM 
					opos_receipt opr
					LEFT JOIN opos_receiptproduct opcp on opcp.receipt_id=opr.id
					JOIN users u on u.id=opr.staff_user_id
					LEFT JOIN opos_servicecharge opsc on opsc.id=opr.servicecharge_id
				WHERE opr.terminal_id=$terminal_id 		
		        AND opr.status IN ('completed','voided')
		        AND DATE(opr.created_at) = CURDATE()
		        AND opcp.deleted_at IS NULL
		        AND opr.payment_type ='".$pay_type."'
				GROUP BY opr.id
				ORDER BY opr.updated_at desc"
			);
        }

        

        

		Log::debug('************  getbalance() *****************');
		Log::debug(json_encode($data));
      
        $cmlbalance=0;
        // echo '<pre>'; print_r($data); die();
        foreach($data as $d){
			// $amount=$d->amount;

			// if($d->status!="voided"){
				// if ($d->type=="cash") {
				// 	if ($d->cash< $d->amount) {
				// 		// $amount=$d->cash;
				// 		if($d->ptype == "creditcard")        
				// 		{
				// 			$amount=$d->amount - $d->cash;
				// 		}
				// 		if($d->ptype == "cash")
				// 		{
				// 			$amount=$d->cash;
				// 		}
				// 	}
				// }
			if($d->total_amount > $d->amount)
        	{
        		$amount = $d->amount;
        	}
        	else
        	{
        		$amount = $d->total_amount;
        	}
            
			if ($d->mode=="in") {
				$cmlbalance+=$amount;
			}else{
				$cmlbalance-=$amount;
			}

			// if(!empty($d->service_charges)) {
			// 	$cmlbalance+=($d->service_charges/100*$amount);
			// }
			// }
        }
        return $cmlbalance;
    }
    

    public function receiptcalculations()
    {
    	# code...
    }

    public function showreceiptlist(Request $request,$terminal_id){

        $user_id=Auth::user()->id;

        $month = Carbon::today()->format('F');
        $year = Carbon::now()->year;
        $terminalId = '0';

        $formdate = Carbon::today()->format('jS');

        if (!Auth::check()) {
            return response()->json(["error"=>"Not Logged In"],403);
        }

        $merchant = DB::table('merchant')->where('user_id',$user_id)->first();

        $selluser = User::find($user_id);

        $merchant_address = Address::where('id',!empty($merchant->address_id)?$merchant->address_id:"")
        ->first(array('line1','line2','line3','line4'));
        
// $user_id=360;
        // $terminalId = DB::table('opos_terminalusers')->select('opos_terminalusers.terminal_id')->where('opos_terminalusers.user_id', $user_id)->first();

        // if(count($terminalId) <= 0){
        //     echo "<h4'>Terminal not found!</h4>";
        //     exit();
        // }

        if($terminal_id > 0) {
            $terminalId = $terminal_id;
        } else{
            echo "<h4'>Terminal not found!</h4>";
            exit();
        }

        $terminal=DB::table('opos_terminal')->
			where('id',$terminal_id)->first();

    	$start=$terminal->start_work;
    	$end=$terminal->end_work;
    	$period="today";

		/* TODAY = start_time < current_time < midnight
		 * YESTD = midnight   < current_time < start_time */
    	$current_time=time();
		if ($current_time > strtotime($start) and
    	    $current_time < strtotime('23:59:59')) {
   			$period="today";

		} else {
			$period="yesterday";
		}

		$stime=strtotime($start);
		$etime=strtotime($end);

 		/* Today = Between 09:00:00 to 23:59:59 
		 * Start = Today   09:00:00
		 * End   = Today+1 08:55:00 */

 		/* Yest  = Between 00:00:00 to 02:00:00
		 * Start = Today-1 09:00:00
		 * End   = Today   08:55:00 */

		if ($period=="today") {
			$start_time=strtotime("+0 day", $stime);
			$end_time=strtotime("+1 day -5 mins", $stime);

		} else { // yesterday
			$start_time=strtotime("-1 day", $stime);
			$end_time=strtotime("-5 mins", $stime);
		}

		// Convert to timestamp
		$start_time=date('Y-m-d h:i:s',$start_time);
		$end_time=date('Y-m-d h:i:s',$end_time);

		Log::debug('start_time='.$start_time);
		Log::debug('end_time  ='.$end_time);
		Log::debug('period    ='.$period);

        $location  = DB::table('opos_locationterminal')
			->select('fairlocation.*','opos_locationterminal.terminal_id')
			->join('fairlocation','opos_locationterminal.location_id','=','fairlocation.id')
			->where('opos_locationterminal.terminal_id',$terminalId)->first();

        $currency= DB::table('currency')->where('active', 1)->first()->code;

        $reports = DB::table("opos_receipt")
        ->join("opos_receiptproduct","opos_receiptproduct.receipt_id","=","opos_receipt.id")
        ->join('opos_locationterminal','opos_receipt.terminal_id','=','opos_locationterminal.terminal_id')
        ->join('fairlocation','fairlocation.id','=','opos_locationterminal.location_id')
       ->leftJoin('opos_servicecharge','opos_servicecharge.id','=','opos_receiptproduct.servicecharge_id')
       ->leftJoin('users as usercheck','usercheck.id','=','opos_receipt.staff_user_id')
        ->leftJoin('opos_servicecharge as sc','sc.id','=','opos_receipt.servicecharge_id')
		->select('opos_receipt.id','opos_receipt.staff_user_id',
			'opos_receipt.created_at','usercheck.first_name',
            'usercheck.last_name','opos_receipt.receipt_no',
            'opos_receipt.status',
            'opos_receipt.creditcard_no',
            'opos_receipt.otherpoints',
            'opos_receipt.payment_type',
            'opos_receipt.cash_received',
			'sc.value',
			'opos_receipt.mode',
			'opos_receipt.round',
            'opos_receipt.terminal_id','opos_receipt.cash_received',
//          SUM(opcp.quantity*(opcp.price+(opsc.value*opcp.price/100))) as amount,
            'fairlocation.location',
			DB::raw(
//		    "SUM(opos_receiptproduct.quantity*(opos_receiptproduct.price+ (opos_servicecharge.value/100)*opos_receiptproduct.price) ) as amount"
           "SUM(opos_receiptproduct.quantity*(opos_receiptproduct.price)) as amount"
			),
			"sc.value as servicecharge",
			"opos_receipt.service_tax",
            DB::raw(
                "SUM((opos_receiptproduct.quantity*opos_receiptproduct.price*opos_receiptproduct.discount)/100) as discount")
        );
      
        $reports = $reports->whereRaw('opos_receipt.terminal_id = '.$terminalId)
			   ->whereRaw('opos_receipt.status IN ("completed","voided")')->whereNull("opos_receipt.deleted_at")->whereNull("opos_receiptproduct.deleted_at");
        $report1 = $reports->toSql();
        $report2 = $reports->toSql();

        $monthlyAmount = DB::select($report2.' and opos_receipt.created_at like "'.
			date('Y-m',strtotime(Carbon::today())).'%" GROUP BY opos_receiptproduct.id');
        
        $todayAmount = DB::select($report1.' and opos_receipt.created_at BETWEEN "'.
			$start_time.'" AND "'.$end_time.'" GROUP BY opos_receiptproduct.id');

		$reports->whereRaw(' opos_receipt.created_at BETWEEN "'.
			$start_time.'" AND "'.$end_time.'"')->
			groupBy("opos_receipt.id")->
			orderBy("opos_receipt.id", "desc");

		$reports = $reports->orderBy("opos_receipt.created_at","DESC")->
			get();

		$cash=0;
		$creditcard=0;
		$otherpoints=0;
        foreach ($reports as $r) {
			//Log::debug(json_encode($r));
			/* Original price less discount */
			
        	$r->amount = $r->amount - $r->discount;

			/* Service charge against total */
			$scharge = $r->amount * (($r->value)/100);

			/*Service Tax*/
			$sst=0;
			if ($r->mode=="exclusive") {
				$sst=$r->amount * (($r->service_tax)/100);
			}
			/* Final total includes service charge */
        	$r->amount = $r->amount + floor($scharge)+floor($sst)+$r->round; 
       
        
       			/*For csh and credit*/
			if($r->status=="completed"){
				if ($r->cash_received>=$r->amount) {
					# code...
					$cash+=$r->amount;
				}else{
					if ($r->cash_received<$r->amount) {
						# code...
						$cash+=$r->cash_received;
						if ($r->payment_type=="creditcard") {
							# code...
							/*dump($r->amount);
							dump($r->otherpoints);
							dump($r->cash_received);*/
							$creditcard+=($r->amount-($r->otherpoints*100)-$r->cash_received);
						}
						
						
					}
				}

				$otherpoints+=$r->otherpoints;
			}
        }

        foreach ($monthlyAmount as $r) {
			/* Original price less discount */
        
        	if ($r->mode=="inclusive") {
        		$r->amount = $r->amount - $r->discount;
				/*$s=floatval($r->amount) * (($r->service_tax)/100.0);*/

				/*$r->amount=$r->amount/(1+($r->service_tax/100));*/

			}else{
				$r->amount = $r->amount - $r->discount;
			}
			/* Service charge against total */
			/*$scharge = $r->amount * (($r->value)/100);*/

			/* Final total includes service charge */
        	/*$r->amount = $r->amount + $scharge; */
        }

        foreach ($todayAmount as $r) {
			/* Original price less discount */

        	if ($r->mode=="inclusive") {
        		$r->amount = $r->amount - $r->discount;
				/*$r->amount=$r->amount/(1+($r->service_tax/100));*/
			}else{
				$r->amount = $r->amount - $r->discount;
			}

			/* Service charge against total */
			/*$scharge = $r->amount * (($r->value)/100);*/

			/* Final total includes service charge */
        	/*$r->amount = $r->amount + $scharge; */
        }

        //dd($monthlyAmount);
        // $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        // $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        
        $s= $merchant_address;
        $name = !empty($merchant->company_name)?$merchant->company_name:"";    
        $monthNum=Carbon::now()->month;
		$monthName = $month; // March        
		$year=Carbon::now()->year;
		
		
		/*$otherpoints = DB::table('opos_receipt')
						 ->select(DB::raw("SUM(otherpoints) as otherpoints"))
						 ->whereRaw('terminal_id = '.$terminalId)
			   			 ->whereRaw('status IN ("completed","voided")')
			   			 ->whereRaw('Date(created_at) = CURDATE()')
			   			 ->first();*/

		return view('opposum.trunk.oposumreceiptlist')
		->with('reports',			$reports)
		->with('location',			$location)
		->with('monthlyAmount',		$monthlyAmount)
		->with('cash',				$cash)
		->with('creditcard',		$creditcard)
		->with('otherpoints',		$otherpoints)
		->with('todayAmount',		$todayAmount)
		->with('terminalId',		$terminalId)
		->with('selluser',			$selluser)
		->with('merchant',			$merchant)
		->with('currency',			$currency)
		->with('merchant_address',	$merchant_address)
		->with('name',				$name)
		->with('s',					$s)
        ->with('id',				$user_id)
        ->with('month',				$monthName)
        ->with('year',				$year)
        ->with('today',				$formdate);        
    }

    public function showopossumreceipt($receipt_id){
        $user_id = Auth::user()->id;
        $receiptInfo = OposReceipt::find($receipt_id);
        $data=$this->receiptproducts($receipt_id);

        $staff_user_id = "";
        if(isset($receiptInfo)){
            $staff_user_id = $receiptInfo->staff_user_id;
        }

        if($staff_user_id !== "" && $staff_user_id == 0 ) {
            $staff_user_id = $user_id;
        }
      
        $company=Company::where('company.owner_user_id',$user_id)->
            join("merchant","merchant.user_id","=","company.owner_user_id")->
            join("users","users.id","=","merchant.user_id")->
            leftJoin('address','merchant.address_id','=','address.id')->
            leftJoin('city','address.city_id','=','city.id')->
            leftJoin('state','city.state_code','=','state.code')->
            select('address.line1','address.line2','address.line3',
                'city.name','state.name','address.postcode',
                'company.dispname','company.id','merchant.gst',
                'users.first_name as first_name',
                'users.last_name as last_name',
                'users.name','users.id as user_id')->
            first();

        
        $staff = DB::table('users')
                ->select('users.first_name','users.last_name')
                ->join('opos_receipt','opos_receipt.staff_user_id','=','users.id')
                ->where('staff_user_id',$staff_user_id)
                ->first();    

        return view('opposum.trunk.receipts',$data)
        ->with('receiptInfo',$receiptInfo)
        ->with('company',$company)
        ->with('staff',$staff);
    }
        

    public function savelokersession(Request $request){
        $lokerdata = (object) $request->all();
        if($lokerdata->ftype_id != '') {
			//get locker key no.
			$lockerkeyno = DB::table('opos_ftype')
				->select('fnumber')
				->where('id',$lokerdata->ftype_id)
				->where('ftype','lockerkey')
				->orderby('id','desc')
				->first();
               
			//get transaction reference number
			$lockerkeydata = DB::table('opos_lockerkeytxn')
				->select('*')
				->where('lockerkey_ftype_id',$lokerdata->ftype_id)
				->whereNull("deleted_at")
				->orderby('id','desc')
				->first();
            if (empty($lockerkeydata)) {
                return response()->json([
                    "status"=>"failure"
                ]);
            }
			 //get receipt id
			$lockerkeytxn_id =  $lockerkeydata->id;
			$receiptdata = DB::table('opos_lockerkeytxnref')
				->join('opos_receipt','opos_receipt.ref_no','=','opos_lockerkeytxnref.ref_no')
				->select('opos_lockerkeytxnref.*','opos_receipt.id')
				->where('opos_lockerkeytxnref.lockerkeytxn_id',$lockerkeytxn_id)
				->whereNull("opos_lockerkeytxnref.deleted_at")
				->orderby('opos_lockerkeytxnref.id','desc')
				->first();

			// $sparoom = DB::table('opos_lockerkeytxnsparoom')
			//  ->select('*')
			//  ->where('lockerkey_ftype_id',$ftypelocarkeydata->id)
			//  ->orderby('id','desc')
			//  ->first();

			$table="opos_save";
			$insert_data=[
				"receipt_id"=>isset($receiptdata->id) ? $receiptdata->id: null,
				"lockerkey_start"=>isset($lockerkeydata->checkin_tstamp) ? $lockerkeydata->checkin_tstamp: null,
				"lockerkey_end"=>isset($lockerkeydata->checkout_tstamp) ? $lockerkeydata->checkout_tstamp: null,
				"lockerkey_no"=>$lockerkeyno->fnumber,
				// "sparoom_no"=>$sparoom->sparoom_ftype_id,
				"created_at"=>Carbon::now(),
				"updated_at"=>Carbon::now()
			];

			try {
				$data=DB::table($table)->insertgetId($insert_data);              

			} catch(\Exception $e){
				$ret["short_message"]=$e->getMessage();
				Log::error("Error @ ".$e->getLine()." file ".
				$e->getFile()." ".$e->getMessage());
			} 
		} 

        return  response()->json(["status" => true]);
    }

    public function showSavedData()
    {
        $lokerdata = DB::table('opos_save')
                    ->select('*')
                    ->get();

        return view('opposum.trunk.oposumsavedata',compact('lokerdata'));
    }


    public function deletelokersession(Request $request){
        $lokerdata = (object) $request->all();

        if($lokerdata->type == "endlockerid")
        {
            $ftypeid = DB::table('opos_ftype')
                ->select('fnumber')
                ->where('id',$lokerdata->id)
                ->where('ftype','lockerkey')
                ->whereNull("deleted_at")
                ->orderby('id','desc')
                ->first();
            $opos=[];

            if (!empty($ftypeid)) {
                # code...
                 $opos = OposSave::select('id')
                            ->where('lockerkey_no',$ftypeid->fnumber)
                            ->first();
            }
           
            if(count($opos) > 0)
            {
             $lokerdata->id = $opos->id;
            }
        }
        $status = OposSave::where('id', $lokerdata->id)->delete();
        // $status =  $delete->delete();
        return  response()->json(["status" => $status]);
    } 

    public function getftypeid(Request $request){
        $lokerdata = (object) $request->all();

        $ftypeid = DB::table('opos_ftype')
                ->select('id')
                ->where('fnumber',$lokerdata->lockerkey)
                ->where('ftype','lockerkey')
                ->orderby('id','desc')
                ->first();
       
        return  response()->json(["ftypeid" => $ftypeid->id]);
    } 
    function lokerkeydata(Request $request){
        $lokerdata = (object) $request->all();
        $lockerkey = (int) $lokerdata->lockerkey;
        
        $pacustlockerkeydata = DB::table('opos_spacustlockerkey')
                    ->select('*')
                    ->where('lockerkey_id',$lockerkey)
                     ->orderby('id','desc')
                    ->first();
        $pacustdata = array();
        if(isset($pacustlockerkeydata->spacust_id)){
        $pacustdata = DB::table('opos_spacust')
                    ->select('*')
                    ->where('lockerkey_id',$pacustlockerkeydata->spacust_id)
                     ->orderby('id','desc')
                    ->first();
        }
        $ftypedata = DB::table('opos_ftype')
                    ->select('*')
                    ->where('fnumber',$lockerkey)
                    ->where('ftype','lockerkey')
                     ->orderby('id','desc')
                    ->first();
        $locarkeydata = DB::table('opos_lockerkeytxn')
                    ->select('*')
                    ->where('lockerkey_ftype_id',$ftypedata->id)
                     ->orderby('id','desc')
                    ->first();
        $locarkeydata->checkin_tstamp=UtilityController::s_date($locarkeydata->checkin_tstamp);
        $locarkeydata->checkout_tstamp=UtilityController::s_date($locarkeydata->checkout_tstamp);
        return view('opposum.trunk.lokerkeydata',compact('pacustdata','locarkeydata'));
    }
      
    function setbfunction(Request $request){
        $user_id=Auth::user()->id;
        $table="opos_terminal";
        $requestdata = (object) $request->all();
        $update_data=[
                "bfunction"=>$requestdata->ftype,
                "updated_at"=>Carbon::now()
            ];
            $data=DB::table($table)
            ->where("id",$request->terminal_id)
            ->update($update_data);
        return  $requestdata->ftype;
    }

    function getbfunction(){
        $bdata = DB::table('merchant')
                    ->select('bfunction')
                     ->orderby('id','desc')
                    ->first();
        return $bdata->bfunction;
    }

    function digitalclock(){
        echo date('D dMy H:i:s');
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function do_stockreport(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            /*Create a stockreport*/
            $ttype=$r->ttype;
            if (empty($ttype) or !in_array($ttype,["tin","tout"])) {
                $ret["short_message"]="Incorrect ttype";
                return response()->json($ret);
            }
            $products=$r->products;
            if (empty($products)) {
                # code...
                $ret["short_message"]="No product specified";
                return response()->json($ret);
            }
            $action="minus";
            $message="Stock Out successfully done!";
            if ($ttype=="tin") {
                $action="add";
                $message="Stock In successfully done!";
            }
            $terminal_id=$r->terminal_id;
            $location_id=DB::table("opos_locationterminal")
            ->where("terminal_id",$terminal_id)
            ->whereNull("deleted_at")
            ->orderBy("id","DESC")
            ->pluck("location_id");
            if (empty($location_id)) {
                $ret["short_message"]="No location found for the terminal";
                return response()->json($ret);
            }
            $company_id=DB::table("fairlocation")
            ->where("fairlocation.id",$location_id)
            ->join("company","company.owner_user_id","=","fairlocation.user_id")
            ->whereNull("company.deleted_at")
            ->whereNull("fairlocation.deleted_at")
            ->pluck("company.id");

            if (empty($company_id)) {
                # code...
                $ret["short_message"]="No company found for the terminal";
                return response()->json($ret);
            }
            $method=$r->method;

            $table="stockreport";
            $insert_data=[
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now(),
            "checked_on"=>Carbon::now(),
            "creator_user_id"=>$user_id,
            "checker_user_id"=>$user_id,
            "checker_company_id"=>$company_id,
            "creator_company_id"=>$company_id,
            "checker_location_id"=>$location_id,
            "creator_location_id"=>$location_id,
            "ttype"=>$ttype,
            "method"=>$method,
            "status"=>"confirmed"
            ];
            $stockreport_id=DB::table($table)
            ->insertGetId($insert_data);
            foreach ($products as $product) {
                $quantity=$product['quantity'];
                $product_id=$product['product_id'];
                if ($quantity<1 or $product_id<1) {
                    Log::debug("Incorrect quantity or product_id");

                }else{
                    UtilityController::locationproduct($location_id,$product_id,$quantity,$action);
                    $insert_data=[
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now(),
                    "stockreport_id"=>$stockreport_id,
                    "product_id"=>$product_id,
                    "quantity"=>$quantity,
                    "received"=>$quantity,
                    "status"=>"checked",
                    ];
                    DB::table("stockreportproduct")->insert($insert_data);
                }
            }
            
            $ret["status"]="success";
            $ret["short_message"]=$message;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    public function opossumLogin()
    {
    	// $fairmerchant = DB::table('member')
	    // 				  ->join('company','member.company_id','=','company.id')
					// 	  ->where('member.type','member')
					// 	  ->select('member.id','member.email','member.user_id','member.company_id','company.company_name')
					// 	  ->groupBy('company.id')
					// 	  ->get();

    	return view('common.opos_login');
    }

    public function getCompanyData($user_id=null)
    {
    	$data = array();
    	$ret=array();
    	$ret["status"]="failure";
    	$fairmerchant = DB::table('member')
	    				  ->join('company','member.company_id','=','company.id')
						  ->where('member.type','member')
						  ->select('member.company_id','company.company_name')
						  ->groupBy('company.id');
						     	
	  	if(isset($user_id) && $user_id > 0)
	  	{
			$fairmerchant  = $fairmerchant->where('member.user_id',$user_id);
	   	}
		$fairmerchant  = $fairmerchant->get();

		$arrayopos = array("opu","opm");
		$arrayware = array("whm","whu");

		$functionmode = DB::table('role_users')
             		   ->join('roles','roles.id','=','role_users.role_id')
             		   ->select('roles.slug')
             		   ->where('role_users.user_id',$user_id)
             		   ->whereNull('roles.deleted_at')
             		   ->whereNull('role_users.deleted_at')
             		   ->get();

        $fun = array();
        foreach($functionmode as $fuu)
        {
        	$fun[] = $fuu->slug;
        }

       $functionarray = array();
       $oposfun = array_intersect($arrayopos,$fun);
       $warefun = array_intersect($arrayware,$fun);
       $index = 0;

       if(count($oposfun) > 0)
       {
       		$functionarray[$index]['id']  = "opossum";
       		$functionarray[$index]['value']  = "OPOSsum";
       		$index++;

       }
       if(count($warefun) > 0)
       {	
       		$functionarray[$index]['id']  = "warehouse";
       		$functionarray[$index]['value']  = "Warehouse";
       		$index++;
       }            

       	$data['fairmerchant'] = $fairmerchant;
       	$data['functionmode'] = $functionarray;

		$ret["status"]="success";
		$ret["data"]=$data;
		return response()->json($ret);
		 // return view('common.getcompanydata',compact('fairmerchant'));
    }

    public function companylocation(Request $r)
    {
      	$ret=array();
    	$ret["status"]="failure";
    	try{
    		
			$companyid=$r->companyid;
			$data=DB::table("fairlocation")
					->join('company','fairlocation.user_id','=','company.owner_user_id')
					->join('locationusers','locationusers.location_id','=','fairlocation.id')
					->select('fairlocation.id as location_id','fairlocation.location')
					->whereNull("fairlocation.deleted_at")
    				->where("company.id",$companyid)
    				->groupBy('fairlocation.id')
    				->get();

			$ret["status"]="success";
			$ret["data"]=$data;
			return response()->json($ret);
    	}
    	
    	catch(\Exception $e){
    		$ret["short_message"]=$e->getMessage();
    		Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    	}   	

    	return response()->json($ret);
    }

	public function locationterminal(Request $r) {
    	$ret=array();
    	$ret["status"]="failure";
    	try{
			$data = DB::table('opos_terminal')
				->join('opos_locationterminal',"opos_terminal.id","=","opos_locationterminal.terminal_id")
				->join('opos_terminalusers',"opos_terminal.id",'=','opos_terminalusers.terminal_id')
				->select('opos_terminal.name','opos_terminal.id')
				->where('opos_locationterminal.location_id',$r->locationid)
				->groupBy('opos_terminal.id')			 
				->get();

			$ret["status"]="success";
			$ret["data"]=$data;
			return response()->json($ret);   		

    	} catch(\Exception $e){
    		$ret["short_message"]=$e->getMessage();
    		Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    	}   	

    	return response()->json($ret);
    }

  //   public function checkData(Request $request)
  //   {
  //   	$ret=array();
  //   	$data = $request->all();
  //   	$user_id = Auth::user()->id;
    	
  //   	$checkcompany = DB::table('merchant')
  //   			   ->join('company','merchant.user_id','=','company.owner_user_id')
		// 		   ->join('member','member.company_id','=','company.id')
		// 		   ->where('member.type','member')
		// 		   ->where('member.user_id',$user_id)
		// 		   ->where('merchant.user_id',$data['merchantuserid'])
		// 		   ->select('merchant.*')
		// 		   ->get();

		// $checkterminal = DB::table('opos_terminalusers')
	 //    			   ->where('terminal_id',$data['terminalid'])
	 //    			   ->where('user_id',$user_id)
	 //    			   ->get();

	 //    if(count($checkcompany)> 0 && count($checkterminal) > 0)
	 //    {
	 //    	$ret["status"]="success";
		// 	// $ret["data"]=$data;
		// 	return response()->json($ret);   
	 //    }
	 //    else
	 //    {
	 //    	$ret["status"]="failure";
		// 	// $ret["data"]='';
		// 	return response()->json($ret);  
	 //    }
		
  //   }
    
    public function receipt_no(Request $r)
    {
    	$ret=1;
    	$terminal_id=$r->terminal_id;
    	$old_receipt_number=DB::table("opos_terminal")
    	->where("id",$terminal_id)
    	->pluck("receipt_no");
    	if (!empty($old_receipt_number)) {
    		$ret=$old_receipt_number+1;
    	}
    	Log::info("New receipt no for terminal id ".$terminal_id." is ".$ret);
    	DB::table("opos_terminal")
    	->where("id",$terminal_id)
    	->update([
    		"receipt_no"=>$ret,
    		"updated_at"=>Carbon::now()
    	]);
    	return $ret;
    }


    function varifyvoucher(Request $request){
        $data = $request->all();

		Log::debug($data);
		Log::debug('voucher_no='.$data['voucher_no']);

        $voucherdata = DB::table('voucher')->
			join('product','voucher.product_id','=','product.id')->
			leftjoin('voucherbuyer','voucher.id','=','voucherbuyer.voucher_id')->
			leftjoin('porder','voucherbuyer.buyer_id','=','porder.user_id')->
			leftjoin('orderproduct','porder.id','=','orderproduct.porder_id')->
			leftjoin('users','voucherbuyer.buyer_id','=','users.id')->
			leftjoin('nbuyerid','users.id','=','nbuyerid.user_id')->
			where('voucher.id',$data['voucher_no'])->
			where('nature','!=','paper')->
			select('product.thumb_photo','voucher.id','porder.user_id as buyer_id','voucher.product_id','product.name as pname','users.first_name','users.last_name','package_qty','voucherbuyer.qty_left','product.thumb_photo as thumb_photo','product.voucher_package_qty')->
			first();

        if(!empty($voucherdata)){
            return view('opposum.trunk.voucherdataview',compact('voucherdata'));
        }
        else
        {
        	return response()->json(["error"=>"Voucher not found"]);
        }
    }
    
    function redeemvoucher(Request $request){
        $data = (object) $request->all();
        $user_id=Auth::user()->id;

        $terminal_id=$data->terminal_id;

        $location_id=DB::table("opos_locationterminal")
        ->where("terminal_id",$terminal_id)
        ->whereNull("deleted_at")
        ->orderBy("id","DESC")
        ->pluck("location_id");

        if (empty($location_id)) {
            $ret["short_message"]="No location found for the terminal";
            return response()->json($ret);
        }      
      
        $voucherdata = DB::table('voucherbuyer')->
			where('voucher_id',$data->voucher_id)->
			select('qty_left')->first();

        if(count($voucherdata) > 0){
        	
            if($voucherdata->qty_left > 0){
                $qty_left = $voucherdata->qty_left - $data->redeemvoucherqty;
            }
            else{
                $qty_left = $data->package_qty - $data->redeemvoucherqty;
            }
        }
        else{
                $qty_left = $data->package_qty - $data->redeemvoucherqty;
            }
    	$update_data=[
    		"voucher_id"=>$data->voucher_id,
    		"buyer_id" => $user_id,
            "qty_left"=>$qty_left,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ];

        if(count($voucherdata) > 0)
        {
        	 $vbdata=DB::table('voucherbuyer')
		             ->where('voucher_id' ,$data->voucher_id)
		             ->update($update_data);
        }
        else
        {
        	 $vbdata=DB::table('voucherbuyer')
		             ->insertgetId($update_data);
        }

        DB::table("voucherledger")
          ->insert([
    			"staff_user_id" =>$user_id,
				"voucher_id" => $data->voucher_id,
				"location_id" => $location_id,
				"created_at"=>Carbon::now(),
				"updated_at"=>Carbon::now(),
			]);           
     }
    

    public function OpopssumLoginUser(Request $req){

    	$ret=array();

    	$ret["status"]="failure";

    	$user_name = $req->username;
        $user_password = $req->password;       

        /* If either username or password is empty return failure
         * immediately */
        if (empty($user_name) or empty($user_password)) {
            $ret["long_message"]="Your username or password is incorrect. Please try again.";
            return response()->json($ret);
        }

        $user_id = User::where('email', $user_name)->first(['id']);
        if (!empty($user_id)) {
         	$user_role = RoleUser::where('user_id', $user_id->id)->
		  		with('user_role')->get();

	  		if (is_null($user_role)) {
	            return response()->json[['status'=>'failure','short_message'=>'Missing Role','long_message'=>'DB Error: The user has no role. Please contact OpenSupport.']];
	            return "";
            }
        }

        if (!empty($user_role)) {
        	$userRole = $user_role->toArray();
            foreach ($userRole as $key => $Role)
            {
            	if ($Role['user_role']['slug'] == 'byr') {
					$buyerStatus = Buyer::where('user_id', $user_id->id)->first(['status']);
					if ($buyerStatus->status != 'active') {
						if($buyerStatus->status == 'suspended'){
							$ret["long_message"]="Your buyer account has been suspended. Please contact OpenSupport.";
							
						} else {
							$ret["long_message"]="Your account is not active. Please contact OpenSupport.";
						}
						return response()->json($ret);
                    }
				}
            }
        }

        if (Auth::attempt(['email' => $user_name, 'password' => $user_password], true)) {
        	$user_id = Auth::user()->id;
			$osmallvisit=DB::table('osmallvisit')->where('user_id',$user_id)->first();
			DB::table('users')->where('id', $user_id)->update(['password_fail'=>0]);
			if(is_null($osmallvisit)){
				DB::table('osmallvisit')->insert(['user_id'=>$user_id,'counter'=>1]);
			} else {
				DB::table('osmallvisit')->where('id',$osmallvisit->id)->update(['counter'=>($osmallvisit->counter + 1)]);
			}
			Session::put('user_id', $user_id);
			$ret["status"]="success";

        } else {
        	$dbuser = DB::table('users')->where('email', $user_name)->first();
			$globals = DB::table('global')->first();
			$att = 0;
			if(!is_null($dbuser)){
				$att = $dbuser->password_fail + 1;
				DB::table('users')->where('email', $user_name)->update(['password_fail'=>$att]);
                $userr = DB::table('users')->where('email', $user_name)->first();
                if(!is_null($userr)){
                    DB::table('buyer')->where('user_id', $userr->id)->update(['status' => 'active']);
                }             
				if($att >= $globals->max_password_fail){
					DB::table('buyer')->where('user_id', $dbuser->id)->update(['status'=>'suspended']);
					$e= new EmailController;
					$e->passwordFail($user_name);
				}
			}
            $ret["long_message"]="Your username or password is incorrect. Please try again.";
			return response()->json($ret);
        }

        $ret["isvalid"] = true;
        $user_id = Auth::user()->id;

        $ret["user_id"] = $user_id;
        if($req->isfromlocal == 1) {
        	$ret["isvalid"]=$this->validateOpossumLoginData($req,$user_id,"inlineCall");
        	if(!$ret['isvalid']) Auth::logout();
        } else {
        	Auth::logout();
        }
	    return response()->json($ret);
    }

    public function validateOpossumLoginData(Request $req, $user_id=null,$type=null)
    {
		if(isset($req->loggedid) && $req->loggedid > 0) {
			$user_id = $req->loggedid;
		}
    	$ret=array();

    	$ret["isvalid"] = true;

    	$status = true;
    	//otherdata
        
        $company = (isset($req->merchantid) && !empty($req->merchantid) &&
			$req->merchantid > 0)? $req->merchantid :  $req->merchant; 

        $functionmode = (isset($req->modeid) && !empty($req->modeid) &&
			$req->modeid !== '') ? $req->modeid :  $req->modeselect;        

        $location = (isset($req->locationid) && !empty($req->locationid) &&
			$req->locationid > 0) ? $req->locationid :  $req->location;

        $terminal = (isset($req->terminalid) && !empty($req->terminalid) &&
			$req->terminalid > 0) ? $req->terminalid :  $req->terminal;
        
       	$array = array();
       	if($functionmode == 'opossum') {
        	$array = array("opu","opm");
        }

        if($functionmode == 'warehouse') {
        	$array = array("whm","whu");
        }

        $checkfunction = DB::table('role_users')
			->join('roles','roles.id','=','role_users.role_id')
			->whereIn('roles.slug',$array)
			->where('role_users.user_id',$user_id)
			->whereNull('roles.deleted_at')
			->whereNull('role_users.deleted_at')
			->get(); 

        $checkcompany = DB::table('member')
			->join('company','member.company_id','=','company.id')
			->where('member.type','member')
			->where('member.user_id',$user_id)
			->where('member.company_id',$company)
			->select('member.id','member.email','member.user_id','member.company_id','company.company_name')
			->whereNull('company.deleted_at')
			->whereNull('member.deleted_at')
			->groupBy('company.id')
			->get();		


		$checklocation = DB::table("fairlocation")
			->join('company','fairlocation.user_id','=','company.owner_user_id')
			->join('locationusers','locationusers.location_id','=','fairlocation.id')
			->select('fairlocation.id as location_id','fairlocation.location')
			->where('locationusers.user_id',$user_id)
			->where('fairlocation.id',$location)
			->whereNull("fairlocation.deleted_at")
			->whereNull('company.deleted_at')
			->whereNull('locationusers.deleted_at')
			->where("company.id",$company)
			->groupBy('fairlocation.id')
			->get();

	   	if($functionmode == 'opossum') {
			$checkterminal = DB::table('opos_terminalusers')
				->where('terminal_id',$terminal)
				->where('user_id',$user_id)
				->groupBy('terminal_id')
				->get();

			if(count($checkterminal) == 0) {
				$status=false;
			}
		}

	    if (count($checkcompany)  == 0 ||
			count($checklocation) == 0 ||
			count($checkfunction) == 0) {
			 $status=false;
		}

		if(isset($type) && $type == "inlineCall") {
			return $status;
		} else {
			if($status) {
				Auth::loginUsingId($user_id);
			}	
			$ret["isvalid"] = $status;
			return response()->json($ret);
		}
		
    }

     public function getLockerKeyDataById($id){
		$lockerKeyProducts=DB::table("opos_lockerkeyproducts")
			->leftJoin("product","product.id","=","opos_lockerkeyproducts.product_id")
			->select("product.name as name","product.id as id","product.thumb_photo as thumb_photo","product.retail_price as retail_price","opos_lockerkeyproducts.quantity as quantity")
			->where("lockerkey_id","=",$id)
			->get();
        return $lockerKeyProducts;
    }
    
    public function getOnLoadUpdateData(Request $r){
		$lockerKeyProducts=[];
        $result=DB::table("opos_servicecharge")->select("*")->get();

        $service_charge_result=DB::table("opos_servicecharge")
        
        ->leftjoin("opos_terminal","opos_servicecharge.id","=","opos_terminal.servicecharge_id")
        
        ->where("opos_terminal.id","=",$r->terminal_id)
        ->select("opos_servicecharge.value","opos_servicecharge.id")
        ->first();
        

        $data=$this->getLastUpdatedLockerKey();
        $lockerKey_id=!empty($data[0]->fnumber)?$data[0]->fnumber:0;
        if(!empty($data[0]))
            {
                

        $lockerKeyProducts=DB::table("opos_lockerkeyproducts")
        ->leftJoin("product","product.id","=","opos_lockerkeyproducts.product_id")
        ->select("product.id",
                "product.thumb_photo as thumb_photo",
                "product.retail_price as retail_price",
                "product.name as name",
                "opos_lockerkeyproducts.quantity as quantity",
                 "opos_lockerkeyproducts.lockerkey_id as lockerkey_id",
                 "opos_lockerkeyproducts.receipt_id as receipt_id"
                )
        ->where("lockerkey_id","=",$lockerKey_id)
        ->get();
            }

        return response()->json([
                                    "service_charges"=>$result,
                                    "lockerkey_products"=>$lockerKeyProducts,
                                    "last_updated_lockerkey"=>$lockerKey_id,
                                    "servicecharge_result"=>$service_charge_result
                                ]);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function servicecharge_active(Request $r,$uid=NULL)
    {
    	$ret=array();
    	$ret["status"]="failure";
    	if(!Auth::check()){return "";}
    	$user_id=Auth::user()->id;
    	if(!empty($uid) and Auth::user()->hasRole("adm")){
    		$user_id=$uid;
    	}
    	try{
    		$table="opos_terminal";
    		$data=DB::table($table)
    		->where($table.".","")		
    		->whereNull($table.".deleted_at")
    		->orderBy($table.".created_at","DESC")
    		->get();
    
    		
    		$ret["status"]="success";
    		$ret["data"]=$data;
    	}
    	catch(\Exception $e){
    		$ret["short_message"]=$e->getMessage();
    		Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    	}
    	return response()->json($ret);
    }

    public function saveServiceCharges(Request $r) {
		try{
			DB::table("opos_servicecharge")->insert([
				"value" => $r->value,
				"user_id" => $r->staffid,
				"created_at" =>Carbon::now(),
				"updated_at" =>Carbon::now()
			]);   

			$result=DB::table("opos_servicecharge")
				->orderBy("value","ASC")
				->get();

			return response()->json([
				"message"=>"Service Charge has been inserted",
				"services"=>$result,
				"status"=>200
			]);

		} catch(\Exception $e){
    		$ret["short_message"]=$e->getMessage();
			Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
			return response()->json(["message"=>$ret,"status"=>404]);
		}
    }

    

    public function closeLockerKey(Request $r) {
		try{
            
            DB::table("opos_lockerkeytxn")
            ->leftjoin("opos_ftype","opos_ftype.id","=","opos_lockerkeytxn.lockerkey_ftype_id")
            ->where("opos_ftype.fnumber","=",$r->value)
            ->where(DB::raw("opos_lockerkeytxn.checkout_tstamp"))
            ->delete();
            DB::table("opos_lockerkeyproducts")
            ->where("lockerkey_id","=",$r->value)
            ->delete();
            // ->delete(["opos_lockerkeytxn.checkout_tstamp"=>date("d-m-Y H:s:i")]);

            return response()->json([
                    "message"=>"Locker Key closed successfully !",
                    "status"=>200
                ]);
		} catch(\Exception $e){
    		$ret["short_message"]=$e->getMessage();
			Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
			return response()->json(["message"=>$ret,"status"=>404]);
		}
    }


    public function resetLockerkey(Request $r) {
		try{
            
            DB::table("opos_lockerkeytxn")
            ->leftjoin("opos_ftype","opos_ftype.id","=","opos_lockerkeytxn.lockerkey_ftype_id")
            ->where("opos_ftype.fnumber","=",$r->value)
            ->where(DB::raw("opos_lockerkeytxn.checkout_tstamp"))  
            ->update(["opos_lockerkeytxn.checkin_tstamp"=> Carbon::now()]);
            DB::table("opos_lockerkeyproducts")
            ->where("lockerkey_id","=",$r->value)
            ->delete();
            return response()->json([
                    "message"=>"Locker Key closed successfully !",
                    "status"=>200
                ]);
		} catch(\Exception $e){
    		$ret["short_message"]=$e->getMessage();
			Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
			return response()->json(["message"=>$ret,"status"=>404]);
		}
    }

    public function applySelectedServiceCharge(Request $r) {
		try{
            

          $result=DB::table("opos_terminal")
          ->where("id",$r->terminal_id)
          ->update([
          	"servicecharge_id"=>$r->servicecharge_id,
          	"updated_at"=>Carbon::now()
          ]);
    if($result>0){
			return response()->json([
				"message"=>"Service Charge has been updated",
				"status"=>200
            ]);
            }else{
                return response()->json([
                    "message"=>"Service charge updation failed",
                    "status"=>500
                ]);
            }

		} catch(\Exception $e){
    		$ret["short_message"]=$e->getMessage();
			Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
			return response()->json(["message"=>$ret,"status"=>404]);
		}
    }

    public function getMobileVerification()
    {
    	return view('opposum.trunk.verification');
    }    


    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function otherpoint(Request $r,$uid=NULL)
    {
    	$ret=array();
    	$ret["status"]="failure";
    	if(!Auth::check()){return "";}
    	$user_id=Auth::user()->id;
    	if(!empty($uid) and Auth::user()->hasRole("adm")){
    		$user_id=$uid;
    	}
    	try{
    		$table="merchant";
    		$mode=$r->mode;
    		
    		$terminal_id=$r->terminal_id;

    		$merchant_user_id=DB::table("opos_terminal")
    		->join("fairlocation","fairlocation.id","=","opos_terminal.location_id")
    		->pluck("fairlocation.user_id");

    		DB::table("merchant")
    		->whereNull("deleted_at")
    		->where("user_id",$merchant_user_id)
    		->update([
    		"otherpoint"=>$mode,
    		"updated_at"=>Carbon::now()
    		]);
    		DB::table("opos_terminal")
    		->where("terminal_id",$terminal_id)
    		->update([
    		"otherpoint"=>$mode,
    		"updated_at"=>Carbon::now()
    		]);
    
    		
    		$ret["status"]="success";
    		$ret["data"]=$data;
    	}
    	catch(\Exception $e){
    		$ret["short_message"]=$e->getMessage();
    		Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    	}
    	return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function login($user_id,$terminal_id)
    {
    	
    	try{
    		$table="opos_terminal";
    		$data=DB::table($table)
    		->where($table.".id",$terminal_id)		
    		->update([
    			"updated_at"=>Carbon::now(),
    			"logged_user_id"=>$user_id
    		]);
    
    		
    	}
    	catch(\Exception $e){
    		
    		Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    	}
    	return "ok";
    }

    public function get_hidden_products($terminal_id)
    {
    	# code...
    	$productArr=array();
    	$products=DB::table("opos_productpreference")
    	->where('terminal_id',$terminal_id)
    	->where('status',"hide")
    	->whereNull('deleted_at')
    	->select('product_id')
    	->get();
    	foreach ($products as $p) {
    		# code...
    		array_push($productArr,$p->product_id);
    	}
    	return array_values($productArr);
    }

    public function saveLocalPrice(Request $r)
    {
    	$ret=array();
        $data=DB::table('opos_productpreference')
		        ->where("product_id",$r->product_id)        
		        ->where("terminal_id",$r->terminal_id)  
		        ->whereNull("deleted_at")
		        ->update([
		            "updated_at"=>Carbon::now(),
		            "local_price"=>$r->local_price
		        ]);

		$ret["status"]="success";
        $ret["data"]=$data;
        return response()->json($ret);

    }

    public function XXgetBranchSales(Request $request)
    {
    	$reports = DB::table("opos_receipt")
			        ->join("opos_receiptproduct","opos_receiptproduct.receipt_id","=","opos_receipt.id")
			        ->join('opos_locationterminal','opos_receipt.terminal_id','=','opos_locationterminal.terminal_id')
			        ->join('fairlocation','fairlocation.id','=','opos_locationterminal.location_id')
			        ->leftJoin('opos_servicecharge','opos_servicecharge.id','=','opos_receiptproduct.servicecharge_id')
			        ->leftJoin('users as usercheck','usercheck.id','=','opos_receipt.staff_user_id')
			        ->leftJoin('opos_servicecharge as sc','sc.id','=','opos_receipt.servicecharge_id')
					->select('sc.value',
						DB::raw(
			           "SUM(opos_receiptproduct.quantity*(opos_receiptproduct.price)) as amount"
						),
						"sc.value as servicecharge",
			            DB::raw(
			                "SUM((opos_receiptproduct.quantity*opos_receiptproduct.price*opos_receiptproduct.discount)/100) as discount")
			        );

		$reports = $reports->whereRaw('opos_receipt.status IN ("completed","voided")')
						   ->whereNull("opos_receipt.deleted_at")
						   ->whereRaw('fairlocation.id = '.$request->id);

        $report1 = $reports->toSql();
        $report2 = $reports->toSql();

        $monthlyAmount = DB::select($report2.' and opos_receipt.created_at like "'.
			date('Y-m',strtotime(Carbon::today())).'%" GROUP BY opos_receipt.id');
        
        $todayAmount = DB::select($report1.' and opos_receipt.created_at like "'.
			date('Y-m-d',strtotime(Carbon::today())).'%" GROUP BY opos_receipt.id');

        foreach ($monthlyAmount as $r) {
        	$r->amount = $r->amount - $r->discount;
			$scharge = $r->amount * (($r->value)/100);
        	$r->amount = $r->amount + $scharge; 
        }

        foreach ($todayAmount as $r) {
        	$r->amount = $r->amount - $r->discount;
			$scharge = $r->amount * (($r->value)/100);
        	$r->amount = $r->amount + $scharge; 
        }

    	$cash=$this->getbalance(null,"cash",$request->id);
		$creditcard=$this->getbalance(null,"creditcard",$request->id);

		$otherpoints = DB::table('opos_receipt')
						->join('opos_locationterminal','opos_receipt.terminal_id','=','opos_locationterminal.terminal_id')
				        ->join('fairlocation','fairlocation.id','=','opos_locationterminal.location_id')
						 ->select(DB::raw("SUM(opos_receipt.otherpoints) as otherpoints"))
			   			 ->whereRaw('opos_receipt.status IN ("completed","voided")')
			   			 ->whereRaw('Date(opos_receipt.created_at) = CURDATE()')
			   			 ->whereRaw('fairlocation.id = '.$request->id)
			   			 ->first();

		$currency= DB::table('currency')->where('active', 1)->first()->code;

		$location = $request->location;

		return view('opposum.trunk.branchsales')
				->with('cash',				$cash)
				->with('creditcard',		$creditcard)
				->with('otherpoints',		$otherpoints)
				->with('currency',			$currency)
				->with('todayAmount',		$todayAmount)
				->with('location',			$location)
				->with('monthlyAmount',		$monthlyAmount)
				;
    }

    public function is_eod($terminal_id)
    {
		Log::debug('***** is_eod('.$terminal_id.') *****');

    	$terminal=DB::table('opos_terminal')
    	->where('id',$terminal_id)->first();

    	$start=$terminal->start_work;
    	$period="today";
    	// decide today or tomorrow.
    	// if time is more than curren time then tomorrow ,else today
    	// Convert it to timestamp
    	$current_time=time();
    	if ($current_time > strtotime($start)) {
   			$period="tomorrow";
		}
		$start_time=strtotime($start);
		
		if ($period=="tomorrow") {
			$start_time=strtotime("+1 day",$start_time);
		}

		

    	$last_eod=DB::table('opos_logterminal')
    	->where('terminal_id',$terminal_id)
    	->whereNull('deleted_at')
    
    	->orderBy("id","DESC")
    	->first();
    	
    	//dump($last_eod);
    	$last_eod_time=null;
    	if (!empty($last_eod)) {
    		$last_eod_time=strtotime($last_eod->eod);
    	}
    	$d=new DateTime;
    	//fdump(($start_time-$last_eod_time));
    	//dump(compact('period','last_eod_time','current_time','start_time'));
    	$ret="ok";
    	
    	
    	if (!empty($last_eod)&& ($start_time-$last_eod_time<(24*3600))&&$current_time>$last_eod_time and $current_time<$start_time ) {
    		$ret= "eod";
    	}
    
    	return $ret;

    }
}
