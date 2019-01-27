<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Carbon;
use Session;
use Auth;
class SalesLogController extends Controller
{

	/*
   public function entry(Requests $r,$action)
   {
       if (empty($action)) {
		   return response()->json([
			   "status"=>"failure",
			   "short_message"=>"action missing!"
		   ]);
		}

		switch ($action) {
			case 'save_saleslog':
				return $this->save_saleslog($r);
				break;

		case 'pay_saleslog':
			return $this->pay_saleslog($r);
			break;

		default:
			return response()->json([
			"status"=>"failure","short_message"=>"action unrecognised"]);
       }
   }
	 */

   //-----------------------------------------
   // Created by Zurez
   //-----------------------------------------
   
   public function save_saleslog(Request $r,$uid=NULL)
   {
	   Log::debug('*********** save_saleslog() ************');
       $ret=array();
       $ret["status"]="failure";
       if(!Auth::check()){return "";}
       $user_id=Auth::user()->id;
       if(!empty($uid) and Auth::user()->hasRole("adm")){
           $user_id=$uid;
       }
       try{
           $table="opos_saleslog";
           
           $receipt_id=$r->active_receipt_id;
           $terminal_id=$r->terminal_id;

		   /* Get all products from the receipt and transfer to saleslog.
		   * Then delete the receipt */
           $receiptproducts=DB::table('opos_receiptproduct')
           ->where('receipt_id',$receipt_id)
           ->whereNull('deleted_at')
           ->get();
           foreach ($receiptproducts as $product) {

               for ($i=0; $i < $product->quantity ; $i++) {
                   
                   $insert_data=[
                        "product_id"=>$product->product_id,
                        "status"=>"active",
                        "price"=>$product->price,
                        "discount"=>$product->discount,
                        "quantity"=>1,
                        "receiptproduct_id"=>$product->id,
                        "terminal_id"=>$terminal_id,
                        "updated_at"=>Carbon::now(),
                        "created_at"=>Carbon::now()
                   ];
                   DB::table('opos_saleslog')->insert($insert_data);
               } 
           }
           DB::table('opos_receipt')->where('id',$receipt_id)
           ->update(["deleted_at"=>Carbon::now()]);
   
           DB::table('opos_receiptproduct')->where('receipt_id',$receipt_id)
           ->update(["deleted_at"=>Carbon::now()]);
           $ret["status"]="success";
           
       }
       catch(\Exception $e){
           $ret["short_message"]=$e->getMessage();
		   Log::error("Error @ ".$e->getLine()." file ".$e->getFile().
			   " ".$e->getMessage());
       }
       return response()->json($ret);
   }

   //-----------------------------------------
   // Created by Zurez
   //-----------------------------------------
   
