<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests;

use DB;
use Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Classes\PaymentGateway;

class PaymentGatewayController extends Controller
{

    private $carbon;

    public function __construct(PaymentGateway $PaymentGateway)
    {
        $this->carbon = new Carbon\Carbon;
        $this->PaymentGateway = $PaymentGateway;
    }

    public function  get_index()
    {
        $currency = DB::table('currency')->select('code')->where('active' , '=', 1)->first();

        $payment_gateways = $this->PaymentGateway->all();

        return view('admin.general.payment_gateway', ['payment_gateways' => $payment_gateways, 'currency' => $currency]);
    }


    public function post_store(Request $request)
    {
        $data = $request->only(['name', 'description']);

        if(!$this->PaymentGateway->store($data))
        {
            return response()->json([
                'message'=>'Payment Gateway could not be saved',
                'status'=>false
            ]);
        }

        return response()->json([
            'message'=>'Payment Gateway was saved',
            'status'=>true
        ]);
    }

    public function post_update($id, Request $request)
    {
        $data = $request->only(['name', 'description']);

        if(!$this->PaymentGateway->update($id, $data))
        {
            return response()->json([
                'message'=>'Payment Gateway could not be updated',
                'status'=>false
            ]);
        }

        return response()->json([
            'message'=>'Payment Gateway was updated',
            'status'=>true
        ]);
    }

    public function get_delete($id)
    {
        if(!$this->PaymentGateway->delete($id))
        {
            return response()->json([
                'message'=>'Payment Gateway could not be deleted',
                'status'=>false
            ]);
        }

        return response()->json([
            'message'=>'Payment Gateway was deleted',
            'status'=>true
        ]);
    }
}