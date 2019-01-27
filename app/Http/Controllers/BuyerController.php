<?php

namespace App\Http\Controllers;
use App\Classes\SecurityIDGenerator;
use App\Models\Autolink;
use App\Models\Address;
use App\Models\Bank;
use App\Models\BuyerCreditCard;
use App\Models\BuyerAddress;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\CreComment;
use App\Models\Userlanguage;
use App\Models\Area;
use App\Models\Country;
use App\Models\Ocredit;
use App\Models\PaymentMethod;
use App\Models\Payment;
use App\Models\Buyer;
use App\Models\Currency;
use App\Models\Credit;
use App\Models\RoleUser;
use App\Models\UserCategory;
use App\Models\BuyerCategory;
use App\Models\BankAccount;
// use App\Models\Cre;
use App\lib\Date;
use App\Models\Merchant;
use App\Models\Globals;
use App\Models\MerchantProduct;
use App\Models\OpenWish;
use App\Models\OpenWishPledge;
use App\Models\OrderProduct;
use App\Models\Cre;
use App\Models\Product;
use App\Models\SMMin;
use App\Models\SMMout;
use App\Models\Website;
use App\Models\Document;
use App\Models\CreDocument;
use App\Models\MerchantDocument;
use App\Models\Occupation;
use App\Models\Language;
use App\Models\POrder;
use App\Models\SalesStaff;
use Carbon\Carbon;
use App\Models\Receipt;
use App\Models\DeliveryOrder;
use App\Models\BuyerBankAccount;
use Exception;
use App\OWish;
use Collection;
use GuzzleHttp;
use App;
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
use Redirect;
use Hash;
use Cart;
use Image;
//use string;
use View;
use File;
use Log;
use App\Http\Controllers\MerchantDashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\IdController as ID;
use App\lib\MessageHandler;
use Mailgun\Mailgun;
use Yajra\Datatables\Facades\Datatables;

class BuyerController extends Controller
{
    public $messageHandler;
	
