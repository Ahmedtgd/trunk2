<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LogisticVerifyWarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function check(Request $request)
    {
        /**This is a function that Checks if this
         * warranty Number has earlier been used
         *
         */
        $warranty = $request->warranty;
        $product_id = $request->product_id;

        $bc_product = DB::table('bc_management')
          //  ->join('bc_management', 'productbc.bc_management_id', '=', 'bc_management.id')
            ->leftjoin
            ('orderproductwarranty','bc_management.id','=','orderproductwarranty.warranty_bc_mgmt_id')
          //  ->where('productbc.product_id', $product_id)
            ->where('bc_management.barcode',$warranty)->first();

        if(is_null($bc_product)){
            return 1;
        }else{
            if($bc_product->warranty_used == 1){
                return 2;
            }
        }
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
