<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
class ErrorMessagesController extends Controller
{
    public static function loginError()
    {
        if (!Auth::check()) {
            return ['status'=>'failure','short_message'=>'Unauthorized Access','long_message'=>'Please log in to use the feature'];
        }
        if (Auth::check()) {
            return ['status','short_message','long_message'];
        }
        return ['status'=>'failure','short_message'=>'Unknown','long_message'=>'Something bad happened. Rest assured our engineers are fixing it'];
    }
}
