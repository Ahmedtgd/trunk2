<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SMMout;
use App\Models\RoleUser;
use Guzzle\Http\Client;
use SnappyImage;
use App\OWish;
use App\Models\Channel;
use App\Models\UserChannel;
use Auth;

class CRMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function member_remarks($id){
		$remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status, nbuyerid.nbuyer_id from remark inner join osmallmemberremark on osmallmemberremark.remark_id = remark.id join osmallmember on osmallmemberremark.member_id = osmallmember.id left join nbuyerid on osmallmember.user_id = nbuyerid.user_id where osmallmemberremark.member_id = " . $id . " order by remark.created_at desc"));

		return json_encode($remarks);
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
	 
    public function approveMember() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
         return \App\Classes\AdminApproveHelper::approveOsmallMember($inputs);

      }
    }		 
	 
	public function add_recruiter(Request $r)
    {
		DB::table('osmallmember')->where('user_id',$r->user_id)->update(['recruiter_id'=>$r->val]);
		$res = DB::table('users')->where('id',$r->val)->first();
		return response()->json(['response'=>$res->first_name . " " . $res->last_name]);
	}	 
	 
	public function member_status($id)
    {
		$member = DB::table('osmallmember')->where('user_id',$id)->join('users as u2','u2.id','=','osmallmember.user_id')->leftJoin('users','users.id','=','osmallmember.recruiter_id')->select('osmallmember.*','users.first_name as recruiter_first_name','users.last_name as recruiter_last_name','u2.first_name as member_first_name','u2.last_name as member_last_name')->first();
		$recruiters = DB::table('users')->join('buyer','users.id','=','buyer.user_id')->where('buyer.user_id','!=',$id)->select('buyer.user_id','users.last_name','users.first_name')->get();
		return view('crm.memberdetail')->with('member',$member)->with('recruiters',$recruiters);
	}	 
	 
	public function changememberrole(Request $r, $user_id)
    {
		//dd($r->data);
		foreach ($r->data as $key => $value) {
			$isrole = DB::table('role_users')->where('role_id',$key)->where('user_id',$user_id)->first();
			if($value == "false"){
				DB::table('role_users')->where('role_id',$key)->where('user_id',$user_id)->delete();
			} else {
				if(is_null($isrole)){
					$role = new RoleUser;
					$role->user_id = $user_id;
					$role->role_id = $key;
					$role->save();
				}
			}
		}
		return response()->json(['status'=>'success']);
	}	 
	 
	public function adminmemberrole($user_id)
    {
		$memberroles = DB::table('roles')->where('memberlist',true)->get();
		$asroles = array();
		foreach($memberroles as $memberroles){
			$asroles[$memberroles->id] = DB::table('role_users')->where('role_id',$memberroles->id)->where('user_id',$user_id)->count();
		}
		return json_encode(['asroles'=>$asroles]);
	}	 
	
	public function adminmemberrolecust($user_id)
    {
		$memberroles = DB::table('roles')->where('customerlist',true)->get();
		$asroles = array();
		foreach($memberroles as $memberroles){
			$asroles[$memberroles->id] = DB::table('role_users')->where('role_id',$memberroles->id)->where('user_id',$user_id)->count();
		}
		return json_encode(['asroles'=>$asroles]);
	}		
	 
	public function send_campaign(Request $r)
    {	
		for($i = 0; $i < count($r->campaings); $i++){
			$members = DB::table('osmallcampaignmember')->where('osmallcampaign_id',$r->campaings[$i])->where('send',true)->get();
			foreach($members as $member){
				try{
					$customer = DB::table('osmallmember')->where('id',$member->osmallmember_id)->first();
					$user = DB::table('users')->where('email',$customer->email)->first();
					$e= new EmailController;
					if(!is_null($user)){
						$e->sendCampaignOsmall($customer->email, $r->campaings[$i]);
					} else {
						$e->customerRequestOsmall($customer->email);
					}
				} catch(\Exception $e){
					//dump($e);
				}
			}
		}
		return response()->json(['status'=>'success']);
	} 
	 
	public function save_campaign(Request $r)
    {
		for($i = 0; $i < count($r->emails); $i++){
			$member = DB::table('osmallcampaignmember')->where('osmallmember_id',$r->emails[$i]['id'])->where('osmallcampaign_id',$r->campaign_id)->first();
			if($r->emails[$i]['action'] ==  "true"){
				if(!is_null($member)){
					DB::table('osmallcampaignmember')->where('id',$member->id)->update(['send'=>true, 'updated_at' => date('Y-m-d H:i:s')]);
				}
			} else {
				if(!is_null($member)){
					DB::table('osmallcampaignmember')->where('id',$member->id)->update(['send'=>false, 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}
	//	dd("DONE");
		return response()->json(['status'=>'success']);
	} 
	 
	public function send_emails(Request $r)
    {
		
		try{
			foreach ($r->emails as $key => $email) {
				$user = DB::table('users')->where('email',$email)->first();
				if(is_null($user)){
					$e= new EmailController;
					$e->employeeRequestOsmall($email);
				} else {
					$role = DB::table('roles')->whereIn('id',[15,16,18,19,20,21])->join('role_users','roles.id','=','role_users.role_id')->where('role_users.user_id',$user->id)->select('roles.*')->first();
					if(is_null($role)){
						$e= new EmailController;
						$e->employeeAddedOsmall($email, $user);
					} else {
						$e= new EmailController;
						$e->roleAddedOsmall($email, $user, $role);
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

	public function send_emails_c(Request $r)
    {
		
		try{
			$user_id=Auth::user()->id;
			$campaigns=DB::table('osmallcampaign')->orderBy('created_at')->get();
			$campaignexists = false;
			$campaign_tosend = null;
			foreach($campaigns as $campaign){
				$campaigns_members = DB::table('osmallcampaignmember')->where('osmallcampaign_id',$campaign->id)->count();
				$campaign->customers = $campaigns_members;
				if($campaigns_members == 0){
					$campaignexists = true;	
					$campaign_tosend = DB::table('osmallcampaign')->where('id',$campaign->id)->first();
				}
			}
			/*Check for active channel*/
			$allow_fb=true;
			$allow_email=true;
			$email_channel=Channel::where('name','email')->first();
			$email_channel=UserChannel::where('user_id',$user_id)->where('status','active')->where('channel_id',$email_channel->id)->first();
			if (empty($email_channel)) {
				$allow_email=false;
			}
			$fb_channel=Channel::where('name','sma')->first();
			$fb_channel=UserChannel::where('user_id',$user_id)->where('status','active')->where('channel_id',$fb_channel->id)->first();
			if (empty($email_channel)) {
				$allow_fb=false;
			}
			// echo $user_id;
			// exit;
			/*Refactoring by Zurez*/ 
			foreach ($r->emails as $key => $email) {
				$user=DB::table('users')->where('email',$email)->first();
				/*Email Block*/

				if ($allow_email) {
					$e=new EmailController;
					if (empty($user)) {
						$e->customerRequestOsmall($email);
					}
					if (!is_null($campaign_tosend) && $campaignexists) {
						$member = DB::table('osmallmember')->where('email',$email)->where('type','customer')->first();
						if(!empty($member)){
							DB::table('osmallcampaignmember')->insert(['osmallmember_id'=>$member->id, 'send'=>true
							, 'osmallcampaign_id' => $campaign_tosend->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						}
						$e->sendCampaignOsmall($email, $campaign_tosend->id);
					}
					elseif (!empty($user)) {
						$role = DB::table('roles')->whereIn('id',[26])->join('role_users','roles.id','=','role_users.role_id')->where('role_users.user_id',$user->id)->select('roles.*')->first();
							if(is_null($role))
							{
								$e->customerAddedOsmall($email, $use);
							} 
							else {
								$e->roleAddedOsmall($email, $user, $role);
							}
					}
				}
				/*FB Block*/
				if ($allow_fb==true and !empty($user)) {
				 	$r=$this->send_campaign_facebook($campaign_tosend->id,$user->id);
				 } 
			}
			/* 
			if ($allow_email) {
				if(!is_null($campaign_tosend) && $campaignexists){
				foreach ($r->emails as $key => $email) {
					// 
					$user = DB::table('users')->where('email',$email)->first();
					if(is_null($user)){
						$e= new EmailController;
						$e->customerRequestOsmall($email);
					} else {
						
						$member = DB::table('osmallmember')->where('email',$email)->where('type','customer')->first();
						if(!is_null($member)){
							DB::table('osmallcampaignmember')->insert(['osmallmember_id'=>$member->id, 'send'=>true
							, 'osmallcampaign_id' => $campaign_tosend->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						}
						//$customer = DB::table('osmallmember')->where('id',$member->osmallmember_id)->first();
						$e= new EmailController;
						$e->sendCampaignOsmall($email, $campaign_tosend->id);
					}
				}
				} else {
					foreach ($r->emails as $key => $email) {
						$user = DB::table('users')->where('email',$email)->first();
						if(is_null($user)){
							$e= new EmailController;
							$e->customerRequestOsmall($email);
						} else {
							$role = DB::table('roles')->whereIn('id',[26])->join('role_users','roles.id','=','role_users.role_id')->where('role_users.user_id',$user->id)->select('roles.*')->first();
							if(is_null($role)){
								$e= new EmailController;
								$e->customerAddedOsmall($email, $use);
							} else {
								$e= new EmailController;
								$e->roleAddedOsmall($email, $user, $role);
							}
						}	
					}
				}
			}
			*/
			return response()->json(['status'=>'success']);
		} catch (\Exception $e) {
			// dd($e->getMessage());
			return response()->json(['status'=>'error',
				'line'=>$e->getLine(),
				'short_message'=>$e->getMessage(),
				'long_message'=>'An unexpected error ocurred! Please contact OpenSupport']);
        }	
	}		
	 
	public function segments() {
		$segments=DB::table('osmallmembersegment')->get();
		return view('crm.segments')	
            ->with('segments', $segments);
	}
	public function c_campaigns($id) {
		$campaigns=DB::table('osmallcampaign')->join('osmallcampaignmember','osmallcampaign.id','=','osmallcampaignmember.osmallcampaign_id')
					->where('osmallcampaignmember.osmallmember_id',$id)
					->orderBy('osmallcampaign.created_at')->get();
		 return view('crm.customer_campaign')	
            ->with('campaigns', $campaigns);
	}
	public function campaign() {
		$campaigns=DB::table('osmallcampaign')->orderBy('created_at')->get();
		foreach($campaigns as $campaign){
			$campaigns_members = DB::table('osmallcampaignmember')->join('osmallmember','osmallmember.id','=','osmallcampaignmember.osmallmember_id')
			->where('send',true)->where('osmallcampaign_id',$campaign->id)->count();
			$campaign->customers = $campaigns_members;
		}
        return view('crm.campaign')	
            ->with('campaigns', $campaigns);			
	}
	
	public function campaigncustomers($id) {
		$campaign=DB::table('osmallcampaign')->where('id',$id)->first();
		$customers=DB::table('osmallmember')
        ->leftJoin('users','users.id','=','osmallmember.user_id')
		->leftJoin('osmallmembersegment','osmallmembersegment.id','=','osmallmember.osmallmembersegment_id')
        ->where('osmallmember.type','customer')
        ->select(DB::raw("
            osmallmember.*,
			osmallmembersegment.description as segment,
            users.first_name as users_first_name,
            users.last_name as users_last_name
          "))
        ->get();		
		foreach($customers as $customer){
			$campaigns_members = DB::table('osmallcampaignmember')->where('osmallmember_id',$customer->id)->where('osmallcampaign_id',$campaign->id)->count();
			$campaignsm= DB::table('osmallcampaignmember')->where('osmallmember_id',$customer->id)->where('osmallcampaign_id',$campaign->id)->first();
			$customer->incampaign = $campaigns_members;
			$customer->send = 0;
			if(!is_null($campaignsm)){
				$customer->send = $campaignsm->send;
			}
		}
        return view('crm.campaigncustomers')	
            ->with('customers', $customers)		
            ->with('campaign', $campaign);			
	}	
	
	public function lasttemplate() {
		$campaigns=DB::table('osmallcampaign')->orderBy('created_at')->get();
		$campaignexists = false;
		$campaign_tosend = null;
		foreach($campaigns as $campaign){
			$campaigns_members = DB::table('osmallcampaignmember')->where('osmallcampaign_id',$campaign->id)->count();
			$campaign->customers = $campaigns_members;
			if($campaigns_members == 0){
				$campaignexists = true;	
				$campaign_tosend = DB::table('osmallcampaign')->where('id',$campaign->id)->first();
			}
		}
		$template = "Template is not defined.";
		$name = "Name is not defined.";
		if($campaignexists){
			if(!is_null($campaign_tosend->template) && $campaign_tosend->template != ""){
				$template = $campaign_tosend->template;
				$name = $campaign_tosend->template_name;
			}
		}
		return response()->json(['html'=>$template,'name'=>$name]);
	}
	
	public function members() {
		$user_id=Auth::user()->id;
		$members=DB::table('osmallmember')
        ->leftJoin('users','users.id','=','osmallmember.user_id')
        ->where('osmallmember.type','member')
        ->select(DB::raw("
            osmallmember.*,
            users.first_name as users_first_name,
            users.last_name as users_last_name,
            users.id as user_id
          "))
		->orderBy('created_at','DESC')
        ->get();
		foreach ($members as $m) {
			$conn=SMMout::where('user_id',$m->user_id)->
			pluck('connections');
			$m->connections=$conn;
		}
		$customers=DB::table('osmallmember')
        ->leftJoin('users','users.id','=','osmallmember.user_id')
		->leftJoin('osmallmembersegment','osmallmembersegment.id','=','osmallmember.osmallmembersegment_id')
        ->where('osmallmember.type','customer')
        ->where('osmallmember.recruiter_id','0')
        ->select(DB::raw("
            osmallmember.*,
			osmallmembersegment.description as segment,
            users.first_name as users_first_name,
            users.last_name as users_last_name
          "))
		->orderBy('created_at','DESC')
        ->get();
		foreach($customers as $customer){
			$campaigns_members = DB::table('osmallcampaignmember')->where('osmallmember_id',$customer->id)->count();
			$customer->countcamp = $campaigns_members;
			$member_segments = DB::table('osmembersegment')->join('osmallmembersegment','osmallmembersegment.id','=','osmembersegment.segment_id')
			->where('osmallmember_id',$customer->id)->get();
			$segments = "";
			foreach($member_segments as $member_segment){
				$segments .= $member_segment->description;
			}
			$customer->segments = $segments;			
		}
		$memberroles = DB::table('roles')->where('memberlist',true)->get();
		$customerroles = DB::table('roles')->where('customerlist',true)->get();
		$membersegments = DB::table('osmallmembersegment')->get();
	/*	$customers=DB::table('member')
    /    ->leftJoin('users','users.id','=','member.user_id')
     //   ->leftJoin('role_users','users.id','=','role_users.user_id')
       // ->leftJoin('roles','roles.id','=','role_users.role_id')
        ->join('company','member.company_id','=','company.id')
      //  ->join('logistic','logistic.company_id','=','company.id')
        ->where('company.owner_user_id',$user_id)
        ->where('member.type','customer')
        ->select(DB::raw("
            member.*,
            users.first_name as users_first_name,
            users.last_name as users_last_name
          "))
        ->get();*/
		//$customerroles = DB::table('roles')->where('customerlist',true)->get();
        // STATEMENT
		//dd($memberroles);
		$channels=Channel::get();
		foreach ($channels as $chan) {
			$uchan=UserChannel::where('user_id',$user_id)->
			where('status','active')->
			where('channel_id',$chan->id)
			->first();
			if (empty($uchan)) {
				$chan->checked=false;
			}else{
				$chan->checked=true;
			}
		}
		// UserChannel::where('user_id',$user_id)->get();
		$campaigns=DB::table('osmallcampaign')->orderBy('created_at')->get();
		$campaignexists = false;
		$campaign_tosend = null;
		foreach($campaigns as $campaign){
			$campaigns_members = DB::table('osmallcampaignmember')->where('osmallcampaign_id',$campaign->id)->count();
			$campaign->customers = $campaigns_members;
			if($campaigns_members == 0){
				$campaignexists = true;	
				$campaign_tosend = DB::table('osmallcampaign')->where('id',$campaign->id)->first();
			}
		}	
		// dd($channels);	
        return view('crm.members')
            ->with('membersegments',$membersegments)
            ->with('campaignexists',$campaignexists)
            ->with('memberroles',$memberroles)
            ->with('customerroles',$customerroles)
            ->with('members', $members)		
            ->with('customers', $customers)
            ->with('channels',$channels)
            ;		
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
	 
	public function deletecampaign(Request $r){
		DB::table('osmallcampaign')->where('id',$r->id)->delete();
		return response()->json(['status'=>'success']);
	}
	
	public function deletemember(Request $r)
    {
		DB::table('osmallmember')->where('email',$r->email)->delete();
		return response()->json(['status'=>'success']);
	}	 
	 
	public function changeosmallmemberrole(Request $r, $user_id)
    {
		//dd($r->data);
		foreach ($r->data as $key => $value) {
			$isrole = DB::table('role_users')->where('role_id',$key)->where('user_id',$user_id)->first();
			if($value == "false"){
				DB::table('role_users')->where('role_id',$key)->where('user_id',$user_id)->delete();
			} else {
				if(is_null($isrole)){
					$role = new RoleUser;
					$role->user_id = $user_id;
					$role->role_id = $key;
					$role->save();
				}
			}
		}
		return response()->json(['status'=>'success']);
	}
	
	 public function add_employee(Request $r, $type = "member")
    {
		try{
			$sword = "Staff";
			if($type != "member"){
				if($type == "fair"){				
					$sword = "Member";	
				} else {
					$sword = "Customer";	
				}
					
			}
			if($type == "fair"){
				$type = "customer";
			}
			$email=$r->email;
			$email = str_replace(" ","",$email);
			$user = DB::table('users')->where('email',$email)->first();
			$recruiter = $r->recruiter;
			$emailexists = DB::table('osmallmember')->where('email',$email)->where('type',$type)->first();
			if(is_null($emailexists)){
				if(is_null($user)){
					if(is_null($recruiter)){
						$mid = DB::table('osmallmember')->insertGetId(['email'=>$email,'type'=>$type,'user_id'=>0,'member_status'=>'not exists','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					} else {
						$mid = DB::table('osmallmember')->insertGetId(['email'=>$email,'type'=>$type,'user_id'=>0,'recruiter_id'=>$recruiter,'member_status'=>'not exists','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					}
					//dd($mid);
					$newmember = DB::table('osmallmember')->where('id',$mid)->first();
					$id= new IdController;
					$newid = $id->nB(0);
					$newemployee = array('id'=>$newid,'member_id'=>$mid,'user_id'=>0, 'name' => "", 'status' => $newmember->status, 'role' => '', 'email'=>$email);
					
					return response()->json(['status'=>'success',
					'long_message'=>'New ' . $sword . ' stored!','employee'=>$newemployee]);	
				} else {
					if(is_null($recruiter)){
						$mid = DB::table('osmallmember')->insertGetId(['email'=>$email,'type'=>$type,'user_id'=>$user->id,'member_status'=>'tagged','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					} else {
						$mid = DB::table('osmallmember')->insertGetId(['email'=>$email,'type'=>$type,'user_id'=>$user->id,'recruiter_id'=>$recruiter,'member_status'=>'tagged','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					}			
					
					$newmember = DB::table('osmallmember')->where('id',$mid)->first();
					$id= new IdController;
					$newid = $id->nB($user->id);
					$newemployee = array('id'=>$newid,'member_id'=>$mid,'user_id'=>$user->id, 'name' => $user->first_name . " " . $user->last_name, 'status' => $newmember->status, 'role' => 'Member', 'email'=>$email);
					
					return response()->json(['status'=>'success',
					'long_message'=> $sword . ' is Tagged!','employee'=>$newemployee]);						
				}
			} else {
				return response()->json(['status'=>'warning',
					'long_message'=>'Existing Tagged ' . $sword . '!']);
			}
		} catch (\Exception $e) {
			//dd($e);
			return response()->json(['status'=>'error',
				'long_message'=>'An unexpected error ocurred! Please contact OpenSupport']);
        }
	}		 
	
	public function campaign_screenshot($campaign)
	{
		// 1,200 x 630 pixels
		$file_name=$campaign->id.".jpg";
		$file_path=public_path("images/campaign/".$file_name);
		try {
			unlink($file_path);
		} catch (\Exception $e) {
			
		}
		SnappyImage::loadView('crm.campaign_webview_raw',['campaign'=>$campaign])
		->setOption('height',315)
		->setOption('width',600)
		->save($file_path);
		
		DB::table('osmallcampaign')->
		where('id',$campaign->id)->
		whereNull('deleted_at')->
		update(['image_path'=>$file_name]);

		
		
		return $file_path;
		
	}
	
	public function show_campaign_webview($campaign_id)
	{
		$campaign=DB::table('osmallcampaign')->
				  where('id',$campaign_id)->
				  whereNull('deleted_at')->
				  first();
		$this->campaign_screenshot($campaign);
		if (!empty($campaign)) {
			return view("crm.campaign_webview")
			->with('campaign',$campaign);
		}else{
			return view("common.generic")
			->with('message_type','error')
		->with('message','The campaign does not exist.')
			;
		}
	}

	public function send_campaign_facebook($campaign_id,$customer_user_id)
	{
		$campaign_url=url('campaign',$campaign_id);
		$data = [
					'link' => $campaign_url,
					'from' => "Opensupermall"
				];
		$o= new OWish;
		$result=$o->facebook($data,$customer_user_id);

		return $result;
	}

	public function save_campaign_channel(Request $r)
	{
		$ret=array();
		$ret['long_message']="Failed to save channel.";
		try {
			$user_id=Auth::user()->id;
			$channel_array=$r->channel_array;
			if (Auth::user()->hasRole('adm') and !empty($r->user_id) and $r->has('user_id')) {
				$user_id=$r->user_id;
			}
			
			foreach ($channel_array as $id=>$action) {
				$uc=UserChannel::where('user_id',$user_id)->
				where('channel_id',$id)->first();
				if (empty($uc)) {
					$uc= new UserChannel;
				}else{
					$uc=UserChannel::find($uc->id);
				}
				$uc->user_id=$user_id;
				$uc->channel_id=$id;
				$uc->status=$action;
				$uc->save();
				
			}
			$ret['long_message']="Your channels have been saved.";

		} catch (\Exception $e) {
			// return $e;
			$ret['short_message']=$e->getMessage()."| Line".$e->getLine();
		}
		
		return response()->json($ret);
	}
}
