<?php

namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Array_;
use Request;
use Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Station;
use App\Models\Address;
use App\Models\Buyer;
use App\Models\User;
use Carbon\Carbon;
use App\Models\POrder;
use App\Models\Receipt;
use App\Models\DeliveryOrder;
use App\Models\Delivery;
//use App\Models\OposReceipt;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use DB;
use Log;
use DateTime;
use PDF;
use App\Models\Stockreport;
use App\Models\Salesmemo;
use App\Models\CreditNote;
use App\Models\OrderProduct;
use App\Models\OposReceipt;
use App\Models\ReturnOfGood;


class StatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  $cStatus='"completed","reviewed","commented"';
    public function lsov($logistic_id){
      $logistic = DB::table('logistic')->where('id',$logistic_id)->first();
      $query = Delivery::leftJoin('orderreturn as op','op.porder_id','=','delivery.porder_id')

      ->where('delivery.logistic_id','=',$logistic_id)
      ->select('delivery.created_at')
      ->orderBy('delivery.created_at','desc')
      ->get();                
      $actual_year = Delivery::leftJoin('orderreturn as op','op.porder_id','=','delivery.porder_id')

      ->where('delivery.logistic_id','=',$logistic_id)
      ->select('delivery.created_at')
      ->orderBy('delivery.created_at','desc')

      ->first();

      $years = Array();$months = Array();$y = Array();$index = 0;
      foreach($query as $que){
        $years[$que->created_at->year][$index] = $que->created_at->month;
        $index++;
    }
    $today = Carbon::today();

    $company = Station::where('id' , $logistic->station_id)
    ->first();

    $s = Address::where('id' , $company->address_id)
    ->first(array('line1','line2','line3','line4'));
    $mer = "Logistic ID";
    $id = IdController::nS($company->id);
    $arr=array('myreturn' => $query, 'today' => $today, 'years'=>$years, 'actual_year'=>$actual_year);
        // return $arr;
    $today = $arr['today'];
    $myreturn = $arr['myreturn'];
    $years = $arr['years'];
    $actual_year = $arr['actual_year'];
    $current_year = 0;
    if(isset($actual_year)){
        $actual_year = $actual_year->created_at;
        if($actual_year->year != $today->year){
            $current_year = 0;
        }else{
            $current_year = 1;
        }
    }		
    return view('statement.logisticdetaill',compact('today','myreturn','current_year'))
    ->with('mer',$mer)->with('id',$id)->with('company',$company)->with('logistic_id',$logistic_id)->with('s' , $s)->with('years',$years)->with('title','Statement')->with('detail','detail');
}

public function sov($custom_id = null){
  if(Auth::check()){
     if(isset($custom_id))
        $id = $custom_id;
    else
        $id =  \Auth::user()->id;
} else {
 return Redirect::back();
}


$stmt = "sov";
$arr = $this->get_all($id, $stmt);
$ireturn = $arr['ireturn'];
$today = $arr['today'];
$myreturn = $arr['myreturn'];
$mer = $arr['mer'];
$id = $arr['id'];
$company = $arr['company'];
$s = $arr['s'];
$years = $arr['years'];
$actual_year = $arr['actual_year'];
$current_year = 0;
if(isset($actual_year)){
    $actual_year = $actual_year->created_at;
    if($actual_year->year != $today->year){
        $current_year = 0;
    }else{
        $current_year = 1;
    }
}
return view('statement.merchantdetail',compact('ireturn','today','myreturn','current_year'))
->with('mer',$mer)->with('id',$id)->with('company',$company)->with('s' , $s)->with('years',$years)->with('title','Statement')->with('detail','detail');
}

public function showMerchantStatement($month,$year,$merchant_id="merchant",$type="st")
{
        // Test Code .
    $y2=intval($year);
    $m2=intval($month);
    if ($month==12) {
        $m2=01;
        $y2=$y2+1;
    }
    $rawMonth=$month;
    $firstcyle_sdate=$year."-".$month."-01";
    $firstcyle_edate=$year."-".$month."-16";
    $secondcyle_sdate=$year."-".$month."-16";
    $secondcyle_edate=$y2."-".($m2+1)."-01";
    if (!Auth::check()) {
        return view('common.generic')
        ->with('message_type','error')
        ->with('message','Please login to access.');
    }
    if (Auth::user()->hasRole('adm')) {

    }else{
            // Get merchant id
        try {
            $merchant_id=Merchant::where('user_id',Auth::user()->id)->pluck('id');
        } catch (\Exception $e) {
            dump($e);
            return view('common.generic')
            ->with('message_type',"error")
            ->with('message','You do not have permission to access this resource. #001')
            ;
        }
    }
    try{
        $extraData=[UtilityController::numberMonth($month),$year,$rawMonth];
        $firstcyle=$this->getMerchantStatement($merchant_id,$firstcyle_sdate,$firstcyle_edate);
        $firstcylepenalty=$this->getMerchantStatementPenalty($merchant_id,$firstcyle_sdate,$firstcyle_edate);

        $secondcycle=$this->getMerchantStatement($merchant_id,$secondcyle_sdate,$secondcyle_edate);
        $secondcyclepenalty=$this->getMerchantStatementPenalty($merchant_id,$secondcyle_sdate,$secondcyle_edate);

        $cycle=[$firstcyle,$secondcycle,$firstcylepenalty,$secondcyclepenalty,$extraData];

        return view('statement.merchant_statement',compact('cycle','merchant_id','type'));
    }catch(\Exception $e){
        dump($e);
        return view('common.generic')
        ->with('message_type',"error")
        ->with('message','You do not have permission to access this resource. #002')
        ;
    }
}

public function sendUpdateMerchantStatement($last_record)
{
}

public function pdfMerchantStatement($month,$year,$merchant_id="merchant",$type="st")
{
    $y2=intval($year);
    $m2=intval($month);
    if ($month==12) {
        $m2=01;
        $y2=$y2+1;
    }
    $rawMonth=$month;
    $firstcyle_sdate=$year."-".$month."-01";
    $firstcyle_edate=$year."-".$month."-16";
    $secondcyle_sdate=$year."-".$month."-16";
    $secondcyle_edate=$y2."-".($m2+1)."-01";
    if ($merchant_id!="merchant") {

    }else{
            // Get merchant id
        try {
            $merchant_id=Merchant::where('user_id',Auth::user()->id)->pluck('id');
        } catch (\Exception $e) {
           return $e;
       }
   }
   $merchant=Merchant::find($merchant_id);
   $merchant_address=Address::find($merchant->address_id);
   $extraData=[UtilityController::numberMonth($month),$year,$rawMonth,$merchant,$merchant_address];
   $firstcyle=$this->getMerchantStatement($merchant_id,$firstcyle_sdate,$firstcyle_edate);
   $firstcylepenalty=$this->getMerchantStatementPenalty($merchant_id,$firstcyle_sdate,$firstcyle_edate);

   $secondcycle=$this->getMerchantStatement($merchant_id,$secondcyle_sdate,$secondcyle_edate);
   $secondcyclepenalty=$this->getMerchantStatementPenalty($merchant_id,$secondcyle_sdate,$secondcyle_edate);

   $statement_file_name="statement/ops_statement_merchant_".$month."_".$year.".pdf";
   $cycle=[$firstcyle,$secondcycle,$firstcylepenalty,$secondcyclepenalty,$extraData];
        // Wrapper
   $pdf=PDF::loadView('statement.pdf.merch',['cycle'=>$cycle,'type'=>$type])->setOption('margin-bottom', 20)
   ->save(storage_path($statement_file_name));
}

public function downloadMSPDF($month,$year,$merchant_id,$type="st")
{
    $this->pdfMerchantStatement($month,$year,$merchant_id,$type);
    $headers = array(
      'Content-Type: application/pdf',
  );
    $file_path="statement/ops_statement_merchant_".$month."_".$year.".pdf";

    return response()->download(storage_path($file_path),"statement.pdf",$headers)->deleteFileAfterSend(true);
}

