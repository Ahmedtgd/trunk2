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
use File;
use Hash;
use Image;
use App\Models\OshopProduct;
use App\Models\Currency;
use Carbon;
// use DB;
class AjaxController extends Controller {

	public function validate_url($url, $oid)
    {
        $code = 1;
        $validation = DB::table('oshop')->where('url',$url)->where('id','!=',$oid)->whereNull('deleted_at')->get();
        if(count($validation) > 0){
            $code = 0;
        }

         return $code;
    }
	
	public function validate_url2($url)
    {
		$returnurl = $url;
		//$code = 1;
        $validation = DB::table('oshop')->where('url',$url)->whereNull('deleted_at')->get();
        if(count($validation) > 0){
            //$code = 0;
			$code = 0;
			$nnumber = 1;
			while($code == 0){
				$url .= $nnumber;
				$validation = DB::table('oshop')->where('url',$url)->whereNull('deleted_at')->get();
				if(count($validation) == 0){
					$code = 1;
					$returnurl = $url;
				}
				$nnumber++;
			}
        }

         return $returnurl;
    }

    public function getstationsbytype($id) {
		$stations = DB::table('station')->where('stationtype_id',$id)->get();
		$html = '<option value="" selected>Select</option>';
		foreach ($stations as $station) {
            $html .= '<option data-text="'.$station->company_name.'" value="'.$station->id.'">'. IdController::nS($station->id) . ' - ' . mb_strimwidth($station->company_name, 0, 30, "...").'</option>';
        }
        echo $html;
	}
	
    public function subcat(Request $req) {
        $html = '<option value="" selected>Choose Option</option>';
        $category_id = $req->id;
        $subcat_level1 = SubCatLevel1::where('category_id', $category_id)->get();
        foreach ($subcat_level1 as $Subcat_level1) {
            $html .= '<option value="' . $Subcat_level1->id . '">' . $Subcat_level1->description . '</option>';
        }
        echo $html;
    }   

	public function broducts(Request $req) {
		$html = '<option value="" selected>Choose Option</option>';
		$brand_id = $req->id;
		$products = DB::table('product')->where('brand_id',$brand_id )->where('segment','b2c')->where('status','!=','deleted')->where('status','!=','transferred')->select('product.*')->get();
		foreach ($products as $product) {
            $html .= '<option value="' . $product->id . '">' . $product->name . '</option>';
        }
        echo $html;
	}	
	
	public function broducts_bymerchant($mid, Request $req) {
		$html = '<option value="" selected>Choose Option</option>';
		$brand_id = $req->id;
		$products = DB::table('product')->join('merchantproduct','merchantproduct.product_id','=','product.id')->where('product.status','!=','deleted')->where('product.status','!=','transferred')->where('brand_id',$brand_id )->where('merchantproduct.merchant_id',$mid )->select('product.*')->get();
		foreach ($products as $product) {
            $html .= '<option value="' . $product->id . '">' . $product->name . '</option>';
        }
        echo $html;
	}
	
	public function broducts_bystation($sid, Request $req) {
		$html = '<option value="" selected>Choose Option</option>';
		$brand_id = $req->id;
		$products = DB::table('product')->join('sproduct','sproduct.product_id','=','product.id')->join('stationsproduct','stationsproduct.sproduct_id','=','sproduct.id')->where('product.brand_id',$brand_id )->where('stationsproduct.station_id',$sid )->select('product.*')->get();
		foreach ($products as $product) {
            $html .= '<option value="' . $product->id . '">' . $product->name . '</option>';
        }
        echo $html;
	}
	
