<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Buyer extends Model
{
    //
    protected $table = 'buyer';
    protected $guarded = [ 'id'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];



    public function store(Request $request, $user_model){


        $buyer_data = $this->collectBuyerFormData($request, $user_model);
        $buyer = new Buyer();
        $buyer_model = $buyer->create($buyer_data);

        return $buyer_model;
    }

    public function collectBuyerFormData(Request $request, $user_model)
    {
        return $bank_data = [
            'code' => $user_model['id']
        ];
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function buyer_bank()
    {
        return $this->belongsTo('App\Models\BuyerBankAccount', 'id', 'buyer_id');
    }
    
    public function buyercreditcard()
    {
        return $this->belongsTo('App\Models\BuyerCreditcard', 'id', 'buyer_id');
    }
}
