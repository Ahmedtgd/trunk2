<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests;

use DB;
use Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Classes\StationType;

class StationTypeController extends Controller
{

    private $carbon;

    public function __construct(StationType $StationType)
    {
        $this->carbon = new Carbon\Carbon;
        $this->StationType = $StationType;
    }

    public function  get_index()
    {
        $station_types = $this->StationType->all();

        return view('admin.general.station_type', ['station_types' => $station_types]);
    }


    public function post_store(Request $request)
    {
        $data = $request->only(['name', 'description']);

        if(!$this->StationType->store($data))
        {
            return response()->json([
                'message'=>'Station Type could not be saved',
                'status'=>false
            ]);
        }

        return response()->json([
            'message'=>'Station Type was saved',
            'status'=>true
        ]);
    }

    public function post_update($id, Request $request)
    {
        $data = $request->only(['name', 'description']);

        if(!$this->StationType->update($id, $data))
        {
            return response()->json([
                'message'=>'Station Type could not be updated',
                'status'=>false
            ]);
        }

        return response()->json([
            'message'=>'Station Type was updated',
            'status'=>true
        ]);
    }

    public function get_delete($id)
    {
        if(!$this->StationType->delete($id))
        {
            return response()->json([
                'message'=>'Station Type could not be deleted',
                'status'=>false
            ]);
        }

        return response()->json([
            'message'=>'Station Type was deleted',
            'status'=>true
        ]);
    }
}