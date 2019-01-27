<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($merchant_id=null)
    {
        if($merchant_id==null){
            $user_id = Auth::user()->id;
            $merchant = \App\Models\Merchant::where('user_id',$user_id)->first();
        } else{
            $merchant = \App\Models\Merchant::find($merchant_id);
        }
        
        $sproducts = $merchant->products()
                    ->with(['orders'=> function($query)
                    {
                        $query->select('quantity');
                    }])
                    ->select(
                        'product.id',
                        'product.name',
                        'product.photo_1',
                        'product.stock as qtystock',
                        'product.available as qtyleft'
                    )
                    ->get();
        // dd($sproducts->toArray());
        

        return view('seller.fridge',['selluser' => $merchant,'sproducts' => $sproducts]);
    }


}
