<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fsection_a extends Model
{
    protected $table = "fsection_a";
    protected $fillable = ['about_us', 'private_policy','how_to_buy', 'how_to_return', 'how_to_sell', 'terms_and_conditions'];
}
