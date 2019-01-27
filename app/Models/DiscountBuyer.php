<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class DiscountBuyer extends Model
{
    protected $table = 'discountbuyer';
    protected $guarded = [ 'id'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
