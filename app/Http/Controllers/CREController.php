<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OpenCreditController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\CityLinkController as CL;
use App\Classes\CityLinkConnection ;
use App\Classes\SecurityIDGenerator;
use DB;
use Auth;
use Carbon;

// Models Alphabetical-asc preferred
use App\Models\CtlShip;
use App\Models\Logistics;
use App\Models\Cre;
use App\Models\OrderProduct;
use App\Models\POrder;
use App\Models\Ocredit;
use App\Models\Payment;
use App\Models\Document;
use App\Models\CreDocument;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\User;
use App\Models\OrderReturn;
use App\Models\Address;
use App\Models\Delivery;
use Cart;
class CREController extends Controller
{
   /*Merchant*/
 public function __construct()
 {
     # code...
    if (!Auth::check()) {
            # code...
            return response()->json(['status' => 'failure','short_message'=>'Unauthorized Access','long_message'=>'You are not authorized to perform this action']);
        }
    


 }


    public function cre(Request $r)
    {
        $ret=array();
    
        /*Validation Block*/ 
        
        /*Process Block*/ 
        try {
            $data=$r->data;
            
            $delivery_cost=0; //Buyer always pay
            $porder_id=0;
            $accepted=0;
            $rejected=0;
            $requested_goods=0;
            foreach ($data as $d) {
                $d=json_decode($d); //quick fix

                $op=Orderproduct::find($d->opid);
                if (!is_null($op)) {
                    $porder_id=$op->porder_id;
                    switch ($d->result) {
                        case 'accepted':
                            $accepted+=1;
                            $op->status="m-approved1";
                          
                                /* Merchant do not want the good.
								 * Immediate refund the opencredit */ 
                                $this->op_oc($op->id);
                                $op->status=="m-approved2";
							break;
                        case 'requested_goods':
                            /* Merchant wants the goods back and the buyer
							 * has to pay. We will cut the money from the
							 * refund
							 * Logic:
                                >Update Porder status to request-goods
                                >Update orderproduct to b-paid1 */ 
                            $requested_goods+=1;
                            $op->status="b-paid1";

                            $orn=new OrderReturn;
                            $orn->porder_id=$op->id;
                            $orn->user_id=Auth::user()->id;
                            $orn->return_price=0;
                            $orn->status="success";
                            $orn->save();
							break;
						case 'rejected':
							$rejected+=1;
							$op->status="rejected";
							break;
						default:
							# code...
							break;
                    }
                $op->save();
                }        
            }   

			if ($requested_goods > 0) {
				POrder::find($op->porder_id)->
				update(['status'=>'request-goods']);

			} elseif ($requested_goods==0 and $accepted>0) {
				POrder::find($op->porder_id)->
					update([
						'prev_m_approved '=>'b-returning',
						'status'=>'m-approved'
					]);
			} else {
				// Squidster: Bypass rejected1 -> reviewed1
				POrder::find($op->porder_id)->
					//update(['status'=>'reviewed1']);
					update(['status'=>'rejected1']);
			}

        } catch (\Exception $e) {
            // dump($e);
            // $ret['short_message']="CRE#001| ".$e->getMessage();
            $ret=$e->getMessage();
            
        }
        $ret=1;
        return $ret;
    }
    public function op_oc($orderproduct_id)
    {
        $op=Orderproduct::find($orderproduct_id);
        $value=$op->order_price*$op->quantity;
        $oc= new Ocredit;
        $oc->porder_id=$op->porder_id;
        $oc->mode="credit";
        $oc->status="success";
        $sidg= new SecurityIDGenerator;
        $oc->security_id=$sidg->generate(Carbon::now()->toDateString());
        $oc->value=$value;
        $oc->save();
    }
    public function helperOcredit($oid)
    {
        $value=0;
        $ops=OrderProduct::where('status','m-approved2')
        ->where('porder_id',$oid)
        ->get();
        foreach ($ops as $op) {
            $value+=$op->order_price*$op->quantity;
        }
        $oc= new Ocredit;
        $oc->porder_id=$oid;
        $oc->mode="credit";
        $oc->status="success";
        $sidg= new SecurityIDGenerator;
        $oc->security_id=$sidg->generate(Carbon::now()->toDateString());
        $oc->value=$value;
        $oc->save();
    }
     public function merchant_confirms_cre(Request $r)
    {
        try {
             $result= $this->cre($r);
             if ($result ==1) {
				$m=[
				 	"status"=>"success",
					"long_message" =>"The order has been updated.",
					"short_message" =>$result];
             } else {
                $m=[
					"status"=>"failure",
					"long_message" =>"Some error happened. Contact OpenSupport",
					"short_message" =>$result];
             }

        } catch (\Exception $e) {
			$m=["status"=>"failure",
				"long_message" =>"Some error happened. Contact OpenSupport",
				"short_message" =>99];
        }
        return response()->json($m);
    }

