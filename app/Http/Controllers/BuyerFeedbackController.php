<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\POrder;
use DB;
use Auth;
class BuyerFeedbackController extends Controller
{
   public function loadFeedbackModal($order_id)
   {
        try{
            $products=Product::join('orderproduct as op','op.product_id','=','product.parent_id')
                    ->where('op.porder_id',$order_id)
                    ->select(DB::raw("
                        product.parent_id as id,
                        product.name,
                        product.photo_1 as image

                        "))
                    ->groupBy('op.id')
                    ->get();
        }catch(\Exception $e){
          dump($e);
            $products=array();
        }
        // return $products;
       return view("buyer.modal.feedback")
       ->with('products',$products)
       ->with('oid',$order_id)
       ;
   }

   public function registerFeedback(Request $r)
   {

       try {
        $status="commented";
            $user_id=Auth::user()->id;
            $oid= $r->oid;
            $kv= $r->kv;
            
            // return $kv;
            foreach ($kv as $pid => $review) {
                // json_decode($review);
                foreach ($review as $pid => $comment) {
                  # code...
                  // return $comment;
                
                // $comment = $review;
                // $product_id = $request->get('product_id');
                $orderproduct_id=DB::table('orderproduct')->where('product_id',$pid)->where('porder_id',$oid)->pluck('id');
                
                $result = DB::table('ocomment')->insertGetId(['product_id' => $pid, 'comment' => $comment,'orderproduct_id'=>$orderproduct_id,'user_id' => $user_id,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                // Update Porder
                $po=POrder::find($oid);
                $po->status=$status;
                $po->save();
              }
            }


       } catch (\Exception $e) {
           dump($e);
       }
       return response()->json(['status'=>'success','long_message
        '=>'Your reviews were saved']);
   }
}
