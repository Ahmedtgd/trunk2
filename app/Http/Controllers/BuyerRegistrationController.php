<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class BuyerRegistrationController extends Controller
{
   public function store(Request $request)
   {
    
        $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',

                    ]);
        // *******************************
           if ($validator->fails()) {
                    return redirect('/')
                        ->withInput()
                        ->withErrors($validator);
                                        }   
   // ************************************************

   }
}
