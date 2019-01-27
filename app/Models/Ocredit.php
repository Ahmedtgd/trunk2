<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ocredit extends Model
{
    protected $table = 'ocredit';
    protected $fillable = ['product_id', 'merchant_id', 'porder_id', 'source'];
}
