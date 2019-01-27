<?php

namespace App\Http\Controllers;
// Models
use App\Models\Autolink;
use App\Models\Merchant;
use App\Models\User;
// Ends Models
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use View;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Auth;
use Auth;
class AutoLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validate_request($id)
    {

        /*
            codes:
            unli ->user not logged in
            uara->user already requested autolink
            scpr->server could not process request
            sspr->server successfully process request


        */

        if (!Auth::check()) {
            $special_instruction="Please signup to use AutoLink feature";
            return response()->json(['status' => 'failure','code'=>'unli']);
            // return route('create_new_user')->with('special_instruction',$special_instruction);
        }
        // elseif () {
        //    Checkif already requested

        //     $check= ['initiator_uid'=>Auth::user()->id,'responder_uid'=>];
        //     $a = AutoLink::where('initiator_uid');
        //     return response()->json(['status' => 'failure','code'=>'uara']);
        // }
        else {
            # code.
            // return "you Clicked AutoLink";
            return $this->send_request($id);
        }
    }

    public function send_request($id)
    {
        //Check for already requested

        try {
            // Initiator
            $user_id= Auth::user()->id;
            // return $user_id;
            $user = User::where('id',$user_id)->first();
            // return $usser;
            // Merchant
            $merchant_id= Merchant::where('id',$id)->first();
            $merchant= User::where('id',$merchant_id->user_id)->first();
            $check= ['initiator_uid'=>Auth::user()->id,'responder_uid'=>$merchant->id];
            $double_check=['responder_uid'=>Auth::user()->id,'initiator_uid'=>$merchant->id];
            $a = AutoLink::where($check)->orWhere($double_check)->get();

            try {
                $a[0];
                return response()->json(['status' => 'failure','code'=>'uara']);
            } catch (\Exception $e) {
                //Pass
            }

            $link= new Autolink;
            $link->initiator_uid=$user->id;
            $link->mode='manual';
            $link->initiator_type='buyer';
            $link->responder_uid=$merchant->id;
            // $type = DB::table('role')
            $link->responder_type='merchant';
            $link->status='requested';
            $link->save();
			$newid = UtilityController::generaluniqueid($link->id, "2",'1', 'nautolinkid', 'nautolink_id');
			DB::table('nautolinkid')->insert([
				'nautolink_id'=>$newid,
				'autolink_id' =>$link->id,
				'created_at'  => date('Y-m-d H:i:s'),
				'updated_at'  => date('Y-m-d H:i:s')]);

            return response()->json(['status'=>'success','code'=>'sspr']);

        } catch (\Exception $e) {
            return $e;
            return response()->json(['status'=>'failure','code'=>'scpr']);
        }
    }
    public function delete()
    {
        $data= Request::all();
        $id=$data['id'];
        try {
            if (Auth::check()) {
                # code...
                $link=AutoLink::find($id);

                if ($link->initiator_uid==Auth::user()->id or $link->responder_uid==Auth::user()->id) {
                    # code...
                     AutoLink::destroy($id);
                    return response()->json(['status'=>'success','code'=>'lds']);
                }
                else{
                    return response()->json(['status'=>'failure','code'=>'ua1','message'=>'Unauthorized access']);
                }
            }
            else {
                 return response()->json(['status'=>'failure','code'=>'ua2','message'=>'Unauthorized access']);
            }

        } catch (\Exception $e) {
            return $e;
            return response()->json(['status'=>'failure','code'=>'ldf']);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    	//
    	 $autolinkeds= DB::select("SELECT type, id, linked_since, myid,user_id,name, responder, company_name, merchant_id , status, created_at FROM (
		 Select 'b' as type,a.id, a.linked_since,b.user_id, b.id as myid, CONCAT(u.first_name, ' ' ,u.last_name) as name, a.responder, m.company_name, m.id AS merchant_id, a.status, a.created_at FROM autolink a, merchant m, buyer b, users u WHERE a.responder = m.id AND b.user_id = a.initiator AND b.user_id = u.id AND a.deleted_at IS NULL AND NOT EXISTS(SELECT s.id FROM station s WHERE s.user_id = u.id)
		 UNION
		 Select 's' as type,a.id, a.linked_since,s.user_id, s.id as myid, CONCAT(u.first_name, ' ' ,u.last_name) as name, a.responder, m.company_name, m.id AS merchant_id, a.status, a.created_at FROM autolink a, merchant m, station s, users u WHERE a.responder = m.id AND s.user_id = a.initiator AND s.user_id = u.id AND a.deleted_at IS NULL AND NOT EXISTS(SELECT b.id FROM buyer b WHERE b.user_id = u.id)
		 ) as T order by created_at DESC");
         // return $autolinkeds;
	   	 $users = User::all();
         $merchants = Merchant::all();
          $currency = DB::table('currency')
                ->where('currency.active' ,'=',1)
                ->select('currency.code')
                ->get();
         foreach ($currency as $value) {
            $currency = $value;
         }
		  $autolinkedss= DB::select("Select a.id, a.linked_since,b.user_id, u.name, a.responder, m.company_name, m.id AS merchant_id,a.linked_since, a.status FROM autolink a, merchant m, buyer b, users u WHERE a.responder = m.id AND b.user_id = a.initiator AND b.user_id = u.id AND a.deleted_at IS NULL AND NOT EXISTS(SELECT s.id FROM station s WHERE s.user_id = u.id) order by a.created_at DESC");
    	// load the view and pass the nerds
//     	return View::make('autolinks.index',[
//     										'autolinkeds' => $autolinkeds,
// 							    			'users' =>$users,
// 							    			'merchants'=>$merchants
//     										]);
		//dd($autolinkeds);
    	return view("autolinks.index",[
    			'autolinkeds' => $autolinkeds,
    			'users' =>$users,
                'currency' => $currency,

    	]);
    }
	
    public function approval($id)
    {
    	//
    	 $autolinkeds= DB::select("SELECT type, id, linked_since, myid,user_id,name, responder, company_name, merchant_id , status, created_at FROM (
		 Select 'b' as type,a.id, a.linked_since,b.user_id, b.id as myid, CONCAT(u.first_name, ' ' ,u.last_name) as name, a.responder, m.company_name, m.id AS merchant_id, a.status, a.created_at FROM autolink a, merchant m, buyer b, users u WHERE a.responder = m.id AND b.user_id = a.initiator AND b.user_id = u.id AND a.deleted_at IS NULL AND NOT EXISTS (SELECT s.id FROM station s WHERE s.user_id = u.id) AND a.id = $id
		 UNION
		 Select 's' as type,a.id, a.linked_since,s.user_id, s.id as myid, CONCAT(u.first_name, ' ' ,u.last_name) as name, a.responder, m.company_name, m.id AS merchant_id, a.status, a.created_at FROM autolink a, merchant m, station s, users u WHERE a.responder = m.id AND s.user_id = a.initiator AND s.user_id = u.id AND a.deleted_at IS NULL AND NOT EXISTS (SELECT b.id FROM buyer b WHERE b.user_id = u.id) AND a.id = $id
		 ) as T order by created_at DESC");
         // return $autolinkeds;
	   	 $users = User::all();
         $merchants = Merchant::all();
          $currency = DB::table('currency')
                ->where('currency.active' ,'=',1)
                ->select('currency.code')
                ->get();
         foreach ($currency as $value) {
            $currency = $value;
         }
		 /* $autolinkedss= DB::select("Select a.id, a.linked_since,b.user_id, u.name, a.responder, m.company_name, m.id AS merchant_id,a.linked_since, a.status FROM autolink a, merchant m, buyer b, users u WHERE a.responder = m.id AND b.user_id = a.initiator AND b.user_id = u.id AND a.deleted_at IS NULL AND NOT EXISTS(SELECT s.id FROM station s WHERE s.user_id = u.id) order by a.created_at DESC");*/
    	// load the view and pass the nerds
//     	return View::make('autolinks.index',[
//     										'autolinkeds' => $autolinkeds,
// 							    			'users' =>$users,
// 							    			'merchants'=>$merchants
//     										]);
		//dd($autolinkeds);
    	return view("autolinks.approval",[
    			'autolinkeds' => $autolinkeds,
    			'users' =>$users,
                'currency' => $currency,

    	]);
    }	

   public function accept()
   {
       # code..

		$message="?";

        # code...
        $data = Request::all();

		// return $data['id'];
		if (!Auth::check()) {
			# code...
			$message=["status"=>'failure',
				'long_message'=>'AutoLink requires user to be logged in'];
		}

		$autoid=$data['id'];
		$autolink=Autolink::find($autoid);
		if ($autolink->status=="linked") {
			# code...
			$message=["status"=>'failure',
				'long_message'=>'You are already AutoLinked'];

		return response()->json($message);
    }

    // return $autolink;
    if ($autolink->responder_uid!=Auth::user()->id) {
        $message=['status'=>'failure',
			'long_message'=>'You are not authorized to accept AutoLink'];

    } else if ($autolink->responder_uid==Auth::user()->id) {
        # code...
        $autolink->status="linked";
        $autolink->linked_since=Carbon::now();
        $autolink->remarks=$data['remark'];
        $autolink->save();
        // check if u
        $dealer=new Dealer;
        $dealer->user_id=Auth::user()->id;
        $dealer->save();
        $message=['status'=>'success',
			'long_message'=>'You have been AutoLlinked'];
    }

    return response()->json($message);
	}

    public function destroy()
    {
    	//
            if (Request::ajax()) {
        # code...
        $data = Request::all();
    }

     if (!Auth::check()) {
        # code...
        $message=["status"=>'failure'];
    }

    $autoid=$data['id'];
    	try {
                    $autolinked = Autolink::find($autoid);
        $autolinked->delete();
        $message=['status'=>'success'];
        } catch (\Exception $e) {
            $message=['status'=>'failure'];
        }

    	 return response()->json($message);
    }
    public function merchant($user_id)
    {
        if (!Auth::check()) {
        $special_instruction="Please signup to use AutoLink feature";
        return response()->json(['status' => 'failure','code'=>'unli']);
        }
          try {
            // Initiator
            $merchant_user_id= Auth::user()->id;
            // return $user_id;
            // $user = User::where('id',$user_id)->first();
            // return $usser;
            // Merchant
            // $merchant_id= Merchant::where('id',$id)->first();
            // $merchant= User::where('id',$merchant_id->user_id)->first();
            $check= ['initiator_uid'=>$merchant_user_id,'responder_uid'=>$user_id];
            $a = AutoLink::where($check)->get();

            try {
                $a[0];
                return response()->json(['status' => 'failure','code'=>'uara']);
            } catch (\Exception $e) {
                //Pass
            }

            $link= new Autolink;
            $link->initiator_uid=$merchant_user_id;
            $link->initiator_type='merchant';
            $link->responder_uid=$user_id;
            // $type = DB::table('role')
            $link->mode='manual';
            $link->responder_type='buyer';
            $link->status='requested';
            $link->save();
            return response()->json(['status'=>'success','code'=>'sspr']);
        } catch (\Exception $e) {
            return $e;
            return response()->json(['status'=>'failure','code'=>'scpr']);
        }
    }

    public function request_autolink(Request $request)
    {
        //Check for already requested

        try {
			$r = $request->all();
            // Initiator
			$autolinkr=DB::table('autolink')->where('status','requested')->where(['initiator'=>$r['autolink_user_id'],'responder'=>$r['autolink_merchant_id']])->get();
		   if(count($autolinkr)==0){
				$autolinkr=DB::table('autolink')->where(['initiator'=>$r['autolink_user_id'],'responder'=>$r['autolink_merchant_id']])->first();
				if(!is_null($autolinkr)){
					DB::table('autolink')->where(['initiator'=>$r['autolink_user_id'],'responder'=>$r['autolink_merchant_id']])->update(['status'=>'requested', 'updated_at' => date('Y-m-d H:i:s')]);
				} else {
					$link= new Autolink;
					$link->initiator=$r['autolink_user_id'];
					$link->responder=$r['autolink_merchant_id'];
					$link->status='requested';
					$link->save();
					$ism = DB::table('merchant')->where('user_id',$r['autolink_user_id'])->count();
					$iss = DB::table('station')->where('user_id',$r['autolink_user_id'])->count();
					$type = "1";
					if($iss > 0){
						$type = "2";
					}
					if($ism > 0){
						$type = "4";
					}		/**/			
					$newid = UtilityController::generaluniqueid($link->id, '2',$type, $link->created_at, 'nautolinkid', 'nautolink_id');
					DB::table('nautolinkid')->insert(['nautolink_id'=>$newid, 'autolink_id'=>$link->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);						
				}
			
		   }
            return response()->json(['status'=>'success','code'=>'sspr']);
        } catch (\Exception $e) {
            return $e;
            return response()->json(['status'=>'failure','code'=>'scpr']);
        }
    }
	
    public function cancel_autolinko(Request $request)
    {
        //Check for already requested

        try {
			$r = $request->all();
            // Initiator
			$autolinkr=DB::table('autolink')->
				where([
					'initiator'=>$r['autolink_user_id'],
					'responder'=>$r['autolink_merchant_id']])->
					update(['status'=>'unlinked']);

			if(count($autolinkr)==0) {
				/*$link= new Autolink;
				$link->initiator=$r['autolink_user_id'];
				$link->responder=$r['autolink_merchant_id'];
				$link->status='requested';
				$link->save();*/
			}
			return response()->json(['status'=>'success','code'=>'sspr']);

        } catch (\Exception $e) {
            return $e;
            return response()->json(['status'=>'failure','code'=>'scpr']);
        }
    }	
	
    public function cancel_autolink(Request $request)
    {
		$r = $request->all();
		$autolinkr=DB::table('autolink')->
			where('id',$r['link_id'])->update(array('status'=>'unlinked'));

		return $autolinkr;		
	}	
	
    public function delete_autolink(Request $request)
    {
		$r = $request->all();
		$autolinkr=DB::table('autolink')->
			where('id',$r['link_id'])->
			update(array('deleted_at' =>
				date('Y-m-d H:i:s'), 'status'=>'unlinked'));

		return $autolinkr;		
	}	
	

    public function approveAutolink() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
         return \App\Classes\AdminApproveHelper::approveAutolink($inputs);

      }
    }
	
    public function approveAutolinkb() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
         return \App\Classes\AdminApproveHelper::approveAutolinkb($inputs);

      }
    }	
	
    //function for saving remarks of station
    public function saveAutolinkRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        $res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
            $res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
            echo $res;
        }
        //echo "Hola";
    }

    public function autolink_remarks($id){
        $remarks = DB::select(DB::raw("select remark.remark, merchant.id as merchant_id, remark.user_id, nbuyerid.nbuyer_id, nsellerid.nseller_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, 
		remark.status from remark inner join autolinkremark on autolinkremark.remark_id = remark.id left join nbuyerid on remark.user_id = nbuyerid.user_id
		inner join autolink on autolinkremark.autolink_id = autolink.id inner join merchant on autolink.responder = merchant.id
		left join nsellerid on merchant.user_id = nsellerid.user_id
		where autolinkremark.autolink_id = " . $id . " order by remark.created_at desc"));
		
        return json_encode($remarks);
    }

 }