    public function merchant_rejects_cre(Request $r)
    {
        $mode= $r->type;
        $cre_id= $r->cre_id;
        $order_id= $r->order_id;
        switch ($mode) {
            case 'cancel':
                try {
                    $c=Cre::find($cre_id);
                    $c_copy=$c; //Just in case if something happens
                    $c->status='fail';
                    $c->save();
                    $op_copy=OrderProduct::where('id',$order_id)->first();
                    OrderProduct::where('id',$order_id)->
					update(['status'=>'pending']);
                   
                    //  Paul on 25 April 2017
					/*
                    POrder::where('id',$op_copy->porder_id)->
						update(['status'=>'pending']);
					*/
                    POrder::find($op_copy->porder_id)->update(['status'=>'pending']);
                   
                
                return response()->json([
                    'status' => 'success',
                    'short_message'=>'Request Success',
                    'long_message'=>'The order has been rejected for cancellation'
                    ]);
        } catch (\Exception $e) {
            return $e;
            // Rollbacks
            // DB::table('cre')->where('porder_id',$order_id)->update(['status'=>$cre_copy->status]);
            $c=Cre::find($c->id);
            $c->status=$c_copy->status;
            $c->save();

            foreach ($op_copy as $o) {
                OrderProduct::where('porder_id',$order_id)
                ->where('product_id',$o->product_id)
                ->update(['status'=>$o->status,'crereason_id'=>$o->crereason_id]);

            }
            
        }
                break;
            case 'return':
                try {
                    $c=Cre::find($cre_id);
                    $c_copy=$c; //Just in case if something happens
                    $c->status='fail';
                    $c->save();
                    $op_copy=OrderProduct::where('id',$order_id)->first();
                    $total_op=OrderProduct::where('porder_id',$op_copy->porder_id)
                            ->where('status','b-returning1')->get();

                    OrderProduct::where('id',$order_id)
                    ->update(['status'=>'returnrjctd']);
                   
                        # code
                    if (count($total_op)==1) {
                        # code...
                        //  Paul on 25 April 2017
                        //POrder::where('id',$op_copy->porder_id)->update(['status'=>'returnrjctd']);
                        POrder::find($op_copy->porder_id)->update(['status'=>'returnrjctd']);
                    }
                    
                } catch (\Exception $e) {
                    return $e;
                }
                return response()->json([
                    'status' => 'success',
                    'short_message'=>'Request Success',
                    'long_message'=>'The order has been rejected for return'
                    ]);
                break;
    }
   }
    public function show_cre_images($cre_id)
    {
       $images= Document::leftJoin('credocument as cd','cd.document_id','=','document.id')
        ->where('cd.cre_id','=',$cre_id)
        ->lists('document.path');
        // return $images;
        return view('cre.image')
            ->with('cre_id',$cre_id)
            ->with('cre_images',$images)
        ;
    }

    public function initRForm($oid)
    {
        $allow_approval=False;

        try {
            $porder=POrder::find($oid);
            $allow_approval=UtilityController::can_approve_return($porder->updated_at);
			$cre=OrderProduct::leftJoin('crereasons','crereasons.id','=','orderproduct.crereason_id')->
				join('product','orderproduct.product_id','=','product.id')->
				where('orderproduct.porder_id',$oid)->
				where('orderproduct.status','b-returning1')->
				select(DB::raw(
					"   product.id as pid,
						product.name as product_name,
						orderproduct.id as opid,
						crereasons.reason_text as reason
					"
				))->get();

			$creid=DB::table('cre')->
				where('porder_id',$oid)->
				pluck('id');

			$crenote=DB::table('crecomment')->
				where('cre_id',$creid)->
				orderBy('created_at','DESC')->
				pluck('comment');


        } catch (\Exception $e) {
            $cre=array();
			$crenote=null;
			$creid=null;
        }

        // $cre=array();
        
        return view('merchant.modal.cre')
        ->with('cre',$cre)
        ->with('crenote',$crenote)
        ->with('creid',$creid)
        ->with('oid',$oid)
        ->with('allow_approval',$allow_approval)
        ;
    }

