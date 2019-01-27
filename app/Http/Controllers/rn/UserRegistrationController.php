<?php

namespace App\Http\Controllers\rn;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
/*ALL RESPONSES MUST BE JSON*/

class UserRegistrationController extends Controller
{


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
                        //    'photo' => 'image',
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
      //c     reate user record
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

      //c     reate new user role
      $role = new RoleUser;
      $role->user_id = $user_id;
      $role->role_id = 2;
      $role->save();

      $e= new EmailController;
            $e->confirmEmail($request->username,2);

      return response()->json(['status'=>"success",'message'=>'user registered']);
    }
    //f   unction end
  }
    public function form_filler($value='')
       {
           $ret=array();
           try {
                $occupations = DB::table('occupation')->select("id","name")->orderBy('name')->get();
                $languages = DB::table('language')->select("id","name")->orderBy('name')->get();
                $interests = DB::table('category')->select("id","name")->orderBy('name')->get();
                $banks = DB::table('bank')->select("id","name")->orderBy('name')->get();


           } catch (\Exception $e) {
               dump($e);
           }
           $ret=compact('occupations','languages','interests','banks');
           return response()->json($ret);
       }
}
