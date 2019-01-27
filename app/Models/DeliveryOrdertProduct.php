<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrdertProduct extends Model
{
    protected $table    = 'deliveryordertproduct';

    protected $fillable = ['do_id','tproduct_id','status','quantity'];
}
