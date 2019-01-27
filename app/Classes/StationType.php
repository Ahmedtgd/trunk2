<?php namespace App\Classes;

use DB;

class StationType{

    public function all()
    {
        return DB::table('stationtype')->select('*')->get();
    }

    public function store(array $data)
    {
        return DB::table('stationtype')->insertGetId($data);
    }

    public function update($id, array $data)
    {
        $station_type = DB::table('stationtype')->where('id', '=', $id);

        //prepare data
        if(!$data['name']) unset($data['name']);
        if(!$data['description']) unset($data['description']);

        if(count($data) && $station_type->first())
        {
            if(is_array($data)) $station_type->update($data);
            return true;
        }

        return false;
    }

    public function delete($id)
    {
        $station_type = DB::table('stationtype')->where('id', '=', $id);

        if($station_type->first()){
            $station_type->delete();
            return true;
        }

        return false;
    }
}