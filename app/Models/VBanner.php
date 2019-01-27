<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class VBanner extends Model
{
    protected $table = 'vbanner';

    public function updateVBanner_link($req,$album_id){
        $action = $req->info[0];
        $val = $req->info[2];
        if($action == 'update')
        {
            $rowid = $action = $req->info[1];
            VBanner::where('id',$rowid)->update(['image'=>$val]);
            return $rowid;
        }
        else
        {
            $vbanner = new VBanner();
            $vbanner->album_id = $album_id;
            $vbanner->image = $val;
            $vbanner->save();
            $lastrow = VBanner::orderBy('id','desc')->first();
            $id = $lastrow->id;
            return $id;
        }
    }

    public function updateVBanner_image($req,$album_id){
		$image_name = null;
        $action = $req['action'];
        $image = $req->file('file');
        $image_type = $image->getClientMimeType();
        switch($image_type){
            case 'video/mp4':
                $image_name = 'vbanner.mp4';
                break;
            case 'image/jpg':
                $image_name = 'vbanner.jpg';
                break;
            case 'image/jpeg':
                $image_name = 'vbanner.jpeg';
                break;
            case 'image/png':
                $image_name = 'vbanner.png';
                break;

        }
        if($action == 'update')
        {
            $rowid = $action = $req['rowid'];
            VBanner::where('id',$rowid)->update(['image'=>$image_name]);
            $folder = base_path().'/public/images/vbanner/'.$rowid;
            File::makeDirectory($folder, 0777,true,true);
            $destination = $folder. '/';
            $image->move($destination,$image_name);
            return $rowid;
        }
        else
        {
            $vbanner = new VBanner();
            $vbanner->album_id = $album_id;
            $vbanner->image = $image_name;
            $vbanner->save();
            $lastrow = VBanner::orderBy('id','desc')->first();
            $id = $lastrow->id;
            $folder = base_path().'/public/images/vbanner/'.$id;
            File::makeDirectory($folder, 0777,true,true);
            $destination = $folder. '/';
            $image->move($destination,$image_name);
            return $id;
        }
    }
}
