<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Classes;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Models\Merchant;
use App\Models\Station;
use App\Models\SalesStaff;
use App\Models\Buyer;
use App\Models\HumanCap;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Oshop;
use App\Models\Companycampaign;
use App\Models\Autolink;
use DB;
use Auth;

class AdminApproveHelper {

    public static function approveSection($inputs) {
		$updateData = ['status' => $inputs['doStatus']];
		$res = 1;
		if ($inputs['role'] == 'merchant') {
			$aprsection = DB::table('aprsection')->where('type','merchant')->where('name',$inputs['section'])->first();
			$aprchecklist = DB::table('aprchecklist')->where('merchant_id',$inputs['id'])->where('aprsection_id',$aprsection->id)->first();
			if(is_null($aprchecklist)){
				//$updateData['type'] = 'merchant';
				$updateData['product_id'] = 0;
				$updateData['merchant_id'] = $inputs['id'];
				$updateData['aprsection_id'] = $aprsection->id;
				$updateData['created_at'] = date('Y-m-d H:i:s');
				$updateData['updated_at'] = date('Y-m-d H:i:s');
				DB::table('aprchecklist')->insert($updateData);
			} else {
				$updateData['updated_at'] = date('Y-m-d H:i:s');
				DB::table('aprchecklist')->where('id',$aprchecklist->id)->update($updateData);
			}
			$aprsections = DB::table('aprsection')->where('type','merchant')->get();
			$status = "active";
			foreach($aprsections as $aprsection){
				$getstatus = DB::table('aprchecklist')->where('merchant_id',$inputs['id'])
									->where('aprsection_id',$aprsection->id)->first();
				$statusc = "";
				if(!is_null($getstatus)){
					$statusc = $getstatus->status;
					if($statusc == "rejected"){
						$status = "rejected";
					}
				} else {
					$status = "pending";
				}
				
			}
		//	DB::table('merchant')->where('id',$inputs['id'])->update(['status'=>$status]);
			$merchant = DB::table('merchant')->where('id',$inputs['id'])->first();
			if(!is_null($merchant)){
				if($merchant->status == 'active'){
					DB::table('merchant')->where('id',$inputs['id'])->update(['status'=>$status]);
				}
			}
		}
		if ($inputs['role'] == 'product') {
			$aprsection = DB::table('aprsection')->where('type','product')->where('name',$inputs['section'])->first();
			$aprchecklist = DB::table('aprchecklist')->where('product_id',$inputs['id'])->where('aprsection_id',$aprsection->id)->first();
			if(is_null($aprchecklist)){
				//$updateData['type'] = 'product';
				$updateData['product_id'] = $inputs['id'];
				$updateData['merchant_id'] = 0;
				$updateData['aprsection_id'] = $aprsection->id;
				$updateData['created_at'] = date('Y-m-d H:i:s');
				$updateData['updated_at'] = date('Y-m-d H:i:s');
				DB::table('aprchecklist')->insert($updateData);
			} else {
				$updateData['updated_at'] = date('Y-m-d H:i:s');
				DB::table('aprchecklist')->where('id',$aprchecklist->id)->update($updateData);
			}		
			$aprsections = DB::table('aprsection')->where('type','product')->get();
			$status = "active";
			$productb2b = null;
			$productb2b =  DB::table('product')->where('parent_id',$inputs['id'])->where('segment','b2b')->first();
			if(!is_null($productb2b)){
				$wholesaleprod = DB::table('wholesale')->where('product_id',$productb2b->id)->orderBy('funit','ASC')->count();
			}
			foreach($aprsections as $aprsection){
				$getstatus = DB::table('aprchecklist')->where('product_id',$inputs['id'])
									->where('aprsection_id',$aprsection->id)->first();
				$statusc = "";
				if(!is_null($getstatus)){
					$statusc = $getstatus->status;
					if($statusc == "rejected"){
						$status = "suspended";
					}
				} else {
					if(!is_null($productb2b) && $wholesaleprod > 0 && ($aprsection->name == 'informationb2b' || $aprsection->name == 'detailb2b' || $aprsection->name == 'specificationb2b' || $aprsection->name == 'b2b')){
						$status = "pending";
					}
				}
				
			}
			$product = DB::table('product')->where('id',$inputs['id'])->first();
			if(!is_null($product)){
				//if($product->status == 'active'){
					DB::table('product')->where('id',$inputs['id'])->update(['status'=>$status]);
					DB::table('product')->where('parent_id',$inputs['id'])->where('segment','b2b')->update(['status'=>$status]);
				//}
			}
		//	DB::table('product')->where('id',$inputs['id'])->update(['status'=>$status]);			
		}
		if ($res == 1) {
            $approvesec = new SectionApproval($inputs['role'], $inputs['section'],$inputs['id']);
            if ($inputs['doStatus'] == 'approved') {
                $approvesec->getRejectButton();
            } else if ($inputs['doStatus'] == 'rejected') {
                $approvesec->getApproveButton();
            }
            return json_encode(['success' => 'TRUE', 'view' => $approvesec->view]);
        } else {
            return json_encode(['success' => 'False']);
        }
	}
	
