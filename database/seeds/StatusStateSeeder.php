<?php

use Illuminate\Database\Seeder;

class StatusStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //php artisan db:seed --class=StatusStateSeeder
    public function run()
    {
        /*  Paul on 26 April 2017 at 11 pm
            Added l-processing1 as
            l-processing1 will replace l-processing in near future  */

		$porder_status = [
				["active","Active"],
				["hyper","Hyper"],
				["openwish","OpenWish"],
				["smm","SMM"],
				["manual","Manual"],
				["cancelreq","Cancel Request"],
				["returnreq","Return Request"],
				["undelivered","Undelivered"],
				["processing","Processing"],
				["deliveryinprogress","Delivery In Progress"],
				["complained","User Complain"],
				["executed","Executed"],
				["returned","Returned"],
				["partial","Partial"],
				["delivered","Delivery"],
				["pending","Pending"],
				["cancelled","Cancelled"],
				["m-processing1","Merchant Accepted"],
				["m-processing2","Merchant Call Logistic"],
				["l-processing","Logistic Accepted Merchant"],
				["l-collected","Logistic Collected Merchant"],
				["b-collected","Buyer Collected"],
				["b-returning","Return Approval"],
				["request_goods","Request Return Goods"],
				["rejected","Return Rejected"],
				["call_logistic1","Buyer Call Logistic"],
				["l-processing1","Logistic Accepted Buyer"],
				["l-collected1","Logistic Collected Buyer"],
				["m-collected","Merchant Collected"],
				["rejected1","Merchant Rejected"],
				["m-approved","Merchant Approved"],
				["reviewed","Review"],
				["rejected1","Merchant Rejected"],
				["reviewed1","Review"],
				["reviewed","Review"],
				["completed","Completed"],
				["commented","Commented"]
			];

        \DB::table('statusstate')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();

        for ($i = 0; $i < sizeof($porder_status); $i++) {
            \DB::table('statusstate')->insert([
                'name' => $porder_status[$i][0],
                'description' => $porder_status[$i][1],
//                'description' => ucfirst($porder_status[$i]),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
