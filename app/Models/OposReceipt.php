<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OposReceipt extends Model
{
    protected $table = "opos_receipt";

    protected $fillable = [
        'reciept_no', 'merchant_id', 'cash_received', 'payment_type', 'points',
        'room_no', 'location_id', 'terminal_id', 'staff_user_id', 'cash_100',
        'cash_50', 'cash_20', 'cash_10', 'cash_5', 'cash_2', 'cash_1', 'cents_1',
        'cents_5', 'cents_10', 'cents_20', 'cents_50', 
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
   
}
