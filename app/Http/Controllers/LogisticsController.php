<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleUser;
use File;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Http\Requests;
use App\Models\Slab;
use App\Models\LogisticSlab;
use App\Models\POrder;
use App\Models\Delivery;
use App\Models\Address;
use App\Models\User;
use App\Models\Station;
use App\Models\Logistic;
use App\Models\Company;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\IdController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CityLinkController as CL;
use App\Models\CtlShip;
use App\Http\Controllers\NinjaVanController as NV;
use App\Models\NvShip;
use DB;
use Auth;
use Carbon;
use Yajra\Datatables\Facades\Datatables;
use Session;
class LogisticsController extends Controller
{
	
	// THE CODE BELOW CALLS THE LOGISTIC
    public function callLogistic(Request $r)
    {
		$order_id = $r->oid;

		$porder = DB::table('porder')->where('id',$order_id)->first();

		if(!is_null($porder)){
			/*
				The 1==1 is to be replaced by validations.
				eg: Order Status Validation
			*/ 
			if(in_array($porder->status,["m-processing1","request-goods"])){
				
				if(1==1){
					$sysname=$this->select_logistic();
					if(!is_null($sysname)){
						switch ($sysname) {
							case 'nv':
								$logController= new NV;
								break;
							case 'ctl':	
								$logController= new CL;
								break;
						}
						//dd($company);
				
						return $logController->callLogistic($r);
					} else {
						return response()->json(['status' => 'failure', 'short_message' => 'LC#000', 'long_message' => 'Something went wrong. Please contact OpenSupport.']);
					}
					
				} else {
					return response()->json(['status' => 'failure', 'short_message' => 'LC#001', 'long_message' => 'Something went wrong. Please contact OpenSupport.']);
				}
				
			} else {
				return response()->json(['status' => 'failure', 'short_message' => 'LC#002', 'long_message' => 'Order status does not allow label download.']);
			}
		} else {
			return response()->json(['status' => 'failure', 'short_message' => 'LC#003', 'long_message' => 'Bad Order ID']);
		}
    }	
	
    public function downloadLabel($order_id, $type = "m2b")
    {
		$porder = DB::table('porder')->where('id',$order_id)->first();
	
		if(!is_null($porder)){
			$delivery = DB::table('delivery')->where('porder_id',$order_id)->first();
			if(!is_null($delivery)){
				$logistic = DB::table('logistic')->where('id',$delivery->logistic_id)->first();
				if(!is_null($logistic)){
					$company = DB::table('company')->where('id',$logistic->company_id)->first();
					if(!is_null($company)){
						switch ($company->sysname) {
							case 'nv':
								$logController= new NV;
								break;
							case 'ctl':	
								$logController= new CL;
								break;
						}
						return $logController->downloadLabel($order_id,$type);

					} else {
						return response()->json([
							'status' => 'failure', 
							'short_message' => 'Server Error LC#DL#001',
							'long_message' => 'Something went wrong. Please contact OpenSupport.LC#DL#001']);
					}
					
				} else {
					return response()->json([
						'status' => 'failure',
						'short_message' => 'Missing Logistic Partner',
						'long_message' => 'Something went wrong. Please contact OpenSupport.LC#DL#002']);
				}
				
			} else {
				return response()->json([
					'status' => 'failure',
					'short_message' => 'Missing Delivery Record',
					'long_message' => 'Something went wrong. Please contact OpenSupport.LC#DL#003']);
			}
		} else {
			return response()->json([
				'status' => 'failure',
				'short_message' => 'Bad Order ID',
				'long_message' => 'Something went wrong. Please contact OpenSupport.LC#DL#004']);
		}
    }	
	
	public function select_logistic_id($logistic_sysname)
	{
		/* By default choose NinjaVan */
		$lid = 3;

		if (empty($logistic_sysname)) {
			$logistic_sysname = $this->select_logistic();
		}

		$log = DB::table('company')->
			join('logistic','logistic.company_id','=','company.id')->
			where('sysname',$logistic_sysname)->
			pluck('logistic.id');

		if(!is_null($log)){
			$lid =  $log;
		}
		return $lid;
	}

	public function select_logistic()
    {
		/* This where our intelligence resides for selection which logisitic
		   provider shall we select based on various criteria or principles */

		/* Currently we hardcode return "nv" for NinjaVan */
		return "nv";
	}
	
	public function get_logistic_details($logistic_sysname, $oid)
    {
		$consignmentNumber = "";
		switch ($logistic_sysname) {
			case 'nv':
				$object = new \stdClass();
				$logController= new NV;
				$resp=$logController->informLogistic($oid,"new",$object);
				if(isset($resp->Error)){
					return json_encode('NotOK');
				}
				$c=$resp->Consignment;
				$consignmentNumber=$c->ConsignmentNumber;
				break;

			case 'ctl':
				$logController= new CL;
				$resp=$logController->informLogistic($oid,"new",$xml);
				if(isset($resp->Error)){
					return json_encode('NotOK');
				}
				$c=$resp->Consignment;
				$consignmentNumber=$c->ConsignmentNumber;
				$serviceType=$c->PackageType;
				$packageType=$c->ServiceType;
				$dStation=$c->DestinationStation;

				// Add validations
				$l= new CtlShip;
				$l->porder_id=$oid;
				$l->ctl_consignment_number=$consignmentNumber;
				$l->ctl_service_type=$serviceType;
				$l->ctl_package_type=$packageType;
				$l->ctl_dstation=$dStation;
				$l->save();					
				break;
		}
		
		return $consignmentNumber;
	}
	
