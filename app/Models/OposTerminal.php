<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OposTerminal extends Model
{
    protected  $table = "opos_terminal";

    protected $fillable = [
        'name', 'description', 'location_id', 'start_work', 'end_work',
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function receipts(){
        return $this->hasMany('\App\Models\OposReceipt', 'terminal_id', 'id');
    }

    public function pettycash(){
        return $this->hasMany('\App\Models\OposPettyCash', 'terminal_id', 'id');
    }
    public function location(){
        return $this->hasMany("\App\Models\OposLocationTerminal","id","terminal_id");
    }
}