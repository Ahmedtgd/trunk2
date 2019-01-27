<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BuyerCategory extends Model
{
    protected $table = 'buyercategory';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

}
