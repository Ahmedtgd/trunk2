<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCatLevel4 extends Model
{
    protected $table = 'subcat_level_4';

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function subCatLevel1()
    {
        return $this->belongsTo('App\Models\SubCatLevel1', 'subcat_level_1_id');
    }

    public function subCatLevel2()
    {
        return $this->belongsTo('App\Models\SubCatLevel2', 'subcat_level_2_id');
    }

    public function subCatLevel3()
    {
        return $this->belongsTo('App\Models\SubCatLevel3', 'subcat_level_3_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\product');
    }
}
