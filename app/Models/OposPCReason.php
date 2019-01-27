<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OposPCReason extends Model
{
    protected $table = "opos_pcreason";

    protected $fillable = [
        'name', 'description', 
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
}
