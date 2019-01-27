<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileProduct extends Model
{
    protected $table = 'profileproduct';

    protected $fillable = ['product_id','profile_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
