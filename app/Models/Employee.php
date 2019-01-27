<?php

namespace App\Models;
use App\Models\Positions;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table = 'employee';


    public function positions() {
        return $this->belongsTo("App\Models\Positions",'position_id');
    }

    public function users(){
        return $this->belongsTo("App\Models\User",'user_id');
    }

    public function sourceUser(){
        return $this->belongsTo("App\Models\User",'source_user_id');
    }

    public function bankaccount(){
        return $this->belongsTo("App\Models\BankAccount",'bankaccount_id');

    }

}
