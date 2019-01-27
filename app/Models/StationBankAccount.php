<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StationBankAccount extends Model
{
    protected $table = 'stationbankaccount';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['station_id', 'bankaccount_id'];

    public function bankaccount()
    {
        return $this->belongsTo('App\Models\BankAccount', 'bankaccount_id', 'station_id');
    }
}
