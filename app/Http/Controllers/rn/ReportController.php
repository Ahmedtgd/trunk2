<?php

namespace App\Http\Controllers\rn;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\rn\ProductController as RPC;
use QrCode;
use DB;
use JWTAuth;
use Log;
use Carbon;
use File;
class ReportController extends Controller
{
    /**
     * @api {post} rn/app/report/new Creates a new empty report record
     * @apiName NewReport
     * @apiGroup Report
     *
     * @apiPermission Merchant Admin
     * @apiSuccess {String} status success.
     * @apiSuccess {String} long_message .
     * @apiFailure {String} status failure
     OBSELETE
     */
   
    public function report_new(Request $r)
    {
        $ret=array();
        $ret['status']="failure";
        if (!$r->has('company_id') or !$r->has('location_id')) {
            $ret['error']="Missing parameter";
            return response()->json($ret);
        }
        // $ret['long_message']="Validation failure";
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user ) {
            return response()->json($ret);
        }
        $ttype="treport";
        if ($r->has("ttype") and !empty($ttype)) {
            $ttype=$r->ttype;
        }
        /*$report_number=(DB::table("stockreport")
        ->join("stockreportproduct","stockreportproduct.stockreport_id","=","stockreport.id")
        ->where("stockreport.creator_company_id",$r->company_id)
        ->whereNull("stockreport.deleted_at")
        ->count())+1;*/
        $to_update=[
            "creator_user_id"=>$user->id,
            "creator_company_id"=>$r->company_id,
            "creator_location_id"=>$r->location_id,
            "status"=>"pending",
            /*"report_no"=>$report_number,*/
            "updated_at"=>Carbon::now(),
            "created_at"=>Carbon::now(),
            "ttype"=>$ttype

        ];
        if ($ttype!="treport") {
            $to_update["checker_user_id"]=$user->id;
            $to_update["checker_location_id"]=$r->location_id;
            $to_update["checker_company_id"]=$r->company_id;
        }
        /*Create a QR*/ 
        $report_id=DB::table('stockreport')->insertGetId($to_update);
        $ret['status']='success';
        $ret['report_id']=$report_id;
        $ret['report_number']=NULL;   
        return response()->json($ret);
    }

    /*
    @input : $user,$r is an key-value array
    @output: Report number int
    */
    public function get_report_number($r=array())
    {
        
       try {
            //$creator_user_id=$user->id;
            $owner_user_id=DB::table("fairlocation")->
                where("id",$r->location_id)->
                pluck("user_id");

            if (empty($owner_user_id)) {
                return 0;
            }
            /* For testing purposes */
          /*  $owner_user_id=378; */
            
            /**************/ 
            $report_no=1;
            $prev=DB::table("stockreport")->
                join("company","company.id","=",
                    "stockreport.creator_company_id")->

                where("company.owner_user_id",$owner_user_id)->
                whereNull("stockreport.deleted_at")->
                where("stockreport.status","confirmed")->
                orderBy("stockreport.created_at","DESC")->
                select("stockreport.report_no")->
                first();
            if (!empty($prev)) {
                $report_no=$prev->report_no+1;
            }
            return $report_no;
       } catch (\Exception $e) {
           Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
       }

        /*ALL CODE BELOW IS USEFUL ZUREZ*/

        /* Delete useless Stockreports */
        /*DB::table("stockreport")->
            join("fairlocation","fairlocation.id","=",
                "stockreport.creator_location_id")->
            leftJoin("stockreportproduct","stockreport.id","=",
                "stockreportproduct.stockreport_id")->
            where("fairlocation.user_id",$owner_user_id)->
            //where('stockreport.creator_user_id',$creator_user_id)->
            whereNull("stockreportproduct.id")->
            whereNull("stockreportproduct.deleted_at")->
            delete();*/

        /*$ts=DB::table("stockreport")->
            join("fairlocation","fairlocation.id","=",
                "stockreport.creator_location_id")->
            where("fairlocation.user_id",$owner_user_id)->
            whereNull("stockreport.deleted_at")->
            whereNull("fairlocation.deleted_at")->
            get();

        foreach ($ts as $t) {
            $smp=DB::table("stockreportproduct")->
                where("stockreport_id",$t->id)->
                whereNull("deleted_at")->
                first();

            if (empty($smp)) {
                DB::table("stockreport")->
                    where("id",$t->id)->
                    //where("creator_user_id",$t->creator_user_id)->
                    update([
                        "report_no"=>NULL,
                        "updated_at"=>Carbon::now(),
                        "deleted_at"=>Carbon::now()
                    ]);
            }
        }*/

        /* RECOVERY SECTION */
        $total_stockreport_records=DB::table("stockreport")->
            join("company","company.id","=",
                "stockreport.creator_company_id")->

            where("company.owner_user_id",$owner_user_id)->
            
            //groupBy("stockreport.report_no")->
            select("stockreport.*")->
            whereNull("stockreport.deleted_at")->
            get();
        //return $total_stockreport_records;
        $total_stockreports=count($total_stockreport_records);
        
        $max_stockreport=DB::table("stockreport")->
            join("fairlocation","fairlocation.id","=",
                "stockreport.creator_location_id")->
            join("stockreportproduct","stockreport.id","=",
                "stockreportproduct.stockreport_id")->
            where("fairlocation.user_id",$owner_user_id)->
            orderBy("stockreport.id","DESC")->
            select("stockreport.*")->
            whereNull("stockreport.deleted_at")->
            first();

        $uniq = array();

		Log::debug('total_stockreports='.$total_stockreports);
		Log::debug('max_stockreport='.json_encode($max_stockreport));

        $run_recovery=False;

        if (!empty($max_stockreport) &&
            $total_stockreports != $max_stockreport->report_no) {
            $run_recovery=True;
        }
        while (!$run_recovery) {
            $p=0;
            foreach ($total_stockreport_records as $t) {
                try {
                    if ($t->report_no==$p) {
                        $run_recovery=True;
                    }else{
                        $p=$t->report_no;
                    }
                } catch (\Exception $e) {
                    
                }
            }
        }
        if($run_recovery){
			Log::debug('*** INSIDE RECOVERY ***');

            /* Prepare datastructure of unique report_no and possible
             * stockreport_id that has the same report_no */
            $i=1;
            foreach ($total_stockreport_records as $k) {

                DB::table("stockreport")->
                where("id",$k->id)->
                update([ "report_no" => $i ,"updated_at"=>Carbon::now()]);
                $i++;
                /* This is a case where report_no is the SAME but valid
                 * with products!! */
                $latest= DB::table("stockreport")->
                    join("fairlocation","fairlocation.id","=",
                        "stockreport.creator_location_id")->
                    where("report_no", $k->report_no)->
                    where("fairlocation.user_id",$owner_user_id)->
                    whereNull("stockreport.deleted_at")->
                    select("stockreport.*")->
                    orderBy("stockreport.id")->
                    first();

                $validrecs = DB::table("stockreport")->
                    join("fairlocation","fairlocation.id","=",
                        "stockreport.creator_location_id")->
                    where("stockreport.report_no", $k->report_no)->
                    where("stockreport.id","!=",$latest->id)->
                    where("fairlocation.user_id",$owner_user_id)->
                    whereNull("stockreport.deleted_at")->
                    select("stockreport.*")->
                    orderBy("stockreport.id")->
                    get();

                /*$procs = array_map(function($v){return $v->id;}, $validrecs);
                $uniq[$k->report_no] = $procs;*/

               
               /* Log::debug($procs);*/
                /*
                dump($validrecs);
                */
            }

			//Log::debug($uniq);
 
            # Recovery
            /*$i=1;
            foreach ($uniq as $k => $v) {
                if (!empty($v) and count($v) > 0) {
                    foreach ($v as $pid) {
                        DB::table("stockreport")->
                            where("id",$pid)->
                            update([ "report_no" => $i ]);

						Log::debug('report_no='.$i);
                        $i++; 
                    }
                }
            }*/
        }
 
        /*****************/
        $sm=DB::table("stockreport")->
            join("fairlocation","fairlocation.id","=",
                "stockreport.creator_location_id")->
            join("stockreportproduct","stockreportproduct.stockreport_id","=",
                "stockreport.id")->
            where("fairlocation.user_id",$owner_user_id)->
            orderBy("stockreport.report_no","DESC")->
            select("stockreport.*")->
            whereNull("stockreport.deleted_at")->
            first();

        if (!empty($sm)) {
            $report_no = $sm->report_no + 1;
            /*Log::debug("***************  user_id=".$creator_user_id.' *****************');*/
            Log::debug("BEFORE while: report_no=".$report_no);
            $continue=false;

            while (!$continue) {
                $does_exist=DB::table("stockreport")->
                join("fairlocation","fairlocation.id","=",
                    "stockreport.creator_location_id")->
                where("fairlocation.user_id",$owner_user_id)->
                where("stockreport.report_no",$report_no)->
                orderBy("stockreport.id","DESC")->
                select("stockreport.*")->
                whereNull("stockreport.deleted_at")->
                first();

                if (empty($does_exist)) {
                   /* Log::debug("Zero record; report_no=".$report_no.
						",  creator_user_id=".$creator_user_id);*/
                    $continue=true;
                } else {
                    Log::debug("Found record; stockreport.id=".
						$does_exist->id.", report_no=".$report_no);
                    $report_no++;
                    Log::debug("Incrementing to: report_no=".$report_no);
                }
            }
            Log::debug("AFTER while: report_no=".$report_no);
        }

        return $report_no;
        //return $report_no;
        /*******************/

/*        $ttype="treport";
        if ($r->has("ttype") and !empty($ttype)) {
            $ttype=$r->ttype;
        }
        $to_update=[
            "creator_user_id"=>$user->id,
            "creator_company_id"=>$r->company_id,
            "creator_location_id"=>$r->location_id,
            "status"=>"pending",
            "report_no"=>$report_no,
            "updated_at"=>Carbon::now(),
            "created_at"=>Carbon::now(),
            "ttype"=>$ttype

        ];
        if ($ttype!="treport") {
            $to_update["checker_user_id"]=$user->id;
            $to_update["checker_location_id"]=$r->location_id;
            $to_update["checker_company_id"]=$r->company_id;
        }

        $report_id=DB::table('stockreport')->insertGetId($to_update);
        $ret['status']='success';
        $ret['report_id']=$report_id;
        $ret['report_number']=$report_no;   
        return response()->json($ret);

        return $report_id;*/
    }


    public function report_confirm($r)
    {
        $ret=array();
        $ret['status']="failure";
        $confirm_mode="checker";
        $user = JWTAuth::parseToken()->authenticate();
        if (empty($user) ) {
            return response()->json($ret);
        }


        $report=DB::table("stockreport")->where("id",$r->rid)
            ->first();
        $is_location_warehouse=DB::table("fairlocation")
        ->join("warehouse","warehouse.location_id","=","fairlocation.id")
        ->whereNull("fairlocation.deleted_at")
        ->whereNull("warehouse.deleted_at")
        ->where("fairlocation.id",$r->creator_location_id)
        ->first();
        if (empty($report) or $report->status=="confirmed") {
            return response()->json(["error"=>"Bad Report Number"],501);
        }

        if (
			 empty($r->rack_no) and !empty($is_location_warehouse)) {
            return response()->json(["error"=>"Rack No. is required"],522);
        }

        if ($report->ttype=="treport" and
		   (empty($report->checker_location_id) or
		    $report->checker_location_id==$report->creator_location_id)) {
            return response()->json(["error"=>"Same location not allowed"],502);
        }

        try {

            /*Get report number*/
            $kvarray=(object)array();
            $kvarray->location_id=$report->creator_location_id;
            $report_number=$this->get_report_number($kvarray,$user);
            if (empty($report_number)) {
                Log::debug("Report Number Is NULL");
                Log::debug("KV Array passed ");
                Log::debug(serialize($kvarray));
            }
            $to_update=[
                "status"=>"confirmed",
                "updated_at"=>Carbon::now(),
                "checked_on"=>Carbon::now(),
                "report_no"=>$report_number,
                "ttype"=>$report->ttype
            ];

            Log::info("Data to be updated for report.id= ".$report->id);
            if (empty($report->checker_user_id)) {
                $to_update["checker_user_id"]=$report->creator_user_id;
                $to_update["checker_company_id"]=$report->creator_company_id;
                $to_update["checker_location_id"]=$report->creator_location_id;
                $confirm_mode="creator";
            }

            if ($report->ttype!="treport") {
                $confirm_mode="creator";
            }

            Log::info("****************************************");
            Log::info("Updating stockreport table for report id ".$report->id);
            Log::info("Confirm Mode ".$confirm_mode);

            /* Handle the confirm action */
            
            $validate=DB::table("stockreportproduct")
                ->where("stockreport_id",$report->id)
                ->whereNull("deleted_at")
                ->where("stockreportproduct.status","!=","checked")
                ->whereNotNull("product_id")
                ->first();

            if (!empty($validate) and $report->ttype=="treport") {
                $ret["error"]="All products not checked";
                return response($ret,510);
            }

            DB::table('stockreport')
            ->where('id',$r->rid)
       
            ->update(
                $to_update
            );
            /* Add rack if needed */
            if (!empty($r->rack_no)) {
                # Assuming only 1 rack number per stockreport
                /* Confirm if it is a warehouse and get rack.id*/
                Log::debug("Rack Number ".$r->rack_no);
                $rack=DB::table("warehouse")
                ->join("rack","rack.warehouse_id","=","warehouse.id")
                ->whereNull("warehouse.deleted_at")
                ->whereNull("rack.deleted_at")
                

                ->where("rack.rack_no",$r->rack_no)
                ->where("warehouse.location_id",$report->creator_location_id)
              
                ->select("rack.id")
                ->orderBy("rack.created_at","DESC")
                ->first();
                if(!empty($rack)){
                    Log::info("Writing in stockreportrack for stockreport ".$report->id." for rack ".$rack->id);
                    DB::table("stockreportrack")
                    ->insert([
                        "rack_id"=>$rack->id,
                        "stockreport_id"=>$report->id,
                        "updated_at"=>Carbon::now(),
                        "created_at"=>Carbon::now()
                        ]);
                }
                
                
            }
            $stockreportproducts=DB::table("stockreportproduct")
                ->where("stockreport_id",$report->id)
                ->whereNull("deleted_at")
                
                ->whereNotNull("product_id")
                ->get();
            $merchant_user_id=DB::table("company")->where("id",$report->checker_company_id)->pluck("owner_user_id");
            $merchant_id=DB::table("merchant")->where("user_id",$merchant_user_id)->pluck("id");
            
            foreach ($stockreportproducts as $sp) {

               Log::info("Processing stockreportproduct.id ".$sp->id);
               $received=$sp->quantity;
               try {
                    switch ($report->ttype) {
                    case 'treport':
                      $received=$sp->received;
                      /* Handle Checker Validation */
                      /*DISABLED TEMP TILL DEMO 
                      if (!empty($report->checker_company_id) and !empty($report->checker_location_id) and !empty($r->location_id) and $r->location_id!=$report->checker_location_id) {
                         
                           $ret["error"]="Invalid location_id";
                           $ret["debug"]=[
                           $report->checker_company_id,
                           $report->checker_location_id,
                           $r->location_id

                           ];
                           return response()->json($ret,506); 
                       } */
                      $this->handle_treport($sp,$report);
                      break;
                    case 'tin':
                      $this->handle_tin_tout($sp,$report);
                      break;
                    case 'tout':
                        $this->handle_tin_tout($sp,$report);
                        break;
                    case 'stocktake':
                        $this->handle_stocktake($sp,$report);
                        break;
                    case 'wastage':
                         $this->handle_wastage($sp,$report);
                        # code...
                        break;
                      default:
                            
                          break;
                    }

                    DB::table("stockreportproduct")->where("id",$sp->id)
                        ->update([
                            "received"=>$received,
                            "status"=>"checked",
                            "updated_at"=>Carbon::now()
                    ]);
                   

                   
               } catch (\Exception $e) {

                   Log::info("Exception occured for Stockreport Id ".$sp->id);
                   Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
               }
            }

            Log::info("***************************************");

        } catch (\Exception $e) {
            Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
            $ret["error"]=$e->getMessage();
        }
        return response()->json($ret);

    }
    public function report_confirm_bulk($r)
    {
        $ret=array();
        $ret['status']="failure";
        $confirm_mode="checker";
 
        
        $user = JWTAuth::parseToken()->authenticate();
        if (empty($user) ) {
            return response()->json($ret);
        }
        if (!$r->has('products') or empty($r->products)) {
            Log::info("No product was found in request for ".$r->rid);
            return response()->json(["error"=>"Bad Request"],501);
        }


        $report=DB::table("stockreport")->where("id",$r->rid)
            ->first();

        if (empty($report) or $report->status=="confirmed") {
            return response()->json(["error"=>"Bad Report Number"],501);
        }

        if ($report->ttype=="treport" and (empty($report->checker_location_id) or $report->checker_location_id==$report->creator_location_id)) {
            # code...
            return response()->json(["error"=>"Same location not allowed"],502);
        }
        try {
            $to_update=[
                
                "status"=>"confirmed",
                "updated_at"=>Carbon::now(),
                "checked_on"=>Carbon::now(),
                "ttype"=>$report->ttype
            ];
            if (empty($report->checker_user_id)) {
                $to_update["checker_user_id"]=$report->creator_user_id;
                $to_update["checker_company_id"]=$report->creator_company_id;
                $to_update["checker_location_id"]=$report->creator_location_id;
                $confirm_mode="creator";
            }

            if ($report->ttype!="treport") {
                $confirm_mode="creator";
            }

            Log::info("****************************************");
            Log::info("Insertin in  stockreport table for report id ".$report->id);
            Log::info("Confirm Mode ".$confirm_mode);

            /* Mass Insert only if not WarehouseST*/
            $is_location_warehouse=UtilityController::is_location_warehouse($report->creator_location_id);
            $is_warehouse_st=False;
            if (!empty($is_location_warehouse) and $report->ttype=="stocktake") {
                # code...
                $is_warehouse_st=True;
                Log::debug("Location is Warehouse ".$is_location_warehouse->id);
            }
            $products_to_be_inserted=$r->products;
                   foreach ($products_to_be_inserted as $product) {
                       
                       $this->report_add_product($product,$report,$is_warehouse_st);
                   }
       
           /*exit();*/
            DB::table('stockreport')
            ->where('id',$r->rid)
       
            ->update(
                $to_update
            );

            $stockreportproducts=DB::table("stockreportproduct")
                ->where("stockreport_id",$report->id)
                ->whereNull("deleted_at")
                
                ->whereNotNull("product_id")
                ->get();
            $merchant_user_id=DB::table("company")->where("id",$report->checker_company_id)->pluck("owner_user_id");
            $merchant_id=DB::table("merchant")->where("user_id",$merchant_user_id)->pluck("id");
            
            foreach ($stockreportproducts as $sp) {

               Log::info("Processing stockreportproduct.id ".$sp->id);

               $received=$sp->quantity;
               try {
                    switch ($report->ttype) {
                    case 'treport':
                      $received=$sp->received;
                      /* Handle Checker Validation 
                      if (!empty($report->checker_company_id) and $r->location_id!=$report->checker_location_id) {
                         
                           $ret["error"]="Invalid location_id";
                           
                           return response()->json($ret,506); 
                       } */
                      $this->handle_treport($sp,$report);
                      break;
                    case 'tin':
                      $this->handle_tin_tout($sp,$report);
                      break;
                    case 'tout':
                        $this->handle_tin_tout($sp,$report);
                        break;
                    case 'stocktake':
                        $this->handle_stocktake($sp,$report);
                        break;
                    case 'wastage':
                        $this->handle_wastage($sp,$report);
                        # code...
                        break;
                      default:
                            
                          break;
                    }
                    if ($report->ttype!="wastage") {
                        # code...
                        $sp_data=[
                            "received"=>$received,
                            "status"=>"checked",
                            "updated_at"=>Carbon::now()
                        ];
                    
                        DB::table("stockreportproduct")->where("id",$sp->id)
                        ->update($sp_data);
                    }
                   

                   
               } catch (\Exception $e) {

                   Log::info("Exception occured for Stockreport Id ".$sp->id);
                   Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
               }
            }

            Log::info("***************************************");

        } catch (\Exception $e) {
            Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
            $ret["error"]=$e->getMessage();
        }
        return response()->json($ret);

    }


    public function handle_treport($s,$report)
    {
        $consignment=$s->received;
        $merchant_id=UtilityController::productMerchantId($s->product_id);
         $company_id=DB::table("merchant")->join("company","company.owner_user_id","=","merchant.user_id")
         ->where("merchant.id",$merchant_id)
         ->pluck("company.id");
        $product=DB::table("product")
         ->join("merchantproduct","merchantproduct.product_id","=","product.id")
         ->where("product.parent_id",$s->product_id)
         ->where("merchantproduct.merchant_id",$merchant_id)

         ->whereNull("product.deleted_at")
         ->select("product.*")->first();

         $old_lp_creator=DB::table("locationproduct")->where("product_id",$product->id)->where("location_id",$report->creator_location_id)
        ->orderBy("created_at","DESC")
         ->whereNull("deleted_at")->first();
         $ob_creator=$old_lp_creator->quantity-$s->quantity;
            DB::table("locationproduct")
                 ->insert(
                        [
                            "product_id"=>$product->id,
                            "location_id"=>$report->creator_location_id,
                            "stocktransfer_id"=>$report->id,
                            "quantity"=>$ob_creator,
                            "created_at"=>Carbon::now(),
                            "updated_at"=>Carbon::now()
                        ]
            );
      
         /*
         Snapshot

         if same company different location then subtract from one and add to another.
         if different company , do same , but make sure the product_id is correct.
         */
      
        if ($report->checker_company_id!=$report->creator_company_id) {
            /* Change the product_id */
            $checker_owner_user_id=DB::table("company")->where("id",$report->checker_company_id)->pluck("owner_user_id");
            $checker_merchant_id=DB::table("merchant")
            ->where("user_id",$checker_owner_user_id)->whereNull("deleted_at")
            ->orderBy("created_at","DESC")->pluck("id");
            $product=DB::table("product")
            ->join("merchantproduct","merchantproduct.product_id","=","product.id")
            ->where("product.parent_id",$s->product_id)
            ->where("merchantproduct.merchant_id",$checker_merchant_id)
            ->whereNull("product.deleted_at")
            ->whereNull("merchantproduct.deleted_at")
            ->orderBy("product.created_at","DESC")
            ->select("product.*")
            ->first();

        }

        
            $old_lp_checker=DB::table("locationproduct")->where("product_id",$product->id)->where("location_id",$report->checker_location_id)
            ->orderBy("created_at","DESC")
            ->whereNull("deleted_at")->first();
            $ob_checker=$consignment;
            if (!empty($old_lp_checker)) {
                $ob_checker=$old_lp_checker->quantity+$s->received;
            }
            DB::table("locationproduct")
             ->insert(
                    [
                        "product_id"=>$product->id,
                        "location_id"=>$report->checker_location_id,
                        "stocktransfer_id"=>$report->id,
                        "quantity"=>$ob_checker,
                        "created_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                    ]
        );
    }

    public function handle_tin_tout($s,$report)
    {
        $consignment=$s->quantity;
        /*Dummy*/
        Log::info("product_id ".$s->product_id);
        $merchant_id=UtilityController::productMerchantId($s->product_id);
        $product=DB::table("product")
         ->join("merchantproduct","merchantproduct.product_id","=","product.id")
         ->where("product.id",$s->product_id)
         ->where("merchantproduct.merchant_id",$merchant_id)

         ->whereNull("product.deleted_at")
         ->select("product.*")->first();

                     
         /*
         Snapshot
            
         */
         $old_lp=DB::table("locationproduct")->where("product_id",$product->id)->where("location_id",$report->creator_location_id)
         ->whereNull("deleted_at")
         ->orderBy("created_at","DESC")
         ->first();
         $old_ob=0;
         $ob=0;
         if (!empty($old_lp)) {
             if ($report->ttype=="tin") {
                 # code...
                $ob=$old_lp->quantity+$consignment;
             }else{
                try {
                    $ob=$old_lp->quantity-$consignment;
                } catch (\Exception $e) {
                    $ob=0;
                    Log::info("Exception ".$e->getMessage());
                }
                
             }
             
            
         }else{
            if ($report->ttype=="tin") {
                # code...
                $ob=$consignment;
            }
            
         }

        DB::table("locationproduct")
        ->insert(
        [
            "product_id"=>$product->id,
            "location_id"=>$report->creator_location_id,
            "stocktransfer_id"=>$report->id,
            "quantity"=>$ob,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ]
        );
    }

    public function handle_wastage($stockreportproduct,$report)
    {
        $location_id=$report->creator_location_id;
        $product_id=$stockreportproduct->product_id;
        $quantity=$stockreportproduct->received;
        UtilityController::locationproduct($location_id,$product_id,$quantity,"minus");
    }
    public function handle_stocktake($s,$report)
    {
        $consignment=$s->opening_balance-$s->quantity;

        $ob=$s->quantity;
        DB::table("locationproduct")
        ->insert(
        [
            "product_id"=>$s->product_id,
            "location_id"=>$report->creator_location_id,
            "stocktransfer_id"=>$report->id,
            "quantity"=>$ob,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ]
        );
    }

    public function report_confirm1($r)
    {
        $ret=array();

        $ret['status']="failure";
        // $ret['long_message']="Validation failure";
        $user = JWTAuth::parseToken()->authenticate();
        if (empty($user) ) {
            return response()->json($ret);
        }
        $confirm_mode="checker";
        $report_id_sent_via_request=$r->rid;
        $report=DB::table('stockreport')
            ->where('id',$r->rid)
            // ->where('checker_user_id',$user->id)
            ->first();
        
        if (empty($report) or $report->status=="confirmed") {
            return response()->json(["error"=>"Bad Report Number"],501);
        }

        if ($report->ttype=="treport" and (empty($report->checker_location_id) or $report->checker_location_id==$report->creator_location_id)) {
            # code...
            return response()->json(["error"=>"Same location not allowed"],502);
        }

        // if ($report->ttype=="treport" and (empty($report->checker_location_id) or $report->checker_location_id==$report->creator_location_id)) {
        //     # code...
        //     return response()->json(["error"=>"Same location not allowed"],502);
        // }

        try {
         
            $to_update=[
                
                "status"=>"confirmed",
                "updated_at"=>Carbon::now(),
                "checked_on"=>Carbon::now(),
                "ttype"=>$report->ttype
            ];
                     
            if (empty($report->checker_user_id)) {
                $to_update["checker_user_id"]=$report->creator_user_id;
                $to_update["checker_company_id"]=$report->creator_company_id;
                $to_update["checker_location_id"]=$report->creator_location_id;
                $confirm_mode="creator";
            }

            if ($report->ttype!="treport") {
                $confirm_mode="creator";
            }
            Log::info("****************************************");
            Log::info("Updating stockreport table for report id ".$report->id);
            Log::info(serialize($to_update));


            DB::table('stockreport')
            ->where('id',$r->rid)
       
            ->update(
                $to_update
            );


            $stockreportproducts=DB::table("stockreportproduct")
                ->where("stockreport_id",$report_id_sent_via_request)
                ->whereNull("deleted_at")
                ->get();
            $merchant_user_id=DB::table("company")->where("id",$report->checker_company_id)->pluck("owner_user_id");
            $merchant_id=DB::table("merchant")->where("user_id",$merchant_user_id)->pluck("id");
            Log::info("Merchant ID for Checker Confirm ".$merchant_id);
            /*Update Consignment*/
            if($report->ttype=="tin"){
                              
                
                foreach ($stockreportproducts as $s) {
                    if ($confirm_mode=="creator") {
                        # code...
                        DB::table("stockreportproduct")->where("id",$s->id)
                        ->update([
                            "received"=>$s->quantity,
                            "status"=>"checked",
                            "updated_at"=>Carbon::now()
                            ]);
                        
                    }
                    ;
                    $consignment=$s->received;
                    if ($confirm_mode=="creator") {
                        $consignment=$s->quantity;
                    }
                    DB::table("product")
                     ->join("merchantproduct","merchantproduct.product_id","=","product.id")
                     ->where("product.parent_id",$s->product_id)
                     ->where("merchantproduct.merchant_id",$merchant_id)
                     ->whereNull("product.deleted_at")
                     ->update([
                        "product.updated_at"=>Carbon::now(),
                        "product.consignment"=>DB::raw("consignment+$consignment")
                    ]);

                     $product=DB::table("product")
                     ->join("merchantproduct","merchantproduct.product_id","=","product.id")
                     ->where("product.parent_id",$s->product_id)
                     ->where("merchantproduct.merchant_id",$merchant_id)

                     ->whereNull("product.deleted_at")
                     ->select("product.*")->first();

                     
                     /*
                     Snapshot
                        
                     */
                     $old_lp=DB::table("locationproduct")->where("product_id",$product->id)->where("location_id",$report->creator_location_id)
                     ->whereNull("deleted_at")
                     ->orderBy("created_at","DESC")
                     ->first();
                     $old_ob=0;
                     $ob=0;
                     if (!empty($old_lp)) {
                         $ob=$old_lp->quantity+$consignment;
                        
                     }else{
                        $ob=$consignment;
                     }

                    DB::table("locationproduct")
                         ->insert(
                                [
                                    "product_id"=>$product->id,
                                    "location_id"=>$report->creator_location_id,
                                    "stocktransfer_id"=>$report->id,
                                    "quantity"=>$ob,
                                    "created_at"=>Carbon::now(),
                                    "updated_at"=>Carbon::now()
                                ]
                    );

               
                     /**/ 
                } 
            }elseif ($report->ttype=="stocktake") {
                foreach ($stockreportproducts as $s) {
                    

                    
                    
                    if ($report->creator_company_id==$report->checker_company_id) {
                        $consignment=0;
                    }
                    if ($confirm_mode=="creator") {
                        # code...
                        DB::table("stockreportproduct")->where("id",$s->id)
                        ->update([
                            "received"=>$s->quantity,
                            "status"=>"checked",
                            "updated_at"=>Carbon::now()
                            ]);
                        $consignment=$s->opening_balance-$s->quantity;
                    }
                    ;

                    Log::info("Consignment value ".$consignment);
                    try {
                        DB::table("product")
                        ->join("merchantproduct","merchantproduct.product_id","=","product.id")
                        ->where("product.parent_id",$s->product_id)
                        ->where("merchantproduct.merchant_id",$merchant_id)
                        ->whereNull("product.deleted_at")
                        ->update([
                        "product.updated_at"=>Carbon::now(),
                        "product.consignment"=>DB::raw("consignment-$consignment")
                        ]);


                    $product=DB::table("product")
                     ->join("merchantproduct","merchantproduct.product_id","=","product.id")
                     ->where("product.parent_id",$s->product_id)
                     ->where("merchantproduct.merchant_id",$merchant_id)

                     ->whereNull("product.deleted_at")
                     ->select("product.*")->first();
                     /*
                     Snapshot
                        
                     */
                     $old_lp=DB::table("locationproduct")->where("product_id",$product->id)->where("location_id",$report->creator_location_id)
                     ->whereNull("deleted_at")->
                     orderBy("created_at","DESC")
                     ->first();
                     $old_ob=0;
                     $ob=0;
                     // $consignment=$s->opening_balance-$s->quantity;
                     if (!empty($old_lp)) {
                        /*In case there is loss*/ 
                         // $ob=$old_lp->quantity-$s->quantity;
                        $ob=$s->quantity;
                     }

                    DB::table("locationproduct")
                    ->insert(
                    [
                        "product_id"=>$product->id,
                        "location_id"=>$report->creator_location_id,
                        "stocktransfer_id"=>$report->id,
                        "quantity"=>$ob,
                        "created_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                    ]
                    );

               
                     /**/ 
                    } catch (\Exception $e) {
                        Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
                    }

                     
                }
            }elseif ($report->ttype=="tout") {
                foreach ($stockreportproducts as $s) {
                    Log::info("Consignment update for parent_id ".$s->product_id);
                    $consignment=$s->received;
                    if ($report->creator_company_id==$report->checker_company_id) {
                        $consignment=$s->quantity;
                    }
                    if ($confirm_mode=="creator") {
                        # code...
                        DB::table("stockreportproduct")->where("id",$s->id)
                        ->update([
                            "received"=>$s->quantity,
                            "status"=>"checked",
                            "updated_at"=>Carbon::now()
                        ]);
                        
                    }
                    ;

                    Log::info("Consignment value ".$consignment);
                    try {
                        DB::table("product")
                        ->join("merchantproduct","merchantproduct.product_id","=","product.id")
                        ->where("product.parent_id",$s->product_id)
                        ->where("merchantproduct.merchant_id",$merchant_id)
                        ->whereNull("product.deleted_at")
                        ->update([
                        "product.updated_at"=>Carbon::now(),
                        "product.consignment"=>DB::raw("consignment-$consignment")
                        ]);
                    $product=DB::table("product")
                     ->join("merchantproduct","merchantproduct.product_id","=","product.id")
                     ->where("product.parent_id",$s->product_id)
                     ->where("merchantproduct.merchant_id",$merchant_id)

                     ->whereNull("product.deleted_at")
                     ->select("product.*")->first();
                     /*
                     Snapshot
                        
                     */
                     $old_lp=DB::table("locationproduct")->where("product_id",$product->id)->where("location_id",$report->creator_location_id)
                        ->orderBy("created_at","DESC")
                     ->whereNull("deleted_at")->first();
                     $old_ob=0;
                     $ob=0;
                     if (!empty($old_lp)) {
                         $ob=$old_lp->quantity-$consignment;
                        
                     }

                     DB::table("locationproduct")
                         ->insert(
                                [
                                    "product_id"=>$product->id,
                                    "location_id"=>$report->creator_location_id,
                                    "stocktransfer_id"=>$report->id,
                                    "quantity"=>$ob,
                                    "created_at"=>Carbon::now(),
                                    "updated_at"=>Carbon::now()
                                ]
                            );

               
                     /**/ 

                    } catch (\Exception $e) {
                        Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
                    }

                     
                }
            }elseif ($report->ttype=="treport") {
                if ($report->creator_location_id==$report->checker_location_id or empty($report->checker_location_id) ){return response()->json(["error"=>"Locations should be different"],502);

                   
                }

                foreach ($stockreportproducts as $s) {
                    /* Find if to delete or add*/
                    try {
                         $consignment=$s->received;
                        /* Obsolete
                         if ($confirm_mode=="creator") {
                             DB::table("stockreportproduct")->where("id",$s->id)
                            ->update([
                                "received"=>$s->quantity,
                                "status"=>"checked",
                                "updated_at"=>Carbon::now()
                                ]);
                            $consignment=$s->quantity;
                            Log::info("Creator Mode for treport");

                         }

                         */
                         $merchant_id=UtilityController::productMerchantId($s->product_id);
                         $company_id=DB::table("merchant")->join("company","company.owner_user_id","=","merchant.user_id")
                         ->where("merchant.id",$merchant_id)
                         ->pluck("company.id");
                      
                       

                        /**/ 
                     $product=DB::table("product")
                     ->join("merchantproduct","merchantproduct.product_id","=","product.id")
                     ->where("product.parent_id",$s->product_id)
                     ->where("merchantproduct.merchant_id",$merchant_id)

                     ->whereNull("product.deleted_at")
                     ->select("product.*")->first();



                     /*
                     Snapshot

                     if same company different location then subtract from one and add to another.
                        
                     */
                  
                    $old_lp_creator=DB::table("locationproduct")->where("product_id",$product->id)->where("location_id",$report->creator_location_id)
                    ->orderBy("created_at","DESC")
                     ->whereNull("deleted_at")->first();

                    $ob_creator=$old_lp_creator->quantity-$s->quantity;
                    DB::table("locationproduct")
                         ->insert(
                                [
                                    "product_id"=>$product->id,
                                    "location_id"=>$report->creator_location_id,
                                    "stocktransfer_id"=>$report->id,
                                    "quantity"=>$ob_creator,
                                    "created_at"=>Carbon::now(),
                                    "updated_at"=>Carbon::now()
                                ]
                    );
                  
                        $old_lp_checker=DB::table("locationproduct")->where("product_id",$product->id)->where("location_id",$report->checker_location_id)
                        ->orderBy("created_at","DESC")
                        ->whereNull("deleted_at")->first();
                        $ob_checker=$consignment;
                        if (!empty($old_lp_checker)) {
                            $ob_checker=$old_lp_checker->quantity+$s->received;
                        }
                        DB::table("locationproduct")
                         ->insert(
                                [
                                    "product_id"=>$product->id,
                                    "location_id"=>$report->checker_location_id,
                                    "stocktransfer_id"=>$report->id,
                                    "quantity"=>$ob_checker,
                                    "created_at"=>Carbon::now(),
                                    "updated_at"=>Carbon::now()
                                ]
                    );
                    

                     

                    

               
                     /**/ 

                     } catch (\Exception $e) {
                        Log::info($e);
                         // Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());

                     } 
                }
            }
            $ret['status']='success';
            $ret['debug']=[$report->ttype,$confirm_mode];
        } catch (\Exception $e) {
            Log::error("function_name():".$e->getFile().":".$e->getLine().":".$e->getMessage());
            $ret['error']=$e->getMessage();   
        }
        
        return response()->json($ret);
    }

    public function report_update($r,$report)
    {
        if ($report->status=="confirmed") {
            return response()->json(['status'=>'failure'],500);
        }
        $report_id=$report->id;
        $product_id=$r->pid;
        $quantity=$r->quantity;
        Log::info("Quantity ".$quantity);
         /* Handle Checker Validation */

    /*  if (!empty($report->checker_company_id) and $r->location_id!=$report->checker_location_id) {
           
           $ret["error"]="Invalid location_id";
           
           return response()->json($ret,506); 
       } */
        $product=DB::table("product")->where("id",$product_id)->first();

        $lp=DB::table("locationproduct")->where("location_id",$report->creator_location_id)->where("product_id",$product_id)
            ->orderBy("created_at","DESC")->first();   
        $opening_balance=$quantity;
        if (!empty($lp)) {
            $opening_balance=$lp->quantity;
        }
        /* Validation */ 
        $available_quantity=DB::table("locationproduct")->where("location_id",$report->creator_location_id)->where("product_id",$product_id)
            ->orderBy("locationproduct.created_at","DESC")
            ->pluck("quantity");
        Log::debug($available_quantity);
        if ($report->ttype=="tout" or ($r->mode=="creator" and $report->ttype!="tin")) {
            
            if ($available_quantity<1 or $quantity>$available_quantity) {
                if (empty($available_quantity)) {
                    $available_quantity=0;
                }
                return response()->json(['status'=>'failure',"long_message"=>"Insufficient stock. ".$available_quantity." units left.",
                    "debug"=>[$report->ttype]
                    ],509);
            }
        }
        /*Validation for Warehouse rack number*/
        $is_location_warehouse=DB::table("fairlocation")
        ->join("warehouse","warehouse.location_id","=","fairlocation.id")
        ->whereNull("fairlocation.deleted_at")
        ->whereNull("warehouse.deleted_at")
        ->where("fairlocation.id",$report->creator_location_id)
        ->select("warehouse.id")
        ->first();
       

        if (
             empty($r->rack_no) and !empty($is_location_warehouse)
             and $report->ttype!="tin"
             ) {
            return response()->json(["error"=>"Rack No. is required"],522);
        }

        if (!empty($is_location_warehouse) and ($report->ttype=="tout" || $report->ttype=="stocktake")) {

            $query="SELECT
                
                    
                    SUM(
                        CASE

                            WHEN stockreport.ttype=NULL then 0
                            WHEN stockreport.ttype = 'stocktake' THEN
                            CAST(stockreportproduct.received as SIGNED)-CAST(stockreportproduct.opening_balance AS SIGNED)
                                
                            WHEN stockreport.ttype='tin' then stockreportproduct.quantity
                            WHEN stockreport.ttype='tout' then - stockreportproduct.quantity
                            WHEN stockreport.ttype='treport' then 
                               CASE WHEN 
                                    stockreport.creator_location_id=".$report->creator_location_id."
                                    THEN -stockreportproduct.quantity
                                    ELSE
                                    stockreportproduct.quantity
                                END
                            ELSE 0
                        END
                    ) as quantity

                    FROM 
                  
                    rack
                    JOIN (SELECT DISTINCT stockreport_id,rack_id from stockreportrack) stockreportrack on stockreportrack.rack_id=rack.id


                    LEFT JOIN stockreport ON  stockreport.id= stockreportrack.stockreport_id
                    
                    LEFT JOIN stockreportproduct ON stockreportproduct.stockreport_id = stockreportrack.stockreport_id
                   


                    WHERE 
                    rack.deleted_at IS NULL
                    AND rack.warehouse_id=".$is_location_warehouse->id." 
                    AND stockreportproduct.product_id=".$product_id."
                    AND rack.rack_no=".$r->rack_no."
                    AND stockreport.status='confirmed'
                    AND stockreport.deleted_at IS NULL
                    AND stockreportproduct.deleted_at IS NULL
                    AND stockreportproduct.status='checked'
                  
                    AND stockreport.creator_location_id=".$report->creator_location_id."

                  
                  
            ";
            $q=DB::select(DB::raw($query))[0];
            $available_rack_quantity=0;
           
      
            if (!empty($q)) {
                $available_rack_quantity=$q->quantity;
                if ($available_rack_quantity<1 or $quantity>$available_rack_quantity) {
                if (empty($available_rack_quantity)) {
                    $available_rack_quantity=0;
                }

                return response()->json(['status'=>'failure',"long_message"=>"Rack has insufficient stock. ".$available_rack_quantity." units left.",
                    "debug"=>[$report->ttype]
                    ],509);
            }
            }
           /* return $query;*/
           $opening_balance=$available_rack_quantity;
        }
        Log::info("mode ".$r->mode);
        

        switch ($r->mode) {
            

            case 'creator':
                $does_exist=DB::table('stockreportproduct')
                ->join("product","stockreportproduct.product_id","=","product.id")
                ->where('product.id',$product_id)
                ->where('stockreportproduct.stockreport_id',$report_id)
                ->first();
                if (empty($does_exist)) {
                    # code...
                    $to_insert=['product_id'=>$product_id,
                            'stockreport_id'=>$report_id,
                            "updated_at"=>Carbon::now(),
                            "created_at"=>Carbon::now(),
                            "quantity"=>$quantity,
                            "opening_balance"=>$opening_balance
                            ];

                         

                    if ($report->ttype=="stocktake") {
                        $to_insert["opening_balance"]=$opening_balance;
                        $to_insert["received"]=$quantity;
                        $to_insert["status"]="checked";
                    }
                    DB::table('stockreportproduct')
                        ->insertGetId($to_insert);
                }
                else{
                    $quantity_to_update=$quantity+$does_exist->quantity;
                    if ($quantity_to_update>$available_quantity) {
                        switch ($report->ttype) {
                            case 'stocktake':
                                $quantity_to_update=$does_exist->quantity;
                                break;
                            case 'tin':
                                break;
                            default:
                                return response()->json(['status'=>'failure',"long_message"=>"Insufficient stock. ".$available_quantity." units left."],509);
                                break;
                        }
                    }
                    $to_update=[
                        "updated_at"=>Carbon::now(),
                        "quantity"=>$quantity+$does_exist->quantity
                        ];
                    if ($report->ttype=="stocktake") {
                        $to_update["opening_balance"]=$opening_balance;
                        $to_update["received"]=$quantity;
                        $to_insert["status"]="checked";
                    }

                    DB::table('stockreportproduct')
                    ->where('product_id',$product_id)
                    ->where('stockreport_id',$report_id)

                    ->update($to_update);

                }
                break;
            case 'checker':
                Log::info("checker ".$product_id);
                $does_exist=DB::table('stockreportproduct')
                ->join("product","stockreportproduct.product_id","=","product.parent_id")
                ->where('product.id',$product_id)
                ->where('stockreportproduct.stockreport_id',$report_id)
                ->first();

                if(empty($does_exist)){
                    return response()->json(['status'=>'failure','short_message'=>"Product not part of report"],501);
                }
                $user = JWTAuth::parseToken()->authenticate();
                // return response(json_encode(["t"=>[$report_id,$product_id,$quantity]]));
                $to_update=[
                    'checker_user_id'=>$user->id,
                   
                   
                    "updated_at"=>Carbon::now()

                    ];

                if ($r->has("mode") and $r->mode=="checker" and $report->checker_company_id==NULL) {
                    $to_update["checker_company_id"]=$r->company_id;


                }

                if ($r->has("mode") and $r->mode=="checker" and $report->checker_location_id==NULL) {
                    $to_update["checker_location_id"]=$r->location_id;


                }
                if ($r->has("mode") and $r->mode=="checker" and $r->location_id==$report->creator_location_id and $report->ttype==null) {
                    $to_update["ttype"]="stocktake";


                }

                DB::table('stockreport')
                ->where('id',$report->id)
                ->update($to_update);
                if ($does_exist->quantity<($quantity+$does_exist->received)) {
                    # code...
                    return response()->json(['status'=>'failure','short_message'=>"Product quantity is more than reported by creator."],502);
                }
                
                if (!empty($does_exist->received)) {
                    $quantity+=$does_exist->received;
                }
                Log::info("Final Quantity ".$quantity);

                DB::table('stockreportproduct')
                ->join("product","stockreportproduct.product_id","=","product.parent_id")
                ->where('stockreportproduct.stockreport_id',$report_id)
                ->where('product.id',$product_id)
                ->update([
                    "stockreportproduct.received"=>$quantity,
                    "stockreportproduct.status"=>"checked",
                    "stockreportproduct.updated_at"=>Carbon::now(),
                    ]);
                break;
            default:
                # code...
                break;
        }

        return response()->json(['status'=>'success']);
    }

    /*ONLY FOR treport*/

    public function report_manual_edit($request,$report)
    {
        # code...
        if ($report->ttype!="treport") {
            # code...
            return response()->json(['status'=>'failure'],500);

        }
        $report_id=$report->id;
        $data=$request->data;
        if ($report->status=="confirmed") {
            return response()->json(['status'=>'failure'],500);
        }
        /* Handle Checker Validation */
       /* if (!empty($report->checker_company_id) and $request->location_id!=$report->checker_location_id) {
          
           $ret["error"]="Invalid location_id";
           
           return response()->json($ret,506); 
       }*/

        $user = JWTAuth::parseToken()->authenticate();
        // return response(json_encode(["t"=>[$report_id,$product_id,$quantity]]));
        $to_update=[
            'checker_user_id'=>$user->id,
           
           
            "updated_at"=>Carbon::now()

            ];

        if ( $report->checker_company_id==NULL) {
            $to_update["checker_company_id"]=$request->company_id;


        }

        if ($report->checker_location_id==NULL) {
            $to_update["checker_location_id"]=$request->location_id;


        }
        DB::table('stockreport')
        ->where('id',$report->id)
        ->update($to_update);
       foreach ($data as $datum) {
            # code...
            $datum=(object)$datum;
            $datum->mode="checker";
            $this->report_manual_edit_single($datum,$report);
        } 

        return response()->json(['status'=>'success'],200);
    }
    public function report_manual_edit_single($r,$report)
    {
        
        $report_id=$report->id;
        $product_id=$r->id;
        $quantity=$r->received;
      
         
        $product=DB::table("product")->where("id",$product_id)->first();

        $lp=DB::table("locationproduct")->where("location_id",$report->creator_location_id)->where("product_id",$product_id)
            ->orderBy("created_at","DESC")->first();   
        $opening_balance=0;
        if (!empty($lp)) {
            $opening_balance=$lp->quantity;
        }
        /* Validation */ 
        $available_quantity=DB::table("locationproduct")->where("location_id",$report->creator_location_id)->where("product_id",$product_id)
            ->orderBy("locationproduct.created_at","DESC")
            ->pluck("quantity");

        Log::info("mode ".$r->mode);


        switch ($r->mode) {
            

            case 'creator':
                break;
            case 'checker':
                Log::info("checker ".$product_id);
                $does_exist=DB::table('stockreportproduct')
                ->join("product","stockreportproduct.product_id","=","product.parent_id")
                ->where('product.id',$product_id)
                ->where('stockreportproduct.stockreport_id',$report_id)
                ->first();

                if(empty($does_exist)){
                    return response()->json(['status'=>'failure','short_message'=>"Product not part of report"],501);
                }
                

                
                if ($does_exist->quantity<$quantity) {
                    # code...
                    return response()->json(['status'=>'failure','short_message'=>"Product quantity is more than reported by creator."],502);
                }
                
             
                Log::info("Final Quantity ".$quantity);

                DB::table('stockreportproduct')
                ->join("product","stockreportproduct.product_id","=","product.parent_id")
                ->where('stockreportproduct.stockreport_id',$report_id)
                ->where('product.id',$product_id)
                ->update([
                    "stockreportproduct.received"=>$quantity,
                    "stockreportproduct.status"=>"checked",
                    "stockreportproduct.updated_at"=>Carbon::now(),
                    ]);
                break;
            default:
                # code...
                break;
        }

        return response()->json(['status'=>'success']);
    }



    public function report_add_product($product,$report,$is_warehouse_st=False)
    {
       
        $report_id=$report->id;
        $product_id=$product["id"];
        $quantity=$product["received"];
        $actual_quantity=$product["quantity"];
         /* Handle Checker Validation */
     
        $product=DB::table("product")->
        where("id",$product_id)
        ->whereNull("deleted_at")
        ->first();

        if (!empty($product)) {
            # code...
        $to_update=[

            "received"=>$quantity,
            "status"=>"checked",
            "updated_at"=>Carbon::now()
            ];
        if ($is_warehouse_st) {
            Log::debug("To update the st warehouse");
            Log::debug($to_update);
           $to_update["quantity"]=$actual_quantity;
        }
        if ($report->ttype=="wastage") {
     
           $to_update["quantity"]=$actual_quantity;
           Log::debug($to_update);
        }

            DB::table("stockreportproduct")
        ->where("stockreport_id",$report_id)
        ->where("product_id",$product->id)
        ->update($to_update);
        }

        
        
    }
    public function report_list(Request $r)
    {
        $ret=array();
        $ret['data']=[];
        $e=200;
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $year=$r->year;
            $month=$r->month;
            // $company_id=$r->company_id;
            // return json(re);
            // $s_date=Carbon::createFromDate($year,$month,1);
            // $e_date=Carbon::createFromDate($year,$month,31);
            $from = Carbon::today();
            $from->day = 1;
            $from->month = $month;
            $from->year = $year;
            $location_id=$r->location_id;
            $company_id=$r->company_id;
            $to = Carbon::create($from->year,$from->month,$from->day);
            $to = $to->endOfMonth();
            $s_date=$from->format('Y-m-d H:i:s');
            $e_date=$to->format('Y-m-d H:i:s');

			Log::debug('s_date='.$s_date);
			Log::debug('e_date='.$e_date);
            
            $ret['debug']=[$r->mode,$s_date,$e_date,$user->id,$location_id];
            Log::info("Mode=".$r->mode);
			if ($r->mode=="current") {
               $ret['data']=DB::table('stockreport')
                ->join('stockreportproduct',
					'stockreportproduct.stockreport_id','=','stockreport.id')
                ->leftJoin('users','users.id','=','stockreport.checker_user_id')
                ->select("users.first_name","users.last_name",
					"stockreport.created_at","stockreport.id","stockreport.report_no")
                ->where('stockreport.status','=','pending')
                ->where('stockreport.creator_location_id',$location_id)
                // ->where('stockreport.creator_company_id',$company_id)
                ->whereNull('stockreport.deleted_at')
                ->groupBy('stockreport.id')
                ->orderBy("stockreport.id","DESC")
                ->where(function ($query) use($user) {
					$query->where("stockreport.creator_user_id",$user->id)
						->orWhere("stockreport.checker_user_id",$user->id);
				})
                ->get();

			} else {
                /*
				$ret['data']= DB::table('stockreport')
                ->join('stockreportproduct',
					'stockreportproduct.stockreport_id','=','stockreport.id')
                ->join('users','users.id','=','stockreport.checker_user_id')
                ->select("users.first_name","users.last_name",
					"stockreport.created_at","stockreport.id")
                ->whereBetween('stockreport.created_at',[$s_date,$e_date])
                ->whereNull('stockreport.deleted_at')
                ->groupBy('stockreport.id')
                ->where(function ($query) use($user) {
					$query->where("stockreport.creator_user_id",$user->id)
						->orWhere("stockreport.checker_user_id",$user->id);
				})
                // ->where("stockreport.creator_user_id",$user->id)
                // ->orWhere("stockreport.checker_user_id",$user->id)
                ->where('stockreport.status','confirmed')
                ->get();
                */
                 $ret['sql']="SELECT users.first_name, users.last_name, stockreport.created_at, stockreport.id,stockreport.report_no from stockreport inner join stockreportproduct on stockreportproduct.stockreport_id = stockreport.id inner join users on users.id = stockreport.checker_user_id where stockreport.created_at between '".$s_date."' AND '".$e_date."' and stockreport.deleted_at is null and (stockreport.creator_user_id = ".$user->id." or stockreport.checker_user_id = ".$user->id.") and stockreport.status = 'confirmed' and stockreport.creator_location_id=$location_id group by stockreport.id;";
 
                $ret['data']=DB::select(DB::raw("
                        SELECT users.first_name,
                        users.last_name,users.mobile_no,
                        stockreport.created_at,
                        stockreport.id,
                        stockreport.report_no from stockreport 
                        inner join stockreportproduct on stockreportproduct.stockreport_id = stockreport.id 
                        inner join users on users.id = stockreport.checker_user_id 
                        where stockreport.created_at between '".$s_date."' AND '".$e_date."' 
                        and stockreport.deleted_at is null 
                        and (
                                (
                                stockreport.creator_user_id = ".$user->id." and stockreport.checker_user_id <> 0 and
                                stockreport.creator_location_id=$location_id 

                            )
                             or (stockreport.creator_user_id <> 0 and stockreport.checker_user_id = ".$user->id." and
                                stockreport.checker_location_id=$location_id
                             )) 
                        and stockreport.status = 'confirmed' 
                        
                        group by stockreport.id 
                        order by stockreport.id desc;
				"));

				Log::debug($ret['data']);
            }

        } catch (\Exception $e) {
            Log::info($e->getMessage());
            $ret['long_message']=$e->getMessage();
            $e=500;
        }
        return response()->json($ret,$e);
    }

    public function report_info($r,$report)
    {
        $data=DB::table('stockreport')
        ->join('stockreportproduct','stockreportproduct.stockreport_id','=','stockreport.id')
        ->join('product','product.id','=','stockreportproduct.product_id')
        ->leftJoin('productqr','productqr.product_id','=','product.id')
        ->leftJoin('qr_management','productqr.qr_management_id','=','qr_management.id')
        

        ->where('stockreport.id',$r->rid)
        ->whereNull('stockreport.deleted_at')
        ->whereNull('stockreportproduct.deleted_at')
        ->select(
            DB::raw("

                product.id,product.name,
                product.photo_1,
                CASE
                when stockreport.ttype='stocktake' then stockreportproduct.opening_balance
                else stockreportproduct.quantity 
                END as quantity,
                stockreportproduct.received,
                stockreportproduct.status,
                qr_management.image_path

                ")
            )->get();

        $checker=DB::table('stockreport')
            ->join("users",'users.id','=','stockreport.checker_user_id')
            ->leftJoin('stockreportrack', 'stockreportrack.stockreport_id','=','stockreport.id')
            ->leftJoin('rack', 'stockreportrack.rack_id','=','rack.id')
            ->where('stockreport.id',$r->rid)
            ->whereNull("stockreport.deleted_at")
            ->whereNull("stockreportrack.deleted_at")
            ->select("users.first_name","users.last_name","users.mobile_no",
                "rack.rack_no"
                )
            ->first();
        /*Format It*/
        foreach ($data as $product) {
            $product->full_name=$product->name;
            $product->name=substr($product->name,0,10)."..";
            $product->image_uri=asset('images/product/'.$product->id.'/'.$product->photo_1);
            $product->qr_uri=asset('images/qr/product/'.$product->id.'/'.$product->image_path).".png";
        }
        return response(json_encode(['data'=>$data,'report'=>$report,'checker'=>$checker],JSON_UNESCAPED_SLASHES)); 

    }

    public function report_summary(Request $r)
    {
        if (!$r->has('rid')) {
            return response()->json(['status'=>'failure','long_message'=>"Invalid report id."],401);
        }

        // DB::table('stockreport')
        // ->join('users')
    }

    public function change_ttype($ttype,$report)
    {
        $to_update=[
        "ttype"=>$ttype,
        "updated_at"=>Carbon::now()

        ];
        if ($ttype!="treport") {
            $to_update["checker_location_id"]=$report->creator_location_id;
            $to_update["checker_company_id"]=$report->creator_company_id;
        }
        DB::table('stockreport')
                    ->where('id',$report->id)
                    ->update(
                        $to_update
                        );
                    $debug= [$report->id,$ttype];
        return response()->json(['status'=>'success','debug'=>$debug],200);
    }

    public function report(Request $r)
    {

        if (!$r->has('rid')) {
            return $this->report_new($r);
        }

        if ($r->has('rid') and $r->has('action')) {
            $report=DB::table('stockreport')
            ->join("users",'users.id','=','stockreport.creator_user_id')
            ->where('stockreport.id',$r->rid)
            ->whereNull("stockreport.deleted_at")
            ->select("stockreport.*","users.first_name","users.last_name")
            ->first();
            if (empty($report)) {
                return response()->json(['status'=>'failure','long_message'=>
                    "Report does not exists"
                    ],533);
            }
            if ($report->status=="confirmed" and !in_array($r->action,["confirm","info"])) {
                return response()->json(['status'=>'failure',"long_message"=>"Report is confirmed"],534);
            }
            switch ($r->action) {
                case 'update':
                    return $this->report_update($r,$report);
                    break;
                /*Manual Edit is only for checker*/
                case 'manual_edit':
                    return $this->report_manual_edit($r,$report);
                    # code...
                    break;
                case 'info':
                    return $this->report_info($r,$report);
                    break;
                case 'confirm':
                    // if ($r->mode!=="checker") {
                    //     return response()->json(['status'=>'failure','long_message'=>"Only checkers can confirm."],403);
                    // }
                    return $this->report_confirm($r,$report);
                    break;
                
                    break;
                case 'confirm_bulk':
                    # code...
                    return $this->report_confirm_bulk($r,$report);
                    break;
                case 'delete':
                    DB::table('stockreport')
                    ->where('id',$r->rid)
                    ->update([
                        "deleted_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                        ]);
                    $debug= DB::table('stockreport')
                    ->where('id',$r->id)->first();
                    return response()->json(['status'=>'success','debug'=>$debug],200);
                    break;
                case 'ttype':
                    return $this->change_ttype($r->ttype,$report);
                     
                    break;
                case 'location':
                    if (!$r->has("location_id") or !$r->has("company_id")) {
                        return "";
                    }
                    DB::table('stockreport')
                    ->where('id',$r->rid)
                    ->update([
                    
                        "checker_location_id"=>$r->location_id,
                        "checker_company_id"=>$r->company_id,
                        "updated_at"=>Carbon::now()
                        ]);
                    $ttype="treport";
                    if (($report->creator_location_id==$r->location_id) and ($report->creator_company_id==$report->checker_company_id)) {
                        $ttype="stocktake";
                    }
                    DB::table('stockreport')
                        ->where('id',$r->rid)
                        ->update([
                        
                            "ttype"=>$ttype,
                            "updated_at"=>Carbon::now()
                    ]);
                    /*Location Address & Company*/

                    $location=DB::table('fairlocation')->
                    where('fairlocation.id',$r->location_id)->
                    join('branch','branch.location_id','=','fairlocation.id')->
                    leftJoin('address','fairlocation.address_id','=','address.id')->
                    leftJoin('city','address.city_id','=','city.id')->
                    leftJoin('state','city.state_code','=','state.code')->
                    select('address.line1','address.line2','address.line3','city.name','state.name','address.postcode','branch.name as location')->
                    first();
                  
                    $debug= [$r->rid,$r->location_id,$ttype];
                    return response()->json(['status'=>'success','debug'=>$debug,'fairlocation'=>$location],200);
                    break;
                case 'company':

                    DB::table('stockreport')
                    ->where('id',$r->rid)
                    ->update([
                        "checker_company_id"=>$r->company_id,
                        "updated_at"=>Carbon::now()
                        ]);
                    /*Location Address & Company*/

                    $company=DB::table('company')->
                    where('id',$r->company_id)->
                    select('company.dispname','owner_user_id')->
                    first();
                    $debug= [$r->rid,$r->company_id,"update company"];
                    return response()->json(['status'=>'success','debug'=>$debug,'company'=>$company],200);
                    break;


                case 'row_delete':
                    if (!$r->has("rows")) {
                        return response()->json(['status'=>'failure',"long_message"=>"Bad Request"],500);
                    }
                    $rows=$r->rows;
                    DB::table("stockreportproduct")
                    ->join("stockreport","stockreport.id","=","stockreportproduct.stockreport_id")
                    ->where("stockreport.id",$report->id)
                    ->whereIn("stockreportproduct.product_id",$rows)
                    ->update([
                            "stockreportproduct.deleted_at"=>Carbon::now()
                        ]);
                    $debug= [$r->rid,$rows,"update company"];
                    return response()->json(['status'=>'success','debug'=>$debug,],200);
                    break;

                case 'add_checker':
                    /*if (!empty($report->checker_company_id) and $r->location_id!=$report->checker_location_id) {
                          
                           $ret["error"]="Invalid location_id";
                           
                           return response()->json($ret,506); 
                       } */
                    return $this->add_checker($r,$report);
                    break;
                default:
                    # code...
                    break;
            }
        }

    }


    public function get_receipent_company($company_id)
    {
        $ret=array();

        /*Get merchant_user_id*/
        $merchant=DB::table('company')->join('merchant','merchant.user_id','=','company.owner_user_id')
        ->where('company.id',$company_id)
        ->select("merchant.id","merchant.user_id")
        ->first();
        if (empty($merchant)) {
            $ret["error"]="Invalid Company";
            return response()->json($ret);
        }
        try {

            // DB::table('autolink')
            // ->where('autolink.status','linked')
            // ->whereNull('autolink.deleted_at')
            // ->where('autolink.initiator',$merchant->user_id)
            // ->orWhere('autolink.responder',$merchant->user_id)

            
        } catch (\Exception $e) {
            $ret['error']=$e->getMessage();
        }
    }

    public function qr_dropdown_info(Request $r) {
        $ret=array();
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $report_number=$r->report_number;
            $report_mode=$r->report_mode;

            $r=DB::table('stockreport')->where('id',$report_number)->first();
            
            if (empty($r)) {
                return response()->json(["error"=>"Invalid report number"]);
            }

            $info=DB::table('users')->where('id',$r->creator_user_id)->select("users.first_name","users.last_name","users.mobile_no")->first();
            $info->fairlocation=DB::table('fairlocation')->
                where('fairlocation.id',$r->creator_location_id)->
                leftJoin('address','fairlocation.address_id','=','address.id')->
                leftJoin('city','address.city_id','=','city.id')->
                leftJoin('state','city.state_code','=','state.code')->
                select('address.line1','address.line2','address.line3','city.name','state.name','address.postcode','fairlocation.location','fairlocation.id')->
                first();
            $info->company=DB::table('company')->
                where('id',$r->creator_company_id)->
                select('company.dispname','owner_user_id')->
                first();
            $info->created_at=$r->created_at;
            $info->ttype=$r->ttype;

            

            // $info=DB::table('stockreport')->
            // join('users','stockreport.creator_user_id','=','users.id')->
            // leftJoin('stockreportproduct','stockreportproduct.id','=','stockreport.creator_location_id')->
            // leftJoin('address','stockreportproduct.address_id','=','address.id')->
            // leftJoin('city','address.city_id','=','city.id')->
            // leftJoin('state','city.state_code','=','state.code')->
            // join('member','member.user_id','=','stockreport.creator_user_id')->
            // join('company','company.id','=','member.company_id')->
            // where('stockreport.id',$report_number)->
            // where('stockreport.creator_company_id',$r->creator_company_id)->
            
            // select('users.first_name','users.last_name','company.dispname','address.line1','address.line2','address.line3','city.name','state.name','address.postcode','company.owner_user_id','stockreportproduct.location')
            // ->first();
             // return response()->json(['report'=>$info,$r->creator_company_id]);
            $linked_companies=DB::select(DB::raw("
                    select
                    DISTINCT f.id as location_id,
                    c.id,
                    c.dispname,
                    f.location
                    
                from
                    autolink al,
                    users mu,   -- merchant.user_id
                    merchant m,
                    users cu,   -- company.owner_user_id
                    merchant cm,
                    company c,
                    fairlocation f
                where
                    
                    mu.id =378 and
                    m.user_id=mu.id and
                    f.user_id=c.owner_user_id and 
                    cm.user_id=c.owner_user_id and
                    c.owner_user_id=cu.id and
                    ((al.initiator=cm.user_id and al.responder=m.id) OR
                    (al.initiator=m.user_id and al.responder=cm.id))
                "));
                $raw_ret=array();
                foreach ($linked_companies as $m) {
                $key=$m->dispname;
                try {
                    
                    
                    $temp_contant=$raw_ret[$key];
                    
                } catch (\Exception $e) {
                    $temp_contant=array();
                }

                

                array_push($temp_contant,["location"=>$m->location,"location_id"=>$m->location_id,"company_id"=>$m->id]);

                $raw_ret[$key]=$temp_contant;

                }
            $fc=array();
            foreach ($raw_ret as $c=>$rr) {
                
                $temp=array();
                $temp["title"]=$c;
                $temp["content"]=$rr;
                array_push($fc,$temp);
            }
            $checker=(object) array();
            $checker->fairlocation=DB::table('fairlocation')->
                    where('fairlocation.id',$r->checker_location_id)->
                    leftJoin('address','fairlocation.address_id','=','address.id')->
                    leftJoin('city','address.city_id','=','city.id')->
                    leftJoin('state','city.state_code','=','state.code')->
                    select('address.line1','address.line2','address.line3','city.name','state.name','address.postcode','fairlocation.location','fairlocation.id')->
                    first();
            $checker->checked_date=$r->checked_on;
            $checker->status=$r->status;
            if (empty($checker->checked_date)) {
                $checker->checked_date="";
            }
            if (empty($checker->fairlocation)) {
                $checker->fairlocation=[
                    "line1"=>"",
                    "line2"=>"",
                    "line3"=>"",
                    "postcode"=>"",
                    "location"=>"",
                    "name"=>""
                ];
            }
            $checker->company=DB::table('company')->
                    where('id',$r->checker_company_id)->
                    select('company.dispname','owner_user_id')->
                    first();
            if (empty($checker->company)) {
                $checker->company=[
                    "dispname"=>"",
                    "owner_user_id"=>""
                ];
            }
            $checker->user=DB::table('users')->where('id',$r->checker_user_id)->select("users.first_name","users.last_name","users.mobile_no")->first();
            if (empty($checker->user)) {

                $checker->user=[
                    "first_name"=>"",
                    "last_name"=>"",
                    "mobile_no"=>""
                ];
            }

            // 
            // $checker=DB::table('stockreport')->
            // leftJoin('users','stockreport.checker_user_id','=','users.id')->
            // leftJoin('stockreportproduct','stockreportproduct.id','=','stockreport.checker_location_id')->
            // leftJoin('address','stockreportproduct.address_id','=','address.id')->
            // leftJoin('city','address.city_id','=','city.id')->
            // leftJoin('state','city.state_code','=','state.code')->
            // leftJoin('member','member.user_id','=','stockreport.checker_user_id')->
            // leftJoin('company','company.id','=','member.company_id')->
            // where('stockreport.id',$report_number)->
            // select('users.first_name','users.last_name','company.dispname','address.line1','address.line2','address.line3','city.name','state.name','address.postcode','stockreportproduct.location')
            // ->first();
            $ret['info']=$info;
            $ret['checker']=$checker;
            $ret['linked_companies']=$fc;
        } catch (\Exception $e) {
            $ret['error']=$e->getMessage();
            $ret['line']=$e->getLine();
        }

        return response()->json($ret);
    }
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function auto_create_st_report_warehouse(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
       
        $user = JWTAuth::parseToken()->authenticate();
        if (empty($user)) {
            return response()->json($ret);
        }
        $user_id=$user->id;
        if(!empty($uid)){
            $user_id=$uid;
        }
        $creator_location_id=$r->location_id;
        $creator_company_id=$r->company_id;
        $rack_no=$r->rack_no;
        $warehouse_id=$r->warehouse_id;
        Log::debug(compact('creator_company_id','creator_location_id','rack_no','warehouse_id'));
        
        /*Create a stockreport*/
        $data=[
            "creator_user_id"=>$user_id,
            "creator_location_id"=>$creator_location_id,
            "creator_company_id"=>$creator_company_id,
            "checker_user_id"=>$user_id,
            "checker_location_id"=>$creator_location_id,
            "checker_company_id"=>$creator_company_id,
            "ttype"=>"stocktake",
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ];
        $stockreport_id=DB::table("stockreport")->insertGetId($data);
        $rack=DB::table("warehouse")
                ->join("rack","rack.warehouse_id","=","warehouse.id")
                ->whereNull("warehouse.deleted_at")
                ->whereNull("rack.deleted_at")
                

                ->where("rack.rack_no",$rack_no)
                ->where("warehouse.location_id",$creator_location_id)
               
                ->select("rack.id")
                ->orderBy("rack.created_at","DESC")
                ->first();
       

        DB::table("stockreportrack")
            ->insert([
                "rack_id"=>$rack->id,
                "stockreport_id"=>$stockreport_id,
                "updated_at"=>Carbon::now(),
                "created_at"=>Carbon::now()
        ]);
        try{
            /*Referenced at 3 places, 2* ReportController 1*SellerRackController*/
            $query="SELECT
                
                    product.name,
                    product.thumb_photo,
                    '--' expiry_date,
                    
                    
                   
                    product.id as product_id,
                    SUM(
                        CASE

                            WHEN stockreport.ttype=NULL then 0
                            WHEN stockreport.ttype = 'stocktake' THEN
                            CAST(stockreportproduct.received as SIGNED)-CAST(stockreportproduct.opening_balance AS SIGNED)
                            WHEN stockreport.ttype='tin' then stockreportproduct.quantity
                            WHEN stockreport.ttype='tout' then - stockreportproduct.quantity
                            WHEN stockreport.ttype='treport' then 
                               CASE WHEN 
                                    stockreport.creator_location_id=$creator_location_id
                                    THEN -stockreportproduct.quantity
                                    ELSE
                                    stockreportproduct.quantity
                                END
                            ELSE 0
                        END
                    ) as quantity

                    FROM 
                  
                    rack
                    JOIN (SELECT DISTINCT stockreport_id,rack_id from stockreportrack) stockreportrack on stockreportrack.rack_id=rack.id


                    LEFT JOIN stockreport ON  stockreport.id= stockreportrack.stockreport_id
                    
                    LEFT JOIN stockreportproduct ON stockreportproduct.stockreport_id = stockreportrack.stockreport_id
                    LEFT JOIN product ON product.id=stockreportproduct.product_id


                    WHERE 
                    rack.deleted_at IS NULL
                    AND rack.warehouse_id=$warehouse_id 
               
                    AND rack.rack_no=$rack_no
                    AND stockreport.status='confirmed'
                    AND stockreport.deleted_at IS NULL
                    AND stockreportproduct.deleted_at IS NULL
                    AND stockreportproduct.status='checked'
                    AND product.deleted_at IS NULL
                    AND stockreport.creator_location_id=$creator_location_id

                    
                    AND quantity>0
                    group by  product.name";

            $all_products=DB::select(DB::raw($query));
            Log::debug((array)$all_products);
            foreach ($all_products as $product) {
                $sdata=[
                    "product_id"=>$product->product_id,
                    "opening_balance"=>$product->quantity,
                    "stockreport_id"=>$stockreport_id,
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now()
                ];
                DB::table("stockreportproduct")->insert($sdata);
            }

            $ret["status"]="success";
            $ret["report_id"]=$stockreport_id;
            $ret["rack_no"]=$r->rack_no;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
        //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function auto_create_wastage_report(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
       
        $user = JWTAuth::parseToken()->authenticate();
        if (empty($user)) {
            return response()->json($ret);
        }
        $user_id=$user->id;
        if(!empty($uid)){
            $user_id=$uid;
        }
        $creator_location_id=$r->location_id;
        $creator_company_id=$r->company_id;
     
        
        /*Create a stockreport*/
        $data=[
            "creator_user_id"=>$user_id,
            "creator_location_id"=>$creator_location_id,
            "creator_company_id"=>$creator_company_id,
            "checker_user_id"=>$user_id,
            "checker_location_id"=>$creator_location_id,
            "checker_company_id"=>$creator_company_id,
            "ttype"=>"wastage",
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ];
        $stockreport_id=DB::table("stockreport")->insertGetId($data);
       
        try{
            /*Referenced at 3 places, 2* ReportController 1*SellerRackController*/
            $n= new RPC;
            $query=$n->plquery($r->location_id);
            $all_products=DB::select(DB::raw($query));
            foreach ($all_products as $product) {
                $sdata=[
                    "product_id"=>$product->id,
                    "opening_balance"=>$product->quantity,
                    "stockreport_id"=>$stockreport_id,
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now()
                ];
                DB::table("stockreportproduct")->insert($sdata);
            }

            $ret["status"]="success";
            $ret["report_id"]=$stockreport_id;
       
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    public function add_checker($r,$report)
    {
        $ret=array();
        $user = JWTAuth::parseToken()->authenticate();
        if (!empty($user)) {
            try {
                $to_update=array();
                $merchant_user_id=DB::table("company")->where("id",$r->company_id)->pluck("owner_user_id");
                $merchant=DB::table("merchant")->where("user_id",$merchant_user_id)
                ->whereNull("deleted_at")->first();
               
                
                $to_update["checker_user_id"]=$user->id;
                if ($report->checker_company_id==null || $report->checker_company_id==0) {
                    $to_update["checker_company_id"]=$r->company_id;
                }
                if ($report->checker_location_id==null || $report->checker_location_id==0) {
                    $to_update["checker_location_id"]=$r->location_id;
                }

                // if ($r->location_id==$report->creator_location_id and $r->company_id == $report->creator_company_id and $report->ttype!="tin" and $report->ttype!="tout") {
                //     $to_update["ttype"]="stocktake";


                // }

                $to_update["updated_at"]=Carbon::now();
                DB::table("stockreport")->where("id",$report->id)
                ->update($to_update);

                /*Copy the inventory*/
                $products=DB::table("stockreportproduct")->whereNull("stockreportproduct.deleted_at")
                ->join("product","product.id","=","stockreportproduct.product_id")
                
                // ->whereNull("product.deleted_at")
                ->where("stockreportproduct.stockreport_id",$report->id)->
                select("product.*")->get();
                 $debug=[];
                foreach ($products as $p) {
                    try {

                        $does_exist1=DB::table("product")->join("merchantproduct","merchantproduct.product_id","=","product.id")
                        ->where("product.parent_id",$p->id)
                        ->where("product.segment",$p->segment)
                        ->where("product.name",$p->name)
                        ->whereNull("merchantproduct.deleted_at")
                        ->whereNull("product.deleted_at")
                        ->where("merchantproduct.merchant_id",$merchant->id)
                        ->first();
                        /* New validation based on product's barcode*/
                         $does_exist2=DB::table("product")->join("merchantproduct","merchantproduct.product_id","=","product.id")
                        ->join("productbc","productbc.product_id","=","product.id")
                        ->join("bc_management","bc_management.id","=","productbc.bc_management_id")
                        ->where("product.parent_id",$p->id)
                        ->where("product.segment",$p->segment)
                        ->where("product.name",$p->name)
                        ->whereNull("merchantproduct.deleted_at")
                        ->whereNull("product.deleted_at")
                        ->where("merchantproduct.merchant_id",$merchant->id)
                        ->first();
                        $parent_id=$p->id;

                        if(empty($does_exist1) and empty($does_exist2)){
                            $p->parent_id=$p->id;
                            unset($p->id);
                            $p->created_at=Carbon::now();
                            $p->updated_at=Carbon::now();
                            $p=(array)$p;
                            $pid=DB::table("product")->insertGetId($p);
                            /*Update merchantproduct*/
                            $to_insert=[
                                "merchant_id"=>$merchant->id,
                                "product_id"=>$pid,
                                "updated_at"=>Carbon::now(),
                                "created_at"=>Carbon::now()
                            ];
                            $mpd=DB::table("merchantproduct")->insertGetId($to_insert) ;
                            $merchantuniqueq = DB::table('nsellerid')->where('user_id',$merchant->user_id)->first();
                         

                       
                            // $merchantuniqueq->nseller_id=12344;
                            
                            
                            try {
                                UtilityController::nproductid($pid);
                            } catch (\Exception $e) {
                                Log::info("An exception occured while creating nproductid.Message ->".$e->getMessage());
                            }
                            // // $nproductid=$pid;
                            // Log::info("NPRODUCT ID GENERATED = ".$nproductid);
                            /*Copy the Product Image*/
                            $source=public_path("images/product/".$parent_id);
                            $destination=public_path("images/product/".$pid);
                            try {
                                // UtilityController::copyfolder($source,$destination);
                               $res= File::copyDirectory($source, $destination);
                                /*After Copy do the QR*/
                                Log::info("COPIED FOLDER ".$res);
                            } catch (\Exception $e) {
                                if (!file_exists($qr_store_path)) {
                                        mkdir($qr_store_path, 0775, true);
                                    }
                                Log::info("**********Copy Folder ERROR*************");
                                Log::info($e);

                            }
                            /* Add a row for ProductBC */
                            #Get parent's productbc record
                            $parent_bcmanagement=DB::table("productbc")->
                            join("bc_management","productbc.bc_management_id","=","bc_management.id")->
                            where("productbc.product_id",$parent_id)->
                            whereNull("productbc.deleted_at")->
                            whereNull("bc_management.deleted_at")->
                            select("bc_management.*")->first(); 

                            $bc_management_id=DB::table("bc_management")->insertGetId([
                                "barcode"=>$parent_bcmanagement->barcode,
                                "barcode_type"=>$parent_bcmanagement->barcode_type,
                                "image_path"=>$parent_bcmanagement->image_path,
                                "created_at"=>Carbon::now(),
                                "updated_at"=>Carbon::now()

                                ]);
                            DB::table("productbc")->insertGetId([
                                "product_id"=>$pid,
                                "bc_management_id"=>$bc_management_id,
                                "created_at"=>Carbon::now(),
                                "updated_at"=>Carbon::now()

                                ]);
                            $source=public_path('images/barcode/'.$parent_id);
                            $destination=public_path('images/barcode/'.$pid);
                            try {
                                // UtilityController::copyfolder($source,$destination);
                               $res= File::copyDirectory($source, $destination);
                                /*After Copy do the QR*/
                                Log::info("COPIED FOLDER ".$res);
                            } catch (\Exception $e) {
                                if (!file_exists($qr_store_path)) {
                                        mkdir($qr_store_path, 0775, true);
                                    }
                                Log::info("**********Copy Folder ERROR*************");
                                Log::info($e);

                            }
                            /* Create QR */
                            UtilityController::createQr($pid,"product",$pid); 
                            /*Add NproductId*/
                         
                         }else{
                            Log::info("Product Exists does_exist1". $does_exist1->id);
                            Log::info("Product Exists does_exist2". $does_exist2->id);
                         }
                    } catch (\Exception $e) {
                        /*Rollback here*/ 
                        Log::info($e);
                        $ret['error']=$e->getMessage();
                        $ret['line']=$e->getLine();
                        

                       
                        DB::table("product")->where("id",$pid)->update([
                            "deleted_at"=>Carbon::now()
                            ]);
                        DB::table("merchantproduct")->where("id",$mpd)->update([
                                "deleted_at"=>Carbon::now()
                            ]);
                        return response()->json($ret);
                                             }
                }

                $ret["long_message"]="Checker Updated";
                
            } catch (\Exception $e) {
                $ret['error']=$e->getMessage();
                $ret['line']=$e->getLine();
            }
        }
        // $ret['debug']=$debug;
        $ret["report"]=$report;
        return response()->json($ret);
    }

    public function years_month($company_id=null, $location_id=null)
    {
        $ret=array();
        try {
           
		if (empty($location_id)) {
			Log::debug('BOOOOO');

           $current=DB::select(DB::raw("
            SELECT
				MONTH(stockreport.created_at) AS month,
				YEAR(stockreport.created_at) AS year
            FROM
				stockreport
            JOIN stockreportproduct ON stockreportproduct.stockreport_id = stockreport.id

            WHERE stockreport.creator_company_id=$company_id
            AND  stockreport.status='pending'
            
            GROUP BY MONTH(created_at), YEAR(created_at)
			"));


            $data=DB::select(DB::raw(" 
            SELECT     MONTH(stockreport.created_at) AS month, YEAR(stockreport.created_at) AS year
            FROM         stockreport
            JOIN stockreportproduct ON stockreportproduct.stockreport_id = stockreport.id

            WHERE stockreport.creator_company_id=$company_id
            OR (stockreport.checker_company_id=$company_id AND stockreport.ttype='treport')
            AND  stockreport.status='confirmed'
            
            GROUP BY MONTH(created_at), YEAR(created_at)
			"));

			} else {
			Log::debug('YAY!'.$location_id);
            $current=DB::select(DB::raw("
            SELECT
				MONTH(stockreport.created_at) AS month,
				YEAR(stockreport.created_at) AS year
            FROM
				stockreport
            JOIN stockreportproduct ON stockreportproduct.stockreport_id = stockreport.id

            WHERE stockreport.creator_location_id=$location_id
            AND  stockreport.status='pending'
            
            GROUP BY MONTH(created_at), YEAR(created_at)
			"));


            $data=DB::select(DB::raw(" 
            SELECT
				MONTH(stockreport.created_at) AS month, YEAR(stockreport.created_at) AS year
            FROM
				stockreport
            JOIN stockreportproduct ON stockreportproduct.stockreport_id = stockreport.id

            WHERE stockreport.creator_location_id=$location_id
            OR (stockreport.checker_location_id=$location_id
			AND stockreport.ttype='treport')
            AND  stockreport.status='confirmed'
            
            GROUP BY MONTH(created_at), YEAR(created_at)
			")); 
			}

            $ret=array();
            foreach ($data as $d) {
                array_push($ret,$d->month);
            }
            if (!empty($current)) {
                array_push($ret,"C");
            }
            $ret=array_unique($ret);

        } catch (\Exception $e) {
            $ret["error"]=$e->getMessage();
            $ret["line"]=$e->getLine();
        }
        return response()->json($ret);
    }

    public function bulk_report(Request $r)
    {
        $raw_data=array();
        foreach ($raw_data as $data) {
            /*Create actual report*/
            $data=[
                "creator_company_id"=>$data->creator_company_id,
                "creator_location_id"=>$data->cre,
            ];
            $report_id=DB::table("report")
            ->insertGetId($data);
        }
    }

   //-----------------------------------------
   // Created by Zurez
   //-----------------------------------------
   
    public function rack_list($warehouse_id,$ttype="")
    {
       $ret=array();
       $data=array();
       try{
            if (!in_array($ttype,["tout"])) {
                # code...
                $data=DB::table("rack")
                ->where("warehouse_id",$warehouse_id)
                ->whereNull("deleted_at")
                ->orderBy("created_at","DESC")
                ->select("rack_no","id")
                ->get();
            }else {
                /*Only those rack which has product in it*/
                $data=DB::select(DB::raw("

                    SELECT
                
                  
                    rack.rack_no,
                    rack.id,
                    stockreport.ttype,
                   
              
                    SUM(
                        CASE
                            WHEN ttype='tin' then stockreportproduct.quantity
                            WHEN ttype='tout' then - stockreportproduct.quantity
                        END
                    ) as quantity

                    FROM 
                  
                    rack
                    LEFT JOIN stockreportrack ON stockreportrack.rack_id=rack.id
                    LEFT JOIN stockreport ON  stockreport.id= stockreportrack.stockreport_id
                    LEFT JOIN stockreportproduct ON stockreportproduct.stockreport_id = stockreportrack.stockreport_id
                    LEFT JOIN product ON product.id=stockreportproduct.product_id


                    WHERE 
                    rack.deleted_at IS NULL
                    AND rack.warehouse_id=$warehouse_id 
                    
                    AND quantity>0
                    group by rack.rack_no

                "));
            }
            
   
   
           $ret["data"]=$data;
       }
       catch(\Exception $e){
           $ret["short_message"]=$e->getMessage();
           Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
       }
       return response()->json($ret);
    }
   
}
