<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Carbon;
use Auth;
use App\Models\User;
use App\Models\Address;
class OposEodController extends Controller
{
  //-----------------------------------------
  // Created by Zurez
  //-----------------------------------------
    public function eod_times($terminalId)
    {
        $terminal=DB::table('opos_terminal')->
            where('id',$terminalId)->first();

        $start=$terminal->start_work;
        $end=$terminal->end_work;

       
        if(empty($terminal->start_work) || $terminal->start_work == NULL || $terminal->start_work == '00:00:00'){
            $start = '00:00:00';
           
        } 
         
        if(empty($terminal->end_work) || $terminal->end_work == NULL || $terminal->end_work == '00:00:00'){
            $end = '23:59:59';
           
        } 

        $period="today";

        /* TODAY = start_time < current_time < midnight
         * YESTD = midnight   < current_time < start_time */
        $current_time=time();
        if ($current_time > strtotime($start) and
            $current_time < strtotime('23:59:59')) {
            $period="today";

        } else {
            $period="yesterday";
        }

		Log::debug('start='.$start.', end='.$end.', period='.$period);

        $stime=strtotime($start);
        $etime=strtotime($end);

        if ($period=="today") {
            $start_time=strtotime("+0 day", $stime);
            $end_time=strtotime("+1 day -5 mins", $stime);

        } else { // yesterday
            $start_time=strtotime("-1 day", $stime);
            $end_time=strtotime("-5 mins", $stime);
        }

		Log::debug('start_time='.date("Y-m-d H:i:s", $start_time));
		Log::debug('end_time  ='.date("Y-m-d H:i:s", $end_time));

        return array('starttimes' => $start_time, 'endtimes' => $end_time);
    }

    public function eod_CommonTimes($starttime)
    {
        $log_startDate = $log_endDate = $CurrentDate=date("Y-m-d H:i:s",strtotime($starttime));
        $endDate = date("Y-m-d H:i:s",strtotime('+24 hours', strtotime($CurrentDate)));
        $endDate = date("H:i:s",strtotime('-5 minutes',strtotime($CurrentDate)));
        $CurrentTime  = date("H:i:s");

        $CurrentdATETime  = date("Y-m-d H:i:s");
        $Midnight     = date('00:00:00');
       
        //condition for mid night display record
        if($CurrentTime >= $Midnight && $CurrentTime < $endDate){
            $log_startDate=date("Y-m-d H:i:s",strtotime('-24 hours', strtotime($CurrentDate)));
            
        }else{

            $log_endDate=date("Y-m-d H:i:s",strtotime('+24 hours', strtotime($CurrentDate)));
        }
        $log_endDate = date("Y-m-d H:i:s",strtotime('-5 minutes',strtotime($log_endDate)));

       

        return array('starttime' => $log_startDate, 'endtime' => $log_endDate);
    }

