<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OposPettyCash extends Model
{
    protected $table = "opos_pettycash";

    protected $fillable = [
        'terminal_id', 'mode', 'staff_user_id', 'pcreason_id', 'amount', 
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];


}
