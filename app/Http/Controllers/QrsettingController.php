<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\QrbcContent;
use App\Models\Currency;
use App\Models\Product;
use App\Models\User;
use Auth;
class QrsettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$selluser = User::find(Auth::user()->id);
		$product =    $request->product;
		$currency = Currency::where('active','=',1)->first();
       
        if ($request->default) {
            $query  = Product::join('nproductid','product.id','=','nproductid.product_id')
            ->where('product.id','=',$request->product_id)->first();

			/*
			dump($request->product_id);
			dump($product);
			dump($query);
			*/

            $qrdata[0]['name'] = "default";
            $qrdata[0]['content'] = "";
            $qrdata[0]['id'] = 0;
            $qrdata[0]['nproduct_id'] =$query->nproduct_id;
            return view('product.qrsetting',compact('selluser'))->with('products',$qrdata)->with('currency',$currency);
        }
       foreach ($product as $key => $value) {

             $query  = Product::join('nproductid','product.id','=','nproductid.product_id')
             ->where('product.id','=',$key)->first();
            //->get();

             $qrdata[0]['name'] = $query->name;
             $qrdata[0]['content'] = $value;
             $qrdata[0]['id'] = $key;
             $qrdata[0]['nproduct_id'] = $query->nproduct_id;
             return view('product.qrsetting',compact('selluser'))->with('products',$qrdata)->with('currency',$currency);
         }
           /* 
            $qrdata[0]['name'] = "default";
            $qrdata[0]['content'] = $request->defaultexp;
            $qrdata[0]['id'] = 0;
            $qrdata[0]['nproduct_id'] = "xxxxxxxxxx";
            return view('product.qrsetting')->with('products',$qrdata)->with('currency',$currency);*/


         /* $qrdata  = QrbcContent::join('product','product.id','=','qrbc_content.product_id')
        ->join('nproductid','product.id','=','nproductid.product_id')
        ->whereIn('qrbc_content.id',$request->qr)->get() ;
        return view('product.qrsetting')->with('products',$qrdata)->with('currency',$currency);
*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
