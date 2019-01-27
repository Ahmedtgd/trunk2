<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class JCController extends Controller
{
	
    public function jcproductreg()
    {
		
		//telco table
		$telcos = DB::table('telco')->get();
        return view('jc.productreg')->with('telcos',$telcos);
    }

    public function jcoshop()
    {
        $telcos = DB::table('telco')->join('telcoproduct','telco.id','=','telcoproduct.telco_id')->select('telco.id as id','telco.description as description')->distinct()->get();
		foreach($telcos as $telco){
			$ntelco = DB::table('telcoproduct')->join('product','product.id','=','telcoproduct.product_id')->where('telcoproduct.telco_id',$telco->id)->first();
			$telco->photo_1 = $ntelco->photo_1;
			$tproduct = DB::table('telcoproduct')->join('product','product.id','=','telcoproduct.product_id')->where('telcoproduct.telco_id',$telco->id)->select('product.*')->distinct()->orderBy('product.id')->get();
			$mindex = 0;
			$telco->product_id = Array();
			$telco->product_price = Array();
			foreach($tproduct as $tproductd){	
				$telco->product_id[$mindex] = $tproductd->id;
				$telco->product_price[$mindex] = $tproductd->retail_price;
				$telco->parent_id = $tproductd->parent_id;
				$mindex++;
			}
			//dd($telco->product_id);
		}
		//dd($telcos);
        return view('jc.oshop')->with('telcos',$telcos);
    }	
	
    public function jccategory()
    {
        $telcos = DB::table('telco')->join('telcoproduct','telco.id','=','telcoproduct.telco_id')->select('telco.id as id','telco.description as description')->distinct()->get();
		foreach($telcos as $telco){
			$ntelco = DB::table('telcoproduct')->join('product','product.id','=','telcoproduct.product_id')->where('telcoproduct.telco_id',$telco->id)->first();
			$telco->photo_1 = $ntelco->photo_1;
			$tproduct = DB::table('telcoproduct')->join('product','product.id','=','telcoproduct.product_id')->where('telcoproduct.telco_id',$telco->id)->select('product.*')->distinct()->orderBy('product.id')->get();
			$mindex = 0;
			$telco->product_id = Array();
			$telco->product_price = Array();
			foreach($tproduct as $tproductd){	
				$telco->product_id[$mindex] = $tproductd->id;
				$telco->product_price[$mindex] = $tproductd->retail_price;
				$telco->parent_id = $tproductd->parent_id;
				$mindex++;
			}
			//dd($telco->product_id);
		}
		//dd($telcos);
        return view('jc.category')->with('telcos',$telcos);
    }	

    public function jcstore(Request $request)
    {
		$user_id = Auth::user()->id;
        $merchant_data = Merchant::where('user_id', $user_id)->first();
        $merchant_id = $merchant_data->id;
		$images = $request->file('product_photo');		
		$oshoptemplate = DB::table('oshop_template')->where('merchant_id',$merchant_id)->first();
		if($oshoptemplate->subcat_level == "1"){
			$subcategory = DB::table('subcat_level_1')->where('id',$oshoptemplate->subcat_id)->first();
		} else if($oshoptemplate->subcat_level == "2"){
			$subcategory = DB::table('subcat_level_2')->where('id',$oshoptemplate->subcat_id)->first();
		} else {
			$subcategory = DB::table('subcat_level_3')->where('id',$oshoptemplate->subcat_id)->first();
		}
		$category = DB::table('category')->where('id',$subcategory->category_id)->first();
		$input = $request->all();
		$parent = 0;
		for($j = 0; $j < count($input['telcoid']); $j++){
			$parent = 0;
			for($k = 0; $k < count($input['price' . $j]); $k++){
				$telcos = DB::table('telco')->where('id',$input['telcoid'][$j])->first();
				$telcos_name = "";
				if(!is_null($telcos)){
					$telcos_name = $telcos->description;
				}
				$product = new Product();
				$product_data = $product->jc_product($request, $images[$j], $merchant_id,$telcos_name,$input['price' . $j][$k],$k,$parent, $oshoptemplate->subcat_level, $subcategory->id, $category->id);
		
				$merchant_pro = new MerchantProduct();
				$merchant_pro_data = $merchant_pro->storeproduct($product_data, $merchant_id);
				DB::table('telcoproduct')->insert(['telco_id'=>$input['telcoid'][$j],'product_id'=>$product_data->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				//DB::table('oshopproduct')->insert(['merchant_id'=>$merchant_id,'product_id'=>$product_data->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				if($k == 0){
					$parent = $product_data->id;
				}
				DB::table('product')->where('id',$product_data->id)->update(['parent_id'=>$parent]);
			}
		}

		//dd($input);
		return json_encode("OK");
	}	
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