	public function subcat_bymerchant($mid, Request $req) {
        $html = '<option value="" selected>Choose Option</option>';
        $category_id = $req->id;
        $subcat_level1 = DB::select(DB::raw(
				"SELECT id, COUNT(nprod) as nprod, name, description FROM 
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name,
				subcat_level_1.description as description, product.id as nprod
				FROM subcat_level_1
				JOIN product ON product.subcat_id = subcat_level_1.id AND product.subcat_level = 1
				JOIN merchantproduct ON merchantproduct.product_id = product.id
				WHERE merchantproduct.merchant_id = " . $mid .
					" AND subcat_level_1.category_id = " . $category_id . "
					AND product.deleted_at IS NULL					
					UNION				
					SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
									JOIN merchantproduct ON merchantproduct.product_id = product.id
									WHERE merchantproduct.merchant_id = " . $mid .
					" AND subcat_level_1.category_id = " . $category_id . "
										AND product.deleted_at IS NULL
						GROUP BY id				
										
					UNION				
					SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
									JOIN merchantproduct ON merchantproduct.product_id = product.id
									WHERE merchantproduct.merchant_id = " . $mid .
					" AND subcat_level_1.category_id = " . $category_id . "
										AND product.deleted_at IS NULL
						GROUP BY id
					) as T
					GROUP BY id
					ORDER BY nprod DESC"
			));
		//	dd($subcat_level1);
        foreach ($subcat_level1 as $Subcat_level1) {
            $html .= '<option value="' . $Subcat_level1->id . '">' . $Subcat_level1->description . '</option>';
        }
        echo $html;
    }

	public function subcat_bystation($sid, Request $req) {
        $html = '<option value="" selected>Choose Option</option>';
        $category_id = $req->id;
        $subcat_level1 = DB::select(DB::raw(
				"SELECT id, COUNT(nprod) as nprod, name, description FROM 
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name,
				subcat_level_1.description as description, product.id as nprod
				FROM subcat_level_1
				JOIN product ON product.subcat_id = subcat_level_1.id AND product.subcat_level = 1
				JOIN sproduct ON sproduct.product_id = product.id
				JOIN stationsproduct ON stationsproduct.sproduct_id = sproduct.id
				WHERE stationsproduct.station_id = " . $sid .
					" AND subcat_level_1.category_id = " . $category_id . "
					AND product.deleted_at IS NULL					
					UNION				
					SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
									JOIN sproduct ON sproduct.product_id = product.id
									JOIN stationsproduct ON stationsproduct.sproduct_id = sproduct.id
									WHERE stationsproduct.station_id = " . $sid .
					" AND subcat_level_1.category_id = " . $category_id . "
										AND product.deleted_at IS NULL
						GROUP BY id				
										
					UNION				
					SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
									JOIN sproduct ON sproduct.product_id = product.id
									JOIN stationsproduct ON stationsproduct.sproduct_id = sproduct.id
									WHERE stationsproduct.station_id = " . $sid .
					" AND subcat_level_1.category_id = " . $category_id . "
										AND product.deleted_at IS NULL
						GROUP BY id
					) as T
					GROUP BY id
					ORDER BY nprod DESC"
			));
		//	dd($subcat_level1);
        foreach ($subcat_level1 as $Subcat_level1) {
            $html .= '<option value="' . $Subcat_level1->id . '">' . $Subcat_level1->description . '</option>';
        }
        echo $html;
    }	
	
    public function subcatproducts(Request $req) {
        $html = '<option value="" selected>Choose Option</option>';
        $category_id = $req->id;
        $subcat_level1 = SubCatLevel2::where('subcat_level_1_id', $category_id)->get();
        foreach ($subcat_level1 as $Subcat_level1) {
            $html .= '<option value="' . $Subcat_level1->id . '">' . $Subcat_level1->description . '</option>';
        }
        echo $html;
    }	
	
    public function subcatp(Request $req) {
        $html = '<option value="" selected>Choose Option</option>';
        $category_id = $req->id;
        $subcat_level1 = SubCatLevel1::where('category_id', $category_id)->get();
        foreach ($subcat_level1 as $Subcat_level1) {
            $html .= '<option value="' . $Subcat_level1->id . '-1">' . $Subcat_level1->description . '</option>';
			$subcat_level2 = SubCatLevel2::where('subcat_level_1_id', $Subcat_level1->id)->get();
        }
        echo $html;
    }
	
	public function subcatp2(Request $req) {
		$subcat1 = $req->id;
		$cat = $req->cat;
		$subcat_level2 = SubCatLevel2::where('subcat_level_1_id', $subcat1)->where('category_id', $cat)->get();
		if(count($subcat_level2) == 0){
			$html = '<option value="0" selected>Choose Option</option>';
		} else {
			$html = '<option value="" selected>Choose Option</option>';
			foreach ($subcat_level2 as $Subcat_level2) {
				$html .= '<option value="' . $Subcat_level2->id . '-2">' . $Subcat_level2->description . '</option>';
			}			
		}
		echo $html;
	}
	
	public function subcatp3(Request $req) {
		$subcat2 = $req->id;
		$cat = $req->cat;
		$subcat1 = $req->subcat1;
		$subcat_level3 = SubCatLevel3::where('subcat_level_2_id', $subcat2)->where('subcat_level_1_id', $subcat1)->where('category_id', $cat)->get();
		if(count($subcat_level3) == 0){
			$html = '<option value="0" selected>Choose Option</option>';
		} else {
			$html = '<option value="" selected>Choose Option</option>';
			foreach ($subcat_level3 as $subcat_level3) {
				$html .= '<option value="' . $subcat_level3->id . '-3">' . $subcat_level3->description . '</option>';
			}			
		}
		echo $html;
	}
	
    public function checktemplate(Request $req) {
        //$html = '<option value="" selected>Choose Option</option>';
        $subcat = $req->subcat;
		$subcat_idarr = explode("-", $subcat);
		$template = DB::table('oshop_template')->where('subcat_id', $subcat_idarr[0])->where('subcat_level', $subcat_idarr[1])->first();
		if(is_null($template)){
			echo json_encode("0");
		} else {
			echo json_encode($template);
		}
    }	
	
	public function getcurrentcurrency() {
		$currency= DB::table('currency')->where('active', 1)->first()->code;
		echo $currency;
	}
	
	public function verify($id) {
        $message1="Thank you for verifying your email! Enjoy shopping in OpenSupermall!";
        $message2="Your approval is under process, please wait for 1-3 working days";
        // Check if merchant
        $merchant=Merchant::where('user_id',$id)->first();
        if (is_null($merchant)) {
            # code...
                    Auth::loginUsingId($id);
        return view('verify')->with('message',$message1);
        }
        if (!is_null($merchant)) {
            if ($merchant->status=="pending") {
                return view('verify')->with('message',$message2);
            }
            if ($merchant->status=="active") {
                                    Auth::loginUsingId($id);
        return view('verify')->with('message',$message1);
            }
        }

	}
	
	public function redirectstation($id) {
		Auth::loginUsingId($id);
		return $id;
	}

	public function redirectrecruiter($id) {
                Auth::loginUsingId($id);
                return $id;
        }	

    public function allUser() {
        $user = user::all();
        $html = '<div class="form-group">
                    <div class="col-sm-11 col-xs-10">
                        <select name="dealer[]" class ="form-control validator">
                            <option value="" selected>Choose Option</option>';
        foreach ($user as $User) {
            $html .= '<option value="' . $User->id . '">' . $User->first_name . '</option>';
        }
        $html .='</select>
                    </div>
                     <div class="col-xs-1 row">
                        <a  href="javascript:void(0);"  class="btn btn-default remwholesale text-danger">
                            <i class="fa fa-minus-circle"></i>
                        </a>
                     </div>
                 </div>';
        echo $html;
    }

    public function getCountries()
    {
        $countries = Country::all();

        return $countries->toJson();
    }

    public function getState(Request $req) {
      
        // $country = Country::find($req->id);
        //$country = Country::find($req->id);
        // dd($country);
        //$state = state::where('country_code',$req->code)->get();
        $state=DB::table("state")->where('country_code',$req->code)->get();
        //return $state;
        $html = '<option value="" selected>Choose Option</option>';
        foreach ($state as $states) {
            $html .= '<option value="' . $states->id . '">' . $states->name . '</option>';
          
        }

       return $html;
    }

	public function getMerchantProducts(Request $req) {
        $isfind = false;
        $products = DB::table('product')->join('merchantproduct','product.id','=','merchantproduct.product_id')->where('merchantproduct.merchant_id',$req->id)->select('merchantproduct.product_id','product.name')->get();

        $html = '<option value="" selected>Choose Option</option>';
        foreach ($products as $product) {
            $html .= '<option value="' . $product->product_id . '">' . $product->name . '</option>';
            $isfind = true;
        }

        if ($isfind) {
            return $html;
        } else {
            return "";
        }		
	}
	
    public function getCity(Request $req) {
        $isfind = false;
        $html = '<option value="" selected>Choose Option</option>';

        $state = State::find($req->id);

		if (!empty($state)) {
			$city = City::where('state_code', $state->code)->
				groupBy('name')->
				orderBy('name','ASC')->
				get();
		   
			if (!empty($city)) {
				foreach ($city as $cities) {
					$html .= '<option value="' . $cities->id . '">' .
						$cities->name . '</option>';
				}
			}
		}
        return $html;
    }

    public function getArea(Request $req) {
        $isfind = false;
        $area = Area::where('city_id', $req->id)->get();

        $html = '<option value="" selected>Choose Option</option>';
        foreach ($area as $areas) {
            $html .= '<option value="' . $areas->id . '">' . $areas->name . '</option>';
            $isfind = true;
        }

        if ($isfind) {
            return $html;
        } else {
            return "";
        }
    }

	public function Register(Request $req) {
	//	dd("BUYING: " . $req->reg_role);
		$user_name = $req->username;
		$user_password = $req->password;
		$confirm_password = $req->confirm_password;
		$user_id = User::where('email', $user_name)->first(['id']);
		if (!is_null($user_id)) {
			 return 'email_error';
		} else {
			if ($user_password != $confirm_password) {
				 return 'password_error';
			} else {
				$user = new User;
				$user->username = $user_name;
				$user->name = "";
				$user->nric = "";
				$user->email = $user_name;
				$user->language_id = 0;
				$user->occupation_id = 0;
				$user->birthdate = "01-01-1950";
				$user->mobile_no = "";
				$user->password = Hash::make($user_password);
				$user->gender = null;
				$user->annual_income = null;

				$user->default_address_id = 0;
				$user->billing_address_id = 0;
				$user->shipping_address_id = 0;
				$user->save();
				$user_id = $user->id;
				if($req->reg_role == 'buyer'){
					$role = new RoleUser;
					$role->user_id = $user_id;
					$role->role_id = 2;
					$role->save();
					
					$buyer_profile = new Buyer;
					$buyer_profile->user_id = $user->id;
					$buyer_profile->save();
					
					$e= new EmailController;
					$e->confirmEmail($user_name,2);
				} else {
					$role = new RoleUser;
					$role->user_id = $user_id;
					$role->role_id = 11;
					$role->save();
					
					$role = new RoleUser;
					$role->user_id = $user_id;
					$role->role_id = 3;
					$role->save();
					
					$user_as_station = new Station();
					$user_as_station_model = $user_as_station->store_empty($req, $user);
					
					$user_as_merchant = new Merchant();
					$user_as_merchant_model = $user_as_merchant->store_empty($req, $user);
					
					$e= new EmailController;
					$e->confirmEmail($user_name,11);
				}
				
				return $user_id;				
			}
		}
	}
	
    public function Login(Request $req) {
    	
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

            if (!empty($user_role)) {
                $userRole = $user_role->toArray();
                foreach ($userRole as $key => $Role) {

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


					$ismerchant = DB::table('merchant')->where('user_id', $user_id->id)->first();

					if ($Role['user_role']['slug'] == 'mer' || !is_null($ismerchant)) {
						$merchant = Merchant::where('user_id', $user_id->id)->first();

						/*This is example of bad code. */
						$merchantStatus = $merchant;

						/*Check for ONZ*/
					   // dd($Role['user_role']['slug']);

						$is_onz = DB::table('onzmerchant')->
							where('user_merchant_id', $merchant->id)->first();
					   // dd($is_onz);

						if (!empty($is_onz)) {
							$ret["long_message"] = "Your account is invalid.";
							return response()->json($ret);
						}

						if ($merchantStatus->status != 'active') {
							if ($merchantStatus->status == 'suspended') {
								$ret["long_message"] = "Your merchant account has been suspended. Please contact OpenSupport.";
							} else {
								$ret["long_message"] = "Your merchant account is not active. Please contact OpenSupport.";
							}
							return response()->json($ret);
						}
					}

                    //Station Operator If not Active can't Login
                    if ($Role['user_role']['slug'] == 'sto') {
                        $stationStatus = Station::where('user_id', $user_id->id)->first(['status']);
						if(!is_null($stationStatus)){
							if ($stationStatus->status != 'active') {
								if($stationStatus->status == 'suspended'){
									$ret["long_message"]="Your station account has been suspended. Please contact OpenSupport.";
								} else {
									$ret["long_message"]="Your station account is not active. Please contact OpenSupport.";
								}
								return response()->json($ret);
							}
                        }
                    }
                }
            }
        }


        if (Auth::attempt(['email' => $user_name, 'password' => $user_password], true)) {
           // if(true){
            $user_id = Auth::user()->id;
			$osmallvisit=DB::table('osmallvisit')->where('user_id',$user_id)->first();
			DB::table('users')->where('id', $user_id)->update(['password_fail'=>0]);
			if(is_null($osmallvisit)){
				DB::table('osmallvisit')->insert(['user_id'=>$user_id,'counter'=>1]);
			} else {
				DB::table('osmallvisit')->where('id',$osmallvisit->id)->update(['counter'=>($osmallvisit->counter + 1)]);
			}			
            Session::put('user_id', $user_id);
            //get merchant id
            $merchant_data = Merchant::where('user_id', $user_id)->first();

            /* User MAY not be a merchant!! */
            if (isset($merchant_data)) {

                $merchant_id = $merchant_data->id;

                //get album id
                $album = Album::where('merchant_id', $merchant_id)->first();
                if (empty($album)) {
                    $album = new Album();
                    $album->merchant_id = $merchant_id;
                    $album->save();
                }

                $album_id = $album->id;
                Session::put('merchant', $merchant_data);
                Session::put('album_id', $album_id);

                //get profile id
                $profile = Profile::where('album_id', $album_id)->first();
                if (empty($profile)) {
                    $profile = new Profile();
                    $profile->album_id = $album_id;
                    $profile->save();
                }

                $profile_id = $profile->id;
                Session::put('profile_id', $profile_id);
            }
            $ret["status"]="success";
			return response()->json($ret);
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
					DB::table('merchant')->where('user_id', $dbuser->id)->update(['status'=>'suspended']);
					DB::table('station')->where('user_id', $dbuser->id)->update(['status'=>'suspended']);
					DB::table('buyer')->where('user_id', $dbuser->id)->update(['status'=>'suspended']);
					//$e= new EmailController;
				//	$e->passwordFail($user_name);
				}
			}
            $ret["long_message"]="Your username or password is incorrect. Please try again.";
			return response()->json($ret);
        }
    }

    public function showsubDetails(Request $req) {
        $merchant = Session::get('merchant');
        $merchant_id = 1; //$merchant->id;
        $i = 0;
        $product_info = Product::where('subcat_id', $req->subcategoryid)->where('category_id', $req->categoryid)->select('product.id' ,
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
				  'product.updated_at')->get();
        $Specifications = Specification::all();
        foreach ($product_info as $product) {
            $Brand[$i] = $product->brand;
            $Wholesale[$i] = $product->wholesale;
            $Productdealer[$i] = $product->productdealer;
            $Productspecs[$i] = $product->productspecs;
            $i = $i + 1;
        }
        for ($i = 0; $i < count($Productdealer); $i++) {
            for ($j = 0; $j < count($Productdealer[$i]); $j++) {
                $dealer = Dealer::find($Productdealer[$i][$j]->dealer_id);
                $NewProDealer[$i]['user_id'] = $dealer->user_id;
                $NewProDealer[$i]['pro_id'] = $Productdealer[$i][$j]->product_id;
                $NewProDealer[$i]['special_price'] = $Productdealer[$i][$j]->special_price;
                $NewProDealer[$i]['special_unit'] = $Productdealer[$i][$j]->special_unit;
                $NewProDealer[$i]['id'] = $Productdealer[$i][$j]->id;
            }
        }
        $Users = User::find(1);
        return Response::json(array('Product' => $product_info, 'Brand' => $Brand, 'Wholesale' => $Wholesale, 'Productdealer' => $NewProDealer,
                    'Productspecs' => $Productspecs, 'Users' => $Users, 'Specifications' => $Specifications));
    }

    public function CategoryAndBrand(Request $req) {
        if ($req->table == 'cat') {

            $cat_id = $req['cat_id'];
            $product = Product::find($req->id);
            $pro_cat = $product->category;
            $html = '<option value="">Choose Option</option>';
            $merchant = session()->get('merchant');
            $cat = $merchant->categories;
            foreach ($cat as $Maincat) {

                if ($cat_id == $Maincat->id) {
                    $selected = "selected";
                } else {
                    $selected = '';
                }

                $html .= '<option ' . $selected . ' value="' .
                        $Maincat->description . "%d%" . $Maincat->id . '">' .
                        $Maincat->description . '</option>';
            }
            echo $html;
        } else if ($req->table == 'brand') {

            $product = Product::find($req->id);
            $pro_sub_cat = $product->brand;


            $html = '<option value="">Choose Option</option>';
            $brands = Brand::all();
            foreach ($brands as $brand) {

                if ($pro_sub_cat->id == $brand->id) {
                    $selected = "selected";
                } else {
                    $selected = '';
                }

                $html .= '<option ' . $selected . ' value="' . $brand->name . "%d%" . $brand->id . '">' . $brand->name . '</option>';
            }
            echo $html;
        } else {
            $product = Product::find($req->id);
            $cat_level_id = $product->subcat_level;


            $html = '<option value="" >Choose Option</option>';
//            $category_id = $req->id;
            if ($cat_level_id == 1) {
                $subcat_level = SubCatLevel1::whereCategoryId($req['cat_id'])->get();
                foreach ($subcat_level as $Subcat_level1) {
                    if ($product->subcat_id == $Subcat_level1->id) {
                        $selected = "selected";
                    } else {
                        $selected = '';
                    }
                    $html .= '<option ' . $selected . ' value="' . $Subcat_level1->description . "%d%" . $Subcat_level1->id . '">' . $Subcat_level1->description . '</option>';
                }
                echo $html;
            } elseif ($cat_level_id == 2) {
                $subcat_level = SubCatLevel2::whereCategoryId($req['cat_id'])->get();
                foreach ($subcat_level as $Subcat_level1) {
                    if ($product->subcat_id == $Subcat_level1->id) {
                        $selected = "selected";
                    } else {
                        $selected = '';
                    }
                    $html .= '<option ' . $selected . ' value="' . $Subcat_level1->description . "%d%" . $Subcat_level1->id . '">' . $Subcat_level1->description . '</option>';
                }
                echo $html;
            } else {
                $subcat_level = SubCatLevel3::whereCategoryId($req['cat_id'])->get();
                foreach ($subcat_level as $Subcat_level1) {
                    if ($product->subcat_id == $Subcat_level1->id) {
                        $selected = "selected";
                    } else {
                        $selected = '';
                    }
                    $html .= '<option ' . $selected . ' value="' . $Subcat_level1->description . "%d%" . $Subcat_level1->id . '">' . $Subcat_level1->description . '</option>';
                }
                echo $html;
            }
        }
    }

    /*
     * Update product information
     */

    public function updatePro(Request $req) {
        $dataarray = $req->info;
        $c = "";
        for ($i = 0; $i < count($dataarray); $i++) {
            if ($dataarray[$i]['action'] == 'update') {
                if ($dataarray[$i]['table_name'] == 'Product') {
                    Product::where('id', $dataarray[$i]['row_id'])->update([$dataarray[$i]['col_name'] => $dataarray[$i]['value']]);
                } elseif ($dataarray[$i]['table_name'] == 'productspec') {
                    productspec::where('id', $dataarray[$i]['row_id'])->update([$dataarray[$i]['col_name'] => $dataarray[$i]['value']]);
                } elseif ($dataarray[$i]['table_name'] == 'Wholesale') {
                    Wholesale::where('id', $dataarray[$i]['row_id'])->update([$dataarray[$i]['col_name'] => $dataarray[$i]['value']]);
                } elseif ($dataarray[$i]['table_name'] == 'Productdealer') {
                    ProductDealer::where('id', $dataarray[$i]['row_id'])->update([$dataarray[$i]['col_name'] => $dataarray[$i]['value']]);
                }
            } else {
                if ($dataarray[$i]['table_name'] == 'Specification') {
                    $Specification = new Specification();
                    switch ($dataarray[$i]['spec']) {
                        case "sku":
                            $Specification->name = $dataarray[$i]['spec'];
                            $Specification->description = 'SKU';
                            break;
                        case "color":
                            $Specification->name = $dataarray[$i]['spec'];
                            $Specification->description = 'Colour';
                            break;
                        case "model":
                            $Specification->name = $dataarray[$i]['spec'];
                            $Specification->description = 'Model';
                            break;
                        case "size":
                            $Specification->name = $dataarray[$i]['spec'];
                            $Specification->description = 'Size (L x W x H)';
                            break;
                        case "weight":
                            $Specification->name = $dataarray[$i]['spec'];
                            $Specification->description = 'Weight';
                            break;
                        case "warranty":
                            $Specification->name = $dataarray[$i]['spec'];
                            $Specification->description = 'Warranty Period';
                            break;
                        case "warranty_type":
                            $Specification->name = $dataarray[$i]['spec'];
                            $Specification->description = 'Warranty Type';
                            break;
                    }
                    $Specification->save();
                    $last_id = Specification::orderBy('id', 'desc')->first();
                    $last_id = $last_id->id;
                    $productspec = new productspec();
                    $productspec->product_id = $dataarray[$i]['row_id'];
                    $productspec->spec_id = $last_id;
                    $productspec->value = $dataarray[$i]['value'];
                    ;
                    $productspec->save();
                }
            }
        }
        return "Product Information Successfully Updated";
    }

    /*
     * Delete product
     */

    public function deletePro(Request $req) {
        $merchant = Session::get('merchant');
        $merchant_id = $merchant->id;
        $array = $req->info;
        foreach ($array as $id) {
            Product::where('id', $id)->delete();
            MerchantProduct::where('product_id', $id)->where('merchant_id', $merchant_id)->delete();
        }

        return "Product Information Successfully Deleted";
    }

    // Check login by ajax
    public function check()
    {
        if (!Auth::check()) {
            return response()->json(['status'=>'failure','short_message'=>'Unauthorized Access','long_message'=>'Please log in to use the feature']);
        }
        // $role_access=False;
        // $roles=DB::table('role_users')->where('user_id',Auth::user()->id)->lists('role_id');
        // if (in_array(2,$roles) or in_array(10,$roles)) {
        //     $role_access=True;
        // }
        
        if (Auth::check()) {
            // if ($role_access==False) {
                # code...
                 // return response()->json(['status'=>'failure','short_message'=>'Unuthorized Access','long_message'=>'Please signin as a buyer or station to use the feature']);
            // }
            
            return response()->json(['status'=>'success','short_message'=>'Authorized Access','long_message'=>'User is logged in and Authorized']);
        }


    }

    // !Zurez Save in Session
    public function saveinSession(Request $r)
    {
        Session::put($r->key,$r->value);
        return response()->json(['status'=>'success']);
    }

	
    public function forgot_password(Request $request){
		$email = $request->get('email');
         DB::table('stuff')->insert(['note'=>'forgot_password|Email|'.$email]);
        $user=DB::table('users')->where('email',$email)->first();
        // Weirdly and creepily the line below suddenly stopped working. I am sure its a temp problem. Please enable it and check
		// $user = User::where('email',$email)->first();
        // return $user->email;
		try{
			// $mgClient = new Mailgun('key-80495c8905443d885803333b49b45718');
			// $domain = "opensupermall.com";

			// # Make the call to the client.
			// $result = $mgClient->sendMessage($domain, array(
			// 	'from'    => 'Opensupermall <info@opensupermall.com>',
			// 	'to'      => $user->first_name . ' ' . $user->first_name .  ' <'. $user->email .'>',
			// 	'subject' => 'Change your Opensupermall password',
			// 	'html'    => '<h4>Please, follow the link to change your password!</h4>
			// 				<p>click on the following link: <a href="http://'.$_SERVER['HTTP_HOST'].'/change_password/'.base64_encode($user->id).'">Change Password</a></p>'
			// ));		
            $e= new EmailController;
            $e->passwordReset($email);
             DB::table('stuff')->insert(['note'=>'password_reset|No Exception Occured']);			
		} catch (\Exception $e) {
             DB::table('stuff')->insert(['note'=>'forgot_password|Exception Occured|'.$e->getMessage()]);
			return $e;
		}		
        
		return json_encode(base64_encode($user->id));
	}		
	
	public function change_password($id) {
		$id = base64_decode($id);
		return view('change_password',['id'=>$id]);
	}	

    public function check_smm()
    {
        // Check if merchant & registered for SMM
        // This should be done once site-wise and saved in Session
        $merchant=False;
        $count=1;

        if(Auth::check()){

            $user_id = Auth::user()->id;
            $role=DB::table('role_users')->where('user_id',$user_id)->pluck('role_id');
            if ($role==3) {
                # Merchant is Yes now.
                $role="mer";
                $merchant=True;
                // $button_status=False;
                $merchant_id=DB::table('merchant')->where('user_id',$user_id)->pluck('id');
            }
            if ($role==1){
                // Lazy Bypass. Bad 
                $button_status=False;
            }
        } 
        if ($merchant==True) {
            $product_ids=DB::table('merchantproduct')->where('merchant_id',$merchant_id)->lists('product_id');
            $products=Product::where('smm_selected',1)->where('oshop_selected',1)->whereIn('id',$product_ids)->select('product.id' ,
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
				  'product.updated_at')->get();
            $count= count($products);
        }
        if ($merchant==False) {
            return response()->json(['status'=>'success','short_message'=>'dnd','long_message'=>'Do Not Disturb']);
        }
        if ($merchant==True and $count==0) {
                    // Check in session
                $val=0;
                try {
                    $val= Session::get('smm-alert-count');
                    if ($val>1) {
                        return response()->json(['status'=>'success','short_message'=>'cf','long_message'=>'Count Full']);
                    if ($val <2) {
                        $val=$val+1;
                        Session::put('smm-alert-count',$val);
                        return response()->json(['status'=>'success','short_message'=>'cl','long_message'=>'Count Left']);
                    }
                    }
                } catch (\Exception $e) {
                    // First time ??
                    $val=$val+1;
                    Session::put('smm-alert-count',$val);
                    return response()->json(['status'=>'success','short_message'=>'cl','long_message'=>'Count Left']);
                }
        }
        else {
            return response()->json(['status'=>'success','short_message'=>'dnd','long_message'=>'Do Not Disturb']);
        }

    }
    public function check_session($key,$limit)
    {   $val=0;
        try {
            $val=Session::get($key);
            if ($val<$limit) {
                $val=$val+1;
                Session::put($key,$val);
                return response()->json(['status'=>'success','short_message'=>'cl','long_message'=>'Count Left']); 
                           }
            if ($val>$limit) {
                return response()->json(['status'=>'success','short_message'=>'cf','long_message'=>'Count Full']);
            }
        } catch (\Exception $e) {
            $val=$val+1;
            Session::put($key,$val);
            return response()->json(['status'=>'success','short_message'=>'cl','long_message'=>'Count Left']);
        }
    }
    public function get_message($id)
    {
        try {
            
            $am=DB::table('helper_messages')->where('id',$id)->first();
            
            if (is_null($am)) {
                # code...
                return response()->json(['status'=>'success','short_message'=>'Code:404','long_message'=>'No message found']);
            }
            $m= $am->message;
            return response()->json(['status'=>'success','short_message'=>'Code:200','long_message'=>$m]);
        } catch (\Exception $e) {
            return response()->json(['status'=>'failure','short_message'=>'Code:500','long_message'=>'Server couldn"t process the request at this time.']);
        }
        // DB::table('helper_messages')->where('id',$id)->first();
    }

    // This is a mini helper function, This is not actual logout
    public function logout()
    {
        Auth::logout();
        return response()->json(['status'=>'success']);
    }

    public function opossum_logout()
    {
		if (Auth::check()) {
			DB::table('opos_terminal')->
				where('logged_user_id', Auth::user()->id)->
				update([
				"updated_at"=>Carbon::now(),
				"logged_user_id"=>null
			]);
			Auth::logout();      
		}
		return redirect('/opossumLogin');
    }
 

    public function header_hyper()
    {
		
	   $global_system_vars = DB::table('global')->first();
      $duration = $global_system_vars->hyper_duration;		
        $category = DB::select(DB::raw('SELECT
    GROUP_CONCAT(DISTINCT (s) SEPARATOR ";") AS sub_cat,
    c AS cat_name,
    logo,
    GROUP_CONCAT(DISTINCT (sub_id) SEPARATOR ";") AS sub_id
FROM (SELECT
          -- mp.section_id,
          CONCAT(s.id , "-", "1")  AS sub_id,
          TRIM(s.description) AS s,
          c.description AS c,
          c.id          AS cat_id,
          c.logo_green  AS logo,
          c.floor       AS floor
      FROM product p 
          LEFT JOIN subcat_level_1 s ON p.subcat_id = s.id
          LEFT JOIN oshopproduct mp ON mp.product_id = p.id
          LEFT JOIN owarehouse ow ON ow.product_id=p.id
          LEFT JOIN category c ON c.id = p.category_id
      WHERE p.subcat_level = 1 and ow.moq>0 and p.owarehouse_moqperpax > 0 and  p.owarehouse_price > 0 and p.oshop_selected=1 and p.status="active" and ow.product_id=p.id and ow.status="active" and NOW() <= DATE_ADD(ow.created_at,INTERVAL '.$duration.' DAY) 
      UNION SELECT
                --  mp.section_id,
                CONCAT(s.id , "-", "2")       AS sub_id,
                TRIM(s.description) AS s,
                c.description AS c,
                c.id          AS cat_id,
                c.logo_green  AS logo,
                c.floor       AS floor
            FROM product p LEFT JOIN subcat_level_2 s ON p.subcat_id = s.id
                LEFT JOIN oshopproduct mp ON mp.product_id = p.id
                LEFT JOIN owarehouse ow ON ow.product_id=p.id
                LEFT JOIN category c ON c.id = p.category_id
            WHERE p.subcat_level = 2 and ow.moq>0 and  p.owarehouse_moqperpax > 0 and  p.owarehouse_price > 0 and p.oshop_selected=1 and p.status="active" and ow.product_id=p.id and ow.status="active" and NOW() <= DATE_ADD(ow.created_at,INTERVAL '.$duration.' DAY)
      UNION SELECT
                CONCAT(s.id , "-", "3")         AS sub_id,
                TRIM(s.description) AS s,
                c.description AS c,
                c.id          AS cat_id,
                c.logo_green  AS logo,
                c.floor       AS floor
            FROM product p LEFT JOIN subcat_level_3 s ON p.subcat_id = s.id
                LEFT JOIN oshopproduct mp ON mp.product_id = p.id
                LEFT JOIN owarehouse ow ON ow.product_id=p.id
                LEFT JOIN category c ON c.id = p.category_id
            WHERE p.subcat_level = 3 and ow.moq>0 and  p.owarehouse_moqperpax > 0 and  p.owarehouse_price > 0 and p.oshop_selected=1 and p.status="active" and ow.product_id=p.id and ow.status="active" and NOW() <= DATE_ADD(ow.created_at,INTERVAL '.$duration.' DAY)
            ) AS t
GROUP BY cat_id
ORDER BY cat_name'
            ));

        $firstLetter = '';
        $firstRun = true;

        $letters['AD'] = array('A','B','C','D');
        $letters['EH'] = array('E','F','G','H');
        $letters['IL'] = array('I','J','K','L');
        $letters['MP'] = array('M','N','O','P');
        $letters['QT'] = array('Q','R','S','T');
        $letters['UX'] = array('U','V','W','X');
        $letters['YZ'] = array('Y','Z');
        $count = 0;
        return view('common.mini.header_hyper')
        ->with('category', $category)
            ->with('firstLetter', $firstLetter)
            ->with('firstRun', $firstRun)
            ->with('letters', $letters);
    }

	public function header_category_mobile()
    {
		 $maindata=[];
		 $subdata=[];
		 if (Session::has('catheaderarray') and Session::has('pr_count') and Session::get('pr_count')==Product::count()) {
            $maindata=Session::get('catheaderarray');
            $subdata=Session::get('catheadersubdata');
        }
		 return view('common.mini.header_category_mobile')
        ->with(array(
            'allCategories'=>$maindata,
            'allsubCategories'=>$subdata,
        ));
	}
	
    public function header_category()
    {

        // Check if in Session

       if (Session::has('catheaderarray') and Session::has('pr_count') and Session::get('pr_count')==Product::count()) {
            $maindata=Session::get('catheaderarray');
            $subdata=Session::get('catheadersubdata');
            return view('common.mini.header_category')
            ->with(array(
                'allCategories'=>$maindata,
                'allsubCategories'=>$subdata,
            ));
        }
        //check if all sub category of mai category have no product
        $isfind = false;
		$maindata = [];
        $subdata = [];  

        //Get all product id
        //$sectionProduct=SectionProduct::all();
  //       $sectionProduct=OshopProduct::all();
		// $pids=array();
		// foreach ($sectionProduct as $sp) {
  //           # code...
  //           $products=Product::where('id',$sp->product_id)->first();
  //           // array_push($category_ids,$products->category_id);
  //           if(!is_null($products)){
  //               array_push($pids, $products->id);
  //           } 
  //           // array_push($pids, $products->id);
  //       }
  //       $pids=array_unique($pids);;
      
		$getAllCategories = DB::select(DB::raw(
            "SELECT DISTINCT(category.id) as id, category.name, category.floor, category.logo_green,
				category.description, COUNT(product.id) as nprod
            FROM category
            JOIN product ON product.category_id = category.id
            JOIN oshopproduct ON oshopproduct.product_id = product.id
            WHERE 
				product.retail_price > 0  AND product.available > 0 AND product.oshop_selected = 1 AND product.status ='active' AND product.segment = 'b2c' AND product.deleted_at IS NULL
            GROUP BY category.name
            ORDER BY name ASC"
        ));
        // return $getAllCategories;

        foreach($getAllCategories as $cat) {
			$subcategories = DB::select(DB::raw(
				"SELECT id, COUNT(nprod) as nprod, name, TRIM(description) as description FROM 
				(SELECT DISTINCT(subcat_level_1.id) as id, subcat_level_1.name as name,
				subcat_level_1.description as description, product.id as nprod
				FROM subcat_level_1
				JOIN product ON product.subcat_id = subcat_level_1.id AND product.subcat_level = 1
				JOIN oshopproduct ON oshopproduct.product_id = product.id
				WHERE subcat_level_1.category_id = " . $cat->id . "
					AND product.oshop_selected = true
					AND product.retail_price > 0
					AND product.available > 0
					AND product.status ='active' AND product.segment = 'b2c'
					AND product.deleted_at IS NULL					
					UNION				
					SELECT DISTINCT(subcat_level_2.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_2 ON subcat_level_2.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_2.id AND product.subcat_level = 2
									JOIN oshopproduct ON oshopproduct.product_id = product.id
									WHERE subcat_level_1.category_id = " . $cat->id . "
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0
										AND product.status ='active' AND product.segment = 'b2c'
										AND product.deleted_at IS NULL
						GROUP BY id				
										
					UNION				
					SELECT DISTINCT(subcat_level_3.subcat_level_1_id) as id, subcat_level_1.name as name,
										subcat_level_1.description as description, product.id as nprod
									FROM subcat_level_1
									JOIN subcat_level_3 ON subcat_level_3.subcat_level_1_id = subcat_level_1.id
									JOIN product ON product.subcat_id = subcat_level_3.id AND product.subcat_level = 3
									JOIN oshopproduct ON oshopproduct.product_id = product.id
									WHERE subcat_level_1.category_id = " . $cat->id . "
										AND product.oshop_selected = true
										AND product.retail_price > 0
										AND product.available > 0	
                                        AND product.status ='active' AND product.segment = 'b2c'
										AND product.deleted_at IS NULL
						GROUP BY id
					) as T
					GROUP BY id
					ORDER BY description ASC"
			));			
			foreach($subcategories as $sub){
                    $subdata[] = [
						'id'=>$cat->id,
						'subid'=>$sub->id,
						'subname'=>$sub->name,
						'subdescription'=>$sub->description];
			}
			$maindata[] = [
				'id' => $cat->id,
				'name' => $cat->name,
				'floor' => $cat->floor,
				'logo_green' => $cat->logo_green,
				'description' => $cat->description];

        }
		//dd($subdata);
        Session::put('catheaderarray',$maindata);
        Session::put('catheadersubdata',$subdata);
        Session::put('pr_count',Product::count());
        return view('common.mini.header_category')
        ->with(array(
            'allCategories'=>$maindata,
            'allsubCategories'=>$subdata,
        ));
    }

    public function header_smm()
    {
        # code...
        $category = DB::select(DB::raw('SELECT
        GROUP_CONCAT(DISTINCT s SEPARATOR ";") AS sub_cat,
        c AS cat_name,
        logo,
        GROUP_CONCAT(DISTINCT sub_id SEPARATOR ";") AS sub_id
        FROM (SELECT
        -- mp.section_id,
        s.id          AS sub_id,
        TRIM(s.description) AS s,
        c.description AS c,
        c.id          AS cat_id,
        c.logo_green  AS logo,
        c.floor       AS floor
        FROM product p 
        LEFT JOIN subcat_level_1 s ON p.subcat_id = s.id
        LEFT JOIN oshopproduct mp ON mp.product_id = p.parent_id
        -- LEFT JOIN sectionproduct mp ON mp.product_id = p.id
        -- LEFT JOIN section mp ON mp.id = sp.section_id
        LEFT JOIN merchantproduct  ON merchantproduct.product_id = p.parent_id
        LEFT JOIN merchant ON merchant.id=merchantproduct.merchant_id
        LEFT JOIN oshop ON mp.oshop_id=oshop.id
        LEFT JOIN category c ON c.id = p.category_id
        WHERE p.subcat_level = 1 and  p.smm_selected=1 and p.oshop_selected=1 and p.status="active" and p.segment="b2c" and p.available>0
        and merchant.status="active" and oshop.status="active"
     
        UNION 

        SELECT
            --  mp.section_id,
            s.id          AS sub_id,
            TRIM(s.description) AS s,
            c.description AS c,
            c.id          AS cat_id,
            c.logo_green  AS logo,
            c.floor       AS floor
        FROM product p LEFT JOIN subcat_level_2 s ON p.subcat_id = s.id
            LEFT JOIN oshopproduct mp ON mp.product_id = p.id
            LEFT JOIN owarehouse ow ON ow.product_id=p.id
            LEFT JOIN merchantproduct  ON merchantproduct.product_id = p.parent_id
            LEFT JOIN merchant ON merchant.id=merchantproduct.merchant_id
            LEFT JOIN oshop ON mp.oshop_id=oshop.id
            LEFT JOIN category c ON c.id = p.category_id
        WHERE p.subcat_level = 2 and  p.smm_selected=1 and p.oshop_selected=1 and p.status="active" and p.segment="b2c" and p.available>0
        and merchant.status="active" and oshop.status="active"
       
        UNION 

        SELECT
            -- mp.section_id,and  p.smm_selected=1 and p.oshop_selected=1 and p.status="active" and p.segment="b2c"
            s.id          AS sub_id,
            TRIM(s.description) AS s,
            c.description AS c,
            c.id          AS cat_id,
            c.logo_green  AS logo,
            c.floor       AS floor
        FROM product p LEFT JOIN subcat_level_3 s ON p.subcat_id = s.id
            LEFT JOIN oshopproduct mp ON mp.product_id = p.id
            LEFT JOIN owarehouse ow ON ow.product_id=p.id
            LEFT JOIN merchantproduct  ON merchantproduct.product_id = p.parent_id
            LEFT JOIN merchant ON merchant.id=merchantproduct.merchant_id
            LEFT JOIN oshop ON mp.oshop_id=oshop.id
            -- LEFT JOIN sectionproduct mp ON mp.product_id = p.id
            LEFT JOIN category c ON c.id = p.category_id
        WHERE p.subcat_level = 3 and  p.smm_selected=1 and p.oshop_selected=1 and p.status="active" and p.segment="b2c" and p.available>0
            and merchant.status="active" and oshop.status="active"

        ) AS t
        GROUP BY cat_id
        ORDER BY cat_name'
            ));

        $firstLetter = '';
        $firstRun = true;

        $letters['AD'] = array('A','B','C','D');
        $letters['EH'] = array('E','F','G','H');
        $letters['IL'] = array('I','J','K','L');
        $letters['MP'] = array('M','N','O','P');
        $letters['QT'] = array('Q','R','S','T');
        $letters['UX'] = array('U','V','W','X');
        $letters['YZ'] = array('Y','Z');
        $count = 0;
	//	dd($category);
        return view('common.mini.header_smm')
        ->with('category', $category)
            ->with('firstLetter', $firstLetter)
            ->with('firstRun', $firstRun)
            ->with('letters', $letters);

    }
	
	public function uploadsummernoteimg(Request $request)
    {
		$files = $request->file('file');
		$files_name = $files->getClientOriginalName();
		$folder = base_path().'/public/images/' . $request->get('directory');
		$full_path = 'images/' . $request->get('directory');
		$result = File::makeDirectory($folder, 0777,true,true);
		//chmod($folder,0775);
		$destination = $folder.'/';
		$r1 = str_random(15);
		$imgext = $files->getClientOriginalExtension();
        $name = $r1 . "." . $imgext;
        Image::make($files)->save($full_path . "/" . $name);		
		return url() . '/images/' . $request->get('directory') . "/" . $name;
	}
}
