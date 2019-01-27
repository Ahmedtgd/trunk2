<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BuyerBankAccount extends Model
{
        protected $table = 'buyerbankaccount';
        use SoftDeletes;
        protected $dates = ['deleted_at'];

    public function bankaccount()
    {
        return $this->belongsTo('App\Models\BankAccount', 'bankaccount_id', 'id');
    }
}
