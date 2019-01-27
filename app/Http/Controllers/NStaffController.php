<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;
use DB;
use Auth;
use Carbon;

class NStaffController extends Controller {

    public function generate() {
        return mt_rand(999, 1000000);
    }

    public function details($member_id) {
        // Requirements
        // For details we need to check if user is registered user or unregistered user.
        // For unregistered user email should be member.email
        // For unregistered user alternate email should be nstaff.alt_email
        // For registered user alternate email should be users.alt_email

        $member = DB::table("member")->where('id', $member_id)->first();
        $user = DB::table("users")->where('id', $member->user_id)->whereNull('deleted_at')->first();
        // $nstaff = DB::table('nstaff')->where('member_id', $member_id)->whereNull('deleted_at')->first();

        // if($nstaff){
        //     $nstaff->email = $member->email;
        //     $response = [
        //         'unregistered_user' => true,
        //         'data' => $nstaff,
        //     ];
        //     return response()->json($response);
        // }

        if(!empty($user)){
            // $nstaff->email = $member->email;

            $response = [
                'registered_user' => true,
                'data' => $member,
            ];
            return response()->json($response);
            
        }else{

            $nstaff = DB::table('nstaff')->where('member_id', $member_id)->whereNull('deleted_at')->first();
            if($nstaff){
                $nstaff->email = $member->email;
                $response = [
                    'unregistered_user' => true,
                    'data' => $nstaff,
                ];
                return response()->json($response);
            }
        }

        // The user must be registered user if control is here.
        if ($member) {
            $user = DB::table("users")->where('id', $member->user_id)->whereNull('deleted_at')->first();
            
            if (!empty($user)) {
                $user->id = sprintf("%010d",$user->id);
                $data = [
                    'registered_user' => true,
                    'data' => $user, 
                    'address' => DB::table('address')->where('id', $user->default_address_id)->first(),
                ];
                return response()->json($data);
            }
        }

        return response()->json(['message' => 'User doesnt exist'], 404);
    }

