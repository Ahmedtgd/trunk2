<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SellerFridgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchant = \App\Models\Merchant::where('user_id',Auth::user()->id)->first();
        return view('seller.fridge',['selluser' => $merchant]);
    }


}
