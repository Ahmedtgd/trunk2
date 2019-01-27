<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityToken extends Model
{
	/*

		This token table is used for email validation
	*/ 
    protected $table = "token";
}
