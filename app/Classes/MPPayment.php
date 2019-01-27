<?php namespace App\Classes;

use DB;

class MPPayment{

    /**
     * This returns all station recruiter analysis and a specific merchant analysis when mp_id is passed
     * @param $mp_id
     * @return array|null|void
     * @throws CustomException
     */
    public function get_mp($mp_id=null)
    {
        try {
            //get global settings
            if(!$global = DB::table('global')->first()) return;

            //add constraint for a given mp_id else use foreign key
            $extra = $mp_id ? "AND ss.user_id = $mp_id" : "AND ss.user_id = u.id";

            //station recruiter query
            $mcp = DB::select("
                SELECT m.id as merchant_id, m.mcp1_sales_staff_id, m.mcp2_sales_staff_id, u.id as mcp_user_id,
                concat(u.first_name, ' ', u.last_name) as name, u.id as mp_id, u.id as user_id,
				ss.status as ss_status, po.id as order_id,

				#rate
				case
				    when ss.commission>0 then ss.commission
				    else (
				     if(m.mcp1_sales_staff_commission > 0, m.mcp1_sales_staff_commission/100, $global->mcp1_sales_staff_commission)
				    )
				end as rate,


				#revenue
				sum(
				    case
				        when cp.id IS NULL then p.receivable else 0
				    end
                ) as revenue,

				#recievable
				case
                    when ss.commission > 0 then
                    (
                        if(cp.id IS NULL, (ss.commission/100) * p.receivable, 0 )
                    )else(
                        if(
                            m.mcp1_sales_staff_commission > 0,
                            (m.mcp1_sales_staff_commission/100)*SUM(CASE WHEN cp.id IS NULL THEN p.receivable ELSE 0 END),
                            ($global->mcp1_sales_staff_commission/100)*SUM(CASE WHEN cp.id IS NULL THEN p.receivable ELSE 0 END)
                         )
                    )
				end as receivable,

				#outstanding
				case
					when m.mcp1_sales_staff_commission > 0 then sum(p.receivable) * m.mcp1_sales_staff_commission
					else sum(p.receivable) * $global->mcp1_sales_staff_commission
				end as outstanding

				FROM sales_staff ss

				LEFT JOIN users u ON u.id = ss.user_id
				LEFT JOIN merchant m ON (ss.id = m.mcp1_sales_staff_id OR ss.id = m.mcp2_sales_staff_id)
				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id
				LEFT JOIN porder po ON po.id = op.porder_id
				LEFT JOIN commissionpaid cp ON po.id = cp.porder_id AND cp.user_id = u.id
				LEFT JOIN payment p ON p.id = po.payment_id

                WHERE ss.type = 'mcp'
                AND p.receivable <> 0

                $extra

                AND po.id NOT IN (
                    SELECT cs_payment_detail.order_id
                    FROM cs_payment, cs_payment_detail
                    WHERE cs_payment.user_id = ss.user_id
                    AND cs_payment.role_id = 7
                    AND cs_payment.id = cs_payment_detail.cs_payment_id
                    AND cs_payment_detail.order_id = po.id
                )
            GROUP BY ss.id");

        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return is_array($mcp) ? $mcp : null;
    }

    public function post_consolidate_mp($mp_ids, $merchant_ids, $receivables)
    {
        if(!is_array($mp_ids)) return;

        foreach($mp_ids as $mp_id)
        {
            $merchant_id = $merchant_ids[$mp_id];
            $merchant_payment = $receivables[$mp_id];

            $role = 7;
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
                'user_id'=>$mp_id,
                'role_id'=>$role,
                'period_start'=>$period_start,
                'period_end'=>$period_end,
                'amount'=>$merchant_payment,
                'status'=>'pending',
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);

//			$audit_cs_pay = DB::table('audit_cs_payment')->insertGetId([
//				'cs_id'=>$cs_pay,
//				'user_id'=>$merchant_id,
//				'role_id'=>$merchant_role,
//				'period_start'=>$period_start,
//				'period_end'=>$period_end,
//				'amount'=>$merchant_payment,
//				'status'=>'pending',
//				'created_at'=>date("Y-m-d H:i:s"),
//				'updated_at'=>date("Y-m-d H:i:s")
//			]);

            $orders = DB::select("
                SELECT po.*
                FROM sales_staff ss

				LEFT JOIN users u ON u.id = ss.user_id
				LEFT JOIN merchant m ON (ss.id = m.mcp1_sales_staff_id OR ss.id = m.mcp2_sales_staff_id)
				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id
				LEFT JOIN porder po ON po.id = op.porder_id
				LEFT JOIN commissionpaid cp ON po.id = cp.porder_id AND cp.user_id = u.id
				LEFT JOIN payment p ON p.id = po.payment_id

                WHERE ss.type = 'mcp'
                AND ss.user_id = $mp_id
                AND m.id = $merchant_id
                AND p.receivable <> 0
                AND po.id NOT IN (
                    SELECT cs_payment_detail.order_id
                    FROM cs_payment, cs_payment_detail
                    WHERE cs_payment.user_id = ss.user_id
                    AND cs_payment.role_id = 7
                    AND cs_payment.id = cs_payment_detail.cs_payment_id
                    AND cs_payment_detail.order_id = po.id
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

    public function get_mp_analysis($mp_id=null)
    {
        try {
            //get global settings
            if(!$global = DB::table('global')->first()) return;

            //add constraint for a given mp_id else use foreign key
            $extra = $mp_id ? "AND ss.user_id = $mp_id" : "AND ss.user_id = u.id";

            //analysis query
            $mcp = DB::select("
                SELECT m.id as merchant_id, u.id as mp_id, CONCAT(u.first_name, ' ', u.last_name) as name, ss.status,
                ss.created_at as since, m.osmall_commission, c.name as country, p.receivable, sum(p.receivable) as sales_since,
                u.id as user_id, ss.status as ss_status, po.id as order_id, count(m.id) as merchant,

                #revenue_since
                (
                  sum(p.receivable) * m.osmall_commission
                ) as revenue_since,

                #earn_since
                case
					when m.mcp1_sales_staff_commission > 0 then (m.mcp1_sales_staff_commission / 100) * sum(p.receivable)
					else  sum(p.receivable) * $global->mcp1_sales_staff_commission
				end as earn_since,


				#revenue
				sum(
				    case
				        when cp.id IS NULL then p.receivable else 0
				    end
                ) as revenue,


				#recievable
				case
                    when ss.commission > 0 then
                    (
                        if(cp.id IS NULL, (ss.commission/100) * p.receivable, 0 )
                    )else(
                        if(
                            m.mcp1_sales_staff_commission > 0,
                            (m.mcp1_sales_staff_commission/100)*SUM(CASE WHEN cp.id IS NULL THEN p.receivable ELSE 0 END),
                            ($global->mcp1_sales_staff_commission/100)*SUM(CASE WHEN cp.id IS NULL THEN p.receivable ELSE 0 END)
                         )
                    )
				end as receivable,

				#outstanding
				case
					when m.mcp1_sales_staff_commission > 0 then sum(p.receivable) * m.mcp1_sales_staff_commission
					else sum(p.receivable) * $global->mcp1_sales_staff_commission
				end as outstanding,

				#sales_ytd
                (
				    SELECT SUM(p.receivable)
				    FROM sales_staff ss
                    LEFT JOIN users u ON u.id = ss.user_id LEFT JOIN merchant m ON (ss.id = m.mcp1_sales_staff_id OR ss.id = m.mcp2_sales_staff_id)
                    LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id LEFT JOIN orderproduct op ON op.product_id = mp.product_id
                    LEFT JOIN porder po ON po.id = op.porder_id LEFT JOIN commissionpaid cp ON po.id = cp.porder_id AND cp.user_id = u.id
                    LEFT JOIN payment p ON p.id = po.payment_id WHERE ss.type = 'mcp' AND po.created_at >= concat(year(curdate()),'-01-01')
                    $extra
				) as sales_ytd,


				 #revenue_ytd
				(
				    SELECT SUM(p.receivable) * m.osmall_commission
				    FROM sales_staff ss
                    LEFT JOIN users u ON u.id = ss.user_id LEFT JOIN merchant m ON (ss.id = m.mcp1_sales_staff_id OR ss.id = m.mcp2_sales_staff_id)
                    LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id LEFT JOIN orderproduct op ON op.product_id = mp.product_id
                    LEFT JOIN porder po ON po.id = op.porder_id LEFT JOIN commissionpaid cp ON po.id = cp.porder_id AND cp.user_id = u.id
                    LEFT JOIN payment p ON p.id = po.payment_id WHERE ss.type = 'mcp' AND po.created_at >= concat(year(curdate()),'-01-01')
                    $extra
				) as revenue_ytd,

                #earn_ytd
				(
				    SELECT (
				        case
                            when m.mcp1_sales_staff_commission > 0 then m.mcp1_sales_staff_commission * sum(p.receivable)
                            else $global->mcp1_sales_staff_commission * sum(p.receivable)
                        end
				    ) as earn_ytd

				    FROM sales_staff ss
                    LEFT JOIN users u ON u.id = ss.user_id LEFT JOIN merchant m ON (ss.id = m.mcp1_sales_staff_id OR ss.id = m.mcp2_sales_staff_id)
                    LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id LEFT JOIN orderproduct op ON op.product_id = mp.product_id
                    LEFT JOIN porder po ON po.id = op.porder_id LEFT JOIN commissionpaid cp ON po.id = cp.porder_id AND cp.user_id = u.id
                    LEFT JOIN payment p ON p.id = po.payment_id WHERE ss.type = 'mcp' AND po.created_at >= concat(year(curdate()),'-01-01')
                    $extra
				) as earn_ytd



				FROM sales_staff ss

				LEFT JOIN users u ON u.id = ss.user_id
				LEFT JOIN country c ON u.nationality_country_id = c.id
				LEFT JOIN merchant m ON (ss.id = m.mcp1_sales_staff_id OR ss.id = m.mcp2_sales_staff_id)
				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id
				LEFT JOIN porder po ON po.id = op.porder_id
				LEFT JOIN commissionpaid cp ON po.id = cp.porder_id AND cp.user_id = u.id
				LEFT JOIN payment p ON p.id = po.payment_id

                WHERE ss.type = 'mcp'
                AND p.receivable <> 0

                $extra

                AND po.id NOT IN (
                    SELECT cs_payment_detail.order_id
                    FROM cs_payment, cs_payment_detail
                    WHERE cs_payment.user_id = ss.user_id
                    AND cs_payment.role_id = 7
                    AND cs_payment.id = cs_payment_detail.cs_payment_id
                    AND cs_payment_detail.order_id = po.id
                )

            GROUP BY ss.id ");

        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return is_array($mcp) ? $mcp : null;
    }

}