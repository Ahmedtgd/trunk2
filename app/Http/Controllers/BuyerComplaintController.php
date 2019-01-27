<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyerComplaint as BC;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
use Auth;
use DB;
class BuyerComplaintController extends Controller
{
   public function loadComplaintModal($porder_id)
   {    
        $raw_porder_id=$porder_id;
        $porder_id=UtilityController::s_id($porder_id);
        $email=Auth::user()->email;
        $complain_reasons=DB::table('buyercomplaintreason')->get();
         return view('buyer.newbuyerinformation.complain')
                ->with('type','porder')
                ->with('porder_id',$porder_id)
                ->with('raw_porder_id',$raw_porder_id)
                ->with('complain_reasons',$complain_reasons)
                ->with('email',$email)
                ;   
   }

   public function registerComplaint(Request $r)
   {

       try {
          $c= new BC;
          $c->porder_id=$r->porder_id;
          $c->complaint_reason_id=$r->complaint_reason_id;
          $c->reference_id= $r->reference;
          $c->share_with_merchant="no";
          $c->priority="normal";
          $c->status="unresolved";
          $c->description=$r->description;

          $c->save();

          // Add email block
          return response()->json(['status'=>'success','short_message'=>'Complaint Registered',
            'long_message'=>'Your complaint has been registered. You will soon receive an email. Your Ticked ID is : <b>'.$c->id."</b>"]);
       } catch (\Exception $e) {
        return $e;
           return response()->json(['status'=>'failure','short_message'=>'Server Error',
            'long_message'=>'Your complaint could not be registered at the moment. Please try again later.']);
       }
   }
}
