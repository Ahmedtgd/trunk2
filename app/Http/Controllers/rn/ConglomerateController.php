<?php
namespace App\Http\Controllers\rn;

use App\Http\Controllers\Controller;
use DB;
use JWTAuth;
use Log;
use Input;
use Request;
use Carbon;

/*ALL RESPONSES MUST BE JSON*/
class ConglomerateController extends Controller
{
    public function revenue()
    {
		Log::debug('***** ConglomerateController@revenue() *****');

        $start_date=null;
        $end_date=null;

        $id = Input::get('user');
        $date=Input::get('date');

		Log::debug('id='.$id.', date='.$date);
        
        //RN Dropdown selection
        if($date=="key0"){
         //TODAY'S REVENUE
         $start_date=Carbon::now()->toDateString();
         $locations=$this->today_revenue($start_date,$id);
         $ret=$this->total_company_revenue($locations);
         Log::debug('start_date='.$start_date);
         Log::debug('locations='.json_encode($locations));
         Log::debug('ret      ='.json_encode($ret));
         
        }else if($date=="key1"){
            //WEEK TO DATE
            $start_date=Carbon::now()->toDateString();
            $end_date=Carbon::now()->startOfWeek()->format('Y-m-d');
            $locations=$this->date_based_revenue($start_date,$end_date,$id);
            $ret=$this->total_company_revenue($locations);
            Log::info($end_date);

        }else if($date=="key2"){
            //MONTH TO DATE
            $start_date=Carbon::now()->toDateString();
            $end_date=Carbon::now()->startOfMonth()->format('Y-m-d');
            $locations=$this->date_based_revenue($start_date,$end_date,$id);
            $ret=$this->total_company_revenue($locations);
            Log::info($end_date);

        }else if($date=="key3"){
            //Year TO DATE
            $start_date=Carbon::now()->toDateString();
            $end_date=Carbon::now()->startOfYear()->format('Y-m-d');
            $locations=$this->date_based_revenue($start_date,$end_date,$id);
            $ret=$this->total_company_revenue($locations);
            Log::info($end_date);

        }else{
            //TOTAL REVENUE            
            $locations=$this->fairlocation_revenue($id);
            $ret=$this->total_company_revenue($locations);
        }
        return response(json_encode([$ret]));
    }

    //Method for calculating fairlocation revenue without any date constarint
    public function fairlocation_revenue($user_id){
        try {
            $location_revenue = DB::select(DB::raw("SELECT
            c.company_name as title,
            f.location as location,
            sum(orp.quantity*(1-(orp.discount/100)) * orp.price/100) as revenue
            FROM
            member m, company c,
            fairlocation f, opos_terminal ot,
            opos_receipt r, opos_receiptproduct orp,
            opos_locationterminal olt
            WHERE
            r.terminal_id=ot.id AND orp.receipt_id=r.id
            AND olt.terminal_id=ot.id AND olt.location_id=f.id
            AND f.user_id=c.owner_user_id AND m.user_id=$user_id;"));     
            return $location_revenue;
            } catch (Exception $e) {
            Log::debug($$e->getMessage());
        }
    }


    //Method calculates the revenue of comapany's location based on current date
    public function today_revenue($today,$user_id)
    {
		Log::debug('***** today_revenue('.$today.','.$user_id.')');

        try {
            $location_revenue = DB::select(DB::raw("
			SELECT
				c.company_name as title,
				f.location as location,
				sum(orp.quantity*(1-(orp.discount/100)) * orp.price/100) as revenue
            FROM
				member m, company c,
				fairlocation f, opos_terminal ot,
				opos_receipt r, opos_receiptproduct orp,
				opos_locationterminal olt
            WHERE
				r.terminal_id=ot.id AND orp.receipt_id=r.id
				AND olt.terminal_id=ot.id AND olt.location_id=f.id
				AND f.user_id=c.owner_user_id AND m.user_id=$user_id
				AND DATE(r.created_at)=$today;
			"));     

			Log::debug('location_revenue='.json_encode($location_revenue));
			return $location_revenue;

            } catch (Exception $e) {
				Log::error($e->getMessage());
			}
    }

    //Method caluclate company fair location revenue based on given date ranges
    public function date_based_revenue($start_date,$end_date,$user_id){
        try {
            $location_revenue = DB::select(DB::raw("SELECT
            c.company_name as title,
            f.location as location,
            sum(orp.quantity*(1-(orp.discount/100)) * orp.price/100) as revenue
            FROM
            member m, company c,
            fairlocation f, opos_terminal ot,
            opos_receipt r, opos_receiptproduct orp,
            opos_locationterminal olt
            WHERE
            r.terminal_id=ot.id AND orp.receipt_id=r.id
            AND olt.terminal_id=ot.id AND olt.location_id=f.id
            AND f.user_id=c.owner_user_id AND m.user_id=$user_id AND date(r.created_at) BETWEEN $start_date AND $end_date;"));     
            
            return $location_revenue;
        } catch (Exception $e) {
            Log::debug($$e->getMessage());
        }
    }
    //Method calculate the total revenue of the company
    public function total_company_revenue($location_revenue){
        $total_revenue = 0;
        $company_name =null;
        $temp = array();
            foreach ($location_revenue as $m) {
                $company_name = $m->title;
                $location_revenue=$m->revenue;
                $location_revenue=number_format($location_revenue,2);
                $total_revenue = $total_revenue + $m->revenue;
                $temp = array("title" => $m->location, "revenue" =>$location_revenue );
            }
            $ret = array('title' => $company_name,
                'revenue' => number_format($total_revenue,2), 'locations' => [$temp]);
        return $ret;
    }
}
