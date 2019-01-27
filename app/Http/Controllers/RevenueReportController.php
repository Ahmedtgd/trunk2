<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class RevenueReportController extends Controller
{

    // Function to show the main page

    public function index() {
        return view('revenueReport.index');
    }

    public function overallRevenuePie(){
        $data=$this->overallRevenuePieData();
		return view('revenueReport.overallRevenue.overallRevenue',
			compact('data'));
    }
    
    public function overallRevenuePieData($option=null){
        $curYear= date('Y');
        $subscription= DB::select("select count(id)*(select global.merchant_annual_subscription_fee from global LIMIT 1) as total_subs_fee,month(merchant.created_at)as month from merchant where created_at LIKE '$curYear%' group by left(merchant.created_at,7)");

        $comission= DB::select("select (sum(payment.receivable) * COALESCE(sum(merchant.osmall_commission),1))as totalComission,month(porder.created_at)as month from porder
LEFT JOIN payment ON porder.payment_id= payment.id
LEFT join merchant ON porder.user_id=merchant.user_id
where porder.created_at LIKE '$curYear%' group by left(porder.created_at,7) ;
");

		$logistic= DB::select("select (sum(orderproduct.shipping_cost) * (select global.merchant_annual_subscription_fee from global LIMIT 1))as totalLogistic,
month(orderproduct.created_at)as month from orderproduct
 where created_at LIKE '$curYear%' group by left(orderproduct.created_at,7)");

		$smm= DB::select("select sum(payment.receivable) as smmAmount,month(porder.created_at)as month from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$curYear%' group by left(porder.created_at,7)");

		$advertise= DB::select("select sum(payment.receivable) as smmAmount,month(porder.created_at)as month from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$curYear%' group by left(porder.created_at,7)");

		$pusher= DB::select("select sum(payment.receivable) as smmAmount,month(porder.created_at)as month from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$curYear%' group by left(porder.created_at,7)");

        //echo "<pre>";

        //print_r($data);

		$year=['','January','February','March','April','May',
			'June','July','August','September','October','November','December'];

        for($i=1;$i<=12;$i++){
            $subscriptionData=0;
            $commissionData=0;
            $logisticData=0;
            $smmData=0;
            $advertiseData=0;
            $pusherData=0;
            $flag=0;
            foreach($subscription as $val){
                if($val->month==$i){
                    $subscriptionData=$val->total_subs_fee;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $subscriptionData=0;
            }

        foreach($comission as $val){
                if($val->month==$i){
                    $comissionData=$val->totalComission;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $comissionData=0;
            }
        foreach($logistic as $val){
                if($val->month==$i){
                    $logisticData=$val->totalLogistic;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $logisticData=0;
            }

        foreach($smm as $val){
                if($val->month==$i){
                    $smmData=$val->smmAmount;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $smmData=0;
            }
    foreach($advertise as $val){
                if($val->month==$i){
                    $advertiseData=$val->smmAmount;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $advertiseData=0;
            }
    foreach($pusher as $val){
                if($val->month==$i){
                    $pusherData=$val->smmAmount;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $pusherData=0;
            }

            $month= $year[$i];
            $data[$month]=array(
                'subscription' => number_format($subscriptionData/100,2),
                'commission'   => number_format($commissionData/100,2),
                'logistic'     => number_format($logisticData/100,2),
                'smm'          => number_format($smmData/100,2),
                'advertise'    => number_format($advertiseData/100,2),
                'pusher'       => number_format($pusherData/100,2)
                );

            }//end of for
            if($option==null)
                return $data;
        $totalSubs=$totalCommission=$totalLogistic=$totalSmm=$totalAdvertise=$totalPusher=0;

        foreach ($data as $value) {

            $totalSubs+=$value['subscription'];
            $totalCommission+=$value['commission'];
            $totalLogistic+=$value['logistic'];
            $totalSmm+=$value['smm'];
            $totalAdvertise+=$value['advertise'];
            $totalPusher+=$value['pusher'];
        }
        $d=array(
            ['Subscription',$totalSubs],
            ['Commission',$totalCommission],
            ['logistic',$totalLogistic],
            ['Advertisement',$totalAdvertise],
            ['SMM',$totalSmm],
            ['Pusher',$totalPusher],
            );

        return (json_encode($d,JSON_NUMERIC_CHECK));
    }

	public function categoryRevenuePie(){
		//$data=$this->overallRevenuePieData();
		return view('revenueReport.categoryRevenue.categoryRevenue');
	}

    public function loadCategoryRevenue($year, $month){
        $data=$this->categoryRevenuePieData($year, $month);
		 return view('revenueReport.categoryRevenue.loadCategoryRevenue',
		 	compact('data','year','month'));
    }
    
    public function categoryRevenuePieData($year,$month,$option=null){

        $date= $year."-".$month;
        $subscription= DB::select("select (count(merchant.id)*(select global.merchant_annual_subscription_fee from global LIMIT 1))as total_subs_fee,merchantcategory.category_id as cat_id,category.name from merchant 
INNER JOIN merchantcategory ON merchantcategory.merchant_id=merchant.id
INNER JOIN category ON merchantcategory.category_id=category.id

where merchant.created_at LIKE '$date%' group by merchantcategory.category_id");

        $comission= DB::select("select (sum(payment.receivable) * COALESCE(sum(merchant.osmall_commission),0))as total_commission,category.id as cat_id
from porder LEFT JOIN orderproduct ON orderproduct.porder_id=porder.id
LEFT JOIN product ON orderproduct.product_id= product.id
LEFT JOIN category ON product.category_id=category.id
LEFT JOIN payment ON porder.payment_id= payment.id
LEFT join merchant ON porder.user_id=merchant.user_id
where porder.created_at LIKE '$date%' group by product.category_id");

		$logistic= DB::select("select (sum(orderproduct.shipping_cost) * (select global.merchant_annual_subscription_fee from global LIMIT 1))as total_logistic,
category.id as cat_id,category.name from orderproduct
LEFT JOIN product ON orderproduct.product_id= product.id
LEFT JOIN category ON product.category_id= category.id
 where orderproduct.created_at LIKE '$date%' group by product.category_id");

		$smm= DB::select("select sum(payment.receivable) as smm_amount,category.id as cat_id, category.name from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN orderproduct ON orderproduct.porder_id=porder.id
INNER JOIN product ON orderproduct.product_id=product.id
INNER JOIN category ON product.category_id=category.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$date%' group by product.category_id");

		$advertise= DB::select("select (sum(orderproduct.shipping_cost) * (select global.merchant_annual_subscription_fee from global LIMIT 1))as total_advertise,
category.id as cat_id,category.name from orderproduct
LEFT JOIN product ON orderproduct.product_id= product.id
LEFT JOIN category ON product.category_id= category.id
 where orderproduct.created_at LIKE '$date%' group by product.category_id;");

		$pusher=DB::select("select (sum(orderproduct.shipping_cost) * (select global.merchant_annual_subscription_fee from global LIMIT 1))as total_pusher,
category.id as cat_id,category.name from orderproduct
LEFT JOIN product ON orderproduct.product_id= product.id
LEFT JOIN category ON product.category_id= category.id
 where orderproduct.created_at LIKE '$date%' group by product.category_id");
        //echo "<pre>";


		$categories= DB::table('category')->orderBy('name','ASC')->get();

        for($i=0;$i<count($categories);$i++){

            $subscriptionData=0;
            $commissionData=0;
            $logisticData=0;
            $smmData=0;
            $advertiseData=0;
            $pusherData=0;
            $flag=0;

            foreach($subscription as $val){
                if($val->cat_id==$categories[$i]->id){
                    $subscriptionData=$val->total_subs_fee;
                    $flag=1;
                    break;
                }else{
                    continue;
                }
            }
            if($flag==0){
                $subscriptionData=0;
            }

			foreach($comission as $val){
                if($val->cat_id==$categories[$i]->id){
                    $comissionData=$val->total_commission;
                    $flag=1;
                    break;
                }else{
                    continue;
                }
            }
            if($flag==0){
                $comissionData=0;
            }

			foreach($logistic as $val){
                if($val->cat_id==$categories[$i]->id){
                    $logisticData=$val->total_logistic;
                    $flag=1;
                    break;
                }else{
                    continue;
                }
            }
            if($flag==0){
                $logisticData=0;
            }

			foreach($smm as $val){
                if($val->cat_id==$categories[$i]->id){
                    $smmData=$val->smm_amount;
                    $flag=1;
                    break;
                }else{
                    continue;
                }
            }
            if($flag==0){
                $smmData=0;
            }

			foreach($advertise as $val){
                if($val->cat_id==$categories[$i]->id){
                    $advertiseData=$val->total_advertise;
                    $flag=1;
                    break;
                }else{
                    continue;
                }
            }
            if($flag==0){
                $advertiseData=0;
            }

			foreach($pusher as $val){
                if($val->cat_id==$categories[$i]->id){
                    $pusherData=$val->total_pusher;
                    $flag=1;
                    break;
                }else{
                    continue;
                }
            }
            if($flag==0){
                $pusherData=0;
            }

            
            $data[$categories[$i]->description]=array(
                'subscription' => number_format($subscriptionData/100,2),
                'commission'   => number_format($commissionData/100,2),
                'logistic'     => number_format($logisticData/100,2),
                'smm'          => number_format($smmData/100,2),
                'advertise'    => number_format($advertiseData/100,2),
                'pusher'       => number_format($pusherData/100,2)
                );

            }//end of for
            if($option==null)
                return $data;
        $totalSubs=$totalCommission=$totalLogistic=$totalSmm=$totalAdvertise=$totalPusher=0;

        foreach ($data as $value) {

            $totalSubs+=$value['subscription'];
            $totalCommission+=$value['commission'];
            $totalLogistic+=$value['logistic'];
            $totalSmm+=$value['smm'];
            $totalAdvertise+=$value['advertise'];
            $totalPusher+=$value['pusher'];
        }
        $d=array(
            ['Subscription',$totalSubs],
            ['Commission',$totalCommission],
            ['logistic',$totalLogistic],
            ['Advertisement',$totalAdvertise],
            ['SMM',$totalSmm],
            ['Pusher',$totalPusher],
            );
        return (json_encode($d,JSON_NUMERIC_CHECK));
    }

public function subCategoryRevenuePie(){
    $categories= DB::table('category')->orderBy('name','ASC')->get();
    return view('revenueReport.subCategoryRevenue.subCategoryRevenue',
		compact('categories'));
}

public function loadSubCategoryRevenue($year,$month,$categoryId){
    $data=$this->subCategoryRevenuePieData($year,$month,$categoryId);
	return view('revenueReport.subCategoryRevenue.loadSubCategoryRevenue',
		compact('year','month','data','categoryId'));
}

public function subCategoryRevenuePieData($year,$month,$categoryId,$option=null){
        $date= $year."-".$month;
        $subscription= DB::select("select (count(merchant.id)*(select global.merchant_annual_subscription_fee from global LIMIT 1))as total_subs_fee,
subcat_level_1.id as sub_cat_id , subcat_level_1.name from merchant 
INNER JOIN merchantcategory ON merchantcategory.merchant_id=merchant.id
INNER JOIN category ON merchantcategory.category_id=category.id
INNER JOIN subcat_level_1 ON subcat_level_1.category_id=category.id
where (merchant.created_at LIKE '$date%' and category.id='$categoryId') group by subcat_level_1.id");

        $comission= DB::select("select (sum(payment.receivable) * COALESCE(sum(merchant.osmall_commission),0))as total_commission,category.id as cat_id,
subcat_level_1.name,subcat_level_1.id as sub_cat_id
from porder LEFT JOIN orderproduct ON orderproduct.porder_id=porder.id
LEFT JOIN product ON orderproduct.product_id= product.id
LEFT JOIN category ON product.category_id=category.id
LEFT JOIN subcat_level_1 ON subcat_level_1.category_id=category.id
LEFT JOIN payment ON porder.payment_id= payment.id
LEFT join merchant ON porder.user_id=merchant.user_id

where (porder.created_at LIKE '$date%' and category.id='$categoryId') group by subcat_level_1.id");

                $logistic= DB::select("select (sum(orderproduct.shipping_cost) * (select global.merchant_annual_subscription_fee from global LIMIT 1))as total_logistic,
subcat_level_1.id as sub_cat_id from orderproduct
LEFT JOIN product ON orderproduct.product_id= product.id
LEFT JOIN category ON product.category_id= category.id
LEFT JOIN subcat_level_1 ON subcat_level_1.category_id=category.id
 where orderproduct.created_at LIKE '$date%' and category.id='$categoryId' group by subcat_level_1.id");

                $smm= DB::select("select sum(payment.receivable) as smm_amount,subcat_level_1.id as sub_cat_id,subcat_level_1.name from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN orderproduct ON orderproduct.porder_id=porder.id
INNER JOIN product ON orderproduct.product_id=product.id
INNER JOIN category ON product.category_id=category.id
INNER JOIN subcat_level_1 ON subcat_level_1.category_id=category.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$date%'and category.id='$categoryId' group by subcat_level_1.id");

                $advertise= DB::select("select (sum(orderproduct.shipping_cost) * (select global.merchant_annual_subscription_fee from global LIMIT 1))as total_advertise,
subcat_level_1.id as sub_cat_id from orderproduct
LEFT JOIN product ON orderproduct.product_id= product.id
LEFT JOIN category ON product.category_id= category.id
LEFT JOIN subcat_level_1 ON subcat_level_1.category_id=category.id
 where orderproduct.created_at LIKE '$date%' and category.id='$categoryId' group by subcat_level_1.id");

                $pusher=DB::select("select (sum(orderproduct.shipping_cost) * (select global.merchant_annual_subscription_fee from global LIMIT 1))as total_pusher,
subcat_level_1.id as sub_cat_id from orderproduct
LEFT JOIN product ON orderproduct.product_id= product.id
LEFT JOIN category ON product.category_id= category.id
LEFT JOIN subcat_level_1 ON subcat_level_1.category_id=category.id
 where orderproduct.created_at LIKE '$date%' and category.id='$categoryId' group by subcat_level_1.id");

$subCategories= DB::table('subcat_level_1')->where('category_id',"$categoryId")->get();
        for($i=0;$i<count($subCategories);$i++){

            $subscriptionData=0;
            $commissionData=0;
            $logisticData=0;
            $smmData=0;
            $advertiseData=0;
            $pusherData=0;
            $flag=0;
            foreach($subscription as $val){
                if($val->sub_cat_id==$subCategories[$i]->id){
                    $subscriptionData=$val->total_subs_fee;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $subscriptionData=0;
            }

        foreach($comission as $val){
                if($val->sub_cat_id==$subCategories[$i]->id){
                    $comissionData=$val->total_commission;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $comissionData=0;
            }
        foreach($logistic as $val){
                if($val->sub_cat_id==$subCategories[$i]->id){
                    $logisticData=$val->total_logistic;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $logisticData=0;
            }

        foreach($smm as $val){
                if($val->sub_cat_id==$subCategories[$i]->id){
                    $smmData=$val->smm_amount;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $smmData=0;
            }
    foreach($advertise as $val){
                if($val->sub_cat_id==$subCategories[$i]->id){
                    $advertiseData=$val->total_advertise;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $advertiseData=0;
            }
    foreach($pusher as $val){
                if($val->sub_cat_id==$subCategories[$i]->id){
                    $pusherData=$val->total_pusher;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $pusherData=0;
            }

            
            $data[$subCategories[$i]->name]=array(
                'subscription' => number_format($subscriptionData/100,2),
                'commission'   => number_format($commissionData/100,2),
                'logistic'     => number_format($logisticData/100,2),
                'smm'          => number_format($smmData/100,2),
                'advertise'    => number_format($advertiseData/100,2),
                'pusher'       => number_format($pusherData/100,2)
                );

            }//end of for
            if($option==null)
                return $data;
        $totalSubs=$totalCommission=$totalLogistic=$totalSmm=$totalAdvertise=$totalPusher=0;

        foreach ($data as $value) {

            $totalSubs+=$value['subscription'];
            $totalCommission+=$value['commission'];
            $totalLogistic+=$value['logistic'];
            $totalSmm+=$value['smm'];
            $totalAdvertise+=$value['advertise'];
            $totalPusher+=$value['pusher'];
        }
        $d=array(
            ['Subscription',$totalSubs],
            ['Commission',$totalCommission],
            ['logistic',$totalLogistic],
            ['Advertisement',$totalAdvertise],
            ['SMM',$totalSmm],
            ['Pusher',$totalPusher],
            );
        return (json_encode($d,JSON_NUMERIC_CHECK));
    }

    public function merchantRevenuePie(){
        $data=$this->merchantRevenuePieData();
return view('revenueReport.merchantRevenue.merchantRevenue',compact('data'));
    }
    
    public function merchantRevenuePieData($option=null){

        $date= date('Y');
        $subscription= DB::select("select (count(merchant.id)*(select global.merchant_annual_subscription_fee from global LIMIT 1))as total_subs_fee,
merchant.id as merchant_id from merchant WHERE merchant.created_at LIKE '$date%'  group by merchant.id");

        $comission= DB::select("select (sum(payment.receivable) * COALESCE(sum(merchant.osmall_commission),0))as total_commission,merchant.id as merchant_id
from porder LEFT JOIN orderproduct ON orderproduct.porder_id=porder.id
LEFT JOIN payment ON porder.payment_id= payment.id
LEFT join merchant ON porder.user_id=merchant.user_id
where porder.created_at LIKE '$date%' group by merchant.id");

                $logistic= DB::select("select (sum(orderproduct.shipping_cost) * (select global.merchant_annual_subscription_fee from global LIMIT 1))as total_logistic,
merchantproduct.merchant_id as merchant_id,category.name from orderproduct
LEFT JOIN product ON orderproduct.product_id= product.id
LEFT JOIN merchantproduct ON product.id=merchantproduct.product_id
LEFT JOIN category ON product.category_id= category.id
 where orderproduct.created_at LIKE '$date%' group by merchantproduct.merchant_id");

                $smm= DB::select("select sum(payment.receivable) as smm_amount,merchantproduct.merchant_id as merchant_id from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN orderproduct ON orderproduct.porder_id=porder.id
INNER JOIN product ON orderproduct.product_id=product.id
INNER JOIN merchantproduct ON merchantproduct.product_id=product.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$date%' group by merchantproduct.merchant_id");

                $advertise= DB::select("select (count(merchant.id)*(select global.merchant_annual_subscription_fee from global LIMIT 1))as total_advertise,
merchant.id as merchant_id from merchant WHERE merchant.created_at LIKE '$date%'  group by merchant.id");

                $pusher=DB::select("select (count(merchant.id)*(select global.merchant_annual_subscription_fee from global LIMIT 1))as total_pusher,
merchant.id as merchant_id from merchant WHERE merchant.created_at LIKE '$date%'  group by merchant.id");
        //echo "<pre>";



$merchants= DB::table('merchant')->orderBy('company_name','ASC')->get();
        for($i=0;$i<count($merchants);$i++){

            $subscriptionData=0;
            $commissionData=0;
            $logisticData=0;
            $smmData=0;
            $advertiseData=0;
            $pusherData=0;
            $flag=0;
            foreach($subscription as $val){
                if($val->merchant_id==$merchants[$i]->id){
                    $subscriptionData=$val->total_subs_fee;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $subscriptionData=0;
            }

        foreach($comission as $val){
                if($val->merchant_id==$merchants[$i]->id){
                    $comissionData=$val->total_commission;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $comissionData=0;
            }
        foreach($logistic as $val){
                if($val->merchant_id==$merchants[$i]->id){
                    $logisticData=$val->total_logistic;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $logisticData=0;
            }

        foreach($smm as $val){
                if($val->merchant_id==$merchants[$i]->id){
                    $smmData=$val->smm_amount;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $smmData=0;
            }
    foreach($advertise as $val){
                if($val->merchant_id==$merchants[$i]->id){
                    $advertiseData=$val->total_advertise;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $advertiseData=0;
            }
    foreach($pusher as $val){
                if($val->merchant_id==$merchants[$i]->id){
                    $pusherData=$val->total_pusher;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $pusherData=0;
            }

            
            $data[$merchants[$i]->company_name]=array(
                'merchant_id' =>$merchants[$i]->id,
                'subscription' => number_format($subscriptionData/100,2),
                'commission'   => number_format($commissionData/100,2),
                'logistic'     => number_format($logisticData/100,2),
                'smm'          => number_format($smmData/100,2),
                'advertise'    => number_format($advertiseData/100,2),
                'pusher'       => number_format($pusherData/100,2)
                );

            }//end of for
            if($option==null)
                return $data;
        $totalSubs=$totalCommission=$totalLogistic=$totalSmm=$totalAdvertise=$totalPusher=0;

        foreach ($data as $value) {

            $totalSubs+=$value['subscription'];
            $totalCommission+=$value['commission'];
            $totalLogistic+=$value['logistic'];
            $totalSmm+=$value['smm'];
            $totalAdvertise+=$value['advertise'];
            $totalPusher+=$value['pusher'];
        }
        $d=array(
            ['Subscription',$totalSubs],
            ['Commission',$totalCommission],
            ['logistic',$totalLogistic],
            ['Advertisement',$totalAdvertise],
            ['SMM',$totalSmm],
            ['Pusher',$totalPusher],
            );
        return (json_encode($d,JSON_NUMERIC_CHECK));
    }


    public function productARevenuePie(){
        $data=$this->productARevenuePieData();
return view('revenueReport.productARevenue.productARevenue',compact('data'));
    }
    
    public function productARevenuePieData($option=null){

        $date= date('Y');
        $subscription= DB::select("select (count(merchant.id)*(select global.merchant_annual_subscription_fee from global LIMIT 1))as total_subs_fee,
product.id as product_id,product.name from merchant
INNER JOIN merchantproduct ON merchantproduct.merchant_id=merchant.id
INNER JOIN product ON merchantproduct.product_id=product.id
WHERE merchantproduct.created_at LIKE '$date'
 group by product.id");

        $comission= DB::select("select (sum(payment.receivable) * COALESCE(sum(merchant.osmall_commission),0))as total_commission,merchantproduct.product_id as product_id
from porder LEFT JOIN orderproduct ON orderproduct.porder_id=porder.id
LEFT JOIN payment ON porder.payment_id= payment.id
LEFT join merchant ON porder.user_id=merchant.user_id
LEFT join merchantproduct ON merchant.id=merchantproduct.merchant_id
where porder.created_at LIKE '$date%' group by merchantproduct.product_id");

                $logistic= DB::select("select (sum(orderproduct.shipping_cost) * (select global.merchant_annual_subscription_fee from global LIMIT 1))as total_logistic,
product.id as product_id,product.name from orderproduct
LEFT JOIN product ON orderproduct.product_id= product.id
 where orderproduct.created_at LIKE '$date%' group by product.id");

                $smm= DB::select("select sum(payment.receivable) as smm_amount,product.id as product_id,product.name from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN orderproduct ON orderproduct.porder_id=porder.id
INNER JOIN product ON orderproduct.product_id=product.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$date%' group by product.id");

                $advertise= DB::select("select sum(payment.receivable) as total_advertise,product.id as product_id,product.name from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN orderproduct ON orderproduct.porder_id=porder.id
INNER JOIN product ON orderproduct.product_id=product.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$date%' group by product.id");

                $pusher=DB::select("select sum(payment.receivable) as total_pusher,product.id as product_id,product.name from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN orderproduct ON orderproduct.porder_id=porder.id
INNER JOIN product ON orderproduct.product_id=product.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$date%' group by product.id");
        //echo "<pre>";



$products= DB::table('product')->select('product.id' ,
				  'product.name' ,
				  'product.brand_id' ,
				  'product.parent_id' ,
				  'product.category_id' ,
				  'product.subcat_id' ,
				  'product.subcat_level'  ,
				  'product.segment' ,
				  'product.photo_1' ,
				  'product.photo_2' ,
				  'product.photo_3' ,
				  'product.photo_4' ,
				  'product.photo_5' ,
				  'product.adimage_1' ,
				  'product.adimage_2' ,
				  'product.adimage_3' ,
				  'product.adimage_4' ,
				  'product.adimage_5' ,
				  'product.description' ,
				  'product.free_delivery' ,
				  'product.free_delivery_with_purchase_qty' ,
				  'product.views' ,
				  'product.display_non_autolink' ,
				  'product.del_worldwide'  ,
				  'product.del_west_malaysia'  ,
				  'product.del_sabah_labuan'  ,
				  'product.del_sarawak'  ,
				  'product.cov_country_id' ,
				  'product.cov_state_id' ,
				  'product.cov_city_id' ,
				  'product.cov_area_id' ,
				  'product.b2b_del_worldwide' ,
				  'product.b2b_del_west_malaysia' ,
				  'product.b2b_del_sabah_labuan' ,
				  'product.b2b_del_sarawak' ,
				  'product.b2b_cov_country_id' ,
				  'product.b2b_cov_state_id' ,
				  'product.b2b_cov_city_id' ,
				  'product.b2b_cov_area_id' ,
				  'product.del_pricing'  ,
				  'product.del_width'  ,
				  'product.del_lenght'  ,
				  'product.del_height'  ,
				  'product.del_weight'  ,
				  'product.weight'  ,
				  'product.height'  ,
				  'product.width'  ,
				  'product.length'  ,
				  'product.del_option' ,
				  'product.retail_price' ,
				  'product.original_price' ,
				  'product.discounted_price',
				  'product.private_retail_price' ,
				  'product.private_discounted_price' ,
				  'product.stock' ,
				  'product.available' ,
				  'product.private_available' ,
				  'product.b2b_available' ,
				  'product.hyper_available' ,
				  'product.owarehouse_moq' ,
				  'product.owarehouse_moqpb' ,
				  'product.owarehouse_moqperpax' ,
				  'product.owarehouse_price' ,
				  'product.measure'  ,
				  'product.owarehouse_units' ,
				  'product.owarehouse_ave_unit_price' ,
				  'product.type'  ,
				  'product.owarehouse_duration' ,
				  'product.smm_selected'  ,
				  'product.oshop_selected'  ,
				  'product.mc_sales_staff_id' ,
				  'product.referral_sales_staff_id' ,
				  'product.mcp1_sales_staff_id' ,
				  'product.mcp2_sales_staff_id' ,
				  'product.psh_sales_staff_id' ,
				  'product.osmall_commission'  ,
				  'product.b2b_osmall_commission'  ,
				  'product.mc_sales_staff_commission'  ,
				  'product.mc_with_ref_sales_staff_commission'  ,
				  'product.referral_sales_staff_commission'  ,
				  'product.mcp1_sales_staff_commission'  ,
				  'product.mcp2_sales_staff_commission'  ,
				  'product.smm_sales_staff_commission'  ,
				  'product.psh_sales_staff_commission'  ,
				  'product.str_sales_staff_commission'  ,
				  'product.return_policy' ,
				  'product.return_address_id' ,
				  'product.status' ,
				  'product.active_date'  ,
				  'product.deleted_at'  ,
				  'product.created_at' ,
				  'product.updated_at')->orderBy('name','ASC')->get();
        for($i=0;$i<count($products);$i++){

            $subscriptionData=0;
            $commissionData=0;
            $logisticData=0;
            $smmData=0;
            $advertiseData=0;
            $pusherData=0;
            $flag=0;
            foreach($subscription as $val){
                if($val->product_id==$products[$i]->id){
                    $subscriptionData=$val->total_subs_fee;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $subscriptionData=0;
            }

        foreach($comission as $val){
                if($val->product_id==$products[$i]->id){
                    $comissionData=$val->total_commission;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $comissionData=0;
            }
        foreach($logistic as $val){
                if($val->product_id==$products[$i]->id){
                    $logisticData=$val->total_logistic;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $logisticData=0;
            }

        foreach($smm as $val){
                if($val->product_id==$products[$i]->id){
                    $smmData=$val->smm_amount;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $smmData=0;
            }
    foreach($advertise as $val){
                if($val->product_id==$products[$i]->id){
                    $advertiseData=$val->total_advertise;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $advertiseData=0;
            }
    foreach($pusher as $val){
                if($val->product_id==$products[$i]->id){
                    $pusherData=$val->total_pusher;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $pusherData=0;
            }

            
            $data[$products[$i]->name]=array(
                'product_id' =>$products[$i]->id,
                'subscription' => number_format($subscriptionData/100,2),
                'commission'   => number_format($commissionData/100,2),
                'logistic'     => number_format($logisticData/100,2),
                'smm'          => number_format($smmData/100,2),
                'advertise'    => number_format($advertiseData/100,2),
                'pusher'       => number_format($pusherData/100,2)
                );

            }//end of for
            if($option==null)
                return $data;
        $totalSubs=$totalCommission=$totalLogistic=$totalSmm=$totalAdvertise=$totalPusher=0;

        foreach ($data as $value) {

            $totalSubs+=$value['subscription'];
            $totalCommission+=$value['commission'];
            $totalLogistic+=$value['logistic'];
            $totalSmm+=$value['smm'];
            $totalAdvertise+=$value['advertise'];
            $totalPusher+=$value['pusher'];
        }
        $d=array(
            ['Subscription',$totalSubs],
            ['Commission',$totalCommission],
            ['logistic',$totalLogistic],
            ['Advertisement',$totalAdvertise],
            ['SMM',$totalSmm],
            ['Pusher',$totalPusher],
            );
        return (json_encode($d,JSON_NUMERIC_CHECK));
    }

public function productBRevenuePie(){
        $data=$this->productBRevenuePieData();
return view('revenueReport.productBRevenue.productBRevenue',compact('data'));
    }
    
    public function productBRevenuePieData($option=null){

        $date= date('Y');
        $subscription= DB::select("select (count(merchant.id)*(select global.merchant_annual_subscription_fee from global LIMIT 1))as total_subs_fee,
product.id as product_id,product.name from merchant
INNER JOIN merchantproduct ON merchantproduct.merchant_id=merchant.id
INNER JOIN product ON merchantproduct.product_id=product.id
WHERE merchantproduct.created_at LIKE '$date'
 group by product.id");

        $comission= DB::select("select (sum(payment.receivable) * COALESCE(sum(merchant.osmall_commission),0))as total_commission,merchantproduct.product_id as product_id
from porder LEFT JOIN orderproduct ON orderproduct.porder_id=porder.id
LEFT JOIN payment ON porder.payment_id= payment.id
LEFT join merchant ON porder.user_id=merchant.user_id
LEFT join merchantproduct ON merchant.id=merchantproduct.merchant_id
where porder.created_at LIKE '$date%' group by merchantproduct.product_id");

                $logistic= DB::select("select (sum(orderproduct.shipping_cost) * (select global.merchant_annual_subscription_fee from global LIMIT 1))as total_logistic,
product.id as product_id,product.name from orderproduct
LEFT JOIN product ON orderproduct.product_id= product.id
 where orderproduct.created_at LIKE '$date%' group by product.id");

                $smm= DB::select("select sum(payment.receivable) as smm_amount,product.id as product_id,product.name from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN orderproduct ON orderproduct.porder_id=porder.id
INNER JOIN product ON orderproduct.product_id=product.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$date%' group by product.id");

                $advertise= DB::select("select sum(payment.receivable) as total_advertise,product.id as product_id,product.name from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN orderproduct ON orderproduct.porder_id=porder.id
INNER JOIN product ON orderproduct.product_id=product.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$date%' group by product.id");

                $pusher=DB::select("select sum(payment.receivable) as total_pusher,product.id as product_id,product.name from smmout 
INNER JOIN smmin ON smmin.smmout_id=smmout.id
INNER JOIN porder ON smmin.porder_id=porder.id
INNER JOIN orderproduct ON orderproduct.porder_id=porder.id
INNER JOIN product ON orderproduct.product_id=product.id
INNER JOIN payment ON porder.payment_id=payment.id
WHERE smmin.response='buy' and porder.created_at LIKE '$date%' group by product.id");
        //echo "<pre>";



$products= DB::table('product')->select('product.id' ,
				  'product.name' ,
				  'product.brand_id' ,
				  'product.parent_id' ,
				  'product.category_id' ,
				  'product.subcat_id' ,
				  'product.subcat_level'  ,
				  'product.segment' ,
				  'product.photo_1' ,
				  'product.photo_2' ,
				  'product.photo_3' ,
				  'product.photo_4' ,
				  'product.photo_5' ,
				  'product.adimage_1' ,
				  'product.adimage_2' ,
				  'product.adimage_3' ,
				  'product.adimage_4' ,
				  'product.adimage_5' ,
				  'product.description' ,
				  'product.free_delivery' ,
				  'product.free_delivery_with_purchase_qty' ,
				  'product.views' ,
				  'product.display_non_autolink' ,
				  'product.del_worldwide'  ,
				  'product.del_west_malaysia'  ,
				  'product.del_sabah_labuan'  ,
				  'product.del_sarawak'  ,
				  'product.cov_country_id' ,
				  'product.cov_state_id' ,
				  'product.cov_city_id' ,
				  'product.cov_area_id' ,
				  'product.b2b_del_worldwide' ,
				  'product.b2b_del_west_malaysia' ,
				  'product.b2b_del_sabah_labuan' ,
				  'product.b2b_del_sarawak' ,
				  'product.b2b_cov_country_id' ,
				  'product.b2b_cov_state_id' ,
				  'product.b2b_cov_city_id' ,
				  'product.b2b_cov_area_id' ,
				  'product.del_pricing'  ,
				  'product.del_width'  ,
				  'product.del_lenght'  ,
				  'product.del_height'  ,
				  'product.del_weight'  ,
				  'product.weight'  ,
				  'product.height'  ,
				  'product.width'  ,
				  'product.length'  ,
				  'product.del_option' ,
				  'product.retail_price' ,
				  'product.original_price' ,
				  'product.discounted_price',
				  'product.private_retail_price' ,
				  'product.private_discounted_price' ,
				  'product.stock' ,
				  'product.available' ,
				  'product.private_available' ,
				  'product.b2b_available' ,
				  'product.hyper_available' ,
				  'product.owarehouse_moq' ,
				  'product.owarehouse_moqpb' ,
				  'product.owarehouse_moqperpax' ,
				  'product.owarehouse_price' ,
				  'product.measure'  ,
				  'product.owarehouse_units' ,
				  'product.owarehouse_ave_unit_price' ,
				  'product.type'  ,
				  'product.owarehouse_duration' ,
				  'product.smm_selected'  ,
				  'product.oshop_selected'  ,
				  'product.mc_sales_staff_id' ,
				  'product.referral_sales_staff_id' ,
				  'product.mcp1_sales_staff_id' ,
				  'product.mcp2_sales_staff_id' ,
				  'product.psh_sales_staff_id' ,
				  'product.osmall_commission'  ,
				  'product.b2b_osmall_commission'  ,
				  'product.mc_sales_staff_commission'  ,
				  'product.mc_with_ref_sales_staff_commission'  ,
				  'product.referral_sales_staff_commission'  ,
				  'product.mcp1_sales_staff_commission'  ,
				  'product.mcp2_sales_staff_commission'  ,
				  'product.smm_sales_staff_commission'  ,
				  'product.psh_sales_staff_commission'  ,
				  'product.str_sales_staff_commission'  ,
				  'product.return_policy' ,
				  'product.return_address_id' ,
				  'product.status' ,
				  'product.active_date'  ,
				  'product.deleted_at'  ,
				  'product.created_at' ,
				  'product.updated_at')->orderBy('name','ASC')->get();
        for($i=0;$i<count($products);$i++){

            $subscriptionData=0;
            $commissionData=0;
            $logisticData=0;
            $smmData=0;
            $advertiseData=0;
            $pusherData=0;
            $flag=0;
            foreach($subscription as $val){
                if($val->product_id==$products[$i]->id){
                    $subscriptionData=$val->total_subs_fee;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $subscriptionData=0;
            }

        foreach($comission as $val){
                if($val->product_id==$products[$i]->id){
                    $comissionData=$val->total_commission;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $comissionData=0;
            }
        foreach($logistic as $val){
                if($val->product_id==$products[$i]->id){
                    $logisticData=$val->total_logistic;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $logisticData=0;
            }

        foreach($smm as $val){
                if($val->product_id==$products[$i]->id){
                    $smmData=$val->smm_amount;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $smmData=0;
            }
    foreach($advertise as $val){
                if($val->product_id==$products[$i]->id){
                    $advertiseData=$val->total_advertise;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $advertiseData=0;
            }
    foreach($pusher as $val){
                if($val->product_id==$products[$i]->id){
                    $pusherData=$val->total_pusher;
                    $flag=1;
                    break;
                }else{
                    continue;
                }

            }
            if($flag==0){
                $pusherData=0;
            }

            
            $data[$products[$i]->name]=array(
                'product_id' =>$products[$i]->id,
                'subscription' => number_format($subscriptionData/100,2),
                'commission'   => number_format($commissionData/100,2),
                'logistic'     => number_format($logisticData/100,2),
                'smm'          => number_format($smmData/100,2),
                'advertise'    => number_format($advertiseData/100,2),
                'pusher'       => number_format($pusherData/100,2)
                );

            }//end of for
            if($option==null)
                return $data;
        $totalSubs=$totalCommission=$totalLogistic=$totalSmm=$totalAdvertise=$totalPusher=0;

        foreach ($data as $value) {

            $totalSubs+=$value['subscription'];
            $totalCommission+=$value['commission'];
            $totalLogistic+=$value['logistic'];
            $totalSmm+=$value['smm'];
            $totalAdvertise+=$value['advertise'];
            $totalPusher+=$value['pusher'];
        }
        $d=array(
            ['Sales',$totalSubs],
            ['Retail',$totalCommission],
            ['B2B',$totalLogistic],
            ['Export',$totalAdvertise],
            ['O-Warehouse',$totalSmm],
            ['OEM/ODM',$totalPusher],
            );
        return (json_encode($d,JSON_NUMERIC_CHECK));
    }

}
