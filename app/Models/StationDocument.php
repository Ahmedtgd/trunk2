<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StationDocument extends Model
{
    protected $table ="stationdocument";
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['station_id', 'document_id'];

    public function storedoc($request, $station_id)
    {
        //first check if category exist
        $isfound = StationDocument::where('station_id',$station_id)->where('document_id',$request->document_id)->first();
        if($isfound) return false;
        $records =[
            'station_id'    => $station_id,
            'document_id'   => $request->document_id,
        ];
        $station_cat = new StationDocument();
        return $station_cat->create($records);
    }

}
