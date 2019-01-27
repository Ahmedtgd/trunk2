<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Carbon;
use Log;
use Auth;
use App\Models\User;

class DocumentSalesReportController extends Controller
{
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function show_salesreport($location_id,$terminal_id,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";

		if (!Auth::check()) {
            return "Please login";
        }

        $user_id=Auth::user()->id;
        $selluser = User::find($user_id);

        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;

        } try{
            /*Get all terminals*/
           /* $terminals=$this->all_terminals($location_id);*/
          $records=$this->terminal_sale($terminal_id,$location_id);
          $terminal=DB::table("opos_terminal")->where("id",$terminal_id)->first();
         
            $location=DB::table('fairlocation')->where('id',$location_id)->pluck('location');

            return view('saleReports.sale_management',
				compact('records','location','terminal'))->
				with('selluser', $selluser);
        }
        catch(\Exception $e){
           dump($e);
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        
    }


    public function all_terminals($location_id)
    {
        # code...
        return DB::table("opos_locationterminal")
        ->where("location_id",$location_id)
        ->whereNull('deleted_at')
        ->select("terminal_id")
        ->get();
    }

    public function location_sale($location_id)
    {
        $query='

            SELECT
              SUM((opr.price*opr.quantity)) -((opr.discount*SUM((opr.price*opr.quantity)))/100)  as billable,
            
            op.service_tax,
            op.cash_received,
            op.otherpoints,
            op.creditcard_no,
            op.terminal_id,
            DAYOFMONTH(op.created_at) as day,
            MONTHNAME(op.created_at) as month,
            YEAR(op.created_at) as year

            
            FROM 
            opos_receipt op 
            JOIN opos_receiptproduct opr on opr.receipt_id=op.id
           
            JOIN opos_locationterminal ol on ol.terminal_id=op.terminal_id

            JOIN opos_terminal ot on ot.id=ol.terminal_id 

            WHERE 

            opr.deleted_at IS NULL
            AND op.deleted_at IS NULL
            AND ol.location_id='.$location_id.'
            AND op.status="completed"
            
            AND TIME(op.created_at) BETWEEN ot.start_work AND ot.end_work
            GROUP BY DAYOFMONTH(op.created_at)
            

        ';
        return DB::select(DB::raw($query));
    }
    public function terminal_sale($terminal_id,$location_id,$year=null,$month=null)
    {
      
           
           /*$data= DB::select(DB::raw('

                SELECT 
                opos_logterminal.id as log_id,
                opos_logterminal.eod,
                opos_logterminal.start_work,
                SUM((opr.price*opr.quantity)
                as amount,
                SUM((opos_receiptproduct.quantity*opos_receiptproduct.price*opos_receiptproduct.discount)/100) as discount,
                CASE
                    WHEN opos_receipt.mode=="exclusive" 
                    THEN
                    ELSE

                END
                op.service_tax,
                op.cash_received,
                op.otherpoints,
                op.creditcard_no,
                FROM 
                opos_logterminal
                LEFT JOIN opos_receipt op on op.terminal_id=opos_logterminal.terminal_id 
                JOIN opos_receiptproduct opr on opr.receipt_id=op.id
                WHERE opos_logterminal.terminal_id='.$terminal_id.'
                AND  ((op.created_at BETWEEN opos_logterminal.start_work AND opos_logterminal.eod) OR op.created_at=NULL)
                AND op.status="completed"
                GROUP BY log_id
            
              

            '));

*/   
            // $Eodtimes = app('App\Http\Controllers\OposEodController')->eod_times($terminal_id);

            $logs=DB::table("opos_logterminal")
            ->where("terminal_id",$terminal_id)
/*            ->whereRaw("YEAR(created_at) = ".$year)
            ->whereRaw("MONTH(created_at) = ".$month)*/
            // ->whereBetween('opos_logterminal.eod', array(date('Y-m-d H:i:s',$Eodtimes['starttimes']), date('Y-m-d H:i:s',$Eodtimes['endtimes'])))
            ->whereNull('deleted_at')
            ->get(); 
            // echo "<pre>"; print_r ($logs); echo "</pre>"; exit();
         /*   foreach ($logs as $log) {
                # code...
                $cash=0;
                $creditcard=0;
                $otherpoints=0;
                $receipts=$reports = DB::table("opos_receipt")
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
            'opos_receipt.terminal_id','opos_receipt.cash_received',
//                        SUM(opcp.quantity*(opcp.price+(opsc.value*opcp.price/100))) as amount,
            'fairlocation.location',
            DB::raw(
//              "SUM(opos_receiptproduct.quantity*(opos_receiptproduct.price+ (opos_servicecharge.value/100)*opos_receiptproduct.price) ) as amount"
           "SUM(opos_receiptproduct.quantity*(opos_receiptproduct.price)) as amount"
            ),
            "sc.value as servicecharge",
            "opos_receipt.service_tax",
            DB::raw(
                "SUM((opos_receiptproduct.quantity*opos_receiptproduct.price*opos_receiptproduct.discount)/100) as discount")
        )
                    ->where("opos_receipt.terminal_id",$terminal_id)
                    ->where("opos_receipt.status","completed")
                    ->whereNull("opos_receipt.deleted_at")
                    ->whereNull("opos_receiptproduct.deleted_at")
                    ->whereRaw("opos_receipt.created_at BETWEEN '".$log->start_work."' AND '".$log->eod."'")
                    ->get()
                    ;

                foreach ($receipts as $r) {
               
                
                    $r->amount = $r->amount - $r->discount;

        
                    $scharge = $r->amount * (($r->value)/100);

                    $sst=0;
                    if ($r->mode=="exclusive") {
                        $sst=$r->amount * (($r->service_tax)/100);
                    }
                    $r->amount = $r->amount + $scharge+$sst; 
             
                    if($r->status=="completed"){
                        if ($r->cash_received>=$r->amount) {
                        # code...
                            $cash+=$r->amount;
                        }else{
                            if ($r->cash_received<$r->amount) {
                            # code...
                                $cash+=$r->cash_received;
                                if ($r->payment_type=="creditcard") {
                               
                                    $creditcard+=($r->amount-($r->otherpoints*100)-$r->cash_received);
                                }
                            
                            
                            }
                        }

                        $otherpoints+=$r->otherpoints;
                    }
                }
                $log->cash=$cash;
                $log->creditcard=$creditcard;
                $log->otherpoints=$otherpoints;
        }*/
           return $logs;
      
    }

    
}
