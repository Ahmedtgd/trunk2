<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OpenWish;
use App\Models\OpenWishPledge;
use App\Models\Product;
use App\Models\Ocredit;
use App\SProduct;
use App\Models\StationProduct;
use App\Models\MerchantProduct;
use App\Models\POrder;
use App\Models\Station;
use App\Models\OrderProduct;
use App\Models\User;
use App\Models\DeliveryOrder;
use App\Models\Receipt;
use App\Models\Globals;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\OpenCreditController;
use App\Http\Controllers\EmailController;
use Carbon;
use DateTime;
use DB;
use App\Models\Cre;
use App\Classes\SecurityIDGenerator;

class UpdateOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Order status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /*
    Updates stock & available in sproduct table.
	To be used in station inventory handler. Logic.
    See if user id has role station.
    */ 
    public function sproductUpdater($porder)
    {
         $userIdWhoBought=$porder->user_id;
         $hasRole=UtilityController::hasRole($userIdWhoBought,'sto');
         // 1 equivalent of True, 0 for false.
         if ($hasRole ==1) {
             # The order belongs to a station.Now get station id
            $stId=UtilityController::getStationId($userIdWhoBought);
            $ops=OrderProduct::where('porder_id',$porder->id)->get();
            foreach ($ops as $op) {
                // Find if a sproduct record exists.
                $sp=SProduct::join('stationsproduct as sp','sp.sproduct_id','=','sproduct.id')
                ->where('sproduct.product_id',$op->product_id)
                ->where('sp.station_id',$stId)
                ->select(DB::raw("sproduct.id as id "))->first();

				/*
                echo "product_id ".$op->product_id."\n";
                $product_id=Product::where('id',$op->product_id)->
					pluck('parent_id');
                echo "parent product_id ".$product_id."\n";
				*/

                $product_id=$op->product_id;
                if (!is_null($sp)) {
                    echo "$sp not null \n";
                    $sproduct=SProduct::find($sp->id);
                    $sproduct->available+=$op->quantity;
                    $sproduct->stock+=$op->quantity;
                    $sproduct->save();
                   
                } else {
                    echo "$sp null \n";
                    $sproduct=new SProduct;
                    $sproduct->product_id=$product_id;
                    $sproduct->available=$op->quantity;
                    $sproduct->stock=$op->quantity;
                    $sproduct->status="active";
                    $sproduct->save();
                    // Create a record in StationProduct
                    $stationproduct=new StationProduct;
                    $stationproduct->station_id=$stId;
                    $stationproduct->sproduct_id=$sproduct->id;
                    $stationproduct->save();
                }
            }
		}
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
			$orders = DB::table('porder')
            ->whereNotIn('status',['manual','commented'])
            ->whereNull('deleted_at')
            ->get();
          
			$globals = DB::table('global')->first();
            $interval=$globals->merchant_process_salesorder_window+
                ($globals->buyer_return_window*24)+
                ($globals->merchant_approve_cre_window*24);
				
			$interval2=
                ($globals->buyer_cancellation_window/60);

			$interval3=
                ($globals->merchant_process_salesorder_window);
			// Squidster: 4hr interval: FOR TESTING ONLY!!!
            //$interval=4;
            echo "R:$interval ";

			foreach($orders as $order){
				$date = $order->created_at;
               
                $now=Carbon::now();
                $diff= UtilityController::timeDiff($date,$now);

				if ($diff > $interval) {
                    POrder::find($order->id)
                        ->update(['status'=>'completed',
							'updated_at'=>date('Y-m-d H:i:s')]);
					/*
					echo 'B2B:$this->sproductUpdater($order)';*/
					
				}
				
				if ($diff > $interval2 && $order->notification == 0) {
					$receipte = DB::table('receipt')->
						where('porder_id', $order->id)->
						pluck('do_password');

					if(!is_null($receipte)){
						dump("Order with notification = 0: -----> " .
							$order->id);

						DB::table('porder')->where('id',$order->id)->
							update(['notification'=>1]);
						
						$useremail = DB::table('users')->
							where('id',$order->user_id)->pluck('email');
						
						$e= new EmailController;
						if(!is_null($useremail)){
							$send1 = $e->sendRC($useremail,$order->id);
							dump($send1);
						}
						$merchant_email = DB::table('users')->
							join('merchant','merchant.user_id','=','users.id')->
							join('merchantproduct','merchant.id','=','merchantproduct.merchant_id')->
							join('orderproduct','merchantproduct.product_id','=','orderproduct.product_id')->
							join('porder','porder.id','=','orderproduct.porder_id')->
							where('porder.id',$order->id)->pluck('users.email');

						if(!is_null($merchant_email)){
							$send2 = $e->sendDO($merchant_email,$order->id);
							dump($send2);
						}
					}
				}
				
				if ($diff > $interval3 && $order->status == 'pending') {
					$porder=POrder::find($order->id);
					$user_id = DB::table('users')->
							where('id',$order->user_id)->pluck('id');

					DB::table('orderproduct')->where('porder_id',$order->id)->update(['status'=>'b-cancelled']);
					$c= New Cre;
					$c->user_id=$user_id;
					$c->type='cancel';
					$c->porder_id=$order->id;
					$c->status='success';
					$c->save();

					$newid = UtilityController::generaluniqueid($c->id, '9','1', $c->created_at, 'ncreid', 'ncre_id');
					DB::table('ncreid')->insert(['ncre_id'=>$newid, 'cre_id'=>$c->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

					$oc_amount = 0;
					$orderproducts = DB::table('orderproduct')->where('porder_id',$order->id)->get();
					foreach($orderproducts as $orderproduct){
						$total = ($orderproduct->order_price * $orderproduct->quantity) + $orderproduct->order_delivery_price;
						$oc_amount += $total;
					}
					$oc= new Ocredit;
					$sidg= new SecurityIDGenerator;
					$security_id= $sidg->generate(Carbon::now()->toDateString());
					$oc->security_id=$security_id;
					$oc->value=$oc_amount;
					$oc->porder_id=$order->id;
					$oc->cre_id=$c->id;
					$oc->source="cre";
					$oc->mode="credit";
					$oc->status="success";
					$oc->save();
					OpenCreditController::save_nocredit_id($oc);
					$porder->status="m-cancelled";
					$porder->save();
					EmailController::sendOrderCancelMail($order->id);
					EmailController::sendOrderCancelMailBuyer($order->id);					
				}
			}
        } catch (\Exception $e){
            dump($e->getMessage());
			echo "Error for Update";
        }
    }
}
