<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AdminTermsAndCondition;
use App\Classes;

class TermsAndConditionAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $termsandcondition = AdminTermsAndCondition::all();
     
        return Response()->json(array(
            'error' => false,
            'termsandcondition' => $termsandcondition->toArray()),
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
        $termsandcondition = new AdminTermsAndCondition;
        $termsandcondition->name = $inputs['name'];
        $termsandcondition->description = $inputs['content'];
        $file = \Input::file('termsAndConditionpic');
        if ($file != ''){
            $destinationPath = '../public/images/termsandcondition/';
            $filename = uniqid().'-'.$file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $termsandcondition->filename = $filename;
        }
        if (isset($inputs['activeStatus']) && ($inputs['activeStatus']== 'on')) {
            AdminTermsAndCondition::whereRaw('1')->update(['active' => 0]);
            $termsandcondition->active = 1;
        }
        $termsandcondition->save();

        return Response()->json(array(
            'error' => false,
            'termsandcondition' => $termsandcondition->toArray()),
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
        $termsandcondition = AdminTermsAndCondition::find($id);
        $inputs =  \Input::all();
        if (isset($inputs['name']) && $inputs['name'] != '') {
            $termsandcondition->name = $inputs['name'];
        }
        if (isset($inputs['activeStatus']) && $inputs['activeStatus'] != '') {
            if ($inputs['activeStatus'] == 'on'){
                AdminTermsAndCondition::whereRaw('1')->update(['active' => 0]);
                $termsandcondition->active = 1;
            }
        }else{
            $termsandcondition->active = 0;
        }
        if (isset($inputs['content']) && $inputs['content'] != '') {
            $termsandcondition->description = $inputs['content'];
        }
        $file = \Input::file('termsandconditionPic');
        if ($file != ''){
            //save image file
            $destinationPath = '../public/images/termsandcondition/';
            $filename = uniqid().'-'.$file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $termsandcondition->filename = $filename;
            
        }

        $termsandcondition->save();
     
        return Response()->json(array(
            'error' => false,
            'sent' => $inputs,
            'termsandcondition' => $termsandcondition,
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
        $termsandcondition = AdminTermsAndCondition::find($id);
        $filename = $termsandcondition->filename;
        if ($filename == "") {
        }else {
            $file_name = '../public/images/termsandcondition/'.$filename;
            if(file_exists($file_name)){
                $deleteStatus = unlink($file_name);
                // $deleteStatus = delete($file_name);
                if ($deleteStatus) {
                    $termsandcondition->delete();
                    return Response()->json(array('error' => false, 'message' => 'Terms And Condition deleted with image'), 200
                    );
                } else {
                    return Response()->json(array('error' => true, 'message' => 'picture in use'), 500 );
                }
            } else {
                $termsandcondition->delete();
                return Response()->json(array('error' => true, 'message' => 'picture not found'), 200 );
            }
        }
        $termsandcondition->delete();
        return Response()->json(array(
            'error' => true,
            'message' => 'picture not found'),
            200
            );
    }

   
    
    
}
