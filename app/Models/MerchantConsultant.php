<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MerchantConsultant extends Model
{
    protected $table = 'merchant_consultant';
    
    public function getAllMerchantConsultants()
    {
        return $this->join('users', 'merchant_consultant.user_id', '=', 'users.id')->orderBy('users.name')->lists('users.name','merchant_consultant.id')->all();
    }
}