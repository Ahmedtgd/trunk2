<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OposBundle extends Model
{
    protected  $table = "opos_bundle";

    protected $fillable = [
        'title', 'valid_start_dt','valid_end_dt','bprice','bundle_thumb_photo'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    
    public function bundleProduct(){
        return $this->hasMany("\App\Models\OposBundleProduct","bundle_id");
    }

}