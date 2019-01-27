<?php

namespace App\Http\Controllers;

use App\Http\Repository\UserFlowRepo;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//use App\Models\UserFlow;

class UserflowController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * $where = "WHERE created_at > '2016-01-01 00:00:00' and authtracker.status='login'";
         * $avg_count_query = "SELECT round(avg(a.count)) as avg from(select count(`id`) as count
         * FROM authtracker " . $where . "GROUP BY MINUTE(`created_at`)) as a";
         * //For logins global
         * $yrLogins = DB::SELECT($avg_count_query);
         *
         * $mnLogins = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg "
         * . "from authtracker a, country c, users u "
         * . "where (c.code='MYS' or c.code='HKG') and a.user_id = u.id "
         * . "and u.nationality_country_id=c.id "
         * . "and a.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) "
         * . "and a.status='login'");
         *
         * $dayLogins = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where (c.code='MYS' or c.code='HKG') and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >='2016-01-01 00:00:00' and a.status='login'");
         *
         * $hrLogins = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from authtracker a, country c, users u where (c.code='MYS' or c.code='HKG') and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) and a.status='login'");
         *
         * $minLogins = DB::SELECT("select count(*) as total from authtracker a, country c, users u where (c.code='MYS' or c.code='HKG') and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date(now()),interval -1 DAY) and a.status='login'");
         *
         * $secLogins = DB::SELECT("select count(*) as total from authtracker a, country c, users u where (c.code='MYS' or c.code='HKG') and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(now(),interval -3600 SECOND) and a.status='login'");
         *
         * //For new user registration global
         * $yrUserReg = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from buyer b, country c, users u where (c.code='MYS' or c.code ='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00'");
         *
         * $mnUserReg = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");
         *
         * $dayUserReg = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00'");
         *
         * $hrUserReg = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from buyer  b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");
         *
         * $minUserReg = DB::SELECT("select count(*) as total from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= date_add(date(now()),interval -1 DAY)");
         *
         * $secUserReg = DB::SELECT("select count(*) as total from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(now(),interval -3600 SECOND)");
         *
         * //for account termination global
         * $yrAccTermination = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00' && b.status = 'terminated'");
         *
         * $mnAccTermination = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) && b.status = 'terminated'");
         *
         * $dayAccTermination = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >='2016-01-01 00:00:00' && b.status = 'terminated'");
         *
         * $hrAccTermination = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) && b.status = 'terminated'");
         *
         * $minAccTermination = DB::SELECT("select count(*) as total from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date(now()),interval -1 DAY) && b.status = 'terminated'");
         *
         * $secAccTermination = DB::SELECT("select count(*) as total from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(now(),interval -3600 SECOND) && b.status = 'terminated'");
         *
         * //For Transaction global
         *
         * $yrTransaction = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >= '2016-01-01 00:00:00'");
         *
         * $mnTransaction = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)  AND p.created_at >= '2016-01-01 00:00:00'");
         *
         * $dayTransaction = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >= '2016-01-01 00:00:00'");
         *
         * $hrTransaction = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");
         *
         * $minTransaction = DB::SELECT("select count(*) as total from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(date(now()),interval -1 DAY)");
         *
         * $secTransaction = DB::SELECT("select count(*) as total from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(now(),interval -3600 SECOND)");
         *
         * //For Page view global
         *
         *
         * $yrPageView = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >= '2016-01-01 00:00:00'");
         *
         * $mnPageView = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)  AND v.created_at >= '2016-01-01 00:00:00'");
         *
         * $dayPageView = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >='2016-01-01 00:00:00'");
         *
         * $hrPageView = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");
         *
         * $minPageView = DB::SELECT("select count(*) as total from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(date(now()),interval -1 DAY)");
         *
         * $secPageView = DB::SELECT("select count(*) as total from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(now(),interval -3600 SECOND)");
         *
         *
         * /*
         * This is for Malaysia
         */
        /*
        //For logins Malaysia

                $yrLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >= '2016-01-01 00:00:00' and a.status='login'");

                $mnLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) and a.status='login'");

                $dayLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >='2016-01-01 00:00:00' and a.status='login'");

                $hrLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) and a.status='login'");

                $minLoginsMalay = DB::SELECT("select count(*) as total from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date(now()),interval -1 DAY) and a.status='login'");

                $secLoginsMalay = DB::SELECT("select count(*) as total from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(now(),interval -3600 SECOND) and a.status='login'");

        //For new user registration Malaysia
                $yrUserRegMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from buyer b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00'");

                $mnUserRegMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

                $dayUserRegMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00'");

                $hrUserRegMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from buyer  b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

                $minUserRegMalay = DB::SELECT("select count(*) as total from buyer b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= date_add(date(now()),interval -1 DAY)");

                $secUserRegMalay = DB::SELECT("select count(*) as total from buyer b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(now(),interval -3600 SECOND)");

        //for account termination Malaysia

                $yrAccTerminationMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from buyer b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00' && b.status = 'terminated'");

                $mnAccTerminationMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) && b.status = 'terminated'");

                $dayAccTerminationMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from buyer b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >='2016-01-01 00:00:00' && status = 'terminated'");

                $hrAccTerminationMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from buyer b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) && b.status = 'terminated'");

                $minAccTerminationMalay = DB::SELECT("select count(*) as total from buyer b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date(now()),interval -1 DAY) && b.status = 'terminated'");

                $secAccTerminationMalay = DB::SELECT("select count(*) as total from buyer b, country c, users u where c.code='MYS' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(now(),interval -3600 SECOND) && b.status = 'terminated'");

        //For Transaction Malaysia

                $yrTransactionMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from porder p, country c, users u where c.code='MYS' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >= '2016-01-01 00:00:00'");

                $mnTransactionMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from porder p, country c, users u where c.code='MYS' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)  AND p.created_at >= '2016-01-01 00:00:00'");

                $dayTransactionMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from porder p, country c, users u where c.code='MYS' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >= '2016-01-01 00:00:00'");

                $hrTransactionMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from porder p, country c, users u where c.code='MYS' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

                $minTransactionMalay = DB::SELECT("select count(*) as total from porder p, country c, users u where c.code='MYS' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(date(now()),interval -1 DAY)");

                $secTransactionMalay = DB::SELECT("select count(*) as total from porder p, country c, users u where c.code='MYS' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(now(),interval -3600 SECOND)");

        //For Page view Malaysia


                $yrPageViewMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from view_count v, country c, users u where c.code='MYS'  and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >= '2016-01-01 00:00:00'");

                $mnPageViewMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from view_count v, country c, users u where c.code='MYS' and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)  AND v.created_at >= '2016-01-01 00:00:00'");

                $dayPageViewMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from view_count v, country c, users u where c.code='MYS' and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >='2016-01-01 00:00:00'");

                $hrPageViewMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from view_count v, country c, users u where c.code='MYS' and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

                $minPageViewMalay = DB::SELECT("select count(*) as total from view_count v, country c, users u where c.code='MYS' and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(date(now()),interval -1 DAY)");

                $secPageViewMalay = DB::SELECT("select count(*) as total from view_count v, country c, users u where c.code='MYS' and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(now(),interval -3600 SECOND)");


                /*
                  This is for Hong Kong

                 */
        /*

//For logins Hong Kong

        $yrLoginsHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from authtracker a, country c, users u where c.code='HKG' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >= '2016-01-01 00:00:00'");

        $mnLoginsHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where c.code='HKG' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $dayLoginsHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where c.code='HKG' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >='2016-01-01 00:00:00'");

        $hrLoginsHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from authtracker a, country c, users u where c.code='HKG' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $minLoginsHongKong = DB::SELECT("select count(*) as total from authtracker a, country c, users u where c.code='HKG' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date(now()),interval -1 DAY)");

        $secLoginsHongKong = DB::SELECT("select count(*) as total from authtracker a, country c, users u where c.code='HKG' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(now(),interval -3600 SECOND)");

//For new user registration HongKong
        $yrUserRegHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from buyer b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00'");

        $mnUserRegHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $dayUserRegHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00'");

        $hrUserRegHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from buyer  b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $minUserRegHongKong = DB::SELECT("select count(*) as total from buyer b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= date_add(date(now()),interval -1 DAY)");

        $secUserRegHongKong = DB::SELECT("select count(*) as total from buyer b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(now(),interval -3600 SECOND)");

//for account termination Hongkong

        $yrAccTerminationHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from buyer b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00' && status = 'terminated'");

        $mnAccTerminationHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) && status = 'terminated'");

        $dayAccTerminationHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from buyer b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >='2016-01-01 00:00:00' && status = 'terminated'");

        $hrAccTerminationHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from buyer b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) && status = 'terminated'");

        $minAccTerminationHongKong = DB::SELECT("select count(*) as total from buyer b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date(now()),interval -1 DAY) && status = 'terminated'");

        $secAccTerminationHongKong = DB::SELECT("select count(*) as total from buyer b, country c, users u where c.code='HKG' and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(now(),interval -3600 SECOND) && status = 'terminated'");

//For Transaction Hongkong

        $yrTransactionHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from porder p, country c, users u where c.code='HKG' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >= '2016-01-01 00:00:00'");

        $mnTransactionHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from porder p, country c, users u where c.code='HKG' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)  AND p.created_at >= '2016-01-01 00:00:00'");

        $dayTransactionHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from porder p, country c, users u where c.code='HKG' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >= '2016-01-01 00:00:00'");

        $hrTransactionHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from porder p, country c, users u where c.code='HKG' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $minTransactionHongKong = DB::SELECT("select count(*) as total from porder p, country c, users u where c.code='HKG' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(date(now()),interval -1 DAY)");

        $secTransactionHongKong = DB::SELECT("select count(*) as total from porder p, country c, users u where c.code='HKG' and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(now(),interval -3600 SECOND)");

//For Page view Hongkong


        $yrPageViewHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from view_count v, country c, users u where c.code='HKG'  and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >= '2016-01-01 00:00:00'");

        $mnPageViewHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from view_count v, country c, users u where c.code='HKG' and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)  AND v.created_at >= '2016-01-01 00:00:00'");

        $dayPageViewHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from view_count v, country c, users u where c.code='HKG' and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >='2016-01-01 00:00:00'");

        $hrPageViewHongKong = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from view_count v, country c, users u where c.code='HKG' and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $minPageViewHongKong = DB::SELECT("select count(*) as total from view_count v, country c, users u where c.code='HKG' and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(date(now()),interval -1 DAY)");

        $secPageViewHongKong = DB::SELECT("select count(*) as total from view_count v, country c, users u where c.code='HKG' and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(now(),interval -3600 SECOND)");

*/
        return view('userflow');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * public function _get_counts()
     * {
     * $today = date("Y-m-d H:i:s");
     * $year_back = date('Y-m-d', strtotime("$today -1 year"));
     * $month_back = date('Y-m-d', strtotime("$today -12 month"));
     * $day30_back = date('Y-m-d', strtotime("$today -30 days"));
     * $hours24_back = date('Y-m-d H:i', strtotime("$today -24 hours"));
     * $minutes60_back = date('Y-m-d H:i', strtotime("$today -60 minutes"));
     * $seconds60_back = date('Y-m-d H:i', strtotime("$today -1 minutes"));
     * $data = [];
     * /* Logins malaysia */
    /**
     * $logins = [];
     * $where = "WHERE authtracker.created_at > '2016-01-01 00:00:00' and authtracker.status='login' and c.code='MYS' ";
     * $lap = 'YEAR(authtracker.created_at)) as a';
     * $avg_count_query = "SELECT round(avg(a.count)) as avg from(select count(authtracker.id) as count
     * FROM authtracker
     * JOIN users u ON u.id= authtracker.user_id
     * JOIN country c ON c.id= u.nationality_country_id
     * " . $where . "GROUP BY ";
     * $yrLoginsMalay = DB::SELECT($avg_count_query . $lap);
     *
     * //        $yrLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1)
     * //        as avg from authtracker a, country c, users u
     * //        where c.code='MYS' and a.user_id = u.id
     * //        and u.nationality_country_id=c.id and a.created_at >= '2016-01-01 00:00:00'");
     * //
     * //        $mnLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");
     * $lap = 'MONTH(authtracker.created_at)) as a';
     * $mnLoginsMalay = DB::SELECT($avg_count_query . $lap);
     *
     * //        $dayLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >='2016-01-01 00:00:00'");
     * $lap = 'DAY(authtracker.created_at)) as a';
     * $dayLoginsMalay = DB::SELECT($avg_count_query . $lap);
     *
     * //        $hrLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");
     * $lap = 'HOUR(authtracker.created_at)) as a';
     * $hrLoginsMalay = DB::SELECT($avg_count_query . $lap);
     *
     * //        $minLoginsMalay = DB::SELECT("select count(*) as total from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date(now()),interval -1 DAY)");
     * $lap = 'MINUTE(authtracker.created_at)) as a';
     * $minLoginsMalay = DB::SELECT($avg_count_query . $lap);
     *
     * //        $secLoginsMalay = DB::SELECT("select count(*) as total from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(now(),interval -3600 SECOND)");
     * $lap = 'SECOND(authtracker.created_at)) as a';
     * $secLoginsMalay = DB::SELECT($avg_count_query . $lap);
     *
     * $logins['my_year_count'] = $yrLoginsMalay[0]->avg ? $yrLoginsMalay[0]->avg : 0;
     * $logins['my_month_count'] = $mnLoginsMalay[0]->avg ? $mnLoginsMalay[0]->avg : 0;
     * $logins['my_day30_count'] = $dayLoginsMalay[0]->avg ? $dayLoginsMalay[0]->avg : 0;
     * $logins["my_hours24_count"] = $hrLoginsMalay[0]->avg ? $hrLoginsMalay[0]->avg : 0;
     * $logins["my_minutes60_count"] = $minLoginsMalay[0]->avg ? $minLoginsMalay[0]->avg : 0;
     * $logins["my_seconds60_count"] = $secLoginsMalay[0]->avg ? $secLoginsMalay[0]->avg : 0;
     *
     * /* logins hongkong */
    /**
     * $where = "WHERE authtracker.created_at > '2016-01-01 00:00:00' and authtracker.status='login' and c.code='HKG' ";
     * $lap = 'YEAR(authtracker.created_at)) as a';
     * $avg_count_query = "SELECT round(avg(a.count)) as avg from(select count(authtracker.id) as count
     * FROM authtracker
     * JOIN users u ON u.id= authtracker.user_id
     * JOIN country c ON c.id= u.nationality_country_id
     * " . $where . "GROUP BY ";
     *
     * $lap = 'YEAR(authtracker.created_at)) as a';
     * $yrLoginsHongKong = DB::SELECT($avg_count_query . $lap);
     *
     * $lap = 'MONTH(authtracker.created_at)) as a';
     * $mnLoginsHongKong = DB::SELECT($avg_count_query . $lap);
     *
     * //        $dayLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >='2016-01-01 00:00:00'");
     * $lap = 'DAY(authtracker.created_at)) as a';
     * $dayLoginsHongKong = DB::SELECT($avg_count_query . $lap);
     *
     * //        $hrLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");
     * $lap = 'HOUR(authtracker.created_at)) as a';
     * $hrLoginsHongKong = DB::SELECT($avg_count_query . $lap);
     *
     * //        $minLoginsMalay = DB::SELECT("select count(*) as total from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date(now()),interval -1 DAY)");
     * $lap = 'MINUTE(authtracker.created_at)) as a';
     * $minLoginsHongKong = DB::SELECT($avg_count_query . $lap);
     *
     * //        $secLoginsMalay = DB::SELECT("select count(*) as total from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(now(),interval -3600 SECOND)");
     * $lap = 'SECOND(authtracker.created_at)) as a';
     * $secLoginsHongKong = DB::SELECT($avg_count_query . $lap);
     *
     * $logins['hkg_year_count'] = $yrLoginsHongKong[0]->avg ? $yrLoginsHongKong[0]->avg : 0;
     * $logins['hkg_month_count'] = $mnLoginsHongKong[0]->avg ? $mnLoginsHongKong[0]->avg : 0;
     * $logins['hkg_day30_count'] = $dayLoginsHongKong[0]->avg ? $dayLoginsHongKong[0]->avg : 0;
     * $logins["hkg_hours24_count"] = $hrLoginsHongKong[0]->avg ? $hrLoginsHongKong[0]->avg : 0;
     * $logins["hkg_minutes60_count"] = $minLoginsHongKong[0]->avg ? $minLoginsHongKong[0]->avg : 0;
     * $logins["hkg_seconds60_count"] = $secLoginsHongKong[0]->avg ? $secLoginsHongKong[0]->avg : 0;
     *
     *
     * /* logins global */
    /**
     * //        $yrLogins = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from authtracker a, country c, users u where (c.code='MYS' or c.code='HKG') and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >= '2016-01-01 00:00:00'");
     * //For logins global
     * $where = "WHERE created_at > '2016-01-01 00:00:00' and authtracker.status='login'";
     * $lap = 'YEAR';
     * $avg_count_query = "SELECT round(avg(a.count)) as avg from(select count(`id`) as count
     * FROM authtracker " . $where . "GROUP BY " . $lap . "(`created_at`)) as a";
     * $yrLogins = DB::SELECT($avg_count_query);
     *
     * $lap = 'MONTH';
     * $avg_count_query = "SELECT round(avg(a.count)) as avg from(select count(`id`) as count
     * FROM authtracker " . $where . "GROUP BY " . $lap . "(`created_at`)) as a";
     * $mnLogins = DB::SELECT($avg_count_query);
     *
     * $lap = 'DAY';
     * $avg_count_query = "SELECT round(avg(a.count)) as avg from(select count(`id`) as count
     * FROM authtracker " . $where . "GROUP BY " . $lap . "(`created_at`)) as a";
     * $dayLogins = DB::SELECT($avg_count_query);
     *
     * $lap = 'HOUR';
     * $avg_count_query = "SELECT round(avg(a.count)) as avg from(select count(`id`) as count
     * FROM authtracker " . $where . "GROUP BY " . $lap . "(`created_at`)) as a";
     * $hrLogins = DB::SELECT($avg_count_query);
     *
     * $lap = 'MINUTE';
     * $avg_count_query = "SELECT round(avg(a.count)) as avg from(select count(`id`) as count
     * FROM authtracker " . $where . "GROUP BY " . $lap . "(`created_at`)) as a";
     * $minLogins = DB::SELECT($avg_count_query);
     *
     * $lap = 'SECOND';
     * $avg_count_query = "SELECT round(avg(a.count)) as avg from(select count(`id`) as count
     * FROM authtracker " . $where . "GROUP BY " . $lap . "(`created_at`)) as a";
     * $secLogins = DB::SELECT($avg_count_query);
     *
     *
     * $logins['global_year_count'] = $yrLogins[0]->avg ? $yrLogins[0]->avg : 0;
     * $logins['global_month_count'] = $mnLogins[0]->avg ? $mnLogins[0]->avg : 0;
     * $logins['global_day30_count'] = $dayLogins[0]->avg ? $dayLogins[0]->avg : 0;
     * $logins["global_hours24_count"] = $hrLogins[0]->avg ? $hrLogins[0]->avg : 0;
     * $logins["global_minutes60_count"] = $minLogins[0]->avg ? $minLogins[0]->avg : 0;
     * $logins["global_seconds60_count"] = $secLogins[0]->avg ? $secLogins[0]->avg : 0;
     *
     * /* End Logins */
    /**
     * $new_user = [];
     *
     * $new_user['my_year_count'] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 150)->whereDate("u.created_at", '>', $year_back)->count();
     * $new_user["my_month_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 150)->whereDate("u.created_at", '>', $month_back)->count() / 12;
     * $new_user["my_day30_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 150)->whereDate("u.created_at", '>', $day30_back)->count() / 30;
     * $new_user["my_hours24_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 150)->whereDate("u.created_at", '>', $hours24_back)->count() / 24;
     * $new_user["my_minutes60_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 150)->whereDate("u.created_at", '>', $minutes60_back)->count() / 60;
     * $new_user["my_seconds60_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 150)->whereDate("u.created_at", '>', $seconds60_back)->count() / 60;
     * $new_user['hkg_year_count'] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 93)->whereDate("u.created_at", '>', $year_back)->count();
     * $new_user["hkg_month_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 93)->whereDate("u.created_at", '>', $month_back)->count() / 12;
     * $new_user["hkg_day30_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 93)->whereDate("u.created_at", '>', $day30_back)->count() / 30;
     * $new_user["hkg_hours24_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 93)->whereDate("u.created_at", '>', $hours24_back)->count() / 24;
     * $new_user["hkg_minutes60_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 93)->whereDate("u.created_at", '>', $minutes60_back)->count() / 60;
     * $new_user["hkg_seconds60_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 93)->whereDate("u.created_at", '>', $seconds60_back)->count() / 60;
     * $new_user['global_year_count'] = $new_user['my_year_count'] + $new_user['hkg_year_count'];
     * $new_user["global_month_count"] = $new_user['my_month_count'] + $new_user['hkg_month_count'];
     * $new_user["global_day30_count"] = $new_user['my_day30_count'] + $new_user['hkg_day30_count'];
     * $new_user["global_hours24_count"] = $new_user['my_hours24_count'] + $new_user['hkg_hours24_count'];
     * $new_user["global_minutes60_count"] = $new_user['my_minutes60_count'] + $new_user['hkg_minutes60_count'];
     * $new_user["global_seconds60_count"] = $new_user['my_seconds60_count'] + $new_user['hkg_seconds60_count'];
     *
     * /*         * ****Terminations****** */
    /**
     * $terminations = [];
     * $terminations['my_year_count'] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where(function ($query) {
     * $query->where("b.status", "terminated");
     * $query->orwhere("b.status", "closed");
     * })->where('u.nationality_country_id', 150)->whereDate("b.closed_date", '>', $year_back)->count();
     * $terminations["my_month_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where(function ($query) {
     * $query->where("b.status", "terminated");
     * $query->orwhere("b.status", "closed");
     * })->where('u.nationality_country_id', 150)->whereDate("b.closed_date", '>', $month_back)->count() / 12;
     * $terminations["my_day30_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where(function ($query) {
     * $query->where("b.status", "terminated");
     * $query->orwhere("b.status", "closed");
     * })->where('u.nationality_country_id', 150)->whereDate("b.closed_date", '>', $day30_back)->count() / 30;
     * $terminations["my_hours24_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where(function ($query) {
     * $query->where("b.status", "terminated");
     * $query->orwhere("b.status", "closed");
     * })->where('u.nationality_country_id', 150)->whereDate("b.closed_date", '>', $hours24_back)->count() / 24;
     * $terminations["my_minutes60_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where(function ($query) {
     * $query->where("b.status", "terminated");
     * $query->orwhere("b.status", "closed");
     * })->where('u.nationality_country_id', 150)->whereDate("b.closed_date", '>', $minutes60_back)->count() / 60;
     * $terminations["my_seconds60_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where(function ($query) {
     * $query->where("b.status", "terminated");
     * $query->orwhere("b.status", "closed");
     * })->where('u.nationality_country_id', 150)->whereDate("b.closed_date", '>', $seconds60_back)->count() / 60;
     * $terminations['hkg_year_count'] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where(function ($query) {
     * $query->where("b.status", "terminated");
     * $query->orwhere("b.status", "closed");
     * })->where('u.nationality_country_id', 93)->whereDate("b.closed_date", '>', $year_back)->count();
     * $terminations["hkg_month_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where(function ($query) {
     * $query->where("b.status", "terminated");
     * $query->orwhere("b.status", "closed");
     * })->where('u.nationality_country_id', 93)->whereDate("b.closed_date", '>', $month_back)->count() / 12;
     * $terminations["hkg_day30_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where(function ($query) {
     * $query->where("b.status", "terminated");
     * $query->orwhere("b.status", "closed");
     * })->where('u.nationality_country_id', 93)->whereDate("b.closed_date", '>', $day30_back)->count() / 30;
     * $terminations["hkg_hours24_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where(function ($query) {
     * $query->where("b.status", "terminated");
     * $query->orwhere("b.status", "closed");
     * })->where('u.nationality_country_id', 93)->whereDate("b.closed_date", '>', $hours24_back)->count() / 24;
     * $terminations["hkg_minutes60_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where(function ($query) {
     * $query->where("b.status", "terminated");
     * $query->orwhere("b.status", "closed");
     * })->where('u.nationality_country_id', 93)->whereDate("b.closed_date", '>', $minutes60_back)->count() / 60;
     * $terminations["hkg_seconds60_count"] = DB::table('users as u')->join('buyer as b', 'u.id', '=', 'b.user_id')->where('u.nationality_country_id', 93)->whereDate("b.closed_date", '>', $seconds60_back)->count() / 60;
     * $terminations['global_year_count'] = $terminations["my_year_count"] + $terminations["hkg_year_count"];
     * $terminations["global_month_count"] = $terminations["my_month_count"] + $terminations["hkg_month_count"];
     * $terminations["global_day30_count"] = $terminations["my_day30_count"] + $terminations["hkg_day30_count"];
     * $terminations["global_hours24_count"] = $terminations["my_hours24_count"] + $terminations["hkg_hours24_count"];
     * $terminations["global_minutes60_count"] = $terminations["my_minutes60_count"] + $terminations["hkg_minutes60_count"];
     * $terminations["global_seconds60_count"] = $terminations["my_seconds60_count"] + $terminations["hkg_seconds60_count"];
     *
     * /*         * ****END Transaction****** */

    /*         * ***Transaction***** */
    /**
     * $transactions = [];
     * $transactions['my_year_count'] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 150)->whereDate("p.created_at", '>', $year_back)->count();
     * $transactions["my_month_count"] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 150)->whereDate("p.created_at", '>', $month_back)->count() / 12;
     * $transactions["my_day30_count"] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 150)->whereDate("p.created_at", '>', $day30_back)->count() / 30;
     * $transactions["my_hours24_count"] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 150)->whereDate("p.created_at", '>', $hours24_back)->count() / 24;
     * $transactions["my_minutes60_count"] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 150)->whereDate("p.created_at", '>', $minutes60_back)->count() / 60;
     * $transactions["my_seconds60_count"] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 150)->whereDate("p.created_at", '>', $seconds60_back)->count() / 60;
     * $transactions['hkg_year_count'] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 93)->whereDate("p.created_at", '>', $year_back)->count();
     * $transactions["hkg_month_count"] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 93)->whereDate("p.created_at", '>', $month_back)->count() / 12;
     * $transactions["hkg_day30_count"] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 93)->whereDate("p.created_at", '>', $day30_back)->count() / 30;
     * $transactions["hkg_hours24_count"] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 93)->whereDate("p.created_at", '>', $hours24_back)->count() / 24;
     * $transactions["hkg_minutes60_count"] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 93)->whereDate("p.created_at", '>', $minutes60_back)->count() / 60;
     * $transactions["hkg_seconds60_count"] = DB::table('porder as p')->join('users as u', 'u.id', '=', 'p.user_id')->where('u.nationality_country_id', 93)->whereDate("p.created_at", '>', $seconds60_back)->count() / 60;
     *
     * $transactions['global_year_count'] = $transactions['my_year_count'] + $transactions['hkg_year_count'];
     * $transactions["global_month_count"] = $transactions['my_month_count'] + $transactions['hkg_month_count'];
     * $transactions["global_day30_count"] = $transactions['my_day30_count'] + $transactions['hkg_day30_count'];
     * $transactions["global_hours24_count"] = $transactions['my_hours24_count'] + $transactions['hkg_hours24_count'];
     * $transactions["global_minutes60_count"] = $transactions['my_minutes60_count'] + $transactions['hkg_minutes60_count'];
     * $transactions["global_seconds60_count"] = $transactions['my_seconds60_count'] + $transactions['hkg_seconds60_count'];
     * /*         * ***End Transaction***** */

    /*         * ***Site hit counts***** */
    /**
     * $site_hits = [];
     *
     * $site_hits['my_year_count'] = DB::table('kryptonit3_counter_page_visitor')->whereDate("created_at", '>', $year_back)->count();
     * $site_hits["my_month_count"] = DB::table('kryptonit3_counter_page_visitor')->whereDate("created_at", '>', $month_back)->count() / 12;
     * $site_hits["my_day30_count"] = DB::table('kryptonit3_counter_page_visitor')->whereDate("created_at", '>', $day30_back)->count() / 30;
     * $site_hits["my_hours24_count"] = DB::table('kryptonit3_counter_page_visitor')->whereDate("created_at", '>', $hours24_back)->count() / 24;
     * $site_hits["my_minutes60_count"] = DB::table('kryptonit3_counter_page_visitor')->whereDate("created_at", '>', $minutes60_back)->count() / 60;
     * $site_hits["my_seconds60_count"] = DB::table('kryptonit3_counter_page_visitor')->whereDate("created_at", '>', $seconds60_back)->count() / 60;
     *
     * $site_hits['hkg_year_count'] = 0;
     * $site_hits["hkg_month_count"] = 0;
     * $site_hits["hkg_day30_count"] = 0;
     * $site_hits["hkg_hours24_count"] = 0;
     * $site_hits["hkg_minutes60_count"] = 0;
     * $site_hits["hkg_seconds60_count"] = 0;
     *
     * $site_hits['global_year_count'] = $site_hits["my_year_count"] + $site_hits["hkg_year_count"];
     * $site_hits["global_month_count"] = $site_hits["my_month_count"] + $site_hits["hkg_month_count"];
     * $site_hits["global_day30_count"] = $site_hits["my_day30_count"] + $site_hits["hkg_day30_count"];
     * $site_hits["global_hours24_count"] = $site_hits["my_hours24_count"] + $site_hits["hkg_hours24_count"];
     * $site_hits["global_minutes60_count"] = $site_hits["my_minutes60_count"] + $site_hits["hkg_minutes60_count"];
     * $site_hits["global_seconds60_count"] = $site_hits["my_seconds60_count"] + $site_hits["hkg_seconds60_count"];
     *
     * /*         * ***End Site hit counts***** */
    /**
     * $counts = new UserFlowRepo();
     *
     * $objects = [
     * [
     * 'code' => 'MYS',
     * 'id' => 150,
     * 'extension' => 'my_'
     * ],
     * [
     * 'code' => 'HKG',
     * 'id' => 93,
     * 'extension' => 'hkg_'
     * ],
     * [
     * 'code' => 0,
     * 'id' => 0,
     * 'extension' => 'global_'
     * ]
     * ];
     *
     * $new_logins = [];
     * $new_transactions = [];
     * $new_terminations = [];
     * foreach ($objects as $login) {
     * $data = $counts->countLogins($login['code'], $login['extension']);
     * $new_logins += $data;
     * }
     *
     * foreach ($objects as $transaction) {
     * $data = $counts->countTransactions($transaction['id'], $transaction['extension']);
     * $new_transactions += $data;
     * }
     *
     * foreach ($objects as $termination) {
     * $data = $counts->countTerminations($termination['id'], $termination['extension']);
     * $new_terminations += $data;
     * }
     *
     * return array(
     * 'new_registration' => $new_user,
     * 'terminations' => $new_terminations,
     * 'transactions' => $new_transactions,
     * 'site_hits' => $site_hits,
     * 'logins' => $new_logins,
     * );
     * }
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_counts()
    {

        $counts = new UserFlowRepo();

        $objects = [
            [
                'code' => 'MYS',
                'id' => 150,
                'extension' => 'my_'
            ],
            [
                'code' => 'HKG',
                'id' => 93,
                'extension' => 'hkg_'
            ],
            [
                'code' => 0,
                'id' => 0,
                'extension' => 'global_'
            ]
        ];

        $new_logins = [];
        $new_transactions = [];
        $new_terminations = [];
        $new_users = [];
        $new_sitehits = [];

        foreach ($objects as $login) {
            $data = $counts->countLogins($login['code'], $login['extension']);
            $new_logins += $data;
        }

        foreach ($objects as $transaction) {
            $data = $counts->countTransactions($transaction['id'], $transaction['extension']);
            $new_transactions += $data;
        }

        foreach ($objects as $termination) {
            $data = $counts->countTerminations($termination['id'], $termination['extension']);
            $new_terminations += $data;
        }

        foreach ($objects as $user) {
            $data = $counts->countNewUsers($user['id'], $user['extension']);
            $new_users += $data;
        }

        foreach ($objects as $hit) {
            $data = $counts->countSiteHits($hit['extension']);
            $new_sitehits += $data;
        }

        return array(
            'new_registration' => $new_users,
            'terminations' => $new_terminations,
            'transactions' => $new_transactions,
            'site_hits' => $new_sitehits,
            'logins' => $new_logins,
        );

    }

}