   public static function processCREOrder($oid)
   {
       try {
            
            // Get Buyer Info
            $p= POrder::find($oid);
            $buyer_user_id=$p->user_id;
            $buyer=User::find($buyer_user_id);
            $shipping_address_id=$buyer->default_address_id;
            $address= Address::find($shipping_address_id);
            $rcity=DB::table('city')
            ->where('id',$address->city_id)
            ->pluck('name');
            $pid= OrderProduct::where('porder_id',$oid)->pluck('product_id');
            $merchant_id=UtilityController::productMerchantId($pid);
            $merchant_add_id= DB::table('merchant')->
            where('id',$merchant_id)->pluck('address_id'); 
            $mAddress=Address::find($merchant_add_id);
            $mcity=DB::table('city')
            ->where('id',$mAddress->city_id)
            ->pluck('name');
            if (is_null($address)) {
                return response()->json([
                    'status'=>'failure',
                    'short_message'=>'DB Error',
                    'long_message'=>'Shipping Address Missing']);
            }

            // $logc=new LogisticsController;
            // $logistic_partner=$logc->select_logistic();
            // $r=new Request;
            // $r->oid=$p->id;
            // $r->type="b2m";
            // $r->count=1;
            // $r->ts="2013-01-01";
            // $r->pd=1;
            // switch ($logistic_partner) {
            //     case 'nv':
            //         $nvc=new NinjaVanController;
            //         $nvc->callLogistic($r);
            //         break;
            
            //     default:
            //         # code...
            //         break;
            // }
           
            // $cityLink= new CL;
            // $resp=$cityLink->informLogistics($oid);
        
            // if(isset($resp->Error)){
            //     return json_encode('NotOK');
            // }
            // $c=$resp->Consignment;

            // $consignmentNumber=$c->ConsignmentNumber;
            // $packageType=$c->PackageType;
            // $serviceType=$c->ServiceType;
            // $dStation=$c->DestinationStation;
            // // Add validations
            // $l= new CtlShip;
            // $l->porder_id=$oid;
            // $l->ctl_consignment_number=$consignmentNumber;
            // $l->ctl_service_type=$serviceType;
            // $l->ctl_package_type=$packageType;
            // $l->ctl_dstation=$dStation;
            // $l->save();
            $sidg= new SecurityIDGenerator;
            $security_id= $sidg->generate(Carbon::now()->toDateString());
            // $dl= new Delivery;
            // $dl->porder_id=$oid;
            // $dl->logistic_id=$logistic_id; //1 for cityLink
            // $dl->status="active";
            // $dl->consignment_number=$consignmentNumber;
            // $dl->type="b2m";
            // $dl->receipient_city=$mcity;
            // $dl->sender_city=$rcity;
            // $dl->pickup_password=$security_id;
            // $dl->save();
            // Change Status
            // 1/0;
            $p->status="request-goods";
            $p->save();
            $or= new OrderReturn;
            $or->porder_id=$p->id;
            $or->user_id=Auth::user()->id;
            $or->status='success';
            $or->save();
            /*** Update OP***/
            
            $op = DB::table('orderproduct')->where('porder_id',$p->id)
            ->where('status','m-approved1')
            ->orWhere('status','returnpartiallyaccepted')
            ->get();

            foreach($op as $o_p){
              
                DB::table('orderproduct')->where('id',$o_p->id)
                ->where('status','m-approved1')
                ->update(['status'=>'b-paid1']);
               
            }
            $m=[
                    'status'=>'success',
                    'short_message'=>0,
                    'long_message'=>''];
            
        } catch (\Exception $e) {
            dump($e);
            try {
                // dump($e);
                
                Logistics::destroy($l->id);
                $m=[
                    'status'=>'failure',
                    'short_message'=>'DB Error',
                    'long_message'=>'Some error happened.Contact OpenSupport',
                    'code'=>'f1'];

            } catch (\Exception $e) {
                $m=[
                    'status'=>'failure',
                    'short_message'=>'DB Error',
                    'long_message'=>'Some error happened.Contact OpenSupport',
                    'code'=>'f2'];
            }
        }
        return response()->json($m);
        
   }
   /* OBSOLETE : Removed by Zurez
    public function payrfee(Request $r)
    {
        $cartTotal=Cart::totalItems();

        try {
            $porder_id=$r->oid;
    
        $ops=OrderProduct::where('porder_id',$porder_id)
        ->where('status','m-approved1')
        ->get();
        if (count($ops)<1) {
            return ;
        }
        $merchant_id=UtilityController::productMerchantId($ops[0]->product_id);
        // DB::table('merchantproduct')->where

        $delivery_fee=$this->getRFee($ops);

        $logistic_id=1;
        //Add shared product to the cart
        $cartItems=Cart::contents();
        $unique=0;
        foreach ($cartItems as $item) {
            if ($item->mode == "rfee" and $item->porder_id == $porder_id) {
                $unique=1;
            }
        }

        if ($unique == 0) {
            # code...
            Cart::insert(array(
            'id'  =>$porder_id,
            'name'        => 'Return Delivery Fee',
            'price'       => $delivery_fee,
            'quantity'    => 1,
            'merchant_id' =>$merchant_id,
            'porder_id'      => $porder_id,
            'logistic_id' =>$logistic_id,
            'mode'        =>'rfee',
            'oshop_name'  => "Return Delivery Fee",
            'delivery_price' =>0.0
            ));
            $message=[
            'status'=>'success',
            'long_message'=>'The return fee has been added to cart',
            'cartTotalItems'=>$cartTotal
            ];
        }else{
            $message=[
            'status'=>'failure',
            'long_message'=>'Return Fee already added to Cart',
            'cartTotalItems'=>$cartTotal
            ];
        }
        
        $cartTotal=Cart::totalItems();

        
        } catch (\Exception $e) {
            dump($e);
            $message=[
            'status'=>'failure',
            'long_message'=>'Failed to add return fee to cart.',
            'cartTotalItems'=>$cartTotal
        ];
        }

        return response()->json($message);
    }
    */

