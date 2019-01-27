<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UserPayment extends Facade{
    protected static function getFacadeAccessor() { return new \App\Classes\UserPayment; }
}