<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Request;

use App\Classes\IPayReceivable;
use App\Exceptions\CustomException;

class PaymentReceivableController extends Controller
{

    private $Carbon;

    public function __construct(IPayReceivable $IPayReceivable, Carbon $Carbon)
    {
        $this->Carbon = $Carbon;
        $this->IPayReceivable = $IPayReceivable;
    }


    public function get_ipay()
    {
        $currency = DB::table('currency')->select('code')->where('active' , '=', 1)->first();

        $receivables = $this->IPayReceivable->get_ipay();

        return view('admin.payment.receivable', ['receivables' => $receivables, 'currency' => $currency]);
    }

    public function get_ipay_detail($week_number)
    {
        $currency = DB::table('currency')->select('code')->where('active' , '=', 1)->first();

        $receivables = $this->IPayReceivable->get_ipay_detail($week_number);

        return view('admin.payment.receivable_detail', ['receivables' => $receivables, 'currency' => $currency]);
    }

    public function post_ipay_partial()
    {
        $partial = Request::get('partial');
        $week_number = Request::get('week_number');
        $payment_id = Request::get('payment_id');

        if(!$partial && ! $week_number && !$payment_id){
            return response()->json([
                'message'=>'Week/Partial not provided',
                'status'=>false
            ]);
        }
//
//        $receivables = $this->IPayReceivable->get_ipay_detail($week_number);

//        if(!is_array($receivables)) return response()->json([
//            'message'=>'Week number does not exists',
//            'status'=>false
//        ]);

        DB::table('payment_receivable')
            ->where('payment_id', $payment_id)
            ->update(['partial' => $partial]);

        return response()->json([
            'status'=>true
        ]);
    }


    public function post_ipay_remark()
    {
        $remarks = Request::get('remarks');
        $week_number = Request::get('week_number');
        $payment_id = Request::get('payment_id');

        if(!$remarks && ! $week_number && !$payment_id){
            return response()->json([
                'message'=>'Week/Remark not provided',
                'status'=>false
            ]);
        }

        $receivables = $this->IPayReceivable->get_ipay_detail($week_number);

        if(!is_array($receivables)) return response()->json([
            'message'=>'Week number does not exists',
            'status'=>false
        ]);

        DB::table('payment_receivable')
            ->where('payment_id', $payment_id)
            ->update([
                'week_number' => $week_number,
                'remarks' => $remarks,
                'confirmation' => date('Y-m-d h:i:s')
            ]);

        return response()->json([
            'message'=>date('Y-m-d h:i:s'),
            'status'=>true
        ]);
    }

}