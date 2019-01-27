<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Employee;
use App\Models\PaymentMethods;
use App\Models\Positions;
use App\Models\User;
use Input;
use Illuminate\Http\Request;
use DB;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function approval($id)
    {
        //
        $employees = Employee::where('id',$id)->orderBy('created_at','DESC')->get();
        $positions = Positions::all();
        $paymethod = PaymentMethods::all();
        $users     = DB::select(
            'select us.*  '.
            'from users us, buyer b  '.
            'where  '.
            '    us.id IN ( '.
            '        select user_id  from role_users as ru where  '.
            '        ru.role_id IN ( '.
            '            select id from roles as rs where rs.slug not like "psh" '.
            '        ) '.
            '    ) '.
			' and  '.
			' us.id = b.user_id and b.emp_appt = true  '.
            ' and  '.
            '    us.id NOT IN (select id from employee) '

        );
        // return $users;
        $banks     = Bank::all();
		$user_id= Auth::id();
		$admin_approver = DB::table("role_users")->join("roles","roles.id","=","role_users.role_id")->where("role_users.user_id",$user_id)->where("roles.name","admin_approver")->get();
		$isapprover = 0;
		if(count($admin_approver)>0){
			$isapprover = 1;
		}
		$idemployee = DB::table('employee')->where('id',$id)->first();
        return view("employee.approval", [
            'isapprover' => $isapprover,
            'employees' => $employees,
            'idemployee' => $idemployee,
            'positions' => $positions,
            'paymethods' => $paymethod,
            'users'      => $users,
            'banks'      => $banks
        ]);		
	} 
	 
    public function index()
    {
        //
        $employees = Employee::orderBy('created_at','DESC')->get();
        $positions = Positions::all();
        $paymethod = PaymentMethods::all();
        $users     = DB::select(
            'select us.*  '.
            'from users us, buyer b  '.
            'where  '.
            '    us.id IN ( '.
            '        select user_id  from role_users as ru where  '.
            '        ru.role_id IN ( '.
            '            select id from roles as rs where rs.slug not like "psh" '.
            '        ) '.
            '    ) '.
			' and  '.
			' us.id = b.user_id and b.emp_appt = true  '.
            ' and  '.
            '    us.id NOT IN (select id from employee) '

        );
        // return $users;
        $banks     = Bank::all();
		$user_id= Auth::id();
		$admin_approver = DB::table("role_users")->join("roles","roles.id","=","role_users.role_id")->where("role_users.user_id",$user_id)->where("roles.name","admin_approver")->get();
		$isapprover = 0;
		if(count($admin_approver)>0){
			$isapprover = 1;
		}
        return view("employee.index", [
            'isapprover' => $isapprover,
            'employees' => $employees,
            'positions' => $positions,
            'paymethods' => $paymethod,
            'users'      => $users,
            'banks'      => $banks
        ]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();

        $bankaccount = new BankAccount();
        $bankaccount->bank_id = $request->get('bank_id');
        $bankaccount->account_name1 = $request->get('account_name');
        $bankaccount->account_number1 = $request->get('account_no');
        $bankaccount->iban = $request->get('iban');
        $bankaccount->swift = $request->get('swift');
        $bankaccount->save();

        $emp = new Employee();
        $emp->user_id = $request->get('user_id');
        $emp->position_id = $request->get('position');
        $emp->visa_no = $request->get('visa_no');
        $emp->socso_no = $request->get('socso_no');
        $emp->epf_no = $request->get('epf_no');
        $emp->pcb = $request->get('pcb');
        $emp->monthly_salary = $request->get('monthly_salary');
        $emp->recruiter_id = $request->get('source_user_id');
		$emp->save();
        //save bank account information
        $bankaccount->employees()->save($emp);
		/*** PCB ***/
		$disabled = $request->get('disabled');
		$marital_status = $request->get('marital_status');
		$child = $request->get('child');
		$spouse = $request->get('spouse');
		if($spouse == ""){
			$spouse == 0;
		}
		$spouse_disabled = $request->get('spouse_disabled');
		if($spouse_disabled == ""){
			$spouse_disabled == 0;
		}		
		$spouse_no_income = $request->get('spouse_no_income');
		if($spouse_no_income == ""){
			$spouse_no_income == 0;
		}		
		$child_underage = $request->get('child_underage');
		if($child_underage == ""){
			$child_underage == 0;
		}		
		$child_above = $request->get('child_above');
		if($child_above == ""){
			$child_above == 0;
		}		
		$child_adopted = $request->get('child_adopted');
		if($child_adopted == ""){
			$child_adopted == 0;
		}		
		
		DB::table('pcb')->insert(
			['disabled' => $disabled, 'employee_id' => $emp->id,
			'status' => $marital_status, 'spouse' => $spouse, 'spouse_no_income' => $spouse_no_income, 'spouse_disabled' => $spouse_disabled
			, 'child' => $child, 'child' => $child_underage, 'child_aboveage' => $child_above, 'child_adopted' => $child_adopted]
		);

        return json_encode($emp);
    }

    public function edit_employee_pcb(Request $request)
    {
		$id = $request->get('user_id');
		$disabled = $request->get('disabled');
		$marital_status = $request->get('marital_status');
		$child = $request->get('child');
		$spouse = $request->get('spouse');
		if($spouse == ""){
			$spouse == 0;
		}
		$spouse_disabled = $request->get('spouse_disabled');
		if($spouse_disabled == ""){
			$spouse_disabled == 0;
		}		
		$spouse_no_income = $request->get('spouse_no_income');
		if($spouse_no_income == ""){
			$spouse_no_income == 0;
		}		
		$child_underage = $request->get('child_underage');
		if($child_underage == ""){
			$child_underage == 0;
		}		
		$child_above = $request->get('child_above');
		if($child_above == ""){
			$child_above == 0;
		}		
		$child_adopted = $request->get('child_adopted');
		if($child_adopted == ""){
			$child_adopted == 0;
		}		
		if($disabled == "true"){
			$disabled = 1;
		} else {
			$disabled = 0;
		}
		$pcbe = DB::table('pcb')->where('employee_id',$id)->first();
		if(!is_null($pcbe)){
			DB::table('pcb')->where('employee_id',$id)->update(
				['disabled' => $disabled,
				'status' => $marital_status, 'spouse' => $spouse, 'spouse_no_income' => $spouse_no_income, 'spouse_disabled' => $spouse_disabled
				, 'child' => $child, 'child_underage' => $child_underage, 'child_aboveage' => $child_above, 'child_adopted' => $child_adopted]
			);		
		} else {
			DB::table('pcb')->insert(
				['disabled' => $disabled, 'employee_id' => $id,
				'status' => $marital_status, 'spouse' => $spouse, 'spouse_no_income' => $spouse_no_income, 'spouse_disabled' => $spouse_disabled
				, 'child' => $child, 'child_underage' => $child_underage, 'child_aboveage' => $child_above, 'child_adopted' => $child_adopted]
			);			
		}
		
		return $disabled;
	}	
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showattachment($id)
    {
        echo "this is of ".$id." someone.";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data[] = Employee::find($id);
        $data[] = Employee::find($id)->bankaccount;
        return json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $bankaccount = Employee::find($id)->bankaccount->first();
        $bankaccount->bank_id = $request->get('bank_id');
        $bankaccount->account_name1 = $request->get('account_name');
        $bankaccount->account_number1 = $request->get('account_no');
        $bankaccount->iban = $request->get('iban');
        $bankaccount->swift = $request->get('swift');
        $bankaccount->save();

        $emp = Employee::find($id);
        $emp->user_id = $request->get('user_id');
        $emp->position_id = $request->get('position');
        $emp->visa_no = $request->get('visa_no');
        $emp->epf_no = $request->get('epf_no');
        $emp->pcb = $request->get('pcb');
        $emp->monthly_salary = $request->get('monthly_salary');
        $emp->recruiter_id = $request->get('source_user_id');
        //save bank account information
        $bankaccount->employees()->save($emp);

        return json_encode($emp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $emp = Employee::find($id);
        $emp->delete();
        return json_encode(["message"=>true]);
    }

	public function employee_position($id, $pos){
		DB::table('employee')->where('user_id',$id)->update(["position_id" => $pos]);
		echo "OK";
	}
	
	public function employee_roles($id){
		$employee = DB::table('employee')
        ->where('user_id',$id)
        ->first();

		$position = DB::table('position')
        ->where('id',$employee->position_id)
        ->first();

        if(isset($position)){
    		$returnarr[0] = $position->description;
        }else{
            $returnarr[0] = "";
        }
		
        if(isset($position)){
    		$returnarr['position_id'] = $position->id;
        }else{
            $returnarr['position_id'] = 0;
        }		
		
		$positions = DB::table('position')
		->get();
		$returnarr['positions'] = $positions;

		$salestaff = DB::table('sales_staff')
		->where('user_id',$id)
		->get();
		$i = 1;
		foreach($salestaff as $staff){
			$type = $staff->type;
			if($type=="smm"){
				$returnarr[$i] = "SMM";
			} else if($type=="mct"){
				$returnarr[$i] = "Merchant Consultant";
			} else if($type=="mcp"){
				$returnarr[$i] = "Merchant Professional";
			} else if($type=="psh"){
				$returnarr[$i] = "Pusher";
			} else if($type=="str"){
				$returnarr[$i] = "Station Recruiter";
			}
			$i++;
		}
		return json_encode($returnarr);
	}


	public function employee_payment_save(Request $request, $id){
		$emp = Employee::find($id);
		$emp->monthly_salary = $request->get('salary')*100;
		$emp->save();
		$bank_account_id = $request->get('bank_account_id');
		if($bank_account_id == 0){
			$bankaccount = new BankAccount();
			$bankaccount->bank_id = $request->get('bank');
			$bankaccount->account_name1 = $request->get('account_name');
			$bankaccount->account_number1 = $request->get('account_number');
			$bankaccount->iban = $request->get('iban');
			$bankaccount->swift = $request->get('swift');
			$bankaccount->save();		
			$bankaccount->employees()->save($emp);			
		} else {
			$bankaccount = Employee::find($id)->bankaccount->first();
			$bankaccount->bank_id = $request->get('bank');
			$bankaccount->account_name1 = $request->get('account_name');
			$bankaccount->account_number1 = $request->get('account_number');
			$bankaccount->iban = $request->get('iban');
			$bankaccount->swift = $request->get('swift');
			$bankaccount->save();		
			$bankaccount->employees()->save($emp);
		}
	}
		
	public function employee_payment($id){
		$employee = DB::table('employee')
        ->where('id',$id)
        ->first();

		$bankaccount = DB::table('bankaccount')
        ->where('id',$employee->bankaccount_id)
        ->first();
		$returnarr[6] = number_format($employee->monthly_salary/100,2);
		$returnarr[8] = 0;
		$returnarr[0] = "";
		$returnarr[1] = "";
		$returnarr[2] = "";
		$returnarr[3] = "";
		$returnarr[4] = "";
		$returnarr[5] = "";
		

		if(!is_null($bankaccount)){
			$returnarr[0] = $bankaccount->account_name1;
			$returnarr[1] = $bankaccount->account_number1;
			$returnarr[4] = $bankaccount->iban;
			$returnarr[5] = $bankaccount->swift;
			$bank = DB::table('bank')
			->where('id',$bankaccount->bank_id)
			->first();
			if(!is_null($bank)){
				$returnarr[2] = $bank->name;
				$returnarr[3] = $bank->code;
			}
			$returnarr[8] = $bankaccount->id;
		}

		$returnarr[7] = DB::table('bank')
		->get();
		return json_encode($returnarr);
	}

	public function employee_pcb($id){
		$employee = DB::table('pcb')
        ->where('employee_id',$id)
        ->first();


		return json_encode($employee);
	}		
	
        /**
     * Approve merchant.
     *
     * @return \Illuminate\Http\Response
     */
     public function approveEmployee() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
         return \App\Classes\AdminApproveHelper::approveUser($inputs);

      }
    }

    //function for saving remarks of station
    public function saveEmployeeRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        $res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
            $res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
            echo $res;
        }
        //echo "Hola";
    }

    public function EmployeeDocument($id){
        $employedocument = DB::table("document")
           ->join("employeedocument","document.id", "=" , "employeedocument.document_id")
           ->where("employeedocument.employee_id" , $id)
           ->get();
        return json_encode( $employedocument );
    }

    public function EmployeeUpdateDocument(Request $r){
        //dd($r->all());

        $data = $r->all();
        $id = $data['id'];
        DB::table("employeedocument")->where('employee_id', '=', $id)->delete();
        $document_old = "";
        for ($i=0; $i < count($data['name']); $i++) {
            $name     = $data['name'][$i];
            $document = $data['document'][$i];
            if(isset($data['document_old'][$i])){
                $document_old = $data['document_old'][$i];
            }
            $number   = $data['number'][$i];

            $folder = base_path() . '/public/images/employee/'.$id;
            File::makeDirectory($folder, 0777, true, true);
            $destination = $folder . '/';

            //$image = $request->file('product_photo');
            if (isset($document)) {
                $image_name = $document->getClientOriginalName();
                if ($document->move($destination, $image_name)) {
                    $document_id = DB::table('document')->insertGetId(
                        ['name' => $name, 'path' => $image_name, 'number' => $number, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
                    );
                    DB::table('employeedocument')->insert(
                        ['employee_id' => $id, 'document_id' => $document_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
                    );
                }
            }else{
                $document_id = DB::table('document')->insertGetId(
                    ['name' => $name, 'path' => $document_old, 'number' => $number, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
                );
                DB::table('employeedocument')->insert(
                    ['employee_id' => $id, 'document_id' => $document_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
                );
            }
        }
        return json_encode("ok");
    }
}