    public static function approveSectionB2b($inputs) {
		$updateData = ['status' => $inputs['doStatus']];
		$res = 1;
		if ($inputs['role'] == 'merchant') {
			$aprsection = DB::table('aprsection')->where('type','merchant')->where('name',$inputs['section'])->first();
			$aprchecklist = DB::table('aprchecklist')->where('merchant_id',$inputs['id'])->where('aprsection_id',$aprsection->id)->first();
			if(is_null($aprchecklist)){
				//$updateData['type'] = 'merchant';
				$updateData['product_id'] = 0;
				$updateData['merchant_id'] = $inputs['id'];
				$updateData['aprsection_id'] = $aprsection->id;
				$updateData['created_at'] = date('Y-m-d H:i:s');
				$updateData['updated_at'] = date('Y-m-d H:i:s');
				DB::table('aprchecklist')->insert($updateData);
			} else {
				$updateData['updated_at'] = date('Y-m-d H:i:s');
				DB::table('aprchecklist')->where('id',$aprchecklist->id)->update($updateData);
			}
			$aprsections = DB::table('aprsection')->where('type','merchant')->get();
			$status = "active";
			foreach($aprsections as $aprsection){
				$getstatus = DB::table('aprchecklist')->where('merchant_id',$inputs['id'])
									->where('aprsection_id',$aprsection->id)->first();
				$statusc = "";
				if(!is_null($getstatus)){
					$statusc = $getstatus->status;
					if($statusc == "rejected"){
						$status = "rejected";
					}
				} else {
					$status = "pending";
				}
				
			}
		//	DB::table('merchant')->where('id',$inputs['id'])->update(['status'=>$status]);
			$merchant = DB::table('merchant')->where('id',$inputs['id'])->first();
			if(!is_null($merchant)){
				if($merchant->status == 'active'){
					DB::table('merchant')->where('id',$inputs['id'])->update(['status'=>$status]);
				}
			}
		}
		if ($inputs['role'] == 'product') {
			$aprsection = DB::table('aprsection')->where('type','product')->where('name',$inputs['section'])->first();
			$aprchecklist = DB::table('aprchecklist')->where('product_id',$inputs['id'])->where('aprsection_id',$aprsection->id)->first();
			if(is_null($aprchecklist)){
				//$updateData['type'] = 'product';
				$updateData['product_id'] = $inputs['id'];
				$updateData['merchant_id'] = 0;
				$updateData['aprsection_id'] = $aprsection->id;
				$updateData['created_at'] = date('Y-m-d H:i:s');
				$updateData['updated_at'] = date('Y-m-d H:i:s');
				DB::table('aprchecklist')->insert($updateData);
			} else {
				$updateData['updated_at'] = date('Y-m-d H:i:s');
				DB::table('aprchecklist')->where('id',$aprchecklist->id)->update($updateData);
			}		
			$aprsections = DB::table('aprsection')->where('type','product')->get();
			$status = "active";
			foreach($aprsections as $aprsection){
				$getstatus = DB::table('aprchecklist')->where('product_id',$inputs['id'])
									->where('aprsection_id',$aprsection->id)->first();
				$statusc = "";
				if(!is_null($getstatus)){
					$statusc = $getstatus->status;
					if($statusc == "rejected"){
						$status = "suspended";
					}
				} else {
					$status = "pending";
				}
				
			}
			$product = DB::table('product')->where('id',$inputs['id'])->first();
			if(!is_null($product)){
				if($product->status == 'active'){
					DB::table('product')->where('id',$inputs['id'])->update(['status'=>$status]);
					DB::table('product')->where('parent_id',$inputs['id'])->where('segment','b2b')->update(['status'=>$status]);
				}
			}
		//	DB::table('product')->where('id',$inputs['id'])->update(['status'=>$status]);			
		}
		if ($res == 1) {
            $approvesec = new SectionApproval($inputs['role'], $inputs['section'],$inputs['id']);
            if ($inputs['doStatus'] == 'approved') {
                $approvesec->getRejectButtonb2b();
            } else if ($inputs['doStatus'] == 'rejected') {
                $approvesec->getApproveButtonb2b();
            }
            return json_encode(['success' => 'TRUE', 'view' => $approvesec->view]);
        } else {
            return json_encode(['success' => 'False']);
        }
	}	
	
