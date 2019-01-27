<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SOrder extends Model
{
    protected $table = 'sorder';
    protected  $guarded = ['id'];

    public function porder()
    {
        return $this->belongsTo('App\Models\POrder');
    }

}
