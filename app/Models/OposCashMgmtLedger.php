<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OposCashMgmtLedger extends Model
{
    protected $table = "opos_cashmgmtledger";

    protected $fillable = [
        'terminal_id', 'pcreason_id', 'location', 'amount' 
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
}