	public function last_eod_summary($id,$id_type="log",$uid=NULL)
	{
		$ret=array();
		$ret["status"]="failure";
		if(!Auth::check()){return "Please login";}
		$user_id=Auth::user()->id;
		if(!empty($uid) and Auth::user()->hasRole("adm")){
			$user_id=$uid;
		}

		try{
			if ($id_type=="log") {
               
				$log=DB::table('opos_logterminal')->
					where('id',$id)->
					whereNull('deleted_at')->
					orderBy('created_at','DESC')->
					first();
				$terminal_id=$log->terminal_id;

			}else{
                
				// $log=DB::table('opos_logterminal')->
				// 	where('terminal_id',$id)->
				// 	whereNull('deleted_at')->
				// 	orderBy('created_at','DESC')->
				// 	first();
                $log=DB::table('opos_terminal')->
                    select('end_work as eod','start_work as start_work')->
                    where('id',$id)->
                    whereNull('deleted_at')->
                    orderBy('created_at','DESC')->
                    first();
				$terminal_id=$id;

			}
		if (empty($log)) {
			return "No EOD records found!";
		}
        
		$location_id=DB::table("opos_locationterminal")->
			where('terminal_id',$terminal_id)->
			pluck('location_id');
 
        $location=DB::table('fairlocation')->
			where('id',$location_id)->first();

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

        // $log_startDate = $log_endDate = $CurrentDate=date("Y-m-d H:i:s",strtotime($log->start_work));
        // $endDate = date("Y-m-d H:i:s",strtotime('+24 hours', strtotime($CurrentDate)));
        // $endDate = date("H:i:s",strtotime('-5 minutes',strtotime($CurrentDate)));

        // $CurrentTime  = date("H:i:s");

        // $CurrentdATETime  = date("Y-m-d H:i:s");
        // $Midnight     = date('00:00:00');
       
        //condition for mid night display record
        // if($CurrentTime >= $Midnight && $CurrentTime < $endDate){
        //     $log_startDate=date("Y-m-d H:i:s",strtotime('-24 hours', strtotime($CurrentDate)));
            
        // }else{

        //     $log_endDate=date("Y-m-d H:i:s",strtotime('+24 hours', strtotime($CurrentDate)));
        // }
        // $log_endDate = date("Y-m-d H:i:s",strtotime('-5 minutes',strtotime($log_endDate)));

            //time function 
            // $times = $this->eod_CommonTimes($log->start_work);
        
        
        if ($id_type=="log") {
            if(empty($log->start_work) || $log->start_work == NULL || $log->start_work == '00:00:00'){
                $starttimes = date('Y-m-d 00:00');
            }else{
                $starttimes = date('Y-m-d H:i', strtotime($log->start_work));
            } 
         
            if(empty($log->eod) || $log->eod == NULL || $log->eod == '00:00:00'){
                $endtimes = date('Y-m-d 23:59');
            }else{
                $endtimes = date('Y-m-d H:i', strtotime($log->eod));
            }
            
            
        }else{
            $starttimes = date('Y-m-d 00:00');
            $endtimes =date('Y-m-d 23:59');
            if(!empty($terminal_id)){
                $times = $this->eod_times($terminal_id);
                $starttimes = date('Y-m-d H:i', $times['starttimes']);
                $endtimes = date('Y-m-d H:i', $times['endtimes']);
            }
        }

        $todayAmount = $reports->
			whereRaw('opos_receipt.terminal_id = '.$terminal_id)->
            whereRaw(DB::raw("DATE_FORMAT(opos_receipt.created_at,'%Y-%m-%d %H:%i') BETWEEN '".$starttimes."' AND '".$endtimes."'"))->
			groupBy('opos_receipt.id')->
			get();
           // dd($todayAmount);
        $branchsalerecords=$reports->
			join('opos_locationterminal','opos_locationterminal.terminal_id','=','opos_receipt.terminal_id')->
			where('opos_locationterminal.location_id',$location_id)->
			// whereRaw('opos_receipt.created_at BETWEEN "'.$log->start_work.'" AND "'.$log->eod.'"')->
            // whereRaw('opos_receipt.created_at BETWEEN "'.$times['starttime'].'" AND "'.$times['endtime'].'"')->
           // whereRaw('opos_receipt.created_at BETWEEN "'.$starttimes.'" AND "'.$endtimes.'"')->
           whereBetween('opos_receipt.created_at', array($starttimes, $endtimes))->
			groupBy('opos_receipt.id')->
			get();
        // echo "<pre>"; print_r ($branchsalerecords); echo "</pre>"; exit();
 
        $todaytotal=0; $branchsale=0;
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

		$todayservicecharge=0;$todaysst=0;
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
        /*  dump("amount  =".$r->amount);*/
            /*
            Log::debug("amount  =".$r->amount);
            Log::debug("discount=".$r->discount);
            Log::debug("scharge =".$scharge);
            */

            /*For cash and credit*/
            if($r->status=="completed"){
               
                if ($r->cash_received>=$r->amount) {
                    $cash+=$r->amount;

                }else{
                    if ($r->cash_received<$r->amount) {
                        $cash+=$r->cash_received;

                        if ($r->payment_type=="creditcard") {
                            # code...
                            /*dump($r->amount);
                            dump($r->otherpoints);
                            dump($r->cash_received);*/
                            $creditcard+=($r->amount-($r->otherpoints*100)-$r->cash_received);
                        }
                    }
                }

                $otherpoints+=$r->otherpoints;
            }
        }
      
         $company=DB::table("company")->
		 	join("fairlocation","fairlocation.user_id","=","company.owner_user_id")->
			join("merchant","merchant.user_id","=","company.owner_user_id")->
			join("address","address.id","=","merchant.address_id")->
			leftjoin("address as address2","address2.id","=","fairlocation.address_id")->
			select(
				DB::raw("IF(fairlocation.address_preference = 'branch', address2.line1, address.line1) as line1"),
				DB::raw("IF(fairlocation.address_preference = 'branch', address2.line2, address.line2) as line2"),
				DB::raw("IF(fairlocation.address_preference = 'branch', address2.line3, address.line3) as line3"),
				DB::raw("IF(fairlocation.address_preference = 'branch', address2.line4, address.line4) as line4"),
				'company.dispname',
				'merchant.gst','merchant.business_reg_no'
			 )->
			 where("fairlocation.id",$location_id)->
			 first();

		$bfunction="";

        $terminal=DB::table("opos_terminal")->
			where("id",$terminal_id)->
			whereNull("deleted_at")->
			first();
        // dd($terminal);

        $bfunction=$terminal->bfunction;
        $localLogo=$terminal->local_logo;
        $show_sst_no=$terminal->show_sst_no;

        if (!empty($company)) {
            /*If terminal has a local addres*/
            if (!empty($terminal->address_id)) {
                $address=DB::table("address")->
					where('id',$terminal->address_id)->
					first();

                if (!empty($address)) {
                    $company->line1=$address->line1;
                    $company->line2=$address->line2;
                    $company->line3=$address->line3;
                }
            }
        }

        $staff=DB::table("users")->
			where("id",$user_id)->
			select("first_name","last_name")->first();

        $first_name=$staff->first_name;
        $last_name=$staff->last_name;
        $staffname=$first_name." ".$last_name;
        $staffid=sprintf("%010d",$user_id);
       
        return view('seller.opossum_document.eod_summary',
			compact('company','cash','creditcard','branchsale',
				'otherpoints','todaytotal','location','terminal_id',
				'log','todaysst','todayservicecharge','show_sst_no',
				'staffid','staffname'));

		} catch(\Exception $e){
          Log::error("Error @ ".$e->getLine()." file ".$e->getFile().
		  	" ".$e->getMessage());
		}