    public function deliverymaster()
    {
		$delivery = DB::select(DB::raw("
		SELECT
			porder.id as porder_id,
			logistic.id as logistic_id,
			merchant.id as merchant_id,
			porder.delivery_tstamp,
			merchant_address.id as merchant_address_id,
			merchant_city.name as merchant_city_name,
			station_address.id as station_address_id,
			station_city.name station_city_name,
			buyer_address.id as buyer_address_id,
			buyer_city.name as buyer_city_name,
			porder.status,
			delivery.status as dstatus,
			SUM(orderproduct.shipping_cost) as fee 
		FROM porder
		JOIN orderproduct ON orderproduct.porder_id = porder.id
		LEFT JOIN sorder ON orderproduct.porder_id = porder.id
		LEFT JOIN station ON sorder.station_id = station.id
		LEFT JOIN address as station_address ON
			station_address.id = station.station_address_id
		LEFT JOIN city as station_city ON
			station_address.city_id = station_city.id
		JOIN product ON orderproduct.product_id = product.id
		JOI merchantproduct ON merchantproduct.product_id = product.parent_id
		JOIN merchant ON merchant.id = merchantproduct.merchant_id
		LEFT JOIN address as merchant_address ON
			merchant_address.id = merchant.address_id
		LEFT JOIN city as merchant_city ON
			merchant_address.city_id = merchant_city.id
		JOIN users ON users.id = porder.user_id
		LEFT JOIN address as buyer_address ON
			buyer_address.id = users.shipping_address_id
		LEFT JOIN city as buyer_city ON buyer_address.city_id = buyer_city.id
		LEFT JOIN logistic ON logistic.id = porder.logistic_id
		GROUP BY porder.id"));
	//	dd($delivery);
		$global = DB::table('global')->first();
        return view('admin.master.delivery')->
			with('delivery',$delivery)->
			with('global',$global);
    }

    public function orders_pagination($lid,$start = 0){
		$end=$start+30;
		$ret=array();
       if (!Auth::check()) {
            return $ret;
        }
        try {
			$ret=Delivery::join('porder','porder.id','=','delivery.porder_id')
				->leftJoin('ndeliveryid', 'ndeliveryid.delivery_id', '=', 'delivery.id')
				->where('delivery.logistic_id',$lid)			
				->select(DB::raw("
						delivery.*,
						porder.status as pstatus,
						IFNULL(ndeliveryid.ndelivery_id,LPAD(delivery.id,16,'E')) as delivery_id,  DATE_FORMAT(delivery.created_at,'%d%b%y %H:%i') as received
						,DATE_FORMAT(delivery.updated_at,'%d%b%y %H:%i') as completed
					"))
				->orderBy('delivery.created_at','DESC');
			//	dd($ret);
        } catch (\Exception $e) {
            // dd($e);
        }
        return Datatables::eloquent($ret)->make(true);			
		
	}
    public function showDashboard($uid = null)
    {
      try {
        $user_id = Auth::user()->id;
      } catch (\Exception $e) {
        return view('common.generic')
        ->with('message_type','error')
        ->with('message','Please log in to access.');
      }
    	if(!is_null($uid)){
			$user_id = $uid;
		}
      // $user_id=1;
	 	$volfactor=DB::table('global')->pluck('volfactor');
		$station = DB::table('station')->where('user_id',$user_id)->first();
		if(!is_null($station)){
			$logistic = DB::table('logistic')->join('station','station.id','=','logistic.station_id')->leftJoin('company','station.user_id','=','company.owner_user_id')->select('logistic.id','logistic.lgrade_id','company.company_name','logistic.volfactor','logistic.professional')->where('station_id',$station->id)->first();

			if(!is_null($logistic)){
				
				if ($logistic->volfactor>0 and !is_null($logistic->volfactor)) {
					$volfactor=$logistic->volfactor;
				}
			$deliverys = null;
			$deliverys=DB::table('delivery')
				->join('porder','porder.id','=','delivery.porder_id')
				->where('delivery.logistic_id',$logistic->id)
				->orderBy('delivery.created_at','DESC')
				->select(DB::raw("
						delivery.*,
						porder.status as pstatus
					"))
				->get();
		
		$slabs=DB::table('slab')
		 // ->join('slab','slab.id','=','logisticslab.slab_id')
          ->where('slab.logistic_id',$logistic->id)->get();		
		$members=array();
        try {
          $members=DB::table('member')
        ->leftJoin('users','users.id','=','member.user_id')
		->join('company','member.company_id','=','company.id')
      //  ->join('logistic','logistic.company_id','=','company.id')
        ->where('company.owner_user_id',$user_id)
        ->select(DB::raw("
            member.*,
            users.first_name as users_first_name,
            users.last_name as users_last_name
          "))
        ->get();
	//	dd($members);
        } catch (\Exception $e) {
          
        }
        // STATEMENT
        $logistic_id=$logistic->id;
        $query = Delivery::leftJoin('orderreturn as op','op.porder_id','=',
			'delivery.porder_id')->
			where('delivery.logistic_id','=',$logistic_id)->
			select('delivery.created_at')->
			orderBy('delivery.created_at','desc')->
			get();                

		$actual_year = Delivery::leftJoin('orderreturn as op','op.porder_id',
			'=','delivery.porder_id')->
			where('delivery.logistic_id','=',$logistic_id)->
			select('delivery.created_at')->
			orderBy('delivery.created_at','desc')->
			first();
					
        $years = Array();$months = Array();$y = Array();$index = 0;
		foreach($query as $que){
			$years[$que->created_at->year][$index] = $que->created_at->month;
			$index++;
		}

        $today = Carbon::today();
        $station = Station::where('user_id' , $user_id)->first();

        $station_address = Address::where('id' , $station->address_id)->
			first(array('line1','line2','line3','line4'));

		$mer = "Logistic ID";
		$id = IdController::nSeller($station->user_id);
        $arr=array(
			'myreturn' => $query,
			'today' => $today,
			'years'=>$years,
			'actual_year'=>$actual_year
		);

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
            } else {
                $current_year = 1;
            }
        }
		$memberroles = DB::table('roles')->where('memberlist',true)->get();
		$b= new BuyerController();
		$autolinks= $b->get_autolink($user_id);

        // STATEMENT
		/*
		dump($years);
		dump($today);
		dump($myreturn);
		dd($actual_year);
		*/
		//dd($memberroles);
		
		return view('logistics.dashboard.index',
			compact('today','myreturn','current_year'))->
				with('deliverys',$deliverys)->
				with('autolinks',$autolinks)->
				with('members',$members)->
				with('memberroles',$memberroles)->
				with('logistic',$logistic)->
				with('slabs',$slabs)->
				with('volfactor',$volfactor)->
				with('years',$years)->
				with('id',$id);
			} else {
				return view('error');
			}
		} else {
			return view('error');
		}
    }

	public function logisticEmployee($id, $user_id)
    {
		$company = DB::table('company')->where('owner_user_id',$user_id)->first();
		$member = DB::table('member')->where('company_id',$company->id)->where('user_id',$id)->join('users as u2','u2.id','=','member.user_id')->leftJoin('users','users.id','=','member.recruiter_id')->select('member.*','users.first_name as recruiter_first_name','users.last_name as recruiter_last_name','u2.first_name as member_first_name','u2.last_name as member_last_name')->first();
		$recruiters = DB::table('users')->join('buyer','users.id','=','buyer.user_id')->where('buyer.user_id','!=',$id)->select('buyer.user_id','users.last_name','users.first_name')->get();
		return view('logistics.dashboard.memberdetail')->with('user_id',$id)->with('member',$member)->with('recruiters',$recruiters);
	}
	
	public function deletemember(Request $r)
    {
		$logistic = DB::table('logistic')->where('id',$r->lpid)->first();
		$station = DB::table('station')->where('id',$logistic->station_id)->first();
		$company = DB::table('company')->where('owner_user_id',$station->user_id)->first();
		DB::table('member')->where('email',$r->email)->where('company_id', $company->id)->delete();
		return response()->json(['status'=>'success']);
	}
	
	public function add_role(Request $r)
    {
		DB::table('role_users')->whereIn('role_id',[15,16,18,19,20,21])->where('user_id',$r->user_id)->delete();
		$valrole = DB::table('roles')->where('name',$r->val)->first();
		if(!is_null($valrole)){
			//DB::table('role_users')->insert(['user_id')
			$role = new RoleUser;
			$role->user_id = $r->user_id;
			$role->role_id = $valrole->id;
			$role->save();		
		} 
		return response()->json(['response'=>$valrole]);
	}
	
	public function add_recruiter(Request $r)
    {
		DB::table('member')->where('user_id',$r->user_id)->update(['recruiter_id'=>$r->val]);
		$res = DB::table('users')->where('id',$r->val)->first();
		/*DB::table('role_users')->whereIn('role_id',[15,16,18,19,20,21])->where('user_id',$r->user_id)->delete();
		$valrole = DB::table('roles')->where('name',$r->val)->first();
		if(!is_null($valrole)){
			//DB::table('role_users')->insert(['user_id')
			$role = new RoleUser;
			$role->user_id = $r->user_id;
			$role->role_id = $valrole->id;
			$role->save();		
		} */
		return response()->json(['response'=>$res->first_name . " " . $res->last_name]);
	}	
	
    public function approveMember() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
         return \App\Classes\AdminApproveHelper::approveMember($inputs);

      }
    }	
	
    public function saveMemberRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        $res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
            $res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
            echo $res;
        }
        //echo "Hola";
    }		
	
    public function member_remarks($id){
		$remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status, nbuyerid.nbuyer_id from remark inner join memberremark on memberremark.remark_id = remark.id join member on memberremark.member_id = member.id left join nbuyerid on member.user_id = nbuyerid.user_id where memberremark.member_id = " . $id . " order by remark.created_at desc"));

		return json_encode($remarks);
	}	
	
	public function send_emails(Request $r)
    {
		
		try{
			$logistic = DB::table('logistic')->
				where('id',$r->lpid)->first();
			$station = DB::table('station')->
				where('id',$logistic->station_id)->first();
			$company = DB::table('company')->
				where('owner_user_id',$station->user_id)->first();
			foreach ($r->emails as $key => $email) {
				$user = DB::table('users')->where('email',$email)->first();
				if(is_null($user)){
					$e= new EmailController;
					$e->employeeRequest($email, $company);
				} else {
					$role = DB::table('roles')->whereIn('id',[15,16,18,19,20,21])->join('role_users','roles.id','=','role_users.role_id')->where('role_users.user_id',$user->id)->select('roles.*')->first();
					if(is_null($role)){
						$e= new EmailController;
						$e->employeeAdded($email, $user, $company);
					} else {
						$e= new EmailController;
						$e->roleAdded($email, $user, $role, $company);
					}
				}
			}
			return response()->json(['status'=>'success']);
		} catch (\Exception $e) {
			//dd($e);
			return response()->json(['status'=>'error',
				'long_message'=>'An unexpected error ocurred! Please contact OpenSupport']);
        }	
	}
	
	public function add_employee(Request $r)
    {
		try{
			$email=$r->email;
			$email = str_replace(" ","",$email);
			$user = DB::table('users')->where('email',$email)->first();
			
			/*$user_id = Auth::user()->id;
			$station = DB::table('station')->
				where('user_id',$user_id)->first();*/
			//$owner_id = $r->userid;

			$logistic = DB::table('logistic')->
				where('id',$r->lpid)->first();
			$station = DB::table('station')->
				where('id',$logistic->station_id)->first();
			$company = DB::table('company')->
				where('owner_user_id',$station->user_id)->first();
			
			/*
			dump($logistic);
			dump($company);
			dump($station);
			*/

			if(!is_null($company) && !is_null($station)){
				$emailexists = DB::table('member')->
					where('email',$email)->
					where('company_id',$company->id)->
					first();

				if(is_null($emailexists)){
					if(is_null($user)){
						$mid = DB::table('member')->
							insertGetId(['email'=>$email,
								'user_id'=>0,'company_id'=>$company->id,
								'member_status'=>'not exists',
								'created_at'=>date('Y-m-d H:i:s'),
								'updated_at'=>date('Y-m-d H:i:s')]);
						
						$newmember = DB::table('member')->
							where('id',$mid)->first();

						$id= new IdController;
						$newid = $id->nB(0);
						$newemployee = array('id'=>$newid,'user_id'=>0,
							'name' => "", 'status' => $newmember->status,
							'role' => '', 'email'=>$email);
						
						return response()->json(['status'=>'success',
							'long_message'=>'Member successfully added',
							'employee'=>$newemployee]);	

					} else {
						$mid = DB::table('member')->
							insertGetId(['email'=>$email,'user_id'=>$user->id,
							'company_id'=>$company->id,'member_status'=>'tagged',
							'created_at'=>date('Y-m-d H:i:s'),
							'updated_at'=>date('Y-m-d H:i:s')]);
						
						/*$roleuserexists = DB::table('role_users')->
							where('user_id',$user->id)->
							where('role_id',18)->first();

						if(is_null($roleuserexists)){
							$role = new RoleUser;
							$role->user_id = $user->id;
							$role->role_id = 18;
							$role->save();	
						}*/
											
						
						$newmember = DB::table('member')->
							where('id',$mid)->first();

						$id= new IdController;
						$newid = $id->nB($user->id);
						$newemployee = array('id'=>$newid,'user_id'=>$user->id,
							'name' => $user->first_name ." ".$user->last_name,
							'status' => $newmember->status, 'role' => 'Member',
							'email'=>$email);
						
						return response()->json(['status'=>'success',
							'long_message'=>'Member successfully added',
							'employee'=>$newemployee]);						
					}
				} else {
					return response()->json(['status'=>'warning',
						'long_message'=>'Member already exists!']);
				} 
			} else {
				return response()->json(['status'=>'error',
				'long_message'=>"Company doesn't exist! Please contact OpenSupport"]);
			}
		} catch (\Exception $e) {
			dd($e);
			return response()->json(['status'=>'error',
				'long_message'=>'An unexpected error ocurred! Please contact OpenSupport']);
        }
	}
	
	public function lockPricing(Request $r)
    {
		DB::table('slab')->where('logistic_id',$r->lpid)->update(['locked'=>1]);
		return response()->json(['status'=>'success',
				'long_message'=>'Ok']);
	}

	public function unlockPricing(Request $r)
    {
		DB::table('slab')->where('logistic_id',$r->lpid)->update(['locked'=>0]);
		return response()->json(['status'=>'success',
				'long_message'=>'Ok']);
	}

    public function checkPricing(Request $r)
    {
		$logistic_id = $r->lpid;
		$count = DB::table('slab')->where('locked',1)->where('logistic_id',$logistic_id)->count();
		if($count > 0 && !Auth::user()->hasRole('adm')){
			return response()->json(['status'=>'failure',
    		'long_message'=>'Your prices could not be added. Prices are locked']);
		} else {
			return response()->json(['status'=>'success',
    		'long_message'=>'']);
		}
	}
	
    public function newPricing(Request $r)
    {
    	try {
    		//    $user_id = Auth::user()->id;
			$anArray=$r->data;
			//	$station = DB::table('station')->where('user_id',$user_id)->first();
			$logistic_id = $r->lpid;
			/*	if(!is_null($station)){
			$logistic = DB::table('logistic')->where('station_id',$station->id)->first();
			if(!is_null($logistic)){
				$logistic_id = $logistic->id;
			}
			*/
			// Validation
			/*  $vQuery=DB::table('logisticslab')
			->where('logisticslab.logistic_id',$logistic_id)->delete();*/
			$error=0;
			if($logistic_id == 0){
				return response()->json(['status'=>'failure',
	    		'long_message'=>'Your prices could not be added. Please Contact OpenSupport']);
			} 
			else {
				$volfactor=$r->volfactor;
				if ($volfactor != "" and is_numeric($volfactor) and $volfactor >0) {
				# code...
				$l= Logistic::find($logistic_id);
				$l->volfactor=$volfactor;
				$l->save();
				}

				$idsarr = array();
				$kk = 0;
				$islocked = 0;
				$checklocked = DB::table('slab')->
					where('logistic_id',$logistic_id)->first();

				if(!is_null($checklocked)){
					$islocked = $checklocked->locked;
				}
				foreach ($anArray as $a) {
					if ($a['weight']=="" and $a['length']="") {
						# code...

					} else {
						if($a['ids'] == 0){
							$s= new Slab;
							$s->weight=$a['weight'];
							$s->height=$a['height'];
							$s->width=$a['width'];
							$s->length=$a['length'];
							$s->base_price=$a['price']*100;
							$s->incremental_price=$a['ip']*100;
							$s->incremental_unit=$a['iu'];
							$s->locked=$islocked;
							$s->logistic_id=$logistic_id;
							$s->save();	
							$idsarr[$kk] = $s->id;	
							$kk++;
						} else {
							$idsarr[$kk] = $a['ids'];
							$s= Slab::find($a['ids']);
							$s->weight=$a['weight'];
							$s->height=$a['height'];
							$s->width=$a['width'];
							$s->length=$a['length'];
							$s->base_price=$a['price']*100;
							$s->incremental_price=$a['ip']*100;
							$s->incremental_unit=$a['iu'];
							$s->logistic_id=$logistic_id;
							$s->save();
							$kk++;
						}
	      			}
				}
				DB::table('slab')->where('logistic_id',$logistic_id)->
					whereNotIn('id',$idsarr)->delete();
			}

    	} catch (\Exception $e) {
			dump($e);
          try {
            Slab::destroy($s->id);
            LogisticSlab::destroy($ls->id);
          } catch (\Exception $e) {
            return response()->json(['status'=>'failure',
    		'long_message'=>'Your prices could not be added. Please Contact OpenSupport']);
          }
    		
    		return response()->json(['status'=>'failure',
    		'long_message'=>'Your prices could not be added. Please Contact OpenSupport']);
    	}
    	return response()->json(['status'=>'success',
    		'long_message'=>'Price table change is successful!']);
    		//'long_message'=>'Your prices have been added.'.$error.' entries ignored.']);
    }

   public function initAddressesModal($cn,$type)
   {
   		try {

   		$d=Delivery::where('consignment_number',$cn)->first();
   		$delivery_status=ucfirst($d->status);
   		$dtype=$d->type;
		//dd($d);
		$poid = IdController::nO($d->porder_id);
   		$Uquery=User::join('address as ass','ass.id','=','users.default_address_id')
   			->join('city','city.id','=','ass.city_id')
   			->join('state','state.code','=','city.state_code');
   		$Mquery=Merchant::join('address as ass',
   			'ass.id','=','address_id')
   			->join('city','city.id','=','ass.city_id')
   			->join('state','state.code','=','city.state_code');;
		$usersender=array();
		$user=array();
   		switch ($dtype) {
   			case 'm2b':

   					// The receipent is buyer.
   					$buyer_user_id= POrder::find($d->porder_id)->user_id;

   					$user= $Uquery
   					->where('users.id',$buyer_user_id)
   					->select(DB::raw("
   						users.name,
   						city.name as city,
   						state.name as state,
   						ass.line1 as line1,
   						ass.line2 as line2,
   						ass.line3 as line3,
   						ass.line4 as line4,
   						users.mobile_no as phone
   					
   						"))->first();
   					$pid=DB::table('orderproduct')
   						->where('porder_id',$d->porder_id)
   						->pluck('product_id');
   					$p=Product::find($pid);
   					$merchant_id=DB::table('merchantproduct')
   					->where('product_id',$p->parent_id)
   					->pluck('merchant_id');
					
   					$usersender=$Mquery
   						->where('merchant.id',$merchant_id)
   						->select(DB::raw("
   						merchant.company_name as name,
   						city.name as city,
   						state.name as state,
   						ass.line1 as line1,
   						ass.line2 as line2,
   						ass.line3 as line3,
   						ass.line4 as line4,
   						merchant.office_no as phone
   					
   						"))->first();
				break;
				case 'b2m':

   					// The receipent is merchant.
   					$buyer_user_id= POrder::find($d->porder_id)->user_id;

   					$usersender= $Uquery
   					->where('users.id',$buyer_user_id)
   					->select(DB::raw("
   						users.name,
   						city.name as city,
   						state.name as state,
   						ass.line1 as line1,
   						ass.line2 as line2,
   						ass.line3 as line3,
   						ass.line4 as line4,
   						users.mobile_no as phone
   					
   						"))->first();
   					$pid=DB::table('orderproduct')
   						->where('porder_id',$d->porder_id)
   						->pluck('product_id');
   					$p=Product::find($pid);
   					$merchant_id=DB::table('merchantproduct')
   					->where('product_id',$p->parent_id)
   					->pluck('merchant_id');
					
   					$user=$Mquery
   						->where('merchant.id',$merchant_id)
   						->select(DB::raw("
   						merchant.company_name as name,
   						city.name as city,
   						state.name as state,
   						ass.line1 as line1,
   						ass.line2 as line2,
   						ass.line3 as line3,
   						ass.line4 as line4,
   						merchant.office_no as phone
   					
   						"))->first();
				break;
   			default:
   				# code...
   				break;
   		}
			$weight = 0;
			$vweight = 0;
			$wsize = "20px";
			$vwsize = "14px";
			$wweight = "bold";
			$vwweight = "normal";
			$orderps= DB::table('orderproduct')->where('porder_id',$d->porder_id)->get();
			$volfactor=DB::table('logistic')->where('id',1)->pluck('volfactor');
			foreach($orderps as $orderp){
				$cproduct = DB::table('product')->where('id',$orderp->product_id)->first();
				if(!is_null($cproduct)){
					$weight += $cproduct->weight;
					$vweight += ($cproduct->length * $cproduct->width * $cproduct->height)/$volfactor;
				}
			}
			if($vweight > $weight){
				$wsize = "14px";
			$vwsize = "20px";
				$wweight = "normal";
				$vwweight= "bold";				
			}
   		} catch (\Exception $e) {
   			return $e;
			$user=array();
			$usersender=array();
   		}
   	
   		// return $user;
		return view('logistics.modal.addresses')
		->with('usersender',$usersender)
		->with('delivery_status',$delivery_status)
		->with('poid',$poid)
		->with('wsize',$wsize)
		->with('vwsize',$vwsize)
		->with('wweight',$wweight)
		->with('vwweight',$vwweight)
		->with('weight',$weight)
		->with('vweight',$vweight)
   		->with('user',$user);
   }	
	
   public function initAddressModal($cn,$type)
   {
   		try {

   		$d=Delivery::where('consignment_number',$cn)->first();
   		$dtype=$d->type;

   		$Uquery=User::join('address as ass','ass.id','=','users.default_address_id')
   			->join('city','city.id','=','ass.city_id')
   			->join('state','state.code','=','city.state_code');
   		$Mquery=Merchant::join('address as ass',
   			'ass.id','=','address_id')
   			->join('city','city.id','=','ass.city_id')
   			->join('state','state.code','=','city.state_code');;

   		switch ($dtype) {
   			case 'm2b':
   				if ($type=="r") {
   					// The receipent is buyer.
   					$buyer_user_id= POrder::find($d->porder_id)->user_id;

   					$user= $Uquery
   					->where('users.id',$buyer_user_id)
   					->select(DB::raw("
   						users.name,
   						city.name as city,
   						state.name as state,
   						ass.line1 as line1,
   						ass.line2 as line2,
   						ass.line3 as line3,
   						ass.line4 as line4,
   						users.mobile_no as phone
   					
   						"))->first();
   				}
   				if ($type=="s") {
   					$pid=DB::table('orderproduct')
   						->where('porder_id',$d->porder_id)
   						->pluck('product_id');
   					$p=Product::find($pid);
   					$merchant_id=DB::table('merchantproduct')
   					->where('product_id',$p->parent_id)
   					->pluck('merchant_id');
   					$user=$Mquery
   						->where('merchant.id',$merchant_id)
   						->select(DB::raw("
   						merchant.company_name as name,
   						city.name as city,
   						state.name as state,
   						ass.line1 as line1,
   						ass.line2 as line2,
   						ass.line3 as line3,
   						ass.line4 as line4,
   						merchant.office_no as phone
   					
   						"))->first();
   				}
   				break;
   			
   			default:
   				# code...
   				break;
   		}
   		} catch (\Exception $e) {
   			return $e;
        $user=array();
   		}
   	
   		// return $user;
   		return view('logistics.modal.address')
   		->with('user',$user);
   }

   public function startOrder($cn)
   {
   		// Get Porder
   		try{
   		$pid=Delivery::where('consignment_number',$cn)->pluck('porder_id');

		$p= POrder::find($pid);

		if ($p->status == "m-processing2") {
			$pstatus="m-processing2";
			$status="l-processing";

		} elseif ($p->status == "b-returning2") {
			$pstatus="b-returning2";
			$status="l-processing2";
		}

   		$p->status=$status;
   		$p->save();
   		$op = DB::table('orderproduct')->where('porder_id',$pid)
      ->where('status',$pstatus)->get();

			foreach($op as $o_p){
				
                DB::table('orderproduct')->where('id',$o_p->id)->update(['status'=>$status]);
				
			}
      Delivery::where('consignment_number',$cn)
      ->update(['status'=>'inprogress']);
		}catch(\Exception $e){
			dump($e);
			return response()->json(['status'=>'failure'
   			,
   			'long_message'=>'Request Failed. Contact OpenSupport']);
		}
   		return response()->json(['status'=>'success'
   			,
   			'long_message'=>'The order status has been updated']);
   }

   public function showPricing($logistic_id)
   {
    try {
        $pricings=DB::table('slab')->where('slab.logistic_id',$logistic_id)->where('weight','>',0)
		->orderBy('weight','ASC')
        ->get();
    } catch (\Exception $e) {
      dump($e);
      $pricings=array();
    }
   // dd($pricings);
     return view('logistics.modal.pricing')
     ->with('pricings',$pricings);
     ;
   }

   public function showDos($logistic_id, $type)
   {
    try {
		$logs=DB::table('delivery')->join('porder','delivery.porder_id','=','porder.id')->select('delivery.porder_id')->distinct()->groupBy('delivery.porder_id')->where('delivery.logistic_id',$logistic_id);
      //      ->join('delivery as dl','dl.logistic_id','=','logistic.id');
		if($type == "outstanding"){
			$logs->where('delivery.status','!=','delivered');
		} else if($type == "delivered"){
			$logs->where('delivery.status','=','delivered');
		}
		
           $result = $logs->get();
		   
		   foreach($result as $porder){
			   $total_del = DB::table('orderproduct')->where('porder_id',$porder->porder_id)->sum('order_delivery_price');
				$porder->total_delivery = $total_del;
		   }
    } catch (\Exception $e) {
      dump($e);
      $dos=array();
    }
   // dd($result);
     return view('logistics.modal.dos')
     ->with('dos',$result);
     ;
   }   
   
   public function changeGrade(Request $r){
	   $logs=DB::table('logistic')->where('id',$r->id)->update(['lgrade_id'=>$r->grade]);
	   return "OK";
   }
   public function showCapability($logistic_id)
   {
    try {
		$logs=DB::table('logistic')->where('id',$logistic_id)->first();
		$out=DB::table('logisticcapability')->join('capability','logisticcapability.capability_id','=','capability.id')->where('logistic_id',$logistic_id)->get();
    } catch (\Exception $e) {
      dump($e);
      $dos=array();
    }
   // dd($result);
     return view('logistics.modal.capability')
     ->with('out',$out);
     ;
   }    

   public function capability($logistic_id)
   {
    try {
        $pricings=DB::table('slab')->where('slab.logistic_id',$logistic_id)->where('weight','>',0)
		->orderBy('weight','ASC')
        ->get();
    } catch (\Exception $e) {
      dump($e);
      $pricings=array();
    }
   // dd($pricings);
     return view('logistics.modal.pricing')
     ->with('pricings',$pricings);
     ;
   }   

   public function initCLModal($oid,$type="m2b")
   {
     return view('logistics.modal.call_logistic')
     ->with('oid',$oid)
     ->with('type',$type);
   }

  public function collectPackage($cn)
  {

   $delivery=DB::table('delivery')->where('consignment_number',$cn)->first();
   $porder=POrder::find($delivery->porder_id); 
   switch ($porder->status) {
     case 'l-collected1':
       $message="Please enter the security key from label for ";
       break;
     case 'l-collected':
       $message="Please enter the receipt password for ";
       break;
     default:
       $message="Please enter the security key from label for ";
       break;
   }
	$message_name="Please enter the recipient name ";
	$message_nric="Please enter the recipient NRIC ";
	$lgrade = 1;
	$logistic = DB::table('logistic')->where('id',$delivery->logistic_id)->first();
	if(!is_null($logistic)){
		$lgrade = $logistic->lgrade_id;
	}
	if($lgrade == 2){
		return view("logistics.modal.cpb")
		->with('delivery',$delivery)
		->with('message',$message)
		->with('message_name',$message_name)
		->with('message_nric',$message_nric);
	} else {
		return view("logistics.modal.cp")
		->with('delivery',$delivery)
		->with('message',$message);
	}
  }

  public function getDeliveryDetails(Request $r)
  {
  	
  	$ret=["status"=>"failure"];
  	try {
  		$skey=$r->skey;
  		$porder_id=$r->oid;
	   	$porder=POrder::find($porder_id); 
	   
		switch ($porder->status) {
		 case 'l-collected1':
		 	$delivery=DB::table('delivery')
		 	->where('porder_id',$porder_id)
		 	->where('pickup_password',$skey)
		 	->where('type','m2b')
		 	->where('status','delivered')
		 	->first();
		 	if (!is_null($delivery)) {
		 		$delivery=DB::table('delivery')
		 		->where('porder_id',$porder_id)
		 		->where('type','b2m')
		 		->where('status','inprogress')
		 		->first();
				$cn=$delivery->consignment_number;
				$type=$delivery->type;
				$ret["status"]="success";
				$ret["consignment_number"]=$cn;
				$ret["type"]=$type;

		 	}
		 	break;
		 case 'l-collected':
		 	$delivery=DB::table('delivery')
		 	->where('porder_id',$porder_id)
		 	->where('type','m2b')
		 	->where('status','inprogress')
		 	->first();
		 	$cn=$delivery->consignment_number;
		 	$type=$delivery->type;
		 	// Double validation
		 	$receipt=DB::table('receipt')->where('do_password',$skey)
		 	->where('porder_id',$porder_id)
		 	->first();
		 	if (!is_null($receipt)) {
			   $ret["status"]="success";
			   $ret["consignment_number"]=$cn;
			   $ret["type"]=$type;
		 	}

		   break;
		 default:
		   $delivery=DB::table('delivery')
		 	->where('porder_id',$porder_id)
		 	->where('pickup_password',$skey)
		 	->where('status','inprogress')
		 	->first();
		 	$cn=$delivery->consignment_number;
		 	$type=$delivery->type;
			$ret["status"]="success";
			$ret["consignment_number"]=$cn;
			$ret["type"]=$type;
		   break;
		}
  	} catch (\Exception $e) {
  		// dump($e);
  		// return $e->getMessage();
  	}
  	return $ret;
  }

public function getLogisticId($porder_id)
	{
		$ret=-1; 
		$merchant=DB::select(DB::raw(
				"
				SELECT 
				merchant.all_own_delivery,
				merchant.all_system_delivery,
				logistic.id as logistic_id
				FROM 
				porder
				JOIN orderproduct ON orderproduct.porder_id = porder.id 
				JOIN product ON product.id=orderproduct.product_id
				JOIN merchantproduct ON merchantproduct.product_id = product.parent_id 
				JOIN merchant ON merchantproduct.merchant_id= merchant.id
				JOIN users ON user.id = merchant.user_id
				JOIN logistic ON logistic.user_id = users.id 
				WHERE
				porder.id=".$porder_id."
				"
			));
		if ($merchant->all_own_delivery == true) {
			$ret= $merchant->logistic_id;
		}
		return $ret;
	}

	/*

		AJAX: Check whether a  user has a logistic_id or not.
		return 0,1


	*/ 
	public function is_logistic()
	{
		$ret=0;
		try {
			$user_id=Auth::user()->id;
			$logistic=Logistic::where('user_id',$user_id)->first();
			if (!is_null($logistic)) {
				$ret=1;
			}
		} catch (\Exception $e) {
			
		}
		return $ret;
	}

	/*

	 Create Logistic Record and Role for the logged in user over Ajax.

	return json
	*/ 

	public function create_logistic()
	{
		$ret=array();
		$ret['status']="failure";
		$ignore=["created_at","updated_at","deleted_at","id"];
		try {
			$user_id=Auth::user()->id;
			// Get Merchant Record.
			$merchant=Merchant::where('user_id',$user_id)->first();
			if (is_null($merchant)) {
				throw new Exception("No merchant record found", 1);
				
			}
			// Create Station
			$station = new Station;
				foreach ($merchant as $key => $value) {
					try {
						if (!in_array($key, $ignore)) {
							$station->$key=$value;
						}
						
					} catch (\Exception $e) {
						
					}
				}
			$station->save();
			// Create Company
			$company=new Company;
			$company->save();
			// Create Logistic
			$logistic=new Logistic;

			$logistic->save();
			// Create Role for Station

		} catch (\Exception $e) {
			// Rollback
			try {
				Station::destroy($station->id);
			} catch (\Exception $e) {
				
			}
			try {
				Company::destroy($company->id);
			} catch (\Exception $e) {
				
			}
			try {
				Logistic::destroy($logistic->id);
			} catch (\Exception $e) {
				
			}
			try {
				// Destroy the slug.
			} catch (\Exception $e) {
				
			}

			$ret['short_message']=$e->getMessage();
		}
		return response()->json($ret);
	}

}
