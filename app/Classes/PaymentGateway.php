<?php namespace App\Classes;

use DB;

class PaymentGateway{

    public function all()
    {
        return DB::table('payment_gateway')->select('*')->get();
    }

    public function store(array $data)
    {
        return DB::table('payment_gateway')->insertGetId($data);
    }

    public function update($id, array $data)
    {
        $payment_gateway = DB::table('payment_gateway')->where('id', '=', $id);

        //prepare data
        if(!$data['name']) unset($data['name']);
        if(!$data['description']) unset($data['description']);

        if(count($data) && $payment_gateway->first())
        {
            if(is_array($data)) $payment_gateway->update($data);
            return true;
        }

        return false;
    }

    public function delete($id)
    {
        $payment_gateway = DB::table('payment_gateway')->where('id', '=', $id);

        if($payment_gateway->first()){
            $payment_gateway->delete();
            return true;
        }

        return false;
    }
}