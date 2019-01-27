<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Models\Station;
use App\Models\SalesStaff;
use App\Models\User;
use App\Models\Currency;
use DB;

class AdminStationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stations = Station::select(DB::raw('station.*'))
		->join('users','station.user_id','=','users.id')
		->join('stationtype','station.stationtype_id','=','stationtype.id')
		->where('stationtype.name','online')
        // ->where('station.user_id','=','users.id')
        ->orderBy('station.created_at','DESC')->get();
		foreach($stations as $station){
			$tokens = DB::table('userstoken')->where('user_id',$station->user_id)->first();
			$token = 0;
			if(!is_null($tokens)){
				$token = $tokens->qty;
			}
			$station->tokens = $token;
            $stations->ocredit=UtilityController::ocredit($station->user_id)['ocredit'];
		}
		$total_active = DB::select(DB::raw("select count(*) as counting from station s, stationtype st where s.stationtype_id=st.id 
		and status='active' and st.name='online' and lcase(s.company_name) not like '%test%'"));

        return view('admin.tblmgmt',['stations'=>$stations,'total_active'=>$total_active[0]]);
    }
	
    public function approval($id)
    {
        $stations = Station::select(DB::raw('station.*'))->where('station.id',$id)->join('users','station.user_id','=','users.id')
        // ->where('station.user_id','=','users.id')
        ->orderBy('station.created_at','DESC')->get();
		$idstation = DB::table('station')->where('station.id',$id)->first(); 
        // return $stations[0]
        return view('admin.tblmgmt',['stations_approval'=>$stations,'idstation'=>$idstation]);
    }	
	
    public function details($id)
    {
        $stations = Station::select(DB::raw('station.*'))->where('station.id',$id)->join('users','station.user_id','=','users.id')
        // ->where('station.user_id','=','users.id')
        ->orderBy('station.created_at','DESC')->get();
        // return $stations[0]
        return view('admin.tblmgmt',['stations_details'=>$stations]);
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

        //function for approving station
    public function approveStation() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
         return \App\Classes\AdminApproveHelper::approveUser($inputs);

      }
    }

    //function for saving remarks of station
    public function saveStationRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        $res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
            $res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
            echo $res;
        }
    }

    public function station_remarks($id){
        $remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status, nbuyerid.nbuyer_id, nsellerid.nseller_id from remark inner join stationremark on stationremark.remark_id = remark.id join station on station.id = stationremark.station_id left join nsellerid on station.user_id = nsellerid.user_id left join nbuyerid on remark.user_id = nbuyerid.user_id where stationremark.station_id = " . $id . "  order by remark.created_at desc"));

        return json_encode($remarks);
    }

    public function get_station_recruiter(){
        $sales_stuffs =  DB::table('sales_staff')
			->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name', 'users.last_name', 'sales_staff.recruiter_user_id', 'sales_staff.target_station', 'sales_staff.target_revenue', 'sales_staff.bonus', 'sales_staff.status', 'users.last_name', 'users.last_name', 'country.name as nationality')
            ->where('sales_staff.type', '=', 'str')
            ->join('users', 'sales_staff.user_id', '=', 'users.id')
            ->leftJoin('country', 'users.nationality_country_id', '=', 'country.id')
            ->orderBy('sales_staff.created_at','desc')
            ->get();
        $currency = Currency::where('active', '=', 1)->first();
       // dd($sales_stuffs);
        return view('admin.master.StationRecruiter')
                ->with('salestaffs', $sales_stuffs)
                ->with('currency', $currency);
    }
	
    public function approval_sr($id){
        $sales_stuffs =  DB::table('sales_staff')
			->select('sales_staff.id as id', 'sales_staff.user_id as user_id', 'users.first_name', 'users.last_name', 'sales_staff.recruiter_user_id', 'sales_staff.target_station', 'sales_staff.target_revenue', 'sales_staff.bonus', 'sales_staff.status', 'users.last_name', 'users.last_name', 'country.name as nationality')
            ->where('sales_staff.type', '=', 'str')
            ->join('users', 'sales_staff.user_id', '=', 'users.id')
            ->leftJoin('country', 'users.nationality_country_id', '=', 'country.id')
			->where('sales_staff.user_id',$id)
            ->orderBy('sales_staff.created_at','desc')
            ->get();
        $currency = Currency::where('active', '=', 1)->first();
       // dd($sales_stuffs);
        return view('admin.master.StationRecruiterApproval')
                ->with('salestaffs', $sales_stuffs)
                ->with('currency', $currency);
    }	

    public function getstationproduct($id){
        $station_product =  DB::table('product')
			->select('product.id as id', 'product.name as name', 'product.stock as stock', 'product.available as available', 'product.parent_id as parent_id')
            ->join('stationsproduct', 'product.id', '=', 'stationsproduct.sproduct_id')
            ->where('stationsproduct.station_id', '=', $id)
            ->get();
       // dd($sales_stuffs);
        return json_encode($station_product);
    }
    public function get_sproperty($station_id)
    {
        try {
         return  DB::table('sproperty')->where('station_id',$station_id)->get();
        } catch (\Exception $e) {
            return array();
        }
        
    }
    public function get_outlet($station_id)
    {
        try {
            $outlets=DB::table('sproperty')->select('sproperty.*','address.line1','address.line2','city.name as cityname','state.name as statename')->leftJoin('address','sproperty.address_id','=','address.id')->leftJoin('city','city.id','=','address.city_id')->leftJoin('state','city.state_code','=','state.code')->where('station_id',$station_id)->get();
        } catch (\Exception $e) {
            // return $e;
		//	dd($e);
         $outlets=array();   
        }
		$station = DB::table('station')->where('id',$station_id)->first();
        $st_id=IdController::nSeller($station->user_id);
        return view('admin.master.station.outlet')->with('outlets',$outlets)
        ->with('st_id',$st_id);
    }
    public function get_oqueue($station_id)
    {
        $oqueues=array();
        $st_id=$station_id;
        return view('admin.master.station.oq')->with('oqueues',$oqueues)->with('st_id',$st_id);
    }
    public function get_sr($station_id)
    {
        try {
            $strs=Station::join('sales_staff','station.str_sales_staff_id','=','sales_staff.id')->join('users','sales_staff.user_id','=','users.id')->where('sales_staff.type','=','str')->where('station.id','=',$station_id)->orderBy('users.created_at','DESC')->get();
        } catch (\Exception $e) {
            return $e;
            $strs=array();
        }
        // return $strs;
		$station = DB::table('station')->where('id',$station_id)->first();
        $st_id=IdController::nSeller($station->user_id);
        return view('admin.master.station.detail')->with('strs',$strs)->with('st_id',$st_id);
    }
}
