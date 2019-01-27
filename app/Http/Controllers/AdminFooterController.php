<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminFooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutus()
    {
        return view('admin.AboutUs');
    }
    public function termsandcondition()
    {
        return view('admin.TermsAndCondition');
    }
    public function downloadapps()
    {
        return view('admin.DownloadApps');
    }

    
  
    
}
