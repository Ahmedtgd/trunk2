<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    protected $table = 'uom';

    protected $fillable=['symbol','name','description'];

}
