<?php

namespace App\Http\Controllers;

use App\Models\HcapSchedule;
use App\SProduct;
use Illuminate\Http\Request;
use DB;
use Log;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\nstaff;
use App\Http\Controllers\Controller;
use App\FairLocation;
use Carbon\Carbon;
use Datatables;
use Carbon\CarbonInterval;


class HumanCapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approveHumanCap() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
            return \App\Classes\AdminApproveHelper::approveUser($inputs);

        }
    }

    public function saveHumanCapRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        $res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
            $res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
            echo $res;
        }
        //echo "Hola";
    }

    public function humancap_remarks($id){
        $remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status, nhumancapid.nhumancap_id, nbuyerid.nbuyer_id from remark inner join humancapremark on humancapremark.remark_id = remark.id left join humancap on humancap.id = humancapremark.humancap_id left join nhumancapid on humancap.user_id = nhumancapid.user_id left join nbuyerid on remark.user_id = nbuyerid.user_id where humancapremark.humancap_id = " . $id . " order by remark.created_at desc"));

        return json_encode($remarks);
    }

    public function approval($id)
    {
        $humancaps = DB::table('humancap')->leftJoin('nhumancapid','humancap.user_id','=','nhumancapid.user_id')
            ->select(DB::raw("humancap.*,
				IFNULL(nhumancapid.nhumancap_id,LPAD(humancap.id,16,'E')) as
					humancap_id"))
            ->where('humancap.id',$id)
            ->orderBY('humancap.created_at', 'desc')->get();
        return view('master.humancap_approval')->with('humancaps',$humancaps);
    }

    public function master()
    {
        $hrole = DB::table('roles')->where('slug','hcu')->first();
        $humancaps = [];
        if(!is_null($hrole)){
            $humancaps = DB::table('merchant')->leftJoin('nsellerid','merchant.user_id','=','nsellerid.user_id')
                ->join('role_users','role_users.user_id','=','merchant.user_id')
                ->where('role_users.role_id',$hrole->id)
                ->select(DB::raw("merchant.*,
				IFNULL(nsellerid.nseller_id,LPAD(merchant.id,16,'E')) as
					humancap_id"))
                ->distinct()
                ->orderBY('merchant.created_at', 'desc')->get();
            foreach($humancaps as $humancap){
                $memberc = 0;
                $company = DB::table('company')->where('owner_user_id',$humancap->user_id)->first();
                if(!is_null($company)){
                    $membersc = DB::table('member')->where('company_id',$company->id)->where('type','member')->count();
                }
                $humancap->staff = $memberc;
            }
        }
        return view('master.humancap')->with('humancaps',$humancaps);
    }

    public function staffList(){
		Log::debug('***** staffList() *****');

        if (!Auth::check()) {
            # code...
            return view("common.generic")
            ->with('message_type','error')
            ->with('message','Please login to view this page.')
            ;
        }
        $user_id= Auth::user()->id;
        $selluser = User::find($user_id);
        $products = SProduct::get_commission_products();

        $staff_li =DB::table('nstaff')->get();
        $staff_arr=array();

        foreach($staff_li as $staff_list=>$value)
        {
            $get_usr = DB::table('users')->
            where('id',$value->member_id)->first();

            if(!is_null($get_usr)>0){
                $staff_id=$get_usr->id;
            }else{
                $staff_id=$value->id;
            }

            $staff_name= $value->name;
            $staff_attendance=DB::table('hcap_attendance')->
            where('staff_user_id',$staff_id)->count();

            $today=date('Y-m-d');
            $today_query=DB::table('hcap_attendance')
                ->where('staff_user_id',$staff_id)
                ->where(DB::raw('date(`checkin`)'),$today.'%')
                ->get();

            $staff_arr[]=[
                'id'=>$staff_id,
                'staff_name'=>$staff_name,
                'staff_attendance'=>$staff_attendance,
                'staff_today'=>(count($today_query)>0)?"Yes":"No"
            ];
        }

        $staffs = DB::select(DB::raw("
                SELECT 
                    u.id as uid,
                    m.id as mid,
                    u.email,m.name as mname,
                    s.name as sname,r.name as rname,
                    concat(u.first_name,' ',u.last_name) as name ,
                    c.id as company_id
                    FROM	users u,
                            roles r,
                            role_users ru,
                            company c,
                            member m 
                            LEFT JOIN nstaff s ON m.id = s.member_id 
                    WHERE 
                    m.user_id = u.id 
                    AND ru.user_id = u.id 
                    AND ru.role_id = r.id 
                    
                    AND (r.slug = 'mbr' OR
						 r.slug = 'mba' OR
						 r.slug = 'hcu' OR
						 r.slug = 'hca' OR
						 r.slug = 'ebu' OR
						 r.slug = 'eba')

                    AND m.type='member'
					AND m.company_id = c.id
					AND m.status = 'active'
					AND c.owner_user_id = $user_id
					GROUP BY	u.id"
        ));
        /*        dd($staffs);*/
        foreach ($staffs as $staff){
            /*DB::table('hcap_productcomm')->where('sales_member_id',$staff->mid)->get();*/
            /*Saleslog commission*/

            $comission =DB::table("opos_saleslog")
                ->join("hcap_productcomm","hcap_productcomm.product_id","=","opos_saleslog.product_id")
                ->where('opos_saleslog.masseur_id',$staff->mid)
                ->where('hcap_productcomm.sales_member_id',$staff->mid)
                //->whereIn('opos_saleslog.status',array('completed','active'))
                ->where('opos_saleslog.status','completed')
                ->whereNull('opos_saleslog.deleted_at')
                ->whereNotNull('opos_saleslog.end')
                ->whereNotNull('opos_saleslog.start')
                ->select('opos_saleslog.commission_amt')
                ->get();
            $over_time = DB::table('hcap_otptrate as rate')->select
            ('rate.id','rate.block','rate.mode','rate.rate_hr','user_rate.created_at','user_rate.user_id',
                'user_rate.otptrate_id')->leftJoin
            ('hcap_usersotptrate as user_rate','user_rate.otptrate_id', '=', 'rate.id')
                ->where(['user_rate.user_id' => $staff->uid, 'rate.mode' => 'ot'])
                ->orderBy('user_rate.id', 'desc')->get();

            $total_ot = 0;
            foreach ($over_time as $over){
                $total_ot = $total_ot +  (floor(($over->block / 30)) * $over->rate_hr) ;

            }
            $part_time = DB::table('hcap_otptrate as rate')->select
            ('rate.id','rate.block','rate.mode','rate.rate_hr','user_rate.created_at','user_rate.user_id',
                'user_rate.otptrate_id')->leftJoin
            ('hcap_usersotptrate as user_rate','user_rate.otptrate_id', '=', 'rate.id')
                ->where(['user_rate.user_id' => $staff->uid, 'rate.mode' => 'pt'])
                ->orderBy('user_rate.id', 'desc')->get();

            $total_pt = 0;
            foreach ($part_time as $part){
                $total_pt = $total_pt +  (floor(($part->block / 30)) * $part->rate_hr) ;

            }

            if ($staff->mid==119) {
                # code...
                /*  dd($comission);*/
            }

            $staff->leave = DB::table('hcap_leave')->where('staff_user_id', $staff->uid)->count();
            $staff->schedule = DB::table('hcap_schedule')->where('staff_user_id', $staff->uid)->count();
            $staff->attendance = DB::table('hcap_attendance')->where('staff_user_id', $staff->uid)->count();
            $staff->over_time = $total_ot;
            $staff->part_time = $total_pt;
            $total = 0;
            foreach($comission as $com){
                $total = $total + $com->commission_amt;
            }
            // dd($total);
            $staff->commission = $total;

            if(!$staff->name){
                $staff->name = $staff->first_name . " ". $staff->last_name;
            }
        }

        $branches = FairLocation::where('user_id', $user_id)->get();

        return view('humancap.stafflist', compact(['selluser','products','branches','staffs','staff_arr']));

    }

    public function staffAttendance($id)
    {

        $user_id= Auth::user()->id;
        $current_date=date('Y-m-d');
        $staff = DB::select(DB::raw("
                SELECT 
                    u.id as uid,
                    m.id as mid,
                    u.email,m.name as mname,
                    s.name as sname,
                    concat(u.first_name,' ',u.last_name) as name ,
                    c.id as company_id
                    FROM	users u,
                            company c,
                            member m 
                            LEFT JOIN nstaff s ON m.id = s.member_id 
                    WHERE 
                    m.user_id = $id        
                    AND m.type='member'
					AND m.company_id = c.id
					AND m.status = 'active'
					AND c.owner_user_id = $user_id
                    AND u.id = $id"

        ));
        $schedule=HcapSchedule::where('staff_user_id',$id)
            ->where('scheduled_day',$current_date)
            ->first();

        $attendance='';
        if($schedule!=null){
            $att=DB::table('hcap_attendance')
                ->where('staff_user_id',$id)
                ->where('checkin','LIKE','CURDATE()%')
                ->first();
            $attendance=$this->attendanceRecord($schedule,$att);

        }


        $selluser = User::find($user_id);
        return view('humancap.staff_attendance_final',
            compact(['selluser','staff','schedule','attendance','id']));
    }

    public function attendanceRecord($s,$attendance)
    {
        if($attendance!=null && !isset($s->leaveType->id)){
            $checkout_time = '';
            $checkout_status = '';
            $overtime = '';
            if ($attendance->checkout != "0000-00-00 00:00:00") {
                $checkout_time = date('H:i:s', strtotime($attendance->checkout));
                $schedule_day_hours=date('H', strtotime($s->shift->end))-date('H', strtotime($s->shift->start));
                $attendance_day_hours=date('H', strtotime($attendance->checkout))-date('H', strtotime($attendance->checkin));

                if (date('H:i:s', strtotime($attendance->checkout)) == date('H:i:s', strtotime($s->shift->end))
                    && $schedule_day_hours ==$attendance_day_hours) {
                    $checkout_status = "Full Day";
                } elseif (date('H:i:s', strtotime($attendance->checkout)) < date('H:i:s', strtotime($s->shift->end))
                    /*|| $schedule_day_hours >$attendance_day_hours*/) {
                    $checkout_status = "Half Day";
                } else if (date('H:i:s', strtotime($attendance->checkout)) > date('H:i:s', strtotime($s->shift->end))
                    && $schedule_day_hours <$attendance_day_hours) {
                    $checkout_status = "Over Time";
                }else if(date('H:i:s', strtotime($attendance->checkout)) > date('H:i:s', strtotime($s->shift->end))
                    && $schedule_day_hours >$attendance_day_hours){
                    $checkout_status = "Half Day";
                }
                $overtime = 0;
                if (date('H:i:s', strtotime($attendance->checkout)) > date('H:i:s', strtotime($s->shift->end))) {
                    $overtime = date('H', strtotime($attendance->checkout)) - date('H',strtotime($s->shift->end));
                }
            }



            return [
                date('dMy', strtotime($attendance->checkin)),
                date('H:i:s', strtotime($attendance->checkin)),
                (date('H:i:s', strtotime($attendance->checkin)) <= date('H:i:s',strtotime($s->shift->start))) ? "Early" : "Late",
                $checkout_time,
                $checkout_status,
                $overtime

            ];
        }else {
            if(isset($s->leaveType->id))
            {
                return [
                    date('d M y', strtotime($s->scheduled_day)),
                    '-',
                    $s->leaveType->description,
                    '-',
                    $s->leaveType->description,
                    0,
                ];
            }else {
                return [
                    date('d M y', strtotime($s->scheduled_day)),
                    '-',
                    'Absent',
                    '-',
                    'Absent',
                    0,
                ];
            }

        }
    }

    public function staffAttendanceRecord(Request $request)
    {

        $full_attendance=[];
        $attendances=[];


        if($request->type=='today'){
            $current_date=date('Y-m-d');

            $s=HcapSchedule::where('staff_user_id',$request->id)
                ->where('scheduled_day',$current_date)
                ->first();


            if($s!=null){

                $attendance=DB::table('hcap_attendance')
                    ->where('staff_user_id',$request->id)
                    ->where(DB::raw('date(checkin)'), '=', $s->scheduled_day)
                    ->first();
                $full_attendance[]=$this->attendanceRecord($s,$attendance);
            }

        }else if($request->type=='weekly'){

            $schedule=HcapSchedule::where('staff_user_id',$request->id)
                ->where(DB::raw('YEARWEEK(`scheduled_day`, 1)'),'=',DB::raw('YEARWEEK(CURDATE(), 1)'))
                ->latest()
                ->get();

            $attendances=[];
            if($schedule!=null){
                foreach($schedule as $s) {

                    $attendance = DB::table('hcap_attendance')
                        ->where('staff_user_id', $request->id)
                        ->where(DB::raw('date(checkin)'), '=', $s->scheduled_day)
                        ->first();

                    $full_attendance[]=$this->attendanceRecord($s,$attendance);
                }
            }
        }else if($request->type=='monthly'){

            $schedule=HcapSchedule::where('staff_user_id',$request->id)
                ->where(DB::raw('MONTH(scheduled_day)'),'=',DB::raw('MONTH(CURRENT_DATE())'))
                ->latest()
                ->get();



            if($schedule!=null){
                foreach($schedule as $s) {

                    $attendance = DB::table('hcap_attendance')
                        ->where('staff_user_id', $request->id)
                        ->where(DB::raw('date(checkin)'), '=', $s->scheduled_day)
                        ->first();

                    $full_attendance[]=$this->attendanceRecord($s,$attendance);
                }
            }

        }else if($request->type=='yearly'){
            $schedule=HcapSchedule::where('staff_user_id',$request->id)
                ->where(DB::raw('YEAR(scheduled_day)'),'=',DB::raw('YEAR(CURRENT_DATE())'))
                ->latest()
                ->get();


            if($schedule!=null){
                foreach($schedule as $s) {

                    $attendance = DB::table('hcap_attendance')
                        ->where('staff_user_id', $request->id)
                        ->where(DB::raw('date(checkin)'), '=', $s->scheduled_day)
                        ->first();

                    $full_attendance[]=$this->attendanceRecord($s,$attendance);
                }
            }

        }else if($request->type=='since'){
            $schedule=HcapSchedule::where('staff_user_id',$request->id)
                ->where(DB::raw('date(scheduled_day)'),'>=',DB::raw('date("'.$request->date.'")'))
                ->latest()
                ->get();


            if($schedule!=null){
                foreach($schedule as $s) {

                    $attendance = DB::table('hcap_attendance')
                        ->where('staff_user_id', $request->id)
                        ->where(DB::raw('date(checkin)'), '=', $s->scheduled_day)
                        ->first();

                    $full_attendance[]=$this->attendanceRecord($s,$attendance);
                }
            }
        }

        return response()->json($full_attendance);
    }

    public function staffCommission($id){
        $user_id= Auth::user()->id;
        $current_date=date('Y-m-d');
        $staff = DB::select(DB::raw("
                SELECT 
                    u.id as uid,
                    m.id as mid,
                    u.email,m.name as mname,
                    s.name as sname,
                    concat(u.first_name,' ',u.last_name) as name ,
                    c.id as company_id
                    FROM	users u,
                            company c,
                            member m 
                            LEFT JOIN nstaff s ON m.id = s.member_id 
                    WHERE 
                    m.user_id =  u.id        
                    AND m.type='member'
					AND m.company_id = c.id
					AND m.status = 'active'
					AND c.owner_user_id = $user_id
                    AND m.id = $id"

        ));
        $user_id= Auth::user()->id;
        $selluser = User::find($user_id);

        // $products = DB::table('hcap_productcomm as hp')
        //              ->select('p.id','p.name','p.thumb_photo','p.retail_price','hp.product_id','hp.commission_amt','op.checkin_tstamp','op.checkout_tstamp')
        //             ->leftJoin('product as p','p.id', '=', 'hp.product_id')
        //             ->leftJoin('opos_masseurtxn as op','op.masseur_member_id', '=','hp.sales_member_id')
        //             ->where('hp.sales_member_id',$id)
        //             ->orderBy('hp.id', 'desc')
        //             ->get();

        $products =DB::table("opos_saleslog")
                ->join("hcap_productcomm",function($join) use ($id){
                    $join->on("hcap_productcomm.product_id","=","opos_saleslog.product_id");
                    $join->where("hcap_productcomm.sales_member_id","=",$id);
                })
                ->join('opos_receiptproduct','opos_receiptproduct.id','=','opos_saleslog.receiptproduct_id')
                // ->join('opos_masseurtxn',function($join) use ($id){
                //     $join->on('opos_masseurtxn.receipt_id','=','opos_receiptproduct.receipt_id');
                //     $join->where('opos_masseurtxn.masseur_member_id','=',$id);
                // })
                ->leftJoin('product as p','p.id', '=', 'hcap_productcomm.product_id')
                ->where('opos_saleslog.masseur_id',$id)
                // ->whereIn('opos_saleslog.status',array('completed','active'))
                ->where('opos_saleslog.status','completed')
                ->whereNull('opos_saleslog.deleted_at')
                ->whereNull('hcap_productcomm.deleted_at')
                ->whereNotNull('opos_saleslog.end')
                ->whereNotNull('opos_saleslog.start')
                ->select('p.id','p.name','p.thumb_photo','p.retail_price','hcap_productcomm.id as hpid','opos_saleslog.commission_amt','opos_saleslog.start','opos_saleslog.end')
                ->orderBy('hcap_productcomm.id', 'desc')
                ->get();
                // echo '<pre>'; print_r($products); die();
        return view('humancap.staff_commission',compact(['products','staff']));
    }



    public function staffSchedule($id){
        $user_id = $id;
        $user = DB::table('users')->select('first_name','last_name','id')->where('id', $id)->first();

        return view('humancap.schedule',compact(['user_id','user']));
    }
    public function staffScheduleTime(Request $request, $id){
        $schedules = "";
        $user_id = $id;


        $schedules = DB::table('hcap_schedule as schedule')->select
        ('schedule.scheduled_day','shift.start','shift.end','schedule.shift_id','schedule.id')->leftJoin
        ('hcap_leavetype as l','l.id', '=', 'schedule.leavetype_id')->leftJoin
        ('hcap_shift as shift','shift.id', '=', 'schedule.shift_id')
            ->where('schedule.staff_user_id',$user_id)
            ->orderBy('schedule.id', 'desc')
        ;

        if($request->id == 1) {
            $today = Carbon::now();
            $today = $today->toDateString();

            $schedules = DB::table('hcap_schedule as schedule')->select
            ('schedule.scheduled_day','shift.start','shift.end','schedule.shift_id','schedule.id')->leftJoin
            ('hcap_leavetype as l','l.id', '=', 'schedule.leavetype_id')->leftJoin
            ('hcap_shift as shift','shift.id', '=', 'schedule.shift_id')->where
            (
                ['schedule.staff_user_id' => $user_id,
                    'schedule.scheduled_day' => $today]
            );
        }
        if($request->id == 2) {
            $today = Carbon::now();
            $today = $today->toDateString();
            $week = Carbon::now()->addWeek(1)->toDateString();

            $schedules = DB::table('hcap_schedule as schedule')->select
            ('schedule.scheduled_day','shift.start','shift.end','schedule.shift_id','schedule.id')->leftJoin
            ('hcap_leavetype as l','l.id', '=', 'schedule.leavetype_id')->leftJoin
            ('hcap_shift as shift','shift.id', '=', 'schedule.shift_id')->where
            ('schedule.staff_user_id',$user_id)->whereBetween
            ('schedule.scheduled_day', [$today,$week])
                ->orderBy('schedule.id', 'desc');
        }
        if($request->id == 3) {
            $today = Carbon::now();
            $today = $today->toDateString();
            $month = Carbon::now()->addMonth(1)->toDateString();

            $schedules = DB::table('hcap_schedule as schedule')->select
            ('schedule.scheduled_day','shift.start','shift.end','schedule.shift_id','schedule.id')->leftJoin
            ('hcap_leavetype as l','l.id', '=', 'schedule.leavetype_id')->leftJoin
            ('hcap_shift as shift','shift.id', '=', 'schedule.shift_id')->where
            ('schedule.staff_user_id',$user_id)->whereBetween
            ('schedule.scheduled_day', [$today,$month])
                ->orderBy('schedule.id', 'desc');
        }
        if($request->id == 4) {
            $today = Carbon::now();
            $today = $today->toDateString();
            $year = Carbon::now()->addYear(1)->toDateString();

            $schedules = DB::table('hcap_schedule as schedule')->select
            ('schedule.scheduled_day','shift.start','shift.end','schedule.shift_id','schedule.id')->leftJoin
            ('hcap_leavetype as l','l.id', '=', 'schedule.leavetype_id')->leftJoin
            ('hcap_shift as shift','shift.id', '=', 'schedule.shift_id')->where
            ('schedule.staff_user_id',$user_id)->whereBetween
            ('schedule.scheduled_day', [$today,$year])
                ->orderBy('schedule.id', 'desc');
        }

        return Datatables::of($schedules)->addColumn('working',

            function ($row) use($schedules)
            {
                //dd($row);
                if($row->shift_id == 3){
                    $html = '<p>Non- Working </p>';
                }else{
                    $html="";
                    $leave = DB::table('hcap_leavetype')->get();
                    $html .='<select class="leave_type" id="leave_app'.$row->id.'" onchange="woosh('.$row->id.')">';
                    foreach ($leave as $l){
                        $html .='<option  value='.$l->id .'>'.$l->description .'</option>';
                    }
                    $html .='</select>';
                }


                return $html;

            })
            ->removeColumn('shift_id')
            ->removeColumn('id')
            ->make();
    }


    public function staffLeave($id){
        $user = DB::table('users')->
        select('first_name','last_name','id')->
        where('id', $id)->first();

        $leaves = DB::table('hcap_leave as l')
//            ->select('l.staff_user_id','l.approver_user_id','l.approval_dt','l.status','l.remarks','l.created_at','u.first_name',
//            'u.last_name')
            //->leftJoin('users as u','u.id', '=', $id)
            ->where('staff_user_id', $id)->
            orderBy('id', 'desc')->get();

        return view('humancap.leave',compact(['leaves', 'user']));
    }

    public function staffLeaveStore(Request $request){
        $leavetype_id = $request['leave_type'];
        $user_id = $request['user_id'];
        $approval_dt = "0000-00-00";
        $remarks = $request['type'];
        $today = Carbon::now();
        $created_at = $today;
        DB::table('hcap_leave')->
        insert(['leavetype_id'=> $leavetype_id,
            'staff_user_id' => $user_id,
            'approval_dt' => $approval_dt,
            'remarks' => $remarks,'created_at' => $today]);

        return view('humancap.schedule',compact(['user_id']));
    }

    public function payslip(){
        return view('humancap.payslipdf_attendace');
    }

    public function summary(){
        return view('humancap.summary');
    }
    public function staffOvertime($id){
        $overtime = DB::table('hcap_otptrate as rate')->select
        ('rate.id','user.first_name','user.last_name','rate.block','rate.mode','rate.rate_hr','user_rate.created_at','user_rate.user_id',
            'user_rate.otptrate_id')->leftJoin
        ('hcap_usersotptrate as user_rate','user_rate.otptrate_id', '=', 'rate.id')
            ->leftJoin('users as user','user.id', '=','user_rate.user_id')
            ->where(['user_rate.user_id' => $id, 'rate.mode' => 'ot'])
            ->orderBy('user_rate.id', 'desc')->get()
        ;
        foreach ($overtime as $over){
            $over->block = floor(($over->block / 30)) * $over->rate_hr ;
        }
        $user = DB::table('users')->select('first_name','last_name','id')->where('id', $id)->first();
        $attendance = DB::table('hcap_attendance')->select('checkin','checkout','id')->where('staff_user_id', $id)->first();
        return view('humancap.staff_over_time',compact(['overtime','user','attendance']));
    }

    public function parttimer($id){
        $partime = DB::table('hcap_otptrate as rate')->select
        ('rate.id','user.first_name','user.last_name','rate.block','rate.mode','rate.rate_hr','user_rate.created_at','user_rate.user_id',
            'user_rate.otptrate_id')->leftJoin
        ('hcap_usersotptrate as user_rate','user_rate.otptrate_id', '=', 'rate.id')
            ->leftJoin('users as user','user.id', '=','user_rate.user_id')
            ->where(['user_rate.user_id' => $id, 'rate.mode' => 'pt'])
            ->orderBy('user_rate.id', 'desc')->get()
        ;
        foreach ($partime as $part) {
            $part->block = floor(($part->block / 30)) * $part->rate_hr;

        }
        $user = DB::table('users')->select('first_name','last_name','id')->where('id', $id)->first();
        $attendance = DB::table('hcap_attendance')->select('checkin','checkout','id')->where('staff_user_id', $id)->first();
        return view('humancap.parttimer',compact(['partime','user','attendance']));
    }

    public function staff_name($id,$mode="web"){
        $user_id= Auth::user()->id;
        $selluser = User::find($user_id);
        $member_id = $id;
        $products = SProduct::get_commission_products_id($id);
        //dd($products);
        $pt = "'pt'";
        $ot = "'ot'";
        $pt_rate =  DB::select(DB::raw(
            "select rate.id,rate.rate_hr,rate.block,rate.mode,hp.user_id,hp.otptrate_id ".
            "from hcap_usersotptrate as hp ".
            "left join hcap_otptrate as rate ".
            "on rate.id =  hp.otptrate_id ".
            "and rate.mode = ".$pt." ".
            "and hp.user_id = ".$id." ".
            "ORDER BY rate.id DESC LIMIT 1"
        ));

        $pt_rate = $this->single($pt_rate);
        ;

        $ot_rate =  DB::select(DB::raw(
            "select rate.id,rate.rate_hr,rate.block,rate.mode,hp.user_id,hp.otptrate_id ".
            "from hcap_usersotptrate as hp ".
            "left join hcap_otptrate as rate ".
            "on rate.id =  hp.otptrate_id ".
            "and rate.mode = ".$ot." ".
            "and hp.user_id = ".$id." ".
            "ORDER BY rate.id DESC LIMIT 1"
        ));


        $ot_rate = $this->single($ot_rate);

        $commproducts = DB::table('hcap_productcomm')
                            ->join('product','product.id','=','hcap_productcomm.product_id')
                            ->select('product.id as product_id','product.name','product.thumb_photo','hcap_productcomm.commission_amt','hcap_productcomm.sales_member_id')
                            ->where('hcap_productcomm.sales_member_id',$id)
                            ->whereNull('hcap_productcomm.deleted_at')
                            ->get();

        $commbranches = DB::table('hcap_branchcomm')
                            ->leftjoin('fairlocation','fairlocation.id','=','hcap_branchcomm.location_id')
                            ->select('hcap_branchcomm.*','fairlocation.location')
                            ->where('hcap_branchcomm.user_id',$id)
                            ->whereNull('hcap_branchcomm.deleted_at')
                            ->orderby('hcap_branchcomm.location_id')
                            ->get();
// echo '<pre>'; print_r($commbranches); die();
        return view('humancap.staff_name',
            compact(['member_id', 'products','pt_rate','ot_rate','commproducts','commbranches','mode']));
    }

    public function single($arrs) {
        $ret = "";
        foreach($arrs as $arr){
            $ret = $arr;
        }

        return $ret;

    }

    // public function store_prod_comm(Request $request){
    //     //Get both commision and id
    //     $member_id = $request['member_id'];

    //     $commission = $request['commission'];
    //     $prod_id = $request['product_id'];
    //     $prod_commission = DB::table('hcap_productcomm')->
    //     where(['sales_member_id' => $member_id,
    //         'product_id' => $prod_id])->first();

    //     if($prod_commission){
    //         DB::table('hcap_productcomm')->where(
    //             ['sales_member_id' => $member_id,
    //                 'product_id' => $prod_id])->
    //         update(['commission_amt' => $commission]);

    //     }else{
    //         DB::table('hcap_productcomm')->
    //         insert(['product_id'=> $prod_id,
    //             'commission_amt' => $commission,
    //             'sales_member_id' => $member_id]);
    //     }
    // }

     public function store_prod_comm(Request $request){
        //Get both commision and id
        $alldata = $request->alldata;

         if(count($alldata) > 0){
            foreach($alldata as $data)
            {
                $member_id = $data['member_id'];
                $commission =$data['commission'];
                $prod_id = $data['product_id'];
                //dd($member_id);
                $prod_commission = DB::table('hcap_productcomm')
                                            ->where([
                                                'sales_member_id' => $member_id,
                                                'product_id' => $prod_id
                                            ])
                                            ->whereNull('deleted_at')
                                            ->first();
                                    
                if($prod_commission){
                            DB::table('hcap_productcomm')
                            ->where([
                                    'sales_member_id' => $member_id,
                                    'product_id' => $prod_id
                                ])
                            ->whereNull('deleted_at')
                            ->update(['commission_amt' => $commission * 100,'updated_at' => Carbon::now()]);

                }else{
                            DB::table('hcap_productcomm')->
                            insert([
                                'product_id'=> $prod_id,
                                'commission_amt' => $commission * 100,
                                'sales_member_id' => $member_id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
            }
        }      
       
    }
    public function delete_prod_comm(Request $request)
    {
        $delete = DB::table('hcap_productcomm')
                        ->where('product_id',$request->product_id)
                        ->where('sales_member_id',$request->sales_member_id)
                        ->update(['deleted_at' => Carbon::now()]);
    }

    public function delete_branch_comm(Request $request)
    {
        $delete = DB::table('hcap_branchcomm')
                        ->where([
                            'location_id' => $request->location_id,
                            'user_id' => $request->user_id
                        ])
                        ->update(['deleted_at' => Carbon::now()]);
    }
    // public function store_percent_comm(Request $request){
    //     //dd("hit");
    //     $user_id= Auth::user()->id;
    //     $commission = $request['commission_pct'];
    //     $location_id = $request['location_id'];
    //     $comm_text = $request['commtext'];

    //     DB::table('locationusers')->insert(['commtext'=> $comm_text,'location_id' => $location_id,
    //         'commission_pct' => $commission,'user_id' => $user_id]);
    // }
     public function store_percent_comm(Request $request){
        // $user_id= Auth::user()->id;
        $user_id = $request->member_id;
        $alldata = $request->data;
        if(count($alldata) > 0){
            foreach($alldata as $data)
            {
                $commission = $data['commission_pct'];
                $location_id = $data['location_id'];
                $comm_text = $data['commtext'];

                $branch_commission = DB::table('hcap_branchcomm')
                                    ->where([
                                        'location_id' => $location_id,
                                        'user_id' => $user_id
                                    ])
                                    ->whereNull('deleted_at')
                                    ->first();

                if($branch_commission)
                {
                    DB::table('hcap_branchcomm')
                    ->where([
                            'location_id' => $location_id,
                            'user_id' => $user_id
                        ])
                    ->whereNull('deleted_at')
                    ->update([
                        'commtext'=> $comm_text,
                        'location_id' => $location_id,
                        'commission_pct' => $commission,
                        'user_id' => $user_id,
                        'updated_at' => Carbon::now()
                    ]);
                }
                else
                {
                    DB::table('hcap_branchcomm')
                        ->insert([
                            'commtext'=> $comm_text,
                            'location_id' => $location_id,
                            'commission_pct' => $commission,
                            'user_id' => $user_id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                }
                
            }
        }
    }
    public function store_part_time(Request $request){
        $user_id= Auth::user()->id;
        $ptrate_hr = $request['rate_hr'];
        $ptblock = $request['block'];
        $mode = 'pt';
        $rt_id = DB::table('hcap_otptrate')->insertGetId(array('rate_hr'=> $ptrate_hr,
            'block' => $ptblock,'mode' => $mode,'created_at' => Carbon::now()));

        DB::table('hcap_usersotptrate')->insert(['user_id' => $request->member_id, 'otptrate_id' => $rt_id,'created_at' => Carbon::now()]);

    }
    public function store_over_time(Request $request){

        $user_id= Auth::user()->id;
        $otrate_hr = $request['rate_hr'];
        $otblock = $request['block'];
        $mode = 'ot';
        $rt_id = DB::table('hcap_otptrate')->insertGetId(array('rate_hr'=> $otrate_hr,
            'block' => $otblock,'mode' => $mode, 'created_at' => Carbon::now()));
        //dd($rt_id);
        DB::table('hcap_usersotptrate')->insert(['user_id' => $request->member_id, 'otptrate_id' => $rt_id,'created_at' => Carbon::now()]);
    }


    public function manager_schedule(){
        $user_id= Auth::user()->id;
        $selluser = User::find($user_id);
        $branches = FairLocation::where('user_id', $user_id)->get();

        /** For the Calendar and time displays */
        $month = Carbon::now()->firstOfMonth()->subDays(1);
        $year = Carbon::now()->format('Y');
        $num = Carbon::now()->daysInMonth;
        $start = new Carbon('Last Sunday of December'. ($year - 1));
        $start_of_year = new Carbon('Last Sunday of December'. ($year - 1));
        $end_of_year = new Carbon('Last Sunday of December'. $year);
        $start_of_year =  $start_of_year->format('d-M-y');
        $end_of_year = $end_of_year->format('d-M-y');
        for ($i = 0; $i <= 45; $i++){
            $weeks[] = $start->addDays(6)->format('d-M-y');
            $weeks[] = $start->addDays(1)->format('d-M-y');
        }
        for ($i = 0; $i <= $num; $i++) {
            $days[] = $month->addDays(1)->format('Y-m-d');
            $works[] = DB::table('hcap_mgrscheduler')->select('working')->where('day', $days[$i])->first();
            $fullforce[] = DB::table('hcap_mgrscheduler')->select('fullforce')->where('day', $days[$i])->first();
            $status[] = DB::table('hcap_mgrscheduler')->select('status')->where('day', $days[$i])->first();
        }
       // dd($works);
        $m = Carbon::now()->month;
        /** End of variables for the Calendar and time displays */

        $shifts = DB::table('hcap_shift')->get();
        return view('humancap.manager_schedule',
            compact(['selluser','branches','days','m','weeks','start_of_year','end_of_year','shifts',
                'works','fullforce','status']));
    }

    public function manager_schedule_month($id){
        $user_id= Auth::user()->id;
        $selluser = User::find($user_id);
        $branches = FairLocation::where('user_id', $user_id)->get();
        /** For the Calendar and time displays */
        $year = Carbon::now()->format('Y');
        $month = Carbon::create($year, $id, 1)->firstOfMonth()->subDays(1);
        $start = new Carbon('Last Sunday of December'. ($year - 1));
        $start_of_year = new Carbon('Last Sunday of December'. ($year - 1));
        $end_of_year = new Carbon('Last Sunday of December'. $year);
        $start_of_year =  $start_of_year->format('d-M-y');
        $end_of_year = $end_of_year->format('d-M-y');
        for ($i = 0; $i <= 45; $i++){
            $weeks[] = $start->addDays(6)->format('y-m-d');
            $weeks[] = $start->addDays(1)->format('y-m-d');
        }
        $m = $id;
        $num = $month->daysInMonth;
        for ($i = 0; $i <= $num; $i++) {
            $days[] = $month->addDays(1)->format('Y-m-d');
            $works[] = DB::table('hcap_mgrscheduler')->select('working')->where('day', $days[$i])->first();
            $fullforce[] = DB::table('hcap_mgrscheduler')->select('fullforce')->where('day', $days[$i])->first();
            $status[] = DB::table('hcap_mgrscheduler')->select('status')->where('day', $days[$i])->first();
        }


        /** End of variables for the Calendar and time displays */


        $shifts = DB::table('hcap_shift')->get();
        return view('humancap.manager_schedule',
            compact(['selluser','branches','days','m','weeks','start_of_year','end_of_year','shifts',
                'works','fullforce','status']));
    }
    public function manager_update_shift(Request $request){
        $id = $request['id'];
        $start = $request['start'];
        $stop = $request['stop'];

        $row = DB::table('hcap_shift')->where('id',$id)->update(['start' => $start, 'end' => $stop]);

    }
    public function manager_store_shift(Request $request){
        $id = $request['id'];
        $start = $request['start'];
        $stop = $request['stop'];

        DB::table('hcap_shift')->insert(['start' => $start, 'end' => $stop]);

    }

    public function manager_daily_schedule(Request $request)
    {
        $day = $request['date'];
        $date = strtotime($day);
        $date = date('Y-m-d', $date);
        $user_id = $request['user_id'];
        $shift_id = $request['shift_id'];

        if($shift_id == "F"){
            $shift_id =   1;
        }else{
            $shift_id = $shift_id + 1 ;
        }

        //check if the date already has a schedule in the mgr schedule
        $schedule = DB::table('hcap_schedule')->where(['scheduled_day' => $date, 'staff_user_id' => $user_id])->first();
        //dd($schedule);
        if ($schedule) {
            if ($shift_id != 1) {
                if ($schedule->shift_id != 1) {
                    DB::table('hcap_schedule')->insert(['scheduled_day' => $date, 'staff_user_id' => $user_id, 'shift_id' => $shift_id]);
                } else {
                    DB::table('hcap_schedule')->where(['scheduled_day' => $date, 'staff_user_id' => $user_id])->delete();
                    DB::table('hcap_schedule')->insert(['scheduled_day' => $date, 'staff_user_id' => $user_id, 'shift_id' => $shift_id]);
                }
            }else{
                DB::table('hcap_schedule')->where(['scheduled_day' => $date, 'staff_user_id' => $user_id])->delete();
                DB::table('hcap_schedule')->insert(['scheduled_day' => $date, 'staff_user_id' => $user_id, 'shift_id' => $shift_id]);
            }
        }else{
            DB::table('hcap_schedule')->insert(['scheduled_day' => $date, 'staff_user_id' => $user_id, 'shift_id' => $shift_id]);
        }



    }

    public function weekly_routine(){
        $en = Carbon::now();
        $start = $en->startOfWeek()->subDay(2);
        for ($i = 0; $i <= 6; $i++) {
            $days[] = $start->addDays(1)->format('Y-m-d');
            $works[] = DB::table('hcap_mgrscheduler')->select('working')->where('day', $days[$i])->first();
        }

        return view('humancap.weekly_routine',compact(['days','works']));
    }

    public function manager_schedule_store(Request $request){
        $day = $request['date'];
        $date = strtotime($day);
        $date = date('Y-m-d', $date);
        $month = strtotime($date);
        $month = date('m', $month);
        $month = str_replace("0","",$month);
        $working = $request['working'];
        $fullforce = $request['fullforce'];
        if($fullforce > $working){
            $status = "exceed";
        }elseif ($fullforce < $working){
            $status = "insufficient";
        }else{
            $status = "optimum";
        }
        $schedule = DB::table('hcap_mgrscheduler')->where('day', $day)->first();

        if($schedule){
            DB::table('hcap_mgrscheduler')->where('day', $day)->update(['month' => ''.$month.'','working' => $working, 'fullforce' => $fullforce, 'status' => $status]);
        }else{
            DB::table('hcap_mgrscheduler')->insert(['day' => $date,'month' => ''.$month.'','working' => $working, 'fullforce' => $fullforce, 'status' => $status]);
        }

    }
    public function manager_working(){

        $user_id= Auth::user()->id;
        $staffs = DB::select(DB::raw("
                SELECT 
                    u.id as uid,
                    m.id as mid,
                    u.email,m.name as mname,
                    s.name as sname,r.name as rname,
                    concat(u.first_name,' ',u.last_name) as name ,
                    c.id as company_id
                    FROM	users u,
                            roles r,
                            role_users ru,
                            company c,
                            member m 
                            LEFT JOIN nstaff s ON m.id = s.member_id 
                    WHERE 
                    m.user_id = u.id 
                    AND ru.user_id = u.id 
                    AND ru.role_id = r.id 
                    
                    AND (r.slug = 'mbr' OR
						 r.slug = 'mba' OR
						 r.slug = 'hcu' OR
						 r.slug = 'hca' OR
						 r.slug = 'ebu' OR
						 r.slug = 'eba')

                    AND m.type='member'
					AND m.company_id = c.id
					AND m.status = 'active'
					AND c.owner_user_id = $user_id
					GROUP BY	u.id"
        ));

        return view('humancap.manager_working',compact(['staffs']));
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
