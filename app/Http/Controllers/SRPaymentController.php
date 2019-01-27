<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\UserPayment;
use DB;
use Carbon;
use Illuminate\Support\Facades\Auth;
use Request;
use App\Classes\SRAnalysis;
use App\Classes\SRPayment;

class SRPaymentController extends Controller
{

    private $carbon;
    private $userpayment;

    public function __construct(SRAnalysis $SRAnalysis, SRPayment $SRPayment)
    {
        $this->carbon = new Carbon\Carbon;
        $this->userpayment = new UserPayment;
        $this->SRAnalysis = $SRAnalysis;
        $this->SRPayment = $SRPayment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.payment.sr');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_sr()
    {
        try {

            $sts = DB::select(DB::raw("SELECT ss.id as stid, CONCAT(u.first_name, ' ', u.last_name) as name, ss.target_station as target_merchant, ss.target_revenue as target_revenue, ss.type= ss.bonus as bonus, SUM(p.receivable) as esince, COUNT(si.response) as clicked, COUNT(op.status) as outstanding, DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv, ad.area_id as area, c.state_code as state, c.country_code as country, cur.code as currency FROM sales_staff ss, users u, smmout so, smmin si, address ad, city c, payment p, porder po, currency cur, orderproduct op WHERE cur.active = 1 and ss.user_id = u.id and ss.type = 'str' and so.user_id = u.id and si.smmout_id = so.id and u.default_address_id = ad.id and ad.city_id = c.id and ss.user_id = po.user_id and po.payment_id = p.id and op.porder_id = po.id and op.commission_paid=0 and ss.created_at BETWEEN ss.created_at AND CURDATE() GROUP BY ss.id"));
            // return $sts;
            foreach ($sts as $key => $st) {
                $item_sold[$key] = DB::select(DB::raw("SELECT COUNT(so.product_id) as item_sold FROM sales_staff ss, users u, smmout so, smmin si WHERE ss.id = $st->stid and ss.user_id = u.id and ss.type = 'str' and so.user_id = u.id and si.smmout_id = so.id and si.response = 'buy' GROUP BY ss.id"));

                $relationship[$key] = DB::select(DB::raw("SELECT COUNT(m.id) as relationship FROM station m, sales_staff ss WHERE ss.id = $st->stid and ss.type = 'str' and ss.id=m.mc_sales_staff_id"));

                $brand[$key] = DB::select(DB::raw("SELECT COUNT(b.id) as brand FROM station m, sales_staff ss, stationbrand mb, brand b WHERE ss.id = $st->stid and ss.type = 'str' and ss.id=m.mc_sales_staff_id and m.id=mb.station_id and mb.brand_id=b.id"));

                $sales_since[$key] = DB::select(DB::raw("SELECT SUM(p.receivable) as sales_since FROM station m, sales_staff ss, stationsproduct mp, orderproduct op, porder po, payment p WHERE ss.id = $st->stid and ss.type = 'str' and ss.id=m.mc_sales_staff_id and m.id=mp.station_id and op.product_id=mp.sproduct_id and op.porder_id=po.id and po.payment_id=p.id  GROUP BY ss.id"));

                $eytd[$key] = DB::select(DB::raw("SELECT SUM(p.receivable) as eytd FROM payment p, sales_staff ss, users u, porder po WHERE ss.id = $st->stid and ss.user_id = u.id and ss.type = 'str' and ss.user_id = po.user_id and po.payment_id = p.id and p.created_at BETWEEN CONCAT(extract(year FROM CURDATE()), '-01', '-01') AND CURDATE() GROUP BY ss.id"));

                $sales_ytd[$key] = DB::select(DB::raw("SELECT SUM(p.receivable) as sales_ytd FROM station m, sales_staff ss, stationsproduct mp, orderproduct op, porder po, payment p WHERE ss.id = $st->stid and ss.type = 'str' and ss.id=m.mc_sales_staff_id and m.id=mp.station_id and op.product_id=mp.sproduct_id and op.porder_id=po.id and po.payment_id=p.id and p.created_at BETWEEN CONCAT(extract(year FROM CURDATE()), '-01', '-01') AND CURDATE() GROUP BY ss.id"));
            }

        } catch(\Exception $e){
              // return $e;
              throw new CustomException($e);
        }

        if (isset($sts) and $sts != null and is_array($sts)){
            foreach ($sts as $st) {
                $rcv_date = $st->rcv;
                if($rcv_date != null and $rcv_date != ''){
                    $date = $this->carbon->parse($rcv_date);

                    $day = $date->format('d');
                    $month = $date->format('m');
                    $year = $date->format('Y');
                    $day_after_seven_days = $day + 7;

                    if ($day_after_seven_days <= 15){
                        $st->due = $this->carbon->parse($year.'-'.$month.'-15')->format('dMy h:m');
                    }else{
                        $st->due = $this->carbon->parse($year.'-'.$month.'-30')->format('dMy h:m');
                    }
                }else{
                    $st->due = '';
                }
            }

            $sts = is_array($sts) && !empty($sts) ? $sts : null;
            $item_sold = is_array($item_sold) && !empty($item_sold) ? $item_sold : null;
            $eytd = is_array($eytd) && !empty($eytd) ? $eytd : null;
            $relationship = is_array($relationship) && !empty($relationship) ? $relationship : null;
            $brand = is_array($brand) && !empty($brand) ? $brand : null;
            $sales_since = is_array($sales_since) && !empty($sales_since) ? $sales_since : null;
            $sales_ytd = is_array($sales_ytd) && !empty($sales_ytd) ? $sales_ytd : null;

            return array($sts, $item_sold, $eytd, $relationship, $brand, $sales_since, $sales_ytd);
        }
    }
	
	public function get_mp_view()
	{
        $merchant_professional = $this->get_merchant_professional();
        // return $sr_arrays;
         return view('admin.payment.mp', compact('merchant_professional', $merchant_professional));
	}

	public function get_mpdetail_view()
	{
        $mpdetails =array();
        // return $sr_arrays;
         return view('admin.payment.mp_details', compact('mpdetails', $mpdetails));
		
	}

	public function get_mpanalysis_view()
	{
        $mpdetails =array();
        // return $sr_arrays;
         return view('admin.payment.mp_analysis', compact('mpdetails', $mpdetails));
		
	}



    public function post_consolidation()
    {
        //get merchant consultant IDs, merchants IDs and Receivables
        $sr_ids = Request::get('sr_ids');
        $station_ids = Request::get('station_ids');
        $receivables = Request::get('receivables');

        //ensure we have an array of station_ids
        if(!is_array($sr_ids) || empty($sr_ids)){
            session()->flash('error_msg', 'Select atleast one Station Recruiter');
            return redirect()->route('srPayment');
        }

        try{
            $consolidate = $this->SRPayment->post_consolidate_sr($sr_ids, $station_ids, $receivables);
        }catch(Exception $e){
            throw new CustomException($e->getMessage());
        }

        if($consolidate === TRUE){
            session()->flash('success_msg', 'Consolidation was successful');
        }elseif($consolidate === FALSE){
            session()->flash('error_msg', 'Consolidation failed');
        }else{
            session()->flash('error_msg', $consolidate);
        }

        //Take us back to page
        return redirect()->route('srPayment');
    }


	private function get_merchant_professional(){

		try {

			$merchant_professional = DB::select(DB::raw("SELECT ss.*, CONCAT(u.first_name, ' ', u.last_name) as name FROM `sales_staff` ss, users u WHERE u.id = ss.user_id and ss.type = 'mcp'"));
		} catch(QueryException $e){
			throw new CustomException($e->getMessage());
		}

		$merchant_professional = is_array($merchant_professional) && !empty($merchant_professional) ? $merchant_professional : null;
		return $merchant_professional;
	}
    private function get_station_recruiter(){
        try {
            $global = DB::table('global')->select('str_sales_staff_commission','osmall_commission')->first();

            $currency = DB::table('currency')->select('code')->where('active' , '=', 1)->first();

            $station_recruiter = DB::select(DB::raw("
                SELECT CONCAT(u.first_name, ' ', u.last_name) as name,u.id as user_id,s.id as station_id ,
                s.str_sales_staff_commission as ss_commission , ss.id as sr_id, ss.status as status, ss.active_date

                FROM sales_staff ss
                JOIN users u ON ss.user_id = u.id
                JOIN station s ON ss.id = s.str_sales_staff_id
                WHERE ss.type = 'str'"
            ));

//            dd($station_recruiter);

            foreach($station_recruiter as $key=>$value){
                $staff = DB::select(DB::raw("SELECT SUM(p.receivable) as receivable, po.id as porder_id,s.station_name,
                        DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv
                        FROM sales_staff ss, porder po
                        JOIN station s ON ss.id = s.str_sales_staff_id

                        JOIN merchantproduct mp ON op.product_id = mp.product_id
                        JOIN merchant m ON mp.merchant_id = m.id
                        JOIN payment p ON po.payment_id = p.id
                        WHERE s.id = $value->station_id"
                ));
                $value->porder_id = $staff[0]->porder_id;
                $value->station_name = $staff[0]->station_name;
                $value->receivable = $staff[0]->receivable;

                $value->ss_commission = (
                empty($station_recruiter->ss_commission) ? $global->str_sales_staff_commission : $station_recruiter->ss_commission);

                $value->outstanding = $staff[0]->receivable * (empty(
                    $station_recruiter->ss_commission) ? $global->str_sales_staff_commission : $station_recruiter->ss_commission);

                $value->currency_code = $currency->code;

                $rcv_date = $staff[0]->rcv;

                if(isset($rcv_date)){
                    $date = $this->carbon->parse($rcv_date);
                    $day = $date->format('d');
                    $month = $date->format('m');
                    $year = $date->format('Y');
                    $day_after_seven_days = $day + 7;
                    if ($day_after_seven_days <= 15){
                        $value->due = $this->carbon->parse($year.'-'.$month.'-15')->format('dMy h:m');
                    }else{
                        $value->due = $this->carbon->parse($year.'-'.$month.'-30')->format('dMy h:m');
                    }
                }else{
                    $value->due = '';
                }
            }
        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }
        return $station_recruiter;
    }

    public function get_sr_view()
    {
        $currency = DB::table('currency')->select('code')->where('active' , '=', 1)->first();

        $station_recruiter = $this->SRPayment->get_sr();

        return view('admin.payment.sr', ['station_recruiter'=>$station_recruiter, 'currency'=>$currency]);
    }

    public function get_srdetails_view($sr_id)
    {
        $currency = DB::table('currency')->select('code')->where('active' , '=', 1)->first();

        $sr_details = $this->SRPayment->get_sr($sr_id);

        return view('admin.payment.sr_details',['sr_details'=>$sr_details, 'currency'=>$currency, 'sr_id' => $sr_id]);
    }

    public function get_sranalysis_view($sr_id)
    {
        $currency = DB::table('currency')->select('code')->where('active' , '=', 1)->first();

        $ssa = $this->SRAnalysis->get_sr_analysis($sr_id);

        return view('admin.payment.sr_analysis',['ssa'=>$ssa, 'currency'=>$currency, 'sr_id' => $sr_id]);
    }


    public function get_mcanalysis_view($mc_id)
    {
        $mca_details = $this->SRAnalysis->get_mc_analysis($mc_id);

        return view('admin.payment.mc_analysis', compact('mca_details', $mca_details));
    }
}