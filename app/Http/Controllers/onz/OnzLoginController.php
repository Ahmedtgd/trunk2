<?php namespace App\Http\Controllers\onz;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Hashing\Hasher;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Merchant;
use Illuminate\Support\Facades\Hash;
use Response;
use App\Http\Controllers\UtilityController;
use Illuminate\Support\Facades\Session;
use App\Models\RoleUser;
use App\Models\Station;
use App\Models\Album;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Profile;
use App\Models\Buyer;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Log;
use App\Http\Controllers\EmailController;
use Carbon;
class OnzLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     754
     */
    public $onz_merchant_user_id;
    function __construct($foo = null)
    {
        $this->onz_merchant_user_id =env("ONZ_MERCHANT_USER_ID",754);
    }

    public function onz_login(Request $request)
    {
        $credentials = $request->only('email' );
		$onz_dealer = null;

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {

            Log::info("something went wrong whilst attempting to encode the token");
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $onz_merchant_user_id=$this->onz_merchant_user_id;

        $user=User::where('email',$request->email)->first();
        if ($user->id==$onz_merchant_user_id) {
            # code...
            /*Skip the checking or do something else*/
        }else{
            /*Check if has onz access*/
            $onz_merchant_id=DB::table("merchant")->where("user_id",$onz_merchant_user_id)->whereNull('deleted_at')->pluck("id");
            $onz_dealer=DB::table("merchant")->where("user_id",$user->id)
            ->whereNull('deleted_at')->first();
            $onz_dealer_id=$onz_dealer->id;

            /*Is approved*/
            if ($onz_dealer->status=="pending") {
                # code...
                return response()->json(['error' =>1,'long_message'=>'You are not approved yet.'], 200);

            }

            if ($onz_dealer->emailconfirm!=1) {
                # code...
                return response()->json(['error' =>2,'long_message'=>'Please confirm your email address.'], 200);
            }

            $is_onz=DB::table('onzmerchant')
            ->where('onz_owner_merchant_id',$onz_merchant_id)
            ->where('user_merchant_id',$onz_dealer_id)
            ->whereNull('deleted_at')
            ->where('status','active')
            ->first();


            if (empty($is_onz)) {
                Log::info("User has no onz. Merchant_ID ".$onz_merchant_id." Dealer's Merchant ID ".$onz_dealer_id);
                return response()->json(['error' => 'no onz access'], 500);
            }
        }

        // all good so return the token
        return response()->json(compact('token','user','onz_dealer'));
    }



    public function login($user_id)
    {

        $user = User::find($user_id);

        $token = JWTAuth::fromUser($user);
        return response()->json(compact('token','user'));

    }

    function onzloginpage($username=null,$password=null){
		$user = JWTAuth::parseToken()->authenticate();
        if (!empty($user)) {
           Auth::logout();
           Session::put('mode','onz');

            Auth::loginUsingId($user->id, true);

            return redirect('sellermembers');
        }

		return json_encode(['email'=>""]);

    }

    function onzregistration(Request $req){

        $mps_user_id=$this->onz_merchant_user_id;

        $onz_owner_merchant=Merchant::where("user_id",$mps_user_id)->first();
        $onz_owner_merchant_id=$onz_owner_merchant->id;
        $messages = [
            'email.required' => 'We need to know your e-mail address!',
            'email.unique' => 'Email already exist ',
        ];
        //Need email validation here
        $validtion = Validator::make($req->all(),[
            'email' => 'required|email|unique:users',
            'password'=>'required|'
        ],$messages); //

        if($validtion->fails()) {
            return 'We need to know your e-mail address!';

        } else {
            try {
                  /*Create Address*/
                $a= new Address;
                $a->line1=$req->line1;
                $a->line2=$req->line2;
                $a->line3=$req->line3;
                $address=$req->line1." ".$req->line2." ".$req->line3;
                $city_id=$this->get_city_id($address);
                $a->line4="MALAYSIA";
                $a->city_id=$city_id;
                //$a->postcode=$req->postcode;
                $a->save();
                $address_id=$a->id;

                $user_data = array(
                'first_name' => $req->firstname,
                'last_name' => $req->lastname,
                'email' => $req->email,
                'mobile_no'=>$req->mobile,
                'password' =>bcrypt($req->password),
                'default_address_id'=>$address_id,
                'shipping_address_id'=>$address_id,
                'billing_address_id'=>$address_id,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
                );
                $user_id=DB::table('users')->insertGetId($user_data);

                Log::debug($req);
                $merchant = new Merchant();
                $merchant->user_id=$user_id;
                $merchant->status="pending";
                $merchant->company_name=$req->company_name;
                $merchant->membership=$req->membership;
                $merchant->referral_code=$req->referral_code;
                $merchant->address_id=$address_id;
                $merchant->save();


                /*Add ONZ*/
                DB::table('onzmerchant')
                ->insert([
                    'onz_owner_merchant_id'=>$onz_owner_merchant_id,
                    'user_merchant_id'=>$merchant->id,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ]);
                /*Add role*/
                DB::table("role_users")
                ->insert(
                    [
                        'user_id'=>$user_id,
                        'role_id'=>3,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')
                    ]
                );
                $nseller_id=UtilityController::selleruniqueid($city_id);
                DB::table('nsellerid')
                ->insert(
                    [
                        'user_id'=>$user_id,
                        'nseller_id'=>$nseller_id,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')
                    ]
                );

                /*Add Company*/
                $sysname=UtilityController::sysname($req->company_name);
                DB::table("company")
                ->insert(
                    [
                        'owner_user_id'=>$user_id,
                        'company_name'=>$req->company_name,
                        'sysname'=>$sysname,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')
                    ]
                );


                /*Create Station*/
                 DB::table("station")
                ->insert(
                    [
                        'user_id'=>$user_id,
                        'company_name'=>$req->company_name,
                        'status'=>'pending',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')
                    ]
                );
                /*Autolink with MPS*/
                DB::table('autolink')
                ->insert([
                    'initiator'=>$user_id,
                    'status'=>'linked',
                    'responder'=>$onz_owner_merchant_id,
                    'linked_since'=>date('Y-m-d H:i:s'),
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ]);
                /*Send Email*/
                return "ok";
               /* $e= new EmailController();
                $e->merchantOnboard($req->email);
                return $this->login($user_id);*/

            } catch (\Exception $e) {

                Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
                return "failure";
            }

        }
    }
    public function onz_logout()
    {
        Auth::logout();
        $url="http://mpstele.my/partner/logout";
        /*$url="http://localhost:8000/partner/logout";*/
        return redirect()->away($url);
    }

    public function onz_forgot_password(Request $r)
    {
		$ret = false;
        $mode=$r->mode;
        $email=$r->email;
        $user=User::where("email",$email)->first();
        if ($user) {
			$merchant=Merchant::where("user_id",$user->id)->
					where('status','active')->first();
            if($merchant ){
                $is_onz=1;
                if ($is_onz==1) {
                    Log::info("Sending onz forgot_password email. Stage1");
                    $e=new EmailController;
                    $e->passwordReset($email,$mode);
					$ret = "success";
                }
            }else{
				Log::error("forgot_password():".$email." is not active yet");
            }
        }
        return $ret;
    }

    public function is_onz($merchant_id)
    {
        $ret=0;
        $onz=DB::table("onzmerchant")
        ->where("user_merchant_id",$merchant_id)
        ->whereNull("deleted_at")
        ->first();
        if (!empty($onz)) {
            # code...
            $ret=1;
        }
        return $ret;
    }

    public function get_city_id($address)
    {
        # code...
        $cities=DB::table('city')->where('country_code','MYS')

                ->select('name')->get();
        $cityArray = array_map(function ($value) {

                   return $value->name;
                }, $cities);
        $city_name=UtilityController::arraystrmatch($cityArray,$address);

        $city_id=DB::table('city')->where('country_code','MYS')
        ->where('name',$city_name)->pluck('id');
        Log::debug($city_id);
        return $city_id;
    }
}
