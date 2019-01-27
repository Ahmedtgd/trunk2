<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenWishPledge extends Model
{
    protected $table = 'openwishpledge';

    public function scopeWithPledgeAmt($query, $id)
    {
        return $query->select(DB::raw('SUM(pledged_amt) as pledged_amt'))->where('openwish_id',$id)->first()->pledged_amt;
    }
}
