<?php
namespace App\Http\Controllers;

use App;
use App\Classes\Delivery;
use App\AuthenticateUser;
use App\Models\Autolink;
use App\Http\Requests\OpenwishPledgeRequest;
use App\Jobs\OpenwishPledgeJob;
use App\Models\Address;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Brand;
use App\Models\SubCatLevel1;
use App\Models\SubCatLevel2;
use App\Models\SubCatLevel3;
use App\Models\Buyer;
use App\Models\BuyerCategory;
use App\Models\Credit;
use App\Models\Courier;
use App\Models\Currency;
use App\Models\Director;
use App\lib\Date;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\OpenWish;
use App\Models\OpenWishPledge;
use App\Models\Product;
use App\Models\SMMin;
use App\Models\SMMout;
use App\Models\User;
use App\Models\Website;
use App\Models\HumanCap;
use App\Models\Document;
use App\Models\MerchantDocument;
use App\Models\StationDocument;
use App\Models\Occupation;
use App\Models\Language;
use App\Models\Station;
use App\Models\StationBrand;
use App\Models\MerchantBrand;
use App\Models\RoleUser;
use App\Models\Sproperty;
use App\Models\Districenter;
use App\Models\StationAddress;
use App\Models\Outlet;
use App\Models\OrderProduct;
use App\Http\Controllers\UrlShortenerController;
use App\Http\Controllers\EmailController;
use Exception;
use Log;
use Input;
use App\OWish;
use Collection;
use GuzzleHttp;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Jobs\WishListJob;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
//use Moltin\Cart\Cart;
use Cart;
use URL;
use Hash;
use Mailgun\Mailgun;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use Redirect;

// Helper
// function curl_get_file_contents($URL) {
//         $c = curl_init();
//         curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($c, CURLOPT_URL, $URL);
//         $contents = curl_exec($c);
//         $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
//         curl_close($c);
//         if ($contents) return $contents;
//         else return FALSE;
// }

// Helper

class UserController extends BaseController
{

