<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'delivery';
    
    protected $fillable=['porder_id','merchant_id','logistic_id','status','password'];
    
    public function products()
    {
        return $this->hasMany('App\Models\DeliveryOrderProduct','do_id','id');
    }
    
    public function porder()
    {
        return $this->belongsTo('App\Models\POrder');
    }
    
    public function merchant()
    {
        return $this->belongsTo('App\Models\Merchant');
    }

}
