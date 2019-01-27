<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\MerchantEmerchant;
use App\Models\NdoID;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Http\Requests;
use App\Models\Product;
use App\Models\Station;
use App\Models\OrderProduct;
use App\Models\SOrder;
use App\Models\Sorderproduct;
use App\Models\POrder;
use Illuminate\Support\Facades\Session;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Emerchant;
use App\Models\User;
use App\Models\Wholesale;
use App\Models\Autolink;
use App\NPorderid;
use Mail;
use DB;
use Auth;
use Log;

use App\Http\Controllers\Controller;

class QuotationController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index($uid = null) 
    {
        if (!Auth::check()) 
        {
            return view('common.generic')
                ->with('message_type', 'error')
                ->with('message', 'Please login to access the page')
                ->with('redirect_to_login', 1);
        }

        if (is_null($uid)) {
            $user_id = Auth::id();
        } else {
            $user_id = $uid;
		}
        
        $user_id=Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            $user_id=$uid;
        }
        $selluser = User::find($user_id);

        Log::debug("selluser_id=" .$user_id);

        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $merchant_id=$merchant->id;

        Log::debug("merchant_id=" .$merchant_id);

        $query="
            SELECT
            DISTINCT 
            pp.parent_id as tprid,
            product.id as id,
            product.id as prid,
            product.segment as segment,
            product.name as name,
            product.thumb_photo as thumb_photo,
            product.parent_id as parent_id,
            product.private_available as offlineProd,
            product.private_retail_price as offlinePrice,
            
            wholesale.price as retail_price,
            wholesale.id as wid,
           
            product.id as product_id,
            np.nproduct_id as nproductid

            FROM 
            product 
            join product parent on parent.id=product.parent_id
            join merchantproduct mp on mp.product_id=product.parent_id
            join nproductid np on np.product_id=product.id
            inner join (
                select parent_id ,MAX(created_at) as created_at
                from 
                product
                group by parent_id
            ) pp on pp.parent_id=product.parent_id
			AND pp.created_at=product.created_at
            LEFT JOIN wholesale on wholesale.product_id=product.id

            WHERE
            mp.merchant_id=$merchant_id
            AND product.status != 'transferred'
            AND product.status != 'deleted'
            AND product.status !=''
            AND product.deleted_at IS NULL
            AND parent.status != 'transferred'
            AND parent.status != 'deleted'
            AND parent.status !=''
            AND parent.deleted_at IS NULL
            
            GROUP BY tprid
            ORDER BY offlinePrice DESC
        ";
        
        $products=DB::select(DB::raw($query));
        
        $index=0;
     
        foreach($products as $prods){
            /* Consignment */ 
            $pr=new ProductController;
            $offline=$pr->consignment($prods->tprid,$user_id);
            $prods->consignment_total=$offline;
        }
        
        $currency = Currency::where('active','=',1)->first();
        
        $wholesaleprices = Product::join('wholesale','wholesale.product_id',
			'=','product.id')->
			join('merchantproduct','product.parent_id','=',
				'merchantproduct.product_id')->
			where('merchantproduct.merchant_id','=',$merchant->id)->
			orderBy('wholesale.price','desc')->
			get([
				'wholesale.funit',
				'wholesale.unit',
				'wholesale.price',
				'wholesale.product_id as id',
			]);

        if(!is_null($merchant)) {
             $merchant_pro = $merchant->products()->
			 whereNull('product.deleted_at')->
			 leftJoin('product as productb2b', function($join) {
                $join->on('product.id', '=', 'productb2b.parent_id')->
				where('productb2b.segment','=','b2b');
            })->
			leftJoin('product as producthyper', function($join) {
                $join->on('product.id', '=', 'producthyper.parent_id')->
				where('producthyper.segment','=','hyper');
            })->
			leftJoin('tproduct as tproduct', function($join) {
                $join->on('product.id', '=', 'tproduct.parent_id');
            })->
			leftJoin('productbc','product.id','=','productbc.product_id')->
			leftJoin('bc_management','bc_management.id','=',
				'productbc.bc_management_id')->
			select(DB::raw('
				product.id,
				product.parent_id,
				bc_management.id as bc_management_id,
				productbc.deleted_at as pbdeleted_at,
				product.name,
				product.thumb_photo as photo_1,
				product.available,
				productb2b.available as availableb2b,
				producthyper.available as availablehyper,
				tproduct.available as warehouse_available,
				product.sku'))->
			groupBy('product.id')->
			where("product.status","!=","transferred")->
			where("product.status","!=","deleted")->
			where("product.status","!=","")->
			orderBy('product.created_at','DESC')->
			get();

            /* Use $merchant_pro to find out which product also has a record
             * in tproduct, related via:
             * $merchant_pro->id = $tproduct->parent_id */
             /*
            foreach($merchant_pro as $prod){
            }
            */

            foreach($merchant_pro as $prods) {
                $pr=new ProductController;
                $prods->consignment_total=$pr->consignment($prods->id,$user_id);
            }

            $merchant_prot = DB::table('product')->
				join('merchantproduct','merchantproduct.product_id','=',
					'product.id')->
				join('twholesale','twholesale.tproduct_id','=','product.id')->
				leftJoin('product as tproduct','product.id','=','product.id')->
				leftJoin('product as parent','product.parent_id','=',
					'parent.id')->
				where('product.status', '=', 'active')->
				whereNull('product.id')->
				where('merchantproduct.merchant_id',$merchant_id)->
				select('product.*')->
				distinct()->
				get();
        }
        /* ENDS */
        return view('quotation.quotation', compact(
			'selluser',
			'products',
			'stations',
			'currency',
			'wholesaleprices',
			'user_id',
			'merchant_pro'
		)); 
    }
    
    public function show(Request $request)
    {
        //return    $request->all();

        if ($request->isbuyer=="") 
        {
            return 0;
        }
        // var_dump($request->all());exit;
        $productsrequest =   $request->product;
     //   Log::debug("All Products ".$productsrequest );

        $productsrequest = array_filter($productsrequest,function($value)
        {
            return $value>0;
        });

        if (!count($productsrequest)) {
            return "1";
        }
        $productsrequest = array_filter($productsrequest,function($value){
            return $value>0;
        });
        $SelectedProductTotalprice = app('App\Http\Controllers\GatorInvoiceController')->calculateInvoiceAmount($productsrequest);
       
        $counproduct =  array_sum($productsrequest);
        
        foreach ($productsrequest as $key => $value) {
            $confirmproduct = Product::where('product.id','=',$key)->
				get(['product.name','product.thumb_photo',
				'product.parent_id']);
        
			$wholesaleprice  =  Wholesale::where('product_id','=',$key)->
				where('unit','>=',$value)->
				where('funit','<=',$value)->
				pluck('price');
			  
			if(empty($wholesaleprice)){
				$wholesaleprice  =  wholesale::where('product_id','=',$key)->
					orderBy('id','desc')->
					pluck('price');
			}
    
			// Log::debug('**** GatorController@show() *****');
			// Log::debug($wholesaleprice);
			// Log::debug('***** key  ='.$key.'   *****');
			// Log::debug('***** value='.$value.' *****');

          $product[$key]['name']        = $confirmproduct[0]->name;
          $product[$key]['thumb_photo'] = $confirmproduct[0]->thumb_photo;
          $product[$key]['parent_id'] = $confirmproduct[0]->parent_id;
          $product[$key]['quantity']  = $value;
          $product[$key]['id']        = $key;
          $product[$key]['price']     = $wholesaleprice;
          $product[$key]['total']     = $wholesaleprice*$value;
      }

      return view('seller.gator.confirm-ajax',
			compact('product','message','SelectedProductTotalprice'))->render();
    }
}
