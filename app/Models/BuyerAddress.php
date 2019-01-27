<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BuyerAddress extends Model
{

    protected $table = 'buyeraddress';
    protected $guarded = [ 'id'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    

}
