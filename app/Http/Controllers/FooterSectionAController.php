<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Fsection_a;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Globals;

class footerSectionAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Fsection_a::find(1);
        $g= Globals::first();

        return view('admin.footerSectionA', ['data' => $data,'merchant_tc'=>$g->merchant_agreement,'station_tc'=>$g->station_agreement]);
    }

    public function save(Request $request)
    {
        $inputs = \Input::all();
        $type =  $inputs['type'];
        $content = $inputs['content'];

        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ]);

        $code = array();

                $code['success'] = '$("#'.$type.'").find(".note-frame").attr("style","");
                         $("#'.$type.'").find(".currentalerr").attr("color","#3c763d");
                         $("#'.$type.'").find(".currentalerr").text("Updated Successfully.");
                         $("#'.$type.'").find(".currentalerr").show();
                         setTimeout(function(){$("#'.$type.'").find(".currentalerr").fadeOut("slow");},2000);';
                $code['failed'] = '$("#'.$type.'").find(".note-frame").attr("style","border:1px solid #F00 !important;");
                     $("#'.$type.'").find(".currentalerr").attr("color","red");
                     $("#'.$type.'").find(".currentalerr").text("This field is required.");
                     $("#'.$type.'").find(".currentalerr").show();';
       
        if ($validator->fails() || strlen( preg_replace('/\s+/', '', strip_tags($inputs['content'],'<img>'))) == 0 ) {
            return response()->json(['type'=> 'danger' , 'code'=>$code['failed']]);
        } else {
            $success = false;     

            switch ($type) {
                case 'aboutUs':
                    $table = Fsection_a::findOrNew(1);
                    $table->about_us = $content;
                    if($table->save())
                    {
                        $success = true;
                    }
                    break;
                
                case 'PrivatePolicy':
                    $table = Fsection_a::findOrNew(1);
                    $table->private_policy = $content;
                    if($table->save())
                    {
                        $success = true;
                    }
                    break;
                
                case 'HowToBuy':
                    $table = Fsection_a::findOrNew(1);
                    $table->how_to_buy = $content;
                    if($table->save())
                    {
                        $success = true;
                    }
                    break;
                
                case 'HowToReturn':
                    $table = Fsection_a::findOrNew(1);
                    $table->how_to_return = $content;
                    if($table->save())
                    {
                        $success = true;
                    }
                    break;
                
                case 'HowToSell':
                    $table = Fsection_a::findOrNew(1);
                    $table->how_to_sell = $content;
                    if($table->save())
                    {
                        $success = true;
                    }
                    break;

                case 'Terms-Conditions':
                    $table = Fsection_a::findOrNew(1);
                    $table->terms_and_conditions = $content;
                    if($table->save())
                    {
                        $success = true;
                    }
                    break;
                case 'mtc':
                    $g= Globals::first();
                    $g->merchant_agreement=$content;
                    if ($g->save()) {
                        $success= true;
                    }
                    break;
                case 'stc':
                    $g= Globals::first();
                    $g->station_agreement=$content;
                    if ($g->save()) {
                        $success= true;
                    }
                    break;
                default:
                    echo "This ID doesn't exist";
                    break;
            }

            if(!$success)
                 return response()->json(['type'=> 'danger' , 'code'=>$code['failed']]);
            else 
                 return response()->json(['code' => $code['success']]);


        }
    }

}