    public static function approveUser($inputs) {

        $updateData = ['status' => $inputs['doStatus']];
        if ($inputs['doStatus'] == 'active' && $inputs['role'] != 'oshop' && $inputs['role'] != 'humancap' && $inputs['role'] != 'companycampaign') {
            $updateData['active_date'] = date('Y-m-d h:i:s');
        }


        if ($inputs['role'] == 'merchant') {
            $tableName = 'merchant';
            $res = Merchant::where('id', '=', $inputs['id'])->update($updateData);
            $roleData = Merchant::where('id','=',$inputs['id'])->first();
            if($inputs['doStatus'] == 'suspended') {
                $e=new  EmailController;
                $result=$e->sendSuspensionMail($inputs['id']);
            }
        } elseif ($inputs['role'] == 'station') {
            $tableName = 'station';
            $res = Station::where('id', '=', $inputs['id'])->update($updateData);
            $roleData = Station::where('id','=',$inputs['id'])->first();
        } elseif ($inputs['role'] == 'humancap') {
            $tableName = 'humancap';
            $res = DB::table('humancap')->where('id', '=', $inputs['id'])->update($updateData);
            $roleData = HumanCap::where('id','=',$inputs['id'])->first();
        } elseif ($inputs['role'] == 'sales_staff') {
            $tableName = 'sales_staff';
            $res = SalesStaff::where('id', '=', $inputs['id'])->update($updateData);
            $roleData = SalesStaff::where('id','=',$inputs['id'])->first();
        } elseif ($inputs['role'] == 'buyer') {
            $tableName = 'buyer';
            if($inputs['doStatus'] == 'suspended' || $inputs['doStatus'] == 'closed' || $inputs['doStatus'] == 'terminated') {
                $updateData['closed_date'] = Carbon::now();
            } else {
                $updateData['closed_date'] = null;
            }
            $res = Buyer::where('id', '=', $inputs['id'])->update($updateData);
            $roleData = Buyer::where('id','=',$inputs['id'])->first();
        } elseif ($inputs['role'] == 'employee') {
            $tableName = 'employee';
            $res = Employee::where('id', '=', $inputs['id'])->update($updateData);
            $roleData = Employee::where('id','=',$inputs['id'])->first();
        } elseif ($inputs['role'] == 'product') {
            $tableName = 'product';
			if($inputs['doStatus'] == 'suspended') {
				$updateData['oshop_selected'] = false;
			}
			if($inputs['doStatus'] == 'active') {
				$updateData['oshop_selected'] = true;
			}
            $res = Product::where('id', '=', $inputs['id'])->update($updateData);
            Product::where('parent_id', '=', $inputs['id'])->where('segment','=','b2b')->update($updateData);
            $roleData = Product::where('id','=',$inputs['id'])->first();
        } elseif ($inputs['role'] == 'oshop') {
            $tableName = 'oshop';
            $res = DB::table('oshop')->where('id', '=', $inputs['id'])->update($updateData);
            $roleData = Oshop::where('id','=',$inputs['id'])->first();
        } elseif ($inputs['role'] == 'companycampaign') {
            $tableName = 'companycampaign';
            $res = DB::table('companycampaign')->where('id', '=', $inputs['id'])->update($updateData);
            $roleData = Companycampaign::where('id','=',$inputs['id'])->first();
        }
		
		if(is_null($roleData)){
			$res = 0;
		} else {
			$roleData = $roleData->toArray();
		}		
		//dd($res);

        if ($res == 1) {
            $approve = new Approval($tableName, $inputs['id']);
            if ($inputs['doStatus'] == 'active') {
                $approve->getSuspendButton();
            } else if ($inputs['doStatus'] == 'rejected' || $inputs['doStatus'] == 'suspended') {
                $approve->getReactivateButton();
            }
            return json_encode(['success' => 'TRUE', 'view' => $approve->view,'roleData' => $roleData]);
        } else {
            return json_encode(['success' => 'False']);
        }
    }

