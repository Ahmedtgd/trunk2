<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StationWebsite extends Model
{
    protected $table = 'stationwebsite';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['station_id','website_id'];

    public function store($request, $station_id)
    {
        //first check if category exist
        $isfound = StationWebsite::where('station_id',$station_id)->where('website_id',$request->website_id)->first();
        if($isfound) return false;
        $records =[
            'station_id' 	=> $station_id,
            'website_id'   => $request->website_id,
        ];
        $station_cat = new StationWebsite();
        return $station_cat->create($records);
    }
}
