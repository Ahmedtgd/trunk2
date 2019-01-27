<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\MerchantEmerchant;
use App\Models\Receipt;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tproduct;
use App\Models\Station;
use App\Inventorycostproduct;
use App\Models\SOrder;
use App\Models\Sorderproduct;
use App\Models\POrder;
use Illuminate\Support\Facades\Session;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\emerchant;
use App\Models\Inventorycost;
use App\Models\LocationProduct;
use App\Models\User;
use App\NPorderid;
use Log;
use DB;
use Auth;
use Carbon;
class EinventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id=null)
    {
        if ($user_id==null) {
            $user_id     = Auth::user()->id;
        }

        $selluser = User::find($user_id);

        
        $merchant = Merchant::where('user_id','=',$user_id)->first();


        $products =   $merchant->products()
            ->join('merchantproduct as mp','mp.product_id','=','product.id')
            ->whereNull('mp.deleted_at')
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->where('product.status','!=','transferred')
            ->whereNull('product.deleted_at')
            ->whereIn('product.type',['product','platypos'])
            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.parent_id as tprid',
                'product.id as prid',
                'product.name as name',
                'product.thumb_photo as thumb_photo',
                'product.parent_id as parent_id',
                'product.retail_price as retail_price',
                'nproductid.nproduct_id as nproductid'
            ]);
        

        $currency = Currency::where('active','=',1)->first();
        //$emerchant =  emerchant::select('business_reg_no','company_name as first_name')->get();




        return view('seller.inventorycost.einventory',compact('selluser','products','stations','currency','user_id'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productdetail($id)
    {
        $product= Product::find($id);

        $returnproductTable = view('seller.inventorycost.einventory-product-ajax',compact('product',$product))->render();

        return $returnproductTable;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
         if ($request->user_id==null) {
           $user_id = Auth::user()->id;
        }
        else{
            $user_id= $request->user_id;
        }
        if ($request->isbuyer == "") {
            return 0;
        }

		Log::debug('isbuyer='.$request->isbuyer);

		/* return $request->doc_no;*/
        if ($request->doc_no == null || $request->doc_no == "") {
            return 1;
        } else if ($request->doc_date == null || $request->doc_date == "") {
            return 2;
        }

       $doc_check =  Inventorycost::where('doc_no',$request->doc_no)->get();

        if (count($doc_check)>0) {
            return 3;
        }

		Log::debug('doc_no='.$request->doc_no);


        $productsrequest =   $request->product;
        $productsrequest = array_filter($productsrequest,function($value){
            return $value>0;
        });

        $countproduct =  array_sum($productsrequest);

		Log::debug($productsrequest);
		Log::debug($countproduct);

        $buyermerchant = Merchant::where('user_id','=',
			$user_id)->pluck('id');

        $inventorycost = new Inventorycost();
        
        if ($countproduct>0) {
            if ($request->isbuyer==0) {
                $sellermerchant = $request->setbuyer;

            } else  {
                $sellermerchant = $request->setbuyer;
                $inventorycost->is_emerchant = 1;
            }
            $user_id = Auth::user()->id;
            $buyermerchant = Merchant::where('user_id','=',
            $user_id)->pluck('id');
           
            $inventorycost->seller_merchant_id = $sellermerchant;
            $inventorycost->buyer_merchant_id = $buyermerchant;
            $inventorycost->doc_no = $request->doc_no;
            $inventorycost->doc_date = $request->doc_date;

			Log::debug($inventorycost);

            if ($inventorycost->save()) {
                foreach ($productsrequest as $key => $value) {

                    $retailprice = Product::where('product.id','=',$key)
                    ->pluck('retail_price');
                    $setprice = 'setprice'.$key;
                    $inventorycostproduct = new Inventorycostproduct;
                    $inventorycostproduct->inventorycost_id = $inventorycost->id;
                    $inventorycostproduct->product_id = $key;
                    $inventorycostproduct->cost = $request->$setprice*100;
                    $inventorycostproduct->quantity = $value;

					Log::debug($inventorycostproduct);

                    $inventorycostproduct->save();
                }

               /* $receipt = Receipt::create([
                    'porder_id'=> $order->id,
                    'receipt_no'=> Receipt::max('receipt_no') +1
                ]);*/

               /* DeliveryOrder::create([
                    'receipt_id'=> $receipt->id,
                    'status'=>'pending',
                    'source'=>'gator',
                    'merchant_id'=>  Merchant::where('user_id','=',Auth::user()->id)->pluck('id')

                ]);
*/
            }

           
        }
         if ($request->has('stockreport') && $request->stockreport==1 && $request->has('location_id') && !empty($request->location_id)) {
                # code...
                $this->stockreport($request,$productsrequest);
        }

       /* $newpoid = UtilityController::generaluniqueid($order->id,
            '1','1', $order->created_at, 'nporderid', 'nporder_id');

        DB::table('nporderid')->insert(['nporder_id'=>$newpoid,
            'porder_id'=>$order->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]);*/

        return 4;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        //return    $request->all();
        $user_id=Auth::user()->id;

        if ($request->isbuyer=="") {
            return 0;
        }
        $productsrequest =   $request->product;
        $productsrequest = array_filter($productsrequest,function($value){
            return $value>0;
        });
        if (!count($productsrequest)) {
            return "1";
        }
        $productsrequest = array_filter($productsrequest,function($value){
            return $value>0;
        });
        $countproduct =  array_sum($productsrequest);

        foreach ($productsrequest as $key => $value) {


            $confirmproduct = Product::where('product.id','=',$key)->get(['retail_price','product.name','thumb_photo']);
           
            $setprice = 'setprice'.$key;

            if ($request->$setprice == 0) {
                return "2";
            }

            $product[$key]['name']      =   $confirmproduct[0]->name;
            $product[$key]['thumb']      =   $confirmproduct[0]->thumb_photo;
            $product[$key]['quantity']  =   $value;
            $product[$key]['id']        =   $key;
            $product[$key]['price']     =   $request->$setprice;
            $product[$key]['total']     =   $confirmproduct[0]->retail_price*$value;

          }
         
         $locations=DB::table('fairlocation')
         ->where('user_id',$user_id)
         ->whereNull('deleted_at')
         ->get();

        return view('seller.inventorycost.confirm-ajax',compact('product','locations'))->render();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function savebuyer(Request $request)
    {




        $emerchant = new Emerchant();
        $emerchant->company_name       =  $request->company_name;
        $emerchant->business_reg_no    =  $request->br;
        $emerchant->gst_reg_no         =  $request->gst;
        $emerchant->location           =  $request->location;
        $emerchant->address_line1      =  $request->address1;
        $emerchant->address_line2      =  $request->address2;
        $emerchant->address_line3      =  $request->address3;
        $emerchant->country_id         =  $request->country;
        $emerchant->state              =  $request->state;
        $emerchant->city               =  $request->city;
        $emerchant->postcode           =  $request->postcode;
        $emerchant->first_name         =  $request->fname;
        $emerchant->last_name          =  $request->lname;
        $emerchant->designation        =  $request->designation;
        $emerchant->mobile_no          =  $request->mobile;
        $emerchant->email              =  $request->email;
        $emerchant->save();

        MerchantEmerchant::create([
            'merchant_id'   => Merchant::where('user_id','=',Auth::user()->id)->pluck('id'),
            'emerchant_id'     => $emerchant->id
        ]);
        return $emerchant = Emerchant::find($emerchant->id);
    }

    public function testview()
    {
        $currency = Currency::where('active','=',1)->first();

        return view('viewtest',compact('currency'));
    }


   /* public function displaysalesorderdocument($id)
    {
       // return $id
        $merchantaddress = POrder::join('ordertproduct','ordertproduct.porder_id','=','porder.id')
        ->join('merchanttproduct','merchanttproduct.tproduct_id','=','ordertproduct.tproduct_id')
        ->join('merchant','merchanttproduct.merchant_id','=','merchant.id')
        ->join('address','merchant.address_id','=','address.id')
        ->join('users','merchant.user_id','=','users.id')
        ->where('porder.id','=',$id)
        ->get([
            'merchant.company_name',
            'address.line1',
            'address.line2',
            'address.line3',
            'address.line4',
            'users.first_name',
            'users.last_name',
            'merchant.user_id',
            'porder.created_at'
        ]);
        $emerchant = POrder::where('porder.id','=',$id)
        ->pluck('is_emerchant');
        if ($emerchant==1) 
        {
            $buyeraddress = POrder::join('emerchant','porder.user_id','=','emerchant.id')
            ->get([
                'emerchant.address_line1 as line1',
                'emerchant.address_line2 as line2',
                'emerchant.address_line3 as line3',
                'emerchant.company_name as line4'
            ]);
        }
        else
        {
            $buyeraddress = POrder::join('station','station.user_id','=','porder.user_id')
            ->join('address','station.address_id','=','address.id')
            ->where('porder.id','=',$id)
            ->get([
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
            ]);
        }
                   // return $buyeraddress;
        $invoice    =   POrder::join('ordertproduct','ordertproduct.porder_id','=','porder.id')
        ->join('ntproductid','ntproductid.tproduct_id','=','ordertproduct.tproduct_id')
        ->join('tproduct','ordertproduct.tproduct_id','=','tproduct.id')
        ->where('porder.id','=',$id)
        ->get([
            'ntproductid.ntproduct_id',
            'tproduct.description',
            'ordertproduct.quantity',
            'ordertproduct.order_price',

        ]);
        $currency = Currency::where('active','=',1)->pluck('code');
        $selluser = User::find(Auth::user()->id);
        $nporder_id = NPorderid::where('porder_id','=',$id)->pluck('nporder_id');
        return view('seller.inventorycost.salesorderdocument',compact('selluser'))->with('merchantaddress',$merchantaddress)->with('buyeraddress',$buyeraddress)->with('invoice',$invoice)->with('currency',$currency)->with('nporder_id',$nporder_id);
    }*/

    public function saveinventorycost($merchant_id,$is_emerchant,$doc_no,$doc_date)
    {
        $checkdoc_no = Inventorycost::where('doc_no','=',$doc_no)->first();

        if (isset($checkdoc_no)) {
            return 0;
        } else {
            return 1;
        }
       /* $merchant = Merchant::where('user_id','=',Auth::user()->id)->pluck('id');
        $inventorycost = new Inventorycost();
        $inventorycost->seller_merchant_id = $merchant_id;
        $inventorycost->buyer_merchant_id = $merchant;
        $inventorycost->is_emerchant = $is_emerchant;
        $inventorycost->doc_no = $doc_no;
        $inventorycost->doc_date = $doc_date;
        $inventorycost->save();
*/

    }

    public function inventorydetails($id,$uid=null)
    {
		if (!Auth::check()) {
			return "Please login";
		}

		$user_id=Auth::user()->id;
		if (!empty($uid) and Auth::user()->hasRole("adm")) {
			$user_id=$uid;
		}

		$company_id=DB::table('company')->
			where('owner_user_id',$uid)->
			whereNull('deleted_at')->
			pluck('id');

        if (empty($company_id)) {
            # code...
            return "missing company";
        }

        $is_staff=DB::table('member')
        ->where('user_id',$user_id)
        ->where('company_id',$company_id)
        ->whereNull('deleted_at')
        ->where('status','active')
        ->where('type','member')
        ->first();
        //dd($is_staff);
        if (empty($is_staff) and Auth::user()->id!=$uid) {
            # code...
            return "Not Authorized";
        }
        if (!empty($is_staff)) {
            # code...
            $user_id=$uid;
        }

		$merchant=DB::table("merchant")->
			where("user_id",$user_id)->
			whereNull("deleted_at")->
			orderBy("created_at","DESC")->first();

		$merchant_id=$merchant->id;
		Log::debug('merchant_id='.$merchant_id);
		Log::debug('product_id ='.$id);

		/*
        $average_cost = Inventorycost::where('inventorycost.buyer_merchant_id'
            ,$merchant_id)->
        join('inventorycostproduct','inventorycostproduct.inventorycost_id',
            '=','inventorycost.id')->
        where('inventorycostproduct.product_id',$id)->
        join('product','product.parent_id','=',
            'inventorycostproduct.product_id')->
        get([
            'inventorycostproduct.product_id',
            'inventorycostproduct.quantity',
            'inventorycostproduct.cost',
            'product.parent_id',
            'product.photo_1',
        ])->groupby('inventorycostproduct.product_id');

        //      ])->groupby('tproduct_id');
		*/


		$average_cost = DB::select(DB::raw('
		SELECT
			icp.id,
			icp.quantity,
			icp.cost,
			p.parent_id,
			p.photo_1
		FROM
			inventorycost ic,
			inventorycostproduct icp,
			product p
		WHERE
			ic.buyer_merchant_id='.$merchant_id.' and
			icp.inventorycost_id=ic.id and
			icp.product_id='.$id.' and
			p.parent_id=icp.product_id
		GROUP BY
			icp.id;'
		));


        $product=DB::table("product")
			->where("id",$id)
			->select("thumb_photo as image","id")
			->first();

        Log::debug($average_cost);

        $count =0; $avg=0; $add = 0; $qty = 0;
        foreach ($average_cost as $key => $value) {
			$add += ($value->cost * $value->quantity);
			$qty += ($value->quantity);
            $avg = $add/$qty;
			Log::debug('avg='.$avg);
        }

        $inventorydetails = Inventorycostproduct::where('product_id',$id)->
			join('inventorycost','inventorycost.id','=','inventorycostproduct.inventorycost_id')->
			where('inventorycost.buyer_merchant_id',$merchant_id)->
			orderBy('inventorycostproduct.created_at','DESC')->
			get([
				'inventorycostproduct.id',
				'inventorycostproduct.created_at',
				'inventorycostproduct.cost',
				'inventorycostproduct.quantity as purchaseqty',
			]);

		Log::debug($inventorydetails);

		/*
		$average_cost = Inventorycost::where('inventorycost.buyer_merchant_id'
            ,$merchant_id)->
        join('inventorycostproduct','inventorycostproduct.inventorycost_id',
            '=','inventorycost.id')->
        where('inventorycostproduct.product_id',$id)->
        join('product','product.parent_id','=',
            'inventorycostproduct.product_id')-> 
		*/



        $pr=new ProductController;
        $qtyleft=$pr->consignment($id,$user_id);

        Log::debug('qtyleft='.$qtyleft);

        if (!$qtyleft) {
            $qtyleft =0;
        }
      
       
        $html =  view('seller.inventorycost.inventorydetail_ajax',
			compact('inventorydetails','avg','qtyleft','product'))->render();

        return $html;
    }

    public function stockreport($r,$products)
    {

        if (!Auth::check()) {
            # code...
            return "bad login";
        }
        $user_id=Auth::user()->id;
        $company_id=DB::table("company")
        ->where('owner_user_id',$user_id)
        ->whereNull('deleted_at')
        ->pluck('id');

        $location_id=$r->location_id;
        
        $insert_data=[
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now(),
            "checked_on"=>Carbon::now(),
            "creator_user_id"=>$user_id,
            "checker_user_id"=>$user_id,
            "checker_company_id"=>$company_id,
            "creator_company_id"=>$company_id,
            "checker_location_id"=>$location_id,
            "creator_location_id"=>$location_id,
            "ttype"=>"tin",
            "method"=>"inventorycost",
            "status"=>"confirmed"
            ];
        $table="stockreport";
        $stockreport_id=DB::table($table)
            ->insertGetId($insert_data);
        Log::debug($products);
        foreach ($products as $key=>$value) {
                $quantity=$value;
                $product_id=$key;
                if ($quantity<1 or $product_id<1) {
                    Log::debug("Incorrect quantity or product_id");

                }else{
                    UtilityController::locationproduct($location_id,$product_id,$quantity,"add");
                    $insert_data=[
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now(),
                    "stockreport_id"=>$stockreport_id,
                    "product_id"=>$product_id,
                    "quantity"=>$quantity,
                    "received"=>$quantity,
                    "status"=>"checked",
                    ];
                    DB::table("stockreportproduct")->insert($insert_data);
                    Log::debug($insert_data);
                }
        }
            
    }
}
