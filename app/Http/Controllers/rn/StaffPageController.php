<?php

namespace App\Http\Controllers\rn;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use JWTAuth;
use Carbon;

class StaffPageController extends Controller
{
    public function get_companies()
    {
        $ret=array();
        try {
            $user = JWTAuth::parseToken()->authenticate();

			$staff=DB::table('member')->
				join('company','company.id','=','member.company_id')->

                join('fairlocation','fairlocation.user_id','=',
					'company.owner_user_id')->
            /*    join('branch','branch.location_id','=','fairlocation.id')->*/
                join('locationusers','fairlocation.id','=','locationusers.location_id')->
                leftJoin("warehouse","warehouse.location_id","=","fairlocation.id")->
				where('member.user_id',$user->id)->
                where('locationusers.user_id',$user->id)->
                whereNull('locationusers.deleted_at')->
				select("company.id","company.dispname","warehouse.id as warehouse_id",
					"fairlocation.location","fairlocation.id as location_id")->
                distinct("location_id")->
				whereNull('company.deleted_at')->
				whereNull('member.deleted_at')->
				get();
            Log::info($staff);
			/*$owner=DB::table('company')->where('owner_user_id',$user->id)->
				select("id","dispname")->
				whereNull('deleted_at')->
				get();*/
            
            // $ret=array_unique($ret);
            /*Intelligent Merge*/
         /*   $i=0;
            foreach ($owner as $o) {
                foreach ($staff as $s) {
                    if ($s->id==$o->id) {
                        unset($owner[$i]);
                    }
                }
				$i++;
            }*/
           /* $merged=array_merge($staff,$owner);*/
            $raw_ret=array();

            /* 
            Format data 
                [[
                    dispname,
                    [{location,location_id,company_id}]
                }]
            */
            
            foreach ($staff as $m) {
                Log::debug((array)$m);
                $key=$m->dispname;
                try {
                    $temp_contant=$raw_ret[$key];
                    
                } catch (\Exception $e) {
                    $temp_contant=array();
                }
                
                array_push($temp_contant,[
					"location"=>$m->location,
					"location_id"=>$m->location_id,
					"company_id"=>$m->id,
                    "warehouse_id"=>$m->warehouse_id
                    ]);

                $raw_ret[$key]=$temp_contant;

            }
            Log::info($raw_ret);
            $ret=array();
            foreach ($raw_ret as $c=>$rr) {
                
                $temp=array();
                $temp["title"]=$c;
                $temp["content"]=$rr;
                array_push($ret,$temp);
            }
            // array_unique($ret);
            
        } catch (\Exception $e) {
            // dump($e);
            Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
            $ret['error']=$e->getMessage();
        }
        // $ret['debug']=[$owner,$staff,$user];
        return response()->json($ret);
    }

    public function get_fairlocations($company_id)
    {
        $ret=array();
        try {
            /**/
			$user_id=DB::table('company')->
				where('id',$company_id)->
				pluck('owner_user_id');

			$ret=DB::table('fairlocation')->
				where('user_id',$user_id)->
				select("fairlocation.location","fairlocation.id")->
				get(); 

        } catch (\Exception $e) {
            $ret['error']=$e->getMessage();
        }
        return response()->json($ret);
    }

    public function get_inventory()
    {
        # Get tagged inventories.
        $ret=array();
        try {
            $user = JWTAuth::parseToken()->authenticate();
			$sproducts=DB::table('member')->
				join('company','member.company_id','=','company.id')->
				join('merchant','merchant.user_id','=','company.owner_user_id')->
				join('merchantproduct','merchant.id','=','merchantproduct.merchant_id')->
				join('product','merchantproduct.product_id','=','product.parent_id')->
				join('nproductid','nproductid.product_id','=','product.id')->
				where('member.user_id',$user->id)->
				whereNull('member.deleted_at')->
				where('member.status','active')->
				select("product.id","product.name","product.photo_1","nproduct.nproduct_id")->
				get();

            $oproducts=DB::table('merchantproduct')
                ->join("merchant","merchant.id","=","merchantproduct.merchant_id")
                ->join("product","merchantproduct.product_id","=","product.parent_id")
                ->join("users","users.id","=","merchant.user_id")
                ->join('nproductid','nproductid.product_id','=','product.id')
                ->whereNull("merchantproduct.deleted_at")
                ->where("users.id",$user->id)
                ->select("product.id","product.name","product.thumb_photo as photo_1","nproduct.nproduct_id")
                ->get();

			$i=0;
            foreach ($oproducts as $o) {
                foreach ($sproducts as $s) {
                    if ($s->id==$o->id) {
                        unset($oproducts[$i]);
                    }
                }
                $i++;
            }
            $products=array_merge($sproducts,$oproducts);
            foreach ($products as $product) {
                // $product->name=substr($product->name,0,10)."..";
                $product->image_uri=asset('images/product/'.$product->id.'/'.$product->photo_1);
                // $product->qr_uri=asset('images/qr/product/'.$product->id.'/'.$product->image_path).".png";
            }
            $ret['products']=$products;
        } catch (\Exception $e) {
            $ret['error']=$e->getMessage();
        }
        return response(json_encode($ret,JSON_UNESCAPED_SLASHES));
    }

