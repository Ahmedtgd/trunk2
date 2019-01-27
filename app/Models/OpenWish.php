<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenWish extends Model
{
    protected $table = 'openwish';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
 
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    //---Pledge Method---//
    public function pledges(){
        return $this->hasMany('App\Models\OpenWishPledge','openwish_id');
    }

    //---PledgeAmount Method---//
    public function pledgeAmount(){
        $pledge = OpenWishPledge::where('openwish_id',$this->id)->get();
        $amt = 0;
        foreach ($pledge as $item) {
            $amt += $item->pledged_amt;
        }

        return $amt;
    }
}
