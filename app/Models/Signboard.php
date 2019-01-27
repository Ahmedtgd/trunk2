<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Signboard extends Model
{
    protected $table = 'signboard';

    protected $fillable = [
        'id',
        'album_id',
        'image',
        'created_at',
        'delete_at',
        'update_at'
    ];

    public function profile(){
        return $this->hasone('App\Models\Profile','signboard_id','id');
    }

    public function updateSignboard($req,$album_id,$merchant_id)
    {
        $image = $req->file('file');
        $image_name = $image->getClientOriginalName();
        if($req['action'] == 'update'){
            $row_id = $req['rowid'];
            Signboard::where('id',$row_id)->update(['image'=>$image_name]);
            $folder = base_path().'/public/images/signboard/'.$row_id;
            File::makeDirectory($folder, 0777,true,true);
            $destination = $folder. '/';
            $image->move($destination,$image_name);
            return $row_id;
        }
        else
        {
            $signboard = new Signboard();
            $signboard->album_id = $album_id;
            $signboard->image = $image_name;
            $signboard->save();
            $lastrow = Signboard::orderBy('id','desc')->first();
            $id = $lastrow->id;
            $folder = base_path().'/public/images/signboard/'.$id;
            File::makeDirectory($folder, 0777,true,true);
            $destination = $folder. '/';
            $image->move($destination,$image_name);
            return $id;
        }

    }
}
