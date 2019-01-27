<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StationCategory extends Model
{
    protected $table = 'stationcategory';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['station_id','category_id'];

    public function storecategory($request, $station_id)
    {
        //first check if category exist
        $isfound = StationCategory::where('station_id', $station_id)->where('category_id',$request->category)->first();
        if($isfound) return false;
        $records =[
            'station_id' 	=> $station_id,
            'category_id'   => $request->category,
        ];
        $station_cat = new StationCategory();
        return $station_cat->create($records);
    }
}