   public function fetch_saleslog(Request $r,$uid=NULL)
   {
	   Log::debug('***** fetch_saleslog() *****');
       $data=(object)array();
       if(!Auth::check()){return "";}
       $user_id=Auth::user()->id;
       if(!empty($uid) and Auth::user()->hasRole("adm")){
           $user_id=$uid;
       }
	   $log=DB::table("opos_logterminal")->
		   where('terminal_id',$r->terminal_id)->
		   whereNull('deleted_at')->
		   select(DB::raw("max(eod) as llimit"))->
		   first();

	   Log::debug('***** log *****');
	   Log::debug(json_encode($log));

        $lowerlimit=$log->llimit;

        $starttimes = date('Y-m-d 00:00') ;
        $endtimes = date('Y-m-d 23:59');
        //convert Datetime to date only
        if(!empty($r->terminal_id)){
          $Eodtimes = app('App\Http\Controllers\OposEodController')->eod_times($r->terminal_id);
         
          $starttimes = date('Y-m-d H:i',$Eodtimes['starttimes']);

          // $endtimes= strtotime("+5 mins",$Eodtimes['endtimes']);
          // $endtimes = date('Y-m-d H:i:s',$Eodtimes['endtimes']);
          $endtimes = date('Y-m-d H:i',strtotime("+5 mins",$Eodtimes['endtimes']));
        }
       try{
		$data=DB::table("opos_saleslog")->
			join("product","product.id","=","opos_saleslog.product_id")->
      join("opos_receiptproductsaleslog","opos_receiptproductsaleslog.saleslog_id","=","opos_saleslog.id")->
      join("opos_receiptproduct","opos_receiptproduct.id","=","opos_receiptproductsaleslog.receiptproduct_id")->
      // join("opos_receipt","opos_receipt.id","=","opos_receiptproduct.receipt_id")->
			leftJoin('hcap_productcomm','hcap_productcomm.product_id','=',
			   'opos_saleslog.product_id')->
			leftJoin('member','member.id','=','opos_saleslog.masseur_id')->
			leftJoin('users','users.id','=','member.user_id')->
			leftJoin('nstaff','nstaff.member_id','=','member.id')->
			leftJoin('opos_lockerkeytxn','opos_lockerkeytxn.id','=',
			   'opos_saleslog.lockerkeytxn_id')->
			leftJoin('opos_ftype','opos_ftype.id','=',
			   'opos_lockerkeytxn.lockerkey_ftype_id')->
			leftJoin('opos_ftype as os','os.id','=',
			   'opos_saleslog.sparoom_ftype_id')->
			where('opos_saleslog.terminal_id',$r->terminal_id)->
			whereNull("opos_saleslog.deleted_at")->
			// whereRaw('DATE(opos_saleslog.created_at)=CURDATE()')->
      // whereBetween('opos_saleslog.created_at', array($starttimes , $endtimes))->

       whereRaw(DB::raw("DATE_FORMAT(opos_saleslog.created_at,'%Y-%m-%d %H:%i') BETWEEN '".$starttimes."' AND '".$endtimes."'"))->

			select(DB::raw("if(opos_receiptproduct.status = 'voided',opos_receiptproduct.status,opos_saleslog.status) as `status`"),
        "product.id","nstaff.nickname",
			   "product.name","product.thumb_photo","opos_saleslog.discount",
			   "opos_saleslog.price","opos_saleslog.discount_id",
			   "opos_saleslog.id as saleslog_id","opos_saleslog.masseur_id",
			   "opos_saleslog.lockerkeytxn_id","opos_saleslog.start",
			   "opos_saleslog.end","hcap_productcomm.id as comm_id",
			   "users.name as uname",'users.username','users.first_name',
			   'opos_ftype.id as ftype_id','opos_ftype.fnumber',
			   'opos_lockerkeytxn.checkout_tstamp as txn_checkout',
			   'os.fnumber as snumber','os.id as stype_id',
			   'opos_saleslog.sparoom_ftype_id')->
			groupBy('opos_saleslog.id')->
			orderBy("opos_saleslog.id","DESC")->
			get();
			Log::debug('***** data *****');
			Log::debug(json_encode($data));


       } catch(\Exception $e){
           
           Log::error("Error @ ".$e->getLine()." file ".
		   	$e->getFile()." ".$e->getMessage());
       }
    
       return $data;
   }


   public function fetch_lockerkeys(Request $r){
      $location_id=$this->get_location_id($r->terminal_id);
      $txn_id=DB::table('opos_saleslog')
      ->where('id',$r->saleslog_id)
      ->pluck('lockerkeytxn_id');
      if (empty($txn_id)) {
        # code...
        $txn_id=0.1;      
      }
      return $this->lockerkeys($location_id,$txn_id);
   }

   public function fetch_sparooms(Request $r){
      $location_id=$this->get_location_id($r->terminal_id);
      $txn_id=DB::table('opos_saleslog')
      ->where('id',$r->saleslog_id)
      ->pluck('sparoom_ftype_id');
      if (empty($txn_id)) {
        # code...
        $txn_id=0.1;
      }
      return $this->sparooms($location_id,$txn_id);
   }


	public function fetch_masseurs(Request $r)
	{
		$location_id=$this->get_location_id($r->terminal_id);
		//$data=$this->fetch_members($location_id,$r->product_id);
		$data=$this->fetch_members($location_id);
		return response()->json([
			'data'=>$data,
			'status'=>"success"
		]);
	}


   public function lockerkeys($location_id,$txn_id=NULL)
   {
      
       /*
        return  DB::table('opos_ftype')
                ->leftJoin('opos_lockerkeytxn','opos_lockerkeytxn.lockerkey_ftype_id','=','opos_ftype.id')  
                        
                ->whereNull("opos_ftype.deleted_at")
               //->whereNotNull('opos_lockerkeytxn.checkin_tstamp')
               ->whereNull('opos_lockerkeytxn.checkout_tstamp')
                ->where('opos_ftype.ftype','lockerkey')
                ->where('opos_ftype.location_id',$location_id)
                ->select('opos_ftype.id','opos_ftype.fnumber','opos_lockerkeytxn.id as txn_id')
                ->orderby('opos_ftype.fnumber','asc')
                ->groupBy('opos_ftype.id')

                ->get();*/

        $ftypes=DB::table('opos_ftype')
        ->whereNull('deleted_at')
        ->where('ftype','lockerkey')
        ->where('location_id',$location_id)
        ->orderBy('fnumber','DESC')
        ->get();

        foreach ($ftypes as $ftype) {
            /*Check In DB*/
            $ftype->txn_id=DB::table('opos_lockerkeytxn')
            ->where('lockerkey_ftype_id',$ftype->id)
            ->whereNull('deleted_at')
            ->whereNull('checkout_tstamp')
            ->orderBy('id','DESC')
            ->pluck('id');
        }
          if (empty($txn_id)) {
        # code...
        return $ftypes;
        } 
        return response()->json(["status"=>"success","data"=>$ftypes,'target'=>$txn_id]);
   }

