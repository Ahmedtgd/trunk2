<?php

namespace App\Classes;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Station;
use App\Models\SalesStaff;
use App\Models\Buyer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Autolink;
use Auth;
use DB;
class Approval {

    private $table;
    private $id;
    private $status;
    public $view;

    public function __construct($tableName=null, $role_id=null) {
        $this->id = $role_id;
        $this->table = $tableName;
        $this->getStatus();
        $this->createView();
    }

    private function getStatus() {
        if ($this->table == 'merchant') {
            $status = Merchant::where('id', '=', $this->id)->first(['status']);
        } elseif ($this->table == 'station') {
            $status = Station::where('id', '=', $this->id)->first(['status']);
        } elseif ($this->table == 'humancap') {
            $status = DB::table('humancap')->where('id', '=', $this->id)->first(['status']);
        }elseif ($this->table == 'sales_staff') {
            $status = SalesStaff::where('id', '=', $this->id)->first(['status']);
        }elseif ($this->table == 'buyer') {
            $status = Buyer::where('id', '=', $this->id)->first(['status']);
        }elseif ($this->table == 'employee') {
            $status = Employee::where('id', '=', $this->id)->first(['status']);
        }elseif ($this->table == 'product') {
            $status = Product::where('id', '=', $this->id)->first(['status']);
        } elseif ($this->table == 'oshop') {
            $status = DB::table('oshop')->where('id', '=', $this->id)->first(['status']);
        }
        if (!empty($status)) {
            $this->status = $status->status;
        }
    }

    private function createView() {
        $this->view = '';
        if ($this->status == 'pending' || is_null($this->status)) {
            $this->view .= "<a class='btn btn-primary role_status_button' role='" . $this->table . "'  do_status='active'  current_role_id='" . $this->id . "' href='javascript:void(0)'> Approve </a>";
            $this->view .= "<a class='btn btn-danger role_status_button' role='" . $this->table . "' do_status='rejected'  current_role_id='" . $this->id . "' href='javascript:void(0)'> Reject </a>";
        } elseif ($this->status == 'active' || $this->status == 'suspended' || $this->status == 'rejected') {
            $this->view .= "<a class='btn btn-info role_status_button' role='" . $this->table . "' do_status='active' current_role_id='" . $this->id . "' href='javascript:void(0)'> Reactivate </a>";
            $this->view .= "<a class='btn btn-warning role_status_button' role='" . $this->table . "' do_status='suspended' current_role_id='" . $this->id . "' href='javascript:void(0)'> Suspend </a>";
        }
        $this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
    }

    public function getSpinner(){
        $this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
    }

    public function getPendingSend() {
       $this->view = "<a class='btn btn-info role_status_button send_campign_c' role='" . $this->table . "' do_status='active' send_campaign='1' current_role_id='" . $this->id . "' href='javascript:void(0)'> Send </a>";
       $this->view .= "&nbsp;<a class='btn btn-danger role_status_button' role='" . $this->table . "' do_status='active'  current_role_id='" . $this->id . "' href='javascript:void(0)'> Reject </a>";    	
	   $this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
		
	}
	
    public function getSuspendButton() {
        $this->view = "<a class='btn btn-warning role_status_button' role='" . $this->table . "' do_status='suspended' current_role_id='" . $this->id . "' href='javascript:void(0)'> Suspend </a>";
        $this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
    }

    public function getDependingReactivateButton($type) {
		$aprsections = DB::table('aprsection')->where('type',$type)->get();
		$isrej = false;
		//dd($aprsections);
		$productb2b = null;
		if($type == 'product'){
			$productb2b =  DB::table('product')->where('parent_id',$this->id)->where('segment','b2b')->first();
			if(!is_null($productb2b)){
				$wholesaleprod = DB::table('wholesale')->where('product_id',$productb2b->id)->orderBy('funit','ASC')->count();
			}
		}
	//	dd($aprsections);
	$count = 0;
		foreach($aprsections as $aprsection){
			if(!is_null($productb2b) && $wholesaleprod > 0 && ($aprsection->name == 'informationb2b' || $aprsection->name == 'detailb2b' || $aprsection->name == 'specificationb2b' || $aprsection->name == 'b2b')){
				$getstatus = DB::table('aprchecklist')->where($type . '_id',$this->id)->where('aprsection_id',$aprsection->id)->first();
				if(!is_null($getstatus)){
					if($getstatus->status == 'rejected' || $getstatus->status == 'pending'){
					//	dd("this");
						$isrej = true;
					}
				} else {
				//	dd($this->id);
					$isrej = true;
				}
			} else {
				if(is_null($productb2b) && ($aprsection->name == 'informationb2b' || $aprsection->name == 'detailb2b' || $aprsection->name == 'specificationb2b' || $aprsection->name == 'b2b')){
					
				} else {
					$getstatus = DB::table('aprchecklist')->where($type . '_id',$this->id)->where('aprsection_id',$aprsection->id)->first();
					if(!is_null($getstatus)){
						if($getstatus->status == 'rejected' || $getstatus->status == 'pending'){
						//	dd("this");
							$isrej = true;
						}
					} else {
					//	dd($this->id);
						$isrej = true;
					}
				}
			}
		}
		//dd($isrej);
		if($isrej){
			$this->view = "<a class='btn btn-default' title='This product cannot be activated' style='background-color: #DDD;  margin: 10px 0 0 10px; width: 85px;' role='" . $this->table . "' do_status='active' current_role_id='" . $this->id . "' href='javascript:void(0)'> Reactivate </a>";
			$this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';			
		} else {
			$this->view = "<a class='btn btn-info role_status_button' role='" . $this->table . "' do_status='active' current_role_id='" . $this->id . "' href='javascript:void(0)'> Reactivate </a>";
			$this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
		}
	}	
	
