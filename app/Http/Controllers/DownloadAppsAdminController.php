<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AdminDownloadApps;
use App\Classes;

class DownloadAppsAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $downloadapps = AdminDownloadApps::all();
     
        return Response()->json(array(
            'error' => false,
            'downloadapps' => $downloadapps->toArray()),
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
        $downloadapps = new AdminDownloadApps;
        $downloadapps->name = $inputs['name'];
        $downloadapps->description = $inputs['content'];
        $downloadapps->version = $inputs['version'];
        $downloadapps->link = $inputs['link'];
        $downloadapps->os = $inputs['os'];
        $file = \Input::file('downloadAppspic');
        if ($file != ''){
            $destinationPath = '../public/images/downloadapps/';
            $filename = uniqid().'-'.$file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $downloadapps->picture = $filename;
        }
        if (isset($inputs['activeStatus']) && ($inputs['activeStatus']== 'on')) {
            $downloadapps->active = 1;
        }else{
            $downloadapps->active = 0;
        }
        $downloadapps->save();

        return Response()->json(array(
            'error' => false,
            'downloadapps' => $downloadapps->toArray()),
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
        $downloadapps = AdminDownloadApps::find($id);
        $inputs =  \Input::all();
        if (isset($inputs['name']) && $inputs['name'] != '') {
            $downloadapps->name = $inputs['name'];
        }
        if (isset($inputs['activeStatus']) && $inputs['activeStatus'] != '') {
            if ($inputs['activeStatus'] == 'on'){
                $downloadapps->active = 1;
            }
        }else{
            $downloadapps->active = 0;
        }
        if (isset($inputs['content']) && $inputs['content'] != '') {
            $downloadapps->description = $inputs['content'];
        }
        if (isset($inputs['version']) && $inputs['version'] != '') {
            $downloadapps->version = $inputs['version'];
        }
        if (isset($inputs['os']) && $inputs['os'] != '') {
            $downloadapps->os = $inputs['os'];
        }
        $file = \Input::file('downloadappsPic');
        if ($file != ''){
            //save image file
            $destinationPath = '../public/images/downloadapps/';
            $filename = uniqid().'-'.$file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $downloadapps->picture = $filename;
            
        }

        $downloadapps->save();
     
        return Response()->json(array(
            'error' => false,
            'sent' => $inputs,
            'downloadapps' => $downloadapps,
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
        $downloadapps = AdminDownloadApps::find($id);
        $filename = $downloadapps->picture;
        if ($filename == "") {
        }else {
            $file_name = '../public/images/downloadapps/'.$filename;
            if(file_exists($file_name)){
                $deleteStatus = unlink($file_name);
                // $deleteStatus = delete($file_name);
                if ($deleteStatus) {
                    $downloadapps->delete();
                    return Response()->json(array('error' => false, 'message' => 'Terms And Condition deleted with image'), 200
                    );
                } else {
                    return Response()->json(array('error' => true, 'message' => 'picture in use'), 500 );
                }
            } else {
                $downloadapps->delete();
                return Response()->json(array('error' => true, 'message' => 'picture not found'), 200 );
            }
        }
        $downloadapps->delete();
        return Response()->json(array(
            'error' => true,
            'message' => 'picture not found'),
            200
            );
    }

   
    
    
}