   public function lockerkeys_all($user_id,$txn_id=NULL)
   {
        $ftypes=DB::table('opos_ftype')
        ->join('fairlocation as f','f.id','=','opos_ftype.location_id')
        ->whereNull('opos_ftype.deleted_at')
        ->where('opos_ftype.ftype','lockerkey')
        ->where('f.user_id',$user_id)
        ->orderBy('fnumber','DESC')
        ->get();

        foreach ($ftypes as $ftype) {
            /*Check In DB*/
            $ftype->txn_id=DB::table('opos_lockerkeytxn')
            ->where('lockerkey_ftype_id',$ftype->id)
            ->whereNull('deleted_at')
            ->whereNull('checkout_tstamp')
            ->orderBy('id','DESC')
            ->pluck('id');
        }
          if (empty($txn_id)) {
        # code...
        return $ftypes;
        } 
        return response()->json(["status"=>"success","data"=>$ftypes,'target'=>$txn_id]);
        

   
   }
	public function sparooms($location_id,$txn_id=NULL)
	{
       # code...
        /*$sparoom = DB::table('opos_lockerkeytxnsparoom')
                      ->select('sparoom_ftype_id')
                      ->where('sparoom_checkout',null)
                      ->get();

        $spakeys = array();
        foreach ($sparoom as $value) {
            $spakeys[] = $value->sparoom_ftype_id;
         }

        return  DB::table('opos_ftype')
                ->leftJoin('opos_lockerkeytxnsparoom','opos_lockerkeytxnsparoom.sparoom_ftype_id','=','opos_ftype.id')  
                        
                ->whereNull("opos_ftype.deleted_at")
            ->whereNotNull('opos_lockerkeytxn.checkin_tstamp')
                ->whereNull('opos_lockerkeytxnsparoom.sparoom_checkout')
                ->where('opos_ftype.ftype','sparoom')
                ->where('opos_ftype.location_id',$location_id)
                ->select('opos_ftype.id','opos_ftype.fnumber','opos_lockerkeytxnsparoom.id as txn_id')
                ->groupBy('opos_ftype.id')
                ->orderby('opos_ftype.fnumber','asc')
                ->get();*/

		$ftypes=DB::table('opos_ftype')->
		   whereNull('deleted_at')->
		   where('ftype','sparoom')->
		   where('location_id',$location_id)->
       orderBy('fnumber','DESC')->
		   get();

        foreach ($ftypes as $ftype) {
            /*Check In DB*/
			$ftype->txn_id=DB::table('opos_lockerkeytxnsparoom')->
				where('sparoom_ftype_id',$ftype->id)->
				whereNull('deleted_at')->
				whereNull('sparoom_checkout')->
				orderBy('id','DESC')->
				pluck('id');
		}
    if (empty($txn_id)) {
      # code...
      return $ftypes;
    }
    return response()->json(["status"=>"success","data"=>$ftypes,'target'=>$txn_id]);
        
	}

