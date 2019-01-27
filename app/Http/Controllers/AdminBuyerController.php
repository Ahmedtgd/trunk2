<?php
namespace App\Http\Controllers;
use App\Models\Autolink;
use App\Models\Address;
use App\Models\Bank;
use App\Models\BuyerCreditCard;
use App\Models\BuyerAddress;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\Buyer;
use App\Models\Credit;
use App\Models\RoleUser;
use App\Models\UserCategory;
use App\Models\BuyerCategory;
use App\Models\BankAccount;
use App\Models\Porder;
use App\Models\BuyerBankAccount;
use App\lib\Date;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\OpenWish;
use App\Models\OpenWishPledge;
use App\Models\Product;
use App\Models\SMMin;
use App\Models\SMMout;
use App\Models\Website;
use App\Models\Document;
use App\Models\MerchantDocument;
use App\Models\Occupation;
use App\Models\Language;
use App\Models\Payment;
use App\Models\Courier;
use Exception ;
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
use Redirect;
use Hash;
use Image;
// use String;
use View;
use File;

class AdminBuyerController extends Controller
{

  /**
     * Get all Buyers
     *
     * @method Ajax Get
     */
    public function getBuyers() {
         if(!Auth::check()) return redirect('/');

        $languages   = DB::table('language')->get();
        $occupations = DB::table('occupation')->get();
        $interests   = DB::table('category')->get();
        $banks       = DB::table('bank')->get();
        $payments    = DB::table('payment')->get();
        $courier     = DB::table('courier')->get();
         //$buyers   = Buyer::with('user','buyer_bank')->get();
         $buyers     = DB::table('buyer')
                       ->leftJoin('users', 'users.id', '=', 'buyer.user_id')
                       ->leftJoin('buyerbankaccount', 'buyer.id', '=', 'buyerbankaccount.buyer_id')
                       ->leftJoin('bankaccount', 'bankaccount.id', '=', 'buyerbankaccount.bankaccount_id')
                       ->leftJoin('bank', 'bank.id', '=', 'bankaccount.bank_id')
                       ->leftJoin('buyercredit_card', 'buyer.id', '=', 'buyercredit_card.buyer_id')
                       ->leftJoin('credit_card', 'buyercredit_card.credit_card_id', '=', 'credit_card.id')
                       ->leftJoin('country', 'users.nationality_country_id','=','country.id')
                       ->leftJoin('city', 'city.country_code','=','country.code')
                       ->leftJoin('role_users', 'role_users.user_id','=','users.id')
                       ->leftJoin('roles', 'roles.id','=','role_users.role_id')
            ->select(
                      'buyer.*', 'users.*','buyerbankaccount.*','bankaccount.*','buyercredit_card.*',
                      'credit_card.*','country.code','country.name as country_name','city.name as city_name',
                      'role_users.role_id', 'roles.name as role_name','bank.name as bank_name',
                      'bank.code as bank_code'
               )

             ->groupBy('buyer.id')
            ->get();

        //dd($buyers);exit;
         return view('admin.BuyerMgmt', array('buyers' => $buyers,'languages' => $languages, 'occupations' => $occupations, 'interests' => $interests, 'banks' => $banks, 'courier' => $courier, 'payments' => $payments));


    }
     public function getBuyerSmm() {
         if(!Auth::check()) return redirect('/');

        $languages   = DB::table('language')->get();
        $occupations = DB::table('occupation')->get();
        $interests   = DB::table('category')->get();
        $banks       = DB::table('bank')->get();
        $payments    = DB::table('payment')->get();
        $courier     = DB::table('courier')->get();
         //$buyers   = Buyer::with('user','buyer_bank')->get();
         $buyers     = DB::table('buyer')
                       ->leftJoin('users', 'users.id', '=', 'buyer.user_id')
                       ->leftJoin('buyerbankaccount', 'buyer.id', '=', 'buyerbankaccount.buyer_id')
                       ->leftJoin('bankaccount', 'bankaccount.id', '=', 'buyerbankaccount.bankaccount_id')
                       ->leftJoin('bank', 'bank.id', '=', 'bankaccount.bank_id')
                       ->leftJoin('buyercredit_card', 'buyer.id', '=', 'buyercredit_card.buyer_id')
                       ->leftJoin('credit_card', 'buyercredit_card.credit_card_id', '=', 'credit_card.id')
                       ->leftJoin('country', 'users.nationality_country_id','=','country.id')
                       ->leftJoin('city', 'city.country_code','=','country.code')

                       ->leftJoin('role_users', 'role_users.user_id','=','users.id')
                       ->leftJoin('roles', 'roles.id','=','role_users.role_id')
                       ->leftJoin('porder', 'users.id','=','porder.user_id')

                       ->leftJoin('smmin', 'smmin.porder_id','=','porder.id')

                       ->leftJoin('smmout', 'smmout.id','=','smmin.smmout_id')
                      // ->leftJoin('porder', 'smmin.porder_id','=','porder.id')
                       ->leftJoin('orderproduct', 'orderproduct.porder_id','=','porder.id')
                       ->leftJoin('product', 'product.id','=','orderproduct.product_id')
                     //  ->leftJoin('users as pusers', 'pusers.id', '=', 'porder.user_id')
                     //  ->leftJoin('buyer', 'buyer.user_id', '=', 'pusers.id')



            ->select(
                      'buyer.*', 'users.*','buyerbankaccount.*','bankaccount.*','buyercredit_card.*',
                      'credit_card.*','country.code','country.name as country_name','city.name as city_name',
                      'role_users.role_id', 'roles.name as role_name','bank.name as bank_name',
                      'bank.code as bank_code','product.name as productname',
                       'orderproduct.quantity', 'orderproduct.status as orderstatus'
               )

            ->groupBy('buyer.id')
            ->get();

        //dd($buyers);exit;
         return view('admin.BuyerSmm', array('buyers' => $buyers,'languages' => $languages, 'occupations' => $occupations, 'interests' => $interests, 'banks' => $banks, 'courier' => $courier, 'payments' => $payments));


    }
     public function getBuyerOwish() {
         if(!Auth::check()) return redirect('/');

        $languages   = DB::table('language')->get();
        $occupations = DB::table('occupation')->get();
        $interests   = DB::table('category')->get();
        $banks       = DB::table('bank')->get();
        $payments    = DB::table('payment')->get();
        $courier     = DB::table('courier')->get();
         //$buyers   = Buyer::with('user','buyer_bank')->get();
         $openwish     = DB::table('openwishpledge')
                      /* ->leftJoin('users', 'users.id', '=', 'buyer.user_id')
                       ->leftJoin('buyerbankaccount', 'buyer.id', '=', 'buyerbankaccount.buyer_id')
                       ->leftJoin('bankaccount', 'bankaccount.id', '=', 'buyerbankaccount.bankaccount_id')
                       ->leftJoin('bank', 'bank.id', '=', 'bankaccount.bank_id')
                       ->leftJoin('buyercredit_card', 'buyer.id', '=', 'buyercredit_card.buyer_id')
                       ->leftJoin('credit_card', 'buyercredit_card.credit_card_id', '=', 'credit_card.id')
                       ->leftJoin('country', 'users.nationality_country_id','=','country.id')
                       ->leftJoin('city', 'city.country_code','=','country.code')
                       ->leftJoin('role_users', 'role_users.user_id','=','users.id')
                       ->leftJoin('roles', 'roles.id','=','role_users.role_id')

                       ->leftJoin('openwish', 'openwish.user_id','=','users.id')
                       ->leftJoin('openwishpledge', 'openwishpledge.openwish_id','=','openwish.id')
                       ->leftJoin('openwishsocial_media', 'openwishsocial_media.ow_id','=','openwish.id')*/

                      /* ->leftJoin('porder', 'porder.user_id','=','users.id')
                       ->leftJoin('orderproduct', 'orderproduct.porder_id','=','porder.id')
                       ->leftJoin('product', 'product.id','=','orderproduct.product_id')*/

            ->select(
                      'openwishpledge.*'
               )

           // ->groupBy('buyer.id')
            ->get();

       // dd($openwish);exit;
         return view('admin.BuyerOwish', array('openwish' => $openwish,'languages' => $languages, 'occupations' => $occupations, 'interests' => $interests, 'banks' => $banks, 'courier' => $courier, 'payments' => $payments));


    }
     public function getBuyerDealer() {
         if(!Auth::check()) return redirect('/');

        $languages   = DB::table('language')->get();
        $occupations = DB::table('occupation')->get();
        $interests   = DB::table('category')->get();
        $banks       = DB::table('bank')->get();
        $payments    = DB::table('payment')->get();
        $courier     = DB::table('courier')->get();
         //$buyers   = Buyer::with('user','buyer_bank')->get();
         /*$buyers     = DB::table('buyer')
                       ->leftJoin('users', 'users.id', '=', 'buyer.user_id')
                       ->leftJoin('buyerbankaccount', 'buyer.id', '=', 'buyerbankaccount.buyer_id')
                       ->leftJoin('bankaccount', 'bankaccount.id', '=', 'buyerbankaccount.bankaccount_id')
                       ->leftJoin('bank', 'bank.id', '=', 'bankaccount.bank_id')
                       ->leftJoin('buyercredit_card', 'buyer.id', '=', 'buyercredit_card.buyer_id')
                       ->leftJoin('credit_card', 'buyercredit_card.credit_card_id', '=', 'credit_card.id')
                       ->leftJoin('country', 'users.nationality_country_id','=','country.id')
                       ->leftJoin('city', 'city.country_code','=','country.code')
                       ->leftJoin('role_users', 'role_users.user_id','=','users.id')
                       ->leftJoin('roles', 'roles.id','=','role_users.role_id')
                       ->leftJoin('porder', 'porder.user_id','=','users.id')
                       ->leftJoin('orderproduct', 'orderproduct.porder_id','=','porder.id')
                       ->leftJoin('product', 'product.id','=','orderproduct.product_id')*/
        $buyers     = DB::table('dealer')
                       ->leftJoin('users', 'users.id', '=', 'dealer.user_id')
                      /* ->leftJoin('buyerbankaccount', 'buyer.id', '=', 'buyerbankaccount.buyer_id')
                       ->leftJoin('bankaccount', 'bankaccount.id', '=', 'buyerbankaccount.bankaccount_id')
                       ->leftJoin('bank', 'bank.id', '=', 'bankaccount.bank_id')
                       ->leftJoin('buyercredit_card', 'buyer.id', '=', 'buyercredit_card.buyer_id')
                       ->leftJoin('credit_card', 'buyercredit_card.credit_card_id', '=', 'credit_card.id')
                       ->leftJoin('country', 'users.nationality_country_id','=','country.id')
                       ->leftJoin('city', 'city.country_code','=','country.code')
                       ->leftJoin('role_users', 'role_users.user_id','=','users.id')
                       ->leftJoin('roles', 'roles.id','=','role_users.role_id')
                       */

                       ->leftJoin('autolink', 'autolink.initiator','=','users.id')
                       ->leftJoin('merchant', 'merchant.id','=','autolink.responder')
                       ->leftJoin('porder', 'porder.user_id','=','users.id')
                       ->leftJoin('orderproduct', 'orderproduct.porder_id','=','porder.id')
                       ->leftJoin('product', 'product.id','=','orderproduct.product_id')
                       ->leftJoin('orderproduct as op', 'op.product_id','=','product.id')
                       ->leftJoin('merchantproduct', 'merchantproduct.product_id','=','product.id')
                       ->leftJoin('merchantproduct as mp', 'mp.merchant_id','=','merchant.id')
                      // ->leftJoin('buyer', 'dealer.user_id','=','users.id')

            ->select(
                      /*'buyer.*', 'users.*','buyerbankaccount.*','bankaccount.*','buyercredit_card.*',
                      'credit_card.*','country.code','country.name as country_name','city.name as city_name',
                      'role_users.role_id', 'roles.name as role_name','bank.name as bank_name',
                      'bank.code as bank_code'*/
               )
            // ->groupBy('buyer.id')
             ->groupBy('merchantproduct.merchant_id')

            ->get();

       // dd($buyers);exit;
         return view('admin.BuyerDealer', array('buyers' => $buyers,'languages' => $languages, 'occupations' => $occupations, 'interests' => $interests, 'banks' => $banks, 'courier' => $courier, 'payments' => $payments));


    }
	/*
    public function addBuyer()
    {
         if(!Auth::check()) return redirect('/');

        $languages = DB::table('language')->get();
        $occupations = DB::table('occupation')->get();
        $interests = DB::table('category')->get();
        $banks = DB::table('bank')->get();
        return view('admin.addbuyer', array('languages' => $languages, 'occupations' => $occupations, 'interests' => $interests, 'banks' => $banks));
    }
	*/
    public function storeBuyer(Request $request)
    {
       if(!Auth::check()) return redirect('/');

         if (!$request->isMethod('post')) {
        return "Only POST requests are allowed";
        }
        if (!isset($request)) {
            return "Empty forms are not accepted";
        }
       $validator = Validator::make($request->all(),[
            'username' => 'required|unique:users|max:100|min:7',
            'full_name' => 'required|min:3',
            'dob'=>'required',
            'password' => 'required|max:100|min:7|confirmed',
            'password_confirmation' => 'required',
            'language'=>'required',
            'mobile'=>'required|max:12|min:10',
            'gender'=>'required',
            'photo'=>'required|mimes:jpeg,jpg,png,bmp,gif',
            'default1' => 'required',
            'default2' => 'required',

        ]);


         if ($validator->fails()) {
            return redirect('admin/buyer')
                        ->withErrors($validator)
                        ->withInput();
        }else{
          DB::beginTransaction();

          try {
                $paypal=false;
                $banking=false;
                $opm=false;
                $owbank=false;
                $card=false;
                $billing=false;
                $delivery=false;
                $payment_method_reference_id="empty";
                $default_address = new Address;
                $default_address->line1 = $request->default1;
                $default_address->line2 = $request->default2;
                $default_address->city_id = $request->city_name;
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
                    $address= new Address;
                    $address->line1=$request->billing1;
                    $address->line2=$request->billing2;
                    if ($request->has('billing3')) {
                      $address->line3 = $request->billing3;
                    }
                    if ($request->has('billing4')) {
                      $address->line3 = $request->billing4;
                    }
                  $address->city_id = $request->city_name;

                    $address->save();
                    $billing=true;
                    $billing_reference_id= $address->id;
                }

                if ($request->has('delivery1')) {
                  # code...
                  $shipping_address= new Address;
                  $shipping_address->line1=$request->delivery1;
                  $shipping_address->line2=$request->delivery2;
                  $shipping_address->city_id = $request->city_name;

                  if ($request->has('delivery3')) {
                      $shipping_address->line3 = $request->delivery3;
                    }
                  if ($request->has('delivery4')) {
                      $shipping_address->line3 = $request->delivery4;
                    }
                  $shipping_address->save();
                  $delivery=true;
                  $shipping_reference_id= $shipping_address->id;
                }

                $user = new User;
                $user->username= $request->username;
                $user->name=$request->full_name;
                $user->nric="";
                $user->email=$request->username;
                $user->language_id=$request->language;
                $user->occupation_id= $request->occupation;
                $user->birthdate=$request->dob;
                $user->mobile_no=$request->mobile;
                $user->nationality_country_id=$request->country;
                $user->password=Hash::make($request->password);
                $user->gender=$request->gender;
                $user->annual_income=$request->income;
                if ($request->salutation=='option1') {
                  if ($request->has('otherinput')) {
                    # code...
                         $user->salutation=$request->otherinput;
                  }


                }
                else {
                   $user->salutation=$request->radioInline;
                }

                $user->default_address_id = $default_reference_id;
                if ($billing==true) {
                  # code...
                   $user->billing_address_id=$billing_reference_id;
                }
               if ($delivery==true) {
                 # code...
                   $user->shipping_address_id=$shipping_reference_id;
               }
                 $user->first_name=$request->first_name;
                 $user->last_name=$request->last_name;
                $user->save();

                $user_id= $user->id;

                $buyer_interests = $request->radioInline;
                $interests_array = explode(';', $buyer_interests);

                $subcat_level = $interests_array[0];
                $subcat_id = $interests_array[1];
                $interest = new BuyerCategory;
                $interest->user_id = $user->id;
                $interest->subcat_id = $subcat_id;
                $interest->subcat_level = $subcat_level;
                $interest->save();
                $interest_reference_id=$interest->id;
                // check for payment_method
                if ($request->has('method')) {
                    if ($request->method == 'debit') {
                         $payment_method = New Credit;
                         $payment_method->user_id= $user->id;
                         $payment_method->bank_id = $request->online_banking_bank;
                        // $payment_method->method= $request->method;
                         $payment_method->number = $request->card_number;
                         $payment_method->name = $request->name_on_card;
                         $payment_method->expiry = $request->expiry_date;
                         $payment_method->cvv = $request->cvv;

                         $payment_method->save();
                         $payment_method_reference_id= $payment_method->id;
                         $card= true;
                      }  //debit_r
                    elseif ($request->method == 'online_banking') {
                        $bank = new BankAccount;
                        $bank->bank_id= $request->online_banking_bank;
                        $bank->account_number2=$request->account2;
                        $bank->save();
                        $payment_method_reference_id=$bank->id;
                        $banking=true;
                    }//banking_r
                    else if ($request->method()=='paypal') {
                          $paypal=true;
                    }; //paypal_r
                } //payment method ends
                    if ($request->has('account_bank')) {
                        try {
                          //if payment method above was bank and a bank account instance exists
                            if ($banking==true) {
                              $account = BankAccount::where('id',$payment_method_reference_id);
                              $account->bank_id= $request->account_bank;
                              $account->swift= $request->account_swift;
                              $account->iban= $request->account_iban;
                              $account->account_name1=$request->account_name;
                              $account->account_number1=$request->account_number;
                              $account->save();
                              $bankaccount_reference_id=$payment_method_reference_id;
                              $owbank=true;
                            } //$banking
                            else{
                              throw new Exception("Bank Account Doesn't Exists", 1);

                            } //else
                        } catch (Exception $e) {
                              $account= new BankAccount;
                              $account->bank_id= $request->account_bank;
                              $account->swift= $request->account_swift;
                              $account->iban= $request->account_iban;
                              $account->account_name1=$request->account_name;
                              $account->account_number1=$request->account_number;
                              $account->save();
                              $bankaccount_reference_id=$account->id;
                              $owbank=true;
                        } //catch ends
                    } else {} //????


                $buyer_profile= new Buyer;
                $buyer_profile->user_id = $user->id;
                if ($request->hasFile('photo')) {
                      $r1=str_random(10);
                      $r2=str_random(5);
                      $r3=str_random(2);
                      $pname=$r1.$r2.$r3;
                      $base_path="images/users/";
                      $full_path=$base_path.$user->id;
                      if(!File::exists($full_path)) {
                        File::makeDirectory(public_path($full_path),0775,true);
                      }

                      $img= $request->file('photo');
                      $imgext= $img->getClientOriginalExtension();
                      $name= $pname.".".$imgext;

                        Image::make($img)->save($full_path."/".$name);

                      $buyer_profile->photo_1= $name;
                } //photo
                if ($owbank==true) {
                  # code...
                      $buyer_profile->bankaccount_id = $bankaccount_reference_id;
                      $buyer_profile->company_name=$request->company_name;
                      $buyer_profile->company_reg_no=$request->company_reg_no;
                }//banking
                      $buyer_profile->potential_industry = $request->potential_industry;
                      $buyer_profile->products=$request->products;
                      $buyer_profile->amount=$request->amount;

                $buyer_profile->save();
                $buyer_profile_reference_id= $buyer_profile->id;


                    /* $role = new RoleUser;
                     $role->user_id = $user->id;
                     $role->role_id = '2';
                     $role->save();*/
                 if ($request->has('type')) {
                     $buyer_role = $request->type;
                     $buyer_role_id = DB::table('roles')->where('slug', $buyer_role)->pluck('id');
                     $role = new RoleUser;
                     $role->user_id = $user->id;
                     $role->role_id = $buyer_role_id;
                     $role->save();
                 } //type


                  //Add references in BuyerAddress
                  $bad= new BuyerAddress;
                  $bad->buyer_id=$buyer_profile_reference_id;
                  $bad->address_id=$default_reference_id;
                  $bad->save();
                  $badi= $bad->id;
                  if ($billing==true) {
                    $bab= new BuyerAddress;
                    $bab->buyer_id=$buyer_profile_reference_id;
                    $bab->address_id=$billing_reference_id;
                    $bab->save();
                    $babi= $bab->id;
                  }
                  if ($delivery==true) {
                      $bas= new BuyerAddress;
                      $bas->buyer_id=$buyer_profile_reference_id;
                      $bas->address_id=$shipping_reference_id;
                      $bas->save();
                      $basi=$bas->id;
                  }
                //Add reference in BuyerCreditCard
                  if ($card==true) {
                    $credit= new BuyerCreditCard;
                    $credit->buyer_id= $buyer_profile_reference_id;
                    $credit->credit_card_id=$payment_method_reference_id;
                    $credit->save();
                  }
                                          //  echo '<pre>';print_r($_POST);exit;

                    $buyer_bank= new BuyerBankAccount;
                    $buyer_bank->buyer_id= $buyer_profile_reference_id;
                    $buyer_bank->bankaccount_id=$bankaccount_reference_id;
                    $buyer_bank->save();

                   /* if ( $request->type=='byr' ) {
                        $porder= new Porder;
                        $porder->user_id= $user_id;
                        $porder->courier_id=$request->courier;
                        $porder->address_id=$default_reference_id;
                        $porder->payment_id=$request->payment;
                        $porder->save();
                      }*/


               DB::commit();
               return redirect('admin/buyer')->with('success', 'Buyer added successfully.');;


              }catch (\Exception $e) {
               DB::rollback();
               return redirect()->back()
                                ->withErrors(['errors' => $e->getMessage()]);
             }
          }


    }
   /* orderproduct.product_id=product.id
orderproduct.porder_id=porder.id
porder.user_id=users.id (buyer)
merchantproduct.product_id=product.id
merchantproduct.merchant_id=merchant.id (merchant)*/

       public function editbuyer($buyer_id)
       {
         if(!Auth::check()) return redirect('/');

        $empty="";
        $buyer_info=Buyer::where('id',$buyer_id)->first();
        $user_id= $buyer_info['user_id'];
        $user= User::where('id',$user_id)->first();


       $billing_address= Address::where(['id'=>$user->billing_address_id])->get()[0];//ba

       $default_address= Address::where(['id'=>$user->default_address_id])->get()[0]; //da

       $card= Credit::where('user_id',$user_id)->first();
       $bankaccount_id= $buyer_info['bankaccount_id'];
       $buyer_image=$buyer_info->photo_1;
       $image="images/users/".$user_id."/".$buyer_image;


       $banka= BankAccount::where('id',$bankaccount_id)->first();

       $buyer_bank= DB::table('bank')->where('id' ,$banka->bank_id)->first();

          // return $company_name;
          // return $user->salutation;
        $dob_raw= $user->birthdate;
        $dob_raw=explode("/", $dob_raw);
        $dob=$dob_raw[2]."/".$dob_raw[1]."/".$dob_raw[0];
        $one_buyer =  array('dob'=>$dob,'image'=>$image,'buyer_bank'=>$buyer_bank,'bankaccount'=>$banka,'cardinfo'=>$card,'default_address'=>$default_address,'billing_address'=>$billing_address,'user'=>$user,'buyer_info'=>$buyer_info);
return $one_buyer;
            }



    public function updatebuyer(Request $request){
         if(!Auth::check()) return redirect('/');


       $this->validate($request, [

                  'full_name' => 'min:3',

                  'password' => 'max:100|min:7|confirmed',

                  'language'=>'required',
                  'mobile'=>'required|max:12|min:10',
                  'gender'=>'required',
                  'photo'=>'image',

        ]);   // return $request->dob;
        $buyer_info=Buyer::where('id',$request->buyer_id)->first();
        $user_id= $buyer_info['user_id'];
        $user= User::where('id',$user_id)->first();


        if ($request->hasFile('photo')) {

                      $r1=str_random(10);
                      $r2=str_random(5);
                      $r3=str_random(2);
                      $pname=$r1.$r2.$r3;
                      $base_path="images/users/";
                      $full_path=$base_path.$user_id;
                      try {
                        File::makeDirectory(public_path($full_path),0775,true);
                        // mkdir($full_path);
                      } catch (\Exception $e) {
                        // Folder already exists or some permission issue
                        // DB::rollBack();
                        // return $e;
                      }//trycatch
                      $img= $request->file('photo');
                      $imgext= $img->getClientOriginalExtension();
                      $name= $pname.".".$imgext;
                      try {
                        Image::make($img)->save($full_path."/".$name);
                      } catch (Exception $e) {
                        DB::rollBack();
                        return $e;
                      }

                      $buyer= Buyer::find($buyer_info->id);

                      $buyer->photo_1= $name;
                      $buyer->save();
                    }

                //Card
                  if ($request->method()=="debit") {
                        try{
                                 $card_id= Credit::where('user_id',$user_id)->pluck('id');
                                  $payment_method = Credit::find($card_id);
                                  // $payment_method->user_id= $user->id;
                                  // $payment_method->bank_id = $bank_id;
                                  // $payment_method->method= $request->method;
                                  $payment_method->number = $request->card_number;
                                  $payment_method->name = $request->name_on_card;
                                  $payment_method->expiry = $request->expiry_date;
                                  $payment_method->cvv = $request->cvv; //string added for security

                                  $payment_method->save();
                            }catch(\Exception $e ) {}
                  }
                  elseif ($request->method()=="online_banking") {

                        try {
                          $bank_id = DB::table('buyer')->where('user_id',$user_id)->pluck('bankaccount_id');
                          $bank= BankAccount::find($bank_id);
                          $bank->account_number2=$request->account1;
                          $bank->save();
                        } catch (\Exception $e) {

                        }
                  }

                  // return $card_id;

                //BANK
                //Must be a bank . other wise null error
                $bank_id = DB::table('buyer')->where('user_id',$user_id)->pluck('bankaccount_id');

                // This is bank account
                if ($request->has('account_name')) {
                  # code...
                      try{
                $bank = BankAccount::find($bank_id);
                  $bank->id = $bank_id;
                  $bank->swift= $request->account_swift;
                  $bank->iban= $request->account_iban;
                  $bank->account_name1=$request->account_name;
                  // if (isset($request->account2)) {
                  //     $buyer->account_number2 = $request->account2;
                  // }
                  $bank->account_number1=$request->account_number;
                // $bank->name= $request->account_bank;
                // $bank->code= $request->account_bank_code;
                  $bank->save();
                }catch(\Exception $e){

                }

                }
                  $buyer1= Buyer::find($buyer_info->id);
                  $buyer1->company_name= $request->company_name;
                  $buyer1->potential_industry = $request->potential_industry;
                  $buyer1->products=$request->products;
                  $buyer1->amount=$request->amount;
                  $buyer1->company_reg_no= $request->company_reg_no;
                  $buyer1->save();

               $user1=User::find($user_id);
               try{
               $dai= $user1->default_address_id;
                  $default_address= Address::find($dai);
                  $default_address->line1 = $request->default1;
                  $default_address->line2 = $request->default2;
                  $default_address->line3 = $request->default3;
                  $default_address->line4 = $request->default4;
                  $default_address->city_id = $request->city_name;
                  $default_address->save();
                   }catch(\Exception $e ) {}
                   try {
                $bai= $user1->billing_address_id;
                    $address= Address::find($bai);
                    $address->line1=$request->billing1;
                    $address->line2=$request->billing2;
                    $address->line3=$request->billing3;
                    $address->line4 = $request->billing4;
                    $address->save();
                $sai= $user1->shipping_address_id;
                      $shipping_address=Address::find($sai);
                      $shipping_address->line1=$request->delivery1;
                      $shipping_address->line2=$request->delivery2;
                      $shipping_address->line3=$request->delivery3;
                      $shipping_address->line4 = $request->delivery4;
                      $shipping_address->save();
                       }catch(\Exception $e ) {}
            // ***************************
                $user= User::find($user_id);

                $user->username= $request->username;
                $user->email= $request->username;

                $user->first_name=$request->first_name;
                $user->last_name=$request->last_name;
                $user->name=$request->full_name;
                // $user->nric="";
                // $user->email=$request->username;
                $user->language_id=$request->language;
                $user->nationality_country_id=$request->country;
                // $user->avatar="";
                // $user->provider="";
                // $user->provider_id="";
                // $user->access_token="";
                $user->birthdate=$request->dob;
                $user->mobile_no=$request->mobile;
                // Confirm password. put a if statememnt

                $user->password=Hash::make($request->password);
                // $user->password= $request->password;
                $user->gender=$request->gender;
                $user->annual_income=$request->income;
                        if ($request->salutation=='option1') {
                  if ($request->has('otherinput')) {
                    # code...

                         $user->salutation=$request->otherinput;
                  }


                }
                else {
                   $user->salutation=$request->radioInline;
                }
                // $user->default_address_id="";
                //

                // $user->remember_token="";
                // $user->permissions="";
                // $user->last_login="";
                $user->save();
         //echo '<pre>';print_r($user);exit;


             return redirect('/admin/buyer')->with('success', 'Buyer updated successfully.');



    }

    public function deletebuyer(Request $request){
         if(!Auth::check()) return redirect('/');

        $buyer_id = $request->buyer_id;
        $buyer_info=Buyer::where('id',$request->buyer_id)->first();
        $user_id= $buyer_info->user_id;
        $user= User::where('id',$user_id)->first();

        $role= RoleUser::where('user_id',$user_id)->delete();

        $bcategory= BuyerCategory::where('user_id',$user_id)->delete();

        $baddress= BuyerAddress::where('buyer_id',$buyer_id)->delete();
         //echo $user->default_address_id.'---'. $user->billing_address_id.'---'. $user->shipping_address_id;
        $address= Address::destroy([$user->default_address_id, $user->billing_address_id, $user->shipping_address_id]);

        $bcredit= BuyerCreditCard::where('buyer_id',$buyer_id)->delete();

        $credit= Credit::where('user_id',$user_id)->delete();
        $bbankaccount= BuyerBankAccount::where('buyer_id',$buyer_id)->first();
        $bbankcount= BuyerBankAccount::where('buyer_id',$buyer_id)->count();
         if($bbankcount>0) {

        $bbank= BankAccount::where('id',$bbankaccount->bankaccount_id)->delete();
         }
        $bbankaccount= BuyerBankAccount::where('buyer_id',$buyer_id)->delete();

        $delete_buyer = Buyer::destroy($buyer_id);
        $delete_buyer = User::where('id',$user_id)->delete();

       return redirect('/admin/buyer')->with('success', 'Buyer deleted successfully.');
;




    }

}