    public function showApproveModal($oid)
    {
       $ops= OrderProduct::join('product','orderproduct.product_id','=',
            'product.id')
        ->where('orderproduct.porder_id',$oid)
        ->where('orderproduct.status','b-paid1')
        ->select(DB::raw("
            product.name as pname,
            product.photo_1 as image,
            orderproduct.*
            "))
        ->get();
        // return $ops;
        return view('merchant.modal.mapprove2')
        ->with('oid',$oid)
        ->with('ops',$ops);
    }
    public function doApproval(Request $r)
    {
        try {
            $oids=$r->oids; //All orderproduct ids which have been approved
           
            // return $oids;
            $porder_id=$r->oid;
            $user_id=Auth::user()->id;

            $status="m-approved";
            
            $merchant_id=Merchant::where('user_id',$user_id)->pluck('id');
            $ocredit=0;
            
            for ($i=0; $i <sizeof($oids); $i++) { 
                $o=OrderProduct::find($oids[$i]);

                $mp=UtilityController::productMerchantId($o->product_id);
                if ($o->status == "b-returning2" and
					$mp == $merchant_id) {
                    $ocredit+=$o->order_price*$o->quantity;
                    $o->status=$status;
                    $o->save();
                }
            }

			// Squidster: Bypass "rejected2" -> "reviewed2"
            if (sizeof($oids) == 0 or !$r->has('oids')) {
                //$status="reviewed2";
                $status="rejected2";

                Orderproduct::where('status','b-returning2')->
					where('porder_id',$porder_id)->
					update(["status"=>"rejected"]);
            } else {
                Orderproduct::whereNotIn("id",$oids)->
					where('status','b-returning2')->
					where('porder_id',$porder_id)->
					update(["status"=>"rejected"]);
            }
            
			$po=POrder::find($porder_id);
			$po->status=$status;
			$po->save();

            if ($ocredit > 0) {
                $oc = new Ocredit;
                $oc->porder_id=$porder_id;
                $oc->value=$ocredit;
                $oc->mode="credit";
                $oc->save();
            }
            $m=['status'=>'success','long_message'=>'The order status has been updated.'];
        } catch (\Exception $e) {
            dump($e);
            $m=['status'=>'failure','long_message'=>'Some error happened. Please try again later','short_message'=>$e->getMessage()];
        }
        return response()->json($m);
    }

    public function getRFee($ops)
    {
        # $ops is object of all orderproducts
        $logistic_id=1;
        switch ($logistic_id) {
            case 1:
                // CityLinkController::dC($porder_id);
				$totalWeight=0;
				foreach ($ops as $op) {
				$pr=Product::find($op->product_id);
					$totalWeight+=$pr->weight;
				}
				// $delivery_fee=CityLinkController::dC($totalWeight);
        
                $delivery_fee=99;
                break;
            
            default:
                $delivery_fee=999999999999;
                break;
        }
        return $delivery_fee;
    }

    public function getStatus($oid)
    {
         try {
            $cre=OrderProduct::join('crereasons','crereasons.id','=','orderproduct.crereason_id')
            ->join('product','orderproduct.product_id','=','product.id')
           ->where('orderproduct.porder_id',$oid)
           ->whereIn('orderproduct.status',['m-approved1','rejected'])
           ->select(DB::raw(
            "   product.id as pid,
                product.name as product_name,
                orderproduct.id as opid,
                orderproduct.status as status,
                crereasons.reason_text as reason
            "
            ))
           ->get();
           $creid=DB::table('cre')->where('porder_id',$oid)->pluck('id');
        } catch (\Exception $e) {
            return $e;
            $cre=array();
            $creid=0;
        }
    
        $status=1;
        return view('buyer.modal.creStatus')
        ->with('cre',$cre)
        ->with('status',$status)
        ->with('oid',$oid)
        ->with('creid',$creid);
    }

    public function merchant_cancel_order($order_id)
    {
        try {

            $porder=POrder::find($order_id);
            if (!Auth::check() or is_null($porder)) {
                return response()->json(['status' => 'failure','short_message'=>'Request Failed','long_message'=>'A request for order cancellation cannot be placed #001']);
            }
            $user_id=Auth::user()->id;
            $merchant_id_order=UtilityController::porderMerchantId($order_id);
            $merchant_id_loggedin=Merchant::where('user_id',$user_id)->pluck('id');
            $timestamp=$porder->created_at;
            if ($merchant_id_loggedin!=$merchant_id_order and !Auth::user()->hasRole('adm')) {
                return response()->json(['status' => 'failure','short_message'=>'Authentication Error','long_message'=>'A request for order cancellation cannot be placed #002']);

            }
            OrderProduct::where('porder_id',$order_id)->update(['status'=>'b-cancelled']);
            $c= New Cre;
            $c->user_id=$user_id;
            $c->type='cancel';
            $c->porder_id=$order_id;
            $c->status='success';
            $c->save();

            $newid = UtilityController::generaluniqueid($c->id, '9','1', $c->created_at, 'ncreid', 'ncre_id');
            DB::table('ncreid')->insert(['ncre_id'=>$newid, 'cre_id'=>$c->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

            $oc_amount = 0;
            $orderproducts = DB::table('orderproduct')->where('porder_id',$order_id)->get();
            foreach($orderproducts as $orderproduct){
                $total = ($orderproduct->order_price * $orderproduct->quantity) + $orderproduct->order_delivery_price;
                $oc_amount += $total;
            }
            $oc= new Ocredit;
            $sidg= new SecurityIDGenerator;
            $security_id= $sidg->generate(Carbon::now()->toDateString());
            $oc->security_id=$security_id;
            $oc->value=$oc_amount;
            $oc->porder_id=$order_id;
            $oc->cre_id=$c->id;
            $oc->source="cre";
            $oc->mode="credit";
            $oc->status="success";
            $oc->save();
            OpenCreditController::save_nocredit_id($oc);
            $porder->status="m-cancelled";
            $porder->save();
            EmailController::sendOrderCancelMail($order_id);
            EmailController::sendOrderCancelMailBuyer($order_id);
            return response()->json(['status' => 'success','short_message'=>1,'long_message'=>'Cancelled Order: '.IdController::nO($order_id)]);


        } catch (\Exception $e) {
            dump($e);
        }
    }
}
