<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AdminAboutUs;
use App\Classes;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aboutus = AdminAboutUs::all();
     
        return Response()->json(array(
            'error' => false,
            'aboutus' => $aboutus->toArray()),
            200
        );
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
        $inputs =  \Input::all();
        $aboutus = new AdminAboutUs;
        $aboutus->name = $inputs['name'];
        $aboutus->description = $inputs['content'];
        $file = \Input::file('aboutuspic');
        if ($file != ''){
            $destinationPath = '../public/images/aboutus/';
            $filename = uniqid().'-'.$file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $aboutus->filename = $filename;
        }
        if (isset($inputs['activeStatus']) && ($inputs['activeStatus']== 'on')) {
            AdminAboutUs::whereRaw('1')->update(['active' => 0]);
            $aboutus->active = 1;
        }
        $aboutus->save();

        return Response()->json(array(
            'error' => false,
            'aboutus' => $aboutus->toArray()),
            200
        );
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
        $aboutus = AdminAboutUs::find($id);
        $inputs =  \Input::all();
        if (isset($inputs['name']) && $inputs['name'] != '') {
            $aboutus->name = $inputs['name'];
        }
        if (isset($inputs['activeStatus']) && $inputs['activeStatus'] != '') {
            if ($inputs['activeStatus'] == 'on'){
                AdminAboutUs::whereRaw('1')->update(['active' => 0]);
                $aboutus->active = 1;
            }
        }else{
            $aboutus->active = 0;
        }
        if (isset($inputs['content']) && $inputs['content'] != '') {
            $aboutus->description = $inputs['content'];
        }
        $file = \Input::file('aboutUsPic');
        if ($file != ''){
            //save image file
            $destinationPath = '../public/images/aboutus/';
            $filename = uniqid().'-'.$file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $aboutus->filename = $filename;
            
        }

        $aboutus->save();
     
        return Response()->json(array(
            'error' => false,
            'sent' => $inputs,
            'aboutus' => $aboutus,
            'message' => 'model updated'),
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aboutus = AdminAboutUs::find($id);
        $filename = $aboutus->filename;
        if ($filename == "") {
        }else {
            $file_name = '../public/images/aboutus/'.$filename;
            if(file_exists($file_name)){
                $deleteStatus = unlink($file_name);
                // $deleteStatus = delete($file_name);
                if ($deleteStatus) {
                    $aboutus->delete();
                    return Response()->json(array('error' => false, 'message' => 'about us deleted with image'), 200
                    );
                } else {
                    return Response()->json(array('error' => true, 'message' => 'picture in use'), 500 );
                }
            } else {
                $aboutus->delete();
                return Response()->json(array('error' => true, 'message' => 'picture not found'), 200 );
            }
        }
        $aboutus->delete();
        return Response()->json(array(
            'error' => true,
            'message' => 'picture not found'),
            200
            );
    }

   
    
    
}