public function getMerchantStatementPenalty($merchant_id,$start_cycle,$end_cycle)
{
    $data=DB::table('adjustment')
    ->leftJoin('users','users.id','=','adjustment.admin_user_id')
    ->where('adjustment.merchant_id',$merchant_id)
    ->whereBetween('adjustment.created_at',[$start_cycle,$end_cycle])
    ->where('adjustment.price','>',0)
                // ->where('porder.id','!=',"NULL")
    ->select(DB::raw("
      adjustment.*,
      users.first_name,
      users.last_name

      "))
    ->get();

    return $data;


}	

public function getMerchantStatement($merchant_id,$start_cycle,$end_cycle)
{
    $data=POrder::join('orderproduct as op','op.porder_id','=','porder.id')

    ->join('merchantproduct as mp','mp.product_id','=','op.product_id')
    ->leftJoin('orderreturn as or','or.porder_id','=','porder.id')
    ->where('mp.merchant_id',$merchant_id)
    ->whereBetween('porder.created_at',[$start_cycle,$end_cycle])

                // ->where('porder.id','!=',"NULL")
    ->select(DB::raw("
        porder.id as oid,
        SUM(((op.osmall_comm_amount/100)*(op.order_price*op.quantity))/100) as osmall_commission,
        porder.updated_at as completed_at,
        SUM(op.order_price*op.quantity)+op.order_delivery_price as price,
        SUM(op.actual_delivery_price) as delivery,
        porder.order_administration_fee as oafee,
        SUM(op.payment_gateway_fee) as pgfee,

        CASE
        WHEN porder.id  in (select porder_id from porderpayment) THEN 'paid'
        ELSE 'unpaid' 
        END as status,
        CASE
        WHEN or.status = 'failed' THEN or.return_price
        ELSE 0
        END as rdelivery

        "))
    ->groupBy('porder.id')
    ->get();

    return $data;
}

public function rec($custom_id = null){

  if(Auth::check()){
     if(isset($custom_id))
        $id = $custom_id;
    else
        $id =  \Auth::user()->id;
} else {
 return Redirect::back();
}

$stmt = "rec";
$arr = $this->get_all($id, $stmt);
$ireturn = $arr['ireturn'];
$today = $arr['today'];
$myreturn = $arr['myreturn'];
$mer = $arr['mer'];
$id = $arr['id'];
$company = $arr['company'];
$s = $arr['s'];
$years = $arr['years'];
$actual_year = $arr['actual_year'];
$current_year = 0;
if(isset($actual_year)){
    $actual_year = $actual_year->created_at;
    if($actual_year->year != $today->year){
        $current_year = 0;
    }else{
        $current_year = 1;
    }
}
return view('statement.merchantdetail',compact('ireturn','today','myreturn','current_year'))
->with('mer',$mer)->with('id',$id)->with('company',$company)->with('s' , $s)->with('years',$years)->with('title','Receipt')->with('detail','recdetail');
}

public function dor($custom_id = null){
  if(Auth::check()){
     if(isset($custom_id))
        $id = $custom_id;
    else
        $id =  \Auth::user()->id;
} else {
 return Redirect::back();
}

$stmt = "dor";
$arr = $this->get_all($id, $stmt);
$ireturn = $arr['ireturn'];
$today = $arr['today'];
$myreturn = $arr['myreturn'];
$mer = $arr['mer'];
$id = $arr['id'];
$company = $arr['company'];
$s = $arr['s'];
$years = $arr['years'];
$actual_year = $arr['actual_year'];
$current_year = 0;
if(isset($actual_year)){
    $actual_year = $actual_year->created_at;
    if($actual_year->year != $today->year){
        $current_year = 0;
    }else{
        $current_year = 1;
    }
}
return view('statement.merchantdetail',compact('ireturn','today','myreturn','current_year'))
->with('mer',$mer)->with('id',$id)->with('company',$company)->with('s' , $s)->with('years',$years)->with('title','Delivery Order')->with('detail','dodetail');
}

public function get_all($id, $stmt){
  $merchant = Merchant::where('user_id',$id)
  ->first();
  $ireturn=array();
  $station = Station::where('user_id' , $id)
  ->first();
  
  if($stmt == "sov"){
     if(!is_null($merchant)){

         $query = POrder::join('orderproduct as op','op.porder_id','=','porder.id')
         ->join('product', 'op.product_id', '=', 'product.id')
         ->join('merchantproduct as mp','mp.product_id','=','product.parent_id')
         ->join('invoice','invoice.porder_id','=','porder.id')
         ->where('mp.merchant_id','=',$merchant->id)
         ->select('porder.user_id','porder.created_at')
         ->orderBy('porder.created_at','desc')
         ->get();

         $actual_year =  POrder::join('orderproduct as op','op.porder_id','=','porder.id')
         ->join('product', 'op.product_id', '=', 'product.id')
         ->join('merchantproduct as mp','mp.product_id','=','product.parent_id')
         ->join('invoice','invoice.porder_id','=','porder.id')
         ->where('mp.merchant_id','=',$merchant->id)
         ->select('porder.user_id','porder.created_at')
         ->orderBy('porder.created_at','desc')
         ->first();

     } else {
        $query = array();
        $actual_year = array();
    }
}
if($stmt == "rec"){
 $query = Receipt::join('porder', 'porder.id', '=', 'receipt.porder_id')
 ->where('user_id' , $id)
 ->select('porder.user_id','porder.created_at')
 ->orderBy('porder.created_at','desc')
 ->get();
 $actual_year = Receipt::join('porder', 'porder.id', '=', 'receipt.porder_id')
 ->where('user_id' , $id)
 ->select('porder.user_id','porder.created_at')
 ->orderBy('porder.created_at','desc')
 ->first();
}
if($stmt == "dor"){
 $query = DeliveryOrder::join('receipt', 'receipt.id', '=', 'deliveryorder.receipt_id')
 ->join('porder', 'porder.id', '=', 'receipt.porder_id')
 ->where('user_id' , $id)
 ->select('porder.user_id','porder.created_at')
 ->orderBy('porder.created_at','desc')
 ->get();
 $actual_year = DeliveryOrder::join('receipt', 'receipt.id', '=', 'deliveryorder.receipt_id')
 ->join('porder', 'porder.id', '=', 'receipt.porder_id')
 ->where('user_id' , $id)
 ->select('porder.user_id','porder.created_at')
 ->orderBy('porder.created_at','desc')
 ->first();
}

if($stmt == "opossum"){
	$query=OposReceipt::join("opos_receiptproduct","opos_receiptproduct.receipt_id","=","opos_receipt.id")
    ->join('opos_locationterminal','opos_locationterminal.terminal_id','=','opos_receipt.terminal_id')
    ->join('fairlocation','fairlocation.id','=','opos_locationterminal.location_id')
    ->where("opos_receipt.status","completed")
    ->where("fairlocation.user_id",$id)
	->orderBy('opos_receipt.created_at','desc')
    ->select("opos_receipt.*")
    ->get();

    $actual_year=NULL;
    if (!empty($query) and sizeof($query)>0) {
        $actual_year=$query[0];
	}
}

if($stmt == "tr"){

 $query1 = Stockreport::
 join('stockreportproduct','stockreportproduct.stockreport_id','=','stockreport.id')
 ->join("company as c1","c1.id","=","stockreport.creator_company_id")
 ->where('stockreport.status' , 'confirmed')
 ->where('c1.owner_user_id' , $id)

 ->select('stockreport.creator_user_id','stockreport.created_at')
 ;
 $query2 = Stockreport::
 join('stockreportproduct','stockreportproduct.stockreport_id','=','stockreport.id')
 ->join("company as c1","c1.id","=","stockreport.checker_company_id")
 ->where('stockreport.status' , 'confirmed')
 ->where('stockreport.ttype','treport')
 ->where('c1.owner_user_id' , $id)

 ->select('stockreport.checker_user_id','stockreport.created_at')
 ;

 $query=$query1->union($query2)->orderBy('created_at','desc')->get();
			//dump($query);
			/*$actual_year = Stockreport::
				join('stockreportproduct','stockreportproduct.stockreport_id','=','stockreport.id')
                ->join("company as c1","c1.id","=","stockreport.creator_company_id")
				->where('stockreport.status' , 'confirmed')
                ->where('c1.owner_user_id' , $id)
				->select('stockreport.creator_user_id','stockreport.created_at')
				->orderBy('stockreport.created_at','desc')
				->first();*/
                $actual_year=NULL;
                if (!empty($query) and sizeof($query)>0) {
                    # code...

                    $actual_year=$query[0];
                }
                

            }

        if($stmt == "sm"){
             $query = Salesmemo::join('salesmemoproduct as op','op.salesmemo_id','=','salesmemo.id')
             ->join('fairlocation','fairlocation.id','=','salesmemo.fairlocation_id')

             ->join('merchant','merchant.user_id','=','fairlocation.user_id')
             ->where('merchant.user_id' , $id)
             ->groupBy("salesmemo.created_at")
             ->select('salesmemo.creator_user_id','salesmemo.created_at')
             ->orderBy('salesmemo.created_at','desc')
             ->get();    
				// dump($query);
             $actual_year =  Salesmemo::join('salesmemoproduct as op','op.salesmemo_id','=','salesmemo.id')
             ->join('fairlocation','fairlocation.id','=','salesmemo.fairlocation_id')
             ->join('merchantproduct','op.product_id','=','merchantproduct.product_id')
             ->join('merchant','merchant.id','=','merchantproduct.merchant_id')
             ->where('merchant.user_id' , $id)
             ->select('salesmemo.creator_user_id','salesmemo.created_at')
             ->orderBy('salesmemo.created_at','desc')
             ->first();
			//dump($actual_year);
         }

         $years = Array();$months = Array();$y = Array();$index = 0;
         foreach($query as $que){
            try {
                $years[$que->created_at->year][$index] = $que->created_at->month;
            } catch (\Exception $e) {

            }

            $index++;
        }
        // dump($years);
        $today = Carbon::today();
        if(isset($merchant)){
         $merchant_address = Address::where( 'id',$merchant->address_id)
         ->first(array('line1','line2','line3','line4'));
         $mer = "Merchant ID";
         $id = IdController::nSeller($merchant->user_id);
         $s = $merchant_address;
         $name = $merchant->oshop_name;
         $company = $merchant->company_name;
         $ireturn = 	$merchant;
         return (array('ireturn'=>$ireturn, 'myreturn' => $query, 'today' => $today, 'mer' => $mer, 'id' => $id, 'name' => $name, 'company'=>$company, 's'=>$s, 'years'=>$years, 'actual_year'=>$actual_year));

     } else {
         if(isset ($station)){
            $station_address = Address::where('id' , $station->address_id)
            ->first(array('line1','line2','line3','line4'));
            $mer = "Station ID";
            $id = IdController::nSeller($station->user_id);
            $s = $station_address;
            $name = $station->company_name;
            $company = $station->station_name;
            $ireturn = 	$station;
            return (array('ireturn'=>$ireturn, 'myreturn' => $query, 'today' => $today, 'mer' => $mer, 'id' => $id, 'name' => $name, 'company'=>$company, 's'=>$s, 'years'=>$years, 'actual_year'=>$actual_year));
        }
    }

}

public function merchantdetailgst()
{
    $recs = null;
    $from = Carbon::today();
    $from->day = 1;
    $from->month = Request::input('month');
    $from->year = Request::input('year');
    $mid = Request::input('mid');
    $to = Carbon::create($from->year,$from->month,$from->day);
    $to = $to->endOfMonth();
    $merchant = DB::table('merchant')->where('id',$mid)->first();
    $currency = \DB::table('currency')
                  ->where('currency.active' ,'=',1)
                  ->select('currency.code')
                  ->get();

    foreach ($currency as $value) {
        $currency = $value;
    }		
    if(!is_null($merchant))
    {
        $recs = DB::table("opos_receipt")
                  ->join("opos_receiptproduct","opos_receiptproduct.receipt_id","=","opos_receipt.id")
                  ->select('opos_receipt.id','opos_receipt.mode','opos_receipt.staff_user_id','opos_receipt.created_at','opos_receipt.receipt_no','opos_receipt.status','opos_receipt.terminal_id','opos_receipt.cash_received',DB::raw("SUM((opos_receiptproduct.quantity*opos_receiptproduct.price)-opos_receiptproduct.discount) as sales"))
                  ->whereRaw('opos_receipt.status IN ("completed","voided")')
                  ->whereNull("opos_receipt.deleted_at")
                  ->whereNull("opos_receiptproduct.deleted_at")
                  ->whereRaw('opos_receipt.staff_user_id IN (select `member`.`user_id` from member INNER JOIN `company` ON `member`.`company_id` = `company`.`id` AND `company`.`owner_user_id` = '.Auth::user()->id.' )')
                  ->where('opos_receipt.created_at','like',$from->format('Y-m').'%')
                  ->groupBy("opos_receipt.id")
                  ->orderBy("opos_receipt.id", "desc")
                  ->orderBy("opos_receipt.created_at","DESC")
                  ->get();
                  
        $glob=DB::table('global')->first()->gst_rate;

        foreach($recs as $rec)
        {
            $sales = $rec->sales;

            if($glob == 0){ 
                $SST = $glob;
            }
            else{ 
                $SST = $glob/100;
            }

            if($rec->mode == 'inclusive')
            {
                $total_items = $sales/(1 + $SST);
            }
            if($rec->mode == 'exclusive')
            {
                $total_items = $sales*(1 + $SST);
            }

            $sst = $sales * $SST;

            $rec->sst = $sst;
            $rec->total_items = $total_items;
        }
    }

    $monthNum=Request::input('month');
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F'); // March		
    $year=Request::input('year');	
    $column_defualt =DB::select(Db::raw(
            "select column_default from information_schema.COLUMNS where table_schema='osmall' and table_name='opos_receipt' and column_name='mode'"));
    if(count($column_defualt) > 0){
        $mode = $column_defualt[0]->column_default; 
    }
    else
    {
        $mode = '';
    }
    
    return view('statement.merchantdetailgst')
            ->with('recs' ,$recs)
            ->with('currency' , $currency)
            ->with('month',$monthName)
            ->with('year',$year)
            ->with('mode',$mode);			
}
    public function merchantdetailrc()
    {
    	$from = Carbon::today();
    	$from->day = 1;
    	$from->month = Request::input('month');
    	$from->year = Request::input('year');
    	$mid = Request::input('mid');
    	$to = Carbon::create($from->year,$from->month,$from->day);
        $to = $to->endOfMonth();
        $id = Auth::user()->id;
        $merchant = DB::table('merchant')->where('id',$mid)
        ->first();
        $merchant_address = Address::where('id',$merchant->address_id)
        ->first(array('line1','line2','line3','line4'));
        $currency = \DB::table('currency')
        ->where('currency.active' ,'=',1)
        ->select('currency.code')
        ->get();
        foreach ($currency as $value) {
            $currency = $value;
        }
        $porders = DB::table('porder')->join('orderproduct as op','op.porder_id','=','porder.id')->join('merchantproduct as mp','op.product_id','=','mp.product_id')
        ->where('mp.merchant_id','=',$merchant->id)
        ->select('porder.*')
        ->whereBetween('porder.created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])->orderBy('porder.created_at','DESC')->get();

        $orders = array();
        foreach ($porders as $po) {
            # code...
         $roder = [];
         $roder['oid'] = $po->id;
         $total= DB::table('orderproduct')->where('porder_id',$po->id)->select(DB::raw("SUM(order_price * quantity) as total"))->first();
         $rtotal = 0;
         if(!is_null($total)){
            $rtotal = $total->total;
        }
        $roder['total'] = $rtotal;
        $roder['o_exec'] = $po->created_at;            
        array_push($orders, $roder);
    }		

    $roles = \DB::table('role_users')
    ->join('roles' , 'roles.id' ,'=' , 'role_users.role_id')
    ->where('role_users.user_id','=',$id)
    ->select('slug' , 'role_users.user_id')
    ->get();
    $i = 0;$r = array();
//	dd($orders);		
    if(isset($roles)){
        foreach($roles as $role){
            $r[$i] =  $role->slug;
            $i++;
        }
    } $i = 1;
    $user_role = "";

    if(in_array("mct",$r) || isset($merchant)){
        $user_role = "mct";
    }
    else if(in_array("sto" , $r) || isset ($station)){
        $user_role = "sto";
    } else if(in_array("byr" , $r)){
        $user_role = "byr";
    }
    $s= $merchant_address;
    $name = $merchant->company_name;	
    $monthNum=Request::input('month');
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March		
        $year=Request::input('year');
        return view('statement.merchantdetailrc')
        ->with('product_orders' ,$orders)
        ->with('merchant' , $merchant)
        ->with('currency' , $currency)
        ->with('merchant_address' , $merchant_address)
        ->with('name' ,$name)
        ->with('s' , $s)
        ->with('id' , $id)
        ->with('month',$monthName)
        ->with('year',$year);		
    }

    public function buyerdetail()
    {
    	$from = Carbon::today();
    	$from->day = 1;
    	$from->month = Request::input('month');
    	$from->year = Request::input('year');
    	$to = Carbon::create($from->year,$from->month,$from->day);
        $to = $to->endOfMonth();
        $id = Auth::user()->id;
        $buyer = User::where('id',$id)
        ->first();
        $buyer_address = Address::where( 'id',$buyer->default_address_id)
        ->first(array('line1','line2','line3','line4'));
        $currency = \DB::table('currency')
        ->where('currency.active' ,'=',1)
        ->select('currency.code')
        ->get();
        foreach ($currency as $value) {
            $currency = $value;
        }
        $porders = DB::table('porder')->whereBetween('porder.created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])->where('user_id', $id)->orderBy('porder.created_at','DESC')->get();

        $b= new BuyerController();
        $product_orders= $b->products($porders);
        $orders = array();
        foreach ($product_orders as $po) {
            # code...
            $ex=DB::table('porder')->where('id',$po['oid'])->first();
            $total= DB::table('payment')->where('id',$ex->payment_id)->pluck('receivable');
         //   $po['total']=$total;
            $po['status']=$ex->status;
            $po['o_receipt']=$ex->receipt_tstamp;
            $date = $ex->created_at;
            $date1 = new DateTime(date('Y-m-d H:i:s'));
            $date2 = new DateTime(date('Y-m-d H:i:s', strtotime($date)));
            $diff = $date1->diff($date2);
            $hours = $diff->h;
            $days = $diff->days;
            $totaldiff = ($diff->days * 24) + $diff->h + ($diff->i / 60) + ($diff->s / 3600);
            $po['hours']=$hours;
            $po['days']=$days;
            $po['totaldiff']=$totaldiff;
            array_push($orders, $po);
        }		

        $roles = \DB::table('role_users')
        ->join('roles' , 'roles.id' ,'=' , 'role_users.role_id')
        ->where('role_users.user_id','=',$id)
        ->select('slug' , 'role_users.user_id')
        ->get();
        $i = 0;$r = array();
	//dd($sorders);		
        if(isset($roles)){
            foreach($roles as $role){
                $r[$i] =  $role->slug;
                $i++;
            }
        } $i = 1;
        $user_role = "";

        if(in_array("mct",$r) || isset($merchant)){
            $user_role = "mct";
        }
        else if(in_array("sto" , $r) || isset ($station)){
            $user_role = "sto";
        } else if(in_array("byr" , $r)){
            $user_role = "byr";
        }
        $mer = "Buyer ID";
        $id = $buyer->id;
        $s= $buyer_address;
        $name = $buyer->name;	
        $monthNum=Request::input('month');
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March		
        $year=Request::input('year');
        return view('statement.buyerdetail')
        ->with('product_orders' ,$orders)
        ->with('buyer' , $buyer)
        ->with('currency' , $currency)
        ->with('buyer_address' , $buyer_address)
        ->with('name' ,$name)
        ->with('s' , $s)
        ->with('id' , $id)
        ->with('mer' , $mer)
        ->with('user_role' , $user_role)
        ->with('month',$monthName)
        ->with('year',$year);
    }

    public function salesmemodetailweb($user_id)
    {
    	$from = Carbon::today();
    	$from->day = 1;
    	$from->month = Request::input('month');
    	$from->year = Request::input('year');
    	$to = Carbon::create($from->year,$from->month,$from->day);
        $to = $to->endOfMonth();
        $id = $user_id;
        $buyer = User::where('id',$id)
        ->first();
        $buyer_address = Address::where( 'id',$buyer->default_address_id)
        ->first(array('line1','line2','line3','line4'));
        $currency = \DB::table('currency')
        ->where('currency.active' ,'=',1)
        ->select('currency.code')
        ->get();
        foreach ($currency as $value) {
            $currency = $value;
        }
        $salesmemo = DB::table('salesmemo')->join('salesmemoproduct','salesmemoproduct.salesmemo_id','=','salesmemo.id')->whereBetween('salesmemo.created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])->where('creator_user_id', $id)->select('salesmemo.*')->distinct()->orderBy('salesmemo.created_at','DESC')->get();
        foreach($salesmemo as $sm){
         $products = DB::table('salesmemoproduct')->where('salesmemo_id',$sm->id)->get();
         $total= 0;
         foreach($products as $pp){
            $tt = $pp->price * $pp->quantity;
            $total += $tt;
        }
        $sm->total = $total;
    }
    $id = $buyer->id;
    $s= $buyer_address;
    $name = $buyer->name;	
    $monthNum=Request::input('month');
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March		
        $year=Request::input('year');
        return view('statement.salesmemodetailweb')
        ->with('product_orders' ,$salesmemo)
        ->with('buyer' , $buyer)
        ->with('currency' , $currency)
        ->with('buyer_address' , $buyer_address)
        ->with('name' ,$name)
        ->with('s' , $s)
        ->with('id' , $id)
        ->with('month',$monthName)
        ->with('year',$year);
    }		

    public function salesmemodetail($user_id)
    {
    	$from = Carbon::today();
    	$from->day = 1;
    	$from->month = Request::input('month');
    	$from->year = Request::input('year');
    	$to = Carbon::create($from->year,$from->month,$from->day);
        $to = $to->endOfMonth();
        $id = $user_id;
        $buyer = User::where('id',$id)
        ->first();
        $buyer_address = Address::where( 'id',$buyer->default_address_id)
        ->first(array('line1','line2','line3','line4'));
        $currency = \DB::table('currency')
        ->where('currency.active' ,'=',1)
        ->select('currency.code')
        ->get();
        foreach ($currency as $value) {
            $currency = $value;
        }
        $salesmemo = DB::table('salesmemo')->join('salesmemoproduct','salesmemoproduct.salesmemo_id','=','salesmemo.id')->whereBetween('salesmemo.created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])->where('user_id', $id)->select('salesmemo.*')->distinct()->orderBy('salesmemo.created_at','DESC')->get();
        foreach($salesmemo as $sm){
         $products = DB::table('salesmemoproduct')->where('salesmemo_id',$sm->id)->get();
         $total= 0;
         foreach($products as $pp){
            $tt = $pp->order_price * $pp->quantity;
            $total += $tt;
        }
        $sm->total = $total;
    }
    $id = $buyer->id;
    $s= $buyer_address;
    $name = $buyer->name;	
    $monthNum=Request::input('month');
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March		
        $year=Request::input('year');
        return view('statement.salesmemodetail')
        ->with('product_orders' ,$salesmemo)
        ->with('buyer' , $buyer)
        ->with('currency' , $currency)
        ->with('buyer_address' , $buyer_address)
        ->with('name' ,$name)
        ->with('s' , $s)
        ->with('id' , $id)
        ->with('month',$monthName)
        ->with('year',$year);
    }	

    public function detail()
    {
    	$from = Carbon::today();
    	$from->day = 1;
    	$from->month = Request::input('month');
    	$from->year = Request::input('year');
    	$to = Carbon::create($from->year,$from->month,$from->day);
        $to = $to->endOfMonth();
        $id = Request::input('id');
        $merchant = Merchant::where('user_id',$id)
        ->first();
        if(isset($merchant)){
            $merchant_address = Address::where( 'id',$merchant->address_id)
            ->first(array('line1','line2','line3','line4'));
        }  else {
            $merchant_address = null;
        }
        $station = Station::where('user_id' , $id)
        ->first();
        if(isset($station)){
            $station_address = Address::where('id' , $station->address_id)
            ->first(array('line1','line2','line3','line4'));
        }else{
            $station_address = null;
        }
        $currency = \DB::table('currency')
        ->where('currency.active' ,'=',1)
        ->select('currency.code')
        ->get();
        foreach ($currency as $value) {
            $currency = $value;
        }
    //    $o = POrder::where('user_id' , $id)->select('id')->get();

        $sorders = \DB::table('porder')
        ->join('station' , 'station.user_id' , '=' , 'porder.user_id')
        ->join('sorder', 'sorder.porder_id','=','porder.id')
        ->join('orderproduct' , 'orderproduct.porder_id' , '=' , 'sorder.porder_id')
        ->join('product' , 'product.id' , '=' , 'orderproduct.product_id')
        ->join('merchantproduct' , 'orderproduct.product_id' , '=' , 'merchantproduct.product_id')
        ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
        ->whereBetween('porder.created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])
        ->where('porder.user_id',$id)
        ->select(
            'porder.id',
            'sorder.created_at',
            'product.name AS description',
            'sorder.id AS transaction_id',
            'merchant.id AS merchant_id',
            'product.id AS product_id',
            'orderproduct.order_price',
            'orderproduct.quantity'
        )
        ->get();
        $porders = \DB::table('porder')
        ->join('orderproduct', 'orderproduct.porder_id','=','porder.id')
        ->join('product' ,'product.id','=','orderproduct.product_id')
        ->join('merchant' , 'merchant.user_id' , '=' , 'porder.user_id')
        ->whereBetween('porder.created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])
        ->where('porder.user_id',$id)
        ->select(
            'porder.created_at',
            'porder.station_id',
            'product.name AS description',
            'porder.id AS transaction_id',
            'merchant.id AS merchant_id',
            'product_id',
            'porder.user_id AS buyer_id',
            'orderproduct.order_price',
            'orderproduct.quantity'
        )
        ->get();

        $roles = \DB::table('role_users')
        ->join('roles' , 'roles.id' ,'=' , 'role_users.role_id')
        ->join('merchant' , 'merchant.user_id' , '=', 'role_users.user_id')
        ->where('role_users.user_id','=',$id)
        ->where('merchant.user_id' , '=' , $id)
        ->select('slug' , 'role_users.user_id')
        ->get();
        $i = 0;$r = array();
        if(isset($roles)){
            foreach($roles as $role){
                $r[$i] =  $role->slug;
                $i++;
            }
        } $i = 1;
        if(in_array("mct",$r) || isset($merchant)){
            $user_role = "mct";
            $mer = "Merchant ID";
            $id = $merchant->user_id;
            $s= $merchant_address;
            $name = $name = $merchant->oshop_name;
        }
        else if(in_array("sto" , $r) || isset ($station)){
            $user_role = "sto";
            $mer = "Station ID";
            $id = $station->user_id;
            $s = $station_address;
            $name = $station->station_name;
        } else if(in_array("byr" , $r)){
            $user_role = "byr";
            $mer = "Merchant ID";
            $id = $merchant->user_id;
            $s= $merchant_address;
            $name = $name = $merchant->oshop_name;
        }
        return view('statement.buyerdetail')
        ->with('porders' ,$porders)
        ->with('sorders' , $sorders)
        ->with('station' , $station)
        ->with('merchant' , $merchant)
        ->with('currency' , $currency)
        ->with('merchant_address' , $merchant_address)
        ->with('station_address' , $station_address)
        ->with('name' ,$name)
        ->with('s' , $s)
        ->with('id' , $id)
        ->with('mer' , $mer)
        ->with('user_role' , $user_role);
    }

    public function recdetail()
    {
    	$from = Carbon::today();
    	$from->day = 1;
    	$from->month = Request::input('month');
    	$from->year = Request::input('year');
    	$to = Carbon::create($from->year,$from->month,$from->day);
        $to = $to->endOfMonth();
        $id = Request::input('id');
        $merchant = Merchant::where('user_id',$id)
        ->first();
        if(isset($merchant)){
            $merchant_address = Address::where( 'id',$merchant->address_id)
            ->first(array('line1','line2','line3','line4'));
        }  else {
            $merchant_address = null;
        }
        $station = Station::where('user_id' , $id)
        ->first();
        if(isset($station)){
            $station_address = Address::where('id' , $station->address_id)
            ->first(array('line1','line2','line3','line4'));
        }else{
            $station_address = null;
        }
        $currency = \DB::table('currency')
        ->where('currency.active' ,'=',1)
        ->select('currency.code')
        ->get();
        foreach ($currency as $value) {
            $currency = $value;
        }
        $roles = \DB::table('role_users')
        ->join('roles' , 'roles.id' ,'=' , 'role_users.role_id')
        ->join('merchant' , 'merchant.user_id' , '=', 'role_users.user_id')
        ->where('role_users.user_id','=',$id)
        ->where('merchant.user_id' , '=' , $id)
        ->select('slug' , 'role_users.user_id')
        ->get();
        $o = POrder::where('user_id' , $id)->select('id')->get();

        $sorders = \DB::table('receipt')
        ->join('porder' , 'receipt.porder_id' , '=' , 'porder.id')
        ->join('station' , 'station.user_id' , '=' , 'porder.user_id')
        ->join('sorder', 'sorder.porder_id','=','porder.id')
        ->join('orderproduct' , 'orderproduct.porder_id' , '=' , 'sorder.porder_id')
        ->join('product' , 'product.id' , '=' , 'orderproduct.product_id')
        ->join('merchantproduct' , 'orderproduct.product_id' , '=' , 'merchantproduct.product_id')
        ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
        ->whereBetween('porder.created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])
        ->where('porder.user_id',$id)
        ->select(
            'receipt.id as recid',
            'porder.id as porderid',
            'porder.receipt_tstamp as receipt_tstamp',
            'porder.delivery_tstamp as delivery_tstamp',
            'sorder.created_at',
            'product.name AS description',
            'sorder.id AS transaction_id',
            'merchant.id AS merchant_id',
            'product.id AS product_id',
            'orderproduct.order_price',
            'porder.user_id AS seller_id',
            'orderproduct.quantity'
        )
        ->get();
        $porders = \DB::table('receipt')
        ->join('porder' , 'receipt.porder_id' , '=' , 'porder.id')
        ->join('orderproduct', 'orderproduct.porder_id','=','porder.id')
        ->join('product' ,'product.id','=','orderproduct.product_id')
        ->join('merchant' , 'merchant.user_id' , '=' , 'porder.user_id')
        ->whereBetween('porder.created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])
        ->where('porder.user_id',$id)
        ->select(
         'receipt.id as recid',
         'porder.id as porderid',
         'porder.receipt_tstamp as receipt_tstamp',
         'porder.delivery_tstamp as delivery_tstamp',
         'porder.created_at',
         'porder.station_id',
         'product.name AS description',
         'merchant.id AS merchant_id',
         'product_id',
         'porder.user_id AS buyer_id',
         'orderproduct.order_price',
         'orderproduct.quantity'
     )
        ->get();
        $i = 0;$r = array();
        if(isset($roles)){
            foreach($roles as $role){
                $r[$i] =  $role->slug;
                $i++;
            }
        } $i = 1;
        if(in_array("mct",$r) || isset($merchant)){
            $user_role = "mct";
            $mer = "Merchant ID";
            $id = $merchant->id;
            $s= $merchant_address;
            $name = $name = $merchant->oshop_name;
        }
        else if(in_array("sto" , $r) || isset ($station)){
            $user_role = "sto";
            $mer = "Station ID";
            $id = $station->id;
            $s = $station_address;
            $name = $station->station_name;
        }
        return view('statement.recdetail')
        ->with('porders' ,$porders)
        ->with('sorders' , $sorders)
        ->with('roles' , $roles)
        ->with('station' , $station)
        ->with('merchant' , $merchant)
        ->with('currency' , $currency)
        ->with('merchant_address' , $merchant_address)
        ->with('station_address' , $station_address)
        ->with('name' ,$name)
        ->with('s' , $s)
        ->with('id' , $id)
        ->with('mer' , $mer)
        ->with('user_role' , $user_role);
    }

    public function stationdetailinvoicedetail()
    {
    	// $from = Carbon::today();
    	// $from->day = 1;
    	// $from->month = Request::input('month');
    	// $from->year = Request::input('year');
    	// $to = Carbon::create($from->year,$from->month,$from->day);
     //    $to = $to->endOfMonth();
        $month=(int)Request::input('month');
        $emonth=(string)$month+1;
        $smonth=(string)$month;
        // $year=Request::input('year');
        $Currentyear=Request::input('year');
        $nextyear=Request::input('year');
        if($emonth == 13){
          $emonth = 01;
          $nextyear++;
        }
        $id = Request::input('user_id');
        // $fromDate=$year."-".$smonth.'-01';
        // $toDate=$year."-".$emonth."-01";
        $fromDate=$Currentyear."-".$smonth.'-01';
        $toDate=$nextyear."-".$emonth."-01";
        $station = Station::where('user_id',$id)
        ->first();
        $currency = \DB::table('currency')
        ->where('currency.active' ,'=',1)
        ->select('currency.code')
        ->get();
        foreach ($currency as $value) {
            $currency = $value;
        }
            // dump($fromDate);
            // dump($toDate);
     //    $porders = \DB::table('deliveryinvoice')
     //    ->join('invoice' , 'deliveryinvoice.invoice_id' , '=' , 'invoice.id')
     //    ->join('porder' , 'invoice.porder_id' , '=' , 'porder.id')
     //    ->join('ordertproduct', 'ordertproduct.porder_id','=','porder.id')
     //    ->join('tproduct' ,'tproduct.id','=','ordertproduct.tproduct_id')
     //    ->join('merchanttproduct' ,'merchanttproduct.tproduct_id','=','ordertproduct.tproduct_id')
     //    ->whereBetween('porder.created_at',[$fromDate,$toDate])
     //                // ->whereRaw("porder.created_at BETWEEN '2017-05-1' AND '2017-06-1'")
     //    ->where('porder.user_id',$id)
     //    ->distinct()
     //    ->select(
     //     'invoice.id as invid',
     //     'porder.id as porderid',
     //     'porder.receipt_tstamp as receipt_tstamp',
     //     'porder.delivery_tstamp as delivery_tstamp',
     //     'porder.created_at',
     //     'merchanttproduct.merchant_id AS seller_id'
     // )
     //    ->orderBy('porder.created_at','DESC')
     //    ->get();
        $merchant_id = Merchant::where('user_id',$id)->first();
        $porders = \DB::table('porder')
                    ->join('orderproduct', 'orderproduct.porder_id', '=', 'porder.id')
                    ->join('product', 'orderproduct.product_id','=','product.id')

                    ->join('merchantproduct' ,'merchantproduct.product_id','=','product.parent_id')
                     // ->join('merchantproduct' ,'merchantproduct.product_id','=','orderproduct.product_id')
                    ->join('invoice','invoice.porder_id','=','porder.id')
                    // ->whereBetween('porder.created_at',[$fromDate,$toDate])
                    ->where('porder.user_id' , $id)
                    ->whereNull('porder.is_emerchant')
                    ->select(
                        // 'porder.user_id AS seller_id',
                        'porder.created_at',
                        'porder.status',
                        'porder.id as porderid',
                        'porder.receipt_tstamp as receipt_tstamp',
                        'porder.delivery_tstamp as delivery_tstamp',
                        'porder.created_at',
                        'invoice.invoice_no',
                        'merchantproduct.merchant_id AS seller_id',
                        // 'orderproduct.order_price',
                        DB::raw("SUM(orderproduct.order_price *  case when orderproduct.approved_qty IS NULL THEN orderproduct.quantity
                      ELSE orderproduct.approved_qty  END) as order_price")
                    )
                    ->groupBy('porder.id')
                    ->orderBy('porder.created_at','desc')
                    ->get();
        return view('statement.invoicestationdetail')
        ->with('porders' ,$porders)
        ->with('station' , $station)
        ->with('currency' , $currency)
        ->with('id' , $id);		
    }

    public function stationpurchasedetail()
    {
    	// $from = Carbon::today();
    	// $from->day = 1;
    	// $from->month = Request::input('month');
    	// $from->year = Request::input('year');
    	// $to = Carbon::create($from->year,$from->month,$from->day);
     //    $to = $to->endOfMonth();
        $month=(int)Request::input('month');
        $emonth=(string)$month+1;
        $smonth=(string)$month;
        // $year=Request::input('year');
        $Currentyear=Request::input('year');
        $nextyear=Request::input('year');
        if($emonth == 13){
          $emonth = 01;
          $nextyear++;
        }
        $id = Request::input('user_id');
        // $fromDate=$year."-".$smonth.'-01';
        // $toDate=$year."-".$emonth."-01";
        $fromDate=$Currentyear."-".$smonth.'-01';
        $toDate=$nextyear."-".$emonth."-01";
        $station = Station::where('user_id',$id)
        ->first();
        $currency = \DB::table('currency')
        ->where('currency.active' ,'=',1)
        ->select('currency.code')
        ->get();
        foreach ($currency as $value) {
            $currency = $value;
        }
            // dump($fromDate);
            // dump($toDate);
        $porders = \DB::table('deliveryinvoice')
        ->join('invoice' , 'deliveryinvoice.invoice_id' , '=' , 'invoice.id')
        ->join('porder' , 'invoice.porder_id' , '=' , 'porder.id')
        // ->join('ordertproduct', 'ordertproduct.porder_id','=','porder.id')
        // ->join('tproduct' ,'tproduct.id','=','ordertproduct.tproduct_id')
        // ->join('merchanttproduct' ,'merchanttproduct.tproduct_id','=','ordertproduct.tproduct_id')
        ->join('orderproduct', 'orderproduct.porder_id','=','porder.id')
          ->join('product' ,'product.id','=','orderproduct.product_id')
        ->join('merchantproduct' ,'merchantproduct.product_id','=','product.parent_id')
        ->whereBetween('porder.created_at',[$fromDate,$toDate])
                    // ->whereRaw("porder.created_at BETWEEN '2017-05-1' AND '2017-06-1'")
        ->where('porder.user_id',$id)
        ->distinct()
        ->select(
         'invoice.id as invid',
         'porder.id as porderid',
         'porder.receipt_tstamp as receipt_tstamp',
         'porder.delivery_tstamp as delivery_tstamp',
         'porder.created_at',
         'merchantproduct.merchant_id AS seller_id'

         // 'merchanttproduct.merchant_id AS seller_id'
     )
        ->orderBy('porder.created_at','DESC')
        ->get();
        return view('statement.purchasestationdetail')
        ->with('porders' ,$porders)
        ->with('station' , $station)
        ->with('currency' , $currency)
        ->with('id' , $id);		
    }	



    
    public function doissued()
    {

        $user_id = Auth::user()->id;
        $merchant_id = Merchant::where('user_id',$user_id)->first();
        $month=(int)Request::input('month');
        $emonth=(string)$month+1;
        $smonth=(string)$month;
        // $year=Request::input('year');
        $Currentyear=Request::input('year');
        $nextyear=Request::input('year');
        if($emonth == 13){
          $emonth = 01;
          $nextyear++;
        }
        $id = Request::input('user_id');
        // $fromDate=$year."-".$smonth.'-01';
        // $toDate=$year."-".$emonth."-01";
        $fromDate=$Currentyear."-".$smonth.'-01';
        $toDate=$nextyear."-".$emonth."-01";
        
        // $doissued = DeliveryOrder::where('deliveryorder.status','confirmed')
            // ->leftjoin('ndeliveryid','ndeliveryid.delivery_id','=','deliveryorder.id')
        $doissued = DeliveryOrder::leftjoin('ndeliveryorderid','ndeliveryorderid.deliveryorder_id','=','deliveryorder.id')
            ->leftjoin('receipt','receipt.id','=','deliveryorder.receipt_id')
            ->leftjoin('porder','porder.id','=','receipt.porder_id')
           ->leftjoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftjoin('deliveryorderproduct','deliveryorder.id','=','deliveryorderproduct.do_id')
        ->where('deliveryorder.merchant_id','=',$merchant_id->id)
            ->whereNotNull('deliveryorder.deliveryorder_no')
        ->whereBetween('deliveryorder.created_at',[$fromDate,$toDate])
        ->select('deliveryorder.created_at as created_at',
            'deliveryorder.status as status',

            // 'ndeliveryid.ndelivery_id as nid',
            'ndeliveryorderid.ndeliveryorder_id as nid',
            'deliveryorder.source as source',
            'deliveryorder.id as id',
            'porder.id as p_id')
          ->groupby('p_id')
          ->orderBy('deliveryorder.id','desc')
        ->get();
        
        return  $returndoissued = view('seller.logistics.return_dodocument_ajax',compact('doissued',$doissued))->render();
        
    }
    
    public function returnofgoods()
    {
        $user_id = Auth::user()->id;
        //$merchant_id = Merchant::where('user_id',$user_id)->first();
        $month=(int)Request::input('month');
        $emonth=(string)$month+1;
        $smonth=(string)$month;
        $year=Request::input('year');
        $id = Request::input('user_id');
        $fromDate=$year."-".$smonth.'-01';
        $toDate=$year."-".$emonth."-01";
        
        $creditnote = CreditNote::join('return_of_goods','creditnote.return_of_goods_id','=','return_of_goods.id')
        ->leftjoin('ntproductid','return_of_goods.order_tproduct_id','=','ntproductid.tproduct_id')
        ->join('ordertproduct','ordertproduct.id','=','return_of_goods.order_tproduct_id')
        //->join('tproduct','ordertproduct.tproduct_id','=','tproduct.id')
        ->where('return_of_goods.station_id','=',$user_id)
        ->where('creditnote.status','=','approved')
        ->whereBetween('return_of_goods.created_at',[$fromDate,$toDate])
        ->get([
            'creditnote.id',
            'return_of_goods.returnofgoods_no as creditnote_no',
            'creditnote.created_at',
            'return_of_goods.quantity',
            'ordertproduct.order_price as price'
        ]);
        $creditnotetable = view('seller.credit_note_views.return_returnofgood_ajax',compact('creditnote',$creditnote))->render();

        return $creditnotetable;
   }


public function salesorderdocument()
{
    $user_id = Auth::user()->id;

    $month=(int)Request::input('month');
    $emonth=(string)$month+1;
    $smonth=(string)$month;
    // $year=Request::input('year');
    $Currentyear=Request::input('year');
    $nextyear=Request::input('year');
    if($emonth == 13){
      $emonth = 01;
      $nextyear++;
    }

    $id = Request::input('user_id');
    $fromDate=$Currentyear."-".$smonth.'-01';
    $toDate=$nextyear."-".$emonth."-01";
    // $fromDate=$year."-".$smonth.'-01';
    // $toDate=$year."-".$emonth."-01";

   
	$porder = OrderProduct::join('porder','porder.id','=','orderproduct.porder_id')->join
	('product', 'product.id', '=', 'orderproduct.product_id')->join
	('merchantproduct','merchantproduct.product_id','=','product.parent_id')->join
	('merchant','merchantproduct.merchant_id','=','merchant.id')->join
	('nporderid','porder.id','=','nporderid.porder_id')->where
	('merchant.user_id','=',$user_id)->whereNull
	('porder.deleted_at')->whereNotNull
    ('porder.salesorder_no')->where
	('porder.mode','=','gator')->whereBetween
	('porder.created_at',[$fromDate,$toDate])->distinct
	('porder.id')->orderBy('porder.created_at','desc')->get([
		'porder.salesorder_no',
		'porder.is_emerchant',
		'porder.user_id',
		'porder.created_at',
		'porder.user_id',
		'porder.status',
		'porder.id',
	]);

	//Get each POrder
	foreach ($porder as $p){
		//Get each Order
		$order = DB::table('orderproduct')->
			select('orderproduct.order_price','orderproduct.quantity','orderproduct.approved_qty')->
			where('orderproduct.porder_id', $p->id)->get();

		$price = 0;

		//Iterate through and sum up order prices
		foreach ($order as $o){
		    if(!is_null($o->approved_qty)){
		        $o->quantity = $o->approved_qty;
            }
			$price = $price + ($o->order_price * $o->quantity);
		}

		$p->price = $price;
	}

	$querysalesorderamount = POrder::join('orderproduct','porder.id','=','orderproduct.porder_id')->join
		('product','product.id', '=', 'orderproduct.product_id')->join
		('merchantproduct','merchantproduct.product_id','=','product.parent_id')->join
		('merchant','merchantproduct.merchant_id','=','merchant.id')->where
		('merchant.user_id','=',$user_id)->whereNull
		('porder.deleted_at')->whereNotNull
        ('porder.salesorder_no')->where
		 ('porder.status', '=', 'completed')->where
		('porder.mode','=','gator')->whereBetween
		('porder.created_at',[$fromDate,$toDate])
		->get([
			'porder.created_at',
			'porder.id as poid',
			'orderproduct.porder_id as otppoid',
			'orderproduct.order_price',
            'orderproduct.approved_qty',
			'orderproduct.quantity',
		]);
    
	Log::debug('***** count='.count($querysalesorderamount).' *****');
	Log::debug('************Quersalesorder**********');
	Log::debug($querysalesorderamount);

	$monthsaleorder =  Array();
	$todaysaleorder =  Array();
	$todaysales = 0;
	$todaydate  = date('d-m-Y');

	if(count($querysalesorderamount) > 0) {

        $monthly_sales = 0;
		foreach ($querysalesorderamount as $key => $saleorder) {

			Log::debug('***********Key**********');
			Log::debug($key);
			Log::debug('***** $saleorder *****');
			Log::debug($saleorder);
            if(!is_null($saleorder->approved_qty)){
                $saleorder->quantity = $saleorder->approved_qty;
            }
			if ($saleorder->created_at->format('d-m-Y') == $todaydate) {
				$todaysales =
					$todaysales + ($saleorder->order_price * $saleorder->quantity);
			}

			$monthly_sales = ($monthly_sales + $saleorder->order_price * $saleorder->quantity);
		}

        Log::debug('***********Monthly Sales**********');
        Log::debug($monthly_sales);

	} else {
        $monthly_sales = 0;
		$todaysales = 0;
	}

	Log::debug('*********** month_of_sales ***********');
	// Log::debug($month_of_sales);
  Log::debug($monthly_sales);

    $pordertable = view('seller.gator.salesorderdocument_ajax',
		compact('porder','monthly_sales',
			'porderprice',
			'todaysales'))->render();

    return $pordertable;
}


public function add_adjustment()
{
  $adjustment=(int)Request::input('adjustment');
  $description=Request::input('description');
  $footer=Request::input('footer');
  $merchant_id=Request::input('merchant_id');
  $def_ad = $adjustment*100;
  DB::table('adjustment')->insert(['price'=>$def_ad,'admin_user_id'=>Auth::user()->id,'description'=>$description,'footer_note'=>$footer,'merchant_id'=>$merchant_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
  return "OK";
}

//--------------------------debitnoteissued statement changed by dave-----------------//
public function merchantdebitnotedetail()
{
    $month=(int)Request::input('month');
    
    $emonth=(string)$month+1;
    $smonth=(string)$month;

    $Currentyear=Request::input('year');
    $nextyear=Request::input('year');
    if($emonth == 13){
      $emonth = 01;
      $nextyear++;
    }
    $selectedMonth = date("F", mktime(0, 0, 0, $smonth, 10));;
    $selectedYear = $nextyear;
    $selectedMonthYear = $selectedMonth.' '.$Currentyear;
   
    $user_id = Request::input('user_id');
    $id=DB::table('merchant')->where('user_id',$user_id)->pluck('id');

    $fromDate=$Currentyear."-".$smonth.'-01';
    $toDate=$nextyear."-".$emonth."-01";
    $merchant = Merchant::where('id',$id)->first();
      
    if(isset($merchant)){
        $merchant_address = Address::where( 'id',$merchant->address_id)
        ->first(array('line1','line2','line3','line4'));

    }  else {
        $merchant_address = null;
    }
	$currency = \DB::table('currency')->
		where('currency.active' ,'=',1)->
		select('currency.code')->get();

    foreach ($currency as $value) {
        $currency = $value;
    }
   
   // dd($fromDate,$toDate);
     $porders = \DB::table('debitnote')
    ->join('merchantdebitnote', 'merchantdebitnote.debitnote_id', '=',
    'debitnote.id')
    ->join('merchant as m', 'm.id', '=', 'merchantdebitnote.merchant_id')
    ->leftJoin('station as s', 'debitnote.dealer_user_id', '=', 's.user_id')
    ->leftJoin('merchant', 'merchant.id', '=',
    'merchantdebitnote.merchant_id')
	->whereBetween('debitnote.created_at',[$fromDate,$toDate])
    ->where('merchant.id',$id)
		->distinct()
		->select(
            's.company_name',
            'debitnote.created_at',	
            'debitnote.id',
            'debitnote.debitnote_no',
            'debitnote.total',
            'debitnote.status',
            'merchantdebitnote.merchant_id as merchant_id',
            'debitnote.dealer_user_id'
		)
		->groupBy('debitnote.id')
		->orderBy('debitnote.created_at','DESC')
        ->get();

        

	$todayInvoice = 0;
	$todaydate  = date('d-m-Y');
  $monthly_invoice = 0;

	if(count($porders) > 0) {
$todayInvoices = 0;
        
		foreach ($porders as $key => $invoiceOrder) {

			if (date('d-m-Y',strtotime($invoiceOrder->created_at)) == $todaydate && $invoiceOrder->status != 'cancelled') {
        $todayInvoice = $todayInvoice + $invoiceOrder->total;
            

        

      } 

			if($invoiceOrder->status != 'cancelled'){

        $monthly_invoice = $monthly_invoice + $invoiceOrder->total;
      }
		
		}
  
	} 

    $mer = "Merchant ID";
    $id = $merchant->id;
    $s= $merchant_address;
   
    return view('statement.debitnotemerchantdetail')
		->with('porders' ,$porders)
		->with('merchant' , $merchant)
		->with('currency' , $currency)
		->with('merchant_address' , $merchant_address)
	    ->with('s' , $s)
		->with('id' , $id)
        ->with('mer' , $mer)
        ->with('monthly_invoice' , $monthly_invoice)		
        ->with('todayInvoice' , $todayInvoice)
        ->with('selectedMonthYear',$selectedMonthYear);
}	
//--------------------------debitnoteissued statement changed by dave-----------------//


//--------------------------debitnote received statement changed by dave-----------------//
public function debitnotereceived()
{
    $month=(int)Request::input('month');
    
    $emonth=(string)$month+1;
    $smonth=(string)$month;

    $Currentyear=Request::input('year');
    $nextyear=Request::input('year');
    if($emonth == 13){
      $emonth = 01;
      $nextyear++;
    }
    $selectedMonth = date("F", mktime(0, 0, 0, $smonth, 10));;
    $selectedYear = $nextyear;
    $selectedMonthYear = $selectedMonth.' '.$Currentyear;
   
    $user_id = Request::input('user_id');
    $id=DB::table('merchant')->where('user_id',$user_id)->pluck('id');

    $fromDate=$Currentyear."-".$smonth.'-01';
    $toDate=$nextyear."-".$emonth."-01";
    $merchant = Merchant::where('id',$id)->first();
      
    if(isset($merchant)){
        $merchant_address = Address::where( 'id',$merchant->address_id)
        ->first(array('line1','line2','line3','line4'));

    }  else {
        $merchant_address = null;
    }
	$currency = \DB::table('currency')->
		where('currency.active' ,'=',1)->
		select('currency.code')->get();

    foreach ($currency as $value) {
        $currency = $value;
    }
   
   // dd($fromDate,$toDate);
     $porders = \DB::table('debitnote')
    ->join('merchantdebitnote', 'merchantdebitnote.debitnote_id', '=',
    'debitnote.id')
    ->join('merchant as m', 'm.id', '=', 'merchantdebitnote.merchant_id')
    ->leftJoin('station as s', 'debitnote.dealer_user_id', '=', 's.user_id')
    ->leftJoin('merchant', 'merchant.id', '=',
    'merchantdebitnote.merchant_id')
	->whereBetween('debitnote.created_at',[$fromDate,$toDate])
    ->where('merchant.id',$id)
		->distinct()
		->select(
            's.company_name',
            'debitnote.created_at',	
            'debitnote.id',
            'debitnote.debitnote_no',
            'debitnote.total',
            'debitnote.status',
            'merchantdebitnote.merchant_id as merchant_id',
            'merchant.company_name as name',
            'debitnote.dealer_user_id'
		)
		->groupBy('debitnote.id')
		->orderBy('debitnote.created_at','DESC')
        ->get();

        

	$todayInvoice = 0;
	$todaydate  = date('d-m-Y');
  $monthly_invoice = 0;

	if(count($porders) > 0) {
$todayInvoices = 0;
        
		foreach ($porders as $key => $invoiceOrder) {

			if (date('d-m-Y',strtotime($invoiceOrder->created_at)) == $todaydate && $invoiceOrder->status != 'cancelled') {
        $todayInvoice = $todayInvoice + $invoiceOrder->total;
            

        

      } 

			if($invoiceOrder->status != 'cancelled'){

        $monthly_invoice = $monthly_invoice + $invoiceOrder->total;
      }
		
		}
  
	} 

    $mer = "Merchant ID";
    $id = $merchant->id;
    $s= $merchant_address;
   //dd($porders);
    return view('statement.debitnotereceived')
		->with('porders' ,$porders)
		->with('merchant' , $merchant)
		->with('currency' , $currency)
		->with('merchant_address' , $merchant_address)
	    ->with('s' , $s)
		->with('id' , $id)
        ->with('mer' , $mer)
        ->with('monthly_invoice' , $monthly_invoice)		
        ->with('todayInvoice' , $todayInvoice)
        ->with('selectedMonthYear',$selectedMonthYear);
}	
//--------------------------debitnote received statement changed by dave-----------------//


public function merchantinvoicedetail()
{
    
    $month=(int)Request::input('month');
    
    $emonth=(string)$month+1;
    $smonth=(string)$month;
    // $year=Request::input('year');
    $Currentyear=Request::input('year');
    $nextyear=Request::input('year');
    if($emonth == 13){
      $emonth = 01;
      $nextyear++;
    }
    $selectedMonth = date("F", mktime(0, 0, 0, $smonth, 10));;
    $selectedYear = $nextyear;
    $selectedMonthYear = $selectedMonth.' '.$Currentyear;
    // if($prev_month == 0) {
    //   $prev_month = 12;
    //   $prev_year--;
    // }
   
    $user_id = Request::input('user_id');
    $id=DB::table('merchant')->where('user_id',$user_id)->pluck('id');
    // $fromDate=$year."-".$smonth.'-01';
    // $toDate=$year."-".$emonth."-01";
    $fromDate=$Currentyear."-".$smonth.'-01';
    $toDate=$nextyear."-".$emonth."-01";
    $merchant = Merchant::where('id',$id)->first();
      
    if(isset($merchant)){
        $merchant_address = Address::where( 'id',$merchant->address_id)
        ->first(array('line1','line2','line3','line4'));

    }  else {
        $merchant_address = null;
    }
	$currency = \DB::table('currency')->
		where('currency.active' ,'=',1)->
		select('currency.code')->get();

    foreach ($currency as $value) {
        $currency = $value;
    }

	$porders = \DB::table('merchantproduct')
		->join('product', 'merchantproduct.product_id','=','product.parent_id')
		->join('orderproduct', 'orderproduct.product_id','=','product.id')
		->join('porder' , 'orderproduct.porder_id' , '=' , 'porder.id')
		->join('invoice','invoice.porder_id','=','porder.id')

    ->leftjoin('merchant as umerchant','porder.user_id','=','umerchant.user_id')

		->leftjoin('merchant','merchant.id','=','merchantproduct.merchant_id')
		->leftjoin('station','station.user_id','=','merchant.user_id')
		->whereBetween('porder.created_at',[$fromDate,$toDate])
    ->where('merchantproduct.merchant_id',$id)
		->distinct()
		->select(
       'umerchant.company_name as companyname',
			 'porder.id as porderid',
			 'porder.receipt_tstamp as receipt_tstamp',
			 'porder.delivery_tstamp as delivery_tstamp',
			 'porder.created_at',
			 'porder.status',
			 'invoice.invoice_no',
		    'orderproduct.order_price',
		    'orderproduct.quantity',
			 'station.user_id AS buyer_id',
			 DB::raw("SUM(orderproduct.order_price *  case when orderproduct.approved_qty IS NULL THEN orderproduct.quantity
                      ELSE orderproduct.approved_qty  END) as TotalOrderPrice")
		)
		->groupBy('porder.id')
		->orderBy('porder.created_at','DESC')
->get();
	$todayInvoice = 0;
	$todaydate  = date('d-m-Y');
  $monthly_invoice = 0;
  // $cancetoday = 0;
	if(count($porders) > 0) {
$todayInvoices = 0;
        //$monthly_invoice = 0;
        // $monthlycancel = 0;
		foreach ($porders as $key => $invoiceOrder) {

			if (date('d-m-Y',strtotime($invoiceOrder->created_at)) == $todaydate && $invoiceOrder->status != 'cancelled') {
    // echo "</br>";
    // print_r($invoiceOrder->status);
    // echo "</br>";
        // if($invoiceOrder->status != 'cancelled'){
           // if($invoiceOrder->status == 'cancelled'){
            
        //      $cancetoday = $cancetoday + ($invoiceOrder->order_price * $invoiceOrder->quantity);
             
        // }else{
            // $todayInvoice = $todayInvoice + ($invoiceOrder->order_price * $invoiceOrder->quantity);
        $todayInvoice = $todayInvoice + $invoiceOrder->TotalOrderPrice;
            
        //}
        
          // $todayInvoice = $todayInvoice + ($invoiceOrder->order_price * $invoiceOrder->quantity);
      } 

			if($invoiceOrder->status != 'cancelled'){
        // if($invoiceOrder->status == 'cancelled'){
             // $monthlycancel = ($monthlycancel + $invoiceOrder->order_price * $invoiceOrder->quantity);
      // }
      // else{
       // $monthly_invoice = ($monthly_invoice + $invoiceOrder->order_price * $invoiceOrder->quantity);
        $monthly_invoice = $monthly_invoice + $invoiceOrder->TotalOrderPrice;
      }
			// $monthly_invoice = ($monthly_invoice + $invoiceOrder->order_price * $invoiceOrder->quantity);
		}
    // $monthly_invoice =$monthly_invoice - $monthlycancel  ;
    // $todayInvoice =$todayInvoice - $cancetoday ;
    // exit;
	} 
 //  else {
 //        $monthly_invoice = 0;
	// 	$todayInvoice = 0;
	// }   
    $mer = "Merchant ID";
    $id = $merchant->id;
    $s= $merchant_address;
    $name = $merchant->oshop_name;

    return view('statement.invoicemerchantdetail')
		->with('porders' ,$porders)
		->with('merchant' , $merchant)
		->with('currency' , $currency)
		->with('merchant_address' , $merchant_address)
		->with('name' ,$name)
		->with('s' , $s)
		->with('id' , $id)
    ->with('mer' , $mer)
    ->with('monthly_invoice' , $monthly_invoice)		
    ->with('todayInvoice' , $todayInvoice)
    ->with('selectedMonthYear',$selectedMonthYear);
}	


public function merchantpurchasedetail()
{
    $month=(int)Request::input('month');
    $emonth=(string)$month+1;
    $smonth=(string)$month;
    $year=Request::input('year');
    $user_id = Request::input('user_id');
    $id=DB::table('merchant')->where('user_id',$user_id)->pluck('id');
    $fromDate=$year."-".$smonth.'-01';
    $toDate=$year."-".$emonth."-01";
    $merchant = Merchant::where('id',$id)
    ->first();
    if(isset($merchant)){
        $merchant_address = Address::where( 'id',$merchant->address_id)
        ->first(array('line1','line2','line3','line4'));
    }  else {
        $merchant_address = null;
    }
    $currency = \DB::table('currency')
    ->where('currency.active' ,'=',1)
    ->select('currency.code')
    ->get();
    foreach ($currency as $value) {
        $currency = $value;
    }

    $porders = \DB::table('deliveryinvoice')
    ->join('invoice' , 'deliveryinvoice.invoice_id' , '=' , 'invoice.id')
    ->join('porder' , 'invoice.porder_id' , '=' , 'porder.id')
    ->join('ordertproduct', 'ordertproduct.porder_id','=','porder.id')
    ->join('tproduct' ,'tproduct.id','=','ordertproduct.tproduct_id')
    ->join('merchanttproduct' ,'merchanttproduct.tproduct_id','=','ordertproduct.tproduct_id')
    ->whereBetween('porder.created_at',[$fromDate,$toDate])
    ->where('merchanttproduct.merchant_id',$id)
    ->distinct()
    ->select(
		 'invoice.id as invid',
		 'porder.id as porderid',
		 'porder.receipt_tstamp as receipt_tstamp',
		 'porder.delivery_tstamp as delivery_tstamp',
		 'porder.created_at',
		 'porder.user_id AS buyer_id'
 )
    ->orderBy('porder.created_at','DESC')
    ->get();
			//dd($porders);
    $mer = "Merchant ID";
    $id = $merchant->id;
    $s= $merchant_address;
    $name = $merchant->oshop_name;

    return view('statement.purchasemerchantdetail')
		->with('porders' ,$porders)
		->with('merchant' , $merchant)
		->with('currency' , $currency)
		->with('merchant_address' , $merchant_address)
		->with('name' ,$name)
		->with('s' , $s)
		->with('id' , $id)
		->with('mer' , $mer);		
}		

public function dodetail()
{
   $from = Carbon::today();
   $from->day = 1;
   $from->month = Request::input('month');
   $from->year = Request::input('year');
   $to = Carbon::create($from->year,$from->month,$from->day);
   $to = $to->endOfMonth();
   $id = Request::input('id');

   $merchant = Merchant::where('user_id',$id)->
	   first();

   if(isset($merchant)){
		$merchant_address = Address::where( 'id',$merchant->address_id)
			->first(array('line1','line2','line3','line4'));

	}  else {
		$merchant_address = null;
	}

	$station = Station::where('user_id' , $id)
		->first();

	if(isset($station)){
		$station_address = Address::where('id' , $station->address_id)
		->first(array('line1','line2','line3','line4'));
	}else{
		$station_address = null;
	}

	$currency = \DB::table('currency')
		->where('currency.active' ,'=',1)
		->select('currency.code')
		->get();

	foreach ($currency as $value) {
		$currency = $value;
	}

	$roles = \DB::table('role_users')
		->join('roles' , 'roles.id' ,'=' , 'role_users.role_id')
		->join('merchant' , 'merchant.user_id' , '=', 'role_users.user_id')
		->where('role_users.user_id','=',$id)
		->where('merchant.user_id' , '=' , $id)
		->select('slug' , 'role_users.user_id')
		->get();
	$o = POrder::where('user_id' , $id)->select('id')->get();

	$sorders = \DB::table('deliveryorder')
	->join('receipt' , 'deliveryorder.receipt_id' , '=' , 'receipt.id')
	->join('porder' , 'receipt.porder_id' , '=' , 'porder.id')
	->join('station' , 'station.user_id' , '=' , 'porder.user_id')
	->join('sorder', 'sorder.porder_id','=','porder.id')
	->join('orderproduct' , 'orderproduct.porder_id' , '=' , 'sorder.porder_id')
	->join('product' , 'product.id' , '=' , 'orderproduct.product_id')
	->join('merchantproduct' , 'orderproduct.product_id' , '=' , 'merchantproduct.product_id')
	->join('merchant','merchantproduct.merchant_id','=','merchant.id')
	->whereBetween('porder.created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])
	->where('porder.user_id',$id)
	->select(
	  'deliveryorder.id as doid',
	  'receipt.id as recid',
	  'porder.id as porderid',
	  'porder.receipt_tstamp as receipt_tstamp',
	  'porder.delivery_tstamp as delivery_tstamp',
	  'sorder.created_at',
	  'product.name AS description',
	  'sorder.id AS transaction_id',
	  'merchant.id AS merchant_id',
	  'product.id AS product_id',
	  'orderproduct.order_price',
	  'porder.user_id AS seller_id',
	  'orderproduct.quantity'
	)
	->get();

	$porders = \DB::table('deliveryorder')
	->join('receipt' , 'deliveryorder.receipt_id' , '=' , 'receipt.id')
	->join('porder' , 'receipt.porder_id' , '=' , 'porder.id')
	->join('orderproduct', 'orderproduct.porder_id','=','porder.id')
	->join('product' ,'product.id','=','orderproduct.product_id')
	->join('merchant' , 'merchant.user_id' , '=' , 'porder.user_id')
	->whereBetween('porder.created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])
	->where('porder.user_id',$id)
	->select(
		 'deliveryorder.id as doid',
		 'receipt.id as recid',
		 'porder.id as porderid',
		 'porder.receipt_tstamp as receipt_tstamp',
		 'porder.delivery_tstamp as delivery_tstamp',
		 'porder.created_at',
		 'porder.station_id',
		 'product.name AS description',
		 'merchant.id AS merchant_id',
		 'product_id',
		 'porder.user_id AS buyer_id',
		 'orderproduct.order_price',
		 'orderproduct.quantity'
	)
	->get();

	$i = 0;$r = array();
	if(isset($roles)){
		foreach($roles as $role){
			$r[$i] =  $role->slug;
			$i++;
		}
	} $i = 1;

	if(in_array("mct",$r) || isset($merchant)){
		$user_role = "mct";
		$mer = "Merchant ID";
		$id = $merchant->id;
		$s= $merchant_address;
		$name = $name = $merchant->oshop_name;

	} else if(in_array("sto" , $r) || isset ($station)){
		$user_role = "sto";
		$mer = "Station ID";
		$id = $station->id;
		$s = $station_address;
		$name = $station->station_name;
	}

	return view('statement.dodetail')
		->with('porders' ,$porders)
		->with('sorders' , $sorders)
		->with('roles' , $roles)
		->with('station' , $station)
		->with('merchant' , $merchant)
		->with('currency' , $currency)
		->with('merchant_address' , $merchant_address)
		->with('station_address' , $station_address)
		->with('name' ,$name)
		->with('s' , $s)
		->with('id' , $id)
		->with('mer' , $mer)
		->with('user_role' , $user_role);
}


public function showLogisticStatement($month,$year,$logistic_id="logistic")
{
        // Test Code .
    $y2=intval($year);
    $m2=intval($month);
    if ($month==12) {
        $m2=01;
        $y2=$y2+1;
    }
    $rawMonth=$month;
    $firstcyle_sdate=$year."-".$month."-01";
    $firstcyle_edate=$year."-".$month."-16";
    $secondcyle_sdate=$year."-".$month."-16";
    $secondcyle_edate=$y2."-".($m2+1)."-01";
    if (Auth::user()->hasRole('adm')) {

    }else{
            // Get merchant id
        try {
            $logistic_id=Station::join('logistic','logistic.station_id','=','station.id')
            ->where('user_id',Auth::user()->id)
            ->pluck('logistic.id');
            $logistic_id=1;

        } catch (\Exception $e) {
            //dump($e);
            return view('common.generic')
            ->with('message_type',"error")
            ->with('message','You do not have permission to access this resource. #001')
            ;
        }
    }
        // echo "string";
        // return $logistic_id;
    try{
        $extraData=[UtilityController::numberMonth($month),$year,$rawMonth];
        $firstcyle=$this->getLogisticStatement($logistic_id,$firstcyle_sdate,$firstcyle_edate);

        $secondcycle=$this->getLogisticStatement($logistic_id,$secondcyle_sdate,$secondcyle_edate);

        $cycle=[$firstcyle,$secondcycle,$extraData];
            // return $cycle;
        return view('statement.logistic_statement',compact('cycle'));
    }catch(\Exception $e){
            // dump($e);
        return view('common.generic')
        ->with('message_type',"error")
        ->with('message','You do not have permission to access this resource. #002')
        ;
    }
}


public function getLogisticStatement($logistic_id,$start_cycle,$end_cycle)
{
    $data=DB::select(DB::raw(
        "
        SELECT DISTINCT SUM(op.actual_delivery_price+orn.return_price) as price,
        delivery.delivery_administration_fee as dafee,
        SUM(op.shipping_cost) as credit,
        delivery.id as did,
        op.porder_id as poid,
        'unpaid' as status,
        delivery.updated_at as completed_at,
        (SUM(op.actual_delivery_price+orn.return_price) -SUM(op.shipping_cost) ) as logistic_commission

        FROM 
        delivery
        JOIN (SELECT DISTINCT porder_id FROM delivery  group by id) as porder on delivery.porder_id=porder.porder_id
        JOIN orderproduct as op on porder.porder_id=op.porder_id

        LEFT JOIN orderreturn as orn on orn.porder_id=porder.porder_id
        WHERE 
        delivery.logistic_id=".$logistic_id."
        AND (delivery.created_at BETWEEN '".$start_cycle."' AND '".$end_cycle."')

        GROUP BY delivery.id

        "
    ));
    return $data;


}
public function pdfLogisticStatement($month,$year,$logistic_id="logistic")
{
    $y2=intval($year);
    $m2=intval($month);
    if ($month==12) {
        $m2=01;
        $y2=$y2+1;
    }
    $rawMonth=$month;
    $firstcyle_sdate=$year."-".$month."-01";
    $firstcyle_edate=$year."-".$month."-16";
    $secondcyle_sdate=$year."-".$month."-16";
    $secondcyle_edate=$y2."-".($m2+1)."-01";
    if ($logistic_id!="logistic_id" and Auth::user()->hasRole('adm')) {
        $logistic_id=$logistic_id;
    }else{
            // Get merchant id
        try {

            $logistic_id=1;
            $merchant=Station::join('logistic','logistic.station_id','=','station.id')

            ->where('logistic.id','=',$logistic_id)
            ->first();


        } catch (\Exception $e) {
           return $e;
       }
   }

   $merchant_address=Address::find($merchant->address_id);
   $extraData=[UtilityController::numberMonth($month),$year,$rawMonth,$merchant,$merchant_address];
   $firstcyle=$this->getLogisticStatement($logistic_id,$firstcyle_sdate,$firstcyle_edate);

   $secondcycle=$this->getLogisticStatement($logistic_id,$secondcyle_sdate,$secondcyle_edate);
   $statement_file_name="statement/ops_statement_logistic_".$month."_".$year.".pdf";
   $cycle=[$firstcyle,$secondcycle,$extraData];
        // Wrapper
   $pdf=PDF::loadView('statement.pdf.log',['cycle'=>$cycle])->setOption('margin-bottom', 20)
   ->save(storage_path($statement_file_name));
}

public function downloadLogisticStatement($month,$year)
{
    $this->pdfLogisticStatement($month,$year);
    $headers = array(
      'Content-Type: application/pdf',
  );
    $file_path="statement/ops_statement_logistic_".$month."_".$year.".pdf";

    return response()->download(storage_path($file_path),"statement.pdf",$headers)->deleteFileAfterSend(true);
}

//public function trackingop()
//{
//    $from = Carbon::today();
//    $from->day = 1;
//    $from->month = Request::input('month');
//    $from->year = Request::input('year');
//
//    $to = Carbon::create($from->year,$from->month,$from->day);
//    $to = $to->endOfMonth();
//    $mid = Request::input('mid');
//    $id = Request::input('id');
//
//    if (!Auth::check()) {
//        return response()->json(["error"=>"Not Logged In"],403);
//    }
//
//    if (Auth::user()->hasRole("adm")) {
//        $merchant = DB::table('merchant')->where('id',$mid)
//        ->first();
//        $id = $merchant->user_id;
//
//    } else {
//            //dump("ELSE id=".$id);
//        $id=Auth::user()->id;
//        $merchant = DB::table('merchant')->where('user_id',$id)
//        ->first();
//            //dump("ELSE merchant=".$merchant);
//    }
//
//
//    $merchant_address = Address::where('id',$merchant->address_id)
//    ->first(array('line1','line2','line3','line4'));
//        // $currency = \DB::table('currency')
//        // ->where('currency.active' ,'=',1)
//        // ->select('currency.code')
//        // ->get();
//        // foreach ($currency as $value) {
//        //     $currency = $value;
//        // }
//
//    $currency= DB::table('currency')->where('active', 1)->first()->code;
//    $reports = DB::table("opos_receipt")
//    ->join('opos_receiptproduct','opos_receipt.id','=','opos_receiptproduct.receipt_id')
//
//    
//    ->leftJoin('users as usercheck','usercheck.id','=','opos_receipt.staff_user_id')
//   
//    ->select('opos_receipt.id','opos_receipt.staff_user_id','opos_receipt.created_at','usercheck.first_name','usercheck.last_name','opos_receipt.receipt_no','opos_receipt.terminal_id')
//    ->whereBetween('opos_receipt.created_at',[
//        $from->format('Y-m-d H:i:s'),
//        $to->format('Y-m-d H:i:s')])
//    ->groupBy("opos_receipt.id")
//    ->get()
//    ;
//   
//
//
//     // dd($reports);
//    //    $reports = Stockreport::with('checker')->where('checker_user_id','=',$id)->where('checker_user_id','<>','0')->where('status','=','confirmed')->whereBetween('created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])->orderBy('id','desc')->get();
//
//    $s= $merchant_address;
//    $name = $merchant->company_name;    
//    $monthNum=Request::input('month');
//    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
//        $monthName = $dateObj->format('F'); // March        
//        $year=Request::input('year');
//        return view('statement.trackingop')
//        ->with('reports' ,$reports)
//        ->with('merchant' , $merchant)
//        ->with('currency' , $currency)
//        ->with('merchant_address' , $merchant_address)
//        ->with('name' ,$name)
//        ->with('s' , $s)
//        ->with('id' , $id)
//        ->with('month',$monthName)
//        ->with('year',$year);       
//    }




public function trackingop()
{   
    $from = Carbon::today();
    $from->day = 1;
    $formdate = "";
   
	if(Request::input('report') === null){
		$from->month = Request::input('month');
		$from->year = Request::input('year');

		$to = Carbon::create($from->year,$from->month,$from->day);
		$to = $to->endOfMonth();
		$id = Request::input('id');
		$terminalId = Request::input('terminal_id');

    } else {
		$from->month =Carbon::now()->month;
		$from->year = Carbon::now()->year;
		$formdate = Carbon::today()->format('jS');
    }
    
    $mid = Request::input('mid');
    $terminal_id= Request::input('terminal_id');
    if (!Auth::check()) {
        return response()->json(["error"=>"Not Logged In"],403);
    }

    if (Auth::user()->hasRole("adm")) {
        $merchant = DB::table('merchant')->where('id',$mid)
        ->first();
        $id = $merchant->user_id;

    } else {
            //dump("ELSE id=".$id);
        $id=Auth::user()->id;
        $merchant = DB::table('merchant')->where('user_id',$id)
        ->first();
            //dump("ELSE merchant=".$merchant);
    }
    $selluser = User::find($id);

    $merchant_address = Address::where('id',$merchant->address_id)
    ->first(array('line1','line2','line3','line4'));
        // $currency = \DB::table('currency')
        // ->where('currency.active' ,'=',1)
        // ->select('currency.code')
        // ->get();
        // foreach ($currency as $value) {
        //     $currency = $value;
        // }
    $location  = DB::table('opos_locationterminal')
            ->select('fairlocation.*')
            ->join('fairlocation','opos_locationterminal.location_id','=','fairlocation.id')
            ->where('opos_locationterminal.terminal_id',$terminalId)->first();

    $currency= DB::table('currency')->where('active', 1)->first()->code;
    $reports = DB::table("opos_receipt")
    ->join('opos_receiptproduct','opos_receiptproduct.receipt_id','=','opos_receipt.id')
    ->join('opos_locationterminal','opos_receipt.terminal_id','=','opos_locationterminal.terminal_id')
    ->join('fairlocation','fairlocation.id','=','opos_locationterminal.location_id')
    ->leftJoin('users as usercheck','usercheck.id','=','opos_receipt.staff_user_id')
	->leftJoin('opos_servicecharge as sc','sc.id','=','opos_receipt.servicecharge_id')
    ->select('opos_receipt.id','opos_receipt.receipt_no','opos_receipt.status as status',
		'sc.value',
		'opos_receipt.staff_user_id','opos_receipt.created_at',
		'usercheck.first_name','usercheck.last_name','opos_receipt.receipt_no',
		'opos_receipt.terminal_id','opos_receipt.cash_received',
        DB::raw("SUM((opos_receiptproduct.quantity*opos_receiptproduct.price*opos_receiptproduct.discount)/100)as discount"),
        'fairlocation.location',DB::raw("SUM(opos_receiptproduct.quantity*opos_receiptproduct.price) as amount")
    );
   
    $reports = $reports->whereRaw('opos_receipt.terminal_id = '.$terminalId)
                       ->whereRaw('opos_receipt.status in ("completed","voided")');
   
   /* $report1 = $reports->toSql();
    $report2 = $reports->toSql();*/
    $monthlyAmount = $reports
		->whereRaw('MONTH(opos_receipt.created_at)='.Request::input('month'))
		->whereRaw('YEAR(opos_receipt.created_at)='.Request::input('year'))
		->whereRaw('opos_receiptproduct.deleted_at is null')
		->orderBy("opos_receipt.created_at","DESC")
		->groupBy("opos_receipt.id")
		->get();

    $todayAmount = $reports
		->whereRaw('MONTH(opos_receipt.created_at)='.Request::input('month'))
		->whereRaw('YEAR(opos_receipt.created_at)='.Request::input('year'))
		->whereRaw('DAY(opos_receipt.created_at)=DAY(CURDATE())')
		->groupBy("opos_receipt.id")
		->get();

    $reports = $reports->orderBy("opos_receipt.created_at","DESC")
    ->get();

	foreach ($reports as $r) {
		//$r->amount=($r->amount-$r->discount)/100;

		$amount=$r->amount;
		if(!empty($r->value)) {
			$sc = 1+(($r->value)/100);
			$r->amount=(($amount-$r->discount)*$sc)/100;
		} else {
			$r->amount=($amount-$r->discount)/100;
		}
	}

	foreach ($monthlyAmount as $r) {
		//$r->amount=($r->amount-$r->discount)/100;
 		$amount=$r->amount;
		if(!empty($r->value)) {
			$sc = 1+(($r->value)/100);
			$r->amount=(($amount-$r->discount)*$sc)/100;
		} else {
			$r->amount=($amount-$r->discount)/100;
		} 
	}

	foreach ($todayAmount as $r) {
		//$r->amount=($r->amount-$r->discount)/100;
 		$amount=$r->amount;
		if(!empty($r->value)) {
			$sc = 1+(($r->value)/100);
			$r->amount=(($amount-$r->discount)*$sc)/100;
		} else {
			$r->amount=($amount-$r->discount)/100;
		} 
	}

	$s= $merchant_address;
	$name = $merchant->company_name;    
	$monthNum=$from->month;
	$dateObj   = DateTime::createFromFormat('!m', $monthNum);
	$monthName = $dateObj->format('F'); // March        
	$year=$from->year;

	return view('statement.trackingop')
        ->with('reports' ,$reports)
        ->with('location' ,$location)
        ->with('monthlyAmount' ,$monthlyAmount)
        ->with('todayAmount' ,$todayAmount)
        ->with('terminalId' ,$terminalId)
        ->with('selluser' ,$selluser)
        ->with('merchant' , $merchant)
        ->with('currency' , $currency)
        ->with('merchant_address' , $merchant_address)
        ->with('name' ,$name)
        ->with('s' , $s)
        ->with('id' , $id)
        ->with('month',$monthName)
        ->with('year',$year)
        ->with('today', $formdate);       
}



    public function salesmemo()
    {
      $merchant = null;
      $from = Carbon::today();
      $from->day = 1;
      $from->month = Request::input('month');
      $from->year = Request::input('year');
      $to = Carbon::create($from->year,$from->month,$from->day);
      $to = $to->endOfMonth();
      $mid = Request::input('mid');
      

      if (!Auth::check()) {
        return response()->json(["error"=>"Not Logged In"],403);
    }

    if (Auth::user()->hasRole("adm")) {
        $merchant = DB::table('merchant')->where('id',$mid)
        ->first();
    } else {
			//dump("ELSE id=".$id);
        $id=Auth::user()->id;
        $merchant = DB::table('merchant')->where('user_id',$id)
        ->first();
			//dump("ELSE merchant=".$merchant);
    }

    $merchant_address = Address::where('id',$merchant->address_id)
    ->first(array('line1','line2','line3','line4'));
    $currency = \DB::table('currency')
    ->where('currency.active' ,'=',1)
    ->select('currency.code')
    ->get();
    foreach ($currency as $value) {
        $currency = $value;
    }

    $memos = DB::table('salesmemo')
    ->join('fairlocation','fairlocation.id','=','salesmemo.fairlocation_id')

    ->join('merchant','merchant.user_id','=','fairlocation.user_id')

    ->whereBetween('salesmemo.created_at',[
     $from->format('Y-m-d H:i:s'),
     $to->format('Y-m-d H:i:s')])
    ->where('fairlocation.user_id' , $merchant->user_id)
    ->select('salesmemo.creator_user_id','salesmemo.created_at','salesmemo.id','salesmemo.salesmemo_no','salesmemo.status')
    ->whereNull("salesmemo.deleted_at")
    ->whereNotNull("salesmemo.salesmemo_no")
    ->groupBy("salesmemo.id")
    ->orderBy('salesmemo.created_at','desc')
    ->get();  
    foreach($memos as $sm){
     $products = DB::table('salesmemoproduct')->where('salesmemo_id',$sm->id)->get();
     $total= 0;
     foreach($products as $pp){
        $tt = $pp->price * $pp->quantity;
        $total += $tt;
    }
    $sm->total = $total;
}

$s= $merchant_address;
$name = $merchant->company_name;    
$monthNum=Request::input('month');
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March        
        $year=Request::input('year');

        /* Summary */ 
        $day=DB::table("salesmemo")-> 
        join("salesmemoproduct","salesmemoproduct.salesmemo_id","=","salesmemo.id")->
        join("fairlocation","fairlocation.id","=","salesmemo.fairlocation_id")->
        where('fairlocation.user_id' , $merchant->user_id)->
        whereDate('salesmemo.created_at',">=",Carbon::today())->
        whereNull("salesmemo.deleted_at")->
        whereNotNull("salesmemo.confirmed_on")->
        where("salesmemo.status","active")->

        select(DB::raw("
            SUM(salesmemoproduct.quantity*salesmemoproduct.price) as sale
            "))
        ->get(); 

        $month=DB::table("salesmemo")-> 
        join("salesmemoproduct","salesmemoproduct.salesmemo_id","=","salesmemo.id")->
        join("fairlocation","fairlocation.id","=","salesmemo.fairlocation_id")->
        whereBetween('salesmemo.created_at',[
            $from->format('Y-m-d H:i:s'),
            $to->format('Y-m-d H:i:s')])->
        whereNull("salesmemo.deleted_at")->
        where("salesmemo.status","active")->
        whereNotNull("salesmemo.confirmed_on")->
        where('fairlocation.user_id' , $merchant->user_id)->
        select(DB::raw("
            SUM(salesmemoproduct.quantity*salesmemoproduct.price) as sale
            "))
        ->get(); 

        $sale=array();

        $sale["day"]=number_format($day[0]->sale/100,2);
        $sale["month"]=number_format($month[0]->sale/100,2);

        return view('statement.salesmemo')
        ->with('memos' ,$memos)
        ->with('merchant' , $merchant)
        ->with('currency' , $currency)
        ->with('merchant_address' , $merchant_address)
        ->with('name' ,$name)
        ->with('s' , $s)
        ->with('id' , $id)
        ->with('month',$monthName)
        ->with('year',$year)
        ->with("sale",$sale)
        ;       
    }	

	public function trackingreport()
	{
        $from = Carbon::today();
        $from->day = 1;
        $from->month = Request::input('month');
        $from->year = Request::input('year');
      
        $to = Carbon::create($from->year,$from->month,$from->day);
        $to = $to->endOfMonth();
        $mid = Request::input('mid');
        $id = Request::input('id');

        if (!Auth::check()) {
            return response()->json(["error"=>"Not Logged In"],403);
        }

        if (Auth::user()->hasRole("adm")) {
            $merchant = DB::table('merchant')->where('id',$mid)
            ->first();
            $id = $merchant->user_id;

        } else {
            //dump("ELSE id=".$id);
            $id=Auth::user()->id;
            $merchant = DB::table('merchant')->where('user_id',$id)
            ->first();
            //dump("ELSE merchant=".$merchant);
        }

        $merchant_address = Address::where('id',$merchant->address_id)
                ->first(array('line1','line2','line3','line4'));
        // $currency = \DB::table('currency')
        // ->where('currency.active' ,'=',1)
        // ->select('currency.code')
        // ->get();
        // foreach ($currency as $value) {
        //     $currency = $value;
        // }

        $currency= DB::table('currency')->where('active', 1)->first()->code;
        $reports1 = Stockreport::
                join('stockreportproduct','stockreport.id','=','stockreportproduct.stockreport_id')
           
                ->join('company','company.id','=','stockreport.checker_company_id')
                ->leftJoin('users as usercheck','usercheck.id','=','stockreport.checker_user_id')
                ->where('company.owner_user_id' , $id)
                ->where('stockreport.creator_user_id','<>','0')
                ->where('stockreport.status' , 'confirmed')
                ->where('stockreport.ttype','treport')
                ->select('stockreport.id','stockreport.creator_user_id','stockreport.created_at','usercheck.first_name','usercheck.last_name','stockreport.report_no')
                ->whereBetween('stockreport.created_at',[
                    $from->format('Y-m-d H:i:s'),
                      $to->format('Y-m-d H:i:s')])
                ->groupBy("stockreport.id")
                ;
        $reports2 = Stockreport::
                join('stockreportproduct','stockreport.id','=','stockreportproduct.stockreport_id')
                ->join('merchantproduct','merchantproduct.product_id','=','stockreportproduct.product_id')
                ->join('merchant','merchant.id','=','merchantproduct.merchant_id')
                ->leftJoin('users as usercheck','usercheck.id','=','stockreport.checker_user_id')
                ->where('merchant.user_id' , $id)
                ->where('stockreport.creator_user_id','<>','0')
                ->where('stockreport.status' , 'confirmed')
                ->select('stockreport.id','stockreport.creator_user_id','stockreport.created_at','usercheck.first_name','usercheck.last_name','stockreport.report_no')
                ->whereBetween('stockreport.created_at',[
                    $from->format('Y-m-d H:i:s'),
                      $to->format('Y-m-d H:i:s')])
                ->groupBy("stockreport.id");
                
        $reports=$reports1->union($reports2)->orderBy("created_at","DESC")->get();


    //  dd($reports);
    //    $reports = Stockreport::with('checker')->where('checker_user_id','=',$id)->where('checker_user_id','<>','0')->where('status','=','confirmed')->whereBetween('created_at',[$from->format('Y-m-d'),$to->format('Y-m-d')])->orderBy('id','desc')->get();

        $s= $merchant_address;
        $name = $merchant->company_name;    
        $monthNum=Request::input('month');
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March        
        $year=Request::input('year');
            return view('statement.trackingreport')
            ->with('reports' ,$reports)
            ->with('merchant' , $merchant)
            ->with('currency' , $currency)
            ->with('merchant_address' , $merchant_address)
            ->with('name' ,$name)
            ->with('s' , $s)
            ->with('id' , $id)
            ->with('month',$monthName)
            ->with('year',$year);       
    }

    public function doreceived()
    {
      // print_r('doreceived');
      // exit;
        $user_id = Auth::user()->id;
        $merchant_id = Merchant::where('user_id',$user_id)->first();
        $month=(int)Request::input('month');
        $emonth=(string)$month+1;
        $smonth=(string)$month;
        $year=Request::input('year');
        $id = Request::input('user_id');
        $fromDate=$year."-".$smonth.'-01';
        $toDate=$year."-".$emonth."-01";
       
        $doreceived = DeliveryOrder::where('deliveryorder.status','!=','cancelled')
        // ->leftjoin('ndeliveryid','ndeliveryid.delivery_id','=','deliveryorder.id')
        ->leftjoin('ndeliveryorderid','ndeliveryorderid.deliveryorder_id','=','deliveryorder.id')
            ->leftjoin('receipt','receipt.id','=','deliveryorder.receipt_id')
            ->leftjoin('porder','porder.id','=','receipt.porder_id')
           ->leftjoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftjoin('deliveryorderproduct','deliveryorder.id','=','deliveryorderproduct.do_id')
       // ->where('deliveryorder.merchant_id','=',$merchant_id->id)
       ->whereNotNull('deliveryorder.deliveryorder_no')
            ->where('porder.user_id','=',$user_id)
        ->whereBetween('deliveryorder.created_at',[$fromDate,$toDate])
        ->select('deliveryorder.created_at as created_at',
            'deliveryorder.status as status',
            // 'ndeliveryid.ndelivery_id as nid',
            'ndeliveryorderid.ndeliveryorder_id as nid',
            'deliveryorder.source as source',
            'deliveryorder.id as id',
            'porder.id as p_id')
          ->groupby('p_id')
           ->orderBy('deliveryorder.id','desc')
        ->get();
       
        return  $returndoissued = view('seller.logistics.return_doreceiveddocument_ajax',compact('doreceived',$doreceived))->render();
        
    }
}



