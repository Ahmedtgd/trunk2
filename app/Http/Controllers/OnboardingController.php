<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use DB;
// use bcrypt;
use App\Http\Controllers\Controller;
// Models
use App\Models\Address;
use App\Models\User;
use App\Models\Buyer;
use App\Models\RoleUser;
use Carbon;
 
class OnboardingController extends Controller
{
   /*
    This controller will cover two areas
    >Onboarding 
    >Tutorials

    Important , True is represented by 1
    and False by -1
    neutral is 0.
   */

    public function init_onboarding()
    {
        $steps=0;
        $name_status=False;
        $address_status=False;
        $email_status=False;
        $phone_status=False;
        $states=DB::table('state')->where('country_code','MYS')->get();
        $name=null;
        $email=null;

        if (!Auth::check()) {
            # User not a registered buyer case
            return view('onboarding.index')
            ->with('name',$name)
            ->with('address_status',$address_status)
            ->with('email_status',$email_status)
            ->with('phone_status',$phone_status)
            ->with('steps',4)
            ->with('states',$states)
            ->with('name',$name)
            ->with('email',$email)
            ;
        }
        // Recomendded : Do not use ELSE.
        if (Auth::check()) {
            # Check if user has name
            $name=Auth::user()->name;
            $email=Auth::user()->email;
        // 
        return view('onboarding.index')
            ->with('name_status',$name_status)
            ->with('address_status',$address_status)
            ->with('email_status',$email_status)
            ->with('phone_status',$phone_status)
            ->with('steps',4)
            ->with('name',$name)
            ->with('email',$email)
            ->with('states',$states)
            ;

        }
    }
    public function is_onboarding_required()
    {

        if (!Auth::check()) {
            return 1;    
        }
        if (Auth::check()) {
            // Check Name
            $name=Auth::user()->name;
            if (is_null($name)) {
                return 1;
            }
            $address_id=Auth::user()->default_address_id;
            if (is_null($address_id)) {
                return 2;
            }
            // Check if the address id is valid and no data corruption has happened.
            try {
                Address::find($address_id)->line1; 
            } catch (\Exception $e) {
                return 2;
            }
            
        }
        return -1;
    }

    public function onboard(Request $r)

    {
        $role_exists=True;

        // $v=$this->validate($r,
        //     [
        //         'full_name'=>'required|min:4|max:200',
        //         'email'=>'required|unique:users|email',
        //         'password'=>'required|min:7|max:20',
        //         'password_confirmation'=>'required',
        //         'address'=>'required|min:7'
        //     ]
        //     );
        // // json_encode($v);
        // //dump($v);
        // dd($r->full_name);
        try {
            // check if user exists
            $user_check=User::where('email',$r->email)->first();
            // Create User
            if (is_null($user_check)) {
                # code...
                    $user= new User;
                    $user->name=$r->full_name;
                    $user->email=$r->email;
                    $user->password=bcrypt($r->password);
                    $user->mobile_no=$r->phone;
                    $user->save();
                    $role_exists=False;
                    $roleuser=new RoleUser;
                    $roleuser->user_id=$user->id;
                    $roleuser->role_id=2;
                    $roleuser->save();
                    $buyer= new Buyer;
                    $buyer->user_id=$user->id;
                    $buyer->status='active';
                    $buyer->active_date=Carbon::now();
                    $buyer->save();
                    //dump("1");
                    Auth::loginUsingId($user->id);
            return response()->json(['status'=>'success','short_message'=>'onboarded','long_message'=>'Reloading page']);
            }
            if (!is_null($user_check)) {
            	// Check if password is correct
            	$newpassword= bcrypt($r->password);
            	if ($user_check->password==$newpassword) {
            		# code...
            		$user= User::find($user_check->id);
                    $user->name=$r->full_name;
                    $user->email=$r->email;
                    $user->password=bcrypt($r->password);
                    $user->mobile_no=$r->phone;
                    $user->save();
                    //s("2");
            	}
            	else{
            		return response()->json(['status'=>'failure','short_message'=>'UserExistsBadPassword','long_message'=>'Your account exists but the password does not match ']);
            	}
                    
            
             // Create Address
             if ($r->has('address')) {
                $a= new Address;
                $a->line1=$r->address;
                $a->line4="MALAYSIA";
                $a->city_id=$r->city_id;
                $a->postcode=$r->postcode;

                $a->save();
                //dump("3");
             }
             $u= User::find($user->id);
             $u->default_address_id=$a->id;
             // $u->default_address_id=$a->id;
             // $u->billing_address_id=$a->id;
             $u->save();
             // Create Buyer
            $buyer= new Buyer;
            $buyer->user_id=$user->id;
            $buyer->status='active';
            $buyer->active_date=Carbon::now();
            $buyer->save();
            // Add a role
            if ($role_exists==False) {
                # code...
                            $roleuser=new RoleUser;
            $roleuser->user_id=$user->id;
            $roleuser->role_id=2;
            $roleuser->save();
            }

            Auth::loginUsingId($user->id);
            return response()->json(['status'=>'success','short_message'=>'onboarded','long_message'=>'Reloading page']);
            	}
        } catch (\Exception $e) {
            //dump($e);
            // Rollbacks
            try {
            User::destroy($user->id);
            Buyer::destroy($buyer->id);
            RoleUser::destroy($user->id);
            } catch (\Exception $e) {
                 return response()->json(['status'=>'failure','short_message'=>'Rollback Error','long_message'=>'The server could not process your request. Please try again later.']);

            }

           
        }
    }
    public function address_modal()

    {
        $states=DB::table('state')->where('country_code','MYS')->get();
        return view("cart.new_address")
        ->with('states',$states);
    }
    public function new_default_address(Request $r)
    {
        if ($r->has('line1')) {
            $a= new Address;
                $a->line1=$r->line1;
                $a->line4="MALAYSIA";
                $a->city_id=$r->city_id;
                $a->postcode=$r->postcode;
            $a->save();
            // Replace default address_id in users table
            try {
                $u= User::find(Auth::user()->id);
                $u->default_address_id=$a->id;
                $u->save();
                return response()->json(['status'=>'success','short_message'=>$a->id,'long_message'=>'Address Updated']);
            } catch (\Exception $e) {
                return response()->json(['status'=>'failure','short_message'=>'Unauthorized Access','long_message'=>'User does not exists']);
            }
            
        }
        else{
            return response()->json(['status'=>'failure','short_message'=>'Invalid Address','long_message'=>'The address cannot be null']);
        }
    }
}
