<?php namespace App\Classes;

use DB;

class SRAnalysis{

    /**
     * This returns all merchant analysis and a specific merchant analysis when mc_id is passed
     * @param $mc_id
     * @return array|null|void
     * @throws CustomException
     */
    public function get_mc_analysis($mc_id=null)
    {
        try {
            //get global settings
            if(!$global = DB::table('global')->first()) return;

            //add constraint for a given mc_id else use foreign key
            $extra = $mc_id ? "AND ss.user_id = $mc_id" : "AND ss.user_id = u.id";

            //merchant analysis query
            $mca = DB::select("
                SELECT u.id as mc_id, CONCAT(u.first_name, ' ', u.last_name) as name, ss.status, ss.created_at as since,
                m.company_name as merchant, m.osmall_commission, m.mc_sales_staff_commission, c.name as country,
                sum(p.receivable) as sales_since, count(m.id) as merchant,

                #revenue_since
                (
                  sum(p.receivable) * m.osmall_commission
                ) as revenue_since,

                #earn_since
                case
					when m.mc_sales_staff_commission > 0 then (m.mc_sales_staff_commission / 100) * sum(p.receivable)
					else $global->mc_sales_staff_commission * sum(p.receivable)
				end as earn_since,

                #outstanding
				case
					when m.mc_sales_staff_commission > 0 then sum(p.receivable) * m.mc_sales_staff_commission
					else sum(p.receivable) * $global->mc_sales_staff_commission
				end as outstanding,

                #mp
				case
					when (m.mcp1_sales_staff_id <> 0 && m.mcp1_sales_staff_id  <> 0) then count(m.id)
					else 0
				end as mp,

                #sales_ytd
                (
				    SELECT SUM(p.receivable)
				    FROM sales_staff ss, merchant m, users u, merchantproduct mp, orderproduct op, porder po, payment p
				    WHERE po.created_at >= concat(year(curdate()),'-01-01')
				    AND ss.id = m.mc_sales_staff_id AND u.id = ss.user_id AND m.id = mp.merchant_id
				    AND op.product_id = mp.product_id AND po.id = op.porder_id  AND p.id = po.payment_id
				    AND ss.type = 'mct' AND ss.user_id = u.id
				) as sales_ytd,

                #revenue_ytd
				(
				    SELECT SUM(p.receivable) * m.osmall_commission
				    FROM sales_staff ss, merchant m, users u, merchantproduct mp, orderproduct op, porder po, payment p
				    WHERE po.created_at >= concat(year(curdate()),'-01-01')
				    AND ss.id = m.mc_sales_staff_id AND u.id = ss.user_id AND m.id = mp.merchant_id
				    AND op.product_id = mp.product_id AND po.id = op.porder_id  AND p.id = po.payment_id
				    AND ss.type = 'mct' AND ss.user_id = u.id
				) as revenue_ytd,

                #earn_ytd
				(
				    SELECT (
				        case
                            when m.mc_sales_staff_commission > 0 then m.mc_sales_staff_commission * sum(p.receivable)
                            else $global->mc_sales_staff_commission * sum(p.receivable)
                        end
				    ) as earn_ytd
				    FROM sales_staff ss, merchant m, users u, merchantproduct mp, orderproduct op, porder po, payment p
				    WHERE po.created_at >= concat(year(curdate()),'-01-01')
				    AND ss.id = m.mc_sales_staff_id AND u.id = ss.user_id AND m.id = mp.merchant_id
				    AND op.product_id = mp.product_id AND po.id = op.porder_id  AND p.id = po.payment_id
				    AND ss.type = 'mct' AND ss.user_id = u.id
				) as earn_ytd

				FROM sales_staff ss

				LEFT JOIN merchant m ON ss.id = m.mc_sales_staff_id
				LEFT JOIN users u ON u.id = ss.user_id
				LEFT JOIN country c ON u.nationality_country_id = c.id

				LEFT JOIN merchantproduct mp ON m.id = mp.merchant_id
				LEFT JOIN orderproduct op ON op.product_id = mp.product_id
				LEFT JOIN porder po ON po.id = op.porder_id
				LEFT JOIN payment p ON p.id = po.payment_id

				WHERE ss.type = 'mct'

				$extra
            ");

        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        $mca = is_array($mca) && !empty($mca) ? $mca : null;
        return $mca;
    }

	/**
	 * This returns all station recruiter analysis and a specific sr analysis when sr_id is passed
	 * @param $sr_id
	 * @return array|null|void
	 * @throws CustomException
	 */
	public function get_sr_analysis($sr_id=null)
	{
		try {
			//get global settings
			if(!$global = DB::table('global')->first()) return;

			//add constraint for a given sr_id else use foreign key
			$extra = $sr_id ? "AND ss.user_id = $sr_id" : "AND ss.user_id = u.id";

			//station recruiter analysis query
			$str = DB::select("
                SELECT s.id as station_id, u.id as sr_id, CONCAT(u.first_name, ' ', u.last_name) as name, ss.status,
                ss.created_at as since, ss.active_date, s.station_name, s.osmall_commission, s.str_sales_staff_commission,
                c.name as country, p.receivable, sum(p.receivable) as sales_since,

                #revenue_since
                (
                  sum(p.receivable) * s.osmall_commission
                ) as revenue_since,

                #earn_since
                case
					when s.str_sales_staff_commission > 0 then (s.str_sales_staff_commission / 100) * sum(p.receivable)
					else  sum(p.receivable) * $global->str_sales_staff_commission
				end as earn_since,

                #outstanding
				case
					when s.str_sales_staff_commission > 0 then sum(p.receivable) * s.str_sales_staff_commission
					else sum(p.receivable) * $global->str_sales_staff_commission
				end as outstanding,

				#sales_ytd
                (
				    SELECT SUM(p.receivable)
				    FROM sales_staff ss
				    LEFT JOIN station s ON ss.id = s.str_sales_staff_id LEFT JOIN users u ON ss.user_id = u.id
				    LEFT JOIN country c ON u.nationality_country_id = c.id LEFT JOIN stationsproduct sp ON s.id = sp.station_id
				    LEFT JOIN orderproduct op ON sp.sproduct_id = op.product_id LEFT JOIN porder po ON po.id = op.porder_id
				    LEFT JOIN sorder so ON s.id = so.station_id AND po.id = so.porder_id LEFT JOIN payment p ON p.id = po.payment_id
					WHERE ss.type = 'str' AND po.created_at >= concat(year(curdate()),'-01-01') $extra
				) as sales_ytd,


				#revenue_ytd
				(
				    SELECT SUM(p.receivable) * s.osmall_commission
					FROM sales_staff ss
				    LEFT JOIN station s ON ss.id = s.str_sales_staff_id LEFT JOIN users u ON ss.user_id = u.id
				    LEFT JOIN country c ON u.nationality_country_id = c.id LEFT JOIN stationsproduct sp ON s.id = sp.station_id
				    LEFT JOIN orderproduct op ON sp.sproduct_id = op.product_id LEFT JOIN porder po ON po.id = op.porder_id
				    LEFT JOIN sorder so ON s.id = so.station_id AND po.id = so.porder_id LEFT JOIN payment p ON p.id = po.payment_id
					WHERE ss.type = 'str' AND po.created_at >= concat(year(curdate()),'-01-01') $extra
				) as revenue_ytd,

                #earn_ytd
				(
				    SELECT (
				        case
                            when s.mc_sales_staff_commission > 0 then s.mc_sales_staff_commission * sum(p.receivable)
                            else $global->str_sales_staff_commission * sum(p.receivable)
                        end
				    ) as earn_ytd
					FROM sales_staff ss
				    LEFT JOIN station s ON ss.id = s.str_sales_staff_id LEFT JOIN users u ON ss.user_id = u.id
				    LEFT JOIN country c ON u.nationality_country_id = c.id LEFT JOIN stationsproduct sp ON s.id = sp.station_id
				    LEFT JOIN orderproduct op ON sp.sproduct_id = op.product_id LEFT JOIN porder po ON po.id = op.porder_id
				    LEFT JOIN sorder so ON s.id = so.station_id AND po.id = so.porder_id LEFT JOIN payment p ON p.id = po.payment_id
					WHERE ss.type = 'str' AND po.created_at >= concat(year(curdate()),'-01-01') $extra
				) as earn_ytd

				FROM sales_staff ss

				LEFT JOIN station s ON ss.id = s.str_sales_staff_id
				LEFT JOIN users u ON ss.user_id = u.id
				LEFT JOIN country c ON u.nationality_country_id = c.id
				LEFT JOIN stationsproduct sp ON s.id = sp.station_id
				LEFT JOIN orderproduct op ON sp.sproduct_id = op.product_id
				LEFT JOIN porder po ON po.id = op.porder_id
				LEFT JOIN sorder so ON s.id = so.station_id AND po.id = so.porder_id
				LEFT JOIN payment p ON p.id = po.payment_id

				WHERE ss.type = 'str'

				$extra
            ");

		} catch(QueryException $e){
			throw new CustomException($e->getMessage());
		}

		return is_array($str) ? $str : null;
	}
}