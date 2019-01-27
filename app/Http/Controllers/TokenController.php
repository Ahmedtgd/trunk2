<?php

namespace App\Http\Controllers;

use App\AuthenticateUser;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\SalesStaff;
use App\Models\SMMout;
use App\Models\Usertoken;
use DB;
use Session;
use Facebook;
use Yajra\Datatables\Facades\Datatables;

//use string;


// Pseusdo Code:

/*
To Automate the best way is to start from function testfbtoken
I have used the token from oauth_session(You can or may use token from User's accesstoken !Not Recomennded)
The function has a way to tell if the access token exists or is expired.
But the function only returns a text response on any error./
What you need to do is to use the  connect function on any error
So suppose if there is no token in oauth_session or the token has expired , you use the connect function to 
generate a facebook link. On clicking the link the user will be able to add/update the token


*/

// helper
function curl_get_file_contents($URL) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($c, CURLOPT_POST,TRUE);
    $contents = curl_exec($c);
    $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
    curl_close($c);
    if ($contents) return $contents;
    else return FALSE;
}

class TokenController extends Controller
{

    public static function connect()
    {
           

		$login_url = Facebook::getLoginUrl(['email','publish_actions','user_friends']);
        // Please dont return the login_url. This code serves a functionality. changing it breaks the other dependant code.
           // return $login_url;
        return redirect($login_url);
		return  '<a href="' . $login_url . '" class="btn ">Click here to connect</a>';
    }
    public function checkLogin()
    {
        
    }
    public function callback()
    {
         // Obtain an access token.
    try {
        $token = Facebook::getAccessTokenFromRedirect();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {

        dd($e->getMessage());
    }
    // Access token will be null if the user denied the request
    // or if someone just hit this URL outside of the OAuth flow.
    if (! $token) {
        // Get the redirect helper
        $helper = Facebook::getRedirectLoginHelper();

        if (! $helper->getError()) {
            abort(403, 'Unauthorized action.');
        }

        // User denied the request
        dd(
            $helper->getError(),
            $helper->getErrorCode(),
            $helper->getErrorReason(),
            $helper->getErrorDescription()
        );
    }
    Session::put('token_tries',0);
    if (! $token->isLongLived()) {
        // OAuth 2.0 client handler
        $oauth_client = Facebook::getOAuth2Client();
        // Extend the access token.
        try {
            $token = $oauth_client->getLongLivedAccessToken($token);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }
    try {
    	
        Facebook::setDefaultAccessToken($token);
        $fb_url= "https://graph.facebook.com/me?access_token=".(string)$token;

        $json = json_decode(file_get_contents($fb_url), true);
        $username=$json['name'];
        $id = $json['id'];
        $smedia_id= 1; 
     
     	// dump($json);
        
        if (Auth::check()) {
        	# code...
        	   $user_id= Auth::user()->id;
	        $user_id_exists = DB::table('oauth_session')->where('user_id', $user_id)->where('smedia_id',1)->pluck('id');
	        $fb_url= "https://graph.facebook.com/me/friends?access_token=".(string)$token;
	        $json = json_decode(file_get_contents($fb_url), true);
	        $totalFBfriends = intval($json['summary']['total_count']);
	        if ($user_id_exists == null) {
	            DB::insert('insert into oauth_session (smedia_id,user_id,client_id,access_token,connections,username) values (?, ?,?,?,?,?)', [$smedia_id, $user_id,$id, (string)$token,$totalFBfriends,$username]);
	            Session::put('fb_user_access_token', (string) $token);
	            $sst= SalesStaff::where('user_id',$user_id)->first();
	            if (is_null($sst)) {
	                $ss= new SalesStaff;
	                $ss->type="smm";
	                $ss->user_id=$user_id;
	                $ss->status="active";
	                $ss->save();
	            }
	            $dumm_sout= new SMMout;
	            $dumm_sout->user_id=$user_id;
	            $dumm_sout->product_id=0;
	            $dumm_sout->object_id=0;
	            $dumm_sout->connections=$totalFBfriends;
	            $dumm_sout->save();
	            // return redirect()->back();
	            return '
	            <script type="text/javascript">setTimeout("window.close();", 1);</script>
	            Your facebook account was connected successfully';
	        } else {
	            DB::table('oauth_session')->where('user_id', $user_id)->update(['access_token' => (string)$token]);
	            $sst= SalesStaff::where('user_id',$user_id)->first();
	            if (is_null($sst)) {
	                $ss= new SalesStaff;
	                $ss->type="smm";
	                $ss->user_id=$user_id;
	                $ss->status="active";
	                $ss->save();
	            }
	            Session::put('fb_user_access_token', (string) $token);
	            // return redirect()->back();
	            return '
	                <script type="text/javascript">setTimeout("window.close();", 1);</script>
	             Your facebook account was updated successfully';
	        }
	    }
	    else{
	    	Session::put('fb_token_json',$json);
	    	return '
	                <script type="text/javascript">setTimeout("window.close();", 1);</script>
	             Your facebook account has been linked. Please complete rest of registration.';
	    }

    } catch (\Exception $e) {
    	dd($e->getMessage());
    	$token_tries=Session::get('token_tries');
    	dump($token_tries);
    	$login_url = Facebook::getLoginUrl(['email']);
    	if ($token_tries>1) {
    		return '
                <script type="text/javascript">setTimeout("window.close();", 10);</script>
             Unable to connect your connect. Please try later.';
    	}else{

    		Session::put('token_tries',2);
        return  '<a href="' . $login_url . '" class="btn ">Click here to connect</a>';
    	}
    	
    }

      
    }
    public function checkToken()
    {
        
    }

	public function offer_tokens(Request $req) {
		$user_id = $req->user_id;
		$tokens_free = $req->tokens_free;
		$tokens_buy = $req->tokens_buy;
		$havetokens = DB::table('tokenoffer')->where('user_id',$user_id)->first();
		if(is_null($havetokens)){
			DB::table('tokenoffer')->insert(['user_id'=>$user_id,'tokens_buy'=>$tokens_buy,'tokens_free'=>$tokens_free,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		} else {
			DB::table('tokenoffer')->where('id',$havetokens->id)->update(['tokens_buy'=>$tokens_buy,'tokens_free'=>$tokens_free,'updated_at'=>date('Y-m-d H:i:s')]);
		}
		//DB::table('freetokenslog')->insert(['user_id'=>$user_id,'quantity'=>$originalquantity,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		return "OK";
	}
	
	public function edit_subscription(Request $req) {
		$facility_id = $req->facility_id;
		$value = $req->value;
		DB::table('facility')->where('id',$facility_id)->update(['token_subscription_fee'=>$value]);
		return "OK";
	}
	
	public function edit_admin(Request $req) {
		$facility_id = $req->facility_id;
		$value = $req->value;
		DB::table('facility')->where('id',$facility_id)->update(['token_admin_fee'=>$value]);
		return "OK";
	}
	
	public function set_tokens(Request $req) {
		$product_id = $req->product_id;
		$user_id = $req->user_id;
		$action = $req->action;
		if($action == "true"){
			DB::table('tokenuserproduct')->insert(['product_id'=>$product_id,'user_id'=>$user_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		} else {
			DB::table('tokenuserproduct')->where('product_id',$product_id)->where('user_id',$user_id)->delete();
		}
		return "OK";
	}
	public function available_facilities(Request $req) {
		$user_id = $req->user_id;
		$facilities = DB::table('facility')->get();
		foreach($facilities as $facility){
			$since = "";
			$issince = DB::table('sellerfacility')->where('facility_id',$facility->id)->where('user_id',$user_id)->first();
			if(!is_null($issince)){
				$since = UtilityController::s_date($issince->created_at);
			}
			$facility->since = $since;
		}
		return json_encode($facilities);
	}
	public function available_tokens(Request $req) {
		$user_id = $req->user_id;
		$available[0] = 0;
		$available[1] = 0;
		$available[2] = 0;
		$available[3] = 0;
		$available[4] = 0;
		$tglobals = DB::table('global')->first();
		if(property_exists($tglobals, 'token_product_id1')){
			$product1 = DB::table('product')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$user_id)->where('product.id',$tglobals->token_product_id1)->first();
			if(!is_null($product1)){
				$available[0] = 1;
			}
		}
		if(property_exists($tglobals, 'token_product_id2')){
			$product2 = DB::table('product')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$user_id)->where('product.id',$tglobals->token_product_id2)->first();
			if(!is_null($product2)){
				$available[1] = 1;
			}
		}
		if(property_exists($tglobals, 'token_product_id3')){
			$product3 = DB::table('product')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$user_id)->where('product.id',$tglobals->token_product_id3)->first();
			if(!is_null($product3)){
				$available[2] = 1;
			}
		}
		if(property_exists($tglobals, 'token_product_id4')){
			$product4 = DB::table('product')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$user_id)->where('product.id',$tglobals->token_product_id4)->first();
			if(!is_null($product4)){
				$available[3] = 1;
			}
		}
		if(property_exists($tglobals, 'token_product_id5')){
			$product5 = DB::table('product')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$user_id)->where('product.id',$tglobals->token_product_id5)->first();
			if(!is_null($product5)){
				$available[4] = 1;
			}
		}
		return json_encode($available);
	}
	public function free_tokens(Request $req) {
		$user_id = $req->user_id;
		$quantity = $req->tokens;
		$originalquantity = $req->tokens;
		$havetokens = DB::table('userstoken')->where('user_id',$user_id)->first();
		if(is_null($havetokens)){
			DB::table('userstoken')->insert(['user_id'=>$user_id,'qty'=>$quantity,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		} else {
			$quantity += $havetokens->qty;
			DB::table('userstoken')->where('id',$havetokens->id)->update(['qty'=>$quantity,'updated_at'=>date('Y-m-d H:i:s')]);
		}
		DB::table('freetokenslog')->insert(['user_id'=>$user_id,'quantity'=>$originalquantity,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		return $quantity;
	}
	
	public function master()
    {
		return view('master.token_pagination');
	}
	
	public function master_pagination($start=0)
    {
        
        $end=$start+30;

        $ret=array();
        if (!Auth::check() or !Auth::user()->hasRole('adm')) {
            return $ret;
        }
        try {
            $ret=Usertoken::leftJoin('nsellerid','userstoken.user_id','=','nsellerid.user_id')->leftJoin('merchant','merchant.user_id','=','userstoken.user_id')
			->select(DB::raw("userstoken.*,merchant.id as merchant_id,merchant.company_name as company_name, IFNULL(nsellerid.nseller_id,LPAD(merchant.id,16,'E')) as seller_id"))->get(); 
			
            foreach($ret as $r){
				$tokenproduct = DB::table('global')->select('token_product_id1','token_product_id2','token_product_id3','token_product_id4','token_product_id5')->first();
				$tokenarray =  (array) $tokenproduct;
				$rarray = [];
				$rcounter = 0;
				foreach($tokenarray as $token){
					$rarray[$rcounter] = $token;
					$rcounter++;
				}
				
				$tokenlogtotal = DB::table('tokenlog')->where('user_id',$r->user_id)->select(DB::raw('SUM(value) as total'))->groupBy('user_id')->first();
				$faci = 0;
				if(!is_null($tokenlogtotal)){
					if(!is_null($tokenlogtotal->total)){
						$faci = $tokenlogtotal->total;
					}
				}
				$tokeninvoicetotal = DB::table('invoicetokenlog')->where('user_id',$r->user_id)->select(DB::raw('SUM(quantity) as total'))->groupBy('user_id')->first();
				$inv = 0;
				if(!is_null($tokeninvoicetotal)){
					if(!is_null($tokeninvoicetotal->total)){
						$inv = $tokeninvoicetotal->total;
					}
				}
				$used = $faci + $inv;
				$freetokenslog = DB::table('freetokenslog')->where('user_id',$r->user_id)->select(DB::raw('SUM(quantity) as total'))->groupBy('user_id')->first();
				$boughttokenlog = DB::table('boughttokenlog')->where('user_id',$r->user_id)->select(DB::raw('SUM(quantity) as total'))->groupBy('user_id')->first();
				$tfree = 0;
				if(!is_null($freetokenslog)){
					if(!is_null($freetokenslog->total)){
						$tfree = $freetokenslog->total;
					}
				}
				$tpaid = 0;
				if(!is_null($boughttokenlog)){
					if(!is_null($boughttokenlog->total)){
						$tpaid = $boughttokenlog->total;
					}
				}
				$r->used = $used;
			//	$totalin = $used + $r->qty;
				$r->tfree = $tfree;
				$r->tpaid = $tpaid;
			}
		//	dd($ret);
        } catch (\Exception $e) {
       //     dd($e);
        }
        return Datatables::of($ret)->make(true);	
    }
	
	public function getFacilities($id)
    {
        $likes = DB::select(DB::raw("SELECT facility.id as id,facility.description as description, facility.token_admin_fee, facility.token_subscription_fee, facility.variable_fee_name,  DATE_FORMAT(sellerfacility.created_at,'%d%b%y %H:%i') as since FROM facility, sellerfacility 
		WHERE facility.id = sellerfacility.facility_id AND sellerfacility.user_id=".$id." ORDER BY sellerfacility.created_at DESC"));

		return json_encode($likes);
    }
	
	public function sort_by_created_at ($a, $b) {
		return $b['created_at'] - $a['created_at'];
	}
	
	public function getTokenLog($id)
    {
		$tokencount = 0;
        $facilities = DB::select(DB::raw("SELECT facility.description as description,  DATE_FORMAT(tokenlog.created_at,'%d%b%y %H:%i') as since , tokenlog.created_at,
		tokenlog.value as value
		FROM facility, tokenlog 
		WHERE facility.id = tokenlog.facility_id AND tokenlog.user_id=".$id." ORDER BY tokenlog.created_at DESC"));
		
		$tokenlog = [];
		foreach($facilities as $facility){
			$tokenlog[$tokencount]['facility'] = $facility->description;
			$tokenlog[$tokencount]['since'] = $facility->since;
			$tokenlog[$tokencount]['created_at'] = strtotime($facility->created_at);
			//dd(strtotime($facility->created_at));
			$tokenlog[$tokencount]['value'] = $facility->value;
			$tokenlog[$tokencount]['symbol'] = "minus";
			$tokenlog[$tokencount]['isfree'] = "";
			$tokencount++;
		}
		
		$invoices = DB::select(DB::raw("SELECT DATE_FORMAT(invoicetokenlog.created_at,'%d%b%y %H:%i') as since , invoicetokenlog.created_at, 
		invoicetokenlog.quantity as value
		FROM invoicetokenlog 
		WHERE invoicetokenlog.user_id=".$id." ORDER BY invoicetokenlog.created_at DESC"));
		
		foreach($invoices as $invoice){
			$tokenlog[$tokencount]['facility'] = "Credit Term (Invoice)";
			$tokenlog[$tokencount]['since'] = $invoice->since;
			$tokenlog[$tokencount]['created_at'] = strtotime($invoice->created_at);
			$tokenlog[$tokencount]['value'] = $invoice->value;
			$tokenlog[$tokencount]['symbol'] = "minus";
			$tokenlog[$tokencount]['isfree'] = "";
			$tokencount++;
		}
		
		$bought = DB::select(DB::raw("SELECT DATE_FORMAT(boughttokenlog.created_at,'%d%b%y %H:%i') as since , boughttokenlog.created_at,
		boughttokenlog.quantity as value
		FROM boughttokenlog 
		WHERE boughttokenlog.user_id=".$id." ORDER BY boughttokenlog.created_at DESC"));
		
		foreach($bought as $bou){
			$tokenlog[$tokencount]['facility'] = "";
			$tokenlog[$tokencount]['since'] = $bou->since;
			$tokenlog[$tokencount]['created_at'] = strtotime($bou->created_at);
			$tokenlog[$tokencount]['value'] = $bou->value;
			$tokenlog[$tokencount]['symbol'] = "";
			$tokenlog[$tokencount]['isfree'] = "no";
			$tokencount++;
		}		
		
		$free = DB::select(DB::raw("SELECT DATE_FORMAT(freetokenslog.created_at,'%d%b%y %H:%i') as since , freetokenslog.created_at,
		freetokenslog.quantity as value
		FROM freetokenslog 
		WHERE freetokenslog.user_id=".$id." ORDER BY freetokenslog.created_at DESC"));
		
		foreach($free as $fre){
			$tokenlog[$tokencount]['facility'] = "";
			$tokenlog[$tokencount]['since'] = $fre->since;
			$tokenlog[$tokencount]['created_at'] = strtotime($fre->created_at);
			$tokenlog[$tokencount]['value'] = $fre->value;
			$tokenlog[$tokencount]['symbol'] = "";
			$tokenlog[$tokencount]['isfree'] = "yes";
			$tokencount++;
		}			
		
		usort($tokenlog, array($this,'sort_by_created_at'));
		
		//dd($tokenlog );

		return json_encode($tokenlog);
    }
	
	public function getTokenAllTransactions()
    {
		$tokencount = 0;
        $facilities = DB::select(DB::raw("SELECT facility.description as description,  DATE_FORMAT(tokenlog.created_at,'%d%b%y %H:%i') as since , tokenlog.created_at,
		tokenlog.value as value, tokenlog.user_id
		FROM facility, tokenlog 
		WHERE facility.id = tokenlog.facility_id ORDER BY tokenlog.created_at DESC"));
		
		$tokenlog = [];
		foreach($facilities as $facility){
			$company_name = "";
			$company = DB::table('company')->where('owner_user_id',$facility->user_id)->first();
			if(!is_null($company)){
				$company_name = $company->dispname;
			}
			$tokenlog[$tokencount]['name'] = $company_name;
			$tokenlog[$tokencount]['facility'] = $facility->description;
			$tokenlog[$tokencount]['action'] = "Subscription";
			$tokenlog[$tokencount]['since'] = $facility->since;
			$tokenlog[$tokencount]['created_at'] = strtotime($facility->created_at);
			//dd(strtotime($facility->created_at));
			$tokenlog[$tokencount]['value'] = $facility->value;
			$tokenlog[$tokencount]['symbol'] = "minus";
			$tokenlog[$tokencount]['isfree'] = "";
			$tokencount++;
		}
		
		$invoices = DB::select(DB::raw("SELECT DATE_FORMAT(invoicetokenlog.created_at,'%d%b%y %H:%i') as since , invoicetokenlog.created_at, 
		invoicetokenlog.quantity as value, invoicetokenlog.user_id
		FROM invoicetokenlog 
		 ORDER BY invoicetokenlog.created_at DESC"));
		
		foreach($invoices as $invoice){
			$company_name = "";
			$company = DB::table('company')->where('owner_user_id',$invoice->user_id)->first();
			if(!is_null($company)){
				$company_name = $company->dispname;
			}
			$tokenlog[$tokencount]['name'] = $company_name;
			$tokenlog[$tokencount]['facility'] = "Credit Term (Invoice)";
			$tokenlog[$tokencount]['action'] = "Issued Invoice";
			$tokenlog[$tokencount]['since'] = $invoice->since;
			$tokenlog[$tokencount]['created_at'] = strtotime($invoice->created_at);
			$tokenlog[$tokencount]['value'] = $invoice->value;
			$tokenlog[$tokencount]['symbol'] = "minus";
			$tokenlog[$tokencount]['isfree'] = "";
			$tokencount++;
		}
		
		$bought = DB::select(DB::raw("SELECT DATE_FORMAT(boughttokenlog.created_at,'%d%b%y %H:%i') as since , boughttokenlog.created_at,
		boughttokenlog.quantity as value, boughttokenlog.user_id
		FROM boughttokenlog 
		ORDER BY boughttokenlog.created_at DESC"));
		
		foreach($bought as $bou){
			$company_name = "";
			$company = DB::table('company')->where('owner_user_id',$bou->user_id)->first();
			if(!is_null($company)){
				$company_name = $company->dispname;
			}
			$tokenlog[$tokencount]['name'] = $company_name;
			$tokenlog[$tokencount]['facility'] = "";
			$tokenlog[$tokencount]['action'] = "Buy Token";
			$tokenlog[$tokencount]['since'] = $bou->since;
			$tokenlog[$tokencount]['created_at'] = strtotime($bou->created_at);
			$tokenlog[$tokencount]['value'] = $bou->value;
			$tokenlog[$tokencount]['symbol'] = "";
			$tokenlog[$tokencount]['isfree'] = "no";
			$tokencount++;
		}		
		
		$free = DB::select(DB::raw("SELECT DATE_FORMAT(freetokenslog.created_at,'%d%b%y %H:%i') as since , freetokenslog.created_at,
		freetokenslog.quantity as value, freetokenslog.user_id
		FROM freetokenslog 
		ORDER BY freetokenslog.created_at DESC"));
		
		foreach($free as $fre){
			$company_name = "";
			$company = DB::table('company')->where('owner_user_id',$fre->user_id)->first();
			if(!is_null($company)){
				$company_name = $company->dispname;
			}
			$tokenlog[$tokencount]['name'] = $company_name;
			$tokenlog[$tokencount]['facility'] = "";
			$tokenlog[$tokencount]['action'] = "Free Token";
			$tokenlog[$tokencount]['since'] = $fre->since;
			$tokenlog[$tokencount]['created_at'] = strtotime($fre->created_at);
			$tokenlog[$tokencount]['value'] = $fre->value;
			$tokenlog[$tokencount]['symbol'] = "";
			$tokenlog[$tokencount]['isfree'] = "yes";
			$tokencount++;
		}			
		
		usort($tokenlog, array($this,'sort_by_created_at'));
		
		//dd($tokenlog );

		return json_encode($tokenlog);
    }	
	
	public function getTokenTransaction($id)
    {
		$tokencount = 0;
        $facilities = DB::select(DB::raw("SELECT facility.description as description,  DATE_FORMAT(tokenlog.created_at,'%d%b%y %H:%i') as since , tokenlog.created_at,
		tokenlog.value as value
		FROM facility, tokenlog 
		WHERE facility.id = tokenlog.facility_id AND tokenlog.user_id=".$id." ORDER BY tokenlog.created_at DESC"));
		
		$tokenlog = [];
		foreach($facilities as $facility){
			$tokenlog[$tokencount]['facility'] = $facility->description;
			$tokenlog[$tokencount]['since'] = $facility->since;
			$tokenlog[$tokencount]['created_at'] = strtotime($facility->created_at);
			//dd(strtotime($facility->created_at));
			$tokenlog[$tokencount]['value'] = $facility->value;
			$tokenlog[$tokencount]['symbol'] = "";
			$tokenlog[$tokencount]['issubs'] = "yes";
			$tokencount++;
		}
		
		$invoices = DB::select(DB::raw("SELECT DATE_FORMAT(invoicetokenlog.created_at,'%d%b%y %H:%i') as since , invoicetokenlog.created_at, 
		invoicetokenlog.quantity as value
		FROM invoicetokenlog 
		WHERE invoicetokenlog.user_id=".$id." ORDER BY invoicetokenlog.created_at DESC"));
		
		foreach($invoices as $invoice){
			$tokenlog[$tokencount]['facility'] = "Credit Term (Invoice)";
			$tokenlog[$tokencount]['since'] = $invoice->since;
			$tokenlog[$tokencount]['created_at'] = strtotime($invoice->created_at);
			$tokenlog[$tokencount]['value'] = $invoice->value;
			$tokenlog[$tokencount]['symbol'] = "";
			$tokenlog[$tokencount]['issubs'] = "no";
			$tokencount++;
		}
		
		usort($tokenlog, array($this,'sort_by_created_at'));
		
		//dd($tokenlog );

		return json_encode($tokenlog);
    }	
	
    public function testfbtoken($user_id=null)
    {
	//	try{
			// Get user id from Auth
			try {
				// $token = Session::get('fb_user_access_token');
				if ($user_id==null) {
					# code...
					$user_id= Auth::user()->id;
				}
				
                $token = DB::table('oauth_session')->where('user_id',$user_id)
					->pluck('access_token');
            }
            catch (\Exception $e) {
                return "Please connect your account first";
			}
		  
			// $user_id="Dummy Value";
			//Get the particaular token 
			// 
			// return $user_id;
			$fb_url= "https://graph.facebook.com/me?access_token=".(string)$token;
			$decoded_response= json_decode(curl_get_file_contents($fb_url));
            //Check for errors
        //    return (string)$decoded_response->error;
			if(isset($decoded_response->error)){
					// check to see if this is an oAuth error:
				if ($decoded_response->error->type == "OAuthException") {
					return "Your token has expired";

				} else {
					return  "Other error has happened";
				}

			} else {
                return "Your token is valid";
//					return '<script type="text/javascript">
//						setTimeout("window.close();", 3000);</script>
//						Your token is valid';
			}
        return "Your token is valid";
		/*}
	   
		 catch (\Exception $e) {
            return "OK";
		 //	return "Please connect your account first";
		 }*/
    }
}
