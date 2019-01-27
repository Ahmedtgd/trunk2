<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionProduct extends Model
{
    protected $table = 'sectionproduct';

    protected $fillable = ['product_id','section_id'];

    //---Product Method---//
//    public function product(){
//        return $this->belongsTo('App\Models\Product', 'product_id');
//    }

}
