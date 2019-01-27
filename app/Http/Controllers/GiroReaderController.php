<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Classes\GiroReader;
use Illuminate\Filesystem\Filesystem as File;
use Storage;

class GiroReaderController extends Controller
{

    protected $carbon;
    protected $upload_path;

    public function __construct(GiroReader $GiroReader, File $file)
    {
        $this->carbon = new Carbon\Carbon;
        $this->GiroReader = $GiroReader;
        $this->upload_path = storage_path('giro');
        $this->file = $file;
    }

    public function get_reader()
    {
        return view('admin.giro_reader.index', ['giro' => []]);
    }
	
	
    public function get_upload($file)
    {
		$giro_txt = $file;
        return view('admin.giro_reader.index', ['giro' => [],'giro_txt'=>$giro_txt]);
    }	

    public function get_detail($id)
    {
        return view('admin.giro_reader.details', ['id' => $id]);
    }

    public function post_uploaded(Request $request)
    {
		$giro = 'http://' . $_SERVER['SERVER_NAME'] . '/text/' . $request->get('giro') . ".txt";

        //generate
        $data = $this->GiroReader->all($giro);
        if(!is_array($data) || !count($data))
        {
            return response()->json([
                'message'=>'Invalid Giro File',
                'status'=>false
            ]);
        }

        //return  giro
        return response()->json([
            'message'   =>'Giro was uploaded and generated',
            'data'      => $data,
            'status'    =>true
        ]);		
	}	
	
    public function post_upload(Request $request)
    {
        $giro = $request->file('giro');

        //verify file is valid
        if(!$giro->isValid() || $giro->getMimeType() != 'text/plain' || $giro->getSize() < 960){
            return response()->json([
                'message'=>'Invalid Giro file',
                'status'=>false
            ]);
        }

        //make directory
        if(!is_dir($this->upload_path)){
            $this->file->makeDirectory($this->upload_path, $mode = 0775, $recursive = true);
        }

        //upload
        $filename = $giro->getClientOriginalName();
        $giro->move($this->upload_path, $filename);

        //ensure uploaded file exists
        if(!file_exists($file_path = storage_path("giro/{$filename}"))){
            return response()->json([
                'message'=>'File upload failed. Possibly permission error!',
                'status'=>false
            ]);
        }

        //generate
        $data = $this->GiroReader->all($file_path);
        if(!is_array($data) || !count($data))
        {
            return response()->json([
                'message'=>'Invalid Giro File',
                'status'=>false
            ]);
        }

        //time to remove the uploaded file
        $this->file->delete($file_path);

        //return  giro
        return response()->json([
            'message'   =>'Giro was uploaded and generated',
            'data'      => $data,
            'status'    =>true
        ]);
    }
}
