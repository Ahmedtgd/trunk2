<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OposBundleProduct extends Model
{
    protected  $table = "opos_bundleproduct";

    protected $fillable = [
        'bundle_id', 'product_id','bpdiscount','bpqty'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    
    public function bundle(){
        return $this->belongsTo("\App\Models\OposBundleProduct","bundle_id");
    }
    public function product(){
        return $this->belongsTo("\App\Models\Product","product_id");
    }

}