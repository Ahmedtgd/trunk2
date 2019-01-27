<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cprofile;
use App\Models\Fsection_a;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class cprofile_controller extends Controller
{
    public function aboutUs() 
    {
		$data    = Cprofile::find(1);
        $cover = $data['cover'];
        return view('cprofile/about_us', ['about_us' => $cover]); 
    }

  	public function content() 
    {
		$data    = Fsection_a::find(1);
        $content = $data['about_us'];
        return view('cprofile/content', ['content' => $content]); 
    }

    public function people() 
    {
		$name = "people";
		$data = Cprofile::find(1);
        $people = $data['people'];
        return view('cprofile/people', ['content' => $people]); 
    }
 
    public function innovation() 
    {
		$name = "innovation";
		$data = Cprofile::find(1);
        $innovation = $data['innovation'];
        return view('cprofile/innovation', ['content' => $innovation]); 
    }
 
    public function risk() 
    {
		$name = "risk";
		$data = Cprofile::find(1);
        $risk = $data['risk'];
        return view('cprofile/risk', ['content' => $risk]); 
    }

    public function target() 
    {
		$name = "target";
		$data = Cprofile::find(1);
        $target = $data['target'];
        return view('cprofile/target', ['content' => $target]); 
    }

    public function jaguar() 
    {
		$name = "jaguar";
		//$data = Cprofile::find(1);
      //  $jaguar = $data['jaguar'];
        return view('cprofile/jaguar'); 
    }	
 
 
     public function flyingfox() 
    {
		$name = "flyingfox";
		//$data = Cprofile::find(1);
      //  $jaguar = $data['jaguar'];
        return view('cprofile/flyingfox'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
