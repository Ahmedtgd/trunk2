<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use Session;
use DB;

class PasswordController extends Controller
{
    public function resetPassword(Request $r)
    {
        $key = Session::get('pswdresetkey');
        $key_from_form = $r->key;
        $uid = Session::get('pswdresetuid');
        $viewtype="whiteifonz";
        $user_id = $r->uid;
        if ($key_from_form != $key or $uid != $user_id) {
            return view('common.generic')->with('message_type', 'error')->with('message', 'Unauthorized access');
        }
        if ($key_from_form == $key and $uid == $user_id) {
            $u = User::find($uid);
            $u->password = bcrypt($r->password);
            $u->save();
        }
		User::where('id', $user_id)->update(['password_fail'=>0]);
        DB::table('buyer')->where('user_id', $user_id)->update(['status' => 'active']);      
        Session::forget('pswdresetuid');
        Session::forget('pswdresetkey');
        $message_type = "success";
        $message = "Password reset is successfull. Login using your new password";
        return view("common.generic")->with('message', $message)->with('message_type', $message_type)->with('viewtype',$viewtype);
    }

}
