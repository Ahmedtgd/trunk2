<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'theme';
    protected $fillable = ['profile_id','image','bg_color','font_family','font_color','font_style','font_size'];

    public function theme(){
        return $this->belongsTo('App\Model\Theme');
    }
}
