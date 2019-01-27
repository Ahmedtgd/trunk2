<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Owarehouse;
use\App\Models\Globals;
use Carbon;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\IdController;
use DB;
class TermEmail extends Command
{

     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'term:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Emailing term user paying reminder";
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
        $term_reminder_period = DB::table('global')->first()->term_reminder_period;
		$all= DB::table('porder')->
			join('invoice','invoice.porder_id','=','porder.id')->
			where('invoice.status','!=','completed')->
			join('ordertproduct','ordertproduct.porder_id','=','porder.id')->
			join('merchanttproduct','ordertproduct.tproduct_id','=',
				'merchanttproduct.tproduct_id')->
			select('porder.*','merchanttproduct.merchant_id',
				'invoice.id as invoice_id','invoice.duration')->get();

		foreach ($all as $a) {
            try {
				$debt_calculation = 0;
				$tproducts_pos = DB::table('ordertproduct')->
					join('tproduct','tproduct.id','=','ordertproduct.tproduct_id')
					->where('porder_id',$a->id)->get();

				$total_owed = 0;
				foreach($tproducts_pos as $tproducts_po){
					$total_owed += ($tproducts_po->order_price/100)*$tproducts_po->quantity;
				}
				$payments_pos = DB::table('invoicepayment')->
					where('invoice_id',$a->invoice_id)->get();

				foreach($payments_pos as $payments_po){
					$total_owed -= $payments_po->amount/100;
				}
				$created = new Carbon($a->created_at);
				$station = DB::table('station')->
					where('user_id',$a->user_id)->first();

				$merchant = DB::table('merchant')->
					where('id',$a->merchant_id)->first();

				$stationterm = DB::table('stationterm')->
					where('creditor_user_id',$merchant->user_id)->
					where('station_id',$station->id)->first(); 

				$now = Carbon::now();
				$date = $created->addDays($a->duration);
				$diff= $date->diff($now)->days;
				$idc= new IdController;
				$porderid= $idc->nO($a->id);

				echo "diff=".$diff.",porder_id=".$a->id.
					",total_owed=".$total_owed."\n";

				if($total_owed > 0 ){
					if ($diff == ($term_reminder_period * 7) ||
						$diff == 21 || $diff == 15 ||
						($diff <= 7 && $diff >=0) ){

						$user = DB::table('users')->
							where('id',$a->user_id)->first();

						$e= new EmailController;
						$e->termEmail($user->email, $diff, $a->id,
							$porderid, $total_owed);	

						echo "diff=".$diff.",owed=".$total_owed.",email=".$user->email."\n";
						DB::table('invoice')->
							where('id',$a->invoice_id)->
							update(['status'=>'coming due']);
					}

					if ($diff <= 0){
						$user = DB::table('users')->
							where('id',$a->user_id)->first();

						$e= new EmailController;
						$e->termEmailOverdue($user->email, $diff,
							$a->id, $porderid, $total_owed);	
						
						DB::table('invoice')->
							where('id',$a->invoice_id)->
							update(['status'=>'overdue']); 
					}
				}
            } catch (\Exception $e) {
				echo "Error for Porder ID: ".$a->id."\n";
            }
        }
    }
}
