<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;
use App\Models\SMMout;
use App\Models\Member;
use DB;
use Auth;
use Carbon;
use Yajra\Datatables\Facades\Datatables;

class StaffManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r,$userid = null)
    {
        $total_smm_army=0;
        $members = DB::table('member')->
                leftJoin('users', 'users.id', '=', 'member.user_id')->
                leftJoin('nstaff', 'nstaff.member_id', '=', 'member.id')->
                join('company', 'member.company_id', '=', 'company.id')->
                where('company.owner_user_id', $userid)->
                where('member.user_id','!=' , $userid)->
                where('member.type', 'member')->
                select(DB::raw("
            member.*,
            users.first_name as users_first_name,
            users.last_name as users_last_name,
            nstaff.name,
            nstaff.nickname,
            users.id as user_id
            "))
                ->groupBy("member.id")
                ->orderBy('created_at', 'DESC')
                ->get();
        foreach ($members as $m) {
            $conn = SMMout::where('user_id', $m->user_id)->
				pluck('connections');
            $m->connections = $conn;
        }
        
        
        $staff = collect((object) $members);

        return Datatables::of($staff)
            ->addIndexColumn()
            ->addColumn('no', function ($staff) {
                return $staff->id;
            })
            ->editColumn('name', function ($staff) {
                $name = '<a href="javascript:void(0);" class="text-center" onclick="show_add_staff_modal('.$staff->id.')">';
                if(empty($staff->name) and empty($staff->nickname) and empty($staff->users_first_name)){
                    $name .= 'Name';

                } elseif (!empty($staff->users_first_name)){
                    $name .= $staff->users_first_name." ".$staff->users_last_name;
                } elseif (!empty($staff->name)){
                    $name .= $staff->name;
                } else {
                    $name .= $staff->nickname;
                }
                $name .= '</a>';
                return $name;})->
				addColumn('roles', function ($staff) use ($total_smm_army) {
                $sysrole = "";
                $pursel = "";
                $memsel = "";
                $ebusel = "";
                $sysquery = DB::table('roles')->
					join('role_users','roles.id','=','role_users.role_id')->
					where('role_users.user_id',$staff->user_id)->
					whereIn('roles.id',[15,18,20])->
					first();

                if(!is_null($sysquery)){
					if($sysquery->name == 'purchaser'){
						$pursel = "selected";
					}
					if($sysquery->name == 'member'){
						$memsel = "selected";
					}
					if($sysquery->name == 'emp_benefit_user'){
						$ebusel = "selected";
					}
					$sysrole = $sysquery->description;
                }

                $total_smm_army+=(int)$staff->connections;
                
                
                if($staff->member_status == 'not exists' || empty($staff->user_id)){
                    $rol = '';
                }else{  
                    $rol = '<a href="javascript:void(0)" class="member_role1" onclick="showmemberrole('.$staff->user_id.')" rel="'.$staff->user_id.'">Roles</a>';
                }
                return $rol;
            })
            ->addColumn('smm_army', function ($staff) {
                if($staff->connections){
                    $d = $staff->connections;
                }else{
                    $d = 0;
                }
                $aaa = '<a href="javascript:void(0)" class="member_smm smmarmy_exposer" uid="'.$staff->user_id.'">'.$d.'</a>';
                return $aaa;
            })
            ->editColumn('status', function ($staff) {
                return ucfirst($staff->status);
            })
            ->editColumn('email', function ($staff) {
                return $staff->email;
            })
            ->addColumn('checkbox', function ($staff) {                
                return "<input type='checkbox' class='sender' rel='".$staff->email."' />";
            })
            ->addColumn('delected', function ($staff) {                
                return '<a  href="javascript:void(0);" class="text-danger delete_member" rel="'.$staff->email.'"><i class="fa fa-minus-circle fa-2x"></i></a>';
            })
            ->setRowClass(function ($staff) {
                $staffstyle = '';
                if($staff->status != 'active'){
                    $staffstyle = "background-color: #EDEDED;";
                }
                return $staffstyle;
            })
            ->make(true);
    }


    public function pah($userid){
        Log::debug('***** pah('.$userid.') *****');
        

        $pah_user = Member::where('user_id', $userid)->first();
        if(!$pah_user){
            
            $userData = DB::table("users")->where('id', $userid)->first();
            
            DB::table('member')
            ->insert([
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'user_id'=>$userData->id,
                'member_status'=>'tagged',
                'status'=>'active',
                'role'=>'employee',
                'email'=>$userData->email,
                'type'=>'member',
                'company_id' => DB::table('company')->where('owner_user_id',$userid)->pluck('id')
            ]);
        }

        $members = DB::table('member')->
                leftJoin('users', 'users.id', '=', 'member.user_id')->
                leftJoin('nstaff', 'nstaff.member_id', '=', 'member.id')->
                join('company', 'member.company_id', '=', 'company.id')->
                where('company.owner_user_id', $userid)->
                where('member.user_id','=' ,$userid)->
                where('member.type', 'member')->
                select(DB::raw("
					member.*,
					users.first_name as users_first_name,
					users.last_name as users_last_name,
					nstaff.name,
					nstaff.nickname,
					users.id as user_id
				"))->
				groupBy("member.id")->
				orderBy('created_at', 'DESC')->
				first();

        if($members){
            $conn = SMMout::where('user_id', $members->user_id)->
                    pluck('connections');
            $members->connections = $conn;
            
            $staff = $members;

            $name = '<a href="javascript:void(0);" class="text-center" onclick="show_add_staff_modal('.$staff->id.')">';
            if(empty($staff->name) and empty($staff->nickname) and empty($staff->users_first_name)){
                $name .= 'Name';
            }elseif(!empty($staff->users_first_name)){
                $name .= $staff->users_first_name." ".$staff->users_last_name;
            }elseif(!empty($staff->name)){
                $name .= $staff->name;
            }else{
                $name .= $staff->nickname;
            }
            $name .= '</a>';
        
            $staff->name = $name;
            
            $total_smm_army=0;
            
            $sysrole = "";
            $pursel = "";
            $memsel = "";
            $ebusel = "";
            $sysquery = DB::table('roles')->
                    join('role_users','roles.id','=',
                            'role_users.role_id')->
                    where('role_users.user_id',$staff->user_id)->
                    whereIn('roles.id',[15,18,20])->
                    first();

            if(!is_null($sysquery)){
                if($sysquery->name == 'purchaser'){
                        $pursel = "selected";
                }
                if($sysquery->name == 'member'){
                        $memsel = "selected";
                }
                if($sysquery->name == 'emp_benefit_user'){
                        $ebusel = "selected";
                }
                $sysrole = $sysquery->description;
            }

            $total_smm_army+=(int)$staff->connections;
            
            if($staff->member_status == 'not exists' || empty($staff->user_id)){
                $rol = '';
            }else{  
                $rol = '<a href="javascript:void(0)" class="member_role1" onclick="showpahrole('.$staff->user_id.')" rel="'.$staff->user_id.'">Roles</a>';
            }
            $staff->roles =  $rol;

            if($staff->connections){
                $d = $staff->connections;
            }else{
                $d = 0;
            }
            $staff->smm_army = '<a href="javascript:void(0)" class="member_smm smmarmy_exposer" uid="'.$staff->user_id.'">'.$d.'</a>';

            $staff->status =  ucfirst($staff->status);

            $staff->checkbox =  "<input type='checkbox' class='sender' rel='".$staff->email."' />";

            $staff->delete =  '<a  href="javascript:void(0);" class="text-danger delete_member" rel="'.$staff->email.'"><i class="fa fa-minus-circle fa-2x"></i></a>';
        
            return response()->json($staff);
        }else{
            return 0;
        }
    }
}



