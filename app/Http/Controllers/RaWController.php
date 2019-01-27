<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\RepairWarranty;
use App\Prdwarranty;
use App\Servicebk;
use App\Servicectr;
use Log;
use Carbon\Carbon;

class RaWController extends Controller
{
    public function warranty_management()
    {
        $user_id= Auth::user()->id;
        $selluser = User::find($user_id);
        $repair_warranties = DB::table('repair_warranty')->get();
        //dd($repair_warranties);
        foreach ($repair_warranties as $rw){
            $rw->product_name = DB::table('product')->where('id',$rw->product_id)->pluck('name');
            $rw->raw_id = DB::table('bc_management')->where('id',$rw->warranty_bcmgmt_id)->pluck('barcode');
            $rw->serial = DB::table('bc_management')->where('id',$rw->serial_bcmgmt_id)->pluck('barcode');
        }
        //return view('raw.warranty_management', compact(['selluser']));
        return view('raw.warranty_management',compact('repair_warranties','selluser'));
    }

    public function show_warranty(Request $request){
        $product_warranty = null;
        Log::debug("Serial".$request->pid);
        $wid = $request->wid;
        $pid = $request->pid;
        $bc_product = DB::table('bc_management')
                 ->leftjoin('orderproductwarranty','bc_management.id','=','orderproductwarranty.serial_bc_mgmt_id')
                 ->leftjoin('orderproductqty as opq', 'orderproductwarranty.orderproductqty_id','=','opq.id')
                  ->leftjoin('orderproduct as op','op.id','=','opq.orderproduct_id')
                 ->leftjoin('porder','porder.id','=','op.porder_id')
                ->leftjoin('product','op.product_id','=','product.id')
            ->leftjoin('invoice','invoice.porder_id','=','porder.id')
                ->leftjoin('brand','product.brand_id','=','brand.id')
                 ->where('bc_management.barcode', $pid)
                ->select('porder.is_emerchant','brand.name as brand_name','porder.user_id','porder.created_at as year',
                    'invoice.created_at as dealer_year')

            ->first();
       // dd($bc_product);
        /** WARNING This is hard coding the warranty period to one year */
        $warranty_period = 1;

        if($bc_product->is_emerchant){
          $merchant =  DB::table('emerchant')
                ->where('id',$bc_product->user_id)->pluck('company_name');
        }else{
            $merchant =  DB::table('merchant')
                ->where('user_id',$bc_product->user_id)->pluck('company_name');
        }
        return view('raw.show_warrenty', compact('wid','pid','merchant','bc_product','warranty_period','date'));
    }

    public function service_repair_book($id){
        $servicebk = null;
        return view('raw.service_repair_book', ['servicebk' => $servicebk]);
    }

    public function show_chitno($product_id){
        $chitno = Servicectr::find($product_id);
        return view('raw.show_chitno')->with('chitno', $chitno);
    }





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
