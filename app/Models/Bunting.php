<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Bunting extends Model
{
    protected $table = 'bunting';

    public function updateBunting($req,$album_id,$merchant_id)
    {
        $image = $req->file('file');
        $image_name = $image->getClientOriginalName();
        if($req['action'] == 'update'){
            $row_id = $req['rowid'];
            Bunting::where('id',$row_id)->update(['image'=>$image_name]);
            $folder = base_path().'/public/images/bunting/'.$row_id;
            File::makeDirectory($folder, 0777,true,true);
            $destination = $folder. '/';
            $image->move($destination,$image_name);
            return $row_id;
        }
        else
        {
            $Bunting = new Bunting();
            $Bunting->album_id = $album_id;
            $Bunting->image = $image_name;
            $Bunting->save();
            $lastrow = Bunting::orderBy('id','desc')->first();
            $id = $lastrow->id;
            Bunting::where('id',$id)->update(['image'=>$image_name]);
            $folder = base_path().'/public/images/bunting/'.$id;
            File::makeDirectory($folder, 0777,true,true);
            $destination = $folder. '/';
            $image->move($destination,$image_name);
            return $id;
        }
    }
}
