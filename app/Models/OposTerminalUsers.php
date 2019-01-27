<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OposTerminalUsers extends Model
{
    protected  $table = "opos_terminalusers";

    protected $fillable = [
        'terminal_id', 'user_id',
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    
    public function terminals(){
        return $this->hasOne("\App\Models\OposTerminal","terminal_id","id");
    }

}