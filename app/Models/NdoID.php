<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NdoID extends Model
{
    protected $table = 'ndeliveryorderid';

    protected $fillable =['ndeliveryorder_id','deliveryorder_id'];
}