    public static function approveAutolink($inputs) {
		$autolink = Autolink::where('id', '=', $inputs['id'])->first();
        if($inputs['doStatus'] == "delete"){
			$updateData = ['status' => 'unlinked'];
			$updateData['deleted_at'] = date('Y-m-d h:i:s');
			if ($inputs['role'] == 'autolink') {
				$tableName = 'autolink';
				$res = Autolink::where('id', '=', $inputs['id'])->update($updateData);
				$roleData = Autolink::where('id','=',$inputs['id'])->first()->toArray();
			}
			if (!is_null($autolink)) {			
				DB::table('merchant')->where('id',$autolink->responder)->update(['own_delivery_logistic_id'=>0]);
			}
			if ($res == 1) {
				return json_encode(['success' => 'TRUE', 'view' => Approval::autolink($inputs['doStatus'], 'autolink',$inputs['id']),'roleData' => $roleData]);
			} else {
				return json_encode(['success' => 'False']);
			}			
		} else {
			$updateData = ['status' => $inputs['doStatus']];
			if ($inputs['doStatus'] == 'linked') {
				$updateData['linked_since'] = date('Y-m-d H:i:s');
				
				if (!is_null($autolink)) {
					$professional= DB::table('station')->where('user_id',$autolink->initiator)->join('logistic', 'station.id', '=', 'logistic.station_id')->pluck('professional');
					if(!is_null($professional)){
						if($professional == 0){
							$lid= DB::table('station')->where('user_id',$autolink->initiator)->join('logistic', 'station.id', '=', 'logistic.station_id')->pluck('logistic.id');
							DB::table('merchant')->where('id',$autolink->responder)->update(['own_delivery_logistic_id'=>$lid]);
						}
					}	
				}
			} else {
				if (!is_null($autolink)) {			
					DB::table('merchant')->where('id',$autolink->responder)->update(['own_delivery_logistic_id'=>0]);
				}
			}


			if ($inputs['role'] == 'autolink') {
				$tableName = 'autolink';
				//dd($updateData);
				$res = Autolink::where('id', '=', $inputs['id'])->update($updateData);
				$roleData = Autolink::where('id','=',$inputs['id'])->first()->toArray();
			}

			if ($res == 1) {
				return json_encode(['success' => 'TRUE', 'view' => Approval::autolink($inputs['doStatus'], 'autolink',$inputs['id']),'roleData' => $roleData]);
			} else {
				return json_encode(['success' => 'False']);
			}
		}
    }
	
    public static function approveAutolinkb($inputs) {
        if($inputs['doStatus'] == "delete"){
			$updateData = ['status' => 'unlinked'];
			$updateData['deleted_at'] = date('Y-m-d h:i:s');
			if ($inputs['role'] == 'autolink') {
				$tableName = 'autolink';
				$res = Autolink::where('id', '=', $inputs['id'])->update($updateData);
				$roleData = Autolink::where('id','=',$inputs['id'])->first()->toArray();
			}			
			
			if ($res == 1) {
				return json_encode(['success' => 'TRUE', 'view' => Approval::autolinkb($inputs['doStatus'], 'autolink',$inputs['id']),'roleData' => $roleData]);
			} else {
				return json_encode(['success' => 'False']);
			}			
		} else {
			$updateData = ['status' => $inputs['doStatus']];
			if ($inputs['doStatus'] == 'linked') {
				$updateData['linked_since'] = date('Y-m-d H:i:s');
			}


			if ($inputs['role'] == 'autolink') {
				$tableName = 'autolink';
				$res = Autolink::where('id', '=', $inputs['id'])->update($updateData);
				$roleData = Autolink::where('id','=',$inputs['id'])->first()->toArray();
			}

			if ($res == 1) {
				return json_encode(['success' => 'TRUE', 'view' => Approval::autolinkb($inputs['doStatus'], 'autolink',$inputs['id']),'roleData' => $roleData]);
			} else {
				return json_encode(['success' => 'False']);
			}
		}
    }	
	
    public static function approveMember($inputs) {
			$updateData = ['status' => $inputs['doStatus']];

			if ($inputs['role'] == 'member') {
				$tableName = 'member';
				$res = DB::table('member')->where('id', '=', $inputs['id'])->update($updateData);
				$roleData = DB::table('member')->where('id','=',$inputs['id'])->first();
			}

			if ($res == 1) {
				return json_encode(['success' => 'TRUE', 'view' => Approval::member($inputs['doStatus'], 'member',$inputs['id']),'roleData' => $roleData]);
			} else {
				return json_encode(['success' => 'False']);
			}
    }	
	
