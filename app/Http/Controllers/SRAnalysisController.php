<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Classes\SRAnalysis;
use DB;
use Carbon;
use Illuminate\Support\Facades\Auth;

class SRAnalysisController extends Controller
{

    private $carbon;
    private $userpayment;

    public function __construct(SRAnalysis $SRAnalysis)
    {
        $this->carbon = new Carbon\Carbon;
        $this->SRAnalysis = $SRAnalysis;
    }

    public function get_mcanalysis_view($mc_id=null)
    {
        $mc_analysis = $this->SRAnalysis->get_mc_analysis($mc_id);
        return view('admin.analysis.mc_analysis', compact('mc_analysis', $mc_analysis));
    }


}