		return response()->json($ret);
	}

    public function save_eod_summary($id,$id_type="log",$uid=NULL)
    {
        $todayAmount=0;$todayservicecharge=0;$todaysst=0;$cash=0;$creditcard=0;$branchsale=0;
            if ($id_type=="log") {
                $log=DB::table('opos_logterminal')->
                    where('id',$id)->
                    whereNull('deleted_at')->
                    orderBy('created_at','DESC')->
                    first();
                if (empty($log)) {
                    return compact('todayAmount','todayservicecharge','todaysst','cash','creditcard','branchsale');

                }
                $terminal_id=$log->terminal_id;

            }else{
                // $log=DB::table('opos_logterminal')->
                //     where('terminal_id',$id)->
                //     whereNull('deleted_at')->
                //     orderBy('created_at','DESC')->
                //     first();
                    $log=DB::table('opos_terminal')->
                    select('end_work as eod','start_work as start_work')->
                    where('id',$id)->
                    whereNull('deleted_at')->
                    orderBy('created_at','DESC')->
                    first();
                $terminal_id=$id;
            }

        if (empty($log)) {
            return "No EOD records found!";
        }

        $location_id=DB::table("opos_locationterminal")->
            where('terminal_id',$terminal_id)->
            pluck('location_id');

        $location=DB::table('fairlocation')->
            where('id',$location_id)->first();

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
            whereNull("opos_receiptproduct.deleted_at")
            ;

        // $CurrentDate=date("Y-m-d H:i:s",strtotime($log->start_work));
        // $CurrentTime  = strtotime('now');
        // $Midnight     = strtotime('12:00am');
        // //condition for mid night display record
        // if($CurrentTime > $Midnight){
        //     $log_endDate=date("Y-m-d H:i:s",strtotime('+24 hours', strtotime($CurrentDate)));
        //     $lockTime = date("Y-m-d H:i:s",strtotime('-5 minutes',strtotime($log_endDate)));
        // }else{
        //     $log_endDate=date("Y-m-d H:i:s",strtotime('-24 hours', strtotime($CurrentDate)));
        //     $lockTime = date("Y-m-d H:i:s",strtotime('-5 minutes',strtotime($log_endDate)));
        // }

        // $log_startDate = $log_endDate = $CurrentDate=date("Y-m-d H:i:s",strtotime($log->start_work));
        // $endDate = date("Y-m-d H:i:s",strtotime('+24 hours', strtotime($CurrentDate)));
        // $endDate = date("H:i:s",strtotime('-5 minutes',strtotime($CurrentDate)));

        // $CurrentTime  = date("H:i:s");

        // $CurrentdATETime  = date("Y-m-d H:i:s");
        // $Midnight     = date('00:00:00');
       
        //condition for mid night display record
        // if($CurrentTime >= $Midnight && $CurrentTime < $endDate){
        //     $log_startDate=date("Y-m-d H:i:s",strtotime('-24 hours', strtotime($CurrentDate)));
            
        // }else{

        //     $log_endDate=date("Y-m-d H:i:s",strtotime('+24 hours', strtotime($CurrentDate)));
        // }
        // $log_endDate = date("Y-m-d H:i:s",strtotime('-5 minutes',strtotime($log_endDate)));

        //time function    
        // $times = $this->eod_CommonTimes($log->start_work); 
            $starttimes = date('Y-m-d 00:00:00');
            $endtimes =date('Y-m-d 23:59:59');
            if(!empty($terminal_id)){

                $times = $this->eod_times($terminal_id);
                $starttimes = date('Y-m-d H:i:s', $times['starttimes']);
                $endtimes = date('Y-m-d H:i:s', $times['endtimes']);
            }

        $todayAmount = $reports->
            whereRaw('opos_receipt.terminal_id = '.$terminal_id)->
            // whereRaw('opos_receipt.created_at BETWEEN "'.
            //     $log->start_work.'" AND "'.$log->eod.'"')->
            // whereRaw('opos_receipt.created_at BETWEEN "'.
            //     $times['starttime'].'" AND "'.$times['endtime'].'"')->
            whereRaw('opos_receipt.created_at BETWEEN "'.$starttimes.'" AND "'.$endtimes.'"')->
            groupBy('opos_receipt.id')->
            get();
        
           // dd($todayAmount);
        $branchsalerecords=$reports->
            join('opos_locationterminal','opos_locationterminal.terminal_id','=','opos_receipt.terminal_id')->
            where('opos_locationterminal.location_id',$location_id)->
            // whereRaw('opos_receipt.created_at BETWEEN "'.$log->start_work.'" AND "'.$log->eod.'"')->
             //whereRaw('opos_receipt.created_at BETWEEN "'.$log_endDate.'" AND "'.$lockTime.'"')->
              // whereRaw('opos_receipt.created_at BETWEEN "'.$times['starttime'].'" AND "'.$times['endtime'].'"')->
            whereRaw('opos_receipt.created_at BETWEEN "'.$starttimes.'" AND "'.$endtimes.'"')->
            groupBy('opos_receipt.id')->
            get();
        
 
        $todaytotal=0; $branchsale=0;
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

        $todayservicecharge=0;$todaysst=0;
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
        /*  dump("amount  =".$r->amount);*/
            /*
            Log::debug("amount  =".$r->amount);
            Log::debug("discount=".$r->discount);
            Log::debug("scharge =".$scharge);
            */

            /*For cash and credit*/
            if($r->status=="completed"){
                if ($r->cash_received>=$r->amount) {
                    $cash+=$r->amount;

                }else{
                    if ($r->cash_received<$r->amount) {
                        $cash+=$r->cash_received;

                        if ($r->payment_type=="creditcard") {
                            # code...
                            /*dump($r->amount);
                            dump($r->otherpoints);
                            dump($r->cash_received);*/
                            $creditcard+=($r->amount-($r->otherpoints*100)-$r->cash_received);
                        }
                    }
                }

                $otherpoints+=$r->otherpoints;
            }
        }
       
     
      return compact('todayAmount','todayservicecharge','todaysst','cash','creditcard','branchsale');

        
    }


    public function showreceiptlist(Request $request,$terminal_id){

        $user_id=Auth::user()->id;

        $month = Carbon::today()->format('F');
        $year = Carbon::now()->year;
        $terminalId = '0';

        $formdate = Carbon::today()->format('jS');

        if (!Auth::check()) {
            return response()->json(["error"=>"Not Logged In"],403);
        }

        $merchant = DB::table('merchant')->where('user_id',$user_id)->first();

        $selluser = User::find($user_id);

        $merchant_address = Address::where('id',!empty($merchant->address_id)?$merchant->address_id:"")
        ->first(array('line1','line2','line3','line4'));

        if($terminal_id > 0) {
            $terminalId = $terminal_id;
        } else{
            echo "<h4'>Terminal not found!</h4>";
            exit();
        }

        // $terminal=DB::table('opos_terminal')->
        //     where('id',$terminal_id)->first();

        // $start=$terminal->start_work;
        // $end=$terminal->end_work;
        // $period="today";

        /* TODAY = start_time < current_time < midnight
         * YESTD = midnight   < current_time < start_time */
        // $current_time=time();
        // if ($current_time > strtotime($start) and
        //     $current_time < strtotime('23:59:59')) {
        //     $period="today";

        // } else {
        //     $period="yesterday";
        // }

        // $stime=strtotime($start);
        // $etime=strtotime($end);

        // if ($period=="today") {
        //     $start_time=strtotime("+0 day", $stime);
        //     $end_time=strtotime("+1 day -5 mins", $stime);

        // } else { // yesterday
        //     $start_time=strtotime("-1 day", $stime);
        //     $end_time=strtotime("-5 mins", $stime);
        // }

        // cal eod time function
        // $Eodtimes = $this->eod_times($terminal_id);

        $start_time = date('Y-m-d 00:00');
        $end_time =date('Y-m-d 23:59');
        if(!empty($terminal_id)){

            $Eodtimes = $this->eod_times($terminal_id);
            $start_time=date('Y-m-d H:i',$Eodtimes['starttimes']);
            $end_time=date('Y-m-d H:i',$Eodtimes['endtimes']);
        }

        // Convert to timestamp
        // $start_time=date('Y-m-d h:i:s',$start_time);
        // $end_time=date('Y-m-d h:i:s',$end_time);

        // $start_time=date('Y-m-d h:i:s',$Eodtimes['starttimes']);
        // $end_time=date('Y-m-d h:i:s',$Eodtimes['endtimes']);

        Log::debug('start_time='.$start_time);
        Log::debug('end_time  ='.$end_time);
        // Log::debug('period    ='.$period);

        $location  = DB::table('opos_locationterminal')
            ->select('fairlocation.*','opos_locationterminal.terminal_id')
            ->join('fairlocation','opos_locationterminal.location_id','=','fairlocation.id')
            ->where('opos_locationterminal.terminal_id',$terminalId)->first();



        $currency= DB::table('currency')->where('active', 1)->first()->code;

        $reports = DB::table("opos_receipt")
        ->join("opos_receiptproduct","opos_receiptproduct.receipt_id","=","opos_receipt.id")
        ->join('opos_locationterminal','opos_receipt.terminal_id','=','opos_locationterminal.terminal_id')
        ->join('fairlocation','fairlocation.id','=','opos_locationterminal.location_id')
       ->leftJoin('opos_servicecharge','opos_servicecharge.id','=','opos_receiptproduct.servicecharge_id')
       ->leftJoin('users as usercheck','usercheck.id','=','opos_receipt.staff_user_id')
        ->leftJoin('opos_servicecharge as sc','sc.id','=','opos_receipt.servicecharge_id')
        ->select('opos_receipt.id','opos_receipt.staff_user_id',
            'opos_receipt.created_at','usercheck.first_name',
            'usercheck.last_name','opos_receipt.receipt_no',
            'opos_receipt.status',
            'opos_receipt.creditcard_no',
            'opos_receipt.otherpoints',
            'opos_receipt.payment_type',
            'opos_receipt.cash_received',
            'sc.value',
            'opos_receipt.mode',
            'opos_receipt.round',
            'opos_receipt.terminal_id','opos_receipt.cash_received',
            //SUM(opcp.quantity*(opcp.price+(opsc.value*opcp.price/100))) as amount,
            'fairlocation.location',
            DB::raw(
            //"SUM(opos_receiptproduct.quantity*(opos_receiptproduct.price+ (opos_servicecharge.value/100)*opos_receiptproduct.price) ) as amount"
           "SUM(opos_receiptproduct.quantity*(opos_receiptproduct.price)) as amount"
            ),
            "sc.value as servicecharge",
            "opos_receipt.service_tax",
            DB::raw(
                "SUM((opos_receiptproduct.quantity*opos_receiptproduct.price*opos_receiptproduct.discount)/100) as discount")
        );

        $reports = $reports->whereRaw('opos_receipt.terminal_id = '.$terminalId)
               ->whereRaw('opos_receipt.status IN ("completed","voided")')->whereNull("opos_receipt.deleted_at")->whereNull("opos_receiptproduct.deleted_at");

        $report1 = $reports->toSql();
        $report2 = $reports->toSql();
        
        $monthlyAmount = DB::select($report2.' and opos_receipt.created_at like "'.
            date('Y-m',strtotime(Carbon::today())).'%" GROUP BY opos_receiptproduct.id');
        
        // $todayAmount = DB::select($report1.' and opos_receipt.created_at BETWEEN "'.
        //     $start_time.'" AND "'.$end_time.'" GROUP BY opos_receiptproduct.id');

         $todayAmount = DB::select($report1." AND DATE_FORMAT(opos_receipt.created_at,'%Y-%m-%d %H:%i') BETWEEN '".$start_time."' AND '".$end_time."' GROUP BY opos_receiptproduct.id");

        $reports->whereRaw(' opos_receipt.created_at BETWEEN "'.
            $start_time.'" AND "'.$end_time.'"')->
            groupBy("opos_receipt.id")->
            orderBy("opos_receipt.id", "desc");

        $reports = $reports->orderBy("opos_receipt.created_at","DESC")->get();
        
        $cash=0;
        $creditcard=0;
        $otherpoints=0;
        foreach ($reports as $r) {

            /* Original price less discount */
            
            $r->amount = $r->amount - $r->discount;

            /* Service charge against total */
            $scharge = $r->amount * (($r->value)/100);

            /*Service Tax*/
            $sst=0;
            if ($r->mode=="exclusive") {
                $sst=$r->amount * (($r->service_tax)/100);
            }
            /* Final total includes service charge */
            $r->amount = $r->amount + floor($scharge)+floor($sst)+$r->round; 

            if($r->status=="completed"){
                if ($r->cash_received>=$r->amount) {
                    # code...
                    $cash+=$r->amount;
                }else{
                    if ($r->cash_received<$r->amount) {
                        # code...
                        $cash+=$r->cash_received;
                        if ($r->payment_type=="creditcard") {
                            # code...
                            /*dump($r->amount);
                            dump($r->otherpoints);
                            dump($r->cash_received);*/
                            $creditcard+=($r->amount-($r->otherpoints*100)-$r->cash_received);
                        }
                        
                        
                    }
                }

                $otherpoints+=$r->otherpoints;
            }
        }

         foreach ($monthlyAmount as $r) {
            /* Original price less discount */
        
            if ($r->mode=="inclusive") {
                $r->amount = $r->amount - $r->discount;
                /*$s=floatval($r->amount) * (($r->service_tax)/100.0);*/

                /*$r->amount=$r->amount/(1+($r->service_tax/100));*/

            }else{
                $r->amount = $r->amount - $r->discount;
            }
            /* Service charge against total */
            /*$scharge = $r->amount * (($r->value)/100);*/

            /* Final total includes service charge */
            /*$r->amount = $r->amount + $scharge; */
        }
        foreach ($todayAmount as $r) {
            /* Original price less discount */

            if ($r->mode=="inclusive") {
                $r->amount = $r->amount - $r->discount;
                /*$r->amount=$r->amount/(1+($r->service_tax/100));*/
            }else{
                $r->amount = $r->amount - $r->discount;
            }

            /* Service charge against total */
            /*$scharge = $r->amount * (($r->value)/100);*/

            /* Final total includes service charge */
            /*$r->amount = $r->amount + $scharge; */
        }

        $s= $merchant_address;
        $name = !empty($merchant->company_name)?$merchant->company_name:"";    
        $monthNum=Carbon::now()->month;
        $monthName = $month; // March        
        $year=Carbon::now()->year;

        return view('opposum.trunk.oposumreceiptlist')
        ->with('reports',           $reports)
        ->with('location',          $location)
        ->with('monthlyAmount',     $monthlyAmount)
        ->with('cash',              $cash)
        ->with('creditcard',        $creditcard)
        ->with('otherpoints',       $otherpoints)
        ->with('todayAmount',       $todayAmount)
        ->with('terminalId',        $terminalId)
        ->with('selluser',          $selluser)
        ->with('merchant',          $merchant)
        ->with('currency',          $currency)
        ->with('merchant_address',  $merchant_address)
        ->with('name',              $name)
        ->with('s',                 $s)
        ->with('id',                $user_id)
        ->with('month',             $monthName)
        ->with('year',              $year)
        ->with('today',             $formdate);        
        // Route::get('/statement/showreceiptlist/{terminal_id}', 'OpossumController@showreceiptlist');

    }

    public function is_eod($terminal_id)
    {
		Log::debug('***** is_eod('.$terminal_id.') *****');

        $current_time=time();
        
        $terminal=DB::table('opos_terminal')->
        where('id',$terminal_id)->first();

        $start_time=$terminal->start_work;

        $Eodtimes = $this->eod_times($terminal_id);

		Log::debug('***** Eodtimes='.json_encode($Eodtimes).' *****');

		$todayStarttime = $start_time=date('Y-m-d H:i:s',
			$Eodtimes['starttimes']);

		$nextDayStartTime = date('Y-m-d H:i:s',
			strtotime('+24 hours',strtotime($todayStarttime)));  

		Log::debug('todayStarttime='.json_encode($todayStarttime));
		Log::debug('nextDayStartTime='.json_encode($nextDayStartTime));

        $end_time=date('Y-m-d H:i:s',$Eodtimes['endtimes']);

        $Eodtimes['endtimes'] =strtotime("+5 mins",$Eodtimes['endtimes'] );
		$last_eod = DB::table('opos_logterminal')->
			where('terminal_id',$terminal_id)->
			whereNull('deleted_at')->
			whereBetween('opos_logterminal.eod', array(
				date('Y-m-d H:i:s', $Eodtimes['starttimes']), 
				date('Y-m-d H:i:s', $Eodtimes['endtimes'])))->
			orderBy("id","DESC")->
			first();

		/* Figure out the location_id of this terminal */
		$location_id = DB::table('opos_locationterminal')->
 			where('terminal_id',$terminal_id)->
			whereNull('deleted_at')->
			pluck('location_id');

		Log::debug('***** location_id='.$location_id.' *****');

		/* See if this terminal is already in manual EOD mode */
		$manual_eod = DB::table('opos_eod')->
 			where('location_id',$location_id)->
			whereNull('deleted_at')->
			pluck('eod');

        //dump($last_eod);
        $last_eod_time=null;
        if (!empty($last_eod)) {
            $end_time=$last_eod->eod;
        }

		if($current_time >= strtotime($end_time)  &&
		   $current_time < strtotime($nextDayStartTime)) {
            $ret= "eod";

		} else {
			$ret= "ok";
		}

		Log::debug('***** ret='.$ret.' *****');
        return $ret;
    }

    public function operation_hours_variables(Request $request,$uid=NULL){
		Log::debug('***** operation_hours_variables() *****');
       
        $array=[];
        if (!Auth::check()) {
            return "Authentication Failure";
        }
        $user_id     = Auth::user()->id;

        if (Auth::user()->hasRole("adm") and !empty($uid)) {
            # code...
            $user_id=$uid;
        } 
        $terminal_id=$request->input("terminal_id");
        // /*Check if EOD*/
        $status=$this->is_eod($terminal_id);

        return response()->json(compact('status'));
    }
}
