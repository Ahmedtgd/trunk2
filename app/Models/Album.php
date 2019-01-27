<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'album';

    public function merchant()
    {
        return $this->belongsTo('App\Models\Merchant');
    }

    public function profiles()
    {
        return $this->hasMany('App\Models\Profile', 'album_id');
    }
    public function signboard(){
        return $this->hasMany('App\Models\Signboard','album_id');
    }
    public function bunting(){
        return $this->hasMany('App\Models\Bunting','album_id');
    }
    public function vbanner(){
        return $this->hasMany('App\Models\VBanner','album_id');
    }
}