    var $indication = null; // is indication for merchant or buyer
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		/* $value=Hash::make('navneet');	
        echo $value; */
    }



    // public function editbuyerinfo()

    // {
    //     $languages=DB::table('language')->get();
    //     $occupations=DB::table('occupation')->get();
    //     $interests=DB::table('category')->get();
    //     $banks=DB::table('bank')->get();
    //     $user_id= Auth::user()->id;
    //     $user= User::where('id',$user_id)->first();
    //     $billing_address= Address::where(['id'=>$user->billing_address_id])->get()[0];//ba

    //     $default_address= Address::where(['id'=>$user->default_address_id])->get()[0]; //da
    //     $card= Credit::where('user_id',$user_id)->first();
    //     $bankaccount_id= Buyer::where('user_id',$user_id)->pluck('bankaccount_id');
    //     $paypal=Buyer::where('user_id',$user_id)->pluck('paypal_email');
    //      //Might not be the best way

    //     $banka= BankAccount::where('id',$bankaccount_id)->first();
    //      $bank_all= DB::table('bank')->where('id' ,$banka->bank_id)->first();
    //     // return $bank_code;

    //     return view('editbuyerinfo',['bank_all'=>$bank_all,'paypal'=>$paypal,'banka'=>$banka,'bid'=>$bankaccount_id,'card'=>$card,'def'=>$default_address,'bill'=>$billing_address,'user'=>$user,'languages'=>$languages,'occupations'=>$occupations,'interests'=>$interests,'banks'=>$banks]);
    // }


	public function getJsonUsers(){
        $user_id= Auth::id();
        $merchant = DB::table('merchant')->where('user_id',$user_id)->first()->id;
		$users = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('autolink','users.id','=','autolink.initiator')->where('autolink.responder',$merchant)->where('autolink.status','linked')->get();
		$i = 0;
		$userarr = null;
		foreach($users as $user) {
			$userarr[$i]['name'] = "[" . str_pad($user->id, 10, '0', STR_PAD_LEFT) . "] - " . $user->first_name . " " . $user->last_name;
            $userarr[$i]['id'] = "[" . str_pad($user->id, 10, '0', STR_PAD_LEFT) . "]";
            $userarr[$i]['justid'] = $user->id;
            $userarr[$i]['username'] = $user->first_name . " " . $user->last_name;
			$i++;
		}
        // dd (json_encode($userarr));
		return json_encode($userarr);
	}

	public function getJsonUsersid(){
        $user_id= Auth::id();
        $merchant = DB::table('merchant')->where('user_id',$user_id)->first()->id;
        $users = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('autolink','users.id','=','autolink.initiator')->where('autolink.responder',$merchant)->where('autolink.status','linked')->get();
		$i = 0;
		$userarr = null;
		foreach($users as $user) {
			$userarr[$i]['name'] = "[" . str_pad($user->id, 10, '0', STR_PAD_LEFT) . "]";
			$userarr[$i]['id'] = $user->id;
			$userarr[$i]['username'] = $user->first_name . " " . $user->last_name;
			$i++;
		}		
		return json_encode($userarr);
	}
	
	public function getJsonUsersidnom(){
        $users = DB::table('users')->get();
		$i = 0;
		$userarr = null;
		foreach($users as $user) {
			$userarr[$i]['name'] = "[" . str_pad($user->id, 10, '0', STR_PAD_LEFT) . "] - " . $user->first_name . " " . $user->last_name;
			$userarr[$i]['id'] = $user->id;
			$userarr[$i]['username'] = $user->first_name . " " . $user->last_name;
			$i++;
		}	
		return json_encode($userarr);
	}	
	
	public function getJsonUsersidnomrec(){
		$users_ss = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('sales_staff','users.id','=','sales_staff.user_id')->where('sales_staff.type','=','str');
		$users_mc = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('sales_staff','users.id','=','sales_staff.user_id')->where('sales_staff.type','=','mct');
        $users = DB::table('users')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('employee','users.id','=','employee.user_id')->union($users_ss)->union($users_mc)->get();
		$i = 0;
		$userarr = null;
		foreach($users as $user) {
			$userarr[$i]['name'] = "[" . str_pad($user->id, 10, '0', STR_PAD_LEFT) . "] - " . $user->first_name . " " . $user->last_name;
			$userarr[$i]['id'] = $user->id;
			$userarr[$i]['username'] = $user->first_name . " " . $user->last_name;
			$i++;
		}	
		return json_encode($userarr);
	}	

	public function getJsonBuyerid(){
		$users = DB::table('buyer')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('users','users.id','=','buyer.user_id')->get();
		$i = 0;
		$userarr = null;
		foreach($users as $user) {
			$userarr[$i]['name'] = "[" . str_pad($user->id, 10, '0', STR_PAD_LEFT) . "]" . " - " . $user->first_name . " " . $user->last_name;
			$userarr[$i]['id'] = $user->id;
			$userarr[$i]['uid'] = $user->user_id;
			$i++;
		}	
		return json_encode($userarr);
	}

	public function getJsonMerchantid($id){
		$staff = DB::table('sales_staff')->where('user_id',$id)->where('type','mct')->first();
		$users = DB::table('merchant')->where('mc_sales_staff_id',$staff->id)->where('mcp1_sales_staff_id','0')->get();
		$i = 0;
		$userarr = null;
		foreach($users as $user) {
			$userarr[$i]['name'] = "[" . str_pad($user->id, 10, '0', STR_PAD_LEFT) . "]" . " - " . $user->oshop_name;
			$userarr[$i]['id'] = $user->id;
			$i++;
		}		
		return json_encode($userarr);
	}

	public function deleteaccount(Request $request){
		$uid = $request->get('uid');
		$deleteaccount = DB::table('buyer')->where('user_id',$uid)->update(array('closed_date' => date('Y-m-d H:i:s'), 'status'=>'closed'));
		$rand = rand();
		$deletepass = DB::table('users')->where('id',$uid)->update(array('password' => $rand));
		Auth::logout();

		return json_encode("OK");

	}

    public function sendmp(Request $request){
        $merchant_link = $request->get('merchant_link');
        $mp1_link = $request->get('mp1_link');
        $mp2_link = $request->get('mp2_link');
		$user_id= Auth::id();
		$user1 = DB::table('sales_staff')->where('user_id',$mp1_link)->where('type','mcp')->count();
		if($user1==0){
			$staff1 = DB::table('sales_staff')->insertGetId(array('user_id' => $mp1_link, 'type'=>'mcp','recruiter_user_id'=>$user_id,'target_station'=>0,'target_merchant'=>0,'target_revenue'=>0,'commission'=>0,'commission'=>0,'bonus'=>0,'status'=>'active','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')));
		} else {
			$user1 = DB::table('sales_staff')->where('user_id',$mp1_link)->where('type','mcp')->first();
			$staff1 = $user1->id;
			$user1 = DB::table('sales_staff')->where('user_id',$mp1_link)->where('type','mcp')->update(array('status' => 'active'));
		}
		$staff2 = 0;
		if($mp2_link > 0){
			$user2 = DB::table('sales_staff')->where('user_id',$mp2_link)->where('type','mcp')->count();
			if($user2==0){
				$staff2 = DB::table('sales_staff')->insertGetId(array('user_id' => $mp2_link, 'type'=>'mcp','recruiter_user_id'=>$user_id,'target_station'=>0,'target_merchant'=>0,'target_revenue'=>0,'commission'=>0,'commission'=>0,'bonus'=>0,'status'=>'active','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')));
			} else {
				$user2 = DB::table('sales_staff')->where('user_id',$mp2_link)->where('type','mcp')->first();
				$staff2 = $user2->id;
				$user2 = DB::table('sales_staff')->where('user_id',$mp2_link)->where('type','mcp')->update(array('status' => 'active'));
			}
		}
		$staff = DB::table('merchant')->where('id',$merchant_link)->update(array('mcp1_sales_staff_id' => $staff1,'mcp2_sales_staff_id' => $staff2));
		return json_encode($staff);
    }

    public function getSharedPosts($object_id)
    {
        $fb = new Facebook(Config::get('facebook.credentials'));
        $access_token = Auth::user()->access_token;


    }

    public function merchantInformation()
    {
        $userModel = null;

        if(Auth::check()) {
            $u = Auth::user();
            $dateObj = new Date();
            $userObj = new User();
            $userModel = $userObj->with('merchant', 'occupation', 'merchant.address', 'merchant.address.city')->where('id', '=', $u->id)->get()->first();
            $userModel->age = $dateObj->age(new DateTime($u->birthdate), null, true);

        }
        return view('merchantInformation', compact(['userModel']));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            $message_type="error";
            $message="Please logout to use the service";
        }
        $indication = "buyer";
        $disabled =  'null';

        //return view('user/registerMerchant',compact(['indication','disabled']));
        return view('buyerregistration',compact(['indication','disabled']));
    }

    public function createFairMode()
    {

        $canregister = false;
        if(!Auth::check()){
            $canregister = true;
        } else {
            $canregister = true;
            $role= DB::table('role_users')->where('user_id',Auth::user()->id)->join('roles', 'roles.id', '=', 'role_users.role_id')->get();
            foreach ($role as $userrole) {
                if($userrole->name == "merchant"){
                    $canregister = false;
                }
            }

        }
       if($canregister) {
            $merchantObj = new Merchant();
            $indication = "merchant";
            $disabled = 'null';
            $userModel = $merchantObj->getMerchantRelationsFullMeta();
            $route = route('create-new-user-p');
            $brand_table = Brand::orderBy('name')->get();
            $subcat_table1 = SubCatLevel1::orderBy('description')->get();
			$subcats = DB::select(DB::raw(
				"SELECT id, description, levelsub FROM (
					SELECT id, description, '1' as levelsub FROM subcat_level_1
					UNION
					SELECT id, description, '2' as levelsub FROM subcat_level_2
					UNION
					SELECT id, description, '3' as levelsub FROM subcat_level_3
				) as T ORDER BY description"
			));			
            $subcat_table2 = SubCatLevel2::orderBy('description')->get();
            $subcat_table3 = SubCatLevel3::orderBy('description')->get();
			$subcats = DB::select(DB::raw(
				"SELECT id, description, levelsub FROM (
					SELECT id, description, '1' as levelsub FROM subcat_level_1
					UNION
					SELECT id, description, '2' as levelsub FROM subcat_level_2
					UNION
					SELECT id, description, '3' as levelsub FROM subcat_level_3
				) as T ORDER BY description"
			));
            $isbrand = false;
			$oshops = null;
            // return $userModel;
			$edit = true;
			$logistic_id = null;
			$editing = 0;
			$type_merchant = 'fairmode';
			 
            return view('user/registerMerchant', compact(['indication', 'type_merchant', 'humancap', 'logistic_id','route', 'edit','editing', 'disabled', 'userModel', 'oshops','brand_table', 'subcat_table1','subcats', 'subcat_table2', 'subcat_table3', 'isbrand']));

        }
        else
        {
            return redirect()->route('home');
        }
    }		
	
    public function createHumancap()
    {

        $canregister = false;
        if(!Auth::check()){
            $canregister = true;
        } else {
            $canregister = true;
            $role= DB::table('role_users')->where('user_id',Auth::user()->id)->join('roles', 'roles.id', '=', 'role_users.role_id')->get();
            foreach ($role as $userrole) {
                if($userrole->name == "merchant"){
                    $canregister = false;
                }
            }

        }
       if($canregister) {
            $merchantObj = new Merchant();
            $indication = "merchant";
            $disabled = 'null';
            $userModel = $merchantObj->getMerchantRelationsFullMeta();
            $route = route('create-new-user-p');
            $brand_table = Brand::orderBy('name')->get();
            $subcat_table1 = SubCatLevel1::orderBy('description')->get();
			$subcats = DB::select(DB::raw(
				"SELECT id, description, levelsub FROM (
					SELECT id, description, '1' as levelsub FROM subcat_level_1
					UNION
					SELECT id, description, '2' as levelsub FROM subcat_level_2
					UNION
					SELECT id, description, '3' as levelsub FROM subcat_level_3
				) as T ORDER BY description"
			));			
            $subcat_table2 = SubCatLevel2::orderBy('description')->get();
            $subcat_table3 = SubCatLevel3::orderBy('description')->get();
			$subcats = DB::select(DB::raw(
				"SELECT id, description, levelsub FROM (
					SELECT id, description, '1' as levelsub FROM subcat_level_1
					UNION
					SELECT id, description, '2' as levelsub FROM subcat_level_2
					UNION
					SELECT id, description, '3' as levelsub FROM subcat_level_3
				) as T ORDER BY description"
			));
            $isbrand = false;
			$oshops = null;
            // return $userModel;
			$edit = true;
			$logistic_id = null;
			$editing = 0;
			$type_merchant = 'humancap';
			 
            return view('user/registerMerchant', compact(['indication', 'type_merchant', 'logistic_id','route', 'edit','editing', 'disabled', 'userModel', 'oshops','brand_table', 'subcat_table1','subcats', 'subcat_table2', 'subcat_table3', 'isbrand']));

        }
        else
        {
            return redirect()->route('home');
        }
    }	
	
    public function createMerchant()
    {
        $canregister = false;
        if(!Auth::check()){
            $canregister = true;
        } else {
            $canregister = true;
            $role= DB::table('role_users')->where('user_id',Auth::user()->id)->join('roles', 'roles.id', '=', 'role_users.role_id')->get();
            foreach ($role as $userrole) {
                if($userrole->name == "merchant"){
                    $canregister = false;
                }
            }

        }
       if($canregister) {
            $merchantObj = new Merchant();
            $indication = "merchant";
            $disabled = 'null';
            $userModel = $merchantObj->getMerchantRelationsFullMeta();
            /*Add contactemail*/
            $userModel['contactemail']=null;
            if (Auth::check()) {
                              
                $userModel['contactemail']=DB::table('contactemail')->join('merchantcontactemail','merchantcontactemail.contactemail_id','=','contactemail.id')
                ->join('merchant','merchantcontactemail.merchant_id','=','merchant.id')
                ->join('users','users.id','=','merchant.user_id')
                ->get();
            } 
            $route = route('create-new-user-p');
            $brand_table = Brand::orderBy('name')->get();
            $subcat_table1 = SubCatLevel1::orderBy('description')->get();
			$subcats = DB::select(DB::raw(
				"SELECT id, description, levelsub FROM (
					SELECT id, description, '1' as levelsub FROM subcat_level_1
					UNION
					SELECT id, description, '2' as levelsub FROM subcat_level_2
					UNION
					SELECT id, description, '3' as levelsub FROM subcat_level_3
				) as T ORDER BY description"
			));			
            $subcat_table2 = SubCatLevel2::orderBy('description')->get();
            $subcat_table3 = SubCatLevel3::orderBy('description')->get();
			$subcats = DB::select(DB::raw(
				"SELECT id, description, levelsub FROM (
					SELECT id, description, '1' as levelsub FROM subcat_level_1
					UNION
					SELECT id, description, '2' as levelsub FROM subcat_level_2
					UNION
					SELECT id, description, '3' as levelsub FROM subcat_level_3
				) as T ORDER BY description"
			));
            $isbrand = false;
			$oshops = null;
            // return $userModel;
			$edit = true;
			$logistic_id = null;
			$editing = 0;
			$type_merchant = 'merchant';
            return view('user/registerMerchant', compact(['indication','type_merchant', 'logistic_id','route', 'edit','editing', 'disabled', 'userModel', 'oshops','brand_table', 'subcat_table1','subcats', 'subcat_table2', 'subcat_table3', 'isbrand']));

        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function getMasterEditMerchant()
    {
        $id = \Input::get('id');

        $indication = "merchant";
        $disabled = 'disabled';
        $route = route('edit-merchant');
        // User,Bank,Address,Merchant,Brand,Website, and Director
        $userObj = new User();

        $userModel = $userObj->with(['merchant', 'merchant.bankaccount', 'merchant.address', 'merchant.brand', 'merchant.websites','merchant.socialmedia', 'merchant.directorsInEditView'])->where('id', '=', $id)->get()->first();

        $userModel = $this->reShapeMasterMerchantModel($userModel, $id);


        $mer_doc = MerchantDocument::all();
		//dd();
        $doc = Document::all();

        // By default it is type Collection
            $brand_table = Brand::orderBy('name')->get();
            $subcat_table1 = SubCatLevel1::orderBy('description')->get();
            $subcat_table2 = SubCatLevel2::orderBy('description')->get();
            $subcat_table3 = SubCatLevel3::orderBy('description')->get();	
			$subcats = DB::select(DB::raw(
				"SELECT id, description, levelsub FROM (
					SELECT id, description, '1' as levelsub FROM subcat_level_1
					UNION
					SELECT id, description, '2' as levelsub FROM subcat_level_2
					UNION
					SELECT id, description, '3' as levelsub FROM subcat_level_3
				) as T ORDER BY description"
			));
        $bank= $userModel;
        // return $bank;
        $isbrand = true;

        $merchant_id = $userModel['merchant'][0]['id'];
            $merchantAddress = null;
            $bankDetails = null;
            $property = null;
            if (isset($merchant_id)) {
                $address_id = Merchant::where('id', $merchant_id)->first()->oshop_address_id;
                $merchantAddress = Address::find($address_id);

                // $bankaccount_id = Station::where('id', $station_id)->first()->bankaccount_id;
                // $bankDetails = BankAccount::find($bankaccount_id);
                // $bankDetails->name = Bank::where('id', $bankDetails->bank_id)->first()->name;

                // $property = Sproperty::where('station_id', $station_id)->first();
                // $property->outlet = Outlet::find($property->outlet_id)->name;
            }

        return view('category', compact(['merchantAddress','indication', 'route', 'disabled', 'userModel', 'mer_doc', 'doc', 'brand_table', 'subcat_table1','subcats', 'subcat_table2', 'subcat_table3', 'isbrand']));
    }

    public function reShapeMasterMerchantModel($merchantModel, $id)
    {
        $user_id= $id;
        $merchant1= Merchant::where('user_id',$user_id)->first();
        if (is_null($merchant1)) {
            return view("common.generic")
            ->with('message_type','error')
            ->with('message','Merchant record missing');
        } else {
            # code...
        }
        

        // dd($merchant1);
        $mid= $merchant1->id;


        $merchantObj = new Merchant();
        $userModel = $merchantObj->getMerchantRelationsFullMeta();

		$bankaccount_id= $merchant1->bankaccount_id;

		$bank= BankAccount::where('id',$bankaccount_id)->get();

        $merchant =  isset($merchantModel['merchant'] ) ?  $merchantModel['merchant'] : null;

        $address =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['address'] ) ?  [$merchantModel['merchant'][0]['address']] : null):null;
        // $brand =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['brand'] ) ?  $merchantModel['merchant'][0]['brand'] : null):null;

        // return $mid;
        $brand_raw= DB::table("merchantbrand")->where('merchant_id',$mid)->get();
        $brand_id_array=array();
        foreach ($brand_raw as $b) {
            # code...
            array_push($brand_id_array, $b->id);
        }
        $brand=Brand::whereIn('id',$brand_id_array)->get();
        // return $brand;
        $websites =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['websites'] ) ?  $merchantModel['merchant'][0]['websites'] : null):null;
        $social_media =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['socialmedia'] ) ?  $merchantModel['merchant'][0]['socialmedia'] : null):null;

        $directors =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['directorsInEditView'] ) ?  $merchantModel['merchant'][0]['directorsInEditView'] : null):null;
        // return $brand;
        $merchantArr = null;
        $bankArr = null;
        $addressArr = null;
        $brandArr = null;
        $websitesArr = null;
        $socialmediaArr = null;
        $directorsArr = null;

        if(!is_null( $merchant))
        foreach($merchant as $data)
        {
            $merchantArr[]=[
                "id" => isset($data->id) ?  $data->id: null,
                "user_id" => isset($data->user_id) ?  $data->user_id: null,
                "company_name" =>
                    isset($data->company_name) ?$data->company_name  : null,
                "gst" => isset($data->gst) ? $data->gst : null,
                "business_reg_no" =>
                    isset($data->business_reg_no) ? $data->business_reg_no : null,
                "country_id" => isset($data->country_id) ? $data->country_id : null,
                "business_type" =>
                    isset($data->business_type) ? $data->business_type : null,
                "address_id" =>
                    isset($data->address_id) ?  $data->address_id: null,
                "contact_person" =>
                    isset($data->contact_person) ?  $data->contact_person: null,
                "office_no" => isset($data->office_no) ?  $data->office_no: null,
                "mobile_no" => isset($data->mobile_no) ?  $data->mobile_no: null,
                "oshop_name" => isset($data->oshop_name) ? $data->oshop_name : null,
                "oshop_logo_1" =>
                    isset($data->oshop_logo_1) ? $data->oshop_logo_1 : null,
                "oshop_logo_2" =>
                    isset($data->oshop_logo_2) ?  $data->oshop_logo_2: null,
                "oshop_logo_3" =>
                    isset($data->oshop_logo_3) ?  $data->oshop_logo_3: null,
                "oshop_logo_4" =>
                    isset($data->oshop_logo_4) ? $data->oshop_logo_4 : null,
                "oshop_logo_5" =>
                    isset($data->oshop_logo_5) ?  $data->oshop_logo_5: null,
                "oshop_adimage_1" =>
                    isset($data->oshop_adimage_1) ? $data->oshop_adimage_1: null,
                "oshop_adimage_2" =>
                    isset($data->oshop_adimage_2) ? $data->oshop_adimage_2: null,
                "oshop_adimage_3" =>
                    isset($data->oshop_adimage_3) ?  $data->oshop_adimage_3: null,
                "oshop_adimage_4" =>
                    isset($data->oshop_adimage_4) ? $data->oshop_adimage_4 : null,
                "oshop_adimage_5" =>
                    isset($data->oshop_adimage_5) ? $data->oshop_adimage_5 : null,
                "description" =>
                    isset($data->description) ? $data->description : null,
                "history" => isset($data->history) ?  $data->history: null,
                "license" => isset($data->license) ?  $data->license: null,
                "coverage" => isset($data->coverage) ? $data->coverage : null,
                "ownership" => isset($data->ownership) ? $data->ownership : null,
                "all_own_delivery" => isset($data->all_own_delivery) ? $data->all_own_delivery : null,
                "all_system_delivery" => isset($data->all_system_delivery) ? $data->all_system_delivery : null,
                "category_id" =>
                    isset($data->category_id) ? $data->category_id : null,
                "planned_sales" =>
                    isset($data->planned_sales) ? $data->planned_sales : null,
                "bank_id" => isset($data->bank_id) ? $data->bank_id : null,
                "return_policy" => isset($data->return_policy) ? $data->return_policy : null,
                "note" => isset($data->note) ? $data->note : null,
                "deleted_at" => isset($data->deleted_at) ? $data->deleted : null,
                "created_at" => isset($data->created_at) ?  $data->created_at: null,
                "updated_at" => isset($data->updated_at) ?  $data->updated_at: null
            ];
        }


        if(!is_null($bank))
        foreach($bank  as $data)
        {
            // $b= BankAccount::find($data);
            $b=Bank::where('id',$data->bank_id)->first();

            $bankArr[] = [
            "id" => isset($data->id) ? $data->id: null,
            "name" => isset($b->name) ? $b->name : null,
            "code" => isset($b->code) ? $b->code : null,
            "account_name1" => isset($data->account_name1) ? $data->account_name1: null,
            "account_number1" => isset($data->account_number1) ? $data->account_number1: null,
            "account_name2" => isset($data->account_name2) ? $data->account_name2: null,
            "account_number2" => isset($data->account_number2) ? $data->account_number2: null,
            "iban" => isset($data->iban) ?$data->iban: null,
            "swift" => isset($data->swift) ?$data->swift: null,
            "url" => isset($data->url) ?$data->url: null,
            "description" => isset($data->description) ?$data->description: null,
            "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
            "created_at" => isset($data->created_at) ?$data->created_at: null,
            "updated_at" => isset($data->updated_at) ?$data->updated_at: null
        ];
        }

        if(!is_null($address))
        foreach($address  as $data)
        {
            $addressArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "city_id" => isset($data->city_id) ?$data->city_id: null,
                "postcode" => isset($data->postcode) ?$data->postcode: null,
                "line1" => isset($data->line1) ?$data->line1: null,
                "line2" => isset($data->line2) ?$data->line2: null,
                "line3" =>isset($data->line3) ?$data->line3: null,
                "line4" => isset($data->line4) ?$data->line4: null,
                "type" => isset($data->type) ?$data->type: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null
            ];
        }

         if(!is_null($brand))
        foreach($brand  as $data)
        {
            $brandArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "name" => isset($data->name) ?$data->name: null,
                "description" => isset($data->description) ?$data->description: null,
                "logo" => isset($data->logo) ?$data->logo: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null
            ];
        }


        if(!is_null($websites))
        foreach($websites  as $data)
        {
            $websitesArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "name" => isset($data->name) ?$data->name: null,
                "type" => isset($data->type) ?$data->type: null,
                "description" => isset($data->description) ?$data->description: null,
                "url" => isset($data->url) ?$data->url: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null
            ];
        }

        if(!is_null($social_media))
        foreach($social_media  as $data)
        {
            $socialmediaArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "name" => isset($data->name) ?$data->name: null,
                "description" => isset($data->description) ?$data->description: null,
                "url" => isset($data->url) ?$data->url: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null
            ];
        }

        if(!is_null($directors))
        foreach($directors  as $data)
        {
            $doc = DB::table('directordocument')
                ->join('document','document.id','=','directordocument.document_id')
                ->where('directordocument.director_id',$data->id)
                ->first();
            $directorsArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "merchant_id" => isset($data->merchant_id) ?$data->merchant_id: null,
                "country_id" => isset($data->country_id) ?$data->country_id: null,
                "name" => isset($data->name) ?$data->name: null,
                "nric" => isset($data->nric) ?$data->nric: null,
                "photo_1" => isset($data->photo_1) ?$data->photo_1: null,
                "photo_2" => isset($data->photo_2) ?$data->photo_2: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null,
                "doc" => isset($doc->path)?$doc->path:null,
                "document_id" => isset($doc->document_id)?$doc->document_id:null
            ];
        }
		
        $userModel = [
          "user" =>[
            "id" => isset($merchantModel['id']) ? $merchantModel['id'] : null ,
            "occupation_id" => isset($merchantModel['occupation_id']) ? $merchantModel['occupation_id'] : null ,
            "first_name" => isset($merchantModel['first_name']) ? $merchantModel['first_name'] : null ,
            "last_name" =>  isset($merchantModel['last_name']) ? $merchantModel['last_name'] : null,
            "birthdate" => isset($merchantModel['birthdate']) ? $merchantModel['birthdate'] : null ,
            "mobile_no" => isset($merchantModel['mobile_no']) ? $merchantModel['mobile_no'] : null ,
            "email" =>  isset($merchantModel['email']) ? $merchantModel['email'] : null,
            "password" => isset($merchantModel['password']) ? $merchantModel['password'] : null ,
            "gender" =>  isset($merchantModel['gender']) ?  $merchantModel['gender']: null,
            "annual_income" => isset($merchantModel['annual_income']) ?$merchantModel['annual_income']  : null,
            "salutation" =>  isset($merchantModel['salutation']) ? $merchantModel['salutation'] : null,
            "type" =>  isset($merchantModel['type']) ? $merchantModel['type'] : null,
            "deleted_at" =>  isset($merchantModel['deleted_at']) ?  $merchantModel['deleted_at']: null,
            "created_at" => isset($merchantModel['created_at']) ? $merchantModel['created_at'] : null,
            "updated_at" => isset($merchantModel['updated_at']) ?  $merchantModel['updated_at']: null
            ],
          "merchant" => $merchantArr,
          "bank" => $bankArr,
          "address" =>$addressArr,
          "brand" =>$brandArr,
          "websites" =>$websitesArr ,
          "socialmedia"=>$socialmediaArr,
          "directorsInEditView" => $directorsArr
        ];

        return $userModel;
    }

    public function getEditMerchant($pmerchant_id = null)
    {
		Log::debug('*****getEditMerchant('.$pmerchant_id.') *****');

        if(Auth::check()) {
            $indication = "merchant";
            $disabled = 'disabled';
            $route = route('edit-merchant');

			/* Really screwed up bug */
            //$route = route('sellermembers');

            $doc = array();
            // User,Bank,Address,Merchant,Brand,Website, and Director
            $userObj = new User();

            if ($pmerchant_id == null) {
				$user_id= Auth::user()->id;
				$merchant1= Merchant::where('user_id',$user_id)->first();

				Log::debug('***** merchant1 *****');
				Log::debug($merchant1);
				Log::debug('***** user_id *****');
				Log::debug($user_id);

                $userModel = $userObj->with([
					'merchant', 'merchant.bankaccount', 'merchant.address',
					'merchant.brand', 'merchant.websites', 'merchant.directorsInEditView'
				])->where('id', '=', Auth::user()->id)->get()->first();

                $userModel = $this->reShapeMerchantModel($userModel,$merchant1);
                $userModel['socialmedia']=array();
				$userModel['approval']=array();		
				$aprsections = DB::table('aprsection')->where('type','merchant')->get();
				foreach($aprsections as $aprsection){
					$getstatus = DB::table('aprchecklist')->
						where('merchant_id',$merchant1->id)->
						where('aprsection_id',$aprsection->id)->
						first();

					$status = "";
					if(!is_null($getstatus)){
						$status = $getstatus->status;
					}
					$userModel['approval'][$aprsection->name] = $status;
				}
				$edit = true;
				$editing = 1;
				$selluser = User::find($user_id);

            } else {
				$mymerchant = Merchant::where('id', $pmerchant_id)->first();
				if(!is_null($mymerchant)){
					$route = URL::to('/sellermembers',$mymerchant->user_id);
					$userModel = $userObj->with([
						'merchant', 'merchant.bankaccount', 'merchant.address',
						'merchant.brand', 'merchant.websites',
						'merchant.directorsInEditView'])->
						where('id', '=', $mymerchant->user_id)->get()->first();

					$userModel = $this->reShapeMerchantModel($userModel, $mymerchant);
					$userModel['socialmedia']=array();
					$userModel['approval']=array();		
					$aprsections = DB::table('aprsection')->where('type','merchant')->get();
					foreach($aprsections as $aprsection){
						$getstatus = DB::table('aprchecklist')->
							where('merchant_id',$pmerchant_id)->
							where('aprsection_id',$aprsection->id)->first();

						$status = "";
						if(!is_null($getstatus)){
							$status = $getstatus->status;
						}
						$userModel['approval'][$aprsection->name] = $status;
					}
					$edit = false;
					$user_id = $mymerchant->user_id;
					$editing = 1;
					$role= DB::table('role_users')->
						where('user_id',Auth::user()->id)->
						join('roles', 'roles.id', '=', 'role_users.role_id')->get();
					
					foreach ($role as $userrole) {
						if($userrole->name == "adminstrator"){
							$edit = true;
							$editing = 1;
						}
					}	
					$selluser = User::find($user_id);
					//dd($theuser->hasRole('mer'));					
				} else {
					\Session::flash(Config::get('messages.key.name'),
						$this->messageHandler->
						error('popupMerchantError', null, null,null, true, true, true));

					return redirect()->back();
				}
	            
			}
			
			$merchant_id = $userModel['merchant'][0]['id'];
			$logistic_id = null;
			
			//$station = DB::table('station')->join('logistic','logistic.station_id','=','station.id')->where('station.user_id',$user_id)->select('logistic.id as lid')->first();

			if($userModel['merchant'][0]['own_delivery_logistic_id'] > 0){
				$logistic_id = $userModel['merchant'][0]['own_delivery_logistic_id'];
			}
            $mer_doc = MerchantDocument::where('merchant_id',$merchant_id )->
				join('document','merchantdocument.document_id','=','document.id')->get();

			//dd($mer_doc);
            if(isset($mer_doc)){
                $count = count($mer_doc);
                for ($i=0; $i < $count ; $i++) {
                    $doc[$i] = Document::where('id', $mer_doc[$i]->document_id)->first();
                }
            }

            // By default it is type Collection
            $brand_table = Brand::orderBy('name')->get();
            $subcat_table1 = SubCatLevel1::orderBy('description')->get();
			$subcats = DB::select(DB::raw(
				"SELECT id, description, levelsub FROM (
					SELECT id, description, '1' as levelsub FROM subcat_level_1
					UNION
					SELECT id, description, '2' as levelsub FROM subcat_level_2
					UNION
					SELECT id, description, '3' as levelsub FROM subcat_level_3
				) as T ORDER BY description"
			));			
            $subcat_table2 = SubCatLevel2::orderBy('description')->get();
            $subcat_table3 = SubCatLevel3::orderBy('description')->get();
            $bank= $userModel;
			$bankaccount_id = null;
            $isbrand = true;
			$oshops = DB::table('oshop')->
				leftJoin('address','oshop.address_id','=','address.id')->
				leftJoin('city','address.city_id','=','city.id')->
				leftJoin('state','city.state_code','=','state.code')->
				leftJoin('area','area.id','=','address.area_id')->
				leftJoin('merchantoshop','oshop.id','=','merchantoshop.oshop_id')->
				where('merchantoshop.merchant_id',$merchant_id)->
				select('oshop.*','area.id as area_id','state.id as state_id','state.code as state_code','city.id as city_id','address.line1 as line1','address.line2 as line2','address.line3 as line3','address.line4 as line4','address.postcode as postcode')->
				where('oshop.single',false)->get();

			if(count($oshops) == 0){
				$oshops = null;
			}
            
            $merchantAddress = null;
            $bankDetails = null;
            $property = null;
            if (isset($merchant_id)) {
                $address_id = Merchant::where('id', $merchant_id)->
					first()->oshop_address_id;

                $merchantAddress = Address::find($address_id);
                if (!is_null(Merchant::where('id', $merchant_id)->first())) {
					$bankaccount_id = Merchant::where('id', $merchant_id)->
						first()->bankaccount_id;
				}

                $bankDetails = BankAccount::find($bankaccount_id);
				if (!is_null($bankDetails)) {
					$bbank = Bank::where('id', $bankDetails->
						bank_id)->first();
					if(!is_null($bbank)){
						$bankDetails->name = Bank::where('id', $bankDetails->
						bank_id)->first()->name;						
					} else {
						$bankDetails->name = "";
					}
				}
            }

			$userfacility = DB::table('sellerfacility')->
				join('facility','sellerfacility.facility_id','=','facility.id')->
				whereIn('name',['empbnf','fair'])->
				where('user_id',$userModel['user']['id'])->get();

			$userroles = DB::table('role_users')->
				join('roles','role_users.role_id','=','roles.id')->
				whereIn('slug',['fmu','hcu'])->
				where('user_id',$userModel['user']['id'])->get();

		//	dd($userroles);
            return view('user/registerMerchant',
				compact(['merchantAddress','bankDetails','indication',
					'route', 'disabled', 'userModel', 'mer_doc', 'doc',
					'oshops','pmerchant_id',
					'brand_table',
					'userfacility',
					'userroles',
					'logistic_id',
					'selluser',
					'subcats',
					'subcat_table1',
					'subcat_table2',
					'subcat_table3', 'isbrand','edit','editing']));
		} else {
            return redirect('/create_new_merchant');
        }
    }

    public function reShapeMerchantModel($merchantModel, $merchant1)
    {
	/* $user_id= Auth::id();
	$merchant1= Merchant::where('user_id',$user_id)->first();

    // dd($merchant1);*/
    $mid= $merchant1->id;

    $merchantObj = new Merchant();
    $userModel = $merchantObj->getMerchantRelationsFullMeta();

    // $bank =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['bankaccount_id'] ) ?  [$merchantModel['merchant'][0]['bankaccount_id']] : null ):null ;
   $bankaccount_id= $merchant1->bankaccount_id;

   $bank= BankAccount::where('id',$bankaccount_id)->get();

    $merchant =  isset($merchantModel['merchant'] ) ?  $merchantModel['merchant'] : null;

    $address =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['address'] ) ?  [$merchantModel['merchant'][0]['address']] : null):null;
    $oshop_address =  Address::where('id',$merchant1->oshop_address_id)->get();
    // $brand =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['brand'] ) ?  $merchantModel['merchant'][0]['brand'] : null):null;

    // return $mid;
    $brand_raw= DB::table("merchantbrand")->where('merchant_id',$mid)->get();
    $brand_id_array=array();

    foreach ($brand_raw as $b) {
        # code...
        array_push($brand_id_array, $b->brand_id);
    }
    $brand=Brand::join('merchantbrand','merchantbrand.brand_id','=','brand.id')->select('brand.*','merchantbrand.relationship','merchantbrand.subcat_id','merchantbrand.subcat_level','merchantbrand.official_distributorship')->whereIn('brand.id',$brand_id_array)->where('merchantbrand.merchant_id',$mid)->get();
	
	$contactemail=DB::table('contactemail')->join('merchantcontactemail','merchantcontactemail.contactemail_id','=','contactemail.id')
	->select('contactemail.*')->where('merchantcontactemail.merchant_id',$mid)->orderBy('contactemail.id','asc')->get();
	
    // return $brand;
    $websites =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['websites'] ) ?  $merchantModel['merchant'][0]['websites'] : null):null;
    $directors =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['directorsInEditView'] ) ?  $merchantModel['merchant'][0]['directorsInEditView'] : null):null;
    // return $brand;
    $merchantArr = null;
    $bankArr = null;
    $addressArr = null;
    $oshopaddressArr = null;
    $brandArr = null;
    $contactArr = null;
    $websitesArr = null;
    $directorsArr = null;

    if(!is_null( $merchant))
    foreach($merchant as $data)
    {
        $merchantArr[]=[
            "id" => isset($data->id) ?  $data->id: null,
            "user_id" => isset($data->user_id) ?  $data->user_id: null,
            "company_name" =>
                isset($data->company_name) ?$data->company_name  : null,
            "gst" => isset($data->gst) ? $data->gst : null,
            "business_reg_no" =>
                isset($data->business_reg_no) ? $data->business_reg_no : null,
            "country_id" => isset($data->country_id) ? $data->country_id : null,
            "business_type" =>
                isset($data->business_type) ? $data->business_type : null,
            "address_id" =>
                isset($data->address_id) ?  $data->address_id: null,
            "contact_person" =>
                isset($data->contact_person) ?  $data->contact_person: null,
            "office_no" => isset($data->office_no) ?  $data->office_no: null,
            "mobile_no" => isset($data->mobile_no) ?  $data->mobile_no: null,
            "oshop_name" => isset($data->oshop_name) ? $data->oshop_name : null,
            "oshop_logo_1" =>
                isset($data->oshop_logo_1) ? $data->oshop_logo_1 : null,
            "oshop_logo_2" =>
                isset($data->oshop_logo_2) ?  $data->oshop_logo_2: null,
            "oshop_logo_3" =>
                isset($data->oshop_logo_3) ?  $data->oshop_logo_3: null,
            "oshop_logo_4" =>
                isset($data->oshop_logo_4) ? $data->oshop_logo_4 : null,
            "oshop_logo_5" =>
                isset($data->oshop_logo_5) ?  $data->oshop_logo_5: null,
            "oshop_adimage_1" =>
                isset($data->oshop_adimage_1) ? $data->oshop_adimage_1: null,
            "oshop_adimage_2" =>
                isset($data->oshop_adimage_2) ? $data->oshop_adimage_2: null,
            "oshop_adimage_3" =>
                isset($data->oshop_adimage_3) ?  $data->oshop_adimage_3: null,
            "oshop_adimage_4" =>
                isset($data->oshop_adimage_4) ? $data->oshop_adimage_4 : null,
            "oshop_adimage_5" =>
                isset($data->oshop_adimage_5) ? $data->oshop_adimage_5 : null,
            "description" =>
                isset($data->description) ? $data->description : null,
            "history" => isset($data->history) ?  $data->history: null,
            "license" => isset($data->license) ?  $data->license: null,
            "min_order" => isset($data->min_order) ?  $data->min_order: 0,
            "coverage" => isset($data->coverage) ? $data->coverage : null,
            "ownership" => isset($data->ownership) ? $data->ownership : null,
            "own_delivery_logistic_id" => isset($data->own_delivery_logistic_id) ? $data->own_delivery_logistic_id : null,
            "all_own_delivery" => isset($data->all_own_delivery) ? $data->all_own_delivery : null,
            "all_system_delivery" => isset($data->all_system_delivery) ? $data->all_system_delivery : null,
            "category_id" =>
                isset($data->category_id) ? $data->category_id : null,
            "planned_sales" =>
                isset($data->planned_sales) ? $data->planned_sales : null,
            "bank_id" => isset($data->bank_id) ? $data->bank_id : null,
            "return_policy" =>
                isset($data->return_policy) ? $data->return_policy : null,
            "note" => isset($data->note) ? $data->note : null,
            "deleted_at" => isset($data->deleted_at) ? $data->deleted_at : null,
            "created_at" => isset($data->created_at) ?  $data->created_at: null,
            "updated_at" => isset($data->updated_at) ?  $data->updated_at: null
        ];
    }


    if(!is_null($bank))
    foreach($bank  as $data)
    {
        // $b= BankAccount::find($data);
        $b=Bank::where('id',$data->bank_id)->first();
		$bname = "";
		$bcode = "";
		if(!is_null($b)){
			$bname = $b->name;
			$bcode = $b->code;		
		}
        $bankArr[] = [
            "id" => isset($data->id) ? $data->id: null,
            "name" => $bname,
            "code" => $bcode,
            "account_name1" => isset($data->account_name1) ?$data->account_name1: null,
            "account_number1" => isset($data->account_number1) ?$data->account_number1: null,
            "account_name2" => isset($data->account_name2) ?$data->account_name2: null,
            "account_number2" => isset($data->account_number2) ?$data->account_number2: null,
            "iban" => isset($data->iban) ?$data->iban: null,
            "swift" => isset($data->swift) ?$data->swift: null,
            "url" => isset($data->url) ?$data->url: null,
            "description" => isset($data->description) ?$data->description: null,
            "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
            "created_at" => isset($data->created_at) ?$data->created_at: null,
            "updated_at" => isset($data->updated_at) ?$data->updated_at: null
        ];
    }

    if(!is_null($address))
    foreach($address  as $data)
    {
		$state_id = 0;
		$state = DB::table('state')->select('state.id as id', 'state.code as code')->join('city','city.state_code','=','state.code')->where('city.id',$data->city_id)->first();
		if(!is_null($state)){
			$state_id = $state->id;
			$state_code = $state->code;
		}
        $addressArr[] = [
            "id" => isset($data->id) ?$data->id: null,
            "state_id" => isset($state_id) ?$state_id: null,
            "state_code" => isset($state_code) ?$state_code: null,
            "city_id" => isset($data->city_id) ?$data->city_id: null,
            "area_id" => isset($data->area_id) ?$data->area_id: null,
            "postcode" => isset($data->postcode) ?$data->postcode: null,
            "line1" => isset($data->line1) ?$data->line1: null,
            "line2" => isset($data->line2) ?$data->line2: null,
            "line3" =>isset($data->line3) ?$data->line3: null,
            "line4" => isset($data->line4) ?$data->line4: null,
            "latitude" => isset($data->latitude) ?$data->latitude: null,
            "longitude" => isset($data->longitude) ?$data->longitude: null,
            "type" => isset($data->type) ?$data->type: null,
            "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
            "created_at" => isset($data->created_at) ?$data->created_at: null,
            "updated_at" => isset($data->updated_at) ?$data->updated_at: null
        ];
    }
	
    if(!is_null($oshop_address))
    foreach($oshop_address  as $data)
    {
		$state_id = 0;
		$state = DB::table('state')->select('state.id as id', 'state.code as code')->join('city','city.state_code','=','state.code')->where('city.id',$data->city_id)->first();
		if(!is_null($state)){
			$state_id = $state->id;
			$state_code = $state->code;
		}		
        $oshopaddressArr[] = [
            "id" => isset($data->id) ?$data->id: null,
			"state_id" => isset($state_id) ?$state_id: null,
			"state_code" => isset($state_code) ?$state_code: null,
            "city_id" => isset($data->city_id) ?$data->city_id: null,
            "area_id" => isset($data->area_id) ?$data->area_id: null,
            "postcode" => isset($data->postcode) ?$data->postcode: null,
            "line1" => isset($data->line1) ?$data->line1: null,
            "line2" => isset($data->line2) ?$data->line2: null,
            "line3" =>isset($data->line3) ?$data->line3: null,
            "line4" => isset($data->line4) ?$data->line4: null,
            "latitude" => isset($data->latitude) ?$data->latitude: null,
            "longitude" => isset($data->longitude) ?$data->longitude: null,
            "type" => isset($data->type) ?$data->type: null,
            "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
            "created_at" => isset($data->created_at) ?$data->created_at: null,
            "updated_at" => isset($data->updated_at) ?$data->updated_at: null
        ];
    }	

     if(!is_null($brand))
    foreach($brand  as $data)
    {	
		$doc = DB::table('branddocument')
            ->join('document','document.id','=','branddocument.document_id')
            ->where('branddocument.brand_id',$data->id)
            ->where('branddocument.merchant_id',$merchant1->id)
            ->first();
        $brandArr[] = [
            "id" => isset($data->id) ?$data->id: null,
            "name" => isset($data->name) ?$data->name: null,
            "subcat_id" => isset($data->subcat_id) ?$data->subcat_id: null,
            "subcat_level" => isset($data->subcat_level) ?$data->subcat_level: null,
            "relationship" => isset($data->relationship) ?$data->relationship: null,
            "official_distributorship" => isset($data->official_distributorship) ?$data->official_distributorship: null,
            "description" => isset($data->description) ?$data->description: null,
            "logo" => isset($data->logo) ?$data->logo: null,
            "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
            "created_at" => isset($data->created_at) ?$data->created_at: null,
            "updated_at" => isset($data->updated_at) ?$data->updated_at: null,
			"doc" => isset($doc->path)?$doc->path:null,
            "document_id" => isset($doc->document_id)?$doc->document_id:null
        ];
    }
	
    if(!is_null($contactemail))
    foreach($contactemail  as $data)
    {	
        $contactArr[] = [
            "id" => isset($data->id) ?$data->id: null,
            "email" => isset($data->email) ?$data->email: null,
            "enable" => isset($data->enable) ?$data->enable: null,
            "name" => isset($data->name) ?$data->name: null,
            "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
            "created_at" => isset($data->created_at) ?$data->created_at: null,
            "updated_at" => isset($data->updated_at) ?$data->updated_at: null,
        ];
    }	
	
    if(!is_null($websites))
    foreach($websites  as $data)
    {
		if(isset($data->type)){
			if(!is_null($data->type)){
				$websitesArr[] = [
					"id" => isset($data->id) ?$data->id: null,
					"name" => isset($data->name) ?$data->name: null,
					"type" => isset($data->type) ?$data->type: null,
					"description" => isset($data->description) ?$data->description: null,
					"url" => isset($data->url) ?$data->url: null,
					"deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
					"created_at" => isset($data->created_at) ?$data->created_at: null,
					"updated_at" => isset($data->updated_at) ?$data->updated_at: null
				];				
			}
		}
    }
	//dd($websitesArr);
    if(!is_null($directors))
    foreach($directors  as $data)
    {
        $doc = DB::table('directordocument')
            ->join('document','document.id','=','directordocument.document_id')
            ->where('directordocument.director_id',$data->id)
            ->first();
        $directorsArr[] = [
            "id" => isset($data->id) ?$data->id: null,
            "merchant_id" => isset($data->merchant_id) ?$data->merchant_id: null,
            "country_id" => isset($data->country_id) ?$data->country_id: null,
            "name" => isset($data->name) ?$data->name: null,
            "nric" => isset($data->nric) ?$data->nric: null,
            "photo_1" => isset($data->photo_1) ?$data->photo_1: null,
            "photo_2" => isset($data->photo_2) ?$data->photo_2: null,
            "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
            "created_at" => isset($data->created_at) ?$data->created_at: null,
            "updated_at" => isset($data->updated_at) ?$data->updated_at: null,
            "doc" => isset($doc->path)?$doc->path:null,
            "document_id" => isset($doc->document_id)?$doc->document_id:null
        ];
    }

    $userModel = [
      "user" =>[
        "id" => isset($merchantModel['id']) ? $merchantModel['id'] : null ,
        "occupation_id" => isset($merchantModel['occupation_id']) ? $merchantModel['occupation_id'] : null ,
        "first_name" => isset($merchantModel['first_name']) ? $merchantModel['first_name'] : null ,
        "last_name" =>  isset($merchantModel['last_name']) ? $merchantModel['last_name'] : null,
        "birthdate" => isset($merchantModel['birthdate']) ? $merchantModel['birthdate'] : null ,
        "mobile_no" => isset($merchantModel['mobile_no']) ? $merchantModel['mobile_no'] : null ,
        "email" =>  isset($merchantModel['email']) ? $merchantModel['email'] : null,
        "password" => isset($merchantModel['password']) ? $merchantModel['password'] : null ,
        "gender" =>  isset($merchantModel['gender']) ?  $merchantModel['gender']: null,
        "annual_income" => isset($merchantModel['annual_income']) ?$merchantModel['annual_income']  : null,
        "salutation" =>  isset($merchantModel['salutation']) ? $merchantModel['salutation'] : null,
        "type" =>  isset($merchantModel['type']) ? $merchantModel['type'] : null,
        "deleted_at" =>  isset($merchantModel['deleted_at']) ?  $merchantModel['deleted_at']: null,
        "created_at" => isset($merchantModel['created_at']) ? $merchantModel['created_at'] : null,
        "updated_at" => isset($merchantModel['updated_at']) ?  $merchantModel['updated_at']: null
        ],
      "merchant" => $merchantArr,
      "bank" => $bankArr,
      "address" =>$addressArr,
      "oshopaddress" =>$oshopaddressArr,
      "brand" =>$brandArr,
      "contactemail" =>$contactArr,
      "websites" =>$websitesArr ,
      "directorsInEditView" => $directorsArr
    ];

    return $userModel;
    }

    public function postEditMerchant(Request $request)
    {
		//update user info
		Log::debug('*****postEditMerchant() *****');
		
		$user = new User();

		//return new user record in db 
		$user_model = $user->UpdateUserByid($request);

		//find merchant
		$merchant_data = Merchant::where('user_id', $user_model->id)->first();

	/*	if($request->get('all_own_delivery') == 1){
			$this->alsologistic($user_model->id);
		}*/
		
		$merchant = new Merchant();
		$merchant->UpdateInfo($merchant_data, $request);
	//	dd("fsdafe");
		DB::table('merchantdirector')->
			where('merchant_id',$merchant_data->id)->delete();
		
		$bankAccount=BankAccount::find($merchant_data->bankaccount_id);
		
		if (!empty($bankAccount)) {
			$bankAccount->bank_id= $request->get('bank');
			$bankAccount->account_name1=$request->get('account_name');
			$bankAccount->account_name2=$request->get('account_name');
			$bankAccount->account_number1=$request->get('account_number');
			$bankAccount->account_number2=$request->get('account_number');
			$bankAccount->iban=$request->get('ibn');
			$bankAccount->swift=$request->get('swift');
			$bankAccount->save();
		} else {
			$bank = new BankAccount();
			$bank_model = $bank->store($request);
			DB::table('merchant')->where('id',$merchant_data->id)->update(['bankaccount_id' => $bank_model->id]);
		}
		$director = new Director();
		$director_model = $director->store($request, $merchant_data);

		//Update websites data
		DB::table('merchantwebsite')->
			where('merchant_id',$merchant_data->id)->delete();

		$websites = new Website();
		$website_models = $websites->store($request);
		$merchant_data->attachWebsites($website_models, $merchant_data);

		DB::table('merchantdocument')->
			where('merchant_id',$merchant_data->id)->
			whereNotIn('document_id', $request->
			get('attfilesIDs'))->delete();
		
		$documents = new Document();
		$documents_model = $documents->store($request, $merchant_data);	
		//dd($request->get('brandIDs'));

		DB::table('merchantbrand')->
			where('merchant_id',$merchant_data->id)->
			whereNotIn('brand_id', $request->get('brandIDs'))->delete();

		DB::table('branddocument')->
			where('merchant_id',$merchant_data->id)->
			whereNotIn('document_id', $request->get('attfilesBIDs'))->delete();
			
		DB::table('merchantcontactemail')->
			where('merchant_id',$merchant_data->id)->delete();
		
		$enabled_email = $request->get('checkemail');
		$contactemail = $request->get('contactemail');
		$contactname = $request->get('contactname');
		$ii = 0;
	//	dump($contactemail );
	//	dd($enabled_email );
		foreach($contactemail as $contact){
			$enable = false;
			if (!empty($enabled_email)) {
				if(in_array($ii,$enabled_email)){
					$enable = true;
				}
			}
			$email = DB::table('contactemail')->insertGetId(['email'=>$contact,'name'=>$contactname[$ii],'enable'=>$enable, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
			DB::table('merchantcontactemail')->insertGetId(['contactemail_id'=>$email,'merchant_id'=>$merchant_data->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
			$ii++;
		}
		$brand = new MerchantBrand();
		$brand_models = $brand->store($request, $merchant_data->id);	
		$addressold = Address::find($merchant_data->address_id);
		$citychanged = false;

		// Have to take account if $addressold is NULL
		if(empty($addressold) ||
			$addressold->city_id != $request->get('city_id')){
			$citychanged = true;
		}

		//Update Address
		$address = new Address();
		$address_id = $address->UpdateAddress($request, $merchant_data);
		if (!empty($address_id)) {
			DB::table('merchant')->where('id',$merchant_data->id)->
				update(['address_id' => $address_id]);
		}

		$data = $merchant_data->id;
		$uniqueexist = DB::table('nsellerid')->where('user_id',$user_model->id)->first();
		if(is_null($uniqueexist)){
			$uniqueid = UtilityController::selleruniqueid($request->get('city_id'),"01");
			DB::table('nsellerid')->insert(['nseller_id'=>$uniqueid, 'user_id' => $user_model->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			$qr = (new UtilityController)->createQr($merchant_data->id,'merchant',IdController::nSeller($user_model->id));
		} else {
			if($citychanged){
				$uniqueid = UtilityController::selleruniqueid($request->get('city_id'),"01");
				//dd($uniqueid);
				DB::table('nsellerid')->where('id',$uniqueexist->id)->update(['nseller_id'=>$uniqueid, 'updated_at' => date('Y-m-d H:i:s')]); 
				DB::table('merchantqr')->where('merchant_id',$merchant_data->id)->delete();
				UtilityController::createQr($merchant_data->id,'merchant',IdController::nSeller($user_model->id));
			}
		}
		$indication = "merchant";
		
		$oshops = $request->get('oshop_name');
		$oshop_ids = $request->get('oshop_ids');
		$oshop_brand_name = $request->get('oshop_brand_name');
		$oshop_url = $request->get('oshop_url');
		$oshop_value_url = $request->get('hoshop_url');
		//dd($oshop_brand_name);
		if(count($oshops) > 0) {
			for ($i = 0; $i < count($oshops); $i++) {
				if($oshop_ids[$i] == 0){							
					$oshop = DB::table('oshop')->
						insertGetId(['oshop_name'=>$oshops[$i],
						'url'=>$oshop_value_url[$i],
						'original_url'=>$oshop_value_url[$i],
						'brand_id'=>$oshop_brand_name[$i],
						'address_id'=>0,
						'shop_size'=>0,
						'contact_first_name'=>"",
						'contact_last_name'=>"",
						'contact_mobile_no'=>"",
						'status'=>'pending',
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>date('Y-m-d H:i:s')]);

					DB::table('merchantoshop')->
						insert(['oshop_id'=>$oshop,
						'merchant_id'=>$merchant_data->id,
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>date('Y-m-d H:i:s')]);		

					$uniqueid = (new UtilityController)->
						branchuniqueid($request->get('city_id'),'06');

					if($uniqueid != ""){
						$nbid = DB::table('nbranchid')->
							insertGetId(['nbranch_id'=>$uniqueid,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')]);
						
						DB::table('nbranchoshopid')->
							insertGetId(['nbranchid_id'=>$nbid,
							'oshop_id'=>$oshop,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')]);
					}	
					//DB::table('oshopqr')
					$qr = (new UtilityController)->createQr($oshop,'oshop', URL::to('/') . '/o/' . $oshop_value_url[$i]);
				} else {
					$oshop = DB::table('oshop')->
						where('id',$oshop_ids[$i])->first();

					if(!is_null($oshop)){
						if($oshop_brand_name[$i] == "" ||
							$oshop_brand_name[$i] == null ||
							$oshop_brand_name[$i] == 0){

							$oshop = DB::table('oshop')->
								where('id',$oshop_ids[$i])->
								update(['oshop_name'=>$oshops[$i],
								'url'=>$oshop_value_url[$i],
								'original_url'=>$oshop_value_url[$i],
								'shop_size'=>0,
								'contact_first_name'=>"",
								'contact_last_name'=>"",
								'contact_mobile_no'=>"",
								'updated_at'=>date('Y-m-d H:i:s')]);

						} else {
							$oshop = DB::table('oshop')->
								where('id',$oshop_ids[$i])->
								update(['oshop_name'=>$oshops[$i],
								'url'=>$oshop_value_url[$i],
								'original_url'=>$oshop_value_url[$i],
								'brand_id'=>$oshop_brand_name[$i],
								'shop_size'=>0,
								'contact_first_name'=>"",
								'contact_last_name'=>"",
								'contact_mobile_no'=>"",
								'updated_at'=>date('Y-m-d H:i:s')]);
						}
						DB::table('oshopqr')->where('oshop_id',$oshop_ids[$i])->delete();
						$qr = (new UtilityController)->createQr($oshop_ids[$i],'oshop', URL::to('/') . '/o/' . $oshop_value_url[$i]);
					}	
				}
			}
		}			
		Session::flash('EditMerchant', 'Information Updated Successfully');
		return redirect()->back();
    }

	public function storewizard(Request $request)
    {
		$email = $request->get('email');
		$mfirstname = $request->get('mfirstname');
		$mlastname = $request->get('mlastname');
		$mmobile = $request->get('mmobile');
		
		$eexist = DB::table('merchant_wizard')->where('email',$email)->first();
		if(is_null($eexist)){
			DB::table('merchant_wizard')->insert(['email'=>$email, 'first_name' => $mfirstname, 'last_name' => $mlastname, 'mobile' => $mmobile, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);				
		}
		
		return "true";
	}
	
	public function storelog(Request $request)
    {
		try {
			
			$user = new User();
			$user_model = $user->store($request);//return new user record in db
		   
			$bank = new BankAccount();
			$bank_model = $bank->store($request);

			//TODO: for adding address first create address then add address id to merchant table
			//country_id   => working
			$address = new Address();
			$address_model = $address->storelatlong($request);
			// user_id, country_id, address_id, bank_id => working
			$user_as_merchant = new Merchant();
			$user_as_merchant_model = $user_as_merchant->store($request, $user_model, $bank_model, $address_model);

		/*	if($request->get('sline1') != ""){
				$merchant_address = new Address();
				$merchant_address->city_id = $request->get('mcity_id');
				$merchant_address->postcode = $request->get('mzip');
				$merchant_address->line1 = $request->get('sline1');
				$merchant_address->line2 = $request->get('sline2');
				$merchant_address->line3 = $request->get('sline3');
				$merchant_address->line4 = $request->get('sline4');
				$merchant_address->type = 'default';

				if ($merchant_address->save()) {
					DB::table('merchant')->where('id', $user_as_merchant_model->id)->update(array(
						'oshop_address_id' => $merchant_address->id,
						'return_address_id' => $merchant_address->id,
						));
				}
			}*/
			$uniqueid = (new UtilityController)->selleruniqueid($request->get('city_id'),'00');
			DB::table('nsellerid')->insert(['nseller_id'=>$uniqueid, 'user_id' => $user_model->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			$qr = (new UtilityController)->createQr($user_as_merchant_model->id,'merchant',IdController::nSeller($user_model->id));
			
			/*
			 * Document table
			 */

			try {
				$documents = new Document();
				$documents_model = $documents->store($request, $user_as_merchant_model);
			} catch (\Exception $e) {
			//	dump ("Below dump is of exception happening in Block 1");
			  //  dump($e);
			}
			

			//todo: add brand
			//1)create merchant and get model
			//2)create all brand and get all models
			//3)sync merchant model with brand models in merchantbrand table
			/*** Merchant Album ***/
			DB::table('album')->insert(['merchant_id' => $user_as_merchant_model->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

			/*$brand = new MerchantBrand();
			$brand_models = $brand->store($request, $user_as_merchant_model->id);*/


			//http://laravel.com/docs/5.1/eloquent-relationships#inserting-many-to-many-relationships
			//for storing web sites in "merchantwebsite" table
			//first create merchant and get id
			//then create websites and get website model array like director
			//then attach merchant with each website id

			$website = new Website();
			$website_models = $website->store($request);

			//attachment with merchant in "merchantwebsite" table

			$user_as_merchant->attachWebsites($website_models, $user_as_merchant_model);

			$director = new Director();
			$director_model = $director->store($request, $user_as_merchant_model);
			
		/*	$enabled_email = $request->get('checkemail');
			$contactemail = $request->get('contactemail');
			$contactname = $request->get('contactname');
			$ii = 1;
			foreach($contactemail as $contact){
				$enable = false;
				if(in_array($ii,$enabled_email)){
					$enable = true;
				}
				$email = DB::table('contactemail')->insertGetId(['email'=>$contact,'name'=>$contactname[$ii - 1],'enable'=>$enable, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				DB::table('merchantcontactemail')->insertGetId(['contactemail_id'=>$email,'merchant_id'=>$user_as_merchant_model->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				$ii++;
			}

			$oshops = $request->get('oshop_name');
			$oshop_ids = $request->get('oshop_ids');
			$oshop_brand_name = $request->get('oshop_brand_name');
			$oshop_url = $request->get('oshop_url');
			$oshop_value_url = $request->get('hoshop_url');
			if(count($oshops) > 0)
			{
				for ($i = 0; $i < count($oshops); $i++) {
					if($oshop_ids[$i] == 0 && $oshops[$i] != ""){							
						$oshop = DB::table('oshop')->insertGetId(['oshop_name'=>$oshops[$i],'url'=>$oshop_value_url[$i],'original_url'=>$oshop_value_url[$i],'brand_id'=>$oshop_brand_name[$i],'address_id'=>0,'shop_size'=>0,'contact_first_name'=>"",'contact_last_name'=>"",'contact_mobile_no'=>"",'status'=>'pending','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
						DB::table('merchantoshop')->insert(['oshop_id'=>$oshop,'merchant_id'=>$user_as_merchant_model->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);	
						$uniqueid = (new UtilityController)->branchuniqueid($request->get('city_id'),'06');
						if($uniqueid != ""){
							$nbid = DB::table('nbranchid')->insertGetId(['nbranch_id'=>$uniqueid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
							
							DB::table('nbranchoshopid')->insertGetId(['nbranchid_id'=>$nbid, 'oshop_id'=>$oshop, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						}	
						$qr = (new UtilityController)->createQr($oshop,'oshop', URL::to('/') . '/o/' . $oshop_value_url[$i]);
					//	DB::table('nbranchid')->insert(['nbranch_id'=>$uniqueid, 'oshop_id' => $oshop, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}

				}
			}	*/		

			$merchants = DB::table('merchant')->
				join('users','users.id','=','merchant.user_id')->
				join('address','address.id','=','merchant.address_id')->
				where('merchant.id',$user_as_merchant_model->id)->
				select('merchant.*', 'address.id as addressid',
					'users.first_name', 'users.last_name',
					'users.mobile_no')->first();
			if(!is_null($merchants)){		
				$oshop = DB::table('oshop')->
				insertGetId([
					'oshop_name'=>"Single",
					'brand_id'=>0,
					'address_id'=>$merchants->addressid,
					'shop_size'=>'0',
					'contact_first_name'=>$merchants->first_name,
					'contact_last_name'=>$merchants->last_name,
					'contact_mobile_no'=>$merchants->mobile_no,
					'status'=>'active',
					'single'=>true,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')]);

				DB::table('merchantoshop')->insert([
					'merchant_id'=>$merchants->id,
					'oshop_id'=>$oshop,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')]);	
					
				DB::table('oshop')->where('id',$oshop)->update(['url'=>$oshop, 'original_url'=>$oshop]);
				
				$uniqueid = (new UtilityController)->branchuniqueid($request->get('city_id'),'06');
				if($uniqueid != ""){
					$nbid = DB::table('nbranchid')->insertGetId(['nbranch_id'=>$uniqueid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					
					DB::table('nbranchoshopid')->insertGetId(['nbranchid_id'=>$nbid, 'oshop_id'=>$oshop, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}		
				$qr = (new UtilityController)->createQr($oshop,'oshop',$oshop);

				/***** CODE FORM COMPANY CREATION *****/
				$cname = trim($merchants->company_name);
				$cdesc = trim($merchants->description);
	

				$farray = explode(" ",$cname);	
				$num = count($farray);


				if($num == 1){
					$sysname = strtolower(substr($farray[0],0,3));
				} else if($num == 2){
					$sysname =strtolower(substr($farray[0],0,1) .
						substr($farray[1],0,1));
				} else if($num >= 3) {
					$sysname = strtolower(substr($farray[0],0,1) .
						substr($farray[1],0,1) . substr($farray[2],0,1));
				} else {
					$sysname = "n/a";
				}

				DB::table('company')->insert(['sysname'=>$sysname,
					'owner_user_id'=>$merchants->user_id,
					'dispname'=>$cname,
					'company_name'=>$cname,
					'description'=>$cdesc,
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')]);
			}							

			$e= new EmailController;
			$e->merchantOnboard($request->email);
			$tokens = DB::table('product')->where('segment','token')->where('retail_price','>=',1000000)->get();
			foreach($tokens as $token){
				DB::table('tokenuserproduct')->insert(['product_id'=>$token->id,'user_id'=>$merchants->user_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			}
			DB::table('fairlocation')->insert(['company_name'=>"Warehouse",'location'=>"Warehouse",'user_id'=>$merchants->user_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			
			$this->alsostationlog($user_model->id);

			/*save all FKs of directors & merchants to merchantdirectos tables */
			//$user_as_merchant_model->attachDirectors($director_model, $user_as_merchant_model);
			// try{
			// 	$mgClient = new Mailgun('key-80495c8905443d885803333b49b45718');
			// 	$domain = "opensupermall.com";

			// 	# Make the call to the client.
			// 	$result = $mgClient->sendMessage($domain, array(
			// 		'from'    => 'Opensupermall <info@opensupermall.com>',
			// 		'to'      => $user_model->first_name . ' ' . $user_model->first_name .  ' <'. $user_model->email .'>',
			// 		'subject' => 'Confirm your Merchant Opensupermall account',
			// 		'html'    => '<h4>Plase, confirm your Opensupermall Account!</h4>
			// 					<p>click on the following link: <a href="'.url().'/verifymerchant/'.$user_as_merchant_model->id.'">Confirm</a></p>'
			// 	));					
			// } catch (\Exception $e) {
				
			// }						
			// Auth::login($user_model);
			//Auth::attempt(['email' => $user_model->email,'password'=> $user_model->password]);
			/*if($request->get('all_own_delivery') == 1){
				$this->alsologistic($user_model->id);
			}*/

			$role_type = $request->get('role_type');
			//dd($role_type);
			if($role_type == 'humancap'){
				$rr = DB::table('roles')->where('slug','hcu')->first();
				if(!is_null($rr)){
					$role = new RoleUser;
					$role->user_id = $user_model->id;
					$role->role_id = $rr->id;
					$role->save();
				}
				$ff = DB::table('facility')->where('name','empbnf')->first();
				if(!is_null($ff)){
					DB::table('sellerfacility')->insert(['user_id'=>$user_model->id, 'facility_id' => $ff->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				}
			} else if($role_type == 'fairmode'){
				$rr = DB::table('roles')->where('slug','fmu')->first();
				if(!is_null($rr)){
					$role = new RoleUser;
					$role->user_id = $user_model->id;
					$role->role_id = $rr->id;
					$role->save();
				}
				$ff = DB::table('facility')->where('name','fair')->first();
				if(!is_null($ff)){
					DB::table('sellerfacility')->insert(['user_id'=>$user_model->id, 'facility_id' => $ff->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				}
			} else {
				$rr = DB::table('roles')->where('slug','mer')->first();
				if(!is_null($rr)){
					$role = new RoleUser;
					$role->user_id = $user_model->id;
					$role->role_id = $rr->id;
					$role->save();
				}
				$ff = DB::table('facility')->where('name','ecomm')->first();
				if(!is_null($ff)){
					DB::table('sellerfacility')->insert(['user_id'=>$user_model->id, 'facility_id' => $ff->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				}
			}
			\Session::flash(Config::get('messages.key.name'), $this->messageHandler->success('merchantRegistered', null, null, true, true, true));

//                if(Auth::attempt(['email' => $user_model->email,'password'=> $user_model->password])){
//                    redirect("home");
//                }
			// throw new Exception("Error Processing Request", 1);
			
		} catch (\Exception $e) {
			
			\Session::flash(Config::get('messages.key.name'), $this->messageHandler->error('merchantError', null, null,null, true, true, true));
			echo "<script>console.log(".$e->getMessage().")</script>";
			//dd($e);
			try {
				// Setting email to be garbage
				$u= User::find($user_model->id);
				$u->email=time();
				$u->save();
				User::destroy($user_model->id);
				// User::where('id',$user_model->id)->delete();
			} catch (\Exception $e) {

			}
			try {
				BankAccount::destroy($bank_model->id);
			} catch (\Exception $e) {

			}
			try {
				Address::destroy($address->id);
			} catch (\Exception $e) {

			}
			try {
				Merchant::destroy($user_as_merchant_model->id);
			} catch (\Exception $e) {

			}
			try {
				Document::destroy($documents_model->id);
			} catch (\Exception $e) {

			}
			try {
				MerchantBrand::destroy($brand_models->id);
			} catch (\Exception $e) {

			}
			try {
				Website::destroy($website_models->id);
			} catch (\Exception $e) {

			}
			
		}		
	}
	
	public function storedislog(Request $request)
    {
		try {
			
			$user = new User();
			$user_model = $user->store($request);//return new user record in db
		   
			$bank = new BankAccount();
			$bank_model = $bank->store($request);

			//TODO: for adding address first create address then add address id to merchant table
			//country_id   => working
			$address = new Address();
			$address_model = $address->storelatlong($request);
			// user_id, country_id, address_id, bank_id => working
			$user_as_merchant = new Merchant();
			$user_as_merchant_model = $user_as_merchant->store($request, $user_model, $bank_model, $address_model);

		/*	if($request->get('sline1') != ""){
				$merchant_address = new Address();
				$merchant_address->city_id = $request->get('mcity_id');
				$merchant_address->postcode = $request->get('mzip');
				$merchant_address->line1 = $request->get('sline1');
				$merchant_address->line2 = $request->get('sline2');
				$merchant_address->line3 = $request->get('sline3');
				$merchant_address->line4 = $request->get('sline4');
				$merchant_address->type = 'default';

				if ($merchant_address->save()) {
					DB::table('merchant')->where('id', $user_as_merchant_model->id)->update(array(
						'oshop_address_id' => $merchant_address->id,
						'return_address_id' => $merchant_address->id,
						));
				}
			}*/
			$uniqueid = (new UtilityController)->selleruniqueid($request->get('city_id'),'00');
			DB::table('nsellerid')->insert(['nseller_id'=>$uniqueid, 'user_id' => $user_model->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			$qr = (new UtilityController)->createQr($user_as_merchant_model->id,'merchant',IdController::nSeller($user_model->id));
			
			/*
			 * Document table
			 */

			try {
				$documents = new Document();
				$documents_model = $documents->store($request, $user_as_merchant_model);
			} catch (\Exception $e) {
			//	dump ("Below dump is of exception happening in Block 1");
			  //  dump($e);
			}
			

			//todo: add brand
			//1)create merchant and get model
			//2)create all brand and get all models
			//3)sync merchant model with brand models in merchantbrand table
			/*** Merchant Album ***/
			DB::table('album')->insert(['merchant_id' => $user_as_merchant_model->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

			/*$brand = new MerchantBrand();
			$brand_models = $brand->store($request, $user_as_merchant_model->id);*/


			//http://laravel.com/docs/5.1/eloquent-relationships#inserting-many-to-many-relationships
			//for storing web sites in "merchantwebsite" table
			//first create merchant and get id
			//then create websites and get website model array like director
			//then attach merchant with each website id

			$website = new Website();
			$website_models = $website->store($request);

			//attachment with merchant in "merchantwebsite" table

			$user_as_merchant->attachWebsites($website_models, $user_as_merchant_model);

			$director = new Director();
			$director_model = $director->store($request, $user_as_merchant_model);
			
		/*	$enabled_email = $request->get('checkemail');
			$contactemail = $request->get('contactemail');
			$contactname = $request->get('contactname');
			$ii = 1;
			foreach($contactemail as $contact){
				$enable = false;
				if(in_array($ii,$enabled_email)){
					$enable = true;
				}
				$email = DB::table('contactemail')->insertGetId(['email'=>$contact,'name'=>$contactname[$ii - 1],'enable'=>$enable, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				DB::table('merchantcontactemail')->insertGetId(['contactemail_id'=>$email,'merchant_id'=>$user_as_merchant_model->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				$ii++;
			}

			$oshops = $request->get('oshop_name');
			$oshop_ids = $request->get('oshop_ids');
			$oshop_brand_name = $request->get('oshop_brand_name');
			$oshop_url = $request->get('oshop_url');
			$oshop_value_url = $request->get('hoshop_url');
			if(count($oshops) > 0)
			{
				for ($i = 0; $i < count($oshops); $i++) {
					if($oshop_ids[$i] == 0 && $oshops[$i] != ""){							
						$oshop = DB::table('oshop')->insertGetId(['oshop_name'=>$oshops[$i],'url'=>$oshop_value_url[$i],'original_url'=>$oshop_value_url[$i],'brand_id'=>$oshop_brand_name[$i],'address_id'=>0,'shop_size'=>0,'contact_first_name'=>"",'contact_last_name'=>"",'contact_mobile_no'=>"",'status'=>'pending','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
						DB::table('merchantoshop')->insert(['oshop_id'=>$oshop,'merchant_id'=>$user_as_merchant_model->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);	
						$uniqueid = (new UtilityController)->branchuniqueid($request->get('city_id'),'06');
						if($uniqueid != ""){
							$nbid = DB::table('nbranchid')->insertGetId(['nbranch_id'=>$uniqueid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
							
							DB::table('nbranchoshopid')->insertGetId(['nbranchid_id'=>$nbid, 'oshop_id'=>$oshop, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						}	
						$qr = (new UtilityController)->createQr($oshop,'oshop', URL::to('/') . '/o/' . $oshop_value_url[$i]);
					//	DB::table('nbranchid')->insert(['nbranch_id'=>$uniqueid, 'oshop_id' => $oshop, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}

				}
			}	*/		

			$merchants = DB::table('merchant')->
				join('users','users.id','=','merchant.user_id')->
				join('address','address.id','=','merchant.address_id')->
				where('merchant.id',$user_as_merchant_model->id)->
				select('merchant.*', 'address.id as addressid',
					'users.first_name', 'users.last_name',
					'users.mobile_no')->first();
			if(!is_null($merchants)){		
				$oshop = DB::table('oshop')->
				insertGetId([
					'oshop_name'=>"Single",
					'brand_id'=>0,
					'address_id'=>$merchants->addressid,
					'shop_size'=>'0',
					'contact_first_name'=>$merchants->first_name,
					'contact_last_name'=>$merchants->last_name,
					'contact_mobile_no'=>$merchants->mobile_no,
					'status'=>'active',
					'single'=>true,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')]);

				DB::table('merchantoshop')->insert([
					'merchant_id'=>$merchants->id,
					'oshop_id'=>$oshop,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')]);	
					
				DB::table('oshop')->where('id',$oshop)->update(['url'=>$oshop, 'original_url'=>$oshop]);
				
				$uniqueid = (new UtilityController)->branchuniqueid($request->get('city_id'),'06');
				if($uniqueid != ""){
					$nbid = DB::table('nbranchid')->insertGetId(['nbranch_id'=>$uniqueid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					
					DB::table('nbranchoshopid')->insertGetId(['nbranchid_id'=>$nbid, 'oshop_id'=>$oshop, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}		
				$qr = (new UtilityController)->createQr($oshop,'oshop',$oshop);

				/***** CODE FORM COMPANY CREATION *****/
				$cname = trim($merchants->company_name);
				$cdesc = trim($merchants->description);
	

				$farray = explode(" ",$cname);	
				$num = count($farray);


				if($num == 1){
					$sysname = strtolower(substr($farray[0],0,3));
				} else if($num == 2){
					$sysname =strtolower(substr($farray[0],0,1) .
						substr($farray[1],0,1));
				} else if($num >= 3) {
					$sysname = strtolower(substr($farray[0],0,1) .
						substr($farray[1],0,1) . substr($farray[2],0,1));
				} else {
					$sysname = "n/a";
				}


				DB::table('company')->insert(['sysname'=>$sysname,
					'owner_user_id'=>$merchants->user_id,
					'dispname'=>$cname,
					'company_name'=>$cname,
					'description'=>$cdesc,
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')]);
			}							
			$e= new EmailController;
			$e->merchantOnboard($request->email);
			$tokens = DB::table('product')->where('segment','token')->where('retail_price','>=',1000000)->get();
			foreach($tokens as $token){
				DB::table('tokenuserproduct')->insert(['product_id'=>$token->id,'user_id'=>$merchants->user_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			}
			DB::table('fairlocation')->insert(['company_name'=>"Warehouse",'location'=>"Warehouse",'user_id'=>$merchants->user_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			/*save all FKs of directors & merchants to merchantdirectos tables */
			//$user_as_merchant_model->attachDirectors($director_model, $user_as_merchant_model);
			// try{
			// 	$mgClient = new Mailgun('key-80495c8905443d885803333b49b45718');
			// 	$domain = "opensupermall.com";

			// 	# Make the call to the client.
			// 	$result = $mgClient->sendMessage($domain, array(
			// 		'from'    => 'Opensupermall <info@opensupermall.com>',
			// 		'to'      => $user_model->first_name . ' ' . $user_model->first_name .  ' <'. $user_model->email .'>',
			// 		'subject' => 'Confirm your Merchant Opensupermall account',
			// 		'html'    => '<h4>Plase, confirm your Opensupermall Account!</h4>
			// 					<p>click on the following link: <a href="'.url().'/verifymerchant/'.$user_as_merchant_model->id.'">Confirm</a></p>'
			// 	));					
			// } catch (\Exception $e) {
				
			// }						
			// Auth::login($user_model);
			//Auth::attempt(['email' => $user_model->email,'password'=> $user_model->password]);
			/*if($request->get('all_own_delivery') == 1){
				$this->alsologistic($user_model->id);
			}*/
			$role_type = $request->get('role_type');
			//dd($role_type);
			if($role_type == 'humancap'){
				$rr = DB::table('roles')->where('slug','hcu')->first();
				if(!is_null($rr)){
					$role = new RoleUser;
					$role->user_id = $user_model->id;
					$role->role_id = $rr->id;
					$role->save();
				}
				$ff = DB::table('facility')->where('name','empbnf')->first();
				if(!is_null($ff)){
					DB::table('sellerfacility')->insert(['user_id'=>$user_model->id, 'facility_id' => $ff->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				}
			} else if($role_type == 'fairmode'){
				$rr = DB::table('roles')->where('slug','fmu')->first();
				if(!is_null($rr)){
					$role = new RoleUser;
					$role->user_id = $user_model->id;
					$role->role_id = $rr->id;
					$role->save();
				}
				$ff = DB::table('facility')->where('name','fair')->first();
				if(!is_null($ff)){
					DB::table('sellerfacility')->insert(['user_id'=>$user_model->id, 'facility_id' => $ff->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				}
			} else {
				$rr = DB::table('roles')->where('slug','mer')->first();
				if(!is_null($rr)){
					$role = new RoleUser;
					$role->user_id = $user_model->id;
					$role->role_id = $rr->id;
					$role->save();
				}
				$ff = DB::table('facility')->where('name','ecomm')->first();
				if(!is_null($ff)){
					DB::table('sellerfacility')->insert(['user_id'=>$user_model->id, 'facility_id' => $ff->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				}
			}
			
			DB::table('users')->where('id',$user_model->id)->delete();
			DB::table('merchant')->where('id',$user_as_merchant_model->id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
			
			\Session::flash(Config::get('messages.key.name'), $this->messageHandler->success('merchantRegistered', null, null, true, true, true));
//                if(Auth::attempt(['email' => $user_model->email,'password'=> $user_model->password])){
//                    redirect("home");
//                }
			// throw new Exception("Error Processing Request", 1);
			
		} catch (\Exception $e) {
			
			\Session::flash(Config::get('messages.key.name'), $this->messageHandler->error('merchantError', null, null,null, true, true, true));
			echo "<script>console.log(".$e->getMessage().")</script>";
			//dd($e);
			try {
				// Setting email to be garbage
				$u= User::find($user_model->id);
				$u->email=time();
				$u->save();
				User::destroy($user_model->id);
				// User::where('id',$user_model->id)->delete();
			} catch (\Exception $e) {

			}
			try {
				BankAccount::destroy($bank_model->id);
			} catch (\Exception $e) {

			}
			try {
				Address::destroy($address->id);
			} catch (\Exception $e) {

			}
			try {
				Merchant::destroy($user_as_merchant_model->id);
			} catch (\Exception $e) {

			}
			try {
				Document::destroy($documents_model->id);
			} catch (\Exception $e) {

			}
			try {
				MerchantBrand::destroy($brand_models->id);
			} catch (\Exception $e) {

			}
			try {
				Website::destroy($website_models->id);
			} catch (\Exception $e) {

			}
			
		}		
	}	
	
    public function store(Request $request)
    {
        $messages = [
            'email.required' => 'We need to know your e-mail address!',
            'email.unique' => 'Email already exist ',
        ];
        //Need email validation here
        $validtion = Validator::make($request->all(),[
            'email' => 'required|email|unique:users',
            'password' => 'required|max:100|min:7|confirmed',
            'password_confirmation' => 'required',
        ],$messages); //
        /*
        $brand_name_array = $request->get('brand_name');
        Models used fo registering a merchant
        User, Bank, Buyer, Address, Merchant, Brand, Website and Director
        */
        if($validtion->fails())
        {
            return redirect()->back()->withErrors($validtion->errors());
        }
        else
        {

            if ($request['indication'] == 'buyer') {

                $user = new User();
                $user_model = $user->store($request);//return new user record in db

                $bank = new BankAccount();
                $bank_model = $bank->store($request);

                return "no functionality implemented";
                $buyer = new Buyer();
                $buyer_model = $buyer->store($request, $user_model);
            }
			
            if ($request['indication'] == 'humancap') {
				try {
					$user = new User();
					$user_model = $user->store($request);//return new user record in db
					
					$address = new Address();
					$address_model = $address->storelatlong($request);
					
					$user_as_humancap = new HumanCap();
					$user_as_humancap_model = $user_as_humancap->store($request, $user_model, $address_model);
					
					$uniqueid = (new UtilityController)->humancapuniqueid($request->get('city_id'),'00');
					DB::table('nhumancapid')->insert(['nhumancap_id'=>$uniqueid, 'user_id' => $user_model->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					
					try {
						$documents = new Document();
						$documents_model = $documents->store($request, $user_as_humancap_model);
					} catch (\Exception $e) {
						dump ("Below dump is of exception happening in Block 1");
						dump($e);
					}
					
					$director = new Director();
					$director_model = $director->store($request, $user_as_humancap_model);
					
					$e= new EmailController;
					$e->humancapOnboard($request->email);
					
					$role = new RoleUser;
					$role->user_id = $user_model->id;
					$role->role_id = 22;
					$role->save();	
					
					\Session::flash(Config::get('messages.key.name'), $this->messageHandler->success('humancapRegistered', null, null, true, true, true));
					
				} catch (\Exception $e) {
				//	dd($e);
					\Session::flash(Config::get('messages.key.name'), $this->messageHandler->error('humancapError', null, null,null, true, true, true));
                    echo "<script>console.log(".$e->getMessage().")</script>";
					//dd($e);
					try {
                        // Setting email to be garbage
                        $u= User::find($user_model->id);
                        $u->email=time();
                        $u->save();
                        User::destroy($user_model->id);
                        // User::where('id',$user_model->id)->delete();
                    } catch (\Exception $e) {

                    }
                }
			}
			
            if ($request['indication'] == 'merchant') {
                try {
				//	dd($request->get('all_own_delivery'));
                    $user = new User();
					$user_model = $user->store($request);//return new user record in db
	               
					$bank = new BankAccount();
					$bank_model = $bank->store($request);

					//TODO: for adding address first create address then add address id to merchant table
					//country_id   => working
					$address = new Address();
					$address_model = $address->storelatlong($request);
					// user_id, country_id, address_id, bank_id => working
					$user_as_merchant = new Merchant();
					$user_as_merchant_model = $user_as_merchant->store($request, $user_model, $bank_model, $address_model);

				/*	if($request->get('sline1') != ""){
						$merchant_address = new Address();
						$merchant_address->city_id = $request->get('mcity_id');
						$merchant_address->postcode = $request->get('mzip');
						$merchant_address->line1 = $request->get('sline1');
						$merchant_address->line2 = $request->get('sline2');
						$merchant_address->line3 = $request->get('sline3');
						$merchant_address->line4 = $request->get('sline4');
						$merchant_address->type = 'default';

						if ($merchant_address->save()) {
							DB::table('merchant')->where('id', $user_as_merchant_model->id)->update(array(
								'oshop_address_id' => $merchant_address->id,
								'return_address_id' => $merchant_address->id,
								));
						}
					}*/
					$uniqueid = (new UtilityController)->selleruniqueid($request->get('city_id'),'00');
					DB::table('nsellerid')->insert(['nseller_id'=>$uniqueid, 'user_id' => $user_model->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					$qr = (new UtilityController)->createQr($user_as_merchant_model->id,'merchant',IdController::nSeller($user_model->id));
					
					/*
					 * Document table
					 */

					try {
						$documents = new Document();
						$documents_model = $documents->store($request, $user_as_merchant_model);
					} catch (\Exception $e) {
						dump ("Below dump is of exception happening in Block 1");
                        dump($e);
					}
					

					//todo: add brand
					//1)create merchant and get model
					//2)create all brand and get all models
					//3)sync merchant model with brand models in merchantbrand table
					/*** Merchant Album ***/
					DB::table('album')->insert(['merchant_id' => $user_as_merchant_model->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

					$brand = new MerchantBrand();
					$brand_models = $brand->store($request, $user_as_merchant_model->id);


					//http://laravel.com/docs/5.1/eloquent-relationships#inserting-many-to-many-relationships
					//for storing web sites in "merchantwebsite" table
					//first create merchant and get id
					//then create websites and get website model array like director
					//then attach merchant with each website id

					$website = new Website();
					$website_models = $website->store($request);

					//attachment with merchant in "merchantwebsite" table

					$user_as_merchant->attachWebsites($website_models, $user_as_merchant_model);

					$director = new Director();
					$director_model = $director->store($request, $user_as_merchant_model);
					
					$enabled_email = $request->get('checkemail');
					$contactemail = $request->get('contactemail');
					$contactname = $request->get('contactname');
					$ii = 1;
					foreach($contactemail as $contact){
						$enable = false;
						if(in_array($ii,$enabled_email)){
							$enable = true;
						}
						$email = DB::table('contactemail')->insertGetId(['email'=>$contact,'name'=>$contactname[$ii - 1],'enable'=>$enable, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
						DB::table('merchantcontactemail')->insertGetId(['contactemail_id'=>$email,'merchant_id'=>$user_as_merchant_model->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
						$ii++;
					}

					$oshops = $request->get('oshop_name');
					$oshop_ids = $request->get('oshop_ids');
					$oshop_brand_name = $request->get('oshop_brand_name');
					$oshop_url = $request->get('oshop_url');
					$oshop_value_url = $request->get('hoshop_url');
					if(count($oshops) > 0)
					{
						for ($i = 0; $i < count($oshops); $i++) {
							if($oshop_ids[$i] == 0 && $oshops[$i] != ""){							
								$oshop = DB::table('oshop')->insertGetId(['oshop_name'=>$oshops[$i],'url'=>$oshop_value_url[$i],'original_url'=>$oshop_value_url[$i],'brand_id'=>$oshop_brand_name[$i],'address_id'=>0,'shop_size'=>0,'contact_first_name'=>"",'contact_last_name'=>"",'contact_mobile_no'=>"",'status'=>'pending','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
								DB::table('merchantoshop')->insert(['oshop_id'=>$oshop,'merchant_id'=>$user_as_merchant_model->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);	
								$uniqueid = (new UtilityController)->branchuniqueid($request->get('city_id'),'06');
								if($uniqueid != ""){
									$nbid = DB::table('nbranchid')->insertGetId(['nbranch_id'=>$uniqueid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
									
									DB::table('nbranchoshopid')->insertGetId(['nbranchid_id'=>$nbid, 'oshop_id'=>$oshop, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
								}	
								$qr = (new UtilityController)->createQr($oshop,'oshop', URL::to('/') . '/o/' . $oshop_value_url[$i]);
							//	DB::table('nbranchid')->insert(['nbranch_id'=>$uniqueid, 'oshop_id' => $oshop, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
							}

						}
					}			

					$merchants = DB::table('merchant')->
						join('users','users.id','=','merchant.user_id')->
						join('address','address.id','=','merchant.address_id')->
						where('merchant.id',$user_as_merchant_model->id)->
						select('merchant.*', 'address.id as addressid',
							'users.first_name', 'users.last_name',
							'users.mobile_no')->first();
					if(!is_null($merchants)){		
						$oshop = DB::table('oshop')->
						insertGetId([
							'oshop_name'=>"Single",
							'brand_id'=>0,
							'address_id'=>$merchants->addressid,
							'shop_size'=>'0',
							'contact_first_name'=>$merchants->first_name,
							'contact_last_name'=>$merchants->last_name,
							'contact_mobile_no'=>$merchants->mobile_no,
							'status'=>'active',
							'single'=>true,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')]);

						DB::table('merchantoshop')->insert([
							'merchant_id'=>$merchants->id,
							'oshop_id'=>$oshop,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')]);	
							
						DB::table('oshop')->where('id',$oshop)->update(['url'=>$oshop, 'original_url'=>$oshop]);
						
						$uniqueid = (new UtilityController)->branchuniqueid($request->get('city_id'),'06');
						if($uniqueid != ""){
							$nbid = DB::table('nbranchid')->insertGetId(['nbranch_id'=>$uniqueid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
							
							DB::table('nbranchoshopid')->insertGetId(['nbranchid_id'=>$nbid, 'oshop_id'=>$oshop, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						}		
						$qr = (new UtilityController)->createQr($oshop,'oshop',$oshop);

						/***** CODE FORM COMPANY CREATION *****/
						$cname = trim($merchants->company_name);
						$cdesc = trim($merchants->description);
			

						$farray = explode(" ",$cname);	
						$num = count($farray);
		

						if($num == 1){
							$sysname = strtolower(substr($farray[0],0,3));
						} else if($num == 2){
							$sysname =strtolower(substr($farray[0],0,1) .
								substr($farray[1],0,1));
						} else if($num >= 3) {
							$sysname = strtolower(substr($farray[0],0,1) .
								substr($farray[1],0,1) . substr($farray[2],0,1));
						} else {
							$sysname = "n/a";
						}


						DB::table('company')->insert(['sysname'=>$sysname,
							'owner_user_id'=>$merchants->user_id,
							'dispname'=>$cname,
							'company_name'=>$cname,
							'description'=>$cdesc,
							'created_at'=>date('Y-m-d H:i:s'),
							'updated_at'=>date('Y-m-d H:i:s')]);
					}							
                    $e= new EmailController;
                    $e->merchantOnboard($request->email);
					$tokens = DB::table('product')->where('segment','token')->where('retail_price','>=',1000000)->get();
					foreach($tokens as $token){
						DB::table('tokenuserproduct')->insert(['product_id'=>$token->id,'user_id'=>$merchants->user_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					}
					DB::table('fairlocation')->insert(['company_name'=>"Warehouse",'location'=>"Warehouse",'user_id'=>$merchants->user_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					/*save all FKs of directors & merchants to merchantdirectos tables */
					//$user_as_merchant_model->attachDirectors($director_model, $user_as_merchant_model);
					// try{
					// 	$mgClient = new Mailgun('key-80495c8905443d885803333b49b45718');
					// 	$domain = "opensupermall.com";

					// 	# Make the call to the client.
					// 	$result = $mgClient->sendMessage($domain, array(
					// 		'from'    => 'Opensupermall <info@opensupermall.com>',
					// 		'to'      => $user_model->first_name . ' ' . $user_model->first_name .  ' <'. $user_model->email .'>',
					// 		'subject' => 'Confirm your Merchant Opensupermall account',
					// 		'html'    => '<h4>Plase, confirm your Opensupermall Account!</h4>
					// 					<p>click on the following link: <a href="'.url().'/verifymerchant/'.$user_as_merchant_model->id.'">Confirm</a></p>'
					// 	));					
					// } catch (\Exception $e) {
						
					// }						
					// Auth::login($user_model);
					//Auth::attempt(['email' => $user_model->email,'password'=> $user_model->password]);
					/*if($request->get('all_own_delivery') == 1){
						$this->alsologistic($user_model->id);
					}*/
					$role_type = $request->get('role_type');
					//dd($role_type);
					if($role_type == 'humancap'){
						$rr = DB::table('roles')->where('slug','hcu')->first();
						if(!is_null($rr)){
							$role = new RoleUser;
							$role->user_id = $user_model->id;
							$role->role_id = $rr->id;
							$role->save();
						}
						$ff = DB::table('facility')->where('name','empbnf')->first();
						if(!is_null($ff)){
							DB::table('sellerfacility')->insert(['user_id'=>$user_model->id, 'facility_id' => $ff->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
						}
					} else if($role_type == 'fairmode'){
						$rr = DB::table('roles')->where('slug','fmu')->first();
						if(!is_null($rr)){
							$role = new RoleUser;
							$role->user_id = $user_model->id;
							$role->role_id = $rr->id;
							$role->save();
						}
						$ff = DB::table('facility')->where('name','fair')->first();
						if(!is_null($ff)){
							DB::table('sellerfacility')->insert(['user_id'=>$user_model->id, 'facility_id' => $ff->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
						}
					} else {
						$rr = DB::table('roles')->where('slug','mer')->first();
						if(!is_null($rr)){
							$role = new RoleUser;
							$role->user_id = $user_model->id;
							$role->role_id = $rr->id;
							$role->save();
						}
						$ff = DB::table('facility')->where('name','ecomm')->first();
						if(!is_null($ff)){
							DB::table('sellerfacility')->insert(['user_id'=>$user_model->id, 'facility_id' => $ff->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
						}
					}
					\Session::flash(Config::get('messages.key.name'), $this->messageHandler->success('merchantRegistered', null, null, true, true, true));
	//                if(Auth::attempt(['email' => $user_model->email,'password'=> $user_model->password])){
	//                    redirect("home");
	//                }
                    // throw new Exception("Error Processing Request", 1);
                    
                } catch (\Exception $e) {
					
					\Session::flash(Config::get('messages.key.name'), $this->messageHandler->error('merchantError', null, null,null, true, true, true));
                    echo "<script>console.log(".$e->getMessage().")</script>";
					//dd($e);
					try {
                        // Setting email to be garbage
                        $u= User::find($user_model->id);
                        $u->email=time();
                        $u->save();
                        User::destroy($user_model->id);
                        // User::where('id',$user_model->id)->delete();
                    } catch (\Exception $e) {

                    }
                    try {
                        BankAccount::destroy($bank_model->id);
                    } catch (\Exception $e) {

                    }
                    try {
                        Address::destroy($address->id);
                    } catch (\Exception $e) {

                    }
                    try {
                        Merchant::destroy($user_as_merchant_model->id);
                    } catch (\Exception $e) {

                    }
                    try {
                        Document::destroy($documents_model->id);
                    } catch (\Exception $e) {

                    }
                    try {
                        MerchantBrand::destroy($brand_models->id);
                    } catch (\Exception $e) {

                    }
                    try {
                        Website::destroy($website_models->id);
                    } catch (\Exception $e) {

                    }
					
                }

            }

            if ($request['indication'] == 'station') {
				/*$input = $request->all();
				dd($input);*/
				/*$container = $request->get('container');
				dd($container);*/
				$type = $request->get('mytype');
                $user = new User();
                $user_model = $user->store($request);//return new user record in db

//				dd($user_model);
                $bank = new BankAccount();
                $bank_model = $bank->store($request);

                //TODO: for adding address first create address then add address id to station table
                //country_id   => working
                $address = new Address();
                $address_model = $address->store($request);

                // user_id, country_id, address_id, bank_id => working
                $user_as_station = new Station();
                $user_as_station_model = $user_as_station->store($request, $user_model, $bank_model, $address_model);
				
                $documents = new Document();
                $documents_model = $documents->store($request, $user_as_station_model);

                //todo: add brand
                //1)create station and get model
                //2)create all brand and get all models
                //3)sync station model with brand models in stationbrand table
				
                $brand = new StationBrand();
                $brand_models = $brand->store($request, $user_as_station_model->id);

                //http://laravel.com/docs/5.1/eloquent-relationships#inserting-many-to-many-relationships
                //for storing web sites in "stationwebsite" table
                //first create station and get id
                //then create websites and get website model array like director
                //then attach station with each website id

                $website = new Website();
                $website_models = $website->store($request);

                //attachment with station in "stationwebsite" table

                $user_as_station->attachWebsites($website_models, $user_as_station_model);
                try {
                	$director = new Director();
                $director_model = $director->store($request, $user_as_station_model);
                } catch (\Exception $e) {
                	
                }
                
				$sellertype = "01";
				if(!is_null($request->get('sign_up_merchant_from_station'))){
					if($request->get('sign_up_merchant_from_station') ==  1){
						$station = DB::table('station')->where('user_id',$user_model->id)->first();

						$user_as_merchant = new Merchant();
						$user_as_merchant_model = $user_as_merchant->store_fromstation($station, $user_model->id);
						
						$mdocuments = DB::table('stationdocument')->where('station_id',$station->id)->get();
						foreach($mdocuments as $mdocument){
							DB::table('merchantdocument')->insert(['merchant_id'=>$user_as_merchant_model->id,'document_id'=>$mdocument->document_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
						}

						$mbrands = DB::table('stationbrand')->where('station_id',$station->id)->get();
						foreach($mbrands as $mbrand){
							DB::table('merchantbrand')->insert(['merchant_id'=>$user_as_merchant_model->id,'brand_id'=>$mbrand->brand_id,'subcat_id'=>$mbrand->subcat_id,'subcat_level'=>$mbrand->subcat_level,'relationship'=>$mbrand->relationship,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
						}
						//http://laravel.com/docs/5.1/eloquent-relationships#inserting-many-to-many-relationships
						//for storing web sites in "stationwebsite" table
						//first create station and get id
						//then create websites and get website model array like director
						//then attach station with each website id
						
						$mwebsites = DB::table('stationwebsite')->where('station_id',$station->id)->get();
						foreach($mwebsites as $mwebsite){
							DB::table('merchantwebsite')->insert(['merchant_id'=>$user_as_merchant_model->id,'website_id'=>$mwebsite->website_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
						}		

						$mdirectors = DB::table('stationdirector')->where('station_id',$station->id)->get();
						foreach($mdirectors as $mdirector){
							DB::table('merchantdirector')->insert(['merchant_id'=>$user_as_merchant_model->id,'director_id'=>$mdirector->director_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
						}			
						
						$role = new RoleUser;
						$role->user_id = $user_model->id;
						$role->role_id = 3;
						$role->save();	
						$sellertype = "02";
					}
				}
				//dump("Email will fire up now. The next //dump if 0 means email has no issue");
                $e= new EmailController;
				$e->stationOnboard($request->email);

				/***** CODE FORM COMPANY CREATION *****/
				$cname = trim($user_as_station_model->company_name);
				$cdesc = trim($user_as_station_model->description);

				$farray = explode(" ",$cname);	
				$num = count($farray);


				if($num == 1){
					$sysname = strtolower(substr($farray[0],0,3));
				} else if($num == 2){
					$sysname =strtolower(substr($farray[0],0,1) .
						substr($farray[1],0,1));
				} else if($num >= 3) {
					$sysname = strtolower(substr($farray[0],0,1) .
						substr($farray[1],0,1) . substr($farray[2],0,1));
				} else {
					$sysname = "n/a";
				}


				$company = DB::table('company')->insertGetId(['sysname'=>$sysname,
					'owner_user_id'=>$user_as_station_model->user_id,
					'dispname'=>$cname,
					'company_name'=>$cname,
					'description'=>$cdesc,
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')]);
				
				
				if($type != 'logistic'){
					$property = new Sproperty();
					$property_model = $property->store($request,$user_as_station_model->id);	
					$uniqueid = (new UtilityController)->selleruniqueid($request->get('city_id'), $sellertype);
					DB::table('nsellerid')->insert(['nseller_id'=>$uniqueid, 'user_id' => $user_model->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]); 
					$qr = (new UtilityController)->createQr($user_as_station_model->id,'station',IdController::nSeller($user_model->id));
				} else {
					$distributioncenter = new Districenter();
					$property_model = $distributioncenter->store($request,$user_as_station_model->id);	
					$role = new RoleUser;
					$role->user_id = $user_model->id;
					$role->role_id = 13;
					$role->save();	
					$api = 0;
					$professional = 0;
					if(!is_null($request->get('support_api'))){
						$api = 1;
					}
					if(!is_null($request->get('professional'))){
						$professional = 1;
					}
			//		dump($request->get('capabilities'));	
					
					$loid = DB::table('logistic')->insertGetId(['station_id'=>$user_as_station_model->id, 'lgrade_id' => 1,'api' => $api,'professional'=>$professional,'company_id'=> $company,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					$capabilities = $request->get('capabilities');
					foreach($capabilities as $capability){
						if($capability != ""){
							$exists = DB::table('logisticcapability')->where('logistic_id',$loid)->where('capability_id',$capability)->first();
							if(is_null($exists)){
								DB::table('logisticcapability')->insert(['logistic_id'=>$loid,'capability_id'=>$capability, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
							}
						}
					}
					$uniqueid = (new UtilityController)->sprovideruniqueid($request->get('city_id'), "03");
					if($uniqueid != ""){
						$nlid = DB::table('nsproviderid')->insertGetId(['nsprovider_id'=>$uniqueid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						
						DB::table('nsproviderlogisticid')->insertGetId(['nsproviderid_id'=>$nlid, 'logistic_id'=>$loid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}
					//DB::table('nsproviderid')->insert(['nsprovider_id'=>$uniqueid, 'user_id' => $user_model->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]); 
				}
				
				$enabled_email = $request->get('checkemail');
				$contactemail = $request->get('contactemail');
				$contactname = $request->get('contactname');
				$ii = 0;
			//	dump($contactemail );
			//	dd($enabled_email );
				foreach($contactemail as $contact){
					$enable = false;
					if(in_array($ii,$enabled_email)){
						$enable = true;
					}
					$email = DB::table('contactemail')->insertGetId(['email'=>$contact,'name'=>$contactname[$ii],'enable'=>$enable, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
					DB::table('stationcontactemail')->insertGetId(['contactemail_id'=>$email,'station_id'=>$user_as_station_model->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
					$ii++;
				}		
				
				$stype = DB::table('stationtype')->where('name',$type)->first();
				$stypeid = 0;
				if(!is_null($stype)){
					$stypeid = $stype->id;
				}
				$tokens = DB::table('product')->where('segment','token')->where('retail_price','>=',1000000)->get();
				foreach($tokens as $token){
					DB::table('tokenuserproduct')->insert(['product_id'=>$token->id,'user_id'=>$user_model->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				}
				DB::table('station')->where('id',$user_as_station_model->id)->update(['stationtype_id'=>$stypeid]);
				\Session::flash(Config::get('messages.key.name'), $this->messageHandler->success('stationRegistered', null, null, true, true, true));
            }
			
			return redirect()->route('home');


        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function product_like(Request $request)
    {
		if(!Auth::check()) return "Please login";

		$productId = $request->get('itemId');

		$userId = Auth::user()->id;

		$sql = DB::select(DB::raw("SELECT id FROM usersproduct WHERE user_id = ".$userId." AND product_id = ".$productId
				));
		$returnresp['incremented'] = false;
		if(sizeof($sql)==0){
			$sql = DB::select(DB::raw("INSERT INTO usersproduct (user_id, product_id, created_at, updated_at)
									VALUES (".$userId.", ".$productId.", '".date("Y-m-d H:i:s") ."','".date("Y-m-d H:i:s") ."')"));
			$returnresp['incremented'] = true;
		} else {
			DB::table('usersproduct')->where('product_id',$productId)->where('user_id',$userId)->delete();
		}
		$returnresp['likes'] = DB::table('usersproduct')->where('product_id',$productId)->count();
		$returnresp['ok'] = true;
		return $returnresp;

	}
	
    public function delete_like(Request $request)
    {
		if(!Auth::check()) return "Please login";

		$product_id = $request->get('product_id');

		$user_id = Auth::user()->id;

		DB::table('usersproduct')->where('user_id', '=', $user_id)->where('product_id', '=', $product_id)->delete();

		$returnresp['ok'] = true;
		return $returnresp;

	}	
	
	public function mywishlist(Request $request)
    {
		$user_id = $request->get('user_id');
		$wishlist = DB::table('wishlist')->join('product','product.id','=','wishlist.product_id')
		->where('user_id', '=', $user_id)->where('product.status', '=', 'active')
		->select('product.*','wishlist.quantity as wish')->get();
		return view('buyer.newbuyerinformation.wishlist.detail')
            ->with('wishlist' ,$wishlist);	
	}
	
	public function add_wishlist(Request $request)
    {
		if(!Auth::check()) return "Please login";

		$product_id = $request->get('product_id');
		$user_id = $request->get('user_id');
		$quantity = $request->get('quantity');

		DB::table('wishlist')->where('user_id', '=', $user_id)->where('product_id', '=', $product_id)->delete();
		DB::table('wishlist')->insert(['user_id' =>  $user_id, 'product_id' => $product_id, 'quantity' => $quantity, 'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);

		$returnresp['ok'] = true;
		return $returnresp;

	}

    public function add_to_wish_list(Request $request, OWish $OWish)
    {
        if ( !$request->ajax() ) return redirect()->back();

        if(!Auth::check()) 

        {
            return "Not Authorized";
        }
        $currency= DB::table('currency')->where('active', 1)->first()->code;
        $productId = $request->get('itemId');
        $custom_message=$request->get('custom_message');
        // Validation
        
        /* This is the user_id of the SMM/OpenWisher, NOT the merchant!!!
		 * Obviously Dev. Duh! */
        $userId = Auth::user()->id;

        $product = Product::find($productId);
        $ow=OpenWish::where('user_id',$userId)->
        where('product_id',$productId)->
        where('status','active')->
        first();
       // dd($ow);
        if (!is_null($ow)) {
            
                $message="This product has already been added to your OpenWish. Please reshare it from your buyer's dashboard";
            return response()->json(['status'=>'success','short_message'=>'Success','long_message'=>$message]);
            
        }
            // Check for token
        $access_token= DB::table('oauth_session')->where('user_id',$userId)->pluck('access_token');
        if (is_null($access_token)) {
                return -1 ;
        }
        // Knowing the product we figure out who the merchant is
        $product_parent_Id=Product::find($productId)->pluck('parent_id');
        $mprod = MerchantProduct::where('product_id', $product_parent_Id)->first();
		if(isset($mprod)){
			$merchant = Merchant::find($mprod->merchant_id);
			if(isset($merchant)){
				$openWish = OpenWish::where('product_id', $productId)
					->where('user_id', $userId)->first();
				$rp = $product->discounted_price;
				$op = $product->retail_price;
                if ($rp!=0) {
                    $pricing=$rp;
                    $discount=(($op-$rp)/$op)*100;

                } else {
                    $pricing=$op;
                    $discount=null;
                }
                // switch ($rp) {
                //     case $rp!=0 and $rp < $op:
                //         $pricing= $rp;
                //         $discount=(($op-$rp)/$op)*100;
                //         break;
                //     case $rp=0;
                //         $pricing=$op;
                //         $discount=null;
                //     default:
                //         # code...
                //         break;
                // }

				// Add Openwish commission
                // $ow_comm_percent=DB::table('global')->first()->ow_commission;
                $delivery=0;
                $pricing= $pricing+$delivery;
                // $ow_comm=($pricing*$ow_comm_percent)/100;
            
                // $pricing=$pricing+$ow_comm;
				$pid = $product->parent_id;
				$pname = $product->name;
				$base_url =url();
				$img_url = $base_url."/images/product/".$pid."/".
							$product->photo_1;

				// Find the latest OpenWish record
				$ow = OpenWish::where('product_id', $pid)->
						orderBy('created_at')->first();

				$data = array(
					'product_id' => $productId,
					'user_id' => $userId,
					//'link_id' => $graphNode['id']
				);

				/* Insert product selected to openwish list table
				 * with pending status */
				$open_wish= $this->dispatch(WishListJob::getInstance($data));
				$pledge = 0;
				$balance = $op;
                if(isset($openWish))
                    $openWishPledge = OpenWishPledge::where('openwish_id', $openWish->id)->get();
                        if(isset($openWishPledge) && !empty($openWishPledge))
                            foreach($openWishPledge as $owp){
                                $pledge += $owp->pledged_amt;
                            }else
                                $pledge = 0;
				$balance = number_format(($pricing/100) - ($pledge / 100) , 2);
                $pledge /= 100;
				//Prepare link data for facebook
                $us= new UrlShortenerController;
                $shortened_url= $base_url."/u/".
					$us->shorten($base_url."/productconsumer/".$pid . '/' .
					$open_wish->id,'owish',$open_wish->id);

                //$description=strip_tags(substr($product->product_details,0,9000));
                $currency=Currency::where('active',1)->first()->code;
                $pricing= number_format($pricing/100,2);
                $discount=number_format($discount,2);
				$linkData = [
					'link' => $shortened_url,
					'from' => "Opensupermall",
					'message' =>$custom_message,
					'icon' => "http://beta.opensupermall.com/images/logo-white.png",
					'picture' => $img_url,
					'caption' => $merchant->oshop_name."@OpenSupermall",
					'name' => "** OpenSupermall ** | ".ucwords($pname),
					'description' => "Price:".$currency." ".$pricing.
					"|Discount:".$discount."%|Accumulated:".
					$currency." ".$pledge."|Balance:".$currency." ".$balance,
				];
                // return $linkData;
				//Post selected product to facebook user's profile, from "app/OWish.php"
                $errorCheck = $OWish->facebook($linkData);
                   
                if($errorCheck['ok']){
                    //    $errorCheck['ok'] = true;
                    $o= OpenWish::find($open_wish->id);
                    $o->status="active";
                    $o->save();
                    $merchantunique_id=DB::table('nsellerid')->where('user_id',$merchant->user_id)->pluck('nseller_id');
                    $type_pdr="openwish";
                    $color=1;
                    $openwish_id=$o->id;
                    $nopenwish_id=UtilityController::productuniqueid($merchant->id, $merchantunique_id, $type_pdr, $color, $openwish_id);
                    try {
                        DB::table('nopenwishid')
                    ->insert([
                        'nopenwish_id'=>$nopenwish_id,
                        'openwish_id'=>$o->id
                        ]);
                    } catch (\Exception $e) {
                        
                    }
                    
                    $message = "Your OpenWish of ".$product->name." (".$currency."".$pricing.") has been posted to your Facebook account ";
                    
                    return response()->json(['status'=>'success','short_message'=>'Success','long_message'=>$message]);
                    //    return "Your OpenWish of ".$product->name." (MYR".$pricing.") has been posted to your Facebook account ";
                } else {
                    return response()->json(['status'=>'failure','short_message'=>'Token Failure','long_message'=>"Please register to use the feature"]);
                    $errorCheck['url'] = TokenController::connect();
                    return $errorCheck;
                }
            } else {
                return response()->json(['status'=>'failure','short_message'=>'Server Failure','long_message'=>"We could not add your OpenWish"]);
                return "We could not add your OpenWish";
            }
        } else {
            return response()->json(['status'=>'failure','short_message'=>' Failure','long_message'=>"Please try again later"]);
            return "We could not add your OpenWish";
        }

    }

	public function openwishPledge($openwish_id)
	{
		$openwish = OpenWish::where('id', $openwish_id)->first();
		if(!is_null($openwish)){
			$product = Product::find($openwish->product_id);
			$openWishPledge = OpenWishPledge::where('openwish_id', $openwish->id)->get();
			$pledged_amt = 0;
			if(isset($openWishPledge) && !empty($openWishPledge)){
				foreach($openWishPledge as $owp){
					 $pledged_amt += $owp->pledged_amt;
				}
			} 
			
			return view('openwish_pledge')->with('product',$product)->with('pledged_amt',$pledged_amt)->with('openwish_id',$openwish->id);
		} else {
				return view('common.generic')
				->with('message_type','error')
				->with('message','OpenWish product not found');
		}
		
	}
	
    public function postOpenwishPledge(OpenwishPledgeRequest $request, $openwish_id)
    {

        $openwish=OpenWish::find($openwish_id);
        if (empty($openwish)) {
            return Redirect::back()->withErrors(["This OpenWish doesn't exists."]);
        }
        if ($openwish->status!="active") {
            return Redirect::back()->withErrors(['This OpenWish is not accepting contributions.']);
        }
        $product = Product::find($openwish->product_id);
        $oshop_name = $product->merchant->first()->oshop_name;
		
        //Check if this product exists
        if(!$product) return redirect()->back();

        if (!is_null(Auth::user()) && !is_null(Auth::user()->email)) {
			$email = Auth::user()->email;
		}
        // $data = array(
        //     'openwish_id'    => $openwish_id,
        //     'smedia_id'      => 1, //i am not sure whats fb
        //     'smedia_account' => $email,
        //     'source_ip'      => $request->ip(),
        //     'pledged_amt'    => $request->pledged_amt,
        // );

        //Add openwish pledge record to db, in order to keep track
        // $this->dispatch( new OpenwishPledgeJob($data) );

        /**/
        if ($request->pledged_amt<=0) {
             return Redirect::back()->withErrors([ 'Contribution amount cannot be zero.']);
         } 
        /*Convert float to int*/
        $op=explode(".",$request->pledged_amt);
        
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
        /*Delivery for Product*/
        $del=new Delivery;
        $actual_delivery_price=$del->get_delivery_price($product->id,1,False)/100; 
        /*Validation for amount danger Danger prices not locked*/
        $product_price=UtilityController::realPrice($product->id);
        $total_raw_cost=$product_price+$actual_delivery_price;



        $pledge_amt = OpenWishPledge::select(DB::raw('SUM(pledged_amt) as pledged_amt'))->where('openwish_id', $openwish_id)->first()->pledged_amt;
        $total_cost=$total_raw_cost-$pledge_amt;

        if ($amount>$total_cost) {
            return Redirect::back()->withErrors(['Contribution amount is more than allowed.']);
        }

        foreach (Cart::contents() as $c) {
            if ($c->openwish_id==$openwish_id) {
                $c->remove();
            }
        }
        //Add shared product to the cart
        Cart::insert(array(
            'id'          => $product->id,
            'parent_id'   => $product->id,
            'name'        => $product->name,
            'delivery'        => $actual_delivery_price/100,
            'price'       => $amount,
            'quantity'    => 1,
            'image'       => $product->photo_1,
            'openwish_id' => $openwish_id,
            'pledged_amt' => $amount,
            'mode'        =>'owish',
            'oshop_name'  => $oshop_name,
            'openwisher_name'=>$request->custom_name,
            'openwisher_message'=>$request->custom_message
        ));

        return redirect('/cart');
    }

    /**
     * SMM out
     * Ajax call
     * @param Request $request
     * @param OWish $OWish
     * @return string
     */
    public function checkIfMinDuration($user_id, $smm_min_duration)
    {
        return DB::table('smmout')->where('user_id', $user_id)
            ->where(DB::raw('created_at >= date_sub(NOW(), INTERVAL '. $smm_min_duration .' hour)'))
            ->count();
    }
    public function smediaMarketer(Request $request, OWish $OWish)
    {
        if(!$request->ajax()){
            return redirect()->back();
        }

        if(!Auth::check()) return 'Please login';


        $user_id = Auth::user()->id;

        if (isset($request->user_id) and Auth::user()->hasRole('adm')) {
            $user_id=$request->user_id;
        }

        /*Check for SMM ARMY*/
        if (Auth::user()->hasRole('mer')) {
            $s= new SMMController;
             return $s->execute_army($request);
         } 
        $smm_min_duration = globalSettings('smm_min_duration');
        $custom_message=$request->custom_message;
        // $smm_min_duration=999999999;
        // $isAllowed = $this->checkIfMinDuration($user_id, $smm_min_duration);
        // if ($isAllowed!=0) {
        //     # code...
        //     return "Please wait for sometime. You have reached the limit.";
        // }
        $sst_status=DB::table('sales_staff')->where('user_id',$user_id)->pluck('status');
        if (empty($sst_status)) {
            return -1;
        }
        if ($sst_status !="active") {
            return "You have been barred from using SMM. Please contact OpenSupport";
        }
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        if ($product->smm_selected==False or $product->oshop_selected==False or $product->available ==0 or $product->status!="active") {
            return "This product is not eligible for SMM";
        }
        // return $product;
        $pid = $product->parent_id;
        $pname = $product->name;
        // $base_url ="{{url('/')}}";
        $base_url=url();
        $img_url = $base_url."/images/product/".$pid."/".
            $product->photo_1;
        // Knowing the product we figure out who the merchant is
        $mprod = MerchantProduct::where('product_id', $product_id)->first();
        if (is_null($mprod)) {
            return "Error: Merchant Product not found";
        }
        $merchant = Merchant::find($mprod->merchant_id);
        if (is_null($merchant)) {
            # code...
            return "Error: Merchant not found";
        }
        // return "Merchant Id: ".$mprod->merchant_id;
        // return $merchant;
        $rp = $product->discounted_price/100;
        $op = $product->retail_price/100;

        if ($op > 0 && $op > $rp && $rp>0) {
            $pricing = $rp;
            // Discount case
           
            $discount = number_format((($op-$rp)/$op)*100, 0)."%";
             
            
        } else {
             $pricing = $op;
            $discount = null;
           
        }
        // return $pricing;
        // return $discount;
        // $access_token=Auth::user()->access_token;
        // Needs to be edited if multiple social account are there
        $os= DB::table('oauth_session')->where('user_id',$user_id)->first();
        
        if (is_null($os)) {
            # code...
            return -1
                ;
        }
        $access_token=$os->access_token;
        $fb_url= "https://graph.facebook.com/me/friends?access_token=".(string)$access_token;
        try {
            $json = json_decode(file_get_contents($fb_url), true);
        } catch (\Exception $e) {
            return -1;
        }
        $comm=SMMController::getCommission($product_id);
        if ($comm==0) {
            return "This product is not available for SMM.";
        }
        $totalFBfriends = intval($json['summary']['total_count']);
        DB::table('oauth_session')->where('id',$os->id)
        ->update(['connections'=>$totalFBfriends]);
        // return $totalFBfriends;
        $smmOut = SMMout::create(array(
            'user_id' => $user_id,
            'product_id' => $product_id,

        ));
        /*Save nsmmid*/
        UtilityController::smm_unique_id($smmOut->id); 
        /*Add code for nsmmid*/ 
        $us= new UrlShortenerController;
        $shortened_url= $us->shorten($base_url."/cart/smmin/".$product_id. '/' .$smmOut->id,'smm',$smmOut->id);
        // return $shortened_url;
        // return $base_url.'/u/'.$shortened_url;
        //$description=strip_tags(substr($product->product_details,0,9000));
        $currency= Currency::where('active',1)->first()->code;
        // return "The description length is ".strlen($description);
        // return $discount;
        $icon="https://zeta.opensupermall.com/images/logo-white.png";
        $linkData = [
            'link' => $base_url.'/u/'.$shortened_url,
            'from' => "FOO BAR BAZ",
            'message' =>$custom_message,
            'icon' => $icon,
            'picture' => $img_url,
            'caption' => $merchant->oshop_name."@OpenSupermall",
            'name' => "** OpenSupermall ** | ".ucwords($pname),
			'description' => "Price:".$currency." ".$pricing.
				" | Discount:".$discount
        ];
        // dd($linkData);
        //Post selected product to facebook user's profile, from "app/OWish.php"
        $graphNode = $OWish->facebook($linkData);
        // dd($graphNode['graphNode']['id']);
        SMMout::where('id', $smmOut->id)->update(array('connections'=>$totalFBfriends,'object_id' => $graphNode['graphNode']['id']));

        return response()->json(['mode'=>'user','long_message'=>'This product -> '.$pname." has been shared through your Facebook account"]);

    }

    public function smmInMarketer(Request $request, $product_id = null, $smmout_id = null)
    {
        $product = Product::find($product_id);
        $smmOut = SMMout::find($smmout_id);

        if(!$product || !$smmOut){
            return redirect()->back();
        }
        $ip_of_client=UtilityController::get_ip();
      

        //Create SMMin
        $smmin=SMMin::create(array(
            'smmout_id' => $smmOut->id,
            'smedia_id' => 1, //facebook id,
            'source_ip' => $ip_of_client,
            'response' => 'view'
        ));
        $rp = $product->discounted_price/100;
        $op = $product->retail_price/100;
        if ($op > 0 && $op > $rp && $rp>0) {
            $pricing = $rp;
             // $discount = null;
            
        } else {
            $pricing = $op;
            // $discount = number_format((($op-$rp)/$op)*100, 0);
           
        }
        //Add shared product to the cart
        Cart::insert(array(
            'id'          => $product->id,
            'parent_id' =>$product->id,
            'name'        => $product->name,
            'price'       => $pricing*100,
            'quantity'    => 1,
            'image'       => $product->photo_1,
            'smmout_id'   => $smmOut->id,
            'smmin_id'    =>$smmin->id,
            'smedia_id'   => 1,
            'mode'        =>'smm',
        ));
        // echo '
        //     <meta property="fb:app_id" content="1679564205590693" />
        // <meta property="og:site_name" content="OpenSupermall" />
        // <meta property="og:title" content="'.$product->name.'" />
        // <meta property="og:image" content="'.asset('/images/product/'.$product->id).'/'.$product->photo_1.'" />
        // <meta property="og:description" content="'.$product->description.'" />
        // <meta property="og:url" content="',url().'/cart/smmin/'.$product->id.'/'.$smmout_id.'" />';
        // echo "You are being redirected.";
        // sleep(1);
        $user=Buyer::join('users','users.id','=','buyer.user_id')
        ->where('users.id',$smmOut->user_id)
        ->where('buyer.user_id',$smmOut->user_id)
        ->select('buyer.photo_1','users.name','users.id')
        ->first()
        ;
        Session::set('smm_opengraph',$product);
        Session::set('smm_opengraph_user',$user);
        return redirect('productconsumer/'.$product->id)
        ->with('product',$product)

        ;
    }


    public function createStation($type = null)
    {
        $canregister = false;
        if(!Auth::check()){
            $canregister = true;
        } else {
            $canregister = true;
            $role= DB::table('role_users')->where('user_id',Auth::user()->id)->join('roles', 'roles.id', '=', 'role_users.role_id')->get();
            foreach ($role as $userrole) {
                if($userrole->name == "station_operator"){
                    $canregister = false;
                }
            }
		}

		if(!$canregister) {
            return redirect()->route('home');

		} else {
            $stationObj = new Station();
            $indication = "station";
            $disabled = 'null';
            $userModel = $stationObj->getStationRelationsFullMeta();
            $route = route('create-new-user-s');
            $brand_table = Brand::orderBy('name')->get();
            $subcat_table1 = SubCatLevel1::orderBy('description')->get();
			$subcats = DB::select(DB::raw(
				"SELECT id, description, levelsub FROM (
					SELECT id, description, '1' as levelsub FROM subcat_level_1
					UNION
					SELECT id, description, '2' as levelsub FROM subcat_level_2
					UNION
					SELECT id, description, '3' as levelsub FROM subcat_level_3
				) as T ORDER BY description"
			));			
            $subcat_table2 = SubCatLevel2::orderBy('description')->get();
            $subcat_table3 = SubCatLevel3::orderBy('description')->get();
            $isbrand = false;
            $state_id =0;

            // if(isset($userModel['websites'])){
            //     dd('true');
            // }else{
            //     dd('false');
            // }
			$system_capabilities = DB::table('capability')->get();
			$lgrades = DB::table('lgrade')->get();
			$logcapabilities = null;
			$outlets = null;
			$centers = null;
			$edit = true;
			$editing = 0;
			$checkapi = "";
			$checkprofessional = "checked";
			$checkown = "";
            return view('user/registerStation', compact(['indication',
				'route', 'disabled', 'checkapi', 'checkown','checkprofessional','checkprofessional', 'system_capabilities', 'lgrades', 'logcapabilities','edit', 'outlets','centers','editing', 'type','userModel', 'subcat_table1','subcats', 'subcat_table2', 'subcat_table3', 'brand_table', 'isbrand','state_id']));
        }
    }

    public function check_for_user($user_id)
    {
        if (!Auth::check()) {
            return response()->json(['status'=>'failure','short_message'=>'Unauthorized Acces','long_message'=>'You need to login']);
        }
        try {
            $user=Buyer::where('user_id', '=', $user_id)->get();
            
		 
			if (count($user) <=0) {
                return response()->json(['status'=>'failure','short_message'=>'Missing Record','long_message'=>'DB Error: Record for user  '.$user_id.' is missing. Please consult OpenSupport.']);
            }
            if (count($user)>0) {
                return response()->json(['status'=>'success','short_message'=>'200','long_message'=>'User record exists.Opening up a new tab']);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failure','short_message'=>'Server Error','long_message'=>'The server is under heavy load. Please consult OpenSupport.' ]);
        }

    }
public function check_for_merchantid($id)
    {
        if (!Auth::check()) {
            return response()->json(['status'=>'failure','short_message'=>'Unauthorized Acces','long_message'=>'You need to login']);
        }
        try {
            $merchant=Merchant::where('id', '=', $id)->get();
            
		 
			if (count($merchant) <=0) {
                return response()->json(['status'=>'failure','short_message'=>'Missing Record','long_message'=>'DB Error: Record for merchant  '.$id.' is missing. Please consult OpenSupport.']);
            }
            if (count($merchant)>0) {
                return response()->json(['status'=>'success','short_message'=>'200','long_message'=>'User record exists.Opening up a new tab']);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failure','short_message'=>'Server Error','long_message'=>'The server is under heavy load. Please consult OpenSupport.' ]);
        }
}

public function check_for_orderid($id)
    {
        if (!Auth::check()) {
            return response()->json(['status'=>'failure','short_message'=>'Unauthorized Acces','long_message'=>'You need to login']);
        }
        try {
            $order=DB::table('porder')->where('id', '=', $id)->get();
            
		 
			if (count($order) <=0) {
                return response()->json(['status'=>'failure','short_message'=>'Missing Record','long_message'=>'DB Error: Record for order  '.$id.' is missing. Please consult OpenSupport.']);
            }
            if (count($order)>0) {
                return response()->json(['status'=>'success','short_message'=>'200','long_message'=>'Order record exists.Opening up a new tab']);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failure','short_message'=>'Server Error','long_message'=>'The server is under heavy load. Please consult OpenSupport.' ]);
        }
}

    public function check_for_station($station_id)
    {
        if (!Auth::check()) {
            return response()->json(['status'=>'failure','short_message'=>'Unauthorized Acces','long_message'=>'You need to login']);
        }
        try {
            $station=Station::find($station_id);
            if (is_null($station)) {
                return response()->json(['status'=>'failure','short_message'=>'Missing Record','long_message'=>'DB Error: Record for station  '.$station_id.' is missing. Please consult OpenSupport.']);
            }
            if (!is_null($station)) {
                return response()->json(['status'=>'success','short_message'=>'200','long_message'=>'Station record exists.Opening up a new tab']);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failure','short_message'=>'Server Error','long_message'=>'The server is under heavy load. Please consult OpenSupport.']);
        }

    }
	
    public function check_for_stationu($station_id)
    {
        if (!Auth::check()) {
            return response()->json(['status'=>'failure','short_message'=>'Unauthorized Acces','long_message'=>'You need to login']);
        }
        try {
            $station=Station::where('user_id',$station_id)->first();
            if (is_null($station)) {
                return response()->json(['status'=>'failure','short_message'=>'Missing Record','long_message'=>'DB Error: Record for station  '.$station_id.' is missing. Please consult OpenSupport.']);
            }
            if (!is_null($station)) {
                return response()->json(['status'=>'success','short_message'=>'200','long_message'=>'Station record exists.Opening up a new tab','id'=> $station->id]);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failure','short_message'=>'Server Error','long_message'=>'The server is under heavy load. Please consult OpenSupport.']);
        }

    }	

 public function check_for_merchant($id)
    {
        if (!Auth::check()) {
            return response()->json(['status'=>'failure','short_message'=>'Unauthorized Acces','long_message'=>'You need to login']);
        }
        try {
            $merchant=merchant::find($id);
            if (is_null($merchant)) {
                return response()->json(['status'=>'failure','short_message'=>'Missing Record','long_message'=>'DB Error: Record for merchant  '.$id.' is missing. Please consult OpenSupport.']);
            }
            if (!is_null($merchant)) {
                return response()->json(['status'=>'success','short_message'=>'200','long_message'=>'Station record exists.Opening up a new tab']);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failure','short_message'=>'Server Error','long_message'=>'The server is under heavy load. Please consult OpenSupport.']);
        }

    }
	
 public function check_for_merchantu($id)
    {
        if (!Auth::check()) {
            return response()->json(['status'=>'failure','short_message'=>'Unauthorized Acces','long_message'=>'You need to login']);
        }
        try {
            $merchant=merchant::where('user_id',$id)->first();
            if (is_null($merchant)) {
                return response()->json(['status'=>'failure','short_message'=>'Missing Record','long_message'=>'DB Error: Record for merchant  '.$id.' is missing. Please consult OpenSupport.']);
            }
            if (!is_null($merchant)) {
                return response()->json(['status'=>'success','short_message'=>'200','long_message'=>'Station record exists.Opening up a new tab','id'=> $merchant->id]);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failure','short_message'=>'Server Error','long_message'=>'The server is under heavy load. Please consult OpenSupport.']);
        }

    }	

public function check_for_product($id)
    {
        if (!Auth::check()) {
            return response()->json(['status'=>'failure','short_message'=>'Unauthorized Acces','long_message'=>'You need to login']);
        }
        try {
            $product=product::find($id);
            if (is_null($product)) {
                return response()->json(['status'=>'failure','short_message'=>'Missing Record','long_message'=>'DB Error: Record for product  '.$id.' is missing. Please consult OpenSupport.']);
            }
            if (!is_null($product)) {
                return response()->json(['status'=>'success','short_message'=>'200','long_message'=>'Station record exists.Opening up a new tab']);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failure','short_message'=>'Server Error','long_message'=>'The server is under heavy load. Please consult OpenSupport.']);
        }

    }


 public function check_for_recruiter($user_id)
    {
        if (!Auth::check()) {
            return response()->json(['status'=>'failure','short_message'=>'Unauthorized Acces','long_message'=>'You need to login']);
        }
        try {
            //$user=Buyer::find($user_id);
            //if (is_null($user)) {
		$user=Buyer::where('user_id', '=', $user_id)->get();
                        if (count($user) <=0) {
                return response()->json(['status'=>'failure','short_message'=>'Missing Record','long_message'=>'DB Error: Record for user  '.$buyer_id.' is missing. Please consult OpenSupport.']);
            }
            //if (!is_null($user)) {
		if (count($user)>0) {
                return response()->json(['status'=>'success','short_message'=>'200','long_message'=>'Recruiter record exists.Opening up a new tab']);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failure','short_message'=>'Server Error','long_message'=>'The server is under heavy load. Please consult OpenSupport.']);
        }

    }
/*public function check_for_merchant($user_id)
{
	if (!Auth::check()) {
		return response()->json(['status'=>'failure','short_message'=>'Unauthorized Access','long_message'=>'You need to login']);
	}
	try {
		$user=Buyer::find($user_id);
		if (is_null($user)) {
			return response()->json(['status'=>'failure','short_message'=>'Missing Record','long_message'=> 'DB Error: Record for merchant '.$user_id.' is missing. Please consult OpenSupport.']);}
		if (!is_null($user)) {
		return response()->json(['status'=>'success','short_message'=>'200','long_message'=>'User record exists. Opening up a new tab']);}
	} catch(\Exception $e) {
		return response()->json(['status'=>'failure','short_message'=>'Server Error','long_message'=>' The server is under heavy load. Please consult OpenSupport.']);
	}
}
*/

	public function getInfoStation($pstation_id)
    {
		 return view('user/infoStation');
	}


    public function getEditStation($pstation_id = null)
    {
        if(Auth::check()) {
            $indication = "station";
            $disabled = 'disabled';
            $route = route('edit-station');
            $stationID = null;
            $state_id = 0;
            $doc = array();
            // User,Bank,Address,Merchant,Brand,Website, and Director
            $userObj = new User();
            if ($pstation_id == null) {
                $userModel = $userObj->with(['station', 'station.bankaccount', 'station.address', 'station.brand', 'station.websites','station.property', 'station.directorsInEditView'])->where('id', '=', Auth::user()->id)->get()->first();

                $userModel = $this->reShapeStationModel($userModel);
				
                $stationID = Station::where('user_id', Auth::user()->id)->select('id')->first();

                $stationtotal = Station::where('user_id', Auth::user()->id)->first();

                if (isset($stationtotal->address_id)) {
                    $stationState = DB::select(DB::raw('Select state.id FROM state, city, address WHERE state.code = city.state_code AND city.id = address.city_id AND address.id = ' . $stationtotal->address_id));
					if(count($stationState) > 0){
						 $state_id = $stationState[0]->id;
					} 
                }
				$edit = true;
				$editing = 1;
				$selluser = User::find(Auth::user()->id);
            } else {
				$mystation = Station::where('id', $pstation_id)->first();
				if(!is_null($mystation)) {
					$userModel = $userObj->with(['station', 'station.bankaccount', 'station.address', 'station.brand', 'station.websites','station.property', 'station.directorsInEditView'])->where('id', '=', $mystation->user_id)->get()->first();

					$userModel = $this->reShapeStationModel($userModel);

					$stationID = Station::where('user_id', $mystation->user_id)->select('id')->first();

					$stationtotal = Station::where('user_id', $mystation->user_id)->first();

					if (isset($stationtotal->address_id)) {
						$stationState = DB::select(DB::raw('Select state.id FROM state, city, address WHERE state.code = city.state_code AND city.id = address.city_id AND address.id = ' . $stationtotal->address_id));

						if (!empty($stationState)) {
							$state_id = $stationState[0]->id;
						}
					}		
					$edit = false;	
					$editing = 1;
					$role= DB::table('role_users')->where('user_id',Auth::user()->id)->join('roles', 'roles.id', '=', 'role_users.role_id')->get();
					
					foreach ($role as $userrole) {
						if($userrole->name == "adminstrator"){
							$edit = true;
							$editing = 1;
						}
					}			
					$selluser = User::find($mystation->user_id);
				} else {
					\Session::flash(Config::get('messages.key.name'), $this->messageHandler->error('popupStationError', null, null,null, true, true, true));
					return redirect()->back();
				}

			}			

            //$station_docs = StationDocument::where('station_id',$stationID->id)->select('document_id')->get();

            try {

                $station_docs = DB::table('stationdocument')->where('station_id',$stationID->id)->select('document_id')->get();
            }catch(\Exception $e){
               // dd($e);
            }
			//dd($station_docs);
            if(isset($station_docs)){

                $count = count($station_docs);
                //dd($station_docs->toArray());

                try{

                    for ($i=0; $i < $count ; $i++) {
                        $doc[$i] = Document::where('id', $station_docs[$i]->document_id)->first();
                    }
                }catch(\Exception $ex){

                }
            }

            // By default it is type Collection
            $brand_table = Brand::orderBy('name')->get();
            $subcat_table1 = SubCatLevel1::orderBy('description')->get();
			$subcats = DB::select(DB::raw(
				"SELECT id, description, levelsub FROM (
					SELECT id, description, '1' as levelsub FROM subcat_level_1
					UNION
					SELECT id, description, '2' as levelsub FROM subcat_level_2
					UNION
					SELECT id, description, '3' as levelsub FROM subcat_level_3
				) as T ORDER BY description"
			));			
            $subcat_table2 = SubCatLevel2::orderBy('description')->get();
            $subcat_table3 = SubCatLevel3::orderBy('description')->get();

            $isbrand = true;

            $stationAddress = null;
            $bankDetails = null;
            $property = null;
            $address_id = Station::where('id', $stationID->id)->first()->address_id;
            if(isset($address_id) && !empty($address_id)) {
                $stationAddress = Address::find($address_id);
            }
			//dd($stationAddress);
            $bankaccount_id = Station::where('id', $stationID->id)->first()->bankaccount_id;
            if(isset($bankaccount_id) && !empty($bankaccount_id)) {
                $bankDetails = BankAccount::find($bankaccount_id);
                if (isset($bankDetails)) {
					/* bank_id maybe ZERO or bank record NOT exists! */
					if (isset($bankDetails->bank_id) and
						($bankDetails->bank_id != 0)) {

						/* Bank record NOT exists, dangling FK! */
						try {
							$bankDetails->name =
								Bank::where('id', $bankDetails->bank_id)->
								first()->name;
						} catch (\Exception $e) {
							$bankDetails->name = "";
						}
					}
                }
            }

            $property = Sproperty::where('station_id', $stationID->id)->first();

            if (isset($property) && !empty($property)) {
                $propertyoutlet = Outlet::find($property->outlet_id);
				if (isset($propertyoutlet) && !empty($propertyoutlet)) {
					$property->outlet = $propertyoutlet->name;
				} else {
					$property->outlet = "";
				}
            }

            if (isset($stationAddress)) {
				$aux = DB::select(DB::raw('Select state.id FROM state, city WHERE state.code = city.state_code AND city.id = '. $stationAddress['city_id']));
				if(!empty($aux)) {
					$statest_id=$aux[0]->id;
				}
			}
			$type=$stationID->stationtype_id;
			if($type != 2){
				$outlets = DB::table('sproperty')->leftJoin('address','sproperty.address_id','=','address.id')->leftJoin('city','address.city_id','=','city.id')->leftJoin('state','city.state_code','=','state.code')->leftJoin('area','area.id','=','address.area_id')->where('sproperty.station_id',$stationID->id)->select('sproperty.*','area.id as area_id','state.id as state_id','state.code as state_code','city.id as city_id','address.line1 as line1','address.line2 as line2','address.line3 as line3','address.line4 as line4','address.postcode as postcode')->get();
				$centers = null;				
			} else {
				$outlets = null;
				$centers = DB::table('districenter')->leftJoin('address','districenter.address_id','=','address.id')->leftJoin('city','address.city_id','=','city.id')->leftJoin('state','city.state_code','=','state.code')->leftJoin('area','area.id','=','address.area_id')->where('districenter.station_id',$stationID->id)->select('districenter.*','area.id as area_id','state.id as state_id','state.code as state_code','city.id as city_id','address.line1 as line1','address.line2 as line2','address.line3 as line3','address.line4 as line4','address.postcode as postcode')->get();;	
				$type = "logistic";
			}

                //dd($stationAddress);
            //if(!isset($userModel['websites'])){dd($userModel['websites']);}else{dd('false');}
			
			$mer_doc = DB::table('stationdocument')->where('station_id',$stationID->id )->join('document','stationdocument.document_id','=','document.id')->get();			
			$system_capabilities = DB::table('capability')->get();
			$lgrades = DB::table('lgrade')->get();
			$logcapabilities = null;
			$checkapi = "";
			$checkprofessional = "";
			$checkown = "";
			//dd($doc);
            return view('user/registerStation', compact(['indication', 'system_capabilities', 'lgrades', 'logcapabilities', 'checkapi', 'checkown', 'checkprofessional', 'route', 'outlets', 'centers','edit', 'editing', 'type','disabled', 'userModel', 'doc', 'mer_doc', 'brand_table', 'selluser','isbrand','subcats', 'state_id', 'stationAddress', 'bankDetails', 'property', 'statest_id']));
        }
        else {
            return redirect('/create_new_station');
        }

    }

    public function postEditStation(Request $request)
    {
        $user = new User();
        $user_model = $user->UpdateUserByid($request);//return new user record in db
        //find merchant
        $station_data = Station::where('user_id', $user_model->id)->first();


        $station = new Station();
        $station->UpdateInfo($station_data, $request);

		DB::table('stationdirector')->where('station_id',$station_data->id)->delete();
        $director = new Director();
        $director_model = $director->store($request, $station_data);

        $bankAccount=BankAccount::find($station_data->bankaccount_id);
        $bankAccount->bank_id= $request->get('bank');
        $bankAccount->account_name1=$request->get('account_name');
        $bankAccount->account_name2=$request->get('account_name');
        $bankAccount->account_number1=$request->get('account_number');
        $bankAccount->account_number2=$request->get('account_number');
        $bankAccount->iban=$request->get('ibn');
        $bankAccount->swift=$request->get('swift');
        $bankAccount->save();
		DB::table('stationbrand')->where('station_id',$station_data->id)->whereNotIn('brand_id', $request->get('brandIDs'))->delete();
        $brand = new StationBrand();
        $brand_models = $brand->store($request, $station_data->id);

        DB::table('stationwebsite')->where('station_id',$station_data->id)->delete();
        //Update websites data
        $websites = new Website();
        $websites->UpdateWebsites($request);

		DB::table('stationcontactemail')->
			where('station_id',$station_data->id)->delete();
		
		$enabled_email = $request->get('checkemail');
		$contactemail = $request->get('contactemail');
		$contactname = $request->get('contactname');
		$ii = 0;
	//	dump($contactemail );
	//	dd($enabled_email );
		foreach($contactemail as $contact){
			$enable = false;
			if(in_array($ii,$enabled_email)){
				$enable = true;
			}
			$email = DB::table('contactemail')->insertGetId(['email'=>$contact,'name'=>$contactname[$ii],'enable'=>$enable, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
			DB::table('stationcontactemail')->insertGetId(['contactemail_id'=>$email,'station_id'=>$station_data->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
			$ii++;
		}		
		
        DB::table('stationdocument')->where('station_id',$station_data->id)->whereNotIn('document_id', $request->get('attfilesIDs'))->delete();
		$documents = new Document();
		$documents_model = $documents->store($request, $station_data);	
		$addressold = Address::find($station_data->address_id);
		$citychanged = false;

		// Have to take account if $addressold is NULL
		if(empty($addressold) ||
		    $addressold->city_id != $request->get('city_id')){
			$citychanged = true;
		}	
        //Update Address
        $address = new Address();
        $address_model = $address->UpdateAddress($request, $station_data);
		$uniqueexist = DB::table('nsellerid')->where('user_id',$user_model->id)->first();
		if(is_null($uniqueexist)){
			$uniqueid = UtilityController::selleruniqueid($request->get('city_id'),"02");
			DB::table('nsellerid')->insert(['nseller_id'=>$uniqueid, 'user_id' => $user_model->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			$qr = (new UtilityController)->createQr($station_data->id,'merchant',IdController::nSeller($user_model->id));
		} else {
			if($citychanged){
				$uniqueid = UtilityController::selleruniqueid($request->get('city_id'),"02");
				//dd($uniqueid);
				DB::table('nsellerid')->where('id',$uniqueexist->id)->update(['nseller_id'=>$uniqueid, 'updated_at' => date('Y-m-d H:i:s')]); 
				DB::table('stationqr')->where('station_id',$station_data->id)->delete();
				UtilityController::createQr($station_data->id,'station',IdController::nSeller($user_model->id));
			}
		}		
		//dd("Hola");
        //Update Property
        $property = new Sproperty();
        $property_model = $property->UpdateProperty($request, $station_data->id);
		
        $indication = "station";
        Session::flash('EditStation', 'Information Updated Successfully');
        return redirect()->back();
    }

    public function reShapeStationModel($stationModel)
    {
        $stationObj = new Station();
        $userModel = $stationObj->getStationRelationsFullMeta();

         //dd($stationModel['station'][0]['property']);

        $station =  isset($stationModel['station'] ) ?  $stationModel['station'] : null;
        $bank =  count($stationModel['station']) > 0 ? (isset($stationModel['station'][0]['bank_id'] ) ?  [$stationModel['station'][0]['bank_id']] : null ):null ;//dd($merchantModel);
        $address =  count($stationModel['station']) > 0 ? (isset($stationModel['station'][0]['address_id'] ) ?  [$stationModel['station'][0]['address_id']] : null):null;
		if(count($stationModel['station']) > 0 && isset($stationModel['station'][0]['brand'])){
			$brand_raw= DB::table("stationbrand")->where('station_id',$stationModel['station'][0]['id'])->get();
			$brand_id_array=array();

			foreach ($brand_raw as $b) {
				# code...
				array_push($brand_id_array, $b->brand_id);
			}
			$brand=Brand::join('stationbrand','stationbrand.brand_id','=','brand.id')->select('brand.*','stationbrand.relationship','stationbrand.subcat_id','stationbrand.subcat_level')->whereIn('brand.id',$brand_id_array)->where('stationbrand.station_id',$stationModel['station'][0]['id'])->get();			
		} else {
			$brand =  count($stationModel['station']) > 0 ? (isset($stationModel['station'][0]['brand'] ) ?  $stationModel['station'][0]['brand'] : null):null;
			$brand_raw = array();
			if(!is_null(!$brand)){
				$brand_id_array=array();
				foreach ($brand_raw as $b) {
					# code...
					array_push($brand_id_array, $b->brand_id);
				}
				$brand=Brand::join('stationbrand','stationbrand.brand_id','=','brand.id')->select('brand.*','stationbrand.relationship','stationbrand.subcat_id','stationbrand.subcat_level')->whereIn('brand.id',$brand_id_array)->where('stationbrand.station_id',$stationModel['station'][0]['id'])->get();	
			}
		}

		$contactemail=DB::table('contactemail')->join('stationcontactemail','stationcontactemail.contactemail_id','=','contactemail.id')
		->select('contactemail.*')->where('stationcontactemail.station_id',$stationModel['station'][0]['id'])->orderBy('contactemail.id','asc')->get();
		
        $websites =  count($stationModel['station']) > 0 ? (isset($stationModel['station'][0]['websites'] ) ?  $stationModel['station'][0]['websites'] : null):null;
        $directors =  count($stationModel['station']) > 0 ? (isset($stationModel['station'][0]['directorsInEditView'] ) ?  $stationModel['station'][0]['directorsInEditView'] : null):null;
        $property =  count($stationModel['station']) > 0 ? (isset($stationModel['station'][0]['property'] ) ?  $stationModel['station'][0]['property'] : null):null;

        $stationArr = null;
        $bankArr = null;
        $addressArr = null;
        $brandArr = null;
        $contactArr = null;
        $websitesArr = null;
        $directorsArr = null;
        $propertyArr = null;

        if(!is_null( $station))
        foreach($station as $data)
        {
            $stationArr[]=[
                "id" => isset($data->id) ?  $data->id: null,
                "user_id" => isset($data->user_id) ?  $data->user_id: null,
                "company_name" =>
                    isset($data->company_name) ?$data->company_name  : null,
                "gst" => isset($data->gst) ? $data->gst : null,
                "business_reg_no" =>
                    isset($data->business_reg_no) ? $data->business_reg_no : null,
                "country_id" => isset($data->country_id) ? $data->country_id : null,
                "business_type" =>
                    isset($data->business_type) ? $data->business_type : null,
                "address_id" =>
                    isset($data->address_id) ?  $data->address_id: null,
                "contact_person" =>
                    isset($data->contact_person) ?  $data->contact_person: null,
                "office_no" => isset($data->office_no) ?  $data->office_no: null,
                "mobile_no" => isset($data->mobile_no) ?  $data->mobile_no: null,
                "oshop_name" => isset($data->oshop_name) ? $data->oshop_name : null,
                "oshop_logo_1" =>
                    isset($data->oshop_logo_1) ? $data->oshop_logo_1 : null,
                "oshop_logo_2" =>
                    isset($data->oshop_logo_2) ?  $data->oshop_logo_2: null,
                "oshop_logo_3" =>
                    isset($data->oshop_logo_3) ?  $data->oshop_logo_3: null,
                "oshop_logo_4" =>
                    isset($data->oshop_logo_4) ? $data->oshop_logo_4 : null,
                "oshop_logo_5" =>
                    isset($data->oshop_logo_5) ?  $data->oshop_logo_5: null,
                "oshop_adimage_1" =>
                    isset($data->oshop_adimage_1) ? $data->oshop_adimage_1: null,
                "oshop_adimage_2" =>
                    isset($data->oshop_adimage_2) ? $data->oshop_adimage_2: null,
                "oshop_adimage_3" =>
                    isset($data->oshop_adimage_3) ?  $data->oshop_adimage_3: null,
                "oshop_adimage_4" =>
                    isset($data->oshop_adimage_4) ? $data->oshop_adimage_4 : null,
                "oshop_adimage_5" =>
                    isset($data->oshop_adimage_5) ? $data->oshop_adimage_5 : null,
                "description" =>
                    isset($data->description) ? $data->description : null,
                "history" => isset($data->history) ?  $data->history: null,
                "license" => isset($data->license) ?  $data->license: null,
                "coverage" => isset($data->coverage) ? $data->coverage : null,
                "ownership" => isset($data->ownership) ? $data->ownership : null,
                "delivery_mode" => isset($data->delivery_mode) ? $data->delivery_mode : null,
                "note" => isset($data->note) ? $data->note : null,
                "category_id" =>
                    isset($data->category_id) ? $data->category_id : null,
                "planned_sales" =>
                    isset($data->planned_sales) ? $data->planned_sales : null,
                "bank_id" => isset($data->bank_id) ? $data->bank_id : null,
                "return_policy" =>
                    isset($data->return_policy) ? $data->return_policy : null,
                "remarks" => isset($data->remarks) ? $data->remarks : null,
                "deleted_at" => isset($data->deleted_at) ? $data->deleted_at : null,
                "created_at" => isset($data->created_at) ?  $data->created_at: null,
                "updated_at" => isset($data->updated_at) ?  $data->updated_at: null
            ];
        }

        if(!is_null($bank))
        foreach($bank  as $data)
        {
            $data = BankAccount::find($data);

            $bankArr[] = [
                "id" => isset($data->id) ?  $data->id: null,
                "name" => isset($data->name) ?  $data->name: null,
                "code" => isset($data->code) ?  $data->code: null,
                "account_name1" => isset($data->account_name1) ?    $data->account_name1: null,
                "account_number1" => isset($data->account_number1) ?    $data->account_number1: null,
                "account_name2" => isset($data->account_name2) ?    $data->account_name2: null,
                "account_number2" => isset($data->account_number2) ?    $data->account_number2: null,
                "iban" => isset($data->iban) ?  $data->iban: null,
                "swift" => isset($data->swift) ?    $data->swift: null,
                "url" => isset($data->url) ?    $data->url: null,
                "description" => isset($data->description) ?    $data->description: null,
                "deleted_at" => isset($data->deleted_at) ?    $data->deleted: null,
                "created_at" => isset($data->created_at) ?  $data->created_at: null,
                "updated_at" => isset($data->updated_at) ?  $data->updated_at: null
            ];
        }

        if(!is_null($address))
        foreach($address  as $data)
        {
			
            $data = Address::find($data);
			$state_id = 0;
			$state = DB::table('state')->select('state.id as id', 'state.code as code')->join('city','city.state_code','=','state.code')->where('city.id',$data->city_id)->first();
			if(!is_null($state)){
				$state_id = $state->id;
				$state_code = $state->code;
			}
            $addressArr[] = [
                "id" => isset($data->id) ? $data->id : null,
				"state_id" => isset($state_id) ?$state_id: null,
				"state_code" => isset($state_code) ?$state_code: null,
				"city_id" => isset($data->city_id) ?$data->city_id: null,
				"area_id" => isset($data->area_id) ?$data->area_id: null,
                "postcode" => isset($data->postcode) ? $data->postcode: null,
                "line1" => isset($data->line1) ? $data->line1: null,
                "line2" => isset($data->line2) ? $data->line2: null,
                "line3" =>isset($data->line3) ? $data->line3: null,
                "line4" => isset($data->line4) ? $data->line4: null,
                "type" => isset($data->type) ?  $data->type: null,
				"latitude" => isset($data->latitude) ?$data->latitude: null,
				"longitude" => isset($data->longitude) ?$data->longitude: null,				
                "deleted_at" => isset($data->deleted_at) ?    $data->deleted: null,
                "created_at" => isset($data->created_at) ? $data->created_at: null,
                "updated_at" => isset($data->updated_at) ?  $data->updated_at: null
            ];
        }

     if(!is_null($brand))
    foreach($brand  as $data)
    {	
		$doc = DB::table('branddocument')
            ->join('document','document.id','=','branddocument.document_id')
            ->where('branddocument.brand_id',$data->id)
            ->where('branddocument.merchant_id',$stationModel['station'][0]['id'])
            ->first();
        $brandArr[] = [
            "id" => isset($data->id) ?$data->id: null,
            "name" => isset($data->name) ?$data->name: null,
            "subcat_id" => isset($data->subcat_id) ?$data->subcat_id: null,
            "subcat_level" => isset($data->subcat_level) ?$data->subcat_level: null,
            "relationship" => isset($data->relationship) ?$data->relationship: null,
            "description" => isset($data->description) ?$data->description: null,
            "logo" => isset($data->logo) ?$data->logo: null,
            "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
            "created_at" => isset($data->created_at) ?$data->created_at: null,
            "updated_at" => isset($data->updated_at) ?$data->updated_at: null,
			"doc" => isset($doc->path)?$doc->path:null,
            "document_id" => isset($doc->document_id)?$doc->document_id:null
        ];
    }

    if(!is_null($contactemail))
    foreach($contactemail  as $data)
    {	
        $contactArr[] = [
            "id" => isset($data->id) ?$data->id: null,
            "email" => isset($data->email) ?$data->email: null,
            "enable" => isset($data->enable) ?$data->enable: null,
            "name" => isset($data->name) ?$data->name: null,
            "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
            "created_at" => isset($data->created_at) ?$data->created_at: null,
            "updated_at" => isset($data->updated_at) ?$data->updated_at: null,
        ];
    }		
	
    if(!is_null($websites))
    foreach($websites  as $data)
    {
		if(isset($data->type)){
			if(!is_null($data->type)){
				$websitesArr[] = [
					"id" => isset($data->id) ?$data->id: null,
					"name" => isset($data->name) ?$data->name: null,
					"type" => isset($data->type) ?$data->type: null,
					"description" => isset($data->description) ?$data->description: null,
					"url" => isset($data->url) ?$data->url: null,
					"deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
					"created_at" => isset($data->created_at) ?$data->created_at: null,
					"updated_at" => isset($data->updated_at) ?$data->updated_at: null
				];				
			}
		}
    }

        if(!is_null($directors))
        foreach($directors  as $data)
        {
            $doc = DB::table('directordocument')
                ->join('document','document.id','=','directordocument.document_id')
                ->where('directordocument.director_id',$data->id)
                ->first();
            $directorsArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "merchant_id" => isset($data->merchant_id) ?$data->merchant_id: null,
                "country_id" => isset($data->country_id) ?$data->country_id: null,
                "name" => isset($data->name) ?$data->name: null,
                "nric" => isset($data->nric) ?$data->nric: null,
                "photo_1" => isset($data->photo_1) ?$data->photo_1: null,
                "photo_2" => isset($data->photo_2) ?$data->photo_2: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null,
                "doc" => isset($doc->path)?$doc->path:null,
				"document_id" => isset($doc->document_id)?$doc->document_id:null
            ];
        }


            if(!is_null($property))
            {
                $propertyArr[] = [
                    "id" => isset($property->id) ? $property->id : null,
                    "biz_name" => isset($property->biz_name) ? $property->biz_name: null,
                    "biz_owner_contact" => isset($property->biz_owner_contact) ? $property->biz_owner_contact: null,
                    "biz_owner_first_name" => isset($property->biz_owner_first_name) ? $property->biz_owner_first_name: null,
                    "biz_owner_last_name" => isset($property->biz_owner_last_name) ? $property->biz_owner_last_name: null,
                    "outlet_id" =>isset($property->outlet_id) ? $property->outlet_id: null,
                    "prop_owner_contact" => isset($property->prop_owner_contact) ? $property->prop_owner_contact: null,
                    "prop_owner_first_name" => isset($property->prop_owner_first_name) ?  $property->prop_owner_first_name: null,
                    "prop_owner_last_name" => isset($property->prop_owner_last_name) ?    $property->prop_owner_last_name: null,
                    "shop_size" => isset($property->shop_size) ? $property->shop_size: null,
                    "delivery" => isset($property->delivery) ? $property->delivery: null,
                    "station_id" => isset($property->station_id) ?  $property->station_id: null
                ];
            }


        $userModel = [
          "user" =>[
            "id" => isset($stationModel['id']) ? $stationModel['id'] : null ,
            "occupation_id" => isset($stationModel['occupation_id']) ? $stationModel['occupation_id'] : null ,
            "first_name" => isset($stationModel['first_name']) ? $stationModel['first_name'] : null ,
            "last_name" =>  isset($stationModel['last_name']) ? $stationModel['last_name'] : null,
            "birthdate" => isset($stationModel['birthdate']) ? $stationModel['birthdate'] : null ,
            "mobile_no" => isset($stationModel['mobile_no']) ? $stationModel['mobile_no'] : null ,
            "email" =>  isset($stationModel['email']) ? $stationModel['email'] : null,
            "password" => isset($stationModel['password']) ? $stationModel['password'] : null ,
            "gender" =>  isset($stationModel['gender']) ?  $stationModel['gender']: null,
            "annual_income" => isset($stationModel['annual_income']) ?$stationModel['annual_income']  : null,
            "salutation" =>  isset($stationModel['salutation']) ? $stationModel['salutation'] : null,
            "type" =>  isset($stationModel['type']) ? $stationModel['type'] : null,
            "deleted_at" =>  isset($stationModel['deleted_at']) ?  $stationModel['deleted_at']: null,
            "created_at" => isset($stationModel['created_at']) ? $stationModel['created_at'] : null,
            "updated_at" => isset($stationModel['updated_at']) ?  $stationModel['updated_at']: null
            ],
          "station" => $stationArr,
          "bank" => $bankArr,
          "address" =>$addressArr,
          "brand" =>$brandArr,
          "contactemail" =>$contactArr,
          "websites" =>$websitesArr ,
          "directorsInEditView" => $directorsArr,
            "property" => $propertyArr
        ];

        return $userModel;
    }

    public function changeadmin(Request $request){
		$password = $request->get('password');
		$userid = $request->get('userid');
		$user_id= Auth::id();
		$check_pass = DB::table("users")->where('id', $user_id )->first()->email;
		$arr['response'] = 0;
		if (Auth::attempt(['email' => $check_pass, 'password' => $password], true)) {
			$admin = DB::table("role_users")->join("roles","roles.id","=","role_users.role_id")->where("role_users.user_id",$userid)->where("roles.name","adminstrator")->get();
			if(count($admin)>0){
				DB::table("role_users")->where('user_id', $userid )->where('role_id',1)->delete();
			} else {
				DB::table('role_users')->insert(
					['user_id' => $userid, 'role_id' => 1]
				);
				DB::table("role_users")->where('user_id', $userid )->where('role_id',2)->delete();
			}
			$arr['response'] = 1;
		}
		return json_encode($arr);
	}	
	
	public function alsomerchant(Request $request){
		$userid = $request->get('userid');
		$station = DB::table('station')->where('user_id',$userid)->first();

		$user_as_merchant = new Merchant();
        $user_as_merchant_model = $user_as_merchant->store_fromstation($station, $userid);
		
		$mdocuments = DB::table('stationdocument')->where('station_id',$station->id)->get();
		foreach($mdocuments as $mdocument){
			DB::table('merchantdocument')->insert(['merchant_id'=>$user_as_merchant_model->id,'document_id'=>$mdocument->document_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}

		$mbrands = DB::table('stationbrand')->where('station_id',$station->id)->get();
		foreach($mbrands as $mbrand){
			DB::table('merchantbrand')->insert(['merchant_id'=>$user_as_merchant_model->id,'brand_id'=>$mbrand->brand_id,'subcat_id'=>$mbrand->subcat_id,'subcat_level'=>$mbrand->subcat_level,'relationship'=>$mbrand->relationship,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}
		//http://laravel.com/docs/5.1/eloquent-relationships#inserting-many-to-many-relationships
		//for storing web sites in "stationwebsite" table
		//first create station and get id
		//then create websites and get website model array like director
		//then attach station with each website id
		
		$mwebsites = DB::table('stationwebsite')->where('station_id',$station->id)->get();
		foreach($mwebsites as $mwebsite){
			DB::table('merchantwebsite')->insert(['merchant_id'=>$user_as_merchant_model->id,'website_id'=>$mwebsite->website_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}		

		$mdirectors = DB::table('stationdirector')->where('station_id',$station->id)->get();
		foreach($mdirectors as $mdirector){
			DB::table('merchantdirector')->insert(['merchant_id'=>$user_as_merchant_model->id,'director_id'=>$mdirector->director_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}			
		
		$role = new RoleUser;
		$role->user_id = $userid;
		$role->role_id = 3;
		$role->save();	
		return json_encode("OK");
	}	
	
	public function alsostationlog($id){
		$userid = $id;
		$merchant = DB::table('merchant')->where('user_id',$userid)->first();

		$user_as_station = new Station();
        $user_as_station_model = $user_as_station->store_frommerchant($merchant, $userid);
		DB::table('station')->where('id',$user_as_station_model->id)->update(['stationtype_id'=>1]);
		$mdocuments = DB::table('merchantdocument')->where('merchant_id',$merchant->id)->get();
		foreach($mdocuments as $mdocument){
			DB::table('stationdocument')->insert(['station_id'=>$user_as_station_model->id,'document_id'=>$mdocument->document_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}

		$mbrands = DB::table('merchantbrand')->where('merchant_id',$merchant->id)->get();
		foreach($mbrands as $mbrand){
			DB::table('stationbrand')->insert(['station_id'=>$user_as_station_model->id,'brand_id'=>$mbrand->brand_id,'subcat_id'=>$mbrand->subcat_id,'subcat_level'=>$mbrand->subcat_level,'relationship'=>$mbrand->relationship,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}
		//http://laravel.com/docs/5.1/eloquent-relationships#inserting-many-to-many-relationships
		//for storing web sites in "stationwebsite" table
		//first create station and get id
		//then create websites and get website model array like director
		//then attach station with each website id
		$mwebsites = DB::table('merchantwebsite')->where('merchant_id',$merchant->id)->get();
		foreach($mwebsites as $mwebsite){
			DB::table('stationwebsite')->insert(['station_id'=>$user_as_station_model->id,'website_id'=>$mwebsite->website_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}		

		$mdirectors = DB::table('merchantdirector')->where('merchant_id',$merchant->id)->get();
		foreach($mdirectors as $mdirector){
			DB::table('stationdirector')->insert(['station_id'=>$user_as_station_model->id,'director_id'=>$mdirector->director_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}			

		$role = new RoleUser;
		$role->user_id = $userid;
		$role->role_id = 11;
		$role->save();	
		return json_encode("OK");		
	}
	
	public function alsostation(Request $request){
		$userid = $request->get('userid');
		$merchant = DB::table('merchant')->where('user_id',$userid)->first();

		$user_as_station = new Station();
        $user_as_station_model = $user_as_station->store_frommerchant($merchant, $userid);
		DB::table('station')->where('id',$user_as_station_model->id)->update(['stationtype_id'=>1]);
		$mdocuments = DB::table('merchantdocument')->where('merchant_id',$merchant->id)->get();
		foreach($mdocuments as $mdocument){
			DB::table('stationdocument')->insert(['station_id'=>$user_as_station_model->id,'document_id'=>$mdocument->document_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}

		$mbrands = DB::table('merchantbrand')->where('merchant_id',$merchant->id)->get();
		foreach($mbrands as $mbrand){
			DB::table('stationbrand')->insert(['station_id'=>$user_as_station_model->id,'brand_id'=>$mbrand->brand_id,'subcat_id'=>$mbrand->subcat_id,'subcat_level'=>$mbrand->subcat_level,'relationship'=>$mbrand->relationship,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}
		//http://laravel.com/docs/5.1/eloquent-relationships#inserting-many-to-many-relationships
		//for storing web sites in "stationwebsite" table
		//first create station and get id
		//then create websites and get website model array like director
		//then attach station with each website id
		$mwebsites = DB::table('merchantwebsite')->where('merchant_id',$merchant->id)->get();
		foreach($mwebsites as $mwebsite){
			DB::table('stationwebsite')->insert(['station_id'=>$user_as_station_model->id,'website_id'=>$mwebsite->website_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}		

		$mdirectors = DB::table('merchantdirector')->where('merchant_id',$merchant->id)->get();
		foreach($mdirectors as $mdirector){
			DB::table('stationdirector')->insert(['station_id'=>$user_as_station_model->id,'director_id'=>$mdirector->director_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}			
		
		$role = new RoleUser;
		$role->user_id = $userid;
		$role->role_id = 11;
		$role->save();	
		return json_encode("OK");
	}
	
	public static function alsologistic($userid){
		//dd($userid);
		$merchant = DB::table('merchant')->where('user_id',$userid)->first();
		$user_as_station_model = DB::table('station')->where('user_id',$userid)->first();
		if(is_null($user_as_station_model)){
			$user_as_station = new Station();
			$user_as_station_model = $user_as_station->store_frommerchant($merchant, $userid);
			
			$mdocuments = DB::table('merchantdocument')->where('merchant_id',$merchant->id)->get();
			foreach($mdocuments as $mdocument){
				DB::table('stationdocument')->insert(['station_id'=>$user_as_station_model->id,'document_id'=>$mdocument->document_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			}

			$mbrands = DB::table('merchantbrand')->where('merchant_id',$merchant->id)->get();
			foreach($mbrands as $mbrand){
				DB::table('stationbrand')->insert(['station_id'=>$user_as_station_model->id,'brand_id'=>$mbrand->brand_id,'subcat_id'=>$mbrand->subcat_id,'subcat_level'=>$mbrand->subcat_level,'relationship'=>$mbrand->relationship,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			}
			//http://laravel.com/docs/5.1/eloquent-relationships#inserting-many-to-many-relationships
			//for storing web sites in "stationwebsite" table
			//first create station and get id
			//then create websites and get website model array like director
			//then attach station with each website id
			$mwebsites = DB::table('merchantwebsite')->where('merchant_id',$merchant->id)->get();
			foreach($mwebsites as $mwebsite){
				DB::table('stationwebsite')->insert(['station_id'=>$user_as_station_model->id,'website_id'=>$mwebsite->website_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			}		

			$mdirectors = DB::table('merchantdirector')->where('merchant_id',$merchant->id)->get();
			foreach($mdirectors as $mdirector){
				DB::table('stationdirector')->insert(['station_id'=>$user_as_station_model->id,'director_id'=>$mdirector->director_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			}			
			
			$role = new RoleUser;
			$role->user_id = $userid;
			$role->role_id = 11;
			$role->save();	
		}
		
		$logistic_exists = DB::table('logistic')->where('logistic.station_id',$user_as_station_model->id)->first();
		if(is_null($logistic_exists)){
			DB::table('station')->where('id',$user_as_station_model->id)->update(['stationtype_id'=>2,'status' => 'active']);
			$role2 = new RoleUser;
			$role2->user_id = $userid;
			$role2->role_id = 13;
			$role2->save();
			
			$company_id = 0;
			$company = DB::table('company')->where('owner_user_id',$userid)->first();
			if(!is_null($company)){
				$company_id = $company->id;
			}
			
			$cityid = DB::table('merchant')->join('address','merchant.address_id','=','address.id')->where('merchant.user_id',$userid)->pluck('address.city_id');
			$loid = DB::table('logistic')->insertGetId(['station_id'=>$user_as_station_model->id, 'api' => 1,'company_id'=> $company_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			$uniqueid = (new UtilityController)->sprovideruniqueid($cityid, "03");
			if($uniqueid != ""){
				$nlid = DB::table('nsproviderid')->insertGetId(['nsprovider_id'=>$uniqueid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				
				DB::table('nsproviderlogisticid')->insertGetId(['nsproviderid_id'=>$nlid, 'logistic_id'=>$loid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			}
		} 
		return json_encode("OK");		
	}
	
    public function changepassword(Request $request){

		

            $userid=Auth::user()->id;
            
            $user=User::find($userid);
            $this->validate($request,array(
                'old_password' => 'required',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required'
            ));
                
            if (Hash::check(Input::get('old_password'), $user->password)==false)
                {
                    return Response(['old_password'=>array('Old Password is not correct')],422);
                
                }
             
            
            $user->password=bcrypt(Input::get('password'));
            
            
            if ($user->save()) {
                return Response(['done'=>array('Password Updated')],200);
            }
	}	
	
    public function sendpassword(Request $request){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randstring = '';
		for ($i = 0; $i < 10; $i++) {
			$randstring = $characters[rand(0, strlen($characters))];
		}	
		
		$password = bcrypt($randstring);
		$userid = $request->get('userid');
		//$user_id= Auth::id();
		$update_pass = DB::table("users")->where('id', $userid )->update(['password' => $password]);
		$user = DB::table("users")->where('id', $userid )->first();
		try{
			$mgClient = new Mailgun('key-80495c8905443d885803333b49b45718');
			$domain = "opensupermall.com";

			# Make the call to the client.
			$result = $mgClient->sendMessage($domain, array(
				'from'    => 'Opensupermall <info@opensupermall.com>',
				'to'      => $user->first_name . ' ' . $user->first_name .  ' <'. $user->email .'>',
				'subject' => 'Your new OpenSupermall password',
				'html'    => '<h4>Please, log in with your new password</h4>
							<p>Password: ' . $randstring
			));
		} catch (\Exception $e) {
			
		}	
		$arr['response'] = 0;
		return json_encode($arr);
	}		
}
