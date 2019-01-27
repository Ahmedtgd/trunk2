<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use App\Models\Buyer;
use App\Models\Merchant;
use App\Models\Station;
/*  Paul on 06 May 2017  */
use App\Models\SecurityToken;
use App\Models\User;
use App\Models\SalesStaff;
use App\Models\Globals;
use Carbon;
use DB;
use Mail;
use Auth;
use QrCode;
use Log;
class EmailController extends Controller
{
    public function __construct()
    {
        # code...

    }

    public function token()
    {
        // In future we might have better ways.
        return strval(time()) . str_random(20);
    }

    public function testEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        Mail::send('emails.test', ['user' => $user], function ($m) use ($user) {
            $m->from('info@opensupermall.com', 'Test Email');

            $m->to($user->email, $user->name)->subject('Test Email');
        });
    }

    public function termEmail($email, $days, $oid, $porderid, $total_owed)
    {
        $user = User::where('email', $email)->first();
        Mail::send('emails.term.reminder', ['user' => $user, 'name' => $user->first_name, 'days' => $days, 'porderid' => $porderid, 'total_owed'=>$total_owed, 'oid' => $oid], function ($m) use ($user, $email, $days) {
            $m->from('info@opensupermall.com', 'Payment Reminder');

            $m->to($email, $user->name)->subject('Payment Reminder!');
        });
    }
	
    public function termEmailOverdue($email, $days, $oid, $porderid)
    {
        $user = User::where('email', $email)->first();
        Mail::send('emails.term.reminderoverdue', ['user' => $user, 'name' => $user->first_name, 'days' => $days, 'porderid' => $porderid, 'oid' => $oid], function ($m) use ($user, $email, $days) {
            $m->from('info@opensupermall.com', 'Payment Overdue');

            $m->to($email, $user->name)->subject('Payment Overdue!');
        });
    }	

    public function confirmEmail($email, $role_id,$mode="osm")
    {
        /*,$rol
          Sends confirmation email to users
        */
        try {
			$globalvars = DB::table("global")->first();
            $user = User::where('email', $email)->first();
            $user_id = $user->id;
            $purpose = "emailconf";
            $status = "new";
            $token = $this->token();

            /*  Paul on 06 May 2017 at 10 30 pm  */
            //$t=new Token();
            $t = new SecurityToken();
            /*  Ends Here  */

            $t->token = $token;
            $t->count = 0;
            $t->status = "active";
            $t->purpose = $purpose; //Check create_token for more info!
            $t->user_id = $user_id;
            $t->save();

            $base_url=url();
			Log::debug('base_url='.$base_url);
			Log::debug('mode    ='.$mode);

            if ($mode=="onz") {
                $base_url='http://mpstele.my';
            }


            // Generate the sexy url
            $url = $base_url . '/c/verify/' . $token . '/' . $email . '/' .
				$purpose . '/' . $role_id . '/confirm';

            // Send mail
            Mail::send('emails.general.confirm_email', [
				'user' => $user,
				'confirm_url' => $url,
				'name' => $user->first_name,
				'status' => $status,
				'hours'=>$globalvars->email_confirmation_duration
			], function ($m) use ($user, $email) {
                $m->from('info@opensupermall.com', 'Confirm Email');

                $m->to($email, $user->name)->
					subject('Confirm Email OpenSupermall!');
            });
            return 1;

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function do_confirmEmail($token, $email, $purpose, $user_role_id)
    {
        if (Auth::check()) {
            Auth::logout();
        }
		$globalvars = DB::table("global")->first();
        $viewtype="whiteifonz";
        /*  Paul on 06 May 2017 at 10 30 pm  */
        //$trecord=Token::where('token',$token)->first();
        $trecord = SecurityToken::where('token', $token)->first();
        /*  Ends Here  */
        $viewtype="whiteifonz";
        try {
            $mode=$_GET['mode'];

            Session::put("mode",$mode);
            //dump($mode);
        } catch (\Exception $e) {
            
        }
        // return $trecord;
        if (is_null($trecord)) {
            $message_type = "error";
            $message = "The url is invalid.";

            return view("common.generic")->
				with('message', $message)->
				with('message_type', $message_type)->
                with('viewtype',$viewtype)
                ;
        }

        if (!is_null($trecord)) {
            $c = new Carbon($trecord->created_at);
            $hours = $c->diffInHours();
            if ($trecord->status == "expired" or $trecord->count > 0 or
				$hours > $globalvars->email_confirmation_duration) {
                $message_type = "error";
                $message = "The url has expired.";

                return view("common.generic")->
					with('message', $message)->
                    with('viewtype',$viewtype)->
					with('message_type', $message_type);
            }

        }
        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            $message_type = "error";
            $message = "Invalid email.";

            return view("common.generic")->
				with('message', $message)->
                with('viewtype',$viewtype)->
					with('message_type', $message_type);
        }

        try {
            switch ($user_role_id) {
                case 2:
                    $modal = Buyer::where('user_id', $user->id)->
						update(['status' => 'active']);
                    break;
                case 3:
					$modal = Merchant::where('user_id', $user->id)->
						update(['emailconfirm' => true]);
					Station::where('user_id', $user->id)->
						update(['emailconfirm' => true]);
                    break;
                case 11:
                    $modal = Station::where('user_id', $user->id)->
						update(['status' => 'active']);
                    break;
                default:
                    # code...
                    break;
            }
            $message_type = "success";
            $message = "Your email has been confirmed";
            return view("common.generic")->
				with('message', $message)->
                with('viewtype',$viewtype)->
				with('message_type', $message_type);

        } catch (\Exception $e) {
            $message_type = "error";
            $message = "A server error happened. Please contact OSupport";

            return view("common.generic")->
                with('viewtype',$viewtype)->
				with('message', $message)->
                with('viewtype',$viewtype)->
				with('message_type', $message_type);
        }
    }

    public function termtokenError($email, $user_id){
        try {
            $user = User::find($user_id);
            if (is_null($user)) {
                $message_type = "error";
                $message = "User record doesn't exists for the email";
                return view("common.generic")->with('message', $message)->with('message_type', $message_type);
            }
			
            Mail::send('emails.seller.term_token_error', ['user' => $user, 'name' => $user->first_name], function ($m) use ($user, $email) {
                $m->from('info@opensupermall.com', 'OpenSupermall');

                $m->to($email, $user->name)->subject('Tokens Insufficient!');
            });
            return 1;

        } catch (\Exception $e) {
            $message_type = "error";
            $message = "A server error happened. Please contact OSupport";
            return view("common.generic")->with('message', $message)->with('message_type', $message_type);
            return $e;
        }		
	}

    public function updateEmail($new_email, $user_id)
    {
        // The token acts as security
        $purpose = "emailupd";
        $status = "old";
        try {

            $user = User::find($user_id);
            if (is_null($user)) {
                $message_type = "error";
                $message = "User record doesn't exists for the email";
                return view("common.generic")->with('message', $message)->with('message_type', $message_type);
            }
            $token = $this->token();

            /*  Paul on 06 May 2017 at 10 30 pm  */
            //$t=new Token();
            $t = new SecurityToken();
            /*  Ends Here  */

            $t->token = $token;
            $t->count = 0;
            $t->status = "active";
            $t->purpose = $purpose; //Check create_token for more info!
            $t->user_id = $user_id;
            $t->save();
            $url = url() . '/c/verify/' . $token . '/' . $new_email . '/' . $purpose . '/' . $user_id . '/update';
            Mail::send('emails.general.confirm_email', ['user' => $user, 'confirm_url' => $url, 'name' => $user->first_name, 'status' => $status], function ($m) use ($user, $new_email) {
                $m->from('info@opensupermall.com', 'Update Email');

                $m->to($new_email, $user->name)->subject('Update Email OpenSupermall!');
            });
            return 1;

        } catch (\Exception $e) {
            $message_type = "error";
            $message = "A server error happened. Please contact OSupport";
            return view("common.generic")->with('message', $message)->with('message_type', $message_type);
            return $e;
        }
    }

    public function do_updateEmail($token, $new_email, $purpose, $user_id)
    {
        if (Auth::check()) {
            # code...
            Auth::logout();
        }
        $emailInUse = User::where('email', $new_email)->first();
        if (!is_null($emailInUse)) {
            # code...
            $message_type = "error";
            $message = "Email already in use . #006";
            return view("common.generic")->with('message', $message)->with('message_type', $message_type);
        }
        if ($purpose != 'emailupd') {
            $message_type = "error";
            $message = "Unauthorized Access . #001";
            return view("common.generic")->with('message', $message)->with('message_type', $message_type);
        }

        /*  Paul on 06 May 2017 at 10 30 pm  */
        //$existsToken = Token::where('token', $token)->first();
        $existsToken = SecurityToken::where('token', $token)->first();
        /*  Ends Here  */

        if (is_null($existsToken)) {
            $message_type = "error";
            $message = "Unauthorized Access. #002";
            return view("common.generic")->with('message', $message)->with('message_type', $message_type);
        }
        $existsUser = User::find($user_id);
        if (is_null($existsUser)) {
            $message_type = "error";
            $message = "Unauthorized Access. #003";
            return view("common.generic")->with('message', $message)->with('message_type', $message_type);
        }
        if ($existsToken->user_id != $user_id or $existsToken->purpose != $purpose) {
            $message_type = "error";
            $message = "Unauthorized Access. #004";
            return view("common.generic")->with('message', $message)->with('message_type', $message_type);
        }
        $tkc = new Carbon($existsToken->created_at);
        $tokenHourPassed = $tkc->diffInHours();
        if ($existsToken->count > 0 or $existsToken->status != "active" or $tokenHourPassed > 24) {
            $message_type = "error";
            $message = "Expired Link. Please request again. #005";
            return view("common.generic")->with('message', $message)->with('message_type', $message_type);
        }

        /*  Paul on 06 May 2017 at 10 30 pm  */
        //$t = Token::find($existsToken->id);
        $t = SecurityToken::find($existsToken->id);
        /*  Ends Here  */

        $t->status = "expired";
        $t->count = $existsToken->count + 1;
        $t->save();
        $u = User::find($existsUser->id);
        $u->email = $new_email;
        $u->save();
        $message_type = "success";
        $message = "Email changed to " . $new_email;
        return view("common.generic")->with('message', $message)->with('message_type', $message_type);
    }

    public function passwordFail($email){
		 $user = User::where('email', $email)->first();
		 if (is_null($user)) {
			$message_type = "error";
			$message = "The email is not associated with any account.";
			return view("common.generic")->with('message', $message)->with('message_type', $message_type);
		}
		Mail::send('emails.general.password_fail', ['user' => $user, 'name' => $user->first_name], function ($m) use ($user, $email) {
			$m->from('info@opensupermall.com', 'OpenSupermall');

			$m->to($email, $user->name)->subject('Maximum Password Attempts Reached!');
		});		
	}
	
    public function passwordReset($email,$mode="osm")
    {
        $purpose = "pwdreset";
        /*Fix it to $osm*/
        
        try {
            Log::debug("Email value for passwordReset is ".$email);
            $user = User::where('email', $email)->first();

            if (is_null($user)) {
                $message_type = "error";
                $message = "The email is not associated with any account.";
                Log::debug($message." ".$email);
                return $message;
            }
            $token = $this->token();

            /*  Paul on 06 May 2017 at 10 30 pm  */
            //$t = new Token();
            $t = new SecurityToken();
            /*  Ends Here  */

            $t->token = $token;
            $t->count = 0;
            $t->status = "active";
            $t->purpose = $purpose; //Check create_token for more info!
            $t->user_id = $user->id;
            $t->save();
            $from="info@opensupermall.com";
            $from2="Password Reset OpenSupermall";
            $base_url=url();
            if ($mode=="onz") {
                # code...
                
                $from="info@mpstele.my";
                $from2="Password Reset MPS";
                $base_url='http://mpstele.my';
            }

            $url = $base_url. "/c/verify/" . $token . "/" . $email . "/" . $purpose . "/" . $user->id . "/password/reset?mode=".$mode;
            Mail::send('emails.general.password_reset', ['user' => $user, 'confirm_url' => $url,'mode'=>$mode,'name' => $user->first_name], function ($m) use ($user, $email,$from,$from2) {
                $m->from($from, 'Password Reset');

                $m->to($email, $user->name)->subject($from2);
            });

          /*  DB::table('stuff')->insert(['note'=>'PasswordReset|No Exception Occured']);*/
            return 1;
        } catch (\Exception $e) {
            // dd($e->getMessage());
            Log::debug('**** HERE LIES DINGBAT *****');
            Log::error('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
           /* DB::table('stuff')->insert(['note'=>'PasswordReset| '.$e->getMessage()]);*/
            
            return 0;
        }
    }

    public function do_passwordReset($token, $email, $purpose, $user_id)
    {
        if (Auth::check()) {
            Auth::logout();
        }
        $viewtype="whiteifonz";
        try {
            $mode=$_GET['mode'];

            Session::put("mode",$mode);
            //dump($mode);
        } catch (\Exception $e) {
            
        }
        $viewtype="whiteifonz";
        if ($purpose != 'pwdreset') {
            $message_type = "error";
            $message = "Unauthorized Access . #001";
            return view("common.generic")->
				with('message', $message)->
                with('viewtype',$viewtype)->
				with('message_type', $message_type);
        }

        /*  Paul on 06 May 2017 at 10 30 pm  */
        //$existsToken = Token::where('token', $token)->first();
        $existsToken = SecurityToken::where('token', $token)->first();
        /*  Ends Here  */

        if (is_null($existsToken)) {
            $message_type = "error";
            $message = "Unauthorized Access. #002";
            return view("common.generic")->
				with('message', $message)->
                with('viewtype',$viewtype)->
				with('message_type', $message_type);
        }

        $existsUser = User::where('email', $email)->
			where('id', $user_id)->first();

        if (is_null($existsUser)) {
            $message_type = "error";
            $message = "Unauthorized Access. #003";
            return view("common.generic")->with('message', $message)->
            with('viewtype',$viewtype)->
            with('message_type', $message_type);
        }
        if ($existsToken->user_id != $user_id or $existsToken->purpose != $purpose) {
            $message_type = "error";
            $message = "Unauthorized Access. #004";
            return view("common.generic")->with('message', $message)->with('viewtype',$viewtype)->with('message_type', $message_type);
        }
        $tkc = new Carbon($existsToken->created_at);
        $tokenHourPassed = $tkc->diffInHours();
        if ($existsToken->count > 0 or $existsToken->status != "active" or $tokenHourPassed > 24) {
            $message_type = "error";
            $message = "Expired Link. Please request again. #005";
            return view("common.generic")->with('message', $message)

            ->with('viewtype',$viewtype)->
            with('message_type', $message_type);
        }
        Session::put('pswdresetuid', $existsUser->id);
        Session::put('pswdresetkey', $existsToken->token);
		User::where('email', $email)->where('id', $user_id)->update(['password_fail'=>0]);
         $userr = DB::table('users')->where('email', $email)->first();
        if(!is_null($userr)){
            DB::table('buyer')->where('user_id', $userr->id)->update(['status' => 'active']);
        }          
        /*  Paul on 06 May 2017 at 10 30 pm  */
        //$t = Token::find($existsToken->id);
        $t = SecurityToken::find($existsToken->id);
        /*  Ends Here  */

        $t->status = "expired";
        $t->count = $existsToken->count + 1;
        $t->save();
        return response()->view('common.generic', [
			'message_type' => 'pwdreset',
            'viewtype'=>$viewtype,
			'uid' => $existsUser->id,
			'key' => $existsToken->token])->
			header("Cache-Control", "private, max-age=0, no-store,
				no-cache, must-revalidate, post-check=0, pre-check=0")->
			header('Pragma', 'no-cache')->
			header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');;
    }


    public function sendSummary($email, $user_id)
    {
        # Send Account Summary ; Things like ocredit balance, last transaction etc etc
    }

    public function sendRC($email, $porder_id)
    {
        $user = User::where('email', $email)->first();
        
        $forder_id = IdController::nO($porder_id);
        // Create Receipt.Pdf [Not correct way to do ]
        $receipt_password = DB::table('receipt')->where('porder_id', $porder_id)->pluck('do_password');
        $receipt_id = DB::table('receipt')->where('porder_id', $porder_id)->pluck('id');
		$qr_store_path=public_path()."/images/qr/receipt/password/". $receipt_id ."/";
		if (!file_exists($qr_store_path)) {
			mkdir($qr_store_path, 0775, true);
		}
		$qr_info=$receipt_password;
		$qr_image_name='BY-'.str_random(10);
		QrCode::format('png')->
			encoding('UTF-8')->
			size(400)->
			generate($qr_info,$qr_store_path.$qr_image_name.".png");
		$receipt_qr = url() . "/images/qr/receipt/password/". $receipt_id ."/" . $qr_image_name.".png";
		$qrFilePath = DOController::pdfRC($porder_id);
        $receipt_path = "receipt-do/receiptp-" . IdController::nO($porder_id) . ".pdf";
        Mail::send('emails.buyer.receipt', ['order_id' => $porder_id, 'receipt_id' => $porder_id, 'user' => $user, 'forder_id' => $forder_id, 'receipt_password' => $receipt_password, 'qrFilePath' => $qrFilePath, 'receipt_qr' => $receipt_qr], function ($m) use ($user, $email, $receipt_path, $forder_id) {
            $m->from('info@opensupermall.com', 'Order Receipt');
            $m->attach(storage_path($receipt_path));
            $m->to($email, $user->name)->subject('Order Receipt for ' . $forder_id . ' OpenSupermall!');
        });

        // unlink($qrFilePath);
        unlink(storage_path($receipt_path));
    }
	
    public function sendInv($email, $porder_id)
    {
        $user = User::where('email', $email)->first();
        $forder_id = IdController::nO($porder_id);
        // Create Invoice.Pdf [Not correct way to do ]
        $invoice_password = DB::table('invoice')->where('porder_id', $porder_id)->pluck('do_password');
        $invoice_id= DB::table('invoice')->where('porder_id', $porder_id)->pluck('id');
		$qr_store_path=public_path()."/images/qr/invoice/password/". $invoice_id ."/";
		if (!file_exists($qr_store_path)) {
			mkdir($qr_store_path, 0775, true);
		}
		$qr_info=$invoice_password;
		$qr_image_name='BY-'.str_random(10);
		QrCode::format('png')->
			encoding('UTF-8')->
			size(400)->
			generate($qr_info,$qr_store_path.$qr_image_name.".png");
		$invoice_qr = url() . "/images/qr/invoice/password/". $invoice_id ."/" . $qr_image_name.".png";
        $qrFilePath=$qr_store_path.$qr_image_name.".png";
	//	dd($invoice_qr);
        DOController::pdfIV($porder_id);
        $invoice_path = "receipt-do/invoicep-" . IdController::nO($porder_id) . ".pdf";		
        Mail::send('emails.buyer.invoice', ['order_id' => $porder_id, 'invoice_id' => $porder_id, 'user' => $user, 'forder_id' => $forder_id, 'invoice_password' => $invoice_password, 'qrFilePath' => $qrFilePath, 'invoice_qr' =>$invoice_qr], function ($m) use ($user, $email, $invoice_path, $forder_id) {
            $m->from('info@opensupermall.com', 'Invoice');
            $m->attach(storage_path($invoice_path));
            $m->to($email, $user->name)->subject('You have received an Invoice');
        });

        // unlink($qrFilePath);
        unlink(storage_path($invoice_path));
    }	

    public function sendDO($email, $porder_id)
    {
        $user = User::where('email', $email)->first();
        $forder_id = IdController::nO($porder_id);
        // Create Receipt.Pdf [Not correct way to do ]
        DOController::pdfDO($porder_id);
        $emails=array();
		$emails[0] = $email;
		$merchant = DB::table('merchant')->where('user_id',$user->id)->first();
		if(!is_null($merchant)){
			$contacts = DB::table('merchantcontactemail')->join('contactemail','merchantcontactemail.contactemail_id','=','contactemail.id')
			->where('merchantcontactemail.merchant_id',$merchant->id)->where('contactemail.enable',true)->get();
			$i = 1;
			foreach($contacts as $contact){
				$emails[$i] = $contact->email;
				$i++;
			}
		}
        $receipt_path = "receipt-do/dop-" . IdController::nO($porder_id) . ".pdf";
        Mail::send('emails.merchant.deliveryorder', ['order_id' => $porder_id, 'receipt_id' => $porder_id, 'user' => $user, 'forder_id' => $forder_id], function ($m) use ($user, $emails, $receipt_path) {
            $m->from('info@opensupermall.com', 'DeliveryOrder');
            $m->attach(storage_path($receipt_path));
            $m->to($emails, $user->name)->subject('You have received an order. OpenSupermall!');
        });
        unlink(storage_path($receipt_path));
    }
	
    public function sendDI($email, $porder_id)
    {
        $user = User::where('email', $email)->first();
        $forder_id = IdController::nO($porder_id);
        // Create Receipt.Pdf [Not correct way to do ]
        DOController::pdfDI($porder_id);
        $invoice_path = "receipt-do/dip-" . IdController::nO($porder_id) . ".pdf";
        Mail::send('emails.merchant.purchase_order', ['order_id' => $porder_id, 'invoice_id' => $porder_id, 'user' => $user, 'forder_id' => $forder_id], function ($m) use ($user, $email, $invoice_path) {
            $m->from('info@opensupermall.com', 'Purchase Order');
            $m->attach(storage_path($invoice_path));
            $m->to($email, $user->name)->subject('You have received a Purchase Order!');
        });
        unlink(storage_path($invoice_path));
    }	

    public function sendPledgeby($email, $hyper_id, $pledged_amount)
    {
        # code...
    }

    public function sendPledgeto($email, $hyper_id, $pledged_amount)
    {
        # code...
    }
    
    public function sendSuspensionMail($merchant_id)
    {
        try {
            $merchant = Merchant::find($merchant_id);
            $merchant_user_id = $merchant->user_id;
            $mc_sales_staff_id = $merchant->mc_sales_staff_id;
            $mc = SalesStaff::find($mc_sales_staff_id);
            $mc_user_id = $mc->user_id;
            # Merchant Suspension
            $globals = Globals::first();
            $cto_email = $globals->cto_log_email;
            $ceo_email = $globals->ceo_log_email;
            $user = User::find($merchant_user_id);
            $merchant_email = $user->email;
            $mcuser = User::find($mc_user_id);
            $mc_email = $mcuser->email;
            // return $merchant_email;
            // Send to Merchant
            Mail::send('emails.account_termination.notify', ['merchant' => $merchant, 'type' => 'mer'], function ($m) use ($user, $merchant_email) {
                $m->from('info@opensupermall.com', 'Merchant Account Suspension ');
                $m->to($merchant_email, $user->name)->subject('Merchant Account Suspension OpenSupermall!');
            });
            // // Send to MC

            Mail::send('emails.account_termination.notify', ['merchant' => $merchant, 'type' => 'ops'], function ($m) use ($mcuser, $mc_email) {
                $m->from('info@opensupermall.com', 'Merchant Account Termination');
                $m->to($mc_email, $mcuser->name)->subject('Merchant Account Termination OpenSupermall!');
                // Send to CEO
            });
            Mail::send('emails.account_termination.notify', ['merchant' => $merchant, 'type' => 'ops'], function ($m) use ($ceo_email) {
                $m->from('info@opensupermall.com', 'Merchant Account Termination');
                $m->to($ceo_email, "CEO")->subject('Merchant Account Termination OpenSupermall!');
            });
            Mail::send('emails.account_termination.notify', ['merchant' => $merchant, 'type' => 'ops'], function ($m) use ($cto_email) {
                $m->from('info@opensupermall.com', 'Merchant Account Termination');
                $m->to($cto_email, "CTO")->subject('Merchant Account Termination OpenSupermall!');
            });
            return 1;
            // Mail Block
        } catch (\Exception $e) {
            return $e;
            return 0;
        }
    }

    public function merchantOnboard($email,$mode="osm")
    {
        try {
			$globalvars = DB::table("global")->first();
            $user = User::where('email', $email)->first();
            $user_id = $user->id;
            $purpose = "emailconf";
            $status = "new";
            $token = $this->token();

            /*  Paul on 06 May 2017 at 10 30 pm  */
            //$t=new Token();
            $t = new SecurityToken();
            /*  Ends Here  */

            $t->token = $token;
            $t->count = 0;
            $t->status = "active";
            $t->purpose = $purpose; //Check create_token for more info!
            $t->user_id = $user_id;
            $t->save();
            $subject='Merchant Account  Registration OpenSupermall!';
            $from="info@opensupermall.com";
            $from2="Merchant Account Registration";
            $viewtype='whiteifonz';
            $base_url=url();
            if ($mode=="onz") {
                # code...
                $subject='Thank You for registering with MPS!';
                $from="info@mpstele.my";
                $from2="Dealer Account Registration";
                //$base_url="http://mpstele.my";
            }
            // Generate the sexy url
           $url = $base_url . '/c/verify/' . $token . '/' . $email . '/' . $purpose . '/' . 3 . '/confirm?mode='.$mode;			
            //$url = url();			

			Log::debug('***** BEFORE Mail::send *****');
			Log::debug('$email='.$email);
            Mail::send('emails.merchant.onboard', ['user' => $user, 'confirm_url'=>$url,'mode'=>$mode, 'hours' => $globalvars->email_confirmation_duration], function ($m) use ($email, $user,$from,$from2,$subject) {
                $m->from($from,$from2);
                $m->to($email, $user->name)->subject($subject);
            });
			Log::debug('***** AFTER Mail::send *****');

            return 1;
        } catch (\Exception $e) {
			Log::debug('***** HERE LIES DINGBAT ****');
            Log::error('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
            //return $e->getMessage();
            return 0;
        }
    }
	
	public function humancapOnboard($email)
    {
        try {
			$globalvars = DB::table("global")->first();
            $user = User::where('email', $email)->first();
            $user_id = $user->id;
            $purpose = "emailconf";
            $status = "new";
            $token = $this->token();

            /*  Paul on 06 May 2017 at 10 30 pm  */
            //$t=new Token();
            $t = new SecurityToken();
            /*  Ends Here  */

            $t->token = $token;
            $t->count = 0;
            $t->status = "active";
            $t->purpose = $purpose; //Check create_token for more info!
            $t->user_id = $user_id;
            $t->save();
            // Generate the sexy url
           // $url = url() . '/c/verify/' . $token . '/' . $email . '/' . $purpose . '/' . 3 . '/confirm';	
			$url = url();
            Mail::send('emails.humancap.onboard', ['user' => $user, 'confirm_url'=>$url, 'hours' => $globalvars->email_confirmation_duration], function ($m) use ($email, $user) {
                $m->from('info@opensupermall.com', 'Employee Benefit Account Registration');
                $m->to($email, $user->name)->subject('Employee Benefit Account  Registration OpenSupermall!');
            });
            return 1;
        } catch (\Exception $e) {
            return $e->getMessage();
            return 0;
        }
    }
	
	

    public function employeeRequestOsmall($email)
    {
        try {

            Mail::send('emails.employee.request_osmall', ['email' => $email], function ($m) use ($email) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $email)->subject('Open Account Request');
            });
            return 1;
        } catch (\Exception $e) {
            dd($e);
        }
    }	
	
    public function employeeRequest($email, $company)
    {
        try {

            Mail::send('emails.employee.request', ['email' => $email, 'company' => $company], function ($m) use ($email, $company) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $email)->subject('Open Account Request');
            });
            return 1;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function fairRequest($email, $company)
    {
        try {

            Mail::send('emails.fair.request', ['email' => $email, 'company' => $company], function ($m) use ($email, $company) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $email)->subject('Open Account Request');
            });
            return 1;
        } catch (\Exception $e) {
            dd($e);
        }
    }
	
    public function customerRequest($email, $company)
    {
        try {

            Mail::send('emails.customer.request', ['email' => $email, 'company' => $company], function ($m) use ($email, $company) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $email)->subject('Open Account Request');
            });
            return 1;
        } catch (\Exception $e) {
            dd($e);
        }
    }	
	
    public function customerRequestOsmall($email)
    {
        try {

            Mail::send('emails.customer.request_osmall', ['email' => $email], function ($m) use ($email) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $email)->subject('Open Account Request');
            });
            return 1;
        } catch (\Exception $e) {
            dd($e);
        }
    }	

	public function sendCampaignOsmall($email, $campaign_id)
    {
        try {
			$campaign = DB::table('osmallcampaign')->where('id',$campaign_id)->first();
            Mail::send('emails.campaign.osmallcampaign', ['email' => $email, 'campaign' => $campaign], function ($m) use ($email, $campaign) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $email)->subject($campaign->name);
            });
            return 1;
        } catch (\Exception $e) {
            dd($e);
        }
	}
	
	public function sendCampaign($email, $campaign_id)
    {
        try {
			$campaign = DB::table('companycampaign')->where('id',$campaign_id)->first();
            Mail::send('emails.campaign.campaign', ['email' => $email, 'campaign' => $campaign], function ($m) use ($email, $campaign) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $email)->subject($campaign->name);
            });
            return 1;
        } catch (\Exception $e) {
            dd($e);
        }
	}	
	
    public function employeeAddedOsmall($email, $user)
    {
        try {

            Mail::send('emails.employee.added_osmall', ['user' => $user], function ($m) use ($email, $user) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $user->first_name)->subject('Added as Staff');
            });
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }	
	
    public function employeeAdded($email, $user, $company)
    {
        try {

            Mail::send('emails.employee.added', ['user' => $user, 'company' => $company], function ($m) use ($email, $user, $company) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $user->first_name)->subject('Added as Staff');
            });
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function fairAdded($email, $user, $company)
    {
        try {

            Mail::send('emails.fair.added', ['user' => $user, 'company' => $company], function ($m) use ($email, $user, $company) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $user->first_name)->subject('Added as Customer');
            });
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }
	
    public function customerAdded($email, $user, $company)
    {
        try {

            Mail::send('emails.customer.added', ['user' => $user, 'company' => $company], function ($m) use ($email, $user, $company) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $user->first_name)->subject('Added as Customer');
            });
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }	

    public function customerAddedOsmall($email, $user)
    {
        try {

            Mail::send('emails.customer.added_osmall', ['user' => $user], function ($m) use ($email, $user) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $user->first_name)->subject('Added as Customer');
            });
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }	
	
    public function roleAdded($email, $user, $role, $company)
    {
        try {

            Mail::send('emails.employee.roleadded', ['user' => $user, 'company' => $company, 'role' => $role], function ($m) use ($email, $user, $role, $company) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $user->first_name)->subject('New Role Appointed');
            });
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }	
	
    public function roleAddedOsmall($email, $user, $role)
    {
        try {

            Mail::send('emails.employee.roleadded_osmall', ['user' => $user, 'role' => $role], function ($m) use ($email, $user, $role) {
                $m->from('info@opensupermall.com', 'OpenSupermall');
                $m->to($email, $user->first_name)->subject('New Role Appointed');
            });
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }	

    public function stationOnboard($email)
    {
        try {
			$globalvars = DB::table("global")->first();
            $user = User::where('email', $email)->first();
            $user_id = $user->id;
            $purpose = "emailconf";
            $status = "new";
            $token = $this->token();

            /*  Paul on 06 May 2017 at 10 30 pm  */
            //$t=new Token();
            $t = new SecurityToken();
            /*  Ends Here  */

            $t->token = $token;
            $t->count = 0;
            $t->status = "active";
            $t->purpose = $purpose; //Check create_token for more info!
            $t->user_id = $user_id;
            $t->save();
            // Generate the sexy url
            $url = url() . '/c/verify/' . $token . '/' . $email . '/' . $purpose . '/' . 11 . '/confirm';				
            Mail::send('emails.station.onboard', ['user' => $user, 'confirm_url'=>$url, 'hours' => $globalvars->email_confirmation_duration], function ($m) use ($email, $user) {
                $m->from('info@opensupermall.com', 'Station Account Registration');
                $m->to($email, $user->name)->subject('Station Account  Registration OpenSupermall!');
            });
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function orderEmail($ref_no)
    {
        $all = DB::table('porderrefno')->get();
        # code...
        $data = DB::table('orderproduct')
            ->join('porder', 'orderproduct.porder_id', '=', 'porder.id')
            ->join('porderrefno as prr', 'prr.porder_id', '=', 'porder.id')
            ->join('product', 'orderproduct.product_id', '=', 'product.id')
            // ->join('users','porder.user_id','=','user.id')
            ->where('prr.ref_no', '=', $ref_no)
            ->select('porder.id as order_id', 'orderproduct.product_id as product_id')
            ->get();
        return view('emails.general.order_detail');
    }

    public static function testMail($email)
    {
        $user = User::find(1);

        Mail::send('emails.test', ['user' => $user], function ($m) use ($user, $email) {
            $m->from('info@opensupermall.com', 'Test Mail');

            $m->to($email)->subject('This is a test mail!');
        });
        return 1;
    }


    public static function sendOrderCancelMail($porder_id)
    {
        try {
            $user = User::find(Auth::user()->id);
            Mail::send('emails.orders.cancel_order', ['user' => $user, 'orderId' => IdController::nO($porder_id)], function ($m) use ($user) {
                $m->from('info@opensupermall.com', 'Order Cancelled');

                $m->to($user->email, $user->name)->subject('Hi! Confirmation for your order cancellation. OpenSupermall');
            });
            // echo "<script>console.log('Mail Sent #socm')</script>";
        } catch (\Exception $e) {
            // dump($e);
            // echo "<script>console.log('Mail Not Sent #socm')</script>";
        }
    }

    public static function sendOrderCancelMailBuyer($porder_id)
    {
        try {
			$order = DB::table('porder')->where('id',$porder_id)->first();
            $user = User::find($order->user_id);
            Mail::send('emails.orders.cancel_order_buyer', ['user' => $user, 'orderId' => IdController::nO($porder_id)], function ($m) use ($user) {
                $m->from('info@opensupermall.com', 'Order Cancelled');

                $m->to($user->email, $user->name)->subject('Hi! Your order ' . IdController::nO($porder_id) . ' have been cancelled. OpenSupermall');
            });
            // echo "<script>console.log('Mail Sent #socm')</script>";
        } catch (\Exception $e) {
            // dump($e);
            // echo "<script>console.log('Mail Not Sent #socm')</script>";
        }
    }	
	
    public static function callLogisticMail($user, $mer, $bAdd, $mAdd, $cn, $type)
    {

        $template = "emails.citilink.call_logistic";
        switch ($type) {
            case 'b2m':
                $template = "emails.citilink.call_logistic_buyer";
                break;

            default:
                # code...
                break;
        }

        $email = DB::table('global')->pluck('ctl_pickup_email1');

        try {
            Mail::send($template, ['user' => $user, 'mer' => $mer, 'bAdd' => $bAdd, 'mAdd' => $mAdd, 'cn' => $cn], function ($m) use ($user, $email, $cn) {
                $m->from('info@opensupermall.com', 'Package Pickup Request');

                $m->to($email, 'City Link')->subject('Package Pickup Request for ' . $cn->ctl_consignment_number . '!');
            });
            return 1;
        } catch (Exception $e) {
            dump($e);
        }
    }
	
    public static function callLogisticNVMail($user, $mer, $bAdd, $mAdd, $cn, $type)
    {

        $template = "emails.nv.call_logistic";
        switch ($type) {
            case 'b2m':
                $template = "emails.nv.call_logistic_buyer";
                break;

            default:
                # code...
                break;
        }

        $email = DB::table('global')->pluck('nv_pickup_email1');

        try {
            Mail::send($template, ['user' => $user, 'mer' => $mer, 'bAdd' => $bAdd, 'mAdd' => $mAdd, 'cn' => $cn], function ($m) use ($user, $email, $cn) {
                $m->from('info@opensupermall.com', 'Package Pickup Request');

                $m->to($email, 'Ninja Van')->subject('Package Pickup Request for ' . $cn->nv_tracking_id . '!');
            });
            return 1;
        } catch (Exception $e) {
            dump($e);
        }
    }

    public function sendCommissionEmail($CommissionData)
    {
        foreach ($CommissionData as $key => $CommissionSingleData) {
            $email =$CommissionSingleData->memberemail;
            $name = $CommissionSingleData->name;
            if(!empty($CommissionSingleData->useremail)){
                $userData = User::where('email', $CommissionSingleData->useremail)->first();
                $name = $userData->first_name.' '.$userData->last_name;
                $email = $userData->email;
            }
            
            //Generate Pdf
            $PdfFile = app('App\Http\Controllers\OpossumStaffController')->performance_download($CommissionSingleData->masseur_id,'ComssisonEmail');

            //send Email Function 
            Mail::send('emails.commission', ['EmailReceiverName' => $name], function ($m) use ($userData,$CommissionSingleData,$name,$email,$PdfFile) {
                $m->from('info@opensupermall.com', 'Commission Email');
                $m->attach($PdfFile, [
                        'mime' => 'application/pdf',
                    ]);
                $m->to($email, $name)->subject('Commission Email');

                // $m->attach('/path/to/file', [
                //         'as' => 'name.pdf',
                //         'mime' => 'application/pdf',
                // ]);
            });
            unlink($PdfFile);
        }
    }
}
