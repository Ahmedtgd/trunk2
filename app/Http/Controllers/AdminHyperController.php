<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Owarehouse;
use App\Models\Owarehouse_pledge;
use App\Models\Product;

use Auth;
use DB;
use DateTime;

class AdminHyperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hypers=array();
        $ow=Owarehouse::orderBy('created_at','DESC')->get();
        // return $ow;
        // $ow= DB::table('owarehouse')->orderBy('created_at','desc')->get();
        // return $ow;
		
        foreach ($ow as $o) {
            $op= Product::find($o->product_id);
            if (!is_null($op)) {
                # code..
                try {
                    
                
                    $temp=array();
                    $temp['owarehouse_id']=$o->id;
                    $temp['product_id']=$o->product_id;
                    // dump($o->product_id);
                    $temp['parent_id']=$op->parent_id;
                    $temp['moq']=$op->owarehouse_moq;
                    $temp['moqpax']=$op->owarehouse_moqperpax;
                    $temp['price']=$op->owarehouse_price;
                    $discount= number_format((($op->retail_price-$op->owarehouse_price)/$op->retail_price) *100,2);
                    $temp['discount']=$discount;
                    $pledged_qty=0;
                    foreach (Owarehouse_pledge::where('owarehouse_id',$o->id)->lists('pledged_qty') as $k) {
                        $pledged_qty+=$k;
                    }
                    $left=$op->owarehouse_moq-$pledged_qty;
                    $temp['left']=$left;
                    $temp['pledged']=$pledged_qty* $op->owarehouse_price;
                    $temp['status']=$o->status;
                    $temp['created_at']=$o->created_at;
                    if(!is_null($o->duration)){
                        $modify=(string) $o->duration." days";
                    } else {
                        $modify=(string) "30 days";
                    }
                    
                    
                    try{
                        //dd($o->duration);
                        $temp['due_date']=$o->created_at->modify($modify);
                        $now = new DateTime();
                        $future_date = new DateTime($o->created_at->modify($modify));
                        $interval = $future_date->diff($now);
                        $temp['time_left']= $interval->format("%ad %hh");           
                    } catch (Exception $e){
                        
                        $temp['due_date']="";
                        $temp['time_left']= "";             
                    }
                    array_push($hypers,$temp);
                    } catch (\Exception $e) {
                    
                }
            }
            

            
        }
        // return $hypers;
        return view('admin.tblmgmt')
        ->with('hypers',$hypers)
        ;
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
