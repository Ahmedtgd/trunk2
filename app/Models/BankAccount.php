<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;


class BankAccount extends Model
{
    protected $table = 'bankaccount';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['bank_id', 'account_name1','account_number1', 'account_name2', 'account_number2', 'iban', 'swift'];

     public function bank_details()
    {
        return $this->belongsTo('App\Models\Bank', 'bank_id', 'id');
    }

    public function employees(){
        return $this->hasMany('App\Models\Employee','bankaccount_id','id');
    }

    /*Bank has only one station 1:1*/
    public function station()
    {
        return $this->hasOne('App\Models\Station','bankaccount_id','user_id');
    }

    public function getMeta()
    {
        return[
            "id" => null,
            "bank_id" => null,
            "account_name1" => null,
            "account_number1" => null,
            "account_name2" => null,
            "account_number2" => null,
            "iban" => null,
            "swift" => null,
            "deleted_at" => null,
            "created_at" => null,
            "updated_at" => null
        ];
    }


    public function store(Request $request)
    {


        $bank_data = $this->collectBankFormData($request);
        $bank = new BankAccount();
        $bank_model = $bank->create($bank_data);

        return $bank_model;
    }

    public function collectBankFormData(Request $request )
    {
        return  $bank_data = [
            'bank_id'=> $request->get('bank'), //CHANGED BY IMRAN, FROM STATIC 1 TO FROM USER SELECTED BANK ID
            'account_name1'=>$request->get('account_name'),
            'account_number1'=>$request->get('account_number'),
            'account_name2'=>$request->get('account_name'),
            'account_number2'=>$request->get('account_number'),
            'iban'=>$request->get('ibn'),
            'swift'=>$request->get('swift')
        ];
    }


}
