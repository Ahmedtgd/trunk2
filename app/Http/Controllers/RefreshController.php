<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use App\Models\UserFlow;

class RefreshController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//For logins global

        $yrLogins = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from authtracker a, country c, users u where (c.code='MYS' or c.code='HKG') and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >= '2016-01-01 00:00:00'");

        $mnLogins = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where (c.code='MYS' or c.code='HKG') and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $dayLogins = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where (c.code='MYS' or c.code='HKG') and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >='2016-01-01 00:00:00'");

        $hrLogins = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from authtracker a, country c, users u where (c.code='MYS' or c.code='HKG') and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $minLogins = DB::SELECT("select count(*) as total from authtracker a, country c, users u where (c.code='MYS' or c.code='HKG') and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date(now()),interval -1 DAY)");

        $secLogins = DB::SELECT("select count(*) as total from authtracker a, country c, users u where (c.code='MYS' or c.code='HKG') and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(now(),interval -3600 SECOND)");        

//For new user registration global
        $yrUserReg = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from buyer b, country c, users u where (c.code='MYS' or c.code ='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00'");

        $mnUserReg = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $dayUserReg = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00'");

        $hrUserReg = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from buyer  b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $minUserReg = DB::SELECT("select count(*) as total from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= date_add(date(now()),interval -1 DAY)");

        $secUserReg = DB::SELECT("select count(*) as total from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(now(),interval -3600 SECOND)");

//for account termination global

        $yrAccTermination = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >= '2016-01-01 00:00:00' && b.status = 'terminated'");

        $mnAccTermination = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) && b.status = 'terminated'");

        $dayAccTermination = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >='2016-01-01 00:00:00' && b.status = 'terminated'");

        $hrAccTermination = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH) && b.status = 'terminated'");

        $minAccTermination = DB::SELECT("select count(*) as total from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(date(now()),interval -1 DAY) && b.status = 'terminated'");

        $secAccTermination = DB::SELECT("select count(*) as total from buyer b, country c, users u where (c.code='MYS' or c.code='HKG') and b.user_id=u.id and u.nationality_country_id=c.id and b.created_at >=date_add(now(),interval -3600 SECOND) && b.status = 'terminated'");

//For Transaction global

        $yrTransaction = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >= '2016-01-01 00:00:00'");

        $mnTransaction = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)  AND p.created_at >= '2016-01-01 00:00:00'");

        $dayTransaction = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >= '2016-01-01 00:00:00'");

        $hrTransaction = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $minTransaction = DB::SELECT("select count(*) as total from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(date(now()),interval -1 DAY)");

        $secTransaction = DB::SELECT("select count(*) as total from porder p, country c, users u where (c.code='MYS' or c.code='HKG') and p.user_id=u.id and u.nationality_country_id=c.id and p.created_at >=date_add(now(),interval -3600 SECOND)");

//For Page view global


        $yrPageView = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >= '2016-01-01 00:00:00'");

        $mnPageView = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)  AND v.created_at >= '2016-01-01 00:00:00'");

        $dayPageView = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >='2016-01-01 00:00:00'");

        $hrPageView = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $minPageView = DB::SELECT("select count(*) as total from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(date(now()),interval -1 DAY)");

        $secPageView = DB::SELECT("select count(*) as total from view_count v, country c, users u where (c.code='MYS' or c.code='HKG') and v.user_id=u.id and u.nationality_country_id=c.id and v.created_at >=date_add(now(),interval -3600 SECOND)");


/* 
    This is for Malaysia

*/

//For logins Malaysia

        $yrLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(YEAR,'2016-01-01 00:00:00',now())+1) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >= '2016-01-01 00:00:00'");

        $mnLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(MONTH,'2016-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at < date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $dayLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(DAY,'2015-01-01 00:00:00',now())) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >='2016-01-01 00:00:00'");

        $hrLoginsMalay = DB::SELECT("select count(*)/(TIMESTAMPDIFF(HOUR,date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH),now())) as avg from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date_add(LAST_DAY(date(now())),interval 1 DAY),interval -1 MONTH)");

        $minLoginsMalay = DB::SELECT("select count(*) as total from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(date(now()),interval -1 DAY)");

        $secLoginsMalay = DB::SELECT("select count(*) as total from authtracker a, country c, users u where c.code='MYS' and a.user_id = u.id and u.nationality_country_id=c.id and a.created_at >=date_add(now(),interval -3600 SECOND)");        

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



       return view('refresh',compact('yrLogins','mnLogins','dayLogins','hrLogins','minLogins','secLogins','yrUserReg','mnUserReg','dayUserReg','hrUserReg','minUserReg','secUserReg','yrAccTermination','mnAccTermination','dayAccTermination','hrAccTermination','minAccTermination','hrAccTermination','minAccTermination','secAccTermination','yrTransaction','mnTransaction','dayTransaction','hrTransaction','minTransaction','secTransaction','yrLoginsMalay','mnLoginsMalay','dayLoginsMalay','hrLoginsMalay','minLoginsMalay','secLoginsMalay','yrUserRegMalay','mnUserRegMalay','dayUserRegMalay','hrUserRegMalay','minUserRegMalay','secUserRegMalay','yrAccTerminationMalay','mnAccTerminationMalay','dayAccTerminationMalay','hrAccTerminationMalay','minAccTerminationMalay','secAccTerminationMalay','yrLoginsHongKong','mnLoginsHongKong','dayLoginsHongKong','hrLoginsHongKong','minLoginsHongKong','secLoginsHongKong','yrUserRegHongKong','mnUserRegHongKong','dayUserRegHongKong','hrUserRegHongKong','minUserRegHongKong','secUserRegHongKong','yrAccTerminationHongKong','mnAccTerminationHongKong','dayAccTerminationHongKong','hrAccTerminationHongKong','minAccTerminationHongKong','secAccTerminationHongKong','yrPageView','mnPageView','dayPageView','hrPageView','minPageView','secPageView','yrPageViewMalay','mnPageViewMalay','dayPageViewMalay','hrPageViewMalay','minPageViewMalay','secPageViewMalay','yrPageViewHongKong','mnPageViewHongKong','dayPageViewHongKong','hrPageViewHongKong','minPageViewHongKong','secPageViewHongKong','yrTransactionMalay','mnTransactionMalay','dayTransactionMalay','hrTransactionMalay','minTransactionMalay','secTransactionMalay','yrTransactionHongKong','mnTransactionHongKong','dayTransactionHongKong','hrTransactionHongKong','minTransactionHongKong','secTransactionHongKong'));                 
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
}