    public function getReactivateButton() {
        $this->view = "<a class='btn btn-info role_status_button' role='" . $this->table . "' do_status='active' current_role_id='" . $this->id . "' href='javascript:void(0)'> Reactivate </a>";
        $this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
    }
	
	 public function getDependingButtons($type) {
		$this->view = '';
		$aprsections = DB::table('aprsection')->where('type',$type)->get();
		$isrej = false;
		$ispend = false;
		$productb2b = null;
		$wholesaleprod = 0;
		if($type == 'product'){
			$productb2b =  DB::table('product')->where('parent_id',$this->id)->where('segment','b2b')->first();
			if(!is_null($productb2b)){
				$wholesaleprod = DB::table('wholesale')->where('product_id',$productb2b->id)->orderBy('funit','ASC')->count();
			}
		}		
		foreach($aprsections as $aprsection){
			if(!is_null($productb2b) && $wholesaleprod > 0 && ($aprsection->name == 'informationb2b' || $aprsection->name == 'detailb2b' || $aprsection->name == 'specificationb2b' || $aprsection->name == 'b2b')){
				$getstatus = DB::table('aprchecklist')->where($type . '_id',$this->id)->where('aprsection_id',$aprsection->id)->first();
				if(!is_null($getstatus)){
					if($getstatus->status == 'rejected'){
						$isrej = true;
					}
				} else {
					$isrej = true;
					$ispend = true;
				}
			} else {
				if(is_null($productb2b) && ($aprsection->name == 'informationb2b' || $aprsection->name == 'detailb2b' || $aprsection->name == 'specificationb2b' || $aprsection->name == 'b2b')){
					
				} else {
					$getstatus = DB::table('aprchecklist')->where($type . '_id',$this->id)->where('aprsection_id',$aprsection->id)->first();
					if(!is_null($getstatus)){
						if($getstatus->status == 'rejected' || $getstatus->status == 'pending'){
						//	dd("this");
							$isrej = true;
						}
					} else {
					//	dd($this->id);
						$isrej = true;
						$ispend = true;
					}
				}
			}
		}	
		if($isrej){
			$this->view .= "<a class='btn btn-default' title='This product cannot be activated' style='background-color: #DDD; margin: 10px 0 0 10px; width: 85px;' role='" . $this->table . "'  do_status='active'  current_role_id='" . $this->id . "' href='javascript:void(0)'>Approve</a>";
		} else {
			$this->view .= "<a class='btn btn-primary role_status_button' role='" . $this->table . "'  do_status='active'  current_role_id='" . $this->id . "' href='javascript:void(0)'>Approve</a>";
		}
		if($ispend){
			$this->view .= "&nbsp;<a class='btn btn-default' title='This product cannot be rejected' style='background-color: #DDD;  margin: 10px 0 0 10px; width: 85px;' role='" . $this->table . "' do_status='rejected'  current_role_id='" . $this->id . "' href='javascript:void(0)'> Reject </a>";    			
		} else {
			$this->view .= "&nbsp;<a class='btn btn-danger role_status_button' role='" . $this->table . "' do_status='rejected'  current_role_id='" . $this->id . "' href='javascript:void(0)'> Reject </a>";    			
		}
	}

