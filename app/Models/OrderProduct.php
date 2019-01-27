<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'orderproduct';
    
    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    public function pOrder()
    {
        return $this->hasOne('App\Models\POrder','id','porder_id');
    }

    // public function Product()
    // {
    // 	return $this->hasOne('App\Models\Product','id','product_id');
    // }
}
