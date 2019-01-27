<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCatLevel2 extends Model
{
    protected $table = 'subcat_level_2';

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\product', 'id', 'subcat_id');
    }
}
