<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'section';
    
    //---Products Method---//
//    public function products(){
//        return $this->hasMany('App\Models\SectionProduct', 'section_id');
//    }

    public function products(){
        return $this->belongsToMany("App\Models\Product","sectionproduct","section_id","product_id");
    }
}
