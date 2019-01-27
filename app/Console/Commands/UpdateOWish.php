<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OpenWish;
use App\Models\OpenWishPledge;
use App\Models\Product;
use App\Models\Ocredit;
// use App\Models\OAcc;
use App\Models\MerchantProduct;
use App\Models\POrder;
use App\Models\OrderProduct;
use App\Models\User;
use App\Models\DeliveryOrder;
use App\Models\Receipt;
use App\Models\Globals;
use Carbon;
class UpdateOWish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'owish:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates OpenWish expiry status+ Ocredit';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $all= OpenWish::where('status','active')->get();
        foreach ($all as $a) {
            try{

            # code...

            $created = new Carbon($a->created_at);
            $now = Carbon::now();
            $diff= $created->diff($now)->days;
            // echo $diff;
            $owish_durationInDays=Globals::first()->openwish_duration;
            if ($diff>$owish_durationInDays and $a->status=="active") {
            // if ($a->status=="active") {
                
            
            // if ($test==True) {
                # code...
            
                # code...
                $o=OpenWish::find($a->id);
                $o->status="expired";
                $o->save();
                // echo "OpenWish ID ".$a->id." updated";
                // Check for pledge amount
                $pledges=OpenWishPledge::where('openwish_id',$a->id)->get();
                $pledged_amt=0;
                foreach($pledges as $p){
                    $pledged_amt+=$p->pledged_amt;
                }

                echo "PLEDGED AMOUNT ".$pledged_amt;
                echo "\n";
                // Get Product price

                $price= Product::find($a->product_id)->retail_price;

                // Get Delivery Price 

                // ???
                $product_merchant=MerchantProduct::where('product_id',$a->product_id)->first()->merchant_id;
                if ($pledged_amt>$price) {
                    # code...
                    // Do an order
                
                    $user= User::find($a->user_id);
                    // Only ORDER Here
                    $p= new POrder;
                    $p->user_id=$user->id;
                    $p->courier_id=0; //should be something else
                    $p->address_id=$user->default_address_id; //should be something else
                    $p->payment_id=$py->id; //0 for odebit| No More
                    $p->status="pending";
                    $p->save();
                    // Send Mail for Pledge
                    // 
                    $rc= new Receipt;
                    $rc->porder_id=$p->id;
                    $rc->do_password=str_random(7);
                    $rc->save();
                    $o= new OrderProduct;
                    $o->porder_id=$p->id;
                    $o->product_id=$cartItem->id;
                    $o->quantity=$cartItem->quantity;
                    $o->order_price=$cartItem->price;
                    $o->shipping_cost=$cartItem->delivery_price;
                    $o->save();
                    $pr=Product::find($a->product_id);
                    $pr->available=$pr->available-1;
                    $pr->save();
                    $do= new DeliveryOrder;
                    $do->receipt_id=$rc->id;
                    $do->status="pending";
                    $do->save();
                    DB::table('deliveryordersproduct')->insert([
                    'do_id'=>$do->id,
                    'product_id'=>$a->id,
                    'status'=>'pending',
                    'quantity'=>$cartItem->quantity,

                    ]); 
                    // Add log in Odebit
                    $odebit= $pledged_amt-$price;
               
                    $o= new Ocredit;
                    $o->product_id=$a->product_id;
                    $o->merchant_id=$product_merchant;
                    $o->porder_id=0;
                    $o->value=$odebit;
                    $o->openwish_id= $a->id;
                    $o->mode="credit";
                    $o->source="openwish";
                    $o->save();
                    // Add/Create Odebit for the user
                    // $oa=OAcc::where('user_id',$a->user_id)->first();
                    // if (is_null($oa)) {
                    //     $noa=new OAcc;
                    //     $noa->user_id= $a->user_id;
                    //     $noa->balance= $odebit;
                    //     $noa->save();
                    // }else{
                    //     $noa= OAcc::find($oa->id);
                    //     $noa->balance= $noa->balance+$odebit;
                    //     $noa->save();
                    // }

                }
                if ($pledged_amt<$price) {
                    # code...
                    // NO ORDER HERE
                    $odebit= $pledged_amt;
                    echo "Ocredit ADDED: ".$odebit;
                    $o= new Ocredit;
                    $o->product_id=$a->product_id;
                    $o->merchant_id=$product_merchant;
                    $o->porder_id=0;
                    $o->value=$odebit;
                    $o->openwish_id= $a->id;
                    $o->mode="credit";
                    $o->source="openwish";
                    $o->save();
                    
                   
                }
                if ($pledged_amt==$price) {
                    $user= User::find($a->user_id);
                    // Only ORDER Here
                    $p= new POrder;
                    $p->user_id=$user->id;
                    $p->courier_id=0; //should be something else
                    $p->address_id=$user->default_address_id; //should be something else
                    $p->payment_id=$py->id; //0 for odebit| No More
                    $p->status="pending";
                    $p->save();
                    // Send Mail for Pledge
                    // 
                    $rc= new Receipt;
                    $rc->porder_id=$p->id;
                    $rc->save();
                    $o= new OrderProduct;
                    $o->porder_id=$p->id;
                    $o->product_id=$cartItem->id;
                    $o->quantity=$cartItem->quantity;
                    $o->order_price=$cartItem->price;
                    $o->shipping_cost=$cartItem->delivery_price;
                    $o->save();
                    $pr=Product::find($a->product_id);
                    $pr->available=$pr->available-1;
                    $pr->save();
                    $do= new DeliveryOrder;
                    $do->receipt_id=$rc->id;
                    $do->status="pending";
                    $do->save();
                    DB::table('deliveryordersproduct')->insert([
                    'do_id'=>$do->id,
                    'product_id'=>$a->id,
                    'status'=>'pending',
                    'quantity'=>$cartItem->quantity,

                    ]); 
                }

            }
        }catch(\Exception $e){
        echo "Error for OpenWish ID: ".$a->id;
        }
        }
    }
}
