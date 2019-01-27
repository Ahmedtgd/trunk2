<?php

namespace App\Http\Controllers\rn;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
//use Illuminate\Support\Facades\DB;
use DB;
use JWTAuth;
use Carbon;
use Log;
use QrCode;
use DNS1D;
class SalesMemoController extends Controller
{
        /**
     * @api {post} rn/app/sales_memo/new Creates a new empty sales_memo record
     * @apiName NewReport
     * @apiGroup Report
     *
     * @apiPermission Merchant Admin
     * @apiSuccess {String} status success.
     * @apiSuccess {String} long_message .
     * @apiFailure {String} status failure
     */
    public function sales_memo_new($location_id)
    {
        $ret=array();

        $ret['long_message']="Validation failure";
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user ) {
            return response()->json($ret);
        }
        
        $owner_user_id=DB::table("fairlocation")->where("id",$location_id)
            ->pluck("user_id");
        if (empty($owner_user_id)) {
             $ret['long_message']="Fairlocation not valid.";
             return response()->json($ret);
        }

        /**************/ 
        $salesmemo_no=1;

        /* Delete useless SM */
        DB::table("salesmemo")->
            join("fairlocation","fairlocation.id","=",
                "salesmemo.fairlocation_id")->
            leftJoin("salesmemoproduct","salesmemo.id","=",
                "salesmemoproduct.salesmemo_id")->
            where("fairlocation.user_id",$owner_user_id)->
            whereNull("salesmemoproduct.id")->
            update([
                "salesmemo.salesmemo_no"=>NULL,
                "salesmemo.deleted_at"=>Carbon::now()
            ]);

        $ts=DB::table("salesmemo")->
            join("fairlocation","fairlocation.id","=",
                "salesmemo.fairlocation_id")->
            where("fairlocation.user_id",$owner_user_id)->
            get();

        foreach ($ts as $t) {
            $smp=DB::table("salesmemoproduct")->
                where("salesmemo_id",$t->id)->
                whereNull("deleted_at")->
                first();

            if (empty($smp)) {
                DB::table("salesmemo")->
                    where("id",$t->id)->
                    update([
                        "salesmemo_no"=>NULL,
                        "updated_at"=>Carbon::now(),
                        "deleted_at"=>Carbon::now()
                    ]);
            }
        }

        /* RECOVERY SECTION */
        $total_salesmemos_records=DB::table("salesmemo")->
            join("fairlocation","fairlocation.id","=",
                "salesmemo.fairlocation_id")->
            where("fairlocation.user_id",$owner_user_id)->
            groupBy("salesmemo.salesmemo_no")->
            select("salesmemo.*")->
            whereNull("salesmemo.deleted_at")->
            get();

        $total_salesmemos=count($total_salesmemos_records);
        $max_salememo=DB::table("salesmemo")->
            join("fairlocation","fairlocation.id","=",
                "salesmemo.fairlocation_id")->
            join("salesmemoproduct","salesmemo.id","=",
                "salesmemoproduct.salesmemo_id")->
            where("fairlocation.user_id",$owner_user_id)->
            orderBy("salesmemo.id","DESC")->
            select("salesmemo.*")->
            whereNull("salesmemo.deleted_at")->
            first();

