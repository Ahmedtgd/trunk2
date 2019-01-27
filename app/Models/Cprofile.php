<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cprofile extends Model
{
    protected $table = "cprofile";
    protected $fillable = [
		'cover',
		'contents'];
}
