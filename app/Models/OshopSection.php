<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OshopSection extends Model
{
    protected $table = 'oshopsection';

    public function section(){
        return $this->belongsTo("App\Models\Section",'section_id');
    }


}
