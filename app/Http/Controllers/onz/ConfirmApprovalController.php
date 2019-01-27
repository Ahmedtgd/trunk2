<?php

namespace App\Http\Controllers\onz;

use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Auth;
use Carbon;
class ConfirmApprovalController extends Controller
{

    public $onz_merchant_user_id;
    function __construct($foo = null)
    {
       /* $this->onz_merchant_user_id =env("ONZ_MERCHANT_USER_ID",754);*/
    }

    public function view($code="mps")
    {
        if (!Auth::check()) {
            # code...
            return "Please login";
        }
        $mps_user_id=Auth::user()->id;
        $onz_owner_merchant=Merchant::where("user_id",$mps_user_id)->first();

        if (empty($onz_owner_merchant)) {
            # code...
            return "Not authorized";
        }

        $onz_owner_merchant_id=$onz_owner_merchant->id;
        $merchants= DB::select(DB::raw("
            SELECT 
                onzmerchant.*,
                users.email,
                users.first_name,
                users.last_name,
                m.company_name,
                m.status
            FROM 
                onzmerchant
                JOIN merchant m on m.id=onzmerchant.user_merchant_id 
                JOIN users on users.id=m.user_id
            WHERE 
                onzmerchant.deleted_at IS NULL 
                AND onzmerchant.onz_owner_merchant_id=$onz_owner_merchant_id
            ORDER BY ID DESC ,m.status ASC
        "));

        return view("seller.onz.confirmapproval",compact('merchants'));
   }

   public function confirm_approval(Request $r)
   {
        $email=$r->email;
        /*Approve*/
        $user_id=DB::table("users")->where('email',$email)
        ->whereNull('deleted_at')->pluck('id');
        if (empty($user_id)) {
            # code...
            return "bad user";
        }

		/* Update merchant.status='active' */
        DB::table("merchant")
        ->where('user_id',$user_id)
        ->whereNull('deleted_at')
        ->update([
            'status'=>'active',
            'updated_at'=>Carbon::now()
        ]);

 		/* Update station.status='active' */
        DB::table("station")
        ->where('user_id',$user_id)
        ->whereNull('deleted_at')
        ->update([
            'status'=>'active',
            'updated_at'=>Carbon::now()
        ]);
 
        $e= new EmailController();
        $e->merchantOnboard($email,"onz");
        return "ok";
   }
}
