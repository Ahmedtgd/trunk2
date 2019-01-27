<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Log;
use Carbon;
class MerchantModuleAccessController extends Controller
{
   public function access($merchant_id)
   {
   		
   		$merchant=DB::table('merchant')->where('id',$merchant_id)
   		->first();
   		$modules=DB::select(DB::raw("

   			SELECT 
   			sysmodule.*,
   			moduleaccess.id as moduleaccess_id
   			FROM 
   			sysmodule
   			LEFT JOIN moduleaccess on moduleaccess.sysmodule_id=sysmodule.id
   			AND moduleaccess.merchant_id=$merchant_id AND moduleaccess.status='active' AND moduleaccess.deleted_at IS NULL
   			WHERE 
   			sysmodule.deleted_at IS NULL

   		"));
   		return view('admin.merchant.module_access',compact('modules','merchant'));
   }

   public function update_access(Request $r)
   {
   		$merchant_id=$r->merchant_id;
   		if (empty($merchant_id)) {
   			
   			return "missing parameter merchant_id";
   		}
   		$modules=$r->modules;
   		if (empty($modules) || sizeof($modules)<1) {
   			
   			return "nothing to update";
   		}
   		foreach ($modules as $m) {
   			$sysmodule_id=$m['ma_id'];
   			$status="deleted";
   			if ($m['status']==0) {
   					# code...
   				$status="pending";
			}elseif ($m['status']==1) {
				# code...
				$status="active";
			}
			
			$data=['status'=>$status,"updated_at"=>Carbon::now()];
   			/*$does_exist*/
   			$does_exist=DB::table('moduleaccess')
   			->where('sysmodule_id',$sysmodule_id)
   			->where('merchant_id',$merchant_id)
   			->whereNull('deleted_at')
   			->first();
   			if (!empty($does_exist)) {
   				DB::table('moduleaccess')
   				->where('id',$does_exist->id)
   				->update($data);
   				if ($status=="pending") {
					/*Check if parent*/
					$is_parent=DB::table('sysmodule')
					->where('id',$sysmodule_id)->first();
					if ($is_parent->id==$is_parent->parent_id
						|| empty($is_parent->parent_id)
					) {
						DB::table('sysmodule')
						->join('moduleaccess','moduleaccess.sysmodule_id','=','sysmodule.id')
						->where('sysmodule.parent_id',$sysmodule_id)
						->where('moduleaccess.merchant_id',$merchant_id)
						->update([
							"moduleaccess.status"=>"pending",
							"moduleaccess.updated_at"=>Carbon::now()
						]);
					}
				}
   			}else{
   				$data['sysmodule_id']=$sysmodule_id;
   				$data['merchant_id']=$merchant_id;
   				DB::table('moduleaccess')
   				
   				->insert($data);
   			}
   		}
   }
}
