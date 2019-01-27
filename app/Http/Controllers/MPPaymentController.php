<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\UserPayment;
use DB;
use Carbon;
use Illuminate\Support\Facades\Auth;
use Request;
use App\Classes\SRAnalysis;
use App\Classes\MPPayment;

class MPPaymentController extends Controller
{

    private $carbon;
    private $userpayment;

    public function __construct(SRAnalysis $SRAnalysis, MPPayment $MPPayment)
    {
        $this->carbon = new Carbon\Carbon;
        $this->userpayment = new UserPayment;
        $this->SRAnalysis = $SRAnalysis;
        $this->MPPayment = $MPPayment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.payment.mp');
    }
	
	public function get_mp_view()
	{
        $mp = $this->MPPayment->get_mp();

         return view('admin.payment.mp', ['mcp' => $mp]);
	}

    public function get_mpdetail_view($id){

        if(!is_numeric($id)){
            Session::flash('error_msg', 'Ops invalid MP ID');
            return redirect()->back();
        }

        $mp = $this->MPPayment->get_mp($id);

        return view('admin.payment.mp_details', ['mcp' => $mp]);
    }

    public function get_mpanalysis_view($id)
    {
        if(!is_numeric($id)){
            Session::flash('error_msg', 'Ops invalid MP ID');
            return redirect()->back();
        }

        $mp = $this->MPPayment->get_mp_analysis($id);

        return view('admin.payment.mp_analysis', ['mcp' => $mp]);
    }

    public function post_consolidation(){

        //get merchant consultant IDs, merchants IDs and Receivables
        $mp_ids = Request::get('mp_ids');
        $merchant_ids = Request::get('merchant_ids');
        $receivables = Request::get('receivables');

        //ensure we have an array of merchant_ids
        if(!is_array($mp_ids) || empty($mp_ids)){
            session()->flash('error_msg', 'Select at least one Merchant Recruiter');
            return redirect()->route('mpPayment');
        }

        try{
            $consolidate = $this->MPPayment->post_consolidate_mp($mp_ids, $merchant_ids, $receivables);
        }catch(Exception $e){
            throw new CustomException($e->getMessage());
        }

        if($consolidate === TRUE){
            session()->flash('success_msg', 'Consolidation was successful');
        }elseif($consolidate === FALSE){
            session()->flash('error_msg', 'Consolidation failed');
        }else{
            session()->flash('error_msg', $consolidate);
        }

        //Take us back to page
        return redirect()->route('mpPayment');
    }
}