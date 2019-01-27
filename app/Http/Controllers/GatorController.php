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
use App\Http\Controllers\Controller;
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

class GatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uid=null) 
    {
        if (!Auth::check()) 
        {
			return view("common.generic")->
				with("message_type","error")->
				with("message","Please login to access this page.");
        }

        if (is_null($uid)) 
        {
            $user_id = Auth::id();
        } 
        else 
        {
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
            ) pp on pp.parent_id=product.parent_id AND pp.created_at=product.created_at
            left join wholesale on wholesale.product_id=product.id

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
        
       /* dd($products);*/
        $index=0;
     
        foreach($products as $prods){

            /* Consignment */ 

            $pr=new ProductController;
            $offline=$pr->consignment($prods->tprid,$user_id);
            $prods->consignment_total=$offline;
            
        }

  /*      dd($products);*/
        $currency = Currency::where('active','=',1)->first();
        //$emerchant =  Emerchant::select('business_reg_no','company_name as first_name')->get();

         $wholesaleprices = Product::join('wholesale','wholesale.product_id','=','product.id')
        ->join('merchantproduct','product.parent_id','=','merchantproduct.product_id')
        ->where('merchantproduct.merchant_id','=',$merchant->id)
        ->orderBy('wholesale.price','desc')
        ->get([
            'wholesale.funit',
            'wholesale.unit',
            'wholesale.price',
            'wholesale.product_id as id',
        ]);

        if(!is_null($merchant)){
             $merchant_pro = $merchant->products()
            ->whereNull('product.deleted_at')
            ->leftJoin('product as productb2b', function($join) {
                $join->on('product.id', '=', 'productb2b.parent_id')
                ->where('productb2b.segment','=','b2b');
            })
            ->leftJoin('product as producthyper', function($join) {
                $join->on('product.id', '=', 'producthyper.parent_id')
                ->where('producthyper.segment','=','hyper');
            })
            ->leftJoin('tproduct as tproduct', function($join) {
                $join->on('product.id', '=', 'tproduct.parent_id');
            })
        
            
        
            ->leftJoin('productbc','product.id','=','productbc.product_id')
            ->leftJoin('bc_management','bc_management.id','=','productbc.bc_management_id')
            ->select(DB::raw('
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
                
                product.sku'))
                /*->where('product.id',2699)*/
            // ->whereNull('bc_management.deleted_at')
            ->groupBy('product.id')

            //->limit(2) //danger Danger , to be commented in production
            ->where("product.status","!=","transferred")
            ->where("product.status","!=","deleted")
            ->where("product.status","!=","")
            
            ->orderBy('product.created_at','DESC')
            ->get();

            /* Use $merchant_pro to find out which product also has a record
             * in tproduct, related via:
             * $merchant_pro->id = $tproduct->parent_id */
             /*
            foreach($merchant_pro as $prod){
            }
            */

            foreach($merchant_pro as $prods){
              /*   $stockreport = DB::table('stockreport')->select('stockreport.*')->
                    join('stockreportproduct','stockreport.id','=',
                        'stockreportproduct.stockreport_id')->
                    where('stockreportproduct.product_id',$prods->id)->
                    where('stockreport.status','confirmed')->
                    orderBy('stockreport.checked_on', 'DESC')->
                    first();

                 if(!is_null($stockreport)){
                    $sttime = strtotime($stockreport->checked_on);
                    if($sttime == 0){
                       $prods->last_updated = null;
                   } else {
                       $prods->last_updated = $stockreport->checked_on;
                   }
                 } else {
                   $prods->last_updated = null;
                 }
*/
    
                $pr=new ProductController;
                $prods->consignment_total=$pr->consignment($prods->id,$user_id);
             /*   dump($prods->consignemt);*/
            }
          /*  exit();*/
            // dump($merchant_pro);
            $merchant_prot = DB::table('product')
            ->join('merchantproduct','merchantproduct.product_id','=','product.id')
            ->join('twholesale','twholesale.tproduct_id','=','product.id')
            ->leftJoin('product as tproduct','product.id','=','product.id')
            ->leftJoin('product as parent','product.parent_id','=','parent.id')
            ->where('product.status', '=', 'active')
            ->whereNull('product.id')
            ->where('merchantproduct.merchant_id',$merchant_id)
            ->select('product.*')
            ->distinct()
            ->get();
        } 
        return view('seller.gator.gator',compact('selluser','products','stations','currency','wholesaleprices','user_id','merchant_pro'));
    }


    public function gatorBuyer($source=null,$user_id=null)
    {
        Log::debug("Null ".$user_id);
         if ($user_id==null) {
             Log::debug("Null?");
            $user_id = Auth::user()->id;
        }
       
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $stations = DB::select("
           select
           m.id as 'merchant_id',
           m.company_name,
           concat(u.first_name,' ',u.last_name) as name,
           u.email,
           a.initiator,
           a.status,
           m.business_reg_no,
           n.nseller_id,
           m.created_at
           from
           autolink a,
           merchant m,
           nsellerid n,
           users u
           where
           a.initiator=u.id and
           m.user_id=a.initiator and
           a.status='linked' and
           n.user_id=m.user_id and
           a.responder=$merchant->id
           UNION select
           m.id as 'merchant_id',
           m.company_name,
           concat(u1.first_name,' ',u1.last_name) as name,
           u1.email,
           a.responder,
           a.status,
            m.business_reg_no,
           n.nseller_id,
           a.created_at
           from
           autolink a,
           merchant m,
           nsellerid n,
           users u,
           users u1
           where
           a.initiator=$user_id and
           u.id=a.initiator and
           a.responder=m.id and
           u1.id=m.user_id and
            n.user_id=m.user_id and 
           a.status='linked'
           UNION SELECT 
           g.id as 'merchant_id',
           g.company_name,
           concat(g.first_name,' ',g.last_name) as name,
           g.email,
           g.id,
           g.company_name,
           g.business_reg_no,
           (null),
           g.created_at
           FROM 
           emerchant g,
           merchantemerchant m
           WHERE 
           m.merchant_id=$merchant->id AND 
           g.id=m.emerchant_id
           ORDER BY created_at DESC 
           "
       );

        return view('seller.gator.gator-buyer',compact('stations','user_id'))->
			with('source',$source);
    }


    public function displaySaleOrder($id)
    {
		Log::debug('***** displaySaleOrder('.$id.') *****');

		if(!empty($id)) {
            DB::table('porder')->
                where('id', $id)->
                update(['staff_user_id' => Auth::user()->id]);
        }
	
        $merchant = POrder::join('orderproduct','orderproduct.porder_id','=',
				'porder.id')->
			join('product','product.id','=','orderproduct.product_id')->
			join('merchantproduct','merchantproduct.product_id','=',
				'product.parent_id')->
			join('merchant','merchantproduct.merchant_id','=','merchant.id')->
			leftjoin('address','merchant.address_id','=','address.id')->
			join('users','merchant.user_id','=','users.id')->
			leftjoin('nbuyerid','nbuyerid.user_id','=','merchant.user_id')->
			where('porder.id','=',$id)->
			first([
            'merchant.id',
                'merchant.company_name',
                'merchant.gst',
                'merchant.business_reg_no',
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
                'users.first_name',
                'users.last_name',
                'porder.staff_user_id as staff_id',
                'nbuyerid.nbuyer_id as user_id',
                'porder.created_at',
                'porder.updated_at',
                'porder.salesorder_no',
                'porder.user_id'
            ]);

		$staff = User::find(Auth::user()->id);

		Log::debug('staff='.json_encode($staff));
		Log::debug('merchant='.json_encode($merchant));

		$merchant->staff_id   = sprintf("%010d", $staff->id);
		$merchant->first_name = $staff->first_name;
		$merchant->last_name  = $staff->last_name;
      
        Log::debug('****** $merchant *****');
        Log::debug($merchant);

        $emerchant = POrder::where('porder.id','=',$id)->pluck('is_emerchant');
        Log::debug('is_emerchant='.$emerchant);

        if ($emerchant) {
			Log::debug('*** $emerchant=TRUE ***');
            Log::debug('$merchant->user_id='.$merchant->user_id);
            $buyeraddress = POrder::join('emerchant','emerchant.id','=',
				'porder.user_id')->
			where('porder.id','=',$id)->
			first([
                'emerchant.company_name',
                'emerchant.business_reg_no',
                'emerchant.address_line1 as line1',
                'emerchant.address_line2 as line2',
                'emerchant.address_line3 as line3',
                'emerchant.postcode',
                'emerchant.city',
                'emerchant.state',
                'emerchant.first_name',
                'emerchant.last_name'
            ]);
        } else {
			Log::debug('*** $emerchant=FALSE ***');
			Log::debug('$merchant->user_id='.$merchant->user_id);

            $buyeraddress = POrder::join('merchant','merchant.user_id','=',
				'porder.user_id')->
			leftjoin('address','merchant.address_id','=','address.id')->
			join('users','merchant.user_id','=','users.id')->
			where('porder.id','=',$id)->
		//	where('merchant.user_id','=',$merchant->user_id)->
			first([
                'merchant.company_name',
                'merchant.business_reg_no', 
                'address.line1 as line1',
                'address.line2 as line2',
                'address.line3 as line3',
                'address.line4 as line4',
//                'address.line3'.' '.'address.line4 as line3',
				'users.first_name as first_name',
				'users.last_name as last_name',
            ]);
        }

		Log::debug('******* $buyeraddress *******');
		//dd($buyeraddress);

        $invoice = POrder::join('orderproduct','orderproduct.porder_id','=',
			'porder.id')->
		join('nproductid','nproductid.product_id','=',
			'orderproduct.product_id')->
		join('product','orderproduct.product_id','=','product.id')->
		where('porder.id','=',$id)->
		get([
            'nproductid.nproduct_id',
            'product.name',
            'product.parent_id',
            'product.id as prid',
            'product.thumb_photo',
            'orderproduct.quantity',
            'orderproduct.approved_qty',
            'orderproduct.order_price',
        ]);
        $do = DeliveryOrder::where('merchant_id',$merchant->id)
            ->whereIn('deliveryorder.source',['gator','jaguar','imported'])
            ->join('ndeliveryorderid','deliveryorder.id','=','ndeliveryorderid.deliveryorder_id')
            ->leftjoin('receipt','receipt.id','=','deliveryorder.receipt_id')
            ->leftjoin('porder','receipt.porder_id','=','porder.id')
            ->where('porder.id', $id)
            ->leftjoin('fairlocation','fairlocation.id','=','deliveryorder.final_location_id')
            ->leftjoin("deliveryorderstockreport","deliveryorderstockreport.deliveryorder_id","=","deliveryorder.id")
            ->leftjoin("stockreport","stockreport.id","=","deliveryorderstockreport.stockreport_id")
            ->leftjoin('member', function ($join) {
                $join->on('deliveryorder.member_id','=','member.id')
                    ->where('member.status','=','active');
            })->leftjoin('users as dlv', function ($join) {
                $join->on('dlv.id','=','member.user_id');
            })
            ->orderby('deliveryorder.created_at','desc')
     //           ->first();
            ->first([
                DB::raw('deliveryorder.*'),
                'ndeliveryorderid.ndeliveryorder_id as ndid',
                'deliveryorder.id as do_id',
                'porder.id as porder_id',
                'deliveryorder.deliveryorder_no'

            ]);
         
        Log::debug("**************************Delivery Order********************");
           Log::debug("Delivery Order" .$do);
        Log::debug("**************************Delivery Order********************");


        $currency = Currency::where('active','=',1)->
			pluck('code');
        $nporder_id = NPorderid::where('porder_id','=',$id)->
			pluck('nporder_id');

		return view('seller.gator.saleorder')->
			with('merchant',$merchant)->
			with('id',$id)->
            with('do',$do)->
			with('buyeraddress',$buyeraddress)->
			with('invoice',$invoice)->
			with('currency',$currency)->
			with('nporder_id',$nporder_id);
      
    }
    public function price_list($id){
      
        //Get the merchant
        $merchant = POrder::join('orderproduct','orderproduct.porder_id','=','porder.id')->join
        ('product','product.id','=','orderproduct.product_id')->join
        ('merchantproduct','merchantproduct.product_id','=','product.parent_id')->join
        ('merchant','merchantproduct.merchant_id','=','merchant.id')->leftjoin
        ('address','merchant.address_id','=','address.id')->join
        ('users','merchant.user_id','=','users.id')->join
        ('nbuyerid','nbuyerid.user_id','=','merchant.user_id')->where
        ('porder.id','=',$id)->first
        ([
            'porder.salesorder_no',
            'porder.user_id'
        ]);
        $user_id=Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
         $Dstatus = DeliveryOrder::where('merchant_id',$merchant->id)
            ->whereIn('deliveryorder.source',['gator','jaguar','imported'])
            ->join('ndeliveryorderid','deliveryorder.id','=','ndeliveryorderid.deliveryorder_id')
            ->leftjoin('receipt','receipt.id','=','deliveryorder.receipt_id')
            ->leftjoin('porder','receipt.porder_id','=','porder.id')->
               leftjoin('invoice','porder.id','=','invoice.porder_id')
            ->select('deliveryorder.status','deliveryorder.member_id','invoice.direct')
            ->where('porder.id', $id)
            ->first();
        //Nporder id
        //dd($Dstatus->direct);
        $nporder_id = NPorderid::where('porder_id','=',$id)->pluck('nporder_id');

        $currency = Currency::where('active','=',1)->pluck('code');
        $sales_order = DB::table('porder')->where('id',$id)->first();
        $invoice = POrder::join('orderproduct','orderproduct.porder_id','=','porder.id')->
        join('nproductid','nproductid.product_id','=',
            'orderproduct.product_id')->
        join('product','orderproduct.product_id','=','product.id')->
        where('porder.id','=',$id)->
        get([
            'nproductid.nproduct_id',
            'product.name',
            'product.parent_id',
            'product.has_serialno',
            'product.type as ptype',
            'product.id as prid',
            'product.thumb_photo',
            'orderproduct.quantity',
            'orderproduct.approved_qty',
            'orderproduct.order_price',
            'orderproduct.id as orderproductId'
        ]);

          $ProductData = DB::table('orderproduct')
          // ->leftjoin('orderproduct','orderproduct.porder_id','=','porder.id')
          ->join('product','orderproduct.product_id','=','product.id')
              ->join('orderproductqty as opq', 'opq.orderproduct_id','=','orderproduct.id')
          ->leftjoin('orderproductwarranty','opq.id','=','orderproductwarranty.orderproductqty_id')

          ->where('orderproduct.porder_id',$id)
          ->select('product.id as pid',
            'product.name as pname',
            'orderproduct.id as opid',
            'orderproductwarranty.serial_no as imeiNo',
            'orderproductwarranty.warranty_no as warrantyNo',
            'orderproduct.approved_qty','orderproduct.quantity'
          )
          // ->groupby('orderproduct.id')
          ->orderby('orderproductwarranty.created_at','desc')
          ->get();
          
          $ImeiWArranty = array();
          foreach ($ProductData as $key => $ImeiOrderproductId) {
            $productId = $ImeiOrderproductId->pid;

            if(!isset($ImeiWArranty[$productId])){
              $ImeiWArranty[$productId] = (array)$ImeiOrderproductId;
              $ImeiWArranty[$productId]['imeiDetail']= array();
            }
              $Numbers = array();
              $Numbers['imeiNo'] = '';
              $Numbers['warrantyNo'] = '';
            
              if($ImeiOrderproductId->imeiNo != '' || $ImeiOrderproductId->imeiNo != 0 ){
                $Numbers['imeiNo'] = $ImeiOrderproductId->imeiNo;
              }
              if($ImeiOrderproductId->warrantyNo != '' || $ImeiOrderproductId->warrantyNo != 0){
                $Numbers['warrantyNo'] = $ImeiOrderproductId->warrantyNo;
              }
            
              
            array_push($ImeiWArranty[$productId]['imeiDetail'], $Numbers);
          }
        Log::debug("This is the invoice of the price list");
        Log::debug($invoice);
        Log::debug("This is the invoice of the price list");

        return view('seller.logistics.price_list')->
                            with('invoice',$invoice)->
                            with('id',$id)->
                            with('sales_order',$sales_order)->
                            with('merchant',$merchant)->
                            with('nporder_id',$nporder_id)->
                            with('Dstatus',$Dstatus->status)->
                            with('direct',$Dstatus->direct)->
                            with('DmanID',$Dstatus->member_id)->
                            with('ImeiWArranty',$ImeiWArranty)->
                            with('currency',$currency);

    }

    public function price_check(Request $request){
        $user_id = Auth::user()->id;
        $porder_id = $request['id'];
        $product_id = $request['prod_id'];
        $qty = $request['qty'];
        $merchant_id = Merchant::where('user_id',$user_id)->pluck('id');

        $fetch_qty = DB::table('orderproduct')->
			where([
				'porder_id' => $porder_id,
				'product_id' => $product_id
			])->first();

        if($fetch_qty->quantity <= 0){
            return response()->json(['response' => 'Zero']);

        }else{
            if($qty > $fetch_qty->quantity){
                return response()->json(['response' => 'One']);

            }else{
                $diff = $fetch_qty->quantity - $qty;
				$update = DB::table('orderproduct')->
				 	where([
						'porder_id' => $porder_id,
						'product_id' => $product_id
					])->update(['approved_qty' => $qty]);

                if($update){

                   $opqs =  DB::table('orderproductqty')->
                   join('orderproduct','orderproduct.id','=','orderproductqty.orderproduct_id')->
                       where('orderproduct.product_id',$product_id)->
                   where('orderproduct.porder_id', $porder_id)->orderBy('orderproductqty.id','desc')->
                       select('orderproductqty.id as opqid')
                       ->get();

                    for($i = 0; $i < $diff; $i++){
                        Log::debug('Update dleted at of '.$opqs[$i]->opqid);
                       $updated =  DB::table('orderproductqty')->where('id',$opqs[$i]->opqid)->update(['deleted_at' => Carbon::now()]);
                        if($updated){
                            Log::debug('Deleted '.$opqs[$i]->opqid);
                        }
                    }

                }
                
				$deliveryId = DB::table('receipt')->
					leftjoin('deliveryorder','deliveryorder.receipt_id','=','receipt.id')->
					leftjoin('invoice','invoice.porder_id','=','receipt.porder_id')->
					select('deliveryorder.id as doid','invoice.invoice_no')->
					where('receipt.porder_id',$porder_id)->where('deliveryorder.merchant_id',$merchant_id)->
					first();

				$doid = '';
				//if(count($deliveryId)>0){
                    if(!empty($deliveryId)){
					$doid = sprintf('%010d', $deliveryId->doid );
				}

				return response()->json([
					'response' => 'Two',
					'quantity' => $qty,
					'deliveryId' => $doid
				]);
            }
        }
    }

    public function printPage($id,$nid = null,$heading =null)
    {
        $merchant = POrder::join('orderproduct','orderproduct.porder_id','=',
            'porder.id')->
        join('product','product.id','=','orderproduct.product_id')->
        join('merchantproduct','merchantproduct.product_id','=',
            'product.parent_id')->
        join('merchant','merchantproduct.merchant_id','=','merchant.id')->
        leftjoin('address','merchant.address_id','=','address.id')->
        join('users','merchant.user_id','=','users.id')->
        join('nbuyerid','nbuyerid.user_id','=','merchant.user_id')->
        where('porder.id','=',$id)->
        first([
            'merchant.company_name',
            'merchant.gst',
            'merchant.business_reg_no',
            'address.line1',
            'address.line2',
            'address.line3',
            'address.line4',
            'users.first_name',
            'users.last_name',
            'merchant.user_id as staff_id',
            'nbuyerid.nbuyer_id as user_id',
            'porder.created_at',
            'porder.salesorder_no',
            'porder.user_id'
        ]);

		$staff = User::find(Auth::user()->id);
		$merchant->staff_id   = sprintf("%010d", $staff->id);
		$merchant->first_name = $staff->first_name;
		$merchant->last_name  = $staff->last_name;

        $emerchant = POrder::where('porder.id','=',$id)
            ->pluck('is_emerchant');

        if ($emerchant) {
            Log::debug('*** $emerchant=TRUE ***');
            $buyeraddress = POrder::join('emerchant','emerchant.id','=',
                'porder.user_id')->
            where('porder.id','=',$id)->
            first([
                'emerchant.company_name',
                'emerchant.business_reg_no',
                'emerchant.address_line1 as line1',
                'emerchant.address_line2 as line2',
                'emerchant.address_line3 as line3',
            ]);

        } else {
            Log::debug('*** $emerchant=FALSE ***');
            Log::debug('$merchant->user_id='.$merchant->user_id);

            $buyeraddress = POrder::join('merchant','merchant.user_id','=',
                'porder.user_id')->
            join('address','merchant.address_id','=','address.id')->
            where('porder.id','=',$id)->
            where('merchant.user_id','=',$merchant->user_id)->
            first([
                'merchant.company_name',
                'merchant.business_reg_no',
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
            ]);
        }
        // return $buyeraddress;
        $invoice    =   POrder::join('orderproduct','orderproduct.porder_id','=','porder.id')
            ->join('nproductid','nproductid.product_id','=','orderproduct.product_id')
            ->join('product','orderproduct.product_id','=','product.id')
            ->where('porder.id','=',$id)
            ->get([
                'nproductid.nproduct_id',
                'product.name',
                'product.parent_id',
                'product.id as prid',
                'product.thumb_photo',
                'orderproduct.quantity',
                'orderproduct.order_price',

            ]);
        $p_order = POrder::find($id);
        $status = $p_order->status;
        $time = $p_order->updated_at;

        $currency = Currency::where('active','=',1)->pluck('code');
        $selluser = User::find(Auth::user()->id);
        $nporder_id = NPorderid::where('porder_id','=',$id)->
        pluck('nporder_id');

        return view('seller.gator.print_page',
            compact('selluser','nid','heading'))->
        with('merchant',$merchant)->
        with('id',$id)->
        with('buyeraddress',$buyeraddress)->
        with('invoice',$invoice)->
        with('status',$status)->
        with('time',$time)->
        with('currency',$currency)->
        with('nporder_id',$nporder_id);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productdetail($id)
    {
        $product= Product::find($id);

        $returnproductTable = view('seller.gator.gator-product-ajax',compact('product',$product))->render();

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
        Log::debug('The sent Request User');
        Log::debug($request->user_id);
        Log::debug('*************************************************');
        if (($request->user_id==null) || ($request->user_id == 0) ) {
           $user_id = Auth::user()->id;
        }
        else{
            $user_id= $request->user_id;
        }
        if ($request->isbuyer=="") {
            return 0;
        }
       // dd($request);
        $productsrequest =   $request->product;
        $productsrequest = array_filter($productsrequest,function($value){
            return $value>0;
        });
        $counproduct =  array_sum($productsrequest);

       // $salesorder_no = POrder::where('user_id','=',)

        $order = new POrder;
        if ($counproduct>0) {
            if ($request->isbuyer == 0) {
                Log::debug("****Merchant********");

                $merchant = $request->setbuyer;
                Log::debug($merchant);
                $merchant_user_id = Merchant::where('id','=',$merchant)->
					pluck('user_id');
                Log::debug("Merchant User_id");
                Log::debug($merchant_user_id);
               $s_no = Merchant::where('id','=',$merchant)->
               max('salesorder_no');
            } else {
                $merchant_user_id = $request->setbuyer;
                Log::debug("****EMerchant********");
                Log::debug($merchant_user_id);
                $order->is_emerchant = 1;
                $s_no =   DB::table('emerchant')
                    ->where('id',$merchant_user_id)->max('salesorder_no');
            }
            Log::debug("****Suspected User_id********");
            Log::debug($user_id);
            Log::debug("****SalesOrder Number********");
            // $s_no = Merchant::where('user_id',$user_id)->max('salesorder_no');
          //  $s_no = DB::table('porder')->where('user_id',$merchant_user_id)->max('salesorder_no');
            $order->salesorder_no = $s_no+1;
            Log::debug("Famed Sales No ".$s_no);
            if($request->isbuyer == 0){
                Log::debug("Updated Merchant");
                Merchant::where('user_id',$merchant_user_id)->update([
                    'salesorder_no'=> $s_no+1
                ]);
            }else{
                Log::debug("Updated Emerchant");
                DB::table('emerchant')
                    ->where('id',$merchant_user_id)->update([
                        'salesorder_no'=> $s_no+1
                    ]);
            }


            $order->user_id = (int) $merchant_user_id;
            $order->logistic_id = NULL;
            $order->courier_id    = 0;
            $order->payment_id    = 0;
            $order->order_administration_fee    = NULL;
            $order->osmall_comm_percent    = 0;
            $order->smm_comm_percent    = 0;
            $order->log_comm_percent    = 0;
            $order->description    = NULL;
            $order->source    = "b2b";
            $order->status    = "completed";
            $order->delivery_mode    = "own";
            $order->cre_count    = 0;
            $order->mode    = "gator";
            $order->prev_m_approved    = "b-returning";
            $order->prev_completed    = "b-approved";

            if ($order->save()) {
                foreach ($productsrequest as $key => $value) {
                    /*$retailprice = product::join('product','product.id','=','product.product_id')
                        ->where('product.id','=',$key)
                        ->pluck('retail_price');*/
                      
				$wholesaleprice  =  wholesale::where('product_id','=',$key)->
					where('unit','>=',$value)->
					where('funit','<=',$value)->
					pluck('price');
          
					$Orderproduct                          = new OrderProduct;
					$Orderproduct->porder_id               = $order->id;
					$Orderproduct->product_id              = $key;
					$Orderproduct->order_price             = $wholesaleprice;
					$Orderproduct->order_delivery_price    = 0;
					$Orderproduct->payment_gateway_fee     = 0;
					$Orderproduct->quantity                = $value;
					$Orderproduct->actual_delivery_price   = 0;
					$Orderproduct->shipping_cost           = 0;
					$Orderproduct->crereason_id            = 0;

					$Orderproduct->save();
                    Log::debug("Save to Orderproductqy");
                    if($Orderproduct->save()){
                        for($i =1; $i <= $value; $i++){
                           DB::table('orderproductqty')->insert(['orderproduct_id' => $Orderproduct->id,'qty_no' => $i]);
                        }
                    }
				}

				$receipt = Receipt::create([
					'porder_id'=> $order->id,
					'receipt_no'=> Receipt::max('receipt_no') +1
				]);

                $new_do =  DeliveryOrder::create([
					'receipt_id'=> $receipt->id,
					'status'=>'pending',
					'source'=>'gator',
					'merchant_id'=> 
						Merchant::where('user_id','=',$user_id)->pluck('id')
                   // 'member_id' => $merchant_user_id
				]);

                NdoID::create([
                    'ndeliveryorder_id'=> 
						UtilityController::generaluniqueid(
							$new_do->id, '3', '1',
							$new_do->created_at,
							'ndeliveryorderid',
							'ndeliveryorder_id'
						),
                    'deliveryorder_id'=> $new_do->id
                ]);
			}
		}


            $newpoid = UtilityController::generaluniqueid($order->id,
                '1','1', $order->created_at, 'nporderid', 'nporder_id');

            DB::table('nporderid')->insert(['nporder_id'=>$newpoid,
                'porder_id'=>$order->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')]);

			Log::debug("porder_id=" . $order->id);
            return $order->id;
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

        if ($request->isbuyer=="") {
            return 0;
        }
        $productsrequest =   $request->product;
     //   Log::debug("All Products ".$productsrequest );

        $productsrequest = array_filter($productsrequest,function($value){
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
    
			Log::debug('**** GatorController@show() *****');
			Log::debug($wholesaleprice);
			Log::debug('***** key  ='.$key.'   *****');
			Log::debug('***** value='.$value.' *****');

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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function savebuyer(Request $request)
    {
        $emerchant = new emerchant();
        $emerchant->company_name       =  $request->company_name;
        $emerchant->business_reg_no    =  $request->br;
        $emerchant->gst_reg_no         =  $request->gst;
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
        $user_id = Auth::user()->id;
        MerchantEmerchant::create([
            'merchant_id'   => Merchant::where('user_id','=',$user_id)->pluck('id'),
            'emerchant_id'     => $emerchant->id
        ]);
        return $emerchant = Emerchant::find($emerchant->id);
    }

    public function testview()
    {
        $currency = Currency::where('active','=',1)->first();

        return view('viewtest',compact('currency'));
    }


    public function displaysalesorderdocument($id,$nid = null,$heading =null)
    {
        $merchant = POrder::join('orderproduct','orderproduct.porder_id','=',
            'porder.id')->
        join('product','product.id','=','orderproduct.product_id')->
        join('merchantproduct','merchantproduct.product_id','=',
            'product.parent_id')->
        join('merchant','merchantproduct.merchant_id','=','merchant.id')->
        leftjoin('invoice','invoice.porder_id','=','porder.id')->
        leftjoin('address','merchant.address_id','=','address.id')->
        join('users','merchant.user_id','=','users.id')->
        join('nbuyerid','nbuyerid.user_id','=','merchant.user_id')->
        where('porder.id','=',$id)->
        first([
            'merchant.company_name',
            'merchant.gst',
            'merchant.business_reg_no',
            'address.line1',
            'address.line2',
            'address.line3',
            'address.line4',
            'users.first_name',
            'users.last_name',
            'merchant.user_id as staff_id',
            'nbuyerid.nbuyer_id as user_id',
            'porder.created_at',
            'porder.salesorder_no',
            'porder.user_id',
            'porder.id as pid',
            'invoice.invoice_no',
            'invoice.id as invoice_id'
        ]);


		$staff = User::find(Auth::user()->id);
		$merchant->staff_id   = sprintf("%010d", $staff->id);
		$merchant->first_name = $staff->first_name;
		$merchant->last_name  = $staff->last_name;

        $emerchant = POrder::where('porder.id','=',$id)
            ->pluck('is_emerchant');

        if ($emerchant) {
            Log::debug('*** $emerchant=TRUE ***');
            $buyeraddress = POrder::join('emerchant','emerchant.id','=',
                'porder.user_id')->
            where('porder.id','=',$id)->
            first([
                'emerchant.company_name',
                'emerchant.business_reg_no',
                'emerchant.address_line1 as line1',
                'emerchant.address_line2 as line2',
                'emerchant.address_line3 as line3',
            ]);

        } else {
            Log::debug('*** $emerchant=FALSE ***');
            Log::debug('$merchant->user_id='.$merchant->user_id);

            $buyeraddress = POrder::join('merchant','merchant.user_id','=',
                'porder.user_id')->
            join('address','merchant.address_id','=','address.id')->
            where('porder.id','=',$id)->
            where('merchant.user_id','=',$merchant->user_id)->
            first([
                'merchant.company_name',
                'merchant.business_reg_no',
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
            ]);
        }
        // return $buyeraddress;
        $invoice    =   POrder::join('orderproduct','orderproduct.porder_id','=','porder.id')
            ->join('nproductid','nproductid.product_id','=','orderproduct.product_id')
            ->join('product','orderproduct.product_id','=','product.id')
            ->where('porder.id','=',$id)
            ->get([
                'nproductid.nproduct_id',
                'product.name',
                'product.parent_id',
                'product.id as prid',
                'product.thumb_photo',
                'orderproduct.quantity',
                'orderproduct.order_price',

            ]);
        $p_order = POrder::find($id);
        $status = $p_order->status;
        $time = $p_order->updated_at;

        $currency = Currency::where('active','=',1)->pluck('code');
        $selluser = User::find(Auth::user()->id);
        $nporder_id = NPorderid::where('porder_id','=',$id)->
        pluck('nporder_id');

        $merchantid = Merchant::where('user_id','=',$merchant->user_id)->pluck('id');

        $dostatus = DeliveryOrder::leftjoin('receipt','receipt.id','=','deliveryorder.receipt_id')
                      ->leftjoin('porder','receipt.porder_id','=','porder.id')
                      ->where('porder.id', $id)
                      ->orderby('deliveryorder.created_at','desc')
                      ->first(['deliveryorder.status']);

        return view('seller.gator.salesorderdocument',
            compact('selluser','nid','heading'))->
        with('merchant',$merchant)->
        with('id',$id)->
        with('buyeraddress',$buyeraddress)->
        with('invoice',$invoice)->
        with('status',$status)->
        with('time',$time)->
        with('currency',$currency)->
        with('dostatus',$dostatus)->
        with('nporder_id',$nporder_id);
    }

    public function deletegatorbuyer($id)
    {
        $emerchant = Emerchant::find($id);
        $emerchant->delete();
        return  $this->gatorBuyer();
    }

    public function unlinkgatorbuyer($id,$user_id=null)
    {
         if ($user_id==null) {
            $user_id = Auth::user()->id;
        }
        
        $merchant = Merchant::find($id);
        $merchantid = Merchant::where('user_id','=',$user_id)->pluck('id');
        $autolink = Autolink::where('initiator','=',$merchant->user_id)
        ->where('responder','=',$merchantid)->first();
		if (isset($autolink)) {
           $autolink->status='requested';
           $autolink->save();
		} else {
           $autolink = Autolink::where('initiator','=',$user_id)
           ->where('responder','=',$id)->first();
           $autolink->status='requested';
           $autolink->save();
       }
       return  $this->gatorBuyer();
   }

   public function emerchantdetail($id)
   {
        $emerchant = Emerchant::find($id);
        $emerchantdetails = view('seller.gator.emerchantdetail',
			compact('emerchant'))->render();
        return $emerchantdetails;
   }

   public function tierPrice($id){
		Log::debug("product.parent_id=" . $id);

		$tier_price =  DB::table('wholesale as w')->
			join('product as p','p.id','=','w.product_id')->
			where(['p.segment' => 'b2b','p.parent_id' => $id])->
			select('w.id','w.product_id','w.funit','w.unit','w.price')->
			orderBy('funit')->
			get();

       return response()->json(json_encode($tier_price));
   }
   public function qty_check(Request $request){
       $parent_id = $request['id'];
       $qty = $request['qty'];
       Log::debug("product.parent_id=" . $parent_id);
       Log::debug("Quantity=" . $qty);
    //   dd("Hit");
       $tier_price =  DB::table('wholesale as w')->
       join('product as p','p.id','=','w.product_id')->
       where(['p.segment' => 'b2b','p.parent_id' => $parent_id])->
       select('w.id','w.product_id','w.funit','w.unit','w.price')->
       orderBy('w.price','desc')->get();
       Log::debug("******************************************");
       Log::debug("Price = " .$tier_price[0]->price);
        $price = 0;
        $count = 0;
       /*
        *
        */
       if($qty ==0){
           $price = $tier_price[0]->price;
           return response()->json([ 'price' => $price]);
       }else{
           foreach($tier_price as $t){
               ++$count;
               Log::debug("******************************************");
               Log::debug("Count = " .$count);
               if($count == 1){

                   if(($t->funit <= $qty) || ($qty == 0)){
                       Log::debug("******************************************");
                       Log::debug("Price = " .$t->price);
                       Log::debug("**************Funit****************************");
                       Log::debug("Price = " .$t->funit);
                       Log::debug("**************Unit****************************");
                       Log::debug("Price = " .$t->unit);
                       $price = $t->price;
                       return response()->json([ 'price' => $price]);
                   }else{
                       Log::debug("**************Price and Qty****************************");
                       Log::debug("Input Qty = " .$qty);
                       Log::debug("Qty = " .$t->funit);
                   }
               }else{
                   if(($t->funit <= $qty) && ($t->unit >= $qty )){
                       Log::debug("******************************************");
                       Log::debug("Price = " .$t->price);
                       Log::debug("**************Funit***1*************************");
                       Log::debug("Price = " .$t->funit);
                       Log::debug("**************Unit*****1***********************");
                       Log::debug("Price = " .$t->unit);
                       return response()->json([ 'price' => $price]);

                   }else{
                       Log::debug("**************Price and Qty****************************");
                       Log::debug("Input Qty = " .$qty);
                       Log::debug("Qty = " .$t->funit);
                       Log::debug("Qty 2 = " .$t->unit);
                   }
               }

           }
       }


   }

   public function deleteRecord(Request $request){
       //Get the Porder ID
      $user_id = Auth::user()->id;
      $merchant_id = Merchant::where('user_id',$user_id)->pluck('id');
      $porder_id =  $request['id'];
       Log::debug("product.parent_id=" . $porder_id);
       //Find the related table

      
       $model =POrder::find( $porder_id );
       $status = 'cancelled';
       //if table exists
       if($model){
           $delivered = DB::table('deliveryorder')->select('deliveryorder.status')
               ->join('receipt','deliveryorder.receipt_id','=','receipt.id')
               ->join('porder','receipt.porder_id','=','porder.id')
               ->whereIn('deliveryorder.source',['gator','jaguar','imported'])
               ->where('porder.id',$porder_id)
               ->first();
          // if($model->status == 'completed'){
               if ($delivered->status == 'completed'){
                   return 2;
               }elseif($delivered->status == 'cancelled'){
                   return 3;
         //      }
           }else{
               $model->status = $status;
               $model->save();
               //Check for related Order table

               $orders = DB::table('deliveryorder')->where('merchant_id',$merchant_id)
                   ->select("deliveryorder.status","deliveryorder.updated_at")
                   ->join('receipt','receipt.id','=','deliveryorder.receipt_id')
                   ->join('porder','receipt.porder_id','=','porder.id')
                   ->join('orderproduct','orderproduct.porder_id','=','porder.id')
                   ->where('porder.id', $porder_id)
                   ->whereIn('deliveryorder.source',['gator','jaguar','imported'])
                   ->update(
                       ['deliveryorder.status' => $status,'orderproduct.status' => $status,
                           'deliveryorder.updated_at' => Carbon::now()]
                   );
               if($orders){
                   return 1;
               }
           }
           //Change Status

           // $orders = DB::table('orderproduct')->where('porder_id',$porder_id)->update(['status' => 'cancelled']);



       }else{
           return 0;
       }


   }

  public function SoConvertInvoice(Request $request)
  {

   // so convert in invoice or not condition
      $porder_id =  $request['id'];
      
      $Invoice = DB::table('invoice')
      ->where('invoice.porder_id', $porder_id)->get();

        if(count($Invoice) > 0){
          return 0;
        }

  }

	public function set_status(Request $request){
		Log::debug('****** set_status() *****');
		$p_id = $request['id'];
    $status = $request['status'];

		Log::debug($p_id . " ". $status);

		$user_id = Auth::user()->id;

		$merchant_id = Merchant::where('user_id',$user_id)->pluck('id');


		/* Processing Logistics Discard radiobutton Status */
		switch($status) {
			case 'pickup':
				$do_status  = 'completed';
				$do_discard = 'pickup';
				break;
			case 'cancelled':
				$do_status  = 'cancelled';
        $note = 'Offset due to cancellation';
				$do_discard = 'cancelled';
        
				break;
			case 'error':
				$do_status  = 'cancelled';
        $note = 'Offset due to error adjustment';
				$do_discard = 'error';
        
				break;
			default:
		}

		Log::debug('***** status    ='.$status);
		Log::debug('***** do_status ='.$do_status);
		Log::debug('***** do_discard='.$do_discard);



      if($do_status == 'cancelled'){
        // $updateArray['orderproduct.order_price'] = 0;
        // $updateArray['invoice.status'] = 'full';
        // $updateArray['invoice.payment'] = 'full';
        $invoice = DB::table('invoice')->where('porder_id',$p_id)->first();


        $products_pos = DB::table('orderproduct')->join('product','product.id','=','orderproduct.product_id')->
        select('orderproduct.id as opid','orderproduct.approved_qty','orderproduct.quantity','orderproduct.order_price')
            ->where('porder_id',$p_id)->get();

        $total_owned = 0;

        foreach($products_pos as $products_poses){
            $opqs = DB::table('orderproductqty as opq')->leftjoin('orderproductwarranty as opw','opq.id','=','opw.orderproductqty_id')
                            ->select('opw.serial_used','opw.warranty_used','opw.id as opwid')
                            ->where('opq.orderproduct_id',$products_poses->opid)->get();

            foreach ($opqs as $opq) {
                if($opq->serial_used == 1){
                    DB::table('orderproductwarranty')->where('id',$opq->opwid)->update(['serial_used' => 0]);
                }else if($opq->warranty_used == 1){
                    DB::table('orderproductwarranty')->where('id',$opq->opwid)->update(['warranty_used' => 0]);
                }
            }
            if(is_null($products_poses->approved_qty)){
                $total_owned += ($products_poses->order_price/100)*$products_poses->quantity;
            }else{
                $total_owned += ($products_poses->order_price/100)*$products_poses->approved_qty;
            }

        }
        $totalBalance = $total_owned * 100;
        DB::table('invoicepayment')->insert(['invoice_id'=>$invoice->id,'amount'=>$totalBalance ,
            'date_paid'=>date('Y-m-d H:i:s'),'method'=>'offset','note'=>$note,'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s')]);
         DB::table('invoice')->where('id',$invoice->id)->update(['status'=>'cancelled']);

        $updateArray = [
        'deliveryorder.status'  => $do_status,
        'deliveryorder.discard' => $do_discard,
        'porder.status' => $do_status,
        'orderproduct.status' => $do_status,
        'stockreport.status' => 'deleted',
        'deliveryorder.updated_at' => Carbon::now(),
        'stockreport.updated_at' => Carbon::now()
        ];
      }else{
        $updateArray = [
        'deliveryorder.status'  => $do_status,
        'deliveryorder.discard' => $do_discard,
       // 'porder.status' => $status,
            'porder.status' => 'completed',
        'orderproduct.status' => $status,
        'stockreport.status' => $status,
        'deliveryorder.updated_at' => Carbon::now(),
        'stockreport.updated_at' => Carbon::now()
        ];
      }
		$delivery_orders = DB::table('deliveryorder')->
			where('merchant_id',$merchant_id)->
			select("deliveryorder.status", "stockreport.status",
				"deliveryorder.updated_at", "stockreport.updated_at")->
			join('receipt','receipt.id','=','deliveryorder.receipt_id')->
			join('porder','receipt.porder_id','=','porder.id')->
			join('orderproduct','orderproduct.porder_id','=','porder.id')->
      // leftjoin('invoice','invoice.porder_id','=','porder.id')->
			where('porder.id', $p_id)->
			whereIn('deliveryorder.source',['gator','jaguar','imported'])->
			leftjoin("deliveryorderstockreport",
				"deliveryorderstockreport.deliveryorder_id","=",
				"deliveryorder.id")->
			leftjoin("stockreport","stockreport.id","=",
				"deliveryorderstockreport.stockreport_id")->

//           ->leftjoin('member', function ($join) {
//               $join->on('deliveryorder.member_id','=','member.id')
//                   ->where('member.status','=','active');
//           })->leftjoin('users as dlv', function ($join) {
//               $join->on('dlv.id','=','member.user_id');
//           })->get()

			update($updateArray);
    
    //       ->get()
     
       Log::debug("***** $delivery_orders *****");
       Log::debug($delivery_orders);
   }

   public function displaydeliveryorderdocument($porderId,$nid = null,$heading =null)
    {
        $user_id = Auth::user()->id;

        $merchant_id = Merchant::where('user_id',$user_id)->first();
        // $month=(int)Request::input('month');
        // $emonth=(string)$month+1;
        // $smonth=(string)$month;
        // $year=Request::input('year');
        // $id = Request::input('user_id');
        // $fromDate=$year."-".$smonth.'-01';
        // $toDate=$year."-".$emonth."-01";

      // $doissued = DeliveryOrder::where('deliveryorder.status','confirmed')

      $doissued = DeliveryOrder::leftjoin('ndeliveryorderid','ndeliveryorderid.deliveryorder_id','=','deliveryorder.id')
           ->leftjoin('receipt','receipt.id','=','deliveryorder.receipt_id')
           ->leftjoin('porder','porder.id','=','receipt.porder_id')
           ->leftjoin('invoice','invoice.porder_id','=','porder.id')
           ->leftjoin('orderproduct','porder.id','=','orderproduct.porder_id')
           ->leftjoin('deliveryorderproduct','deliveryorder.id','=','deliveryorderproduct.do_id')
           ->join('product','product.id','=','orderproduct.product_id')
           ->leftjoin('users','porder.user_id','=','users.id')
           ->leftjoin('member','member.id','=','deliveryorder.member_id')
           ->leftjoin('users as duid','member.user_id','=','duid.id')
           ->join('merchantproduct','merchantproduct.product_id','=',
           'product.parent_id')
           ->leftjoin('merchant','merchantproduct.merchant_id','=','merchant.id')
           ->leftjoin('address','merchant.address_id','=','address.id')
           ->leftjoin('nbuyerid','nbuyerid.user_id','=','merchant.user_id')
           ->where('porder.id','=',$porderId)
       ->where('deliveryorder.merchant_id','=',$merchant_id->id)
       // ->whereBetween('deliveryorder.created_at',[$fromDate,$toDate])
       ->select(
         'member.user_id as mid',
         'member.email as memberemail',
           'deliveryorder.status as status',
            'deliveryorder.deliveryorder_no',
           'deliveryorder.discard as discard',
           'invoice.invoice_no as invoice_no',
           'invoice.direct as direct',
           // 'ndeliveryid.ndelivery_id as nid',
           'ndeliveryorderid.ndeliveryorder_id as nid',
           'deliveryorder.source as source',
           'deliveryorder.id as id',
          'deliveryorder.updated_at as comp_time',
           'porder.id as p_id',
           'duid.first_name as memberfirst',
           'duid.last_name as memberlast',
           'duid.id as deliverymanId',
            'duid.username as memberusername',
           'merchant.company_name',
           'merchant.gst',
           'merchant.business_reg_no',
           'address.line1',
           'address.line2',
           'address.line3',
           'address.line4',
           'users.first_name',
           'users.last_name',
           'merchant.user_id as staff_id',
           'nbuyerid.nbuyer_id as user_id',
           'porder.created_at',
           'porder.salesorder_no',
           'porder.user_id'
           )
       ->first();

		$staff = User::find(Auth::user()->id);
		$doissued->staff_id   = sprintf("%010d", $staff->id);
		$doissued->first_name = $staff->first_name;
		$doissued->last_name  = $staff->last_name;
        $direct = $doissued->direct;

        $doid = '';
        $invoiceNo =0;
        $dman_id='';
        $dman_name='';
        $salesorder_no='';
        //if(count($doissued)>0){
            if(!empty($doissued)){
            $doid = sprintf('%010d', $doissued['deliveryorder_no'] );
            $salesorder_no = sprintf('%010d', $doissued['salesorder_no']);

            if($doissued['invoice_no'] != ''){
                $invoiceNo = sprintf('%010d',$doissued['invoice_no'] );
            }
            if($doissued['mid'] != '')
            {
                $dman_id = sprintf('%06d',$doissued['mid']);

                if($doissued['memberfirst'] != '' || $doissued['memberlast'] != ''){
                    $dman_name = $doissued['memberfirst']." ".$doissued['memberlast'];

                }else if($doissued['memberusername'] != ''){
                    $Email = explode('@', $doissued['memberusername']);
                    $dman_name = $Email[0];

                }else{
                    $dmaName = explode('@', $doissued['memberemail']);
                    $dman_name = $dmaName[0];
                }
               
            }
           
        }

        $emerchant = POrder::where('porder.id','=',$porderId)
            ->pluck('is_emerchant');

        if ($emerchant) {
            Log::debug('*** $emerchant=TRUE ***');
            $buyeraddress = POrder::join('emerchant','emerchant.id','=',
                'porder.user_id')->
            where('porder.id','=',$porderId)->
            first([
                'emerchant.company_name',
                'emerchant.business_reg_no',
                'emerchant.address_line1 as line1',
                'emerchant.address_line2 as line2',
                'emerchant.address_line3 as line3',
            ]);

        } else {
            Log::debug('*** $emerchant=FALSE ***');
            Log::debug('$merchant->user_id='.$user_id);

            $buyeraddress = POrder::join('merchant','merchant.user_id','=',
                'porder.user_id')->
            join('address','merchant.address_id','=','address.id')->
            where('porder.id','=',$porderId)->
            where('merchant.user_id','=',$doissued->user_id)->
            first([
                'merchant.company_name',
                'merchant.business_reg_no',
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
            ]);
        }

        // return $buyeraddress;
        $invoice    =   POrder::join('orderproduct','orderproduct.porder_id','=','porder.id')
            ->join('nproductid','nproductid.product_id','=','orderproduct.product_id')
            ->join('product','orderproduct.product_id','=','product.id')
            ->where('porder.id','=',$porderId)
            ->get([
                'nproductid.nproduct_id',
                'product.name',
                'product.parent_id',
                'product.id as prid',
                'product.thumb_photo',
                'orderproduct.quantity',
                'orderproduct.approved_qty',
                'orderproduct.order_price',

            ]);
        $p_order = POrder::find($porderId);
        $status = $p_order->status;
        $time = $p_order->updated_at;
        $stat = '';
        if($doissued->status == 'completed'){
            $stat = 1;
        }
       // dd($doissued);
        $currency = Currency::where('active','=',1)->pluck('code');
        $selluser = User::find(Auth::user()->id);
        $nporder_id = NPorderid::where('porder_id','=',$porderId)->
        pluck('nporder_id');
        $merchant = Merchant::where('user_id','=',$user_id)->first();


        $wholesaleprices = Product::join('wholesale','wholesale.product_id','=','product.id')
            ->join('merchantproduct','product.parent_id','=','merchantproduct.product_id')
            ->where('merchantproduct.merchant_id','=',$merchant->id)
            ->orderBy('wholesale.price','desc')
            ->get([
                'wholesale.funit',
                'wholesale.unit',
                'wholesale.price',
                'wholesale.product_id as id',
            ]);


        return view('seller.gator.deliveryorderdocument',
            compact('selluser','nid','heading'))->
        with('merchant',$doissued)->
        with('id',$user_id)->
    //    with('porder_data', $porder_data)->
        with('wholesaleprices',$wholesaleprices)->
        with('user_id', $user_id)->
        with('buyeraddress',$buyeraddress)->
        with('invoice',$invoice)->
        with('stat',$stat)->
        with('direct',$direct)->
        with('time',$time)->
        with('status',$status)->
        with('currency',$currency)->
        with('doid',$doid)->
        with('invoiceNo',$invoiceNo)->
        with('dman_id',$dman_id)->
        with('dman_name',$dman_name)->
        with('salesorder_no',$salesorder_no)->
        with('nporder_id',$nporder_id);
    }
    public function displaydeliveryorderpopup($porderId,$nid = null,$heading =null)
    {
        $user_id = Auth::user()->id;
        $merchant_id = Merchant::where('user_id',$user_id)->first();

      // $doissued = DeliveryOrder::where('deliveryorder.status','confirmed')

      $doissued = DeliveryOrder::leftjoin('ndeliveryorderid','ndeliveryorderid.deliveryorder_id','=','deliveryorder.id')
           ->leftjoin('receipt','receipt.id','=','deliveryorder.receipt_id')
           ->leftjoin('porder','porder.id','=','receipt.porder_id')
           ->leftjoin('invoice','invoice.porder_id','=','porder.id')
           ->leftjoin('orderproduct','porder.id','=','orderproduct.porder_id')
           ->leftjoin('deliveryorderproduct','deliveryorder.id','=','deliveryorderproduct.do_id')
           ->join('product','product.id','=','orderproduct.product_id')
           ->leftjoin('users','porder.user_id','=','users.id')
           ->leftjoin('member','member.id','=','deliveryorder.member_id')
           ->leftjoin('users as duid','member.user_id','=','duid.id')
           ->join('merchantproduct','merchantproduct.product_id','=',
           'product.parent_id')
           ->leftjoin('merchant','merchantproduct.merchant_id','=','merchant.id')
           ->leftjoin('address','merchant.address_id','=','address.id')
           ->leftjoin('nbuyerid','nbuyerid.user_id','=','merchant.user_id')
           ->where('porder.id','=',$porderId)
       ->where('deliveryorder.merchant_id','=',$merchant_id->id)
       ->select(
         'member.user_id as mid',
           'deliveryorder.status as status',
           'invoice.invoice_no as invoice_no',
           'ndeliveryorderid.ndeliveryorder_id as nid',
           'deliveryorder.source as source',
           'deliveryorder.id as id',
           'porder.id as p_id',
           'duid.first_name as memberfirst',
           'duid.last_name as memberlast',
           'duid.id as deliverymanId',
           'merchant.company_name',
           'merchant.gst',
           'merchant.business_reg_no',
           'address.line1',
           'address.line2',
           'address.line3',
           'address.line4',
           'users.first_name',
           'users.last_name',
           'merchant.user_id as staff_id',
           'nbuyerid.nbuyer_id as user_id',
           'porder.created_at',
           'porder.salesorder_no',
           'porder.user_id'
           )
       ->first();

		$staff = User::find(Auth::user()->id);
		$doissued->staff_id   = sprintf("%010d", $staff->id);
		$doissued->first_name = $staff->first_name;
		$doissued->last_name  = $staff->last_name;

        $emerchant = POrder::where('porder.id','=',$porderId)
            ->pluck('is_emerchant');

        if ($emerchant) {
            Log::debug('*** $emerchant=TRUE ***');
            $buyeraddress = POrder::join('emerchant','emerchant.id','=',
                'porder.user_id')->
            where('porder.id','=',$porderId)->
            first([
                'emerchant.company_name',
                'emerchant.business_reg_no',
                'emerchant.address_line1 as line1',
                'emerchant.address_line2 as line2',
                'emerchant.address_line3 as line3',
            ]);

        } else {
            Log::debug('*** $emerchant=FALSE ***');
            Log::debug('$merchant->user_id='.$user_id);

            $buyeraddress = POrder::join('merchant','merchant.user_id','=',
                'porder.user_id')->
            join('address','merchant.address_id','=','address.id')->
            where('porder.id','=',$porderId)->
            where('merchant.user_id','=',$doissued->user_id)->
            first([
                'merchant.company_name',
                'merchant.business_reg_no',
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
            ]);
        }
        // return $buyeraddress;
        $invoice = POrder::join('orderproduct','orderproduct.porder_id','=','porder.id')
            ->join('nproductid','nproductid.product_id','=','orderproduct.product_id')
            ->join('product','orderproduct.product_id','=','product.id')
            ->where('porder.id','=',$porderId)
            ->get([
                'nproductid.nproduct_id',
                'product.name',
                'product.parent_id',
                'product.id as prid',
                'product.thumb_photo',
                'orderproduct.quantity',
                'orderproduct.approved_qty',
                'orderproduct.order_price',

            ]);
        $p_order = POrder::find($porderId);
        $status = $p_order->status;
        $time = $p_order->updated_at;

        $currency = Currency::where('active','=',1)->pluck('code');
        $selluser = User::find(Auth::user()->id);
        $nporder_id = NPorderid::where('porder_id','=',$porderId)->
        pluck('nporder_id');

        return view('seller.gator.deliveryorderpopup',
                compact('selluser','nid','heading'))->
                with('merchant',$doissued)->
                with('id',$user_id)->
                with('buyeraddress',$buyeraddress)->
                with('invoice',$invoice)->
                with('status',$status)->
                with('time',$time)->
                with('currency',$currency)->
                with('nporder_id',$nporder_id);
    }
}