	public function showPage()
    {
        $canregister = false;
        if(!Auth::check()){
            $canregister = true;
        } else {
            $canregister = true;
            $role= DB::table('role_users')->where('user_id',Auth::user()->id)->join('roles', 'roles.id', '=', 'role_users.role_id')->get();
            foreach ($role as $userrole) {
                if($userrole->name == "buyer"){
                    $canregister = false;
                }
            }

        }
        if($canregister) {
            $address = new Address();
            $languages = DB::table('language')->get();
            $occupations = DB::table('occupation')->get();
            $interests = DB::table('category')->get();
            $banks = DB::table('bank')->get();
            $userModel = $address->getMeta();
            return response()->view('buyerregistration', array('languages' => $languages, 'occupations' => $occupations, 'interests' => $interests, 'banks' => $banks, 'userModel' => $userModel));
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function showPagenewRegmob()
    {
        $canregister = false;
        if(!Auth::check()){
            $canregister = true;
        } else {
            $canregister = true;
            $role= DB::table('role_users')->where('user_id',Auth::user()->id)->join('roles', 'roles.id', '=', 'role_users.role_id')->get();
            foreach ($role as $userrole) {
                if($userrole->name == "buyer"){
                    $canregister = false;
                }
            }

        }
        if($canregister) {
            $address = new Address();
            $languages = DB::table('language')->get();
            $occupations = DB::table('occupation')->get();
            $interests = DB::table('category')->get();
            $banks = DB::table('bank')->get();
            $userModel = $address->getMeta();
            return response()->view('mobbuyerreg', array('languages' => $languages, 'occupations' => $occupations, 'interests' => $interests, 'banks' => $banks, 'userModel' => $userModel));
        }
        else
        {
            return redirect()->route('home');
        }
    }
	
    public function showPagenewReg()
    {
        $canregister = false;
        if(!Auth::check()){
            $canregister = true;
        } else {
            $canregister = true;
            $role= DB::table('role_users')->where('user_id',Auth::user()->id)->join('roles', 'roles.id', '=', 'role_users.role_id')->get();
            foreach ($role as $userrole) {
                if($userrole->name == "buyer"){
                    $canregister = false;
                }
            }

        }
        if($canregister) {
            $address = new Address();
            $languages = DB::table('language')->get();
            $occupations = DB::table('occupation')->get();
            $interests = DB::table('category')->get();
            $banks = DB::table('bank')->get();
            $userModel = $address->getMeta();
            $viewfile="buyerreg";
            /*Mobile View*/ 
            $is_mobile=UtilityController::is_mobile();

            if ($is_mobile) {
            	$viewfile="mobile.buyerreg";
            }
            // $viewfile="mobile.buyerreg";
            return response()->view($viewfile, array('languages' => $languages, 'occupations' => $occupations, 'interests' => $interests, 'banks' => $banks, 'userModel' => $userModel));
        }
        else
        {
            return redirect()->route('home');
        }
    }

	public function getStaffModemobile(Request $request, $mode)
    {
		$merchant_user_id = $request->userid;
		$recruiter_user_id = $request->recruiter;
		$locations = DB::table('fairlocation')->where('user_id',$merchant_user_id)->orderBy(DB::raw("
		  CASE fairlocation.company_name
			WHEN 'Warehouse' THEN 1
			ELSE 10
		  END"))->get();
		switch ($mode) {
			case "fairmode":
				
				return view('buyer.mobile.functions.fairmode')
				->with('merchant_user_id',$merchant_user_id)
				->with('locations',$locations)
				->with('recruiter_user_id',$recruiter_user_id);
				break;
			case "salesmemo":
						if(Auth::check()){
							if(isset($custom_id))
								$id = $custom_id;
							else
								$id =  \Auth::user()->id;
						} else {
							return Redirect::back();
						}

						$stmt = "rec";
						$query = DB::table('salesmemo')->join('salesmemoproduct as op','op.salesmemo_id','=','salesmemo.id')
						->where('salesmemo.creator_user_id','=',$recruiter_user_id)
							->select('salesmemo.creator_user_id','salesmemo.created_at')
							->orderBy('salesmemo.created_at','desc')
							->get();                
						$actual_year =  DB::table('salesmemo')->join('salesmemoproduct as op','op.salesmemo_id','=','salesmemo.id')
						->where('salesmemo.creator_user_id','=',$recruiter_user_id)
							->select('salesmemo.creator_user_id','salesmemo.created_at')
							->orderBy('salesmemo.created_at','desc')
						   
							->first();
						$years = Array();$months = Array();$y = Array();$index = 0;
						foreach($query as $que){
							$date = Carbon::parse($que->created_at);
							//dd($date);
							$years[$date->year][$index] = $date->month;
							$index++;
						}
						$today = Carbon::today();	
						$mer = "SalesMan ID";
						$id = IdController::nB($recruiter_user_id);
						$userr = DB::table('users')->where('id',$recruiter_user_id)->first();
						$name = $userr->first_name . " " . $userr->last_name;
						$ireturn = 	$userr;
						$arr = array('ireturn'=>$ireturn, 'myreturn' => $query, 'today' => $today, 'mer' => $mer, 'id' => $id, 'name' => $name, 'years'=>$years, 'actual_year'=>$actual_year);
						$ireturn = $arr['ireturn'];
						$today = $arr['today'];
						$myreturn = $arr['myreturn'];
						$mer = $arr['mer'];
						$id = $arr['id'];
						$years = $arr['years'];
						$actual_year = $arr['actual_year'];
						$current_year = 0;
						if(isset($actual_year)){
							$actual_year = Carbon::parse($actual_year->created_at);
							if($actual_year->year != $today->year){
								$current_year = 0;
							}else{
								$current_year = 1;
							}
						}
			
				return view('buyer.mobile.functions.salesmemo',compact('ireturn','today','myreturn','current_year'))
				->with('merchant_user_id',$merchant_user_id)
				->with('locations',$locations)
				->with('recruiter_user_id',$recruiter_user_id)
				->with('mer',$mer)->with('id',$id)->with('years',$years)->with('title','SalesMemo');
				break;
			case "invoiceproforma":
				return "<h2>Invoice Pro-Forma</h2>";
				break;
			case "stocktable":
				return view('buyer.mobile.functions.stocktake')
				->with('merchant_user_id',$merchant_user_id)
				->with('locations',$locations)
				->with('recruiter_user_id',$recruiter_user_id);
				break;
			default:
				return "";
				break;
		}

	}	
	
	public function getStaffMode(Request $request, $mode)
    { 
    	$merchant_user_id = $request->userid;
		$recruiter_user_id = $request->recruiter;
		$locations = DB::table('fairlocation')->where('user_id',$merchant_user_id)->orderBy(DB::raw("
		  CASE fairlocation.company_name
			WHEN 'Warehouse' THEN 1
			ELSE 10
		  END"))->get();
		switch ($mode) {
			case "fairmode":
				
				return view('buyer.newbuyerinformation.functions.fairmode')
				->with('merchant_user_id',$merchant_user_id)
				->with('locations',$locations)
				->with('recruiter_user_id',$recruiter_user_id);
				break;

			case "salesmemo":
						if(Auth::check()){
							if(isset($custom_id))
								$id = $custom_id;
							else
								$id =  \Auth::user()->id;
						} else {
							return Redirect::back();
						}

						$stmt = "rec";
						$query = DB::table('salesmemo')->join('salesmemoproduct as op','op.salesmemo_id','=','salesmemo.id')
						->where('salesmemo.creator_user_id','=',$recruiter_user_id)
							->select('salesmemo.creator_user_id','salesmemo.created_at')
							->orderBy('salesmemo.created_at','desc')
							->get();                
						$actual_year =  DB::table('salesmemo')->join('salesmemoproduct as op','op.salesmemo_id','=','salesmemo.id')
						->where('salesmemo.creator_user_id','=',$recruiter_user_id)
							->select('salesmemo.creator_user_id','salesmemo.created_at')
							->orderBy('salesmemo.created_at','desc')
						   
							->first();
						$years = Array();$months = Array();$y = Array();$index = 0;
						foreach($query as $que){
							$date = Carbon::parse($que->created_at);
							//dd($date);
							$years[$date->year][$index] = $date->month;
							$index++;
						}
						$today = Carbon::today();	
						$mer = "SalesMan ID";
						$id = IdController::nB($recruiter_user_id);
						$userr = DB::table('users')->where('id',$recruiter_user_id)->first();
						$name = $userr->first_name . " " . $userr->last_name;
						$ireturn = 	$userr;
						$arr = array('ireturn'=>$ireturn, 'myreturn' => $query, 'today' => $today, 'mer' => $mer, 'id' => $id, 'name' => $name, 'years'=>$years, 'actual_year'=>$actual_year);
						$ireturn = $arr['ireturn'];
						$today = $arr['today'];
						$myreturn = $arr['myreturn'];
						$mer = $arr['mer'];
						$id = $arr['id'];
						$years = $arr['years'];
						$actual_year = $arr['actual_year'];
						$current_year = 0;
						if(isset($actual_year)){
							$actual_year = Carbon::parse($actual_year->created_at);
							if($actual_year->year != $today->year){
								$current_year = 0;
							}else{
								$current_year = 1;
							}
						}
			
				return view('buyer.newbuyerinformation.functions.salesmemo',compact('ireturn','today','myreturn','current_year'))
				->with('merchant_user_id',$merchant_user_id)
				->with('locations',$locations)
				->with('recruiter_user_id',$recruiter_user_id)
				->with('mer',$mer)->with('id',$id)->with('years',$years)->with('title','SalesMemo');
				break;
			case "invoiceproforma":
				return "<h2>Invoice Pro-Forma</h2>";
				break;
			case "stocktable":
				return view('buyer.newbuyerinformation.functions.stocktake')
				->with('merchant_user_id',$merchant_user_id)
				->with('locations',$locations)
				->with('recruiter_user_id',$recruiter_user_id);
				break;
	        case "opossum":
	            $user_id     = Auth::user()->id;

	            $merchant_user_id=null;
	            $location_id=null;
	            try {
	            	$merchant_user_id=$_GET['userid'];
	            } catch (\Exception $e) {
	            	
	            }
	            try {
	            	$location_id=$_GET['location_id'];
	            } catch (\Exception $e) {
	            	
	            }
	             $terminals=\App\Models\OposTerminalUsers::select("opos_terminal.name as name",
	                     "opos_terminal.id as terminal_id","logged_user_id")->
	                     leftJoin("users","users.id","=","opos_terminalusers.user_id")
	                     ->join("opos_terminal","opos_terminal.id","=","opos_terminalusers.terminal_id")
	                     ->join("opos_locationterminal","opos_locationterminal.terminal_id","=","opos_terminal.id")
	                     ->join("fairlocation", "fairlocation.id","=","opos_locationterminal.location_id")
	                     ->where("users.id","=",$user_id)
	                     ->where('opos_locationterminal.location_id',$location_id)
	                     ->where("fairlocation.user_id",$merchant_user_id)
	                     ->groupBy("opos_terminal.id")
	                     ->get();
	             
	            return view('buyer.newbuyerinformation.functions.opossum')
				->with('terminals',$terminals);
                             
            break;
            case "warehosue":

        		// if (!Auth::check()) {
		        //     return "Please login";
		        // }
				$id = Auth::user()->id;

				if ($id != null) {
		            $user_id= $id;
		        } else {
		            $user_id= Auth::user()->id; 
		        }

		        $selluser = User::find($user_id);
		       
	        if(isset($user_id)){

	        $warehouses =DB::table("warehouse")
            ->join("fairlocation","fairlocation.id","=","warehouse.location_id")
           /* ->join("branch","branch.location_id","=","fairlocation.id")*/
            ->whereNull("fairlocation.deleted_at")
            ->whereNull("warehouse.deleted_at")
            ->where("fairlocation.user_id",$user_id)
            ->select("fairlocation.*","warehouse.id as warehouse_id","fairlocation.location as branch_name")
            ->groupBy("warehouse_id")->toSql();
            // ->get();
 		/*dd($warehouses);*/

    		return view('buyer.newbuyerinformation.functions.warehosue')->with('selluser', $selluser)->with('warehouses', $warehouses);
			}

            break;
			default:
				return "";
				break;
		}

	}

    public function storeBuyerDetails(Request $request)
    {
        // dd($request->all());
        // return $request->method;
        if (!$request->isMethod('post')) {
            return "Only POST requests are allowed";
        }
        if (!isset($request)) {
            return "Empty forms are not accepted";
        }
        $this->validate($request, [
            'username' => 'required|unique:users|max:100|min:7',
            'full_name' => 'required|min:3',
            //'dob' => 'required',
            'password' => 'required|max:100|min:7|confirmed',
            'password_confirmation' => 'required',
            //'language' => 'required',
            //'mobile' => 'required|max:12|min:10',
            //'gender' => 'required',
            //'photo' => 'image',
            //'default1' => 'required',
            //'default2' => 'required',
            //'city_name' => 'required'
        ]);
		
		$rules =  array('captcha' => ['required', 'captcha']); 
		$validator = Validator::make( 
			[ 'captcha' => Input::get('captcha') ], 
			$rules, 
			// Mensaje de error personalizado 
			[ 'captcha' => 'El captcha ingresado es incorrecto.' ]
		); 
        // DB::transaction(function () use ($request){
        // NEW CODE
        //   $paypal=false;
        //   $banking=false;
        //   $opm=false;
        // try {
        //         $default_address = new Address;
        //         $default_address->line1 = $request->default1;
        //         $default_address->line2 = $request->default2;
        //         if ($request->has('default3')) {
        //             $default_address->line3 = $request->default3;
        //         }
        //         if ($request->has('default4')) {
        //             $default_address->line4 = $request->default4;
        //         }
        //         $address->save();
        //         $billing_reference_id= $address->id;
        //         try {

        //         } catch (Exception $e) {

        //         }
        // } catch (Exception $e) {
        //     Address::destroy($billing_reference_id);
        //     return "Data1 not saved";
        // }

        //NEWCODE
        // DB::beginTransaction();

        // ENDS

        try {
            $paypal = false;
            $banking = false;
            $opm = false;
            $owbank = false;
            $card = false;
            $billing = false;
            $delivery = false;
            $payment_method_reference_id = "empty";
            $default_address = new Address;
            $default_address->city_id = $request->city_name;
            $default_address->line1 = $request->default1;
            $default_address->line2 = $request->default2;
            if ($request->has('default3')) {
                $default_address->line3 = $request->default3;
            }
            if ($request->has('default4')) {
                $default_address->line4 = $request->default4;
            }
            $default_address->save();
            $default_reference_id = $default_address->id;
            // *****
            if ($request->has('billing1')) {
                $address = new Address;
                $address->city_id = $request->city_name;
                $address->line1 = $request->billing1;
                $address->line2 = $request->billing2;
                if ($request->has('billing3')) {
                    $address->line3 = $request->billing3;
                }
                if ($request->has('billing4')) {
                    $address->line3 = $request->billing4;
                }
                $address->save();
                $billing = true;
                $billing_reference_id = $address->id;
            }

            if ($request->has('delivery1')) {
                # code...
                $shipping_address = new Address;
                $shipping_address->city_id = $request->city_name;
                $shipping_address->line1 = $request->delivery1;
                $shipping_address->line2 = $request->delivery2;
                if ($request->has('delivery3')) {
                    $shipping_address->line3 = $request->delivery3;
                }
                if ($request->has('delivery4')) {
                    $shipping_address->line3 = $request->delivery4;
                }
                $shipping_address->save();
                $delivery = true;
                $shipping_reference_id = $shipping_address->id;
            }

            $user = new User;
            $user->username = $request->username;
            $user->name = $request->full_name;

            $user->nric = "";
            $user->email = $request->username;
            $user->language_id = $request->language;
            $user->occupation_id =$request->occupation;
            $user->birthdate = $request->dob;
            $user->mobile_no = $request->mobile;
            $user->password = Hash::make($request->password);
            $user->gender = $request->gender;
            $user->annual_income = $request->income;
            if ($request->salutation == 'option1') {
                if ($request->has('otherinput')) {
                    # code...
                    $user->salutation = $request->otherinput;
                }
            } else {
                $user->salutation = $request->salutation;
            }

            $user->default_address_id = $default_reference_id;
            if ($billing == true) {
                # code...
                $user->billing_address_id = $billing_reference_id;
            }
            if ($delivery == true) {
                # code...
                $user->shipping_address_id = $shipping_reference_id;
            }

            $user->save();
            $user_id = $user->id;

            /****Electronics Checked***/
            $this->saveInterests($user, $request->electronics);
            /****Travel Checked***/
            $this->saveInterests($user, $request->travel);
            /****industrial Checked***/
            $this->saveInterests($user, $request->industrial);
            /****food Checked***/
            $this->saveInterests($user, $request->food);
            /****Books & Stationary Checked***/
            $this->saveInterests($user, $request->books);
            /****Fashion & Stationary Checked***/
            $this->saveInterests($user, $request->fashion);
            /****Sports & Outdoor Checked***/
            $this->saveInterests($user, $request->sports);
            /****decoration Checked***/
            $this->saveInterests($user, $request->decoration);
            /****present Checked***/
            $this->saveInterests($user, $request->present);
            /****weddings Checked***/
            $this->saveInterests($user, $request->weddings);
            /****furniture Checked***/
            $this->saveInterests($user, $request->furniture);
            /****health & Beauty Checked***/
            $this->saveInterests($user, $request->health);
            /****automotive Checked***/
            $this->saveInterests($user, $request->automotive);
            /***Construction******/
            $this->saveInterests($user, $request->construction);
            /***souvenirs******/
            $this->saveInterests($user, $request->souvenirs);
            /***restaurant******/
            $this->saveInterests($user, $request->restaurant);
            /***pets******/
            $this->saveInterests($user, $request->pets);

            $interest_reference_id = null;
            // check for payment_method
            if ($request->has('method')) {
                if ($request->get("method") == 'debit') {
                    $payment_method = New Credit;
                    $payment_method->user_id = $user->id;
                    // $payment_method->bank_id = $bank_id;
                    // $payment_method->method= $request->method;
                    $payment_method->number = $request->card_number;
                    $payment_method->name = $request->name_on_card;
                    $payment_method->expiry = $request->expiry_date;
                    $payment_method->cvv = $request->cvv;

                    $payment_method->save();
                    $payment_method_reference_id = $payment_method->id;
                    $card = true;
                }  //debit_r
                elseif ($request->get("method") == 'online_banking') {
                    $bank = new BankAccount;
                    $bank->bank_id = $request->online_banking_bank;
                    $bank->account_number2 = $request->account2;
                    $bank->save();
                    $payment_method_reference_id = $bank->id;
                    $banking = true;
                }//banking_r
                else if ($request->get("method") == 'paypal') {
                    $paypal = true;
                }; //paypal_r
            } //payment method ends
            if ($request->openm == "yes") {
                if ($request->has('account_bank')) {
                    try {
                        //if payment method above was bank and a bank account instance exists
                        if ($banking == true) {
                            $account = BankAccount::where('id', $payment_method_reference_id);
                            $account->swift = $request->account_swift;
                            $account->iban = $request->account_iban;
                            $account->account_name1 = $request->account_name;
                            $account->account_number1 = $request->account_number;
                            $account->save();
                            $bankaccount_reference_id = $payment_method_reference_id;
                            $owbank = true;
                        } //$banking
                        else {
                            throw new Exception("Bank Account Doesn't Exists", 1);

                        } //else
                    } catch (\Exception $e) {
                        $account = new BankAccount;
                        $account->swift = $request->account_swift;
                        $account->iban = $request->account_iban;
                        $account->account_name1 = $request->account_name;
                        $account->account_number1 = $request->account_number;
                        $account->save();
                        $bankaccount_reference_id = $account->id;
                        $owbank = true;
                    } //catch ends
                } else {
                } //????

            }  //openmethod ends

            $buyer_profile = new Buyer;
            $buyer_profile->user_id = $user->id;
            if ($request->hasFile('photo')) {
                $r1 = str_random(10);
                $r2 = str_random(5);
                $r3 = str_random(2);
                $pname = $r1 . $r2 . $r3;
                $base_path = "images/users/";
                $full_path = $base_path . $user->id;
                // try {
                File::makeDirectory(public_path($full_path), 0775, true);

                $img = $request->file('photo');
                $imgext = $img->getClientOriginalExtension();
                $name = $pname . "." . $imgext;

                Image::make($img)->resize('400', '300')->save($full_path . "/" . $name);

                $buyer_profile->photo_1 = $name;
            } //photo
            if ($owbank == true) {
                # code...
                $buyer_profile->bankaccount_id = $bankaccount_reference_id;
                $buyer_profile->company_name = $request->company_name;
                $buyer_profile->company_reg_no = $request->company_reg_no;
                $buyer_profile->potential_industry - $request->potential_industry;
                $buyer_profile->products = $request->products;
                $buyer_profile->amount = $request->amount;
            }//banking
            // New Addition

            $buyer_profile->save();
            $buyer_profile_reference_id = $buyer_profile->id;
            // if ($request->has('type')) {
            //     $buyer_role = $request->type;
            //     $buyer_role_id = DB::table('role')->where('slug', $buyer_role)->pluck('id');
            //     $role = new RoleUser;
            //     $role->user_id = $user->id;
            //     $role->role_id = $buyer_role_id;
            //     $role->save();
            // } //type
            // } //?
            //Add references in BuyerAddress
            $bad = new BuyerAddress;
            $bad->buyer_id = $buyer_profile_reference_id;
            $bad->address_id = $default_reference_id;
            $bad->save();
            $badi = $bad->id;
            if ($billing == true) {
                $bab = new BuyerAddress;
                $bab->buyer_id = $buyer_profile_reference_id;
                $bab->address_id = $billing_reference_id;
                $bab->save();
                $babi = $bab->id;
            }

            if ($delivery == true) {
                $bas = new BuyerAddress;
                $bas->buyer_id = $buyer_profile_reference_id;
                $bas->address_id = $shipping_reference_id;
                $bas->save();
                $basi = $bas->id;
            }
            //Add reference in BuyerCreditCard
            if ($card == true) {
                $credit = new BuyerCreditCard;
                $credit->buyer_id = $buyer_profile_reference_id;
                $credit->credit_card_id = $payment_method_reference_id;
                $credit->save();
            }

            if (Session::has('fb_')) {
                # code...
            }
            // Send EMAIL CONFIRMATION
            $e= new EmailController;
            $e->confirmEmail($request->username,2);
            return redirect()->route('buyerinformation');
        } catch (\Exception $e) {

            try {
                if(isset($shipping_reference_id))
                    Address::destroy($shipping_reference_id);
            } catch (\Exception $e) {
                echo "<script> console.log('Exception:Shipping')</script>";
            }
            try {
                if(isset($billing_reference_id))
                    Address::destroy($billing_reference_id);
            } catch (\Exception $e) {
                echo "<script> console.log('Exception:Billing')</script>";
            }
            try {
                if(isset($default_reference_id))
                    Address::destroy($default_reference_id);
            } catch (\Exception $e) {
                echo "<script> console.log('Exception:Default')</script>";
            }
            try {
                if(isset($user_id))
                    $user= User::find($user_id);
                $user->email=time();
                $user->save();
                    User::destroy($user_id);
            } catch (\Exception $e) {
                echo "<script> console.log('Exception:User')</script>";
            }
            try {
                if(isset($interest_reference_id))
                BuyerCategory::destroy($interest_reference_id);
            } catch (\Exception $e) {
                echo "<script> console.log('Exception:BuyerCategory')</script>";
            }
            try {
                if(isset($buyer_profile_reference_id))
                    Buyer::destroy($buyer_profile_reference_id);
            } catch (\Exception $e) {

                echo "<script> console.log('Exception:Buyer')</script>";
            }
            if (isset($bad)) {
                try {
                    BuyerAddress::destroy($badi);
                } catch (\Exception $e) {
                };
            }
            if (isset($bas)) {
                try {
                    BuyerAddress::destroy($basi);
                } catch (\Exception $e) {

                }
            }

            try {
                if ($banking == true) {
                    try {
                        BankAccount::destroy($payment_method_reference_id);
                        echo "<script> console.log('Exception:BankAccount')</script>";
                    } catch (\Exception $e) {
                        try {
                            BankAccount::destroy($bankaccount_reference_id);
                        } catch (\Exception $e) {
                            echo "<script> console.log('Exception:BankAccount2')</script>";
                        }
                    }
                } elseif ($card == true) {
                    try {
                        Credit::destroy($payment_method_reference_id);
                    } catch (\Exception $e) {
                        echo "<script> console.log('Exception:Card')</script>";
                    }
                } elseif ($paypal == true) {
                    # code...
                }
            } catch (\Exception $e) {
                echo "<script> console.log('Exception:Method')</script>";
            }

            return $e;
            return "Data not saved";
            // DB::rollBack();
            // throw new Exception($e, 1);
            // // Manual DB rollback
            // return "Data Not Saved";
        }


        // }); //Transaction ends


    }


    public function storeBuyernewDetails(Request $request)
    {
        // return $request->method;
	//	dd("DING DONG");
        if (!$request->isMethod('post')) {
            return "Only POST requests are allowed";
        }
        if (!isset($request)) {
            return "Empty forms are not accepted";
        }
        $this->validate($request, [
            'username' => 'required|unique:users|max:100|min:7',
            'email' => 'required|unique:users|max:100|min:7',
            'full_name' => 'required|min:3',
            //'dob' => 'required',
            'password' => 'required|max:100|min:7|confirmed',
            'password_confirmation' => 'required',
            //'language' => 'required',
            //'mobile' => 'required|max:50|min:1',
            //'gender' => 'required',
            //'photo' => 'image',
            //'default1' => 'required',
            //'defaultcity_name' => 'required',
            //'occupation' => 'required'

        ]);
		$bankaccout_id=0;

        try {
            $paypal = false;
            $banking = false;
            $opm = false;
            $owbank = false;
            $card = false;
            $billing = false;
            $delivery = false;
            $payment_method_reference_id = "empty";
            $default_address = new Address;
            $default_address->city_id = $request->defaultcity_name;
            $default_address->line1 = $request->default1;

            if ($request->has('default_postcode')) {
                $default_address->postcode = $request->default_postcode;
            }
            if ($request->has('defaultarea_name')) {
                $default_address->area_id = $request->defaultarea_name;
            }

            $default_address->save();
            $default_reference_id = $default_address->id;

            if(($request->billingcheck)!= null){
                    $billing = true;
                    $billing_reference_id =  $default_reference_id;

            }else {
                if ($request->has('billing1')) {
                    $address = new Address;
                    $address->city_id = $request->billingcity_name;
                    $address->line1 = $request->billing1;
                    if ($request->has('billing_postcode')) {
                        $address->postcode = $request->billing_postcode;
                    }
                    if ($request->has('billingarea_name')) {
                        $address->area_id = $request->billingarea_name;
                    }
                    $address->save();
                    $billing = true;
                    $billing_reference_id = $address->id;
                }
            }

            if(($request->deliverycheck)!= null){
                    # code...
                    $delivery = true;
                    $shipping_reference_id =  $default_reference_id;

            }else{
                if ($request->has('delivery1')) {
                    # code...
                    $shipping_address = new Address;
                    $shipping_address->city_id = $request->deliverycity_name;
                    $shipping_address->line1 = $request->delivery1;

                    if ($request->has('delivery_postcode')) {
                        $shipping_address->postcode = $request->delivery_postcode;
                    }
                    if ($request->has('deliveryarea_name')) {
                        $shipping_address->area_id = $request->deliveryarea_name;
                    }
                    $shipping_address->save();
                    $delivery = true;
                    $shipping_reference_id = $shipping_address->id;
                }
            }


            $user = new User;
            $user->username = $request->username;
            $user->name = $request->full_name;
			$split_name = explode(" ", $request->full_name);
			if(sizeof($split_name)==1){
				$user->first_name = $split_name[0];
			} else if(sizeof($split_name)==2){
				$user->first_name = $split_name[0];
				$user->last_name = $split_name[1];
			} else if(sizeof($split_name)==3){
				$user->first_name = $split_name[0] .  " " . $split_name[1];
				$user->last_name = $split_name[2];
			} else if(sizeof($split_name)>=4){
				$user->first_name = $split_name[0] .  " " . $split_name[1];
				$user->last_name = $split_name[2] . " " . $split_name[3];
			}

            $user->nric = "";
            $user->email = $request->email;

            /**
             * 08.04.2017 => Updated buyer details
             * cov_country_id => nationality_country_id
             */
            $user->nationality_country_id = $request->cov_country_id;
            /**
             * End update
             */

            $user_name = $request->username;
            $user_email = $request->email;

            $user->occupation_id = $request->occupation;
            $user->birthdate = $request->dob;
            $user->mobile_no = $request->mobile;
            $user_password = $request->password;
            $user->password = Hash::make($request->password);
            $user->gender = $request->gender;
            $user->annual_income = $request->income;
            if ($request->salutation == 'option1') {
                if ($request->has('otherinput')) {
                    # code...
                    $user->salutation = $request->otherinput;
                }
            } else {
                $user->salutation = $request->salutation;
            }

            $user->default_address_id = $default_reference_id;
            if ($billing == true) {
                # code...
                $user->billing_address_id = $billing_reference_id;
            }
            if ($delivery == true) {
                # code...
                $user->shipping_address_id = $shipping_reference_id;
            }

            $user->save();
            $user_id = $user->id;
			$memberin = DB::table('member')->where('email',$user->email)->get();
			$osmallmemberin = DB::table('osmallmember')->where('email',$user->email)->get();
			foreach($memberin as $memberi){
				$mid = DB::table('member')->where('email',$user->email)->update(['user_id'=>$user->id,'member_status'=>'tagged','updated_at'=>date('Y-m-d H:i:s')]);
			}
			foreach($osmallmemberin as $osmallmemberi){
				$mid = DB::table('osmallmember')->where('email',$user->email)->update(['user_id'=>$user->id,'member_status'=>'tagged','updated_at'=>date('Y-m-d H:i:s')]);
			}
			$role = new RoleUser;
			$role->user_id = $user_id;
			$role->role_id = 2;
			$role->save();

            foreach($request->language as $key => $value){
                $userlanguage = new Userlanguage;
                $userlanguage->language_id = $value;
                $userlanguage->user_id = $user_id;
                $userlanguage->save();
            }
			$bankaccout_id = 0;
            if ($request->has('account_name')) {

                if($request->has('account_name') != ""){
					$payment_receive = New BankAccount;

					$payment_receive->account_name1=$request->account_name;
					$payment_receive->account_number1 = $request->account_number;
					$payment_receive->bank_id = $request->bank;
					//$payment_receive->code = $request->bank_code;
					$payment_receive->iban = $request->iban;
					$payment_receive->swift = $request->swift;

					$payment_receive->save();
					$bankaccout_id=$payment_receive->id;
				}
            }  //openmethod ends

            $buyer_profile = new Buyer;
            $buyer_profile->user_id = $user->id;
            $base_path = "images/users/";
            $full_path = $base_path . $user->id;
            File::makeDirectory(public_path($full_path), 0775, true);

            for($i=0;$i<7;$i++){
                $photo='photo'.$i;
				if ($request->hasFile($photo)) {
                $name="";
                $img="";
                $r1 = str_random(10);
                $r2 = str_random(5);
                $r3 = str_random(2);
                $pname = $i.$r1 . $r2 . $r3;
                // try {

                $img = $request->file('photo'.$i);
                $imgext = $img->getClientOriginalExtension();
                $name = $pname . "." . $imgext;

                Image::make($img)->save($full_path . "/" . $name);
                $photoname='photo_'.($i+1);
                $buyer_profile->$photoname = $name;

              } //photo
            }

			$buyer_profile->bankaccount_id = $bankaccout_id;
            $buyer_profile->save();
            $buyer_profile_reference_id = $buyer_profile->id;

            $bad = new BuyerAddress;
            $bad->buyer_id = $buyer_profile_reference_id;
            $bad->address_id = $default_reference_id;
            $bad->save();
            $badi = $bad->id;
            if ($billing == true) {
                $bab = new BuyerAddress;
                $bab->buyer_id = $buyer_profile_reference_id;
                $bab->address_id = $billing_reference_id;
                $bab->save();
                $babi = $bab->id;
            }

            if ($delivery == true) {
                $bas = new BuyerAddress;
                $bas->buyer_id = $buyer_profile_reference_id;
                $bas->address_id = $shipping_reference_id;
                $bas->save();
                $basi = $bas->id;
            }
            //Add reference in BuyerCreditCard
            if ($card == true) {
                $credit = new BuyerCreditCard;
                $credit->buyer_id = $buyer_profile_reference_id;
                $credit->credit_card_id = $payment_method_reference_id;
                $credit->save();
            }
            $e= new EmailController;
            $e->confirmEmail($request->email,2);
			
			// try{
			// 	$mgClient = new Mailgun('key-80495c8905443d885803333b49b45718');
			// 	$domain = "opensupermall.com";

			// 	# Make the call to the client.
			// 	$result = $mgClient->sendMessage($domain, array(
			// 		'from'    => 'Opensupermall <info@opensupermall.com>',
			// 		'to'      => $user->first_name . ' ' . $user->first_name .  ' <'. $user->email .'>',
			// 		'subject' => 'Confirm your Opensupermall account',
			// 		'html'    => '<h4>Plase, confirm your Opensupermall Account!</h4>
			// 					<p>click on the following link: <a href="http://'.$_SERVER['HTTP_HOST'].'/verify/'.$user_id.'">Confirm</a></p>'
			// 	));					
			// } catch (\Exception $e) {
				
			// }	
			
			$uniqueid = UtilityController::buyeruniqueid($request->defaultcity_name);
			DB::table('nbuyerid')->insert(['nbuyer_id'=>$uniqueid, 'buyer_id'=>$buyer_profile->id, 'user_id' => $user->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]); 
			UtilityController::createQr($buyer_profile->id,'buyer',IdController::nB($user->id));
			$this->messageHandler = new MessageHandler();
			\Session::flash(Config::get('messages.key.name'), $this->messageHandler->success('buyerRegistered', null, null, true, true, true));
			return redirect()->route('home');


        } catch (\Exception $e) {
			dd($e);
              $user= User::find($user_id);
                $user->email=time();
                $user->save();
            User::destroy($user->id);
            try {
                if(isset($shipping_reference_id))
                    Address::destroy($shipping_reference_id);
            } catch (\Exception $e) {
                echo "<script> console.log('Exception:Shipping')</script>";
            }
            try {
                if(isset($billing_reference_id))
                    Address::destroy($billing_reference_id);
            } catch (\Exception $e) {
                echo "<script> console.log('Exception:Billing')</script>";
            }
            try {
                if(isset($default_reference_id))
                    Address::destroy($default_reference_id);
            } catch (\Exception $e) {
                echo "<script> console.log('Exception:Default')</script>";
            }
            try {
                if(isset($user_id))
                    User::destroy($user_id);
            } catch (\Exception $e) {
                echo "<script> console.log('Exception:User')</script>";
            }

            try {
                if(isset($buyer_profile_reference_id))
                    Buyer::destroy($buyer_profile_reference_id);
            } catch (\Exception $e) {

                echo "<script> console.log('Exception:Buyer')</script>";
            }
            if (isset($bad)) {
                try {
                    BuyerAddress::destroy($badi);
                } catch (\Exception $e) {
                };
            }
            if (isset($bas)) {
                try {
                    BuyerAddress::destroy($basi);
                } catch (\Exception $e) {

                }
            }

            return $e;
            return "Data not saved";
            // DB::rollBack();
            // throw new Exception($e, 1);
            // // Manual DB rollback
            // return "Data Not Saved";
        }


        // }); //Transaction ends


    }

    public function memberscrm($user_id){
		$customers = DB::table('osmallmember')->leftJoin('users','osmallmember.user_id','=','users.id')
		->select('osmallmember.*','users.first_name','users.last_name')
		->where('type','customer')->where('recruiter_id',$user_id)->get();
		return view('buyer.crm')
            ->with('customers',$customers)
            ->with('user_id',$user_id);
		
	}
	
	 public function memberscrmadd(Request $r)
    {
		try{
			$type = "customer";
			$email=$r->email;
			$email = str_replace(" ","",$email);
			$user = DB::table('users')->where('email',$email)->first();
			$recruiter = $r->recruiter;
			$emailexists = DB::table('osmallmember')->where('email',$email)->where('type',$type)->first();
			if(is_null($emailexists)){
				if(is_null($user)){
					if(is_null($recruiter)){
						$mid = DB::table('osmallmember')->insertGetId(['email'=>$email,'type'=>$type,'user_id'=>0,'member_status'=>'not exists','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					} else {
						$mid = DB::table('osmallmember')->insertGetId(['email'=>$email,'type'=>$type,'user_id'=>0,'recruiter_id'=>$recruiter,'member_status'=>'not exists','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					}
					//dd($mid);
					$newmember = DB::table('osmallmember')->where('id',$mid)->first();
					$id= new IdController;
					$newid = $id->nB(0);
					$cname = "<span title='' class='customer_name' id='customer_name" . $mid . "' rel='" . $mid . "'>&nbsp;&nbsp;&nbsp;&nbsp;</span>	
					<span id='sinputcustomer_name" . $mid . "' style='display: none;'>
						<input type='text' value='' rel='" . $mid . "' class='customer_name_input' id='inputcustomer_name" . $mid . "' />
					</span>	";
					$cmobile = "<span title='' class='customer_mobile' id='customer_mobile" . $mid . "' rel='" . $mid . "'>&nbsp;&nbsp;&nbsp;&nbsp;</span>	
					<span id='sinputcustomer_mobile" . $mid . "' style='display: none;'>
						<input type='text' value='' rel='" . $mid . "' class='customer_mobile_input' id='inputcustomer_mobile" . $mid . "' />
					</span>	";
					$newemployee = array('id'=>$newid,'user_id'=>0, 'name' => $cname, 'mobile' => $cmobile, 'status' => $newmember->status, 'role' => '', 'email'=>$email);
					
					return response()->json(['status'=>'success',
					'long_message'=>'New Customer added!','employee'=>$newemployee]);	
				} else {
					if(is_null($recruiter)){
						$mid = DB::table('osmallmember')->insertGetId(['email'=>$email,'type'=>$type,'user_id'=>$user->id,'member_status'=>'tagged','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					} else {
						$mid = DB::table('osmallmember')->insertGetId(['email'=>$email,'type'=>$type,'user_id'=>$user->id,'recruiter_id'=>$recruiter,'member_status'=>'tagged','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					}			
					
					$newmember = DB::table('osmallmember')->where('id',$mid)->first();
					$id= new IdController;
					$newid = $id->nB($user->id);
					$cname = "<span title='" .$user->first_name . " " . $user->last_name ."' class='customer_name' id='customer_name" . $mid . "' rel='" . $mid . "'>&nbsp;&nbsp;" . $user->first_name . " " . $user->last_name . "&nbsp;&nbsp;</span>	
					<span id='sinputcustomer_name" . $mid . "' style='display: none;'>
						<input type='text' value='" . $user->first_name . " " . $user->last_name ."' rel='" . $mid . "' class='customer_name_input' id='inputcustomer_name" . $mid . "' />
					</span>	";
					$cmobile = "<span title='' class='customer_mobile' id='customer_mobile" . $mid . "' rel='" . $mid . "'>&nbsp;&nbsp;&nbsp;&nbsp;</span>	
					<span id='sinputcustomer_mobile" . $mid . "' style='display: none;'>
						<input type='text' value='' rel='" . $mid . "' class='customer_mobile_input' id='inputcustomer_mobile" . $mid . "' />
					</span>	";
					$newemployee = array('id'=>$newid,'user_id'=>$user->id, 'mobile' => $cmobile, 'name' => $cname, 'status' => $newmember->status, 'role' => 'Member', 'email'=>$email);
					
					return response()->json(['status'=>'success',
					'long_message'=> 'New Customer added!','employee'=>$newemployee]);						
				}
			} else {
				return response()->json(['status'=>'warning',
					'long_message'=>'Customer already exists!']);
			}
		} catch (\Exception $e) {
			//dd($e);
			return response()->json(['status'=>'error',
				'long_message'=>'An unexpected error ocurred! Please contact OpenSupport']);
        }
	}	
	
    public function createsalesmemo(Request $request){
		$input = $request->all();
	//	dd($input);
		$user_id = $request->recruiter;
		$location = $request->location;
		$qty = $request->qty;
		$ids = $request->ids;
		$prices = $request->prices;
		$salesmemo = DB::table('salesmemo')->insertGetId(['user_id'=>$user_id,'fairlocation_id'=>$location,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		$sm = DB::table('salesmemo')->where('id',$salesmemo)->first();
		$newsmid = UtilityController::generaluniqueid($sm->id,'1','1', $sm->created_at, 'nsalesmemoid', 'nsalesmemo_id');
		DB::table('nsalesmemoid')->insert(['nsalesmemo_id'=>$newsmid, 'salesmemo_id'=>$sm->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
		$counter = 0;
		$laspid = 0;
		foreach($prices as $price){
			DB::table('salesmemoproduct')->insertGetId(['salesmemo_id'=>$salesmemo,'product_id'=>$ids[$counter],'order_price'=>$price*100,'quantity'=>$qty[$counter],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			$laspid = $ids[$counter];
			$counter++;
		}
		UtilityController::createQr($sm->id,'salesmemo',IdController::nSM($sm->id));
		UtilityController::createBarcode($sm->id,'salesmemo',IdController::nSM($sm->id));
		$merchant = DB::table('merchant')->join('merchantproduct','merchantproduct.merchant_id','=','merchant.id')->where('merchantproduct.product_id',$laspid)->select('merchant.*')->first();
		if(!is_null($merchant)){
			$salesmemo_no = $merchant->salesmemo_no;
			if(!is_null($salesmemo_no)){
				$salesmemo_no++;
			} else {
				$salesmemo_no = 1;
			}
		//	DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
			DB::table('merchant')->where('id',$merchant->id)->update(['salesmemo_no'=>$salesmemo_no]);
			DB::table('salesmemo')->where('id',$sm->id)->update(['salesmemo_no'=>$salesmemo_no]);
		}
		$return['response'] = "success";
		$return['id'] = $salesmemo;
		return json_encode($return);
	}
	
    public function stocktakeinfo($id){
		$return['id'] = '';
		$return['nproductid'] = '';
		$return['photo_1'] = '';
		$return['qrphoto'] = '';
		$return['name'] = '';
		$return['available'] = 0;
		$return['qtyordered'] = 0;
		$product = DB::table('product')->where('id',$id)->first();
		if(!is_null($product)){
			$return['id'] = $product->id;
			$return['photo_1'] = $product->photo_1;
			$return['name'] = $product->name;
			$return['available'] = $product->available;
			$return['nproductid'] = IdController::nP($product->id);
			$qtyorder = DB::table('porder')
			->join('orderproduct','orderproduct.porder_id','=','porder.id')
			->join('product','product.id','=','orderproduct.product_id')
			->where('product.parent_id',$id)
			->select(DB::raw('SUM(orderproduct.quantity) as totalordered'))
			->first();
			if(!is_null($qtyorder)){	
				if(!is_null($qtyorder->totalordered)){
					$return['qtyordered'] = $qtyorder->totalordered;
				}
			}
			$qrphoto = DB::table('productqr')
			->join('qr_management','qr_management.id','=','productqr.qr_management_id')
			->where('productqr.product_id',$id)
			->first();
			if(!is_null($qrphoto)){
				$return['qrphoto'] = $qrphoto->image_path;
			}
		}
		return json_encode($return);
	}
	
    public function salesmemoinfo($id){
		$return['id'] = '';
		$return['nproductid'] = '';
		$return['photo_1'] = '';
		$return['qrphoto'] = '';
		$return['name'] = '';
		$return['available'] = 0;
		$return['qtyordered'] = 0;
		$return['retail_price'] = 0;
		$product = DB::table('product')->where('id',$id)->first();
		if(!is_null($product)){
			$return['id'] = $product->id;
			$return['photo_1'] = $product->photo_1;
			$return['name'] = $product->name;
			$return['available'] = $product->available;
			$return['retail_price'] = $product->retail_price/100;
			$return['nproductid'] = IdController::nP($product->id);
			$qtyorder = DB::table('porder')
			->join('orderproduct','orderproduct.porder_id','=','porder.id')
			->join('product','product.id','=','orderproduct.product_id')
			->where('product.parent_id',$id)
			->select(DB::raw('SUM(orderproduct.quantity) as totalordered'))
			->first();
			if(!is_null($qtyorder)){	
				if(!is_null($qtyorder->totalordered)){
					$return['qtyordered'] = $qtyorder->totalordered;
				}
			}
			$qrphoto = DB::table('productqr')
			->join('qr_management','qr_management.id','=','productqr.qr_management_id')
			->where('productqr.product_id',$id)
			->first();
			if(!is_null($qrphoto)){
				$return['qrphoto'] = $qrphoto->image_path;
			}
		}
		return json_encode($return);
	}	
	
    public function stocktake($merchant, $recruiter,$location){
		$products = DB::table('product')
		->join('merchantproduct','merchantproduct.product_id','=','product.id')
		->join('merchant','merchantproduct.merchant_id','=','merchant.id')
		->select('product.id','product.name')
		->where('merchant.user_id',$merchant)
		->where('product.status','active')
		->where('product.segment','b2c')
		->get();
		return view('buyer.stocktake')
            ->with('products',$products)
            ->with('location',$location)
            ->with('merchant',$merchant)
            ->with('recruiter',$recruiter);
	}
	
    public function salesmemo($merchant, $recruiter,$location){
		$products = DB::table('product')
		->join('merchantproduct','merchantproduct.product_id','=','product.id')
		->join('merchant','merchantproduct.merchant_id','=','merchant.id')
		->select('product.id','product.name')
		->where('merchant.user_id',$merchant)
		->where('product.status','active')
		->where('product.segment','b2c')
		->get();
		return view('buyer.salesmemo')
            ->with('products',$products)
            ->with('location',$location)
            ->with('merchant',$merchant)
            ->with('recruiter',$recruiter);
	}	
	
    public function fairmode($merchant, $recruiter){
		return view('buyer.fairmode')
            ->with('merchant',$merchant)
            ->with('recruiter',$recruiter);
	}
    public function saveInterests($user, $interests)
    {
        $buyer_interests = $interests;
        if (!empty($buyer_interests) && isset($buyer_interests)) {
            $interests_array = explode(';', $buyer_interests);
            $subcat_level = $interests_array[0];
            $subcat_id = $interests_array[1];
            $interest = new BuyerCategory;
            $interest->user_id = $user->id;
            $interest->subcat_id = $subcat_id;
            $interest->subcat_level = $subcat_level;
            $interest->save();
        }

    }
    public function get_autolink($user_id)
    {
        # code...
         try {
            $autolinks = Autolink::where('initiator', $user_id)->where('status', '!=','unlinked')->orderBY('created_at','DESC')->get();

            $autolinks[0];//Just to check if there is any autolink

            $a_links = array();
            foreach ($autolinks as $link) {
                $temp = array();
                $temp['id'] = $link->id;
                $temp['merchant_id'] = $link->responder;
                $temp['linked_since'] = $link->linked_since;
              //  $temp['rid'] = $link->responder_uid;
				$mname = Merchant::where('id', $link->responder)->pluck('company_name');

                $temp['mname'] = $mname;
                $temp['status'] = $link->status;

                try {
                    $temp ['l_s'] = $link->linked_since;

                    $temp['deleted_at'] = $link->deleted_at;
                } catch (\Exception $e) {

                    // echo "<script> console.log('Exception: Bad Linked-Since Date'); </script>";

                }
                array_push($a_links, $temp);

            }

        } catch (\Exception $e) {
            $a_links = array();
			//dd($e);
            // echo "<script> console.log('Exception:Autolink not found'); </script>";
            // return "Please fill up the autolink table and connect with your user id";
        }

        return $a_links;
    }
    public function get_shipping($porders,$porder=false)
    {
        # code...
        $couriers = array();
        try {
            // $porders = DB::table('porder')->where('user_id', $user_id)->get();


            foreach ($porders as $id) {
                $courier = DB::table('courier')->where('shipping_id', $id->courier_id)->first();
                if ($porder==true) {
                    # code...
                    $courier->porder_id= $id->id;
                } else {
                    # code...
                }

                array_push($couriers, $courier);
            }
        } catch (\Exception $e) {

        }
        return $couriers;
    }

    public function products($porders,$payment=false)
    {
        # code...
        $products = array();
		
        foreach ($porders as $order) {
            try {
                if($order->mode == "cash"){
					$odata = DB::table('orderproduct')->where('porder_id', $order->id)->get();
				} else {
					$odata = DB::table('ordertproduct')->where('porder_id', $order->id)->get();
				}
               // $pdata = DB::table('product')->where('id', $odata->product_id)->first();//product detail
				$total = 0;
				foreach ($odata as $opd) {
					$amount = $opd->quantity * ($opd->order_price + $opd->order_delivery_price );
					$total += $amount;
				}
				
                // return $pdata->name;

                //
             /*   if ($pdata->subcat_level == '0') {
                    $cat2 = DB::table('category')->where('id', $pdata->category_id)->pluck('name');
                } else {
                    try {
                        $table = 'subcat_level_' . $link->subcat_level;
                        $totaldata = DB::table($table)->where('id', $link->subcat_id)->first();
                        $catdata = DB::table('category')->where('id', $totaldata->category_id)->first();
                        $cat2 = $catdata->name;
                        $subcat2 = $totaldata->description;
                    } catch (\Exception $e) {
                        $cat2 = "Not Found";
                        $subcat2 = "Not Found";
                    }
                }*/
              //  $commission= Product::where('id',$pdata->id)->pluck('osmall_commission');
                $temp = array();
                $temp['total'] = $total; //
             //   $temp['pname'] = $pdata->name; //
                $temp['oid'] = $order->id;//Order ID
                $temp['mode'] = $order->mode;//Order ID
            //    $temp['quantity'] = $odata->quantity;
            //    $temp['orig_price'] = $pdata->retail_price;
            //    $temp['retail_price'] = $pdata->discounted_price;
                $temp['o_rcv'] = $order->updated_at;
                $temp['o_exec'] = $order->created_at;
                $temp['uid'] = $order->user_id;
                $temp['source'] = $order->source;
               // $temp['sku'] = $pdata->id; //product id
                $temp['comm']=0;
                $temp['desc']=$order->description;
				$pay = 0;
                if ($payment==true) {
                    # code...
                    $pay = DB::table('payment')->where('id',$order->payment_id)->first();
                }
                $temp['payment']=$pay;
                array_push($products, $temp);
            } catch (\Exception $e) {
               //dd($e);
            }
        }
        return $products;
    }

    public function buyer_orders_pagination($user_id, $start = 0){
		$end=$start+30;

        $ret=array();
        if (!Auth::check()) {
            return $ret;
        }
        try {
            $ret=POrder::join('orderproduct', 'porder.id', '=', 'orderproduct.porder_id')
					->leftJoin('nporderid', 'nporderid.porder_id', '=', 'porder.id')
					->select(DB::raw("porder.*, SUM(orderproduct.order_price * orderproduct.quantity) as total,  DATE_FORMAT(porder.created_at,'%d%b%y %H:%i') as received, IFNULL(nporderid.nporder_id,LPAD(porder.id,16,'E')) as order_id,DATE_FORMAT(porder.updated_at,'%d%b%y %H:%i') as completed"))
					->groupBy("porder.id")
					->where('user_id', $user_id)->orderBy('created_at','DESC'); 
              
        } catch (\Exception $e) {
            // dd($e);
        }
        return Datatables::eloquent($ret)->make(true);	
	//	DB::table('porder')->where('user_id', $user_id)->orderBy('created_at','DESC')
	}
	
	public function mobautolink($id)
    {
		$a_links= $this->get_autolink($id);
		return response()->view('buyer.mobile.dautolink',
        ['autolinks'=>$a_links]);
	}
	
	public function mobstaff($user_id)
    {
		$fairmerchant = DB::table('merchant')->join('company','merchant.user_id','=','company.owner_user_id')
						->join('member','member.company_id','=','company.id')->where('member.type','member')->where('member.user_id',$user_id)->select('merchant.*')->get();
		return response()->view('buyer.mobile.fairmode',
        ['fairmerchant'=>$fairmerchant,'user_id'=>$user_id]);
	}
	
	public function mobinformation($user_id)
    {
        $buyer = Buyer::where('user_id' , $user_id)->first();
		//dd($buyer);
		$imagenum = array();
        if (!is_null($buyer)) {
            # code...
        $buyerinfo = Buyer::where('user_id', $user_id)->first();
		
        $o= new OpenWishController();
        $openwish = $o->get_openwish($user_id);
        try {
            for($i=0;$i<7;$i++) {
                $photo='photo_'.($i+1);
                $buyer_image = $buyer->$photo;
                $imagenum[$i]=0;
                if ($buyer_image == "") {
                    $image[$i] = "";
                    $imagenum[$i]=1;
                } else {
                    $image[$i] = "images/users/" . $user_id . "/" . $buyer_image;
                    $imagenum[$i]=0;
                }
            }
            $buyer_img = true;
        } catch (\Exception $e) {
            echo "<script> console.log('Exception:Image not found'); </script>";
            $image = "images/placecards/dummy.jpg";
        }
        }

        else{
			return redirect()->back();
        }
        $smmProducts = SMMout::smmOuts($user_id);
        try {
            // $smmOutuser=SMMout::where('user_id',$user_id)->get();
            $tempsmmOutuser=SMMout::where('user_id',$user_id);
            $smmOutuser=$tempsmmOutuser->get();
            $mostrecentSmmOut=$tempsmmOutuser->orderBy('created_at', 'desc')->first();
            $connections= $mostrecentSmmOut->connections;
            // return $connections;
        } catch (\Exception $e) {
            // return $e;
            $smmOutuser=array();
            $connections=0;

        }
        $smmIn=array();
        $shares= 0;
        $smmInsales=0;
        $smmIncomm=0;
        $smmIncommthisYear=0;
        $todays_date= Carbon::now();
        $clicked=0;

        $userID = Auth::id();
        $shares= SMMout::where('user_id', $userID)->sum('shares');
        $clicked= count(

            SMMin::join('smmout','smmin.smmout_id','=','smmout.id')
            ->where('smmout.user_id','=',$user_id)
            ->get()
            );
        $earned_since = DB::select(DB::raw("SELECT SUM(ss.commission) as pes FROM  sales_staff ss WHERE  ss.user_id = $userID and ss.type = 'smm'  and ss.created_at BETWEEN ss.created_at AND CURDATE() GROUP BY ss.id"));
       
        $unpaid = DB::select(DB::raw("SELECT SUM(ss.commission) as pes FROM sales_staff ss, porder po, smmin si WHERE ss.user_id = $userID and ss.type = 'smm'   and si.porder_id = po.id and si.comm_claimed = 0 GROUP BY ss.id "));
        

        $ytd = DB::select(DB::raw("SELECT SUM(ss.commission) as eytd FROM sales_staff ss WHERE  ss.user_id = $userID and ss.type = 'smm'  and ss.created_at BETWEEN CONCAT(extract(year FROM CURDATE()), '-01', '-01') AND CURDATE() GROUP BY ss.id"));
       
        $smmEarnedSince = is_array($earned_since) ? $earned_since : null;
        $smmYearToDate = is_array($ytd) ? $ytd : null;
        $smmPending = is_array($unpaid) ? $unpaid : null;

        // return $smmIn;

        $dateObj = new Date();
        $userObj = new User();
        // $userModel = $userObj->with('merchant', 'occupation', 'merchant.address', 'merchant.city')->where('id', '=', $u->id)->get()->first();
        // $userModel->age = 12;//$dateObj->age(new DateTime($u->birthdate),null,true);
        // return $user_id;

        $user = User::where('id', $user_id)->first(); //?Why this returns a list

        if ($user->first_name == null and $user->last_name == null) {
            $name = $user->name;

        } elseif ($user->first_name != null and $user->last_name != null) {
            $name = $user->first_name . " " . $user->last_name;
        } elseif ($user->last_name == null and $user->name == null) {
            $name = $user->first_name;
        } elseif ($user->name != null and $user->first_name != null) {
            # code...
            $name = $user->name;
        } elseif ($user->first_name == null and $user->name == null) {
            # code...
            $name = $user->last_name;
        } elseif ($user->first_name == null and $user->name != null) {
            # code...
            $name = $user->name;
        } elseif ($user->name == null and $user->first_name == null and $user->last_name == null) {
            # code...
            $name = "John Doe"; //? Get the joke??
        }
        $member_since = $user->created_at->format('dMy H:i');

        try {
            $time= $user->birthdate;
            if ($time!="30/11/-0001") {
            $time=str_replace("/","-",$time);
            $date=date_create($time);
            $now = \Carbon::now();
            // return $now;
            $age = $date->diff($now)->y;
            }
            else {
                $age="";
            }


        } catch (\Exception $e) {

            $age = "";
            echo "<script>console.log('Invalid Birthdate or Birthdate is string in users table');</script>";
        }

        try {
            $occupation = Occupation::where('id', $user->occupation_id)->first()->name;
        } catch (\Exception $e) {
            $occupation = "---";
            echo "<script>console.log('Occupation id not found');</script>";
        }

        // $occupation=Occupation::where('id',$user->occupation_id)->get()[0]->name;//production version
        // $occupation=Occupation::where('id','2')->get()[0]->name; //test version
        // $language= Language::where('id',$user->language_id)->get()->description;//production_version

        $language = Language::select('language.*')
                ->join('userlanguage','language.id','=','userlanguage.language_id')
                ->where('userlanguage.user_id',$user_id)
                ->get();

        $bi = BuyerCategory::where('user_id', $user_id)->get(); //returns an array.for buyer interests
        $t = "subcat_level_"; //temp variable
        $interests = "";

        // $bi= (array)$bi;
        try {
            $filter = $bi->subcat_level;
            if (!empty($bi)) {
                foreach ($bi as $b) {
                    if ($b->subcat_level_ == '0') {
                        $interest = DB::table('category')->where('id', $b->subcat_id)->pluck('description');
                        $interests = $interests . " " . $interest;
                    } elseif ($b->subcat_level_ == "?") {

                    } else {
                        $table = $t . $b->subcat_level;
                        $interest = DB::table($table)->where('id', $b->subcat_id)->pluck('description');
                        $interests = $interests . " " . $interest;
                    }
                }
            } else {
                $interests = "No interest specified";
            }

        } catch (\Exception $e) {
            $interests = "No interest specified";
        }

        // return $interests;
        try {
            $billing_address = Address::where(['id' => $user->billing_address_id])->get()[0];//ba
        } catch (\Exception $e) {
            echo "<script>console.log('No Billing Address Found');</script>";
            $billing_address = "";
        }

        try {
            $default_address = Address::where(['id' => $user->default_address_id])->get()[0]; //da
        } catch (\Exception $e) {
            echo "<script>console.log('No Default Address Found');</script>";
            $default_address = "";
        }
        //Buyer
        try {
            $buyer = Buyer::where('user_id', $user_id);
        } catch (\Exception $e) {
            echo "<script>console.log('No Buyer Detail Found');</script>";
        }
		return response()->view('buyer.mobile.information',
        ['name'=>$name,'user_id'=>$user_id,'member_since'=>$member_since,'age'=>$age
		,'occupation'=>$occupation,'user'=>$user,'language'=>$language,'interests'=>$interests]);
	}
	
	public function moblikes($user_id)
    {
		$product_likes = DB::select(DB::raw("SELECT product.*, DATE_FORMAT(usersproduct.created_at,'%d%b%y') as since, usersproduct.created_at 
		FROM product, usersproduct WHERE product.id = usersproduct.product_id AND usersproduct.user_id = " . $user_id . " AND product.status = 'active'
		ORDER BY usersproduct.created_at DESC"));
		
		return response()->view('buyer.mobile.likes',
        ['product_likes'=>$product_likes,'user_id'=>$user_id]);
	}
	
	public function mobdocuments($user_id)
    {
        $buyer = User::where('id',$user_id)
                    ->first();

		$query = Receipt::join('porder', 'porder.id', '=', 'receipt.porder_id')
			->where('user_id' , $user_id)
			->select('porder.user_id','porder.created_at')
			->orderBy('porder.created_at','desc')
			->get();
			
		//dd($query);

        $actual_year = Receipt::join('porder', 'porder.id', '=', 'receipt.porder_id')
            ->where('user_id' , $user_id)
            ->select('porder.user_id','porder.created_at')
            ->orderBy('porder.created_at','desc')
            ->first();


		$years = Array();$months = Array();$y = Array();$index = 0;
		foreach($query as $que){
			$years[$que->created_at->year][$index] = $que->created_at->month;
			$index++;
		}
	//	dd($years);
		$today = Carbon::today();
        $current_year = 0;
        if(isset($actual_year)){
            $actual_year = $actual_year->created_at;
            if($actual_year->year != $today->year){
                $current_year = 0;
            }else{
                $current_year = 1;
            }
        }

        $buyer_address = Address::where( 'id',$buyer->default_address_id)
                ->first(array('line1','line2','line3','line4'));
				$mer = "Buyer ID";
				$id = $buyer->id;
				$s = $buyer_address;
				$name = $buyer->name;
				$company = "";
				$ireturn = 	$buyer;
		return response()->view('buyer.mobile.history',
        ['mer'=>$mer,'id'=>$id,'s'=>$s,'name'=>$name,'myreturn' => $query,'company'=>$company,'ireturn'=>$ireturn,'current_year'=>$current_year,'today'=>$today,'years'=>$years,'actual_year'=>$actual_year]);
	}
	
	public function mobdiscount($id)
    {
		$buyerDiscount=DB::table('discountbuyer')
        ->select('discount.*','discountbuyer.*','discount.created_at as created_atnew','discount.image as discount_image','discount.id as discount_id','product.name as product_name','buyer.*','discountbuyer.status as discstatus')
        ->Join('buyer', 'discountbuyer.buyer_id', '=', 'buyer.user_id')
        ->Join('discount', 'discountbuyer.discount_id', '=', 'discount.id')
        ->Join('product', 'discount.product_id', '=', 'product.id')
        ->where('discountbuyer.buyer_id', $id)
        ->where('discountbuyer.status', '!=','expired')
        ->where('product.available', '>',0)
        ->whereNull('discountbuyer.deleted_at')
		->orderBy('discstatus', 'ASC')
		->orderBy('created_atnew', 'DESC')
        ->get();
		
		return response()->view('buyer.mobile.discount',
        ['buyerDiscount'=>$buyerDiscount,]);
	}
	
	public function mobhyper($user_id)
    {
        try {
            $hypers = Product::leftJoin('owarehouse as o','product.id','=','o.product_id')
            ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id')
							 ->where('op.status','=','executed');
                         })
            ->where('op.user_id',$user_id)
            ->where('product.oshop_selected','1')
            ->where('product.available','>','0')
            ->where('o.status','=','active')
            ->select(DB::raw('product.*,product.parent_id as product_id,o.id as owarehouse_id,o.collection_price,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
            ->groupBy('product.id')
            ->get();
        } catch (\Exception $e) {
            // return $e;
            $hypers=array();  //Fallback ! Just in case something happens
           }
		
		return response()->view('buyer.mobile.hyper',
        ['ow_product'=>$hypers]);
	}	
	
    public function buyerInformation($id = null)
    {
        //Early returns
        if (!Auth::check()){
             return view('common.generic')
            ->with('message_type','error')
            ->with('message','Please login to access the page')
            ->with('redirect_to_login',1);
        }
		
        $buyer_img = false;
        try {
            if($id == null){
				$u = Auth::user();
				$user_id = $u->id;
				$userjust_id = $u->id;
				$u_id = $u->id;
			} else {
				$user_id = $id;
				$userjust_id = $id;
				$u_id = $id;
			}
        } catch (\Exception $e) {
			\Session::flash(Config::get('messages.key.name'), $this->messageHandler->error('sessionError', null, null,null, true, true, true));
            return redirect()->back();
        }
        $b= new BuyerController();
        $url = url('/');
		// Could be null resultset
        $buyer = Buyer::where('user_id' , $user_id)->first();
		//dd($buyer);
		$imagenum = array();
        if (!is_null($buyer)) {
            # code...
        $buyerinfo = Buyer::where('user_id', $user_id)->first();
		
        $o= new OpenWishController();
        $openwish = $o->get_openwish($user_id);
        try {
            for($i=0;$i<7;$i++) {
                $photo='photo_'.($i+1);
                $buyer_image = $buyer->$photo;
                $imagenum[$i]=0;
                if ($buyer_image == "") {
                    $image[$i] = "";
                    $imagenum[$i]=1;
                } else {
                    $image[$i] = "images/users/" . $user_id . "/" . $buyer_image;
                    $imagenum[$i]=0;
                }
            }
            $buyer_img = true;
        } catch (\Exception $e) {
            echo "<script> console.log('Exception:Image not found'); </script>";
            $image = "images/placecards/dummy.jpg";
        }
        }

        else{
			return redirect()->back();
        }
        $smmProducts = SMMout::smmOuts($user_id);
        try {
            // $smmOutuser=SMMout::where('user_id',$user_id)->get();
            $tempsmmOutuser=SMMout::where('user_id',$user_id);
            $smmOutuser=$tempsmmOutuser->get();
            $mostrecentSmmOut=$tempsmmOutuser->orderBy('created_at', 'desc')->first();
            $connections= $mostrecentSmmOut->connections;
            // return $connections;
        } catch (\Exception $e) {
            // return $e;
            $smmOutuser=array();
            $connections=0;

        }
        $smmIn=array();
        $shares= 0;
        $smmInsales=0;
        $smmIncomm=0;
        $smmIncommthisYear=0;
        $todays_date= Carbon::now();
        $clicked=0;

        $userID = Auth::id();
        $shares= SMMout::where('user_id', $userID)->sum('shares');
        $clicked= count(

            SMMin::join('smmout','smmin.smmout_id','=','smmout.id')
            ->where('smmout.user_id','=',$user_id)
            ->get()
            );
        $earned_since = DB::select(DB::raw("SELECT SUM(ss.commission) as pes FROM  sales_staff ss WHERE  ss.user_id = $userID and ss.type = 'smm'  and ss.created_at BETWEEN ss.created_at AND CURDATE() GROUP BY ss.id"));
       
        $unpaid = DB::select(DB::raw("SELECT SUM(ss.commission) as pes FROM sales_staff ss, porder po, smmin si WHERE ss.user_id = $userID and ss.type = 'smm'   and si.porder_id = po.id and si.comm_claimed = 0 GROUP BY ss.id "));
        

        $ytd = DB::select(DB::raw("SELECT SUM(ss.commission) as eytd FROM sales_staff ss WHERE  ss.user_id = $userID and ss.type = 'smm'  and ss.created_at BETWEEN CONCAT(extract(year FROM CURDATE()), '-01', '-01') AND CURDATE() GROUP BY ss.id"));
       
        $smmEarnedSince = is_array($earned_since) ? $earned_since : null;
        $smmYearToDate = is_array($ytd) ? $ytd : null;
        $smmPending = is_array($unpaid) ? $unpaid : null;

        // return $smmIn;

        $dateObj = new Date();
        $userObj = new User();
        // $userModel = $userObj->with('merchant', 'occupation', 'merchant.address', 'merchant.city')->where('id', '=', $u->id)->get()->first();
        // $userModel->age = 12;//$dateObj->age(new DateTime($u->birthdate),null,true);
        // return $user_id;

        $user = User::where('id', $user_id)->first(); //?Why this returns a list

        $buyerDiscount=DB::table('discountbuyer')
        ->select('discount.*','discountbuyer.*','discount.created_at as created_atnew','discount.image as discount_image','discount.id as discount_id','product.name as product_name','buyer.*','discountbuyer.status as discstatus')
        ->Join('buyer', 'discountbuyer.buyer_id', '=', 'buyer.user_id')
        ->Join('discount', 'discountbuyer.discount_id', '=', 'discount.id')
        ->Join('product', 'discount.product_id', '=', 'product.id')
        ->where('discountbuyer.buyer_id', $user_id)
        ->where('discountbuyer.status', '!=','expired')
        ->where('product.available', '>',0)
        ->whereNull('discountbuyer.deleted_at')
		->orderBy('discstatus', 'ASC')
		->orderBy('created_atnew', 'DESC')
        ->get();
		//dd($buyerDiscount);
		
		 $buyerVoucher=DB::table('product')
        ->select('product.*','orderproduct.quantity','orderproduct.order_price')
        ->join('orderproduct', 'product.id', '=', 'orderproduct.product_id')
        ->join('porder', 'orderproduct.porder_id', '=', 'porder.id')
        ->where('porder.user_id', $user_id)
        ->where('product.type', 'voucher')
        ->get();

        if ($user->first_name == null and $user->last_name == null) {
            $name = $user->name;
        } elseif ($user->first_name != null and $user->last_name != null) {
            $name = $user->first_name . " " . $user->last_name;
        } elseif ($user->last_name == null and $user->name == null) {
            $name = $user->first_name;
        } elseif ($user->name != null and $user->first_name != null) {
            $name = $user->name;
        } elseif ($user->first_name == null and $user->name == null) {
            $name = $user->last_name;
        } elseif ($user->first_name == null and $user->name != null) {
            $name = $user->name;
        } elseif ($user->name == null and $user->first_name == null and $user->last_name == null) {
            $name = "John Doe";
        } else {
            $name = "Jane Doe";
		}

        $member_since = $user->created_at->format('dMy H:i');

        try {
            $time= $user->birthdate;
            if ($time!="30/11/-0001") {
            $time=str_replace("/","-",$time);
            $date=date_create($time);
            $now = \Carbon::now();
            // return $now;
            $age = $date->diff($now)->y;
            }
            else {
                $age="";
            }


        } catch (\Exception $e) {

            $age = "";
            echo "<script>console.log('Invalid Birthdate or Birthdate is string in users table');</script>";
        }

        try {
            $occupation = Occupation::where('id', $user->occupation_id)->first()->name;
        } catch (\Exception $e) {
            $occupation = "---";
            echo "<script>console.log('Occupation id not found');</script>";
        }

        // $occupation=Occupation::where('id',$user->occupation_id)->get()[0]->name;//production version
        // $occupation=Occupation::where('id','2')->get()[0]->name; //test version
        // $language= Language::where('id',$user->language_id)->get()->description;//production_version

        $language = Language::select('language.*')
                ->join('userlanguage','language.id','=','userlanguage.language_id')
                ->where('userlanguage.user_id',$user_id)
                ->get();

        $bi = BuyerCategory::where('user_id', $user_id)->get(); //returns an array.for buyer interests
        $t = "subcat_level_"; //temp variable
        $interests = "";

        // $bi= (array)$bi;
        try {
            $filter = $bi->subcat_level;
            if (!empty($bi)) {
                foreach ($bi as $b) {
                    if ($b->subcat_level_ == '0') {
                        $interest = DB::table('category')->where('id', $b->subcat_id)->pluck('description');
                        $interests = $interests . " " . $interest;
                    } elseif ($b->subcat_level_ == "?") {

                    } else {
                        $table = $t . $b->subcat_level;
                        $interest = DB::table($table)->where('id', $b->subcat_id)->pluck('description');
                        $interests = $interests . " " . $interest;
                    }
                }
            } else {
                $interests = "No interest specified";
            }

        } catch (\Exception $e) {
            $interests = "No interest specified";
        }

        // return $interests;
        try {
            $billing_address = Address::where(['id' => $user->billing_address_id])->get()[0];//ba
        } catch (\Exception $e) {
            echo "<script>console.log('No Billing Address Found');</script>";
            $billing_address = "";
        }

        try {
            $default_address = Address::where(['id' => $user->default_address_id])->get()[0]; //da
        } catch (\Exception $e) {
            echo "<script>console.log('No Default Address Found');</script>";
            $default_address = "";
        }
        //Buyer
        try {
            $buyer = Buyer::where('user_id', $user_id);
        } catch (\Exception $e) {
            echo "<script>console.log('No Buyer Detail Found');</script>";
        }

        // AUTOLINK

       $a_links= $this->get_autolink($user_id);
       // return $a_links;
       $porders = DB::table('porder')->where('user_id', $user_id)->get();
        //Shipping

       $couriers=$this->get_shipping($porders,false);
        // return $porders;
        // Product
        $products= $this->products($porders);

        // AUTOLINKS
        // $autolinks= null;
        // try {

        // } catch (\Exception $e) {

        // }
        // return $products;
        // return $couriers;
        // return response()->view('buyerinformation');

		$porders = DB::table('porder')->where('user_id', $user_id)->orderBy('created_at','DESC')->get();
		$product_orders= $b->products($porders,true);
        // dd($product_orders);
        $orders= array();
       foreach ($product_orders as $po) {
            # code...
            $ex=DB::table('porder')->where('id',$po['oid'])->first();
            $total= DB::table('payment')->where('id',$ex->payment_id)->pluck('receivable');
            $total=DB::table('orderproduct')->where('porder_id',$ex->id)->select(DB::raw("
                    SUM((orderproduct.order_price*orderproduct.quantity)+orderproduct.order_delivery_price) as total
                "))->first();
        
           $po['total']=$total->total;
            $po['status']=$ex->status;
            $po['o_receipt']=$ex->created_at;

            $po['segment']=UtilityController::getPorderSegment($ex->id);
			$date = $ex->created_at;
			$date1 = new DateTime(date('Y-m-d H:i:s'));
			$date2 = new DateTime(date('Y-m-d H:i:s', strtotime($date)));
			$diff = $date1->diff($date2);
			$hours = $diff->h;
			$days = $diff->days;
			$totaldiff = ($diff->days * 24) + $diff->h + ($diff->i / 60) + ($diff->s / 3600);
			//dd($date);
            $totaldiff=UtilityController::cancelTime($date);
			//dd($totaldiff);
			$po['hours']=$hours;
			$po['days']=$days;
			$po['totaldiff']=$totaldiff;
            $po['delivery_timestamp']=DB::table('delivery')->where('porder_id',$ex->id)->where('type','m2b')->orderBy('updated_at','DESC')->pluck('delivered_date');
            // $po['delivery_timestamp']=$ex->updated_at;

            array_push($orders, $po);
        }
        // return $orders;
//		$shipping = POrder::select('porder.*','courier.shipping_id','merchant.id as merchant_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable')
		$shipping = POrder::select('porder.*','courier.shipping_id','merchant.id as merchant_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable')
			->leftJoin('courier','porder.courier_id','=','courier.id')
			->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('omerchantproduct as merchantproduct', function($join) {
                 $join->on('orderproduct.product_id', '=', 'merchantproduct.product_id')
                 ->where('orderproduct.created_at','>=','merchantproduct.created_at')
                 ->orWhere(function ($query) {
						$query->whereNull('merchantproduct.deleted_at')
							  ->where('merchantproduct.deleted_at', '>', 'orderproduct.created_at');
					});
             })
			->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->join('product','product.id','=','orderproduct.product_id')
            ->where('porder.user_id',$user_id)
            ->get();
        $currency = Currency::where('active' , 1)->first();

        $buyer = User::where('id',$user_id)
                    ->first();

		$query = Receipt::join('porder', 'porder.id', '=', 'receipt.porder_id')
			->where('user_id' , $user_id)
			->select('porder.user_id','porder.created_at')
			->orderBy('porder.created_at','desc')
			->get();
			
		//dd($query);

        $actual_year = Receipt::join('porder', 'porder.id', '=', 'receipt.porder_id')
            ->where('user_id' , $user_id)
            ->select('porder.user_id','porder.created_at')
            ->orderBy('porder.created_at','desc')
            ->first();


		$years = Array();$months = Array();$y = Array();$index = 0;
		foreach($query as $que){
			$years[$que->created_at->year][$index] = $que->created_at->month;
			$index++;
		}
	//	dd($years);
		$today = Carbon::today();
        $current_year = 0;
        if(isset($actual_year)){
            $actual_year = $actual_year->created_at;
            if($actual_year->year != $today->year){
                $current_year = 0;
            }else{
                $current_year = 1;
            }
        }

        $buyer_address = Address::where( 'id',$buyer->default_address_id)
                ->first(array('line1','line2','line3','line4'));
		$mer = "Buyer ID";
		$id = $buyer->id;
		$s = $buyer_address;
		$name = $buyer->name;
		$company = "";
		$ireturn = 	$buyer;

		/************ 	PERFORMANCE ***************/
		$global = DB::table('global')->first();
		/*** LINK ***/
		$mcmp = DB::select(DB::raw("SELECT merchants.id as merchant_id, buyer1.id as buyer1_id, buyer2.id as buyer2_id, buyer1.user_id as buyer1_uid, buyer2.user_id as buyer2_uid 
		FROM merchant as merchants
		JOIN sales_staff as staffmc ON merchants.mc_sales_staff_id = staffmc.id AND staffmc.user_id = " . $userjust_id . " AND staffmc.type = 'mct'
		JOIN sales_staff as staff ON staff.id = mcp1_sales_staff_id 
		LEFT JOIN sales_staff as staff2 ON staff2.id = merchants.mcp2_sales_staff_id 
		JOIN users as user1 ON staff.user_id = user1.id 
		LEFT JOIN users as user2 ON staff2.user_id = user2.id 
		JOIN buyer as buyer1 ON user1.id = buyer1.user_id
		LEFT JOIN buyer as buyer2 ON user2.id = buyer2.user_id"));

		$ismc = DB::select(DB::raw("SELECT staff.id FROM sales_staff as staff WHERE staff.user_id = " . $userjust_id . " AND staff.type = 'mct'"));
		$ismc = count($ismc);
		$ismp = DB::select(DB::raw("SELECT staff.id FROM sales_staff as staff WHERE staff.user_id = " . $userjust_id . " AND staff.type = 'mcp'"));
		$ismp = count($ismp);
		$ispsh = DB::select(DB::raw("SELECT staff.id FROM sales_staff as staff WHERE staff.user_id = " . $userjust_id . " AND staff.type = 'psh'"));
		$ispsh = count($ispsh);	

		$issmm = DB::select(DB::raw("SELECT staff.id FROM sales_staff as staff WHERE staff.user_id = " . $userjust_id . " AND staff.type = 'smm'"));
		$issmm = count($issmm);

		$isstr = DB::select(DB::raw("SELECT staff.id FROM sales_staff as staff WHERE staff.user_id = " . $userjust_id . " AND staff.type = 'str'"));
		$isstr = count($isstr);	
			
		/*** PERFORMANCE ***/
		$arrperformace = array();
		$arrperformace['totali'] = $ismp + $isstr + $issmm + $ispsh + $ismc;
		$performancemc = DB::select(DB::raw("SELECT (IF(sales_staff.commission>0,(sales_staff.commission/100)*SUM(payment.receivable),IF(merchant.mc_sales_staff_commission > 0,(merchant.mc_sales_staff_commission/100)*SUM(payment.receivable),(".$global->mc_sales_staff_commission."/100)*SUM(payment.receivable)))) as YTD, sales_staff.target_revenue as target_revenue, (SUM(payment.receivable)) as sales FROM payment, porder, orderproduct, omerchantproduct, sales_staff, merchant WHERE payment.id = porder.payment_id AND porder.id = orderproduct.porder_id AND orderproduct.product_id = omerchantproduct.product_id AND (orderproduct.created_at >= omerchantproduct.created_at AND (omerchantproduct.deleted_at IS NULL OR omerchantproduct.deleted_at > orderproduct.created_at)) AND merchant.id = omerchantproduct.merchant_id AND sales_staff.id = merchant.mc_sales_staff_id AND sales_staff.type = 'mct' AND porder.created_at >= '" . date("Y") . "-01-01' AND sales_staff.user_id = " . $userjust_id));
		$arrperformace['total'] = 0;
		$arrperformace['totals'] = 0;
		$arrperformace['totalr'] = 0;

		$arrperformace['mc'] = 0;
		$arrperformace['mcs'] = 0;
		$arrperformace['mcr'] = 0;
		$arrperformace['mci'] = $ismc;
        $mc_sales=0;
        $comm=0;
        if ($ismc>0) {
            $mc_sales_staff=SalesStaff::where('user_id',$userjust_id)->where('type','mct')->first();
            $merchant_ids_mc=Merchant::where('mc_sales_staff_id',$mc_sales_staff->id)->get();

            foreach ($merchant_ids_mc as $mer) {
                $s= UtilityController::merchantSale($mer->id);
                $mc_sales+=$s;
                if ($mer->referral_sales_staff_id==0 or is_null($mer->referral_sales_staff_id)) {
                    $comm+=($global->mc_sales_staff_commission*$s)/100;
                }else{
                     $comm+=($global->mc_sales_staff_commission*$s*$global->mc_with_ref_sale_staff_commission)/100;
                }

               
            }
            $arrperformace['mcs']=$mc_sales;
            $arrperformace['mc']=$comm;
            $arrperformace['mcr'] = $mc_sales_staff->target_revenue;

        }
		// if(isset($performancemc)){
		// 	if(!is_null($performancemc[0]->YTD)){
		// 		$arrperformace['mc'] = $performancemc[0]->YTD;
		// 	}
		// 	if(!is_null($performancemc[0]->sales)){
		// 		$arrperformace['mcs'] = $performancemc[0]->sales;
		// 	}
		// 	if(!is_null($performancemc[0]->target_revenue)){
		// 		$arrperformace['mcr'] = $performancemc[0]->target_revenue;
		// 	}
		// }

		$arrperformace['total'] += $arrperformace['mc'];
		$arrperformace['totals'] += $arrperformace['mcs'];
		$arrperformace['totalr'] += $arrperformace['mcr'];

		$performanceref = DB::select(DB::raw("SELECT (IF(sales_staff.commission>0,(sales_staff.commission/100)*SUM(payment.receivable),IF(merchant.referral_sales_staff_commission > 0,(merchant.referral_sales_staff_commission/100)*SUM(payment.receivable),(".$global->referral_sales_staff_commission."/100)*SUM(payment.receivable)))) as YTD, sales_staff.target_revenue as target_revenue, (SUM(payment.receivable)) as sales FROM payment, porder, orderproduct, omerchantproduct, sales_staff, merchant WHERE payment.id = porder.payment_id AND porder.id = orderproduct.porder_id AND orderproduct.product_id = omerchantproduct.product_id AND (orderproduct.created_at >= omerchantproduct.created_at AND (omerchantproduct.deleted_at IS NULL OR omerchantproduct.deleted_at > orderproduct.created_at)) AND merchant.id = omerchantproduct.merchant_id AND sales_staff.id = merchant.referral_sales_staff_id AND sales_staff.type = 'mct' AND porder.created_at >= '" . date("Y") . "-01-01' AND sales_staff.user_id = " . $userjust_id));

		$arrperformace['ref'] = 0;
		$arrperformace['refs'] = 0;
		$arrperformace['refr'] = 0;
		$arrperformace['refi'] = $ismc;
        // Referral
         $ref_mer_sale=0;

        if ($ismc>0) {
            $ref_merchants= Merchant::where('referral_sales_staff_id',$mc_sales_staff->id)->lists('id')->all();

            // Get Sales
               foreach ($ref_merchants as $mer) {
                $s=UtilityController::merchantSale($mer);
                $ref_mer_sale+=$s;
            }

            $arrperformace['refs']=$ref_mer_sale;
            $arrperformace['ref']=($global->osmall_commission*$ref_mer_sale*$global->referral_sales_staff_commission)/100;
            $arrperformace['refr']=$mc_sales_staff->target_revenue;


        }

		// if(isset($performanceref)){
		// 	if(!is_null($performanceref[0]->YTD)){
		// 		$arrperformace['ref'] = $performanceref[0]->YTD;
		// 	}
		// 	if(!is_null($performanceref[0]->sales)){
		// 		$arrperformace['refs'] = $performanceref[0]->sales;
		// 	}
		// 	if(!is_null($performanceref[0]->target_revenue)){
		// 		$arrperformace['refr'] = $performanceref[0]->target_revenue;
		// 	}
		// }

		$arrperformace['total'] += $arrperformace['ref'];
		$arrperformace['totals'] += $arrperformace['refs'];
		$arrperformace['totalr'] += $arrperformace['refr'];

		// $performancemp1 = DB::select(DB::raw("SELECT (IF(sales_staff.commission>0,(sales_staff.commission/100)*SUM(payment.receivable),IF(merchant.mcp1_sales_staff_commission > 0,(merchant.mcp1_sales_staff_commission/100)*SUM(payment.receivable),(".$global->mcp1_sales_staff_commission."/100)*SUM(payment.receivable)))) as YTD, sales_staff.target_revenue as target_revenue, (SUM(payment.receivable)) as sales FROM payment, porder, orderproduct, merchantproduct, sales_staff, merchant WHERE payment.id = porder.payment_id AND porder.id = orderproduct.porder_id AND orderproduct.product_id = merchantproduct.product_id AND merchant.id = merchantproduct.merchant_id AND sales_staff.id = merchant.mcp1_sales_staff_id AND sales_staff.type = 'mcp' AND porder.created_at >= '" . date("Y") . "-01-01' AND sales_staff.user_id = " . $userjust_id));
		// $performancemp2 = DB::select(DB::raw("SELECT (IF(sales_staff.commission>0,(sales_staff.commission/100)*SUM(payment.receivable),IF(merchant.mcp2_sales_staff_commission > 0,(merchant.mcp2_sales_staff_commission/100)*SUM(payment.receivable),(".$global->mcp2_sales_staff_commission."/100)*SUM(payment.receivable)))) as YTD, sales_staff.target_revenue as target_revenue, (SUM(payment.receivable)) as sales FROM payment, porder, orderproduct, merchantproduct, sales_staff, merchant WHERE payment.id = porder.payment_id AND porder.id = orderproduct.porder_id AND orderproduct.product_id = merchantproduct.product_id AND merchant.id = merchantproduct.merchant_id AND sales_staff.id = merchant.mcp2_sales_staff_id AND sales_staff.type = 'mcp' AND porder.created_at >= '" . date("Y") . "-01-01' AND sales_staff.user_id = " . $userjust_id));

		$arrperformace['mp'] = 0;
		$arrperformace['mps'] = 0;
		$arrperformace['mpr'] = 0;
		$arrperformace['mpi'] = $ismp;
        $sales=0;
        $mp_commission=0;
        if ($ismp>0) {
            $mp_sales_staff=SalesStaff::where('user_id',$userjust_id)->where('type','mcp')->first();

            $mp_mers=Merchant::where('mcp1_sales_staff_id',$mp_sales_staff->id)->orWhere('mcp2_sales_staff_id',$mp_sales_staff->id)->get();

            foreach ($mp_mers as $mp) {

                $s= UtilityController::merchantSale($mp->id);
                $sales+=$s;
                $comm=0;
                if ($mp->mcp1_sales_staff_id==$mp_sales_staff->id) {
                    $comm= $global->mcp1_sales_staff_commission;
                }
                else{
                    $comm= $global->mcp1_sales_staff_commission;
                }
                $mp_commission+=($global->osmall_commission*$s*$comm)/100;
            }
        
            $arrperformace['mp'] = $mp_commission;
            $arrperformace['mps'] = $sales;
            $arrperformace['mpr'] = $mp_sales_staff->target_revenue;

        }

		// if(isset($performancemp1)){
		// 	if(!is_null($performancemp1[0]->YTD)){
		// 		$arrperformace['mp'] = $performancemp1[0]->YTD;
		// 	}
		// 	if(!is_null($performancemp1[0]->sales)){
		// 		$arrperformace['mps'] = $performancemp1[0]->sales;
		// 	}
		// 	if(!is_null($performancemp1[0]->target_revenue)){
		// 		$arrperformace['mpr'] = $performancemp1[0]->target_revenue;
		// 	}
		// }

		// if(isset($performancemp2)){
		// 	if(!is_null($performancemp2[0]->YTD)){
		// 		$arrperformace['mp'] += $performancemp2[0]->YTD;
		// 	}
		// 	if(!is_null($performancemp2[0]->sales)){
		// 		$arrperformace['mps'] += $performancemp2[0]->sales;
		// 	}
		// 	if(!is_null($performancemp2[0]->target_revenue)){
		// 		$arrperformace['mpr'] += $performancemp2[0]->target_revenue;
		// 	}
		// }

		$arrperformace['total'] += $arrperformace['mp'];
		$arrperformace['totals'] += $arrperformace['mps'];
		$arrperformace['totalr'] += $arrperformace['mpr'];
		

		$performancepsh = DB::select(DB::raw("SELECT (IF(sales_staff.commission>0,(sales_staff.commission/100)*SUM(payment.receivable),IF(merchant.psh_sales_staff_commission > 0,(merchant.psh_sales_staff_commission/100)*SUM(payment.receivable),(".$global->psh_sales_staff_commission."/100)*SUM(payment.receivable)))) as YTD, sales_staff.target_revenue as target_revenue, (SUM(payment.receivable)) as sales FROM payment, porder, orderproduct, merchantproduct, sales_staff, merchant WHERE payment.id = porder.payment_id AND porder.id = orderproduct.porder_id AND orderproduct.product_id = merchantproduct.product_id AND merchant.id = merchantproduct.merchant_id AND sales_staff.id = merchant.psh_sales_staff_id AND sales_staff.type = 'psh' AND porder.created_at >= '" . date("Y") . "-01-01' AND sales_staff.user_id = " . $userjust_id));


		$arrperformace['psh'] = 0;
		$arrperformace['pshs'] = 0;
		$arrperformace['pshr'] = 0;
		$arrperformace['pshi'] = $ispsh;
		if(isset($performancepsh)){
			if(!is_null($performancepsh[0]->YTD)){
				$arrperformace['psh'] = $performancepsh[0]->YTD;
			}
			if(!is_null($performancepsh[0]->sales)){
				$arrperformace['pshs'] = $performancepsh[0]->sales;
			}
			if(!is_null($performancepsh[0]->target_revenue)){
				$arrperformace['pshr'] = $performancepsh[0]->target_revenue;
			}
		}

		$arrperformace['total'] += $arrperformace['psh'];
		$arrperformace['totals'] += $arrperformace['pshs'];
		$arrperformace['totalr'] += $arrperformace['pshr'];

		$performancestr = DB::select(DB::raw("SELECT (IF(sales_staff.commission>0,(sales_staff.commission/100)*SUM(payment.receivable),IF(station.str_sales_staff_commission > 0,(station.str_sales_staff_commission/100)*SUM(payment.receivable),(".$global->str_sales_staff_commission."/100)*SUM(payment.receivable)))) as YTD, sales_staff.target_revenue as target_revenue, (SUM(payment.receivable)) as sales FROM payment, porder, orderproduct, sproduct, sales_staff, station, stationsproduct WHERE payment.id = porder.payment_id AND porder.id = orderproduct.porder_id AND orderproduct.product_id = sproduct.product_id AND sproduct.id = stationsproduct.sproduct_id AND stationsproduct.station_id = station.id AND sales_staff.id = station.str_sales_staff_id AND sales_staff.type = 'str' AND porder.created_at >= '" . date("Y") . "-01-01' AND sales_staff.user_id = " . $userjust_id));

		$arrperformace['str'] = 0;
		$arrperformace['strs'] = 0;
		$arrperformace['strr'] = 0;
		$arrperformace['stri'] = $isstr;

		// if(isset($performancestr)){
		// 	if(!is_null($performancestr[0]->YTD)){
		// 		$arrperformace['str'] = $performancestr[0]->YTD;
		// 	}
		// 	if(!is_null($performancestr[0]->sales)){
		// 		$arrperformace['strs'] = $performancestr[0]->sales;
		// 	}
		// 	if(!is_null($performancestr[0]->target_revenue)){
		// 		$arrperformace['strr'] = $performancestr[0]->target_revenue;
		// 	}
		// }

		$arrperformace['total'] += $arrperformace['str'];
		$arrperformace['totals'] += $arrperformace['strs'];
		$arrperformace['totalr'] += $arrperformace['strr'];

		$performancesmm = DB::select(
                DB::raw(
                    "SELECT (IF(sales_staff.commission>0,(sales_staff.commission/100)*SUM(payment.receivable),(".$global->smm_sales_staff_commission."/100)*SUM(payment.receivable))) as YTD, sales_staff.target_revenue as target_revenue, (SUM(payment.receivable)) as sales FROM payment, porder, orderproduct, smmin, smmout, sales_staff WHERE payment.id = porder.payment_id AND porder.id = orderproduct.porder_id AND porder.id = smmin.porder_id AND smmin.smmout_id = smmout.id AND sales_staff.id = smmout.user_id AND sales_staff.type = 'smm'AND smmin.response = 'buy' AND porder.created_at >= '" . date("Y") . "-01-01' AND sales_staff.user_id = " . $userjust_id));
        // Need to break query

        // zxcv
		$arrperformace['smm'] = 0;
		$arrperformace['smms'] = 0;
		$arrperformace['smmr'] = 0;
		$arrperformace['smmi'] = $issmm;  //Init for commission
        $arrperformace['smmytd']=0;
        $arrperformace['smm_shared']=count(SMMout::where('user_id',$userjust_id)->get());
        if(isset($performancesmm)){
			 
                try {
                    $arrperformace['smm']=SalesStaff::where('user_id',$userjust_id)
        ->where('type','smm')->select('commission')->first()->commission/100;
                } catch (\Exception $e) {
                    // sales staff record doesn't exist
                    $arrperformace['smm']=0;
                }
                
				// $arrperformace['smm'] = $performancesmm[0]->YTD;
			 
			     $sales_half_query=    SMMin::join('porder','porder.id','=','smmin.porder_id')
                ->join('orderproduct as op','porder.id','=','op.porder_id')
                ->join('smmout','smmin.smmout_id','=','smmout.id')
                ->where('smmout.user_id','=',$userjust_id)
                ->where('smmin.response','=','buy');
                $sales=
               
                $sales_half_query->select(
                    DB::raw(
                        "
                            SUM(op.order_price) as s
                        "
                        )
                    )
                ->first()->s;
                // >= concat(year(curdate()),'-01-01'
                $ytdsale=$sales_half_query->where(
                    DB::raw(
                        "
                        op.created_at >= concat(year(curdate()),'-01-01')
                        ")
                    )->select(
                    DB::raw(
                        "
                            SUM(op.order_price) as s
                        "
                        )
                    )
                ->first()->s;
				$arrperformace['smms'] = $sales;
                $ytd_ow_commission=($ytdsale*$global->osmall_commission)/100;
                $ytd_smm_commission=($global->smm_commission*$ytd_ow_commission)/100;
			     $arrperformace['ytdsale']=$ytd_smm_commission/100;
                
			if(!is_null($performancesmm[0]->target_revenue)){
				$arrperformace['smmr'] = $performancesmm[0]->target_revenue;
			}
		}

		$arrperformace['total'] += $arrperformace['smm'];
		$arrperformace['totals'] += $arrperformace['smms'];
		$arrperformace['totalr'] += $arrperformace['smmr'];

		$employee = DB::table('employee')->where('user_id',$userjust_id)->first();
		$payslip = array();
		if(!is_null($employee)){
			$payslip = $this->calculate_payslip($employee,$userjust_id);
		}
		$buyer_vouchers=App\Models\VoucherBuyer::where('buyer_id',$user->id)->get();
        $voucher_data=[];
        foreach ($buyer_vouchers as $single_voucher_id) {
        $vouchers= App\Models\Voucher::where('id',$single_voucher_id->voucher_id)->get();

            foreach ($vouchers as $i) {
                $temp['voucher']=$i;
                //$temp['voucher_timeslot']=$i->timeSlots;
                $temp['voucher_product']=$i->product;
                $temp['voucher_timeslot']=DB::table('timeslot')->select('*')->where('voucher_id',$i->id)->first();;
                $temp['voucher_address']=$i->address;
                $voucher_data[]=$temp;
            }
        }

		$product_likes = DB::select(DB::raw("SELECT product.*, DATE_FORMAT(usersproduct.created_at,'%d%b%y') as since, usersproduct.created_at 
		FROM product, usersproduct WHERE product.id = usersproduct.product_id AND usersproduct.user_id = " . $userjust_id . " AND product.status = 'active'
		ORDER BY usersproduct.created_at DESC"));

                // OCREDIT - WAHID
        /* For SMM we can leave it first, because we don't pull the record direct. */



        $smm_price = DB::select(DB::raw("select pr.name as pname, oc.value as price, DATE_FORMAT(si.created_at,'%d%b%y %h:%m') as cdate, oc.product_id as pid, oc.value as value from ocredit oc, porder po, product pr, smmin si, smmout so where pr.id = oc.product_id and oc.source = 'smm' and oc.porder_id = si.porder_id and si.response = 'buy' and si.smmout_id = so.id group by oc.id"));

        $openwish_price = DB::select(DB::raw("select pr.name as pname, oc.value as price, DATE_FORMAT(ow.created_at,'%d%b%y %h:%m') as cdate, oc.product_id as pid, oc.value as value from product pr, openwish ow, ocredit oc where oc.product_id = pr.id and oc.openwish_id = ow.id and oc.source = 'openwish' and ow.status = 'expired' group by oc.id"));
		
        $hprice = DB::select(DB::raw("select pr.name as pname, oc.value as price, owh.duration as duration, DATE_FORMAT(owh.created_at,'%d%b%y %h:%m') as cdate, oc.product_id as pid, oc.value as value from product pr, ocredit oc, owarehouse owh, owarehousepledge owhp, porder po where oc.product_id = pr.id and oc.source='hyper' and owhp.owarehouse_id = owh.id and owh.id = oc.owarehouse_id group by oc.id"));

        $hyper_price = array();

        foreach ($hprice as $key => $hp) {
            $duration = $hp->duration;
            $expiry_date = new \Carbon\Carbon($hp->cdate);
            $expiry_date = $expiry_date->addMinutes($duration);
            $curr_date = Carbon::now();

            if ($expiry_date < $curr_date) {
                $hyper_price[$key] = $hp;
            }
        }

        $cre_price = DB::select(DB::raw("select pr.name as pname, oc.value as price, DATE_FORMAT(c.created_at,'%d%b%y %h:%m') as cdate, oc.product_id as pid, oc.value as value  from cre c, ocredit oc, product pr where pr.id = oc.product_id and oc.source = 'cre' and oc.cre_id = c.id and c.status = 'success' group by oc.id"));

        $mcredit_price = DB::select(DB::raw("select p.receivable as price from payment p, ocredit oc, porder po where oc.source = 'cancellation' and oc.porder_id = po.id and po.payment_id = p.id"));

        $smm_total = count($smm_price);
        $openwish_total = count($openwish_price);
        $hyper_total = count($hyper_price);
        $cre_total = count($cre_price);
        $mcredit_total = count($mcredit_price);

        $source_total = [
            'smm' => isset($smm_total) ? $smm_total : null,
            'openwish' => isset($openwish_total) ? $openwish_total : null,
            'cre' => isset($cre_total) ? $cre_total : null,
            'hyper' => isset($hyper_total) ? $hyper_total : null,
            'mcredit' => isset($mcredit_total) ? $mcredit_total : null,
        ];

        $source_price = [
            'smm' => isset($smm_price) ? $smm_price : null,
            'openwish' => isset($openwish_price) ? $openwish_price : null,
            'cre' => isset($cre_price) ? $cre_price: null,
            'hyper' => isset($hyper_price) ? $hyper_price : null,
            'mcredit' => isset($mcredit_price) ? $mcredit_price : null,
        ];

        $source_total_array = is_array($source_total) && !empty($source_total) ? $source_total : null;
        $source_price_array = is_array($source_price) && !empty($source_price) ? $source_price : null;
        // OCREDITS
        $smm_ocredit=0;
        $openwish_ocredit=0;
        $cre_ocredit=0;
        $hyper_ocredit=0;
        $mcredit_ocredit=0;
        // $ocredits= DB::table('ocredit')->where('user_id')
        // Hyper
        try {
            $hypers = Product::leftJoin('owarehouse as o','product.id','=','o.product_id')
            ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id');
							
                         })
            ->where('op.user_id',$user_id)
            ->where('product.oshop_selected','1')
            ->where('product.available','>','0')
            ->whereIn('o.status',['active','executed'])
            ->select(DB::raw('product.*,product.parent_id as product_id,o.id as owarehouse_id,o.collection_price,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
            ->groupBy('product.id')
            ->get();
        } catch (\Exception $e) {
            
            $hypers=array();  //Fallback ! Just in case something happens
           }
        // dd($hypers);

		$portfolios = DB::select(DB::raw("SELECT DISTINCT(m.id) as merchant_id, m.company_name as merchant_name FROM merchant m, sales_staff ss WHERE (ss.type = 'str' OR ss.type = 'mct') AND ss.user_id = " . $userjust_id . " AND (m.mc_sales_staff_id =  ss.id OR m.referral_sales_staff_id = ss.id)"));		   
		   // Merge code below
        $merchants_c = 0;
        $staff_c = DB::table('sales_staff')->where('user_id',$userjust_id)->where('type','mct')->first(); 
        if(!is_null($staff_c)){
            $merchants_c = DB::table('merchant')->where('mc_sales_staff_id',$staff_c->id)->where('mcp1_sales_staff_id','0')->count(); 
        }   
		   
		$merchants_c = 0;
		$staff_c = DB::table('sales_staff')->where('user_id',$userjust_id)->where('type','mct')->first(); 
		if(!is_null($staff_c)){
			$merchants_c = DB::table('merchant')->where('mc_sales_staff_id',$staff_c->id)->where('mcp1_sales_staff_id','0')->count(); 
		}
        // Pre init
        $merchants=array();
		$staff = DB::table('sales_staff')->where('user_id',$userjust_id)->where('type','mct')->first();
		if(!is_null($staff)){
			$merchants = DB::table('merchant')->where('mc_sales_staff_id',$staff->id)->where('mcp1_sales_staff_id','0')->get();
			$ww= 0;			
		}

		$merchantsarr = null;
		foreach($merchants as $merchant1) {
			$merchantsarr[$ww]['name'] = IdController::nM($merchant1->id) . " - " . $merchant1->oshop_name;
			$merchantsarr[$ww]['id'] = $merchant1->id;
			$ww++;
		}		
		
		$buyersmp = DB::table('buyer')->select('users.id as id','users.first_name as first_name','users.last_name as last_name')->join('users','users.id','=','buyer.user_id')->get();
		$kk = 0;
		$buyersmprr = null;
		foreach($buyersmp as $buyermp) {
			$buyersmprr[$kk]['name'] = IdController::nB($buyermp->id) . " - " . $buyermp->first_name . " " . $buyermp->last_name;
			$buyersmprr[$kk]['id'] = $buyermp->id;
			$buyersmprr[$kk]['uid'] = $buyermp->id;
			$kk++;
		}		   
	   // return $openwish;
		//dd($image);
       // dd($u_id);
		$fairmerchant = DB::table('merchant')->join('company','merchant.user_id','=','company.owner_user_id')
						->join('member','member.company_id','=','company.id')
                        ->where('member.type','member')->where('member.user_id',$u_id)->select('merchant.*', 'company.id as cid')->get();
        ;


        $new_cre=UtilityController::ocredit();

        $buyer_social_url=NULL;
        $fb_id=DB::table('oauth_session')->where('user_id',$user_id)->pluck('client_id');
        if (!is_null($fb_id)) {
            $buyer_social_url="https://fb.com/".$fb_id;
        }
        
        $opencredit_log=OpenCreditController::get_ocredit($user_id);
        // dd($opencredit_log);
        $SMM_total=0;
        $SMM_log=array();
        $OpenWish_total=0;
        $OpenWish_log=array();
        $CRE_total=0;
        $CRE_log=array();
        $PURCHASE_total=0;
        $PURCHASE_log=array();
        $Hyper_total=0;
        $Hyper_log=array();
        /*formatter*/ 
        

        // foreach ($opencredit_log as $log) {
        //     $var=$log->source."_total";
        //     $arr=$log->source."_log";

        //     if ($log->mode=="credit") {    
        //         $$var+=$log->value;
        //     }else{
       

        //         $$var= $$var-$log->value;
        //     }
        //     array_push($$arr,$log);

        // }


        $oc_log=compact('SMM_total',
			'OpenWish_total',
			'CRE_total',
			'Hyper_total',
			'PURCHASE_total',
			'SMM_log',
			'OpenWish_log',
			'CRE_log',
			'PURCHASE_log',
			'Hyper_log'
		);

		/* If buyer is a member who has 'opu' or 'opm' roles,
		   check his status */

		/*
		$staff_status = DB::table('member')->
			where('member.user_id',$u_id)->
			join('role_users','role_users.user_id','=','member.user_id')->
			join('roles', function($join) {
				$join->on('roles.slug','=','opu')->
				     orOn('roles.slug','=','opm');
			})->select('member.status', 'role_users.company_id')->
			first();

		Log::debug('********staff_status **********');
		Log::debug($staff_status);
		*/

		    
        // dd($oc_log);

		return response()->view('newbuyerinformation', [
			'shipping'=>$shipping,
			'fairmerchant' => $fairmerchant,
			'buyer_social_url'=>$buyer_social_url,
			'portfolios' => $portfolios,
			'merchantsarr' => $merchantsarr,
			'buyersmprr' => $buyersmprr,
			'openwishes' => $openwish,
			'merchants_c' => $merchants_c,
			'orders'=>$orders,
			'currency' => $currency ,
			'buyerinfo' => $buyer,
			'buyerinformation' => $buyerinfo,
			'name' => $name,
			'user_id'=> $u_id,
			'userjust_id' =>$userjust_id,
			'image' => $image,
			'imagenum'=> $imagenum,
			'products' => $products,
			'couriers' => $couriers,
			'autolinks' => $a_links,
			'user' => $user,
			'smmProducts'=>$smmProducts,
			'occupation' => $occupation,
			'age' => $age,
			'view_count'=>$clicked,
			'connections'=>$connections,
			'member_since' => $member_since,
			'language' => $language,
			'interests' => $interests,
			'ba' => $billing_address,
			'da' => $default_address,
			'ireturn'=>$ireturn,
			'myreturn' => $query,
			'today' => $today,
			'current_year' => $current_year,
			'mer' => $mer,
			'id' => $id,
			'name' => $name,
			's'=>$s,
			'years'=>$years,
			'ismc'=>$ismc,
			'mcmp'=>$mcmp,
			'smmIncomm'=>$smmIncomm,
			'smmInsales'=>$smmInsales,
			'arrperformace'=>$arrperformace,
			'payslip' => $payslip,
			'shares'=>$shares,
			'product_likes'=>$product_likes,
			'buyerDiscount'=>$buyerDiscount,
			'buyerVoucher'=>$buyerVoucher,
			'voucher_data'=>$voucher_data,
			'source_total'=>$source_total_array,
			'source_price'=>$source_price_array,
			'ow_product'=>$hypers,
			'smmEarnedSince'=>$smmEarnedSince,
			'smmYearToDate'=>$smmYearToDate,
			'smmPending'=>$smmPending,
			'opencredit_log'=>$oc_log,
			'new_cre'=>$new_cre
		]);
	}


	public function calculate_payslip($employee,$userjust_id){
		$payslip['employeeid'] = $employee->id;
		$userbyid = DB::table('users')->where('id',$userjust_id)->first();
		if(!is_null($userbyid)){
			$payslip['username'] = $userbyid->first_name . " " . $userbyid->last_name;
			$payslip['ismal'] = $userbyid->nationality_country_id;
		}
		$paysliptable = DB::table('payslip')->where('employee_id',$employee->id)->first();
		if(!is_null($paysliptable)){
			$payslip['basic_pay'] = number_format($paysliptable->basic_pay/100,2);
			if(date('m') == date('m', strtotime('+1 week'))){
				$numbermonth = date('n') - 1;
			} else {
				$numbermonth = date('n');
			}
			$payslip['basic_pay_ytd'] = number_format(($paysliptable->basic_pay*$numbermonth)/100,2);
			$payslip['bonus'] = number_format($paysliptable->bonus/100,2);
			$ismal = true;
			if(isset($payslip['ismal'])){
				if($payslip['ismal'] != 2){
					$ismal = false;
				}
			}
			$payslip['gross'] = number_format(($paysliptable->bonus+$paysliptable->basic_pay)/100,2);
			$maximum_socso = 4000;
			if($paysliptable->basic_pay <= $maximum_socso){
				$maximum_socso = $paysliptable->basic_pay;
			}
			$maximum_epf = 20000;
			if($paysliptable->basic_pay <= $maximum_epf){
				$maximum_epf = $paysliptable->basic_pay;
			}			
			if($age < 60){
				$payslip['socso'] = number_format(($maximum_socso*0.005)/100,2);
				$payslip['esocso'] = number_format(($maximum_socso*0.0175)/100,2);
				$payslip['socso_ytd'] = number_format((($maximum_socso*$numbermonth)*0.005)/100,2);
				if($ismal){
					if($paysliptable->basic_pay/100 < 5000){
						$payslip['epf'] = number_format(($maximum_epf*0.11)/100,2);
						$payslip['epf_ytd'] = number_format((($maximum_epf*$numbermonth)*0.11)/100,2);
						$payslip['eepf'] = number_format(($maximum_epf*0.13)/100,2);
					} else {
						$payslip['epf'] = number_format(($maximum_epf*0.11)/100,2);
						$payslip['epf_ytd'] = number_format((($maximum_epf*$numbermonth)*0.11)/100,2);
						$payslip['eepf'] = number_format(($maximum_epf*0.12)/100,2);
					}
				} else {
					$payslip['epf'] = number_format(($maximum_epf*0.11)/100,2);
					$payslip['epf_ytd'] = number_format((($maximum_epf*$numbermonth)*0.11)/100,2);
					$payslip['eepf'] = number_format(5,2);
				}
			} else {
				$payslip['socso'] = number_format(0,2);
				$payslip['socso_ytd'] = number_format(0,2);
				$payslip['esocso'] = number_format(($maximum_socso*0.0125)/100,2);
				if($ismal){
					if($paysliptable->basic_pay/100 < 5000){
						$payslip['epf'] = number_format(($maximum_epf*0.055)/100,2);
						$payslip['epf_ytd'] = number_format((($maximum_epf*$numbermonth)*0.055)/100,2);
						$payslip['eepf'] = number_format(($maximum_epf*0.065)/100,2);
					} else {
						$payslip['epf'] = number_format(($maximum_epf*0.055)/100,2);
						$payslip['epf_ytd'] = number_format((($maximum_epf*$numbermonth)*0.055)/100,2);
						$payslip['eepf'] = number_format(($maximum_epf*0.06)/100,2);
					}
				} else {
					$payslip['epf'] = number_format(($maximum_epf*0.055)/100,2);
					$payslip['epf_ytd'] = number_format((($maximum_epf*$numbermonth)*0.055)/100,2);
					$payslip['eepf'] = number_format(5,2);
				}
			}
			if($ismal){
				$balance_month = 12 - $numbermonth;
				$pcb = DB::table('pcb')->where('employee_id',$employee_id)->first();
				$global_pcb = DB::table('pcb_global')->first();

				if(is_null($pcb)){
					$deductions = 0;
					$category = 1;
				} else {
					$disabled = $pcb->disabled * ($global_pcb->pcb_disabled/100);
					$spouse_noincome = $pcb->spouse_no_income * ($global_pcb->pcb_spouse_no_income/100);
					$spouse_disabled = $pcb->spouse_disabled * ($global_pcb->pcb_spouse_disabled/100);
					$child_underage = $pcb->child_underage * ($global_pcb->pcb_child_underage/100);
					$child_aboveage = $pcb->child_aboveage * ($global_pcb->pcb_child_aboveage/100);
					$deductions = $disabled + $spouse_noincome + $spouse_disabled + $child_underage + $child_aboveage;
				}
				$P = (($basic_ytd - $epf_ytd) + ($basic - $epf) + (($basic - $epf)*$balance_month)) - $deductions;
				$values_arr = get_pcb_mrcb($P);

				if($pcb->status == 'single' && $pcb->child_adopted == 0){
					$category = 1;
				} else if ($pcb->status == 'married' && $pcb->spouse_disabled > 0){
					$category = 2;
				} else {
					$category = 3;
				}

				$b = 0;
				if($category == 2){
					$b = $values_arr['cat_2_b'];
				} else {
					$b = $values_arr['cat_1_3_b'];
				}

				$pcb_arr['pcb_ytd'] = (($P - $values_arr['m'])*$values_arr['r']) + $b;
				$pcb_arr['pcb'] = ((($P - $values_arr['m'])*$values_arr['r']) + $b)/($balance_month+1);

			} else {
				$pcb_arr['pcb'] = $basic *0.28;
				$pcb_arr['pcb_ytd'] = $pcb_arr['pcb'] * $numbermonth;
			}
			$payslip['pcb'] = $pcb_arr['pcb'];
			$payslip['pcb_ytd'] = $pcb_arr['pcb_ytd'];
			$netin = $payslip['basic_pay'] - ($payslip['epf']+$payslip['socso']+$payslip['pcb']);
			$basicytd = str_replace(",","",$payslip['basic_pay_ytd']);
			//dd($basicytd);
			//exit;
			$netin_ytd = $basicytd  - ($payslip['epf_ytd']+$payslip['socso_ytd']+$payslip['pcb_ytd']);
			$payslip['net'] = number_format($netin,2);
			$payslip['net_ytd'] = number_format($netin_ytd,2);
		}
		return $payslip;
	}

	public function get_pcb_mrcb($P){
		$mrcb_arr['m'] = 0;
		$mrcb_arr['r'] = 0;
		$mrcb_arr['cat_1_3_b'] = 0;
		$mrcb_arr['cat_2_b'] = 0;
		$values = DB::table('pcb_table')->where('p_min','<=',($P*100))->where('p_max','>',$P)->first();
		if(is_null($values)){
			$values = DB::table('pcb_table')->where('p_min','<=',($P*100))->where('p_max','=','0')->first();
			if(is_null($values)){

			} else {
				$mrcb_arr['m'] = $values->m/100;
				$mrcb_arr['r'] = $values->r;
				$mrcb_arr['cat_1_3_b'] = $values->cat_1_3_b;
				$mrcb_arr['cat_2_b'] = $values->cat_2_b;
			}
		} else {
			$mrcb_arr['m'] = $values->m/100;
			$mrcb_arr['r'] = $values->r;
			$mrcb_arr['cat_1_3_b'] = $values->cat_1_3_b;
			$mrcb_arr['cat_2_b'] = $values->cat_2_b;
		}

		return $mrcb_arr;
	}

    public function buyerInformationFromPayment($id)
    {
        //Early returns
        if (!Auth::check()) return redirect()->back();
        // Infortmation to display
        //Interests
        //Language
        //Shipping
        //Occupation
        $buyer_img = false;
        try {

            $user_id = $id;
            $u_id = $id;

            if (strlen($u_id) < 6) {
                $n = 6 - strlen($u_id);
                for ($i = 0; $i < $n; $i++) {
                    $u_id = '0' . $u_id;
                }
                $u_id = "[" . $u_id . "]";
            } else {
                $u_id = "[" . $u_id . "]";
            }

        } catch (\Exception $e) {
            return "You are not logged in";
        }
        $buyer = Buyer::where('user_id', $user_id)->first();
        $buyerinfo = Buyer::where('user_id', $user_id)->first();
		
        try {
            $buyer_image = $buyer->photo_1;
            $image = "images/users/" . $user_id . "/" . $buyer_image;
            $buyer_img = true;
        } catch (\Exception $e) {
            echo "<script> console.log('Exception:Image not found'); </script>";
            $image = "images/placecards/dummy.jpg";
        }


        $smmProducts = SMMout::withPosts($user_id);

        $dateObj = new Date();
        $userObj = new User();
        // $userModel = $userObj->with('merchant', 'occupation', 'merchant.address', 'merchant.city')->where('id', '=', $u->id)->get()->first();
        // $userModel->age = 12;//$dateObj->age(new DateTime($u->birthdate),null,true);
        // return $user_id;
        $user = User::where('id', $user_id)->first(); //?Why this returns a list
        // return $user;
        if ($user->first_name == null and $user->last_name == null) {
            $name = $user->name;

        } elseif ($user->first_name != null and $user->last_name != null) {
            $name = $user->first_name . " " . $user->last_name;
        } elseif ($user->last_name == null and $user->name == null) {
            $name = $user->first_name;
        } elseif ($user->name != null and $user->first_name != null) {
            # code...
            $name = $user->name;
        } elseif ($user->first_name == null and $user->name == null) {
            # code...
            $name = $user->last_name;
        } elseif ($user->first_name == null and $user->name != null) {
            # code...
            $name = $user->name;
        } elseif ($user->name == null and $user->first_name == null and $user->last_name == null) {
            # code...
            $name = "John Doe"; //? Get the joke??
        }
        $member_since = $user->created_at->format('d/m/Y');
        $dob = $user->birthdate;

        try {
            $dob_f = new DateTime($dob);
            $today = new DateTime('today');

            $age = $dob_f->diff($today)->y;
        } catch (\Exception $e) {

            $age = "";
            echo "<script>console.log('Invalid Birthdate or Birthdate is string in users table');</script>";
        }

        try {
            $occupation = Occupation::where('id', $user->occupation_id)->first()->name;
        } catch (\Exception $e) {
            $occupation = "---";
            echo "<script>console.log('Occupation id not found');</script>";
        }

        // $occupation=Occupation::where('id',$user->occupation_id)->get()[0]->name;//production version
        // $occupation=Occupation::where('id','2')->get()[0]->name; //test version
        // $language= Language::where('id',$user->language_id)->get()->description;//production_version
        $language = Language::where('id', '1')->get()[0]->description;
        $bi = BuyerCategory::where('user_id', $user_id)->get(); //returns an array.for buyer interests
        $t = "subcat_level_"; //temp variable
        $interests = "";

        // $bi= (array)$bi;
        try {
            $filter = $bi->subcat_level;
            if (!empty($bi)) {
                foreach ($bi as $b) {
                    if ($b->subcat_level_ == '0') {
                        $interest = DB::table('category')->where('id', $b->subcat_id)->pluck('description');
                        $interests = $interests . " " . $interest;
                    } elseif ($b->subcat_level_ == "?") {

                    } else {
                        $table = $t . $b->subcat_level;
                        $interest = DB::table($table)->where('id', $b->subcat_id)->pluck('description');
                        $interests = $interests . " " . $interest;
                    }
                }
            } else {
                $interests = "No interest specified";
            }

        } catch (\Exception $e) {
            $interests = "No interest specified";
        }

        // return $interests;
        try {
            $billing_address = Address::where(['id' => $user->billing_address_id])->get()[0];//ba
        } catch (\Exception $e) {
            echo "<script>console.log('No Billing Address Found');</script>";
            $billing_address = "";
        }

        try {
            $default_address = Address::where(['id' => $user->default_address_id])->get()[0]; //da
        } catch (\Exception $e) {
            echo "<script>console.log('No Default Address Found');</script>";
            $default_address = "";
        }
        //Buyer
        try {
            $buyer = Buyer::where('user_id', $user_id);
        } catch (\Exception $e) {
            echo "<script>console.log('No Buyer Detail Found');</script>";
        }

        // AUTOLINK

       $a_links= $this->get_autolink($user_id);
       // return $a_links;
       $porders = DB::table('porder')->where('user_id', $user_id)->get();
        //Shipping

       $couriers=$this->get_shipping($porders,false);
        // return $porders;
        // Product
        $products= $this->products($porders);

        // AUTOLINKS
        // $autolinks= null;
        // try {

        // } catch (\Exception $e) {

        // }
        // return $products;
        // return $couriers;
        return response()->view('userinfo', ['buyerinfo' => $buyerinfo, 'name' => $name, 'user_id' => $u_id, 'image' => $image, 'products' => $products, 'couriers' => $couriers, 'autolinks' => $a_links, 'user' => $user, 'smmProducts' => $smmProducts, 'occupation' => $occupation, 'age' => $age, 'member_since' => $member_since, 'language' => $language, 'interests' => $interests, 'ba' => $billing_address, 'da' => $default_address])       ->header("Cache-Control","private, must-revalidate,
        max-age=0, no-store, no-cache, must-revalidate, post-check=0, pre-check=0"
      )->header('Pragma', 'no-cache')
        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');;
        return response()->view('userinfo')

            ->with('smmProducts', $smmProducts);
               // ->with('userModel', $userModel)
    }

    public function editmobbuyerinfo()

    {

        $empty = "";
        $languages = DB::table('language')->get();
        $occupations = DB::table('occupation')->get();
        $interests = DB::table('category')->get();
        $banks = DB::table('bank')->get();
        $buyer_social_url=NULL;
        
        try {
            $user_id = Auth::user()->id;
        } catch (\Exception $e) {
            return view("common.generic")
            ->with('message_type','error')
            ->with('message','Please log in to edit.');
            // return "You are not logged in";
        }
        $fb_id=DB::table('oauth_session')->where('user_id',$user_id)->pluck('client_id');
        if (!is_null($fb_id)) {
            $buyer_social_url="https://fb.com/".$fb_id;
        }
        
        try {
            $buyerinfo = Buyer::where('user_id', $user_id);
        } catch (\Exception $e) {
            return view("common.generic")
            ->with('message_type','error')
            ->with('message','Please log in as a buyer.');
            // return "No buyer record found";
        }
        $user = User::where('id', $user_id)->first();

        try {
            $billing_address = Address::where(['id' => $user->billing_address_id])->first();//ba
            $billing_city= $billing_address->city_id;
            $billing_state_code=City::where(['id'=>$billing_city])->first();
            $billing_state_id = State::where(['code'=>$billing_state_code->state_code])->first();
            $billing_city_all = City::where(['state_code' => $billing_state_code->state_code])->get();
            $billing_country = Country::where(['code'=>$billing_state_code->country_code])->first();
            $billing_state_all = State::where(['country_code'=>$billing_country->code])->get();
            $billing_area=$billing_address->area_id;
            $billing_area_all= Area::where(['city_id'=>$billing_city])->get();

        } catch (\Exception $e) {
            echo "<script>console.log('No Billing Address Found');</script>";
            $billing_address = "";
            $billing_city= "";
            $billing_state_code="";
            $billing_state_id = "";
            $billing_city_all = "";
            $billing_country = "";
            $billing_state_all = "";
            $billing_area="";
            $billing_area_all= "";
        }

        try {

            $shipping_address = Address::where(['id' => $user->shipping_address_id])->first();//ba
            $shipping_city = $shipping_address->city_id;
            $shipping_state_code=City::where(['id'=>$shipping_city])->first();
            $shipping_state_id = State::where(['code'=>$shipping_state_code->state_code])->first();
            $shipping_city_all = City::where(['state_code' => $shipping_state_code->state_code])->get();
            $shipping_country = Country::where(['code'=>$shipping_state_code->country_code])->first();
            $shipping_state_all = State::where(['country_code'=>$shipping_country->code])->get();
            $shipping_area=$shipping_address->area_id;
            $shipping_area_all= Area::where(['city_id'=>$shipping_city])->get();

        } catch (\Exception $e) {
            echo "<script>console.log('No Shipping Address Found');</script>";
            $shipping_address = "";
            $shipping_city = "";
            $shipping_state_code="";
            $shipping_state_id = "";
            $shipping_city_all = "";
            $shipping_country = "";
            $shipping_state_all = "";
            $shipping_area="";
            $shipping_area_all= "";
        }


        try {
			$default_address = Address::where(['id' => $user->default_address_id])->first();
            $default_city= $default_address->city_id;
            $default_state_code=City::where(['id'=>$default_city])->first();
            $default_state_id=State::where(['code'=>$default_state_code->state_code])->first();
            $default_city_all = City::where(['state_code' => $default_state_code->state_code])->get();
            $default_country = Country::where(['code'=>$default_state_code->country_code])->first();
            $default_state_all = State::where(['country_code'=>$default_country->code])->get();
            $default_area=$default_address->area_id;
            $default_area_all= Area::where(['city_id'=>$default_city])->get();

        } catch (\Exception $e) {
            echo "<script>console.log('No Default Address Found');</script>";
            $default_address = "";
            $default_city= "";
            $default_state_code="";
            $default_state_id="";
            $default_city_all = "";
            $default_country = "";
            $default_state_all = "";
            $default_area="";
            $default_area_all= "";
        }
        /*try {
            $card = Credit::where('user_id', $user_id)->first();

        } catch (\Exception $e) {
            echo "<script>console.log('No card available');</script>";
            $card = "";
        }*/

        $bankaccount_id = Buyer::where('user_id', $user_id)->pluck('bankaccount_id');

        $buyer = Buyer::where('user_id', $user_id)->first();

        try {
            for($i=0;$i<7;$i++) {
                $photo = 'photo_'.($i+1);
                $buyer_image = $buyer->$photo;
                if($buyer_image!="") {
                    $image[$i] = "images/users/" . $user_id . "/" . $buyer_image;
                }else{
                    $image[$i]="";
                }
            }
        } catch (\Exception $e) {
            echo "<script>console.log('No Image Found');</script>";
            $image = "images/placecards/dummy.jpg";
            //Might not be the best way
        }

        try {
            $banka = BankAccount::where('id', $bankaccount_id)->first();

            $bank_all = DB::table('bank')->where('id', $banka->bank_id)->first();
        } catch (\Exception $e) {
            echo "<script>console.log('No Bank Found');</script>";
            $bank_all = "";

        }

        try {

            $languages_select = Userlanguage::where('user_id', $user_id)->get();

        } catch (\Exception $e) {
            echo "<script>console.log('No languages Found');</script>";
            $bank_all = "";

        }
        /*try {
            $company_name = $buyer->company_name;
        } catch (Exception $e) {
            echo "<script>console.log('No Company Found');</script>";
            $company_name = "";
        }
        try {
            $company_reg_no = $buyer->company_reg_no;
        } catch (Exception $e) {
            $company_reg_no = "";
        }
        try {
            $paypal = $buyer->paypal_email;
        } catch (Exception $e) {
            $paypal = "";
        }*/
        // return $company_name;
        // return $user->salutation;
        $dob_raw = $user->birthdate;
        $dob_raw = explode("/", $dob_raw);
        $dob = $dob_raw[2] . "/" . $dob_raw[1] . "/" . $dob_raw[0];
		//dd($buyerinfo);
        return response()->view('mobeditbuyerreg', ['buyer_social_url'=>$buyer_social_url,'buyerinfo' => $buyerinfo
		, 'userid' => $user_id, 'dob' => $dob, 'image' => $image, 'em' => $empty, 'bank_all' => $bank_all
		, 'banka' => $banka, 'bid' => $bankaccount_id, 'def' => $default_address, 'bill' => $billing_address
		, 'ship' => $shipping_address, 'user' => $user, 'languages' => $languages, 'selectlang'=>$languages_select
		, 'occupations' => $occupations, 'interests' => $interests, 'banks' => $banks, 'defcity'=>$default_city
		,'defstate'=>$default_state_id,'defcityall'=>$default_city_all,'defstateall'=>$default_state_all,'defarea'=>$default_area
		,'defareall'=>$default_area_all, 'billcity'=>$billing_city, 'billstate'=>$billing_state_id,'billcityall'=>$billing_city_all
		,'billstateall'=>$billing_state_all,'billarea'=>$billing_area,'billareall'=>$billing_area_all,'delcity'=>$shipping_city
		, 'delstate'=>$shipping_state_id,'delcityall'=>$shipping_city_all,'delstateall'=>$shipping_state_all,'delarea'=>$shipping_area
		,'delareall'=>$shipping_area_all]);
    }
	
// Edit Form

    public function editbuyerinfo()
    {
        $empty = "";
        $languages = DB::table('language')->get();
        $occupations = DB::table('occupation')->get();
        $interests = DB::table('category')->get();
        $banks = DB::table('bank')->get();
        $buyer_social_url=NULL;
        
        try {
            $user_id = Auth::user()->id;
        } catch (\Exception $e) {
            return view("common.generic")
            ->with('message_type','error')
            ->with('message','Please log in to edit.');
            // return "You are not logged in";
        }
        $fb_id=DB::table('oauth_session')->where('user_id',$user_id)->pluck('client_id');
        if (!is_null($fb_id)) {
            $buyer_social_url="https://fb.com/".$fb_id;
        }
        
        try {
            $buyerinfo = Buyer::where('user_id', $user_id);
        } catch (\Exception $e) {
            return view("common.generic")
            ->with('message_type','error')
            ->with('message','Please log in as a buyer.');
            // return "No buyer record found";
        }
        $user = User::where('id', $user_id)->first();

        try {
            $billing_address = Address::where(['id' => $user->billing_address_id])->first();//ba
            $billing_city= $billing_address->city_id;
            $billing_state_code=City::where(['id'=>$billing_city])->first();
            $billing_state_id = State::where(['code'=>$billing_state_code->state_code])->first();
            $billing_city_all = City::where(['state_code' => $billing_state_code->state_code])->get();
            $billing_country = Country::where(['code'=>$billing_state_code->country_code])->first();
            $billing_state_all = State::where(['country_code'=>$billing_country->code])->get();
            $billing_area=$billing_address->area_id;
            $billing_area_all= Area::where(['city_id'=>$billing_city])->get();

        } catch (\Exception $e) {
            echo "<script>console.log('No Billing Address Found');</script>";
            $billing_address = "";
            $billing_city= "";
            $billing_state_code="";
            $billing_state_id = "";
            $billing_city_all = "";
            $billing_country = "";
            $billing_state_all = "";
            $billing_area="";
            $billing_area_all= "";
        }

        try {

            $shipping_address = Address::where(['id' => $user->shipping_address_id])->first();//ba
            $shipping_city = $shipping_address->city_id;
            $shipping_state_code=City::where(['id'=>$shipping_city])->first();
            $shipping_state_id = State::where(['code'=>$shipping_state_code->state_code])->first();
            $shipping_city_all = City::where(['state_code' => $shipping_state_code->state_code])->get();
            $shipping_country = Country::where(['code'=>$shipping_state_code->country_code])->first();
            $shipping_state_all = State::where(['country_code'=>$shipping_country->code])->get();
            $shipping_area=$shipping_address->area_id;
            $shipping_area_all= Area::where(['city_id'=>$shipping_city])->get();

        } catch (\Exception $e) {
            echo "<script>console.log('No Shipping Address Found');</script>";
            $shipping_address = "";
            $shipping_city = "";
            $shipping_state_code="";
            $shipping_state_id = "";
            $shipping_city_all = "";
            $shipping_country = "";
            $shipping_state_all = "";
            $shipping_area="";
            $shipping_area_all= "";
        }

		//dd($user);
        try {
			$default_address = Address::where(['id' => $user->default_address_id])->first();
		//	dd($default_address);
            $default_city= $default_address->city_id;
            $default_state_code=City::where(['id'=>$default_city])->first();
            $default_state_id=State::where(['code'=>$default_state_code->state_code])->first();
            $default_city_all = City::where(['state_code' => $default_state_code->state_code])->get();
            $default_country = Country::where(['code'=>$default_state_code->country_code])->first();
            $default_state_all = State::where(['country_code'=>$default_country->code])->get();
            $default_area=$default_address->area_id;
            $default_area_all= Area::where(['city_id'=>$default_city])->get();

        } catch (\Exception $e) {
		//	dd($e);
            echo "<script>console.log('No Default Address Found');</script>";
            $default_address = "";
            $default_city= "";
            $default_state_code="";
            $default_state_id="";
            $default_city_all = "";
            $default_country = "";
            $default_state_all = "";
            $default_area="";
            $default_area_all= "";
        }
        /*try {
            $card = Credit::where('user_id', $user_id)->first();

        } catch (\Exception $e) {
            echo "<script>console.log('No card available');</script>";
            $card = "";
        }*/

        $bankaccount_id = Buyer::where('user_id', $user_id)->pluck('bankaccount_id');

        $buyer = Buyer::where('user_id', $user_id)->first();

        try {
            for($i=0;$i<7;$i++) {
                $photo = 'photo_'.($i+1);
                $buyer_image = $buyer->$photo;
                if($buyer_image!="") {
                    $image[$i] = "images/users/" . $user_id . "/" . $buyer_image;
                }else{
                    $image[$i]="";
                }
            }
        } catch (\Exception $e) {
            echo "<script>console.log('No Image Found');</script>";
            $image = "images/placecards/dummy.jpg";
            //Might not be the best way
        }

        try {
            $banka = BankAccount::where('id', $bankaccount_id)->first();

            $bank_all = DB::table('bank')->where('id', $banka->bank_id)->first();
        } catch (\Exception $e) {
            echo "<script>console.log('No Bank Found');</script>";
            $bank_all = "";

        }

        try {

            $languages_select = Userlanguage::where('user_id', $user_id)->get();

        } catch (\Exception $e) {
            echo "<script>console.log('No languages Found');</script>";
            $bank_all = "";

        }
        /*try {
            $company_name = $buyer->company_name;
        } catch (Exception $e) {
            echo "<script>console.log('No Company Found');</script>";
            $company_name = "";
        }
        try {
            $company_reg_no = $buyer->company_reg_no;
        } catch (Exception $e) {
            $company_reg_no = "";
        }
        try {
            $paypal = $buyer->paypal_email;
        } catch (Exception $e) {
            $paypal = "";
        }*/
        // return $company_name;
        // return $user->salutation;
        $dob_raw = $user->birthdate;
        $dob_raw = explode("/", $dob_raw);
        $dob = $dob_raw[2] . "/" . $dob_raw[1] . "/" . $dob_raw[0];
	//	dd($default_address);
        return response()->view('editbuyerreg', ['buyer_social_url'=>$buyer_social_url,'buyerinfo' => $buyerinfo, 'userid' => $user_id, 'dob' => $dob, 'image' => $image, 'em' => $empty, 'bank_all' => $bank_all, 'banka' => $banka, 'bid' => $bankaccount_id, 'def' => $default_address, 'bill' => $billing_address, 'ship' => $shipping_address, 'user' => $user, 'languages' => $languages, 'selectlang'=>$languages_select, 'occupations' => $occupations, 'interests' => $interests, 'banks' => $banks, 'defcity'=>$default_city,'defstate'=>$default_state_id,'defcityall'=>$default_city_all,'defstateall'=>$default_state_all,'defarea'=>$default_area,'defareall'=>$default_area_all, 'billcity'=>$billing_city, 'billstate'=>$billing_state_id,'billcityall'=>$billing_city_all,'billstateall'=>$billing_state_all,'billarea'=>$billing_area,'billareall'=>$billing_area_all,'delcity'=>$shipping_city, 'delstate'=>$shipping_state_id,'delcityall'=>$shipping_city_all,'delstateall'=>$shipping_state_all,'delarea'=>$shipping_area,'delareall'=>$shipping_area_all])       ->header("Cache-Control","private, must-revalidate,
        max-age=0, no-store, no-cache, must-revalidate, post-check=0, pre-check=0"
      )->header('Pragma', 'no-cache')
        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');;
    }

// Save Edit
    public function save_mobedit(Request $request)
    {

       // dd("JOLA");
        $billing=false;
        $delivery=false;
        $sendConfirmMail=False;
        $old_email= Auth::user()->email;
        $new_email=$request->email;
        if ($old_email!=$new_email) {

            $sendConfirmMail=True;
        }

        if (!isset($request)) {
            return "Empty forms are not accepted";
        }
        $this->validate($request, [

            'full_name' => 'min:3',
            'language' => 'required',
            'occupation' => 'required',
            'mobile' => 'max:12|min:10',
            'photo' => 'image',
            'email'=>'required',

        ]);



        // return $request->dob;
        $user_id = Auth::user()->id;
        //check for buyer record
        try {
            $check_buyer_id = DB::table('buyer')->where('user_id', $user_id)->pluck('id');

            $check_buyer = Buyer::find($check_buyer_id);
            if ($check_buyer == null) {
                # code...
                $new_buyer = new Buyer;
                $new_buyer->user_id = $user_id;
                $new_buyer->save();
            }
        } catch (\Exception $e) {
            return "no buyer";

        }


    $base_path = "images/users/";
    $full_path = $base_path . $user_id;
    $base_pathnew = "images\users\\". $user_id;

/*    if(File::exists(public_path($full_path))) {
         File::deleteDirectory(public_path($full_path,0775));
    }*/
       // File::makeDirectory(public_path($full_path), 0775, true);

    for($i=0;$i<7;$i++) {
        $nodelete=0;
        $photo='photo'.$i;
        if ($request->hasFile($photo)) {
            $nodelete=1;
            $photold ='photo'.$i.'_old';

            $r1 = str_random(10);
            $r2 = str_random(5);
            $r3 = str_random(2);
            $pname = $i.$r1 . $r2 . $r3;

            //try {
                //File::makeDirectory(public_path($full_path), 0775, true);
                // mkdir($full_path);
           // } catch (\Exception $e) {
                // Folder already exists or some permission issue
                // DB::rollBack();
                // return $e;
            //}//trycatch
            $img = $request->file('photo'.$i);
            $imgext = $img->getClientOriginalExtension();
            $name = $pname . "." . $imgext;
            try {

                Image::make($img)->save($full_path . "/" . $name);
            } catch (\Exception $e) {
                // DB::rollBack();
                return $e;
            }
            try {

                $buyer_id = DB::table('buyer')->where('user_id', $user_id)->pluck('id');

                $buyer = Buyer::find($buyer_id);

        $photoname='photo_'.($i+1);
        if($request->$photold=="1" || $request->$photold=="2"){
            $user_photodel = DB::table('buyer')->where('user_id', $user_id)->pluck($photoname);
            $full_path=public_path()."\\".$base_pathnew.'\\'.$user_photodel;
            \File::delete($full_path);
        }

                $buyer->$photoname = $name;
                $buyer->save();
            } catch (\Exception $e) {
                return "<script>console.log('No buyer id');</script>";
            };
        }
        if($nodelete == 0){
            $photold ='photo'.$i.'_old';
            $photoname='photo_'.($i+1);
            if($request->$photold=="2"){
                $user_photodel = DB::table('buyer')->where('user_id', $user_id)->pluck($photoname);
                $full_path=public_path()."\\".$base_pathnew.'\\'.$user_photodel;
                \File::delete($full_path);
                DB::table('buyer')->where('user_id', $user_id)->update([$photoname => '']);
            }
        }

    }


        //BANK
        //Must be a bank . other wise null error
        $bank_id = DB::table('buyer')->where('user_id', $user_id)->pluck('bankaccount_id');
        // This is bank account
        if ($request->has('account_name')) {
            # code...
            try {
                $bank = BankAccount::find($bank_id);
				if(!is_null($bank)){
					$bank->bank_id = $request->bank;
					$bank->swift = $request->swift;
					$bank->iban = $request->iban;
					$bank->account_name1 = $request->account_name;
					// if (isset($request->account2)) {
					//     $buyer->account_number2 = $request->account2;
					// }
					$bank->account_number1 = $request->account_number;
					// $bank->name= $request->account_bank;
					// $bank->code= $request->account_bank_code;
					$bank->save();
				} else {
					//dd("Estoy aqui");
					$payment_receive = New BankAccount;

					$payment_receive->account_name1=$request->account_name;
					$payment_receive->account_number1 = $request->account_number;
					$payment_receive->bank_id = $request->bank;
					//$payment_receive->code = $request->bank_code;
					$payment_receive->iban = $request->iban;
					$payment_receive->swift = $request->swift;

					$payment_receive->save();
					$bankaccout_id=$payment_receive->id;
					DB::table('buyer')->where('user_id', $user_id)->update(['bankaccount_id'=>$bankaccout_id]);
				}

            } catch (\Exception $e) {

            }

        }


        $user1 = User::find($user_id);
        try {
            $dai = $user1->default_address_id;
            $default_address = Address::find($dai);
			//dd($default_address);
			if(is_null($default_address)){
				$default_address = new Address;
				$default_address->city_id = $request->defaultcity_name;
				$default_address->line1 = $request->default1;

				if ($request->has('default_postcode')) {
					$default_address->postcode = $request->default_postcode;
				}
				if ($request->has('defaultarea_name')) {
					$default_address->area_id = $request->defaultarea_name;
				}

				$default_address->save();
				$dai = $default_address->id;	
			} else {
				$default_address->city_id = $request->defaultcity_name;
				$default_address->line1 = $request->default1;
				if ($request->has('default_postcode')) {
					$default_address->postcode = $request->default_postcode;
				}
				if ($request->has('defaultarea_name')) {
					$default_address->area_id = $request->defaultarea_name;
				}
				$default_address->save();
			}
			$uniqueexist = DB::table('nbuyerid')->where('user_id',$user1->id)->first();
			if(is_null($uniqueexist)){
				$uniqueid = UtilityController::buyeruniqueid($request->defaultcity_name);
				DB::table('nbuyerid')->insert(['nbuyer_id'=>$uniqueid, 'buyer_id'=>$check_buyer_id, 'user_id' => $user1->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]); 
				UtilityController::createQr($check_buyer_id,'buyer',IdController::nB($user1->id));
			}
        } catch (\Exception $e) {
			dd($e);
        }

        try {

            if($request->billingcheck != null){
                $billing_reference_id = $dai;
				$billing = true;
            }else{
                if ($request->has('billing1')) {
                    $address = new Address;
                    $address->city_id = $request->billingcity_name;
                    $address->line1 = $request->billing1;
                    if ($request->has('billing_postcode')) {
                        $address->postcode = $request->billing_postcode;
                    }
                    if ($request->has('billingarea_name')) {
                        $address->area_id = $request->billingarea_name;
                    }
                    $address->save();
                    $billing = true;
                    $billing_reference_id = $address->id;
                }
            }

            if($request->deliverycheck != null){
				$shipping_reference_id = $dai;
                $delivery = true;
            }else{
                if ($request->has('delivery1')) {
                    # code...
                    $shipping_address = new Address;
                    $shipping_address->city_id = $request->deliverycity_name;
                    $shipping_address->line1 = $request->delivery1;

                    if ($request->has('delivery_postcode')) {
                        $shipping_address->postcode = $request->delivery_postcode;
                    }
                    if ($request->has('deliveryarea_name')) {
                        $shipping_address->area_id = $request->deliveryarea_name;
                    }
                    $shipping_address->save();
                    $delivery = true;
                    $shipping_reference_id = $shipping_address->id;
                }
            }
        } catch (\Exception $e) {
        }
        // ***************************
        $user = User::find($user_id);
		$user->default_address_id = $dai;
		if ($billing == true) {
			# code...
			$user->billing_address_id = $billing_reference_id;
		}
		if ($delivery == true) {
			# code...
			$user->shipping_address_id = $shipping_reference_id;
		}
        $user->username = $request->username;
        // $user->first_name="";
        // $user->last_name="";
        $user->name = $request->full_name;
		$split_name = explode(" ", $request->full_name);
		if(sizeof($split_name)==1){
			$user->first_name = $split_name[0];
		} else if(sizeof($split_name)==2){
			$user->first_name = $split_name[0];
			$user->last_name = $split_name[1];
		} else if(sizeof($split_name)==3){
			$user->first_name = $split_name[0] .  " " . $split_name[1];
			$user->last_name = $split_name[2];
		} else if(sizeof($split_name)>=4){
			$user->first_name = $split_name[0] .  " " . $split_name[1];
			$user->last_name = $split_name[2] . " " . $split_name[3];
		}
        // $user->nric="";
        // $user->email=$request->username;
        $user->occupation_id = $request->occupation;
        // $user->nationality_country_id="";
        // $user->avatar="";
        // $user->provider="";
        // $user->provider_id="";
        // $user->access_token="";
        // $user->birthdate = $request->dob;
        $user->mobile_no = $request->mobile;
        // Confirm password. put a if statememnt

        /*if($request->password != ""){
			$user->password = Hash::make($request->password);
		}*/
        // $user->password= $request->password;
        $user->gender = $request->gender;
        $user->annual_income = $request->income;
        if ($request->salutation == 'option1') {
            if ($request->has('otherinput')) {
                $user->salutation = $request->otherinput;
            }

        } else {
            $user->salutation = $request->salutation;
        }
        // $user->default_address_id="";
        //

        // $user->remember_token="";
        // $user->permissions="";
        // $user->last_login="";
        $user->save();
        // ***************************
        Userlanguage::where('user_id', $user_id)->delete();

        foreach($request->language as $key => $value){
            $userlanguage = new Userlanguage;
            $userlanguage->language_id = $value;
            $userlanguage->user_id = $user_id;
            $userlanguage->save();
        }
        if ($sendConfirmMail==True) {
            $e= new EmailController;
            $e->updateEmail($new_email,$user->id);
        }

        return redirect()->route('buyermobinformation')
        ;
        return "Buyer's information has been updated!";
		//}

    }
	
// Save Edit
    public function save_edit(Request $request)
    {
     //   dump("JOLA");
        $billing=false;
        $delivery=false;
        $sendConfirmMail=False;
        $old_email= Auth::user()->email;
        $new_email=$request->email;
        if ($old_email!=$new_email) {
            $sendConfirmMail=True;
        }

        if (!isset($request)) {
            return "Empty forms are not accepted";
        }

        $this->validate($request, [
            'full_name' => 'min:3',
        //    'language' => 'required',
        //    'occupation' => 'required',
        //    'photo' => 'image',
            'email'=>'required',
        ]);

        // return $request->dob;
        $user_id = Auth::user()->id;

        //check for buyer record
        try {
            $check_buyer_id = DB::table('buyer')->where('user_id', $user_id)->pluck('id');

            $check_buyer = Buyer::find($check_buyer_id);
            if ($check_buyer == null) {
                # code...
                $new_buyer = new Buyer;
                $new_buyer->user_id = $user_id;
                $new_buyer->save();
            }
        } catch (\Exception $e) {
            return "no buyer";

        }


    $base_path = "images/users/";
    $full_path = $base_path . $user_id;
    $base_pathnew = "images\users\\". $user_id;

/*    if(File::exists(public_path($full_path))) {
         File::deleteDirectory(public_path($full_path,0775));
    }*/
       // File::makeDirectory(public_path($full_path), 0775, true);

  /*  for($i=0;$i<7;$i++) {
        $nodelete=0;
        $photo='photo'.$i;
        if ($request->hasFile($photo)) {
            $nodelete=1;
            $photold ='photo'.$i.'_old';

            $r1 = str_random(10);
            $r2 = str_random(5);
            $r3 = str_random(2);
            $pname = $i.$r1 . $r2 . $r3;

            //try {
                //File::makeDirectory(public_path($full_path), 0775, true);
                // mkdir($full_path);
           // } catch (\Exception $e) {
                // Folder already exists or some permission issue
                // DB::rollBack();
                // return $e;
            //}//trycatch
            $img = $request->file('photo'.$i);
            $imgext = $img->getClientOriginalExtension();
            $name = $pname . "." . $imgext;
            try {

                Image::make($img)->save($full_path . "/" . $name);
            } catch (\Exception $e) {
                // DB::rollBack();
                return $e;
            }

            try {
                $buyer_id = DB::table('buyer')->
					where('user_id', $user_id)->pluck('id');
                $buyer = Buyer::find($buyer_id);

				$photoname='photo_'.($i+1);
				if($request->$photold=="1" || $request->$photold=="2"){
					$user_photodel = DB::table('buyer')->
						where('user_id', $user_id)->pluck($photoname);

					$full_path=public_path()."\\".$base_pathnew.'\\'.
						$user_photodel;
					\File::delete($full_path);
				}

                $buyer->$photoname = $name;
                $buyer->save();

            } catch (\Exception $e) {
                return "<script>console.log('No buyer id');</script>";
            };
        }

        if($nodelete == 0){
            $photold ='photo'.$i.'_old';
            $photoname='photo_'.($i+1);
            if($request->$photold=="2"){
                $user_photodel = DB::table('buyer')->
					where('user_id', $user_id)->pluck($photoname);

                $full_path=public_path()."\\".$base_pathnew.'\\'.$user_photodel;
                \File::delete($full_path);
                DB::table('buyer')->
					where('user_id', $user_id)->
					update([$photoname => '']);
            }
        }

    }*/


        //BANK
        //Must be a bank . other wise null error
        $bank_id = DB::table('buyer')->
			where('user_id', $user_id)->
			pluck('bankaccount_id');

        // This is bank account
     /*   if ($request->has('account_name')) {
            # code...
            try {
                $bank = BankAccount::find($bank_id);
				if(!is_null($bank)){
					$bank->bank_id = $request->bank;
					$bank->swift = $request->swift;
					$bank->iban = $request->iban;
					$bank->account_name1 = $request->account_name;
					// if (isset($request->account2)) {
					//     $buyer->account_number2 = $request->account2;
					// }
					$bank->account_number1 = $request->account_number;
					// $bank->name= $request->account_bank;
					// $bank->code= $request->account_bank_code;
					$bank->save();
				} else {
					//dd("Estoy aqui");
					$payment_receive = New BankAccount;

					$payment_receive->account_name1=$request->account_name;
					$payment_receive->account_number1 = $request->account_number;
					$payment_receive->bank_id = $request->bank;
					//$payment_receive->code = $request->bank_code;
					$payment_receive->iban = $request->iban;
					$payment_receive->swift = $request->swift;

					$payment_receive->save();
					$bankaccout_id=$payment_receive->id;
					DB::table('buyer')->where('user_id', $user_id)->update(['bankaccount_id'=>$bankaccout_id]);
				}

            } catch (\Exception $e) {

            }
        }*/
        $user1 = User::find($user_id);

        try {
            $dai = $user1->default_address_id;
            $default_address = Address::find($dai);
		 	//dd($default_address);
			$citychanged = false;

			if(is_null($default_address)){
				
				$default_address = new Address;
			//	dd($default_address);
				if (isset($request->defaultcity_name) &&
					!empty($request->defaultcity_name)) {
					$default_address->city_id = $request->defaultcity_name;
				}

				if (isset($request->default1) &&
					!empty($request->default1)) {
					$default_address->line1 = $request->default1;
				}

				if ($request->has('default_postcode')) {
					$default_address->postcode = $request->default_postcode;
				}
				if ($request->has('defaultarea_name')) {
					$default_address->area_id = $request->defaultarea_name;
				}
			//	dd($default_address);
				$default_address->save();
				$dai = $default_address->id;
			//	dd($dai);					

			} else {
			//	dump($default_address->city_id);
			//	dump($request->defaultcity_name);
				if (isset($default_address->city_id) &&
					!empty($default_address->city_id) &&
					isset($request->defaultcity_name) &&
					!empty($request->defaultcity_name)) {
					if($default_address->city_id != $request->defaultcity_name){
						$citychanged = true;
					}
				}				
				$default_address->city_id = $request->defaultcity_name;
				$default_address->line1 = $request->default1;
				if ($request->has('default_postcode')) {
					$default_address->postcode = $request->default_postcode;
				}
				if ($request->has('defaultarea_name')) {
					$default_address->area_id = $request->defaultarea_name;
				}
				$default_address->save();
			}
			$uniqueexist = DB::table('nbuyerid')->
				where('user_id',$user1->id)->first();
			//dump($uniqueexist);
			if(is_null($uniqueexist)){
				$uniqueid = UtilityController::buyeruniqueid($request->defaultcity_name);
				DB::table('nbuyerid')->insert(['nbuyer_id'=>$uniqueid, 'buyer_id'=>$check_buyer_id, 'user_id' => $user1->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]); 
				UtilityController::createQr($check_buyer_id,'buyer',IdController::nB($user1->id));
			} else {
			//	dd($citychanged);
				if($citychanged){
					$uniqueid = UtilityController::buyeruniqueid($request->defaultcity_name);
					//dd($uniqueid);
					DB::table('nbuyerid')->where('id',$uniqueexist->id)->update(['nbuyer_id'=>$uniqueid, 'updated_at' => date('Y-m-d H:i:s')]); 
					DB::table('buyerqr')->where('buyer_id',$check_buyer_id)->delete();
					UtilityController::createQr($check_buyer_id,'buyer',IdController::nB($user1->id));
				}
			}
        } catch (\Exception $e) {
			dd($e);
        }

        try {

            if($request->billingcheck != null){
                $billing_reference_id = $dai;
				$billing = true;
            }else{
                if ($request->has('billing1')) {
                    $address = new Address;
                    $address->city_id = $request->billingcity_name;
                    $address->line1 = $request->billing1;
                    if ($request->has('billing_postcode')) {
                        $address->postcode = $request->billing_postcode;
                    }
                    if ($request->has('billingarea_name')) {
                        $address->area_id = $request->billingarea_name;
                    }
                    $address->save();
                    $billing = true;
                    $billing_reference_id = $address->id;
                }
            }

            if($request->deliverycheck != null){
				$shipping_reference_id = $dai;
                $delivery = true;
            }else{
                if ($request->has('delivery1')) {
                    # code...
                    $shipping_address = new Address;
                    $shipping_address->city_id = $request->deliverycity_name;
                    $shipping_address->line1 = $request->delivery1;

                    if ($request->has('delivery_postcode')) {
                        $shipping_address->postcode = $request->delivery_postcode;
                    }
                    if ($request->has('deliveryarea_name')) {
                        $shipping_address->area_id = $request->deliveryarea_name;
                    }
                    $shipping_address->save();
                    $delivery = true;
                    $shipping_reference_id = $shipping_address->id;
                }
            }
        } catch (\Exception $e) {
        }
        // ***************************
        $user = User::find($user_id);
		$user->default_address_id = $dai;
		if ($billing == true) {
			# code...
			$user->billing_address_id = $billing_reference_id;
		}
		if ($delivery == true) {
			# code...
			$user->shipping_address_id = $shipping_reference_id;
		}
        $user->username = $request->username;
        // $user->first_name="";
        // $user->last_name="";
        $user->name = $request->full_name;
		$split_name = explode(" ", $request->full_name);
		if(sizeof($split_name)==1){
			$user->first_name = $split_name[0];
		} else if(sizeof($split_name)==2){
			$user->first_name = $split_name[0];
			$user->last_name = $split_name[1];
		} else if(sizeof($split_name)==3){
			$user->first_name = $split_name[0] .  " " . $split_name[1];
			$user->last_name = $split_name[2];
		} else if(sizeof($split_name)>=4){
			$user->first_name = $split_name[0] .  " " . $split_name[1];
			$user->last_name = $split_name[2] . " " . $split_name[3];
		}
        // $user->nric="";
        // $user->email=$request->username;
        $user->occupation_id = $request->occupation;
        // $user->nationality_country_id="";
        // $user->avatar="";
        // $user->provider="";
        // $user->provider_id="";
        // $user->access_token="";
        // $user->birthdate = $request->dob;
        $user->mobile_no = $request->mobile;
        // Confirm password. put a if statememnt

        /*if($request->password != ""){
			$user->password = Hash::make($request->password);
		}*/
        // $user->password= $request->password;
        $user->gender = $request->gender;
        $user->annual_income = $request->income;
        if ($request->salutation == 'option1') {
            if ($request->has('otherinput')) {
                $user->salutation = $request->otherinput;
            }

        } else {
            $user->salutation = $request->salutation;
        }
        // $user->default_address_id="";
        //

        // $user->remember_token="";
        // $user->permissions="";
        // $user->last_login="";
        $user->save();
        // ***************************
        Userlanguage::where('user_id', $user_id)->delete();

		/* Only save language if it exists */
		if (isset($request->language)) {
			foreach($request->language as $key => $value){
				$userlanguage = new Userlanguage;
				$userlanguage->language_id = $value;
				$userlanguage->user_id = $user_id;
				$userlanguage->save();
			}
		}

        if ($sendConfirmMail==True) {
            $e= new EmailController;
            $e->updateEmail($new_email,$user->id);
        }

        return redirect()->route('buyerinformation')
        ;
        return "Buyer's information has been updated!";
		//}

    }

    public function buyer_pagination($start=0){
		$end=$start+30;

        $ret=array();
        if (!Auth::check() or !Auth::user()->hasRole('adm')) {
            return $ret;
        }
        try {
            $ret= Buyer::leftJoin('usersproduct','usersproduct.user_id','=','buyer.user_id')
			->leftJoin('nbuyerid','nbuyerid.user_id','=','buyer.user_id')
		->select(DB::raw("buyer.id as id, buyer.user_id as user_id,LPAD(buyer.id,11,'0') as buyer_id,users.first_name as first_name, users.last_name as last_name,users.username as username,users.email as email, buyer.status, buyer.created_at, COUNT(usersproduct.product_id) as likes"))
        ->join('users', 'buyer.user_id', '=', 'users.id')
        ->groupBy('buyer.user_id')
        ->orderBY('buyer.created_at', 'desc')->get();
		
		foreach($ret as $r){
			$oacc=UtilityController::ocredit($r->user_id)['ocredit'];

			if (is_null($oacc)) {
				$ocredit=0;
			}
			else{
				$ocredit=$oacc;
			}
			$r->ocredit = $ocredit;
		}
              
        } catch (\Exception $e) {
            // dd($e);
        }
        return Datatables::of($ret)->make(true);
	}
    public function master_buyer(){

        return response()->view('master.buyer_pagination')       ->header("Cache-Control","private, must-revalidate,
        max-age=0, no-store, no-cache, must-revalidate, post-check=0, pre-check=0"
      )->header('Pragma', 'no-cache')
        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');

    }
	public function approval($id){
        $buyer = DB::table('buyer')->select('buyer.id as id', 'buyer.user_id as user_id','users.username as username','users.email as email', 'buyer.status', 'buyer.created_at')
		->where('buyer.id',$id)
        ->join('users', 'buyer.user_id', '=', 'users.id')
        ->orderBY('buyer.created_at', 'desc')
        ->get();
		$idbuyer = DB::table('buyer')->where('buyer.id',$id)->first();
        return response()->view('master.buyer_approval',['buyer'=>$buyer,'idbuyer'=>$idbuyer])       ->header("Cache-Control","private, must-revalidate,
        max-age=0, no-store, no-cache, must-revalidate, post-check=0, pre-check=0"
      )->header('Pragma', 'no-cache')
        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
	}

	public function others($id){
        $buyer = DB::table('buyer')->select('buyer.id as id', 'buyer.user_id as user_id','users.username as username','users.email as email', 'buyer.status', 'buyer.created_at')
		->where('buyer.id',$id)
        ->join('users', 'buyer.user_id', '=', 'users.id')
        ->orderBY('buyer.created_at', 'desc')
        ->get();
        return response()->view('master.buyer_others',['buyer'=>$buyer])       ->header("Cache-Control","private, must-revalidate,
        max-age=0, no-store, no-cache, must-revalidate, post-check=0, pre-check=0"
      )->header('Pragma', 'no-cache')
        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
	}

    public function buyer_interest($id){

        $buyer = DB::table('buyercategory')
        ->where('buyercategory.user_id',$id)
        ->get();
		$returnarr = array();
		$i=0;
		foreach($buyer as $interest){
			if($interest->subcat_level > 0 && $interest->subcat_level < 5){
				$buyernew = DB::table('subcat_level_' . $interest->subcat_level)
				->select('subcat_level_' . $interest->subcat_level .'.id as id', 'subcat_level_' . $interest->subcat_level .'.description as description', 'category.description as catdescription')
				->where('subcat_level_' . $interest->subcat_level . '.id',$interest->subcat_id)
				->join('category','subcat_level_' . $interest->subcat_level . '.category_id','=','category.id')
				->first();
				if(!is_null($buyernew)){
					$returnarr[$i]['query'] = $buyernew;
					$returnarr[$i]['level'] = $interest->subcat_level;
					$i++;
				}
			}
		}
        return json_encode($returnarr);

    }

    public function buyer_address($id){

        $buyer = DB::table('address')
        ->select('address.id as id', 'address.line1 as description','city.name as cityname','area.name as areaname','state.name as statename','country.name as countryname', 'address.postcode as postcode')
        ->join('buyeraddress', 'buyeraddress.address_id', '=', 'address.id')
        ->join('city', 'address.city_id', '=', 'city.id')
        ->leftjoin('area', 'address.area_id', '=', 'area.id')
        ->join('state', 'city.state_code', '=', 'state.code')
        ->join('country', 'state.country_code', '=', 'country.code')
        ->where('buyeraddress.buyer_id',$id)
        ->get();
		
		if (empty($buyer) || is_null($buyer)) {
			Log::info("***** Empty Address *****");

			/* buyeraddress has no record,
			 * fallback to users.default_address_id */

			$buyer = DB::select(DB::raw(
			"select
				`address`.`id` as `id`,
				`address`.`line1` as `description`,
				`city`.`name` as `cityname`,
				`area`.`name` as `areaname`,
				`state`.`name` as `statename`,
				`country`.`name` as `countryname`,
				`address`.`postcode` as `postcode`
			from
				buyer, 
				`address`
				inner join `users` on `address`.`id` =
					`users`.`default_address_id`
				inner join `city` on `address`.`city_id` = `city`.`id`
				left join `area` on `address`.`area_id` = `area`.`id`
				inner join `state` on `city`.`state_code` = `state`.`code`
				inner join `country` on `state`.`country_code` = `country`.`code`
			where
				buyer.user_id=users.id and
				`buyer`.`id` =".$id));

			//Log::info(json_encode($buyer));
		}

        return json_encode($buyer);
    }

    public function buyer_payment_method($id){
		$buyer = DB::table('buyer')
        ->where('id',$id)
        ->first();

		$bankaccount = DB::table('bankaccount')
        ->where('id',$buyer->bankaccount_id)
        ->first();
		//$returnarr[6] = number_format($employee->monthly_salary/100,2);
		$returnarr[0] = "";
		$returnarr[1] = "";
		$returnarr[2] = "";
		$returnarr[3] = "";
		$returnarr[4] = "";
		$returnarr[5] = "";


		if(!is_null($bankaccount)){
			$returnarr[0] = $bankaccount->account_name1;
			$returnarr[1] = $bankaccount->account_number1;
			$returnarr[4] = $bankaccount->iban;
			$returnarr[5] = $bankaccount->swift;
			$bank = DB::table('bank')
			->where('id',$bankaccount->bank_id)
			->first();
			if(!is_null($bank)){
				$returnarr[2] = $bank->name;
				$returnarr[3] = $bank->code;
			}
		}


		return json_encode($returnarr);;

    }

    public function buyer_roles($id){

        $employee = DB::table('employee')
        ->where('user_id',$id)
        ->count();
		$employees = "";
		$employeer = "";
		if($employee > 0){
			$employeedata = DB::table('employee')
			->where('user_id',$id)
			->first();
			$employees = $employeedata->status;
			if (isset($employeedata->recruiter_id)) {
				$employeer = $employeedata->recruiter_id;
			}
		}

        $sr = DB::table('sales_staff')
        ->where('user_id',$id)
        ->where('type','str')
        ->count();
		$srs = "";
		$srr = "";
		if($sr > 0){
			$srdata = DB::table('sales_staff')
			->where('user_id',$id)
			->where('type','str')
			->first();
			$srs = $srdata->status;
			$srr = $srdata->recruiter_user_id;
		}

        $mc = DB::table('sales_staff')
        ->where('user_id',$id)
		->where('type','mct')
        ->count();
		$mcs = "";
		$mcr = "";
		if($mc > 0){
			$mcdata = DB::table('sales_staff')
			->where('user_id',$id)
			->where('type','mct')
			->first();
			$mcs = $mcdata->status;
			$mcr = $mcdata->recruiter_user_id;
		}

        $mp = DB::table('sales_staff')
        ->where('user_id',$id)
		->where('type','mcp')
        ->count();
		$mps = "";
		$mpr = "";
		if($mp > 0){
			$mpdata = DB::table('sales_staff')
			->where('user_id',$id)
			->where('type','mcp')
			->first();
			$mps = $mpdata->status;
			$mpr = $mpdata->recruiter_user_id;
		}

        $psh = DB::table('sales_staff')
        ->where('user_id',$id)
		->where('type','psh')
        ->count();
		$pshs = "";
		$pshr = "";
		if($psh > 0){
			$pshdata = DB::table('sales_staff')
			->where('user_id',$id)
			->where('type','psh')
			->first();
			$pshs = $pshdata->status;
			$pshr = $pshdata->recruiter_user_id;
		}

        $smm = DB::table('sales_staff')
        ->where('user_id',$id)
		->where('type','smm')
        ->count();
		$smms = "";
		$smmr = "";

		if($smm > 0){
			$smmdata = DB::table('sales_staff')
			->where('user_id',$id)
			->where('type','smm')
			->first();

			$smms = $smmdata->status;
			$smmr = $smmdata->recruiter_user_id;
			if(is_null($smmr)){
				$smmr = 0;
			}
		}

		$buyer = DB::table('buyer')
        ->where('user_id',$id)
        ->first();

		$buyerrole = DB::table("role_users")->where('user_id', $id )->where('role_id',2)->count();
		//dd($buyerrole);
		$roles[0] = $buyer->emp_appt;
		$roles[1] = $buyer->str_appt;
		$roles[2] = $buyer->mct_appt;
		$roles[3] = $mp;
		$roles[4] = $psh;
		$roles[5] = $smm;

		$roles[6] = $employees;
		$roles[7] = $srs;
		$roles[8] = $mcs;
		$roles[9] = $mps;
		$roles[10] = $pshs;
		$roles[11] = $smms;

		$roles[12] = $employeer;
		$roles[13] = $srr;
		$roles[14] = $mcr;
		$roles[15] = $mpr;
		$roles[16] = $pshr;
		$roles[17] = $smmr;

		$users_ss = DB::table('users')->
			select('users.id as id','users.first_name as first_name',
				'users.last_name as last_name','nbuyerid.nbuyer_id as bid')->
				join('sales_staff','users.id','=','sales_staff.user_id')->
				leftJoin('nbuyerid','nbuyerid.user_id','=','users.id')->
			where('sales_staff.type','=','str');

		$users_mc = DB::table('users')->
			select('users.id as id','users.first_name as first_name',
				'users.last_name as last_name','nbuyerid.nbuyer_id as bid')->
				join('sales_staff','users.id','=','sales_staff.user_id')->
				leftJoin('nbuyerid','nbuyerid.user_id','=','users.id')->
			where('sales_staff.type','=','mct');

        $users = DB::table('users')->
			select('users.id as id','users.first_name as first_name',
				'users.last_name as last_name','nbuyerid.nbuyer_id as bid')->
				join('employee','users.id','=','employee.user_id')->
				leftJoin('nbuyerid','nbuyerid.user_id','=','users.id')->
			union($users_ss)->union($users_mc)->get();

		$roles[18] = $users;
		$roles[19] = $buyerrole;

        return json_encode($roles);

    }

	public function buyer_edit($id, $role, $tf, $rec){
		$user_id = Auth::user()->id;
		$tfs = false;
		$tfsc = true;
		if($tf == 1){
			$tfs = true;
			$tfsc = false;
		}
		if($role=="employee"){
			DB::table('buyer')->where('user_id',$id)->update(['emp_appt' => $tfs, 'mct_appt' => $tfsc]);
			$empchek = DB::table('employee')->where('user_id',$id)->first();
			if(!is_null($empchek)){
				DB::table('employee')->where('user_id',$id)->update(['recruiter_id'=>$rec, 'updated_at'=>date('Y-m-d H:i:s')]);
			} else {
				DB::table('employee')->insert(['user_id'=>$id,'position_id'=>0,'recruiter_id'=>$rec,'status'=>'active','payment'=>0, 'active_date'=>date('Y-m-d H:i:s'), 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
			}
			if($tfs){
				$mct = DB::table('sales_staff')->where('user_id',$id)->where('type',"mct")->update(['status' => 'suspended']);
				$rmct = DB::table('roles')->where('roles.slug',"mct")->first();
				$rolmct = DB::table('role_users')->where('user_id',$id)->where('role_id',$rmct->id)->delete();
			}
			$remp = DB::table('roles')->where('roles.slug',"emp")->first();
			$roleemp = DB::table('role_users')->where('user_id',$id)->where('role_id',$remp->id)->first();
			if(is_null($roleemp)){
				DB::table('role_users')->insert(['user_id'=>$id, 'role_id'=>$remp->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
			}
		} else {

			if($role=="mct"){
				DB::table('buyer')->where('user_id',$id)->update(['mct_appt' => $tfs, 'emp_appt' => $tfsc]);
			}

			if($role=="str"){
				DB::table('buyer')->where('user_id',$id)->update(['str_appt' => $tfs]);
			}
			if($tfs){
				 DB::table('employee')->where('user_id',$id)->update(['status' =>'suspended']);
				 $remp = DB::table('roles')->where('roles.slug',"emp")->first();
				 $roleemp = DB::table('role_users')->where('user_id',$id)->where('role_id',$remp->id)->delete();
			}
			if($tf == 1){
				$mycount = DB::table('sales_staff')->where('user_id',$id)->where('type',$role)->count();
				if($mycount == 0){
					$staff2 = DB::table('sales_staff')->insertGetId(array('user_id' => $id, 'type'=>$role,'recruiter_user_id'=>$rec,'target_station'=>0,'target_merchant'=>0,'target_revenue'=>0,'commission'=>0,'commission'=>0,'bonus'=>0,'status'=>'active','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')));
				} else {
					$staff2 = DB::table('sales_staff')->where('user_id',$id)->where('type',$role)->update(['recruiter_user_id'=>$rec]);
				}
				$rmct = DB::table('roles')->where('roles.slug',"mct")->first();
				$rolmct = DB::table('role_users')->where('user_id',$id)->where('role_id',$rmct->id)->first();
				if(is_null($rolmct)){
					DB::table('role_users')->insert(['user_id'=>$id, 'role_id'=>$rmct->id, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				}
			} else {
				$mycount = DB::table('sales_staff')->where('user_id',$id)->where('type',$role)->count();
				if($mycount == 0){
					$sstaff = DB::table('sales_staff')->where('user_id',$id)->where('type',$role)->first();
					if($role=="str"){
						$staff2 = DB::table('station')->where('str_sales_staff_id',$sstaff->id)->update(['str_sales_staff_id'=>0]);
					} else {
						$staff2 = DB::table('mechant')->where('mc_sales_staff_id',$sstaff->id)->update(['mc_sales_staff_id'=>0]);
						$staff2 = DB::table('mechant')->where('referral_sales_staff_id',$sstaff->id)->update(['referral_sales_staff_id'=>0]);
					}
				}
			}
		}
		echo "OK";
	}

    public function openwishProduct(Request $request){

	/*
		$input = $request->all();

		$gst_rate=Globals::first()->gst_rate;
		$mp=DB::table('merchantproduct')->where('product_id',$request->product_id)->first();
		$price = ($request->price - $request->pledged)*100;
		$credit = 0;
		if((float) $price < 0){
			$credit = $price * -1;
			$price = 0;
		}
		$grossPrice= $price;
		$gst=Merchant::find($mp->merchant_id)->gst;
		if (!is_null($gst) and $gst>0) {
			$gstprice= ($gst_rate*$grossPrice);
		}else{
			$gstprice=0;
		}
		$gstprice -= $credit;
		$credit = 0;
		if($gstprice < 0){
			$credit = $gstprice * -1;
			$gstprice = 0;
		}
	*/
        $product = DB::table('product')->where('id',$request->product_id)->first();

        $user_id= Auth::user()->id;

        $ow=OpenWish::where('id',$request->owid)->where('product_id',$request->product_id)->where('status','active')->first();
        if (is_null($ow)) {
            return ;
        }
        try {
            $pledged=OpenWishPledge::where('openwish_id',$ow->id)
                    ->select(DB::raw('
                        SUM(pledged_amt) as amt
                        '))
                    ->first()
                    ->amt;
        } catch (\Exception $e) {
            $pledged=0;
        }

        $p= new PriceController;
        $rawPrice= $p->init($request->product_id,'raw');
        $delivery= $p->init($request->product_id,'delivery');
        $gst= $p->init($request->product_id,'gst');
        $commission=DB::table('global')->first()->ow_commission;
        $rawPrice= $rawPrice+ ($rawPrice*$commission)/100;
        if ($pledged > $rawPrice) {
            return "Could not add this openwish contribution.";
        }
        $price=$rawPrice-$pledged;
        Cart::insert(
            array(
				'id' => $product->id,
				'parent_id' => $product->id,
				'name' => $product->name,
				'price' => $price,
				'delivery_price' =>$delivery,
				'quantity' => '1',
				'image' => $product->photo_1,
				'gst'=>$gst/100,
				'ow_id' => $ow->id,
				'page'=>'openwishbd',
				'mode'=>'owishbn'
            )
        );
        $total_items = Cart::totalItems();
		$price=$price/100;
        $product_name =  $product->name;
        //    Cart::destroy();
        return compact('total_items' , 'product_name', 'price');
    }

    public function approveBuyer() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
            return \App\Classes\AdminApproveHelper::approveUser($inputs);
        }
    }

    //function for saving remarks of station
    public function saveBuyerRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        $res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
            $res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
            echo $res;
        }
        //echo "Hola";
    }

    public function buyer_remarks($id){
        $remarks = DB::select(DB::raw("select remark.remark, IFNULL(nbuyerid.nbuyer_id,LPAD(nbuyerid.nbuyer_id,20,'E')) as nbuyer_id, IFNULL(nb2.nbuyer_id,LPAD(nb2.nbuyer_id,20,'E')) as nadmin_id, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status from remark inner join buyerremark on buyerremark.remark_id = remark.id LEFT JOIN nbuyerid ON buyerremark.buyer_id = nbuyerid.buyer_id LEFT JOIN nbuyerid as nb2 ON remark.user_id = nb2.user_id where buyerremark.buyer_id = " . $id . " order by remark.created_at desc"));

        return json_encode($remarks);
    }

	public function payslipdf(){
		$u = Auth::user();
		$userjust_id = $u->id;

        $userObj = new User();
        $user = User::where('id', $userjust_id)->first();

        try {
            $time= $user->birthdate;
            if ($time!="30/11/-0001") {
            $time=str_replace("/","-",$time);
            $date=date_create($time);
            $now = \Carbon::now();
            // return $now;
            $age = $date->diff($now)->y;
            }
            else {
                $age="";
            }


        } catch (\Exception $e) {

            $age = "";
            echo "<script>console.log('Invalid Birthdate or Birthdate is string in users table');</script>";
        }

		$employee = DB::table('employee')->where('user_id',$userjust_id)->first();
		$payslip = array();
		if(!is_null($employee)){

            $payslip['employeeid'] = $employee->id;
			$userbyid = DB::table('users')->where('id',$userjust_id)->first();
			if(!is_null($userbyid)){
				$payslip['username'] = $userbyid->first_name . " " . $userbyid->last_name;
				$payslip['ismal'] = $userbyid->nationality_country_id;
			}
			$paysliptable = DB::table('payslip')->where('employee_id',$employee->id)->first();
			if(!is_null($paysliptable)){
				$payslip['basic_pay'] = number_format($paysliptable->basic_pay/100,2);
				if(date('m') == date('m', strtotime('+1 week'))){
					$numbermonth = date('n') - 1;
				} else {
					$numbermonth = date('n');
				}
				$payslip['basic_pay_ytd'] = number_format(($paysliptable->basic_pay*$numbermonth)/100,2);
				$payslip['bonus'] = number_format($paysliptable->bonus/100,2);
				$ismal = true;
				if(isset($payslip['ismal'])){
					if($payslip['ismal'] != 2){
						$ismal = false;
					}
				}
				$payslip['gross'] = number_format(($paysliptable->bonus+$paysliptable->basic_pay)/100,2);
				$payslip['pcb'] = number_format(0,2);
				$payslip['pcb_ytd'] = number_format(0,2);
				if($age < 60){
					$payslip['socso'] = number_format(($paysliptable->basic_pay*0.005)/100,2);
					$payslip['esocso'] = number_format(($paysliptable->basic_pay*0.0175)/100,2);
					$payslip['socso_ytd'] = number_format((($paysliptable->basic_pay*$numbermonth)*0.005)/100,2);
					if($ismal){
						if($paysliptable->basic_pay/100 < 5000){
							$payslip['epf'] = number_format(($paysliptable->basic_pay*0.11)/100,2);
							$payslip['epf_ytd'] = number_format((($paysliptable->basic_pay*$numbermonth)*0.11)/100,2);
							$payslip['eepf'] = number_format(($paysliptable->basic_pay*0.13)/100,2);
						} else {
							$payslip['epf'] = number_format(($paysliptable->basic_pay*0.11)/100,2);
							$payslip['epf_ytd'] = number_format((($paysliptable->basic_pay*$numbermonth)*0.11)/100,2);
							$payslip['eepf'] = number_format(($paysliptable->basic_pay*0.12)/100,2);
						}
					} else {
						$payslip['epf'] = number_format(($paysliptable->basic_pay*0.11)/100,2);
						$payslip['epf_ytd'] = number_format((($paysliptable->basic_pay*$numbermonth)*0.11)/100,2);
						$payslip['eepf'] = number_format(5,2);
					}
				} else {
					$payslip['socso'] = number_format(0,2);
					$payslip['socso_ytd'] = number_format(0,2);
					$payslip['esocso'] = number_format(($paysliptable->basic_pay*0.0125)/100,2);
					if($ismal){
						if($paysliptable->basic_pay/100 < 5000){
							$payslip['epf'] = number_format(($paysliptable->basic_pay*0.055)/100,2);
							$payslip['epf_ytd'] = number_format((($paysliptable->basic_pay*$numbermonth)*0.055)/100,2);
							$payslip['eepf'] = number_format(($paysliptable->basic_pay*0.065)/100,2);
						} else {
							$payslip['epf'] = number_format(($paysliptable->basic_pay*0.055)/100,2);
							$payslip['epf_ytd'] = number_format((($paysliptable->basic_pay*$numbermonth)*0.055)/100,2);
							$payslip['eepf'] = number_format(($paysliptable->basic_pay*0.06)/100,2);
						}
					} else {
						$payslip['epf'] = number_format(($paysliptable->basic_pay*0.055)/100,2);
						$payslip['epf_ytd'] = number_format((($paysliptable->basic_pay*$numbermonth)*0.055)/100,2);
						$payslip['eepf'] = number_format(5,2);
					}
				}
                $netin = $payslip['basic_pay'] - ($payslip['epf']+$payslip['socso']+$payslip['pcb']);
                $basicytd = str_replace(",","",$payslip['basic_pay_ytd']);
                //dd($basicytd);
                //exit;
                $netin_ytd = $basicytd  - ($payslip['epf_ytd']+$payslip['socso_ytd']+$payslip['pcb_ytd']);
                $payslip['net'] = number_format($netin,2);
                $payslip['net_ytd'] = number_format($netin_ytd,2);
			}

			/*dd($employee);
			exit;	*/
		}

		$view =  \View::make('employee.payslipdf', compact('payslip'))->render();

		$pdf = App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		return $pdf->stream();
	}

	public function getLikes($id)
    {
        $likes = DB::select(DB::raw("SELECT users.last_name as last_name,users.first_name as first_name,  DATE_FORMAT(usersproduct.created_at,'%d%b%y %H:%i') as since, 			
									usersproduct.product_id as product_id , IFNULL(nproductid.nproduct_id,LPAD(usersproduct.product_id,16,'E')) as nproduct_id
									FROM users, usersproduct
									LEFT JOIN nproductid ON usersproduct.product_id = nproductid.product_id
									WHERE users.id = usersproduct.user_id AND users.id=".$id." ORDER BY usersproduct.created_at DESC"));

		return json_encode($likes);
    }
	
	    public function getOcredit($id)
    {
        
        $opencredits=OpenCreditController::get_ocredit($id);
        return json_encode($opencredits);
	
	}

    public function validate_email($email)
    {
        $code = 1;
        $validation = DB::table('users')->where('email',$email)->whereNull('deleted_at')->get();
        if(count($validation) > 0){
            $code = 0;
        }

         return $code;
    }
    public function cancelBuyerOrder(Request $request){
        $po = DB::table('porder')->where('id', $request->id)->first();
        $product = DB::table('orderproduct')->where('porder_id', $request->id)->select('product_id')->first();
        $lessThenHour = UtilityController::cancelTime($po->created_at);
        if($lessThenHour == 'yes'){ // Auto approve in first hour
            DB::table('porder')->where('id', $request->id)->update(['status' => 'cancelled']);
            DB::table('orderproduct')->where('porder_id', $request->id)->update(['status' => 'cancelled']);
            DB::table('cre')->insert(array(
                'user_id' => $po->user_id,
                'type' => 'cancel',
                'status' => 'success',
                'crereason_id' => '',
                'product_id' => $product->product_id,
                'created_at' => (Carbon::now())
            ));
            return response()->json(['responseText' => 'Success!'], 200);
        }else{
            DB::table('porder')->where('id', $request->id)->update(['status' => 'cancelreq']);
            DB::table('orderproduct')->where('porder_id', $request->id)->update(['status' => 'b-returning1']);
            return response()->json(['responseText' => 'Error'], 500);
        }
    }
    public function storeReturnDetails(Request $request){
        if($request->ajax()){
            for($i = 1; $i <= $request->len; $i++):
                $name ='img'.$i;
                $files[$i] = $request->$name;
            endfor;
            $po = DB::table('porder')->where('id', $request->id)->select('user_id')->first();
            $product = DB::table('orderproduct')->where('porder_id', $request->id)->select('product_id')->first();
            $data = array(
                'user_id' => $po->user_id,
                'type' => 'return',
                'status' => 'success',
                'crereason_id' => $request->reason,
                'product_id' => $product->product_id,
                'created_at' => (Carbon::now())
            );
            $cre_id = DB::table('cre')->insertGetId($data);
            DB::table('porder')->where('id', $request->id)->update(['status' => 'b-returning']);
            DB::table('orderproduct')->where('porder_id', $request->id)->update(['status' => 'b-returning1']);
            DB::table('remark')->insert(array(
                'user_id' => $po->user_id,
                'status' => '',
                'remark' => $request->remarks,
                'created_at' => (Carbon::now())
            ));
            $destinationPath = 'images/cre/'.$cre_id;
            if(!empty($files)):
                try{
                    File::makeDirectory('images/cre/'.$cre_id, 0775, true);
                }catch(Exception $e){
                    $msg =  "Already";
                }
                foreach($files as $file):
                    $fileName = $file->getClientOriginalName();
                    $file->move($destinationPath, $fileName);
                    //    Storage::put($file->getClientOriginalName(),file_get_contents($file));
                endforeach;
                return response()->json(['responseText' => 'Success!'], 200);
            endif;
            return response()->json(['responseText' => 'Error'], 500);
        }else{

            return back();
        }
    }
 
     public function buyer_complain_order($order_id)

    {
        // try {
        //     $order_id=$r->id;
        // } catch (\Exception $e) {
        //     return response()->json(['status' => 'failure','short_message'=>'Bad Data','long_message'=>'An illegel method was encountered.']);
        // } Not needed as converted from post to get
        // Check if order_id is still eligible for cancellationr request
        // Check if the user_id is the one setting the order id
        if (!Auth::check()) {
            return response()->json(['status' => 'failure','short_message'=>'Request Failed','long_message'=>'A request for order cancellation cannot be placed #001']);
        }
        try {
            $porder=POrder::find($order_id);
			$porder->status="complained";
			$porder->save();
			POrder::where('id',$order_id)->update(['status'=>'complained']);

			return response()->json(['status' => 'success','short_message'=>1,'long_message'=>'Complained Order: '.$order_id]);
            
        } catch (\Exception $e) {
            return $e;
            return response()->json(['status' => 'failure','short_message'=>'Server Error','long_message'=>'Something went wrong.Please try later.']);
        }
    }
 
 
    public function buyer_cancel_order($order_id)

    {

        // Check if order_id is still eligible for cancellationr request
        // Check if the user_id is the one setting the order id
        if (!Auth::check()) {
            return response()->json(['status' => 'failure','short_message'=>'Request Failed','long_message'=>'A request for order cancellation cannot be placed #001']);
        }
        try {
            $porder=POrder::find($order_id);
            // return $porder;
            $timestamp=$porder->created_at; //This line will give us an exception if there is no record for the order_id. So donot ignore the exception

            $can_Cancel=UtilityController::cancelTime($timestamp); //Is the buyer eligible to cancel the order?
            // return $can_Cancel;
            $can_Cancel_2=False;
            if (!is_null($porder)) {
                $user_id=Auth::user()->id; // This is where we check the db modification rights 
                if ($porder->user_id==$user_id) {
                        $can_Cancel_2=True;
                    }    
            }
            if ($can_Cancel=="yes" and $can_Cancel_2==True) {
             
                OrderProduct::where('porder_id',$order_id)->update(['status'=>'b-cancelled']);
                POrder::where('id',$order_id)->update(['status'=>'b-cancelled']);

                $c= New Cre;
                $c->user_id=$user_id;
                $c->type='cancel';
                $c->porder_id=$order_id;
                $c->status='success';
                $c->save();
				
				$newid = UtilityController::generaluniqueid($c->id, '9','1', $c->created_at, 'ncreid', 'ncre_id');
				DB::table('ncreid')->insert(['ncre_id'=>$newid, 'cre_id'=>$c->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);		
                // EmailController

                // Add in Ocredit
                /*$oc_amount= Payment::join('porder as p','p.payment_id','=','payment.id')
                        ->where('p.id',$order_id)
                        ->select('payment.receivable as r')->first()->r;*/
				$oc_amount = 0;
				$orderproducts = DB::table('orderproduct')->where('porder_id',$order_id)->get();
				foreach($orderproducts as $orderproduct){
					$total = ($orderproduct->order_price * $orderproduct->quantity) + $orderproduct->order_delivery_price;
					$oc_amount += $total;
				}
                $oc= new Ocredit;
                $sidg= new SecurityIDGenerator;
                $security_id= $sidg->generate(Carbon::now()->toDateString());
                $oc->security_id=$security_id;
                $oc->value=$oc_amount;
                $oc->porder_id=$order_id;

                $oc->cre_id=$c->id;
                $oc->source="cre";
                $oc->mode="credit";
                $oc->status="success";
                $oc->save();
                OpenCreditController::save_nocredit_id($oc);
                EmailController::sendOrderCancelMail($order_id);
                return response()->json(['status' => 'success','short_message'=>1,'long_message'=>'Cancelled Order: '.IdController::nO($order_id)]);
            }
            if ($can_Cancel=="no" or $can_Cancel_2==False) {
                // OrderProduct::where('porder_id',$order_id)->update(['status'=>'cancelreq']);
                // POrder::where('id',$order_id)->update(['status'=>'cancelreq']);
                // $c= New Cre;
                // $c->user_id=$user_id;
                // $c->type='cancel';
                // $c->porder_id=$order_id;
                // // $c->crereason_id=?
                // $c->status='pending';

                // $c->save();
                return response()->json(['status' => 'failure','short_message'=>2,'long_message'=>'A request for cancellation cannot be placed.']);
            }
            
        } catch (\Exception $e) {
            return $e;
            return response()->json(['status' => 'failure','short_message'=>'Server Error','long_message'=>'Something went wrong.Please try later.']);
        }
    }
    public function init_return_modal($porder_id)
    {
        /*
            product array should be like this :
            {product_id:return reason}
        */
        // $porder_id=$r->order_id;
        // Get all product_ids from orderproduct using the order id
        $product_ids=array();
        $products=array();
        $cre_reasons=array();
        if (!Auth::check()) {
            # code...
            return view('buyer.order.return')
            ->with('products',$products)
            ->with('cre_reasons',$cre_reasons)
            ->with('order_id',$porder_id)
            ->with('message','You are not authorized to view the transaction');
        
        }

        $user_id=Auth::user()->id;

        if (POrder::where('id',$porder_id)->pluck('user_id')!=$user_id) {
            # code...
            return view('buyer.order.return')
            ->with('products',$products)
            ->with('cre_reasons',$cre_reasons)
            ->with('order_id',$porder_id)
            ->with('message','You are not authorized to view the transaction');
                       
        }
        try {
            $product_ids=OrderProduct::where('porder_id',$porder_id)->lists('product_id');
            $products=Product::whereIn('id',$product_ids)->get();
            $cre_reasons=DB::table('crereasons')->get();
        } catch (\Exception $e) {
            return $e;
        }

        
        return view('buyer.order.return')
        ->with('products',$products)
        ->with('cre_reasons',$cre_reasons)
        ->with('order_id',$porder_id);
    
    }
    public function buyer_does_return(Request $r)
    {
        $MAX_CRE_COUNT=0;
        if (!Auth::check()) {
            # code...
            return response()->json(['status' => 'failure','short_message'=>-2,'long_message'=>'Something went wrong.Please try later.']);
        }
        $user_id=Auth::user()->id;

        $product_reason_array=json_decode($r->p_r_a);
        $order_id=$r->oid;
        $pc= $r->photo_counter;

        // return $pc;
        $comment=$r->comment;
        $op_copy=OrderProduct::where('porder_id',$order_id)->get();
        $temp_porder=POrder::find($order_id);
        // return $temp_porder;
        $porder= POrder::find($order_id);

        if ($porder->user_id!=$user_id or $pc==0 or count($product_reason_array)==0) {
            return response()->json(['status' => 'failure','short_message'=>-3,'long_message'=>'Something went wrong.Please try later.']);

        }
        /* if porder.cre_count != 0 the cre request cannot be placed. Check migration file for porder */ 
        if ($porder->status=="b-returning" or $porder->cre_count>0) {
            # code...
            return response()->json(['status' => 'failure','short_message'=>-4,'long_message'=>'Return already requested']);
        }

        /*Time Based Validation*/
         
        try {
            
                $c= New Cre;
                $c->user_id=$user_id;
                $c->type='return';
                $c->porder_id=$order_id;
                // $c->crereason_id=?
                $c->status='pending';

                $c->save();

                $cc= new CreComment;
                $cc->cre_id=$c->id;
                $cc->comment=$comment;
                $cc->save();/**/
				$newid = UtilityController::generaluniqueid($c->id, '9','1', $c->created_at, 'ncreid', 'ncre_id');
				DB::table('ncreid')->insert(['ncre_id'=>$newid, 'cre_id'=>$c->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);		
            // pid ->product_id ; cid->creareadon_id
            foreach ($product_reason_array as $pid => $cid) {
                OrderProduct::where('porder_id',$order_id)->where('product_id',$pid)
                ->update(['status'=>'b-returning1','crereason_id'=>$cid,'cre_id'=>$c->id]);
            }

            /*  Paul on 25 April 2017 at 8 pm
            Modified ::where to ::find TO RAISE updated event on Model POrder...
            When we use ->where, updated event is not fired but
            when we use ->find, updated event will be fired
            events are present in EventServiceProvider  */
            //POrder::where('id',$order_id)->update(['status'=>'b-returning1','cre_count'=>1]);

            POrder::find($order_id)->update(['status'=>'b-returning','cre_count'=>1]);

            // Store Images
            $path=public_path()."/images/cre/".$c->id."/";
            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }
            for ($i=0; $i <intval($pc) ; $i++) { 
                try {
                    if (!is_null($r->file('photo_'.strval($i+1)))) {
                        $extension = $r->file('photo_'.strval($i+1))->getClientOriginalExtension();
                        $fileName = rand(11111,99999).time().'.'.$extension;
                        $r->file('photo_'.strval($i+1))->move($path, $fileName);
                        // Create Document
                        $dc= new Document;
                        $dc->name="cre";
                        $dc->description="return";
                        $dc->path=$fileName;
                        $dc->save();
                        $cr= new CreDocument;
                        $cr->cre_id=$c->id;
                        $cr->document_id= $dc->id;
                        $cr->save();

                    }
                    
                } catch (\Exception $e) {
                 dump($e);   
                }
                
                
            }
            return response()->json(['status' => 'success','short_message'=>'Request Success','long_message'=>'Your return request has been placed via CRE ID '.ID::nCre($c->id)." ."]);
        } catch (\Exception $e) {
            return $e;
            // Rollbacks
            // DB::table('cre')->where('porder_id',$order_id)->update(['status'=>$cre_copy->status]);
            Cre::destroy($c->id);
            foreach ($op_copy as $o) {
                OrderProduct::where('porder_id',$order_id)->where('product_id',$o->product_id)->update(['status'=>$o->status,'crereason_id'=>$o->crereason_id]);

            }
            return response()->json(['status' => 'failure','short_message'=>'Server Error','long_message'=>'Something went wrong.Please try later.']);
        }
        // ----------------------

    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function companylocation(Request $r,$uid=NULL)
    {
    	$ret=array();
    	$ret["status"]="failure";
    	if(!Auth::check()){return "";}
    	$user_id=Auth::user()->id;
    	if(!empty($uid) and Auth::user()->hasRole("adm")){
    		$user_id=$uid;
    	}
    	try{
    		$type=$r->type;
    		switch ($type) {
    			case 'user_id':
    				# code...
    				$merchant_user_id=$r->user_id;

//    				$data=DB::table("fairlocation")
//    				->whereNull("deleted_at")
//    				->where("user_id",$merchant_user_id)
//    				->get()
//    				;
                    $company = DB::table('company')->where('owner_user_id', $merchant_user_id)->first();
                    $data =  DB::select(DB::raw("select f.location, f.id from locationusers lu,
                                fairlocation f, users u, company c
                                where f.user_id=c.owner_user_id and lu.location_id=f.id
                                and lu.user_id=u.id and u.id=$user_id and c.id=$company->id"));

                    //dd($data);

    				$ret["status"]="success";
    				$ret["data"]=$data;
    				return response()->json($ret);
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
    
    public function get_roles($location_id,$uid=NULL)
    {
    	$ret=array();
    	$ret["status"]="failure";
    	if(!Auth::check()){return "";}
    	$user_id=Auth::user()->id;
    	if(!empty($uid) and Auth::user()->hasRole("adm")){
    		$user_id=$uid;
    	}
    	try{
    		$owner_user_id=DB::table("fairlocation")->where("id",$location_id)
    		->whereNull('deleted_at')->pluck('user_id');
    		if (empty($owner_user_id)) {
    			# code...
    			return "bad location";
    		}
    		$company_id=DB::table('company')->whereNull('deleted_at')
    		->where('owner_user_id',$owner_user_id)
    		->pluck('id');
    		if (empty($company_id)) {
    			# code...
    			return "bad company";
    		}
    		$data=DB::table('role_users')
    		->join('roles','roles.id','=','role_users.role_id')
		    ->where('role_users.company_id',$company_id)
		    ->where('role_users.user_id',$user_id)
		    ->whereNull('role_users.deleted_at')
		    ->select('roles.slug')
		    ->get();
    		/*Create options*/

    		$ret["status"]="success";
    		$ret["data"]=$data;
    	}
    	catch(\Exception $e){
    		$ret["short_message"]=$e->getMessage();
    		Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
    	}
    	return response()->json($ret);
    }

    
}