    public function get_summary($company_id=null)
    {
        /*Hardcoded Company Id*/
        // $company_id=6;

        $created=DB::table("stockreport")->
			join("stockreportproduct","stockreportproduct.stockreport_id",
				"=","stockreport.id")->
			join("fairlocation","stockreport.creator_location_id",
				"=","fairlocation.id")->
			whereRaw('Date(stockreport.created_at) = CURDATE()')->
			where("stockreport.creator_company_id",$company_id)->
			groupBy("stockreport.id")->
			select(DB::raw("
                COUNT(DISTINCT(stockreport.id)) as count,
                fairlocation.location
            "))->
			groupBy("fairlocation.location")->
			get();

        // dump($created);

		//Log::debug($created);

        $checked=DB::table("stockreport")->
			join("stockreportproduct","stockreportproduct.stockreport_id",
				"=","stockreport.id")->
			join("fairlocation","stockreport.checker_location_id",
				"=","fairlocation.id")->
			whereRaw('Date(stockreport.created_at) = CURDATE()')->
			// whereRaw("stockreport.creator_company_id <> stockreport.checker_company_id")->
			where("stockreport.checker_company_id",$company_id)->
			select(DB::raw("
                COUNT(DISTINCT(stockreport.id)) as count,
                fairlocation.location
            "))->
			groupBy("fairlocation.location")->
			get();

		//Log::debug($checked);

        /* Get Losses */ 
        $stockreports=DB::table("stockreport")->
			join("stockreportproduct","stockreportproduct.stockreport_id",
				"=","stockreport.id")->
			join("fairlocation as f1","stockreport.creator_location_id",
				"=","f1.id")->
			// join("fairlocation as f2","stockreport.checker_location_id","=","f2.id")->
			whereRaw('Date(stockreport.created_at) = CURDATE()')->
			// where("stockreport.checker_company_id",$company_id)->
			where("stockreportproduct.quantity","!=",
				"stockreportproduct.received")->
			where("stockreport.status","confirmed")->
			where("stockreport.creator_company_id",$company_id)->
			select(DB::raw("
                stockreport.id,
                stockreport.ttype,
                stockreportproduct.opening_balance,
                stockreportproduct.quantity,
                stockreportproduct.received,
                f1.location,
                stockreport.created_at
            "))->
			get();

        // dump($stockreports);

		//Log::debug($stockreports);

        $filtered=array();
        $losses=[];
        foreach ($stockreports as $s) {
		// dump($filtered);
		// dump($losses);
		if (!in_array($s->id,$filtered)) {
			if (($s->ttype!="stocktake" and $s->quantity!=$s->received)||
				($s->ttype=="stocktake" and $s->opening_balance>$s->quantity)
				) {
				Log::debug("ttype=".$s->ttype.", ob=".$s->opening_balance.
					", qty=".$s->quantity.", recv=".$s->received);

				array_push($filtered,$s->id);
				try {
					$losses[$s->location]+=1;
				} catch (\Exception $e) {
					$losses[$s->location]=1;
				}
			}
		}
        }

        /* Format Data */ 
        $report=array();
        foreach ($losses as $key => $value) {
            $report[$key]["loss"]=$value;
        }

        foreach ($created as $key =>$value) {
            try {
                $report[$value->location]["created"]+=$value->count;
            } catch (\Exception $e) {
                $report[$value->location]["created"]=$value->count;
            }
        }

        foreach ($checked as $key =>$value) {
            try {
                $report[$value->location]["checked"]+=$value->count;
            } catch (\Exception $e) {
                $report[$value->location]["checked"]=$value->count;
            }
        }

        /* SalesMemo */
        $salesmemo=DB::table("salesmemo")->
			join("fairlocation","salesmemo.fairlocation_id",
				"=","fairlocation.id")->
			join("salesmemoproduct","salesmemoproduct.salesmemo_id",
				"=","salesmemo.id")->
			join("company","company.owner_user_id",
				"=","fairlocation.user_id")->
			whereDate('salesmemo.created_at',">=",Carbon::today())->
			whereNull("salesmemo.deleted_at")->
			whereNotNull("salesmemo.confirmed_on")->
			where("company.id",$company_id)->
            where("salesmemo.status","active")->
            where("salesmemo.status","frozen")->
			select(DB::raw("
                SUM(salesmemoproduct.quantity*salesmemoproduct.price) as sale,
                fairlocation.location
            "))->
			groupBy("fairlocation.location")->
			get();

        return response()->json(compact("salesmemo","report"));
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function sales_by_location($company_id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        /*Validate for role.*/
        /*Validation ends.*/
        try{
            $opossum_sales_query="

                SELECT 

                SUM(ops.quantity*ops.price) as price,
                ops.discount as discount,
                ops.servicecharge as servicecharge

                FROM 

                opos_receiptproduct ops 

                JOIN opos_receipt orp on orp.id=opos.receipt_id

                /*JOIN opos_terminal otl on otl.id=orp.terminal_id*/

                JOIN opos_locationterminal oltm on oltm.terminal_id=orp.terminal_id
                JOIN fairlocation f on f.id=oltm.location_id

            ";
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
}
