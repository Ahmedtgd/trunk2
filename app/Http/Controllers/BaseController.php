<?php
/**
 * Created by PhpStorm.
 * User: sadia
 * Date: 10/25/2015
 * Time: 1:05 PM
 */

namespace App\Http\Controllers;

use App\lib\MessageHandler;

class BaseController extends  Controller{


    public $messageHandler;

    public function __construct()
    {
        $this->messageHandler = new MessageHandler();
    }

}

