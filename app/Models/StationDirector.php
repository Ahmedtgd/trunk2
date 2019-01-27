<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StationDirector extends Model
{
    protected $table = 'stationdirector';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['station_id','director_id'];

    public function storedirector($request, $station_id)
    {
        //first check if category exist
        $isfound = StationDirector::where('station_id',$station_id)->where('director_id',$request->director_id)->first();
        if($isfound) return false;
        $records =[
            'station_id' 	=> $station_id,
            'director_id'   => $request->director_id,
        ];
        $station_cat = new StationDirector();
        return $station_cat->create($records);
    }
}
