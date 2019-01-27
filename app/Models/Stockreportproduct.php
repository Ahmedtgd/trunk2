<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stockreportproduct extends Model
{
    protected $table='stockreportproduct';

    public function report()
    {
        return $this->belongsTo('App\Models\Stockreport','stockreport_id','id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
}
