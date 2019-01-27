<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderProduct extends Model
{
    protected $table = 'deliveryordersproduct';
    
    // protected $fillable = ['do_id','product_id','quantity','status'];
    
    
    public function deliveryorder()
    {
        return $this->belongsTo('App\Models\DeliveryOrder','do_id','id');
    }
    
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
