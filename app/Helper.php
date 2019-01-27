<?php namespace App;

use Carbon\Carbon;

class Helper{


    public static function getMinVal($monthlySales){
        $min = $monthlySales[1];

        foreach ($monthlySales as $monthlySale) {
            if($min > $monthlySale){
                $min = $monthlySale;
            }
        }

        return number_format((float)$min, 2, '.', '');
    }

    public static function getMaxVal($monthlySales){
        $max = 0;

        foreach ($monthlySales as $monthlySale) {
            if($max < $monthlySale){
                $max = $monthlySale;
            }
        }

        return number_format((float)$max, 2, '.', '');
    }


    public static function getAvgDaySale($year, $monthlySales){
        $dailySale = [];
        foreach ($monthlySales as $month => $sale) {
            $dailySale[$month] = $sale / cal_days_in_month(CAL_GREGORIAN, $month, $year);;
        }

        return number_format((float)(array_sum ($dailySale) / 12), 2, '.', '');
    }

    public static function getTotalView($products){
        $hits = 0;

        foreach ($products as $product) {
            try{
                $hits += $product->adSlotProduct->hits->views;
            }catch (\Exception $e){
            }
        }

        return number_format((float)$hits, 2, '.', '');
    }

    public static function getAvgDeal($products){
        $deal = 0;
        $i = 0;

        foreach ($products as $product) {
            if(count($product->wholesale)){
                foreach($product->wholesale as $wholesale){
                    $i++;
                    $deal += $wholesale->price;
                }
            }
        }

        if($i == 0){
            return 0.00;
        }
        return number_format((float)($deal / $i), 2, '.', '');
    }


    //---CountProducts Method---//
    public static function countProducts($category, $merchant_pro){

        foreach ($category->subCatLevel1 as $sub_category) {
            if ($sub_category->product()->whereIn('id',$merchant_pro->lists('id','id'))->count()) {
                return true;
            }
        }

        return false;
    }


    /**
     * Returns due date
     * @param $rcv_date
     * @return string|void
     */
    public static function dueDate($rcv_date){

        if(!$rcv_date) return;

        $date = Carbon::parse($rcv_date);
        $day = $date->format('d');
        $month = $date->format('m');
        $year = $date->format('Y');
        $day_after_seven_days = $day + 7;

        if ($day_after_seven_days <= 15){
            return Carbon::parse($year.'-'.$month.'-15')->format('dMy h:m');
        }

        return Carbon::parse($year.'-'.$month.'-30')->format('dMy h:m');
    }
    
}