    public static function approveOsmallMember($inputs) {
		$updateData = ['status' => $inputs['doStatus']];

		if ($inputs['role'] == 'osmallmember') {
			$tableName = 'osmallmember';
			$res = DB::table('osmallmember')->where('id', '=', $inputs['id'])->update($updateData);
			$roleData = DB::table('osmallmember')->where('id','=',$inputs['id'])->first();
		}

		if ($res == 1) {
			return json_encode(['success' => 'TRUE', 'view' => Approval::osmallmember($inputs['doStatus'], 'member',$inputs['id']),'roleData' => $roleData]);
		} else {
			return json_encode(['success' => 'False']);
		}
    }	

    public static function saveSecRemarks($inputs) {
		$updateData = ['status' =>'pending'];
		$user_id= Auth::user()->id;
		$last_id = DB::table('remark')->insertGetId(['remark' =>  $inputs['remarks'],'status' =>  $inputs['status'], 'user_id' => $user_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		if ($inputs['role'] == 'merchant') {
			$aprsection = DB::table('aprsection')->where('type','merchant')->where('name',$inputs['section'])->first();
			$aprchecklist = DB::table('aprchecklist')->where('merchant_id',$inputs['id'])->where('aprsection_id',$aprsection->id)->first();
			if(is_null($aprchecklist)){
			//	$updateData['type'] = 'merchant';
				$updateData['product_id'] = 0;
				$updateData['merchant_id'] = $inputs['id'];
				$updateData['aprsection_id'] = $aprsection->id;
				$updateData['created_at'] = date('Y-m-d H:i:s');
				$updateData['updated_at'] = date('Y-m-d H:i:s');
				$aprid = DB::table('aprchecklist')->insertGetId($updateData);
			} else {
				$aprid = $aprchecklist->id;
			}
		}else if($inputs['role'] == 'product'){
			$aprsection = DB::table('aprsection')->where('type','product')->where('name',$inputs['section'])->first();
			$aprchecklist = DB::table('aprchecklist')->where('product_id',$inputs['id'])->where('aprsection_id',$aprsection->id)->first();
			if(is_null($aprchecklist)){
			//	$updateData['type'] = 'product';
				$updateData['product_id'] = $inputs['id'];
				$updateData['merchant_id'] = 0;
				$updateData['aprsection_id'] = $aprsection->id;
				$updateData['created_at'] = date('Y-m-d H:i:s');
				$updateData['updated_at'] = date('Y-m-d H:i:s');
				$aprid = DB::table('aprchecklist')->insertGetId($updateData);
			} else {
				$aprid = $aprchecklist->id;
			}
		}
		$res = DB::table('aprchecklistremark')->insert(['aprchecklist_id' =>  $aprid, 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		if ($res == 1) {
            return json_encode(['success' => 'TRUE']);
        } else {
            return json_encode(['success' => 'False']);
        }
	}
    public static function saveRemarks($inputs) {
       // $updateData = ['remarks' => $inputs['remarks']];
	    $user_id= Auth::user()->id;
		$last_id = DB::table('remark')->insertGetId(['remark' =>  $inputs['remarks'],'status' =>  $inputs['status'], 'user_id' => $user_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);

        if ($inputs['role'] == 'merchant') {
            $res = DB::table('merchantremark')->insert(['merchant_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }else if($inputs['role'] == 'station'){
            $res = DB::table('stationremark')->insert(['station_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }else if($inputs['role'] == 'humancap'){
            $res = DB::table('humancapremark')->insert(['humancap_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }else if($inputs['role'] == 'sales_staff'){
            $res = DB::table('sales_staffremark')->insert(['sales_staff_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }else if($inputs['role'] == 'buyer'){
            $res = DB::table('buyerremark')->insert(['buyer_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }else if($inputs['role'] == 'employee'){
            $res = DB::table('employeeremark')->insert(['employee_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }else if($inputs['role'] == 'product'){
            $res = DB::table('productremark')->insert(['product_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }else if($inputs['role'] == 'autolink'){
            $res = DB::table('autolinkremark')->insert(['autolink_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }else if($inputs['role'] == 'osmallmember'){
            $res = DB::table('osmallmemberremark')->insert(['member_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }else if($inputs['role'] == 'member'){
            $res = DB::table('memberremark')->insert(['member_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }else if($inputs['role'] == 'oshop'){
            $res = DB::table('oshopremark')->insert(['oshop_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }else if($inputs['role'] == 'companycampaign'){
            $res = DB::table('companycampaignremark')->insert(['companycampaign_id' =>  $inputs['id'], 'remark_id' => $last_id, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }
        if ($res == 1) {
            return json_encode(['success' => 'TRUE']);
        } else {
            return json_encode(['success' => 'False']);
        }
    }

}