        $uniq = array();
        if (!empty($max_salememo) &&
            $total_salesmemos != $max_salememo->salesmemo_no) {

            /* Prepare datastructure of unique salesmemo_no and possible
             * salesmemo_id that has the same salesmemo_no */
            foreach ($total_salesmemos_records as $k) {
                /* This is a case where salesmemo_no is the SAME but valid
                 * with products!! */
                $validrecs = DB::table("salesmemo")->
                    join("fairlocation","fairlocation.id","=",
                        "salesmemo.fairlocation_id")->
                    where("salesmemo_no", $k->salesmemo_no)->
                    where("fairlocation.user_id",$owner_user_id)->
					whereNull("salesmemo.deleted_at")->
                    select("salesmemo.*")->
                    orderBy("salesmemo.id")->
                    get();

                $procs = array_map(function($v){return $v->id;}, $validrecs);
                $uniq[$k->salesmemo_no] = $procs;

                /*
                dump('uniq['.$k->salesmemo_no.']='.
                    json_encode($uniq[$k->salesmemo_no]));
                dump($procs);
                dump($validrecs);
                */
            }
 
            # Recovery
            $i=1;
            foreach ($uniq as $k => $v) {
                if (!empty($v) and count($v) > 0) {
                    foreach ($v as $pid) {
                        DB::table("salesmemo")->
                            where("id",$pid)->
                            update([ "salesmemo_no" => $i ]);
                        $i++; 
                    }
                }
            }
        }
 
        /*****************/
        $sm=DB::table("salesmemo")->
            join("fairlocation","fairlocation.id","=",
                "salesmemo.fairlocation_id")->
            join("salesmemoproduct","salesmemoproduct.salesmemo_id","=",
                "salesmemo.id")->
            where("fairlocation.user_id",$owner_user_id)->
            orderBy("salesmemo.salesmemo_no","DESC")->
            select("salesmemo.*")->
            whereNull("salesmemo.deleted_at")->
            first();

        if (!empty($sm)) {
            $salesmemo_no = $sm->salesmemo_no + 1;
        }

        /*******************/
        $sales_memo_id=DB::table('salesmemo')->
            insertGetId([
           
                "creator_user_id"=>$user->id,
                "fairlocation_id"=>$location_id,
                "salesmemo_no"=>$salesmemo_no,
                "status"=>"active",
                "updated_at"=>Carbon::now(),
                "created_at"=>Carbon::now()
            ]);

