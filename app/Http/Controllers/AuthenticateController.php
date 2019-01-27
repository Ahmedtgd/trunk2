<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests;
use App\Models\Address;
use App\Models\User;
use App\Models\RoleUser;
use App\Http\Controllers\Controller;
use Hash;
use App\Models\Buyer;
use App\Models\BuyerAddress;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\EmailController;
class AuthenticateController extends Controller
{
	public function authenticate(Request $request)
							    {
		// 		grab credentials from the request
		$credentials = $request->only('email', 'password');
		
		try {
			// 			attempt to verify the credentials and create a token for the user
																					            if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'Invalid Username or Password,Try again!'], 401);
			}
		}
		catch (JWTException $e) {
			// 			something went wrong whilst attempting to encode the token
		return response()->json(['error' => 'could_not_create_token'], 500);
		}
		
		// 		all good so return the token
		return response()->json(compact('token'));
	}
	
	public function getAuthenticatedUser()
							{
		try {
			
			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}
			
		}
		catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			
			return response()->json(['token_expired'], $e->getStatusCode());
			
		}
		catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			
			return response()->json(['token_invalid'], $e->getStatusCode());
			
		}
		catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
			
			return response()->json(['token_absent'], $e->getStatusCode());
			
		}
		
		// 		the token is valid and we have found the user via the sub claim
														    return response()->json(compact('user'));
	}
	function getUser(Request $request){
		return "User Found";
	}
	
	function getConsignment(Request $request){
		$key = $request->only('key');
		$porder_id = $request->only('porder_id');
		$consignment = DB::table('delivery')
														->where('pickup_password','=',$key)
														->where('porder_id','=',$porder_id)
														->select('consignment_number','type')
														->get();
		
		return response()->json($consignment);
	}
	
	function register(Request $request){ 
		
		if (!isset($request)) {
			return response()->json(["status"=>"failure","message"=>"Empty forms are not accepted"]);
		}
		$validator = Validator::make($request->all(),[
												'username' => 'required|unique:users|max:100|min:7',
												'full_name' => 'required|min:3',
												'dob' => 'required',
												'password' => 'required|max:100|min:7|confirmed',
												'password_confirmation' => 'required',
												'language' => 'required',
												'mobile' => 'required|max:12|min:10',
												'gender' => 'required',
												// 		'photo' => 'image',
												'default1' => 'required',
												'default2' => 'required',
												'city_name' => 'required'
		
		]);
		if($validator->fails()){
			return $validator->errors();
		}
		else{
			$default_address = new Address;
			$default_address->city_id = $request->city_name;
			$default_address->line1 = $request->default1;
			$default_address->line2 = $request->default2;
			$default_address->save();
			$default_reference_id = $default_address->id;
			//c			reate user record
									$user = new User;
			$user->username = $request->username;
			$user->name = $request->full_name;
			$split_name = explode(" ", $request->full_name);
			if(sizeof($split_name)==1){
				$user->first_name = $split_name[0];
			}
			else if(sizeof($split_name)==2){
				$user->first_name = $split_name[0];
				$user->last_name = $split_name[1];
			}
			else if(sizeof($split_name)==3){
				$user->first_name = $split_name[0] .  " " . $split_name[1];
				$user->last_name = $split_name[2];
			}
			else if(sizeof($split_name)>=4){
				$user->first_name = $split_name[0] .  " " . $split_name[1];
				$user->last_name = $split_name[2] . " " . $split_name[3];
			}
			
			$user->nric = "";
			$user->email = $request->username;
			$user->language_id = $request->language;
			$user->occupation_id =$request->occupation;
			$user->birthdate = $request->dob;
			$user->mobile_no = $request->mobile;
			$user->password = Hash::make($request->password);
			$user->gender = $request->gender;
			$user->annual_income = $request->income;
			
			$user->save();
			$user_id = $user->id;
			
			$buyer_profile = new Buyer;
			$buyer_profile->user_id = $user_id;
			$buyer_profile->save();
			$buyer_profile_reference_id = $buyer_profile->id;
			
			$bad = new BuyerAddress;
			$bad->buyer_id = $buyer_profile_reference_id;
			$bad->address_id = $default_reference_id;
			$bad->save();
			
			//c			reate new user role
			$role = new RoleUser;
			$role->user_id = $user_id;
			$role->role_id = 2;
			$role->save();
			
			$e= new EmailController;
            $e->confirmEmail($request->username,2);

			return response()->json(['status'=>"success",'message'=>'user registered']);
		}
		//f		unction end
	}
}
