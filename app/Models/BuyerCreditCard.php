<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BuyerCreditCard extends Model
{
    protected $table="buyercredit_card";
     use SoftDeletes;
     protected $dates = ['deleted_at'];

}
