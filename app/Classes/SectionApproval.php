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
class SectionApproval {

    private $table;
    private $id;
    private $status;
    public $view;

    public function __construct($tableName=null, $sectionName=null, $role_id=null) {
        $this->id = $role_id;
        $this->table = $tableName;
        $this->section = $sectionName;
      //  $this->getStatus();
      //  $this->createView();
    }

    public function getRejectButton() {
        $this->view = "<a class='btn btn-danger secrole_status_button' role='" . $this->table . "' section='". $this->section ."' do_status='rejected' current_role_id='" . $this->id . "' href='javascript:void(0)'> Reject </a>";
        $this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->section.'_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
    }

    public function getApproveButton() {
        $this->view = "<a class='btn btn-info secrole_status_button' role='" . $this->table . "' section='". $this->section ."' do_status='approved' current_role_id='" . $this->id . "' href='javascript:void(0)'> Approve </a>";
        $this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->section.'_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
    }
	public function getAllButton() {
        $this->view ="<a class='btn btn-info secrole_status_button' role='" . $this->table . "' section='". $this->section ."' do_status='approved' current_role_id='" . $this->id . "' href='javascript:void(0)'> Approve </a>";
        $this->view .="&nbsp;<a class='btn btn-danger secrole_status_button' role='" . $this->table . "' section='". $this->section ."' do_status='rejected' current_role_id='" . $this->id . "' href='javascript:void(0)'> Reject </a>";
        $this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->section.'_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
    }
	
    public function getRejectButtonb2b() {
        $this->view = "<a class='btn btn-danger secrole_status_buttonb2b' role='" . $this->table . "' section='". $this->section ."' do_status='rejected' current_role_id='" . $this->id . "' href='javascript:void(0)'> Reject </a>";
        $this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->section.'_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
    }

    public function getApproveButtonb2b() {
        $this->view = "<a class='btn btn-info secrole_status_buttonb2b' role='" . $this->table . "' section='". $this->section ."' do_status='approved' current_role_id='" . $this->id . "' href='javascript:void(0)'> Approve </a>";
        $this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->section.'_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
    }
	public function getAllButtonb2b() {
        $this->view ="<a class='btn btn-info secrole_status_buttonb2b' role='" . $this->table . "' section='". $this->section ."' do_status='approved' current_role_id='" . $this->id . "' href='javascript:void(0)'> Approve </a>";
        $this->view .="&nbsp;<a class='btn btn-danger secrole_status_button' role='" . $this->table . "' section='". $this->section ."' do_status='rejected' current_role_id='" . $this->id . "' href='javascript:void(0)'> Reject </a>";
        $this->view .= '<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" id="overlay_spinner_'.$this->section.'_'.$this->id.'" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>';
    }	
	
}
