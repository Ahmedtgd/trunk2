<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    protected $table = 'discount';
    protected $guarded = [ 'id'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

   public function buyer_discounts()
    {
        return $this->belongsTo("App\Models\DicountBuyer",'discount_id');
    }
}
