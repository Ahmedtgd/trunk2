<?php namespace App\Classes;

use DB;

class SRPayment{

    /**
     * This returns all station recruiter analysis and a specific merchant analysis when sr_id is passed
     * @param $sr_id
     * @return array|null|void
     * @throws CustomException
     */
    public function get_sr($sr_id=null)
    {
        try {
            //get global settings
            if(!$global = DB::table('global')->first()) return;

            //add constraint for a given sr_id else use foreign key
            $extra = $sr_id ? "AND ss.user_id = $sr_id" : "AND ss.user_id = u.id";

            //station recruiter query
            $str = DB::select("
                SELECT s.id as station_id, s.str_sales_staff_commission, s.osmall_commission, s.station_name,
				u.id as str_user_id, concat(u.first_name, ' ', u.last_name) as sr_name, u.id as str_id, u.id as user_id,
				ss.active_date, ss.status as ss_status, sum(p.receivable) as receivable, po.id as porder_id,
				DATE_FORMAT(p.consignment,'%d%b%y %h:%m') as rcv,

				#ss_commission
				case
					when s.str_sales_staff_commission > 0 then s.str_sales_staff_commission
					else $global->str_sales_staff_commission
				end as ss_commission,

				#outstanding
				case
					when s.str_sales_staff_commission > 0 then sum(p.receivable) * s.str_sales_staff_commission
					else sum(p.receivable) * $global->str_sales_staff_commission
				end as outstanding

				FROM sales_staff ss

				LEFT JOIN station s ON ss.id = s.str_sales_staff_id
				LEFT JOIN users u ON ss.user_id = u.id
				LEFT JOIN country c ON u.nationality_country_id = c.id
				LEFT JOIN stationsproduct sp ON s.id = sp.station_id
				LEFT JOIN orderproduct op ON sp.sproduct_id = op.product_id
				LEFT JOIN porder po ON op.porder_id = po.id
				LEFT JOIN sorder so ON s.id = so.station_id AND po.id = so.porder_id
				LEFT JOIN payment p ON p.id = po.payment_id

                WHERE ss.type = 'str'
                AND p.receivable <> 0
                AND po.id NOT IN (
                    SELECT cs_payment_detail.order_id
                    FROM cs_payment, cs_payment_detail
                    WHERE cs_payment.user_id = ss.user_id
                    AND cs_payment.role_id = 10
                    AND cs_payment.id = cs_payment_detail.cs_payment_id
                    AND cs_payment_detail.order_id = po.id
                )

                $extra
            GROUP BY s.id");

        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return is_array($str) ? $str : null;
    }

    public function post_consolidate_sr($sr_ids, $station_ids, $receivables)
    {
        if(!is_array($sr_ids)) return;

        foreach($sr_ids as $sr_id)
        {
            $station_id = $station_ids[$sr_id];
            $station_payment = $receivables[$sr_id];

            $role = 10;
            $today_day = date('d');
            $today_month = date('m');
            $period_start = date('Y-m-');
            $period_end = date('Y-m-');

            if($today_day<=15){
                $period_start .= "01";
                $period_end .= "15";
            } else {
                $period_start .= "16";
                if($today_month == 2){
                    $period_end .= "28";
                } else if($today_month == 1 || $today_month == 3 || $today_month == 5 || $today_month == 7 ||
                    $today_month == 8 || $today_month == 10 || $today_month == 12){
                    $period_end .= "31";
                } else {
                    $period_end .= "30";
                }
            }

            $cs_pay = DB::table('cs_payment')->insertGetId([
                'user_id'=>$sr_id,
                'role_id'=>$role,
                'period_start'=>$period_start,
                'period_end'=>$period_end,
                'amount'=>$station_payment,
                'status'=>'pending',
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

//			$audit_cs_pay = DB::table('audit_cs_payment')->insertGetId([
//				'cs_id'=>$cs_pay,
//				'user_id'=>$station_id,
//				'role_id'=>$station_role,
//				'period_start'=>$period_start,
//				'period_end'=>$period_end,
//				'amount'=>$station_payment,
//				'status'=>'pending',
//				'created_at'=>date("Y-m-d H:i:s"),
//				'updated_at'=>date("Y-m-d H:i:s")
//			]);

            $orders = DB::select("
                SELECT porder.*
                FROM porder, orderproduct, sproduct,stationsproduct, station, sales_staff
                WHERE porder.id = orderproduct.porder_id
                AND orderproduct.product_id = sproduct.product_id
                AND sproduct.id = stationsproduct.sproduct_id
                AND stationsproduct.station_id = station.id
                AND station.str_sales_staff_id = sales_staff.id
                AND sales_staff.user_id = $sr_id
                AND sales_staff.type = 'str'
                AND porder.id NOT IN
                (
                    SELECT cs_payment_detail.order_id
                    FROM cs_payment, cs_payment_detail
                    WHERE cs_payment.user_id = sales_staff.user_id
                    AND cs_payment.role_id = $role
                    AND cs_payment.id = cs_payment_detail.cs_payment_id
                    AND cs_payment_detail.order_id = porder.id
                )
           ");



            foreach($orders as $order)
            {
                $cs_det_pay = DB::table('cs_payment_detail')->insertGetId([
                    'order_id'=>$order->id,
                    'cs_payment_id'=>$cs_pay,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'deleted_at'=>date("Y-m-d H:i:s")
                ]);

//				$audit_cs_det_pay = DB::table('audit_cs_payment_detail')->insertGetId([
//					'cs_id'=>$cs_det_pay,
//					'order_id'=>$orders[$iw]->id,
//					'cs_payment_id'=>$cs_pay,
//					'created_at'=>date("Y-m-d H:i:s"),
//					'deleted_at'=>date("Y-m-d H:i:s")
//				]);

            }

            return true;
        }
    }
}