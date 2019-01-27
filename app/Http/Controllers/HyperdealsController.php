<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Owarehouse;

class HyperdealsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Get Hyper deals data */

        $products = Owarehouse::join('product','owarehouse.product_id','=','product.id')
        ->join('oshopproduct','oshopproduct.product_id','=','product.id')
        ->join('oshop','oshop.id','=','oshopproduct.oshop_id')
        ->join('merchantoshop','merchantoshop.oshop_id','=','oshopproduct.oshop_id')
        ->join('merchantproduct','merchantproduct.product_id','=','product.id')
        ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
        ->where('oshop.status','active')
        ->where('merchant.status','active')
        ->where('product.oshop_selected',1)
        ->where('product.status','active')
        ->where('product.available','>',0)
        ->select('owarehouse.id as owarehouse_id','product.*')
        ->get();

        return view('deals')->with(compact('products'));
    }
}
