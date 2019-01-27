<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMMin extends Model
{
    protected $table = 'smmin';

    protected $fillable = ['smmout_id', 'smedia_id', 'source_ip', 'response'];

    
}