        return $sales_memo_id;
	}
    

    public function sales_memo_confirm($r,$salesmemo)
    {
        $ret=array();
        $ret['status']="failure";
        // $ret['long_message']="Validation failure";
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user ) {
            return response()->json($ret);
        }
        try {
            $sales_memo_id=DB::table('salesmemo')
            ->where('id',$salesmemo->id)
            
            ->update(
            [
                "consignment_account_no"=>$r->consignment_no,
                "confirmed_on"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ]
            );
            $ret['status']='success';
            // $ret['sales_memo_id']=$sales_memo_id;
        } catch (\Exception $e) {
            $ret['error']=$e->getMessage();   
        }
        
        return response()->json($ret);
    }


    public function sales_memo_update($r,$sales_memo)
    {
        if ($sales_memo->status=="confirmed") {
            return response()->json(['status'=>'failure'],500);
        }

		/*
		Log::info(print_r($sales_memo, true));

		Log::info('$r->quantity='.$r->quantity);
		Log::info('$r->pid='.$r->pid);
		Log::info('$sales_mem->id='.$sales_memo->id);
		*/

        $quantity = $r->quantity;
        $product_id = $r->pid;
        $sales_memo_id = $sales_memo->id;
        $string_price=$r->price;

        /* Convert string price in MYR to cents*/
        $string_price=str_replace(",","",$string_price);

        $float_price=floatval($string_price);

        $price=$float_price*100;
        
		try {
			/*
			Log::info('quantity='.$quantity);
			Log::info('product_id='.$product_id);
			Log::info('sales_memo_id='.$sales_memo_id);
			*/

			$does_exist = DB::Table('salesmemoproduct')->
				where('product_id', '=', "$product_id")->
				where('salesmemo_id', '=', "$sales_memo_id")->
				first();


			/*
			Log::info("------------- does_exist -----------");
			Log::info(print_r($does_exist, true));
			Log::info("------------- does_exist -----------");
			*/

		} catch (\Exception $e) {
            Log::error($e->getMessage());
            //$ret['long_message']=$e->getMessage();
		}

        $product=DB::table("product")->where("id",$product_id)
        ->first();
        // $available_quantity=$product->consignment;
        $available_quantity=DB::table("locationproduct")->where("location_id",$sales_memo->fairlocation_id)->where("product_id",$product_id)->
            orderBy("locationproduct.created_at","DESC")->
            pluck("quantity");
        if (empty($available_quantity) or $available_quantity<1 or $quantity>$available_quantity) {
            Log::info("Insufficient stock for this sale. Only ".$available_quantity. " units left . Code 501");
            return response()->json(['status'=>'failure',"long_message"=>"Insufficient stock for this sale. Only ".$available_quantity. " units left"],501);
        }

        //$price=UtilityController::realPrice($product_id);
        $deductible_quantity=$quantity;
        switch ($r->mode) {
            case 'creator':
                if (empty($does_exist)) {
                    DB::table('salesmemoproduct')
                    ->insertGetId([
                        'quantity'=>$quantity,
                        'product_id'=>$product_id,
                        'price'=>$price,
                        'salesmemo_id'=>$sales_memo_id,
                        "updated_at"=>Carbon::now(),
                        "created_at"=>Carbon::now()
                        ]);

                } else {
                    $smp=DB::table('salesmemoproduct')
                    ->where('product_id',$product_id)
                    ->where('salesmemo_id',$sales_memo_id)
                    ->first();
                    $deductible_quantity=$deductible_quantity-$smp->quantity;
                    DB::table('salesmemoproduct')
                    ->where('product_id',$product_id)
                    ->where('salesmemo_id',$sales_memo_id)
                    ->update([
                        'quantity'=>$quantity,
                        "updated_at"=>Carbon::now()
                        ]);
                }
                /*Consignment Update OBSOLETE
                try {
                    DB::table('product')
                    ->where('id',$product_id)
                    ->update([
                    "consignment"=>DB::raw("consignment-".$deductible_quantity),
                    "updated_at"=>Carbon::now()
                    ]); 
                    
                } catch (\Exception $e) {
                    Log::info("Error while updating the consignment in salesmemo at line ".$e->getLine()." file".$e->getFile()." error ".$e->getMessage());
                }
                */
                                     /*
                     Snapshot
                        
                     */
                 $old_lp=DB::table("locationproduct")->where("product_id",$product_id)->where("location_id",$sales_memo->fairlocation_id)
                 ->whereNull("deleted_at")->orderBy("created_at","DESC")->first();
                 $old_ob=0;
                 $ob=0;
                 if (!empty($old_lp)) {
                     $ob=$old_lp->quantity-$deductible_quantity;
                    
                 }else{
                    $ob=$deductible_quantity;
                 }
                 Log::info("Sales Memo value of $ob ".$ob);
                 DB::table("locationproduct")
                     ->insert(
                            [
                                "product_id"=>$product_id,
                                "location_id"=>$sales_memo->fairlocation_id,
                             
                                "quantity"=>$ob,
                                "created_at"=>Carbon::now(),
                                "updated_at"=>Carbon::now()
                            ]
                        );

           
                 /**/ 
                
                break;

            case 'buyer':
                if(empty($does_exist)){
                    return response()->json(['status'=>'failure','short_message'=>"Product not part of sales_memo"],501);
                }
                $user = JWTAuth::parseToken()->authenticate();
                // return response(json_encode(["t"=>[$sales_memo_id,$product_id,$quantity]]));

                DB::table('salesmemo')
                ->where('id',$sales_memo->id)
                ->update([
                    'buyer_user_id'=>$user->id,
                    "updated_at"=>Carbon::now()

                    ]);
                if ($does_exist->quantity<($quantity+$does_exist->received)) {
                    # code...
                    return response()->json(['status'=>'failure','short_message'=>"Product quantity is more than sales_memoed by creator."],502);
                }
                DB::table('salesmemoproduct')
                ->where('salesmemo_id',$sales_memo_id)
                ->where('product_id',$product_id)
                ->update([
                    "received"=>$quantity+$does_exist->received,
                    "status"=>"checked",
                    "updated_at"=>Carbon::now(),
                    ]);
                break;
            default:
                break;
        }

		Log::debug("sales_memo_number=".$sales_memo->id);

        return response()->json([
			'sales_memo_number'=>$sales_memo->id]);
    }

    public function salesmemo_list(Request $r)
    {
        $ret=array();
        $ret['data']=[];
        $e=200;
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $year=$r->year;
            $month=$r->month;
            $from = Carbon::today();
            $from->day = 1;
            $from->month = $month;
            $from->year = $year;
            $company_id=$r->company_id;
            $location_id=$r->location_id;
            $to = Carbon::create($from->year,$from->month,$from->day);
            $to = $to->endOfMonth();
            $r->mode="active";
            $ret['debug']=[$r->mode,$from,$to,$user->id,$r->company_id];
            $merchant_user_id=DB::table("company")->where("id",$company_id)
            ->pluck("owner_user_id");
            $status="active";

			Log::debug($from);
			Log::debug($to);

            $data=DB::table("salesmemo")->
            join("salesmemoproduct","salesmemoproduct.salesmemo_id","=","salesmemo.id")->
            join("fairlocation","salesmemo.fairlocation_id","=","fairlocation.id")->
            where("fairlocation.user_id",$merchant_user_id)->
            where("salesmemo.created_at",">=",$from)->
            where("salesmemo.created_at","<=",$to)->
            where("salesmemo.fairlocation_id",$location_id)->
            whereNotNull("salesmemo.confirmed_on")->
            //whereNotNull("salesmemo.consignment_account_no")->
            whereNull("salesmemo.deleted_at")->
            select(DB::raw("
				sum(salesmemoproduct.quantity * salesmemoproduct.price) as sale,
				salesmemo.id,
				salesmemo.salesmemo_no,
				salesmemo.status,
				salesmemo.created_at
                "))->
            groupBy("salesmemo.salesmemo_no")->
            orderBy("salesmemo.salesmemo_no","DESC")->
            get();

			//Log::debug($data);


            /* Sales Summary */
            $day=DB::table("salesmemo")-> 
                join("salesmemoproduct","salesmemoproduct.salesmemo_id","=",
					"salesmemo.id")->
                whereDate('salesmemo.created_at',">=",Carbon::today())->
                whereNull("salesmemo.deleted_at")->
                whereNotNull("salesmemo.confirmed_on")->
                where("salesmemo.status","active")->
                where("salesmemo.fairlocation_id",$location_id)->
                select(DB::raw("
				SUM(salesmemoproduct.quantity*salesmemoproduct.price) as sale
                    "))
                ->get(); 

            $month=DB::table("salesmemo")-> 
                join("salesmemoproduct","salesmemoproduct.salesmemo_id","=",
					"salesmemo.id")->
				where("salesmemo.created_at",">=",$from)->
				where("salesmemo.created_at","<=",$to)->
				whereNull("salesmemo.deleted_at")->
				where("salesmemo.status","active")->
				whereNotNull("salesmemo.confirmed_on")->
                where("salesmemo.fairlocation_id",$location_id)->
                select(DB::raw("
				SUM(salesmemoproduct.quantity*salesmemoproduct.price) as sale
				"))
                ->get();

			Log::debug('location_id='.$location_id);
			Log::debug($month);
			Log::debug($day);

            $ret["data"]=$data;
            $ret["month"]=$month;
            $ret["day"]=$day;

        } catch (\Exception $e) {
			Log::error($e->getFile().':'.$e->getLine().':'.$e->getMessage());
            $ret['long_message']=$e->getMessage();
            $e=500;
        }
        return response()->json($ret,$e);
    }

    public function sales_memo_info($r,$sales_memo)
    {
        $data=DB::table('salesmemo')
        ->join('salesmemoproduct','salesmemoproduct.salesmemo_id','=','salesmemo.id')
        ->join('product','product.id','=','salesmemoproduct.product_id')
        ->leftJoin('productqr','productqr.product_id','=','product.id')
        ->leftJoin('qr_management','productqr.qr_management_id','=','qr_management.id')
        ->where('salesmemo.id',$r->sid)
        ->whereNull('salesmemo.deleted_at')
        ->whereNull('salesmemoproduct.deleted_at')
        ->select('product.id','product.name','product.photo_1','salesmemoproduct.quantity','salesmemoproduct.price','salesmemoproduct.status','qr_management.image_path')->get();
        // $company=DB::table
        $salesman=DB::table('salesmemo')
            ->leftJoin("users",'users.id','=','salesmemo.creator_user_id')
           
            ->where('salesmemo.id',$r->sid)
            ->whereNull("salesmemo.deleted_at")
            ->select("users.id","users.first_name","users.last_name")
            ->first();

      
            $salesman->nbuyer_id=UtilityController::nsid($salesman->id,10,"0");
        
       
        $location=DB::table("salesmemo")->
			leftJoin('fairlocation','fairlocation.id','=','salesmemo.fairlocation_id')->
			leftJoin('address','fairlocation.address_id','=','address.id')->
			leftJoin('city','address.city_id','=','city.id')->
			leftJoin('state','city.state_code','=','state.code')->
	  
			where('salesmemo.id',$r->sid)->
			select('fairlocation.id','fairlocation.company_name',
				'fairlocation.location','address.line1','address.line2',
				'address.line3','city.name','state.name','address.postcode')
			->first();

         $company=DB::table('company')->
                join('fairlocation','fairlocation.user_id','=','company.owner_user_id')->
                join('merchant','merchant.user_id','=','company.owner_user_id')->
                leftJoin('address','merchant.address_id','=','address.id')->
                    leftJoin('city','address.city_id','=','city.id')->
                    leftJoin('state','city.state_code','=','state.code')->
              
                    where('fairlocation.id',$location->id)->
                    select("company.dispname",'address.line1','address.line2','address.line3','city.name','state.name','address.postcode',"merchant.gst")
                    ->first();
        /*Format It*/
        foreach ($data as $product) {
            $limit=80;
            if (strlen($product->name)>$limit) {
                # code...
                $product->name=substr($product->name,0,80)."..";
            }
            
            $product->image_uri=asset('images/product/'.$product->id.'/'.$product->photo_1);
            $product->qr_uri=asset('images/qr/product/'.$product->id.'/'.$product->image_path).".png";
        }
        return response(json_encode(['data'=>$data,'sales_memo'=>$sales_memo,'location'=>$location,'company'=>$company,'salesman'=>$salesman],JSON_UNESCAPED_SLASHES)); 

    }

    public function sales_memo_summary(Request $r)
    {
        if (!$r->has('sid')) {
            return response()->json(['status'=>'failure','long_message'=>"Invalid sales_memo id."],401);
        }

        // DB::table('salesmemo')
        // ->join('users')
    }


    public function sales_memo_void($r,$salesmemo)
    {
        /*Roll back*/
        $salesmemoproducts=DB::table("salesmemoproduct")
        ->where("salesmemo_id",$salesmemo->id)->whereNull("deleted_at")
        ->get();
        foreach ($salesmemoproducts as $s) {
            $old_lp=DB::table("locationproduct")->where("location_id",$salesmemo->fairlocation_id)->where("product_id",$s->product_id)->
            orderBy("locationproduct.created_at","DESC")->
            first(); 
            if (!empty($old_lp)) {
                # code...
                $rolled_back_quantity=$old_lp->quantity+$s->quantity;
            }else{
                $rolled_back_quantity=$s->quantity;
            }
            
            DB::table("locationproduct")
                 ->insert(
                        [
                            "product_id"=>$s->product_id,
                            "location_id"=>$salesmemo->fairlocation_id,
                         
                            "quantity"=>$rolled_back_quantity,
                            "created_at"=>Carbon::now(),
                            "updated_at"=>Carbon::now()
                        ]
                    );
        }
        DB::table('salesmemo')
        ->where('id',$r->sid)
        ->update([
            "status"=>"voided",
            "updated_at"=>Carbon::now()
            ]);
        $debug= DB::table('salesmemo')
        ->where('id',$r->id)->first();
        return response()->json(['status'=>'success','debug'=>$debug],200);
    }

    public function salesmemo(Request $r)
    {
        if (!$r->has('sid')) {
            return response()->json(['status'=>'failure'],401);
        }

        if ($r->has('sid') and $r->has('action')) {
            $sales_memo=DB::table('salesmemo')
            ->join("users",'users.id','=','salesmemo.creator_user_id')
            ->where('salesmemo.id',$r->sid)
            ->whereNull("salesmemo.deleted_at")
            ->select("salesmemo.*","users.first_name","users.last_name")
            ->first();
            if (empty($sales_memo) and $r->action!="update") {
                return response()->json(['status'=>'failure'],405);
            }
            
            
            switch ($r->action) {
                case 'update':
                    if ( !empty($sales_memo) and
						 ($sales_memo->status=="voided" or $sales_memo->status=="frozen")) {
                        return response()->json(['status'=>'failure'],403);
                    }

                    /* Create new sales memo if empty */ 
                    if (empty($sales_memo)) {
                        $sales_memo=DB::table('salesmemo')->
							where('id',$this->sales_memo_new($r->location_id))->
							first();
                    }
                    return $this->sales_memo_update($r,$sales_memo);
                    break;

                case 'info':
                    return $this->sales_memo_info($r,$sales_memo);
                    break;

                case 'confirm':
                    return $this->sales_memo_confirm($r,$sales_memo);
                    break;
                
                case 'delete':
                    DB::table('salesmemo')
                    ->where('id',$r->sid)
                    ->update([
                        "deleted_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                        ]);
                    $debug = DB::table('salesmemo')->
						where('id',$r->id)->first();
                    return response()->json([
						'status'=>'success','debug'=>$debug],200);
                    break;

                case 'void':
                    /*Update Product consignment*/
                    if ( !empty($sales_memo) and
                         ($sales_memo->status=="voided" or $sales_memo->status=="frozen")) {
                        return response()->json(['status'=>'failure'],403);
                    }
                    return $this->sales_memo_void($r,$sales_memo);
                    # code...
                    break;

                case 'barcode':
                    return $this->qr_barcode($r->sid);
                    break;

                default:
                    # code...
                    break;
            }
        }
    }

    public function years_month($company_id=null)
    {
        // $company_id=6;
        $merchant_user_id=DB::table("company")->where("id",$company_id)->pluck("owner_user_id");
        $ret=array();
        try {
            $data=DB::select(DB::raw("
            SELECT     MONTH(salesmemo.created_at) AS month, YEAR(salesmemo.created_at) AS year
            FROM         salesmemo
            JOIN salesmemoproduct on salesmemoproduct.salesmemo_id=salesmemo.id
            JOIN fairlocation ON fairlocation.id = salesmemo.fairlocation_id

            WHERE fairlocation.user_id=$merchant_user_id

            AND  (salesmemo.status='active' OR salesmemo.status='frozen')
            
            GROUP BY MONTH(created_at), YEAR(created_at)
                "));
            $ret=array();
            foreach ($data as $d) {
                array_push($ret,$d->month);
            }
            $ret=array_unique($ret);

        } catch (\Exception $e) {
            $ret["error"]=$e->getMessage();
            $ret["line"]=$e->getLine();
        }
        return response()->json($ret);
    }

    public function cacct(Request $r)
    {   
        $ret=array();

        $user = JWTAuth::parseToken()->authenticate();

        if (empty($user)) {
            $ret["error"]="User doesn't exist";
            return response()->json($ret,403);
        }
        if (!$r->has("company_id")  or !$r->has("location_id")) {
            $ret["error"]="Bad Parameters";
            return response()->json($ret,500);
        }

        if ($r->action=="save" and !$r->has("consignment_no")) {
            $ret["error"]="Bad Parameters, missing consignment_no";
            return response()->json($ret,500);
        }
        $company=DB::table("company")->whereNull("deleted_at")
        ->where("id",$r->company_id)->first();
        if (empty($company)) {
            $ret["error"]="Company doesn't exist";
            return response()->json($ret,500);
        }
        $merchant=DB::table("merchant")
        ->where("user_id",$company->owner_user_id)
        ->whereNull("deleted_at")
        ->orderBy("created_at")
        ->first();
        if (empty($merchant)) {
            $ret["error"]="Merchant doesn't exist";
            return response()->json($ret,500);
        }

        $does_exist=DB::table("cacctno")
        ->whereNull("deleted_at")
        ->where("location_id",$r->location_id)
        ->where("merchant_id",$merchant->id)
        ->where("acctno",$r->consignment_no)
        ->first();

        switch ($r->action) {
            case 'save':
                if (!empty($does_exist)) {
                    $ret["error"]="Consignment Number already exists";
                    return response()->json($ret,555);
                }
                return $this->save_cacct($r,$merchant);
                break;
            case 'delete':
                if (empty($does_exist)) {
                    $ret["error"]="Consignment Number does not exists1";
                    return response()->json($ret,500);
                }
                return $this->delete_acct($r,$does_exist);
                break;
            default:
                # code...
                break;
        }
    }

    public function save_cacct($r,$merchant)
    {
        $to_insert=[
            "location_id"=>$r->location_id,
            "merchant_id"=>$merchant->id,
            "acctno"=>$r->consignment_no,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ];

        $cacct_id=DB::table("cacctno")
        ->insertGetId($to_insert);
        $ret=array();
        $ret["id"]=$cacct_id;
        return response()->json($ret);
    }

    public function delete_acct($r,$acct)
    {
        DB::table("cacctno")
        ->where("id",$acct->id)
        ->update(
            [
                "deleted_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ]
            );
        $ret=array();
        $ret["id"]=$acct->id;
        return response()->json($ret,200);
    }

    public function cacct_list(Request $r)
    {
        $ret=array();

        $user = JWTAuth::parseToken()->authenticate();

        if (empty($user)) {
            $ret["error"]="User doesn't exist";
            return response()->json($ret,403);
        }
        if (!$r->has("company_id")  or !$r->has("location_id")) {
            $ret["error"]="Bad Parameters";
            return response()->json($ret,500);
        }
        $company=DB::table("company")->whereNull("deleted_at")
        ->where("id",$r->company_id)->first();
        if (empty($company)) {
            $ret["error"]="Company doesn't exist";
            return response()->json($ret,500);
        }
        $merchant=DB::table("merchant")
        ->where("user_id",$company->owner_user_id)
        ->whereNull("deleted_at")
        ->orderBy("created_at")
        ->first();
        if (empty($merchant)) {
            $ret["error"]="Merchant doesn't exist";
            return response()->json($ret,500);
        }

        $list=DB::table("cacctno")->where("location_id",$r->location_id)
        ->where("merchant_id",$merchant->id)
        ->whereNull("deleted_at")
        ->orderBy("created_at","DESC")
        ->select("id","acctno")
        ->get();
        return response()->json(compact("list"));
    }

    public function qr_barcode($value)
    {
        $ret=array();
        $ret["qr"]=base64_encode(QrCode::format("png")->size(75)->generate($value));
        $ret["barcode"]=DNS1D::getBarcodePNG($value,"C128");
        return response()->json($ret);
    }
}
