<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Auth;
use Log;
use Mail;
use Carbon;
class EodNatural extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eod:natural';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Does natural eod';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
    	 parent::__construct();
    }

    public function natural_eod()
    {
    	log::debug('Cron natural_eod');
		// echo("------------- natural_eod() ----------------\n");
		
		$buffer=5;
		$terminals= DB::select(DB::raw("
			SELECT 
			opos_terminal.* ,
			HOUR(opos_terminal.start_work) as starthour,
			HOUR(now()) as curhour,
			MINUTE(now()) as curminute,
			(MINUTE(opos_terminal.start_work)-MINUTE(now())) as buffer
			FROM 
			opos_terminal
		  	JOIN opos_locationterminal ON opos_locationterminal.terminal_id = opos_terminal.id
			WHERE 			
			(timediff (opos_terminal.start_work,CURTIME()) > TIME('00:00:00')
			AND timediff (opos_terminal.start_work,CURTIME()) <= TIME('00:05:00'))
			AND opos_terminal.deleted_at IS NULL
			GROUP BY opos_terminal.id
		"));
			// -- HOUR(opos_terminal.start_work)=HOUR(now())
			// -- AND (MINUTE(opos_terminal.start_work)-MINUTE(now()))<$buffer
			// -- AND (MINUTE(opos_terminal.start_work)-MINUTE(now()))>0
			// --(MINUTE(timediff (opos_terminal.start_work,CURTIME()))>=0 and MINUTE(timediff (opos_terminal.start_work,CURTIME()))<=4) 
	   // --
		//dump($terminals);return;
		// var_dump($terminals);
		
		foreach ($terminals as $key => $terminal) {
			// dump($terminal);
			// Check if eligible

			$is_eod=DB::select(DB::raw("

				SELECT * FROM opos_logterminal	
				WHERE opos_logterminal.terminal_id=".$terminal->id."
				AND DATE(eod) = CURDATE()
				
			"));
//AND (timediff (CURTIME(),TIME(opos_logterminal.eod)) > TIME('00:00:00')
			//AND timediff (CURTIME(),TIME(opos_logterminal.eod)) <= TIME('00:05:00'))
			
			// echo "<pre>"; print_r ($is_eod); echo "</pre>"; 
			// echo "insert ".$key." => ".$terminal->id.'</br>';
			// SELECT * FROM opos_logterminal	
			// 	WHERE opos_logterminal.id=".$terminal->id."
			// 	AND DATE(eod) = CURDATE()
			// 	AND ((HOUR(eod)=HOUR(now())	AND (MINUTE(now())-MINUTE(eod))<$buffer	AND (MINUTE(now())-MINUTE(eod))>0 AND type = 'natural') 
			// 		OR type = 'manual')
			//dd($is_eod);
			
			if (!empty($is_eod)) {
				echo "already eoded ".$key." => ".$terminal->id.'</br>';
				continue;
			}

			//-------------Commission Email------------//

		$CommissionDataQuery = "SELECT
		  	`product`.`name`,
		  	`users`.`email` AS `useremail`,
		  	`member`.`email` AS `memberemail`,
		  	`product`.`id` AS `pid`,
		  	`nproductid`.`nproduct_id` AS `nproduct_id`,
		  	`product`.`thumb_photo`,
		  	`opos_saleslog`.*,
		  	SUM(
		    	hcap_productcomm.commission_amt
		  	) AS commission,
	  		SUM(hcap_productcomm.time) AS productTime,
	  		SUM(opos_saleslog.price) AS price,
	  		SUM(opos_saleslog.quantity) AS quantity
			FROM
			  `opos_saleslog`
			INNER JOIN
	  		`product`
			ON
	  		`product`.`id` = `opos_saleslog`.`product_id`
			INNER JOIN
	  		`hcap_productcomm`
			ON
	  		`hcap_productcomm`.`product_id` = `product`.`id` AND `opos_saleslog`.`masseur_id` = `hcap_productcomm`.`sales_member_id`
			LEFT JOIN
	  		`nproductid`
			ON
	  		`nproductid`.`product_id` = `product`.`id`
			LEFT JOIN
	  		`member`
			ON
	  		`member`.`id` = `opos_saleslog`.`masseur_id`
			LEFT JOIN
	  		`users`
			ON
	  		`member`.`user_id` = `users`.`id`
			WHERE
	  		`opos_saleslog`.`deleted_at` IS NULL AND `opos_saleslog`.`start` IS NOT NULL AND `opos_saleslog`.`end` IS NOT NULL AND `opos_saleslog`.`status` = 'completed'
	  		AND `opos_saleslog`.`terminal_id` = $terminal->id
			GROUP BY
	  		`opos_saleslog`.`masseur_id`";

		$CommissionDataWithEmail = DB::select(DB::raw($CommissionDataQuery));
		if(!empty($CommissionDataWithEmail)){
			foreach ($CommissionDataWithEmail as $key => $CommissionSingleData) {
				
				$email = '';
				$name = '';

	            if(!empty($CommissionSingleData->useremail)){
	                $userData = Db::table('users')->where('email', $CommissionSingleData->useremail)->first();
	                $name = $userData->first_name.' '.$userData->last_name;
	                $email = $userData->email;
	            }else{
	            	if(!empty($CommissionSingleData->memberemail)){
						$email =$CommissionSingleData->memberemail;
					}
	            	if(!empty($CommissionSingleData->name)){
	            		$name = $CommissionSingleData->name;
	            	}
	            	
	            }
	            //Generate Pdf
	            $PdfFile = app('App\Http\Controllers\OpossumStaffController')->performance_download($CommissionSingleData->masseur_id,'ComssisonEmail');
	            
	            //send Email Function 
	          	Mail::send('emails.commission', ['EmailReceiverName',$name], function ($m) use ($userData,$CommissionSingleData,$name,$email,$PdfFile) {
	                $m->from('info@opensupermall.com', 'Commission Email');
	                $m->attach($PdfFile, [
	                        'mime' => 'application/pdf',
	                    ]);
	                $m->to($email, $name)->subject('Commission Email');
	            });
	            unlink($PdfFile);
	        }
    	}
		//-------------Commission Email------------//

			// echo(json_encode($is_eod));

			$start_work=$terminal->start_work;
			// $starthour=$terminal->starthour;
			$eod=Carbon::now();

			// $start_work=Carbon::createFromFormat('H:i:s',!empty($start_work)?$start_work:"00:00:00");
			// if ($eod->hour<$starthour) {
				# Subtract to get previous day start_work
				//$start_work=$start_work->subDays(1);
			//}

			//--------------------------------------------------------------//

				// $terminal=DB::table('opos_terminal')->
    //         		where('id',$terminal->id)->first();

		        $start=$terminal->start_work;
		        $end=$terminal->end_work;

		        if(empty($terminal->start_work) || $terminal->start_work == NULL || $terminal->start_work == '00:00:00'){
           			 $start = '00:00:00';
           
    			} 
				if(empty($terminal->end_work) || $terminal->end_work == NULL || $terminal->end_work == '00:00:00'){
				    $end = '23:59:59';
				   
				} 
		        $period="today";

	         	$current_time=time();
		        if ($current_time > strtotime($start) and
		            $current_time < strtotime('23:59:59')) {
		            $period="today";

		        } else {
		            $period="yesterday";
		        }

		        $stime=strtotime($start);
		        $etime=strtotime($end);
		        if ($period=="today") {
		            $start_time=strtotime("+0 day", $stime);
		            $end_time=strtotime("+1 day -5 mins", $stime);

		        } else { // yesterday
		            $start_time=strtotime("-1 day", $stime);
		            $end_time=strtotime("-5 mins", $stime);
		        }

		 //   	// checking natural eod is done or not
	        // $Eodendtimes =strtotime("+5 mins",$end_time);

			// $last_eod = DB::table('opos_logterminal')->
			// 	// select()->
			//  	where('terminal_id',$terminal->id)->
			//  	whereNull('deleted_at')->
   //          	whereBetween('opos_logterminal.eod', array(date('Y-m-d H:i:s',$start_time), date('Y-m-d H:i:s',$Eodendtimes)))->

   //          	where(DB::raw("HOUR(eod)=HOUR(now())
			// 	AND (MINUTE(now())-MINUTE(eod))<$buffer
			// 	AND (MINUTE(now())-MINUTE(eod))>0
   //          		"))->
			//     orderBy("id","DESC")->
			// 	first();

				

		 	// if (!empty($last_eod) &&(($last_eod->) < 5)) {

    //         	echo "already added";
				// exit();
    //     	}

			// insert all receiptdata
			$location_id=DB::table("opos_locationterminal")
				->where("terminal_id",$terminal->id)
				->whereNull("deleted_at")
				->orderBy("created_at","DESC")
				->pluck("location_id");

			$reports = DB::table("opos_receipt")->
				join("opos_receiptproduct","opos_receiptproduct.receipt_id","=","opos_receipt.id")->
				leftJoin('opos_servicecharge','opos_servicecharge.id','=','opos_receiptproduct.servicecharge_id')->
				leftJoin('users as usercheck','usercheck.id','=','opos_receipt.staff_user_id')->
				leftJoin('opos_servicecharge as sc','sc.id','=','opos_receipt.servicecharge_id')->
				select('sc.value',
	                "opos_receipt.id as receipt_id",
					DB::raw(
						"SUM(opos_receiptproduct.quantity*(opos_receiptproduct.price)) as amount"
					),
					"sc.value as servicecharge",
					"opos_receipt.service_tax",
					"opos_receipt.status",
					"opos_receipt.cash_received",
					"opos_receipt.otherpoints",
					"opos_receipt.payment_type",
					"opos_receipt.mode",
					DB::raw(
						"SUM((opos_receiptproduct.quantity*opos_receiptproduct.price*opos_receiptproduct.discount)/100) as discount")
					)->
				whereRaw('opos_receipt.status IN ("completed")')->
				whereNull("opos_receipt.deleted_at")->
	            whereNull("opos_receiptproduct.deleted_at");

	 			// $log_startDate = $log_endDate = $CurrentDate=date("Y-m-d H:i:s",strtotime($start_work));
		   //      $endDate = date("Y-m-d H:i:s",strtotime('+24 hours', strtotime($CurrentDate)));
		   //      $endDate = date("H:i:s",strtotime('-5 minutes',strtotime($CurrentDate)));
			
	    //     	$CurrentTime  = date("H:i:s");
			
		   //      $CurrentdATETime  = date("Y-m-d H:i:s");
		   //      $Midnight     = date('00:00:00');

	    //      	if($CurrentTime >= $Midnight && $CurrentTime < $endDate){
	    //     		$log_startDate=date("Y-m-d H:i:s",strtotime('-24 hours', strtotime($CurrentDate)));
	    	    
	    // 		}else{

	    //    	 		$log_endDate=date("Y-m-d H:i:s",strtotime('+24 hours', strtotime($CurrentDate)));
	    // 		}
	    // 		$log_endDate = date("Y-m-d H:i:s",strtotime('-5 minutes',strtotime($log_endDate)));

	    		

	    		// $month_start = date('Y-m-d',strtotime('first day of this month',strtotime($CurrentDate)));

	    		// $month_end = date('Y-m-d',strtotime('last day of this month',strtotime($log_endDate)));

	    		$month_start = date('Y-m-d',strtotime('first day of this month',$start_time));
				
        		$month_end = date('Y-m-d',strtotime('last day of this month',$end_time));

	    		//today total

	  			$todayAmount = $reports->
				whereRaw('opos_receipt.terminal_id = '.$terminal->id)->
	            // whereRaw('opos_receipt.created_at BETWEEN "'.
	            //     $CurrentDate.'" AND "'.$log_endDate.'"')->
	            whereRaw('opos_receipt.created_at BETWEEN "'.date('Y-m-d H:i:s', $start_time).'" AND "'.date('Y-m-d H:i:s', $end_time).'"')->
				groupBy('opos_receipt.id')->
				get();

			// monthly total
				$Monthlyamount = $reports->
				whereRaw('opos_receipt.terminal_id = '.$terminal->id)->
	            whereRaw('opos_receipt.created_at BETWEEN "'.
	                $month_start.'" AND "'.$month_end.'"')->
				groupBy('opos_receipt.id')->
				first();
				
				$Monthlyamount = 0;
				if(!empty($Monthlyamount)){
					$Monthlyamount = $Monthlyamount->amount;
				}

			//branch total
				$branchsalerecords=$reports->
				join('opos_locationterminal','opos_locationterminal.terminal_id','=','opos_receipt.terminal_id')->
				where('opos_locationterminal.location_id',$location_id)->
	            // whereRaw('opos_receipt.created_at BETWEEN "'.$CurrentDate.'" AND "'.$log_endDate.'"')->
	            whereRaw('opos_receipt.created_at BETWEEN "'.date('Y-m-d H:i:s', $start_time).'" AND "'.date('Y-m-d H:i:s', $end_time).'"')->
				groupBy('opos_receipt.id')->
				get();
			
				$todayservicecharge=0;$todaysst=0;$todaytotal=0;
				foreach ($todayAmount as $r) {
		            /* Original price less discount */

		            if ($r->mode=="inclusive") {
		                $r->amount = $r->amount - $r->discount;
		                $sc=0;
		                $amount=$r->amount/(1+($r->service_tax/100));
		                $todaysst+=$r->amount-$amount;
		                $todayservicecharge+=$sc;
		                $todaytotal += $amount;

		            }else{
		                $r->amount = $r->amount - $r->discount;
		                $todayservicecharge+=($r->servicecharge*$r->amount)/100;
		                $todaysst=($r->service_tax*$r->amount)/100;
		                $todaytotal += $r->amount;
		            }
		        }

		        $branchsale=0;
		        foreach ($branchsalerecords as $r) {
		            /* Original price less discount */

		            if ($r->mode=="inclusive") {
		                $r->amount = $r->amount - $r->discount;
		                $sc=0;
		                $amount=$r->amount/(1+($r->service_tax/100));
		                //$sst=$r->amount-$amount;
		                $branchsale += $amount;
		                /*$s=floatval($r->amount) * (($r->service_tax)/100.0);*/
		                /*$r->amount=$r->amount/(1+($r->service_tax/100));*/

		            }else{
		                $r->amount = $r->amount - $r->discount;
		                $branchsale += $r->amount;
		            }
		        }

		        $cash=0;
		        $creditcard=0;
		        $otherpoints=0;
	    
		        foreach ($todayAmount as $r) {
		            //Log::debug(json_encode($r));
		            /* Original price less discount */
		            
		            $r->amount = $r->amount - $r->discount;

		            /* Service charge against total */
		            $scharge = $r->amount * (($r->value)/100);

		            /*Service Tax*/
		            $sst=0;
		            if ($r->mode=="exclusive") {
		                $sst+=$r->amount * (($r->service_tax)/100);
		            }
		            /* Final total includes service charge */
		            $r->amount = $r->amount + $scharge+$sst; 
		            /*For cash and credit*/
		            if($r->status=="completed"){
		                if ($r->cash_received>=$r->amount) {
		                    $cash+=$r->amount;

		                }else{
		                    if ($r->cash_received<$r->amount) {
		                        $cash+=$r->cash_received;

		                        if ($r->payment_type=="creditcard") {
		                           
		                            $creditcard+=($r->amount-($r->otherpoints*100)-$r->cash_received);
		                        }
		                    }
		                }

		                $otherpoints+=$r->otherpoints;
		            }
		        }

			$insert=[
				"terminal_id"=>$terminal->id,
				"eod"=>$eod,
				"type"=>"natural",
					// "start_work"=>$start_work,
					// "start_work"=>$CurrentDate,
				"start_work"=>date('Y-m-d H:i:s', $start_time),
				"today_branch_sales" => $branchsale,
				"today_sales" =>$todaytotal,
				"today_sst" =>$todaysst,
				"today_servicecharge" => $todayservicecharge,
				"today_cash" =>$cash,
				"today_creditcard" =>$creditcard,
				"today_point" => $otherpoints,
				"monthly_sales" =>$Monthlyamount,
				"created_at"=>Carbon::now(),
				"updated_at"=>Carbon::now()
			];

			DB::table("opos_logterminal")
				->insert($insert);
			// $eod=Carbon::now();


			/* BUG: PLEASE FIX THIS!!
			Temporarily setting this to zero To prevent an exception */
			// user_id =???

			$user_id = 0;

			DB::table("opos_eod")
			->insert([
				"eod_presser_user_id"=>$user_id,
				"location_id"=>$location_id,
				"eod"=>$eod,
				"created_at"=>Carbon::now(),
				"updated_at"=>Carbon::now()
			]);
		}
		echo "ok";
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	log::debug('handles');
        $this->natural_eod();
    }
}
