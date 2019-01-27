<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Bank extends Model
{
    //
    protected $table = 'bank';
    protected $guarded = [ 'id'];

    /*Bank has only one merchant 1:1*/
    public function merchant()
    {
        return $this->hasOne('App\Models\Merchant','bank_id','user_id');
    }

    /*Bank has only one station 1:1*/
    public function station()
    {
        return $this->hasOne('App\Models\Station','bank_id','user_id');
    }

    public function getMeta()
    {
        return[
            "id" => null,
            "name" => null,
            "code" => null,
            "account_name1" => null,
            "account_number1" => null,
            "account_name2" => null,
            "account_number2" => null,
            "iban" => null,
            "swift" => null,
            "url" => null,
            "description" => null,
            "deleted_at" => null,
            "created_at" => null,
            "updated_at" => null
        ];
    }

    public function store(Request $request)
    {


        $bank_data = $this->collectBankFormData($request);
        $bank = new Bank();
        $bank_model = $bank->create($bank_data);

        return $bank_model;
    }

    public function collectBankFormData(Request $request )
    {
        return  $bank_data = [
            'name'=>$request->get('bank'),
            'code'=>$request->get('bank_code'),
            'account_name1'=>$request->get('account_name'),
            'account_number1'=>$request->get('account_number'),
            'account_name2'=>$request->get('account_name'),
            'account_number2'=>$request->get('account_number'),
            'iban'=>$request->get('ibn'),
            'swift'=>$request->get('swift'),
            'url'=>'null', //todo: not available
            'description'=>'null'//todo: not available
        ];
    }

       public function bankdetails()
    {
        return $this->belongsTo('App\Models\Bank', 'bank_id', 'id');
    }
}
