<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{

    protected $table = 'dealer';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productDealers(){
        return $this->hasMany('App\Models\ProductDealer','dealer_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(){
        return $this->belongsToMany('App\Models\Product', 'productdealer','product_id','dealer_id')->withTimestamps()->withPivot(
            [
                'special_unit',
                'special_price',
                'deleted_at'
            ]
        );
    }
}
