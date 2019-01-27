<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    //
    protected $table ='position';

    public function employees(){
        return $this->hasMany("App\Models\Employee");
    }
}
