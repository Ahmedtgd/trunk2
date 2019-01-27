<?php

// Set timezone
use App\Models\Autolink;
use App\Models\GlobalT;
use Carbon\Carbon;

date_default_timezone_set("UTC");

// Time format is UNIX timestamp or
// PHP strtotime compatible strings
function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
        $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
        $time2 = strtotime($time2);
    }

    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
        $ttime = $time1;
        $time1 = $time2;
        $time2 = $ttime;
    }

    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();

    // Loop thru all intervals
    foreach ($intervals as $interval) {
        // Create temp time from time1 and interval
        $ttime = strtotime('+1 ' . $interval, $time1);
        // Set initial values
        $add = 1;
        $looped = 0;
        // Loop until temp time is smaller than time2
        while ($time2 >= $ttime) {
            // Create new temp time from time1 and interval
            $add++;
            $ttime = strtotime("+" . $add . " " . $interval, $time1);
            $looped++;
        }

        $time1 = strtotime("+" . $looped . " " . $interval, $time1);
        $diffs[$interval] = $looped;
    }

    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
        // Break if we have needed precission
        if ($count >= $precision) {
            break;
        }
        // Add value and interval
        // if value is bigger than 0
        if ($value > 0) {
            // Add s if value is not 1
            if ($value != 1) {
                $interval .= "s";
            }
            // Add value and interval to times array
            $times[] = $value . " " . $interval;
            $count++;
        }
    }

    // Return string with times
    return implode(", ", $times);
}

    //finding responder against initiator link_id
    function findResponder($id){

        $responders = Autolink::where('link_id',$id)->firstorFail();
        return $responders;

    }

/**
 * @param $initial
 *  date and time data
 * @param $final
 */
    function amountCount($record){

//

        $amountCount = 0;
        foreach($record as $product){
            $amountCount = $amountCount+$product->payment->receivable;
        }
        return $amountCount;

    }
    //this method will count amount monthly
    function amountCountMonthly($year, $orders)
    {

        $mon[1] = 0;
        $mon[2] = 0;
        $mon[3] = 0;
        $mon[4] = 0;
        $mon[5] = 0;
        $mon[6] = 0;
        $mon[7] = 0;
        $mon[8] = 0;
        $mon[9] = 0;
        $mon[10] = 0;
        $mon[11] = 0;
        $mon[12] = 0;

        foreach($orders as $order)
        {
            if($order->created_at->year == $year){
                $mon[$order->created_at->month] = $mon[$order->created_at->month] + $order->payment->receivable;
            }
        }

//        dd($mon);

        return $mon;
    }
    function amountCountYear($year,$orders)
    {

        $mon = 0;

        foreach($orders as $order)
        {
            if($order->created_at->year == $year){
                $mon +=  $order->payment->receivable;
            }
        }

    //        dd($mon);

        return $mon;
    }

/*
 * Get setting from global table
 * Param passed is the global
 * table column
 */
if(!function_exists('globalSettings')){
    function globalSettings($param){
        $global = GlobalT::select($param)->first();
        return $global->$param;
    }
}



 function splitStringGetEnd($delimeter,$str)
{
    $list=explode($delimeter,$str);
    return end($list);
}

function splitStringGetFirst($delimeter,$str)
{
    $list=  explode($delimeter,$str);
    return count($list) >0?$list[0]:"";
}

 function splitString($delimeter,$str)
{
    return explode($delimeter,$str);
}







