<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
/*Models*/ 
use App\Models\AdControl;
use App\Models\AdTarget;
use App\Models\AdImage;
use Input;
use File;
use Redirect;
use Storage;
// use Filesystem;
use Carbon;
class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $targets= AdTarget::all();
        return response()->view('admin.ads.index',
            [
            'targets'=>$targets

            ]);
    }

    public function set_ads(Request $r)
    {
      # code...
        // 10 images maximum
      
       if ($r->target=="") {
            // return "lol";
           return view('common.generic')
        ->with('message_type','error')
        ->with('message','Ad Target Missing');
        }
   
       $adtarget_id=$r->target;
        $ad=AdControl::where('adtarget_id',$adtarget_id)->first();
        if (is_null($ad)) {
            # code...
            $adc= new AdControl;
           $adc->adtarget_id=$adtarget_id;
           $adc->height=$r->input('height',0);
           $adc->width=$r->input('width',0);
           $adc->nav=$r->nav;
           $adc->rotation_time=$r->input('rottime',0);
           $adc->priority=$r->priority;
           $adc->save();
        }
        if (!is_null($ad)) {
            # code...
            $adc= AdControl::find($ad->id);
           $adc->adtarget_id=$adtarget_id;
           $adc->height=$r->input('height',0);
           $adc->width=$r->input('width',0);
           $adc->nav=$r->nav;
           $adc->rotation_time=$r->input('rottime',0);
           $adc->priority=$r->priority;
           $adc->save();
        }
       
       // $path= "images/adimages/".$adc->id;

      return response()->json(["status"=>"success",'short_message'=>'AdControl','long_message'=>'Please upload the images using the form below','adcontrol_id'=>$adc->id]);
        
       foreach ($r->file('images') as $img) {
           # code...
        $imageName =$img->getClientOriginalExtension();
        $new_name= str_random(10);
        $name=$new_name.".".$imageName;
        $i= new AdImage;
        $i->adcontrol_id=$adc->id;
        $i->path=$name;
        $i->save();
        $path= public_path('images/adimage/'.$i->id);
        if (!file_exists($path)) {
        File::MakeDirectory($path);
        }
        
        $img->move(base_path() . '/public/images/adimage/'.$i->id.'/', $name
        );
       }
      
            // echo Input::get($x);
       // }
        return view('common.generic')
        ->with('message_type','success')
        ->with('message','Ad Set');
    }

    public function set_targets(Request $r)
    {
        # code...
        // Check if uri has a record.
        try{
            $AdTarget=AdTarget::where('route',$r->uri)->first();
            if (is_null($AdTarget)) {
                $ad= new AdTarget;
                $ad->route=$r->uri;
                $ad->target=$r->identifier;
                $ad->description=$r->desc;
                $ad->save();
                return response()->json(["status"=>"success",'short_message'=>'Target Created','long_message'=>'Target was created successfully.']);
            }
            if (!is_null($AdTarget)) {
                $ad= AdTarget::find($AdTarget->id);
                $ad->route=$r->uri;
                $ad->target=$r->identifier;
                $ad->description=$r->desc;
                $ad->save();
                 return response()->json(["status"=>"success",'short_message'=>'Target Updated','long_message'=>'Target was updated successfully.']);
            }
        }catch(\Exception $e){
            return $e;
            return response()->json(["status"=>"failure",'short_message'=>'Exception Occured','long_message'=>'An error occured.']);
        }
    }
    // Image Handlers

    public function store( Storage $storage, Request $request )
    {
      return $request->oshop;
        if ( $request->isXmlHttpRequest() )
        {
            $image = $request->file( 'image' );
            $timestamp = $this->getFormattedTimestamp();
            $savedImageName = $this->getSavedImageName( $timestamp, $image );

            $imageUploaded = $this->uploadImage( $image, $savedImageName, $storage );

            if ( $imageUploaded )
            {
                $data = [
                    'original_path' => asset( '/images/' . $savedImageName )
                ];
                return json_encode( $data, JSON_UNESCAPED_SLASHES );
            }
            return "uploading failed";
        }

    }
    public function uploadImage( $image, $imageFullName, $storage )
    {
        $filesystem = new File;
        return $storage->disk( 'image' )->put( $imageFullName, $filesystem->get( $image ) );
    }

    protected function getFormattedTimestamp()
    {
        return str_replace( [' ', ':'], '-', Carbon::now()->toDateTimeString() );
    }
    protected function getSavedImageName( $timestamp, $image )
    {
        return $timestamp . '-' . $image->getClientOriginalName();
    }
    public function deleteImage($adimage_id)
    {
      try{
      AdImage::delete($adimage_id);
      return response()->json(['status'=>'success']);
      }catch(\Exception $e){
        return response()->json(['status'=>'failure']);
      }
    }

    // Check if AdControl exists
    public function adcontrolExists($adtarget_id)
    {
      $adtarget=AdTarget::find($adtarget_id);
      if (is_null($adtarget)) {
        # 
        return response()->json(['status'=>'failure','short_message'=>'Null Adtarget','long_message'=>'The adtarget sent was invalid']);
      }
      $adcontrol=AdControl::where('adtarget_id',$adtarget_id)->first();
      if (is_null($adcontrol)) {
        # code...
        return response()->json(['status'=>'success','exists'=>'false']);
      }
      if (!is_null($adcontrol)) {
        // get all images
        $images=AdImage::where('adcontrol_id',$adcontrol->id)->get();
        return response()->json(['status'=>'success','exists'=>'true','images'=>$images,'adcontrol'=>$adcontrol,'adtarget'=>$adtarget]);
      }

    }
    // Save and Return an adcontrol id

    public function createAdcontrol($r)
    {

    }
}