    public static function autolink($status,$role,$id)
    {
        $view="";
        if ($status == 'requested' || is_null($status ) || $status  == "") {
            $view .= "<a class='btn btn-primary role_status_button_autolink' role='" . $role. "'  do_status='linked'  current_role_id='" . $id . "' href='javascript:void(0)'> Link </a>";
            $view .= "<a class='btn btn-danger role_status_button_autolink' role='" . $role . "' do_status='unlinked'  current_role_id='" . $id . "' href='javascript:void(0)'> Remove </a>";
			//$view .= "<a class='btn btn-warning delete_autolink role_status_button_autolink' role='" . $role . "' do_status='suspended'  current_role_id='" . $id . "' href='javascript:void(0)'> Unlink </a>";
        } elseif ($status == 'linked') {
           // $view .= "<a class='btn btn-danger role_status_button_autolink' role='" . $role . "' do_status='unlinked' current_role_id='" . $id . "' href='javascript:void(0)'> Remove </a>";
			$view .= "<a class='btn btn-warning delete_autolink role_status_button_autolink' role='" . $role . "' do_status='suspended'  current_role_id='" . $id . "' href='javascript:void(0)'> Unlink </a>";
        } elseif ($status == 'suspended') {
			$view .= "<a class='btn btn-info role_status_button_autolink' role='" . $role. "'  do_status='linked'  current_role_id='" . $id . "' href='javascript:void(0)'> Link </a>";
			$view .= "<a class='btn btn-danger role_status_button_autolink' role='" . $role . "' do_status='remove'  current_role_id='" . $id . "' href='javascript:void(0)'> Remove </a>";
		} elseif ($status == 'unlinked') {
			$view .= "<a class='btn btn-info role_status_button_autolink' role='" . $role. "'  do_status='linked'  current_role_id='" . $id . "' href='javascript:void(0)'> Link </a>";
			$view .= "<a class='btn btn-danger role_status_button_autolink' role='" . $role . "' do_status='unlinked' current_role_id='" . $id . "' href='javascript:void(0)'> Remove </a>";
		}
        $view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';

        return $view;
    }
	
    public static function autolinkb($status,$role,$id)
    {
        $view="";
        if ($status == 'requested' || is_null($status ) || $status  == "") {
            $view .= "<a class='btn btn-danger role_status_button_autolink' role='" . $role . "' do_status='unlinked'  current_role_id='" . $id . "' href='javascript:void(0)'> Remove </a>";
			//$view .= "<a class='btn btn-warning delete_autolink role_status_button_autolink' role='" . $role . "' do_status='suspended'  current_role_id='" . $id . "' href='javascript:void(0)'> Unlink </a>";
        } elseif ($status == 'linked') {
           // $view .= "<a class='btn btn-danger role_status_button_autolink' role='" . $role . "' do_status='unlinked' current_role_id='" . $id . "' href='javascript:void(0)'> Remove </a>";
			$view .= "<a class='btn btn-warning delete_autolink role_status_button_autolink' role='" . $role . "' do_status='suspended'  current_role_id='" . $id . "' href='javascript:void(0)'> Unlink </a>";
        } elseif ($status == 'suspended') {
			$view .= "<a class='btn btn-info role_status_button_autolink' role='" . $role. "'  do_status='linked'  current_role_id='" . $id . "' href='javascript:void(0)'> Link </a>";
			$view .= "<a class='btn btn-danger role_status_button_autolink' role='" . $role . "' do_status='unlinked'  current_role_id='" . $id . "' href='javascript:void(0)'> Remove </a>";
		} elseif ($status == 'unlinked') {
			$view .= "<a class='btn btn-danger role_status_button_autolink' role='" . $role . "' do_status='unlinked' current_role_id='" . $id . "' href='javascript:void(0)'> Remove </a>";
		}
        $view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';

        return $view;
    }	
	
    public static function member($status,$role,$id)
    {
        $view="";
        if ($status == 'pending' || is_null($status ) || $status  == "") {
            $view .= "<a class='btn btn-primary role_status_button_member' role='" . $role. "'  do_status='active'  current_role_id='" . $id . "' href='javascript:void(0)'> Approve </a>";
            $view .= "<a class='btn btn-danger role_status_button_member' role='" . $role . "' do_status='suspended'  current_role_id='" . $id . "' href='javascript:void(0)'> Suspend </a>";
        } elseif ($status == 'active') {
			$view .= "<a class='btn btn-danger delete_member role_status_button_member' role='" . $role . "' do_status='suspended'  current_role_id='" . $id . "' href='javascript:void(0)'> Suspend </a>";
        } elseif ($status == 'suspended') {
			$view .= "<a class='btn btn-info role_status_button_member' role='" . $role. "'  do_status='active'  current_role_id='" . $id . "' href='javascript:void(0)'> Reactivate </a>";
		}
        $view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';

        return $view;
    }	
	
    public static function osmallmember($status,$role,$id)
    {
        $view="";
        if ($status == 'exists' || is_null($status ) || $status  == "") {
            $view .= "<a class='btn btn-primary role_status_button_member' role='" . $role. "'  do_status='active'  current_role_id='" . $id . "' href='javascript:void(0)'> Approve </a>";
            $view .= "<a class='btn btn-danger role_status_button_member' role='" . $role . "' do_status='suspended'  current_role_id='" . $id . "' href='javascript:void(0)'> Suspend </a>";
        } elseif ($status == 'tagged') {
			$view .= "<a class='btn btn-danger delete_member role_status_button_member' role='" . $role . "' do_status='suspended'  current_role_id='" . $id . "' href='javascript:void(0)'> Suspend </a>";
        } elseif ($status == 'suspended') {
			$view .= "<a class='btn btn-info role_status_button_member' role='" . $role. "'  do_status='tagged'  current_role_id='" . $id . "' href='javascript:void(0)'> Reactivate </a>";
		}
        $view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';

        return $view;
    }	
	
}
