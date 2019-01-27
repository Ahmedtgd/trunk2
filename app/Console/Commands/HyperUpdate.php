<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Owarehouse;
use\App\Models\Globals;
use App\Models\POrder;
use App\Models\Owarehouse_pledge;
use Carbon;
use DB;
class HyperUpdate extends Command
{

     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hyper:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Updates Hyper's status";
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
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $all= Owarehouse::where('status','active')->get();
         echo "\n";

        echo "Count of Active Hypers: ".count($all)."\n";
        $hyper_durationInDays=Globals::first()->hyper_duration;

		echo "hyper_duration=$hyper_durationInDays\n";

        foreach ($all as $a) {
            try {
            $created = new Carbon($a->created_at);
            $now = Carbon::now();
            $diff= $created->diff($now)->days;
            $acopy= Owarehouse::find($a->id);
            $pledges = DB::table('owarehousepledge')->
                    where('owarehouse_id',$a->id)->
                    sum('pledged_qty');

			/* We will expire on the SAME day!! */
            if ($diff >= $hyper_durationInDays and $a->status=="active") {
				// Set status to expired.
				
                $product_id= $a->product_id;
				$product = DB::table('product')->
					where('id',$a->product_id)->first();
				if($pledges < $a->moq){
					/************* OPEN CREDIT **************/
					$pledges = DB::table('owarehousepledge')->where('owarehouse_id',$a->id)->get();
					foreach($pledges as $pledge){
					/*
						$porder = DB::table('porder')->where('porder.user_id',$pledge->user_id)->join('orderproduct','porder.id','=','orderproduct.porder_id')->where('orderproduct.porder_id',$pledge->porder_id)->where('orderproduct.quantity',$pledge->pledged_qty)->
                            where('porder.id',$pledge->porder_id)
                            ->first();
						*/
                        $porder_id=$pledge->porder_id;

						$cre_new = DB::table('cre')->insertGetId(['user_id'=>$pledge->user_id,'type'=>'return','porder_id'=>$porder_id, 'status' => 'success','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
						
						$value = 0;
						if(!is_null($product)){
							$value = $pledge->pledged_qty * $product->owarehouse_price;
						}
						$ocredit=new Ocredit;
                        $sidg= new SecurityIDGenerator;
                        $security_id= $sidg->generate(Carbon::now()->toDateString());
                        $ocredit->mode="credit";
                        $ocredit->status="success";
                        $ocredit->source="hyper";
                        $ocredit->owarehouse_id=$a->id;
                        $ocredit->cre_id=$cre_new;
                        $ocredit->value=$value;
                        $ocredit->security_id=$security_id;
                        $ocredit->save();
						// $ocre_new = DB::table('ocredit')->insertGetId(['cre_id'=>$cre_new,'mode'=>'credit','owarehouse_id'=>$a->id,'product_id'=>$product_id,'porder_id'=>$porder_id,'value'=>$value,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					}
					$acopy->status="expired";
				} else {

					/************* PROCESS PLEDGES **************/
                    /*Update porder status to pending*/
                    $owpledges=DB::table('owarehousepledge')->
                    where('owarehouse_id',$a->id)->get();
                    foreach ($owpledges as $pl) {
                        $po=POrder::find($pl->porder_id);
                        if (!empty($po)) {
                            $po->status="pending";
                            $po->save();
                        }
                        echo $pl->id;
                        $opl=Owarehouse_pledge::find($pl->id);
                        if (!empty($opl)) {
                            $opl->status="executed";
                            $opl->save();
                        }
                    }
					$acopy->status="executed";
				}			
                
                
                $acopy->save();
                echo "\n";
                echo "Owarehouse ID: ".$a->id." set to expired";
                echo "\n";
            }

            } catch (\Exception $e) {
                 echo "\n";

                echo "Error for Owarehouse ID: ".$a->id;
                echo $e->getMessage();
                echo "\n";
                echo $e->getLine();
                 echo "\n";

            }
        }
    }
}