    public function save(Request $r) {
        if (!$r->has('member_id') || empty($r->member_id)) {
            return "Missing Member Id";
        }

        $user_id = ltrim($r->userid,"0");

        //check if user is already added as a member
        $Owneruser_id = Auth::user()->id;
        $Existingmembers = DB::table('member')->
            // leftJoin('users', 'users.id', '=', 'member.user_id')->
            // leftJoin('nstaff', 'nstaff.member_id', '=', 'member.id')->
            join('company', 'member.company_id', '=', 'company.id')->
            where('company.owner_user_id', $Owneruser_id)->
            where('member.type', 'member')->
            where('member.email',$r->modalStaffEmail)->
            where('member.id','!=',$r->member_id)->
            select(DB::raw("member.*"))
            ->groupBy("member.id")
            ->orderBy('created_at', 'DESC')
            ->get();

            if(count($Existingmembers)>0){
                return 0;
            }

        $member = DB::table('member')->where('id', $r->member_id)->first();
        if(empty($member)){
            return 'Invalid Member Id';
        }

        //check if user is registered
        if($user_id > 0){
           
            $addressData = [
                "line1" => $r->address_line1,
                "line2" => $r->address_line2,
                "line3" => $r->address_line3,
            ];

            // $userData = DB::table('users')->where('id', $member->user_id)->first();
            $userData = DB::table('users')->where('id', $user_id)->first();
            $addressQuery = DB::table('address')->where('id', $userData->default_address_id)->first();

            $addressID = null;
            if(!empty($addressQuery)){
                $addressID = DB::table('address')->where('id', $userData->default_address_id)->update($addressData);
            }else{
                  $addressID = DB::table('address')->insertGetId($addressData);
            }

            $data = [
                "default_address_id" => $addressID,
                // "alt_email" => $r->alt_email,
                "name" => $r->name,
                "mobile_no" => $r->mobile_no,
            ];
            DB::table('users')->where('id', $user_id)->update($data);
            DB::table('member')->where('id', $r->member_id)->update([
                        'user_id' => $user_id,
                        'email' => $r->modalStaffEmail,
                        ]);
        }else{
            
            //if user is unregistered 
            $nstaff = DB::table("nstaff")->where("member_id", $r->member_id)->whereNull("deleted_at")->first();

            if(!empty($nstaff) ){
                $data = [
                    "updated_at" => Carbon::now(),
                    "member_id" => $r->member_id,
                    "nickname" => $r->nickname,
                    "login_name" => $r->asloginno,
                    "name" => $r->name,
                    "address_line1" => $r->address_line1,
                    "address_line2" => $r->address_line2,
                    "address_line3" => $r->address_line3,
                    "alt_email" => $r->alt_email,
                    "mobile_no" => $r->mobile_no
                ];

                DB::table("nstaff")->where('id', $nstaff->id)->update($data);

                // Now lets do work if email was filled or not
                if($r->get('modalStaffEmail', null)){
                    $user = DB::table('users')->where('email', $r->get('modalStaffEmail'))->first();

                    if(!empty($user)){
                        DB::table('member')->where('id', $r->member_id)->update([
                            'user_id' => $user->id,
                            'email' => $user->email,
                        ]);
                    }else{
                        DB::table('member')->where('id', $r->member_id)->update([
                            'email' => $r->get('modalStaffEmail'),
                        ]);
                    }
                }
            }
        }

        // if(!empty($nstaff) ){

        //     echo "if";
        //     exit();
            // $data = [
            //     "updated_at" => Carbon::now(),
            //     "member_id" => $r->member_id,
            //     "nickname" => $r->nickname,
            //     "login_name" => $r->asloginno,
            //     "name" => $r->name,
            //     "address_line1" => $r->address_line1,
            //     "address_line2" => $r->address_line2,
            //     "address_line3" => $r->address_line3,
            //     "alt_email" => $r->alt_email,
            //     "mobile_no" => $r->mobile_no
            // ];
            // DB::table("nstaff")->where('id', $nstaff->id)->update($data);

            // // Now lets do work if email was filled or not
            // if($r->get('modalStaffEmail', null)){
            //     $user = DB::table('users')->where('email', $r->get('modalStaffEmail'))->first();

            //     if(!empty($user)){
            //         DB::table('member')->where('id', $r->member_id)->update([
            //             'user_id' => $user->id,
            //             'email' => $user->email,
            //         ]);
            //     }else{
            //         DB::table('member')->where('id', $r->member_id)->update([
            //             'email' => $r->get('modalStaffEmail'),
            //         ]);
            //     }
            // }
        // }else{
        //     echo "else";
        //     exit();
            // $addressData = [
            //     "line1" => $r->address_line1,
            //     "line2" => $r->address_line2,
            //     "line3" => $r->address_line3,
            // ];

            // $userData = DB::table('users')->where('id', $member->user_id)->first();
            // $addressQuery = DB::table('address')->where('id', $userData->default_address_id)->first();

            // $addressID = null;
            // if(!empty($addressQuery)){
            //     $addressID = DB::table('address')->where('id', $userData->default_address_id)->update($addressData);
            // }else{
            //       $addressID = DB::table('address')->insertGetId($addressData);
            // }

            // $data = [
            //     "default_address_id" => $addressID,
            //     "alt_email" => $r->alt_email,
            //     "name" => $r->name,
            //     "mobile_no" => $r->mobile_no,
            // ];
            // DB::table('users')->where('id', $member->user_id)->update($data);
        //}
        return "ok";
    }

    public function new_member($company_id, $user) {
        $data = [
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "status" => "active",
            "type" => "member",
            "company_id" => $company_id
        ];

        if (!empty($user)) {
            try {
                $data['user_id'] = $user->id;
            } catch (\Exception $e) {
                
            }
            $data['email'] = (!empty($user->email)) ? $user->email : null;
            $data['member_status'] = "tagged";
            $data['name'] = (!empty($user->name)) ? $user->name : '';
            $data['mobile'] = (!empty($user->mobile_no)) ? $user->mobile_no : '';
        }

        return DB::table('member')->insertGetId($data);
    }

    public function new_nstaff($member_id, $r) {
        $data = [
            "updated_at" => Carbon::now(),
            "member_id" => $member_id,
            "nickname" => $r->nickname,
            "login_name" => $r->login_name,
            "name" => $r->name,
            "address_line1" => $r->address_line1,
            "address_line2" => $r->address_line2,
            "address_line3" => $r->address_line3,
            "alt_email" => (!empty($r->alt_email)) ? $r->alt_email : '',
            "mobile_no" => $r->mobile_no
        ];
        $does_exist = DB::table("nstaff")
                ->where("member_id", $r->member_id)->whereNull("deleted_at")
                ->first();

        if (empty($does_exist)) {
            $data["created_at"] = Carbon::now();
            DB::table("nstaff")->insert($data);
        } else {
            DB::table("nstaff")->update($data);
        }
        return "ok";
    }

