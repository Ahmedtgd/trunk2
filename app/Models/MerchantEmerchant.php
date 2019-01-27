<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantEmerchant extends Model
{
    protected $table =  'merchantemerchant';
    protected $fillable =['merchant_id','emerchant_id'];
}
