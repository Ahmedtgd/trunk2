<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 2/18/16
 * Time: 7:08 PM
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

	function get_all(){
            $sales = $this->salesByCountryall();
			$merchants = $this->merchantByCountryall();
			$stations = $this->stationByCountryall();
			$buyer_registered = $this->buyerRegisteredall();
			$activebuyer = $this->activeBuyerall();
			$smmrecruited = $this->SMMRecruitedall();
			$mc_recruited = $this->mcRecruitedall();
			$product_registered = $this->productRegisteredall();
			$active_product = $this->productActiveall();
			$returns = $this->returnsall();
            return view('admin.adminSummary',['sales'=>$sales, 'merchants'=> $merchants, 'stations'=> $stations, 'buyer_registered'=> $buyer_registered, 'activebuyer'=> $activebuyer,  'smmrecruited'=> $smmrecruited, 'mc_recruited'=> $mc_recruited, 'product_registered'=> $product_registered, 'active_product'=> $active_product, 'returns' => $returns]);
	}

	function salesByCountryall()
    {
        $sales = DB::Select("
              SELECT cc.name country,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAYY,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= SUBDATE(CURDATE(), WEEKDAY(CURDATE())) THEN 1 ELSE 0 END),2) WTD,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') THEN 1 ELSE 0 END),2) MTD,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) AND DATE_FORMAT(ss.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) YTD
                FROM
                    payment ss,
                    porder o,
                    users u,
                    address a,
                    city c,
                    country cc
                WHERE
                    o.payment_id = ss.id
                        and  o.user_id = u.id
                        AND IFNULL(u.default_address_id,
                            IFNULL(u.billing_address_id,
                                    u.shipping_address_id)) = a.id
                        AND a.city_id = c.id
                        AND c.country_code = cc.code
                group by cc.name
                ");

        return $sales;

    }
	
	function merchantByCountryall()
    {
        $merchants = DB::select(
            "SELECT cc.name country,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAY_Head,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') = CURDATE() THEN p.receivable ELSE 0 END),2) as DAYY,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= SUBDATE(CURDATE(), WEEKDAY(CURDATE())) THEN 1 ELSE 0 END),2) as WTD_Head,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= SUBDATE(CURDATE(), WEEKDAY(CURDATE())) THEN p.receivable ELSE 0 END),2) as WTD,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') THEN 1 ELSE 0 END),2) as MTD_Head,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') THEN p.receivable ELSE 0 END),2) as MTD,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) THEN 1 ELSE 0 END),2) as YTD_Head,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) THEN p.receivable ELSE 0 END),2) as YTD
                FROM
                    porder o,
                    users u,
                    payment p,
                    merchant m,
                    country cc
                WHERE
                    o.user_id = u.id
                    AND u.id = m.user_id
                    AND m.country_id = cc.id
                    AND o.payment_id = p.id
                GROUP BY cc.name
            "
        );
        return $merchants;

    }

    function stationByCountryall()
    {
        $buyer_registered = DB::select("
        SELECT
                cc.name country,
				ROUND(SUM(CASE WHEN DATE_FORMAT(s.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAY_Head,
				ROUND(SUM(CASE WHEN DATE_FORMAT(s.created_at, '%Y-%m-%d') >= SUBDATE(CURDATE(), WEEKDAY(CURDATE())) THEN 1 ELSE 0 END),2) as WTD_Head,
				ROUND(SUM(CASE WHEN DATE_FORMAT(s.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') THEN 1 ELSE 0 END),2) as MTD_Head,
				ROUND(SUM(CASE WHEN DATE_FORMAT(s.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) THEN 1 ELSE 0 END),2) as YTD_Head
		FROM
			porder o,
			users u,
			payment p,
			station s,
			country cc
		WHERE
			o.user_id = u.id
			AND u.id = s.user_id
			AND s.country_id = cc.id
			AND o.payment_id = p.id
		GROUP BY cc.name
        ");
        return $buyer_registered;
    }		
	
    function buyerRegisteredall()
    {
        $buyer_registered = DB::select("
        SELECT
                cc.name country,
                ROUND(SUM(CASE WHEN DATE_FORMAT(b.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAYY,
                ROUND(SUM(CASE WHEN DATE_FORMAT(b.created_at, '%Y-%m-%d') >= SUBDATE(CURDATE(), WEEKDAY(CURDATE())) THEN 1 ELSE 0 END),2) WTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(b.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') THEN 0 ELSE 0 END),2) MTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(b.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) THEN 1 ELSE 0 END),2) YTD
            FROM
                buyer b,
                users u,
                address a,
                city c,
                country cc
            WHERE
                b.user_id = u.id
                    AND IFNULL(u.default_address_id,
                        IFNULL(u.billing_address_id,
                                u.shipping_address_id)) = a.id
                    AND a.city_id = c.id
                    AND c.country_code = cc.code
                    group by cc.name
        ");
        return $buyer_registered;
    }	
	
    function activeBuyerall()
    {
        $active_buyer = DB::select("
        SELECT
                cc.name country,
                ROUND(SUM(CASE WHEN b.created_at = CURDATE() THEN 1 ELSE 0 END),2) DAY_Head,
                ROUND(SUM(CASE WHEN b.created_at = CURDATE() THEN p.receivable ELSE 0 END), 2) DAYY,
                ROUND(SUM(CASE WHEN b.created_at >= SUBDATE(CURDATE(), WEEKDAY(CURDATE())) THEN 1 ELSE 0 END),2) WTD_Head,
                ROUND(SUM(CASE WHEN b.created_at >= SUBDATE(CURDATE(), WEEKDAY(CURDATE())) THEN p.receivable ELSE 0 END),2) WTD,
                ROUND(SUM(CASE WHEN b.created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01') THEN 0 ELSE 0 END),2) MTD_Head,
                ROUND(SUM(CASE WHEN b.created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01') THEN p.receivable ELSE 0 END),2) MTD,
                ROUND(SUM(CASE WHEN b.created_at >= MAKEDATE(YEAR(NOW()), 1) THEN 1 ELSE 0 END),2) YTD_Head,
                ROUND(SUM(CASE WHEN b.created_at >= MAKEDATE(YEAR(NOW()), 1) THEN p.receivable ELSE 0 END),2) YTD
            FROM
                porder o,
                users u,
                buyer b,
                payment p,
                address a,
                city c,
                country cc
            WHERE
                o.user_id = u.id AND u.id = b.user_id
                    AND o.payment_id = p.id
                    AND IFNULL(u.default_address_id,
                        IFNULL(u.billing_address_id,
                                u.shipping_address_id)) = a.id
                    AND a.city_id = c.id
                    AND c.country_code = cc.code
            GROUP BY cc.name
        ");
        return $active_buyer;
    }	
	
    function SMMRecruitedall()
    {
        $smmrecruited = DB::select(
            " SELECT cc.name country,
                       ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAYY,
                       ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >=SUBDATE(CURDATE(), WEEKDAY(CURDATE())) THEN 1 ELSE 0 END),2) WTD,
                       ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') THEN 1 ELSE 0 END),2) MTD,
                       ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) THEN 1 ELSE 0 END),2) YTD
                FROM
                  sales_staff ss,
                  users u,
                  address a,
                  city c,
                  country cc
                WHERE
                  ss.user_id = u.id
                  AND IFNULL(u.default_address_id,
                             IFNULL(u.billing_address_id,
                                    u.shipping_address_id)) = a.id
                  AND a.city_id = c.id
                  AND c.country_code = cc.code
                  AND ss.type='smm'
                group by cc.name
            "
        );
        return $smmrecruited;
    }	
	
    function mcRecruitedall()
    {
        $mc_recruited = DB::select("
        SELECT
                cc.name country,
                ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAYY,
                ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= SUBDATE(CURDATE(), WEEKDAY(CURDATE())) THEN 1 ELSE 0 END),2) WTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') THEN 0 ELSE 0 END),2) MTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) THEN 1 ELSE 0 END),2) YTD
            FROM
                sales_staff ss,
                users u,
                address a,
                city c,
                country cc
            WHERE
                ss.user_id = u.id
                    AND IFNULL(u.default_address_id,
                        IFNULL(u.billing_address_id,
                                u.shipping_address_id)) = a.id
                    AND a.city_id = c.id
                    AND c.country_code = cc.code
               group by cc.name
        ");
        return $mc_recruited;
    }	
	
    function productRegisteredall()
    {
        $product_registered = DB::select("
        SELECT  cc.name country,
                ROUND(SUM(CASE WHEN DATE_FORMAT(p.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAYY,
                ROUND(SUM(CASE WHEN DATE_FORMAT(p.created_at, '%Y-%m-%d') >= SUBDATE(CURDATE(), WEEKDAY(CURDATE())) THEN 1 ELSE 0 END),2) WTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(p.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') THEN 0 ELSE 0 END),2) MTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(p.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) THEN 1 ELSE 0 END), 2) YTD
            FROM
                product p,
                merchantproduct mp,
                merchant m,
                address a,
                city c,
                country cc
            WHERE
                p.id = mp.product_id
                    AND mp.merchant_id = m.id
                    AND m.oshop_address_id = a.id
                    AND a.city_id = c.id
                    AND c.country_code = cc.code
            GROUP BY cc.name
        ");

        return $product_registered;
    }	
	
    function productActiveall()
    {
        $product_active = DB::select("
			SELECT 
				COUNT(distinct product.id) as item, 
				COUNT(distinct orderproduct.product_id) as active, 
				country.name as country 
			FROM product 
			LEFT JOIN orderproduct ON orderproduct.product_id=product.id AND orderproduct.created_at >= concat(year(curdate()),'-01-01') 
			LEFT JOIN merchantproduct ON orderproduct.product_id=merchantproduct.product_id 
			LEFT JOIN merchant ON merchantproduct.merchant_id=merchant.id
			LEFT JOIN address ON merchant.address_id=address.id 
			LEFT JOIN city ON address.city_id=city.id 
			LEFT JOIN country ON city.country_code=country.code WHERE product.created_at >= concat(year(curdate()),'-01-01') 
			GROUP BY country.name 
			ORDER BY country.name
        ");

        return $product_active;
    }	
	
    function returnsall()
    {
        $returns = DB::select("
			SELECT 
				ROUND(SUM(CASE WHEN DATE_FORMAT(buyer_help.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAYY, 
				ROUND(SUM(CASE WHEN DATE_FORMAT(buyer_help.created_at, '%Y-%m-%d') >= SUBDATE(CURDATE(), WEEKDAY(CURDATE())) THEN 1 ELSE 0 END),2) WEEK, ROUND(SUM(CASE WHEN DATE_FORMAT(buyer_help.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') THEN 1 ELSE 0 END),2) MONTH, ROUND(SUM(CASE WHEN DATE_FORMAT(buyer_help.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) THEN 1 ELSE 0 END),2) YEARS, 
				country.name as country 
			FROM buyer_help 
				LEFT JOIN porder ON porder.id = buyer_help.porder_id 
				LEFT JOIN users ON porder.user_id = users.id 
				LEFT JOIN country ON users.nationality_country_id = country.id 
			GROUP BY country.name
        ");

        return $returns;
    }		
	
/************ OLD CODE ****************/
	
    function getSales($year)
    {
        $month = DB::table('porder')
            ->join('payment', 'porder.payment_id', '=', 'payment.id')
            ->where(DB::raw("DATE_FORMAT(porder.created_at,'%Y')"), '=', $year)
            ->groupBy(DB::raw("DATE_FORMAT(porder.created_at,'%M')"))
            ->select(DB::raw('DATE_FORMAT(porder.created_at,\'%M\') as month'),
                DB::raw('SUM(payment.receivable) as revenu'))
            ->get();
        $cat = array();
        $data = array();
        $jdata = array();
        if (isset($month)) {
            foreach ($month as $sale) {
                $cat[] = $sale->month;
                $data[] = intval($sale->revenu);
            }
        }
        $jdata[] = $cat;
        $jdata[] = $data;
        return json_encode($jdata);
    }

    function monthlySales()
    {   $currency = Currency::where('active',true)->first()->value('code');
        $views = DB::select("select Sum(product.views) views from product");
        $aggSale = $this->getSaleAggregates();
        $yarSale = $this->yearlyMonthSale();
        return view('admin.graphReport', [
            'aggSale' => $aggSale,
            'sale' => $yarSale,
            'view' => $views[0],
            'currency'=>$currency
        ]);
    }

    function getSaleAggregates()
    {
        $aggregate = DB::select(
            "select Max(payment.receivable) max,
                    min(payment.receivable) min,
                    Sum(payment.receivable)/count(*) Average_Deal,
                    Sum(payment.receivable)/datediff(max(payment.created_at),min(payment.created_at)) Average_day
              from porder , payment
             where porder.payment_id = payment.id
            "
        );

        return $aggregate;
    }

    function yearlyMonthSale()
    {
        $year = DB::Select("Select DATE_FORMAT(porder.created_at,'%Y') year,
	                              Sum(payment.receivable) revenu,
	                              null month
                              from  porder , payment
                              where payment.id = porder.payment_id
                           Group By DATE_FORMAT(porder.created_at,'%Y')"
        );

        $temp = array();
        foreach ($year as $y) {

            $month = $this->monthSale($y->year);
            $y->month = $month;
            $temp[] = $y;

        }
        return $temp;
    }

    function monthSale($pyear)
    {
        $month = DB::Select("Select DATE_FORMAT(porder.created_at,'%M') month,
	                                Sum(payment.receivable) revenu
                                from  porder , payment
                                where payment.id = porder.payment_id
                                  and DATE_FORMAT(porder.created_at,'%Y') = $pyear
                              Group By DATE_FORMAT(porder.created_at,'%M');");
        return $month;
    }

    function getReportData($identifier)
    {
        $result = null;

        if ($identifier == 'merchants') {
            $result = $this->merchantByCountry();
            return $result;
        } elseif ($identifier == 'activebuyer') {
            $result = $this->activeBuyer();
            return $result;
        } elseif ($identifier == 'mcrecruited') {
            $result = $this->mcRecruited();
            return $result;
        } elseif ($identifier == 'smmrecruited') {
            $result = $this->SMMRecruited();
            return $result;
        } elseif ($identifier == 'sales') {
            $result = $this->salesByCountry();
            return $result;
        } elseif ($identifier == 'productregistered') {
            $result = $this->productRegistered();
            return $result;
        } elseif ($identifier == 'buyerregistered') {
            $result = $this->buyerRegistered();
            return $result;
        }

    }

    function merchantByCountry()
    {
        $merchants = DB::select(
            "SELECT cc.name country,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAY_Head,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') = CURDATE() THEN p.receivable ELSE 0 END),2) as DAYY,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= ADDDATE(CURDATE(),INTERVAL - WEEKDAY(CURDATE()) DAY) AND DATE_FORMAT(m.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) as WTD_Head,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= ADDDATE(CURDATE(),INTERVAL - WEEKDAY(CURDATE()) DAY) AND DATE_FORMAT(m.created_at, '%Y-%m-%d') <= CURDATE() THEN p.receivable ELSE 0 END),2) as WTD,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND DATE_FORMAT(m.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) as MTD_Head,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND DATE_FORMAT(m.created_at, '%Y-%m-%d') <= CURDATE() THEN p.receivable ELSE 0 END),2) as MTD,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) AND DATE_FORMAT(m.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) as YTD_Head,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(m.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) AND DATE_FORMAT(m.created_at, '%Y-%m-%d') <= CURDATE() THEN p.receivable ELSE 0 END),2) as YTD
                FROM
                    porder o,
                    users u,
                    payment p,
                    merchant m,
                    country cc
                WHERE
                    o.user_id = u.id
                    AND u.id = m.user_id
                    AND m.country_id = cc.id
                    AND o.payment_id = p.id
                GROUP BY cc.name
            "
        );
        return view('admin.CountryMerchant',['merchants'=>$merchants]);

    }

    function activeBuyer()
    {
        $active_buyer = DB::select("
        SELECT
                cc.name country,
                ROUND(SUM(CASE WHEN b.created_at = CURDATE() THEN 1 ELSE 0 END),2) DAY_Head,
                ROUND(SUM(CASE WHEN b.created_at = CURDATE() THEN p.receivable ELSE 0 END), 2) DAYY,
                ROUND(SUM(CASE WHEN b.created_at >= ADDDATE(CURDATE(),INTERVAL - WEEKDAY(CURDATE()) DAY) AND b.created_at <= CURDATE() THEN 1 ELSE 0 END),2) WTD_Head,
                ROUND(SUM(CASE WHEN b.created_at >= ADDDATE(CURDATE(),INTERVAL - WEEKDAY(CURDATE()) DAY) AND b.created_at <= CURDATE() THEN p.receivable ELSE 0 END),2) WTD,
                ROUND(SUM(CASE WHEN b.created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND b.created_at <= CURDATE() THEN 0 ELSE 0 END),2) MTD_Head,
                ROUND(SUM(CASE WHEN b.created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND b.created_at <= CURDATE() THEN p.receivable ELSE 0 END),2) MTD,
                ROUND(SUM(CASE WHEN b.created_at >= MAKEDATE(YEAR(NOW()), 1) AND b.created_at <= CURDATE() THEN 1 ELSE 0 END),2) YTD_Head,
                ROUND(SUM(CASE WHEN b.created_at >= MAKEDATE(YEAR(NOW()), 1) AND b.created_at <= CURDATE() THEN p.receivable ELSE 0 END),2) YTD
            FROM
                porder o,
                users u,
                buyer b,
                payment p,
                address a,
                city c,
                country cc
            WHERE
                o.user_id = u.id AND u.id = b.user_id
                    AND o.payment_id = p.id
                    AND IFNULL(u.default_address_id,
                        IFNULL(u.billing_address_id,
                                u.shipping_address_id)) = a.id
                    AND a.city_id = c.id
                    AND c.country_code = cc.code
            GROUP BY cc.name
        ");
        return view('admin.CountryActiveBuyer',['activeBuyer'=>$active_buyer]);
    }

    function mcRecruited()
    {
        $mc_recruited = DB::select("
        SELECT
                cc.name country,
                ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAYY,
                ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= ADDDATE(CURDATE(),INTERVAL - WEEKDAY(CURDATE()) DAY) AND DATE_FORMAT(ss.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) WTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND DATE_FORMAT(ss.created_at, '%Y-%m-%d') <= CURDATE() THEN 0 ELSE 0 END),2) MTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) AND DATE_FORMAT(ss.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) YTD
            FROM
                sales_staff ss,
                users u,
                address a,
                city c,
                country cc
            WHERE
                ss.user_id = u.id
                    AND IFNULL(u.default_address_id,
                        IFNULL(u.billing_address_id,
                                u.shipping_address_id)) = a.id
                    AND a.city_id = c.id
                    AND c.country_code = cc.code
               group by cc.name
        ");
        return view('admin.CountryMCRecruited',['mcRecruited'=>$mc_recruited]);
    }

    function SMMRecruited()
    {
        $smmrecruited = DB::select(
            " SELECT cc.name country,
                       ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAYY,
                       ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= ADDDATE(CURDATE(),INTERVAL - WEEKDAY(CURDATE()) DAY) AND DATE_FORMAT(ss.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) WTD,
                       ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND DATE_FORMAT(ss.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) MTD,
                       ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) AND DATE_FORMAT(ss.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) YTD
                FROM
                  sales_staff ss,
                  users u,
                  address a,
                  city c,
                  country cc
                WHERE
                  ss.user_id = u.id
                  AND IFNULL(u.default_address_id,
                             IFNULL(u.billing_address_id,
                                    u.shipping_address_id)) = a.id
                  AND a.city_id = c.id
                  AND c.country_code = cc.code
                  AND ss.type='smm'
                group by cc.name
            "
        );
        return view('admin.CountrySMMRecruited',['smmRecruited'=>$smmrecruited]);
    }

    function salesByCountry()
    {
        $sales = DB::Select("
              SELECT cc.name country,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAYY,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= ADDDATE(CURDATE(),INTERVAL - WEEKDAY(CURDATE()) DAY) AND DATE_FORMAT(ss.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) WTD,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND DATE_FORMAT(ss.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) MTD,
                    ROUND(SUM(CASE WHEN DATE_FORMAT(ss.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) AND DATE_FORMAT(ss.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) YTD
                FROM
                    payment ss,
                    porder o,
                    users u,
                    address a,
                    city c,
                    country cc
                WHERE
                    o.payment_id = ss.id
                        and  o.user_id = u.id
                        AND IFNULL(u.default_address_id,
                            IFNULL(u.billing_address_id,
                                    u.shipping_address_id)) = a.id
                        AND a.city_id = c.id
                        AND c.country_code = cc.code
                group by cc.name
                ");

        return view('admin.CountrySales',['sales'=>$sales]);

    }

    function productRegistered()
    {
        $product_registered = DB::select("
        SELECT  cc.name country,
                ROUND(SUM(CASE WHEN DATE_FORMAT(p.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAYY,
                ROUND(SUM(CASE WHEN DATE_FORMAT(p.created_at, '%Y-%m-%d') >= ADDDATE(CURDATE(),INTERVAL - WEEKDAY(CURDATE()) DAY) AND DATE_FORMAT(p.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) WTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(p.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND DATE_FORMAT(p.created_at, '%Y-%m-%d') <= CURDATE() THEN 0 ELSE 0 END),2) MTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(p.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) AND DATE_FORMAT(p.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END), 2) YTD
            FROM
                product p,
                merchantproduct mp,
                merchant m,
                address a,
                city c,
                country cc
            WHERE
                p.id = mp.product_id
                    AND mp.merchant_id = m.id
                    AND m.oshop_address_id = a.id
                    AND a.city_id = c.id
                    AND c.country_code = cc.code
            GROUP BY cc.name
        ");

        return view('admin.CountryProductRegistered',['productRegistered'=>$product_registered]);
    }

    function buyerRegistered()
    {
        $buyer_registered = DB::select("
        SELECT
                cc.name country,
                ROUND(SUM(CASE WHEN DATE_FORMAT(b.created_at, '%Y-%m-%d') = CURDATE() THEN 1 ELSE 0 END),2) DAYY,
                ROUND(SUM(CASE WHEN DATE_FORMAT(b.created_at, '%Y-%m-%d') >= ADDDATE(CURDATE(),INTERVAL - WEEKDAY(CURDATE()) DAY) AND DATE_FORMAT(b.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) WTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(b.created_at, '%Y-%m-%d') >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND DATE_FORMAT(b.created_at, '%Y-%m-%d') <= CURDATE() THEN 0 ELSE 0 END),2) MTD,
                ROUND(SUM(CASE WHEN DATE_FORMAT(b.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) AND DATE_FORMAT(b.created_at, '%Y-%m-%d') <= CURDATE() THEN 1 ELSE 0 END),2) YTD
            FROM
                buyer b,
                users u,
                address a,
                city c,
                country cc
            WHERE
                b.user_id = u.id
                    AND IFNULL(u.default_address_id,
                        IFNULL(u.billing_address_id,
                                u.shipping_address_id)) = a.id
                    AND a.city_id = c.id
                    AND c.country_code = cc.code
                    group by cc.name
        ");
        return view('admin.CountryBuyerRegistered',['buyerRegistered'=>$buyer_registered]);
    }

    public function mcGeneralReport(){
        $mc = DB::select("
            SELECT
                  ss.id       MC_ID,
                  u.name,
                  u.email     MC_Email,
                  ss.target_revenue,
                  ss.commission,
                  ss.bonus,
                  count(*)    Relationship_Analysis,
                  brands.brand,
                  sales.since Since_Sale,
                  sales.YTD   YTD_Sale,
                  sales.revenue,
                  comp.complaints,
                  its.item_sold,
                  itc.item_clicked
                FROM sales_staff ss,
                  users u,
                  merchant m,
                  (SELECT
                     mm.id    merchant_id,
                     count(*) brand
                   FROM merchantbrand b, merchant mm
                   WHERE b.merchant_id = mm.id
                   GROUP BY mm.id) brands,
                  (SELECT
                     mmm.id,
                     ROUND(SUM(CASE WHEN DATE_FORMAT(p.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) AND
                                         DATE_FORMAT(p.created_at, '%Y-%m-%d') <= CURDATE()
                       THEN p.receivable
                               ELSE 0 END), 2)                       YTD,
                     sum(p.receivable)                               since,
                     Sum(p.receivable * (p.osmall_commission / 100)) revenue
                   FROM porder o, merchant mmm, payment p
                   WHERE mmm.user_id = o.user_id
                         AND o.payment_id = p.id
                   GROUP BY mmm.id) sales,
                  (SELECT
                     m.mc_sales_staff_id,
                     count(bh.id) complaints
                   FROM merchant m, merchantproduct mp, orderproduct op, porder o, buyer_help bh
                   WHERE bh.order_id = o.id
                         AND op.porder_id = o.id
                         AND mp.product_id = op.id
                         AND mp.merchant_id = m.id
                   GROUP BY m.mc_sales_staff_id
                  ) comp,
                  (SELECT
                     m.mc_sales_staff_id,
                     sum(op.quantity) item_sold
                   FROM merchant m, merchantproduct mp, orderproduct op, porder o
                   WHERE
                     op.porder_id = o.id
                     AND mp.product_id = op.id
                     AND mp.merchant_id = m.id
                   GROUP BY m.mc_sales_staff_id
                  ) its,
                  (
                    SELECT
                      m.mc_sales_staff_id,
                      count(sm.id) item_clicked
                    FROM merchant m, merchantproduct mp, orderproduct op, porder o, smmin sm
                    WHERE sm.porder_id = o.id
                          AND op.porder_id = o.id
                          AND mp.product_id = op.id
                          AND mp.merchant_id = m.id
                    GROUP BY m.mc_sales_staff_id
                  ) itc
                WHERE ss.user_id = u.id
                      AND ss.id = m.mc_sales_staff_id
                      AND m.id = brands.merchant_id
                      AND m.id = sales.id
                      AND comp.mc_sales_staff_id = m.mc_sales_staff_id
                      AND its.mc_sales_staff_id = m.mc_sales_staff_id
                      AND itc.mc_sales_staff_id = m.mc_sales_staff_id
                GROUP BY
                  ss.id,
                  u.name,
                  u.email,
                  ss.target_revenue,
                  ss.commission,
                  ss.bonus
        ");
        return view("general.mcreport",["mcs"=>$mc]);
    }

    public function mpGeneralReport(){
        $mp = DB::select("
            SELECT
                  ss.id       MP_ID,
                  u.name,
                  u.email     MP_Email,
                  ss.target_revenue,
                  ss.commission,
                  ss.bonus,
                  count(*)    Relationship_Analysis,
                  brands.brand,
                  sales.since Since_Sale,
                  sales.YTD   YTD_Sale,
                  sales.revenue,
                  comp.complaints,
                  its.item_sold,
                  itc.item_clicked
                FROM sales_staff ss,
                  users u,
                  merchant m,
                  (SELECT
                     mm.id    merchant_id,
                     count(*) brand
                   FROM merchantbrand b, merchant mm
                   WHERE b.merchant_id = mm.id
                   GROUP BY mm.id) brands,
                  (SELECT
                     mmm.id,
                     ROUND(SUM(CASE WHEN DATE_FORMAT(p.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) AND
                                         DATE_FORMAT(p.created_at, '%Y-%m-%d') <= CURDATE()
                       THEN p.receivable
                               ELSE 0 END), 2)                       YTD,
                     sum(p.receivable)                               since,
                     Sum(p.receivable * (p.osmall_commission / 100)) revenue
                   FROM porder o, merchant mmm, payment p
                   WHERE mmm.user_id = o.user_id
                         AND o.payment_id = p.id
                   GROUP BY mmm.id) sales,
                  (SELECT
                     m.mcp1_sales_staff_id,
                     count(bh.id) complaints
                   FROM merchant m, merchantproduct mp, orderproduct op, porder o, buyer_help bh
                   WHERE bh.order_id = o.id
                         AND op.porder_id = o.id
                         AND mp.product_id = op.id
                         AND mp.merchant_id = m.id
                   GROUP BY m.mcp1_sales_staff_id
                  ) comp,
                  (SELECT
                     m.mcp1_sales_staff_id,
                     sum(op.quantity) item_sold
                   FROM merchant m, merchantproduct mp, orderproduct op, porder o
                   WHERE
                     op.porder_id = o.id
                     AND mp.product_id = op.id
                     AND mp.merchant_id = m.id
                   GROUP BY m.mcp1_sales_staff_id
                  ) its,
                  (
                    SELECT
                      m.mcp1_sales_staff_id,
                      count(sm.id) item_clicked
                    FROM merchant m, merchantproduct mp, orderproduct op, porder o, smmin sm
                    WHERE sm.porder_id = o.id
                          AND op.porder_id = o.id
                          AND mp.product_id = op.id
                          AND mp.merchant_id = m.id
                    GROUP BY m.mcp1_sales_staff_id
                  ) itc
                WHERE ss.user_id = u.id
                      AND ss.id = m.mcp1_sales_staff_id
                      AND m.id = brands.merchant_id
                      AND m.id = sales.id
                      AND comp.mcp1_sales_staff_id = m.mcp1_sales_staff_id
                      AND its.mcp1_sales_staff_id = m.mcp1_sales_staff_id
                      AND itc.mcp1_sales_staff_id = m.mcp1_sales_staff_id
                GROUP BY
                  ss.id,
                  u.name,
                  u.email,
                  ss.target_revenue,
                  ss.commission,
                  ss.bonus
        ");
        return view("general.mpreport",["mps"=>$mp]);
    }

    public function pusherGeneralReport(){
        $pusher = DB::select("
            SELECT
                  ss.id       Pusher_ID,
                  u.name,
                  u.email     Pusher_Email,
                  ss.target_revenue,
                  ss.commission,
                  ss.bonus,
                  count(*)    Relationship_Analysis,
                  brands.brand,
                  sales.since Since_Sale,
                  sales.YTD   YTD_Sale,
                  sales.revenue,
                  comp.complaints,
                  its.item_sold,
                  itc.item_clicked
                FROM sales_staff ss,
                  users u,
                  merchant m,
                  (SELECT
                     mm.id    merchant_id,
                     count(*) brand
                   FROM merchantbrand b, merchant mm
                   WHERE b.merchant_id = mm.id
                   GROUP BY mm.id) brands,
                  (SELECT
                     mmm.id,
                     ROUND(SUM(CASE WHEN DATE_FORMAT(p.created_at, '%Y-%m-%d') >= MAKEDATE(YEAR(NOW()), 1) AND
                                         DATE_FORMAT(p.created_at, '%Y-%m-%d') <= CURDATE()
                       THEN p.receivable
                               ELSE 0 END), 2)                       YTD,
                     sum(p.receivable)                               since,
                     Sum(p.receivable * (p.osmall_commission / 100)) revenue
                   FROM porder o, merchant mmm, payment p
                   WHERE mmm.user_id = o.user_id
                         AND o.payment_id = p.id
                   GROUP BY mmm.id) sales,
                  (SELECT
                     m.psh_sales_staff_id,
                     count(bh.id) complaints
                   FROM merchant m, merchantproduct mp, orderproduct op, porder o, buyer_help bh
                   WHERE bh.order_id = o.id
                         AND op.porder_id = o.id
                         AND mp.product_id = op.id
                         AND mp.merchant_id = m.id
                   GROUP BY m.psh_sales_staff_id
                  ) comp,
                  (SELECT
                     m.psh_sales_staff_id,
                     sum(op.quantity) item_sold
                   FROM merchant m, merchantproduct mp, orderproduct op, porder o
                   WHERE
                     op.porder_id = o.id
                     AND mp.product_id = op.id
                     AND mp.merchant_id = m.id
                   GROUP BY m.psh_sales_staff_id
                  ) its,
                  (
                    SELECT
                      m.psh_sales_staff_id,
                      count(sm.id) item_clicked
                    FROM merchant m, merchantproduct mp, orderproduct op, porder o, smmin sm
                    WHERE sm.porder_id = o.id
                          AND op.porder_id = o.id
                          AND mp.product_id = op.id
                          AND mp.merchant_id = m.id
                    GROUP BY m.psh_sales_staff_id
                  ) itc
                WHERE ss.user_id = u.id
                      AND ss.id = m.psh_sales_staff_id
                      AND m.id = brands.merchant_id
                      AND m.id = sales.id
                      AND comp.psh_sales_staff_id = m.psh_sales_staff_id
                      AND its.psh_sales_staff_id = m.psh_sales_staff_id
                      AND itc.psh_sales_staff_id = m.psh_sales_staff_id
                GROUP BY
                  ss.id,
                  u.name,
                  u.email,
                  ss.target_revenue,
                  ss.commission,
                  ss.bonus
        ");
        return view("general.pusherreport",["pushers"=>$pusher]);
    }
}