    public function sparooms_all($user_id,$txn_id=NULL)
  {
       

    $ftypes=DB::table('opos_ftype')->
      join('fairlocation as f','f.id','=','opos_ftype.location_id')->
       whereNull('opos_ftype.deleted_at')->
       where('opos_ftype.ftype','sparoom')->
       where('f.id',$user_id)->
       orderBy('fnumber','DESC')->
       get();

        foreach ($ftypes as $ftype) {
            /*Check In DB*/
      $ftype->txn_id=DB::table('opos_lockerkeytxnsparoom')->
        where('sparoom_ftype_id',$ftype->id)->
        whereNull('deleted_at')->
        whereNull('sparoom_checkout')->
        orderBy('id','DESC')->
        pluck('id');
    }
    if (empty($txn_id)) {
      # code...
      return $ftypes;
    }
    return response()->json(["status"=>"success","data"=>$ftypes,'target'=>$txn_id]);
        
  }

//	public function fetch_members($location_id,$product_id)
	public function fetch_members($location_id)
	{
		# Need validation for ownership derived via location_id
		$ret = DB::select(DB::raw("
			SELECT
				m.id,
				u.first_name,
				u.last_name,
				u.name,
				n.nickname,
				u.email,
				l.location
			FROM
				users u,
				users mu,
				roles r,
				role_users ru,
				locationusers lu,
				fairlocation l,
				company c,
				member m
			LEFT JOIN
				opos_saleslog on m.id = opos_saleslog.masseur_id
			LEFT JOIN
				nstaff n on m.id = n.member_id
			WHERE
				ru.user_id=m.user_id and
				m.user_id=u.id and
				ru.role_id=r.id and
				ru.user_id=u.id and
				ru.company_id=c.id and
				m.company_id=c.id and
				l.user_id=c.owner_user_id and
				lu.user_id=u.id and
				lu.location_id=l.id and
				r.slug='mas' and
				m.type = 'member' and
				l.id=$location_id
			GROUP BY
				u.id
			ORDER BY
				cast(n.nickname as unsigned)
		"));

		//Log::debug($ret);
		Log::debug('***** location_id='.$location_id.' *****');

		return $ret;
	}

	public function get_location_id($terminal_id)
	{
		return DB::table("opos_locationterminal")->
			where("terminal_id",$terminal_id)->
			whereNull("deleted_at")->
			pluck("location_id");
    
	}

	public function get_terminal($terminal_id)
	{
		return DB::table('opos_terminal')->
			//select('start_work','end_work')
			where('id',$terminal_id)->
			first();
	}

	public function viewSalesLog(Request $r)
	{
		Log::debug('****** viewSalesLog() *******');
		/* save_saleslog() should be executed HERE!!! */
      $returnvalue = $this->save_saleslog($r);
      $is_eod=false;
      $location_id=$this->get_location_id($r->terminal_id);

      $products=$this->fetch_saleslog($r);
      $lockerkeys=$this->lockerkeys($location_id);
      $sparoomkeys=$this->sparooms($location_id);

      //$members=$this->fetch_members($location_id);
      $members=array();
      $terminal=$this->get_terminal($r->terminal_id);
      
		  $eod= DB::table("opos_logterminal")->
			where("terminal_id",$r->terminal_id)->
			whereNull("deleted_at")->
			whereNotNull("eod")->
			whereRaw('Date(eod) = CURDATE()')->
			orderBy("id","DESC")->
			first();
     
        if (!empty($eod)) {
            $is_eod=true;
        }

		$logged_in_userid = Auth::user()->id;
		Log::debug('logged_in_userid='.$logged_in_userid);

        $cash=$this->getbalance($r->terminal_id,"cash");
        $creditcard=$this->getbalance($r->terminal_id,"creditcard");

		$otherpoints = DB::table('opos_receipt')->
			select(DB::raw("SUM(otherpoints) as otherpoints"))->
			whereRaw('terminal_id = '.$r->terminal_id)->
			whereRaw('status IN ("completed")')->
			// ->whereRaw('Date(created_at) = CURDATE()')
			first();

		$currency= DB::table('currency')->
			where('active', 1)->first()->code;

		$location  = DB::table('opos_locationterminal')->
			select('fairlocation.*','opos_locationterminal.terminal_id')->
			join('fairlocation','opos_locationterminal.location_id','=',
				'fairlocation.id')->
			where('opos_locationterminal.terminal_id',$r->terminal_id)->
			first();
		Log::debug('***** location *****');
		Log::debug(json_encode($location));

		$location_userid = $location->user_id;
		Log::debug('***** location-userid='.$location_userid);

		if ($logged_in_userid == $location_userid) {
			/* Logged in user is actually the merchant via OpenSupermall */
			$member = DB::table('users')->
				where("id",$location_userid);

		} else {
			/* Logged in user is a buyer accessing via OPOSsum */
			$member=\App\Models\OposTerminalUsers::select(
				"opos_terminalusers.terminal_id as terminal_id",
				"fairlocation.location as branch_name",
				"users.id as staffid",
				"users.first_name as first_name",
				"users.last_name as last_name",
				"fairlocation.company_name as company_name",
				"fairlocation.id as location_id")->
				leftJoin("users","users.id","=","opos_terminalusers.user_id")->
				leftJoin("merchant","merchant.user_id","=",
					"opos_terminalusers.user_id")->
				leftJoin("opos_locationterminal as oplt","oplt.terminal_id","=",
					"opos_terminalusers.terminal_id")->
				leftJoin("fairlocation","oplt.location_id","=",
					"fairlocation.id")->
				where("opos_terminalusers.terminal_id", "=", $r->terminal_id)->
				where('users.id',Auth::user()->id)->
				get();
		}

		Log::debug('***** member *****');
		Log::debug(json_encode($member));

        $staffid=0;
        $staffname="--";

        $member=$member->first();
        if(!empty($member)) {
            $staffname = $member->first_name." ".$member->last_name;

			if(empty($member->staffid)){
				$staffid= sprintf("%010d",$member->id);
			} else {
				$staffid= sprintf("%010d",$member->staffid);
            } 
        }

		Log::debug('***** staffid  ='.$staffid);
		Log::debug('***** staffname='.$staffname);

		return view('opposum.trunk.saleslog',
			compact('products','members','terminal','lockerkeys',
				'sparoomkeys','is_eod','cash','creditcard','otherpoints',
				'currency','location','staffname','staffid','eod'));
	}


  public function getbalance($terminal_id,$pay_type)
  {  
      if($pay_type == "cash")
      {
        
        $data=DB::select("
          SELECT opr.cash_received as total_amount,        
              'in' as mode,
              SUM(opcp.quantity*(opcp.price)) as amount,
              SUM((opcp.discount*opcp.quantity*opcp.price)/100) as discount,
              opsc.value as service_charges,
              opr.payment_type as ptype
          FROM 
            opos_receipt opr
            LEFT JOIN opos_receiptproduct opcp on opcp.receipt_id=opr.id
            JOIN users u on u.id=opr.staff_user_id
            LEFT JOIN opos_servicecharge opsc on opsc.id=opr.servicecharge_id
          WHERE opr.terminal_id=$terminal_id    
              AND opr.status IN ('completed','voided')
              AND DATE(opr.created_at) = CURDATE()
              AND opcp.deleted_at IS NULL
          GROUP BY opr.id
          ORDER BY opr.updated_at desc"
        );
      }
      else
      {
        $data=DB::select("
          SELECT (SUM(opcp.quantity*(opcp.price)) - opr.cash_received) as total_amount,        
              'in' as mode,
              SUM(opcp.quantity*(opcp.price)) as amount,
              SUM((opcp.discount*opcp.quantity*opcp.price)/100) as discount,
              opsc.value as service_charges,
              opr.payment_type as ptype
          FROM 
            opos_receipt opr
            LEFT JOIN opos_receiptproduct opcp on opcp.receipt_id=opr.id
            JOIN users u on u.id=opr.staff_user_id
            LEFT JOIN opos_servicecharge opsc on opsc.id=opr.servicecharge_id
          WHERE opr.terminal_id=$terminal_id    
              AND opr.status IN ('completed','voided')
              AND DATE(opr.created_at) = CURDATE()
              AND opcp.deleted_at IS NULL
              AND opr.payment_type ='".$pay_type."'
          GROUP BY opr.id
          ORDER BY opr.updated_at desc"
        );
      }

      Log::debug('************  getbalance() *****************');
      Log::debug(json_encode($data));
        
      $cmlbalance=0;
      foreach($data as $d)
      {
        if($d->total_amount > $d->amount)
        {
          $amount = $d->amount;
        }
        else
        {
          $amount = $d->total_amount;
        }
        if ($d->mode=="in") {
          $cmlbalance+=$amount;
        }
        else{
          $cmlbalance-=$amount;
        }

      }
      return $cmlbalance;
  }



	public function fetch_products(Request $r)
	{
		try {
			return "lol";
		} catch (\Exception $e) {

		}
	}

	public function unselect($saleslog,$type="sparoom")
	{
		$updated_at=Carbon::now();
		switch ($type) {
			case 'lockerkey':
				DB::table('opos_lockerkeytxn')->
					where('id',$saleslog->lockerkeytxn_id)->
					update([
						"updated_at"=>$updated_at,
						"checkout_tstamp"=>$updated_at
					]);
			break;
       
		default:
			DB::table('opos_lockerkeytxnsparoom')->
				where('id',$saleslog->sparoomtxn_id)->update([
					"updated_at"=>$updated_at,
					"sparoom_checkout"=>$updated_at
				]);
		}

		return "ok";
	}

	public function update_saleslog(Request $r)
	{
   
		$timestamp=Carbon::now();
		$update_data=["updated_at"=>$timestamp];
		$saleslog_id=$r->saleslog_id;
		$saleslog=DB::table('opos_saleslog')->
			where('id',$saleslog_id)->
			first();

      $comminationData = DB::table('hcap_productcomm')
      ->where('sales_member_id',$r->id)
      ->where('product_id',$saleslog->product_id)
      ->first();
       
        
		if (empty($saleslog)) { return "failed"; }

		if ($r->id=="unselect") {

			return $this->unselect($saleslog,$r->type);
		}
    $commissionAmount = 0;
    if(isset($comminationData->sales_member_id)){
       $commissionAmount = $comminationData->commission_amt;
    }
		switch ($r->type) {
			case 'masseur':

				$update_data['masseur_id']=$r->id;
        $update_data['commission_amt'] = $commissionAmount;
				break;

			case 'lockerkey':
				$most_recent_record=DB::table("opos_lockerkeytxn")->
					where('lockerkey_ftype_id',$r->id)->
					whereNull('checkout_tstamp')->
					whereNull('deleted_at')->
					orderBy('id','DESC')->
					first();

				/* End any previous transaction for theh saleslog */
				/*DB::table('opos_lockerkeytxn')->
					where('id',$saleslog->lockerkeytxn_id)->
					update([
						"updated_at"=>$updated_at,
						"checkout_tstamp"=>$updated_at
					]);*/
				$update_data['lockerkeytxn_id']=$most_recent_record->id;
				break;

			case 'start':
        
				$update_data['start']=$timestamp;
				break;

			case 'end':
      	$update_data['end']=$timestamp;
				break;
      case 'sparoomstart':
        # code...
        $update_data['sparoom_ftype_id']=$r->id;
        break;
      case 'sparoomstop':
        # code...
        $update_data['sparoom_ftype_id']=NULL;
        break;
			default:
				break;
		}
   
		DB::table("opos_saleslog")->
			where("id",$saleslog_id)->
			update($update_data);
    
		return UtilityController::s_date($timestamp);
	}

  //-----------------------------------------
  // Created by Zurez
  //-----------------------------------------
  
  public function active_months($year=2018,$uid=NULL)
  {
    $ret=array();
    $ret["status"]="failure";
    if(!Auth::check()){return "";}
    $user_id=Auth::user()->id;
    if(!empty($uid) and Auth::user()->hasRole("adm")){
      $user_id=$uid;
    }
    try{
    $raw_data=DB::select(DB::raw("

        SELECT
        MONTH(opos_saleslog.created_at) as months
        FROM
        opos_saleslog 
        JOIN opos_locationterminal olt on olt.terminal_id=opos_saleslog.terminal_id
        JOIN fairlocation as f on f.id=olt.location_id
        WHERE 
        opos_saleslog.deleted_at IS NULL
        AND f.user_id=$user_id
        GROUP BY months
      "));
    $data=array();
    foreach ($raw_data as $k) {
        array_push($data,$k->months);
    }
    
      $ret["status"]="success";
      $ret["data"]=$data;
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
 
 public function active_days(Request $r,$uid=NULL)
 {
   $ret=array();
   $ret["status"]="failure";
   if(!Auth::check()){return "";}
   $user_id=Auth::user()->id;
   if(!empty($uid) and Auth::user()->hasRole("adm")){
     $user_id=$uid;
   }
   try{
    $year=$r->year;
    $month=$r->month;
     
    $data=DB::select(DB::raw("

        SELECT
        MONTH(opos_saleslog.created_at) as month,
        DAY(opos_saleslog.created_at) as day,
        YEAR(opos_saleslog.created_at) as year,
        MONTHNAME(opos_saleslog.created_at) as month_name
        FROM
        opos_saleslog 
        JOIN opos_locationterminal olt on olt.terminal_id=opos_saleslog.terminal_id
        JOIN fairlocation as f on f.id=olt.location_id
        WHERE 
        opos_saleslog.deleted_at IS NULL
        AND f.user_id=$user_id
        AND YEAR(opos_saleslog.created_at)=$year
        AND MONTH(opos_saleslog.created_at)=$month
        GROUP BY day
      "));
     
     $ret["status"]="success";
     $ret["data"]=$data;
   }
   catch(\Exception $e){
     $ret["short_message"]=$e->getMessage();
     Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
   }
   return response()->json($ret);
 }
 
  
  public function view_saleslog_all($terminal_id,$year,$month,$uid=null)
  {
   
      $ret=array();
      $ret["status"]="failure";
      if(!Auth::check()){return "";}
      $user_id=Auth::user()->id;
      if(!empty($uid) and Auth::user()->hasRole("adm")){
      $user_id=$uid;
      }
        $is_eod=false;
        $location_id=$this->get_location_id($terminal_id);
        
        $products=DB::table("opos_saleslog")
           ->join("product","product.id","=","opos_saleslog.product_id")
           ->leftJoin('hcap_productcomm','hcap_productcomm.product_id','=','opos_saleslog.product_id')
           ->leftJoin('member','member.id','=','opos_saleslog.masseur_id')
           ->leftJoin('users','users.id','=','member.user_id')
           ->leftJoin('opos_lockerkeytxn','opos_lockerkeytxn.id','=','opos_saleslog.lockerkeytxn_id')
           ->leftJoin('opos_ftype','opos_ftype.id','=','opos_lockerkeytxn.lockerkey_ftype_id')
           ->leftJoin('opos_ftype as os','os.id','=','opos_saleslog.sparoom_ftype_id')
           ->where('opos_saleslog.terminal_id',$terminal_id)
           ->whereRaw('MONTH(opos_saleslog.created_at)='.$month)
           ->whereRaw('YEAR(opos_saleslog.created_at)='.$year)
         /*  ->where('opos_saleslog.status','active')   */     
           ->whereNull("opos_saleslog.deleted_at")
          
           ->select("opos_saleslog.status","product.id",
        "product.name","product.thumb_photo","opos_saleslog.discount","opos_saleslog.price","opos_saleslog.discount_id","opos_saleslog.id as saleslog_id","opos_saleslog.masseur_id","opos_saleslog.lockerkeytxn_id","opos_saleslog.start","opos_saleslog.end","hcap_productcomm.id as comm_id","users.name as uname",'users.username','users.first_name','opos_ftype.id as ftype_id','opos_ftype.fnumber','opos_lockerkeytxn.checkout_tstamp as txn_checkout','os.fnumber as snumber','os.id as stype_id','opos_saleslog.sparoom_ftype_id')
           ->groupBy('opos_saleslog.id')
            ->orderBy("opos_saleslog.id","DESC")
           ->get();
;
        

        $lockerkeys=$this->lockerkeys_all($location_id);
        $sparoomkeys=$this->sparooms_all($location_id);

        $terminal=$this->get_terminal($terminal_id);
        $members=$this->fetch_members($location_id);
		$member=\App\Models\OposTerminalUsers::select(
                  "opos_terminalusers.terminal_id as terminal_id",
                  "fairlocation.location as branch_name",
                  "users.id as staffid",
                  "users.first_name as first_name",
                  "users.last_name as last_name",
                  "fairlocation.company_name as company_name", "fairlocation.id as location_id")
                  ->leftJoin("users","users.id","=","opos_terminalusers.user_id")
                  ->leftJoin("merchant","merchant.user_id","=","opos_terminalusers.user_id")
                  ->leftJoin("opos_locationterminal as oplt","oplt.terminal_id","=",
                    "opos_terminalusers.terminal_id")       
                  ->leftJoin("fairlocation","oplt.location_id","=","fairlocation.id")
                  ->where("opos_terminalusers.terminal_id", "=", $terminal_id)
                  ->where('users.id',$user_id)
                  ->get();

        $member=$member->first();
        if(!empty($member)) {
            $staffname = $member->first_name." ".$member->last_name;

            if(!empty($member->staffid)){
              $staffid= sprintf("%010d",$member->staffid);
            }
        }
       // dd($products);
        
        $cash=$this->getbalance($terminal_id,"cash");
        $creditcard=$this->getbalance($terminal_id,"creditcard");

        $otherpoints = DB::table('opos_receipt')
                         ->select(DB::raw("SUM(otherpoints) as otherpoints"))
                         ->whereRaw('terminal_id = '.$terminal_id)
                           ->whereRaw('status IN ("completed","voided")')
                           // ->whereRaw('Date(created_at) = CURDATE()')
                           ->first();
        $currency= DB::table('currency')->where('active', 1)->first()->code;


        
       // dd($products);
        return view('seller.opossum.sellersaleslog',compact('products','members','terminal','lockerkeys','sparoomkeys','is_eod','cash','creditcard','otherpoints','currency','location','staffname','staffid'));
   }




	public function view_saleslog_by_range($logterminal_id,$uid=null)
	{
		if(!Auth::check()){return "";}
		$user_id=Auth::user()->id;
		if(!empty($uid) and Auth::user()->hasRole("adm")){
			$user_id=$uid;
		}
     $log=DB::table("opos_logterminal")->where("id",$logterminal_id)->first();

     $start=$log->start_work;
     $eod=$log->eod;
     $terminal_id=$log->terminal_id;

     $location_id=$this->get_location_id($terminal_id);
      $products=DB::table("opos_saleslog")
           ->join("product","product.id","=","opos_saleslog.product_id")
           ->leftJoin('hcap_productcomm','hcap_productcomm.product_id','=','opos_saleslog.product_id')
           ->leftJoin('member','member.id','=','opos_saleslog.masseur_id')
           ->leftJoin('users','users.id','=','member.user_id')
           ->leftJoin('opos_lockerkeytxn','opos_lockerkeytxn.id','=','opos_saleslog.lockerkeytxn_id')
           ->leftJoin('opos_ftype','opos_ftype.id','=','opos_lockerkeytxn.lockerkey_ftype_id')
           ->leftJoin('opos_ftype as os','os.id','=','opos_saleslog.sparoom_ftype_id')
           ->where('opos_saleslog.terminal_id',$terminal_id)
           ->whereRaw('opos_saleslog.created_at BETWEEN "'.$start.'" AND "'.$eod.'"')
    
           ->whereNull("opos_saleslog.deleted_at")
          
           ->select("opos_saleslog.status","product.id",
        "product.name","product.thumb_photo","opos_saleslog.discount","opos_saleslog.price","opos_saleslog.discount_id","opos_saleslog.id as saleslog_id","opos_saleslog.masseur_id","opos_saleslog.lockerkeytxn_id","opos_saleslog.start","opos_saleslog.end","hcap_productcomm.id as comm_id","users.name as uname",'users.username','users.first_name','opos_ftype.id as ftype_id','opos_ftype.fnumber','opos_lockerkeytxn.checkout_tstamp as txn_checkout','os.fnumber as snumber','os.id as stype_id','opos_saleslog.sparoom_ftype_id')
           ->groupBy('opos_saleslog.id')
            ->orderBy("opos_saleslog.id","DESC")
           ->get();
           
			$lockerkeys=$this->lockerkeys_all($location_id);
			$sparoomkeys=$this->sparooms_all($location_id);

			$terminal=$this->get_terminal($terminal_id);
			$members=$this->fetch_members($location_id);
			$member=\App\Models\OposTerminalUsers::select(
                  "opos_terminalusers.terminal_id as terminal_id",
                  "fairlocation.location as branch_name",
                  "users.id as staffid",
                  "users.first_name as first_name",
                  "users.last_name as last_name",
                  "fairlocation.company_name as company_name", "fairlocation.id as location_id")
                  ->leftJoin("users","users.id","=","opos_terminalusers.user_id")
                  ->leftJoin("merchant","merchant.user_id","=","opos_terminalusers.user_id")
                  ->leftJoin("opos_locationterminal as oplt","oplt.terminal_id","=",
                    "opos_terminalusers.terminal_id")       
                  ->leftJoin("fairlocation","oplt.location_id","=","fairlocation.id")
                  ->where("opos_terminalusers.terminal_id", "=", $terminal_id)
                  ->where('users.id',$user_id)
                  ->get();

        $member=$member->first();
        if(!empty($member)) {
            $staffname = $member->first_name." ".$member->last_name;

            if(!empty($member->staffid)){
              $staffid= sprintf("%010d",$member->staffid);
            }
        }
       // dd($products);
        
        $cash=$this->getbalance($terminal_id,"cash");
        $creditcard=$this->getbalance($terminal_id,"creditcard");

        $otherpoints = DB::table('opos_receipt')
                         ->select(DB::raw("SUM(otherpoints) as otherpoints"))
                         ->whereRaw('terminal_id = '.$terminal_id)
                           ->whereRaw('status IN ("completed","voided")')
                           ->whereRaw('opos_receipt.created_at BETWEEN "'.$start.'" AND "'.$eod.'"')
                           // ->whereRaw('Date(created_at) = CURDATE()')
                           ->first();
        $branch=DB::table("fairlocation")->where("id",$location_id)->pluck("location");
        $currency= DB::table('currency')->where('active', 1)->first()->code;


        
       // dd($products);
        $is_eod=true;
        return view('seller.opossum.sellersaleslog',compact('products','members','terminal','lockerkeys','sparoomkeys','is_eod','cash','creditcard','otherpoints','currency','branch','staffname','staffid','start','eod'));

   }

}