    public function validate_name(Request $r){
        $company = DB::table('company')->where('owner_user_id', Auth::user()->id)->first();

        if (empty($company)) {
            return "Company does not exist";
        }
        $company_id = $company->id;
        
        $is_nstaff = DB::table('nstaff')
                        ->whereNull('deleted_at')
                        ->where(function ($query) use ($r) {

                            if(!empty($r->nickname)){
                                $query->orWhere('nickname', $r->nickname)
                                ->orWhere('name', $r->nickname);
                            }

                            if(!empty($r->name)){
                                $query->orWhere('nickname', $r->name)
                                ->orWhere('name', $r->name);
                            }
                        })
                        ->first();

            if (!empty($is_nstaff)) {
                $nstaff_company_id = DB::table('member')
                        ->whereNull('deleted_at')
                        ->where('id', $is_nstaff->member_id)
                        ->pluck('company_id');
                
                if (!empty($nstaff_company_id) and $company_id == $nstaff_company_id) {
                    return -1;
                }
            }

    }

    public function add_new_staff(Request $r) {
        $email = $r->email;
        $user = DB::table("users")->where('email', $email)->whereNull('deleted_at')->first();
        $company = DB::table('company')->where('owner_user_id', Auth::user()->id)->first();

        if (empty($company)) {
            return "Company does not exist";
        }
        $company_id = $company->id;

        // Check if already a registered member
        if(!empty($email)){
            $is_member = DB::table('member')
                ->where('email', $email)
                ->where('company_id', $company_id)
                ->whereNull('deleted_at')
                ->first();
        }


        if (!empty($is_member)) {
            return -1;
        }

        $is_nstaff = DB::table('nstaff')
                ->whereNull('deleted_at')
                ->where(function ($query) use ($r) {

                    if(!empty($r->nickname)){
                        $query->orWhere('nickname', $r->nickname)
                          ->orWhere('name', $r->nickname);
                    }

                    if(!empty($r->name)){
                        $query->orWhere('nickname', $r->name)
                          ->orWhere('name', $r->name);
                    }
                })
                ->first();

        // return response()->json($is_nstaff);
        /*  
            Remove these queries.
            ->orWhere('alt_email', $email)
                ->orWhere('name', $r->name)
                ->orWhere('member_id', $r->member_id)

        */

        if (!empty($is_nstaff)) {
            $nstaff_company_id = DB::table('member')
                    ->whereNull('deleted_at')
                    ->where('id', $is_nstaff->member_id)
                    ->pluck('company_id');
            
            if (!empty($nstaff_company_id) and $company_id == $nstaff_company_id) {
                return -1;
            }
        }

        if (empty($user) || empty($email)) {
            $data = [
                "member_id" => $r->member_id,
                "nickname" => $r->nickname,
                "name" => $r->name,
                "address_line1" => $r->address_line1,
                "address_line2" => $r->address_line2,
                "address_line3" => $r->address_line3,
                "alt_email" => $r->email,
                "email" => $r->email,
                "mobile_no" => $r->mobile_no
            ];
            $user = (object) $data;
            $member_id = $this->new_member($company_id, $user);
            $user->member_id = $member_id;
            $user->login_name = $r->asloginno;
            $this->new_nstaff($member_id, $user);
        } else {
            $user->name = $user->first_name . " " . $user->last_name;
            $user->member_id = $this->new_member($company_id, $user);
        }
        $user->created_at = Carbon::now()->format('Y-m-d H:i:s');
        return response()->json($user);
    }

    public function emailinfo($email) {
        $user = DB::table('users')
                ->where('email', $email)
                ->whereNull('deleted_at')
                ->select('id', 'name', 'first_name', 'last_name', 'mobile_no')
                ->first();
        if (empty($user)) {
            return "notok";
        } 
        $user->id =  sprintf("%010d",$user->id);
        return response()->json($user);
    }

}