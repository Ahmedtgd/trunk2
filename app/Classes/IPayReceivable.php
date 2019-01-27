<?php namespace App\Classes;

use DB;
/*
This is not a class for IPay. This is a generic class for all records with all payment gateway and not just ipay88.
Correct name should be PG_Receivable.
~Zurez
*/ 
class IPayReceivable{

    public function get_ipay()
    {

        try {
            //get global settings
            if(!$global = DB::table('global')->first()) return;

            //expense
            $bank_transfer_fee = ((int) $global->bank_transfer_fee) / 100;

            $ipay = DB::select("
                SELECT
                sum(p.receivable) *  $bank_transfer_fee as expense,
                sum(p.receivable) - ($bank_transfer_fee * sum(p.receivable)) as receivable,
                sum(p.receivable) as sales,
                sum(pr.partial) as partial, pr.confirmation as confirmation, pr.remarks,

                WEEK(po.created_at) as week_number, pg.name as gateway_name, pg.id as gateway_id, p.id as payment_id,
                STR_TO_DATE(CONCAT(YEAR(po.created_at), WEEK(po.created_at) + 1, ' Thursday'), '%X%V %W') as due_date,

                case
                    when sum(pr.partial) > 0 then (sum(p.receivable) - ($bank_transfer_fee * sum(p.receivable))) - sum(pr.partial)
                    else 0
                end as balance

				FROM orderproduct op

				LEFT JOIN porder po ON po.id = op.porder_id
				LEFT JOIN users u ON po.user_id = u.id
				LEFT JOIN product pro ON pro.id = op.product_id
				LEFT JOIN payment p ON p.id = po.payment_id

				LEFT JOIN pgatewayporder pgp ON po.id = pgp.porder_id
				LEFT JOIN payment_gateway pg ON pgp.payment_gateway_id = pg.id
				LEFT JOIN payment_receivable pr ON pgp.payment_gateway_id = pr.id

                WHERE p.receivable <> 0
                AND pg.id = 1
                AND po.id = pgp.porder_id

                
            ");

        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return is_array($ipay) ? $ipay : null;
    }

    public function get_ipay_detail($week_number)
    {

        try {
            //get global settings
            if(!$global = DB::table('global')->first()) return;

            //expense
            $bank_transfer_fee = ((int) $global->bank_transfer_fee) / 100;

            $ipay = DB::select("
                SELECT
                po.id as order_id, po.status, $bank_transfer_fee * p.receivable as expense,
                p.receivable - ($bank_transfer_fee * p.receivable) as receivable, p.receivable as sales,
                u.id as user_id, pr.partial as partial, pr.confirmation as confirmation, pr.remarks,
                pg.name as gateway_name, pg.id as gateway_id, p.id as payment_id,

                STR_TO_DATE(CONCAT(YEAR(po.created_at), WEEK(po.created_at) + 1, ' Thursday'), '%X%V %W') as due_date,

                case
                    when pr.partial > 0 then (p.receivable - ($bank_transfer_fee * p.receivable)) - pr.partial
                    else 0
                end as balance

				FROM orderproduct op

				LEFT JOIN porder po ON po.id = op.porder_id
				LEFT JOIN users u ON po.user_id = u.id
				LEFT JOIN product pro ON pro.id = op.product_id
				LEFT JOIN payment p ON p.id = po.payment_id

				LEFT JOIN pgatewayporder pgp ON po.id = pgp.porder_id
				LEFT JOIN payment_gateway pg ON pgp.payment_gateway_id = pg.id
				LEFT JOIN payment_receivable pr ON pgp.payment_gateway_id = pr.id

                WHERE p.receivable <> 0
                AND pg.id = 1
                AND po.id = pgp.porder_id
                AND WEEK(po.created_at) = $week_number
                ORDER BY po.id DESC
            ");

        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return is_array($ipay) ? $ipay : null;
    }

}