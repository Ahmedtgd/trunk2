<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;

class JaguarController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($uid = null) {
		if (!Auth::check()) {
            return view('common.generic')
                ->with('message_type', 'error')
                ->with('message', 'Please login to access the page')
                ->with('redirect_to_login', 1);
        }

        if (is_null($uid)) {
            $user_id = Auth::id();
        } else {
            $user_id = $uid;
		}

        $selluser = User::find($user_id);

        /* ENDS */
        return view('jaguar.jaguar', compact('selluser'))
                        ->with("wholesaleprices", 0)
                        ->with("user_id", $selluser);
	}
}