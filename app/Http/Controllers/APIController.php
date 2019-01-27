<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EmailController;
use App\Models\Album;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Dealer;
use App\Models\Station;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Buyer;
use App\Models\ProductDealer;
use App\Models\productspec;
use App\Models\ProfileProduct;
use App\Models\RoleUser;
use App\Models\Specification;
use App\Models\SubCatLevel1;
use App\Models\SubCatLevel2;
use App\Models\SubCatLevel3;
use App\Models\SubCatLevel4;
use App\Models\User;
use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Wholesale;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Response;
use Mailgun\Mailgun;
use App\Models\OshopProduct;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login_api(Request $req) {
		$email = $req->email;
		$password = $req->password;
	/*	$input = $req->all();
		dd($input['json']);*/
        $user = User::where('email', $email)->first();
       /*   if (!empty($user_id)) {
            $user_role = RoleUser::where('user_id', $user_id->id)->
		  		with('user_role')->get();
            if (is_null($user_role)) {
                return response()->json[['status'=>'failure','short_message'=>'Missing Role','long_message'=>'DB Error: The user has no role. Please contact OpenSupport.']];
                return "";
            }
          if (!empty($user_role)) {
                $userRole = $user_role->toArray();
                foreach ($userRole as $key => $Role) {
					if ($Role['user_role']['slug'] == 'byr') {
						$buyerStatus = Buyer::where('user_id', $user_id->id)->first(['status']);
						if ($buyerStatus->status != 'active') {
                            return response()->json[['status'=>'failure','short_message'=>'Missing Role','long_message'=>'DB Error: The user has no role. Please contact OpenSupport.']];
                        }
					}
                    if ($Role['user_role']['slug'] == 'mer') {
                        $merchantStatus = Merchant::where('user_id',
							$user_id->id)->first(['status']);
                        if ($merchantStatus->status != 'active') {
                            if($merchantStatus->status == 'suspended'){
								return "merchant_status_error_suspended";
							} else {
								return "merchant_status_error";
							}
                        }
                    }
                    //Station Operator If not Active can't Login
                    if ($Role['user_role']['slug'] == 'sto') {
                        $stationStatus = Station::where('user_id', $user_id->id)->first(['status']);
                        if ($stationStatus->status != 'active') {
                            return "station_status_error";
                        }
                    }
                }
            }
        }*/

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return json_encode(['email'=>$email, 'name' => $user->first_name]);
        } else {
           return json_encode(['email'=>""]);
        }
	}
	
    public function qr_api(Request $req) {
		$qr_string = $req->text;
		$qr_format = $req->format;
		$email = $req->email;
		return json_encode(['message'=>"This is the message that we are going to show in the Mobile Application: " . $qr_string]);
        /*$user = User::where('email', $email)->first();

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return json_encode(['email'=>$email, 'name' => $user->first_name]);
        } else {
           return json_encode(['email'=>""]);
        }*/
	}	

}
